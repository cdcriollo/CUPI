<?php
session_start();
//Vaciamos la sesión
 session_unset();
//Destruimos la sesión
session_destroy();
//Redirigimos hacia la pagina index.php
 header('Location:../../index.php');
 
 ?>