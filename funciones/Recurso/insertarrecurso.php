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

$fecharecibo = $_POST['Fecharecibo'];
$nuevaFecha = implode('-', array_reverse(explode('-', $fecharecibo)));
$nombrebien = mb_convert_case($_POST['nombre'], MB_CASE_TITLE, "UTF-8");
$marca = mb_convert_case($_POST['marca'], MB_CASE_TITLE, "UTF-8");
$estadoprestamo = $_POST['estadoPrestamo'];

$insertSQL = sprintf("INSERT INTO recursos (Noinventario, estadorecurso, Nombrebien,idTipo,subgrupo, cantidad, marca, serial, caracteristicas, instalado_sala, instalado_comp, novedades, fechatramite, dependencia, orden_No,Observaciones,llave,Tipo,Licencia,Idioma,Factura,Proveedor,Valor,Fecharecibo,Version,estadoprestamo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", GetSQLValueString($_POST['inventario'], "text"), GetSQLValueString($_POST['estado'], "text"), GetSQLValueString($nombrebien, "text"), GetSQLValueString($_POST['grupo'], "int"), GetSQLValueString($_POST['subgrupo'], "int"), GetSQLValueString($_POST['cantidad'], "int"), GetSQLValueString($marca, "text"), GetSQLValueString($_POST['serial'], "int"), GetSQLValueString($_POST['caracteristicas'], "text"), GetSQLValueString($_POST['instaladosala'], "int"), GetSQLValueString($_POST['instaladopc'], "int"), GetSQLValueString("", "text"), GetSQLValueString("", "date"), GetSQLValueString("", "text"), GetSQLValueString("", "int"), GetSQLValueString("", "text"), GetSQLValueString($_POST['llave'], "text"), GetSQLValueString($_POST['Tipo'], "text"), GetSQLValueString($_POST['Licencia'], "text"), GetSQLValueString($_POST['Idioma'], "text"), GetSQLValueString($_POST['Factura'], "text"), GetSQLValueString($_POST['Proveedor'], "text"), GetSQLValueString($_POST['Valor'], "int"), GetSQLValueString($nuevaFecha, "date"), GetSQLValueString($_POST['Version'], "text"), GetSQLValueString($estadoprestamo, "text"));
mysql_select_db($database_conexion, $conexion);
mysql_query("SET NAMES 'utf8'");
$Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());


if ($Result1 == 1) {

    echo 1;
}
else {

    echo 0;
}
?>

