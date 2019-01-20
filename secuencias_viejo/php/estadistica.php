<?php
ob_start();
require_once ("../config/funciones.php");
$sql23 = "SELECT `tipo` as Tipo,`avatar` as Avatar FROM `usuarios`";
resultados_graficar_tabla(consultar_datos($sql23,true),'Tipo,Avatar');
$contenido = ob_get_clean();
require_once ("../plantilla/home.php");
?>