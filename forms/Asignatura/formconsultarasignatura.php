
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cupi-Control Utilizacion Piso Informatico</title>

        <script type="text/javascript">
            $(function () {


                $('#nomAsig').attr('disabled', 'disabled');
                $('#actividad').attr('disabled', 'disabled');
                $("#codAsig").focus();
                $("#busquedaavanzasig").hide();


                function Traerhorarios(codigo, grupo) {

                    $.ajax({
                        type: 'POST',
                        url: 'consultas/Asignatura/consultarHorarios.php',
                        data: 'asignatura=' + codigo + '&grupo=' + grupo,
                        success: function (datos)
                        {
                            $("#Mostrarhorarios").html(datos);

                        }
                    });
                }


                $("#grupo").keydown(function (event) {
                    //SI DA ENTER SE HACE LO SIGUIENTE
                    if (event.keyCode == '13')
                    {
                        event.preventDefault();
                        consultarAsignatura();

                    }
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


                $('#aceptar').button().click(function () {

                    consultarAsignatura();

                });

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


                function consultarAsignatura() {

                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "codAsig",
                                validations:
                                        {
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
                            opcion = 1;

                            $.ajax({
                                type: 'POST',
                                url: 'consultas/Asignatura/consultarAsignatura.php',
                                data: 'codigo=' + codigo + '&grupo=' + grupo + '&opcion=' + opcion,
                                success: function (datos) {


                                    if (datos != 0)
                                    {

                                        // separo los datos enviados en un array de posiciones		
                                        datosasig = datos.split('-');
                                        nombre = datosasig[1];
                                        actividad = datosasig[2];

                                        // habilito los campos del formulario

                                        $('#nomAsig').attr('disabled', '');
                                        $('#actividad').attr('disabled', '');

                                        // le doy valor a cada uno de los campos
                                        $('#nomAsig').val(nombre);
                                        $('#actividad').val(actividad);
                                        Traerhorarios(codigo, grupo);

                                    } else
                                    {
                                        alertas("Por favor verifique que la asignatura y el grupo existen", "Consultar Asignatura", "error");
                                    }
                                }
                            });
                        }
                    };
                    $.validation(options);
                }

                $("#limpiarform").button().click(function () {
                    $("#codAsig").val("");
                    $("#nomAsig").val("");
                    $("#grupo").val("");
                    $("#actividad").val("");
                    $("#searchString").val("");
                    $("#busquedaavanzasig").hide();
                    $("#mostrarbusqueda").empty();
                    $("#Mostrarhorarios").empty();
                    $("#codAsig").focus();

                });
                
                $("#limpiarformBA").button().click(function () {
                    
                  $("#searchString").val("");
                  $("#searchString").focus();
                  $("#mostrarbusqueda").empty();
                 
                    
                });

            }); // cierra  el jquery


        </script>


    </head>

    <body>

        <p id="validateErrors"></p>

        <div id="formasignatura" class="text ui-widget-content ui-corner-all" style="width:90%;  height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
            <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CONSULTAR ASIGNATURA</div>

            <table style="margin-left:15px;">
                <tr>
                    <td ><label>Codigo:</label ></td>
                    <td><input type="text" name="codAsig" id="codAsig" size="15" class="text ui-widget-content ui-corner-all height font12" value="" /></td>
                    <td><label>Grupo:</label></td>
                    <td><input type="text" name="grupo" id="grupo" size="3"  class="text ui-widget-content ui-corner-all height font12" value="" title="presione enter dentro del cajon de texto para traer la consulta"/></td>
                </tr>

                <tr>    
                    <td><label>Nombre:</label></td>
                    <td><input type="text" name="nomAsig" id="nomAsig" size="45" class="text ui-widget-content ui-corner-all height font12" value=""/></td>

                    <td><label>Actividad:</label></td>
                    <td>
                        <input type="text" name="actividad"   size="30"  class="text ui-widget-content ui-corner-all height font12" id="actividad" value=""/>
                    </td>  
                </tr>
            </table>

            <table style="margin-left:15px;">
                <tr>
                    <td><button type="button" id="aceptar" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/aceptar.png" style=" vertical-align:middle; padding-right:4px;"/>Aceptar </button></td>
                    <td> <button type="button" id="BusquedaA" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/buscar1.png" style="vertical-align:middle; padding-right:4px;"/>Busqueda Avanzada</button> </td>
                    <td>
                        <button type="button" id="limpiarform" style="font-size:11px; margin-top:10px; margin-bottom:10px;"><img src="images/broom.png" style="vertical-align:middle;            padding-right:4px;"/> Limpiar</button>
                    </td>

                </tr>
            </table>


        </div>



        <div id="Mostrarhorarios" style="margin-top:20px;">


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


        </div>

        <div id="alertas"></div>
    </body>
</html>