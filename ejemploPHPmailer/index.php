<?php
// Importar las clases necesarias de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluir el archivo autoload.php de Composer para cargar las clases de PHPMailer
require 'vendor/autoload.php';

// Verificar si el formulario ha sido enviado (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear una nueva instancia de PHPMailer
    $mail = new PHPMailer(true); // true para habilitar excepciones

//Luego, configura PHPMailer con los detalles del servidor SMTP, puerto, credenciales de acceso y otros detalles específicos de tu servidor de correo.
    try {
        // Configurar PHPMailer para usar SMTP
        $mail->isSMTP();

        // Configuración del servidor SMTP y credenciales
        $mail->Host = 'smtp.tu_servidor.com'; // Dirección del servidor SMTP
        $mail->SMTPAuth = true; // Habilitar autenticación SMTP
        $mail->Username = 'tu_correo@example.com'; // Nombre de usuario del correo
        $mail->Password = 'tu_contraseña'; // Contraseña del correo
        $mail->SMTPSecure = 'tls'; // Método de seguridad (TLS)
        $mail->Port = 587; // Puerto del servidor SMTP

        // Establecer detalles del correo
        $mail->setFrom('tu_correo@example.com', 'Tu Nombre'); // Remitente
        $mail->addAddress($_POST['destinatario']); // Destinatario del correo
        $mail->Subject = $_POST['asunto']; // Asunto del correo
        $mail->Body = $_POST['mensaje']; // Cuerpo del mensaje

        // Enviar el correo
        $mail->send(); // Método para enviar el correo

        // Mensaje de éxito si se envía correctamente
        echo '¡El correo ha sido enviado correctamente!';
    } catch (Exception $e) {
        // Captura de excepciones en caso de error al enviar el correo
        echo 'Error al enviar el correo: ', $mail->ErrorInfo;
    }
}
?>

<!-- Formulario HTML para enviar el correo -->
<!DOCTYPE html>
<html>
<head>
    <title>Enviar Correo</title>
</head>
<body>
    <h2>Enviar Correo</h2>
    <!-- Formulario para introducir los detalles del correo -->
    <form action="" method="post">
        <!-- Campo para introducir el destinatario -->
        <label for="destinatario">Destinatario:</label><br>
        <input type="email" id="destinatario" name="destinatario" required><br><br>

        <!-- Campo para introducir el asunto -->
        <label for="asunto">Asunto:</label><br>
        <input type="text" id="asunto" name="asunto" required><br><br>

        <!-- Campo para introducir el mensaje -->
        <label for="mensaje">Mensaje:</label><br>
        <textarea id="mensaje" name="mensaje" required></textarea><br><br>

        <!-- Botón para enviar el formulario -->
        <input type="submit" value="Enviar Correo">
    </form>
</body>
</html>




