
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


if(isset($_POST['sala'], $_POST['idhorario']))
{
	
	$sala=$_POST['sala'];
	$idhorario=$_POST['idhorario'];
	
	//consulta que trae la sala anterior que tenia la reserva
	mysql_select_db($database_conexion, $conexion);
	$query_JRSala = "SELECT sala FROM horario WHERE idhorario = '$idhorario'";
	$JRSala = mysql_query($query_JRSala, $conexion) or die(mysql_error());
	$row_JRSala = mysql_fetch_assoc($JRSala);
	$totalRows_JRSala = mysql_num_rows($JRSala);
	$salaant= $row_JRSala["sala"];
	
	// Consulta que trae los computadores de la sala especificada
	mysql_select_db($database_conexion, $conexion);
	$query_JRPcs = "select Nopc from pcs where numSala=$sala order by Nopc";
	mysql_query("SET NAMES 'utf8'");
	$JRPcs = mysql_query($query_JRPcs, $conexion) or die(mysql_error());
	$row_JRPcs = mysql_fetch_assoc($JRPcs);
	$totalRows_JRPcs = mysql_num_rows($JRPcs);
	?>
	
	<?php 
	$totalpcs = mysql_num_rows($JRPcs);  
        
// Se almacena en un array los computadores de la sala especificada		
   if ($totalpcs > 0)  
    {  
       do {  
    

     $pcs[0]=$row_JRPcs['Nopc'];

      for ($i=1; $i<$totalpcs; $i++) 
	  {  
       $comp = mysql_fetch_array($JRPcs);  
       $pcs[$i] = $comp["Nopc"];  
      }  
	
	   } while ($row_JRPcs = mysql_fetch_assoc($JRPcs));
	   $rows = mysql_num_rows($JRPcs);
		if($rows > 0) {
		  mysql_data_seek($JRPcs, 0);
		  $row_JRPcs = mysql_fetch_assoc($JRPcs);
		 } 
	  
		$cadenapcs=implode(',',$pcs);
		mysql_free_result($JRPcs);
	 
  }
  
 
   // consulta que trae el numero de pcs que hay disponibles en la sala o salas
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRpcssala = "SELECT count(Nopc) As NoPcsSala FROM pcs WHERE numSala = $sala";
	mysql_query("SET NAMES 'utf8'");
	$JRpcssala = mysql_query($query_JRpcssala, $conexion) or die(mysql_error());
	$row_JRpcssala = mysql_fetch_assoc($JRpcssala);
	$totalRows_JRpcssala = mysql_num_rows($JRpcssala);
    $pcsSala= $row_JRpcssala['NoPcsSala'];
	mysql_free_result($JRpcssala);
	
	
	// consulta que trae el numero de estudiante matriculados en una asignatura y un grupo
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRPcsMatriculados = "select count(codUsuario) As CompMatriculados from matricula where idHorario=$idhorario and Estado='Activa'";
	
	mysql_query("SET NAMES 'utf8'");
	$JRPcsMatriculados = mysql_query($query_JRPcsMatriculados, $conexion) or die(mysql_error());
	$row_JRPcsMatriculados = mysql_fetch_assoc($JRPcsMatriculados);
	$totalRows_JRPcsMatriculados = mysql_num_rows($JRPcsMatriculados);
	$NoPcsMatriculados=$row_JRPcsMatriculados['CompMatriculados'];
	mysql_free_result($JRPcsMatriculados);
 
	 // verifica si la se ha cambiado
	   if($sala != $salaant){
		   
	   //consulta que trae los usuarios matriculados en un horario
	   mysql_select_db($database_conexion, $conexion);
	   $query_JRMatriculados = "SELECT * FROM matricula WHERE idHorario = $idhorario order by pc";
	   $JRMatriculados = mysql_query($query_JRMatriculados, $conexion) or die(mysql_error());
	   $row_JRMatriculados = mysql_fetch_assoc($JRMatriculados);
	   $totalRows_JRMatriculados = mysql_num_rows($JRMatriculados);
	   
	   if($totalRows_JRMatriculados > 0){
		
		 $i=0;
		 
		 // Convierto un array de strings a un array de posiciones 
          $arraypcs=explode(",",$cadenapcs);
		 
			do{
			  	// Actualiza los computadores de los usuarios dependiendo de la sala   
			    $updateSQL = sprintf("UPDATE matricula SET pc=%s WHERE pc=%s and idHorario=%s",
                      
                 GetSQLValueString($arraypcs[$i], "int"),
				 GetSQLValueString($row_JRMatriculados["pc"], "int"),
                 GetSQLValueString($idhorario, "int"));

				 mysql_select_db($database_conexion, $conexion);
				 $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
				 $i++;  	
				
			}while($row_JRMatriculados = mysql_fetch_assoc($JRMatriculados));		 
			
			//Obtiene el numero de filas afectadas
			$resultado= mysql_affected_rows();
			
			if($resultado > 0)
			 {  
			    // Devuelve un json con el error 
				$error=array("error"=>1); 
				echo json_encode($error);
			 }
			 else
			 {
				 // Devuelve un json con el error   
				$error=array("error"=>0); 
			    echo json_encode($error);
			 }
			 
			 //Libera el resultado
			 mysql_free_result($JRMatriculados);
	  
	   }    
   }
}// cierro isset


  mysql_free_result($JRSala);

?>
