<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Paste\Exception\PasteNotFoundException;

require __DIR__ . '/bootstrap.php';

$app = new Application();
$app['debug'] = true;

// Catch paste not found exceptions - this needs a lot of imrpovement of course!
$app->error(function(PasteNotFoundException $e) {
    return new Response('404 Paste not found', 404);
});

// Define resources
require __DIR__ . '/config/resources.php';

// Define routes
require __DIR__ . '/config/routes.php';

return $app;