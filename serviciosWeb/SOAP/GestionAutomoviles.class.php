<?php
class GestionAutomoviles
{
  public function obtenerMarcas()
    {
      include 'config.php';
      $db = new mysqli(HOST, USER, PASSWORD, DB, PORT);


      $marcas = array();
      if( $db )
      {
        $result = $db->query('select marca from marcas');
        while( $row = $result->fetch_array() )
          $marcas[] = $row['marca'];
        $db->close();
      }

      return $marcas;
    }
    
    public function obtenerModelos($idMarca)
    {           
      include 'config.php';
      $db = new mysqli(HOST, USER, PASSWORD, DB, PORT);
      $modelos = array();

      if( $marca !== 0 )
      {
        $result = $db->query('select modelo from modelos
                                where marca = ' . $idMarca );
        while( $row = $result->fetch_array() )
            $modelos[] = $row['modelo'];
      }
      $db->close();
      return $modelos;
    }
}
?>