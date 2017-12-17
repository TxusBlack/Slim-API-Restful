<?php
require_once 'vendor/autoload.php';

$app = new \Slim\Slim();

$app->get("/hola/:nombre", function($nombre){
    print_r("hola " . $nombre);
});

// Como hacer un middleware
// Para comprobar cosas como un login, si está en produccion, etc
function pruebaMiddle(){
    echo "Soy un Middleware <br>";
};

function pruebaDos(){
    echo "Soy un Middleware 2 <br>";
};

// Para volver opcional un parametro se coloca en () pero
// al no ser necesarios hay que ponerle un valor default

// Para pasar un middleware 
$app->get("/pruebas/(:uno/(:dos))", 'pruebaMiddle', 'pruebaDos', function($uno=null, $dos=null){
    print_r($uno."<br>");
    print_r($dos."<br>");
    // Podemos colocar condiciones para tiparlos
})->conditions(array(
    // "Expresion regular"
    "uno" => "[a-zA-Z]*",
    "dos" => "[0-9]*"
));

// Crear un grupo de rutas
$app->group("/api", function() use ($app) {
    $app->group("/ejemplo", function() use ($app) {
        $app->get("/hola/:nombre", function($nombre){
            print_r("hola " . $nombre);
        });
        
        $app->get("/apellido/:apellido", function($apellido){
            print_r("Tu apellido es: " . $apellido);
        });
    });
});

$app->run();