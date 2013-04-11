<?php

use Symfony\Component\HttpFoundation\Request;

$app = require __DIR__ . '/../app/app.php';

if (isset($argv) && count($argv) > 0) {
    // Request is being made from CL
    list($_, $method, $path) = $argv;
    $request = Request::create($path, $method);
    $app->run($request);
} else {
    // Request us being mad via HTTP
    $app->run();
}