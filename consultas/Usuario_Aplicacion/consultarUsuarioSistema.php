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

	
$username=$_POST['username'];
$usernamesinespacios=trim($username);

mysql_select_db($database_conexion, $conexion);
$query_JRCusuarios = "select u.nombreUsuario, u.contrasena, u.Nombre, u.estado, p.descripcion  from usuarios_aplicacion u inner join perfil_usuario p on (u.perfil=p.idPerfil) WHERE nombreUsuario= '$usernamesinespacios'";
mysql_query("SET NAMES 'utf8'");
$JRCusuarios = mysql_query($query_JRCusuarios, $conexion) or die(mysql_error());
$row_JRCusuarios = mysql_fetch_assoc($JRCusuarios);
$totalRows_JRCusuarios = mysql_num_rows($JRCusuarios);

if($totalRows_JRCusuarios==1 ){
	
	$usuarios[0]= $row_JRCusuarios['nombreUsuario'];
	$usuarios[1]= $row_JRCusuarios['contrasena'];
	$usuarios[2]= $row_JRCusuarios['Nombre'];
	$usuarios[3]= $row_JRCusuarios['descripcion'];
	$usuarios[4]= $row_JRCusuarios['estado'];
	$cadenausuarios=implode('-',$usuarios);
	echo $cadenausuarios;
}
else{
	echo 0;
}
	
mysql_free_result($JRCusuarios);
mysql_close($conexion);


?>