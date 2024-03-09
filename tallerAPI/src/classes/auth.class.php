<?php
require_once 'jwt/JWT.php';
require_once 'src/authModel.php';
require_once 'src/response.php';  // Asegúrate de tener la ruta correcta al archivo Response.php
use Firebase\JWT\JWT;

class Authentication extends AuthModel
{
    // Nombre de la tabla en la base de datos
    private $table = 'personas';

    // Clave secreta para firmar los tokens JWT
    private $key = 'clave_secreta';

    // Método para autenticar a un usuario y generar un token JWT
    public function signIn($user)
    {
        // Validación: Los campos password y username son obligatorios
        if (!isset($user['username']) || !isset($user['password']) || empty($user['username']) || empty($user['password'])) {
            $response = array(
                'result' => 'error',
                'details' => 'Los campos password y username son obligatorios'
            );

            $responseInstance = new Response();
            $responseInstance->result(400, $response);
            exit;
        }

        // Llamada al método login de la clase padre para verificar las credenciales del usuario
        $result = parent::login($user['username'], hash('sha256' , $user['password']));

        // Validación: Verificar si el usuario y la contraseña son correctos
        if (sizeof($result) == 0) {
            $response = array(
                'result' => 'error',
                'details' => 'El usuario y/o la contraseña son incorrectas'
            );

            $responseInstance = new Response();
            $responseInstance->result(403, $response);
            exit;
        }

        // Creación de datos para el token JWT
        $dataToken = array(
            'iat' => time(),
            'data' => array(
                'id' => $result[0]['id'],
                'nombres' => $result[0]['nombres']
            )
        );

        // Generar el token JWT utilizando la clave secreta
        $jwt = JWT::encode($dataToken, $this->key);

        // Actualizar el token en la base de datos para el usuario autenticado
        parent::update($result[0]['id'], $jwt);

        return $jwt; // Retornar el token JWT generado
    }

    // Método para verificar la autenticación mediante un token JWT
    public function verify()
    {
        // Validación: Verificar si se proporcionó la clave de API en la solicitud
        if (!isset($_SERVER['HTTP_API_KEY'])) {
            $response = array(
                'result' => 'error',
                'details' => 'Usted no tiene los permisos para esta solicitud'
            );

            $responseInstance = new Response();
            $responseInstance->result(403, $response);
            exit;
        }

        $jwt = $_SERVER['HTTP_API_KEY'];

        try {
            // Decodificar y verificar el token JWT utilizando la clave secreta
            $data = JWT::decode($jwt, $this->key, array('HS256'));

            // Obtener información del usuario desde la base de datos
            $user = parent::getById($data->data->id);

            // Validar si el token almacenado en la base de datos coincide con el proporcionado
            if ($user[0]['token'] != $jwt) {
                throw new Exception();
            }

            return $data; // Retornar los datos decodificados del token JWT
        } catch (\Throwable $th) {
            // Manejar cualquier excepción que ocurra durante la verificación del token
            $response = array(
                'result' => 'error',
                'details' => 'No tiene los permisos para esta solicitud'
            );

            $responseInstance = new Response();
            $responseInstance->result(403, $response);
            exit;
        }
    }
}
?>
