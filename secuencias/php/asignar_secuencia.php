<?php 
ob_start();
@session_start();
if (!isset($_SESSION['email'])){
   header("Location: login.php");
}
require("../config/conexion.php");
 require_once("../config/funciones.php"); 
 ?>
<center>
<?php 
function buscar_secuencia_estudiante($datos="",$reporte=""){
if ($reporte=="xls"){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; Filename=secuencia_estudiante.xls");
}
require("../config/conexion.php");
require_once ("../lib/Zebra_Pagination/Zebra_Pagination.php");
if (isset($_COOKIE['numeroresultados_secuencia_estudiante']) and $_COOKIE['numeroresultados_secuencia_estudiante']=="")  $_COOKIE['numeroresultados_secuencia_estudiante']="0";
$resultados = ((isset($_COOKIE['numeroresultados_secuencia_estudiante']) and $_COOKIE['numeroresultados_secuencia_estudiante']!="" ) ? $_COOKIE['numeroresultados_secuencia_estudiante'] : 10);
$paginacion = new Zebra_Pagination();
$paginacion->records_per_page($resultados);
$paginacion->records_per_page($resultados);

$cookiepage="page_secuencia_estudiante";
$funcionjs="buscar();";$paginacion->fn_js_page("$funcionjs");
$paginacion->cookie_page($cookiepage);
$paginacion->padding(false);
$id_anio = $_SESSION['id_anio_lectivo'];
if (isset($_COOKIE["$cookiepage"])) $_GET['page'] = $_COOKIE["$cookiepage"];
$sql = "SELECT * FROM `secuencia_estudiante` inner join `matricula` ON `secuencia_estudiante`.`id_estudiante`  = `matricula`.`id_matricula` and `matricula`.`anio` = '$id_anio' inner join `usuarios` on `usuarios`.`id_usuarios` = `matricula`.`estudiante` inner join `secuencia` on `secuencia_estudiante`.`id_secuencia`= `secuencia`.`id_secuencia` WHERE `usuarios`.`tipo` = 'estudiante'  ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' and ';

foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`usuarios`.`nombre`)," ",LOWER(`usuarios`.`apellido1`)," ",LOWER(`usuarios`.`apellido2`)," "   ) LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
#$_COOKIE['orderbysecuencia_estudiante']="";
$sql .=  " ORDER BY ";
if (isset($_COOKIE['orderbysecuencia_estudiante']) and $_COOKIE['orderbysecuencia_estudiante']!=""){ $sql .= "`secuencia_estudiante`.`".$_COOKIE['orderbysecuencia_estudiante']."`";
}else{ $sql .= "`secuencia_estudiante`.`id_secuencia_estudiante`";}
if (isset($_COOKIE['orderad_secuencia_estudiante'])){
$orderadsecuencia_estudiante = $_COOKIE['orderad_secuencia_estudiante'];
$sql .=  " $orderadsecuencia_estudiante ";
}else{
$sql .=  " desc ";
}
$consulta_total_secuencia_estudiante = $mysqli->query($sql);
$total_secuencia_estudiante = $consulta_total_secuencia_estudiante->num_rows;
$paginacion->records($total_secuencia_estudiante);
if ($reporte=="") $sql .=  " LIMIT " . (($paginacion->get_page() - 1) * $resultados) . ", " . $resultados;
#echo $sql;

$consulta = $mysqli->query($sql);
$numero_secuencia_estudiante = $consulta->num_rows;
$minimo_secuencia_estudiante = (($paginacion->get_page() - 1) * $resultados)+1;
$maximo_secuencia_estudiante = (($paginacion->get_page() - 1) * $resultados) + $resultados;
if ($maximo_secuencia_estudiante>$numero_secuencia_estudiante) $maximo_secuencia_estudiante=$numero_secuencia_estudiante;
$maximo_secuencia_estudiante += $minimo_secuencia_estudiante-1;
if ($reporte=="") echo "<p>Resultados de $minimo_secuencia_estudiante a $maximo_secuencia_estudiante del total de ".$total_secuencia_estudiante." en página ".$paginacion->get_page()."</p>";
 ?>
<div align="center">
<table border="1" id="tbsecuencia_estudiante">
<thead>
<tr>
<th <?php  if(isset($_COOKIE['orderbysecuencia_estudiante']) and $_COOKIE['orderbysecuencia_estudiante']== "id_estudiante"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbysecuencia_estudiante','id_estudiante');buscar();" >Estudiante</th>
<th <?php  if(isset($_COOKIE['orderbysecuencia_estudiante']) and $_COOKIE['orderbysecuencia_estudiante']== "id_secuencia"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbysecuencia_estudiante','id_secuencia');buscar();" >Secuencia</th>
<?php if ($reporte==""){ ?>
<th data-label="Nuevo" class="thbotones"><form id="formNuevo" name="formNuevo" method="post" action="asignar_secuencia.php">
<input name="cod" type="hidden" id="cod" value="0">
<input type="image" name="submit" id="submit" value="Nuevo" title="Nuevo" src="<?php echo $url_raiz ?>img/nuevo.png">
</form>
</th>
<th data-label="XLS" class="thbotones"><form id="formNuevo" name="formNuevo" method="post" action="asignar_secuencia.php?xls">
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
<td data-label="Estudiante"><?php echo $row['nombre']." ".$row['apellido1']." ".$row['apellido2']?></td>
<td data-label="secuencia"><?php echo $row['nombre_secuencia']?></td>
<?php if ($reporte==""){ ?>
<td data-label="Modificar">
<form id="formModificar" name="formModificar" method="post" action="asignar_secuencia.php">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_secuencia_estudiante']; ?>">
<input type="image" src="<?php echo $url_raiz ?>img/modificar.png"name="submit" id="submit" value="Modificar" title="Modificar">
</form>
</td>
<td data-label="Eliminar">
<input title="Eliminar" type="image" src="<?php echo $url_raiz ?>img/eliminar.png" onClick="confirmeliminar('asignar_secuencia.php',{'del':'<?php echo $row['id_secuencia_estudiante'];?>'},'<?php echo "Secuencia: ".$row['nombre_secuencia']." Estudiante: ".$row['nombre']." ".$row['apellido1']." ".$row['apellido2'];?>');" value="Eliminar">
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
buscar_secuencia_estudiante($_POST['datos']);
exit();
}
if (isset($_GET['xls'])){
ob_start();
buscar_secuencia_estudiante('','xls');
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
$sql = 'DELETE FROM secuencia_estudiante WHERE concat(`secuencia_estudiante`.`id_secuencia_estudiante`)="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
$eliminar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
 /*Validamos si el registro fue eliminado con éxito*/ 
 ?>
<script>alert('Registro eliminado');</script>
<meta http-equiv="refresh" content="1; url=asignar_secuencia.php" />
<?php 
}else{
?>
<script>alert('Eliminación fallida, por favor compruebe que la usuario no esté en uso');</script>
<meta http-equiv="refresh" content="2; url=asignar_secuencia.php" />
<?php 
}
}
 ?>
<center>
<h1>Asignar Secuencia a estudiante</h1>
</center><?php 
if (isset($_POST['submit'])){
if ($_POST['submit']=="Registrar"){
 #print_r($_POST);
 #exit();
 /*recibo los campos del formulario proveniente con el método POST*/ 
 @session_start(); 
$sql = "INSERT INTO `secuencia_estudiante`(`id_secuencia_estudiante`, `id_secuencia`, `id_estudiante`) VALUES ('".$_POST['id_secuencia_estudiante']."', '".$_POST['id_secuencia']."', '".$_POST['id_estudiante']."')";
 /*echo $sql;*/
$insertar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
$insertid = $mysqli->insert_id;
 /*Validamos si el registro fue ingresado con éxito*/ 
 ?>
<script>alert('Registro Exitoso');</script>
<meta http-equiv="refresh" content="1; url=asignar_secuencia.php" />
<?php 
 }else{ 
 ?>
<script>alert('Registro fallido');</script>
<meta http-equiv="refresh" content="1; url=asignar_secuencia.php" />
<?php 
}
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo" or $_POST['submit']=="Modificar"){
if ($_POST['submit']=="Modificar"){
$sql = 'SELECT * FROM `secuencia_estudiante` WHERE `secuencia_estudiante`.`id_secuencia_estudiante`="'.$_POST['cod'].'" Limit 1'; 
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
<div class="col-md-3"></div><form class="col-md-6" id="form1" name="form1" method="post" action="asignar_secuencia.php" >
<h1><?php echo $textoh1 ?></h1>
<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_secuencia_estudiante']))  echo $row['id_secuencia_estudiante'] ?>" size="120" required></p>
<div class="form-group">
<p><input title="" class="form-control" name="id_secuencia_estudiante" type="hidden" id="id_secuencia_estudiante" value="<?php 
if (isset($row['id_secuencia_estudiante'])) echo $row['id_secuencia_estudiante'];
?>" ></p>
</div>
<div class="form-group"><p><label for="secuencia">secuencia:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>
<?php 
$sql2= "SELECT id_secuencia,nombre_secuencia FROM secuencia;";
$consulta2 = $mysqli->query($sql2);
if ($consulta2->num_rows==0){
echo '<br>Advertencia, aún no ha creado secuencias, para crear uno haga clic <a href="secuencia.php">Aquí</a>';
}
?>
<select  title="" class="form-control" name="id_secuencia" id="id_secuencia" onchange="valida_asignacion_secuencia()" required>
<option value="">Seleccione una opci&oacute;n</option>
<?php
while($row2=$consulta2->fetch_assoc()){
?><option value="<?php echo $row2['id_secuencia']?>" <?php if (isset($row['id_secuencia']) and $row['id_secuencia'] == $row2['id_secuencia']) echo " selected "; ?> > <?php echo $row2['nombre_secuencia'] ?></option>
<?php } ?>
</select></p>
</div>
<div class="form-group"><p><label for="id_estudiante">Estudiante:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>
<?php $estudiante = isset($row['id_estudiante']) ? $row['id_estudiante'] : ""; ?>
<span id="span_estudiante" pre="<?php echo $estudiante ?>">
<?php
if (!isset($id_anio)) $id_anio = $_SESSION['id_anio_lectivo'];
lista_estudiantes($id_anio,$estudiante); ?>
</span>
</p>
</div>
<span id="txtid_secuenciaid_estudiante">Disponible</span>
<p><input type="hidden" name="submit" id="submit" value="<?php echo $textobtn ?>">
<button type="submit" class="btn btn-primary"><?php echo $textobtn ?></button></p>
</form><div class="col-md-3"></div>
<?php
} /*fin mixto*/ 
if ($_POST['submit']=="Actualizar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$cod = $_POST['cod'];
 /*Instrucción SQL que permite insertar en la BD */ 
@session_start(); 
 $sql = "UPDATE secuencia_estudiante SET id_secuencia='".$_POST['id_secuencia']."', id_estudiante='".$_POST['id_estudiante']."'WHERE  `secuencia_estudiante`.`id_secuencia_estudiante` = '".$cod."';";
/* echo $sql;*/ 
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/ 
$actualizar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
 /*Validamos si el registro fue ingresado con éxito*/
?>
<script>alert('Modificación exitosa');</script>
<meta http-equiv="refresh" content="1; url=asignar_secuencia.php" />
<?php 
 }else{ 
?>
<script>alert('Modificación exitosa');</script>
<meta http-equiv="refresh" content="2; url=asignar_secuencia.php" />
<?php 
}
} /*fin Actualizar*/ 
 }else{ 
if (isset($_COOKIE['numeroresultados_secuencia_estudiante']) and $_COOKIE['numeroresultados_secuencia_estudiante']=="")  $_COOKIE['numeroresultados_secuencia_estudiante']="10";
 ?>
<center>
<b><label>Buscar: </label></b><input placeholder="Buscar por palabra clave" title="Buscar por palabra clave: secuencia, Año Lectivo, Estudiante" type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados por página:</label></b>
<input onKeyPress="return soloNumeros(event)" type="number" min="0" id="numeroresultados_secuencia_estudiante" placeholder="Cant." title="Cantidad de resultados" value="<?php $no_resultados = ((isset($_COOKIE['numeroresultados_secuencia_estudiante']) and $_COOKIE['numeroresultados_secuencia_estudiante']!="" ) ? $_COOKIE['numeroresultados_secuencia_estudiante'] : 10); echo $no_resultados; ?>" onkeyup="grabarcookie('numeroresultados_secuencia_estudiante',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_secuencia_estudiante',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_secuencia_estudiante',this.value);buscar(document.getElementById('buscar').value);" size="4" style="width: 60px;">
<button title="Orden Ascendente" onclick="grabarcookie('orderad_secuencia_estudiante','ASC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-up"></span></button><button title="Orden Descendente" onclick="grabarcookie('orderad_secuencia_estudiante','DESC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-down"></span></button>
</center>
<span id="txtsugerencias">
<?php 
buscar_secuencia_estudiante();
 ?>
</span>
<?php 
}/*fin else if isset cod*/
echo '</center>';
 ?>
<script>
var vmenu_secuencia_estudiante = document.getElementById('menu_secuencia_estudiante')
if (vmenu_secuencia_estudiante){
vmenu_secuencia_estudiante.className ='active '+vmenu_secuencia_estudiante.className;
}
</script>
<?php $contenido = ob_get_contents();
ob_clean();
#$sql4= "SELECT * FROM usuarios WHERE tipo ='estudiante';";
include ("../plantilla/home.php");
 ?>

