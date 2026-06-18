
<?php 
  $user=$_GET['nameuser'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cupi-Control de Utilizacion del Piso Informatico</title>
<link href="CSS/estilo.css" rel="stylesheet" type="text/css" />
 
</head>

<html>
<body>

<div id="Sexy-login" class="login" align="center">
  <form action="loginuser.php" method="post" id="loginform">
    <table>
      <tr>
      <td><label style="font-size:14px">Contraseña:</label></td>
      <td><input type="password" name="contrasena" id="contrasena" class="borderRad5" style="height:20px;" autofocus="autofocus" /></td>
       <input type="hidden" name="nombreUsuario" id="nombreUsuario" style="height:20px;" value="<?php echo $user; ?>" />
       </tr>
       
       <tr>
       <td></td>
       <td><button type="submit" class="button_login borderRad5" name="submit" id="submit" style="margin-left:50px;" onClick="return SexyLoginInit();"><img src="images/userindex.png"/>Entrar</button></td>
      </tr>
     
    </table>
    
    
   
    
</form>
</div>

<div id="Sexy-loading" class="login loading" style="display:none;">
Cargando...

</div> 

<div id="Sexy-error" class="login error" style="display:none;">

Nombre de usuario o contraseña incorrectos. <br /><a href="#" id="again">¿Deseas volver a intentarlo?</a>
</div>
<script type="text/javascript">

var Sexy_FirstTime = 0;



function SexyLoginInit()
{  
  if (Sexy_FirstTime) {
    $('loginform').send();
    return false;
  } else {
    Sexy_FirstTime = 1;
  }
  
  $('again').addEvent('click', function(event) {

    event.stop();
    $('Sexy-error').setStyle('display', 'none');
    $('Sexy-loading').setStyle('display', 'none');
    $('Sexy-login').setStyle('display', 'block');

  });

  $('loginform').set('send', {

    onRequest: function() {
      $('Sexy-loading').setStyle('display', 'block');
      $('Sexy-login').setStyle('display', 'none');
    },
      
    onComplete: function(response) {
      $('Sexy-loading').setStyle('display', 'none');
	 
      if (response == 1)
      {   
        document.location.href = "loginuser.php?exito=1";
		
      }
      else if (response == 0)
      {
        $('Sexy-error').setStyle('display', 'block');
      }
      else
      {
        $('Sexy-login').setStyle('display', 'block');
      }
  }});


  $('loginform').send();

  return false;

};

</script>
</body>
</html>