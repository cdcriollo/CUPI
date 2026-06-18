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

$reserva=$_POST['reserva'];
$sala=$_POST['sala'];

mysql_select_db($database_conexion, $conexion);
$query_JRPcsala7 = "SELECT Nopc FROM pcs WHERE numSala = $sala ORDER BY Nopc ASC";
$JRPcsala7 = mysql_query($query_JRPcsala7, $conexion) or die(mysql_error());
$row_JRPcsala7 = mysql_fetch_assoc($JRPcsala7);
$totalRows_JRPcsala7 = mysql_num_rows($JRPcsala7);

$numcolumnas = 3;
$styleocupado='style="color:#FF0000; font-weight:bold; font-size:14px;"';
$stylefree='style="color:#009900; font-weight:bold; font-size:14px;"';

        
 
 function verificarestadopc ($database_conexion, $conexion, $pc, $reserva)
 {
	  mysql_select_db($database_conexion, $conexion);
      $query_JRPcmatriculasala7 = "SELECT pc FROM matricula WHERE pc = $pc and  Estado='Activa' and No_reserva='$reserva'";
	  $JRPcmatriculasala7 = mysql_query($query_JRPcmatriculasala7, $conexion) or die(mysql_error());
	  $row_JRPcmatriculasala7 = mysql_fetch_assoc($JRPcmatriculasala7);
      $totalRows_JRPcmatriculasala7 = mysql_num_rows($JRPcmatriculasala7);  
	  
	  if($totalRows_JRPcmatriculasala7 > 0)
	  {
		 return 1;  
	  }
	  else if($totalRows_JRPcmatriculasala7 ==0)
	  {
		 return 0;    
	  }
	  
	  mysql_free_result($JRPcmatriculasala7);
 }
 
 function Equipodocente($database_conexion, $conexion, $sala)
 {
	
	
	mysql_select_db($database_conexion, $conexion);
	$query_JREquipodocente = "SELECT Nopc FROM pcs WHERE estado = 'Docente' and numSala= $sala";
	$JREquipodocente = mysql_query($query_JREquipodocente, $conexion) or die(mysql_error());
	$row_JREquipodocente = mysql_fetch_assoc($JREquipodocente);
	$totalRows_JREquipodocente = mysql_num_rows($JREquipodocente); 
	
	$pc=$row_JREquipodocente['Nopc'];
	
	return $pc;
	
	mysql_free_result($JREquipodocente);
	
 }
 
 
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>

<?php
 
   if ($totalRows_JRPcsala7 > 0) 
   {
	   
	   echo '<script type="text/javascript">$(".tableUI").styleTable();</script> ';?>
       
        <table border="1" width="300" cellpadding="0" cellpadding="0" id="comp" class="tableUI" style="margin-top:10px; margin-bottom:10px; margin-left:10px;">
        
        <thead>
        <tr>
        <th><?php echo "SALA"." ".$sala; ?></th>
         <?php $pcdocente=Equipodocente($database_conexion, $conexion, $sala)?>
        <th colspan="2"><?php echo $pcdocente."/"."Profe".$sala; ?></th>
        </tr>
        
        </thead>

  <?php
     
	  $i = 1;
	  
	 do
	 {
		
		
	    $resto = ($i % $numcolumnas); 
       if($resto == 1)
	   { ?> 
         <tr>
       <?php }
	   
	   $pcsala7=$row_JRPcsala7['Nopc'];
	   $estadopc=verificarestadopc($database_conexion, $conexion, $pcsala7, $reserva);
	   
	   if($estadopc==1)
	   {?>
		  <td  <?php  echo $styleocupado ?>> <input type="checkbox" value="<?php echo $row_JRPcsala7['Nopc']; ?>" class="freepc"/><?php echo $pcsala7 ?> </td>   
	   <?php }
	   else if($estadopc==0)
	   {?>
		    <td <?php echo $stylefree ?>><input type="checkbox" value="<?php echo $row_JRPcsala7['Nopc']; ?>" class="freepc"/><?php echo $pcsala7 ?></td>
             
	  <?php  }
	   
       
     /*mostramos el valor del campo especificado*/ 
     if($resto == 0)
	 {?>
      
       </tr> 
     <?php }
   $i++;  
		 
	 }while($row_JRPcsala7 = mysql_fetch_assoc($JRPcsala7));
	 
    
     
      
 }

?>

</table>

</body>
</html>

<?php
mysql_free_result($JRPcsala7);


?>
