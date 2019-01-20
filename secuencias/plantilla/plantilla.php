<?php require ("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
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
    <script src="<?php echo $url_raiz ?>lib/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="<?php echo $url_raiz ?>lib/sweetalert2/sweetalert2.min.css">
</head>
<body>
    <div  class="wrapper container">
         <div class="page-header">
            <?php require("header.php"); ?>
            <?php require("menu.php"); ?>
            <main>
                <section>
                <?php if (isset($contenido)) echo $contenido; ?>
                </section>
            </main>
        </div>
    </div>
     <?php require("footer.php"); ?>
</body>
</html>