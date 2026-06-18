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

$campo=$_POST['campo'];
$nuevovalor=$_POST['nuevovalor'];
$valorllave=$_POST['valorllave'];
/*if($campo != "estado")
{
  $nuevovalor= mb_convert_case($_POST['nuevovalor'], MB_CASE_TITLE, "UTF-8");
  $valorllave=$_POST['valorllave'];
}

else
{*/
   //$nuevovalor=$_POST['nuevovalor'];
   //$valorllave=$_POST['valorllave'];
//}



mysql_select_db($database_conexion, $conexion);
 
    $updateSQL = "UPDATE monitores SET $campo= '$nuevovalor' WHERE vccedula= $valorllave";
    mysql_query("SET NAMES 'utf8'");
    $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

 if($Result1==1)
 {
	echo 1;
 }
 else
	{
	  echo 0;
	}


 
?>

