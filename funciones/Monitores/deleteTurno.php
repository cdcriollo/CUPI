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

$idturno=$_POST['idturno'];



mysql_select_db($database_conexion, $conexion);
 
   $deleteSQL = "DELETE FROM turnos_monitor  WHERE idturno IN ($idturno)";
   $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());
  
  $FilasAfectadas=mysql_affected_rows();

  if( $FilasAfectadas > 0)
  {
	 $error=array("error"=>1); 
	 echo json_encode($error);
		
  }
  else if($FilasAfectadas==0)
  {
     $error=array("error"=>0); 
	 echo json_encode($error);
	
  }


?>