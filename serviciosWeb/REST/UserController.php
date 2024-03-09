<?php

class UserController {

  private $conn;

  public function __construct($conn) {
    $this->conn = $conn;
  }

  public function login($username, $password) {
    $query = "SELECT id, nombres, username FROM personas WHERE username = '$username' AND password = '$password'";
    $result = $this->conn->query($query);

    if (!$result) {
      return $this->handleError();
    }

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $user = new User($row['id'], $row['nombres'], $row['username'], null, null);
      return $user->getValues();
    }

    return null;
  }


  public function getAllUsers()
  {
      $query = "SELECT * FROM users";
      $result = $this->conn->query($query);

      if (!$result) {
          return $this->handleError();
      }

      $users = array();
      while ($row = $result->fetch_assoc()) {
          $user = new User($row['username'], $row['password'], $row['token'], $row['nombres'], $row['id']);
          $users[] = $user->getValues();
      }

      return $users;
  }

  public function getUserById($id)
  {
      $query = "SELECT * FROM users WHERE id = $id";
      $result = $this->conn->query($query);

      if (!$result) {
          return $this->handleError();
      }

      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $user = new User($row['username'], $row['password'], $row['token'], $row['nombres'], $row['id']);
          return $user->getValues();
      }

      return null;
  }

  public function createUser($username, $password, $nombres)
  {
      // Supongo que el campo 'token' se genera automáticamente en la base de datos
      $query = "INSERT INTO users (username, password, nombres) VALUES ('$username', '$password', '$nombres')";
      $result = $this->conn->query($query);

      if (!$result) {
          return $this->handleError();
      }

      return $this->getUserById($this->conn->getInsertId());
  }

  public function updateUser($id, $username, $password, $nombres)
  {
      $query = "UPDATE users SET username = '$username', password = '$password', nombres = '$nombres' WHERE id = $id";
      $result = $this->conn->query($query);

      if (!$result) {
          return $this->handleError();
      }

      return $this->getUserById($id);
  }

  public function deleteUser($id)
  {
      // Utilizar una sentencia preparada para evitar la inyección SQL
      $query = "DELETE FROM users WHERE id = ?";

      // Preparar la sentencia
      $stmt = $this->conn->prepare($query);

      if (!$stmt) {
          // Manejar el error de preparación
          return $this->handleError();
      }

      // Vincular el parámetro
      $stmt->bind_param("i", $id);

      // Ejecutar la sentencia
      $result = $stmt->execute();

      // Cerrar la sentencia preparada
      $stmt->close();

      if (!$result) {
          // Manejar el error de ejecución
          return $this->handleError();
      }

      return true;
  }



  private function handleError() {
    return ['error' => $this->conn->getError()];
}
}