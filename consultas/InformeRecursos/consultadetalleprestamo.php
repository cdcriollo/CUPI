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

if (isset($_POST['inventario'], $_POST['fechaI'], $_POST['fechaF'], $_POST['grupo'], $_POST['subgrupo'])) {

    $Noinventario = $_POST['inventario'];
    $fechainicial = implode('-', array_reverse(explode('-', $_POST['fechaI'])));
    $fechafinal = implode('-', array_reverse(explode('-', $_POST['fechaF'])));
    $grupo = $_POST['grupo'];
    $subgrupo = $_POST['subgrupo'];

    function formatearHora($hora1) {
        $horaFormateada[1] = explode(':', $hora1);
        $horaTransformada = $horaFormateada[1][0] . ":" . $horaFormateada[1][1];

        return $horaTransformada;
    }

    mysql_select_db($database_conexion, $conexion);
    $query_JREstadorecurso = "SELECT estadorecurso, novedades, fechatramite, dependencia, caracteristicas, orden_No FROM recursos WHERE Noinventario = '$Noinventario' and idTipo=$grupo and subGrupo=$subgrupo";
    mysql_query("SET NAMES 'utf8'");
    $JREstadorecurso = mysql_query($query_JREstadorecurso, $conexion) or die(mysql_error());
    $row_JREstadorecurso = mysql_fetch_assoc($JREstadorecurso);
    $totalRows_JREstadorecurso = mysql_num_rows($JREstadorecurso);

    $estado = $row_JREstadorecurso['estadorecurso'];
    $novedad = $row_JREstadorecurso['novedades'];
    $fecha = $row_JREstadorecurso['fechatramite'];
    $dependencia = $row_JREstadorecurso['dependencia'];
    $orden = $row_JREstadorecurso['orden_No'];



    mysql_select_db($database_conexion, $conexion);
    $query_JRPrestamoUsuario = "select d.cantidad, p.fechaprestamo, p.horaentrega, u.codUsuario, u.nombreUsu  from detalle_prestamo d inner join recursos r on (d.Noinventario=r.Noinventario)   inner join  prestamorecursos p on (d.idPrestamo=p.idPrestamo) inner join ingreso_salida i on (p.codIngreso= i.codIngreso) inner join usuarios u on (i.codUsuario=u.codUsuario) where d.Noinventario= '$Noinventario' and p.fechaprestamo BETWEEN '$fechainicial' and '$fechafinal' and r.idTipo=$grupo and r.subGrupo=$subgrupo";
    mysql_query("SET NAMES 'utf8'");
    $JRPrestamoUsuario = mysql_query($query_JRPrestamoUsuario, $conexion) or die(mysql_error());
    $row_JRPrestamoUsuario = mysql_fetch_assoc($JRPrestamoUsuario);
    $totalRows_JRPrestamoUsuario = mysql_num_rows($JRPrestamoUsuario);


    $styleth = ' style="padding: 5px;
			font-size: 12px;
			background-color: #DADADA;
			font:Arial, Helvetica, sans-serif;
			border-style: solid;
			border-color: #000000;
			color: #000;
			border-width: 1px;"';


    $styletr = 'style="font-size: 12px;
			font-weight:bold;
			color: #34484E;
			font:Arial, Helvetica, sans-serif;
			border-style: solid;
			border-color: #000000;
			border-width: 1px;
			text-align:center;"';

    $stylecabecera = 'style="background-color: #DADADA;
	 font-weight:bold; 
	 border-right-style:solid; 
	 border-right-width:1px; 
	 border-right-color:black; 
	 border-left-style:solid; 
	 border-left-width:1px; 
	 border-left-color:black; 
	 border-top-style:solid;
	 border-top-width:1px;
	 border-top-color:black;
	 border-bottom-style:solid;
	 border-bottom-width:1px;
	 border-bottom-color:black;
	  "';

    $stylecabeceratitulo = 'style="text-align:center; 
	 font-weight:bold; 
	 font-size:12px;  
	 border-right-style:solid;
	 border-right-width:1px; 
	 border-right-color:black;
	 border-left-style:solid;
	 border-left-width:1px; 
	 border-left-color:black;"';

    $styleImagen = 'style="background-color: #DADADA;
	 border-top-style:solid;
	 border-top-width:1px;
	 border-top-color:black;
	 border-bottom-style:solid;
	 border-bottom-width:1px;
	 border-bottom-color:black;
	 border-left-style:solid; 
	 border-left-width:1px; 
	 border-left-color:black;"';

    $stylefooter = 'style="text-align:center; 
	 background-color: #DADADA;
	 font-weight:bold; 
	 font-size:12px;  
	 border-right-style:solid;
	 border-right-width:1px; 
	 border-right-color:black;
	 border-left-style:solid;
	 border-left-width:1px; 
	 border-left-color:black;
	 border-bottom-style:solid;
	 border-bottom-width:1px;
	 border-bottom-color:black;
	 border-top-style:solid;
	 border-top-width:1px;
	 border-top-color:black;"';
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

        <body>




    <?php if ($estado == 'Inactivo') {
        ?>


                <table cellspacing="0" cellspacing="0" width="600" class="detallegruporecurso">

                    <tr>

                        <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/CUPI/images/tn1_univallelogo.jpg' ?>" style="height:88px; width:71px" /> </td>
                        <td  colspan="3" <?php echo $stylecabecera; ?>><center><p>Piso Informático - Facultad de Artes Integradas
                                </p></center><center><p>Universidad del Valle </p></center> </td>

                    </tr>  

                    <tr>
                        <td colspan="4" <?php echo $stylecabeceratitulo; ?> > <center><p> REPORTE RECURSOS</p></center> </td>
                    </tr>

                    <tr>
                        <th <?php echo $styleth; ?>>Novedad</th>
                        <th <?php echo $styleth; ?>>Fecha del Tramite</th>
                        <th <?php echo $styleth; ?>>Dependencia</th>
                        <th <?php echo $styleth; ?>>Orden No</th>
                    </tr>


                    <tr>
                        <td <?php echo $styletr; ?>><?php echo $row_JREstadorecurso['novedades']; ?></td>
                        <td <?php echo $styletr; ?>><?php echo $row_JREstadorecurso['fechatramite']; ?></td>
                        <td <?php echo $styletr; ?>><?php echo $row_JREstadorecurso['dependencia']; ?></td>
                        <td <?php echo $styletr; ?>><?php echo $row_JREstadorecurso['orden_No']; ?></td>  
                    </tr>

                    <tr>
                        <td colspan="5" <?php echo $stylecabecera ?>> <?php echo '<p>' . 'Fuente: CUPI' . '-' . 'Control de Utilizacion Piso Informatico' . '</br>' ?>
        <?php
        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
        $mes = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $ano = date('Y');
        $hora = date('H');
        $minutos = date('i');
        $second = date('s');
        ?> <?php echo 'Fecha y hora reporte:' . " " . date('d') . ' de ' . $mes[date('n')] . " " . $ano . " " . $hora . ":" . $minutos . ":" . $second . '</p>'; ?></td>
                    </tr>   
                </table>

            <?php }
            else if ($estado == 'Activo') {
                ?>

        <?php if ($totalRows_JRPrestamoUsuario > 0) { ?>



                    <table border="1" cellspacing="0" cellspacing="0" width="600" class="detallegruporecurso">

                        <tr>

                            <td  align="center" <?php echo $styleImagen; ?>><img src="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/CUPI/images/tn1_univallelogo.jpg' ?>" style="height:88px; width:71px" /> </td>
                            <td  colspan="4" <?php echo $stylecabecera; ?> ><center><p>Piso Informático - Facultad de Artes Integradas
                                    </p></center><center><p>Universidad del Valle </p></center> </td>

                        </tr>  

                        <tr>
                            <td colspan="5"  <?php echo $stylecabeceratitulo; ?> > <center><p> REPORTE RECURSOS</p></center> </td>
                        </tr>

                        <tr>
                            <th <?php echo $styleth; ?>>Codigo</th>
                            <th <?php echo $styleth; ?>>Usuario</th>
                            <th <?php echo $styleth; ?>>Cantidad</th>
                            <th <?php echo $styleth; ?>>Vence</th>
                            <th <?php echo $styleth; ?>>Hora Prestamo</th>
                        </tr>

            <?php do { ?>
                            <tr>
                                <td <?php echo $styletr; ?>><?php echo $row_JRPrestamoUsuario['codUsuario']; ?></td>
                                <td <?php echo $styletr; ?>><?php echo $row_JRPrestamoUsuario['nombreUsu']; ?></td>
                                <td <?php echo $styletr; ?>><?php echo $row_JRPrestamoUsuario['cantidad']; ?></td>
                                <td <?php echo $styletr; ?>><?php echo $row_JRPrestamoUsuario['fechaprestamo']; ?></td>
                <?php $horaInicial = $row_JRPrestamoUsuario['horaentrega']; ?>
                                <td <?php echo $styletr; ?>><?php echo $hora = formatearHora($horaInicial); ?></td> 

                            </tr>
            <?php }
            while ($row_JRPrestamoUsuario = mysql_fetch_assoc($JRPrestamoUsuario)); ?> 

                        <tr>
                            <td colspan="5" <?php echo $stylecabecera ?>> <?php echo '<p>' . 'Fuente: CUPI' . '-' . 'Control de Utilizacion Piso Informatico' . '</br>' ?>
            <?php
            $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
            $mes = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $ano = date('Y');
            $hora = date('H');
            $minutos = date('i');
            $second = date('s');
            ?> <?php echo 'Fecha y hora reporte:' . " " . date('d') . ' de ' . $mes[date('n')] . " " . $ano . " " . $hora . ":" . $minutos . ":" . $second . '</p>'; ?></td>
                        </tr> 

                    </table>

                <?php
                }
                else {
                    echo '<script type="text/javascript">alertas("El recurso no se encuentra prestado en el rango de fechas especificado", "Reporte Recursos","inform")</script>';
                }
            }
            ?>


            <div id="alertas"></div>
        </body>
    </html>

    <?php
    mysql_free_result($JREstadorecurso);
    mysql_free_result($JRPrestamoUsuario);
    mysql_close($conexion);
}
?>
