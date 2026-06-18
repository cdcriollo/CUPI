<?php require_once('../../Connections/conexion.php'); ?>
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


$usuario=$_POST['usuario'];

// se obtiene la fecha de ingreso
$fecha= date('Y'.'-'.'m'.'-'.'d');

mysql_select_db($database_conexion, $conexion);
$query_JRCodingreso = "SELECT codIngreso,codUsuario,actividad,codAsignatura,codGrupo,sala,fecha,horaingreso,estado FROM ingreso_salida WHERE codUsuario=$usuario and fecha= '$fecha' and estado <> 1 ";
$JRCodingreso = mysql_query($query_JRCodingreso, $conexion) or die(mysql_error());
$row_JRCodingreso = mysql_fetch_assoc($JRCodingreso);
$totalRows_JRCodingreso = mysql_num_rows($JRCodingreso);

 if($totalRows_JRCodingreso > 0 )
 {
	   $respuesta[0]=1;
	   $respuesta[1]=$row_JRCodingreso['codIngreso'];
	   $respuesta[2]=$row_JRCodingreso['codUsuario'];
	   $respuesta[3]=$row_JRCodingreso['actividad'];
	   $respuesta[4]=$row_JRCodingreso['codAsignatura'];
	   $respuesta[5]=$row_JRCodingreso['codGrupo'];
	   $respuesta[6]=$row_JRCodingreso['sala'];
	   $respuesta[7]=$row_JRCodingreso['fecha'];
	   $respuesta[8]=$row_JRCodingreso['horaingreso'];
	   $respuesta[9]=$row_JRCodingreso['estado'];
	   $cadenaIngreso= implode(',',$respuesta);
	   echo $cadenaIngreso;
 }
 
 else
 {
	echo 0;
 }

?>


