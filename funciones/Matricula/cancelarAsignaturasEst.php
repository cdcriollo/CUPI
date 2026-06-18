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

if(isset($_POST['arrayAsig'], $_POST['arrayGrupo'],$_POST['usuario'],$_POST['Arrayreservas']))

$asignaturas= explode(',',$_POST['arrayAsig']);
$grupos=explode(',',$_POST['arrayGrupo']);
$reserva=explode(',',$_POST['Arrayreservas']);
$usuario= $_POST['usuario'];


mysql_select_db($database_conexion, $conexion);

for($i=0; $i<count($asignaturas); $i++)
{
	$updateSQL ="update matricula set Estado='Cancelada' WHERE codAsignatura='$asignaturas[$i]' and grupo=$grupos[$i] and  codUsuario=$usuario and No_reserva ='$reserva[$i]'"; 
    $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
    
}

$FilasAfectadasmatricula=mysql_affected_rows();
  
if($FilasAfectadasmatricula > 0)
{
  echo 1;
}
else if($FilasAfectadasmatricula==0)
{
 echo 0;
}


?>








  