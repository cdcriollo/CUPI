<?php require_once('../../Connections/conexion.php'); 
  date_default_timezone_set("America/bogota"); 
?>

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

// Capturo las variables enviadas por POST
$codigoasignatura=$_POST['codigoA'];
$grupo=$_POST['grupo'];
$codigoresponsable=$_POST['codigoresp'];
$email=$_POST['email'];
$arrayhorarios=$_POST['arrayhorarios'];
$arrayrecursos=$_POST['arrayrecursos'];
$internet=$_POST['internet'];
$nombreasignatura=$_POST['nameasignatura'];
$nombreusuario=$_POST['nameusuario'];
$insertarrecurso= $_POST['insertarrecurso'];
$tiporeserva=$_POST['tiporeserva'];
$No_reserva_eventual="FAIPIRE";
$No_reserva_semestral="FAIPIRS";
$No_reserva="";

// se obtiene la fecha de reserva
$fecha= date('Y'.'-'.'m'.'-'.'d'." ".'H'.":"."i".":".'s');
$ano=$dia= date('Y');

if($tiporeserva==1)
{
	$No_reserva=$No_reserva_semestral;
}
else if($tiporeserva==2)
{
	$No_reserva=$No_reserva_eventual;
}


if( isset ($_POST['codigoA'], $_POST['grupo'], $_POST['codigoresp'], $_POST['email'],$_POST['arrayhorarios'],$_POST['arrayrecursos'],$_POST['internet'],$_POST['nameasignatura'],$_POST['nameusuario'],$_POST['insertarrecurso']))
{

    $insertSQL = sprintf("INSERT INTO reserva_eventual (No_reserva, cod_asignatura, grupo, cod_responsable,fecha_reserva,email,nombre_asignatura, nombre_responsable,internet) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)",
	
                       GetSQLValueString($No_reserva, "text"),
                       GetSQLValueString($codigoasignatura, "text"),
					   GetSQLValueString($grupo, "int"),
                       GetSQLValueString($codigoresponsable, "int"),
					   GetSQLValueString($fecha, "date"),
                       GetSQLValueString($email, "text"),
					   GetSQLValueString($nombreasignatura, "text"),
					   GetSQLValueString($nombreusuario, "text"),
					   GetSQLValueString($internet, "text"));
					   
                      
                       
					   

   mysql_select_db($database_conexion, $conexion);
   mysql_query("SET NAMES 'utf8'");
   $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
   $idreserva = mysql_insert_id();
   $nuevocodigoreserva= $No_reserva."-".$idreserva."-".$ano;
   
    mysql_select_db($database_conexion, $conexion);
 
    $updateSQL = "UPDATE reserva_eventual SET No_reserva= '$nuevocodigoreserva' WHERE id= '$idreserva'";
    mysql_query("SET NAMES 'utf8'");
    $Result2 = mysql_query($updateSQL, $conexion) or die(mysql_error());

		
 
  $arrayhorarios=explode(',',$_POST['arrayhorarios']);
   
 
  
	  for($i=0; $i<count($arrayhorarios)-1;$i+=6)
	  {
		    
   $insertSQL = sprintf("INSERT INTO horario (codGrupo, codAsignatura, codDia, horainicio, horafinal,fechaInicio,fechaFinal,sala,No_reserva) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($grupo, "int"),
                       GetSQLValueString($codigoasignatura, "text"),
                       GetSQLValueString($arrayhorarios[$i], "int"),
                       GetSQLValueString($arrayhorarios[$i+1], "date"),
                       GetSQLValueString($arrayhorarios[$i+2], "date"),
					   GetSQLValueString(implode('-',array_reverse(explode('-',$arrayhorarios[$i+3]))), "date"),
					   GetSQLValueString(implode('-',array_reverse(explode('-',$arrayhorarios[$i+4]))), "date"),
					   GetSQLValueString($arrayhorarios[$i+5], "int"),
					   GetSQLValueString($nuevocodigoreserva, "text"));
                    
  mysql_select_db($database_conexion, $conexion);
  $Result3 = mysql_query($insertSQL, $conexion) or die(mysql_error());
 
	}
   
  if($insertarrecurso!=0)
  {
      $arrayrecursos=explode(',',$_POST['arrayrecursos']);
   
     for($i=0; $i<count($arrayrecursos)-1;$i+=3)
	 {
		    
        $insertSQL = sprintf("INSERT INTO recursos_reservados (grupo, subgrupo, cantidad, No_reserva, Software) VALUES (%s, %s, %s, %s, %s)",
                
                       GetSQLValueString($arrayrecursos[$i], "int"),
                       GetSQLValueString($arrayrecursos[$i+1], "int"),
                       GetSQLValueString($arrayrecursos[$i+2], "int"),
					   GetSQLValueString($nuevocodigoreserva, "text"),
					   GetSQLValueString($arrayrecursos[$i+3], "text"));
					   
                    
      mysql_select_db($database_conexion, $conexion);
      $Result4 = mysql_query($insertSQL, $conexion) or die(mysql_error());
 
	}
  
  }
 
  if($Result1 > 0 && $Result2 > 0 && $Result3 > 0 )
  {
	  $respuesta=array("error"=>0,"reserva"=> $nuevocodigoreserva,"fechahorareserva"=>$fecha);
	  echo json_encode($respuesta); 
  }
  
  else
  {
	   $respuesta=array("error"=>1);
	  echo json_encode($respuesta); 
	  
  }
 
}// cierro isset
  
?>

