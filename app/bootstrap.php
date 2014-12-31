<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

use \CBF\Autoloading\Autoloader;


define('FRAMEWORK_PATH', __DIR__ . '/../');

require_once FRAMEWORK_PATH . 'CBF/Autoloading/Autoloader.php';
Autoloader::register();
Autoloader::addPath(FRAMEWORK_PATH);

$app = new \CBF\Application\Application;

$app->detectEnv(array(
    'cbf.com' => 'production'
));

$app->setConfigsPath(__DIR__ . '/configs/');
$app->loadConfig('path');
$app->loadConfig('app');




\CBF\Facade\Facade::setContainer($app);

require_once $app->getConfig('path')->framework . 'CBF\bootstrap.php';
require_once $app->getConfig('path')->app . 'routes.php';


$route = Router::matchRequest();

Autoloader::addPath($app->getConfig('path')->modules . $route->getModule() . '/Controller');
Autoloader::addPath($app->getConfig('path')->modules . $route->getModule() . '/Model');

$app->setRoute($route);
$app->run();