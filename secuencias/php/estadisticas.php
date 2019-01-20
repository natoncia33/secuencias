<?php 
require_once(dirname(__FILE__)."/../config/conexion.php");
require_once(dirname(__FILE__)."/../config/funciones.php");
$grupo = $_POST['cod'];
#echo $grupo;
#exit();
ob_start();
@session_start();
?>
<ol>
<span class="area_fichas col-md-12">
<label id="ficha1" class="ficha toogle" onclick="mostrar_ficha('p1',this.id);" ><li>Aprobación por cada Reto</li></label>
<label id="ficha2" class="ficha toogle" onclick="mostrar_ficha('p2',this.id);"><li>Tiempo el cual demora responder un reto</li></label>
<label id="ficha3" class="ficha toogle" onclick="mostrar_ficha('p3',this.id);" ><li>Cuál es el reto más dificil de acuerdo al tiempo</li></label>
<label id="ficha4" class="ficha toogle" onclick="mostrar_ficha('p4',this.id);" ><li>Cuál es el reto menos dificil de acuerdo al tiempo</li></label>
</span>
</ol>
<h1><?php 
if ($grupo!="")
echo "Grupo: ".nombre_grupo($grupo);
else {
    echo "Todos los grupos";
}
?></h1>
<div class="fichas" id="p1">
<?php
if($grupo==''){
$sql23 = "SELECT Replace(concat(`secuencia`.`nombre_secuencia`,'_',`reto`.`nombre_reto`),' ', '_') as Reto, `seguimiento_reto`.`aprobado` as Aprobado FROM `seguimiento_reto` inner join `reto` on `seguimiento_reto`.`reto` = `reto`.`id_reto` inner join `secuencia` on `secuencia`.`id_secuencia` = `reto`.`id_secuencia`";

}else{
$sql23 = "SELECT Replace(concat(`secuencia`.`nombre_secuencia`,'_',`reto`.`nombre_reto`),' ', '_') as Reto, `seguimiento_reto`.`aprobado` as Aprobado FROM `seguimiento_reto` inner join `reto` on `seguimiento_reto`.`reto` = `reto`.`id_reto` inner join `secuencia` on `secuencia`.`id_secuencia` = `reto`.`id_secuencia` inner join `matricula` on 
`matricula`.`estudiante` =  `seguimiento_reto`.`usuario` where `matricula`.`grupo` = '$grupo'";
}
resultados_graficar_tabla(consultar_datos($sql23,true),'Reto,Aprobado');
?>
</div>
<div class="fichas" id="p2">
<?php
if($grupo==''){
$sql23 = "SELECT timediff(h_fin, h_inicio ) AS Tiempo, `id_seguimiento_reto`, Replace(concat(`secuencia`.`nombre_secuencia`,'_',`reto`.`nombre_reto`),' ', '_') as Reto, `usuario` as Estudiante, `aprobado`, `fecha`, `h_inicio`, `h_fin`, `marcado` FROM `seguimiento_reto` inner join `reto` on `seguimiento_reto`.`reto` = `reto`.`id_reto` inner join `secuencia` on `secuencia`.`id_secuencia` = `reto`.`id_secuencia` WHERE h_fin != '00:00:00'";
}else{
$sql23 = "SELECT timediff(h_fin, h_inicio ) AS Tiempo, `id_seguimiento_reto`, Replace(concat(`secuencia`.`nombre_secuencia`,'_',`reto`.`nombre_reto`),' ', '_') as Reto, `usuario` as Estudiante, `aprobado`, `fecha`, `h_inicio`, `h_fin`, `marcado` FROM `seguimiento_reto` inner join `reto` on `seguimiento_reto`.`reto` = `reto`.`id_reto` inner join `secuencia` on `secuencia`.`id_secuencia` = `reto`.`id_secuencia` inner join `matricula` on 
`matricula`.`estudiante` =  `seguimiento_reto`.`usuario` where `matricula`.`grupo` = '$grupo' and h_fin != '00:00:00'";
}
resultados_graficar_tabla(consultar_datos($sql23,true),'Reto,Tiempo');
?>
</div>
<div class="fichas" id="p3">
<?php
if($grupo==''){
$sql23 = "SELECT avg(timediff(h_fin, h_inicio )) AS Tiempo, `id_seguimiento_reto`, Replace(concat(`secuencia`.`nombre_secuencia`,'_',`reto`.`nombre_reto`),' ', '_') as Reto, `usuario` as Estudiante, `aprobado`, `fecha`, `h_inicio`, `h_fin`, `marcado` FROM `seguimiento_reto` inner join `reto` on `seguimiento_reto`.`reto` = `reto`.`id_reto` inner join `secuencia` on `secuencia`.`id_secuencia` = `reto`.`id_secuencia` WHERE h_fin != '00:00:00' and `aprobado` = 'NO' group by `reto`.`id_reto` order by Tiempo desc limit 5";
}else{
$sql23 = "SELECT avg(timediff(h_fin, h_inicio )) AS Tiempo, `id_seguimiento_reto`, Replace(concat(`secuencia`.`nombre_secuencia`,'_',`reto`.`nombre_reto`),' ', '_') as Reto, `usuario` as Estudiante, `aprobado`, `fecha`, `h_inicio`, `h_fin`, `marcado` FROM `seguimiento_reto` inner join `reto` on `seguimiento_reto`.`reto` = `reto`.`id_reto` inner join `secuencia` on `secuencia`.`id_secuencia` = `reto`.`id_secuencia` inner join `matricula` on 
`matricula`.`estudiante` =  `seguimiento_reto`.`usuario` where `matricula`.`grupo` = '$grupo' and  h_fin != '00:00:00' and `aprobado` = 'NO' group by `reto`.`id_reto` order by Tiempo desc limit 5";
}
$div = uniqid();
?>
<script>
var datos<?php echo $div ?> = {
      "elementos": [<?php
      foreach(consultar_datos($sql23,true) as $row){
             $salidas[] = '{ "cualitativo":" '.$row["Reto"].'", "cuantitativo":"'.$row['Tiempo'].'" }';
       }
       echo implode(",",$salidas);
      ?>]} ;
google.setOnLoadCallback(function() {
Graficar(titulo="Grafica de el reto más dificil de acuerdo al tiempo",cualitativa="Opción",cuantitativa="Segundos por Reto",contenedor="div<?php echo $div ?>",tipo_grafica="ColumnChart",ancho="700px",alto="200px",datos<?php echo $div ?>);
});
</script>
<div id="div<?php echo $div ?>" style="width: 700px; height: 300px;"></div>
<?php
?>
</div>
<div class="fichas" id="p4">
<?php
if($grupo==''){
$sql23 = "SELECT avg(timediff(h_fin, h_inicio )) AS Tiempo, `id_seguimiento_reto`, Replace(concat(`secuencia`.`nombre_secuencia`,'_',`reto`.`nombre_reto`),' ', '_') as Reto, `usuario` as Estudiante, `aprobado`, `fecha`, `h_inicio`, `h_fin`, `marcado` FROM `seguimiento_reto` inner join `reto` on `seguimiento_reto`.`reto` = `reto`.`id_reto` inner join `secuencia` on `secuencia`.`id_secuencia` = `reto`.`id_secuencia` WHERE h_fin != '00:00:00' and `aprobado` = 'NO' group by `reto`.`id_reto` order by Tiempo asc limit 5";
}else{
$sql23 = "SELECT avg(timediff(h_fin, h_inicio )) AS Tiempo, `id_seguimiento_reto`, Replace(concat(`secuencia`.`nombre_secuencia`,'_',`reto`.`nombre_reto`),' ', '_') as Reto, `usuario` as Estudiante, `aprobado`, `fecha`, `h_inicio`, `h_fin`, `marcado` FROM `seguimiento_reto` inner join `reto` on `seguimiento_reto`.`reto` = `reto`.`id_reto` inner join `secuencia` on `secuencia`.`id_secuencia` = `reto`.`id_secuencia` inner join `matricula` on 
`matricula`.`estudiante` =  `seguimiento_reto`.`usuario` where `matricula`.`grupo` = '$grupo' and h_fin != '00:00:00' and `aprobado` = 'NO' group by `reto`.`id_reto` order by Tiempo asc limit 5";
}

$div = uniqid();
?>
<script>
var datos<?php echo $div ?> = {
      "elementos": [<?php
      foreach(consultar_datos($sql23,true) as $row){
             $salidas[] = '{ "cualitativo":" '.$row["Reto"].'", "cuantitativo":"'.$row['Tiempo'].'" }';
       }
       echo implode(",",$salidas);
      ?>]} ;
google.setOnLoadCallback(function() {
Graficar(titulo="Grafica de el reto menos dificil de acuerdo al tiempo",cualitativa="Opción",cuantitativa="Segundos por Reto",contenedor="div<?php echo $div ?>",tipo_grafica="ColumnChart",ancho="700px",alto="200px",datos<?php echo $div ?>);
});
</script>
<div id="div<?php echo $div ?>" style="width: 700px; height: 300px;"></div>
</div>
<!--hr>
<h1><li>3</li></h1-->
<?php
//SELECT count(`id_seguimiento_reto`) as numero, reto.id_secuencia, `aprobado` FROM `seguimiento_reto` inner join `reto` on `reto`.`id_reto`= `seguimiento_reto`.`reto` group by id_secuencia,`aprobado`
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
    #echo $resumen;
/*
$sql23 = "SELECT Replace(concat(`secuencia`.`nombre_secuencia`,'_',`reto`.`nombre_reto`),' ', '_') as Reto2, `seguimiento_reto`.`aprobado` as Aprobado2 FROM `seguimiento_reto` inner join `reto` on `seguimiento_reto`.`reto` = `reto`.`id_reto` inner join `secuencia` on `secuencia`.`id_secuencia` = `reto`.`id_secuencia`";
resultados_graficar_tabla(consultar_datos($sql23,true),'Reto,Aprobado');
*/
?>
<style>
    .ficha{
        float: left;
        cursor: pointer;
        font-size: 15px;  /* Tamaño del texto de las pestañas */
        line-height: 40px;
        height: 40px;
        padding: 0 20px;
        display: block;
        color: #888 !important;  /* Color del texto de las pestañas */
        text-align: center;
        border-radius: 5px 5px 0 0;
        background: #eee;  /* Fondo de las pestañas */
        margin-right: 5px;
    }
    .ficha:hover:not(.toogle_active){
            background: #888888;
            color: #FFF !important
    }
    .toogle_active{
            background: #777777;
            color: #FFF !important
    }
</style>
<?php $contenido = ob_get_contents();
ob_clean();
include (dirname(__FILE__)."/../plantilla/home.php");
 ?>
