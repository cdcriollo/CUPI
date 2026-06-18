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

mysql_select_db($database_conexion, $conexion);
$query_JRCMonitores = "SELECT * FROM monitores WHERE vccedula = $codigo";
mysql_query("SET NAMES 'utf8'");
$JRCMonitores = mysql_query($query_JRCMonitores, $conexion) or die(mysql_error());
$row_JRCMonitores = mysql_fetch_assoc($JRCMonitores);
$totalRows_JRCMonitores = mysql_num_rows($JRCMonitores);

if($totalRows_JRCMonitores > 0 ){
	
	$cedula=$row_JRCMonitores['vccedula'];
	$codigo=$row_JRCMonitores['vccodigo'];
	$nombres=$row_JRCMonitores['vcnombres'];
	$apellidos=$row_JRCMonitores['vcapellidos'];
	$estado=$row_JRCMonitores['vcestado'];
	
	
	$response= array("error"=>0,"nombres"=>$nombres,"apellidos"=>$apellidos,"cedula"=>$cedula,"codigo"=>$codigo,"estado"=>$estado);
	echo json_encode($response);
}
else 
{
   $response = array("error"=>1);
   echo json_encode($response);
}
	
mysql_free_result($JRCMonitores);
mysql_close($conexion);


?>