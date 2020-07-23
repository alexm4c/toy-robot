<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use ToyRobot\Exceptions\BoardException;
use ToyRobot\Models\Board;

class BoardTest extends TestCase
{
    public function testCannotCreateWithInvalidDimensions(): void
    {
        $this->expectException(BoardException::class);

        $board = new Board(-1, -1);
    }

    public function testReturnFalseOnInvalidPosition(): void
    {
        $board = new Board(5, 5);

        $this->assertFalse($board->validatePosition(-1, -1));
        $this->assertFalse($board->validatePosition(5, 5));
        $this->assertFalse($board->validatePosition(100, 100));
    }

    public function testReturnTrueOnValidPosition(): void
    {
        $board = new Board(5, 5);

        $this->assertTrue($board->validatePosition(0, 0));
        $this->assertTrue($board->validatePosition(2, 2));
        $this->assertTrue($board->validatePosition(4, 4));
    }
}
