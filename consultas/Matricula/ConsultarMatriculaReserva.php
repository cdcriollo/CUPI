
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



$styleth=' style="padding: 5px;
        font-size: 12px;
		background-color:#DADADA;
        font:Arial, Helvetica, sans-serif;
		border-style: solid;
        border-color: #000000;
		color: #000 ;
        border-width: 1px;"';
        
		
 $styletr='style="font-size: 12px;
        color: #34484E;
        font:Arial, Helvetica, sans-serif;
		border-style: solid;
        border-color: #000000;
        border-width: 1px;
		text-align:center;"';
			 
 $stylecabecera='style="
 background-color:#DADADA;
 font:Arial, Helvetica, sans-serif;
 border-right-style:solid; 
 border-right-width:1px; 
 border-right-color:black; 
 border-left-style:solid; 
 border-left-width:1px; 
 border-left-color:black; 
 border-top-style:solid;
 border-top-width:1px;
 border-top-color:black;
 border-bottom-style:solid;
 border-bottom-width:1px;
 border-bottom-color:black;
  "';
 		
if (isset($_POST['codigo'],$_POST['grupo'],$_POST['nombre']))
{
  
  
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
$nombre=$_POST['nombre'];

//Realizo una consulta a la tabla matricula para traer la lista de los usuarios matriculados en esa asignatura 
mysql_select_db($database_conexion, $conexion);
$query_JRCmatriculaA = "select u.nombreUsu, u.apellidos, m.codUsuario, m.pc,p.numSala,m.idHorario, m.No_reserva from matricula m  inner join usuarios u on (m.codUsuario=u.codUsuario)  inner join pcs p on (m.pc=p.Nopc)  where m.codAsignatura= '$codigo' and m.grupo=$grupo  and m.Estado='Activa' order by No_reserva, pc";
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


<table class="estmatriculados tableUI" width="600" style="margin-left:10px; margin-top:15px;"  border="1" cellpadding="0" cellspacing="0" >
  
  <tr>
    <td colspan="2" <?php echo $stylecabecera?>><strong>Codigo:</strong>&nbsp&nbsp<?php echo $codigo; ?></td>
    <td <?php echo $stylecabecera?>> <strong>Grupo:</strong>&nbsp&nbsp<?php echo $grupo; ?> </td>
    <td colspan="4" <?php echo $stylecabecera?>><strong>Nombre:</strong>&nbsp&nbsp<?php echo $nombre; ?></td>
  </tr>
 
  <tr>
    <th <?php echo  $styleth ?>>No</th> 
    <th <?php echo  $styleth ?>>No Reserva</th> 
    <th <?php echo $styleth ?>>Codigo</th>
    <th <?php echo $styleth ?>>Nombre</th>
    <th <?php echo $styleth ?>>Computador</th>
    <th <?php echo  $styleth ?>>Sala</td>
    <th <?php echo $styleth ?>>Horario</th>
  </tr>
  
  <?php $i=1 ?>
  <?php do { ?>
  
	 <tr>
      <td <?php echo  $styletr ?>><?php echo $i;?></td>
      <td <?php echo  $styletr ?>><?php echo $row_JRCmatriculaA['No_reserva']; ?></td>
      <td <?php echo $styletr ?>><?php echo $row_JRCmatriculaA['codUsuario']; ?></td>
      <?php $user= $row_JRCmatriculaA['nombreUsu']." ".$row_JRCmatriculaA['apellidos'] ?>
      <td <?php echo $styletr ?>><?php echo $user; ?></td>
      <td <?php echo  $styletr ?>><?php echo $row_JRCmatriculaA['pc']; ?></td>
      <td <?php echo  $styletr ?>><?php echo $row_JRCmatriculaA['numSala']; ?></td>
      <?php $idhorario=$row_JRCmatriculaA['idHorario']; ?>
      <?php  $horario= ObtenerHorario($idhorario,$database_conexion, $conexion); ?>
      <td <?php echo $styletr ?>> <?php echo $horario;?></td>
      <?php $i++;?>
    </tr>	
	
    <?php } while ($row_JRCmatriculaA = mysql_fetch_assoc($JRCmatriculaA)); ?>
</table>	
</div>	
<?php }

else 
{
   echo'<script type="text/javascript">alertas("La asignatura no tiene estudiantes matriculados","Consultar Matricula Asignatura","error");</script> ';
} 

?>
       
       
     <?php
	    // Libero resultados y conexion
        mysql_free_result($JRCmatriculaA);
		mysql_close($conexion);
     ?>  
<?php } ?>
</body>
</html>