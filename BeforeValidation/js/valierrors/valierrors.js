//AUTOR: Smartware Copyright @ 2011
//Plugin Creado para validaciones Smartfriend
//Validations Errors
(function($){
  $.validation = function(params) {
	        
	var defaults = {
		classerror:"None",
		classdone:"None",
		contentmsg:"None",
		fields:[
			{id:"None",validations:{clength:["0-0","None"],LaN:[false,"None"],email:[false,"None"],required:[false,"None"], number:[false,"None"], file:["all","None"], url:["None"]}}				  
		]
		,
		beforeValidation:function(){
				 alert("Te falta la función que se ejecuta cuando la validación es correcta");
		 }		
		
	};           
 

    opciones = jQuery.extend(defaults , params);
  //  alert(opciones.fields[0].id + "-" +opciones.fields[1].id+"-"+opciones.fields[2].id+"-"+ opciones.fields[3].id);
	
	var defaultMsg=opciones.defaultMsg;
	var styleerror=opciones.classerror;
	var styledone=opciones.classdone;
	var ctmsg=opciones.contentmsg;
	var arrayfields=opciones.fields;
	var numberfields=arrayfields.length;
	var arrayValid = new Array(numberfields);
	
	//alert(numberfields);
	
	$("#"+ctmsg).empty();
	
	for(i=0;i<numberfields;i++)
	{
		
		var idfield=arrayfields[i].id;
		$("#"+idfield).removeClass(styleerror);
	}
	for(i=0;i<numberfields;i++)
	{
		
		var idfield=arrayfields[i].id;
		//alert(idfield);
		var arrayrequired=arrayfields[i].validations.required;
		var arraylength=arrayfields[i].validations.clength;
		var arrayLaN=arrayfields[i].validations.LaN;
		var arrayemail=arrayfields[i].validations.email;
		var arrayNumber=arrayfields[i].validations.number;
		var arrayFile=arrayfields[i].validations.file;
		var arrayurl=arrayfields[i].validations.url;
		var resultrequired=true;
		var resultlength=true;
		var resultLaN=true;
		var resultemail=true;
		var resultnumber=true;
		var resultfile=true;
		var resulturl=true;
		
	//	alert(required);
		if(arrayrequired[0])
		{			
			
						
			if($("#"+idfield).val().trim()=="")
			{
				resultrequired=false;
				updateTips($("#"+ctmsg),arrayrequired[1],styledone);
				$("#"+idfield).addClass(styleerror);
			}
											
			if(arraylength!=undefined)
			{
			   //alert(arraylength[0]+"-"+arraylength[1]);
			   range=arraylength[0];
			   msg=arraylength[1];
			   arrayrange=range.split("-");
			  // alert(ctmsg);
			   resultlength=checkLength($("#"+idfield),arrayrange[0],arrayrange[1],styleerror,styledone,$("#"+ctmsg),msg);
			  		 
			   
			}
			if(arrayLaN!=undefined)
			{
				//PATRON: /^[a0-zñÑ9]([0-9a-zñÑ_])+$/i
			  // alert(arrayLaN[0]+"-"+arrayLaN[1]);
			//  /[A-Za-zñÑ\s]/ o /^[a-zA-Z0-9_]$/
			  msgLaN=arrayLaN[1];
			  resultLaN=checkRegexp($("#"+idfield),/^[a0-zñÑ9]([0-9a-zñÑ_])+$/i,styleerror,styledone,$("#"+ctmsg),msgLaN);
			  
			}
			if(arrayemail!=undefined)
			{
			  /*PATRON:  /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i */
			  // alert(arrayemail[0]+"-"+arrayemail[1]);
			   msgemail=arrayemail[1];
			   resultemail=checkRegexp($("#"+idfield),/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,styleerror,styledone,$("#"+ctmsg),msgemail);
			  
			}
			
			if(arrayNumber!=undefined)
			{
				//PATRON:/^\d+$/
			 
			  msgNum=arrayNumber[1];
			  resultnumber=checkRegexp($("#"+idfield),/^\d+$/,styleerror,styledone,$("#"+ctmsg),msgNum);
			  
			}
			
			if(arrayFile!=undefined)
			{
				
				extFile=arrayFile[0];
				if(extFile!="all")
				{
					extensions=extFile.split("-");
					msgFile=arrayFile[1];													
					resultfile=checkExtension($("#"+idfield),extensions,styleerror,styledone,$("#"+ctmsg),msgFile);
				}				
			}
			
			if(arrayurl!=undefined)
			{
				
			 
			  msgUrl=arrayurl[0];
			  resulturl=checkRegexp($("#"+idfield),/^(ht|f)tps?:\/\/\w+([\.\-\w]+)?\.([a-z]{2,4}|travel)(:\d{2,5})?(\/.*)?$/i,styleerror,styledone,$("#"+ctmsg),msgUrl);
			  
			}
			
			
			
			
		}
		
		//alert("REQUIRED:"+resultrequired);
		//alert("LENGTH:"+resultlength);
		//alert("LAN:"+resultLaN);
		//alert("EMAIL:"+resultemail);
		//alert("NUMBER:"+resultnumber);
		if(resultrequired == true && resultlength == true && resultLaN == true && resultemail == true && resultnumber == true && resultfile == true && resulturl == true)
		{
			arrayValid[i]=true;
					
		}
		else
		{
			arrayValid[i]=false;		
		}
		
		
		
		
	}
	
	//alert(arrayValid);
	var numbertrue=0;
	for(i=0;i<numberfields;i++)
	{
		if(arrayValid[i]==true)
		{
			numbertrue++;		
		}
	}
	//alert(numbertrue);
//	alert(numberfields);
	if(numbertrue==numberfields)
	{
		opciones.beforeValidation();
		$("#"+ctmsg).empty();
	    $("#"+ctmsg).text(defaultMsg);
	}
	
	
	
  };
  
function updateTips(tips, t, classdone ) {
	 tips
	 .append("<br />"+ t )
	 .addClass( classdone );
	 setTimeout(function() {
		tips.removeClass( classdone, 1500 );
	 }, 200 );
}

function checkLength( o, min, max, classerror, classdone, ctmsg, msg) {
	if ( o.val().length > max || o.val().length < min ) {
		o.addClass(classerror);
			updateTips(ctmsg,msg,classdone);
			return false;
		} else {
		    
			return true;
		}
}

function checkRegexp( o, regexp, classerror, classdone, ctmsg, msg) {
		if ( !( regexp.test( o.val() ) ) ) {
			o.addClass( classerror );
			updateTips(ctmsg,msg,classdone);
			return false;
		} else {
			
			return true;
		}
}

function checkExtension( o, arrayExt, classerror, classdone, ctmsg, msg)
{
	
	var file=o.val();
	var extension = (file.substring(file.lastIndexOf("."))).toLowerCase();
		
	var i=0;
	var valiFile = true;
	while(i<arrayExt.length)
	{		
		acceptExt="."+arrayExt[i];
		if (extension==acceptExt)
		{
			valiFile=true;
			i=i+arrayExt.length;
		}
		else
		{
			valiFile=false;		
			
		}
		i++;
	}
	if(valiFile==false){
		o.addClass( classerror );
		updateTips(ctmsg,msg,classdone);
	}
		
	return valiFile;
}
  
})(jQuery);

