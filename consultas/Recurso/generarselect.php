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


 mysql_select_db($database_conexion, $conexion);
 $query_JRSelects = "SELECT * from subgrupo WHERE idTipo = ".$_GET['id'];
 mysql_query("SET NAMES 'utf8'");
 $JRSelects = mysql_query($query_JRSelects, $conexion) or die(mysql_error());
 $row_JRSelects = mysql_fetch_assoc($JRSelects);
 $totalRows_JRSelects = mysql_num_rows($JRSelects);

 if ($totalRows_JRSelects > 0){
	 echo '<option value="'.$row_JRSelects['idsubtipo'].'">'.$row_JRSelects['descripcionSubtipo'].'</option>';
	while ($fila = mysql_fetch_array($JRSelects)) {
        echo '<option value="'.$fila['idsubtipo'].'">'.$fila['descripcionSubtipo'].'</option>';
    };
	
	
 }
 
 mysql_free_result($JRSelects);
 mysql_close($conexion);
 
?>
