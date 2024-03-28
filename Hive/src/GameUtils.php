<?php

namespace HiveGame;

class GameUtils
{
    public static function checkWin($board): ?int
    {
        $countPlayer1 = 0;
        $countPlayer2 = 0;

        foreach ($board as $tile) {
            if ($tile[0][0] == 0) {
                $countPlayer1++;
            } else {
                $countPlayer2++;
            }
        }

        if ($countPlayer1 == 6) {
            return 0;
        } elseif ($countPlayer2 == 6) {
            return 1;
        } else {
            return null;
        }

    }

    public static function getSurroundingTiles($target): array
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


    public static function isNeighbour($a, $b): bool
    {
        $a = explode(',', $a);
        $b = explode(',', $b);

        if (count($a) != 2 || count($b) != 2) {
            return false;
        }

        if (($a[0] == $b[0] && abs($a[1] - $b[1]) == 1) ||
            ($a[1] == $b[1] && abs($a[0] - $b[0]) == 1) ||
            ($a[0] . $a[1] == $b[0] . $b[1])) {
            return true;
        }

        return false;
    }


    public static function hasNeighbour($coordinate, $board): bool
    {
        $offsets = [[0, 1], [0, -1], [1, 0], [-1, 0], [-1, 1], [1, -1]];

        [$x, $y] = explode(',', $coordinate);

        foreach ($offsets as [$dx, $dy]) {
            $neighbourX = $x + $dx;
            $neighbourY = $y + $dy;
            $neighbourCoordinate = "$neighbourX,$neighbourY";

            if (isset($board[$neighbourCoordinate])) {
                return true;
            }
        }

        return false;
    }

    public function neighboursAreSameColor($player, $a, $board): bool
    {
        foreach ($board as $b => $st) {
            if (!$st) {continue;}
            $c = $st[count($st) - 1][0];
            if ($c != $player && $this->isNeighbour($a, $b)) {return false;}
        }
        return true;
    }

    public function len($tile): int
    {
        return $tile ? count($tile) : 0;
    }

    public function slide($board, $from, $to): bool
    {
        $offsets = [[0, 1], [0, -1], [1, 0], [-1, 0], [-1, 1], [1, -1]];
        if (!$this->hasNeighBour($to, $board) || !$this->isNeighbour($from, $to)) {return false;}
        $b = explode(',', $to);
        $common = [];
        foreach ($offsets as $pq) {
            $p = $b[0] + $pq[0];
            $q = $b[1] + $pq[1];
            if ($this->isNeighbour($from, $p.",".$q)) {$common[] = $p.",".$q;}
        }
        if (!$board[$common[0]] && !$board[$common[1]] && !$board[$from] && !$board[$to]) {return false;}
        return min($this->len($board[$common[0]]), $this->len($board[$common[1]])) <=
            max($this->len($board[$from]), $this->len($board[$to]));
    }

    public static function getPossiblePlays($board): array
    {
        $offsets = [[0, 1], [0, -1], [1, 0], [-1, 0], [-1, 1], [1, -1]];
        $turn = count($board);

        if (!$turn) {
            return ['0,0'];
        }

        if ($turn == 1) {
            return ['0,1', '1,0', '-1,0', '0,-1', '1,-1', '-1,1'];
        }

        $toList = [];
        foreach ($board as $coordinate => $item) {
            $xy = explode(',', $coordinate);
            $x = intval($xy[0]);
            $y = intval($xy[1]);

            foreach ($offsets as $offset) {
                $newX = $x + $offset[0];
                $newY = $y + $offset[1];

                $newCoordinate = "$newX,$newY";

                $alreadyInBoard = false;
                foreach ($board as $existingCoordinate => $existingItem) {
                    if ($existingCoordinate === $newCoordinate) {
                        $alreadyInBoard = true;
                        break;
                    }
                }

                if (!$alreadyInBoard) {
                    $toList[] = $newCoordinate;
                }
            }
        }

        return array_unique($toList);
    }

    public static function getPlayerTiles($board): array
    {
        $tiles = [];
        foreach ($board as $tile => $data) {
            if ($data[0][0] == GameState::getPlayer()) {
                $tiles[$tile] = $data;
            }
        }

        return $tiles;
    }

}
