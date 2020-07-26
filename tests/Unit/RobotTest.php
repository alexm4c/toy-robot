<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use ToyRobot\Exceptions\RobotException;
use ToyRobot\Models\Board;
use ToyRobot\Models\Robot;

class RobotTest extends TestCase
{
    protected $robot;

    protected function setUp(): void
    {
        $board = new Board(5, 5);
        $this->robot = new Robot($board);
    }

    public function testPositionIsNullOnInit()
    {
        $this->assertNull($this->robot->getPosition());
    }

    public function testCannotSetInvalidSouthWestPosition()
    {
        $this->expectException(RobotException::class);

        $this->robot->setPosition(-1, -1);
    }

    public function testCannotSetInvalidNorthWestPosition()
    {
        $this->expectException(RobotException::class);

        $this->robot->setPosition(-1, 5);
    }

    public function testCannotSetInvalidNorthEastPosition()
    {
        $this->expectException(RobotException::class);

        $this->robot->setPosition(5, 5);
    }

    public function testCannotSetInvalidSouthEastPosition()
    {
        $this->expectException(RobotException::class);

        $this->robot->setPosition(5, -1);
    }

    public function testCanSetValidPosition()
    {
        $this->robot->setPosition(3, 3);
        $position = $this->robot->getPosition();

        $this->assertEquals($position['x'], 3);
        $this->assertEquals($position['y'], 3);
    }

    public function testDirectionIsNullOnInit()
    {
        $this->assertNull($this->robot->getDirection());
    }

    public function testFailIfSetInvalidDirection()
    {
        $this->expectException(RobotException::class);

        $this->robot->setDirection('ASDF');
    }

    public function testCanSetNorthDirection()
    {
        $this->robot->setDirection('NORTH');
        $direction = $this->robot->getDirection();

        $this->assertEquals($direction['name'], 'north');
        $this->assertEquals($direction['x'], 0);
        $this->assertEquals($direction['y'], 1);
    }

    public function testCanSetEastDirection()
    {
        $this->robot->setDirection('EAST');
        $direction = $this->robot->getDirection();

        $this->assertEquals($direction['name'], 'east');
        $this->assertEquals($direction['x'], 1);
        $this->assertEquals($direction['y'], 0);
    }

    public function testCanSetSouthDirection()
    {
        $this->robot->setDirection('SOUTH');
        $direction = $this->robot->getDirection();

        $this->assertEquals($direction['name'], 'south');
        $this->assertEquals($direction['x'], 0);
        $this->assertEquals($direction['y'], -1);
    }

    public function testCanSetWestDirection()
    {
        $this->robot->setDirection('WEST');
        $direction = $this->robot->getDirection();

        $this->assertEquals($direction['name'], 'west');
        $this->assertEquals($direction['x'], -1);
        $this->assertEquals($direction['y'], 0);
    }

    public function testCanPlaceWithValidPositionAndDirection()
    {
        $this->robot->place(1, 1, 'WEST');
        $direction = $this->robot->getDirection();
        $position = $this->robot->getPosition();

        $this->assertEquals($direction['name'], 'west');
        $this->assertEquals($position['x'], 1);
        $this->assertEquals($position['y'], 1);
    }

    public function testCannotPlaceWithInvalidPosition()
    {
        $this->expectException(RobotException::class);

        $this->robot->place(-1, -1, 'WEST');
    }

    public function testCannotPlaceWithInvalidDirection()
    {
        $this->expectException(RobotException::class);

        $this->robot->place(1, 1, 'ASDF');
    }

    public function testCannotMoveIfUnplaced()
    {
        $this->expectException(RobotException::class);

        $this->robot->move();
    }

    public function testCannotMoveToInvalidPosition()
    {
        $this->robot->place(0, 0, 'SOUTH');

        $this->expectException(RobotException::class);

        $this->robot->move();
    }

    public function testCanMoveNorthToValidPosition()
    {
        $this->robot->place(1, 1, 'NORTH');
        $this->robot->move();

        $position = $this->robot->getPosition();

        $this->assertEquals($position['x'], 1);
        $this->assertEquals($position['y'], 2);
    }

    public function testCanMoveEastToValidPosition()
    {
        $this->robot->place(1, 1, 'EAST');
        $this->robot->move();

        $position = $this->robot->getPosition();

        $this->assertEquals($position['x'], 2);
        $this->assertEquals($position['y'], 1);
    }

    public function testCanMoveSouthToValidPosition()
    {
        $this->robot->place(1, 1, 'SOUTH');
        $this->robot->move();

        $position = $this->robot->getPosition();

        $this->assertEquals($position['x'], 1);
        $this->assertEquals($position['y'], 0);
    }

    public function testCanMoveWestToValidPosition()
    {
        $this->robot->place(1, 1, 'WEST');
        $this->robot->move();

        $position = $this->robot->getPosition();

        $this->assertEquals($position['x'], 0);
        $this->assertEquals($position['y'], 1);
    }

    public function testCanMoveMultipleSteps()
    {
        $this->robot->place(0, 0, 'NORTH');
        $this->robot->move(4);

        $position = $this->robot->getPosition();

        $this->assertEquals($position['x'], 0);
        $this->assertEquals($position['y'], 4);
    }

    public function testCanMoveZeroSteps()
    {
        $this->robot->place(0, 0, 'NORTH');
        $this->robot->move(0);

        $position = $this->robot->getPosition();

        $this->assertEquals($position['x'], 0);
        $this->assertEquals($position['y'], 0);
    }

    public function testCannotRotateLeftIfUnplaced()
    {
        $this->expectException(RobotException::class);

        $this->robot->rotateLeft();
    }

    public function testCannotRotateRightIfUnplaced()
    {
        $this->expectException(RobotException::class);

        $this->robot->rotateRight();
    }

    public function testCanRotateLeft()
    {
        $this->robot->place(1, 1, 'SOUTH');
        
        $this->robot->rotateLeft();
        $this->assertEquals($this->robot->getDirectionName(), 'east');

        $this->robot->rotateLeft();
        $this->assertEquals($this->robot->getDirectionName(), 'north');

        $this->robot->rotateLeft();
        $this->assertEquals($this->robot->getDirectionName(), 'west');

        $this->robot->rotateLeft();
        $this->assertEquals($this->robot->getDirectionName(), 'south');
    }

    public function testCanRotateRight()
    {
        $this->robot->place(1, 1, 'SOUTH');
        
        $this->robot->rotateRight();
        $this->assertEquals($this->robot->getDirectionName(), 'west');

        $this->robot->rotateRight();
        $this->assertEquals($this->robot->getDirectionName(), 'north');

        $this->robot->rotateRight();
        $this->assertEquals($this->robot->getDirectionName(), 'east');

        $this->robot->rotateRight();
        $this->assertEquals($this->robot->getDirectionName(), 'south');
    }

    public function testCannotReportIfUnplaced()
    {
        $this->expectException(RobotException::class);

        $this->robot->report();
    }

    public function testCanReport()
    {
        $this->robot->place(1, 1, 'SOUTH');

        $report = $this->robot->report();
        
        $this->assertEquals($report, '1,1,SOUTH');
    }
}
