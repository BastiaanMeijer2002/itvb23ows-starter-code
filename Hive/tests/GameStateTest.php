<?php


use HiveGame\GameState;
use PHPUnit\Framework\TestCase;

class GameStateTest extends TestCase
{
    public function testGetState() {
        GameState::setPlayer1hand(["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3]);
        GameState::setPlayer2hand(["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3]);
        GameState::setBoard([]);
        GameState::setPlayer(0);

        $expectedState = serialize([
            "hand1" => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3],
            "hand2" => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3],
            "board" => [],
            "player" => 0,
        ]);

        $this->assertEquals($expectedState, GameState::getState());
    }

    public function testSetState() {
        $testState = [
            "hand1" => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3],
            "hand2" => ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3],
            "board" => [],
            "player" => 0,
        ];

        $serializedState = serialize($testState);

        GameState::setState($serializedState);

        $this->assertEquals($testState["hand1"], GameState::getPlayer1hand());
        $this->assertEquals($testState["hand2"], GameState::getPlayer2hand());
        $this->assertEquals([], GameState::getBoard());
        $this->assertEquals(0, GameState::getPlayer());

    }
}
