<?php require('conexion.php'); 
@session_start();
if(!isset($_SESSION['id_usuarios'])){
    header("Location:login.php");
    exit();
}
    ob_start();
?>
	<style>
div.show-top-margin{margin-top:2em;}.show-grid{margin-bottom:2em;}.show-grid [class^="col-"]{padding-top:10px;padding-bottom:10px;border:1px solid #AAA;background-color:#EEE;background-color:rgba(200,200,200,0.3);}.responsive-utilities-test .col-xs-6{margin-bottom:10px;}.responsive-utilities-test span{padding:15px 10px;font-size:14px;font-weight:bold;line-height:1.1;text-align:center;border-radius:4px;}.visible-on .col-xs-6 .hidden-xs,.visible-on .col-xs-6 .hidden-sm,.visible-on .col-xs-6 .hidden-md,.visible-on .col-xs-6 .hidden-lg,.hidden-on .col-xs-6 .visible-xs,.hidden-on .col-xs-6 .visible-sm,.hidden-on .col-xs-6 .visible-md,.hidden-on .col-xs-6 .visible-lg{color:#999;border:1px solid #ddd;}.visible-on .col-xs-6 .visible-xs,.visible-on .col-xs-6 .visible-sm,.visible-on .col-xs-6 .visible-md,.visible-on .col-xs-6 .visible-lg,.hidden-on .col-xs-6 .hidden-xs,.hidden-on .col-xs-6 .hidden-sm,.hidden-on .col-xs-6 .hidden-md,.hidden-on .col-xs-6 .hidden-lg{color:#468847;background-color:#dff0d8;border:1px solid #d6e9c6;}div.controls input,div.controls select{margin-bottom:.5em;}#inputSeleccionado{border-color:rgba(82,168,236,.8);outline:0;outline:thin dotted \9;-moz-box-shadow:0 0 8px rgba(82,168,236,.6);box-shadow:0 0 8px rgba(82,168,236,.6);}.bs-glyphicons{padding-left:0;padding-bottom:1px;margin-bottom:20px;list-style:none;overflow:hidden;}.bs-glyphicons li{float:left;width:25%;height:115px;padding:10px;margin:0 -1px -1px 0;font-size:12px;line-height:1.4;text-align:center;border:1px solid #ddd;}.bs-glyphicons .glyphicon{display:block;margin:5px auto 10px;font-size:24px;}.bs-glyphicons li:hover{background-color:rgba(86,61,124,.1);}@media (min-width: 768px) {.bs-glyphicons li{width:12.5%;}}.btn-toolbar+.btn-toolbar{margin-top:10px;}.dropdown>.dropdown-menu{position:static;display:block;margin-bottom:5px;}form .row{margin-bottom:1em;}.nav .dropdown-menu{display:none;}.nav .open .dropdown-menu{display:block;position:absolute;}
</style>
<form id="form_figura" method="post">
Figura: <img height="80" id="icon-img" src="<?php if (isset($_SESSION['archivo'])) echo "figuras/".$_SESSION['archivo'] ?>">
<span id="icono"></span>
<input type="hidden" id="icon" name="icon" value="<?php if (isset($row['archivo'])) echo "figuras/".$row['archivo'] ?>"/>
<button type="button" id="elegir_figura" class="btn btn-info btn-s" data-toggle="modal" data-target="#myModal">Elegir</button>
<div class="container">
  <!-- Modal -->
  <div class="modal modal-fullscreen fade" id="myModal" role="dialog">
    <div class="modal-dialog">
  <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
  <ul class="bs-glyphicons">
	<?php
	$sql_av = "SELECT `id_elementos_juego`, `tipo`, `nombre_elemento`, `archivo` FROM `elementos_juego` WHERE tipo = 'Figura'";
	$consulta_av = $mysqli->query($sql_av);
	while($row_av=$consulta_av->fetch_assoc()){
	//$nombre2 = str_replace("figuras/","",$nombre);
	?>
	<li <?php if ($row['archivo']==$row_av['archivo']) echo 'style="background-color:#d6e6d6"'?>><span onclick="obtener_icono(this);document.getElementById('form_figura').submit();" data-src="figuras/<?php echo $row_av['archivo'] ?>" data-id="<?php echo $row_av['archivo'] ?>" ><img width="40" src="figuras/<?php echo $row_av['archivo'] ?>"><?php echo $row_av['nombre_elemento']?></span></li>
	<?php } 
	?>
    </ul> </div>
    <div class="modal-footer">
        <a class="close btn" data-dismiss="modal">Cerrar</a>
    </div>
      </div>
      
    </div>
  </div>
  
</div>
</form>
<script>
    document.getElementById('elegir_figura').click();
</script>
<?php 
$contenido=ob_get_clean();
require("home.php");
?>