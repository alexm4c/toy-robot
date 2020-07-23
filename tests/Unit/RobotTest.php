<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use ToyRobot\Models\Robot;

class RobotTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(
            Robot::class,
            new Robot(),
        );
    }
}
