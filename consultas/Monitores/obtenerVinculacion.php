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


$cedula=$_POST['cedula'];

if(isset($_POST['cedula'] )){
	
mysql_select_db($database_conexion, $conexion);
$query_JRConsultarvinculacion = "SELECT v.*, m.vcnombres FROM vinculacion_monitor v left join monitores m on(m.vccedula = v.cedula)  WHERE v.cedula='$cedula' order by v.No_vinculacion
";
mysql_query("SET NAMES 'utf8'");
$JRConsultarvinculacion = mysql_query($query_JRConsultarvinculacion, $conexion) or die(mysql_error());
$row_JRConsultarvinculacion = mysql_fetch_assoc($JRConsultarvinculacion);
$totalRows_JRConsultarvinculacion = mysql_num_rows($JRConsultarvinculacion);



if($totalRows_JRConsultarvinculacion > 0 )
{
	    echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>


    <table border="1" cellpadding="0" cellspacing="0"  class="tableUI" width="500" style="margin-top:15px;" >
     <tr class="ui-state-default">
      <th colspan="10">VINCULACION DE MONITORES</th>
     </tr>
     
      <tr>
       <td colspan="3">Monitor:<?php echo $row_JRConsultarvinculacion['vcnombres']; ?></td>
       <td colspan="3">Cedula:<?php echo $cedula; ?></td>
      </tr>
     
      <tr>
        <th>No Vinculacion</th>
        <th>Fecha de Inicio</th>
        <th>Fecha de Terminacion </th>
        <th>Total Horas del Periodo</th>
        <th>Valor Total de la Vinculacion</th>
        <th></th>
      </tr>	
      
     
      
    <?php  do
	{?>
	   
      <tr>
      <td><?php echo $row_JRConsultarvinculacion['No_vinculacion']; ?></td>
      <td><?php echo $row_JRConsultarvinculacion['comienzo']; ?></td>
      <td><?php echo $row_JRConsultarvinculacion['finalizacion']; ?></td>
      <td><?php echo $row_JRConsultarvinculacion['total_horas_semestre']; ?></td>
      <td><?php echo $row_JRConsultarvinculacion['valor_total_vinculacion']; ?></td>
      <td><input type="checkbox" class="checkboxvinculacion" value="<?php echo $row_JRConsultarvinculacion['No_vinculacion']; ?>" </td>
    </tr>
		
		
	<?php }while($row_JRConsultarvinculacion = mysql_fetch_assoc($JRConsultarvinculacion));?>
	
	</table>
   
   <?php  
	
  }
}

?>

<?php
mysql_free_result($JRConsultarvinculacion);
mysql_close($conexion);
?>
