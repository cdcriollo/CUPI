<?php require_once('../../Connections/conexion.php'); ?>
<?php date_default_timezone_set("America/bogota"); ?>
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

$estado=1;
$arrayrecursos=$_POST['arrayrecursos'];
$actualizarusuarios=$_POST['actualizarusuarios'];
$arraypcs= $_POST['arraypcs'];
$updaterecursos=  $_POST['updaterecursos'];
$updateequipos= $_POST['updateequipos'];



// se obtiene la hora de salida
$horasalida= date('H:i');

if($updaterecursos==1)
{
	
 $arrayrecursos=explode(',',$_POST['arrayrecursos']);
 $tamañoarray= count($arrayrecursos);
 
 for ($i=0; $i< $tamañoarray; $i++)
 {	
   $updateSQL= "UPDATE recursos SET estadoprestamo='disponible' WHERE Noinventario = '$arrayrecursos[$i]'";   
   mysql_select_db($database_conexion, $conexion);
   $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
 }
   $filasafectadasrecursos= mysql_affected_rows();
   
  if($filasafectadasrecursos > 0)
  {
     echo 1;
  }
  else if($filasafectadasrecursos == 0){
    echo  0;
  } 
  
  $actualizarprestamo = "UPDATE prestamorecursos SET horarecibido='$horasalida' WHERE codIngreso IN ($actualizarusuarios)";              

  mysql_select_db($database_conexion, $conexion);
  $Result4 = mysql_query( $actualizarprestamo , $conexion) or die(mysql_error());
 
  $filasafectadasprestamo= mysql_affected_rows();
   
  if($filasafectadasprestamo > 0)
  {
     echo 1;
  }
  else if($filasafectadasprestamo == 0){
    echo  0;
  }
  
 } 
 
 
  $updateingreso= "UPDATE ingreso_salida SET horasalida='$horasalida', estado=$estado WHERE codIngreso IN ($actualizarusuarios)";   
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query( $updateingreso, $conexion) or die(mysql_error());
  
  $filasafectadasingreso= mysql_affected_rows();
   
  if($filasafectadasingreso > 0)
  {
     echo 1;
  }
  else if($filasafectadasingreso == 0){
    echo  0;
  }
  
  
  
  if ($updateequipos==1)
  {
	 $actualizarequipos = "UPDATE equipos_externos SET horaretiro='$horasalida' WHERE codIngreso IN ($actualizarusuarios)";   

	  mysql_select_db($database_conexion, $conexion);
	  $Result3 = mysql_query(  $actualizarequipos , $conexion) or die(mysql_error());
 

	 $filasafectadasequipos= mysql_affected_rows();
   
	  if($filasafectadasequipos > 0)
	  {
		 echo 1;
	  }
	  else if($filasafectadasequipos == 0){
		echo  0;
	  }
  
 } 
  
  $actualizarpcs = "UPDATE pcs SET estadoocupacion='disponible' WHERE Nopc IN ($arraypcs)";              

  mysql_select_db($database_conexion, $conexion);
  $Result5 = mysql_query( $actualizarpcs , $conexion) or die(mysql_error());
 

  $filasafectadaspcs= mysql_affected_rows();
   
	  if($filasafectadaspcs > 0)
	  {
		 echo 1;
	  }
	  else if($filasafectadaspcs == 0){
		echo  0;
	  }
  
 
?>
