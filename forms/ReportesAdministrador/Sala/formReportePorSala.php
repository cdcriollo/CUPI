
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>


<script type="text/javascript">


$(function(){
	
	
	$("#html").hide();
	$("#horaI").timepicker({divId: "mytimepicker"});
    $("#horaF").timepicker({divId: "mytimepicker"});
	var ArrayDias= new Array();
	
	
	$.datepicker.setDefaults($.datepicker.regional['es']);
	
	 $("#desde" ).datepicker({ 
              dateFormat:'yy-mm-dd',
              defaultDate: +7,
			  changeMonth: true,
			  changeYear: true,
	 });
	 
	$('#hasta').datepicker({
	
	   dateFormat:'yy-mm-dd',
       defaultDate: +7,
	   changeMonth: true,
	   changeYear: true
	
	
	});
	
	$("#dia").multiselect({
	  selectedList: 5
	 
   })
   
   $("#sala").multiselect({
	  selectedList: 5
	 
   })

  
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
		
		
		
	
	$("#enviar").button().click(function(){
	 
	   var options = {
				  
				  classerror:"ui-state-error",
				  classdone:"ui-state-highlight",
				  contentmsg:"validateErrors",
				  fields:[
				  {
					  id:"desde",
					  validations:{
						 
						  required:[true,"El campo desde no puede estar vacio."],
						  }
				  }
				  ,
				  
				  {
					  id:"hasta",
					       validations:{
					       required:[true,"El campo Hasta no puede estar vacio."],
						  
						  }				  
				  }
				  ],	
				  			  
				  beforeValidation:function(){
		
					
					  var sala=$("#sala").val();
					  var horaI= $("#horaI").val();
					  var horaF= $("#horaF").val();
					  var dia= $("#dia").val();	
					  var fechainicio=$("#desde").val();
					  var fechafinal=$("#hasta").val();	
					  var horainicial=$("#horaI").val();
					  var horafinal=$("#horaF").val();
					  	
					  var sql="select h.*, a.nomAsignatura from horario h inner join asignatura a on (a.codAsignatura=h.codAsignatura) where fechaInicio between '"+fechainicio+"' and '"+fechafinal+"'";
					  var filtro="";
					  
					  if(sala!= null)	
					  {
						filtro= "and sala in ("+sala+")"+'' ;   
						sql= sql+filtro; 
						 
					  }
					  if(dia != null)
					  {
						filtro= "and codDia in ("+dia+")"+'' ;   
						sql= sql+filtro; 
						 
					  }
					  
					  if(horainicial != "" && horafinal != "")
					  {
						separarhorainicial= horainicial.split(':');
						separarhorafinal= horafinal.split(':');
					
						
						if(separarhorainicial[0] <=9)
						 {
							horainicial= "0"+separarhorainicial[0]+":"+separarhorainicial[1]+":"+"00"; 
							 
						 }
						 else 
						 {
							horainicial= horainicial+":"+"00"; 
						 }
						 
						 if(separarhorafinal[0] <=9)
						 {
							horafinal= "0"+separarhorafinal[0]+":"+separarhorafinal[1]+":"+"00"; 
							 
						 }
						 else 
						 {
							horafinal= horafinal+":"+"00"; 
						 }
						 
						 
						filtro= "and horainicio >= '"+horainicial+"' and horafinal <= '"+horafinal+"' " ;   
						sql= sql+filtro; 
						 
					  }
				
					
				 $.ajax({
						  
					type:'POST',
					url: 'consultas/InformeHorarios/consultarHorario.php',
					data:'sql='+sql+'&fechainicial='+fechainicio+'&fechafinal='+fechafinal,
					
					success: function(datos){
						
						$("#horariosala").html(datos);
						
					}
				  });
			   
			   }// cierro before validation
		      }; 
		     $.validation(options);  
		  });
	
	
	$("#limpiar").button().click(function(){
	     
		 $("#desde").val("");
	     $("#hasta").val("");	
		 $("#horaI").val("");
		 $("#horaF").val("");	
		 $("#horariosala").empty();
		 $("#desde").focus();
		 
	});
	
	
	
  function exportar_excel(id_form, id_tabla)
  {
	  // Obtiene el contenido de la tabla indicada
      var tabla = $("." + id_tabla).html();
	 // Añade los tags de tabla
	 tabla = "<table>" + tabla + "</table>";
	 // Almacena en el campo oculto los datos a exportar
	 $("#datos_a_enviar").val( tabla );
	 // Activa el formulario, el cual lanza el código en PHP
     $("#" + id_form).submit();
	 
   }
	
	$("#exportar").click(function(){
		
	   exportar_excel('form_excel_horarios', 'informehorarios');
	
	});
	
	$("#pdf").click(function(){
		
		 html= $('.informehorarios').html();
		 
		cadenahtml='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>Informe Horarios</title></head> <body style="margin-top:30px; margin-left: 250px; margin-right: 250px;"><center><table width="600" class="informehorarios" id="informehorarios" cellpadding="0" cellspacing="0" > '+html+ '</table></center></body> </html>'
		
		$("#html").text(cadenahtml);//al text area le asigno toda la variable html
		
										  
	   $("#frmpdf").submit();//envio el formulario
	
	
	});
	
	
	$("#print").click(function(){
	  
	   $("#horariosala").printArea();
		
	});
	
	
}); // cierra el function
</script>


</head>

<body>
 

 <p id="validateErrors"></p>


        
 <div id="recursos" class="text ui-widget-content ui-corner-all" style="width:700px; margin-bottom:15px; height:auto; font-size:12px;">
   <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">INFORME SALAS</div> 
   
   <table style="margin-left:5px;">
      <tr>
       <td><label style="margin-left:10px;" >Desde:</label></td>
       <td><input type="text" size="15" id="desde" class="text ui-widget-content ui-corner-all"/></td>
       <td><label style="margin-left:10px;">Hasta:</label></td>
       <td><input type="text" size="15" id="hasta" class="text ui-widget-content ui-corner-all"/></td>
       <td><label style="margin-left:10px;" >Hora Inicial:</label></td>
       <td><input type="text" size="8" id="horaI" class="text ui-widget-content ui-corner-all" /></td>
       <td><label style="margin-left:10px;">Hora Final:</label></td>
       <td><input type="text" size="8" id="horaF" class="text ui-widget-content ui-corner-all" /></td>  
      </tr>
   </table>
       
   <table style="margin-left:5px;">
   
    <tr> 
    
    <td><label style="margin-left:10px;">Dia:</label></td>
        <td>
           <select size="1" id="dia" multiple="multiple" class="text ui-widget-content ui-corner-all">
           <option value="1">Lunes</option>
           <option value="2">Martes</option>
           <option value="3">Miercoles</option>
           <option value="4">Jueves</option>
           <option value="5">Viernes</option>
           <option value="6">Sabado</option>
           </select>
      </td>
         
       <td><label>Sala:</label></td>
        <td><select size="1" multiple="multiple" class="text ui-widget-content ui-corner-all" id="sala">
           <option value="1">1</option>
           <option value="2">2</option>
           <option value="3">3</option>
           <option value="4">4</option>
           <option value="5">5</option>
           <option value="6">6</option>
           <option value="7">7</option>
         </select>
         </td>
       </tr>
   </table>
       
    <table style="margin-left:15px;">
     <tr>
     <td><button type="button" id="enviar"  style="font-size:11px; margin-bottom:10px; margin-top:10px;"> <img src="images/aceptar.png"  style="vertical-align:middle; padding-right:3px"/>Aceptar</button></td>
     <td><button type="button" id="limpiar"  style="font-size:11px; margin-bottom:10px; margin-top:10px;"> <img src="images/broom.png"  style="vertical-align:middle; padding-right:3px"/>Limpiar</button></td>
     
     </tr>
    </table>  
 </div>
 
  <div id="horariosala" style="margin-bottom:15px; min-width:0; max-width:720px; max-height:400px; min-height:0px; overflow: auto; visibility: visible;"></div>
   
 
 
 <p><a href="#" id="exportar"  title="Exportar a Excel" style="padding-top:5px;"><img src="images/exportaraexcel.png" /></a><a href="#"  title="Exportar a Pdf" id="pdf"> <img src="images/Exportarapdf.png" /></a> <a href="#"  title="Imprimir" id="print"> <img src="images/document-print.png" /></a> </p>
 
 <form action="forms/ReportesAdministrador/Sala/FicheroExcelInfHorarios.php" id="form_excel_horarios"  method="post" target="_blank">
          <!-- Inicia el proceso de exportar -->
        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>  
 </form>
 
 
 <form action="forms/ReportesAdministrador/Sala/formpdfhorarios.php" method="post" id="frmpdf">
   <textarea id="html" name="html"></textarea>
</form>


 
<div id="alertas"></div>	   
</body>
</html>
