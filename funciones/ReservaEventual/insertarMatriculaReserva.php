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

  // Obtengo los datos enviados por POST
  $codigoAsignatura=$_POST['codigoA'];
  $codigoUsuario=$_POST['codigoU'];
  $grupo=$_POST['grupo'];
  $pc= $_GET['pc'];
  $reserva=$_POST['reserva'];
  $horario= $_POST['horarioU'];
  
  // Convierto un array de strings a un array de posiciones 
  $horarioAsignatura=explode(",",$horario);
  
  // recorro los horarios de las asignaturas y creo una matricula por cada uno de los horarios que tenga la asignatura
  for($i=0; $i<=count($horarioAsignatura)-1; $i++)
  {
  	  // Ejecuto la insercion de los datos 
	  $insertSQL = sprintf("INSERT INTO matricula (codUsuario, codAsignatura, pc, grupo, idHorario, No_reserva) VALUES (%s,%s,%s,%s,%s,%s)",
	  GetSQLValueString($codigoUsuario, "int"),
	  GetSQLValueString($codigoAsignatura, "text"),
	  GetSQLValueString($pc, "int"),
	  GetSQLValueString($grupo, "int"),
	  GetSQLValueString($horarioAsignatura[$i], "int"),
	  GetSQLValueString($reserva, "text"));
						   
	  mysql_select_db($database_conexion, $conexion);
	  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }


  // si el resultado de la inserción devuelve mas de un resultado imprimo 1 de lo contario imprimo 0 y esto se envia como respuesta al ajax	   
  if($Result1 > 0)
  {
	 echo 1;   
  }
  else
  {
    echo 0;
  }
   
?>

