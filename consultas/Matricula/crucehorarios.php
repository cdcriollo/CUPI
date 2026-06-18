
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
$recorrerArray=$_POST['arregloMatricula'];
$horarios= array();
$respuesta=array();

mysql_select_db($database_conexion, $conexion);
$query_JRCruceh = "select distinct m.codAsignatura, m.grupo, h.horainicio, h.horafinal,h.codDia,h.sala from matricula m inner join horario h on(m.idHorario= h.idHorario) where codUsuario=$usuario and m.Estado='Activa'";
mysql_query("SET NAMES 'utf8'");
$JRCruceh = mysql_query($query_JRCruceh, $conexion) or die(mysql_error());
$row_JRCruceh = mysql_fetch_assoc($JRCruceh);
$totalRows_JRCruceh = mysql_num_rows($JRCruceh);

if($totalRows_JRCruceh > 0)
{
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRHasignatura = "select codDia,sala,horainicio,horafinal from horario where codAsignatura='$asignatura' and codGrupo=$grupo and estadohorario='activo'";
	
	mysql_query("SET NAMES 'utf8'");
	$JRHasignatura = mysql_query($query_JRHasignatura, $conexion) or die(mysql_error());
	$row_JRHasignatura = mysql_fetch_assoc($JRHasignatura);
	$totalRows_JRHasignatura = mysql_num_rows($JRHasignatura);

   $dia= $row_JRHasignatura  ['codDia'];
   $sala=$row_JRHasignatura  ['sala'];
   $horainicio=strtotime($row_JRHasignatura['horainicio']);
   $horafinal= strtotime($row_JRHasignatura['horafinal']);
   

 do { 
 
    $diam= $row_JRCruceh ['codDia'];
    $salam= $row_JRCruceh ['sala'];
    $horainiciom= strtotime($row_JRCruceh ['horainicio']);
    $horafinalm= strtotime($row_JRCruceh ['horafinal']);
	$horainicionormal= $row_JRCruceh ['horainicio'];
    $horafinalnormal= $row_JRCruceh ['horafinal'];
	$asignatura= $row_JRCruceh ['codAsignatura'];
    $grupo= $row_JRCruceh ['grupo'];
   
     if($dia==$diam  && $horainiciom==$horainicio && $horafinalm== $horafinal){
		 
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
	 
	 else if($dia==$diam && $horainiciom < $horafinal &&  $horafinalm > $horainicio){
		 
	    $diasemana=descripcionDia($diam);
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
	 
    } while ($row_JRCruceh = mysql_fetch_assoc($JRCruceh));
}

 else if($totalRows_JRCruceh==0)
 {
	
	if($recorrerArray==1)
	{
		mysql_select_db($database_conexion, $conexion);
		$query_JRHasignatura = "select codDia,sala,horainicio,horafinal from horario where codAsignatura='$asignatura' and codGrupo=$grupo and estadohorario='activo'";
		mysql_query("SET NAMES 'utf8'");
		$JRHasignatura = mysql_query($query_JRHasignatura, $conexion) or die(mysql_error());
		$row_JRHasignatura = mysql_fetch_assoc($JRHasignatura);
		$totalRows_JRHasignatura = mysql_num_rows($JRHasignatura);
	
	
	   $dia= $row_JRHasignatura  ['codDia'];
	   $sala=$row_JRHasignatura  ['sala'];
	   $horainicio=strtotime($row_JRHasignatura['horainicio']);
	   $horafinal= strtotime($row_JRHasignatura['horafinal']);
	   
	   $cadenamatriculas=explode(',',$_POST['matriculausu']);
   
		$j=0;
		
		for($i=4; $i<count($cadenamatriculas);$i+=5)
		{
		   $horarios[$j]=$cadenamatriculas[$i];	
		   $j++;	
		}
		
		$cadenaHorarios=implode(',',$horarios);
		
		
		mysql_select_db($database_conexion, $conexion);
	   $query_JRCHorarios = "SELECT codDia, horainicio, horafinal, codAsignatura,codGrupo,sala  FROM horario WHERE idHorario IN ($cadenaHorarios) and estadohorario='activo'";
	   mysql_query("SET NAMES 'utf8'");
	   $JRCHorarios = mysql_query($query_JRCHorarios, $conexion) or die(mysql_error());
	   $row_JRCHorarios = mysql_fetch_assoc($JRCHorarios);
	   $totalRows_JRCHorarios = mysql_num_rows($JRCHorarios);
   
	   do { 
	 
		$diam= $row_JRCHorarios ['codDia'];
		$salam= $row_JRCHorarios ['sala'];
		$horainiciom= strtotime($row_JRCHorarios ['horainicio']);
		$horafinalm= strtotime($row_JRCHorarios ['horafinal']);
		$horainicionormal= $row_JRCHorarios ['horainicio'];
		$horafinalnormal= $row_JRCHorarios ['horafinal'];
		$asignatura= $row_JRCHorarios ['codAsignatura'];
		$grupo= $row_JRCHorarios ['codGrupo'];
   
	   
		 if($dia==$diam  && $horainiciom==$horainicio && $horafinalm== $horafinal){
			 
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
		 
		 else if($dia==$diam && $horainiciom < $horafinal &&  $horafinalm > $horainicio){
			
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
		 
		} while ($row_JRCHorarios = mysql_fetch_assoc($JRCHorarios));
		
		mysql_free_result($JRHasignatura);
		mysql_free_result($JRCHorarios);
		
   
   }
	
}
	 
?>
    
<?php 

mysql_free_result($JRCruceh);

?>