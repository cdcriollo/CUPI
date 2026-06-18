<?php require_once('../../Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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
$grupo= $_POST['grupo'];
$salas=array();

	mysql_select_db($database_conexion, $conexion);
   $query_JRAsignaturas = "SELECT  A.nomAsignatura, A.actividad  FROM  asignatura A  inner join horario H on (H.codAsignatura= A.codAsignatura) WHERE H.codAsignatura = '$codigo' AND H.codGrupo=$grupo";
   
    mysql_query("SET NAMES 'utf8'");
	$JRAsignaturas = mysql_query($query_JRAsignaturas, $conexion) or die(mysql_error());
	$row_JRAsignaturas = mysql_fetch_assoc($JRAsignaturas);
	$totalRows_JRAsignaturas = mysql_num_rows($JRAsignaturas);


		if ($totalRows_JRAsignaturas > 0)
		{
			
		  $asignaturas[0]= $row_JRAsignaturas['nomAsignatura'];
		  $asignaturas[1]= $row_JRAsignaturas['actividad'];
		  $cadenaasignaturas=implode(',',$asignaturas);  
		  echo $cadenaasignaturas;

         }
		 else
		 {
			echo 0; 
		 }


?>
<?php
  mysql_free_result($JRAsignaturas);
  mysql_close($conexion);
?>
