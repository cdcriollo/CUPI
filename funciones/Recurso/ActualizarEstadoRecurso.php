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

$inventario=$_POST['inventario'];
$novedades=$_POST['novedades'];
$dependencia=$_POST['dependencia'];
$fechatramite=$_POST['fechatramite'];
$orden=$_POST['orden'];
$observaciones= $_POST['observaciones'];

	
  $updateSQL = "UPDATE recursos SET novedades='$novedades', fechatramite='$fechatramite', dependencia='$dependencia', orden_No='$orden', Observaciones='$observaciones',estadorecurso='Inactivo', estadoprestamo='No disponible' WHERE Noinventario= '$inventario'";
  mysql_select_db($database_conexion, $conexion);
   mysql_query("SET NAMES 'utf8'");
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  $numerofilasafectadas= mysql_affected_rows();
  
  if($numerofilasafectadas > 0)
  {
	echo 1;
  }
	else if($numerofilasafectadas==0)
	{
	 echo 0;
	}

?>


