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


$codigo=$_POST['codigo'];
$fecha_entrada= date('Y'.'-'.'m'.'-'.'d');

mysql_select_db($database_conexion, $conexion);
$query_JRPlanilla = "SELECT * from ingreso_salida_monitor WHERE codigo = '$codigo' and fecha_entrada= '$fecha_entrada'";
mysql_query("SET NAMES 'utf8'");
$JRPlanilla = mysql_query($query_JRPlanilla, $conexion) or die(mysql_error());
$row_JRPlanilla = mysql_fetch_assoc($JRPlanilla);
$totalRows_JRPlanilla = mysql_num_rows($JRPlanilla);


/*function calcular_tiempo_trasnc($hora1,$hora2)
 {
	
  
	 $separar[1]=explode(':',$hora1);
	 $separar[2]=explode(':',$hora2);
		
	$total_minutos_trasncurridos[1] = ($separar[1][0]*60) +$separar[1][1];
	$total_minutos_trasncurridos[2] = ($separar[2][0]*60) +$separar[2][1];
	$total_minutos_trasncurridos = $total_minutos_trasncurridos[2]-$total_minutos_trasncurridos[1];
	
	return $total_minutos_trasncurridos;   
		 
}*/

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

<?php

	 if ($totalRows_JRPlanilla > 0 )
	 { 
       echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>


    <table border="1" cellpadding="0" cellspacing="0" id="scheduleres"  class="tableUI" width="540" style="margin:10px 10px 10px 0px" >
     
      <tr>
        <th>Dia</th>
        <th>Fecha de inicio</th>
        <th>Hora de inicio</th>
        <th>Fecha de terminacion</th>
        <th>Hora de terminacion</th>
        <th>Total horas turno</th> 
     </tr>
  
  
  
  <?php do { ?>
  
  
    <tr>
      <?php $codDia=$row_JRPlanilla['dia']; ?>
      <td><?php echo $descripcionDia=MostrarDia($codDia); ?></td>
      <td><?php echo $row_JRPlanilla['fecha_entrada']; ?></td>
      <td><?php echo $row_JRPlanilla['hora_entrada']; ?></td>
      <td><?php echo $row_JRPlanilla['fecha_salida']; ?></td>
      <td><?php echo $row_JRPlanilla['hora_salida']; ?></td>
      <td><?php echo $row_JRPlanilla['total_horas_turno']; ?></td>
    </tr>
    <?php } while ($row_JRPlanilla = mysql_fetch_assoc($JRPlanilla)); ?>
</table>
<?php }
else
{
	echo '<p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#F00;">El monitor no tiene asignado turnos</p>'; 
}

mysql_free_result($JRPlanilla);
mysql_close($conexion);
?>
