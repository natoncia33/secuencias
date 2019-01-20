<?php 
ob_start();
@session_start();
@session_start();
if (!isset($_SESSION['email'])){
 if ($_SESSION['tipo']!="Administrador"){
    header("Location: login.php"); 
 }
}
echo '<center>';
require("../config/conexion.php");
require_once("../config/funciones.php");
function buscar_elementos_juego($datos="",$reporte=""){
require("../config/conexion.php");
$sql = "SELECT `elementos_juego`.`id_elementos_juego`, `elementos_juego`.`tipo`, `elementos_juego`.`nombre_elemento`, `elementos_juego`.`archivo` FROM `elementos_juego`   ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' WHERE ';
foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`elementos_juego`.`id_elementos_juego`)," ", LOWER(`elementos_juego`.`tipo`)," ", LOWER(`elementos_juego`.`nombre_elemento`)) LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
$sql .=  " ORDER BY `elementos_juego`.`id_elementos_juego` desc LIMIT ";
if (isset($_COOKIE['numeroresultados_elementos_juego']) and $_COOKIE['numeroresultados_elementos_juego']!="") $sql .=$_COOKIE['numeroresultados_elementos_juego'];
else $sql .= "10";
/*echo $sql;*/ 

$consulta = $mysqli->query($sql);
 ?>
<div align="center">
<table border="1" id="tbelementos_juego">
<thead>
<tr>
<th>Tipo</th>
<th>Elemento</th>
<?php if ($reporte==""){ ?>
<th colspan="2"><form id="formNuevo" name="formNuevo" method="post" action="elementos_juego.php">
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
<?php $datostipo = array("Vocal" => "Vocal", "Silaba" => "Silaba", "Figura" => "Figura", "Palabra" => "Palabra"); ?>
<td><?php echo $datostipo[$row['tipo']] ?></td>
<td>
 <?php if ($row['archivo']!=""){?>
 <img width="80" src="../img/figuras/<?php echo $row['archivo']?>">
 <br>
 <?php } ?> 
<?php echo $row['nombre_elemento']?></td>
<?php if ($reporte==""){ ?>
<td>
<form id="formModificar" name="formModificar" method="post" action="elementos_juego.php">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_elementos_juego']?>">
<input type="submit" name="submit" id="submit" value="Modificar">
</form>
</td>
<td>
<input type="image" src="img/eliminar.png" onClick="confirmeliminar('elementos_juego.php',{'del':'<?php echo $row['id_elementos_juego'];?>'},'<?php echo $row['id_elementos_juego'];?>');" value="Eliminar">
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
buscar_elementos_juego($_POST['datos']);
exit();
}

if (isset($_POST['del'])){
/*Instrucción SQL que permite eliminar en la BD*/ 
$sql = 'DELETE FROM elementos_juego WHERE id_elementos_juego="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
if ($eliminar = $mysqli->query($sql)){
 /*Validamos si el registro fue eliminado con éxito*/ 
echo '
Registro eliminado
<meta http-equiv="refresh" content="1; url=elementos_juego.php" />
'; 
}else{
?>
Eliminación fallida, por favor compruebe que la usuario no esté en uso
<meta http-equiv="refresh" content="2; url=elementos_juego.php" />
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
$sql = "INSERT INTO elementos_juego (`id_elementos_juego`, `tipo`, `nombre_elemento`, `archivo`) VALUES ('".$_POST['id_elementos_juego']."', '".$_POST['tipo']."', '".$_POST['nombre_elemento']."', ";
if ($_POST['archivo']!="") $sql .= "'".$_POST['archivo']."'";
else $sql .= "NULL";
$sql .= ")";
 /*echo $sql;*/
if ($insertar = $mysqli->query($sql)) {
 /*Validamos si el registro fue ingresado con éxito*/ 
echo 'Registro exitoso';
echo '<meta http-equiv="refresh" content="1; url=elementos_juego.php" />';
 }else{ 
echo 'Registro fallido';
echo '<meta http-equiv="refresh" content="1; url=elementos_juego.php" />';
}
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo"){

$textoh1 ="Registrar";
$textobtn ="Registrar";

echo '<form id="form1" name="form1" method="post" action="elementos_juego.php">
<h1>'.$textoh1.'</h1>';
?>

<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_elementos_juego']))  echo $row['id_elementos_juego'] ?>" size="120" required></p>
<?php 
echo '<p><input class=""name="id_elementos_juego"type="hidden" id="id_elementos_juego" value="';if (isset($row['id_elementos_juego'])) echo $row['id_elementos_juego'];echo '"';echo '></p>';
echo '<p><label for="tipo">Tipo:</label><select class="" name="tipo" id="tipo"  required><option value="">Seleccione una opci&oacute;n</option><option value="Vocal"';if (isset($row['tipo']) and $row['tipo'] =="Vocal") echo " selected ";echo '>Vocal</option><option value="Silaba"';if (isset($row['tipo']) and $row['tipo'] =="Silaba") echo " selected ";echo '>Silaba</option><option value="Figura"';if (isset($row['tipo']) and $row['tipo'] =="Figura") echo " selected ";echo '>Figura</option><option value="Palabra"';if (isset($row['tipo']) and $row['tipo'] =="Palabra") echo " selected ";echo '>Palabra</option></select></p>';
echo '<p><label for="nombre_elemento">Nombre Elemento:</label><input class=""name="nombre_elemento"type="text" id="nombre_elemento" value="';if (isset($row['nombre_elemento'])) echo $row['nombre_elemento'];echo '"';echo ' required ></p>';
echo '<p><label for="archivo">Archivo:</label><input class=""name="archivo"type="file" id="archivo" value="';if (isset($row['archivo'])) echo $row['archivo'];echo '"';echo '></p>';

echo '<p><input type="submit" name="submit" id="submit" value="'.$textobtn.'"></p>
</form>';
} /*fin nuevo*/ 
if ($_POST['submit']=="Modificar"){

$sql = "SELECT `id_elementos_juego`, `tipo`, `nombre_elemento`, `archivo` FROM `elementos_juego` WHERE id_elementos_juego ='".$_POST['cod']."' Limit 1"; 
$consulta = $mysqli->query($sql);
 /*echo $sql;*/ 
$row=$consulta->fetch_assoc();

$textoh1 ="Modificar";
$textobtn ="Actualizar";
echo '<form id="form1" name="form1" method="post" action="elementos_juego.php">
<h1>'.$textoh1.'</h1>';
?>

<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_elementos_juego']))  echo $row['id_elementos_juego'] ?>" size="120" required></p>
<?php 
echo '<p><input class=""name="id_elementos_juego"type="hidden" id="id_elementos_juego" value="';if (isset($row['id_elementos_juego'])) echo $row['id_elementos_juego'];echo '"';echo '></p>';
echo '<p><label for="tipo">Tipo:</label><select class="" name="tipo" id="tipo"  required><option value="">Seleccione una opci&oacute;n</option><option value="Vocal"';if (isset($row['tipo']) and $row['tipo'] =="Vocal") echo " selected ";echo '>Vocal</option><option value="Silaba"';if (isset($row['tipo']) and $row['tipo'] =="Silaba") echo " selected ";echo '>Silaba</option><option value="Figura"';if (isset($row['tipo']) and $row['tipo'] =="Figura") echo " selected ";echo '>Figura</option><option value="Palabra"';if (isset($row['tipo']) and $row['tipo'] =="Palabra") echo " selected ";echo '>Palabra</option></select></p>';
echo '<p><label for="nombre_elemento">Nombre Elemento:</label><input class=""name="nombre_elemento"type="text" id="nombre_elemento" value="';if (isset($row['nombre_elemento'])) echo $row['nombre_elemento'];echo '"';echo ' required ></p>';
echo '<p><label for="archivo">Archivo:</label><input class=""name="archivo"type="file" id="archivo" value="';if (isset($row['archivo'])) echo $row['archivo'];echo '"';echo '></p>';

echo '<p><input type="submit" name="submit" id="submit" value="'.$textobtn.'"></p>
</form>';
} /*fin modificar*/ 
if ($_POST['submit']=="Actualizar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$cod = $_POST['cod'];
 /*Instrucción SQL que permite insertar en la BD */ 
$sql = "UPDATE elementos_juego SET id_elementos_juego='".$_POST['id_elementos_juego']."', tipo='".$_POST['tipo']."', nombre_elemento='".$_POST['nombre_elemento']."', archivo='".$_POST['archivo']."'WHERE  id_elementos_juego = '".$cod."';";
/* echo $sql;*/ 
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/ 
if ($actualizar = $mysqli->query($sql)) {
 /*Validamos si el registro fue ingresado con éxito*/
echo 'Modificación exitosa';
echo '<meta http-equiv="refresh" content="1; url=elementos_juego.php" />';
 }else{ 
echo 'Modificacion fallida';
}
echo '<meta http-equiv="refresh" content="2; url=elementos_juego.php" />';
} /*fin Actualizar*/ 
 }else{ 
 ?>
<center>
<b><label>Buscar: </label></b><input type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados:</label></b>
<input type="number" min="0" id="numeroresultados_elementos_juego" placeholder="Cantidad de resultados" title="Cantidad de resultados" value="10" onkeyup="grabarcookie('numeroresultados_elementos_juego',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_elementos_juego',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_elementos_juego',this.value);buscar(document.getElementById('buscar').value);" size="4" style="width: 40px;">
</center>
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
document.getElementById('menu_elementos_juego').className ='active '+document.getElementById('menu_elementos_juego').className;
</script>
<?php $contenido = ob_get_contents();
ob_clean();
include ("../plantilla/home.php");
 ?>
