<?php require('../config/conexion.php'); 
@session_start();
if(!isset($_SESSION['id_usuarios'])){
    header("Location:login.php");
    exit();
}
    ob_start();
    if(isset($_POST['icon'])){
    $sql = "UPDATE usuarios SET  avatar='".$_POST['icon']."' WHERE  id_usuarios = '".$_SESSION['id_usuarios']."';";
if ($actualizar = $mysqli->query($sql)) {
 /*Validamos si el registro fue ingresado con éxito*/
    $sql = "SELECT `usuarios`.`id_usuarios`, `avatar`.`img_avatar`, `usuarios`.`nombre`, `usuarios`.`apellido1`, `usuarios`.`apellido2`, `usuarios`.`nuip`, `usuarios`.`email`, `usuarios`.`clave`, `usuarios`.`f_nacimiento`, `usuarios`.`tipo` FROM `usuarios` inner join `avatar` on `usuarios`.`avatar` = `avatar`.`id_avatar` where `usuarios`.`id_usuarios` = '".$_SESSION['id_usuarios']."'";
    $consulta = $mysqli->query($sql);
    if($row=$consulta->fetch_assoc()){
    $_SESSION['img_avatar'] = $row['img_avatar'];
    }
echo '<meta http-equiv="refresh" content="1; url=jugar.php" />';
 }else{ 
echo '<meta http-equiv="refresh" content="1; url=jugar.php" />';
}
$contenido=ob_get_clean();
require("home.php");
exit();
}
?>
<form id="form_avatar" method="post">
Avatar: <img height="80" id="icon-img" src="<?php if (isset($_SESSION['img_avatar'])) echo "Avatars/".$_SESSION['img_avatar'] ?>">
<span id="icono"></span>
<input type="hidden" id="icon" name="icon" value="<?php if (isset($row['img_avatar'])) echo "Avatars/".$row['img_avatar'] ?>"/>
<button type="button" id="elegir_avatar" class="btn btn-info btn-s" data-toggle="modal" data-target="#myModal">Elegir</button>
<div class="container">
  <!-- Modal -->
  <div class="modal modal-fullscreen fade" id="myModal" role="dialog">
    <div class="modal-dialog">
  <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
  <ul class="bs-glyphicons">
	<?php
	$sql = "SELECT `usuarios`.`id_usuarios`, `avatar`.`img_avatar`, `usuarios`.`nombre`, `usuarios`.`apellido1`, `usuarios`.`apellido2`, `usuarios`.`nuip`, `usuarios`.`email`, `usuarios`.`clave`, `usuarios`.`f_nacimiento`, `usuarios`.`tipo` FROM `usuarios` inner join `avatar` on `usuarios`.`avatar` = `avatar`.`id_avatar` where `usuarios`.`id_usuarios` = '".$_SESSION['id_usuarios']."'";
$consulta = $mysqli->query($sql);
if($row=$consulta->fetch_assoc()){
	$sql_av = "SELECT `avatar`.`id_avatar`, `avatar`.`nombre_avatar`, `avatar`.`img_avatar` FROM `avatar`";
	$consulta_av = $mysqli->query($sql_av);
	while($row_av=$consulta_av->fetch_assoc()){
	//$nombre2 = str_replace("Avatars/","",$nombre);
	?>
	<li <?php if ($row['img_avatar']==$row_av['img_avatar']) echo 'style="background-color:#d6e6d6"'?>><span onclick="obtener_icono(this);document.getElementById('form_avatar').submit();" data-src="../img/Avatars/<?php echo $row_av['img_avatar'] ?>" data-id="<?php echo $row_av['id_avatar'] ?>" ><img height="80" src="../img/Avatars/<?php echo $row_av['img_avatar'] ?>"><?php echo $row_av['nombre_avatar']?></span></li>
	<?php } 
	}
	?>
    </ul> </div>
    <div class="modal-footer">
        <a class="close btn" data-dismiss="modal">Cerrar</a>
    </div>
      </div>
      
    </div>
  </div>
  
</div>
</form>
<script>
    document.getElementById('elegir_avatar').click();
</script>
<?php 
$contenido=ob_get_clean();
require("../plantilla/home.php");
?>