<?php
return array(
    "name" => "actions",
    "callback" => function () {
        $command_files = scandir(__DIR__.'');
        foreach ($command_files as $file) {
            if (utilities::ends_with($file, '.php') && !utilities::starts_with($file, "actions")) {
                $actions[] = include(__DIR__.'/'.$file);
            }
        }
        return $actions;
    }
);
