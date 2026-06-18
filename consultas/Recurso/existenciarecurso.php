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
   
	     $codigoInv=$_POST['codigoInv'];
	  
		mysql_select_db($database_conexion, $conexion);
		$query_JRDuplirecurso = "SELECT Noinventario FROM recursos WHERE Noinventario= '$codigoInv'";
		mysql_query("SET NAMES 'utf8'");
		$JRDuplirecurso = mysql_query($query_JRDuplirecurso, $conexion) or die(mysql_error());
		$row_JRDuplirecurso = mysql_fetch_assoc($JRDuplirecurso);
		$totalRows_JRDuplirecurso = mysql_num_rows($JRDuplirecurso);
		
		if($totalRows_JRDuplirecurso > 0)
		{
		  echo 1;
		
		}
		
		mysql_free_result($JRDuplirecurso);
		mysql_close($conexion);
      
?>