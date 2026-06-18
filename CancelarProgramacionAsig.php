<?php require_once('Connections/conexion.php'); ?>
<?php date_default_timezone_set("America/bogota"); ?>
<?php

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}



// se obtiene la fecha del servidor
$fechaServidor= strtotime(date('Y'.'-'.'m'.'-'.'d'));
// se obtiene la hora del servidor
$horaServidor= strtotime(date('H:i:'."00"));
$fechaServidor1= date('Y'.'-'.'m'.'-'.'d');

// realiza una consulta sobre la tabla horario que contiene la programacion de las asignaturas
    mysql_select_db($database_conexion, $conexion);
	$query_JRHorarios = "SELECT  horafinal, fechaFinal, idHorario, No_reserva FROM horario WHERE estadohorario='activo' and fechaFinal='$fechaServidor1'";
	mysql_query("SET NAMES 'utf8'");
	$JRHorarios = mysql_query($query_JRHorarios, $conexion) or die(mysql_error());
	$row_JRHorarios = mysql_fetch_assoc($JRHorarios);
	$totalRows_JRHorarios = mysql_num_rows($JRHorarios);
	
	if($totalRows_JRHorarios > 0)
	{
		
	 // recorre todas las programaciones de las asignaturas
	     do 
		 { 
		 
		   $fechaFinalProg=strtotime($row_JRHorarios['fechaFinal']);
		   $horaFinalProg=strtotime($row_JRHorarios['horafinal']);
		   $idHorario=$row_JRHorarios['idHorario'];
		   $reserva= $row_JRHorarios['No_reserva'];
			
			// compara si la fecha, hora del servidor coinciden con la fecha y hora de la programacion de las asignaturas
			if($fechaServidor==$fechaFinalProg && $horaServidor==$horaFinalProg)
			{ 
			  mysql_select_db($database_conexion, $conexion);
              $updateProgAsignaturas = "UPDATE horario SET estadohorario= 'inactivo' WHERE idHorario= $idHorario ";
              $Result1 = mysql_query($updateProgAsignaturas, $conexion) or die(mysql_error());
			  
			  mysql_select_db($database_conexion, $conexion);
	          $updateMatAsignaturas = "UPDATE matricula SET Estado= 'inactiva' WHERE idHorario= $idHorario ";
		      $Result4 = mysql_query($updateMatAsignaturas, $conexion) or die(mysql_error());
			  
			  mysql_select_db($database_conexion, $conexion);
	          $updateReserva = "UPDATE reserva_eventual SET estado= 'inactiva' WHERE No_reserva= $reserva ";
		      $Result4 = mysql_query($updateMatAsignaturas, $conexion) or die(mysql_error());
			   
			}
				  
	     } while ($row_JRHorarios = mysql_fetch_assoc($JRHorarios));  
  
	}
	
?>


