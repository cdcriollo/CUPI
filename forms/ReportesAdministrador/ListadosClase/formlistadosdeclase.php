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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin título</title>



        <script type="text/javascript">

            $(function () {

                $("#html").hide();


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

                    exportar_excel('form_excel_listado', 'ReporteClase');

                });

                $("#pdf").click(function () {

                    html = $('.ReporteClase').html();

                    cadenahtml = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>Reporte Asistencia</title></head> <body style="margin-top:30px; margin-left: 300px; margin-right: 300px;"><center><table   class="ReporteClase" id="ReporteClase" cellpadding="0" cellspacing="0" > ' + html + '</table></center></body> </html>'

                    $("#html").text(cadenahtml);//al text area le asigno toda la variable html


                    $("#frmpdf").submit();//envio el formulario


                });

                $("#print").click(function () {
                    $("#MostrarReporteListadoClase").printArea();

                });

                $("#generarlistado").button().click(function () {

                    var codigo = $('#codigo').val();
                    var grupo = $('#grupo').val();
                    consultardatosreserva(codigo, grupo);
                    $("#MostrarReporteListadoClase").empty();
                });


                $("#grupo").keydown(function (event) {

                    if (event.keyCode == '13') {
                        event.preventDefault();
                        var codigo = $('#codigo').val();
                        var grupo = $('#grupo').val();
                        consultardatosreserva(codigo, grupo);
                        $("#MostrarReporteListadoClase").empty();
                    }
                });

                $("#limpiarform").button().click(function () {

                    $('#codigo').val("");
                    $('#grupo').val("");
                    $("#MostrarReporteListadoClase").empty();
                    $("#reservas").empty();
                    $("#codigo").focus();

                });

                function consultardatosreserva(codigo, grupo)
                {


                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "codigo",
                                validations:
                                        {
                                            required: [true, "El campo codigo no puede estar vacio."]
                                        }

                            },
                            {id: "grupo",
                                validations:
                                        {
                                            required: [true, "El campo grupo no puede estar vacio."],
                                            number: [true, "El campo grupo debe contener numeros."]

                                        }
                            }
                        ],
                        beforeValidation: function ()
                        {

                            $.ajax({
                                type: 'POST',
                                dataType: 'html',
                                url: 'consultas/ReservaEventual/Obtenerreservas.php',
                                data: 'codigo=' + codigo + '&grupo=' + grupo,
                                success: function (datos)
                                {
                                    $("#reservas").html(datos);
                                }
                            });

                        }
                    };
                    $.validation(options);
                }

                $(".checkboxreserva").live("click", function () {

                    if ($(this).is(":checked"))
                    {
                        var contador = 0;

                        $("#reservas input:checked").each(
                                function (i) {
                                    valor = $(this).val();
                                    contador += 1;

                                });

                        if (contador == 1)
                        {
                            $.ajax({
                                type: 'POST',
                                url: 'consultas/listadoClase/consultalistadoclase.php',
                                data: 'reserva=' + valor,
                                success: function (datos)
                                {

                                    if (datos)
                                    {
                                        $("#MostrarReporteListadoClase").html(datos);

                                    } else
                                    {
                                        alertas("Por favor verifique los datos", "error");
                                    }
                                }
                            });
                        } else if (contador > 1)
                        {
                            alertas("Por favor seleccione una sola reserva", "Consulta Reserva Eventual", "warning")
                        }

                    }

                });
                
                $("#send_email").button().click(function () {
                  
                  $.ajax({
                                type: 'POST',
                                dataType: 'html',
                                url: 'funciones/Correo/enviar_correo.php',
                                //data: 'codigo=' + codigo + '&grupo=' + grupo,
                                success: function (datos)
                                {
                                    //$("#reservas").html(datos);
                                }
                            });
                    
                });


            });// cierro jquery



        </script>



    </head>

    <body>

        <p id="validateErrors"></p>

        <div id="formlistadosclase" class="text ui-widget-content ui-corner-all" style="width:450px;  margin-bottom:15px; height:auto; font-size:12px;">
            <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">LISTADO DE CLASE</div>

            <table style="margin-left:15px;">
                <tr>
                    <td><label for="codigo">Codigo Asignatura:</label></td>
                    <td><input type="text"  id="codigo" size="20" class="text ui-widget-content ui-corner-all"/></td>
                    <td><label for="grupo">Grupo:</label></td>
                    <td> <input type="text" size="5" id="grupo" class="text ui-widget-content ui-corner-all" ></td>            
                </tr>
            </table>

            <table  style="margin-left:15px;">
                <tr>
                    <td><button type="button" id="generarlistado" style="font-size:11px;margin-bottom:5px; margin-top:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>
                    <td>
                        <button type="button" id="limpiarform" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/> Limpiar</button>
                    </td>
                </tr>
            </table> 
        </div>

        <div id="reservas" style="margin-bottom:10px; width:500px; height:auto;"></div>

        <div id="MostrarReporteListadoClase" style="margin-bottom:15px; min-width:0; max-width:668px; max-height:500px; min-height:0px; overflow:auto; visibility:visible;"></div>


        <p><a href="#" id="exportar"  title="Exportar a Excel" style="padding-top:5px;"><img src="images/exportaraexcel.png" /></a><a href="#"  title="Exportar a Pdf" id="pdf"> <img src="images/Exportarapdf.png" /></a> <a href="#"  title="Imprimir" id="print"> <img src="images/document-print.png" /></a> </p>

        <form action="forms/ReportesAdministrador/ListadosClase/FicheroExcellistadoclase.php" id="form_excel_listado"  method="post" target="_blank">
            <!-- Inicia el proceso de exportar -->
            <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>  
        </form>


        <form action="forms/ReportesAdministrador/ListadosClase/formpdflistadoclase.php" method="post" id="frmpdf">
            <textarea id="html" name="html"></textarea>
        </form>

        <div id="formlistadosclase" class="text ui-widget-content ui-corner-all" style="width:450px;  margin-bottom:15px; height:auto; font-size:12px;">
            <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">Enviar Correo</div>

            <form name="form_contacto" enctype="multipart/form-data" method="post" action="funciones/Correo/enviar_correo.php">
                <table>
                    <tr>
                        <td><label>Para:</label></td> 
                        <td><input type="text" id="para" name="address"></input></td>
                    </tr>
                     <tr>
                        <td><label>Asunto:</label></td> 
                        <td><input type="text" id="asunto" name="subject"></input></td>
                    </tr>  
                     <tr>
                        <td><label>Mensaje:</label></td> 
                        <td><textarea rows="4" cols="30" id="mensaje" name="body"></textarea></td>
                    </tr> 
                </table>
                <table>
                    <tr>
                        <td><input type="file" name="file"/></td>
                    </tr>
                    <tr>
                        <td><input type="submit" name="enviar" /></td>
                    </tr>
                    
                </table>
            </form> 
        </div>    


        <div id="alertas"></div>





    </body>
</html>
<?php
?>


