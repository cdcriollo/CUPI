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

$reserva=$_POST['Numreserva'];

mysql_select_db($database_conexion, $conexion);
$query_JRConsultarreserva = "SELECT * FROM reserva_eventual WHERE No_reserva = '$reserva'";
mysql_query("SET NAMES 'utf8'");
$JRConsultarreserva = mysql_query($query_JRConsultarreserva, $conexion) or die(mysql_error());
$row_JRConsultarreserva = mysql_fetch_assoc($JRConsultarreserva);
$totalRows_JRConsultarreserva = mysql_num_rows($JRConsultarreserva);



if($totalRows_JRConsultarreserva > 0 ){
	
	$codasig=$row_JRConsultarreserva['cod_asignatura'];
	$grupo=$row_JRConsultarreserva['grupo'];
	$codresp= $row_JRConsultarreserva['cod_responsable'];
	$nomresp= $row_JRConsultarreserva['nombre_responsable'];
	$nomasig= $row_JRConsultarreserva['nombre_asignatura'];
	$fecha= $row_JRConsultarreserva['fecha_reserva'];
	$email= $row_JRConsultarreserva['email'];
	$internet=$row_JRConsultarreserva['internet'];
	
	$data = array("error"=>1,"codasig" => $codasig, "grupo" => $grupo, "codresp"=>$codresp,"nomresp"=>$nomresp,"nomasig"=>$nomasig,"fecha"=>$fecha,"email"=>$email,"internet"=>$internet);
	
	echo json_encode($data);
}
else
{
   $data = array("error"=>0);
   echo json_encode($data);
   	
}


?>

<?php
mysql_free_result($JRConsultarreserva);
mysql_close($conexion);
?>
