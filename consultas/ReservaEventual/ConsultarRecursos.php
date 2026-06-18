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

 function descripcionGrupoSubgrupo($idtipo,$subtipo,$conexion, $database_conexion,$opcion)
 {
	 
  if($opcion==1)
  { 	 
    mysql_select_db($database_conexion, $conexion);
    $query_JRDescripgrupo = "SELECT descripcionTipo FROM gruporecurso WHERE idTipo = $idtipo";
    $JRDescripgrupo = mysql_query($query_JRDescripgrupo, $conexion) or die(mysql_error());
    $row_JRDescripgrupo = mysql_fetch_assoc($JRDescripgrupo);
    $totalRows_JRDescripgrupo = mysql_num_rows($JRDescripgrupo);
	return  $row_JRDescripgrupo['descripcionTipo'];
	mysql_free_result($JRDescripgrupo);
	
	
  }
  else if($opcion==2)
  {

	mysql_select_db($database_conexion, $conexion);
	$query_JRDescripsubgrupo = "SELECT descripcionSubtipo FROM subgrupo WHERE idsubtipo = $subtipo and idTipo= $idtipo";
	$JRDescripsubgrupo = mysql_query($query_JRDescripsubgrupo, $conexion) or die(mysql_error());
	$row_JRDescripsubgrupo = mysql_fetch_assoc($JRDescripsubgrupo);
	$totalRows_JRDescripsubgrupo = mysql_num_rows($JRDescripsubgrupo);
	return $row_JRDescripsubgrupo['descripcionSubtipo'];
	mysql_free_result($JRDescripsubgrupo);
  }
	
	
 }

$reserva=$_POST['reserva'];
$opcion=$_POST['opcion'];
$stylered='style="font-size:14px; color:#FF0000;  font-weight:bold;"';

mysql_select_db($database_conexion, $conexion);
$query_JRConsultarrecurso = "SELECT grupo, subgrupo,cantidad,id,Software FROM recursos_reservados  WHERE No_reserva = '$reserva'";
$JRConsultarrecurso = mysql_query($query_JRConsultarrecurso, $conexion) or die(mysql_error());
$row_JRConsultarrecurso = mysql_fetch_assoc($JRConsultarrecurso);
$totalRows_JRConsultarrecurso = mysql_num_rows($JRConsultarrecurso);



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cupi-Control de Utilizacion Piso Informatico</title>
</head>




<body>

<?php


if ($opcion==1) 
{

  if($totalRows_JRConsultarrecurso > 0 )
  {

	
    echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>


<table border="1" cellpadding="0" cellspacing="0"  class="tableUI" width="540" style="margin-top:15px;" >
 <tr class="ui-state-default">
  <th colspan="4">RECURSOS RESERVADOS</th>
 </tr>
 
  <tr>
    <th>Grupo</th>
    <th>Subgrupo</th>
    <th>Cantidad</th>
    <th>Software</th>
  </tr>
  
  
  
  <?php do { ?>
  
  
    <tr>
      
      <?php $idtipo=$row_JRConsultarrecurso['grupo']; ?>
      <?php $subtipo=$row_JRConsultarrecurso['subgrupo']; ?>
      <?php $descripcionTipo= descripcionGrupoSubgrupo($idtipo,$subtipo,$conexion,$database_conexion,1) ?>
      <td><?php echo $descripcionTipo ?></td>
       <?php $descripcionsubgrupo= descripcionGrupoSubgrupo($idtipo,$subtipo,$conexion,$database_conexion,2) ?>
      <td><?php echo $descripcionsubgrupo; ?></td>
      <td><?php echo $row_JRConsultarrecurso['cantidad']; ?></td>
      <td><?php echo $row_JRConsultarrecurso['Software']; ?></td>
      
    </tr>
    <?php } while ($row_JRConsultarrecurso = mysql_fetch_assoc($JRConsultarrecurso)); ?>
    
    
</table>
<?php }
}// cierro opcion


else if($opcion==2)
{
	
	if($totalRows_JRConsultarrecurso > 0 )
   {
	  echo '<script type="text/javascript">$(".tableUI").styleTable();</script> ';?>


<table border="1" cellpadding="0" cellspacing="0"  class="tableUI" width="540" id="searchrecurso" style="margin:10px 10px 10px 10px">
 <tr class="ui-state-default">
  <th colspan="5">RECURSOS RESERVADOS</th>
 </tr>
 
  <tr>
    <th>Grupo</th>
    <th>Subgrupo</th>
    <th>Cantidad</th>
    <th>Software</th>
    <th></th>
  </tr>
  
  
  
  <?php do { ?>
  
  
    <tr>
      
      <?php $idtipo=$row_JRConsultarrecurso['grupo']; ?>
      <?php $subtipo=$row_JRConsultarrecurso['subgrupo']; ?>
      <?php $descripcionTipo= descripcionGrupoSubgrupo($idtipo,$subtipo,$conexion,$database_conexion,1) ?>
      <td><?php echo $descripcionTipo ?></td>
       <?php $descripcionsubgrupo= descripcionGrupoSubgrupo($idtipo,$subtipo,$conexion,$database_conexion,2) ?>
      <td><?php echo $descripcionsubgrupo; ?></td>
      <td><?php echo $row_JRConsultarrecurso['cantidad']; ?></td>
      <td><?php echo $row_JRConsultarrecurso['Software']; ?></td>
      <td><input type="checkbox" class="keyrecurso" value="<?php echo $row_JRConsultarrecurso['id']?>" /></td>
      
    </tr>
    <?php } while ($row_JRConsultarrecurso = mysql_fetch_assoc($JRConsultarrecurso)); ?>
</table>
<?php }

  else
  {
	  echo '<p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#F00;">La reserva no tiene recursos</p>';    
  }
}// cierro opcion

?>
</body>	
	
<?php
mysql_free_result($JRConsultarrecurso);

mysql_close($conexion);

?>
</html>
