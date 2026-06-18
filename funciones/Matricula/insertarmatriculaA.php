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

$datos=$_GET['array'];
$asignatura= $_POST['asignatura'];
$grupo= $_POST['grupo'];

  
    $arraymatricula=explode(',',$datos);
 
  
	 for($i=0; $i<count($arraymatricula)-1;$i+=3)
	 {
		    
	   $insertSQL = sprintf("INSERT INTO matricula (codUsuario,codAsignatura, pc,grupo,idHorario) VALUES (%s, %s, %s, %s, %s)",
						 
						   GetSQLValueString($arraymatricula[$i], "int"),
						   GetSQLValueString($asignatura, "text"),
						   GetSQLValueString($arraymatricula[$i+1], "int"),
						   GetSQLValueString($grupo, "int"),
						   GetSQLValueString($arraymatricula[$i+2], "int"));
					  				                 
       mysql_select_db($database_conexion, $conexion);
       $Result = mysql_query($insertSQL, $conexion) or die(mysql_error());

	}
	
	if($Result > 0)
	{
	   echo 1; 
    }
	
    else
     {
	   echo 0;
     }
	
	
?>

