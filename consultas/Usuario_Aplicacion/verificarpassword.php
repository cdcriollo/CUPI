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

$contrasena=$_POST['password'];

if( isset($_POST['password']))
{

	mysql_select_db($database_conexion, $conexion);
	$query_JRVerificarpassword = "SELECT * FROM usuarios_aplicacion WHERE contrasena = '$contrasena'";
	$JRVerificarpassword = mysql_query($query_JRVerificarpassword, $conexion) or die(mysql_error());
	$row_JRVerificarpassword = mysql_fetch_assoc($JRVerificarpassword);
	$totalRows_JRVerificarpassword = mysql_num_rows($JRVerificarpassword);
	
	if($totalRows_JRVerificarpassword > 0)
	{
	   $response=array("error"=>0);
	   echo json_encode($response);
	}
	
	else if($totalRows_JRVerificarpassword ==0)
	{
		$response=array("error"=>1);
	    echo json_encode($response);
	}
	
	mysql_free_result($JRVerificarpassword);

}
?>
