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


$grupo= $_POST['grupo'];
$subgrupo= $_POST['subgrupo'];
$cantidad= $_POST['cantidad'];
$idrecurso= $_POST['idRecurso'];
$software= $_POST['software'];



  $updateSQL = sprintf("UPDATE recursos_reservados SET grupo=%s, subgrupo=%s, cantidad=%s, Software=%s  WHERE id=%s",
                      
                       GetSQLValueString($grupo, "int"),
                       GetSQLValueString($subgrupo, "int"),
                       GetSQLValueString($cantidad, "int"),
					   GetSQLValueString($software, "text"),
                       GetSQLValueString($idrecurso, "int"));
					  
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
  $recactualizados=mysql_affected_rows();
  
  if($recactualizados > 0)
  {
	$error=array("error"=>"1");  
	echo json_encode($error);
  }
  else if($recactualizados==0)
  {
	 $error=array("error"=>"1");  
	 echo json_encode($error);
  }



?>


