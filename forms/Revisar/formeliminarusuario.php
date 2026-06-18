<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<script type="text/javascript">
$(function() {
	
	
	
	$('#aceptar').click(function() {
		
	codigo=$('#codusu').val();
    opcion=2; 	  
    $.ajax({
					type:'POST',
					 url: 'consultas/consultarusuario.php',
					 data:'codigo='+codigo+'&opcion='+opcion,
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
								
								 Sexy.confirm('¿Esta seguro que quiere eliminar el usuario?', {
                                    onComplete:
                                       function(returnvalue) {
                                         if (returnvalue) {
                                           codigo=$('#codusu').val();
		                                   tabla="usuarios";
		  
		                            $.ajax({
			  
					                    type: 'POST',
					                    url: 'funciones/eliminarusuario.php',
					                    data: 'tabla='+tabla+'&llave='+codigo,
					                    success: function(datos){
						
						
								    if(datos==1){
									
									 Sexy.info("Los datos se han eliminado correctamente");
									 $('#contenedor').hide();
								   }
								   else{
									   Sexy.error("Por favor verifique los datos ");
								     }
							  }
		        
			               });
			
                      } 
	
                   }
  
                 });
								 	 
			}
			else{
				alert("El usuario no existe");
									
			}
								
	  }
	  
	});
	
  });
	 
}); // cierra el jquery




</script>


</head>

<body>

<form id="insertu"   method="post" class="niceform" id="header"  >

	<fieldset>
    	<legend>Usuarios Cancelar</legend>
         
        <table>
       
        <tr>
        	<td><label for="titulo">Codigo</label></td>
            <td><input type="text" name="codusu" id="codusu" size="32" maxlength="128"   class"required"/></td>
            
            
       </tr>
       
        <tr>
        	<td><label for="titulo">Nombre</label></td>
            <td><input type="text" name="nomusu" id="nomusu" size="32" maxlength="128"   class"required"/></td>
             
        </tr>
       
       
        <tr>
        	<td><label for="estamento">Estamento:</label></td>
            <td><input type="text" name="estamento" id="estamento" size="32" maxlength="128"   class"required"/></td>
           
                             
            
      </tr>
      
     
      
      <tr>
        	<td> <label for="dependencia">Dependencia:</label></td>
            <td><input type="text" name="dependencia" id="dependencia" size="32" maxlength="128"   class"required"/></td>                    
             
      </tr>
      
      <tr>
      
      <td> <input type="button" id="aceptar" value="Aceptar" /> </td>
      
      
      </tr>
      
      </table>
    
    </fieldset>
     
   </form>
</body>
</html>

