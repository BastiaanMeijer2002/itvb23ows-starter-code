<?php

namespace HiveGame;

use HiveGame\GameUtils;
use HiveGame\insects\Grasshopper;

class GameRules
{
    public static function validPlay(array $board, string $to, string $piece): bool|string
    {
        $utils = new GameUtils();
        $hand = GameState::getHand(GameState::getPlayer());

        $validity = true;

        if (!$hand[$piece]) {
            $errorMessage = "Player does not have tile";
            GameState::setError($errorMessage);
            $validity = false;
        } elseif (isset($board[$to])) {
            $errorMessage = 'Board position is not empty';
            GameState::setError($errorMessage);
            $validity = false;
        } elseif (count($board) && !$utils->hasNeighBour($to, $board)) {
            $errorMessage = "board position has no neighbour";
            GameState::setError($errorMessage);
            $validity = false;
        } elseif (array_sum($hand) < 11 &&
            !$utils->neighboursAreSameColor(GameState::getPlayer(), $to, $board)) {
            $errorMessage = "Board position has opposing neighbour";
            GameState::setError($errorMessage);
            $validity = false;
        } elseif (array_sum($hand) <= 8 && isset($hand['Q'])) {
            $errorMessage = 'Must play queen bee';
            GameState::setError($errorMessage);
            $validity = false;
        }

        return $validity;
    }

    public static function validMove(array $board, string $to, string $from): bool|string
    {
        $validity = true;
        echo $to;

        if (self::wouldSplitHive($board, $from)) {$validity = false;}

        $playerTiles = GameUtils::getPlayerTiles($board);
        if (!isset($playerTiles[$from])) {$validity = false;}

        if ($from == "0,0" && $board[$from][0][0] == 0 && $board[$from][0][1] == "Q"
            && $to == "0,1" && $board["1,0"][0][0] == 1 && $board["1,0"][0][1] == "Q") {
            $validity = true;
        }

        switch ($from[0][1]) {
            case "G":
                $validity = Grasshopper::validMove($board, $from, $to);
                break;
            case "A":
                echo "A";
                break;
            case "S":
                echo "S";
                break;
            default:
                $validity = true;
        }
        return $validity;
    }

    public static function wouldSplitHive($board, $from): bool
    {
        $boardCopy = $board;
        unset($boardCopy[$from]);
        foreach ($boardCopy as $tile => $item) {
            if (!GameUtils::hasNeighbour($tile, $boardCopy)) {
                GameState::setError("Hive would split");
                return true;
            }
        }
        return false;
    }

}
