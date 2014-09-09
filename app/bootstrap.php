<?php

use CBF\Autoloading\Autoloader;
use CBF\Application\Application;


require_once __DIR__.'/../CBF/Autoloading/Autoloader.php';



Autoloader::addPath('.');
Autoloader::register();


$app = \CBF\Application\Application::getInstance();

$app->setConfigsPath(__DIR__ . '/configs/');
$app->detectEnv(array(
    
));

$app->loadConfig('path');
$app->loadConfig('database');
$app->loadConfig('cache');


