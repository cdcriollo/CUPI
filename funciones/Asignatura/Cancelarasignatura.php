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

// Determina sila cancelacion de la reserva de la asignatura se hace por una asignatura en especifico o varias asignaturas a la vez
$opcion=$_POST['opcion'];
$horarios= $_POST['horarios'];
$reservas= $_POST['reservas'];

// array que contiene la respuesta del servidor y el numero de filas afectadas
$respuesta=array();


// cancela la reserva de una asignatura en especifico
if ($opcion==1)
{
	$codigo=$_POST['codigo'];
    $grupo=$_POST['grupo'];
	
	
	// realiza una consulta a la tabla horarios para determinar si existe la reserva de la asignatura
	mysql_select_db($database_conexion, $conexion);
	$query_JRHorarios1 = "SELECT H.idHorario,H.codDia, H.horainicio, H.horafinal, H.fechaInicio, H.fechaFinal,H.sala,H.estadohorario, H.codGrupo, H.codAsignatura, A.nomAsignatura FROM horario H inner join    asignatura A ON (H.codAsignatura=A.codAsignatura) WHERE H.codAsignatura='$codigo' and H.codGrupo='$grupo' order by H.codGrupo";
	mysql_query("SET NAMES 'utf8'");
	$JRHorarios1 = mysql_query($query_JRHorarios1, $conexion) or die(mysql_error());
	$row_JRHorarios1 = mysql_fetch_assoc($JRHorarios1);
	$totalRows_JRHorarios1 = mysql_num_rows($JRHorarios1);
	
	
	if ($totalRows_JRHorarios1 > 0 )
	{ 
	       
		// Actualiza el estadohorario de la tabla horario colocandolo en inactivo
		mysql_select_db($database_conexion, $conexion);
	    $updateProgAsigGrupo = "UPDATE horario SET estadohorario= 'inactivo' WHERE idHorario IN($horarios)";
		
					   
		$Result1 = mysql_query($updateProgAsigGrupo, $conexion) or die(mysql_error());
		// Obtengo el numero de filas afectadas por la actualizacion
		$FilasAfectadasHorario=mysql_affected_rows();
	
	    if($Result1 > 0)
	    {
		    $respuesta[0]=1;// asigno 1 como una respuesta afirmativa de la actualizacion
			$respuesta[1]=$FilasAfectadasHorario;// asigno el numero de filas afectadas del horario 
	    }
	   
	    else if($Result1==0) 
	    {
		    $respuesta[0]=0;// asigno 0 como una respuesta negativa de la actualizacion
			$respuesta[1]=$FilasAfectadasHorario;// asigno el numero de filas afectadas del horario
		}
	
		
	     // cambia el estado de la matricula a inactiva
		 mysql_select_db($database_conexion, $conexion);
	    $updateMatAsigGrupo = "UPDATE matricula SET Estado= 'inactiva' WHERE idHorario IN($horarios)";
		$Result2 = mysql_query($updateMatAsigGrupo, $conexion) or die(mysql_error());
	    $filasafectadasMatricula=mysql_affected_rows();
		 
	    if($Result2 > 0)
	    {
		  $respuesta[2]=1; //asigno 1 como una respuesta afirmativa de la actualizacion
		  $respuesta[3]=$filasafectadasMatricula;// asigno el numero de filas afectadas de la matricula 
	    }
	   
	    else if($Result2==0)
	    {
		   $respuesta[2]=0;// asigno 0 como una respuesta negativa de la actualizacion
		   $respuesta[3]=$filasafectadasMatricula; // asigno el numero de filas afectadas de la matricula 
		}
		
		// cambia el estado de la reserva a inactiva
		 mysql_select_db($database_conexion, $conexion);
	    $updateMatAsigReserva = "UPDATE reserva_eventual SET estado= 'inactiva' WHERE id IN($reservas)";
		$Result3 = mysql_query($updateMatAsigReserva, $conexion) or die(mysql_error());
	    $filasafectadasreserva=mysql_affected_rows();
		 
	    if($Result3 > 0)
	    {
		  $respuesta[4]=1; //asigno 1 como una respuesta afirmativa de la actualizacion
		  $respuesta[5]=$filasafectadasreserva;// asigno el numero de filas afectadas de la matricula 
	    }
	   
	    else if($Result3==0)
	    {
		   $respuesta[4]=0;// asigno 0 como una respuesta negativa de la actualizacion
		   $respuesta[5]=$filasafectadasreserva; // asigno el numero de filas afectadas de la matricula 
		}
		
		// imprimo la cadena que sera enviada al javascript
		echo $cadenaRespuesta=implode('-', $respuesta);
		
   }
  
  else 
  {
	echo 0; // la consulta no arrojo resultados 
  }
	
}

else if ($opcion==2)
{
   $fechainicial=implode('-',array_reverse(explode('-',$_POST['fechainicial'])));
   $fechafinal=implode('-',array_reverse(explode('-',$_POST['fechafinal'])));
   
   // realiza una consulta sobre la tabla horario dado un rango de fechas
   mysql_select_db($database_conexion, $conexion);
	$query_JRHorarios = "SELECT H.idHorario,H.codDia, H.horainicio, H.horafinal, H.fechaInicio, H.fechaFinal,H.sala, H.estadohorario, H.codGrupo, H.codAsignatura, A.nomAsignatura FROM horario H  inner join asignatura A ON (H.codAsignatura=A.codAsignatura) WHERE H.fechaInicio='$fechainicial' and H.fechaFinal='$fechafinal' order by H.codGrupo";
	mysql_query("SET NAMES 'utf8'");
	$JRHorarios = mysql_query($query_JRHorarios, $conexion) or die(mysql_error());
	$row_JRHorarios = mysql_fetch_assoc($JRHorarios);
	$totalRows_JRHorarios = mysql_num_rows($JRHorarios);


?>

 <?php if ($totalRows_JRHorarios > 0 )
 { 
 	   
           mysql_select_db($database_conexion, $conexion);
           $updateProgAsignaturas = "UPDATE horario SET estadohorario= 'inactivo' WHERE idHorario IN ($horarios)";
           $Result4 = mysql_query($updateProgAsignaturas, $conexion) or die(mysql_error());
		   // obtengo el numero de filas afectadas del horario
		   $FilasAfectadasHorario=mysql_affected_rows();

		if($Result4 > 0)
		{
		    $respuesta[0]=1;// devuelvo 1 en caso afirmativo de la actualizacion
			$respuesta[1]=$FilasAfectadasHorario;// asigno el numero de filas afectadas por la actualizacion
		}
		else if($Result4==0)
		{
		    $respuesta[0]=0;// devuelvo 0 como una respuesta negativa de la actualizacion
			$respuesta[1]=$FilasAfectadasHorario;// asigno el numero de filas afectadas por la actualizacion
		}
		
	     // cambia el estado de la matricula a inactiva
		  mysql_select_db($database_conexion, $conexion);
	     $updateMatAsignaturas = "UPDATE matricula SET Estado= 'inactiva' WHERE idHorario IN ($horarios) ";
		 $Result5 = mysql_query($updateMatAsignaturas, $conexion) or die(mysql_error());
		 $filasafectadasMatricula=mysql_affected_rows();
	
	    if($Result5 > 0)
	    {
		  $respuesta[2]=1;// devuelvo 1 como respuesta afirmativa de la actualizacion
		  $respuesta[3]=$filasafectadasMatricula;// asigno el numero de filas afectadas por la actualizacion
	    }
	   
	    else if($Result5 ==0)
	    {
		   $respuesta[2]=0;// devuelvo 0 como respuesta negativa de la actualizacion
		   $respuesta[3]=$filasafectadasMatricula;// asigno el numero de filas afectadas por la actualizacion 
		}
		
		// cambia el estado de la reserva a inactiva
		 mysql_select_db($database_conexion, $conexion);
	    $updateMatAsigReserva = "UPDATE reserva_eventual SET estado= 'inactiva' WHERE id IN($reservas)";
		$Result6 = mysql_query($updateMatAsigReserva, $conexion) or die(mysql_error());
		$filasafectadasreserva=mysql_affected_rows();
		
		 if($Result6 > 0)
	    {
		  $respuesta[4]=1;// devuelvo 1 como respuesta afirmativa de la actualizacion
		  $respuesta[5]=$filasafectadasreserva;// asigno el numero de filas afectadas por la actualizacion
	    }
	   
	    else if($Result6 ==0)
	    {
		   $respuesta[4]=0;// devuelvo 0 como respuesta negativa de la actualizacion
		   $respuesta[5]=$filasafectadasreserva;// asigno el numero de filas afectadas por la actualizacion 
		}
		
		// imprimo la cadena que sera enviada por javascript
		echo $cadenaRespuesta=implode('-', $respuesta);
			
  }// cierro if
  else
  {
	echo 0;
  }
}// cierro if opcion

?>

