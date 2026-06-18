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

$codingreso=$_POST['idIngreso'];

mysql_select_db($database_conexion, $conexion);
$query_JRCPrestamos = "SELECT idPrestamo FROM prestamorecursos WHERE codIngreso = $codingreso";
mysql_query("SET NAMES 'utf8'");
$JRCPrestamos = mysql_query($query_JRCPrestamos, $conexion) or die(mysql_error());
$row_JRCPrestamos = mysql_fetch_assoc($JRCPrestamos);
$totalRows_JRCPrestamos = mysql_num_rows($JRCPrestamos);

$idprestamo=$row_JRCPrestamos['idPrestamo'];
mysql_free_result($JRCPrestamos);


mysql_select_db($database_conexion, $conexion);
$query_JRDetallePrestamo = "SELECT Noinventario, cantidad , descripcion FROM detalle_prestamo WHERE idPrestamo = $idprestamo";
mysql_query("SET NAMES 'utf8'");
$JRDetallePrestamo = mysql_query($query_JRDetallePrestamo, $conexion) or die(mysql_error());
$row_JRDetallePrestamo = mysql_fetch_assoc($JRDetallePrestamo);
$totalRows_JRDetallePrestamo = mysql_num_rows($JRDetallePrestamo);


mysql_select_db($database_conexion, $conexion);
$query_JREquiposexternos = "SELECT Idingreso FROM equipos_externos WHERE codIngreso = $codingreso";
mysql_query("SET NAMES 'utf8'");
$JREquiposexternos = mysql_query($query_JREquiposexternos, $conexion) or die(mysql_error());
$row_JREquiposexternos = mysql_fetch_assoc($JREquiposexternos);
$totalRows_JREquiposexternos = mysql_num_rows($JREquiposexternos);
$idingreso=$row_JREquiposexternos['Idingreso'];
mysql_free_result($JREquiposexternos);

mysql_select_db($database_conexion, $conexion);
$query_JRDetaleEquipos = "SELECT equipo, cantidad, detalles FROM detalle_equipos_externos WHERE Idingreso=$idingreso";
mysql_query("SET NAMES 'utf8'");
$JRDetaleEquipos = mysql_query($query_JRDetaleEquipos, $conexion) or die(mysql_error());
$row_JRDetaleEquipos = mysql_fetch_assoc($JRDetaleEquipos);
$totalRows_JRDetaleEquipos = mysql_num_rows($JRDetaleEquipos);


?>


<?php if ($totalRows_JRCPrestamos > 0 && $totalRows_JRDetallePrestamo > 0 && $totalRows_JREquiposexternos > 0 && $totalRows_JRDetaleEquipos > 0){ ?>

<?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>


<table border="1" cellpadding="1" class="tableUI" cellspacing="0" align="left" width="500" id="TableRecursoEquipo">

   <tr>
    <td colspan="3" style="color:#F00; font-weight:bold;  font-size:14px; text-align:center;">El usuario debe devolver</td>
   </tr>
  
  <thead>
    <th>Inventario</th>
    <th>Cantidad</th>
    <th>Descripcion</th>
  </thead>
      
    <?php do { ?>
       <tbody>
        <td class="detRecursos"><?php echo $row_JRDetallePrestamo['Noinventario']; ?></td>
        <td class="detRecursos"><?php echo $row_JRDetallePrestamo['cantidad']; ?></td>
        <td class="detRecursos"><?php echo $row_JRDetallePrestamo['descripcion']; ?></td>
      </tbody>
       <?php } while ($row_JRDetallePrestamo = mysql_fetch_assoc($JRDetallePrestamo)); ?> 
         
         <?php mysql_free_result($JRDetallePrestamo);  ?>
  
     <tr>
      <td colspan="4" style="color:#F00; font-weight:bold; font-size:14px; text-align:center;">Retira de su propiedad</td>
     </tr> 
    
  <thead>
    <th>Equipo</th>
    <th>Cantidad</th>
    <th>Detalles</th>
  </thead>
  
  <?php do { ?>
   
    <tbody>
      
      <td class="detEquipos"><?php echo $row_JRDetaleEquipos['equipo']; ?></td>
      <td class="detEquipos"><?php echo $row_JRDetaleEquipos['cantidad']; ?></td>
      <td class="detEquipos"><?php echo $row_JRDetaleEquipos['detalles']; ?></td>
      
    </tbody>
      <?php } while ($row_JRDetaleEquipos = mysql_fetch_assoc($JRDetaleEquipos)); ?>
      <?php mysql_free_result($JRDetaleEquipos);  ?>
      
</table>

<?php }?>

<?php

mysql_close($conexion);

?>
