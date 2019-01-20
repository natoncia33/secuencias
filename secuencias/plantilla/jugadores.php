<?php @session_start();
require("../config/conexion.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link type="image/x-icon" href="../img/favicon.png" rel="shortcut icon" /> 
    <meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
    
    <title>Sistema | Panel Control</title>
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
      <script src="<?php echo $url_raiz ?>lib/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="<?php echo $url_raiz ?>lib/sweetalert2/sweetalert2.min.css">
<style>
  .insignias_ganadas_menu span{
      float: right;
      margin-left: -22px;
      z-index: 2;
      position: relative;
      background-color: rgba(226, 195, 14, 0.93);
      color: #000;
  }
</style>
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
              <?php echo insignias_ganadas(); ?>
              <!-- User Account: style can be found in dropdown.less -->
              <!--li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php#echo $url_raiz."img/Avatars/".$_SESSION['img_avatar']?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><!--{{Auth::usuarios()->tipo}} {{Auth::user()->nombre}}-></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image ->
                  <li class="user-header">
                    <img src="<?php #echo $url_raiz."img/Avatars/".$_SESSION['img_avatar']?>" class="img-circle" alt="User Image">
                    <p>
                     <?php #echo $_SESSION['email']?>
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer->
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="logout" class="btn btn-default btn-flat">Salir</a>
                    </div>
                  </li-->
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
              <!--img src="<?php #echo $url_raiz."img/Avatars/".$_SESSION['img_avatar'] ?>" class="img-circle" alt="User Image"-->
              <div ondblclick="document.location.href='elegir_avatar.php'" style="background: url('<?php echo "../img/Avatars/".$_SESSION['img_avatar']?>');
    /*background-size: 79.5px 47.5px;*/
    background-size: 185.5px 47.5px;
    height: 47px;
    width: 26px;
    background-size: 322px 95px;
    height: 95px;
    width: 46px;
    background-position: 0px 0px;
    background-repeat: no-repeat;
    display:inline-block;
" ></div>
            </div>
            <div class="pull-left info">
              <p><?php echo $_SESSION['email']?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> En Linea</a>
            <br><!--p>Puntos <?php #echo consultar_puntos($_SESSION['id_usuarios'])?> </p-->
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

        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          
    <div class="derecha">
             <!-- <?php require("header.php"); ?> -->
             <main>
                <section>
                <?php if (isset($contenido)) echo $contenido; ?>
                </section>
            </main>
        </div>
                   
                  

     
        </section><!-- /.content -->

      
      </div><!-- /.content-wrapper -->
      
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <?php require("footer.php"); ?>
        <strong>Copyright &copy; 2016 <a href="">Development House</a>.</strong> All rights reserved.
      </footer>

     

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
    <script src="<?php echo $url_raiz ?>plugins/morris/morris.min.js"></script>
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
    <script src="<?php echo $url_raiz ?>dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo $url_raiz ?>dist/js/demo.js"></script>
  </body>
</html>
