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

if(isset($_POST["codigoA"], $_POST["grupo"],$_POST["codigoresp"], $_POST['email'],$_POST["Noreserva"],$_POST["nomasignatura"],$_POST["nomusuario"],$_POST["fechahora"]))

{
	//Capturro las variables necesarias para enviar el email
	
	//Codigo de la asignatura
	$codigoasignatura=$_POST["codigoA"];
	//grupo de la asignatura
	$grupo = $_POST["grupo"];
	// Codigo del responsable
    $codresp= $_POST["codigoresp"];
	// Correo de la persona que realizo la solicitud de reserva
	$email= $_POST["email"];
    // Obtengo el numero de reserva asignado
	$Noreserva= $_POST["Noreserva"];
	// Obtengo el nombre de la asignatura
	$nombreasignatura= $_POST["nomasignatura"];
	// Obtengo el nombre del usuario 
	$nombreusuario= $_POST["nomusuario"];
	//Obtengo la fecha y hora de la reserva
	$fechahora= $_POST["fechahora"];
	
	mysql_select_db($database_conexion, $conexion);
   $query_JRSalasreserva = "select distinct sala from horario where codAsignatura='$codigoasignatura' and codGrupo=$grupo and No_reserva='$Noreserva' and estadohorario='activo'";
   $JRSalasreserva = mysql_query($query_JRSalasreserva, $conexion) or die(mysql_error());
   $row_JRSalasreserva = mysql_fetch_assoc($JRSalasreserva);
   $totalRows_JRSalasreserva = mysql_num_rows($JRSalasreserva);
   
 
		
   if ($totalRows_JRSalasreserva > 0)  
    {  
       do {  
    ?>
   <?php

     $salas[0]=$row_JRSalasreserva['sala'];

      for ($i=1; $i<$totalRows_JRSalasreserva; $i++) 
	  {  
       $NoSala = mysql_fetch_array($JRSalasreserva);  
       $salas[$i] = $NoSala["sala"];  
      }  
	?>
   <?php
   } while ($row_JRSalasreserva = mysql_fetch_assoc($JRSalasreserva));
   $rows = mysql_num_rows($JRSalasreserva);
    if($rows > 0) {
      mysql_data_seek($JRSalasreserva, 0);
	  $row_JRSalasreserva = mysql_fetch_assoc($JRSalasreserva);
     } 
	
    $cadenasalas=implode(',',$salas); 
	 
	}
	
	//Enviamos un correo electronico confirmando al usuario la solicitud de reserva
	//Obtenemos el mensaje html y enviamos datos
	//Preparo los datos
     $data -> nombre = $nombreusuario ;
	$data -> email = $email;
	$data -> asignatura = $codigoasignatura ;
	$data -> grupo = $grupo;
	$data ->nombreasignatura= $nombreasignatura;
	$data ->Noreserva= $Noreserva;
	$data ->fechahora=$fechahora;
	$data ->salas=$cadenasalas;
	$htmlmail = get_msgHtml('emailreserva',json_encode($data));		
			
	// Envia el correo electronico	
	sendmail($htmlmail,"Solicitud reserva eventual", $email, "fai.pisoinformatico@correounivalle.edu.co", "Cupi reserva eventual");
			
			
			
 }



?>


<?php
mysql_free_result($JRSalasreserva);
?>
