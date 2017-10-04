<?php

/*=============================================================================
 |   Assignment:  RETURNER 2 - Front page genertor
 |   Author:  Robert Bodley, Oliver De Briun, Andre Venter
 |   Description:  Generate the front pages of test and quiz papers
 |   Language:  PHP
 +-----------------------------------------------------------------------------*/

require 'vendor/autoload.php';
require 'src/Controller.php';

date_default_timezone_set('Africa/Lagos');//or change to whatever timezone you want

//Slim object used for routing
$app = new Slim\App();
	
// / route loads the index page
$app->get('/', function ($request, $response, $args) {
    $controller = new Controller();
    return $controller->indexLoad();
});

// /generate used to actually generate the pdf and return it to the user
$app->get('/generate', function ($request, $response, $args) {
    $controller = new Controller();
    return $controller->generateLoad();
});

$app->run();
