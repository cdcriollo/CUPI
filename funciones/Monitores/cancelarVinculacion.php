<?php require_once('../../Connections/conexion.php'); ?>
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

$vinculacion=$_POST['vinculacion'];

mysql_select_db($database_conexion, $conexion);
 
    $updateSQL = "UPDATE vinculacion_monitor SET estado= 'inactiva' WHERE No_vinculacion= '$vinculacion'";
    mysql_query("SET NAMES 'utf8'");
    $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	$FilasAfectadas=mysql_affected_rows();

 if($FilasAfectadas > 0)
 {
	$respuesta=array("error"=>1); 
	echo json_encode($respuesta);
 }
 else
 {
	$respuesta=array("error"=>0); 
	echo json_encode($respuesta);
 }


 
?>

