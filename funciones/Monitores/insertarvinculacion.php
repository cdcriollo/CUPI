<?php require_once('../../Connections/conexion.php'); 
  date_default_timezone_set("America/bogota"); 
?>

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

// Capturo las variables enviadas por POST
$cedula=$_POST['cedula'];
$comienzo=$_POST['comienzo'];
$finalizacion=$_POST['finalizacion'];
$valorhora=$_POST['valorhora'];
$arrayturnos=$_POST['arrayturnos'];
$horassemestre=$_POST['horassemestre'];
$totalvinculacion=$_POST['totalvinculacion'];
$ano=date('Y');
$vinculacion="VM";


if( isset ($_POST['cedula'], $_POST['comienzo'], $_POST['finalizacion'], $_POST['valorhora'],$_POST['arrayturnos'],$_POST['horassemestre'],$_POST['totalvinculacion']))
{

    $insertSQL = sprintf("INSERT INTO vinculacion_monitor (cedula, comienzo, finalizacion, total_horas_semestre, valor_hora_monitor, valor_total_vinculacion) VALUES (%s,%s,%s,%s,%s,%s)",
	
                       GetSQLValueString($cedula, "text"),
					   GetSQLValueString(implode('-',array_reverse(explode('-',$comienzo))), "date"),
					   GetSQLValueString(implode('-',array_reverse(explode('-',$finalizacion))), "date"),
                       GetSQLValueString($horassemestre, "int"),
					   GetSQLValueString($valorhora, "int"),
                       GetSQLValueString($totalvinculacion, "int"));
					  
	
   mysql_select_db($database_conexion, $conexion);
   mysql_query("SET NAMES 'utf8'");
   $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
   $idvinculacion = mysql_insert_id();
   $nuevoid_vinculacion= $vinculacion.$idvinculacion."-".$ano;
   
    mysql_select_db($database_conexion, $conexion);
    $updateSQL = "UPDATE vinculacion_monitor SET No_vinculacion= '$nuevoid_vinculacion' WHERE idvinculacion= '$idvinculacion'";
    mysql_query("SET NAMES 'utf8'");
    $Result2 = mysql_query($updateSQL, $conexion) or die(mysql_error());

		
 
  $vectorturnos=explode(',',$_POST['arrayturnos']);
   
 
  
	  for($i=0; $i<count($vectorturnos)-1;$i+=4)
	  {
		    
   $insertSQL = sprintf("INSERT INTO turnos_monitor (dia, hora_entrada, hora_salida, actividad, cedula, No_vinculacion) VALUES (%s, %s, %s, %s, %s, %s)",
                       
                       GetSQLValueString($vectorturnos[$i], "int"),
                       GetSQLValueString($vectorturnos[$i+1], "date"),
                       GetSQLValueString($vectorturnos[$i+2], "date"),
					   GetSQLValueString($vectorturnos[$i+3], "text"),
					   GetSQLValueString($cedula, "text"),
					   GetSQLValueString($nuevoid_vinculacion, "text"));
                    
  mysql_select_db($database_conexion, $conexion);
  $Result3 = mysql_query($insertSQL, $conexion) or die(mysql_error());
 
	}
   
  
  if($Result1 > 0 && $Result2 > 0 && $Result3 > 0 )
  {
	  $respuesta=array("error"=>0,"No_vinculacion"=> $nuevoid_vinculacion);
	  echo json_encode($respuesta); 
  }
  
  else
  {
	   $respuesta=array("error"=>1);
	  echo json_encode($respuesta); 
	  
  }
 
}// cierro isset
  
?>

