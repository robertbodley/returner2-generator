<?php

require 'vendor/autoload.php';
require 'src/Controller.php';

date_default_timezone_set('Africa/Lagos');//or change to whatever timezone you want


$app = new Slim\App();

$app->get('/', function ($request, $response, $args) {
    $controller = new Controller();
    return $controller->indexLoad();
});

$app->get('/generate', function ($request, $response, $args) {
    $controller = new Controller();
    return $controller->generateLoad();
});

$app->run();
