<?php

require_once './authModel.php';

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
    $datos = file_get_contents('php://input');

    $user = json_decode($datos,true);

    foreach($user as $key => $value){
        $user[] = $value;
    }

    $conexion = new mysqli('172.21.0.2','root','root','rest','3306');

    $auth = new authModel($conexion);
    $dataUser = $auth->login($user);
    if(!$dataUser){
        header("HTTP/1.1 401 Unauthorized");
        exit;
    }

    $payload = [
        'id' => $dataUser['id'],
        'username' => $dataUser['username']
    ];
    error_log("Estoy aqui :");
    $token = $auth->generarToken($payload,$dataUser['id']);

    if($token){
        header("HTTP/1.1 200 OK");
        echo "$token";
    }else{
        header("HTTP/1.1 500 Internal Server Error");
    }

    


    


    
}