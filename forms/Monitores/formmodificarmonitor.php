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

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cupi-Control de Utilizacion Piso Informatico</title>

<script type="text/javascript" >

$(function () {
	
	var estado="";
	
	$('#codigo').attr('disabled','disabled');
	$('#nombres').attr('disabled','disabled');
	$('#apellidos').attr('disabled','disabled');
	$('#programa').attr('disabled','disabled');
	$('#direccion').attr('disabled','disabled');
	$('#telefono').attr('disabled','disabled');
	$('#celular').attr('disabled','disabled');
	$('#email').attr('disabled','disabled');
	$('#estado').attr('disabled','disabled');
	
	$('#formupdnombre').hide();
	$('#formupdapellido').hide();
	$('#formupdprograma').hide();
	$('#formupddireccion').hide();
	$("#formupdtelefono").hide();
	$("#formupdcelular").hide();
	$("#formupdemail").hide();
	$("#formupdestado").hide();
	$("#formupdcodigo").hide();
	$("#formupdcedula").hide();
	
	$("#updcedula").hide();
	$("#updcodigo").hide();
	$('#updnombres').hide();
	$('#updapellidos').hide();
	$('#updprograma').hide();
	$('#upddireccion').hide();
	$('#updcelular').hide();
	$('#updtelefono').hide();
	$('#updemail').hide();
	$('#updestado').hide();
	$("#updcedula").hide();
	$("#cedula").focus();	
    
	$('#updcedula').toggle(function(){
	 
	    $('#formupdcedula').show("slide");
		$("#newcedula").val($("#cedula").val())
        },function() {
        $("#formupdcedula").hide("slide");
		$("#newcedula").val("");
	});

	$('#updcodigo').toggle(function(){
	 
	    $('#formupdcodigo').show("slide");
		$("#newcode").val($("#codigo").val())
        },function() {
        $("#formupdcodigo").hide("slide");
		$("#newcode").val("");
	});
	
	
	$("#updnombres").toggle(function() {
	     $('#formupdnombre').show("slide");
		 $("#newfirstname").val($("#nombres").val());
		 
     },function() {
		 
         $("#formupdnombre").hide("slide");
		 $("#newfirstname").val("");
     });	
	
	$('#updapellidos').toggle(function(){
	
	     $('#formupdapellido').show("slide");
		 $("#newlastname").val($("#apellidos").val());
        },function() {
        $("#formupdapellido").hide("slide");
		$("#newlastname").val("");
	});
	
	$('#updprograma').toggle(function(){
	 
	     $('#formupdprograma').show("slide");
		 $("#newprograma").val($("#programa").val());
        },function() {
          $("#formupdprograma").hide("slide");
		  $("#newprograma").val("");
	});
	
	$('#upddireccion').toggle(function(){
	     $('#formupddireccion').show("slide");
		 $("#newdireccion").val($("#direccion").val());
         },function() {
         $("#formupddireccion").hide("slide");
		 $("#newdireccion").val("");
		
	});
	
	$('#updcelular').toggle(function(){
	
	       $('#formupdcelular').show("slide");
		   $("#newcelular").val($("#celular").val());
         },function() {
         $("#formupdcelular").hide("slide");
		  $("#newcelular").val("");
	});
	
	$('#updtelefono').toggle(function(){
	
	       $('#formupdtelefono').show("slide");
		   $("#newtelefono").val($("#telefono").val());
         },function() {
         $("#formupdtelefono").hide("slide");
		  $("#newtelefono").val("");
	});
	
	$('#updemail').toggle(function(){
	
	      $('#formupdemail').show("slide");
		  $("#newemail").val($("#email").val());
         },function() {
         $("#formupdemail").hide("slide");
		  $("#newemail").val("");
	});
	
	$('#updestado').toggle(function(){
	     $('#formupdestado').show("slide");
         },function() {
         $("#formupdestado").hide("slide");
		  
	});
	
	
   $("#cedula").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') {
	  
	     event.preventDefault();
		 cedula=$("#cedula").val();
	     consultarMonitor(cedula);
		 
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
	
	
	
     $('.aceptar').button().click(function(){
	
	        cedula=$('#cedula').val();
			arrayupdate=$(this).attr('class').split(' ');
	        idupdate=arrayupdate[1];
			formulario= arrayupdate[2];
			var CMonitor;
			
			if(idupdate=="newestado"){
				id=$(this).parents().find('select#'+idupdate).attr('id'); 
				nuevovalor=$('#'+id).val();	 
			 }
			 else
			 {
			  id=$(this).parents().find('input#'+idupdate).attr('id');
		      nuevovalor=$('#'+id).val();
			 }
				
			if(id=="cedula"){
			  campo="vccedula";
			} else if(id=="newcode"){
			  campo="vccodigo"	
			}else if(id=="newfirstname"){
			  campo="vcnombres";
			}else if(id=="newlastname"){
			  campo="vcapellidos";
			}else if(id=="newprograma"){
			  campo="vcprogramaacademico";
			}
			else if(id=="newdireccion"){
			  campo="vcdireccionresidencia";
			}
			else if(id=="newcelular"){
			  campo="vccelular";
			}
			else if(id=="newtelefono"){
			  campo="vctelefonofijo";
			}
			else if(id=="newemail"){
			  campo="vcemail";
			}
			else if(id=="newestado"){
			  campo="vcestado";
			}else if(id=="newcedula"){
			campo="vccedula";	
			}
			
			
	       if( nuevovalor!="")
		   {
		       $.ajax({
			  
					 type: 'POST',
					 url: 'funciones/Monitores/actualizarMonitor.php',
					 data: 'campo='+campo+'&nuevovalor='+nuevovalor+'&valorllave='+cedula,
					 success: function(datos)
					 {
						 
						 if(datos!=0)
						   {
					
							    alertas("Los datos se han modificado exitosamente","Modificar Monitor","done");
								if(id=="newcedula"){
								  CMonitor= nuevovalor;	
								}
								else{
								   CMonitor=$("#cedula").val();	
								}
								//var CMonitor=$("#cedula").val();
							    consultarMonitor(CMonitor);
								$("#"+formulario).hide();
								$("#"+idupdate).val("");
								
							}
									
					  else
					  {
						  alertas("Por favor verifique los datos","Modificar Monitor","error");
					  }
				  }
		        
			   });
			  }
			  else
			  {
			     alertas("Por favor digite el nuevo texto para modificar el campo","Modificar Monitor","error");
			  }  
	       });
	
	
	 $("#Actualizarcodigo").button().click(function(){
	 
	    campo="codUsuario"
		nuevovalor=$("#nuevocod").val();
		valorllave=$("#codusu").val();
		verificarExistenciaUsuario(campo,nuevovalor,valorllave);
	 
	 });
	 
	function actualizarcodigousuario(campo,nuevovalor,codigo)
	{
	   $.ajax({
			  
		 type: 'POST',
		 url: 'funciones/Usuario/ActualizarUsuario.php',
		 data: 'campo='+campo+'&nuevovalor='+nuevovalor+'&valorllave='+codigo,
		 success: function(datos){
		   if (datos!=0) 
		   {
		       alertas("Los datos se han modificado exitosamente","Modificar Usuario","done");
			   consultarUsuario(nuevovalor);
			   $("#formcod").hide();
			   $("#nuevocod").val("");
			   
			 
		   }
		   else
		   {
		    alertas("Ha ocurrido un error","Modificar Usuario","error");
		   }
		 }
	  }); 
		 
	}
	
	
	$("#actualizarEstado").button().click(function(){
	  
	   if($("#Estado").is(":checked"))
	   {
	       campo="estado";
		   nuevovalor="activo";
		   codigoUsuario= $("#codusu").val();
		   
	       $.ajax({
			  
			 type: 'POST',
			 url: 'funciones/Usuario/ActualizarUsuario.php',
			 data: 'campo='+campo+'&nuevovalor='+nuevovalor+'&valorllave='+codigoUsuario,
			 success: function(datos)
			 {
			 
			   if (datos!=0) 
			   {
				   alertas("Los datos se han modificado exitosamente","Modificar Usuario","done");
				   consultarUsuario(codigoUsuario);
				   $("#formestado").hide();
				   $("#Estado").attr('checked', false);
			   }
			   else
			   {
				alertas("Ha ocurrido un error","Modificar Usuario","error");
			   }
			 }
		  }); 
	   }
	   else
	   {
	      alertas("Por favor marque la opcion","Modificar Usuario","error");
	   } 
	});
	
	
  $('#enviar').button().click(function(){
	  
	codigousuario=$("#codusu").val();
	consultarUsuario(codigousuario); 
	
  });
  
  
     function verificarExistenciaUsuario(campo,nuevovalor,valorllave)
    {
		
		    if (nuevovalor!="")
		    {
		      $.ajax({
			
				 type:'POST',
				 url:'consultas/Usuario/existenciausuario.php',
				 data: 'codigoU='+nuevovalor,
				 success: function(datos){
			
		         if (datos==1)
				 {
				
					$("#nuevocod").val("");
					$("#nuevocod").addClass("ui-state-error");
					alertas("El usuario ya existe en la base de datos","Modificar Usuario","error");	
				
				}
				else
				{
					$("#nuevocod").removeClass("ui-state-error");
					actualizarcodigousuario(campo,nuevovalor,valorllave)
				}
		      }
	         });
	       }
		 }	




  function consultarMonitor(cedula)
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
				 
				  beforeValidation:function(){
	  
               $.ajax({
					 type:'POST',
					 dataType:'json',
					 url: 'consultas/Monitores/consultarMonitor.php',
					 data:'cedula='+cedula,
					 success: function(datos){
						 
						      if(datos.error==0) 
							  {			
								 $("#cedula").val(datos.cedula);
								 $("#codigo").val(datos.codigo);
							     $("#nombres").val(datos.nombres);
								 $("#apellidos").val(datos.apellidos);
								 $("#programa").val(datos.programa);
								 $("#direccion").val(datos.direccion);
								 $("#celular").val(datos.celular);
								 $("#telefono").val(datos.telefono);
								 $("#email").val(datos.email);
								 $("#estado").val(datos.estado);
								 
								 $('#cedula').attr('disabled','');
	                             $('#codigo').attr('disabled','');
	                             $('#nombres').attr('disabled','');
								 $('#apellidos').attr('disabled','');
								 $('#direccion').attr('disabled','');
								 $('#programa').attr('disabled','');
								 $('#telefono').attr('disabled','');
								 $('#celular').attr('disabled','');
								 $('#email').attr('disabled','');
								 
								 $("#updcedula").show();	
								 $("#updcodigo").show();	
								 $('#updnombres').show();
							     $('#updapellidos').show();
							     $('#updprograma').show(); 
								 $('#upddireccion').show(); 
								 $('#updtelefono').show();
								 $('#updcelular').show();
								 $('#updemail').show(); 
								 $('#updestado').show(); 
							
								 
								}
								else if(datos.error==1)
								{
									alertas("El monitor no existe o no esta activo en el sistema","Modificar Monitor","error");
									
								}
								
							  }
			});

	    }
	
	  };
	  $.validation(options);   		
  
}

		
	     function limpiarform()
		 {		
		   $("#codusu").val("");
		   $("#nomusu").val("");	
		   $("#estamento").val("");	
		   $("#dependencia").val("");	
		   $("#estado").val("");
		   $("#apellidos").val("");	
		   $("#codusu").focus();	
		 }
		 
		$("#limpiarform").button().click(function(){
			
			limpiarform();
			
	   }); 
	  
	
	
}); // cierra jquery

</script>

</head>

<body>

<p id="validateErrors"></p>

   <div class="text ui-widget-content ui-corner-all" style="width:500px; margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MODIFICAR MONITOR</div>      
          
       <table style="margin-left:15px;">
        <tr>
          <td><label>Cedula:</label></td>
          <td><input type="text" name="cedula" id="cedula" size="20"  class="text ui-widget-content ui-corner-all height font12" title="Presione enter dentro del cajon de texto para traer la consulta"/></td>
          <td><img src="images/code.png" id="updcedula"/></td>
        </tr>
        
        <tr>
          <td><label>Codigo:</label></td>
          <td><input type="text" name="codigo" id="codigo" size="20"  class="text ui-widget-content ui-corner-all height font12" title="Presione enter dentro del cajon de texto para traer la consulta"/></td>
          <td><img src="images/code.png" id="updcodigo"/></td>
        </tr>
       
        <tr>
        	<td><label>Nombres:</label></td>
            <td><input type="text" name="nombres" id="nombres" size="50" class="text ui-widget-content ui-corner-all height font12"/></td>
            <td> <img src="images/editar nombre.png" id="updnombres" title="Editar Nombres"/></td>      
        </tr>
        
        <tr>
        	<td><label>Apellidos:</label></td>
            <td><input type="text" name="apellidos" id="apellidos" size="50"  class="text ui-widget-content ui-corner-all height font12"/></td>
            <td> <img src="images/editar nombre.png" id="updapellidos" title="Editar Apellidos"/></td>      
        </tr>
        
        <tr>
          <td><label for="dependencia">Programa Academico:</label></td>
          <td><input type="text" name="programa" id="programa" size="50"  class="text ui-widget-content ui-corner-all height font12"/></td><td><img src="images/dependencia.png" id="updprograma" title="Editar programa academico" /></td>        
       </tr>
       
        <tr>
          <td><label for="estamento">Direccion Residencia:</label></td>
          <td><input type="text" name="direccion" id="direccion" size="50"  class="text ui-widget-content ui-corner-all height font12"/></td>
          <td> <img src="images/house.png" id="upddireccion" title="Editar direccion residencia" /></td>       
        </tr>
        
        <tr>
          <td><label for="estamento">Celular:</label></td>
          <td><input type="text" name="celular" id="celular" size="15"  class="text ui-widget-content ui-corner-all height font12"/></td>
          <td> <img src="images/mobile.png" id="updcelular" title="Editar celular" /></td>       
        </tr>
        
        <tr>
          <td><label for="estamento">Telefono Fijo:</label></td>
          <td><input type="text" name="telefono" id="telefono" size="15"  class="text ui-widget-content ui-corner-all height font12"/></td>
          <td> <img src="images/Telephone.png" id="updtelefono" title="Editar telefono" /></td>       
        </tr>
        
        <tr>
          <td><label for="estamento">Correo Electronico:</label></td>
          <td><input type="text" name="email" id="email" size="50"  class="text ui-widget-content ui-corner-all height font12"/></td>
          <td> <img src="images/email1.png" id="updemail" title="Editar correo" /></td>       
        </tr>
     
      <tr>
       <td><label>Estado:</label></td>
       <td><input type="text"  id="estado" size="15" class="text ui-widget-content ui-corner-all height font12" /></td>                    
       <td><img src="images/activo.png" id="updestado" title="Editar Estado" /></td>        
    </tr> 
   </table>
   
     
  <table style="margin-left:15px;">
   <tr>
     <td><button name="enviar" type="button"  id="enviar" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/aceptar.png" style="       vertical-align:middle; padding-right:4px;"/>Aceptar</button>
     </td>
     
     <td><button type="button" id="limpiarform" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/> Limpiar</button>
     </td>
  </tr>    
      
  </table>
  
 </div>
 
 <!-- Formulario modificacion cedula  -->
 <div id="formupdcedula" class="text ui-widget-content ui-corner-all" style="width:300px; margin-bottom:15px;  height:110px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nueva Identificación</div>      

<table style="margin-left:15px;">
<tr>
<td><label>Nueva identificación:</label></td>
<td ><input type="text" name="newcedula" id="newcedula" size="20" class="text ui-widget-content ui-corner-all"/></td>
</tr>
<tr>
<td><button name="updcedula" type="button" class="aceptar newcedula formupdcedula" style="font-size:11px;" ><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>

 
<div id="formupdcodigo" class="text ui-widget-content ui-corner-all" style="width:260px; margin-bottom:15px;  height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nuevo Codigo</div>      

<table style="margin-left:15px;">
<tr>
<td><label>Nuevo Codigo:</label></td>
<td ><input type="text" name="newcode" id="newcode" size="20" class="text ui-widget-content ui-corner-all"/></td>
</tr>
<tr>
<td><button name="updcodigo" type="button" class="aceptar newcode formupdcodigo" style="font-size:11px;" ><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>


 
<div id="formupdnombre" class="text ui-widget-content ui-corner-all" style="width:400px; margin-bottom:15px;  height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nuevo Nombre</div>      
 
<table style="margin-left:15px;">
<tr>
<td><label>Nuevo Nombre:</label></td>
<td><input type="text" name="newfirstname" id="newfirstname" size="40" class="text ui-widget-content ui-corner-all" value=""/></td>
</tr>
<tr>
<td><button name="updnombre" type="button" class="aceptar newfirstname formupdnombre" style="font-size:11px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>


<div id="formupdapellido" class="text ui-widget-content ui-corner-all" style="width:400px; margin-bottom:15px;  height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nuevo Apellido</div>      
 
<table style="margin-left:15px;">
<tr>
<td><label>Nuevo Apellido:</label></td>
<td><input type="text" name="newlastname" id="newlastname" size="40" class="text ui-widget-content ui-corner-all" value=""/></td>
</tr>
<tr>
<td><button name="updapellidos" type="button" class="aceptar newlastname formupdapellido" style="font-size:11px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>




<div id="formupdprograma" class="text ui-widget-content ui-corner-all" style="width:400px; margin-bottom:15px;  height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nuevo Programa</div>      
 
<table style="margin-left:15px;">
<tr>
 <td><label>Nuevo Programa:</label></td>
 <td><input type="text" name="newprograma" id="newprograma" size="40" class="text ui-widget-content ui-corner-all" value=""/></td>
</tr>
<tr>

<td><button  type="button" class="aceptar newprograma formupdprograma" style="font-size:11px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>

</table>

</div>
 

<div id="formupddireccion" class="text ui-widget-content ui-corner-all" style="width:400px; margin-bottom:15px;  height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nueva Direccion</div>      

<table style="margin-left:15px;">
<tr>
<td><label>Nueva Direccion:</label></td>
<td><input type="text" name="newdireccion" id="newdireccion" size="30" class="text ui-widget-content ui-corner-all" value="" title="Digite alguna letra dentro del cajon de texto para traer la lista de dependencias"/></td>
</tr>
<tr>
<td><button name="upddependencia" type="button" class="aceptar newdireccion formupddireccion" style="font-size:11px;" ><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>


<div id="formupdcelular" class="text ui-widget-content ui-corner-all" style="width:400px; margin-bottom:15px;  height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nuevo Celular</div>      

<table style="margin-left:15px;">
<tr>
<td><label>Nuevo Ceular:</label></td>
<td><input type="text" name="newcelular" id="newcelular" size="30" class="text ui-widget-content ui-corner-all" value="" title="Digite alguna letra dentro del cajon de texto para traer la lista de dependencias"/></td>
</tr>
<tr>
<td><button  type="button" class="aceptar newcelular formupdcelular" style="font-size:11px;" ><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>

<div id="formupdtelefono" class="text ui-widget-content ui-corner-all" style="width:400px; margin-bottom:15px;  height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nuevo Telefono</div>      

<table style="margin-left:15px;">
<tr>
<td><label>Nuevo Telefono:</label></td>
<td><input type="text" name="newtelefono" id="newtelefono" size="30" class="text ui-widget-content ui-corner-all" value="" title="Digite alguna letra dentro del cajon de texto para traer la lista de dependencias"/></td>
</tr>
<tr>
<td><button  type="button" class="aceptar newtelefono formupdtelefono" style="font-size:11px;" ><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>

<div id="formupdemail" class="text ui-widget-content ui-corner-all" style="width:400px; margin-bottom:15px;  height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nuevo Correo</div>      

<table style="margin-left:15px;">
<tr>
<td><label>Nuevo Correo:</label></td>
<td><input type="text" name="newemail" id="newemail" size="30" class="text ui-widget-content ui-corner-all" value="" title="Digite alguna letra dentro del cajon de texto para traer la lista de dependencias"/></td>
</tr>

<tr>
<td><button name="upddependencia" type="button" class="aceptar newemail formupdemail" style="font-size:11px;" ><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>



 
 <div id="formupdestado" class="text ui-widget-content ui-corner-all" style="width:350px; height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nuevo Estado</div>      

<table style="margin-left:15px;">
<tr>
<td><label>Activar/Desactivar Monitor:</label></td>
<td>
  <select size="1" id="newestado">
   <option value="activo">Activo</option>
   <option value="inactivo">Inactivo</option>
  </select>
</td>
</tr>
<tr>
<td><button type="button" class="aceptar newestado formupdestado" style="font-size:11px;" ><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>

  <div id="alertas" ></div> 
   
    
</body>

</html>
