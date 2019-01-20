<?php 
ob_start();
@session_start();
if (!isset($_SESSION['email'])){
    header("Location: login.php");
}
echo '<center>';
require_once(dirname(__FILE__)."/../config/conexion.php");
 /*require_once(dirname(__FILE__)."/../config/funciones.php");*/ 
function buscar_seguimiento_reto($datos="",$reporte=""){
if ($reporte=="xls"){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; Filename=seguimiento_reto.xls");
}
require_once(dirname(__FILE__)."/../config/conexion.php");

$sql = "SELECT `seguimiento_reto`.`id_seguimiento_reto`, `seguimiento_reto`.`reto`, `reto`.`nombre_reto` as retonombre_reto, `seguimiento_reto`.`usuario`, `usuarios`.`nombre` as usuariosnombre, `seguimiento_reto`.`aprobado`, `seguimiento_reto`.`h_inicio`, `seguimiento_reto`.`h_fin`, `seguimiento_reto`.`marcado`, `elementos_juego`.`nombre_elemento` as elementos_juegonombre_elemento FROM `seguimiento_reto`  inner join `reto` on `seguimiento_reto`.`reto` = `reto`.`id_reto` inner join `usuarios` on `seguimiento_reto`.`usuario` = `usuarios`.`id_usuarios` inner join `elementos_juego` on `seguimiento_reto`.`marcado` = `elementos_juego`.`id_elementos_juego`  ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' WHERE ';
foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`seguimiento_reto`.`id_seguimiento_reto`)," ", LOWER(`reto`.`nombre_reto`)," ", LOWER(`usuarios`.`nombre`)," ", LOWER(`seguimiento_reto`.`aprobado`)," ", LOWER(`seguimiento_reto`.`h_inicio`)," ", LOWER(`seguimiento_reto`.`h_fin`)," ", LOWER(`elementos_juego`.`nombre_elemento`)," ") LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
$sql .=  " ORDER BY `seguimiento_reto`.`id_seguimiento_reto` desc LIMIT ";
if (isset($_COOKIE['numeroresultados_seguimiento_reto']) and $_COOKIE['numeroresultados_seguimiento_reto']!="") $sql .=$_COOKIE['numeroresultados_seguimiento_reto'];
else $sql .= "10";
/*echo $sql;*/ 

$consulta = $mysqli->query($sql);
 ?>
<div align="center">
<table border="1" id="tbseguimiento_reto">
<thead>
<tr>
<th>Id Seguimiento Reto</th>
<th>Reto</th>
<th>Usuario</th>
<th>Aprobado</th>
<th>Hora de Inicio</th>
<th>Hora de Fin</th>
<th>Marcado</th>
<?php if ($reporte==""){ ?>
<th><form id="formNuevo" name="formNuevo" method="post" action="seguimiento_reto.php">
<input name="cod" type="hidden" id="cod" value="0">
<input type="submit" name="submit" id="submit" value="Nuevo">
</form>
</th>
<th><form id="formNuevo" name="formNuevo" method="post" action="seguimiento_reto.php?xls">
<input name="cod" type="hidden" id="cod" value="0">
<input type="submit" name="submit" id="submit" value="XLS">
</form>
</th>
<?php } ?>
</tr>
</thead><tbody>
<?php 
while($row=$consulta->fetch_assoc()){
 ?>
<tr>
<td><?php echo $row['id_seguimiento_reto']?></td>
<td><?php echo $row['retonombre_reto']?></td>
<td><?php echo $row['usuariosnombre']?></td>
<td><?php echo $row['aprobado']?></td>
<td><?php echo $row['h_inicio']?></td>
<td><?php echo $row['h_fin']?></td>
<td><?php echo $row['elementos_juegonombre_elemento']?></td>
<?php if ($reporte==""){ ?>
<td>
<form id="formModificar" name="formModificar" method="post" action="seguimiento_reto.php">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_seguimiento_reto']?>">
<input type="submit" name="submit" id="submit" value="Modificar">
</form>
</td>
<td>
<input type="image" src="img/eliminar.png" onClick="confirmeliminar('seguimiento_reto.php',{'del':'<?php echo $row['id_seguimiento_reto'];?>'},'<?php echo $row['id_seguimiento_reto'];?>');" value="Eliminar">
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
buscar_seguimiento_reto($_POST['datos']);
exit();
}
if (isset($_GET['xls'])){
buscar_seguimiento_reto('','xls');
exit();
}
if (isset($_POST['del'])){
 /*Instrucción SQL que permite eliminar en la BD*/ 
$sql = 'DELETE FROM seguimiento_reto WHERE id_seguimiento_reto="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
if ($eliminar = $mysqli->query($sql)){
 /*Validamos si el registro fue eliminado con éxito*/ 
echo '
Registro eliminado
<meta http-equiv="refresh" content="1; url=seguimiento_reto.php" />
'; 
}else{
?>
Eliminación fallida, por favor compruebe que la usuario no esté en uso
<meta http-equiv="refresh" content="2; url=seguimiento_reto.php" />
<?php 
}
}
 ?>
<center>
<h1>Seguimiento Reto</h1>
</center><?php 
if (isset($_POST['submit'])){
if ($_POST['submit']=="Registrar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$sql = "INSERT INTO seguimiento_reto (`id_seguimiento_reto`, `reto`, `usuario`, `aprobado`, `h_inicio`, `h_fin`, `marcado`) VALUES ('".$_POST['id_seguimiento_reto']."', '".$_POST['reto']."', '".$_POST['usuario']."', '".$_POST['aprobado']."', '".$_POST['h_inicio']."', '".$_POST['h_fin']."', '".$_POST['marcado']."')";
 /*echo $sql;*/
if ($insertar = $mysqli->query($sql)) {
 /*Validamos si el registro fue ingresado con éxito*/ 
echo 'Registro exitoso';
echo '<meta http-equiv="refresh" content="1; url=seguimiento_reto.php" />';
 }else{ 
echo 'Registro fallido';
echo '<meta http-equiv="refresh" content="1; url=seguimiento_reto.php" />';
}
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo"){

$textoh1 ="Registrar";
$textobtn ="Registrar";

echo '<form id="form1" name="form1" method="post" action="seguimiento_reto.php">
<h1>'.$textoh1.'</h1>';
?>

<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_seguimiento_reto']))  echo $row['id_seguimiento_reto'] ?>" size="120" required></p>
<?php 
echo '<p><input class=""name="id_seguimiento_reto"type="hidden" id="id_seguimiento_reto" value="';if (isset($row['id_seguimiento_reto'])) echo $row['id_seguimiento_reto'];echo '"';echo '></p>';
echo '<p><label for="reto">Reto:</label>';
$sql2= "SELECT id_reto,nombre_reto FROM reto;";
echo '<select class="" name="reto" id="reto"  required>';
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta2 = $mysqli->query($sql2);
while($row2=$consulta2->fetch_assoc()){
echo '<option value="'.$row2['id_reto'].'"';if (isset($row['reto']) and $row['reto'] == $row2['id_reto']) echo " selected ";echo '>'.$row2['nombre_reto'].'</option>';
}
echo '</select></p>';
echo '<p><label for="usuario">Usuario:</label>';
$sql3= "SELECT id_usuarios,nombre FROM usuarios;";
echo '<select class="" name="usuario" id="usuario"  required>';
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta3 = $mysqli->query($sql3);
while($row3=$consulta3->fetch_assoc()){
echo '<option value="'.$row3['id_usuarios'].'"';if (isset($row['usuario']) and $row['usuario'] == $row3['id_usuarios']) echo " selected ";echo '>'.$row3['nombre'].'</option>';
}
echo '</select></p>';
echo '<p><input type="hidden" name="aprobado" value="No"><input class=""name="aprobado"type="checkbox" id="aprobado" value="';echo 'Si';echo '"';if (isset($row['aprobado']) and $row['aprobado']=="Si") echo " checked ";echo '><label for="aprobado">Aprobado</label></p>';
echo '<p><label for="h_inicio">Hora de Inicio:</label><input class=""name="h_inicio"type="time" id="h_inicio" value="';if (isset($row['h_inicio'])) echo $row['h_inicio'];echo '"';echo ' required ></p>';
echo '<p><label for="h_fin">Hora de Fin:</label><input class=""name="h_fin"type="time" id="h_fin" value="';if (isset($row['h_fin'])) echo $row['h_fin'];echo '"';echo ' required ></p>';
echo '<p><label for="marcado">Marcado:</label>';
$sql7= "SELECT id_elementos_juego,nombre_elemento FROM elementos_juego;";
echo '<select class="" name="marcado" id="marcado"  required>';
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta7 = $mysqli->query($sql7);
while($row7=$consulta7->fetch_assoc()){
echo '<option value="'.$row7['id_elementos_juego'].'"';if (isset($row['marcado']) and $row['marcado'] == $row7['id_elementos_juego']) echo " selected ";echo '>'.$row7['nombre_elemento'].'</option>';
}
echo '</select></p>';

echo '<p><input type="submit" name="submit" id="submit" value="'.$textobtn.'"></p>
</form>';
} /*fin nuevo*/ 
if ($_POST['submit']=="Modificar"){

$sql = "SELECT `id_seguimiento_reto`, `reto`, `usuario`, `aprobado`, `h_inicio`, `h_fin`, `marcado` FROM `seguimiento_reto` WHERE id_seguimiento_reto ='".$_POST['cod']."' Limit 1"; 
$consulta = $mysqli->query($sql);
 /*echo $sql;*/ 
$row=$consulta->fetch_assoc();

$textoh1 ="Modificar";
$textobtn ="Actualizar";
echo '<form id="form1" name="form1" method="post" action="seguimiento_reto.php">
<h1>'.$textoh1.'</h1>';
?>

<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_seguimiento_reto']))  echo $row['id_seguimiento_reto'] ?>" size="120" required></p>
<?php 
echo '<p><input class=""name="id_seguimiento_reto"type="hidden" id="id_seguimiento_reto" value="';if (isset($row['id_seguimiento_reto'])) echo $row['id_seguimiento_reto'];echo '"';echo '></p>';
echo '<p><label for="reto">Reto:</label>';
$sql2= "SELECT id_reto,nombre_reto FROM reto;";
echo '<select class="" name="reto" id="reto"  required>';
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta2 = $mysqli->query($sql2);
while($row2=$consulta2->fetch_assoc()){
echo '<option value="'.$row2['id_reto'].'"';if (isset($row['reto']) and $row['reto'] == $row2['id_reto']) echo " selected ";echo '>'.$row2['nombre_reto'].'</option>';
}
echo '</select></p>';
echo '<p><label for="usuario">Usuario:</label>';
$sql3= "SELECT id_usuarios,nombre FROM usuarios;";
echo '<select class="" name="usuario" id="usuario"  required>';
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta3 = $mysqli->query($sql3);
while($row3=$consulta3->fetch_assoc()){
echo '<option value="'.$row3['id_usuarios'].'"';if (isset($row['usuario']) and $row['usuario'] == $row3['id_usuarios']) echo " selected ";echo '>'.$row3['nombre'].'</option>';
}
echo '</select></p>';
echo '<p><input type="hidden" name="aprobado" value="No"><input class=""name="aprobado"type="checkbox" id="aprobado" value="';echo 'Si';echo '"';if (isset($row['aprobado']) and $row['aprobado']=="Si") echo " checked ";echo '><label for="aprobado">Aprobado</label></p>';
echo '<p><label for="h_inicio">Hora de Inicio:</label><input class=""name="h_inicio"type="time" id="h_inicio" value="';if (isset($row['h_inicio'])) echo $row['h_inicio'];echo '"';echo ' required ></p>';
echo '<p><label for="h_fin">Hora de Fin:</label><input class=""name="h_fin"type="time" id="h_fin" value="';if (isset($row['h_fin'])) echo $row['h_fin'];echo '"';echo ' required ></p>';
echo '<p><label for="marcado">Marcado:</label>';
$sql7= "SELECT id_elementos_juego,nombre_elemento FROM elementos_juego;";
echo '<select class="" name="marcado" id="marcado"  required>';
echo '<option value="">Seleccione una opci&oacute;n</option>';
$consulta7 = $mysqli->query($sql7);
while($row7=$consulta7->fetch_assoc()){
echo '<option value="'.$row7['id_elementos_juego'].'"';if (isset($row['marcado']) and $row['marcado'] == $row7['id_elementos_juego']) echo " selected ";echo '>'.$row7['nombre_elemento'].'</option>';
}
echo '</select></p>';

echo '<p><input type="submit" name="submit" id="submit" value="'.$textobtn.'"></p>
</form>';
} /*fin modificar*/ 
if ($_POST['submit']=="Actualizar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$cod = $_POST['cod'];
 /*Instrucción SQL que permite insertar en la BD */ 
$sql = "UPDATE seguimiento_reto SET id_seguimiento_reto='".$_POST['id_seguimiento_reto']."', reto='".$_POST['reto']."', usuario='".$_POST['usuario']."', aprobado='".$_POST['aprobado']."', h_inicio='".$_POST['h_inicio']."', h_fin='".$_POST['h_fin']."', marcado='".$_POST['marcado']."'WHERE  id_seguimiento_reto = '".$cod."';";
/* echo $sql;*/ 
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/ 
if ($actualizar = $mysqli->query($sql)) {
 /*Validamos si el registro fue ingresado con éxito*/
echo 'Modificación exitosa';
echo '<meta http-equiv="refresh" content="1; url=seguimiento_reto.php" />';
 }else{ 
echo 'Modificacion fallida';
}
echo '<meta http-equiv="refresh" content="2; url=seguimiento_reto.php" />';
} /*fin Actualizar*/ 
 }else{ 
 ?>
<center>
<b><label>Buscar: </label></b><input type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados:</label></b>
<input type="number" min="0" id="numeroresultados_seguimiento_reto" placeholder="Cantidad de resultados" title="Cantidad de resultados" value="10" onkeyup="grabarcookie('numeroresultados_seguimiento_reto',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_seguimiento_reto',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_seguimiento_reto',this.value);buscar(document.getElementById('buscar').value);" size="4" style="width: 40px;">
</center>
<span id="txtsugerencias">
<?php 
buscar_seguimiento_reto();
 ?>
</span>
<?php 
}/*fin else if isset cod*/
echo '</center>';
 ?>
<script>
document.getElementById('menu_seguimiento_reto').className ='active '+document.getElementById('menu_seguimiento_reto').className;
</script>
<?php $contenido = ob_get_contents();
ob_clean();
include ("home.php");
 ?>
