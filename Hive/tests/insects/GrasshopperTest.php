<?php

namespace insects;

use HiveGame\insects\Grasshopper;
use PHPUnit\Framework\TestCase;

class GrasshopperTest extends TestCase
{
    public function testStraightLineValid() {
        $board = [
            "0,0" => [],
            "0,1" => []
        ];
        $from = "0,0";
        $to = "0,2";

        $result = Grasshopper::validMove($board,$from, $to);

        $this->assertTrue($result);
    }

    public function testStraightLineInvalid() {
        $from = "0,0";
        $to = "1,2";

        $result = Grasshopper::validMove([],$from, $to);

        $this->assertFalse($result);
    }

    public function testIsNotSamePosition() {
        $from = "0,0";
        $to = "0,0";

        $result = Grasshopper::validMove([],$from, $to);

        $this->assertFalse($result);
    }

    public function testMinOneTileValid(){
        $board = [
            "0,0" => [],
            "0,1" => []
        ];
        $from = "0,0";
        $to = "0,2";

        $result = Grasshopper::validMove($board,$from, $to);

        $this->assertTrue($result);
    }

    public function testMinOneTileInvalid(){
        $from = "0,0";
        $to = "0,1";

        $result = Grasshopper::validMove([],$from, $to);

        $this->assertFalse($result);
    }

    public function testEmptyFieldsValid(){
        $board = [
            "0,0" => [],
            "0,1" => [],
        ];
        $from = "0,0";
        $to = "0,2";

        $result = Grasshopper::validMove($board, $from, $to);

        $this->assertTrue($result);
    }
}
