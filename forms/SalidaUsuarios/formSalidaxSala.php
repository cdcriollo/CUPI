
<?php date_default_timezone_set("America/bogota"); ?>
<?php require_once('../../Connections/conexion.php'); ?>
<?php 
 // consulta las actividades relacionadas con clase
mysql_select_db($database_conexion, $conexion);
$query_JRActividad = "SELECT idActividad, Descripcion FROM `actividades` WHERE Descripcion like 'Clase%'";
$JRActividad = mysql_query($query_JRActividad, $conexion) or die(mysql_error());
$row_JRActividad = mysql_fetch_assoc($JRActividad);
$totalRows_JRActividad = mysql_num_rows($JRActividad);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin t&iacute;tulo</title>

        <script type="text/javascript">

            $(function () {

                $(".tableUI").styleTable();
                $("#enviar").hide();
                cadenaprestamos = new Array();
                cadenaequipos = new Array();
                actualizarusuarios = new Array();
                arraypcs = new Array();
                $("#detallesalida").hide();
                $("#tabs").tabs();

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


                $("#sala").keydown(function (event)
                {

                    if (event.keyCode == '13')
                    {
                        event.preventDefault();
                        sala = $("#sala").val();
                        SalidaxSalaUsuarios(sala);
                    }
                });


                function SalidaxSalaUsuarios(sala)
                {

                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
					  id:"sala",
					  validations:
					  {
					      required:[true,"El campo sala no puede estar vacio."],
					  }
				  },
				  
				  {
					  id:"actividad",
					       validations:
						   {
					         required:[true,"El campo actividad no puede estar vacio."],
						   }				  
				  },
                            

                        ],
                        beforeValidation: function () {

                            $.ajax({
                                type: 'POST',
                                url: 'consultas/Salida/consultaasignaturasala.php',
                                data: 'sala=' + sala,
                                success: function (datos)
                                {
                                    if (datos != 0)
                                    {
                                        datossalida = datos.split('-');
                                        codigoasignatura = datossalida[0];
                                        grupoasignatura = datossalida[1];
                                        nombreasignatura = datossalida[2];

                                        $('#detalleasignatura').append('<tbody><td class="detAsignatura ui-widget-content">' + codigoasignatura + '</td><td class="detAsignatura ui-widget-content first">' + grupoasignatura + '</td><td class="detAsignatura ui-widget-content first">' + nombreasignatura + '</td></tbody>');
                                        mostrardetallesalida();
                                        $("#enviar").show();
                                    } else
                                    {
                                        alertas("La consulta no arrojo resultados ", "Salida x Sala", "error");
                                        $("tbody", "#detalleasignatura").remove();
                                        $("#detallesalida").hide();
                                        $("#salidaporsala").css({height: "200px"});
                                    }
                                }// cierro success
                            });// cierro ajax
                        }// cierro before validation
                    };
                    $.validation(options);
                }// cierro funcion



                function mostrardetallesalida()
                {
                    var sala = $("#sala").val();
                    var actividad = $("#actividad option:selected").html();
                   
                    $.ajax({
                        type: 'POST',
                        url: 'consultas/Salida/Consultarsalidaxsala.php',
                        data: 'sala=' + sala+ '&actividad='+actividad,
                        success: function (datos)
                        {
                            if (datos != "")
                            {
                                $("#detallesalida").show();
                                $("#detallesalida").html(datos);
                                $("#salidaporsala").css({height: "auto"});
                            }
                        }
                    });
                }

                $("#salida_parcial").button().click(function () {
                    var options = {
                        classerror: "ui-state-error",
                        classdone: "ui-state-highlight",
                        contentmsg: "validateErrors",
                        fields: [
                            {
                                id: "sala_parcial",
                                validations: {
                                    required: [true, "El campo sala no puede estar vacio."]

                                }
                            }
                        ],
                        beforeValidation: function ()
                        {

                            // parametros de busqueda
                            var sala = $("#sala_parcial").val();

                            // se hace una llamada ajax a la url especificada	
                            $.ajax({
                                type: 'POST',
                                url: 'consultas/Usuarios_Sala/consultaxsala.php',
                                data: 'sala=' + sala + '&check=' + 1,
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

                $("#dar_salida").button().click(function () {

                    Salida_usuarios_parcial();
                });

                function Salida_usuarios_parcial()
                {

                    Arraysalidausuarios = [];
                    Arraycomputadores = [];
                    contador_salida_usuarios = 0;


                    $("input:checked.chksalidausuarios").each(
                            function (i) {
                                valor = $(this).val();
                                datos = valor.split('-');
                                contador_salida_usuarios += 1;
                                Arraysalidausuarios[i] = datos[0];
                                Arraycomputadores[i] = datos[1];
                                //console.log(Arraysalidausuarios);
                                //console.log(Arraycomputadores);

                            });



                    if (contador_salida_usuarios > 0)
                    {

                        $.ajax({
                            type: 'POST',
                            url: 'funciones/Salida/salida_usuarios_parcial.php',
                            data: 'Arraysalidausuarios=' + Arraysalidausuarios + '&Arraycomputadores=' + Arraycomputadores,
                            // Formato de datos que se espera en la respuesta
                            dataType: "json",
                            success: function (datos)
                            {
                                var html = '<p align= center> Información salida parcial </p>';
                                html += '<p align= center> Salidas exitosas' + " " + datos.exit_usuarios + '</p>';
                                html += '<p align= center> Se actualizo' + " " + datos.prestamos_update + " " + 'prestamo(s)' + '</p>';
                                html += '<p align= center> Se actualizo' + " " + datos.pcs_update + " " + 'computador(es)' + '</p>';
                                html += '<p align= center> Se libero' + " " + datos.recursos_update + " " + 'recurso(s)' + '</p>';
                                html += '<p align= center> Se dio salida a' + " " + datos.equipos_update + " " + 'equipo(s) externos' + '</p>';
                                $("#alertas").css({height: "300px", width: '250px'});
                                alertas(html, "Salida parcial usuarios", "done");
                            }

                        });
                    } else
                    {
                        alertas("Por favor seleccione al menos una asignatura para cancelar ", "Modificar Matricula Usuario", "error");
                    }
                }



                $("#enviar").button().click(function () {

                    cadenaprestamos = [];
                    cadenaequipos = [];
                    actualizarusuarios = [];
                    arraypcs = [];

                    $('.detprestamo').each(function (i) {
                        valor = $(this).text();
                        cadenaprestamos[i] = valor;

                    });


                    $('.detequipo').each(function (i) {
                        valor = $(this).text();
                        cadenaequipos[i] = valor;

                    });

                    $("input:checked").each(function (i) {
                        valor = $(this).val();
                        datos = valor.split(".");
                        codIngreso = datos[0];
                        pc = datos[1];
                        actualizarusuarios[i] = codIngreso;
                        arraypcs[i] = pc;

                    });

                    tamañoarrayecursos = cadenaprestamos.length;
                    tamañoarrayequipos = cadenaequipos.length;
                    tamañoarraypcs = arraypcs.length;
                    NoPcs = $("#NoRegistros").val();

                    if (tamañoarrayecursos > 0)
                    {
                        updaterecursos = 1;
                    } else {
                        updaterecursos = 0;
                    }

                    if (tamañoarrayequipos > 0)
                    {
                        updateequipos = 1;
                    } else {
                        updateequipos = 0;
                    }


                    if (updaterecursos == 1 || updateequipos == 1 || updaterecursos == 1 && updateequipos == 1)
                    {

                        if (tamañoarraypcs == NoPcs)
                        {

                            $.ajax({
                                type: 'POST',
                                url: 'funciones/Salida/salidaxsalausuarios.php',
                                data: 'arrayrecursos=' + cadenaprestamos + '&actualizarusuarios=' + actualizarusuarios + '&arraypcs=' + arraypcs + '&updaterecursos=' + updaterecursos + '&updateequipos=' + updateequipos,
                                success: function (datos) {

                                    if (datos == 11) {
                                        alertas("Los usuarios han salido exitosamente ", "Salida x Sala", "done");
                                        $("tbody", "#detalleasignatura").remove();
                                        $("#detallesalida").hide();
                                        $("#salidaporsala").css({height: "200px"});
                                        $("#sala").val("");


                                    } else if (datos == 1111) {

                                        alertas("Los usuarios han salido exitosamente ", "Salida x Sala", "done");
                                        $("tbody", "#detalleasignatura").remove();
                                        $("#detallesalida").hide();
                                        $("#salidaporsala").css({height: "200px"});
                                        $("#sala").val("");
                                    } else if (datos == 111)
                                    {
                                        alertas("Los usuarios han salido exitosamente ", "Salida x Sala", "done");
                                        $("tbody", "#detalleasignatura").remove();
                                        $("#detallesalida").hide();
                                        $("#salidaporsala").css({height: "200px"});
                                        $("#sala").val("");
                                    } else if (datos == 11111)
                                    {
                                        alertas("Los usuarios han salido exitosamente ", "Salida x Sala", "done");
                                        $("tbody", "#detalleasignatura").remove();
                                        $("#detallesalida").hide();
                                        $("#salidaporsala").css({height: "200px"});
                                        $("#sala").val("");
                                    } else
                                    {
                                        alertas("Ha ocurrido un error", "Salida x Sala", "error");

                                    }

                                }
                            });
                        } else
                        {
                            alertas("Por favor seleccione todos los checkbox", "Salida x Sala", "error");

                        }
                    }
                });

            });// cierro jquery



        </script>

    </head>

    <body>

        <p id="validateErrors"></p>
        <div id="tabs" style="width:750px; min-height:0px; max-height:auto;">
            <ul>
                <li><a href="#Total">Total</a></li>
                <li><a href="#Parcial">Parcial</a></li>

            </ul>

            <div id="Total">      
                <div id="salidaporsala" class="text ui-widget-content ui-corner-all" style="width:650px; height:auto; font-size:12px; margin-bottom:10px; ">
                    <div class="ui-state-default" style="margin-bottom:10px; text-align:center;">SALIDA POR SALA</div>

                    <table style="margin-left:15px;">

                        <tr>
                            <td><label>Sala:</label></td>
                            <td><input type="text" id="sala" size="5" class="text ui-widget-content ui-corner-all" style="margin-right:10px;" title="Digite el numero de sala y presione enter dentro del cajon de texto para realizar la consulta" /> </td>
                            <td><label>Actividad:</label></td>
                            <td> <select size="1" id="actividad">
                                    <option value=''>Seleccione una actividad</option>
                                    <?php
                                    do {
                                        ?>
                                        <option value="<?php echo $row_JRActividad['idActividad'] ?>"><?php echo $row_JRActividad['Descripcion'] ?></option>
                                        <?php
                                    }
                                    while ($row_JRActividad = mysql_fetch_assoc($JRActividad));
                                    $rows = mysql_num_rows($JRActividad);
                                    if ($rows > 0) {
                                        mysql_data_seek($JRActividad, 0);
                                        $row_JRActividad = mysql_fetch_assoc($JRActividad);
                                    }
                                    ?>
                                </select>
                            </td>
                            <tr>
                                <td><label>Fecha Salida:</label></td>
                                <td><input type="text" name="fecha" id="fecha" size="40" class="text ui-widget-content ui-corner-all"          value="<?php
                                    $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
                                    $mes = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                                    $ano = date('Y');
                                    ?> <?php echo '' . $dias[date('w')] . ' ' . date('d') . ' de ' . $mes[date('n')] . ' del ' . $ano . '' ?>" /></td>

                            <td><label>Hora Salida:</label></td>
                            <td><input type="text" name="hora" id="hora" size="7" class="text ui-widget-content ui-corner-all" /></td>
                        </tr>

                    </table>

                    <table class="tableUI" border="1" id="detalleasignatura" cellspacing="0" width="400" style="margin-top:10px; margin-bottom:20px; margin-left:15px;">
                        <thead>
                            <th>Codigo</th>
                            <th>Grupo</th>
                            <th>Asignatura</th>
                        </thead>  
                    </table>

                    <div id="detallesalida" style="overflow:auto; width:620px; min-height:0px; max-height:300px; margin-top:auto;"></div>

                    <table style="margin-left:15px;">
                        <tr>
                            <td><button id="enviar" style="margin-top:10px; margin-bottom:10px;" type="button"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px; font-size:11px;"/>Aceptar</button></td>
                            <td><button type="button" id="abrirPop" style="font-size:11px; margin-top:5px;"><img src="images/mycomputer.png" style="vertical-align:middle; padding-right:4px;"/>Estado Pcs</button></td>  
                        </tr>
                    </table>
                </div>
            </div>    

            <div id="Parcial">

                <div id="" class="text ui-widget-content ui-corner-all" style="width:680px; min-height:80px; max-height:250px; margin-top:20px;">
                    <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CONSULTA POR SALA</div>

                    <table style="margin-left:15px;">
                        <tr>
                            <td><label>Sala:</label></td>
                            <td><select size="1" class="text ui-widget-content ui-corner-all" id="sala_parcial">
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
                                <td><button type="button" id="salida_parcial"  style="font-size:11px; margin-bottom:10px; margin-top:10px;"> <img src="images/aceptar.png"  style="vertical-align:middle; padding-right:3px"/>Aceptar</button></td>  
                            </td>

                        </tr> 
                    </table>

                </div> 

                <div id="detalleConsultaxSala" style="overflow:auto; width:680px; min-height:0px; max-height:300px;"> </div>

                <td><button type="button" id="dar_salida"  style="font-size:11px; margin-bottom:10px; margin-top:10px;"> <img src="images/aceptar.png"  style="vertical-align:middle; padding-right:3px"/>Dar salida usuarios</button></td>

            </div><!-- cierro div Adicusuario-->
        </div> 

        <div id="alertas"></div>

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


        <div id="wrapper"></div><!-- #wrapper -->
    </body>
</html>
