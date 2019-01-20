<?php 
require_once(dirname(__FILE__)."/../config/conexion.php");
require_once(dirname(__FILE__)."/../config/funciones.php");
ob_start();
$sql2= "SELECT `secuencia`.`id_secuencia`, `secuencia`.`nombre_secuencia` FROM `secuencia`";
?>
<select class="" name="secuencia" id="secuencia" onchange="if(this.value=='Nueva') {document.getElementById('modal_nueva_secuencia').click();cargar_secuencias('0')}else{cargar_secuencias(this.value);}">
<option value="">Seleccione una opci&oacute;n</option>
<?php
$consulta2 = $mysqli->query($sql2);
$primerasecuencia = true;
while($row2=$consulta2->fetch_assoc()){
echo '<option value="'.$row2['id_secuencia'].'"';
if (isset($_POST['secuencia']) and $row2['id_secuencia']==$_POST['secuencia']){
        echo ' selected ';
}else if (!isset($_POST['secuencia']) and $primerasecuencia==true){
        echo ' selected ';
        $primerasecuencia = false;
        $primerasecuencia1 = $row2['id_secuencia'];
}
echo '>'.$row2['nombre_secuencia'].'</option>';
}
if (!isset($_POST['secuencia']))
$_POST['secuencia'] = $primerasecuencia1;
?>
<option value="Nueva">Crear Nueva Secuencia</option>
</select>
<?php $contenido = ob_get_contents();
ob_clean();
include ("home.php");
 ?>
