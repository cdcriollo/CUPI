<?php require_once('../../Connections/conexion.php'); ?>
<?php

if (!function_exists("GetSQLValueString")) {

    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
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

// Se inicializan las validaciones de fecha,hora y salas a 0
$validacionFecha = 0;
$validacionHora = 0;
$validacionSala7 = 0;
$contador = 0;

// Se crean los array de salas y dias
$salas = array();
$dias = array();

// Se obtiene el horario enviado por POST

$arrayhorarios = explode(',', $_POST['horario']);
$tamañoArrayHorario = count($arrayhorarios);
$tamañoTotal = $tamañoArrayHorario / 6;

// verifica que la horainicial y final esten correctas

for ($i = 1; $i < count($arrayhorarios); $i+=6) {
    $horainicial = strtotime($arrayhorarios[$i]);
    $horafinal = strtotime($arrayhorarios[$i + 1]);

    if ($horainicial >= $horafinal || $horafinal <= $horainicial) {
        $validacionHora = 1;
        $i+= count($arrayhorarios);
    }
}


// verifica que la fechainicial y la fechafinal esten correctas
for ($i = 3; $i < count($arrayhorarios); $i+=6) {
    $fechainicial = strtotime($arrayhorarios[$i]);
    $fechafinal = strtotime($arrayhorarios[$i + 1]);

    if ($fechainicial > $fechafinal || $fechafinal < $fechainicial) {
        $validacionFecha = 1;
        $i+=count($arrayhorarios);
    }
}

// obtiene la o las salas del horario definido

for ($i = 5; $i < count($arrayhorarios); $i+=6) {
    $salas[$i] = $arrayhorarios[$i];
}

// obtiene el o los dias del horario definido
for ($i = 0; $i < count($arrayhorarios); $i+=6) {
    $dias[$i] = $arrayhorarios[$i];
}

$salasHorario = implode(',', $salas);
$diasHorario = implode(',', $dias);

for ($i = 5; $i < count($arrayhorarios); $i+=6) {
    $sala7 = $arrayhorarios[$i];

    if ($sala7 == 7) {
        $contador+=1;
    }
}

if ($tamañoTotal == $contador) {
    $validacionSala7 = 1;
}

function descripcionDia($diasemana) {
    if ($diasemana == 1) {
        $descripcion = "Lunes";
    }
    else if ($diasemana == 2) {
        $descripcion = "Martes";
    }
    else if ($diasemana == 3) {
        $descripcion = "Miercoles";
    }
    else if ($diasemana == 4) {
        $descripcion = "Jueves";
    }
    else if ($diasemana == 5) {
        $descripcion = "Viernes";
    }
    else if ($diasemana == 6) {
        $descripcion = "Sabado";
    }

    return $descripcion;
}

// verifica si las fechas y las horas estan correctas
if ($validacionFecha != 1 && $validacionHora != 1) {

    // realiza una consulta a la tabla horarios especificando los dias y las salas
    mysql_select_db($database_conexion, $conexion);
    $query_JRConsHorario = "select codDia, codAsignatura,codGrupo, horainicio,horafinal,sala,fechaInicio,fechaFinal from horario where codDia IN ($diasHorario) and sala IN($salasHorario) and  estadohorario <> 'inactivo' order by codDia";
    mysql_query("SET NAMES 'utf8'");
    $JRConsHorario = mysql_query($query_JRConsHorario, $conexion) or die(mysql_error());
    $row_JRConsHorario = mysql_fetch_assoc($JRConsHorario);
    $totalRows_JRConsHorario = mysql_num_rows($JRConsHorario);

    if ($validacionSala7 == 0) {

        if ($totalRows_JRConsHorario > 0) {

            do {

                $diam = $row_JRConsHorario ['codDia'];
                $horainiciom = strtotime($row_JRConsHorario ['horainicio']);
                $horafinalm = strtotime($row_JRConsHorario ['horafinal']);
                $fechainiciom = strtotime($row_JRConsHorario ['fechaInicio']);
                $fechafinalm = strtotime($row_JRConsHorario ['fechaFinal']);
                $asignatura = $row_JRConsHorario ['codAsignatura'];
                $grupo = $row_JRConsHorario ['codGrupo'];
                $horainicion = $row_JRConsHorario ['horainicio'];
                $horafinaln = $row_JRConsHorario ['horafinal'];
                $salam = $row_JRConsHorario ['sala'];


                for ($i = 0; $i < count($arrayhorarios); $i+=6) {
                    $dia = $arrayhorarios[$i];
                    $horainicial = strtotime($arrayhorarios[$i + 1]);
                    $horafinal = strtotime($arrayhorarios[$i + 2]);
                    $fechainicial = strtotime($arrayhorarios[$i + 3]);
                    $fechafinal = strtotime($arrayhorarios[$i + 4]);
                    $sala = $arrayhorarios[$i + 5];

                    // verifica si coincide el dia con la sala para hacer la comparacion
                    if ($dia == $diam && $salam == $sala) {
                        // verifica si las horas son exactamente iguales entre ellas para determinar si se prsenta cruce de horarios 
                        if ($horainiciom == $horainicial && $horafinalm == $horafinal && $fechainiciom == $fechainicial && $fechafinalm == $fechafinal) {
                            $diasemana = descripcionDia($diam);
                            $respuesta[0] = 1;
                            $respuesta[1] = $asignatura;
                            $respuesta[2] = $grupo;
                            $respuesta[3] = $diasemana;
                            $respuesta[4] = $horainicion;
                            $respuesta[5] = $horafinaln;
                            $respuesta[6] = $salam . "-";
                            $cadenarespuesta = implode('-', $respuesta);
                            echo $cadenarespuesta;
                            break;
                        }

                        // verifica si las horas de inicio y final son mayores o menores entre ellas para determinar si se presenta cruce de horarios 
                        else if ($horainiciom < $horafinal && $horafinalm > $horainicial && $fechainiciom <= $fechafinal && $fechafinalm >= $fechainicial) {
                            $diasemana = descripcionDia($diam);
                            $respuesta[0] = 1;
                            $respuesta[1] = $asignatura;
                            $respuesta[2] = $grupo;
                            $respuesta[3] = $diasemana;
                            $respuesta[4] = $horainicion;
                            $respuesta[5] = $horafinaln;
                            $respuesta[6] = $salam . "-";
                            $cadenarespuesta = implode('-', $respuesta);
                            echo $cadenarespuesta;
                            break;
                        }
                    }// cierro if comparacion dia y sala
                }// cierro for
            }
            while ($row_JRConsHorario = mysql_fetch_assoc($JRConsHorario));
        }// cierro if totalrows
    }// validacion sala7
}// cierro if validacion fecha, hora,sala,dias
else if ($validacionFecha == 1 && $validacionHora == 0) {
    echo 2; // La fecha no esta correcta
}
else if ($validacionFecha == 0 && $validacionHora == 1) {
    echo 3; // La hora no esta correcta
}
else if ($validacionFecha == 1 && $validacionHora == 1) {
    echo 4; //La fecha y la hora no estan correctas
}
?>

