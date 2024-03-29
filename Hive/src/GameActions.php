<?php

namespace HiveGame;

use Exception;
use HiveGame\GameRules;

/**
 * Manages the actions of the game
 */
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

        $validity = GameRules::validPlay($board, $to, $piece);

        if (!$validity) {
            return false;
        }

        GameState::clearError();

        $board[$to] = [[GameState::getPlayer(), $piece]];

        $this->updateHand($piece);
        $this->swapPlayer();

        GameState::setBoard($board);

        $this->db->storeMove(GameState::getGameId(), "play", $piece, $to,
            GameState::getLastMove(), GameState::getState());
        GameState::setLastMove($this->db->getDb()->insert_id);

        return true;
    }

    public function makeMove(string $from, string $to): string|bool
    {
        $board = GameState::getBoard();

        $validity = GameRules::validMove(GameState::getBoard(), $to, $from);

        if (!$validity) {
            return $validity;
        }

        GameState::clearError();

        $tile = array_pop($board[$from]);

        $board[$to] = [$tile];

        $this->swapPlayer();

        GameState::setBoard($board);

        $this->db->storeMove(GameState::getGameId(), "move", $from, $to,
            GameState::getLastMove(), GameState::getState());
        GameState::setLastMove($this->db->getDb()->insert_id);


        return $validity;
    }

    public static function swapPlayer(): void
    {
        if (GameState::getPlayer() == 0) {
            GameState::setPlayer(1);
        } else {
            GameState::setPlayer(0);
        }
    }

    public static function updateHand($piece): void
    {
        $hand = GameState::getHand(GameState::getPlayer());
        $hand[$piece]--;
        if ($hand[$piece] < 1) {unset($hand[$piece]);}
        GameState::setHand(GameState::getPlayer(), $hand);
    }
}
