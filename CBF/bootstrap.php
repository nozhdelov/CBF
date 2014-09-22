<?php

CBF\Autoloading\Autoloader::addAliases(array(
    'App' => 'CBF\Facade\Application',
    'Router' => 'CBF\Facade\Router',
    'View' => 'CBF\Facade\View'
));


$app->instance($app, 'CBF\Application\Application', 'App');

$app->bindShared('CBF\Routing\Router', 'Router');
$app->bind('CBF\View\Factory', 'View')->addArgument($app->getConfig('path'));


$v = View::make('kur');
