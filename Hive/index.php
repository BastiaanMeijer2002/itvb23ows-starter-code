<?php

require_once __DIR__ . '/vendor/autoload.php';

use HiveGame\Database;
use HiveGame\Game;
use HiveGame\GameActions;

session_start();

$db = new Database();
$gameActions = new GameActions($db);

$game = new Game($db, $gameActions);
if (isset($_POST["game"])) {
    if ($_POST["game"] == "new") {
        $game->restartGame();
    } else {
        $game->continueGame($_POST);
    }
} else {
    $game->startGame();
}



