<?php require_once('../../../Connections/conexion.php'); session_start();  ?>
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

	
  
<script type="text/javascript">

$(function(){

 $("#html").hide(); 
 

 $.datepicker.setDefaults($.datepicker.regional['es']);
 
	    $("#comienzo").datepicker({ 
	       dateFormat:'dd-mm-yy',
	       defaultDate: +7,
			  changeMonth: true,
			  changeYear: true,
		 });
		 
		 $("#finalizacion").datepicker({ 
	       dateFormat:'dd-mm-yy',
	       defaultDate: +7,
			  changeMonth: true,
			  changeYear: true,
		 });
 
 
  
      $("#alertas" ).dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			modal:true		
		});
		
		function alertas(content,title,type)
		{			
			$("#alertas").empty();			
			$("#alertas").dialog( "option", "title", title );
			if(type=="done")
			{
				$("#alertas").html('<img src="images/done.png" style="float:left; padding:5px;" />');
			}
			else if(type=="error")
			{
				$("#alertas").html('<img src="images/error.png" style="float:left; padding:5px;" />');
			}
			else if(type=="inform")
			{
				$("#alertas").html('<img src="images/inform.png" style="float:left; padding:5px;" />');
			}
			$("#alertas").append(content);
			$("#alertas").dialog("open");
		}
        	
 
 
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
		
	   exportar_excel('form_excel_listado', 'ReporteClase');
	
	});
	
	$("#pdf").click(function(){
		
		 html= $('.ReporteClase').html();
		
		cadenahtml='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>Reporte Asistencia</title></head> <body style="margin-top:30px; margin-left: 300px; margin-right: 300px;"><center><table   class="ReporteClase" id="ReporteClase" cellpadding="0" cellspacing="0" > '+html+ '</table></center></body> </html>'
		
		$("#html").text(cadenahtml);//al text area le asigno toda la variable html
		
										  
	   $("#frmpdf").submit();//envio el formulario
	
	
	});
	
	$("#print").click(function(){
		$("#MostrarReporteMonitores").printArea();
			
	});

  
  $("#limpiarform").button().click(function() {
		  
		$('#codigo').val("");
		$('#comienzo').val("");
		$("#MostrarReporteMonitores").empty();
		$("#finalizacion").val("");	
  });

  $("#allmonitores").button().click(function() {

	  var comienzo= $('#comienzo').val();
	  var finalizacion= $('#finalizacion').val();
	 
	  var options = {
			  
			classerror:"ui-state-error",
			classdone:"ui-state-highlight",
			contentmsg:"validateErrors",
			fields:[
				
					  
				{  id:"comienzo",
					   validations:
					  {
						required:[true,"El campo comienzo no puede estar vacio."],
						
					  }
			   },

			   {  id:"finalizacion",
					 validations:
				     {
					   required:[true,"El campo finalizacion no puede estar vacio."],
					 }
			   }
			],
						  
	beforeValidation:function()
	{    
		$.ajax({
			
		type: 'POST',
		url: 'consultas/Monitores/consulta_todos_monitores.php',
		data: 'comienzo='+comienzo+'&finalizacion='+finalizacion,
		success: function(datos)
		{
					 
			if(datos)
			{				
			  $("#MostrarReporteMonitores").html(datos);
									
			}
			else
			{
			  alertas("Por favor verifique los datos","error"); 
			 
			}
	   }
	});
  }
 }; 
$.validation(options);  		
});			   
	  
  
  
   
   $("#generarreporte").button().click(function(){

	      var comienzo= $('#comienzo').val();
		  var finalizacion= $('#finalizacion').val();
		  var codigo=$("#codigo").val();
	     
		  var options = {
				  
				classerror:"ui-state-error",
				classdone:"ui-state-highlight",
				contentmsg:"validateErrors",
				fields:[
					{
						id:"codigo",
						validations:
						{
						 required:[true,"El campo codigo no puede estar vacio."]
						}
							
					},
						  
					{  id:"comienzo",
						   validations:
						  {
							required:[true,"El campo comienzo no puede estar vacio."],
							
						  }
				   },

				   {  id:"finalizacion",
						 validations:
					     {
						   required:[true,"El campo finalizacion no puede estar vacio."],
						 }
				   }
				],
							  
		beforeValidation:function()
		{    
			$.ajax({
				
			type: 'POST',
			url: 'consultas/Monitores/consultareportemonitor.php',
			data: 'comienzo='+comienzo+'&finalizacion='+finalizacion+'&codigo='+codigo,
			success: function(datos)
			{
						 
				if(datos)
				{				
				  $("#MostrarReporteMonitores").html(datos);
										
				}
				else
				{
				  alertas("Por favor verifique los datos","error"); 
				 
				}
		   }
		});
	  }
	 }; 
    $.validation(options);  		
 });			  
	
	
});// cierro jquery

</script>

</head>

<body>

 <p id="validateErrors"></p>

        <div id="formlistadosclase" class="text ui-widget-content ui-corner-all" style="width:500px;  margin-bottom:15px; height:auto; font-size:12px;">
          <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">REPORTE MONITORES</div>
        
        <table style="margin-left:15px;">
        <tr>
        	<td><label for="comienzo">Comienzo:</label></td>
            <td><input type="text"  id="comienzo" size="20" class="text ui-widget-content ui-corner-all"/></td>
            <td><label for="finalizacion">Finalizacion:</label></td>
            <td> <input type="text" size="20" id="finalizacion" class="text ui-widget-content ui-corner-all" ></td>            
        </tr>
        <tr>
          <td><label for="codigo">Cedula:</label></td>
          <td><input type="text"  id="codigo" size="20" class="text ui-widget-content ui-corner-all"/></td>
        </tr>
        </table>
        
        <table  style="margin-left:15px;">
        <tr>
          <td><button type="button" id="generarreporte" style="font-size:11px;margin-bottom:5px; margin-top:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>
          <td>
        <button type="button" id="limpiarform" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/> Limpiar</button>
        </td>
        <?php if($_SESSION['perfil']==1)// Solo se muestra la opcion de todos los monitores para el administrador
        {?>
        <td>
         <button type="button" id="allmonitores" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Todos los Monitores</button>
        </td>
        <?php }?>
       </tr>
      </table> 
    </div>
    
    
  <div id="MostrarReporteMonitores" style="margin-bottom:15px; min-width:0; max-width:668px; max-height:500px; min-height:0px; overflow:auto; visibility:visible;"></div>
 
 
  <p><a href="#" id="exportar"  title="Exportar a Excel" style="padding-top:5px;"><img src="images/exportaraexcel.png" /></a><a href="#"  title="Exportar a Pdf" id="pdf"> <img src="images/Exportarapdf.png" /></a> <a href="#"  title="Imprimir" id="print"> <img src="images/document-print.png" /></a> </p>

 <form action="forms/ReportesAdministrador/ReporteMonitores/FicheroExcelreportemonitores.php" id="form_excel_listado"  method="post" target="_blank">
          <!-- Inicia el proceso de exportar -->
        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>  
 </form>
 
 
 <form action="forms/ReportesAdministrador/ReporteMonitores/formpdfreportemonitores.php" method="post" id="frmpdf">
   <textarea id="html" name="html"></textarea>
</form>


 <div id="alertas"></div>
   	   
</body>
</html>
<?php


?>


