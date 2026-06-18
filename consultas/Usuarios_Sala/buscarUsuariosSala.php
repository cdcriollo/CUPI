<?php require_once('../../Connections/conexion.php'); ?>
<?php date_default_timezone_set("America/bogota"); ?>
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


function NombreAsignatura($codigo,$database_conexion,$conexion)
{
	mysql_select_db($database_conexion, $conexion);
	$query_JRAsignatura = "SELECT nomAsignatura FROM asignatura WHERE codAsignatura = '$codigo'";
	$JRAsignatura = mysql_query($query_JRAsignatura, $conexion) or die(mysql_error());
	$row_JRAsignatura = mysql_fetch_assoc($JRAsignatura);
	$totalRows_JRAsignatura = mysql_num_rows($JRAsignatura);
	return $nombre=$row_JRAsignatura['nomAsignatura'];
	mysql_free_result($JRAsignatura);

}

// se obtiene la fecha de ingreso
$fecha= date('Y'.'-'.'m'.'-'.'d');


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
	
	else if($searchoper=='bw')//begins with
	{
		$filters.="LIKE '$searchstring%'";
	}
	
	else if($searchoper=='ew')//ends with
	{
		$filters.="LIKE '%$searchstring'";
	}
	
	else if($searchoper=='cn')//contains
	{
		$filters.="LIKE '%$searchstring%'";
	}
	
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
    
    
    <?php 
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRBusquedaAUsuario = "SELECT codUsuario FROM usuarios $filters order by $searchfield";
	mysql_query("SET NAMES 'utf8'");
	$JRBusquedaAUsuario = mysql_query($query_JRBusquedaAUsuario, $conexion) or die(mysql_error());
	$row_JRBusquedaAUsuario = mysql_fetch_assoc($JRBusquedaAUsuario);
	$totalRows_JRBusquedaAUsuario = mysql_num_rows($JRBusquedaAUsuario);
	
	if($totalRows_JRBusquedaAUsuario > 0)
	{
	
		 do 
		 {  
		
	
	      $usuarios[0]=$row_JRBusquedaAUsuario['codUsuario'];
	
		  for ($i=1; $i<$totalRows_JRBusquedaAUsuario; $i++) 
		  {  
		    $user = mysql_fetch_array($JRBusquedaAUsuario);  
		    $usuarios[$i] = $user["codUsuario"];  
		  }  
		
	   } while ($row_JRBusquedaAUsuario = mysql_fetch_assoc($JRBusquedaAUsuario));
	   $rows = mysql_num_rows($JRBusquedaAUsuario);
		if($rows > 0) {
		  mysql_data_seek($JRBusquedaAUsuario, 0);
		  $row_JRBusquedaAUsuario = mysql_fetch_assoc($JRBusquedaAUsuario);
		 } 
	  
		$cadenausuarios=implode(',',$usuarios);
		mysql_free_result($JRBusquedaAUsuario);
		
		mysql_select_db($database_conexion, $conexion);
$query_JRCodingreso = "SELECT i.codUsuario,i.actividad,i.codAsignatura, u.nombreUsu,i.codGrupo,i.sala,i.computador,i.fecha,i.horaingreso,i.horasalida  FROM  ingreso_salida i inner join usuarios u on (u.codUsuario=i.codUsuario) WHERE i.codUsuario IN ($cadenausuarios) and fecha= '$fecha'";
$JRCodingreso = mysql_query($query_JRCodingreso, $conexion) or die(mysql_error());
$row_JRCodingreso = mysql_fetch_assoc($JRCodingreso);
$totalRows_JRCodingreso = mysql_num_rows($JRCodingreso);
		
		
	  if($totalRows_JRCodingreso > 0 )
     {
	  
   echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>
    
   <body>   
  <table  border="1" class="tableUI"  width="650" style="margin-left:5px; margin-top:15px; margin-bottom:15px;" cellpadding="0" cellspacing="0">
  <tr>
    <th>Nombre</th>
    <th>Asignatura</th>
    <th>Grupo</th>
    <th>Actividad</th>
    <th>Computador</th>
    <th>Sala</td>
    <th>Fecha</th>
    <th>Hora Ingreso</th>
    <th>Hora Salida</th>
    
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_JRCodingreso['nombreUsu']; ?></td>
      <?php $asignatura= $row_JRCodingreso['codAsignatura'];
      if ($asignatura != ""){$asignatura= NombreAsignatura($asignatura,$database_conexion,$conexion);} ?>
      <td><?php echo $asignatura; ?></td>
      <td><?php echo $row_JRCodingreso['codGrupo']; ?></td>
      <td><?php echo $row_JRCodingreso['actividad']; ?></td>
      <td><?php echo $row_JRCodingreso['computador']; ?></td>
      <td><?php echo $row_JRCodingreso['sala']; ?></td>
      <td><?php echo $row_JRCodingreso['fecha']; ?></td>
      <td><?php echo $row_JRCodingreso['horaingreso']; ?></td>
      <td><?php echo $row_JRCodingreso['horasalida']; ?></td>
    </tr>
    <?php } while ($row_JRCodingreso = mysql_fetch_assoc($JRCodingreso)); ?>
</table>
	
    	
	<?php
  }
  else
  {
	echo'<script type="text/javascript">alertas("El(Los) usuario(s) no ha(n) tenido ingresos en el dia de hoy","Busqueda Usuario Sala","error");</script> ';   
  }
 }
 else
 {
	echo'<script type="text/javascript">alertas("La consulta no arrojo resultados","Busqueda Usuario Sala","error");</script> ';   
 }
   

?>
		
</body>
</html>
<?php
mysql_free_result($JRCodingreso);
mysql_close($conexion);

?>
