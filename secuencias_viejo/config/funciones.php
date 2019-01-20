<?php
if (isset($_GET['buscar_iconos'])){
$contenidoc = ob_get_clean();
buscar_iconos($_POST['datos'],'',$_POST['destino']);
exit();
}
if (isset($_GET['url_raiz'])){
echo $url_raiz;
exit();
}
if (isset($_GET['cargar_secuencias'])){
cargar_secuencia($_POST['secuencia']);
exit();
}
if (isset($_GET['listado_secuencias'])){
listado_secuencias($_GET['listado_secuencias']);
exit();
}
if (isset($_GET['adjunto_imagenes'])){
$array = adjunto_imagenes();
echo json_encode($array);
exit();
}
if (isset($_GET['puntos'])){
$puntos = puntos($_POST['usuario'],$_POST['operador'],$_POST['cantidad']);
if ($puntos==true){
    echo "1";
}else{
    echo "0";
}
exit();
}
if (isset($_GET['insignia_a_usuario'])){
$insignias = insignia_a_usuario($_POST['insignia'],$_POST['usuario']);
if ($insignias==true){
    echo "1";
}else{
    echo "0";
}
exit();
}
if (isset($_GET['eliminar_elemento_de_reto'])){
eliminar_elemento_de_reto($_POST['id_elemento_reto']);
exit();
}
if (isset($_GET['modificar_reto'])){//modificando un reto
modificar_reto($_POST['cod'],$_POST['dif']);
exit();
}
if (isset($_GET['guardar_reto'])){//modificando un reto
guardar_reto($_POST['cod'],$_POST['dif']);
exit();
}
if (isset($_GET['nuevo_reto'])){//modificando un reto
nuevo_reto($_POST['cod'],$_POST['dif']);
exit();
}

if (isset($_GET['grupos_por_asignacion'])){
grupos_por_asignacion($_POST['id_docente']);
exit();
}
if (isset($_GET['matricula_estudiantes_por_grupos'])){
matricula_estudiantes_por_grupos($_POST['id_grupo']);
exit();
}
if (isset($_GET['guardar_secuencia'])){
if (isset($_POST['asignacion_docente']))
$guardar = guardar_secuencia($_POST['nombre_secuencia'],$_POST['asignacion_docente']);
else
$guardar = guardar_secuencia($_POST['nombre_secuencia'],$_SESSION['id_asignacion']);
ob_clean();
echo $guardar;
exit();
}
if (isset($_GET['valida_existe'])){
echo $_POST['tabla'].$_POST['campo'].$_POST['valor'];
ob_clean();
if (valida_existe($_POST['tabla'],$_POST['campo'],$_POST['valor'])){
    echo "1";
}else{
    echo "0";
}
exit();
}
function valida_existe($tabla,$campo,$valor){
    require("conexion.php");
    $sql ="SELECT * FROM `".$tabla."` WHERE `".$campo."` = '".$valor."'";
    $consulta = $mysqli->query($sql);
    if ($consulta->num_rows > 0) {
        return true;
     }else{ 
        return false;
    }
}
if (isset($_GET['valida_existe_par'])){
#echo $_POST['tabla'].$_POST['campo'].$_POST['valor'].$_POST['campo2'].$_POST['valor2'];
ob_clean();
if (valida_existe_par($_POST['tabla'],$_POST['campo'],$_POST['valor'],$_POST['campo2'],$_POST['valor2'])){
    echo "1";
}else{
    echo "0";
}
exit();
}
function valida_existe_par($tabla,$campo,$valor,$campo2,$valor2){
    require("conexion.php");
    $sql ="SELECT * FROM `".$tabla."` WHERE `".$campo."` = '".$valor."' and `".$campo2."` = '".$valor2."'";
    #echo $sql;
    $consulta = $mysqli->query($sql);
    if ($consulta->num_rows > 0) {
        return true;
     }else{ 
        return false;
    }
}

if (isset($_GET['valida_existe_trio'])){
#echo $_POST['tabla'].$_POST['campo'].$_POST['valor'].$_POST['campo2'].$_POST['valor2'];
ob_clean();
if (valida_existe_trio($_POST['tabla'],$_POST['campo'],$_POST['valor'],$_POST['campo2'],$_POST['valor2'],$_POST['campo3'],$_POST['valor3'])){
    echo "1";
}else{
    echo "0";
}
exit();
}
function valida_existe_trio($tabla,$campo,$valor,$campo2,$valor2,$campo3,$valor3){
    require("conexion.php");
    $sql ="SELECT * FROM `".$tabla."` WHERE `".$campo."` = '".$valor."' and `".$campo2."` = '".$valor2."' and `".$campo3."` = '".$valor3."'";
    #echo $sql;
    $consulta = $mysqli->query($sql);
    if ($consulta->num_rows > 0) {
        return true;
     }else{ 
        return false;
    }
}
function guardar_secuencia($nombre_secuencia,$asignacion_docente=""){
     require("conexion.php");
     @session_start();
 /*recibo los campos del formulario proveniente con el método POST*/ 
if ($asignacion_docente=="") $asignacion_docente = $_SESSION['id_asignacion'];
$sql = "INSERT INTO secuencia (`nombre_secuencia`, `asignacion`) VALUES ('".$nombre_secuencia."', '".$asignacion_docente."')";
//echo $sql;
$insertar = $mysqli->query($sql);
    if ($mysqli->errno != 1062){
        if ($mysqli->affected_rows>0) {
            return 1;
        }else{
            return 0;
        }
    }else{
        return 2;
    }
}
function grupos_por_asignacion($id_docente=""){
 require("conexion.php");
 $sql = "SELECT * FROM `asignacion` inner join grupo on asignacion.grupo = grupo.id_grupo ";
if (isset($id_docente) and $id_docente != "") $sql .= " WHERE asignacion.docente = '".$id_docente."'";
 $consulta = $mysqli->query($sql);
  ?><label>Grupo: <select onchange="matricula_estudiantes_por_grupos(this.value)"><option value="">Seleccione un grupo</option><?php
    while ($row = $consulta->fetch_assoc()){
          ?>
          <option value="<?php echo $row['id_grupo'];?>"><?php echo $row['nombre'];?></option><?php
    }
    ?></select></label><?php
}
function matricula_estudiantes_por_grupos($id_grupo=""){
 require("conexion.php");
 $sql = "SELECT `matricula`.`id_matricula`, `matricula`.`grupo`, `matricula`.`anio`, `matricula`.`estudiante`, `usuarios`.`id_usuarios`, `usuarios`.`nombre`, `usuarios`.`apellido1`, `usuarios`.`apellido2`, `usuarios`.`nuip`, `usuarios`.`email`, `usuarios`.`f_nacimiento`, `usuarios`.`avatar`, `usuarios`.`puntos` FROM `matricula` inner join `usuarios` on `matricula`.`estudiante` = `usuarios`.`id_usuarios` WHERE `matricula`.`grupo` = '".$id_grupo."'";
 $consulta = $mysqli->query($sql);
 if ($consulta->num_rows>0){
  ?><table>
  <tr>
      <th rowspan="2">Estudiante</th>
      <th rowspan="2">Secuencia</th>
      <th colspan="3">Retos</th>
      <th rowspan="2">Puntos</th>
      <th rowspan="2">Insignias</th>
  </tr>
  <tr>
      <th>SI</th>
      <th>NO</th>
      <th>Detalle</th>
  </tr>
  <?php
    while ($row = $consulta->fetch_assoc()){
          ?>
         <tr>
          <td><?php echo $row['id_matricula'].": ".$row['apellido1']." ".$row['apellido2']." ".$row['nombre'] ?></td>
          <td>
              <?php
              $sql_seguimiento = "SELECT `id_seguimiento_reto`, `reto`, `usuario`, `aprobado`, `fecha`, `h_inicio`, `h_fin`, `marcado` FROM `seguimiento_reto` WHERE `usuario` = '".$row['id_usuarios']."'";
    $consulta_seguimiento = $mysqli->query($sql_seguimiento);
    $secuencias_retos = array();
    $aprobados = 0;
    $no_aprobados = 0;
    $vacios = 0;
    $total = 0;
    $tiempototal = 0;
    $retos_array = array();
    while($row_seguimiento = $consulta_seguimiento->fetch_assoc()){
    $total++;
    if ($row_seguimiento['aprobado']=="SI"){
        $aprobados++;
    }elseif ($row_seguimiento['aprobado']=="NO"){
        $no_aprobados++;
    }elseif ($row_seguimiento['aprobado']==""){
        $vacios++;
    }
    $secuencias_retos[] = $row_seguimiento['reto'];
        $retos =  "<hr><br>Reto: ".$row_seguimiento['reto'];
        $retos .= "<br>Aprobado: ".$row_seguimiento['aprobado'];//=="SI"
        $retos .= "<br>Fecha: ".$row_seguimiento['fecha'];
        $retos .= "<br>Hora Inicio: ".$row_seguimiento['h_inicio'];
        $retos .= "<br>Hora Fin: ".$row_seguimiento['h_fin'];
        $retos .= "<br>Marcado: ".$row_seguimiento['marcado'];
        
        if ($row_seguimiento['h_inicio'] != "00:00:00" and $row_seguimiento['h_fin'] != "00:00:00"){
        $tiempo = diferencia_hora($row_seguimiento['h_inicio'],$row_seguimiento['h_fin']);
        $tiempototal += $tiempo;
        }else{
        $tiempo = "No se puede determinar";
        }
        $retos .= "<br>Tiempo: ".$tiempo." Segundos";
        $retos_array[] = $retos;
    }
    $resumen = "<hr>"."Total: ".$total."<br>"."Aprobados: ".$aprobados."<br>"."No Aprobados: ".$no_aprobados."<br>"."Vacios: ".$vacios."<br>"."Tiempo total: ".$tiempototal." Segundos, o ".convertir_a_minutos($tiempototal)." Minutos<br><hr>";
        secuenciasretos($secuencias_retos);
        ?>
          </td>
          <td><?php echo $aprobados ?></td>
          <td><?php echo $aprobados ?></td>
          <td><button class="btn btn-sucess" onclick="verocultar('detalles_est_<?php echo $row['id_matricula'] ?>')">Detalles</button>
          <div style="display:none" id="detalles_est_<?php echo $row['id_matricula'] ?>">
          <?php  foreach ($retos_array as $retos) echo $retos;
          echo $resumen ?>
          </div>
          </td>
          <td><?php echo $row['puntos']; ?></td>
          <td>
              <li><ul>
              <?php echo insignias_ganadas($row['id_usuarios']); ?>
              </ul></li>
          </td>
         </tr>
          <?php
    }
    ?></table><?php
}else{
 echo "No hay estudiantes matriculados a este grupo";
}
}
function shuffle_assoc(&$array) {
#shuffle($array);//los ordena aleatoriamente los elementos dentro del array "barajar"
        if (count ($array) > 0 ) {
        $keys = array_keys($array);

        shuffle($keys);

        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }

        $array = $new;

        return true;
    }
    }
function escape_string(&$elemento1, $clave)
{
    require("conexion.php");
    $elemento1 = $mysqli->real_escape_string($elemento1);
}
function values_columnas($array)
{
    foreach ($array as $id => $value){
        $array[$id]= " `".$id."` = VALUES(".$id.")";
    }
  return($array);
}
function test_print($elemento2, $clave)
{
    echo "$clave: $elemento2<br />\n";
}

function insertar($array,$tabla,$update = false){
array_walk($array, 'escape_string');
if (isset($array['clave']) and $array['clave']!="")
$array['clave']=sha1($array['clave']);
$columns = implode(", ",array_keys($array));
$escaped_values = array_values($array);
$values  = implode("', '", $escaped_values);
$array_values = values_columnas($array);
$value_columns = implode(", ",array_values($array_values));
$sql = "INSERT INTO `$tabla`($columns) VALUES ('$values')";
if($update) $sql .=" ON DUPLICATE KEY UPDATE $value_columns;";
return $sql;
}
function cargar_secuencia($secuencia){
require("conexion.php");
$retos = array();
$sql1 = "SELECT `id_reto`, `nombre_reto`, `dificultad` FROM `reto` WHERE estado = 'Publicado' and id_secuencia = '".$secuencia."';";
$sql1 = "SELECT `id_reto`, `nombre_reto`, `dificultad`, `estado` FROM `reto` WHERE id_secuencia = '".$secuencia."';";
#echo $sql1;
$consulta1 = $mysqli->query($sql1);
while($row1=$consulta1->fetch_assoc()){
$retos[$row1['id_reto']] = array("nombre_reto"=>$row1['nombre_reto'],"dificultad"=>$row1['dificultad'],"estado"=>$row1['estado']);
$sql2 = "SELECT `elementos_reto`.`id_elementos_reto`, `elementos_reto`.`elemento_reto`, `elementos_reto`.`tipo`, `elementos_juego`.`tipo` as tipo_e_juego, `elementos_juego`.`nombre_elemento`, `elementos_juego`.`archivo` FROM `elementos_reto` left join `elementos_juego` on `elementos_reto`.`elemento_reto` = `elementos_juego`.`id_elementos_juego` WHERE `elementos_reto`.`reto` = '".$row1['id_reto']."';";
$consulta2 = $mysqli->query($sql2);
while($row2=$consulta2->fetch_assoc()){
$retos[$row1['id_reto']]['elementos'][$row2['id_elementos_reto']]= array("elemento_reto"=>$row2['elemento_reto'],"tipo"=>$row2['tipo'],"tipo_e_juego"=>$row2['tipo_e_juego'],"nombre_elemento"=>$row2['nombre_elemento'],"archivo"=>$row2['archivo']);
}
}//consulta 1
?>
<div class="row">
<div class="col-md-12">
    <div id="secuencias">
    <?php
    /*
    <div id="secuencias">
    <div class="secuencia">1</div>
    <div class="secuencia">1</div>
    <div class="secuencia">1</div>
    </div>
    */
    foreach($retos as $id_reto => $reto){
    $hablar = "¿Donde está la ";
    shuffle_assoc($reto['elementos']);//barjar elementos
    ?>
    <div class="secuencia">
        <div class="secuencia2" id="sec2<?php echo $id_reto ?>" title="Dif: <?php echo $reto['dificultad']; ?> - <?php echo $reto['estado']; ?> #<?php echo $reto['nombre_reto']; ?>" >
        <span style="background-color:#FFF;">
        </span>
<input style="float:right;margin-right:10px;width:18px;height:18px;" type="image" src="<?php echo $url_raiz ?>img/eliminar.png" onClick="confirmeliminar('index.php',{'del':'<?php echo $id_reto ?>'},'<?php echo $id_reto ?>');" value="Eliminar">
<input onclick="modificar_reto('<?php echo $id_reto ?>','<?php echo $reto['dificultad']; ?>','<?php echo $reto['estado']; ?>')" style="float:right;margin-right:20px;width:18px;height:18px;" type="image" src="<?php echo $url_raiz ?>img/pencil.png" name="submit" id="submit" value="Modificar">
        <br>
        <?php 
        if (count ($reto['elementos']) > 0 )
        foreach($reto['elementos'] as $id_ele_reto => $ele_reto){ ?>
        <?php #echo  "Tipo: ".$ele_reto['tipo']; ?>
        <?php 
        $claseclave = '';
        if ($ele_reto['tipo']=="Clave"){
             $hablar .= $ele_reto['tipo_e_juego'].",";
             $hablar .= $ele_reto['nombre_elemento'];
             $claseclave = 'borde_rojo';
        }
        ?>
        <?php
        if ($ele_reto['tipo_e_juego']=="Figura"){
        echo  '<span class="elemento2 '.$claseclave.'"><img src="../img/figuras/'.$ele_reto['archivo'].'" width="30px"></span>';
        }else{
        echo  '<span class="elemento2 '.$claseclave.'">'.$ele_reto['nombre_elemento']."</span>";
        }
        #echo  "Archivo:".$ele_reto['archivo']; ?>
        <?php }
        $hablar .= "?";
        ?>
        <script>
        var obj = document.getElementById("sec2<?php echo $id_reto ?>");
        obj.addEventListener("click", function(){
            onclick="hablar('<?php echo $hablar ?>')"; 
        });
        </script>
        <?php
        #printf("<pre>%s</pre>",print_r($reto,true));
        ?>
    </div>
    </div>
    <?php
    }
    if (count($retos)==0){
        echo "Aún no hay retos en esta Secuencia";
    }
 ?>
    </div>
</div>
<?php
}
function nuevo_reto(){
require("conexion.php");
    $sql ="select AUTO_INCREMENT from information_schema.TABLES where TABLE_SCHEMA='$basededatos' and TABLE_NAME='reto'";
$consulta = $mysqli->query($sql);
if ($row = $consulta->fetch_assoc()){
$proximo_id_reto = $row['AUTO_INCREMENT'];
}
?>
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
            <input style="width:1px;height:1px;" required id="radior" title="Por favor seleccione clave una clave" type="radio" name="correcta" class="correcta" value="">
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
<?php
}
function modificar_reto($cod,$dif){
require("conexion.php");
#$retos2[$cod] = array('id_reto'=>$cod,"nombre_reto"=>$cod,"dificultad"=>"1","estado"=>"");
$sql2 = "SELECT `elementos_reto`.`id_elementos_reto`, `elementos_reto`.`elemento_reto`, `elementos_reto`.`tipo`, `elementos_juego`.`tipo` as tipo_e_juego, `elementos_juego`.`nombre_elemento`, `elementos_juego`.`archivo` FROM `elementos_reto` left join `elementos_juego` on `elementos_reto`.`elemento_reto` = `elementos_juego`.`id_elementos_juego` WHERE `elementos_reto`.`reto` = '".$cod."';";
#echo $sql2;
$consulta2 = $mysqli->query($sql2);
?>
<div>
    <p>
    <label for="reto">Nombre del Reto:</label>
    <input class="" name="reto" id="reto" value="<?php if (isset($_POST['id_reto'])) 
        echo $_POST['id_reto'];
        else
        echo $proximo_id_reto ?>">
    <input hidden name="secuencia" id="secuencia" value="<?php if (isset($_POST['secuencia'])) echo $_POST['secuencia'];?>" required>
    <br><input type="hidden" id="id_reto" name="id_reto" value="<?php if (isset($_POST['cod'])) echo $_POST['cod'];  ?>">
    </p>
        <div class="lienzo">
            <input type="hidden" id="num_elemento" value="<?php echo $consulta2->num_rows ?>">
            <div id="elementos">
            <?php
            $cont = 0;
            while($row2=$consulta2->fetch_assoc()){
#print_r($row2);
#$retos2[$cod]['elementos'][$row2['id_elementos_reto']]= array("elemento_reto"=>$row2['elemento_reto'],"tipo"=>$row2['tipo'],"tipo_e_juego"=>$row2['tipo_e_juego'],"nombre_elemento"=>$row2['nombre_elemento'],"archivo"=>$row2['archivo']);
        ?>
        <label class="areaselementos" id="areaelemento<?php echo $cont ?>" for="radio<?php echo $cont ?>">
                <span class="elemento"><input class="lienzo_<?php echo strtolower($row2['tipo_e_juego']);
                if (strtolower($row2['tipo_e_juego'])=="silaba") echo "-hidden";
                ?>" type="hidden" name="<?php echo strtolower($row2['tipo_e_juego']) ?>[<?php echo $row2['id_elementos_reto'] ?>]" id="<?php echo $row2['nombre_elemento'] ?>" value="<?php echo $row2['nombre_elemento'] ?>">
                <input required="" id="radio<?php echo $cont ?>" type="radio" class="correcta" name="correcta" <?php if ($row2['tipo']=="Clave") echo "checked" ?> value="<?php echo $row2['nombre_elemento'] ?>">
                    <span class="fig ajustar">
                        <?php 
                         if ($row2['tipo_e_juego']=="Figura"){
    	?><span><img src="<?php echo $url_raiz ?>img/figuras/<?php echo  $row2['nombre_elemento'] ?>.png" width="120"></span><?php }else{ ?>
    	<span><?php echo $row2['nombre_elemento'] ?></span><?php }
                        ?>
                        <a type="button" style="text-decoration:none;" class="btn_elim" onclick="eliminar_opcion('areaelemento<?php echo $cont ?>'); /*eliminar_elemento_de_reto('<?php echo $row2['id_elementos_reto'] ?>')*/;">X</a>
                    </span>
                </span>
        </label>
        <?php
        $cont++;
        } ?>
            </div>
            
        </div>
        <p><label><input type="checkbox" name="estado" id="estado" value="Publicado" <?php if (isset($_POST['estado']) and $_POST['estado']=="Publicado") echo "checked"; ?> >Publicado</label></p>
        <p><label for="dificultad">Dificultad:
<div id="slider">
  <input class="bar" style="width:240px" type="range" name="dificultad" id="dificultad" min="1" max="3"  required value="1" onchange="rangevalue.value=value" />
  <span class="highlight"></span>
  <output id="rangevalue">1</output>
</div>
</p>
    <input type="button" onclick="guardar_reto();" value="Guardar"></p>
    </div>
    <script>
            document.getElementById('dificultad').value="<?php echo $dif; ?>";
            document.getElementById('rangevalue').innerHTML="<?php echo $dif; ?>";
    </script>
    <?php
}
function eliminar_elementos_de_reto($id_reto){
    require("conexion.php");
    $sql = "DELETE FROM `elementos_reto` WHERE `reto` = '$id_reto'";
    $eliminar = $mysqli->query($sql);
    if ($mysqli->affected_rows>0){
        return true;
    }else{
        return false;
    }

}
function eliminar_elemento_de_reto($id){
    require("conexion.php");
    $sql = "DELETE FROM `elementos_reto` WHERE `id_elementos_reto` = '$id'";
    $eliminar = $mysqli->query($sql);
    if ($mysqli->affected_rows>0){
        echo "1";
    }else{
        echo "0";
    }
}
function guardar_reto(){
    require("conexion.php");
    #printf("<pre>%s</pre>",print_r($_POST,true));
    #"<br>";
    #$sql = "INSERT INTO reto (`id_reto`,`nombre_reto`, `estado`, `dificultad`) VALUES (".$_POST['reto'].", '".$_POST['reto']."', 'Publicado', '".$_POST['dificultad']."')";
    $array = array();
    $array['id_reto']=$_POST['id_reto'];
    eliminar_elementos_de_reto($_POST['id_reto']);
    $array['nombre_reto']=$_POST['reto'];
    $array['id_secuencia']=$_POST['secuencia'];
    $array['estado']=$_POST['estado'];
    $array['dificultad']=$_POST['dificultad'];
    $sql = insertar($array,'reto',true);
    echo  $sql;
    $insertar = $mysqli->query($sql);
    if ($_POST['id_reto'] == "" ){
    $id_reto = $mysqli->insert_id;
    }else{
    $id_reto = $_POST['id_reto'];
    #echo $sql = "DELETE FROM `elementos_reto` WHERE `reto` = '$id_reto'";
    #$eliminar = $mysqli->query($sql);
    }#echo "<br>";
    $elementos = array();
    if(isset($_POST['palabra'])){
    $_POST['palabra'] = explode(",",$_POST['palabra']);
    if (count($_POST['palabra'])>0){
    foreach ($_POST['palabra'] as $id => $mipalabra){
    $sql = "SELECT * FROM `elementos_juego` WHERE `tipo` ='Palabra' and `nombre_elemento` = '".$mipalabra."'";
    $consulta = $mysqli->query($sql);
    if ($consulta->num_rows>0){
    if ($row=$consulta->fetch_assoc()){
     $palabra  = $row['id_elementos_juego'];
    }
    }
    if ($consulta->num_rows==0){
    $sql = "INSERT INTO `elementos_juego`(`tipo`, `nombre_elemento`) VALUES ('Palabra','".$mipalabra."');";
    $insertar = $mysqli->query($sql);
    $palabra = $mysqli->insert_id;
    }
    #$palabra //guarda la ID
        if ($_POST['correcta'] == $mipalabra)
        $elementos[$palabra] = "Clave";
        else
        $elementos[$palabra] = "Distractor";
    }
    }
    }
    if(isset($_POST['vocal'])){
    $_POST['vocal'] = explode(",",$_POST['vocal']);
    foreach ($_POST['vocal'] as $id => $mivocal){
        $id_vocal = consulta_id_reto('Vocal',$mivocal);
        if ($_POST['correcta'] == $mivocal)
        $elementos[$id_vocal] = "Clave";
        else
        $elementos[$id_vocal] = "Distractor";
    }
    }
    if(isset($_POST['silaba'])){
    $_POST['silaba'] = explode(",",$_POST['silaba']);
    foreach ($_POST['silaba'] as $id => $misilaba){
          $sql = "SELECT * FROM `elementos_juego` WHERE `tipo` ='Silaba' and `nombre_elemento` = '".$misilaba."'";
    $consulta = $mysqli->query($sql);
    if ($consulta->num_rows>0){
    if ($row=$consulta->fetch_assoc()){
      $id_silaba  = $row['id_elementos_juego'];
    }
    }
    if ($consulta->num_rows==0){
    $sql = "INSERT INTO `elementos_juego`(`tipo`, `nombre_elemento`) VALUES ('Silaba','".$misilaba."');";
    $insertar = $mysqli->query($sql);
      $id_silaba = $mysqli->insert_id;
    }

        //$id_silaba = consulta_id_reto('Silaba',$misilaba);
        if ($_POST['correcta'] == $misilaba)
        $elementos[$id_silaba] = "Clave";
        else
        $elementos[$id_silaba] = "Distractor";
    }
    }
    if(isset($_POST['figura'])){
    $_POST['figura'] = explode(",",$_POST['figura']);
    foreach ($_POST['figura'] as $id => $mifigura){
        $id_figura = consulta_id_reto('Figura',$mifigura);
        if ($_POST['correcta'] == $mifigura)
        $elementos[$id_figura] = "Clave";
        else
        $elementos[$id_figura] = "Distractor";
    }
    }
    #printf("<pre>%s</pre>",print_r($elementos,true));
    foreach ($elementos as $elemento_reto => $tipo){
    $sql = "INSERT INTO elementos_reto (`reto`, `elemento_reto`, `tipo`) VALUES ('".$id_reto."', '".$elemento_reto."', '".$tipo."');";
    #echo  $sql;
    $insertar = $mysqli->query($sql);
    }
 /*echo $sql;*/
#if ($insertar = $mysqli->query($sql)) {
}
function consulta_id_reto($tipo,$nombre){
    require("conexion.php");
    $sql = "SELECT `id_elementos_juego` FROM `elementos_juego` WHERE `tipo`='$tipo' and `nombre_elemento` ='$nombre' ";
    #echo $sql;
    $consulta = $mysqli->query($sql);
    if ($row=$consulta->fetch_assoc())
    return $row['id_elementos_juego'];
    else
    return false;
}
function puntos($usuario,$operador="sumar",$cantidad="1"){
    if ($operador=="sumar") $operador = "+";
    elseif ($operador=="restar") $operador = "-";
    else $operador = "";
    require ("conexion.php");
    $sql_puntos = "UPDATE `usuarios` SET `puntos`=`puntos` ".$operador.$cantidad." WHERE `id_usuarios` = '".$usuario."'";
    $consulta_puntos = $mysqli->query($sql_puntos);
    if ($mysqli->affected_rows>0){
    return true;
    }else{
    return false;
    }
}
function insignia_a_usuario($insignia,$usuario){
    require ("conexion.php");
    $sql = "INSERT INTO `secuencias`.`insignias_usuario` (`id_insignia`, `id_usuario`) VALUES ('$insignia','$usuario');";
    $consulta = $mysqli->query($sql);
    if ($mysqli->affected_rows>0){
    return true;
    }else{
    return false;
    }
}
function consultar_puntos($usuario){
	require ("conexion.php");
    $sql = "SELECT puntos FROM `usuarios` WHERE id_usuarios = '".$usuario."' ";
     $consulta = $mysqli->query($sql);
    if ($row = $consulta->fetch_assoc()){
        return $row['puntos'];
    }else{
        return "0";
    }
}
function listado_insignias(){
    require ("conexion.php");
    $sql = "SELECT * FROM `insignia` order by `aciertos` asc";
    $consulta = $mysqli->query($sql);
    $insignias = array();
    while ($row = $consulta->fetch_assoc()){
        $insignias[$row['id_insignia']] = $row['aciertos'];
    }
    return $insignias;
}
function insignias_ganadas($usuario=""){
   @session_start();
   if ($usuario=="") $usuario=$_SESSION['id_usuarios'];
   require ("conexion.php");
 $sql = "SELECT `insignia`.`id_insignia`, `insignia`.`nombre_insignia`, `insignia`.`foto_insignia`, `insignia`.`aciertos`, count(`insignias_usuario`.`id_insignia`) as cantidad_insignias FROM `insignia` left join `insignias_usuario` on `insignia`.`id_insignia` = `insignias_usuario`.`id_insignia` and `insignias_usuario`.`id_usuario` ='".$usuario."' group by `insignia`.`id_insignia` order by aciertos asc";
 $consulta = $mysqli->query($sql);
    while ($row = $consulta->fetch_assoc()){
       ?>
       <li title="<?php echo $row['aciertos']; ?> Aciertos consecutivos" class="insignias_ganadas_menu">
       <a><img width="45px" src="<?php echo $url_raiz ?>img/<?php echo "insignias/".$row['foto_insignia']; ?>"><span class="badge"><?php echo $row['cantidad_insignias']; ?></span></a>
       </li>
       <?php
    }
}
function inicio_reto($reto){
    require ("conexion.php");
    @session_start();
    $sql = "INSERT INTO `secuencias`.`seguimiento_reto` (`reto`, `usuario`, `fecha`, `h_inicio`) VALUES ('".$reto."', '".$_SESSION['id_usuarios']."', '".date("Y-m-d")."', '".date("H:i:s")."');";
    $consulta = $mysqli->query($sql);
    if ($mysqli->affected_rows>0){
    return $mysqli->insert_id;
    }else{
    return false;
    }
}
function fin_reto($insert_id_reto,$aprobado,$marcado){
    require ("conexion.php");
    @session_start();
    $sql ="UPDATE `seguimiento_reto` SET `aprobado`='".$aprobado."', `h_fin`='".date("H:i:s")."',`marcado`='".$marcado."' WHERE `id_seguimiento_reto`='".$insert_id_reto."'";
    $consulta = $mysqli->query($sql);
    if ($mysqli->affected_rows>0){
    return $mysqli->insert_id;
    }else{
    return false;
    }
}
function listado_secuencias($pre=''){
  if ($pre!='') $_POST['secuencia'] = $pre;
     require ("conexion.php");
    @session_start();
    ?>
    <label for="secuencia">Secuencias:</label>&nbsp;
<?php 
$sql2= "SELECT `secuencia`.`id_secuencia`, `secuencia`.`nombre_secuencia` FROM `secuencia` ";
if  ($_SESSION['tipo']=="docente"){
$sql2 .= " WHERE asignacion = '".$_SESSION['id_asignacion']."'";
}
?>
<select class="" name="secuencia" id="secuencia" onchange="if(this.value=='Nueva') {document.getElementById('modal_nueva_secuencia').click();cargar_secuencias('0')}else{cargar_secuencias(this.value);}">
<option value="">Seleccione una opci&oacute;n</option>
<?php
$consulta2 = $mysqli->query($sql2);
$primerasecuencia = true;
while($row2=$consulta2->fetch_assoc()){
echo '<option value="'.$row2['id_secuencia'].'"';
if (isset($_POST['secuencia']) and $row2['nombre_secuencia']==$_POST['secuencia']){
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
<?php
}
function nombre_grupo_asignacion($id_asignacion){
    require ("conexion.php");
    $sql_ac = "SELECT `nombre` FROM `grupo` inner join asignacion on asignacion.grupo = grupo.id_grupo WHERE `asignacion`.`id_asignacion` = '".$id_asignacion."'";
$consulta_ac = $mysqli->query($sql_ac);
if($row_ac=$consulta_ac->fetch_assoc()){
return $row_ac['nombre'];
}else{
return $id_asignacion;
}
}
function seguimientos_retos($id_usuario){
    require ("conexion.php");
    $sql_seguimiento = "SELECT `id_seguimiento_reto`, `reto`, `usuario`, `aprobado`, `fecha`, `h_inicio`, `h_fin`, `marcado` FROM `seguimiento_reto` WHERE `usuario` = '".$id_usuario."'";
    $consulta_seguimiento = $mysqli->query($sql_seguimiento);
    $aprobados = 0;
    $no_aprobados = 0;
    $vacios = 0;
    $total = 0;
    $tiempototal = 0;
    while($row_seguimiento = $consulta_seguimiento->fetch_assoc()){
    $total++;
    if ($row_seguimiento['aprobado']=="SI"){
        $aprobados++;
    }elseif ($row_seguimiento['aprobado']=="NO"){
        $no_aprobados++;
    }elseif ($row_seguimiento['aprobado']==""){
        $vacios++;
    }
        echo "<hr><br>Reto: ".$row_seguimiento['reto'];
        echo "<br>Aprobado: ".$row_seguimiento['aprobado'];//=="SI"
        echo "<br>Fecha: ".$row_seguimiento['fecha'];
        echo "<br>Hora Inicio: ".$row_seguimiento['h_inicio'];
        echo "<br>Hora Fin: ".$row_seguimiento['h_fin'];
        echo "<br>Marcado: ".$row_seguimiento['marcado'];
        
        if ($row_seguimiento['h_inicio'] != "00:00:00" and $row_seguimiento['h_fin'] != "00:00:00"){
        $tiempo = diferencia_hora($row_seguimiento['h_inicio'],$row_seguimiento['h_fin']);
        $tiempototal += $tiempo;
        }else{
        $tiempo = "No se puede determinar";
        }
        echo "<br>Tiempo: ".$tiempo." Segundos";
    }
    echo "<hr>";
    echo "Total: ".$total."<br>";
    echo "Aprobados: ".$aprobados."<br>";
    echo "No Aprobados: ".$no_aprobados."<br>";
    echo "Vacios: ".$vacios."<br>";
    echo "Tiempo total: ".$tiempototal." Segundos, o ".convertir_a_minutos($tiempototal)." Minutos<br><hr>";
}
function diferencia_hora($hora1,$hora2){
$date1 = new DateTime($hora2);
$date2 = new DateTime($hora1);
$diff = $date1->diff($date2);
// 3036 seconds to go [number is variable]
$salida = ( ($diff->days * 24 ) * 60 ) + ( $diff->i * 60 ) + $diff->s;
// passed means if its negative and to go means if its positive
#$salida .=  ' seconds' . ($diff->invert == 1 ) ? ' passed ' : ' to go ';
return $salida;
}
function convertir_a_minutos($min){
    return round($min/60, 2);
}
function secuenciasretos($secuencias_retos){
    require ("conexion.php");
    $nombres_secuencias = array();
    foreach ($secuencias_retos as $secuencias_reto){
    $sql = "SELECT * FROM `reto` inner join `secuencia` on `secuencia`.`id_secuencia` = `reto`.`id_secuencia` WHERE `id_reto` = '".$secuencias_reto."'";
    $consulta = $mysqli->query($sql);
        while($row = $consulta->fetch_assoc()){
            $nombres_secuencias[$row['id_secuencia']] = $row['nombre_secuencia'];
        }
    }
    foreach ($nombres_secuencias as $id_secuencias_reto => $nombre_secuencia){
        echo $nombre_secuencia."<BR>";
    }
}
function secuenciasretos_array($secuencias_retos){
    require ("conexion.php");
    $nombres_secuencias = array();
    foreach ($secuencias_retos as $secuencias_reto){
    $sql = "SELECT * FROM `reto` inner join `secuencia` on `secuencia`.`id_secuencia` = `reto`.`id_secuencia` WHERE `id_reto` = '".$secuencias_reto."'";
    $consulta = $mysqli->query($sql);
        while($row = $consulta->fetch_assoc()){
            $nombres_secuencias[$row['id_secuencia']] = $row['nombre_secuencia'];
        }
    }
    return $nombres_secuencias;
}
function elegir_secuencia(){
  //SELECT `secuencia`.`id_secuencia`, `secuencia`.`nombre_secuencia`, ROUND(AVG(`reto`.`dificultad`)) FROM `secuencia` inner join `reto` on `secuencia`.`id_secuencia`= `reto`.`id_secuencia` GROUP BY ( `secuencia`.`id_secuencia`)
}
function encriptar_clave($clave){
$key = 123;//SOLO MODIFICAR EN LA INSTALACIPON INICIAL, DESPUES NO MODIFICAR NUNCA
return sha1($clave.$key);
}
function adjunto_imagenes(){
require ("conexion.php");
$array_adjunto_imagenes = explode(",",$adjunto_imagenes);
return $array_adjunto_imagenes;
}

function resultados_graficar_tabla($array,$datos,$orden="",$intervalo = 0,$grafica=true,$tabla=true){
//se usa en reportes
    $datos_a= explode(",",$datos);
    $orden_a= explode(",",$orden);
    
    $array2=array();
         foreach ($array as $i => $valor){
            foreach ($valor as $j => $dato){
                    $var_u = $valor[$datos_a[0]].$valor[$datos_a[1]];
                    @$$var_u++;
                    $array2[$valor[$datos_a[0]]][$valor[$datos_a[1]]]=array("Marca"=>$valor[$datos_a[1]],"Intervalo"=>"","FA"=>$$var_u/count($valor));
            }
   }
             
$i=0;
if($orden!=""){
    #echo $orden."<br>";
$ordenado = array();
foreach ($array2 as $nombre => $array3){
foreach ($orden_a as $i => $val){
foreach ($array3 as $id2 => $valor2){
    if ($valor2['Marca']==$val){
        $ordenado[$nombre][$id2]=$valor2;
    }
    }
    
}
}
$array2 = $ordenado;
}//fin if($orden!="")
//imprimir tabla de frecuencias
foreach ($array2 as $nombre => $array3){
$i++;
$faa = 0;
$faat = 0;
$salidas=array();
foreach ($array3 as $id2 => $valor2){
  $faat += $valor2["FA"];
  //organizar salida para grafica
  $salidas[] = '{ "cualitativo":" '.$valor2["Marca"].'", "cuantitativo":"'.$valor2["FA"].'" }';
}
if ($tabla){
?>
<h1>Tabla de Frecuencias para <?php echo $nombre ?></h1>
<table border="1">
    <thead>
        <tr>
        <th><?php echo $datos_a[1] ?></th>
        <?php if ($intervalo != 0){ ?>
        <th>Intervalo de Clase Rango</th>
        <?php } ?>
        <th>Frecuencia Absoluta</th>
        <th>Frecuencia Absoluta Acumulada</th>
        <th>Frecuencia Relativa</th>
        <th>Frecuencia Relativa Acumulada</th>
        <th>Frecuencia Relativa %</th>
        <th>Frecuencia Relativa Acumulada %</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_datos=0;
             foreach ($array3 as $id2 => $valor2){
             ?><tr>
                    <td><?php echo $valor2["Marca"] ?></td>
                    <?php if ($intervalo != 0){ ?>
                    <td><?php echo $valor2["Intervalo"] ?></td>
                    <?php } ?>
                    <td><?php echo $valor2["FA"] ?></td>
                    <td><?php $faa += $valor2["FA"]; echo $faa ?></td>
                    <td><?php echo round($valor2["FA"]/$faat,2) ?></td>
                    <td><?php echo round($faa/$faat,2) ?></td>
                    <td><?php echo round((($valor2["FA"]/$faat)*100),2) ?>%</td>
                    <td><?php echo round((($faa/$faat)*100),2) ?>%</td>
              </tr><?php
            $total_datos++;
             }
            //$array2
            #$array2[$var_u]=$$var_u;
        #$array2;
    ?>
    </tbody>
</table>
    <?php
}
if ($grafica){
$datos_grafica = implode(",",$salidas);
$div = $nombre.$i;
#echo $total_datos;
?>
<script>
var datos<?php echo $div ?> = {
      "elementos": [<?php echo $datos_grafica ?>]} ;
google.setOnLoadCallback(function() {
Graficar(titulo="Grafica de <?php echo $nombre ?>",cualitativa="Opcíón",cuantitativa="<?php echo $datos_a[1]?>",contenedor="div<?php echo $div ?>",tipo_grafica="<?php if ($total_datos<=5) echo "PieChart"; else echo "ColumnChart"; ?>",ancho="700px",alto="200px",datos<?php echo $div ?>);
});
</script>
<div id="div<?php echo $div ?>" style="width: 500px; height: 300px;"></div>
<?php
}
}
}
//estadisticas
function consultar_datos($consulta,$mysqli_assoc=true){
require ("conexion.php");
if ($gconsulta_red = $mysqli->prepare($consulta)){
$gconsulta_red = $mysqli->prepare($consulta);
$gconsulta_red->execute();
$arraydedatos = $gconsulta_red->get_result();
if($mysqli_assoc){
$datos = $arraydedatos->fetch_all(MYSQLI_ASSOC);
}else{
$datos = $arraydedatos->fetch_all();
}
return $datos;
}
}
function boton_modal_nuevo_icono(){
    ?>
    <button id="btn_nuevo_foro" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal_nuevo">Nuevo Icono</button>
    <?php
}
function ventana_modal_nuevo_icono($atributos){
    ?>
    <!-- Modal -->
<div id="myModal_nuevo" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Nuevo Icono</h4>
      </div>
      <div class="modal-body">
        <form <?php echo $atributos ?> ENCTYPE="multipart/form-data">
              <div class="form-group">
                <label for="icono">Nombre</label>
                <input type="text" name="icono" id="icono" class="form-control" placeholder="Nombre del icono">
            </div>
            <div class="form-group">
                <label for="archivo">Archivo</label>
                <input type="file" multiple name="archivo" id="archivo" class="form-control" placeholder="Titulo del Foro">
            </div>
            <div class="form-group">
                <button  type="submit" name="titulo_foro" id="titulo_foro" class="btn btn-success">Guardar</button>
            </div>
            </form>
      </div>
      <div class="modal-footer">
        <button id="cerrar_modal_nuevo_icono" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>
<!---->
    <?php
}
function boton_modal_elegir_icono($destino=""){
    ?>
    <button id="btn_elegir_icono" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal2_elegiricono<?php echo $destino ?>" onmouseup="parent.buscar_iconos('','<?php echo $destino; ?>');">Elegir Figura</button>
    <?php
}
function ventana_modal_elegir_icono($destino=""){
    ?>
    <!-- Modal -->
<div id="myModal2_elegiricono<?php echo $destino ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Elegir una Figura</h4>
      </div>
      <div class="modal-body">
        <input name="contexto" type="hidden" value="general">
            <div class="form-group">
                <?php #boton_modal_nuevo_icono($destino); ?>
            </div>
            <div class="form-group">
                <label for="buscar_iconos">Buscar Figura</label>
                <input type="text" name="buscar_iconos" id="buscar_iconos" class="form-control" placeholder="Escriba aqui para buscar" value="" onkeyup ="parent.buscar_iconos(this.value,'<?php echo $destino?>');" onchange="parent.buscar_iconos(this.value,'<?php echo $destino?>');"  >
            </div>
        <div class="form-group">
            <span id="txtresultadosicono<?php echo $destino ?>">
            </span>
        </div>
      </div>
      <div class="modal-footer">
        <button id="cerrar_modal_elegir_icono<?php echo $destino ?>" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>
<!---->
    <?php
}

function buscar_iconos($datos="",$reporte="",$destino=""){
require(dirname(__FILE__)."/conexion.php");
require_once (dirname(__FILE__)."/../lib/Zebra_Pagination/Zebra_Pagination.php");
$resultados = ((isset($_COOKIE['numeroresultados_iconos']) and $_COOKIE['numeroresultados_iconos']!= ""  and $_COOKIE['numeroresultados_iconos']!= 0 ) ? $_COOKIE['numeroresultados_iconos'] : 10);
$paginacion = new Zebra_Pagination();
$paginacion->records_per_page($resultados);
$paginacion->records_per_page($resultados);
$funcionjs="buscar_iconos('','".$destino."');";$paginacion->fn_js_page("$funcionjs");
$paginacion->cookie_page("page_iconos");
$paginacion->padding(false);
if (isset($_COOKIE["page_iconos"]))
$_GET['page'] = $_COOKIE["page_iconos"];
else
$_GET['page'] = 1;
$sql = "SELECT id_elementos_juego,nombre_elemento,archivo FROM elementos_juego where tipo = 'Figura' ";
#$sql = "SELECT `iconos`.`id_elementos_juego`, `iconos`.`icono`, `iconos`.`archivo` FROM `iconos`   ";
$datosrecibidos = $datos;
$datos = explode(" ",$datosrecibidos);
$datos[]="";
$cont =  0;
$sql .= ' and ';
foreach ($datos as $id => $dato){
$sql .= ' concat(LOWER(`elementos_juego`.`nombre_elemento`)," ",LOWER(`elementos_juego`.`archivo`)," "   ) LIKE "%'.mb_strtolower($dato, 'UTF-8').'%"';
$cont ++;
if (count($datos)>1 and count($datos)<>$cont){
$sql .= " and ";
}
}
$sql .=  " ORDER BY ";
if (isset($_COOKIE['orderbyiconos']) and $_COOKIE['orderbyiconos']!=""){ $sql .= "`elementos_juego`.`".$_COOKIE['orderbyiconos']."`";
}else{ $sql .= "`elementos_juego`.`id_elementos_juego`";}
if (isset($_COOKIE['orderad_iconos'])){
$orderadiconos = $_COOKIE['orderad_iconos'];
$sql .=  " $orderadiconos ";
}else{
$sql .=  " desc ";
}
$consulta_total_iconos = $mysqli->query($sql);
$total_iconos = $consulta_total_iconos->num_rows;
$paginacion->records($total_iconos);
if (isset($_COOKIE["page_iconos"]))
$sql .=  " LIMIT " . (($paginacion->get_page() - 1) * $resultados) . ", " . $resultados;
#echo $sql; 
$consulta = $mysqli->query($sql);
$numero_iconos = $consulta->num_rows;
$minimo_iconos = (($paginacion->get_page() - 1) * $resultados)+1;
$maximo_iconos = (($paginacion->get_page() - 1) * $resultados) + $resultados;
if ($maximo_iconos>$numero_iconos) $maximo_iconos=$numero_iconos;
$maximo_iconos += $minimo_iconos-1;
echo "<p>Resultados de $minimo_iconos a $maximo_iconos del total de ".$total_iconos." en página ".$paginacion->get_page()."</p>";
 ?>
<div class="css_table" align="center">
<div border="1" id="tbiconos">
<div vlass="css_thead">
<span class="css_tr">
</span>
</div>
<div class="css_tbody">
<ul class="bs-glyphicons">
<?php 
while($row=$consulta->fetch_assoc()){
 ?>
<li id="icono_<?php echo $row['id_elementos_juego']?>" class="icono_a_seleccionar" onclick="document.getElementById('icono_seleccionado<?php echo $destino ?>').value = '<?php echo $row['id_elementos_juego']?>';document.getElementById('icono_seleccionado_img<?php echo $destino ?>').src='<?php echo $url_raiz ?>/img/figuras/<?php echo $row['archivo']; ?>';document.getElementById('icono_seleccionado<?php echo $destino ?>').setAttribute('data-url','<?php echo $url_raiz ?>/img/figuras/<?php echo $row['archivo']; ?>');cuadre('<?php echo $destino ?>');document.getElementById('cerrar_modal_elegir_icono<?php echo $destino ?>').click();" data-label='Imagen icono'>
  <?php if ($reporte==""){ ?>
<!--span data-label="Modificar">
<form style="float:left;position:relative;margin-bottom:-10px" id="formModificar" name="formModificar" method="post" action="<?php echo $url_raiz ?>/iconos.php" ENCTYPE="multipart/form-data">
<input name="cod" type="hidden" id="cod" value="<?php echo $row['id_elementos_juego']?>">
<input type="image" name="submit" src="<?php echo $url_raiz ?>/img/modificar.png" height="20px" value="Modificar">
</form>
</span-->
<!--span style="float:right;position:relative;margin-bottom:-10px" data-label="Eliminar">
<input type="image" src="<?php echo $url_raiz ?>/img/eliminar.png" height="20px" onClick="confirmeliminar2('<?php echo $url_raiz ?>/iconos.php',{'del':'<?php echo $row['id_elementos_juego'];?>'},'<?php echo $row['nombre_elemento'];?>');" value="Eliminar">
</span-->
<?php } ?>
 <img width="50px" src="<?php echo $url_raiz ?>/img/figuras/<?php echo $row['archivo']; ?>"></img>
 <?php #echo $row['archivo']?><br>
 <span data-label='nombre_elemento'><?php echo $row['nombre_elemento']?></span>
 </li>
<?php 
}/*fin while*/
 ?>
</ul>
</div>
</div>
<?php $paginacion->render2();?>
</div>
<?php 
}/*fin function buscar*/
?>