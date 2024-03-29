<?php

namespace insects;

use HiveGame\insects\SoldierAnt;
use PHPUnit\Framework\TestCase;

class SoldierAntTest extends TestCase
{
    public function testDestinationIsEmptyValid() {
        $board = [
          "0,0" => []
        ];
        $from = "0,0";
        $to = "0,1";

        $result = SoldierAnt::validMove($board, $from, $to);

        $this->assertTrue($result);
    }

    public function testDestinationIsEmptyInvalid() {
        $board = [
            "0,0" => [],
            "0,1" => [],
        ];
        $from = "0,0";
        $to = "0,1";

        $result = SoldierAnt::validMove($board, $from, $to);

        $this->assertFalse($result);
    }

    public function testIsNotSamePosition() {
        $from = "0,0";
        $to = "0,0";

        $result = SoldierAnt::validMove([],$from, $to);

        $this->assertFalse($result);
    }
}
