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

// My Application
$app = new Application(dirname(__DIR__), $config = []);

$app->router->get('/', [SiteController::class, 'home']);

// Run Application
$app->run();