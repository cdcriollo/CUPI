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

	$sala= $_POST['sala'];
	$dia= $_POST['dia'];
	$horaIni=$_POST['horaI'];
	$horaFin=$_POST['horaF'];
	$arraydias=$_POST['arraydias'];
	$fechainicial=implode('-',array_reverse(explode('-',$_POST['fechainicial'])));
	$fechafinal=implode('-',array_reverse(explode('-',$_POST['fechafinal'])));
	$styleth="";
	$styletr="";
	$primerpc="";
	$ultimopc="";

if($horaIni!="Null" && $horaFin!="Null")
{
	 $horainicial[1]=explode(':',$horaIni);
     $horaend[2]=explode(':',$horaFin);
	 
	 if($horainicial[1][0] <=9)
	 {
		$horainicial= "0".$horainicial[1][0].":".$horainicial[1][1]."00"; 
		 
	 }
	 else 
	 {
		$horainicial=$horaIni; 
	 }
	 
	  if($horaend[2][0] <=9)
	 {
		$horaend= "0".$horaend[2][0].":".$horaend[2][1]."00";  
	 }
	 else 
	 {
	  $horaend=$horaFin;
	 }
		 
}


function nombreasignatura($asignatura,$database_conexion, $conexion)
{
    mysql_select_db($database_conexion, $conexion);
	$query_JRNomasignatura = "SELECT nomAsignatura FROM asignatura WHERE codAsignatura = '$asignatura'";
	mysql_query("SET NAMES 'utf8'");
	$JRNomasignatura = mysql_query($query_JRNomasignatura, $conexion) or die(mysql_error());
	$row_JRNomasignatura = mysql_fetch_assoc($JRNomasignatura);
	$totalRows_JRNomasignatura = mysql_num_rows($JRNomasignatura); 
	
	$nombreasignatura=$row_JRNomasignatura['nomAsignatura'];
	
	return $nombreasignatura; 
	
	mysql_free_result($JRNomasignatura);	
	
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

?> 

<body>

<?php
if($dia!="Null" && $horaIni=="Null" && $horaFin=="Null")
{
 

mysql_select_db($database_conexion, $conexion);
$query_JRHorarios = "SELECT h.codGrupo, h.codAsignatura, h.codDia, h.horainicio, h.horafinal, h.sala, s.numpripc, s.numultpc, s.Plataforma FROM horario h inner join sala s on(h.sala=s.numsala) WHERE codDia=$dia and sala=$sala and fechaInicio>='$fechainicial' and fechaFinal<='$fechafinal' and h.estadohorario='activo' order by horainicio";
mysql_query("SET NAMES 'utf8'");
$JRHorarios = mysql_query($query_JRHorarios, $conexion) or die(mysql_error());
$row_JRHorarios = mysql_fetch_assoc($JRHorarios);
$totalRows_JRHorarios = mysql_num_rows($JRHorarios);

 $primerpc= $row_JRHorarios['numpripc'];
 $ultimopc= $row_JRHorarios['numultpc'];
 $Noestudiantes= $ultimopc-$primerpc;
 $plataforma= $row_JRHorarios['Plataforma'];
 
   if ($totalRows_JRHorarios  > 0) {  ?>
 

   <table class="informehorarios" id="informehorarios" cellspacing="0"  cellpadding="0" width="600" >
         
    <tr>
    
     <td  align="center" <?php echo $styleImagen; ?> ><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
     <td  colspan="4" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
</p></center><center><p><?php echo "SALA"." ".$sala; ?></p></center><center><p><?php echo "Plataforma:"." ".$plataforma." "."/"." "."Capacidad:"." ".$Noestudiantes." "."Estudiantes"." "."+"." "."Profesor"; ?></p></center></td>
     
   </tr>
   
   <tr>
     <td <?php echo $stylecabeceratitulo; ?> colspan="5"><?php echo "FICHAS"." "."DEL"." ".$primerpc." "."AL"." ".$ultimopc; ?></td>
   </tr>  
   
 
  <tr>
       
       <th <?php echo $styleth;?>>DIA</th>
       <th <?php echo $styleth;?>>CODIGO</th>
       <th <?php echo $styleth;?>>GRUPO</th>
       <th <?php echo $styleth;?>>ASIGNATURA </th>
       <th <?php echo $styleth;?>>HORA</th>
             
  </tr>
  
  
    
    
     <?php do { ?>
     
    
  
    <tr>
       
         <?php  
		 
			 $dia= $row_JRHorarios['codDia'];
			 $asignatura= $row_JRHorarios['codAsignatura'];
			 $grupo= $row_JRHorarios['codGrupo'];
			 $horainicio= $row_JRHorarios['horainicio'];
             $horafinal= $row_JRHorarios['horafinal'];
			 $separar[1]=explode(':',$horainicio);
             $separar[2]=explode(':',$horafinal);
			 $horareducidainicio = $separar[1][0].":". $separar[1][1];
			 $horareducidafinal =  $separar[2][0].":". $separar[2][1];
			 
		 ?>
        
        
        <td <?php echo $styletr; ?>><?php echo $descripciondia= descripcionDia($dia);?> </td>
        <td <?php echo $styletr; ?>><?php echo $asignatura;?></td>
        <td <?php echo $styletr; ?>><?php echo "0".$grupo;?> </td>
        <td <?php echo $styletr; ?>><?php echo $nomA=nombreasignatura($asignatura ,$database_conexion, $conexion);?> </td>
        <td <?php echo $styletr; ?>><?php echo $horareducidainicio."-".$horareducidafinal;?> </td>
    </tr>
      
  <?php } while ($row_JRHorarios = mysql_fetch_assoc($JRHorarios)); ?> 
  
  <?php  mysql_free_result($JRHorarios); ?>
      
    <tr>
             <td colspan="5" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
            </tr>
      
</table>


<?php }
 else 
     echo '<script type="text/javascript"> alertas("La consulta no arrojo resultados","Informe Horarios","error"); </script>';
?>

<?php } 



 else if($dia=="Null" && $arraydias=="LaV" && $horaIni=="Null" && $horaFin=="Null" ){
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRHorarioslav = "SELECT h.codGrupo, h.codAsignatura, h.codDia, h.horainicio, h.horafinal, h.sala, s.numpripc, s.numultpc, s.Plataforma  FROM horario h inner join sala s on(h.sala=s.numsala) WHERE sala=$sala and codDia between 1 and 5 and fechaInicio>='$fechainicial' and fechaFinal<='$fechafinal' and h.estadohorario='activo' ORDER BY codDia,horainicio asc ";
	mysql_query("SET NAMES 'utf8'");
	$JRHorarioslav = mysql_query($query_JRHorarioslav, $conexion) or die(mysql_error());
	$row_JRHorarioslav = mysql_fetch_assoc($JRHorarioslav);
	$totalRows_JRHorarioslav = mysql_num_rows($JRHorarioslav);

  $primerpc= $row_JRHorarioslav['numpripc'];
  $ultimopc= $row_JRHorarioslav['numultpc'];
  $Noestudiantes= $ultimopc-$primerpc;
  $plataforma= $row_JRHorarioslav['Plataforma'];
 
   if ($totalRows_JRHorarioslav  > 0) {  ?>
   
 
   <table border="1" class="informehorarios" id="informehorarios" cellspacing="0"  cellpadding="0" width="600" >
         
    <tr>
    
     <td  align="center" <?php echo $styleImagen; ?> ><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
     <td  colspan="4" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
</p></center><center><p><?php echo "SALA"." ".$sala; ?></p></center><center><p><?php echo "Plataforma:"." ".$plataforma." "."/"." "."Capacidad:"." ".$Noestudiantes." "."Estudiantes"." "."+"." "."Profesor"; ?></p></center></td>
     
   </tr>
   
   <tr>
     <td colspan="5" <?php echo $stylecabeceratitulo; ?>><?php echo "FICHAS"." "."DEL"." ".$primerpc." "."AL"." ".$ultimopc; ?></td>
   </tr>  
   
 
  <tr>
       
      
       <th <?php echo $styleth;?>>DIA</th>
       <th <?php echo $styleth;?>>CODIGO</th>
       <th <?php echo $styleth;?>>GRUPO</th>
       <th <?php echo $styleth;?>>ASIGNATURA </th>
       <th <?php echo $styleth;?>>HORA</th>
         
  </tr>
  
   
        
     
       <?php do { ?>
       
    <tr>
    
         <?php  
		 
			 $dia= $row_JRHorarioslav['codDia'];
			 $asignatura= $row_JRHorarioslav['codAsignatura'];
			 $grupo= $row_JRHorarioslav['codGrupo'];
			 $horainicio= $row_JRHorarioslav['horainicio'];
             $horafinal= $row_JRHorarioslav['horafinal'];
			 $separar[1]=explode(':',$horainicio);
             $separar[2]=explode(':',$horafinal);
			 $horareducidainicio = $separar[1][0].":". $separar[1][1];
			 $horareducidafinal =  $separar[2][0].":". $separar[2][1];
			 
		 ?>
         
         
        <td <?php echo $styletr; ?>><?php echo $descripciondia= descripcionDia($dia);?> </td>
        <td <?php echo $styletr; ?>><?php echo $asignatura;?></td>
        <td <?php echo $styletr; ?>><?php echo "0".$grupo;?> </td>
        <td <?php echo $styletr; ?>><?php echo $nomA=nombreasignatura($asignatura ,$database_conexion, $conexion);?> </td>
        <td <?php echo $styletr; ?>><?php echo $horareducidainicio."-".$horareducidafinal;?> </td>
      
        
    </tr>
   <?php } while ($row_JRHorarioslav = mysql_fetch_assoc($JRHorarioslav)); ?> 
    <?php  mysql_free_result($JRHorarioslav); ?>
   
     <tr>
             <td colspan="5" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
            </tr>  
     
</table>


<?php }
 else 
     echo '<script type="text/javascript"> alertas("La consulta no arrojo resultados","Informe Horarios","error"); </script>';
?>
	
<?php } 


 else if($dia=="Null" && $arraydias=="LaS" && $horaIni=="Null" && $horaFin=="Null" ){
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRHorarioslas = "SELECT h.codGrupo, h.codAsignatura, h.codDia, h.horainicio, h.horafinal, h.sala, s.numpripc, s.numultpc, s.Plataforma FROM horario h inner join sala s on(h.sala=s.numsala) WHERE sala=$sala and codDia between 1 and 6 and fechaInicio>='$fechainicial' and fechaFinal<='$fechafinal' and h.estadohorario='activo' ORDER BY codDia,horainicio asc ";
	
	mysql_query("SET NAMES 'utf8'");
	$JRHorarioslas = mysql_query($query_JRHorarioslas, $conexion) or die(mysql_error());
	$row_JRHorarioslas = mysql_fetch_assoc($JRHorarioslas);
	$totalRows_JRHorarioslas = mysql_num_rows($JRHorarioslas);

  $primerpc= $row_JRHorarioslas['numpripc'];
  $ultimopc= $row_JRHorarioslas['numultpc'];
  $Noestudiantes= $ultimopc-$primerpc;
  $plataforma= $row_JRHorarioslas['Plataforma'];
 
   if ($totalRows_JRHorarioslas  > 0) {  ?>
 
 
  <table border="1" class="informehorarios" id="informehorarios" cellspacing="0"  cellpadding="0" width="600" >
         
    <tr>
    
     <td  align="center" <?php echo $styleImagen; ?> ><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
     <td  colspan="4" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
</p></center><center><p><?php echo "SALA"." ".$sala; ?></p></center><center><p><?php echo "Plataforma:"." ".$plataforma." "."/"." "."Capacidad:"." ".$Noestudiantes." "."Estudiantes"." "."+"." "."Profesor"; ?></p></center></td>
     
   </tr>
   
   <tr>
     <td  colspan="5" <?php echo $stylecabeceratitulo; ?>><?php echo "FICHAS"." "."DEL"." ".$primerpc." "."AL"." ".$ultimopc; ?></td>
   </tr>  
   
 
  <tr>
       
      
        <th <?php echo $styleth;?>>DIA</th>
       <th <?php echo $styleth;?>>CODIGO</th>
       <th <?php echo $styleth;?>>GRUPO</th>
       <th <?php echo $styleth;?>>ASIGNATURA </th>
       <th <?php echo $styleth;?>>HORA</th>
         
  </tr>
  
    
    
     <?php do { ?>
     
    
      
    <tr>
       
         <?php  
		 
			 $dia= $row_JRHorarioslas['codDia'];
			 $asignatura= $row_JRHorarioslas['codAsignatura'];
			 $grupo= $row_JRHorarioslas['codGrupo'];
			 $horainicio= $row_JRHorarioslas['horainicio'];
             $horafinal= $row_JRHorarioslas['horafinal'];
			 $separar[1]=explode(':',$horainicio);
             $separar[2]=explode(':',$horafinal);
			 $horareducidainicio = $separar[1][0].":". $separar[1][1];
			 $horareducidafinal =  $separar[2][0].":". $separar[2][1];
			 
		 ?>
         
        <td <?php echo $styletr; ?>><?php echo $descripciondia= descripcionDia($dia);?> </td>
        <td <?php echo $styletr; ?>><?php echo $asignatura;?></td>
        <td <?php echo $styletr; ?>><?php echo "0".$grupo;?> </td>
        <td <?php echo $styletr; ?>><?php echo $nomA=nombreasignatura($asignatura ,$database_conexion, $conexion);?> </td>
        <td <?php echo $styletr; ?>><?php echo $horareducidainicio."-".$horareducidafinal;?> </td>
        
    </tr>
      
  <?php } while ($row_JRHorarioslas = mysql_fetch_assoc($JRHorarioslas)); ?> 
  <?php  mysql_free_result($JRHorarioslas); ?>
  
        <tr>
             <td colspan="5" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
     </tr>
      
      
</table>


<?php }
 else 
     echo '<script type="text/javascript"> alertas("La consulta no arrojo resultados","Informe Horarios","error"); </script>';
?>
	
<?php } 



else if($dia!="Null" && $horaIni!="Null" && $horaFin!="Null")

{
	mysql_select_db($database_conexion, $conexion);
   $query_JRHorariosHoras = "SELECT h.codGrupo, h.codAsignatura, h.codDia, h.horainicio, h.horafinal, h.sala, s.numpripc, s.numultpc, s.Plataforma FROM horario h inner join sala s on(h.sala=s.numsala) WHERE codDia=$dia and sala=$sala and horainicio>='$horainicial' and horafinal<='$horaend' and fechaInicio>='$fechainicial' and fechaFinal<='$fechafinal' and h.estadohorario='activo' order by horainicio";
   mysql_query("SET NAMES 'utf8'");
  $JRHorariosHoras = mysql_query($query_JRHorariosHoras, $conexion) or die(mysql_error());
  $row_JRHorariosHoras = mysql_fetch_assoc($JRHorariosHoras);
  $totalRows_JRHorariosHoras = mysql_num_rows($JRHorariosHoras);

 $primerpcHoras= $row_JRHorariosHoras['numpripc'];
 $ultimopcHoras= $row_JRHorariosHoras['numultpc'];
 $NoestudiantesHoras= $ultimopcHoras-$primerpcHoras;
 $plataformaHoras= $row_JRHorariosHoras['Plataforma'];
 
   if ($totalRows_JRHorariosHoras  > 0) {  ?>

 
  <table border="1" class="informehorarios" id="informehorarios" cellspacing="0"  cellpadding="0" width="600" >
         
    <tr>
    
     <td  align="center" <?php echo $styleImagen; ?> ><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
     <td  colspan="4" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
</p></center><center><p><?php echo "SALA"." ".$sala; ?></p></center><center><p><?php echo "Plataforma:"." ".$plataformaHoras." "."/"." "."Capacidad:"." ".$NoestudiantesHoras." "."Estudiantes"." "."+"." "."Profesor"; ?></p></center></td>
     
   </tr>
   
   <tr>
     <td colspan="5" <?php  echo $stylecabeceratitulo; ?>><?php echo "FICHAS"." "."DEL"." ".$primerpcHoras." "."AL"." ".$ultimopcHoras; ?></td>
   </tr>  
   
 
  <tr>
       
       <th <?php echo $styleth;?>>DIA</th>
       <th <?php echo $styleth;?>>CODIGO</th>
       <th <?php echo $styleth;?>>GRUPO</th>
       <th <?php echo $styleth;?>>ASIGNATURA </th>
       <th <?php echo $styleth;?>>HORA</th>
       
         
  </tr>
  
  
    
    
     <?php do { ?>
     
    
  
    <tr>
       
         <?php  
		 
			 $diaHoras= $row_JRHorariosHoras['codDia'];
			 $asignaturaHoras= $row_JRHorariosHoras['codAsignatura'];
			 $grupoHoras= $row_JRHorariosHoras['codGrupo'];
			 $horainicioHoras= $row_JRHorariosHoras['horainicio'];
             $horafinalHoras= $row_JRHorariosHoras['horafinal'];
			 $separar[1]=explode(':',$horainicioHoras);
             $separar[2]=explode(':',$horafinalHoras);
			 $horareducidainicioHoras = $separar[1][0].":". $separar[1][1];
			 $horareducidafinalHoras =  $separar[2][0].":". $separar[2][1];
			 
		 ?>
        
        
        <td <?php echo $styletr; ?>><?php echo $descripciondia= descripcionDia($diaHoras);?> </td>
        <td <?php echo $styletr; ?>><?php echo $asignaturaHoras;?></td>
        <td <?php echo $styletr; ?>><?php echo "0".$grupoHoras;?> </td>
        <td <?php echo $styletr; ?>><?php echo $nomA=nombreasignatura($asignaturaHoras ,$database_conexion, $conexion);?> </td>
        <td <?php echo $styletr; ?>><?php echo $horareducidainicioHoras."-".$horareducidafinalHoras;?> </td>
    </tr>
      
  <?php } while ($row_JRHorariosHoras = mysql_fetch_assoc($JRHorariosHoras)); ?> 
  
   <?php  mysql_free_result($JRHorariosHoras); ?>
      
        <tr>
             <td colspan="5" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
      </tr>
       
</table>


<?php }

 else {
     echo '<script type="text/javascript"> alertas("La consulta no arrojo resultados","Informe Horarios","error"); </script>';
?>

<?php } 

}

else if($dia=="Null" && $horaIni!="Null" && $horaFin!="Null" && $arraydias=="LaV")
{
	
	 
	 mysql_select_db($database_conexion, $conexion);
   $query_JRHorariosHoraslav = "SELECT h.codGrupo, h.codAsignatura, h.codDia, h.horainicio, h.horafinal, h.sala, s.numpripc, s.numultpc, s.Plataforma FROM horario h inner join sala s on(h.sala=s.numsala) WHERE codDia between 1 and 5 and sala=$sala and horainicio>='$horainicial' and horafinal<='$horaend' and fechaInicio>='$fechainicial' and fechaFinal<='$fechafinal' and h.estadohorario='activo' order by codDia,horainicio asc";
   mysql_query("SET NAMES 'utf8'");
  $JRHorariosHoraslav = mysql_query($query_JRHorariosHoraslav, $conexion) or die(mysql_error());
  $row_JRHorariosHoraslav = mysql_fetch_assoc($JRHorariosHoraslav);
  $totalRows_JRHorariosHoraslav = mysql_num_rows($JRHorariosHoraslav);

 $primerpcHoraslav= $row_JRHorariosHoraslav['numpripc'];
 $ultimopcHoraslav= $row_JRHorariosHoraslav['numultpc'];
 $NoestudiantesHoraslav= $ultimopcHoraslav-$primerpcHoraslav;
 $plataformaHoraslav= $row_JRHorariosHoraslav['Plataforma'];
 
   if ($totalRows_JRHorariosHoraslav  > 0) {  ?>
 

   <table border="1" class="informehorarios" id="informehorarios" cellspacing="0"  cellpadding="0" width="600" >
         
    <tr>
    
     <td  align="center" <?php echo $styleImagen; ?> ><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
     <td  colspan="4" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
</p></center><center><p><?php echo "SALA"." ".$sala; ?></p></center><center><p><?php echo "Plataforma:"." ".$plataformaHoraslav." "."/"." "."Capacidad:"." ".$NoestudiantesHoraslav." "."Estudiantes"." "."+"." "."Profesor"; ?></p></center></td>
     
   </tr>
   
   <tr>
     <td  colspan="5" <?php echo $stylecabeceratitulo; ?>><?php echo "FICHAS"." "."DEL"." ".$primerpcHoraslav." "."AL"." ".$ultimopcHoraslav; ?></td>
   </tr>  
   
 
  <tr>
       
       <th <?php echo $styleth;?>>DIA</th>
       <th <?php echo $styleth;?>>CODIGO</th>
       <th <?php echo $styleth;?>>GRUPO</th>
       <th <?php echo $styleth;?>>ASIGNATURA </th>
       <th <?php echo $styleth;?>>HORA</th>
       
         
  </tr>
  
  
    
    
     <?php do { ?>
     
    
  
    <tr>
       
         <?php  
		 
			 $diaHoraslav= $row_JRHorariosHoraslav['codDia'];
			 $asignaturaHoraslav= $row_JRHorariosHoraslav['codAsignatura'];
			 $grupoHoraslav= $row_JRHorariosHoraslav['codGrupo'];
			 $horainicioHoraslav= $row_JRHorariosHoraslav['horainicio'];
             $horafinalHoraslav= $row_JRHorariosHoraslav['horafinal'];
			 $separar[1]=explode(':',$horainicioHoraslav);
             $separar[2]=explode(':',$horafinalHoraslav);
			 $horareducidainicioHoraslav = $separar[1][0].":". $separar[1][1];
			 $horareducidafinalHoraslav =  $separar[2][0].":". $separar[2][1];
			 
		 ?>
        
        
        <td <?php echo $styletr; ?>><?php echo $descripciondia= descripcionDia($diaHoraslav);?> </td>
        <td <?php echo $styletr; ?>><?php echo $asignaturaHoraslav;?></td>
        <td <?php echo $styletr; ?>><?php echo "0".$grupoHoraslav;?> </td>
        <td <?php echo $styletr; ?>><?php echo $nomA=nombreasignatura($asignaturaHoraslav ,$database_conexion, $conexion);?> </td>
        <td <?php echo $styletr; ?>><?php echo $horareducidainicioHoraslav."-".$horareducidafinalHoraslav;?> </td>
    </tr>
      
  <?php } while ($row_JRHorariosHoraslav = mysql_fetch_assoc($JRHorariosHoraslav)); ?> 
  
  <?php  mysql_free_result($JRHorariosHoraslav); ?>
      
       <tr>
             <td colspan="5" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
       </tr>
       
</table>


<?php }

 else {
     echo '<script type="text/javascript"> alertas("La consulta no arrojo resultados","Informe Horarios","error"); </script>';
?>

<?php } 

}

else if($dia=="Null" && $horaIni!="Null" && $horaFin!="Null" && $arraydias=="LaS")
{
	
	
	mysql_select_db($database_conexion, $conexion);
   $query_JRHorariosHoraslas = "SELECT h.codGrupo, h.codAsignatura, h.codDia, h.horainicio, h.horafinal, h.sala, s.numpripc, s.numultpc, s.Plataforma FROM horario h inner join sala s on(h.sala=s.numsala) WHERE codDia between 1 and 6 and sala=$sala and horainicio>='$horainicial' and horafinal<='$horaend' and fechaInicio>='$fechainicial' and fechaFinal<='$fechafinal' and h.estadohorario='activo' order by codDia,horainicio asc";
   mysql_query("SET NAMES 'utf8'");
  $JRHorariosHoraslas = mysql_query($query_JRHorariosHoraslas, $conexion) or die(mysql_error());
  $row_JRHorariosHoraslas = mysql_fetch_assoc($JRHorariosHoraslas);
  $totalRows_JRHorariosHoraslas = mysql_num_rows($JRHorariosHoraslas);

 $primerpcHoraslas= $row_JRHorariosHoraslas['numpripc'];
 $ultimopcHoraslas= $row_JRHorariosHoraslas['numultpc'];
 $NoestudiantesHoraslas= $ultimopcHoraslas-$primerpcHoraslas;
 $plataformaHoraslas= $row_JRHorariosHoraslas['Plataforma'];
 
   if ($totalRows_JRHorariosHoraslas  > 0) {  ?>
 
 
    <table border="1" class="informehorarios" id="informehorarios" cellspacing="0"  cellpadding="0" width="600" >
         
    <tr>
    
     <td  align="center" <?php echo $styleImagen; ?> ><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
     <td  colspan="4" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
</p></center><center><p><?php echo "SALA"." ".$sala; ?></p></center><center><p><?php echo "Plataforma:"." ".$plataformaHoraslas." "."/"." "."Capacidad:"." ".$NoestudiantesHoraslas." "."Estudiantes"." "."+"." "."Profesor"; ?></p></center></td>
     
   </tr>
   
   <tr>
     <td  colspan="5" <?php echo $stylecabeceratitulo; ?>><?php echo "FICHAS"." "."DEL"." ".$primerpcHoraslas." "."AL"." ".$ultimopcHoraslas; ?></td>
   </tr>  
   
 
  <tr>
       
       <th <?php echo $styleth;?>>DIA</th>
       <th <?php echo $styleth;?>>CODIGO</th>
       <th <?php echo $styleth;?>>GRUPO</th>
       <th <?php echo $styleth;?>>ASIGNATURA </th>
       <th <?php echo $styleth;?>>HORA</th>
       
         
  </tr>
  
     <?php do { ?>
     
    <tr>
       
         <?php  
		 
			 $diaHoraslas= $row_JRHorariosHoraslas['codDia'];
			 $asignaturaHoraslas= $row_JRHorariosHoraslas['codAsignatura'];
			 $grupoHoraslas= $row_JRHorariosHoraslas['codGrupo'];
			 $horainicioHoraslas= $row_JRHorariosHoraslas['horainicio'];
             $horafinalHoraslas= $row_JRHorariosHoraslas['horafinal'];
			 $separar[1]=explode(':',$horainicioHoraslas);
             $separar[2]=explode(':',$horafinalHoraslas);
			 $horareducidainicioHoraslas = $separar[1][0].":". $separar[1][1];
			 $horareducidafinalHoraslas =  $separar[2][0].":". $separar[2][1];
			 
		 ?>
        
        
        <td <?php echo $styletr; ?>><?php echo $descripciondia= descripcionDia($diaHoraslas);?> </td>
        <td <?php echo $styletr; ?>><?php echo $asignaturaHoraslas;?></td>
        <td <?php echo $styletr; ?>><?php echo "0".$grupoHoraslas;?> </td>
        <td <?php echo $styletr; ?>><?php echo $nomA=nombreasignatura($asignaturaHoraslas ,$database_conexion, $conexion);?> </td>
        <td <?php echo $styletr; ?>><?php echo $horareducidainicioHoraslas."-".$horareducidafinalHoraslas;?> </td>
    </tr>
      
  <?php } while ($row_JRHorariosHoraslas = mysql_fetch_assoc($JRHorariosHoraslas)); ?> 
  
  <?php  mysql_free_result($JRHorariosHoraslas); ?>
    
        <tr>
             <td colspan="5" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
        </tr>
      
</table>


<?php }

 else {
     echo '<script type="text/javascript"> alertas("La consulta no arrojo resultados","Informe Horarios","error"); </script>';
?>

<?php } 
}
?>

<?php mysql_close($conexion); ?>

<div id="alertas"></div>

</body>
</html>




 


 

 