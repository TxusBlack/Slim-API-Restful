<?php
require_once 'vendor/autoload.php';

$app = new \Slim\Slim();

$app->get("/hola/:nombre", function($nombre) use ($app){
    print_r("hola " . $nombre. "<br>");
    // En vez de params podremos utiliar GET, POST y PUT para saber que hay ahí
    // Y podemos ser específicos dentro del params
    var_dump($app->request->params("hola"));
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
// $uri = "slim/index.php/api/ejemplo/";
$app->group("/api", function() use ($app) {
    $app->group("/ejemplo", function() use ($app) {
        $app->get("/hola/:nombre", function($nombre){
            print_r("hola " . $nombre);
        })->name("hola");

        $app->get("/apellido/:apellido", function($apellido){
            print_r("Tu apellido es: " . $apellido);
        });

        // Hacer redirecciones
        $app->get("/enviame-a-hola", function() use ($app) {
            // $app->redirect("hola/Diego");

            // urlFor es darle nombre a una ruta y usarla como si fuera var
            // urlFor es para sacar la ruta completa de donde se ejecuta
            $app->redirect($app->urlFor("hola", array(
                "nombre" => "Diego"
            )));
        });
    });
});

$app->run();