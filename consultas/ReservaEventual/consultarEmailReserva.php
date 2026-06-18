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


$reserva=$_POST['reserva'];

mysql_select_db($database_conexion, $conexion);
$query_JREmail = "SELECT email FROM reserva_eventual WHERE No_reserva = '$reserva'";
mysql_query("SET NAMES 'utf8'");
$JREmail = mysql_query($query_JREmail, $conexion) or die(mysql_error());
$row_JREmail = mysql_fetch_assoc($JREmail);
$totalRows_JREmail = mysql_num_rows($JREmail);

if($totalRows_JREmail > 0 ){
	
	$email=$row_JREmail['email'];
		
	$response= array("error"=>0,"email"=>$email);
	echo json_encode($response);
}
else 
{
   $response = array("error"=>1);
   echo json_encode($response);
}



?>

<?php
mysql_free_result($JREmail);
?>
