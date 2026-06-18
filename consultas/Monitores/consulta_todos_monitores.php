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


function calcular_tiempo_trasnc($horastrabajadas)
{
	$separar[1]=explode(':',$horastrabajadas);
	$total_minutos_trasncurridos[1] = ($separar[1][0]*60) +$separar[1][1];
	$total_minutos_trasncurridos = $total_minutos_trasncurridos[1];
	return $total_minutos_trasncurridos;		
}

if(isset($_POST['comienzo'],$_POST['finalizacion']))
{
	$comienzo=implode('-',array_reverse(explode('-',$_POST['comienzo'])));
	$finalizacion= implode('-',array_reverse(explode('-',$_POST['finalizacion'])));
	
	mysql_select_db($database_conexion, $conexion);
	$query_fechas = "select min(comienzo) as fecha_minima, max(finalizacion) as fecha_maxima from vinculacion_monitor where estado='activo'";
	mysql_query("SET NAMES 'utf8'");
	$JRFechas = mysql_query($query_fechas, $conexion) or die(mysql_error());
	$row_JRFechas = mysql_fetch_assoc($JRFechas);
	$totalRows_JRFechas = mysql_num_rows($JRFechas);
	
	$fecha_minima= $row_JRFechas['fecha_minima'];
	$fecha_maxima= $row_JRFechas['fecha_maxima'];
	
	mysql_select_db($database_conexion, $conexion);
    $query_datos = "select m.vccedula, m.vcnombres, m.vcapellidos,v.comienzo, v.finalizacion,v.total_horas_semestre,v.valor_total_vinculacion from monitores m inner join vinculacion_monitor v on (v.cedula=m.vccedula) where v.estado='activo' and '$comienzo' >= '$fecha_minima' and '$finalizacion' <='$fecha_maxima'";
	mysql_query("SET NAMES 'utf8'");
	$JRDatos = mysql_query($query_datos, $conexion) or die(mysql_error());
	$row_JRDatos = mysql_fetch_assoc($JRDatos);
	$totalRows_JRDatos = mysql_num_rows($JRDatos);
		
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
	
	<?php if ($totalRows_JRDatos > 0){ ?>
	
	 <table cellspacing="0" cellspacing="0" width="650" class="ReporteClase" id="ReporteClase">
	
	  <tr>
		
		 <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
		 <td  colspan="7" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
		 </p></center><center><p>Universidad del Valle </p></center> </td>
     </tr>
     
      <tr>
	     <td <?php echo $stylecabeceratitulo;?> colspan="8"><center><p>REPORTE MONITORES VINCULADOS </p></center></td>
	  </tr>
	  
	 <tr>
        <td <?php echo $styletr; ?> colspan="2" ><strong>Periodo Solicitado</strong></td>
		<td <?php echo $styletr; ?> ><strong>Desde:</strong></td>
		<td <?php echo $styletr; ?> colspan="2"><?php echo $comienzo?></td>
		<td <?php echo $styletr; ?> ><strong>Hasta:</strong></td>
		<td <?php echo $style_td_tr; ?> colspan="2" ><?php echo $finalizacion ?></td>
	</tr> 
	
	
	<tr>
	    <td <?php echo $styleth; ?>>Monitor</td>
		<td <?php echo $styleth; ?>>Cedula</td>
		<td <?php echo $styleth; ?>>Fecha de inicio vinculacion</td>
		<td <?php echo $styleth; ?>>Fecha de terminacion vinculacion</td>
		<td <?php echo $styleth; ?>>Total horas del periodo</td>
		<td <?php echo $styleth; ?>>Valor total de la vinculacion</td>
		<td <?php echo $styleth; ?>>Total horas trabajadas a la fecha</td>
		<td <?php echo $styleth; ?>>Total horas por trabajar a la fecha</td>
	</tr> 
	
	<?php do{?>
		
	<tr>
          <td <?php echo $styletr; ?>><?php echo $row_JRDatos['vcnombres']." ".$row_JRDatos['vcapellidos'];  ?></td>
		  <td <?php echo $styletr; ?>><?php echo $row_JRDatos['vccedula']; ?></td>
		  <td <?php echo $styletr; ?>><?php echo $row_JRDatos['comienzo']; ?></td>
		  <td <?php echo $styletr; ?> ><?php echo $row_JRDatos['finalizacion'];  ?></td>
		  <td <?php echo $styletr; ?> ><?php echo $row_JRDatos['total_horas_semestre'];  ?></td>
		  <td <?php echo $style_td_tr; ?>><?php echo "$".$row_JRDatos['valor_total_vinculacion'];  ?></td>  
    <?php 
    
    mysql_select_db($database_conexion, $conexion);
	$query_JRReporteMonitor = "select  total_horas_turno 
	from ingreso_salida_monitor
	where codigo= '$row_JRDatos[vccedula]'
	and estado='terminado'
	and fecha_entrada >= '$comienzo' and fecha_salida <='$finalizacion' ";
	mysql_query("SET NAMES 'utf8'");
	$JRReporte = mysql_query($query_JRReporteMonitor, $conexion) or die(mysql_error());
	$row_JRReporte = mysql_fetch_assoc($JRReporte);
	$totalRows_JRReporte = mysql_num_rows($JRReporte);
	$totaltiempo=0;
	
	if($totalRows_JRReporte > 0){
	
	do{
       
		$total=calcular_tiempo_trasnc($row_JRReporte['total_horas_turno']);
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
			 $total_horas_x_trabajar= $row_JRDatos['total_horas_semestre'] - $horas_trabajadas_monitor[0];
			 $totaltiempo=0;
             mysql_free_result($JRReporte);  
          ?> 
	     
		    <td <?php echo $styletr; ?>><?php echo $totalhorastrabajadas?></td>
		    <td <?php echo $style_td_tr; ?> ><?php echo $total_horas_x_trabajar?></td>
		  <?php }
          else{?>
             <td <?php echo $styletr; ?>></td>
		    <td <?php echo $style_td_tr; ?> ></td>
        <?php }?> 
		  
	     </tr>

         
	<?php } while($row_JRDatos = mysql_fetch_assoc($JRDatos));
	

	 ?>
	      
		 <tr>
             <td colspan="8" <?php echo $stylefooter?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
        </tr>
		
	</table>
	<?php }
	else
	{
	   echo '<script type="text/javascript">alertas("La consulta no arrojo resultados, por favor refine su busqueda", "Reporte Monitor","error")</script>'; 		
	}?>
	
	<div id="alertas"></div>
	
	</body>
	</html>
	
	
	<?php }
	else
	{
	   echo '<script type="text/javascript">alertas("Suministre los datos para realizar la consulta", "Reporte Monitor","error")</script>'; 		
	}

?>