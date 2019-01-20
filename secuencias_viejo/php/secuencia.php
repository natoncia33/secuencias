<?php 
ob_start();
@session_start();
if (!isset($_SESSION['email'])){
 if ($_SESSION['tipo']!="admin" and $_SESSION['tipo']!="docente"){
    header("Location: login.php"); 
 }
}
 ?>
<center>
<?php 
require(dirname(__FILE__)."/../config/conexion.php");
require_once(dirname(__FILE__)."/../config/funciones.php");
if (isset($_GET['pdf'])){
 ?>
<style>
 table {
    border-collapse: collapse;
}
table, td, th {
    border: 1px solid black;
}
</style>
 <h1>Secuencia</h1><?php
buscar_secuencia('','pdf');
#$print=false;
require(dirname(__DIR__)."/lib/convertir_dompdf.php");
exit();
}
function buscar_secuencia($datos="",$reporte=""){
if ($reporte=="xls"){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; Filename=secuencia.xls");
}
require(dirname(__FILE__)."/../config/conexion.php");
require_once (dirname(__FILE__)."/../lib/Zebra_Pagination/Zebra_Pagination.php");
if (isset($_COOKIE['numeroresultados_secuencia']) and $_COOKIE['numeroresultados_secuencia']=="")  $_COOKIE['numeroresultados_secuencia']="0";
$resultados = ((isset($_COOKIE['numeroresultados_secuencia']) and $_COOKIE['numeroresultados_secuencia']!="" ) ? $_COOKIE['numeroresultados_secuencia'] : 10);
$paginacion = new Zebra_Pagination();
$paginacion->records_per_page($resultados);
$paginacion->records_per_page($resultados);

$cookiepage="page_secuencia";
$funcionjs="buscar();";$paginacion->fn_js_page("$funcionjs");
$paginacion->cookie_page($cookiepage);
$paginacion->padding(false);
if (isset($_COOKIE["$cookiepage"])) $_GET['page'] = $_COOKIE["$cookiepage"];
$sql ="SELECT `secuencia`.`id_secuencia`, `secuencia`.`nombre_secuencia`, ROUND(AVG(`reto`.`dificultad`)) as dificultad_secuencia FROM `secuencia` left join `reto` on `secuencia`.`id_secuencia`= `reto`.`id_secuencia` ";
#$sql = "SELECT `secuencia`.`id_secuencia`, `secuencia`.`nombre_secuencia` FROM `secuencia`   ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' WHERE ';
if (isset($_COOKIE['busqueda_avanzada_secuencia']) and $_COOKIE['busqueda_avanzada_secuencia']=="true"){
if (isset($_COOKIE['busqueda_av_secuencianombre_secuencia']) and $_COOKIE['busqueda_av_secuencianombre_secuencia']!=""){
$sql .= ' LOWER(`secuencia`.`nombre_secuencia`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_secuencianombre_secuencia'], 'UTF-8').'%" and ';
}
}
foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`secuencia`.`nombre_secuencia`)," ") LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
if  ($_SESSION['tipo']=="docente"){
$sql .= " and asignacion = '".$_SESSION['id_asignacion']."'";
}
$sql .=  " GROUP BY ( `secuencia`.`id_secuencia`) order by dificultad_secuencia ";
if (isset($_COOKIE['orderad_secuencia'])){
$orderadsecuencia = $_COOKIE['orderad_secuencia'];
$sql .=  " $orderadsecuencia ";
}else{
$sql .=  " asc ";
}
$consulta_total_secuencia = $mysqli->query($sql);
$total_secuencia = $consulta_total_secuencia->num_rows;
$paginacion->records($total_secuencia);
if ($reporte=="") $sql .=  " LIMIT " . (($paginacion->get_page() - 1) * $resultados) . ", " . $resultados;
/*echo $sql;*/ 
$consulta = $mysqli->query($sql);
 ?>
<div align="center">
<div class="row" >
<div class="col-md-12">
<?php 
while($row=$consulta->fetch_assoc()){
 ?>
<div class="panel panel-default">
    <div class="panel-heading"><!--td><?php echo $row['id_secuencia']?></td-->
<p>Secuencia N°<?php echo $row['id_secuencia']?>: <?php echo $row['nombre_secuencia']?></p>
<p>Dificultad promedio: <?php echo $row['dificultad_secuencia']?></p>
 <p>
<form id="formModificar" name="formModificar" method="post" action="secuencia.php">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_secuencia']?>">
<input type="image" src="<?php echo $url_raiz ?>img/modificar.png" name="submit" id="submit" value="Modificar">
</form>
<input type="image" src="<?php echo $url_raiz ?>img/eliminar.png" onClick="confirmeliminar('secuencia.php',{'del':'<?php echo $row['id_secuencia'];?>'},'N° <?php echo $row['id_secuencia']?>: <?php echo $row['nombre_secuencia'];?>');" value="Eliminar">
</p></div>
    <div class="panel-body">
<div class="row">
     <div class="col-md-12" style="top: 10px;overflow-x:auto;">

 <span style="height:150px;">
  
       <?php cargar_secuencia($row['id_secuencia']) ?>
 </span>
     </div>
  </div>
</div>
</div></div>
<?php 
}/*fin while*/
 ?>
</tbody>
</table>
<?php if ($reporte=="") $paginacion->render2();?>
</div>
</div><!--/div row -->
</div>
<?php 
}/*fin function buscar*/
if (isset($_GET['buscar'])){
buscar_secuencia($_POST['datos']);
exit();
}

if (isset($_POST['del'])){
 /*Instrucción SQL que permite eliminar en la BD*/ 
$sql = 'DELETE FROM secuencia WHERE id_secuencia="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
$eliminar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
 /*Validamos si el registro fue eliminado con éxito*/ 
 ?>
<script>
 alert('Registro eliminado');
 document.location.href="secuencia.php";
</script>
<?php 
}else{
?>
<script>
 alert('Eliminación fallida, por favor compruebe que esta secuencia no esté en uso');
 document.location.href="secuencia.php";
</script>
<?php 
}
}
 ?>
<center>
<h1>Secuencia</h1>
</center><?php 
if (isset($_POST['submit'])){
if ($_POST['submit']=="Registrar"){
 @session_start();
 #print_r($_POST);
 #exit();
 if (isset($_SESSION['tipo']) and $_SESSION['tipo']=="admin")
$guardar_secuencia = guardar_secuencia($_POST['nombre_secuencia'],$_POST['asignacion_docente']);
 else
$guardar_secuencia = guardar_secuencia($_POST['nombre_secuencia']);
 if ($guardar_secuencia==1){
  /*Validamos si el registro fue ingresado con éxito*/ 
  ?>
 <script>alert('Registro exitoso')</script>
 <meta http-equiv="refresh" content="1; url=secuencia.php" />
 <?php 
  }elseif ($guardar_secuencia==2){
  /*Validamos si el registro fue ingresado con éxito*/ 
  ?>
 <script>alert('Registro duplicado')</script>
 <meta http-equiv="refresh" content="1; url=secuencia.php" />
 <?php 
  }else{
  ?>
 <script>alert('Registro fallido')</script>
 <meta http-equiv="refresh" content="1; url=secuencia.php" />
 <?php 
 }
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo" or $_POST['submit']=="Modificar"){
if ($_POST['submit']=="Modificar"){
$sql = "SELECT `id_secuencia`, `nombre_secuencia` FROM `secuencia` WHERE id_secuencia ='".$_POST['cod']."' Limit 1"; 
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
<form id="form1" name="form1" method="post" action="secuencia.php">
<h1><?php echo $textoh1 ?></h1>
<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_secuencia']))  echo $row['id_secuencia'] ?>" size="120" required></p>
<?php 
echo '<p><input class=""name="id_secuencia"type="hidden" id="id_secuencia" value="';if (isset($row['id_secuencia'])) echo $row['id_secuencia'];echo '"';echo '></p>';
echo '<p><label for="nombre_secuencia">Nombre Secuencia:';
?>
<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span>

<?php
echo'</label><input autocomplete="off" onkeyup="valida_existe_nombre_secuencia(this.value);" class=""name="nombre_secuencia"type="text" id="nombre_secuencia" value="';if (isset($row['nombre_secuencia'])) echo $row['nombre_secuencia'];echo '"';echo ' required >';
?>
</p>
<p>
<span id="txtnombre_secuencia"></span>
</p>
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
 ?><label>Docente y Grupo: <span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span><select id="asignacion_docente" name="asignacion_docente" required><option value="">Seleccione un docente</option><?php
    while ($row = $consulta->fetch_assoc()){
        ?>
        <option value="<?php echo $row['id_asignacion'];?>"><?php echo $row['docente'].": ".$row['apellido1']." ".$row['apellido2']." ".$row['nombre_docente']." - ".$row['nombre'];?></option>
        <?php
    }
?></select></label><?php
                }
                ?>
                </p>
<?php

echo '<p><input type="submit" name="submit" id="submit" value="'.$textobtn.'"></p>
</form>';
} /*fin mixto*/ 
if ($_POST['submit']=="Actualizar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
$cod = $_POST['cod'];
 /*Instrucción SQL que permite insertar en la BD */ 
$sql = "UPDATE secuencia SET id_secuencia='".$_POST['id_secuencia']."', nombre_secuencia='".$_POST['nombre_secuencia']."'WHERE  id_secuencia = '".$cod."';";
/* echo $sql;*/ 
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/ 
$actualizar = $mysqli->query($sql);
if ($mysqli->affected_rows>0){
 /*Validamos si el registro fue ingresado con éxito*/
 ?>
<script>alert('Modificación exitosa')</script>
<meta http-equiv="refresh" content="1; url=secuencia.php" />
<?php }else{ ?>
<script>alert('Modificacion fallida')</script>
<meta http-equiv="refresh" content="2; url=secuencia.php" />
<?php }
} /*fin Actualizar*/ 
 }else{ 
 ?>
<center>
<b><label>Buscar: </label></b><input title="Buscar por Nombre de Secuencia" type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados:</label></b>
<input type="number" min="0" id="numeroresultados_secuencia" placeholder="Cantidad de resultados" title="Cantidad de resultados" value="10" onkeyup="grabarcookie('numeroresultados_secuencia',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_secuencia',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_secuencia',this.value);buscar(document.getElementById('buscar').value);" size="4" style="width: 40px;">
<button title="Orden Ascendente" onclick="grabarcookie('orderad_secuencia','ASC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-up"></span></button><button title="Orden Descendente" onclick="grabarcookie('orderad_secuencia','DESC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-down"></span></button>
<p><label><input type="checkbox" onchange="grabarcookie('busqueda_avanzada_secuencia',this.checked);mostrar_busqueda_avanzada(this.checked);buscar();" <?php if (isset($_COOKIE['busqueda_avanzada_secuencia']) and $_COOKIE['busqueda_avanzada_secuencia']=='true') echo 'checked' ?>>Búsqueda Avanzada</label></p>
</center>

<form id="formNuevo" name="formNuevo" method="post" action="secuencia.php">
<input name="cod" type="hidden" id="cod" value="0">
<input type="image" src="<?php echo $url_raiz ?>img/nuevo.png" name="submit" id="submit" value="Nuevo">
</form>
<form id="formNuevo" name="formNuevo" method="post" action="secuencia.php?pdf">
<input name="cod" type="hidden" id="cod" value="0">
<input type="image" title="Descargar en pdf" src="<?php echo $url_raiz ?>img/pdf.png" name="submit" id="submit" value="PDF">
</form>
<span id="txtsugerencias">
<?php 
buscar_secuencia();
 ?>
</span>
<?php 
}/*fin else if isset cod*/
echo '</center>';
 ?>
<script>
//document.getElementById('menu_secuencia').className ='active '+document.getElementById('menu_secuencia').className;
</script>
<?php $contenido = ob_get_contents();
ob_clean();
include ("../plantilla/home.php");
 ?>
