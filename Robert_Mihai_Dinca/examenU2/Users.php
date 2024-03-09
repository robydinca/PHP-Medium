<?php
class Users {
    private $conexion;

    private function limpiarDatos($datosUser){
        $datosLimpio = array();
        foreach ($datosUser as $key => $value) {
            $datosLimpio[$key] = $this->conexion->real_escape_string($value);
        }
        return $datosLimpio;
    }

    public function __construct($conexion = NULL){
      $this->conexion = $conexion;

  }

  public function insertar($datosUser) {
    $datosUser = $this->limpiarDatos($datosUser);

    $consulta = "INSERT INTO users (login, password, salt, nombre, apellido1, apellido2, avatar) VALUES ('".$datosUser['login']."', '".$datosUser['password']."', '".$datosUser['salt']."', '".$datosUser['nombre']."', '".$datosUser['apellido1']."', '".$datosUser['apellido2']."', '".$datosUser['avatar']."');";
        
    return $this->conexion->query($consulta);
  
  }

  public function listar($login = NULL){
    if ($login != NULL){
        $consulta = "SELECT * FROM users WHERE login = $login;";
        $resultado = $this->conexion->query($consulta);
        return $resultado->fetch_all(MYSQLI_ASSOC);
        if ($resultado) {
            return $resultado->fetch_assoc();
        }
    } else {
        $consulta = "SELECT * FROM users;";
        $resultado = $this->conexion->query($consulta);

        if ($resultado) {
            $data = array();
            while ($row = $resultado->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }

    return false;
  }


  public function borrar($login) {
    // Utilizar una consulta preparada
    $consulta = $this->conexion->prepare("DELETE FROM users WHERE login = ?");
    $consulta->bind_param("s", $login);

    if ($consulta->execute()) {
        return true; // Éxito al eliminar el registro
    } else {
        return false; // Error al eliminar el registro
    }
}
}

?>