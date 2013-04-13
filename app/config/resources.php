<?php

use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Paste\Controller\PasteController;
use Paste\Gateway;

// Register database
$app->register(new DoctrineServiceProvider, [
    'db.options' => [
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'pastebang',
        'user'      => 'root',
        'password'  => 'swordfish',
        'charset'   => 'utf8'
    ]
]);

// Register twig
$app->register(new TwigServiceProvider, [
    'twig.path' => realpath(__DIR__ . '/../../views'),
]);

// Register service provider
$app->register(new ServiceControllerServiceProvider);

// Create gateway
$app['paste.gateway'] = $app->share(function() use ($app) {
    return new Gateway($app['db']);
});

// Create controller
$app['paste.controller'] = $app->share(function() use ($app) {
    return new PasteController($app['paste.gateway'], $app['twig']);
});