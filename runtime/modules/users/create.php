<?php
return array(
    "name" => "create user",
    "desc" => "create new user",
    "group" => "User Management",
    "programmer" => "Peyman",
    "created_at" => "",
    
    "route" => "/user",
    "methods" => array("GET"),
    "input_validation" => array(
        "phone" => "required",
        "email" => "required"
    ),
    "input_values" => array(),
    "response_type" => "object",
    
    "access" => "any_person",
    
    "callback" => function(array $self, \Klein\Request $request, \Klein\Response $response) {
	
    }
);

