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

function descripcionDia($diasemana)
{
	if($diasemana==1)
  {
	 $descripcion="Lunes";  
  }
  else if($diasemana==2)
  {
	$descripcion="Martes";  
  }
  else if($diasemana==3)
  {
	$descripcion="Miercoles";  
  }
  else if($diasemana==4)
  {
	$descripcion="Jueves";  
  }
  else if($diasemana==5)
  {
	$descripcion="Viernes";  
  }
  else if($diasemana==6)
  {
	$descripcion="Sabado";  
  }
  
  return $descripcion;
}

$asignatura= $_POST['asignatura'];
$grupo= $_POST['grupo'];
$usuario= $_POST['usuario'];
$reserva=$_POST['reserva'];
$cruce_no=0;

if(isset($_POST['asignatura'] , $_POST['grupo'],  $_POST['usuario'], $_POST['reserva']))
{

mysql_select_db($database_conexion, $conexion);
$query_JRCruceh = "select m.codAsignatura, m.grupo, h.horainicio, h.horafinal,h.codDia,h.sala,h.fechaInicio, h.fechaFinal from matricula m  inner join horario h on(m.idHorario= h.idHorario) where codUsuario=$usuario and m.Estado='Activa'";
mysql_query("SET NAMES 'utf8'");
$JRCruceh = mysql_query($query_JRCruceh, $conexion) or die(mysql_error());
$row_JRCruceh = mysql_fetch_assoc($JRCruceh);
$totalRows_JRCruceh = mysql_num_rows($JRCruceh);

if($totalRows_JRCruceh > 0)
{
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRHasignatura = "select codDia,sala,horainicio,horafinal,fechaInicio,fechaFinal from horario where codAsignatura='$asignatura' and codGrupo=$grupo and No_reserva='$reserva' and estadohorario='activo'";
	
	mysql_query("SET NAMES 'utf8'");
	$JRHasignatura = mysql_query($query_JRHasignatura, $conexion) or die(mysql_error());
	$row_JRHasignatura = mysql_fetch_assoc($JRHasignatura);
	$totalRows_JRHasignatura = mysql_num_rows($JRHasignatura);
	
	do { 

	   $dia= $row_JRHasignatura  ['codDia'];
	   $sala=$row_JRHasignatura  ['sala'];
	   $horainicio=strtotime($row_JRHasignatura['horainicio']);
	   $horafinal= strtotime($row_JRHasignatura['horafinal']);
	   $fechainicio=strtotime($row_JRHasignatura['fechaInicio']);
	   $fechafinal=strtotime($row_JRHasignatura['fechaFinal']);
	   
   

 do { 
 
    $diam= $row_JRCruceh ['codDia'];
    $salam= $row_JRCruceh ['sala'];
    $horainiciom= strtotime($row_JRCruceh ['horainicio']);
    $horafinalm= strtotime($row_JRCruceh ['horafinal']);
	$horainicionormal= $row_JRCruceh ['horainicio'];
    $horafinalnormal= $row_JRCruceh ['horafinal'];
	$fechainiciom= strtotime($row_JRCruceh ['fechaInicio']);
    $fechafinalm= strtotime($row_JRCruceh ['fechaFinal']);
	$fechainicionormal= $row_JRCruceh ['fechaInicio'];
    $fechafinalnormal= $row_JRCruceh ['fechaFinal'];
	$asignatura= $row_JRCruceh ['codAsignatura'];
    $grupo= $row_JRCruceh ['grupo'];
   
     if($dia==$diam  && $horainiciom==$horainicio && $horafinalm== $horafinal && $fechainicio==$fechainiciom && $fechafinal==$fechafinalm)
	 {
	
	   $diasemana=descripcionDia($diam);
	   $respuesta=array("error"=>1,"asignatura"=>$asignatura,"grupo"=>$grupo,"diasemana"=>$diasemana,"horainicio"=>$horainicionormal,"horafinal"=>       $horafinalnormal,"sala"=>$salam,"fechainicio"=>$fechainicionormal,"fechafinal"=> $fechafinalnormal);
	   $cruce_no=1;
	   echo json_encode($respuesta);
	   
	   break;
	 }
	 
	 else if($dia==$diam && $horainiciom < $horafinal &&  $horafinalm > $horainicio && $fechainiciom < $fechafinal && $fechafinalm > $fechainicio)
	 {
	    
	      $diasemana=descripcionDia($diam);
		  $respuesta=array("error"=>1,"asignatura"=>$asignatura,"grupo"=>$grupo,"diasemana"=>$diasemana,"horainicio"=>$horainicionormal,"horafinal"=>          $horafinalnormal,"sala"=>$salam,"fechainicio"=>$fechainicionormal,"fechafinal"=> $fechafinalnormal);
		  $cruce_no=1;
	      echo json_encode($respuesta);
	    
	   break;
	 }
	 
    } while ($row_JRCruceh = mysql_fetch_assoc($JRCruceh));
	
  } while ($row_JRHasignatura = mysql_fetch_assoc($JRHasignatura));
  
    mysql_free_result($JRHasignatura);


}

   if($cruce_no==0)
   {	
	 $respuesta=array("error"=>0);
	 echo json_encode($respuesta);
   }

}
	 
?>
    
<?php 

mysql_free_result($JRCruceh);
mysql_close($conexion);

?>