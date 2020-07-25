Toy Robot Simulator
===================

Coding challenge for Xplor by Alex McBain.

Installation and Usage Instructions
-----------

### Composer

Install composer https://getcomposer.org/download/. 

Use composer install project dependencies:

``` bash
composer install
```

### Testing

``` bash
composer test
```

### Usage

To run the toy robot:

``` bash
php toy-robot.php commands/corner-to-corner
```

Any text file containing commands for the robot can be used.

### Commands

The robot will accept the following commands:

```
PLACE X,Y,DIR
MOVE
LEFT
RIGHT
REPORT
```

When running the `PLACE` command, arguments `X` and `Y` determine the robot's position, and `DIR` determines the direction the robot will be facing.

The robot can will accept the four compass directions for values of `DIR`:

```
NORTH
EAST
SOUTH
WEST
```

Invalid or incomplete commands will be ignored by the robot.
