<?php

$app->match('/', 'paste.controller:createAction');

$app->match('/contact', 'paste.controller:contactAction');

$app->get('/about', 'paste.controller:aboutAction');

$app->get('/{pasteHex}', 'paste.controller:viewAction')
    ->assert('pasteHex', '[a-zA-Z0-9]+');