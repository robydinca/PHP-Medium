<?php

require_once 'db.class.php';
require_once 'ModeloController.php';
require_once 'api.REST.class.php';
require_once 'auth.php';
require_once 'authModel.php';

// Configuración de la conexión a la base de datos (deberías ajustar esto según tu configuración)

$servername = "172.21.0.2";
$username = "root";
$password = "root";
$dbname = "rest";

$db = new DB($servername, $username, $password, $dbname);

$modeloController = new ModeloController($db);

$auth = new authModel($db);



$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
$endpoint = isset($request_uri[1]) ? $request_uri[1] : '';
$MiApi = new apiREST($modeloController, 'modelo');

$apiKey = null;

if($apiKey = $_SERVER['HTTP_API_KEY'] != null){
    if($auth->validarToken($apiKey)){
        header("HTTP/1.1 200 OK");
        echo "validado";
    }else{
        header("HTTP/1.1 401 No autorizado");
        echo "No autorizado";
    }
}else{
    header("HTTP/1.1 401 No autorizado");
    echo "No hay credenciales :";
    exit;
    
}
    

   // 







$MiApi->action($endpoint);



?>
