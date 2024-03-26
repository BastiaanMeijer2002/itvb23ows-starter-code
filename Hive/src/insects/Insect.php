<?php

namespace HiveGame\insects;

interface Insect {
    public static function validMove($board, $from, $to): bool;
}