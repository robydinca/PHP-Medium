<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php
  if (!file_exists("./config/config.php")) {
    header("Location: ./config/install.php");
  } else {
    header ("Location index.php");
  }
  ?>
  <h1>TodoBetter</h1>
</body>
</html>