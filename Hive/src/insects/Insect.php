<?php

namespace HiveGame\insects;

interface Insect {
    public static function validMove($from, $to): bool;
}