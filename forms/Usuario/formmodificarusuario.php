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
$query_JREstamento = "SELECT * FROM estamento";
mysql_query("SET NAMES 'utf8'");
$JREstamento = mysql_query($query_JREstamento, $conexion) or die(mysql_error());
$row_JREstamento = mysql_fetch_assoc($JREstamento);
$totalRows_JREstamento = mysql_num_rows($JREstamento);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cupi-Control de Utilizacion Piso Informatico</title>

<script type="text/javascript" >

$(function () {
	$('#nomusu').attr('disabled','disabled');
	$('#estamento').attr('disabled','disabled');
	$('#dependencia').attr('disabled','disabled');
	$('#dependencia').attr('disabled','disabled');
	$('#apellidos').attr('disabled','disabled');
	$('#formusuario').hide();
	$('#formestamento').hide();
	$('#formdependencia').hide();
	$('#formestado').hide();
	$("#formcod").hide();
	$("#formapellidos").hide();
	$("#updcodigo").hide();
	$('#updnombre').hide();
	$('#updestamento').hide();
	$('#upddependencia').hide();
	$('#updestado').hide();
	$('#updapellidos').hide();
	$("#codusu").focus();	
    banderaEstado=0;
	
	
	
	$('#updcodigo').toggle(function(){
	 
	    $('#formcod').show("slide");
		$("#nuevocod").focus();
        },function() {
        $("#formcod").hide("slide");
		$("#nuevocod").val("");
	});
	
	
	$("#updnombre").toggle(function() {
	     $('#formusuario').show("slide");
		 $("#newuser").focus();
		 
     },function() {
		 
         $("#formusuario").hide("slide");
		 $("#newuser").val("");
     });	
	
	$('#updestamento').toggle(function(){
	
	    $('#formestamento').show("slide");
        },function() {
        $("#formestamento").hide("slide");
	});
	
	$('#upddependencia').toggle(function(){
	 
	    $('#formdependencia').show("slide");
		 $("#nuevadependencia").focus();
        },function() {
        $("#formdependencia").hide("slide");
		  $("#nuevadependencia").val("");
	});
	
	$('#updestado').toggle(function(){
	
	     $('#formestado').show("slide");
         },function() {
         $("#formestado").hide("slide");
		
	});
	
	$('#updapellidos').toggle(function(){
	
	     $('#formapellidos').show("slide");
		  $("#newapel").focus();
         },function() {
         $("#formapellidos").hide("slide");
		  $("#newapel").val("");
	});
	
	
	
   $("#codusu").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') {
	  
	     event.preventDefault();
		 codigousuario=$("#codusu").val();
	     consultarUsuario(codigousuario);
		 
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
	
	        codigo=$('#codusu').val();
			arrayupdate=$(this).attr('class').split(' ');
	        idupdate=arrayupdate[1];
			formulario= arrayupdate[2];
			
		
			 if(idupdate=="nuevoest"){
				id=$(this).parents().find('select#'+idupdate).attr('id'); 
				nuevovalor=$('#'+id).val();
					 
			 }
			  else
			  {
			    id=$(this).parents().find('input#'+idupdate).attr('id');
				nuevovalor=$('#'+id).val();
				
			 }
			
			if(id=="nuevocod"){
				campo="codUsuario";
			} else if(id=="newuser"){
			  campo="nombreUsu"	
			}else if(id=="nuevadependencia"){
				campo="dependencia";
			}else if(id=="nuevoest"){
				campo="estamento";
			}else if(id="newapel"){
				campo="apellidos";
			}
			
			
	       if( nuevovalor!="")
		   {
		       $.ajax({
			  
					 type: 'POST',
					 url: 'funciones/Usuario/ActualizarUsuario.php',
					 data: 'campo='+campo+'&nuevovalor='+nuevovalor+'&valorllave='+codigo,
					 success: function(datos)
					 {
						 
						 if(datos!=0)
						   {
					
							    alertas("Los datos se han modificado exitosamente","Modificar Usuario","done");
								var Cuser=$("#codusu").val();
							    consultarUsuario(Cuser);
								$("#"+formulario).hide();
								$("#"+idupdate).val("");
								
							}
									
					  else
					  {
						  alertas("Por favor verifique los datos","Modificar Usuario","error");
					  }
				  }
		        
			   });
			  }
			  else
			  {
			     alertas("Por favor digite el nuevo texto para modificar el campo","Modificar Usuario","error");
			  }  
	       });
	
	 function obtenerDependencia(){
		
		  //$getJSON("URL",CADENA DE DATOS O PARAMETROS,FUNCION CALLBACK);
		  $.getJSON('consultas/Dependencias/consultardependencia.php' ,function(data) {
			//DATA ES EL JSON, LA VARIABLE i es el IDENTIFICADOR o KEY foo bar y baz Y LA VARIABLE item es el array,              valores o valor que tiene ese identificador
			$.each(data, function(key,item) { 
			size=item.length;
			var cadena=new Array();
			for(i=0;i<size;i++){
				 valor=item[i];
				cadena[i]=valor;
				
				
			}
			arraycadena(cadena);
				
			}); //each
		 
		});// Getjson
	}	
	
	
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




function consultarUsuario(codigo)
{

	
	 var options = {
				  
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codusu",
					  validations:{
						 
						  required:[true,"El campo Codigo no puede estar vacio."],
						  number:[true,"El campo Codigo debe contener numeros."],
						  clength:["5-12","El campo Codigo debe tener como minimo 5 caracteres maximo 12."]
						 }
				  }
				 ],
				 
				  beforeValidation:function(){
	  
               $.ajax({
					 type:'POST',
					 dataType:'json',
					 url: 'consultas/Usuario/consultarusuario.php',
					 data:'codigo='+codigo,
					 success: function(datos){
						 
						      if(datos.error==0) 
							  {			
								 nombre= datos.nombre;
								 estamento= datos.estamento;
								 dependencia=datos.dependencia;
								 estado=datos.estado;
								 codigousuario=datos.codigo;
								 apellidos=datos.apellidos;
								 $("#codusu").val(codigousuario);
								 $('#nomusu').val(nombre); 
								 $('#estamento').val(estamento); 	
								 $('#dependencia').val(dependencia);
								 $('#estado').val(estado);
								 $('#apellidos').val(apellidos);
								 $('#nomusu').attr('disabled','');
	                             $('#estamento').attr('disabled','');
	                             $('#dependencia').attr('disabled','');
								 $('#apellidos').attr('disabled','');
								 $("#updcodigo").show();	
								 $('#updnombre').show();
							     $('#updestamento').show();
							     $('#upddependencia').show(); 
								 $('#updestado').show(); 
								 $('#updapellidos').show(); 
								
								 
								}
								else if(datos.error==1)
								{
									alertas("El usuario no existe o no esta activo en el sistema","Modificar Usuario","error");
									
								}
								
							  }
			});

	    }
	
	  };
	  $.validation(options);   		
  
}


        $('#nuevadependencia').mouseenter(function () { 
	      obtenerDependencia();
	   }); 
	   
		   
		 function arraycadena(cadena){  
		    $( "#nuevadependencia" ).autocomplete({
			
			source: cadena
			
		   });
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

   <div class="text ui-widget-content ui-corner-all" style="width:420px; margin-bottom:15px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MODIFICAR USUARIO</div>      
          
       <table style="margin-left:15px;">
        <tr>
          <td><label>Codigo:</label></td>
          <td><input type="text" name="codusu" id="codusu" size="15" maxlength="128"  class="text ui-widget-content ui-corner-all height font12" title="Presione enter dentro del cajon de texto para traer la consulta"/></td>
          <td><img src="images/code.png" id="updcodigo"/></td>
        </tr>
       
        <tr>
        	<td><label>Nombre:</label></td>
            <td><input type="text" name="nomusu" id="nomusu" size="45" maxlength="128"  class="text ui-widget-content ui-corner-all height font12"/></td>
            <td> <img src="images/editar nombre.png" id="updnombre" title="Editar Nombre"/></td>      
        </tr>
        
        <tr>
        	<td><label>Apellidos:</label></td>
            <td><input type="text" name="apellidos" id="apellidos" size="35" maxlength="35"  class="text ui-widget-content ui-corner-all height font12"/></td>
            <td> <img src="images/editar nombre.png" id="updapellidos" title="Editar Apellidos"/></td>      
        </tr>
       
       
        <tr>
        	<td><label for="estamento">Estamento:</label></td>
            <td><input type="text" name="estamento" id="estamento" size="32" maxlength="128"  class="text ui-widget-content ui-corner-all height font12"/></td>
            <td> <img src="images/estamento.png" id="updestamento" title="Editar Estamento" /></td>       
       </tr>
      
        <tr>
          <td><label for="dependencia">Dependencia:</label></td>
          <td><input type="text" name="dependencia" id="dependencia" size="32" maxlength="128"   class="text ui-widget-content ui-corner-all height font12"/></td>          <td><img src="images/dependencia.png" id="upddependencia" title="Editar Dependencia" /></td>        
      </tr>
  
    <tr>
       <td><label>Estado:</label></td>
       <td><input type="text"  id="estado" size="15"  class="text ui-widget-content ui-corner-all height font12" /></td>                      
       <td><img src="images/activo.png" id="updestado" title="Editar Estado" /></td>        
  </tr>  
  
   <tr>
     <td><button name="enviar" type="button"  id="enviar" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/aceptar.png" style="       vertical-align:middle; padding-right:4px;"/>Aceptar</button>
     </td>
     
     <td><button type="button" id="limpiarform" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/> Limpiar</button>
     </td>
  </tr>    
      
  </table>
  
 </div>
 
<div id="formcod" class="text ui-widget-content ui-corner-all" style="width:260px; margin-bottom:15px;  height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nuevo Codigo</div>      

<table style="margin-left:15px;">
<tr>
<td><label>Nuevo Codigo:</label></td>
<td ><input type="text" name="nuevocod" id="nuevocod" size="20" class="text ui-widget-content ui-corner-all"/></td>
</tr>
<tr>
<td><button name="updcodigo" type="button" id="Actualizarcodigo" style="font-size:11px;" ><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>


 
<div id="formusuario" class="text ui-widget-content ui-corner-all" style="width:360px; margin-bottom:15px;  height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nuevo Nombre</div>      
 
<table style="margin-left:15px;">
<tr>
<td><label>Nuevo Nombre:</label></td>
<td><input type="text" name="newuser" id="newuser" size="40" class="text ui-widget-content ui-corner-all" value=""/></td>
</tr>
<tr>
<td><button name="updnombre" type="button" class="aceptar newuser formusuario" style="font-size:11px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>


<div id="formapellidos" class="text ui-widget-content ui-corner-all" style="width:400px; margin-bottom:15px;  height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nuevos Apellidos</div>      
 
<table style="margin-left:15px;">
<tr>
<td><label>Nuevos Apellidos:</label></td>
<td><input type="text" name="newapel" id="newapel" size="40" class="text ui-widget-content ui-corner-all" value=""/></td>
</tr>
<tr>
<td><button name="updapellidos" type="button" class="aceptar newapel formapellidos" style="font-size:11px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>




<div id="formestamento" class="text ui-widget-content ui-corner-all" style="width:260px; margin-bottom:15px;  height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nuevo Estamento</div>      
 
<table style="margin-left:15px;">
<tr>
<td><label>Nuevo estamento:</label></td>
<td><select size="1" name="estamento" id="nuevoest" class="text ui-widget-content ui-corner-all" >
        <?php
			  do {  
				?>
				  <option value="<?php echo $row_JREstamento['descripcion']?>"><?php echo $row_JREstamento['descripcion']?></option>
					<?php
					} while ($row_JREstamento = mysql_fetch_assoc($JREstamento));
					  $rows = mysql_num_rows($JREstamento);
					  if($rows > 0) {
						  mysql_data_seek($JREstamento, 0);
						  $row_JREstamento = mysql_fetch_assoc($JREstamento);
					}
	             ?>
     </select>
</td>
</tr>
<tr>
 <td><button name="updestamento" type="button" class="aceptar nuevoest formestamento" style="font-size:11px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:3px;"/>Aceptar</button></td>

</tr>

</table>

</div>
 

<div id="formdependencia" class="text ui-widget-content ui-corner-all" style="width:360px; margin-bottom:15px;  height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nueva Dependencia</div>      

<table style="margin-left:15px;">
<tr>
<td><label>Nueva dependencia:</label></td>
<td><input type="text" name="nuevadependencia" id="nuevadependencia" size="30" class="text ui-widget-content ui-corner-all" value="" title="Digite alguna letra dentro del cajon de texto para traer la lista de dependencias"/></td>
</tr>
<tr>
<td><button name="upddependencia" type="button" class="aceptar nuevadependencia formdependencia" style="font-size:11px;" ><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>


 
 <div id="formestado" class="text ui-widget-content ui-corner-all" style="width:230px; height:100px; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Nueva Estado</div>      

<table style="margin-left:15px;">
<tr>
<td><label>Activar Usuario:</label></td>
<td>
  <input type="checkbox" id="Estado"/>
</td>
</tr>
<tr>
<td><button type="button" id="actualizarEstado" style="font-size:11px;" ><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>

  <div id="alertas" ></div> 
   
    
</body>

</html>
