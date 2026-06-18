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
<title>Documento sin título</title>


<script type="text/javascript" >
$(function () {
	
		
$("#Buscar").button().click(function(){
	
	BusquedaUsuarioAvanzada();
	
});	


  $("#searchString").keydown(function(event) {
	//SI DA ENTER SE HACE LO SIGUIENTE
	 if (event.keyCode == '13') {
	    event.preventDefault();
	    BusquedaUsuarioAvanzada();
    } 
  });	




function BusquedaUsuarioAvanzada()
{
	
	 var options = {
				 
	  classerror:"ui-state-error",
	  classdone:"ui-state-highlight",
	  contentmsg:"validateErrors",
	  fields:[
	  {
	    id:"searchString",
		validations:{
		 required:[true,"El campo de busqueda no puede estar vacio."]
		
		}
	 }
	],
				 
  beforeValidation:function()
  {
	
	cadena= $("#searchString").val();
	campobusqueda=$("#searchField").val();
	parametro= $("#searchOper").val();
	
   $.ajax({
	   
	 type:'POST',
	 url: 'consultas/Usuario_Aplicacion/BusquedaAvanzadaUsuarioA.php',
	 data:'searchString='+cadena+'&searchField='+campobusqueda+'&searchOper='+parametro,
	 success: function(datos)
	 {
		$("#mostrarbusqueda").html(datos);
	    $("#searchString").val("");
	 }
    });
   }
 };
  $.validation(options);   	
	
}


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
			  
			
});

</script>

</head>

<body>


<p id="validateErrors"></p>


    <div id="busquedaavanzusu" class="text ui-widget-content ui-corner-all" style="width:500px; height:auto; margin-top:20px;">
      <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">BUSQUEDA AVANZADA USUARIO SISTEMA</div>
      
      <table style="margin-left:15px;">
      <tr>
       <td><label>Buscar Por:</label></td>
       <td>
       <select size="1" id="searchField">
         <option value="nombreUsuario">Nombre Usuario</option>
       </select>
       </td>
       
       <td>
        <select size="1" id="searchOper">
         <option value="eq">Igual</option>
         <option value="ne">No igual a</option> 
         <option value="bw">Empiece por</option>
         <option value="bn">No empiece por</option> 
         <option value="ew">Termina por</option>
         <option value="en">No termina por</option> 
         <option value="cn">Contiene</option>
         <option value="nc">No contiene</option> 
       </select>
       
       </td>
       
    
       <td><input type="text" id="searchString" size="20" class="text ui-widget-content ui-corner-all"/></td>
       
      </tr>
      
      <tr>
      <td><button type="button" id="Buscar" style="font-size:11px; margin-bottom:5px; margin-top:5px;"><img src="images/buscar1.png" style="vertical-align:middle; padding-right:4px;"/>Buscar</button></td>
      </tr>
      
      </table>
      
     </div> 
     
     <div id="mostrarbusqueda" style="margin-top:20px; margin-bottom:20px; overflow:auto; width:500px; height:100px; ">
     
     
     </div>
    
 <div id="alertas"></div>  
   
    
</body>

</html>
