<?php require_once('Connections/conexion.php'); ?>
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

mysql_select_db($database_conexion, $conexion);
$query_JRUsuarios = "SELECT apellidos, nombreUsu, dependencia, codUsuario FROM usuarios where codUsuario between 9615037 and 1130669830";
mysql_query("SET NAMES 'utf8'");
$JRUsuarios = mysql_query($query_JRUsuarios, $conexion) or die(mysql_error());
$row_JRUsuarios = mysql_fetch_assoc($JRUsuarios);
$totalRows_JRUsuarios = mysql_num_rows($JRUsuarios);

do{
	
	$nombre=trim(mb_convert_case($row_JRUsuarios['nombreUsu'], MB_CASE_TITLE, "UTF-8"));
    $dependencia=trim(mb_convert_case($row_JRUsuarios['dependencia'], MB_CASE_TITLE, "UTF-8"));
    $apellidos=trim(mb_convert_case($row_JRUsuarios['apellidos'], MB_CASE_TITLE, "UTF-8"));
	$codigo=$row_JRUsuarios['codUsuario'];
	
	mysql_select_db($database_conexion, $conexion);
    $updateSQL = "UPDATE usuarios SET  apellidos= '$apellidos', nombreusu= '$nombre', dependencia='$dependencia' where codUsuario= $codigo";
    mysql_query("SET NAMES 'utf8'");
    $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	
	echo $FilasAfectadas=mysql_affected_rows();
	
	
	
	
}while($row_JRUsuarios = mysql_fetch_assoc($JRUsuarios));

?>
<?php
mysql_free_result($JRUsuarios);
?>
