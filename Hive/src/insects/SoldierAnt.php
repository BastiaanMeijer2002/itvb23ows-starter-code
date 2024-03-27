<?php

namespace HiveGame\insects;

class SoldierAnt implements Insect
{
    public static function validMove($board, $from, $to): bool
    {
        $validity = false;

        if ($from != $to) {
            if (!isset($board[$to])) {
                $validity = true;
            }
        }

        return $validity;
    }

}
