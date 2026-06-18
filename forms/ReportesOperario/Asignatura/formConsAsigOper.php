<html>
    <head>
        <script type="text/javascript">

            $(function () {


                $('#nomAsig').attr('disabled', 'disabled');
                $('#actividad').attr('disabled', 'disabled');
                $("#busquedaavanzasig").hide();


                function DetalleAsignaturas(codigo, grupo) {

                    $.ajax({
                        type: 'POST',
                        url: 'consultas/Matricula/consultarmatriculaA.php',
                        data: 'codigo=' + codigo + '&grupo=' + grupo,
                        success: function (datos) {

                            $("#Mostrardetalle").html(datos);
                            $("#Mostrardetalle").show();

                        }
                    });
                }

                function DetalleHorarios(codigo, grupo)
                {
                    $.ajax({
                        type: 'POST',
                        url: 'consultas/Asignatura/consultarHorarios.php',
                        data: 'asignatura=' + codigo + '&grupo=' + grupo,
                        success: function (datos) {

                            $("#mostrarDetalleHorario").html(datos);
                            $("#mostrarDetalleHorario").show();

                        }
                    });
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


                $("#grupo").keydown(function (event) {
                    //SI DA ENTER SE HACE LO SIGUIENTE
                    if (event.keyCode == '13') {

                        event.preventDefault();
                        consultarMatriculaAsignatura()

                    }

                });
                
                $("#limpiarform").button().click(function () {
                    
                  $("#codAsig").val("");
                  $("#grupo").val("");
                  $("#nomAsig").val("");
                  $("#actividad").val("");
                    
                });
                
                $("#limpiarformBA").button().click(function () {
                    
                  $("#searchString").val("");
                  $("#searchString").focus();
                  $("#mostrarbusqueda").empty();
                 
                    
                });

                function descripcionDia(diasemana)
                {
                    if (diasemana == 1)
                    {
                        descripcion = "Lunes";
                    } else if (diasemana == 2)
                    {
                        descripcion = "Martes";
                    } else if (diasemana == 3)
                    {
                        descripcion = "Miercoles";
                    } else if (diasemana == 4)
                    {
                        descripcion = "Jueves";
                    } else if (diasemana == 5)
                    {
                        descripcion = "Viernes";
                    } else if (diasemana == 6)
                    {
                        descripcion = "Sabado";
                    }

                    return descripcion;
                }

                $('#aceptar').button().click(function () {

                    consultarMatriculaAsignatura();
                });

                function consultarMatriculaAsignatura()
                {

                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "codAsig",
                                validations: {
                                    required: [true, "El campo Codigo no puede estar vacio."],
                                }
                            }
                            ,
                            {
                                id: "grupo",
                                validations: {
                                    required: [true, "El campo Grupo no puede estar vacio."],
                                    number: [true, "El campo Grupo debe contener numeros."]
                                }
                            }

                        ],
                        beforeValidation: function () {


                            codigo = $('#codAsig').val();
                            grupo = $("#grupo").val();

                            $.ajax({
                                type: 'POST',
                                url: 'consultas/Asignatura/consultarAsignaturaOper.php',
                                data: 'codigo=' + codigo + '&grupo=' + grupo,
                                success: function (datos) {


                                    if (datos != 0) {



                                        // separo los datos enviados en un array de posiciones		
                                        datosasig = datos.split(',');
                                        nombre = datosasig[0];
                                        actividad = datosasig[1];

                                        // habilito los campos del formulario
                                        $('#nomAsig').attr('disabled', '');
                                        $('#actividad').attr('disabled', '');

                                        // le doy valor a cada uno de los campos
                                        $('#nomAsig').val(nombre);
                                        $("#actividad").val(actividad);
                                        DetalleHorarios(codigo, grupo)
                                        DetalleAsignaturas(codigo, grupo);

                                    } else
                                    {
                                        $("#mostrarDetalleHorario").hide();
                                        $("#Mostrardetalle").hide();
                                        alertas("Por favor verifique que el codigo y el grupo estan correctos o que la asignatura exista", "Consulta por Asignatura", "error");

                                    }
                                }
                            });
                        }
                    };
                    $.validation(options);
                }

                // muestra o esconde el formulario de busqueda avanzada
                $("#BusquedaA").button().toggle(function () {
                    $('#busquedaavanzasig').show("slide");
                    $("#searchString").focus();
                }, function () {
                    $("#busquedaavanzasig").hide("slide");
                    $("#mostrarbusqueda").empty();
                });


                $("#Buscar").button().click(function () {

                    BusquedaAsignaturaAvanzada();

                });



                function BusquedaAsignaturaAvanzada()
                {

                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "searchString",
                                validations: {
                                    required: [true, "El campo de busqueda no puede estar vacio."]

                                }
                            }
                        ],
                        beforeValidation: function () {

                            cadena = $("#searchString").val();
                            campobusqueda = $("#searchField").val();
                            parametro = $("#searchOper").val();

                            $.ajax({
                                type: 'POST',
                                url: 'consultas/Asignatura/BusquedaAvanzadaAsignatura.php',
                                data: 'searchString=' + cadena + '&searchField=' + campobusqueda + '&searchOper=' + parametro,
                                success: function (datos) {

                                    $("#mostrarbusqueda").html(datos);
                                }
                            });
                        }
                    };
                    $.validation(options);
                }




                $("#searchString").keydown(function (event) {
                    //SI DA ENTER SE HACE LO SIGUIENTE
                    if (event.keyCode == '13') {
                        event.preventDefault();
                        BusquedaAsignaturaAvanzada();
                    }
                });


            }); // cierra  el jquery


        </script>


    </head>

    <body>

        <p id="validateErrors"></p>
        <div id="formasignatura" class="text ui-widget-content ui-corner-all" style="width:660px;  height:auto; font-size:12px;">
            <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CONSULTA POR ASIGNATURA</div>

            <table style="margin-left:15px;">
                <tr>
                    <td ><label style="padding-right:25px;">Codigo:</label ></td>
                    <td><input type="text" name="codAsig" id="codAsig" size="20" maxlength="128"   class="text ui-widget-content ui-corner-all"value="" /></td>
                    <td><label>Grupo:</label></td>
                    <td><input type="text" name="grupo" id="grupo" size="2" maxlength="128" title="De enter dentro del cajon de texto para realizar la consulta"  class="text ui-widget-content ui-corner-all" value=""/></td>
                </tr>

                <tr>    
                    <td><label for="nombre">Nombre:</label></td>
                    <td><input type="text" name="nomAsig" id="nomAsig" size="40" class="text ui-widget-content ui-corner-all" value=""/></td> 
                    <td><label for="nombre">Actividad:</label></td>
                    <td><input type="text"  id="actividad" size="20" class="text ui-widget-content ui-corner-all" value=""/></td>         
                </tr>
            </table>
            
            <table>
                <tr>
                    <td><button type="button" id="BusquedaA" style="font-size:11px; margin-top:10px;"><img src="images/buscar1.png" style="vertical-align:middle; padding-right:4px;"/>Busqueda Avanzada</button></td>   
                    <td><button type="button" id="limpiarform" style="font-size:11px; margin-top:10px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/>Limpiar</button></td>
                </tr>
            </table>


            <div id="mostrarDetalleHorario" style="margin-top:10px; margin-bottom:10px; margin-left:15px;">

            </div>


            <div id="Mostrardetalle" style="margin-top:10px; margin-bottom:10px;">


            </div>
            
            

        </div>

        <div id="busquedaavanzasig" class="text ui-widget-content ui-corner-all" style="width:470px; height:100px; margin-top:20px; background-color:#F8F8F8; background-repeat:repeat-y">
            <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">BUSQUEDA AVANZADA ASIGNATURA</div>

            <table style="margin-left:15px;">
                <tr>
                    <td><label>Buscar Por:</label></td>
                    <td>
                        <select size="1" id="searchField">
                            <option value="codAsignatura">Codigo</option>
                            <option value="nomAsignatura">Nombre</option> 
                            <option value="actividad">Actividad</option> 
                        </select>
                    </td>

                    <td>
                        <select size="1" id="searchOper">
                            <option value="eq">Igual</option>
                            <option value="ne">No igual a</option> 
                            <option value="bw">Empiece por</option>
                            <option value="bn">No empiece por</option> 
                            <option value="ew">Termina por</option>
                            <option value="en">No termina por</option> 
                            <option value="cn">Contiene</option>
                            <option value="nc">No contiene</option> 
                        </select>

                    </td>


                    <td><input type="text" id="searchString" size="20" class="text ui-widget-content ui-corner-all"/></td>

                </tr>

                <tr>
                    <td><button type="button" id="Buscar" style="font-size:11px;"><img src="images/buscar1.png" style="vertical-align:middle; padding-right:4px;"/>Buscar</button></td>
                    <td><button type="button" id="limpiarformBA" style="font-size:11px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/>Limpiar</button></td>              
                </tr>

            </table>

        </div> 

        <div id="mostrarbusqueda" style="margin-top:20px; margin-bottom:20px; overflow:auto; width:520px; min-height:0px; max-height:300px;">
    
        <div id="alertas"></div>
    </body>
</html>