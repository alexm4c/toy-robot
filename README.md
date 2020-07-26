Toy Robot
===================

A solution to the Toy Robot coding challenge for Xplor by Alex McBain.

Installation and Usage
-----------

This project was primarily built and tested in a Debian environment running PHP7.3.

### Prerequisites

- PHP7.2 or greater
- php-mbstring
- php-xml

### Composer

Install composer https://getcomposer.org/download/. 

Use composer to install our dependencies. Composer is installed globally
in the following examples.

``` bash
composer install
```

### Testing

``` bash
composer test
```

### Usage

Any text file containing Robot commands can be used.

``` bash
php toy-robot.php commands/corner-to-corner
```

### Commands

The following commands will be accepted by the Robot. Invalid or
incomplete commands will be ignored.

```
PLACE X,Y,DIR
MOVE STEPS?
LEFT
RIGHT
REPORT
```

#### Place

The `PLACE` command takes three arguments `X,Y,DIR`. `X` and `Y` give
the Robot's position and `DIR` gives the compass direction that it will
face. The Robot will ignore any other command if it is not yet placed.

#### Move

`MOVE` will ask the Robot to change it's position one unit in the 
direction it's facing. Optionally, you can ask the Robot to move
multiple units by providing the `STEPS` argument.

#### Left and Right

`LEFT` and `RIGHT` will tell the Robot to rotate in each direction.

#### Report

`REPORT` outputs the Robot's current position and direction as `X,Y,DIR`.

### The Board

The Robot's `X,Y` position is bounded by a 5x5 Board. The south-west
corner has the position `0,0` and the north-east corner has the position
`4,4`. The `MOVE` and `PLACE` commands will be ignored if it would
result in a position that is out of bounds.

Example Input and Output
------------------------

### Corner to corner

    PLACE 0,0,NORTH
    MOVE
    MOVE
    MOVE
    MOVE
    RIGHT
    MOVE
    MOVE
    MOVE
    MOVE
    REPORT

Expected output:

    4,4,EAST

### Spin left

    PLACE 0,0,SOUTH
    LEFT
    LEFT
    LEFT
    LEFT
    REPORT

Expected output:

    0,0,SOUTH

### Four corners fast

    PLACE 0,0,NORTH
    MOVE 4
    RIGHT
    MOVE 4
    RIGHT
    MOVE 4
    RIGHT
    REPORT

Expected output:

    4,0,WEST

Notes
------------------------

### Verbose Mode

If you ever need to see what the Robot is thinking you can use the `-v`
flag to enable verbose mode.

``` bash
php toy-robot.php README.md -v
```
