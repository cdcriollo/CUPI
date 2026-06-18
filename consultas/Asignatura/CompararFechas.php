<?php 

$fecha1 = $_POST['fechainicial'];
$fecha2 = $_POST['fechafinal'];

list($dia,$mes,$año)=explode('-',$fecha1);
$fecha1=mktime(0,0,0,$mes,$dia,$año);

list($dia1,$mes1,$año1)=explode('-',$fecha2);
$fecha2=mktime(0,0,0,$mes1,$dia1,$año1);

if ($fecha1 > $fecha2)
{
  echo 1; 
}

else
{
  echo 0;	
}


?>