<?php

namespace insects;

use HiveGame\insects\Grasshopper;
use PHPUnit\Framework\TestCase;

class GrasshopperTest extends TestCase
{
    public function testStraightLineValid() {
        $from = "0,0";
        $to = "0,2";

        $result = Grasshopper::validMove($from, $to);

        $this->assertTrue($result);
    }
}
