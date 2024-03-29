<?php

function getSurroundingTiles($target): array
{
    $targetCoords = explode(",", $target);
    $x = $targetCoords[0];
    $y = $targetCoords[1];

    $offsets = [[0, 1], [0, -1], [1, 0], [-1, 0], [-1, 1], [1, -1]];
    $surroundingCoords = [];

    foreach ($offsets as $offset) {
        $surroundingX = $x + $offset[0];
        $surroundingY = $y + $offset[1];
        $surroundingCoords[] = $surroundingX .",". $surroundingY;
    }

    return $surroundingCoords;
}

$board = [
    '1,4' => [[0, "G"]],
    '2,3' => [[1, "A"]],
    '4,3' => [[0, "B"]],
    '2,2' => [[1, "G"]],
    '3,2' => [[0, "A"]],
    '5,2' => [[1, "G"]],
    '1,1' => [[0, "B"]],
    '2,1' => [[1, "Q"]],
    '3,1' => [[0, "A"]],
    '4,1' => [[1, "B"]],
    '5,1' => [[0, "G"]],
    '2,0' => [[0, "Q"]],
    '3,0' => [[1, "B"]],
    '4,0' => [[0, "B"]],
    '2,-1' => [[1, "B"]],
    '3,-1' => [[0, "A"]],
    '2,-2' => [[1, "G"]]
];

$queenBeePlayer1 = null;
$queenBeePlayer2 = null;

foreach ($board as $tile => $item){
    if ($item[0][1] == "Q") {
        if ($item[0][0] == 0) {
            $queenBeePlayer1 = $tile;
        } else {
            $queenBeePlayer2 = $tile;
        }
    }
}

$countPlayer1 = 0;
$countPlayer2 = 0;

if ($queenBeePlayer2 != null) {
    $tiles = getSurroundingTiles($queenBeePlayer2);
    foreach ($tiles as $tile) {
        if ($board[$tile][0][0] == 0) {
            $countPlayer1++;
        }
    }
}

if ($queenBeePlayer1 != null) {
    $tiles = getSurroundingTiles($queenBeePlayer1);
    foreach ($tiles as $tile) {
        var_dump($board[$tile][0][0]);
        if ($board[$tile][0][0] == 1) {
            $countPlayer2++;
        }
    }
}

$result = null;
if ($countPlayer1 == 6 && $countPlayer2 < 6) {
    $result = 0;
} elseif ($countPlayer2 == 6 && $countPlayer1 < 6) {
    $result = 1;
} elseif ($countPlayer1 == 6 && $countPlayer2 == 6) {
    $result = 3;
}

var_dump($result);