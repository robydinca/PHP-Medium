<?php

class Database
{
    private $connection;
    private $results_page = 50;

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

    // Método para obtener datos de la base de datos.
    public function getDB($table, $extra = null)
    {
        $page = 0;
        $query = "SELECT * FROM $table";

        // Si se proporciona el parámetro 'page', se configura la paginación.
        if (isset($extra['page'])) {
            $page = $extra['page'];
            unset($extra['page']); // Elimina 'page' del array de condiciones adicionales.
        }

        // Construye la cláusula WHERE con las condiciones adicionales si las hay.
        if ($extra != null) {
            $query .= ' WHERE';

            foreach ($extra as $key => $condition) {
                $query .= ' ' . $key . ' = "' . $condition . '"';
                if ($extra[$key] != end($extra)) {
                    $query .= " AND ";
                }
            }
        }

        // Configura la limitación de resultados según la paginación.
        if ($page > 0) {
            $since = (($page - 1) * $this->results_page);
            $query .= " LIMIT $since, $this->results_page";
        } else {
            $query .= " LIMIT 0, $this->results_page";
        }

        // Ejecuta la consulta SQL y recupera los resultados en un array asociativo.
        $results = $this->connection->query($query);
        $resultArray = array();

        foreach ($results as $value) {
            $resultArray[] = $value;
        }

        return $resultArray;
    }

    // Método para insertar datos en la base de datos.
    public function insertDB($table, $data)
    {
        // Construye las cláusulas de campos y valores para la consulta SQL de inserción.
        $fields = implode(',', array_keys($data));
        $values = '"';
        $values .= implode('","', array_values($data));
        $values .= '"';

        // Ejecuta la consulta SQL de inserción y devuelve el ID del último registro insertado.
        $query = "INSERT INTO $table (" . $fields . ') VALUES (' . $values . ')';
        $this->connection->query($query);

        return $this->connection->insert_id;
    }

    // Método para actualizar datos en la base de datos.
    public function updateDB($table, $id, $data)
    {
        // Construye la cláusula SET de la consulta SQL de actualización.
        $query = "UPDATE $table SET ";

        foreach ($data as $key => $value) {
            $query .= "$key = '$value'";
            if (sizeof($data) > 1 && $key != array_key_last($data)) {
                $query .= " , ";
            }
        }

        // Añade la cláusula WHERE para actualizar el registro específico.
        $query .= ' WHERE id = ' . $id;

        // Ejecuta la consulta SQL de actualización y verifica si hubo cambios.
        $this->connection->query($query);

        if (!$this->connection->affected_rows) {
            return 0; // No hubo cambios.
        }

        return $this->connection->affected_rows;
    }

    // Método para eliminar un registro de la base de datos.
    public function deleteDB($table, $id)
    {
        // Construye la cláusula WHERE de la consulta SQL de eliminación.
        $query = "DELETE FROM $table WHERE id = $id";

        // Ejecuta la consulta SQL de eliminación y verifica si se eliminó algún registro.
        $this->connection->query($query);

        if (!$this->connection->affected_rows) {
            return 0; // No hubo cambios.
        }

        return $this->connection->affected_rows;
    }
}

?>
