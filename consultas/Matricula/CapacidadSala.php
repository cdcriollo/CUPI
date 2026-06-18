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

$sala=$_POST['sala'];

 
	
	// consulta que trae el numero de pcs que hay disponibles en la sala
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRpcssala = "SELECT  count(Nopc) As NoPcsSala FROM pcs WHERE numSala=$sala";
	mysql_query("SET NAMES 'utf8'");
	$JRpcssala = mysql_query($query_JRpcssala, $conexion) or die(mysql_error());
	$row_JRpcssala = mysql_fetch_assoc($JRpcssala);
	$totalRows_JRpcssala = mysql_num_rows($JRpcssala);
	echo $pcsSala= $row_JRpcssala['NoPcsSala'];
	
    mysql_free_result($JRpcssala);
    mysql_close($conexion);
	
	
	