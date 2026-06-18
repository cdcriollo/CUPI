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

	mysql_select_db($database_conexion, $conexion);
	$query_JRDependencia = "SELECT descripcion FROM dependencias order by descripcion asc";
	mysql_query("SET NAMES 'utf8'");
	$JRDependencia = mysql_query($query_JRDependencia, $conexion) or die(mysql_error());
	$row_JRDependencia = mysql_fetch_assoc($JRDependencia);
	$totalRows_JRDependencia = mysql_num_rows($JRDependencia);


	 $dependencias[0] =$row_JRDependencia["descripcion"];
	 
	 for ($i=1; $i< $totalRows_JRDependencia; $i++) 
	 {
	    $row = mysql_fetch_assoc($JRDependencia);
	    $dependencias[$i] = $row["descripcion"];
	 }

	$json->descripcion=$dependencias;
	echo json_encode($json);
	mysql_free_result($JRDependencia);
	mysql_close($conexion);

?>
