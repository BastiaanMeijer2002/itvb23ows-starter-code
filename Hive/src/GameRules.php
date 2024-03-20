<?php

namespace HiveGame;

use HiveGame\Player;
use HiveGame\Utils;

class GameRules
{
    public function validPlay(array $board, string $to, string $piece): bool|string
    {
        $utils = new Utils();

        $hand = GameState::getPlayer() == 0 ? GameState::getPlayer1hand() : GameState::getPlayer2hand();


        if (!$hand[$piece]) return "Player does not have tile";

        elseif (isset($board[$to])) return 'Board position is not empty';

        elseif (count($board) && !$utils->hasNeighBour($to, $board)) return "board position has no neighbour";

        elseif (array_sum($hand) < 11 && !$utils->neighboursAreSameColor(GameState::getPlayer(), $to, $board)) return "Board position has opposing neighbour";

        elseif (array_sum($hand) <= 8 && $hand['Q']) return 'Must play queen bee';

        return true;
    }

    public function validMove(array $board, string $to, string $from): bool|string
    {
        if (!$this->isBoardPositionOccupied($board, $from)) {
            return 'Board position is empty';
        }

        if (!$this->isTileOwnedByPlayer($board, $from)) {
            return "Tile is not owned by player";
        }

        if ($this->isQueenBeeNotPlayed()) {
            return "Queen bee is not played";
        }

        if (!$this->hasNeighboringTiles($to, $board)) {
            return "Move would split hive";
        }

        if ($this->isHiveSplit($board)) {
            return "Move would split hive";
        }

        if ($this->isInvalidMove($board, $to, $from)) {
            return $_SESSION['error'];
        }

        return true;
    }

    private function isBoardPositionOccupied(array $board, string $position): bool
    {
        return isset($board[$position]);
    }

    private function isTileOwnedByPlayer(array $board, string $position): bool
    {
        return $board[$position][count($board[$position])-1][0] === GameState::getPlayer();
    }

    private function isQueenBeeNotPlayed(): bool
    {
        $hand = GameState::getPlayer() == 0 ? GameState::getPlayer1hand() : GameState::getPlayer2hand();
        return $hand['Q'];
    }

    private function hasNeighboringTiles(string $position, array $board): bool
    {
        $utils = new Utils();
        return $utils->hasNeighBour($position, $board);
    }

    private function isHiveSplit(array $board): bool
    {
        $utils = new Utils();
        return $utils->isHiveSplit($board);
    }

    private function isInvalidMove(array $board, string $to, string $from): bool
    {
        $utils = new Utils();
        $tile = array_pop($board[$from]);

        if ($from === "0,0" && $to === "0,1" && $tile[1] === "Q" && GameState::getPlayer() == 0) {
            return false;
        }

        if ($to === $from || (isset($board[$to]) && $tile[1] != "B")) {
            $_SESSION['error'] = ($to === $from) ? 'Tile must move' : 'Tile not empty';
            return true;
        }

        if ($tile[1] == "Q" || $tile[1] == "B") {
            if (!$utils->slide($board, $from, $to)) {
                $_SESSION['error'] = 'Tile must slide';
                return true;
            }
        }

        return false;
    }


    public function validSoldierAntMove(array $board, string $from, string $to): bool
    {
        return false;
    }

    public function validGrasshopperMove(array $board, string $from, string $to): bool
    {
        return false;
    }

    public function validSpiderMove(array $board, string $from, string $to): bool
    {
        return false;
    }

    public function hasValidMove(array $board, Player $player): bool
    {
        return false;
    }

    public function checkWin(GameState $gameState): int
    {
        return GameState::getPlayer();
    }

    public function checkTie(GameState $gameState): bool
    {
        return false;
    }
}