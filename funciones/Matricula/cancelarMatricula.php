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

$datos=explode(',',$_GET['arrayest']);
$asignatura= $_POST['asignatura'];
$grupo=$_POST['grupoE'];


for($i=0; $i<count($datos); $i+=2)
{

mysql_select_db($database_conexion, $conexion);

$usuario= $datos[$i];
$reserva=$datos[$i+1];

  $updateSQL ="update matricula set Estado='Cancelada' WHERE codUsuario= $usuario and codAsignatura='$asignatura' and grupo=$grupo and No_reserva= '$reserva'"; 
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  
}

  $FilasAfectadasmatricula=mysql_affected_rows();
  
if($FilasAfectadasmatricula > 0)
{
  echo 1;
}
else if($FilasAfectadasmatricula==0)
{
 echo 0;
}


?>








  