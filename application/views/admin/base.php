<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Administrador</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=base_url()?>assets/librerias/fontawesome-free-5.2.0-web/css/all.css"/>
    <!-- Material Icons-->
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
    <!-- Bootstrap core CSS -->
    <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="<?=base_url()?>assets/css/compiled.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
    <link rel="icon" href=" http://intelisis.com.mx/images/intelisis/favicon.ico" type="image/x-icon">
</head>
<script>
    site_url = "<?=site_url()?>";
    base_url = "<?=base_url()?>";
</script>
<body class="fixed-sn light-blue-skin">
    <header>
        <?=$sidebar?>
        <?=$navbar?>
    </header>
    <!--/.Double navigation-->
    <!--Main Navigation-->
    <!--Main layout-->
    <main>
        <?=$contenido?>
    </main>
    <!--Main layout-->
    <!--Footer-->
    <footer class="page-footer mt-4 fixed-bottom">
        <!--Copyright-->
        <div class="footer-copyright text-center py-3">
            <div class="container-fluid">
                © 2018 Copyright:
                <a href="http://intelisis-solutions.com/"> intelisis-solutions.com </a>
            </div>
        </div>
        <!--/.Copyright-->
    </footer>
    <!--/.Footer-->

    <!-- SCRIPTS -->
    <!-- JQuery  y scripts universales -->
    <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="<?=base_url()?>assets/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/js/materialize.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="<?=base_url()?>assets/js/mdb.min.js"></script>
    <script src="<?=base_url()?>assets/js/toastr.min.js"></script>
    <!-- Initializations -->
    <script>
         // SideNav Initialization
        $(".button-collapse").sideNav();
        $('.mdb-select').material_select();
        
        new WOW().init();
    
    </script>

<?php 
    //look for JS for the class/controller/method
    $caller_method = $this->router->fetch_method();
    $class_method_js = "assets/js/custom/custom-".$caller_method.".js";
    if(file_exists(getcwd()."/".$class_method_js)){
        $fecha = date("d m Y H:i:s", filemtime($class_method_js));
        $fecha = str_replace(' ', '', $fecha);
        $fecha = str_replace(':', '', $fecha);
        $tam = filesize($class_method_js);
        ?><script type="text/javascript" src="<?php echo base_url().$class_method_js; ?>?u='<?php echo $fecha.$tam;?>'""></script>
        <?php
    }
?>
</body>
</html>