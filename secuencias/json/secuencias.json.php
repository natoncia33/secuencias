<?php
require ("../config/conexion.php");
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
}
echo json_encode($retos);
?>