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

$usuario=$_POST['usuario'];
$cadenaUsuario=trim($usuario);


mysql_select_db($database_conexion, $conexion);
$query_JREusuario = "SELECT nombreUsuario,contrasena FROM usuarios_aplicacion WHERE nombreUsuario = '$cadenaUsuario'";
mysql_query("SET NAMES 'utf8'");
$JREusuario = mysql_query($query_JREusuario, $conexion) or die(mysql_error());
$row_JREusuario = mysql_fetch_assoc($JREusuario);
$totalRows_JREusuario = mysql_num_rows($JREusuario);



   if($totalRows_JREusuario > 0)
   {
	 echo 1;
   }

mysql_free_result($JREusuario);
mysql_close($conexion);
?>
