<?php require_once('../../Connections/conexion.php'); ?>
<?php  date_default_timezone_set("America/bogota"); ?>
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
 $asignatura= $_POST['asignatura']; 
 $grupo= $_POST['grupo'];
 $nuevoestado=0;
 $idPrestamo=0;
 $idingreso= 0;

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
$query_JRMenoringreso = "select min(codIngreso) as menor, estado, computador from ingreso_salida where codUsuario=$usuario and fecha='$fecha' and estado <> 1;
";
$JRMenoringreso = mysql_query($query_JRMenoringreso, $conexion) or die(mysql_error());
$row_JRMenoringreso = mysql_fetch_assoc($JRMenoringreso);
$totalRows_JRMenoringreso = mysql_num_rows($JRMenoringreso);

 $ingresomin= $row_JRMenoringreso['menor'];
 $estadomin=  $row_JRMenoringreso['estado'];
 

mysql_select_db($database_conexion, $conexion);
$query_JRMayoringreso = "select max(codIngreso) as mayor, estado,computador from ingreso_salida where codUsuario=$usuario and fecha='$fecha' and estado <> 1;
";
$JRMayoringreso = mysql_query($query_JRMayoringreso, $conexion) or die(mysql_error());
$row_JRMayoringreso = mysql_fetch_assoc($JRMayoringreso);
$totalRows_JRMayoringreso = mysql_num_rows($JRMayoringreso);

$ingresomax= $row_JRMayoringreso['mayor'];
$estadomax= $row_JRMayoringreso['estado'];
$pcmax= $row_JRMayoringreso['computador'];

if($totalRows_JRMenoringreso > 0 && $totalRows_JRMayoringreso > 0 )
{

   mysql_select_db($database_conexion, $conexion);
    $query_JRBprestamoR = "SELECT idPrestamo FROM prestamorecursos WHERE codIngreso = $ingresomin";
    $JRBprestamoR = mysql_query($query_JRBprestamoR, $conexion) or die(mysql_error());
   $row_JRBprestamoR = mysql_fetch_assoc($JRBprestamoR);
   $totalRows_JRBprestamoR = mysql_num_rows($JRBprestamoR);
   
    $idPrestamomin=  $row_JRBprestamoR['idPrestamo'];
	
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRBequipos = "SELECT Idingreso FROM equipos_externos WHERE codIngreso = $ingresomin";
	$JRBequipos = mysql_query($query_JRBequipos, $conexion) or die(mysql_error());
	$row_JRBequipos = mysql_fetch_assoc($JRBequipos);
	$totalRows_JRBequipos = mysql_num_rows($JRBequipos);
	
	 $idingresomin= $row_JRBequipos['Idingreso'];
	 
	 mysql_select_db($database_conexion, $conexion);
    $query_JRBprestamoRmax = "SELECT idPrestamo FROM prestamorecursos WHERE codIngreso = $ingresomax";
    $JRBprestamoRmax = mysql_query($query_JRBprestamoRmax, $conexion) or die(mysql_error());
   $row_JRBprestamoRmax = mysql_fetch_assoc($JRBprestamoRmax);
   $totalRows_JRBprestamoRmax = mysql_num_rows($JRBprestamoRmax);
   
    $idPrestamomax=  $row_JRBprestamoRmax['idPrestamo'];
	
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRBequiposmax = "SELECT Idingreso FROM equipos_externos WHERE codIngreso = $ingresomax";
	$JRBequiposmax = mysql_query($query_JRBequiposmax, $conexion) or die(mysql_error());
	$row_JRBequiposmax = mysql_fetch_assoc($JRBequiposmax);
	$totalRows_JRBequiposmax = mysql_num_rows($JRBequiposmax);
	
	 $idingresomax= $row_JRBequiposmax['Idingreso'];
	 
	 
	 if ($totalRows_JRBprestamoR > 0 && $totalRows_JRBequipos  > 0 )
     {
	   
		  
		  $nuevoestado=4;
		  $idPrestamo=$row_JRBprestamoR['idPrestamo'];
		  $idingreso= $row_JRBequipos['Idingreso'];
	
    }
  
  else if ($totalRows_JRBprestamoRmax > 0 && $totalRows_JRBequiposmax  > 0 )
   {
     
      $nuevoestado=4;
      $idPrestamo=$row_JRBprestamoRmax['idPrestamo'];
      $idingreso= $row_JRBequiposmax['Idingreso'];
	
  }
	else if($totalRows_JRBprestamoR > 0)
    {
        $nuevoestado=2;
        $idPrestamo=$row_JRBprestamoR['idPrestamo'];
   }
   
   else if( $totalRows_JRBprestamoRmax > 0)
    {
       $nuevoestado=2;
       $idPrestamo=$row_JRBprestamoRmax['idPrestamo'];
   }
   
   else if($totalRows_JRBequipos  > 0)
   { 
      
      $nuevoestado=3; 
      $idingreso= $row_JRBequipos['Idingreso'];
   }
   
  
   else if($totalRows_JRBequiposmax  > 0)
   { 
	  $nuevoestado=3; 
      $idingreso= $row_JRBequiposmax['Idingreso'];
   }
  
  else
  {
    $nuevoestado=5; 
  }

	 
	 


$insertSQL = sprintf("INSERT INTO ingreso_salida (codUsuario, actividad, codAsignatura,codGrupo, sala, dependencia, estamento, computador, fecha, horaingreso, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",

                  
                       GetSQLValueString($usuario, "int"),
					   GetSQLValueString($actividad, "text"),
					   GetSQLValueString($asignatura, "text"),
					   GetSQLValueString($grupo, "int"),
                       GetSQLValueString($sala, "int"),
                       GetSQLValueString($dependencia, "text"),
                       GetSQLValueString($estamento, "text"),
                       GetSQLValueString($pc, "int"),
                       GetSQLValueString($fecha, "date"),
                       GetSQLValueString($horaentrada, "date"),
                       GetSQLValueString($nuevoestado, "int"));
					   
					   
                       

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  $nuevoingreso = mysql_insert_id();
  
  if($Result1==1)
  {
	echo 1;  
  }
  else
  {
	echo 0;  
  }
  
  
	
	
   if($nuevoestado==2)
   {
  
  
	  $updateprestamos = sprintf("UPDATE prestamorecursos SET codIngreso=%s WHERE idPrestamo=%s",
						   GetSQLValueString($nuevoingreso, "int"),
						   GetSQLValueString($idPrestamo, "int"));
	
	  mysql_select_db($database_conexion, $conexion);
	  $Result2 = mysql_query($updateprestamos, $conexion) or die(mysql_error());
	  
	  if($Result2 > 0)
	  {
		echo 1;  
	  }
	  else
	  {
		echo 0;  
	  }
	
	  
   }
	else if($nuevoestado==3) 
	{
	 
	  $updateequipos = sprintf("UPDATE equipos_externos SET codIngreso=%s WHERE Idingreso=%s",
						   GetSQLValueString($nuevoingreso, "int"),
						   GetSQLValueString($idingreso, "int"));
	
	  mysql_select_db($database_conexion, $conexion);
	  $Result3 = mysql_query($updateequipos, $conexion) or die(mysql_error());
	  
	  if($Result3 > 0)
	  {
		echo 1;  
	  }
	  else
	  {
		echo 0;  
	  }
	  
	}
	
	else if($nuevoestado==4)
	{
	  $updateprestamos1 = sprintf("UPDATE prestamorecursos SET codIngreso=%s WHERE idPrestamo=%s",
						   GetSQLValueString($nuevoingreso, "int"),
						   GetSQLValueString($idPrestamo, "int"));
	
	  mysql_select_db($database_conexion, $conexion);
	  $Result4 = mysql_query($updateprestamos1, $conexion) or die(mysql_error());
	
	  
	  
	  
	  $updateequipos1 = sprintf("UPDATE equipos_externos SET codIngreso=%s WHERE Idingreso=%s",
						   GetSQLValueString($nuevoingreso, "int"),
						   GetSQLValueString($idingreso, "int"));
	
	  mysql_select_db($database_conexion, $conexion);
	  $Result5 = mysql_query($updateequipos1, $conexion) or die(mysql_error());
	  
	  if($Result4 > 0 && $Result5 > 0)
	  {
		echo 1;  
	  }
	  else
	  {
		echo 0;  
	  }
	
	 
	}
	
	
	$updateingresomin= "UPDATE ingreso_salida SET estado=1 WHERE codIngreso= $ingresomin";
  mysql_select_db($database_conexion, $conexion);
  $Result6 = mysql_query(  $updateingresomin, $conexion) or die(mysql_error());
  
  if($Result6==1)
  {
	echo 1;  
  }
  else
  {
	echo 0;  
  }
 	

  
  
  $updateingresomax= "UPDATE ingreso_salida SET estado=1, horasalida='$horaentrada' WHERE codIngreso= $ingresomax";
  mysql_select_db($database_conexion, $conexion);
  $Result7= mysql_query($updateingresomax, $conexion) or die(mysql_error());
  
  if($Result7==1)
  {
	echo 1;  
  }
  else
  {
	echo 0;  
  }
 	

  
   $updatepcmax= "UPDATE pcs SET estadoocupacion='disponible' WHERE Nopc= $pcmax";
  mysql_select_db($database_conexion, $conexion);
  $Result8 = mysql_query($updatepcmax, $conexion) or die(mysql_error());
  
   if($Result8==1)
  {
	echo 1;  
  }
  else
  {
	echo 0;  
  }
  
}// cierro if

//mysql_free_result($JRIngresousuario);

//mysql_free_result($JRBprestamoR);

//mysql_free_result($JRBequipos);

//mysql_free_result($JRpcActividad);

//mysql_free_result($JRMenoringreso);

//mysql_free_result($JRCusuario);

?>

