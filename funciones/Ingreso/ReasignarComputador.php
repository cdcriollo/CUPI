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


$pc=$_POST['pc'];
$usuario= $_POST['usuario'];
$sala=  $_POST['sala'];
$fecha= date('Y'.'-'.'m'.'-'.'d');



	mysql_select_db($database_conexion, $conexion);
	$query_JRVerdispallpc = "SELECT Nopc FROM pcs WHERE numSala = $sala and estadoocupacion='disponible'";
	$JRVerdispallpc = mysql_query($query_JRVerdispallpc, $conexion) or die(mysql_error());
	$row_JRVerdispallpc = mysql_fetch_assoc($JRVerdispallpc);
	$totalRows_JRVerdispallpc = mysql_num_rows($JRVerdispallpc);


   if($totalRows_JRVerdispallpc > 0)
   {
	
	
		mysql_select_db($database_conexion, $conexion);
		$query_JRVerificarsala = "select numSala from pcs where numSala=$sala and Nopc=$pc";
		$JRVerificarsala = mysql_query($query_JRVerificarsala, $conexion) or die(mysql_error());
		$row_JRVerificarsala = mysql_fetch_assoc($JRVerificarsala);
		$totalRows_JRVerificarsala = mysql_num_rows($JRVerificarsala);



     if($totalRows_JRVerificarsala > 0)
     {
		 
		mysql_free_result($JRVerificarsala);
		
		mysql_select_db($database_conexion, $conexion);
		$query_JRDisppc = "SELECT Nopc FROM pcs WHERE estadoocupacion = 'disponible' and Nopc= $pc";
		$JRDisppc = mysql_query($query_JRDisppc, $conexion) or die(mysql_error());
		$row_JRDisppc = mysql_fetch_assoc($JRDisppc);
		$totalRows_JRDisppc = mysql_num_rows($JRDisppc);
    
	 
	
	   if ($totalRows_JRDisppc > 0)
	   {
		   
		    mysql_free_result($JRDisppc);
			
			mysql_select_db($database_conexion, $conexion);
			$query_JRBuscarIngreso = "select codIngreso, computador from Ingreso_salida where codUsuario=$usuario and fecha='$fecha' and estado <> 1 
			";
			$JRBuscarIngreso = mysql_query($query_JRBuscarIngreso, $conexion) or die(mysql_error());
			$row_JRBuscarIngreso = mysql_fetch_assoc($JRBuscarIngreso);
			$totalRows_JRBuscarIngreso = mysql_num_rows($JRBuscarIngreso);
			
			$codIngreso=  $row_JRBuscarIngreso['codIngreso'];
			$computadorAnt= $row_JRBuscarIngreso['computador'];
			
			// Actualizo el computador en la tabla ingreso_salida
			mysql_select_db($database_conexion, $conexion);
			 
			$updateSQL = "UPDATE ingreso_salida SET computador= $pc WHERE codIngreso= $codIngreso";
			$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
			
			// Actualizo el estado del pc en la tabla pcs
			mysql_select_db($database_conexion, $conexion);
			 
			$updatePc = "UPDATE pcs  SET estadoocupacion= 'ocupado' WHERE Nopc= $pc";
			$Result2 = mysql_query($updatePc, $conexion) or die(mysql_error());
			
			// Actualizo el estado del computador que estaba utilizando anteriormente
			
			mysql_select_db($database_conexion, $conexion);
			 
			$updatePcAnt = "UPDATE pcs  SET estadoocupacion= 'disponible' WHERE Nopc= $computadorAnt";
			$Result3 = mysql_query($updatePcAnt, $conexion) or die(mysql_error());
		
		  if($Result1==1 && $Result2==1 && $Result3==1 ){
			  echo 4;
		   }
		  else
		  {
			echo 0;
		  }
		  
		   mysql_free_result($JRBuscarIngreso);
				
	 }// verificar JRDisppc
	 
	 else 
	{
	  echo 3; 	
	}
	
  }// verificar sala
   else{
	  echo 2; 
   }
 
 }// JRVerdispallpc
  else 
  {
	echo 1;
  }

mysql_free_result($JRVerdispallpc);

?>
