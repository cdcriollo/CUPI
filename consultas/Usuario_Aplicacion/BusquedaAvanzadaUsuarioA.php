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
	$query_JRBusquedaAUsuario = "select u.nombreUsuario, u.contrasena, u.Nombre, u.estado, p.descripcion  from usuarios_aplicacion u inner join perfil_usuario p on (u.perfil=p.idPerfil) $filters order by $searchfield";
	mysql_query("SET NAMES 'utf8'");
	$JRBusquedaAUsuario = mysql_query($query_JRBusquedaAUsuario, $conexion) or die(mysql_error());
	$row_JRBusquedaAUsuario = mysql_fetch_assoc($JRBusquedaAUsuario);
	$totalRows_JRBusquedaAUsuario = mysql_num_rows($JRBusquedaAUsuario);

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

<?php if($totalRows_JRBusquedaAUsuario > 0) { ?>

<?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>

<table border="1" cellspacing="0"  class="tableUI" width="500" >
  <tr>
    <th>Nombre Usuario</th>
    <th>Contraseña</th>
    <th>Nombre Interfaz</th>
    <th>Perfil</th>
    <th>Estado</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_JRBusquedaAUsuario['nombreUsuario']; ?></td>
      <td><?php echo $row_JRBusquedaAUsuario['contrasena']; ?></td>
      <td><?php echo $row_JRBusquedaAUsuario['Nombre']; ?></td>
      <td><?php echo $row_JRBusquedaAUsuario['descripcion']; ?></td>
      <td><?php echo $row_JRBusquedaAUsuario['estado']; ?></td>
    </tr>
    <?php } while ($row_JRBusquedaAUsuario = mysql_fetch_assoc($JRBusquedaAUsuario)); ?>
</table>
<?php } else { echo'<script type="text/javascript">alertas("La consulta no arrojo resultados","Busqueda Avanzada Usuario","error");</script> ';}?>

<div id="alertas"></div>

</body>
</html>

<?php
mysql_free_result($JRBusquedaAUsuario);
mysql_close($conexion);
?>
