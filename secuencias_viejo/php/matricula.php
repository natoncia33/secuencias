<?php 
ob_start();
require("../config/conexion.php");
 require_once("../config/funciones.php"); 
 ?>
<center>
<?php 
function buscar_matricula($datos="",$reporte=""){
if ($reporte=="xls"){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; Filename=matricula.xls");
}
require("../config/conexion.php");
require_once ("../lib/Zebra_Pagination/Zebra_Pagination.php");
if (isset($_COOKIE['numeroresultados_matricula']) and $_COOKIE['numeroresultados_matricula']=="")  $_COOKIE['numeroresultados_matricula']="0";
$resultados = ((isset($_COOKIE['numeroresultados_matricula']) and $_COOKIE['numeroresultados_matricula']!="" ) ? $_COOKIE['numeroresultados_matricula'] : 10);
$paginacion = new Zebra_Pagination();
$paginacion->records_per_page($resultados);
$paginacion->records_per_page($resultados);

$cookiepage="page_matricula";
$funcionjs="buscar();";$paginacion->fn_js_page("$funcionjs");
$paginacion->cookie_page($cookiepage);
$paginacion->padding(false);
if (isset($_COOKIE["$cookiepage"])) $_GET['page'] = $_COOKIE["$cookiepage"];
$sql = "SELECT `matricula`.`id_matricula`, `matricula`.`grupo`, `grupo`.`nombre` as gruponombre, `matricula`.`anio`, `anio_lectivo`.`nombre_anio_lectivo` as anio_lectivonombre_anio_lectivo, `matricula`.`estudiante`, `usuarios`.`nombre` as usuariosnombre, `usuarios`.`apellido1` as usuariosapellido1, `usuarios`.`apellido2` as usuariosapellido2 FROM `matricula`  inner join `grupo` on `matricula`.`grupo` = `grupo`.`id_grupo` inner join `anio_lectivo` on `matricula`.`anio` = `anio_lectivo`.`id_anio_lectivo` inner join `usuarios` on `matricula`.`estudiante` = `usuarios`.`id_usuarios`  ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' WHERE ';
if (isset($_COOKIE['busqueda_avanzada_matricula']) and $_COOKIE['busqueda_avanzada_matricula']=="true"){
if (isset($_COOKIE['busqueda_av_matriculagrupo']) and $_COOKIE['busqueda_av_matriculagrupo']!=""){
$sql .= ' LOWER(`matricula`.`grupo`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_matriculagrupo'], 'UTF-8').'%" and ';
}
if (isset($_COOKIE['busqueda_av_matriculaanio']) and $_COOKIE['busqueda_av_matriculaanio']!=""){
$sql .= ' LOWER(`matricula`.`anio`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_matriculaanio'], 'UTF-8').'%" and ';
}
if (isset($_COOKIE['busqueda_av_matriculaestudiante']) and $_COOKIE['busqueda_av_matriculaestudiante']!=""){
$sql .= ' LOWER(`matricula`.`estudiante`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_matriculaestudiante'], 'UTF-8').'%" and ';
}
}
foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`grupo`.`nombre`)," ",LOWER(`anio_lectivo`.`nombre_anio_lectivo`)," ",LOWER(`usuarios`.`apellido1`)," "   ) LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
$sql .=  " ORDER BY ";
if (isset($_COOKIE['orderbymatricula']) and $_COOKIE['orderbymatricula']!=""){ $sql .= "`matricula`.`".$_COOKIE['orderbymatricula']."`";
}else{ $sql .= "`matricula`.`id_matricula`";}
if (isset($_COOKIE['orderad_matricula'])){
$orderadmatricula = $_COOKIE['orderad_matricula'];
$sql .=  " $orderadmatricula ";
}else{
$sql .=  " desc ";
}
$consulta_total_matricula = $mysqli->query($sql);
$total_matricula = $consulta_total_matricula->num_rows;
$paginacion->records($total_matricula);
if ($reporte=="") $sql .=  " LIMIT " . (($paginacion->get_page() - 1) * $resultados) . ", " . $resultados;
/*echo $sql;*/ 

$consulta = $mysqli->query($sql);
$numero_matricula = $consulta->num_rows;
$minimo_matricula = (($paginacion->get_page() - 1) * $resultados)+1;
$maximo_matricula = (($paginacion->get_page() - 1) * $resultados) + $resultados;
if ($maximo_matricula>$numero_matricula) $maximo_matricula=$numero_matricula;
$maximo_matricula += $minimo_matricula-1;
if ($reporte=="") echo "<p>Resultados de $minimo_matricula a $maximo_matricula del total de ".$total_matricula." en página ".$paginacion->get_page()."</p>";
 ?>
<div align="center">
<table border="1" id="tbmatricula">
<thead>
<tr>
<th <?php  if(isset($_COOKIE['orderbymatricula']) and $_COOKIE['orderbymatricula']== "grupo"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbymatricula','grupo');buscar();" >Grupo</th>
<th <?php  if(isset($_COOKIE['orderbymatricula']) and $_COOKIE['orderbymatricula']== "anio"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbymatricula','anio');buscar();" >Año Lectivo</th>
<th <?php  if(isset($_COOKIE['orderbymatricula']) and $_COOKIE['orderbymatricula']== "estudiante"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbymatricula','estudiante');buscar();" >Estudiante</th>
<?php if ($reporte==""){ ?>
<th data-label="Nuevo" class="thbotones"><form id="formNuevo" name="formNuevo" method="post" action="matricula.php">
<input name="cod" type="hidden" id="cod" value="0">
<input type="image" name="submit" id="submit" value="Nuevo" title="Nuevo" src="<?php echo $url_raiz ?>img/nuevo.png">
</form>
</th>
<th data-label="XLS" class="thbotones"><form id="formNuevo" name="formNuevo" method="post" action="matricula.php?xls">
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
<td data-label="Grupo"><?php echo $row['gruponombre']?></td>
<td data-label="Año Lectivo"><?php echo $row['anio_lectivonombre_anio_lectivo']?></td>
<td data-label="Estudiante"><?php echo $row['usuariosnombre']." ".$row['usuariosapellido1']." ".$row['usuariosapellido2']?></td>
<?php if ($reporte==""){ ?>
<td data-label="Modificar">
<form id="formModificar" name="formModificar" method="post" action="matricula.php">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_matricula']; ?>">
<input type="image" src="<?php echo $url_raiz ?>img/modificar.png"name="submit" id="submit" value="Modificar" title="Modificar">
</form>
</td>
<td data-label="Eliminar">
<input title="Eliminar" type="image" src="<?php echo $url_raiz ?>img/eliminar.png" onClick="confirmeliminar('matricula.php',{'del':'<?php echo $row['id_matricula'];?>'},'<?php echo "Grupo: ".$row['gruponombre']." Año: ".$row['anio_lectivonombre_anio_lectivo']." Estudiante: ".$row['usuariosnombre']." ".$row['usuariosapellido1']." ".$row['usuariosapellido2'];?>');" value="Eliminar">
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
buscar_matricula($_POST['datos']);
exit();
}
if (isset($_GET['xls'])){
ob_start();
buscar_matricula('','xls');
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
$sql = 'DELETE FROM matricula WHERE concat(`matricula`.`id_matricula`)="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
$eliminar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
 /*Validamos si el registro fue eliminado con éxito*/ 
 ?>
<script>alert('Registro eliminado');</script>
<meta http-equiv="refresh" content="1; url=matricula.php" />
<?php 
}else{
?>
<script>alert('Eliminación fallida, por favor compruebe que la usuario no esté en uso');</script>
<meta http-equiv="refresh" content="2; url=matricula.php" />
<?php 
}
}
 ?>
<center>
<h1>Matricula</h1>
</center><?php 
if (isset($_POST['submit'])){
if ($_POST['submit']=="Registrar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
 @session_start(); 
$sql = "INSERT INTO matricula (`id_matricula`, `grupo`, `anio`, `estudiante`) VALUES ('".$_POST['id_matricula']."', '".$_POST['grupo']."', '".$_POST['anio']."', '".$_POST['estudiante']."')";
 /*echo $sql;*/
$insertar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
$insertid = $mysqli->insert_id;
 /*Validamos si el registro fue ingresado con éxito*/ 
 ?>
<script>alert('Registro Exitoso');</script>
<meta http-equiv="refresh" content="1; url=matricula.php" />
<?php 
 }else{ 
 ?>
<script>alert('Registro fallido');</script>
<meta http-equiv="refresh" content="1; url=matricula.php" />
<?php 
}
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo" or $_POST['submit']=="Modificar"){
if ($_POST['submit']=="Modificar"){
$sql = 'SELECT `id_matricula`, `grupo`, `anio`, `estudiante` FROM `matricula` WHERE concat(`matricula`.`id_matricula`) ="'.$_POST['cod'].'" Limit 1'; 
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
<div class="col-md-3"></div><form class="col-md-6" id="form1" name="form1" method="post" action="matricula.php" >
<h1><?php echo $textoh1 ?></h1>
<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_matricula']))  echo $row['id_matricula'] ?>" size="120" required></p>
<?php 
echo '<div class="form-group"><p><input title="" class="form-control" name="id_matricula" type="hidden" id="id_matricula" value="';if (isset($row['id_matricula'])) echo $row['id_matricula'];echo '"';echo '></p>';
echo "</div>";echo '<div class="form-group"><p><label for="grupo">Grupo:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>';
$sql2= "SELECT id_grupo,nombre FROM grupo;";
 ?>
<select  title="" class="form-control" name="grupo" id="grupo"  required>
<?php 
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta2 = $mysqli->query($sql2);
while($row2=$consulta2->fetch_assoc()){
echo '<option value="'.$row2['id_grupo'].'"';if (isset($row['grupo']) and $row['grupo'] == $row2['id_grupo']) echo " selected ";echo '>'.$row2['nombre'].'</option>';
}
echo '</select></p>';
echo "</div>";echo '<div class="form-group"><p><label for="anio">Año Lectivo:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>';
$sql3= "SELECT id_anio_lectivo,nombre_anio_lectivo FROM anio_lectivo;";
 ?>
<select  title="" class="form-control" name="anio" id="anio"  required>
<?php 
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta3 = $mysqli->query($sql3);
while($row3=$consulta3->fetch_assoc()){
echo '<option value="'.$row3['id_anio_lectivo'].'"';if (isset($row['anio']) and $row['anio'] == $row3['id_anio_lectivo']) echo " selected ";echo '>'.$row3['nombre_anio_lectivo'].'</option>';
}
echo '</select></p>';
echo "</div>";echo '<div class="form-group"><p><label for="estudiante">Estudiante:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>';
$sql4= "SELECT id_usuarios,apellido1,apellido2,nombre FROM usuarios WHERE tipo ='estudiante';";
 ?>
<select  title="" class="form-control" name="estudiante" id="estudiante"  required>
<?php 
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta4 = $mysqli->query($sql4);
while($row4=$consulta4->fetch_assoc()){
echo '<option value="'.$row4['id_usuarios'].'"';if (isset($row['estudiante']) and $row['estudiante'] == $row4['id_usuarios']) echo " selected ";echo '>'.$row4['apellido1']." ".$row4['apellido2']." ".$row4['nombre'].'</option>';
}
echo '</select></p>';
echo "</div>";
echo '<p><input type="hidden" name="submit" id="submit" value="'.$textobtn.'"><button type="submit" class="btn btn-primary">'.$textobtn.'</button></p>
</form><div class="col-md-3"></div>';
} /*fin mixto*/ 
if ($_POST['submit']=="Actualizar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$cod = $_POST['cod'];
 /*Instrucción SQL que permite insertar en la BD */ 
 @session_start(); 
$sql = "UPDATE matricula SET id_matricula='".$_POST['id_matricula']."', grupo='".$_POST['grupo']."', anio='".$_POST['anio']."', estudiante='".$_POST['estudiante']."'WHERE  `matricula`.`id_matricula` = '".$cod."';";
/* echo $sql;*/ 
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/ 
$actualizar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
 /*Validamos si el registro fue ingresado con éxito*/
?>
<script>alert('Modificación exitosa');</script>
<meta http-equiv="refresh" content="1; url=matricula.php" />
<?php 
 }else{ 
?>
<script>alert('Modificación exitosa');</script>
<meta http-equiv="refresh" content="2; url=matricula.php" />
<?php 
}
} /*fin Actualizar*/ 
 }else{ 
if (isset($_COOKIE['numeroresultados_matricula']) and $_COOKIE['numeroresultados_matricula']=="")  $_COOKIE['numeroresultados_matricula']="10";
 ?>
<center>
<b><label>Buscar: </label></b><input placeholder="Buscar por palabra clave" title="Buscar por palabra clave: Grupo, Año Lectivo, Estudiante" type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados por página:</label></b>
<input onKeyPress="return soloNumeros(event)" type="number" min="0" id="numeroresultados_matricula" placeholder="Cant." title="Cantidad de resultados" value="<?php $no_resultados = ((isset($_COOKIE['numeroresultados_matricula']) and $_COOKIE['numeroresultados_matricula']!="" ) ? $_COOKIE['numeroresultados_matricula'] : 10); echo $no_resultados; ?>" onkeyup="grabarcookie('numeroresultados_matricula',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_matricula',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_matricula',this.value);buscar(document.getElementById('buscar').value);" size="4" style="width: 60px;">
<button title="Orden Ascendente" onclick="grabarcookie('orderad_matricula','ASC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-up"></span></button><button title="Orden Descendente" onclick="grabarcookie('orderad_matricula','DESC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-down"></span></button>
<p><label><input type="checkbox" onchange="grabarcookie('busqueda_avanzada_matricula',this.checked);mostrar_busqueda_avanzada(this.checked);buscar();" <?php if (isset($_COOKIE['busqueda_avanzada_matricula']) and $_COOKIE['busqueda_avanzada_matricula']=='true') echo 'checked' ?>>Búsqueda Avanzada</label></p>
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
<div class="busqueda_avanzada" <?php if (!isset($_COOKIE['busqueda_avanzada_matricula']) or (isset($_COOKIE['busqueda_avanzada_matricula']) and $_COOKIE['busqueda_avanzada_matricula']!='true')) echo 'style="display:none"' ?>>
<div class="form-group"><p><label for="grupo">Grupo<input title="" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_matriculagrupo',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_matriculagrupo'])) echo $_COOKIE['busqueda_av_matriculagrupo']; ?>
"></label></p></div>
<div class="form-group"><p><label for="anio">Año Lectivo<input title="" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_matriculaanio',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_matriculaanio'])) echo $_COOKIE['busqueda_av_matriculaanio']; ?>
"></label></p></div>
<div class="form-group"><p><label for="estudiante">Estudiante<input title="" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_matriculaestudiante',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_matriculaestudiante'])) echo $_COOKIE['busqueda_av_matriculaestudiante']; ?>
"></label></p></div>

<input type="button" onclick="buscar();" class="btn btn-primary" value="Buscar">
</div>
<span id="txtsugerencias">
<?php 
buscar_matricula();
 ?>
</span>
<?php 
}/*fin else if isset cod*/
echo '</center>';
 ?>
<script>
var vmenu_matricula = document.getElementById('menu_matricula')
if (vmenu_matricula){
vmenu_matricula.className ='active '+vmenu_matricula.className;
}
</script>
<?php $contenido = ob_get_contents();
ob_clean();
#$sql4= "SELECT * FROM usuarios WHERE tipo ='estudiante';";
include ("../plantilla/home.php");
 ?>

