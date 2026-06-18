<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enlaces de Interes</title>
  
<style>
html, body {
    margin: 0;
    padding: 0;
    font-size: 83%;
}
</style>
  
<script type="text/javascript">
$(function(){ 
   
  

  $("#list").jqGrid({
    url:'forms/Actividades/AdminActividades/queryActividades.php',
    datatype: 'xml',
    mtype: 'POST',
    colNames:['Id','Descripción'],
    colModel :[ 
      {name:'idActividad', index:'idActividad', width:80, editable:false, editoptions:{size:10},editrules:{required:true}}, 
	  {name:'Descripcion', index:'Descripcion', width:300, editable:true,editoptions:{size:40},editrules:{required:true}}
	   
	  	  
	],
    pager: '#pager',
    rowNum:10,
    rowList:[10,20,30],
    sortname: 'idActividad',
    sortorder: 'asc',
    viewrecords: true,
    caption: 'Actividades',
	width:700,
	height:300,
	editurl:"forms/Actividades/AdminActividades/server.php"
   }); 
  $("#list").navGrid('#pager',{	  
	  view:true,
	  del:true,
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