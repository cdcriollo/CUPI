<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<?php
header('Content-Type:text/html; charset=UTF-8');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=\"Reporte Asistencia Usuarios.xls\"");
header("Pragma: no-cache");
header("Expires: 0"); 

  echo $_POST["datos_a_enviar"];
?>