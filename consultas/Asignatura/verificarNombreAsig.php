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

$nombre= $_POST['nombre'];
// preg_replace quita todos los espacios en blanco de mas en la mitad de la cadena
$espaciosmitadcadena=preg_replace('/\s+/', ' ', $nombre); 
// trim quita los espacios en blanco al comienzo y al final de la cadena
$nuevacadena=trim($espaciosmitadcadena); 

mysql_select_db($database_conexion, $conexion);
$query_JRExistNombre = "SELECT * FROM asignatura WHERE nomAsignatura = '$nuevacadena'";
mysql_query("SET NAMES 'utf8'");
$JRExistNombre = mysql_query($query_JRExistNombre, $conexion) or die(mysql_error());
$row_JRExistNombre = mysql_fetch_assoc($JRExistNombre);
$totalRows_JRExistNombre = mysql_num_rows($JRExistNombre);

if($totalRows_JRExistNombre > 0 )
{
	echo 1;
}
else if($totalRows_JRExistNombre==0 ) 
{
   echo 2;  	
}

?>

<?php
mysql_free_result($JRExistNombre);
mysql_close($conexion);

?>
