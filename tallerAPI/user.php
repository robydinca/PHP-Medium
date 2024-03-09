<?php
require_once 'src/response.php';
require_once 'src/classes/user.class.php';
require_once 'src/classes/auth.class.php';

// Crear una instancia de la clase de autenticación
$auth = new Authentication();
// Verificar la autenticación
$auth->verify();

// Crear una instancia de la clase de usuario
$user = new User();
// Crear una instancia de la clase de respuesta
$responseInstance = new Response();

// Analizar el método de solicitud HTTP (GET, POST, PUT, DELETE)
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Obtener parámetros de la solicitud GET
        $params = $_GET;
        // Obtener usuarios según los parámetros proporcionados
        $usuarios = $user->get($params);

        // Construir una respuesta con el resultado de la operación
        $response = array(
            'result' => 'ok',
            'usuarios' => $usuarios
        );

        // Enviar la respuesta con el código de estado HTTP 200 (OK)
        $responseInstance->result(200, $response);

        break;

    case 'POST':
        // Obtener datos JSON del cuerpo de la solicitud POST
        $params = json_decode(file_get_contents('php://input'), true);

        // Verificar si los datos se decodificaron correctamente
        if (!isset($params)) {
            // Construir una respuesta de error si los datos son nulos
            $response = array(
                'result' => 'error',
                'details' => 'Error en la solicitud'
            );

            // Enviar la respuesta con el código de estado HTTP 400 (Bad Request)
            $responseInstance->result(400, $response);
            exit; // Finalizar el script después de enviar la respuesta
        }

        // Insertar un nuevo usuario con los datos proporcionados
        $insert_id = $user->insert($params);

        // Construir una respuesta con el resultado de la operación
        $response = array(
            'result' => 'ok',
            'insert_id' => $insert_id
        );

        // Enviar la respuesta con el código de estado HTTP 201 (Created)
        $responseInstance->result(201, $response);

        break;

    case 'PUT':
        // Obtener datos JSON del cuerpo de la solicitud PUT
        $params = json_decode(file_get_contents('php://input'), true);

        // Verificar si los datos, el ID y el parámetro ID no están vacíos
        if (!isset($params) || !isset($_GET['id']) || empty($_GET['id'])) {
            // Construir una respuesta de error si los datos son nulos o falta el ID
            $response = array(
                'result' => 'error',
                'details' => 'Error en la solicitud'
            );

            // Enviar la respuesta con el código de estado HTTP 400 (Bad Request)
            $responseInstance->result(400, $response);
            exit; // Finalizar el script después de enviar la respuesta
        }

        // Actualizar el usuario con el ID proporcionado y los nuevos datos
        $user->update($_GET['id'], $params);

        // Construir una respuesta con el resultado de la operación
        $response = array(
            'result' => 'ok'
        );

        // Enviar la respuesta con el código de estado HTTP 200 (OK)
        $responseInstance->result(200, $response);

        break;

    case 'DELETE':
        // Verificar si el parámetro ID no está vacío
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            // Construir una respuesta de error si falta el parámetro ID
            $response = array(
                'result' => 'error',
                'details' => 'Error en la solicitud'
            );

            // Enviar la respuesta con el código de estado HTTP 400 (Bad Request)
            $responseInstance->result(400, $response);
            exit; // Finalizar el script después de enviar la respuesta
        }

        // Eliminar el usuario con el ID proporcionado
        $user->delete($_GET['id']);

        // Construir una respuesta con el resultado de la operación
        $response = array(
            'result' => 'ok'
        );

        // Enviar la respuesta con el código de estado HTTP 200 (OK)
        $responseInstance->result(200, $response);
        break;

    default:
        // Construir una respuesta de error para métodos de solicitud no admitidos
        $response = array(
            'result' => 'error'
        );

        // Enviar la respuesta con el código de estado HTTP 404 (Not Found)
        $responseInstance->result(404, $response);

        break;
}
?>
