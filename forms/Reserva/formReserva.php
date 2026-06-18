<?php require_once('../../Connections/conexion.php'); ?>
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
<title>Cupi-Control de Utilizacion Piso Informatico</title>



<script type="text/javascript">

  
 
var i=0;
var x=0;

$(function(){
	
  var cadenahorario=new Array();
  var cadenarecursos= new Array();
  $("#formcorreo").hide();
  $("#datosadicreservaeventual").hide();
  $("#confirmation_email").hide(); 

  $.datepicker.setDefaults($.datepicker.regional['es']);
  
  


      $("#alertas" ).dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			modal:true		
		});
		
		
		$("#confirmation_email").dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			title:"Confirmación envio correo",
			modal:true,
			
			buttons: {
				
				"Aceptar": function() {
					
					SendEmail(codigoAsig,grupo,codigoresponsable,correo,Noreserva,nameasignatura,nameusuario,Fechahorareserva);
					
					$( this ).dialog( "close" );
				},
				Cancelar: function() {
					$( this ).dialog( "close" );
				}
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
		
		
		
		 $("#grupo").keydown(function(event) {
	  
	       if (event.keyCode == '13') 
		   {
	         event.preventDefault();
			 codasignatura=$("#codasig").val();
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
		
					
			function insertarreserva(horarios,tiporeserva)
			{	
			
			        // Capturo las variables del formulario 
			        codigoAsig= $("#codasig").val();
			        grupo= $("#grupo").val();
			        codigoresponsable= $("#codresp").val();
			        correo=$("#email").val();
					sala=$("#sala").val();
					internet=$("#internet").val();
					nameasignatura=$("#nomasig").val();
					nameusuario=$("#nomresp").val();
					
					 //Vacio el array de recursos 
					 cadenarecurso=[];
						
						// Recorrro el formulario de recursos y obtengo los datos en un array
						$(':input.source').each(function(i){
							valor=$(this).val();
							cadenarecurso[i]=valor;
					   });	
					   
					   //Obtengo el tamaño de cadenarecurso
					   tamañoarrayrecursos=cadenarecurso.length;
				
					  
			          if(tamañoarrayrecursos==0)
					  {
					    insertarrecurso=0;
					  }
					  else if(tamañoarrayrecursos > 0)
					  {
					    insertarrecurso=1;
					  }	
		
			       $.ajax({
					   
						 type: 'POST',
						 dataType:'json',
						 url: 'funciones/ReservaEventual/insertarreserva.php',
						 data: 'codigoA='+codigoAsig+'&grupo='+grupo+'&codigoresp='+codigoresponsable+'&email='+correo+'&arrayhorarios='+horarios+'&arrayrecursos='+cadenarecurso+'&internet='+internet+'&nameasignatura='+nameasignatura+'&nameusuario='+nameusuario+'&insertarrecurso='+insertarrecurso+'&tiporeserva='+tiporeserva,
						 
						 success: function(datos)
						 {
						
							 if(datos.error==0)
							 {
								 // Limpio el formulario
								 limpiarformulario();
								 
								 // Obtengo el numero de reserva y la fecha de reserva
								  Noreserva=datos.reserva;
								  Fechahorareserva=datos.fechahorareserva;
								 
								
								// Envio mensaje al usuario
								if(tiporeserva==1)
								{
								   alertas("La reserva"+" "+Noreserva+" "+ "ha sido creada satisfactoriamente","Crear Nueva Reserva","done");
								}
								 
								else if(tiporeserva==2)
								{	
								    $("#datosadicreservaeventual").hide();
									$("#confirmation_email").text("¿LA RESERVA"+" "+Noreserva+" "+ "HA SIDO CREADA SATISFACTORIAMENTE, DESEA ENVIAR UN CORREO AL USUARIO INFORMANDOLE DE LA CREACIÓN DE LA RESERVA?")
									$("#confirmation_email").dialog("open");
								}
								 
								 
								  
							 }
							 else if(datos.error==1)
							 {
								 alertas("Se ha producido un error en la inserción de los datos","Crear Nueva Reserva","error");
										
							 }
						   }
						}); 
					  }
								  
						 
// Adiciona un horario a la reserva
$("#adicionarhorres").click(function(){   

 $("#horario").css({width:"560px", height:"auto"});
   i++;
   
   

$("#horarioasigreserva").append('<tbody><td><input name="horario" type="checkbox" class="schedule"  value="i" /></td><td><select id="dia" size="1" class="horario"><option value="1">Lunes</option><option value="2">Martes</option><option value="3">Miercoles</option><option value="4">Jueves</option><option value="5">Viernes</option><option value="6">Sabado</option></select></td> <td><select name= "horainicial" id="horainicial" class="horario" style="margin-left:6px;"><option value="07:00:00">07:00</option><option value="07:30:00">07:30</option><option value="08:00:00">08:00</option><option value="08:30:00">08:30</option><option value="09:00:00">09:00</option><option value="09:30:00">09:30</option><option value="10:00:00">10:00</option><option value="10:30:00">10:30</option><option value="11:00:00">11:00</option><option value="11:30:00">11:30</option><option value="12:00:00">12:00</option><option value="12:30:00">12:30</option><option value="13:00:00">13:00</option><option value="14:00:00">14:00</option><option value="14:30:00">14:30</option><option value="15:00:00">15:00</option><option value="15:30:00">15:30</option><option value="16:00:00">16:00</option><option value="16:30:00">16:30</option><option value="17:00:00">17:00</option><option value="17:30:00">17:30</option><option value="18:00:00">18:00</option><option value="18:30:00">18:30</option><option value="19:00:00">19:00</option><option value="19:30:00">19:30</option><option value="20:00:00">20:00</option><option value="20:30:00">20:30</option><option value="21:00:00">21:00</option><option value="21:30:00">21:30</option><option value="22:00:00">22:00</option></select></td><td><select name= "horafinal" id="horafinal" class="horario" style="margin-left:6px;"><option value="07:00:00">07:00</option><option value="07:30:00">07:30</option><option value="08:00:00">08:00</option><option value="08:30:00">08:30</option><option value="09:00:00">09:00</option><option value="09:30:00">09:30</option><option value="10:00:00">10:00</option><option value="10:30:00">10:30</option><option value="11:00:00">11:00</option><option value="11:30:00">11:30</option><option value="12:00:00">12:00</option><option value="12:30:00">12:30</option><option value="13:00:00">13:00</option><option value="14:00:00">14:00</option><option value="14:30:00">14:30</option><option value="15:00:00">15:00</option><option value="15:30:00">15:30</option><option value="16:00:00">16:00</option><option value="16:30:00">16:30</option><option value="17:00:00">17:00</option><option value="17:30:00">17:30</option><option value="18:00:00">18:00</option><option value="18:30:00">18:30</option><option value="19:00:00">19:00</option><option value="19:30:00">19:30</option><option value="20:00:00">20:00</option><option value="20:30:00">20:30</option><option value="21:00:00">21:00</option><option value="21:30:00">21:30</option><option value="22:00:00">22:00</option></select></td><td><input type="text"  size="15" class="comienzo horario text ui-widget-content ui-corner-all" id="comienzo'+i+'" title="De click dentro del cajon de texto para mostrar la fecha"/></td><td><input type="text" size="15" class="final horario text ui-widget-content ui-corner-all" id="final'+i+'" title="De click dentro del cajon de texto para mostrar la fecha"/></td><td><select id="sala" size="1" class="horario"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option></select></td></tbody>');


 
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


$("#adicionarrecurso").click(function(){   

   x++;
  
$("#reservarecursos").append('<tbody><td><input name="horario" type="checkbox" class="schedule"  value="i" /></td><td><select size="1" name="grupo"   class=" source text ui-widget-content ui-corner-all" id="grupo'+x+'"><?php do {?><option value="<?php echo $row_JRRecursos['idTipo']?>" ><?php echo $row_JRRecursos['descripcionTipo']?></option><?php }while ($row_JRRecursos = mysql_fetch_assoc($JRRecursos)); $rows = mysql_num_rows($JRRecursos); if($rows > 0){mysql_data_seek($JRRecursos, 0);$row_JRRecursos = mysql_fetch_assoc($JRRecursos);}?></select></td><td><select size="1" name="subgrupo" class="source text ui-widget-content ui-corner-all" id="subgrupo'+x+'"> <option selected value="0">Seleccione</option></select></td><td><input type="text" size="10" class=" source text ui-widget-content ui-corner-all" id="cantidad"/></td><td><input type="text" size="20" class=" source text ui-widget-content ui-corner-all" id="software"/></td></tbody>');

   

    $("#grupo"+x).change(function(){
		
		 var id = $("#grupo"+x).find(':selected').val();
		 $("#subgrupo"+x).load('consultas/Recurso/generarselect.php?id='+id);
		 $("#formrecursos").css({width:"520px", height:"auto"});	
    });
			 			  
});

				 
  // Elimina una fila del horario de la reserva 
  $('#eliminarhorres').click(function(){
				  
	$("#horarioasigreserva").find("input:checked").parents("tr").remove();
				
 });
 
 
 function SendEmail(codigoAsig,grupo,codigoresponsable,correo, Noreserva, nombreasignatura, nombreusuario, fechahora)
 {
	      $.ajax({
					   
			   type: 'POST',
			   url: 'funciones/ReservaEventual/SendEmail.php',
			   data: 'codigoA='+codigoAsig+'&grupo='+grupo+'&codigoresp='+codigoresponsable+'&email='+correo+'&Noreserva='+Noreserva+'&nomasignatura='+nombreasignatura+'&nomusuario='+nombreusuario+'&fechahora='+fechahora,
								 
			   success: function(datos)
	           {
					  
			   }
			
		     });							  
  }
 
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
							   $("#nomasig").val(datos.nombre);  
						   }
						   else if(datos.error==1)
						   {
								alertas("Por favor verifique que la asignatura o el grupo existen","Crear Nueva Reserva","error");
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
							    var nombre=datos.nombre;
								var apellidos=datos.apellidos;
								var nombreusuario=nombre+" "+apellidos
							    $("#nomresp").val(nombreusuario)  
						   }
						   else if(datos.error==1)
						   {
							   alertas("El usuario no existe","Crear Nueva Reserva","error"); 
						   }
						}
					 }); 
					 
				}
			  }; 
			$.validation(options);  
   }
 
 
 function verificarDisponibilidadSala(horarioClases,tiporeserva)
	{ 
	
	
	      tamañoarrayhorarios=horarioClases.length;
					  
		  if(tamañoarrayhorarios > 0)  
		  {
		
		    $.ajax({
				
			 type: 'POST',
			 url: 'funciones/Asignatura/addScheduleCruce.php',
			 data: 'horario='+horarioClases,
					  
			  success: function(datos)
			  {
				 cruceHorarioAddSchedule=datos.split('-');
		         respuestaAdd=cruceHorarioAddSchedule[0];
		         mensajeAdd= "Asignatura:"+" "+cruceHorarioAddSchedule[1]+" "+"Grupo:"+" "+cruceHorarioAddSchedule[2]+" "+"Dia:"+" "+cruceHorarioAddSchedule[                 3]+" "+ "Hora Inicio:"+" "+ cruceHorarioAddSchedule[4]+" "+"Hora Final:"+" "+ cruceHorarioAddSchedule[5]+" "+"Sala:"+" "+ cruceHorarioAddSchedule[6]; 
				  
				  
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
					insertarreserva(horarioClases,tiporeserva) 
				 }	 
			   }// cierro success
		    });// cierro ajax
		  }
		  else
		  {
			 alertas("Por favor seleccione un horario para la reserva","Adicionar Horario reserva","warning")  
		  }
	    }// cierro funcion
 
 function limpiarformulario()
 {
	$("#codasig").val("");
	$("#grupo").val(""); 
	$("#nomasig").val(""); 
	$("#codresp").val(""); 
	$("#nomresp").val(""); 
	$("#email").val(""); 
	$("#est").val(""); 
	$("tbody", "#horarioasigreserva").remove(); 
	$("tbody", "#reservarecursos").remove();
	$("#horario").css({width:"400px", height:"auto"});
	$("#formrecursos").css({width:"400px", height:"auto"}); 
	$("#codasig").focus();
	
 }
 
 function limpiarformularioreservaeventua()
 {
	 $("#codresp").val("");
	 $("#nomresp").val("");
	 $("#email").val(""); 
 }
 
 $("#writemail").button().toggle(function(){
	 
	$("#formcorreo").show("slide"); 
	 
 },function (){
	 
  $("#formcorreo").hide("slide"); 
 });
 
 
 $("#sendemailuser").button().click(function () {
	 
	correouser=$("#para").val();
	nombre=$("#nomresp1").val();
	asunto=$("#asunto").val();
	textocorreo=$("#textmail").val();
	 
	 
	 
	$.ajax({
					   
	  type: 'POST',
	  url: 'funciones/ReservaEventual/SendEmailUsuario.php',
	  data: 'email='+correouser+'&nomusuario='+nombre+'&asunto='+asunto+'&textocorreo='+textocorreo,
						 
		success: function(datos)
	    {
			  
	    }
			
	}); 
	 
 });
 
 $("#reservasem").button().click(function() {
	
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
					  id:"grupo",
					       validations:
						   {
					         required:[true,"El campo grupo no puede estar vacio."],
							 number:[true,"El campo grupo debe contener numeros."]
						   }				  
				  },
				  
				  
				  
				  {
					  id:"nomasig",
					  validations:
					    {
						   required:[true,"El campo nombre asignatura no puede estar vacio."],
						   
						  
						}
				  },		
				   
				  							
				  ],
				  				  
				   beforeValidation:function()
				   {
					
					
					  cadenahorario=[];
						
						$(':input.horario').each(function(i){
							valor=$(this).val();
							cadenahorario[i]=valor;
					   });
					  
					   verificarDisponibilidadSala(cadenahorario,1)
					   
					  }
				   }; 
				  $.validation(options);   
	 
	 
 });
 
 $("#reservaeve").button().click(function() {
	
	
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
					  id:"grupo",
					       validations:
						   {
					         required:[true,"El campo grupo no puede estar vacio."],
							 number:[true,"El campo grupo debe contener numeros."]
						   }				  
				  },
				  
				  
				  
				  {
					  id:"nomasig",
					  validations:
					    {
						   required:[true,"El campo nombre asignatura no puede estar vacio."],
						   
						  
						}
				  },		
				   
				  							
				  ],
				  				  
				   beforeValidation:function()
				   {
					
					
					  cadenahorario=[];
						
						$(':input.horario').each(function(i){
							valor=$(this).val();
							cadenahorario[i]=valor;
					   });
					   
					   // Despliega formulario adicional de reserva eventual
					    $("#datosadicreservaeventual").show("slide");
					   
					  }
				   }; 
				  $.validation(options);   
	  
	 
	 
 });
 
 
 $("#confirmreseventual").button().click(function() {
	 
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
				  
				  {
					  id:"nomresp",
					       validations:
						   {
					         required:[true,"El campo Nombre responsable no puede estar vacio."],
							
						   }				  
				  },
				  
				  
				  
				  {
					  id:"email",
					  validations:
					    {
						   required:[true,"El campo Correo electronico no puede estar vacio."],
						   email:[true,"El Correo electronico no es valido."],
						  
						}
				  },		
				   
				  							
				  ],
				  				  
				    beforeValidation:function()
				    {
					
					   cadenahorario=[];
						
						$(':input.horario').each(function(i){
							valor=$(this).val();
							cadenahorario[i]=valor;
					   });
					   
					    verificarDisponibilidadSala(cadenahorario,2)
					 
					}
				   }; 
				  $.validation(options);    
	 
	 
});


$("#closedataadicres").click(function () {
	
 $("#datosadicreservaeventual").hide("slide");	
	
});
 


	
}); // cierra el function
</script>



</head>

<body>
 
 <p id="validateErrors"></p>
 
<div id="formReservaE" class="text ui-widget-content ui-corner-all" style="width:420px; height:auto; font-size:12px; margin-bottom:10px;">
  <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CREAR NUEVA RESERVA</div>
          
    <table style="margin-left:15px; margin-bottom:10px;">
       
        <tr>
        	<td><label for="titulo">Codigo Asignatura:</label></td>
            <td><input type="text"  id="codasig" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td> 
        </tr>
       
        <tr>
        	<td><label for="titulo">Grupo:</label></td>
            <td><input type="text"  id="grupo" size="5" title="Presione enter para traer el nombre de la asignatura" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
        
        <tr>
        	<td><label for="titulo">Nombre asignatura:</label></td>
            <td><input type="text"  id="nomasig" size="45" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
       
        </table>
        
       </div> 
       
       
       <div id="horario" class="text ui-widget-content ui-corner-all" style="width:420px; height:auto; font-size:12px; margin-bottom:10px;">
         <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">HORARIO RESERVA</div>
     
     <p><img src="images/add1.png" id="adicionarhorres" title="Adiciona un horario a la reserva" style="padding-right:2px;"/> <img src="images/delete.png" id=      "eliminarhorres" title="Elimina un horario de la reserva" style="padding-right:3px;"/></p>
     
     
    
    <table id="horarioasigreserva" style="margin-left:15px;">
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
   </div>   
   
   
   <div id="formrecursos" class="text ui-widget-content ui-corner-all" style="width:540px; height:auto; font-size:12px; margin-bottom:10px;">
         <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">RECURSOS RESERVADOS</div>
     
     <p><img src="images/add1.png" id="adicionarrecurso" title="Adiciona un recurso a la reserva" style="padding-right:2px;"/> <img src="images/delete.png" id=      "eliminar" title="Elimina un recurso de la reserva" style="padding-right:3px;"/></p>
     
     
    
    <table id="reservarecursos" style="margin-left:15px;">
    <thead>
         <th></th>    
    	<th>Grupo</th>
        <th>Subgrupo</th>
        <th>Cantidad</th>
        <th>Software</th>
    </thead>   
  </table>
   </div>  
   
   <table>
   <tr><td><button id="reservasem"  style="font-size:11px; margin-top:5px;" >Reserva Semestral</button></td><td><button id="reservaeve"  style="font-size:11px; margin-top:5px;" >Reserva Eventual</button></td><td><button type="button" id="writemail"  style="font-size:11px; margin-top:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Escribir correo</button></td></tr>
   
   </table>
   
   
   <!-- Formulario adicional de reserva eventual -->
 
 
  <div id="datosadicreservaeventual" class="text ui-widget-content ui-corner-all" style="width:430px; height:auto; font-size:12px; margin-bottom:10px; margin-top:10px;"><div style="float:right" id="closedataadicres" title="Cerrar ventana"><img src="images/close1.png"/></div>
     <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">DATOS ADICIONALES RESERVA EVENTUAL</div>  
     
   <table style="margin-left:15px;">
   
    <tr>
        	<td><label for="titulo">Codigo Responsable:</label></td>
            <td><input type="text"  id="codresp" size="20" title="Presione enter para traer el nombre del responsable" class="text ui-widget-content ui-corner-all height font12"/></td>    
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
        	<td><label >Reservar internet:</label></td>
            <td><input type="checkbox" id="internet" style="padding-left:7px;" value="No"/></td>    
        </tr> 
        </table> 
        
     <table  style="margin-left:15px;">
      <tr>
        <td><button type="button" id="confirmreseventual"  style="font-size:11px; margin-top:5px;"><img src="images/aceptar.png" style="vertical-align:middle;           padding-right:4px;"/>Confirmar Reserva</button></td>
       </tr>
    </table> 
         
    </div>    
        
    <!-- <table  style="margin-left:15px;">
      <tr>
        <td><button type="button" id="enviar"  style="font-size:11px; margin-top:5px;"><img src="images/aceptar.png" style="vertical-align:middle;           padding-right:4px;"/>Crear Reserva</button></td>
    
     </tr>
     
    </table> -->
  
  
      <div id="formcorreo" class="text ui-widget-content ui-corner-all" style="width:420px; height:auto; font-size:12px; margin-bottom:10px; margin-top:10px;">
         <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">ENVIAR CORREO ELECTRONICO</div>
         
        <table style="margin-left:15px; margin-bottom:10px;">
       
        <tr>
        	<td><label>Para:</label></td>
            <td><input type="text"  id="para" size="45"  class="text ui-widget-content ui-corner-all height font12" /></td> 
        </tr>
       
        <tr>
        	<td><label>Asunto:</label></td>
            <td><input type="text"  id="asunto" size="45" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
        
        <tr>
        	<td><label for="titulo">Nombre responsable:</label></td>
            <td><input type="text"  id="nomresp1" size="45" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
        
        </table>
        
        <table style="margin-left:15px; margin-bottom:10px;">
        
        <tr>
           <td><textarea id="textmail" rows="10" cols="50"  class="text ui-widget-content ui-corner-all"></textarea></td>    
        </tr>
        
        </table> 
        
        <table style="margin-left:15px; margin-bottom:10px;">
        
        <tr>
           <td><button type="button" id="sendemailuser"  style="font-size:11px; margin-top:5px;"><img src="images/email.png" style="vertical-align:middle;        padding-right:4px;"/>Enviar email</button></td>    
        </tr>
        
        </table> 
         
         
     </div>
  
  
   <div id="confirmation_email"><p style="font-size:11px;"><img src="images/inform.png" style="float:left; padding:5px;"/><!--¿LA RESERVA HA SIDO CREADA SATISFACTORIAMENTE, DESEA ENVIAR UN CORREO AL USUARIO INFORMANDOLE DE LA CREACIÓN DE LA RESERVA?--></p></div> 
	<div id="alertas"></div>

    
</body>
</html>
<?php
mysql_free_result($JRSalas);
?>
