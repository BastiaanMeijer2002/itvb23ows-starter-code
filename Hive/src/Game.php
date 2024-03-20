<?php

namespace HiveGame;

use HiveGame\GameState;
use HiveGame\Utils;

class Game
{
    private Database $db;

    /**
     * @param Database $db
     */
    public function __construct(Database $db)
    {
        $GLOBALS['OFFSETS'] = [[0, 1], [0, -1], [1, 0], [-1, 0], [-1, 1], [1, -1]];
        $this->db = $db;
    }


    public function startGame(): void
    {
        GameState::setGameId($this->db->createGame());
        GameState::setPlayer1hand(["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3]);
        GameState::setPlayer2hand(["Q" => 1, "B" => 2, "S" => 2, "A" => 3, "G" => 3]);
        GameState::setBoard([]);
        GameState::setPlayer(0);

        GameView::render();
    }

    public function continueGame($move): void
    {

        $this->db->getGame($move["game"]);
        $gameActions = new GameActions($this->db);

        switch ($move["action"]) {
            case "Play":
                $gameActions->makePlay($move["piece"], $move["to"]);
                break;
            case "Move":
                $gameActions->makeMove($move["from"], $move["to"]);
                break;
            case "Undo":
                echo "undo";
                break;
            case "Pass":
                echo "pass";
                break;
            default:
                $this->restartGame();

        }

        GameView::render();
    }

    public function restartGame(): void {
        session_unset();
        $this->startGame();
    }
}
