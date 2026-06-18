<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>

<script type="text/javascript" >
$(function () {
	$('#nomusu').attr('disabled','disabled');
	$('#estamento').attr('disabled','disabled');
	$('#dependencia').attr('disabled','disabled');
	
function mostrarDetalleasignaturas(codigo){


   $.ajax({
			
			type:'POST',
			url: 'consultas/Matricula/consultarmatricula1.php',
			data:'codigo='+codigo,
			success: function(datos){
				if(datos!=0){
				  $("#detalleasignaturas").html(datos)
				}
				
				
			}
		});

}	


  $("#codusu").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') {
	  
	     event.preventDefault();
	    consultarmatriculausuario();
		 
	   } 
	
	});	
	
	
$('#enviar').button().click(function(){
	
	consultarmatriculausuario();
	
});	

function consultarmatriculausuario()
{
    var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codusu",
					  validations:{
						 
						  required:[true,"El campo Codigo no puede estar vacio."],
						  number:[true,"El campo Codigo debe contener numeros."]
						 }
				  }
				 ],
				 
				     beforeValidation:function(){
				     codigo=$('#codusu').val();
					
				      $.ajax({
						 type:'POST',
						 url: 'consultas/Usuario/consultarusuario.php',
						 data:'codigo='+codigo,
					     success: function(datos){
						 
						        if(datos!=0) {			
									 datos1=datos.split('-');
									 nombre= datos1[0];
									 estamento= datos1[1];
									 dependencia=datos1[2];
									 $('#nomusu').val(nombre); 
									 $('#estamento').val(estamento); 	
									 $('#dependencia').val(dependencia);
									 $('#nomusu').attr('disabled','');
									 $('#estamento').attr('disabled','');
									 $('#dependencia').attr('disabled','');	 
									 
									 mostrarDetalleasignaturas(codigo);
								 
								}
								else{
									alertas("El usuario no existe o no esta activo en el sistema","Consultar Usuario","error");
									
								}
								
							  }
		             });
				  
				  } 
		};
		$.validation(options);   		  
      }


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
			  
			
});

</script>








</head>

<body>

<p id="validateErrors"></p>

<div class="text ui-widget-content ui-corner-all" style="width:630px; height:auto; font-size:12px;">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CONSULTAR POR USUARIO</div>
         
        <table style="margin-left:15px; margin-bottom:10px;">
       
        <tr>
        	<td><label for="titulo">Codigo</label></td>
            <td><input type="text" name="codusu" id="codusu" size="15"  class="text ui-widget-content ui-corner-all"/></td>
            
            
       </tr>
       
        <tr>
        	<td><label for="titulo">Nombre</label></td>
            <td><input type="text" name="nomusu" id="nomusu" size="32"class="text ui-widget-content ui-corner-all"/></td>
             
        </tr>
       
       
        <tr>
        	<td><label for="estamento">Estamento:</label></td>
            <td><input type="text" name="estamento" id="estamento" size="32" class="text ui-widget-content ui-corner-all"/></td>
           
                             
            
      </tr>
      
     
      
      <tr>
        	<td> <label for="dependencia">Dependencia:</label></td>
            <td><input type="text" name="dependencia" id="dependencia" size="32" class="text ui-widget-content ui-corner-all"/></td>                    
             
      </tr>
      
      <tr>
      
     
      
      <td> <button type="button" id="enviar" style="font-size:11px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button> </td>
      
      </tr>
      
      </table>
      
       <div id="detalleasignaturas"></div>
       
    </div>
    
 <div id="alertas"></div>  
</body>
</html>
