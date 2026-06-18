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

if(isset($_POST['antiguopc'],$_POST['asignatura'],$_POST['grupo'],$_POST['reserva']))
{

	$antiguopc=$_POST['antiguopc'];
	$asignatura=$_POST['asignatura'];
	$grupo=$_POST['grupo'];
	$reserva= $_POST['reserva'];
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRCruceComp = "SELECT m.pc,m.codUsuario,u.nombreUsu FROM matricula m inner join usuarios u on (m.codUsuario=u.codUsuario) WHERE m.codAsignatura='$asignatura' and m.grupo= $grupo and m.No_reserva='$reserva' and m.Estado='Activa' order by pc
	";
	mysql_query("SET NAMES 'utf8'");
	$JRCruceComp = mysql_query($query_JRCruceComp, $conexion) or die(mysql_error());
	$row_JRCruceComp = mysql_fetch_assoc($JRCruceComp);
	$totalRows_JRCruceComp = mysql_num_rows($JRCruceComp);
	
	?>
	
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Documento sin título</title>
	</head>
	
	<body>
	
	<?php  if ($totalRows_JRCruceComp > 0) { ?>
	
	 <div style="overflow:auto; width:580px; max-height:250px; min-height:0px; margin-top:auto;">
	 <?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> ';?>
	 
	<table border="1" cellspacing="0" width="560" cellpadding="0" cellspacing="0" id="listapcs" class="tableUI" style="margin-left:15px; margin-top:15px; margin-bottom:15px;">
	  <tr>
		<th>Seleccione</th>
		<th>PC</th>
		<th>Codigo</th>
		<th>Nombre</th>
	  </tr>
	  <?php do { ?>
		<tr>
		  <td><input type="checkbox" class="escogerPc" value="<?php echo $row_JRCruceComp['pc']; ?>"/></td>
		  <td><?php echo $row_JRCruceComp['pc']; ?></td>
		  <td><?php echo $row_JRCruceComp['codUsuario']; ?></td>
		  <td><?php echo $row_JRCruceComp['nombreUsu']; ?></td>
		</tr>
		<?php } while ($row_JRCruceComp = mysql_fetch_assoc($JRCruceComp)); ?>
	</table>
	<?php }
	else 
	{
	  echo'<script type="text/javascript">alertas("La consulta no arrojo resultados","Modificar Matricula Usuario","error");</script> ';	
	}
	
	 ?>
	</body>
	</html>
	<?php
	mysql_free_result($JRCruceComp);
	mysql_close($conexion);
	
}
?>
