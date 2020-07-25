#!/usr/bin/env php

<?php
    /**
     * Feed the RobotController the list of commands we pulled from the input file.
     *
     * @param array $commands
     */
    function run(array $commands)
    {
        require __DIR__.'/vendor/autoload.php';

        $controller = new ToyRobot\Controllers\RobotController();

        foreach ($commands as $command) {
            $controller->run(
                $command['name'],
                $command['arguments'] ?? null
            );
        }
    }
    
    /**
     * Open the input file and generate a list of commands
     *
     * @param string $filePath
     * @return array $commands
     */
    function process(string $filePath)
    {
        $commands = [];
        $filePath = file_get_contents($filePath);
        $lines = explode(PHP_EOL, $filePath);

        foreach ($lines as $line) {
            $result = preg_match('/\s*(\S*)\s*(\S*)\s*/', $line, $matches);

            if (!$result) {
                continue;
            }

            $command = $matches[1];
            $arguments = $matches[2];

            if (!$command) {
                continue;
            }

            if ($arguments) {
                $arguments = explode(',', $arguments);
            } else {
                $arguments = null;
            }

            array_push($commands, [
                'name' => $command,
                'arguments' => $arguments
            ]);
        }

        return $commands;
    }

    /**
     * Print usage message to the console.
     *
     * @param string $name
     */
    function usage(string $name)
    {
        print("usage: {$name} input_file\n\n");
        print("  input_file:\tThe filepath containing robot commands to be processed.\n\n");
    }

    /**
     * Validate and process command line arguments. Returns the input file path.
     *
     * @param integer $argc
     * @param array $argv
     * @return string $filePath
     */
    function args(int $argc, array $argv)
    {
        if ($argc < 2) {
            print("Aborted: You must specify an input file\n\n");
            usage($argv[0]);
            exit(1);
        }

        if (in_array($argv[1], ['--help', '-h'])) {
            usage($argv[0]);
            exit();
        }

        $filePath = $argv[1];

        if (!file_exists($filePath)) {
            print("Aborted: {$filePath} is not a valid input file\n\n");
            usage($argv[0]);
            exit(1);
        }

        return $filePath;
    }

    function main(int $argc, array $argv)
    {
        $filePath = args($argc, $argv);
        $commands = process($filePath);
        run($commands);
        exit();
    }

    main($argc, $argv);
?>
