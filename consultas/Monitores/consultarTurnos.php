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


$vinculacion=$_POST['idVinculacion'];
$opcion=$_POST['opcion'];


mysql_select_db($database_conexion, $conexion);
$query_JRTurnos = "SELECT * FROM turnos_monitor WHERE No_vinculacion = '$vinculacion' order by dia";
mysql_query("SET NAMES 'utf8'");
$JRTurnos = mysql_query($query_JRTurnos, $conexion) or die(mysql_error());
$row_JRTurnos = mysql_fetch_assoc($JRTurnos);
$totalRows_JRTurnos = mysql_num_rows($JRTurnos);


function calcular_tiempo_trasnc($hora1,$hora2)
 {
	
  
	 $separar[1]=explode(':',$hora1);
	 $separar[2]=explode(':',$hora2);
		
	$total_minutos_trasncurridos[1] = ($separar[1][0]*60) +$separar[1][1];
	$total_minutos_trasncurridos[2] = ($separar[2][0]*60) +$separar[2][1];
	$total_minutos_trasncurridos = $total_minutos_trasncurridos[2]-$total_minutos_trasncurridos[1];
	
	return $total_minutos_trasncurridos;   
		 
}

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

	 if ($totalRows_JRTurnos > 0 )
	 { 
       echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>


    <table border="1" cellpadding="0" cellspacing="0" id="scheduleres"  class="tableUI" width="540" style="margin:10px 10px 10px 0px" >
     
      <tr>
        <th>Dia</th>
        <th>Hora de Entrada</th>
        <th>Hora de Salida</th>
        <th>Total Horas del Turno</th>
        <th>Actividad</th>
        <?php if ($opcion==2) {?>
		 <th></th> 	
			
	  <?php } ?>
      </tr>
  
  
  
  <?php do { ?>
  
  
    <tr>
      <?php $codDia=$row_JRTurnos['dia']; ?>
      <td><?php echo $descripcionDia=MostrarDia($codDia); ?></td>
      <td><?php echo $row_JRTurnos['hora_entrada']; ?></td>
      <td><?php echo $row_JRTurnos['hora_salida']; ?></td>
      
      <?php $hora1=$row_JRTurnos['hora_entrada'];
			$hora2=$row_JRTurnos['hora_salida'];
			$total=calcular_tiempo_trasnc($hora1,$hora2);
			$totalhoras=(int)($total/60);
			$totalminutos=$total%60;
			$totalhorasminutos= $totalhoras.":".$totalminutos;
                    
              if($totalminutos<=9 && $totalhoras<=9){
				  $totalhorasminutos= "0".$totalhoras.":"."0".$totalminutos;
			  }
		      else if($totalminutos<=9 && $totalhoras >9){
			      $totalhorasminutos= $totalhoras.":"."0".$totalminutos;
			  }
			  else if($totalminutos==0 && $totalhoras <=9){
			      $totalhorasminutos= "0". $totalhoras.":"."0".$totalminutos;  
			  }
			 else if($totalminutos>0 && $totalhoras >9){
			     $totalhorasminutos= $totalhoras.":".$totalminutos;
			 }
			else if($totalminutos>0 && $totalhoras<=9){
			    $totalhorasminutos= "0".$totalhoras.":".$totalminutos;
			} 	
	   ?>
      <td><?php echo $totalhorasminutos; ?></td>
      <td><?php echo $row_JRTurnos['actividad']; ?></td>
      <?php if ($opcion==2) {?>
		 <td><input type="checkbox" class="turn" value="<?php echo $row_JRTurnos['idturno']; ?>"/></td>
	  <?php } ?>
   
    </tr>
    <?php } while ($row_JRTurnos = mysql_fetch_assoc($JRTurnos)); ?>
</table>
<?php }
else
{
	echo '<p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#F00;">El monitor no tiene asignado turnos</p>'; 
}

mysql_free_result($JRTurnos);
mysql_close($conexion);
?>
