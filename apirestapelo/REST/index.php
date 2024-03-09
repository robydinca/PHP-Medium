<?php
require_once 'DB.php';
require_once 'ModeloController.php';
require_once 'apiREST.php';
require_once 'config.php';

// Configuración de la conexión a la base de datos (deberías ajustar esto según tu configuración)

$db = new mysqli(HOST, USER, PASSWORD, DB, PORT);

$modeloController = new ModeloController($db);


$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
$endpoint = $request_uri[1];
var_dump($endpoint);

$token = $_SERVER['HTTP_API_KEY'];
if ($token==null){
  header ('HTTP/1.1 401 Unauthorized');
  echo "error: credenciales inexistentes";
  exit;
}



$MiApi = new apiREST($modeloController, 'modelo');
$MiApi->action($endpoint);



?>