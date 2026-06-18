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



$sala=$_POST['Sala'];
$asignatura=$_POST['Asignatura'];
$grupo=$_POST['Grupo'];
$reserva=$_POST['reserva'];
$cadenapcs="";


mysql_select_db($database_conexion, $conexion);
$query_JRidhorario = "SELECT idHorario FROM horario WHERE codAsignatura = '$asignatura' and codGrupo=$grupo AND sala=$sala AND No_reserva='$reserva' AND estadohorario='activo' order by idHorario";

mysql_query("SET NAMES 'utf8'");
$JRidhorario = mysql_query($query_JRidhorario, $conexion) or die(mysql_error());
$row_JRidhorario = mysql_fetch_assoc($JRidhorario);
$totalRows_JRidhorario = mysql_num_rows($JRidhorario);

mysql_select_db($database_conexion, $conexion);
$query_JRSalas = "SELECT distinct sala From horario where codAsignatura='$asignatura' and codGrupo=$grupo  and No_reserva='$reserva'";
mysql_query("SET NAMES 'utf8'");
$JRSalas = mysql_query($query_JRSalas, $conexion) or die(mysql_error());
$row_JRSalas = mysql_fetch_assoc($JRSalas);
$totalRows_JRSalas = mysql_num_rows($JRSalas);
?>




<?php 
$totalsalas = mysql_num_rows($JRSalas);  
        
		
   if ($totalsalas > 0)  
    {  
       do {  
    

   $salas[0]=$row_JRSalas['sala'];

      for ($i=1; $i<$totalsalas; $i++) 
	  {  
       $NoSala = mysql_fetch_array($JRSalas);  
       $salas[$i] = $NoSala["sala"];  
      }  
	
   } while ($row_JRSalas = mysql_fetch_assoc($JRSalas));
   $rows = mysql_num_rows($JRSalas);
    if($rows > 0) {
      mysql_data_seek($JRSalas, 0);
	  $row_JRSalas = mysql_fetch_assoc($JRSalas);
     } 
  
    $cadenasalas=implode(',',$salas);
	mysql_free_result($JRSalas);
	 
  }
  
 
   // consulta que trae el numero de pcs que hay disponibles en la sala o salas
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRpcssala = "SELECT count(Nopc) As NoPcsSala FROM pcs WHERE numSala IN ($cadenasalas)";
	mysql_query("SET NAMES 'utf8'");
	$JRpcssala = mysql_query($query_JRpcssala, $conexion) or die(mysql_error());
	$row_JRpcssala = mysql_fetch_assoc($JRpcssala);
	$totalRows_JRpcssala = mysql_num_rows($JRpcssala);
    $pcsSala= $row_JRpcssala['NoPcsSala'];
	mysql_free_result($JRpcssala);
	
	
	
	// consulta que trae el numero de estudiante matriculados en una asignatura y un grupo
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRPcsMatriculados = "select count(codUsuario) As CompMatriculados from matricula where codAsignatura='$asignatura' and grupo=$grupo and    No_reserva='$reserva' and Estado='Activa'";
	
	mysql_query("SET NAMES 'utf8'");
	$JRPcsMatriculados = mysql_query($query_JRPcsMatriculados, $conexion) or die(mysql_error());
	$row_JRPcsMatriculados = mysql_fetch_assoc($JRPcsMatriculados);
	$totalRows_JRPcsMatriculados = mysql_num_rows($JRPcsMatriculados);
	$NoPcsMatriculados=$row_JRPcsMatriculados['CompMatriculados']/$totalRows_JRidhorario;
	mysql_free_result($JRPcsMatriculados);
	
	

     if($NoPcsMatriculados < $pcsSala)
	 {  
	   
		if($NoPcsMatriculados ==0)
		{ 
		
			mysql_select_db($database_conexion, $conexion);
			$query_JRPcs = "SELECT Nopc FROM pcs WHERE estado <> 'Docente' and numSala=$sala and estado='Activo' limit 1";
			$JRPcs = mysql_query($query_JRPcs, $conexion) or die(mysql_error());
			$row_JRPcs = mysql_fetch_assoc($JRPcs);
			$totalRows_JRPcs = mysql_num_rows($JRPcs);
			$pc=$row_JRPcs['Nopc'];
			echo $pc;
			mysql_free_result($JRPcs);
			
		}
		
		else if($NoPcsMatriculados > 0)
		{
			
		 mysql_select_db($database_conexion, $conexion);
		$query_JRAsignarpc = "select pc from matricula where codAsignatura='$asignatura' and grupo=$grupo and pc <> 0 and No_reserva= '$reserva' and Estado='Activa'";
		mysql_query("SET NAMES 'utf8'");
		$JRAsignarpc = mysql_query($query_JRAsignarpc, $conexion) or die(mysql_error());
		$row_JRAsignarpc = mysql_fetch_assoc($JRAsignarpc);
		$totalRows_JRAsignarpc = mysql_num_rows($JRAsignarpc);
	    
		
         do {  
		  
	
		   $pcs[0]=$row_JRAsignarpc['pc'];
	
			for ($i=1; $i<$totalRows_JRAsignarpc; $i++) 
			{  
			  $pcmatricula = mysql_fetch_array($JRAsignarpc);  
			  $pcs[$i] = $pcmatricula["pc"]; 
			}
		
		} while ($row_JRAsignarpc = mysql_fetch_assoc($JRAsignarpc));
		$rows = mysql_num_rows($JRAsignarpc);
		 if($rows > 0) {
		   mysql_data_seek($JRAsignarpc, 0);
		   $row_JRAsignarpc = mysql_fetch_assoc($JRAsignarpc);
		 } 
	     
		 $cadenapcs=implode(',',$pcs); 
	
		 mysql_free_result($JRAsignarpc);
		 
		 mysql_select_db($database_conexion, $conexion);
		$query_JRPcGenerado = "SELECT Nopc FROM pcs WHERE  Nopc NOT IN($cadenapcs) and numSala=$sala and estado <> 'Docente' and estado='Activo' LIMIT 1";
		$JRPcGenerado = mysql_query($query_JRPcGenerado, $conexion) or die(mysql_error());
		$row_JRPcGenerado = mysql_fetch_assoc($JRPcGenerado);
		$totalRows_JRPcGenerado = mysql_num_rows($JRPcGenerado);
		
				if($totalRows_JRPcGenerado > 0)
				{
				  echo $row_JRPcGenerado['Nopc'];
				  mysql_free_result($JRPcGenerado);
				}
				else if($totalRows_JRPcGenerado ==0)
				{
				  echo 1000; 	
				}
		
		}// cierro else
		
		
			
     }// cierro if
				
   
    else
    {  
	   // devuelve cero cuando ya no hay computadores para asignar
	   echo 0;
     }
	 
	mysql_close($conexion); 

?>