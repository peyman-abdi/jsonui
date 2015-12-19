<?php

require __DIR__ . '/../vendor/autoload.php';

set_error_handler(function ($error) {
    echo $error;
});

use \Klein\Klein;
$app = new Klein();
$modules = array();

$module_root = __DIR__.'/modules/';
$module_files = utilities::glob_recursive($module_root."*.php", GLOB_NOSORT);
foreach ($module_files as $mfile) {
    $modules[] = include($mfile);
}

foreach ($modules as $mj) {
    if (utilities::module_valid($mj)) {
        $app->respond($mj['methods'], $mj['route'], function(\Klein\Request $request, \Klein\Response $response) use($mj) {
            /* TODO: check callback access */
            $answer = $mj['callback']($mj, $request, $response);            
            if ($mj['response_type'] === "object") {
                $response_json = array(
                    "result" => array("code" => $answer['code'], "object" => $answer['object']),
                    "data" => $answer['data']
                );
                return $response->json($response_json);
            } else if ($mj['response_type'] === "array") {
                $response_json = array(
                    "result" => array("code" => $answer['code'], "object" => $answer['object']),
                    "pagination" => array(
                        "window" => $answer['window'],
                        "current" => $answer['current'],
                        "next" => $answer['next'],
                        "total" => $answer['total'],
                        "pages" => $answer['pages']
                    ),
                    "data" => $answer['data']
                );
                return $response->json($response_json);
            } else if ($mj['response_type'] == "file") {

            }
        });
    } else {
        
    }
}

$app->onError(function(\Klein\Klein $app, $message, $type, jsonui_exception $ex) {    
    /** TODO: save report */
    return $app->response()->json(array(        
        "result" => array ("code" => $ex->getCode(), "message" => $ex->getMessage()),    
    ));
});

$app->dispatch();

