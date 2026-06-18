
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin título</title>



        <script type="text/javascript">
            $(function () {

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
                $("#novdep").hide();
                $("#fecord").hide();
                $("#Robs").hide();


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



                $("#NoInventario").keydown(function (event) {

                    if (event.keyCode == '13') {

                        event.preventDefault();
                        Noinventario = $('#NoInventario').val();
                        consultarRecurso(Noinventario)

                    }

                });



                $('#enviar').button().click(function () {

                    inventario = $('#NoInventario').val();
                    consultarRecurso(inventario);
                });


                function consultarRecurso(inventario)
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
                                        $('#estado').val(datosrecursos[25]);
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

                                        estadorecurso = $("#estado").val();

                                        if (estadorecurso == "Inactivo") {

                                            $('#novedades').val(datosrecursos[12]);
                                            $('#dependencia').val(datosrecursos[14]);
                                            $('#obs').val(datosrecursos[11]);
                                            $('#fechatramite').val(datosrecursos[13]);
                                            $('#ordenNo').val(datosrecursos[15]);

                                            $("#novdep").show();
                                            $("#fecord").show();
                                            $("#Robs").show();
                                        } else {
                                            $("#novdep").hide();
                                            $("#fecord").hide();
                                            $("#Robs").hide();
                                        }


                                    } else {

                                        alertas("El Recurso no existe", "Consultar Recurso", "error");
                                    }
                                }
                            });
                        }
                    };
                    $.validation(options);
                }

                $("#limpiarform").button().click(function () {

                    $('#nombrebien').val("");
                    $('#descripcionTipo').val("");
                    $('#descripcionSubtipo').val("");
                    $('#estado').val("");
                    $('#cantidad').val("");
                    $('#marca').val("");
                    $('#serial').val("");
                    $('#caracteristicas').val("");
                    $('#instaladoS').val("");
                    $('#instaladoC').val("");
                    $('#de').val("");
                    $('#llave').val("");
                    $('#tipo').val("");
                    $('#licencia').val("");
                    $('#factura').val("");
                    $('#idioma').val("");
                    $('#proveedor').val("");
                    $('#valor').val("");
                    $('#fecharecibo').val("");
                    $('#version').val("");
                    $("#NoInventario").val("");
                    $("#NoInventario").focus();

                });

            }); // cierra el function
        </script>


    </head>

    <body>


        <p id="validateErrors"></p>

        <div class="text ui-widget-content ui-corner-all" style="width:80%; margin-bottom:15px; height:auto; font-size:12px;">
            <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CONSULTAR RECURSO</div>  

            <table style="margin-left:15px;">


                <tr>
                    <td><label>No Inventario:</label></td>
                    <td><input type="text" id="NoInventario" size="20"  class="text ui-widget-content ui-corner-all" title="Presione enter dentro del cajon de texto para traer la consulta"/></td>
                    <td><label>Estado:</label></td>
                    <td>
                        <input type="text" id="estado" size="30"  class="text ui-widget-content ui-corner-all"/>
                    </td>     
                </tr>
            </table>    
            <table style="margin-left:15px;">   
                <tr>

                    <td><label>Nombre del bien:</label></td>
                    <td><input type="text" name="nombrebien" id="nombrebien" class="text ui-widget-content ui-corner-all" size="40"  />
                    </td>
                </tr>
            </table>

            <table  style="margin-left:15px;">
                <tr> 
                    <td><label>Grupo:</label></td>
                    <td><input type="text" name="descripcionTipo" id="descripcionTipo" class="text ui-widget-content ui-corner-all" size="20" maxlength="128" /></td>

                    <td><label>subGrupo:</label></td>
                    <td><input type="text" name="descripcionSubtipo" id="descripcionSubtipo" class="text ui-widget-content ui-corner-all" size="20" maxlength="128"  /></td>

                </tr>

            </table>

            <table  style="margin-left:15px;">
                <tr>
                    <td><label>Cantidad:</label></td>
                    <td><input type="text" name="cantidad" id="cantidad" class="text ui-widget-content ui-corner-all" size="5" maxlength="128"   />
                    </td>
                    <td><label>De:</label></td>
                    <td><input type="text" name="de" id="de" class="text ui-widget-content ui-corner-all" size="5" maxlength="128" />
                    </td>
                    <td><label>Marca:</label></td>
                    <td><input type="text" name="marca" id="marca" class="text ui-widget-content ui-corner-all" size="20" maxlength="128"   />
                    </td>
                </tr>

            </table>

            <table  style="margin-left:15px;">
                <tr>
                    <td><label>Serial</label></td>
                    <td><input type="text" name="de" id="serial" size="20" class="text ui-widget-content ui-corner-all" maxlength="128"   />
                    </td>
                    <td><label>Estado:</label></td>
                    <td><input type="text" name="estado" id="estado" class="text ui-widget-content ui-corner-all" size="20" maxlength="128"   /></td>
                </tr>
            </table>

            <table  style="margin-left:15px;">
                <tr>
                    <td><label>Caracteristicas:</label></td>
                    <td><textarea name="caracteristicas" cols="40" class="text ui-widget-content ui-corner-all" rows="3" id="caracteristicas" ></textarea>
                    </td>
                </tr>

            </table>
            <table  style="margin-left:15px;">
                <td><label>Instalado en la sala:</label></td>
                <td><input type="text" name="cantidad" id="instaladoS" size="5" class="text ui-widget-content ui-corner-all" maxlength="128" />
                </td>
                <td><label>Instalado en el computador:</label></td>
                <td><input type="text" name="de" id="instaladoC" size="5" class="text ui-widget-content ui-corner-all" maxlength="128"/>
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
                        <input type="text" name="novedades" id="novedades" size="20" class="text ui-widget-content ui-corner-all"/>
                    </td>
                    <td><label>Dependencia:</label></td>
                    <td><input type="text" name="dependencia" id="dependencia" size="20" class="text ui-widget-content ui-corner-all"/>
                    </td>
                </tr>

                <tr id="fecord">
                    <td><label>Fecha de Tramite:</label></td>
                    <td><input type="text" name="fechatramite" id="fechatramite" size="20" class="text ui-widget-content ui-corner-all"  />
                    </td>
                    <td><label>Orden No:</label></td>
                    <td><input type="text" name="ordenNo" id="ordenNo" size="20" class="text ui-widget-content ui-corner-all"/>
                    </td>
                </tr>
            </table>

            <table  style="margin-left:15px;">
                <tr id="Robs">  
                    <td><label>Observaciones:</label></td>
                    <td><textarea id="obs" cols="45" rows="3" class="text ui-widget-content ui-corner-all"></textarea>  </td>
                </tr>
            </table>

            <tr>
                <td><button type="button" id="enviar" style="margin:15px 0 15px 15px; font-size:11px;"><img src="images/buscar1.png" style="vertical-align:middle; padding-right:4px;"/>Buscar</button></td>
                <td>
                    <button type="button" id="limpiarform" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/> Limpiar</button>
                </td>
            </tr>


        </div>
        <div id="alertas"></div>	



    </body>
</html>

