<?php 
include("../includes/conexion.php"); // Se incluye conexion a la base de datos
include("../includes/Evitar-inyeccion.php"); // Se incluye funcion para evitar inyecciones
include("../includes/fechas.php");// Funcion Fecha
session_start();// Se inicia el session_star para crear las sesiones

//Array con los posibles mensajes que se presentaran.
$mensajes = array(  
        0=>"Ingresa tus datos", 
        1=>"Falto ingresar nombre", 
        2=>"Falto ingresar contraseña", 
        3=>"Nombre de usuario no valido",
		4=>"Contraseña no valida", 
        5=>"Bienvenido",);

//Declaracion de variables
$msg="";
$tiempo= date("Y-m-d H:i:s");


// Se comprueba si ya se establecio la variable "MM_insert"
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "Envio")) 
{
		//Si faltan ingresar los dos campos.
		if (($_POST["user"]=="") AND ($_POST["pass"]=="")) 
		{
			$msg=$mensajes['0'];
		}
		//Si falto ingresar el nombre.
		if (($_POST["user"]=="") AND ($_POST["pass"]!="")) 
		{
			$msg=$mensajes['1'];
		}
		//Si falto ingresar la contraseña.
		if (($_POST["user"]!="") AND ($_POST["pass"]=="")) 
		{
			$msg=$mensajes['2'];
		}
		//Si se ingresaron los dos .
		if (($_POST["user"]!="") AND ($_POST["pass"]!="")) 
		{
			$user        =  $_POST['user'];
			$user_clear  =  strtolower(GetSQLValueString($_POST['user'], "text"));
 			$pass_clear  =  GetSQLValueString(md5($_POST['pass']), "text");
			$pass_cookie =  trim(str_replace("'", "", (GetSQLValueString($_POST['pass'], "text"))));
			$user_end    =  trim(str_replace("'", "", $user_clear));
			$pass_end    =  trim(str_replace("'", "", $pass_clear));
			
			
			$consulta= sprintf("SELECT * FROM usuarios WHERE usuario = %s",$user_clear);
			$resultado= mysql_query($consulta,$conexion) or die (mysql_error());
			$fila=mysql_fetch_array($resultado);
			
			

					if (!$fila[0]) //Si el usuario NO existe. 
					{
					$msg=$mensajes['3'];
					}
					else //Usuario logueado correctamente (Falta verificar contraseña)
					{								
								if($fila['5']!=$pass_end && $fila['3']==$user_end)//SI la contraseña no es valide
								{
										$msg=$mensajes['4'];	
								}
								
								if($fila['5']==$pass_end && $fila['3']==$user_end)//Si la contraseña y usuarios son validos
								{
										$msg=$mensajes['5'];
										 if(isset($_POST["recordar"])) 
										{
												setcookie("cookie_user", $user_end, time() + (3600*24*365),'/');
      											setcookie("cookie_pass", $pass_cookie, time() + (3600*24*365),'/');
												echo "Recuerdame";
										} else {
												unset($_COOKIE);
												setcookie("cookie_user", "", time() - (3600*24*365),'/');
      											setcookie("cookie_pass", "", time() - (3600*24*365),'/');
												echo "Olvidame";
											
										}

										//Insertamos la hora de registro para informacion
										$last = sprintf("UPDATE usuarios SET last_date = '$tiempo' WHERE usuario =%s",$user_clear);
										$inserta = mysql_query($last,$conexion) or die (mysql_error());
										
										//Definimos las variables de sesión										
									  	// Se comienzan a asignar los valores para el array
										$ID=$fila['ID'];
										$nombre=$fila['nombre']; 
										$apellidos=$fila['apellidos'];
										$usuario=$fila['usuario'];
										$email=$fila['email'];
										$pass=$fila['pass'];
										$permisos=$fila['permisos'];
										$imagen=$fila['imagen'];
										$fecha_ingreso=$fila['fecha_ingreso'];
										$last_date=$fila['last_date'];
										
										//Se crea un array con el valor de la tabla
										$mi_sesion=array(
											'ID' =>$ID,
											'nombre'=> $nombre,
											'apellidos' => $apellidos,
											'usuario'  => $usuario,
											'email' => $email,
											'pass' => $pass,
											'permisos'=> $permisos, 
											'imagen'  => $imagen,
											'fecha_ingreso'=> $fecha_ingreso,
											'last_date'=> $last_date,);
										
										
										//Se creara variables de sesion de acuerdo a su nivel de usuario
										switch ($mi_sesion['permisos']) {
											  case 'baneado':
											  $_SESSION['General'] = 1;
											  $_SESSION['mi_sesion']=$mi_sesion;
											  //header("Location: panel_general.php");
											  break;
											  case 'proceso':
											  $_SESSION['General'] = 2;
											  $_SESSION['mi_sesion']=$mi_sesion;
											  //header("Location: panel_general.php");
											  break;
											  case 'usuario':
											  $_SESSION['General'] = 3;
											  $_SESSION['mi_sesion']=$mi_sesion;
											  //header("Location: ../panel_general.php");
											  break;
											  case 'escritor':
											  $_SESSION['General'] = 4;
											  $_SESSION['mi_sesion']=$mi_sesion;
											  //header("Location: ../admin/panel_general.php");
											  break;
											  case 'master':
											  $_SESSION['General'] = 5;
											  $_SESSION['mi_sesion']=$mi_sesion;
											  //header("Location: ../master/panel_general.php");
											  break;
											  }
				  						
					  
										
								}//Fin de proceso
					
					
								
						
						
					}

				
				
				
		}




}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Prueba</title>
</head>

<body>

<form id="Envio" name="Envio" method="post" action="Prueba.php" autocomplete="off">
  <p>
    <label for="user">Usuario </label>
    <input type="text" name="user" id="user" value="<?php if(isset($_COOKIE['cookie_user']) && $_COOKIE['cookie_user']!=""){echo $_COOKIE['cookie_user'];}else {if (isset($_POST['user'])){echo $_POST['user'];}}?>"/>
  </p>
  <p>
    <label for="pass">Contraseña</label>
    <input type="password" name="pass" id="pass" value="<?php if(isset($_COOKIE['cookie_pass']) && $_COOKIE['cookie_pass']!="") echo $_COOKIE['cookie_pass'];?>"/>
  </p>
  <p>
    <input name="recordar" type="checkbox" id="checkbox" value="SI" <?php if(isset($_COOKIE['cookie_user']) && $_COOKIE['cookie_user']!="") echo " checked";?>/>
    <label for="checkbox">Recordar</label>
  </p>
  <p>
    <input type="submit" name="entrar" id="entrar" value="Entrar" />
  </p>
  <p>
    <input type="hidden" name="MM_insert" value="Envio">
  </p>
  <p>&nbsp;</p>
</form>
<p>35fa3650cd5cd160bcd38bed675a711a</p>
<hr>
<label><?php echo $msg; ?></label><br>
<?php echo fecha_hoy();?>
<hr>
<table width="90%" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <th align="right" scope="col">Variable</th>
    <th align="left" scope="col">Valor</th>
  </tr>
  <tr>
    <td align="right">POST ['user']</td>
    <td align="left"><?php if (isset($_POST['user'])){echo $_POST['user'];}?></td>
  </tr>
  <tr>
    <td align="right">POST ['pass']</td>
    <td align="left"><?php if (isset($_POST['pass'])){echo $_POST['pass'];}?></td>
  </tr>
  <tr>
    <td align="right">Variable $user_clear</td>
    <td align="left"><?php if (isset($user_clear)){echo $user_clear;};?></td>
  </tr>
    <tr>
    <td align="right">Variable $pass_clear</td>
    <td align="left"><?php if (isset($pass_clear)){echo $pass_clear;};?></td>
  </tr>
  <tr>
    <td align="right">Variable $user_end</td>
    <td align="left"><?php if (isset($user_end)){echo $user_end;};?></td>
  </tr>
  <tr>
    <td align="right">Variable $pass_end</td>
    <td align="left"><?php if (isset($pass_end)){echo $pass_end;};?></td>
  </tr>
    <tr>
    <td align="right">Variable $pass_cookie</td>
    <td align="left"><?php if (isset($pass_cookie)){echo $pass_cookie;};?></td>
  </tr>
    <tr>
    <td align="right">$Consulta</td>
    <td align="left"><?php if (isset($consulta)){echo $consulta;};?></td>
  </tr>
    <tr>
    <td align="right">$Tiempo</td>
    <td align="left"><?php if (isset($tiempo)){echo $tiempo;};?></td>
  </tr>
    <tr>
    <td align="right">$last</td>
    <td align="left"><?php if (isset($last)){echo $last;}?></td>
  </tr>
  <tr>
    <td align="right">Cookie usuario</td>
    <td align="left"><?php if (isset($_COOKIE['cookie_user'])){echo $_COOKIE['cookie_user'];}?></td>
  </tr>
  <tr>
    <td align="right">Cookie pass</td>
    <td align="left"><?php if (isset($_COOKIE['cookie_pass'])){echo $_COOKIE['cookie_pass'];}?></td>
  </tr>
</table>
<hr>
<?php if (isset($mi_sesion)){var_dump($mi_sesion['permisos']);}?>
<hr>
<?PHP var_dump($_POST) ?>
<hr>
<?php var_dump ($_COOKIE)?>
<hr>
<?php if (isset($mi_sesion)){var_dump ($mi_sesion);}?>
<hr>


</body>
</html>