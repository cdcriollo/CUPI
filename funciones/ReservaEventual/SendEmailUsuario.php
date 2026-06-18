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
<?php
include("../mod_mail/mail.php");
include("../mod_mail/html_msg.php");

if(isset($_POST["email"], $_POST["nomusuario"],$_POST["asunto"], $_POST['textocorreo']))
{

	//Captura de variables	
	
	// Correo de la persona que realizo la solicitud de reserva
	$email= $_POST["email"];
	// Obtengo el nombre del usuario 
	$nombreusuario= $_POST["nomusuario"];
	//Obtengo el asunto
	$asunto=$_POST["asunto"];
	//Obtengo el texto del mensaje
	$texto=	$_POST["textocorreo"];
	
	
			//Enviamos un correo electronico confirmando al usuario la solicitud de reserva
			//Obtenemos el mensaje html y enviamos datos
			//Preparo los datos
			$data -> nombre = $nombreusuario ;
			$data -> email = $email;
			$data -> texto= $texto;
			$htmlmail = get_msgHtml('emailuser',json_encode($data));		
			
			// Envia el correo electronico	
			sendmail($htmlmail, $asunto, $email, "fai.pisoinformatico@correounivalle.edu.co", "Cupi reserva eventual");
			
			
			
}



?>


