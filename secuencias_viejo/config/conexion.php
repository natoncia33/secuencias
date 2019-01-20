<?php 
/*
$servidorbd = 'sql211.55freehost.com';
$usuariobd = 'hzree_19182551';
$passwordbd = 'notieneclaveparaestesoftware';
$basededatos = 'hzree_19182551_secuencias';
*/
$servidorbd = 'localhost';
$usuariobd = 'root';
$passwordbd = '';
$basededatos = 'secuencias';
$mysqli = new mysqli ($servidorbd,$usuariobd,$passwordbd,$basededatos);
if (mysqli_connect_errno()){
echo "error".mysqli_connect_errno();}else{
if($mysqli){
mysqli_set_charset($mysqli,'utf8');
}
}
 ini_set('date.timezone', 'America/Bogota');
 date_default_timezone_set('America/Bogota');
$results = $mysqli->query("SET session wait_timeout=28800", FALSE);//solución error 2006
$results = $mysqli->query("SET session interactive_timeout=28800", FALSE);//solución error 2006
/*URL Raiz*/
$url_raiz = str_replace("\\","/",dirname(__FILE__));
$url_raiz = str_replace($_SERVER['DOCUMENT_ROOT'],"",$url_raiz);
$url_raiz = "//".$_SERVER['SERVER_NAME']."/".$url_raiz;
$url_raiz =  str_replace("config","",$url_raiz);

 ?>