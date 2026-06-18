
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cupi-Control Utilizacion Piso Informatico</title>
<script type="text/javascript">
$(function(){
 
 
     var horarios= new Array();
	 var idreservas=new Array();
	 
     // datepicker
	$.datepicker.setDefaults($.datepicker.regional['es']);
    
      $("#comienzo" ).datepicker({ 
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

 $("#cancelarasignatura").hide();


  function TraerProgAsignaturas(codigo,grupo,fechainicial,fechafinal,opcion)
  {
	   
		$.ajax({
						
		  type: 'POST',
		  url: 'consultas/Asignatura/consultarHorariosCancelarR.php',
		  data: 'codigo='+codigo+'&grupo='+grupo+'&fechainicial='+fechainicial+'&fechafinal='+fechafinal+'&opcion='+          opcion,
		  success: function(datos)
		  {
			 $("#Mostrarhorarios").html(datos);
		  }
		}); 
	
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
		
		
		function verificarFecha(comienzo,final)
		{
			
			$.ajax({
								
					type: 'POST',
					url: 'consultas/Asignatura/CompararFechas.php',
					data: 'fechainicial='+comienzo+'&fechafinal='+final,
					success: function(datos)
					{
							    		
				      if(datos==1)
					  {
						  alertas("La fecha inicio no puede ser mayor a la fecha final o la fecha final menor a la fecha inicio", "Cancelar Reserva Asignatura","error");
						  $("#comienzo").addClass("ui-state-error"); 
						  $("#final").addClass("ui-state-error"); 
						  
					 }
							 
					else if(datos==0)
					{
					   $("#comienzo").removeClass("ui-state-error"); 
					   $("#final").removeClass("ui-state-error"); 
					   buscarReservaAsignaturas(comienzo,final);
					       
					}
					
				   }// cierro el success
			    });// cierro el ajax
				
				
		 }
		 
		
		$("#BuscarFechaIniFin").click(function(){
		
		   var options = {
				  
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"comienzo",
					  validations:{
						 
						  required:[true,"El campo Comienzo no puede estar vacio."],
						   
						  }
				  }
				  ,
				  {
					  id:"final",
					       validations:{
					       required:[true,"El campo Finalizacion no puede estar vacio."],
						     
						   }				  
				  }
				  
				  ],
				  				  
			      beforeValidation:function()
				  {
					fechaComienzo= $("#comienzo").val();
					fechaFinalizacion=$("#final").val();  
	                verificarFecha(fechaComienzo,fechaFinalizacion)
					
				   }// cierro beforevalidation
				  };
				  $.validation(options);  
		         });// cierro evento click	
					
					
			    function buscarReservaAsignaturas(fechaComienzo,fechaFinalizacion)
			    { 
				
					 $.ajax({
								
							type: 'POST',
							url: 'consultas/Asignatura/consultarHorariosCancelarR.php',
							data: 'fechainicial='+fechaComienzo+'&fechafinal='+fechaFinalizacion+'&opcion='+2,
							success: function(datos)
							{
								$("#Mostrarhorarios").html(datos);   
											
							}// cierro success
					    });	// cierro ajax
			  }
			
			
			$("#BuscarCodGrupo").click(function(){
			
			  var options = {
				  
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codAsig",
					  validations:{
						 
						  required:[true,"El campo Codigo no puede estar vacio."],
						   
						  }
				  }
				  ,
				  {
					  id:"grupo",
					       validations:{
					       required:[true,"El campo Grupo no puede estar vacio."],
						    number:[true,"El campo Grupo debe contener numeros."]  
						   }				  
				  }
				  
				  ],
				  				  
			      beforeValidation:function()
				  {
			
	                codigo= $("#codAsig").val();
				    grupo=$("#grupo").val();
				 
				    $.ajax({
					
					 type: 'POST',
					 url: 'consultas/Asignatura/consultarHorariosCancelarR.php',
					 data: 'codigo='+codigo+'&grupo='+grupo+'&opcion='+1,
					 success: function(datos)
					 {
						$("#Mostrarhorarios").html(datos);   
								
		            }// cierro success
				});	// cierro ajax
				}// cierro beforevalidation
			  };
		    $.validation(options);  
		  });// cierro evento click
			
			
	   $("#cancelarProgAsignaturaGrupo" ).dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			title:"Cancelar Programacion Asignatura",
			modal:true,
			
			  buttons: {
				"Aceptar": function() {
					cancelarAsignatura(1);
					$( this ).dialog( "close" );
					
				},
				"Cancelar": function() {
					$( this ).dialog( "close" );
				}
			}		
		});
		
		
		$("#cancelarProgAsignaturas" ).dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			title:"Cancelar Programacion Asignatura",
			modal:true,
			
			  buttons: {
				"Aceptar": function() {
					cancelarAsignatura(2);
					$( this ).dialog( "close" );
					
				},
				"Cancelar": function() {
					$( this ).dialog( "close" );
				}
			}		
		});
			 
				 
		 $("#CancelarAsigGrupo").click(function(){
			 
			 var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codAsig",
					  validations:{
						 
						  required:[true,"El campo Codigo no puede estar vacio."],
						 
						  }
				  }
				  ,
				  {
					  id:"grupo",
					       validations:{
					         required:[true,"El campo grupo no puede estar vacio."],
						     number:[true,"El campo Grupo debe contener numeros."]
						   }				  
				  }
				  
				  ],
				  				  
			 beforeValidation:function(){
			 
			   $("#cancelarProgAsignaturaGrupo").dialog("open");
			 
			 }
	        };
		  $.validation(options);    
		 });
		 
		 
		 $("#CancelarProgAsig").click(function(){
			 
			var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"comienzo",
					  validations:{
						 
						  required:[true,"El campo Comienzo no puede estar vacio."],
						 
						  }
				  }
				  ,
				  {
					  id:"final",
					       validations:{
					         required:[true,"El campo Finalizacion no puede estar vacio."],
						    
						   }				  
				  }
				  
				  ],
				  				  
			  beforeValidation:function(){ 
			 
			    $("#cancelarProgAsignaturas").dialog("open");
			   
			   }
	        };
		  $.validation(options);    
			 
		 });
				 
				
				
	     function cancelarAsignatura(opcion)
		 {
		 
             codigo=$('#codAsig').val();
			 grupo=$('#grupo').val();
			 dateinicial=$('#comienzo').val();
			 datefinal=$('#final').val();
			 idreservas=[];
			 horarios=[];
			 
			 if($(".reserva").is(":checked"))
            {	
	           var contadorreserva=0; 
		  
			  $("input:checked.reserva").each( 
				function(i) { 
				  valor=$(this).val();
				   datos=valor.split("-");
				   horarios[i]=datos[0];
				   idreservas[i]=datos[1]
			  });
			  
		     $.ajax({
			  
					 type: 'POST',
					 url: 'funciones/Asignatura/Cancelarasignatura.php',
					 data: 'codigo='+codigo+'&grupo='+grupo+'&fechainicial='+dateinicial+'&fechafinal='+datefinal+ '&opcion='+opcion+'&horarios='+horarios+'&reservas='+idreservas,
					 
					 success: function(datos)
					  {
						   cadenaRespuesta=datos.split("-");
						   respuestaHorario= cadenaRespuesta[0];
						   filasafectadasHorario=cadenaRespuesta[1];
						   respuestaMatricula= cadenaRespuesta[2];
						   filasafectadasMatricula=cadenaRespuesta[3];
						   respuestaReserva= cadenaRespuesta[4];
						   filasafectadasReserva=cadenaRespuesta[5];
						   
						   if( respuestaReserva==1 && respuestaMatricula==1)
						   {
							   alertas("La(s) reserva(s) de la asignatura(s) ha(n) sido cancelada(s) exitosamente", "Cancelar Programacion Asignatura","done");
							   TraerProgAsignaturas(codigo,grupo,dateinicial,datefinal,opcion);
							   $("#NoResevasC").val(filasafectadasReserva);
							   $("#NoMatriculasI").val(filasafectadasMatricula);
							   
							   if(opcion==1)
							   {
								  $('#codAsig').val(""); 
								  $('#grupo').val("");
							   }
							   else if(opcion==2)
							   {
								  $('#comienzo').val("");
								  $('#final').val(""); 
							   }
							   	
						   }
						   else if(datos==0) 
						    {
							   alertas("La operacion no pudo ser realizada satisfatoriamente ","Cancelar reserva","error");
									
						    }
					      }// cierro success
		               });// cierro ajax
			          }
					  else{
						 alertas("por favor seleccione una reserva para cancelar ","Cancelar reserva","error")  
					  }
                    }// cierro la funcion
					
					// Evento que limpia el formulario
					$("#limpiarform").button().click(function(){
							
						  $("#codAsig").val("");
						  $("#grupo").val("");	
						  $("#comienzo").val("");	
						  $("#final").val("");	
						  $("#NoResevasC").val("");	
						  $("#NoMatriculasI").val("");					  
						  $("#Mostrarhorarios").empty();	
						  $("#codAsig").focus();
						  
						  
					});
	           });// cierro jquery

</script>

</head>

<body>

<p id="validateErrors"></p>
         
       <div id="modasignatura" class="text ui-widget-content ui-corner-all" style="width:540px;  height:auto; background-color:#F8F8F8; background-repeat:repeat-y;">
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CANCELAR RESERVA ASIGNATURAS</div>
        
        <table style="margin-left:15px;">
        <tr>
            <td ><label>Codigo:</label ></td>
            <td><input type="text" name="codAsig" id="codAsig" size="15" maxlength="128"  class="text ui-widget-content ui-corner-all height font12" value="" /></td>
            <td><label>Grupo:</label></td>
            <td><input type="text" id="grupo" size="3" class="text ui-widget-content ui-corner-all height font12" value="" /></td>
            <td><img src="images/buscar1.png" id="BuscarCodGrupo" title="Busca la programacion de la asignatura dado un codigo y un grupo en especifico"/></td>
            <td><img src="images/delete.png" id="CancelarAsigGrupo" title="Cancela la programacion de la asignatura dado un codigo y un grupo en especifico"/></td>
        </tr>
       </table>
        
       <table style="margin-left:15px;"> 
        <tr>
           <td><label for="comienzo">Comienzo:</label></td>
            <td><input type="text" id="comienzo"  size="20" class="text ui-widget-content ui-corner-all height font12" id="comienzo" value=""/></td>
            
        
        	<td><label for="periodo">finalizacion:</label></td>
            <td><input type="text" name="final" size="20" class="text ui-widget-content ui-corner-all height font12" id="final" value=""/></td>
            <td><img src="images/buscar1.png" id="BuscarFechaIniFin" title="Busca la programacion de las asignaturas que esten en el rango de fechas "/></td>
            <td><img src="images/delete.png" id="CancelarProgAsig" title="Cancela la programacion de las asignaturas que esten en el rango de fechas"/></td> 
        </tr>
        
        </table>
        
        <table style="margin-left:15px;">
        
          <tr> 
          <td><label>Total Reservas Canceladas:</label> </td>
          <td><input type="text" id="NoResevasC" size="5" class="text ui-widget-content ui-corner-all height font12"/> </td>
          <td><label>Total Matriculas Inactivadas:</label> </td>
          <td><input type="text" id="NoMatriculasI" size="5" class="text ui-widget-content ui-corner-all height font12"/> </td>
        </tr>
        
        </table>
        
        <table style="margin-left:15px; margin-bottom:15px;">
        <td><button type="button" id="limpiarform" style="font-size:11px; margin-top:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/>Limpiar</button></td>
         </table>
      
        </div>
        
        <div id="Mostrarhorarios" style="margin-top:10px;">
         
         </div>
         
         
         <div id="alertas"></div>
   <div id="cancelarProgAsignaturaGrupo"><p style="font-size:12px;"><img src="images/dialog-warning.png" style="float:left; padding:5px;"/>ESTA SEGURO QUE QUIERE CANCELAR LA PROGRAMACION DE LA ASIGNATURA ?</p></div>
  <div id="cancelarProgAsignaturas"><p style="font-size:12px;"><img src="images/dialog-warning.png" style="float:left; padding:5px;"/>ESTA SEGURO QUE QUIERE CANCELAR LA PROGRAMACION DE ESTAS ASIGNATURAS?</p></div> 
        
    

</body>
</html>
