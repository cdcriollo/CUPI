
<?php session_start(); 
if(isset($_SESSION['nombreusuario'])){
			if(isset($_SESSION['contrasena']))
			{			
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cupi- Control de Utilizacon del Piso Informatico</title>

<!--Javascripts -->
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>-->
<script type="text/javascript" src="js/controller.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.5.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" src="jqueryprintarea/jquery.PrintArea.js"></script>
<script type="text/javascript" src="jQueryTimePicker0.3/jquery.mousewheel.js"></script>
<script type="text/javascript" src="jQueryTimePicker0.3/jquery.timepicker.js"></script>
<script type="text/javascript" src="BeforeValidation/js/valierrors/valierrors.js"></script>
<script type="text/javascript" src="js/styleTablesUI.js"></script>
<script type="text/javascript" src="js/Timer.js"></script>
<script src="js/i18n/grid.locale-es.js" type="text/javascript"></script>
<script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="js/jquery-multiselect.js" type="text/javascript"></script>

<!-- CSS-->
<link href="CSS/estilo.css" rel="stylesheet" type="text/css" />
<link href="CSS/niceforms-default.css" rel="stylesheet" type="text/css" />
<link href="CSS/menu.css" rel="stylesheet" type="text/css" />
<link href="CSS/tabla.css" rel="stylesheet" type="text/css" />
<link href="jQueryTimePicker0.3/timepicker.css" rel="stylesheet" type="text/css" />
<link href="CSS/button.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css" />
<link href="CSS/redmond/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="CSS/styleTablesUI.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="CSS/estilopop.css" type="text/css"/>
<link rel="stylesheet" type="text/css" href="CSS/jquery-multiselect.css" type="text/css"/>

<style>

.Bienvenida
{
  float:right; 
  font-weight:bold; 
  color:#FFF; 
  margin-top:50px; 
  margin-right:20px; 
  font-size:16px; 
  font:Arial, Helvetica, sans-serif;	
}

.logout
{
    float:right;
	margin-right:10px; 
	font-size:12px; 
    font:Arial, Helvetica, sans-serif;
	margin-top:20px;	 	
}

</style>


<script type="text/javascript">

$(function(){  
$('#usuarios').hide();
$('#asignaturas').hide();
$('#matriculas').hide();
$('#recursos').hide();
$("#consultas").hide();
$('#ingresos').hide();
$('#salidas').hide();
$("#consultasR").hide();
$("#useraplication").hide();
$("#herramientas").hide();
$("#reserva_eventual").hide();
$("#utilidades").hide();
$("#monitores").hide();
$('.minus').hide();


$('.plus').click(function(){
	arraysubmenus=$(this).attr('class').split(' ');
	submenus=arraysubmenus[1];
	$(this).parents().find('ul#'+submenus).show('slow');
	$(this).hide('slow');
	$(this).parent().find('.minus').show('slow');
	
});


$('.minus').click(function(){
	arraysubmenus=$(this).attr('class').split(' ');
	submenus=arraysubmenus[1];
	$(this).parents().find('ul#'+submenus).hide('slow');
	$(this).hide('slow');
	$(this).parent().find('.plus').show('slow');
	   
});



});// cierra el jquery

</script>

</head>

<body>

<div class="container">
  <div class="header">
  <div class="barraunivalle"><img src="images/logoheader.png" />
  <label class="Bienvenida"><?php echo "Bienvenido(a)"." ". $_SESSION['nombre']?></label>
  </div>
  <div class="barracupi">
  <div><a href="funciones/CerrarSesion/logout.php" id="logout" class="logout" style="text-decoration:none;"><img src="images/1284991526_Profile.png" style="vertical-align:middle; padding-right:12px;"/>Cerrar Sesion</a></div>
  </div>
  <!-- end .header --></div>
  
  
  

  <div class="sidebar1">
  
  

 <?php if($_SESSION['perfil']==1)//gerente
 {?>
  
<div class="glossymenu borderRad5">
 <!--menu de la aplicacion-->
<a class="menuitem submenuheader" href="#" ><img src="images/plus.gif" align="right" class="plus usuarios" /><img src="images/minus.gif" align="right" id="minus" class="minus usuarios" /><img src="images/usuario.png" style="vertical-align:middle; padding-right:3px" />Usuarios</a>
<div class="submenu">
	<ul id="usuarios">
	<li id="adicusuario"><a href="#"><img src="images/add1.png" style="padding-right:5px;"/>Crear Nuevo </a></li>
	<li id="consusuario"><a href="#"><img src="images/Search.png" style="padding-right:5px;"/>Consultar</a></li>
    <li id="modusuario"><a href="#"><img src="images/modify.png" style="padding-right:5px;"/>Modificar </a></li>
	<li id="cancelar"><a href="#"><img src="images/cancel.png" style="padding-right:5px;"/>Inactivar Usuario</a></li>
        <li id="carga_usuario"><a href="#"><img src="images/masive_user.png" style="padding-right:5px;"/>Carga Masiva</a></li>

	</ul>
</div>
<a class="menuitem submenuheader" href="#" ><img src="images/plus.gif" align="right" class="plus asignaturas" /><img src="images/minus.gif" align="right" id="minus" class="minus asignaturas" /><img src="images/asignatura.png" style="vertical-align:middle; padding-right:3px"/>Asignaturas</a>
<div class="submenu">
	<ul id="asignaturas">
	<li id="adicasignatura"><a href="#"><img src="images/add1.png" style="padding-right:5px;"/>Crear Nuevo </a></li>
	<li id="consultarAsig"><a href="#"><img src="images/Search.png" style="padding-right:5px;"/>consultar</a></li>
    <li id="updateasig"><a href="#"><img src="images/modify.png" style="padding-right:5px;"/>Modificar</a></li>
	</ul>
</div>

<a class="menuitem submenuheader" href="#"><img src="images/plus.gif" align="right" class="plus reserva_eventual" /><img src="images/minus.gif" align="right" id="minus" class="minus reserva_eventual "/><img src="images/reserva.png" style="vertical-align:middle;" />Reserva</a>
 <div class="submenu">
	<ul id="reserva_eventual">
	<li id="addreserva"><a href="#"><img src="images/add1.png" style="padding-right:5px; vertical-align:middle"/>Crear Reserva</a></li>
    <li id="searchreserva"><a href="#"><img src="images/Search.png" style="padding-right:5px; vertical-align:middle"/>Consultar Reserva</a></li>
    <li id="updatereserva"><a href="#"><img src="images/modify.png" style="padding-right:5px; vertical-align:middle"/>Modificar Reserva</a></li>
    <li id="eliminarAsig"><a href="#"><img src="images/cancel.png" style="padding-right:5px;"/>Cancelar Reserva</a></li>
    <li id="matreserva"><a href="#"><img src="images/matriculareserva.png" style="padding-right:5px; vertical-align:middle"/>Matricular Reserva</a></li>
    <li id="consultarreserva"><a href="#"><img src="images/Search.png" style="padding-right:5px; vertical-align:middle"/>Consultar Matricula</a></li>
    <li id="modmatreserva"><a href="#"><img src="images/modify.png" style="padding-right:5px; vertical-align:middle"/>Modificar Matricula</a></li>
    </ul>
 </div>
  
<a class="menuitem submenuheader" href="#"><img src="images/plus.gif" align="right" class="plus recursos" /><img src="images/minus.gif" align="right" id="minus" class="minus recursos" /><img src="images/recurso.png" style="vertical-align:middle"/>Recursos</a>
<div class="submenu">
	<ul id="recursos">
	<li id="Adicrecurso"><a href="#"><img src="images/add1.png" style="padding-right:5px;"/>Crear  nuevo</a></li>
    <li id="ConsRecurso"><a href="#"><img src="images/Search.png" style="padding-right:5px;"/>Consultar</a></li>
	<li id="modrecurso"><a href="#"><img src="images/modify.png" style="padding-right:5px;"/>Modificar</a></li>
	</ul>
</div>

<a class="menuitem submenuheader" href="#"><img src="images/plus.gif" align="right" class="plus monitores" /><img src="images/minus.gif" align="right" id="minus" class="minus monitores" /><img src="images/monitores.png" style="vertical-align:middle; padding-right:3px"/>Monitores</a>
<div class="submenu">
	<ul id="monitores">
	 <li id="Addmonitor"><a href="#"><img src="images/add1.png" style="padding-right:5px;"/>Crear Monitor</a></li>
     <li id="searchmonitor"><a href="#"><img src="images/Search.png" style="padding-right:5px;"/>Consultar Monitor</a></li>
	 <li id="updatemonitor"><a href="#"><img src="images/modify.png" style="padding-right:5px;"/>Modificar Monitor</a></li>
     <li id="Addvinculacion"><a href="#"><img src="images/vinculate.png" style="padding-right:5px;"/>Vincular Monitor</a></li>
     <li id="searchvinculacion"><a href="#"><img src="images/Search.png" style="padding-right:5px;"/>Consultar Vinculacion</a></li>
     <li id="updatevinculacion"><a href="#"><img src="images/modify.png" style="padding-right:5px;"/>Modificar Vinculacion</a></li>
	</ul>
</div>

<a class="menuitem submenuheader" href="#"><img src="images/plus.gif" align="right" class="plus consultas" /><img src="images/minus.gif" align="right" id="minus" class="minus consultas" /><img src="images/informe.png" style="vertical-align:middle; padding-right:3px"/>Informes</a>
<div class="submenu">
 <ul id="consultas">
	<li id="Utilizacion"><a href="#"><img src="images/1313781717_preferences-system-time.png" style="padding-right:5px; vertical-align:middle"/>Utilizacion</a></li>
    <li id="Horarios"><a href="#"><img src="images/ReporteHorario.png" style="padding-right:5px; vertical-align:middle"/>Horarios</a></li>
	<li id="Asistencia"><a href="#"><img src="images/Loading.png" style="padding-right:5px; vertical-align:middle"/>Asistencia</a></li>
    <li id="informerecursos"><a href="#"><img src="images/scanner.png" style="padding-right:5px; vertical-align:middle"/>Recursos</a></li>
    <li id="listadoclase"><a href="#"><img src="images/books.png" style="padding-right:5px; vertical-align:middle"/>Listado de Clase</a></li>
    <li id="infreservas"><a href="#"><img src="images/reserva.png" style="padding-right:5px; vertical-align:middle"/>Reservas</a></li>
    <li id="repmonitoresadmin"><a href="#"><img src="images/pmonitores.png" style="padding-right:5px; vertical-align:middle"/>Reporte Monitores</a></li>
 </ul>
</div>

<a class="menuitem submenuheader" href="#"><img src="images/plus.gif" align="right" class="plus useraplication" /><img src="images/minus.gif" align="right" id="minus" class="minus useraplication "/><img src="images/security.png" style="vertical-align:middle; padding-right:5px;" />Sistema</a>
<div class="submenu">
	<ul id="useraplication">
	<li id="CUserAplicacion"><a href="#"><img src="images/add1.png" style="padding-right:5px;"/>Crear Usuario</a></li>
    <li id="ConsUserAplicacion"><a href="#"><img src="images/Search.png" style="padding-right:5px;"/>Consultar Usuario</a></li>
	<li id="MUserAplicacion"><a href="#"><img src="images/modify.png" style="padding-right:5px;"/>Modificar Usuario</a></li>
	</ul>
</div>

<a class="menuitem submenuheader" href="#"><img src="images/plus.gif" align="right" class="plus herramientas" /><img src="images/minus.gif" align="right" id="minus" class="minus herramientas "/><img src="images/administrator.png" style="vertical-align:middle;" />Administración</a>
<div class="submenu">
	<ul id="herramientas">
	<li id="Pcs"><a href="#"><img src="images/pc.png" style="padding-right:5px; vertical-align:middle"/>Computadores</a></li>
    <li id="Actividades"><a href="#"><img src="images/activity_window_16.png" style="padding-right:5px; vertical-align:middle"/>Actividades</a></li>
    <li id="Dependencias"><a href="#"><img src="images/agency.png" style="padding-right:5px; vertical-align:middle"/>Dependencias</a></li>
    <li id="Gruposubgrupo"><a href="#"><img src="images/audio-headset.png" style="padding-right:5px; vertical-align:middle"/>Grupo-Subgrupo</a></li>
    </ul>
  </div>
</div>
	
 <?php } else  if($_SESSION['perfil']==2)
		{ 
		
?>           
 
         
    <div class="glossymenu">
 <!--menu de la aplicacion-->
<a class="menuitem submenuheader" href="#" ><img src="images/plus.gif" align="right" class="plus ingresos" /><img src="images/minus.gif" align="right" id="minus" class="minus ingresos" /><img src="images/ingresopiso.png" style="vertical-align:middle; padding-right:5px;"/>Ingresos</a>
<div class="submenu">
	<ul id="ingresos">
	<li id="ingresousuario"><a href="#"><img src="images/ingresousuarios.png" style="vertical-align:middle; padding-right:5px;"/>Ingresar Usuario </a></li>
	</ul>
</div>

<a class="menuitem submenuheader" href="#"><img src="images/plus.gif" align="right" class="plus salidas" /><img src="images/minus.gif" align="right" id="minus" class="minus salidas" /><img src="images/salida.png" style="vertical-align:middle; padding-right:5px;"/>Salidas</a>
<div class="submenu">
	<ul id="salidas">
	<li id="salusuario"><a href="#"><img src="images/inguser.png" style="padding-right:5px; vertical-align:middle"/>Por Usuario </a></li>
	<li id="salsala"><a href="#"><img src="images/1313782523_desktop_computer.png" style="padding-right:5px; vertical-align:middle"/>Por Sala</a></li>
    
	</ul>
</div>

<a class="menuitem submenuheader" href="#" ><img src="images/plus.gif" align="right" class="plus consultasR" /><img src="images/minus.gif" align="right" id="minus" class="minus consultasR" /><img src="images/consultar.png"style="vertical-align:middle; padding-right:5px;"/>Consultas</a>
<div class="submenu">
	<ul id="consultasR">
	<li id="porusuario"><a href="#"><img src="images/user2.png" style="padding-right:5px; vertical-align:middle"/>Usuario </a></li>
	<li id="porasignatura"><a href="#"><img src="images/bookyellow.png" style="padding-right:5px; vertical-align:middle"/>Asignatura</a></li>
    <li id="porrecursos"><a href="#"><img src="images/scanner.png" style="padding-right:5px; vertical-align:middle"/>Recursos </a></li>
	<li id="porsala"><a href="#"><img src="images/ReporteHorario.png" style="padding-right:5px; vertical-align:middle"/>Horarios</a></li>
    <li id="porasistencia"><a href="#"><img src="images/Loading.png" style="padding-right:5px; vertical-align:middle"/>Asistencia</a></li>
    <li id="listadoclasemonitor"><a href="#"><img src="images/books.png" style="padding-right:5px; vertical-align:middle"/>Listado de Clase</a></li>
    <li id="infreservas"><a href="#"><img src="images/reserva.png" style="padding-right:5px; vertical-align:middle"/>Reservas</a></li>
    <li id="BusquedaUsuarioSala"><a href="#"><img src="images/users.png" style="vertical-align:middle"/>Usuario(s) Sala</a></li>
	</ul>
</div>

<a class="menuitem submenuheader" href="#"><img src="images/plus.gif" align="right" class="plus monitores" /><img src="images/minus.gif" align="right" id="minus" class="minus monitores" /><img src="images/monitores.png" style="vertical-align:middle; padding-right:3px"/>Monitores</a>
<div class="submenu">
	<ul id="monitores">
	<li id="planilla"><a href="#"><img src="images/add1.png" style="padding-right:5px;"/>Planilla</a></li>
    <li id="reportesMonitor"><a href="#"><img src="images/pmonitores.png" style="padding-right:5px;"/>Reportes</a></li>
	</ul>
</div>

<a class="menuitem submenuheader" href="#" ><img src="images/plus.gif" align="right" class="plus utilidades" /><img src="images/minus.gif" align="right" id="minus" class="minus utilidades" /><img src="images/Help.png"style="vertical-align:middle; padding-right:5px;"/>Ayuda</a>
<div class="submenu">
	<ul id="utilidades">
	<li id="manualU"><a href="Archivos/Manual de usuario monitor Cupi.pdf"><img src="images/pdf.png" style="padding-right:5px; vertical-align:middle"/>Manual de Usuario </a></li>
	</ul>
</div>
</div>


<?php } ?>
   
			
 </div>	<!-- cierro sidebar-->		 
		
		   
  <div class="content" id="contenedor">
     <div align="center"><img src="images/newlogocupi.png"/></div>
  </div>
   
  <div class="footer">
   
    <!-- end .footer -->
  </div>
  <!-- end .container --></div>
  
</body>
</html>
<?php 
 }

}
else {
    header('Location:index.php');
}


?>
