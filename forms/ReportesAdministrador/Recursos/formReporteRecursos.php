<?php require_once('../../../Connections/conexion.php'); ?>
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

mysql_select_db($database_conexion, $conexion);
$query_JRRecursos = "SELECT * FROM gruporecurso";
$JRRecursos = mysql_query($query_JRRecursos, $conexion) or die(mysql_error());
$row_JRRecursos = mysql_fetch_assoc($JRRecursos);
$totalRows_JRRecursos = mysql_num_rows($JRRecursos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin título</title>



        <script type="text/javascript">



            $(function () {


                $("#html").hide();
                $.datepicker.setDefaults($.datepicker.regional['es']);
                $("#tabs").tabs();


                $("#desde").datepicker({
                    dateFormat: 'dd-mm-yy',
                    defaultDate: +7,
                    changeMonth: true,
                    changeYear: true,
                });

                $("#hasta").datepicker({
                    dateFormat: 'dd-mm-yy',
                    defaultDate: +7,
                    changeMonth: true,
                    changeYear: true,
                });

                $("#desde_uso").datepicker({
                    dateFormat: 'dd-mm-yy',
                    defaultDate: +7,
                    changeMonth: true,
                    changeYear: true,
                });

                $("#hasta_uso").datepicker({
                    dateFormat: 'dd-mm-yy',
                    defaultDate: +7,
                    changeMonth: true,
                    changeYear: true,
                });


                $("#grupo").change(function (event) {
                    var id = $("#grupo").find(':selected').val();
                    $("#subgrupo").load('consultas/Recurso/generarselect.php?id=' + id)
                });


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


                $("#limpiar").button().click(function () {

                    $("#NoInventario").val("");
                    $("#nombrebien").val("");
                    $("#cantidadtotal").val("");
                    $("#prestados").val("");
                    $("#disponibles").val("");
                    $("#desde").val("");
                    $("#hasta").val("");
                    $("#mostrardetalleRgrupo").empty();

                });





                $("#busquedaInventario").click(function () {

                    grupo = $("#grupo").val();
                    subgrupo = $("#subgrupo").val();
                    inventario = $("#NoInventario").val();

                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "NoInventario",
                                validations: {
                                    required: [true, "El campo NoInventario no puede estar vacio."],
                                }
                            },
                            {
                                id: "desde",
                                validations: {
                                    required: [true, "El campo desde no puede estar vacio."]

                                }
                            },
                            {
                                id: "hasta",
                                validations: {
                                    required: [true, "El campo hasta no puede estar vacio."]

                                }
                            }
                        ],
                        beforeValidation: function ()
                        {
                            busquedaporNoinventario(grupo, subgrupo, inventario);
                        }
                    };
                    $.validation(options);
                });


                function busquedaporNoinventario(idgrupo, idsubgrupo, Noinventario)
                {
                    $.ajax
                            ({
                                type: 'POST',
                                url: 'consultas/InformeRecursos/consultaporinventario.php',
                                data: 'idTipo=' + idgrupo + '&subTipo=' + idsubgrupo + '&Inventario=' + Noinventario,
                                success: function (datos) {

                                    if (datos)
                                    {
                                        datosrecursoporinv = datos.split('-');
                                        $("#cantidadtotal").val(datosrecursoporinv[0]);
                                        $("#prestados").val(datosrecursoporinv[1]);
                                        $("#disponibles").val(datosrecursoporinv[2]);
                                        $("#nombrebien").val(datosrecursoporinv[3]);
                                        fechainicial = $("#desde").val();
                                        fechafinal = $("#hasta").val();
                                        detallerecursosinventario(Noinventario, idgrupo, idsubgrupo, fechainicial, fechafinal);
                                    }
                                }
                            });
                }


                function detallerecursosinventario(inventario, idgrupo, idsubgrupo, fechainicial, fechafinal)
                {

                    $.ajax
                            ({
                                type: 'POST',
                                url: 'consultas/InformeRecursos/consultadetalleprestamo.php',
                                data: 'inventario=' + inventario + '&fechaI=' + fechainicial + '&fechaF=' + fechafinal + '&grupo=' + idgrupo + '&subgrupo=' + idsubgrupo,
                                success: function (datos) {

                                    if (datos)
                                    {
                                        $("#mostrardetalleRgrupo").html(datos);
                                    }
                                }
                            });
                }


                $("#busquedagrupo").click(function () {

                    idGrupo = $("#grupo").val();

                    $.ajax
                            ({
                                type: 'POST',
                                url: 'consultas/InformeRecursos/consultaporgrupo.php',
                                data: 'idTipo=' + idGrupo,
                                success: function (datos) {

                                    if (datos)
                                    {
                                        datosrecursos = datos.split('-');
                                        $("#cantidadtotal").val(datosrecursos[0]);
                                        $("#prestados").val(datosrecursos[1]);
                                        $("#disponibles").val(datosrecursos[2]);
                                        detallerecursosgrupo(idGrupo);
                                    }
                                }
                            });
                });


                $("#busquedagruposubgrupo").click(function () {

                    idGrupo = $("#grupo").val();
                    idSubgrupo = $("#subgrupo").val();
                    $("#mostrardetalleRgrupo").empty();

                    $.ajax
                            ({
                                type: 'POST',
                                url: 'consultas/InformeRecursos/consultaporgruposubgrupo.php',
                                data: 'idTipo=' + idGrupo + '&subtipo=' + idSubgrupo,
                                success: function (datos) {

                                    if (datos)
                                    {

                                        datosrecursosgs = datos.split('-');
                                        $("#cantidadtotal").val(datosrecursosgs[0]);
                                        $("#prestados").val(datosrecursosgs[1]);
                                        $("#disponibles").val(datosrecursosgs[2]);
                                        detallerecursosgruposubgrupo(idGrupo, idSubgrupo);
                                    }
                                }
                            });
                });


                $("#busquedainventarios").click(function () {

                    idtipo = $("#grupo").val();
                    subtipo = $("#subgrupo").val();
                    fechaini = $("#desde").val();
                    fechafin = $("#hasta").val();

                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "desde",
                                validations: {
                                    required: [true, "El campo desde no puede estar vacio."]

                                }
                            },
                            {
                                id: "hasta",
                                validations: {
                                    required: [true, "El campo hasta no puede estar vacio."]

                                }
                            }
                        ],
                        beforeValidation: function () {

                            $.ajax
                                    ({
                                        type: 'POST',
                                        url: 'consultas/InformeRecursos/consultaDetallePrestamoGS.php',
                                        data: 'idtipo=' + idtipo + '&subtipo=' + subtipo + '&fechaI=' + fechaini + '&fechaF=' + fechafin,
                                        success: function (datos) {

                                            if (datos)
                                            {
                                                $("#mostrardetalleRgrupo").html(datos);
                                            }
                                        }
                                    });
                        }
                    };
                    $.validation(options);
                });


                function detallerecursosgrupo(idGrupoDetalle)
                {

                    $.ajax
                            ({
                                type: 'POST',
                                url: 'consultas/InformeRecursos/consultaDetalleRecursoGrupo.php',
                                data: 'idTipo=' + idGrupoDetalle,
                                success: function (datos) {

                                    if (datos)
                                    {
                                        $("#mostrardetalleRgrupo").html(datos);
                                    }
                                }
                            });
                }


                function detallerecursosgruposubgrupo(idGrupoDetalle, idSubgrupodetalle)
                {

                    $.ajax
                            ({
                                type: 'POST',
                                url: 'consultas/InformeRecursos/consultaDetalleRecursoGrupoSubgrupo.php',
                                data: 'idTipo=' + idGrupoDetalle + '&subgrupo=' + idSubgrupodetalle,
                                success: function (datos) {

                                    if (datos)
                                    {
                                        $("#mostrardetalleRgrupo").html(datos);
                                    }
                                }
                            });
                }

                function exportar_excel(id_form, id_tabla)
                {
                    // Obtiene el contenido de la tabla indicada
                    var tabla = $("." + id_tabla).html();
                    // Añade los tags de tabla
                    tabla = "<table>" + tabla + "</table>";
                    // Almacena en el campo oculto los datos a exportar
                    $("#datos_a_enviar").val(tabla);
                    // Activa el formulario, el cual lanza el código en PHP
                    $("#" + id_form).submit();
                }


                $("#exportar").click(function () {

                    exportar_excel('form_excel_recurso', 'detallegruporecurso');

                });

                $("#pdf").click(function () {

                    html = $('.detallegruporecurso').html();
                    cadenahtml = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>Reporte Asistencia</title></head> <body style="margin-top:30px; margin-left: 300px; margin-right: 300px;"><center><table  class="detallegruporecurso" id="detallegruporecurso" cellpadding="0" cellspacing="0" > ' + html + '</table></center></body> </html>'
                    $("#html").text(cadenahtml);//al text area le asigno toda la variable html
                    $("#frmpdf").submit();//envio el formulario
                });


                $("#print").click(function () {
                    $("#mostrardetalleRgrupo").printArea();
                });

                $("#enviar").button().click(function () {

                    var desde = $("#desde_uso").val();
                    var hasta = $("#hasta_uso").val();

                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "desde_uso",
                                validations: {
                                    required: [true, "El campo desde no puede estar vacio."]

                                }
                            },
                            {
                                id: "hasta_uso",
                                validations: {
                                    required: [true, "El campo hasta no puede estar vacio."]

                                }
                            }
                        ],
                        beforeValidation: function () {

                            $.ajax
                                    ({
                                        type: 'POST',
                                        url: 'consultas/Recurso/cons_liberar_recurso.php',
                                        data: 'desde=' + desde + '&hasta=' + hasta,
                                        success: function (datos) {

                                            if (datos)
                                            {
                                                $("#detalle_recursos").html(datos);
                                                $("#lrecurso").show();
                                            }
                                        }
                                    });


                        }
                    };
                    $.validation(options);

                });

                $("#lrecurso").button().click(function () {

                    Arrayliberarrecursos = [];
                    contador_salida_recurso = 0;


                    $("input:checked.chkliberar_recursos").each(
                            function (i) {
                                recurso = $(this).val();
                                contador_salida_recurso += 1;
                                Arrayliberarrecursos[i] = recurso;
                                //console.log(Arrayliberarrecursos);

                            });



                    if (contador_salida_recurso > 0)
                    {

                        $.ajax({
                            type: 'POST',
                            url: 'funciones/Recurso/liberar_recurso.php',
                            data: 'Arrayliberarrecursos=' + Arrayliberarrecursos,
                            // Formato de datos que se espera en la respuesta
                            dataType: "json",
                            success: function (datos)
                            {
                                var html = '<p align= center> Información Recursos </p>';
                                html += '<p align= center> Se liberaron exitosamente' + " " + datos.exit_recursos + " " + 'recurso(s)' + '</p>';
                                alertas(html, "Liberar Recursos", "done");
                                Arrayliberarrecursos.length = 0;
                            }

                        });
                    } else
                    {
                        alertas("Por favor seleccione al menos un recurso para liberar ", "Liberar Recursos", "error");
                    }

                });


            }); // cierra el function
        </script>


    </head>

    <body>


        <p id="validateErrors"></p>

        <div id="tabs" style="width:750px; min-height:0px; max-height:auto;">
            <ul>
                <li><a href="#Recursos">Recursos</a></li>
                <li><a href="#Enuso">En uso</a></li>

            </ul>

            <div id="Recursos"> 

                <div id="" class="text ui-widget-content ui-corner-all" style="width:500px; margin-bottom:15px; height:auto; font-size:12px;">
                    <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">INFORME RECURSOS</div> 


                    <table style="margin-left:15px;">

                        <tr> 
                            <td><label>Grupo:</label></td>
                            <td><select size="1" class="text ui-widget-content ui-corner-all" id="grupo">
                                    <?php
                                    do {
                                        ?>
                                        <option value="<?php echo $row_JRRecursos['idTipo'] ?>" ><?php echo $row_JRRecursos['descripcionTipo'] ?></option>
                                        <?php
                                    }
                                    while ($row_JRRecursos = mysql_fetch_assoc($JRRecursos));
                                    $rows = mysql_num_rows($JRRecursos);
                                    if ($rows > 0) {
                                        mysql_data_seek($JRRecursos, 0);
                                        $row_JRRecursos = mysql_fetch_assoc($JRRecursos);
                                    }
                                    ?>
                                </select></td>
                            <td><img src="images/camera.png" id="busquedagrupo" title="Realiza una busqueda de recursos por grupo"/></td>
                        </tr>
                    </table>

                    <table style="margin-left:15px;">
                        <tr>     

                            <td><label>subGrupo:</label></td>
                            <td><select size="1" name="subgrupo"   class="text ui-widget-content ui-corner-all" id="subgrupo">
                                    <option selected value="0">Seleccione</option></select>

                            </td>

                            <td><img src="images/video-projector.png" id="busquedagruposubgrupo" title="Realiza una busqueda de recursos por Grupo y Subgrupo"/></td>

                        </tr>

                    </table >

                    <table style="margin-left:15px;">

                        <tr>
                            <td><label>No Inventario:</label></td>
                            <td><input type="text"  id="NoInventario" size="20" maxlength="128"   class="text ui-widget-content ui-corner-all"/></td>
                            <td><img src="images/alacarte.png" id="busquedaInventario" title="Realiza una busqueda de un recurso que se encuentre prestado por un usuario, especificando un grupo, subgrupo, No inventario y un rango de fechas "/></td>     
                        </tr>
                    </table>

                    <table  style="margin-left:15px;">
                        <tr>

                            <td><label>Recurso:</label></td>
                            <td><input type="text" id="nombrebien" size="45" maxlength="128"   class="text ui-widget-content ui-corner-all"/></td>
                            <td><img src="images/date.png" id="busquedainventarios" title="Realiza una busqueda de un recurso que se encuentre prestado por uno o varios usuarios, especificando un grupo, subgrupo y un rango de fechas "/></td>
                        </tr>

                    </table>   

                    </table>

                    <table  style="margin-left:15px;">          
                        <tr>
                            <td><label>Cantidad Total:</label></td>
                            <td><input type="text" id="cantidadtotal" size="5" maxlength="128"  class="text ui-widget-content ui-corner-all"/></td>
                            <td><label>Prestados:</label></td>
                            <td><input type="text" id="prestados" size="5"   class="text ui-widget-content ui-corner-all" /></td>
                            <td><label>Disponibles:</label></td>
                            <td><input type="text" id="disponibles" size="5"  class="text ui-widget-content ui-corner-all"/></td>
                        </tr>

                    </table> 

                    <table  style="margin-left:15px; ">
                        <tr>
                            <td><label>Consulte Historico:</label></td>
                            <td><label>Desde:</label></td>
                            <td><input type="text" id="desde" size="15" class="text ui-widget-content ui-corner-all" /></td>
                            <td><label>Hasta:</label></td>
                            <td><input type="text" id="hasta" size="15"   class="text ui-widget-content ui-corner-all" /></td>
                        </tr>

                    </table>

                    <table style="margin-left:15px;">
                        <tr>
                            <td><button type="button" id="limpiar"  style="font-size:11px; margin-bottom:10px;"> <img src="images/broom.png"  style="vertical-align:middle; padding-right:3px"/>Limpiar</button></td>

                        </tr>
                    </table>  


                </div>



                <div id="mostrardetalleRgrupo" style="margin-bottom:15px; min-width:0; max-width:600px; max-height:400px; min-height:0px; overflow: auto; visibility: visible;">

                </div>

                <p><a href="#" id="exportar"  title="Exportar a Excel" style="padding-top:5px;"><img src="images/exportaraexcel.png" /></a><a href="#"  title="Exportar a Pdf" id="pdf"> <img src="images/Exportarapdf.png" /></a> <a href="#"  title="Imprimir" id="print"> <img src="images/document-print.png" /></a> </p>

                <form action="forms/ReportesAdministrador/Recursos/FicheroExcelRepRecurso.php" id="form_excel_recurso"  method="post" target="_blank">
                    <!-- Inicia el proceso de exportar -->
                    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>  
                </form>


                <form action="forms/ReportesAdministrador/Recursos/formpdfrecurso.php" method="post" id="frmpdf">
                    <textarea id="html" name="html"></textarea>
                </form>
            </div>

            <div id="Enuso"> 
                <table  style="margin-left:15px; ">
                    <tr>
                        <td><label>Consulte Historico:</label></td>
                        <td><label>Desde:</label></td>
                        <td><input type="text" id="desde_uso" size="15" class="text ui-widget-content ui-corner-all" /></td>
                        <td><label>Hasta:</label></td>
                        <td><input type="text" id="hasta_uso" size="15"   class="text ui-widget-content ui-corner-all" /></td>
                        <td><button type="button" id="enviar"  style="font-size:11px; margin-bottom:10px; margin-top:10px;"> <img src="images/aceptar.png"  style="vertical-align:middle; padding-right:3px"/>Aceptar</button></td>   

                    </tr>

                </table> 
                <div id="detalle_recursos" style="overflow:auto; width:680px; min-height:0px; max-height:300px;"> </div>

                <td><button type="button" id="lrecurso"  style="font-size:11px; margin-bottom:10px; margin-top:10px; display:none"> <img src="images/aceptar.png"  style="vertical-align:middle; padding-right:3px"/>Liberar recursos</button></td>   
            </div>    
        </div>

        <div id="alertas"></div>	


    </body>
</html>
<?php
mysql_free_result($JRRecursos);
?>
