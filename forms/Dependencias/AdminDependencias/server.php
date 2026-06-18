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
	

	  $insertSQL = sprintf("INSERT INTO dependencias (descripcion) VALUES (%s)",                       
      GetSQLValueString($_POST['descripcion'], "text"));
					   
      mysql_select_db($database_conexion, $conexion);
	  mysql_query("SET NAMES 'utf8'");
	  $Result1 = mysql_query($insertSQL, $conexion); //or die(mysql_error());
	  
	  $response->query = $Result1;//done si es true , mal si es false ;(
	  echo json_encode($response);

 
}
else if($oper=='edit')
{
	
	
		  $updateSQL = sprintf("UPDATE dependencias SET descripcion=%s WHERE Iddependencia=%s",
          GetSQLValueString($_POST['descripcion'], "text"),
          GetSQLValueString($_POST['id'], "int"));
		  mysql_select_db($database_conexion, $conexion);
		  mysql_query("SET NAMES 'utf8'");
		  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	
  
	
}
else if($oper=='del'){
	
	
		  $deleteSQL = sprintf("DELETE FROM dependencias WHERE Iddependencia=%s",
		  GetSQLValueString($_POST['id'], "int"));
		  mysql_select_db($database_conexion, $conexion);
		  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());

}
mysql_close($conexion);
exit;




mysql_free_result($Recordset1);
?>

