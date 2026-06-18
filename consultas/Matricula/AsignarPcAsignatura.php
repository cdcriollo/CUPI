<?php require_once('../../Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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
$estudiantesMatriculadosTemp=$_POST['EstMat'];
 
	
	// consulta que trae el numero de pcs que hay disponibles en la sala
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRpcssala = "SELECT count(Nopc) As NoPcsSala FROM pcs WHERE numSala= $sala";
	mysql_query("SET NAMES 'utf8'");
	$JRpcssala = mysql_query($query_JRpcssala, $conexion) or die(mysql_error());
	$row_JRpcssala = mysql_fetch_assoc($JRpcssala);
	$totalRows_JRpcssala = mysql_num_rows($JRpcssala);
	$pcsSala= $row_JRpcssala['NoPcsSala'];
	mysql_free_result($JRpcssala);

	    
	mysql_select_db($database_conexion, $conexion);
	$query_JRPc = "SELECT Nopc FROM pcs WHERE estado <> 'Docente' and numSala=$sala and estado='No asignado' LIMIT 1";
	mysql_query("SET NAMES 'utf8'");
	$JRPc = mysql_query($query_JRPc, $conexion) or die(mysql_error());
	$row_JRPc = mysql_fetch_assoc($JRPc);
	$totalRows_JRPc = mysql_num_rows($JRPc);
				
    if($totalRows_JRPc > 0)
    {
		echo $pcAsignado=$row_JRPc['Nopc'];
		mysql_free_result($JRPc);
						 
		// actualiza en la tabla pcs el estado del computador
		mysql_select_db($database_conexion, $conexion);
		$updateSQL = "UPDATE pcs SET estado='asignado' where numSala= $sala and Nopc=$pcAsignado";
		mysql_query("SET NAMES 'utf8'");
		$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error()); 
		    
    }// cierro if
				
    else
   {  
	  // devuelve cero cuando ya no hay computadores para asignar
	 echo 0;
   } 
					 
 mysql_close($conexion);				

?>
