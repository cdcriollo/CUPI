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
$fechainicial=strtotime($_POST['fechaInicial']);
$fechafinal=strtotime($_POST['fechaFinal']);

if($horainicial < $horafinal && $fechainicial <= $fechafinal)
{

	mysql_select_db($database_conexion, $conexion);
	$query_JRConsHorario = "select codDia, horainicio,horafinal,sala from horario where sala=$sala and codDia=$dia and estadohorario <> 'inactivo'";
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
	$horainicion= $row_JRConsHorario ['horainicio'];
    $horafinaln= $row_JRConsHorario ['horafinal'];
	
	if($dia==$diam && $salam==$sala)
   
     if($horainiciom==$horainicial && $horafinalm== $horafinal){
	   echo 1;
	   break;
	 }
	 
	 else if($horainiciom < $horafinal &&  $horafinalm > $horainicial){
	    
	    echo 1;
	    break;
	 } 
	 
    } while ($row_JRConsHorario = mysql_fetch_assoc($JRConsHorario));
	
	mysql_free_result($JRConsHorario);
 }
}
else if($horainicial >= $horafinal && $fechainicial > $fechafinal)
{
   echo 2;	// las horas y las fechas no son correctas
}
else if($horainicial >= $horafinal )
{
  echo 3;// las horas no son correctas
}
else if($fechainicial > $fechafinal)
{
  echo 4;// las fechas no son correctas
}


?>

<?php ?>