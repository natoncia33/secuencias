<?php
require_once(dirname(__FILE__)."/../config/funciones.php");
ob_start();
@session_start();
if (isset($_GET['logout'])){
    unset ($_SESSION['id_usuarios']);
    unset ($_SESSION['email']);
    unset($_SESSION['img_avatar']);
    unset($_SESSION['nombre']);
    unset($_SESSION['apellido']);
    unset($_SESSION['tipo']);
    unset($_SESSION['id_asignacion']);
    unset($_SESSION['nombre_asignacion']);
    #session_destroy();
    header("Location: index.php");
}
if (isset($_POST['usuario'])){
    require_once(dirname(__FILE__)."/../config/conexion.php");
    $usuario = $mysqli->real_escape_string($_POST['usuario']);
    $clave = $mysqli->real_escape_string($_POST['clave']);
    $clave = encriptar_clave($clave);
   $sql = "SELECT `usuarios`.`id_usuarios`, `avatar`.`img_avatar`, `usuarios`.`nombre`, `usuarios`.`apellido1`, `usuarios`.`apellido2`, `usuarios`.`nuip`, `usuarios`.`email`, `usuarios`.`f_nacimiento`, `usuarios`.`tipo` FROM `usuarios` inner join `avatar` on `usuarios`.`avatar` = `avatar`.`id_avatar`  WHERE `usuarios`.`clave` = '$clave' and (`usuarios`.`nuip` = '$usuario' or `usuarios`.`email` = '$usuario')";
   $consulta = $mysqli->query($sql);
   if ($consulta->num_rows>0){
   if ($row=$consulta->fetch_assoc()){
       $sql2 = "UPDATE `secuencias`.`usuarios` SET `ultimo_inicio` = '".date("Y-m-d H:i:s")."' WHERE `usuarios`.`id_usuarios` = '".$row['id_usuarios']."';";
       $consulta2 = $mysqli->query($sql2);
       $_SESSION['id_usuarios'] = $row['id_usuarios'];
       $_SESSION['email'] = $row['email'];
       $_SESSION['img_avatar'] = $row['img_avatar'];
       setcookie('img_avatar',$row['img_avatar']);
       $_SESSION['tipo'] = $row['tipo'];
       $_SESSION['nombre'] = $row['nombre'];
       $_SESSION['apellido'] = $row['apellido1']." ".$row['apellido2'];
    $sql2 = "SELECT * FROM anio_lectivo WHERE estado_anio_lectivo = 'Activo' ";
    $consulta2 = $mysqli->query($sql2);
    if ($consulta2->num_rows>0){
        if ($row2=$consulta2->fetch_assoc()){
            $_SESSION['id_anio_lectivo']=$row2['id_anio_lectivo'];
            $_SESSION['nombre_anio_lectivo']=$row2['nombre_anio_lectivo'];
        }
    }
        if ($_SESSION['tipo']=="admin"){
            unset($_SESSION['nombre_asignacion']);
            unset($_SESSION['id_asignacion']);
        header("Location: index.php");
        }elseif ($_SESSION['tipo']=="docente"){
        header("Location:  elegir_grupo.php");
        }else{
        header("Location: elegir_avatar.php");
        }
   }
   }else{
       ?>
       <script>alert('El usuario o clave no son correctos, por favor verifique e intente de nuevo')</script>
       <?php
   }
}
?>
<center>
    <h1>Iniciar Sesión</h1>
<form method="post">
    <label for="usuario">Usuario</label>
    <input type="text" name="usuario">
    <br>
    <label for="clave">Clave</label>
    <input type="password" name="clave">
    <br>
    <input type="submit" name="Iniciar">
</form>
</center>
<?php $contenido = ob_get_contents();
ob_clean();
include (dirname(__FILE__)."/../plantilla/home.php");
?>