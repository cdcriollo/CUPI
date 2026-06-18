<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enlaces de Interes</title>
  
<style>
html, body {
    margin: 0;
    padding: 0;
    font-size: 85%;
}
</style>
  
<script type="text/javascript">
$(function(){ 
   
  

  $("#list").jqGrid({
    url:'forms/Pcs/AdministrarPcs/queryPcs.php',
    datatype: 'xml',
    mtype: 'POST',
    colNames:['No pc','Sala','Estado','Estado Ocupacion'],
    colModel :[ 
      {name:'Nopc', index:'Nopc', width:80,editable:false, editoptions:{size:10},editrules:{required:true, number:true}}, 
      {name:'numSala', index:'numSala', width:300, editable:true, edittype:"select",editoptions:{size:40, value:{0:'0',1:'1',2:'2',3:'3',4:'4',5:'5',6:'6',7:'7'}},editrules:{required:true}},
	  {name:'estado', index:'estado', width:300, editable:true, edittype:"select",editoptions:{size:40, value:{Activo:'Activo',Inactivo:'Inactivo',Docente:'Docente'}},editrules:{required:true}},
	  {name:'estadoocupacion', index:'estadoocupacion', width:300, edittype:"select", editable:true,editoptions:{size:40,value:{disponible:'Disponible',ocupado:'Ocupado'}},editrules:{required:true}}
	   
	  	  
	],
    pager: '#pager',
    rowNum:10,
    rowList:[10,20,30],
    sortname: 'Nopc',
    sortorder: 'asc',
    viewrecords: true,
    caption: 'Pcs Salas',
	width:700,
	height:300,
	editurl:"forms/Pcs/AdministrarPcs/server.php"
   }); 
  $("#list").navGrid('#pager',{	  
	  view:true,
	  del:false,
	  add:true,
	  edit:true,
	  refresh:true	    
   },
    {
	    
		width:400,
		height:'100%'		

	},
	 {
		width:400,
		height:'100%'		
	},
	{},
	{multipleSearch:false},
	{}
	);
  
//DEFINICION DE NAVGRID jQuery("#grid_id").navGrid('#gridpager',{parameters}, prmEdit, prmAdd, prmDel, prmSearch, prmView);
   
 

}); 
</script>
 
</head>
<body>
<table id="list"></table> 
<div id="pager"></div> 


</body>
</html>