<?php require_once('../../Connections/conexion.php'); 
include("show_hours.php")
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
$query_JRActividad = "SELECT Descripcion FROM actividades";
$JRActividad = mysql_query($query_JRActividad, $conexion) or die(mysql_error());
$row_JRActividad = mysql_fetch_assoc($JRActividad);
$totalRows_JRActividad = mysql_num_rows($JRActividad);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cupi- Control de Utilizacion del Piso Informatico</title>

<script type="text/javascript">

$(function(){
	
	

var arraydelete=new Array();

  // escondo los formularios auxiliares que me permiten modificar los campos
	$('#formnombre').hide();
	$('#formactividad').hide();
	$("#formcodigo").hide();
	
	// escondo los botones que despliegan los formularios auxiliares
	$('#updnombre').hide();
	$('#updactividad').hide();
	

	// desabilito los campos nombre y actividad del formulario
	$("#nomAsig").attr('disabled','disabled' );
    $("#actividad").attr('disabled','disabled' );
						
	

  
	// se muestran los formularios correspondientes para modificar los datos
	
	
	   $('#updnombre').toggle(function(){
		
		  $('#formnombre').show("slide");
          },function() {
          $("#formnombre").hide("slide");
		   $("#nuevonombre").val("");	
			
		});
		
		$('#updactividad').toggle(function(){
		
		  $('#formactividad').show("slide");
          },function() {
           $("#formactividad").hide("slide");	
		   $("#nuevaactividad").val("");
		});
		   
		
	$("#grupo").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') {
	      
	     event.preventDefault();
	     codigo= $('#codAsig').val();
		 grupo=$("#grupo").val();
		 opcion=2;
		 ModificarAsignatura(codigo,grupo,opcion);
		 
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
			else if(type=="warning")
			{
				$("#alertas").html('<img src="images/dialog-warning.png" style="float:left; padding:5px;" />');
			}
			$("#alertas").append(content);
			$("#alertas").dialog("open");
		}
		
	
	function ModificarAsignatura(codigo,grupo,opcion){
		
		var options = {
				  //defaultMsg:"Todos los campos son requeridos.",
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
				  ,
				  {
					  id:"grupo",
					       validations:{
					         required:[true,"El campo grupo no puede estar vacio."],
						     number:[true,"El campo Grupo debe contener numeros."]
						   }				  
				  }
				  
				  ],
				  				  
			beforeValidation:function(){
				$.ajax({
					
					 type: 'POST',
					 url: 'consultas/Asignatura/consultarAsignatura.php',
					 data: 'codigo='+codigo+'&grupo='+grupo+'&opcion='+opcion,
					 success: function(datos){
						
						        if(datos!=0) {
									
									datosasig= datos.split('-');
									CAsignatura=datosasig[0];
									nombre=datosasig[1];
									actividad=datosasig[2];
									
									// se habilitan todos los campos del formulario
									$("#nomAsig").attr('disabled','' );
									$("#actividad").attr('disabled','' );
									
									// se muestran los botones que me permiten modificar los datos
									$('#updnombre').show();
									$('#updactividad').show();
									
									// asigno el valor devuelto por la cadena a cada uno de los campos}
									$("#codAsig").val(CAsignatura);
									$("#nomAsig").val(nombre);
		                            $("#actividad").val(actividad);
									
									
									
								}
								else{
								
								  alertas("Por favor verifique que la asignatura y el grupo existen ","Modificar Asignatura","error"); 
					             }
								
							  }
			});
		
			}
		};
	     $.validation(options);   
	}
	
		  
	            function  verificarExistenciaCodigo(campo,nuevovalor,valorllave)
			  
				 {	
					checkCodigo=$("#nuevocodigo").val();
					
					if(checkCodigo!="")
					{
					   $.ajax({
								
							type: 'POST',
							url: 'consultas/Asignatura/verificarCodigoAsig.php',
							data: 'asignatura='+checkCodigo,
							success: function(datos)
							{
									
							  if(datos==1)
							  {
								 alertas("El codigo ya ha sido utilizado para esta u otra asignatura","Modificar Asignatura","error");
								 $("#nuevocodigo").val("");
								 $("#nuevocodigo").addClass("ui-state-error"); 
								
							  }
							  else if(datos==2)
							  {
							     $("#nuevocodigo").removeClass("ui-state-error");
								 actualizarcodigoasignatura(campo,nuevovalor,valorllave); 
								    
							  }
						   }
					     });
						}
						else
						{
						  alertas("El campo codigo no puede estar vacio","Modificar Asignatura", "error");
						}
				      }
				 
				 
				 function verificarExistenciaNombre(codigo,campo,nuevovalor,idupdate,formulario)
				 {
					 
					 checkNombre=$("#nuevonombre").val();
					 
					 if(checkNombre!="")
					 {
					 
					     $.ajax({
								
							type: 'POST',
							url: 'consultas/Asignatura/verificarNombreAsig.php',
							data: 'nombre='+checkNombre,
							success: function(datos)
							{
									
							  if(datos==1)
							  {
								 alertas("El nombre ya ha sido definido para esta u otra asignatura","Modificar Asignatura","error");
								 $("#nuevonombre").val("");
								 $("#nuevonombre").addClass("ui-state-error"); 
								
							  }
							  else if(datos==2)
							  {
							     $("#nuevonombre").removeClass("ui-state-error");
								 ActualizarItemsAsignatura(campo,nuevovalor,codigo,idupdate,formulario); 
								    
							  }
						   }
					     });
						}
						else
						{
						   alertas("El campo nombre no puede estar vacio","Modificar Asignatura","error"); 
						} 
				      }
	
		
		$('#consultar').button().click(function(){
		
		  codigo= $('#codAsig').val();
		  grupo=$("#grupo").val();
		  ModificarAsignatura(codigo,grupo);
			
		});
		
		
	  $('.aceptar').button().click(function(){
		
			arrayupdate=$(this).attr('class').split(' ');
	        idupdate=arrayupdate[1];
			formulario= arrayupdate[2];
			
			if(idupdate=="nuevoprograma" || idupdate=="nuevaactividad"){
				
			id=$(this).parents().find('select#'+idupdate).attr('id');
			nuevovalor=$('#'+id).val();	
			}
			else{
	         id=$(this).parents().find('input#'+idupdate).attr('id');
			 nuevovalor=$('#'+id).val();
			}
			
			 if(id=="nuevocodigo"){
			   campo="codAsignatura"		
			}
			else if(id=="nuevonombre")
			{
			  campo="nomAsignatura"	
			}
			else if(id=="nuevoprograma")
			{
			   campo="codPrograma";
			}
			else if(id=="nuevaactividad")
			{
			  campo="actividad";
			}
			
			codigo= $('#codAsig').val();
		    grupo=$("#grupo").val();
			
			if(idupdate=="nuevafechai")
			{
				checkfechaIni=$("#nuevafechai").val();
				checkfechaFin=$("#final").val();
				
				verificarFechas(checkfechaIni,checkfechaFin,campo,nuevovalor,codigo,idupdate,formulario);
				
			}
			else if(idupdate=="nuevafechat")
			{
				checkfechaIni=$("#comienzo").val();
				checkfechaFin=$("#nuevafechat").val();
				
				verificarFechas(checkfechaIni,checkfechaFin,campo,nuevovalor,codigo,idupdate,formulario);
			
			}
			
			else if(idupdate=="nuevonombre")
			{
				verificarExistenciaNombre(codigo,campo,nuevovalor,idupdate,formulario)
			}
			else
			{
				ActualizarItemsAsignatura(campo,nuevovalor,codigo,idupdate,formulario);
			}
		});
		
			
			function ActualizarItemsAsignatura(campo,nuevovalor,codigo,idupdate,formulario)
			{
			   if(nuevovalor!="")
			   {
			  	
	              $.ajax({
			  
					 type: 'POST',
					 url: 'funciones/Asignatura/actualizarall.php',
					 data:'campo='+campo+'&nuevovalor='+nuevovalor+'&valorllave='+codigo,
					 success: function(datos)
					  {
						 
						   if(datos==1)
						   {	
								codigo=$("#codAsig").val();
								grupo=$("#grupo").val();
								alertas("Los datos se han modificado correctamente","Modificar Asignatura","done"); 
								ModificarAsignatura(codigo,grupo);		
							    $("#"+formulario).hide();                        
						   }
					      
						   else
						    {
							  alertas("Por favor verifique los datos","Modificar Asignatura","error"); 
						    }
					   }// ciero success
			         });// cierro ajax
			       }
				   else
				   {
				      alertas("El campo no puede estar vacio","Modificar Asignatura","error"); 
				   }
	             }// cierra function
				 
				 $("#actualizarCodigoAsig").button().click(function(){
	 
					campo="codAsignatura"
					nuevovalor=$("#nuevocodigo").val();
					valorllave=$("#codAsig").val();
					verificarExistenciaCodigo(campo,nuevovalor,valorllave);
				 
				});
				
				function actualizarcodigoasignatura(campo,nuevovalor,valorllave)
				{
				   $.ajax({
						  
					 type: 'POST',
					 url: 'funciones/Asignatura/actualizarall.php',
					 data: 'campo='+campo+'&nuevovalor='+nuevovalor+'&valorllave='+valorllave,
					 success: function(datos){
					   if (datos!=0) 
					   {
						   alertas("Los datos se han modificado exitosamente","Modificar Asignatura","done");
						   grupo=$("#grupo").val();
						   ModificarAsignatura(nuevovalor,grupo);
						   $("#formcodigo").hide();
						   $("#nuevocodigo").val("");
						   
						 
					   }
					   else
					   {
						alertas("Ha ocurrido un error","Modificar Usuario","error");
					   }
					 }
				  }); 
					 
				}
				
		   $("#limpiarform").button().click(function() {
			   
			  $("#codAsig").val("");
			  $("#nomAsig").val("");
			  $("#grupo").val("");
			  $("#actividad").val("");
			  $("#codAsig").focus();      
		  });		
							 
       });// cierro jquery

</script>


</head>

<body>

<p id="validateErrors"></p>

        
       <div id="modasignatura" class="text ui-widget-content ui-corner-all" style="width:560px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y; margin-bottom:10px;">
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MODIFICAR ASIGNATURA</div>
          
        <table style="margin-left:15px;">
        <tr>
        	<td><label>Codigo:</label></td>
            <td><input type="text" name="codAsig" id="codAsig"   maxlength="128" size="15"   class="text ui-widget-content ui-corner-all height font12" value=""/></td>
           
            
            <td><label>Grupo:</label></td>
            <td><input type="text" name="" id="grupo"  maxlength="128" size="5"  class="text ui-widget-content ui-corner-all height font12" value="" title="Presione enter dentro del cajon de texto para traer la consulta"/></td>
          
        </tr>
       
       </table>
       
      <table style="margin-left:15px;">
        <tr>    
            <td><label for="nombre">Nombre:</label></td>
            <td><input type="text" name="nomAsig" id="nomAsig"  size="30"  class="text ui-widget-content ui-corner-all height font12" value=""/></td>
            <td><img src="images/editar nombre.png" id="updnombre" title="Editar Nombre"/></td>
            
            <td>
        	  <label for="actividad">Actividad:</label></td>
            <td>
<input type="text" name="actividad" id="actividad"  class="text ui-widget-content ui-corner-all height font12" value=""/>
            </td>                      
            <td><img src="images/actividad.png"id="updactividad" title="Editar Actividad"/></td>
           
       </tr>
       </table>
     
   <table style="margin-left:15px;">  
     <tr>
        <td><button name="consultar" type="button" value="Aceptar" id="consultar" style="font-size:11px; margin-top:10px; margin-bottom:10px;" ><img src="images/aceptar.png"  style="vertical-align:middle; padding-right:3px;"/>Aceptar</button> 
        </td>
        <td>
          <button type="button" id="limpiarform" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/broom.png" style="vertical-align:middle;            padding-right:4px;"/> Limpiar</button>
        </td>
     </tr>
   </table> 
 </div>
     
     
        
  <div id="formnombre" class="text ui-widget-content ui-corner-all" style="width:330px;  margin-bottom:15px; height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
      <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nuevo Nombre</div>
              
     <table style="margin-left:10px;">
        <tr>
         <td><label for="codigo">Nuevo nombre:</label></td>
         <td><input type="text" name="nuevonombre" id="nuevonombre" size="35" class="text ui-widget-content ui-corner-all" value=""/></td>
       </tr>
       <tr>
         <td><button  type="button"  class="aceptar nuevonombre formnombre"  style="font-size:11px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>
      </tr>
    </table>
            
</div>

  
<div id="formactividad" class="text ui-widget-content ui-corner-all" style="width:350px;  margin-bottom:15px; height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
      <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nuevo Actividad</div>


        <table style="margin-left:10px;">
        <tr>
        	<td><label for="actividad">Nueva Actividad:</label></td>
            <td><select size="1" name="nuevaactividad" id="nuevaactividad">
              <?php
            do {  
             ?>
              <option value="<?php echo $row_JRActividad['Descripcion']?>"><?php echo $row_JRActividad['Descripcion']?></option>
              <?php
				} while ($row_JRActividad = mysql_fetch_assoc($JRActividad));
				  $rows = mysql_num_rows($JRActividad);
				  if($rows > 0) {
					  mysql_data_seek($JRActividad, 0);
					  $row_JRActividad = mysql_fetch_assoc($JRActividad);
				  }
             ?>
          </select>
          </td>
            </tr>
            <tr>
<td><button  type="button" class="aceptar nuevaactividad formactividad"  style="font-size:11px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>
</tr>

 </table>
         
 </div>
       
   <div id="alertas"></div>
   
</body>
</html>
<?php

mysql_free_result($JRActividad);

mysql_close($conexion)
?>
