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
$query_JRGrupo = "SELECT * FROM grupo";
$JRGrupo = mysql_query($query_JRGrupo, $conexion) or die(mysql_error());
$row_JRGrupo = mysql_fetch_assoc($JRGrupo);
$totalRows_JRGrupo = mysql_num_rows($JRGrupo);

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
	 
	 $("#final").datepicker({ 
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
        
	
	function traerdatosasignatura(asignatura, grupo)
	{
		
		var options = {
				  
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codAsig",
					  validations:{
						 
						  required:[true,"El campo Codigo Asignatura no puede estar vacio."],
						  }
				  },
				  
				   {
					  id:"grupo",
					  validations:{
						 
						  required:[true,"El campo grupo no puede estar vacio."],
						  number:[true,"El campo grupo debe ser numerico."]
						  }
				  },
				  
				  {
					  id:"comienzo",
					  validations:{
						 
						  required:[true,"El campo comienzo no puede estar vacio."],
						  }
				  },
				  
				  {
					  id:"final",
					  validations:{
						 
						  required:[true,"El campo finalizacion no puede estar vacio."],
						  }
				  }
				  ],	
				  			  
		  beforeValidation:function(){
					  
		
		  $.ajax({
				
			type: 'POST',
			 url: 'consultas/Asistencia/consultardatosasignatura.php',
			data: 'asignatura='+asignatura+'&grupo='+grupo,
			success: function(datos){
			  
			  if(datos==1)
			  {
				  alertas("Por favor verifique que la asignatura existe o el grupo existe", "Reporte Asistencia","error"); 
			  }
			  else if(datos!=0)
			  {   
			      Nombreasignatura=datos;
				  $("#nomAsig").val(Nombreasignatura);
				  ReporteAsistencia();  
			  }
				
			}
			
		});
	  }
	 }; 
	 $.validation(options);  
  }
  
  
  function traerdatosasignaturausuario(asignatura,usuario, grupo)
	{
		
		var options = {
				  
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  
				  {
					  id:"coduser",
					  validations:
					    {
						 
						  required:[true,"El campo usuario no puede estar vacio."],
						  number:[true,"El campo usuario no puede contener letras."],
						}
				  },
				   
				   
				    {
					  id:"comienzo",
					  validations:{
						 
						  required:[true,"El campo comienzo no puede estar vacio."],
						  }
				  },
				  
				  {
					  id:"final",
					  validations:{
						 
						  required:[true,"El campo finalizacion no puede estar vacio."],
						  }
				  }
				  ],	
				  			  
		  beforeValidation:function(){	  
		
		  $.ajax({
				
			type: 'POST',
			 url: 'consultas/Asistencia/consultardatosasignaturausuario.php',
			data: 'asignatura='+asignatura+'&usuario='+usuario+'&grupo='+grupo,
			success: function(datos){
			  
			   if(datos==3)
			  {
				 alertas("Por favor verifique que la asignatura el grupo y el usuario existen", "Reporte Asistencia","error"); 
			  }
			  else if(datos==2)
			  {
				 alertas("El usuario no existe", "Reporte Asistencia","error"); 
			  }
			  else if(datos==1)
			  {
				  alertas("Por favor verifique que la asignatura existe o el grupo existe", "Reporte Asistencia","error");
			  }
			  
			  
			  else if(datos!=0)
			  {   
			      datosasignaturausuario=datos.split(',');
				  $("#nomAsig").val(datosasignaturausuario[0]);
				  $("#nomuser").val(datosasignaturausuario[1]);
				  ReporteAsistenciaUsuario();  
			  }
			 
			  
				
			}
			
		});
	  }
	 }; 
	 $.validation(options);  
  }
	
	
 
  function ReporteAsistencia()
  {
 
	var codigo= $("#codAsig").val();
	var grupo=$('#grupo').val();
	var fechainicial=$("#comienzo").val();
	var fechafinal=$("#final").val();
	
	var options = {
				  
		 classerror:"ui-state-error",
		 classdone:"ui-state-highlight",
		 contentmsg:"validateErrors",
		 fields:[
		 {
			 id:"codAsig",
			 validations:
			 {
				required:[true,"El campo Codigo Asignatura no puede estar vacio."],
			 }
		 },
				  
		  {
			 id:"grupo",
			 validations:{
						 
			    required:[true,"El campo grupo no puede estar vacio."],
				number:[true,"El campo grupo debe ser numerico."]
		  }
		 },
				  
		  {
			   id:"comienzo",
			   validations:{
					required:[true,"El campo comienzo no puede estar vacio."],
		  }
		 },
				  
		 {
			  id:"final",
			  validations:{
				 required:[true,"El campo finalizacion no puede estar vacio."],
		  }
		 }
		],	
				  			  
	beforeValidation:function(){
						
		$.ajax({
				
			type: 'POST',
			url: 'consultas/Asistencia/consultaReporteAsistencia.php',
			data: 'asignatura='+codigo+'&grupo='+grupo+'&comienzo='+fechainicial+'&final='+fechafinal,
			success: function(datos){
						 
			if(datos)
			{				
			  $("#MostrarReporteAsistencia").html(datos);
									
			}
			else{
									
		     alertas("Por favor verifique los datos","error"); 
			}
		  }
		});	
		 }
	 }; 
	 $.validation(options);  
     }
	 
	 
 function ReporteAsistenciaUsuario()
  {
 
	var user=$("#coduser").val();
	var fechaI=$("#comienzo").val();
	var fechaF=$("#final").val();
	
	   var options = {
				  
		 classerror:"ui-state-error",
		 classdone:"ui-state-highlight",
		 contentmsg:"validateErrors",
		 fields:[
				  
		   {
			  id:"coduser",
			  validations:
			{
						 
				required:[true,"El campo usuario no puede estar vacio."],
				number:[true,"El campo usuario no puede contener letras."],
			 }
		   },
				   
				   
		   {
			    id:"comienzo",
			    validations:{
		        required:[true,"El campo comienzo no puede estar vacio."],
		   }
		 },
				  
		  {
			    id:"final",
			    validations:{
				required:[true,"El campo finalizacion no puede estar vacio."],
		  }
		 }
	    ],	
				  			  
		beforeValidation:function(){	  
						
		$.ajax({
				
			type: 'POST',
			url: 'consultas/Asistencia/consultaReporteAsistenciaUsuario.php',
			data: 'usuario='+user+'&comienzo='+fechaI+'&final='+fechaF,
			success: function(datos)
			{
						 
				if(datos){						   						
				  $("#MostrarReporteAsistencia").html(datos);									
				}
				else{									
				  alertas("Por favor verifique los datos","error"); 
				}
		   }
		});	
	   }
	  }; 
	  $.validation(options);  
    }
	 

	  $("#grupo").keydown(function(event) {
	  
	       if (event.keyCode == '13') 
		   {
	         event.preventDefault();
			 $("#coduser").val("");
			 ReporteAsistencia();  
          } 
       });	
	   
	    $("#coduser").keydown(function(event) {
	  
	       if (event.keyCode == '13') 
		   {
	         event.preventDefault();
			 $("#codAsig").val("");
			 grupo=$("#grupo").val("");
		     usuario=$("#coduser").val();		     
			 ReporteAsistenciaUsuario();  
          } 
       });	
	   
	    

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
		
	   exportar_excel('form_excel_asistencia', 'DatosRAsistencia');
	
	});
	
	$("#pdf").click(function(){
		
		 html= $('.DatosRAsistencia').html();
		
		cadenahtml='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>Reporte Asistencia</title></head> <body style="margin-top:20px; margin-left: 20px; margin-right: 20px;  margin-button:20px;"><center><table class="DatosRAsistencia" id="DatosRAsistencia" cellpadding="0" cellspacing="0" > '+html+ '</table></center></body> </html>'
		
		$("#html").text(cadenahtml);//al text area le asigno toda la variable html
		
										  
	   $("#frmpdf").submit();//envio el formulario
	
	
	});
	
	$("#print").click(function(){
		$("#MostrarReporteAsistencia").printArea();
			
	});

   $("#limpiarform").button().click(function() {
		  
	 $('#comienzo').val("");
	 $('#final').val("");
	 $('#codAsig').val("");
	 $('#grupo').val("");
	 $('#nomAsig').val("");
	 $('#coduser').val("");
	 $('#nomuser').val("");
	 $("#MostrarReporteAsistencia").empty();
	 $("#comienzo").focus(); 
		  
   });	
	

});// cierro jquery



</script>



</head>

<body>

 <p id="validateErrors"></p>

        <div id="formreporteasignatura" class="text ui-widget-content ui-corner-all" style="width:500px;  margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y"">
        
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">REPORTE DE ASISTENCIA</div>
         
         <table style="margin-left:15px;">
          <tr>
        	
            <td><label for="comienzo">Comienzo:</label></td>
            <td><input type="text" name="comienzo"  size="15" class="text ui-widget-content ui-corner-all height font12" id="comienzo" title="Recuerde que la fecha de              comienzo debe ser menor a la fecha de finalizacion"/></td>
        	<td><label for="periodo">finalizacion:</label></td>
            <td><input type="text" name="final"  size="15" maxlength="128"   class="text ui-widget-content ui-corner-all height font12" id="final" title="Recuerde que la              fecha de finalizacion debe ser mayor a la fecha de comienzo"/></td>         
         </tr> 
       </table>
         
        <table style="margin-left:15px;">
        <tr>
        	<td><label for="codigo">Codigo Asignatura:</label></td>
            <td><input type="text" name="codAsig" id="codAsig" size="20" class="text ui-widget-content ui-corner-all height font12"/></td>
            <td><label for="grupo">Grupo:</label></td>
            <td> <input type="text" size="5" id="grupo" class="text ui-widget-content ui-corner-all height font12" title="Presione enter dentro del cajon de texto para realizar una consulta de asistencia por asignatura y grupo" ></td>            
        </tr>
        </table>
                
       <table  style="margin-left:15px;"> 
       <tr>
         <td><label>Codigo Usuario:</label></td>
         <td><input type="text" id="coduser" size="15"  class="text ui-widget-content ui-corner-all height font12" title="Presione enter dentro del cajon de texto para realizar una consulta de asistencia por asignatura, grupo y usuario"/></td>
         
       </tr>
       </table>
       
     <table style="margin-left:15px;">
       <tr>
         <td>
        <button type="button" id="limpiarform" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/> Limpiar</button>
        </td>
       </tr>       
     </table>      
        
    </div>
    
     
  <div id="MostrarReporteAsistencia" style="margin-bottom:15px; min-width:0; max-width:618px; max-height:500px; min-height:0px; overflow: auto; visibility: visible;"></div>
 
 
  <p><a href="#" id="exportar"  title="Exportar a Excel" style="padding-top:5px;"><img src="images/exportaraexcel.png" /></a><a href="#"  title="Exportar a Pdf" id="pdf"> <img src="images/Exportarapdf.png" /></a> <a href="#"  title="Imprimir" id="print"> <img src="images/document-print.png" /></a> </p>

 <form action="forms/ReportesAdministrador/Asistencia/FicheroExcelRepAsistencia.php" id="form_excel_asistencia"  method="post" target="_blank">
          <!-- Inicia el proceso de exportar -->
        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>  
 </form>
 
 
 <form action="forms/ReportesAdministrador/Asistencia/formpdfasistencia.php" method="post" id="frmpdf">
   <textarea id="html" name="html"></textarea>
</form>


 <div id="alertas"></div>
     
</body>
</html>
<?php
mysql_free_result($JRGrupo);


?>


