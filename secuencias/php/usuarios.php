<?php 
ob_start();
$titulo_modulo = "Usuarios";
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
require("../config/conexion.php");
require_once("../config/funciones.php");
?>
<center>
<?php 
function buscar_usuarios($datos="",$reporte=""){
if ($reporte=="xls"){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; Filename=usuarios.xls");
}
require("../config/conexion.php");
require_once ("../lib/Zebra_Pagination/Zebra_Pagination.php");
$resultados = ((isset($_COOKIE['numeroresultados_usuarios']) and $_COOKIE['numeroresultados_usuarios']!="" ) ? $_COOKIE['numeroresultados_usuarios'] : 10);
$paginacion = new Zebra_Pagination();
$paginacion->records_per_page($resultados);
$paginacion->records_per_page($resultados);

$cookiepage="page_usuarios";
$funcionjs="buscar();";$paginacion->fn_js_page("$funcionjs");
$paginacion->cookie_page($cookiepage);
$paginacion->padding(false);
if (isset($_COOKIE["$cookiepage"])) $_GET['page'] = $_COOKIE["$cookiepage"];
$sql = "SELECT `usuarios`.`id_usuarios`, `usuarios`.`nuip`, `usuarios`.`nombre`, `usuarios`.`apellido1`, `usuarios`.`apellido2`, `usuarios`.`email`, `usuarios`.`clave`, `usuarios`.`f_nacimiento`, `usuarios`.`tipo`, `usuarios`.`avatar`, `avatar`.`img_avatar` as avatarimg_avatar, `usuarios`.`puntos`, `usuarios`.`estado`, `usuarios`.`ultimo_inicio` FROM `usuarios`  left join `avatar` on `usuarios`.`avatar` = `avatar`.`id_avatar`  ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' WHERE ';
if (isset($_COOKIE['busqueda_av_usuariostipo']) and $_COOKIE['busqueda_av_usuariostipo']!=""){
$sql .= ' LOWER(`usuarios`.`tipo`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_usuariostipo'], 'UTF-8').'%" and ';
}
if (isset($_COOKIE['busqueda_avanzada_usuarios']) and $_COOKIE['busqueda_avanzada_usuarios']=="true"){
if (isset($_COOKIE['busqueda_av_usuariosnuip']) and $_COOKIE['busqueda_av_usuariosnuip']!=""){
$sql .= ' LOWER(`usuarios`.`nuip`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_usuariosnuip'], 'UTF-8').'%" and ';
}
if (isset($_COOKIE['busqueda_av_usuariosnombre']) and $_COOKIE['busqueda_av_usuariosnombre']!=""){
$sql .= ' LOWER(`usuarios`.`nombre`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_usuariosnombre'], 'UTF-8').'%" and ';
}
if (isset($_COOKIE['busqueda_av_usuariosapellido1']) and $_COOKIE['busqueda_av_usuariosapellido1']!=""){
$sql .= ' LOWER(`usuarios`.`apellido1`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_usuariosapellido1'], 'UTF-8').'%" and ';
}
if (isset($_COOKIE['busqueda_av_usuariosapellido2']) and $_COOKIE['busqueda_av_usuariosapellido2']!=""){
$sql .= ' LOWER(`usuarios`.`apellido2`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_usuariosapellido2'], 'UTF-8').'%" and ';
}
if (isset($_COOKIE['busqueda_av_usuariosemail']) and $_COOKIE['busqueda_av_usuariosemail']!=""){
$sql .= ' LOWER(`usuarios`.`email`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_usuariosemail'], 'UTF-8').'%" and ';
}
if (isset($_COOKIE['busqueda_av_usuariosf_nacimiento_desde'],$_COOKIE['busqueda_av_usuariosf_nacimiento_hasta'])){
if ($_COOKIE['busqueda_av_usuariosf_nacimiento_desde']!="" and $_COOKIE['busqueda_av_usuariosf_nacimiento_hasta']!=""){
$busqueda_av_usuariosf_nacimiento_desde = $_COOKIE['busqueda_av_usuariosf_nacimiento_desde'];
$busqueda_av_usuariosf_nacimiento_hasta = $_COOKIE['busqueda_av_usuariosf_nacimiento_hasta'];
$sql .= " usuarios.f_nacimiento BETWEEN '$busqueda_av_usuariosf_nacimiento_desde' AND '$busqueda_av_usuariosf_nacimiento_hasta' and ";
}
}
if (isset($_COOKIE['busqueda_av_usuariosavatar']) and $_COOKIE['busqueda_av_usuariosavatar']!=""){
$sql .= ' LOWER(`usuarios`.`avatar`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_usuariosavatar'], 'UTF-8').'%" and ';
}
if (isset($_COOKIE['busqueda_av_usuariospuntos_desde'],$_COOKIE['busqueda_av_usuariospuntos_hasta'])){
if ($_COOKIE['busqueda_av_usuariospuntos_desde']!="" and $_COOKIE['busqueda_av_usuariospuntos_hasta']!=""){
$busqueda_av_usuariospuntos_desde = $_COOKIE['busqueda_av_usuariospuntos_desde'];
$busqueda_av_usuariospuntos_hasta = $_COOKIE['busqueda_av_usuariospuntos_hasta'];
$sql .= " usuarios.puntos BETWEEN '$busqueda_av_usuariospuntos_desde' AND '$busqueda_av_usuariospuntos_hasta' and ";
}
}
if (isset($_COOKIE['busqueda_av_usuariosestado']) and $_COOKIE['busqueda_av_usuariosestado']!=""){
$sql .= ' LOWER(`usuarios`.`estado`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_usuariosestado'], 'UTF-8').'%" and ';
}
if (isset($_COOKIE['busqueda_av_usuariosultimo_inicio_desde'],$_COOKIE['busqueda_av_usuariosultimo_inicio_hasta'])){
if ($_COOKIE['busqueda_av_usuariosultimo_inicio_desde']!="" and $_COOKIE['busqueda_av_usuariosultimo_inicio_hasta']!=""){
$busqueda_av_usuariosultimo_inicio_desde = $_COOKIE['busqueda_av_usuariosultimo_inicio_desde'];
$busqueda_av_usuariosultimo_inicio_hasta = $_COOKIE['busqueda_av_usuariosultimo_inicio_hasta'];
$sql .= " usuarios.ultimo_inicio BETWEEN '$busqueda_av_usuariosultimo_inicio_desde' AND '$busqueda_av_usuariosultimo_inicio_hasta' and ";
}
}
}
foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`usuarios`.`nuip`)," ",LOWER(`usuarios`.`nombre`)," ",LOWER(`usuarios`.`apellido1`)," ",LOWER(`usuarios`.`apellido2`)," ",LOWER(`usuarios`.`email`)) LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
$sql .=  " ORDER BY ";
if (isset($_COOKIE['orderbyusuarios']) and $_COOKIE['orderbyusuarios']!=""){ $sql .= "`usuarios`.`".$_COOKIE['orderbyusuarios']."`";
}else{ $sql .= "`usuarios`.`id_usuarios`";}
if (isset($_COOKIE['orderad_usuarios'])){
$orderadusuarios = $_COOKIE['orderad_usuarios'];
$sql .=  " $orderadusuarios ";
}else{
$sql .=  " desc ";
}
$consulta_total_usuarios = $mysqli->query($sql);
$total_usuarios = $consulta_total_usuarios->num_rows;
$paginacion->records($total_usuarios);
if ($reporte=="") $sql .=  " LIMIT " . (($paginacion->get_page() - 1) * $resultados) . ", " . $resultados;
/*echo $sql;*/ 

$consulta = $mysqli->query($sql);
$numero_usuarios = $consulta->num_rows;
$minimo_usuarios = (($paginacion->get_page() - 1) * $resultados)+1;
$maximo_usuarios = (($paginacion->get_page() - 1) * $resultados) + $resultados;
if ($maximo_usuarios>$numero_usuarios) $maximo_usuarios=$numero_usuarios;
$maximo_usuarios += $minimo_usuarios-1;
if ($reporte=="") echo "<p>Resultados de $minimo_usuarios a $maximo_usuarios del total de ".$total_usuarios." en página ".$paginacion->get_page()."</p>";
 ?>
<div align="center">
<table border="1" id="tbusuarios">
<thead>
<tr>
<th <?php  if(isset($_COOKIE['orderbyusuarios']) and $_COOKIE['orderbyusuarios']== "nuip"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyusuarios','nuip');buscar();" >Identificación</th>
<th <?php  if(isset($_COOKIE['orderbyusuarios']) and $_COOKIE['orderbyusuarios']== "nombre"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyusuarios','nombre');buscar();" >Nombre</th>
<th <?php  if(isset($_COOKIE['orderbyusuarios']) and $_COOKIE['orderbyusuarios']== "apellido1"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyusuarios','apellido1');buscar();" >Primer Apellido</th>
<th <?php  if(isset($_COOKIE['orderbyusuarios']) and $_COOKIE['orderbyusuarios']== "apellido2"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyusuarios','apellido2');buscar();" >Segundo Apellido</th>
<th <?php  if(isset($_COOKIE['orderbyusuarios']) and $_COOKIE['orderbyusuarios']== "email"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyusuarios','email');buscar();" >Email</th>
<th <?php  if(isset($_COOKIE['orderbyusuarios']) and $_COOKIE['orderbyusuarios']== "f_nacimiento"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyusuarios','f_nacimiento');buscar();" >Fecha de Nacimiento</th>
<th <?php  if(isset($_COOKIE['orderbyusuarios']) and $_COOKIE['orderbyusuarios']== "tipo"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyusuarios','tipo');buscar();" >Tipo de usuario</th>
<?php if ($reporte=="") { ?>
<th <?php  if(isset($_COOKIE['orderbyusuarios']) and $_COOKIE['orderbyusuarios']== "avatar"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyusuarios','avatar');buscar();" >Avatar</th>
<?php } ?>
<!--th <?php  #if(isset($_COOKIE['orderbyusuarios']) and $_COOKIE['orderbyusuarios']== "puntos"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyusuarios','puntos');buscar();" >Puntos</th-->
<th <?php  if(isset($_COOKIE['orderbyusuarios']) and $_COOKIE['orderbyusuarios']== "estado"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyusuarios','estado');buscar();" >Estado</th>
<th <?php  if(isset($_COOKIE['orderbyusuarios']) and $_COOKIE['orderbyusuarios']== "ultimo_inicio"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyusuarios','ultimo_inicio');buscar();" >Ultimo Inicio</th>
<?php if ($reporte==""){ ?>
<th data-label="Nuevo" class="thbotones"><form id="formNuevo" name="formNuevo" method="post" action="usuarios.php">
<input name="cod" type="hidden" id="cod" value="0">
<input type="image" name="submit" id="submit" value="Nuevo" title="Nuevo" src="<?php echo $url_raiz ?>img/nuevo.png">
</form>
</th>
<th data-label="XLS" class="thbotones"><form id="formNuevo" name="formNuevo" method="post" action="usuarios.php?xls">
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
<td data-label='Identificación'><?php echo $row['nuip']?></td>
<td data-label='Nombre'><?php echo $row['nombre']?></td>
<td data-label='Primer Apellido'><?php echo $row['apellido1']?></td>
<td data-label='Segundo Apellido'><?php echo $row['apellido2']?></td>
<td data-label='Email'><?php echo $row['email']?></td>
<td><?php echo formato_fecha($row['f_nacimiento']); ?></td>
<?php $datostipo = array("estudiante" => "Estudiante", "docente" => "Docente", "admin" => "Administrador"); ?>
<td data-label='Tipo de usuario'><?php echo $datostipo[$row['tipo']] ?></td>
<?php if ($reporte==""){ ?>
<td data-label="Avatar">
<?php if (file_exists("../img/Avatars/".$row['avatarimg_avatar']) and $row['avatarimg_avatar'] != ""){ ?>
<div  style="background: url('../img/Avatars/<?php echo $row['avatarimg_avatar'] ?>');
    background-size: 350px 95px;
    height: 94px;
    width: 48px;
    background-position: 0px 0px;
    background-repeat: no-repeat;
" ></div>
<?php } ?>
</td>
<?php } ?>
<!--td data-label='Puntos'><?php #echo $row['puntos']?></td-->
<?php $datosestado = array("Activo" => "Activo", "Inactivo" => "Inactivo"); ?>
<td data-label='Estado'><?php echo $datosestado[$row['estado']] ?></td>
<td data-label="Ultimo Inicio"><?php echo formato_fecha($row['ultimo_inicio'])." ".formato_hora($row['ultimo_inicio']); ?></td>
<?php if ($reporte==""){ ?>
<td data-label="Modificar">
<form id="formModificar" name="formModificar" method="post" action="usuarios.php">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_usuarios']; ?>">
<input type="image" src="<?php echo $url_raiz ?>img/modificar.png"name="submit" id="submit" value="Modificar" title="Modificar">
</form>
</td>
<td data-label="Eliminar">
<input title="Eliminar" type="image" src="<?php echo $url_raiz ?>img/eliminar.png" onClick="confirmeliminar('usuarios.php',{'del':'<?php echo $row['id_usuarios'];?>','nombre':'<?php echo $row['nuip']." ".$row['nombre']." ".$row['apellido1']." ".$row['apellido2'];?>'},'<?php echo $row['nuip']." ".$row['nombre']." ".$row['apellido1']." ".$row['apellido2'];?>');" value="Eliminar">
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
buscar_usuarios($_POST['datos']);
exit();
}
if (isset($_GET['xls'])){
ob_start();
buscar_usuarios('','xls');
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
$sql = 'DELETE FROM usuarios WHERE concat(`usuarios`.`id_usuarios`)="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
$eliminar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
 /*Validamos si el registro fue eliminado con éxito*/ 
 ?>
<script>
 alert('El Usuario <?php echo $_POST['nombre']; ?> fué eliminado');
 document.location.href="usuarios.php";
</script>
<?php 
}else{
?>
<script>
 alert('No se pudo eliminar, por favor compruebe que el usuario <?php echo $_POST['nombre']; ?> no esté en uso');
 document.location.href="usuarios.php";
</script>
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
$sql = "INSERT INTO usuarios (`id_usuarios`, `nuip`, `nombre`, `apellido1`, `apellido2`, `email`, `clave`, `f_nacimiento`, `tipo`, `avatar`,`estado`) VALUES ('".$_POST['id_usuarios']."', '".$_POST['nuip']."', '".$_POST['nombre']."', '".$_POST['apellido1']."', '".$_POST['apellido2']."', '".$_POST['email']."', '".encriptar_clave($_POST['clave'])."', '".$_POST['f_nacimiento']."', '".$_POST['tipo']."', '".$_POST['icon']."', '".$_POST['estado']."')";
 #echo $sql;
$insertar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
 /*Validamos si el registro fue ingresado con éxito*/ 
 ?>
<script>alert('Se agregó el Usuario <?php echo $_POST['nombre']." ".$_POST['apellido1']." ".$_POST['apellido2']; ?> satisfactoriamente.')</script>
<?php 
echo '<meta http-equiv="refresh" content="0; url=usuarios.php" />';
 }else{ 
 ?>
<script>alert('No se agregó el Usuario <?php echo $_POST['nombre']." ".$_POST['apellido1']." ".$_POST['apellido2']; ?>.')</script>

<?php 
echo '<meta http-equiv="refresh" content="0; url=usuarios.php" ';
#print_r($_POST);
///>
}
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo" or $_POST['submit']=="Modificar"){
if ($_POST['submit']=="Modificar"){
$sql = 'SELECT * FROM `usuarios` left join `avatar` on `avatar`.`id_avatar` = `usuarios`.`avatar` WHERE concat(`usuarios`.`id_usuarios`) ="'.$_POST['cod'].'" Limit 1'; 
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
<div class="col-md-3"></div><form class="col-md-6" id="form1" name="form1" method="post" action="usuarios.php">
<h1><?php echo $textoh1 ?></h1>
<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_usuarios'])) echo $row['id_usuarios']; ?>" size="120" required></p>
<div class="form-group"><p>
<input title="" class="form-control" name="id_usuarios" type="hidden" id="id_usuarios" value="<?php 
if (isset($row['id_usuarios'])) echo $row['id_usuarios'];
?>" ></p>
</div>
<div class="form-group"><p>
 <label for="nuip">Identificación:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label><input title="Ejemplo: 10852345678" onchange="valida_existe_nuip(this.value)" onkeyup="valida_existe_nuip(this.value)" onKeyPress="return soloNumeros(event)" pattern="\d{8,12}"  class="form-control" name="nuip" autocomplete="off" type="text" id="nuip" step="1" value="<?php if (isset($row['nuip'])) echo $row['nuip']; ?>" required ><span id="txtnuip"></span></p>
<?php
echo "</div>";echo '<div class="form-group"><p><label for="nombre">Nombre:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label><input title="Ejemplo: Juan" class="form-control" name="nombre" autocomplete="off" type="text" id="nombre" value="';if (isset($row['nombre'])) echo $row['nombre'];echo '"';echo ' required ></p>';
echo "</div>";echo '<div class="form-group"><p><label for="apellido1">Primer Apellido:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label><input title="Ejemplo: Gonzales" class="form-control" name="apellido1" autocomplete="off" type="text" id="apellido1" value="';if (isset($row['apellido1'])) echo $row['apellido1'];echo '"';echo ' required ></p>';
echo "</div>";echo '<div class="form-group"><p><label for="apellido2">Segundo Apellido:</label><input title="Ejemplo: Mora" class="form-control" name="apellido2" autocomplete="off" type="text" id="apellido2" value="';if (isset($row['apellido2'])) echo $row['apellido2'];echo '"';echo '></p>';
echo "</div>";echo '<div class="form-group"><p><label for="email">Email:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label><input title="Ejemplo: juan@email.com" class="form-control" name="email" autocomplete="off" pattern="^[a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$" onchange="valida_existe_email(this.value)" onkeyup="valida_existe_email(this.value)" type="email" id="email" value="';if (isset($row['email'])) echo $row['email'];echo '"';echo ' required ><span id="txtemail"></span></p>';
echo "</div>";echo '<div class="form-group"><p><label for="clave">Clave:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label><input title="Para mayor seguridad cree una clave que contenga Mayúsculas, Minúsculas, Números y Símbolos Ej: MDas34$%" class="form-control" name="clave" autocomplete="off" type="password" id="clave" value="" ';
if ($_POST['submit']=="Nuevo") echo 'required';
echo ' ><label><input type="checkbox" onclick="document.getElementById(\'clave\').type = document.getElementById(\'clave\').type == \'text\' ? \'password\' : \'text\'"/> Ver</label></p>';
echo "</div>";echo '<div class="form-group"><p><label for="f_nacimiento">Fecha de Nacimiento:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label><input title="Ejemplo: 01/06/2001, Formato Día/Mes/Año" class="form-control" name="f_nacimiento" autocomplete="off" type="date" id="f_nacimiento" value="';if (isset($row['f_nacimiento'])) echo $row['f_nacimiento'];echo '"';echo ' required ></p>';
echo "</div>";echo '<div class="form-group"><p>'; ?>
<p><label for="tipo">Tipo de usuario:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label></p><label><input type="radio" title="" class="" name="tipo" id="tipo[1]"  required value="estudiante" <?php if (isset($row['tipo']) and $row['tipo'] =="estudiante") echo " checked "; ?> >Estudiante</label><br><label><input type="radio" title="" class="" name="tipo" id="tipo[2]"  required value="docente" <?php if (isset($row['tipo']) and $row['tipo'] =="docente") echo " checked "; ?> >Docente</label><br><label><input type="radio" title="" class="" name="tipo" autocomplete="off" id="tipo[3]"  required value="admin" <?php if (isset($row['tipo']) and $row['tipo'] =="admin") echo " checked "; ?> >Administrador</label><br></p>
<?php 
echo "</div>";
?>
<div class="form-group"><p>

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
	foreach(glob("../img/Avatars/*.*") as $nombre){
	while($row_av=$consulta_av->fetch_assoc()){
	 $pre_id_avatar = $row_av['id_avatar'];
	 $pre_ima_avatar = $row_av['img_avatar'];
	//$nombre2 = str_replace("Avatars/","",$nombre);
	?>
	<li><span onclick="obtener_icono(this)" data-src="../img/Avatars/<?php echo $row_av['img_avatar'] ?>" data-id="<?php echo $row_av['id_avatar'] ?>" >
	<!--img height="80" src="../img/Avatars/<?php #echo $row_av['img_avatar'] ?>"-->
	<div  style="background: url('<?php echo "../img/Avatars/".$row_av['img_avatar']?>');
    background-size: 350px 95px;
    height: 94px;
    width: 48px;
    background-position: 0px 0px;
    background-repeat: no-repeat;
    display:inline-block;
    margin-bottom:-8px;
" ></div>
	<?php echo $row_av['nombre_avatar']?>
	</span></li>
	<?php } ?>
	<?php } ?>
    </ul> </div>
       <div class="modal-footer">
        <a class="close btn" id="cerrar_modal_avatar" data-dismiss="modal">Cerrar</a>
    </div>
      </div>
      
    </div>
  </div>
  
</div>
 <label for="avatar">Avatar:</label>
<img data-toggle="modal" data-target="#myModal" height="80" id="icon-img" src="<?php 
if ($textobtn=="Actualizar" and isset($row['img_avatar']))
echo "../img/Avatars/".$row['img_avatar']; 
else if ($textobtn=="Registrar")
echo "../img/Avatars/".$pre_ima_avatar; 
?>">
<span id="icono"></span>
<input type="hidden" id="icon" name="icon" autocomplete="off" value="<?php
if ($textobtn=="Actualizar" and isset($row['id_avatar'])) 
echo $row['id_avatar']; 
else if ($textobtn=="Registrar")
echo $pre_id_avatar; 
?>"/>
<button type="button" class="btn btn-info btn-s" data-toggle="modal" data-target="#myModal">Elegir</button>
</div>
<?php
#fin modal
echo '<div class="form-group"><p>'; ?>
<p><label for="estado">Estado:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label></p><label><input type="radio" title="" class="" name="estado" id="estado[1]"  required value="Activo" <?php if (isset($row['estado']) and $row['estado'] =="Activo") echo " checked "; ?> >Activo</label><br><label><input type="radio" title="" class="" name="estado" autocomplete="off" id="estado[2]"  required value="Inactivo" <?php if (isset($row['estado']) and $row['estado'] =="Inactivo") echo " checked "; ?> >Inactivo</label><br></p>
<?php 
echo "</div>";
echo '<p><input type="hidden" name="submit" value="'.$textobtn.'"><button type="submit" id="submit" class="btn btn-primary">'.$textobtn.'</button></p>
</form><div class="col-md-3"></div>';
} /*fin mixto*/ 
if ($_POST['submit']=="Actualizar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$cod = $_POST['cod'];
$sql_up_clave = "";
if ($_POST['clave']!="") $sql_up_clave = ", clave='".encriptar_clave($_POST['clave'])."'";
$icon_avatar = "";
if ($_POST['icon']!="")  $icon_avatar = ", avatar='".$_POST['icon']."'";
 /*Instrucción SQL que permite insertar en la BD */ 
$sql = "UPDATE usuarios SET id_usuarios='".$_POST['id_usuarios']."', nuip='".$_POST['nuip']."', nombre='".$_POST['nombre']."', apellido1='".$_POST['apellido1']."', apellido2='".$_POST['apellido2']."', email='".$_POST['email']."'".$sql_up_clave.", f_nacimiento='".$_POST['f_nacimiento']."', tipo='".$_POST['tipo']."'".$icon_avatar.", puntos='".$_POST['puntos']."', estado='".$_POST['estado']."', ultimo_inicio='".$_POST['ultimo_inicio']."' WHERE  `usuarios`.`id_usuarios` = '".$cod."';";
#echo $sql;
  /*Se conecta a la BD y luego ejecuta la instrucción SQL*/ 
 $actualizar = $mysqli->query($sql);
 if ($mysqli->affected_rows>0){
  /*Validamos si el registro fue ingresado con éxito*/ 
 ?>
 <script>alert('Se modificó el Usuario <?php echo $_POST['nombre']." ".$_POST['apellido1']." ".$_POST['apellido2']; ?> satisfactoriamente.')</script>
 <meta http-equiv="refresh" content="1; url=usuarios.php" />
 <?php 
  }else{ 
 ?>
 <script>alert('No modificó el Usuario <?php echo $_POST['nombre']." ".$_POST['apellido1']." ".$_POST['apellido2']; ?>.')</script><!--meta http-equiv="refresh" content="2; url=usuarios.php" /-->
 <?php 
 }
} /*fin Actualizar*/ 
 }else{ 
 ?>
<center>
<b><label>Buscar: </label></b><input title="Buscar por: Identificación, Nombre, Primer apellido, Segundo apellido, Email" type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados por página:</label></b>
<input type="number" min="0" id="numeroresultados_usuarios" placeholder="Cantidad de resultados" title="Cantidad de resultados" value="10" onkeyup="grabarcookie('numeroresultados_usuarios',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_usuarios',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_usuarios',this.value);buscar(document.getElementById('buscar').value);" onKeyPress="return soloNumeros(event)" size="4" style="width: 40px;">
<button title="Orden Ascendente" onclick="grabarcookie('orderad_usuarios','ASC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-up"></span></button><button title="Orden Descendente" onclick="grabarcookie('orderad_usuarios','DESC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-down"></span></button>
<div class="form-group"><p><label for="tipo">Tipo de usuario<select title="" class="form-control input_busqueda_avanzada" onchange="grabarcookie('busqueda_av_usuariostipo',this.value);buscar();" onblur="this.onchange();">
<option value="">Todos los Usuario</option>
<option value="estudiante" <?php if (isset($_COOKIE['busqueda_av_usuariostipo']) and $_COOKIE['busqueda_av_usuariostipo']=="Estudiante") echo "selected";; ?> >Estudiante</option>
<option value="docente" <?php if (isset($_COOKIE['busqueda_av_usuariostipo']) and $_COOKIE['busqueda_av_usuariostipo']=="Docente") echo "selected";; ?> >Docente</option>
<option value="admin" <?php if (isset($_COOKIE['busqueda_av_usuariostipo']) and $_COOKIE['busqueda_av_usuariostipo']=="Administrador") echo "selected";; ?> >Administrador</option>
</select></label></p></div>
<p><label><input type="checkbox" onchange="grabarcookie('busqueda_avanzada_usuarios',this.checked);mostrar_busqueda_avanzada(this.checked);buscar();" <?php if (isset($_COOKIE['busqueda_avanzada_usuarios']) and $_COOKIE['busqueda_avanzada_usuarios']=='true') echo 'checked' ?>>Búsqueda Avanzada</label></p>
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
<div class="busqueda_avanzada" <?php if (!isset($_COOKIE['busqueda_avanzada_usuarios']) or (isset($_COOKIE['busqueda_avanzada_usuarios']) and $_COOKIE['busqueda_avanzada_usuarios']!='true')) echo 'style="display:none"' ?>>
<div class="form-group"><p><label for="nuip">Identificación<input title="" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_usuariosnuip',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_usuariosnuip'])) echo $_COOKIE['busqueda_av_usuariosnuip']; ?>
"></label></p></div>
<div class="form-group"><p><label for="nombre">Nombre<input title="" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_usuariosnombre',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_usuariosnombre'])) echo $_COOKIE['busqueda_av_usuariosnombre']; ?>
"></label></p></div>
<div class="form-group"><p><label for="apellido1">Primer Apellido<input title="" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_usuariosapellido1',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_usuariosapellido1'])) echo $_COOKIE['busqueda_av_usuariosapellido1']; ?>
"></label></p></div>
<div class="form-group"><p><label for="apellido2">Segundo Apellido<input title="" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_usuariosapellido2',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_usuariosapellido2'])) echo $_COOKIE['busqueda_av_usuariosapellido2']; ?>
"></label></p></div>
<div class="form-group"><p><label for="email">Email<input title="" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_usuariosemail',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_usuariosemail'])) echo $_COOKIE['busqueda_av_usuariosemail']; ?>
"></label></p></div>
<p><label for="f_nacimiento">Fecha de Nacimiento</label></p><center><div class="form-group"><label>Desde:<input onchange="grabarcookie('busqueda_av_usuariosf_nacimiento_desde',this.value);buscar();" class="form-control input_busqueda_avanzada" type="date" onblur="this.onchange();" value="<?php if (isset($_COOKIE['busqueda_av_usuariosf_nacimiento_desde'])) echo $_COOKIE['busqueda_av_usuariosf_nacimiento_desde']; ?>"></label></div><div class="form-group"><label>Hasta:<input onchange="grabarcookie('busqueda_av_usuariosf_nacimiento_hasta',this.value);buscar();" class="form-control input_busqueda_avanzada" type="date" onblur="this.onchange();" value="<?php if (isset($_COOKIE['busqueda_av_usuariosf_nacimiento_hasta'])) echo $_COOKIE['busqueda_av_usuariosf_nacimiento_hasta']; ?>"></label></div></center>
<!--div class="form-group"></div>
<p><label for="puntos">Puntos</label></p><center><div class="form-group"><label>Desde:<input onchange="grabarcookie('busqueda_av_usuariospuntos_desde',this.value);buscar();" class="form-control input_busqueda_avanzada" type="number" onblur="this.onchange();" value="<?php #if (isset($_COOKIE['busqueda_av_usuariospuntos_desde'])) echo $_COOKIE['busqueda_av_usuariospuntos_desde']; ?>"></label></div><div class="form-group"><label>Hasta:<input onchange="grabarcookie('busqueda_av_usuariospuntos_hasta',this.value);buscar();" class="form-control input_busqueda_avanzada" type="number" onblur="this.onchange();" value="<?php #if (isset($_COOKIE['busqueda_av_usuariospuntos_hasta'])) echo $_COOKIE['busqueda_av_usuariospuntos_hasta']; ?>"></label></div></center>
<div class="form-group"></div-->
<div class="form-group"><p><label for="estado">Estado<select title="" class="form-control input_busqueda_avanzada" onchange="grabarcookie('busqueda_av_usuariosestado',this.value);buscar();" onblur="this.onchange();">
<option value="">Seleccione un Estado</option>
<option value="Activo" <?php if (isset($_COOKIE['busqueda_av_usuariosestado']) and $_COOKIE['busqueda_av_usuariosestado'] =="Activo") echo "selected "; ?>>Activo</option> 
<option value="Inactivo" <?php if (isset($_COOKIE['busqueda_av_usuariosestado']) and $_COOKIE['busqueda_av_usuariosestado'] =="Inactivo") echo "selected "; ?>>Inactivo</option>
</select></label></p></div>
<p><label for="ultimo_inicio">Último Inicio</label></p><center><div class="form-group"><label>Desde:<input onchange="grabarcookie('busqueda_av_usuariosultimo_inicio_desde',this.value);buscar();" class="form-control input_busqueda_avanzada" type="date" onblur="this.onchange();" value="<?php if (isset($_COOKIE['busqueda_av_usuariosultimo_inicio_desde'])) echo $_COOKIE['busqueda_av_usuariosultimo_inicio_desde']; ?>"></label></div><div class="form-group"><label>Hasta:<input onchange="grabarcookie('busqueda_av_usuariosultimo_inicio_hasta',this.value);buscar();" class="form-control input_busqueda_avanzada" type="date" onblur="this.onchange();" value="<?php if (isset($_COOKIE['busqueda_av_usuariosultimo_inicio_hasta'])) echo $_COOKIE['busqueda_av_usuariosultimo_inicio_hasta']; ?>"></label></div></center>
<div class="form-group"></div>

<input type="button" onclick="buscar();" class="btn btn-primary" value="Buscar">
</div>
<span id="txtsugerencias">
<?php 
buscar_usuarios();
 ?>
</span>
<?php 
}/*fin else if isset cod*/
echo '</center>';
 ?>
<script>
var vmenu_usuarios = document.getElementById('menu_usuarios')
if (vmenu_usuarios){
vmenu_usuarios.className ='active '+vmenu_usuarios.className;
}
</script>
	<style>
div.show-top-margin{margin-top:2em;}.show-grid{margin-bottom:2em;}.show-grid [class^="col-"]{padding-top:10px;padding-bottom:10px;border:1px solid #AAA;background-color:#EEE;background-color:rgba(200,200,200,0.3);}.responsive-utilities-test .col-xs-6{margin-bottom:10px;}.responsive-utilities-test span{padding:15px 10px;font-size:14px;font-weight:bold;line-height:1.1;text-align:center;border-radius:4px;}.visible-on .col-xs-6 .hidden-xs,.visible-on .col-xs-6 .hidden-sm,.visible-on .col-xs-6 .hidden-md,.visible-on .col-xs-6 .hidden-lg,.hidden-on .col-xs-6 .visible-xs,.hidden-on .col-xs-6 .visible-sm,.hidden-on .col-xs-6 .visible-md,.hidden-on .col-xs-6 .visible-lg{color:#999;border:1px solid #ddd;}.visible-on .col-xs-6 .visible-xs,.visible-on .col-xs-6 .visible-sm,.visible-on .col-xs-6 .visible-md,.visible-on .col-xs-6 .visible-lg,.hidden-on .col-xs-6 .hidden-xs,.hidden-on .col-xs-6 .hidden-sm,.hidden-on .col-xs-6 .hidden-md,.hidden-on .col-xs-6 .hidden-lg{color:#468847;background-color:#dff0d8;border:1px solid #d6e9c6;}div.controls input,div.controls select{margin-bottom:.5em;}#inputSeleccionado{border-color:rgba(82,168,236,.8);outline:0;outline:thin dotted \9;-moz-box-shadow:0 0 8px rgba(82,168,236,.6);box-shadow:0 0 8px rgba(82,168,236,.6);}.bs-glyphicons{padding-left:0;padding-bottom:1px;margin-bottom:20px;list-style:none;overflow:hidden;}.bs-glyphicons li{float:left;width:25%;height:115px;padding:10px;margin:0 -1px -1px 0;font-size:12px;line-height:1.4;text-align:center;border:1px solid #ddd;}.bs-glyphicons .glyphicon{display:block;margin:5px auto 10px;font-size:24px;}.bs-glyphicons li:hover{background-color:rgba(86,61,124,.1);}@media (min-width: 768px) {.bs-glyphicons li{width:12.5%;}}.btn-toolbar+.btn-toolbar{margin-top:10px;}.dropdown>.dropdown-menu{position:static;display:block;margin-bottom:5px;}form .row{margin-bottom:1em;}.nav .dropdown-menu{display:none;}.nav .open .dropdown-menu{display:block;position:absolute;}
</style>
<?php $contenido = ob_get_contents();
ob_clean();
include ("../plantilla/home.php");
 ?>