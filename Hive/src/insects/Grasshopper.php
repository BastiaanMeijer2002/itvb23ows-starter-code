<?php

namespace HiveGame\insects;

class Grasshopper implements Insect
{
    public static function validMove($from, $to): bool
    {
        $validity = false;
        $fromCoords = explode(",", $from);
        $toCoords = explode(",", $to);

        $fromX = $fromCoords[0];
        $fromY = $fromCoords[1];

        $toX = $toCoords[0];
        $toY = $toCoords[1];

        if ($fromX == $toX || $fromY == $toY) {$validity = true;}


        return $validity;

    }
}