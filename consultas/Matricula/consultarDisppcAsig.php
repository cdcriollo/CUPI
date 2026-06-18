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


if(isset($_POST['sala'], $_POST['asignatura'], $_POST['grupo'],$_POST['reserva']))
{
	
	$sala=$_POST['sala'];
	$asignatura=$_POST['asignatura'];
	$grupo=$_POST['grupo'];
	$reserva=$_POST['reserva'];
	
	 mysql_select_db($database_conexion, $conexion);
	 $query_JRSalasMatricula = "SELECT sala FROM horario WHERE codAsignatura = '$asignatura' and codGrupo=$grupo and No_reserva = '$reserva' and estadohorario='activo'";
	 $JRSalasMatricula = mysql_query($query_JRSalasMatricula, $conexion) or die(mysql_error());
	 $row_JRSalasMatricula = mysql_fetch_assoc($JRSalasMatricula);
	 $totalRows_JRSalasMatricula = mysql_num_rows($JRSalasMatricula);
	 
	 if ($totalRows_JRSalasMatricula > 0) 
	 {
		do {  
		  
	
		   $salas[0]=$row_JRSalasMatricula['sala'];
	
			for ($i=1; $i<$totalRows_JRSalasMatricula; $i++) 
			{  
			  $salasasignatura = mysql_fetch_array($JRSalasMatricula);  
			  $salas[$i] = $salasasignatura["sala"];  
		    }  
		 
		 } while ($row_JRSalasMatricula = mysql_fetch_assoc($JRSalasMatricula));
		$rows = mysql_num_rows($JRSalasMatricula);
		 if($rows > 0) 
		 {
		   mysql_data_seek($JRSalasMatricula, 0);
		    $row_JRSalasMatricula = mysql_fetch_assoc($JRSalasMatricula);
		 } 
	  
		 $cadenasalas=implode(',',$salas); 
	 }
	
	
	mysql_select_db($database_conexion, $conexion);
	$query_JRAsignarpc = "select pc from matricula where codAsignatura='$asignatura' and grupo=$grupo and No_reserva = '$reserva' and pc <> 0 and Estado='Activa'";
	mysql_query("SET NAMES 'utf8'");
	$JRAsignarpc = mysql_query($query_JRAsignarpc, $conexion) or die(mysql_error());
	$row_JRAsignarpc = mysql_fetch_assoc($JRAsignarpc);
	$totalRows_JRAsignarpc = mysql_num_rows($JRAsignarpc);?>
		
  <html>
   <head>
     <script type="text/javascript">

     $("#alertas" ).dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			modal:true		
		});
		
		
		function alertas(content,title,type)
		{			
			$("#alertas").empty();			
			$("#alertas").dialog( "option", "title", title );
			if(type=="done")
			{
				$("#alertas").html('<img src="images/done.png" style="float:left; padding:5px;" />');
			}
			else if(type=="error")
			{
				$("#alertas").html('<img src="images/error.png" style="float:left; padding:5px;" />');
			}
			else if(type=="inform")
			{
				$("#alertas").html('<img src="images/inform.png" style="float:left; padding:5px;" />');
			}
			$("#alertas").append(content);
			$("#alertas").dialog("open");
		}

    </script>
   </head>
   <body>
	    
		
      <?php  if ($totalRows_JRAsignarpc > 0)  
       {  
		   do {  
		  ?>
		  <?php
	
		   $pcs[0]=$row_JRAsignarpc['pc'];
	
			for ($i=1; $i<$totalRows_JRAsignarpc; $i++) 
			{  
			 $pcmatricula = mysql_fetch_array($JRAsignarpc);  
			 $pcs[$i] = $pcmatricula["pc"];  
		   }  
		 ?>
		<?php
		} while ($row_JRAsignarpc = mysql_fetch_assoc($JRAsignarpc));
		$rows = mysql_num_rows($JRAsignarpc);
		 if($rows > 0) {
		   mysql_data_seek($JRAsignarpc, 0);
		   $row_JRAsignarpc = mysql_fetch_assoc($JRAsignarpc);
		 } 
	  
		 $cadenapcs=implode(',',$pcs); 
		 mysql_free_result($JRAsignarpc);
	
		mysql_select_db($database_conexion, $conexion);
		$query_JRListapc = "select Nopc, numSala from pcs where numSala IN ($cadenasalas) and Nopc NOT IN($cadenapcs) and estado <> 'Docente'";
		mysql_query("SET NAMES 'utf8'");
		$JRListapc = mysql_query($query_JRListapc, $conexion) or die(mysql_error());
		$row_JRListapc = mysql_fetch_assoc($JRListapc);
		$totalRows_JRListapc = mysql_num_rows($JRListapc);


	
		 if ($totalRows_JRListapc > 0)  
		 {  ?>
		
        
        <div  style="overflow:auto; width:340px; min-height:0px; max-height:200px; margin-top:auto; margin-bottom:15px;">
        
         <?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>
		<table  border="1" class="tableUI"  width="300" style="margin-left:20px; margin-bottom:10px; margin-top:10px;" cellpadding="0"   cellspacing="0">
   <tr>
    <th>Seleccione</th>
    <th>Pc</th>
    <th>Sala</th>
   </tr> 
		<?php do { ?>
	
    <tr>
      <td><input type="checkbox" value="<?php echo $row_JRListapc['Nopc'];?>" class="selectpcasig"></td>
      <td><?php echo $row_JRListapc['Nopc']; ?></td>
      <td><?php echo $row_JRListapc['numSala']; ?></td>
    </tr>
        
	   <?php
	   } while ($row_JRListapc = mysql_fetch_assoc($JRListapc));?>
	  </table>
	  </div>
	   
		 <?php mysql_free_result($JRListapc);
	  }
	  else 
	  {
	   echo'<script type="text/javascript">alertas("No hay computadores disponibles para el cambio","Modificar Matricula Asignatura","error");</script>      ';
	  }
    }
	
	else 
	  {
	    echo'<script type="text/javascript">alertas("La asignatura no ha sido matriculada o se encuentra inactiva","Modificar Matricula Asignatura","error");</script>      ';
	  }
  ?>

 </body>
 </html>

<?php
   mysql_free_result($JRSalasMatricula);
   mysql_close($conexion);
  ?>

<?php }?>