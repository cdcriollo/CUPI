<?php require_once('../../Connections/conexion.php'); ?>
<?php date_default_timezone_set("America/bogota"); ?>

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

    $fecha= date('Y'.'-'.'m'.'-'.'d');
    $pc=$_POST['pc'];


	mysql_select_db($database_conexion, $conexion);
	$query_JRSalidas = "select i.actividad, i.sala, i.computador, i.estado, i.codIngreso, u.nombreUsu, i.codAsignatura, i.codGrupo, i.codUsuario from ingreso_salida i inner join usuarios u on (i.codUsuario=u.codUsuario)  where i.fecha='$fecha' and i.computador=$pc and i.estado <> 1 order by i.codIngreso desc limit 1";
	mysql_query("SET NAMES 'utf8'");
	$JRSalidas = mysql_query($query_JRSalidas, $conexion) or die(mysql_error());
	$row_JRSalidas = mysql_fetch_assoc($JRSalidas);
	$totalRows_JRSalidas = mysql_num_rows($JRSalidas);



   if ($totalRows_JRSalidas > 0){
	 
	 $codigoasignatura= $row_JRSalidas['codAsignatura'];  
	   
	mysql_select_db($database_conexion, $conexion);
	$query_JRNombreAsignatura = "SELECT nomAsignatura FROM asignatura WHERE codAsignatura = '$codigoasignatura'";
	mysql_query("SET NAMES 'utf8'");
	$JRNombreAsignatura = mysql_query($query_JRNombreAsignatura, $conexion) or die(mysql_error());
	$row_JRNombreAsignatura = mysql_fetch_assoc($JRNombreAsignatura);
	$totalRows_JRNombreAsignatura = mysql_num_rows($JRNombreAsignatura);   
	
	$arraysalidas[0]=$row_JRSalidas['actividad'];
	$arraysalidas[1]=$row_JRSalidas['sala'];
	$arraysalidas[2]=$row_JRSalidas['computador'];
	$arraysalidas[3]=$row_JRSalidas['nombreUsu'];
	$arraysalidas[4]=$row_JRSalidas['estado'];
	$arraysalidas[5]=$row_JRSalidas['codIngreso'];
	$arraysalidas[6]=$row_JRSalidas['codAsignatura'];
	$arraysalidas[7]=$row_JRSalidas['codGrupo'];
	$arraysalidas[8]=$row_JRSalidas['codUsuario'];
	$arraysalidas[9]=$row_JRNombreAsignatura['nomAsignatura'];
	
	
	$arrayfinal=implode('-',$arraysalidas);
	echo $arrayfinal;  
	mysql_free_result($JRNombreAsignatura); 
	mysql_free_result($JRSalidas);  
	   
   }
   else
   {
	 echo 0;   
   }

?>


