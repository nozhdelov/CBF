<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

use \CBF\Autoloading\Autoloader;



require_once __DIR__.'/../CBF/Autoloading/Autoloader.php';


Autoloader::register();
Autoloader::addPath('.');




$app = new \CBF\Application\Application;

\CBF\Facade\Facade::setContainer($app);

$app->setConfigsPath(__DIR__ . '/configs/');
$app->detectEnv(array(
    
));

$app->loadConfig('path');
$app->loadConfig('app');




require_once $app->getConfig('path')->framework . 'bootstrap.php';


require_once $app->getConfig('path')->app . 'routes.php';


$route = Router::matchRequest();

Autoloader::addPath($app->getConfig('path')->modules . $route->getModule() . '/Controller');
Autoloader::addPath($app->getConfig('path')->modules . $route->getModule() . '/Model');

$app->setRoute($route);
$app->run();