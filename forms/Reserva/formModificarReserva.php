<?php require_once('../../Connections/conexion.php'); 
   include("show_hours.php");
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


mysql_select_db($database_conexion, $conexion);
$query_JRSalas = "SELECT numSala FROM sala where numSala NOT IN(0)";
$JRSalas = mysql_query($query_JRSalas, $conexion) or die(mysql_error());
$row_JRSalas = mysql_fetch_assoc($JRSalas);
$totalRows_JRSalas = mysql_num_rows($JRSalas);

mysql_select_db($database_conexion, $conexion);
$query_JRRecursos = "SELECT * FROM gruporecurso";
$JRRecursos = mysql_query($query_JRRecursos, $conexion) or die(mysql_error());
$row_JRRecursos = mysql_fetch_assoc($JRRecursos);
$totalRows_JRRecursos = mysql_num_rows($JRRecursos);

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
var arrayrecurso=new Array();

 
	// escondo el formulario que me permite modificar el horario
	$("#formmodreserva").hide();
	$('#formupdatehorario').hide();
	$("#Horario").hide();
	$("#recursosR").hide();
	$("#editar").hide();
	$("#addSchedule").hide();
	$("#eliminarHorario").hide();
	$("#editarrecurso").hide();
	$("#addrecurso").hide();
	$("#eliminarrecurso").hide();	
	$("#formaddhorario").hide();
	$("#formaddrecursos").hide();
	$("#formupdaterecurso").hide();
	
	
	
	
	$("#deleteschedule").dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			title:"Eliminar Horario Reserva",
			modal:true,
			
			buttons: {
				"Aceptar": function() {
					
					eliminarhorarioreserva();
					$( this ).dialog( "close" );
				},
				Cancelar: function() {
					$( this ).dialog( "close" );
				}
			}		
		});
		
		$("#deleterecurso").dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			title:"Eliminar Recurso Reserva",
			modal:true,
			
			buttons: {
				"Aceptar": function() {
					
					eliminarrecursoreserva();
					$( this ).dialog( "close" );
				},
				Cancelar: function() {
					$( this ).dialog( "close" );
				}
			}		
		});
		
		
		
	
					
	
	// Muestra un calendario para escoger la fecha
	$.datepicker.setDefaults($.datepicker.regional['es']);
    
      $("#nuevafechai" ).datepicker({ 
              dateFormat:'dd-mm-yy',
              defaultDate: +7,
			  changeMonth: true,
			  changeYear: true,
	 });
	 
	 $("#nuevafechat" ).datepicker({ 
              dateFormat:'dd-mm-yy',
              defaultDate: +7,
			  changeMonth: true,
			  changeYear: true,
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
		
		
		
	
		// muestra o esconde el formulario para editar la asignatura
		$("#editar").button().click(function() {
			
		   if($(".keyhorario").is(":checked"))
           {	
	         var contador=0; 
		  
			$("input:checked.keyhorario").each( 
				function(i) { 
				  contador+=1;
			});
		
				if(contador==1)
				{   
				    // Me ubico en la fila la cual he seleccionado
					valor=$("#scheduleres").find("input:checked").parents("tr");
					
					// Obtengo los valores de la tabla
				    diareserva= valor.find("td").eq(0).text();
				    horainicio= valor.find("td").eq(1).text();
				    horafinal= valor.find("td").eq(2).text();
				    fechainicio = valor.find("td").eq(3).text();
					fechaterm = valor.find("td").eq(4).text();
					salareserva = valor.find("td").eq(5).text();
					estado = valor.find("td").eq(6).text();
					
					//Asigno a los input del formulario de modificar horario los valores obtenidos arriba
				
					var index =iddia(diareserva)-1;
					var indexsala=salareserva-1;
                    $('#dia').get(0).selectedIndex = index;
			     	$("#horainicio").val(horainicio);
					$("#horafinal").val(horafinal);
					$("#nuevafechai").val(fechainicio);
					$("#nuevafechat").val(fechaterm);
					$("#salares").get(0).selectedIndex=indexsala;
					
					//Muestro el formulario de modificación
					$('#formupdatehorario').show("slide");	
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
		
		  
		 // muestra o esconde el formulario para adicionar un nnuevo horario
		$("#addSchedule").button().click(function() {
			
          $("#formaddhorario").show("slide");
        
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
			else if(type=="warning")
			{
				$("#alertas").html('<img src="images/dialog-warning.png" style="float:left; padding:5px;" />');
			}
			$("#alertas").append(content);
			$("#alertas").dialog("open");
		}
		
		
		$("#actualizarhorario").button().click(function() {
		
			var options = {
				  //defaultMsg:"Todos los campos son requeridos.",
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"nuevafechai",
					  validations:{
						 
						  required:[true,"El campo fecha de inicio no puede estar vacio."],
						 
						  }
				  }
				  ,
				  {
					  id:"nuevafechat",
					       validations:{
					         required:[true,"El campo fecha final no puede estar vacio."],
						    
						   }				  
				  }
				  
				  ],
				  				  
			beforeValidation:function(){
				
			 if($(".keyhorario").is(":checked"))
             {	  	
	             valor="";	
				
				 $("input:checked.keyhorario").each( 
		            function() 
					{ 
		               valor=$(this).val();
				
		          });
				
				  diaH=$("#dia").val();
				  salaH=$("#salares").val();
				  horaI=$("#horainicio").val();
				  horaF=$("#horafinal").val();
				  dateIni=$("#nuevafechai").val();
				  dateEnd=$("#nuevafechat").val();
				  llavehorario=valor;
				
				$.ajax({
				
					 type: 'POST',
					 url: 'consultas/Asignatura/ModificarEspacioSala.php',
					 data: 'dia='+diaH+'&sala='+salaH+'&horaI='+horaI+'&horaF='+horaF+'&horario='+llavehorario+'&fechainicial='+dateIni+'&fechafinal='+dateEnd,
					  
					 success: function(datos)
					 {
						 
				       crucehorario=datos.split('-');
				       respuesta=crucehorario[0];
				       mensaje= "Asignatura:"+" "+crucehorario[1]+" "+"Grupo:"+" "+crucehorario[2]+" "+"Dia:"+" "+crucehorario[3]+" "+"Hora Inicio:"+" "+                       crucehorario[4]+" "+"Hora Final:"+" "+ crucehorario[5]+" "+"Sala:"+" "+crucehorario[6]; 
				  
				  
				      if(respuesta==1)
				      {
					    alertas("Se presenta cruce de horario(s) con la(s) siguiente(s) asignatura(s):"+mensaje+"","Modificar horario reserva","warning"); 
				      }
						
					 else if(datos==2)
					  {
						  
						  alertas("La hora de inicio no puede ser mayor o igual a la hora final","Modificar horario reserva","error");
					  }
						
					  else 
					  {
						  verificarFechaHorario(dateIni,dateEnd,diaH,salaH,horaI,horaF,llavehorario);
							
					  }
				    }
		          });	
				
			  }
			  else
		     {
		       alertas("Por favor marque la opcion o verifique que la reserva tiene un horario para modificar", "Modificar Horario reserva","warning"); 	
		     }
		   }
		  };
	     $.validation(options);   			
		});
		
		
		// Modifica el horario de la reserva
	   function ModificarHorarioReserva(dia,sala,horainicial,horafinal,idHorario,fechainicial,fechafinal)
	   {
		   
		    $("#reservas input:checked").each( 
				function(i) { 
				  valor=$(this).val(); 
			});
		   
		   actualizarMatriculaReserva(sala,idHorario);
		   
	      $.ajax({
					
					 type: 'POST',
					 dataType:'json',
					 url: 'funciones/ReservaEventual/updatehorarioreserva.php',
					 data: 'dia='+dia+'&sala='+sala+'&horainicio='+horainicial+'&horafinal='+horafinal+'&idhorario='+idHorario+'&fechainicial='+fechainicial+'&fechafinal='+fechafinal,
					 success: function(datos){
					   
					   if(datos.error==1)
					   {  
					      
						  consultarHorarios(valor,2)
						  $("#formupdatehorario").hide();
						  alertas("El horario ha sido modificado exitosamente ","Modificar horario reserva","done");     
					   }
					   else if(datos.error==0)
					   {
						  alertas("El horario no fue actualizado ","Modificar horario reserva","inform");       
					   }
					  
					 }
	            });	
	         }
  
		
		        function verificarFechaHorario(fechainicial,fechafinal,diaH,salaH,horaI,horaF,llavehorario)
				{
					
					
				    $.ajax({
								
							type: 'POST',
							url: 'consultas/Asignatura/CompararFechas.php',
							data: 'fechainicial='+fechainicial+'&fechafinal='+fechafinal,
							success: function(datos)
							{
							    		
							  if(datos==1)
							  {
								 alertas("La fecha inicio no puede ser mayor a la fecha final o la fecha final menor a la fecha inicio", "Modificar Horario","error");
							     $("#nuevafechai").addClass("ui-state-error"); 
								 $("#nuevafechat").addClass("ui-state-error"); 
								   
								 
							  }
							 
							  else if(datos==0)
							  {
							      $("#nuevafechai").removeClass("ui-state-error"); 
								  $("#nuevafechat").removeClass("ui-state-error"); 
								  ModificarHorarioReserva(diaH,salaH,horaI,horaF,llavehorario,fechainicial,fechafinal);	         
							  }
							}// cierro el success
					   });// cierro el ajax
				}
		          
				
	
		   
		 function llenarformularioreserva(reserva,codigo,grupo,nombreasignatura,codresponsable,nombreresp,correo,internet)
	     {	
			
			// Limpio el formulario de modificación de reservas
			limpiarformmodreserva();
			
			// Asigno a cada input el valor correspondiente de la consulta 	 
			$("#codigo").val(codigo);
			$("#grupo").val(grupo);
			$("#nombre").val(nombreasignatura);
			$("#Selectinternet").val(internet);
			
			if(codresponsable=="" && nombreresp=="" && correo=="")
			{
				 $('#codresp').attr('disabled','disabled');
				 $('#nomresp').attr('disabled','disabled');
				 $('#email').attr('disabled','disabled');
			}
			else if(codresponsable!="" && nombreresp!="" && correo!="")
			{
				 $('#codresp').attr('disabled','');
				 $('#nomresp').attr('disabled','');
				 $('#email').attr('disabled','');
				 $("#codresp").val(codresponsable);
				 $("#nomresp").val(nombreresp);
				 $("#email").val(correo);
			}
			
			$("#formmodreserva").show();
							 					
		 }
		 
		 
		 function limpiarformmodreserva()
		 {
			 $("#codigo").val("");
			 $("#grupo").val("");
			 $("#nombre").val("");
			 $("#codresp").val("");
			 $("#nomresp").val("");
			 $("#email").val(""); 
		 }
		   
		   function consultarHorarios(Numreserva,opcion)
           {
			   
			  $.ajax({
							   
					type: 'POST',
					url: 'consultas/ReservaEventual/consultarHorarios.php',
					data: 'reserva='+Numreserva+'&opcion='+opcion,
								 
				    success: function(datos)
				    {
					  $("#Horario").show();				 
					  $("#Horarioreserva").html(datos);	
					  
				     // Muestro los botones de editar,adicionar horario, eliminar horario
					 $("#editar").show();
					 $("#addSchedule").show();
					 $("#eliminarHorario").show();	
					 		 
				   }
		    });
         }
		 
		  function consultarRecursos(Numreserva,opcion)
		  {
			  
			  $.ajax({
							   
					type: 'POST',
					url: 'consultas/ReservaEventual/consultarRecursos.php',
					data: 'reserva='+Numreserva+'&opcion='+opcion,
								 
				    success: function(datos)
				    {
					  $("#recursosR").show();				 
					  $("#recursoreserva").html(datos);	
					  
				     // Muestro los botones de editar,adicionar horario, eliminar horario
					 $("#editarrecurso").show();
					 $("#addrecurso").show();
					 $("#eliminarrecurso").show();	
					 		 
				   }
		    });  
		  }
	
		
		$('#ModificarReserva').button().click(function(){
		
		  $("#reservas input:checked").each( 
				function(i) { 
				  numreserva=$(this).val(); 	 
		  });
			
		  ModificarReserva(numreserva);
			
		});
		
		
		function ModificarReserva(idreserva)
		{
			
			
			var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  
				  {
					  id:"codasig",
					       validations:{
					         required:[true,"El campo Codigo Asignatura no puede estar vacio."],
						    
						   }				  
				  },
				  
				  {
					  id:"grupo",
					       validations:{
					         required:[true,"El campo Grupo no puede estar vacio."],
						     number:[true,"El campo Grupo debe contener numeros."], 
						   }				  
				  },
				  
				  
				  ],
				  				  
			beforeValidation:function()
			
			{
				
				  // capturo los datos del formulario
			
					mrcodigoasig=$("#codigo").val();
					mrgrupo=$("#grupo").val();
					mrnomasignatura=$("#nombre").val();
					mrcodigoresp=$("#codresp").val();
					mrnombreresp=$("#nomresp").val();
					mremail=$("#email").val();
					internet=$("#Selectinternet").val();
				
				
				   $.ajax({
			  
					 type: 'POST',
					 url: 'funciones/ReservaEventual/Modificarreserva.php',
					 dataType:'json',
					 data:'reserva='+idreserva+'&cod_asignatura='+mrcodigoasig+'&grupo='+mrgrupo+'&cod_responsable='+mrcodigoresp+'&email='+mremail+'&nombre_asignatura='+mrnomasignatura+'&nombre_responsable='+mrnombreresp+'&internet='+internet,
					 
					 success: function(datos)
					 {
						if(datos.error==1)
						{
						   alertas("La reserva fue modificada exitosamente","Modificar reserva eventual","done");
						   
						  
						}
						else if(datos.error==0)
						{
							alertas("La información no fue actualizada","Modificar reserva eventual","error");
						}
					 }
				});
			}
		  };
	     $.validation(options);   		
	  }
		
			  				
$('#añadir').click(function(){   

   $("#formaddhorario").css({width:"560px", height:"auto"});
   i++;

$("#horarioreserva").append('<tbody><td><input name="horario" type="checkbox" class="schedule"  value="i" /></td> <td><select id="dia" size="1" class="addhorario"><option value="1">Lunes</option><option value="2">Martes</option><option value="3">Miercoles</option><option value="4">Jueves</option><option value="5">Viernes</option><option value="6">Sabado</option></select></td> <td><select name= "horainicial" id="horainicial" class="addhorario" style="margin-left:6px;"><option value="07:00:00">07:00</option><option value="07:30:00">07:30</option><option value="08:00:00">08:00</option><option value="08:30:00">08:30</option><option value="09:00:00">09:00</option><option value="09:30:00">09:30</option><option value="10:00:00">10:00</option><option value="10:30:00">10:30</option><option value="11:00:00">11:00</option><option value="11:30:00">11:30</option><option value="12:00:00">12:00</option><option value="12:30:00">12:30</option><option value="13:00:00">13:00</option><option value="14:00:00">14:00</option><option value="14:30:00">14:30</option><option value="15:00:00">15:00</option><option value="15:30:00">15:30</option><option value="16:00:00">16:00</option><option value="16:30:00">16:30</option><option value="17:00:00">17:00</option><option value="17:30:00">17:30</option><option value="18:00:00">18:00</option><option value="18:30:00">18:30</option><option value="19:00:00">19:00</option><option value="19:30:00">19:30</option><option value="20:00:00">20:00</option><option value="20:30:00">20:30</option><option value="21:00:00">21:00</option><option value="21:30:00">21:30</option><option value="22:00:00">22:00</option></select></td><td><select name= "horafinal" id="horafinal" class="addhorario" style="margin-left:6px;"><option value="07:00:00">07:00</option><option value="07:30:00">07:30</option><option value="08:00:00">08:00</option><option value="08:30:00">08:30</option><option value="09:00:00">09:00</option><option value="09:30:00">09:30</option><option value="10:00:00">10:00</option><option value="10:30:00">10:30</option><option value="11:00:00">11:00</option><option value="11:30:00">11:30</option><option value="12:00:00">12:00</option><option value="12:30:00">12:30</option><option value="13:00:00">13:00</option><option value="14:00:00">14:00</option><option value="14:30:00">14:30</option><option value="15:00:00">15:00</option><option value="15:30:00">15:30</option><option value="16:00:00">16:00</option><option value="16:30:00">16:30</option><option value="17:00:00">17:00</option><option value="17:30:00">17:30</option><option value="18:00:00">18:00</option><option value="18:30:00">18:30</option><option value="19:00:00">19:00</option><option value="19:30:00">19:30</option><option value="20:00:00">20:00</option><option value="20:30:00">20:30</option><option value="21:00:00">21:00</option><option value="21:30:00">21:30</option><option value="22:00:00">22:00</option></select></td><td><input type="text"  size="15" class="comienzo addhorario text ui-widget-content ui-corner-all" id="comienzo'+i+'" title="De click dentro del cajon de texto para mostrar la fecha"/></td><td><input type="text" size="15" class="final addhorario text ui-widget-content ui-corner-all" id="final'+i+'" title="De click dentro del cajon de texto para mostrar la fecha"/></td><td><select id="sala" size="1" class="addhorario"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option></select></td></tbody>');


 
  $("#comienzo"+i).datepicker({ 
              dateFormat:'dd-mm-yy',
              defaultDate: +7,
			  changeMonth: true,
			  changeYear: true,
  });
	 
   $("#final"+i).datepicker({ 
              dateFormat:'dd-mm-yy',
              defaultDate: +7,
			  changeMonth: true,
			  changeYear: true,
  });
   

			 			  
});



 // Elimina una fila del horario de la asignatura 
  $('#eliminar').click(function(){
  
	$("#horarioreserva").find("input:checked").parents("tr").remove();

  });
  
  
 $("#addScheduleAsig").button().click(function(){
	 
	cadenahorario=[];
						
     $(':input.addhorario').each(function(i){
		valor=$(this).val();
		cadenahorario[i]=valor;
     });
	
	 $.ajax({
					 
		type: 'POST',
		url: 'funciones/Asignatura/addScheduleCruce.php',
		data: 'horario='+ cadenahorario,
		success: function(datos)
		{
		  
			 cruceHorarioAddSchedule=datos.split('-');
		     respuestaAdd=cruceHorarioAddSchedule[0];
		     mensajeAdd= "Asignatura:"+" "+cruceHorarioAddSchedule[1]+" "+"Grupo:"+" "+cruceHorarioAddSchedule[2]+" "+"Dia:"+" "+cruceHorarioAddSchedule[3]+"             "+ "Hora Inicio:"+" "+ cruceHorarioAddSchedule[4]+" "+"Hora Final:"+" "+ cruceHorarioAddSchedule[5]+" "+"Sala:"+" "+cruceHorarioAddSchedule[6]; 
				  
				  
				   if(respuestaAdd==1)
				   {
					   alertas("Se presenta cruce de horario(s) con la(s) siguiente(s) asignatura(s):"+mensajeAdd+"","Adicionar Horario reserva","warning"); 
				   }
				   
				   
				   else if(datos==2)
				  {
					 alertas("Por favor verifique que las fechas esten correctas","Adicionar Horario reserva","error");
				  }
				  
				  else if(datos==3)
				  {
					  alertas("Por favor verifique que las horas esten correctas","Adicionar Horario reserva","error");
				  }
				  
				  else if(datos==4)
				  {
					  alertas("Por favor verifique que las fechas y las horas estan correctas","Adicionar Horario reserva" , "error");
				  }
				  
				 else 
				 {
					InsertarHorariosAdicionales(cadenahorario);  
				 }	 
			 
			
			
		}
		
	 });
	 
 });
 
 
 function InsertarHorariosAdicionales(horario)
 {
	 
	 asignatura=$("#codasig").val();
	 grupo=$("#grupoasig").val();
	 
	 $("#reservas input:checked").each( 
		 function(i) { 
		  reservaaddhor=$(this).val(); 
	});
	 
	 
	 $.ajax({
					 
		type: 'POST',
		url: 'funciones/ReservaEventual/InsertScheduleReserva.php',
		data: 'horario='+ horario+'&asignatura='+asignatura+'&grupo='+grupo+'&Noreserva='+reservaaddhor,
		success: function(datos)
		{
		  if (datos==1)
		  {
		    alertas("Los horarios se han ingresado correctamente","Adicionar horario reserva","done");
           consultarHorarios(reservaaddhor,2);
		  }
		  
		}
	 });
	 
  }
  
  
   $("#internet").click(function(){
		   	  
	  if($(this).is(":checked"))
	  {
	     $(this).attr("value","Si");
			 
	  }
	  
	  else
	  {
		  $(this).attr("value","No");	 
	  }
			 
   });	
	 
	 
	$("#eliminarHorario").button().click(function(){
		
	  if($(".keyhorario").is(":checked"))
       {	
		 $("#deleteschedule").dialog("open");
		 
	  }
	  else
	  {
	    alertas("Por favor selecccione al menos un horario para eliminar","Modificar horario reserva","error");
      }
	 });
	 
	 	
	 function eliminarhorarioreserva()
	 {	
	   	arraydelete=[];
		  	
	        $("input:checked.keyhorario").each( 
			function(i) { 
		       valor=$(this).val();
			   arraydelete[i]=valor;
		    });
			
			 $("#reservas input:checked").each( 
				function(i) { 
				  reservahordel=$(this).val(); 
			});
			
	
		 $.ajax({
					
		  type: 'POST',
		  url: 'funciones/Asignatura/DeleteSchedule.php',
		  data: 'idHorario='+arraydelete,
		  success: function(datos)
		  {
			 if(datos==1)
			 {
				alertas("El(Los) horario(s) ha(n) sido eliminados(s) con exito","Modificar horario reserva","done");
	            consultarHorarios(reservahordel,2)
			 }
			 
	      }
	    });
		
	 }
	 
	 
	 
	 $("#eliminarrecurso").button().click(function(){
		
	  if($(".keyrecurso").is(":checked"))
       {	
		 $("#deleterecurso").dialog("open");
		 
	  }
	  else
	  {
	    alertas("Por favor selecccione al menos un recurso para eliminar","Modificar recurso reserva","error");
      }
	 });
	 
	 	
	 function eliminarrecursoreserva()
	 {	
	   	  arrayrecurso=[];
		  	
	        $("input:checked.keyrecurso").each( 
			function(i) { 
		       valor=$(this).val();
			   arrayrecurso[i]=valor;
		    });
			
			$("#reservas input:checked").each( 
				function(i) { 
				  reservarecdel=$(this).val(); 
			});
			
	
		 $.ajax({
					
		  type: 'POST',
		  dataType:'json',
		  url: 'funciones/ReservaEventual/eliminarrecurso.php',
		  data: 'idRecurso='+arrayrecurso,
		  success: function(datos)
		  {
			 if(datos.error==1)
			 {
				consultarRecursos(reservarecdel,2); 
				alertas("El(Los) recurso(s) ha(n) sido eliminado(s) con exito","Modificar recurso reserva","done");
	           
			 }
			 else if(datos.error==0)
			 {
				alertas("El(Los) recurso(s) no ha(n) sido eliminado(s) de la reserva","Modificar recurso reserva","error"); 
			 }
			 
			 
	      }
	    });
		
	 }
	 
	 
	 
	
	 	 
$("#adicionarrecurso").click(function(){   

   x++;
  
$("#reservarecursos").append('<tbody><td><input name="horario" type="checkbox" class="schedule"  value="i" /></td><td><select size="1" name="grupo" class=" source text ui-widget-content ui-corner-all" id="grupo'+x+'"><?php do {?><option value="<?php echo $row_JRRecursos['idTipo']?>" ><?php echo $row_JRRecursos['descripcionTipo']?></option><?php }while ($row_JRRecursos = mysql_fetch_assoc($JRRecursos)); $rows = mysql_num_rows($JRRecursos); if($rows > 0){mysql_data_seek($JRRecursos, 0);$row_JRRecursos = mysql_fetch_assoc($JRRecursos);}?></select></td><td><select size="1" name="subgrupo" class="source text ui-widget-content ui-corner-all" id="subgrupo'+x+'"> <option selected value="0">Seleccione</option></select></td><td><input type="text" size="10" class=" source text ui-widget-content ui-corner-all" id="cantidad"/></td><td><input type="text" size="20" class=" source text ui-widget-content ui-corner-all" id="software"/></td></tbody>');

   

    $("#grupo"+x).change(function(){
		
		 var id = $("#grupo"+x).find(':selected').val();
		 $("#subgrupo"+x).load('consultas/Recurso/generarselect.php?id='+id);
		 //$("#formaddrecursos").css({width:"520px", height:"auto"});	
    });
			 			  
});


 // Elimina un recurso de la reserva
   $('#deleterowrec').click(function(){
				  
	$("#formaddrecursos").find("input:checked").parents("tr").remove();
				
  });
	 
	 
	 $("#editarrecurso").button().click(function () {
		 
		 
		  if($(".keyrecurso").is(":checked"))
           {	
	         var contador=0; 
		  
			$("input:checked.keyrecurso").each( 
				function(i) {
				 contador+=1;
			});
		
				if(contador==1)
				{   
				   
				   
				   valor=$("#searchrecurso").find("input:checked").parents("tr");
					
					// Obtengo los valores de la tabla
				    cantidadR= valor.find("td").eq(2).text();
					softwareR= valor.find("td").eq(3).text();
					
					//Asigno a los input del formulario de modificar horario los valores obtenidos arriba
			        $("#editcantrec").val(cantidadR);
					$("#editsoftrec").val(softwareR);
					
			     	
					//Muestro el formulario de modificación
					$("#formupdaterecurso").show("slide"); 
				}
				else
				{
				   alertas("Por favor seleccione una sola opcion para modificar","Modificar recurso reserva","warning")	
				}
		   }
		   else
		   {
			  alertas("Por favor seleccione una opcion para modificar","Modificar recurso reserva","warning")	  
		   }
		
	 });
	 
	 
	  $("#addrecurso").button().click(function () {
		 
		$("#formaddrecursos").show("slide"); 
	 });
	 
	 
	  $("#addrecres").button().click(function () {
		 
		 //Vacio el array de recursos 
			cadenarecurso=[];
						
		// Recorrro el formulario de recursos y obtengo los datos en un array
			$(':input.source').each(function(i){
				valor=$(this).val();
				cadenarecurso[i]=valor;
			});
			
		   
		   $("#reservas input:checked").each( 
				function(i) { 
				  reservaaddrec=$(this).val(); 
			});
			
			
			//Obtengo el tamaño de cadenarecurso
		   tamañoarrayrecursos=cadenarecurso.length;
		   
		  if(tamañoarrayrecursos > 0)
		  { 
		 
			 $.ajax({
				
				type:'POST',
				dataType:'json',
				url:'funciones/ReservaEventual/adicrecurso.php',
				data:'arrayrecursos='+cadenarecurso+'&reserva='+reservaaddrec,
				success: function (datos)
				{
				   if(datos.error==1)
				   {
					   alertas("El recurso fue adicionado con exito","Adicionar recurso reserva","done")
					   $("#formaddrecursos").hide();
					   $("tbody", "#reservarecursos").remove();  
					   consultarRecursos(reservaaddrec,2);  
				   }
				   else if(datos.error==0)
				   {
					   alertas("El recurso no fue adicionado","Adicionar recurso reserva","error")  
				    
				   }
			   }
			
	         }); 
		  }
		  else
		  {
			 alertas("Por favor adicione un recurso","Adicionar recurso reserva","error");  
		  }
	  });
	 
	 
	  $("#eliminarrecurso").button().click(function () {
		 
		 
	 });
	 
	 $("#closeupdhor").click(function () {
		 
		$("#formupdatehorario").hide("slide"); 
		 
	});
	
	 $("#closeaddhor").click(function () {
		 
		$("#formaddhorario").hide("slide"); 
		 
	});
	
	
	$("#closeupdhorrec").click(function () {
		 
		$("#formaddrecursos").hide("slide"); 
		 
	});
	
	
	$("#closeupdrec").click(function () {
		 
		$("#formupdaterecurso").hide("slide"); 
		 
	});
	
	
	   
   
   $("#editgrupo").change(function(){
		
		 var id = $("#editgrupo").find(':selected').val();
		 $("#editsubgrupo").load('consultas/Recurso/generarselect.php?id='+id);
		 
    });
	
	
	$("#updrecurso").button().click(function () {
	 
	  if($(".keyrecurso").is(":checked"))
      {	
	         var contador=0; 
			
		  
			$("input:checked.keyrecurso").each( 
				function(i) {
			      valor=$(this).val();
				  contador+=1;
			});
			
			 $("#reservas input:checked").each( 
				function(i) { 
				  reserva=$(this).val(); 
			});
		
				if(contador==1)
				{   
				   // Obtengo los parametros los cuales voy a modificar
				   var idrecurso= valor;
				   var nuevogrupo=$("#editgrupo").val();
				   var nuevosubgrupo=$("#editsubgrupo").val();
				   var nuevacantidad=$("#editcantrec").val();
				   var nuevosoftware=$("#editsoftrec").val();
				  
				   
				   // Hago la peticion ajax al servidor para actualizar los datos
				   
				   $.ajax({
					
					  type: 'POST',
					  dataType:'json',
					  url: 'funciones/ReservaEventual/updaterecursoreserva.php',
					  data: 'idRecurso='+idrecurso+'&grupo='+nuevogrupo+'&subgrupo='+nuevosubgrupo+'&cantidad='+nuevacantidad+'&software='+nuevosoftware,
					  success: function(datos)
					  {
						 if(datos.error==1)
						 {
							 alertas("El recurso ha sido modificado exitosamente","Modificar recurso reserva","done");
							 consultarRecursos(reserva,2); 
							
						 }
						 else if(datos.error==0)
						 {
							 alertas("El recurso no fue modificado","Modificar recurso reserva","error");
							 
						 }
					  }
				   });
				   
				       
				}
				else
				{
					alertas("Por favor seleccione solo un recurso para modificar","Modificar recurso reserva","error"); 
				}
				
	  }
	  else
	  {
		 alertas("Por favor seleccione un recurso para modificar","Modificar recurso reserva","error");  
	  }
				   	
		
   });
		
	
   $("#grupoasig").keydown(function(event) {
	  
	       if (event.keyCode == '13') 
		   {
	         event.preventDefault();
			 codigo=$("#codasig").val();
			 grupo=$("#grupoasig").val();
	         consultarreservas(codigo,grupo);
          } 
       });	
	   
	   
	   function consultarreservas(codigo,grupo)
	   {	
			
			
			   var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codasig",
					  validations:
					  {
					      required:[true,"El campo codigo asignatura no puede estar vacio."],
						  
					  }
				  },
				  
				  {
					  id:"grupoasig",
					  validations:
					  {
					      required:[true,"El campo grupo no puede estar vacio."],
						  number:[true,"El campo grupo debe contener numeros."],
					  }
				  }
								
				  ],
				  				  
				   beforeValidation:function()
				   {
					  
			           $.ajax({
					   
						 type: 'POST',
						 dataType:'html',
						 url: 'consultas/ReservaEventual/Obtenerreservas.php',
						 data: 'codigo='+codigo+'&grupo='+grupo,
						 
						  success: function(datos)
						 {
							 $("#reservas").html(datos);
						
						  }
						});
						
				   }
				  }; 
				$.validation(options);  
		 }
		 
		 
		 
		 $(".checkboxreserva").live("click",function(){
	  
	   
	      if($(this).is(":checked"))
           {	
	         var contador=0; 
			 
			$("#reservas input:checked").each( 
				function(i) { 
				  contador+=1;
				 
			});
			
				if(contador==1)
				{  
				   //consultardatosreserva(valor);
				   
				   valor=$("#reservas").find("input:checked").parents("tr");
					
					// Obtengo los valores de la tabla
				    Noreserva= valor.find("td").eq(0).text();
				    codigoA = valor.find("td").eq(2).text();
				    grupoA= valor.find("td").eq(3).text();
				    nombreA = valor.find("td").eq(4).text();
					codigoresp = valor.find("td").eq(5).text();
					nombreresp = valor.find("td").eq(6).text();
					//email = valor.find("td").eq(7).text();
					internet = valor.find("td").eq(7).text();
				    llenarformularioreserva(Noreserva,codigoA,grupoA,nombreA,codigoresp,nombreresp,email,internet)
					consultarEmailReserva(Noreserva);
				    consultarHorarios(Noreserva,2);
				    consultarRecursos(Noreserva,2);
				}
				else if(contador > 1)
				{
				   alertas("Por favor seleccione una sola reserva","Consulta Reserva Eventual","warning")
				}
				
		   }
	  
	  });

									 						
     $("#grupo").keydown(function(event) {
	  
	       if (event.keyCode == '13') 
		   {
	         event.preventDefault();
			 codasignatura=$("#codigo").val();
			 grupo=$("#grupo").val();
	         consultarnombreasignatura(codasignatura, grupo);
          } 
       });	
  
  
		 $("#codresp").keydown(function(event) {
		  
		 if (event.keyCode == '13') 
		 {
			event.preventDefault();
			codusuario=$("#codresp").val();
			consultarnombreusuario(codusuario);
		  } 
		});	
		
		
		function consultarnombreasignatura(codigo,grupo)
       {
	  
	       var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  
				  {
					  id:"grupo",
					       validations:
						   {
					         required:[true,"El campo grupo no puede estar vacio."],
							 number:[true,"El campo grupo debe contener numeros."]
						   }				  
				  },
				  
				  {
					  id:"codigo",
					       validations:
						   {
					         required:[true,"El campo codigo asignatura no puede estar vacio."],
							 
						   }				  
				  },
				  							
				  ],
				  				  
				   beforeValidation:function()
				   {
					   
					   $.ajax({
									   
						type: 'POST',
						dataType:'json',
						url: 'consultas/ReservaEventual/consultarAsignatura1.php',
						data: 'codigo='+codigo+'&grupo='+grupo,
										 
						success: function(datos)
						{
						   if(datos.error==0)
						   {
							   $("#nombre").val(datos.nombre);  
						   }
						   else if(datos.error==1)
						   {
								alertas("Por favor verifique que la asignatura o el grupo existen","Modificar reserva","error");
						   }
						   
						}
					 });
					 
				  }
				 }; 
			$.validation(options);  
 }
 
 
 function consultarnombreusuario(codigo)
 {
	 
	 var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  
				  {
					  id:"codresp",
					       validations:
						   {
					         required:[true,"El campo Codigo responsable no puede estar vacio."],
							 number:[true,"El campo Codigo responsable debe contener numeros."]
						   }				  
				  },
				  							
				  ],
				  				  
				   beforeValidation:function()
				   {
	 
	 
					   $.ajax({
					   type: 'POST',
					   dataType:'json',
					   url: 'consultas/Usuario/consultarUsuario.php',
					   data: 'codigo='+codigo,
										 
						success: function(datos)
						{
							if(datos.error==0)
						   {
							    nombreusuario=datos.nombre;
							    $("#nomresp").val(nombreusuario)  
						   }
						   else if(datos.error==1)
						   {
							   alertas("El usuario no existe","Modificar reserva","error"); 
						   }
						}
					 }); 
					 
				}
			  }; 
			$.validation(options);  
   }

	$("#closeeditR").click(function () {
		
	  $("#formmodreserva").hide("slide");	
		
	});
	
	$("#closeeditH").click(function () {
		
		$("#Horario").hide("slide");
	});
	
	$("#closeeditREC").click(function() {
		
	  $("#recursosR").hide("slide");
		
	});
	
	$("#limpiarform").button().click(function() {
		
	 $("#codasig").val("");
	 $("#grupoasig").val("");
	 $("#reservas").empty();
	 $("#formmodreserva").hide();
	 $("#Horarioreserva").empty();
	 $("#Horario").hide();
	 $("#recursoreserva").empty();
	 $("#recursosR").hide();
	 $("#formupdatehorario").hide();
	 $("#formupdaterecurso").hide();
	 $("#formaddhorario").hide();
	 $("#formaddrecursos").hide();
	 $("#codasig").focus();
	 	
		
	});
	
	function consultarEmailReserva(Noreserva)
	{
	   $.ajax({
		 type: 'POST',
		 dataType:'json',
		 url: 'consultas/ReservaEventual/consultarEmailReserva.php',
		 data: 'reserva='+Noreserva,
										 
		  success: function(datos)
		  {
			 if(datos.error==0)
			 {
				var email=datos.email;
			    $("#email").val(email);  
			 }
						   
		 }
	   }); 	
		
	}
	
	// Modifica la matricula de una reserva
	   function actualizarMatriculaReserva(sala,idHorario)
	   {
		   
	      $.ajax({
					
					 type: 'POST',
					 dataType:'json',
					 url: 'funciones/ReservaEventual/actualizarMatriculaReserva.php',
					 data: 'sala='+sala+'&idhorario='+idHorario,
					 success: function(datos){
					   
					   if(datos.error==1)
					   {  
						  alertas("La matricula se ha modificado exitosamente ","Modificar matricula reserva","done");     
					   }
					   else if(datos.error==0)
					   {
						  alertas("La matricula no fue actualizada ","Modificar matricula reserva","inform");       
					   }
					  
					 }
	            });	
	         }
							 
});// cierro jquery

</script>


</head>

<body>

<p id="validateErrors"></p>

        
     <div  class="text ui-widget-content ui-corner-all" style="width:560px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y;">
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MODIFICAR RESERVA</div>
          
        <table style="margin-left:15px;">
       
        <tr>
          <td><label for="titulo">Codigo Asignatura:</label></td>
          <td><input type="text"  id="codasig" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td> 
        </tr>
       
        <tr>
         <td><label for="titulo">Grupo:</label></td>
         <td><input type="text"  id="grupoasig" size="5" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
        
        <tr>
         <td><button type="button" id="limpiarform" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/> Limpiar</button></td>
        </tr>
         
         </table> 
      </div>
    
      
      <div id="reservas"></div>
      
      
      
      <div id="formmodreserva" class="text ui-widget-content ui-corner-all" style="width:560px; height:auto; font-size:12px; background-color:#F8F8F8;             background-repeat:repeat-y; margin-top:10px;"><div style="float:right" id="closeeditR" title="Cerrar ventana"><img src="images/close1.png"/></div>
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MODIFICAR DATOS RESERVA</div>
          
        <table style="margin-left:15px;">
       
        <tr>
        	<td><label for="titulo">Codigo Asignatura:</label></td>
            <td><input type="text"  id="codigo" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td> 
        </tr>
       
        <tr>
        	<td><label for="titulo">Grupo:</label></td>
            <td><input type="text"  id="grupo" size="5" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
        
        <tr>
        	<td><label for="titulo">Nombre asignatura:</label></td>
            <td><input type="text"  id="nombre" size="45" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
        
        <tr>
        	<td><label for="titulo">Codigo Responsable:</label></td>
            <td><input type="text"  id="codresp" size="20" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
        
        <tr>
        	<td><label for="titulo">Nombre responsable:</label></td>
            <td><input type="text"  id="nomresp" size="45" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
        
        <tr>
        	<td><label for="titulo">Correo Electronico:</label></td>
            <td><input type="text"  id="email" size="45" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
         
         <tr>
        	<td><label>Internet:</label></td>
            <td><select id="Selectinternet" size="1">
              <option value="Si">Si</option>
              <option value="No">No</option>
            
            </select></td>       
        </tr>
        
       </table>
     
     <table style="margin-left:15px;">  
     <tr>
        <td><button type="button" value="Aceptar" id="ModificarReserva" style="font-size:11px; margin-top:10px; margin-bottom:10px;" ><img src="images/edit.png"  style="vertical-align:middle; padding-right:3px;"/>Modificar reserva</button> </td>
        </tr>
     </table> 
      </div>
     
     <div id="Mostrarhorarios" style="margin-top:10px;"></div> 
     
  
      
       <!-- div donde se muestra los horarios de la reserva eventual -->
       <div id="Horario" class="text ui-widget-content ui-corner-all" style="width:560px; height:auto; margin-bottom:10px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y;"><div style="float:right" id="closeeditH" title="Cerrar ventana"><img src="images/close1.png"/></div>
         <div class="ui-state-default" style="text-align:center;">MODIFICAR HORARIOS RESERVA</div>
           <div id="Horarioreserva" style="overflow:auto; width:580px; height:auto; margin-top:auto;"></div>
           
           <table style="margin-left:10px;">
         <tr>
         <td><button type="button" id="editar" title="Editar horario Asignatura"  style="font-size:11px; margin-top:10px; margin-bottom:10px;"> <img         src="images/edit1.png"  style="vertical-align:middle; padding-right:3px;"/>Editar Horario</button></td>
        <td><button type="button" id="addSchedule" title="Adiciona un nuevo horario a la asignatura"  style="font-size:11px; margin-top:10px; margin-bottom:10px;"> <img src="images/add2.png"  style="vertical-align:middle; padding-right:3px;"/>Adicionar Horario</button></td>
        <td><button type="button" id="eliminarHorario" title="Elimina un horario de la asignatura"  style="font-size:11px; margin-top:10px; margin-bottom:10px;"> <img src="images/delete.png"  style="vertical-align:middle; padding-right:3px;"/>Eliminar Horario</button></td>
          </tr>
       </table>
           
       </div>
       
       
       <!-- div donde se muestra los recursos recursos de la reserva eventual-->
       
        <div id="recursosR" class="text ui-widget-content ui-corner-all" style="width:560px; height:auto; margin-bottom:10px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y;"><div style="float:right" id="closeeditREC" title="Cerrar ventana"><img src="images/close1.png"/></div>
         <div class="ui-state-default" style="text-align:center;">MODIFICAR RECURSOS RESERVA</div>
           <div id="recursoreserva" style="overflow:auto; width:580px; height:auto; margin-top:auto;"></div>
           
           <table style="margin-left:10px;">
         <tr>
         <td><button type="button" id="editarrecurso" title="Editar recurso reserva"  style="font-size:11px; margin-bottom:10px;"> <img         src="images/edit1.png"  style="vertical-align:middle; padding-right:3px;"/>Editar recurso</button></td>
        <td><button type="button" id="addrecurso" title="Adiciona un nuevo recurso a la reserva"  style="font-size:11px; margin-bottom:10px;"> <img src="images/add2.png"  style="vertical-align:middle; padding-right:3px;"/>Adicionar recurso</button></td>
        <td><button type="button" id="eliminarrecurso" title="Elimina un recurso de la reserva"  style="font-size:11px;  margin-bottom:10px;"> <img src="images/delete.png"  style="vertical-align:middle; padding-right:3px;"/>Eliminar recurso</button></td>
          </tr>
       </table>
           
       </div>
       
       
       <!-- div que contiene el formulario para modificar los horarios de la reserva-->
       <div id="formupdatehorario" class="text ui-widget-content ui-corner-all" style="width:530px;  margin-bottom:15px; height:auto;" background-color:#F8F8F8; background-repeat:repeat-y;><div style="float:right" id="closeupdhor" title="Cerrar ventana"><img src="images/close1.png"/></div>
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MODIFICAR HORARIO</div>
         
        <table style="margin-left:15px;">
        <tr>
        	<td><label>Dia</label></td>
            <td><select size="1" id="dia">
              <option value="1" >Lunes</option><option value="2" >Martes</option><option value="3" >Miercoles</option><option value="4" >Jueves</option>
              <option value="5" >Viernes</option><option value="6" >Sabado</option></select>
            </td>
            
            <td><label>Sala</label></td>
            <td><select size="1" id="salares">
             <?php
             do {  
               ?>
            	  <option value="<?php echo $row_JRSalas['numSala']?>"><?php echo $row_JRSalas['numSala']?></option>
            	  <?php
						} while ($row_JRSalas = mysql_fetch_assoc($JRSalas));
						  $rows = mysql_num_rows($JRSalas);
						  if($rows > 0) {
							  mysql_data_seek($JRSalas, 0);
							  $row_JRSalas = mysql_fetch_assoc($JRSalas);
						  }
						?>
            
            </select>
            </td>
            
            <td><label>Hora Inicio:</label></td>
            <td><select id="horainicio" size="1" > <?php echo getSelectTimer(); ?>  </select></td>
     
     <td><label>Hora Final:</label></td>
     <td><select id="horafinal" size="1" ><?php echo getSelectTimer(); ?></select></td>
           
            </tr>
            </table>
            
            <table style="margin-left:15px;">
            <tr>
            <td><label>Fecha Inicio:</label></td>
            <td><input type="text" id="nuevafechai" class="text ui-widget-content ui-corner-all"/> </td>
            <td><label>Fecha Final :</label></td>
            <td><input type="text" id="nuevafechat" class="text ui-widget-content ui-corner-all"/> </td>
            </tr>
           </table>
           
           <table style="margin-left:15px;">
             <tr>
              <td><button id="actualizarhorario" style="font-size:11px; margin-bottom:10px;"><img src= "images/schedule.png" style="vertical-align:middle;"/>Cambiar Horario</button></td>
             </tr>
            </table>
            
      </div>
      
      
      <!-- div que contiene el formulario para modificar los recursos de la reserva-->
       <div id="formupdaterecurso" class="text ui-widget-content ui-corner-all" style="width:450px;  margin-bottom:15px; height:auto;" background-color:#F8F8F8; background-repeat:repeat-y;><div style="float:right" id="closeupdrec" title="Cerrar ventana"><img src="images/close1.png"/></div>
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MODIFICAR RECURSO</div>
        
         <table style="margin-left:10px;">
         
         <tr>
         
         <td><label>Grupo:</label></td>
         <td><select size="1"  class="text ui-widget-content ui-corner-all" id="editgrupo"><?php do {?><option value="<?php echo $row_JRRecursos['idTipo']?>" ><?php echo $row_JRRecursos['descripcionTipo']?></option><?php }while ($row_JRRecursos = mysql_fetch_assoc($JRRecursos)); $rows = mysql_num_rows($JRRecursos); if($rows > 0){mysql_data_seek($JRRecursos, 0);$row_JRRecursos = mysql_fetch_assoc($JRRecursos);}?></select></td>
         </tr>
         
         <tr>
         
         <td><label>Subgrupo:</label></td>
         <td><select size="1" name="subgrupo" class="text ui-widget-content ui-corner-all" id="editsubgrupo"> <option selected value="0">Seleccione</option></select></td>
         </tr>
        
         <tr>       
          <td><label>Cantidad:</label></td>
          <td><input type="text" class="text ui-widget-content ui-corner-all height font12" size="7" id="editcantrec"/></td>
         </tr>
         
         <tr>
           <td><label>Software:</label></td>
           <td><input type="text" class="text ui-widget-content ui-corner-all height font12" size="30" id="editsoftrec"/></td>
         </tr>
         
         <tr>
         <td><button id="updrecurso" style="font-size:12px; margin-bottom:10px;"><img src= "images/schedule.png" style="vertical-align:middle;"/>Modificar recurso</button></td>
         </tr>
           
         
       </table> 
        
        
        </div>
        
      
    <!--Formulario para adicionar mas horarios a la asignatura -->
    <div id="formaddhorario" class="text ui-widget-content ui-corner-all" style="width:400px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y;"><div style="float:right" id="closeaddhor" title="Cerrar ventana"><img src="images/close1.png"/></div>
     <div class="ui-state-default" style="text-align:center; margin-bottom:15px;"> ADICIONAR HORARIO RESERVA</div>
     
     <p><img src="images/add1.png" id="añadir" title="Añade un horario a la reserva" style="padding-right:2px;"/> <img src="images/delete.png" id="eliminar" title="Elimina un horario de la reserva" style="padding-right:3px;"/></p>
     
     
    
    <table id="horarioreserva" style="margin-left:15px;">
    <thead>
         <th></th>    
    	<th>Dia Clase</th>
        <th>Hora Entrada</th>
        <th>Hora Salida</th>
        <th>Comienzo</th>
        <th>Finalizacion</th>
        <th>Sala</th>
    </thead>   
  </table>
  
  <button type="button" id="addScheduleAsig" style="font-size:11px; margin-top:10px; margin-left:15px; margin-bottom:10px; "><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Adicionar </button>
  
  </div>
  
  <!-- div que contiene el formulario para adicionar mas recursos a la reserva-->
 <div id="formaddrecursos" class="text ui-widget-content ui-corner-all" style="max-width:650px; min-width:540px; height:auto; font-size:12px; margin-bottom:10px; background-color:#F8F8F8;background-repeat:repeat-y;"><div style="float:right" id="closeupdhorrec" title="Cerrar ventana"><img src="images/close1.png"/></div>
 
     <div class="ui-state-default" style="text-align:center; margin-bottom:10px;">ADICIONAR RECURSOS</div>
     
     <p><img src="images/add1.png" id="adicionarrecurso" title="Adiciona un recurso a la reserva" style="padding-right:2px;"/> <img src="images/delete.png" id="deleterowrec" title="Elimina un recurso de la reserva" style="padding-right:3px;"/></p>
     
     
    
    <table id="reservarecursos" style="margin-left:15px; margin-bottom:10px;">
    <thead>
         <th></th>    
    	<th>Grupo</th>
        <th>Subgrupo</th>
        <th>Cantidad</th>
        <th>Software</th>
    </thead>   
  </table>
  
   <button type="button" id="addrecres" style="font-size:11px; margin-top:10px; margin-left:15px; margin-bottom:10px; "><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Adicionar </button>
  
   </div>     
  
            
   <div id="alertas"></div>
   <div id="deleteschedule"><p style="font-size:11px;"><img src="images/dialog-warning.png" style="float:left; padding:5px;"/>¿ESTA SEGURO QUE QUIERE ELIMIMAR EL HORARIO DE LA RESERVA?</p></div> 
   
   <div id="deleterecurso"><p style="font-size:11px;"><img src="images/dialog-warning.png" style="float:left; padding:5px;"/>¿ESTA SEGURO QUE QUIERE ELIMIMAR EL (LOS) RECURSO(S) DE LA RESERVA?</p></div> 
   
</body>
</html>

