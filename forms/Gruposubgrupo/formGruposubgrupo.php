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
$query_JRGrupos = "SELECT idTipo, descripcionTipo FROM gruporecurso";
$JRGrupos = mysql_query($query_JRGrupos, $conexion) or die(mysql_error());
$row_JRGrupos = mysql_fetch_assoc($JRGrupos);
$totalRows_JRGrupos = mysql_num_rows($JRGrupos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cupi-Control de Utilizacion Piso Informatico</title>




<script type="text/javascript">

$(function(){
	
	arraysubgrupo= new Array();
	$("#formmodSubgrupo").hide();
	$("#formmodGrupo").hide();
	
		
	
	$("#tabs").tabs();
		
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
		
		
  // Adiciona una fila al horario de clases	
  $('#añadir').click(function(){   

    $("#subgrupos").append('<tbody><td><input name="horario" type="checkbox" class="schedule" value="" /></td><td><input type="text" size="30" class="subgrupo text      ui-widget-content ui-corner-all" /></td></tbody>');

			 			  
});



 // Elimina una fila del horario de la asignatura 
  $('#eliminar').click(function(){
  
	$("#subgrupos").find("input:checked").parents("tr").remove();

  });


      function limpiar_formulario_elementos(ele) 
	  {
	 
	 
	 }
	
  
	
     $("#btnsubgrupo").button().click(function(){
		 
		 var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"dtipo",
					  validations:
					  {
					      required:[true,"El campo nombre no puede estar vacio."],
					  }
				  }
				  
				  ],				  
				  beforeValidation:function()
				  {
					  
		            Nombregrupo=$("#dtipo").val();
				   
				    arraysubgrupo=[];
								
					$(':input.subgrupo').each(function(i){
						valor=$(this).val();
						arraysubgrupo[i]=valor;
				   }); 
				   
				   tamañocadena=arraysubgrupo.length;
					  
			       if(tamañocadena != 0)
			       {
			          $.ajax({
				
				        type: 'POST',
				        url: 'funciones/Gruposubgrupo/insertarGruposubgrupo.php',
				        data: 'descripTipo='+Nombregrupo+'&subgrupos='+arraysubgrupo,
					  
				        success: function(data)
					    { 
					       if(data==11)
						   {
							 alertas("El grupo y subgrupo(s) se han insertado correctamente","Crear grupo-subgrupo","done");  
						   }
						   else
						   {
							  alertas("Se ha producido un error en la inserción","Crear grupo-subgrupo","error")  
						   }
					     
					    }
					 });
			       }
				   else
				   {
					  alertas("Por favor defina un subgrupo","Crear grupo-subgrupo","error")  
				   }
				  }
				 }; 
			   $.validation(options);   
	         });
			 
			 
			 $("#Grupos").change(function(){
				  
				keytipo=$("#Grupos").val();
				mostrarSubgrupos(keytipo) 
				
			 });
			 
			 function mostrarSubgrupos(llave)
			 {
				 
			    $.ajax({
				
				   type: 'POST',
				   url: 'consultas/Gruposubgrupo/consultarSubgrupos.php',
				   data: 'idTipo='+llave,
					  
				   success: function(datos)
				   { 
					  $("#Detallesubgrupos").html(datos);
					  $("#formupdateSubgrupo").show();	
			       }
						
			 });
				 
		   }
			
			
			
		 $("#editargrupo").button().click(function() {
			 
            $("#formmodGrupo").show("slide");
			
          });
		  
		 	
	     $("#upddescgrupo").button().click(function () {
			 
			nuevadescripcionG=$("#nuevonombre").val();
			idTipo=$("#Grupos").val();
			oper="updategrupo";
			
			$.ajax({
				
				   type: 'POST',
				   url: 'funciones/Gruposubgrupo/updateGrupoSubgrupo.php',
				   data: 'llave='+idTipo+'&nuevovalor='+nuevadescripcionG+'&oper='+oper,
					  
				   success: function(datos)
				   { 
					  if(datos==1)
					  {
						alertas("El grupo se ha modificado correctamente","Modificar grupo","done");
						$("#formmodGrupo").hide("slide");    
					  }
					  else if (datos==0)
					  {
						alertas("Hubo un problema en la actualización, por favor intente mas tarde","Modificar grupo","error")    
					  }
			       }
						
			 });
				 
	    });
		
		
		$("#editarsubgrupo").button().click(function () {
			
			var contadorsubgrupo=0; 
			 
			if($(".checksubgrupo").is(":checked"))
           {	
	        
			 $("input:checked.checksubgrupo").each( 
				function(i) {
				  idsubtipo= $(this).val();	 
				  contadorsubgrupo+=1;
			 });
			
			 
				if(contadorsubgrupo==1)
				{  
				  valor=$("#Detallesubgrupos").find("input:checked").parents("tr");
				  descripcionSubgrupo= valor.find("td").eq(1).text();
				  $("#nuevonombresubgrupo").val(descripcionSubgrupo);
				  $("#formmodSubgrupo").show("slide"); 
				}
				else if(contadorsubgrupo > 1)
				{
					alertas("Por favor seleccione una sola opcion","Modificar grupo","warning");  
				}
				
				
		   }
		   else if (contadorsubgrupo==0)
		   {
			  alertas("Por favor seleccione una opcion","Modificar grupo","warning"); 
		   }
				 
	    });
		
		
		$("#upddescsubgrupo").button().click(function () {
			
			nuevadescripcionGS=$("#nuevonombresubgrupo").val();
			oper="updatesubgrupo";
			
			$.ajax({
				
				   type: 'POST',
				   url: 'funciones/Gruposubgrupo/updateGrupoSubgrupo.php',
				   data: 'idsubTipo='+idsubtipo+'&nuevovalor='+nuevadescripcionGS+'&oper='+oper,
					  
				   success: function(datos)
				   { 
					  if(datos==1)
					  {
						alertas("El subgrupo se ha modificado correctamente","Modificar subgrupo","done");
						$("#formmodSubgrupo").hide("slide");
						llavetipo=$("#Grupos").val();
						mostrarSubgrupos(llavetipo);
						    
					  }
					  else if (datos==0)
					  {
						alertas("Hubo un problema en la actualización, por favor intente mas tarde","Modificar subgrupo","error")    
					  }
			       }
						
			 });
		});
		
		
	 
	   
		   
	
}); // cierra el function
</script>


</head>

<body>
 
 <p id="validateErrors"></p>
 
 <div id="tabs" style="width:500px; min-height:0px;">
	<ul>
		<li><a href="#addgruposubgrupo">Adicionar</a></li>
		<li><a href="#updategruposubgrupo">Modificar</a></li>
		
	</ul>
    
   <!--Formulario para adicionar un grupo  y un subgrupo --> 
   
<div id="addgruposubgrupo"> 
 
<div id="formGrupo" class="text ui-widget-content ui-corner-all" style="width:400px; height:auto; font-size:12px; margin-bottom:10px;">
  <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CREAR NUEVO GRUPO</div>
          
    <table style="margin-left:15px; margin-bottom:10px;">
       
        <tr>
          <td><label for="titulo">Nombre:</label></td>
          <td><input type="text" name="dtipo" id="dtipo" size="20"  class="text ui-widget-content ui-corner-all" /></td>
        </tr>
          
   </table>
  
   </div> 
   
   
   <div id="formSubgrupo" class="text ui-widget-content ui-corner-all" style="width:400px; height:auto; font-size:12px;">
  <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CREAR NUEVOS SUBGRUPOS</div>
          
    <p><img src="images/add1.png" id="añadir" title="Adiciona un subgrupo" style="padding-right:2px;"/> <img src="images/delete.png" id="eliminar" title="Elimina un subgrupo" style="padding-right:3px;"/></p>
     
     
    
    <table id="subgrupos" style="margin-left:15px; margin-bottom:15px">
    <thead>
    
        <th></th>    
    	<th>Descripción</th>
        
    </thead> 
    
    <tbody><td><input type="checkbox"  value="" /></td><td><input type="text" size="30" class="subgrupo text ui-widget-content ui-corner-all" id="dsubgrupo"/></td>
    </tbody>  
  </table>
  
   </div> 
   
   <button type="button" id="btnsubgrupo" style="font-size:12px; margin-top:15px; margin-left:10px; margin-bottom:10px; "><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Crear grupo-subgrupo </button>
   
     </div><!-- cierro div Adicusuario-->
     
    <!--Formulario para modificar los datos del grupo y subgrupo  -->
     
<div id="updategruposubgrupo"> 
 
<div id="formupdateGrupo" class="text ui-widget-content ui-corner-all" style="width:400px; height:auto; font-size:12px; margin-bottom:10px;">
  <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MODIFICAR GRUPO</div>
          
    <table style="margin-left:15px; margin-bottom:10px;">
       
        <tr>
          <td><label for="titulo">Grupo:</label></td>
          <td><select name="Grupos" id="Grupos" size="1">
            <?php
              do {  
            ?>
            <option value="<?php echo $row_JRGrupos['idTipo']?>"><?php echo $row_JRGrupos['descripcionTipo']?></option>
            <?php
			} while ($row_JRGrupos = mysql_fetch_assoc($JRGrupos));
			  $rows = mysql_num_rows($JRGrupos);
			  if($rows > 0) {
				  mysql_data_seek($JRGrupos, 0);
				  $row_JRGrupos = mysql_fetch_assoc($JRGrupos);
			  }
			?>
          </select></td>
          </tr>
         </table>
          
        <table style="margin-left:15px; margin-bottom:10px;">
          <tr>
          <td><button type="button" id="editargrupo"> <img src="images/edit1.png" style="vertical-align:middle; padding-right:4px;" />Modificar grupo</button></td>
        </tr>
       </table>
  
   </div> 
   
   <div id="formupdateSubgrupo" class="text ui-widget-content ui-corner-all" style="width:460px; height:auto; font-size:12px; margin-bottom:10px;">
     <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MODIFICAR SUBGRUPO(S)</div>
       <div id="Detallesubgrupos">
       
       </div>
      <button type="button" id="editarsubgrupo" style="font-size:12px; margin-top:10px; margin-left:10px; margin-bottom:10px; "><img src="images/edit1.png" style="vertical-align:middle; padding-right:4px;" />Modificar subgrupo</button> 
   </div>    
   
      </div><!-- cierro div Adicusuario-->
    </div><!-- cierro tabs-->
     
     <div id="formmodGrupo" class="text ui-widget-content ui-corner-all" style="width:420px; height:auto; font-size:12px; margin-bottom:10px; margin-top:10px;">
     <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Cambiar Descripción Grupo</div>
     
      <table style="margin-left:15px; margin-bottom:10px;">
       
        <tr>
          <td><label for="titulo">Nuevo Nombre:</label></td>
          <td><input type="text" name="nuevonombre" id="nuevonombre" size="40"  class="text ui-widget-content ui-corner-all" /></td>
        </tr>
        
      </table>
       
       <table> 
       
        <tr>
         <td><button type="button" id="upddescgrupo" style="font-size:12px; margin-top:10px; margin-left:10px; margin-bottom:10px; "><img src="images/edit1.png" style="vertical-align:middle; padding-right:4px;" />Guardar Cambios</button> </td>
       </tr>
          
     </table>
     
       
   </div> 
   
   <div id="formmodSubgrupo" class="text ui-widget-content ui-corner-all" style="width:400px; height:auto; font-size:12px; margin-bottom:10px; margin-top:10px;">
     <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Cambiar Descripción Subgrupo</div>
     
      <table style="margin-left:15px; margin-bottom:10px;">
       
        <tr>
          <td><label for="titulo">Nuevo Nombre:</label></td>
          <td><input type="text" name="nuevonombresubgrupo" id="nuevonombresubgrupo" size="30"  class="text ui-widget-content ui-corner-all" /></td>
        </tr>
        
      </table>
        
        
        <table>
        
        <tr>
        <td><button type="button" id="upddescsubgrupo" style="font-size:12px; margin-top:10px; margin-left:10px; margin-bottom:10px; "><img src="images/edit1.png" style="vertical-align:middle; padding-right:4px;" />Guardar Cambios</button> </td>
       </tr>
          
     </table>
     
       
   </div> 
   
	<div id="alertas"></div>

    
</body>
</html>
<?php
mysql_free_result($JRGrupos);
?>
