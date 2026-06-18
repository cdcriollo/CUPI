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
$usuario=$_POST['codigoUsuario'];

  
    $arraymatricula=explode(',',$datos);
 
  
	  for($i=0; $i<count($arraymatricula)-1;$i+=4){
		    
   $insertSQL = sprintf("INSERT INTO matricula (codUsuario,codAsignatura, pc,grupo,idHorario) VALUES (%s,%s,%s,%s,%s)",
                     
                       GetSQLValueString($usuario, "int"),
                       GetSQLValueString($arraymatricula[$i], "text"),
					   GetSQLValueString($arraymatricula[$i+2], "int"),
                       GetSQLValueString($arraymatricula[$i+1], "int"),
					   GetSQLValueString($arraymatricula[$i+3], "int"));
					   
					   
					   
					   
					                 
   mysql_select_db($database_conexion, $conexion);
   $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
   
   
  
  
	}
	if($Result1==1){
	
	 echo 1; 
	
  }
  else{
	echo 0;
  }
	
	


?>