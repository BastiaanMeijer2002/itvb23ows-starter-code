<?php

require_once __DIR__ . '/vendor/autoload.php';

use HiveGame\Database;
use HiveGame\Game;

$db = new Database();

$game = new Game($db);
if (isset($_POST["game"])) {
    if ($_POST["game"] == "new") {
        $game->startGame();
    } else {
        $game->continueGame($_POST);
    }
} else {
    $game->startGame();
}



