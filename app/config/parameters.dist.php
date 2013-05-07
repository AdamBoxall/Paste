<?php

// Copy this file to `parameters.php` and update to match your installation.

return [

    // Debug mode?
    'debug' => false,

    // Database config
    'database' => [
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => '',
        'user'      => 'root',
        'password'  => '',
        'charset'   => 'utf8',
    ],

    // Twig config
    'twig' => [
        'path' => realpath(__DIR__ . '/../../views'),
    ],

    // Memcache config
    'memcache' => [
        'host' => 'localhost',
        'port' => '11211',
    ],

];