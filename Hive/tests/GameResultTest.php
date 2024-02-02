<?php


use HiveGame\GameRules;
use HiveGame\GameState;
use PHPUnit\Framework\TestCase;

class GameResultTest extends TestCase
{

    public function testPlayerWins()
    {
        $gameRules = new GameRules();
        $gameState = new GameState();

        $player1Hand = [
            'Q' => 0,
            'B' => 0,
            'S' => 0,
            'A' => 0,
            'G' => 0,
        ];

        $player2Hand = [
            'Q' => 0,
            'B' => 0,
            'S' => 0,
            'A' => 0,
            'G' => 0,
        ];

        $gameBoard = [
            '0,0' => [['player' => $gameState->getPlayer1(), 'piece' => 'Q']],
            '0,1' => [['player' => $gameState->getPlayer2(), 'piece' => 'B']],
            '1,0' => [['player' => $gameState->getPlayer2(), 'piece' => 'B']],
            '1,1' => [['player' => $gameState->getPlayer1(), 'piece' => 'S']],
            '0,-1' => [['player' => $gameState->getPlayer1(), 'piece' => 'S']],
            '-1,0' => [['player' => $gameState->getPlayer1(), 'piece' => 'S']],
            '-1,-1' => [['player' => $gameState->getPlayer1(), 'piece' => 'S']],
        ];

        $gameState->getPlayer1()->setHand($player1Hand);
        $gameState->getPlayer2()->setHand($player2Hand);
        $gameState->setBoard($gameBoard);

        $result = $gameRules->checkWin($gameState);

        $this->assertEquals($gameState->getPlayer2(), $result);
    }

    public function testTie() {
        $gameRules = new GameRules();
        $gameState = new GameState();

        $player1Hand = [
            'Q' => 0,
            'B' => 0,
            'S' => 0,
            'A' => 0,
            'G' => 0,
        ];

        $player2Hand = [
            'Q' => 0,
            'B' => 0,
            'S' => 0,
            'A' => 0,
            'G' => 0,
        ];

        $gameBoard = [
            '0,0' => [['player' => $gameState->getPlayer1(), 'piece' => 'Q']],
            '0,1' => [['player' => $gameState->getPlayer2(), 'piece' => 'B']],
            '1,0' => [['player' => $gameState->getPlayer2(), 'piece' => 'B']],
            '1,1' => [['player' => $gameState->getPlayer1(), 'piece' => 'S']],
            '0,-1' => [['player' => $gameState->getPlayer1(), 'piece' => 'S']],
            '-1,0' => [['player' => $gameState->getPlayer1(), 'piece' => 'S']],
            '-1,-1' => [['player' => $gameState->getPlayer1(), 'piece' => 'S']],
            '1,-1' => [['player' => $gameState->getPlayer1(), 'piece' => 'S']],
            '2,0' => [['player' => $gameState->getPlayer1(), 'piece' => 'S']],
            '2,-1' => [['player' => $gameState->getPlayer2(), 'piece' => 'Q']],
            '3,-1' => [['player' => $gameState->getPlayer2(), 'piece' => 'S']],
            '3,0' => [['player' => $gameState->getPlayer2(), 'piece' => 'S']],
            '2,-2' => [['player' => $gameState->getPlayer2(), 'piece' => 'S']],
            '1,-2' => [['player' => $gameState->getPlayer2(), 'piece' => 'S']],

        ];

        $gameState->getPlayer1()->setHand($player1Hand);
        $gameState->getPlayer2()->setHand($player2Hand);
        $gameState->setBoard($gameBoard);

        $result = $gameRules->checkTie($gameState);

        $this->assertTrue($result);

    }
}
