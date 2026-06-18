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


$asignatura=$_POST['asignatura'];
$grupo=$_POST['grupo'];

mysql_select_db($database_conexion, $conexion);
$query_JRDatosAsignatura = "SELECT codAsignatura,codGrupo FROM grupo_x_asignatura  WHERE codAsignatura = '$asignatura' AND codGrupo=$grupo";
mysql_query("SET NAMES 'utf8'");
$JRDatosAsignatura = mysql_query($query_JRDatosAsignatura, $conexion) or die(mysql_error());
$row_JRDatosAsignatura = mysql_fetch_assoc($JRDatosAsignatura);
$totalRows_JRDatosAsignatura = mysql_num_rows($JRDatosAsignatura);

if($totalRows_JRDatosAsignatura > 0)
{
	mysql_select_db($database_conexion, $conexion);
    $query_JRAsignaturas = "SELECT  nomAsignatura FROM  asignatura  WHERE codAsignatura = '$asignatura'";
    mysql_query("SET NAMES 'utf8'");
	$JRAsignaturas = mysql_query($query_JRAsignaturas, $conexion) or die(mysql_error());
	$row_JRAsignaturas = mysql_fetch_assoc($JRAsignaturas);
	$totalRows_JRAsignaturas = mysql_num_rows($JRAsignaturas);
	
    $nomasignatura= $row_JRAsignaturas['nomAsignatura'];
    echo $nomasignatura;
	mysql_free_result($JRAsignaturas);

	
}

else if($totalRows_JRDatosAsignatura==0)
{
  echo 1;	
}

?>
<?php
mysql_free_result($JRDatosAsignatura);
mysql_close($conexion);

?>
