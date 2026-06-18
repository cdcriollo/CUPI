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


$asignatura=$_POST['asignatura'];

mysql_select_db($database_conexion, $conexion);
$query_JRGrupo = "select codGrupo from grupo_x_asignatura where codAsignatura='$asignatura'";
mysql_query("SET NAMES 'utf8'");
$JRGrupo = mysql_query($query_JRGrupo, $conexion) or die(mysql_error());
$row_JRGrupo = mysql_fetch_assoc($JRGrupo);
$totalRows_JRGrupo = mysql_num_rows($JRGrupo);

?>


<?php 


$totalGrupos = mysql_num_rows($JRGrupo);  
        
		
  if ($totalGrupos > 0)  
  {  
       do {  
     ?>
    <?php

   $Grupos[0]=$row_JRGrupo['codGrupo'];

      for ($i=1; $i<$totalGrupos; $i++) 
	  {  
       $Grupo = mysql_fetch_array($JRGrupo);  
       $Grupos[$i] = $Grupo["codGrupo"];  
      }  
	?>
   <?php
   } while ($row_JRGrupo = mysql_fetch_assoc($JRGrupo));
   $rows = mysql_num_rows($JRGrupo);
    if($rows > 0) {
      mysql_data_seek($JRGrupo, 0);
	  $row_JRGrupo = mysql_fetch_assoc($JRGrupo);
     } 
  
    $cadenaGrupos=implode(',',$Grupos); 
	
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRGAsignatura = "SELECT codGrupo FROM grupo WHERE codGrupo NOT IN ($cadenaGrupos)";
	$JRGAsignatura = mysql_query($query_JRGAsignatura, $conexion) or die(mysql_error());
	$row_JRGAsignatura = mysql_fetch_assoc($JRGAsignatura);
	$totalRows_JRGAsignatura = mysql_num_rows($JRGAsignatura);
	
	
	$totalGruposAsignatura = mysql_num_rows($JRGAsignatura);  
        
		
  if ($totalGruposAsignatura > 0)  
  {  
       do {  
     ?>
    <?php

   $GruposAsig[0]=$row_JRGAsignatura['codGrupo'];

      for ($i=1; $i<$totalGruposAsignatura; $i++) 
	  {  
       $GrupoA = mysql_fetch_array($JRGAsignatura);  
       $GruposAsig[$i] = $GrupoA["codGrupo"];  
      }  
	?>
   <?php
   } while ($row_JRGAsignatura = mysql_fetch_assoc($JRGAsignatura));
   $rows = mysql_num_rows($JRGAsignatura);
    if($rows > 0) {
      mysql_data_seek($JRGAsignatura, 0);
	  $row_JRGAsignatura= mysql_fetch_assoc($JRGAsignatura);
     } 
  
    echo $cadenaGruposAsig=implode(',',$GruposAsig); 
	mysql_free_result($JRGAsignatura); 
	
  }// cierro if
	
	      
}// Cierro if 
else
{
  echo 0;	
}
	
		
?>


<?php
mysql_free_result($JRGrupo);

?>



