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


$dia= $_POST['dia'];
$horainicio= $_POST['horainicio'];
$horafinal= $_POST['horafinal'];
$idturno= $_POST['idturno'];
$actividad= $_POST['actividad'];

  $updateSQL = sprintf("UPDATE turnos_monitor SET dia=%s, hora_entrada=%s, hora_salida=%s, actividad=%s WHERE idturno=%s",
                      
                       GetSQLValueString($dia, "int"),
                       GetSQLValueString($horainicio, "date"),
                       GetSQLValueString($horafinal, "date"),
					   GetSQLValueString($actividad, "text"),
                       GetSQLValueString($idturno, "int"));
					   

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  $resultado= mysql_affected_rows();
  
  if($resultado > 0)
  {
	  
	 $error=array("error"=>1); 
	 echo json_encode($error);
  }
  else
  {
	 $error=array("error"=>0); 
	 echo json_encode($error);
  }



?>


