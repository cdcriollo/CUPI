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


$dia= $_POST['dia'];
$sala= $_POST['sala'];
$horainicio= $_POST['horainicio'];
$horafinal= $_POST['horafinal'];
$idhorario= $_POST['idhorario'];
$fechainicial=implode('-',array_reverse(explode('-',$_POST['fechainicial'])));
$fechafinal=implode('-',array_reverse(explode('-',$_POST['fechafinal'])));



  $updateSQL = sprintf("UPDATE horario SET codDia=%s, horainicio=%s, horafinal=%s, sala=%s, fechaInicio=%s, fechaFinal=%s WHERE idHorario=%s",
                      
                       GetSQLValueString($dia, "int"),
                       GetSQLValueString($horainicio, "date"),
                       GetSQLValueString($horafinal, "date"),
                       GetSQLValueString($sala, "int"),
					   GetSQLValueString($fechainicial, "date"),
					   GetSQLValueString($fechafinal, "date"),
                       GetSQLValueString($idhorario, "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  
  if( $Result1==1)
  {
	echo 1;
  }
  else
  {
	 echo 0; 
  }



?>


