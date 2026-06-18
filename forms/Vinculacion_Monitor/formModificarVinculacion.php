<?php require_once('../../Connections/conexion.php'); 
include('../Asignatura/show_hours.php');
?>

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
<title>Cupi- Control de Utilizacion del Piso Informatico</title>

<script type="text/javascript">

$(function(){
	
var x=0;
var arraydelete=new Array();
var cadenaturnos=new Array();

 
	// escondo el formulario que me permite modificar el horario
	$("#formmodvinculacion").hide();
	$('#formupdateturno').hide();
	$("#turno").hide();
	$("#turno_monitor").hide();
	$("#recursosR").hide();
	$("#editar").hide();
	$("#addSchedule").hide();
	$("#eliminarHorario").hide();
	$("#editarrecurso").hide();
	$("#addrecurso").hide();
	$("#eliminarrecurso").hide();	
	$("#formaddturno").hide();
	$("#formaddrecursos").hide();
	$("#formupdaterecurso").hide();
	$("#formaddresthoras").hide();
	
	
	$("#deleteturno").dialog({
		autoOpen: false,
		show: "explode",
		hide: "explode",
		title:"Eliminar turno monitor",
		modal:true,
			
		 buttons: {
			"Aceptar": function() {
					
			  eliminarturnomonitor();
			  $( this ).dialog( "close" );
		  },
			  Cancelar: function() {
			  $( this ).dialog( "close" );
		  }
	    }		
	});
	
		
		$("#cedula").focus();
		 
	   // Muestra un calendario para escoger la fecha
	  $.datepicker.setDefaults($.datepicker.regional['es']);
    
       $("#comienzo" ).datepicker({ 
             dateFormat:'dd-mm-yy',
             defaultDate: +7,
			 changeMonth: true,
			 changeYear: true,
	  });
	 
	 $("#final" ).datepicker({ 
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
		
		function iddia(diasemana)
	{
		switch (diasemana) 
		{
             case 'Lunes':
                 id=1;
				 return id;
             break;
             case 'Martes':
                 id=2;
				 return id;
              break;
              case 'Miercoles':
                 id=3;
				 return id;
              break;
			  case 'Jueves':
                 id=4;
				 return id;
              break;
		      case 'Viernes':
                  id=5;
				  return id;
              break;
			  case 'Sabado':
                 id=6;
				 return id;
              break;            
        }	
	}
	
	
 $('#añadir').click(function(){   

   $("#formaddturno").css({width:"450px", height:"auto"});

$("#turnos_monitor").append('<tbody><td><input name="horario" type="checkbox" class="schedule"  value="i" /></td><td><select id="dia" size="1" class="turno"><option value="1">Lunes</option><option value="2">Martes</option><option value="3">Miercoles</option><option value="4">Jueves</option><option value="5">Viernes</option><option value="6">Sabado</option></select></td> <td><select name= "horainicial" id="horainicial" class="turno" style="margin-left:6px;"><option value="06:30:00">06:30</option><option value="07:00:00">07:00</option><option value="07:30:00">07:30</option><option value="08:00:00">08:00</option><option value="08:30:00">08:30</option><option value="09:00:00">09:00</option><option value="09:30:00">09:30</option><option value="10:00:00">10:00</option><option value="10:30:00">10:30</option><option value="11:00:00">11:00</option><option value="11:30:00">11:30</option><option value="12:00:00">12:00</option><option value="12:30:00">12:30</option><option value="13:00:00">13:00</option><option value="13:30:00">13:30</option><option value="14:00:00">14:00</option><option value="14:30:00">14:30</option><option value="15:00:00">15:00</option><option value="15:30:00">15:30</option><option value="16:00:00">16:00</option><option value="16:30:00">16:30</option><option value="17:00:00">17:00</option><option value="17:30:00">17:30</option><option value="18:00:00">18:00</option><option value="18:30:00">18:30</option><option value="19:00:00">19:00</option><option value="19:30:00">19:30</option><option value="20:00:00">20:00</option><option value="20:30:00">20:30</option><option value="21:00:00">21:00</option><option value="21:30:00">21:30</option><option value="22:00:00">22:00</option><option value="22:30:00">22:30</option></select></td><td><select name= "horafinal" id="horafinal" class="turno" style="margin-left:6px;"><option value="06:30:00">06:30</option><option value="07:00:00">07:00</option><option value="07:30:00">07:30</option><option value="08:00:00">08:00</option><option value="08:30:00">08:30</option><option value="09:00:00">09:00</option><option value="09:30:00">09:30</option><option value="10:00:00">10:00</option><option value="10:30:00">10:30</option><option value="11:00:00">11:00</option><option value="11:30:00">11:30</option><option value="12:00:00">12:00</option><option value="12:30:00">12:30</option><option value="13:00:00">13:00</option><option value="13:30:00">13:30</option><option value="14:00:00">14:00</option><option value="14:30:00">14:30</option><option value="15:00:00">15:00</option><option value="15:30:00">15:30</option><option value="16:00:00">16:00</option><option value="16:30:00">16:30</option><option value="17:00:00">17:00</option><option value="17:30:00">17:30</option><option value="18:00:00">18:00</option><option value="18:30:00">18:30</option><option value="19:00:00">19:00</option><option value="19:30:00">19:30</option><option value="20:00:00">20:00</option><option value="20:30:00">20:30</option><option value="21:00:00">21:00</option><option value="21:30:00">21:30</option><option value="22:00:00">22:00</option><option value="22:30:00">22:30</option></select></td><td><input type="text"  size="25" class="actividad turno text ui-widget-content ui-corner-all" id="actividad" title="De click dentro del cajon de texto para mostrar la fecha"/></td></tbody>');

});

	
	 $("#eliminarTurno").button().click(function(){
			
		  if($(".turn").is(":checked"))
		   {	
			 $("#deleteturno").dialog("open");
			 
		  }
		  else
		  {
			alertas("Por favor selecccione al menos un turno para eliminar","Modificar turnos monitor","error");
		  }
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
			 
			 
	   $("#cedula").keydown(function(event) {
	  
	       if (event.keyCode == '13') 
		   {
	         event.preventDefault();
			 var cedula=$("#cedula").val();
			 consultarmonitor(cedula);
	        
          } 
        });	
		
		$("#enviar").button().click(function(){
		
		    var cedula=$("#cedula").val();
			consultarmonitor(cedula);	
			
	    });
		
	// Funcion que realiza la busqueda de un monitor
     function consultarmonitor(cedula){

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
								   var nombres= datos.nombres+" "+datos.apellidos; 
								   $("#nombre").val(nombres); 
								   consultardatosvinculacion(cedula); 			
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
	  
	  
	  function consultardatosvinculacion(cedula)
		{	
		
		  var options = {
				 
		   classerror:"ui-state-error",
		   classdone:"ui-state-highlight",
		   contentmsg:"validateErrors",
		   fields:[
		   {
			  id:"cedula",
			  validations:
			  {
			    required:[true,"El campo cedula no puede estar vacio."],					  
			  }
		    }
								
		  ],
				  				  
		   beforeValidation:function()
		  {
					  
			   $.ajax({
					   
				 type: 'POST',
				 dataType:'html',
				 url: 'consultas/Monitores/obtenerVinculacion.php',
				 data: 'cedula='+cedula,
						 
				 success: function(datos)
				 {
					 $("#vinculacion").html(datos);
						
				 }
			    });
			   }
			  }; 
		    $.validation(options);  
    }
	
	function consultarTurnos(Novinculacion)
           {
			   
			   var opcion=2;
			   
			  $.ajax({
							   
					type: 'POST',
					url: 'consultas/Monitores/consultarturnos.php',
					data: 'idVinculacion='+Novinculacion+'&opcion='+opcion,
								 
				    success: function(datos)
				    {
					  $("#turno").show();
					  $("#turno_monitor").show();				 
					  $("#turno_monitor").html(datos);	
					  
				     // Muestro los botones de editar,adicionar horario, eliminar horario
					 $("#editar").show();
					 $("#addSchedule").show();
					 $("#eliminarHorario").show();	
					 		 
				   }
		    });
         }
	
	$(".checkboxvinculacion").live("click",function(){
	  
	   
	      if($(this).is(":checked"))
           {	
	         var contador=0; 
			 
			$("#vinculacion input:checked").each( 
				function(i) { 
				  contador+=1;
				 
			});
			
				if(contador==1)
				{  
				   //consultardatosreserva(valor);
				   
				   valor=$("#vinculacion").find("input:checked").parents("tr");
					
					// Obtengo los valores de la tabla
					Novinculacion=valor.find("td").eq(0).text();
				    comienzo= valor.find("td").eq(1).text();
				    finalizacion = valor.find("td").eq(2).text();
				    totalhoras_semestre= valor.find("td").eq(3).text();
					valortotal_vinculacion = valor.find("td").eq(4).text();
					valorhora_monitor = valortotal_vinculacion / totalhoras_semestre 
				    llenarformulariovinculacion(comienzo,finalizacion,totalhoras_semestre,valortotal_vinculacion,valorhora_monitor)
					//consultarEmailReserva(Noreserva);
				    consultarTurnos(Novinculacion);
				    //consultarRecursos(Noreserva,2);
				}
				else if(contador > 1)
				{
				   alertas("Por favor seleccione una sola vinculacion","Modificar Vinculacion","warning")
				}
				
		   }
	  
	  });
	  
	  
	  function llenarformulariovinculacion(comienzo,finalizacion,totalhoras_semestre,valortotal_vinculacion,valorhora_monitor)
	     {
			
			// Asigno a cada input el valor correspondiente de la consulta 	 
			$("#comienzo").val(comienzo);
			$("#final").val(finalizacion);
			$("#totalhoras").val(totalhoras_semestre);
			$("#horamonitor").val(valorhora_monitor);
			$("#totalvinculacion").val(valortotal_vinculacion);
			$("#formmodvinculacion").show();
							 					
		 }
		 
		
		 $('#ModificarVinculacion').button().click(function(){
			 
		  var vinculacion="";
		  
		  $("#vinculacion input:checked").each( 
				function(i) { 
				 vinculacion=$(this).val(); 	 
		  });
			
		  ModificarVinculacion(vinculacion);
			
		});
		
		function ModificarVinculacion(idvinculacion)
		{
			
			
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
				
				  // capturo los datos del formulario
					
					var comienzo=$("#comienzo").val();
					var finalizacion=$("#final").val();
					var totalhoras=$("#totalhoras").val();
					var horamonitor=$("#horamonitor").val();
					var totalvinculacion=$("#totalvinculacion").val();
				
				
				   $.ajax({
			  
					 type: 'POST',
					 url: 'funciones/Monitores/updateVinculacion.php',
					 dataType:'json',
					 data:'vinculacion='+idvinculacion+'&comienzo='+comienzo+'&finalizacion='+finalizacion+'&totalhoras='+totalhoras+'&horamonitor='+horamonitor+                     '&totalvinculacion='+totalvinculacion,
					 
					 success: function(datos)
					 {
						if(datos.error==1)
						{
						   alertas("La vinculacion fue modificada exitosamente","Modificar Vinculacion","done");
						   
						}
						else if(datos.error==0)
						{
							alertas("La vinculacion no fue actualizada","Modificar Vinculacion","error");
						}
				   }
				});
			}
		  };
	     $.validation(options);   		
	  }
	  
	  // muestra o esconde el formulario para adicionar o restar horas a la vinculacion
		$("#addresthoras").button().click(function() {
			
          $("#formaddresthoras").show("slide");
        
        });	
		
		$("#addhoras").button().click(function() {
		  var horassemestre= parseInt($("#totalhoras").val());
		  var horasadicionadas= parseInt($("#inputaddresthoras").val());
		  var nuevahorasemestre= parseInt(horassemestre+horasadicionadas);
		  var totalvinculacion= nuevahorasemestre * $("#horamonitor").val();	
          $("#totalhoras").val(nuevahorasemestre);
		  $("#totalvinculacion").val(totalvinculacion);
        
        });	
		
		$("#resthoras").button().click(function() {
			
          var horassemestre= parseInt($("#totalhoras").val());
		  var horasrestadas= parseInt($("#inputaddresthoras").val());
		  var nuevahorasemestre= parseInt(horassemestre-horasrestadas);
		  var totalvinculacion= nuevahorasemestre * $("#horamonitor").val();	
          $("#totalhoras").val(nuevahorasemestre);
		  $("#totalvinculacion").val(totalvinculacion);
        
        });	
		
	   $("#deleteVinculacion").button().click(function () {
		   
		   var vinculacion="";
		   
		  $("#vinculacion input:checked").each( 
			  function(i) { 
			   vinculacion=$(this).val();
			    	 
		  });
		  
		 
		  	    
		  $.ajax({
			  
					 type: 'POST',
					 url: 'funciones/Monitores/updateVinculacion.php',
					 dataType:'json',
					 data:'vinculacion='+vinculacion,
					 
					 success: function(datos)
					 {
						if(datos.error==1)
						{
						   alertas("La vinculacion fue cancelada exitosamente","Modificar Vinculacion","done");
						   
						  
						}
						else if(datos.error==0)
						{
							alertas("La vinculacion no fue actualizada, intente mas tarde","Modificar Vinculacion","error");
						}
					 }
				}); 
		   
		   
	  });
	  
	  
		// muestra o esconde el formulario para editar los turnos dek monitor
		$("#editar").button().click(function() {
			
		
		   if($(".turn").is(":checked"))
           {	
	         var contador=0; 
		  
			$("input:checked.turn").each( 
				function(i) { 
				  contador+=1;
			});
		
				if(contador==1)
				{   
				    // Me ubico en la fila la cual he seleccionado
					valor=$("#scheduleres").find("input:checked").parents("tr");
					
					// Obtengo los valores de la tabla
				    var dia= valor.find("td").eq(0).text();
				    var horainicio= valor.find("td").eq(1).text();
				    var horafinal= valor.find("td").eq(2).text();
				    var actividad = valor.find("td").eq(4).text();
					
					
					//Asigno a los input del formulario de modificar turno los valores obtenidos arriba
				
					var index =iddia(dia)-1;
					//var indexsala=salareserva-1;
                    $('#dia').get(0).selectedIndex = index;
			     	$("#horainicio").val(horainicio);
					$("#horafinal").val(horafinal);
					$("#actividad").val(actividad);
					
					//Muestro el formulario de modificación
					$('#formupdateturno').show("slide");	
				}
				else
				{
				   alertas("Por favor seleccione una sola opcion para modificar","Modificar horario reserva","warning")	
				}
		   }
		   else
		   {
			  alertas("Por favor seleccione una opcion para modificar","Modificar horario reserva","warning")	  
		   }
			
		});	
		
	
	  
	  $("#limpiarform").button().click(function() {
		 
		 $("#cedula").val("");
		 $("#nombre").val("");
		 $("#vinculacion").empty();
		 $("#cedula").focus();
		  
	  });
	  
	  $("#enviar").button().click(function() {
		 
		 var cedula=$("#cedula").val();
	     consultarmonitor(cedula);
		  
	  });
	  
	  
	 $("#actualizarTurno").button().click(function() {
	
			var options = {
				
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"actividad",
					  validations:{
						 required:[true,"El campo actividad no puede estar vacio."],
						 
				      }
				  }
				  
				],
				  				  
			beforeValidation:function(){
		     
			 // Se recorre los datos de la vinculacion para obtener la vinculacion		
		     $("#vinculacion input:checked").each( 
			  function(i) { 
			   vinculacion=$(this).val(); 	 
		     }); 
			 		
				
			 if($(".turn").is(":checked"))
             {	  	
	             valor="";	
				 var contador=0;
				 
				 $("input:checked.turn").each( 
		            function() 
					{ 
		               valor=$(this).val();
					   contador++;
				
		          });
				  
				 if(contador == 1) 
				 {
				
				  dia=$("#dia").val();
				  horaI=$("#horainicio").val();
				  horaF=$("#horafinal").val();
				  actividad=$("#actividad").val();
				  llaveturno=valor;
			      
				 $.ajax({
			  
					 type: 'POST',
					 url: 'funciones/Monitores/updateturno.php',
					 dataType:'json',
					 data:'dia='+dia+'&horainicio='+horaI+'&horafinal='+horaF+'&idturno='+llaveturno+'&actividad='+actividad,
					 
					 success: function(datos)
					 {
					   if(datos.error==1)
					   {  
						  consultarTurnos(vinculacion);
						  $("#formupdateturno").hide();
						  alertas("El turno ha sido modificado exitosamente ","Modificar turno monitor","done");     
					   }
					  else if(datos.error==0)
					  {
						  alertas("El turno no fue actualizado ","Modificar turno monitor","inform");       
					  }
					}
				});
			  }
			  else{
				 alertas("Por favor seleccione un solo turno ","Modificar turno monitor","warning");   
			  }
				
		   }// cierro if
		   else{
			  alertas("Por favor seleccione un turno para modificar ","Modificar turno monitor","warning"); 
		   }
		  }// cierro before validation
		 };
	    $.validation(options);		
       });
	 
	 
	   
	 // Funcion que elimina un turno de un monitor  
	 function eliminarturnomonitor()
	 {	
	   	arraydeleteturno=[];
		  	
	        $("input:checked.turn").each( 
			function(i) { 
		       valor=$(this).val();
			   arraydeleteturno[i]=valor;
		    });
			
		 // Se recorre los datos de la vinculacion para obtener la vinculacion		
		    $("#vinculacion input:checked").each( 
			  function(i) { 
			   vinculacion=$(this).val(); 	 
		   }); 	
			
	
		 $.ajax({
					
		  type: 'POST',
		  dataType:"json",
		  url: 'funciones/Monitores/deleteTurno.php',
		  data: 'idturno='+arraydeleteturno,
		  success: function(datos)
		  {
			 if(datos.error==1)
			 {
				alertas("El(Los) turno(s) ha(n) sido eliminados(s) con exito","Modificar turnos monitor","done");
	            consultarTurnos(vinculacion);
			 }
			 else if(datos.error==0)
			 {
				alertas("El(Los) turno(s) no ha(n) sido eliminados(s) intente mas tarde","Modificar turnos monitor","error"); 
			 }
			 
	      }
	    });
		
	 }
	 
	  // muestra o esconde el formulario para adicionar un nnuevo horario
		$("#addSchedule").button().click(function() {
			
          $("#formaddturno").show("slide");
        
       });

 
    $("#addturnomonitor").button().click(function () {
	  
	  var vincmonitor="";
	  
	    $("#vinculacion input:checked").each( 
		  function(i) { 
		  vincmonitor=$(this).val();
		  
	   });
	  
	 cadenaturnos=[];
						
	 $(':input.turno').each(function(i){
		valor=$(this).val();
		cadenaturnos[i]=valor;
	}); 
	  
	  var cedula= $("#cedula").val();	
	 
	 
	 $.ajax({
					 
		type: 'POST',
		url: 'funciones/Monitores/Insertturnomonitor.php',
		data: 'turnos='+ cadenaturnos+'&cedula='+cedula+'&vinculacion='+vincmonitor,
		success: function(datos)
		{
		  if (datos==1)
		  {
		    alertas("Los turnos se han ingresado correctamente","Adicionar turno monitor","done");
            consultarTurnos(vincmonitor);
			$("#formaddturno").hide();
		  }
		  else{
			alertas("No fue posible insertar el turno, intente mas tarde","Adicionar turno monitor","error");  
		  }
		  
		}
	 });// ajax  
  });	   
	   
 			 
							 
});// cierro jquery

</script>


</head>

<body>

<p id="validateErrors"></p>

        
     <div  class="text ui-widget-content ui-corner-all" style="width:560px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y;">
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">VINCULACION DE MONITORES</div>
          
        <table style="margin-left:15px;">
       
        <tr>
          <td><label for="titulo">Cedula:</label></td>
          <td><input type="text"  id="cedula" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td> 
        </tr>
       
        <tr>
         <td><label for="titulo">Nombre:</label></td>
         <td><input type="text"  id="nombre" size="50" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
        
        <tr>
         <td><button type="button" id="enviar" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/> Aceptar</button></td>
         <td><button type="button" id="limpiarform" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/> Limpiar</button></td>
        </tr>
         
         </table> 
      </div>
    
      
      <div id="vinculacion"></div>
      
      <div id="formmodvinculacion" class="text ui-widget-content ui-corner-all" style="width:600px; height:auto; font-size:12px; background-color:#F8F8F8;             background-repeat:repeat-y; margin-top:10px;"><div style="float:right" id="closeeditR" title="Cerrar ventana"><img src="images/close1.png"/></div>
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MODIFICAR VINCULACION</div>
          
    <table style="margin-left:15px;">
       
     <tr> 
      <td><label for="comienzo">Comienzo</label></td>
      <td><label for="final">Finalizacion</label></td>
      <td><label for="totalhoras">Total Horas Semestre</td> 
      <td><label for="horamonitor">Valor Hora Monitor</label></td>
    </tr> 
    
    <tr> 
      <td><input type="text" id="comienzo" class="text ui-widget-content ui-corner-all height font12"/> </td>
      <td><input type="text" id="final" class="text ui-widget-content ui-corner-all height font12"/></td>
      <td><input type="text" id="totalhoras" class="text ui-widget-content ui-corner-all height font12"/></td>
       <td><input type="text" id="horamonitor" class="text ui-widget-content ui-corner-all height font12"/> </td>
    </tr> 
    </table>
    
    <table style="margin-left:15px;">
     <tr> 
      <td><label for="totalvinculacion">Valor Total de la Vinculacion:</label></td>
      <td><input type="text" id="totalvinculacion" class="text ui-widget-content ui-corner-all height font12"/></td>
    </tr>    
   </table>
        
     
     <table style="margin-left:15px;">  
     <tr>
        <td><button type="button" value="Aceptar" id="ModificarVinculacion" style="font-size:11px; margin-top:10px; margin-bottom:10px;" ><img src="images/edit.png"  style="vertical-align:middle; padding-right:3px;"/>Modificar Vinculacion</button> </td>
        <td><button type="button" value="Aceptar" id="addresthoras" style="font-size:11px; margin-top:10px; margin-bottom:10px;" ><img src="images/add2.png" style="vertical-align:middle; padding-right:2px;"/><img src="images/minus1.png" style="vertical-align:middle; padding-right:4px;"/>Adicionar/Restar horas</button> </td>
         <td><button type="button" value="Aceptar" id="deleteVinculacion" style="font-size:11px; margin-top:10px; margin-bottom:10px;" ><img src="images/delete.png"  style="vertical-align:middle; padding-right:3px;"/>Cancelar Vinculacion</button> </td>
        </tr>
     </table> 
      </div>
      
       <!-- adiciona o resta las horas de la vinculacion -->
      
      <div id="formaddresthoras" class="text ui-widget-content ui-corner-all" style="width:530px; margin-bottom:10px; margin-top:10px; height:auto;" background-color:#F8F8F8; background-repeat:repeat-y;><div style="float:right" id="closeupdhor" title="Cerrar ventana"><img src="images/close1.png"/></div>
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">ADICIONAR - RESTAR HORAS</div>
         
        <table style="margin-left:15px;">
          <tr>
        	<td><label>Adcionar/Restar</label></td>
            <td><input type="text" id="inputaddresthoras" size="10" class="text ui-widget-content ui-corner-all height font12"  /></td>
           </tr>
         </table>   
            
           
         <table style="margin-left:15px;">
           <tr>
             <td><button id="addhoras" style="font-size:11px; margin-bottom:10px;"><img src="images/add2.png" style="vertical-align:middle; padding-right:4px;"/>Adicionar Horas</              button></td>
             <td><button id="resthoras" style="font-size:11px; margin-bottom:10px;"><img src="images/minus1.png" style="vertical-align:middle; padding-right:4px;"/>Restar Horas</button></td>
            </tr>
         </table>
            
      </div>
     
   
       <!-- div donde se muestra los turnos de un monitor -->
       <div id="turno" class="text ui-widget-content ui-corner-all" style="width:600px; height:auto; margin-bottom:10px; margin-top:10px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y;"><div style="float:right" id="closeeditH" title="Cerrar ventana"><img src="images/close1.png"/></div>
         <div class="ui-state-default" style="text-align:center;">MODIFICAR TURNOS MONITOR</div>
           <div id="turno_monitor" style="overflow:auto; width:580px; height:auto; margin-top:auto; margin-left:10px;"></div>
           
           <table style="margin-left:10px;">
         <tr>
         <td><button type="button" id="editar" title="Editar un turno de un monitor"  style="font-size:11px; margin-top:10px; margin-bottom:10px;"> <img  src="images/edit1.png"  style="vertical-align:middle; padding-right:3px;"/>Editar Turno</button></td>
        <td><button type="button" id="addSchedule" title="Adiciona un turno a un monitor"  style="font-size:11px; margin-top:10px; margin-bottom:10px;"> <img src="images/add2.png"  style="vertical-align:middle; padding-right:3px;"/>Adicionar Turno</button></td>
        <td><button type="button" id="eliminarTurno" title="Elimina un turno de un monitor"  style="font-size:11px; margin-top:10px; margin-bottom:10px;"> <img src="images/delete.png"  style="vertical-align:middle; padding-right:3px;"/>Cancelar Turno</button></td>
          </tr>
       </table>
           
       </div>
       
        
       
       <!-- div que contiene el formulario para modificar los turnos de un monitor-->
       <div id="formupdateturno" class="text ui-widget-content ui-corner-all" style="width:530px;  margin-bottom:15px; height:auto;" background-color:#F8F8F8; background-repeat:repeat-y;><div style="float:right" id="closeupdhor" title="Cerrar ventana"><img src="images/close1.png"/></div>
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MODIFICAR HORARIO</div>
         
        <table style="margin-left:15px;">
        <tr>
        	<td><label>Dia</label></td>
            <td><select size="1" id="dia">
              <option value="1" >Lunes</option><option value="2" >Martes</option><option value="3" >Miercoles</option><option value="4" >Jueves</option>
              <option value="5" >Viernes</option><option value="6" >Sabado</option></select>
            </td>
            
            <td><label>Hora Entrada:</label></td>
            <td><select id="horainicio" size="1" > <?php echo getSelectTimer(); ?>  </select></td>
     
     <td><label>Hora Salida:</label></td>
     <td><select id="horafinal" size="1" ><?php echo getSelectTimer(); ?></select></td>
           
            </tr>
            </table>
            
            <table style="margin-left:15px;">
            <tr>
            <td><label>Actividad:</label></td>
            <td><input type="text" id="actividad" class="text ui-widget-content ui-corner-all"/> </td>
            <td><button id="actualizarTurno" style="font-size:11px; margin-bottom:10px;"><img src= "images/schedule.png" style="vertical-align:middle;"/>Actualizar Turnno</button></td>
            </tr>
           </table>
           
           
            
      </div>
      
       
    <!--Formulario para adicionar mas horarios a la asignatura -->
    <div id="formaddturno" class="text ui-widget-content ui-corner-all" style="width:400px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y;"><div style="float:right" id="closeaddhor" title="Cerrar ventana"><img src="images/close1.png"/></div>
     <div class="ui-state-default" style="text-align:center; margin-bottom:15px;"> ADICIONAR TURNO MONITOR</div>
     
     <p><img src="images/add1.png" id="añadir" title="Añade un turno a un monitor" style="padding-right:2px;"/> <img src="images/delete.png" id="eliminar" title="Elimina un turno a un monitor" style="padding-right:3px;"/></p>
     
    
    <table id="turnos_monitor" style="margin-left:15px;">
    <thead>
         <th></th>    
    	<th>Dia</th>
        <th>Hora Entrada</th>
        <th>Hora Salida</th>
        <th>Actividad</th>
    </thead>   
  </table>
  
  <button type="button" id="addturnomonitor" style="font-size:11px; margin-top:10px; margin-left:15px; margin-bottom:10px; "><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Adicionar </button>
  
  </div>
        
   <div id="alertas"></div>
   
   <div id="deleteturno"><p style="font-size:11px;"><img src="images/dialog-warning.png" style="float:left; padding:5px;"/>¿ESTA SEGURO QUE QUIERE ELIMIMAR EL (LOS) TURNO(S) DEL  MONITOR?</p></div> 
   
  
</body>
</html>

