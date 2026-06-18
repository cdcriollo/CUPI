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

$asignatura=$_POST['asignatura'];
$grupo=$_POST['grupo'];
$estado= $_POST['estado'];
	
	mysql_select_db($database_conexion, $conexion);

   $updateSQL = "UPDATE horario SET  estadohorario= '$estado' WHERE codAsignatura= '$asignatura' and codGrupo=$grupo";
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  if($Result1==1){
	echo 1;
  }
  else{
	 echo 0;
	}

	
	


 
?>

