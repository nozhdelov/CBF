<?php

Router::get('/', 'index@index');

Router::get('index/{name}', 'index@index');
