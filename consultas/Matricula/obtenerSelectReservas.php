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

if(isset($_POST['codigo'], $_POST['grupo'],$_POST['clase']))
{

	$codigo=$_POST['codigo'];
	$grupo=$_POST['grupo'];
	$clase=$_POST['clase'];
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRConsultarreserva = "SELECT r.No_reserva,r.nombre_asignatura, h.codDia,h.horainicio,h.horafinal,h.fechainicio,h.fechafinal,h.codAsignatura,h.codGrupo,h.sala FROM reserva_eventual r inner join horario h on (r.No_reserva=h.No_reserva) WHERE r.cod_asignatura='$codigo' AND r.grupo= $grupo order by id
	";
	mysql_query("SET NAMES 'utf8'");
	$JRConsultarreserva = mysql_query($query_JRConsultarreserva, $conexion) or die(mysql_error());
	$row_JRConsultarreserva = mysql_fetch_assoc($JRConsultarreserva);
	$totalRows_JRConsultarreserva = mysql_num_rows($JRConsultarreserva);
	
  function MostrarDia($codDia)
  {

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



	if($totalRows_JRConsultarreserva > 0 )
	{
		echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>


    <table border="1" cellpadding="0" cellspacing="0"  class="tableUI" width="600" style="margin-top:15px;" >
     <tr class="ui-state-default">
     <th colspan="10">Reservas</th>
     </tr>
     
      <tr>
        <th>No Reserva</th>
        <th>Nombre</th>
        <th>Dia</th>
        <th>Hora Inicio</th>
        <th>Hora final</th>
        <th>Fecha inicio</th>
        <th>Fecha final</th>
        <th>Sala</th>
        <th></th>
      </tr>	
      
    <?php  do
	{?>
	   
      <tr>
    
      <td><?php echo $row_JRConsultarreserva['No_reserva']; ?></td>
      <td><?php echo $row_JRConsultarreserva['nombre_asignatura']; ?></td>
       <?php $codDia=$row_JRConsultarreserva['codDia']; ?>
      <td><?php echo $descripcionDia=MostrarDia($codDia); ?></td>
      <td><?php echo $row_JRConsultarreserva['horainicio']; ?></td>
      <td><?php echo $row_JRConsultarreserva['horafinal']; ?></td>
      <td><?php echo $row_JRConsultarreserva['fechainicio']; ?></td>
      <td><?php echo $row_JRConsultarreserva['fechafinal']; ?></td>
      <td><?php echo $row_JRConsultarreserva['sala']; ?></td>
      <td><input type="checkbox" class="<?php echo $clase ?>" value="<?php echo $row_JRConsultarreserva['No_reserva']; ?>" </td>
     
    </tr>
		
		
	<?php }while($row_JRConsultarreserva = mysql_fetch_assoc($JRConsultarreserva));?>
	
	</table>
		
	
		
   <?php  }// cierro $totalRows_JRConsultarreserva 
	
	else 
	{
	  echo '<p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#F00;">La asignatura no tiene reservas</p>'; 	
	}
 
	mysql_free_result($JRConsultarreserva);
	mysql_close($conexion);
	
 }// cierro isset
	?>
 
