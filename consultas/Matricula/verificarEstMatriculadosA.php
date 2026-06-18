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

$asignatura= $_POST['asignatura'];
$grupo=$_POST['grupo'];

mysql_select_db($database_conexion, $conexion);
$query_JRExistMatA = "SELECT * FROM matricula WHERE codAsignatura = '$asignatura' and grupo=$grupo and Estado='Activa'";
mysql_query("SET NAMES 'utf8'");
$JRExistMatA = mysql_query($query_JRExistMatA, $conexion) or die(mysql_error());
$row_JRExistMatA = mysql_fetch_assoc($JRExistMatA);
$totalRows_JRExistMatA = mysql_num_rows($JRExistMatA);

if($totalRows_JRExistMatA > 0)
{
	echo 1;
	
}
 else
 {
  echo 0;
 }

 mysql_free_result($JRExistMatA);
 mysql_close($conexion);
?>
