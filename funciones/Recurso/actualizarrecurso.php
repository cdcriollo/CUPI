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

$inventario = $_POST['inventario'];
$estado = $_POST['estado'];
$grupo = $_POST['grupo'];
$cantidad = $_POST['cantidad'];
$marca = $_POST['marca'];
$serial = $_POST['serial'];
$caracteristicas = $_POST['caracteristicas'];
$instaladosala = $_POST['instaladosala'];
$instaladopc = $_POST['instaladopc'];
$nombre = $_POST['nombre'];
$subgrupo = $_POST['subgrupo'];
$llave = $_POST['llave'];
$tipo = $_POST['Tipo'];
$licencia = $_POST['Licencia'];
$idioma = $_POST['Idioma'];
$factura = $_POST['Factura'];
$proveedor = $_POST['Proveedor'];
$valor = $_POST['Valor'];
$fecharecibo = $_POST['Fecharecibo'];
$version = $_POST['Version'];
$estadoprestamo = $_POST['estadoPrestamo'];
$idInventario = $_POST['idInventario'];


$updateSQL = sprintf("UPDATE recursos SET Noinventario=%s, estadorecurso=%s, Nombrebien=%s, cantidad=%s, marca=%s, serial=%s, caracteristicas=%s, instalado_sala=%s, instalado_comp=%s,llave=%s, Tipo=%s, Licencia=%s, Idioma=%s, Factura=%s, Proveedor=%s, Valor=%s, Fecharecibo=%s, Version=%s, estadoprestamo=%s WHERE Noinventario=%s", GetSQLValueString($inventario, "text"), GetSQLValueString($estado, "text"), GetSQLValueString($nombre, "text"), GetSQLValueString($cantidad, "int"), GetSQLValueString($marca, "text"), GetSQLValueString($serial, "int"), GetSQLValueString($caracteristicas, "text"), GetSQLValueString($instaladosala, "int"), GetSQLValueString($instaladopc, "int"), GetSQLValueString($llave, "text"), GetSQLValueString($tipo, "text"), GetSQLValueString($licencia, "text"), GetSQLValueString($idioma, "text"), GetSQLValueString($factura, "text"), GetSQLValueString($proveedor, "text"), GetSQLValueString($valor, "int"), GetSQLValueString($fecharecibo, "date"), GetSQLValueString($version, "text"), GetSQLValueString($estadoprestamo, "text"), GetSQLValueString($idInventario, "text"));

mysql_select_db($database_conexion, $conexion);
$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

$numerofilasafectadas = mysql_affected_rows();

if ($numerofilasafectadas > 0) {
    echo 1;
}
else if ($numerofilasafectadas == 0) {
    echo 0;
}


