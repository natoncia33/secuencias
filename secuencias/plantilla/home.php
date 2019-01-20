<?php @session_start();
require(dirname(__FILE__)."/../config/conexion.php");
require_once(dirname(__FILE__)."/../config/funciones.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
     <link type="image/x-icon" href="../img/favicon.png" rel="shortcut icon" /> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Secuencias de Aprendizaje<?php if (isset($titulo_modulo)) echo " - $titulo_modulo"; ?></title> <!-- Nombre del modulo-->
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo $url_raiz ?>bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $url_raiz ?>dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo $url_raiz ?>dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo $url_raiz ?>plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?php echo $url_raiz ?>plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo $url_raiz ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo $url_raiz ?>plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo $url_raiz ?>plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo $url_raiz ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <meta charset="UTF-8">
    <meta name="copyright" content="© 2016">
    <meta name="description" content="">
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Secuencias de Aprendizaje</title>
  <link rel="stylesheet" href="<?php echo $url_raiz ?>css/jquery.mobile-1.4.5.min.css">
  <link rel="stylesheet" href="<?php echo $url_raiz ?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $url_raiz ?>css/estilo_tabla.css">
  <link rel="stylesheet" href="<?php echo $url_raiz ?>css/estilo.css">
  <link rel="shortcut icon" href="<?php echo $url_raiz ?>img/logo.png" type="image/x-icon" />
  <script src="<?php echo $url_raiz ?>js/jquery-2.2.4.min.js"></script>
  <script src="<?php echo $url_raiz ?>js/funciones.js"></script>
  <script src="<?php echo $url_raiz ?>js/bootstrap.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js"></script>
  <script type="text/javascript" src="<?php echo $url_raiz ?>js/jsapi.js"></script>
  <script type="text/javascript" src="<?php echo $url_raiz ?>js/uds_api_contents.js"></script>
  <!--link rel="stylesheet" ref="<?php echo $url_raiz ?>lib/sweetalert/sweetalert.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.2/sweetalert2.all.min.js"></script>
  <script src="< ? php echo #$url_raiz ? >lib/sweetalert/sweetalert.min.js"></script- ->
  <script src="<?php echo $url_raiz ?>lib/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="<?php echo $url_raiz ?>lib/sweetalert2/sweetalert2.min.css"-->
  <script src="<?php echo $url_raiz ?>lib/sweetalert/sweetalert.min.js"></script>
  <link rel="stylesheet" href="<?php echo $url_raiz ?>lib/sweetalert/sweetalert.css">
  <style>
div.show-top-margin{margin-top:2em;}.show-grid{margin-bottom:2em;}.show-grid [class^="col-"]{padding-top:10px;padding-bottom:10px;border:1px solid #AAA;background-color:#EEE;background-color:rgba(200,200,200,0.3);}.responsive-utilities-test .col-xs-6{margin-bottom:10px;}.responsive-utilities-test span{padding:15px 10px;font-size:14px;font-weight:bold;line-height:1.1;text-align:center;border-radius:4px;}.visible-on .col-xs-6 .hidden-xs,.visible-on .col-xs-6 .hidden-sm,.visible-on .col-xs-6 .hidden-md,.visible-on .col-xs-6 .hidden-lg,.hidden-on .col-xs-6 .visible-xs,.hidden-on .col-xs-6 .visible-sm,.hidden-on .col-xs-6 .visible-md,.hidden-on .col-xs-6 .visible-lg{color:#999;border:1px solid #ddd;}.visible-on .col-xs-6 .visible-xs,.visible-on .col-xs-6 .visible-sm,.visible-on .col-xs-6 .visible-md,.visible-on .col-xs-6 .visible-lg,.hidden-on .col-xs-6 .hidden-xs,.hidden-on .col-xs-6 .hidden-sm,.hidden-on .col-xs-6 .hidden-md,.hidden-on .col-xs-6 .hidden-lg{color:#468847;background-color:#dff0d8;border:1px solid #d6e9c6;}div.controls input,div.controls select{margin-bottom:.5em;}#inputSeleccionado{border-color:rgba(82,168,236,.8);outline:0;outline:thin dotted \9;-moz-box-shadow:0 0 8px rgba(82,168,236,.6);box-shadow:0 0 8px rgba(82,168,236,.6);}.bs-glyphicons{padding-left:0;padding-bottom:1px;margin-bottom:20px;list-style:none;overflow:hidden;}.bs-glyphicons li{float:left;width:25%;height:115px;padding:10px;margin:0 -1px -1px 0;font-size:12px;line-height:1.4;text-align:center;border:1px solid #ddd;}.bs-glyphicons .glyphicon{display:block;margin:5px auto 10px;font-size:24px;}.bs-glyphicons li:hover{background-color:rgba(86,61,124,.1);}@media (min-width: 768px) {.bs-glyphicons li{width:12.5%;}}.btn-toolbar+.btn-toolbar{margin-top:10px;}.dropdown>.dropdown-menu{position:static;display:block;margin-bottom:5px;}form .row{margin-bottom:1em;}.nav .dropdown-menu{display:none;}.nav .open .dropdown-menu{display:block;position:absolute;}
</style>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
  
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="admin" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>S</b>A</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Secuencias</b>APRENDIZAJE</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
                <!--li id="dropdown" class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administración</a>
                   <ul class="dropdown-menu">
                   </ul>
               </li-->
               <?php  if (isset($_SESSION['tipo']) and $_SESSION['tipo']=="docente"){ ?>
                <?php  if (isset($_SESSION['nombre_asignacion']) and $_SESSION['nombre_asignacion']!=""){ ?>
<li class="dropdown1 user user-menu"><a href="elegir_grupo.php">Grupo Actual:<BR><?php echo $_SESSION['nombre_asignacion'] ?></a></li>
                 <?php  } ?>
                 <?php  } ?>
              <?php  if (isset($_SESSION['email'])){ ?>
              <li class="dropdown1 user user-menu"><a href="<?php echo $url_raiz ?>php/asignar_secuencia.php">Asignar Secuencia</a></li>
              <li class="dropdown1 user user-menu"><a href="<?php echo $url_raiz ?>php/reporte.php">Reportes</a></li>
              <?php  } ?>
               <?php  if (isset($_SESSION['tipo']) and $_SESSION['tipo']=="admin"){ ?>
              <li class="dropdown1 user user-menu"><a href="<?php echo $url_raiz ?>php/asignacion.php">Asignación</a></li>
              <li class="dropdown1 user user-menu"><a href="<?php echo $url_raiz ?>php/matricula.php">Matricula</a></li>
              <li class="dropdown1 user user-menu"><a href="<?php echo $url_raiz ?>php/grupo.php">Grupos</a></li>
              <li class="dropdown1 user user-menu"><a href="<?php echo $url_raiz ?>php/anio_lectivo.php">Año Lectivo<br><?php echo $_SESSION['nombre_anio_lectivo'] ?></a></li>
              <?php } ?>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <?php if(isset($_SESSION['img_avatar'])){ ?>
                  <?php } ?>
                  <span class="hidden-xs"><?php if (isset($_SESSION['nombre'],$_SESSION['apellido'])) echo $_SESSION['nombre']." ".$_SESSION['apellido'] ?><br>
                  </span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                     <?php if(isset($_SESSION['img_avatar'])){ ?>
                      <img src="<?php echo $url_raiz ?><?php echo "img/Avatars/".$_SESSION['img_avatar']?>" class="img-circle" alt="User Image">
                      <?php } ?>
                  <p>
                     <?php echo $_SESSION['nombre']." ".$_SESSION['apellido'] ?><br>
                  <?php echo  nombre_grupo_asignacion($_SESSION['id_asignacion']) ?>
                      <small><?php echo $_SESSION['tipo']; ?></small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="<?php echo $url_raiz ?>php/login.php?logout" class="btn btn-default btn-flat">Salir</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <?php if(isset($_SESSION['img_avatar'])){ ?>
              <div  style="background: url('<?php echo "../img/Avatars/".$_SESSION['img_avatar']?>');
    background-size: 185.5px 47.5px;
    background-size: 79.5px 47.5px;
    height: 47px;
    width: 26px;
    
    background-size: 322px 95px;
    height: 95px;
    width: 46px;
    background-position: 0px 0px;
    background-repeat: no-repeat;
    display:inline-block;
" ></div>
              <?php } ?>
            </div>
            <div class="pull-left info">
              <p><?php echo $_SESSION['email']?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> En Linea</a>
            </div>
          </div>
          <!-- search form -->
          
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="active treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Menú</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <li class="active"><div class="izquierda"><?php require("menu.php"); ?>
        </div></li>
                
              </ul>
            </li>

  
           
           
          
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1 style="font-family: 'Comic Sans MS',cursive,sans-serif">
            
            <small>Bienvenido</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active"></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          
    <div class="derecha">
             <!-- <?php require("header.php"); ?> -->
             <main>
                <section id="prueba">
                <?php if (isset($contenido)) echo $contenido; ?>
                </section>
            </main>
        </div>
                   
                  

     
        </section><!-- /.content -->

      
      </div><!-- /.content-wrapper -->
      <?php 
      require("footer.php");
      ?>
      

     

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo $url_raiz ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo $url_raiz ?>bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <!--script src="plugins/morris/morris.min.js"></script-->
    <!-- Sparkline -->
    <script src="<?php echo $url_raiz ?>plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="<?php echo $url_raiz ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo $url_raiz ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo $url_raiz ?>plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="<?php echo $url_raiz ?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="<?php echo $url_raiz ?>plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo $url_raiz ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="<?php echo $url_raiz ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo $url_raiz ?>plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo $url_raiz ?>dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!--script src="dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo $url_raiz ?>dist/js/demo.js"></script>
    <style>
    .logo-lg {
    font-size: 12pt !important;
    transition:1.5s;
}
    </style>
  <span id="txt_alerta" style="position:fixed;bottom:28px;right:5px"></span>
  </body>
  <style>
    .content {
    overflow-y: auto;
    overflow-x: auto;
    margin-bottom:60px;
    }
  </style>
</html>
