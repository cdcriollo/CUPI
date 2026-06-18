<?php

require_once("../../../dompdf/dompdf_config.inc.php");

// We check wether the user is accessing the demo locally
//$local = array("::1", "127.0.0.1");
//$is_local = in_array($_SERVER['REMOTE_ADDR'], $local);

if ( isset( $_POST["html"] ) ) {

  if ( get_magic_quotes_gpc() )
    $_POST["html"] = stripslashes($_POST["html"]);
  
  $dompdf = new DOMPDF();
  $dompdf->load_html($_POST["html"]);
  $dompdf->set_paper("b4", "landscape");
  $dompdf->render();
  $dompdf->stream("Informe Listado de Clase.pdf");
  //$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));

  exit(0);
}
?>
