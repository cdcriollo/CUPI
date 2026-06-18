
<?php require_once('../Connections/conexion.php'); ?>
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
mysql_select_db($database_conexion, $conexion);
$query_JRCmatricula = "select u.nombreUsu,m.codAsignatura,m.pc,a.nomAsignatura,a.numSala,g.codGrupo from usuarios u inner join matricula m on (u.codUsuario=m.codUsuario) inner join asignatura a on (m.codAsignatura=a.codAsignatura) inner join grupo_x_asignatura g on (a.codAsignatura=g.codAsignatura) where U.codUsuario= $codigo";
$JRCmatricula = mysql_query($query_JRCmatricula, $conexion) or die(mysql_error());
$row_JRCmatricula = mysql_fetch_assoc($JRCmatricula);
$totalRows_JRCmatricula = mysql_num_rows($JRCmatricula);
$numregistros= $totalRows_JRCmatricula*6;

/*do {
for($i=0; $i<$numregistros;$i+=6){
		    
   $cadenamatricula[$i]=  $row_JRCmatricula['nombreUsu']; 
		 $cadenamatricula[$i+1]=  $row_JRCmatricula['codAsignatura']; 	
		 $cadenamatricula[$i+2]=  $row_JRCmatricula['pc']; 	
		 $cadenamatricula[$i+3]=  $row_JRCmatricula['nomAsignatura']; 	
		 $cadenamatricula[$i+4]=  $row_JRCmatricula['numSala']; 	
		 $cadenamatricula[$i+5]=  $row_JRCmatricula['codGrupo']; 	
        
	}
 $cadenamatric= implode('-',$cadenamatricula);
} while ($row_JRCmatricula = mysql_fetch_assoc($JRCmatricula));


echo $cadenamatric;*/

////////////////////



?>
<html>
<head>

<style type="text/css">

.tabla {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	text-align: center;
	width: 600px;
	padding: 0px;
	margin:10px;
	border:1px solid #000;
	
}

 .tabla th {
	padding: 5px;
	font-size: 14px;
	background-color: #83aec0;
	background-image: url(../images/fondo_th.png);
	background-repeat: repeat-x;
	color: #FFFFFF;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-right-style: solid;
	border-bottom-style: solid;
	border-right-color: #558FA6;
	border-bottom-color: #558FA6;
	font-family: "Trebuchet MS", Arial;
	text-transform: uppercase;
}
.tabla .modo1 {
	font-size: 12px;
	font-weight:bold;
	background-color: #e2ebef;
	background-image: url(../images/fondo_tr01.png);
	background-repeat: repeat-x;
	color: #34484E;
	font-family: "Trebuchet MS", Arial;
}
</style>
</head>
<body>
<form id="form" action="" method="post" class="niceform" >  

  <fieldset>
    	<legend>MATRICULAS - CONSULTAR POR ASIGNATURA</legend>
        
        
        <table>
        <tr>
        <td><label>Codigo usuario:</label>
        <td><input name="codusu" type="text" id="codusu" value="<?php echo $codigo; ?>" /></td>
        </tr>
       
        <tr>
        <td><label>Nombre:</label>
        <td><input name="nomusu" type="text" id="nomusu" size="40" value= "<?php echo  $row_JRCmatricula['nombreUsu'];  ?>" /></td>
        </tr>
        </table>
        
        <table class="tabla"  border="1">
  <tr>
    <th>Codigo</th>
    <th>Grupo</th>
    <th>Asignatura</th>
    <th>Computador</th>
    <th>Sala</td>
    
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_JRCmatricula['codAsignatura']; ?></td>
      <td><?php echo $row_JRCmatricula['codGrupo']; ?></td>
      <td><?php echo $row_JRCmatricula['nomAsignatura']; ?></td>
      <td><?php echo $row_JRCmatricula['pc']; ?></td>
      <td><?php echo $row_JRCmatricula['numSala']; ?></td>
    </tr>
    <?php } while ($row_JRCmatricula = mysql_fetch_assoc($JRCmatricula)); ?>
</table>

        
      </fieldset>
      
     </form>   

</body>
<?php
mysql_free_result($JRCmatricula);

?>
</html>