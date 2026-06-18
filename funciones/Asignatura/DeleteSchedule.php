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

$idHorario=$_POST['idHorario'];



mysql_select_db($database_conexion, $conexion);
 
   $updateSQL = "UPDATE horario SET estadohorario='inactivo' WHERE idHorario IN ($idHorario)";
   $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
   
   
  $FilasAfectadas=mysql_affected_rows();

  if( $FilasAfectadas > 0)
  {
	echo 1;
		
  }
  else if($FilasAfectadas==0)
  {
    echo 0;
	
  }


?>