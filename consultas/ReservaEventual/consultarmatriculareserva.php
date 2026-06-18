
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


// Funcion que recibe un horario y lo transforma en una cadena que contiene el horario de la asignatura
function ObtenerHorario($idhorario,$database_conexion, $conexion)
{
	// Realizo consulta sobre la tabla horario
    mysql_select_db($database_conexion, $conexion);
	$query_JRHorario = "SELECT codDia, horainicio, horafinal FROM horario WHERE idHorario= $idhorario";
	$JRHorario = mysql_query($query_JRHorario, $conexion) or die(mysql_error());
	$row_JRHorario = mysql_fetch_assoc($JRHorario);
	$totalRows_JRHorario = mysql_num_rows($JRHorario);
	
	// Obtengo cada uno de los datos de la consuulta
	$dia= $row_JRHorario['codDia'];
	// Asigno a la varaiable $descripcionDia, lo que devuelva la función descripcionDia()
	$descripcionDia=descripcionDia($dia);
	$horainicio=$row_JRHorario['horainicio'];
	$horafinal=$row_JRHorario['horafinal'];
	// Asigno a la varaiable $horaformateada, lo que devuelva la función formatearHora()
	$horaformateada=formatearHora($horainicio,$horafinal);

	return $horarioclases= $descripcionDia." ".$horaformateada;
	mysql_free_result($JRHorario);
		
}

// Funcion que recibe un dia y lo transforma en una cadena de texto con la descripción del dia
function descripcionDia($diasemana)
{
	if($diasemana==1)
  {
	 $descripcion="Lunes";  
  }
  else if($diasemana==2)
  {
	$descripcion="Martes";  
  }
  else if($diasemana==3)
  {
	$descripcion="Miercoles";  
  }
  else if($diasemana==4)
  {
	$descripcion="Jueves";  
  }
  else if($diasemana==5)
  {
	$descripcion="Viernes";  
  }
  else if($diasemana==6)
  {
	$descripcion="Sabado";  
  }
  
  return $descripcion;
}

//Funcion que recibe una horainicial y una horafinal y lo simplifica ej: 10:00:00 lo transforma en 10:00
function formatearHora($horainicial,$horafinal)
{
	 $horainicio[1]=explode(':',$horainicial);
     $horaend[2]=explode(':',$horafinal);
	 return $horainicio[1][0].":".$horainicio[1][1]."-".$horaend[2][0].":".$horaend[2][1];
}


// Recibo las varaiables enviadas por POST		
$codigo=$_POST['codigo'];
$grupo=$_POST['grupo'];
$reserva=$_POST['reserva'];

//Realizo una consulta a la tabla matricula para traer la lista de los usuarios matriculados en esa asignatura 
mysql_select_db($database_conexion, $conexion);
$query_JRCmatriculaA = "select u.nombreUsu,m.codUsuario,m.pc,p.numSala,m.idHorario from matricula m  inner join usuarios u on (m.codUsuario=u.codUsuario)  inner join pcs p on (m.pc=p.Nopc)  where m.codAsignatura= '$codigo' and m.grupo=$grupo and m.No_reserva='$reserva' and m.Estado='Activa' order by pc,idHorario";
mysql_query("SET NAMES 'utf8'");
$JRCmatriculaA = mysql_query($query_JRCmatriculaA, $conexion) or die(mysql_error());
$row_JRCmatriculaA = mysql_fetch_assoc($JRCmatriculaA);
$totalRows_JRCmatriculaA = mysql_num_rows($JRCmatriculaA);
 
?>
<html>
<head>
<script type="text/javascript">

       // Configuracion de las alertas
      $("#alertas" ).dialog({
			autoOpen: false,
			show: "explode",
			hide: "explode",
			modal:true		
		});
		
		// Funcion para construir los mensajes que se le mostraran al usuario
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

<?php // Recorro el resultado y creo la tabla con la lista de los estudiantes matriculados en la asignatura ?>

<?php if($totalRows_JRCmatriculaA > 0){ ?>

<div id="tabladinamica" style="overflow:auto; width:630px; max-height:300px; min-height:0px; margin-top:auto;">

<?php echo '<script type="text/javascript">$(".tableUI").styleTable();</script> '; ?>

<table class="tableUI" width="600" style="margin-left:10px; margin-top:15px;"  border="1" id="addstudents">
  <tr>
    <th>Codigo</th>
    <th>Nombre</th>
    <th>Computador</th>
    <th>Sala</td>
    <th>Horario</th>
    
  </tr>
  <?php do { ?>
  
	 <tr>
      <td><?php echo $row_JRCmatriculaA['codUsuario']; ?></td>
      <td><?php echo $row_JRCmatriculaA['nombreUsu']; ?></td>
      <td><?php echo $row_JRCmatriculaA['pc']; ?></td>
      <td><?php echo $row_JRCmatriculaA['numSala']; ?></td>
      <?php $idhorario=$row_JRCmatriculaA['idHorario']; ?>
      <?php  $horario= ObtenerHorario($idhorario,$database_conexion, $conexion); ?>
      <td><?php echo $horario;?></td>
    </tr>	
	
    <?php } while ($row_JRCmatriculaA = mysql_fetch_assoc($JRCmatriculaA)); ?>
</table>	
</div>	
<?php }

else 
{
   echo'<script type="text/javascript">alertas("La asignatura no tiene estudiantes matriculados","Consultar Matricula Reserva","error");</script> ';
} 

?>
       
       
     <?php
	    // Libero resultados y conexion
        mysql_free_result($JRCmatriculaA);
		mysql_close($conexion);
     ?>  

</body>
</html>