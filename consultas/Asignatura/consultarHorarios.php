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


$asignatura=$_POST['asignatura'];
$grupo=$_POST['grupo'];

mysql_select_db($database_conexion, $conexion);
$query_JRHorarios = "SELECT codDia, horainicio, horafinal, fechaInicio,fechaFinal,sala,estadohorario FROM horario WHERE codAsignatura = '$asignatura' and CodGrupo=$grupo and estadohorario='activo'";
mysql_query("SET NAMES 'utf8'");
$JRHorarios = mysql_query($query_JRHorarios, $conexion) or die(mysql_error());
$row_JRHorarios = mysql_fetch_assoc($JRHorarios);
$totalRows_JRHorarios = mysql_num_rows($JRHorarios);

function MostrarDia($codDia){

switch ($codDia) {
    case 1:
	    $descripcion="Lunes";
        break;
    case 2:
	    $descripcion="Martes";
        break;
    case 3:
        $descripcion="Miercoles";
      break;
	  case 4:
        $descripcion="Jueves";
      break;
	  case 5:
        $descripcion="Viernes";
      break;
	  case 6:
        $descripcion="Sabado";
      break;
}

return $descripcion;
}
?>

<?php if ($totalRows_JRHorarios > 0 ){ ?> 
<?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>


<table border="1" cellpadding="0" cellspacing="0"  class="tableUI" width="540" style="margin-top:15px;" >
 <tr class="ui-state-default">
 <th colspan="7">HORARIO DE CLASES</th>
 </tr>
 
  <tr>
    <th>Dia</th>
    <th>Hora Inicio</th>
    <th>Hora Salida</th>
    <th>Fecha Inicio</th>
    <th>Fecha Terminacion</th>
    <th>Sala No</th>
    <th>Estado</th>
  </tr>
  
  
  
  <?php do { ?>
  
  
    <tr>
      <?php $codDia=$row_JRHorarios['codDia']; ?>
      <td><?php echo $descripcionDia=MostrarDia($codDia); ?></td>
      <td><?php echo $row_JRHorarios['horainicio']; ?></td>
      <td><?php echo $row_JRHorarios['horafinal']; ?></td>
      <td><?php echo $row_JRHorarios['fechaInicio']; ?></td>
      <td><?php echo $row_JRHorarios['fechaFinal']; ?></td>
      <td><?php echo $row_JRHorarios['sala']; ?></td>
      <td><?php echo $row_JRHorarios['estadohorario']; ?></td>
     
    </tr>
    <?php } while ($row_JRHorarios = mysql_fetch_assoc($JRHorarios)); ?>
</table>
</div>
<?php }
?>
<?php
mysql_free_result($JRHorarios);
mysql_close($conexion);
?>
