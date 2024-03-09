<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>Ejemplo PHPlot</h1>
  <h2>waaaa</h2>
  <?php

  // Incluye la clase PHPlot
  require_once 'vendor/phplot/phplot/src/phplot.php';
  require_once 'vendor/autoload.php';
  use PHPlot\PHPlot\phplot;

  // Datos para el gráfico
  $data = array(
    array('A', 10),
    array('B', 20),
    array('C', 15),
    array('D', 30),
  );

  // Crea una instancia de PHPlot
  $plot = new PHPlot(800, 600);

  // Configura el gráfico
  $plot->SetTitle('Ejemplo de Gráfico PHPlot');
  $plot->SetXTitle('Eje X');
  $plot->SetYTitle('Eje Y');

  $plot->SetDataValues($data);

  $plot->SetDataType('text-data');
  
  $plot->SetPlotType('bars');

  // Dibuja el gráfico
  $plot->DrawGraph();

  ?>
</body>

</html>
