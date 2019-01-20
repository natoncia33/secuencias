<?php 
ob_start();
@session_start();
if (!isset($_SESSION['email'])){
    header("Location: login.php");
}
echo '<center>';
require_once(dirname(__FILE__)."/../config/conexion.php");
 /*require_once(dirname(__FILE__)."/../config/funciones.php");*/ 
function buscar_instrucciones_juego($datos="",$reporte=""){

require_once(dirname(__FILE__)."/../config/conexion.php");

$sql = "SELECT `instrucciones_juego`.`id_instrucciones_juego`, `instrucciones_juego`.`texto`, `instrucciones_juego`.`url_audio` FROM `instrucciones_juego`   ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' WHERE ';
foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`instrucciones_juego`.`id_instrucciones_juego`)," ", LOWER(`instrucciones_juego`.`texto`)," ", LOWER(`instrucciones_juego`.`url_audio`)," ") LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
$sql .=  " ORDER BY `instrucciones_juego`.`id_instrucciones_juego` desc LIMIT ";
if (isset($_COOKIE['numeroresultados_instrucciones_juego']) and $_COOKIE['numeroresultados_instrucciones_juego']!="") $sql .=$_COOKIE['numeroresultados_instrucciones_juego'];
else $sql .= "10";
/*echo $sql;*/ 

$consulta = $mysqli->query($sql);
 ?>
<div align="center">
<table border="1" id="tbinstrucciones_juego">
<thead>
<tr>
<th>Id Instrucciones Juego</th>
<th>Texto</th>
<th>Audio</th>
<?php if ($reporte==""){ ?>
<th colspan="2"><form id="formNuevo" name="formNuevo" method="post" action="instrucciones_juego.php">
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
<td><?php echo $row['id_instrucciones_juego']?></td>
<td><?php echo $row['texto']?></td>
<td><?php echo $row['url_audio']?></td>
<?php if ($reporte==""){ ?>
<td>
<form id="formModificar" name="formModificar" method="post" action="instrucciones_juego.php">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_instrucciones_juego']?>">
<input type="submit" name="submit" id="submit" value="Modificar">
</form>
</td>
<td>
<input type="image" src="img/eliminar.png" onClick="confirmeliminar('instrucciones_juego.php',{'del':'<?php echo $row['id_instrucciones_juego'];?>'},'<?php echo $row['id_instrucciones_juego'];?>');" value="Eliminar">
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
buscar_instrucciones_juego($_POST['datos']);
exit();
}

if (isset($_POST['del'])){
 /*Instrucción SQL que permite eliminar en la BD*/ 
$sql = 'DELETE FROM instrucciones_juego WHERE id_instrucciones_juego="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
if ($eliminar = $mysqli->query($sql)){
 /*Validamos si el registro fue eliminado con éxito*/ 
echo '
Registro eliminado
<meta http-equiv="refresh" content="1; url=instrucciones_juego.php" />
'; 
}else{
?>
Eliminación fallida, por favor compruebe que la usuario no esté en uso
<meta http-equiv="refresh" content="2; url=instrucciones_juego.php" />
<?php 
}
}
 ?>
<center>
<h1>Instrucciones Juego</h1>
</center><?php 
if (isset($_POST['submit'])){
if ($_POST['submit']=="Registrar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$sql = "INSERT INTO instrucciones_juego (`id_instrucciones_juego`, `texto`, `url_audio`) VALUES ('".$_POST['id_instrucciones_juego']."', '".$_POST['texto']."', '".$_POST['url_audio']."')";
 /*echo $sql;*/
if ($insertar = $mysqli->query($sql)) {
 /*Validamos si el registro fue ingresado con éxito*/ 
echo 'Registro exitoso';
echo '<meta http-equiv="refresh" content="1; url=instrucciones_juego.php" />';
 }else{ 
echo 'Registro fallido';
echo '<meta http-equiv="refresh" content="1; url=instrucciones_juego.php" />';
}
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo"){

$textoh1 ="Registrar";
$textobtn ="Registrar";

echo '<form id="form1" name="form1" method="post" action="instrucciones_juego.php">
<h1>'.$textoh1.'</h1>';
?>

<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_instrucciones_juego']))  echo $row['id_instrucciones_juego'] ?>" size="120" required></p>
<?php 
echo '<p><input class=""name="id_instrucciones_juego"type="hidden" id="id_instrucciones_juego" value="';if (isset($row['id_instrucciones_juego'])) echo $row['id_instrucciones_juego'];echo '"';echo '></p>';
echo '<p><label for="texto">Texto:</label></p><p><textarea class="" name="texto" cols="60" rows="10"id="texto"  required>';if (isset($row['texto'])) echo $row['texto'];echo '</textarea></p>';
echo '<p><label for="url_audio">Audio:</label><input class=""name="url_audio"type="file" id="url_audio" value="';if (isset($row['url_audio'])) echo $row['url_audio'];echo '"';echo ' required ></p>';

echo '<p><input type="submit" name="submit" id="submit" value="'.$textobtn.'"></p>
</form>';
} /*fin nuevo*/ 
if ($_POST['submit']=="Modificar"){

$sql = "SELECT `id_instrucciones_juego`, `texto`, `url_audio` FROM `instrucciones_juego` WHERE id_instrucciones_juego ='".$_POST['cod']."' Limit 1"; 
$consulta = $mysqli->query($sql);
 /*echo $sql;*/ 
$row=$consulta->fetch_assoc();

$textoh1 ="Modificar";
$textobtn ="Actualizar";
echo '<form id="form1" name="form1" method="post" action="instrucciones_juego.php">
<h1>'.$textoh1.'</h1>';
?>

<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_instrucciones_juego']))  echo $row['id_instrucciones_juego'] ?>" size="120" required></p>
<?php 
echo '<p><input class=""name="id_instrucciones_juego"type="hidden" id="id_instrucciones_juego" value="';if (isset($row['id_instrucciones_juego'])) echo $row['id_instrucciones_juego'];echo '"';echo '></p>';
echo '<p><label for="texto">Texto:</label></p><p><textarea class="" name="texto" cols="60" rows="10"id="texto"  required>';if (isset($row['texto'])) echo $row['texto'];echo '</textarea></p>';
echo '<p><label for="url_audio">Audio:</label><input class=""name="url_audio"type="file" id="url_audio" value="';if (isset($row['url_audio'])) echo $row['url_audio'];echo '"';echo ' required ></p>';

echo '<p><input type="submit" name="submit" id="submit" value="'.$textobtn.'"></p>
</form>';
} /*fin modificar*/ 
if ($_POST['submit']=="Actualizar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$cod = $_POST['cod'];
 /*Instrucción SQL que permite insertar en la BD */ 
$sql = "UPDATE instrucciones_juego SET id_instrucciones_juego='".$_POST['id_instrucciones_juego']."', texto='".$_POST['texto']."', url_audio='".$_POST['url_audio']."'WHERE  id_instrucciones_juego = '".$cod."';";
/* echo $sql;*/ 
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/ 
if ($actualizar = $mysqli->query($sql)) {
 /*Validamos si el registro fue ingresado con éxito*/
echo 'Modificación exitosa';
echo '<meta http-equiv="refresh" content="1; url=instrucciones_juego.php" />';
 }else{ 
echo 'Modificacion fallida';
}
echo '<meta http-equiv="refresh" content="2; url=instrucciones_juego.php" />';
} /*fin Actualizar*/ 
 }else{ 
 ?>
<center>
<b><label>Buscar: </label></b><input type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados:</label></b>
<input type="number" min="0" id="numeroresultados_instrucciones_juego" placeholder="Cantidad de resultados" title="Cantidad de resultados" value="10" onkeyup="grabarcookie('numeroresultados_instrucciones_juego',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_instrucciones_juego',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_instrucciones_juego',this.value);buscar(document.getElementById('buscar').value);" size="4" style="width: 40px;">
</center>
<span id="txtsugerencias">
<?php 
buscar_instrucciones_juego();
 ?>
</span>
<?php 
}/*fin else if isset cod*/
echo '</center>';
 ?>
<script>
document.getElementById('menu_instrucciones_juego').className ='active '+document.getElementById('menu_instrucciones_juego').className;
</script>
<?php $contenido = ob_get_contents();
ob_clean();
include ("home.php");
 ?>
