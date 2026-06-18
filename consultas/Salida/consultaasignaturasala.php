<?php require_once('../../Connections/conexion.php');?> 
<?php date_default_timezone_set("America/bogota"); ?>

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

$sala= $_POST['sala'];

$fecha=  date('Y'.'-'.'m'.'-'.'d');

mysql_select_db($database_conexion, $conexion);
$query_JRConsultaasig = "SELECT  codAsignatura, codGrupo FROM ingreso_salida WHERE fecha= '$fecha' and estado <> 1  and sala = $sala limit 1";
mysql_query("SET NAMES 'utf8'");
$JRConsultaasig = mysql_query($query_JRConsultaasig, $conexion) or die(mysql_error());
$row_JRConsultaasig = mysql_fetch_assoc($JRConsultaasig);
 $totalRows_JRConsultaasig = mysql_num_rows($JRConsultaasig);

if($totalRows_JRConsultaasig > 0){

$asignatura= $row_JRConsultaasig['codAsignatura'];
$grupo= $row_JRConsultaasig['codGrupo'];

mysql_select_db($database_conexion, $conexion);
$query_JRCasigsala = "select nomAsignatura from asignatura  where codAsignatura='$asignatura' 
";
mysql_query("SET NAMES 'utf8'");
$JRCasigsala = mysql_query($query_JRCasigsala, $conexion) or die(mysql_error());
$row_JRCasigsala = mysql_fetch_assoc($JRCasigsala);
$totalRows_JRCasigsala = mysql_num_rows($JRCasigsala);

$nombreasignatura= $row_JRCasigsala['nomAsignatura'];

$detalleasignatura[0]=$asignatura;
$detalleasignatura[1]=$grupo;
$detalleasignatura[2]=$nombreasignatura;

$cadenaasignatura=implode('-', $detalleasignatura);  
echo $cadenaasignatura;
}
else
{
  echo 0;
}

?>