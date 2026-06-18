<?php require_once('../../Connections/conexion.php'); ?>
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

if(isset($_POST['desde'],$_POST['hasta'],$_POST['cadenareserva']))
{
	
$desde=implode('-',array_reverse(explode('-',$_POST['desde'])));
$hasta=implode('-',array_reverse(explode('-',$_POST['hasta'])));

$fechainicial=$desde." ".'00:00:00';
$fechafinal=$hasta." ".'23:59:59';
$cadena=$_POST['cadenareserva'];

	if($cadena==1)
	{
	
		mysql_select_db($database_conexion, $conexion);
$query_JRConsultaReservas = "SELECT id, No_reserva, cod_asignatura, grupo, nombre_asignatura, fecha_reserva from reserva_eventual  where fecha_reserva BETWEEN '$fechainicial' and '$fechafinal' and No_reserva like 'FAIPIRS%' order by r.id";
$JRConsultaReservas = mysql_query($query_JRConsultaReservas, $conexion) or die(mysql_error());
$row_JRConsultaReservas = mysql_fetch_assoc($JRConsultaReservas);
$totalRows_JRConsultaReservas = mysql_num_rows($JRConsultaReservas);
	}
	else if($cadena==2)
	{
		mysql_select_db($database_conexion, $conexion);
		$query_JRConsultaReservas = "SELECT r.id, r.No_reserva, r.cod_asignatura, r.grupo, r.nombre_asignatura,r.fecha_reserva from reserva_eventual r  where fecha_reserva BETWEEN '$fechainicial' and '$fechafinal' and r.No_reserva like 'FAIPIRE%' order by r.id";
		$JRConsultaReservas = mysql_query($query_JRConsultaReservas, $conexion) or die(mysql_error());
		$row_JRConsultaReservas = mysql_fetch_assoc($JRConsultaReservas);
		$totalRows_JRConsultaReservas = mysql_num_rows($JRConsultaReservas);
	}
	else if($cadena==3)
	{
		mysql_select_db($database_conexion, $conexion);
		$query_JRConsultaReservas = "SELECT r.id, r.No_reserva, r.cod_asignatura, r.grupo, r.nombre_asignatura,r.fecha_reserva from reserva_eventual r  where fecha_reserva BETWEEN '$fechainicial' and '$fechafinal' order by r.id";
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
	
	 <table cellspacing="0" cellspacing="0" width="650" class="ReporteClase" id="ReporteClase"  >
	
	  <tr>
		
		 <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px; width:71px" /> </td>
		 <td  colspan="6" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
		 </p></center><center><p>Universidad del Valle </p></center> </td>
    </tr>
	  
	  <tr>
	  <td <?php echo $stylecabeceratitulo;?> colspan="7"><center><p>INFORME DE RESERVAS EVENTUALES </p></center></td>
	  </tr>
	  
	  
	  <tr>
         
		<th <?php echo $styleth;?>>Reserva No</th>
	    <th<?php echo $styleth;?> colspan="2">Codigo Asignatura</th>
		<th <?php echo $styleth;?>>Grupo</th>
	    <th <?php echo $styleth;?> colspan="2">Nombre Asignatura</th>
		<th <?php echo $styleth;?>>Horario</th>
        <th <?php echo $styleth;?> colspan="2">Fecha Inicio</th>
		<th <?php echo $styleth;?>>Fecha Terminación</th>
        <th <?php echo $styleth;?>>Sala</th>		   	   
	  </tr>
      
      <?php do { 
	  
	    $reserva=$row_JRConsultaReservas['No_reserva'];
	  
	  ?>
      
	  
	   <tr>
		<td <?php echo $styletr; ?> ><?php echo $row_JRConsultaReservas['No_reserva'] ?></td>
		<td <?php echo $styletr; ?> colspan="2"><?php echo $row_JRConsultaReservas['cod_asignatura'] ?></td>
		<td <?php echo $styletr; ?> ><?php echo $row_JRConsultaReservas['grupo'] ?></td>
		<td <?php echo $styletr; ?> colspan="2" ><?php echo $row_JRConsultaReservas['nombre_asignatura'] ?></td>
		<td <?php echo $styletr; ?> ><?php echo $row_JRConsultaReservas[''] ?></td>
	  </tr> 
      
     <?php  mysql_select_db($database_conexion, $conexion);
		$query_JRHorario = "SELECT codDia, horainicio, horafinal, fechaInicio, fechaFinal, sala FROM horario WHERE No_reserva = '$reserva'";
		$JRHorario = mysql_query($query_JRHorario, $conexion) or die(mysql_error());
		$row_JRHorario = mysql_fetch_assoc($JRHorario);
		$totalRows_JRHorario = mysql_num_rows($JRHorario);
		
		$dia=$row_JRHorario['codDia'];
		$horainicio=$row_JRHorario['horainicio'];
		$horafinal=$row_JRHorario['horafinal'];
		$horario= $dia." ".$horainicio." ".$horafinal;
				
     ?>
              
        <td <?php echo $styletr; ?> ><?php echo $horario; ?></td>
		<td <?php echo $styletr; ?> colspan="2"><?php echo $row_JRHorario['fechaInicio'] ?></td>
		<td <?php echo $styletr; ?> ><?php echo $row_JRHorario['fechaFinal'] ?></td>
		<td <?php echo $styletr; ?> colspan="2" ><?php echo $row_JRHorario['sala'] ?></td>
             
      <?php } while($row_JRConsultaReservas = mysql_fetch_assoc($JRConsultaReservas)) ?>
      
     <?php } ?>  
</body>
</html>
<?php
mysql_free_result($JRConsultaReservas)

//mysql_free_result($JRHorario);
?>
