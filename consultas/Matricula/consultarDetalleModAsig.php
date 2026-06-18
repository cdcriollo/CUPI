
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

$stylerow='style="color:#F00;"';
		
$codigo=$_POST['codigo'];
$grupo=$_POST['grupo'];

mysql_select_db($database_conexion, $conexion);
$query_JRCmatriculaA = "select u.nombreUsu, u.apellidos, m.codUsuario,m.pc,p.numSala, m.Estado, m.No_reserva from matricula m  inner join usuarios u on (m.codUsuario=u.codUsuario) inner join pcs p on (m.pc=p.Nopc) where m.codAsignatura= '$codigo' and m.grupo=$grupo  and m.Estado='Activa' order by No_reserva,pc";
mysql_query("SET NAMES 'utf8'");
$JRCmatriculaA = mysql_query($query_JRCmatriculaA, $conexion) or die(mysql_error());
$row_JRCmatriculaA = mysql_fetch_assoc($JRCmatriculaA);
$totalRows_JRCmatriculaA = mysql_num_rows($JRCmatriculaA);
 
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


<?php if($totalRows_JRCmatriculaA > 0){ ?>



<?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>

<div style="overflow:auto; width:640px; max-height:300px; min-height:0px; margin-top:20px; margin-top:auto;">

<table class="tableUI" width="600" style="margin-left:20px;" border="1" id="MatriAsig">
  <tr>
    <th>No</th>
    <th>Codigo</th>
    <th>Nombre</th>
    <th>Computador</th>
    <th>Sala</th>
    <th>Reserva</th>
    <th></th>  
  </tr>
  
  <?php $i=1; ?>
  <?php do { ?>
  
	 <tr>
      <td><?php echo $i;?></td>
      <td><?php echo $row_JRCmatriculaA['codUsuario']; ?></td>
      <?php $usuario= $row_JRCmatriculaA['nombreUsu']." ".$row_JRCmatriculaA['apellidos'] ?>
      <td><?php echo $usuario; ?></td>
      <td><?php echo $row_JRCmatriculaA['pc']; ?></td>
      <td><?php echo $row_JRCmatriculaA['numSala']; ?></td>
      <td><?php echo $row_JRCmatriculaA['No_reserva']; ?></td>
      <td><input type="checkbox" value="<?php echo $row_JRCmatriculaA['codUsuario'];?>.<?php echo $row_JRCmatriculaA['pc']; ?>.<?php echo $row_JRCmatriculaA['No_reserva']; ?>" class="checkModMatriculaAsig"></td>
      <?php $i++; ?>
    </tr>	
	
    <?php } while ($row_JRCmatriculaA = mysql_fetch_assoc($JRCmatriculaA)); ?>
</table>	
</div>
<?php }

else 
{
   echo'<script type="text/javascript">alertas("La asignatura no tiene estudiantes matriculados","Consultar Matricula Asignatura","error");</script> ';
} 

?>
       
       
     <?php
        mysql_free_result($JRCmatriculaA);
		mysql_close($conexion);
     ?>  

</body>
</html>