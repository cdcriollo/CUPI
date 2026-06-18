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


$codigo=$_POST['codigo'];
$grupo=$_POST['grupo'];

if( isset ($_POST['codigo'], $_POST['grupo'] ))
{
	
	mysql_select_db($database_conexion, $conexion);
   $query_JRAsignaturas = "SELECT * FROM  asignatura A INNER JOIN grupo_x_asignatura G ON(A.codAsignatura=G.codAsignatura)  WHERE A.codAsignatura = '$codigo'   AND G.codGrupo=$grupo";
   
   mysql_query("SET NAMES 'utf8'");
   $JRAsignaturas = mysql_query($query_JRAsignaturas, $conexion) or die(mysql_error());
   $row_JRAsignaturas = mysql_fetch_assoc($JRAsignaturas);
   $totalRows_JRAsignaturas = mysql_num_rows($JRAsignaturas);
   
  
	if($totalRows_JRAsignaturas > 0){	
		 
		 $nombre= $row_JRAsignaturas['nomAsignatura'];
         $response=array("error"=>0,"nombre"=> $nombre);
		 echo json_encode($response);
		  
	}
	
	else if($totalRows_JRAsignaturas==0)
	{ 
		
		$response=array("error"=>1);
		echo json_encode($response);
    }
         
 
}


?>

<?php

mysql_free_result($JRAsignaturas);
mysql_close($conexion);

?>
