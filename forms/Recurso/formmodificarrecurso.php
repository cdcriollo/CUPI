
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin título</title>



        <script type="text/javascript">
            $(function () {



                $('#novdep').hide();
                $('#fecord').hide();
                $('#Robs').hide();

                $('#nombrebien').attr('disabled', 'disabled');
                $('#descripcionTipo').attr('disabled', 'disabled');
                $('#estado').attr('disabled', 'disabled');
                $('#cantidad').attr('disabled', 'disabled');
                $('#marca').attr('disabled', 'disabled');
                $('#serial').attr('disabled', 'disabled');
                $('#caracteristicas').attr('disabled', 'disabled');
                $('#descripcionSubtipo').attr('disabled', 'disabled');
                $('#instaladoS').attr('disabled', 'disabled');
                $('#instaladoC').attr('disabled', 'disabled');

                $.datepicker.setDefaults($.datepicker.regional['es']);
                $('#fechatramite').datepicker();
                $('#fechatramite').datepicker("option", "defaultDate", +7);
                $('#fechatramite').datepicker("option", "dateFormat", 'yy-mm-dd');

                $('#fecharecibo').datepicker();
                $('#fecharecibo').datepicker("option", "defaultDate", +7);
                $('#fecharecibo').datepicker("option", "dateFormat", 'yy-mm-dd');


                $("#estado").change(function () {

                    var id = $("#estado").find(':selected').val();
                    if (id == "Inactivo") {

                        $('#novdep').show();
                        $('#fecord').show();
                        $('#Robs').show();

                    }


                });

                $("#NoInventario").keydown(function (event) {

                    if (event.keyCode == '13') {

                        event.preventDefault();
                        inventario = $('#NoInventario').val();
                        BuscarRecurso(inventario);

                    }

                });


                function obtenerDependencia() {

                    //$getJSON("URL",CADENA DE DATOS O PARAMETROS,FUNCION CALLBACK);
                    $.getJSON('consultas/Dependencias/consultardependencia.php', function (data) {
                        //DATA ES EL JSON, LA VARIABLE i es el IDENTIFICADOR o KEY foo bar y baz Y LA VARIABLE item es el array, valores o valor que tiene ese identificador
                        $.each(data, function (key, item) {
                            size = item.length;
                            var cadena = new Array();
                            for (i = 0; i < size; i++) {
                                valor = item[i];
                                cadena[i] = valor;


                            }
                            arraycadena(cadena);

                        }); //each



                    });// Getjson


                }


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



                $("#limpiarform").button().click(function () {


                    $("#nombrebien").val("");
                    $("#descripcionTipo").val("");
                    $("#descripcionSubtipo").val("");
                    $("#cantidad").val("");
                    $("#marca").val("");
                    $("#serial").val("");
                    $("#estado").val("");
                    $("#caracteristicas").val("");
                    $("#instaladoS").val("");
                    $("#instaladoC").val("");
                    $("#llave").val("");
                    $("#tipo").val("");
                    $("#licencia").val("");
                    $("#idioma").val("");
                    $("#factura").val("");
                    $("#proveedor").val("");
                    $("#valor").val("");
                    $("#fecharecibo").val("");
                    $("#version").val("");
                    $("#NoInventario").val("");
                    $("#NoInventario").focus();

                });


                function BuscarRecurso(inventario)

                {

                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "NoInventario",
                                validations: {
                                    required: [true, "El campo No Inventario no puede estar vacio."],
                                }
                            }
                   ],
                        beforeValidation: function () {



                            $.ajax({
                                type: 'POST',
                                url: 'consultas/Recurso/consultarrecurso.php',
                                data: 'inventario=' + inventario,
                                success: function (datos) {

                                    if (datos != 0) {
                                        datosrecursos = datos.split('*');

                                        $('#nombrebien').attr('disabled', '');
                                        $('#descripcionTipo').attr('disabled', '');
                                        $('#estado').attr('disabled', '');
                                        $('#cantidad').attr('disabled', '');
                                        $('#marca').attr('disabled', '');
                                        $('#serial').attr('disabled', '');
                                        $('#caracteristicas').attr('disabled', '');
                                        $('#descripcionSubtipo').attr('disabled', '');
                                        $('#instaladoS').attr('disabled', '');
                                        $('#instaladoC').attr('disabled', '');
                                        $('#nombrebien').val(datosrecursos[0]);
                                        $('#descripcionTipo').val(datosrecursos[1]);
                                        $('#descripcionSubtipo').val(datosrecursos[2]);
                                        $('#estado').val(datosrecursos[3]);
                                        $('#cantidad').val(datosrecursos[4]);
                                        $('#marca').val(datosrecursos[5]);
                                        $('#serial').val(datosrecursos[6]);
                                        $('#caracteristicas').val(datosrecursos[7]);
                                        $('#instaladoS').val(datosrecursos[8]);
                                        $('#instaladoC').val(datosrecursos[9]);
                                        $('#de').val(datosrecursos[10]);
                                        $('#llave').val(datosrecursos[16]);
                                        $('#tipo').val(datosrecursos[17]);
                                        $('#licencia').val(datosrecursos[18]);
                                        $('#factura').val(datosrecursos[19]);
                                        $('#idioma').val(datosrecursos[20]);
                                        $('#proveedor').val(datosrecursos[21]);
                                        $('#valor').val(datosrecursos[22]);
                                        $('#fecharecibo').val(datosrecursos[23]);
                                        $('#version').val(datosrecursos[24]);

                                        if ($("#estado").val() == "Inactivo")
                                        {
                                            $('#novedades').val(datosrecursos[12]);
                                            $('#dependencia').val(datosrecursos[14]);
                                            $('#obs').val(datosrecursos[11]);
                                            $('#fechatramite').val(datosrecursos[13]);
                                            $('#ordenNo').val(datosrecursos[15]);

                                            $("#novdep").show();
                                            $("#fecord").show();
                                            $("#Robs").show();
                                        } else
                                        {
                                            $("#novdep").hide();
                                            $("#fecord").hide();
                                            $("#Robs").hide();
                                        }


                                    } else
                                    {
                                        alertas("El Recurso no existe", "Modificar Recurso", "error");
                                    }
                                }
                            });
                        }
                    };
                    $.validation(options);
                }


                $('#enviar').button().click(function () {


                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "NoInventario",
                                validations: {
                                    required: [true, "El campo No Inventario no puede estar vacio."],
                                    number: [true, "El  campo No Inventario debe contener numeros ."]


                                }
                            },
                            {
                                id: "dependencia",
                                validations: {
                                    required: [true, "El campo Dependencia no puede estar vacio."],
                                }
                            },
                            {
                                id: "fechatramite",
                                validations: {
                                    required: [true, "El campo Fecha Tramite no puede estar vacio."],
                                }
                            },
                            {
                                id: "ordenNo",
                                validations: {
                                    required: [true, "El campo Orden No no puede estar vacio."],
                                    number: [true, "El  campo  Orden No debe contener numeros ."]


                                }
                            }
                   ],
                        beforeValidation: function () {

                            novedades = $("#novedades").val();
                            dependencia = $("#dependencia").val();
                            fechatramite = $("#fechatramite").val();
                            orden = $("#ordenNo").val();
                            observaciones = $("#obs").val();


                            $.ajax({
                                type: 'POST',
                                url: 'funciones/Recurso/ActualizarEstadoRecurso.php',
                                data: 'inventario=' + inventario + '&novedades=' + novedades + '&dependencia=' + dependencia + '&fechatramite=' + fechatramite + '&orden=' + orden + '&observaciones=' + observaciones,
                                success: function (datos) {

                                    if (datos == 1) {


                                        alertas(" El recurso se ha modificado exitosamente", "Modificar Recurso", "done");
                                        //limpiar_formulario_elementos(); 
                                    } else {

                                        alertas(" Ha ocurrido un error", "Modificar Recurso", "error");

                                    }
                                }
                            });
                        }
                    };
                    $.validation(options);
                });




                $("#dependencia").mouseenter(function () {
                    obtenerDependencia();
                });


                function arraycadena(cadena) {
                    $("#dependencia").autocomplete({
                        source: cadena

                    });
                }

                $("#modificar").button().click(function () {

                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "NoInventario",
                                validations: {
                                    required: [true, "El campo No Inventario no puede estar vacio."],
                                    number: [true, "El  campo No Inventario debe contener numeros ."]


                                }
                            }
                   ],
                        beforeValidation: function () {

                            Noinventario = $("#NoInventario").val();
                            nombrebien = $("#nombrebien").val();
                            grupo = $("#descripcionTipo").val();
                            subgrupo = $("#descripcionSubtipo").val();
                            cantidad = $("#cantidad").val();
                            marca = $("#marca").val();
                            serial = $("#serial").val();
                            estado = $("#estado").val();
                            caracteristicas = $("#caracteristicas").val();
                            instaladosala = $("#instaladoS").val();
                            instaladopc = $("#instaladoC").val();
                            llave = $("#llave").val();
                            tipo = $("#tipo").val();
                            licencia = $("#licencia").val();
                            idioma = $("#idioma").val();
                            factura = $("#factura").val();
                            proveedor = $("#proveedor").val();
                            valor = $("#valor").val();
                            fecharecibo = $("#fecharecibo").val();
                            version = $("#version").val();

                            if (instaladosala != "" || instaladopc != "")
                            {
                                estadoPrestamo = "No disponible";
                            } else if (instaladosala == "" && instaladopc == "")
                            {
                                estadoPrestamo = "disponible";
                            }


                            $.ajax({
                                type: 'POST',
                                url: 'funciones/Recurso/actualizarrecurso.php',
                                data: 'inventario=' + Noinventario +'&estado='+estado+ '&grupo=' + grupo + '&cantidad=' + cantidad + '&marca=' + marca + '&serial=' + serial + '&estado=' + estado + '&caracteristicas=' + caracteristicas + '&instaladosala=' + instaladosala + '&instaladopc=' + instaladopc + '&nombre=' + nombrebien + '&subgrupo=' + subgrupo + '&llave=' + llave + '&Tipo=' + tipo + '&Licencia=' + licencia + '&Idioma=' + idioma + '&Factura=' + factura + '&Proveedor=' + proveedor + '&Valor=' + valor + '&Fecharecibo=' + fecharecibo + '&Version=' + version + '&estadoPrestamo=' + estadoPrestamo + '&idInventario=' + inventario,
                                success: function (datos) {

                                    if (datos == 1)
                                    {
                                        alertas("Los datos se han actualizado correctamente", "Modificar Recurso", "done");
                                    } else if (datos == 0)
                                    {
                                        alertas("No se actualizo la informacion del recurso", "Modificar Recurso", "error");
                                    }
                                }
                            });
                        }
                    };
                    $.validation(options);
                });

                $("#estado").change(function () {

                    estadorecurso = $("#estado option:selected").val();
                    if (estadorecurso == "Inactivo") {

                        $('#novedades').val(datosrecursos[12]);
                        $('#dependencia').val(datosrecursos[14]);
                        $('#obs').val(datosrecursos[11]);
                        $('#fechatramite').val(datosrecursos[13]);
                        $('#ordenNo').val(datosrecursos[15]);

                        $("#novdep").show();
                        $("#fecord").show();
                        $("#Robs").show();
                    } else
                    {
                        $("#novdep").hide();
                        $("#fecord").hide();
                        $("#Robs").hide();
                    }

                });

            }); // cierra el function
        </script>


    </head>

    <body>


        <p id="validateErrors"></p>

        <div class="text ui-widget-content ui-corner-all" style="width:580px; margin-bottom:15px; height:auto; font-size:12px;">
            <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">MODIFICAR RECURSO</div>       
            <table style="margin-left:15px;">

                <tr>
                    <td><label>No Inventario:</label></td>
                    <td><input type="text" name="NoInventario" id="NoInventario" size="20" maxlength="128" title="Escriba el No de inventario del recurso y de enter enter dentro del cajon de texto para traer la informacion correspondiente del recurso"   class="text ui-widget-content ui-corner-all" /></td>    
                </tr>
            </table>

            <table style="margin-left:15px;">   
                <tr>

                    <td><label>Nombre del bien:</label></td>
                    <td><input type="text" name="nombrebien" id="nombrebien" size="45" class="text ui-widget-content ui-corner-all" />
                    </td>
                </tr>
            </table>   


            <table  style="margin-left:15px;">
                <tr> 
                    <td><label>Grupo:</label></td>
                    <td><input type="text" name="descripcionTipo" id="descripcionTipo" size="20" class="text ui-widget-content ui-corner-all" /></td>

                    <td><label>subGrupo:</label></td>
                    <td><input type="text" name="descripcionSubtipo" id="descripcionSubtipo" size="20" class="text ui-widget-content ui-corner-all"/></td>

                </tr>

            </table>

            <table  style="margin-left:15px;">
                <tr>
                    <td><label>Cantidad:</label></td>
                    <td><input type="text" name="cantidad" id="cantidad" size="5" maxlength="128"   class="text ui-widget-content ui-corner-all"/>
                    </td>
                    <td><label>De:</label></td>
                    <td><input type="text" name="de" id="de" size="5" maxlength="128" class="text ui-widget-content ui-corner-all"/>
                    </td>
                    <td><label>Marca:</label></td>
                    <td><input type="text" name="marca" id="marca" size="20"  class="text ui-widget-content ui-corner-all"  />
                    </td>
                </tr>

            </table>

            <table  style="margin-left:15px;">
                <tr>
                    <td><label>Serial</label></td>
                    <td><input type="text" name="de" id="serial" size="20" class="text ui-widget-content ui-corner-all"/>
                    </td>
                    <td><label>Estado:</label></td>
                    <td><select name="estado" id="estado" size="1">
                            <option value="Activo" >Activo</option>
                            <option value="Inactivo">Inactivo</option>
                            <option value="Disponible">Disponible</option>
                            <option value="Ocupado">Ocupado</option>
                            <option value="Dañado">Dañado</option>
                            <option value="En mantenimiento">En mantenimiento</option>
                            <option value="Uso administrativo">Uso administrativo</option>
                            <option value="Baja" >Baja</option>
                        </select>
                    </td>
                </tr>
            </table>

            <table  style="margin-left:15px;">
                <tr>
                    <td><label>Caracteristicas:</label></td>
                    <td><textarea name="caracteristicas" cols="45" rows="3" id="caracteristicas" class="text ui-widget-content ui-corner-all" ></textarea>
                    </td>
                </tr>

            </table>
            <table  style="margin-left:15px;">
                <td><label>Instalado en la sala:</label></td>
                <td><input type="text" name="cantidad" id="instaladoS" size="5" class="text ui-widget-content ui-corner-all"/>
                </td>
                <td><label>Instalado en el computador:</label></td>
                <td><input type="text" name="de" id="instaladoC" size="5" class="text ui-widget-content ui-corner-all"/>
                </td>
            </table>

            <table  style="margin-left:15px;">
                <tr>
                    <td><label>Key:</label></td>
                    <td><input type="text" class="text ui-widget-content ui-corner-all" id="llave" size="20"/>
                    </td>
                    <td><label>Tipo:</label></td>
                    <td><input type="text" class="text ui-widget-content ui-corner-all" id="tipo" size="15"/>
                    </td>
                    <td><label>Licencia:</label></td>
                    <td><input type="text" class="text ui-widget-content ui-corner-all" id="licencia" size="25"/>
                    </td>
                </tr>
            </table>

            <table style="margin-left:15px;">
                <tr>
                    <td><label>Idioma:</label></td>
                    <td><select size="1" class="text ui-widget-content ui-corner-all" id="idioma">
                            <option value="Español">Español</option>
                            <option value="Ingles">Ingles</option>
                        </select>
                    </td>
                    <td><label>Factura No:</label></td>
                    <td><input type="text" class="text ui-widget-content ui-corner-all" id="factura" size="20"/></td>
                    <td><label>Proveedor:</label></td>
                    <td><input type="text" class="text ui-widget-content ui-corner-all" id="proveedor" size="20"/></td>
                </tr>
            </table>

            <table style="margin-left:15px;">
                <tr>
                    <td><label>valor:</label></td>
                    <td><input type="text" class="text ui-widget-content ui-corner-all" id="valor" size="15"/>
                    </td>
                    <td><label>Fecha Recibo:</label></td>
                    <td><input type="text" class="text ui-widget-content ui-corner-all" id="fecharecibo" size="15"/></td>
                    <td><label>Version:</label></td>
                    <td><input type="text" class="text ui-widget-content ui-corner-all" id="version" size="15"/></td>
                </tr>
            </table>

            <table  style="margin-left:15px;">
                <tr id="novdep" >
                    <td><label>Novedades:</label></td>
                    <td>
                        <select name="novedades" size="1" id="novedades">
                            <option value="Baja">Baja</option>
                            <option value="Prestamo">Prestamo</option>
                            <option value="Retiro">Retiro</option>
                            <option value="Traslado">Traslado</option>
                        </select>
                    </td>
                    <td><label>Dependencia:</label></td>
                    <td><input type="text" name="dependencia" id="dependencia" size="20" class="text ui-widget-content ui-corner-all" title="Digite alguna letra dentro del cajon de texto para traer la lista de dependencias"/>
                    </td>
                </tr>

                <tr id="fecord">
                    <td><label>Fecha de Tramite:</label></td>
                    <td><input type="text" name="fechatramite" id="fechatramite" size="20" class="text ui-widget-content ui-corner-all" title="De click dentro del cajon de texto para traer la fecha"/>
                    </td>
                    <td><label>Orden No:</label></td>
                    <td><input type="text" name="ordenNo" id="ordenNo" size="20" class="text ui-widget-content ui-corner-all"/>
                    </td>
                </tr>

                <table  style="margin-left:15px;">
                    <tr id="Robs">  
                        <td><label>Observaciones:</label></td>
                        <td><textarea id="obs" cols="45" rows="3" class="text ui-widget-content ui-corner-all"></textarea>  </td>
                    </tr>
                </table>
            </table>

            <table style="margin-left:15px;"> 
                <tr>
                    <td><button type="button" id="enviar" style=" margin-bottom:10px; margin-top:10px; font-size:11px;" title="Cambia el estado de un recurso cuando este ha sido dado de baja, trasladado, prestado o retirado del piso, para utilizar esta opcion seleccione en estado inactivo para que se desplieguen los campos correspondientes"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Cambiar Estado Recurso</button></td>
                    <td><button type="button" id="modificar" style="margin-bottom:10px; margin-top:10px; font-size:11px;" title="Modifica la informacion de un recurso en especifico"><img src="images/edit1.png" style="vertical-align:middle; padding-right:4px;"/>Modificar</button>      </td>
                    <td><button type="button" id="limpiarform" style="margin-bottom:10px; margin-top:10px; font-size:11px; " title="Limpia el formulario"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/>       Limpiar</button></td>
                </tr>
            </table>

        </div>

        <div id="alertas"></div>	

    </body>
</html>

