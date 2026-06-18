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

$inventario=$_POST['inventario'];


mysql_select_db($database_conexion, $conexion);
$query_JRConsultarR = "SELECT r.Nombrebien, g.descripcionTipo,sg.descripcionSubtipo, r.estadorecurso,r.cantidad, r.marca,r.serial,r.caracteristicas,r.instalado_sala,r.instalado_comp,r.novedades,r.fechatramite,r.dependencia,r.orden_No, r.idTipo, r.subGrupo, r.Observaciones,r.Llave,r.Tipo,r.Licencia,r.Factura, r.Idioma, r.Proveedor,r.Valor,r.Fecharecibo,r.Version FROM recursos r inner join gruporecurso g on(r.idTipo=g.idTipo) inner join subgrupo sg on(g.idTipo=sg.idTipo)  WHERE Noinventario = '$inventario'";
 mysql_query("SET NAMES 'utf8'");
$JRConsultarR = mysql_query($query_JRConsultarR, $conexion) or die(mysql_error());
$row_JRConsultarR = mysql_fetch_assoc($JRConsultarR);
$totalRows_JRConsultarR = mysql_num_rows($JRConsultarR);

$idtipo= $row_JRConsultarR['idTipo'];
$subgrupo=$row_JRConsultarR['subGrupo'];


if($totalRows_JRConsultarR !=0)
{
mysql_select_db($database_conexion, $conexion);
$query_JRCantidad = "select count(idTipo) as Total,subGrupo from recursos where idTipo=$idtipo and subGrupo=$subgrupo";
 mysql_query("SET NAMES 'utf8'");
$JRCantidad = mysql_query($query_JRCantidad, $conexion) or die(mysql_error());
$row_JRCantidad = mysql_fetch_assoc($JRCantidad);
$totalRows_JRCantidad = mysql_num_rows($JRCantidad);
$cantidad= $row_JRCantidad['Total'];
mysql_free_result($JRCantidad);

mysql_select_db($database_conexion, $conexion);
$query_JRDescripcion = "SELECT descripcionSubtipo FROM subgrupo WHERE idTipo = $idtipo and  idsubtipo=$subgrupo";
 mysql_query("SET NAMES 'utf8'");
$JRDescripcion = mysql_query($query_JRDescripcion, $conexion) or die(mysql_error());
$row_JRDescripcion = mysql_fetch_assoc($JRDescripcion);
$totalRows_JRDescripcion = mysql_num_rows($JRDescripcion);
$descripcionRecurso=$row_JRDescripcion['descripcionSubtipo']; 
mysql_free_result($JRDescripcion);
}




if($totalRows_JRConsultarR !=0)
{

   $recurso[0]=$row_JRConsultarR['Nombrebien'];
   $recurso[1]=$row_JRConsultarR['descripcionTipo'];
   $recurso[2]=$descripcionRecurso;
   $recurso[3]=$row_JRConsultarR['estadorecurso'];
   $recurso[4]=$row_JRConsultarR['cantidad'];
   $recurso[5]=$row_JRConsultarR['marca'];
   $recurso[6]=$row_JRConsultarR['serial'];
   $recurso[7]=$row_JRConsultarR['caracteristicas'];
   $recurso[8]=$row_JRConsultarR['instalado_sala'];
   $recurso[9]=$row_JRConsultarR['instalado_comp'];
   $recurso[10]=$cantidad;
   $recurso[11]=$row_JRConsultarR['Observaciones'];
   $recurso[12]=$row_JRConsultarR['novedades'];
   $recurso[13]=$row_JRConsultarR['fechatramite'];
   $recurso[14]=$row_JRConsultarR['dependencia'];
   $recurso[15]=$row_JRConsultarR ['orden_No'];   
   $recurso[16]=$row_JRConsultarR['Llave'];
   $recurso[17]=$row_JRConsultarR['Tipo'];
   $recurso[18]=$row_JRConsultarR['Licencia'];
   $recurso[19]=$row_JRConsultarR['Factura'];
   $recurso[20]=$row_JRConsultarR['Idioma'];
   $recurso[21]=$row_JRConsultarR['Proveedor'];
   $recurso[22]=$row_JRConsultarR['Valor'];
   $recurso[23]=$row_JRConsultarR['Fecharecibo'];
   $recurso[24]=$row_JRConsultarR ['Version'];
  
    $cadenarecursos= implode('*', $recurso);
    echo  $cadenarecursos;
	
}
else 
{
  echo 0;	
}
mysql_free_result($JRConsultarR);
mysql_close($conexion);

?>
