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
			$("#alertas").append(content);
			$("#alertas").dialog("open");
		}
		
		
		 function verificarNombreUsuario()
		 {
		
		   DupliNombreUsuario=$("#username").val();
		  	
		    if (DupliNombreUsuario!="")
		
		    {
		      $.ajax({
			
				 type:'POST',
				 url:'consultas/Usuario_Aplicacion/existenciaUsuarioSistema.php',
				 data: 'usuario='+DupliNombreUsuario,
				 success: function(datos){
			
				 if (datos==1)
				 {
				
					$("#username").val("");
					$("#username").addClass("ui-state-error");
					alertas("El usuario ya existe en la base de datos","Adicionar Usuario Sistema","error");	
				
				}
				else
				{
				   $("#username").removeClass("ui-state-error");
				   verificarContraseñas();
				}
			  }
			});
		   }
	    }
	

	function limpiar_formulario() 
	{
		$("#username").val(""); 
		$("#usernamereal").val(""); 
		$("#userpassword").val(""); 
		$("#Ruserpassword").val(""); 
			
	}
		
 
 
	 function verificarContraseñas()
	 {
		 contrasenaR= $("#Ruserpassword").val();
		 contrasenaN= $("#userpassword").val();
		
		if(contrasenaR==contrasenaN)
		{
			$("#Ruserpassword").removeClass('ui-state-error')
			insertarDatosUser();
		}
		else
		{
			$("#Ruserpassword").val("");
			$("#Ruserpassword").addClass('ui-state-error');
			alertas("Las Contraseñas no coinciden por favor escribalas correctamente","Crear Nuevo Usuario Sistema","error");
		}
	 }
	 
 

	
      $("#enviar").button().click(function(){
	
			// plugin de validacion
				
			var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"usernamereal",
					  validations:{
						 
						  required:[true,"El campo Nombre y Apellidos no puede estar vacio."]}
						 
				  }
				  ,
				  {
					  id:"username",
					       validations:{
					      required:[true,"El campo Nombre Usuario no puede estar vacio."]}				  
				  },
				  
				  {
					  id:"userpassword",
					  validations:{
						  
						  required:[true,"El campo Contraseña no puede estar vacio."],
						 
						  }
				  },	
				  
				  {
					  id:"Ruserpassword",
					  validations:{
						  
						  required:[true,"El campo Repetir Contraseña no puede estar vacio."],
						 
						  }
				  }		
				  	  
				  
				  ],				  
				  beforeValidation:function(){
					  
					verificarNombreUsuario();    
				 }
		        }; 
		       $.validation(options); 
            });
			   
			   
			   function insertarDatosUser()
			   {  
					 
				  nombreUsuario= $("#username").val();
				  nombreReal= $("#usernamereal").val();
				  contrasena= $("#userpassword").val();
				  perfil =$("#perfil").val();
					   
		
			      $.ajax({
					 type: 'POST',
					 url: 'funciones/Usuario_Aplicacion/insertusuarioA.php',
					 data: 'username='+nombreUsuario+'&usernamereal='+nombreReal+'&password='+contrasena+'&perfil='+perfil,
					 success: function(datos)
					 {
						 
						 if(datos==1)
						 {
						    alertas("Los datos se han ingresado correctamente","Adicionar Usuario Sistema","done");
						    limpiar_formulario(); 	
						 }
						else
						{
						   alertas("Por favor verifique los datos","Adicionar Usuario Sistema","error");
									
						}
				  }
			 });
		   }
						
	
}); // cierra el function
</script>


</head>

<body>
 
 <p id="validateErrors"></p>
 
 
 
<div id="formusuario" class="text ui-widget-content ui-corner-all" style="width:400px; height:auto; font-size:12px;">
  <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CREAR NUEVO USUARIO SISTEMA</div>
          
    <table style="margin-left:15px;">
     
        <tr>
        	<td><label>Nombre usuario:</label></td>
            <td><input type="text"  id="username" size="20" class="text ui-widget-content ui-corner-all" /></td>
        </tr>
       
       
       
        <tr>
        	<td><label >Contraseña</label></td>
            <td><input type="password"  id="userpassword" size="15" class="text ui-widget-content ui-corner-all"/></td>
             
        </tr>
        
        <tr>
        	<td><label >Repetir contraseña</label></td>
            <td><input type="password"  id="Ruserpassword" size="15" class="text ui-widget-content ui-corner-all"/></td>
             
        </tr>
        
         <tr>
        	<td><label title="Nombre que aparecera en la pagina principal del Cupi">Nombre completo:</label></td>
            <td><input type="text"  id="usernamereal" size="30" class="text ui-widget-content ui-corner-all" /></td>
        </tr>
       
       
        <tr>
        	<td><label>Perfil usuario:</label></td>
            <td>
            	<select size="1" id="perfil" class="text ui-widget-content ui-corner-all">
            	  <?php
                 do {  
                 ?>
            	  <option value="<?php echo $row_JRPerfil['idPerfil']?>"><?php echo $row_JRPerfil['descripcion']?></option>
            	  <?php
					} while ($row_JRPerfil = mysql_fetch_assoc($JRPerfil));
					  $rows = mysql_num_rows($JRPerfil);
					  if($rows > 0) {
						  mysql_data_seek($JRPerfil, 0);
						  $row_JRPerfil = mysql_fetch_assoc($JRPerfil);
					  }
					?>
                </select>
            </td>    
      </tr>
      
    
    <tr>
      <td><button type="button" id="enviar"  style="font-size:11px; margin-top:5px; margin-bottom:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>
    </tr>
    
   </table>
  
   </div> 
   
	<div id="alertas"></div>

    
</body>
</html>
<?php
mysql_free_result($JRPerfil);
?>
