<?php

// Include autoloader
require __DIR__ . '/../vendor/autoload.php';

// Include parameters file
if (!file_exists(__DIR__ . '/config/parameters.php')) {
    throw new Exception('`app/config/parameters.php` file has not been defined');
}

// Start session
session_start();

// Set default timezone
date_default_timezone_set('Europe/London');