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

if(isset($_POST['idTipo']))
{

	$idTipodetalle= $_POST['idTipo'];
	
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRDetalleRecursoGrupo = "SELECT Noinventario, estadorecurso, caracteristicas, estadoprestamo, novedades,cantidad,Nombrebien FROM recursos WHERE idTipo = $idTipodetalle";
	mysql_query("SET NAMES 'utf8'");
	$JRDetalleRecursoGrupo = mysql_query($query_JRDetalleRecursoGrupo, $conexion) or die(mysql_error());
	$row_JRDetalleRecursoGrupo = mysql_fetch_assoc($JRDetalleRecursoGrupo);
	$totalRows_JRDetalleRecursoGrupo = mysql_num_rows($JRDetalleRecursoGrupo);
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
	
	<?php if ($totalRows_JRDetalleRecursoGrupo > 0 ){ ?>
	
	 
	   <table cellspacing="0"  cellpadding="0" class="detallegruporecurso" width="600">
	
	  <tr>
		
		 <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
		 <td  colspan="6" <?php echo $stylecabecera; ?>><center><p>Piso Informático - Facultad de Artes Integradas
	</p></center><center><p>Universidad del Valle </p></center> </td>
		 
	  </tr>  
	   
	  <tr>
		<td colspan="7" <?php echo $stylecabeceratitulo; ?> > <center><p>REPORTE RECURSOS</p></center>   </td>
	  </tr>
	  
	  <tr>
		<th <?php echo $styleth; ?>>Inventario</th>
		<th <?php echo $styleth; ?>>Nombre Bien</th>
		<th <?php echo $styleth; ?>>Caracteristicas</th>
		<th <?php echo $styleth; ?>>Estado</th>
		<th <?php echo $styleth; ?>>Total</th>
		<th <?php echo $styleth; ?>>Prestado</th>
		<th <?php echo $styleth; ?>>Disponible</th>
		
	  
	  </tr>
	  <?php do { ?>
	   
	   <?php $prestamo=$row_JRDetalleRecursoGrupo['estadoprestamo']; 
		$novedad= $row_JRDetalleRecursoGrupo['novedades']; 
		$estadorecurso=$row_JRDetalleRecursoGrupo['estadorecurso']; 
		$cantidad= $row_JRDetalleRecursoGrupo['cantidad']; 
	   ?>
		<tr>
		  <td <?php echo $styletr; ?>><?php echo $row_JRDetalleRecursoGrupo['Noinventario']; ?></td>
		  <td <?php echo $styletr; ?>><?php echo $row_JRDetalleRecursoGrupo['Nombrebien']; ?></td>
		  <td <?php echo $styletr; ?>><?php echo $row_JRDetalleRecursoGrupo['caracteristicas']; ?></td>
		  <td <?php echo $styletr; ?>><?php if($estadorecurso!='inactivo') {echo $estadorecurso;} else if($estadorecurso=='inactivo'){echo $novedad;} ?></td>
		  <td <?php echo $styletr; ?>><?php if($estadorecurso!='inactivo')  echo $row_JRDetalleRecursoGrupo['cantidad']; else if($estadorecurso=='inactivo') echo $cantidad=0;  ?></td>
		  <td <?php echo $styletr; ?>><?php if($prestamo=='Prestado'){echo $prestamo+=1;}else{ echo $prestamo=0;} ?></td>
		  <td <?php echo $styletr; ?>><?php echo $disponibles=$cantidad-$prestamo; ?></td>
		 
		</tr>
		<?php } while ($row_JRDetalleRecursoGrupo = mysql_fetch_assoc($JRDetalleRecursoGrupo)); ?>
		
		  <tr>
             <td colspan="7" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
            </tr>
		
	</table>
	
	<?php } else { echo '<script type="text/javascript">alertas("La Consulta no arrojo resultados", "Reporte Recursos","error")</script>';}?>
	
	<div id="alertas"></div>
	
	</body>
	</html>
	<?php
	mysql_free_result($JRDetalleRecursoGrupo);
	mysql_close($conexion);
}
?>
