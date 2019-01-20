<?php 
if (!isset($tamano_dom)) $tamano_dom="letter";
if (!isset($orientacion_dom)) $orientacion_dom='portrait';//landscape/portrait
if (!isset($nombre_dom)) $nombre_dom="archivo";
if (!isset($adjunto_dom)) $adjunto_dom = false;
if (!isset($print)) $print=true;
require_once(__DIR__."/dompdf/autoload.inc.php");
use Dompdf\Dompdf;
$html_dom = ob_get_clean();
if ($print==false){
echo $html_dom;
exit();
}
$dompdf = new Dompdf();
$dompdf->load_html($html_dom);
$dompdf->set_paper($tamano_dom,$orientacion_dom);//Esta línea es para hacer la página del PDF más grande //landscape/portrait
$dompdf->render();
$dompdf->stream("$nombre_dom.pdf", array("Attachment" => $adjunto_dom));
exit(0);