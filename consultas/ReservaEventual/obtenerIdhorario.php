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


function MostrarDia($codDia){

switch ($codDia) {
    case 1:
	    $descripcion="Lunes";
        break;
    case 2:
	    $descripcion="Martes";
        break;
    case 3:
        $descripcion="Miercoles";
      break;
	  case 4:
        $descripcion="Jueves";
      break;
	  case 5:
        $descripcion="Viernes";
      break;
	  case 6:
        $descripcion="Sabado";
      break;
}

return $descripcion;
}

$asignatura=$_POST['asignatura'];
$grupo=$_POST['grupo'];
$sala=$_POST['sala'];
$reserva=$_POST['reserva'];

mysql_select_db($database_conexion, $conexion);
$query_JRidhorario = "SELECT idHorario FROM horario WHERE codAsignatura = '$asignatura' and codGrupo=$grupo AND sala=$sala AND No_reserva='$reserva' AND estadohorario='activo' order by idHorario";
mysql_query("SET NAMES 'utf8'");
$JRidhorario = mysql_query($query_JRidhorario, $conexion) or die(mysql_error());
$row_JRidhorario = mysql_fetch_assoc($JRidhorario);
$totalRows_JRidhorario = mysql_num_rows($JRidhorario);


     do {  
		  ?>
		  <?php
	
		   $horarios[0]=$row_JRidhorario['idHorario'];
	
			for ($i=1; $i<$totalRows_JRidhorario; $i++) 
			{  
			 $horariosala = mysql_fetch_array($JRidhorario);  
			 $horarios[$i] = $horariosala["idHorario"];  
		   }  
		 ?>
		<?php
		} while ($row_JRidhorario = mysql_fetch_assoc($JRidhorario));
		$rows = mysql_num_rows($JRidhorario);
		 if($rows > 0) {
		   mysql_data_seek($JRidhorario, 0);
		   $row_JRidhorario = mysql_fetch_assoc($JRidhorario);
		 } 
	  
		 echo $cadenaHorarios=implode(',',$horarios); 
		 

?>
<?php
 mysql_free_result($JRidhorario);
 mysql_close($conexion);
?>