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

if ((isset($_POST["reserva"])))
{


    $arrayrecursos=explode(',',$_POST['arrayrecursos']);
   
     for($i=0; $i<count($arrayrecursos)-1;$i+=4)
	 {
		    
        $insertSQL = sprintf("INSERT INTO recursos_reservados (grupo, subgrupo, cantidad, Software, No_reserva) VALUES (%s, %s, %s, %s, %s)",
                
                       GetSQLValueString($arrayrecursos[$i], "int"),
                       GetSQLValueString($arrayrecursos[$i+1], "int"),
                       GetSQLValueString($arrayrecursos[$i+2], "int"),
					   GetSQLValueString($arrayrecursos[$i+3], "text"),
					   GetSQLValueString($_POST['reserva'], "text"));
					   
                    
      mysql_select_db($database_conexion, $conexion);
      $Result4 = mysql_query($insertSQL, $conexion) or die(mysql_error());
 
	}
	
	if($Result4 > 0)
	{
		$response=array("error"=>1);
		echo json_encode($response);
	}
	else
	{
	   $response=array("error"=>0);
	   echo json_encode($response);	
	}
}
	
?>