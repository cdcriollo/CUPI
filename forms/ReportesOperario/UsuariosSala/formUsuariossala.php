<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin título</title>

        <script type="text/javascript">

            $(function () {

                $("#tabs").tabs();



                $("#searchString").keydown(function (event) {

                    if (event.keyCode == '13')
                    {
                        event.preventDefault();
                        BusquedaUsuarioAvanzada();
                    }// cierro event.KeyCode

                });


                /*$("#sala").multiselect({
                 selectedList: 5
         
                 }) */



                function BusquedaUsuarioAvanzada()
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
                        beforeValidation: function ()
                        {

                            // parametros de busqueda
                            cadena = $("#searchString").val();
                            campobusqueda = $("#searchField").val();
                            parametro = $("#searchOper").val();

                            // se hace una llamada ajax a la url especificada	
                            $.ajax({
                                type: 'POST',
                                url: 'consultas/Usuarios_Sala/buscarUsuariosSala.php',
                                data: 'searchString=' + cadena + '&searchField=' + campobusqueda + '&searchOper=' + parametro,
                                success: function (datos)
                                {
                                    // muestra el formulario con los resultados de la busqueda
                                    $("#detalleUsuarioSala").html(datos);
                                }
                            });
                        }
                    };
                    $.validation(options);
                }

                $("#enviar").button().click(function () {
                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "sala",
                                validations: {
                                    required: [true, "El campo sala no puede estar vacio."]

                                }
                            }
                        ],
                        beforeValidation: function ()
                        {

                            // parametros de busqueda
                            var sala = $("#sala").val();

                            // se hace una llamada ajax a la url especificada	
                            $.ajax({
                                type: 'POST',
                                url: 'consultas/Usuarios_Sala/consultaxsala.php',
                                data: 'sala=' + sala+'&check='+0,
                                success: function (datos)
                                {
                                    // muestra el formulario con los resultados de la busqueda
                                    $("#detalleConsultaxSala").html(datos);
                                }
                            });
                        }
                    };
                    $.validation(options);


                });



            });// cierro function

        </script>

    </head>

    <body>

        <p id="validateErrors"></p>
        <div id="tabs" style="width:750px; min-height:0px; max-height:auto;">
            <ul>
                <li><a href="#UsuarioSala">Usuario</a></li>
                <li><a href="#ConsultaxSala">Sala</a></li>

            </ul>


            <div id="UsuarioSala"> 


                <div id="busquedaavanzusu" class="text ui-widget-content ui-corner-all" style="width:680px; min-height:80px; max-height:250px; margin-top:20px;">
                    <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">BUSQUEDA USUARIO SALITAS</div>

                    <table style="margin-left:15px;">
                        <tr>
                            <td><label>Buscar Por:</label></td>
                            <td>
                                <select size="1" id="searchField">
                                    <option value="codUsuario">Codigo</option>
                                    <option value="nombreUsu">Nombre</option> 
                                </select>
                            </td>

                            <td>
                                <select size="1" id="searchOper">
                                    <option value="eq">Igual</option>
                                    <option value="bw">Empiece por</option>
                                    <option value="ew">Termina por</option>
                                    <option value="cn">Contiene</option>
                                </select>

                            </td>


                            <td><input type="text" id="searchString" size="20" class="text ui-widget-content ui-corner-all"/></td>

                        </tr> 
                    </table>

                </div> 

                <div id="detalleUsuarioSala" style="overflow:auto; width:680px; min-height:0px; max-height:300px;"> </div>

            </div><!-- cierro div Adicusuario-->


            <div id="ConsultaxSala">

                <div id="" class="text ui-widget-content ui-corner-all" style="width:680px; min-height:80px; max-height:250px; margin-top:20px;">
                    <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CONSULTA POR SALA</div>

                    <table style="margin-left:15px;">
                        <tr>
                            <td><label>Sala:</label></td>
                            <td><select size="1" class="text ui-widget-content ui-corner-all" id="sala">
                                    <option value="">Seleccione una sala</option>     
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                </select>
                            </td>
                            <td>
                                <td><button type="button" id="enviar"  style="font-size:11px; margin-bottom:10px; margin-top:10px;"> <img src="images/aceptar.png"  style="vertical-align:middle; padding-right:3px"/>Aceptar</button></td>  
                            </td>

                        </tr> 
                    </table>

                </div> 

                <div id="detalleConsultaxSala" style="overflow:auto; width:680px; min-height:0px; max-height:300px;"> </div>

            </div><!-- cierro div Adicusuario-->

        </div> <!-- cierro div tabs-->   

        <div id="alertas"></div>

    </body>
</html>
