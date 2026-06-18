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


$pc= $_POST['pc'];
mysql_select_db($database_conexion, $conexion);
$query_JRSala = "SELECT numSala FROM pcs WHERE Nopc=$pc and estadoocupacion='disponible'";
mysql_query("SET NAMES 'utf8'");
$JRSala = mysql_query($query_JRSala, $conexion) or die(mysql_error());
$row_JRSala = mysql_fetch_assoc($JRSala);
$totalRows_JRSala = mysql_num_rows($JRSala);


if($totalRows_JRSala > 0)
{
	echo $row_JRSala['numSala'];
}

else
{
  echo 0;	
}

mysql_free_result($JRSala);
mysql_close($conexion);
?>
