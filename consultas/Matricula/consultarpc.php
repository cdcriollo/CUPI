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

if(isset($_POST['asignatura'],$_POST['grupo'],$_POST['sala'], $_POST['reserva']))
{

	$asignatura=$_POST['asignatura'];
	$grupo=$_POST['grupo'];
	$sala=$_POST['sala'];
	$reserva=$_POST['reserva'];
	$respuesta=array();


    mysql_select_db($database_conexion, $conexion);
	$query_JRAsignarpc = "select pc from matricula where codAsignatura='$asignatura' and grupo=$grupo and No_reserva= '$reserva' and pc <> 0 and Estado='Activa'";
	mysql_query("SET NAMES 'utf8'");
	$JRAsignarpc = mysql_query($query_JRAsignarpc, $conexion) or die(mysql_error());
	$row_JRAsignarpc = mysql_fetch_assoc($JRAsignarpc);
	$totalRows_JRAsignarpc = mysql_num_rows($JRAsignarpc);
	    
		
    if ($totalRows_JRAsignarpc > 0)  
    {  

       do {  
      ?>
     <?php

      $pcs[0]=$row_JRAsignarpc['pc'];

      for ($i=1; $i<$totalRows_JRAsignarpc; $i++) 
	  {  
       $pc = mysql_fetch_array($JRAsignarpc);  
       $pcs[$i] = $pc["pc"];  
      }  
	?>
   <?php
   } while ($row_JRAsignarpc = mysql_fetch_assoc($JRAsignarpc));
   $rows = mysql_num_rows($JRAsignarpc);
    if($rows > 0) {
      mysql_data_seek($JRAsignarpc, 0);
	  $row_JRAsignarpc = mysql_fetch_assoc($JRAsignarpc);
     } 
  
   $cadenapcs=implode(',',$pcs);
	mysql_free_result($JRAsignarpc);
 
	mysql_select_db($database_conexion, $conexion);
	$query_JRListapc = "select Nopc from pcs where Nopc NOT IN($cadenapcs) and numSala=$sala and Estado <> 'Docente' LIMIT 1";
	mysql_query("SET NAMES 'utf8'");
	$JRListapc = mysql_query($query_JRListapc, $conexion) or die(mysql_error());
	$row_JRListapc = mysql_fetch_assoc($JRListapc);
	$totalRows_JRListapc = mysql_num_rows($JRListapc);
	
	if($totalRows_JRListapc > 0)

    {	
	  echo $row_JRListapc['Nopc']; 
	  mysql_free_result($JRListapc);
	}
	else
	{
	   echo -1;	
	}

	
  }// cierro if
  else
  {
	 mysql_select_db($database_conexion, $conexion);
	$query_JRSeleccionarpc = "SELECT Nopc FROM pcs WHERE numSala= $sala and Estado <> 'Docente' limit 1 ";
	mysql_query("SET NAMES 'utf8'");
	$JRSeleccionarpc = mysql_query($query_JRSeleccionarpc, $conexion) or die(mysql_error());
	$row_JRSeleccionarpc = mysql_fetch_assoc($JRSeleccionarpc);
	$totalRows_JRSeleccionarpc = mysql_num_rows($JRSeleccionarpc);
	
	echo $row_JRSeleccionarpc['Nopc']; 
	mysql_free_result($JRSeleccionarpc);

  }
  
  mysql_close($conexion);
  
}
?>

