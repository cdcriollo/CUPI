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



<script type="text/javascript">

$(function(){
	
  $("#cedula").focus();  
  var cadenaturnos= new Array();
  $.datepicker.setDefaults($.datepicker.regional['es']);
  
  $("#comienzo").datepicker({ 
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
		
							 
// Adiciona un horario a la reserva
$("#adicturno").click(function(){   

 $("#divturno").css({width:"560px", height:"auto"});
  

$("#turnos_monitor").append('<tbody><td><input name="horario" type="checkbox" class="schedule"  value="i" /></td><td><select id="dia" size="1" class="turno"><option value="1">Lunes</option><option value="2">Martes</option><option value="3">Miercoles</option><option value="4">Jueves</option><option value="5">Viernes</option><option value="6">Sabado</option></select></td> <td><select name= "horainicial" id="horainicial" class="turno" style="margin-left:6px;"><option value="06:30:00">06:30</option><option value="07:00:00">07:00</option><option value="07:30:00">07:30</option><option value="08:00:00">08:00</option><option value="08:30:00">08:30</option><option value="09:00:00">09:00</option><option value="09:30:00">09:30</option><option value="10:00:00">10:00</option><option value="10:30:00">10:30</option><option value="11:00:00">11:00</option><option value="11:30:00">11:30</option><option value="12:00:00">12:00</option><option value="12:30:00">12:30</option><option value="13:00:00">13:00</option><option value="13:30:00">13:30</option><option value="14:00:00">14:00</option><option value="14:30:00">14:30</option><option value="15:00:00">15:00</option><option value="15:30:00">15:30</option><option value="16:00:00">16:00</option><option value="16:30:00">16:30</option><option value="17:00:00">17:00</option><option value="17:30:00">17:30</option><option value="18:00:00">18:00</option><option value="18:30:00">18:30</option><option value="19:00:00">19:00</option><option value="19:30:00">19:30</option><option value="20:00:00">20:00</option><option value="20:30:00">20:30</option><option value="21:00:00">21:00</option><option value="21:30:00">21:30</option><option value="22:00:00">22:00</option><option value="22:30:00">22:30</option></select></td><td><select name= "horafinal" id="horafinal" class="turno" style="margin-left:6px;"><option value="06:30:00">06:30</option><option value="07:00:00">07:00</option><option value="07:30:00">07:30</option><option value="08:00:00">08:00</option><option value="08:30:00">08:30</option><option value="09:00:00">09:00</option><option value="09:30:00">09:30</option><option value="10:00:00">10:00</option><option value="10:30:00">10:30</option><option value="11:00:00">11:00</option><option value="11:30:00">11:30</option><option value="12:00:00">12:00</option><option value="12:30:00">12:30</option><option value="13:00:00">13:00</option><option value="13:30:00">13:30</option><option value="14:00:00">14:00</option><option value="14:30:00">14:30</option><option value="15:00:00">15:00</option><option value="15:30:00">15:30</option><option value="16:00:00">16:00</option><option value="16:30:00">16:30</option><option value="17:00:00">17:00</option><option value="17:30:00">17:30</option><option value="18:00:00">18:00</option><option value="18:30:00">18:30</option><option value="19:00:00">19:00</option><option value="19:30:00">19:30</option><option value="20:00:00">20:00</option><option value="20:30:00">20:30</option><option value="21:00:00">21:00</option><option value="21:30:00">21:30</option><option value="22:00:00">22:00</option><option value="22:30:00">22:30</option></select></td><td><input type="text"  size="25" class="actividad turno text ui-widget-content ui-corner-all" id="actividad" title="De click dentro del cajon de texto para mostrar la fecha"/></td></tbody>');
			 			  
});


$("#adicvinculacion").click(function(){   
 i++;
 
$("#vinc_monitor").append('<tbody><td><input name="horario" type="checkbox" class="schedule"  value="i" /></td><td><input type="text" size="20" class="source text ui-widget-content ui-corner-all" id="comienzo'+i+'"/></td><td><input type="text" size="20" class=" source text ui-widget-content ui-corner-all" id="finalizacion'+i+'"/></td><td><input type="text" size="10" class=" source text ui-widget-content ui-corner-all" id="totalhoras"/></td></tbody>');

     
			 			  
});

				 
  // Elimina un turno de la vinculacion
  $('#eliminar_turno').click(function(){
				  
	$("#turnos_monitor").find("input:checked").parents("tr").remove();
				
 });
 

  // Funcion que realiza la busqueda de un monitor
     function consultarmonitor(){

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
				     cedula=$('#cedula').val();
				
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
  
     $("#buscarmonitor").button().click(function() {
	  consultarmonitor();	
     });
	 
	 $("#limpiarmonitor").button().click(function() {
	   $("#nombre").val("");
	   $("#cedula").val("");
	   $("#cedula").focus();
     });
	 
	 $("#limpiarvinculacion").button().click(function() {
	   limpiarvinculacion();
	 });
	 
	  function limpiarvinculacion()
	  {
		$("#cedula").val("");
	    $("#comienzo").val("");
		$("#nombre").val("");
	    $("#final").val("");
	    $("#horamonitor").val("");
	    $("#totalhoras").val("");
	    $("#totalvinculacion").val("");	
	  }
	 
	 $("#cedula").keydown(function(event) {
	  
	     if (event.keyCode == '13') 
		 {
	        event.preventDefault();
			consultarmonitor();	
         } 
       });	
	   
	   $("#horamonitor").blur(function() {
	    var totalvinculacion= $("#horamonitor").val()*$("#totalhoras").val();
	    $("#totalvinculacion").val(totalvinculacion);
     });
	 
	 
	 $("#crearvinculacion").button().click(function () {
	
	   var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"comienzo",
					  validations:
					  {
					      required:[true,"El campo comienzo no puede estar vacio."],
						  
					  }
				  },
				  
				  {
					  id:"final",
					       validations:
						   {
					         required:[true,"El campo finalizacion no puede estar vacio."],
							
						   }				  
				  },
				  
				  {
					  id:"totalhoras",
					  validations:
					    {
						   required:[true,"El campo total horas semestre no puede estar vacio."],
						   number:[true,"El campo total horas semestre debe ser un valor numerico."],
						  
						}
				  },
				  
				  {
					  id:"horamonitor",
					  validations:
					    {
						   required:[true,"El campo valor hora monitor no puede estar vacio."],
						   number:[true,"El campo valor hora monitor debe ser un valor numerico."],
						  
						}
				  },
				  
				  {
					  id:"totalvinculacion",
					  validations:
					    {
						   required:[true,"El campo valor total vinculacion no puede estar vacio."],
						   number:[true,"El campo valor total vinculacion debe ser un valor numerico."],
						  
						}
				  }		
				   
				  							
				  ],
				  				  
				    beforeValidation:function()
				    { 
						// Capturo las variables del formulario 
						cedula= $("#cedula").val();
						comienzo= $("#comienzo").val();
						finalizacion= $("#final").val();
						valorhora=$("#horamonitor").val();
						horassemestre=$("#totalhoras").val();
						totalvinculacion=$("#totalvinculacion").val();
					
					   cadenaturnos=[];
						
						$(':input.turno').each(function(i){
							valor=$(this).val();
							cadenaturnos[i]=valor;
					   });
					   
					   $.ajax({
					   
						 type: 'POST',
						 dataType:'json',
						 url: 'funciones/Monitores/insertarvinculacion.php',
						 data: 'cedula='+cedula+'&comienzo='+comienzo+'&finalizacion='+finalizacion+'&valorhora='+valorhora+'&arrayturnos='+cadenaturnos+'&horassemestre=                         '+horassemestre+'&totalvinculacion='+totalvinculacion,
						 
						 success: function(datos)
						 {
							 if(datos.error==0)
							 {
								 alertas("La vinculacion se creo exitosamente","Vincular Monitor","done"); 
								 limpiarvinculacion();
								  
							 }
							 else if(datos.error==1)
							 {
								 alertas("No fue posible crear la vinculacion, por favor intente mas tarde","Vincular Monitor","error"); 
							 }
						 }
					   });
					}
				   }; 
				  $.validation(options);   	 
		 
	     });
	  
    }); // cierra jquery
</script>



</head>

<body>
 
 <p id="validateErrors"></p>
 
<div id="formReservaE" class="text ui-widget-content ui-corner-all" style="width:420px; height:auto; font-size:12px; margin-bottom:5px;">
  <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">VINCULAR MONITOR</div>
          
    <table style="margin-left:15px; margin-bottom:10px;">
       <tr>
         <td><label for="titulo">Cedula:</label></td>
         <td><input type="text"  id="cedula" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td> 
       </tr>
       
        <tr>
          <td><label for="titulo">Nombre:</label></td>
          <td><input type="text"  id="nombre" size="45" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
     </table>
   </div> 
       
    <table>
      <tr>
        <td><button id="buscarmonitor"  style="font-size:11px; margin-top:5px; margin-bottom:5px;"><img src="images/aceptar.png" style=" vertical-align:middle; padding-right:4px;"/>Aceptar</button>
        </td>
        <td><button id="limpiarmonitor"  style="font-size:11px; margin-top:5px; margin-bottom:5px;" ><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/>Limpiar</button>
        </td>
      </tr>
   </table>
       
     <div id="div_vinculacion" class="text ui-widget-content ui-corner-all" style="width:600px; height:auto; font-size:12px; margin-bottom:10px;">
       <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">VINCULACION</div>
     
    <table id="vinc_monitor" style="margin-left:15px;">
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
       <td>$  <input type="text" id="horamonitor" class="text ui-widget-content ui-corner-all height font12"/> </td>
    </tr> 
    </table>
    
    <table style="margin-left:15px;">
     <tr> 
      <td><label for="totalvinculacion">Valor Total de la Vinculacion:</label></td>
      <td>$  <input type="text" id="totalvinculacion" class="text ui-widget-content ui-corner-all height font12"/></td>
    </tr>    
   </table>
   </div>  
   
       <div id="divturno" class="text ui-widget-content ui-corner-all" style="width:420px; height:auto; font-size:12px; margin-bottom:10px;">
         <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">TURNO</div>
     
     <p><img src="images/add1.png" id="adicturno" title="Adiciona un horario a la reserva" style="padding-right:2px;"/> <img src="images/delete.png" id= "eliminar_turno" title="Elimina un horario de la reserva" style="padding-right:3px;"/></p>
     
     
    
    <table id="turnos_monitor" style="margin-left:15px;">
    <thead>
        <th></th>    
    	<th>Dia</th>
        <th>Hora Entrada</th>
        <th>Hora Salida</th>
        <th>Actividad</th>
    </thead>   
  </table>
   </div>   
   
 
   <table>
   <tr><td><button id="crearvinculacion"  style="font-size:11px; margin-top:5px;" ><img src="images/aceptar.png" style=" vertical-align:middle; padding-right:4px;"/>Aceptar</button></td><td><button id="limpiarvinculacion"  style="font-size:11px; margin-top:5px;" ><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/>Limpiar</button></td></tr>
   
   </table>
   
   <div id="alertas"></div>
  
</body>
</html>

