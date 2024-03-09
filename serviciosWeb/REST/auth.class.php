<?php
require_once 'jwt/JWT.php';
use Firebase\JWT\JWT;

class Auth
{
    private $key = 'my_secret_key';

    public function generateToken($data)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // Token válido por 1 hora
        $token = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $data,
        ];
        return JWT::encode($token, $this->key, 'HS256');
    }

    public function verifyToken($token)
    {
        try {
            $decoded = JWT::decode($token, $this->key, array('HS256'));

            // Manejar diferentes formatos del campo 'data' en el token decodificado
            if (is_object($decoded->data)) {
                return json_decode(json_encode($decoded->data), true);
            } elseif (is_array($decoded->data)) {
                return $decoded->data;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null; // Token inválido
        }
    }
}
