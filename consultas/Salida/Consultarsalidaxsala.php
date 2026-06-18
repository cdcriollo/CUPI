<?php require_once('../../Connections/conexion.php'); ?>
<?php  date_default_timezone_set("America/bogota"); ?>

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
$actividad= $_POST['actividad'];
$fecha= date('y'.'-'.'m'.'-'.'d');
//$fecha= '2016-02-06';
$contadorprestamo=0;
$contadorequipo=0;
$contadorprestamoequipo=0;
$horasalida= date('H:i');

mysql_select_db($database_conexion, $conexion);
$query_JRSalidaSala = "select codIngreso, estado, computador, codUsuario from ingreso_salida where fecha='$fecha' and sala=$sala and estado=5 and actividad='$actividad' ";
mysql_query("SET NAMES 'utf8'");
$JRSalidaSala = mysql_query($query_JRSalidaSala, $conexion) or die(mysql_error());
$row_JRSalidaSala = mysql_fetch_assoc($JRSalidaSala);
$totalRows_JRSalidaSala = mysql_num_rows($JRSalidaSala);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript">

$(".tableUI").styleTable();

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

<title>Documento sin título</title>
</head>
 <style type="text/css">
 .tdpc{
	 color:#F00;
	 font-weight:bold;
	 font-size:14px;
	 
 }
  
 </style>
 
<body>

<?php  if($totalRows_JRSalidaSala > 0) { ?>

<table border="1" cellpadding="0" class="tableUI" cellspacing="0"  width="600"  style=" margin-left:15px; margin-bottom:15px;">
   
   
      <tr>
       <td colspan="3" class="tdpc">Usuarios con salida exitosa</td>
     </tr>
    
    <tr>
        <th>Computador</th> 
        <th>Codigo</th>
        <th>Estado</th>
   </tr>


<?php do{


$codingreso= $row_JRSalidaSala['codIngreso'];
$estado= $row_JRSalidaSala['estado'];
$pc= $row_JRSalidaSala['computador'];
$codigousuario= $row_JRSalidaSala['codUsuario'];


if($estado==5)
{
  $actualizaringreso = "UPDATE ingreso_salida SET  horasalida='$horasalida', estado=1 WHERE codIngreso= $codingreso ";           
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query( $actualizaringreso , $conexion) or die(mysql_error());
  
  $actualizarpcs = "UPDATE pcs SET estadoocupacion='disponible' WHERE Nopc = $pc";              
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query( $actualizarpcs , $conexion) or die(mysql_error());?>
  
   
   <tr>
     <td><?php echo $row_JRSalidaSala['computador']; ?></td>
     <td><?php echo $row_JRSalidaSala['codUsuario']; ?></td>
     <td> <?php if ( $Result1==1 && $Result2==1){?><img src="images/ok.png"/>  <?php }?> </td>
   </tr>
 


   
<?php }// cierro estado 5

  }  while($row_JRSalidaSala = mysql_fetch_assoc($JRSalidaSala)); ?>
  <?php mysql_free_result($JRSalidaSala);?>
  
  </table>
  
<?php } // cierro if ?>

  <?php
  
  mysql_select_db($database_conexion, $conexion);
 $query_JRSalidaSala1 = "select codIngreso, estado, computador, codUsuario from ingreso_salida where fecha='$fecha' and sala=$sala and estado between 2 and 4 and actividad='$actividad' ";
 mysql_query("SET NAMES 'utf8'");
 $JRSalidaSala1 = mysql_query($query_JRSalidaSala1, $conexion) or die(mysql_error());
 $row_JRSalidaSala1 = mysql_fetch_assoc($JRSalidaSala1);
 $totalRows_JRSalidaSala1 = mysql_num_rows($JRSalidaSala1);?>
  
  
  <?php if ($totalRows_JRSalidaSala1 > 0){ ?>
  
   <table border="1" cellpadding="0" class="tableUI" cellspacing="0"  width="600"  style=" margin-left:15px; ">
   
   
      <tr>
       <td colspan="5" class="tdpc">El usuario debe Devolver</td>
       <td colspan="3" class="tdpc">Retira de su Propiedad</td>
       <input type="hidden" id="NoRegistros" value="<?php echo $totalRows_JRSalidaSala1; ?>"/>
     </tr>
    
    <tr>
        <th>Sale</th> 
        <th>Computador</th>
        <th>Inventario</th>
        <th>Cantidad</th>
        <th>Descripcion</th>
        <th>Equipo</th>
        <th>Cantidad</th>
        <th>Detalles</th>
   </tr> 
  
  <?php do {?>
   
 <?php  
 
  
  $codingreso1= $row_JRSalidaSala1['codIngreso'];
  $estado1= $row_JRSalidaSala1['estado'];
  $pc1= $row_JRSalidaSala1['computador'];

 ?>
	   
       
   
  <?php 


  if($estado1==2){ 
	 
	
	   mysql_select_db($database_conexion, $conexion);
	   $query_JRPrestamos = "SELECT idPrestamo FROM prestamorecursos WHERE codIngreso = $codingreso1";
	   mysql_query("SET NAMES 'utf8'");
	   $JRPrestamos = mysql_query($query_JRPrestamos, $conexion) or die(mysql_error());
	   $row_JRPrestamos = mysql_fetch_assoc($JRPrestamos);
	   $totalRows_JRPrestamos = mysql_num_rows($JRPrestamos);
   
       $idprestamo= $row_JRPrestamos['idPrestamo'];
	   mysql_free_result($JRPrestamos);

		mysql_select_db($database_conexion, $conexion);
		$query_JRDetallePrestamo = "SELECT Noinventario, cantidad, descripcion FROM detalle_prestamo WHERE idPrestamo = $idprestamo";
		mysql_query("SET NAMES 'utf8'");
		$JRDetallePrestamo = mysql_query($query_JRDetallePrestamo, $conexion) or die(mysql_error());
		$row_JRDetallePrestamo = mysql_fetch_assoc($JRDetallePrestamo);
		$totalRows_JRDetallePrestamo = mysql_num_rows($JRDetallePrestamo);
	 
	 ?>
     
    
     
     <?php do {?> 
     
  
    
     <tr>
     
     <?php if($contadorprestamo==0) { ?>
     <td><input type="checkbox" value="<?php echo $row_JRSalidaSala1['codIngreso'];?>. <?php echo $row_JRSalidaSala1['computador'];?>"/></td>
     <?php $contadorprestamo++; }else if ($contadorprestamo > 0) { ?> <td>&nbsp;</td> <?php $contadorprestamo++;  } ?>
     
     
     <td class="tdpc"><?php echo $pc1  ?></td>
     <td class="detprestamo"><?php echo $row_JRDetallePrestamo['Noinventario']; ?></td>
     <td><?php echo $row_JRDetallePrestamo['cantidad']; ?></td>
     <td><?php echo $row_JRDetallePrestamo['descripcion']; ?></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     
     </tr>
    <?php } while ($row_JRDetallePrestamo = mysql_fetch_assoc($JRDetallePrestamo)); ?>
    
   <?php  $contadorprestamo=0; ?>
   <?php mysql_free_result($JRDetallePrestamo);?>
    
    <?php } // cierro estado 2
	  
	
	else if($estado1==3){
		
		
	
	 mysql_select_db($database_conexion, $conexion);
	$query_JREquipos = "SELECT Idingreso FROM equipos_externos WHERE codIngreso = $codingreso1";
	mysql_query("SET NAMES 'utf8'");
	$JREquipos = mysql_query($query_JREquipos, $conexion) or die(mysql_error());
	$row_JREquipos = mysql_fetch_assoc($JREquipos);
	$totalRows_JREquipos = mysql_num_rows($JREquipos);
	
	$idingreso= $row_JREquipos['Idingreso'];
	mysql_free_result($JREquipos);

	mysql_select_db($database_conexion, $conexion);
	$query_JRDetalleequipos = "SELECT equipo, cantidad, detalles FROM detalle_equipos_externos WHERE Idingreso = $idingreso";
	mysql_query("SET NAMES 'utf8'");
	$JRDetalleequipos = mysql_query($query_JRDetalleequipos, $conexion) or die(mysql_error());
	$row_JRDetalleequipos = mysql_fetch_assoc($JRDetalleequipos);
	$totalRows_JRDetalleequipos = mysql_num_rows($JRDetalleequipos);
	
	
       do { ?>
     
     <tr>
     
      <?php if($contadorequipo==0) { ?>
     <td><input type="checkbox" value="<?php echo $row_JRSalidaSala1['codIngreso'];?>. <?php echo $row_JRSalidaSala1['computador'];?>"/></td>
     <?php $contadorequipo++; }else if ($contadorequipo > 0) { ?> <td>&nbsp;</td> <?php $contadorequipo++;  } ?>
      
     <td class="tdpc"><?php echo $pc1  ?></td>
      <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
      <td class="detequipo"><?php echo $row_JRDetalleequipos['equipo']; ?></td>
     <td class="detequipo"><?php echo $row_JRDetalleequipos['cantidad']; ?></td>
      <td class="detequipo"><?php echo $row_JRDetalleequipos['detalles']; ?></td>
    
      
     </tr>
    <?php } while ($row_JRDetalleequipos = mysql_fetch_assoc($JRDetalleequipos)); ?>
    
  <?php  $contadorequipo=0; ?>
  <?php mysql_free_result($JRDetalleequipos);?>
    
  
<?php  } // cierro estado 3

  else if ($estado1==4){
	
       mysql_select_db($database_conexion, $conexion);
	   $query_JRPrestamos = "SELECT idPrestamo FROM prestamorecursos WHERE codIngreso = $codingreso1";
	   mysql_query("SET NAMES 'utf8'");
	   $JRPrestamos = mysql_query($query_JRPrestamos, $conexion) or die(mysql_error());
	   $row_JRPrestamos = mysql_fetch_assoc($JRPrestamos);
	   $totalRows_JRPrestamos = mysql_num_rows($JRPrestamos);
   
       $idprestamo= $row_JRPrestamos['idPrestamo'];
	   mysql_free_result($JRPrestamos);

		mysql_select_db($database_conexion, $conexion);
		$query_JRDetallePrestamo = "SELECT Noinventario, cantidad, descripcion FROM detalle_prestamo WHERE idPrestamo = $idprestamo";
		mysql_query("SET NAMES 'utf8'");
		$JRDetallePrestamo = mysql_query($query_JRDetallePrestamo, $conexion) or die(mysql_error());
		$row_JRDetallePrestamo = mysql_fetch_assoc($JRDetallePrestamo);
		$totalRows_JRDetallePrestamo = mysql_num_rows($JRDetallePrestamo);
		
		mysql_select_db($database_conexion, $conexion);
		$query_JREquipos = "SELECT Idingreso FROM equipos_externos WHERE codIngreso = $codingreso1";
		mysql_query("SET NAMES 'utf8'");
		$JREquipos = mysql_query($query_JREquipos, $conexion) or die(mysql_error());
		$row_JREquipos = mysql_fetch_assoc($JREquipos);
		$totalRows_JREquipos = mysql_num_rows($JREquipos);
	
		$idingreso= $row_JREquipos['Idingreso'];
		 mysql_free_result($JREquipos);
	
		mysql_select_db($database_conexion, $conexion);
		$query_JRDetalleequipos = "SELECT equipo, cantidad, detalles FROM detalle_equipos_externos WHERE Idingreso = $idingreso";
		mysql_query("SET NAMES 'utf8'");
		$JRDetalleequipos = mysql_query($query_JRDetalleequipos, $conexion) or die(mysql_error());
		$row_JRDetalleequipos = mysql_fetch_assoc($JRDetalleequipos);
		$totalRows_JRDetalleequipos = mysql_num_rows($JRDetalleequipos);
			
		?> <?php  if ($totalRows_JRDetallePrestamo==1 && $totalRows_JRDetalleequipos==1) {
	   
	    do { ?>
     
     
     
     <tr>
     <td><input type="checkbox" value="<?php echo $row_JRSalidaSala1['codIngreso'];?>. <?php echo $row_JRSalidaSala1['computador'];?>"/></td>
     
      <td class="tdpc"><?php echo $pc1  ?></td>
      <td class="detprestamo"><?php echo $row_JRDetallePrestamo['Noinventario']; ?></td>
      <td><?php echo $row_JRDetallePrestamo['cantidad']; ?></td>
      <td><?php echo $row_JRDetallePrestamo['descripcion']; ?></td>
      
      <?php } while($row_JRDetallePrestamo = mysql_fetch_assoc($JRDetallePrestamo)); ?>
     
      
       <?php do{ ?>
      
       
       <td class="detequipo"><?php echo $row_JRDetalleequipos['equipo']; ?></td>
       <td class="detequipo"><?php echo $row_JRDetalleequipos['cantidad']; ?></td>
       <td class="detequipo"><?php echo $row_JRDetalleequipos['detalles']; ?></td>
       <?php } while($row_JRDetalleequipos = mysql_fetch_assoc($JRDetalleequipos)); ?>
      
     </tr>
    
	 <?php } else if ($totalRows_JRDetallePrestamo >= 1 && $totalRows_JRDetalleequipos >= 1) {?>
      
      
      <?php do{ ?>
      
      <tr>
       <?php if($contadorprestamo==0) { ?>
     <td><input type="checkbox" value="<?php echo $row_JRSalidaSala1['codIngreso'];?>. <?php echo $row_JRSalidaSala1['computador'];?>"/></td>
     <?php $contadorprestamo++; }else if ($contadorprestamo > 0) { ?> <td>&nbsp;</td> <?php $contadorprestamo++;  } ?>
       <td class="tdpc"><?php echo $pc1  ?></td>
      <td class="detprestamo"><?php echo $row_JRDetallePrestamo['Noinventario']; ?></td>
      <td><?php echo $row_JRDetallePrestamo['cantidad']; ?></td>
      <td><?php echo $row_JRDetallePrestamo['descripcion']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      
      <?php } while($row_JRDetallePrestamo = mysql_fetch_assoc($JRDetallePrestamo)); ?>
       <?php  $contadorprestamo=0; ?>
      </tr>
       <?php do{ ?>
      
       <tr>
       <td>&nbsp;</td>
      <td class="tdpc"><?php echo $pc1  ?></td>
       <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
       <td class="detequipo"><?php echo $row_JRDetalleequipos['equipo']; ?></td>
       <td class="detequipo"><?php echo $row_JRDetalleequipos['cantidad']; ?></td>
       <td class="detequipo"><?php echo $row_JRDetalleequipos['detalles']; ?></td>
       <?php } while($row_JRDetalleequipos = mysql_fetch_assoc($JRDetalleequipos)); ?>
      
     </tr>
     
     
     
     <?php } // cierro else ?>  
	   
      <?php  
	  
	    mysql_free_result($JRDetallePrestamo);
        mysql_free_result($JRDetalleequipos); 
	  ?> 
	
<?php } // cierro estado 4 ?> 

 
 
<?php  }while($row_JRSalidaSala1 = mysql_fetch_assoc($JRSalidaSala1)); ?>
 
 
</table>
 <?php }// cierro if?>
 
 <?php if ($totalRows_JRSalidaSala==0 && $totalRows_JRSalidaSala1==0){
	 
	echo'<script type="text/javascript">alertas("La consulta no arrojo resultados","Salida x Sala ","error");</script> '; 
	
 } ?>
    
    <?php mysql_free_result($JRSalidaSala1);?> 
    
 <div id="alertas"></div>
</body>
</html>



