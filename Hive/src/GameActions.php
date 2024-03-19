<?php

namespace HiveGame;

use Exception;
use HiveGame\GameRules;

class GameActions
{
    private Database $db;

    /**
     * @param Database $db
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function makePlay(string $piece, string $to): bool|string
    {
        $board = GameState::getBoard();

        $rules = new GameRules();
        $validity = $rules->validPlay($board, $to, $piece);

        if ($validity) {
            $board[$to] = [[GameState::getPlayer(), $piece]];


            $hand = GameState::getHand(GameState::getPlayer());
            $hand[$piece]--;
            if ($hand[$piece] < 1) unset($hand[$piece]);
            GameState::setHand(GameState::getPlayer(), $hand);

            $this->swapPlayer();

            GameState::setBoard($board);

            $this->db->storeMove(GameState::getGameId(), "play", $piece, $to, GameState::getLastMove(), GameState::getState());
            GameState::setLastMove($this->db->getDb()->insert_id);

        }

        return $validity;
    }

    public function makeMove(string $from, string $to): string|bool
    {
        $board = GameState::getBoard();

        $rules = new GameRules();
        $validity = $rules->validMove(GameState::getBoard(), $to, $from);

        if (!$validity) {
            return $validity;
        }

        if (!empty($board[$from])) {
            $tile = array_pop($board[$from]);

            if (isset($board[$to])) {
                array_push($board[$to], $tile);
            } else {
                $board[$to] = [$tile];
            }

            $this->swapPlayer();

            $this->db->storeMove(GameState::getGameId(), "move", $from, $to, GameState::getLastMove(), GameState::getState());
            GameState::setLastMove($this->db->getDb()->insert_id);
        }

        GameState::setBoard($board);

        return $validity;
    }


    /**
     * @throws Exception
     */
    public function undoMove(): void
    {
        if (GameState::getLastMove() == 0) {
            throw new Exception("No previous move");
        }

        $lastMove = $this->db->getMoves(GameState::getLastMove());

        if (isset($lastMove["state"])) {
            GameState::setLastMove($lastMove["previous_id"]);
            GameState::setState($lastMove["state"]);
        }

    }


    private function swapPlayer(): void
    {
        if (GameState::getPlayer() == 0) {
            GameState::setPlayer(1);
        } else {
            GameState::setPlayer(0);
        }
    }
}