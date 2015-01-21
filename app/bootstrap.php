<?php
// Error reporting
error_reporting(E_ALL|E_STRICT);

// Composer Packages
require __DIR__ . '/../vendor/autoload.php';

// Define app constants
define('APP_DIR', __DIR__);
define('VIEW_DIR', __DIR__ . '/views');
define('RESOURCE_DIR', __DIR__ . '/resources');

// Load config
config(parse_ini_file(__DIR__ . '/config.ini'));

// Load support functions
require APP_DIR . '/support.php';

// Setup Database
require APP_DIR . '/database.php';

// Load Page resource
require RESOURCE_DIR . '/page.php';

// Start the app
dispatch();
