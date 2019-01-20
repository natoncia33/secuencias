<?php 
ob_start();
require("../config/conexion.php");
 require_once("../config/funciones.php"); 
 ?>
<center>
<script src="../js/funciones.js"></script>
<?php 
function buscar_asignacion($datos="",$reporte=""){
if ($reporte=="xls"){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; Filename=asignacion.xls");
}
require("../config/conexion.php");
require_once ("../lib/Zebra_Pagination/Zebra_Pagination.php");
if (isset($_COOKIE['numeroresultados_asignacion']) and $_COOKIE['numeroresultados_asignacion']=="")  $_COOKIE['numeroresultados_asignacion']="0";
$resultados = ((isset($_COOKIE['numeroresultados_asignacion']) and $_COOKIE['numeroresultados_asignacion']!="" ) ? $_COOKIE['numeroresultados_asignacion'] : 10);
$paginacion = new Zebra_Pagination();
$paginacion->records_per_page($resultados);
$paginacion->records_per_page($resultados);

$cookiepage="page_asignacion";
$funcionjs="buscar();";$paginacion->fn_js_page("$funcionjs");
$paginacion->cookie_page($cookiepage);
$paginacion->padding(false);
if (isset($_COOKIE["$cookiepage"])) $_GET['page'] = $_COOKIE["$cookiepage"];
$sql = "SELECT `asignacion`.`id_asignacion`, `asignacion`.`grupo`, `grupo`.`nombre` as gruponombre, `asignacion`.`docente`, `usuarios`.`nuip` as usuariosnuip, `usuarios`.`nombre` as usuariosnombre, `usuarios`.`apellido1` as usuariosapellido1, `usuarios`.`apellido2` as usuariosapellido2, `asignacion`.`anio`, `anio_lectivo`.`nombre_anio_lectivo` as anio_lectivonombre_anio_lectivo FROM `asignacion`  inner join `grupo` on `asignacion`.`grupo` = `grupo`.`id_grupo` inner join `usuarios` on `asignacion`.`docente` = `usuarios`.`id_usuarios` inner join `anio_lectivo` on `asignacion`.`anio` = `anio_lectivo`.`id_anio_lectivo`  ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' WHERE ';
if (isset($_COOKIE['busqueda_avanzada_asignacion']) and $_COOKIE['busqueda_avanzada_asignacion']=="true"){
if (isset($_COOKIE['busqueda_av_asignaciongrupo']) and $_COOKIE['busqueda_av_asignaciongrupo']!=""){
$sql .= ' LOWER(`asignacion`.`grupo`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_asignaciongrupo'], 'UTF-8').'%" and ';
}
if (isset($_COOKIE['busqueda_av_asignaciondocente']) and $_COOKIE['busqueda_av_asignaciondocente']!=""){
$sql .= ' LOWER(`asignacion`.`docente`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_asignaciondocente'], 'UTF-8').'%" and ';
}
if (isset($_COOKIE['busqueda_av_asignacionanio']) and $_COOKIE['busqueda_av_asignacionanio']!=""){
$sql .= ' LOWER(`asignacion`.`anio`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_asignacionanio'], 'UTF-8').'%" and ';
}
}
foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`grupo`.`nombre`)," ",LOWER(`usuarios`.`nombre`)," ",LOWER(`usuarios`.`apellido1`)," ",LOWER(`usuarios`.`apellido2`)," ",LOWER(`anio_lectivo`.`nombre_anio_lectivo`)) LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
$sql .=  " ORDER BY ";
if (isset($_COOKIE['orderbyasignacion']) and $_COOKIE['orderbyasignacion']!=""){ $sql .= "`asignacion`.`".$_COOKIE['orderbyasignacion']."`";
}else{ $sql .= "`asignacion`.`id_asignacion`";}
if (isset($_COOKIE['orderad_asignacion'])){
$orderadasignacion = $_COOKIE['orderad_asignacion'];
$sql .=  " $orderadasignacion ";
}else{
$sql .=  " desc ";
}
$consulta_total_asignacion = $mysqli->query($sql);
$total_asignacion = $consulta_total_asignacion->num_rows;
$paginacion->records($total_asignacion);
if ($reporte=="") $sql .=  " LIMIT " . (($paginacion->get_page() - 1) * $resultados) . ", " . $resultados;
/*echo $sql;*/ 

$consulta = $mysqli->query($sql);
$numero_asignacion = $consulta->num_rows;
$minimo_asignacion = (($paginacion->get_page() - 1) * $resultados)+1;
$maximo_asignacion = (($paginacion->get_page() - 1) * $resultados) + $resultados;
if ($maximo_asignacion>$numero_asignacion) $maximo_asignacion=$numero_asignacion;
$maximo_asignacion += $minimo_asignacion-1;
if ($reporte=="") echo "<p>Resultados de $minimo_asignacion a $maximo_asignacion del total de ".$total_asignacion." en página ".$paginacion->get_page()."</p>";
 ?>
<div align="center">
<table border="1" id="tbasignacion">
<thead>
<tr>
<th <?php  if(isset($_COOKIE['orderbyasignacion']) and $_COOKIE['orderbyasignacion']== "grupo"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyasignacion','grupo');buscar();" >Grupo</th>
<?php if ($reporte=="xls"){ ?>
<th>Identificación</th>
<?php } ?>
<th <?php  if(isset($_COOKIE['orderbyasignacion']) and $_COOKIE['orderbyasignacion']== "docente"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyasignacion','docente');buscar();" >Docente</th>
<th <?php  if(isset($_COOKIE['orderbyasignacion']) and $_COOKIE['orderbyasignacion']== "anio"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyasignacion','anio');buscar();" >Año Lectivo</th>
<?php if ($reporte==""){ ?>
<th data-label="Nuevo" class="thbotones"><form id="formNuevo" name="formNuevo" method="post" action="asignacion.php">
<input name="cod" type="hidden" id="cod" value="0">
<input type="image" name="submit" id="submit" value="Nuevo" title="Nuevo" src="<?php echo $url_raiz ?>img/nuevo.png">
</form>
</th>
<th data-label="XLS" class="thbotones"><form id="formNuevo" name="formNuevo" method="post" action="asignacion.php?xls">
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
<?php if ($reporte=="xls"){ ?>
<td><?php echo $row['usuariosnuip'];?></td>
<td><?php echo $row['usuariosnombre']." ".$row['usuariosapellido1']." ".$row['usuariosapellido2']; ?></td>
<?php }else{ ?>
<td data-label="Docente"><?php echo $row['usuariosnuip']."<br>".$row['usuariosnombre']." ".$row['usuariosapellido1']." ".$row['usuariosapellido2']; ?></td>
<?php } ?>
<td data-label="Año Lectivo"><?php echo $row['anio_lectivonombre_anio_lectivo']?></td>
<?php if ($reporte==""){ ?>
<td data-label="Modificar">
<form id="formModificar" name="formModificar" method="post" action="asignacion.php">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_asignacion']; ?>">
<input type="image" src="<?php echo $url_raiz ?>img/modificar.png"name="submit" id="submit" value="Modificar" title="Modificar">
</form>
</td>
<td data-label="Eliminar">
<input title="Eliminar" type="image" src="<?php echo $url_raiz ?>img/eliminar.png" onClick="confirmeliminar('asignacion.php',{'del':'<?php echo $row['id_asignacion'];?>'},'<?php echo "Grupo: ".$row['gruponombre'].". Docente: ".$row['usuariosnombre']." ".$row['usuariosapellido1']." ".$row['usuariosapellido2']." (".$row['usuariosnuip']."). Año: ".$row['anio_lectivonombre_anio_lectivo']; ?>');" value="Eliminar">
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
buscar_asignacion($_POST['datos']);
exit();
}
if (isset($_GET['xls'])){
ob_start();
buscar_asignacion('','xls');
$excel = ob_get_clean();
echo utf8_decode($excel);
exit();
}
if (!empty($_POST)){
 /*Validación de los datos recibidos mediante el método POST*/ 
 foreach ($_POST as $id => $valor){$_POST[$id]=$mysqli->real_escape_string($valor);} 
}
if (isset($_POST['del'])){
 /*Instrucción SQL que permite eliminar en la BD*/ 
$sql = 'DELETE FROM asignacion WHERE concat(`asignacion`.`id_asignacion`)="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
$eliminar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
 /*Validamos si el registro fue eliminado con éxito*/ 
 ?>
<script>alert('Registro eliminado');</script>
<meta http-equiv="refresh" content="1; url=asignacion.php" />
<?php 
}else{
?>
<script>alert('Eliminación fallida, por favor compruebe que la usuario no esté en uso');</script>
<meta http-equiv="refresh" content="2; url=asignacion.php" />
<?php 
}
}
 ?>
<center>
<h1>Asignación</h1>
</center><?php 
if (isset($_POST['submit'])){
if ($_POST['submit']=="Registrar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
 @session_start(); 
$sql = "INSERT INTO asignacion (`grupo`, `docente`, `anio`) VALUES ('".$_POST['grupo']."', '".$_POST['docente']."', '".$_SESSION['id_anio_lectivo']."')";
/*echo $sql;*/
$insertar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
 /*Validamos si el registro fue ingresado con éxito*/ 
 ?>
<script>alert('Registro Exitoso')</script>
<meta http-equiv="refresh" content="1; url=asignacion.php" />
<?php 
 }else{ 
 ?>
<script>alert('Registro fallido')</script>
<meta http-equiv="refresh" content="1; url=asignacion.php" />
<?php 
}
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo"){
$textoh1 ="Registrar";
$textobtn ="Registrar";
?>
<div class="col-md-3"></div>
<form class="col-md-6" id="form1" name="form1" method="post" action="asignacion.php">
<h1><?php echo $textoh1 ?></h1>
<div class="form-group"><p>
<input title="" class="form-control" name="id_asignacion" type="hidden" id="id_asignacion" value="<?php if (isset($row['id_asignacion'])) echo $row['id_asignacion']; ?>"></p>
</div>
<div class="form-group"><p>
<label for="grupo">Grupo:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>
<?php 
$sql2= "SELECT id_grupo,nombre FROM grupo;";
$consulta2 = $mysqli->query($sql2);
if ($consulta2->num_rows==0){
echo '<br>Advertencia, aún no ha creado Grupos, para crear uno haga clic <a href="grupo.php">Aquí</a>';
}
 ?>
<select  title="" class="form-control" name="grupo" id="grupo"  required onchange="valida_asignacion();">
<option value="">Seleccione una opci&oacute;n</option>
<?php 
while($row2=$consulta2->fetch_assoc()){
echo '<option value="'.$row2['id_grupo'].'"';if (isset($row['grupo']) and $row['grupo'] == $row2['id_grupo']) echo " selected ";echo '>'.$row2['nombre'].'</option>';
}
?>
</select></p>
</div>
<div class="form-group"><p>
<label for="docente">Docente:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>
<?php
$sql3= "SELECT * FROM usuarios WHERE tipo = 'docente';";
$consulta3 = $mysqli->query($sql3);
if ($consulta3->num_rows==0){
echo '<br>Advertencia, no hay docentes disponibles para asignar, para crear usuarios haga clic <a href="usuarios.php">Aquí</a>';
}
 ?>
<select  title="" class="form-control" name="docente" id="docente"  required onchange="valida_asignacion();">
<option value="">Seleccione una opci&oacute;n</option>
<?php 
while($row3=$consulta3->fetch_assoc()){
echo '<option value="'.$row3['id_usuarios'].'"';
if (isset($row['docente']) and $row['docente'] == $row3['id_usuarios']) echo " selected ";echo '>'.$row3['nombre'].' '.$row3['apellido1'].' '.$row3['apellido2'].' ('.$row3['nuip'].')</option>';
}
?>
</select></p>
</div>
<!--div class="form-group"><p>
<label for="anio">Año Lectivo:</label>
<?php
@session_start();
/*
$sql4= "SELECT id_anio_lectivo,nombre_anio_lectivo FROM anio_lectivo;";
if (isset($_SESSION['nombre_anio_lectivo'])){
echo "<span>".$_SESSION['nombre_anio_lectivo']."</span>";
echo "<input type='hidden' id='anio' value='".$_SESSION['id_anio_lectivo']."'>";
}
*/
?>
</div-->
<div class="form-group"><p>
<label for="anio">Año Lectivo:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>
<?php 
$sql3= "SELECT id_anio_lectivo,nombre_anio_lectivo FROM anio_lectivo;"; 
$consulta3 = $mysqli->query($sql3);
if ($consulta3->num_rows==0){
echo '<br>Advertencia, aún no ha creado Año Lectivo, para crear uno haga clic <a href="anio_lectivo.php">Aquí</a>';
}
?>
<select  title="" class="form-control" name="anio" id="anio" required onchange="valida_asignacion();">
<option value="">Seleccione una opci&oacute;n</option>
<?php
//echo "<option>".$consulta3->num_rows."</option>";
while($row3=$consulta3->fetch_assoc()){
?>
<option value="<?php echo $row3['id_anio_lectivo']; ?>" <?php
if (isset($row['anio']) and $row['anio'] == $row3['id_anio_lectivo']){
    echo " selected ";
    $id_anio = $row3['id_anio_lectivo'];
}else if ($_SESSION['id_anio_lectivo'] == $row3['id_anio_lectivo']){
echo " selected ";
    $id_anio = $row3['id_anio_lectivo'];
} 
?> > <?php echo $row3['nombre_anio_lectivo'] ?> </option>
<?php } ?>
</select></p>
</div>
<span id="txtgrupodocenteanio"></span>
<p><input type="hidden" name="submit" id="submit" value="<?php echo $textobtn; ?>"><button type="submit" class="btn btn-primary"><?php echo $textobtn; ?></button></p>
</form><div class="col-md-3"></div>
<?php
} /*fin nuevo*/ 
if ($_POST['submit']=="Modificar"){
$sql = 'SELECT `id_asignacion`, `grupo`, `docente`, `anio` FROM `asignacion` WHERE concat(`asignacion`.`id_asignacion`) ="'.$_POST['cod'].'" Limit 1'; 
$consulta = $mysqli->query($sql);
 /*echo $sql;*/ 
$row=$consulta->fetch_assoc();
$textoh1 ="Modificar";
$textobtn ="Actualizar";
 ?>
<div class="col-md-3"></div><form class="col-md-6" id="form1" name="form1" method="post" action="asignacion.php">
<h1><?php echo $textoh1 ?></h1>
<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_asignacion']))  echo $row['id_asignacion'] ?>" size="120" required></p>
<div class="form-group"><p>
<input title="" class="form-control" name="id_asignacion" type="hidden" id="id_asignacion" value="<?php if (isset($row['id_asignacion'])) echo $row['id_asignacion'];?> " ></p>
</div>
<div class="form-group"><p><label for="grupo">Grupo:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>';
<?php $sql2= "SELECT id_grupo,nombre FROM grupo;"; ?>
<select  title="" class="form-control" name="grupo" id="grupo" onchange="valida_asignacion();" required>
<option value="">Seleccione una opci&oacute;n</option>
<?php 
$consulta2 = $mysqli->query($sql2);
while($row2=$consulta2->fetch_assoc()){
echo '<option value="'.$row2['id_grupo'].'"';if (isset($row['grupo']) and $row['grupo'] == $row2['id_grupo']) echo " selected ";echo '>'.$row2['nombre'].'</option>';
}
?>
</select></p>
</div>
<div class="form-group"><p><label for="docente">Docente:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>
<?php
$sql3= "SELECT * FROM usuarios WHERE tipo = 'docente';";
 ?>
<select  title="" class="form-control" name="docente" id="docente"  onchange="valida_asignacion();" required>
<option value="">Seleccione una opci&oacute;n</option>
<?php 
$consulta3 = $mysqli->query($sql3);
while($row3=$consulta3->fetch_assoc()){
echo '<option value="'.$row3['id_usuarios'].'"';if (isset($row['docente']) and $row['docente'] == $row3['id_usuarios']) echo " selected ";echo '>'.$row3['nombre'].' '.$row3['apellido1'].' '.$row3['apellido2'].'</option>';
}
?>
</select></p>
</div>
<!--div class="form-group"><p><label for="anio">Año Lectivo:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>
<?php
@session_start();
/*
$sql4= "SELECT id_anio_lectivo,nombre_anio_lectivo FROM anio_lectivo;";
if (isset($_SESSION['nombre_anio_lectivo'])){
echo "<span>".$_SESSION['nombre_anio_lectivo']."</span>";
echo "<input type='hidden' id='anio' value='".$_SESSION['id_anio_lectivo']."'>";
}
*/
?>
</div-->
<div class="form-group"><p>
<label for="anio">Año Lectivo:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>
<?php 
$sql3= "SELECT id_anio_lectivo,nombre_anio_lectivo FROM anio_lectivo;"; 
$consulta3 = $mysqli->query($sql3);
if ($consulta3->num_rows==0){
echo '<br>Advertencia, aún no ha creado Año Lectivo, para crear uno haga clic <a href="anio_lectivo.php">Aquí</a>';
}
?>
<select  title="" class="form-control" name="anio" id="anio" required>
<option value="">Seleccione una opci&oacute;n</option>
<?php
//echo "<option>".$consulta3->num_rows."</option>";
while($row3=$consulta3->fetch_assoc()){
?>
<option value="<?php echo $row3['id_anio_lectivo']; ?>" <?php
if (isset($row['anio'])){
 if ($row['anio'] == $row3['id_anio_lectivo']){
     echo " selected ";
     $id_anio = $row3['id_anio_lectivo'];
 }
}else{
if ($_SESSION['id_anio_lectivo'] == $row3['id_anio_lectivo']){
echo " selected ";
    $id_anio = $row3['id_anio_lectivo'];
}
}
?> > <?php echo $row3['nombre_anio_lectivo'] ?> </option>
<?php } ?>
</select></p>
</div>
<span id="txtgrupodocenteanio"></span>
<p><input type="hidden" name="submit" id="submit" value="<?php echo $textobtn ?>"><button type="submit" class="btn btn-primary"><?php echo $textobtn ?></button></p>
</form><div class="col-md-3"></div>';
<?php
} /*fin modificar*/ 
if ($_POST['submit']=="Actualizar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$cod = $_POST['cod'];
 /*Instrucción SQL que permite insertar en la BD */ 
 @session_start(); 
$sql = "UPDATE asignacion SET id_asignacion='".$_POST['id_asignacion']."', grupo='".$_POST['grupo']."', docente='".$_POST['docente']."', anio='".$_POST['anio']."' WHERE  `asignacion`.`id_asignacion` = '".$cod."';";
#echo $sql;
#print_r($_POST);exit();
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/ 
$actualizar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
 /*Validamos si el registro fue ingresado con éxito*/
?>
<script>alert('Modificación exitosa');</script>
<meta http-equiv="refresh" content="1; url=asignacion.php" />
<?php 
 }else{ 
?>
<script>alert('Modificación fallida');</script>
<meta http-equiv="refresh" content="2; url=asignacion.php" />
<?php 
}
} /*fin Actualizar*/ 
 }else{ 
if (isset($_COOKIE['numeroresultados_asignacion']) and $_COOKIE['numeroresultados_asignacion']=="")  $_COOKIE['numeroresultados_asignacion']="10";
 ?>
<center>
<b><label>Buscar: </label></b><input placeholder="Buscar por palabra clave" title="Buscar por palabra clave: Grupo, Docente, Año Lectivo" type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados por página:</label></b>
<input onKeyPress="return soloNumeros(event)" type="number" min="0" id="numeroresultados_asignacion" placeholder="Cant." title="Cantidad de resultados" value="<?php $no_resultados = ((isset($_COOKIE['numeroresultados_asignacion']) and $_COOKIE['numeroresultados_asignacion']!="" ) ? $_COOKIE['numeroresultados_asignacion'] : 10); echo $no_resultados; ?>" onkeyup="grabarcookie('numeroresultados_asignacion',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_asignacion',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_asignacion',this.value);buscar(document.getElementById('buscar').value);" size="4" style="width: 60px;">
<button title="Orden Ascendente" onclick="grabarcookie('orderad_asignacion','ASC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-up"></span></button><button title="Orden Descendente" onclick="grabarcookie('orderad_asignacion','DESC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-down"></span></button>
<p><label><input type="checkbox" onchange="grabarcookie('busqueda_avanzada_asignacion',this.checked);mostrar_busqueda_avanzada(this.checked);buscar();" <?php if (isset($_COOKIE['busqueda_avanzada_asignacion']) and $_COOKIE['busqueda_avanzada_asignacion']=='true') echo 'checked' ?>>Búsqueda Avanzada</label></p>
</center>
<script>
function mostrar_busqueda_avanzada(valor){
  if (valor==true){
    $(".busqueda_avanzada").show();
    $(".input_busqueda_avanzada").val("");
    $(".input_busqueda_avanzada").change();
  }else if (valor==false){
    $(".busqueda_avanzada").hide();
  }
}
</script>
<div class="busqueda_avanzada" <?php if (!isset($_COOKIE['busqueda_avanzada_asignacion']) or (isset($_COOKIE['busqueda_avanzada_asignacion']) and $_COOKIE['busqueda_avanzada_asignacion']!='true')) echo 'style="display:none"' ?>>
<div class="form-group"><p><label for="grupo">Grupo<input placeholder="Grupo" title="Grupo" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_asignaciongrupo',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_asignaciongrupo'])) echo $_COOKIE['busqueda_av_asignaciongrupo']; ?>
"></label></p></div>
<div class="form-group"><p><label for="docente">Docente<input placeholder="Identificación Docente" title="Docente" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_asignaciondocente',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_asignaciondocente'])) echo $_COOKIE['busqueda_av_asignaciondocente']; ?>
"></label></p></div>
<div class="form-group"><p><label for="anio">Año Lectivo<input placeholder="Año Lectivo" title="Año Lectivo" class="form-control input_busqueda_avanzada" type="number" onchange="grabarcookie('busqueda_av_asignacionanio',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_asignacionanio'])) echo $_COOKIE['busqueda_av_asignacionanio']; ?>
"></label></p></div>
<input type="button" onclick="buscar();" class="btn btn-primary" value="Buscar">
</div>
<span id="txtsugerencias">
<?php buscar_asignacion(); ?>
</span>
<?php 
}/*fin else if isset cod*/
 ?>
</center>
<script>
var vmenu_asignacion = document.getElementById('menu_asignacion')
if (vmenu_asignacion){
vmenu_asignacion.className ='active '+vmenu_asignacion.className;
}
</script>
<?php $contenido = ob_get_contents();
ob_clean();
include ("../plantilla/home.php");
 ?>
