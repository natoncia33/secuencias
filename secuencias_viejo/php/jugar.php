<?php
//SELECT `secuencia`.`id_secuencia`, `secuencia`.`nombre_secuencia`, ROUND(AVG(`reto`.`dificultad`)) FROM `secuencia` inner join `reto` on `secuencia`.`id_secuencia`= `reto`.`id_secuencia` GROUP BY ( `secuencia`.`id_secuencia`)
ob_start();
@session_start();
if(!isset($_SESSION['id_usuarios'])){
    header("Location:login.php");
    exit();
}
require(dirname(__FILE__)."/../config/conexion.php");
require_once(dirname(__FILE__)."/../config/funciones.php");
$sql_seguimiento = "SELECT `id_seguimiento_reto`, `reto`, `usuario`, `aprobado`, `fecha`, `h_inicio`, `h_fin`, `marcado` FROM `seguimiento_reto` WHERE `usuario` = '".$_SESSION['id_usuarios']."'";
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
if (isset($_GET['reset'])){
    echo "reset";
    unset ($_SESSION['retos']);
    unset ($_SESSION['aciertos']);
    unset ($_SESSION['intentos']);
    unset ($_SESSION['fallidos']);
    unset ($_SESSION['consecutivos']);
    unset($_COOKIE['total_retos']);
    unset($_SESSION['total_retos']);
    unset($_COOKIE['secuencia_actual']);
    setcookie("secuencia_actual", "", time()-3600);
    header ("Location: jugar.php");
    exit();
}
?>
<div class="row">
    <div class="col-md-8">
<?php
if (!isset($_COOKIE['secuencia_actual'])){
echo "Elegir Secuencia";
elegir_secuencia();
}else{
if (isset($_SESSION['total_retos'])){
 $actual_retos = count($_SESSION['retos']);
        if ($_SESSION['total_retos']!=0)
        $pocentaje = 100-($actual_retos*100/$_SESSION['total_retos']);
        $pocentaje = round($pocentaje);
        $_SESSION['pocentaje'] = $pocentaje;
    }
$tiempoparacontinuar="500";//milisegundos
$tiempodepermanencia= 10 * 60 * 1000;//munitos


//crear variables
if (!isset($_SESSION['actual'])) $_SESSION['actual']= 0;
if (!isset($_SESSION['consecutivos'])) $_SESSION['consecutivos']= 0;
if (!isset($_SESSION['aciertos'] )) $_SESSION['aciertos'] = 0;
if (!isset($_SESSION['fallidos' ])) $_SESSION['fallidos'] = 0;
if (!isset($_SESSION['intentos'])) $_SESSION['intentos'] = 0;
if (!isset($_SESSION['total_retos'])) $_SESSION['total_retos'] = 0;
if (!isset($_SESSION['clave'])) $_SESSION['clave']= "";
if (!isset($_SESSION['retos2'])) $_SESSION['retos2'] = array();
echo '<center>';

if (isset($_POST) and !empty($_POST)){
#printf("<pre>%s</pre>",print_r($_POST,true));
#printf("<pre>%s</pre>",print_r($_SESSION,true));
}
 $_SESSION['start'] = time(); // Taking now logged in time.
            // Ending a session in 30 minutes from the starting time.
$_SESSION['expire'] = $_SESSION['start'] + ($tiempodepermanencia);
   $now = time(); // Checking the time now when home page starts.

if ($now > $_SESSION['expire']) {
$_SESSION['pocentaje'] = 0;
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
#$sql_secuencias = "SELECT * FROM `secuencia` WHERE `asignacion` = (SELECT id_asignacion FROM `asignacion` inner join `grupo` on `asignacion`.`grupo` = `grupo`.`id_grupo` inner join `matricula` on `matricula`.`grupo` = `grupo`.`id_grupo` WHERE `matricula`.`anio` = '2017' and `matricula`.`estudiante` = '".$_COOKIE['secuencia_actual']."')";
function retos(){
require(dirname(__FILE__)."/../config/conexion.php");
?>
<script>
setTimeout(function(){ hablar('Comienza el Juego'); }, 500);
</script>
<?php
$retos = array();
$sql1 = "SELECT `id_reto`, `nombre_reto`, `dificultad`, `estado` FROM `reto` WHERE estado = 'Publicado' and id_secuencia='".$_COOKIE['secuencia_actual']."' order by `dificultad` desc";
#$sql1 = "SELECT `id_reto`, `nombre_reto`, `dificultad`, `estado` FROM `reto` WHERE estado = 'Publicado'  order by `dificultad` desc";
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
$_SESSION['retos'] = $retos;
$_SESSION['total_retos']=count($retos);
}//if isset $_SESSION['retos']
}//fin function

#unset($_SESSION['retos']);
if (!isset($_SESSION['retos'])){
retos();
}//consulta 1ss-striped">
$pocentaje = $_SESSION['pocentaje'];
?>
<div class="progress progress-striped">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $pocentaje; ?>" aria-valuemin="0" aria-valuemax="100"
       style="width: <?php echo $pocentaje; ?>%">
    <span class="sr-only"><?php echo $pocentaje; ?>% completado (éxito)</span>
  </div>
</div>
    <form name="form" id="form" method="post" action="jugar.php">
    <div id="secuencias2">
    <?php
    /*
    <div id="secuencias">
    <div class="secuencia">1</div>
    <div class="secuencia">1</div>
    <div class="secuencia">1</div>
    </div>
    */
if (isset($_POST['actual'],$_SESSION['clave'])){
    if ($_POST['actual'] == $_SESSION['clave']){
        $_SESSION['aciertos']++;
        $_SESSION['intentos']++;
        $_SESSION['consecutivos']++;
        puntos($_SESSION['id_usuarios'],"sumar","1");
        fin_reto($_SESSION['id_seguimiento_actual'],"SI",$_POST['actual']);
       if (count($_SESSION['retos'])>0){
        $_SESSION['retos2'][] = end($_SESSION['retos']);
        array_pop($_SESSION['retos']);
        }
         ?>
        <script>
        var audio = new Audio('audio/arpa1.wav');
        setTimeout(function(){ hablar('Muy bien!'); alert2('Muy bien!');  }, 50);
        audio.play();
        </script>
        <?php
        $insignias = listado_insignias();
        //print_r($insignias);
        //Array( [2] => 3 [1] => 4 [3] => 6 )
        foreach ($insignias as $id_insignia => $aciertos){
            if ($_SESSION['consecutivos']==$aciertos){
            insignia_a_usuario($id_insignia,$_SESSION['id_usuarios']);
            ?>
            <script>
            setTimeout(function(){ hablar('Ganaste una insignia!'); alert2('Ganaste una insignia!'); }, 50);
            </script>
            <?php
            }
        }
    }else{
        puntos($_SESSION['id_usuarios'],"restar","1");
        fin_reto($_SESSION['id_seguimiento_actual'],"NO",$_POST['actual']);
        $_SESSION['fallidos']++;
        $_SESSION['intentos']++;
        $_SESSION['consecutivos']=0;
        ?>
        <script>
        setTimeout(function(){ hablar('Inténtalo de nuevo'); alert2('Inténtalo de nuevo','warning'); }, 500);
        </script>
        <?php
        if($_SESSION['fallidos'] % 2 == 0){
            unset ($_SESSION['retos']);
            unset($_SESSION['retos2']);
            retos();
        }
    #if (count($_SESSION['retos2'])>0) $_SESSION['retos'][] = array_pop($_SESSION['retos2']);
    }
    ?>
    <meta http-equiv="refresh" content="3; url=jugar.php" />
        <?php
        $contenido = ob_get_contents();
        ob_clean();
        include ("../plantilla/jugadores.php");
        exit();
}
if (count($_SESSION['retos'])==0){
    echo "<center><strong>Fin</strong></center>";
?>
<script>
    setTimeout(function(){ hablar('Juego Terminado'); alert2('Juego Terminado'); }, 500);
</script>
<?php
}
if (count($_SESSION['retos'])>0)
$_SESSION['actual'] = end($_SESSION['retos'])['id_reto'];
else
$_SESSION['actual'] = "";
$actual = $_SESSION['actual'];
$retos2 = array();
$_SESSION['id_seguimiento_actual'] = inicio_reto($actual);
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
    echo "Consecutivos: ".$_SESSION['consecutivos']."<br>";
    echo "Aciertos: ".$_SESSION['aciertos']."<br>";
    echo "Intentos: ".$_SESSION['intentos']."<br>";
    echo "Fallidos: ".$_SESSION['fallidos']."<br>";
    echo "Total: ".$_SESSION['total_retos']."<br>";
    #print_r($retos2);
    foreach($retos2 as $id_reto => $reto){
    $hablar = "¿Donde está, ";
    shuffle_assoc($reto['elementos']);//barjar elementos
    ?>
    <div class="lienzo2" id="mi_lienzo_juego">

        <div class="elementos3" title="#<?php echo $reto['nombre_reto']; ?>
        Dif: <?php echo $reto['dificultad']; ?> - <?php echo $reto['estado']; ?>">
        <span style="background-color:#FFF;">
        </span>
        <br>
        <?php foreach($reto['elementos'] as $id_ele_reto => $ele_reto){ ?>
        <?php #echo  "Tipo: ".$ele_reto['tipo']; ?>
        <?php 
        if ($ele_reto['tipo']=="Clave"){
             #$hablar .= $ele_reto['tipo_e_juego'].",";
             $hablar .= $ele_reto['nombre_elemento'];
             $_SESSION['clave'] = $id_ele_reto;
            }
        ?>
        <label>
            <script>
            var audio2 = new Audio('audio/click1.mp3');
            </script>
        <input class="radiojuego" hidden type="radio" value="<?php echo $id_ele_reto ?>" name="actual">
        <?php
        if ($ele_reto['tipo_e_juego']=="Figura"){
        echo  '<span class="elementoj fig" onclick="audio2.play();document.getElementById(\'mi_lienzo_juego\').style=\'display:none\';setTimeout(function(){document.getElementById(\'submit\').click();}, '.$tiempoparacontinuar.')"><img src="figuras/'.$ele_reto['nombre_elemento'].'.png" width="120px"></span>';
        }else{
        echo  '<span class="elementoj fig" onclick="audio2.play();document.getElementById(\'mi_lienzo_juego\').style=\'display:none\';setTimeout(function(){document.getElementById(\'submit\').click();}, '.$tiempoparacontinuar.')">'.$ele_reto['nombre_elemento']."</span>";
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
    #printf("<pre>%s</pre>",print_r($_SESSION['retos'],true));
    ?>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <input type="button" onclick="hablar('<?php echo $hablar ?>');" value="Repetir Audio">
    <br>
    <?php
    #echo "Clave: ".$_SESSION['clave'];
    ?>
     <p><input type="submit" id="submit" value="Continuar"></p>
        </form>

        <a href="?reset">Reiniciar</a>
<?php
}
?>
</div><!--div class="col-md-4"-->
<div class="col-md-4">
<?php

$sql_secuencias = "SELECT * FROM `secuencia`";# WHERE `asignacion` = (SELECT id_asignacion FROM `asignacion` inner join `grupo` on `asignacion`.`grupo` = `grupo`.`id_grupo` inner join `matricula` on `matricula`.`grupo` = `grupo`.`id_grupo` WHERE `matricula`.`anio` = '".date("Y")."' and `matricula`.`estudiante` = '".$_SESSION['id_usuarios']."')";
$consulta = $mysqli->query($sql_secuencias);
echo "Total secuencias: ".$consulta->num_rows."<br>";
    while($row = $consulta->fetch_assoc()){
        $nombres_secuencias[$row['id_secuencia']] = $row['nombre_secuencia'];
    }
    #echo 'secuencia_actual'.$_COOKIE['secuencia_actual'];
    $secuenciasretos_array = secuenciasretos_array($secuencias_retos);
    #print_r($secuenciasretos_array);
    echo "<ul>";
    if (count($nombres_secuencias)>0)
    foreach ($nombres_secuencias as $id_secuencias_reto => $nombre_secuencia){
        if ($secuenciasretos_array[$id_secuencias_reto]==$nombre_secuencia)
        echo "<li class='visitado'>";
        else
        echo "<li class='novisitado'>";
        if (isset($_COOKIE['secuencia_actual']) and $_COOKIE['secuencia_actual'] == $id_secuencias_reto)
        echo "<a class=\"btn btn-success\" ";
            else
        echo "<a class=\"btn btn-primary\" ";
        if (!isset($_SESSION['total_retos']))
            echo " onclick='grabarcookie(\"secuencia_actual\",\"".$id_secuencias_reto."\");document.location.href=\"jugar.php\"'";
        echo ">".$nombre_secuencia."</a></li><BR>";
    }
    echo "</ul>";
?>
<hr>
Secuencias Visitadas:<br>
<?php
        secuenciasretos($secuencias_retos);

?>
<?php  foreach ($retos_array as $retos) echo $retos;
          echo $resumen ?>
</div><!--div class="col-md-4"-->
</div><!--div class="row"-->
<style>
.visitado{
    list-style-type:disc;
}
.novisitado{
    list-style-type:circle
}
</style>
<?php
$contenido = ob_get_contents();
ob_clean();
include ("../plantilla/jugadores.php");
 ?>
