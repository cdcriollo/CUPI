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

if(isset($_POST['codigo'],$_POST['grupo'],$_POST['actividad'],$_POST['nombre'],$_POST['insertarAsig']))
{
	
$nombreAsignatura=$_POST['nombre'];
$insertarAsig=$_POST['insertarAsig'];

if($insertarAsig==1)
{

    $insertSQL = sprintf("INSERT INTO asignatura (codAsignatura, nomAsignatura, actividad) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['codigo'], "text"),
                       GetSQLValueString($nombreAsignatura, "text"),
                       GetSQLValueString($_POST['actividad'], "text"));
                      
                       
					   

   mysql_select_db($database_conexion, $conexion);
   mysql_query("SET NAMES 'utf8'");
   $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  
  if($Result1==1){
	echo 1; 
  }
  else{
	echo 0;
  }
  
  $insertgrupo = sprintf("INSERT INTO grupo_x_asignatura (codGrupo, codAsignatura) VALUES (%s, %s)",
                       GetSQLValueString($_POST['grupo'], "int"),
                       GetSQLValueString($_POST['codigo'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($insertgrupo, $conexion) or die(mysql_error());

   if($Result2==1){
	echo 1; 
  }
  else{
	echo 0;
  }

  }// cierro if
  
  else if($insertarAsig ==2)
  {
  
    $insertgrupo = sprintf("INSERT INTO grupo_x_asignatura (codGrupo, codAsignatura) VALUES (%s, %s)",
                       GetSQLValueString($_POST['grupo'], "int"),
                       GetSQLValueString($_POST['codigo'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result5 = mysql_query($insertgrupo, $conexion) or die(mysql_error());

   if($Result5==1){
	echo 1; 
  }
  else{
	echo 0;
  }
  }// cierro if
}

?>

