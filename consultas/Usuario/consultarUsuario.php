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
$query_JRCusuarios = "SELECT * FROM usuarios WHERE codUsuario = $codigo";
mysql_query("SET NAMES 'utf8'");
$JRCusuarios = mysql_query($query_JRCusuarios, $conexion) or die(mysql_error());
$row_JRCusuarios = mysql_fetch_assoc($JRCusuarios);
$totalRows_JRCusuarios = mysql_num_rows($JRCusuarios);

if($totalRows_JRCusuarios > 0 ){
	
	$nombre=$row_JRCusuarios['nombreUsu'];
	$apellidos=$row_JRCusuarios['apellidos'];
	$estamento= $row_JRCusuarios['estamento'];
	$dependencia= $row_JRCusuarios['dependencia'];
	$estado=$row_JRCusuarios['estado'];
	$codigo=$row_JRCusuarios['codUsuario'];
	
	$response= array("error"=>0,"nombre"=>$nombre,"apellidos"=>$apellidos,"estamento"=>$estamento,"dependencia"=>$dependencia,"estado"=>$estado,"codigo"=>$codigo);
	echo json_encode($response);
}
else 
{
   $response = array("error"=>1);
   echo json_encode($response);
}
	
mysql_free_result($JRCusuarios);
mysql_close($conexion);


?>