<script>
function nuevoAjax(){
var xmlhttp=false;
try {
htmlhttp=new activeXObject("Msxml2.XMLHTTP");
}
catch (e) {
 try {htmlhttp=new activeXObject("Microsoft.XMLHTTP");
}
catch (e) {
xhtmlhttp=false;
}
}
if (!xmlhttp && typeof XMLHttpRequest!='undefineded'){
xmlhttp=new XMLHttpRequest();
}
return xmlhttp;
}
function obtener(url,destino){
ajax=nuevoAjax();
ajax.open("GET",url,true);
ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		document.getElementById(destino).src = ajax.responseText;
		}
	}
ajax.send();
}
</script>
<script src="https://code.responsivevoice.org/responsivevoice.js"></script>
<button type="button" id="play">Play</button>
<a download id="download">Descargar</a>
Texto: <input id="texto" value="Muy Bien!" /><br/>
<textarea id="textarea" cols="60" rows="10"></textarea>
<iframe id="iframe" src=""></iframe>
<button type="button" id="obtener">Obtener</button>
<script>
var texto = document.getElementById('texto');
var play = document.getElementById('play');
var obtener = document.getElementById('obtener');
var download = document.getElementById('download');
var textarea = document.getElementById('textarea');
var iframe = document.getElementById('iframe');
obtener.onclick = function() {
    textarea.value = window.btoa(iframe.firstChild.src);
}
play.onclick = function() {
  responsiveVoice.speak(texto.value, "Spanish Latin American Female", {pitch: 1,rate: 1});
}
texto.onblur = function () {
  var url = '//responsivevoice.org/responsivevoice/getvoice.php?t=' + 
      encodeURIComponent(texto.value) + '&tl=es-co';
  download.href = url;
  iframe.src=url;
}
texto.onblur();

function hablar(texto){
	responsiveVoice.speak(texto, "Spanish Latin American Female", {pitch: 1,rate: 1});
}
    var audio = new Audio();
    audio.src = "data:audio/wav;base64,<?php echo base64_encode(file_get_contents(dirname(__FILE__)."/audio/arpa1.wav")); ?>";
    //setTimeout(function(){ hablar('Muy bien!'); }, 50);
    audio.play();
</script>
<?php
exit();
?>
<style>
        .lienzo{
        width:304px !important;
        height:304px !important;
        padding:5px;
        background-color: rgba(0,0,0,.03);
    }
    .lienzo2{
        font-family: 'Comic Sans MS',cursive,sans-serif;
        font-size: 10px;
        width:310px !important;
        height:310px !important;
        padding:5px;
        background-color: transparent;
        margin: 0 auto;
        position: relative;


    }
    #secuencias{
        text-align:left;
        height:180px !important;
        overflow-x:none;
        white-space:nowrap;
        margin-bottom:5px;
    }
    #secuencias2{
        text-align:left;
        height:150px !important;
        overflow-x:none;
        white-space:normal;
        margin-bottom:5px;
    }
    .elemento{
        display:inline-block;
        float:left;
        width: 146px !important;
        height:146px !important;
        background-color: transparent;
        margin-left:1px;
        margin-right:1px;
    }
    .elementoj{
        display:inline-block;
        float:left;
        width: 146px !important;
        height:146px !important;
        background-color: #EEE;
        margin-left:1px;
        margin-right:1px;
        font-size: 35px;
    }
    #elementos{
        position:absolute;
        width:300px !important;
        text-align:center;
    }
    #elementos3{
        position:absolute;
        width:310px !important;
        text-align:center;
        white-space: normal;
    }
    .secuencia{
        width:160px !important;
        height:170px !important;
        display:inline-block;
        margin: 0 10px;
        background-color: #DDD;
    }
    .secuencia2{
        margin: 0 10px;
        width:150px !important;
        height:150px !important;
        position:absolute;
        display:inline;
    }
    .elemento2{
    width: 74px !important;
    height: 74px !important;
    float:left;
    text-align:center;
    }
    
    .col-md-12{
        width:100% !important;
        overflow-x:auto;
        margin-bottom:50px;
    }
    body{
        overflow-x:none;
        font-family: "Comic Sans MS",cursive,sans-serif;
    }
    .areaselementos{
    position:relative;
    margin-top: -6px;
    margin-left: 2px;
    }
    .btn_elim{
    position:absolute;
    text-decoration:none;
    top:0;
    right:0;
    text-align:right;
    margin-right:5px;
    color:red;
    font-weight:bold;
    font-size:25px;
    }
.areaselementos input, .radiojuego { /* HIDE RADIO */
  visibility: hidden; /* Makes input not-clickable */
  position: absolute; /* Remove input from document flow */
}
.areaselementos  input + .fig, .radiojuego + .elementosj{ /* IMAGE STYLES */
    position:absolute;
    top:0;
    right:0;
    width:150px !important;
    height:150px !important;
    border:2px solid rgba(100,100,100,.2);
    cursor:pointer;
}
.borde_rojo {
    border: 2px solid red;
}
 input:checked + .fig, .radiojuego:checked  + .elementosj{ /* (RADIO CHECKED) IMAGE STYLES */
  border:2px solid #f00;
  cursor:pointer;
}
.fig{
    color:#000;
    font-size: 35px;
    
}
.areaselementos span{
    padding-top: 25px;
}


</style>
<?php

@session_start();
if(!isset($_COOKIE['id_usuarios'])){
    header("Location:login.php");
    exit();
}
require_once(dirname(__FILE__)."/../config/conexion.php");
require_once(dirname(__FILE__)."/../config/funciones.php");
if (isset($_COOKIE['total_retos'])){
 $actual_retos = count($_COOKIE['retos']);
        if ($_COOKIE['total_retos']!=0)
        $pocentaje = 100-($actual_retos*100/$_COOKIE['total_retos']);
        $pocentaje = round($pocentaje);
        $_COOKIE['pocentaje'] = $pocentaje;
}
$tiempoparacontinuar="2000";//milisegundos
$tiempodepermanencia= 10 * 60 * 1000;//munitos
if (isset($_GET['reset'])){
    echo "reset";
    unset ($_COOKIE['retos']);
    unset ($_COOKIE['aciertos']);
    unset ($_COOKIE['intentos']);
    unset ($_COOKIE['fallidos']);
    unset($_COOKIE['total_retos']);
    header ("Location: play.php");
    exit();
}

//crear variables
if (!isset($_COOKIE['actual'])) $_COOKIE['actual']= 0;
if (!isset($_COOKIE['aciertos'] )) $_COOKIE['aciertos'] = 0;
if (!isset($_COOKIE['fallidos' ])) $_COOKIE['fallidos'] = 0;
if (!isset($_COOKIE['intentos'])) $_COOKIE['intentos'] = 0;
if (!isset($_COOKIE['clave'])) $_COOKIE['clave']= "";
if (!isset($_COOKIE['retos2'])) $_COOKIE['retos2'] = array();
echo '<center>';

if (isset($_POST) and !empty($_POST)){
#printf("<pre>%s</pre>",print_r($_POST,true));
#printf("<pre>%s</pre>",print_r($_COOKIE,true));
}
$_COOKIE['start'] = time(); // Taking now logged in time.
            // Ending a session in 30 minutes from the starting time.
$_COOKIE['expire'] = $_COOKIE['start'] + ($tiempodepermanencia);
   $now = time(); // Checking the time now when home page starts.

if ($now > $_COOKIE['expire']) {
$_COOKIE['pocentaje'] = 0;
        $pocentaje = 0;
?>
<script>
setTimeout(function(){ location.href="login.php"; }, 0);
</script>
<?php
}
 ?>
<script>
setTimeout(function(){ location.href="login.php"; }, <?php echo $tiempodepermanencia ?>);
</script>
<center>
<h1>Jugar</h1>
</center>
<?php
function retos(){
?>
<script>
setTimeout(function(){ hablar('Comienza el Juego'); }, 500);
</script>
<?php
require ("conexion.php");
$retos = array();
$sql1 = "SELECT `id_reto`, `nombre_reto`, `dificultad`, `estado` FROM `reto` WHERE estado = 'Publicado' order by `dificultad` desc";
if ($consulta1 = $mysqli->query($sql1))
while($row1=$consulta1->fetch_assoc()){
$retos[$row1['id_reto']] = array('id_reto'=>$row1['id_reto'],"nombre_reto"=>$row1['nombre_reto'],"dificultad"=>$row1['dificultad'],"estado"=>$row1['estado']);
$sql2 = "SELECT `elementos_reto`.`id_elementos_reto`, `elementos_reto`.`elemento_reto`, `elementos_reto`.`tipo`, `elementos_juego`.`tipo` as tipo_e_juego, `elementos_juego`.`nombre_elemento`, `elementos_juego`.`archivo` FROM `elementos_reto` left join `elementos_juego` on `elementos_reto`.`elemento_reto` = `elementos_juego`.`id_elementos_juego` WHERE `elementos_reto`.`reto` = '".$row1['id_reto']."';";
$consulta2 = $mysqli->query($sql2);
while($row2=$consulta2->fetch_assoc()){
$retos[$row1['id_reto']]['elementos'][$row2['id_elementos_reto']]= array("elemento_reto"=>$row2['elemento_reto'],"tipo"=>$row2['tipo'],"tipo_e_juego"=>$row2['tipo_e_juego'],"nombre_elemento"=>$row2['nombre_elemento'],"archivo"=>$row2['archivo']);
if ($row2['tipo']=="Clave")
$retos[$row1['id_reto']]['clave']= $row2['id_elementos_reto'];
}
$_COOKIE['retos'] = $retos;
$_COOKIE['total_retos']=count($retos);
}//if isset $_COOKIE['retos']
}//fin function

#unset($_COOKIE['retos']);
if (!isset($_COOKIE['retos'])){
retos();
}//consulta 1ss-striped">
$pocentaje = $_COOKIE['pocentaje'];
?>
<div class="progress progress-striped">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $pocentaje; ?>" aria-valuemin="0" aria-valuemax="100"
       style="width: <?php echo $pocentaje; ?>%">
    <span class="sr-only"><?php echo $pocentaje; ?>% completado (éxito)</span>
  </div>
</div>
<form name="form" id="form" method="post" action="play.php">
    <div id="secuencias2">
    <?php
    /*
    <div id="secuencias">
    <div class="secuencia">1</div>
    <div class="secuencia">1</div>
    <div class="secuencia">1</div>
    </div>
    */
if (isset($_POST['actual'],$_COOKIE['clave'])){
    if ($_POST['actual'] == $_COOKIE['clave']){
        $_COOKIE['aciertos']++;
        $_COOKIE['intentos']++;
       if (count($_COOKIE['retos'])>0){
        $_COOKIE['retos2'][] = end($_COOKIE['retos']);
        array_pop($_COOKIE['retos']);
        }
         ?>
        <script>
        var audio = new Audio('audio/arpa1.wav');
        setTimeout(function(){ hablar('Muy bien!'); }, 50);
        audio.play();
        </script>
        <?php
    }else{
        $_COOKIE['fallidos']++;
        $_COOKIE['intentos']++;
        ?>
        <script>
        setTimeout(function(){ hablar('Inténtalo de nuevo'); }, 500);
        </script>
        <?php
        if($_COOKIE['fallidos'] % 2 == 0){
            unset ($_COOKIE['retos']);
            unset($_COOKIE['retos2']);
            retos();
        }
    #if (count($_COOKIE['retos2'])>0) $_COOKIE['retos'][] = array_pop($_COOKIE['retos2']);
    }
    ?>
    <meta http-equiv="refresh" content="3; url=play.php" />
        <?php
        exit();
}
if (count($_COOKIE['retos'])==0){
    echo "<center><strong>Fin</strong></center>";
?>
<script>
    setTimeout(function(){ hablar('Juego Terminado'); }, 500);
</script>
<?php
}

$_COOKIE['actual'] = end($_COOKIE['retos'])['id_reto'];
$actual = $_COOKIE['actual'];
$retos2 = array();
$sql1 = "SELECT `id_reto`, `nombre_reto`, `dificultad`, `estado` FROM `reto` WHERE estado = 'Publicado' and `id_reto` = '".$actual."' order by `id_reto` desc";
$consulta1 = $mysqli->query($sql1);
while($row1=$consulta1->fetch_assoc()){
$retos2[$row1['id_reto']] = array('id_reto'=>$row1['id_reto'],"nombre_reto"=>$row1['nombre_reto'],"dificultad"=>$row1['dificultad'],"estado"=>$row1['estado']);
$sql2 = "SELECT `elementos_reto`.`id_elementos_reto`, `elementos_reto`.`elemento_reto`, `elementos_reto`.`tipo`, `elementos_juego`.`tipo` as tipo_e_juego, `elementos_juego`.`nombre_elemento`, `elementos_juego`.`archivo` FROM `elementos_reto` left join `elementos_juego` on `elementos_reto`.`elemento_reto` = `elementos_juego`.`id_elementos_juego` WHERE `elementos_reto`.`reto` = '".$actual."';";
$consulta2 = $mysqli->query($sql2);
while($row2=$consulta2->fetch_assoc()){
$retos2[$row1['id_reto']]['elementos'][$row2['id_elementos_reto']]= array("elemento_reto"=>$row2['elemento_reto'],"tipo"=>$row2['tipo'],"tipo_e_juego"=>$row2['tipo_e_juego'],"nombre_elemento"=>$row2['nombre_elemento'],"archivo"=>$row2['archivo']);
}
}
    echo "Aciertos: ".$_COOKIE['aciertos']."<br>";
    echo "Intentos: ".$_COOKIE['intentos']."<br>";
    echo "Fallidos: ".$_COOKIE['fallidos']."<br>";
    echo "Total: ".$_COOKIE['total_retos']."<br>";
    #print_r($retos2);
    foreach($retos2 as $id_reto => $reto){
    $hablar = "¿Donde está la ";
    shuffle_assoc($reto['elementos']);//barjar elementos
    ?>
    <div class="lienzo2">

        <div class="elementos3" title="#<?php echo $reto['nombre_reto']; ?>
        Dif: <?php echo $reto['dificultad']; ?> - <?php echo $reto['estado']; ?>">
        <span style="background-color:#FFF;">
        </span>
        <br>
        <?php foreach($reto['elementos'] as $id_ele_reto => $ele_reto){ ?>
        <?php #echo  "Tipo: ".$ele_reto['tipo']; ?>
        <?php 
        if ($ele_reto['tipo']=="Clave"){
             $hablar .= $ele_reto['tipo_e_juego'].",";
             $hablar .= $ele_reto['nombre_elemento'];
             $_COOKIE['clave'] = $id_ele_reto;
            }
        ?>
        <label>
            <script>
            var audio2 = new Audio('audio/click1.mp3');
            </script>
        <input class="radiojuego" hidden type="radio" value="<?php echo $id_ele_reto ?>" name="actual">
        <?php
        if ($ele_reto['tipo_e_juego']=="Figura"){
        echo  '<span class="elementoj fig" onclick="audio2.play();setTimeout(function(){document.getElementById(\'submit\').click();}, '.$tiempoparacontinuar.')"><img src="figuras/'.$ele_reto['nombre_elemento'].'.png" width="120px"></span>';
        }else{
        echo  '<span class="elementoj fig" onclick="audio2.play();setTimeout(function(){document.getElementById(\'submit\').click();}, '.$tiempoparacontinuar.')">'.$ele_reto['nombre_elemento']."</span>";
        }
        ?>
        </label>
        <?php #echo  "Archivo:".$ele_reto['archivo']; ?>
        <?php } 
        $hablar .= "?";
        ?>
        
        <script>
        setTimeout(function(){ hablar('<?php echo $hablar ?>'); }, 3000);
        </script>
        <?php
        #printf("<pre>%s</pre>",print_r($reto,true));
        ?>

    </div>
</div>

    <?php
    }
    #printf("<pre>%s</pre>",print_r($_COOKIE['retos'],true));
    ?>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <input type="button" onclick="hablar('<?php echo $hablar ?>');" value="Repetir Audio">
    <br>
    <?php
    #echo "Clave: ".$_COOKIE['clave'];
    ?>
     <p><input type="submit" id="submit" value="Continuar"></p>
        </form>
</div>
        <a href="?reset">Reiniciar</a>
<?php

 ?>
