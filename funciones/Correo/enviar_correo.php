<?php 

require_once('../mod_phpmailer/phpmailer/class.phpmailer.php');
require_once('../mod_phpmailer/phpmailer/class.smtp.php');

$address= $_POST['address'];
$body= $_POST['body'];
$subject= $_POST['subject'];
$from= "faipisoinformatico@univalle.edu.co";
$fromname= "Facultad de Artes Integradas";
sendmail($body, $subject, $address, $from, $fromname);

function sendmail($body, $subject, $address, $from, $fromname)
{
	//Instancio un phpmailer	
	$mail = new PHPMailer();
	//Le digo a phpmailer que es un smtp
	$mail->IsSMTP();
	//Host del smtp
	//$mail->Host = "ssl://smtp.univalle.edu.co";
        //$mail->SMTPSecure = "tls"; //Establece el prefijo al servidor SMTP
        $mail->Host = "smtp.univalle.edu.co";
        //$mail->SMTPSecure = 'ssl';
	//puerto del smtp
	$mail->Port = 25;
	//Autenticacion en smtp: SI
	//$mail->SMTPAuth = true;
	//Nombre de usuario del SMTP
	//$mail->Username = "fai.piso@univalle.edu.co";
	//$mail->Username = "fai-piso";
	//Password del smtp
	//$mail->Password = "382pisofai";
	//$mail->Password = "382piso";
        //$mail->Password = "crisco80";
	//Quien lo envia   
        $mail->SMTPDebug = 2;
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
		//$error=true;
                echo "Error enviando:" . $mail->ErrorInfo;
	}
         else {
         echo "¡¡Enviado!!";
        }
		
	//return $error;
        //echo $error;

}
		

?>

