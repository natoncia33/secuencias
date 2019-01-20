<?php 
header("php/index.php");
ob_start();
?>
Bienvenido a Secuencias
<?php $contenido = ob_get_contents();
ob_clean();
include ("plantilla/home.php");
 ?>