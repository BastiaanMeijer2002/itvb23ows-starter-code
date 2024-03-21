<?php


use HiveGame\GameState;
use HiveGame\GameUtils;
use PHPUnit\Framework\TestCase;

class GameUtilsTest extends TestCase
{
    public function testPossiblePlaysFirstRound() {
        $board = [];
        $expectedPossiblePlays = ["0,0"];

        $actualPossiblePlays = GameUtils::getPossiblePlays($board);

        $this->assertEquals($expectedPossiblePlays, $actualPossiblePlays);
    }

    public function testPossiblePlaysSecondRound() {
        $board = ["0,0" => []];
        $expectedPossiblePlays = ['0,1', '1,0', '-1,0', '0,-1', '1,-1', '-1,1'];

        $actualPossiblePlays = GameUtils::getPossiblePlays($board);

        $this->assertEquals($expectedPossiblePlays, $actualPossiblePlays);
    }

    public function testPossiblePlays() {
        $board = ["0,0" => [], "0,1" => []];
        $expectedPossiblePlays = ["0,-1", "1,0", "-1,0", "-1,1", "1,-1", "0,2", "1,1", "-1,2"];

        $actualPossiblePlays = GameUtils::getPossiblePlays($board);

        $this->assertEqualsCanonicalizing($expectedPossiblePlays, $actualPossiblePlays);
    }

    public function testPlayerTiles() {
        $board = ["0,0" => [[0, "Q"]], "0,1" => [[1, "Q"]],"0,2" => [[0, "S"]]];
        $player = 0;
        GameState::setPlayer($player);
        $expectedTiles = ["0,0", "0,2"];

        $actualTiles = GameUtils::getPlayerTiles($board);

        $this->assertEquals($expectedTiles, $actualTiles);
    }
}
