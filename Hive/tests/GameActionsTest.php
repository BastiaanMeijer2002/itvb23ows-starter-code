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

    public function testSwapPlayer() {
        GameState::setPlayer(0);

        GameActions::swapPlayer();

        $this->assertEquals(1, GameState::getPlayer());
    }

    public function testSetEmptyState() {
        $expectedHand = ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3];
        $expectedBoard = [];
        $expectedPlayer = 0;

        GameActions::setEmptyState();

        $this->assertEquals($expectedHand, GameState::getPlayer1hand());
        $this->assertEquals($expectedHand, GameState::getPlayer2hand());
        $this->assertEquals($expectedBoard, GameState::getBoard());
        $this->assertEquals($expectedPlayer, GameState::getPlayer());
    }

    public function testUndoMoveEmptyBoard() {
        $dbMock = $this->getMockBuilder(Database::class)
            ->disableOriginalConstructor()
            ->getMock();

        $dbMock->expects($this->once())
            ->method("getPreviousState")
            ->willReturn(null);

        GameState::setGameId(1);

        $gameActions = new GameActions($dbMock);

        $gameActions->undoMove();

        $this->assertEmpty(GameState::getBoard());
    }

    public function testUndoMoveNotEmptyBoard() {
        $dbMock = $this->getMockBuilder(Database::class)
            ->disableOriginalConstructor()
            ->getMock();

        $dbMock->expects($this->once())
            ->method("getPreviousState")
            ->willReturn('a:4:{s:5:"hand1";a:4:{s:1:"B";i:2;s:1:"S";i:2;s:1:"A";i:3;s:1:"G";i:3;}s:5:"hand2";a:5:{s:1:"Q";i:1;s:1:"B";i:2;s:1:"S";i:2;s:1:"A";i:3;s:1:"G";i:3;}s:5:"board";a:1:{s:3:"0,0";a:1:{i:0;a:2:{i:0;i:0;i:1;s:1:"Q";}}}s:6:"player";i:1;}');

        GameState::setGameId(1);

        $expectedBoard = [
            "0,0" => [[0, "Q"]]
        ];

        $gameActions = new GameActions($dbMock);

        $gameActions->undoMove();

        $this->assertEquals($expectedBoard, GameState::getBoard());
    }


}

