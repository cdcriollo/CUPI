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


$codigo=$_POST['codigo'];
$grupo=$_POST['grupo'];

if(isset($_POST['codigo'] , $_POST['grupo'] )){
	
mysql_select_db($database_conexion, $conexion);
$query_JRConsultarreserva = "SELECT r.No_reserva, r.fecha_reserva, r.email, r.nombre_responsable, r.cod_asignatura, r.grupo, r.nombre_asignatura, r.cod_responsable, r.internet FROM reserva_eventual r inner join horario h on(h.No_reserva=r.No_reserva)  WHERE r.cod_asignatura='$codigo' AND r.grupo= $grupo AND h.estadohorario='activo' order by id
";
mysql_query("SET NAMES 'utf8'");
$JRConsultarreserva = mysql_query($query_JRConsultarreserva, $conexion) or die(mysql_error());
$row_JRConsultarreserva = mysql_fetch_assoc($JRConsultarreserva);
$totalRows_JRConsultarreserva = mysql_num_rows($JRConsultarreserva);



if($totalRows_JRConsultarreserva > 0 )
{
	    echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>


    <table border="1" cellpadding="0" cellspacing="0"  class="tableUI" width="500" style="margin-top:15px;" >
     <tr class="ui-state-default">
      <th colspan="10">Reservas Asignatura</th>
     </tr>
     
      <tr>
        <th>No Reserva</th>
        <th>Fecha reserva</th>
        <th>Codigo asignatura</th>
        <th>Grupo</th>
        <th>Nombre asignatura</th>
        <th>Codigo responsable</th>
        <th>Nombre responsable</th>
        <th>Internet</th>
        <th></th>
      </tr>	
      
    <?php  do
	{?>
	   
      <tr>
    
      <td><?php echo $row_JRConsultarreserva['No_reserva']; ?></td>
      <td><?php echo $row_JRConsultarreserva['fecha_reserva']; ?></td>
      <td><?php echo $row_JRConsultarreserva['cod_asignatura']; ?></td>
      <td><?php echo $row_JRConsultarreserva['grupo']; ?></td>
      <td><?php echo $row_JRConsultarreserva['nombre_asignatura']; ?></td>
      <td><?php echo $row_JRConsultarreserva['cod_responsable']; ?></td>
      <td><?php echo $row_JRConsultarreserva['nombre_responsable']; ?></td>
      <td><?php echo $row_JRConsultarreserva['internet']; ?></td>
      <td><input type="checkbox" class="checkboxreserva" value="<?php echo $row_JRConsultarreserva['No_reserva']; ?>" </td>
     
    </tr>
		
		
	<?php }while($row_JRConsultarreserva = mysql_fetch_assoc($JRConsultarreserva));?>
	
	</table>
   
   <?php  
	
  }
}

?>

<?php
mysql_free_result($JRConsultarreserva);
mysql_close($conexion);
?>
