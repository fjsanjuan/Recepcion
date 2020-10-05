<!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg  sticky-top navbar-dark dark-primary-color ">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="#"> Servicio de Citas</a>
        <ul class="navbar-nav ml-auto mt-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fa fa-user"></i> <?php echo $this->session->userdata["logged_in"]["correo"]?>
                </a>
                <div class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdownMenuLink-4">
                    <a class="dropdown-item waves-effect waves-light" href="<?=site_url('user/logout')?>">Salir</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- ./NAVBAR -->
<br><br>

<!-- float bottons -->
<div id="container-floating">
  <div class="nd1 nds" data-toggle="tooltip" data-placement="left" ><img class="reminder">
    <p class="letter hvr-pulse"><i class="fa fa-plus-circle"  data-toggle="modal" data-target="#modalContactForm"  aria-hidden="true"></i></p>
  </div>
  <div id="floating-button" data-toggle="tooltip" data-placement="left" data-original-title="Create" onclick="newmail()">
    <p class="plus">+</p>
    <img class="edit" src="https://ssl.gstatic.com/bt/C3341AA7A1A076756462EE2E5CD71C11/1x/bt_compose2_1x.png">
  </div>
</div>
<!-- /float buttons -->

<!-- button return -->
<a class="btn-floating accent-color"  data-toggle="tooltip" data-placement="right" title="regresar" href="<?= $_SERVER['HTTP_REFERER']; ?>"><i class="fa fa-undo"></i></a>
<!-- MODALS -->

<!-- alta cliente -->
<div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Alta Cliente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php 
                $attributes = array('id' => 'alta_cliente');
                echo form_open('',$attributes);
            ?>
            <div class="modal-body mx-3">
                <div class="md-form mb-5">
                    <i class="fa fa-user prefix grey-text"></i>
                    <input type="text" id="orangeForm-name" class="form-control validate[required]" name="nombre_cli">
                    <label data-error="wrong" data-success="right" for="orangeForm-name">Nombre Completo</label>
                </div>
                <div class="md-form mb-5">
                    <i class="fa fa-address-card prefix grey-text"></i>
                    <input type="text" id="rfcinput" class="form-control validate[required]" name="rfc_cli">
                    <label data-error="wrong" data-success="right" for="orangeForm-email">RFC</label>
                </div>
                <!-- Switch -->
                <div class="switch">RFC Genérico:
                    <span style="display: inline-block; float: right;">
                        <label>
                            No
                            <input id="check_rfc" type="checkbox">
                            <span class="lever"></span>
                            Sí
                        </label>
                    </span>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-deep-orange " id="btn_altaCli">Alta Cliente</button>
            </div>
            <?php 
                echo form_close();
            ?>
        </div>
    </div>
</div>

<div class="text-center">
    <a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#modalRegisterForm">Alta Cliente</a>
</div>
