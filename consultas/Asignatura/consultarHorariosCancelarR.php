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

$opcion=$_POST['opcion']; ?>

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

<?php if($opcion==2)
{

   $fechainicial=implode('-',array_reverse(explode('-',$_POST['fechainicial'])));
   $fechafinal=implode('-',array_reverse(explode('-',$_POST['fechafinal'])));


	mysql_select_db($database_conexion, $conexion);
	$query_JRHorarios = "SELECT H.idHorario,H.codDia, H.horainicio, H.horafinal, H.fechaInicio, H.fechaFinal,H.sala, H.estadohorario, H.codGrupo, H.codAsignatura, H.No_reserva, A.nomAsignatura FROM horario H  inner join  asignatura A ON (H.codAsignatura=A.codAsignatura) WHERE fechaInicio>='$fechainicial' and fechaFinal<='$fechafinal' and H.estadohorario='activo'  order by   H.codGrupo";
	mysql_query("SET NAMES 'utf8'");
	$JRHorarios = mysql_query($query_JRHorarios, $conexion) or die(mysql_error());
	$row_JRHorarios = mysql_fetch_assoc($JRHorarios);
	$totalRows_JRHorarios = mysql_num_rows($JRHorarios);
  


?>

<?php if ($totalRows_JRHorarios > 0 ){ ?> 

<?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>

<div  style="overflow:auto; width:700px; height:350px; margin-top:auto; margin-bottom:20px;">



  <table cellpadding="0" cellspacing="0" width="700"  id="HorarioClasesA"  class="tableUI" border="1">

    <tr class="ui-state-default">
      <th colspan="12">PROGRAMACION DE ASIGNATURAS</th>
    </tr>
 
  <tr>
    <th>Codigo</th> 
    <th>Grupo</th> 
    <th>Nombre</th> 
    <th>Dia</th>
    <th>Hora Inicio</th>
    <th>Hora Salida</th>
    <th>Fecha Inicio</th>
    <th>Fecha Terminacion</th>
    <th>Sala No</th>
    <th>No Reserva</th>
    <th>Estado</th> 
    <th></th> 
  </tr>
  
 
  
 <?php do {?>
  
   
      <tr>
          <td><?php echo $row_JRHorarios['codAsignatura'];?></td>
          <td><?php echo $row_JRHorarios['codGrupo'];?></td>
          <td><?php echo $row_JRHorarios['nomAsignatura'];?></td>
          <?php $codDia=$row_JRHorarios['codDia']; ?>
          <td><?php echo $descripcionDia=MostrarDia($codDia); ?></td>
          <td><?php echo $row_JRHorarios['horainicio']; ?></td>
          <td><?php echo $row_JRHorarios['horafinal']; ?></td>
          <?php $nuevafechaInicio=implode('-',array_reverse(explode('-',$row_JRHorarios['fechaInicio'])));?>
          <?php $nuevafechaFinal=implode('-',array_reverse(explode('-',$row_JRHorarios['fechaFinal'])));?>
          <td><?php echo $nuevafechaInicio ?></td>
          <td><?php echo $nuevafechaFinal ?></td>
          <td><?php echo $row_JRHorarios['sala']; ?></td>
          <td><?php echo $row_JRHorarios['No_reserva']; ?></td>
          <td><?php echo $row_JRHorarios['estadohorario']; ?></td>
           <?php $valor= explode('-', $row_JRHorarios['No_reserva']); $id= $valor[1];?>
          <td><input type="checkbox" class="reserva" value="<?php echo $row_JRHorarios['idHorario'].'-'.$id; ?>"/></td>
         
         
     </tr>
   
   
   <?php } while($row_JRHorarios = mysql_fetch_assoc($JRHorarios));?>
  <?php  mysql_free_result($JRHorarios); ?>
    </table>
 </div>
  <?php }
  
  else
  {
	  echo'<script type="text/javascript">alertas("La consulta no arrojo resultados por favor verifique que los rangos de fecha esten bien definidos ","Cancelar Reserva Asignaturas","error");</script> ';  
  }
  
  }
  else if ($opcion==1)
  {
      $codigo=$_POST['codigo'];
      $grupo=$_POST['grupo'];


	mysql_select_db($database_conexion, $conexion);
	$query_JRHorarios1 = "SELECT H.idHorario,H.codDia, H.horainicio, H.horafinal, H.fechaInicio, H.fechaFinal,H.sala, H.estadohorario, H.codGrupo, H.codAsignatura, H.No_reserva, A.nomAsignatura FROM horario H  inner join  asignatura A ON (H.codAsignatura=A.codAsignatura)  WHERE H.codAsignatura='$codigo' and H.codGrupo=$grupo and H.estadohorario='activo' order by H.codGrupo";
	mysql_query("SET NAMES 'utf8'");
	$JRHorarios1 = mysql_query($query_JRHorarios1, $conexion) or die(mysql_error());
	$row_JRHorarios1 = mysql_fetch_assoc($JRHorarios1);
	$totalRows_JRHorarios1 = mysql_num_rows($JRHorarios1);
	
	if ($totalRows_JRHorarios1 > 0 )
	{ 

    echo '<script type="text/javascript">$(".tableUI").styleTable();</script> ';?>

  <div  style="overflow:auto; width:700px; height:350px; margin-top:auto; margin-bottom:20px;">

<table cellpadding="0" cellspacing="0" width="700" id="HorarioClasesA" class="tableUI" border="1">

<tr class="ui-state-default">
 <th colspan="12">PROGRAMACION DE ASIGNATURAS</th>
 </tr>
 
  <tr>
    <th>Codigo</th> 
    <th>Grupo</th> 
    <th>Nombre</th> 
    <th>Dia</th>
    <th>Hora Inicio</th>
    <th>Hora Salida</th>
    <th>Fecha Inicio</th>
    <th>Fecha Terminacion</th>
    <th>Sala No</th>
    <th>No Reserva</th>
    <th>Estado</th> 
    <th></th> 
  </tr>
  
 <?php do {?>
 
      <tr>
      <td><?php echo $row_JRHorarios1['codAsignatura'];?></td>
      <td><?php echo $row_JRHorarios1['codGrupo'];?></td>
      <td><?php echo $row_JRHorarios1['nomAsignatura'];?></td>
      <?php $codDia=$row_JRHorarios1['codDia']; ?>
      <td><?php echo $descripcionDia=MostrarDia($codDia); ?></td>
      <td><?php echo $row_JRHorarios1['horainicio']; ?></td>
      <td><?php echo $row_JRHorarios1['horafinal']; ?></td>
      <?php $nuevafechaInicio=implode('-',array_reverse(explode('-',$row_JRHorarios1['fechaInicio'])));?>
      <?php $nuevafechaFinal=implode('-',array_reverse(explode('-',$row_JRHorarios1['fechaFinal'])));?>
      <td><?php echo $nuevafechaInicio ?></td>
      <td><?php echo $nuevafechaFinal ?></td>
      <td><?php echo $row_JRHorarios1['sala']; ?></td>
      <td><?php echo $row_JRHorarios1['No_reserva']; ?></td>
      <td><?php echo $row_JRHorarios1['estadohorario']; ?></td>
      <?php $valor= explode('-', $row_JRHorarios1['No_reserva']); $id= $valor[1];?>
      <td><input type="checkbox" class="reserva" value="<?php echo $row_JRHorarios1['idHorario'].'-'.$id;; ?>"/></td 
    ></tr>
    
  <?php } while($row_JRHorarios1 = mysql_fetch_assoc($JRHorarios1));?> 
  <?php  mysql_free_result($JRHorarios1);?>
    </table>
    </div>
  <?php }
  else 
  {
	 echo'<script type="text/javascript">alertas("La consulta no arrojo resultados por favor verifique que la asignatura y el grupo existe ","Cancelar Reserva Asignatura","error");</script> ';  
  }
  
   }
  ?>  

<?php mysql_close($conexion);?>
</body>
</html>


