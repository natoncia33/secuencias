<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema | Panel Control</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="/ingenieriaSoftware/public/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/ingenieriaSoftware/public/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/ingenieriaSoftware/public/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/ingenieriaSoftware/public/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="/ingenieriaSoftware/public/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="/ingenieriaSoftware/public/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="/ingenieriaSoftware/public/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/ingenieriaSoftware/public/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/ingenieriaSoftware/public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <meta charset="UTF-8">
    <meta name="copyright" content="© 2016">
    <meta name="description" content="">
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Secuencias de Aprendizaje</title>
  <link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/estilo_tabla.css">
  <link rel="stylesheet" href="css/estilo.css">
  <link rel="shortcut icon" href="img/logo.png" type="image/x-icon" />
  <script src="js/funciones.js"></script>
  <script src="js/jquery-2.2.4.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="http://code.responsivevoice.org/responsivevoice.js"></script>

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
              
             
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="/ingenieriaSoftware/public/dist/img/avatar5.png" class="user-image" alt="User Image">
                  <span class="hidden-xs">{{Auth::usuarios()->tipo}} {{Auth::user()->nombre}}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="/ingenieriaSoftware/public/dist/img/avatar5.png" class="img-circle" alt="User Image">
                    <p>
                     {{Auth::usuarios()->tipo}}: {{Auth::usuarios()->nombre}}
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="logout" class="btn btn-default btn-flat">Salir</a>
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
              <img src="/ingenieriaSoftware/public/dist/img/Admin.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>text<!--{{Auth::user()->roll}}:{{Auth::user()->name}}--></p>
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
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
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
      
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <?php require("footer.php"); ?>
        <strong>Copyright &copy; 2016 <a href="">Development House</a>.</strong> All rights reserved.
      </footer>

     

    <!-- jQuery 2.1.4 -->
    <script src="/ingenieriaSoftware/public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="/ingenieriaSoftware/public/bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="/ingenieriaSoftware/public/plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="/ingenieriaSoftware/public/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="/ingenieriaSoftware/public/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="/ingenieriaSoftware/public/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/ingenieriaSoftware/public/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="/ingenieriaSoftware/public/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="/ingenieriaSoftware/public/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="/ingenieriaSoftware/public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="/ingenieriaSoftware/public/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="/ingenieriaSoftware/public/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/ingenieriaSoftware/public/dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="/ingenieriaSoftware/public/dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/ingenieriaSoftware/public/dist/js/demo.js"></script>
  </body>
</html>
