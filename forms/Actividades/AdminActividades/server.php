<?php require_once("../../../Connections/conexion.php");

	  
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

$oper = $_POST['oper'];//ADD , EDIT OR DEL
if($oper == 'add') {
	

	  $insertSQL = sprintf("INSERT INTO actividades (Descripcion) VALUES (%s)",                       
      GetSQLValueString($_POST['Descripcion'], "text"));
					   
      mysql_select_db($database_conexion, $conexion);
	  mysql_query("SET NAMES 'utf8'");
	  $Result1 = mysql_query($insertSQL, $conexion); //or die(mysql_error());
	  
	  $response->query = $Result1;//done si es true , mal si es false ;(
	  echo json_encode($response);

 
}
else if($oper=='edit')
{
	
	
		  $updateSQL = sprintf("UPDATE actividades SET Descripcion=%s WHERE idActividad=%s",
          GetSQLValueString($_POST['Descripcion'], "text"),
          GetSQLValueString($_POST['id'], "int"));
		  mysql_select_db($database_conexion, $conexion);
		  mysql_query("SET NAMES 'utf8'");
		  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	
  
	
}
else if($oper=='del'){
	
	
		  $deleteSQL = sprintf("DELETE FROM actividades WHERE idActividad=%s",
		  GetSQLValueString($_POST['id'], "int"));
		  mysql_select_db($database_conexion, $conexion);
		  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());

}
mysql_close($conexion);
exit;




mysql_free_result($Recordset1);
?>

