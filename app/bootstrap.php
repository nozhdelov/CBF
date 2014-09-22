<?php

use \CBF\Autoloading\Autoloader;



require_once __DIR__.'/../CBF/Autoloading/Autoloader.php';



Autoloader::addPath('.');
//Autoloader::addPath('./CBF/');
Autoloader::register();


$app = new \CBF\Application\Application;

\CBF\Facade\Facade::setContainer($app);

$app->setConfigsPath(__DIR__ . '/configs/');
$app->detectEnv(array(
    
));

$app->loadConfig('path');
$app->loadConfig('database');




require_once $app->getConfig('path')->framework . 'bootstrap.php';


require_once $app->getConfig('path')->app . 'routes.php';