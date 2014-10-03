<?php

CBF\Autoloading\Autoloader::addAliases(array(
    'App' => 'CBF\Facade\Application',
    'Router' => 'CBF\Facade\Router',
    'View' => 'CBF\Facade\View',
    'Session' => 'CBF\Facade\Session',
    'SessionFactory' => 'CBF\Facade\SessionFactory',
    'Controller' => 'CBF\Controller\Controller',
    
));




$app->bindInstance($app, 'CBF\Application\Application', 'App');

$app->bindShared('CBF\Routing\Router', 'Router');
$app->bindShared('CBF\Session\Session', 'Session');
$app->bindShared('CBF\Session\Factory', 'SessionFactory');
$app->bind('CBF\View\Factory', 'View');


$app->bindInstance(SessionFactory::make() , 'CBF\Session\Session', 'Session');





Session::init();
