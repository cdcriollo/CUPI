<?php
header('Content-Type: text/html; charset=UTF-8');

function get_msgHtml($i,$data){
   switch ($i) { 
    case "emailreserva":
	//Mensaje de activación de cuenta por correo		
		$data = json_decode($data);
		//Se obtiene nombre 
		$fullname = $data -> {"nombre"};
		// se obtiene correo
		$email = $data -> {"email"};
		// se obtiene codigo asignatura
		$asignatura = $data -> {"asignatura"};
		// se obtiene grupo de la asignatura
		$grupo = $data -> {"grupo"};
		// se obtiene nombre de la asignatura
		$nombreasig= $data ->{"nombreasignatura"};
		// se obtiene numero de reserva
		$Noreserva= $data -> {"Noreserva"};
		// Se obtiene la fecha y hora de reserva
		$fechahora= $data -> {"fechahora"};
		// Se obtiene las salas
		$salas=$data -> {"salas"};
		
		$html =
		'		
		<body style="font-size:12px; line-height:1.125em; font-family: Arial, Helvetica, sans-serif; color:#999">
        <div style="border:1px solid #EEE;">
			<div style="background:#007DC5; color:#FFF; font-weight:bold; font-size:18px; padding:5px">Piso Informatico Facultad de Artes Integradas</div>
            <div style="padding:10px;">			
                <h1 style="font-size: 18px; color: #5287D6; ">Su reserva ha sido realizada exitosamente!</h1>
                <br />
                <div style=" font-weight:bold; font-size:14px; color:#333">Hola '.$fullname.',</div>
                <br />
				Se ha creado una nueva reserva con la siguiente información:
				<br/>
				<br/>
				No reserva: <strong>'.$Noreserva.'</strong>
				<br/>
				Asignatura: <strong>'.$asignatura.'</strong>
				<br />
				Grupo: <strong>'.$grupo.'</strong>
				<br />
				Nombre asignatura: <strong>'.$nombreasig.'</strong>
				<br/>
				Sala(s): <strong>'.$salas.'</strong>
				<br/>
				Fecha y hora de reserva: <strong>'.$fechahora.'</strong>
                <br/>
			    <br/>
				<strong>Nota:</strong> Si por algun motivo decide cancelar la reserva, tenga en cuenta este No de reserva y envie un correo al                 coordinador del piso informatico para cancelar la reserva.  
				
            </div>
			
		</div>
       </body>';
        return $html;
        break; 	
		
		
		case "emailuser":
	//Mensaje de activación de cuenta por correo		
		$data = json_decode($data);
		//Se obtiene nombre 
		$fullname = $data -> {"nombre"};
		// se obtiene correo
		$email = $data -> {"email"};
		// se obtiene el texto del mensaje
		$texto = $data -> {"texto"};
	
		$html =
		'		
		<body style="font-size:12px; line-height:1.125em; font-family: Arial, Helvetica, sans-serif; color:#999">
        <div style="border:1px solid #EEE;">
			<div style="background:#007DC5; color:#FFF; font-weight:bold; font-size:18px; padding:5px">Piso Informatico Facultad de Artes Integradas</div>
            <div style="padding:10px;">			
			
                <div style=" font-weight:bold; font-size:14px; color:#333">Hola '.$fullname.',</div>
                <br/>
				<p style="text-align:justify">
				  '.$texto.'
				</p>
				
				<br/>
				<br/>
				
			    Att
				<br/>
				
				<strong>Hofelia Arias Arias</strong><br/>
				<strong>Coordinadora Piso informatico</strong><br/>
				
				
            </div>
			
		</div>
       </body>';
        return $html;
        break; 			
    }
  }

?>

