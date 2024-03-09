<?php
if (isset($_POST["host"]) && isset($_POST["usuario"]) && isset($_POST["password"]) && isset($_POST["nombreBaseDatos"])) {
  $host = $_POST["host"];
  $usuario = $_POST["usuario"];
  $password = $_POST["password"];
  $nombreBaseDatos = $_POST["nombreBaseDatos"];
  $puerto = $_POST["puerto"];
  //encripta la contraseña ademas de añadir un salt
  $passwordHash = password_hash($password, PASSWORD_DEFAULT);


  $configContenido = '<?php' . "\n";
  $configContenido .= 'define("HOST", "' . $host . '");' . "\n";
  $configContenido .= 'define("USER", "' . $usuario . '");' . "\n";
  $configContenido .= 'define("PASSWORD", "' . $password . '");' . "\n";
  $configContenido .= 'define("DB", "' . $nombreBaseDatos . '");' . "\n";
  $configContenido .= 'define("PORT", "' . $puerto . '");' . "\n";
  $configContenido .= '?' . '>' . "\n";

  $archivo = fopen("config.php", "w");
  fwrite($archivo, $configContenido);
  fclose($archivo);


  //creacion de tablas
  $conexion = new mysqli($host, $usuario, $password, $nombreBaseDatos, $puerto);
  if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
  }

  $consultas[] =
    "CREATE TABLE IF NOT EXISTS usuarios (
      nombre VARCHAR(50) NOT NULL,
      apellidos VARCHAR(50) NOT NULL,
      salt VARCHAR(20) NOT NULL,
      login VARCHAR(50) NOT NULL PRIMARY KEY,
      email VARCHAR(150) NOT NULL,
      password VARCHAR(512) NOT NULL,
      rol enum('admin', 'bibliotecario', 'user') NOT NULL)";

  $consultas[] =
    "CREATE TABLE IF NOT EXISTS tareas (
    id_tarea INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    contenido VARCHAR(500) NOT NULL,
    fecha DATE NOT NULL,
    estado ENUM('pendiente', 'en proceso', 'finalizada') NOT NULL,
    duracion INT NOT NULL,
    prioridad ENUM('baja', 'media', 'alta') NOT NULL,
    login VARCHAR(50) NOT NULL,
    FOREIGN KEY (login) REFERENCES usuarios(login)
)";

  $consultas[] =
    "CREATE TABLE IF NOT EXISTS cursos (
    id_cursos INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion VARCHAR(500) NOT NULL,
    estado ENUM('pendiente', 'en proceso', 'finalizado') NOT NULL,
    duracion INT NOT NULL,
    prioridad ENUM('baja', 'media', 'alta') NOT NULL,
    login VARCHAR(50) NOT NULL,
    FOREIGN KEY (login) REFERENCES usuarios(login)
)";

  $consultas[] =
    "CREATE TABLE IF NOT EXISTS menus (
    id_menu INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion VARCHAR(500) NOT NULL,
    estado ENUM('pendiente', 'en proceso', 'finalizada') NOT NULL,
    duracion INT NOT NULL,
    login VARCHAR(50) NOT NULL,
    FOREIGN KEY (login) REFERENCES usuarios(login)
)";

  $consultas[] =
    "CREATE TABLE IF NOT EXISTS rutinas (
    id_rutina INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion VARCHAR(500) NOT NULL,
    estado ENUM('pendiente', 'en proceso', 'finalizada') NOT NULL,
    duracion INT NOT NULL,
    login VARCHAR(50) NOT NULL,
    FOREIGN KEY (login) REFERENCES usuarios(login)
)";

  $consultas[] =
    "CREATE TABLE IF NOT EXISTS notas (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
titulo VARCHAR(50) NOT NULL,
contenido VARCHAR(500) NOT NULL,
fecha DATE NOT NULL,
estado ENUM('pendiente', 'en proceso', 'finalizada') NOT NULL,
id_tarea INT ,
FOREIGN KEY (id_tarea) REFERENCES tareas(id_tarea),
id_curso INT ,
FOREIGN KEY (id_curso) REFERENCES cursos(id_cursos),
id_menu INT ,
FOREIGN KEY (id_menu) REFERENCES menus(id_menu),
id_rutina INT ,
FOREIGN KEY (id_rutina) REFERENCES rutinas(id_rutina),
login VARCHAR(50) NOT NULL,
FOREIGN KEY (login) REFERENCES usuarios(login)
)";




  foreach ($consultas as $consulta) {
    if ($conexion->query($consulta) === TRUE) {
      echo "Tabla creada correctamente<br>";
      header ("Location: ./registro.php");
    } else {
      echo "Error al crear la tabla: " . $conexion->error . "<br>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <title>todoBetter</title>
  <link rel="stylesheet" href="./estilos/forms.css">
</head>

<body class="install" style="display:flex; flex-direction:column; padding: 40px;">

  <form action="" method="post" class="installForm">
    <h1>Instalación para el primer usuario Administrador</h1>
    <input type="text" name="host" placeholder="Host" required>
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <input type="text" name="nombreBaseDatos" placeholder="Nombre Base de Datos" required>
    <input type="text" name="puerto" placeholder="Puerto" required>
    <input type="submit" value="Aceptar" class="boton">
  </form>

</body>

</html>