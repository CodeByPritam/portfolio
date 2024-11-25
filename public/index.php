<?php

// import Autoload & Namespaces
use myproject\app\controller\SiteController;
use myproject\app\core\Application;

require_once __DIR__ . '../../vendor/autoload.php';

// Reporting Agent
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_time_limit(60);

// Env
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Config
$config = [
    'isConstruction' => (bool)filter_var($_ENV['MAINTENANCE_MODE'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
];

// My Application
$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/home', [SiteController::class, 'home']);

// Run Application
$app->run();