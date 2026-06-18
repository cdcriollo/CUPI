<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cupi-Control Utilizacion Piso Informatico</title>

 <script type="text/javascript">

 $(function() {
	
	$('#nomusu').attr('disabled','disabled');
	$('#estamento').attr('disabled','disabled');
	$('#dependencia').attr('disabled','disabled');
	$('#estado').attr('disabled','disabled');
	$('#apellidos').attr('disabled','disabled');
	$("#codusu").focus();
	
	
	
	    $("#alertas" ).dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			modal:true		
		});
		
		
	 $("#codusu").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') 
	   {
	      event.preventDefault();
	      consultarusuario(); 
	   } 
	
	 });
	 
	 
	  // Evento que limpia el formulario
    $("#limpiarform").button().click(function(){
			
		  $("#codusu").val("");
		  $("#nomusu").val("");	
		  $("#estamento").val("");	
		  $("#dependencia").val("");	
		  $("#estado").val("");	
		  $("#apellidos").val("");	
		  $("#codusu").focus();	
	});		
		
	$("#canceluser" ).dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			title:"Inactivar Usuario",
			modal:true,
			
			buttons: 
			{
				"Aceptar": function() 
				{
					codigo=$('#codusu').val();
		            tabla="usuarios";
					cancelarusuario(codigo,tabla);
					$( this ).dialog( "close" );
				},
				Cancelar: function() {
					$( this ).dialog( "close" );
				}
			}		
    });
		
		function cancelarusuario(codigo,tabla)
		{
			
			$.ajax({
			  
			 type: 'POST',
		     url: 'funciones/Usuario/Cancelarusuario.php',
			 data: 'llave='+codigo,
			 success: function(datos){
						
			 if(datos==1)
			 {
				alertas("El usuario ha sido inactivado exitosamente","Inactivar Usuario","done");
				limpiarformulario();
				$("#codusu").focus();	
			}
			else
			{
			  alertas("Por favor verifique los datos","Inactivar Usuario","error");
			}
		  }
		});	
	  }
	  
	 function limpiarformulario()
	 {
	     $("#codusu").val("");
		 $("#nomusu").val("");
		 $("#estamento").val("");
		 $("#dependencia").val("");
		 $("#estado").val("");
		 $("#apellidos").val("");
	 }
		
		
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
	
	
	   $("#cancelarUsuario").button().click(function() {
		   
		   var options = {
				 
				classerror:"ui-state-error",
				classdone:"ui-state-highlight",
				contentmsg:"validateErrors",
				fields:[
				{
				  id:"codusu",
				  validations:
				  {
					  required:[true,"El campo Codigo no puede estar vacio."],
					  number:[true,"El campo Codigo debe contener numeros."]  
				  }
			    }
				],
				 
				beforeValidation:function()
				{
	              $("#canceluser").dialog("open"); 
				}
			   };
			  $.validation(options);   	
	
	   });// cierro enviar
	  
	  
	  function consultarusuario()
	  
	  {
	       var options = {
				 
				classerror:"ui-state-error",
				classdone:"ui-state-highlight",
				contentmsg:"validateErrors",
				fields:[
				{
				  id:"codusu",
				  validations:
				  {
					  required:[true,"El campo Codigo no puede estar vacio."],
					  number:[true,"El campo Codigo debe contener numeros."]
					  
				  }
			    }
				],
				 
				beforeValidation:function()
				{
		           codigo=$('#codusu').val();

                   $.ajax({
					 type:'POST',
					 dataType:'json',
					 url: 'consultas/Usuario/consultarusuario.php',
					 data:'codigo='+codigo,
					 success: function(datos)
					 {
						 
						 if(datos.error==0) 
						 {			
							nombre= datos.nombre;
							estamento= datos.estamento;
							dependencia=datos.dependencia;
							estado=datos.estado;
							apellidos=datos.apellidos;
							
						    $('#nomusu').val(nombre); 
							$('#estamento').val(estamento); 	
							$('#dependencia').val(dependencia);
							$('#estado').val(estado);
							$('#apellidos').val(apellidos);
							$('#nomusu').attr('disabled','');
							$('#estamento').attr('disabled','');
							$('#dependencia').attr('disabled','');
							$('#estado').attr('disabled','');
							$('#apellidos').attr('disabled','');			 
						 }
						 else if(datos.error==1)
						 {
				            alertas("El usuario no existe o no esta activo en el sistema","Cancelar Usuario","error");
				         }
					 }
				    });
				   }
		          };
				  $.validation(options);   	
		 }	   
						 			 
   }); // cierra el jquery




</script>


</head>

<body>

<p id="validateErrors"></p>

 <div class="text ui-widget-content ui-corner-all" style="width:400px; margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">INACTIVAR USUARIO</div>      
         
        <table style="margin-left:15px;">
       
        <tr>
        	<td><label>Codigo:</label></td>
            <td><input type="text" name="codusu" id="codusu" size="15" class="text ui-widget-content ui-corner-all height font12" title="Presione enter dentro del cajon de texto para traer la consulta"/></td>
               
       </tr>
       
        <tr>
          <td><label>Nombre:</label></td>
          <td><input type="text" name="nomusu" id="nomusu" size="40" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
        
        <tr>
          <td><label>Apellidos:</label></td>
          <td><input type="text"  id="apellidos" size="40" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
       
       
        <tr>
        	<td><label>Estamento:</label></td>
            <td><input type="text" name="estamento" id="estamento" size="32" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
      
        <tr>
          <td> <label>Dependencia:</label></td>
          <td><input type="text" name="dependencia" id="dependencia" size="32" class="text ui-widget-content ui-corner-all height font12"/></td>                    
        </tr>
        
        <tr>
          <td><label>Estado:</label></td>
          <td><input type="text" id="estado" size="15"  class="text ui-widget-content ui-corner-all height font12" /></td>                      
       </tr>  
      
      <tr>
        <td> <button type="button" id="cancelarUsuario" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/delete.png" style="vertical-align:middle; padding-right:3px;"/>Inactivar</button> </td> 
        <td><button type="button" id="limpiarform" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/>Limpiar</button></td> 
      </tr>
      
      </table>
    
   </div>
   
   <div id="alertas"></div>
   <div id="canceluser"><p style="font-size:12px;"><img src="images/dialog-warning.png" style="float:left; padding:5px;"/>ESTA SEGURO QUE QUIERE INACTIVAR EL USUARIO?</p></div>
</body>
</html>

