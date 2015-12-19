<?php
return array(
    "name" => "print version data",
    "callback" => function(jsonui_console $console) {
        $console->writeln("Welcome to jsonui version 0.0.1 alpha");
        $actions = include(__DIR__.'/actions.php');
        $console->options("How can i help you?", $actions["callback"]());
    }
);
