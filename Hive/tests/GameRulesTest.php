<?php


use HiveGame\GameRules;
use HiveGame\GameState;
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

    public function testValidMoveWhiteQueen() {
        $board = ["0,0" => [[0, "Q"]], "1,0" => [[1, "Q"]]];
        $from = "0,0";
        $to = "0,1";

        $result = GameRules::validMove($board, $to, $from);

        $this->assertTrue($result);

    }

    public function testQueenBeePlayed() {
        $board = [
            "0,0" => [0, "B"],
            "0,1" => [1, "B"],
            "0,2" => [1, "B"],
            "1,0" => [0, "A"],
            "0,-1" => [0, "A"],
            "-1, 1" => [1, "Q"]
        ];
        $piece = "S";
        $to = "0,-2";
        GameState::setPlayer(0);

        $result = GameRules::validPlay($board, $to, $piece);

        var_dump($result);

        $this->assertFalse($result);
    }

    public function testPlayerDoesNotHavePiece() {
        GameState::setPlayer(0);
        GameState::setPlayer1hand([]);
        $piece = "Q";

        $result = GameRules::validPlay([], "", $piece);

        $this->assertFalse($result);
    }

    public function testPositionIsNotEmpty() {
        $board = [
            "0,0" => []
        ];
        $to = "0,0";

        $result = GameRules::validPlay($board, $to, "");

        $this->assertFalse($result);
    }

    public function testHasNoNeighbour() {
        $board = [
            "0,0" => []
        ];
        $to = "3,3";

        $result = GameRules::validPlay($board, $to, "");

        $this->assertFalse($result);
    }
}
