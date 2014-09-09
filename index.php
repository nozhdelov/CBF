<?php

require_once 'app/bootstrap.php';

$routes = include 'routes.php';

/*
ini_set('display_errors', 'on');
ini_set("log_errors", "on");
ini_set("error_reporting", E_ALL);



use \CBF\Routing\Router as Router;

Router::get('/', 'index@index');
Router::get('index/{name}', 'index@index');
Router::matchRequest();

*/

Router::matchRequest();
?>