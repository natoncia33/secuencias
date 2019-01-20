<?php
ob_start();
@session_start();
if (!isset($_SESSION['email'])){
   header("Location: login.php");
}
require_once(dirname(__FILE__)."/../config/funciones.php");
?>
<script>
function verocultar(id){
	document.getElementById(id).style.display = document.getElementById(id).style.display == 'none' ? 'blocK':'none';
}
function grupos_por_asignacion(id_docente){
ajax=nuevoAjax();
ajax.open("POST","?grupos_por_asignacion",true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		document.getElementById('span_grupos').innerHTML = ajax.responseText;
		}
	}
ajax.send("id_docente="+id_docente);
}
function matricula_estudiantes_por_grupos(id_grupo){
ajax=nuevoAjax();
ajax.open("POST","?matricula_estudiantes_por_grupos",true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		document.getElementById('span_estudiantes').innerHTML = ajax.responseText;
		}
	}
ajax.send("id_grupo="+id_grupo);
}
</script>
<style>
	table li{
		list-style:none;
	}
</style>
<a href="estadisticas.php">Estadistica</a><br>
<?php
require(dirname(__FILE__)."/../config/conexion.php");
$sql="SELECT * FROM `asignacion` inner join usuarios on asignacion.docente = usuarios.id_usuarios ";
if ($_SESSION['tipo']!="admin"){
$sql .= " wHERE asignacion.docente = '".$_SESSION['id_usuarios']."'";
}
$sql .= " GROUP BY asignacion.docente";
$consulta = $mysqli->query($sql);
 ?><label>Docente: <select onchange="grupos_por_asignacion(this.value)"><option value="">Seleccione un docente</option><?php
    while ($row = $consulta->fetch_assoc()){
        ?>
        <option value="<?php echo $row['docente'];?>"><?php echo $row['docente'].": ".$row['apellido1']." ".$row['apellido2']." ".$row['nombre'];?></option>
        <?php
    }
?></select></label><?php
echo "<hr>";
?>

<span id="span_grupos"></span>
<hr>
<span id="span_estudiantes"></span>
<?php
echo "<hr>";
#echo insignias_ganadas();
?>
<?php
$contenido = ob_get_contents();
ob_clean();
include ("../plantilla/home.php");
 ?>