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

$nuevovalor=$_POST['nuevovalor'];
$oper=$_POST['oper'];

if($oper=='updategrupo')
{
     $idtipo=$_POST['llave'];
	
	 mysql_select_db($database_conexion, $conexion);
	 
	 $updateSQL = "UPDATE gruporecurso SET descripcionTipo= '$nuevovalor' WHERE idTipo= $idtipo";
	 mysql_query("SET NAMES 'utf8'");
	 $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	
	$numerofilasafectadasgrupo= mysql_affected_rows();
	  
	  if($numerofilasafectadasgrupo > 0)
	  {
		echo 1;  
	  }
	  else if($numerofilasafectadasgrupo==0)
	  {
		echo 0;  
	  }
}
else if($oper=='updatesubgrupo')
{
    $idsubtipo=$_POST['idsubTipo'];
	
	 mysql_select_db($database_conexion, $conexion);
	 
	 $updateSQL = "UPDATE subgrupo SET descripcionSubtipo= '$nuevovalor' WHERE idsubtipo= $idsubtipo";
	 mysql_query("SET NAMES 'utf8'");
	 $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	
	if($Result1==1)
	{
		echo 1;
	}
	else
    {
	   echo 0;
	}
 	
}


 
?>