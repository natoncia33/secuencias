<nav class='navbar navbar-default' role='navigation'><div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegaci&oacute;n</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <!--a class="navbar-brand" href="#">Evaluaci&oacute;n</a-->
  </div>
  <div class="collapse navbar-collapse navbar-ex1-collapse">
<ul  class='nav navbar-nav'>
<?php
@session_start();
if (isset($_SESSION['email']) and ($_SESSION['tipo']=="admin" or $_SESSION['tipo']=="docente")){
?>
<li><a href="<?php echo $url_raiz ?>php/index.php" target="_self" title="">Inicio</a></li><br>
<?php if ($_SESSION['tipo']=="admin"){ ?>
<li><a href="<?php echo $url_raiz ?>php/usuarios.php" target="_self" title="">Usuarios</a></li><br>
<?php } ?>
<?php if ($_SESSION['tipo']=="docente"){ ?>
<li><a href="<?php echo $url_raiz ?>php/elegir_grupo.php" target="_self" title="">Elegir Grupo</a></li><br>
<?php } ?>
<!--li><a href="instrucciones_juego.php" target="_self" title="">Instrucciones Juego</a></li-->
<li><a href="<?php echo $url_raiz ?>php/elementos_juego.php" target="_self" title="">Elementos Juego</a></li><br>
<li><a href="<?php echo $url_raiz ?>php/secuencia.php" target="_self" title="">Secuencia</a></li><br>
<!--li><a href="reto.php" target="_self" title="">Reto</a></li><br-->
<li><a href="<?php echo $url_raiz ?>php/insignia.php" target="_self" title="">Insignias</a></li><br>
<li><a href="<?php echo $url_raiz ?>php/avatar.php" target="_self" title="">Avatars</a></li><br>
<!--li><a href="seguimiento_reto.php" target="_self" title="">Seguimiento Reto</a></li-->
<?php } ?>
<li><a href="<?php echo $url_raiz ?>php/jugar.php" target="_self" title="">Jugar</a></li><br>
</ul>
<ul class='nav navbar-nav'>
  <?php
if (!isset($_SESSION['email'])){
?>
  <li><a href="<?php echo $url_raiz ?>php/login.php" target="_self" title="">Iniciar Sesión</a></li><br>
  <?php
}else{
  ?>
<li><a href="<?php echo $url_raiz ?>php/login.php?logout" target="_self" title="">Cerrar Sesión</a></li><br>
  <?php
}
?>
</ul>
</div></nav>