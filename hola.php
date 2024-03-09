<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=<, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        
    //crear un array con las provincias de andalucia

    $andalucia[] = "Granada";
    $andalucia[] = "Almería";
    $andalucia[] = "Málaga"; 
    $andalucia[] = "Jaén";

    echo "<ol>";

    foreach($andalucia as $clave => $valor){
        echo "<li>clave:$clave provincia:$valor</li>";
    }

    echo "</ol>";

    ?>
</body>
</html>