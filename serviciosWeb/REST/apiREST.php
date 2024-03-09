<?php
require_once 'auth.class.php';
require_once 'auth.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class apiREST
{
    private $controller;
    private $resource;
    private $auth;



    public function __construct($controller, $resource)
    {
        $this->controller = $controller;
        $this->resource = $resource;
        $this->auth = new Auth();
    }

    public function action($endpoint)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                if ($endpoint === 'api/modelo/') {
                    $this->index();
                } elseif (preg_match('/modelo\/(\d+)/', $endpoint, $matches)) {
                    $numero = $matches[1];
                    $this->show($numero);
                } else {
                    $this->errorResponse('Invalid endpoint for GET request');
                }
                break;

            case 'POST':
                // Verificar token antes de permitir el acceso a otras rutas
                if ($endpoint === 'api/modelo/store') {
                    $this->store();
                }
                if ($endpoint === 'api/auth') {
                    $username = 'user';
                    $password = '1234';
                    
                    
                    $key = 'example_key';
                    $payload = [
                        'exp' => time() + 3600,
                        'data' => '1'
                    ];

                    $jwt = JWT::encode($payload, $key, 'HS256');

                    print_r($jwt);
                    
                } else {
                    $this->errorResponse('Invalid endpoint for POST request');
                }
                break;

            default:
                $this->errorResponse('Invalid request method');
                break;
        }
    }



    private function getBearerToken()
    {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            return trim(str_replace('Bearer', '', $headers['Authorization']));
        }
        return null;
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

    private function store()
    {
        $name = $_POST['name'];
        $brand = $_POST['brand'];
        $year = $_POST['year'];

        $postData = array(
            "name" => $name,
            "brand" => $brand,
            "year" => $year
        );

        $data = $this->controller->create($postData);

        header('Content-Type: application/json');
        echo json_encode($data);
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
