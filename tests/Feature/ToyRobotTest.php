<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class ToyRobotTest extends TestCase
{
    public function testScriptExists()
    {
        $this->assertTrue(file_exists(__DIR__ . '/../../toy-robot.php'));
    }

    public function testCanRunCornerToCorner()
    {
        $command = __DIR__ . '/../../toy-robot.php commands/corner-to-corner';
        $result = `$command`;
        $result = $result ? trim($result) : null;

        $this->assertEquals($result, '4,4,EAST');
    }

    public function testCanRunSpinLeft()
    {
        $command = __DIR__ . '/../../toy-robot.php commands/spin-left';
        $result = `$command`;
        $result = $result ? trim($result) : null;

        $this->assertEquals($result, '0,0,SOUTH');
    }

    public function testCanRunSpinRight()
    {
        $command = __DIR__ . '/../../toy-robot.php commands/spin-right';
        $result = `$command`;
        $result = $result ? trim($result) : null;

        $this->assertEquals($result, '0,0,SOUTH');
    }

    public function testCanRunOutOfBounds()
    {
        $command = __DIR__ . '/../../toy-robot.php commands/out-of-bounds';
        $result = `$command`;
        $result = $result ? trim($result) : null;

        $this->assertEquals($result, '4,0,SOUTH');
    }

    public function testCanRunInvalid()
    {
        $command = __DIR__ . '/../../toy-robot.php commands/invalid';
        $result = `$command`;
        $result = $result ? trim($result) : null;

        $this->assertNull($result);
    }
}
