<?php require_once('../../Connections/conexion.php'); ?>
<?php date_default_timezone_set("America/bogota"); ?>
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


$codigo=$_POST['codigo'];
$fecha_entrada= date('Y'.'-'.'m'.'-'.'d');

mysql_select_db($database_conexion, $conexion);
$query_JRPlanilla = "SELECT * from ingreso_salida_monitor WHERE codigo = '$codigo' and fecha_entrada= '$fecha_entrada' and estado='activo'";
mysql_query("SET NAMES 'utf8'");
$JRPlanilla = mysql_query($query_JRPlanilla, $conexion) or die(mysql_error());
$row_JRPlanilla = mysql_fetch_assoc($JRPlanilla);
$totalRows_JRPlanilla = mysql_num_rows($JRPlanilla);



  if ($totalRows_JRPlanilla > 0 )
  { 
	 echo 1; 
  }
  else
  {
	echo 0; 	 
  }
  
  

mysql_free_result($JRPlanilla);
mysql_close($conexion);
?>
