<?php
include ("../config/conexion.php");
ob_start();
@session_start();
	foreach(glob(dirname(__FILE__)."/*.*") as $nombre){
	$info = new SplFileInfo($nombre);
    $archivo = $info->getBasename();
    $formato = $info->getExtension();
	$nombre = str_replace(".".$formato,"",$archivo);
	if ($archivo!="index.php"){
	$ruta = $url_raiz."/audio/".$archivo;
	?>
	<span style="">
	<label title="<?php echo $nombre ?>">
        <audio controls>
        <source src="<?php echo $ruta ?>" type="audio/<?php echo $formato ?>">
        <a src="<?php echo $ruta ?>"><?php echo $archivo ?></a>
        </audio></label>
	</span>
<?php }
}
?>
<?php $contenido = ob_get_contents();
ob_clean();
include ("../plantilla/home.php");
?>