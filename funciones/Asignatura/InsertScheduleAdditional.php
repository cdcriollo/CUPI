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


$asignatuta=$_POST['asignatura'];
$grupo=$_POST['grupo'];  
$arrayhorarios=explode(',',$_POST['horario']);

for($i=0; $i<count($arrayhorarios)-1;$i+=6){
		    
   $insertSQL = sprintf("INSERT INTO horario (codGrupo, codAsignatura, codDia, horainicio, horafinal,fechaInicio,fechaFinal,sala) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['grupo'], "int"),
                       GetSQLValueString($_POST['asignatura'], "text"),
                       GetSQLValueString($arrayhorarios[$i], "int"),
                       GetSQLValueString($arrayhorarios[$i+1], "date"),
                       GetSQLValueString($arrayhorarios[$i+2], "date"),
					   GetSQLValueString(implode('-',array_reverse(explode('-',$arrayhorarios[$i+3]))), "date"),
					   GetSQLValueString(implode('-',array_reverse(explode('-',$arrayhorarios[$i+4]))), "date"),
					   GetSQLValueString($arrayhorarios[$i+5], "int"));
                    
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
  