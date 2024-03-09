<?php
require_once "config.php";
require_once "Users.php";

$conexion = new mysqli(HOST, USER, PASSWORD, DB, PORT);
if ($conexion->connect_errno) {
    die("Error de conexión: " . $conexion->connect_error);
}

$mensaje = '';  
$users = new Users($conexion);

if (isset($_GET['borrar'])) {
  $login = $_GET['borrar'];
  $resultado = $users->borrar($login);

  if ($resultado) {
    $mensaje = "Usuario borrado correctamente";
  } else {
    $mensaje = "Error al borrar el usuario";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Listado de Usuarios</h1>
  <table border="1px">
    <tr>
      <th>Login</th>
      <th>Password</th>
      <th>Salt</th>
      <th>Nombre</th>
      <th>Apellido1</th>
      <th>Apellido2</th>
      <th>Avatar</th>
    </tr>

    <?php
    $todosLosUsers = $users->listar();
    foreach ($todosLosUsers as $user) {
      echo "<tr>";
      echo "<td>" . $user['login'] . "</td>";
      echo "<td>" . $user['password'] . "</td>";
      echo "<td>" . $user['salt'] . "</td>";
      echo "<td>" . $user['nombre'] . "</td>";
      echo "<td>" . $user['apellido1'] . "</td>";
      echo "<td>" . $user['apellido2'] . "</td>";
      echo "<td><img style='width:150px; height:100px;' src='" . $user['avatar'] . "' alt='Avatar'></td>";
      echo "<td><a href='?borrar={$user['login']}'>Borrar</a></td>";
      echo "</tr>";
    }
    ?>
  </table>
  <?php echo $mensaje; ?>
  <a href="index.php">Volver</a>
</body>
</html>
