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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin título</title>



        <script type="text/javascript">



            $(function () {

                $.datepicker.setDefaults($.datepicker.regional['es']);
                $('#fecharecibo').datepicker();
                $('#fecharecibo').datepicker("option", "defaultDate", +7);
                $('#fecharecibo').datepicker("option", "dateFormat", 'dd-mm-yy');


                var contador = 1;

                $("#grupo").change(function (event) {

                    var id = $("#grupo").find(':selected').val();
                    $("#subgrupo").load('consultas/Recurso/generarselect.php?id=' + id);
                    contador = 1;
                    $("#de").val(contador);

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


                function verificarExistenciaRecurso()
                {

                    codigoInv = $("#NoInventario").val();

                    if (codigoInv != "")

                    {
                        $.ajax({
                            type: 'POST',
                            url: 'consultas/Recurso/existenciarecurso.php',
                            data: 'codigoInv=' + codigoInv,
                            success: function (datos) {

                                if (datos == 1)
                                {

                                    $("#NoInventario").val("");
                                    $("#NoInventario").addClass("ui-state-error");
                                    alertas("El Recurso ya existe en la base de datos", "Adicionar Recurso", "error");

                                } else
                                {
                                    $("#NoInventario").removeClass("ui-state-error");
                                    insertarDatosRecursos();
                                }
                            }
                        });
                    }
                }





                function limpiar_formulario_elementos() {

                    $("#NoInventario").val("");
                    $("#nombrebien").val("");
                    $("#cantidad").val("");
                    $("#marca").val("");
                    $("#serial").val("");
                    $("#caracteristicas").val("");
                    $("#instaladoS").val("");
                    $("#instaladoC").val("");
                    $("#llave").val("");
                    $("#tipo").val("");
                    $("#licencia").val("");
                    $("#factura").val("");
                    $("#proveedor").val("");
                    $("#valor").val("");
                    $("#fecharecibo").val("");
                    $("#version").val("");


                }

                $("#limpiarform").button().click(function () {

                    $('#nombrebien').val("");
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
                    $('#proveedor').val("");
                    $('#valor').val("");
                    $('#fecharecibo').val("");
                    $('#version').val("");
                    $("#NoInventario").val("");
                    $("#NoInventario").focus();

                });

                $("#enviar").button().click(function () {

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
                            },
                            {
                                id: "estado",
                                validations: {
                                    required: [true, "El campo estado no puede estar vacio."],
                                }
                            },
                            {
                                id: "nombrebien",
                                validations: {
                                    required: [true, "El campo Nombre del bien no puede estar vacio."],
                                }
                            },
                            {
                                id: "cantidad",
                                validations: {
                                    required: [true, "El campo Cantidad  no puede estar vacio."],
                                    number: [true, "El  campo Cantidad  debe contener numeros ."]

                                }
                            },
                            {
                                id: "marca",
                                validations: {
                                    required: [true, "El campo Marca no puede estar vacio."],
                                }
                            },
                            {
                                id: "caracteristicas",
                                validations: {
                                    required: [true, "El campo caracteristicas  no puede estar vacio."],
                                }
                            }
                    ],
                        beforeValidation: function ()
                        {

                            verificarExistenciaRecurso();
                        }
                    };
                    $.validation(options);

                });// cierra enviar	


                function insertarDatosRecursos()
                {

                    inventario = $("#NoInventario").val();
                    nombrebien = $("#nombrebien").val();
                    grupo = $("#grupo").val();
                    subgrupo = $("#subgrupo").val();
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
                        url: 'funciones/Recurso/insertarrecurso.php',
                        data: 'inventario=' + inventario + '&estado=' + estado + '&grupo=' + grupo + '&cantidad=' + cantidad + '&marca=' + marca + '&serial=' + serial + '&estado=' + estado + '&caracteristicas=' + caracteristicas + '&instaladosala=' + instaladosala + '&instaladopc=' + instaladopc + '&nombre=' + nombrebien + '&subgrupo=' + subgrupo + '&llave=' + llave + '&Tipo=' + tipo + '&Licencia=' + licencia + '&Idioma=' + idioma + '&Factura=' + factura + '&Proveedor=' + proveedor + '&Valor=' + valor + '&Fecharecibo=' + fecharecibo + '&Version=' + version + '&estadoPrestamo=' + estadoPrestamo,
                        success: function (datos) {

                            if (datos == 1) {
                                alertas("Los datos se han ingresado correctamente", "Crear Recurso", "done");
                                limpiar_formulario_elementos();
                                contador += 1;
                                $("#de").val(contador);
                            } else {

                                alertas("Por favor verifique los datos", "Crear Recurso", "error");
                            }
                        }
                    });
                }











            }); // cierra el function
        </script>


    </head>

    <body>


        <p id="validateErrors"></p>



        <div id="recursos" class="text ui-widget-content ui-corner-all" style="width:80%; margin-bottom:15px; height:auto; font-size:12px;">
            <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CREAR RECURSO</div>      

            <table style="margin-left:15px;">

                <tr>
                    <td ><label>No Inventario:</label></td>
                    <td><input type="text"  id="NoInventario" size="20"  class="text ui-widget-content ui-corner-all"/></td>    

                    <td><label>Estado::</label></td>
                    <td>
                        <select size="1" name="estado"   class="text ui-widget-content ui-corner-all" id="estado">
                            <option value="">Seleccione</option> 
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
                    <tr>

                        <td><label>Nombre del bien:</label></td>
                        <td><input type="text" name="nombrebien" id="nombrebien" size="35" class="text ui-widget-content ui-corner-all"/>
                        </td>
                    </tr>

                    <table style="margin-left:15px;">
                        <tr> 
                            <td><label>Grupo:</label></td>
                            <td><select size="1" name="grupo"   class="text ui-widget-content ui-corner-all" id="grupo">
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

                            <td><label>subGrupo:</label></td>
                            <td><select size="1" name="subgrupo"   class="text ui-widget-content ui-corner-all" id="subgrupo">
                                    <option selected value="0">Seleccione</option>
                                </select></td>

                        </tr>

                    </table>

                    <table  style="margin-left:15px;">
                        <tr>
                            <td><label>Cantidad:</label></td>
                            <td><input type="text" name="cantidad" id="cantidad" size="5" maxlength="128"  class="text ui-widget-content ui-corner-all" value="1"/>
                            </td>
                            <td><label>De:</label></td>
                            <td><input type="text" name="de" id="de" size="5"   class="text ui-widget-content ui-corner-all" maxlength="128" value="1"  class"required"/>
                        </td>
                        <td><label>Marca:</label></td>
                        <td><input type="text" name="marca" id="marca" size="20" maxlength="128"  class="text ui-widget-content ui-corner-all"/>
                        </td>
                    </tr>

                </table>

                <table  style="margin-left:15px;">
                    <tr>
                        <td><label>Serial</label></td>
                        <td><input type="text" name="de" id="serial" size="15" maxlength="128"   class="text ui-widget-content ui-corner-all"/>
                        </td>
                        <td><label>Caracteristicas:</label></td>
                        <td><textarea name="caracteristicas" cols="40" rows="3" id="caracteristicas" class="text ui-widget-content ui-corner-all"></textarea>
                        </td>
                    </tr>
                </table>

                <table  style="margin-left:15px;">
                    <tr>
                        <td><label>Instalado en la sala:</label></td>
                        <td><input type="text" name="cantidad"   class="text ui-widget-content ui-corner-all" id="instaladoS" size="5" maxlength="128"   />
                        </td>
                        <td><label>Instalado en el computador:</label></td>
                        <td><input type="text" name="de"   class="text ui-widget-content ui-corner-all" id="instaladoC" size="5" maxlength="128"   />
                        </td>
                    </tr>
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
                                <option value=""></option>
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
        </table>
    </div>

    <div style="margin-left: 10px; margin-bottom: 10px; margin-top: 10px;">
        <button type="button" id="enviar" style="font-size:11px; padding-left: 5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:3px;"/>Aceptar</button>
        <button type="button" id="limpiarform" style="font-size:11px; padding-left: 5px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/> Limpiar</button>
    </div>


    <div id="alertas"></div>	


</body>
</html>
<?php
mysql_free_result($JRRecursos);
?>
