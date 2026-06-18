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
		
		
		
		 $("#nores").keydown(function(event) {
	  
	       if (event.keyCode == '13') 
		   {
	         event.preventDefault();
			 numerores=$("#nores").val();
	         consultardatosreserva(numerores);
          } 
       });	
	   
	   
	   $("#grupo").keydown(function(event) {
	  
	       if (event.keyCode == '13') 
		   {
	         event.preventDefault();
			 codigo=$("#codasig").val();
			 grupo=$("#grupo").val();
	         consultardatosreserva(codigo,grupo);
          } 
       });	
	   
	   
    			
		function consultardatosreserva(codigo,grupo)
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
			    required:[true,"El campo No reserva no puede estar vacio."],					  
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
 
	function consultarHorarios(reserva)
	{
		opcion=1
	
		 $.ajax({
						   
				type: 'POST',
				url: 'consultas/ReservaEventual/consultarHorarios.php',
				data: '&reserva='+reserva+'&opcion='+opcion,
							 
			   success: function(datos)
			   {
								 
				$("#horario").html(datos);				 
			  }
	   });
	}
							   
							   
	function consultarRecursos(reserva)
	{
		opcion=1;
		
		  $.ajax({
						   
				type: 'POST',
				url: 'consultas/ReservaEventual/consultarRecursos.php',
				data: 'reserva='+reserva+'&opcion='+opcion,
							 
			   success: function(datos)
			   {
								 
				$("#recursosreserva").html(datos);				 
			  }
	   });								
	}



$(".checkboxreserva").live("click",function(){
	  
	   
	      if($(this).is(":checked"))
           {	
	         var contador=0; 
			 
			$("#reservas input:checked").each( 
				function(i) { 
				  valor=$(this).val(); 
				  contador+=1;
				 
			});
			
				if(contador==1)
				{  
				   consultarHorarios(valor);
				   consultarRecursos(valor)   
				}
				else if(contador > 1)
				{
					alertas("Por favor seleccione una sola reserva","Consulta Reserva Eventual","warning")
				}
				
		   }
	  
	  });
	  
	  $("#limpiarform").button().click(function(){
		  
		 $("#codasig").val("");
		 $("#grupo").val("");
		 $("#reservas").empty();
		 $("#horario").empty();
		 $("#recursosreserva").empty(); 
		 $("#codasig").focus();
		  
	 });

	
}); // cierra el function
</script>



</head>

<body>
 
 <p id="validateErrors"></p>
 
<div id="formReservaE" class="text ui-widget-content ui-corner-all" style="width:420px; height:auto; font-size:12px; margin-bottom:10px;">
  <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CONSULTAR RESERVA</div>
          
    <table style="margin-left:15px; margin-bottom:10px;">
   
        <tr>
         <td><label for="titulo">Codigo Asignatura:</label></td>
         <td><input type="text"  id="codasig" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td> 
        </tr>
       
        <tr>
          <td><label for="titulo">Grupo:</label></td>
          <td><input type="text"  id="grupo" size="5" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
        
        <tr>
         <td><button type="button" id="limpiarform" style="font-size:11px; margin-top:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/> Limpiar</button></td>
        </tr>
     </table>
        
       </div> 
       
       <div  id="reservas"></div>
       
       <div id="horario" style="width:400px; height:auto; margin-bottom:10px;"></div>   
   
       <div id="recursosreserva" style="width:400px; height:auto; font-size:12px; margin-bottom:10px;"></div>     
        
	  <div id="alertas"></div>
  
</body>
</html>

