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

if(isset($_POST['codigo'], $_POST['grupo'],$_POST['opcion']))
{

$codigo=$_POST['codigo'];
$grupo= $_POST['grupo'];
$opcion=$_POST['opcion'];

mysql_select_db($database_conexion, $conexion);
$query_JRFranja = "SELECT idHorario,codDia,horainicio,horafinal,sala,No_reserva,fechaInicio,fechaFinal FROM horario WHERE codAsignatura='$codigo' AND codGrupo=$grupo and estadohorario='activo'";
mysql_query("SET NAMES 'utf8'");
$JRFranja = mysql_query($query_JRFranja, $conexion) or die(mysql_error());
$row_JRFranja = mysql_fetch_assoc($JRFranja);
$totalRows_JRFranja = mysql_num_rows($JRFranja);

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

 <?php $totalfranjas = mysql_num_rows($JRFranja); ?> 
        
<body>		
  
  <?php  if ($totalfranjas > 0)  
   {?>  
	 <?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>
     
	  <table border="1" width="600" cellpadding="0" cellpadding="0" class="tableUI" style="margin-top:10px; margin-bottom:10px; margin-left:10px;">
      <tr>
         <th></th>
        <th>No Reserva</th>
        <th>Dia</th>
        <th>Hora Inicio</th>
        <th>Hora Final</th>
        <th>Fecha Inicio</th>
        <th>Fecha Final</th>
        <th>Sala</th>
    </tr>
      
  <?php do { ?>
    
    
    
    <tr>
    
    <?php if ($opcion==2) {?>
     <td><input type="checkbox" class="franjahoraria" value="<?php echo $row_JRFranja['idHorario']?>"/></td>
     <?php } else if ($opcion==1){?>  <td><input type="checkbox" class="franjahorariauser" value="<?php echo $row_JRFranja['idHorario']?>"/></td> <?php } ?>
      <?php $codDia= $row_JRFranja['codDia']; ?>
      <td><?php echo $row_JRFranja['No_reserva']; ?></td>
     <td><?php echo $descripcionDia=MostrarDia($codDia); ?></td>
     <td><?php echo $row_JRFranja['horainicio']; ?></td>
     <td><?php echo $row_JRFranja['horafinal']; ?></td>
     <td><?php echo $row_JRFranja['fechaInicio']; ?></td>
     <td><?php echo $row_JRFranja['fechaFinal']; ?></td>
     <td><?php echo $row_JRFranja['sala']; ?></td>
    
    </tr>
    <?php } while ($row_JRFranja = mysql_fetch_assoc($JRFranja)); ?>
</table>
	  
     
       
 <?php }// Cierro if
 else if($totalfranjas==0)
 {
	echo'<script type="text/javascript">alertas("Por favor verifique que la asignatura y el grupo existan, que la asignatura tenga una programación","Matriculas Sala 7","error"); </script>'; 
 }
  	
		
?>

</body>
</html>

<?php
 mysql_free_result($JRFranja);
 mysql_close($conexion);
}
?>
