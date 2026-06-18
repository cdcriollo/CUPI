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


$fechainicial= implode('-',array_reverse(explode('-',$_POST['desde'])));
$fechafinal=implode('-',array_reverse(explode('-',$_POST['hasta'])));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin título</title>

        <script type="text/javascript">

            $("#alertas").dialog({
                autoOpen: false,
                show: "explode",
                hide: "explode",
                modal: true
            });


            function alertas(content, title, type)
            {
                $("#alertas").empty();
                $("#alertas").dialog("option", "title", title);
                if (type == "done")
                {
                    $("#alertas").html('<img src="images/done.png" style="float:left; padding:5px;" />');
                } else if (type == "error")
                {
                    $("#alertas").html('<img src="images/error.png" style="float:left; padding:5px;" />');
                } else if (type == "inform")
                {
                    $("#alertas").html('<img src="images/inform.png" style="float:left; padding:5px;" />');
                }
                $("#alertas").append(content);
                $("#alertas").dialog("open");
            }

        </script>

    </head>


    <?php
    mysql_select_db($database_conexion, $conexion);
    $query_JRLRecurso = "SELECT r.Noinventario, r.Nombrebien, p.fechaprestamo, p.horaentrega, u.apellidos, u.nombreUsu, r.estadoprestamo, i.sala
FROM detalle_prestamo d
INNER JOIN recursos r ON ( d.Noinventario = r.Noinventario )
INNER JOIN prestamorecursos p ON ( d.idPrestamo = p.idPrestamo )
INNER JOIN ingreso_salida i ON ( p.codIngreso = i.codIngreso )
INNER JOIN usuarios u ON ( p.codUsuario = u.codUsuario )
WHERE p.fechaprestamo
BETWEEN '$fechainicial'
AND '$fechafinal'
AND r.estadoprestamo = 'Prestado' ";
    mysql_query("SET NAMES 'utf8'");
    $JRLRecurso = mysql_query($query_JRLRecurso, $conexion) or die(mysql_error());
    $row_JRLRecurso = mysql_fetch_assoc($JRLRecurso);
    $totalRows_JRLRecurso = mysql_num_rows($JRLRecurso);
    

    if ($totalRows_JRLRecurso > 0) {

        echo '<script type="text/javascript">$(".tableUI").styleTable();</script> ';
        ?>

        <body>  

            <table  border="1" class="tableUI"  width="650" style="margin-left:5px; margin-top:15px; margin-bottom:15px;" cellpadding="0" cellspacing="0">
                <tr>
                    <th>No inventario</th>
                    <th>Recurso</th>
                    <th>Usuario</th>
                    <th>Sala</th>
                    <th>Fecha</th>
                    <th>Hora ingreso</th>
                    <th>Finalizar Prestamo</td>
                </tr>
                <?php do { ?>
                    <tr>
                        <td><?php echo $row_JRLRecurso['Noinventario']; ?></td>
                        <td><?php echo $row_JRLRecurso['Nombrebien']; ?></td>
                        <td><?php echo $row_JRLRecurso['nombreUsu'] . " " . $row_JRLRecurso['apellidos']; ?></td>
                        <td><?php echo $row_JRLRecurso['sala']; ?></td>
                        <td><?php echo $row_JRLRecurso['fechaprestamo']; ?></td>
                        <td><?php echo $row_JRLRecurso['horaentrega']; ?></td>
                        <td><input name="" type="checkbox" class="chkliberar_recursos" value="<?php echo $row_JRLRecurso['Noinventario']; ?>"></td>
                       
                    </tr>
                <?php
                }
                while ($row_JRLRecurso = mysql_fetch_assoc($JRLRecurso));
                ?>
                <?php
                mysql_free_result($JRLRecurso);
                ?>  

            </table>


            <?php
        }
        else {
            echo'<script type="text/javascript">alertas("La consulta no arrojo resultados","Liberar Recursos","error");</script> ';
        }
        ?>

    </body>
</html>
<?php
  mysql_close($conexion);
?>
