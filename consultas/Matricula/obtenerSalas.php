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


if(isset($_POST['codigo'], $_POST['grupo'], $_POST['reserva']))
{


$codigo=$_POST['codigo'];
$grupo= $_POST['grupo'];
$reserva=$_POST['reserva'];

mysql_select_db($database_conexion, $conexion);
$query_JRSalas = "SELECT distinct sala From horario where codAsignatura='$codigo' and codGrupo=$grupo and No_reserva='$reserva' and estadohorario='activo'";
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
    ?>
   <?php

     $salas[0]=$row_JRSalas['sala'];

      for ($i=1; $i<$totalsalas; $i++) 
	  {  
       $NoSala = mysql_fetch_array($JRSalas);  
       $salas[$i] = $NoSala["sala"];  
      }  
	?>
   <?php
   } while ($row_JRSalas = mysql_fetch_assoc($JRSalas));
   $rows = mysql_num_rows($JRSalas);
    if($rows > 0) {
      mysql_data_seek($JRSalas, 0);
	  $row_JRSalas = mysql_fetch_assoc($JRSalas);
     } 
	
    $cadenasalas=implode(',',$salas);  
    echo $cadenasalas;
       
}// Cierro if 
else
{
  echo 0;	
}
	
		
?>


<?php
 mysql_free_result($JRSalas);
 mysql_close($conexion);
?>

<?php } ?>

