<?php


use HiveGame\Database;
use HiveGame\GameActions;
use HiveGame\GameRules;
use HiveGame\GameState;
use HiveGame\Player;
use PHPUnit\Framework\TestCase;

class GameActionsTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testNoUndoOnFirstMove() {
        $db = $this->getMockBuilder(Database::class)
            ->disableOriginalConstructor()
            ->getMock();

        $gameState = $this->getMockBuilder(GameState::class)
            ->getMock();

        $gameActions = new GameActions($db, $gameState);


        $gameState->expects($this->once())
            ->method('getLastMove')
            ->willReturn(0);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('No previous move');

        $gameActions->undoMove();

    }

    /**
     * @throws Exception
     */
    public function testUndoLastMove() {
        $db = $this->getMockBuilder(Database::class)
            ->disableOriginalConstructor()
            ->getMock();

        $gameState = $this->getMockBuilder(GameState::class)
            ->getMock();

        $gameActions = new GameActions($db, $gameState);


        $gameState->expects($this->once())
            ->method('getLastMove')
            ->willReturn(123);

        $expectedMoveData = [
            "previous_id" => 456,
        ];
        $db->expects($this->once())
            ->method('getMoves')
            ->with(123)
            ->willReturn($expectedMoveData);

        $gameState->expects($this->once())
            ->method('setLastMove')
            ->with(456);


        $gameActions->undoMove();

    }

    public function testPass() {
        $gameRules = new GameRules();
        $gameState = new GameState();

        $hand = [
            'Q' => 0,
            'B' => 0,
            'S' => 0,
            'A' => 0,
            'G' => 0,
        ];

        $board = [
            '0,0' => [['player' => new Player(0), 'piece' => 'Q']],
        ];

        $gameState->getPlayer1()->setHand($hand);
        $gameState->setBoard($board);

        $canMoveOrPlay = $gameRules->hasValidMove($gameState->getBoard(), $gameState->getPlayer1());

        $this->assertFalse($canMoveOrPlay);
    }
}
