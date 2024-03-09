<?php
require_once 'src/classes/user.class.php';
require_once 'src/classes/auth.class.php';
require_once 'src/response.php';

// Crear una instancia de la clase de autenticación
$auth = new Authentication();

// Analizar el método de solicitud HTTP (en este caso, solo se maneja POST)
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        // Decodificar los datos JSON del cuerpo de la solicitud POST
        $user = json_decode(file_get_contents('php://input'), true);

        // Intentar iniciar sesión y obtener un token
        $token = $auth->signIn($user);

        // Construir una respuesta con el resultado de la operación
        $response = array(
            'result' => 'ok',
            'token' => $token
        );

        // Instanciar un objeto de la clase Response
        $responseInstance = new Response();
        // Llamar al método result en esa instancia para enviar la respuesta con el código de estado HTTP 201 (Created)
        $responseInstance->result(201, $response);

        break;
}
?>
