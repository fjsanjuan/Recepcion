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
<!-- alta VIN -->
<div class="modal fade" id="modalAltaVin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?php 
                $attributes = array('id' => 'alta_vin');
                echo form_open('',$attributes);
            ?>
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Alta VIN</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-header text-center">
                    <button class="btn btn-info btn-rounded btn-sm" id="btn_acArt">Alta Artículo</button>
                </div>
                <div class="modal-body mx-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="md-form mb-4">
                                <i class="fa fa-calendar prefix grey-text"></i>
                                <input type="number" class="form-control validate[required]" id="anio_vin" name="anio_vin" maxlength="4" />
                                <label data-error="wrong" data-success="right" for="orangeForm-name">Año</label>
                            </div>
                            <div class="form-inline md-form form-sm active-cyan-2">
                                <i class="fa fa-briefcase prefix grey-text"></i>
                                <input class="form-control form-control-sm mr-3 w-75 validate[required]" type="text" placeholder="Artículo" aria-label="Search" id="art_vin" name="art_vin">
                                <button type="button" data-toggle="modal" data-target="#modalbusqcli" class=""><i class="fa fa-search hvr-bob" aria-hidden="true"></i></button> 
                            </div>
                            <div class="md-form mb-4">
                                <i class="fa fa-car prefix grey-text"></i>
                                <input type="text" class="form-control validate[required]" id="vin_vin" name="vin_vin" maxlength="17">
                                <label>VIN</label>
                            </div>
                            <div class="md-form mb-4">
                                <i class="fa fa-edit prefix grey-text"></i>
                                <input type="text" class="form-control validate[required]" id="descr_vin" name="descr_vin">
                                <label>Descripción</label>
                            </div>
                            <div class="md-form mb-4">
                                <i class="fa fa-bolt prefix grey-text"></i>
                                <input type="number" class="form-control validate[required]" id="cil_vin" name="cil_vin">
                                <label>Cilindros</label>
                            </div>
                            <div class="md-form mb-4">
                                <i class="fa fa-arrow-circle-right prefix grey-text"></i>
                                <input type="number" class="form-control validate[required]" id="puertas_vin" name="puertas_vin">
                                <label>Puertas</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="md-form mb-4">
                                <i class="fa fa-users prefix grey-text"></i>
                                <input type="number" class="form-control validate[required]" id="pasaj_vin" name="pasaj_vin">
                                <label>Pasajeros</label>
                            </div>
                            <div class="md-form mb-4">
                                <i class="fa fa-cogs prefix grey-text"></i>
                                <input type="text" class="form-control validate[required]" id="trans_vin" name="trans_vin">
                                <label>Transmisión</label>
                            </div>
                            <div class="md-form mb-4">
                                <i class="fa fa-cog prefix grey-text"></i>
                                <input type="text" class="form-control validate[required]" id="tipovqc_vin" name="tipovqc_vin">
                                <label>Tipo Vehículo QC</label>
                            </div>
                            <div class="md-form mb-4">
                                <i class="fa fa-tachometer-alt prefix grey-text"></i>
                                <input type="text" class="form-control validate[required]" id="motorlts_vin" name="motorlts_vin">
                                <label>Motor Lts</label>
                            </div>
                            <div class="md-form mb-4">
                                <i class="fa fa-fire prefix grey-text"></i>
                                <input type="text" class="form-control validate[required]" id="cilqc_vin" name="cilqc_vin">
                                <label>Cilindros QC</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-deep-orange" id="btn_altaVin">Alta VIN</button>
                </div>
            <?php 
                echo form_close();
            ?>
        </div>
    </div>
</div>

<div class="text-center">
    <a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#modalAltaVin">Alta VIN</a>
</div>
<!-- ALTA Articulo -->
<div class="modal fade" id="modAltaArt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?php 
                $attributes = array('id' => 'alta_articulo');
                echo form_open('',$attributes);
            ?>
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Alta Artículo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-header text-center">
                    <button class="btn btn-info btn-rounded btn-sm" id="btn_acVin">Alta Vin</button>
                </div>
                <div class="modal-body mx-3">
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <div class="md-form mb-4">
                                <i class="fa fa-key prefix grey-text"></i>
                                <input type="text" class="form-control validate[required]" id="clave_art" name="clave_art" maxlength="20">
                                <label for="orangeForm-name">Clave</label>
                            </div>
                            <div class="md-form">
                                <select class="mdb-select colorful-select dropdown-primary" id="opciones_art" name="opciones_art">
                                    <option value="No" selected>No</option>    
                                </select>
                                <label>Opciones</label>
                            </div>
                            <div class="md-form">
                                <select class="mdb-select colorful-select dropdown-primary" id="estatus_art" name="estatus_art">
                                    <option value="ALTA" selected>ALTA</option>    
                                </select>
                                <label>Estatus</label>
                            </div>
                            <div class="md-form">
                                <select class="mdb-select colorful-select dropdown-primary" id="estPrecio_art" name="estPrecio_art">
                                    <option value="NUEVO" selected>NUEVO</option>    
                                </select>
                                <label>Estatus Precio</label>
                            </div>
                            <div class="md-form mb-4">
                                <i class="fa fa-edit prefix grey-text"></i>
                                <textarea class="md-textarea form-control validate[required]" id="descripcion_art" name="descripcion_art"></textarea>
                                <label for="orangeForm-name">Descripción</label>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="md-form">
                                <select class="mdb-select colorful-select dropdown-primary" id="uVenta_art" name="uVenta_art">
                                    <option value="Unidad" selected>Unidad</option>    
                                </select>
                                <label>Unidad Venta</label>
                            </div>
                            <div class="md-form">
                                <select class="mdb-select colorful-select dropdown-primary" id="uTrasp_art" name="uTrasp_art">
                                    <option value="Unidad" selected>Unidad</option>    
                                </select>
                                <label>Unidad Traspaso</label>
                            </div>
                            <div class="md-form mb-4">
                                <i class="fa fa-sort prefix grey-text"></i>
                                <input type="number" id="orangeForm-name" class="form-control validate[required]" id="numPartes_art" name="numPartes_art" value="1" readonly>
                                <label for="orangeForm-name"># Partes</label>
                            </div>
                            <div class="md-form">
                                <select class="mdb-select colorful-select dropdown-primary" id="monVenta_art" name="monVenta_art">
                                    <option value="Pesos">Pesos</option>
                                    <option value="Dolar">Dolar</option>    
                                </select>
                                <label>Moneda Venta</label>
                            </div>
                            <div class="md-form">
                                <select class="mdb-select colorful-select dropdown-primary" id="cat_art" name="cat_art">
                                    <option value="1">Autos Nuevos</option>
                                    <option value="2">Autos Seminuevos</option>    
                                </select>
                                <label>Categoría</label>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="md-form mb-4">
                                <i class="fa fa-barcode prefix grey-text"></i>
                                <input type="text" class="form-control validate[required]" id="codFabr_art" name="codFabr_art" readonly>
                                <label for="orangeForm-name">Código Fabricante</label>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button  type="submit" class="btn btn-deep-orange" id="btn_altaArt">Alta Artículo</button>
                </div>
            <?php 
                echo form_close();
            ?>
        </div>
    </div>
</div>

<div class="text-center">
    <a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#modAltaArt">Alta Artículo</a>
</div>