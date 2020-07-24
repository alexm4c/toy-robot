<?php declare(strict_types=1);

namespace ToyRobot\Models;

use ToyRobot\Exceptions\RobotException;
use ToyRobot\Models\Board;

/**
 *  Class for controlling the Toy Robot's position and direction.
 */
class Robot
{
    /**
     * Board defines the Robot's (x, y) boundaries.
     *
     * @var Board
     */
    private $board;

    /**
     * Robot's current position as (x, y) array.
     * Null if the robot is unplaced.
     *
     * Format: ['x' => 3, 'y' => 3]
     *
     * @var array|null
     */
    private $position;

    /**
     * Current index of the direction that the robot is facing.
     * Null if the robot is unplaced.
     *
     * @var int|null
     */
    private $direction;

    /**
     * List of valid directions the robot can be facing.
     *
     * In this list structure we have an (x, y) vector
     * so we can tell the robot which direction to move in,
     * as well as a name so we can tell the humans.
     *
     * Instead of keying this array by the direction name,
     * index keys were chosen instead so we can easily cycle
     * through clockwise or anticlockwise by adding or subtracting
     * from the current index.
     */
    const DIRECTIONS = [
        ['name' => 'north', 'x' => 0, 'y' => 1],
        ['name' => 'east', 'x' => 1, 'y' => 0],
        ['name' => 'south', 'x' => 0, 'y' => -1],
        ['name' => 'west', 'x' => -1, 'y' => 0],
    ];

    /**
     * Enumerate our direction indexes so we can grab them cleanly.
     */
    const NORTH = 0;
    const EAST = 1;
    const SOUTH = 2;
    const WEST = 3;

    public function __construct(Board $board)
    {
        $this->board = $board;
        $this->position = null;
        $this->direction = null;
    }

    /**
     * Get Robot position as (x, y) array.
     *
     * @return array|null
     */
    public function getPosition(): ?array
    {
        return $this->position;
    }

    /**
     * Set Robot position from an (x, y) "tuple".
     *
     * @param integer $x
     * @param integer $y
     * @throws RobotException
     */
    public function setPosition(int $x, int $y): void
    {
        if (!$this->board->validatePosition($x, $y)) {
            throw new RobotException("Invalid position ({$x}, {$y})");
        }

        $this->position = ['x' => $x, 'y' => $y];
    }

    /**
     * Get the direction object that corresponds to the
     * direction that the robot is currently facing.
     *
     * @return array
     */
    public function getDirection(): ?array
    {
        if ($this->direction === null) {
            return null;
        }
        
        return self::DIRECTIONS[$this->direction];
    }

    /**
     * Get the name of the compass direction the robot is facing.
     *
     * @return array
     */
    public function getDirectionName(): ?string
    {
        return $this->getDirection()['name'] ?? null;
    }

    /**
     * Set Robot direction from named compass
     * directions (North, East, South, West).
     *
     * @param string $directionString
     * @throws RobotException
     */
    public function setDirection(string $directionString)
    {
        $directionString = strtolower($directionString);
        
        switch ($directionString) {
            case 'north':
                $this->direction = self::NORTH;
                break;
            case 'east':
                $this->direction = self::EAST;
                break;
            case 'south':
                $this->direction = self::SOUTH;
                break;
            case 'west':
                $this->direction = self::WEST;
                break;
            default:
                throw new RobotException(
                    "Invalid direction {$directionString}"
                );
                break;
        }
    }

    /**
     * Place robot at the specified position (x, y), facing
     * compass direction (North, East, South, West).
     *
     * @param integer $x
     * @param integer $y
     * @param string $direction
     * @throws RobotException
     */
    public function place(int $x, int $y, string $direction): void
    {
        $this->setPosition($x, $y);
        $this->setDirection($direction);
    }

    /**
     * Move the robot one unit in the direction it's currently facing.
     *
     * The robot cannot move to an position that is
     * out of bounds on the Board. Nor can it move
     * if it has not been placed on the Board.
     *
     * @throws RobotException
     */
    public function move(): void
    {
        $direction = $this->getDirection();

        if ($this->direction === null) {
            throw new RobotException("Robot cannot move if unplaced.");
        }

        // Add the robots direction vector to it's position
        // to calculate it's new position on the Board.
        $newPositionX = $this->position['x'] + $direction['x'];
        $newPositionY = $this->position['y'] + $direction['y'];

        if (!$this->board->validatePosition($newPositionX, $newPositionY)) {
            throw new RobotException(
                "Robot cannot move to invalid position ({$newPositionX}, {$newPositionY})"
            );
        }

        $this->setPosition($newPositionX, $newPositionY);
    }

    /**
     * Move Robot's compass direction anti-clockwise
     * from it's current direction.
     *
     * Robot cannot rotate if it is not yet placed.
     *
     * @throws RobotException
     */
    public function rotateLeft(): void
    {
        $direction = $this->direction;

        if ($this->direction === null) {
            throw new RobotException("Robot cannot rotate left if unplaced.");
        }

        // Shift direction backwards while wrapping around at array boundaries
        $upperLimit = count(self::DIRECTIONS) - 1;
        $lowerLimit = 0;

        if ($direction <= $lowerLimit) {
            $this->direction = $upperLimit;
        } else {
            $this->direction = $direction - 1;
        }
    }

    /**
     * Move Robot's compass direction clockwise
     * from it's current direction.
     *
     * Robot cannot rotate if it is not yet placed.
     *
     * @throws RobotException
     */
    public function rotateRight(): void
    {
        $direction = $this->direction;

        if ($this->direction === null) {
            throw new RobotException("Robot cannot rotate right if unplaced.");
        }

        // Shift direction forwards while wrapping around at array boundaries
        $upperLimit = count(self::DIRECTIONS) - 1;
        $lowerLimit = 0;

        if ($direction >= $upperLimit) {
            $this->direction = $lowerLimit;
        } else {
            $this->direction = $direction + 1;
        }
    }

    /**
     * Report the Robot's current position and direction
     *
     * @return string
     * @throws RobotException
     */
    public function report(): string
    {
        $position = $this->getPosition();
        $direction = $this->getDirection();
        
        if ($direction === null || $position === null) {
            throw new RobotException("Robot cannot report if unplaced.");
        }

        return implode(',', [
            $position['x'],
            $position['y'],
            strtoupper($direction['name']),
        ]);
    }
}
