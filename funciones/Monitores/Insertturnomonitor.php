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


$cedula=$_POST['cedula'];
$vinculacion=$_POST['vinculacion'];   
$arrayturnos=explode(',',$_POST['turnos']);

for($i=0; $i<count($arrayturnos)-1;$i+=4){
		    
   $insertSQL = sprintf("INSERT INTO turnos_monitor (dia, hora_entrada, hora_salida, actividad, cedula,No_vinculacion) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($arrayturnos[$i], "int"),
                       GetSQLValueString($arrayturnos[$i+1], "date"),
                       GetSQLValueString($arrayturnos[$i+2], "date"),
					   GetSQLValueString($arrayturnos[$i+3], "text"),
					   GetSQLValueString($cedula, "text"),
                       GetSQLValueString($vinculacion, "text"));
					  
                    
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
 
	}
	
   if($Result1==1)
   {
	echo 1; 
  }
  else
  {
	echo 0;
  }
  