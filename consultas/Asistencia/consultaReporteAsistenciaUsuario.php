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

 $styleth=' style="padding: 5px;
			font-size: 12px;
			background-color:#DADADA;
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
			
	
	$stylecabecera=	'style="
	  background-color:#DADADA;
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
	 border-bottom-color:black; "';
	 
	 $stylecabeceratitulo='style="text-align:center; 
	 font-weight:bold; 
	 font-size:12px; 
	 border-left-style:solid;
	 border-left-width:1px; 
	 border-left-color:black; 
	 border-right-style:solid;
	 border-right-width:1px; 
	 border-right-color:black;"';				
	
	$styleImagen= 'style="
	  background-color:#DADADA;
	 border-top-style:solid;
	 border-top-width:1px;
	 border-top-color:black;
	 border-bottom-style:solid;
	 border-bottom-width:1px;
	 border-bottom-color:black;
	 border-left-style:solid; 
	 border-left-width:1px; 
	 border-left-color:black;"';
	 
	 $styleSinEspacio='style="text-align:center; 
	 font-weight:bold; 
	 font-size:12px;
	 border-left-style:solid; 
	 border-left-width:1px; 
	 border-left-color:black;
	 border-right-style:solid;
	 border-right-width:1px; 
	 border-right-color:black;
	 border-bottom-style:solid;
	 border-bottom-width:1px; 
	 border-bottom-color:black;"';		
	 
	 
 function calcular_tiempo_trasnc($hora1,$hora2)
 {
	 $separar[1]=explode(':',$hora1);
	 $separar[2]=explode(':',$hora2);
		
	 $total_minutos_trasncurridos[1] = ($separar[1][0]*60) +$separar[1][1];
	 $total_minutos_trasncurridos[2] = ($separar[2][0]*60) +$separar[2][1];
	 $total_minutos_trasncurridos = $total_minutos_trasncurridos[2]-$total_minutos_trasncurridos[1];
	
	return $total_minutos_trasncurridos;   
		 
  }
  
  function formatearHora($hora1)
  {
	$horaFormateada[1]=explode(':',$hora1);
	$horaTransformada= $horaFormateada[1][0].":".$horaFormateada[1][1]; 
	return $horaTransformada;		
  }
  
  
if(isset($_POST['usuario'],$_POST['comienzo'],$_POST['final']))
{
	
	$usuario=$_POST['usuario'];
	$fechai=implode('-',array_reverse(explode('-',$_POST['comienzo'])));
	$fechaf=implode('-',array_reverse(explode('-',$_POST['final'])));
	$totaltiempo=0;
	
	//Consulta que trae la informacion del usuario
	mysql_select_db($database_conexion, $conexion);
	$query_JRNombreusuario = "SELECT nombreUsu, apellidos, estamento, dependencia FROM usuarios WHERE codUsuario = $usuario";
	mysql_query("SET NAMES 'utf8'");
	$JRNombreusuario = mysql_query($query_JRNombreusuario, $conexion) or die(mysql_error());
	$row_JRNombreusuario = mysql_fetch_assoc($JRNombreusuario);
	$totalRows_JRNombreusuario = mysql_num_rows($JRNombreusuario);
	$nombre=$row_JRNombreusuario['nombreUsu']." ".$row_JRNombreusuario['apellidos'];
	$estamento=$row_JRNombreusuario['estamento'];
	$dependencia=$row_JRNombreusuario['dependencia'];
	mysql_free_result($JRNombreusuario);
	
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRReporteAsistencia = "SELECT i.fecha, i.horaingreso, i.horasalida, i.codAsignatura, i.codGrupo, a.nomAsignatura  FROM ingreso_salida i inner join asignatura a on (a.codAsignatura=i.codAsignatura) WHERE i.codUsuario=$usuario and i.fecha between '$fechai' and '$fechaf' order by codAsignatura, codGrupo" ;
	mysql_query("SET NAMES 'utf8'");
	$JRReporteAsistencia = mysql_query($query_JRReporteAsistencia, $conexion) or die(mysql_error());
	$row_JRReporteAsistencia = mysql_fetch_assoc($JRReporteAsistencia);
	$totalRows_JRReporteAsistencia = mysql_num_rows($JRReporteAsistencia);
	
	mysql_select_db($database_conexion, $conexion);
    $query_JRAsignaturas = "select distinct i.codAsignatura, i.codGrupo, a.nomAsignatura from ingreso_salida i inner join asignatura a on (a.codAsignatura=i.codAsignatura) where i.codusuario='$usuario' and i.fecha BETWEEN '$fechai' and '$fechaf'";
    $JRAsignaturas = mysql_query($query_JRAsignaturas, $conexion) or die(mysql_error());
    $row_JRAsignaturas = mysql_fetch_assoc($JRAsignaturas);
    $totalRows_JRAsignaturas = mysql_num_rows($JRAsignaturas);
	
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
	
	
	<?php if($totalRows_JRReporteAsistencia > 0){ ?>
	
	 
	 
	 <table cellspacing="0" cellspacing="0" width="600" class="DatosRAsistencia">
	
	  <tr>
		
		 <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
		 <td  colspan="6" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
		  </p></center><center><p>Universidad del Valle </p></center></td>
		 
	  </tr>  
	   
	  <tr>
		<td colspan="7" <?php echo $stylecabeceratitulo; ?> > <center><p> REPORTE DE ASISTENCIA USUARIOS</p></center> </td>
	  </tr>
      
      <tr>
		<th <?php echo $styleth;?>>Codigo</th>
        <th <?php echo $styleth;?> colspan="2">Nombre</th>
		<th <?php echo $styleth;?> colspan="3">Dependencia</th>
        <th <?php echo $styleth;?>>Estamento</th>
	  </tr>
	     
        <tr>
		 <td <?php echo $styletr; ?>> <?php echo $usuario;?></td>
		 <td <?php echo $styletr; ?> colspan="2"> <?php echo $nombre ?></td>
		 <td <?php echo $styletr; ?> colspan="3"> <?php echo $dependencia ?></td>
         <td <?php echo $styletr; ?>> <?php echo $estamento ?></td>
	   </tr>
       
       <?php // Muestra la informacion de la signaturas del usuario ?>
       
       <tr>
		<td colspan="7" <?php echo $stylecabeceratitulo; ?> > <center><p> INFORMACION ASIGNATURAS</p></center> </td>
	  </tr>
      
      <tr>
		<th <?php echo $styleth;?>>Codigo</th>
        <th <?php echo $styleth;?>>Asignatura</th>
        <th <?php echo $styleth;?>>Grupo</th>
		<th <?php echo $styleth;?> colspan="2">Fecha Inicio</th>
        <th <?php echo $styleth;?> colspan="2">Fecha Terminación</th>
	  </tr>
	    
       <?php do{ 
	   
	      $asignatura= $row_JRAsignaturas['codAsignatura'];
		  $grupo= $row_JRAsignaturas['codGrupo'];
		  $nombre=$row_JRAsignaturas['nomAsignatura'];
		  
          mysql_select_db($database_conexion, $conexion);
		  $query_JRInfoasignaturas = "select fechaInicio, fechaFinal from horario where No_reserva = (select No_reserva from horario where codAsignatura='$asignatura' and codGrupo=$grupo order by No_reserva desc limit 1)";
		  $JRInfoasignaturas = mysql_query($query_JRInfoasignaturas, $conexion) or die(mysql_error());
		  $row_JRInfoasignaturas = mysql_fetch_assoc($JRInfoasignaturas);
		  $totalRows_JRInfoasignaturas = mysql_num_rows($JRInfoasignaturas);
		  $fechainicio=$row_JRInfoasignaturas['fechaInicio'];
		  $fechafinal=$row_JRInfoasignaturas['fechaFinal'];?> 
          <?php mysql_free_result($JRInfoasignaturas);?>
          
        <?php if ($totalRows_JRAsignaturas) {?>   
        <tr>
		 <td <?php echo $styletr; ?>> <?php echo $asignatura;?></td>
         <td <?php echo $styletr; ?>> <?php echo $nombre ?></td>
		 <td <?php echo $styletr; ?> > <?php echo $grupo ?></td>
         <td <?php echo $styletr; ?> colspan="2"> <?php echo $fechainicio;?> </td>
         <td <?php echo $styletr; ?> colspan="2"> <?php echo $fechafinal; ?> </td>
	   </tr>
       <?php } ?>
       <?php } while($row_JRAsignaturas = mysql_fetch_assoc($JRAsignaturas)) ?>
        <?php mysql_free_result($JRAsignaturas);?>
      
      <tr>
		<td colspan="7" <?php echo $stylecabeceratitulo; ?> ><center><p> DETALLE INGRESO ASIGNATURAS USUARIO</p></center> </td>
	  </tr>
       	  
	  <tr>
        <th <?php echo $styleth;?>>Codigo</th>
        <th <?php echo $styleth;?>>Asignatura</th> 
		<th <?php echo $styleth;?>>Grupo</th>     
		<th <?php echo $styleth;?> >Fecha de Ingreso</th>
		<th <?php echo $styleth;?>>Hora de Ingreso</th>
		<th <?php echo $styleth;?>>Hora de Salida</th>
        <th <?php echo $styleth;?>>Total Tiempo</th>
	  </tr>
      
      <?php 
	    $total1=0;
		$totaltiempousuario=0;
		$totalhorasasistidas=0;
		$totalminutosasistidos=0;
		$totalhorasminutosasistidos=0;
	   
	  ?>
	  
	  <?php do { 
	  
	  //Reinicio a 0 los valores para calcular el tiempo
		 $total=0;
		 $totaltiempo=0;
		 $totalhoras=0;
		 $totalminutos=0;
		 $totalhorasminutos=0;
		  
	    // Se calcula el tiempo en el que el estudiante ingreso a clase ese dia
		if ($totalRows_JRReporteAsistencia) {
			$hora1=$row_JRReporteAsistencia['horaingreso'];
			$hora2=$row_JRReporteAsistencia['horasalida'];
			$total=calcular_tiempo_trasnc($hora1,$hora2);
			$totaltiempo+=$total;
			$totalhoras=(int)($totaltiempo/60);
			$totalminutos=$totaltiempo%60;
			$totalhorasminutos= $totalhoras.":".$totalminutos;
		}
		// Se calcula el tiempo total que el usuario asistio a la asignatura
		 if ($totalRows_JRReporteAsistencia) {
			 $total1=calcular_tiempo_trasnc($hora1,$hora2);
			 $totaltiempousuario+=$total1;
			 $totalhorasasistidas=(int)($totaltiempousuario/60);
			 $totalminutosasistidos= $totaltiempousuario%60;
			 $totalhorasminutosasistidos= $totalhorasasistidas.":".$totalminutosasistidos;
		 }
			
		if($totalminutos<=9 && $totalhoras<=9 )
		{
		   $totalhorasminutos= "0".$totalhoras.":"."0".$totalminutos;		  
		}
		else if($totalminutos<=9 && $totalhoras >9 )
		{
		   $totalhorasminutos= $totalhoras.":"."0".$totalminutos;		  
		}
		else if($totalminutos==0 && $totalhoras <=9 )
		{
		  $totalhorasminutos= "0". $totalhoras.":"."0".$totalminutos; 		
		}
		else if($totalminutos>0 && $totalhoras >9 )
		{
		  $totalhorasminutos= $totalhoras.":".$totalminutos;
		}
		else if($totalminutos > 0 && $totalhoras<=9 )
		{
		  $totalhorasminutos= "0".$totalhoras.":".$totalminutos;	  
		}
	  
	  ?>
      <?php if ($totalRows_JRReporteAsistencia) { ?>
		<tr>
          <td <?php echo $styletr; ?>><?php echo $row_JRReporteAsistencia['codAsignatura'];  ?></td>
          <td <?php echo $styletr; ?>><?php echo $row_JRReporteAsistencia['nomAsignatura'];  ?></td>
          <td <?php echo $styletr; ?>><?php echo $row_JRReporteAsistencia['codGrupo'];  ?></td>       
		  <td <?php echo $styletr; ?>><?php echo $row_JRReporteAsistencia['fecha']; ?></td>
		  <?php $horaInicial= $row_JRReporteAsistencia['horaingreso']; $horaFinal=$row_JRReporteAsistencia['horasalida'] ?>
		  <td <?php echo $styletr; ?>><?php echo $hora= formatearHora($horaInicial);  ?></td>
		  <td <?php echo $styletr; ?>><?php echo $hora= formatearHora($horaFinal);  ?></td>
          <td <?php echo $styletr; ?>><?php echo $totalhorasminutos;  ?></td>
		</tr>
        <?php } ?>   
		<?php } while ($row_JRReporteAsistencia = mysql_fetch_assoc($JRReporteAsistencia)); ?>
        
        <?php
		
        if($totalminutosasistidos<=9 && $totalhorasasistidas<=9 )
		{
		  $totalhorasminutosasistidos= "0".$totalhorasasistidas.":"."0".$totalminutosasistidos;
		  
		}
		else if($totalminutosasistidos<=9 && $totalhorasasistidas >9 )
		{
		   $totalhorasminutosasistidos= $totalhorasasistidas.":"."0".$totalminutosasistidos;
		  
		}
		else if($totalminutosasistidos==0 && $totalhorasasistidas <=9 )
		{
		  $totalhorasminutosasistidos= "0". $totalhorasasistidas.":"."0".$totalminutosasistidos; 
		
		}
		else if($totalminutosasistidos>0 && $totalhorasasistidas >9 )
		{
		  $totalhorasminutosasistidos= $totalhorasasistidas.":".$totalminutosasistidos;
		 
	    }
		else if($totalminutosasistidos > 0 && $totalhorasasistidas<=9 )
		{
		  $totalhorasminutosasistidos= "0".$totalhorasasistidas.":".$totalminutosasistidos;
		  
		}
		?>
        
        <tr>
		   <td colspan="7" align="center" <?php echo $stylecabecera; ?>>Total Horas asistidas:  <?php echo $totalhorasminutosasistidos ?></td>
		</tr>
		
		 <tr>
             <td colspan="7" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
            </tr>
		
	</table>
	
	<div id="alertas"></div>
	
	</body>
	</html>
	
	
	
	<?php
	mysql_free_result($JRReporteAsistencia);
	mysql_close($conexion);
	?>
	
	<?php }
	else 
	{
	  echo '<script type="text/javascript">alertas("La Consulta no arrojo resultados", "Reporte Asistencia","error")</script>'; 	
	}
}
?>
