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
	 
	 $styletrestudiante='style="text-align:center; 
	 font-weight:bold; 
	 font-size:12px; 
	 border-left-style:solid;
	 border-left-width:1px; 
	 border-left-color:black; 
	 border-right-style:solid;
	 border-right-width:1px; 
	 border-right-color:black;"';
	 
	 	 
	function formatearHora($hora1)
	{
		$horaFormateada[1]=explode(':',$hora1);
		$horaTransformada= $horaFormateada[1][0].":".$horaFormateada[1][1]; 
		return $horaTransformada;		
	}
	
   function calcular_tiempo_trasnc($hora1,$hora2)
   {
	 $separar[1]=explode(':',$hora1);
	 $separar[2]=explode(':',$hora2);		
	 $total_minutos_trasncurridos[1] = ($separar[1][0]*60) +$separar[1][1];
	 $total_minutos_trasncurridos[2] = ($separar[2][0]*60) +$separar[2][1];
	 $total_minutos_trasncurridos = $total_minutos_trasncurridos[2]-$total_minutos_trasncurridos[1];
	
	return $total_minutos_trasncurridos;   
		 
  }
  
  function Nombreasignatura($codigo, $database_conexion, $conexion)
  {
	 mysql_select_db($database_conexion, $conexion);
	 $query_JRNombreA = "SELECT nomAsignatura FROM asignatura WHERE codAsignatura = '$codigo'";
	 $JRNombreA = mysql_query($query_JRNombreA, $conexion) or die(mysql_error());
	 mysql_query("SET NAMES 'utf8'");
	 $row_JRNombreA = mysql_fetch_assoc($JRNombreA);
	 $totalRows_JRNombreA = mysql_num_rows($JRNombreA); 
	 return  $row_JRNombreA['nomAsignatura'];
	 mysql_free_result($JRNombreA);
  }

			

if(isset($_POST['asignatura'],$_POST['grupo'],$_POST['comienzo'],$_POST['final']))
{

	$asignatura=$_POST['asignatura'];
	$grupo=$_POST['grupo'];
	$fechai=implode('-',array_reverse(explode('-',$_POST['comienzo'])));
	$fechaf=implode('-',array_reverse(explode('-',$_POST['final'])));
	$totaltiempoasignatura=0;

	
	mysql_select_db($database_conexion, $conexion);
	$query_JRFechas = "SELECT distinct fecha  FROM ingreso_salida WHERE codAsignatura = '$asignatura' and codGrupo=$grupo and fecha between '$fechai' and '$fechaf'
";
    mysql_query("SET NAMES 'utf8'");
	$JRFechas = mysql_query($query_JRFechas, $conexion) or die(mysql_error());
	$row_JRFechas = mysql_fetch_assoc($JRFechas);
	$totalRows_JRFechas = mysql_num_rows($JRFechas);
	
	mysql_select_db($database_conexion, $conexion);
   $query_JRFechahorario = "select fechaInicio, fechaFinal from horario where No_reserva = (select No_reserva from horario where codAsignatura='$asignatura' and codGrupo=$grupo order by No_reserva desc limit 1)";
   $JRFechahorario = mysql_query($query_JRFechahorario, $conexion) or die(mysql_error());
   $row_JRFechahorario = mysql_fetch_assoc($JRFechahorario);
   $totalRows_JRFechahorario = mysql_num_rows($JRFechahorario);
   $fechainicio=$row_JRFechahorario['fechaInicio'];
   $fechafinal=$row_JRFechahorario['fechaFinal'];
   mysql_free_result($JRFechahorario);

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
    
    <?php if($totalRows_JRFechas > 0) {?>
    
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
		<td colspan="7" <?php echo $stylecabeceratitulo; ?> > <center><p> INFORMACIÓN ASIGNATURA</p></center> </td>
	  </tr>
      
      <tr>
		<th <?php echo $styleth;?>>Codigo</th>
        <th <?php echo $styleth;?> colspan="3">Nombre</th>
		<th <?php echo $styleth;?>>Grupo</th>
        <th <?php echo $styleth;?>>Fecha Inicio</th>
        <th <?php echo $styleth;?>>Fecha Terminación</th>
	  </tr>
	  
	   <tr>
        <td <?php echo $styletr; ?>> <?php echo $asignatura?></td>
        <td <?php echo $styletr; ?> colspan="3"> <?php echo Nombreasignatura($asignatura, $database_conexion, $conexion) ?></td>
	    <td <?php echo $styletr; ?>> <?php echo $grupo ?> </td>
        <td <?php echo $styletr; ?>> <?php echo $fechainicio; ?> </td>
        <td <?php echo $styletr; ?>> <?php echo $fechafinal; ?> </td>
	   </tr>
	  
	  
	
    <?php 
	
	
	$totalglobal=0;
	$totalhorasG=0;
	$totalminutosG=0;
	$totalminutosparcial=0;
	
	
	do
	{
	   $fechaasistencia=$row_JRFechas['fecha'];
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRReporteAsistencia = "SELECT i.codUsuario, u.nombreUsu, u.apellidos, a.nomAsignatura, i.fecha, i.horaingreso, i.horasalida FROM ingreso_salida i inner join usuarios u on (i.codUsuario=u.codUsuario) inner join asignatura a on (a.codAsignatura=i.codAsignatura) inner join pcs p on(i.computador=p.Nopc) WHERE  p.estado <> 'Docente' and i.codAsignatura = '$asignatura' and i.codGrupo=$grupo and i.fecha between '$fechaasistencia' and '$fechaasistencia' order by u.nombreUsu ";
	mysql_query("SET NAMES 'utf8'");
	$JRReporteAsistencia = mysql_query($query_JRReporteAsistencia, $conexion) or die(mysql_error());
	$row_JRReporteAsistencia = mysql_fetch_assoc($JRReporteAsistencia);
	$totalRows_JRReporteAsistencia = mysql_num_rows($JRReporteAsistencia);
	
	// Consulta que trae los tiempos del docente de la asignatura en una fecha especifica
	mysql_select_db($database_conexion, $conexion);
   $query_JRTiempoDocente = "SELECT distinct i.codUsuario, i.estamento, i.codAsignatura, u.nombreUsu, u.apellidos, i.fecha, i.horaingreso, i.horasalida FROM ingreso_salida i inner join usuarios u on(i.codUsuario=u.codUsuario) inner join pcs p on(i.computador=p.Nopc) WHERE p.estado='Docente' and fecha between '$fechaasistencia' and '$fechaasistencia' and i.codAsignatura='$asignatura' and i.codGrupo=$grupo ";
   $JRTiempoDocente = mysql_query($query_JRTiempoDocente, $conexion) or die(mysql_error());
   $row_JRTiempoDocente = mysql_fetch_assoc($JRTiempoDocente);
   $totalRows_JRTiempoDocente = mysql_num_rows($JRTiempoDocente);?>
   
   
      <tr>
        <td colspan="7" <?php echo $styletrestudiante;?>>DOCENTE(S)</td>
      </tr> 
      
      <tr>
        
		<th <?php echo $styleth;?>>Codigo</th>
        <th colspan="2" <?php echo $styleth;?>>Nombre</th>
		<th <?php echo $styleth;?>>Fecha de Ingreso</th>
		<th <?php echo $styleth;?>>Hora de Ingreso</th>
		<th <?php echo $styleth;?>>Hora de Salida</th>
        <th <?php echo $styleth;?>>Total Tiempo</th>
	  </tr> 
   
	  <?php 
	   do
	   {
		 //Reinicio a 0 los valores para calcular el tiempo
		  $totaldocente=0;
		  $totaltiempodocente=0;
		  $totalhorasdocente=0;
		  $totalminutosdocente=0;
		  $totalhorasminutosdocente=0;
		  
		   if($totalRows_JRTiempoDocente){
			  // Se calcula el tiempo para el docente en una fecha determinada
			  $hora1docente=$row_JRTiempoDocente['horaingreso'];
			  $hora2docente=$row_JRTiempoDocente['horasalida'];
			  $totaldocente=calcular_tiempo_trasnc($hora1docente,$hora2docente);
			  $totaltiempodocente+=$totaldocente;
			  $totalhorasdocente=(int)($totaltiempodocente/60);
			  $totalminutosdocente=$totaltiempodocente%60;
			  $totalhorasminutosdocente= $totalhorasdocente.":".$totalminutosdocente;
		   }
		   
	   }while(mysql_fetch_assoc($JRTiempoDocente));
	   
	   if($totalminutosdocente<=9 && $totalhorasdocente<=9)
		 {
		   $totalhorasminutosdocente= "0".$totalhorasdocente.":"."0".$totalminutosdocente;
		   
		 }
		else if($totalminutosdocente<=9 && $totalhorasdocente >9 )
		{
		   $totalhorasminutosdocente= $totalhorasdocente.":"."0".$totalminutosdocente;
		   
		}
		else if($totalminutosdocente==0 && $totalhorasdocente <=9 )
		{
		  $totalhorasminutosdocente= "0". $totalhorasdocente.":"."0".$totalminutosdocente; 
		 
		}
		else if($totalminutosdocente>0 && $totalhorasdocente >9 )
		{
		  $totalhorasminutosdocente= $totalhorasdocente.":".$totalminutosdocente;
		  
	    }
		else if($totalminutosdocente > 0 && $totalhorasdocente<=9 )
		{
		  $totalhorasminutosdocente= "0".$totalhorasdocente.":".$totalminutosdocente;
		 
		}
		  	  
		?>
        
         <?php if($totalRows_JRTiempoDocente){?>	
	    <tr>        
		  <td <?php echo $styletr; ?>><?php echo $row_JRTiempoDocente['codUsuario']; ?></td>
          <td colspan="2" <?php echo $styletr; ?>><?php echo $row_JRTiempoDocente['nombreUsu']." ".$row_JRTiempoDocente['apellidos']; ?></td>
		  <td <?php echo $styletr; ?>><?php echo $row_JRTiempoDocente['fecha']; ?></td>
		  <?php $horaIniciald= $row_JRTiempoDocente['horaingreso']; $horaFinald=$row_JRTiempoDocente['horasalida'] ?>
		  <td <?php echo $styletr; ?>><?php echo $hora= formatearHora($horaIniciald);  ?></td>
		  <td <?php echo $styletr; ?>><?php echo $hora= formatearHora($horaFinald);  ?></td>
          <td <?php echo $styletr; ?>><?php echo $totalhorasminutosdocente;  ?></td>
		</tr>
	   <?php }?>
	     
		<?php mysql_free_result($JRTiempoDocente);	?>
	
	<?php 
	  $total1=0;
      $totaltiempoasignatura=0;
	  $totalhorasdictadas=0;
	  $totalminutosdictados=0;
	  $totalhorasminutosdictados=0;	
	?>
    
     <?php $i=1; ?>
       
     <tr>
        <td colspan="7" <?php echo $styletrestudiante;?>>ESTUDIANTES</td>
      </tr> 
      
      <tr>
        <th <?php echo $styleth;?>>No</th>
		<th <?php echo $styleth;?>>Codigo</th>
        <th <?php echo $styleth;?>>Nombre</th>
		<th <?php echo $styleth;?>>Fecha de Ingreso</th>
		<th <?php echo $styleth;?>>Hora de Ingreso</th>
		<th <?php echo $styleth;?>>Hora de Salida</th>
        <th <?php echo $styleth;?>>Total Tiempo</th>
	  </tr> 
      
      <?php do
      {
		  
		  //Reinicio a 0 los valores para calcular el tiempo
		  $total=0;
		  $totaltiempo=0;
		  $totalhoras=0;
		  $totalminutos=0;
		  $totalhorasminutos=0;
		  
		  if($totalRows_JRReporteAsistencia){ 
			  // Se calcula el tiempo para un usuario en una fecha determinada
			  $hora1=$row_JRReporteAsistencia['horaingreso'];
			  $hora2=$row_JRReporteAsistencia['horasalida'];
			  $total=calcular_tiempo_trasnc($hora1,$hora2);
			  $totaltiempo+=$total;
			  $totalhoras=(int)($totaltiempo/60);
			  $totalminutos=$totaltiempo%60;
			  $totalhorasminutos= $totalhoras.":".$totalminutos;
		  }
		  
		   if($totalRows_JRReporteAsistencia){ 
			  // Se calcula el tiempo total que se dicto la signatura en una fecha especifica
			  $total1=calcular_tiempo_trasnc($hora1,$hora2);
			  $totaltiempoasignatura+=$total1;
			  $totalhorasdictadas=(int)($totaltiempoasignatura/60);
			  $totalminutosdictados= $totaltiempoasignatura%60;
			  $totalhorasminutosdictados= $totalhorasdictadas.":".$totalminutosdictados;
		   }
		  
		  if($totalminutos<=9 && $totalhoras<=9)
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
        
         <?php if($totalRows_JRReporteAsistencia){ ?>	
	    <tr>
          <td <?php echo $styletr; ?>><?php echo $i;?></td>
		  <td <?php echo $styletr; ?>><?php echo $row_JRReporteAsistencia['codUsuario']; ?></td>
          <td <?php echo $styletr; ?>><?php echo $row_JRReporteAsistencia['nombreUsu']." ".$row_JRReporteAsistencia['apellidos']; ?></td>
		  <td <?php echo $styletr; ?>><?php echo $row_JRReporteAsistencia['fecha']; ?></td>
		  <?php $horaInicial= $row_JRReporteAsistencia['horaingreso']; $horaFinal=$row_JRReporteAsistencia['horasalida'] ?>
		  <td <?php echo $styletr; ?>><?php echo $hora= formatearHora($horaInicial);  ?></td>
		  <td <?php echo $styletr; ?>><?php echo $hora= formatearHora($horaFinal);  ?></td>
          <td <?php echo $styletr; ?>><?php echo $totalhorasminutos;  ?></td>
		</tr>
        <?php }?>
        <?php $i++ ?>
	  <?php } while ($row_JRReporteAsistencia = mysql_fetch_assoc($JRReporteAsistencia));?>
      
       <?php mysql_free_result($JRReporteAsistencia);?>
      
      <?php 
	  
	    if($totalminutosdictados<=9 && $totalhorasdictadas<=9)
		{
		   $totalhorasminutosdictados=  "0".$totalhorasdictadas.":"."0".$totalminutosdictados;
		}
		else if($totalminutosdictados <=9 && $totalhorasdictadas >9)
		{
		   $totalhorasminutosdictados= $totalhorasdictadas.":"."0".$totalminutosdictados;
		}
		else if($totalminutosdictados ==0 && $totalhorasdictadas <=9)
		{
		  $totalhorasminutosdictados=  "0". $totalhorasdictadas.":"."0".$totalminutosdictados; 
		}
		else if($totalminutosdictados > 0 && $totalhorasdictadas > 9)
		{
		  $totalhorasminutosdictados= $totalhorasdictadas.":".$totalminutosdictados;
	    }
		else if($totalminutosdictados > 0 && $totalhorasdictadas <=9)
		{
		  $totalhorasminutosdictados=  "0".$totalhorasdictadas.":".$totalminutosdictados;
		}
		
	?>
                  
	    <tr>
         <?php 
		 
		 $totalglobal=explode(':',$totalhorasminutosdictados);
		 $totalhorasG+=$totalglobal[0];
		 $totalminutosG+= $totalglobal[1];
		 $totalhorasparcial=(int)($totalminutosG/60);
		 $totalhorasglobales=$totalhorasG+$totalhorasparcial;
		 $totalminutosparcial= $totalminutosG%60;
		 $totalhorasminutosglobal=$totalhorasglobales.":".$totalminutosparcial;
		 
		 if($totalminutosparcial<=9 && $totalhorasglobales<=9)
		{
		   $totalhorasminutosglobal=  "0".$totalhorasglobales.":"."0".$totalminutosparcial;
		}
		else if($totalminutosparcial <=9 && $totalhorasglobales >9)
		{
		   $totalhorasminutosglobal= $totalhorasglobales.":"."0".$totalminutosparcial;
		}
		else if($totalminutosparcial ==0 && $totalhorasglobales <=9)
		{
		  $totalhorasminutosglobal=  "0". $totalhorasglobales.":"."0".$totalminutosparcial; 
		}
		else if($totalminutosparcial > 0 && $totalhorasglobales > 9)
		{
		  $totalhorasminutosglobal= $totalhorasglobales.":".$totalminutosparcial;
	    }
		else if($totalminutosparcial > 0 && $totalhorasglobales <=9)
		{
		  $totalhorasminutosglobal=  "0".$totalhorasglobales.":".$totalminutosparcial;
		}
		 
		 ?>
         <td <?php echo $stylecabecera; ?> colspan="3"><center>Numero de estudiantes:  <?php echo $totalRows_JRReporteAsistencia; ?></center></td>
		 <td <?php echo $stylecabecera; ?> colspan="4"><center>Numero de horas:  <?php echo $totalhorasminutosdictados; ?></center>  </td>
        
       </tr>
	
	
	<?php } while ($row_JRFechas = mysql_fetch_assoc($JRFechas)); ?>
      
      <tr>
		 <td <?php echo $stylecabecera; ?> colspan="7"><center>Total horas dictadas asignatura:  <?php echo $totalhorasminutosglobal; ?></center>  </td>
       </tr>
      
        <tr>
             <td colspan="7" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
            </tr>
        
	</table>
    
     <?php } 
	else
	{
	   echo '<script type="text/javascript">alertas("La Consulta no arrojo resultados", "Reporte Asistencia Usuarios","error")</script>'; 		
	}
?>
     
    </body>
    
      <div id="alertas"></div>
      
      <?php	
      mysql_free_result($JRFechas);
	  mysql_close($conexion);
	  
     }// cierro isset
	?>
	
	</html>
	
