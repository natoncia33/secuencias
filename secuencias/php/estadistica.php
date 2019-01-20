<?php
ob_start();
require_once ("../config/funciones.php");
function transpose($array) {
    array_unshift($array, null);
    return call_user_func_array('array_map', $array);
}
/*
$item1 = 'Tipo';
$item2 = 'Avatar';
$array = array();
$array[] = array ($item1=> 'admin', $item2 => 24 );
$array[] = array ($item1=> 'docente', $item2 => 25 );
$array[] = array ($item1=> 'estudiante', $item2 => 24 );
$array[] = array ($item1=> 'estudiante', $item2 => 24 );
$array[] = array ($item1=> 'estudiante', $item2 => 25 );
$array[] = array ($item1=> 'estudiante', $item2 => 25 );
$array[] = array ($item1=> 'estudiante', $item2 => 25 );
$array[] = array ($item1=> 'estudiante', $item2 => 25 );
$array[] = array ($item1=> 'estudiante', $item2 => 25 );
$array[] = array ($item1=> 'estudiante', $item2 => 24 );
$array[] = array ($item1=> 'estudiante', $item2 => 24 );
$array[] = array ($item1=> 'estudiante', $item2 => 24 );
echo "<br>";
Array ( [Tipo] => Array ( [0] => 44 [1] => 44 [2] => 4 [3] => 4 [4] => 4 ) [Avatar] => Array ( [0] => 3 [1] => 4 [2] => 34 [3] => 3 [4] => 4 ) )
*/
if (isset($_POST['Tipo'])){
echo "<pre>";
#print_r($_POST);
$datos = array();
$items_base = array();
foreach ($_POST as $campo => $valor){
    $items_base[$campo] = $campo;
}
foreach ($_POST as $campo => $valor){
    if (is_array($valor))
    foreach ($valor as $campo1 => $valor1){
        foreach ($items_base as $valor2){
            $datos[$campo1][$valor2]=$valor1;
        }
    }
}
$items = implode(",",$items_base);
#print_r($datos);
echo "</pre>";
resultados_graficar_tabla($datos,"$items");
#resultados_graficar_tabla(consultar_datos($sql23,true),'1,2');
}
?>

<form method="post">
    <input type="text" name="Tipo[]" placeholder="Tipo">
    <input type="text" name="Tipo[]" placeholder="Tipo">
    <input type="text" name="Tipo[]" placeholder="Tipo">
    <input type="text" name="Tipo[]" placeholder="Tipo">
    <input type="text" name="Tipo[]" placeholder="Tipo">
<br><input type="text" name="Avatar[]" placeholder="Avatar">
    <input type="text" name="Avatar[]" placeholder="Avatar">
    <input type="text" name="Avatar[]" placeholder="Avatar">
    <input type="text" name="Avatar[]" placeholder="Avatar">
    <input type="text" name="Avatar[]" placeholder="Avatar">
    <button>Enviar</button>
</form>
<?php
$contenido = ob_get_clean();
require_once ("../plantilla/home.php");
?>