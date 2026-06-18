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

$dependencia= trim(mb_convert_case($_POST['dependencia'], MB_CASE_TITLE, "UTF-8"));

mysql_select_db($database_conexion, $conexion);
$query_JRCDependencia = "SELECT Iddependencia FROM dependencias WHERE descripcion = '$dependencia'";
mysql_query("SET NAMES 'utf8'");
$JRCDependencia = mysql_query($query_JRCDependencia, $conexion) or die(mysql_error());
$row_JRCDependencia = mysql_fetch_assoc($JRCDependencia);
$totalRows_JRCDependencia = mysql_num_rows($JRCDependencia);

  if($totalRows_JRCDependencia == 0)
   {

      $insertSQL = sprintf("INSERT INTO dependencias (descripcion) VALUES (%s)",
      GetSQLValueString($dependencia, "text"));
      mysql_select_db($database_conexion, $conexion);
	  mysql_query("SET NAMES 'utf8'");
      $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }

mysql_free_result($JRCDependencia);
mysql_close($conexion);
?>

