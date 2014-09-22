<?php

require_once 'app/bootstrap.php';




$route = Router::matchRequest();

$app->run($route);
?>