<?php


use HiveGame\GameRules;
use PHPUnit\Framework\TestCase;

class GameRulesTest extends TestCase
{
    public function testWouldSplitHiveInvalidMove() {
        $board = ["0,0" => [], "0,1" => [], "-1,0" =>[], "-2,1" => [], "-3,2" => []];
        $from = "-2,1";

        $result = GameRules::wouldSplitHive($board, $from);

        $this->assertTrue($result);
    }

    public function testWouldSplitHiveValidMove() {
        $board = ["0,0" => [], "0,1" => [], "-1,0" =>[]];
        $from = "-1,0";

        $result = GameRules::wouldSplitHive($board, $from);

        $this->assertFalse($result);
    }
}
