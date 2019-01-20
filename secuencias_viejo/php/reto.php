<?php 
ob_start();
@session_start();
if (!isset($_SESSION['email'])){
 if ($_SESSION['tipo']!="Administrador"){
    header("Location: login.php"); 
 }
}
 ?>
<center>
<?php 
require_once(dirname(__FILE__)."/../config/conexion.php");
 /*require_once(dirname(__FILE__)."/../config/funciones.php");*/ 
function buscar_reto($datos="",$reporte=""){
require_once(dirname(__FILE__)."/../config/conexion.php");
$sql = "SELECT `reto`.`id_reto`, `reto`.`nombre_reto`, `reto`.`estado`, `reto`.`dificultad`, `reto`.`id_secuencia`, `secuencia`.`nombre_secuencia` as secuencianombre_secuencia FROM `reto`  inner join `secuencia` on `reto`.`id_secuencia` = `secuencia`.`id_secuencia`  ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' WHERE ';
foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`reto`.`id_reto`)," ", LOWER(`reto`.`nombre_reto`)," ", LOWER(`reto`.`estado`)," ", LOWER(`reto`.`dificultad`)," ", LOWER(`secuencia`.`nombre_secuencia`)," ") LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
$sql .=  " ORDER BY `reto`.`id_reto` desc LIMIT ";
if (isset($_COOKIE['numeroresultados_reto']) and $_COOKIE['numeroresultados_reto']!="") $sql .=$_COOKIE['numeroresultados_reto'];
else $sql .= "10";
/*echo $sql;*/ 

$consulta = $mysqli->query($sql);
 ?>
<div align="center">
<table border="1" id="tbreto">
<thead>
<tr>
<th>Id Reto</th>
<th>Nombre Reto</th>
<th>Estado</th>
<th>Dificultad</th>
<th>Secuencia</th>
<?php if ($reporte==""){ ?>
<th colspan="2"><form id="formNuevo" name="formNuevo" method="post" action="reto.php">
<input name="cod" type="hidden" id="cod" value="0">
<input type="submit" name="submit" id="submit" value="Nuevo">
</form>
</th>
<?php } ?>
</tr>
</thead><tbody>
<?php 
while($row=$consulta->fetch_assoc()){
 ?>
<tr>
<td><?php echo $row['id_reto']?></td>
<td><?php echo $row['nombre_reto']?></td>
<td><?php echo $row['estado']?></td>
<td><?php echo $row['dificultad']?></td>
<td><?php echo $row['secuencianombre_secuencia']?></td>
<?php if ($reporte==""){ ?>
<td>
<form id="formModificar" name="formModificar" method="post" action="reto.php">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_reto']?>">
<input type="submit" name="submit" id="submit" value="Modificar">
</form>
</td>
<td>
<input type="image" src="img/eliminar.png" onClick="confirmeliminar('reto.php',{'del':'<?php echo $row['id_reto'];?>'},'<?php echo $row['id_reto'];?>');" value="Eliminar">
</td>
<?php } ?>
</tr>
<?php 
}/*fin while*/
 ?>
</tbody>
</table></div>
<?php 
}/*fin function buscar*/
if (isset($_GET['buscar'])){
buscar_reto($_POST['datos']);
exit();
}

if (isset($_POST['del'])){
 /*Instrucción SQL que permite eliminar en la BD*/ 
$sql = 'DELETE FROM reto WHERE id_reto="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
if ($eliminar = $mysqli->query($sql)){
 /*Validamos si el registro fue eliminado con éxito*/ 
 ?>
Registro eliminado
<meta http-equiv="refresh" content="1; url=reto.php" />
<?php 
}else{
?>
Eliminación fallida, por favor compruebe que la usuario no esté en uso
<meta http-equiv="refresh" content="2; url=reto.php" />
<?php 
}
}
 ?>
<center>
<h1>Reto</h1>
</center><?php 
if (isset($_POST['submit'])){
if ($_POST['submit']=="Registrar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$sql = "INSERT INTO reto (`id_reto`, `nombre_reto`, `estado`, `dificultad`, `id_secuencia`) VALUES ('".$_POST['id_reto']."', '".$_POST['nombre_reto']."', '".$_POST['estado']."', '".$_POST['dificultad']."', '".$_POST['id_secuencia']."')";
 /*echo $sql;*/
if ($insertar = $mysqli->query($sql)) {
 /*Validamos si el registro fue ingresado con éxito*/ 
 ?>
Registro exitoso
<meta http-equiv="refresh" content="1; url=reto.php" />
<?php 
 }else{ 
 ?>
Registro fallido
<meta http-equiv="refresh" content="1; url=reto.php" />
<?php 
}
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo" or $_POST['submit']=="Modificar"){
if ($_POST['submit']=="Modificar"){
$sql = "SELECT `id_reto`, `nombre_reto`, `estado`, `dificultad`, `id_secuencia` FROM `reto` WHERE id_reto ='".$_POST['cod']."' Limit 1"; 
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
<form id="form1" name="form1" method="post" action="reto.php">
<h1><?php echo $textoh1 ?></h1>
<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_reto']))  echo $row['id_reto'] ?>" size="120" required></p>
<?php 
echo '<p><input class=""name="id_reto"type="hidden" id="id_reto" value="';if (isset($row['id_reto'])) echo $row['id_reto'];echo '"';echo '></p>';
echo '<p><label for="nombre_reto">Nombre Reto:</label><input class=""name="nombre_reto"type="text" id="nombre_reto" value="';if (isset($row['nombre_reto'])) echo $row['nombre_reto'];echo '"';echo ' required ></p>';
echo '<p><label for="estado">Estado:</label><input class=""name="estado"type="text" id="estado" value="';if (isset($row['estado'])) echo $row['estado'];echo '"';echo ' required ></p>';
echo '<p><label for="dificultad">Dificultad:</label><input class=""name="dificultad"type="text" id="dificultad" value="';if (isset($row['dificultad'])) echo $row['dificultad'];echo '"';echo ' required ></p>';
echo '<p><label for="id_secuencia">Secuencia:</label>';
$sql6= "SELECT id_secuencia,nombre_secuencia FROM secuencia;";
 ?>
<select  class="" name="id_secuencia" id="id_secuencia"  required>
<?php 
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta6 = $mysqli->query($sql6);
while($row6=$consulta6->fetch_assoc()){
echo '<option value="'.$row6['id_secuencia'].'"';if (isset($row['id_secuencia']) and $row['id_secuencia'] == $row6['id_secuencia']) echo " selected ";echo '>'.$row6['nombre_secuencia'].'</option>';
}
echo '</select></p>';

echo '<p><input type="submit" name="submit" id="submit" value="'.$textobtn.'"></p>
</form>';
} /*fin mixto*/ 
if ($_POST['submit']=="Actualizar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$cod = $_POST['cod'];
 /*Instrucción SQL que permite insertar en la BD */ 
$sql = "UPDATE reto SET id_reto='".$_POST['id_reto']."', nombre_reto='".$_POST['nombre_reto']."', estado='".$_POST['estado']."', dificultad='".$_POST['dificultad']."', id_secuencia='".$_POST['id_secuencia']."'WHERE  id_reto = '".$cod."';";
/* echo $sql;*/ 
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/ 
if ($actualizar = $mysqli->query($sql)) {
 /*Validamos si el registro fue ingresado con éxito*/
echo 'Modificación exitosa';
echo '<meta http-equiv="refresh" content="1; url=reto.php" />';
 }else{ 
echo 'Modificacion fallida';
}
echo '<meta http-equiv="refresh" content="2; url=reto.php" />';
} /*fin Actualizar*/ 
 }else{ 
 ?>
<center>
<b><label>Buscar: </label></b><input type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados:</label></b>
<input type="number" min="0" id="numeroresultados_reto" placeholder="Cantidad de resultados" title="Cantidad de resultados" value="10" onkeyup="grabarcookie('numeroresultados_reto',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_reto',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_reto',this.value);buscar(document.getElementById('buscar').value);" size="4" style="width: 40px;">
</center>
<span id="txtsugerencias">
<?php 
buscar_reto();
 ?>
</span>
<?php 
}/*fin else if isset cod*/
echo '</center>';
 ?>
<script>
document.getElementById('menu_reto').className ='active '+document.getElementById('menu_reto').className;
</script>
<?php $contenido = ob_get_contents();
ob_clean();
include ("home.php");
 ?>
