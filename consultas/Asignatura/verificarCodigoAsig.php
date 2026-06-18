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
// trim quita los espacios en blanco al comienzo y al final de la cadena
$nuevacadena=trim($asignatura); 

mysql_select_db($database_conexion, $conexion);
$query_JRExistAsignatura = "SELECT codAsignatura,nomAsignatura from asignatura WHERE codAsignatura = '$nuevacadena'";
mysql_query("SET NAMES 'utf8'");
$JRExistAsignatura = mysql_query($query_JRExistAsignatura, $conexion) or die(mysql_error());
$row_JRExistAsignatura = mysql_fetch_assoc($JRExistAsignatura);
$totalRows_JRExistAsignatura = mysql_num_rows($JRExistAsignatura);


if($totalRows_JRExistAsignatura > 0 )
{
	echo 1;
}
else if($totalRows_JRExistAsignatura == 0) 
{
   echo 2;  	
}


?>

<?php
mysql_free_result($JRExistAsignatura);
mysql_close($conexion);
?>
