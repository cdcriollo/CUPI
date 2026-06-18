 <?php require_once('../../Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<script type="text/javascript">

$(function(){
	
	
	var cancelstudent= new Array();
	var ArraycancelAsigEst=new Array();
	var Arraygrupoasignatura=new Array();
	var Arrayreservas=new Array();
	var crucecomputador=new Array();
	
	$(".tableUI").styleTable();
	$("#ocultarcheckbox").hide();
	$("#ocultarcheckboxusuario").hide();
	$("#crucepc").hide();
	$("#cancAsignaturasEstudiante").hide();
	$("#Cambiargrupoasignatura").hide();
	$("#Cambiarpcasignatura").hide();
	$("#CRComputadorAsig").hide();

	$("#tabs").tabs();
	$("#matriculau").hide();
	$("#matriculaA").hide();
	$("#tabladinamica").hide();
	$("#tabladinamica1").hide();
	$("#adicAsignatura").hide();
	$("#adicUsuarios").hide();
	$("#ocultarcelda").hide();
	$("#Cambiargrupo").hide();
	$("#Cambiarpc").hide();
	$("#CRComputador").hide();
	$("#cancUsuarios").hide();
	$("#cancUsuarios").hide();
	$("#DialogCancelAsig").hide();
	
	
	
	
	$("#modmatusuario").change(function()
	{
		var id=$("#modmatusuario").find(":selected").val();
		 if(id=="adicasig"){
		   $("#adicAsignatura").show("slide");
		   $("#Cambiargrupo").hide();
		   $("#Cambiarpc").hide();
		   $("#CRComputador").hide();
		   $("#cancAsignaturasEstudiante").hide();
		   
		   
	    } 
		
		else if(id=="changegrupo")
		{
		   $("#Cambiargrupo").show("slide");
		   $("#adicAsignatura").hide();
		   $("#Cambiarpc").hide();
		   $("#CRComputador").hide();
		   $("#cancAsignaturasEstudiante").hide();
		   
        } 
		
		else if(id=="changepc"){
			
			ComputadoresDisponiblesUser();
			$("#adicAsignatura").hide();
			$("#Cambiargrupo").hide();
			$("#CRComputador").hide();
			
        }
		else if(id=="cruceComp")
		{
		    $("#CRComputador").show("slide");
			$("#adicAsignatura").hide();
			$("#Cambiargrupo").hide();
			$("#Cambiarpc").hide(); 
			$("#cancAsignaturasEstudiante").hide(); 
        }
		
		else if(id=="cancelAsigUsu")
		{
			$("#adicAsignatura").hide();
			$("#Cambiargrupo").hide();
			$("#Cambiarpc").hide(); 
			$("#CRComputador").hide();
			CancelarAsignaturaEstudiante();
        }
		
		
	 
	});
	
	
	$("#modmatasig").change(function(){
		var id=$("#modmatasig").find(":selected").val();
		 if(id=="adicest")
		 {
		   $("#adicUsuarios").show("slide");
		   $("#ocultarcheckbox").hide();
		   $("#Cambiarpcasignatura").hide(); 
		   $("#Cambiargrupoasignatura").hide();
	    } 
		else if(id=="cambiarGrupoA")
		{
			$("#ocultarcheckbox").hide();
			$("#Cambiargrupoasignatura").show("slide");
			$("#Cambiarpcasignatura").hide();
			$("#adicUsuarios").hide();
			
		}
		else if(id=="cambiarComputadorA")
		{
			$("#ocultarcheckbox").hide();
			ComputadoresDisponiblesAsig();
			$("#adicUsuarios").hide();
			$("#Cambiargrupoasignatura").hide();
		}
		
		else if(id=="cruceCompAsig")
		{
			$("#ocultarcheckbox").hide();
			$("#adicUsuarios").hide();
			$("#Cambiargrupoasignatura").hide();
			$("#Cambiarpcasignatura").hide();
			CruceComputadorAsignatura();
		}
		
		else if(id=="cancelarEstAsig")
		{
			$("#ocultarcheckbox").show();
			$("#adicUsuarios").hide();
			$("#Cambiargrupoasignatura").hide();
			$("#Cambiarpcasignatura").hide();
			CancelarMatriculaEstudiantes()
		}
		
	});
	
	
	
	
 function obtenerSalas(asignatura,grupo,reservaSala,opcion){
	 
	

      $.ajax({

			type:'POST',
			url: 'consultas/Matricula/obtenerSalas.php',
			data:'codigo='+asignatura+'&grupo='+grupo+'&reserva='+reservaSala,
			success: function(datos)
			{
			    var arraysalas=datos.split(',');
				var filas=arraysalas.length; 
			    llenarCombo(arraysalas,filas,opcion);
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
 else if(opcion==3){
	 
	 $('select.SalaGrupo option').remove();
 }
 else if(opcion==4){
	 
	 $('select.SalaGrupoAsig option').remove();
 }


 for(i=0; i<filas; i++){
    var valor= array[i];
	
	if(opcion==1){
     $('#salaNo').append('<option value="'+valor+'" selected="selected" >'+valor+'</option>');
	}
	else if(opcion==2){
		$('#Salas1').append('<option value="'+valor+'" selected="selected" >'+valor+'</option>');
	}
	else if(opcion==3){
		$('#SalaGrupo').append('<option value="'+valor+'" selected="selected" >'+valor+'</option>');
	}
	else if(opcion==4){
		$('#SalaGrupoAsig').append('<option value="'+valor+'" selected="selected" >'+valor+'</option>');
	}
   }
   
}


   $("#codusu").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') {
	  
	     event.preventDefault();
	     codigo= $("#codusu").val();
		 BuscarUsuario(codigo);
		 
	   } 
	
	});	
	
	
   $("#codG").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') {
	  
	     event.preventDefault();
	     validarcampos();
		 
	   } 
	
	});
	
	
	$("#coduser").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') {
	    event.preventDefault();
	    adicionarEstudiantes();
		 
	   } 
	
	});	
	
	   //Caputuro el evento click del checkbox checkall
       $("#checkallAsig").click(function(){
		 //Obtengo el estado del checkbox checkall
         var bolDisabled = this.checked;
         $(".checkModMatriculaAsig").each(function(){
         //para cada uno de los checkbox restantes
         //le asigno el estado del checkbox checkall
          this.checked = bolDisabled;
        });
      });	
	  
	  //Caputuro el evento click del checkbox checkall
       $("#checkalluser").click(function(){
		 //Obtengo el estado del checkbox checkall
         var bolDisabled = this.checked;
         $(".checkmatricula").each(function(){
         //para cada uno de los checkbox restantes
         //le asigno el estado del checkbox checkall
          this.checked = bolDisabled;
        });
      });			

       $("#alertas" ).dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			modal:true		
		});
		
		$("#CanMatriculaEstudiantes").dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			title:"Cancelar Estudiantes",
			modal:true,
			
			buttons: {
				"Aceptar": function() {
					
					CancelarMatriEstudiantes();
					$( this ).dialog( "close" );
				},
				Cancelar: function() {
					$( this ).dialog( "close" );
				}
			}		
		});
		
		$("#DialogCancelAsig").dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			title:"Cancelar Asignaturas Estudiante",
			modal:true,
			
			buttons: {
				"Aceptar": function() {
					
					CancelarAsigEst();
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


     function verificarcrucehorario(usuario,asignatura,grupo,NoSala, nombreAsignatura,reserva,contenedor)
     {

       $.ajax({
			
			    type:'POST',
				dataType:'json',
			    url: 'consultas/Matricula/crucehorariosasignatura.php',
			    data:'usuario='+usuario+'&asignatura='+asignatura+'&grupo='+grupo+'&reserva='+reserva,
			    success: function(datos){
				
				   
				   if(datos.error==1)
				   {
					mensaje="Asignatura:"+" "+datos.asignatura+" "+"Grupo:"+" "+datos.grupo+" "+"Dia:"+" "+datos.diasemana+" "+"Hora Inicio:"+" "+datos.                    horainicio+" "+"Hora Final:"+" "+datos.horafinal+" "+"Sala:"+" "+datos.sala+" "+"Fecha inicio:"+" "+datos.fechainicio+" "+"Fecha final:"+                    " "+datos.fechafinal;
					
					   alertas("Se presenta cruce de horario(s) con la(s) siguiente(s) asignatura(s):"+mensaje+"","Modificar Matricula Usuario","warning"); 
					   
					   $("#codigoAsig").val("");
				       $("#codGrupo").val("");
				       $("#codigoAsig").focus();  
				  }
				else
				{
				   consultarpc(asignatura,grupo,NoSala,reserva,contenedor); 
				}
			  }
		    });
           }
		
		function verificarcrucehorarioA(codigoUsuario,codAsignatura,codGrupo,SalaA,reserva,contenedor)
		{
		  
		  $.ajax({
			
			    type:'POST',
				dataType:'json',
			    url: 'consultas/Matricula/crucehorariosasignatura.php',
			    data:'usuario='+codigoUsuario+'&asignatura='+codAsignatura+'&grupo='+codGrupo+'&reserva='+reserva,
			    success: function(datos){
				
				  if(datos.error==1)
				   {
					mensaje="Asignatura:"+" "+datos.asignatura+" "+"Grupo:"+" "+datos.grupo+" "+"Dia:"+" "+datos.diasemana+" "+"Hora Inicio:"+" "+datos.                    horainicio+" "+"Hora Final:"+" "+datos.horafinal+" "+"Sala:"+" "+datos.sala+" "+"Fecha inicio:"+" "+datos.fechainicio+" "+"Fecha final:"+                    " "+datos.fechafinal;
				
				    alertas("Se presenta cruce de horario(s) con la(s) siguiente(s) asignatura(s):"+mensaje+"","Modificar Matricula Asignatura","warning"); 
				 }
				else if(datos.error==0)
				{
				   obtenerpc(codAsignatura,codGrupo,SalaA,reserva,contenedor);
				}
				
			  }
		    });
		
		
		
		}
		
		
		//  funcion que verifica la existencia de una asignatura en al matricula del estudiante
		function verificarMatricula(Usuario,Asignatura,Grupo,Sala,NomAsignatura,reserva,contenedor)
		
	    {
		  
		
		  $.ajax({
			
				 type:'POST',
				 dataType:'json',
				 url:'consultas/Matricula/existenciamatriculaU.php',
				 data: 'asignatura='+Asignatura+'&usuario='+Usuario+'&grupo='+Grupo+'&reserva='+reserva,
				 success: function(datos){
			
		     if (datos.error==0)
			 {
			
				$("#codigoAsig").val("");
				$("#codGrupo").val("");
				$("#codigoAsig").focus();
				alertas("El usuario ya tiene matriculada esta Asignatura","Modificar Matricula por Usuario","error");	
			
		    }
			else if(datos.error==1)
			{
				
				verificarcrucehorario(Usuario,Asignatura,Grupo,Sala,NomAsignatura,reserva,contenedor);
				 
			}
		}
		
	  });
	
	}
	
	function verificarExistAsignaturaUsuario(Asignatura,Usuario,NuevoGrupo,NuevoHorario,NuevaSala,NuevoPc,reservaant,reservanueva,contenedor,opcion)
	{
		$.ajax({
			
				 type:'POST',
				 dataType:'json',
				 url:'consultas/Matricula/verificarExistAsignaturaU.php',
				 data: 'asignatura='+Asignatura+'&usuario='+Usuario,
				 success: function(datos){
			
		      if (datos.error==0)
			  {
		
				verificarcrucehorarioscambiogrupo(Asignatura,Usuario,NuevoGrupo,NuevoHorario,NuevaSala,NuevoPc,reservaant,reservanueva,contenedor,opcion);
			
		     }
			 else if (datos.error==1){
				
				alertas("El usuario no tiene matriculada esta asignatura","Modificar Matricula","error");	
				 
			}
		 }
		
	  });
	}
	
	
	function verificarcrucehorarioscambiogrupo(Asignatura,Usuario,NuevoGrupo,NuevoHorario,NuevaSala,NuevoPc,reservaant,reservanueva, contenedor,opcion)
	{
		//nuevoGrupo= $("#newgrupo").val();
		
		$.ajax({
			
			    type:'POST',
				dataType:'json',
			    url: 'consultas/Matricula/crucehorariosasignatura.php',
			    data:'usuario='+Usuario+'&asignatura='+Asignatura+'&grupo='+NuevoGrupo+'&reserva='+reservanueva,
			    success: function(datos){
				
				  if(datos.error==1)
				  {
					mensaje="Asignatura:"+" "+datos.asignatura+" "+"Grupo:"+" "+datos.grupo+" "+"Dia:"+" "+datos.diasemana+" "+"Hora Inicio:"+" "+datos.                    horainicio+" "+"Hora Final:"+" "+datos.horafinal+" "+"Sala:"+" "+datos.sala+" "+"Fecha inicio:"+" "+datos.fechainicio+" "+"Fecha final:"+                    " "+datos.fechafinal;
					
				      alertas("Se presenta cruce de horario(s) con la(s) siguiente(s) asignatura(s):"+mensaje+"","Modificar Matricula","warning"); 
				  }
				  else
				  {
				    Cambiargrupoestudiante(Asignatura,Usuario,NuevoGrupo,NuevoHorario,NuevaSala,NuevoPc,reservaant,reservanueva,contenedor,opcion);
				  
				  }
				
			  }
		    });
	}
	
	
	function MostrarSelectUsuario(usuario)
	{
		$.ajax({
			
		   type:'POST',
		   url:'consultas/Matricula/verificarExistMatriculaU.php',
		   data: 'usuario='+usuario,
		   success: function(datos){
			   
			 if (datos==1)
			 {  
			   consultarMatriculaUsuario();
			 }
			 else
			 {  
			    $("#tabladinamica").hide();
				$("#matriculau").hide();
				alertas("El usuario no tiene matriculadas asignaturas en el piso","Consultar Matricula Usuario","error") 
			 }
		   }
		});
   }
   
   function MostrarSelectAsignatura(asignatura,grupo)
	{
		$.ajax({
			
		   type:'POST',
		   url:'consultas/Matricula/verificarEstMatriculadosA.php',
		   data: 'asignatura='+asignatura+'&grupo='+grupo,
		   success: function(datos){
			   
			 if (datos==1)
			 {  
			     consultarMatriculaAsignatura(asignatura,grupo); 
				
			}
			 else
			 {
				 $("#tabladinamica1").hide();
				 $("#matriculaA").hide();
				alertas(" La asignatura no tiene estudiantes matriculados","Consultar Matricula Asignatura","error") 
			 }
		   }
		});
   }
	
	// verifica la matricula de los estudiantes matriculados en una asignatura
    function verificarMatriculaA(Asignatura,Sala,grupo,reserva,contenedor)
	{
		codUsuario=$("#coduser").val();
		
		$.ajax({
			
				 type:'POST',
				 dataType:'json',
				 url:'consultas/Matricula/existenciamatriculaU.php',
				 data: 'asignatura='+Asignatura+'&usuario='+codUsuario+'&grupo='+grupo+'&reserva='+reserva,
				 success: function(datos){
			
		     if (datos.error==0)
			 {
			   
				$("#coduser").val("");
				$("#coduser").focus();
				alertas("El usuario ya tiene matriculada esta Asignatura","Adicionar Matricula por Asignatura","error");	
			
		    }
			else if(datos.error==1){
				
				 verificarcrucehorarioA(codUsuario,Asignatura,grupo,Sala,reserva,contenedor);
			}
		}
		
	  });
	
	}
	

	// Trae las asignaturas matriculadas por el usuario
	function consultarMatriculaUsuario(){
		
		usuario=$("#codusu").val();
		
			 $.ajax({
			
			    type:'POST',
			    url: 'consultas/Matricula/consultarmatricula1.php',
			    data:'codigo='+usuario+'&opcion='+2,
			    success: function(datos){
				
				if(datos)
				{
				  $("#tabladinamica").html(datos);
				  $("#tabladinamica").show();
				  $("#matriculau").show();
				  $("#ocultarcheckboxusuario").show();
				}
			  }
		    });
				
   }
   
   // Trae la asignatura matriculadas por los usuarios 
   function consultarMatriculaAsignatura(asignatura,grupo)
   {		
			 $.ajax({
			
			     type:'POST',
			     url: 'consultas/Matricula/consultarDetalleModAsig.php',
			     data:'codigo='+asignatura+'&grupo='+grupo,
			     success: function(datos){
				 if(datos)
				 {
				   $("#tabladinamica1").html(datos)
				   $("#tabladinamica1").show();
				   $("#matriculaA").show();
				   $("#ocultarcheckbox").show();
			   
				 }
				
			  }
		    });
     }
	 
	 
	
	// funcion que verifica si la asignatura y el grupo existe 
  function verificarAsignatura(codigoAsignatura,grupo,reserva,contenedor){
	  
	 
	  
		$.ajax({
			
			type:'POST',
			dataType:'json',
			url: 'consultas/Matricula/ConsultarAGHorario.php',
			data:'codigo='+codigoAsignatura+'&grupo='+grupo,
			success: function(datos){
				
				if(datos.error==0){
					
					nombreAsignatura=datos.nombre;
					NoSala= $("#salaNo").val();
					usuario=$("#codusu").val();
					asignatura=$("#codigoAsig").val();
					grupo=$("#codGrupo").val();
					obteneridhorario(asignatura,grupo,NoSala,reserva);
					verificarMatricula(usuario,asignatura,grupo,NoSala,nombreAsignatura,reserva,contenedor);	
				   
				}
				else if(datos.error==1)
				{
					 alertas("Por favor verifique que la asignatura existe o el grupo existe o que la programacion de la asignatura esta vigente","Modificar Matricula Usuario","error"); 	
				}
			  }
		    }); 
		 
		 
	}
	
	// funcion que inserta una asignatura en la matricula del estudiante
	function insertarAsignatura(codigo,pc,grupo,reserva,contenedor){
		
		usuario= $("#codusu").val();
		horarioU=$("#HorarioMMat").val();
		
		$.ajax({
		 type:'POST',
		 dataType:'json',
		 url: 'funciones/Matricula/insertarMatricula1.php?pc='+pc,
		 data:'codigoA='+codigo+'&codigoU='+usuario+'&grupo='+grupo+'&horarioU='+horarioU+'&reserva='+reserva,
		 success: function(datos){
			
			if(datos.error==1)
			{
			
			    BuscarUsuario(usuario);
				$("#"+contenedor).empty();
				alertas("La asignatura ha sido adicionada exitosamente, El sistema asignara el computador automaticamente","Modificar Matricula","done"); 
				$("#codigoAsig").val("");
				$("#codGrupo").val("");
				$("#codigoAsig").focus();
				
			} 
			else if(datos.error==0)
			{
			  alertas("La asignatura no fue adicionada con exito","Modificar Matricula Usuario","error"); 
			}
		 }
		});
		
		
	}
	
	function insertarAsignaturaUsuarios(codAsignatura,codigoUsuario,datopc,codGrupo,horario,reserva,contenedor){
		
		
		
		$.ajax({
		 type:'POST',
		 dataType:'json',
		 url:'funciones/Matricula/insertarMatricula1.php?pc='+datopc,
		 data:'codigoA='+codAsignatura+'&codigoU='+codigoUsuario+'&grupo='+codGrupo+'&horarioU='+horario+'&reserva='+reserva,
		 success: function(datos){
			
			if(datos.error==1)
			{
			
			    alertas("El usuario ha sido adicionado con exito","Modificar Matricula Asignatura","done")
			    BuscarAsignatura(codAsignatura,codGrupo);
				$("#coduser").val("");
				$("#coduser").focus();
				
			} 
			else if(datos.error==0)
			{
			  alertas("El usuario no fue adicionado con exito","Modificar Matricula Asignatura","error"); 
			}
		 }
		});
		
		
	}
   
   
   // consulta un usuario en la base de datos
   function consultarUsuario(codigo){
   
	   NoSala= $("#Salas1").val();
	    
	  $.ajax({
			
			type:'POST',
			dataType:'json',
			url: 'consultas/Usuario/consultarUsuario.php',
			data:'codigo='+codigo,
			success: function(datos)
			{
				
				if(datos.error==0)
				{ 
				   if($(".checkboxreservaasig").is(":checked"))
				   {	
					  var contador=0; 
					 
					  $("#detallereservasasig input:checked").each( 
						function(i) { 
						  contador+=1; 
					  });
					
						if(contador==1)
						{  
						  nombreEstudiante=datos.nombre;
						  CAsignatura=$("#codA").val();
						  Sala=$("#Salas1").val();
						  grupo=$("#codG").val();
						  valor=$("#detallereservasasig").find("input:checked").parents("tr");
						  reserva= valor.find("td").eq(0).text();
						  idcontenedor="detallereservasasig";
						  verificarMatriculaA(CAsignatura,Sala,grupo,reserva,idcontenedor);
						
						}
				    }
					else
					{
					   alertas("Por favor seleccione una reserva","Modificar Matricula","error"); 	
					}
				 }
			     else if(datos.error==1)
				 {
				   alertas("El usuario no existe o esta inactivo","Modificar Matricula","error"); 
				 }
			    }
	          });
			}
        
   
   // funcion que obtiene el numero de pc que se le asignara al estudiante
   function obtenerpc(codAsignatura,codGrupo,NoSala,reserva,contenedor)
   {
      
	   
	 $.ajax({
			
		type:'POST',
		url: 'consultas/Matricula/consultarpc.php',
		data:'asignatura='+codAsignatura+'&grupo='+codGrupo+'&sala='+NoSala+'&reserva='+reserva,
		success: function(datos)
		{
			
			  pc=datos;
			
		   
		        if(pc==-1)
				{
				   alertas("No hay computadores para asignar","Modificar Matricula Asignatura","error");			
				}
	            else if(pc!= -1)
		        {
					
					 $.ajax({

						type:'POST',
						url: 'consultas/Matricula/obtenerIdhorario.php',
						data:'asignatura='+codAsignatura+'&grupo='+codGrupo+'&sala='+NoSala+'&reserva='+reserva,
						success: function(datos)
						{
			                Horario=datos.split(',');
						    insertarAsignaturaUsuarios(codAsignatura,codigoUsuario,pc,codGrupo,Horario,reserva,contenedor);
						 
						}
					 });
				}// cierro else if
					
		     }
	     });
	   }
	   
	   
	   function BuscarUsuario(){
	   
	  
		   var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codusu",
					  validations:{
						 
						  required:[true,"El campo Codigo no puede estar vacio."],
						  number:[true,"El campo Codigo debe contener numeros ."]
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
				if(datos.error==0)
				{
				  nombre=datos.nombre;
				  apellidos=datos.apellidos;
				  usuario= nombre+" "+apellidos;
				  $("#nomusu").val(usuario);
				  MostrarSelectUsuario(codigo);
				 
				}
				else if(datos.error==1)
			   {
			    
				  alertas("El usuario no existe","Modificar Matricula","error"); 
			   }
			}
		});
	  }
	 };
	$.validation(options);  
  }
	 
	 function BuscarAsignatura(codigoAsignatura,grupo){
		
		
		$.ajax({
			
			type:'POST',
			dataType:'json',
			url: 'consultas/Matricula/ConsultarAGHorario.php',
			data:'codigo='+codigoAsignatura+'&grupo='+grupo,
			success: function(datos){
				
				if(datos.error==0)
				{
				  nomasignatura=datos.nombre;
				  $("#nomA").val(nomasignatura);
				   MostrarSelectAsignatura(codigoAsignatura,grupo);
				}
				else
				{
				  alertas("Por favor verifique que la asignatura existe o el grupo existe","Modificar Matricula","error"); 
				}
			  }
		    });
	      }
	
		   
	   
	   function ComputadoresDisponiblesUser ()
	   {
		   
		   
		   if($(".checkmatricula").is(":checked"))
           {	
	         var contadorPcMat=0; 
		  
			$("input:checked.checkmatricula").each( 
				function(i) { 
				  contadorPcMat+=1;
			});
		
				if(contadorPcMat==1)
				{ 
				  valor=$("#tabladinamica").find("input:checked").parents("tr");
				
				  CodigoAs= valor.find("td").eq(0).text();
				  GrupoAs= valor.find("td").eq(1).text();
				  numComp= valor.find("td").eq(3).text();
				  sala= valor.find("td").eq(4).text();
				  reserva=valor.find("td").eq(6).text();
				  codigoU=$("#codusu").val();
				  
				  $.ajax({
			
					type:'POST',
					url: 'consultas/Matricula/consultarDisppc.php',
					data:'sala='+sala+'&asignatura='+CodigoAs+'&grupo='+GrupoAs+'&reserva='+reserva,
					success: function(datos)
					{
					   $("#PcsDispUser").html(datos);
					   $("#Cambiarpc").show("slide");
					}
				});
				 
			
		        }
			   
			    else if(contadorPcMat > 1)
			    {
				  alertas("Por favor seleccione solo una asignatura para hacer el cambio","Modificar Matricula Usuario","warning");    	
			    }
		
	      }
	     else
	     {
		  alertas("Por favor seleccione la asignatura, para traer los computadores disponibles para el cambio ","Modificar Matricula Usuario","warning"); 	  
	     }
	 }// cierro funcion
	 
	 
	 
	 
	  function ComputadoresDisponiblesAsig()
	   {
		  
		   if($(".checkModMatriculaAsig").is(":checked"))
           {	
	         var contadorPcMatAsig=0; 
		  
			$("input:checked.checkModMatriculaAsig").each( 
				function(i) { 
				  contadorPcMatAsig+=1;
			});
		
			if(contadorPcMatAsig==1)
			{ 
			  
		   
				 valor=$("#tabladinamica1").find("input:checked").parents("tr");
				 changepcCodigoAs= $("#codA").val();
				 changepcGrupoAs= $("#codG").val();
				 changepcsala= valor.find("td").eq(3).text();
				 changepcusuario=valor.find("td").eq(0).text();
				 changepcreserva=valor.find("td").eq(4).text();
				 
				 $.ajax({
				
					type:'POST',
					url: 'consultas/Matricula/consultarDisppcAsig.php',
					data:'sala='+changepcsala+'&asignatura='+changepcCodigoAs+'&grupo='+changepcGrupoAs+'&reserva='+changepcreserva,
					success: function(datos)
					{
					   $("#PcsDispAsig").html(datos);
					   $("#Cambiarpcasignatura").show("slide");
					}
				});
			
		   }
		   
			else if(contadorPcMatAsig > 1)
			{
			  alertas("Por favor seleccione solo un usuario para hacer el cambio","Modificar Matricula Asignatura","warning");    	
			}
		
	  }
	  else
	  {
		  alertas("Por favor seleccione el usuario  para traer los computadores disponibles para el cambio","Modificar Matricula Asignatura","warning"); 	  
	  } 
	   
   }
		  
	    
	 function cambiarComputador(asignatura,usuario,pc,grupo,reserva,contenedor,opcion){
		 
		 $.ajax({
			
			type:'POST',
			url: 'funciones/Matricula/cambiarComputador.php',
			data:'asignatura='+asignatura+'&usuario='+usuario+'&nuevopc='+pc+'&grupo='+grupo+'&reserva='+reserva,
			success: function(datos){
				
				if(datos==1)
				{
					if(opcion==1)
					{
						BuscarUsuario(usuario);
						$("#"+contenedor).hide();
					    alertas("El cambio de computador ha sido exitoso","Modificar Matricula Usuario","done"); 
						$(".selectpcuser").attr('checked',false);
						
						
					}
					else if(opcion==2)
					{
						 consultarMatriculaAsignatura(asignatura,grupo);
						 $("#"+contenedor).hide()
						 alertas("El cambio de computador ha sido exitoso","Modificar Matricula Asignatura","done"); 
						 $("#selectpcasig").attr('checked',false);
 
					}
				   
				}
				else
			   {
			     
				  alertas("No fue posible actualizar el computador","Modificar Matricula","error"); 
			   }
			}
		});
		 
	 }
	 
	function obteneridhorario(asignaturahorario,grupohorario,salaHorario,reserva){

     $.ajax({

		type:'POST',
		url: 'consultas/Matricula/obtenerIdhorario.php',
		data:'asignatura='+asignaturahorario+'&grupo='+grupohorario+'&sala='+salaHorario+'&reserva='+reserva,
		success: function(datos){
						
		 horario=datos.split(',');
		 $("#HorarioMMat").val(horario);
			
		}				
   });
  }
  
   
	 
	 function verificarAsignaturaGrupo(asignatura,usuario,nuevogrupo,salaC,reservaant,reservanueva,contenedor,opcion){
		 
		$.ajax({
			
			type:'POST',
			url: 'consultas/Matricula/consultarAsignaturaGrupo.php',
			data:'codigo='+asignatura+'&grupo='+nuevogrupo+'&sala='+salaC+'&reserva='+reservanueva,
			success: function(datos){
				
				 if(datos==0)
				 {
					alertas("Por favor verifique que la asignatura existe o el grupo existe o que la programacion de esta asignatura esta activa","Modificar Matricula Usuario","error"); 
				}
				
				else if(datos==2)
				{
				  alertas("No hay computadores disponibles para el cambio","Modificar Matricula Usuario","error"); 	
				}
				
			   else 
			   {
				 cambioG=datos.split('-');
				 NuevoHorario=cambioG[0];
				 NuevaSala= cambioG[1];
				 NuevoPc= cambioG[2];
				 verificarExistAsignaturaUsuario(asignatura,usuario,nuevogrupo,NuevoHorario, NuevaSala, NuevoPc,reservaant,reservanueva,contenedor,opcion);   
			  }
			 }
		    });   
	      }
	 
	 
	 function consultarpc(asignatura,grupo,sala,reserva,contenedor)
	 {
	 
		 $.ajax({
			
			type:'POST',
			url: 'consultas/Matricula/consultarpc.php',
			data:'asignatura='+asignatura+'&grupo='+grupo+'&sala='+sala+'&reserva='+reserva,
			success: function(datos)
			 {
				pc=datos;
				
				if(pc==-1)
				{
				   alertas("No hay computadores para asignar","Modificar Matricula Usuario","error");			
				}
				
				else if(pc!=-1)
				{
				  insertarAsignatura(asignatura,pc,grupo,reserva,contenedor);
				}
			  }
		   }); 
	    }
	
	
	// busca una asignatura en la base de datos
	$("#buscarA").button().click(function(){
	
	   validarcamposA();
	});
	
	function validarcampos()
	{
	  var options = {
				  
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codA",
					  validations:{
						 
						  required:[true,"El campo codigo no puede estar vacio."],
						  
						  
						 
						  }
				  },
				  
				  {
					  id:"codG",
					  validations:{
						 
						  required:[true,"El campo Grupo no puede estar vacio."],
						  number:[true,"El  campo Grupo debe contener numeros ."]
						  
						 
						  }
				  }
				  
				  ],
				  
				  				  
			beforeValidation:function(){  
				
				codigoAsignatura= $("#codA").val();
				grupo=$("#codG").val();
				BuscarAsignatura(codigoAsignatura,grupo);
			
			}
		   };
		   $.validation(options);  
		 }  
		
		
		
			
		 
	
	// evento que al dar click verifica si existe la asignatura e inserta una asignatura en la matricula del estudiante
	
	$("#Adicionar").button().click(function(){
		
	  var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codigoAsig",
					  validations:{
						 
						  required:[true,"El campo Codigo Asignatura no puede estar vacio."],
						  
						  }
				  },
				  
				  {
					  id:"codGrupo",
					  validations:{
						 
						  required:[true,"El campo Grupo no puede estar vacio."],
						  number:[true,"El campo Grupo debe contener numeros ."]
						  }
				  }
				  
				  ],	
				  			  
				        beforeValidation:function()
						{
						   if($(".checkboxreserva").is(":checked"))
						   {	
							   var contadorreserva=0; 
						  
							   $("input:checked.checkboxreserva").each( 
								function(i) { 
								  contadorreserva+=1;
							   });
						
							   if(contadorreserva==1)
							   { 
							     codAsig= $("#codigoAsig").val();
								 codigousu=$("#codusu").val();
								 grupo= $("#codGrupo").val();
								 valor=$("#detallereservas").find("input:checked").parents("tr");
								 reserva= valor.find("td").eq(0).text();
								 idcontenedor="detallereservas";
								 verificarAsignatura(codAsig,grupo,reserva,idcontenedor);
							  }
						   }
						   else
						   {
							  alertas("Por favor seleccione una reserva","Modificar Matricula Usuario","error");	 
						   }
						  }
						 };
					$.validation(options);  

		         });
	
	
	
	
	$("#addestudiantes").click(function(){
	
	  adicionarEstudiantes();
	
	});
	
	function adicionarEstudiantes()
	
	{
		var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"coduser",
					  validations:{
						 
						  required:[true,"El campo Codigo no puede estar vacio."],
						  number:[true,"El campo Codigo debe contener numeros ."]
						  
						  }
				  }
				  
				  ],	
				  			  
				  beforeValidation:function()
				  {
					codigoUsuario=$("#coduser").val();
					codigoMateria=$("#codA").val(); 
					grupoA=$("#codG").val();
					consultarUsuario(codigoUsuario);
				  }
		         };
				  $.validation(options);  
				}
					
	  
  
     function Cambiargrupoestudiante(asignatura,usuario,nuevogrupo, nuevohorario, nuevasala, nuevopc,reservaant,reservanueva, contenedor,opcion ){
	  
	 
         $.ajax({
					type:'POST',
					url: 'funciones/Matricula/actualizarGrupo.php',
					data:'asignatura='+asignatura+'&usuario='+usuario+'&nuevogrupo='+nuevogrupo+'&nuevohorario='+nuevohorario+'&nuevasala='+nuevasala+'&nuevopc='+nuevopc+'&reservaant='+reservaant+'&reservanueva='+reservanueva,
					 success: function(datos){
						 
						 
						
						 if(datos==1)
						 {
							 if(opcion==1)
							 {
								alertas("El grupo se ha cambiado exitosamente el cupi asignara el computador automaticamente","Modificar Matricula Usuario","done");
								consultarMatriculaUsuario();
								$("#"+contenedor).empty();
								$(".checkmatricula").attr('checked',false);
								$("#CAsignatura").val("");
								$("#newgrupo").val("");  
							 }
							 else if(opcion==2)
							 {
								alertas("El grupo se ha cambiado exitosamente el cupi asignara el computador automaticamente","Modificar Matricula Asignatura","done");
								$("#"+contenedor).empty();
								$(".checkModMatriculaAsig").attr('checked',false); 
								$("#newgrupoAsig").val("");     
							 }
					  }
							 
					 
					 else 
					 {
						alertas("El cambio de grupo no fue exitoso","Modificar Matricula","error"); 
					 }
			    }
		
			});
	   
  }
  
  // cambia el grupo de la  asignatura en la matricula
  $("#cambiarGrupoMat").button().click(function(){
	  
	  if($(".checkmatricula").is(":checked"))
      {	
	      var contadorGrupoMat=0; 
		  
	    $("input:checked.checkmatricula").each( 
			function(i) { 
			  contadorGrupoMat+=1;
		});
		
		if(contadorGrupoMat==1)
		{
	      var options = {
				  
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"CAsignatura",
					  validations:{
						 
						  required:[true,"El campo Codigo Asignatura no puede estar vacio."],
						  
						 
						  }
				  },
				  {
					  id:"newgrupo",
					  validations:{
						 
						  required:[true,"El campo Grupo no puede estar vacio."],
						  number:[true,"El campo Grupo no puede contener letras."],
						 
						  }
				  }
				  
				  ],
				  
				  				  
			beforeValidation:function()
			{  
			   if($(".checkboxreservagrupo").is(":checked"))
              {	
	             var contadorGrupoReserva=0; 
		  
				$("input:checked.checkboxreservagrupo").each( 
					function(i) { 
					  contadorGrupoReserva+=1;
				});
		
				if(contadorGrupoReserva==1)
				{
				  asignatura=$("#CAsignatura").val();
				  usuario= $("#codusu").val();
				  nuevogrupo= $("#newgrupo").val();
				  SalaCambioGrupo=$("#SalaGrupo").val();
				  valorreserva=$("#detallereservasgrupo").find("input:checked").parents("tr");
				  Reservagrupouser= valorreserva.find("td").eq(0).text();
				  idcontenedor="detallereservasgrupo";
				  valor=$("#tabladinamica").find("input:checked").parents("tr");
				  reservaantgrupouser= valor.find("td").eq(6).text();
				  verificarAsignaturaGrupo(asignatura,usuario,nuevogrupo,SalaCambioGrupo,reservaantgrupouser,Reservagrupouser,idcontenedor,1);
			  }
			 }
			 else
			 {
				alertas("Por favor seleccione una reserva","Modificar Matricula Usuario","error");  
			 }
			}
	      };
	     $.validation(options);
		}
		else if(contadorGrupoMat > 1)
		{
		  alertas("Por favor marque una sola opcion","Modificar Matricula","warning");    	
		}
		
	  }
	  else
	  {
		  alertas("Por favor marque la opcion","Modificar Matricula","warning"); 	  
	  }
	});
	
	
	 // cambia el grupo de la  asignatura en la matricula
  $("#cambiarGrupoMatAsignatura").button().click(function(){
	  
	  if($(".checkModMatriculaAsig").is(":checked"))
      {	
	      var contadorGrupoModMat=0; 
		  
	    $("input:checked.checkModMatriculaAsig").each( 
			function(i) { 
			  contadorGrupoModMat+=1;
		});
		
		if(contadorGrupoModMat==1)
		{
	      var options = {
				  
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  
				  {
					  id:"newgrupoAsig",
					  validations:{
						 
						  required:[true,"El campo Grupo no puede estar vacio."],
						  number:[true,"El campo Grupo no puede contener letras."],
						 
						  }
				  }
				  
				  ],
				  
				  				  
			beforeValidation:function()
			{  
	            if($(".checkboxreservaasiggrupo").is(":checked"))
                {	
	               var contadorGrupoReservaAsig=0; 
		  
					$("input:checked.checkboxreservaasiggrupo").each( 
						function(i) { 
						  contadorGrupoReservaAsig+=1;
					});
		
				if(contadorGrupoReservaAsig==1)
				{
				  CGasignatura=$("#codA").val();
				  valor=$("#tabladinamica1").find("input:checked").parents("tr");
				  CGAusuario= valor.find("td").eq(0).text();
				  CGAnuevogrupo= $("#newgrupoAsig").val();
				  CGASalaCambioGrupo=$("#SalaGrupoAsig").val();
				  reservaant=valor.find("td").eq(4).text();
				  valorreservaAsig=$("#detallereservasasigrupo").find("input:checked").parents("tr");
				  reservanueva= valorreservaAsig.find("td").eq(0).text();
				  idcontenedor="detallereservasasigrupo";
				  verificarAsignaturaGrupo(CGasignatura,CGAusuario,CGAnuevogrupo,CGASalaCambioGrupo,reservaant,reservanueva,idcontenedor,2);
			  }
		    }
			else
			{
				alertas("Por favor seleccione una reserva","Modificar Matricula Asignatura","error");  
			}
		   }// cierro before validation
	      };
	     $.validation(options);
		}
		else if(contadorGrupoModMat > 1)
		{
		  alertas("Por favor marque una sola opcion","Modificar Matricula","warning");    	
		}
		
	  }
	  else
	  {
		  alertas("Por favor marque la opcion","Modificar Matricula","warning"); 	  
	  }
	});
	
   
   $("#cambiarpcmat").button().click(function(){
	
	 if($(".checkmatricula").is(":checked"))
     {	
	 
	         var contadorPcMatUserCambio=0;
			 var contadorPcMatUser=0; 
	         var CodigoUsuario=$("#codusu").val(); 
		  
			$("input:checked.checkmatricula").each( 
				function(i) { 
				contadorPcMatUserCambio+=1;
			});
		
				if(contadorPcMatUserCambio==1)
				{ 
				  valor=$("#tabladinamica").find("input:checked").parents("tr");
				  CodigoAsCambio= valor.find("td").eq(0).text();
				  GrupoAsCambio= valor.find("td").eq(1).text();
				  reservacambio=valor.find("td").eq(6).text();
				  idcontenedor="Cambiarpc";
				  
				    if($(".selectpcuser").is(":checked"))
                    {	
					   $("input:checked.selectpcuser").each( 
							function(i) { 
							  contadorPcMatUser+=1;
							  comp=$(this).val();
						});
			
			        if(contadorPcMatUser==1)
			        { 
			          cambiarComputador(CodigoAsCambio,CodigoUsuario,comp,GrupoAsCambio,reservacambio,idcontenedor,1)  
			        }
			       else
			       {
			          alertas("Por favor seleccione solo un computador para hacer el cambio","Modificar Matricula Usuario","warning"); 	
			       }
	           }
			   else
			   {
				  alertas("Por favor seleccione el computador para el cambio","Modificar Matricula Usuario","warning"); 
			   }
		}
		else
		{
			alertas("Por favor seleccione solo una asignatura para hacer el cambio","Modificar Matricula Usuario","warning"); 
		}
	 }
	 else
	 {
		alertas("Por favor seleccione la asignatura para hacer el cambio","Modificar Matricula Usuario","warning");  
	 }
  });
	  
	 
   
   $("#cambiarpcmatAsig").button().click(function(){
	  
	   if($(".checkModMatriculaAsig").is(":checked"))
      {	
	      var contadorPcMatAsigcambio=0; 
		  var contadorCompSelAsig=0;
		  
	    $("input:checked.checkModMatriculaAsig").each( 
			function(i) { 
			  contadorPcMatAsigcambio+=1;
		});
		
		if(contadorPcMatAsigcambio==1)
		{ 
	      
	   
	         valor=$("#tabladinamica1").find("input:checked").parents("tr");
			 changepcCodigoAsCambio= $("#codA").val();
			 changepcGrupoAsCambio= $("#codG").val();
			 changepcsalaCambio= valor.find("td").eq(3).text();
			 changepcusuarioCambio=valor.find("td").eq(0).text();
			 changepcreserva=valor.find("td").eq(4).text();
			 idcontenedor="Cambiarpcasignatura";
			 
			 
			   if($(".selectpcasig").is(":checked"))
               {	
					$("input:checked.selectpcasig").each( 
						function(i) { 
						contadorCompSelAsig+=1;
					    compSelAsig=$(this).val();
				     });
			
			        if(contadorCompSelAsig==1)
			        { 
			          cambiarComputador(changepcCodigoAsCambio,changepcusuarioCambio,compSelAsig,changepcGrupoAsCambio,changepcreserva,idcontenedor,2)  
			        }
			       else
			       {
			          alertas("Por favor seleccione solo un computador para hacer el cambio","Modificar Matricula Asignatura","warning"); 	
			       }
	           }
			   else
			   {
				  alertas("Por favor seleccione el computador para el cambio","Modificar Matricula Asignatura","warning"); 
			   }
			 
		}
		else if(contadorPcMatAsigcambio > 1)
		{
		  alertas("Por favor seleccione un solo usuario para hacer el cambio","Modificar Matricula Asignatura","warning");    	
		}
		
	  }
	  else
	  {
		  alertas("Por favor seleccione el usuario, para realizar el cambio de computador","Modificar Matricula Asignatura","warning"); 	  
	  } 
	   
   });
   
   
      
	 function CancelarMatriculaEstudiantes()
	 {  
		   if($(".checkModMatriculaAsig").is(":checked"))
		   {  
			  $("#CanMatriculaEstudiantes").dialog("open");
			  $("#checkallAsig").attr('checked',false);
		   }
		  else
		  {
			alertas("Por favor seleccione al menos un usuario para cancelar","Modificar Matricula Asignatura","warning");   
		  }
	 }
	
	
	   
	   
	   
 
		 function CancelarAsignaturaEstudiante()
		 { 
	   
			  if($(".checkmatricula").is(":checked"))
			  {  
				 $("#DialogCancelAsig").dialog("open");
				 $("#checkalluser").attr('checked',false);
			  }
			  else
			  {
				alertas("Por favor seleccione al menos una asignatura para cancelar","Modificar Matricula Asignatura","warning");   
			  }
		 }
	
	   
	   function CancelarMatriEstudiantes()
	   {
		   cancelstudent=[];
		  
	   
			   $("input:checked.checkModMatriculaAsig").each( 
				   function(i) { 
				   valor=$(this).val();
				   datos=valor.split(".");
				   usuario=datos[0];
				   reserva=datos[2]
				   cancelstudent[i]=usuario+','+reserva;
					
				 });
				 
				   
			asig= $("#codA").val();
			grupoE=$("#codG").val();
			
			   $.ajax({
				 
					type:'POST',
					url: 'funciones/Matricula/cancelarMatricula.php?arrayest='+cancelstudent,
					data:'asignatura='+asig+'&grupoE='+ grupoE,
					 success: function(datos)
					 {
						
						
						 if(datos==1)
						 {
						   
						   alertas("Las matriculas han sido canceladas con exito","Modificar Matricula Asignatura","done");
						   consultarMatriculaAsignatura(asig,grupoE)
						   //$("#cancUsuarios").hide("slide");
						   $(".checkModMatriculaAsig").attr('checked',false);   	
						 }
							 
					 
					    else if(datos==0)
					    {
						
						  alertas("Las matriculas no fueron canceladas con exito","Modificar Matricula Asignatura","error"); 
					    }
			      }
		
			 });
	      }
		   
		   
		  function CancelarAsigEst()
	      {
			 
		    ArraycancelAsigEst=[];
			Arraygrupoasignatura=[];
			Arrayreservas=[];
		    contadorCancelarUsuario=0;
			user=$("#codusu").val();
	   
			 $("input:checked.checkmatricula").each( 
				function(i) { 
				  valor=$(this).val();
				  datos=valor.split(".");
				  contadorCancelarUsuario+=1;
				  asignatura=datos[0];
				  grupo=datos[1];
				  reserva=datos[2];
				  ArraycancelAsigEst[i]=asignatura;
				  Arraygrupoasignatura[i]=grupo;
				  Arrayreservas[i]=reserva;
					
			});
				 
				 
			   
			  if(contadorCancelarUsuario > 0)
			  { 
			   
			    $.ajax({
				 
					type:'POST',
					url: 'funciones/Matricula/cancelarAsignaturasEst.php',
					data:'usuario='+user+'&arrayAsig='+ ArraycancelAsigEst+'&arrayGrupo='+Arraygrupoasignatura+'&Arrayreservas='+Arrayreservas,
					 success: function(datos)
					 {
						
						
						 if(datos==1)
						 {
						   alertas("La(s) asignaturas han sido canceladas con exito","Modificar Matricula Usuario","done"); 
						   BuscarUsuario();
						   $(".checkmatricula").attr('checked',false);   
						 }
							 
					 
						 else if(datos==0)
						 {
							alertas("Las asignaturas no fueron canceladas con exito","Modificar Matricula Usuario","error"); 
						 }
			      }
		
			  });
			 }
			  else
			  {
			    alertas("Por favor seleccione al menos una asignatura para cancelar ","Modificar Matricula Usuario","error"); 	
			  }
	       }
		    
		   
		   
 
  
  $("#codGrupo").blur(function(){
	  
  	 var options = {
					 
					classerror:"ui-state-error",
					classdone:"ui-state-highlight",
					contentmsg:"validateErrors",
					fields:[
					{
						id:"codigoAsig",
						validations:
						{
							required:[true,"El campo Codigo asignatura no puede estar vacio."],
						}
					},
					
					{
						id:"codGrupo",
						validations:
						{
							required:[true,"El campo Grupo no puede estar vacio."],
							number:[true,"El campo Grupo debe contener numeros."]
						}
					}
					
				],
									  
				beforeValidation:function()
				{
					var asignatura=$("#codigoAsig").val();
					var grupo=$("#codGrupo").val();
					var clase="checkboxreserva";
					llenarselectreservas(asignatura,grupo,4,clase)
				}
			   };
			 $.validation(options);   
  
  });
  
  
   $("#codG").blur(function(){
	   
	 var options = {
				  
		classerror:"ui-state-error",
		classdone:"ui-state-highlight",
		contentmsg:"validateErrors",
		fields:[
			{
			  id:"codA",
			  validations:
			  {
				 required:[true,"El campo codigo no puede estar vacio."]
				
			  },
			  
			  id:"codG",
			  validations:
			  {
				 required:[true,"El campo grupo no puede estar vacio."],
				 number:[true,"El campo grupo debe contener numeros."]
				
			  }
		   }
		  ],
				  
		beforeValidation:function()
		{    
  
	      var asignatura=$("#codA").val();
		  var grupo=$("#codG").val();
		  var clase="checkboxreservaasig";
		  llenarselectreservas(asignatura,grupo,3,clase)
		 
	   }
	  };
	 $.validation(options); 
	});
	
  
  $("#CAsignatura").dblclick(function(){
	  
	 var contadorCAsignatura=0; 
	
	if($(".checkmatricula").is(":checked"))
    {	
	
	   $("input:checked.checkmatricula").each( 
			function(i) { 
			contadorCAsignatura+=1;
		});
		
	
		if(contadorCAsignatura==1)
		{
		  valor=$("#tabladinamica").find("input:checked").parents("tr");
		  textoAsignatura= valor.find("td").eq(0).text(); 
		  $("#CAsignatura").val(textoAsignatura);
		}
		else if(contadorCAsignatura > 1)
		{
		  alertas("Por favor marque una sola opcion","Modificar Matricula","warning");    	
		}
   }
   else
   {
	 alertas("Por favor marque la opcion","Modificar Matricula","warning");    
   }
   	   
  });
  
  
  $("#interchangepc").button().click(function(){
	  
	
	 
	    if ($(".checkmatricula").is(":checked"))
		{
	       
		      valor=$("#tabladinamica").find("input:checked").parents("tr");
			  antiguopc= valor.find("td").eq(3).text();
			  codMateria=valor.find("td").eq(0).text();
			  GrupoCambio=valor.find("td").eq(1).text();
			  reservaCambio=valor.find("td").eq(6).text();
	
	   $.ajax({
		
		type:'POST',
		url: 'consultas/Matricula/crucecomputador.php',
		data:'asignatura='+codMateria+'&grupo='+GrupoCambio+'&antiguopc='+antiguopc+'&reserva='+reservaCambio,
		success: function(datos)
		{
		   
		   $("#detallepcs").html(datos);
		   $("#crucepc").show();
		  
		}
	    }); 
	  }
	  else
	  {
	    alertas("Por favor seleccione la opcion para recopilar los datos","Modificar Matricula Usuario","warning");    
	  }
   });
   
   
   
   
  
  $("#crucepc").button().click(function(){
	  
	  var contadorEscogerpc=0;
	  var contadorcheckmatricula=0;
	  codigoUsuario=$("#codusu").val();
	 
	
	      $("input:checked.checkmatricula").each( 
			 function(i) { 
			  contadorcheckmatricula+=1;
			  valor=$("#tabladinamica").find("input:checked").parents("tr");
			  antiguopc= valor.find("td").eq(3).text();
			  SalaComputo=valor.find("td").eq(4).text();
			  codMateria=valor.find("td").eq(0).text();
			  GrupoCambio=valor.find("td").eq(1).text();
			  ReservaCambio=valor.find("td").eq(6).text();
			  
		 });
		 
		
	      $("input:checked.escogerPc").each( 
			 function(i) { 
			  contadorEscogerpc+=1;
			  nuevoComp= $(this).val();
			  
		 });
		
	
		if ($(".checkmatricula").is(":checked"))
		{
		   if(contadorcheckmatricula==1)
		   {
			  if($(".escogerPc").is(":checked"))
			  {
				 if(contadorEscogerpc==1)
				 {
					
					   $.ajax({
		                 type:'POST',
		                 url: 'funciones/Matricula/IntercambiarComputadorUsuario.php',
		                 data:'asignatura='+codMateria+'&usuario='+codigoUsuario+'&nuevopc='+nuevoComp+'&oldpc='+antiguopc+'&grupo='+GrupoCambio+'&reserva='+ReservaCambio,
		                 success: function(datos)
		                 {
		                   
						   if(datos==2)
						   {
							  alertas("El computador escogido para el cambio no ha sido asignado","Modificar Matricula Usuario","done");    
						   }
						   else if(datos==11)
						   {
					           BuscarUsuario(codigoUsuario);
							   $("#detallepcs").empty();
							   alertas("El Cambio de computador se ha hecho exitosamente","Modificar Matricula Usuario","done"); 
							   $(".escogerPc").attr('checked',false);
							   $(".checkmatricula").attr('checked',false);      
						   }
						   else
						   {
							  alertas("Ha ocurrido un error","Modificar Matricula Usuario","error")    
						   }
		                 }
					   });
					
				 }
				 else
				 {
				    alertas("Por favor seleccione solo un computador para hacer el cambio","Modificar Matricula Usuario","warning")  	 
				 }
			  }
			  else
			  {
				 alertas("Por favor seleccione seleccione el computador con el cual va a ser el cambio","Modificar Matricula Usuario","error")    
			  }
		   }
		   else
		   {
			 alertas("Por favor seleccione solo un computador que este usando actualmente","Modificar Matricula Usuario","warning")  
		   }
	    }
	  else
	  {
		 alertas("Por favor seleccione la asignatura y el computador que va a cambiar","Modificar Matricula Usuario","error");	
	  }
	  
  });
  
  
  
	function CruceComputadorAsignatura()
	{ 
	 
	  var contadorcheckmatriculaAsig=0;
	 
	     $("input:checked.checkModMatriculaAsig").each( 
			 function(i) 
			 { 
			   
			  contadorcheckmatriculaAsig+=1;
			  id=$(this).val();
			  valor=id.split(".");
			  usuario=valor[0];
			  comp=valor[1];
			  reserva=valor[2];
			  crucecomputador[i]=usuario+","+comp+','+reserva;  
		 });
		 
		  
		   if(contadorcheckmatriculaAsig==2)
		   {
			   AsignaturaCruce=$("#codA").val();
			   GrupoCruce=$("#codG").val();
			 
			 
					   $.ajax({
		                 type:'POST',
						 dataType:'json',
		                 url: 'funciones/Matricula/IntercambiarComputador.php',
		                 data:'asignatura='+AsignaturaCruce+'&crucecomp='+crucecomputador+'&grupo='+GrupoCruce,
		                 success: function(datos)
		                 {
		                   
						   if(datos.error==3)
						   {
							   alertas("No se puede hacer el cambio entre usuarios que posean distinta reserva","Modificar Matricula Asignatura","error");   
						   }
						   
						   else if(datos.error==2)
						   {
							  alertas("Pór favor seleccione los usuarios para realizar el cruce de computador","Modificar Matricula Asignatura","done");    
						   }
						   
						   else if(datos.error==0)
						   {
					           consultarMatriculaAsignatura(AsignaturaCruce,GrupoCruce);
							   alertas("El cruce de computador se ha hecho exitosamente","Modificar Matricula Asignatura","done"); 
							   $(".checkModMatriculaAsig").attr('checked',false);    
						   }
						   else if(datos.error==1)
						   {
							  alertas("El cruce de computador no pudo realizarse","Modificar Matricula Asignatura","error")    
						   }
		                 }
					   });
					   
	      }
		  else
		  {
			 alertas("Por favor seleccione 2 usuarios para realizar el cruce de computador","Modificar Matricula Usuario","error");	
		  }
	}
	   
  
  $("#newgrupo").blur(function(){
	 
	  var options = {
				  
		classerror:"ui-state-error",
		classdone:"ui-state-highlight",
		contentmsg:"validateErrors",
		fields:[
			{
			  id:"CAsignatura",
			  validations:
			  {
				 required:[true,"El campo codigo no puede estar vacio."]
				
			  },
			  
			  id:"newgrupo",
			  validations:
			  {
				 required:[true,"El campo grupo no puede estar vacio."],
				 number:[true,"El campo grupo debe contener numeros."]
				
			  }
		   }
		  ],
				  
		beforeValidation:function()
		{    
  
		  var asignatura=$("#CAsignatura").val();
		  var grupo=$("#newgrupo").val();
		  var clase="checkboxreservagrupo";
		 llenarselectreservas(asignatura,grupo,5,clase)
	   }
	  };
	 $.validation(options);  
	  
  });
  
   $("#newgrupoAsig").blur(function(){
	 
	  var options = {
				  
		classerror:"ui-state-error",
		classdone:"ui-state-highlight",
		contentmsg:"validateErrors",
		fields:[
			{
			  id:"codA",
			  validations:
			  {
				 required:[true,"El campo codigo no puede estar vacio."]
				
			  },
			  
			  id:"newgrupoAsig",
			  validations:
			  {
				 required:[true,"El campo grupo no puede estar vacio."],
				 number:[true,"El campo grupo debe contener numeros."]
				
			  }
		   }
		  ],
				  
		beforeValidation:function()
		{    
  
	        var asignatura=$("#codA").val();
			var grupo=$("#newgrupoAsig").val();
			var clase="checkboxreservaasiggrupo";
			llenarselectreservas(asignatura,grupo,2,clase)
	   }
	  };
	 $.validation(options);  
	  
  });
  
  
  function CancelarAsignaturasEstudiante(usuario)
  {
	  
	 $.ajax({
			
			     type:'POST',
			     url: 'consultas/Matricula/CancelarAsignaturaEstudiante.php',
			     data:'usuario='+usuario,
			     success: function(datos){
					 
				 if(datos!=0)
				 {
				   $("#detalleAsignaturas").html(datos);
				   $("#ocultarcheckboxusuario").show();
				   $("#cancAsignaturasEstudiante").show("slide");
					$("#adicAsignatura").hide();
			        $("#Cambiargrupo").hide();
			        $("#Cambiarpc").hide(); 
			        $("#CRComputador").hide(); 
				 }
			  }
		    });
  }
  
  $("#limpiarpantallauser").button().click(function(){
	  
	 $("#tabladinamica").hide(); 
	 $("#matriculau").hide(); 
	 $("#codusu").val("");
	 $("#nomusu").val("");
	 $("#codusu").focus();
  });
  
  $("#limpiarpantallaasig").button().click(function(){
	  
	 $("#tabladinamica1").hide(); 
	 $("#matriculaA").hide(); 
     $("#codA").val("");
	 $("#codG").val("");
	 $("#nomA").val("");
	 $("#codA").focus();
  });
  
  $("#closepcuser").click(function () {
	  
	$("#Cambiarpc").hide("slide");  
	  
  });
  
  $("#closepcasig").click(function () {
	  
	$("#Cambiarpcasignatura").hide("slide");  
	  
  });
  
  $("#closecruceuser").click(function (){
	  
	$("#CRComputador").hide("slide");  
	  
  });
  
  function llenarselectreservas(codigo,grupo,opcion,clase)
	 {
		 
		    $.ajax({
			
			    type:'POST',
			    url: 'consultas/Matricula/verificarreserva.php',
			    data:'asignatura='+codigo+'&grupo='+grupo,
			    success: function(datos)
				{
				     if(datos!=0)
					 {
						 $.ajax({
					      type:'POST',
						  dataType:'html',
						  url: 'consultas/matricula/obtenerSelectReservas.php',
						  data:'codigo='+codigo+'&grupo='+grupo+'&clase='+clase,
						  success: function(datos)
						  {
							  if(datos!=0)
							  {
								  if(opcion==4)
								  {
									 $("#detallereservas").html(datos);  
								  }
								  else if(opcion==5)
								  {
									$("#detallereservasgrupo").html(datos);  
								  }
								  else if(opcion==3)
								  {
									 $("#detallereservasasig").html(datos); 
								  }
								  else if(opcion==2)
								  {
									$("#detallereservasasigrupo").html(datos);  
								  }
					         }
					        }
			             }); 
						 
						 
					   }
					   else if(datos==0)
					   {
						 alertas("La asignatura no tiene reservas en el piso","Matriculas","error"); 	    
					   }
				 
				    }
		         });       
	           }
			  
   
    $(".checkboxreserva").live("click",function(){
	  
	   
	      if($(".checkboxreserva").is(":checked"))
           {	
	         var contador=0; 
			 
			$("#detallereservas input:checked").each( 
				function(i) { 
				  reserva=$(this).val(); 
				  contador+=1;
				 
			});
			
				if(contador==1)
				{  
				    Asignatura=$("#codigoAsig").val();
					Grupo=$("#codGrupo").val();
					obtenerSalas(Asignatura,Grupo,reserva,1); 
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
				    Asignatura=$("#codA").val();
					Grupo=$("#codG").val();
					obtenerSalas(Asignatura,Grupo,reserva,2);
				}
				else if(contador > 1)
				{
					alertas("Por favor seleccione una sola reserva","Modificar matricula Asignatura","error")
				}
				
		   }
		   else
		   {
			    alertas("Por favor seleccione una reserva","Modificar matricula Asignatura","error")
		   }
	  
	  
	  });
	  
	  
	  $(".checkboxreservagrupo").live("click",function(){
	  
	   
	      if($(".checkboxreservagrupo").is(":checked"))
           {	
	         var contador=0; 
			 
			$("#detallereservasgrupo input:checked").each( 
				function(i) { 
				  reserva=$(this).val(); 
				  contador+=1;
				 
			});
			
				if(contador==1)
				{  
				     Asignatura=$("#CAsignatura").val();
					 Grupo=$("#newgrupo").val();
					 obtenerSalas(Asignatura,Grupo,reserva,3); 
				}
				else if(contador > 1)
				{
					alertas("Por favor seleccione una sola reserva","Modificar matricula","warning")
				}
				
		   }
		   else
		   {
			    alertas("Por favor seleccione una reserva","Modificar matricula","warning")
		   }
	  
	  
	  });
	  
	  $(".checkboxreservaasiggrupo").live("click",function(){
	  
	   
	      if($(".checkboxreservaasiggrupo").is(":checked"))
           {	
	         var contador=0; 
			 
			$("#detallereservasasigrupo input:checked").each( 
				function(i) { 
				  reserva=$(this).val(); 
				  contador+=1;
				 
			});
			
				if(contador==1)
				{  
					 Asignatura=$("#codA").val();
					 Grupo=$("#newgrupoAsig").val();
					 obtenerSalas(Asignatura,Grupo,reserva,4);
				}
				else if(contador > 1)
				{
					alertas("Por favor seleccione una sola reserva","Modificar matricula","warning")
				}
				
		   }
		   else
		   {
			    alertas("Por favor seleccione una reserva","Modificar matricula","warning")
		   }
	  
	  
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
     
        
     <div id="consasignatura" class="text ui-widget-content ui-corner-all" style="width:650px;  margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
     
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MATRICULAS - MODIFICAR POR USUARIO</div>
           
        <table style="margin-left:20px;">
        <tr>
        <td><label style="padding-right:4px;">Codigo:</label></td>
        <td><input name="codusu" type="text" id="codusu" value="" class="text ui-widget-content ui-corner-all height font12" title="Presione enter dentro del cajon de texto para realizar la consulta" /></td>
        
        </tr>
       </table>
       
       <table style="margin-left:20px;">
        <tr>
        <td><label>Nombre:</label></td>
        <td><input name="nomusu" type="text" class="text ui-widget-content ui-corner-all height font12" id="nomusu" size="40" value= "" /></td>
        </tr>
        </table>
        
        <table  style="margin-left:20px;">
        <tr>
        <td><button type="button" id="limpiarpantallauser" title="Limpia la pantalla " style="font-size:11px;margin-bottom:5px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/>Limpiar</button></td>
        </tr>
        </table>
         
         
         <table style="margin-left:15px;">
          <tr id="ocultarcheckboxusuario">
           <td> <label>Seleccionar Todos:</label></td>
           <td> <input type="checkbox" id="checkalluser"/></td>
          </tr>    
        </table> 
        
        <div id="tabladinamica">
        
        </div>
        
        <table style="margin-left:20px;">
        <tr id="matriculau">
        <td><label>Modificar Matricula por Usuario:</label></td>
        <td><select id="modmatusuario" size="1">
        <option value="seleccione">Seleccione </option>
        <option value="adicasig">Adicionar Asignatura </option>
        <option value="changegrupo">Cambiar Grupo </option>
        <option value="changepc">Cambiar Computador </option>
        <option value="cruceComp">Cruce Computador </option> 
        <option value="cancelAsigUsu">Cancelar Asignatura</option>   
        </select>
        </td>
        </tr>
        </table>
        
        </div>
        
        <!--Formulario que adiciona una asignatura en la matricula de un estudiante -->
        
     
     
     <div id="adicAsignatura" class="text ui-widget-content ui-corner-all" style="width:650px; margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
     
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MATRICULAS - ADICIONAR ASIGNATURA</div>
           
        <table style="margin-left:15px;">
        <tr>
        <td><label>Codigo:</label></td>
        <td><input name="" type="text" id="codigoAsig" size="20" value= "" class="text ui-widget-content ui-corner-all height font12" /></td>
        <td><label>Grupo:</label></td>
        <td><input name="" type="text" id="codGrupo" size="5" value= "" class="text ui-widget-content ui-corner-all height font12" title="Presione enter dentro del cajon de texto para realizar la consulta" /></td>
        <td><label>Sala No:</label></td>
        <td><select id="salaNo" size="1" class="Salas"> 
         <option value="Seleccione">Seleccione</option>
         
        </select></td>
      
        <td><input name="" type="hidden" id="HorarioMMat" size="5" value= ""  /></td>
        </tr>
        </table>
        
        
      <div id="detallereservas" style="margin-left:15px;"></div>
       
       <table style="margin-left:15px;">
            <tr>
            <td><button type="button" id="Adicionar" style="font-size:11px; margin-bottom:5px; margin-top:5px;" ><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Adicionar</button></td>
            </tr>
        </table>
        
      </div> 
        
        
        <!--Formulario que cambia el grupo de la asignatura en la matricula de un estudiante -->
        
       
       <div id="Cambiargrupo" class="text ui-widget-content ui-corner-all" style="width:650px;  margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
       
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MATRICULAS - CAMBIAR GRUPO</div>
         
        <table style="margin-left:15px;">
        <tr>
        <td><label>Codigo:</label></td>
        <td><input name="" type="text" id="CAsignatura" size="15" class="text ui-widget-content ui-corner-all height font12" title="Haga doble click dentro de la caja de texto y seleccione la opcion para traer el codigo de la asignatura "/></td>
        <td><label>Nuevo Grupo:</label></td>
        <td><input name="" type="text" id="newgrupo" size="5" class="text ui-widget-content ui-corner-all height font12" /></td>
        <td><label>Sala No:</label></td>
        <td><select id="SalaGrupo" size="1"  class="SalaGrupo"> 
         <option value="Seleccione">Seleccione</option>
          </select></td>
        </tr>
        </table>
        
         <div id="detallereservasgrupo" style="margin-left:15px;"></div>
         
        <table style="margin-left:15px;">
        <tr>
           <td><button type="button" id="cambiarGrupoMat" style="font-size:11px;margin-bottom:5px; margin-top:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Cambiar Grupo</button></td>
        </tr>
        </table>
        
       </div>
        
        <!-- Formulario que cambia el computador asignado a un estudiante --> 
        
        
       
       <div id="Cambiarpc" class="text ui-widget-content ui-corner-all" style="width:400px;  margin-bottom:10px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y"><div style="float:right" id="closepcuser" title="Cerrar ventana"><img src="images/close1.png"/></div>
       
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">COMPUTADORES DISPONIBLES</div> 
        
          <div id="PcsDispUser"></div>
          
          <table style="margin-left:15px;">
        <tr>
        <td><button type="button" id="cambiarpcmat" style="font-size:11px; margin-bottom:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Cambiar Computador</button></td>
        </tr>
        </table>
        
        </div>
        
        
        
        <div id="CRComputador" class="text ui-widget-content ui-corner-all" style="width:600px;  margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y"><div style="float:right" id="closecruceuser" title="Cerrar ventana"><img src="images/close1.png"/></div>
        
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MATRICULAS - CRUCE COMPUTADOR</div>
        
        <table style="margin-left:15px;">
         <tr>
          <td><button id="interchangepc" title="Consulta los usuarios matriculados en la asignatura" style="font-size:11px; margin-bottom:5px; margin-top:5px;"><img src="images/users1.png" style="vertical-align:middle; padding-right:4px;"/>Consultar Usuarios</button></td>
          </tr>
        </table>
        
        <div id="detallepcs">
        
        </div> 
        
        <table style="margin-left:15px;">
         <tr>
          <td><button type="button" id="crucepc" style="font-size:11px; margin-bottom:5px; margin-top:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>
        </tr>
        </table>
        
        </div>
              
      </div><!-- cierro div matusuario-->
      
      <div id="matasignatura">
       
     
        
      <div id="adicAsignatura" class="text ui-widget-content ui-corner-all" style="width:650px;  margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
      
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MATRICULAS - MODIFICAR POR ASIGNATURA</div>
           
        <table style="margin-left:20px;">
        <tr>
        <td><label style="padding-right:23px;">Codigo:</label></td>
        <td><input name="codA" type="text" id="codA" value="" size="20" class="text ui-widget-content ui-corner-all height font12"/></td>
        <td><label>Grupo:</label></td>
        <td><input name="codG" type="text" id="codG" value="" size="5" class="text ui-widget-content ui-corner-all height font12" /></td>
        <tr>
        </table>
        
        <table style="margin-left:20px;">
        <tr>
        <td><label>Asignatura:</label></td>
        <td><input name="nomA" type="text" id="nomA" class="text ui-widget-content ui-corner-all height font12" value="" size="50" /></td>
        </table>
        
        <table style="margin-left:20px;">
        <tr>
        <td><button id="limpiarpantallaasig" style="font-size:11px; margin-bottom:10px; margin-top:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/>Limpiar</button></td>
         <td><input name="nomA" type="hidden" id="valorhorario" class="text ui-widget-content ui-corner-all" value="" size="30" /></td>
        </tr>
        </table>
         
         <table style="margin-left:20px;">
          <tr id="ocultarcheckbox">
           <td> <label>Seleccionar Todos:</label></td>
           <td> <input type="checkbox" id="checkallAsig"/></td>
          </tr>    
        </table> 
         
        <div id="tabladinamica1">
        
        
        </div>
        
        <table style="margin-left:20px;">
        <tr id="matriculaA">
        <td><label>Modificar Matricula por Asignatura:</label></td>
        <td><select id="modmatasig" size="1">
            <option value="seleccione">Seleccione </option>
            <option value="adicest">Adicionar Estudiantes </option>
            <option value="cambiarGrupoA">Cambiar Grupo </option>
            <option value="cambiarComputadorA">Cambiar Computador </option>
            <option value="cruceCompAsig">Cruce Computador </option>
            <option value="cancelarEstAsig">Cancelar Estudiantes</option>
        </select>
        </td>
        </tr>
        </table> 
        </div>
        
        
        
      <div id="adicUsuarios" class="text ui-widget-content ui-corner-all" style="width:650px;  margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
      
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MATRICULAS - ADICIONAR ESTUDIANTES</div>
          
        <table style="margin-left:15px; margin-bottom:15px;">
        <tr>
        <td><label>Codigo Usuario:</label></td>
        <td><input type="text" id="coduser"class="text ui-widget-content ui-corner-all height font12" title="Presione enter dentro del cajon de texto para matricular al usuario una asignatura"/></td>
        <td><label>Sala No:</label></td>
        <td><select id="Salas1" size="1" class="Salas1"> <option value="0">Seleccione</option></select></td>
        <td><img src="images/add1.png" id="addestudiantes" title="De click en este boton para matricular al usuario una asignatura" /></td>
        </tr>
        </table>
        
        <div id="detallereservasasig" style="margin-left:15px; margin-bottom:10px;"></div>
       
        </div>
        
       <div id="Cambiargrupoasignatura" class="text ui-widget-content ui-corner-all" style="width:650px;  margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
       
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MATRICULAS - CAMBIAR GRUPO ASIGNATURA</div>
         
        <table style="margin-left:15px;">
        <tr>
        <td><label>Nuevo Grupo:</label></td>
        <td><input name="" type="text" id="newgrupoAsig" size="5" class="text ui-widget-content ui-corner-all height font12" /></td>
        <td><label>Sala No:</label></td>
        <td><select id="SalaGrupoAsig" size="1"  class="SalaGrupoAsig"> 
         <option value="Seleccione">Seleccione</option>
          </select></td>
        </tr>
        </table>
        
        <div id="detallereservasasigrupo" style="margin-left:15px;"></div>
        
        <table style="margin-left:15px;">
        <tr>
           <td><button type="button" id="cambiarGrupoMatAsignatura" style="font-size:11px;margin-bottom:5px; margin-top:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Cambiar Grupo</button></td>
        </tr>
        </table>
        
       </div> 
       
       
       <div id="Cambiarpcasignatura" class="text ui-widget-content ui-corner-all" style="width:400px;  margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y"><div style="float:right" id="closepcasig" title="Cerrar ventana"><img src="images/close1.png"/></div>
       
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">COMPUTADORES DISPONIBLES</div> 
        
          <div id="PcsDispAsig"></div>
        
        <table style="margin-left:15px;">
        <tr>
        <td><button type="button" id="cambiarpcmatAsig" style="font-size:11px; margin-bottom:5px; margin-top:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Cambiar Computador</button></td>
        </tr>
        </table>
        
        </div>
        
      </div> <!-- cierro div matasignatura-->
      
     </div> <!-- cierro div tabs-->   
    
    <div id="alertas"></div> 
    <div id="CanMatriculaEstudiantes"><p style="font-size:11px;"><img src="images/dialog-warning.png" style="float:left; padding:5px;"/>ESTA SEGURO QUE QUIERE CANCELAR LA MATRICULA A ESTE(OS) ESTUDIANTES?</p></div> 
     <div id="DialogCancelAsig"><p style="font-size:11px;"><img src="images/dialog-warning.png" style="float:left; padding:5px;"/>ESTA SEGURO QUE QUIERE CANCELAR LA(S) ASIGNATURA(S) A ESTE ESTUDIANTE?</p></div>         
</body>
</html>
<?php
mysql_free_result($JRGrupo);
?>