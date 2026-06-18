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
$usuario=$_POST['usuario'];
$nuevopc=$_POST['nuevopc'];
$antiguopc= $_POST['oldpc'];
$grupo=$_POST['grupo'];
$reserva=$_POST['reserva'];

mysql_select_db($database_conexion, $conexion);
$query_JRSelUsuario = "select codUsuario from matricula where codAsignatura='$asignatura' and grupo=$grupo and pc=$nuevopc and No_reserva= '$reserva'";
$JRSelUsuario = mysql_query($query_JRSelUsuario, $conexion) or die(mysql_error());
$row_JRSelUsuario = mysql_fetch_assoc($JRSelUsuario);
$totalRows_JRSelUsuario = mysql_num_rows($JRSelUsuario);


if($totalRows_JRSelUsuario > 0)
{
	$usuariocambio=$row_JRSelUsuario['codUsuario'];
	
  $updateMatricula = "update matricula set pc=$nuevopc where codAsignatura='$asignatura' and codUsuario=$usuario and grupo=$grupo and No_reserva='$reserva'";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateMatricula, $conexion) or die(mysql_error());
  $FilasAfectadasCrucepc=mysql_affected_rows();
  
  $updateMatricula1 = "update matricula set pc= $antiguopc where codAsignatura='$asignatura' and codUsuario= $usuariocambio and grupo=$grupo and No_reserva= '$reserva'";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateMatricula1, $conexion) or die(mysql_error());
  $FilasAfectadasCrucepc1=mysql_affected_rows();

		if($FilasAfectadasCrucepc > 0 && $FilasAfectadasCrucepc1 > 0)
		{
			echo 11;
				
		}
		else if($FilasAfectadasCrucepc==0 && $FilasAfectadasCrucepc1==0)
		{
		   echo 0;
		}
			
 }
 
 else
 {
	echo 2;
 }


mysql_free_result($JRSelUsuario);
?>
