<?php require_once('../../Connections/conexion.php'); ?>
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

$estado=1;
$respuesta = array();
// se obtiene la hora de salida
$hora_entrega= date('H:i');
$codigo_ingreso= $_POST['Arraysalidausuarios'];
$computadores= $_POST['Arraycomputadores'];
$total_usuarios_salida=0;
$total_prestamos_actualizados=0;
$total_pcs_actualizados=0;
$total_recursos_actualizados=0;
$total_equipos_actualizados=0;


    /* Update estado salida usuario */
    $updateSQL ="UPDATE ingreso_salida SET horasalida= '$hora_entrega', estado=$estado WHERE codIngreso in ($codigo_ingreso)"; 
    mysql_select_db($database_conexion, $conexion);
    $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
    $total_usuarios_salida= mysql_affected_rows();
    
   /*Update hora de entrega tabla prestamorecursos */ 
   $actualizarprestamo = "UPDATE prestamorecursos SET horarecibido= '$hora_entrega' WHERE codIngreso in ( $codigo_ingreso)";              
   mysql_select_db($database_conexion, $conexion);
   $Result2 = mysql_query( $actualizarprestamo , $conexion) or die(mysql_error());
   $total_prestamos_actualizados= mysql_affected_rows(); 
   
    /*Update estado pcs  */
   $actualizarpcs = "UPDATE pcs SET estadoocupacion='disponible' WHERE Nopc in ($computadores)";              
   mysql_select_db($database_conexion, $conexion);
   $Result3 = mysql_query( $actualizarpcs , $conexion) or die(mysql_error());
   $total_pcs_actualizados= mysql_affected_rows(); 
   
   mysql_select_db($database_conexion, $conexion);
   $query_JRecursos = "SELECT d.Noinventario from prestamorecursos p, detalle_prestamo  d WHERE  d.idPrestamo= p.idPrestamo and p.codIngreso in ($codigo_ingreso) ";
   mysql_query("SET NAMES 'utf8'");
   $JRecursos = mysql_query($query_JRecursos, $conexion) or die(mysql_error());
   $row_JRecursos = mysql_fetch_assoc($JRecursos);
   $totalRows_JRecursos = mysql_num_rows($JRecursos);
   
   if ($totalRows_JRecursos > 0){ 
     
     while ($fila = mysql_fetch_array($JRecursos, MYSQL_NUM)) 
     {
      /*Update estado recursos  */
     $actualizarpcs = "UPDATE recursos SET estadoprestamo='disponible' WHERE Noinventario = $fila[0]";              
     mysql_select_db($database_conexion, $conexion);
     $Result4 = mysql_query( $actualizarpcs , $conexion) or die(mysql_error());
     $total_recursos_actualizados= mysql_num_rows($JRecursos);
   }   
 }
 
   mysql_select_db($database_conexion, $conexion);
   $query_JREquipos = "SELECT * from  equipos_externos where codIngreso in ($codigo_ingreso)";
   mysql_query("SET NAMES 'utf8'");
   $JREquipos = mysql_query($query_JREquipos, $conexion) or die(mysql_error());
   $row_JREquipos = mysql_fetch_assoc($JREquipos);
   $totalRows_JREquipos = mysql_num_rows($JREquipos);
   
   if ($totalRows_JREquipos){
     
       $actualizarequipos = "UPDATE equipos_externos SET horaretiro= '$hora_entrega' WHERE codIngreso in ($codigo_ingreso)";   
       mysql_select_db($database_conexion, $conexion);
       $Result5 = mysql_query(  $actualizarequipos , $conexion) or die(mysql_error());
       $total_equipos_actualizados= mysql_num_rows($JREquipos);
       
   }
   
$respuesta['exit_usuarios'] = $total_usuarios_salida;
$respuesta['prestamos_update'] = $total_prestamos_actualizados;
$respuesta['pcs_update'] = $total_pcs_actualizados;
$respuesta['recursos_update'] = $total_recursos_actualizados;
$respuesta['equipos_update'] = $total_equipos_actualizados;

header('Content-type: application/json; charset=utf-8');
echo json_encode($respuesta);
exit();
?>








  