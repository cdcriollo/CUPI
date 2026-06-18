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

$reserva= $_POST["reserva"];

if ((isset($_POST["reserva"])))
{
  $updateSQL = sprintf("UPDATE reserva_eventual SET  cod_asignatura=%s, grupo=%s, cod_responsable=%s, email=%s, nombre_asignatura=%s, nombre_responsable=%s, internet=%s WHERE No_reserva=%s",
                       GetSQLValueString($_POST['cod_asignatura'], "text"),
                       GetSQLValueString($_POST['grupo'], "int"),
                       GetSQLValueString($_POST['cod_responsable'], "int"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['nombre_asignatura'], "text"),
                       GetSQLValueString($_POST['nombre_responsable'], "text"),
					   GetSQLValueString($_POST['internet'], "text"),
                       GetSQLValueString($reserva, "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  
  $updates= mysql_affected_rows();
  
  if($updates > 0)
  {
	 $error=array("error"=>1);
	 echo json_encode($error);    
  }
  else if($updates == 0 )
  {
	 $error=array("error"=>0);
	 echo json_encode($error);    
  }
}

mysql_close($conexion);

?>
