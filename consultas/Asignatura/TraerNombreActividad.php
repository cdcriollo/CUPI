<?php require_once('../../Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$asignatura=$_POST['asignatura'];
$arrayNombreActividad=array();

mysql_select_db($database_conexion, $conexion);
$query_JRNombreActividad = "SELECT nomAsignatura,actividad FROM asignatura WHERE codAsignatura = '$asignatura'";
mysql_query("SET NAMES 'utf8'");
$JRNombreActividad = mysql_query($query_JRNombreActividad, $conexion) or die(mysql_error());
$row_JRNombreActividad = mysql_fetch_assoc($JRNombreActividad);
$totalRows_JRNombreActividad = mysql_num_rows($JRNombreActividad);

if($totalRows_JRNombreActividad > 0)
{
  $arrayNombreActividad[0]= $row_JRNombreActividad['nomAsignatura'];
  $arrayNombreActividad[1]= $row_JRNombreActividad['actividad'];
  $cadenaasignaturas=implode('-',$arrayNombreActividad);  
  echo $cadenaasignaturas;

}
else
{
 echo 0;	
}

 
mysql_free_result($JRNombreActividad);
mysql_close($conexion);
?>