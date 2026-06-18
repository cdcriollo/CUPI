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

mysql_select_db($database_conexion, $conexion);
$query_JREmatriculau = "SELECT * FROM matricula WHERE  codUsuario=$usuario";
mysql_query("SET NAMES 'utf8'");
$JREmatriculau = mysql_query($query_JREmatriculau, $conexion) or die(mysql_error());
$row_JREmatriculau = mysql_fetch_assoc($JREmatriculau);
$totalRows_JREmatriculau = mysql_num_rows($JREmatriculau);

if($totalRows_JREmatriculau > 0)
{
  echo 1;
	
}

else
{
  echo 0;
}

 mysql_free_result($JREmatriculau);
 mysql_close($conexion);
?>
