
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
 

mysql_select_db($database_conexion, $conexion);
$query_JRCmatricula = "select m.codAsignatura,m.pc,a.nomAsignatura,p.numSala,m.grupo from matricula m  inner join asignatura a on (m.codAsignatura=a.codAsignatura) inner join pcs p on (m.pc=p.Nopc)  where m.codUsuario= $codigo and m.No_reserva is null and m.Estado='Activa'";
mysql_query("SET NAMES 'utf8'");
$JRCmatricula = mysql_query($query_JRCmatricula, $conexion) or die(mysql_error());
$row_JRCmatricula = mysql_fetch_assoc($JRCmatricula);
$totalRows_JRCmatricula = mysql_num_rows($JRCmatricula);


?>

<html>
<head>
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

<?php if($totalRows_JRCmatricula > 0){ ?>

<div id="tabladinamica" style="overflow:auto; width:620px; min-height:0px; max-height:300px; margin-bottom:15px; margin-top:auto;">
        
  <?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>
       
  <table  border="1" class="tableUI" class="MatriUser" width="600" style="margin-left:15px; margin-top:15px;" cellpadding="0" cellspacing="0">
  <tr>
    <th>Codigo</th>
    <th>Grupo</th>
    <th>Asignatura</th>
    <th>Computador</th>
    <th>Sala</td>
    <th></th>
    
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_JRCmatricula['codAsignatura']; ?></td>
      <td><?php echo $row_JRCmatricula['grupo']; ?></td>
      <td><?php echo $row_JRCmatricula['nomAsignatura']; ?></td>
      <td><?php echo $row_JRCmatricula['pc']; ?></td>
      <td><?php echo $row_JRCmatricula['numSala']; ?></td>
      
      <td ><input name="elegir" type="checkbox" value="<?php echo $row_JRCmatricula['codAsignatura'];?>.<?php echo $row_JRCmatricula['grupo']; ?>" class="checkmatricula"></td>
    </tr>
    <?php } while ($row_JRCmatricula = mysql_fetch_assoc($JRCmatricula)); ?>
</table>
   </div>      
     
    <?php }
	else {
	
		echo'<script type="text/javascript">alertas("El usuario no tiene matriculadas asignaturas en el piso","Consultar Matricula Usuario","error");</script> ';
	}
	?> 
    


    
    
     <?php
        mysql_free_result($JRCmatricula);
		mysql_close($conexion);
     ?>  

</body>
</html>