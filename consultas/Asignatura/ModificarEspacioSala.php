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

$dia=$_POST['dia'];
$sala=$_POST['sala'];
$horainicial=strtotime($_POST['horaI']);
$horafinal=strtotime($_POST['horaF']);
$idHorario=$_POST['horario'];
$fechainicial=strtotime($_POST['fechainicial']);
$fechafinal=strtotime($_POST['fechafinal']);

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


if($horainicial < $horafinal )
{

	mysql_select_db($database_conexion, $conexion);
	$query_JRConsHorario = "select codDia, codAsignatura,codGrupo, horainicio,horafinal,sala,fechaInicio,fechaFinal from horario where sala=$sala and codDia=$dia and idHorario NOT IN($idHorario) and  estadohorario <> 'inactivo'";
	mysql_query("SET NAMES 'utf8'");
	$JRConsHorario = mysql_query($query_JRConsHorario, $conexion) or die(mysql_error());
	$row_JRConsHorario = mysql_fetch_assoc($JRConsHorario);
	$totalRows_JRConsHorario = mysql_num_rows($JRConsHorario);



if($totalRows_JRConsHorario > 0)
{

  do { 
 
    $diam= $row_JRConsHorario ['codDia'];
    $salam=$row_JRConsHorario ['sala'];
    $horainiciom= strtotime($row_JRConsHorario ['horainicio']);
    $horafinalm= strtotime($row_JRConsHorario ['horafinal']);
	$fechainiciom= strtotime($row_JRConsHorario ['fechaInicio']);
    $fechafinalm= strtotime($row_JRConsHorario ['fechaFinal']);
	$asignatura=$row_JRConsHorario ['codAsignatura'];
	$grupo=$row_JRConsHorario ['codGrupo'];
	$horainicionormal=$row_JRConsHorario ['horainicio'];
    $horafinalnormal=$row_JRConsHorario ['horafinal'];
	
	
	if($dia==$diam && $salam==$sala)
   
     if($horainiciom==$horainicial && $horafinalm== $horafinal && $fechainiciom==$fechainicial && $fechafinalm==$fechafinal){
		 
	   $diasemana=descripcionDia($diam);
	   $respuesta[0]=1;
	   $respuesta[1]=$asignatura;
	   $respuesta[2]=$grupo;
	   $respuesta[3]=$diasemana;
	   $respuesta[4]=$horainicionormal;
	   $respuesta[5]=$horafinalnormal; 
	   $respuesta[6]=$salam;
	   $cadenarespuesta= implode('-',$respuesta);
	   echo $cadenarespuesta;
	   break;
	 }
	 
	 else if($horainiciom < $horafinal &&  $horafinalm > $horainicial && $fechainiciom < $fechafinal && $fechafinalm > $fechainicial){
	    
	   $diasemana=descripcionDia($diam);
	   $respuesta[0]=1;
	   $respuesta[1]=$asignatura;
	   $respuesta[2]=$grupo;
	   $respuesta[3]=$diasemana;
	   $respuesta[4]=$horainicionormal;
	   $respuesta[5]=$horafinalnormal; 
	   $respuesta[6]=$salam;
	   $cadenarespuesta= implode('-',$respuesta);
	   echo $cadenarespuesta;
	   break;
	 } 
	 
    } while ($row_JRConsHorario = mysql_fetch_assoc($JRConsHorario));
	
	mysql_free_result($JRConsHorario);
	
 }
}
else
{
   echo 2;	
}


?>

<?php mysql_close($conexion);?>