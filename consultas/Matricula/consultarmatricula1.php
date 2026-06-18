
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

if(isset($_POST['codigo'],$_POST['opcion']))
{

$codigo=$_POST['codigo'];
$opcion=$_POST['opcion'];

mysql_select_db($database_conexion, $conexion);
$query_JRCmatricula = "select m.codAsignatura,m.pc,a.nomAsignatura,p.numSala,m.grupo, m.Estado, m.idHorario, m.No_reserva from matricula m  inner join asignatura a on (m.codAsignatura=a.codAsignatura) inner join pcs p on(m.pc=p.Nopc)  where m.codUsuario= $codigo and m.Estado='Activa'";
mysql_query("SET NAMES 'utf8'");
$JRCmatricula = mysql_query($query_JRCmatricula, $conexion) or die(mysql_error());
$row_JRCmatricula = mysql_fetch_assoc($JRCmatricula);
$totalRows_JRCmatricula = mysql_num_rows($JRCmatricula);
$numregistros= $totalRows_JRCmatricula*6;


function ObtenerHorario($idhorario,$database_conexion, $conexion)
{
    mysql_select_db($database_conexion, $conexion);
	$query_JRHorario = "SELECT codDia, horainicio, horafinal FROM horario WHERE idHorario= $idhorario";
	$JRHorario = mysql_query($query_JRHorario, $conexion) or die(mysql_error());
	$row_JRHorario = mysql_fetch_assoc($JRHorario);
	$totalRows_JRHorario = mysql_num_rows($JRHorario);
	
	$dia= $row_JRHorario['codDia'];
	$descripcionDia=descripcionDia($dia);
	$horainicio=$row_JRHorario['horainicio'];
	$horafinal=$row_JRHorario['horafinal'];
	$horaformateada=formatearHora($horainicio,$horafinal);

	return $horarioclases= $descripcionDia." ".$horaformateada;
	mysql_free_result($JRHorario);
		
}

function descripcionDia($diasemana)
{
	if($diasemana==1)
  {
	 $descripcion="Lunes";  
  }
  else if($diasemana==2)
  {
	$descripcion="Martes";  
  }
  else if($diasemana==3)
  {
	$descripcion="Miercoles";  
  }
  else if($diasemana==4)
  {
	$descripcion="Jueves";  
  }
  else if($diasemana==5)
  {
	$descripcion="Viernes";  
  }
  else if($diasemana==6)
  {
	$descripcion="Sabado";  
  }
  
  return $descripcion;
}

function formatearHora($horainicial,$horafinal)
{
	 $horainicio[1]=explode(':',$horainicial);
     $horaend[2]=explode(':',$horafinal);
	 return $horainicio[1][0].":".$horainicio[1][1]."-".$horaend[2][0].":".$horaend[2][1];
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
<body>

<?php if($totalRows_JRCmatricula > 0){ ?>

<div id="tabladinamica" style="overflow:auto; min-width: 0px; max-width:630px; max-height:300px; min-height:0px; margin-bottom:15px;  margin-top:auto;">
        
  <?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>
       
  <table  border="1" class="tableUI" id="addmaterias" align="center" width="600" style="margin-left:10px; margin-top:15px;" cellpadding="0" cellspacing="0">
  <tr>
    <th>Codigo</th>
    <th>Grupo</th>
    <th>Asignatura</th>
    <th>Computador</th>
    <th>Sala</th>
    <th>Horario</th>
    <th>Reserva</th>
     <?php if ($opcion==2){ ?>
       <th></th>
     <?php }?>
  </tr>
  
  
  <?php do { ?>
  
      <tr>
        <td><?php echo $row_JRCmatricula['codAsignatura']; ?></td>
        <td><?php echo $row_JRCmatricula['grupo']; ?></td>
        <td><?php echo $row_JRCmatricula['nomAsignatura']; ?></td>
        <td><?php echo $row_JRCmatricula['pc']; ?></td>
        <td><?php echo $row_JRCmatricula['numSala']; ?></td>
        <?php $idhorario=$row_JRCmatricula['idHorario']; ?>
        <?php  $horario= ObtenerHorario($idhorario,$database_conexion, $conexion); ?>
        <td><?php echo $horario;?></td>
        <td><?php echo $row_JRCmatricula['No_reserva'];?></td>
        
        <?php if ($opcion==2){ ?>
        <td><input name="elegir" type="checkbox" value="<?php echo $row_JRCmatricula['codAsignatura'];?>.<?php echo $row_JRCmatricula['grupo'];?>.<?php echo $row_JRCmatricula['No_reserva'];?>" class="checkmatricula">
        <?php }?>
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
<?php
}
?>
