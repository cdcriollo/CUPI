
<?php require_once('../../Connections/conexion.php'); ?>
<?php date_default_timezone_set("America/bogota"); ?>
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

// se obtiene la fecha de ingreso
$opcion = $_POST['opcion'];
$fecha = date('Y' . '-' . 'm' . '-' . 'd');
// se obtiene la hora de ingreso
$hora = date('H:i');
// Se obtiene el dia de la semana
$dia = date("w");
// Codigo del estudiante
$codigo = $_POST['codigo'];

if ($opcion == 1) {

    mysql_select_db($database_conexion, $conexion);
    $insertSQL = "INSERT INTO ingreso_salida_monitor (dia, fecha_entrada, hora_entrada, codigo) VALUES ('$dia','$fecha','$hora','$codigo')";
    mysql_query("SET NAMES 'utf8'");
    $Result2 = mysql_query($insertSQL, $conexion) or die(mysql_error());
    $ngresos = mysql_affected_rows();

    if ($ngresos >= 1) {
        echo 1;
    }
    else {
        echo 0;
    }
}
else if ($opcion == 2) {
    mysql_select_db($database_conexion, $conexion);

    mysql_select_db($database_conexion, $conexion);
    $query_JRTurnos = "SELECT hora_entrada FROM ingreso_salida_monitor WHERE codigo = '$codigo' and fecha_entrada='$fecha' and estado='activo'";
    mysql_query("SET NAMES 'utf8'");
    $JRTurnos = mysql_query($query_JRTurnos, $conexion) or die(mysql_error());
    $row_JRTurnos = mysql_fetch_assoc($JRTurnos);
    $totalRows_JRTurnos = mysql_num_rows($JRTurnos);

    $hora_entrada = $row_JRTurnos['hora_entrada'];
    $separar[1] = explode(':', $hora_entrada);
    $separar[2] = explode(':', $hora);

    $total_minutos_trasncurridos[1] = ($separar[1][0] * 60) + $separar[1][1];
    $total_minutos_trasncurridos[2] = ($separar[2][0] * 60) + $separar[2][1];
    $total_minutos_trasncurridos = $total_minutos_trasncurridos[2] - $total_minutos_trasncurridos[1];

    $totalhoras = (int) ($total_minutos_trasncurridos / 60);
    $totalminutos = $total_minutos_trasncurridos % 60;
    $totalhorasminutos = $totalhoras . ":" . $totalminutos;

    if ($totalminutos <= 9 && $totalhoras <= 9) {
        $totalhorasminutos = "0" . $totalhoras . ":" . "0" . $totalminutos;
    }
    else if ($totalminutos <= 9 && $totalhoras > 9) {
        $totalhorasminutos = $totalhoras . ":" . "0" . $totalminutos;
    }
    else if ($totalminutos == 0 && $totalhoras <= 9) {
        $totalhorasminutos = "0" . $totalhoras . ":" . "0" . $totalminutos;
    }
    else if ($totalminutos > 0 && $totalhoras > 9) {
        $totalhorasminutos = $totalhoras . ":" . $totalminutos;
    }
    else if ($totalminutos > 0 && $totalhoras <= 9) {
        $totalhorasminutos = "0" . $totalhoras . ":" . $totalminutos;
    }

    mysql_select_db($database_conexion, $conexion);

    $updateSQL = "UPDATE ingreso_salida_monitor  SET fecha_salida= '$fecha', hora_salida= '$hora', total_horas_turno= '$totalhorasminutos', estado='terminado' WHERE codigo= '$codigo' and fecha_entrada='$fecha' and estado='activo'";
    mysql_query("SET NAMES 'utf8'");
    $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
    $updingreso = mysql_affected_rows();

    if ($updingreso >= 1) {
        echo 1;
    }
    else {
        echo 0;
    }
}
?>
