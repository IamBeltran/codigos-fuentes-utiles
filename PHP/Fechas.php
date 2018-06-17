<?php
/*  
    Agregar a la session donde se quiera mostrar 
    la fecha en formato de texto.
    fecha_hoy()
================================================== */


    function fecha_hoy() {
      $fecha = date("Y/m/d/w");
      $trozos = explode("/", $fecha);
      switch($trozos[1]) {
        case "01": $mes="Enero";      break;
        case "02": $mes="Febrero";    break;
        case "03": $mes="Marzo";      break;
        case "04": $mes="Abril";      break;
        case "05": $mes="Mayo";       break;
        case "06": $mes="Junio";      break;
        case "07": $mes="Julio";      break;
        case "08": $mes="Agosto";     break;
        case "09": $mes="Septiembre"; break;
        case "10": $mes="Octubre";    break;
        case "11": $mes="Noviembre";  break;
        case "12": $mes="Diciembre";  break;
      }

      switch($trozos[2]) {
        case "01": $dia="1°"; break;
        case "02": $dia="2";  break;
        case "03": $dia="3";  break;
        case "04": $dia="4";  break;
        case "05": $dia="5";  break;
        case "06": $dia="6";  break;
        case "07": $dia="7";  break;
        case "08": $dia="8";  break;
        case "09": $dia="9";  break;
        default  : $dia=$trozos[2];
      }

      switch($trozos[3]) {
        case 0: $dia2="Domingo";   break;
        case 1: $dia2="Lunes";     break;
        case 2: $dia2="Martes";    break;
        case 3: $dia2="Miércoles"; break;
        case 4: $dia2="Jueves";    break;
        case 5: $dia2="Viernes";   break;
        case 6: $dia2="Sábado";    break;
      }

      return $dia2.", ".$dia." de ".$mes." del ".$trozos[0].".";
}?>