<?php
require_once 'Modelo.class.php';

class ModeloController {
    private DB $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll() {
        $query = "SELECT * FROM modelos";
        $result = $this->conn->query($query);

        $modelos = array();
        while ($row = $result->fetch_assoc()) {
            $modelo= new Modelo($row['id'], $row['name'], $row['brand'], $row['year']);
            $modelos[] = $modelo->getValues();
        }

        return $modelos;
    }

    public function getById($id) {
        $query = "SELECT * FROM modelos WHERE id = $id";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $modelo=new Modelo($row['id'], $row['name'], $row['brand'], $row['year']);
            return $modelo->getValues();
        }

        return null;
    }

    public function createModelo($name, $brand, $year) {
        $query = "INSERT INTO modelos (name, brand, year) VALUES ('$name', '$brand', '$year')";
        $result = $this->conn->query($query);

        if ($result) {
            return $this->getById($this->conn->getInsertId());
        }

        return null;
    }
    public function create($modelo) {
        $query = "INSERT INTO modelos (name, brand, year) VALUES ('".$modelo['name']."', '".$modelo['brand']."', '".$modelo['year']."')";
        $result = $this->conn->query($query);

        if ($result) {
            return $this->getById($this->conn->getInsertId());
        }

        return null;
    }
    public function update($array, $id) {
        $query = "UPDATE modelos SET name = '".$array['name']."', brand = '".$array['brand']."', year = '".$array['year']."' WHERE id = $id;";
        $result = $this->conn->query($query);

        if ($result) {
            return $this->getById($id);
        }

        return null;
    }
    public function updateModelo($id, $name, $brand, $year) {
        $query = "UPDATE modelos SET name = '$name', brand = '$brand', year = '$year' WHERE id = $id";
        $result = $this->conn->query($query);

        if ($result) {
            return $this->getById($id);
        }

        return null;
    }
    public function delete($id) {
        $query = "DELETE FROM modelos WHERE id = $id";
        $result = $this->conn->query($query);

        if ($result) {
            return true;
        }

        return false;
    }
    
}
?>
