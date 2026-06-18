// JavaScript Document

$(function () {



    $('#adicusuario').click(function () {



        $.ajax({
            url: 'forms/Usuario/formusuario.php',
            success: function (msg) {
                $("#contenedor").html(msg);
            }
        });


    });

    // Adiciona una asignatura a la base de datos

    $('#adicasignatura').click(function () {


        $.ajax({
            url: 'forms/Asignatura/formasignatura.php',
            success: function (msg) {
                $("#contenedor").html(msg);
            }
        });
    });



    $('#consusuario').click(function () {

        $.ajax({
            url: 'forms/Usuario/formconsultarusuario.php',
            success: function (msg) {
                $("#contenedor").html(msg);
            }
        });

    });



    $('#modusuario').click(function () {


        $.ajax({
            url: 'forms/Usuario/formmodificarusuario.php',
            success: function (msg) {
                $("#contenedor").html(msg);
            }
        });

    });


    $('#cancelar').click(function () {


        $.ajax({
            url: 'forms/Usuario/formCancelarUsuario.php',
            success: function (msg) {
                $("#contenedor").html(msg);
            }
        });
    });



    $('#consultarAsig').click(function () {


        $.ajax({
            url: 'forms/Asignatura/formconsultarasignatura.php',
            success: function (msg) {
                $("#contenedor").html(msg);

            }
        });
    });


    $('#updateasig').click(function () {

        $.ajax({
            url: 'forms/Asignatura/formmodificarasignatura.php',
            success: function (msg) {
                $("#contenedor").html(msg);
            }
        });
    });


    $('#eliminarAsig').click(function () {


        $.ajax({
            url: 'forms/Reserva/formcancelarAsignatura.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });
    });


    $('#Adicrecurso').click(function () {

        $.ajax({
            url: 'forms/Recurso/formcrearrecurso.php',
            success: function (datos) {

                $("#contenedor").html(datos);

            }
        });
    });


    $('#ConsRecurso').click(function () {

        $.ajax({
            url: 'forms/Recurso/formconsultarrecurso.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });
    });


    $('#modrecurso').click(function () {

        $.ajax({
            url: 'forms/Recurso/formmodificarrecurso.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });
    });



    $('#Utilizacion').click(function () {

        $.ajax({
            url: 'forms/ReportesAdministrador/Utilizacion/formConsultaUtilizacion.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });


    $('#ingresousuario').click(function () {

        $.ajax({
            url: 'forms/IngresoUsuarios/formIngresos.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });
    });


    $('#salusuario').click(function () {

        $.ajax({
            url: 'forms/SalidaUsuarios/formSalidaUsuarios.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });
    });


    $('#salsala').click(function () {

        $.ajax({
            url: 'forms/SalidaUsuarios/formSalidaxSala.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });
    });



    $('#porusuario').click(function () {

        $.ajax({
            url: 'forms/ReportesOperario/Usuario/formConsUsuOper.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });
    });


    $('#porasignatura').click(function () {

        $.ajax({
            url: 'forms/ReportesOperario/Asignatura/formConsAsigOper.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });
    });


    $('#Asistencia').click(function () {

        $.ajax({
            url: 'forms/ReportesAdministrador/Asistencia/formreporteasistencia.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });
    });


    $('#informerecursos').click(function () {

        $.ajax({
            url: 'forms/ReportesAdministrador/Recursos/formReporteRecursos.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });
    });

    $('#porrecursos').click(function () {


        $.ajax({
            url: 'forms/ReportesAdministrador/Recursos/formReporteRecursos.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });
    });



    $('#Horarios').click(function () {


        $.ajax({
            url: 'forms/ReportesAdministrador/Sala/formReportePorSala.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });
    });


    $('#CUserAplicacion').click(function () {


        $.ajax({
            url: 'forms/Usuarios_Aplicacion/formCrearuserAplication.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });
    });


    $('#ConsUserAplicacion').click(function () {


        $.ajax({
            url: 'forms/Usuarios_Aplicacion/formconsultarusuarioA.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });
    });


    $('#MUserAplicacion').click(function () {


        $.ajax({
            url: 'forms/Usuarios_Aplicacion/formmodificarusuarioA.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });
    });


    $("#porsala").click(function () {

        $.ajax({
            url: 'forms/ReportesAdministrador/Sala/formReportePorSala.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#porasistencia").click(function () {

        $.ajax({
            url: 'forms/ReportesAdministrador/Asistencia/formreporteasistencia.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#listadoclase").click(function () {

        $.ajax({
            url: 'forms/ReportesAdministrador/ListadosClase/formlistadosdeclase.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });


    $("#listadoclasemonitor").click(function () {

        $.ajax({
            url: 'forms/ReportesAdministrador/ListadosClase/formlistadosdeclase.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });


    $("#BusquedaUsuarioSala").click(function () {

        $.ajax({
            url: 'forms/ReportesOperario/UsuariosSala/formusuariossala.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#Pcs").click(function () {

        $.ajax({
            url: 'forms/Pcs/AdministrarPcs/index.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#Actividades").click(function () {

        $.ajax({
            url: 'forms/Actividades/AdminActividades/index.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#Dependencias").click(function () {

        $.ajax({
            url: 'forms/Dependencias/AdminDependencias/index.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });


    $("#Gruposubgrupo").click(function () {

        $.ajax({
            url: 'forms/Gruposubgrupo/formGruposubgrupo.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });


    $("#addreserva").click(function () {

        $.ajax({
            url: 'forms/Reserva/formReserva.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });


    $("#searchreserva").click(function () {

        $.ajax({
            url: 'forms/Reserva/formConsultarReserva.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#updatereserva").click(function () {

        $.ajax({
            url: 'forms/Reserva/formModificarReserva.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });


    $("#matreserva").click(function () {

        $.ajax({
            url: 'forms/Reserva/formMatriculaReserva.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#consultarreserva").click(function () {

        $.ajax({
            url: 'forms/Reserva/formconsmatricula.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#modmatreserva").click(function () {

        $.ajax({
            url: 'forms/Reserva/formmodmatricula.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#infreservas").click(function () {

        $.ajax({
            url: 'forms/ReportesAdministrador/InformeReservas/formInformeReservas.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });


    $("#Addmonitor").click(function () {

        $.ajax({
            url: 'forms/Monitores/formmonitor.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#searchmonitor").click(function () {

        $.ajax({
            url: 'forms/Monitores/formconsultarmonitor.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#updatemonitor").click(function () {

        $.ajax({
            url: 'forms/Monitores/formmodificarmonitor.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#Addvinculacion").click(function () {

        $.ajax({
            url: 'forms/Vinculacion_Monitor/formvincmonitor.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#searchvinculacion").click(function () {

        $.ajax({
            url: 'forms/Vinculacion_Monitor/formconsultarvinculacion.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#updatevinculacion").click(function () {

        $.ajax({
            url: 'forms/Vinculacion_Monitor/formModificarVinculacion.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#planilla").click(function () {

        $.ajax({
            url: 'forms/Planilla/formPlanillaMonitor.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#repmonitoresadmin").click(function () {

        $.ajax({
            url: 'forms/ReportesAdministrador/ReporteMonitores/formreportemonitores.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });

    $("#reportesMonitor").click(function () {

        $.ajax({
            url: 'forms/ReportesAdministrador/ReporteMonitores/formreportemonitores.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });
    
    $("#carga_usuario").click(function () {

        $.ajax({
            url: 'forms/Usuario/carga_masiva_usuarios.php',
            success: function (datos) {
                $("#contenedor").html(datos);
            }
        });

    });
    
}); // cierro jquery