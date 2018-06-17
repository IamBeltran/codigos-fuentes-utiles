<?php 
	
	//Archivo configurable de conexion a Base de datos

	$servidor = 'localhost';		// Detalles de la conexión de base de datos - Host
	$usuario = 'root';				// Detalles de la conexión de base de datos - Username
	$password = '';					// Detalles de la conexión de base de datos - Password
	$basedatos = 'base';


	$conexion= 		mysql_connect($servidor,$usuario,$password)
	or die("No se pudo realizar la conexion");

	$base_datos=	mysql_select_db($basedatos,$conexion)
	or die("ERROR con la base de datos");


	$conjunto_caracteres = mysql_client_encoding($conexion);	//Saber el tipo de caracteres que tiene el cliente
	$caracteres =mysql_set_charset('utf8',$conexion); 			//Configuracion al UTF8 
	date_default_timezone_set('America/Mexico_City');			// Formateamos la zona horaria
	header('Content-Type: text/html; charset=UTF-8');			//Configuramos los carateres especiales del idioma español	
?>
