<?php


use HiveGame\Database;
use HiveGame\GameActions;
use HiveGame\GameState;
use PHPUnit\Framework\TestCase;

class GameActionsTest extends TestCase
{
    public function testHand() {
        $testHand = ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3];
        $testPiece = "Q";
        GameState::setPlayer(0);
        GameState::setHand(GameState::getPlayer(), $testHand);

        GameActions::updateHand($testPiece);

        $this->assertArrayNotHasKey($testPiece, GameState::getHand(GameState::getPlayer()));
    }
}

