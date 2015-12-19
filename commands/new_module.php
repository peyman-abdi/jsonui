<?php
return array(
    "name" => "new module",
    "callback" => function(jsonui_console $console) {
        $console->writeln("New module meta", "green");
        $name = $console->ask("Module name: ");
        $desc = $console->ask("Module desc: ");
        $ownr = $console->ask("Your name: ", "Peyman Abdi");
        
        $access = $console->options("Module access", array(
            array("name" => "no access resctrictions", "value" => 1),
            array("name" => "self or application with certificates", "value" => 5),
            array("name" => "any unsigned/signed person", "value" => 2),
            array("name" => "any signed person", "value" => 3),
            array("name" => "signed person with permissions", "value" => 4),
            array("name" => "signed person with roles and permissions", "value" => 6),
            array("name" => "custom", "value" => 7)
        ));
        
        $flags = $console->flags("Access roles", array(
            array("name" => "Root", "value" => 1),
            array("name" => "Student", "value" => 2),
            array("name" => "Mamager", "value" => 4)
        ), 3);
    },
);

