<?php 
ob_start();
@session_start();
if (!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}
if ($_SESSION['tipo']!="admin"){
echo "Ingreso Incorrecto";
$contenido = ob_get_contents();
ob_clean();
include ("../plantilla/home.php");
 exit();
}
require_once(dirname(__FILE__)."/../config/conexion.php");
require_once(dirname(__FILE__)."/../config/funciones.php");
?>
<center>
	<style>
div.show-top-margin{margin-top:2em;}.show-grid{margin-bottom:2em;}.show-grid [class^="col-"]{padding-top:10px;padding-bottom:10px;border:1px solid #AAA;background-color:#EEE;background-color:rgba(200,200,200,0.3);}.responsive-utilities-test .col-xs-6{margin-bottom:10px;}.responsive-utilities-test span{padding:15px 10px;font-size:14px;font-weight:bold;line-height:1.1;text-align:center;border-radius:4px;}.visible-on .col-xs-6 .hidden-xs,.visible-on .col-xs-6 .hidden-sm,.visible-on .col-xs-6 .hidden-md,.visible-on .col-xs-6 .hidden-lg,.hidden-on .col-xs-6 .visible-xs,.hidden-on .col-xs-6 .visible-sm,.hidden-on .col-xs-6 .visible-md,.hidden-on .col-xs-6 .visible-lg{color:#999;border:1px solid #ddd;}.visible-on .col-xs-6 .visible-xs,.visible-on .col-xs-6 .visible-sm,.visible-on .col-xs-6 .visible-md,.visible-on .col-xs-6 .visible-lg,.hidden-on .col-xs-6 .hidden-xs,.hidden-on .col-xs-6 .hidden-sm,.hidden-on .col-xs-6 .hidden-md,.hidden-on .col-xs-6 .hidden-lg{color:#468847;background-color:#dff0d8;border:1px solid #d6e9c6;}div.controls input,div.controls select{margin-bottom:.5em;}#inputSeleccionado{border-color:rgba(82,168,236,.8);outline:0;outline:thin dotted \9;-moz-box-shadow:0 0 8px rgba(82,168,236,.6);box-shadow:0 0 8px rgba(82,168,236,.6);}.bs-glyphicons{padding-left:0;padding-bottom:1px;margin-bottom:20px;list-style:none;overflow:hidden;}.bs-glyphicons li{float:left;width:25%;height:115px;padding:10px;margin:0 -1px -1px 0;font-size:12px;line-height:1.4;text-align:center;border:1px solid #ddd;}.bs-glyphicons .glyphicon{display:block;margin:5px auto 10px;font-size:24px;}.bs-glyphicons li:hover{background-color:rgba(86,61,124,.1);}@media (min-width: 768px) {.bs-glyphicons li{width:12.5%;}}.btn-toolbar+.btn-toolbar{margin-top:10px;}.dropdown>.dropdown-menu{position:static;display:block;margin-bottom:5px;}form .row{margin-bottom:1em;}.nav .dropdown-menu{display:none;}.nav .open .dropdown-menu{display:block;position:absolute;}
</style>
<?php
function buscar_usuarios($datos="",$reporte=""){
require_once(dirname(__FILE__)."/../config/conexion.php");
$sql = "SELECT `usuarios`.`puntos`,`usuarios`.`id_usuarios`, `avatar`.`img_avatar`, `usuarios`.`nombre`, `usuarios`.`apellido1`, `usuarios`.`apellido2`, `usuarios`.`nuip`, `usuarios`.`email`, `usuarios`.`clave`, `usuarios`.`f_nacimiento`, `usuarios`.`tipo` FROM `usuarios` inner join `avatar` on `usuarios`.`avatar` = `avatar`.`id_avatar` ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' WHERE ';
foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`usuarios`.`id_usuarios`)," ", LOWER(`usuarios`.`nombre`)," ", LOWER(`usuarios`.`apellido1`)," ", LOWER(`usuarios`.`apellido2`)," ", LOWER(`usuarios`.`nuip`)," ", LOWER(`usuarios`.`email`)," ", LOWER(`usuarios`.`clave`)," ", LOWER(`usuarios`.`f_nacimiento`)," ", LOWER(`usuarios`.`tipo`)," ") LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
$sql .=  " ORDER BY `usuarios`.`id_usuarios` desc LIMIT ";
if (isset($_COOKIE['numeroresultados_usuarios']) and $_COOKIE['numeroresultados_usuarios']!="") $sql .=$_COOKIE['numeroresultados_usuarios'];
else $sql .= "10";
/*echo $sql;*/ 

$consulta = $mysqli->query($sql);
 ?>
<div align="center">
<table border="1" id="tbusuarios">
<thead>
<tr>
<th>Id Usuarios</th>
<th>Nombre</th>
<th>Primer Apellido</th>
<th>Segundo Apellido</th>
<th>Identificación</th>
<th>Email</th>
<th>Fecha de Nacimiento</th>
<th>Tipo de usuario</th>
<th>Avatar</th>
<th>Puntos</th>
<?php if ($reporte==""){ ?>
<th colspan="2"><form id="formNuevo" name="formNuevo" method="post" action="usuarios.php">
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
<td><?php echo $row['id_usuarios']?></td>
<td><?php echo $row['nombre']?></td>
<td><?php echo $row['apellido1']?></td>
<td><?php echo $row['apellido2']?></td>
<td><?php echo $row['nuip']?></td>
<td><?php echo $row['email']?></td>
<?php $meses = array ('','\\E\\n\\e\\r\\o','\\F\\e\\b\\r\\e\\r\\o','\\M\\a\\r\\z\\o','\\A\\b\\r\\i\\l','\\M\\a\\y\\o','\\J\\u\\n\\i\\o','\\J\\u\\l\\i\\o','\\A\\g\\o\\s\\t\\o','\\S\\e\\p\\t\\i\\e\\m\\b\\r\\e','\\O\\c\\t\\u\\b\\r\\e','\\N\\o\\v\\i\\e\\m\\b\\r\\e','\\D\\i\\c\\i\\e\\m\\b\\r\\e'); ?>
<td><?php echo  date("d \\d\\e ".$meses[date("n",strtotime($row['f_nacimiento']))]."  \\d\\e\\l \\a\\ñ\\o Y ",strtotime($row['f_nacimiento'])); ?></td>
<?php $datostipo = array("admin" => "Administrador", "docente" => "Docente", "estudiante" => "Estudiante"); ?>
<td><?php echo $datostipo[$row['tipo']] ?></td>
<td><img height="80" src="Avatars/<?php echo $row['img_avatar']?>"></td>
<td><?php echo $row['puntos']?></td>
<?php if ($reporte==""){ ?>
<td>
<form id="formModificar" name="formModificar" method="post" action="usuarios.php">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_usuarios']?>">
<input type="submit" name="submit" id="submit" value="Modificar">
</form>
</td>
<td>
<input type="image" src="img/eliminar.png" onClick="confirmeliminar('usuarios.php',{'del':'<?php echo $row['id_usuarios'];?>'},'<?php echo $row['id_usuarios'];?>');" value="Eliminar">
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
buscar_usuarios($_POST['datos']);
exit();
}

if (isset($_POST['del'])){
 /*Instrucción SQL que permite eliminar en la BD*/ 
$sql = 'DELETE FROM usuarios WHERE id_usuarios="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
if ($eliminar = $mysqli->query($sql)){
 /*Validamos si el registro fue eliminado con éxito*/ 
echo '
Registro eliminado
<meta http-equiv="refresh" content="1; url=usuarios.php" />
'; 
}else{
?>
Eliminación fallida, por favor compruebe que la usuario no esté en uso
<meta http-equiv="refresh" content="2; url=usuarios.php" />
<?php 
}
}
 ?>
<center>
<h1>Usuarios</h1>
</center><?php 
if (isset($_POST['submit'])){
if ($_POST['submit']=="Registrar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$sql = "INSERT INTO usuarios (`id_usuarios`, `nombre`, `apellido1`, `apellido2`, `nuip`, `email`, `clave`, `f_nacimiento`, `tipo`, `avatar`) VALUES ('".$_POST['id_usuarios']."', '".$_POST['nombre']."', '".$_POST['apellido1']."', '".$_POST['apellido2']."', '".$_POST['nuip']."', '".$_POST['email']."', '".$_POST['clave']."', '".$_POST['f_nacimiento']."', '".$_POST['tipo']."', '".$_POST['icon']."')";
# echo $sql;
#exit();
if ($insertar = $mysqli->query($sql)) {
 /*Validamos si el registro fue ingresado con éxito*/ 
echo 'Registro exitoso';
echo '<meta http-equiv="refresh" content="1; url=usuarios.php" />';
 }else{ 
echo 'Registro fallido';
echo '<meta http-equiv="refresh" content="1; url=usuarios.php" />';
}
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo"){

$textoh1 ="Registrar";
$textobtn ="Registrar";

echo '<form id="form1" name="form1" method="post" action="usuarios.php">
<h1>'.$textoh1.'</h1>';
?>

<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_usuarios']))  echo $row['id_usuarios'] ?>" size="120" required></p>
<?php 
echo '<p><input class=""name="id_usuarios"type="hidden" id="id_usuarios" value="';if (isset($row['id_usuarios'])) echo $row['id_usuarios'];echo '"';echo '></p>';
echo '<p><label for="nombre">Nombre:</label><input class=""name="nombre"type="text" id="nombre" value="';if (isset($row['nombre'])) echo $row['nombre'];echo '"';echo ' required ></p>';
echo '<p><label for="apellido1">Primer Apellido:</label><input class=""name="apellido1"type="text" id="apellido1" value="';if (isset($row['apellido1'])) echo $row['apellido1'];echo '"';echo ' required ></p>';
echo '<p><label for="apellido2">Segundo Apellido:</label><input class=""name="apellido2"type="text" id="apellido2" value="';if (isset($row['apellido2'])) echo $row['apellido2'];echo '"';echo '></p>';
echo '<p><label for="nuip">Identificación:</label><input class=""name="nuip"type="number"  min="0" id="nuip" value="';if (isset($row['nuip'])) echo $row['nuip'];echo '"';echo ' required ></p>';
echo '<p><label for="email">Email:</label><input class=""name="email"type="email" id="email" value="';if (isset($row['email'])) echo $row['email'];echo '"';echo ' required ></p>';
echo '<p><label for="clave">Clave:</label><input class=""name="clave"type="password" id="clave" value="';if (isset($row['clave'])) echo $row['clave'];echo '"';echo ' required ><input type="checkbox" onclick="document.getElementById(\'clave\').type = document.getElementById(\'clave\').type == \'text\' ? \'password\' : \'text\'"/><label>Ver</label></p>';
echo '<p><label for="f_nacimiento">Fecha de Nacimiento:</label><input class=""name="f_nacimiento"type="date" id="f_nacimiento" value="';if (isset($row['f_nacimiento'])) echo $row['f_nacimiento'];echo '"';echo ' required ></p>';
?>
<p><label for="tipo">Tipo de usuario:</label>
<br>
<label><input type="radio" class="" name="tipo" id="tipo_admin"  required value="admin" 
<?php
if (isset($row['tipo']) and $row['tipo'] =="Administrador") 
echo " checked ";
?>
>Administrador</label>
<br>
<label><input type="radio" class="" name="tipo" id="tipo_docente"  required value="docente" 
<?php
if (isset($row['tipo']) and $row['tipo'] =="docente") 
echo " checked ";
?>
>Docente</label>
<br>
<label><input type="radio" class="" name="tipo" id="tip_estudiante]" required value="estudiante"
<?php if (isset($row['tipo']) and $row['tipo'] =="estudiante") echo " checked "; ?>
>Estudiante</label>
<br>
<br>
</p>
Avatar: <img height="80" id="icon-img" src="">
<span id="icono"></span>
<input onchange="document.getElementById('icon-img').src = this.value" type="hidden" id="icon" name="icon" value=""/>
<button type="button" class="btn btn-info btn-s" data-toggle="modal" data-target="#myModal">Elegir</button>
<div class="container">
  <!-- Modal -->
  <div class="modal modal-fullscreen fade" id="myModal" role="dialog">
    <div class="modal-dialog">
  <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
  <ul class="bs-glyphicons">
	<?php
	$sql_av = "SELECT `avatar`.`id_avatar`, `avatar`.`nombre_avatar`, `avatar`.`img_avatar` FROM `avatar`";
	$consulta_av = $mysqli->query($sql_av);
	foreach(glob("Avatars/*.*") as $nombre){
	while($row_av=$consulta_av->fetch_assoc()){
	//$nombre2 = str_replace("Avatars/","",$nombre);
	?>
	<li><span onclick="obtener_icono(this)" data-src="Avatars/<?php echo $row_av['img_avatar'] ?>" data-id="<?php echo $row_av['id_avatar'] ?>" ><img height="80" src="Avatars/<?php echo $row_av['img_avatar'] ?>"><?php echo $row_av['nombre_avatar']?></span></li>
	<?php } ?>
	<?php } ?>
    </ul> </div>
       <div class="modal-footer">
        <a class="close btn" data-dismiss="modal">Cerrar</a>
    </div>
      </div>
      
    </div>
  </div>
  
</div>

</div>
<?php
#fin modal
echo '<p><input class="btn btn-primary" type="submit" name="submit" id="submit" value="'.$textobtn.'"></p>
</form>';
} /*fin nuevo*/ 
if ($_POST['submit']=="Modificar"){

$sql = "SELECT `usuarios`.`id_usuarios`, `usuarios`.`nombre`, `usuarios`.`apellido1`, `usuarios`.`apellido2`, `usuarios`.`nuip`, `usuarios`.`email`, `clave`, `usuarios`.`f_nacimiento`, `usuarios`.`tipo`, `avatar`.`img_avatar` FROM `usuarios` inner join `avatar` on `usuarios`.`avatar` = `avatar`.`id_avatar` WHERE `usuarios`.id_usuarios ='".$_POST['cod']."' Limit 1"; 
$consulta = $mysqli->query($sql);
 /*echo $sql;*/ 
$row=$consulta->fetch_assoc();

$textoh1 ="Modificar";
$textobtn ="Actualizar";
echo '<form id="form1" name="form1" method="post" action="usuarios.php">
<h1>'.$textoh1.'</h1>';
?>

<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_usuarios']))  echo $row['id_usuarios'] ?>" size="120" required></p>
<?php 
echo '<p><input class=""name="id_usuarios"type="hidden" id="id_usuarios" value="';if (isset($row['id_usuarios'])) echo $row['id_usuarios'];echo '"';echo '></p>';
echo '<p><label for="nombre">Nombre:</label><input class=""name="nombre"type="text" id="nombre" value="';if (isset($row['nombre'])) echo $row['nombre'];echo '"';echo ' required ></p>';
echo '<p><label for="apellido1">Primer Apellido:</label><input class=""name="apellido1"type="text" id="apellido1" value="';if (isset($row['apellido1'])) echo $row['apellido1'];echo '"';echo ' required ></p>';
echo '<p><label for="apellido2">Segundo Apellido:</label><input class=""name="apellido2"type="text" id="apellido2" value="';if (isset($row['apellido2'])) echo $row['apellido2'];echo '"';echo '></p>';
echo '<p><label for="nuip">Identificación:</label><input class=""name="nuip"type="number"  min="0" id="nuip" value="';if (isset($row['nuip'])) echo $row['nuip'];echo '"';echo ' required ></p>';
echo '<p><label for="email">Email:</label><input class=""name="email"type="email" id="email" value="';if (isset($row['email'])) echo $row['email'];echo '"';echo ' required ></p>';
echo '<p><label for="clave">Clave:</label><input class=""name="clave"type="password" id="clave" value="';if (isset($row['clave'])) echo $row['clave'];echo '"';echo ' required ><input type="checkbox" onclick="document.getElementById(\'clave\').type = document.getElementById(\'clave\').type == \'text\' ? \'password\' : \'text\'"/><label>Ver</label></p>';
echo '<p><label for="f_nacimiento">Fecha de Nacimiento:</label><input class=""name="f_nacimiento"type="date" id="f_nacimiento" value="';if (isset($row['f_nacimiento'])) echo $row['f_nacimiento'];echo '"';echo ' required ></p>';
#echo '<p><label for="tipo">Tipo de usuario:</label><br><input type="radio" class="" name="tipo" id="tipo[1]"  required value="Usuario"';if (isset($row['tipo']) and $row['tipo'] =="Usuario") echo " checked ";echo '><label>Usuario</label><br><input type="radio" class="" name="tipo" id="tipo[2]"  required value="Administrador"';if (isset($row['tipo']) and $row['tipo'] =="Administrador") echo " checked ";echo '><label>Administrador</label><br></p>';
?>
<p><label for="tipo">Tipo de usuario:</label>
<br>
<label><input type="radio" class="" name="tipo" id="tipo_admin"  required value="admin" 
<?php
if (isset($row['tipo']) and $row['tipo'] =="admin") 
echo " checked ";
?>
>Administrador</label>
<br>
<label><input type="radio" class="" name="tipo" id="tipo_docente"  required value="docente" 
<?php
if (isset($row['tipo']) and $row['tipo'] =="docente") 
echo " checked ";
?>
>Docente</label>
<br>
<label><input type="radio" class="" name="tipo" id="tip_estudiante]" required value="estudiante"
<?php if (isset($row['tipo']) and $row['tipo'] =="estudiante") echo " checked "; ?>
>Estudiante</label>
<br>
<br>
</p>
Avatar: <img height="80" id="icon-img" src="<?php if (isset($row['img_avatar'])) echo "Avatars/".$row['img_avatar'] ?>">
<span id="icono"></span>
<input onchange="document.getElementById('icon-img').src = this.value" type="hidden" id="icon" name="icon" value="<?php if (isset($row['img_avatar'])) echo "Avatars/".$row['img_avatar'] ?>"/>
<button type="button" class="btn btn-info btn-s" data-toggle="modal" data-target="#myModal">Elegir</button>
<div class="container">
  <!-- Modal -->
  <div class="modal modal-fullscreen fade" id="myModal" role="dialog">
    <div class="modal-dialog">
  <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
  <ul class="bs-glyphicons">
	<?php
	$sql_av = "SELECT `avatar`.`id_avatar`, `avatar`.`nombre_avatar`, `avatar`.`img_avatar` FROM `avatar`";
	$consulta_av = $mysqli->query($sql_av);
	while($row_av=$consulta_av->fetch_assoc()){
	//$nombre2 = str_replace("Avatars/","",$nombre);
	?>
	<li <?php if ($row['img_avatar']==$row_av['img_avatar']) echo 'style="background-color:#d6e6d6"'?>><span onclick="obtener_icono(this)" data-src="Avatars/<?php echo $row_av['img_avatar'] ?>" data-id="<?php echo $row_av['id_avatar'] ?>" ><img height="80" src="Avatars/<?php echo $row_av['img_avatar'] ?>"><?php echo $row_av['nombre_avatar']?></span></li>
	<?php } ?>
    </ul> </div>
    <div class="modal-footer">
        <a class="close btn" data-dismiss="modal">Cerrar</a>
    </div>
      </div>
      
    </div>
  </div>
  
</div>

</div>
<?php
#fin modal
echo '<p><input  class="btn btn-primary" type="submit" name="submit" id="submit" value="'.$textobtn.'"></p>
</form>';
} /*fin modificar*/ 
if ($_POST['submit']=="Actualizar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$cod = $_POST['cod'];
 /*Instrucción SQL que permite insertar en la BD */ 
$sql = "UPDATE usuarios SET id_usuarios='".$_POST['id_usuarios']."', nombre='".$_POST['nombre']."', apellido1='".$_POST['apellido1']."', apellido2='".$_POST['apellido2']."', nuip='".$_POST['nuip']."', email='".$_POST['email']."', clave='".$_POST['clave']."', f_nacimiento='".$_POST['f_nacimiento']."', tipo='".$_POST['tipo']."', avatar='".$_POST['icon']."' WHERE  id_usuarios = '".$cod."';";
/* echo $sql;*/ 
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/ 
if ($actualizar = $mysqli->query($sql)) {
 /*Validamos si el registro fue ingresado con éxito*/
echo 'Modificación exitosa';
echo '<meta http-equiv="refresh" content="1; url=usuarios.php" />';
 }else{ 
echo 'Modificacion fallida';
}
echo '<meta http-equiv="refresh" content="2; url=usuarios.php" />';
} /*fin Actualizar*/ 
 }else{ 
 ?>
<center>
<b><label>Buscar: </label></b><input type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados:</label></b>
<input type="number" min="0" id="numeroresultados_usuarios" placeholder="Cantidad de resultados" title="Cantidad de resultados" value="10" onkeyup="grabarcookie('numeroresultados_usuarios',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_usuarios',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_usuarios',this.value);buscar(document.getElementById('buscar').value);" size="4" style="width: 40px;">
</center>
<span id="txtsugerencias">
<?php 
buscar_usuarios();
 ?>
</span>
<?php 
}/*fin else if isset cod*/
echo '</center>';
 ?>
<?php $contenido = ob_get_contents();
ob_clean();
include ("../plantilla/home.php");
 ?>
