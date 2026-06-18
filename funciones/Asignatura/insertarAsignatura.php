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

$grupo=$_POST['grupoHorario'];
$codigo=$_POST['codigo'];

  mysql_select_db($database_conexion, $conexion);
  $insertgrupo = "INSERT INTO grupo_x_asignatura (codGrupo, codAsignatura) VALUES ($grupo,'$codigo')";
  $Result1 = mysql_query($insertgrupo, $conexion) or die(mysql_error());
  
 

   if($Result1==1){
	echo 1; 
  }
  else{
	echo 0;
  }
  
  
  
  
   $arrayhorarios=explode(',',$_POST['horario']);
   
 
  
	  for($i=0; $i<count($arrayhorarios)-1;$i+=4){
		  
		  $dia=$arrayhorarios[$i];  
		  $horainicio=$arrayhorarios[$i+1];
		  $horafinal=$arrayhorarios[$i+2];      
		  $sala=$arrayhorarios[$i+3];
	
	  mysql_select_db($database_conexion, $conexion);	    
     $insertSQL= "INSERT INTO horario (codGrupo, codAsignatura, codDia, horainicio, horafinal,sala) VALUES ($grupo, '$codigo',$dia,'$horainicio','$horafinal', $sala)";
                       
                    

  $Result2 = mysql_query($insertSQL, $conexion) or die(mysql_error());
 
	}
   if($Result2==1){
	echo 1; 
  }
  else{
	echo 0;
  }
  
  

?>

