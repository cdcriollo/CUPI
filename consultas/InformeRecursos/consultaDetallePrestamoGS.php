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

if(isset($_POST['idtipo'],$_POST['subtipo'],$_POST['fechaI'],$_POST['fechaF']))
{

	$idtipo= $_POST['idtipo'];
	$subtipo=$_POST['subtipo'];
	$fechainicial= implode('-',array_reverse(explode('-',$_POST['fechaI'])));
	$fechafinal=implode('-',array_reverse(explode('-',$_POST['fechaF'])));
	
		mysql_select_db($database_conexion, $conexion);
	  $query_JRDetalleprestamos = "select  p.fechaprestamo, p.horaentrega, p.horarecibido, u.codUsuario, u.nombreUsu, u.dependencia, u.estamento from detalle_prestamo d inner join recursos r on (d.Noinventario=r.Noinventario) inner join prestamorecursos p on (d.idPrestamo=p.idPrestamo) inner join ingreso_salida i on (p.codIngreso= i.codIngreso) inner join usuarios u on (i.codUsuario=u.codUsuario) where p.fechaprestamo BETWEEN '$fechainicial' and '$fechafinal' and r.idTipo=$idtipo and r.subGrupo=$subtipo";
	  mysql_query("SET NAMES 'utf8'");
		$JRDetalleprestamos = mysql_query($query_JRDetalleprestamos, $conexion) or die(mysql_error());
		$row_JRDetalleprestamos = mysql_fetch_assoc($JRDetalleprestamos);
		$totalRows_JRDetalleprestamos = mysql_num_rows($JRDetalleprestamos);
	
	
	
	function calcular_tiempo_trasnc($hora1,$hora2){
		
	
	 $separar[1]=explode(':',$hora1);
	 $separar[2]=explode(':',$hora2);
		
	$total_minutos_trasncurridos[1] = ($separar[1][0]*60) +$separar[1][1];
	$total_minutos_trasncurridos[2] = ($separar[2][0]*60) +$separar[2][1];
	$total_minutos_trasncurridos = $total_minutos_trasncurridos[2]-$total_minutos_trasncurridos[1];
	
	return $total_minutos_trasncurridos;   
		 
	}
	?>
	
	<?php
	
	
	$styleth=' style="padding: 5px;
			font-size: 12px;
			background-color: #DADADA;
			font:Arial, Helvetica, sans-serif;
			border-style: solid;
			border-color: #000000;
			color: #000;
			border-width: 1px;"';
			
			
	 $styletr='style="font-size: 12px;
			font-weight:bold;
			color: #34484E;
			font:Arial, Helvetica, sans-serif;
			border-style: solid;
			border-color: #000000;
			border-width: 1px;
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
	 border-top-color:black;
	 border-bottom-style:solid;
	 border-bottom-width:1px;
	 border-bottom-color:black;
	  "';
	 
	 $stylecabeceratitulo='style="text-align:center; 
	 font-weight:bold; 
	 font-size:12px;  
	 border-right-style:solid;
	 border-right-width:1px; 
	 border-right-color:black;
	 border-left-style:solid;
	 border-left-width:1px; 
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
	 
	 $stylefooter='style="text-align:center; 
	 background-color: #DADADA;
	 font-weight:bold; 
	 font-size:12px;  
	 border-right-style:solid;
	 border-right-width:1px; 
	 border-right-color:black;
	 border-left-style:solid;
	 border-left-width:1px; 
	 border-left-color:black;
	 border-bottom-style:solid;
	 border-bottom-width:1px;
	 border-bottom-color:black;
	 border-top-style:solid;
	 border-top-width:1px;
	 border-top-color:black;"';						
	
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
	
	<?php if ($totalRows_JRDetalleprestamos > 0 ) {?>
	
	
	  <table cellspacing="0" cellspacing="0" width="600" class="detallegruporecurso">
	
	  <tr>
		
		 <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
		 <td  colspan="5" <?php echo $stylecabecera; ?>><center><p>Piso Informático - Facultad de Artes Integradas
	</p></center><center><p>Universidad del Valle </p></center> </td>
		 
	  </tr>  
	   
	  <tr>
		<td colspan="6" <?php echo $stylecabeceratitulo; ?> > <center><p> REPORTE RECURSOS</p></center> </td>
	  </tr>
	  
	 
	  <tr>
		<th <?php echo $styleth; ?>>Codigo</th>
		<th <?php echo $styleth; ?>>Usuario</th>
		<th <?php echo $styleth; ?>>Dependencia</th>
		<th <?php echo $styleth; ?>>Estamento</th>
		<th <?php echo $styleth; ?>>Fecha</th>
		<th <?php echo $styleth; ?>>Tiempo</th>
	   
	   
	  </tr>
	  <?php do { ?>
		<tr>
		  <td <?php echo $styletr; ?>><?php echo $row_JRDetalleprestamos['codUsuario']; ?></td>
		  <td <?php echo $styletr; ?>><?php echo $row_JRDetalleprestamos['nombreUsu']; ?></td>
		  <td <?php echo $styletr; ?>><?php echo $row_JRDetalleprestamos['dependencia']; ?></td>
		  <td <?php echo $styletr; ?>><?php echo $row_JRDetalleprestamos['estamento']; ?></td>
		  <td <?php echo $styletr; ?>><?php echo $row_JRDetalleprestamos['fechaprestamo']; ?></td>
		  <?php
		   $hora1= $row_JRDetalleprestamos['horaentrega']; 
		   $hora2= $row_JRDetalleprestamos['horarecibido']; 
		  ?>
		  
		  <td <?php echo $styletr; ?>><?php  $total=calcular_tiempo_trasnc($hora1,$hora2); 
		   $totalhoras=(int)($total/60);
		   $totalminutos=$total%60;
		  
				   if($totalminutos<=9 && $totalhoras<=9){
					echo $totalhorasminutos= "0".$totalhoras.":"."0".$totalminutos;
				  }
				  else if($totalminutos<=9 && $totalhoras >9){
					 echo $totalhorasminutos= $totalhoras.":"."0".$totalminutos;
				  }
				   else if($totalminutos==0 && $totalhoras <=9){
					 echo $totalhorasminutos= "0". $totalhoras.":"."0".$totalminutos;  
				   }
				  else if($totalminutos>0 && $totalhoras >9){
					echo $totalhorasminutos= $totalhoras.":".$totalminutos;
				  }
				  else if($totalminutos>0 && $totalhoras<=9){
					echo $totalhorasminutos= "0".$totalhoras.":".$totalminutos;
				  }
				
		  ?></td>
		 
		</tr>
		<?php } while ($row_JRDetalleprestamos = mysql_fetch_assoc($JRDetalleprestamos)); ?>
		
		<tr>
             <td colspan="6" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
         </tr> 
		
	</table>
	
	 <?php  mysql_free_result($JRDetalleprestamos);?>
		
	 <?php } else { echo '<script type="text/javascript">alertas("El recurso no se encuentra prestado en el rango de fechas especificado", "Reporte Recursos","inform")</script>'; }
	 
}?>
  
<div id="alertas"></div>
<?php mysql_close($conexion);?>
</body>
</html>



