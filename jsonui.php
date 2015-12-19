<?php

require __DIR__ . '/vendor/autoload.php';

$console = new jsonui_console();

$console->writeln("Welcome to jsonui command line tool", "green");
$actions = include(__DIR__.'/commands/actions.php');

$console->options("What can i do for you?", $actions["callback"]());



