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

$grupo=$_POST['grupo'];
$subgrupo=$_POST['subgrupo'];
$inventario=$_POST['inventario'];


if($inventario=="")
{
	$clausula= "select Noinventario, cantidad from recursos r  where idTipo=$grupo and subGrupo=$subgrupo and estadorecurso='Activo' and estadoprestamo='disponible' LIMIT 1";
}

else if($inventario!="NULL")
{
	$clausula= "select Noinventario, cantidad from recursos r  where Noinventario= '$inventario' and estadorecurso='Activo' and estadoprestamo='disponible' LIMIT 1";
	
}

		mysql_select_db($database_conexion, $conexion);
		$query_JRConsultarR = $clausula;
		mysql_query("SET NAMES 'utf8'");
		$JRConsultarR = mysql_query($query_JRConsultarR, $conexion) or die(mysql_error());
		$row_JRConsultarR = mysql_fetch_assoc($JRConsultarR);
		$totalRows_JRConsultarR = mysql_num_rows($JRConsultarR);
		$Noinventario=$row_JRConsultarR['Noinventario'];


		if($totalRows_JRConsultarR > 0){
			
			
			mysql_select_db($database_conexion, $conexion);
			$query_JRDescripcionsubgrupo = "SELECT Nombrebien FROM recursos WHERE Noinventario='$Noinventario'";
			mysql_query("SET NAMES 'utf8'");
			$JRDescripcionsubgrupo = mysql_query($query_JRDescripcionsubgrupo, $conexion) or die(mysql_error());
			$row_JRDescripcionsubgrupo = mysql_fetch_assoc($JRDescripcionsubgrupo);
			$totalRows_JRDescripcionsubgrupo = mysql_num_rows($JRDescripcionsubgrupo);
		
		   $recurso[0]=$row_JRConsultarR['Noinventario'];
		   $recurso[1]=$row_JRConsultarR['cantidad']; 
		   $recurso[2]=$row_JRDescripcionsubgrupo['Nombrebien'];
		   $arraybusquedarecursos= implode(',',$recurso);
		   
		   echo $arraybusquedarecursos;
           mysql_free_result($JRDescripcionsubgrupo);
  
  }
  else 
  {
	echo 0;
  }
  
mysql_free_result($JRConsultarR);
mysql_close($conexion);

?>
