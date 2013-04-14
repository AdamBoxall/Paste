<?php

use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Paste\Controller\PasteController;
use Paste\Gateway;
use Paste\Cache;


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

// Create cache layer
$app['paste.cache'] = $app->share(function() {
    return new Cache('localhost', '11211');
});

// Create gateway
$app['paste.gateway'] = $app->share(function() use ($app) {
    return new Gateway($app['db'], $app['paste.cache']);
});

// Create controller
$app['paste.controller'] = $app->share(function() use ($app) {
    return new PasteController($app['paste.gateway'], $app['twig']);
});