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
  
    $("#desde").datepicker({ 
          dateFormat:'dd-mm-yy',
          defaultDate: +7,
		  changeMonth: true,
		  changeYear: true,
	 });
	 
	 $("#hasta").datepicker({ 
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
		
	   exportar_excel('form_excel_reservas', 'RReservas');
	
	});
	
	$("#pdf").click(function(){
		
		 html= $('.RReservas').html();
		
		cadenahtml='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>Reporte Asistencia</title></head> <body style="margin-top:30px; margin-left: 300px; margin-right: 300px;"><center><table   class="RReservas" id="RReservas" cellpadding="0" cellspacing="0" > '+html+ '</table></center></body> </html>'
		
		$("#html").text(cadenahtml);//al text area le asigno toda la variable html
		
										  
	   $("#frmpdf").submit();//envio el formulario
	
	
	});
	
	$("#print").click(function(){
		$("#reportereservas").printArea();
			
	});
	

   $("#semestral").button().click(function() {
	   	   
	   var options = {
				  
		classerror:"ui-state-error",
		classdone:"ui-state-highlight",
		contentmsg:"validateErrors",
		fields:[
			{
			  id:"desde",
			  validations:
			  {
				 required:[true,"El campo desde no puede estar vacio."]
			  }
				
			},
			  
			{  id:"hasta",
			   validations:
			   {
				 required:[true,"El campo hasta no puede estar vacio."]				 				
			   }
		   }
		  ],
				  
		beforeValidation:function()
		{    
	  
		  var desde= $('#desde').val();
		  var hasta= $('#hasta').val();
		  var cadenareserva="1";
		  
		  $.ajax({
					
				type: 'POST',
				url: 'consultas/InformeReservas/ConsultaReservasEventuales.php',
				data: 'desde='+desde+'&hasta='+hasta+'&cadena='+cadenareserva,
				success: function(datos){
							 
				if(datos)
				{				
				  $("#reportereservas").html(datos);
										
				}
				else{									
				   alertas("Por favor verifique los datos","error"); 
				}
			  }
			});	
			}
		  }; 
		 $.validation(options);       	  
    }); 
   
   
   $("#eventual").button().click(function() {
	  
	  var options = {
				  
		classerror:"ui-state-error",
		classdone:"ui-state-highlight",
		contentmsg:"validateErrors",
		fields:[
			{
			  id:"desde",
			  validations:
			  {
				 required:[true,"El campo desde no puede estar vacio."]
			  }
				
			},
			  
			{  id:"hasta",
			   validations:
			   {
				 required:[true,"El campo hasta no puede estar vacio."]				 				
			   }
		   }
		  ],
				  
		beforeValidation:function()
		{    
		
		  var desde= $('#desde').val();
		  var hasta= $('#hasta').val();
		  var cadenareserva="2";
		  
		  $.ajax({
					
				type: 'POST',
				url: 'consultas/InformeReservas/ConsultaReservasEventuales.php',
				data: 'desde='+desde+'&hasta='+hasta+'&cadena='+cadenareserva,
				success: function(datos){
							 
				if(datos)
				{				
				  $("#reportereservas").html(datos);										
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
   
   $("#todas").button().click(function() {
	  
	  var options = {
				  
		classerror:"ui-state-error",
		classdone:"ui-state-highlight",
		contentmsg:"validateErrors",
		fields:[
			{
			  id:"desde",
			  validations:
			  {
				 required:[true,"El campo desde no puede estar vacio."]
			  }
				
			},
			  
			{  id:"hasta",
			   validations:
			   {
				 required:[true,"El campo hasta no puede estar vacio."]				 				
			   }
		   }
		  ],
				  
		beforeValidation:function()
		{    
		
		  var desde= $('#desde').val();
		  var hasta= $('#hasta').val();
		  var cadenareserva="3";
		  
		  $.ajax({
					
				type: 'POST',
				url: 'consultas/InformeReservas/ConsultaReservasEventuales.php',
				data: 'desde='+desde+'&hasta='+hasta+'&cadena='+cadenareserva,
				success: function(datos){
							 
				if(datos)
				{				
				  $("#reportereservas").html(datos);										
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
	 
 
  $("#limpiarform").button().click(function() {
		  
		$('#desde').val("");
		$('#hasta').val("");
		$("#reportereservas").empty();
		$("#desde").focus(); 
		  
  });
  
  
   	
});// cierro jquery



</script>



</head>

<body>

 <p id="validateErrors"></p>

        <div id="formlistadosclase" class="text ui-widget-content ui-corner-all" style="width:530px;  margin-bottom:15px; height:auto; font-size:12px;">
          <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">RESERVAS EVENTUALES</div>
        
        <table style="margin-left:15px;">
        <tr>
        	<td><label for="desde">Desde:</label></td>
            <td><input type="text"  id="desde" size="20" class="text ui-widget-content ui-corner-all"/></td>
            <td><label for="hasta">Hasta:</label></td>
            <td> <input type="text" size="20" id="hasta" class="text ui-widget-content ui-corner-all" ></td>            
        </tr>
        </table>
        
        <table  style="margin-left:15px;">
        <tr>
          <td><button type="button" id="semestral" style="font-size:11px;margin-bottom:5px; margin-top:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Semestral</button></td>
          <td>
          <td><button type="button" id="eventual" style="font-size:11px;margin-bottom:5px; margin-top:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Eventual</button></td>
          <td>
          <td><button type="button" id="todas" style="font-size:11px;margin-bottom:5px; margin-top:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Todas las reservas</button></td>
          <td>
        <button type="button" id="limpiarform" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/> Limpiar</button>
        </td>
       </tr>
      </table> 
    </div>
    
    
  <div id="reportereservas" style="margin-bottom:15px; min-width:0; max-width:668px; max-height:500px; min-height:0px; overflow:auto; visibility:visible;"></div>
 
 
  <p><a href="#" id="exportar"  title="Exportar a Excel" style="padding-top:5px;"><img src="images/exportaraexcel.png" /></a><a href="#"  title="Exportar a Pdf" id="pdf"> <img src="images/Exportarapdf.png" /></a> <a href="#"  title="Imprimir" id="print"> <img src="images/document-print.png" /></a> </p>

 <form action="forms/ReportesAdministrador/InformeReservas/FicheroExcelReservas.php" id="form_excel_reservas"  method="post" target="_blank">
          <!-- Inicia el proceso de exportar -->
        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>  
 </form>
 
 
 <form action="forms/ReportesAdministrador/InformeReservas/formpdfreservas.php" method="post" id="frmpdf">
   <textarea id="html" name="html"></textarea>
</form>

 <div id="alertas"></div>
   	    
</body>
</html>



