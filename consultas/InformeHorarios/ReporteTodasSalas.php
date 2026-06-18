<?php require_once('../../Connections/conexion.php');?>
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


$dia= $_POST['dia'];
$horaIni=$_POST['horaI'];
$horaFin=$_POST['horaF'];
$arraydias=$_POST['arraydias'];
$fechainicial=implode('-',array_reverse(explode('-',$_POST['fechainicial'])));
$fechafinal=implode('-',array_reverse(explode('-',$_POST['fechafinal'])));
$styleth="";
$styletr="";

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

 $(function(){

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


});

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

if($dia!="Null" && $horaIni=="Null" && $horaFin=="Null" )
{

?>
<table border="1" class="informehorarios" id="informehorarios" cellspacing="0"  cellpadding="0" width="600">
         
    <tr>
    
     <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
     <td  colspan="4"<?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
      </p></center><center><p>Universidad del Valle</p></center><center><p><?php echo "TODAS LAS SALAS" ?></p></center></td>
   </tr>

<?php
mysql_select_db($database_conexion, $conexion);
$query_JRSalas = "SELECT *  FROM sala where numSala <> 0 ORDER BY numSala";
mysql_query("SET NAMES 'utf8'");
$JRSalas = mysql_query($query_JRSalas, $conexion) or die(mysql_error());
$row_JRSalas = mysql_fetch_assoc($JRSalas);
$totalRows_JRSalas = mysql_num_rows($JRSalas);

if($totalRows_JRSalas>0)
{
	do
	{
		$numSala = $row_JRSalas['numSala'];
		$primerpcsala= $row_JRSalas['numpripc'];
		$ultimopcsala= $row_JRSalas['numultpc'];
		$plataforma= $row_JRSalas['Plataforma']; 
		
		$query_JRHorarios = "SELECT codGrupo, codAsignatura, codDia, horainicio, horafinal, sala FROM horario WHERE codDia=$dia and sala=$numSala and        estadohorario='activo' order by horainicio";
		mysql_query("SET NAMES 'utf8'");
		$JRHorarios = mysql_query($query_JRHorarios, $conexion) or die(mysql_error());
		$row_JRHorarios = mysql_fetch_assoc($JRHorarios);
		$totalRows_JRHorarios = mysql_num_rows($JRHorarios);
		
		if($totalRows_JRHorarios > 0)
		{
			?>
           <tr>
               <td  colspan="5" <?php echo $stylecabeceratitulo; ?>><p>SALA <?php echo $numSala; ?></p> <p><?php echo "FICHAS"." "."DEL"." ".$primerpcsala." "."AL"." ".$ultimopcsala;?> </p> </td>
           </tr>
           <tr>
               <th <?php echo $styleth;?>>DIA</th>
               <th <?php echo $styleth;?>>CODIGO</th>
               <th <?php echo $styleth;?>>GRUPO</th>
               <th <?php echo $styleth;?>>ASIGNATURA </th>
               <th <?php echo $styleth;?>>HORA</th>
           </tr>
            <?php
			do{
				echo "<tr>";
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
                <?php
				echo "</tr>";
				
			}
			while ($row_JRHorarios = mysql_fetch_assoc($JRHorarios));
			mysql_free_result($JRHorarios);
			
		}
		else
		{
			?>
            <tr>
    			<td  colspan="5" <?php echo $styleSinEspacio; ?>><?php echo "SALA $numSala DISPONIBLE" ?></td>
            </tr>  
            <?php
		}?>
			 	
	<?php }
	  while($row_JRSalas = mysql_fetch_assoc($JRSalas));
	  mysql_free_result($JRSalas);
     }?> 
  
         <tr>
             <td colspan="5" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
        </tr>
    
 </table>
 
<?php } else if($dia=="Null" && $arraydias=="LaV" && $horaIni=="Null" && $horaFin=="Null" )
   
   {?>
        <table border="1" class="informehorarios" id="informehorarios" cellspacing="0"  cellpadding="0" width="600">
         
     <tr>
    
     <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
     <td  colspan="4"<?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
      </p></center><center><p>Universidad del Valle</p></center><center><p><?php echo "TODAS LAS SALAS" ?></p></center></td>
   </tr>
<?php
mysql_select_db($database_conexion, $conexion);
$query_JRSalas = "SELECT *  FROM sala where numSala <> 0 ORDER BY numSala";
mysql_query("SET NAMES 'utf8'");
$JRSalas = mysql_query($query_JRSalas, $conexion) or die(mysql_error());
$row_JRSalas = mysql_fetch_assoc($JRSalas);
$totalRows_JRSalas = mysql_num_rows($JRSalas);

if($totalRows_JRSalas>0)
{
	do
	{
		$numSala = $row_JRSalas['numSala'];
		$primerpcsala= $row_JRSalas['numpripc'];
		$ultimopcsala= $row_JRSalas['numultpc'];
		$plataforma= $row_JRSalas['Plataforma']; 
		
		$query_JRHorarios = "SELECT codGrupo, codAsignatura, codDia, horainicio, horafinal, sala FROM horario  WHERE codDia between 1 and 5 and sala=$numSala and fechaInicio>='$fechainicial' and fechaFinal<='$fechafinal' and estadohorario='activo' ORDER BY codDia,horainicio asc";
		mysql_query("SET NAMES 'utf8'");
		$JRHorarios = mysql_query($query_JRHorarios, $conexion) or die(mysql_error());
		$row_JRHorarios = mysql_fetch_assoc($JRHorarios);
		$totalRows_JRHorarios = mysql_num_rows($JRHorarios);
		if($totalRows_JRHorarios > 0)
		{
			?>
           <tr>
               <td  colspan="5" <?php echo $stylecabeceratitulo; ?>><p>SALA <?php echo $numSala; ?></p> <p><?php echo "FICHAS"." "."DEL"." ".$primerpcsala." "."AL"." ".$ultimopcsala;?> </p> </td>
           </tr>
           <tr>
               <th <?php echo $styleth;?>>DIA</th>
               <th <?php echo $styleth;?>>CODIGO</th>
               <th <?php echo $styleth;?>>GRUPO</th>
               <th <?php echo $styleth;?>>ASIGNATURA </th>
               <th <?php echo $styleth;?>>HORA</th>
           </tr>
            <?php
			do{
				echo "<tr>";
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
                <?php
				echo "</tr>";
				
			}
			while ($row_JRHorarios = mysql_fetch_assoc($JRHorarios));
			mysql_free_result($JRHorarios);
			?>
	
		<?php } // cierro if totalrows
		else
		{
			?>
            <tr>
    			<td  colspan="5" <?php echo $styleSinEspacio; ?>><?php echo "SALA $numSala DISPONIBLE" ?></td>
            </tr>  
            <?php
		}?>		 
		 
		
	<?php } while($row_JRSalas = mysql_fetch_assoc($JRSalas)); // cierro do salas?> 
    <?php mysql_free_result($JRSalas);?>
    
        <tr>
             <td colspan="5" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
        </tr>
    
    </table>
  
<?php }// cierro totalrowsalas

}// cierro else

else if($dia=="Null" && $arraydias=="LaS" && $horaIni=="Null" && $horaFin=="Null")
{?>

   <table border="1" class="informehorarios" id="informehorarios" cellspacing="0"  cellpadding="0" width="600">
         
     <tr>
    
     <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
     <td  colspan="4"<?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
      </p></center><center><p>Universidad del Valle</p></center><center><p><?php echo "TODAS LAS SALAS" ?></p></center></td>
   </tr>

<?php
mysql_select_db($database_conexion, $conexion);
$query_JRSalas = "SELECT *  FROM sala where numSala <> 0 ORDER BY numSala";
mysql_query("SET NAMES 'utf8'");
$JRSalas = mysql_query($query_JRSalas, $conexion) or die(mysql_error());
$row_JRSalas = mysql_fetch_assoc($JRSalas);
$totalRows_JRSalas = mysql_num_rows($JRSalas);

if($totalRows_JRSalas>0)
{
	do
	{
		$numSala = $row_JRSalas['numSala'];
		$primerpcsala= $row_JRSalas['numpripc'];
		$ultimopcsala= $row_JRSalas['numultpc'];
		$plataforma= $row_JRSalas['Plataforma']; 
		
		$query_JRHorarios = "SELECT codGrupo, codAsignatura, codDia, horainicio, horafinal, sala FROM horario WHERE codDia between 1 and 6 and sala=$numSala and fechaInicio>='$fechainicial' and fechaFinal<='$fechafinal' and estadohorario='activo' ORDER BY codDia,horainicio asc";
		mysql_query("SET NAMES 'utf8'");
		$JRHorarios = mysql_query($query_JRHorarios, $conexion) or die(mysql_error());
		$row_JRHorarios = mysql_fetch_assoc($JRHorarios);
		$totalRows_JRHorarios = mysql_num_rows($JRHorarios);
		if($totalRows_JRHorarios > 0)
		{
			?>
           <tr>
               <td  colspan="5" <?php echo $stylecabeceratitulo; ?>><p>SALA <?php echo $numSala; ?></p> <p><?php echo "FICHAS"." "."DEL"." ".$primerpcsala." "."AL"." ".$ultimopcsala;?> </p> </td>
           </tr>
           <tr>
               <th <?php echo $styleth;?>>DIA</th>
               <th <?php echo $styleth;?>>CODIGO</th>
               <th <?php echo $styleth;?>>GRUPO</th>
               <th <?php echo $styleth;?>>ASIGNATURA </th>
               <th <?php echo $styleth;?>>HORA</th>
           </tr>
            <?php
			do{
				echo "<tr>";
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
                <?php
				echo "</tr>";
				
			}
			while ($row_JRHorarios = mysql_fetch_assoc($JRHorarios));
			mysql_free_result($JRHorarios);
			?>
	
		<?php } // cierro if totalrows
		else
		{
			?>
            <tr>
    			<td  colspan="5" <?php echo $styleSinEspacio; ?>><?php echo "SALA $numSala DISPONIBLE" ?></td>
            </tr>  
            <?php
		}?>		 
		 
		
	<?php } while($row_JRSalas = mysql_fetch_assoc($JRSalas)); // cierro do salas?> 
   <?php mysql_free_result($JRSalas);?>
    
        <tr>
             <td colspan="5" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
        </tr>
    
    </table>
  
<?php }// cierro totalrowsalas

}// cierro else

else if($dia!="Null" && $horaIni!="Null" && $horaFin!="Null")
{?>

	<table border="1" class="informehorarios" id="informehorarios" cellspacing="0"  cellpadding="0" width="600">
         
     <tr>
    
     <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
     <td  colspan="4"<?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
      </p></center><center><p>Universidad del Valle</p></center><center><p><?php echo "TODAS LAS SALAS" ?></p></center></td>
   </tr>

<?php
mysql_select_db($database_conexion, $conexion);
$query_JRSalas = "SELECT *  FROM sala where numSala <> 0 ORDER BY numSala";
mysql_query("SET NAMES 'utf8'");
$JRSalas = mysql_query($query_JRSalas, $conexion) or die(mysql_error());
$row_JRSalas = mysql_fetch_assoc($JRSalas);
$totalRows_JRSalas = mysql_num_rows($JRSalas);

if($totalRows_JRSalas>0)
{
	do
	{
		$numSala = $row_JRSalas['numSala'];
		$primerpcsala= $row_JRSalas['numpripc'];
		$ultimopcsala= $row_JRSalas['numultpc'];
		$plataforma= $row_JRSalas['Plataforma']; 
		
		$query_JRHorarios = "SELECT codGrupo, codAsignatura, codDia, horainicio, horafinal, sala FROM horario WHERE codDia=$dia and sala=$numSala and horainicio>='$horainicial' and  horafinal<='$horaend' and fechaInicio>='$fechainicial' and fechaFinal<='$fechafinal' and estadohorario='activo' order by horainicio";
		mysql_query("SET NAMES 'utf8'");
		$JRHorarios = mysql_query($query_JRHorarios, $conexion) or die(mysql_error());
		$row_JRHorarios = mysql_fetch_assoc($JRHorarios);
		$totalRows_JRHorarios = mysql_num_rows($JRHorarios);
		if($totalRows_JRHorarios > 0)
		{
			?>
           <tr>
               <td  colspan="5" <?php echo $stylecabeceratitulo; ?>><p>SALA <?php echo $numSala; ?></p> <p><?php echo "FICHAS"." "."DEL"." ".$primerpcsala." "."AL"." ".$ultimopcsala;?> </p> </td>
           </tr>
           <tr>
               <th <?php echo $styleth;?>>DIA</th>
               <th <?php echo $styleth;?>>CODIGO</th>
               <th <?php echo $styleth;?>>GRUPO</th>
               <th <?php echo $styleth;?>>ASIGNATURA </th>
               <th <?php echo $styleth;?>>HORA</th>
           </tr>
            <?php
			do{
				echo "<tr>";
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
                <?php
				echo "</tr>";
				
			}
			while ($row_JRHorarios = mysql_fetch_assoc($JRHorarios));
			mysql_free_result($JRHorarios);
			?>
	
		<?php } // cierro if totalrows
		else
		{
			?>
            <tr>
    			<td  colspan="5" <?php echo $styleSinEspacio; ?>><?php echo "SALA $numSala DISPONIBLE" ?></td>
            </tr>  
            <?php
		}?>		 
		 
		
	<?php } while($row_JRSalas = mysql_fetch_assoc($JRSalas)); // cierro do salas?> 
     <?php mysql_free_result($JRSalas);?>
    
        <tr>
             <td colspan="5" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
        </tr>
    
    </table>
  
<?php }// cierro totalrowsalas
	
}// cierro else

else if($dia=="Null" && $horaIni!="Null" && $horaFin!="Null" && $arraydias=="LaV")
{?>


	<table border="1" class="informehorarios" id="informehorarios" cellspacing="0"  cellpadding="0" width="600">
         
     <tr>
    
     <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
     <td  colspan="4"<?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
      </p></center><center><p>Universidad del Valle</p></center><center><p><?php echo "TODAS LAS SALAS" ?></p></center></td>
   </tr>

<?php
mysql_select_db($database_conexion, $conexion);
$query_JRSalas = "SELECT *  FROM sala where numSala <> 0 ORDER BY numSala";
mysql_query("SET NAMES 'utf8'");
$JRSalas = mysql_query($query_JRSalas, $conexion) or die(mysql_error());
$row_JRSalas = mysql_fetch_assoc($JRSalas);
$totalRows_JRSalas = mysql_num_rows($JRSalas);

if($totalRows_JRSalas>0)
{
	do
	{
		$numSala = $row_JRSalas['numSala'];
		$primerpcsala= $row_JRSalas['numpripc'];
		$ultimopcsala= $row_JRSalas['numultpc'];
		$plataforma= $row_JRSalas['Plataforma']; 
		
		$query_JRHorarios = "SELECT codGrupo, codAsignatura, codDia, horainicio, horafinal, sala FROM horario WHERE codDia between 1 and 5 and sala=$numSala and horainicio>='$horainicial' and horafinal<='$horaend' and fechaInicio>='$fechainicial' and fechaFinal<='$fechafinal' and estadohorario='activo' order by codDia,horainicio asc";
		mysql_query("SET NAMES 'utf8'");
		$JRHorarios = mysql_query($query_JRHorarios, $conexion) or die(mysql_error());
		$row_JRHorarios = mysql_fetch_assoc($JRHorarios);
		$totalRows_JRHorarios = mysql_num_rows($JRHorarios);
		if($totalRows_JRHorarios > 0)
		{
			?>
           <tr>
               <td  colspan="5" <?php echo $stylecabeceratitulo; ?>><p>SALA <?php echo $numSala; ?></p> <p><?php echo "FICHAS"." "."DEL"." ".$primerpcsala." "."AL"." ".$ultimopcsala;?> </p> </td>
           </tr>
           <tr>
               <th <?php echo $styleth;?>>DIA</th>
               <th <?php echo $styleth;?>>CODIGO</th>
               <th <?php echo $styleth;?>>GRUPO</th>
               <th <?php echo $styleth;?>>ASIGNATURA </th>
               <th <?php echo $styleth;?>>HORA</th>
           </tr>
            <?php
			do{
				echo "<tr>";
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
                <?php
				echo "</tr>";
				
			}
			while ($row_JRHorarios = mysql_fetch_assoc($JRHorarios));
			mysql_free_result($JRHorarios);
			?>
	
		<?php } // cierro if totalrows
		else
		{
			?>
            <tr>
    			<td  colspan="5" <?php echo $styleSinEspacio; ?>><?php echo "SALA $numSala DISPONIBLE" ?></td>
            </tr>  
            <?php
		}?>		 
		 
		
	<?php } while($row_JRSalas = mysql_fetch_assoc($JRSalas)); // cierro do salas?> 
    <?php mysql_free_result($JRSalas);?>
    
        <tr>
             <td colspan="5" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
        </tr>
    
    </table>
  
<?php }// cierro totalrowsalas

}// cierro else

else if($dia=="Null" && $horaIni!="Null" && $horaFin!="Null" && $arraydias=="LaS")
{?>
	<table border="1" class="informehorarios" id="informehorarios" cellspacing="0"  cellpadding="0" width="600">
         
     <tr>
    
     <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
     <td  colspan="4"<?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
      </p></center><center><p>Universidad del Valle</p></center><center><p><?php echo "TODAS LAS SALAS" ?></p></center></td>
   </tr>

<?php
mysql_select_db($database_conexion, $conexion);
$query_JRSalas = "SELECT *  FROM sala where numSala <> 0 ORDER BY numSala";
mysql_query("SET NAMES 'utf8'");
$JRSalas = mysql_query($query_JRSalas, $conexion) or die(mysql_error());
$row_JRSalas = mysql_fetch_assoc($JRSalas);
$totalRows_JRSalas = mysql_num_rows($JRSalas);

if($totalRows_JRSalas>0)
{
	do
	{
		$numSala = $row_JRSalas['numSala'];
		$primerpcsala= $row_JRSalas['numpripc'];
		$ultimopcsala= $row_JRSalas['numultpc'];
		$plataforma= $row_JRSalas['Plataforma']; 
		
		$query_JRHorarios = "SELECT codGrupo, codAsignatura, codDia, horainicio, horafinal, sala FROM horario WHERE codDia between 1 and 6 and sala=$numSala and horainicio>='$horainicial' and horafinal<='$horaend' and fechaInicio>='$fechainicial' and fechaFinal<='$fechafinal' and estadohorario='activo' order by codDia,horainicio asc";
		mysql_query("SET NAMES 'utf8'");
		$JRHorarios = mysql_query($query_JRHorarios, $conexion) or die(mysql_error());
		$row_JRHorarios = mysql_fetch_assoc($JRHorarios);
		$totalRows_JRHorarios = mysql_num_rows($JRHorarios);
		if($totalRows_JRHorarios > 0)
		{
			?>
           <tr>
               <td  colspan="5" <?php echo $stylecabeceratitulo; ?>><p>SALA <?php echo $numSala; ?></p> <p><?php echo "FICHAS"." "."DEL"." ".$primerpcsala." "."AL"." ".$ultimopcsala;?> </p> </td>
           </tr>
           <tr>
               <th <?php echo $styleth;?>>DIA</th>
               <th <?php echo $styleth;?>>CODIGO</th>
               <th <?php echo $styleth;?>>GRUPO</th>
               <th <?php echo $styleth;?>>ASIGNATURA </th>
               <th <?php echo $styleth;?>>HORA</th>
           </tr>
            <?php
			do{
				echo "<tr>";
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
                <?php
				echo "</tr>";
				
			}
			while ($row_JRHorarios = mysql_fetch_assoc($JRHorarios));
			mysql_free_result($JRHorarios);
			?>
	
		<?php } // cierro if totalrows
		else
		{
			?>
            <tr>
    			<td  colspan="5" <?php echo $styleSinEspacio; ?>><?php echo "SALA $numSala DISPONIBLE" ?></td>
            </tr>  
            <?php
		}?>		 
		 
		
	<?php } while($row_JRSalas = mysql_fetch_assoc($JRSalas)); // cierro do salas?> 
    <?php mysql_free_result($JRSalas);?>
    
        <tr>
             <td colspan="5" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
             <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			 $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
        </tr>
    
    </table>
  
<?php }// cierro totalrowsalas
	
}// cierro else


?>

<?php mysql_close($conexion); ?>    

<div id="alertas"></div>

</body>
</html>




 