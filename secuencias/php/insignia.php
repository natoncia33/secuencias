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
var inp = '<img id="img_foto_insignia" height="80"><input class="" name="foto_insignia" type="file" onchange="valida_adjunto_img(this);sugerir_nombre_insignia();mostrarImagen(this);" id="foto_insignia" required >';	
document.getElementById('span_img').innerHTML=inp;
}
</script>
<?php 
require(dirname(__FILE__)."/../config/conexion.php");
 /*require_once(dirname(__FILE__)."/../config/funciones.php");*/
if (isset($_GET['pdf'])){
 ?>
<style>
 table {
    border-collapse: collapse;
}
table, td, th {
    border: 1px solid black;
}
</style>
 <h1>Insignia</h1><?php
buscar_insignia('','pdf');
#$print=false;
require(dirname(__DIR__)."/lib/convertir_dompdf.php");
exit();
}
function buscar_insignia($datos="",$reporte=""){
require(dirname(__FILE__)."/../config/conexion.php");
//inicio paginacion datos basicos
require_once ("../lib/Zebra_Pagination/Zebra_Pagination.php");
if (isset($_COOKIE['numeroresultados_insignia']) and $_COOKIE['numeroresultados_insignia']=="")  $_COOKIE['numeroresultados_insignia']="0";
$resultados = ((isset($_COOKIE['numeroresultados_insignia']) and $_COOKIE['numeroresultados_insignia']!="" ) ? $_COOKIE['numeroresultados_insignia'] : 10);
$paginacion = new Zebra_Pagination();
$paginacion->records_per_page($resultados);
$paginacion->records_per_page($resultados);
$cookiepage="page_insignia";
$funcionjs="buscar();";$paginacion->fn_js_page("$funcionjs");
$paginacion->cookie_page($cookiepage);
$paginacion->padding(false);
if (isset($_COOKIE["$cookiepage"])) $_GET['page'] = $_COOKIE["$cookiepage"];
//fin paginacion datos basicos
$sql = "SELECT `insignia`.`id_insignia`, `insignia`.`nombre_insignia`, `insignia`.`foto_insignia`, `insignia`.`aciertos` FROM `insignia` ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' WHERE ';
//inicio busqueda avanzada
if (isset($_COOKIE['busqueda_avanzada_insignia']) and $_COOKIE['busqueda_avanzada_insignia']=="true"){
 if (isset($_COOKIE['busqueda_av_insignianombre_insignia']) and $_COOKIE['busqueda_av_insignianombre_insignia']!=""){
 $sql .= ' LOWER(`insignia`.`nombre_insignia`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_insignianombre_insignia'], 'UTF-8').'%" and ';
 }
 if (isset($_COOKIE['busqueda_av_insigniafoto_insignia']) and $_COOKIE['busqueda_av_insigniafoto_insignia']!=""){
 $sql .= ' LOWER(`insignia`.`foto_insignia`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_insigniafoto_insignia'], 'UTF-8').'%" and ';
 }
 if (isset($_COOKIE['busqueda_av_insigniaaciertos']) and $_COOKIE['busqueda_av_insigniaaciertos']!=""){
 $sql .= ' LOWER(`insignia`.`aciertos`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_insigniaaciertos'], 'UTF-8').'%" and ';
 }
}
//fin busqueda avanzada
foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`insignia`.`nombre_insignia`)," ",`insignia`.`aciertos`) LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
 if (count($datos)>1 and count($datos)<>$cont){
 $sql .= " and ";
 }
}
$sql .=  " ORDER BY ";
if (isset($_COOKIE['orderbyinsignia']) and $_COOKIE['orderbyinsignia']!=""){ $sql .= "`insignia`.`".$_COOKIE['orderbyinsignia']."`";
}else{ $sql .= "`insignia`.`id_insignia`";}
if (isset($_COOKIE['orderad_insignia'])){
$orderadinsignia = $_COOKIE['orderad_insignia'];
$sql .=  " $orderadinsignia ";
}else{
$sql .=  " desc ";
}
$consulta_total_insignia = $mysqli->query($sql);
$total_insignia = $consulta_total_insignia->num_rows;
$paginacion->records($total_insignia);
if ($reporte=="") $sql .=  " LIMIT " . (($paginacion->get_page() - 1) * $resultados) . ", " . $resultados;
/*echo $sql;*/ 

$consulta = $mysqli->query($sql);
$numero_insignia = $consulta->num_rows;
$minimo_insignia = (($paginacion->get_page() - 1) * $resultados)+1;
$maximo_insignia = (($paginacion->get_page() - 1) * $resultados) + $resultados;
if ($maximo_insignia>$numero_insignia) $maximo_insignia=$numero_insignia;
$maximo_insignia += $minimo_insignia-1;
if ($reporte=="") echo "<p>Resultados de $minimo_insignia a $maximo_insignia del total de ".$total_insignia." en página ".$paginacion->get_page()."</p>";
 ?>
<div align="center">
<table style="border:1px solid black;border-collapse: collapse;" align="center" id="tbinsignia">
<thead>
<tr>
<th <?php  if(isset($_COOKIE['orderbyinsignia']) and $_COOKIE['orderbyinsignia']== "nombre_insignia"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyinsignia','nombre_insignia');buscar();" >Nombre Insignia</th>
<th <?php  if(isset($_COOKIE['orderbyinsignia']) and $_COOKIE['orderbyinsignia']== "foto_insignia"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyinsignia','foto_insignia');buscar();" >Foto Insignia</th>
<th <?php  if(isset($_COOKIE['orderbyinsignia']) and $_COOKIE['orderbyinsignia']== "aciertos"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyinsignia','aciertos');buscar();" >Aciertos</th>
<?php if ($reporte==""){ ?>
<th data-label="Nuevo" class="thbotones"><form id="formNuevo" name="formNuevo" method="post" action="insignia.php">
<input name="cod" type="hidden" id="cod" value="0">
<input type="image" name="submit" id="submit" value="Nuevo" title="Nuevo" src="<?php echo $url_raiz ?>img/nuevo.png">
</form>
</th>
<th data-label="PDF" class="thbotones"><form id="formNuevo" name="formNuevo" method="post" action="insignia.php?pdf">
<input name="cod" type="hidden" id="cod" value="0">
<input type="image" title="Descargar en pdf" src="<?php echo $url_raiz ?>img/pdf.png" name="submit" id="submit" value="PDF">
</form>
</th>
<?php } ?>
</tr>
</thead>
<tbody>
<?php 
while($row=$consulta->fetch_assoc()){
 ?>
<tr>
<td data-label='Nombre Insignia'><?php echo $row['nombre_insignia']?></td>
<td data-label='Foto Insignia'>
 <img width='80' src='../img/insignias/<?php echo $row['foto_insignia']?>' alt="">
 </td>
<td data-label='Aciertos'><?php echo $row['aciertos']?></td>
<?php if ($reporte==""){ ?>
<td data-label="Modificar"><form id="formModificar" name="formModificar" method="post" action="insignia.php">
<input type="image" src="<?php echo $url_raiz ?>img/modificar.png"name="submit" id="submit" value="Modificar" title="Modificar">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_insignia']; ?>">
</form></td>
<td data-label="Eliminar"><input type="image" src="<?php echo $url_raiz ?>img/eliminar.png" onClick="confirmeliminar('insignia.php',{'del':'<?php echo $row['id_insignia'];?>'},'<?php echo $row['nombre_insignia']." con ".$row['aciertos']." acierto(s) ";?>');" value="Eliminar" title="Eliminar">
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
buscar_insignia($_POST['datos']);
exit();
}

if (isset($_POST['del'])){
 /*Instrucción SQL que permite eliminar en la BD*/ 
$sql = 'DELETE FROM insignia WHERE id_insignia="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
$sqlimg = "SELECT `foto_insignia` FROM `insignia` WHERE id_insignia='".$_POST['del']."'";
$consulta = $mysqli->query($sqlimg);
if($row=$consulta->fetch_assoc()){
$eliminar_img = "../img/insignias/".$row['foto_insignia'];
}
$eliminar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
@unlink ($eliminar_img);
 /*Validamos si el registro fue eliminado con éxito*/ 
 ?>
<script>
 alert('Registro eliminado');
 document.location.href="insignia.php";
</script>
<?php 
}else{
?>
<script>
 alert('Eliminación fallida, por favor compruebe que la insignia no esté en uso');
 document.location.href="insignia.php";
</script>
<?php 
}
}
 ?>
<center>
<h1>Insignia</h1>
</center><?php 
if (isset($_POST['submit'])){
if ($_POST['submit']=="Registrar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$sql = "INSERT INTO insignia (`id_insignia`, `nombre_insignia`, `aciertos`) VALUES ('".$_POST['id_insignia']."', '".$_POST['nombre_insignia']."', '".$_POST['aciertos']."')";
 /*echo $sql;*/
if ($insertar = $mysqli->query($sql)) {
$id_insignia = $mysqli->insert_id;
@mkdir("../img/insignias");
$partes_nombre = explode (".",$_FILES['foto_insignia']['name']);
$ext = end($partes_nombre);

@unlink("../img/insignias/".$id_insignia.".".$ext);
move_uploaded_file($_FILES['foto_insignia']['tmp_name'],"../img/insignias/".$id_insignia.".".$ext);
if (file_exists("../img/insignias/".$id_insignia.".".$ext)){
$sqlav = "UPDATE insignia SET foto_insignia='".$id_insignia.".".$ext."' WHERE  id_insignia = '".$id_insignia."'";
$insertar_imagen = $mysqli->query($sqlav);
}
 if ($insertar_imagen>0){
 /*Validamos si el registro fue ingresado con éxito*/ 
 ?>
<script>alert('Se agregó la insignia <?php echo $_POST['nombre_insignia']." con ".$_POST['aciertos']; ?> aciertos satisfactoriamente.')</script>
<meta http-equiv="refresh" content="1; url=insignia.php" />
<?php 
 }else{ 
 ?>
<script>alert('Hubo un error, No se registró la insignia <?php echo $_POST['nombre_insignia']." con ".$_POST['aciertos']; ?>.')</script>
<meta http-equiv="refresh" content="1; url=insignia.php" />
<?php 
}
}else{
  ?>
<script>alert('Hubo un error, No se registró la insignia <?php echo $_POST['nombre_insignia']." con ".$_POST['aciertos']; ?>.')</script>
<meta http-equiv="refresh" content="1; url=insignia.php" />
<?php 
}
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo" or $_POST['submit']=="Modificar"){
if ($_POST['submit']=="Modificar"){
$sql = "SELECT * FROM `insignia` WHERE id_insignia ='".$_POST['cod']."' Limit 1"; 
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
 ?>
<form id="form1" name="form1" method="post" action="insignia.php" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="<?php echo 1024 * (1024 * 4)?>" />
<h1><?php echo $textoh1 ?></h1>
<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_insignia']))  echo $row['id_insignia'] ?>" size="120" required></p>
<p><label for="foto_insignia">Imágen Insignia:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>
<span id="span_img">
<?php if (isset($row['foto_insignia']))
echo '<img id="img_foto_insignia" height="80" src="'.$url_raiz.'img/insignias/'.$row['foto_insignia'].'"><br><input onclick="span_img()" type="button" value="Cambiar Imágen">';
else{
echo '<img id="img_foto_insignia" height="80">';
echo '<input class=""name="foto_insignia" type="file"  onchange="valida_adjunto_img(this);sugerir_nombre_insignia();mostrarImagen(this);" id="foto_insignia" required>';
}
?>
</span>
</p>
<?php 
echo '<p><input class=""name="id_insignia"type="hidden" id="id_insignia" value="';if (isset($row['id_insignia'])) echo $row['id_insignia'];echo '"';echo '></p>';
echo '<p><label for="nombre_insignia">Nombre Insignia:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label><input autocomplete="off" class=""name="nombre_insignia"type="text" id="nombre_insignia"  onchange="valida_insignia()" value="';if (isset($row['nombre_insignia'])) echo $row['nombre_insignia'];echo '"';echo ' required ></p>';
?>
<?php
echo '<p><label for="aciertos">Aciertos:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label><input onKeyPress="return soloNumeros(event)" min="0" class=""name="aciertos"type="number" id="aciertos" onchange="valida_insignia()" value="';if (isset($row['aciertos'])) echo $row['aciertos'];echo '"';echo ' required ></p>';
?>
<span id="txtnombre_insigniaaciertos"></span>
<?php
echo '<p><input type="submit" name="submit" id="submit" value="'.$textobtn.'"></p>
</form>';
} /*fin mixto*/ 
if ($_POST['submit']=="Actualizar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$cod = $_POST['cod'];
 /*Instrucción SQL que permite insertar en la BD */ 
$imginsignia = "";
$partes_nombre = explode (".",$_FILES['foto_insignia']['name']);
$ext = end($partes_nombre);
if (isset($_FILES['foto_insignia'])) $imginsignia = ", foto_insignia='".$cod.".".$ext."' ";
$sql = "UPDATE insignia SET id_insignia='".$_POST['id_insignia']."', nombre_insignia='".$_POST['nombre_insignia']."', aciertos='".$_POST['aciertos']."' ".$imginsignia." WHERE  id_insignia = '".$cod."';";
/* echo $sql;*/ 
/*Se conecta a la BD y luego ejecuta la instrucción SQL*/
$actualizar = $mysqli->query($sql);
 if ($actualizar>0){
if (isset($_FILES['foto_insignia'])){

@unlink("../img/insignias/".$cod.".".$ext);
move_uploaded_file($_FILES['foto_insignia']['tmp_name'],"../img/insignias/".$cod.".".$ext);
}
 /*Validamos si el registro fue ingresado con éxito*/
?>
<script>alert('Se modificó la insignia <?php echo $_POST['nombre_insignia']." con ".$_POST['aciertos']; ?> aciertos satisfactoriamente.')</script>
<?php
echo '<meta http-equiv="refresh" content="1; url=insignia.php" />';
 }else{ 
  ?>
  <script>alert('Hubo un error, No se modificó la insignia <?php echo $_POST['nombre_insignia']." con ".$_POST['aciertos']; ?>.')</script>
  <?php
}
echo '<meta http-equiv="refresh" content="2; url=insignia.php" />';
} /*fin Actualizar*/ 
 }else{ 
 ?>

<center>
<b><label>Buscar: </label></b><input placeholder="Buscar por palabra clave" title="Buscar por palabra clave: Nombre Insignia, Foto Insignia, Aciertos" type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados por página:</label></b>
<input onKeyPress="return soloNumeros(event)" type="number" min="0" id="numeroresultados_insignia" placeholder="Cant." title="Cantidad de resultados" value="<?php $no_resultados = ((isset($_COOKIE['numeroresultados_insignia']) and $_COOKIE['numeroresultados_insignia']!="" ) ? $_COOKIE['numeroresultados_insignia'] : 10); echo $no_resultados; ?>" onkeyup="grabarcookie('numeroresultados_insignia',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_insignia',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_insignia',this.value);buscar(document.getElementById('buscar').value);" size="4" style="width: 60px;">
<button title="Orden Ascendente" onclick="grabarcookie('orderad_insignia','ASC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-up"></span></button><button title="Orden Descendente" onclick="grabarcookie('orderad_insignia','DESC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-down"></span></button>
<p><label><input type="checkbox" onchange="grabarcookie('busqueda_avanzada_insignia',this.checked);mostrar_busqueda_avanzada(this.checked);buscar();" <?php if (isset($_COOKIE['busqueda_avanzada_insignia']) and $_COOKIE['busqueda_avanzada_insignia']=='true') echo 'checked' ?>>Búsqueda Avanzada</label></p>
</center>
<script>function mostrar_busqueda_avanzada(valor){
  if (valor==true){
    $(".busqueda_avanzada").show();
    $(".input_busqueda_avanzada").val("");
    $(".input_busqueda_avanzada").change();
  }else if (valor==false){
    $(".busqueda_avanzada").hide();
  }
}</script>
<div class="busqueda_avanzada" <?php if (!isset($_COOKIE['busqueda_avanzada_insignia']) or (isset($_COOKIE['busqueda_avanzada_insignia']) and $_COOKIE['busqueda_avanzada_insignia']!='true')) echo 'style="display:none"' ?>>
<div class="form-group"><p><label for="nombre_insignia">Nombre Insignia<input title="Ejemplo: Trofeo" placeholder="Ejemplo: Trofeo" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_insignianombre_insignia',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_insignianombre_insignia'])) echo $_COOKIE['busqueda_av_insignianombre_insignia']; ?>
"></label></p></div>
<div class="form-group"><p><label for="aciertos">Aciertos<input title="Ejemplo: 8" placeholder="Ejemplo: 8" class="form-control input_busqueda_avanzada" type="number" min="0" onchange="grabarcookie('busqueda_av_insigniaaciertos',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_insigniaaciertos'])) echo $_COOKIE['busqueda_av_insigniaaciertos']; ?>
"></label></p></div>
<input type="button" onclick="buscar();" class="btn btn-primary" value="Buscar">
</div>
<span id="txtsugerencias">
<?php 
buscar_insignia();
 ?>
</span>
<?php 
}/*fin else if isset cod*/
echo '</center>';
 ?>
<script>
//document.getElementById('menu_insignia').className ='active '+document.getElementById('menu_insignia').className;
</script>
<?php
$contenido = ob_get_contents();
ob_clean();
include ("../plantilla/home.php");
 ?>
