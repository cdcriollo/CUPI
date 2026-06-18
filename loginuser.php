<?php require_once('Connections/conexion.php'); ?>

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

$password=isset($_POST["contrasena"])? $_POST["contrasena"]: ''; 
$usuario=isset($_POST["nombreUsuario"])? $_POST["nombreUsuario"]:''; 

mysql_select_db($database_conexion, $conexion);
$query_queryusuarios ="SELECT nombreUsuario, contrasena, estado, Nombre, perfil FROM usuarios_aplicacion WHERE nombreUsuario='$usuario' AND contrasena='$password'";
$queryusuarios = mysql_query($query_queryusuarios, $conexion) or die(mysql_error());
$row_queryusuarios = mysql_fetch_assoc($queryusuarios);
$totalRows_queryusuarios = mysql_num_rows($queryusuarios);




//Comprobar que nos envien las variables
if(!empty($_POST["nombreUsuario"]))
{ 
  $estado=$row_queryusuarios['estado'];
  $perfil=$row_queryusuarios['perfil'];
  $nombre=$row_queryusuarios['Nombre'];
  sleep(3); //only for debug

if($totalRows_queryusuarios == 0)
{
	echo 0; //Dato clave, de esto depende el Formulario AJAX
}
else
{ 
	session_start();
	
	
            
	

  if($_POST["nombreUsuario"] == "$usuario" && $_POST["contrasena"] == "$password" && $estado == 'activo')
  {
	  
	$_SESSION['perfil']=$perfil;//Perfil
	$_SESSION['nombreusuario']=$usuario;//Nombre Usuario 
	$_SESSION['contrasena']=$password;//Contraseña
	$_SESSION['nombre']=$nombre;
	
   echo 1; //Dato clave, de esto depende el Formulario AJAX
	//echo $_SESSION['perfil'];
	
  }
  else
  {
    echo 0; //Dato clave, de esto depende el Formulario AJAX
  }
}
 

}
else if ((bool) $_GET['exito'])
{  

  $resultMenuUrlName="principal.php";
  echo "<META HTTP-EQUIV=Refresh CONTENT=0;URL=$resultMenuUrlName>";

}
else
{
  include("logearse.php");
}


mysql_free_result($queryusuarios);
?>
