<?php declare(strict_types=1);

namespace ToyRobot\Controllers;

use ToyRobot\Models\Board;
use ToyRobot\Models\Robot;

/**
 *  Recieves commands as string and runs the appropriate robot functions.
 */
class RobotController
{
    protected $robot;

    public function __construct()
    {
        $board = new Board(5, 5);
        $this->robot = new Robot($board);
    }

    /**
     * Give the robot a command from string and optional array of arguments.
     *
     * @param string $command
     * @param array|null $args
     */
    public function run(string $command, array $args = null)
    {
        //
    }
}
