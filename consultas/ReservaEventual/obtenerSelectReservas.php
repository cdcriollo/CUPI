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


$codigo=$_POST['codigo'];
$grupo=$_POST['grupo'];


    mysql_select_db($database_conexion, $conexion);
	$query_JRConsultarreserva = "SELECT No_reserva FROM reserva_eventual WHERE cod_asignatura='$codigo' AND grupo= $grupo order by id
	";
	mysql_query("SET NAMES 'utf8'");
	$JRConsultarreserva = mysql_query($query_JRConsultarreserva, $conexion) or die(mysql_error());
	$row_JRConsultarreserva = mysql_fetch_assoc($JRConsultarreserva);
	$totalRows_JRConsultarreserva = mysql_num_rows($JRConsultarreserva);


	if($totalRows_JRConsultarreserva > 0 )
	{?>
		 <select id="reservas" size="1">
		 <?php do
		 {  
			  $reserva=$row_JRConsultarreserva['No_reserva'];?> 
              
                 <option value="<?php echo $reserva ?>"><?php echo $reserva ?></option>
			 
		
		 <?php } while($row_JRConsultarreserva = mysql_fetch_assoc($JRConsultarreserva)) ?>
		 </select>
	<?php }
	
	?>
	
    
	<?php
	mysql_free_result($JRConsultarreserva);
	mysql_close($conexion);
	?>
 
