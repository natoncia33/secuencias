<?php 
ob_start();
$titulo_modulo = "Elementos Juego";
require("../config/conexion.php");
 require_once("../config/funciones.php"); 
 ?>
<center>
<?php
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
 <h1>Elementos Juego</h1><?php
buscar_elementos_juego('','pdf');
#$print=false;
require(dirname(__DIR__)."/lib/convertir_dompdf.php");
exit();
}
function buscar_elementos_juego($datos="",$reporte=""){
require("../config/conexion.php");
require_once ("../lib/Zebra_Pagination/Zebra_Pagination.php");
if (isset($_COOKIE['numeroresultados_elementos_juego']) and $_COOKIE['numeroresultados_elementos_juego']=="")  $_COOKIE['numeroresultados_elementos_juego']="0";
$resultados = ((isset($_COOKIE['numeroresultados_elementos_juego']) and $_COOKIE['numeroresultados_elementos_juego']!="" ) ? $_COOKIE['numeroresultados_elementos_juego'] : 10);
$paginacion = new Zebra_Pagination();
$paginacion->records_per_page($resultados);
$paginacion->records_per_page($resultados);

$cookiepage="page_elementos_juego";
$funcionjs="buscar();";$paginacion->fn_js_page("$funcionjs");
$paginacion->cookie_page($cookiepage);
$paginacion->padding(false);
if (isset($_COOKIE["$cookiepage"])) $_GET['page'] = $_COOKIE["$cookiepage"];
$sql = "SELECT `elementos_juego`.`id_elementos_juego`, `elementos_juego`.`tipo`, `elementos_juego`.`nombre_elemento`, `elementos_juego`.`archivo` FROM `elementos_juego`   ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' WHERE ';
if (isset($_COOKIE['busqueda_avanzada_elementos_juego']) and $_COOKIE['busqueda_avanzada_elementos_juego']=="true"){
if (isset($_COOKIE['busqueda_av_elementos_juegotipo']) and $_COOKIE['busqueda_av_elementos_juegotipo']!=""){
$sql .= ' LOWER(`elementos_juego`.`tipo`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_elementos_juegotipo'], 'UTF-8').'%" and ';
}
if (isset($_COOKIE['busqueda_av_elementos_juegonombre_elemento']) and $_COOKIE['busqueda_av_elementos_juegonombre_elemento']!=""){
$sql .= ' LOWER(`elementos_juego`.`nombre_elemento`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_elementos_juegonombre_elemento'], 'UTF-8').'%" and ';
}
}
foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`elementos_juego`.`tipo`)," ",LOWER(`elementos_juego`.`nombre_elemento`)) LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
$sql .=  " ORDER BY ";
if (isset($_COOKIE['orderbyelementos_juego']) and $_COOKIE['orderbyelementos_juego']!=""){ $sql .= "`elementos_juego`.`".$_COOKIE['orderbyelementos_juego']."`";
}else{ $sql .= "`elementos_juego`.`id_elementos_juego`";}
if (isset($_COOKIE['orderad_elementos_juego'])){
$orderadelementos_juego = $_COOKIE['orderad_elementos_juego'];
$sql .=  " $orderadelementos_juego ";
}else{
$sql .=  " desc ";
}
$consulta_total_elementos_juego = $mysqli->query($sql);
$total_elementos_juego = $consulta_total_elementos_juego->num_rows;
$paginacion->records($total_elementos_juego);
if ($reporte=="") $sql .=  " LIMIT " . (($paginacion->get_page() - 1) * $resultados) . ", " . $resultados;
/*echo $sql;*/
$consulta = $mysqli->query($sql);
$numero_elementos_juego = $consulta->num_rows;
$minimo_elementos_juego = (($paginacion->get_page() - 1) * $resultados)+1;
$maximo_elementos_juego = (($paginacion->get_page() - 1) * $resultados) + $resultados;
if ($maximo_elementos_juego>$numero_elementos_juego) $maximo_elementos_juego=$numero_elementos_juego;
$maximo_elementos_juego += $minimo_elementos_juego-1;
if ($reporte==""){ ?>
<p>
<?php echo "Resultados de $minimo_elementos_juego a $maximo_elementos_juego del total de ".$total_elementos_juego." en página ".$paginacion->get_page(); ?>
</p>
<?php } ?>
<div align="center">
<table border="1" align="center" id="tbelementos_juego">
<thead>
<tr>
<th <?php  if(isset($_COOKIE['orderbyelementos_juego']) and $_COOKIE['orderbyelementos_juego']== "tipo"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyelementos_juego','tipo');buscar();" >Tipo</th>
<th <?php  if(isset($_COOKIE['orderbyelementos_juego']) and $_COOKIE['orderbyelementos_juego']== "nombre_elemento"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyelementos_juego','nombre_elemento');buscar();">Elemento</th>
<?php if ($reporte==""){ ?>
<th data-label="Nuevo" colspan="1" class="thbotones"><form id="formNuevo" name="formNuevo" method="post" action="elementos_juego.php">
<input name="cod" type="hidden" id="cod" value="0">
<input type="image" src="<?php echo $url_raiz ?>img/nuevo.png" name="submit" id="submit" value="Nuevo" title="Nuevo" >
</form>
</th>
<th data-label="PDF" class="thbotones"><form id="formNuevo" name="formNuevo" method="post" action="elementos_juego.php?pdf">
<input name="cod" type="hidden" id="cod" value="0">
<input type="image" title="Descargar en pdf" src="<?php echo $url_raiz ?>img/pdf.png" name="submit" id="submit" value="PDF">
</form>
</th>
<?php } ?>
</tr>
</thead><tbody>
<?php 
while($row=$consulta->fetch_assoc()){
 ?>
<tr>
<td data-label='Tipo'><?php echo $row['tipo'] ?></td>
<td data-label="Elemento">
<?php if ($row['archivo']!=""){?>
 <img width="80" src="../img/figuras/<?php echo $row['archivo']?>" alt="">
 <br>
 <?php } ?> 
<?php echo $row['nombre_elemento']?></td>
<?php if ($reporte==""){ ?>
<td data-label="Modificar">
<form id="formModificar" name="formModificar" method="post" action="elementos_juego.php">
<input type="image" src="<?php echo $url_raiz ?>img/modificar.png" name="submit" id="submit" value="Modificar" title="Modificar">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_elementos_juego']; ?>">
</form>
</td>
<td data-label="Eliminar"><input title="Eliminar" type="image" src="<?php echo $url_raiz ?>img/eliminar.png" onClick="confirmeliminar('elementos_juego.php',{'del':'<?php echo $row['id_elementos_juego'];?>','tipo':'<?php echo $row['tipo'];?>','nombre_elemento':'<?php echo $row['nombre_elemento'];?>'},'<?php echo $row['tipo']." ".$row['nombre_elemento'];?>');" value="Eliminar">
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
buscar_elementos_juego($_POST['datos']);
exit();
}

if (!empty($_POST)){
 /*Validación de los datos recibidos mediante el método POST*/ 
 foreach ($_POST as $id => $valor){$_POST[$id]=$mysqli->real_escape_string($valor);} 
}
if (isset($_POST['del'])){
 /*Instrucción SQL que permite eliminar en la BD*/ 
$sql = 'DELETE FROM elementos_juego WHERE concat(`elementos_juego`.`id_elementos_juego`)="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
$sql_anterior = "SELECT archivo FROM elementos_juego WHERE id_elementos_juego ='".$_POST['del']."';";
if ($query_anterior = $mysqli->query($sql_anterior)) {
 if ($row_anterior = $query_anterior->fetch_assoc()){
    if (file_exists("../img/figuras/".$row_anterior['archivo']) and $row_anterior['archivo']!="")
     unlink("../img/figuras/".$row_anterior['archivo']);
 }
}
$eliminar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
 /*Validamos si el registro fue eliminado con éxito*/ 
 ?>
<script>
 alert('Se eliminó <?php echo $_POST['tipo']." ".$_POST['nombre_elemento']; ?> satisfactoriamente.');
 document.location.href="elementos_juego.php";
</script>
<?php 
}else{
?>
<script>
 alert('No se Eliminó, por favor compruebe que "<?php echo $_POST['tipo']." ".$_POST['nombre_elemento']; ?>" no esté en uso');
 document.location.href="elementos_juego.php";
</script>
<?php 
}
}
 ?>
<center>
<h1>Elementos Juego</h1>
</center><?php 
if (isset($_POST['submit'])){
if ($_POST['submit']=="Registrar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$sql = "INSERT INTO elementos_juego (`id_elementos_juego`, `tipo`, `nombre_elemento` ";
if ($_POST['tipo']=="Figura")$sql .=", `archivo`";
$sql .=") VALUES ('".$_POST['id_elementos_juego']."', '".$_POST['tipo']."', '".$_POST['nombre_elemento']."'";
if ($_POST['tipo']=="Figura"){
$id_unico = uniqid();
$sql .=", '".$id_unico."_".$_FILES['archivo']['name']."'";
}
$sql .= ");";

/*echo $sql;*/
$insertar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
if ($_POST['tipo']=="Figura"){
#print_r($_FILES);
move_uploaded_file($_FILES['archivo']['tmp_name'],"../img/figuras/".$id_unico."_".$_FILES['archivo']['name']);
}
 /*Validamos si el registro fue ingresado con éxito*/ 
 ?>
<script>
 alert('Registro Exitoso');
 document.location.href="elementos_juego.php";
</script>
<?php 
//<meta http-equiv="refresh" content="1; url=elementos_juego.php" />

 }else{ 
 ?>
<script>
 alert('Registro Fallido, Intente de nuevo');
 document.location.href="elementos_juego.php";
</script>
<?php 
//<meta http-equiv="refresh" content="1; url=elementos_juego.php" />
}
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo"){

$textoh1 ="Registrar";
$textobtn ="Registrar";

 ?>
<div class="col-md-3"></div><form class="col-md-6" id="form1" name="form1" method="post" action="elementos_juego.php" enctype="multipart/form-data">
 <input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="<?php echo 1024 * (1024 * 4)?>" />
<h1><?php echo $textoh1 ?></h1>
<?php 
echo '<div class="form-group"><p><input title="" class="form-control" name="id_elementos_juego" type="hidden" id="id_elementos_juego" value="';if (isset($row['id_elementos_juego'])) echo $row['id_elementos_juego'];echo '"';echo '></p>';
echo "</div>";echo '<div class="form-group"><p>'; ?>
<label for="tipo">Tipo:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label><select title="" class="form-control" name="tipo" id="tipo"  required onchange="validar_elemento_juego(document.getElementById('nombre_elemento').value);">
<option value="">Seleccione una opci&oacute;n</option>
<option value="Silaba" <?php if (isset($row['tipo']) and $row['tipo'] =="Silaba") echo " selected "; ?> >Sílaba</option>
<option value="Figura" <?php if (isset($row['tipo']) and $row['tipo'] =="Figura") echo " selected "; ?> >Figura</option>
<option value="Palabra" <?php if (isset($row['tipo']) and $row['tipo'] =="Palabra") echo " selected "; ?> >Palabra</option>
</select></p>
<?php 
echo "</div>";echo '<div class="form-group"><p><label for="nombre_elemento">Nombre Elemento:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label><input title="" class="form-control" autocomplete="off" name="nombre_elemento"  onchange="validar_elemento_juego(this.value);valida_elemento_juego();" onblur="this.onchange();" onkeyup="this.onchange();" type="text" id="nombre_elemento" value="';if (isset($row['nombre_elemento'])) echo $row['nombre_elemento'];echo '"';echo ' required ></p>';
echo "</div>";echo '<div class="form-group" id="area_adjunto" style="display:none"><p><label for="archivo">Archivo:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label><img src="" id="img_archivo" style="width:120px"><input title="" class="form-control" name="archivo" type="file" onchange="valida_adjunto_img(this);sugerir_nombre_adjunto();mostrarImagen(this);" id="archivo" value="" required ></p>';
echo "</div>";
echo '<p id="txt_valida_silaba"></p>';
echo '<p id="txttiponombre_elemento"></p>';
echo '<p><input type="hidden" name="submit" id="submit" value="'.$textobtn.'"><button type="submit" class="btn btn-primary">'.$textobtn.'</button></p>
</form><div class="col-md-3"></div>';
} /*fin nuevo*/ 
if ($_POST['submit']=="Modificar"){

$sql = 'SELECT `id_elementos_juego`, `tipo`, `nombre_elemento`, `archivo` FROM `elementos_juego` WHERE concat(`elementos_juego`.`id_elementos_juego`) ="'.$_POST['cod'].'" Limit 1'; 
$consulta = $mysqli->query($sql);
 /*echo $sql;*/ 
$row=$consulta->fetch_assoc();

$textoh1 ="Modificar";
$textobtn ="Actualizar";
 ?>
<div class="col-md-3"></div><form class="col-md-6" id="form1" name="form1" method="post" action="elementos_juego.php" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="<?php echo 1024 * (1024 * 4)?>" />
<h1><?php echo $textoh1 ?></h1>
<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_elementos_juego']))  echo $row['id_elementos_juego'] ?>" size="120" required></p>
<?php 
echo '<div class="form-group"><p><input title="" class="form-control" name="id_elementos_juego" type="hidden" id="id_elementos_juego" value="';if (isset($row['id_elementos_juego'])) echo $row['id_elementos_juego'];echo '"';echo '></p>';
echo "</div>";echo '<div class="form-group"><p>'; ?>
<label for="tipo">Tipo:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label><select title="" class="form-control" name="tipo" id="tipo"  required onchange="validar_elemento_juego(document.getElementById('nombre_elemento').value);">
<option value="">Seleccione una opci&oacute;n</option>
<option value="Silaba" <?php if (isset($row['tipo']) and $row['tipo'] =="Silaba") echo " selected "; ?> >Sílaba</option>
<option value="Figura" <?php if (isset($row['tipo']) and $row['tipo'] =="Figura") echo " selected "; ?> >Figura</option>
<option value="Palabra" <?php if (isset($row['tipo']) and $row['tipo'] =="Palabra") echo " selected "; ?> >Palabra</option>
</select></p>
</div>
<div class="form-group"><p>
 <label for="nombre_elemento">Nombre Elemento:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span>
 </label>
 <input title="" class="form-control" name="nombre_elemento" onchange="validar_elemento_juego(this.value)" onblur="this.onchange();" onkeyup="this.onchange();" type="text" id="nombre_elemento" value="<?php if (isset($row['nombre_elemento'])) echo $row['nombre_elemento'];?>" required ></p>
</div>
<div class="form-group" id="area_adjunto" <?php if (isset($row['tipo']) and $row['tipo'] !="Figura") echo 'style="display:none"'; ?>><p>
 <label for="archivo">Archivo:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label><img src="<?php
if (isset($row['archivo'])) echo "../img/figuras/".$row['archivo'];
?>" id="img_archivo" style="width:120px">
<input title="" class="form-control" name="archivo" type="file" id="archivo" onchange="valida_adjunto_img(this);sugerir_nombre_adjunto();mostrarImagen(this);"></p>
</div>
 <p><label><input id="chk_cambiar_imagen" type="checkbox" checked onchange="if(this.checked){ archivo.setAttribute('required','required');area_adjunto.style.display='block'}else{archivo.removeAttribute('required');area_adjunto.style.display='none'}">Cambiar Imágen</label></p>
<p id="txt_valida_silaba"></p>
<p><input type="hidden" name="submit" id="submit" value="<?php echo $textobtn ?>"><button type="submit" class="btn btn-primary"><?php echo $textobtn?></button></p>
</form><div class="col-md-3"></div>
<?php
} /*fin modificar*/ 
if ($_POST['submit']=="Actualizar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$cod = $_POST['cod'];
 /*Instrucción SQL que permite insertar en la BD */ 
$archivo = "";
if ($_FILES['archivo']['name']!=""){
$id_unico = uniqid();
$archivo = ", archivo = '".$id_unico."_".$_FILES['archivo']['name']."' ";
}

$sql = "UPDATE elementos_juego SET id_elementos_juego='".$_POST['id_elementos_juego']."', tipo='".$_POST['tipo']."', nombre_elemento='".$_POST['nombre_elemento']."' ".$archivo." WHERE  `elementos_juego`.`id_elementos_juego` = '".$cod."';";
/* echo $sql;*/ 
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
if ($_FILES['archivo']['name']!=""){
$sql_anterior = "SELECT archivo FROM elementos_juego WHERE id_elementos_juego ='".$cod."';";
#echo $sql_anterior; exit();
if ($query_anterior = $mysqli->query($sql_anterior)) {
 if ($row_anterior = $query_anterior->fetch_assoc()){
    if (file_exists(dirname(__DIR__)."/img/figuras/".$row_anterior['archivo']))
     unlink(dirname(__DIR__)."/img/figuras/".$row_anterior['archivo']);
 }
}
}
$actualizar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
if ($_FILES['archivo']['name']!=""){
move_uploaded_file($_FILES['archivo']['tmp_name'],"../img/figuras/".$id_unico."_".$_FILES['archivo']['name']);
}
 /*Validamos si el registro fue ingresado con éxito*/
?>
<script>alert('Modificación exitosa');</script>
<meta http-equiv="refresh" content="1; url=elementos_juego.php" />
<?php 
 }else{ 
?>
<script>alert('Modificación fallida');</script>
<meta http-equiv="refresh" content="2; url=elementos_juego.php" />
<?php 
}
} /*fin Actualizar*/
 }else{ 
if (isset($_COOKIE['numeroresultados_elementos_juego']) and $_COOKIE['numeroresultados_elementos_juego']=="")  $_COOKIE['numeroresultados_elementos_juego']="10";
 ?>
<center>
<b><label>Buscar: </label></b><input placeholder="Buscar por palabra clave" title="Buscar por palabra clave: Tipo, Nombre Elemento" type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados por página:</label></b>
<input onKeyPress="return soloNumeros(event)" type="number" min="0" id="numeroresultados_elementos_juego" placeholder="Cant." title="Cantidad de resultados" value="<?php $no_resultados = ((isset($_COOKIE['numeroresultados_elementos_juego']) and $_COOKIE['numeroresultados_elementos_juego']!="" ) ? $_COOKIE['numeroresultados_elementos_juego'] : 10); echo $no_resultados; ?>" onkeyup="grabarcookie('numeroresultados_elementos_juego',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_elementos_juego',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_elementos_juego',this.value);buscar(document.getElementById('buscar').value);" size="4" style="width: 60px;">
<button title="Orden Ascendente" onclick="grabarcookie('orderad_elementos_juego','ASC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-up"></span></button><button title="Orden Descendente" onclick="grabarcookie('orderad_elementos_juego','DESC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-down"></span></button>
<p><label><input type="checkbox" onchange="grabarcookie('busqueda_avanzada_elementos_juego',this.checked);mostrar_busqueda_avanzada(this.checked);buscar();" <?php if (isset($_COOKIE['busqueda_avanzada_elementos_juego']) and $_COOKIE['busqueda_avanzada_elementos_juego']=='true') echo 'checked' ?>>&nbsp;Búsqueda Avanzada</label></p>
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
<div class="busqueda_avanzada" <?php if (!isset($_COOKIE['busqueda_avanzada_elementos_juego']) or (isset($_COOKIE['busqueda_avanzada_elementos_juego']) and $_COOKIE['busqueda_avanzada_elementos_juego']!='true')) echo 'style="display:none"' ?>>
<div class="form-group"><p><label for="tipo">Tipo<input title="" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_elementos_juegotipo',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_elementos_juegotipo'])) echo $_COOKIE['busqueda_av_elementos_juegotipo']; ?>
"></label></p></div>
<div class="form-group"><p><label for="nombre_elemento">Nombre Elemento<input title="" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_elementos_juegonombre_elemento',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_elementos_juegonombre_elemento'])) echo $_COOKIE['busqueda_av_elementos_juegonombre_elemento']; ?>
"></label></p></div>

<input type="button" onclick="buscar();" class="btn btn-primary" value="Buscar">
</div>
<span id="txtsugerencias">
<?php 
buscar_elementos_juego();
 ?>
</span>
<?php 
}/*fin else if isset cod*/
echo '</center>';
 ?>
<script>
var vmenu_elementos_juego = document.getElementById('menu_elementos_juego')
if (vmenu_elementos_juego){
vmenu_elementos_juego.className ='active '+vmenu_elementos_juego.className;
}
</script>
<?php $contenido = ob_get_contents();
ob_clean();
include ("../plantilla/home.php");
 ?>
