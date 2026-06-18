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

if(isset($_POST['reserva']))
{
	$reserva= $_POST['reserva'];
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRReserva = "SELECT No_reserva, nombre_asignatura, internet, cod_asignatura, grupo FROM reserva_eventual WHERE No_reserva = '$reserva'";
	mysql_query("SET NAMES 'utf8'");
	$JRReserva = mysql_query($query_JRReserva, $conexion) or die(mysql_error());
	$row_JRReserva = mysql_fetch_assoc($JRReserva);
	$totalRows_JRReserva = mysql_num_rows($JRReserva);
	
	$internet= $row_JRReserva['internet'];
	$nombreasignatura= $row_JRReserva['nombre_asignatura'];
	$asignatura= $row_JRReserva['cod_asignatura'];
	$grupo= $row_JRReserva['grupo'];
	
	if($totalRows_JRReserva > 0)
	{
	    mysql_select_db($database_conexion, $conexion);
		$query_JRHorario = "SELECT codDia, horainicio, horafinal, sala, fechaInicio,fechaFinal, No_reserva FROM horario WHERE No_reserva='$reserva' ORDER BY idHorario asc";
		$JRHorario = mysql_query($query_JRHorario, $conexion) or die(mysql_error());
		$row_JRHorario = mysql_fetch_assoc($JRHorario);
		$totalRows_JRHorario = mysql_num_rows($JRHorario);

		mysql_select_db($database_conexion, $conexion);
		$query_JRReporteClase = "SELECT distinct m.codUsuario, u.nombreUsu, u.apellidos, m.pc, m.No_reserva, h.sala FROM matricula m inner join usuarios u on(m.codUsuario=u.codUsuario) inner join horario h on(m.idHorario=h.idHorario) inner join pcs p on(m.pc=p.Nopc) WHERE m.No_reserva= '$reserva' and p.estado <> 'Docente' and m.Estado='Activa' order by pc";
		mysql_query("SET NAMES 'utf8'");
		$JRReporteClase = mysql_query($query_JRReporteClase, $conexion) or die(mysql_error());
		$row_JRReporteClase = mysql_fetch_assoc($JRReporteClase);
		$totalRows_JRReporteClase = mysql_num_rows($JRReporteClase);
		
		
		mysql_select_db($database_conexion, $conexion);
		$query_JRDocentes = "SELECT distinct m.codUsuario, u.nombreUsu, u.apellidos, u.dependencia, p.Nopc FROM matricula m inner join usuarios u on(m.codUsuario=u.codUsuario) inner join pcs p on(m.pc=p.Nopc) WHERE m.No_reserva= '$reserva' and p.estado='Docente' and m.Estado='Activa'";
		mysql_query("SET NAMES 'utf8'");
		$JRDocentes = mysql_query($query_JRDocentes, $conexion) or die(mysql_error());
		$row_JRDocentes = mysql_fetch_assoc($JRDocentes);
		$totalRows_JRDocentes = mysql_num_rows($JRDocentes);
		
		
		mysql_select_db($database_conexion, $conexion);
		$query_JRRecursosreservados = "SELECT g.descripcionTipo,s.descripcionSubtipo, r.cantidad, r.Software, r.No_reserva FROM recursos_reservados r inner join gruporecurso g on(r.grupo=g.idTipo) INNER join subgrupo s on(r.subgrupo=s.idsubtipo) WHERE r.No_reserva= '$reserva' 
";
		mysql_query("SET NAMES 'utf8'");
		$JRRecursosreservados = mysql_query($query_JRRecursosreservados, $conexion) or die(mysql_error());
		$row_JRRecursosreservados = mysql_fetch_assoc($JRRecursosreservados);
		$totalRows_JRRecursosreservados = mysql_num_rows($JRRecursosreservados);

			
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
		
	?>
	
	
	<?php 
	
	$styleth=' style="padding: 5px;
	font-size: 12px;
	background-color: #DADADA;
    border-left-style:solid;
	border-left-width:1px; 
	border-left-color:black;
	border-top-style:solid;
	border-top-width:1px;
	border-top-color:black;"';
			
			
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
	
	<?php if ($totalRows_JRReserva > 0){ ?>
	
	 <table cellspacing="0" cellspacing="0" width="650" class="ReporteClase" id="ReporteClase">
	
	  <tr>
		
		 <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
		 <td  colspan="6" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
		 </p></center><center><p>Universidad del Valle </p></center> </td>
    </tr>
	  
	  <tr>
	  <td <?php echo $stylecabeceratitulo;?> colspan="7"><center><p>INFORMACIÓN ASIGNATURA </p></center></td>
	  </tr>
	  
	  
	  <tr>         
		<th <?php echo $styleth;?>>Codigo</th>
        <th <?php echo $styleth;?>>Grupo</th>
	    <th<?php echo $styleth;?> colspan="4">Nombre</th>
		<th <?php echo $style_td_th;?>>No Reserva</th>   
	  </tr>
	  
	   <tr>
		<td <?php echo $styletr; ?> ><?php echo $asignatura; ?></td>
        <td <?php echo $styletr; ?> ><?php echo $grupo ?></td>
		<td <?php echo $styletr; ?> colspan="4"><?php echo $nombreasignatura; ?></td>
		<td <?php echo $style_td_tr; ?> ><?php echo $row_JRHorario['No_reserva']; ?></td>
	  </tr>  
	  
      <?php if($totalRows_JRHorario > 0 ) {?>
	  <tr>
		<td align="center" <?php echo $stylecabeceratitulo;?> colspan="7">HORARIO DE CLASES</td>
	  </tr>  
	   
		<tr>
         <th <?php echo $styleth;?> >Fecha Inicio</th>
		 <th <?php echo $styleth;?>>Fecha Terminación</th>
         <th <?php echo $styleth;?>>Hora Inicio</th>
		 <th<?php echo $styleth;?> >Hora Final</th>
		 <th <?php echo $styleth;?> colspan="2">Dia</th>	 
		 <th <?php echo $style_td_th;?>>Sala</th>         
	  </tr>
	  
	   <?php do { ?>
	   
		<tr>
          <td <?php echo $styletr; ?> ><?php echo $row_JRHorario['fechaInicio'] ?></td>
		  <td <?php echo $styletr; ?> ><?php echo $row_JRHorario['fechaFinal'] ?></td>
		  <td <?php echo $styletr; ?>><?php echo $row_JRHorario['horainicio']; ?></td>
		  <td <?php echo $styletr; ?> ><?php echo $row_JRHorario['horafinal'];  ?></td>
          <?php $diasemana=descripcionDia($row_JRHorario['codDia']);?>
		  <td <?php echo $styletr; ?> colspan="2"><?php echo $diasemana; ?></td>
		  <td <?php echo $style_td_tr; ?>><?php echo $row_JRHorario['sala'];  ?></td>
          
		</tr>
	   <?php } while ($row_JRHorario = mysql_fetch_assoc($JRHorario)); ?>
        <?php mysql_free_result($JRHorario); } ?> 
	   
	  <?php if ($totalRows_JRDocentes > 0) {?>
      
		<tr>
		 <td align="center" <?php echo $stylecabeceratitulo;?> colspan="7">DOCENTE(S)</td>
	   </tr>  
	   
		<tr>
		 <th <?php echo $styleth;?> colspan="2">Codigo</th>
		 <th <?php echo $styleth;?> colspan="2" >Nombre</th>
         <th <?php echo $styleth;?> colspan="2">Dependencia</th>
         <th <?php echo $style_td_th;?> >Computador</th>
		 
		</tr>
	    
	   <?php do { ?>
	   
		<tr>
		  <td <?php echo $styletr; ?> colspan="2"><?php echo $row_JRDocentes['codUsuario']; ?></td>
          <?php $docente= $row_JRDocentes['nombreUsu']." ".$row_JRDocentes['apellidos'] ?>
		  <td <?php echo $styletr; ?> colspan="2" ><?php echo $docente; ?></td>
          <td <?php echo $styletr; ?> colspan="2"><?php echo $row_JRDocentes['dependencia']; ?></td>
          <td <?php echo $style_td_tr; ?>><?php echo $row_JRDocentes['Nopc']; ?></td>		  
		</tr>
	   <?php } while ($row_JRDocentes = mysql_fetch_assoc($JRDocentes)); ?>
       <?php mysql_free_result($JRDocentes); } ?>
       
       
       <?php if($totalRows_JRRecursosreservados) { ?>
	   
	   <tr>
		 <td align="center" <?php echo $stylecabeceratitulo;?> colspan="7">RECURSOS RESERVADOS</td>
	   </tr>
       
       <tr>
         <th <?php echo $styleth; ?>>Internet:</th>
         <th <?php echo $style_td_th; ?>><?php echo $internet ?></th>
       </tr>  
	   
		<tr>
		 <th <?php echo $styleth;?> colspan="3">Equipos</th>
		 <th <?php echo $styleth;?> colspan="1" >Cantidad</th>
         <th <?php echo $style_td_th;?> colspan="3" >Software</th>
		</tr>
	    
	   <?php do { ?>
	   
		<tr>
		  <td <?php echo $styletr; ?> colspan="3"><?php echo $row_JRRecursosreservados['descripcionTipo']." ".$row_JRRecursosreservados['descripcionSubtipo']; ?></td>
		  <td <?php echo $styletr; ?> colspan="1" ><?php echo $row_JRRecursosreservados['cantidad'] ?></td>
          <td <?php echo $style_td_tr; ?> colspan="3" ><?php echo $row_JRRecursosreservados['Software']; ?></td>
		</tr>
	   <?php } while ($row_JRRecursosreservados = mysql_fetch_assoc($JRRecursosreservados)); ?>
       <?php mysql_free_result($JRRecursosreservados); 
	   
	   }?>
       
	  <?php if($totalRows_JRReporteClase > 0) {?> 
          
	  <tr>
		<td colspan="7" <?php echo $stylecabeceratitulo; ?>> <center><p>USUARIOS MATRICULADOS</p></center> </td>
	  </tr>
	  
	  <tr>
        <th <?php echo $styleth;?>>No</th> 
		<th <?php echo $styleth;?>>Codigo Usuario</th>
		<th <?php echo $styleth;?> colspan="3" >Nombre</th>
		<th <?php echo $styleth;?>>Computador</th>
		<th <?php echo $style_td_th;?>>Sala</th>
	  </tr>
	  
       <?php $i=1; ?>
	  <?php do { ?>
		<tr>
          <td <?php echo $styletr; ?>><?php echo $i++; ?></td> 
		  <td <?php echo $styletr; ?>><?php echo $row_JRReporteClase['codUsuario']; ?></td>
          <?php $usuario= $row_JRReporteClase['nombreUsu']." ".$row_JRReporteClase['apellidos'] ?>
		  <td <?php echo $styletr; ?> colspan="3"><?php echo $usuario; ?></td>
		  <td <?php echo $styletr; ?>><?php echo $row_JRReporteClase['pc'];  ?></td>
		  <td <?php echo $style_td_tr; ?>><?php echo $row_JRReporteClase['sala'];  ?></td>
		</tr>
		<?php } while ($row_JRReporteClase = mysql_fetch_assoc($JRReporteClase)); ?>
        
        <?php mysql_free_result($JRReporteClase); }?>
		
		 <tr>
             <td colspan="7" <?php echo $stylefooter?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
            </tr>
		
	</table>
	
	
	<div id="alertas"></div>
	
	</body>
	</html>
	
	<?php mysql_free_result($JRReserva);?>
    
	<?php }
	else
	{
	   echo '<script type="text/javascript">alertas("La asignatura no tiene estudiantes matriculados", "Listados de Clase","error")</script>'; 		
	}

}
?>