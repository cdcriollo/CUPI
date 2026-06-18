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


$idTipo=$_POST['idTipo'];

mysql_select_db($database_conexion, $conexion);
$query_JRsubgrupos = "SELECT idsubtipo, descripcionSubtipo FROM subgrupo WHERE idTipo = $idTipo";
mysql_query("SET NAMES 'utf8'");
$JRsubgrupos = mysql_query($query_JRsubgrupos, $conexion) or die(mysql_error());
$row_JRsubgrupos = mysql_fetch_assoc($JRsubgrupos);
$totalRows_JRsubgrupos = mysql_num_rows($JRsubgrupos);
?>

<html>
<head>


</head>
<body>

<?php if($totalRows_JRsubgrupos > 0){ ?>

<div style="overflow:auto; width:420px; min-height:0px; max-height:300px; margin-bottom:15px; margin-top:auto;">
        
  <?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>
       
  <table  border="1" class="tableUI" class="MatriUser" width="400" style="margin-left:15px; margin-top:15px;" cellpadding="0" cellspacing="0">
  <tr>
    <th></th>
    <th>Descripción</th>
  </tr>
  
  <?php do { ?>
    <tr>
      <td><input type="checkbox" class="checksubgrupo" value="<?php echo $row_JRsubgrupos['idsubtipo']; ?>"/></td>
      <td><?php echo $row_JRsubgrupos['descripcionSubtipo']; ?></td>
    </tr>
    <?php } while ($row_JRsubgrupos = mysql_fetch_assoc($JRsubgrupos)); ?>
</table>
</div>      
     
    <?php }
	else {
	
		echo'<script type="text/javascript">alertas("El usuario no tiene matriculadas asignaturas en el piso","Consultar Matricula Usuario","error");</script> ';
	}
	?> 
    


    
    
     <?php
        mysql_free_result($JRsubgrupos);
		mysql_close($conexion);
     ?>  

</body>
</html>
