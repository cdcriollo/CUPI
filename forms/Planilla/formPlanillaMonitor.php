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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cupi-Control de Utilizacion Piso Informatico</title>

        <script type="text/javascript">

            $(function () {

                $("#infoturnogeneral").hide();
                $("#iniciar_turno").hide();
                $("#terminar_turno").hide();

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

                function consultarPlanilla(codigo)
                {
                    $.ajax({
                        type: 'POST',
                        url: 'consultas/Monitores/consultarPlanilla.php',
                        data: 'codigo=' + codigo,
                        success: function (datos) {
                            $("#infoturnos").html(datos);
                        }
                    });
                }



                function consultarMonitor(codigo) {

                    $.ajax({
                        type: 'POST',
                        url: 'consultas/Monitores/consultarMonitorCodigo.php',
                        data: 'codigo=' + codigo,
                        dataType: "json",
                        success: function (datos) {

                            if (datos.error == 0) {
                                var nombre = datos.nombres + " " + datos.apellidos
                                $("#nombre").val(nombre);
                                $("#iniciar_turno").show();
                                $("#terminar_turno").show();
                            } else if (datos.error == 1) {
                                alertas("El monitor no existe", "Planilla monitor", "error");
                            }

                        }
                    });

                }

                function tiemposMonitor(codigo) {

                    $.ajax({
                        type: 'POST',
                        url: 'consultas/Monitores/calcularTiemposMonitor.php',
                        data: 'codigo=' + codigo,
                        dataType: "json",
                        success: function (datos) {

                            if (datos.error == 0) {
                                $("#thsemestre").val(datos.total_horas_semestre);
                                $("#thtrabajadas").val(datos.total_horas_trabajadas);
                                $("#thportrabajar").val(datos.total_horas_x_trabajar);
                            } else if (datos.error == 1) {
                                //alertas("El monitor no existe","Planilla monitor","error");	
                            }

                        }
                    });

                }

                $("#iniciar_turno").button().click(function () {


                    var codigo = $("#codigo").val();


                    $.ajax({
                        type: 'POST',
                        url: 'consultas/Monitores/consultarIngresoMonitor.php',
                        data: 'codigo=' + codigo,
                        success: function (datos) {

                            if (datos == 0)
                            {
                                $.ajax({
                                    type: 'POST',
                                    url: 'funciones/Monitores/insertarPlanilla.php',
                                    data: 'codigo=' + codigo + '&opcion=' + 1,
                                    success: function (datos) {
                                        
                                        if (datos == 1)
                                        {
                                            consultarPlanilla(codigo);
                                            $("#infoturnogeneral").show();
                                            tiemposMonitor(codigo);

                                        } else
                                        {
                                            alertas("Hubo problemas para ingresar el turno, consulte al administrador","Planilla Monitores","error");
                                        }
                                    }
                                });


                            }// cierro if
                            else
                            {
                                consultarPlanilla(codigo);
                                $("#infoturnogeneral").show();
                                alertas("Por favor termine el turno que esta en curso", "Planilla Monitor", "error");
                            }
                        }
                    });



                });

                $("#terminar_turno").button().click(function () {

                    var codigo = $("#codigo").val();

                    $.ajax({
                        type: 'POST',
                        url: 'consultas/Monitores/consultarIngresoMonitor.php',
                        data: 'codigo=' + codigo,
                        success: function (datos) {

                            if (datos == 1)
                            {
                                $.ajax({
                                    type: 'POST',
                                    url: 'funciones/Monitores/insertarPlanilla.php',
                                    data: 'codigo=' + codigo + '&opcion=' + 2,
                                    success: function (datos) {

                                        if (datos == 1)
                                        {
                                            consultarPlanilla(codigo);
                                            $("#infoturnogeneral").show();
                                            tiemposMonitor(codigo);

                                        } else
                                        {
                                            alertas("Hubo problemas para terminar el turno, consulte al administrador","Planilla Monitor","error");

                                        }
                                    }
                                });


                            }// cierro if
                            else
                            {
                                alertas("No hay turno activo", "Planilla Monitor", "error");
                            }
                        }
                    });


                });

                $("#codigo").keydown(function (event) {

                    if (event.keyCode == '13') {
                        event.preventDefault();
                        var codigo = $("#codigo").val();
                        consultarMonitor(codigo)
                    }
                });

                $("#limpiarform").button().click(function () {

                    $("#codigo").val("");
                    $("#nombre").val("");
                    $("#infoturnos").empty();
                    $("#thsemestre").val("");
                    $("#thtrabajadas").val("");
                    $("#thportrabajar").val("");
                    $("#codigo").focus();


                });



            }); // cierra el function
        </script>


    </head>

    <body>

        <p id="validateErrors"></p>



        <div id="formusuario" class="text ui-widget-content ui-corner-all" style="width:500px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
            <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">PLANILLA</div>

            <table style="margin-left:15px; margin-bottom:10px;">

                <tr>
                    <td><label for="titulo">Cedula:</label></td>
                    <td><input type="text" name="codigo" id="codigo" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td>
                </tr>

                <tr>
                    <td><label for="titulo">Nombre del monitor:</label></td>
                    <td><input type="text" name="nombre" id="nombre" size="50" class="text ui-widget-content ui-corner-all height font12"/></td>    
                </tr>
            </table> 
        </div>


        <table>
        <tr>
            <td><button type="button" id="limpiarform" style="font-size:11px; padding-left: 2px; margin-top: 5px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/>Limpiar</button>  </td>  
            <td><button type="button" id="iniciar_turno"  style="font-size:11px; padding-left:2px; margin-top: 5px;"><img src="images/start.png" style="vertical-align:middle; padding-right:4px;"/>Iniciar Turno</button></td>
            <td><button type="button" id="terminar_turno"  style="font-size:11px; margin-top:5px;"><img src="images/finish.png" style="vertical-align:middle; padding-right:4px;"/>Terminar Turno</button></td>
        </tr>
        </table>

        </div> 

        <div id="infoturnogeneral">

            <!-- div que contiene la informacion de lox turnos del monitor-->
            <div id="infoturnos"></div>


            <table>
                <tr>
                    <td><label for="thsemestre" style="font-weight:bold">Total Horas Semestre:</label></td>
                    <td><input type="text" name="thsemestre" id="thsemestre" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td>
                </tr>
                <tr>
                    <td><label for="thtrabajadas" style="font-weight:bold">Total Horas Trabajadas:</label></td>
                    <td><input type="text" name="thtrabajadas" id="thtrabajadas" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td>
                </tr>
                <tr>
                    <td><label for="thportrabajar" style="font-weight:bold">Total Horas por Trabajar:</label></td>
                    <td><input type="text" name="thportrabajar" id="thportrabajar" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td>
                </tr>
            </table>

        </div>

        <div id="alertas"></div>


    </body>
</html>
