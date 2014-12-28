<?php




Router::get('/', 'index@index');
Router::get('index/{name}', 'index@index');

Router::get('api/', 'api/index@index');