<?php
try {
    $client = new SoapClient(null, array(
        'uri' => 'http://localhost/',
        'location' => 'http://localhost/php/serviciosWeb/servicioWebAutomoviles.php'
    ));

    $marcas = $client->obtenerMarcas();
    
    //formatea la salida en una tabla
    echo "<table border='1'>";
    echo "<tr><th>Marcas</th></tr>";
    foreach ($marcas as $marca) {
        echo "<tr><td>$marca</td></tr>";
    }
    echo "</table>";
    
    $modelos = $client->obtenerModelos(1);

    //formatea la salida en una tabla
    echo "<table border='1'>";
    echo "<tr><th>Modelos</th></tr>";
    foreach ($modelos as $modelo) {
        echo "<tr><td>$modelo</td></tr>";
    }
    echo "</table>";

} catch (SoapFault $e) {
    // Captura y muestra la excepción si ocurre un error SOAP
    echo "Error SOAP: " . $e->getMessage();
    var_dump($e); // Muestra información detallada del error
} catch (Exception $ex) {
    // Captura y muestra otras excepciones
    echo "Error: " . $ex->getMessage();
}
?>
