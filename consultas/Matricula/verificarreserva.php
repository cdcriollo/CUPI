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

if(isset($_POST['asignatura'], $_POST['grupo']))
{
   $asignatura= trim($_POST['asignatura']);
   $grupo= trim($_POST['grupo']);
  
    mysql_select_db($database_conexion, $conexion);
	$query_JRHasignatura = "select No_reserva from reserva_eventual where cod_Asignatura='$asignatura' and grupo=$grupo";
	mysql_query("SET NAMES 'utf8'");
	$JRHasignatura = mysql_query($query_JRHasignatura, $conexion) or die(mysql_error());
	$row_JRHasignatura = mysql_fetch_assoc($JRHasignatura);
	$totalRows_JRHasignatura = mysql_num_rows($JRHasignatura);
	
	if($totalRows_JRHasignatura > 0)
	{
		$response=array("error"=>0);
		echo json_encode($response);
	}
	else if($totalRows_JRHasignatura == 0)
	{
		$response=array("error"=>1);
		echo json_encode($response);
	}

    mysql_free_result($JRHasignatura);
	mysql_close($conexion);
	
}
?>
