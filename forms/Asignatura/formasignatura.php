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

// consulta todos los grupos de la base de datos
mysql_select_db($database_conexion, $conexion);
$query_JRGrupo = "SELECT * FROM grupo";
$JRGrupo = mysql_query($query_JRGrupo, $conexion) or die(mysql_error());
$row_JRGrupo = mysql_fetch_assoc($JRGrupo);
$totalRows_JRGrupo = mysql_num_rows($JRGrupo);

// consulta todas las salas de la base de datos
mysql_select_db($database_conexion, $conexion);
$query_JRSalas = "SELECT numSala FROM sala";
$JRSalas = mysql_query($query_JRSalas, $conexion) or die(mysql_error());
$row_JRSalas = mysql_fetch_assoc($JRSalas);
$totalRows_JRSalas = mysql_num_rows($JRSalas);

mysql_select_db($database_conexion, $conexion);
$query_JRActividades = "SELECT * FROM actividades where idActividad NOT IN(2,3,4,5) order by Descripcion asc";
$JRActividades = mysql_query($query_JRActividades, $conexion) or die(mysql_error());
$row_JRActividades = mysql_fetch_assoc($JRActividades);
$totalRows_JRActividades = mysql_num_rows($JRActividades);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cupi-Control Utilizacion Piso Informatico</title>

<style type="text/css">
 .vacio
 {
    font:Arial, Helvetica, sans-serif; 
	color:#FF0000; 
	font-size:12px
 }

</style>

	
  
<script type="text/javascript">

var i=0;


$(function(){

var cadenahorario=new Array();
// calendarios para la fecha
$.datepicker.setDefaults($.datepicker.regional['es']);
$("#codAsig").focus();

// Funcion que limpia el formulario	
function limpiar_formulario_elementos(ele) {
	 
	    $(ele).find(':input').each(function() {
	        switch(this.type) {
	            case 'password':
	            case 'text':
	            case 'textarea':
	                $(this).val('');
	                break;
	            case 'checkbox':
	            case 'radio':
                this.checked = false;
        }
	    });
	 
	}
  
      // Se define las caracteristicas del mensajes
      $("#alertas" ).dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			modal:true		
		});
		
		// funcion que define los mensajes de dialogo
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
        
	  
	     // Funcion que busca si una asignatura tiene definido sus datos, un grupo y un horario de clases
		function buscarAsignaturaGrupoHorario(codigo,grupo,nombre,actividad,BAsigGrupo)
		{
				   
			  if(BAsigGrupo==0)
			  {
				  verificarExistenciaCodigo(codigo,grupo,nombre,actividad,BAsigGrupo)
			  }
			  
			  else if(BAsigGrupo==1)
			  {
				 insertarDatosAsignatura(codigo,grupo,nombre,actividad,BAsigGrupo)  			   
			 }
						
    }// cierro funcion
	
	
	  
   
      $("#enviar").button().click(function(){
	   
	       verificarExistCodigo=$("#codAsig").val();
		   grupoAsignatura=$("#grupo").val();
		   nombreAsignatura=$("#nomAsig").val();
		   actividad=$("#actividad").val();
		   
          if(verificarExistCodigo!="") 
		  { 	
			
	       $.ajax({
				
				 type: 'POST',
				 url: 'consultas/Asignatura/buscarAsignaturaGrupoHorario.php',
				 data: 'codigo='+verificarExistCodigo+'&grupo='+grupoAsignatura,
					  
				 success: function(BAsigGrupo)
				 { 
					   
					if(BAsigGrupo==1)
					{
						
						  var options = {
				  
				          classerror:"ui-state-error",
						  classdone:"ui-state-highlight",
						  contentmsg:"validateErrors",
						  fields:[
						  {
						    id:"codAsig",
						    validations:
						     {
							    required:[true,"El campo Codigo no puede estar vacio."],
							 }
					  	}
				  
				       ],	
				  			  
				       beforeValidation:function(){
				   
					   buscarAsignaturaGrupoHorario(verificarExistCodigo,grupoAsignatura,nombreAsignatura,actividad,BAsigGrupo)
				        }
		               }; 
		              $.validation(options); 
				  }// cierro if
				   
				else if(BAsigGrupo==0)
				{
				  
				       var options = {
				  
				          classerror:"ui-state-error",
						  classdone:"ui-state-highlight",
						  contentmsg:"validateErrors",
						  fields:[
						  {
						    id:"codAsig",
						    validations:
						     {
							    required:[true,"El campo Codigo no puede estar vacio."],
							 }
					  	},
						
						{
						    id:"nomAsig",
						    validations:
						     {
							    required:[true,"El campo Nombre no puede estar vacio."],
							 }
					  	}
				    ],	
				  			  
				   beforeValidation:function()
				   {
				   
					 buscarAsignaturaGrupoHorario(verificarExistCodigo,grupoAsignatura,nombreAsignatura,actividad,BAsigGrupo)
				   }
		           }; 
		           $.validation(options);
				}
				 
				else if(BAsigGrupo==3)
				{
				   alertas("La asignatura ya tiene definido un grupo ","Crear Asignatura", "error");
				}// cierro else if	
			   }// cierro success
			 }); // cierro ajax
			 }// cierro if
			 else
			 {
			   alertas("Por favor verifique que el codigo de la asignatura no este vacio","Crear Asignatura","error");
			 }
	        });// cierro enviar
	
	
	  // Funcion que se encarga de insertar una asignatura en la base de datos
	  function insertarDatosAsignatura(codigo,grupo,nombre,actividad,opcionInsercion)
	  {
    
	       if(opcionInsercion==0)
		   {						   
			    
			   insertarAsig=1;
				   
					$.ajax({
					 
					type: 'POST',
					url: 'funciones/Asignatura/insertarAsig.php',
					data: 'codigo='+codigo+'&nombre='+nombre+'&actividad='+actividad+'&grupo='+grupo+'&insertarAsig='+insertarAsig,
					success: function(datos)
					{
							 
					  if(datos==11)
					  {
									
					   alertas("Los datos se han ingresado correctamente","Adicionar Asignatura","done"); 
					   limpiar_formulario_elementos($("#formasignatura"));
					   $(".vacio").hide();
					   
					  
					  }
					  else
					  {
						 alertas("Por favor verifique los datos","Adicionar Asignatura","error"); 
					  }
				 }// cierro success
			   });// cierro ajax
			}// cierro if 
			
			else if(opcionInsercion==1)
			{
			    insertarAsig=2;
				   
					$.ajax({
					 
					type: 'POST',
					url: 'funciones/Asignatura/insertarAsig.php',
					data: 'codigo='+codigo+'&nombre='+nombre+'&actividad='+actividad+'&grupo='+grupo+'&insertarAsig='+insertarAsig,
					success: function(datos)
					{
							 
					  if(datos==1)
					  {
									
					   alertas("Los datos se han ingresado correctamente","Adicionar Asignatura","done"); 
					   limpiar_formulario_elementos($("#formasignatura"));
					   $(".vacio").hide();
					  }
					  else
					  {
						 alertas("Por favor verifique los datos","Adicionar Asignatura","error"); 
					  }
				 }// cierro success
			   });// cierro ajax
			}// cierro else if
		
	 }// cierro funcion


	// verifica si se presenta cruce de horarios
	
			 
   function  verificarExistenciaCodigo(codigo,grupo,nombre,actividad,opcionInsercion)
				 
    {	
					
	  $.ajax({
								
		type: 'POST',
		url: 'consultas/Asignatura/verificarCodigoAsig.php',
		data: 'asignatura='+codigo,
		success: function(datos)
		{
									
		   if(datos==1)
		   {
				alertas("El codigo ya ha sido definido para esta asignatura","Crear Asignatura","error");
				$("#codAsig").val("");
				$("#codAsig").addClass("ui-state-error"); 
		  }
				
		  else if (datos==2)
		 {
			$("#codAsig").removeClass("ui-state-error"); 
			insertarDatosAsignatura(codigo,grupo,nombre,actividad,opcionInsercion);
	      } // cierro else if
		 }// cierro el success
	    });// cierro el ajax
	 }// cierro funcion
				 
				 
				 		 
		// Evento que verifica si es necesario escribir el nombre y la actividad de la asignatura
				 
		  $("#grupo").blur(function(){
			
			//$(".vacio").hide();
				 
		    codigoA= $("#codAsig").val();
		    grupoA= $("#grupo").val();
				  
		     $.ajax({
				
				 type: 'POST',
				 url: 'consultas/Asignatura/buscarAsignaturaGrupoHorario.php',
				 data: 'codigo='+codigoA+'&grupo='+grupoA,
					  
				 success: function(datos)
				 { 
					   
					 if(datos==0)
					 {
						$("#nomAsig").val(""); 
						alertas("La asignatura no existe, por favor defina un nombre, grupo, actividad ","Adicionar Asignatura","inform");
				     }
					 else if(datos==1)
					 {
						alertas("La asignatura no se encuentra definida con este grupo, por favor defina  el grupo de la asignatura","Adicionar Asignatura","inform"); 
						TraerNombreActividad(codigoA);
					 }
					 else if(datos==3)
					 {
						alertas("La asignatura ya tiene definido un nombre, grupo, actividad","Adicionar Asignatura","inform");
						TraerNombreActividad(codigoA);    
					 }
						
				 }// cierro success
			  }); // cierro ajax
		   }); // cierro blur
		   
		   function TraerNombreActividad(asignatura)
		   {
			   $.ajax({
					 
					type: 'POST',
					url: 'consultas/Asignatura/TraerNombreActividad.php',
					data: 'asignatura='+asignatura,
					success: function(datos)
					{
						if(datos!=0)
						{
						  cadena=datos.split("-");	
						  $("#nomAsig").val(cadena[0]);
						  $("#actividad").val(cadena[1]);
						}
						else
						{
							alertas("La asignatura no existe","Adicionar Asignatura","error");  
						}
						
					}
			   });
		   }
		   
		 $("#limpiarform").button().click(function() {
			 
			$("#codAsig").val("");
			$("#nomAsig").val("");
			$("#codAsig").focus();
			 
		 });  
		   
		   
	  });// cierro jquery

</script>

</head>

<body>

 <p id="validateErrors"></p>
 
        <div id="formasignatura" class="text ui-widget-content ui-corner-all" style="width:630px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
        
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CREAR ASIGNATURA</div>
        
        <table style="margin-left:15px; margin-bottom:15px;">
        <tr>
        	<td><label for="codigo">Codigo:</label></td>
            <td><input type="text" name="codAsig" id="codAsig" size="20" class="text ui-widget-content ui-corner-all height font12" style="font-size:14px;"/></td>
            <td><label for="grupo">Grupo:</label></td>
            <td> <select size="1" id="grupo">
        <?php
         do {  
        ?>
       <option value="<?php echo $row_JRGrupo['codGrupo']?>"><?php echo $row_JRGrupo['codGrupo']?></option>
         <?php
     } while ($row_JRGrupo = mysql_fetch_assoc($JRGrupo));
        $rows = mysql_num_rows($JRGrupo);
       if($rows > 0) {
           mysql_data_seek($JRGrupo, 0);
	         $row_JRGrupo = mysql_fetch_assoc($JRGrupo);
         }
        ?>
        </select>
         </td>             
        </tr>
        
        <tr>
         <td><label for="nombre">Nombre:</label></td>
            <td><input type="text" name="nomAsig" id="nomAsig" size="50" maxlength="128"   class="text ui-widget-content ui-corner-all height font12 "/></td>
           
            <td> <label for="actividad">Actividad:</label></td>
            <td>
            	<select size="1" name="actividad" id="actividad" class="text ui-widget-content ui-corner-all">
            	  <?php
					do {  
					?>
					<option value="<?php echo $row_JRActividades['Descripcion']?>"><?php echo $row_JRActividades['Descripcion']?></option>
					<?php
					} while ($row_JRActividades = mysql_fetch_assoc($JRActividades));
					  $rows = mysql_num_rows($JRActividades);
					  if($rows > 0) {
						  mysql_data_seek($JRActividades, 0);
						  $row_JRActividades = mysql_fetch_assoc($JRActividades);
					  }
					?>
                </select>
            </td>    
        </tr>      
     </table>       
      
      <button type="button" id="enviar" style="font-size:11px; margin-left:10px; margin-bottom:10px; "><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar </button> 
      <button type="button" id="limpiarform" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/> Limpiar</button>
     
    </div>
    


 <div id="alertas">
     
</body>
</html>
<?php
mysql_free_result($JRGrupo);

mysql_free_result($JRActividades);

?>


