<?php


use HiveGame\Database;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testStoreMove()
    {
        $mysqliMock = $this->getMockBuilder(mysqli::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stmtMock = $this->getMockBuilder(mysqli_stmt::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mysqliMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $stmtMock->expects($this->once())
            ->method('bind_param')
            ->willReturn(true);

        $stmtMock->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $gameId = 1;
        $type = 'test_type';
        $from = 'test_from';
        $to = 'test_to';
        $previous = 0;
        $state = 'test_state';

        $database = new Database($mysqliMock);

        $result = $database->storeMove($gameId, $type, $from, $to, $previous, $state);

        $this->assertEquals(1, $result);
    }

}