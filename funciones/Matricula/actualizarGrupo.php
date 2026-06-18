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

$nuevovalor=$_POST['nuevogrupo'];
$asignatura=$_POST['asignatura'];
$usuario=$_POST['usuario'];
$horario=$_POST['nuevohorario'];
$nuevasala=$_POST['nuevasala'];
$nuevopc=$_POST['nuevopc'];
$reservaant=$_POST['reservaant'];
$reservanueva=$_POST['reservanueva'];

if(isset($_POST['nuevogrupo'], $_POST['asignatura'], $_POST['usuario'], $_POST['nuevohorario'], $_POST['nuevasala'], $_POST['nuevopc'],$_POST['reservaant'],$_POST['reservanueva']))
{

	  $updateSQL = "update matricula set grupo=$nuevovalor, idHorario=$horario, pc=$nuevopc, No_reserva='$reservanueva' where codAsignatura='$asignatura' and codUsuario=$usuario and No_reserva='$reservaant' and   Estado='Activa'";
	  mysql_select_db($database_conexion, $conexion);
	  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	  $FilasAfectadascambiogrupo=mysql_affected_rows();  

	 if($FilasAfectadascambiogrupo > 0)
	 {
		 echo 1;
	 }
	 else if($FilasAfectadascambiogrupo==0)
	 {
		 echo 0;
	 }

}
?>


