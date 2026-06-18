
<!-- http://ProgramarEnPHP.wordpress.com -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>:: Importar de Excel a la Base de Datos ::</title>

    <style>
        .clean-gray{
            border:solid 1px #DEDEDE;
            background:#EFEFEF;
            color:#222222;
            padding:4px;
            text-align:center;
        } 

    </style> 
    
    <script type="text/javascript">

        $(function () {
            
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

            $("#enviar").button().click(function () {

              var data= $("#excel").val();
              var file= data.split('.');
              var ext= file[1];
              
             if(data != "")
             {
              
              if(ext== 'xls' || ext== 'xlsx'){
                $("#importar").submit();
                $("#load").show();
                         
              }
              else{
                 alertas("El formato de archivo seleccionado no es permitido", "Carga Masiva Usuarios", "error"); 
              }
          }
          else
          {
              alertas("Por favor seleccione un archivo para cargar", "Carga Masiva Usuarios", "error"); 
          }
                
            });

            $("#excel").button().click(function () {

               // $("#enviar").show();
            });

        });

    </script>
</head>

<body>
    <!-- FORMULARIO PARA SOICITAR LA CARGA DEL EXCEL -->
    <div id="carga_masiva" class="text ui-widget-content ui-corner-all" style="width:80%; height:auto; font-size:12px;  background-color:#F8F8F8; background-repeat:repeat-y;">
        <div class="ui-state-default" style="text-align:center; margin-bottom:15px;">CARGA MASIVA USUARIOS</div>
        <label style="font-weight: bold">Selecciona el archivo a importar:</label>
        <form name="importar" id="importar" method="post" action="funciones/Usuario/insertar_usuarios_masivo.php" enctype="multipart/form-data" >
            <input type="file" name="excel" id="excel" style="margin-bottom: 10px;" />
            <input type="button" name='enviar' id="enviar"  value="Importar"  />
            <input type="hidden" value="upload" name="action" />
        </form> 
    </div>
    <div class='clean-gray' style="display: none; width: 80%; margin-top: 10px;" id="load">Por favor espere, el proceso de cargue de usuarios puede demorar dependiendo del numero de usuarios a cargar <br/> <img style="margin-top: 10px;" src="images/load-gif.gif"</div>
     <div id="alertas"></div> 
</body>
</html>

