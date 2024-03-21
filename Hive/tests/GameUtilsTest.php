<?php


use HiveGame\GameUtils;
use PHPUnit\Framework\TestCase;

class GameUtilsTest extends TestCase
{
    public function testPossiblePlaysFirstRound() {
        $board = [];
        $expectedPossiblePlays = ["0,0"];

        $actualPossiblePlays = GameView::getPossiblePlays($board);

        $this->assertEquals($expectedPossiblePlays, $actualPossiblePlays);
    }

    public function testPossiblePlaysSecondRound() {
        $board = ["0,0" => []];
        $expectedPossiblePlays = ['0,1', '1,0', '-1,0', '0,-1', '1,-1', '-1,1'];

        $actualPossiblePlays = GameView::getPossiblePlays($board);

        $this->assertEquals($expectedPossiblePlays, $actualPossiblePlays);
    }

    public function testPossiblePlays() {
        $board = ["0,0" => [], "0,1" => []];
        $expectedPossiblePlays = ["0,-1", "1,0", "-1,0", "-1,1", "1,-1", "0,2", "1,1", "-1,2"];

        $actualPossiblePlays = GameView::getPossiblePlays($board);

        $this->assertEqualsCanonicalizing($expectedPossiblePlays, $actualPossiblePlays);
    }
}
