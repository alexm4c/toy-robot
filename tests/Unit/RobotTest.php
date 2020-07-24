<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use ToyRobot\Exceptions\RobotException;
use ToyRobot\Models\Board;
use ToyRobot\Models\Robot;

class RobotTest extends TestCase
{
    public function testPositionIsNullOnInit()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);

        $this->assertNull($robot->getPosition());
    }

    public function testCannotSetInvalidPosition()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);

        $this->expectException(RobotException::class);

        $robot->setPosition(-1, -1);
        $robot->setPosition(5, 5);
        $robot->setPosition(100, 100);
    }

    public function testCanSetValidPosition()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);

        $robot->setPosition(3, 3);
        $position = $robot->getPosition();

        $this->assertEquals($position['x'], 3);
        $this->assertEquals($position['y'], 3);
    }

    public function testDirectionIsNullOnInit()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);

        $this->assertNull($robot->getDirection());
    }

    public function testFailIfSetInvalidDirection()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);

        $this->expectException(RobotException::class);

        $robot->setDirection('ASDF');
    }

    public function testCanSetNorthDirection()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);

        $robot->setDirection('NORTH');
        $direction = $robot->getDirection();

        $this->assertEquals($direction['name'], 'north');
        $this->assertEquals($direction['x'], 0);
        $this->assertEquals($direction['y'], 1);
    }

    public function testCanSetEastDirection()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);
                
        $robot->setDirection('EAST');
        $direction = $robot->getDirection();

        $this->assertEquals($direction['name'], 'east');
        $this->assertEquals($direction['x'], 1);
        $this->assertEquals($direction['y'], 0);
    }

    public function testCanSetSouthDirection()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);
                
        $robot->setDirection('SOUTH');
        $direction = $robot->getDirection();

        $this->assertEquals($direction['name'], 'south');
        $this->assertEquals($direction['x'], 0);
        $this->assertEquals($direction['y'], -1);
    }

    public function testCanSetWestDirection()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);
                
        $robot->setDirection('WEST');
        $direction = $robot->getDirection();

        $this->assertEquals($direction['name'], 'west');
        $this->assertEquals($direction['x'], -1);
        $this->assertEquals($direction['y'], 0);
    }

    public function testCanPlaceWithValidPositionAndDirection()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);

        $robot->place(1, 1, 'WEST');
        $direction = $robot->getDirection();
        $position = $robot->getPosition();

        $this->assertEquals($direction['name'], 'west');
        $this->assertEquals($position['x'], 1);
        $this->assertEquals($position['y'], 1);
    }

    public function testCannotPlaceWithInvalidPosition()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);

        $this->expectException(RobotException::class);

        $robot->place(-1, -1, 'WEST');
    }

    public function testCannotPlaceWithInvalidDirection()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);

        $this->expectException(RobotException::class);

        $robot->place(1, 1, 'ASDF');
    }

    public function testCannotMoveIfUnplaced()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);

        $this->expectException(RobotException::class);

        $robot->move();
    }

    public function testCannotMoveToInvalidPosition()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);
        $robot->place(0, 0, 'SOUTH');

        $this->expectException(RobotException::class);

        $robot->move();
    }

    public function testCanMoveNorthToValidPosition()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);
        $robot->place(1, 1, 'NORTH');
        $robot->move();

        $position = $robot->getPosition();

        $this->assertEquals($position['x'], 1);
        $this->assertEquals($position['y'], 2);
    }

    public function testCanMoveEastToValidPosition()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);
        $robot->place(1, 1, 'EAST');
        $robot->move();

        $position = $robot->getPosition();

        $this->assertEquals($position['x'], 2);
        $this->assertEquals($position['y'], 1);
    }

    public function testCanMoveSouthToValidPosition()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);
        $robot->place(1, 1, 'SOUTH');
        $robot->move();

        $position = $robot->getPosition();

        $this->assertEquals($position['x'], 1);
        $this->assertEquals($position['y'], 0);
    }

    public function testCanMoveWestToValidPosition()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);
        $robot->place(1, 1, 'WEST');
        $robot->move();

        $position = $robot->getPosition();

        $this->assertEquals($position['x'], 0);
        $this->assertEquals($position['y'], 1);
    }

    public function testCannotRotateLeftIfUnplaced()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);

        $this->expectException(RobotException::class);

        $robot->rotateLeft();
    }

    public function testCannotRotateRightIfUnplaced()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);

        $this->expectException(RobotException::class);

        $robot->rotateRight();
    }

    public function testCanRotateLeft()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);
        $robot->place(1, 1, 'SOUTH');
        
        $robot->rotateLeft();
        $this->assertEquals($robot->getDirectionName(), 'east');

        $robot->rotateLeft();
        $this->assertEquals($robot->getDirectionName(), 'north');

        $robot->rotateLeft();
        $this->assertEquals($robot->getDirectionName(), 'west');

        $robot->rotateLeft();
        $this->assertEquals($robot->getDirectionName(), 'south');
    }

    public function testCanRotateRight()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);
        $robot->place(1, 1, 'SOUTH');
        
        $robot->rotateRight();
        $this->assertEquals($robot->getDirectionName(), 'west');

        $robot->rotateRight();
        $this->assertEquals($robot->getDirectionName(), 'north');

        $robot->rotateRight();
        $this->assertEquals($robot->getDirectionName(), 'east');

        $robot->rotateRight();
        $this->assertEquals($robot->getDirectionName(), 'south');
    }

    public function testCannotReportIfUnplaced()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);

        $this->expectException(RobotException::class);

        $robot->report();
    }

    public function testCanReport()
    {
        $board = new Board(5, 5);
        $robot = new Robot($board);
        $robot->place(1, 1, 'SOUTH');

        $report = $robot->report();
        
        $this->assertEquals($report, '1,1,SOUTH');
    }
}
