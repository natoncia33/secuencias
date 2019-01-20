<?php 
ob_start();
@session_start();
if (!isset($_SESSION['email'])){
 if ($_SESSION['tipo']!="Administrador"){
    header("Location: login.php"); 
 }
}
echo '<center>';
require_once(dirname(__FILE__)."/../config/conexion.php");
 /*require_once(dirname(__FILE__)."/../config/funciones.php");*/ 
function buscar_elementos_reto($datos="",$reporte=""){

require_once(dirname(__FILE__)."/../config/conexion.php");

$sql = "SELECT `elementos_reto`.`id_elementos_reto`, `elementos_reto`.`reto`, `reto`.`nombre_reto` as retonombre_reto, `elementos_reto`.`elemento_reto`, `elementos_juego`.`nombre_elemento` as elementos_juegonombre_elemento, `elementos_reto`.`tipo` FROM `elementos_reto`  inner join `reto` on `elementos_reto`.`reto` = `reto`.`id_reto` inner join `elementos_juego` on `elementos_reto`.`elemento_reto` = `elementos_juego`.`id_elementos_juego`  ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' WHERE ';
foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`elementos_reto`.`id_elementos_reto`)," ", LOWER(`reto`.`nombre_reto`)," ", LOWER(`elementos_juego`.`nombre_elemento`)," ", LOWER(`elementos_reto`.`tipo`)," ") LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
$sql .=  " ORDER BY `elementos_reto`.`id_elementos_reto` desc LIMIT ";
if (isset($_COOKIE['numeroresultados_elementos_reto']) and $_COOKIE['numeroresultados_elementos_reto']!="") $sql .=$_COOKIE['numeroresultados_elementos_reto'];
else $sql .= "10";
/*echo $sql;*/ 

$consulta = $mysqli->query($sql);
 ?>
<div align="center">
<table border="1" id="tbelementos_reto">
<thead>
<tr>
<th>Id Elementos Reto</th>
<th>Reto</th>
<th>Elemento Reto</th>
<th>Tipo</th>
<?php if ($reporte==""){ ?>
<th colspan="2"><form id="formNuevo" name="formNuevo" method="post" action="elementos_reto.php">
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
<td><?php echo $row['id_elementos_reto']?></td>
<td><?php echo $row['retonombre_reto']?></td>
<td><?php echo $row['elementos_juegonombre_elemento']?></td>
<?php $datostipo = array("Clave" => "Clave", "Distractor" => "Distractor"); ?>
<td><?php echo $datostipo[$row['tipo']] ?></td>
<?php if ($reporte==""){ ?>
<td>
<form id="formModificar" name="formModificar" method="post" action="elementos_reto.php">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_elementos_reto']?>">
<input type="submit" name="submit" id="submit" value="Modificar">
</form>
</td>
<td>
<input type="image" src="img/eliminar.png" onClick="confirmeliminar('elementos_reto.php',{'del':'<?php echo $row['id_elementos_reto'];?>'},'<?php echo $row['id_elementos_reto'];?>');" value="Eliminar">
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
buscar_elementos_reto($_POST['datos']);
exit();
}

if (isset($_POST['del'])){
 /*Instrucción SQL que permite eliminar en la BD*/ 
$sql = 'DELETE FROM elementos_reto WHERE id_elementos_reto="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
if ($eliminar = $mysqli->query($sql)){
 /*Validamos si el registro fue eliminado con éxito*/ 
echo '
Registro eliminado
<meta http-equiv="refresh" content="1; url=elementos_reto.php" />
'; 
}else{
?>
Eliminación fallida, por favor compruebe que la usuario no esté en uso
<meta http-equiv="refresh" content="2; url=elementos_reto.php" />
<?php 
}
}
 ?>
<center>
<h1>Elementos Reto</h1>
</center><?php 
if (isset($_POST['submit'])){
if ($_POST['submit']=="Registrar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$sql = "INSERT INTO elementos_reto (`id_elementos_reto`, `reto`, `elemento_reto`, `tipo`) VALUES ('".$_POST['id_elementos_reto']."', '".$_POST['reto']."', '".$_POST['elemento_reto']."', '".$_POST['tipo']."')";
 /*echo $sql;*/
if ($insertar = $mysqli->query($sql)) {
 /*Validamos si el registro fue ingresado con éxito*/ 
echo 'Registro exitoso';
echo '<meta http-equiv="refresh" content="1; url=elementos_reto.php" />';
 }else{ 
echo 'Registro fallido';
echo '<meta http-equiv="refresh" content="1; url=elementos_reto.php" />';
}
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo"){

$textoh1 ="Registrar";
$textobtn ="Registrar";

echo '<form id="form1" name="form1" method="post" action="elementos_reto.php">
<h1>'.$textoh1.'</h1>';
?>

<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_elementos_reto']))  echo $row['id_elementos_reto'] ?>" size="120" required></p>
<?php 
echo '<p><input class=""name="id_elementos_reto"type="hidden" id="id_elementos_reto" value="';if (isset($row['id_elementos_reto'])) echo $row['id_elementos_reto'];echo '"';echo '></p>';
echo '<p><label for="reto">Reto:</label>';
$sql2= "SELECT id_reto,nombre_reto FROM reto;";
echo '<select class="" name="reto" id="reto"  required>';
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta2 = $mysqli->query($sql2);
while($row2=$consulta2->fetch_assoc()){
echo '<option value="'.$row2['id_reto'].'"';if (isset($row['reto']) and $row['reto'] == $row2['id_reto']) echo " selected ";echo '>'.$row2['nombre_reto'].'</option>';
}
echo '</select></p>';
echo '<p><label for="elemento_reto">Elemento Reto:</label>';
$sql3= "SELECT id_elementos_juego,nombre_elemento FROM elementos_juego;";
echo '<select class="" name="elemento_reto" id="elemento_reto"  required>';
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta3 = $mysqli->query($sql3);
while($row3=$consulta3->fetch_assoc()){
echo '<option value="'.$row3['id_elementos_juego'].'"';if (isset($row['elemento_reto']) and $row['elemento_reto'] == $row3['id_elementos_juego']) echo " selected ";echo '>'.$row3['nombre_elemento'].'</option>';
}
echo '</select></p>';
echo '<p><label for="tipo">Tipo:</label><br><input type="radio" class="" name="tipo" id="tipo[1]"  required value="Clave"';if (isset($row['tipo']) and $row['tipo'] =="Clave") echo " checked ";echo '><label>Clave</label><br><input type="radio" class="" name="tipo" id="tipo[2]"  required value="Distractor"';if (isset($row['tipo']) and $row['tipo'] =="Distractor") echo " checked ";echo '><label>Distractor</label><br></p>';

echo '<p><input type="submit" name="submit" id="submit" value="'.$textobtn.'"></p>
</form>';
} /*fin nuevo*/ 
if ($_POST['submit']=="Modificar"){

$sql = "SELECT `id_elementos_reto`, `reto`, `elemento_reto`, `tipo` FROM `elementos_reto` WHERE id_elementos_reto ='".$_POST['cod']."' Limit 1"; 
$consulta = $mysqli->query($sql);
 /*echo $sql;*/ 
$row=$consulta->fetch_assoc();

$textoh1 ="Modificar";
$textobtn ="Actualizar";
echo '<form id="form1" name="form1" method="post" action="elementos_reto.php">
<h1>'.$textoh1.'</h1>';
?>

<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_elementos_reto']))  echo $row['id_elementos_reto'] ?>" size="120" required></p>
<?php 
echo '<p><input class=""name="id_elementos_reto"type="hidden" id="id_elementos_reto" value="';if (isset($row['id_elementos_reto'])) echo $row['id_elementos_reto'];echo '"';echo '></p>';
echo '<p><label for="reto">Reto:</label>';
$sql2= "SELECT id_reto,nombre_reto FROM reto;";
echo '<select class="" name="reto" id="reto"  required>';
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta2 = $mysqli->query($sql2);
while($row2=$consulta2->fetch_assoc()){
echo '<option value="'.$row2['id_reto'].'"';if (isset($row['reto']) and $row['reto'] == $row2['id_reto']) echo " selected ";echo '>'.$row2['nombre_reto'].'</option>';
}
echo '</select></p>';
echo '<p><label for="elemento_reto">Elemento Reto:</label>';
$sql3= "SELECT id_elementos_juego,nombre_elemento FROM elementos_juego;";
echo '<select class="" name="elemento_reto" id="elemento_reto"  required>';
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta3 = $mysqli->query($sql3);
while($row3=$consulta3->fetch_assoc()){
echo '<option value="'.$row3['id_elementos_juego'].'"';if (isset($row['elemento_reto']) and $row['elemento_reto'] == $row3['id_elementos_juego']) echo " selected ";echo '>'.$row3['nombre_elemento'].'</option>';
}
echo '</select></p>';
echo '<p><label for="tipo">Tipo:</label><br><input type="radio" class="" name="tipo" id="tipo[1]"  required value="Clave"';if (isset($row['tipo']) and $row['tipo'] =="Clave") echo " checked ";echo '><label>Clave</label><br><input type="radio" class="" name="tipo" id="tipo[2]"  required value="Distractor"';if (isset($row['tipo']) and $row['tipo'] =="Distractor") echo " checked ";echo '><label>Distractor</label><br></p>';

echo '<p><input type="submit" name="submit" id="submit" value="'.$textobtn.'"></p>
</form>';
} /*fin modificar*/ 
if ($_POST['submit']=="Actualizar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$cod = $_POST['cod'];
 /*Instrucción SQL que permite insertar en la BD */ 
$sql = "UPDATE elementos_reto SET id_elementos_reto='".$_POST['id_elementos_reto']."', reto='".$_POST['reto']."', elemento_reto='".$_POST['elemento_reto']."', tipo='".$_POST['tipo']."'WHERE  id_elementos_reto = '".$cod."';";
/* echo $sql;*/ 
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/ 
if ($actualizar = $mysqli->query($sql)) {
 /*Validamos si el registro fue ingresado con éxito*/
echo 'Modificación exitosa';
echo '<meta http-equiv="refresh" content="1; url=elementos_reto.php" />';
 }else{ 
echo 'Modificacion fallida';
}
echo '<meta http-equiv="refresh" content="2; url=elementos_reto.php" />';
} /*fin Actualizar*/ 
 }else{ 
 ?>
<center>
<b><label>Buscar: </label></b><input type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados:</label></b>
<input type="number" min="0" id="numeroresultados_elementos_reto" placeholder="Cantidad de resultados" title="Cantidad de resultados" value="10" onkeyup="grabarcookie('numeroresultados_elementos_reto',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_elementos_reto',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_elementos_reto',this.value);buscar(document.getElementById('buscar').value);" size="4" style="width: 40px;">
</center>
<span id="txtsugerencias">
<?php 
buscar_elementos_reto();
 ?>
</span>
<?php 
}/*fin else if isset cod*/
echo '</center>';
 ?>
<script>
document.getElementById('menu_elementos_reto').className ='active '+document.getElementById('menu_elementos_reto').className;
</script>
<?php $contenido = ob_get_contents();
ob_clean();
include ("home.php");
 ?>
