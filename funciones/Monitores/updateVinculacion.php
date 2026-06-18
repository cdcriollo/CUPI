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

$vinculacion= $_POST["vinculacion"];

if ((isset($_POST["vinculacion"])))
{
  $updateSQL = sprintf("UPDATE vinculacion_monitor SET  comienzo= %s, finalizacion=%s, total_horas_semestre=%s, valor_hora_monitor=%s, valor_total_vinculacion=%s WHERE No_vinculacion=%s",
                       GetSQLValueString(implode('-',array_reverse(explode('-',$_POST['comienzo']))), "date"),
                       GetSQLValueString(implode('-',array_reverse(explode('-',$_POST['finalizacion']))), "date"),
                       GetSQLValueString($_POST['totalhoras'], "int"),
                       GetSQLValueString($_POST['horamonitor'], "int"),
                       GetSQLValueString($_POST['totalvinculacion'], "int"),
                       GetSQLValueString($vinculacion, "text"));

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
