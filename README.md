Toy Robot Simulator
===================

Toy robot simulator challenge for Xplor by Alex McBain.

Installation and Usage Instructions
-----------

### Composer

Install composer https://getcomposer.org/download/. In the following steps I have composer installed globally. Once you have composer installed you can install depencies with:

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
php toy-robot.php commands
```

Where `commands` is any text file containing commands for the robot. Commands are accepted in the following format:

```
COMMAND ARG1,ARG2,ARG3
```

Arguments are optional.

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
