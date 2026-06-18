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

$asignatura=$_POST['asignatura'];
$grupo=$_POST['grupo'];


mysql_select_db($database_conexion, $conexion);
$query_JRidhorario = "SELECT idHorario,codDia,horainicio,horafinal FROM horario WHERE codAsignatura='$asignatura' and codGrupo=$grupo and estadohorario='activo'";
mysql_query("SET NAMES 'utf8'");
$JRidhorario = mysql_query($query_JRidhorario, $conexion) or die(mysql_error());
$row_JRidhorario = mysql_fetch_assoc($JRidhorario);
$totalRows_JRidhorario = mysql_num_rows($JRidhorario);

?>


<?php if($totalRows_JRidhorario > 0) {?>

 <?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>

<table border="1" class="tableUI"  width="500" style="margin-left:15px; margin-bottom:10px; margin-top:10px;" cellpadding="0" cellspacing="0">
  <tr>
    <th>Codigo Horario</th>
    <th>Dia</th>
    <th>Hora Inicio</th>
    <th>Hora Final</th>
  </tr>
  
  
  <?php do { ?>
    <tr>
       <?php $dia=$row_JRidhorario['codDia']; 
	    $descripcionDia=MostrarDia($dia);
	   ?>
      <td><?php echo $row_JRidhorario['idHorario']; ?></td>
      <td><?php echo $descripcionDia; ?></td>
      <td><?php echo $row_JRidhorario['horainicio']; ?></td>
      <td><?php echo $row_JRidhorario['horafinal']; ?></td>
    </tr>
    <?php } while ($row_JRidhorario = mysql_fetch_assoc($JRidhorario)); ?>
</table>

<?php }?>
<?php
 mysql_free_result($JRidhorario);
 mysql_close($conexion);

?>
