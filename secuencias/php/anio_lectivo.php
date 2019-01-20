<?php 
ob_start();
require("../config/conexion.php");
 require_once("../config/funciones.php"); 
 ?>
<center>
<?php 
function buscar_anio_lectivo($datos="",$reporte=""){
require("../config/conexion.php");
require_once ("../lib/Zebra_Pagination/Zebra_Pagination.php");
if (isset($_COOKIE['numeroresultados_anio_lectivo']) and $_COOKIE['numeroresultados_anio_lectivo']=="")  $_COOKIE['numeroresultados_anio_lectivo']="0";
$resultados = ((isset($_COOKIE['numeroresultados_anio_lectivo']) and $_COOKIE['numeroresultados_anio_lectivo']!="" ) ? $_COOKIE['numeroresultados_anio_lectivo'] : 10);
$paginacion = new Zebra_Pagination();
$paginacion->records_per_page($resultados);
$paginacion->records_per_page($resultados);

$cookiepage="page_anio_lectivo";
$funcionjs="buscar();";$paginacion->fn_js_page("$funcionjs");
$paginacion->cookie_page($cookiepage);
$paginacion->padding(false);
if (isset($_COOKIE["$cookiepage"])) $_GET['page'] = $_COOKIE["$cookiepage"];
$sql = "SELECT `anio_lectivo`.`id_anio_lectivo`, `anio_lectivo`.`nombre_anio_lectivo`, `anio_lectivo`.`estado_anio_lectivo` FROM `anio_lectivo`   ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' WHERE ';
if (isset($_COOKIE['busqueda_avanzada_anio_lectivo']) and $_COOKIE['busqueda_avanzada_anio_lectivo']=="true"){
if (isset($_COOKIE['busqueda_av_anio_lectivonombre_anio_lectivo']) and $_COOKIE['busqueda_av_anio_lectivonombre_anio_lectivo']!=""){
$sql .= ' LOWER(`anio_lectivo`.`nombre_anio_lectivo`) LIKE "%'.mb_strtolower($_COOKIE['busqueda_av_anio_lectivonombre_anio_lectivo'], 'UTF-8').'%" and ';
}
if (isset($_COOKIE['busqueda_av_anio_lectivoestado_anio_lectivo']) and $_COOKIE['busqueda_av_anio_lectivoestado_anio_lectivo']!=""){
$sql .= ' LOWER(`anio_lectivo`.`estado_anio_lectivo`) = "'.mb_strtolower($_COOKIE['busqueda_av_anio_lectivoestado_anio_lectivo'], 'UTF-8').'" and ';
}
}
foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`anio_lectivo`.`nombre_anio_lectivo`)," ",LOWER(`anio_lectivo`.`estado_anio_lectivo`)," "   ) LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
$sql .=  " ORDER BY ";
if (isset($_COOKIE['orderbyanio_lectivo']) and $_COOKIE['orderbyanio_lectivo']!=""){ $sql .= "`anio_lectivo`.`".$_COOKIE['orderbyanio_lectivo']."`";
}else{ $sql .= "`anio_lectivo`.`id_anio_lectivo`";}
if (isset($_COOKIE['orderad_anio_lectivo'])){
$orderadanio_lectivo = $_COOKIE['orderad_anio_lectivo'];
$sql .=  " $orderadanio_lectivo ";
}else{
$sql .=  " desc ";
}
$consulta_total_anio_lectivo = $mysqli->query($sql);
$total_anio_lectivo = $consulta_total_anio_lectivo->num_rows;
$paginacion->records($total_anio_lectivo);
if ($reporte=="") $sql .=  " LIMIT " . (($paginacion->get_page() - 1) * $resultados) . ", " . $resultados;
/*echo $sql;*/ 
$consulta = $mysqli->query($sql);
$numero_anio_lectivo = $consulta->num_rows;
$minimo_anio_lectivo = (($paginacion->get_page() - 1) * $resultados)+1;
$maximo_anio_lectivo = (($paginacion->get_page() - 1) * $resultados) + $resultados;
if ($maximo_anio_lectivo>$numero_anio_lectivo) $maximo_anio_lectivo=$numero_anio_lectivo;
$maximo_anio_lectivo += $minimo_anio_lectivo-1;
if ($reporte=="") echo "<p>Resultados de $minimo_anio_lectivo a $maximo_anio_lectivo del total de ".$total_anio_lectivo." en página ".$paginacion->get_page()."</p>";
 ?>
<div align="center">
<table border="1" id="tbanio_lectivo">
<thead>
<tr>
<th <?php  if(isset($_COOKIE['orderbyanio_lectivo']) and $_COOKIE['orderbyanio_lectivo']== "nombre_anio_lectivo"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyanio_lectivo','nombre_anio_lectivo');buscar();" >Año Lectivo</th>
<th <?php  if(isset($_COOKIE['orderbyanio_lectivo']) and $_COOKIE['orderbyanio_lectivo']== "estado_anio_lectivo"){ echo " style='text-decoration:underline' ";} ?>  onclick="grabarcookie('orderbyanio_lectivo','estado_anio_lectivo');buscar();" >Estado</th>
<?php if ($reporte==""){ ?>
<th class="thbotones" data-label="Nuevo" colspan="2"><form id="formNuevo" name="formNuevo" method="post" action="anio_lectivo.php">
<input name="cod" type="hidden" id="cod" value="0">
<input type="image" name="submit" id="submit" value="Nuevo" title="Nuevo" src="<?php echo $url_raiz ?>img/nuevo.png">
</form>
</th>
<?php } ?>
</tr>
</thead><tbody>
<?php 
while($row=$consulta->fetch_assoc()){
 ?>
<tr>
<td data-label='Año Lectivo'><?php echo $row['nombre_anio_lectivo']?></td>
<td data-label='Estado'><?php echo $row['estado_anio_lectivo']?></td>
<?php if ($reporte==""){ ?>
<td data-label="Modificar">
<form id="formModificar" name="formModificar" method="post" action="anio_lectivo.php">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_anio_lectivo']; ?>">
<input type="image" src="<?php echo $url_raiz ?>img/modificar.png"name="submit" id="submit" value="Modificar" title="Modificar">
</form>
</td>
<td data-label="Eliminar">
<?php if ($row['estado_anio_lectivo']!="Activo"){ ?>
<input title="Eliminar" type="image" src="<?php echo $url_raiz ?>img/eliminar.png" onClick="confirmeliminar('anio_lectivo.php',{'del':'<?php echo $row['id_anio_lectivo'];?>'},'<?php echo $row['nombre_anio_lectivo'];?>');" value="Eliminar">
<?php } ?>
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
buscar_anio_lectivo($_POST['datos']);
exit();
}

if (!empty($_POST)){
 /*Validación de los datos recibidos mediante el método POST*/ 
 foreach ($_POST as $id => $valor){$_POST[$id]=$mysqli->real_escape_string($valor);} 
}
if (isset($_POST['del'])){
 /*Instrucción SQL que permite eliminar en la BD*/ 
$sql = 'DELETE FROM anio_lectivo WHERE concat(`anio_lectivo`.`id_anio_lectivo`)="'.$_POST['del'].'"';
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/
if ($eliminar = $mysqli->query($sql)){
 /*Validamos si el registro fue eliminado con éxito*/ 
 ?>
Registro eliminado
<meta http-equiv="refresh" content="1; url=anio_lectivo.php" />
<?php 
}else{
?>
Eliminación fallida, por favor compruebe que la usuario no esté en uso
<meta http-equiv="refresh" content="2; url=anio_lectivo.php" />
<?php 
}
}
 ?>
<center>
<h1>Año Lectivo</h1>
</center><?php 
if (isset($_POST['submit'])){
if ($_POST['submit']=="Registrar"){
 /*recibo los campos del formulario proveniente con el método POST*/ 
 @session_start(); 
$sql = "INSERT INTO anio_lectivo (`id_anio_lectivo`, `nombre_anio_lectivo`, `estado_anio_lectivo`) VALUES ('".$_POST['id_anio_lectivo']."', '".$_POST['nombre_anio_lectivo']."', '".$_POST['estado_anio_lectivo']."')";
if ($_POST['estado_anio_lectivo']=="Activo"){
$sql_activo = "UPDATE anio_lectivo SET estado_anio_lectivo='Inactivo'";
$mysqli->query($sql_activo);
}
 /*echo $sql;*/
if ($insertar = $mysqli->query($sql)) {
 /*Validamos si el registro fue ingresado con éxito*/ 
if ($_POST['estado_anio_lectivo']=="Activo"){
$_SESSION['id_anio_lectivo']=$mysqli->insert_id;
$_SESSION['nombre_anio_lectivo']=$_POST['nombre_anio_lectivo'];
}
 ?>
Registro Exitoso
<meta http-equiv="refresh" content="1; url=anio_lectivo.php" />
<?php 
 }else{ 
 ?>
Registro fallido
<meta http-equiv="refresh" content="1; url=anio_lectivo.php" />
<?php 
}
} /*fin Registrar*/ 
if ($_POST['submit']=="Nuevo" or $_POST['submit']=="Modificar"){
if ($_POST['submit']=="Modificar"){
$sql = 'SELECT `id_anio_lectivo`, `nombre_anio_lectivo`, `estado_anio_lectivo` FROM `anio_lectivo` WHERE concat(`anio_lectivo`.`id_anio_lectivo`) ="'.$_POST['cod'].'" Limit 1'; 
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
<div class="col-md-3"></div><form class="col-md-6" id="form1" name="form1" method="post" action="anio_lectivo.php" >
<h1><?php echo $textoh1 ?></h1>
<p><input name="cod" type="hidden" id="cod" value="<?php if (isset($row['id_anio_lectivo']))  echo $row['id_anio_lectivo'] ?>" size="120" required></p>

<div class="form-group">
    <p>
        <input title="" class="form-control" name="id_anio_lectivo" type="hidden" id="id_anio_lectivo" value="<?php 
        if (isset($row['id_anio_lectivo'])) echo $row['id_anio_lectivo'];
        ?>">
    </p>
    </div>
    <script>
     function ocultar_opcion(id){
      $("#"+id).hide();
      
     }
     function mostrar_opcion(id){
      $("#"+id).show();
      $("#"+id).val("");
      sugerir_nombre_anio_lectivo();
     }
     function sugerir_nombre_anio_lectivo(){
      var nombreb = $("#nombre_anio_lectivoB").val();
      if (nombreb!="")
      var nombre = $("#nombre_anio_lectivoA").val()+"-"+$("#nombre_anio_lectivoB").val();
      else
      var nombre = $("#nombre_anio_lectivoA").val();
       $("#nombre_anio_lectivo").val(nombre);
     }
     function validar_numero(e,obj){
      var numero = obj.value;
      if (numero.length>=4){
      return false;
      }
     
      tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla==8){
        return true;
    }
        
    // Patron de entrada, en este caso solo acepta numeros
    patron =/[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
     }
    </script>
    <?php 
        if (isset($row['nombre_anio_lectivo'])){
         $datos_anio = explode("-",$row['nombre_anio_lectivo']);
        }
        //print_r($datos_anio);
        ?>
<div class="form-group">
    <p>
        <label for="nombre_anio_lectivo">Año Lectivo:<span title="Este campo es obligatorio" style="color:red;font-size: 30px;margin: 2px;/top: 12px;top: 13px;position: relative;">*</span></label>
        <label><input title="Calendario A Ejemplo: 2017" <?php if (!isset($datos_anio[1])) echo 'checked' ?> type="radio" onchange="ocultar_opcion('nombre_anio_lectivoB');" name="calendario" value="A">A</label>
        <label><input title="Calendario B Ejemplo: 2017-2018" <?php if (isset($datos_anio[1])) echo 'checked' ?> type="radio" onchange="mostrar_opcion('nombre_anio_lectivoB');" name="calendario" value="B">B</label>
        <input placeholder="Año Lectivo" type="text" onkeyup="this.onchange();" onkeypress="return validar_numero(event,this)" onchange="sugerir_nombre_anio_lectivo();" title="" class="form-control" type="text" id="nombre_anio_lectivoA" value="<?php 
        if (isset($datos_anio[0])) echo $datos_anio[0];
        ?>" >
        <input placeholder="Año Lectivo" type="text" onkeyup="this.onchange();" onkeypress="return validar_numero(event,this)" onchange="sugerir_nombre_anio_lectivo();" title="" <?php
        if (!isset($datos_anio[1])) echo 'style="display: none;"';?> class="form-control" type="text" id="nombre_anio_lectivoB" value="<?php 
        if (isset($datos_anio[1])) echo $datos_anio[1];
        ?>" >
        <hr>
         <input title="" class="form-control" name="nombre_anio_lectivo" type="hidden" id="nombre_anio_lectivo" value="<?php 
        if (isset($row['nombre_anio_lectivo'])) echo $row['nombre_anio_lectivo'];
        ?>" required>
    </p>
</div>

<?php 
echo '<div class="form-group"><p><input type="hidden" name="estado_anio_lectivo" value="Inactivo"><input title="" class="" name="estado_anio_lectivo" type="checkbox" id="estado_anio_lectivo" value="';echo 'Activo';echo '"';if (isset($row['estado_anio_lectivo']) and $row['estado_anio_lectivo']=="Activo") echo " checked ";echo '><label for="estado_anio_lectivo">Año activo</label></p></div>';
echo '<p><input type="hidden" name="submit" id="submit" value="'.$textobtn.'"><button type="submit" class="btn btn-primary">'.$textobtn.'</button></p>';
?>
</form><div class="col-md-3"></div>
<?php
} /*fin mixto*/ 
if ($_POST['submit']=="Actualizar"){
/*recibo los campos del formulario proveniente con el método POST*/
$cod = $_POST['cod'];
 /*Instrucción SQL que permite insertar en la BD */ 
 @session_start(); 
$sql = "UPDATE anio_lectivo SET id_anio_lectivo='".$_POST['id_anio_lectivo']."', nombre_anio_lectivo='".$_POST['nombre_anio_lectivo']."', estado_anio_lectivo='".$_POST['estado_anio_lectivo']."'WHERE  `anio_lectivo`.`id_anio_lectivo` = '".$cod."';";
/* echo $sql;*/
if ($_POST['estado_anio_lectivo']=="Activo"){
$sql_activo = "UPDATE anio_lectivo SET estado_anio_lectivo='Inactivo'";
$mysqli->query($sql_activo);
}
 /*Se conecta a la BD y luego ejecuta la instrucción SQL*/ 
if ($actualizar = $mysqli->query($sql)) {
if ($_POST['estado_anio_lectivo']=="Activo"){
$_SESSION['id_anio_lectivo']=$_POST['id_anio_lectivo'];
$_SESSION['nombre_anio_lectivo']=$_POST['nombre_anio_lectivo'];
}
 /*Validamos si el registro fue ingresado con éxito*/
?>
Modificación exitosa
<meta http-equiv="refresh" content="1; url=anio_lectivo.php" />
<?php 
 }else{ 
?>
Modificación fallida
<meta http-equiv="refresh" content="2; url=anio_lectivo.php" />
<?php 
}
} /*fin Actualizar*/ 
 }else{ 
if (isset($_COOKIE['numeroresultados_anio_lectivo']) and $_COOKIE['numeroresultados_anio_lectivo']=="")  $_COOKIE['numeroresultados_anio_lectivo']="10";
 ?>
<center>
<b><label>Buscar: </label></b><input placeholder="Buscar por palabra clave" title="Buscar por palabra clave: Año Lectivo, Estado" type="search" id="buscar" onkeyup ="buscar(this.value);" onchange="buscar(this.value);"  style="margin: 15px;">
<b><label>N° de Resultados por página:</label></b>
<input onKeyPress="return soloNumeros(event)" type="number" min="0" id="numeroresultados_anio_lectivo" placeholder="Cant." title="Cantidad de resultados" value="<?php $no_resultados = ((isset($_COOKIE['numeroresultados_anio_lectivo']) and $_COOKIE['numeroresultados_anio_lectivo']!="" ) ? $_COOKIE['numeroresultados_anio_lectivo'] : 10); echo $no_resultados; ?>" onkeyup="grabarcookie('numeroresultados_anio_lectivo',this.value) ;buscar(document.getElementById('buscar').value);" mousewheel="grabarcookie('numeroresultados_anio_lectivo',this.value);buscar(document.getElementById('buscar').value);" onchange="grabarcookie('numeroresultados_anio_lectivo',this.value);buscar(document.getElementById('buscar').value);" size="4" style="width: 60px;">
<button title="Orden Ascendente" onclick="grabarcookie('orderad_anio_lectivo','ASC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-up"></span></button><button title="Orden Descendente" onclick="grabarcookie('orderad_anio_lectivo','DESC');buscar(document.getElementById('buscar').value);"><span class="  glyphicon glyphicon-arrow-down"></span></button>
<p><label><input type="checkbox" onchange="grabarcookie('busqueda_avanzada_anio_lectivo',this.checked);mostrar_busqueda_avanzada(this.checked);buscar();" <?php if (isset($_COOKIE['busqueda_avanzada_anio_lectivo']) and $_COOKIE['busqueda_avanzada_anio_lectivo']=='true') echo 'checked' ?>>Búsqueda Avanzada</label></p>
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
<div class="busqueda_avanzada" <?php if (!isset($_COOKIE['busqueda_avanzada_anio_lectivo']) or (isset($_COOKIE['busqueda_avanzada_anio_lectivo']) and $_COOKIE['busqueda_avanzada_anio_lectivo']!='true')) echo 'style="display:none"' ?>>
<div class="form-group"><p><label for="nombre_anio_lectivo">Año Lectivo<input placeholder="Año Lectivo" title="Año Lectivo, Ejemplo: 2017, 2017-2018" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_anio_lectivonombre_anio_lectivo',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_anio_lectivonombre_anio_lectivo'])) echo $_COOKIE['busqueda_av_anio_lectivonombre_anio_lectivo']; ?>
"></label></p></div>
<div class="form-group"><p><label for="estado_anio_lectivo">Estado<input title="Ejemplo: Activo, Inactivo" placeholder="Estado" class="form-control input_busqueda_avanzada" type="search" onchange="grabarcookie('busqueda_av_anio_lectivoestado_anio_lectivo',this.value);buscar();" onblur="this.onchange();" value="
<?php if (isset($_COOKIE['busqueda_av_anio_lectivoestado_anio_lectivo'])) echo $_COOKIE['busqueda_av_anio_lectivoestado_anio_lectivo']; ?>
"></label></p></div>

<input type="button" onclick="buscar();" class="btn btn-primary" value="Buscar">
</div>
<span id="txtsugerencias">
<?php 
buscar_anio_lectivo();
 ?>
</span>
<?php 
}/*fin else if isset cod*/
echo '</center>';
 ?>
<script>
var vmenu_anio_lectivo = document.getElementById('menu_anio_lectivo')
if (vmenu_anio_lectivo){
vmenu_anio_lectivo.className ='active '+vmenu_anio_lectivo.className;
}
</script>
<?php $contenido = ob_get_contents();
ob_clean();
include ("../plantilla/home.php");
 ?>
