<?php require_once('../../Connections/conexion.php'); ?>
<?php date_default_timezone_set("America/bogota"); ?>

<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$usuario=$_POST['usuario'];

mysql_select_db($database_conexion, $conexion);
$query_JRUsuarios = "select nombreUsu, apellidos from usuarios where codUsuario=$usuario";
mysql_query("SET NAMES 'utf8'");
$JRUsuarios= mysql_query($query_JRUsuarios, $conexion) or die(mysql_error());
$row_JRUsuarios = mysql_fetch_assoc($JRUsuarios);
$totalRows_JRUsuarios = mysql_num_rows($JRUsuarios);

if($totalRows_JRUsuarios > 0)
{

$dia= date('w');


mysql_select_db($database_conexion, $conexion);
$query_JRIngresos1 = "select h.horainicio,h.horafinal,h.idHorario,fechaInicio,fechaFinal from  usuarios u inner join matricula m  on(u.codUsuario=m.codUsuario) inner join horario h on (h.idHorario=m.idHorario) where h.codDia=$dia and u.codUsuario=$usuario and m.Estado='Activa' order by h.horainicio";
mysql_query("SET NAMES 'utf8'");
$JRIngresos1 = mysql_query($query_JRIngresos1, $conexion) or die(mysql_error());
$row_JRIngresos1 = mysql_fetch_assoc($JRIngresos1);
$totalRows_JRIngresos1 = mysql_num_rows($JRIngresos1);

 $horahorario= 0;
 $idhorario=0;
 $fechahorarioinicio=0;
 $fechahorariofinal=0;
 $horaentrada= strtotime(date('H:i:s'));
 $fechaentrada=strtotime(date("Y-m-d"));


 
 if($totalRows_JRIngresos1 > 0)
 {
     
    do{
	 
	  $horainicio= strtotime($row_JRIngresos1['horainicio']);
	  $horafinal= strtotime($row_JRIngresos1['horafinal']);
	  $fechainicio= $row_JRIngresos1['fechaInicio'];
	  $fechafinal=$row_JRIngresos1['fechaFinal'];
	  $Horario=$row_JRIngresos1['idHorario'];
	  $fechainicio = strtotime($fechainicio);
	  $fechafinal =strtotime($fechafinal);
   
	
		/*if($fechaentrada >= $fechainicio && $fechaentrada <= $fechafinal)
		 {
			 $fechahorarioinicio=$fechainicio;
			 $fechahorariofinal=$fechafinal;
		 }*/
		 
		 
	    if( $horaentrada >= $horainicio && $horaentrada < $horafinal )
		{
			 $horahorario= $horainicio;
		     $idhorario= $Horario;
			
		}
		   
	}while($row_JRIngresos1 = mysql_fetch_assoc($JRIngresos1));
	 mysql_free_result($JRIngresos1);
	 
	 //if($fechahorarioinicio!=0 && $fechahorariofinal!=0)
	 //{
	
	   if($horahorario!=0 && $idhorario!=0 )
       { 
        
  
	 mysql_select_db($database_conexion, $conexion);
	$query_JRIngresos = "select  h.sala,h.codAsignatura,h.codGrupo, h.No_reserva, a.nomAsignatura,a.actividad, m.pc from usuarios u  inner join matricula m on (u.codUsuario= m. codUsuario) inner join asignatura a on(m.codAsignatura=a.codAsignatura) inner join horario h on(m.idHorario=h.idHorario) where h.codDia=$dia and $horaentrada >= $horahorario and u.codUsuario=$usuario and h.idHorario=$idhorario and m.Estado='Activa'";
	mysql_query("SET NAMES 'utf8'");
	$JRIngresos = mysql_query($query_JRIngresos, $conexion) or die(mysql_error());
	$row_JRIngresos = mysql_fetch_assoc($JRIngresos);
	$totalRows_JRIngresos = mysql_num_rows($JRIngresos);
	
	  if ($totalRows_JRIngresos > 0)
	  {
	
		$sala=$row_JRIngresos['sala'];
		$codasignatura=$row_JRIngresos['codAsignatura'];
		$grupo=$row_JRIngresos['codGrupo'];
		$nomasignatura=$row_JRIngresos['nomAsignatura'];
		$actividad=$row_JRIngresos['actividad'];
		$pc=$row_JRIngresos['pc'];
		$reserva=$row_JRIngresos['No_reserva'];
		$usuario=$row_JRUsuarios['nombreUsu']." ".$row_JRUsuarios['apellidos'];
		
		$response=array("error"=>"3","sala"=>$sala,"codasignatura"=>$codasignatura,"grupo"=>$grupo,"nomasignatura"=>$nomasignatura,"actividad"=>$actividad,"pc"=>$pc,"reserva"=>$reserva,"usuario"=>$usuario); 
		echo json_encode($response);
		mysql_free_result($JRIngresos);  
	  }
    
	}
	 else
	 {
	   //devuelve 2 cuando el usuario no tiene clase en la hora indicada 
	   $response=array("error"=>2);
	   echo json_encode($response);
	   
	 }
	 
	 /*}
	 else
	 {
		//devuelve 4 cuando el usuario no le corresponde ver todavia clase
	    $response=array("error"=>4);
	    echo json_encode($response); 
	 }*/
	 

 } //cierro $totalRows_JRIngresos1 
 
 else if($totalRows_JRIngresos1 ==  0)
 {
	//devuelve 1 cuando el usuario no tiene clase en ese dia en especifico 
	$response=array("error"=>1);
	echo json_encode($response);
	
 }
  
}// cierro $totalRows_JRUsuarios
else
{
  // devuelve cero cuando el usuario no existe
  $response=array("error"=>0);
  echo json_encode($response);
 
}

 mysql_free_result($JRUsuarios);
 mysql_close($conexion);
?>
