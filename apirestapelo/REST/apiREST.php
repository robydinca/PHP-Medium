<?php
require_once 'vendor/autoload.php';
use \Firebase\JWT\JWT;
require_once 'ModeloController.php';

function generateSecretKey($length = 32)
{
    return bin2hex(random_bytes($length));
}

// Genera una clave secreta de 32 caracteres (256 bits) y la almacena en una constante SECRET_KEY
define('SECRET_KEY', generateSecretKey());



class apiREST
{
    private $controller;
    private $resource;

    public function __construct($controller, $resource)
    {
        $this->controller = $controller;
        $this->resource = $resource;
    }

    public function action($endpoint)
    {
        session_start();
    
        // Verifica si el usuario está autenticado, excepto para el endpoint 'api/login'
        if (!($endpoint === 'api/login')) {
            if (!isset($_SESSION['authenticated_user'])){
                $this->errorResponse('Unauthorized', 401);
            }
        }
    
        $method = $_SERVER['REQUEST_METHOD'];
    
        switch ($method) {
            case 'GET':
                if ($endpoint === 'api/modelo/') {
                    $this->index();
                } elseif (preg_match('/modelo\/(\d+)/', $endpoint, $matches)) {
                    $numero = $matches[1];
                    $this->show($numero);
                } else {
                    var_dump($method);
                    $this->errorResponse('Invalid endpoint for GET request');
                }
                break;
    
            case 'POST':
                if ($endpoint === 'api/login') {
                    $this->login();
                } elseif ($endpoint === 'api/modelo/store') {
                    $this->store();
                } else {
                    $this->errorResponse('Invalid endpoint for POST request');
                }
                break;
    
            case 'DELETE':
                // Utilizar expresión regular para extraer el número después de "/destroy/"
                if (preg_match('/\/destroy\/(\d+)/', $endpoint, $matches)) {
                    $this->destroy($matches[1]);
                } elseif ($endpoint === 'api/modelo/') {
                    $this->errorResponse('Invalid endpoint for DELETE request');
                } else {
                    $this->errorResponse('Invalid endpoint for DELETE request');
                }
                break;
    
            default:
                $this->errorResponse('Invalid request method');
                break;
        }
    
        session_destroy();
    }
    
    private function authenticate($username, $password)
    {
        // Llama a tu controlador de usuario para verificar las credenciales
        $user = $this->controller->getUserByUsername($username);
        // Compara la contraseña sin verificar la contraseña hash
        if ($user && $password === $user['password']) {
            // Autenticación exitosa
            return true;
        } else {
            // Autenticación fallida
            print_r("Autenticación fallida");
            return false;
        }
    }
    
    
    private function generateToken($userId)
    {
        $token = [
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => time(),
            "exp" => time() + (60 * 60), // Caducidad del token en 1 hora
            "userId" => $userId
        ];
    
        return JWT::encode($token, SECRET_KEY, 'HS256');
    }
    
    private function verifyToken($token)
    {
        try {
            print_r("verifyToken");
            var_dump($token);
            $decoded = JWT::decode($token, SECRET_KEY, array('HS256'));
            return $decoded->userId;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    private function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['username']) || empty($_POST['password'])) {
            $this->errorResponse('Invalid request', 400);
        }
    
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        // Realizar la autenticación contra la base de datos
        if ($this->authenticate($username, $password)) {
            // Autenticación exitosa, generar un nuevo token temporal de una hora
            $token = $this->generateToken($username);
            $this->controller->saveToken($username, $token);
    
            // Crear una variable de sesión para indicar que el usuario está autenticado
            session_start();
            $_SESSION['authenticated_user'] = $username;
    
            $this->jsonResponse(['token' => $token, 'message' => 'Login completed successfully']);
        } else {
            // Fallo de autenticación
            $this->errorResponse('Invalid username or password', 401);
        }
    }
    
    
    

    private function index()
    {
        $data = $this->controller->getAll();
        $this->jsonResponse($data);
    }

    private function show($id)
    {
        $data = $this->controller->getById($id);
        $this->jsonResponse($data);
    }
    private function store() {
        // Obtener datos del formulario POST
        $name = $_POST['name'];
        $brand = $_POST['brand'];
        $year = $_POST['year'];
    
        // Crear un array asociativo con los datos
        $postData = array(
            "name" => $name,
            "brand" => $brand,
            "year" => $year
        );
    
        // Llamar al controlador para crear el modelo
        $data = $this->controller->create($postData);
    
        // Responder con un JSON válido
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    
    private function destroy($id)
    {
        $success = $this->controller->delete($id);

        if ($success) {
            $this->jsonResponse(['success' => true]);
        } else {
            $this->errorResponse('Failed to delete resource');
        }
    }

    
private function getAuthorizationToken($username)
{
    // Obtener el token del usuario desde la base de datos
    $token = $this->controller->getTokenByUsername($username);
    var_dump($token);
    // Verificar si se encontró un token válido
    if ($this->verifyToken($token)) {
        return $token;
    }

    return null;
}

    private function jsonResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    private function errorResponse($message)
    {
        $this->jsonResponse(['error' => $message]);
        exit;
    }
}
