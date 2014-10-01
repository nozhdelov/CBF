<?php

CBF\Autoloading\Autoloader::addAliases(array(
    'App' => 'CBF\Facade\Application',
    'Router' => 'CBF\Facade\Router',
    'View' => 'CBF\Facade\View',
    'Session' => 'CBF\Facade\Session',
    'SessionFactory' => 'CBF\Session\Factory',
    'Controller' => 'CBF\Controller\Controller',
    
));


$session = SessionFactory::make();


$app->bindInstance($app, 'CBF\Application\Application', 'App');
$app->bindInstance($session , 'CBF\Session\Session', 'Session');

$app->bindShared('CBF\Routing\Router', 'Router');
$app->bindShared('CBF\Session\Session', 'Session');
$app->bind('CBF\View\Factory', 'View');



