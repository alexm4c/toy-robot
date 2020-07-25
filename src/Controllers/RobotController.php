<?php declare(strict_types=1);

namespace ToyRobot\Controllers;

use ToyRobot\Exceptions\RobotException;
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
     * @param array|null $arguments
     * @param bool $verbose
     */
    public function run(
        string $command,
        array $arguments = null,
        bool $verbose = false
    ) {
        $command = strtolower($command);

        try {
            switch ($command) {
                case 'place':
                    if (count($arguments) >= 3) {
                        $this->robot->place(
                            intval($arguments[0]), // X
                            intval($arguments[1]), // Y
                            $arguments[2] // Direction
                        );
                    }
                    break;
                case 'move':
                    $this->robot->move();
                    break;
                case 'left':
                    $this->robot->rotateLeft();
                    break;
                case 'right':
                    $this->robot->rotateRight();
                    break;
                case 'report':
                    echo $this->robot->report() . "\n";
                    break;
                default:
                    // Ignore invalid command
                    break;
            }
        } catch (RobotException $e) {
            if ($verbose) {
                print("Ignored \"{$command}\": " . $e->getMessage(). "\n");
            }
        }
    }
}
