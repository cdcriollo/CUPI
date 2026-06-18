<?php date_default_timezone_set("America/bogota"); ?>
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
$query_JRRecursos = "SELECT * FROM gruporecurso";
$JRRecursos = mysql_query($query_JRRecursos, $conexion) or die(mysql_error());
$row_JRRecursos = mysql_fetch_assoc($JRRecursos);
$totalRows_JRRecursos = mysql_num_rows($JRRecursos);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<script type="text/javascript">
$(function(){
	
	  $(".tableUI").styleTable();
	  var cadena= new Array();
	  var cadenaequipos= new Array();
	  $("#observaciones").hide();
	  $("#detallesalida").hide();
	  $('#detalleasignatura').hide();
	 	
	    
	   setInterval(function(){
	
	    momentoActual = new Date()
		horas = momentoActual.getHours()
		minutos = momentoActual.getMinutes()
		segundos = momentoActual.getSeconds()
		if (horas <= 9) horas = "0" + horas; 
        if (minutos <= 9) minutos = "0" + minutos; 
        if (segundos <= 9) segundos = "0" + segundos; 
		horaImprimible =horas+":"+minutos+":"+segundos;
		$("#hora").val(horaImprimible);
		},1000);
		
	
       $("#alertas" ).dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			height:"120",
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
		
		
		
		function limpiarformulario()
		{
			 $("#codusu").val(""); 
	         $("#nomusu").val(""); 
	         $("#sala").val(""); 
	         $("#comp").val(""); 
			 $("#actividad").val(""); 
			 
		}
		
		
	
	$("#codusu").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') {
	  
	     event.preventDefault();
	     usuario=$("#codusu").val();
	     salidausuario(usuario);
		 
	   } 
	});	
	
	$("#comp").keydown(function(event) {
	  //SI DA ENTER SE HACE LO SIGUIENTE
	  if (event.keyCode == '13') {
	  
	     event.preventDefault();
	     pcsalida=$("#comp").val();
		 $("#detallesalida").hide();
	     salidausuariofichapc(pcsalida);
		 
	   } 
	});	

	
	
	
$("#enviar").button().click(function(){
	
   var options = {
				 
		classerror:"ui-state-error",
		classdone:"ui-state-highlight",
		contentmsg:"validateErrors",
		fields:[
		{
			id:"codusu",
			validations:
			{
			  required:[true,"El campo Codigo no puede estar vacio."],
			  number:[true,"El campo Codigo debe contener numeros."]}
			}
		],
						  
	 beforeValidation:function(){
					 	
	
		cadena=[];
		cadenaequipos=[];
		
		$(".detRecursos").each(function(i){
		valor=$(this).text();
		cadena[i]=valor;
		
	  });
	  
	  $(".detEquipos").each(function(i){
		valorequipo=$(this).val();
		cadenaequipos[i]=valorequipo;
		
	  });
	 
	 codIngreso=$("#codingreso").val();

	 tamañocadena= cadena.length;
	 tamañoequipos=cadenaequipos.length;
	 
	 if(tamañocadena > 0){
	  updaterecursos=1;  	
	}
	else{
	  updaterecursos=0;  	
	}
	
	if(tamañoequipos > 0){
	  updateequipos=1;  	
	}
	else{
	  updateequipos=0;  	
	}
	
	observacion= $("#obs").val();
	pc=$("#comp").val();

	 $.ajax({
	  
			type: 'POST',
			url: 'funciones/Salida/ActualizarIngreso.php?arrayprestamo='+cadena,
			data: 'codIngreso='+codIngreso+'&updaterecursos='+updaterecursos+'&updateequipos='+updateequipos+'&observaciones='+observacion+'&pc='+pc,
			
			success: function(datos){
				
			if(datos==1111)
			{
			   $('#detalleasignatura').hide();
			   $('#observaciones').hide();
			   $("tbody", "#TableRecursos").remove();
			   $("#detallesalida").hide();
			   $("#salidausuarios").css({ width:"600px", height:"160"}); 
			   alertas("El usuario ha salido exitosamente de la sala","Salida Usuario","done");
			   limpiarformulario();	
			}
			else if(datos==11111)
			{
			   $('#detalleasignatura').hide();
			   $('#observaciones').hide();
			   $("tbody", "#TableRecursoEquipo").remove();
			   $("#detallesalida").hide();
			   $("#salidausuarios").css({ width:"600px", height:"160"}); 	
			   alertas("El usuario ha salido exitosamente de la sala","Salida Usuario","done");
			   limpiarformulario();	
			   
			}
			else if(datos==11)
			{
				$('#detalleasignatura').hide();
			    $('#observaciones').hide();
				$("#salidausuarios").css({ width:"600px", height:"160"}); 
			    alertas("El usuario ha salido exitosamente de la sala","Salida Usuario","done");
			    limpiarformulario();		
			}
			else if(datos==111)
			{
				
				$('#detalleasignatura').hide();
				$('#observaciones').hide();
				$("tbody", "#TableEquipos").remove();
				$("#detallesalida").hide();
				$("#salidausuarios").css({ width:"600px", height:"160"}); 
				alertas("El usuario ha salido exitosamente de la sala","Salida Usuario","done");
			    limpiarformulario();	
			}
			else 
			{
			  alertas("Ha ocurrido un error","Salida Usuario","error");
			}
		   }
		});	
       }
	 }; 
   $.validation(options);   


});// cierra enviar


       function salidausuario(usuario){
	
		// plugin de validacion
			
			
			var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"codusu",
					  validations:{
						 
						  required:[true,"El campo Codigo no puede estar vacio."],
						  number:[true,"El campo Codigo debe contener numeros."]}
				  }
				   
				  ],				  
				  beforeValidation:function(){
					 
				   $("tbody", "#detalleasignatura").remove();
			
	             $.ajax({
					 type: 'POST',
					 url: 'consultas/Salida/SalidaUsuario.php',
					 data: 'usuario='+usuario,
					 success: function(datos){
						  
						  
						  
						       if(datos==1)
								{
								  alertas("El usuario no existe","Salida Usuario","error");	
								}
								else if(datos==0)
								{
								  alertas("El usuario no ha tenido ingresos en el dia de hoy","Salida Usuario","error");		
								}
								
								 else
								 {
									     datossalida=datos.split('-');
									     $("#actividad").val(datossalida[0]);
										 $("#sala").val(datossalida[1]);
										 $("#comp").val(datossalida[2]);
										 $("#nomusu").val(datossalida[3]);
										 var estado= datossalida[4];
										 var idIngreso= datossalida[5];
										 $("#codingreso").val(idIngreso); 
										 codigoasignatura=datossalida[6];
										 grupoasignatura=datossalida[7];
										 nombreasignatura=datossalida[8];
										
									 
									   if( $("#actividad").val()=="Clase" || $("#actividad").val()=="Monitor de Clase")
									   {
										   
										  
										   $('#detalleasignatura').show();
										  $('#detalleasignatura').append('<tbody><td class="ui-widget-content">'+codigoasignatura+'</td><td class="ui-widget-content first">'+grupoasignatura+'                                          </td><td class="ui-widget-content first">'+nombreasignatura+'</td></tbody>');
										  $("#salidausuarios").css({ width:"600px", height:"250"}); 
									   
									   }
									   else
									   {
										 $('#detalleasignatura').hide();
										 $("#salidausuarios").css({ width:"600px", height:"auto"}); 
									   }   
							
									
									if(estado==2){
									
									  $.ajax({
										 type: 'POST',
										 url: 'consultas/Salida/consultarprestamo.php',
										 data: 'idIngreso='+idIngreso,
										 success: function(datos){
										    $("#Detalleprestamos").html(datos);
											$("#detallesalida").show();
										    $("#Detalleprestamos").show();
											 
									    }
									 }); 
									
									 }
									 else if(estado==3){
										 
										$.ajax({
										 type: 'POST',
										 url: 'consultas/Salida/consultarequiposexternos.php',
										 data: 'idIngreso='+idIngreso,
										 success: function(datos){
										    $("#Detalleequipos").html(datos);
											$("#detallesalida").show();
											$("#Detalleequipos").show();
											
									    }
									 });  
								   }
								   else if(estado==4){
									 
									 $.ajax({
										 type: 'POST',
										 url: 'consultas/Salida/consultarprestamoequipo.php',
										 data: 'idIngreso='+idIngreso,
										 success: function(datos){
										    $("#general").html(datos);
											$("#detallesalida").show();
											$("#general").show();
											
									    }
									 });    
								  }
								}// cierro else
							  }// cierro sucess
			                });// cierro ajax
					       }// cierro before validation
		                  }; 
		                 $.validation(options);   
          }// cierro funcion	
		  
		  
  
  
  function salidausuariofichapc(pc)
  {
	
		// plugin de validacion
			
			
			var options = {
				 
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"comp",
					  validations:{
						 
						  required:[true,"El campo Computador no puede estar vacio."],
						  number:[true,"El campo Computador debe contener numeros."]}
				  }
				   
				  ],
				  				  
				  beforeValidation:function()
				  {
					 
				   $("tbody", "#detalleasignatura").remove();
			
	                 $.ajax({
					   type: 'POST',
					   url: 'consultas/Salida/SalidaUsuarioFichaPc.php',
					   data: 'pc='+pc,
					   success: function(datos){
						  
						  
					   if(datos==0)
					   {
						  alertas("Por favor verifique que el computador haya sido usado o que el usuario haya tenido ingresos","Salida Usuario","error");		
					   }
								
					  else
					  {
						  datossalida=datos.split('-');
						  $("#actividad").val(datossalida[0]);
						  $("#sala").val(datossalida[1]);
						  $("#comp").val(datossalida[2]);
						  $("#nomusu").val(datossalida[3]);
						  var estado= datossalida[4];
						  var idIngreso= datossalida[5];
						  $("#codingreso").val(idIngreso); 
						  codigoasignatura=datossalida[6];
						  grupoasignatura=datossalida[7];
						  nombreasignatura=datossalida[9];
						  codigousuario=datossalida[8];
						  $("#codusu").val(codigousuario);
										  
									 
									   if( $("#actividad").val()=="Clase" || $("#actividad").val()=="Monitor de Clase")
									   {
										   
										  
										   $('#detalleasignatura').show();
										  $('#detalleasignatura').append('<tbody><td class="ui-widget-content">'+codigoasignatura+'</td><td class="ui-widget-content first">'+grupoasignatura+'                                          </td><td class="ui-widget-content first">'+nombreasignatura+'</td></tbody>');
										  $("#salidausuarios").css({ width:"620px", height:"250"}); 
									   
									   }
									   else
									   {
										 $('#detalleasignatura').hide();
										 $("#salidausuarios").css({ width:"620px", height:"160"}); 
									   }   
							
									
									if(estado==2){
									
									  $.ajax({
										 type: 'POST',
										 url: 'consultas/Salida/consultarprestamo.php',
										 data: 'idIngreso='+idIngreso,
										 success: function(datos)
										 {
											$("#detallesalida").show();
											$("#detallesalida").html(datos);	 
									    }
									 }); 
									
									 }
									 else if(estado==3){
										 
										$.ajax({
										 type: 'POST',
										 url: 'consultas/Salida/consultarequiposexternos.php',
										 data: 'idIngreso='+idIngreso,
										 success: function(datos)
										 {
										    $("#detallesalida").show();
											$("#detallesalida").html(datos);	
									    }
									 });  
								   }
								   else if(estado==4){
									 
									 $.ajax({
										 type: 'POST',
										 url: 'consultas/Salida/consultarprestamoequipo.php',
										 data: 'idIngreso='+idIngreso,
										 success: function(datos)
										 {
										    $("#detallesalida").show();
											$("#detallesalida").html(datos);
									    }
									 });    
								  }
								}// cierro else
							  }// cierro sucess
			                });// cierro ajax
					       }// cierro before validation
		                  }; 
		                 $.validation(options);   
          }// cierro funcion				
  
  
   				


$("#BtnObservaciones").button().toggle(function() {

  if($("#codusu").val() != "" && $("#actividad").val() != "" && codigoasignatura !="" )
  {
    $("#observaciones").show("");
    $("#salidausuarios").css({ height:"320px"}); 
  }
  else if($("#codusu").val() != "" && $("#actividad").val() != "" && codigoasignatura =="")
  {
     $("#observaciones").show("");
     $("#salidausuarios").css({ height:"220px"}); 
  } 
  else
  {
     alertas("Por favor verifique que exista una salida de usuario","Salida Usuario","error");		
  }

},function() {


   if($("#codusu").val() != "" && $("#actividad").val() != "" && codigoasignatura !="")
  {
    $("#observaciones").hide("");
	$("#salidausuarios").css({ height:"250px"}); 
  }
  else if($("#codusu").val() != "" && $("#actividad").val() != "" && codigoasignatura =="")
  {
     $("#observaciones").hide("");
     $("#salidausuarios").css({ height:"160px"}); 
  } 
  else
  {
     alertas("Por favor verifique que exista una salida de usuario","Salida Usuario","error");		
  }
    

});	
	   
	
}); // cierra el function
</script>



</head>

<body>
 

 <p id="validateErrors"></p>

               
      <div id="salidausuarios" class="text ui-widget-content ui-corner-all" style="width:620px; height:160px;          margin-bottom:15px; font-size:12px;">
      <div class="ui-state-default" style="margin-bottom:10px; text-align:center;">SALIDA USUARIOS</div>
 
       <table style="margin-left:10px;">
       
        <tr>
        	<td><label>Codigo Usuario:</label></td>
            <td><input type="text" name="codusu" id="codusu" size="15"  class="text ui-widget-content ui-corner-all" style="margin-right:10px;" /></td>
           <td><label>Actividad:</label></td>
           <td><input type="text" class="text ui-widget-content ui-corner-all" id="actividad" size="20"</td>
           
        
        </tr>
       
       </table>
       
       <table style="margin-left:10px;">
        <tr>
        	<td><label>Nombre:</label></td>
            <td><input type="text" name="nomusu" id="nomusu" size="40"  class="text ui-widget-content ui-corner-all" style="margin-right:10px;"/></td>
            <td><label>Fecha:</label></td>
            <td><input type="text" id="fecha" size="40"  class="text ui-widget-content ui-corner-all" value="<?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes", "Sábado");
		$mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$ano=date('Y');?> <?php echo ''. $dias[date('w')].' '.date('d').' de '.$mes[date('n')].' del '.$ano.'' ?>"/></td>    
             
        </tr>
     </table>  
     
     <table style="margin-left:10px;">
       
        <tr>
        	<td><label>Sala:</label></td>
            <td><input type="text" id="sala" size="5"  class="text ui-widget-content ui-corner-all" style="margin-right:10px;"/></td>
            <td><label>Computador:</label></td>
            <td><input type="text" id="comp" size="5"  class="text ui-widget-content ui-corner-all" value="" style="font-size:16px; color:#FF0000; text-align:center; font-weight:bold; margin-right:10px;"/></td>            
            <td><label>Hora de Salida:</label></td>
            <td><input type="text" id="hora" name="reloj" size="15"  class="text ui-widget-content ui-corner-all" value="" style="margin-right:10px;"/></td>
            <input type="hidden" id="descripasig"/>
        </tr>
       </table> 
        
        <table style="margin-left:10px;" id="observaciones">
         <tr>
           <td><textarea cols="50"  rows="3" id="obs" > </textarea> </td>
         </tr>
        </table>
    
    
    <table align="left" class="tableUI" border="1" id="detalleasignatura" cellspacing="0" width="400" style="margin-top:10px; margin-bottom:10px; margin-left:10px;">
      <thead>
        <th>Codigo</th>
          <th>Grupo</th>
          <th>Asignatura</th>
      </thead>  
      </table> 
      
     <div style="float:left"> 
      <table style="margin-left:10px;">
        <tr>    
            <td><button type="button" id="BtnObservaciones" style="font-size:11px; margin-top:5px;"><img src="images/obs.png" style="vertical-align:middle; "/>Observaciones</button></td>  
         <td><button type="button" id="enviar" style="font-size:11px; margin-top:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button> </td>   
          
      </tr>
     </table>  
     </div>
    
      <input type="hidden" id="codingreso"/>
      
   </div>

     
     <div id="detallesalida" style="overflow:auto; width:520px; min-height:0px; max-height:300px; margin-top:auto;">
       
    </div>
    
   
<div id="alertas"></div>
   
</body>
</html>
