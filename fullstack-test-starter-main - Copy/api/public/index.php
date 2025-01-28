<?php

// Autoload dependencies and classes
require_once __DIR__ . '/../vendor/autoload.php';

use App\App;

// Set appropriate error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Start the application
App::run();
