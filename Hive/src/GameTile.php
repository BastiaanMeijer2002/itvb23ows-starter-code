<?php

namespace HiveGame;

class GameTile
{
    public static function getType($position, $board): string|bool
    {
        $tile = $board[$position];

        if (isset($tile[0][1])) {return $tile[0][1];}

        return false;
    }
}