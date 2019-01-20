<?php 
ob_start();
@session_start();
if (!isset($_SESSION['email'])){
 if ($_SESSION['tipo']!="Administrador"){
    header("Location: login.php"); 
 }
}
#print_r($_FILES);
 ?>
<center>
<script>
function span_img(){
var inp = '<img id="img_img_avatar" height="80"><input class=""name="img_avatar"type="file" id="img_avatar" onchange="valida_adjunto_img(this);sugerir_nombre_avatar();mostrarImagen(this);" required >';	
document.getElementById('span_img').innerHTML=inp;
}

</script>
<?php 
require(dirname(__FILE__)."/../config/conexion.php");
require_once(dirname(__FILE__)."/../config/funciones.php");
function buscar_avatar($datos="",$reporte=""){
require(dirname(__FILE__)."/../config/conexion.php");
//inicio parametros paginacion
require_once ("../lib/Zebra_Pagination/Zebra_Pagination.php");
if (isset($_COOKIE['numeroresultados_avatar']) and $_COOKIE['numeroresultados_avatar']=="")  $_COOKIE['numeroresultados_avatar']="0";
$resultados = ((isset($_COOKIE['numeroresultados_avatar']) and $_COOKIE['numeroresultados_avatar']!="" ) ? $_COOKIE['numeroresultados_avatar'] : 10);
$paginacion = new Zebra_Pagination();
$paginacion->records_per_page($resultados);
$paginacion->records_per_page($resultados);

$cookiepage="page_avatar";
$funcionjs="buscar();";$paginacion->fn_js_page("$funcionjs");
$paginacion->cookie_page($cookiepage);
$paginacion->padding(false);
if (isset($_COOKIE["$cookiepage"])) $_GET['page'] = $_COOKIE["$cookiepage"];
//fin parametros paginacion
$sql = "SELECT `avatar`.`id_avatar`, `avatar`.`nombre_avatar`, `avatar`.`img_avatar` FROM `avatar`   ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' WHERE ';
foreach ($datos as $id => $dato){
$sql .= ' LOWER(`avatar`.`nombre_avatar`) LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
$sql .=  " ORDER BY ";
if (isset($_COOKIE['orderbyavatar']) and $_COOKIE['orderbyavatar']!=""){ $sql .= "`avatar`.`".$_COOKIE['orderbyavatar']."`";
}else{ $sql .= "`avatar`.`id_avatar`";}
if (isset($_COOKIE['orderad_avatar'])){
$orderadavatar = $_COOKIE['orderad_avatar'];
$sql .=  " $orderadavatar ";
}else{
$sql .=  " desc ";
}
$consulta_total_avatar = $mysqli->query($sql);
$total_avatar = $consulta_total_avatar->num_rows;
$paginacion->records($total_avatar);
if ($reporte=="") $sql .=  " LIMIT " . (($paginacion->get_page() - 1) * $resultados) . ", " . $resultados;
/*echo $sql;*/
$consulta = $mysqli->query($sql);
$numero_avatar = $consulta->num_rows;
$minimo_avatar = (($paginacion->get_page() - 1) * $resultados)+1;
$maximo_avatar = (($paginacion->get_page() - 1) * $resultados) + $resultados;
if ($maximo_avatar>$numero_avatar) $maximo_avatar=$numero_avatar;
$maximo_avatar += $minimo_avatar-1;
if ($reporte=="") echo "<p>Resultados de $minimo_avatar a $maximo_avatar del total de ".$total_avatar." en página ".$paginacion->get_page()."</p>";
 ?>
<div align="center">
<table border="1" id="tbavatar">
<thead>
<tr>
<th>Nombre Avatar</th>
<th>Imágen Avatar</th>
<?php if ($reporte==""){ ?>
<th colspan="2"><form id="formNuevo" name="formNuevo" method="post" action="avatar.php">
<input name="cod" type="hidden" id="cod" value="0">
<input type="image" src="<?php echo $url_raiz ?>img/nuevo.png" name="submit" id="submit" value="Nuevo" title="Nuevo">
</form>
</th>
<?php } ?>
</tr>
</thead><tbody>
<?php 
while($row=$consulta->fetch_assoc()){
 ?>
<tr>
<td><?php echo $row['nombre_avatar']?></td>
<td><img height="80" src="../img/Avatars/<?php echo $row['img_avatar']?>"></td>
<?php if ($reporte==""){ ?>
<td>
<form id="formModificar" name="formModificar" method="post" action="avatar.php">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_avatar']?>">
<input type="image" src="<?php echo $url_raiz ?>img/modificar.png" name="submit" id="submit" value="Modificar" title="Modificar">
</form>
</td>
<td>
<input type="image" src="../img/eliminar.png" onClick="confirmeliminar('avatar.php',{'del':'<?php echo $row['id_avatar'];?>'},'<?php echo $row['nombre_avatar'];?>');" value="Eliminar" title="Eliminar">
</td>
<?php } ?>
</tr>
<?php 
}/*fin while*/
 ?>
</tbody>
</table>
<?php if ($reporte=="") $paginacion->render2();?>
</div>
<?php 
}/*fin function buscar*/
if (isset($_GET['buscar'])){
buscar_avatar($_POST['datos']);
exit();
}

if (isset($_POST['del'])){
 /*Instrucción SQL que permite eliminar en la BD*/ 
$sql = 'DELETE FROM avatar WHERE id_avatar="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
$sqlimg = "SELECT `img_avatar` FROM `avatar` WHERE id_avatar='".$_POST['del']."'";
$consulta = $mysqli->query($sqlimg);
if($row=$consulta->fetch_assoc()){
$eliminar = "../img/Avatars/".$row['img_avatar'];
}
if ($eliminar = $mysqli->query($sql)){
@unlink ($eliminar);
 /*Validamos si el registro fue eliminado con éxito*/ 
 ?>
<script>alert('Registro eliminado');</script>
<meta http-equiv="refresh" content="1; url=avatar.php" />
<?php 
}else{
?>
<script>alert('Eliminación fallida, por favor compruebe que la usuario no esté en uso');</script>
<meta http-equiv="refresh" content="2; url=avatar.php" />
<?php 
}
}
 ?>
<center>
<h1>Avatar</h1>
</center><?php 
if (isset($_POST['submit'])){
if ($_POST['submit']=="Registrar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$sql = "INSERT INTO avatar (`id_avatar`, `nombre_avatar`, `img_avatar`) VALUES ('".$_POST['id_avatar']."', '".$_POST['nombre_avatar']."', '')";
 /*echo $sql;*/
if ($insertar = $mysqli->query($sql)) {
$id_avatar = $mysqli->insert_id;
@mkdir("../img/Avatars");
$partes_nombre = explode (".",$_FILES['img_avatar']['name']);
$ext = end($partes_nombre);
if (copy($_FILES['img_avatar']['tmp_name'],"../img/Avatars/".$id_avatar.".".$ext))
$sqlav = "UPDATE avatar SET img_avatar='".$id_avatar.".".$ext."'WHERE  id_avatar = '".$id_avatar."'";
if ($insertar = $mysqli->query($sqlav)){
 /*Validamos si el registro fue ingresado con éxito*/ 
 ?>
Registro exitoso
<meta http-equiv="refresh" content="1; url=avatar.php" />
<?php 
 }else{ 
 ?>
Registro fallido
<meta http-equiv="refresh" content="1; url=avatar.php" />
<?php 
}
}
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo" or $_POST['submit']=="Modificar"){
if ($_POST['submit']=="Modificar"){
$sql = "SELECT `id_avatar`, `nombre_avatar`, `img_avatar` FROM `avatar` WHERE id_avatar ='".$_POST['cod']."' Limit 1"; 
$consulta = $mysqli->query($sql);
 /*echo $sql;*/
$row=$consulta->fetch_assoc();

$textoh1 ="Modificar";
$textobtn ="Actualizar";
}
if ($_POST['submit']=="Nuevo"){
$textoh1 ="Registrar";
$textobtn ="Registrar";
}
 ?><div class="col-md-3"></div><form class="col-md-6" id="form1" name="form1" method="post" action="avatar.php" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="<?php echo 1024 * (1024 * 4)?>" />
<h1><?php echo $textoh1 ?></h1>
<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_avatar']))  echo $row['id_avatar'] ?>" size="120" required></p>
<?php 
echo '<p><input class=""name="id_avatar"type="hidden" id="id_avatar" value="';if (isset($row['id_avatar'])) echo $row['id_avatar'];echo '"';echo '></p>';
echo '<div class="form-group"><label for="nombre_avatar">Nombre Avatar:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label><span id="txtnombre_avatar" style="float:right"></span><input class="form-control" name="nombre_avatar" type="text" id="nombre_avatar" value="';if (isset($row['nombre_avatar'])) echo $row['nombre_avatar'];echo '"';echo ' required onchange="valida_existe_avatar(this.value)"></div>';
?><div class="form-group"><label for="img_avatar">Imágen Avatar:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>
<span id="span_img">
<?php if (isset($row['img_avatar'])){
echo '<img height="80" src="../img/Avatars/'.$row['img_avatar'].'"><br><input onclick="span_img()" type="button" value="Cambiar Imágen">';
}else{
echo '<img id="img_img_avatar" height="80">';
echo '<input class="form-control" name="img_avatar" type="file" id="img_avatar" onchange="valida_adjunto_img(this);sugerir_nombre_avatar();mostrarImagen(this);valida_existe_avatar(document.getElementById(\'nombre_avatar\').value)" required>';
}
?>
</span>
</div>
<div class="form-group">
<input type="submit" name="submit" id="submit" value="<?php echo $textobtn?>">
</div>
</form><div class="col-md-3"><?php
} /*fin mixto*/ 
if ($_POST['submit']=="Actualizar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$cod = $_POST['cod'];
 /*Instrucción SQL que permite insertar en la BD */ 
$imgavatar = "";
$partes_nombre = explode (".",$_FILES['img_avatar']['name']);
$ext = end($partes_nombre);
if (isset($_FILES['img_avatar'])) $imgavatar = ", img_avatar='".$cod.".".$ext."' ";
$sql = "UPDATE avatar SET nombre_avatar='".$_POST['nombre_avatar']."' ".$imgavatar." WHERE  id_avatar = '".$cod."';";
/* echo $sql;*/ 
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/ 
$actualizar = $mysqli->query($sql);
if ($mysqli->affected_rows>0) {
if (isset($_FILES['img_avatar'])){

@unlink("../img/Avatars/".$cod.".".$ext);
copy($_FILES['img_avatar']['tmp_name'],"../img/Avatars/".$cod.".".$ext);
}
 /*Validamos si el registro fue ingresado con éxito*/
 ?>
<script>
alert('Modificación exitosa');
document.location.href="avatar.php";
</script>
<?php
 }else{
?>
<script>
alert('Modificacion fallida');
document.location.href="avatar.php";
</script>
<?php
}
} /*fin Actualizar*/ 
 }else{ 
 ?>

<center>
<b><label>Buscar: </label></b><input placeholder="Buscar por palabra clave" title="Buscar por Nombre" type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados por página:</label></b>
<input onKeyPress="return soloNumeros(event)" type="number" min="0" id="numeroresultados_avatar" placeholder="Cant." title="Cantidad de resultados" value="<?php $no_resultados = ((isset($_COOKIE['numeroresultados_avatar']) and $_COOKIE['numeroresultados_avatar']!="" ) ? $_COOKIE['numeroresultados_avatar'] : 10); echo $no_resultados; ?>" onkeyup="grabarcookie('numeroresultados_avatar',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_avatar',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_avatar',this.value);buscar(document.getElementById('buscar').value);" size="4" style="width: 60px;">
<button title="Orden Ascendente" onclick="grabarcookie('orderad_avatar','ASC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-up"></span></button><button title="Orden Descendente" onclick="grabarcookie('orderad_avatar','DESC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-down"></span></button>
</center>
<span id="txtsugerencias">
<?php 
buscar_avatar();
 ?>
</span>
<?php 
}/*fin else if isset cod*/
echo '</center>';
 ?>
<script>
//document.getElementById('menu_avatar').className ='active '+document.getElementById('menu_avatar').className;
</script>
<?php $contenido = ob_get_contents();
ob_clean();
include (dirname(__FILE__)."/../plantilla/home.php");
 ?>
