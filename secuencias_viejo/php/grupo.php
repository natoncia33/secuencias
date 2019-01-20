<?php 
ob_start();
require("../config/conexion.php");
 require_once("../config/funciones.php"); 
 ?>
<center>
<?php 
function buscar_grupo($datos="",$reporte=""){
if ($reporte=="xls"){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; Filename=grupo.xls");
}
require("../config/conexion.php");
require_once ("../lib/Zebra_Pagination/Zebra_Pagination.php");
if (isset($_COOKIE['numeroresultados_grupo']) and $_COOKIE['numeroresultados_grupo']=="")  $_COOKIE['numeroresultados_grupo']="0";
$resultados = ((isset($_COOKIE['numeroresultados_grupo']) and $_COOKIE['numeroresultados_grupo']!="" ) ? $_COOKIE['numeroresultados_grupo'] : 10);
$paginacion = new Zebra_Pagination();
$paginacion->records_per_page($resultados);
$paginacion->records_per_page($resultados);

$cookiepage="page_grupo";
$funcionjs="buscar();";$paginacion->fn_js_page("$funcionjs");
$paginacion->cookie_page($cookiepage);
$paginacion->padding(false);
if (isset($_COOKIE["$cookiepage"])) $_GET['page'] = $_COOKIE["$cookiepage"];
$sql = "SELECT `grupo`.`id_grupo`, `grupo`.`nombre` FROM `grupo`   ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' WHERE ';
if (isset($_COOKIE['busqueda_avanzada_grupo']) and $_COOKIE['busqueda_avanzada_grupo']=="true"){
if (isset($_COOKIE['busqueda_av_gruponombre']) and $_COOKIE['busqueda_av_gruponombre']!=""){
$sql .= ' LOWER(`grupo`.`nombre`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_gruponombre'], 'UTF-8').'%" and ';
}
}
foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`grupo`.`nombre`)," "   ) LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
$sql .=  " ORDER BY ";
if (isset($_COOKIE['orderbygrupo']) and $_COOKIE['orderbygrupo']!=""){ $sql .= "`grupo`.`".$_COOKIE['orderbygrupo']."`";
}else{ $sql .= "`grupo`.`id_grupo`";}
if (isset($_COOKIE['orderad_grupo'])){
$orderadgrupo = $_COOKIE['orderad_grupo'];
$sql .=  " $orderadgrupo ";
}else{
$sql .=  " desc ";
}
$consulta_total_grupo = $mysqli->query($sql);
$total_grupo = $consulta_total_grupo->num_rows;
$paginacion->records($total_grupo);
if ($reporte=="") $sql .=  " LIMIT " . (($paginacion->get_page() - 1) * $resultados) . ", " . $resultados;
/*echo $sql;*/ 

$consulta = $mysqli->query($sql);
$numero_grupo = $consulta->num_rows;
$minimo_grupo = (($paginacion->get_page() - 1) * $resultados)+1;
$maximo_grupo = (($paginacion->get_page() - 1) * $resultados) + $resultados;
if ($maximo_grupo>$numero_grupo) $maximo_grupo=$numero_grupo;
$maximo_grupo += $minimo_grupo-1;
if ($reporte=="") echo "<p>Resultados de $minimo_grupo a $maximo_grupo del total de ".$total_grupo." en página ".$paginacion->get_page()."</p>";
 ?>
<div align="center">
<table border="1" id="tbgrupo">
<thead>
<tr>
<th <?php  if(isset($_COOKIE['orderbygrupo']) and $_COOKIE['orderbygrupo']== "nombre"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbygrupo','nombre');buscar();" >Nombre</th>
<?php if ($reporte==""){ ?>
<th data-label="Nuevo"><form id="formNuevo" name="formNuevo" method="post" action="grupo.php">
<input name="cod" type="hidden" id="cod" value="0">
<input type="image" name="submit" id="submit" value="Nuevo" title="Nuevo" src="<?php echo $url_raiz ?>img/nuevo.png">
</form>
</th>
<th data-label="XLS"><form id="formNuevo" name="formNuevo" method="post" action="grupo.php?xls">
<input name="cod" type="hidden" id="cod" value="0">
<input type="image" title="Descargar en XLS" src="<?php echo $url_raiz ?>img/xls.png" name="submit" id="submit" value="XLS">
</form>
</th>
<?php } ?>
</tr>
</thead><tbody>
<?php 
while($row=$consulta->fetch_assoc()){
 ?>
<tr>
<td data-label='Nombre'><?php echo $row['nombre']?></td>
<?php if ($reporte==""){ ?>
<td data-label="Modificar">
<form id="formModificar" name="formModificar" method="post" action="grupo.php">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_grupo']; ?>">
<input type="image" src="<?php echo $url_raiz ?>img/modificar.png"name="submit" id="submit" value="Modificar" title="Modificar">
</form>
</td>
<td data-label="Eliminar">
<input title="Eliminar" type="image" src="<?php echo $url_raiz ?>img/eliminar.png" onClick="confirmeliminar('grupo.php',{'del':'<?php echo $row['id_grupo'];?>'},'<?php echo $row['id_grupo'];?>');" value="Eliminar">
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
buscar_grupo($_POST['datos']);
exit();
}
if (isset($_GET['xls'])){
ob_start();
buscar_grupo('','xls');
$excel = ob_get_clean();
echo utf8_decode($excel);
exit();
exit();
}
if (!empty($_POST)){
 /*Validación de los datos recibidos mediante el método POST*/ 
 foreach ($_POST as $id => $valor){$_POST[$id]=$mysqli->real_escape_string($valor);} 
}
if (isset($_POST['del'])){
 /*Instrucción SQL que permite eliminar en la BD*/ 
$sql = 'DELETE FROM grupo WHERE concat(`grupo`.`id_grupo`)="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
$eliminar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
 /*Validamos si el registro fue eliminado con éxito*/ 
 ?>
<script>alert('Registro eliminado');</script>
<meta http-equiv="refresh" content="1; url=grupo.php" />
<?php 
}else{
?>
<script>alert('Eliminación fallida, por favor compruebe que la usuario no esté en uso');</script>
<meta http-equiv="refresh" content="2; url=grupo.php" />
<?php 
}
}
 ?>
<center>
<h1>Grupo</h1>
</center><?php 
if (isset($_POST['submit'])){
if ($_POST['submit']=="Registrar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
 @session_start(); 
$sql = "INSERT INTO grupo (`id_grupo`, `nombre`) VALUES ('".$_POST['id_grupo']."', '".$_POST['nombre']."')";
 /*echo $sql;*/
$insertar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
 /*Validamos si el registro fue ingresado con éxito*/ 
 ?>
<script>alert('Registro Exitoso');</script>
<meta http-equiv="refresh" content="1; url=grupo.php" />
<?php 
 }else{ 
 ?>
<script>alert('Registro fallido');</script>
<meta http-equiv="refresh" content="1; url=grupo.php" />
<?php 
}
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo" or $_POST['submit']=="Modificar"){
if ($_POST['submit']=="Modificar"){
$sql = 'SELECT `id_grupo`, `nombre` FROM `grupo` WHERE concat(`grupo`.`id_grupo`) ="'.$_POST['cod'].'" Limit 1'; 
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
<div class="col-md-3"></div><form class="col-md-6" id="form1" name="form1" method="post" action="grupo.php" >
<h1><?php echo $textoh1 ?></h1>
<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_grupo']))  echo $row['id_grupo'] ?>" size="120" required></p>
<div class="form-group">
  <p>
   <input title="" class="form-control" name="id_grupo" type="hidden" id="id_grupo" value="<?php  if (isset($row['id_grupo'])) echo $row['id_grupo'];?>">
  </p>
</div>
<div class="form-group">
 <p>
  <label for="nombre">Nombre:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>
  <span id="txtnombre" style="float:right"></span>
  <input title="" onchange="valida_existe_grupo(this.value)" onkeyup="valida_existe_grupo(this.value)" class="form-control" name="nombre" type="text" id="nombre" value="<?php if (isset($row['nombre'])) echo $row['nombre'];?>" required ></p>
</div>
<p><input type="hidden" name="submit" id="submit" value="<?php echo $textobtn; ?>"><button type="submit" class="btn btn-primary"><?php echo $textobtn; ?></button></p>
</form><div class="col-md-3"></div>
<?php
} /*fin mixto*/ 
if ($_POST['submit']=="Actualizar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$cod = $_POST['cod'];
 /*Instrucción SQL que permite insertar en la BD */ 
 @session_start(); 
$sql = "UPDATE grupo SET id_grupo='".$_POST['id_grupo']."', nombre='".$_POST['nombre']."'WHERE  `grupo`.`id_grupo` = '".$cod."';";
/* echo $sql;*/ 
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/ 
$actualizar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
 /*Validamos si el registro fue ingresado con éxito*/
?>
<script>alert('Modificación exitosa');</script>
<meta http-equiv="refresh" content="1; url=grupo.php" />
<?php 
 }else{ 
?>
<script>alert('Modificación fallida');</script>
<meta http-equiv="refresh" content="2; url=grupo.php" />
<?php 
}
} /*fin Actualizar*/ 
 }else{ 
if (isset($_COOKIE['numeroresultados_grupo']) and $_COOKIE['numeroresultados_grupo']=="")  $_COOKIE['numeroresultados_grupo']="10";
 ?>
<center>
<b><label>Buscar: </label></b><input placeholder="Buscar por palabra clave" title="Buscar por palabra clave: Nombre" type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados por página:</label></b>
<input onKeyPress="return soloNumeros(event)" type="number" min="0" id="numeroresultados_grupo" placeholder="Cant." title="Cantidad de resultados" value="<?php $no_resultados = ((isset($_COOKIE['numeroresultados_grupo']) and $_COOKIE['numeroresultados_grupo']!="" ) ? $_COOKIE['numeroresultados_grupo'] : 10); echo $no_resultados; ?>" onkeyup="grabarcookie('numeroresultados_grupo',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_grupo',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_grupo',this.value);buscar(document.getElementById('buscar').value);" size="4" style="width: 60px;">
<button title="Orden Ascendente" onclick="grabarcookie('orderad_grupo','ASC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-up"></span></button><button title="Orden Descendente" onclick="grabarcookie('orderad_grupo','DESC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-down"></span></button>
<p><label><input type="checkbox" onchange="grabarcookie('busqueda_avanzada_grupo',this.checked);mostrar_busqueda_avanzada(this.checked);buscar();" <?php if (isset($_COOKIE['busqueda_avanzada_grupo']) and $_COOKIE['busqueda_avanzada_grupo']=='true') echo 'checked' ?>>Búsqueda Avanzada</label></p>
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
<div class="busqueda_avanzada" <?php if (!isset($_COOKIE['busqueda_avanzada_grupo']) or (isset($_COOKIE['busqueda_avanzada_grupo']) and $_COOKIE['busqueda_avanzada_grupo']!='true')) echo 'style="display:none"' ?>>
<div class="form-group"><p><label for="nombre">Nombre<input title="" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_gruponombre',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_gruponombre'])) echo $_COOKIE['busqueda_av_gruponombre']; ?>
"></label></p></div>

<input type="button" onclick="buscar();" class="btn btn-primary" value="Buscar">
</div>
<span id="txtsugerencias">
<?php 
buscar_grupo();
 ?>
</span>
<?php 
}/*fin else if isset cod*/
echo '</center>';
 ?>
<script>
var vmenu_grupo = document.getElementById('menu_grupo')
if (vmenu_grupo){
vmenu_grupo.className ='active '+vmenu_grupo.className;
}
</script>
<?php $contenido = ob_get_contents();
ob_clean();
include ("../plantilla/home.php");
 ?>
