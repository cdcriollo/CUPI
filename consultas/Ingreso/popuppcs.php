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

?>


<style type="text/css">

.th {

	    padding: 5px;
        font-size: 12px;
        background-color: #83aec0;
        background-image: url(images/fondo_th.png);
        background-repeat: repeat-x; 
        font:Arial, Helvetica, sans-serif;
		border-style: solid;
        border-color: #000000;
		color: #FFFFFF;
        border-width: 1px;
	
}

 .tr{

	    font-size: 12px;
        font-weight:bold;
        background-color: #e2ebef;
        background-image: url(images/fondo_tr01.png);
        background-repeat: repeat-x;
        color: #34484E;
        font:Arial, Helvetica, sans-serif;
		border-style: solid;
        border-color: #000000;
        border-width: 1px;
		text-align:center;
}
       
</style>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>

<table border="1" cellspacing="0" width="300">

<?php mysql_select_db($database_conexion, $conexion);
$query_JRSalas = "SELECT *  FROM sala where numSala <> 0 ORDER BY numSala";
mysql_query("SET NAMES 'utf8'");
$JRSalas = mysql_query($query_JRSalas, $conexion) or die(mysql_error());
$row_JRSalas = mysql_fetch_assoc($JRSalas);
$totalRows_JRSalas = mysql_num_rows($JRSalas);

if($totalRows_JRSalas > 0)
{
	do
	{
    
    $numSala = $row_JRSalas['numSala'];
    
    mysql_select_db($database_conexion, $conexion);
    $query_JREstadoPcs = "SELECT Nopc,estadoocupacion FROM pcs where numSala=$numSala";
	mysql_query("SET NAMES 'utf8'");
    $JREstadoPcs = mysql_query($query_JREstadoPcs, $conexion) or die(mysql_error());
    $row_JREstadoPcs = mysql_fetch_assoc($JREstadoPcs);
    $totalRows_JREstadoPcs = mysql_num_rows($JREstadoPcs);
    
    if($totalRows_JREstadoPcs > 0)
    {
			?>
           <tr>
               <th colspan="2" align="center" class="th" style="font-size:14px; font-weight:bold;"><?php echo "SALA"."". $numSala;?></p></th>
           </tr>

     <tr>
        <th class="th">No Pc</th>
        <th class="th">Estado</th>
    </tr>
    
  <?php do { ?>
    <tr>
      <td class="tr" ><?php echo $row_JREstadoPcs['Nopc']; ?></td>
      <td class="tr"><?php echo $row_JREstadoPcs['estadoocupacion']; ?></td>
    </tr>
    <?php } while ($row_JREstadoPcs = mysql_fetch_assoc($JREstadoPcs)); ?>
      <?php  mysql_free_result($JREstadoPcs);?> 
    <?php }?>
    <?php  } while ($row_JRSalas = mysql_fetch_assoc($JRSalas)); ?>
      <?php mysql_free_result($JRSalas);?>
</table>

<?php }?>

<?php 
 mysql_close($conexion); 
?>
</body>
</html>
