<?php
require_once 'src/response.php';
require_once 'src/database.php';

class User extends Database
{
    // Nombre de la tabla en la base de datos
    private $table = 'personas';

    // Campos permitidos para condiciones en la operación GET
    private $allowedConditions_get = array(
        'id',
        'nombres',
        'disponible',
        'page'
    );

    // Campos permitidos para condiciones en la operación INSERT
    private $allowedConditions_insert = array(
        'nombres',
        'disponible'
    );

    // Método para validar los datos antes de realizar una operación
    private function validate($data)
    {
        $responseInstance = new Response();

        // Validación: El campo "nombres" es obligatorio
        if (!isset($data['nombres']) || empty($data['nombres'])) {
            $response = array(
                'result' => 'error',
                'details' => 'El campo nombre es obligatorio'
            );

            $responseInstance->result(400, $response);
            exit;
        }

        // Validación: El campo "disponible" debe ser del tipo boolean
        if (isset($data['disponible']) && !($data['disponible'] == "1" || $data['disponible'] == "0")) {
            $response = array(
                'result' => 'error',
                'details' => 'El campo disponible debe ser del tipo boolean'
            );

            $responseInstance->result(400, $response);
            exit;
        }

        return true; // Validación exitosa
    }

    // Método para obtener datos de la base de datos según los parámetros proporcionados
    public function get($params)
    {
        $responseInstance = new Response();

        // Validación de los parámetros permitidos
        foreach ($params as $key => $param) {
            if (!in_array($key, $this->allowedConditions_get)) {
                unset($params[$key]);
                $response = array(
                    'result' => 'error',
                    'details' => 'Error en la solicitud'
                );

                $responseInstance->result(400, $response);
                exit;
            }
        }

        // Obtener datos de la base de datos utilizando el método getDB de la clase padre
        $usuarios = parent::getDB($this->table, $params);

        return $usuarios;
    }

    // Método para insertar nuevos registros en la base de datos
    public function insert($params)
    {
        $responseInstance = new Response();

        // Validación de los campos permitidos para la operación INSERT
        foreach ($params as $key => $param) {
            if (!in_array($key, $this->allowedConditions_insert)) {
                unset($params[$key]);
                $response = array(
                    'result' => 'error',
                    'details' => 'Error en la solicitud'
                );

                $responseInstance->result(400, $response);
                exit;
            }
        }

        // Validación adicional de los datos antes de la inserción
        if ($this->validate($params)) {
            // Llamada al método insertDB de la clase padre para realizar la inserción
            return parent::insertDB($this->table, $params);
        }
    }

    // Método para actualizar registros en la base de datos
    public function update($id, $params)
    {
        $responseInstance = new Response();

        // Validación de los campos permitidos para la operación UPDATE
        foreach ($params as $key => $parm) {
            if (!in_array($key, $this->allowedConditions_insert)) {
                unset($params[$key]);
                $response = array(
                    'result' => 'error',
                    'details' => 'Error en la solicitud'
                );

                $responseInstance->result(400, $response);
                exit;
            }
        }

        // Validación adicional de los datos antes de la actualización
        if ($this->validate($params)) {
            // Llamada al método updateDB de la clase padre para realizar la actualización
            $affected_rows = parent::updateDB($this->table, $id, $params);

            // Verificación de cambios realizados
            if ($affected_rows == 0) {
                $response = array(
                    'result' => 'error',
                    'details' => 'No hubo cambios'
                );

                $responseInstance->result(200, $response);
                exit;
            }
        }
    }

    // Método para eliminar registros de la base de datos
    public function delete($id)
    {
        $responseInstance = new Response();

        // Llamada al método deleteDB de la clase padre para realizar la eliminación
        $affected_rows = parent::deleteDB($this->table, $id);

        // Verificación de cambios realizados
        if ($affected_rows == 0) {
            $response = array(
                'result' => 'error',
                'details' => 'No hubo cambios'
            );

            $responseInstance->result(200, $response);
            exit;
        }
    }
}
?>
