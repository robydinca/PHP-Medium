<?php
require_once 'modelo.php';

class ModeloController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        $query = "SELECT * FROM modelos";
        $result = $this->conn->query($query);

        if (!$result) {
            return $this->handleError();
        }

        $modelos = array();
        while ($row = $result->fetch_assoc()) {
            $modelo = new Modelo($row['id'], $row['name'], $row['brand'], $row['year']);
            $modelos[] = $modelo->getValues();
        }

        return $modelos;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM modelos WHERE id = $id";
        $result = $this->conn->query($query);

        if (!$result) {
            return $this->handleError();
        }

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $modelo = new Modelo($row['id'], $row['name'], $row['brand'], $row['year']);
            return $modelo->getValues();
        }

        return null;
    }

    public function createModelo($name, $brand, $year)
    {
        $query = "INSERT INTO modelos (name, brand, year) VALUES ('$name', '$brand', '$year')";
        $result = $this->conn->query($query);

        if (!$result) {
            return $this->handleError();
        }

        return $this->getById($this->conn->getInsertId());
    }

    public function create($modelo)
    {
        $query = "INSERT INTO modelos (name, brand, year) VALUES ('" . $modelo['name'] . "', '" . $modelo['brand'] . "', '" . $modelo['year'] . "')";
        $result = $this->conn->query($query);

        if (!$result) {
            return $this->handleError();
        }

        return $this->getById($this->conn->getInsertId());
    }

    public function update($array, $id)
    {
        $query = "UPDATE modelos SET name = '" . $array['name'] . "', brand = '" . $array['brand'] . "', year = '" . $array['year'] . "' WHERE id = $id";
        $result = $this->conn->query($query);

        if (!$result) {
            return $this->handleError();
        }

        return $this->getById($id);
    }

    public function updateModelo($id, $name, $brand, $year)
    {
        $query = "UPDATE modelos SET name = '$name', brand = '$brand', year = '$year' WHERE id = $id";
        $result = $this->conn->query($query);

        if (!$result) {
            return $this->handleError();
        }

        return $this->getById($id);
    }

    public function delete($id)
    {
        // Utilizar una sentencia preparada para evitar la inyección SQL
        $query = "DELETE FROM modelos WHERE id = ?";

        // Preparar la sentencia
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            // Manejar el error de preparación
            return $this->handleError();
        }

        // Vincular el parámetro
        $stmt->bind_param("i", $id);

        // Ejecutar la sentencia
        $result = $stmt->execute();

        // Cerrar la sentencia preparada
        $stmt->close();

        if (!$result) {
            // Manejar el error de ejecución
            return $this->handleError();
        }

        return true;
    }


    public function createUser($username, $password, $nombres)
    {
        // Hash de la contraseña antes de almacenarla
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password, nombres) VALUES (?, ?, ?)";

        // Preparar la sentencia
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return $this->handleError();
        }

        // Vincular los parámetros
        $stmt->bind_param("sss", $username, $hashedPassword, $nombres);

        // Ejecutar la sentencia
        $result = $stmt->execute();

        // Cerrar la sentencia preparada
        $stmt->close();

        if (!$result) {
            return $this->handleError();
        }

        return true;
    }

    public function getUserByUsername($username)
    {
        $query = "SELECT username, password FROM users WHERE username = ?";
    
        // Preparar la sentencia
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            return $this->handleError();
        }
    
        // Vincular el parámetro
        $stmt->bind_param("s", $username);
    
        // Ejecutar la sentencia
        $stmt->execute();
    
        // Obtener el resultado
        $result = $stmt->get_result();
    
        // Cerrar la sentencia preparada
        $stmt->close();
    
        if (!$result) {
            return $this->handleError();
        }
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
    
        return null;
    }
    


    // Otros métodos CRUD y manejo de tokens aquí...

    public function getTokenByUsername($username)
    {
        $query = "SELECT token FROM users WHERE username = ?";
    
        // Preparar la sentencia
        $stmt = $this->conn->prepare($query);
        var_dump($username);
    
        if (!$stmt) {
            return $this->handleError();
        }
    
        // Vincular el parámetro
        $stmt->bind_param("s", $username);
    
        // Ejecutar la sentencia
        $stmt->execute();
    
        // Obtener el resultado
        $result = $stmt->get_result();

    
        // Cerrar la sentencia preparada
        $stmt->close();
    
        if (!$result) {
            return $this->handleError();
        }
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['token'];
        }
    
        return null;
    }
    

    public function saveToken($username, $token)
    {
        $query = "UPDATE users SET token = ? WHERE username = ?";

        // Preparar la sentencia
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            return $this->handleError();
        }

        // Vincular los parámetros
        $stmt->bind_param("ss", $token, $username);

        // Ejecutar la sentencia
        $result = $stmt->execute();
        // Cerrar la sentencia preparada
        $stmt->close();

        if (!$result) {
            return $this->handleError();
        }

        return true;
    }

    private function handleError()
    {
        return ['error' => $this->conn->getError()];
    }
}
