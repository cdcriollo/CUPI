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


$codigo=$_POST['codigo'];
$grupo=$_POST['grupo'];
	
	mysql_select_db($database_conexion, $conexion);
    $query_JRAsignaturas = "SELECT codAsignatura,codGrupo FROM  grupo_x_asignatura WHERE codAsignatura = '$codigo' AND codGrupo=$grupo";
    mysql_query("SET NAMES 'utf8'");
	$JRAsignaturas = mysql_query($query_JRAsignaturas, $conexion) or die(mysql_error());
	$row_JRAsignaturas = mysql_fetch_assoc($JRAsignaturas);
	$totalRows_JRAsignaturas = mysql_num_rows($JRAsignaturas);

	if($totalRows_JRAsignaturas > 0)
	{	
	
	    mysql_select_db($database_conexion, $conexion);
		$query_JRNombreAsig = "SELECT nomAsignatura FROM asignatura WHERE codAsignatura = '$codigo'";
		$JRNombreAsig = mysql_query($query_JRNombreAsig, $conexion) or die(mysql_error());
		$row_JRNombreAsig = mysql_fetch_assoc($JRNombreAsig);
		$totalRows_JRNombreAsig = mysql_num_rows($JRNombreAsig);
	    echo $nombre= $row_JRNombreAsig['nomAsignatura'];
		mysql_free_result($JRNombreAsig);
	}
	else
	{ 
	  echo 0;  
    }
        
?>
<?php
  mysql_free_result($JRAsignaturas);
  mysql_close($conexion);
?>
