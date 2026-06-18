<?php require_once('../../Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
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

function calcular_tiempo_trasnc($horastrabajadas)
 {
	
  
	$separar[1]=explode(':',$horastrabajadas);
	$total_minutos_trasncurridos[1] = ($separar[1][0]*60) +$separar[1][1];
	$total_minutos_trasncurridos = $total_minutos_trasncurridos[1];
	
	return $total_minutos_trasncurridos;   
		 
}


	
$codigo=$_POST['codigo'];
$totaltiempo=0;

	mysql_select_db($database_conexion, $conexion);
	$query_JRTotalhorassemestre = "SELECT total_horas_semestre,comienzo,finalizacion FROM vinculacion_monitor WHERE cedula = '$codigo' and estado='activo'";
	$JRTotalhorassemestre = mysql_query($query_JRTotalhorassemestre, $conexion) or die(mysql_error());
	$row_JRTotalhorassemestre = mysql_fetch_assoc($JRTotalhorassemestre);
	$totalRows_JRTotalhorassemestre = mysql_num_rows($JRTotalhorassemestre);

	$total_horas_semestre= $row_JRTotalhorassemestre['total_horas_semestre'];
	$comienzo=$row_JRTotalhorassemestre['comienzo'];
	$finalizacion=$row_JRTotalhorassemestre['finalizacion'];
	
	 if($totalRows_JRTotalhorassemestre > 0){
		 
		 mysql_select_db($database_conexion, $conexion);
		$query_JRHorastrabajadas = "SELECT total_horas_turno FROM ingreso_salida_monitor WHERE codigo = '$codigo' and fecha_entrada >='$comienzo' and fecha_salida <= '$finalizacion' ";
		
		$JRHorastrabajadas = mysql_query($query_JRHorastrabajadas, $conexion) or die(mysql_error());
		$row_JRHorastrabajadas = mysql_fetch_assoc($JRHorastrabajadas);
		$totalRows_JRHorastrabajadas = mysql_num_rows($JRHorastrabajadas);
		
	
			 do{
			  
			   $horas_trabajadas=$row_JRHorastrabajadas ['total_horas_turno'];
			   
			  if($horas_trabajadas==""){
				 $horas_trabajadas="00:00:00";
				 $total=calcular_tiempo_trasnc($horas_trabajadas);
				 $totaltiempo+=$total;
				 $totalhoras=(int)($totaltiempo/60);
				 $totalminutos=$totaltiempo%60;
				 $totalhorastrabajadas= $totalhoras.":".$totalminutos; 
				 
				  if($totalhoras<=9 && $totalminutos<=9){
				    $totalhorastrabajadas= "0".$totalhoras.":"."0".$totalminutos;
				  }
				  else if($totalminutos<=9 && $totalhoras >9){
					$totalhorastrabajadas= $totalhoras.":"."0".$totalminutos;
				  }
				  else if($totalminutos==0 && $totalhoras <=9){
					$totalhorastrabajadas= "0". $totalhoras.":"."0".$totalminutos;  
				  }
				 else if($totalminutos>0 && $totalhoras >9){
				   $totalhorastrabajadas= $totalhoras.":".$totalminutos;
				 }
				else if($totalminutos>0 && $totalhoras<=9){
				  $totalhorastrabajadas= "0".$totalhoras.":".$totalminutos;
				} 	 
			  }
			  else{
				  $total=calcular_tiempo_trasnc($horas_trabajadas);
				  $totaltiempo+=$total;
				  $totalhoras=(int)($totaltiempo/60);
				  $totalminutos=$totaltiempo%60;
				  $totalhorastrabajadas= $totalhoras.":".$totalminutos;
				  
				  if($totalhoras<=9 && $totalminutos<=9){
				    $totalhorastrabajadas= "0".$totalhoras.":"."0".$totalminutos;
				  }
				  else if($totalminutos<=9 && $totalhoras >9){
					$totalhorastrabajadas= $totalhoras.":"."0".$totalminutos;
				  }
				  else if($totalminutos==0 && $totalhoras <=9){
					$totalhorastrabajadas= "0". $totalhoras.":"."0".$totalminutos;  
				  }
				 else if($totalminutos>0 && $totalhoras >9){
				   $totalhorastrabajadas= $totalhoras.":".$totalminutos;
				 }
				else if($totalminutos>0 && $totalhoras<=9){
				  $totalhorastrabajadas= "0".$totalhoras.":".$totalminutos;
				} 	 
			  }
			  
			  
			}while($row_JRHorastrabajadas = mysql_fetch_assoc($JRHorastrabajadas));
			
			 $horas_trabajadas_monitor=explode(':',$totalhorastrabajadas);
			 $total_horas_x_trabajar= $total_horas_semestre - $horas_trabajadas_monitor[0];
			 $response = array("error"=>0,"total_horas_semestre"=>$total_horas_semestre, "total_horas_trabajadas"=>$totalhorastrabajadas, "total_horas_x_trabajar"=>             $total_horas_x_trabajar);
			 echo json_encode($response);
		  
	 }
	
mysql_free_result($JRTotalhorassemestre);
mysql_free_result($JRHorastrabajadas);
mysql_close($conexion);
?>