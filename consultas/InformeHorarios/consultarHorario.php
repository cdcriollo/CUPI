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

	$sql=$_POST['sql'];
	$fechainicial=$_POST['fechainicial'];
	$fechafinal=$_POST['fechafinal'];
	$fechainicial=explode('-',$_POST['fechainicial']);
	$fechafinal=explode('-',$_POST['fechafinal']);
	$mesinicialpos0=substr($fechainicial[1], 0 , 1);
	$mesfinalpos0=substr($fechafinal[1], 0, 1);
	
	if($mesinicialpos0==0){
	  $mesinicial=substr($fechainicial[1], -1);	
	}
	else
	{
		$mesinicial=$fechainicial[1];	
	}
	
	if($mesfinalpos0==0){
	  $mesfinal=substr($fechafinal[1], -1);	
	}
	else
	{
		$mesfinal=$fechafinal[1];	
	}
	
	$styleth="";
	$styletr="";
	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
	$mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$ano=date('Y'); $hora=date('H'); $minutos= date('i'); $second= date('s');
	
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

<body>

<?php


mysql_select_db($database_conexion, $conexion);
$query_JRHorarios = "$sql and estadohorario='activo' order by codDia, sala";
mysql_query("SET NAMES 'utf8'");
$JRHorarios = mysql_query($query_JRHorarios, $conexion) or die(mysql_error());
$row_JRHorarios = mysql_fetch_assoc($JRHorarios);
$totalRows_JRHorarios = mysql_num_rows($JRHorarios);

 
   if ($totalRows_JRHorarios  > 0) 
   {  ?>
 

   <table class="informehorarios" id="informehorarios" cellspacing="0"  cellpadding="0" width="700" >
         
    <tr>
       <td align="center" <?php echo $styleImagen; ?> ><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/CUPI/images/tn1_univallelogo.jpg'?>" style="height:88px;          width:71px" /> 
      </td>
         
       <td  colspan="6" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
        </p></center><center><p>Universidad del Valle</p></center>
      </td>
   </tr> 
   
  <tr> 
    <td  colspan="7" <?php echo $stylecabeceratitulo; ?> ><center><p>HORARIOS DE LAS SALAS
       </p></center><center><p><?php echo "Consulta DESDE"." ". $fechainicial[2]."-".$mes[$mesinicial]."-".$fechainicial[0]." "."HASTA"." ". $fechafinal[2]."-".$mes[$mesfinal]."-".$fechafinal[0]?>  </p></center>
    </td>
  </tr>
 
  <tr> 
       
       <th <?php echo $styleth;?>>Dia</th>
       <th <?php echo $styleth;?>>Hora</th>
       <th <?php echo $styleth;?>>Sala</th>
       <th <?php echo $styleth;?>>Codigo</th>
       <th <?php echo $styleth;?>>Grupo</th>
       <th <?php echo $styleth;?>>Asignatura</th>
       <th <?php echo $styleth;?>>Reserva No</th>
                   
  </tr>
  
     <?php do { ?>
     
    <tr>
       
         <?php  
		 
			 $dia= $row_JRHorarios['codDia'];
			 $asignatura= $row_JRHorarios['nomAsignatura'];
			 $grupo= $row_JRHorarios['codGrupo'];
			 $horainicio= $row_JRHorarios['horainicio'];
             $horafinal= $row_JRHorarios['horafinal'];
			 $sala=$row_JRHorarios['sala'];
			 $codigo=$row_JRHorarios['codAsignatura'];
			 $reserva= $row_JRHorarios['No_reserva'];
			 $separar[1]=explode(':',$horainicio);
             $separar[2]=explode(':',$horafinal);
			 $horareducidainicio = $separar[1][0].":". $separar[1][1];
			 $horareducidafinal =  $separar[2][0].":". $separar[2][1];
			 
		 ?>
        
        
        <td <?php echo $styletr; ?>><?php echo $descripciondia= descripcionDia($dia);?> </td>
        <td <?php echo $styletr; ?>><?php echo $horareducidainicio."-".$horareducidafinal;?> </td>
        <td <?php echo $styletr; ?>><?php echo $sala;?></td>
        <td <?php echo $styletr; ?>><?php echo $codigo ?> </td>
        <td <?php echo $styletr; ?>><?php echo $grupo?> </td>
        <td <?php echo $styletr; ?>><?php echo $asignatura ?> </td>
        <td <?php echo $styletr; ?>><?php echo $reserva?> </td>
        
    </tr>
      
  <?php } while ($row_JRHorarios = mysql_fetch_assoc($JRHorarios)); ?> 
  
  <?php  mysql_free_result($JRHorarios); ?>
      
    <tr>
        <td colspan="7" <?php echo $stylecabecera?>> <?php echo '<p>'. 'Fuente: CUPI'.'-'.'Control de Utilizacion Piso Informatico'.'</br>'?>
        <?php echo 'Fecha y hora reporte:'." ".date('d').' de '.$mes[date('n')]." ".$ano." ".$hora.":".$minutos.":".$second.'</p>';?></td>
   </tr>
      
</table>


<?php }
 else 
     echo '<script type="text/javascript"> alertas("La consulta no arrojo resultados","Informe Horarios","error"); </script>';
?>


<?php mysql_close($conexion); ?>

<div id="alertas"></div>

</body>
</html>




 


 

 