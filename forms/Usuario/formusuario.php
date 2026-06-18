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
$query_JREstamento = "SELECT * FROM estamento";
mysql_query("SET NAMES 'utf8'");
$JREstamento = mysql_query($query_JREstamento, $conexion) or die(mysql_error());
$row_JREstamento = mysql_fetch_assoc($JREstamento);
$totalRows_JREstamento = mysql_num_rows($JREstamento);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cupi-Control de Utilizacion Piso Informatico</title>

        <script type="text/javascript">

            $(function () {

                var estado = 0;
                var cadena = new Array();

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


                function verificarExistenciaUsuario()
                {

                    codigoU = $("#codusu").val();

                    if (codigoU != "")

                    {
                        $.ajax({
                            type: 'POST',
                            url: 'consultas/Usuario/existenciausuario.php',
                            data: 'codigoU=' + codigoU,
                            success: function (datos) {

                                if (datos == 1)
                                {

                                    $("#codusu").val("");
                                    $("#codusu").addClass("ui-state-error");
                                    alertas("El usuario ya existe en la base de datos", "Adicionar Usuario", "error");

                                } else
                                {
                                    $("#codusu").removeClass("ui-state-error");
                                    insertarDatosUsuario();
                                }
                            }
                        });
                    }
                }


                function limpiar_formulario_elementos(ele) {

                    $(ele).find(':input').each(function () {
                        switch (this.type) {
                            case 'password':
                            case 'text':
                            case 'textarea':
                                $(this).val('');
                                break;
                            case 'checkbox':
                            case 'radio':
                                this.checked = false;
                        }
                    });

                }

                // Evento que limpia el formulario
                $("#limpiarform").button().click(function () {

                    $("#codusu").val("");
                    $("#nomusu").val("");
                    $("#estamento").val("");
                    $("#tags").val("");
                    $("#estado").val("");
                    $("#apellidos").val("");
                    $("#searchString").val("");
                    $("#mostrarbusqueda").empty();
                    $("#codusu").focus();
                    $("#searchString").focus();

                });


                function llenarDependencias(dependencia)
                {

                    $.ajax({
                        type: 'POST',
                        url: 'consultas/Dependencias/ConsExistDependencia.php',
                        data: 'dependencia=' + dependencia,
                        success: function (datos) {

                        }
                    });


                }


                $("#enviar").button().click(function () {

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
                            },
                            {
                                id: "nomusu",
                                validations:
                                        {
                                            required: [true, "El campo Nombre no puede estar vacio."],
                                        }
                            },
                            {
                                id: "apellidos",
                                validations:
                                        {
                                            required: [true, "El campo apellido no puede estar vacio."],
                                        }
                            },
                            {
                                id: "tags",
                                validations:
                                        {
                                            required: [true, "El campo Dependencia no puede estar vacio."],
                                        }
                            }

                        ],
                        beforeValidation: function () {

                            verificarExistenciaUsuario();
                        }
                    };
                    $.validation(options);
                });


                function insertarDatosUsuario()
                {

                    codigo = $("#codusu").val();
                    nombre = $("#nomusu").val();
                    estamento = $("#estamento").val();
                    dependencia = $("#tags").val();
                    apellidos = $("#apellidos").val();

                    $.ajax({
                        type: 'POST',
                        url: 'funciones/Usuario/insertusu.php',
                        data: 'codigo=' + codigo + '&nombre=' + nombre + '&estamento=' + estamento + '&dependencia=' + dependencia + '&apellidos=' + apellidos,
                        success: function (datos) {

                            if (datos == 1)
                            {
                                alertas("Los datos se han ingresado correctamente", "Adicionar Usuario", "done");
                                Nuevadependencia = $("#tags").val();
                                llenarDependencias(Nuevadependencia);
                                limpiar_formulario_elementos($("#formusuario"));
                            } else
                            {
                                alertas("Por favor verifique los datos", "Adicionar Usuario", "error");

                            }
                        }
                    });
                }




                function obtenerDependencia()
                {

                    //$getJSON("URL",CADENA DE DATOS O PARAMETROS,FUNCION CALLBACK);
                    $.getJSON('consultas/Dependencias/consultardependencia.php', function (data) {
                        //DATA ES EL JSON, LA VARIABLE i es el IDENTIFICADOR o KEY foo bar y baz Y LA VARIABLE item es el array, valores o valor que tiene ese identificador
                        $.each(data, function (key, item) {
                            size = item.length;

                            for (i = 0; i < size; i++)
                            {
                                valor = item[i];
                                cadena[i] = valor;
                            }

                            arraycadena(cadena);


                        }); //each

                    });// Getjson
                }



                $('#tags').click(function () {
                    obtenerDependencia();
                });


                function arraycadena(cadena)
                {
                    $("#tags").autocomplete({
                        source: cadena

                    });
                }

            }); // cierra el function
        </script>


    </head>

    <body>

        <p id="validateErrors"></p>



        <div id="formusuario" class="text ui-widget-content ui-corner-all" style="width:420px; height:auto; font-size:12px; background-color:#F8F8F8; background-repeat:repeat-y">
            <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CREAR NUEVO USUARIO</div>

            <table style="margin-left:15px; margin-bottom:10px;">

                <tr>
                    <td><label for="titulo">Codigo:</label></td>
                    <td><input type="text" name="codusu" id="codusu" size="20"  class="text ui-widget-content ui-corner-all height font12" /></td>
                </tr>

                <tr>
                    <td><label for="titulo">Nombre:</label></td>
                    <td><input type="text" name="nomusu" id="nomusu" size="25" class="text ui-widget-content ui-corner-all height font12"/></td>    
                </tr>

                <tr>
                    <td><label for="titulo">Apellidos:</label></td>
                    <td><input type="text" name="apellidos" id="apellidos" size="25" class="text ui-widget-content ui-corner-all height font12"/></td>

                </tr>


                <tr>
                    <td><label for="estamento" style="padding-bottom:5px;">Estamento:</label></td>
                    <td>
                        <select size="1" name="estamento" id="estamento" class="text ui-widget-content ui-corner-all">
<?php
do {
    ?>
                                <option value="<?php echo $row_JREstamento['descripcion'] ?>"><?php echo $row_JREstamento['descripcion'] ?></option>
    <?php
}
while ($row_JREstamento = mysql_fetch_assoc($JREstamento));
$rows = mysql_num_rows($JREstamento);
if ($rows > 0) {
    mysql_data_seek($JREstamento, 0);
    $row_JREstamento = mysql_fetch_assoc($JREstamento);
}
?>
                        </select>
                    </td>


                </tr>


                <div class="ui-widget"> 
                    <tr>

                        <td><label for="dependencia">Dependencia:</label></td>
                        <td> <input type="text" name="tags" id="tags" size="45"  class="text ui-widget-content ui-corner-all height font12" title="Digite alguna letra dentro del cajon de texto para traer la lista de dependencias"/>
                        </td>                 

                    </tr>

                </div>
            </table>   

            <div style="margin-top: 10px; margin-bottom: 10px; margin-left: 10px;">
                <button type="button" id="enviar"  style="font-size:11px; padding-left: 5px;"><img src="images/aceptar.png" style="vertical-align:middle; padding-right:4px;"/>Aceptar</button>
                <button type="button" id="limpiarform" style="font-size:11px; padding-left: 5px;"><img src="images/broom.png" style="vertical-align:middle; padding-right:4px;"/>Limpiar</button>
            </div> 
        </div> 

        <div id="alertas"></div>


    </body>
</html>
