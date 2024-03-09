<?php
require_once "./config.php";
require_once "./Users.php";

$conexion = new mysqli(HOST, USER, PASSWORD, DB, PORT);

if ($conexion->connect_errno) {
    die("Error de conexión: " . $conexion->connect_error);
}

$users = new Users($conexion);
$mensaje = "";

if (isset($_POST['enviar'])) {
    $salt = random_int(-1000000, 1000000);

    $login = mysqli_real_escape_string($conexion, $_POST['login']);
    $password = mysqli_real_escape_string($conexion, hash('sha256', $_POST['password'] . $salt));
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido1 = mysqli_real_escape_string($conexion, $_POST['apellido1']);
    $apellido2 = mysqli_real_escape_string($conexion, $_POST['apellido2']);
    $avatar = '';


    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $tipo = $_FILES['avatar']['type'];
        if ($tipo == "image/jpeg" || $tipo == "image/png") {
            $nombreArchivoGuardado = $login;
            $rutaDestino = './imagenes/' . $nombreArchivoGuardado;
    
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $rutaDestino)) {
                $avatar = mysqli_real_escape_string($conexion, $rutaDestino);
            } else {
                $mensajeImagen = "Hubo un error al subir el archivo de imagen.";
            }
        } else {
            $mensajeImagen = "El archivo debe ser de tipo JPEG o PNG.";
        }
    }

    $datosUser = array(
        'login' => $login,
        'password' => $password,
        'salt' => $salt,
        'nombre' => $nombre,
        'apellido1' => $apellido1,
        'apellido2' => $apellido2,
        'avatar' => $avatar 
    );

    if ($users->insertar($datosUser)) {
        $mensaje = "Usuario insertado correctamente";
    } else {
        $mensaje = "Hubo un error al insertar el usuario en la base de datos.";
    }
} else {
    $mensaje = "Por favor, complete todos los campos del formulario.";
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
</head>

<body>
    <h1>Formulario de Registro</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="login">Login</label>
        <input type="text" name="login" id="login">
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <br>
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre">
        <br>
        <label for="apellido1">Apellido 1</label>
        <input type="text" name="apellido1" id="apellido1">
        <br>
        <label for="apellido2">Apellido 2</label>
        <input type="text" name="apellido2" id="apellido2">
        <br>
        <label for="avatar">Avatar</label>
        <input type="file" name="avatar" id="avatar">
        <br>
        <input type="submit" value="enviar" name="enviar">
    </form>
    <?php echo $mensajeImagen; ?>
    <?php echo $mensaje; ?>
    <a href="index.php">Volver</a>
</body>

</html>