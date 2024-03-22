<?php


use HiveGame\GameTile;
use PHPUnit\Framework\TestCase;

class GameTileTest extends TestCase
{
    public function testGetTypeValid() {
        $board = ["0,0" => [[0, "Q"]]];
        $position = "0,0";
        $expectedType = "Q";

        $actualType = GameTile::getType($position, $board);

        $this->assertEquals($expectedType, $actualType);
    }

    public function testGetTypeInvalid() {
        $board = [];
        $position = "0,0";

        $actualType = GameTile::getType($position, $board);

        $this->assertFalse($actualType);
    }
}
