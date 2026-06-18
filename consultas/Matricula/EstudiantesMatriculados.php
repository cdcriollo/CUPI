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

 if(isset($_POST['asignatura'], $_POST['grupo'],  $_POST['reserva']))
 {
	$asignatura=$_POST['asignatura'];
	$grupo=$_POST['grupo'];
	$reserva= $_POST['reserva'];

    mysql_select_db($database_conexion, $conexion);
	$query_JRPcsMatriculados = "select distinct codUsuario from matricula where codAsignatura='$asignatura' and grupo= $grupo and No_reserva= '$reserva' and    Estado='Activa'";
	mysql_query("SET NAMES 'utf8'");
	$JRPcsMatriculados = mysql_query($query_JRPcsMatriculados, $conexion) or die(mysql_error());
	$row_JRPcsMatriculados = mysql_fetch_assoc($JRPcsMatriculados);
	$totalRows_JRPcsMatriculados = mysql_num_rows($JRPcsMatriculados);
	
	$response=array("Totalmatriculados"=> $totalRows_JRPcsMatriculados);
	echo json_encode($response);
	
	mysql_free_result($JRPcsMatriculados);
    mysql_close($conexion);
	
 }?>