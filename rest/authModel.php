<?php
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class authModel{
    private $conexion;
    private $key = 'miclavesecreta'; 
    public function __construct($conexion)
    {
        $this->conexion=$conexion;
    }

    public function login($datos){
        //echo var_dump($datos);
        $password = hash('sha256',$datos[1]);
        $sql = "SELECT * FROM users WHERE id='$datos[0]' AND password='$password';";
        $resultado = $this->conexion->query($sql);

        
        if($resultado->num_rows > 0){
            $resultado = $resultado->fetch_assoc();
            return $resultado;
        }else{
            return false;
        }
    }

    public function guardarToken($token,$id){
        $sql = "UPDATE users SET token='$token' WHERE id='$id';";

        try{
            $this->conexion->query($sql);
            return true;
        }catch(Exception $e){
            return false;

        }
    }

    public function validarToken($token){
        $decoded = JWT::decode($token, new Key($this->key,'HS256'));
        $id = $decoded->id;
        $username = $decoded->username;

        error_log("id : ".$id);

        $sql = "SELECT * FROM users WHERE id='$id' AND username='$username';";

        $resultado = $this->conexion->query($sql);

        if($resultado->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    public function generarToken($payload,$id){
        $token = JWT::encode($payload,$this->key,'HS256');
        return $this->guardarToken($token,$id) == true ? $token : false;
    }


}

?>