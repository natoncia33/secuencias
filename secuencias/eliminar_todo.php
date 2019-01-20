<?php
require ("config/conexion.php");
$sql = "DELETE FROM `insignias_usuario`;";
$sql .= "DELETE FROM `seguimiento_reto`;";
$sql .= "DELETE FROM `secuencia_estudiante`;";
$sql .= "DELETE FROM `elementos_reto`;";
$sql .= "DELETE FROM `reto`;";
$sql .= "DELETE FROM `secuencia`;";
$sql .= "DELETE FROM `asignacion`;";
#$sql .= "DELETE FROM `avatar`;";
$sql .= "DELETE FROM `elementos_juego`;";
#$sql .= "DELETE FROM `iconos`;";
#$sql .= "DELETE FROM `insignia`;";
$sql .= "DELETE FROM `matricula`;";
$sql .= "DELETE FROM `grupo`;";
$sql .= "DELETE FROM `anio_lectivo`;";
$sql .= "DELETE FROM `usuarios` WHERE email != 'admin@gmail.com';";

$sql .= "INSERT IGNORE INTO `secuencias`.`elementos_juego` (`tipo`, `nombre_elemento`) VALUES ('Vocal', 'A'),('Vocal', 'E'),('Vocal', 'I'),('Vocal', 'O'),('Vocal', 'U'),('Vocal', 'a'),('Vocal', 'e'),('Vocal', 'i'),('Vocal', 'o'),('Vocal', 'u');";
echo $sql;
$mysqli->multi_query($sql);
?>