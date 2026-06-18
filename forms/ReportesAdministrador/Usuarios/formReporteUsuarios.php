<?php require_once('../../../Connections/conexion.php'); ?>
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

mysql_select_db($database_conexion, $conexion);
$query_JRUsuarios = "SELECT * FROM usuarios";
mysql_query("SET NAMES 'utf8'");
$JRUsuarios = mysql_query($query_JRUsuarios, $conexion) or die(mysql_error());
$row_JRUsuarios = mysql_fetch_assoc($JRUsuarios);
$totalRows_JRUsuarios = mysql_num_rows($JRUsuarios);

$styleth=' style="padding: 5px;
        font-size: 12px;
        background-color: #83aec0;
        background-image: url(images/fondo_th.png);
        background-repeat: repeat-x; 
        font:Arial, Helvetica, sans-serif;
		border-style: solid;
        border-color: #000000;
		color: #FFFFFF;
        border-width: 1px;"';
        
		
 $styletr='style="font-size: 12px;
        font-weight:bold;
        background-color: #e2ebef;
        background-image: url(images/fondo_tr01.png);
        background-repeat: repeat-x;
        color: #34484E;
        font:Arial, Helvetica, sans-serif;
		border-style: solid;
        border-color: #000000;
        border-width: 1px;
		text-align:center;"';
		
 $styletable='style="font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size:10px;
	text-align: center;
	width: 500px;
	padding: 0px;
	margin:10px;
	border:2px solid black;
	-moz-border-radius:7px;
	-webkit-border-radius:7px;
	 border-radius:7px;
	 cellpadding="0";
	 cellspacing="0";
	 "';
	 
 $stylecabecera='style="background-color: #e2ebef;
  background-image: url(images/fondo_tr01.png);
  background-repeat: repeat-x; 
 font-weight:bold; 
 border-right-style:solid; 
 border-right-width:1px; 
 border-right-color:black; 
 border-left-style:solid; 
 border-left-width:1px; 
 border-left-color:black; 
 border-top-style:solid;
 border-top-width:1px;
 border-top-color:black;
 border-bottom-style:solid;
 border-bottom-width:1px;
 border-bottom-color:black;
  "';
 
 $stylecabeceratitulo='style="text-align:center; 
 background-color: #e2ebef;
 background-image: url(images/fondo_tr01.png);
 background-repeat: repeat-x; 
 font-weight:bold; 
 font-size:12px;  
 border-right-style:solid;
 border-right-width:1px; 
 border-right-color:black;
 border-left-style:solid;
 border-left-width:1px; 
 border-left-color:black;"';				

$styleImagen= 'style="background-color: #e2ebef;
 background-image: url(images/fondo_tr01.png);
 background-repeat: repeat-x;
 border-top-style:solid;
 border-top-width:1px;
 border-top-color:black;
 border-bottom-style:solid;
 border-bottom-width:1px;
 border-bottom-color:black;
 border-left-style:solid; 
 border-left-width:1px; 
 border-left-color:black;"';	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

	
  
<script type="text/javascript">

$(function(){

 $("#html").hide();  
 
	function exportar_excel(id_form, id_tabla)
		
		{
			
        // Obtiene el contenido de la tabla indicada
        var tabla = $("." + id_tabla).html();
        // Añade los tags de tabla
        tabla = "<table>" + tabla + "</table>";
        // Almacena en el campo oculto los datos a exportar
       $("#datos_a_enviar").val( tabla );
        // Activa el formulario, el cual lanza el código en PHP
      $("#" + id_form).submit();
    }
	
	$("#exportar").click(function(){
		
	   exportar_excel('form_excel_usuarios', 'DatosUsuarios');
	
	});
	
	$("#pdf").click(function(){
		
		 html= $('.DatosUsuarios').html();
		cadenahtml='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>Reporte Usuarios</title></head> <body style="margin-top:30px; margin-left: 300px; margin-right: 300px;"><center><table class="DatosUsuarios" id="DatosUsuarios" cellpadding="0" cellspacing="0" > '+html+ '</table></center></body> </html>'
		
		$("#html").text(cadenahtml);//al text area le asigno toda la variable html						  
	    $("#frmpdf").submit();//envio el formulario
	
	
	});
	
	$("#print").click(function(){
		$("#MostrarReporteUsuarios").printArea();
			
	});


	

});// cierro jquery



</script>



</head>

<body>

 <?php if ($totalRows_JRUsuarios > 0){ ?>
 
 <div id="MostrarReporteUsuarios" style="margin-bottom:15px; min-width:0; max-width:650px; max-height:600px; min-height:0px; overflow: auto; visibility: visible;">

 <table cellspacing="0" cellspacing="0" width="650" class="DatosUsuarios" id="DatosUsuarios">

  <tr>
    
     <td  align="center" <?php echo $styleImagen; ?>><img src="http://192.168.82.9/CUPI/images/tn1_univallelogo.jpg" style="height:88px; width:71px" /> </td>
     <td  colspan="4" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
     </p></center><center><p>Universidad del Valle </p></center> <?php 
	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$ano=date('Y');?> <?php echo ' <center><p>'. $dias[date('w')].' '.date('d').' de '.$mes[date('n')].' del '.$ano.'</p></center>';?></td>
     
  </tr>  
   
  <tr>
    <td colspan="5" <?php echo $stylecabeceratitulo; ?> > <center><p> REPORTE DE USUARIOS</p></center> </td>
  </tr>
  
  <tr>
    <th <?php echo $styleth;?>>Codigo Usuario</th>
    <th <?php echo $styleth;?>>Nombre Usuario</th>
    <th <?php echo $styleth;?>>Estamento</th>
    <th <?php echo $styleth;?>>Dependencia</th>
    <th <?php echo $styleth;?>>Estado</th>
  </tr>
  
  <?php do { ?>
    <tr>
      <td <?php echo $styletr; ?>><?php echo $row_JRUsuarios['codUsuario']; ?></td>
      <td <?php echo $styletr; ?>><?php echo $row_JRUsuarios['nombreUsu']; ?></td>
      <td <?php echo $styletr; ?>><?php echo $row_JRUsuarios['estamento'];  ?></td>
      <td <?php echo $styletr; ?>><?php echo $row_JRUsuarios['dependencia']; ?></td>
      <td <?php echo $styletr; ?>><?php echo $row_JRUsuarios['estado']; ?></td>
    </tr>
    <?php } while ($row_JRUsuarios = mysql_fetch_assoc($JRUsuarios)); ?>
    
     <tr>
       <td colspan="5" align="center" <?php echo $stylecabecera; ?>><p>CUPI</p><p>Control de Utilizacion Piso Informatico</p></td>
    </tr>
    
</table>

  <?php }?>  
     
  </div>
 
 
  <p><a href="#" id="exportar"  title="Exportar a Excel" style="padding-top:5px;"><img src="images/exportaraexcel.png" /></a><a href="#"  title="Exportar a Pdf" id="pdf"> <img src="images/Exportarapdf.png" /></a> <a href="#"  title="Imprimir" id="print"> <img src="images/document-print.png" /></a> </p>

 <form action="forms/ReportesAdministrador/Usuarios/FicheroExcelRepUsuarios.php" id="form_excel_usuarios"  method="post" target="_blank">
          <!-- Inicia el proceso de exportar -->
        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>  
 </form>
 
 
 <form action="forms/ReportesAdministrador/Usuarios/formpdfusuarios.php" method="post" id="frmpdf">
   <textarea id="html" name="html"></textarea>
</form>
   
</body>
</html>
<?php
mysql_free_result($JRUsuarios);


?>


