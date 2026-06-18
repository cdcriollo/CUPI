<?php 

require_once('../mod_phpmailer/phpmailer/class.phpmailer.php');

function sendmail($body, $subject, $address, $from, $fromname)
{
	//Instancio un phpmailer	
	$mail = new PHPMailer();
	//Le digo a phpmailer que es un smtp
	$mail->IsSMTP();
	//Host del smtp
	$mail->Host = "ssl://smtp.gmail.com";
	//puerto del smtp
	$mail->Port = 465;
	//Autenticacion en smtp: SI
	$mail->SMTPAuth = true;
	//Nombre de usuario del SMTP
	$mail->Username = "fai.pisoinformatico@correounivalle.edu.co";
	//$mail->Username = "faipisoinformatico@gmail.com";
	//Password del smtp
	$mail->Password = "382pisofai";
	//$mail->Password = "rootfaipi";
	//Quien lo envia                      
	$mail -> From = $from;
	//Alias del quien lo envia
	$mail -> FromName = $fromname;
	//Direccion de correo donde va dirigido el mail
	$mail -> AddAddress ($address);
	//Mensaje en utf8
	$mail-> CharSet = "UTF-8";
	//mensaje en html
	$mail -> IsHTML (true);
	//El asunto del mensaje	
	$mail -> Subject = $subject;
	//El cuerpo del mensaje
	$mail -> Body = $body; 
	
	
	$error=false;
	if(!$mail->Send())
	{
		$error=true;
	}
		
	return $error;

}
		

?>