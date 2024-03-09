<?php
class Response
{
    // Método result que toma un código de estado y una respuesta como parámetros
    public function result($code, $response)
    {
        // Establecer el encabezado Content-type a application/json
        header('Content-type: application/json');
        
        // Establecer el código de estado HTTP de la respuesta
        http_response_code($code);
        
        // Convertir la respuesta a formato JSON y enviarla como cuerpo de la respuesta
        echo json_encode($response);
    }
}
?>
