<?php
require_once 'vendor/autoload.php';

$app = new \Slim\Slim();

// Conexión rápida a la bd, recordar cambiarla a PDO
$db = new mysqli("localhost", "root", "", "slim-api");

$app->get("/productos", function() use ($db, $app) {
    $query = $db->query("SELECT * FROM productos;");
    // Recorremos la consulta
    $productos = array();
    while($fila = $query->fetch_assoc()){
        $productos[] = $fila;
    };

    // Nos mostrará sólo un registro de la bd
    echo json_encode($productos);
});

$app->post("/productos", function() use ($db, $app) {
    $query = "INSERT INTO productos VALUES(NULL,"
        ."'{$app->request->post("name")}',"
        ."'{$app->request->post("description")}',"
        ."'{$app->request->post("price")}'"
        . ")";
    $insert = $db->query($query);
    // echo $db->error;

    if($insert) {
        $result = array("STATUS" => "true", "message" => "Producto creado correctamente!");
    } else {
        $result = array("STATUS" => "false", "message" => "El producto no se pudo crear");
    }

    echo json_encode($result);
});

// Hace falta poner que si el dato que entra es nulo no lo cambie
$app->put("/productos/:id", function($id) use ($db, $app){
    $query = "UPDATE productos SET "
        . "name = '{$app->request->post("name")}',"
        . "description = '{$app->request->post("description")}',"
        . "price = '{$app->request->post("price")}'"
        . "WHERE id = {$id}";

    $update = $db->query($query);

    if($update) {
        $result = array("STATUS" => "true", "message" => "Producto actualizado correctamente!");
    } else {
        $result = array("STATUS" => "false", "message" => "El producto no se pudo actualizar");
    }
    echo json_encode($result);
});

$app->delete("/productos/:id", function($id) use($db, $app){
    $query = "DELETE FROM productos WHERE id = {$id}";
    $delete = $db->query($query);

    if($delete) {
        $result = array("STATUS" => "true", "message" => "Producto borrado correctamente!");
    } else {
        $result = array("STATUS" => "false", "message" => "El producto no se pudo borrar");
    }
    echo json_encode($result);
});


$app->run();