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

if(isset($_POST['idTipo']))
{
	$idTipo=$_POST['idTipo'];
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRCGrupoRecurso = "select count(Noinventario) as totalrecursos from recursos where idTipo=$idTipo and estadorecurso <> 'Inactivo'";
	mysql_query("SET NAMES 'utf8'");
	$JRCGrupoRecurso = mysql_query($query_JRCGrupoRecurso, $conexion) or die(mysql_error());
	$row_JRCGrupoRecurso = mysql_fetch_assoc($JRCGrupoRecurso);
	$totalRows_JRCGrupoRecurso = mysql_num_rows($JRCGrupoRecurso);
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRCPrestadosRecursos = "select COUNT(Noinventario)as prestados from recursos where idTipo=$idTipo and estadoprestamo='Prestado'";
	mysql_query("SET NAMES 'utf8'");
	$JRCPrestadosRecursos = mysql_query($query_JRCPrestadosRecursos, $conexion) or die(mysql_error());
	$row_JRCPrestadosRecursos = mysql_fetch_assoc($JRCPrestadosRecursos);
	$totalRows_JRCPrestadosRecursos = mysql_num_rows($JRCPrestadosRecursos);
	
	$cantidadtotal= $row_JRCGrupoRecurso['totalrecursos'];
	$cantidadprestados= $row_JRCPrestadosRecursos['prestados'];
	$disponibles= $cantidadtotal-$cantidadprestados;
	
	$datosrecursos[0]= $cantidadtotal;
	$datosrecursos[1]= $cantidadprestados;
	$datosrecursos[2]= $disponibles;
	$datos=implode('-', $datosrecursos);
	echo $datos;
	
	?>
	
	
	<?php
	mysql_free_result($JRCGrupoRecurso);
	mysql_free_result($JRCPrestadosRecursos);
	mysql_close($conexion);
}
	?>
