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

if(isset($_POST['desde'],$_POST['hasta'],$_POST['cadena']))
{
	
$desde=implode('-',array_reverse(explode('-',$_POST['desde'])));
$hasta=implode('-',array_reverse(explode('-',$_POST['hasta'])));

$fechainicial=$desde." ".'00:00:00';
$fechafinal=$hasta." ".'23:59:59';
$cadena=$_POST['cadena'];

	if($cadena==1)
	{
		mysql_select_db($database_conexion, $conexion);
$query_JRConsultaReservas = "SELECT r.id, r.No_reserva, r.cod_asignatura, r.grupo, r.nombre_asignatura, r.fecha_reserva, h.codDia, h.horainicio, h.horafinal, h.fechaInicio, h.fechaFinal,h.sala from reserva_eventual r inner join horario h on (r.No_reserva=h.No_reserva)  where r.fecha_reserva BETWEEN '$fechainicial' and '$fechafinal' and r.No_reserva like 'FAIPIRS%' order by r.id";
mysql_query("SET NAMES 'utf8'");
$JRConsultaReservas = mysql_query($query_JRConsultaReservas, $conexion) or die(mysql_error());
$row_JRConsultaReservas = mysql_fetch_assoc($JRConsultaReservas);
$totalRows_JRConsultaReservas = mysql_num_rows($JRConsultaReservas);
	}
	else if($cadena==2)
	{
		mysql_select_db($database_conexion, $conexion);
		$query_JRConsultaReservas = "SELECT r.id, r.No_reserva, r.cod_asignatura, r.grupo, r.nombre_asignatura, r.fecha_reserva, h.codDia, h.horainicio, h.horafinal, h.fechaInicio, h.fechaFinal, h.sala from reserva_eventual r inner join horario h on (r.No_reserva=h.No_reserva)  where r.fecha_reserva BETWEEN '$fechainicial' and '$fechafinal' and r.No_reserva like 'FAIPIRE%' order by r.id";
		mysql_query("SET NAMES 'utf8'");
		$JRConsultaReservas = mysql_query($query_JRConsultaReservas, $conexion) or die(mysql_error());
		$row_JRConsultaReservas = mysql_fetch_assoc($JRConsultaReservas);
		$totalRows_JRConsultaReservas = mysql_num_rows($JRConsultaReservas);
	}
	else if($cadena==3)
	{
		mysql_select_db($database_conexion, $conexion);
		$query_JRConsultaReservas = "SELECT r.id, r.No_reserva, r.cod_asignatura, r.grupo, r.nombre_asignatura, r.fecha_reserva, h.codDia, h.horainicio, h.horafinal, h.fechaInicio, h.fechaFinal, h.sala from reserva_eventual r inner join horario h on (r.No_reserva=h.No_reserva)  where r.fecha_reserva BETWEEN '$fechainicial' and '$fechafinal'  order by r.id";
		mysql_query("SET NAMES 'utf8'");
		$JRConsultaReservas = mysql_query($query_JRConsultaReservas, $conexion) or die(mysql_error());
		$row_JRConsultaReservas = mysql_fetch_assoc($JRConsultaReservas);
		$totalRows_JRConsultaReservas = mysql_num_rows($JRConsultaReservas);

	}
	
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
 <?php if ($totalRows_JRConsultaReservas > 0){ ?>
	
	 <table cellspacing="0" cellspacing="0" width="650" class="RReservas" id="RReservas" >
	
	  <tr>
		
		 <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
		 <td  colspan="8" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
		 </p></center><center><p>Universidad del Valle </p></center> </td>
    </tr>
	  
	  <tr>
	  <td <?php echo $stylecabeceratitulo;?> colspan="9"><center><p>INFORME DE RESERVAS EVENTUALES </p></center></td>
	  </tr>
	  
	  
	  <tr>
        <th <?php echo $styleth;?>>No</th> 
		<th <?php echo $styleth;?>>Reserva No</th>
	    <th<?php echo $styleth;?>>Codigo Asignatura</th>
		<th <?php echo $styleth;?>>Grupo</th>
	    <th <?php echo $styleth;?>>Nombre Asignatura</th>
		<th <?php echo $styleth;?>>Horario</th>
        <th <?php echo $styleth;?>>Fecha Inicio</th>
		<th <?php echo $styleth;?>>Fecha Terminación</th>
        <th <?php echo $styleth;?>>Sala</th>		   	   
	  </tr>
      
      <?php $i=1; ?>
      
      <?php do { 	  
	    $reserva=$row_JRConsultaReservas['No_reserva'];	  
	  ?>
      
	  
	   <tr>
        <td <?php echo $styletr; ?>><?php echo $i++; ?></td> 
		<td <?php echo $styletr; ?> ><?php echo $row_JRConsultaReservas['No_reserva'] ?></td>
		<td <?php echo $styletr; ?> ><?php echo $row_JRConsultaReservas['cod_asignatura'] ?></td>
		<td <?php echo $styletr; ?> ><?php echo $row_JRConsultaReservas['grupo'] ?></td>
		<td <?php echo $styletr; ?> ><?php echo $row_JRConsultaReservas['nombre_asignatura'] ?></td>
      
     <?php  
		
		$diasemana=descripcionDia($row_JRConsultaReservas['codDia']);
		$horainicio=$row_JRConsultaReservas['horainicio'];
		$horafinal=$row_JRConsultaReservas['horafinal'];
		$horario= $diasemana." ".$horainicio." ".$horafinal;
				
     ?>
              
        <td <?php echo $styletr; ?>><?php echo $horario; ?></td>
		<td <?php echo $styletr; ?>><?php echo $row_JRConsultaReservas['fechaInicio'] ?></td>
		<td <?php echo $styletr; ?>><?php echo $row_JRConsultaReservas['fechaFinal'] ?></td>
		<td <?php echo $styletr; ?>><?php echo $row_JRConsultaReservas['sala'] ?></td>
      </tr>  
             
      <?php } while($row_JRConsultaReservas = mysql_fetch_assoc($JRConsultaReservas)) ?>
      
      <tr>
          <td colspan="9" <?php echo $stylefooter?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
          <?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		  $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		  $ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');?> <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
     </tr>
      
     <?php } ?>  

</body>
</html>
<?php
mysql_free_result($JRConsultaReservas)


?>
