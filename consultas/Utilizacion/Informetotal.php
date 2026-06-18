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


$desde= $_POST['desde'];
$hasta= $_POST['hasta'];
$nuevaFechai=implode('-',array_reverse(explode('-',$desde)));
$nuevaFechaf=implode('-',array_reverse(explode('-',$hasta)));
$horaI= $_POST["HoraI"];
$horaF= $_POST["HoraF"];
$styleth="";
$styletr="";
$suma=0;
$totalusuarios=0;
$totalhoras=0;
$totalminutos=0;
$totalhorasminutos=0;
$totalactividad=0;


mysql_select_db($database_conexion, $conexion);
$query_JRSala = "SELECT numSala FROM sala where numSala <> 0 ORDER BY numSala";
$JRSala = mysql_query($query_JRSala, $conexion) or die(mysql_error());
$row_JRSala = mysql_fetch_assoc($JRSala);
$totalRows_JRSala = mysql_num_rows($JRSala);




function calcular_tiempo_trasnc($hora1,$hora2)
 {
	
  
	 $separar[1]=explode(':',$hora1);
	 $separar[2]=explode(':',$hora2);
		
	$total_minutos_trasncurridos[1] = ($separar[1][0]*60) +$separar[1][1];
	$total_minutos_trasncurridos[2] = ($separar[2][0]*60) +$separar[2][1];
	$total_minutos_trasncurridos = $total_minutos_trasncurridos[2]-$total_minutos_trasncurridos[1];
	
	return $total_minutos_trasncurridos;   
		 
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
		
	 
 $stylecabecera='style="
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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consultas Utilizacion</title>

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


<?php 


 if($horaI!="Null" && $horaF!="Null")
 {
	 $horainicial[1]=explode(':',$horaI);
     $horafinal[2]=explode(':',$horaF);
	 
	 if($horainicial[1][0] <=9)
	 {
		$horainicial= "0".$horainicial[1][0].":".$horainicial[1][1]."00"; 	 
	 }
	 else 
	 {
		$horainicial=$horaI; 
	 }
	 
	  if($horafinal[2][0] <=9)
	 {
		$horafinal= "0".$horafinal[2][0].":".$horafinal[2][1]."00"; 
		 
	 }
	 else 
	 {
	   $horafinal=$horaF;
	 }?>
	 
	 
	 <body>
 
	 <table class="Utilizacion" id="Utilizacion" cellspacing="0"  cellpadding="0" width="600" >
         
        <tr>
           <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px;            width:71px" /> </td>
           <td  colspan="6" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
            </p></center><center><p>Universidad del Valle </p></center></td>
        </tr>  
   
      <tr>
       <td colspan="7" <?php echo $stylecabeceratitulo; ?>> <center><p>INFORME TOTAL UTILIZACIÓN </p></center> </td>
      </tr>
         
         
     <tr>
        <th <?php echo $styleth;?>>Desde</th>
        <th <?php echo $styleth;?> colspan="2">Hasta</th>
        <th <?php echo $styleth;?> colspan="2">Hora Inicial</th>
        <th <?php echo $styleth;?> colspan="2">Hora Final</th> 
       </tr> 
       
       <tr>
        <td <?php echo $styletr; ?>><?php echo $desde ?> </td>
        <td <?php echo $styletr; ?> colspan="2"><?php echo $hasta ?> </td>
        <td <?php echo $styletr; ?> colspan="2"><?php echo $horaI ?> </td>
        <td <?php echo $styletr; ?> colspan="2"><?php echo $horaF ?> </td>
       </tr> 
         
     <tr>
       <th <?php echo $styleth; ?>>Actividad </th>
       <th <?php echo $styleth;?> colspan="2">Dependencia </th>
       <th <?php echo $styleth; ?>>Estamento </th>
       <th <?php echo $styleth;?>>Sala </th>
       <th <?php echo $styleth; ?>>Tiempo</th>
       <th<?php echo $styleth; ?>>Usuarios</th> 
     </tr>  
     
	 
	<?php 
		
          // inicializo los valores para el calculo de las horas y los usuarios 
			$suma=0;
			$totalusuarios=0;
			$totalhoras=0;
			$totalminutos=0;
			$totalhorasminutos= 0;
			$totaltiempo=0;
					
			// Hago una consulta a la tabla ingreso_salida
			 mysql_select_db($database_conexion, $conexion);
			 $query_JRCUtilizacion ="SELECT distinct  sala,actividad,dependencia,estamento FROM ingreso_salida WHERE  fecha between '$nuevaFechai' and '$nuevaFechaf' and horaingreso>='$horainicial' and horasalida <='$horafinal' and horasalida <> '00:00:00' order by sala, actividad, dependencia,estamento ";	
			 mysql_query("SET NAMES 'utf8'");
			 $JRCUtilizacion = mysql_query($query_JRCUtilizacion , $conexion) or die(mysql_error());
			 $row_JRCUtilizacion = mysql_fetch_assoc($JRCUtilizacion);
			 $totalrowsutilizacion= mysql_num_rows($JRCUtilizacion);?>
			 
			 
		<?php if( $totalrowsutilizacion > 0) {?>
        	 
		   <?php do{?>	
			  
			  
			  <tr>
			  
			  <td <?php echo $styletr; ?>><?php echo $row_JRCUtilizacion['actividad']; ?></td>
              <td <?php echo $styletr; ?> colspan="2"><?php echo $row_JRCUtilizacion['dependencia']; ?></td>
              <td <?php echo $styletr; ?>><?php echo $row_JRCUtilizacion['estamento']; ?></td>
              <td <?php echo $styletr; ?>><?php echo $row_JRCUtilizacion['sala']; ?></td>
			  
             <?php 
			 
			  $sala= $row_JRCUtilizacion['sala'];
			  $actividad= $row_JRCUtilizacion['actividad'];
			  $dependencia= $row_JRCUtilizacion['dependencia'];
			  $estamento= $row_JRCUtilizacion['estamento'];
			  
			  mysql_select_db($database_conexion, $conexion);
			  $query_JRHorasusuarios = "SELECT sala,actividad,dependencia,estamento,horaingreso, horasalida  FROM ingreso_salida WHERE  fecha between '$nuevaFechai' and '$nuevaFechaf'  and horaingreso>='$horainicial' and horasalida <='$horafinal' and sala=$sala and actividad='$actividad' and dependencia='$dependencia' and estamento='$estamento' and horasalida <> '00:00:00' order by sala, actividad, dependencia,estamento ";
			  $JRHorasusuarios = mysql_query($query_JRHorasusuarios, $conexion) or die(mysql_error());
			  $row_JRHorasusuarios = mysql_fetch_assoc($JRHorasusuarios);
			  $totalRows_JRHorasusuarios = mysql_num_rows($JRHorasusuarios);
			  
			  $totalusuarios=0;
			  $totalhoras=0;
			  $totalminutos=0;
			  $totalhorasminutos= 0;
			  $totaltiempo=0;
			  
			  do{
				  
			    if($totalRows_JRHorasusuarios > 0)
				{
					
				    $hora1=$row_JRHorasusuarios['horaingreso'];
					$hora2=$row_JRHorasusuarios['horasalida'];
					$total=calcular_tiempo_trasnc($hora1,$hora2);
					$totaltiempo+=$total;
					$totalhoras=(int)($totaltiempo/60);
					$totalminutos=$totaltiempo%60;
					$totalhorasminutos= $totalhoras.":".$totalminutos;
					$totalusuarios++;
                    
                  if($totalminutos<=9 && $totalhoras<=9){
				   $totalhorasminutos= "0".$totalhoras.":"."0".$totalminutos;
				  }
				  else if($totalminutos<=9 && $totalhoras >9){
					 $totalhorasminutos= $totalhoras.":"."0".$totalminutos;
				  }
				   else if($totalminutos==0 && $totalhoras <=9){
					 $totalhorasminutos= "0". $totalhoras.":"."0".$totalminutos;  
				   }
				  else if($totalminutos>0 && $totalhoras >9){
					 $totalhorasminutos= $totalhoras.":".$totalminutos;
				  }
				  else if($totalminutos>0 && $totalhoras<=9){
					 $totalhorasminutos= "0".$totalhoras.":".$totalminutos;
				  } 	
				  
			    }
			  } while($row_JRHorasusuarios = mysql_fetch_assoc($JRHorasusuarios))?>
              
              <?php  mysql_free_result($JRHorasusuarios);?>
			  
              <?php if($totalRows_JRHorasusuarios > 0) {?>
			  <td <?php echo $styletr;?> > <?php echo $totalhorasminutos;?> </td>
			  <td <?php echo $styletr; ?>> <?php echo $totalusuarios;?></td>
              <?php }?>
			</tr>
			   
			<?php }while($row_JRCUtilizacion = mysql_fetch_assoc($JRCUtilizacion));?>
      
      <?php if($totalRows_JRHorasusuarios) {?>
          <tr>
             <td colspan="7" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
            </tr>
            <?php }}?>
	   </table>
    </body>	
	 
	 
	 	 
 <?php }

else if($horaI=="Null" && $horaF=="Null")

{ ?>
	
 <body>
 
	 <table class="Utilizacion" id="Utilizacion" cellspacing="0"  cellpadding="0" width="600" >
         
        <tr>
           <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px;            width:71px" /> </td>
           <td  colspan="6" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
            </p></center><center><p>Universidad del Valle </p></center></td>
        </tr>  
   
      <tr>
       <td colspan="7" <?php echo $stylecabeceratitulo; ?>> <center><p>INFORME TOTAL UTILIZACIÓN </p></center> </td>
      </tr>
      
      <?php $horaI=""; $horaF=""?>
       
       <tr>
        <th <?php echo $styleth;?>>Desde</th>
        <th <?php echo $styleth;?> colspan="2">Hasta</th>
        <th <?php echo $styleth;?> colspan="2">Hora Inicial</th>
        <th <?php echo $styleth;?> colspan="2">Hora Final</th> 
       </tr> 
       
       <tr>
        <td <?php echo $styletr; ?>><?php echo $desde ?> </td>
        <td <?php echo $styletr; ?> colspan="2"><?php echo $hasta ?> </td>
        <td <?php echo $styletr; ?> colspan="2"><?php echo $horaI ?> </td>
        <td <?php echo $styletr; ?> colspan="2"><?php echo $horaF ?> </td>
       </tr> 
         
     <tr>
       <th <?php echo $styleth; ?>>Actividad </th>
       <th <?php echo $styleth;?> colspan="2">Dependencia </th>
       <th <?php echo $styleth; ?>>Estamento </th>
       <th <?php echo $styleth;?>>Sala </th>
       <th <?php echo $styleth; ?>>Tiempo</th>
       <th<?php echo $styleth; ?>>Usuarios</th> 
     </tr> 
	 
	<?php 
		
          // inicializo los valores para el calculo de las horas y los usuarios 
			$suma=0;
			$totalusuarios=0;
			$totalhoras=0;
			$totalminutos=0;
			$totalhorasminutos= 0;
			$totaltiempo=0;
					
			// Hago una consulta a la tabla ingreso_salida
			 mysql_select_db($database_conexion, $conexion);
			 $query_JRCUtilizacion ="SELECT distinct  sala,actividad,dependencia,estamento FROM ingreso_salida WHERE  fecha between '$nuevaFechai' and '$nuevaFechaf' and horasalida <> '00:00:00' order by sala, actividad, dependencia,estamento ";	
			 mysql_query("SET NAMES 'utf8'");
			 $JRCUtilizacion = mysql_query($query_JRCUtilizacion , $conexion) or die(mysql_error());
			 $row_JRCUtilizacion = mysql_fetch_assoc($JRCUtilizacion);
			 $totalrowsutilizacion= mysql_num_rows($JRCUtilizacion);?>
			 
		  <?php if($totalrowsutilizacion > 0) {?>	  
			 
		   <?php do{?>	
			  
			  
			  <tr>
			  
			  <td <?php echo $styletr; ?>><?php echo $row_JRCUtilizacion['actividad']; ?></td>
              <td <?php echo $styletr; ?> colspan="2"><?php echo $row_JRCUtilizacion['dependencia']; ?></td>
              <td <?php echo $styletr; ?>><?php echo $row_JRCUtilizacion['estamento']; ?></td>
              <td <?php echo $styletr; ?>><?php echo $row_JRCUtilizacion['sala']; ?></td>
			  
             <?php 
			 
			  $sala= $row_JRCUtilizacion['sala'];
			  $actividad= $row_JRCUtilizacion['actividad'];
			  $dependencia= $row_JRCUtilizacion['dependencia'];
			  $estamento= $row_JRCUtilizacion['estamento'];
			  
			  mysql_select_db($database_conexion, $conexion);
			  $query_JRHorasusuarios = "SELECT sala,actividad,dependencia,estamento,horaingreso, horasalida  FROM ingreso_salida WHERE  fecha between '$nuevaFechai'  and '$nuevaFechaf' and sala=$sala and actividad='$actividad' and dependencia='$dependencia' and estamento='$estamento' and horasalida <> '00:00:00' order by sala, actividad, dependencia,estamento ";
			  $JRHorasusuarios = mysql_query($query_JRHorasusuarios, $conexion) or die(mysql_error());
			  $row_JRHorasusuarios = mysql_fetch_assoc($JRHorasusuarios);
			  $totalRows_JRHorasusuarios = mysql_num_rows($JRHorasusuarios);
			  
			  $totalusuarios=0;
			  $totalhoras=0;
			  $totalminutos=0;
			  $totalhorasminutos= 0;
			  $totaltiempo=0;
			  
			  do{
				  
			    if($totalRows_JRHorasusuarios > 0)
				{
					
				    $hora1=$row_JRHorasusuarios['horaingreso'];
					$hora2=$row_JRHorasusuarios['horasalida'];
					$total=calcular_tiempo_trasnc($hora1,$hora2);
					$totaltiempo+=$total;
					$totalhoras=(int)($totaltiempo/60);
					$totalminutos=$totaltiempo%60;
					$totalhorasminutos= $totalhoras.":".$totalminutos;
					$totalusuarios++;
                    
                  if($totalminutos<=9 && $totalhoras<=9){
				   $totalhorasminutos= "0".$totalhoras.":"."0".$totalminutos;
				  }
				  else if($totalminutos<=9 && $totalhoras >9){
					 $totalhorasminutos= $totalhoras.":"."0".$totalminutos;
				  }
				   else if($totalminutos==0 && $totalhoras <=9){
					 $totalhorasminutos= "0". $totalhoras.":"."0".$totalminutos;  
				   }
				  else if($totalminutos>0 && $totalhoras >9){
					 $totalhorasminutos= $totalhoras.":".$totalminutos;
				  }
				  else if($totalminutos>0 && $totalhoras<=9){
					 $totalhorasminutos= "0".$totalhoras.":".$totalminutos;
				  } 	
				  
			    }
			  } while($row_JRHorasusuarios = mysql_fetch_assoc($JRHorasusuarios))?>
              
              <?php  mysql_free_result($JRHorasusuarios);?>
			    
             <?php if($totalRows_JRHorasusuarios > 0) {?>
			  <td <?php echo $styletr;?> > <?php echo $totalhorasminutos;?> </td>
			  <td <?php echo $styletr; ?>> <?php echo $totalusuarios;?></td>
              <?php }?>
			</tr>
			   
			<?php }while($row_JRCUtilizacion = mysql_fetch_assoc($JRCUtilizacion));?>
			
		<?php if($totalRows_JRHorasusuarios > 0) {?>	
		   <tr>
             <td colspan="7" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
             
         </tr>
        <?php }}?>    
      </table>
     </body>	
	
 
<?php } ?>

  <div id="alertas"></div>
	
  </html>    
       
   <?php
     
     mysql_free_result($JRCUtilizacion);
	 mysql_close($conexion);
	  
  ?>