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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>


<script type="text/javascript">
  
$(function(){
	
   var tiporeporte="";
	
	$("#horaI").timepicker({divId: "mytimepicker"});
    $("#horaF").timepicker({divId: "mytimepicker"});
	var tamaño=0;
	var html="";
	var style="";
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
		height:"120",
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
			else if(type=="warning")
			{
				$("#alertas").html('<img src="images/dialog-warning.png" style="float:left; padding:5px;" />');
			}
			$("#alertas").append(content);
			$("#alertas").dialog("open");
		}
		
		
		function exportar_excel(id_form, id_tabla)
		{
		   // Obtiene el contenido de la tabla indicada
           var tabla = $("#" + id_tabla).html();
           // Añade los tags de tabla
           tabla = "<table>" + tabla + "</table>";
           // Almacena en el campo oculto los datos a exportar
          $("#datos_a_enviar").val( tabla );
          // Activa el formulario, el cual lanza el código en PHP
           $("#" + id_form).submit();
       }
	
	  $("#exportar").click(function(){
		
	    exportar_excel('form_excel', 'tabladatos');
	
	  });
	  
	
	$("#pdf").click(function(){
		
		 html= $('.Utilizacion').html();
		 
	  cadenahtml='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title> Consulta       Utilizacion</title></head> <body style="margin-top:30px; margin-left:220px; margin-right:220px;"><table        class="Utilizacion" id="Utilizacion" cellpadding="0" cellspacing="0" > '+html+ '</table></body> </html>'
	   $("#html").text(cadenahtml);//al text area le asigno toda la variable html							  
	   $("#frmpdf").submit();//envio el formulario
	
	});
	
	$("#print").click(function(){
	  $("#tabladatos").printArea();	
	});	
	
	
	$("#searchall").button().click(function () {
		
		horaI= $("#horaI").val();
	    horaF= $("#horaF").val();
		desde= $("#desde").val();
	    hasta= $("#hasta").val();
		$("#idreporte").val("");
		$("#idreporte").val("Reporte Utilización");
			
		 if(horaI=="")
	     {
	        horaI="Null";
	     }
	
	
	     if(horaF=="")
	     {
	       horaF="Null";
	     }
		  
		var options = {
				 
		  classerror:"ui-state-error",
		  classdone:"ui-state-highlight",
		  contentmsg:"validateErrors",
		  fields:[
		  {
			 id:"desde",
			 validations:{
						 
				required:[true,"El campo Consulta Desde no puede estar vacio."],
						 
			  }
		 }
		 ,
		 {
			 id:"hasta",
			 validations:{
			 required:[true,"El campo Consulta Hasta no puede estar vacio."],
						     
		 }				  
		}
				  
	   ],
				  				  
		 beforeValidation:function()
		 {
			$.ajax({
					
			  type:'POST',
			  dataType:'html',
			  url: 'consultas/Utilizacion/Informetotal.php',
			  data:'desde='+desde+'&hasta='+hasta+'&HoraI='+horaI+'&HoraF='+horaF,
			  success: function(datos){
					
			   if(datos!=0)
			  {
			    $("#tabladatos").html(datos);	
						   
			  }  		
			}	  
			
		   });
		 }
		};
	   $.validation(options);   	
	});
	
	$("#searchsources").button().click(function () {
		
		horaI= $("#horaI").val();
	    horaF= $("#horaF").val();
		desde= $("#desde").val();
	    hasta= $("#hasta").val();
		$("#idreporte").val("");
		$("#idreporte").val("Reporte Utilización Recursos");
			
		 if(horaI=="")
	     {
	        horaI="Null";
	     }
	
	
	     if(horaF=="")
	     {
	       horaF="Null";
	     }
		  
		var options = {
				 
		  classerror:"ui-state-error",
		  classdone:"ui-state-highlight",
		  contentmsg:"validateErrors",
		  fields:[
		  {
			 id:"desde",
			 validations:{
						 
				required:[true,"El campo Consulta Desde no puede estar vacio."],
						 
			  }
		 }
		 ,
		 {
			 id:"hasta",
			 validations:{
			 required:[true,"El campo Consulta Hasta no puede estar vacio."],
						     
		 }				  
		}
				  
	   ],
				  				  
		 beforeValidation:function()
		 {
			$.ajax({
					
			  type:'POST',
			  dataType:'html',
			  url: 'consultas/UtilizacionRecursos/InformeTotal.php',
			  data:'desde='+desde+'&hasta='+hasta+'&HoraI='+horaI+'&HoraF='+horaF,
			  success: function(datos){
					
			   if(datos!=0)
			  {
			    $("#tabladatos").html(datos);	
						   
			  }  		
			}	  
			
		   });
		 }
		};
	   $.validation(options);   	
	});
	
	
	$("#limpiar").button().click(function() {
	  $("#desde").val("");
	  $("#hasta").val("");
	  $("#horaI").val("");
	  $("#horaF").val("");	
	  $("#desde").focus();	
		
   });
	
			            
  }); // cierra el jquery


</script>



</head>

<body>
 
<p id="validateErrors"></p>

        
   <div class="text ui-widget-content ui-corner-all" style="width:670px; height:auto; font-size:12px; margin-bottom:15px; background-color:#F8F8F8; background-repeat:repeat-y">
    <div class="ui-state-default" style="margin-bottom:10px; text-align:center;">CONSULTA UTILIZACION</div>      
         
       <table style="margin-left:15px;">
         
        <tr>
        	<td><label>Consulta Desde:</label></td>
            <td><input type="text" id="desde" size="30" class="text ui-widget-content ui-corner-all height font12" title="Recuerde que la fecha consulta desde debe ser menor a la fecha consulta hasta"/></td>
            
        </tr>
        
        <tr>
        	<td><label>Consulta Hasta:</label></td>
            <td><input type="text" id="hasta" size="30" class="text ui-widget-content ui-corner-all height font12" title="Recuerde que la fecha consulta hasta debe ser mayor a la fecha consulta desde"/></td>
       </tr>
           
        <tr>
          <td><label>Hora Inicial:</label></td>
          <td><input type="text" size="10" id="horaI" class="text ui-widget-content ui-corner-all height font12" /></td>
       </tr>
       
       <tr>   
        <td><label>Hora Final:</label></td>
        <td><input type="text" size="10" id="horaF" class="text ui-widget-content ui-corner-all height font12"/></td>  
       </tr>
        
        
        <tr>
         
         <td> <button type="button" id="searchall" style="font-size:11px; margin-top:10px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Informe Total </button> </td>
         <td> <button type="button" id="searchsources" style="font-size:11px; margin-top:10px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Utilización de Recursos</button> </td>
         <td> <button type="button" id="limpiar" style="font-size:11px; margin-top:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/>Limpiar</button> </td>
        </tr>
        
        </table>
       
     
       <div id="tabladatos" style="margin-top:20px; margin-bottom:20px; margin-left:20px; min-width:0; max-width:620px; max-height:500px; min-height:0px; overflow: auto;">
       
       </div>
       
       
       
    </div>
    
    <div id="alertas"></div>
    
    <p><a href="#" id="exportar"  title="Exportar a Excel" style="padding-top:5px;"><img src="images/exportaraexcel.png" /></a><a href="#"  title="Exportar a Pdf" id="pdf"> <img src="images/Exportarapdf.png" /></a> <a href="#"  title="Imprimir" id="print"> <img src="images/document-print.png" /></a> </p>
    
   
    
    <form action="forms/ReportesAdministrador/Utilizacion/FicheroExcel.php" id="form_excel" 
              method="post" target="_blank">
          <!-- Inicia el proceso de exportar --> 
         <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>
         <input type="hidden" id="idreporte" name="idreporte"/>  
        </form>
    
    


<form action="forms/ReportesAdministrador/Utilizacion/formpdf.php" method="post" id="frmpdf">
  <textarea id="html" name="html">
  <input type="hidden" id="idreporte" name="idreporte"/>
  </textarea>
</form>
        
        
    
</body>
</html>

