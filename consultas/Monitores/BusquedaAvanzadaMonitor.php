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

   $filters='';

 //GET SEARCH FIELD ;D
	$searchfield=$_POST['searchField'];
	
	$filters='WHERE '.$searchfield.' ';
	 //GET SEARCH OPERATION ;D
	$searchoper=$_POST['searchOper'];
	//GET SEARCH VALUE ;D
	$searchstring=$_POST['searchString'];
	if($searchoper=='eq')//equals
	{
		$filters.="='".$searchstring."'";
	}
	else if($searchoper=='ne')//not equals
	{
		$filters.="<>'".$searchstring."'";
	}
	
	else if($searchoper=='bw')//begins with
	{
		$filters.="LIKE '$searchstring%'";
	}
	else if($searchoper=='bn')//does not begins with
	{
		$filters.="NOT LIKE '$searchstring%'";
	}
	
	else if($searchoper=='ew')//ends with
	{
		$filters.="LIKE '%$searchstring'";
	}
	else if($searchoper=='en')//does not ends with
	{
		$filters.="NOT LIKE '%$searchstring'";
	}
	else if($searchoper=='cn')//contains
	{
		$filters.="LIKE '%$searchstring%'";
	}
	else if($searchoper=='nc')//NOT contains
	{
		$filters.="NOT LIKE '%$searchstring%'";
	}

    mysql_select_db($database_conexion, $conexion);
	$query_JRBusquedaAMonitor = "SELECT * FROM monitores $filters order by $searchfield";
	mysql_query("SET NAMES 'utf8'");
	$JRBusquedaAMonitor = mysql_query($query_JRBusquedaAMonitor, $conexion) or die(mysql_error());
	$row_JRBusquedaAMonitor = mysql_fetch_assoc($JRBusquedaAMonitor);
	$totalRows_JRBusquedaAMonitor = mysql_num_rows($JRBusquedaAMonitor);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<script type="text/javascript">

     $("#alertas" ).dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			modal:true		
		});
		
		
		function alertas(content,title,type)
		{			
			$("#alertas").empty();			
			$("#alertas").dialog( "option", "title", title );
			if(type=="done")
			{
				$("#alertas").html('<img src="images/done.png" style="float:left; padding:5px;" />');
			}
			else if(type=="error")
			{
				$("#alertas").html('<img src="images/error.png" style="float:left; padding:5px;" />');
			}
			else if(type=="inform")
			{
				$("#alertas").html('<img src="images/inform.png" style="float:left; padding:5px;" />');
			}
			$("#alertas").append(content);
			$("#alertas").dialog("open");
		}

</script>

</head>

<body>

<?php if($totalRows_JRBusquedaAMonitor > 0) { ?>

<?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>

<table border="1" cellspacing="0"  class="tableUI" width="600" >
  <tr>
    <th>Cedula</th>
    <th>Codigo</th>
    <th>Nombres</th>
    <th>Apellidos</th>
    <th>Programa Academico</th>
    <th>Direccion Residencia</th>
    <th>Celular</th>
    <th>Telefono</th>
    <th>Correo Electronico</th>
    <th>Estado</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_JRBusquedaAMonitor['vccedula']; ?></td>
      <td><?php echo $row_JRBusquedaAMonitor['vccodigo']; ?></td>
      <td><?php echo $row_JRBusquedaAMonitor['vcnombres']; ?></td>
      <td><?php echo $row_JRBusquedaAMonitor['vcapellidos']; ?></td>
      <td><?php echo $row_JRBusquedaAMonitor['vcprogramaacademico']; ?></td>
      <td><?php echo $row_JRBusquedaAMonitor['vcdireccionresidencia']; ?></td>
      <td><?php echo $row_JRBusquedaAMonitor['vccelular']; ?></td>
      <td><?php echo $row_JRBusquedaAMonitor['vctelefonofijo']; ?></td>
      <td><?php echo $row_JRBusquedaAMonitor['vcemail']; ?></td>
      <td><?php echo $row_JRBusquedaAMonitor['vcestado']; ?></td>
    </tr>
    <?php } while ($row_JRBusquedaAMonitor = mysql_fetch_assoc($JRBusquedaAMonitor)); ?>
</table>
<?php } else { echo'<script type="text/javascript">alertas("La consulta no arrojo resultados","Busqueda Avanzada Usuario","error");</script> ';}?>

<div id="alertas"></div>

</body>
</html>

<?php
mysql_free_result($JRBusquedaAMonitor);
mysql_close($conexion);
?>
