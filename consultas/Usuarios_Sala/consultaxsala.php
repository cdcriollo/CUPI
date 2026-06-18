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
$fecha = date('Y' . '-' . 'm' . '-' . 'd');
//$fecha = '2016-02-06';
$sala = $_POST['sala'];

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
    $query_JRBusquedaAUsuario = "SELECT  i.sala,u.nombreUsu,u.apellidos, i.computador, i.actividad,i.codAsignatura, i.codGrupo, e.descripcionEstado, i.fecha , i.horaingreso, i.codIngreso FROM ingreso_salida i 
    INNER JOIN usuarios u ON ( i.codUsuario = u.codUsuario )
    INNER JOIN estado_ingreso_salida e ON ( i.estado = e.idEstado ) 
    WHERE i.fecha = '$fecha'
    AND i.sala = $sala
    AND i.estado <> 1    
    ORDER BY i.actividad ASC ";
    mysql_query("SET NAMES 'utf8'");
    $JRBusquedaAUsuario = mysql_query($query_JRBusquedaAUsuario, $conexion) or die(mysql_error());
    $row_JRBusquedaAUsuario = mysql_fetch_assoc($JRBusquedaAUsuario);
    $totalRows_JRBusquedaAUsuario = mysql_num_rows($JRBusquedaAUsuario);
    

    if ($totalRows_JRBusquedaAUsuario > 0) {

        mysql_select_db($database_conexion, $conexion);
        $query_JRPCdisponible = "select count(Nopc) disponible from pcs where numSala= $sala and estadoocupacion='disponible'";
        mysql_query("SET NAMES 'utf8'");
        $JRPCdisponible = mysql_query($query_JRPCdisponible, $conexion) or die(mysql_error());
        $row_JRPCdisponible = mysql_fetch_assoc($JRPCdisponible);
        $totalRows_JRPCdisponible = mysql_num_rows($JRPCdisponible);
        //mysql_free_result( $JRPCdisponible);

        mysql_select_db($database_conexion, $conexion);
        $query_JRPCocupado = "select count(Nopc)ocupado from pcs where numSala= $sala and estadoocupacion='ocupado'";
        mysql_query("SET NAMES 'utf8'");
        $JRPCocupado = mysql_query($query_JRPCocupado, $conexion) or die(mysql_error());
        $row_JRPCocupado = mysql_fetch_assoc($JRPCocupado);
        $totalRows_JRPCocupado = mysql_num_rows($JRPCocupado);

        echo '<script type="text/javascript">$(".tableUI").styleTable();</script> ';
        ?>

        <body>  

            <center>
                <table style="margin-top: 10px">
                    <tr> 
                        <td><label style="font-weight: bold">Computadores desocupados</label></td>    
                        <td><input type="text" style="width: 20%; font-weight: bold" disabled value="<?php echo $row_JRPCdisponible['disponible'] ?>"></input></td>
                    </tr>
                    <tr>
                        <td><label style="font-weight: bold">Computadores Ocupados</label></td>    
                        <td><input type="text" disabled  style="width: 20%; font-weight: bold" value="<?php echo $row_JRPCocupado['ocupado'] ?>"></input></td> 
                    </tr> 
                </table>
            </center>     

            <table  border="1" class="tableUI"  width="650" style="margin-left:5px; margin-top:15px; margin-bottom:15px;" cellpadding="0" cellspacing="0">
                <tr>
                    <th>Sala No</th>
                    <th>Nombre Estudiante</th>
                    <th>Computador</th>
                    <th>Actividad</th>
                    <th>Codigo Asignatura</th>
                    <th>Grupo</td>
                        <th>Asignatura</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Hora ingreso</th>
                        <?php if ($_POST['check'] == 1) { ?>  
                            <th></th>  
                        <?php } ?>
                </tr>
                <?php do { ?>
                    <tr>
                        <td><?php echo $row_JRBusquedaAUsuario['sala']; ?></td>
                        <td><?php echo $row_JRBusquedaAUsuario['nombreUsu'] . " " . $row_JRBusquedaAUsuario['apellidos']; ?></td>
                        <td><?php echo $row_JRBusquedaAUsuario['computador']; ?></td>
                        <td><?php echo $row_JRBusquedaAUsuario['actividad']; ?></td>
                        <td><?php echo $row_JRBusquedaAUsuario['codAsignatura']; ?></td>
                        <td><?php echo $row_JRBusquedaAUsuario['codGrupo']; ?></td>

                        <?php
                        $codigo_asignatura = $row_JRBusquedaAUsuario['codAsignatura'];
                        mysql_select_db($database_conexion, $conexion);
                        $query_JRAsignatura = "select nomAsignatura from asignatura where codAsignatura= '$codigo_asignatura'";
                        mysql_query("SET NAMES 'utf8'");
                        $JRAsignatura = mysql_query($query_JRAsignatura, $conexion) or die(mysql_error());
                        $row_JRAsignatura = mysql_fetch_assoc($JRAsignatura);
                        $totalRows_JRAsignatura = mysql_num_rows($JRAsignatura);
                        $nombre_asignatura = $row_JRAsignatura['nomAsignatura'];
                        ?>

                        <td><?php echo $nombre_asignatura; ?></td>
                        <td><?php echo $row_JRBusquedaAUsuario['descripcionEstado']; ?></td>
                        <td><?php echo $row_JRBusquedaAUsuario['fecha']; ?></td>
                        <td><?php echo $row_JRBusquedaAUsuario['horaingreso']; ?></td>
                        <?php if ($_POST['check'] == 1) { ?>
                            <td><input name="" type="checkbox" class="chksalidausuarios" value="<?php echo $row_JRBusquedaAUsuario['codIngreso'] . '-' . $row_JRBusquedaAUsuario['computador']; ?>"></td>
                        <?php } ?>
                    </tr>
                <?php
                }
                while ($row_JRBusquedaAUsuario = mysql_fetch_assoc($JRBusquedaAUsuario));
                ?>
                <?php
                mysql_free_result($JRBusquedaAUsuario);
                mysql_free_result($JRPCdisponible);
                mysql_free_result($JRPCocupado);
                mysql_free_result($JRAsignatura);
                ?>  

            </table>


            <?php
        }
        else {
            echo'<script type="text/javascript">alertas("La consulta no arrojo resultados","Busqueda Usuario Sala","error");</script> ';
        }
        ?>

    </body>
</html>
<?php
  mysql_close($conexion);
?>
