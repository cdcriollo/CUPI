
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
$cedula= $_POST['cedula'];
$codigo= $_POST['codigo'];
$nombres=trim(mb_convert_case($_POST['nombres'], MB_CASE_TITLE, "UTF-8"));
$apellidos=trim(mb_convert_case($_POST['apellidos'], MB_CASE_TITLE, "UTF-8"));
$progacademico=  $_POST['progacademico'];
$dirresidencia=  $_POST['dirresidencia'];
$celular=  $_POST['celular'];
$telefono= $_POST['telefono']; 
$email=$_POST['email'];

  mysql_select_db($database_conexion, $conexion);
  $insertSQL = "INSERT INTO monitores (vccedula, vccodigo, vcnombres, vcapellidos, vcprogramaacademico, vcdireccionresidencia,vccelular, vctelefonofijo, vcemail) VALUES ('$cedula','$codigo','$nombres','$apellidos','$progacademico', '$dirresidencia', '$celular', '$telefono', '$email')";
  mysql_query("SET NAMES 'utf8'");
  $Result2 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  
  if($Result2==1){
  
  echo 1;
  }
  else{
   
	echo 0;
  }
 
 
?>
