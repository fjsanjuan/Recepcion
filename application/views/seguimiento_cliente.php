<!DOCTYPE html>
<html lang="es">
<head runat="server">   
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Segumiento cliente</title>
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="<?=base_url()?>assets/librerias/fontawesome-free-5.2.0-web/css/all.css"/>
    <!-- Material Icons-->
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
    <!-- Bootstrap core CSS -->
    <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="<?=base_url()?>assets/css/compiled.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/js/jqueryui/jquery-ui.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/hover.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
    <link rel="icon" href="<?=base_url();?>assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.tosrus.all.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/librerias/Flatpickr/material_blue.css" type="text/css"/>
</head>
<body>
    <main>
        <div class="main-wrapper">
      <!-- Start your project here-->
        <div class="container"> 
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Seguimiento cliente</h2>
                </div>
            </div>
            <br>
                <?php if($estatus): ?>
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <!--Panel-->
                <div class="card">
                    <div class="card-body">
                        <div class="form-header dark-primary-color rounded">
                            <h3><i class="fa fa-user"></i> Datos de seguimiento</h3>
                        </div>
                         <table class="table" id="table_datos">
                            <thead class="blue-grey lighten-4">
                                <th>Nombre cliente</th>
                                <th><?php echo $orden->folio_intelisis ? "Folio" : "Folio <label style='color:red'>(Pre Orden)</label>"; ?></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $cliente; ?></td>
                                    <td><?php echo $orden->folio_intelisis ? $orden->folio_intelisis : $orden->folio; ?></td>
                                </tr>
                            </tbody>
                         </table>
                        <!--Table-->
                    </div>
                </div>
                <!--/.Panel-->
            </div>
            <div class="col-xs-12 col-md-6">
                <!--Panel-->
                <div class="card">
                    <div class="card-body">
                        <div class="form-header dark-primary-color rounded">
                            <h3><i class="fa fa-photo"></i> Imágenes</h3>
                        </div>
                        <div id="links_light">
                        </div>
                    </div>
                    <!--/.Panel-->
                </div>
            </div><!-- /card -->
        </div>
                <?php else: ?>
        <div class="col-xs-12 col-md-12">
            <p class="text-danger text-center">No se encontro información...</p>
        </div>
                <?php endif; ?>
                <br><br>
        </div>
    </main>
    <div class="cargando" id="loading_spin" style="background-color: rgba(0, 0, 0, 0)">
    <div class="col-md-12">
        <div class="windows8">
        <div class="wBall" id="wBall_1">
        <div class="wInnerBall">
        </div>
        </div>
        <div class="wBall" id="wBall_2">
        <div class="wInnerBall">
        </div>
        </div>
        <div class="wBall" id="wBall_3">
        <div class="wInnerBall">
        </div>
        </div>
        <div class="wBall" id="wBall_4">
        <div class="wInnerBall">
        </div>
        </div>
        <div class="wBall" id="wBall_5">
        <div class="wInnerBall">
        </div>
        </div>
        </div>
    </div>
    </div>
    <!-- JQuery  y scripts universales -->
    <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="<?=base_url()?>assets/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/js/materialize.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="<?=base_url()?>assets/js/mdb.min.js"></script>
    <script src="<?=base_url()?>assets/js/jqueryui/jquery-ui.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.tosrus.all.min.js"></script>
    <!-- scripts especificos -->
    <script type="text/javascript">
    $(document).ready(function() {
        carousel();
    });
    function carousel() {
        var img = document.createElement("img");
        var random = 0;
        const imagenes = JSON.parse('<?php echo json_encode($imagenes); ?>');
        $("#links_light").empty();
        if(imagenes.length > 0){
            
            for(i = 0; i<imagenes.length; i++){
                $("#links_light").append(`<a target="_blank"><img class="img_hist" src="${imagenes[i]}" style="width:100%"></a>`);
            }
        
            $("#links_light").tosrus();
        }
        else{
            $("#links_light").append(' <center style="color:red " > Sin imágenes para mostrar</center>');
        }
       
    }
    </script>
</body>
</html>