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
                    // Validate place command was given with
                    // all three (X,Y,DIR) arguments and X and Y
                    // are valid integer values.
                    // This could probably be tidied up.
                    if (count($arguments) >= 3
                        && is_numeric($arguments[0])
                        && is_numeric($arguments[1])
                    ) {
                        $this->robot->place(
                            intval($arguments[0]), // X
                            intval($arguments[1]), // Y
                            $arguments[2] // Direction
                        );
                    }
                    break;
                case 'move':
                    // Optional no. steps argument
                    $steps = 1;
                    if (isset($arguments[0]) && is_numeric($arguments[0])) {
                        $steps = intval($arguments[0]);
                    }
                    $this->robot->move($steps);
                    break;
                case 'left':
                    $this->robot->rotateLeft();
                    break;
                case 'right':
                    $this->robot->rotateRight();
                    break;
                case 'report':
                    print($this->robot->report() . "\n");
                    break;
                default:
                    // Ignore invalid command

                    // This is cool but a little too verbose
                    // if ($verbose) {
                    //    print("Ignored {$command}\n");
                    // }
                    break;
            }
        } catch (RobotException $e) {
            if ($verbose) {
                print("Ignored \"{$command}\": " . $e->getMessage(). "\n");
            }
        }
    }
}
