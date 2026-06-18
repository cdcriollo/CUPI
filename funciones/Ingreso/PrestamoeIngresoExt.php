<?php require_once('../../Connections/conexion.php'); ?>
<?php date_default_timezone_set("America/bogota"); ?>
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

$usuario=$_POST['usuario'];
$prestamo=$_POST['insertprestamo'];
$ingresoequipo=$_POST['insertequipo'];

// se obtiene la fecha de ingreso
$fecha= date('Y'.'-'.'m'.'-'.'d');
// se obtiene la hora de ingreso
$horaentrada= date('H:i');

mysql_select_db($database_conexion, $conexion);
$query_JRUsuarios = "SELECT nombreUsu FROM usuarios WHERE codUsuario = $usuario";
$JRUsuarios = mysql_query($query_JRUsuarios, $conexion) or die(mysql_error());
$row_JRUsuarios = mysql_fetch_assoc($JRUsuarios);
$totalRows_JRUsuarios = mysql_num_rows($JRUsuarios);


mysql_select_db($database_conexion, $conexion);
$query_JRCodingreso = "SELECT codIngreso FROM ingreso_salida WHERE codUsuario=$usuario and fecha= '$fecha' and estado <> 1 ";
$JRCodingreso = mysql_query($query_JRCodingreso, $conexion) or die(mysql_error());
$row_JRCodingreso = mysql_fetch_assoc($JRCodingreso);
$totalRows_JRCodingreso = mysql_num_rows($JRCodingreso);

// se obtiene el codigo del ingreso
$codIngreso= $row_JRCodingreso['codIngreso']; 

if($totalRows_JRUsuarios > 0)
{

  if($totalRows_JRCodingreso > 0 && $totalRows_JRCodingreso < 2 )
  {

	if($prestamo==1 and $ingresoequipo==1){
		
	 $estado=4;
	
	   mysql_select_db($database_conexion, $conexion);
	 
	   $updateIngreso = "UPDATE ingreso_salida SET estado=$estado WHERE codIngreso= $codIngreso";
	   $Result1 = mysql_query($updateIngreso, $conexion) or die(mysql_error());
	   $numerofilasafectadas= mysql_affected_rows();
	  
	  if($numerofilasafectadas > 0)
	  {
		echo 1;  
	  }
	  else if($numerofilasafectadas==0)
	  {
		echo 0;  
	  }
	   
   

	 $insertprestamo= "INSERT INTO prestamorecursos (fechaprestamo, horaentrega, codUsuario,codIngreso) VALUES ('$fecha','$horaentrada',$usuario, $codIngreso)";
	
	   mysql_select_db($database_conexion, $conexion);
	  $Result2 = mysql_query($insertprestamo, $conexion) or die(mysql_error());	
	   $last_insert_id_prestamo = mysql_insert_id();
	  
	  if($Result2 > 0){
	  
	  echo 1;
	  }
	  else{
	   
		echo 0;
	  }
	  


	 $cadenaprestamo=explode(',',$_GET['arrayprestamo']);
	
	 
	  for($i=0; $i<count($cadenaprestamo)-1;$i+=3){
				
	   $insertPmo = sprintf("INSERT INTO detalle_prestamo (idPrestamo, Noinventario, cantidad, descripcion) VALUES (%s, %s, %s, %s)",
						   GetSQLValueString($last_insert_id_prestamo, "int"),
						   GetSQLValueString($cadenaprestamo[$i], "int"),
						   GetSQLValueString($cadenaprestamo[$i+1], "int"),
						   GetSQLValueString($cadenaprestamo[$i+2], "text"));
						
	  mysql_select_db($database_conexion, $conexion);
	  $Result3 = mysql_query( $insertPmo, $conexion) or die(mysql_error());
	 
		}
	   if($Result3 > 0){
		echo 1; 
	  }
	  else{
		echo 0;
	  }
  

	 $insertequipos= "INSERT INTO equipos_externos (codIngreso, fechaingreso, horaingreso) VALUES ($codIngreso, '$fecha','$horaentrada')";
	
	   mysql_select_db($database_conexion, $conexion);
	  $Result4 = mysql_query($insertequipos, $conexion) or die(mysql_error());
	  $last_insert_id_equipos = mysql_insert_id();
	
	   if($Result4 > 0){
	  
	  echo 1;
	  }
	  else{
	   
		echo 0;
	  }
 
 
 
 
	 $cadenaequipos=explode(',',$_POST['arrayequipos']);
	 
	 for($i=0; $i<count($cadenaequipos)-1;$i+=3){
				
	   $insertdetalleequipos = sprintf("INSERT INTO detalle_equipos_externos (Idingreso,cantidad, equipo,detalles) VALUES (%s, %s, %s, %s)",
						   GetSQLValueString($last_insert_id_equipos, "int"),
						   GetSQLValueString($cadenaequipos[$i], "int"),
						   GetSQLValueString($cadenaequipos[$i+1], "text"),
						   GetSQLValueString($cadenaequipos[$i+2], "text"));
						
	  mysql_select_db($database_conexion, $conexion);
	  $Result5 = mysql_query( $insertdetalleequipos, $conexion) or die(mysql_error());
	 
		}
	   if($Result5 > 0){
		echo 1; 
	  }
	  else{
		echo 0;
	  }	
	
	}

	 else if($prestamo==1 && $ingresoequipo==0 )
	 {
		 $estado=2;
		 
		   mysql_select_db($database_conexion, $conexion);
	 
		   $updateIngreso = "UPDATE ingreso_salida SET estado=$estado WHERE codIngreso= $codIngreso";
		   $Result1 = mysql_query($updateIngreso, $conexion) or die(mysql_error());
		   $numerofilasafectadas= mysql_affected_rows();
		  
		  if($numerofilasafectadas > 0)
		  {
			echo 1;  
		  }
		  else if($numerofilasafectadas==0)
		  {
			echo 0;  
		  }
		 
		 $insertprestamo= "INSERT INTO prestamorecursos (fechaprestamo, horaentrega, codUsuario,codIngreso) VALUES ('$fecha','$horaentrada',$usuario, $codIngreso)";
	
	   mysql_select_db($database_conexion, $conexion);
	  $Result2 = mysql_query($insertprestamo, $conexion) or die(mysql_error());	
	   $last_insert_id_prestamo = mysql_insert_id();
	  
	  if($Result2 > 0){
	  
	  echo 1;
	  }
	  else{
	   
		echo 0;
	  }
	  
	
	 $cadenaprestamo=explode(',',$_GET['arrayprestamo']);
	
	 
	  for($i=0; $i<count($cadenaprestamo)-1;$i+=3){
				
	   $insertPmo = sprintf("INSERT INTO detalle_prestamo (idPrestamo, Noinventario, cantidad, descripcion) VALUES (%s, %s, %s, %s)",
						   GetSQLValueString($last_insert_id_prestamo, "int"),
						   GetSQLValueString($cadenaprestamo[$i], "int"),
						   GetSQLValueString($cadenaprestamo[$i+1], "int"),
						   GetSQLValueString($cadenaprestamo[$i+2], "text"));
						
	  mysql_select_db($database_conexion, $conexion);
	  $Result3 = mysql_query( $insertPmo, $conexion) or die(mysql_error());
	 
		}
	   if($Result3 > 0){
		echo 1; 
	  }
	  else{
		echo 0;
	  }
	 }
	  else if($prestamo==0 && $ingresoequipo==1)
	  {
		 $estado=3;	
		 
			mysql_select_db($database_conexion, $conexion);
	 
		   $updateIngreso = "UPDATE ingreso_salida SET estado=$estado WHERE codIngreso= $codIngreso";
		   $Result1 = mysql_query($updateIngreso, $conexion) or die(mysql_error());
		   $numerofilasafectadas= mysql_affected_rows();
		  
		  if($numerofilasafectadas > 0)
		  {
			echo 11;  
		  }
		  else if($numerofilasafectadas==0)
		  {
			echo 0;  
		  }
		  
		  $insertequipos= "INSERT INTO equipos_externos (codIngreso, fechaingreso, horaingreso) VALUES ($codIngreso, '$fecha','$horaentrada')";
	
		  mysql_select_db($database_conexion, $conexion);
		  $Result2 = mysql_query($insertequipos, $conexion) or die(mysql_error());
		  $last_insert_id_equipos = mysql_insert_id();
		
		   if($Result2 > 0)
		   {
			 echo 1;
		  }
		  else
		  {
			echo 0;
		  }
 
 
	 $cadenaequipos=explode(',',$_POST['arrayequipos']);
	 
	 for($i=0; $i<count($cadenaequipos)-1;$i+=3){
				
	   $insertdetalleequipos = sprintf("INSERT INTO detalle_equipos_externos (Idingreso,cantidad, equipo,detalles) VALUES (%s, %s, %s, %s)",
						   GetSQLValueString($last_insert_id_equipos, "int"),
						   GetSQLValueString($cadenaequipos[$i], "int"),
						   GetSQLValueString($cadenaequipos[$i+1], "text"),
						   GetSQLValueString($cadenaequipos[$i+2], "text"));
						
	  mysql_select_db($database_conexion, $conexion);
	  $Result3 = mysql_query( $insertdetalleequipos, $conexion) or die(mysql_error());
	 
		}
	   if($Result3 > 0)
	   {
		 echo 1; 
	   }
	  else
	  {
		echo 0;
	   }
		 
	  }// cierro else
    }// cierro $totalRows_JRCodingreso
	else
	{
		 if($totalRows_JRCodingreso==0)
		 {
		   echo 2; 
		 }
		 else if($totalRows_JRCodingreso > 1)
		 {
			echo 3; 
		 }	
	}
 }// cierro $totalRows_JRUsuarios
 else
 {
	echo 4; 
 }

  ?>
<?php

mysql_free_result($JRUsuarios);
mysql_free_result($JRCodingreso);

?>
