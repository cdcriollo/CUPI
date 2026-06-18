
<?php date_default_timezone_set("America/bogota"); ?>
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

mysql_select_db($database_conexion, $conexion);
$query_JRRecursos = "SELECT * FROM gruporecurso";
$JRRecursos = mysql_query($query_JRRecursos, $conexion) or die(mysql_error());
$row_JRRecursos = mysql_fetch_assoc($JRRecursos);
$totalRows_JRRecursos = mysql_num_rows($JRRecursos);

mysql_select_db($database_conexion, $conexion);
$query_JRSalas = "SELECT numsala FROM sala where numsala not in (0)";
$JRSalas = mysql_query($query_JRSalas, $conexion) or die(mysql_error());
$row_JRSalas = mysql_fetch_assoc($JRSalas);
$totalRows_JRSalas = mysql_num_rows($JRSalas);

mysql_select_db($database_conexion, $conexion);
$query_JRActividad = "SELECT Descripcion FROM actividades order by Descripcion asc";
$JRActividad = mysql_query($query_JRActividad, $conexion) or die(mysql_error());
$row_JRActividad = mysql_fetch_assoc($JRActividad);
$totalRows_JRActividad = mysql_num_rows($JRActividad);

$stylerow = 'style="color:#0C3; font-size:14px;"';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin título</title>

        <script type="text/javascript">
            $(function () {

                $(".tableUI").styleTable();
                $("#monitor").hide();
                $("#wrapper").hide();
                $("#detallereserva").hide();
                $("#accordion").accordion({icons: {'header': 'ui-icon-plus', 'headerSelected': 'ui-icon-minus'}});
                var cadena = new Array();
                var cadenaequipos = new Array();
                var cadenaAsignatura = new Array();
                var prestamossaltemp = new Array();
                var equipossaltemp = new Array();
                var cadenaInv = new Array();
                var scrollCachePosition = 0;
                $("#mensaje").hide();

                setInterval(function () {

                    momentoActual = new Date()
                    horas = momentoActual.getHours()
                    minutos = momentoActual.getMinutes()
                    segundos = momentoActual.getSeconds()
                    if (horas <= 9)
                        horas = "0" + horas;

                    if (minutos <= 9)
                        minutos = "0" + minutos;

                    if (segundos <= 9)
                        segundos = "0" + segundos;


                    horaImprimible = horas + ":" + minutos + ":" + segundos;
                    $("#hora").val(horaImprimible);
                }, 1000);

                $("#grupo").change(function (event) {

                    var id = $("#grupo").find(':selected').val();
                    $("#subgrupo").load('consultas/Recurso/generarselect.php?id=' + id);


                });
                
                $("#sala").change(function (event) {

                    var id = $("#sala").find(':selected').val();
                    $("#comp").load('consultas/Ingreso/generarselect.php?id=' + id);

                });


                $("#alertas").dialog({
                    autoOpen: false,
                    show: "explode",
                    hide: "explode",
                    height: "120",
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


                function traerNombreUsuario(usuario)
                {
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: 'consultas/Usuario/consultarUsuario.php',
                        data: 'codigo=' + usuario,
                        success: function (datos) {

                            var nombre = datos.nombre;
                            var apellidos = datos.apellidos;
                            var nombrecompleto = nombre + " " + apellidos;
                            $("#nomusu").val(nombrecompleto);

                        }


                    });


                }

                function traersala(pc)
                {
                    $.ajax({
                        type: 'POST',
                        url: 'consultas/Ingreso/consultarSala.php',
                        data: 'pc=' + pc,
                        success: function (datos) {


                            if (datos != 0) {
                                sala = datos;
                                $("#sala").val(datos);

                            } else if (datos == 0) {
                                alertas("El computador no se encuentra disponible", "Ingresar Usuario", "error");

                            }
                        }


                    });
                }

                function Reasignarpc(pc)
                {



                    usuario = $("#codusu").val();
                    sala = $("#sala").val();

                    $.ajax({
                        type: 'POST',
                        url: 'funciones/Ingreso/ReasignarComputador.php',
                        data: 'pc=' + pc + '&usuario=' + usuario + '&sala=' + sala,
                        success: function (datos) {


                            if (datos == 1)
                            {
                                alertas("No Hay Computadores Disponibles ", "Ingresar Usuario", "error");
                            } else if (datos == 2)
                            {
                                alertas("El computador no se encuentra en la sala donde esta programada la asignatura ", "Ingresar Usuario", "error");
                            } else if (datos == 3)
                            {
                                alertas("El Computador esta en uso ", "Ingresar Usuario", "error");
                            } else if (datos == 4) {
                                alertas("La reasignacion del computador ha sido exitosa ", "Ingresar Usuario", "done");
                            } else if (datos == 0) {
                                alertas("La reasignacion del computador no se pudo realizar ", "Ingresar Usuario", "error");

                            }


                        }


                    });
                }


                function Limpiarformulario() {

                    $("#codusu").val("");
                    $("#nomusu").val("");
                    $("#sala").val("");
                    $("#comp").val("");
                }


                function busquedarecurso(GrupoRecurso, SubGrupoRecurso, inventario)
                {

                    $.ajax({
                        type: 'POST',
                        url: 'consultas/Ingreso/consultarrecursoingreso.php',
                        data: 'grupo=' + GrupoRecurso + '&subgrupo=' + SubGrupoRecurso + '&inventario=' + inventario,
                        success: function (datos) {


                            if (datos != 0) {

                                detalleR = datos.split(',');
                                Noinventario = detalleR[0];
                                cantidad = detalleR[1];
                                descripcion = detalleR[2];

                                $("#detallerecursos").append('<tbody><td class="ui-widget-content"><input type="checkbox" value="' + Noinventario + '"/></td><td class="detRecursos ui-widget-content first ">' + Noinventario + '</td><td class="detRecursos ui-widget-content first">' + cantidad + '</td><td class="detRecursos ui-widget-content first">' + descripcion + '</td></tbody>');

                                $("#NoInv").val("");

                            } else if (datos == 0)
                            {
                                alertas("El recurso no esta disponible", "Ingresar Usuario", "error");

                            }
                        }


                    });


                }

                $("#add").click(function () {

                    $("#detalleequiposexternos").append('<tbody><td><input type="checkbox"/></td><td align="center"><input type="text" class="detEquipos text ui-widget-content ui-corner-all" align="middle" id="cantidad" size="7"/></td><td align="center"><select class="detEquipos text ui-widget-content ui-corner-all"><option value="Audifonos">Audifonos</option><option value="Camara de Video">Camara de Video</option><option value="Camara Fotografica">Camara Fotografica</option><option value="Computador de Mesa">Computador de Mesa</option><option value="Instrumento Musical">Instrumento Musical</option><option value="Mouse">Mouse</option><option value="Portatil">Portatil</option><option value="Tabla Digitalizadora">Tabla Digitalizadora</option><option value="Tablero Inteligente">Tablero Inteligente</option><option value="Video Beam">Video Beam</option><option value="Otros">Otros</option></select></td><td align="center"><input type="text" class="detEquipos text ui-widget-content ui-corner-all" id="detalle" size="30"/></td></tbody>');

                });

                $("#buscarrecurso").button().click(function () {

                    GrupoRecurso = $("#grupo").val();
                    SubGrupoRecurso = $("#subgrupo").val();
                    Inventario = $("#NoInv").val();
                    busquedarecurso(GrupoRecurso, SubGrupoRecurso, Inventario);



                });


                $("#codusu").keydown(function (event) {
                    //SI DA ENTER SE HACE LO SIGUIENTE
                    if (event.keyCode == '13') {
                        event.preventDefault();
                        usuario = $("#codusu").val();
                        $("#mensaje").hide();
                        ingresarusuario(usuario);


                    }

                });




                $("#enviar").button().click(function () {


                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "sala",
                                validations: {
                                    required: [true, "El campo Sala no puede estar vacio."],
                                    number: [true, "El campo Sala debe contener numeros."]}
                            },
                            {
                                id: "comp",
                                validations: {
                                    required: [true, "El campo Computador no puede estar vacio."],
                                    number: [true, "El campo Computador debe contener numeros."]}
                            },
                            {
                                id: "codusu",
                                validations: {
                                    required: [true, "El campo Codigo no puede estar vacio."],
                                    number: [true, "El campo Codigo debe contener numeros."]}
                            },
                            {
                                id: "nomusu",
                                validations: {
                                    required: [true, "El campo nombre usuario no puede estar vacio."]}

                            },
                            {
                                id: "actividad",
                                validations: {
                                    required: [true, "El campo actividad no puede estar vacio."]}

                            }

                        ],
                        beforeValidation: function () {

                            cadena = [];
                            cadenaequipos = [];
                            cadenaAsignatura = [];

                            codigousuario = $("#codusu").val();
                            actividad = $("#actividad").val();
                            sala = $("#sala").val();
                            computador = $("#comp").val();



                            $(".detRecursos").each(function (i) {
                                valor = $(this).text();
                                cadena[i] = valor;

                            });


                            $(".detEquipos").each(function (i) {
                                valorequipo = $(this).val();
                                cadenaequipos[i] = valorequipo;

                            });

                            $(".detAsignatura").each(function (i) {
                                valorasignatura = $(this).val();
                                cadenaAsignatura[i] = valorasignatura;

                            });


                            tamañocadena = cadena.length;
                            tamañocadenaequipos = cadenaequipos.length;
                            tamañocadenaasignatura = cadenaAsignatura.length;

                            if (tamañocadena > 0) {
                                insertarprestamo = 1;
                            } else {
                                insertarprestamo = 0;
                            }
                            if (tamañocadenaequipos > 0) {
                                insertarequipo = 1;
                            } else {
                                insertarequipo = 0;
                            }
                            if (tamañocadenaasignatura > 0) {

                                asignatura = codigoasignatura;
                                codGrupo = $("#CGrupo").val();
                            } else {
                                asignatura = "NULL";
                                codGrupo = "NULL";
                            }



                            pc = $("#comp").val();

                            $.ajax({
                                type: 'POST',
                                url: 'funciones/Ingreso/NumeroIngresos.php',
                                data: 'usuario=' + codigousuario,
                                success: function (datos)
                                {

                                    if (datos == 0)
                                    {
                                        $.ajax({
                                            type: 'POST',
                                            url: 'funciones/Ingreso/insertarIngreso.php?arrayprestamo=' + cadena,
                                            data: 'usuario=' + codigousuario + '&actividad=' + actividad + '&sala=' + sala + '&computador=' + computador + '&insertprestamo=' + insertarprestamo + '&insertequipo=' + insertarequipo + '&arrayequipos=' + cadenaequipos + '&asignatura=' + asignatura + '&pc=' + pc + '&grupo=' + codGrupo,
                                            success: function (datos) {


                                                if (datos == 111111)
                                                {

                                                    $("tbody", "#detallerecursos").remove();
                                                    $("tbody", "#detalleasignatura").remove();
                                                    $("tbody", "#detalleequiposexternos").remove();
                                                    $("#Recursos").hide();
                                                    $("#mensaje").show();
                                                    Limpiarformulario();
                                                    $("#codusu").focus();
                                                } else if (datos == 11)
                                                {
                                                    $("tbody", "#detalleasignatura").remove();
                                                    $("#Recursos").hide();
                                                    $("#mensaje").show();
                                                    Limpiarformulario();
                                                    $("#codusu").focus();
                                                } else if (datos == 1111)
                                                {
                                                    $("tbody", "#detallerecursos").remove();
                                                    $("tbody", "#detalleasignatura").remove();
                                                    $("tbody", "#detalleequiposexternos").remove();
                                                    $("#Recursos").hide();
                                                    $("#mensaje").show();
                                                    Limpiarformulario();
                                                    $("#codusu").focus();
                                                } else
                                                {
                                                    alertas("Ha ocurrido un problema al realizar el ingreso, por favor verifique que el usuario haya ingresado o que los prestamos o ingresos que se hayan realizado esten correctos ", "Ingresar Usuario", "error");
                                                }

                                            }
                                        });
                                    } else
                                    {
                                        NoIngresos = datos.split(',');
                                        respuesta = NoIngresos[0];
                                        Estado = NoIngresos[9];

                                        if (Estado == 5)
                                        {
                                            mensajeEstado = "El usuario no realizo ningun prestamo, ni ingreso equipos";
                                        } else if (estado == 2)
                                        {
                                            mensajeEstado = "El usuario realizo un prestamo";
                                        } else if (estado == 3)
                                        {
                                            mensajeEstado = "El usuario ingreso un equipo";
                                        } else if (estado == 4)
                                        {
                                            mensajeEstado = "El usuario realizo un prestamo e ingreso un equipo";
                                        }

                                        mensaje = "Codigo Ingreso:" + " " + NoIngresos[1] + " " + "codUsuario:" + " " + NoIngresos[2] + " " + "actividad:" + " " + NoIngresos[3] + " " + "codAsignatura:" + " " + NoIngresos[4] + " " + "codGrupo:" + " " +
                                                NoIngresos[5] + " " + "Sala:" + " " + NoIngresos[6] + " " + "Fecha:" + " " + NoIngresos[7] + " " + "Hora Ingreso:" + " " + NoIngresos[8] + " " + "Estado:" + " " + mensajeEstado;


                                        if (respuesta == 1)
                                        {
                                            alertas("El usuario ya ha ingresado al piso con la siguiente información:" + mensaje + "", "Ingreso Usuario", "error");
                                        }
                                    }
                                }
                            });
                        }
                    };
                    $.validation(options);

                });// cierra enviar


                function ingresarusuario(usuario)
                {

                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "codusu",
                                validations:
                                  {
                                     required: [true, "El campo Codigo no puede estar vacio."],
                                     number: [true, "El campo Codigo debe contener numeros."]
                                 }
                            }

                        ],
                        beforeValidation: function () {

                            horainicio = $("#hora").val();
                            $("tbody", "#detalleasignatura").remove();


                            $.ajax({
                                type: 'POST',
                                dataType: 'json',
                                url: 'consultas/Ingreso/ingresarUsuario.php',
                                data: 'usuario=' + usuario,
                                success: function (datos) {

                                    if (datos.error == 0)
                                    {
                                        alertas("El usuario no existe, por favor contacte con el coordinador del piso ", "Ingresar Usuario", "error");
                                    } else if (datos.error == 1)
                                    {
                                        alertas(" El usuario no tiene clase en el dia y hora especificada por favor especifique otra actividad", "Ingresar Usuario", "inform");
                                        traerNombreUsuario(usuario);
                                        $("#sala").val("");
                                        $("#comp").val("");
                                    } else if (datos.error == 2)
                                    {
                                        alertas("El usuario no tiene clase en la hora indicada ", "Ingresar Usuario", "inform");
                                        traerNombreUsuario(usuario);
                                        $("#sala").val("");
                                        $("#comp").val("");
                                    } else if (datos.error == 4)
                                    {
                                        alertas("La asignatura esta programada para una fecha posterior o la programación de la asignatura ha terminado", "Ingresar Usuario", "inform");
                                    } else if (datos.error == 3)
                                    {

                                        $("#nomusu").val(datos.usuario);
                                        //$("#comp").val(datos.pc)
                                        $('#comp').append('<option value="'+ datos.pc +'" selected="selected">'+ datos.pc+ '</option>');
                                        $("#sala").val(datos.sala);
                                        $("#actividad").val(datos.actividad);
                                        codigoasignatura = datos.codasignatura;
                                        $("#codA").val(codigoasignatura);
                                        grupoasignatura = datos.grupo;
                                        $("#CGrupo").val(grupoasignatura);
                                        nombreasignatura = datos.nomasignatura;


                                        $('#detalleasignatura').append('<tr><td class="detAsignatura ui-widget-content">' + codigoasignatura + '</td><td class="detAsignatura ui-widget-content first">' + grupoasignatura + '</td><td class="detAsignatura ui-widget-content first">' + nombreasignatura + '</td></tr>');

                                        No_reserva = datos.reserva;

                                        if (No_reserva != null)
                                        {
                                            cadenareserva = No_reserva.split("-");
                                            Reserva = cadenareserva[0];
                                            reservainternet(No_reserva);

                                        } else
                                        {
                                            Reserva = "null";
                                        }

                                        if (Reserva == "FAIPIRE" || "FAIPIRS")
                                        {
                                            $.ajax({
                                                type: 'POST',
                                                dataType: 'html',
                                                url: 'consultas/ReservaEventual/ConsultarRecursos.php',
                                                data: 'reserva=' + No_reserva + '&opcion=' + 1,
                                                success: function (datos)
                                                {
                                                    $("#recursosreservados").html(datos);
                                                    $("#detallereserva").show("slide");
                                                    $("#numreserva").val(No_reserva);

                                                }
                                            });
                                        }

                                    }
                                }
                            });
                        }
                    };
                    $.validation(options);
                }


                $("#comp").dblclick(function () {

                    computador = $("#comp").val();

                    if (computador != "") {
                        if ($("#Reasigcomp").attr('checked') == false)
                        {
                            traersala(computador);
                        } else if ($("#Reasigcomp").attr('checked') == true)
                        {

                            Reasignarpc(computador);

                        }

                    } else
                    {
                        alertas("El campo computador no puede estar vacio ", "Ingresar Usuario", "error");
                    }


                });


                $('#eliminar').button().click(function () {

                    $("#detallerecursos").find("input:checked").parents("tr").remove();

                });


                $("#delete").click(function () {

                    $("#detalleequiposexternos").find("input:checked").parents("tr").remove();

                });



                $("#SalTemp").click(function () {

                    if ($("#SalTemp").is(":checked"))
                    {

                        var options = {
                            classerror: "ui-state-error",
                            classdone: "ui-state-highlight",
                            contentmsg: "validateErrors",
                            fields: [
                                {
                                    id: "sala",
                                    validations: {
                                        required: [true, "El campo Sala no puede estar vacio."],
                                        number: [true, "El campo Sala debe contener numeros."]}
                                },
                                {
                                    id: "comp",
                                    validations: {
                                        required: [true, "El campo Computador no puede estar vacio."],
                                        number: [true, "El campo Computador debe contener numeros."]}
                                },
                                {
                                    id: "codusu",
                                    validations: {
                                        required: [true, "El campo Codigo no puede estar vacio."],
                                        number: [true, "El campo Codigo debe contener numeros."]}
                                },
                                {
                                    id: "nomusu",
                                    validations: {
                                        required: [true, "El campo nombre usuario no puede estar vacio."]}

                                }

                            ],
                            beforeValidation: function ()
                            {

                                StUsuario = $("#codusu").val();
                                StActividad = $("#actividad").val();
                                StSala = $("#sala").val();
                                StPc = $("#comp").val();
                                prestamossaltemp = [];
                                equipossaltemp = [];

                                $(".detRecursos").each(function (i) {
                                    prestamo = $(this).text();
                                    prestamossaltemp[i] = prestamo;

                                });


                                $(".detEquipos").each(function (i) {
                                    equipo = $(this).val();
                                    equipossaltemp[i] = equipo;

                                });

                                tamañocadenap = prestamossaltemp.length;
                                tamañocadenae = equipossaltemp.length;

                                // examino el tamaño de los arrays
                                if (tamañocadenap > 0)
                                {
                                    varinsertarp = 1;
                                } else
                                {
                                    varinsertarp = 0;
                                }
                                if (tamañocadenae > 0)
                                {
                                    varinsertare = 1;
                                } else
                                {
                                    varinsertare = 0;
                                }

                                $.ajax({
                                    type: 'POST',
                                    url: 'funciones/Ingreso/Salidatemporalusuario.php?arraye=' + equipossaltemp,
                                    data: 'usuario=' + StUsuario + '&actividad=' + StActividad + '&sala=' + StSala + '&pc=' + StPc + '&varinsertarp=' + varinsertarp + '&varinsertare=' + varinsertare + '&arrayp=' + prestamossaltemp,
                                    success: function (datos) {


                                        if (datos == 1111111)

                                        {
                                            $("tbody", "#detallerecursos").remove();
                                            $("tbody", "#detalleasignatura").remove();
                                            $("tbody", "#detalleequiposexternos").remove();
                                            alertas("La nueva actividad ha sido asignada exitosamnente ", "Ingresar Usuario", "done");
                                            $("#SalTemp").attr('checked', false);
                                            Limpiarformulario();

                                        } else if (datos == 111)
                                        {
                                            $("tbody", "#detalleasignatura").remove();
                                            alertas("La nueva actividad ha sido asignada exitosamnente ", "Ingresar Usuario", "done");
                                            $("#SalTemp").attr('checked', false);
                                            Limpiarformulario();
                                        } else if (datos == 11111)
                                        {
                                            $("tbody", "#detallerecursos").remove();
                                            $("tbody", "#detalleasignatura").remove();
                                            $("tbody", "#detalleequiposexternos").remove();
                                            alertas("La nueva actividad ha sido asignada exitosamnente ", "Ingresar Usuario", "done");
                                            $("#SalTemp").attr('checked', false);
                                            Limpiarformulario();
                                        }
                                    }

                                });
                            }
                        };
                        $.validation(options);
                    }// cierro if
                });


                $("#Reingreso").click(function () {

                    if ($("#Reingreso").is(":checked"))
                    {

                        var options = {
                            classerror: "ui-state-error",
                            classdone: "ui-state-highlight",
                            contentmsg: "validateErrors",
                            fields: [
                                {
                                    id: "sala",
                                    validations: {
                                        required: [true, "El campo Sala no puede estar vacio."],
                                        number: [true, "El campo Sala debe contener numeros."]}
                                },
                                {
                                    id: "comp",
                                    validations: {
                                        required: [true, "El campo Computador no puede estar vacio."],
                                        number: [true, "El campo Computador debe contener numeros."]}
                                },
                                {
                                    id: "codusu",
                                    validations: {
                                        required: [true, "El campo Codigo no puede estar vacio."],
                                        number: [true, "El campo Codigo debe contener numeros."]}
                                },
                                {
                                    id: "nomusu",
                                    validations: {
                                        required: [true, "El campo nombre usuario no puede estar vacio."]}

                                }

                            ],
                            beforeValidation: function ()
                            {

                                RUsuario = $("#codusu").val();
                                RActividad = $("#actividad").val();
                                RSala = $("#sala").val();
                                RPc = $("#comp").val();
                                Casignatura = $("#codA").val();
                                RGrupo = $("#CGrupo").val();


                                $.ajax({
                                    type: 'POST',
                                    url: 'funciones/Ingreso/Reingresousuario.php',
                                    data: 'usuario=' + RUsuario + '&actividad=' + RActividad + '&sala=' + RSala + '&pc=' + RPc + '&asignatura=' + Casignatura + '&grupo=' + RGrupo,
                                    success: function (datos) {


                                        if (datos == 11111)
                                        {
                                            alertas("El usuario ha sido reingresado a la clase exitosamente ", "Ingresar Usuario", "done");
                                        } else if (datos == 1111)
                                        {
                                            alertas("El usuario ha sido reingresado a la clase exitosamente ", "Ingresar Usuario", "done");
                                        } else
                                        {
                                            alertas("Ha ocurrido un error ", "Ingresar Usuario", "error");
                                        }
                                    }
                                });
                            }
                        };
                        $.validation(options);
                    }// cierro if
                });


                $("#actividad").change(function () {

                    if ($("#actividad").val() == "Monitor de Clase" || $("#actividad").val() == "Clase Eventual" || $("#actividad").val() == "Reunion")
                    {
                        $("#monitor").show("slide");

                    }


                });


                $("#MGrupo").dblclick(function () {

                    CodigoAsig = $("#MCodigo").val();
                    GrupoAsig = $("#MGrupo").val();

                    $.ajax({
                        type: 'POST',
                        url: 'consultas/Ingreso/consultarNombreAsig.php',
                        data: 'codigo=' + CodigoAsig + '&grupo=' + GrupoAsig,
                        success: function (datos) {

                            if (datos != 0)
                            {
                                $("#MAsignatura").val(datos);
                            } else
                            {
                                alertas("Por favor verifique que la asignatura existe o el grupo existe ", "Ingresar Usuario", "error");
                            }
                        }

                    });


                });


                function reservainternet(Reserva)
                {
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: 'consultas/ReservaEventual/Consultarreserva.php',
                        data: 'Numreserva=' + Reserva,
                        success: function (datos)
                        {
                            if (datos.error == 1)
                            {
                                $("#resinternet").val(datos.internet);

                            }
                        }
                    });
                }


                $("#IngresoMonitor").button().click(function ()
                {
                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "sala",
                                validations: {
                                    required: [true, "El campo Sala no puede estar vacio."],
                                    number: [true, "El campo Sala debe contener numeros."]}
                            },
                            {
                                id: "comp",
                                validations: {
                                    required: [true, "El campo Computador no puede estar vacio."],
                                    number: [true, "El campo Computador debe contener numeros."]}
                            },
                            {
                                id: "codusu",
                                validations: {
                                    required: [true, "El campo Codigo Usuario no puede estar vacio."],
                                    number: [true, "El campo Codigo debe contener numeros."]}
                            },
                            {
                                id: "MCodigo",
                                validations: {
                                    required: [true, "El campo Codigo no puede estar vacio."]}

                            },
                            {
                                id: "MGrupo",
                                validations: {
                                    required: [true, "El campo Grupo no puede estar vacio."],
                                    number: [true, "El campo Grupo debe contener numeros."]}
                            },
                            {
                                id: "MAsignatura",
                                validations: {
                                    required: [true, "El campo Asignatura no puede estar vacio."]}

                            },
                        ],
                        beforeValidation: function () {

                            cadena = [];
                            cadenaequipos = [];


                            codigousuarioM = $("#codusu").val();
                            actividadM = $("#actividad").val();
                            salaM = $("#sala").val();
                            computadorM = $("#comp").val();
                            MCodigo = $("#MCodigo").val();
                            MGrupo = $("#MGrupo").val();



                            $(".detRecursos").each(function (i) {
                                valor = $(this).text();
                                cadena[i] = valor;

                            });


                            $(".detEquipos").each(function (i) {
                                valorequipo = $(this).val();
                                cadenaequipos[i] = valorequipo;

                            });




                            tamañocadenaM = cadena.length;
                            tamañocadenaequiposM = cadenaequipos.length;


                            if (tamañocadenaM > 0) {
                                insertarprestamo = 1;
                            } else {
                                insertarprestamo = 0;
                            }
                            if (tamañocadenaequiposM > 0) {
                                insertarequipo = 1;
                            } else {
                                insertarequipo = 0;
                            }

                            pc = $("#comp").val();

                            $.ajax({
                                type: 'POST',
                                url: 'funciones/Ingreso/insertarIngreso.php?arrayprestamo=' + cadena,
                                data: 'usuario=' + codigousuarioM + '&actividad=' + actividadM + '&sala=' + salaM + '&computador=' + computadorM + '&insertprestamo=' + insertarprestamo + '&insertequipo=' + insertarequipo + '&arrayequipos=' + cadenaequipos + '&asignatura=' + MCodigo + '&pc=' + pc + '&grupo=' + MGrupo,
                                success: function (datos) {



                                    if (datos == 111111)
                                    {

                                        $("tbody", "#detallerecursos").remove();
                                        $("tbody", "#detalleequiposexternos").remove();
                                        alertas("El usuario ha ingresado exitosamente a la sala", "Ingresar Usuario", "done");
                                        Limpiarformulario();
                                        $("#monitor").hide();
                                    } else if (datos == 11)
                                    {

                                        alertas("El usuario ha ingresado exitosamente a la sala", "Ingresar Usuario", "done");
                                        Limpiarformulario();
                                        $("#monitor").hide();

                                    } else if (datos == 1111)
                                    {
                                        $("tbody", "#detallerecursos").remove();
                                        $("tbody", "#detalleequiposexternos").remove();
                                        alertas("El usuario ha ingresado exitosamente a la sala", "Ingresar Usuario", "done");
                                        Limpiarformulario();
                                        $("#monitor").hide();
                                    } else
                                    {
                                        alertas("Ha ocurrido un error", "Ingresar Usuario", "error");
                                    }
                                }
                            });
                        }
                    };
                    $.validation(options);

                });

                // Codigo javascript para el popup

                $("#abrirPop").button().click(function (event) {
                    scrollCachePosition = $(window).scrollTop();
                    //Envío el scroll a la posición 0 (left), 0 (top), es decir, arriba de todo.
                    window.top.scroll(0, 0);

                    //Si el body es mas grande que la capa 'wrapper' incrementa la altura del body a la capa 'capaPopUp'.
                    if ($("body").outerHeight() > $("#wrapper").outerHeight()) {
                        var altura = $("body").outerHeight();
                    } else {
                        //Si la capa 'wrapper' es más grande que el body incrementa la altura de la capa 'wrapper' a la capa 'capaPopUp'.
                        var altura = $("#wrapper").outerHeight();
                    }
                    window.document.getElementById("capaPopUp").style.height = altura + "px";
                    event.preventDefault();
                    //Muestro la capa con el efecto 'slideToggle'.
                    $("#capaPopUp").slideToggle();

                    //Calculo la altura de la capa 'popUpDiv' y lo divido entre 2 para darle un margen negativo.
                    var altura = $("#popUpDiv").outerHeight();
                    $("#popUpDiv").css("margin-top", "-" + parseInt(altura / 2) + "px");

                    //Calculo la anchura de la capa 'popUpDiv' y lo divido entre 2 para darle un margen negativo.
                    var anchura = $("#popUpDiv").outerWidth();
                    $("#popUpDiv").css("margin-left", "-" + parseInt(anchura / 2) + "px");

                    $.ajax({
                        type: 'POST',
                        url: 'consultas/Ingreso/popuppcs.php',
                        success: function (datos)
                        {
                            $("#capaContent").html(datos);
                        }
                    });


                    //Muestro la capa con el efecto 'slideToggle'.
                    $("#popUpDiv").slideToggle();
                });

                $("#cerrar").click(function (event) {
                    event.preventDefault();
                    //Cierro las capas con el efecto 'slideToggle'.
                    $("#capaPopUp").slideToggle();
                    $("#popUpDiv").slideToggle();
                    //Si la variable scrollCachePosition es mayor que 0 incrementará la posición del scroll al valor que se almacenó. 
                    if (scrollCachePosition > 0) {
                        window.top.scroll(0, scrollCachePosition);
                        //Reseteamos la variable scrollCachePosition a 0 para poder ejecutar el script tantas veces sea necesario.
                        scrollCachePosition = 0;
                    }
                });


                $("#PEExtemporaneo").button().click(function () {

                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "codusu",
                                validations: {
                                    required: [true, "El campo Codigo Usuario no puede estar vacio."],
                                    number: [true, "El campo Codigo Usuario debe contener numeros."]}
                            },
                        ],
                        beforeValidation: function ()
                        {

                            cadena = [];
                            cadenaequipos = [];

                            codigousuario = $("#codusu").val();


                            $(".detRecursos").each(function (i) {
                                valor = $(this).text();
                                cadena[i] = valor;

                            });


                            $(".detEquipos").each(function (i) {
                                valorequipo = $(this).val();
                                cadenaequipos[i] = valorequipo;

                            });


                            tamañocadena = cadena.length;
                            tamañocadenaequipos = cadenaequipos.length;


                            if (tamañocadena > 0) {
                                insertarprestamo = 1;
                            } else
                            {
                                insertarprestamo = 0;
                            }
                            if (tamañocadenaequipos > 0) {
                                insertarequipo = 1;
                            } else
                            {
                                insertarequipo = 0;
                            }



                            if (insertarprestamo == 0 && insertarequipo == 0)
                            {
                                alertas("Por favor realice un prestamo o ingrese un equipo", "Ingreso Usuarios", "error");
                            } else
                            {
                                $.ajax({
                                    type: 'POST',
                                    url: 'funciones/Ingreso/PrestamoeIngresoExt.php?arrayprestamo=' + cadena,
                                    data: 'usuario=' + codigousuario + '&insertprestamo=' + insertarprestamo + '&insertequipo=' + insertarequipo + '&arrayequipos=' + cadenaequipos,
                                    success: function (datos) {

                                        if (datos == 4)
                                        {
                                            alertas("El usuario no existe", "Ingreso Usuario", "error");
                                        } else if (datos == 2)
                                        {
                                            alertas("El usuario no ha tenido ingresos en este dia", "Ingreso Usuario", "error");
                                        } else if (datos == 3)
                                        {
                                            alertas("El usuario ha tenido mas de un ingreso", "Ingreso Usuario", "error");
                                        } else if (datos == 11111)
                                        {

                                            $("tbody", "#detallerecursos").remove();
                                            $("tbody", "#detalleequiposexternos").remove();
                                            $("tbody", "#detalleasignatura").remove();
                                            alertas("El prestamo e ingreso de equipo se ha realizado satisfatoriamente", "Ingreso Usuario", "done");
                                            Limpiarformulario();

                                        } else if (datos == 111)
                                        {
                                            $("tbody", "#detallerecursos").remove();
                                            $("tbody", "#detalleasignatura").remove();
                                            alertas("El prestamo se ha realizado satisfatoriamente", "Ingreso Usuario", "done");
                                            Limpiarformulario();
                                        } else if (datos == 1111)
                                        {
                                            $("tbody", "#detalleequiposexternos").remove();
                                            $("tbody", "#detalleasignatura").remove();
                                            alertas("El Ingreso de equipo se ha realizado satisfatoriamente", "Ingreso Usuario", "done");
                                            Limpiarformulario();
                                        } else
                                        {
                                            alertas("Ha ocurrido un error", "Ingresar Usuario", "error");
                                        }
                                    }//cierro success
                                });	// cierro ajax
                            }// cierro else
                        }
                    };
                    $.validation(options);

                });

                $("#closerec").click(function () {

                    $("#detallereserva").hide("slide");


                });

                $("#closemonitor").click(function () {

                    $("#monitor").hide("slide");

                });


            }); // cierra jquery
        </script>

    </head>

    <body>

        <p id="validateErrors"></p>
        <p id="mensaje" <?php echo $stylerow; ?>>El usuario ha ingresado correctamente</p>

        <div class="text ui-widget-content ui-corner-all" style="width:640px; height:220px; font-size:12px; margin-bottom:15px; background-color:#F8F8F8; background-repeat:repeat-y;">
            <div class="ui-state-default" style="margin-bottom:10px; text-align:center;">INGRESO USUARIOS</div>

            <table style="margin-left:10px">

                <tr>
                    <td><label>Codigo Usuario:</label></td>
                    <td><input type="text" name="codusu" id="codusu" size="15" class="text ui-widget-content ui-corner-all height font12" /></td>
                    <td><label>Actividad:</label></td>
                    <td><select id="actividad" size="1" class="text ui-widget-content">
                            <option value="">Seleccione</option>
                            <?php
                            do {
                                ?>
                                <option value="<?php echo $row_JRActividad['Descripcion'] ?>"><?php echo $row_JRActividad['Descripcion'] ?></option>
                                <?php
                            }
                            while ($row_JRActividad = mysql_fetch_assoc($JRActividad));
                            $rows = mysql_num_rows($JRActividad);
                            if ($rows > 0) {
                                mysql_data_seek($JRActividad, 0);
                                $row_JRActividad = mysql_fetch_assoc($JRActividad);
                            }
                            ?>
                        </select></td>

                </tr>

            </table>

            <table  style="margin-left:10px">
                <tr>
                    <td><label>Nombre Usuario:</label></td>
                    <td><input type="text" name="nomusu" id="nomusu" size="40" disabled  class="text ui-widget-content ui-corner-all height font12"/></td>
                    <td><label>Fecha:</label></td>
                    <td><input type="text" id="fecha" size="40"  class="text ui-widget-content ui-corner-all height font12" value="<?php
                        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
                        $mes = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                        $ano = date('Y');
                        ?> <?php echo '' . $dias[date('w')] . ' ' . date('d') . ' de ' . $mes[date('n')] . ' del ' . $ano . '' ?>"/></td>    
                    <input type="hidden" id="CGrupo"/>    
                </tr>
            </table>  

            <table  style="margin-left:10px">

                <tr>
                    <td><label>Sala:</label></td>
                    <!--<td><input type="text" id="sala" size="5" class="text ui-widget-content ui-corner-all height font12"/></td>-->
                    <td><select id="sala" size="1" class="text ui-widget-content">
                            <option value="">Seleccione</option>
                            <?php
                            do {
                                ?>
                                <option value="<?php echo $row_JRSalas['numsala'] ?>"><?php echo $row_JRSalas['numsala'] ?></option>
                                <?php
                            }
                            while ($row_JRSalas = mysql_fetch_assoc($JRSalas));
                            $rows = mysql_num_rows($JRSalas);
                            if ($rows > 0) {
                                mysql_data_seek($JRSalas, 0);
                                $row_JRSalas = mysql_fetch_assoc($JRSalas);
                            }
                            ?>
                        </select></td>
                    <td><label>Computador:</label></td>
                    <!--<td><input type="text" id="comp" size="5"  class="text ui-widget-content ui-corner-all height font12" value="" title="Introduzca el numero del computador y haga doble click dentro de la caja de texto para traer la sala" style="font-size:16px; color:#FF0000; text-align:center; font-weight:bold;"/></td>-->
                    <td><select id="comp" size="1">
                            <option value="">Seleccione</option>

                            </select></td>
                    <td><label>Hora Ingreso:</label></td>
                    <td><input type="text" id="hora" name="reloj" size="15"  class="text ui-widget-content ui-corner-all height font12" value=""/></td>       
                </tr>

            </table> 

            <table align="right">
                <tr>
                    <td><label>Reasignar computador</label></td>
                    <td><input id="Reasigcomp"  type="checkbox" title="Asigna un nuevo computador al usuario"/></td>
                </tr>
                <tr>
                    <td><label>Salida Temporal</label></td>
                    <td><input  id="SalTemp" type="checkbox" title="Termina temporalmente una actividad  y se asigna una nueva actividad a realizar "/></td>
                </tr>
                <tr>
                    <td><label>Reingreso</label></td>
                    <td><input id="Reingreso" type="checkbox" title="Retorna nuevamente a la actividad que estaba realizando el usuario antes de salir"/></td>
                </tr>
            </table>
            <input type="hidden" id="codA"/>


            <table class="tableUI" border="1" id="detalleasignatura" cellspacing="0" width="400" style="margin-top:10px; margin-bottom:10px; margin-left:10px;">
                <thead>
                    <th>Codigo</th>
                    <th>Grupo</th>
                    <th>Asignatura</th>
                </thead>  
            </table>
        </div>

        <div id="alertas"></div>
        </form>

        <div id="accordion" style="width:550px; min-height:0px; max-height:300px; background-color:#F8F8F8; background-repeat:repeat-y;">
            <h3><a href="#">Prestamos</a></h3>
            <div>

                <table>
                    <tr>
                        <td><label>Grupo:</label></td>
                        <td><select id="grupo" size="1">
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
                    </tr>

                    <tr>
                        <td><label>SubGrupo:</label></td>
                        <td><select id="subgrupo" size="1">
                                <option selected value="0">Seleccione</option>

                            </select></td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <td><label>No Inventario:</label></td>
                        <td><input type="text" id="NoInv" size="20"  class="text ui-widget-content ui-corner-all height font12"/></td>
                        <td><button type="button" id="buscarrecurso" style="font-size:11px;" title="Busca un recurso para prestamo "><img src="images/buscar1.png" style="vertical-align:middle; padding-right:4px;"/>Buscar</button></td>
                        <td><button type="button" id="eliminar" style="font-size:11px;" title="Elimina una fila de prestamos"><img src="images/delete.png" style="vertical-align:middle; padding-right:3px;"/>Eliminar</button></td>
                    </tr>
                </table> 

                <table class="tableUI"  border="1" align="left" id="detallerecursos"  cellspacing="0" width="450" style="margin-top:20px; margin-bottom:20px;">
                    <thead>
                        <th></th> 
                        <th>No Inventario</th>
                        <th>Cantidad</th>
                        <th>Detalles</th>
                    </thead>
                </table>

            </div>
            <h3><a href="#">Ingreso de Equipos Externos</a></h3>
            <div>

                <div class="text ui-widget-content ui-corner-all" style="width:470px; height:auto; font-size:12px; margin-bottom:15px;">
                    <div class="ui-state-default" style="margin-bottom:10px; text-align:center;">DETALLE EQUIPOS EXTERNOS</div>
                    <table> <tr> <td><img src="images/delete.png" id="delete" /> </td> <td> <img src="images/add2.png" id="add" /></td> </tr></table>

                    <table id="detalleequiposexternos"  cellspacing="0" width="450"   style="margin-top:10px; margin-bottom:10px;">

                        <thead>
                            <th></th> 
                            <th>Cantidad</th>
                            <th>Equipo</th>
                            <th>Detalles</th>
                        </thead>
                    </table>
                </div> 

            </div>	
        </div>


        <div id="detallereserva" class="text ui-widget-content ui-corner-all" style="width:600px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y; margin-bottom:10px; margin-top:10px;"><div style="float:right" id="closerec" title="Cerrar ventana"><img src="images/close1.png"/></div>

            <div class="ui-state-default" style="margin-bottom:10px; text-align:center;">DETALLE RESERVA EVENTUAL</div>

            <table style="margin-left:10px;">
                <tr>
                    <td><label>No reserva:</label></td>
                    <td><input type="text" id="numreserva" class="text ui-widget-content ui-corner-all height font12" size="25" style="font-size:12px; color:#FF0000;  font-weight:bold;"/></td>
                </tr>

                <tr>
                    <td><label>Reserva internet:</label></td>
                    <td><input type="text" id="resinternet" class="text ui-widget-content ui-corner-all height font12" size="5" style="font-size:14px; color:#FF0000;  font-weight:bold;"/></td>
                </tr>

            </table>

            <div id="recursosreservados" style="margin:10px 10px 10px 10px"></div>

        </div>


        <div id="monitor">

            <div class="text ui-widget-content ui-corner-all" style="width:600px; height:auto; font-size:12px; margin-bottom:10px; margin-top:10px;"><div style="float:right" id="closemonitor" title="Cerrar ventana"><img src="images/close1.png"/></div>
                <div class="ui-state-default" style="margin-bottom:10px; text-align:center;">INGRESO MONITOR - CLASE EVENTUAL - REUNION</div>

                <table style="margin-left:15px;">

                    <tr>
                        <td><label>Codigo:</label></td>
                        <td><input type="text" id="MCodigo" size="15"  class="text ui-widget-content ui-corner-all"/></td>
                        <td><label>Grupo:</label></td>
                        <td><input type="text" id="MGrupo" size="3"  class="text ui-widget-content ui-corner-all" value=""/></td>  
                        <td><label>Asignatura:</label></td>
                        <td><input type="text" id="MAsignatura" size="40"  class="text ui-widget-content ui-corner-all" value=""/></td>       

                    </tr>
                </table>

                <table style="margin-left:15px;">   
                    <tr>
                        <td><button type="button" id="IngresoMonitor" style="font-size:11px; margin-top:5px; margin-bottom:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Ingresar</button>         </td>
                    </tr> 
                </table>    
            </div>    

        </div>

        <table>

            <tr>
                <td><button type="button" id="enviar" style="font-size:11px; margin-top:5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button></td>
                <td><button type="button" id="abrirPop" style="font-size:11px; margin-top:5px;"><img src="images/mycomputer.png" style="vertical-align:middle; padding-right:4px;"/>Estado Pcs</button> 
                </td>
                <td><button type="button" id="PEExtemporaneo" style="font-size:11px; margin-top:5px;" title="Realiza un prestamo o ingreso de un equipo despues de que el usuario ha ingresado al piso">Prestamo e ingreso de equipos </button></td>
            </tr>

        </table> 


        <!-- Div que conformaran el popup--> 

        <div id="capaPopUp"></div>
        <div id="popUpDiv">
            <img src="images/close.png" title="Cerrar" id="cerrar" style=" float:right; margin-bottom:5px;"/>
            <div  style=" min-width:0; max-width:300px; max-height:300px; min-height:0px; overflow: auto; visibility: visible;"></div>
            <div id="capaContent">
                <div>

                </div>
            </div>
        </div>  
        </div>


        <div id="wrapper"></div><!-- #wrapper 
   </body>
</html>
        <?php
        mysql_free_result($JRRecursos);
        mysql_free_result($JRActividad);
        ?>
