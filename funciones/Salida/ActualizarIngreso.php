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



$updaterecursos=$_POST['updaterecursos'];
$updateequipos=$_POST['updateequipos'];
$observacion= $_POST['observaciones'];    
$codingreso= $_POST['codIngreso'];
$pc= $_POST['pc'];
$estado=0;

// se obtiene la hora de salida
$horasalida= date('H:i');


  $updateSQL= "UPDATE ingreso_salida SET observaciones='$observacion' WHERE codIngreso=$codingreso";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  



if($updaterecursos==1 and $updateequipos==1){

   $estado=1;
	 
   $updateSQL= "UPDATE ingreso_salida SET horasalida='$horasalida', estado=$estado WHERE codIngreso=$codingreso";

              

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
 

   $filasafectadasingreso= mysql_affected_rows();
   
  if($filasafectadasingreso > 0)
  {
     echo 1;
  }
  else if($filasafectadasingreso == 0){
    echo  0;
  } 
 
 

 $cadenaprestamo=explode(',',$_GET['arrayprestamo']);
 $tamañoarray= count($cadenaprestamo);
 
 // recorro el array para obtener $cadenaprestamo para actualizar estado de los recursos
 
 
  for($j=0; $j<$tamañoarray; $j+=3)
  {
	
	$actualizarrecursos = "UPDATE recursos SET estadoprestamo='disponible' WHERE Noinventario= '$cadenaprestamo[$j]'";           
    mysql_select_db($database_conexion, $conexion);
    $Result2 = mysql_query( $actualizarrecursos , $conexion) or die(mysql_error());
 }
 
 
 $filasafectadasrecurso= mysql_affected_rows();
   
  if($filasafectadasrecurso > 0)
  {
     echo 1;
  }
  else if($filasafectadasrecurso == 0){
    echo  0;
  } 
  
 
  
  $actualizarequipos = "UPDATE equipos_externos SET horaretiro='$horasalida' WHERE codIngreso= $codingreso";           

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
  
  
  $actualizarprestamo = "UPDATE prestamorecursos SET horarecibido='$horasalida' WHERE codIngreso= $codingreso";           

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
   
  
  $actualizarpcs = "UPDATE pcs SET estadoocupacion='disponible' WHERE Nopc= $pc ";              

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
  
  
 }// cierro if
 	



else if($updaterecursos==0 and $updateequipos==0){


   $estado=1;
	 
   $updateSQL= "UPDATE ingreso_salida SET horasalida='$horasalida', estado=$estado WHERE codIngreso=$codingreso";

              

  mysql_select_db($database_conexion, $conexion);
  $Result6 = mysql_query($updateSQL, $conexion) or die(mysql_error());
 

   $filasafectadasingreso= mysql_affected_rows();
   
  if($filasafectadasingreso > 0)
  {
     echo 1;
  }
  else if($filasafectadasingreso == 0){
    echo  0;
  } 
  
  
  $actualizarpcs = "UPDATE pcs SET estadoocupacion='disponible' WHERE Nopc= $pc ";              

  mysql_select_db($database_conexion, $conexion);
  $Result7 = mysql_query( $actualizarpcs , $conexion) or die(mysql_error());
 

   $filasafectadaspcs= mysql_affected_rows();
   
  if($filasafectadaspcs > 0)
  {
     echo 1;
  }
  else if($filasafectadaspcs == 0){
    echo  0;
  } 
	

} // cierro if




 else  if($updaterecursos==1 and $updateequipos==0 )
 
 {
	 
	 $estado=1;
	 
   $updateSQL= "UPDATE ingreso_salida SET horasalida='$horasalida', estado=$estado WHERE codIngreso=$codingreso";

              

  mysql_select_db($database_conexion, $conexion);
  $Result8 = mysql_query($updateSQL, $conexion) or die(mysql_error());
 

   $filasafectadasingreso= mysql_affected_rows();
   
  if($filasafectadasingreso > 0)
  {
     echo 1;
  }
  else if($filasafectadasingreso == 0){
    echo  0;
  } 
 
 

 $cadenaprestamo=explode(',',$_GET['arrayprestamo']);
 $tamañoarray= count($cadenaprestamo);
 
 // recorro el array para obtener $cadenaprestamo para actualizar el estado de los recursos
 
 
  for($j=0; $j<$tamañoarray; $j+=3)
  {
	$actualizarrecursos = "UPDATE recursos SET estadoprestamo='disponible' WHERE Noinventario= '$cadenaprestamo[$j]'";           
    mysql_select_db($database_conexion, $conexion);
    $Result2 = mysql_query( $actualizarrecursos , $conexion) or die(mysql_error());
 }
 
 
 
 $filasafectadasrecurso= mysql_affected_rows();
   
  if($filasafectadasrecurso > 0)
  {
     echo 1;
  }
  else if($filasafectadasrecurso == 0){
    echo  0;
  } 
  
  
  $actualizarprestamo = "UPDATE prestamorecursos SET horarecibido='$horasalida' WHERE codIngreso= $codingreso";           

  mysql_select_db($database_conexion, $conexion);
  $Result10 = mysql_query( $actualizarprestamo , $conexion) or die(mysql_error());
 
  $filasafectadasprestamo= mysql_affected_rows();
   
  if($filasafectadasprestamo > 0)
  {
     echo 1;
  }
  else if($filasafectadasprestamo == 0){
    echo  0;
  } 
  
  $actualizarpcs = "UPDATE pcs SET estadoocupacion='disponible' WHERE Nopc= $pc ";              

  mysql_select_db($database_conexion, $conexion);
  $Result11 = mysql_query( $actualizarpcs , $conexion) or die(mysql_error());
 
  $filasafectadaspcs= mysql_affected_rows();
   
  if($filasafectadaspcs > 0)
  {
     echo 1;
  }
  else if($filasafectadaspcs == 0){
    echo  0;
  } 
   
  
  
 }// cierro if
 
 
 
 else if($updaterecursos==0 and $updateequipos==1){
	
  $estado=1;
	 
  $updateingreso= "UPDATE ingreso_salida SET horasalida='$horasalida', estado=$estado WHERE codIngreso=$codingreso";

              

  mysql_select_db($database_conexion, $conexion);
  $Result12 = mysql_query($updateingreso, $conexion) or die(mysql_error());
 

   $filasafectadasingreso= mysql_affected_rows();
   
  if($filasafectadasingreso > 0)
  {
     echo 1;
  }
  else if($filasafectadasingreso == 0){
    echo  0;
  } 
  
   $updateEquipoExt = "UPDATE equipos_externos SET horaretiro='$horasalida' WHERE codIngreso= $codingreso";           

  mysql_select_db($database_conexion, $conexion);
  $Result13 = mysql_query( $updateEquipoExt , $conexion) or die(mysql_error());
 

   $filasafectadasequipos= mysql_affected_rows();
   
  if($filasafectadasequipos > 0)
  {
     echo 1;
  }
  else if($filasafectadasequipos == 0){
    echo  0;
  } 
  
  
  
  $actualizarpcs = "UPDATE pcs SET estadoocupacion='disponible' WHERE Nopc= $pc ";              

  mysql_select_db($database_conexion, $conexion);
  $Result14 = mysql_query( $actualizarpcs , $conexion) or die(mysql_error());
 

   $filasafectadaspcs= mysql_affected_rows();
   
  if($filasafectadaspcs > 0)
  {
     echo 1;
  }
  else if($filasafectadaspcs == 0){
    echo  0;
  } 
	 
}// cierro if
  
?>
