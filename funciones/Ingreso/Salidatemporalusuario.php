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

$usuario= $_POST['usuario'];
$actividad= $_POST['actividad'];
$sala= $_POST['sala'];
$pc= $_POST['pc'];
$insertarprestamosalt=$_POST['varinsertarp'];
$insertarequiposalt=$_POST['varinsertare'];
$estado=0;

// se obtiene la fecha de ingreso
$fecha= date('Y'.'-'.'m'.'-'.'d');

// se obtiene la hora de ingreso
$horaentrada= date('H:i');




mysql_select_db($database_conexion, $conexion);
$query_JRCusuario = "SELECT estamento, dependencia FROM usuarios WHERE codUsuario= $usuario";
$JRCusuario = mysql_query($query_JRCusuario, $conexion) or die(mysql_error());
$row_JRCusuario = mysql_fetch_assoc($JRCusuario);
$totalRows_JRCusuario = mysql_num_rows($JRCusuario);

$dependencia= $row_JRCusuario['dependencia']; 
$estamento=$row_JRCusuario ['estamento'];

mysql_select_db($database_conexion, $conexion);
$query_JRIngresousuario = "SELECT codIngreso FROM ingreso_salida WHERE codUsuario = $usuario and fecha= '$fecha' and estado <> 1 ";
$JRIngresousuario = mysql_query($query_JRIngresousuario, $conexion) or die(mysql_error());
$row_JRIngresousuario = mysql_fetch_assoc($JRIngresousuario);
$totalRows_JRIngresousuario = mysql_num_rows($JRIngresousuario);

if($totalRows_JRIngresousuario > 0)
{

$codingreso= $row_JRIngresousuario['codIngreso']; 

$updateSQL= "UPDATE ingreso_salida SET  horasalida= '$horaentrada' WHERE codIngreso= $codingreso";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  
  if($Result1==1)
  {
    echo 1;
  }
  else
  {
     echo 0;
  }


if($insertarprestamosalt==1 && $insertarequiposalt==1){
	
$estado=4;	
	
$insertSQL = sprintf("INSERT INTO ingreso_salida (codUsuario, actividad,  sala, dependencia, estamento, computador, fecha, horaingreso, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                      
                       GetSQLValueString($usuario, "int"),
                       GetSQLValueString($actividad, "text"),
                       GetSQLValueString($sala, "int"),
                       GetSQLValueString($dependencia, "text"),
                       GetSQLValueString($estamento, "text"),
                       GetSQLValueString($pc, "int"),
                       GetSQLValueString($fecha, "date"),
                       GetSQLValueString($horaentrada, "date"),
                       GetSQLValueString($estado, "int"));
                       

  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  $last_insert_id = mysql_insert_id();
  
  if($Result2==1)
  {
    echo 1;
  }
   else 
   {
    echo 0;
   }
   
   $insertprestamo= "INSERT INTO prestamorecursos (fechaprestamo, horaentrega, codUsuario,codIngreso) VALUES ('$fecha','$horaentrada',$usuario, $last_insert_id )";

   mysql_select_db($database_conexion, $conexion);
  $Result3 = mysql_query($insertprestamo, $conexion) or die(mysql_error());	
   $last_insert_id_prestamo = mysql_insert_id();
  
  if($Result3==1){
  
  echo 1;
  }
  else{
   
	echo 0;
  }
  


 $cadenaprestamo=explode(',',$_POST['arrayp']);

 
  for($i=0; $i<count($cadenaprestamo)-1;$i+=3){
		    
   $insertPmo = sprintf("INSERT INTO detalle_prestamo (idPrestamo, Noinventario, cantidad, descripcion) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($last_insert_id_prestamo, "int"),
                       GetSQLValueString($cadenaprestamo[$i], "int"),
                       GetSQLValueString($cadenaprestamo[$i+1], "int"),
					   GetSQLValueString($cadenaprestamo[$i+2], "text"));
                    
  mysql_select_db($database_conexion, $conexion);
  $Result4 = mysql_query( $insertPmo, $conexion) or die(mysql_error());
 
	}
   if($Result4==1){
	echo 1; 
  }
  else{
	echo 0;
  }
  

 $insertequipos= "INSERT INTO equipos_externos (codIngreso, fechaingreso, horaingreso) VALUES ( $last_insert_id, '$fecha','$horaentrada')";

   mysql_select_db($database_conexion, $conexion);
  $Result5 = mysql_query($insertequipos, $conexion) or die(mysql_error());
  $last_insert_id_equipos = mysql_insert_id();

   if($Result5==1){
  
  echo 1;
  }
  else{
   
	echo 0;
  }
 
 
 
 
$cadenaequipos=explode(',',$_GET['arraye']);
 
 for($i=0; $i<count($cadenaequipos)-1;$i+=3){
		    
   $insertdetalleequipos = sprintf("INSERT INTO detalle_equipos_externos (Idingreso,cantidad, equipo,detalles) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($last_insert_id_equipos, "int"),
                       GetSQLValueString($cadenaequipos[$i], "int"),
					   GetSQLValueString($cadenaequipos[$i+1], "text"),
                       GetSQLValueString($cadenaequipos[$i+2], "text"));
                    
  mysql_select_db($database_conexion, $conexion);
  $Result6 = mysql_query( $insertdetalleequipos, $conexion) or die(mysql_error());
 
	}
   if($Result6==1){
	echo 1; 
  }
  else{
	echo 0;
  }
  
  $updateSQL= "UPDATE pcs SET  estadoocupacion='ocupado' WHERE Nopc= $pc";
  mysql_select_db($database_conexion, $conexion);
  $Result7 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  
  if($Result7==1)
  {
    echo 1;
  }
  else
  {
     echo 0;
  }

  
}

else if($insertarprestamosalt==0 && $insertarequiposalt==0)
{
	
	$estado=5;
	
	$insertSQL = sprintf("INSERT INTO ingreso_salida (codUsuario, actividad,  sala, dependencia, estamento, computador, fecha, horaingreso, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                      
                       GetSQLValueString($usuario, "int"),
                       GetSQLValueString($actividad, "text"),
                       GetSQLValueString($sala, "int"),
                       GetSQLValueString($dependencia, "text"),
                       GetSQLValueString($estamento, "text"),
                       GetSQLValueString($pc, "int"),
                       GetSQLValueString($fecha, "date"),
                       GetSQLValueString($horaentrada, "date"),
                       GetSQLValueString($estado, "int"));
                       

  mysql_select_db($database_conexion, $conexion);
  $Result8 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  $last_insert_id = mysql_insert_id();
  
  if($Result8==1)
  {
    echo 1;
  }
   else 
   {
    echo 0;
   }
   
   
    $updateSQL= "UPDATE pcs SET  estadoocupacion='ocupado' WHERE Nopc= $pc";
  mysql_select_db($database_conexion, $conexion);
  $Result9 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  
  if($Result9==1)
  {
    echo 1;
  }
  else
  {
     echo 0;
  }
	
}
else if($insertarprestamosalt==1 && $insertarequiposalt==0)
{
	
	  $estado=2;
	  
	$insertSQL = sprintf("INSERT INTO ingreso_salida (codUsuario, actividad,  sala, dependencia, estamento, computador, fecha, horaingreso, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                      
                       GetSQLValueString($usuario, "int"),
                       GetSQLValueString($actividad, "text"),
                       GetSQLValueString($sala, "int"),
                       GetSQLValueString($dependencia, "text"),
                       GetSQLValueString($estamento, "text"),
                       GetSQLValueString($pc, "int"),
                       GetSQLValueString($fecha, "date"),
                       GetSQLValueString($horaentrada, "date"),
                       GetSQLValueString($estado, "int"));
                       

  mysql_select_db($database_conexion, $conexion);
  $Result10 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  $last_insert_id = mysql_insert_id();
  
  if($Result10==1)
  {
    echo 1;
  }
   else 
   {
    echo 0;
   }
   
   $insertprestamo= "INSERT INTO prestamorecursos (fechaprestamo, horaentrega, codUsuario,codIngreso) VALUES ('$fecha','$horaentrada',$usuario, $last_insert_id )";

   mysql_select_db($database_conexion, $conexion);
  $Result11 = mysql_query($insertprestamo, $conexion) or die(mysql_error());	
   $last_insert_id_prestamo = mysql_insert_id();
  
  if($Result11==1){
  
  echo 1;
  }
  else{
   
	echo 0;
  }
  


$cadenaprestamo=explode(',',$_POST['arrayp']);


 
  for($i=0; $i<count($cadenaprestamo)-1;$i+=3){
		    
   $insertPmo = sprintf("INSERT INTO detalle_prestamo (idPrestamo, Noinventario, cantidad, descripcion) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($last_insert_id_prestamo, "int"),
                       GetSQLValueString($cadenaprestamo[$i], "int"),
                       GetSQLValueString($cadenaprestamo[$i+1], "int"),
					   GetSQLValueString($cadenaprestamo[$i+2], "text"));
                    
  mysql_select_db($database_conexion, $conexion);
  $Result12 = mysql_query( $insertPmo, $conexion) or die(mysql_error());
 
	}
   if($Result12==1){
	echo 1; 
  }
  else{
	echo 0;
  }
  
  
   $updateSQL= "UPDATE pcs SET  estadoocupacion='ocupado' WHERE Nopc= $pc";
  mysql_select_db($database_conexion, $conexion);
  $Result13 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  
  if($Result13==1)
  {
    echo 1;
  }
  else
  {
     echo 0;
  }
  
}
else if($insertarprestamosalt==0 && $insertarequiposalt==1)
{
	
	 $estado=3;
	 
	$insertSQL = sprintf("INSERT INTO ingreso_salida (codUsuario, actividad,  sala, dependencia, estamento, computador, fecha, horaingreso, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                      
                       GetSQLValueString($usuario, "int"),
                       GetSQLValueString($actividad, "text"),
                       GetSQLValueString($sala, "int"),
                       GetSQLValueString($dependencia, "text"),
                       GetSQLValueString($estamento, "text"),
                       GetSQLValueString($pc, "int"),
                       GetSQLValueString($fecha, "date"),
                       GetSQLValueString($horaentrada, "date"),
                       GetSQLValueString($estado, "int"));
                       

  mysql_select_db($database_conexion, $conexion);
  $Result14 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  $last_insert_id = mysql_insert_id();
  
  if($Result14==1)
  {
    echo 1;
  }
   else 
   {
    echo 0;
   }
   
   $insertequipos= "INSERT INTO equipos_externos (codIngreso, fechaingreso, horaingreso) VALUES ( $last_insert_id, '$fecha','$horaentrada')";

   mysql_select_db($database_conexion, $conexion);
  $Result15 = mysql_query($insertequipos, $conexion) or die(mysql_error());
  $last_insert_id_equipos = mysql_insert_id();

   if($Result15==1){
  
  echo 1;
  }
  else{
   
	echo 0;
  }
 
 
 
 
 $cadenaequipos=explode(',',$_GET['arraye']);
 
 for($i=0; $i<count($cadenaequipos)-1;$i+=3){
		    
   $insertdetalleequipos = sprintf("INSERT INTO detalle_equipos_externos (Idingreso,cantidad, equipo,detalles) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($last_insert_id_equipos, "int"),
                       GetSQLValueString($cadenaequipos[$i], "int"),
					   GetSQLValueString($cadenaequipos[$i+1], "text"),
                       GetSQLValueString($cadenaequipos[$i+2], "text"));
                    
  mysql_select_db($database_conexion, $conexion);
  $Result16 = mysql_query( $insertdetalleequipos, $conexion) or die(mysql_error());
 
	}
   if($Result16==1){
	echo 1; 
  }
  else{
	echo 0;
  }
  
  $updateSQL= "UPDATE pcs SET  estadoocupacion='ocupado' WHERE Nopc= $pc";
  mysql_select_db($database_conexion, $conexion);
  $Result17 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  
  if($Result17==1)
  {
    echo 1;
  }
  else
  {
     echo 0;
  } 
 }
}// cierro if

//mysql_free_result($JRIngresousuario);

//mysql_free_result($JRCusuario);

?>

