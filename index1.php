<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cupi-Control de Utilizacion del Piso Informatico</title>

<script src="mootools.js"  type="text/javascript"></script>
<script src="sexylightbox.packed.js" type="text/javascript"></script>
<link href="CSS/estilo.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="CSS/sexylightbox.css" type="text/css" media="all" />

</script>
<style type="text/css">
.login {
width: 238px;
margin: 0 auto;
padding:20px 0 0 43px;
background: url(images/user.png) no-repeat left center;
}

.login label {
display:block;
font-size:12px;
padding-bottom:5px;
text-align:right;
}

.login label em{
width:80px;
display:block;
float:left;
font-style: normal;
}

.login input {
width:146px;eight:22px;
border:1px solid #ccc;
}

.login input.submit {
width:auto;
height:auto;
border:1px solid #ccc;
float:right;

}

.loading {
text-align: center;
width: 238px;
margin: 0 auto;
padding:40px 0;
background: url(images/ajax-loader.gif) no-repeat center 60px;
}

.error{
margin: 0 auto;
padding:20px 0 20px 55px;
width:212px;
background: url(images/dialog-error.png) no-repeat left center;
}

.texto{

font-weight:900;
text-align:justify;
font: Verdana, Arial, Helvetica, sans-serif;
font-size:16px;
color:#333;
}

</style>

<script type="text/javascript">


 window.addEvent('domready', function(){
    new SexyLightBox({OverlayStyles: {'background-color': '#000000'}});
  });

</script>
</head>

<body>

<div class="container">
  <div class="header">
  <div class="barraunivalle"><img src="images/logoheader.png" />
  </div>
  <div class="barracupi"></div>
  <!-- end .header --></div>
  
  
  
  <div class="content" id="contenedor" style="padding-top:20px; padding-bottom:20px;">
  
     <div style="height:380px; width:960px; margin-right:auto; margin-left:auto;"> 
  
        <div style="width:555px; padding-top:10px; padding-left:20px; float:left;"> 
		    <center><div style="float:left; width:550px; height:405px; margin-top:40px;"> <img src="images/newlogocupi.png"/> </div></center> 
        </div> 
  
       <div style="width:360px; float:right; padding-top:80px; padding-right:20px; text-justify:auto;"> 

        <p style="font-size:18px; text-align:center; color:#203360; font-weight:normal;">Bienvenido al CUPI, aplicación desarrollada para controlar la utilización del Piso Informático de la Facultad de Artes Integradas de la Universidad del Valle.</p>&nbsp;
         
        
        <center> 
        <table>
             <tr>
             <td><a href="logearse.php?height=180&amp;width=360&amp;&nameuser=administrador" rel="sexylightbox" style="text-decoration:none;" ><center><img src="images/1351788388_administrator.png" style="vertical-align:middle; padding-right:5px;"/></center> </a></td>
             <td><a href="logearse.php?height=180&amp;width=360&nameuser=operario" rel="sexylightbox" style="text-decoration:none;" ><center><img src="images/1351788466_user1.png" style="vertical-align:middle; padding-right:5px;"/></center> </a></td>
             </tr>
             <tr>
             <td style="font-size:14px; font-weight:normal"><center>Administrador</center></td>
             <td style="font-size:14px; font-weight:normal"><center>Operario</center></td>
             </tr>
         </table> 
        </center>
     
      </div>
  
  </div>
 
    </div><!--cierro content -->
   
   <div class="footer" style="text-align:center">
    <p style="color:#FFF; padding-top:10px;">Concepto y Diseño: Hofelia Arias Arias</p>
    <p style="color:#FFF; padding-top:1px;">Desarrollo: Cristian Criollo</p>
     <p style="color:#FFF; padding-top:5px;">@ 2011 Cupi</p> 
  
   </div>
  <!-- end .container --></div>

</body>
</html>
