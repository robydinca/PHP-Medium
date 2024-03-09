<?php
/*
 * ejerTabla.php
 * 

 */
 /**************** Insertar ****************************/
 // Incluya mediante un include_once el fichero de configuración	
	include_once "config.php";
  // 1.- Comprobamos que han pulsado el botón Insertar  con un if y función isset()
	if (isset($_POST['Insertar'])) {
  // 2.- Conectamos con la BD
		$conexion=new mysqli($host,$user,$password,$db) or die("Problemas en la conexion".$conexion->connect_error);
  // 3.- Creamos la consulta Insert " Insert into alumnos values (Valores recibidos mediante $_POST del formulario)
		$consulta="INSERT INTO alumnos VALUES ('$_POST[Apellido1]','$_POST[Apellido2]','$_POST[Nombre]','$_POST[DNI]')";
  // 4.- Ejecutamos la consulta Insert en la conexión
		$conexion->query($consulta);
  // 5.- Cerramos la conexión
		$conexion->close();
  // Cerramos el If
	}
  /**************** Borrar una fila *************************/
	
  // 1.- Comprobamos que nos ha llegado el GET de Borrar con un if y funcion isset de $_GET['borrar]
	if (isset($_GET['borrar'])) {
  // 2.- Conectamos con la BD
		$conexion=new mysqli($host,$user,$password,$db) or die("Problemas en la conexion".$conexion->connect_error);
  // 3.- Creamos la consulta DELETE FROM `alumnos` WHERE `DNI` = '$_GET[borrar]' 
		$consulta="DELETE FROM `alumnos` WHERE `DNI` = '$_GET[borrar]'";
  // 4.- Ejecutamos la consulta delete en la conexión
		$conexion->query($consulta);
  // 5.- Cerramos la conexión
		$conexion->close();
  // 6.- Limpiamos la urlsucia que hemos usado para el borrado mediante
  // header("Location:./ejerTabla.php");
		header("Location:./ejerTabla.php");
  // cerramos el if
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<title>Ejercicio de control de tabla con php</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
</head>

<body style="background-color: #4B4B4B; color:white; font-size:24px; font-family:'Courier New', Courier, monospace;">
	<H3>Ejercicio de control de tablas</H3>
	<P>Este ejercicio pretende que ejercite el trabajo más común sobre sistemas de bases de datos y tablas sql desde php para la web. Realice los siguientes puntos
	<li>1.- La carpeta debe de estar en una url alcanzable desde su servidor, su servidor debe tener al menos Apache2, PHP 5.4 y Mysql </li>
	<li>2.- Cree una base de datos en su sistema MariaDB o MySQL. Edite y configure el fichero config.php con los parámetros de su base de datos</li>
	<li>3.- Ejecute el script instalar que le proporciono <a href="instalar.php">instalar.php</a></li>
	<li>4.- Mostrando valores de una tabla: Edite este fichero y vea el div contenido donde tiene que programar el listado</li>
	<li>5.- Insertando valores en una tabla: Edite este fichero y vea el div formulario donde tiene que crear un formulario y luego programar</li>
	<li>6.- Borrando filas de una tabla: Edite este fichero y vea la sección Borrar una fila</li>
	</P>
	
	
	<div id="formulario">
	<!-- Cree un formulario POST con cinco input con atributo name  Apellido1, Apellido2, Nombre, DNI y el ultimo debe ser un input submt con el name Insertar. 
		Una vez cree  el formulario dirijase al comentario Insertar al principio del documento
	-->
		<form action="ejerTabla.php" method="post">
			<label for="Apellido1">Apellido1</label>
			<input type="text" name="Apellido1" id="Apellido1" />
			<br>
			<label for="Apellido2">Apellido2</label>
			<input type="text" name="Apellido2" id="Apellido2" />
			<br>
			<label for="Nombre">Nombre</label>
			<input type="text" name="Nombre" id="Nombre" />
			<br>
			<label for="DNI">DNI</label>
			<input type="text" name="DNI" id="DNI" />
			<br>
			<input type="submit" name="Insertar" id="Insertar" />
		</form>
	
	</div>
	
	
	
	
	<div id="contenido">
	<?php
		// 0. Incluya mediante un include_once el fichero de configuración
		include_once "config.php";
	    // 1. Conecte con la base de datos
		$conexion=new mysqli($host,$user,$password,$db) or die("Problemas en la conexion".$conexion->connect_error);
	    // 2.- Cree una variable llamada $consulta para obtener todos los registros de la tabla alumnos ordenados por Apellido1, Apellido2, Nombre
		$consulta="SELECT * FROM alumnos ORDER BY Apellido1, Apellido2, Nombre";
	    // 3.- Mande a ejecutar esta consulta a su servidor mediante la conexión que creó en 1 y asigne el resultado a una variable llamada $datos, donde se almacenarán los registros devueltos.
		$datos=$conexion->query($consulta);
	    // 4.- Recorremos los registros devueltos mediante un bucle de tipo while
		while ($fila = $datos -> fetch_array(MYSQLI_ASSOC)) {
   			// Crearemos un párrafo para la fila obtenida poniendo Apellido 1, Apellido2, Nombre y DNI.
    		// Al final del párrafo, pondremos un enlace así <a href='?borrar={$fila['DNI']}'>borrar</a>.
			// Esto enviará la primary key mediante GET para el borrado.
			echo "<p>".$fila['Apellido1']." ".$fila['Apellido2']." ".$fila['Nombre']." ".$fila['DNI']." <a href='?borrar={$fila['DNI']}'>borrar</a></p>";
		}
	    // 5.- Cerramos la conexión
		$conexion->close();

	?>
	</div>
	
</body>

</html>
