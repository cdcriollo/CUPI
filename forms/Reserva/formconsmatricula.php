
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>


<script type="text/javascript">

  $(function(){

	$("#html").hide();  
	$("#tabs").tabs();
	$("#tabladinamica").hide();
	$("#tabladinamica1").hide(); 
	
	$("#codusu").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') 
	  {
	     event.preventDefault();
	     buscarusuario();
	   } 
	
	});	
	
	
	$("#codG").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') 
	  {
	     event.preventDefault();
	     buscarAsignatura(); 
	   } 
	
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

	
	 
	
	function traerdatosUsuario(codigo)
	{
		
		$.ajax({
			
			type:'POST',
			url: 'consultas/Matricula/consultarmatricula1.php',
			data:'codigo='+codigo+'&opcion='+1,
			success: function(datos)
			{
				if(datos){
				  $("#tabladinamica").html(datos);
				  $("#tabladinamica").show(); 
				}
			}
		});	
	 }
	
	function traerdatosAsignatura(codigoA,grupoA,nombreA)
	{
		
		$.ajax({
			
			type:'POST',
			url: 'consultas/Matricula/ConsultarMatriculaReserva.php',
			data:'codigo='+codigoA+'&grupo='+grupoA+'&nombre='+nombreA,
			success: function(datos){
				
				if(datos)
				{
				  $("#tabladinamica1").html(datos);
				  $("#tabladinamica1").show();  	
				}
			   }
     	 });
	}
	
	
	
	function buscarusuario()
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
			   required:[true,"El campo Codigo no puede estar vacio"],
			   number:[true,"El campo codigo debe contener numeros."]
			 }
		  }
		],
				  				  
			beforeValidation:function()
			{
				
	          codigo= $("#codusu").val();
	
	           $.ajax({
			
				type:'POST',
				dataType:'json',
				url: 'consultas/Usuario/consultarUsuario.php',
				data:'codigo='+codigo,
				success: function(datos){
					if(datos.error==0)
					{
						var nombre=datos.nombre;
						var apellidos=datos.apellidos;
						var usuario=nombre+" "+apellidos;
						$("#nomusu").val(usuario);
						MostrarMatriculaUsuario(codigo);
						
					}
					else if(datos.error==0) 
					{
						
						alertas("El usuario no existe","Consultar Matricula Usuario","error"); 	
					}
				  }
			  });
		    }
		   };
		  $.validation(options); 
		}		  
		    
		
	
	function buscarAsignatura()
	{
	
	   var options = {
				  
		  classerror:"ui-state-error",
		  classdone:"ui-state-highlight",
		  contentmsg:"validateErrors",
		  
		   fields:[
		   {
			  id:"codA",
			  validations:
			  {
				 required:[true,"El campo Codigo no puede estar vacio"],
			  }
		  },
				  
		  {
		     id:"codG",
			 validations:
			 {
				required:[true,"El campo Grupo no puede estar vacio"],
				number:[true,"El campo Grupo debe contener numeros."]
			 }
		  }
		 ],
				  				  
			beforeValidation:function()
			{
				var codigoAsignatura= $("#codA").val();
				var grupo=$("#codG").val();
				var opcion= 1;
				
		       $.ajax({
			
				type:'POST',
				url: 'consultas/Asignatura/consultarAsignatura.php',
				data:'codigo='+codigoAsignatura+'&grupo='+grupo+'&opcion='+opcion,
				success: function(datos)
				{
				
					if(datos!=0)
					{
						datosasignatura=datos.split('-');
						nomasignatura=datosasignatura[1];
						$("#nomA").val(nomasignatura);
						MostrarMatriculaAsignatura(codigoAsignatura,grupo,nomasignatura);
						
				   }
				   else
				   {
					 alertas("Por favor verifique  que la asignatura y el grupo existen","Consultar Matricula Asignatura","error"); 	
				   }
			   }
		    });
	       }
	     };
	   $.validation(options);   
	 }
	
	
	function MostrarMatriculaUsuario(usuario)
	{
		$.ajax({
			
		   type:'POST',
		   url:'consultas/Matricula/verificarExistMatriculaU.php',
		   data: 'usuario='+usuario,
		   success: function(datos){
			   
			 if (datos==1)
			 {  
			   traerdatosUsuario(usuario);
			 }
			 else
			 {
				 $("#tabladinamica").hide(); 
				alertas("El usuario no tiene matriculadas asignaturas en el piso","Consultar Matricula Usuario","error");
				 
			 }
		   }
		});
      }
   
   function MostrarMatriculaAsignatura(asignatura,grupo,nombre)
	{
		$.ajax({
			
		   type:'POST',
		   url:'consultas/Matricula/verificarEstMatriculadosA.php',
		   data: 'asignatura='+asignatura+'&grupo='+grupo,
		   success: function(datos){
			   
			 if (datos==1)
			 {  
				traerdatosAsignatura(asignatura,grupo,nombre)
				 
			 }
			 else
			 {  
			    $("#tabladinamica1").hide();   
				alertas(" La asignatura no tiene estudiantes matriculados","Consultar Matricula Asignatura","error") 
			 }
		   }
		});
      }
	  
	
	$("#limpiar").button().click(function () {
	
	   $("#codA").val("");
	   $("#codG").val("");	
	   $("#nomA").val("");
	   $("#tabladinamica1").empty();
		
	});
	
	
	$("#limpiarmatuser").button().click(function () {
	
	   $("#codusu").val("");
	   $("#nomusu").val("");	
	   $("#tabladinamica").empty();
		
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
		
	   exportar_excel('form_excel_matricula', 'estmatriculados');
	
	});
	
	$("#pdf").click(function(){
		
		 html= $('.estmatriculados').html();
		
		cadenahtml='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>Reporte Asistencia</title></head> <body style="margin-top:20px; margin-left: 20px; margin-right: 20px;"><center><table class="estmatriculados" id="estmatriculados" cellpadding="0" cellspacing="0" > '+html+ '</table></center></body> </html>'
		
		$("#html").text(cadenahtml);//al text area le asigno toda la variable html
		
										  
	   $("#frmpdf").submit();//envio el formulario
	
	
	});
	
	$("#print").click(function(){
		$("#tabladinamica1").printArea();
			
	});
	
});// cierra jquery


</script>


</head>

<body>

<p id="validateErrors"></p>
<div id="tabs" style="width:700px; height:auto;">
	<ul>
		<li><a href="#matusuario">Usuario</a></li>
		<li><a href="#matasignatura">Asignatura</a></li>
		
	</ul>
    
   <div id="matusuario"> 
     
        
       <div id="consasignatura" class="text ui-widget-content ui-corner-all" style="width:640px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
       
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MATRICULAS - CONSULTAR POR USUARIO</div>
          
        <table>
        <tr>
        <td><label>Codigo:</label>
        <td><input name="codusu" type="text" id="codusu" value=""  class="text ui-widget-content ui-corner-all height font12" title="Presione enter dentro del cajon de texto para realizar la consulta"  /></td>
       
        </tr>
       </table>
       
       <table>
        <tr>
        <td><label>Nombre:</label>
        <td><input name="nomusu" type="text" id="nomusu" class="text ui-widget-content ui-corner-all height font12"  size="40" value= "" /></td>
        <td><button type="button" id="limpiarmatuser" style="font-size:11px;"  title="Limpia la pantalla para una nueva consulta"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;" />Limpiar</button></td>
        </tr>
        </table>
       </div>  
        
        <div id="tabladinamica"></div>
 
      </div><!-- cierro div matusuario-->
      
      <div id="matasignatura">
      
    <div id="consasignatura" class="text ui-widget-content ui-corner-all" style="width:640px;  margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
    
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MATRICULAS - CONSULTAR POR ASIGNATURA</div>
            
        <table style="margin-left:10px;">
        <tr>
        <td><label style="padding-right:23px;">Codigo:</label>
        <td><input name="codA" type="text" id="codA" value="" size="20" class="text ui-widget-content ui-corner-all height font12" /></td>
        <td><label>Grupo:</label>
        <td><input name="codG" type="text" id="codG" value="" size="5" class="text ui-widget-content ui-corner-all height font12" title="Presione enter dentro del cajon de texto para realizar la consulta"/></td>
        <tr>
        </table>
        
        <table style="margin-left:10px;">
        <tr>
          <td><label>Asignatura:</label>
          <td><input name="nomA" type="text" id="nomA" class="text ui-widget-content ui-corner-all height font12" value="" size="50" /></td>
          <td><button type="button" id="limpiar"  title="Limpia la pantalla para una nueva consulta" style="font-size:11px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/>Limpiar</button></td>
        </tr>
        </table>
       </div>
         
        <div id="tabladinamica1" style="overflow:auto; width:630px; max-height:300px; min-height:0px; margin-top:auto;
margin-bottom:15px;"> </div> 
        
        <!--  Aqui van las opciones para exportar a pdf, excel e imprimir-->
        <p><a href="#" id="exportar"  title="Exportar a Excel" style="padding-top:5px;"><img src="images/exportaraexcel.png" /></a><a href="#"  title="Exportar a Pdf" id="pdf"> <img src="images/Exportarapdf.png" /></a> <a href="#"  title="Imprimir" id="print"> <img src="images/document-print.png" /></a> </p>
        
        </div>
      </div> <!-- cierro div matasignatura-->
      
     </div> <!-- cierro div tabs-->  
     
     <form action="forms/Reserva/ficheroexcelmatricula.php" id="form_excel_matricula"  method="post" target="_blank">
          <!-- Inicia el proceso de exportar -->
        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>  
    </form>
 
 
   <form action="forms/Reserva/formpdfmatricula.php" method="post" id="frmpdf">
      <textarea id="html" name="html"></textarea>
   </form> 
      
       <div id="alertas">  
</body>
</html>