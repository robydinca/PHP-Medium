<?php

class AuthModel
{
    private $connection;
    
    // Constructor: Establece la conexión con la base de datos al crear una instancia de la clase.
    public function __construct()
    {
        // Conexión a la base de datos MySQL con los parámetros proporcionados.
        $this->connection = new mysqli('172.21.0.2', 'root', '7227', 'automoviles', '3306');

        // Verifica si hay errores de conexión.
        if ($this->connection->connect_errno) {
            echo 'Error de conexión a la base de datos';
            exit;
        }
    }

    // Método para realizar la autenticación de un usuario.
    public function login($username, $password)
    {
        // Construye la consulta SQL para buscar un usuario por nombre de usuario y contraseña.
        $query = "SELECT id, nombres, username FROM personas WHERE username = '$username' AND password = '$password'";

        // Ejecuta la consulta SQL y recupera los resultados en un array asociativo.
        $results = $this->connection->query($query);

        $resultArray = array();

        if ($results != false) {
            foreach ($results as $value) {
                $resultArray[] = $value;
            }
        }

        return $resultArray;
    }

    // Método para actualizar el token de un usuario después de iniciar sesión.
    public function update($id, $token)
    {
        // Construye la consulta SQL para actualizar el token de un usuario específico.
        $query = "UPDATE personas SET token = '$token' WHERE id = $id";

        // Ejecuta la consulta SQL de actualización y verifica si hubo cambios.
        $this->connection->query($query);
        
        if (!$this->connection->affected_rows) {
            return 0; // No hubo cambios.
        }

        return $this->connection->affected_rows;
    }

    // Método para obtener el token de un usuario por su ID.
    public function getById($id)
    {
        // Construye la consulta SQL para obtener el token de un usuario específico.
        $query = "SELECT token FROM personas WHERE id = $id";

        // Ejecuta la consulta SQL y recupera los resultados en un array asociativo.
        $results = $this->connection->query($query);

        $resultArray = array();

        if ($results != false) {
            foreach ($results as $value) {
                $resultArray[] = $value;
            }
        }

        return $resultArray;
    }
}
?>
