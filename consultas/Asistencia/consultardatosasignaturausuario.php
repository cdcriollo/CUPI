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
$usuario=$_POST['usuario'];
$grupo=$_POST['grupo'];

mysql_select_db($database_conexion, $conexion);
$query_JRDatosAsignatura = "SELECT A.nomAsignatura FROM asignatura A inner join grupo_x_asignatura G on (A.codAsignatura=G.codAsignatura)  WHERE G.codAsignatura = '$asignatura' AND G.codGrupo=$grupo";
mysql_query("SET NAMES 'utf8'");
$JRDatosAsignatura = mysql_query($query_JRDatosAsignatura, $conexion) or die(mysql_error());
$row_JRDatosAsignatura = mysql_fetch_assoc($JRDatosAsignatura);
$totalRows_JRDatosAsignatura = mysql_num_rows($JRDatosAsignatura);

mysql_select_db($database_conexion, $conexion);
$query_JRUsuario = "SELECT nombreUsu, apellidos FROM usuarios WHERE codUsuario = $usuario";
mysql_query("SET NAMES 'utf8'");
$JRUsuario = mysql_query($query_JRUsuario, $conexion) or die(mysql_error());
$row_JRUsuario = mysql_fetch_assoc($JRUsuario);
$totalRows_JRUsuario = mysql_num_rows($JRUsuario);




if($totalRows_JRDatosAsignatura > 0 && $totalRows_JRUsuario > 0)
{
   $datosasignaturausuario[0]= $row_JRDatosAsignatura['nomAsignatura'];
   $datosasignaturausuario[1]= $row_JRUsuario['nombreUsu']." ".$row_JRUsuario['apellidos'];
   $datos= implode(',',$datosasignaturausuario);
   echo $datos;
}

else if($totalRows_JRDatosAsignatura==0 && $totalRows_JRUsuario==0)
{
 echo 3; 	
}
else if($totalRows_JRUsuario==0)
{
 echo 2;	
}
else if($totalRows_JRDatosAsignatura==0)
{
  echo 1;	
}




?>
<?php
mysql_free_result($JRDatosAsignatura);
mysql_free_result($JRUsuario);
mysql_close($conexion);
?>
