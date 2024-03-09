<?php

class DB {
    private $conn;

    public function __construct($HOST, $USER, $PASSWORD, $DB, $PORT) {
        require_once 'config.php'; // Incluye el archivo de configuración
        $this->conn = new mysqli(HOST, USER, PASSWORD, DB, PORT);

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }

    public function query($query) {
        $result = $this->conn->query($query);

        if (!$result) {
            die("Error en la consulta: " . $this->conn->error . ". Query: " . $query);
        }

        return $result;
    }

    public function getError() {
        return $this->conn->error;
    }

    public function getAffectedRows() {
        return $this->conn->affected_rows;
    }

    public function getInsertId() {
        return $this->conn->insert_id;
    }
}
?>
