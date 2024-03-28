<?php


use HiveGame\Database;
use HiveGame\Game;
use HiveGame\GameActions;
use HiveGame\GameState;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    private Database $database;
    private Game $game;
    private GameActions $gameActions;

    protected function setUp(): void
    {
        $this->database = $this->getMockBuilder(Database::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->gameActions = $this->getMockBuilder(GameActions::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->game = new Game($this->database, $this->gameActions);

    }

    public function testStartGame() {

        $this->database->expects($this->once())
            ->method("createGame")
            ->willReturn("1");

        $expectedId = 1;
        $expectedHand = ["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3];
        $expectedPlayer = 0;
        $expectedBoard = [];

        $this->game->startGame();

        $this->assertEquals($expectedId, GameState::getGameId());
        $this->assertEquals($expectedHand, GameState::getPlayer1hand());
        $this->assertEquals($expectedHand, GameState::getPlayer2hand());
        $this->assertEquals($expectedPlayer, GameState::getPlayer());
        $this->assertEquals($expectedBoard, GameState::getBoard());

    }

    public function testContinueGamePlayValidMove() {
        $move = [
            "game" => 1,
            "piece" => "Q",
            "to" => "0,0",
            "action" => "Play"
        ];

        $this->gameActions->expects($this->once())
            ->method("makePlay")
            ->with($move["piece"], $move["to"])
            ->willReturn(true);

        $play = $this->game->continueGame($move);

        $this->assertTrue($play);
    }

    public function testContinueGamePlayInvalidMove() {
        $move = [];

        $play = $this->game->continueGame($move);

        $this->assertFalse($play);
    }

    public function testContinueGameMoveValidMove() {
        $move = [
            "game" => 1,
            "piece" => "Q",
            "from" => "0,0",
            "to" => "0,1",
            "action" => "Move"
        ];

        $this->gameActions->expects($this->once())
            ->method("makeMove")
            ->with("0,0", "0,1")
            ->willReturn(true);

        $play = $this->game->continueGame($move);

        $this->assertTrue($play);
    }

    public function testContinueGameMoveInvalidMove() {
        $move = [];

        $play = $this->game->continueGame($move);

        $this->assertFalse($play);
    }

    public function testContinueGamePassValid() {
        $move = [
            "action" => "Pass",
            "game" => 1
        ];
        GameState::setPlayer(0);

        $play = $this->game->continueGame($move);

        $this->assertTrue($play);
        $this->assertEquals(1, GameState::getPlayer());
    }

    public function testContinueGamePassInvalid() {
        $move = [];
        GameState::setPlayer(0);

        $play = $this->game->continueGame($move);

        $this->assertFalse($play);
        $this->assertEquals(0, GameState::getPlayer());
    }

    public function testContinueGamePlayWinsGame() {
        $move = [
            "game" => 1,
            "piece" => "Q",
            "to" => "0,0",
            "action" => "Play"
        ];

        $this->gameActions->expects($this->once())
            ->method("makePlay")
            ->with($move["piece"], $move["to"])
            ->willReturn(true);

        GameState::setBoard([
            '0,0' => [[1, "Q"]],
            '0,1' => [[0, "B"]],
            '0,-1' => [[0, "B"]],
            '1,0' => [[0, "B"]],
            '-1,0' => [[0, "B"]],
            '-1,1' => [[0, "B"]],
            '1,-1' => [[0, "B"]]
        ]);

        $gameMock = $this->getMockBuilder(Game::class)
            ->setConstructorArgs([$this->database, $this->gameActions])
            ->onlyMethods(['handleWin']) // Specify the method to mock
            ->getMock();

        $gameMock->expects($this->once())
            ->method("handleWin");

        $gameMock->continueGame($move);
    }

    public function testContinueGamePlayDoesntWisGame() {
        $move = [
            "game" => 1,
            "piece" => "Q",
            "to" => "0,0",
            "action" => "Play"
        ];

        $this->gameActions->expects($this->once())
            ->method("makePlay")
            ->with($move["piece"], $move["to"])
            ->willReturn(true);

        GameState::setBoard([
            '0,0' => [[1, "Q"]],
            '0,1' => [[0, "B"]],
            '0,-1' => [[0, "B"]],
            '1,0' => [[1, "B"]],
            '-1,0' => [[0, "B"]],
            '-1,1' => [[0, "B"]],
            '1,-1' => [[0, "B"]]
        ]);

        $gameMock = $this->getMockBuilder(Game::class)
            ->setConstructorArgs([$this->database, $this->gameActions])
            ->onlyMethods(['handleWin'])
            ->getMock();

        $gameMock->expects($this->once())
            ->method("handleWin");

        $gameMock->continueGame($move);
    }


}
