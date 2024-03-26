<?php

namespace HiveGame\insects;

class Grasshopper implements Insect
{
    public static function validMove($board, $from, $to): bool
    {
        $validity = false;
        $fromCoords = explode(",", $from);
        $toCoords = explode(",", $to);

        $fromX = $fromCoords[0];
        $fromY = $fromCoords[1];

        $toX = $toCoords[0];
        $toY = $toCoords[1];

        if ($from != $to && ($fromX == $toX || $fromY == $toY) && (abs($toX - $fromX) > 1
                || abs($toY - $fromY) > 1)) {
            $validity = self::checkPositionsOccupied($board, $fromX, $fromY, $toY);
        }

        return $validity;
    }


    private static function checkPositionsOccupied($board, $fromX, $fromY, $toY): bool
    {
        for ($i = $fromY; $i < $toY; $i++) {
            $coords = $fromX . "," . $i;
            if (isset($board[$coords])) {
                return true;
            }
        }
        return false;
    }
}
