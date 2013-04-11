<?php

use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Paste\Controller\PasteController;
use Paste\Gateway;
use Paste\Exception\PasteNotFoundException;

require __DIR__ . '/bootstrap.php';

$app = new Application();
$app['debug'] = true;

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
    'twig.path' => __DIR__.'/../views',
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

// Catch paste not found exceptions - this needs a lot of imrpovement of course!
$app->error(function(PasteNotFoundException $e) {
    return new Response('404 Paste not found', 404);
});

// Define routes
$app->match('/', 'paste.controller:createAction');
$app->match('/contact', 'paste.controller:contactAction');
$app->get('/latest', 'paste.controller:latestAction');
$app->get('/about', 'paste.controller:aboutAction');
$app->get('/{pasteHex}', 'paste.controller:viewAction')->assert('pasteHex', '[a-zA-Z0-9]+');

return $app;