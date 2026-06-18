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


$usuario=$_POST['usuario'];
$actividad=$_POST['actividad'];
$sala=$_POST['sala'];
$computador=$_POST['computador'];
$prestamo=$_POST['insertprestamo'];
$ingresoequipo=$_POST['insertequipo'];
$asignatura=$_POST['asignatura'];
$pc= $_POST['pc'];
$grupo=$_POST['grupo'];

	
$estado=0;

mysql_select_db($database_conexion, $conexion);
$query_JRUsuarios = "SELECT estamento, dependencia FROM usuarios WHERE codUsuario= $usuario ";
mysql_query("SET NAMES 'utf8'");
$JRUsuarios = mysql_query($query_JRUsuarios, $conexion) or die(mysql_error());
$row_JRUsuarios = mysql_fetch_assoc($JRUsuarios);
$totalRows_JRUsuarios = mysql_num_rows($JRUsuarios);

// se obtienen  la dependencia del usuario  y el estamento
$dependencia= $row_JRUsuarios['dependencia']; 
$estamento= $row_JRUsuarios['estamento']; 

// se obtiene la fecha de ingreso
$fecha= date('Y'.'-'.'m'.'-'.'d');
// se obtiene la hora de ingreso
$horaentrada= date('H:i');


if($prestamo==1 and $ingresoequipo==1)
{
	
  $estado=4;	
	
if($asignatura=="NULL" && $grupo=="NULL"){
	
$insertSQL= "INSERT INTO ingreso_salida (codUsuario, actividad, sala, dependencia, estamento, computador, fecha, horaingreso, estado) VALUES ($usuario, '$actividad', $sala,'$dependencia','$estamento', $computador, '$fecha', '$horaentrada', $estado)";

              

  mysql_select_db($database_conexion, $conexion);
  mysql_query("SET NAMES 'utf8'");
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
   $last_insert_id = mysql_insert_id();

   if($Result1 > 0){
  
     echo 1;
   }
    else{
   
	echo 0;
  }
}
else if($asignatura!="NULL" && $grupo!="NULL"){
	
$insertSQL= "INSERT INTO ingreso_salida (codUsuario, actividad, sala, dependencia, estamento, computador, fecha, horaingreso, estado, codAsignatura, codGrupo) VALUES ($usuario, '$actividad', $sala,'$dependencia','$estamento', $computador, '$fecha', '$horaentrada', $estado, '$asignatura', $grupo)";

              

  mysql_select_db($database_conexion, $conexion);
  mysql_query("SET NAMES 'utf8'");
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
   $last_insert_id = mysql_insert_id();

   if($Result1 > 0){
  
     echo 1;
   }
    else{
   
	echo 0;
  }	
	
	
	
}
	
$insertprestamo= "INSERT INTO prestamorecursos (fechaprestamo, horaentrega, codUsuario,codIngreso) VALUES ('$fecha','$horaentrada',$usuario, $last_insert_id )";

   mysql_select_db($database_conexion, $conexion);
   mysql_query("SET NAMES 'utf8'");
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
                       GetSQLValueString($cadenaprestamo[$i], "text"),
                       GetSQLValueString($cadenaprestamo[$i+1], "int"),
					   GetSQLValueString($cadenaprestamo[$i+2], "text"));
                    
		  mysql_select_db($database_conexion, $conexion);
		  mysql_query("SET NAMES 'utf8'");
		  $Result3 = mysql_query( $insertPmo, $conexion) or die(mysql_error());
		  
		  mysql_select_db($database_conexion, $conexion);
          $updateSQL = "UPDATE recursos SET estadoprestamo='Prestado' WHERE Noinventario= '$cadenaprestamo[$i]'";
          $Result4 = mysql_query($updateSQL, $conexion) or die(mysql_error());
		  $filasafectadasrecurso= mysql_affected_rows();
 
	}
	
   if($Result3 > 0 && $filasafectadasrecurso > 0){
	echo 1; 
  }
  else  if($Result3== 0 && $filasafectadasrecurso ==0)
  {
	echo 0;
  }
  

 $insertequipos= "INSERT INTO equipos_externos (codIngreso, fechaingreso, horaingreso) VALUES ( $last_insert_id, '$fecha','$horaentrada')";

   mysql_select_db($database_conexion, $conexion);
   mysql_query("SET NAMES 'utf8'");
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
  mysql_query("SET NAMES 'utf8'");
  $Result5 = mysql_query( $insertdetalleequipos, $conexion) or die(mysql_error());
 
	}
   if($Result5 > 0){
	echo 1; 
  }
  else
  {
	echo 0;
  }
    
	$actualizarpcs = "UPDATE pcs SET estadoocupacion='ocupado' WHERE Nopc= $pc ";              

  mysql_select_db($database_conexion, $conexion);
  $Result6 = mysql_query( $actualizarpcs , $conexion) or die(mysql_error());
 

   if($Result6 > 0){
  
  echo 1;
  }
  else
  {
    echo 0;
  }
  
 

}// cierro if

else if($prestamo==0 && $ingresoequipo==0 ){
	
$estado=5;	

if($asignatura=="NULL" && $grupo=="NULL"){

$insertSQL= "INSERT INTO ingreso_salida (codUsuario, actividad, sala, dependencia, estamento, computador, fecha, horaingreso, estado) VALUES ($usuario, '$actividad', $sala,'$dependencia','$estamento', $computador, '$fecha', '$horaentrada', $estado)";

              

  mysql_select_db($database_conexion, $conexion);
  mysql_query("SET NAMES 'utf8'");
  $Result7 = mysql_query($insertSQL, $conexion) or die(mysql_error());

   if($Result7 > 0){
  
     echo 1;
  }
  else{
   
	echo 0;
  }	

}

else if($asignatura!= "NULL" && $grupo!="NULL"){


$insertSQL= "INSERT INTO ingreso_salida (codUsuario, actividad, sala, dependencia, estamento, computador, fecha, horaingreso, estado, codAsignatura, codGrupo) VALUES ($usuario, '$actividad', $sala,'$dependencia','$estamento', $computador, '$fecha', '$horaentrada', $estado, '$asignatura', $grupo)";

              

  mysql_select_db($database_conexion, $conexion);
  mysql_query("SET NAMES 'utf8'");
  $Result7 = mysql_query($insertSQL, $conexion) or die(mysql_error());

   if($Result7 > 0){
  
     echo 1;
  }
  else{
   
	echo 0;
  }		
}

$actualizarpcs = "UPDATE pcs SET estadoocupacion='ocupado' WHERE Nopc= $pc ";              

  mysql_select_db($database_conexion, $conexion);
  $Result8 = mysql_query( $actualizarpcs , $conexion) or die(mysql_error());
 

   if($Result8 > 0){
  
  echo 1;
  }
  else{
   
	echo 0;
  }
	
}// cierro if

 else if($prestamo==1 && $ingresoequipo==0 )
 
 {
	 
	 $estado=2;
	 
	if($asignatura=="NULL" && $grupo=="NULL"){ 
	 
     $insertSQL= "INSERT INTO ingreso_salida (codUsuario, actividad, sala, dependencia, estamento, computador, fecha, horaingreso, estado) VALUES ($usuario, '$actividad', $sala,'$dependencia','$estamento', $computador, '$fecha', '$horaentrada', $estado)";

              

  mysql_select_db($database_conexion, $conexion);
  mysql_query("SET NAMES 'utf8'");
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  $last_insert_id = mysql_insert_id();

   if($Result1 > 0){
  
  echo 1;
  }
  else{
   
	echo 0;
  }
 
 }
 
 else if($asignatura!= "NULL"){
	 
	$insertSQL= "INSERT INTO ingreso_salida (codUsuario, actividad, sala, dependencia, estamento, computador, fecha, horaingreso, estado, codAsignatura,codGrupo) VALUES ($usuario, '$actividad', $sala,'$dependencia','$estamento', $computador, '$fecha', '$horaentrada', $estado, '$asignatura', $grupo)";

              

  mysql_select_db($database_conexion, $conexion);
  mysql_query("SET NAMES 'utf8'");
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  $last_insert_id = mysql_insert_id();

   if($Result1 > 0){
  
  echo 1;
  }
  else{
   
	echo 0;
  } 
	 
 }
 
	
$insertprestamo= "INSERT INTO prestamorecursos (fechaprestamo, horaentrega, codUsuario,codIngreso) VALUES ('$fecha','$horaentrada',$usuario, $last_insert_id )";

   mysql_select_db($database_conexion, $conexion);
   mysql_query("SET NAMES 'utf8'");
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
                       GetSQLValueString($cadenaprestamo[$i], "text"),
                       GetSQLValueString($cadenaprestamo[$i+1], "int"),
					   GetSQLValueString($cadenaprestamo[$i+2], "text"));
                    
   mysql_select_db($database_conexion, $conexion);
   mysql_query("SET NAMES 'utf8'");
   $Result3 = mysql_query( $insertPmo, $conexion) or die(mysql_error());
  
   mysql_select_db($database_conexion, $conexion);
   $updateSQL = "UPDATE recursos SET estadoprestamo='Prestado' WHERE Noinventario= '$cadenaprestamo[$i]'";
   $Result4 = mysql_query($updateSQL, $conexion) or die(mysql_error());
   $filasafectadasrecurso= mysql_affected_rows();
 
	}
	
   if($Result3 > 0 && $filasafectadasrecurso > 0 )
   {
	 echo 1; 
   }
   
   else if($Result3== 0 && $filasafectadasrecurso == 0 )
   {
	  echo 0;
   }
  
  
  $actualizarpcs = "UPDATE pcs SET estadoocupacion='ocupado' WHERE Nopc= $pc ";              
  mysql_select_db($database_conexion, $conexion);
  $Result9 = mysql_query( $actualizarpcs , $conexion) or die(mysql_error());
 

   if($Result9 > 0)
   {
     echo 1;
   }
   else
   {
     echo 0;
   }

 
 }
 
 else if($prestamo==0 && $ingresoequipo==1){
	 
$estado=3;	

 if($asignatura=="NULL" && $grupo=="NULL"){ 
 
  $insertSQL= "INSERT INTO ingreso_salida (codUsuario, actividad, sala, dependencia, estamento, computador, fecha, horaingreso, estado) VALUES ($usuario, '$actividad', $sala,'$dependencia','$estamento', $computador, '$fecha', '$horaentrada', $estado)";

              

  mysql_select_db($database_conexion, $conexion);
  mysql_query("SET NAMES 'utf8'");
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  $last_insert_id = mysql_insert_id();

   if($Result1 > 0){
  
  echo 1;
  }
  else{
   
	echo 0;
  }
  
 }
 else if($asignatura!="NULL" && $grupo!="NULL"){ 
 
  $insertSQL= "INSERT INTO ingreso_salida (codUsuario, actividad, sala, dependencia, estamento, computador, fecha, horaingreso, estado, codAsignatura, codGrupo) VALUES ($usuario, '$actividad', $sala,'$dependencia','$estamento', $computador, '$fecha', '$horaentrada', $estado, '$asignatura', $grupo)";

              

  mysql_select_db($database_conexion, $conexion);
  mysql_query("SET NAMES 'utf8'");
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  $last_insert_id = mysql_insert_id();

   if($Result1 > 0){
  
  echo 1;
  }
  else{
   
	echo 0;
  }
 }
  
  $insertequipos= "INSERT INTO equipos_externos (codIngreso, fechaingreso, horaingreso) VALUES ( $last_insert_id, '$fecha','$horaentrada')";

  mysql_select_db($database_conexion, $conexion);
  mysql_query("SET NAMES 'utf8'");
  $Result5 = mysql_query($insertequipos, $conexion) or die(mysql_error());
  $last_insert_id_equipos = mysql_insert_id();

   if($Result5 > 0){
  
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
  mysql_query("SET NAMES 'utf8'");
  $Result6 = mysql_query( $insertdetalleequipos, $conexion) or die(mysql_error());
 
	}
   if($Result6 > 0){
	echo 1; 
  }
  else{
	echo 0;
  }
  
  $actualizarpcs = "UPDATE pcs SET estadoocupacion='ocupado' WHERE Nopc= $pc ";              

  mysql_select_db($database_conexion, $conexion);
  $Result10 = mysql_query( $actualizarpcs , $conexion) or die(mysql_error());
 

   if($Result10 > 0){
  
  echo 1;
  }
  else{
   
	echo 0;
  }
 
 }
  mysql_free_result($JRUsuarios);
  mysql_close($conexion);
?>
