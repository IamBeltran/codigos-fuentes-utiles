/* 

Para trabajar con mysqli tienes 2 formas:

	1.- Usarlo de forma procedural
	2.- Usarlo Orientado a Objetos (te lo recomiendo)

Ejemplo  de una consulta en ambas formas


Forma Procedural:

			$con = mysqli_connect("localhost", "usuario", "password", "tu_bd"); 

			verificar la conexion 
			if (mysqli_connect_errno()) {
			echo "Hay error de conexion: ". mysqli_connect_error();
			exit();
			}

			$sql = "SELECT Name, CountryCode FROM City ORDER by ID DESC LIMIT 50,5";

			if ($rs = mysqli_query($con, $sql)) {

	Fetch array asociativo

			while ($fila = mysqli_fetch_assoc($rs)) {
			echo $fila["Name"].' '.$fila["CountryCode"].'<br>';
			}

			Liberamos la memoria asociado al resultado
			 
			mysqli_free_result($result);
			}

	Cerrmos conexion

			mysqli_close($con);


Forma orientada a objetos:



			$mysqli = new mysqli("localhost", "usuario", "password", "tu_bd");

	verificar conexion

			if (mysqli_connect_errno()) {
			echo "Error enconexion: ". mysqli_connect_error();
			exit();
			}

			$sql = "SELECT Name, CountryCode FROM City ORDER by ID DESC LIMIT 50,5";

			if ($rs = $mysqli->query($sql)) {

	Fetch array asociativo

			while ($fila = $rs->fetch_assoc()) {
			echo $fila["Name"].' '.$fila["CountryCode"].'<br>';
			}

	liberamos la memoria asociada al resultado 
			
			$rs->close();
			}

	Cerramos la conexion 
			
			$mysqli->close();

*/