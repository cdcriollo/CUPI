
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cupi-Control de Utilizacion Piso Informatico</title>

<script type="text/javascript" >
$(function () {
	
	$('#nomusu').attr('disabled','disabled');
	$('#estamento').attr('disabled','disabled');
	$('#dependencia').attr('disabled','disabled');
	$('#estado').attr('disabled','disabled');
	$('#apellidos').attr('disabled','disabled');
	$("#busquedaavanzusu").hide();
	$("#codusu").focus();
	
// Evento que llama a la funcion consultarusuario al dar click 	
$('#enviar').button().click(function(){

   consultarusuario();

});

// Evento que al dar click una vez muestra el formulario, al dar click nuevamente lo esconde
$("#BusquedaA").button().toggle(function(){
	
   $("#busquedaavanzusu").show("slide");
	
},function() {
	
  $("#busquedaavanzusu").hide("slide");	
  $("#mostrarbusqueda").empty();
	
});

// evento que llama a a la funcion BusquedaUsuarioAvanzada al dar click en el boton correspondiente
$("#Buscar").button().click(function(){
	
	BusquedaUsuarioAvanzada();
	
});	


  // Evento que limpia el formulario
    $("#limpiarform").button().click(function(){
			
		  $("#codusu").val("");
		  $("#nomusu").val("");	
		  $("#estamento").val("");	
		  $("#dependencia").val("");	
		  $("#estado").val("");	
		  $("#apellidos").val("");
		  $("#searchString").val("");
		  $("#mostrarbusqueda").empty();	
		  $("#codusu").focus();
		  $("#searchString").focus();	
		  
	});
	
	
		

  
  // Evento que llama a la funcion BusquedaUsuarioAvanzada al presionar la tecla enter
  $("#searchString").keydown(function(event) {
	  
	 if (event.keyCode == '13') {
	    event.preventDefault();
	    BusquedaUsuarioAvanzada();
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
function BusquedaUsuarioAvanzada()
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
	url: 'consultas/Usuario/BusquedaAvanzadaUsuario.php',
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
$("#codusu").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') {
	  
	     event.preventDefault();
	      consultarusuario();
		 
	   } 
	
	});	
	
	
  // Funcion que realiza la busqueda de un usuario
     function consultarusuario(){

        var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codusu",
					  validations:{
						 
						  required:[true,"El campo Codigo no puede estar vacio."],
						  number:[true,"El campo Codigo debe contener numeros."],
						  clength:["5-12","El campo Codigo debe tener como minimo 5 caracteres maximo 12."]
						 }
				  }
				 ],
				 
				   beforeValidation:function()
				  {
				     codigo=$('#codusu').val();
				
				   //se hace una llamada ajax a la url especificada
				   $.ajax({
					   
					 type:'POST',
					 dataType:'json',
					 url: 'consultas/Usuario/consultarusuario.php',
					 data:'codigo='+codigo,
					 success: function(datos)
					 {
						 
						  // si se tiene una respuesta afirmativa de la llamada ajax se asignan los valores devueltos a cada campo de texto
						        if(datos.error==0) 
								{			
									 nombre= datos.nombre;
									 estamento= datos.estamento;
									 dependencia=datos.dependencia;
									 estadousuario=datos.estado;
									 apellidos=datos.apellidos;
									 $('#nomusu').val(nombre); 
									 $('#estamento').val(estamento); 	
									 $('#dependencia').val(dependencia);
									 $('#estado').val(estadousuario);
									 $('#apellidos').val(apellidos);
									 $('#nomusu').attr('disabled','');
									 $('#estamento').attr('disabled','');
									 $('#dependencia').attr('disabled','');
									 $('#estado').attr('disabled','');
									 $('#apellidos').attr('disabled','');
								 
								}
								
								else if (datos.error==1)
								{
								   alertas("El usuario no existe o no esta activo en el sistema","Consultar Usuario","error");
									
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

<div class="text ui-widget-content ui-corner-all" style="width:400px; height:230px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CONSULTAR USUARIO</div>
     
        <table style="margin-left:15px;">
       
        <tr>
        	<td><label for="titulo">Codigo:</label></td>
            <td><input type="text" name="codusu" id="codusu" size="15"  class="text ui-widget-content ui-corner-all height font12" title="Presione enter dentro del cajon de texto para traer la consulta"/></td>
            
            
       </tr>
       
        <tr>
        	<td><label>Nombre:</label></td>
            <td><input type="text" name="nomusu" id="nomusu" size="25"class="text ui-widget-content ui-corner-all height font12"/></td>
             
        </tr>
        
        <tr>
        	<td><label>Apellidos:</label></td>
            <td><input type="text" name="apellidos" id="apellidos" size="25"class="text ui-widget-content ui-corner-all height font12"/></td>
             
        </tr>
       
       
        <tr>
        	<td><label for="estamento">Estamento:</label></td>
            <td><input type="text" name="estamento" id="estamento" size="32" class="text ui-widget-content ui-corner-all height font12"/></td>
           
                             
            
      </tr>
      
     
      
      <tr>
        	<td> <label for="dependencia">Dependencia:</label></td>
            <td><input type="text" name="dependencia" id="dependencia" size="32" class="text ui-widget-content ui-corner-all height font12"/></td>                    
             
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
    
    
    <div id="busquedaavanzusu" class="text ui-widget-content ui-corner-all" style="width:470px; height:100px; margin-top:20px; background-color:#F8F8F8; background-repeat:repeat-y">
      <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">BUSQUEDA AVANZADA USUARIO</div>
      
      <table style="margin-left:15px;">
      <tr>
       <td><label>Buscar Por:</label></td>
       <td>
       <select size="1" id="searchField">
         <option value="codUsuario">Codigo</option>
         <option value="nombreUsu">Nombre</option> 
         <option value="apellidos">Apellidos</option> 
         <option value="estamento">Estamento</option>
         <option value="dependencia">Dependencia</option> 
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
