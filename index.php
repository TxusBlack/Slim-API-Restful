<?php
require_once 'vendor/autoload.php';

$app = new \Slim\Slim();

$app->get("/hola/:nombre", function($nombre){
    print_r("hola " . $nombre);
});

$app->run();