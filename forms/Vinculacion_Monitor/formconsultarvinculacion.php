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
  
								  
					
	function consultarTurnos(vinculacion)
	{
	
	    var opcion=1;
		
		 $.ajax({
						   
				type: 'POST',
				url: 'consultas/Monitores/consultarTurnos.php',
				data: 'idVinculacion='+vinculacion+'&opcion='+opcion,
							 
			   success: function(datos)
			   {
								 
				$("#turnos").html(datos);				 
			  }
	   });
	}
							   
							

    $(".checkboxvinculacion").live("click",function(){
	  
	   
	      if($(this).is(":checked"))
           {	
	         var contador=0; 
			 
			$("#vinculacion input:checked").each( 
				function(i) { 
				  valor=$(this).val(); 
				  contador+=1;
				 
			});
			
				if(contador==1)
				{  
				   consultarTurnos(valor);
				 
				}
				else if(contador > 1)
				{
					alertas("Por favor seleccione una sola vinculacion","Consultar Vinculacion Monitor","warning")
				}
				
		   }
	  
	  });
	  
	  $("#limpiarform").button().click(function(){
		  
		 $("#cedula").val("");
		 $("#nombre").val("");
		 $("#vinculacion").empty();
		 $("#turnos").empty();
		 $("#cedula").focus();
		  
	 });

	
}); // cierra el function
</script>



</head>

<body>
 
 <p id="validateErrors"></p>
 
<div id="formReservaE" class="text ui-widget-content ui-corner-all" style="width:420px; height:auto; font-size:12px; margin-bottom:10px;">
  <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CONSULTAR VINCULACION</div>
          
    <table style="margin-left:15px; margin-bottom:10px;">
   
        <tr>
         <td><label for="cedula">Cedula:</label></td>
         <td><input type="text"  id="cedula" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td> 
        </tr>
       
        <tr>
          <td><label for="nombre">Nombre:</label></td>
          <td><input type="text"  id="nombre" size="40" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
        
        <tr>
        <td> <button type="button" id="enviar" style="font-size:11px; margin-top:10px; "><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button> </td>
         <td><button type="button" id="limpiarform" style="font-size:11px; margin-top:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/> Limpiar</button></td>
        </tr>
     </table>
        
       </div> 
       
       <!--   div que muestra la informacion de las vinculaciones-->
       <div  id="vinculacion"></div>
       
       <!-- div que muestra la informacion de los turnos de un monitor -->
       <div id="turnos" style="width:400px; height:auto; margin-bottom:10px;"></div>   
          
	  <div id="alertas"></div>
  
</body>
</html>

