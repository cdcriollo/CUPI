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


if(isset($_POST['asignatura'],$_POST['usuario'],$_POST['nuevopc'], $_POST['grupo'], $_POST['reserva']))
{

	$asignatura=$_POST['asignatura'];
	$usuario=$_POST['usuario'];
	$nuevopc=$_POST['nuevopc'];
	$grupo=$_POST['grupo'];
	$reserva=$_POST['reserva'];
		
   $updateSQL = "update matricula set pc=$nuevopc where codAsignatura='$asignatura' and codUsuario=$usuario and grupo=$grupo and No_reserva='$reserva'";
   mysql_select_db($database_conexion, $conexion);
   $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
   $FilasAfectadasCambioPc=mysql_affected_rows();



	 if($FilasAfectadasCambioPc > 0)
	 {
		echo 1;
			
	 }
	 else if($FilasAfectadasCambioPc==0)
	 {
	   echo 0;
	 }
		
}
?>

