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
$query_JRPerfil = "SELECT idPerfil,descripcion FROM perfil_usuario";
$JRPerfil = mysql_query($query_JRPerfil, $conexion) or die(mysql_error());
$row_JRPerfil = mysql_fetch_assoc($JRPerfil);
$totalRows_JRPerfil = mysql_num_rows($JRPerfil);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<script type="text/javascript" >

$(function () {
	
	$('#usernamereal').attr('disabled','disabled');
	$('#perfil').attr('disabled','disabled');
	$('#estado').attr('disabled','disabled');
	$('#formusername').hide();
	$('#formestado').hide();
	$("#formnuevacontrasena").hide();
	$("#formnuevonombre").hide();
	$("#formnuevoperfil").hide();
	$("#updusername").hide();
	$('#updpassword').hide();
	$('#updname').hide();
	$('#updperfil').hide();
	$('#updestado').hide();
	
	
	
	$('#updusername').toggle(function(){
	  
		 $('#formusername').show("slide");
          },function() {
          $("#formusername").hide("slide");
		  	
	});
	
	   
	$('#updname').toggle(function(){
	    $('#formnuevonombre').show("slide");
	    },function() {
        $("#formnuevonombre").hide("slide");
	   
	});
	
	$('#updpassword').toggle(function(){
	   $('#formnuevacontrasena').show("slide");
	   },function() {
        $("#formnuevacontrasena").hide("slide");
	});
	
	$('#updperfil').toggle(function(){
	  $('#formnuevoperfil').show("slide");
	  },function() {
       $("#formnuevoperfil").hide("slide");
	});
	
	$('#updestado').toggle(function(){
	  $('#formestado').show("slide");
	  },function() {
       $("#formestado").hide("slide");
	});
	
	
	
   $("#username").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') {
	  
	     event.preventDefault();
		 NUsuario=$("#username").val();
		 consultarUsuarioSistema(NUsuario);
		 
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
	
	 
	   
	        Musername=$('#username').val();
			Mpassword=$('#userpassword').val();
			arrayupdate=$(this).attr('class').split(' ');
	        idupdate=arrayupdate[1];
			formulario= arrayupdate[2];
			
			
			
			 if(idupdate=="newperfil" || idupdate=="nuevoestado"){
				id=$(this).parents().find('select#'+idupdate).attr('id'); 
				nuevovalor=$('#'+id).val();
					 
			 }
			 
			else
			{
			    id=$(this).parents().find('input#'+idupdate).attr('id');
				nuevovalor=$('#'+id).val();
				
			 }
			
			if(id=="nuevousername"){
				campo="nombreUsuario";
			} else if(id=="newpassword"){
			  campo="contrasena"	
			}else if(id=="newname"){
				campo="Nombre";
			}else if(id=="newperfil"){
				campo="perfil";
			}else if(id=="nuevoestado"){
				campo="estado";
			}
			
			if(idupdate=="nuevousername")
			{
				verificarNombreUsuario(campo,nuevovalor,Musername,formulario,idupdate);
			}
			
			if(idupdate=="newpassword")
			{
				oldpassword=$("#oldpassword").val();
				verificarPassword(campo,nuevovalor,oldpassword,Musername,formulario,idupdate);
			}
			
			else
			{
				ModificarDatosUsuario(campo,nuevovalor,Musername,formulario,idupdate)
			}
	    });
		
			
	   function  ModificarDatosUsuario(campo,nuevovalor,valorllave,formulario,idupdate)
	   {
		   
		   
		   if(nuevovalor!="")
		   {
		        $.ajax({
			  
					 type: 'POST',
					 url: 'funciones/Usuario_Aplicacion/ActualizarUsuarioA.php',
					 data: 'campo='+campo+'&nuevovalor='+nuevovalor+'&valorllave='+valorllave,
					 success: function(datos){
						 
						 
						 if(datos!=0)
						 {
					
							    alertas("Los datos se han modificado exitosamente","Modificar Usuario Sistema","done");
								if(idupdate=="nuevousername")
								{
								   NuevoNombreUsuario=$("#nuevousername").val();
								   consultarUsuarioSistema(NuevoNombreUsuario);
								   $("#"+formulario).hide();	
								}
								
							  else
							  {
								 BuscarUsuario=$('#username').val(); 
								 consultarUsuarioSistema(BuscarUsuario)
								 $("#"+formulario).hide(); 
							  }
								 
						 }
						 
					  else
					  {
						  alertas("Por favor verifique los datos","Modificar Usuario Sistema","error");
					  }
				  }
		        
			   });
		   }
		   else
		   {
			   alertas("El campo no puede estar vacio","Modificar Usuario Sistema","error");    
		   }
	   }// cierro funcion
	
	

	
  $('#enviar').button().click(function(){
	
	Uname=$("#username").val();
	consultarUsuarioSistema(Uname);
	
  });	


        function verificarNombreUsuario(campo,nuevovalor,valorllave,formulario,idupdate)
	
		 {
		
		  	
		    if (nuevovalor!="")
		
		    {
		      $.ajax({
			
				 type:'POST',
				 url:'consultas/Usuario_Aplicacion/existenciaUsuarioSistema.php',
				 data: 'usuario='+nuevovalor,
				 success: function(datos){
			
				 if (datos==1)
				 {
				
					$("#nuevousername").val("");
					$("#nuevousername").addClass("ui-state-error");
					alertas("El usuario ya existe","Modificar Usuario Sistema","error");	
				
				}
				else
				{
				   $("#nuevousername").removeClass("ui-state-error");
				   ModificarDatosUsuario(campo,nuevovalor,valorllave,formulario,idupdate);
				}
			  }// cierro success
			});// cierro ajax
		   }// cierro if
		   else
		   {
			 alertas("El campo nombre usuario no puede estar vacio","Modificar Usuario Sistema","error");	   
		   }
	    }// cierro funcion
		
		
		 function verificarPassword(campo,nuevovalor,oldpassword,valorllave,formulario,idupdate)
		 {
			
			 $.ajax({
			
				 type:'POST',
				 dataType:'json',
				 url:'consultas/Usuario_Aplicacion/verificarpassword.php',
				 data: 'password='+oldpassword,
				 success: function(datos){
			
					 if (datos.error==1)
					 {
						 $("#oldpassword").val("");
					     $("#oldpassword").addClass("ui-state-error");
						 alertas("La contraseña proporcionada no es la correcta","Modificar Usuario Sistema","error");	    
					 }
					 else if(datos.error==0)
					 {
						  $("#oldpassword").remove("ui-state-error");
						  ModificarDatosUsuario(campo,nuevovalor,valorllave,formulario,idupdate);
					 }
				 }
			 });
			
			
		}


   function consultarUsuarioSistema(username)
   {
   
	 var options = {
				  
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"username",
					  validations:{
						 
						  required:[true,"El campo Nombre Usuario no puede estar vacio."],
						  
						  
						 }
				  },
				  
				 ],
				 
				  beforeValidation:function(){
	  
                 $.ajax({ 
				 
					 type:'POST',
					 url: 'consultas/Usuario_Aplicacion/consultarUsuariosistema.php',
					 data:'username='+username,
					 success: function(datos){
						 
						        if(datos!=0) {			
								 datos1=datos.split('-');
								 nickname=datos1[0];
								 pass=datos1[1];
								 nombre=datos1[2];
								 perfil=datos1[3];
								 estado=datos1[4];
								 $('#username').val(nickname); 	
								 $('#userpassword').val(pass);
								 $('#usernamereal').val(nombre); 	
								 $('#perfil').val(perfil);
								 $('#estado').val(estado);
								 $('#username').attr('disabled','');
	                             $('#userpassword').attr('disabled','');
	                             $('#usernamereal').attr('disabled','');
								 $('#perfil').attr('disabled','');
	                             $('#estado').attr('disabled','');
								 $("#updusername").show();	
								 $('#updpassword').show();
							     $('#updname').show();
							     $('#updperfil').show(); 
								 $('#updestado').show(); 
								
								 
								}
								else{
									alertas("El usuario no existe o no esta activo en el sistema","Modificar Usuario Sistema","error");
									
								}
								
							  }
			});

	    }
	
	  };
	  $.validation(options);   		
  
}

}); // cierra jquery

</script>

</head>

<body>

<p id="validateErrors"></p>

   <div class="text ui-widget-content ui-corner-all" style="width:400px; margin-bottom:15px; height:auto; font-size:12px;">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MODIFICAR USUARIO SISTEMA</div>      
          
       <table style="margin-left:15px;">
       
        <tr>
        	<td><label>Nombre usuario:</label></td>
            <td><input type="text"  id="username" size="20" class="text ui-widget-content ui-corner-all" /></td>
            <td><img src="images/code.png" id="updusername"/></td>
        </tr>
       
       
       
        <tr>
        	<td><label >Contraseña:</label></td>
            <td><input type="password"  id="userpassword" size="15" class="text ui-widget-content ui-corner-all"/></td> 
             <td> <img src="images/editar nombre.png" id="updpassword" title="Editar Nombre"/></td>  
        </tr>
        
        
        <tr>
        	<td><label title="Nombre que aparecera en la pagina principal del Cupi">Nombre completo:</label></td>
            <td><input type="text"  id="usernamereal" size="30" class="text ui-widget-content ui-corner-all" /></td>
            <td> <img src="images/editar nombre.png" id="updname" title="Editar Nombre"/></td>  
        </tr>
       
       
        <tr>
        	<td><label>Perfil:</label></td>
            <td><input type="text"  id="perfil" size="20" class="text ui-widget-content ui-corner-all" /></td>
            <td> <img src="images/editar nombre.png" id="updperfil" title="Editar Nombre"/></td>  
            
      </tr>
      
      
      <tr>
        	<td><label>Estado:</label></td>
            <td><input type="text"  id="estado" size="20" class="text ui-widget-content ui-corner-all" /></td> 
            <td><img src="images/activo.png" id="updestado" title="Editar Estado" /></td>  
      </tr>
      
    
<tr>
      <td><button type="button" id="enviar"  style="font-size:11px; margin-top:5px; margin-bottom:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>
      
      </tr>
   </table>
  
 </div>
 
<div id="formusername" class="text ui-widget-content ui-corner-all" style="width:360px; margin-bottom:15px;  height:100px; font-size:12px;">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Modificar Nombre Usuario</div>      

<table style=" margin-left:10px;">
<tr>
<td><label>Nuevo Nombre Usuario:</label></td>
<td ><input type="text"  id="nuevousername" size="15" class="text ui-widget-content ui-corner-all"/></td>
</tr>
<tr>
<td><button  type="button" class="aceptar nuevousername formusername" style="font-size:11px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>


 
<div id="formnuevacontrasena" class="text ui-widget-content ui-corner-all" style="width:400px; margin-bottom:15px;  height:120px; font-size:12px;">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Modificar Contraseña Usuario</div>      
 
<table style=" margin-left:10px;">

<tr>
  <td><label>Nueva contraseña:</label></td>
  <td><input type="password"  id="newpassword" size="30" class="text ui-widget-content ui-corner-all" value=""/></td>
</tr>

<tr>
  <td><label>Introduce contraseña :</label></td>
  <td><input type="password"  id="oldpassword" size="30" class="text ui-widget-content ui-corner-all" value=""/></td>
</tr>

<tr>
 <td><button  type="button" class="aceptar newpassword formnuevacontrasena" style="font-size:11px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>




<div id="formnuevonombre" class="text ui-widget-content ui-corner-all" style="width:360px; margin-bottom:15px;  height:100px; font-size:12px;">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Modificar Nombre Interfaz</div>      
 
<table style=" margin-left:10px;">
<tr>
<td><label>Nuevo Nombre:</label></td>
<td><input type="text"  id="newname" size="30" class="text ui-widget-content ui-corner-all" value=""/></td>
</tr>
<tr>
 <td><button  type="button" class="aceptar newname formnuevonombre" style="font-size:11px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:3px;"/>Aceptar</button></td>

</tr>

</table>

</div>
 

<div id="formnuevoperfil" class="text ui-widget-content ui-corner-all" style="width:330px; margin-bottom:15px;  height:100px; font-size:12px;">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Modificar Perfil Usuario</div>      

 <table style=" margin-left:10px;">
 <tr>
  <td><label>Nuevo Perfil:</label></td>
  <td>
    <select size="1" id="newperfil">
    <?php
        do {  
              ?>
          <option value="<?php echo $row_JRPerfil['idPerfil']?>"><?php echo $row_JRPerfil['descripcion']?></option>
          <?php
         } while ($row_JRPerfil = mysql_fetch_assoc($JRPerfil));
           $rows = mysql_num_rows($JRPerfil);
           if($rows > 0) 
		   {
             mysql_data_seek($JRPerfil, 0);
             $row_JRPerfil = mysql_fetch_assoc($JRPerfil);
           }
        ?>
    
    </select>

</td>
</tr>
<tr>
<td><button  type="button" class="aceptar newperfil formnuevoperfil" style="font-size:11px;" ><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>


 
 <div id="formestado" class="text ui-widget-content ui-corner-all" style="width:220px;  height:100px; font-size:12px;">
<div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Modificar Estado Usuario</div>      

<table style=" margin-left:10px;">
<tr>
<td><label>Nuevo Estado:</label></td>
<td>
<select size="1" id="nuevoestado">
<option value="activo">Activo</option>
<option value="inactivo">Inactivo</option>
</select>

</td>
</tr>
<tr>
<td><button type="button" class="aceptar nuevoestado formestado" style="font-size:11px;" ><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>

</tr>
</table>

</div>

  <div id="alertas" ></div> 
   
    
</body>

</html>
