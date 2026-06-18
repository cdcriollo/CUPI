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

if(isset($_POST['asignatura'], $_POST['crucecomp'],$_POST['grupo']))
{

//Obtengo los valores por POST
$asignatura=$_POST['asignatura'];
$crucecomp=explode(',',$_POST['crucecomp']);
$grupo=$_POST['grupo'];


// Obtengo el codigo el computador y la reserva del primer usuario
$codigorusuario1=$crucecomp[0];
$primerpcusuario1=$crucecomp[1];
$reserva1erusuariio=$crucecomp[2];

// Obtengo el codigo el computador y la reserva  del segundo usuario
$codigousuario2=$crucecomp[3];
$segundorpcusuario=$crucecomp[4];
$reserva2dousuariio=$crucecomp[5];


if (strcasecmp($reserva1erusuariio, $reserva2dousuariio) == 0) 
{
  
	   // Realizo un update para cada usuario en la tabla matriculas
	  $updateMatricula = "update matricula set pc=$primerpcusuario1 where codAsignatura='$asignatura' and codUsuario=$codigousuario2 and grupo=$grupo and No_reserva= '$reserva1erusuariio' ";
	  mysql_select_db($database_conexion, $conexion);
	  $Result1 = mysql_query($updateMatricula, $conexion) or die(mysql_error());
	  $FilasAfectadasCrucepc=mysql_affected_rows();
	  
	  $updateMatricula1 = "update matricula set pc= $segundorpcusuario where codAsignatura='$asignatura' and codUsuario= $codigorusuario1 and grupo=$grupo and No_reserva= '$reserva1erusuariio'";
	  mysql_select_db($database_conexion, $conexion);
	  $Result2 = mysql_query($updateMatricula1, $conexion) or die(mysql_error());
	  $FilasAfectadasCrucepc1=mysql_affected_rows();
	  
	       
	     // Verifico si se ha hecho las actualizaciones en la base de datos
			if($FilasAfectadasCrucepc > 0 && $FilasAfectadasCrucepc1 > 0)
			{
				$response=array("error"=>0);
				echo json_encode($response);
					
			}
			else if($FilasAfectadasCrucepc==0 && $FilasAfectadasCrucepc1==0)
			{
			    $response=array("error"=>1);
				echo json_encode($response);
			}
			
   }
   else
   {
	  $response=array("error"=>3);
	  echo json_encode($response); 
   }
	
				
 }// cierro isset
 
 else
 {  
    // Devuelve 2 cuando el usuiario no ha enviado los datos correctamente
	 $response=array("error"=>2);
	 echo json_encode($response);
 }


?>
