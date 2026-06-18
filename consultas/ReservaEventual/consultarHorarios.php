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


$reserva=$_POST['reserva'];
$opcion=$_POST['opcion'];


mysql_select_db($database_conexion, $conexion);
$query_JRHorarios = "SELECT  codDia, horainicio, horafinal, fechaInicio,fechaFinal,sala,estadohorario,idHorario FROM horario WHERE No_reserva = '$reserva'  and estadohorario='activo'";
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


<?php if ($opcion==1) {?>
<?php if ($totalRows_JRHorarios > 0 ){ ?> 
<?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>


<table border="1" cellpadding="0" cellspacing="0"  class="tableUI" width="540" style="margin-top:15px;" >
 <tr class="ui-state-default">
 <th colspan="8">HORARIOS RESERVA EVENTUAL</th>
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
}

else if($opcion==2)
{
	 if ($totalRows_JRHorarios > 0 )
	 { 
       echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>


    <table border="1" cellpadding="0" cellspacing="0" id="scheduleres"  class="tableUI" width="540" style="margin:10px 10px 10px 10px" >
     
      <tr>
       
        <th>Dia</th>
        <th>Hora Inicio</th>
        <th>Hora Salida</th>
        <th>Fecha Inicio</th>
        <th>Fecha Terminacion</th>
        <th>Sala No</th>
        <th>Estado</th>
        <th></th>
      </tr>
  
  
  
  <?php do { ?>
  
  
    <tr>
      <?php $codDia=$row_JRHorarios['codDia']; ?>
      <td><?php echo $descripcionDia=MostrarDia($codDia); ?></td>
      <td><?php echo $row_JRHorarios['horainicio']; ?></td>
      <td><?php echo $row_JRHorarios['horafinal']; ?></td>
      <td><?php echo implode('-',array_reverse(explode('-', $row_JRHorarios['fechaInicio']))); ?></td>
      <td><?php echo  implode('-',array_reverse(explode('-', $row_JRHorarios['fechaFinal']))); ?></td>
      <td><?php echo $row_JRHorarios['sala']; ?></td>
      <td><?php echo $row_JRHorarios['estadohorario']; ?></td>
      <td><input type="checkbox" class="keyhorario" value="<?php echo $row_JRHorarios['idHorario']; ?>" </td>
     
    </tr>
    <?php } while ($row_JRHorarios = mysql_fetch_assoc($JRHorarios)); ?>
</table>
<?php }
else
{
	echo '<p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#F00;">La reserva no tiene programaciones</p>'; 
}


}?>

<?php
mysql_free_result($JRHorarios);
mysql_close($conexion);
?>
