<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <style>
        .clean-gray{
            border:solid 1px #DEDEDE;
            background:#EFEFEF;
            color:#222222;
            padding:4px;
            text-align:center;
        } 

    </style> 
</head>

<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require_once('../../Connections/conexion.php');

//solo le agregue el sufijo bak_ 
$archivo = $_FILES['excel']['name'];
$tipo = $_FILES['excel']['type'];
$destino = "bak_" . $archivo;
if (copy($_FILES['excel']['tmp_name'], $destino)) {
  echo '<center> <div class="clean-gray">'.'ARCHIVO CARGADO CON EXITO'.'</div>'. '<br>'.'<a href="http://localhost/CUPI/principal.php" role="button">Volver</a>' .'</center>';
}
else {
    echo '<div class="clean-gray">'.'Error Al Cargar el Archivo'.'</div>';
}

if (file_exists("bak_" . $archivo)) {

    /** Clases necesarias */
    require_once('../../lib/excelamysql/Classes/PHPExcel.php');
    require_once('../../lib/excelamysql/Classes/PHPExcel/Reader/Excel2007.php');

    // Cargando la hoja de cálculo
    $objReader = new PHPExcel_Reader_Excel2007();
    $objPHPExcel = $objReader->load("bak_" . $archivo);
    $objFecha = new PHPExcel_Shared_Date();

    // Asignar hoja de excel activa
    $objPHPExcel->setActiveSheetIndex(0);

    // Llenamos el arreglo con los datos  del archivo xlsx
    $fin_archivo = false;

    try {
        for ($i = 2; !$fin_archivo; $i++) {
            $_DATOS_EXCEL[$i]['codUsuario'] = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getValue();
            $_DATOS_EXCEL[$i]['apellidos'] = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getValue();
            $_DATOS_EXCEL[$i]['nombreUsu'] = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getValue();
            $_DATOS_EXCEL[$i]['dependencia'] = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getValue();
            $_DATOS_EXCEL[$i]['estamento'] = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getValue();

            //Condición de parada
            if ($_DATOS_EXCEL[$i]['codUsuario'] == '' &&
                    $_DATOS_EXCEL[$i]['apellidos'] == '' &&
                    $_DATOS_EXCEL[$i]['nombreUsu'] == '' &&
                    $_DATOS_EXCEL[$i]['dependencia'] == '' &&
                    $_DATOS_EXCEL[$i]['estamento'] == '') {
                unset($_DATOS_EXCEL[$i]);
                $fin_archivo = true;
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
//si por algo no cargo el archivo bak_ 
else {
    echo "Necesitas primero importar el archivo";
}

$errores = 0;
$total_usuarios = 0;

foreach ($_DATOS_EXCEL as $item) {

    $codigo = $item{'codUsuario'};
    $apellidos = $item{'apellidos'};
    $nombre = $item{'nombreUsu'};
    $dependencia = $item{'dependencia'};
    $estamento = $item{'estamento'};

    mysql_select_db($database_conexion, $conexion);
    $insertSQL = "INSERT IGNORE INTO usuarios (codUsuario,apellidos,nombreUsu,dependencia,estamento) VALUES ('$codigo','$apellidos','$nombre','$dependencia','$estamento')";
    mysql_query("SET NAMES 'utf8'");
    $Result = mysql_query($insertSQL, $conexion) or die(mysql_error());
    mysql_query("COMMIT");
    $total_usuarios++;
   
}

echo "<center> <div class='clean-gray'>ARCHIVO IMPORTADO CON EXITO, EN TOTAL $total_usuarios REGISTROS </center>";
//una vez terminado el proceso borramos el archivo que esta en el servidor el bak_
unlink($destino);
?>


