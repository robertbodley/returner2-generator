<?php

require 'vendor/autoload.php';
require 'src/Controller.php';

$app = new Slim\App();

$app->get('/', function ($request, $response, $args) {
    $controller = new Controller();
    return $controller->indexLoad();
});

$app->run();
