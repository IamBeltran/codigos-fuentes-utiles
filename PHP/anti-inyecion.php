<?php 

		function limpiarCadena($valor)
		{
			$valor = str_ireplace("SELECT","",$valor);
			$valor = str_ireplace("COPY","",$valor);
			$valor = str_ireplace("DELETE","",$valor);
			$valor = str_ireplace("DROP","",$valor);
			$valor = str_ireplace("DUMP","",$valor);
			$valor = str_ireplace(" OR ","",$valor);
			$valor = str_ireplace("%","",$valor);
			$valor = str_ireplace("LIKE","",$valor);
			$valor = str_ireplace("--","",$valor);
			$valor = str_ireplace("^","",$valor);
			$valor = str_ireplace("[","",$valor);
			$valor = str_ireplace("]","",$valor);
			$valor = str_ireplace("\\","",$valor);
			$valor = str_ireplace("!","",$valor);
			$valor = str_ireplace("¡","",$valor);
			$valor = str_ireplace("?","",$valor);
			$valor = str_ireplace("=","",$valor);
			$valor = str_ireplace("&","",$valor);
			return $valor;

				/* 	Se agrega el siguiente codigo a la hoja que se filtrara

				$input_arr = array(); 
				foreach ($_POST as $key => $input_arr) 
				{ 
					$_POST[$key] = addslashes(limpiarCadena($input_arr)); 
				}
				 
				$input_arr = array(); 
				foreach ($_GET as $key => $input_arr) 
				{ 
					$_GET[$key] = addslashes(limpiarCadena($input_arr)); 
				}
				================================================== */
}?>