<?php

use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Paste\Controller\PasteController;
use Paste\Gateway;
use Paste\Cache;


// Register database
$app->register(new DoctrineServiceProvider, [
    'db.options' => $parameters['database']
]);

// Register twig
$app->register(new TwigServiceProvider, [
    'twig.path' => $parameters['twig']['path']
]);

// Register service provider
$app->register(new ServiceControllerServiceProvider);

// Create cache layer
$app['paste.cache'] = $app->share(function() use ($parameters) {
    return new Cache(
        $parameters['memcache']['host'],
        $parameters['memcache']['port']
    );
});

// Create gateway
$app['paste.gateway'] = $app->share(function() use ($app) {
    return new Gateway($app['db'], $app['paste.cache']);
});

// Create controller
$app['paste.controller'] = $app->share(function() use ($app) {
    return new PasteController($app['paste.gateway'], $app['twig']);
});