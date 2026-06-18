
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cupi-Control de Utilizacion Piso Informatico</title>

<script type="text/javascript" >
$(function () {

	$("#busquedaavanzmonitor").hide();
	$("#cedula").focus();
	
// Evento que llama a la funcion consultarusuario al dar click 	
$('#enviar').button().click(function(){

   consultarmonitor();

});

// Evento que al dar click una vez muestra el formulario, al dar click nuevamente lo esconde
$("#BusquedaA").button().toggle(function(){
	
   $("#busquedaavanzmonitor").show("slide");
	
},function() {
	
  $("#busquedaavanzmonitor").hide("slide");	
  $("#mostrarbusqueda").empty();
	
});

// evento que llama a a la funcion BusquedaUsuarioAvanzada al dar click en el boton correspondiente
$("#Buscar").button().click(function(){
	
	BusquedaMonitorAvanzada();
	
});	


  // Evento que limpia el formulario
    $("#limpiarform").button().click(function(){
			
		  $("#cedula").val("");
		  $("#codigo").val("");
		  $("#nombres").val("");
		  $("#apellidos").val("");
		  $("#progacademico").val("");
		  $("#dirresidencia").val("");
		  $("#celular").val("");
		  $("#telefono").val("");
		  $("#email").val("");
		  $("#estado").val("");
		  $("#busquedaavanzmonitor").hide();	
          $("#mostrarbusqueda").empty();
		  $("#cedula").focus();
		  $("#searchString").focus();	
		  
	});
	
	
		

  
  // Evento que llama a la funcion BusquedaUsuarioAvanzada al presionar la tecla enter
  $("#searchString").keydown(function(event) {
	  
	 if (event.keyCode == '13') {
	    event.preventDefault();
	    BusquedaMonitorAvanzada();
    } 
  });	
  
    // Se especifican los parametros para las alertas
	$("#alertas" ).dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			modal:true		
    });	
	
		  
        // Funcion que especifica el tipo de alertas a utilizar
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



// Funcion que realiza una busqueda avanzada dependiendo de ciertos parametros
function BusquedaMonitorAvanzada()
{
	
	 var options = {
				 
	  classerror:"ui-state-error",
	  classdone:"ui-state-highlight",
	  contentmsg:"validateErrors",
	  fields:[
	  {
	    id:"searchString",
		validations:{
		 required:[true,"El campo de busqueda no puede estar vacio."]
		
		}
	 }
	],
				 
  beforeValidation:function(){
	
	// parametros de busqueda
	cadena= $("#searchString").val();
	campobusqueda=$("#searchField").val();
	parametro= $("#searchOper").val();
	
  // se hace una llamada ajax a la url especificada	
   $.ajax({
	type:'POST',
	url: 'consultas/Monitores/BusquedaAvanzadaMonitor.php',
	data:'searchString='+cadena+'&searchField='+campobusqueda+'&searchOper='+parametro,
	success: function(datos){
		
		// muestra el formulario con los resultados de la busqueda
		$("#mostrarbusqueda").html(datos);
	 }
    });
   }
 };
  $.validation(options);   	
	
}




// Evento que llama a la funcion consultarusuario al presionar la tecla enter
$("#cedula").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') {
	  
	     event.preventDefault();
	      consultarmonitor();
		 
	   } 
	
	});	
	
	
  // Funcion que realiza la busqueda de un monitor
     function consultarmonitor(){

        var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"cedula",
					  validations:{
						  required:[true,"El campo Cedula no puede estar vacio."],
						 }
				  }
				 ],
				 
				   beforeValidation:function()
				  {
				     cedula=$('#cedula').val();
				
				   //se hace una llamada ajax a la url especificada
				   $.ajax({
					   
					 type:'POST',
					 dataType:'json',
					 url: 'consultas/Monitores/consultarMonitor.php',
					 data:'cedula='+cedula,
					 success: function(datos)
					 {
						 
						  // si se tiene una respuesta afirmativa de la llamada ajax se asignan los valores devueltos a cada campo de texto
						        if(datos.error==0) 
								{			
									  $("#cedula").val(datos.cedula);
									  $("#codigo").val(datos.codigo);
									  $("#nombres").val(datos.nombres);
									  $("#apellidos").val(datos.apellidos);
									  $("#progacademico").val(datos.programa);
									  $("#dirresidencia").val(datos.direccion);
									  $("#celular").val(datos.celular);
									  $("#telefono").val(datos.telefono);
									  $("#email").val(datos.email);
									  $("#estado").val(datos.estado);
									 
								 
								}
								
								else if (datos.error==1)
								{
								   alertas("El monitor no existe o no esta activo en el sistema","Consultar Monitor","error");
									
								}
								
					  }// cierro success
		            });// cierro ajax
				  
				   } // cierro before validation
		         };
		       $.validation(options);   		  
	}// cierro funcion
				
});

</script>

</head>

<body>


<p id="validateErrors"></p>

<div class="text ui-widget-content ui-corner-all" style="width:500px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CONSULTAR MONITOR</div>
     
        <table style="margin-left:15px;">
       
        <tr>
          <td><label for="cedula">Cedula:</label></td>
          <td><input type="text" name="cedula" id="cedula" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td>
        </tr> 
       
        <tr>
          <td><label for="codigo">Codigo:</label></td>
          <td><input type="text" name="codigo" id="codigo" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td>
        </tr>
       
        <tr>
          <td><label for="nombres">Nombres:</label></td>
          <td><input type="text" name="nombres" id="nombres" size="50" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
        
        <tr>
          <td><label for="apellidos">Apellidos:</label></td>
          <td><input type="text" name="apellidos" id="apellidos" size="50" class="text ui-widget-content ui-corner-all height font12"/></td>      
        </tr>
        
         <tr>
          <td><label for="progacademico">Programa Academico:</label></td>
          <td><input type="text" name="progacademico" id="progacademico" size="50" class="text ui-widget-content ui-corner-all height font12"/></td>      
        </tr>
        
        <tr>
          <td><label for="dirresidencia">Direccion Residencia:</label></td>
          <td><input type="text" name="dirresidencia" id="dirresidencia" size="50" class="text ui-widget-content ui-corner-all height font12"/></td>      
        </tr>
        
        <tr>
          <td><label for="celuar">Celular:</label></td>
          <td><input type="text" name="celular" id="celular" size="20" class="text ui-widget-content ui-corner-all height font12"/></td>      
        </tr>
        
        <tr>
          <td><label for="telefono">Telefono:</label></td>
          <td><input type="text" name="telefono" id="telefono" size="20" class="text ui-widget-content ui-corner-all height font12"/></td>      
        </tr>
        
        <tr>
          <td><label for="email">Correo electronico:</label></td>
          <td><input type="text" name="email" id="email" size="50" class="text ui-widget-content ui-corner-all height font12"/></td>      
        </tr>
      
       <tr>
        <td> <label>Estado:</label></td>
        <td><input type="text"  id="estado" size="15"  class="text ui-widget-content ui-corner-all height font12" /></td>                      
       </tr>  
     </table>
     
     
     <table style="margin-left:15px;"> 
     
      <tr>
      
      <td> <button type="button" id="enviar" style="font-size:11px; margin-top:10px; "><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button> </td>
      <td><button type="button" id="limpiarform" style="font-size:11px; margin-top:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/>Limpiar</button></td>
      <td> <button type="button" id="BusquedaA" style="font-size:11px; margin-top:10px;"><img src="images/buscar1.png" style="vertical-align:middle; padding-right:4px;"/>Busqueda Avanzada</button> </td>
     </tr>
   </table>
      
    </div>
    
    
    <div id="busquedaavanzmonitor" class="text ui-widget-content ui-corner-all" style="width:620px; height:100px; margin-top:20px; background-color:#F8F8F8; background-repeat:repeat-y">
      <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">BUSQUEDA AVANZADA MONITOR</div>
      
      <table style="margin-left:15px;">
      <tr>
       <td><label>Buscar Por:</label></td>
       <td>
       <select size="1" id="searchField">
         <option value="vccedula">Cedula</option>
         <option value="vccodigo">Codigo</option> 
         <option value="vcnombres">Nombres</option> 
         <option value="vcapellidos">Apellidos</option>
         <option value="vcprogramaacademico">Programa Academico</option> 
         <option value="vcdireccionresidencia">Direccion Residencia</option> 
         <option value="vccelular">Celular</option> 
         <option value="vctelefonofijo">Telefono Fijo</option>
         <option value="vcemail">Email</option> 
       </select>
       </td>
       
       <td>
        <select size="1" id="searchOper">
         <option value="eq">Igual</option>
         <option value="ne">No igual a</option> 
         <option value="bw">Empiece por</option>
         <option value="bn">No empiece por</option> 
         <option value="ew">Termina por</option>
         <option value="en">No termina por</option> 
         <option value="cn">Contiene</option>
         <option value="nc">No contiene</option> 
       </select>
       
       </td>
      
       <td><input type="text" id="searchString" size="20" class="text ui-widget-content ui-corner-all"/></td>
      </tr>
      
      <tr>
        <td><button type="button" id="Buscar" style="font-size:11px;"><img src="images/buscar1.png" style="vertical-align:middle; padding-right:4px;"/>Buscar</button></td>
      </tr>
      
      </table>
      
     </div> 
     
     <div id="mostrarbusqueda" style="margin-top:20px; margin-bottom:20px; overflow:auto;  max-width:620px; min-height:0px; max-height:250px;">
     
     </div>
    
 <div id="alertas"></div>  
   
    
</body>

</html>
