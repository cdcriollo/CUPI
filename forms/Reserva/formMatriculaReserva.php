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
$query_JRGrupo = "SELECT * FROM grupo";
$JRGrupo = mysql_query($query_JRGrupo, $conexion) or die(mysql_error());
$row_JRGrupo = mysql_fetch_assoc($JRGrupo);
$totalRows_JRGrupo = mysql_num_rows($JRGrupo);

$stylerow='style="color:#0C3; font-size:14px;"';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>



<script type="text/javascript">

$(function (){
     
    $("#matsala7").hide();
	$("#matsala7Asig").hide();
	$("#tabs").tabs();
	$(".tableUI").styleTable();
	$('#codasig').attr('disabled','disabled');
	$('#grupo').attr('disabled','disabled');
	$('#nomusu').attr('disabled','disabled');
	$('#nomasig').attr('disabled','disabled');
	$('#coduser').attr('disabled','disabled');
	$("#mensaje").hide();
	$("#mensajeUser").hide();
	$("#mensajeAsigSala7").hide();
	$("#mensajeUserSala7").hide();
	$("#MatriculaUsuarioSala7").hide();
	$("#MatriculaAsignaturaSala7").hide();
	$("#tablaselfranja").hide();
	$("#TablaSelfranjauser").hide();
	$("#selectreserva").hide();
	$("#labelreserva").hide();
	
	
	var cadena= new Array();
	//var cadenaA=new Array(); 
	var arraysalas= new Array();
	var cadenahorariomatricula= new Array();
	var arraypcs=new Array();
	var descripcionesHorario=new Array();
	var descripcionesHorarioUsuario=new Array();
	var horarioSala7Asig=new Array();
	var HorarioSala7User= new Array();
	var asignacionAutomatica=1;
	var docente=0;
	var docenteU=0;
	var EstudiantesMat=0;
	var pcs=0;
	var matriculafranjas=0;
	var i=0;
	var CompDocenteAsig=0;


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
		
		function limpiarmatriculausuario()
		{
		  $("#codusu").val("");	
		  $("#nomusu").val("");	
		  $("#codasig").val("");	
		  $("#grupo").val("");
		  $("#Noestmat").val("");
		  $("#CSalaUser").val("");	
		}
		
		function limpiarmatriculaasignatura()
		{
		  $("#codasignatura").val("");	
		  $("#grupo1").val("");	
		  $("#nomasig").val("");	
		  $("#coduser").val("");	
		}
		
		
		//Caputuro el evento click del checkbox Selfranja
       $("#Selfranja").click(function(){
		  //Obtengo el estado del checkbox Selfranja
         var bolDisabled = this.checked;
		 $(".franjahoraria").each(function(){
         //para cada uno de los checkbox restantes
         //le asigno el estado del checkbox Selfranja
          this.checked = bolDisabled;
        });
      });	
	  
	  
	  //Caputuro el evento click del checkbox Selfranjauser
       $("#Selfranjauser").click(function(){
		 //Obtengo el estado del checkbox Selfranjauser
         var bolDisabled = this.checked;
         $(".franjahorariauser").each(function(){
         //para cada uno de los checkbox restantes
         //le asigno el estado del checkbox Selfranjauser
          this.checked = bolDisabled;
        });
      });
	  		
		
	function verificarMatricula(reserva,Asignatura,Sala,grupo,docente,usuario,opcion)
	{
		
		
		$.ajax({
			
				 type:'POST',
				 dataType:'json',
				 url:'consultas/Matricula/existenciamatriculaU.php',
				 data: 'asignatura='+Asignatura+'&usuario='+usuario+'&grupo='+grupo+'&reserva='+reserva,
				 success: function(datos){
			
		     if (datos.error==0)
			 {
			    if(opcion==1)
				{
					$("#codasig").val("");
					$("#grupo").val("");
					$("#codasig").focus();
					alertas("El usuario ya tiene matriculada esta Asignatura con este grupo Y No de reserva","Matricula Nueva Usuario","error");	
				}
				else if(opcion==2)
				{
					$("#coduser").val("");
				    $("#coduser").focus();
				    alertas("El usuario ya tiene matriculada esta Asignatura con este grupo y No de reserva","Matricula Nueva Asignatura","error");	
				}
			
		    }
			else if(datos.error==2)
			{
				alertas("Se produjo un error al enviar los datos al servidor","Matricula Nueva","error");	
			}
			else if(datos.error==1){
				
				  verificarcrucehorario(reserva,usuario,Asignatura,grupo,Sala,docente,opcion); 
			}
		}
		
	  });
	
	}
	
	
	
	
	function verificarMatriculafranja(reserva,Asignatura,grupo,nombre,usuario,computador,horario)
	{
		
		$.ajax({
			
				 type:'POST',
				 dataType:'json',
				 url:'consultas/Matricula/existenciamatriculaU.php',
				 data: 'asignatura='+Asignatura+'&usuario='+usuario+'&grupo='+grupo+'&reserva='+reserva,
				 success: function(datos){
			
		       if (datos.error==0)
			   {
			
				$("#codfranja").val("");
				$("#grupofranja").val("");
				$("#codfranja").focus();
				alertas("El usuario ya tiene matriculada esta Asignatura con este grupo","Matricula Usuario Sala 7","error");	
			
		     }
			 else if(datos.error==1)
			 {
		        insertarAsignaturaUsuario(reserva,Asignatura,grupo,computador,horario,usuario,3);   	
			 }
		}
		
	  });
	
	}
	
	
	function verificarMatriculaFranjaAsig(reserva,codigousuario,nombre,codigoAsig,grupo,computador,horario)
	{
		
		$.ajax({
			
				 type:'POST',
				 dataType:'json',
				 url:'consultas/Matricula/existenciamatriculaU.php',
				 data: 'asignatura='+codigoAsig+'&usuario='+codigousuario+'&grupo='+grupo+'&reserva='+reserva,
				 success: function(datos){
			
		     if (datos.error==0)
			 {
			
				$("#codfranjaAsig").val("");
				$("#codfranjaAsig").focus();
				alertas("El usuario ya tiene matriculada esta Asignatura con este grupo","Matricula Usuario","error");	
			
		    }
			else if(datos.error==1)
			{
				 insertarAsignaturaUsuario(reserva,codigoAsig,grupo,computador,horario,codigousuario,4);
			   
			}
		}
		
	  });
	
	}
	

   function consultarAsignaturaGrupo(reserva,asignaturas,grupo,docente,usuario,opcion){
	
	
	  
	  var options = {
				  
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codasig",
					  validations:{
						 
					   required:[true,"El campo Codigo Asignatura  no puede estar vacio"],
				      
						 
				      }
				  },
				  
				  
				  {
					  id:"grupo",
					  validations:{
						 
					   required:[true,"El campo grupo no puede estar vacio."],
				       number:[true,"El campo grupo debe contener numeros."]
						 
				      }
				  },
				  
				  {
					  id:"codusu",
					  validations:{
						 
					   required:[true,"El campo codigo no puede estar vacio."],
				       number:[true,"El campo codigo debe contener numeros."]
						 
				      }
				  }
				
				  ],
				  				  
			beforeValidation:function(){
	
	       $.ajax({
					type:'POST',
					dataType:"json",
					url: 'consultas/Matricula/consultarAGHorario.php',
					data:'codigo='+asignaturas+'&grupo='+grupo,
					success: function(datos){
						
					 if (datos.error==0)
					 {
						 sala= $("#idSalas").val();
						 verificarMatricula(reserva,asignaturas,sala,grupo,docente,usuario,opcion); 
			         }
					 else if(datos.error==1)
					 {
					   alertas("Por favor verifique que la asignatura existe o el grupo exista","Matricula Asignatura","error"); 			
							
					 }
						
				  }
	});
	
	  }
	 };
	  $.validation(options);   
}

 
 
 function consultarAsignaturaGrupofranja(reserva,asignatura,grupo,usuario,computador,horario)
 {
	
	
	       $.ajax({
					type:'POST',
					dataType:"json",
					url: 'consultas/Matricula/consultarAGHorario.php',
					data:'codigo='+asignatura+'&grupo='+grupo,
					success: function(datos)
					{
					   NomAsignatura=datos;	
						
					 if (datos!=0)
					 {
						 verificarMatriculafranja(reserva,asignatura,grupo,NomAsignatura,usuario,computador,horario);  
			          }
					  else
					  {
						 alertas("Por favor verifique que la asignatura existe o el grupo exista","Matricula Asignatura","error"); 				
					  }
						
				  }
	       });
 }



  function obtenerSalas(asignatura,grupo,reserva,opcion)
  {

     $.ajax({

			type:'POST',
			url: 'consultas/Matricula/obtenerSalas.php',
			data:'codigo='+asignatura+'&grupo='+grupo+'&reserva='+reserva,
			success: function(datos){
				
				if(datos!=0)
				{
			        
					var arraysalas=datos.split(',');
					sala=arraysalas[0];
					var filas=arraysalas.length; 
					llenarCombo(arraysalas,filas,opcion);
			  }
			}
         });
	   

}

function  llenarCombo(array,filas,opcion){
	
 if(opcion==1){
	$('select.Salas option').remove(); 
 }
 else if(opcion==2){
	 
	 $('select.Salas1 option').remove();
 }
 else if(opcion==3)
 {
	 $('select.salauser1 option').remove(); 
 }
 else if(opcion==4)
 {
	$('select.sala7asig option').remove();  
 }


 for(i=0; i<filas; i++){
    var valor= array[i];
	if(opcion==1){
     $('#idSalas').append('<option value="'+valor+'" selected="selected" >'+valor+'</option>');
	   if(filas==1)
	   {
	     NoSalauser=$("#idSalas option:selected").val();
		 CapacidadSala(NoSalauser,1);
	   }
		
	}
	else if(opcion==2){
		$('#Salas1').append('<option value="'+valor+'" selected="selected" >'+valor+'</option>');
		if(filas==1)
	   {
		 NoSala=$("#Salas1 option:selected").val();
		 CapacidadSala(NoSala,2);
	   }
		
	}
	else if(opcion==3)
	{
	    $('#salauser7').append('<option value="'+valor+'" selected="selected" >'+valor+'</option>');
		if(filas==1)
	   {
		 NoSala7User=$("#salauser7 option:selected").val();
		 TraerComputadorSala7(1,NoSala7User) 
		 CapacidadSala(NoSala7User,1);
		 
	   }	 
	}
	else if(opcion==4)
	{
	    $('#sala7asig').append('<option value="'+valor+'" selected="selected" >'+valor+'</option>');
		if(filas==1)
	   {
		 NoSala7=$("#sala7asig option:selected").val();
		 TraerComputadorSala7(2,NoSala7) 
		 CapacidadSala(NoSala7,3);
		 
	   }	 
	}
   }// cierro for
}// cierro funcion


    function consultarNombre(reserva,codigo,asignatura, docente,grupo,opcion){
	
	
	   var options = {
				  
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"coduser",
					  validations:{
						 
						  required:[true,"El campo Codigo Usuario no puede estar vacio."],
						  number:[true,"El campo Codigo Usuario debe contener numeros ."]
						 
						  }
				  },
				  
				  {
					  id:"codasignatura",
					  validations:{
						 
						  required:[true,"El campo Codigo no puede estar vacio."],
						 
						  }
				  },
				  
				  {
					  id:"grupo1",
					  validations:{
						 
						  required:[true,"El campo Grupo no puede estar vacio."],
						  number:[true,"El campo Grupo debe contener numeros ."]
						 
						  }
				  }
				  
				  ],
				  				  
			beforeValidation:function(){
	
	
	           $.ajax({
					type:'POST',
					dataType:'json',
					url: 'consultas/Usuario/consultarUsuario.php',
					data:'codigo='+codigo,
					success: function(datos){
						
					 if (datos.error==0)
					 {
						 nombre= datos.nombre;
						 salaA=$("#Salas1").val();
						 verificarMatricula(reserva,asignatura,salaA,grupo,docente,codigo,opcion);
			          }
					  else if(datos.error==1)
					  {
						 alertas("El usuario no existe","Matricula Nueva Asignatura","error"); 		
					  }
						
				   }
	             });
	           }
	         };
	         $.validation(options);   
           }
		   
		   
		   function consultarNombreFranja(reserva,codigoUsuario,codigoAsignatura,grupo,computador,horario)
		   {
	
	           $.ajax({
				   
					type:'POST',
					dataType:'json',
					url: 'consultas/Usuario/consultarUsuario.php',
					data:'codigo='+codigoUsuario,
					success: function(datos){
						
					 if (datos.error==0)
					 {
						 nomUsuario= datos.nombre;
						 verificarMatriculaFranjaAsig(reserva,codigoUsuario,nomUsuario,codigoAsignatura,grupo,computador,horario);
			          }
					  else if(datos.error==0)
					  {
						 alertas("El usuario no existe","Matricula Asignatura","error"); 		
					  }
						
				   }
	             });
           }
   

   
   function consultarcomputador(reserva,NoSala,asignatura,grupo,Docente,usuario,opcion)
   {
	 
	if (Docente==0)
	{
		
		$.ajax({
			
	      type:'POST',
		  dataType:'json',
		  url: 'consultas/Matricula/AsignarPcUsuario.php',
		  data:'Sala='+NoSala+'&Asignatura='+asignatura+'&Grupo='+grupo+'&reserva='+reserva,
		  success: function(datos)
		  {
			  
			 if(datos.error==1)
			 {
			   alertas("Ya no hay computadores para asignar en esta sala, por favor escoja otra sala si la hay","Matricula Nueva","warning");
			 }
			 else if(datos.error==2)
			 {
				alertas("No hay computadores para asignar se asignara un computador vacio intente nuevamente matricular al usuario","Matricula Nueva","warning");
			  
			 }
				
			 else if(datos.error==0)
			 {	
			    
				PcUser=datos.pc;
				
				$.ajax({

					type:'POST',
					url: 'consultas/Matricula/obtenerIdhorario.php',
					data:'asignatura='+asignatura+'&grupo='+grupo+'&sala='+NoSala+'&reserva='+reserva,
					success: function(datos)
					{
					  CodigohorarioU=datos.split(',');
					  insertarAsignaturaUsuario(reserva,asignatura,grupo,PcUser,CodigohorarioU,usuario,opcion)
					 
					}
				});
			 }
			}// cierro success
		  });// cierro ajax   
		
	}
	else if(Docente==1)
	{
		asignarpcdocenteusuario(reserva,asignatura,grupo,NoSala,usuario,opcion);
		
     }// cierro else
	 			 
  }// cierra function


	  
	function insertarAsignaturaUsuario(reserva,Asignatura,Grupo,datopc,Horario,usuario,opcion)
	{
		 
		$.ajax({
		 type:'POST',
		 dataType:'json',
		 url: 'funciones/Matricula/insertarMatricula1.php?pc='+datopc,
		 data:'codigoA='+Asignatura+'&codigoU='+usuario+'&grupo='+Grupo+'&horarioU='+Horario+'&reserva='+reserva,
		 success: function(datos)
		 {
			
			if(datos.error==1)
			{
			   if(opcion==1)
			   {
			     MostrarMatriculaUsuario(reserva,usuario,1);
				 $("#mensajeUser").show();
				 $("#codasig").val("");
				 $("#grupo").val("");
				 $("#codasig").focus();
				 NoEstMatriculados(reserva,Asignatura,Grupo,1);
			   }
			   else if(opcion==2)
			   {
				   MostrarMatriculaAsignatura(reserva,Asignatura,Grupo,1)
				   $("#mensaje").show();
				   $("#coduser").focus(); 
				   $("#coduser").val("");
				   NoEstMatriculados(reserva,Asignatura,Grupo,2); 
			   }
			   
			   else if(opcion==3)
			   {
				   $("#mensajeUserSala7").show();
				   Sala7User=$("#salauser7").val();
				   TraerComputadorSala7(1,Sala7User); 
				   MostrarMatriculaUsuario(reserva,usuario,2);
				   NoEstMatriculados(reserva,Asignatura,Grupo,1);  
				   $("#codfranja").val("");
				   $("#grupofranja").val("");
				   $("#pcsala7").val("");
				   $("#codfranja").focus();
			  }
			   
			   else if (opcion==4)
			   {
				   $("#mensajeAsigSala7").show();
				   Sala7Asig=$("#sala7asig").val();
				   TraerComputadorSala7(2,Sala7Asig); 
				   MostrarMatriculaAsignatura(reserva,Asignatura,Grupo,2)
				   NoEstMatriculados(reserva,Asignatura,Grupo,2); 
				   $("#codfranjaAsig").val(""); 
				   $("#pcsala7Asig").val("");
				   $("#codfranjaAsig").focus(); 
				   
			   }
			    
			} 
			else if(datos.error==0)
			{
			  alertas("El usuario no fue matriculado con exito", "Matricula Nueva","error"); 
			}
		 }
		});	
	}// cierro función
		  
		  
		 function AsignarComputadorFranja(Asignatura,grupo,nombre,usuario,computador,horario)
		 {
			 TamañoHorarioUser=horario.length;
			 
			  for(var i=0; i< TamañoHorarioUser; i++)
			  {
				DatosSala7User=horario[i].split("-");
				HorarioUser=DatosSala7User[0];
				SalaUser=DatosSala7User[1];
				 
				$('#detallematriculas').append('<tbody><td class="ui-widget-content"><input type="checkbox"/></td><td class="matricula ui-widget-content">'+ Asignatura+'</td><td                class="matricula ui-widget-content first">'+grupo+'</td><td class="ui-widget-content first">'+nombre+'</td><td class=" matricula ui-widget-content first">'+computador+'</td><td class=" ui-widget-content first">' +SalaUser+'</td><td class="matricula ui-widget-content first">'+HorarioUser+'</td></tbody>'); 
			 }
			 
			 $("#codfranja").val("");
			 $("#grupofranja").val("");
			 $("#pcsala7").val("");
			 $("#codfranja").focus();
		 }
		 
 	
		
	function buscarusuario()
	{	
		var options = {
				  //defaultMsg:"Todos los campos son requeridos.",
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codusu",
					  validations:{
						 
						   required:[true,"El campo Codigo usuario no puede estar vacio."],
						   number:[true,"El campo codigo usuario debe contener numeros."]
						 
						  }
				  }
				
				  ],
				  				  
			beforeValidation:function(){
		
		      codigo=$('#codusu').val();
		
		      $.ajax({
				  
					type:'POST',
					dataType:'json',
					url: 'consultas/Usuario/consultarUsuario.php',
					data:'codigo='+codigo,
					success: function(datos){
						 if(datos.error==0)
						 {
						       var nombre= datos.nombre;
							   var apellidos= datos.apellidos;
							   var usuario=nombre+" "+apellidos;
						       $('#nomusu').val(usuario);
							   $("#codasig").attr('disabled','');
							   $("#grupo").attr('disabled','');
							   $("#nomusu").attr("disabled", "");
					    }
					 
					 else if(datos.error==1)
					 {
						
						 alertas("El usuario no existe","Matricula Usuario","error"); 	
					 }
			    }
		
			});
			
	     }
			};
			 $.validation(options);  
	}
		
		
	$("#codusu").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') {
	  
	     event.preventDefault();
	     buscarusuario();
		 
	   } 
	
	});	
	
	$("#grupo1").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  buscarAsignatura();
	});

		
	$("#coduser").keydown(function(event) {
	  //Ejecuta una accion al dar enter
	  if (event.keyCode == '13') 
	  {
	     event.preventDefault();
		 
		   if($(".checkboxreservaasig").is(":checked"))
		   {	
			  var contadorreserva=0; 
						  
				$("input:checked.checkboxreservaasig").each( 
				function(i) { 
				  contadorreserva+=1;
				});
						
			  if(contadorreserva==1)
			  { 
				 codigouser=$('#coduser').val();
				 codigoasignatura=$('#codasignatura').val();
				 grupoAsig=$("#grupo1").val();
				 valor=$("#detallereservasasig").find("input:checked").parents("tr");
				 reserva= valor.find("td").eq(0).text();
				 $("#mensaje").hide();
				 consultarNombre(reserva,codigouser,codigoasignatura,docente,grupoAsig,2); 
			  }
		   }
		   else
		   {
			  alertas("Por favor seleccione una reserva para empezar a matricular al usuario","Matricula Asignatura","error"); 
		   }
	  } 
	
	});	
	
	
	// funcion que verifica si se presenta cruce de horarios entre asignaturas
	function verificarcrucehorario(reserva,usuario,asignatura,grupo,NoSala,docente,opcion)
     {
		
         $.ajax({
			
			    type:'POST',
				dataType:'json',
			    url: 'consultas/Matricula/crucehorariosasignatura.php',
			    data:'usuario='+usuario+'&asignatura='+asignatura+'&grupo='+grupo+'&reserva='+reserva,
			    success: function(datos)
				{
				 
				 if(datos.error==1)
				 {
					mensaje="Asignatura:"+" "+datos.asignatura+" "+"Grupo:"+" "+datos.grupo+" "+"Dia:"+" "+datos.diasemana+" "+"Hora Inicio:"+" "+datos.                    horainicio+" "+"Hora Final:"+" "+datos.horafinal+" "+"Sala:"+" "+datos.sala+" "+"Fecha inicio:"+" "+datos.fechainicio+" "+"Fecha final:"+                    " "+datos.fechafinal;
					
					if(opcion==1)
					   {
						   alertas("Se presenta cruce de horario(s) con la(s) siguiente(s) asignatura(s):"+mensaje+"","Matricula Nueva Usuario","warning"); 
						   $("#codasig").val("");
						   $("#grupo").val("");
						   $("#codasig").focus();
					   }
					   else if(opcion==2)
					   {
						  alertas("Se presenta cruce de horario(s) con la(s) siguiente(s) asignatura(s):"+mensaje+"","Matricula Nueva Asignatura","warning"); 
					      $("#coduser").val("");
				          $("#coduser").focus();     
					   } 
				 }
				 
				
				 
				 else if(datos.error==0)
				 {
					consultarcomputador(reserva,NoSala,asignatura,grupo,docente,usuario,opcion);
				 }// cierro else
				  
			  }// cierro success
		    });// cierro ajax

        }// cierro funcion
		  

		$('#adicusu').click(function() {
		   
		   if($(".checkboxreservauser").is(":checked"))
		   {	
			  var contadorreserva=0; 
						  
				$("input:checked.checkboxreservauser").each( 
				  function(i) { 
				  contadorreserva+=1;
				});
						
			   if(contadorreserva==1)
			   {  
					codigoU=$('#codusu').val();
					asignaturas=$('#codasig').val();
					grupo=$('#grupo').val();
					codUsuario=$("#codusu").val();
					$("#mensajeUser").hide();
					valor=$("#detallereservasuser").find("input:checked").parents("tr");
				    reservauser= valor.find("td").eq(0).text();
					consultarAsignaturaGrupo(reservauser,asignaturas,grupo,docenteU,codUsuario,1);
			   }
		   }
		   else
		   {
			 alertas("Por favor seleccione una reserva para empezar a matricular una asignatura al usuario","Matricula Usuario","error");  
		   }
		
         });// cierro el click function
		 
		 
		 
		 $('#Adicusumat').click(function() {
  		    codigouser=$('#coduser').val();
			codigoasignatura=$('#codasignatura').val();
			grupo=$('#grupo1').val();
			$("#mensaje").hide();
		    consultarNombre(codigouser,codigoasignatura,asignacionAutomatica,docente,grupo,2); 
         });// cierro el click function
		 
		 
	
		function AsignarPcManualUsuario(NoSala,asignatura,grupo,docente,usuario,opcion)
		{
				pc=0;	
				 
				  $.ajax({

					type:'POST',
					url: 'consultas/Matricula/obtenerIdhorario.php',
					data:'asignatura='+asignatura+'&grupo='+grupo+'&sala='+NoSala,
					success: function(datos)
					{
			           CodigohorarioPcManualUsuario=datos.split(',');
					   insertarAsignaturaUsuario(asignatura,grupo,pc,CodigohorarioPcManualUsuario,usuario,opcion)
					   
					   if(opcion==1)
					   {
						 $("#codasig").val("");
					     $("#grupo").val(""); 
						 $("#codasig").focus(); 
					   }
					   else if (opcion==2)
					   {
						  $("#coduser").val("");
						  $("#coduser").focus();
					  
					   }
					 
				  }// cierro success
                });// cierro ajax
		}// cierro funcion
		
		
		// Evento que asigna un computador a un docente
		$("#teacher").click(function(){
			
			 codigoU=$('#codusu').val();
		     asignatura=$("#codasig").val();
		     grupo=$('#grupo').val();
			 TeacherUser=$("#codusu").val();
			 valor=$("#detallereservasuser").find("input:checked").parents("tr");
		     reservauser= valor.find("td").eq(0).text();
			 docenteU=1;
		     consultarAsignaturaGrupo(reservauser,asignatura,grupo, docenteU,TeacherUser,1);
		});
		
		
		function asignarpcdocenteusuario(reserva,asignatura,grupo,NoSala,usuario,opcion)
		{
			
				// obtengo el computador que se le asignara al docente
				 $.ajax({
	
					type:'POST',
					url: 'consultas/Matricula/AsignarPcDocente.php',
					data:'sala='+NoSala,
					success: function(datos)
					{
						
					if(datos!=0)
					{	
						PcDocenteUser=datos;
						
						$.ajax({

							type:'POST',
							url: 'consultas/Matricula/obtenerIdhorario.php',
							data:'asignatura='+asignatura+'&grupo='+grupo+'&sala='+NoSala+'&reserva='+reserva,
							success: function(datos)
							{
							
								CodigohorarioDUsuario=datos.split(',');
								insertarAsignaturaUsuario(reserva,asignatura,grupo,PcDocenteUser,CodigohorarioDUsuario,usuario,opcion)
								 
								 if(opcion==1)
								 {
									$("#codasig").val("");
									$("#grupo").val("");
									$("#codasig").focus();
									docenteU=0;	 
								 }
								 else if(opcion==2)
								 {
								   $("#coduser").val("");
								   $("#coduser").focus();
								   docente=0;
								 }
					  
					     }// cierro success
			           });// cierro ajax  
					}
					else
					{
					  alertas("La sala no tiene asignado un computador para el docente","Matricula Nueva","error");
					  if(opcion==1)
					  {
						 docenteU=0;	 
					  }
					  
					 else if(opcion==2)
					 {
					   docente=0;
					  }
					  	
					}
				   }
				 });
		     }  
			  
			  $("#teacherAsignatura").click(function(){
				  
				 codigouserT=$('#coduser').val();
				 codigoasignaturaT=$('#codasignatura').val();
				 GrupoA=$("#grupo1").val();
				 valor=$("#detallereservasasig").find("input:checked").parents("tr");
				 reserva= valor.find("td").eq(0).text();
				 docente=1;
				 consultarNombre(reserva,codigouserT,codigoasignaturaT,docente,GrupoA,2);  
				  
			  });
				
			
		 function buscarAsignatura()
		 {	 
			 
			 var options = {
				
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codasignatura",
					  validations:{
						 
						  required:[true,"El campo Codigo Asignatura no puede estar vacio."],
						 
						  }
				  }
				  ,
				  {
					  id:"grupo1",
					       validations:{
					         required:[true,"El campo grupo no puede estar vacio."],
						     number:[true,"El campo Grupo debe contener numeros."]
						   }				  
				  }
				  
				  ],
				  				  
			beforeValidation:function(){
			 
  		    codigoA=$('#codasignatura').val();
			grupo=$('#grupo1').val();
		
			
		
		    $.ajax({
					type:'POST',
					dataType:'json',
					url: 'consultas/Matricula/ConsultarAGHorario.php',
					data:'codigo='+codigoA+'&grupo='+grupo,
					success: function(datos)
					{
						 if(datos.error==0)
						 {
							 nombreA=datos.nombre;
						     $('#nomasig').val(nombreA);
							 $("#nomasig").attr("disabled", "");
                             $("#coduser").attr("disabled", "");
							 //llenarselectreservas(codigoA,grupo,2,2);	   
					    }
					 
					 else if(datos.error==1)
					 {
					   alertas("Por favor verifique que la asignatura existe o el grupo existe o que la asignatura tenga una programación","Matricula Asignatura","error"); 	
					 }
			    }
		
			});
		  }
		};
		 $.validation(options);   
	 }
	 
	 
	 function  llenarselectreservas(codigo,grupo,opcion,clase)
	 {
		 
		    $.ajax({
			
			    type:'POST',
				dataType:'json',
			    url: 'consultas/Matricula/verificarreserva.php',
			    data:'asignatura='+codigo+'&grupo='+grupo,
			    success: function(datos)
				{
				     if(datos.error==0)
					 {
						 $.ajax({
					      type:'POST',
						  dataType:'html',
						  url: 'consultas/matricula/obtenerSelectReservas.php',
						  data:'codigo='+codigo+'&grupo='+grupo+'&clase='+clase,
						  success: function(datos)
						  {
							  if(datos)
							  {
								 if(opcion==1) 
								 {
									$("#detallereservasuser").html(datos);
									$("#detallereservasuser").show();
									 
							     }
								else if(opcion==2) 
								{
								  $("#detallereservasasig").html(datos);
								  $("#detallereservasasig").show();
								}
								else if(opcion==3) 
								{
								  $("#selectreservasala7user").html(datos); 
								   reserva=$("#RUserSala7").val();
								   TraerFranjaHoraria(1);
								   obtenerSalas(codigo,grupo,reserva,3);   
								}
							   
					         }
					        }
			             }); 
					   }
					   else if(datos.error==1)
					   {
						 alertas("La asignatura no tiene reservas en el piso","Matriculas","error"); 	    
					   }
				 
				    }
		         });       
	           }
	  
	 
	 function MostrarMatriculaAsignatura(reserva,codigoA,grupoA, opcion)
	 {
		
		$.ajax({
			
			type:'POST',
			url: 'consultas/Matricula/consultarmatriculaA.php',
			data:'codigo='+codigoA+'&grupo='+grupoA+'&reserva='+reserva,
			success: function(datos)
			{
				
				if(datos)
				{
				  if(opcion==1)
				  {	 
				    $("#tabladinamica1").html(datos);
				  }
				  else if(opcion==2)
				  {
					$("#matriculasala7").html(datos);
				  }
			   }
		   }
        });
	 }
	 
	 function MostrarMatriculaUsuario(reserva,usuario,opcion)
	 {
		
		$.ajax({
			
			type:'POST',
			url: 'consultas/Matricula/consultarmatricula1.php',
			data:'codigo='+usuario+'&opcion='+1,
			success: function(datos)
			{
				
				if(datos)
				{ 
				   if(opcion==1)
				   {
				     $("#tabladinamica").html(datos);
				   }
				   else if(opcion==2)
				   {
					  $("#matriculasalauser7").html(datos)  
				   }
			   }
		   }
        });
	 }
      
			
	 
	 $("#grupo1").blur(function(){
		 
		 var options = {
				
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codasignatura",
					  validations:{
						 
						   required:[true,"El campo Codigo Asignatura no puede estar vacio."]
						   
						 
						  }
				  },
				  
				  {
					  id:"grupo1",
					  validations:{
						 
						   required:[true,"El campo Grupo no puede estar vacio."],
						   number:[true,"El campo Grupo debe contener numeros."]
						 
						  }
				  }
				
				  ],
				  				  
			beforeValidation:function()
			{
				materia= $("#codasignatura").val();
				grupo=$("#grupo1").val();
				clase="checkboxreservaasig";
				llenarselectreservas(materia,grupo,2,clase);	
		  }
		 };
		 $.validation(options);  
		 
	 });
	 
	 $("#grupo").blur(function(){
		 
		 var options = {
				
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codasig",
					  validations:{
						 
						   required:[true,"El campo Codigo Asignatura no puede estar vacio."]
						   
						 
						  }
				  },
				  
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
				asignatura= $("#codasig").val();
				grupouser=$("#grupo").val();
				clase="checkboxreservauser";
				llenarselectreservas(asignatura,grupouser,1,clase);	
		  }
		 };
		 $.validation(options);  
		 
	 });
	 
	 
	 $("#grupofranja").blur(function(){
		 
		 var options = {
				
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codfranja",
					  validations:{
						 
						   required:[true,"El campo Codigo Asignatura no puede estar vacio."]
						   
						 
						  }
				  },
				  
				  {
					  id:"grupofranja",
					  validations:{
						 
						   required:[true,"El campo Grupo no puede estar vacio."],
						   number:[true,"El campo Grupo debe contener numeros."]
						 
						  }
				  }
				
				  ],
				  				  
			beforeValidation:function()
			{
				 TraerFranjaHoraria(1);
		  }
		 };
		 $.validation(options);  
		 
	 });
	 
	 
	
	 function CapacidadSala(NoSala,opcion)
	 {
		 $.ajax({
			type:'POST',
			url: 'consultas/Matricula/CapacidadSala.php',
			data:'sala='+NoSala,
			success: function(datos)
			{ 
				if(opcion==1)
				{
					$("#CSalaUser").val(datos);
				}
				else if(opcion==2)
				{
					$("#CSala").val(datos);
				}
				else if(opcion==3)
				{
					$("#CSala").val(datos);
				}
			}
		 });
						 
	 }
	 
	 
	 function NoEstMatriculados(reserva,asignatura,grupo,opcion)
	 {
		 $.ajax({
			type:'POST',
			dataType:"json",
			url: 'consultas/Matricula/EstudiantesMatriculados.php',
			data:'asignatura='+asignatura+'&grupo='+grupo+'&reserva='+reserva,
			success: function(datos)
			{ 
			  if(opcion==1)
			  {
			   $("#Noestmat").val(datos.Totalmatriculados);
			  }
			  else if (opcion==2)
			  {
				$("#userMat").val(datos.Totalmatriculados);  
			  }
			   
			}
		 });
	 }
	 
	 $("#idSalas").change(function() {
		 
		 NoSalauser=$("#idSalas option:selected").html();
		CapacidadSala(NoSalauser,1); 
	 });
	 
	 
	 
	 $("#Salas1").change(function() {
	      NoSala=$("#Salas1 option:selected").val();
		  CapacidadSala(NoSala,2);
		  Reserva=$("#reservas").val();
		  TraerComputadorSala7(2,NoSala,Reserva)  
	  });


		function TraerFranjaHoraria(opcion) 
		{
		  
		  if(opcion==1)
		  {
			 codigoAsignaturaFranja=$("#codfranja").val();
			 grupoFranjaAsig=$("#grupofranja").val();
			 opcion=1;  
		  }
		 
		 
		  if(opcion==2)
		  {
			codigoAsignaturaFranja=$("#codasignatura").val();
			grupoFranjaAsig=$("#grupo1").val();
			opcion=2;
		  }
		
			
			$.ajax
			({
	
				type:'POST',
				dataType:'html',
				url: 'consultas/Matricula/ObtenerFranja.php',
				data:'codigo='+codigoAsignaturaFranja+'&grupo='+grupoFranjaAsig+'&opcion='+opcion,
				success: function(datos)
				{
				   
				   if(opcion==1)
				   {
					    $("#TablaSelfranjauser").show();
						$(".mostrarhorario").html(datos); 
				   }
				   
				   else if(opcion==2)
				   {	
					 $("#tablaselfranja").show();
					 $(".mostrarhorarioAsig").html(datos);
					 
				   }
				}
			}); 
		}
		
	 
	 $("#SalaMac").toggle(function() {
         
		  $("#matsala7").show("slide");
		  $('#codasig').attr('disabled','disabled');
		  $('#grupo').attr('disabled','disabled');
		  $('#idSalas').attr('disabled','disabled');
		  $('#adiusu').attr('disabled','disabled');
		  $('#teacher').attr('disabled','disabled');
		  $(".hidemenuuser").hide();
		  $("#MatriculaUsuarioSala7").show();
		 
			  
         },function() {
          
		   $("#matsala7").hide("slide");
		   $('#codasig').attr('disabled','');
		   $('#grupo').attr('disabled','');
		   $('#idSalas').attr('disabled','');
		   $('#adiusu').attr('disabled','');
		   $('#teacher').attr('disabled','');
		   $(".hidemenuuser").show();
		   $("#MatriculaUsuarioSala7").hide();
		   
		   
     });
	 
	  $("#SalaMacAsignatura").toggle(function() {
         
		 
		 var options = {
				
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codasignatura",
					  validations:{
						 
						   required:[true,"El campo Codigo Asignatura no puede estar vacio."]
						   
						 
						  }
				  },
				  {
					  id:"grupo1",
					  validations:{
						 
						   required:[true,"El campo Grupo no puede estar vacio."],
						   number:[true,"El campo Grupo debe contener numeros."]
						 
						  }
				  },
				  
				  ],
				  				  
				beforeValidation:function()
				{
					
				   $("#matsala7Asig").show("slide");
				   $('#coduser').attr('disabled','disabled');
				   $(".hidemenuasig").hide();
				   $("#MatriculaAsignaturaSala7").show();
				   $("#detallereservasasig").empty();
				   $("#detallereservasasig").hide();
				   TraerFranjaHoraria(2);
							 
						
				}
			   };
			   $.validation(options); 
			  
			  
				 },function() {
				  
				   $("#matsala7Asig").hide("slide");
				   $('#coduser').attr('disabled','');
				   $(".hidemenuasig").show();
				   $("#MatriculaAsignaturaSala7").hide();
			   });
	 
	 
	 $("#adicionarmatfranja").click(function () 
	 {
		 
		
		
		 var options = {
				
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codfranja",
					  validations:{
						 
						   required:[true,"El campo Codigo Asignatura no puede estar vacio."]
						   
						 
						  }
				  },
				  {
					  id:"grupofranja",
					  validations:{
						 
						   required:[true,"El campo Grupo no puede estar vacio."],
						   number:[true,"El campo Grupo debe contener numeros."]
						 
						  }
				  },
				  
				  {
					  id:"codusu",
					  validations:{
						 
						   required:[true,"El campo Codigo no puede estar vacio."],
						   number:[true,"El campo Codigo debe contener numeros."]
						 
						  }
				  },
				  
				   {
					  id:"pcsala7",
					  validations:{
						 
						   required:[true,"El campo Pc no puede estar vacio."],
						   number:[true,"El campo Pc debe contener numeros."]
						 
						  }
				  }
				  
				  ],
				  				  
				beforeValidation:function()
				{
					codigoUsuariof=$("#codusu").val();
					codasigf=$("#codfranja").val();
					computadorf=$("#pcsala7").val();
					grupof=$("#grupofranja").val();
					valor=$(".mostrarhorario").find("input:checked").parents("tr");
		            reserva= valor.find("td").eq(1).text();
					
				
					 if($(".franjahorariauser").is(":checked"))
                     {
					     HorarioSala7User=[];
						
						$("input:checked.franjahorariauser").each( 
						 
						 function(i) { 
						  valorid=$(this).val();
						  HorarioSala7User[i]=valorid;
						  
					   });
					   
					   
					   NoSeleccionUsu= $(".mostrarhorario input:checked").length;
					 
						if(NoSeleccionUsu > 0)
						 {
						    $("#mensajeUserSala7").hide();
						    consultarAsignaturaGrupofranja(reserva,codasigf,grupof,codigoUsuariof,computadorf,HorarioSala7User)
						 }
						 
				   }
				   else
				   {
					  alertas("Por favor seleccione al menos una franja horaria","Matricula Asignatura Sala 7","warning");  
				   }
			  }
			 };
			 $.validation(options); 
			 
		 
		 
    });
	
	
	$("#adicionarmatfranjaAsig").click(function () {
		 
		  var options = {
				
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codasignatura",
					  validations:{
						 
						   required:[true,"El campo Codigo Asignatura no puede estar vacio."]
						   
						 
						  }
				  },
				  {
					  id:"grupo1",
					  validations:{
						 
						   required:[true,"El campo Grupo no puede estar vacio."],
						   number:[true,"El campo Grupo debe contener numeros."]
						 
						  }
				  },
				  
				  {
					  id:"codfranjaAsig",
					  validations:{
						 
						   required:[true,"El campo Codigo Usuario no puede estar vacio."],
						   number:[true,"El campo Codigo Usuario debe contener numeros."]
						 
						  }
				  },
				  
				   {
					  id:"pcsala7Asig",
					  validations:{
						 
						   required:[true,"El campo Pc no puede estar vacio."],
						   number:[true,"El campo Pc debe contener numeros."]
						 
						  }
				  }
				  
				  ],
				  				  
				beforeValidation:function()
				{

					  if($(".franjahoraria").is(":checked"))
					  {
							horarioSala7Asig=[];
							 
						   $("input:checked.franjahoraria").each( 
								 
							  function(i) { 
							   valoridAsig=$(this).val();
							   horarioSala7Asig[i]=valoridAsig;
								  
							 });
						   
							 NoSeleccion= $(".mostrarhorarioAsig input:checked").length;
							 valor=$(".mostrarhorarioAsig").find("input:checked").parents("tr");
		                     reserva= valor.find("td").eq(1).text();
							 codigousuario=$("#codfranjaAsig").val();
							 asignatura=$("#codasignatura").val();
							 grupo=$("#grupo1").val();
							 pc=$("#pcsala7Asig").val();
							
							 
							 if(NoSeleccion > 0)
							 {
					
							   $("#mensajeAsigSala7").hide();
							   consultarNombreFranja(reserva,codigousuario,asignatura,grupo,pc,horarioSala7Asig);	
							 }
							 
					  }
					  else
					  {
						 alertas("Por favor seleccione al menos una franja horaria","Matricula Asignatura Sala 7","warning");  
					  }
				 }// cierro before validation
				};
			 $.validation(options); 
          });
	

	 
	 $("#finishmatasigsala7").button().click(function() {
		
	   $(".mostrarhorarioAsig").empty();
	   $(".mostrarcompsala7").empty();
	   $("#matriculasala7").empty();
	   $("#codasignatura").val("");
	   $("#grupo1").val("");
	   $("#usermat").val("");
	   $("#nomasig").val("");
	   $("#CSala").val("");
	   $("#userMat").val(""); 
       $("#codfranjaAsig").val("");
	   $("#pcsala7Asig").val("");
	   $("#detallereservasasig").empty();
	   $("#detallereservasasig").hide();
	   $("#matsala7Asig").hide();
	   $(".hidemenuasig").show();
	   $("#codasignatura").focus();
	   $("#mensajeAsigSala7").hide();
	
							 
	 });
	 
	 
	 $("#finishmatusersala7").button().click(function () {
		 
		$(".mostrarhorario").empty();
	    $(".mostrarcompusersala7").empty();
	    $("#matriculasalauser7").empty(); 
		$("#codfranja").val("");
		$("#grupofranja").val("");
		$("#pcsala7").val("");
		$("#codusu").val("");
		$("#Noestmat").val("");
		$("#nomusu").val("");
		$("#CSalaUser").val("");
		$("#matsala7").hide();
		$(".hidemenuuser").show();
		$("#codusu").focus();
		$("#mensajeUserSala7").hide();
		 
		 
    });
	
	
	$("#finishmatasig").button().click(function () {
		
		$("#codasignatura").val("");
		$("#grupo1").val("");
		$("#userMat").val("");
		$("#nomasig").val("");
		$("#CSala").val("");
		$("#tabladinamica1").empty();
		$("#detallereservasasig").empty();
		$("#detallereservasasig").hide();
		$("#codasignatura").focus();
		$("#mensaje").hide();
		
   });
   
   $("#finishmatuser").button().click(function () {
	   
	   $("#codusu").val("");
	   $("#Noestmat").val("");
	   $("#nomusu").val("");
	   $("#CSalaUser").val("");
	   $("#codasig").val("");
	   $("#grupo").val("");
	   $("#tabladinamica").empty();
	   $("#detallereservasuser").empty();
	   $("#detallereservasuser").hide();
	   $("#codusu").focus();
	   $("#mensajeUser").hide();
	   
	   
	   
  });
	 

	 
	  $(".freepc").live("click",function(){
	  
	   
	      if($(this).is(":checked"))
           {	
	         var contador=0; 
			 
			$(".mostrarcompsala7 input:checked").each( 
				function(i) { 
				  valor=$(this).val(); 
				  contador+=1;
				 
			});
			
			
		
				if(contador==1)
				{  
				   $("#pcsala7Asig").val(valor);
				}
				else if(contador > 1)
				{
					alertas("Por favor seleccione un solo computador","Matricula sala 7","warning")
				}
				
		   }
		   else
		   {
			    $("#pcsala7Asig").val("");
		   }
	  
	  
	  });
	  
	  
	  $(".freepcuser").live("click",function(){
	  
	   
	      if($(this).is(":checked"))
           {	
	         var contador=0; 
			 
			$(".mostrarcompusersala7 input:checked").each( 
				function(i) { 
				  valor=$(this).val(); 
				  contador+=1;
				 
			});
			
			
		
				if(contador==1)
				{  
				   $("#pcsala7").val(valor);
				}
				else if(contador > 1)
				{
					alertas("Por favor seleccione un solo computador","Matricula sala 7","warning")
				}
				
		   }
		   else
		   {
			    $("#pcsala7").val("");
		   }
	  
	  
	  });
	  
	  
	  function TraerComputadorSala7(opcion,Sala) 
		{
		  
		  if(opcion==1)
		  {
			  Asignatura=$("#codfranja").val();
		      Grupo=$("#grupofranja").val(); 
			  valor=$(".mostrarhorario").find("input:checked").parents("tr");
		      reserva= valor.find("td").eq(1).text();  
		  }
		  
		 else  if(opcion==2)
		  {
		    Asignatura=$("#codasignatura").val();
		    Grupo=$("#grupo1").val();
			valor=$(".mostrarhorarioAsig").find("input:checked").parents("tr");
		    reserva= valor.find("td").eq(1).text();
			
		  }
		  
		  
		   
			$.ajax
			({
	
				type:'POST',
				dataType:'html',
				data:'asignatura='+Asignatura+'&sala='+Sala+'&grupo='+Grupo+'&opcion='+opcion+'&reserva='+reserva,
				url: 'consultas/Matricula/pcssala7.php',
				success: function(datos)
				{
					
				    if(opcion==1)
					{
					   $(".mostrarcompusersala7").html(datos);	
					}
					
					else if(opcion==2)
					{
					  $(".mostrarcompsala7").html(datos);
					}
					
				}
			}); 
		}
	 
	
   $("#MatriculaUsuarioSala7").button().click(function() {
		
		   var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codusu",
					  validations:{
						 
						   required:[true,"El campo Codigo usuario no puede estar vacio."],
						   number:[true,"El campo codigo usuario debe contener numeros."]
						 
						  }
				  }
				
				  ],
				  				  
			beforeValidation:function(){
				
			cadena=[];	
					
	         $('.matricula').each(function(i){
				valor=$(this).text();
				cadena[i]=valor;
			
		    });
			
		if(cadena.length > 0)
		
		{	
		  
		    codigoUser=$("#codusu").val();
			
		  
		    $.ajax({
				
					type:'POST',
					url: 'funciones/Matricula/insertarmatricula.php?array='+cadena,
					data:'codigoUsuario='+codigoUser,
					success: function(datos){
						
						
						 if(datos==1){
						 
						       $("tbody", "#detallematriculas").remove(); 
							   $(".franjahorariauser").attr('checked',false);
							   $("#TablaSelfranjauser").attr('checked',false);
							   $("#TablaSelfranjauser").hide();
							   $(".mostrarhorario").empty();
						       alertas("Las asignaturas se han matriculado correctamente","Matricula Usuario Sala 7","done"); 
							   asignacionAutomatica=1;
							   limpiarmatriculausuario();	
							    
							  }
							 
					 
					 else {
						
						 alertas("Ha ocurrido un error","Matricula Usuario Sala 7","error"); 	
					 }
			    }
		
			});
			}
			else
			{
			   alertas("Por favor matricule al menos una asignatura","Matricula Usuario","error"); 	
			}
		   }
		};
		 $.validation(options);   	
	 });
	 
  
	
	$(".checkboxreservaasig").live("click",function(){
	  
	   
	      if($(".checkboxreservaasig").is(":checked"))
           {	
	         var contador=0; 
			 
			$("#detallereservasasig input:checked").each( 
				function(i) { 
				  reserva=$(this).val(); 
				  contador+=1;
				 
			});
			
				if(contador==1)
				{  
				    Asignatura=$("#codasignatura").val();
					Grupo=$("#grupo1").val();
					obtenerSalas(Asignatura,Grupo,reserva,2); 
				}
				else if(contador > 1)
				{
					alertas("Por favor seleccione una sola reserva","Modificar matricula","error")
				}
				
		   }
		   else
		   {
			    alertas("Por favor seleccione una reserva","Modificar matricula","error")
		   }
	  
	  
	  });
	  
	  $(".checkboxreservauser").live("click",function(){
	  
	   
	      if($(".checkboxreservauser").is(":checked"))
           {	
	         var contador=0; 
			 
			$("#detallereservasuser input:checked").each( 
				function(i) { 
				  reserva=$(this).val(); 
				  contador+=1;
				 
			});
			
				if(contador==1)
				{  
				    Asignatura=$("#codasig").val();
					Grupo=$("#grupo").val();
					obtenerSalas(Asignatura,Grupo,reserva,1); 
				}
				else if(contador > 1)
				{
					alertas("Por favor seleccione una sola reserva","Modificar matricula","error")
				}
				
		   }
		   
	  });
	  
	  $(".franjahoraria").live("click",function(){
	  
	   
	      if($(".franjahoraria").is(":checked"))
           {	
	         var contador=0; 
			 
			$(".mostrarhorarioAsig input:checked").each( 
				function(i) { 
				  contador+=1;
				 
			});
			
				if(contador==1)
				{  
				    Asignatura=$("#codasignatura").val();
					Grupo=$("#grupo1").val();
					valor=$(".mostrarhorarioAsig").find("input:checked").parents("tr");
				    reserva= valor.find("td").eq(1).text();
					obtenerSalas(Asignatura,Grupo,reserva,4); 
				}
				else if(contador > 1)
				{
					alertas("Por favor seleccione una sola reserva","Modificar matricula","error")
				}
				
		   }
		   else
		   {
			    alertas("Por favor seleccione una reserva","Modificar matricula","error")
		   }
	  
	  
	  });
	  
	  
	  $(".franjahorariauser").live("click",function(){
	  
	   
	      if($(".franjahorariauser").is(":checked"))
           {	
	         var contador=0; 
			 
			$(".mostrarhorario input:checked").each( 
				function(i) { 
				  contador+=1;
				 
			});
			
				if(contador==1)
				{  
				    Asignatura=$("#codfranja").val();
					Grupo=$("#grupofranja").val();
					valor=$(".mostrarhorario").find("input:checked").parents("tr");
				    reserva= valor.find("td").eq(1).text();
					obtenerSalas(Asignatura,Grupo,reserva,3); 
				}
				else if(contador > 1)
				{
					alertas("Por favor seleccione una sola reserva","Modificar matricula","error")
				}
				
		   }
		   else
		   {
			    alertas("Por favor seleccione una reserva","Modificar matricula","error")
		   }
	  
	  
	  });
	
	
	  
   });// cierra jquery

</script>


</head>

<body>

<p id="validateErrors"></p>
<div id="tabs" style="width:720px; min-height:0px; max-height:auto;">
	<ul>
		<li><a href="#Adicusuario">Usuario</a></li>
		<li><a href="#Adicasignatura">Asignatura</a></li>
		
	</ul>
    
    
    <div id="Adicusuario"> 
       
     <p id="mensajeUser" <?php echo $stylerow; ?>>La asignatura ha sido matriculada correctamente</p>     
     <div id="matusuario" class="text ui-widget-content ui-corner-all" style="width:640px;  margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y;">
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MATRICULAS - CREAR NUEVA POR USUARIO</div>
           
        <table style="margin-left:10px;">
        <tr>
        <td><label>Codigo:</label>
        <td><input name="codusu" type="text" id="codusu" size="20" class="text ui-widget-content ui-corner-all height font12" title="Presione enter dentro del cajon de texto para realizar la consulta"  /></td>
         <td><label>Usuarios Matriculados:</label>
        <td><input type="text" id="Noestmat" size="5" class="text ui-widget-content ui-corner-all height font12"/></td>
        </tr>
        </table>
        
        <table style="margin-left:10px;">
        <tr>
          <td><label>Nombre:</label></td>
          <td><input name="nomusu" type="text" id="nomusu" value= "" size="50" class="text ui-widget-content ui-corner-all height font12" /></td>
          <td><label>Capacidad Sala:</label></td>
          <td><input  type="text"  size="5" id="CSalaUser" class="text ui-widget-content ui-corner-all height font12"  /></td>
          <td><input  type="hidden" size="5" id="HideCSala" class="text ui-widget-content ui-corner-all" /></td>
        </tr>
        </table>
        
        <div id="detallereservasuser" style="margin-left:10px; margin-bottom:10px; display:none;"></div>
        
        <table style="margin-left:10px;">
        <tr>
            <td class="hidemenuuser"><label>Codigo Asignatura:</label></td>
            <td class="hidemenuuser"><input name="codasig" type="text" id="codasig" size="15" class="text ui-widget-content ui-corner-all height font12" /></td>
            <td class="hidemenuuser"><label>Grupo:</label></td>
            <td class="hidemenuuser"><input name="" type="text" id="grupo" value= "" size="5" class="text ui-widget-content ui-corner-all height font12" /></td>
            <td class="hidemenuuser"><label id="salaNo">Sala No:</label></td>
           <td class="hidemenuuser">
           <select id="idSalas" size="1" class="Salas">
           <option value="Seleccione">Seleccione</option>
     
            </select>
           </td>
           <td class="hidemenuuser"><img src="images/add1.png" id="adicusu" title="De click en este boton para matricular una asignatura"/></td>
           <td class="hidemenuuser"><img src="images/teacher.png" id="teacher" title="De click en este boton para asignar un computador al docente"/></td>
           <td><img src="images/Sala Mac.png" id="SalaMac" title="De click en este boton para matricular un proyecto en la sala 7"/></td>
         </tr>
       </table>
        
        <div id="tabladinamica"> </div>
        
         <table>
        <tr>
         <td><button  type="button" id="finishmatuser" style="margin-top:5px; margin-bottom:5px; margin-left:10px;  font-size:11px;" title="Presione este boton si desea iniciar una nueva matricula"><img src="images/finish.png" style="vertical-align:middle; padding-right:4px;"/>Terminar Matricula</button></td>
          </tr>
       </table>
        
        </div>

   
     <p id="mensajeUserSala7" <?php echo $stylerow; ?>>La asignatura ha sido matriculada correctamente</p>     
    <div id="matsala7" class="text ui-widget-content ui-corner-all" style="width:640px;  margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y;">
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MATRICULAS SALA 7</div>
       
         <table style="margin-left:10px;"> 
         <tr>
           <td><label>Codigo Asignatura:</label></td>
           <td><input  type="text" id="codfranja" size="15" class="text ui-widget-content ui-corner-all height font12" /></td>
           <td><label>Grupo:</label></td>
           <td><input name="" type="text" id="grupofranja" value= "" size="5" class="text ui-widget-content ui-corner-all height font12" /></td>
           <td><label>Sala:</label></td>
           <td><select id="salauser7" size="1" class="salauser1" ><option value="Seleccione">Seleccione</option> </select></td>
           <td><label>Pc:</label></td>
           <td><input  type="text" id="pcsala7" size="7" class="text ui-widget-content ui-corner-all height font12" /></td> 
           <td><img src="images/add1.png" id="adicionarmatfranja" title="De click en este boton para matricular una asignatura"/></td>
          </tr> 
        </table>
        
         <table style="margin-left:10px;" id="TablaSelfranjauser"><tr> <td> <input type="checkbox" id="Selfranjauser" /></td><td><label>Seleccionar todas las franjas</label></td> </tr></table> 
         
         
         <div class="mostrarhorario"></div>
         
         <div class="mostrarcompusersala7" style="overflow:auto; min-width:0px; max-width:330px; min-height:0px; max-height:200px; margin-top:auto;"></div>

      
        <div id="matriculasalauser7"></div> 
      
       <table>
        <tr>
         <td><button  type="button" id="finishmatusersala7" style="margin-top:5px; margin-bottom:5px; margin-left:10px;  font-size:11px;" title="Presione este boton si desea iniciar una nueva matricula"><img src="images/finish.png" style="vertical-align:middle; padding-right:4px;"/>Terminar Matricula</button></td>
          </tr>
       </table>  
        
      </div> 
     
  
     </div><!-- cierro div Adicusuario-->
    
    
    <div id="Adicasignatura" >
          
      <p id="mensaje" <?php echo $stylerow; ?>>El usuario ha sido matriculado correctamente</p>    
     <div id="matasignatura" class="text ui-widget-content ui-corner-all" style="width:650px;  margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y;">
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MATRICULAS - CREAR NUEVA POR ASIGNATURA</div>
           
      
        <table style="margin-left:10px;">
        <tr>
        <td><label>Codigo:</label>
        <td><input name="codasignatura" type="text" id="codasignatura" size="20"  class="text ui-widget-content ui-corner-all height font12"  /></td>
        <td><label>Grupo:</label>
        <td><input name="" type="text" id="grupo1" value= "" size="5" style="margin-right:6px;"  class="text ui-widget-content ui-corner-all height font12" title="Presione enter dentro del cajon de texto para realizar la consulta" 
         />
        <td><label>Usuarios Matriculados:</label></td>
        <td><input name="" type="text" id="userMat" value= "" size="5"  class="text ui-widget-content ui-corner-all height font12"/> </td>
        </tr>
        </table>
        
       <table style="margin-left:10px;"> 
        <tr>
        <td><label>Nombre:</label>
        <td><input name="nomasig" type="text"  size="60" style="margin-right:6px;" id="nomasig"class="text ui-widget-content ui-corner-all height font12" /></td>
        <td><label>Capacidad Sala:</label>
        <td><input  type="text"  size="5" id="CSala"class="text ui-widget-content ui-corner-all height font12" /></td>
        <td><input  type="hidden" size="5" id="PcUserAsig"class="text ui-widget-content ui-corner-all" /></td>
        </tr>
     </table>
     
     <div id="detallereservasasig" style="margin-left:10px; margin-bottom:10px; display:none;"></div>
      
     <table style="margin-left:10px;">   
        <tr>
        <td class="hidemenuasig"><label>Codigo Usuario:</label></td>
        <td class="hidemenuasig" ><input type="text" id="coduser" size="15"  class="text ui-widget-content ui-corner-all height font12" title="Presione enter dentro del cajon de texto para matricular una asignatura" /></td>
        <td class="hidemenuasig"><label>Sala No:</label></td>
        <td class="hidemenuasig">
        <select id="Salas1" size="1" class="Salas1" style="margin-right:6px;"> 
           <option value="0">Seleccione</option> 
         </select>
         </td>
         <td class="hidemenuasig"><img src="images/add1.png" id="Adicusumat" title="De click en este boton para matricular una asignatura"/></td>
         <td class="hidemenuasig"><img src="images/teacher.png" id="teacherAsignatura" title="De click en este boton para asignar un computador al docente"/></td>
         <td><img src="images/Sala Mac.png" id="SalaMacAsignatura" title="De click en este boton para matricular un proyecto en la sala 7"/></td>
        </tr>
        </table>
         
         <div id="tabladinamica1"></div> 
       
        <table>
          <tr>
            <td><button  type="button" id="finishmatasig" style="margin-top:5px; margin-bottom:5px; margin-left:10px;  font-size:11px;" title="Presione este boton si desea iniciar una nueva matricula"><img src="images/finish.png" style="vertical-align:middle; padding-right:4px;"/>Terminar Matricula</button></td>
          </tr>
       </table> 
       
       </div>
 
 
       <p id="mensajeAsigSala7" <?php echo $stylerow; ?>>La asignatura ha sido matriculada correctamente</p>   
      <div id="matsala7Asig" class="text ui-widget-content ui-corner-all" style="width:640px;  margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y;">
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MATRICULAS SALA 7</div>
        
         <table style="margin-left:10px;"> 
         <tr>
          <td><label>Codigo Usuario:</label></td>
          <td><input  type="text" id="codfranjaAsig" size="15" class="text ui-widget-content ui-corner-all height font12" /></td>
           <td><label>Pc:</label></td>
           <td><input  type="text" id="pcsala7Asig" size="7" class="text ui-widget-content ui-corner-all height font12" /></td> 
           <td><label>Sala:</label></td>
           <td><select size="1" id="sala7asig" class="sala7asig"><option value="">Seleccione</option></select></td> 
           <td><img src="images/add1.png" id="adicionarmatfranjaAsig" title="De click en este boton para matricular una asignatura"/></td>
         </tr>
         </table>
         
         <table style="margin-left:10px;" id="tablaselfranja"><tr> <td> <input type="checkbox" id="Selfranja" /></td><td><label>Seleccionar todas las franjas</label></td> </tr></table> 
         
         <div class="mostrarhorarioAsig"></div>
         
      
      <div class="mostrarcompsala7" style="overflow:auto; min-width:0px; max-width:330px; min-height:0px; max-height:200px; margin-top:auto;"></div>

      
      <div id="matriculasala7"></div> 
      
        <table>
         <tr>
            <td><button  type="button" id="finishmatasigsala7" style="margin-top:5px; margin-bottom:5px; margin-left:10px;  font-size:11px;" title="Presione este boton si desea iniciar una nueva matricula"><img src="images/finish.png" style="vertical-align:middle; padding-right:4px;"/>Terminar Matricula</button></td>
          </tr>
       </table>  
          
       </div> 
     
     </div> <!-- cierro div Adicasignatura-->
      
    </div> <!-- cierro div tabs-->   

   <div id="alertas"></div>
    
</body>
</html>
<?php
mysql_free_result($JRGrupo);

?>
