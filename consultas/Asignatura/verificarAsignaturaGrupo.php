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
$grupo= $_POST['grupo'];

mysql_select_db($database_conexion, $conexion);
$query_JRVerificarAsigGrupo = "SELECT codGrupo, codAsignatura FROM grupo_x_asignatura WHERE codAsignatura = '$asignatura' and codGrupo=$grupo";
mysql_query("SET NAMES 'utf8'");
$JRVerificarAsigGrupo = mysql_query($query_JRVerificarAsigGrupo, $conexion) or die(mysql_error());
$row_JRVerificarAsigGrupo = mysql_fetch_assoc($JRVerificarAsigGrupo);
$totalRows_JRVerificarAsigGrupo = mysql_num_rows($JRVerificarAsigGrupo);

if($totalRows_JRVerificarAsigGrupo > 0)
{
	
  echo 1;	
}

mysql_free_result($JRVerificarAsigGrupo);
mysql_close($conexion);
?>
