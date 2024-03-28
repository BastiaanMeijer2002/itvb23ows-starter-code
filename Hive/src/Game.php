<?php

namespace HiveGame;

use HiveGame\GameState;
use HiveGame\GameUtils;

class Game
{
    private Database $db;
    private GameActions $gameActions;

    /**
     * @param Database $db
     * @param GameActions $gameActions
     */
    public function __construct(Database $db, GameActions $gameActions)
    {
        $this->db = $db;
        $this->gameActions = $gameActions;
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

    public function continueGame($move): bool
    {
        if (empty($move)) {return false;}

        $this->db->getGame($move["game"]);

        switch ($move["action"]) {
            case "Play":
                $this->gameActions->makePlay($move["piece"], $move["to"]);
                $state = GameUtils::checkWin(GameState::getBoard());
                echo 'printstate';
                var_dump($state);
                if ($state != null) {
                    echo 'printstate1';
                    $this->handleWin($state);
                }
                break;
            case "Move":
                $this->gameActions->makeMove($move["from"], $move["to"]);
                $state = GameUtils::checkWin(GameState::getBoard());
                if ($state) {$this->handleWin($state);}
                break;
            case "Undo":
                echo "undo";
                break;
            case "Pass":
                GameActions::swapPlayer();
                break;
            default:
                $this->restartGame();
                return false;

        }

        GameView::render();
        return true;
    }

    public function restartGame(): void
    {
        session_unset();
        $this->startGame();
    }

    public function handleWin($player): void
    {
        session_unset();
        GameState::setError("Player ".$player." won!!!!");
        $this->startGame();
    }

}
