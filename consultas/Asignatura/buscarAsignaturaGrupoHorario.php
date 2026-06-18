<?php require_once('../../Connections/conexion.php'); ?>
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

if(isset($_POST['codigo'], $_POST['grupo']))
{
  $codigo=$_POST['codigo'];
  $grupo= $_POST['grupo'];
  
  // realiza una consulta para verificar si la asignatura existe definida con otro grupo
   mysql_select_db($database_conexion, $conexion);
   $query_JRAsignaturas = "SELECT codAsignatura, codGrupo FROM  grupo_x_asignatura  WHERE codAsignatura = '$codigo'";
   
    mysql_query("SET NAMES 'utf8'");
	$JRAsignaturas = mysql_query($query_JRAsignaturas, $conexion) or die(mysql_error());
	$row_JRAsignaturas = mysql_fetch_assoc($JRAsignaturas);
	$totalRows_JRAsignaturas = mysql_num_rows($JRAsignaturas);
	
	 mysql_free_result($JRAsignaturas);
	
 // veridica si la asignatura y el grupo ya se encuentran definidos
    mysql_select_db($database_conexion, $conexion);
   $query_JRAsignaturas1 = "SELECT codAsignatura, codGrupo FROM grupo_x_asignatura  WHERE codAsignatura = '$codigo' and codGrupo=$grupo";
   
    mysql_query("SET NAMES 'utf8'");
	$JRAsignaturas1 = mysql_query($query_JRAsignaturas1, $conexion) or die(mysql_error());
	$row_JRAsignaturas1 = mysql_fetch_assoc($JRAsignaturas1);
	$totalRows_JRAsignaturas1 = mysql_num_rows($JRAsignaturas1);
	
	 mysql_free_result($JRAsignaturas1);
	
  
   if($totalRows_JRAsignaturas1 == 0 && $totalRows_JRAsignaturas==0)
   {
      echo 0; // se puede insertar la asignatura y el grupo 
   }
   else if($totalRows_JRAsignaturas1 == 0 && $totalRows_JRAsignaturas > 0 )
   {
       echo 1; // solo se puede insertar el grupo
   }
   
   else if($totalRows_JRAsignaturas1 > 0 && $totalRows_JRAsignaturas > 0 )
   {
       echo 3; // la aasignatura ya tiene definido un grupo 
   }
   	
	mysql_close($conexion);
}
?>
<?php

 
?>