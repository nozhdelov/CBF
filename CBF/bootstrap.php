<?php

CBF\Autoloading\Autoloader::addAliases(array(
    'App' => 'CBF\Facade\Application',
    'Router' => 'CBF\Facade\Router',
    'View' => 'CBF\Facade\View',
    'Session' => 'CBF\Facade\Session',
    'SessionFactory' => 'CBF\Facade\SessionFactory',
    'Controller' => 'CBF\Controller\Controller',
    'DatabaseFactory' => 'CBF\Facade\DatabaseFactory',
    'Model' => 'CBF\Model\Model'
));




$app->bindInstance($app, 'CBF\Application\Application', 'App');

$app->bindShared('CBF\Routing\Router', 'Router');
$app->bindShared('CBF\Session\Session', 'Session');
$app->bindShared('CBF\Session\Factory', 'SessionFactory');
$app->bindShared('CBF\Database\Factory', 'DatabaseFactory');
$app->bind('CBF\View\Factory', 'View');
$app->bindInstance(SessionFactory::make(), 'CBF\Session\Session', 'Session');



Session::init();


if(!empty($app->getConfig('app')['database'])){
	CBF\Model\Model::setAdaptor(DatabaseFactory::make());
}