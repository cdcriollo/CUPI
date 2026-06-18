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


function calcular_tiempo_trasnc($horastrabajadas)
{
	$separar[1]=explode(':',$horastrabajadas);
	$total_minutos_trasncurridos[1] = ($separar[1][0]*60) +$separar[1][1];
	$total_minutos_trasncurridos = $total_minutos_trasncurridos[1];

	return $total_minutos_trasncurridos;
		
}

if(isset($_POST['comienzo'],$_POST['finalizacion'], $_POST['codigo']))
{
	$comienzo=implode('-',array_reverse(explode('-',$_POST['comienzo'])));
	$finalizacion= implode('-',array_reverse(explode('-',$_POST['finalizacion'])));
	$codigo= $_POST['codigo'];
	$totaltiempo=0;
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRReporteMonitor = "select distinct i.dia, i.fecha_entrada, i.fecha_salida, i.hora_entrada, i.hora_salida, i.total_horas_turno, i.codigo  
	from ingreso_salida_monitor i
	where i.codigo= '$codigo'
	and i.estado='terminado'
	and i.fecha_entrada >= '$comienzo' and i.fecha_salida <='$finalizacion'
	order by i.fecha_entrada ";
	mysql_query("SET NAMES 'utf8'");
	$JRReporte = mysql_query($query_JRReporteMonitor, $conexion) or die(mysql_error());
	$row_JRReporte = mysql_fetch_assoc($JRReporte);
	$totalRows_JRReporte = mysql_num_rows($JRReporte);
	

	mysql_select_db($database_conexion, $conexion);
	$query_datos = "SELECT vcnombres, vcapellidos, vccedula FROM monitores WHERE vccodigo='$codigo'";
	$JRDatos = mysql_query($query_datos, $conexion) or die(mysql_error());
	$row_JRDatos = mysql_fetch_assoc($JRDatos);
	$totalRows_JRDatos = mysql_num_rows($JRDatos);
		
	$nombres= $row_JRDatos['vcnombres'];
	$apellidos= $row_JRDatos['vcapellidos'];
	
	
	mysql_select_db($database_conexion, $conexion);
	$query_vinculacion = "SELECT comienzo, finalizacion, total_horas_semestre, valor_total_vinculacion FROM vinculacion_monitor WHERE cedula='$codigo'";
	$JRVinculacion = mysql_query($query_vinculacion, $conexion) or die(mysql_error());
	$row_JRVinculacion = mysql_fetch_assoc($JRVinculacion);
	$totalRows_JRVinculacion = mysql_num_rows($JRVinculacion);

		
	?>
	
	
	<?php 
	
	$styleth=' style="padding: 5px;
			font-size: 12px;
			background-color:#DADADA;
			font:Arial, Helvetica, sans-serif;
		    font-weight: bold;
		    text-align: center;
			border-style: solid;
			border-color: #000000;
			color: #000;
			border-width: 1px;"';
			
			
	 $styletr='style="font-size: 12px;
	 color: #34484E;
	 font:Arial, Helvetica, sans-serif;
	 border-left-style:solid;
	 border-left-width:1px; 
	 border-left-color:black;
	 border-top-style:solid;
	 border-top-width:1px;
	 border-top-color:black;
	 text-align:center;"';
			
		 
	 $stylecabecera='style="background-color: #DADADA;
	 font-weight:bold; 
	 border-right-style:solid; 
	 border-right-width:1px; 
	 border-right-color:black; 
	 border-left-style:solid; 
	 border-left-width:1px; 
	 border-left-color:black; 
	 border-top-style:solid;
	 border-top-width:1px;
	 border-top-color:black;"';
	 
	 $stylecabeceratitulo='style="text-align:center; 
	 font-weight:bold; 
	 font-size:12px;  
	 border-right-style:solid;
	 border-right-width:1px; 
	 border-right-color:black;
	 border-left-style:solid;
	 border-left-width:1px;
	 border-top-style:solid;
	 border-top-width:1px;
	 border-top-color:black; 
	 border-left-color:black;"';				
	
	$styleImagen= 'style="background-color: #DADADA;
	 border-top-style:solid;
	 border-top-width:1px;
	 border-top-color:black;
	 border-bottom-style:solid;
	 border-bottom-width:1px;
	 border-bottom-color:black;
	 border-left-style:solid; 
	 border-left-width:1px; 
	 border-left-color:black;"';
	 
	 $stylefooter='style="background-color: #DADADA;
	 font-weight:bold; 
	 border-right-style:solid; 
	 border-right-width:1px; 
	 border-right-color:black; 
	 border-left-style:solid; 
	 border-left-width:1px; 
	 border-left-color:black; 
	 border-top-style:solid;
	 border-top-width:1px;
	 border-top-color:black;
	 border-bottom-style:solid;
	 border-bottom-width:1px;
	 border-bottom-color:black;"';
	  
	  $style_td_th='style="
	  background-color: #DADADA;
	  border-right-style:solid; 
	  border-right-width:1px; 
	  border-right-color:black;
	  border-left-style:solid; 
	  border-left-width:1px; 
	  border-left-color:black;
	  border-top-style:solid;
	  border-top-width:1px;
	  border-top-color:black;"';
	  
	  $style_td_tr='style="
	  font-size: 12px;
	  color: #34484E;
	  font:Arial, Helvetica, sans-serif;
	  border-right-style:solid; 
	  border-right-width:1px; 
	  border-right-color:black;
	  border-left-style:solid; 
	  border-left-width:1px; 
	  border-left-color:black;
	  border-top-style:solid;
	  border-top-width:1px;
	  border-top-color:black;
	  text-align:center;"';				
			
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
	
	<?php if ($totalRows_JRReporte > 0){ ?>
	
	 <table cellspacing="0" cellspacing="0" width="650" class="ReporteClase" id="ReporteClase">
	
	  <tr>
		
		 <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
		 <td  colspan="5" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
		 </p></center><center><p>Universidad del Valle </p></center> </td>
     </tr>
     
      <tr>
	     <td <?php echo $stylecabeceratitulo;?> colspan="6"><center><p>REPORTE MONITOR VINCULADO </p></center></td>
	  </tr>
	  
	 <tr>
        <td <?php echo $styletr; ?> colspan="2" ><strong>Periodo Solicitado</strong></td>
		<td <?php echo $styletr; ?> ><strong>Desde:</strong></td>
		<td <?php echo $styletr; ?>><?php echo $comienzo?></td>
		<td <?php echo $styletr; ?>><strong>Hasta:</strong></td>
		<td <?php echo $style_td_tr; ?> ><?php echo $finalizacion ?></td>
	</tr> 
	
	<?php if($totalRows_JRDatos > 0){?>
	<tr>
		<td <?php echo $styletr; ?>><strong>Monitor:</strong></td>
		<td <?php echo $styletr; ?> colspan="2"><?php echo $nombres.' '.$apellidos?></td>
		<td <?php echo $styletr; ?>><strong>Cedula:</strong></td>
		<td <?php echo $style_td_tr; ?> colspan="2"><?php echo $codigo?></td>
	</tr> 
	<?php }?>
	
	<?php if($totalRows_JRVinculacion) {?>
	
	  <tr>
	    <td <?php echo $styletr; ?> colspan="2"><strong>Fecha de Inicio Vinculacion:</strong></td>
		<td <?php echo $styletr; ?>><?php echo $row_JRVinculacion['comienzo']; ?></td>
		<td <?php echo $styletr; ?> colspan="2"><strong>Fecha de Terminacion Vinculacion:</strong></td>
		<td <?php echo $style_td_tr; ?>><?php echo $row_JRVinculacion['finalizacion'];?></td>
	</tr> 
	
	<tr>
	    <td <?php echo $styletr; ?> colspan="2"><strong>Total Horas del Periodo:</strong></td>
		<td <?php echo $style_td_tr; ?> ><?php echo $row_JRVinculacion['total_horas_semestre'];?></td>
		<td <?php echo $styletr; ?> colspan="2"><strong>Valor Total de la Vinculacion:</strong></td>
		<td <?php echo $style_td_tr; ?>><?php echo '$'.$row_JRVinculacion['valor_total_vinculacion']; ?></td>
	</tr>

	
	<?php }?>
	
	<tr>
	    <td <?php echo $styleth; ?>>Actividad</td>
		<td <?php echo $styleth; ?>>Dia</td>
		<td <?php echo $styleth; ?>>Fecha</td>
		<td <?php echo $styleth; ?>>Hora Entrada</td>
		<td <?php echo $styleth; ?>>Hora Salida</td>
		<td <?php echo $styleth; ?>>Total Horas del Turno</td>
	</tr> 
	
	  
	  
	   <?php do { 
	   
	   	$dia=$row_JRReporte['dia'];
	    mysql_select_db($database_conexion, $conexion);
		$query_JRActividad = "select actividad from turnos_monitor where dia= $dia and cedula='$codigo'";
		mysql_query("SET NAMES 'utf8'");
		$JRActividad = mysql_query($query_JRActividad, $conexion) or die(mysql_error());
		$row_JRActividad = mysql_fetch_assoc($JRActividad);
		$totalRows_JRActividad = mysql_num_rows($JRActividad);?>
	   
	   
		<tr>
          <td <?php echo $styletr; ?>><?php echo $row_JRActividad['actividad'];  ?></td>
          <?php $diasemana=descripcionDia($row_JRReporte['dia']);?>
		  <td <?php echo $styletr; ?>><?php echo $diasemana; ?></td>
		  <td <?php echo $styletr; ?>><?php echo $row_JRReporte['fecha_entrada']; ?></td>
		  <td <?php echo $styletr; ?>><?php echo $row_JRReporte['hora_entrada']; ?></td>
		  <td <?php echo $styletr; ?> ><?php echo $row_JRReporte['hora_salida'];  ?></td>
		  <td <?php echo $style_td_tr; ?>><?php echo $row_JRReporte['total_horas_turno'];  ?></td>
          
		</tr>
		
		<?php  $total_horas_semestre= $row_JRVinculacion['total_horas_semestre']; ?>
		 
		<?php $total=calcular_tiempo_trasnc($row_JRReporte['total_horas_turno']);
				  $totaltiempo+=$total;
				  $totalhoras=(int)($totaltiempo/60);
				  $totalminutos=$totaltiempo%60;
				  $totalhorastrabajadas= $totalhoras.":".$totalminutos;
				  
				  if($totalhoras<=9 && $totalminutos<=9){
				    $totalhorastrabajadas= "0".$totalhoras.":"."0".$totalminutos;
				  }
				  else if($totalminutos<=9 && $totalhoras >9){
					$totalhorastrabajadas= $totalhoras.":"."0".$totalminutos;
				  }
				  else if($totalminutos==0 && $totalhoras <=9){
					$totalhorastrabajadas= "0". $totalhoras.":"."0".$totalminutos;  
				  }
				 else if($totalminutos>0 && $totalhoras >9){
				   $totalhorastrabajadas= $totalhoras.":".$totalminutos;
				 }
				else if($totalminutos>0 && $totalhoras<=9){
				  $totalhorastrabajadas= "0".$totalhoras.":".$totalminutos;
				} 
				?>	 
				
	   <?php } while ($row_JRReporte = mysql_fetch_assoc($JRReporte)); ?>
	   
	     <?php $horas_trabajadas_monitor=explode(':',$totalhorastrabajadas);
			 $total_horas_x_trabajar= $total_horas_semestre - $horas_trabajadas_monitor[0];
             mysql_free_result($JRReporte);  
          ?> 
	     
	      <tr>
	        <td <?php echo $styletr; ?> colspan="2"><strong>Total Horas Trabajadas a la Fecha:</strong></td>
		    <td <?php echo $styletr; ?>><?php echo $totalhorastrabajadas?></td>
		    <td <?php echo $styletr; ?> colspan="2"><strong>Total Horas por Trabajar a la Fecha:</strong></td>
		    <td <?php echo $style_td_tr; ?> ><?php echo $total_horas_x_trabajar?></td>
	      </tr> 
	       
	       
		 <tr>
             <td colspan="6" <?php echo $stylefooter?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
        </tr>
		
	</table>
	<?php }
	else
	{
		echo '<script type="text/javascript">alertas("El monitor no tiene turnos registrados en el sistema", "Reporte Monitor","error")</script>';
	}
	
	?>
	
	<div id="alertas"></div>
	
	</body>
	</html>
	
	
	<?php }
	else
	{
	   echo '<script type="text/javascript">alertas("Por favor ingrese los datos para generar el reporte", "Reporte Monitor","error")</script>'; 		
	}

?>