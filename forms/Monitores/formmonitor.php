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
			$("#alertas").append(content);
			$("#alertas").dialog("open");
		}
		
		
		


      function limpiarformulario() {
	    $("#cedula").val("");
	    $("#codigo").val("");
	    $("#nombres").val("");
	    $("#apellidos").val("");
		$("#progacademico").val("");
	    $("#dirresidencia").val("");
		$("#celular").val("");
	    $("#telefono").val("");
		$("#email").val("");
		$("#cedula").focus();  
	 }
	
       // Evento que limpia el formulario
    $("#limpiarform").button().click(function(){
			
		  $("#cedula").val("");
		  $("#codigo").val("");
		  $("#nombres").val("");
		  $("#apellidos").val("");
		  $("#progacademico").val("");
		  $("#dirresidencia").val("");
		  $("#celular").val("");
		  $("#telefono").val("");
		  $("#email").val("");
		  $("#estado").val("");
		  $("#cedula").focus();
		  
		  
	});
        
     $("#enviar").button().click(function(){
		 
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
				  },
				  
				  {
					  id:"codigo",
					       validations:
						   {
					         required:[true,"El campo codigo no puede estar vacio."],
						   }				  
				  },
				  
				  {
					  id:"nombres",
					       validations:
						   {
					         required:[true,"El campo nombre no puede estar vacio."],
						   }				  
				  },
				  
				  {
					  id:"apellidos",
					       validations:
						   {
					         required:[true,"El campo apellidos no puede estar vacio."],
						   }				  
				  },
				  
				  {
					  id:"progacademico",
					       validations:
						   {
					         required:[true,"El campo programa academico no puede estar vacio."],
						   }				  
				  },
				  
				  
				  {
					  id:"dirresidencia",
					  validations:
					    {
						   required:[true,"El campo direccion residencia no puede estar vacio."],
						  
						}
				  },
				  
				  {
					  id:"celular",
					  validations:
					    {
						   required:[true,"El campo celular no puede estar vacio."],
						  
						}
				  },
				  
				  {
					  id:"telefono",
					  validations:
					    {
						   required:[true,"El campo telefono no puede estar vacio."],
						  
						}
				  },
				  
				  {
					  id:"email",
					  validations:
					    {
						   required:[true,"El campo email no puede estar vacio."],
						   email:[true,"Introduzca un email valido."],
						  
						}
				  },
				  
				  			  
				  
				  ],				  
				  beforeValidation:function(){
					  
		          var cedula= $("#cedula").val();
			      var codigo= $("#codigo").val();
			      var nombres= $("#nombres").val();
			      var apellidos=$("#apellidos").val();
				  var progacademico= $("#progacademico").val();
			      var dirresidencia=$("#dirresidencia").val();
				  var celular=$("#celular").val();
			      var telefono=$("#telefono").val();
				  var email=$("#email").val();
		
			     $.ajax({
					 type: 'POST',
					 url: 'funciones/Monitores/insertmonitor.php',
					 data: 'cedula='+cedula+'&codigo='+codigo+'&nombres='+nombres+'&apellidos='+apellidos+'&progacademico='+progacademico+'&dirresidencia='+dirresidencia                     +'&celular='+celular+'&telefono='+telefono+'&email='+email,
					 success: function(datos){
						 
						 if(datos==1)
						 {
							  alertas("Los datos se han ingresado correctamente","Adicionar Monitor","done");
							  limpiarformulario();
						 }
						 else
						 {
							 alertas("Por favor verifique los datos","Adicionar Monitor","error");
									
						 }
					   }
			        }); 			  
		        }
		       }; 
		      $.validation(options);   
	         });
			
         }); // cierra el function
    </script>


</head>

<body>
 
 <p id="validateErrors"></p>
 
<div id="formusuario" class="text ui-widget-content ui-corner-all" style="width:500px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
  <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CREAR NUEVO MONITOR</div>
          
    <table style="margin-left:15px; margin-bottom:10px;">
    
        <tr>
          <td><label for="cedula">Cedula:</label></td>
          <td><input type="text" name="cedula" id="cedula" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td>
        </tr> 
       
        <tr>
          <td><label for="codigo">Codigo:</label></td>
          <td><input type="text" name="codigo" id="codigo" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td>
        </tr>
       
        <tr>
          <td><label for="nombres">Nombres:</label></td>
          <td><input type="text" name="nombres" id="nombres" size="50" class="text ui-widget-content ui-corner-all height font12"/></td>    
        </tr>
        
        <tr>
          <td><label for="apellidos">Apellidos:</label></td>
          <td><input type="text" name="apellidos" id="apellidos" size="50" class="text ui-widget-content ui-corner-all height font12"/></td>      
        </tr>
        
         <tr>
          <td><label for="progacademico">Programa Academico:</label></td>
          <td><input type="text" name="progacademico" id="progacademico" size="50" class="text ui-widget-content ui-corner-all height font12"/></td>      
        </tr>
        
        <tr>
          <td><label for="dirresidencia">Direccion Residencia:</label></td>
          <td><input type="text" name="dirresidencia" id="dirresidencia" size="50" class="text ui-widget-content ui-corner-all height font12"/></td>      
        </tr>
        
        <tr>
          <td><label for="celuar">Celular:</label></td>
          <td><input type="text" name="celular" id="celular" size="20" class="text ui-widget-content ui-corner-all height font12"/></td>      
        </tr>
        
        <tr>
          <td><label for="telefono">Telefono:</label></td>
          <td><input type="text" name="telefono" id="telefono" size="20" class="text ui-widget-content ui-corner-all height font12"/></td>      
        </tr>
        
        <tr>
          <td><label for="email">Correo electronico:</label></td>
          <td><input type="text" name="email" id="email" size="50" class="text ui-widget-content ui-corner-all height font12"/></td>      
        </tr>
     </table>
  <div style="margin-top: 5px; margin-bottom: 5px; margin-left: 5px;">
      <button type="button" id="enviar"  style="font-size:11px; padding-left: 5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/> Aceptar</button>
      <button type="button" id="limpiarform" style="font-size:11px; padding-left: 5px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/>Limpiar</button>
    </div>
  
  
   </div> 
   
	<div id="alertas"></div>
     
</body>
</html>
