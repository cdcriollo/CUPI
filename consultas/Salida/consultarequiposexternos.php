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

$codingreso=$_POST['idIngreso'];

mysql_select_db($database_conexion, $conexion);
$query_JREquiposexternos = "SELECT Idingreso FROM equipos_externos WHERE codIngreso = $codingreso";
mysql_query("SET NAMES 'utf8'");
$JREquiposexternos = mysql_query($query_JREquiposexternos, $conexion) or die(mysql_error());
$row_JREquiposexternos = mysql_fetch_assoc($JREquiposexternos);
$totalRows_JREquiposexternos = mysql_num_rows($JREquiposexternos);
$idingreso=$row_JREquiposexternos['Idingreso'];

mysql_select_db($database_conexion, $conexion);
$query_JRDetaleEquipos = "SELECT equipo, cantidad, detalles FROM detalle_equipos_externos WHERE Idingreso=$idingreso";
mysql_query("SET NAMES 'utf8'");
$JRDetaleEquipos = mysql_query($query_JRDetaleEquipos, $conexion) or die(mysql_error());
$row_JRDetaleEquipos = mysql_fetch_assoc($JRDetaleEquipos);
$totalRows_JRDetaleEquipos = mysql_num_rows($JRDetaleEquipos);

?>

<?php if($totalRows_JREquiposexternos > 0 && $totalRows_JRDetaleEquipos > 0 ) 

{?>

<?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>

<table border="1" cellpadding="1" class="tableUI" cellspacing="0" align="left" width="500" id="TableEquipos">

<tr>
    <td colspan="4" style="color:#F00; font-weight:bold;">Retira de su propiedad</td>
    
    </tr>
    
  <thead>
    <th>equipo</th>
    <th>cantidad</th>
    <th>detalles</th>
  </thead>
  <?php do { ?>
    <tbody>
      <td class="detEquipos"><?php echo $row_JRDetaleEquipos['equipo']; ?></td>
      <td class="detEquipos"><?php echo $row_JRDetaleEquipos['cantidad']; ?></td>
      <td class="detEquipos"><?php echo $row_JRDetaleEquipos['detalles']; ?></td>
    </tbody>
    <?php } while ($row_JRDetaleEquipos = mysql_fetch_assoc($JRDetaleEquipos)); ?>
</table>

<?php }?>

<?php 

mysql_free_result($JREquiposexternos);

mysql_free_result($JRDetaleEquipos);

?>