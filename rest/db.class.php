<?php

class DB {
    private $servername;
    private $username;
    private $password;
    private $dbname ;
    private $port;
    private $conn;

    public function __construct($servername, $username, $password, $dbname, $port = 3306) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->port = $port;
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname, $this->port);
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $values = "'" . implode("', '", $data) . "'";

        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        $result = $this->query($query);

        if ($result) {
            return $this->getInsertId();
        } else {
            return false;
        }
    }

    public function getById($table, $id) {
        $query = "SELECT * FROM $table WHERE id = $id";
        $result = $this->query($query);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function getConnection() {
        return $this->conn;
    }
    public function closeConnection() {
        $this->conn->close();
    }
    public function query($query) {
        return $this->conn->query($query);
        
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