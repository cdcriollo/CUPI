<?php require_once('../../Connections/conexion.php'); ?>
<?php

if (!function_exists("GetSQLValueString")) {

    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
                $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$No_inventario = explode(',', $_POST['Arrayliberarrecursos']);
$contador=0;

/* Update estado prestamo recursos */
for ($i = 0; $i< count($No_inventario); $i++) {
    $updateSQL = "UPDATE recursos SET estadoprestamo= 'disponible' WHERE Noinventario = ('$No_inventario[$i]')";
    mysql_select_db($database_conexion, $conexion);
    $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
    $contador+=1;
}

//$total_recursos = mysql_affected_rows();
$total_recursos= $contador;
$respuesta['exit_recursos'] = $total_recursos;
$respuesta['update'] = $updateSQL;

header('Content-type: application/json; charset=utf-8');
echo json_encode($respuesta);
exit();
?>










