<?php 
require_once(dirname(__FILE__)."/../config/conexion.php");
require_once(dirname(__FILE__)."/../config/funciones.php");
ob_start();
@session_start();
if (!isset($_SESSION['email'])){
   header("Location: jugar.php");
}
if (isset($_SESSION['tipo']) and $_SESSION['tipo']!="admin" and !isset($_SESSION['nombre_asignacion'])){
   header("Location: elegir_grupo.php");
}
if (isset($_POST['del'])){
 /*Instrucción SQL que permite eliminar en la BD*/ 
$sql = 'DELETE FROM reto WHERE id_reto="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
if ($eliminar = $mysqli->query($sql)){
 /*Validamos si el registro fue eliminado con éxito*/ 
echo 'Registro eliminado
<meta http-equiv="refresh" content="1; url=index.php" />
'; 
}else{
?>
Eliminación fallida, por favor compruebe que la usuario no esté en uso
<meta http-equiv="refresh" content="2; url=index.php" />
<?php 
}
}
echo '<center>';
if (isset($_POST) and !empty($_POST) and !isset($_POST['cod']) and !isset($_POST['del'])){
nuevo_reto();
}
?>
<style>
.areaselementos{
    float: left;
}
</style>
<div class="row">
    <div class="col-md-6">
<h1>Elementos</h1>
<p>
<button id="modal_nueva_secuencia" style="display:none" class="btn btn-primary" data-toggle="modal" data-target="#myModal_roles">Nueva Secuencia</button>
<div id="myModal_roles" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <h2>
                        <label for="roles">Secuencias:</label>
                    </h2>
                </h4>
          </div>
            <div class="modal-body">
                <form id="form1" name="form1" method="post" action="secuencia.php" target="_blank" onsubmit="return false">
                <h1>Nueva Secuencia</h1>
                <p><input class="" name="id_secuencia" type="hidden" id="id_secuencia" value=""></p>
                <p>
                <?php 
                if (isset($_SESSION['tipo']) and $_SESSION['tipo']=="admin"){
                    require_once(dirname(__FILE__)."/../config/conexion.php");
$sql="SELECT *, usuarios.nombre as nombre_docente FROM `asignacion` inner join usuarios on asignacion.docente = usuarios.id_usuarios inner join grupo on asignacion.grupo = grupo.id_grupo ";
if ($_SESSION['tipo']!="admin"){
$sql .= " wHERE asignacion.docente = '".$_SESSION['id_usuarios']."'";
}
$sql .= " GROUP BY asignacion.docente";
$consulta = $mysqli->query($sql);
 ?><label>Docente y Grupo: <select id="asignacion_docente"><option value="">Seleccione un docente</option><?php
    while ($row = $consulta->fetch_assoc()){
        ?>
        <option value="<?php echo $row['id_asignacion'];?>"><?php echo $row['docente'].": ".$row['apellido1']." ".$row['apellido2']." ".$row['nombre_docente']." - ".$row['nombre'];?></option>
        <?php
    }
?></select></label><?php
                }
                ?>
                </p>
                <p>
                    <label for="nombre_secuencia">Nombre Secuencia:</label>
                    <input class="" name="nombre_secuencia" type="text" id="nombre_secuencia" value="" required >
                </p>
                <!--p>
                    <label><input type="checkbox" id="elegir_al_crear" value="SI">&nbsp;Elegir despues de crear</label>
                </p-->
                <p>
                <input type="button" name="submit" id="submit" value="Registrar" onclick="guardar_secuencia(document.getElementById('nombre_secuencia').value);document.getElementById('cerrar_modal_nueva_secuencia').click();">
                </p>
                </form>
            </div>
            <div class="modal-footer">
                    <button type="button" id="cerrar_modal_nueva_secuencia" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<button onclick="nuevo_reto();">Nuevo Reto</button><br><br>
<form method="post" id="formsecuencia">
    <span id="listado_secuencias">
<?php listado_secuencias(); ?>
    </span>
</form>
</p>


<?php 

$sql ="select AUTO_INCREMENT from information_schema.TABLES where TABLE_SCHEMA='$basededatos' and TABLE_NAME='reto'";
$consulta = $mysqli->query($sql);
if ($row = $consulta->fetch_assoc()){
$proximo_id_reto = $row['AUTO_INCREMENT'];
}
?>
<p><label for="vocal">Vocal:</label>&nbsp;
<?php 
$sql2= "SELECT id_elementos_juego,nombre_elemento FROM elementos_juego where tipo = 'Vocal';";
?>
<select class="" name="vocal" id="vocal">
<option value="">Seleccione una opci&oacute;n</option>
<?php
$consulta2 = $mysqli->query($sql2);
while($row2=$consulta2->fetch_assoc()){
echo '<option value="'.$row2['id_elementos_juego'].'">'.$row2['nombre_elemento'].'</option>';
}
?>
</select><input type="button" onclick="agregar_elemento('vocal')" value="Agregar"></p>
<p><label for="silaba">Silaba:</label>
<?php
$sql3= "SELECT id_elementos_juego, nombre_elemento FROM elementos_juego where tipo = 'Silaba';";
?>
<input class="" autocomplete="off" list="list_silaba" onblur="/*validar()*/" id="silaba">
<datalist id="list_silaba">
<?php
$consulta3 = $mysqli->query($sql3);
while($row3=$consulta3->fetch_assoc()){
echo '<option data-value="'.$row3['id_elementos_juego'].'">'.$row3['nombre_elemento'].'</option>';
}
?>
</datalist>
<input type="hidden" name="silaba" id="silaba-hidden">
<input type="button"  onclick="agregar_elemento('silaba')" value="Agregar"></p>
<p><label for="figura">Figura:</label>
<input hidden id="icono_seleccionadoindex1">
<input hidden name="figura" id="figura">
<img id="icono_seleccionado_imgindex1" width="80">
<?php 
boton_modal_elegir_icono('index1');
ventana_modal_elegir_icono('index1');
ventana_modal_nuevo_icono('id="form_guardar_icono" method="post" class="form_ajax" resp_1="Icono creado correctamente" resp_0="icono no creado, revise su información e intentete nuevo" action="?guardar_icono" callback_1="document.getElementById(\'cerrar_modal_nuevo_icono\').click();buscar_iconos();" callback_0="false" callback="buscar_iconos();"');
//listado_secuencias();if(document.getElementByUd('elegir_al_crear').ckecked){}
/*
$sql4= "SELECT id_elementos_juego,nombre_elemento,archivo FROM elementos_juego where tipo = 'Figura';";
?>
<select class="" name="figura" id="figura">
<option value="">Seleccione una opci&oacute;n</option>
<?php
$consulta4 = $mysqli->query($sql4);
while($row4=$consulta4->fetch_assoc()){
echo '<option data-url="'.$row4['archivo'].'" value="'.$row4['id_elementos_juego'].'"';if (isset($row['figura']) and $row['figura'] == $row4['id_elementos_juego']) echo " selected ";echo '>'.$row4['nombre_elemento'].'</option>';
}
?>
</select>
*/
?>
<input type="button"  onclick="agregar_elemento('figura')" value="Agregar"></p>
<p><label for="palabra">Palabra:</label>
<input class="" autocomplete="off" name="palabra" id="palabra" >
<input type="button"  onclick="agregar_elemento('palabra')" value="Agregar"></p>
<p>
    </div>
    <div class="col-md-6">
    <span id="area_reto">
    <div>
    <p><label for="reto">Nombre del Reto:</label>
    <input class="" name="reto" id="reto" value="<?php if (isset($_POST['id_reto'])) 
        echo $_POST['id_reto'];
        else
        echo $proximo_id_reto ?>">
    <input hidden name="secuencia" id="secuencia" value="<?php if (isset($_POST['secuencia'])) echo $_POST['secuencia'];?>" required>
    <br><input type="hidden" id="id_reto" name="id_reto" value="<?php if (isset($_POST['cod'])) echo $_POST['cod'];  ?>">
    </p>
        <div class="lienzo">
            <input type="hidden" id="num_elemento" value="0">
            
            <div id="elementos">
            </div>
            <input style="width:1px;height:1px;" required id="radior" title="Por favor seleccione clave una clave" type="radio" name="correcta" value="">
        </div>
        <p><label><input type="checkbox" name="estado" id="estado" value="Publicado">Publicado</label></p>
        <p><label for="dificultad">Dificultad:
<div id="slider">
  <input class="bar" style="width:240px" type="range" name="dificultad" id="dificultad" min="1" max="3"  required value="1" onchange="rangevalue.value=value" />
  <span class="highlight"></span>
  <output id="rangevalue">1</output>
</div>
</p>
    <input type="button" onclick="guardar_reto();" value="Crear" value="Crear"></p>
    </div>
    </span>
    </div>
</center>
 </div>
 <span id="txt_secuencias">
<?php if (isset($_POST['secuencia'])) cargar_secuencia($_POST['secuencia']); ?>
 </span>
<script>
    document.querySelector('input[list]').addEventListener('input', function(e) {
        var input = e.target,
            list = input.getAttribute('list'),
            options = document.querySelectorAll('#' + list + ' option'),
            hiddenInput = document.getElementById(input.id + '-hidden'),
            inputValue = input.value;
        hiddenInput.value = inputValue;
        for(var i = 0; i < options.length; i++) {
            var option = options[i];
            if(option.innerText === inputValue) {
                hiddenInput.value = option.getAttribute('data-value');
                break;
            }
        }
    });
</script>
<?php $contenido = ob_get_contents();
ob_clean();
include (dirname(__FILE__)."/../plantilla/home.php");
 ?>
