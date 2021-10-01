<?php date_default_timezone_set('America/Mexico_City'); ?>
<script src="<?=base_url()?>assets/js/jquery.jqscribble.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/jqscribble.extrabrushes.js" type="text/javascript"></script>
<!-- <link rel="stylesheet" type="text/css" href="https://printjs-4de6.kxcdn.com/print.min.css"> -->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/multi-select.css">
<link rel="stylesheet" href="<?=base_url()?>assets/librerias/fontawesome-free-5.2.0-web/css/all.css"/>
<link rel="stylesheet" href="<?=base_url()?>assets/librerias/fontawesome-free-5.2.0-web/css/fontawesome.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/librerias/roundslider/roundslider.css">       
<script src="<?=base_url()?>assets/js/jquery.multi-select.js"></script>
<!-- <script src="https://superal.github.io/canvas2image/canvas2image.js"></script> -->
<script src="<?=base_url()?>assets/librerias/canvas2image/canvas2image.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script> -->
<script src="<?=base_url()?>assets/librerias/html2canvas/html2canvas.min.js"></script>

<!-- <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script> -->
<script src="<?=base_url()?>assets/librerias/jspdf/jspdf.debug.js"></script>
<script src="<?=base_url()?>assets/librerias/roundslider/roundslider.js"></script>
<script src="<?=base_url();?>assets/librerias/moment.js/moment.min.js"></script>
<script src="<?=base_url();?>assets/librerias/moment.js/moment-with-locales.min.js"></script>
<!-- <script src="<?=base_url()?>assets/librerias/autonumeric/autoNumeric.js"></script> -->

<input type="hidden" id="id_venta" value="<?=$vta?>">
<input type="hidden" id="cliente" value="<?=$cliente?>">
<input type="hidden" id="vin" value="<?=$vin?>">
<style>
	body {
        overscroll-behavior: contain;
    }
    .modal-lg{
        max-width: 1100px;
    }

    .titulos_collapse {
        font-size: 16px;
        /*font-weight: bold;*/
        color: #212529;
    }

    .card-header, .card-body {
        padding-top: 0px;
        padding-bottom: 0px; 
    }

    #accordion a, label, input{
        font-size: 12px !important;
    }

    #accordion label {
        margin: 0px;
    }

    #accordion input {
        padding: 5px;
    }

    .modal-header {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .separador {
        height: 5px;
    }

    .btn-success {
        padding: 10px;
    }

    .links a {
        padding-left: 10px;
        margin-left: 10px;
        border-left: 1px solid #000;
        text-decoration: none;
        color: #999;
    }
    .links a:first-child {
        padding-left: 0;
        margin-left: 0;
         border-left: none;
    }
    .links a:hover {text-decoration: underline;}
    .column-left {
        display: inline; 
        float: left;
    }
    .column-right {
        display: inline; 
        float: right;
    }
    #boton_agregarArt {
        padding-left: 13px;
        padding-right: 13px;
        padding-top: 8px;
        padding-bottom: 8px;
        margin-top: 0px;
    }
</style>
<!-- Nav tabs 
<ul class="nav nav-tabs nav-justified primary-color" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#panel5" role="tab">
        <i class="fa fa-clone"></i> Datos</a>
    </li>
    <li class="nav-item" >
        <a class="nav-link" data-toggle="tab" href="#panel6" role="tab" id="tab2_ordn">
        <i class="fa fa-cart-arrow-down"></i> Orden</a>
    </li>
</ul> -->
<form role="form" action="<?= base_url()?>servicio/nueva_orden_detalle" method="post" id="form_orden_servicio" class="form-actions">
<div class="tab-content">
    <input type="hidden" name="id_orden" id="id_orden">
    <!-- Nav tabs -->
 <!-- modal orden de Servicio -->
    <div class=" fade in show " id="panel5" role="tabpanel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Orden de Servicio</h4> 
                </div>
                <div class="modal-body mx-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                                $attributes = array('id' => 'form_datosOrden');
                                echo form_open('',$attributes);
                            ?>
                            <div id="accordion">
                                <div class="card"> <!-- ACORDEON CLIENTE -->
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <a class="card-link titulos_collapse" data-toggle="collapse" href="#collapseCliente">CLIENTE</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapseCliente" class="collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <?php $this->load->view("muestra_datos/datos_cliente");?>
                                        </div>
                                    </div>
                                </div>
                                <div class="separador"></div>
                                <div class="card"> <!-- ACORDEON VEHICULO -->
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <a class="card-link titulos_collapse" data-toggle="collapse" href="#collapseVehiculo">VEHÍCULO</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapseVehiculo" class="collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <?php $this->load->view("muestra_datos/datos_vehiculo");?>
                                        </div>
                                    </div>
                                </div>
                                <div class="separador"></div>
                                <div class="card"> <!-- ACORDEON ASESOR -->
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <a class="card-link titulos_collapse" data-toggle="collapse" href="#collapseAsesor">ASESOR</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapseAsesor" class="collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row vista_previa">
                                                <div class="col-sm-2">
                                                    <div class="col-sm">
                                                        <label for="cve_asesor" class="grey-text">Clave</label>
                                                        <input type="text" id="cve_cliente" name="cve_cliente" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="col-sm">
                                                        <label for="nombre_asesor" class="grey-text">Nombre</label>
                                                        <input type="text" id="asesorname_cliente" name="asesorname_cliente" class="form-control" readonly="true">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="col-sm">
                                                        <label for="nombre_asesor" class="grey-text">Fecha Promesa</label>
                                                        <input type="date" id="fecha_promesa_cliente" name="fecha_promesa_cliente"  required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" class="form-control validate[required]">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="col-sm">
                                                        <label for="nombre_asesor" class="grey-text">Hora Promesa</label>
                                                        <input type="hidden" id="horapromesa_cliente" name="horapromesa_cliente" class="form-control validate[required]" value="<?php echo (date("G")+1).":00";?>">
                                                        <select id="hora_promesa_cliente2" name="hora_promesa_cliente2" class="browser-default form-control validate[required]" style="height: calc(1.90rem + 2px);">
                                                            <option disabled selected></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1" style="display: none;">
                                                    <div class="sm-"> 
                                                        <p class="grey-text ver_todo_texto" style="font-size: 12px;">Ver Todo</p>
                                                        <i class="fa fa-plus rotate-icon fa-1x card-link" style="display: block; text-align: center; color: #1976D2; cursor: pointer;" id="ver_todoAsesor"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                                <div class="separador"></div>
                                <div class="card">    <!-- ACORDEON ORDEN -->
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <a class="card-link titulos_collapse" data-toggle="collapse" href="#collapseOrden">ORDEN</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapseOrden" class="collapse show" data-parent="#accordion">
                                        <div class="card-body"> 
                                            <div class="row vista_previa">
                                                <div class="col"> 
                                                    <label for="condicion_cliente" class="grey-text">Condición</label>
                                                    <select id="condicion_cliente" name="condicion_cliente" class="browser-default form-control validate[required]" >
                                                        <option disabled selected>Seleccione</option>
                                                        <!-- <option value="5 Dias">5 Días</option>
                                                        <option value="15 Dias">15 Días</option>
                                                        <option value="30 Dias">30 Días</option>
                                                        <option value="Contado">Contado</option>
                                                        <option value="Credito">Crédito</option>
                                                        <option value="Parcialidades">Parcialidades</option> -->
                                                    </select>
                                                </div>
                                                <div class="form-group col">
                                                    <label for="tipoorden_cliente" class="grey-text">Tipo Orden</label>
                                                    <select id="tipoorden_cliente" name="tipoorden_cliente" class="browser-default form-control validate[required]">
                                                        <!-- <option>seleccione... </option> -->
                                                    </select>
                                                </div>
                                                <div class="form-group col">
                                                    <label for="tipooperacion_cliente" class="grey-text">Tipo Operación</label>
                                                    <select id="tipooperacion_cliente" name="tipooperacion_cliente" class="browser-default form-control validate[required]" >
                                                        <!-- <option>seleccione... </option> -->
                                                    </select>
                                                </div>
                                                <div class="form-group col">
                                                    <label for="tipoprecio_cliente" class="grey-text">Tipo Precio</label>
                                                    <select id="tipoprecio_cliente" name="tipoprecio_cliente" class="browser-default form-control validate[required]" >
                                                        <!-- <option>seleccione... </option> -->
                                                    </select>
                                                </div>
                                                <div class="form-group col">
                                                    <label for="concepto_cliente" class="grey-text">Concepto</label>
                                                    <select id="concepto_cliente" name="concepto_cliente" class="browser-default form-control validate[required]" >
                                                        <!-- <option>seleccione... </option> -->
                                                    </select>
                                                </div>
                        

                                            </div>
                                            <div class="row">
                                                <div class="form-group col">
                                                    <label for="moneda_cliente" class="grey-text">Moneda</label>
                                                    <select id="moneda_cliente" name="moneda_cliente" class="browser-default form-control validate[required]" >
                                                        <option value="Pesos">Pesos</option>
                                                        <option value="USD">USD</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col">
                                                    <label for="ZonaImpuesto_select" class="grey-text">% IVA (Zona Impuesto)</label>
                                                    <select id="ZonaImpuesto_select" name="ZonaImpuesto_select" class="browser-default form-control validate[required]" >
                                                        <option>Seleccione... </option>
                                                    </select>
                                                </div>
                                                <div class="form-group col">
                                                    <label for="tipouen_cliente" class="grey-text">UEN</label>
                                                    <select id="tipouen_cliente" name="tipouen_cliente" class="browser-default form-control validate[required]" >
                                                        <!-- <option>seleccione... </option> -->
                                                    </select>
                                                </div>
                                                <div class="form-group col">
                                                    <label for="tipotorre" class="grey-text">Torre Color</label>
                                                    <select id="tipotorre" name="tipotorre" class="browser-default form-control validate[required]" >
                                                        <!-- <option>seleccione... </option> -->
                                                    </select>
                                                </div>
                                                <div class="form-group col">
                                                    <label for="torrenumero" class="grey-text">Torre #</label>
                                                    <input type="number" id="torrenumero" name="torrenumero" class="form-control validate[required]">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col">
                                                    <label for="Comentario_cliente" class="grey-text" style="display:block !important;">Comentario clientes</label>
                                                    <textarea name="comentcliente" id="comentcliente" rows="3" style="width:100%;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="" id="panel6">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">
                            Paquetes
                        </h4>
                    </div>
                    <div class="moda-body">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <a class="btn btn-primary btn-sm" data-toggle="modal" id="add_pac"><i class="fa fa-plus mr-1"></i> Agregar Paquete</a>
                                       <!--  <a class="btn btn-primary btn-sm" data-toggle="modal" ><i class="fa fa-plus mr-1"></i> Agregar Op. Frecuentes</a> -->
                                        <a class="btn btn-primary btn-sm" data-toggle="modal" id="add_mo"><i class="fa fa-plus mr-1"></i> Mano de Obra</a>
                                           <a class="btn btn-primary btn-sm" data-toggle="modal" id="add_arts"><i class="fa fa-plus mr-1"></i> Articulos</a>
                                    </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive" style="width: 85%;">
                                            <table class="table table-condensed" id="table_invoice">
                                                <thead>
                                                    <tr>
                                                        <td></td>
                                                        <td><strong>Artículo</strong></td>
                                                        <td class="text-center"><strong>Descripción</strong></td>
                                                        <td class="text-center"><strong>Cantidad</strong></td>
                                                        <td class="text-center"><strong>Precio U</strong></td>
                                                        <td class="text-center"><strong>Total</strong></td>
                                                    </tr>
                                                </thead>
                                         
                                              
                                            </table>
                                        </div>
                                        <div class="row" style="text-align: center;">
                                            <div class="col">
                                                <div class="md-form" style="padding: 25px; font-size: 45px;">
                                                    <i class="fa fa-dollar" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="md-form" style="padding: 25px;">
                                                    <span class="font-weight-bold">SUBTOTAL</span>
                                                    <input class="form-control" id="subtotal" name ="subtotal" type="text" readonly="true">
                                                </div>
                                              
                                            </div>
                                            <div class="col">
                                               <div class="md-form" style="padding: 25px;">
                                                     <span class="font-weight-bold">IVA</span>  
                                                     <input class="form-control" type="text" name="iva" id="ivatotal" readonly="true">
                                                </div>
                                             
                                            </div>
                                            <div class="col">
                                                <div class="md-form" style="padding: 25px;">
                                                    <span class="font-weight-bold">TOTAL</span>
                                                    <input class="due form-control" type="text" name='totaaal' id="totaaal" readonly="true">
                                                </div>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            echo form_close();
                        ?>
                          <!-- guardar, email, firma, pdf -->
                         <section>
                            <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
                                <a class="btn-floating btn-lg red waves-effect waves-light">
                                    <i class="fa fa-plus"></i>
                                </a>
                                <ul class="list-unstyled">
                                    <li>
                                        <a class="btn-floating indigo waves-effect waves-light" id="mostrar_modalemail"><i class="fa fa-at"></i></a>
                                    </li>                            
                                    <li>
                                        <a class="btn-floating white waves-effect waves-light" id="enviar_whatsapp"><img src="<?=base_url()?>assets/img/whatsapp.png" alt="logo whatsapp" class="icono_whatsapp"></a>
                                    </li>
                                    <li>
                                        <a class="btn-floating red waves-effect waves-light" id="generar_pdf"><i class="far fa-file-pdf" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a class="btn-floating yellow waves-effect waves-light" id="mostrar_modalOasis"><i class="fa fa-file-pdf"></i></a>
                                    </li>
                                    <li>
                                        <a class="btn-floating blue waves-effect waves-light" id="mostrar_modalfirma"><i class="fa fa-file-signature"></i></a>
                                    </li>
                                    <li>
                                        <a class="btn-floating green waves-effect waves-light" id="levanta_orden"><i class="fa fa-save" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </section>
                        <div class="col-sm-12">
                <button class="btn btn-info btn-sm" id="boton_OrdenesVin"><i class="fa fa-search"></i> Buscar Órdenes</button>
                    </div>
                </div>
            </div>
    </div>
    </div>
    <div class="" id="panel7">
    <?php 
       echo form_open( base_url ().'servicio/guardar_inspeccion', 'class="form-actions" id="form_inspeccion_servicio"');
    ?>
        <div class="row">
        <div class="col-md-11 modal-lg" style="margin:0 auto;">
            <div id="scrolltoo"></div>
          <h2 id="top-section" class="text-center font-bold pt-4 pb-5 mb-5"><strong>Inspección de Vehículo</strong></h2>
          <!-- Stepper -->
          <div class="steps-form-2">
          <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">
             <div class="steps-step-2">
                  <a href="#step-1" type="button" class="btn btn-amber btn-circle-2 waves-effect ml-0" data-toggle="tooltip" data-placement="top" title="Inspeccion Visual"><i class="fa fa-clipboard-list" aria-hidden="true"></i><br>1</a>
              </div>
              <div class="steps-step-2">
                  <a href="#step-2" type="button" class="btn btn-blue-grey btn-circle-2 waves-effect" data-toggle="tooltip" data-placement="top" title="Niveles"><i class="fa fa-car" aria-hidden="true"></i>2</a>
              </div>
              <div class="steps-step-2">
                  <a href="#step-3" type="button" class="btn btn-blue-grey btn-circle-2 waves-effect" data-toggle="tooltip" data-placement="top" title="Fotos"><i class="fa fa-image" aria-hidden="true"></i>3</a>
              </div>
              <div class="steps-step-2">
                  <a href="#step-4" type="button" class="btn btn-blue-grey btn-circle-2 waves-effect" data-toggle="tooltip" data-placement="top" title="Audios"><i class="fa fa-file-audio" aria-hidden="true"></i>4</a>
              </div>
          </div>
      </div>
      <!-- First Step -->
      <form role="form" action="" method="post">
          <div class="row setup-content-2" id="step-1">
            <div class="col-md-12">
              <br>
              <h5 style="color: #4285f4;"><center><b>Paso 1: Inspección Visual e Inventario en Recepción</b></center></h5> 
              <br>
              <div class="row">
                <div class="col-6">
                  <div class="table-responsive">
                    <table class="table">
                        <blockquote class="blockquote bq-primary htext">Cajuela</blockquote>
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="herramienta" name="herramienta">
                              <label class="form-check-label" for="herramienta">Herramienta</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="gatollave" name="gatollave">
                              <label class="form-check-label" for="gatollave">Gato/Llave</label>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="reflejantes" name="reflejantes">
                              <label class="form-check-label" for="reflejantes">Reflejantes</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="cables" name="cables">
                              <label class="form-check-label" for="cables">Cables</label>
                            </div>
                          </td>
                        </tr>
                        <!-- -->
                        <tr>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="extintor" name="extintor">
                              <label class="form-check-label" for="extintor">Extintor</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="llantarefaccion" name="llantarefaccion">
                              <label class="form-check-label" for="llantarefaccion">Llanta de refacción</label>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-6">
                  <div class="table-responsive">
                    <table class="table">
                        <blockquote class="blockquote bq-primary htext">Exteriores</blockquote>
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="taponesrueda" name="taponesrueda">
                              <label class="form-check-label" for="taponesrueda">Tapones de Ruedas</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="gomalimpiador" name="gomalimpiador">
                              <label class="form-check-label" for="gomalimpiador">Gomas de Limpiadores</label>
                            </div>
                          </td>
                          <tr>
                            <td>
                              <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="antna" name="antna">
                                <label class="form-check-label" for="antna">Antena</label>
                              </div>
                            </td>
                            <td>
                              <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="tapagas" name="tapagas">
                                <label class="form-check-label" for="tapagas">Tapon de Gasolina</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="molduras" name="molduras">
                                <label class="form-check-label" for="molduras">Molduras</label>
                              </div>
                            </td>
                          </tr>
        
                        </tr>          
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-6">
                  <div class="table-responsive">
                    <table class="table">
                        <blockquote class="blockquote bq-primary htext">Documentación</blockquote>
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="polizamanual" name="polizamanual">
                              <label class="form-check-label" for="polizamanual">Poliza de Garantía/Manual Op.</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="segrines" name="segrines">
                              <label class="form-check-label" for="segrines">Seguro de Rines</label>
                            </div>
                          </td>
                          <tr>
                            <td>
                              <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="certverific" name="certverific">
                                <label class="form-check-label" for="certverific">Certificado de Verificación</label>
                              </div>
                            </td>
                            <td>
                              <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="tarjcirc" name="tarjcirc">
                                <label class="form-check-label" for="tarjcirc">Tarjeta de Circulación</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>
                               <label for="">Extensión de garantía</label>
                              <!--  <label for="">Garantía</label>  --> <!-- para fame -->
                                <!-- Material inline 1 -->
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="extGSI" name="ext_garantia" value="si" checked>
                                  <label class="form-check-label" for="extGSI">Sí</label>
                                </div>
                                <!-- Material inline 2 -->
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="extGNo" name="ext_garantia" value="no">
                                  <label class="form-check-label" for="extGNo">No</label>
                                </div>
                            </td>
                          </tr>     
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-6">
                    <blockquote class="blockquote bq-primary htext">Gasolina</blockquote>
                    <!-- roundslider -->
                    <div class="form-check capturar">
                        <div class="col-12">
                            <label>Gasolina en Octavos</label>
                            <input type="hidden" name="insp_gasolina" id="insp_gasolina">
                            <br>
                            <div class="col-12">
                                <span id="span_grafica"></span>
                            </div>
                            <br>
                            <div id="handle1" class="grafica_gasolina"></div>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="col">
                    <blockquote class="blockquote bq-primary htext">¿Deja artículos personales?</blockquote>
                  <!-- Material inline 1 -->
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="form-check-input" id="dejaarticulos" name="dejaarticulos">
                    <label class="form-check-label" for="dejaarticulos">SI</label>
                  </div>
                  <!-- Material inline 2 -->
                  <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="nodejaarticulos" name="nodejaarticulos">
                    <label class="form-check-label" for="nodejaarticulos">NO</label>
                  </div>
                  <div class="form-check">
                    <label for="">¿Cuáles?</label>
                    <input class="form-control" type="text" name="articulos_personales">
                  </div>
                </div>
              </div>

            </div>
          </div>
          <!-- Second Step -->
          <div class="row setup-content-2" id="step-2">
            <div class="col" style="text-align: center;">
              <br>
              <h5 style="color: #4285f4;"><center><b>Paso 2: Niveles</b></center></h5>
              <br>
              <strong>Leyenda</strong>
              <button type="button" class="btn btn-sm success-color">Verfificado y aprobado esta vez</button>
              <button type="button" class="btn btn-sm warning-color">Puede requerir atencion en el futuro</button>
              <button type="button" class="btn btn-sm danger-color">Requiere atencion inmediata</button>
            </div>

            <div class="col-md-12">
              <blockquote class="blockquote bq-primary htext">NIVELES DE FLUIDOS</blockquote>
              <div class="table-responsive">
                <table class="table">
                  <div>
                      <label for="">Pérdida de aceite o fluidos</label>
                        <!-- Material inline 1 -->
                        <div class="form-check form-check-inline">
                          <input type="radio" class="form-check-input" id="fluidossi" name="perdida_fluid" value="si">
                          <label class="form-check-label" for="fluidossi">Sí</label>
                        </div>
                        <!-- Material inline 2 -->
                        <div class="form-check form-check-inline">
                          <input type="radio" class="form-check-input" id="fluidosno" name="perdida_fluid" value="no">
                          <label class="form-check-label" for="fluidosno">No</label>
                        </div>
                        &nbsp;&nbsp;&nbsp;
                        <!-- Material inline 1 -->
                        <label>Cambiado:</label>
                        <div class="form-check form-check-inline">
                          <input type="radio" class="form-check-input" id="materialInline1" name="nivel_fl_cambiado" value="si">
                          <label class="form-check-label" for="materialInline1">Sí</label>
                        </div>
                        <!-- Material inline 2 -->
                        <div class="form-check form-check-inline">
                          <input type="radio" class="form-check-input" id="materialInline2" name="nivel_fl_cambiado" value="no">
                          <label class="form-check-label" for="materialInline2">No</label>
                        </div>
                  </div>
                  <tr>
                    <td>
                      <label for="">Aceite de Motor</label>
                      <div class="switch">
                        <label>
                              Llenar
                              <input type="checkbox" name="aceiteMotor">
                              <span class="lever success"></span>
                              Bien
                          </label>
                      </div>
                    </td>
                    <td>
                      <label for="">Dirección Hidraulica</label>
                      <div class="switch">
                        <label>
                              Llenar
                              <input type="checkbox" name="direccionHidraulica">
                              <span class="lever"></span>
                              Bien
                          </label>
                      </div>
                    </td>
                    <td>
                      <label for="">Transmisión</label>
                      <div class="switch">
                        <label>
                              Llenar
                              <input type="checkbox" name="transmision">
                              <span class="lever"></span>
                              Bien
                          </label>
                      </div>
                    </td>
                    <td>
                      <label for="">Limpiaparabrisas</label>
                      <div class="switch">
                        <label>
                              Llenar
                              <input type="checkbox" name="liq_limpiaparabrisas">
                              <span class="lever"></span>
                              Bien
                          </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="">Deposito de Fluido de Freno</label>
                      <div class="switch">
                        <label>
                              Llenar
                              <input type="checkbox" name="liq_frenos">
                              <span class="lever"></span>
                              Bien
                          </label>
                      </div>
                    </td>
                    <td>
                      <label for="">Deposito de recuperación refrigerante</label>
                      <div class="switch">
                        <label>
                              Llenar
                              <input type="checkbox" name="liq_refrigerante">
                              <span class="lever"></span>
                              Bien
                          </label>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>

              <blockquote class="blockquote bq-primary htext">PLUMAS LIMPIAPARABRISAS</blockquote>

              <div class="table-responsive">
                <table class="table">
                <div>
                    <!-- Material inline 1 -->
                    <label>Prueba de limpiaparabrisas realizada:</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="prueba_limp1" name="prueba_limp" value="si">
                        <label class="form-check-label" for="prueba_limp1">Sí</label>
                    </div>
                    <!-- Material inline 2 -->
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="prueba_limp2" name="prueba_limp" value="no">
                        <label class="form-check-label" for="prueba_limp2">No</label>
                    </div>
                    &nbsp;&nbsp;&nbsp;
                    <!-- Material inline 1 -->
                    <label>Cambiado:</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="plumaslimp_cambiado1" name="plumaslimp_cambiado" value="si">
                        <label class="form-check-label" for="plumaslimp_cambiado1">Sí</label>
                    </div>
                    <!-- Material inline 2 -->
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="plumaslimp_cambiado2" name="plumaslimp_cambiado" value="no">
                        <label class="form-check-label" for="plumaslimp_cambiado2">No</label>
                    </div>
                </div>
                  <tr>
    
                    <td>
                      <div class="form-inline">
                          <span>Plumas Limpiaparabrisas  </span>
                          <!-- Default checkbox -->
                          &nbsp; &nbsp; &nbsp; &nbsp; 
                          <div class="form-check mr-3 success-color">
                              <input class="form-check-input plma " type="radio" id="inlineFormCheckbox1" name="plumasok" value="si">
                              <label class="form-check-label" for="inlineFormCheckbox1" style="padding-right: 20px;">Verificado</label>
                          </div>
                          <!-- Filled-in checkbox -->
                          <div class="form-check mr-3 danger-color">
                              <input type="radio" class="form-check-input plma" id="inlineFormCheckbox2" name="plumasok" value="no">
                              <label class="form-check-label" for="inlineFormCheckbox2" style="padding-right: 20px;">Requiere Atención</label>
                          </div>
                      </div>
                               
                    </td>
                  </tr>
                </table>
              </div>
              <blockquote class="blockquote bq-primary htext">BATERIA</blockquote>
              <div class="table-responsive">
                  <table class="table">
                      <div>
                            <!-- Material inline 1 -->
                            <label>Cambiado:</label>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="bateria_cambiado1" name="bateria_cambiado" value="si">
                                <label class="form-check-label" for="bateria_cambiado1">Sí</label>
                            </div>
                            <!-- Material inline 2 -->
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="bateria_cambiado2" name="bateria_cambiado" value="no">
                                <label class="form-check-label" for="bateria_cambiado2">No</label>
                            </div>
                      </div>
                      <tbody>
                        <tr>
                                <td>
                                <div class="form-inline">
                                    <span>Nivel de Batería</span>
                                &nbsp; &nbsp; &nbsp; &nbsp; 
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-input" id="bateriabien" name="bateriabien" value="bateriabien">
                                        <label class="form-check-label" for="bateriabien" style="padding-right: 20px;">Bien</label>
                                    </div>
                            
                                    <div class="form-check form-check-inline warning-color">
                                        <input type="radio" class="form-check-input" id="bateriamedio" name="bateriabien" value="bateriamedio">
                                        <label class="form-check-label" for="bateriamedio" style="padding-right: 20px;">Requiere Atención</label>
                                    </div>
                              
                                <div class="form-check form-check-inline danger-color">
                                    <input type="radio" class="form-check-input" id="bateriamal" name="bateriabien" value="bateriamal">
                                    <label class="form-check-label" for="bateriamal" style="padding-right: 20px;">Requiere Reparación</label>
                                </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class=" ">
                                    <div class="col-3">
                                        <div class="md-form form-sm">
                                            <label for="corriente_fabrica" class="form-check-label">corriente de arranque en frío, especificaciones de fabrica</label>
                                            <input type="number" placeholder="CCA" class="form-check-inline" name="corriente_fabrica">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="md-form form-sm">
                                            <label for="corriente_real" class="form-check-inline">Corriente de arranque en frío real</label>
                                            <input type="number" placeholder="CCA" class="form-check-inline" name="corriente_real">
                                        </div>
                                    </div>
                                   <div class="col-3">
                                        <div class="md-form form-sm">
                                            <label for="nivel_carga" class="form-check-inline">Nivel de Carga</label>
                                            <input type="number" placeholder="%" class="form-check-inline" name="nivel_carga" min="1" max="100">
                                        </div>
                                   </div>
                                </div>
                                </td>
                        </tr>
                      </tbody>
                </table>
              </div>
              <blockquote class="blockquote bq-primary htext">SISTEMAS/COMPONENTES</blockquote>
              <div class="table-responsive">
                  <table class="table">
                      <tbody>
                           <tr>
                                <td> 
                                    <div class="form-check form-inline">
                                    <span>Funcionamiento del claxon, luces interiores, luces exteriores, luces de giro, luces de emergencia y freno.</span>
                                
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-inline" id="lucesydemasbien" name="lucesydemasbien" value="si">
                                        <label class="form-check-label" for="lucesydemasbien" style="padding-right: 20px;">SI</label>
                                    </div>
                                
                                    <div class="form-check form-check-inline danger-color">
                                        <input type="radio" class="form-check-inline" id="lucesydemasmal" name="lucesydemasbien" value="no">
                                        <label class="form-check-label" for="lucesydemasmal" style="padding-right: 20px;">NO</label>
                                    </div>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <!-- Material inline 1 -->
                                    <label>Cambiado:</label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="sistemas1_cambiado1" name="sistemas1_cambiado" value="si">
                                        <label class="form-check-label" for="sistemas1_cambiado1">Sí</label>
                                    </div>
                                    <!-- Material inline 2 -->
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="sistemas1_cambiado2" name="sistemas1_cambiado" value="no">
                                        <label class="form-check-label" for="sistemas1_cambiado2">No</label>
                                    </div>
                                </td>
                
                          </tr>
                          <tr>
                            <td>
                                <div class="form-check form-inline">
                                    <span>Grietas, roturas y picaduras en el parabrisas</span>
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-inline" id="parabrisasbien" name="parabrisasbien" value="si">
                                        <label class="form-check-label" for="parabrisasbien" style="padding-right: 20px;">SI</label>
                                    </div>
                                    <div class="form-check form-check-inline danger-color">
                                        <input type="radio" class="form-check-inline" id="parabrisasmal" name="parabrisasbien" value="no">
                                        <label class="form-check-label" for="parabrisasmal" style="padding-right: 20px;">NO</label>
                                    </div>
                                </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <!-- Material inline 1 -->
                                <label>Cambiado:</label>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="sistemas2_cambiado1" name="sistemas2_cambiado" value="si">
                                    <label class="form-check-label" for="sistemas2_cambiado1">Sí</label>
                                </div>
                                <!-- Material inline 2 -->
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="sistemas2_cambiado2" name="sistemas2_cambiado" value="no">
                                    <label class="form-check-label" for="sistemas2_cambiado2">No</label>
                                </div>
                            </td>
                  </tr>
                      </tbody>
                </table>
              </div>
              
             <blockquote class="blockquote bq-primary htext">Interiores (Opera)</blockquote>
              <div class="table-responsive">
                <table class="table">
                  <tbody>
                  <tr>
                    <div>
                    <td>
                      <span>Claxon</span>
                    </td>
                    <td>
                        <div class="form-check form-check-inline border">
                          <input type="radio" class="form-check-input" id="claxonok" name="claxonok" value="si">
                          <label class="form-check-label" for="claxonok" style="padding-right: 20px;">SI</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline border">
                          <input type="radio" class="form-check-input" id="claxonno" name="claxonok" value="no">
                          <label class="form-check-label" for="claxonno" style="padding-right: 20px;">NO</label>
                        </div>
                    </td>
                    <td> 
                        <div class="form-check form-check-inline border">
                          <input type="radio" class="form-check-input" id="claxonnc" name="claxonok" value="nc">
                          <label class="form-check-label" for="claxonnc" style="padding-right: 20px;">No cuenta</label>
                        </div>
                    </td>
                    </div>
                  </tr>
                <tr>
                    <div>
                    <td>
                    <span>Luces</span>
                    </td>
                    <td>
                        <div class="form-check form-check-inline border">
                          <input type="radio" class="form-check-input" id="lucesok" name="lucesok" value="si">
                          <label class="form-check-label" for="lucesok" style="padding-right: 20px;">Si</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline border">
                          <input type="radio" class="form-check-input" id="lucesno" name="lucesok" value="no">
                          <label class="form-check-label" for="lucesno" style="padding-right: 20px;">No</label>
                        </div>
                    </td>
                    <td> 
                        <div class="form-check form-check-inline border">
                          <input type="radio" class="form-check-input" id="lucesnc" name="lucesok" value="nc">
                          <label class="form-check-label" for="lucesnc" style="padding-right: 20px;">No cuenta</label>
                        </div>
                    </td>
                    </div>
                </tr>
            
                  <tr>
                    <td><span>Radio/Caratula</span></td>
                    <td>
                        <div class="form-check form-check-inline border">
                          <input type="radio" class="form-check-input" id="radiook" name="radiook" value="si">
                          <label class="form-check-label" for="radiook" style="padding-right: 20px;">Si</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline border">
                          <input type="radio" class="form-check-input" id="radiono" name="radiook" value="no">
                          <label class="form-check-label" for="radiono" style="padding-right: 20px;">No</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline border">
                          <input type="radio" class="form-check-input" id="radionc" name="radiook" value="nc">
                          <label class="form-check-label" for="radionc" style="padding-right: 20px;">No Cuenta</label>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td><span>Pantallas</span></td>
                    <td>
                      <div class="form-check form-check-inline border"> 
                        <input type="radio" class="form-check-input" id="pantallasi" name="pantallasi" value="si">
                          <label class="form-check-label" for="pantallasi" style="padding-right: 20px;">Si</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="pantallano" name="pantallasi" value="no">
                          <label class="form-check-label" for="pantallano" style="padding-right: 20px;">No</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="pantallanc" name="pantallasi" value="nc">
                          <label class="form-check-label" for="pantallanc" style="padding-right: 20px;">No Cuenta</label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><span>A/C</span></td>
                    <td>
                      <div class="form-check form-check-inline border"> 
                        <input type="radio" class="form-check-input" id="acsi" name="acsi" value="si">
                          <label class="form-check-label" for="acsi" style="padding-right: 20px;">Si</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="acno" name="acsi" value="no">
                          <label class="form-check-label" for="acno" style="padding-right: 20px;">No</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="acnc" name="acsi" value="nc">
                          <label class="form-check-label" for="acnc" style="padding-right: 20px;">No Cuenta</label>
                      </div>
                    </td>
                  </tr>
                <tr>
                    <td><span>Encendedor</span></td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="encendedorsi" name="encendedorsi" value="si">
                          <label class="form-check-label" for="encendedorsi" style="padding-right: 20px;">Si</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="encendedorno" name="encendedorsi" value="no">
                          <label class="form-check-label" for="encendedorno" style="padding-right: 20px;">No</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="encendedornc" name="encendedorsi" value="nc">
                          <label class="form-check-label" for="encendedornc" style="padding-right: 20px;">No Cuenta</label>
                      </div>
                    </td>
                  </tr>
                <tr><div>
                    <td><span>Vidrios</span></td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="vidriossi" name="vidriossi" value='si'>
                        <label class="form-check-label" for="vidriossi"  style="padding-right: 20px;">Si</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="vidriosno" name="vidriossi"  value ='no'>
                          <label class="form-check-label" for="vidriosno" style="padding-right: 20px;">No</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="vidriosnc" name="vidriossi" value='nc' >
                          <label class="form-check-label" for="vidriosnc" style="padding-right: 20px;">No Cuenta</label>
                      </div>
                    </td>
                  </div></tr>
                  <tr>
                    <td><span>Espejos</span></td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="espejossi" name="espejossi" value="si">
                          <label class="form-check-label" for="espejossi" style="padding-right: 20px;">Si</label>
                      </div>
                    </td>
                    <td>
                    <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="espejosno" name="espejossi" value="no">
                        <label class="form-check-label" for="espejosno" style="padding-right: 20px;">No</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="espejosnc" name="espejossi" value="nc">
                          <label class="form-check-label" for="espejosnc" style="padding-right: 20px;">No Cuenta</label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><span>Seguros Electrónicos</span></td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="segurosesi" name="segurosesi" value="si">
                          <label class="form-check-label" for="segurosesi" style="padding-right: 20px;">Si</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="seguroseno" name="segurosesi" value="no">
                          <label class="form-check-label" for="seguroseno" style="padding-right: 20px;">No</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="segurosenc" name="segurosesi" value="nc">
                          <label class="form-check-label" for="segurosenc" style="padding-right: 20px;">No Cuenta</label>
                      </div>
                    </td>
                  </tr>
                <tr>
                    <td><span>CD</span></td>                                                <!-- antes estaba como co -->
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="cosi" name="cosi" value="si">
                          <label class="form-check-label" for="cosi" style="padding-right: 20px;">Si</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="cono" name="cosi" value="no">
                          <label class="form-check-label" for="cono" style="padding-right: 20px;">No</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="conc" name="cosi" value="nc">
                          <label class="form-check-label" for="conc" style="padding-right: 20px;">No Cuenta</label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><span>Asientos y Vestiduras</span></td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="asientosvsi" name="asientosvsi" value="si">
                          <label class="form-check-label" for="asientosvsi" style="padding-right: 20px;">Si</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="asientosvno" name="asientosvsi" value="no">
                          <label class="form-check-label" for="asientosvno" style="padding-right: 20px;">No</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="asientosvnc" name="asientosvsi" value="nc">
                          <label class="form-check-label" for="asientosvnc" style="padding-right: 20px;">No Cuenta</label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><span>Tapetes</span></td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="tapetessi" name="tapetessi" value="si">
                          <label class="form-check-label" for="tapetessi" style="padding-right: 20px;">Si</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="tapetesno" name="tapetessi" value="no">
                          <label class="form-check-label" for="tapetesno" style="padding-right: 20px;">No</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline border">
                        <input type="radio" class="form-check-input" id="tapetesnc" name="tapetessi" value="nc">
                          <label class="form-check-label" for="tapetesnc" style="padding-right: 20px;">No Cuenta</label>
                      </div>
                    </td>
                  </tr>

                  </tbody>
                </table>
              </div>

        <blockquote class="blockquote bq-primary htext">Interiores Profeco (opera)</blockquote>
              <div class="table-responsive">
                <table class="table">
                  <tbody>
                      <tr>
                        <div>
                            <td>
                              <span>Instrumentos de tablero</span>
                            </td>
                            <td>
                                <div class="form-check form-check-inline border">
                                  <input type="radio" class="form-check-input" id="tableroSi" name="tableroVal" value="si">
                                  <label class="form-check-label" for="tableroSi" style="padding-right: 20px;">SI</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-check-inline border">
                                  <input type="radio" class="form-check-input" id="tableroNo" name="tableroVal" value="no" >
                                  <label class="form-check-label" for="tableroNo" style="padding-right: 20px;">NO</label>
                                </div>
                            </td>
                        </div>
                      </tr>
                    <tr>
                        <div>
                            <td>
                              <span>Espejo retrovisor</span>
                            </td>
                            <td>
                                <div class="form-check form-check-inline border">
                                  <input type="radio" class="form-check-input" id="retrovisorSi" name="retrovisorVal" value="si">
                                  <label class="form-check-label" for="retrovisorSi" style="padding-right: 20px;">SI</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-check-inline border">
                                  <input type="radio" class="form-check-input" id="retrovisorNo" name="retrovisorVal" value="no" >
                                  <label class="form-check-label" for="retrovisorNo" style="padding-right: 20px;">NO</label>
                                </div>
                            </td>
                        </div>
                  </tr>
                    <tr>
                        <div>
                            <td>
                              <span>Ceniceros</span>
                            </td>
                            <td>
                                <div class="form-check form-check-inline border">
                                  <input type="radio" class="form-check-input" id="ceniceroSi" name="ceniceroVal" value="si">
                                  <label class="form-check-label" for="ceniceroSi" style="padding-right: 20px;">SI</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-check-inline border">
                                  <input type="radio" class="form-check-input" id="ceniceroNo" name="ceniceroVal" value="no" >
                                  <label class="form-check-label" for="ceniceroNo" style="padding-right: 20px;">NO</label>
                                </div>
                            </td>
                        </div>
                  </tr>
                  <tr>
                        <div>
                            <td>
                              <span>Cinturones de seguridad</span>
                            </td>
                            <td>
                                <div class="form-check form-check-inline border">
                                  <input type="radio" class="form-check-input" id="cinturonSi" name="cinturonVal" value="si">
                                  <label class="form-check-label" for="cinturonSi" style="padding-right: 20px;">SI</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-check-inline border">
                                  <input type="radio" class="form-check-input" id="cinturonNo" name="cinturonVal" value="no" >
                                  <label class="form-check-label" for="cinturonNo" style="padding-right: 20px;">NO</label>
                                </div>
                            </td>
                        </div>
                  </tr>
                   <tr>
                        <div>
                            <td>
                              <span>Manijas y/o controles interiores</span>
                            </td>
                            <td>
                                <div class="form-check form-check-inline border">
                                  <input type="radio" class="form-check-input" id="manijasSi" name="manijasVal" value="si">
                                  <label class="form-check-label" for="manijasSi" style="padding-right: 20px;">SI</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-check-inline border">
                                  <input type="radio" class="form-check-input" id="manijasNo" name="manijasVal" value="no" >
                                  <label class="form-check-label" for="manijasNo" style="padding-right: 20px;">NO</label>
                                </div>
                            </td>
                        </div>
                  </tr>
                  </tbody>
                </table>
              </div> 

            <blockquote class="blockquote bq-primary htext">Condiciones generales</blockquote>
              <div class="table-responsive">
                <table class="table">
                  <tbody>
                      <tr>
                        <div>
                            <td>
                              <span>Aspectos mecanicos</span>
                            </td>
                            <td>
                                <div class="form-check form-check-inline border">
                                  <input type="radio" class="form-check-input" id="amRegulares" name="amecanicos" value="amRegulares">
                                  <label class="form-check-label" for="amRegulares" style="padding-right: 20px;">Regulares de uso</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-check-inline border">
                                  <input type="radio" class="form-check-input" id="amNoE" name="amecanicos" value="amNoE" >
                                  <label class="form-check-label" for="amNoE" style="padding-right: 20px;">No enciende</label>
                                </div>
                            </td>
                        </div>
                      </tr>
                     <tr>
                        <div>
                            <td>
                              <span>Aspectos de carroceria</span>
                            </td>
                            <td>
                                <div class="form-check form-check-inline border">
                                  <input type="radio" class="form-check-input" id="acRegulares" name="acarroceria" value="acRegulares">
                                  <label class="form-check-label" for="acRegulares" style="padding-right: 20px;">Regulares de uso</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-check-inline border">
                                  <input type="radio" class="form-check-input" id="acRayones" name="acarroceria" value="acRayones" >
                                  <label class="form-check-label" for="acRayones" style="padding-right: 20px;">Presenta rayones diversos</label>
                                </div>
                            </td>
                             <td>
                                <div class="form-check form-check-inline border">
                                  <input type="radio" class="form-check-input" id="acMalEdo" name="acarroceria" value="acMalEdo" >
                                  <label class="form-check-label" for="acMalEdo" style="padding-right: 20px;">Mal estado</label>
                                </div>
                            </td>
                        </div>
                     </tr>
                  </tbody>
                </table>
              </div> 

            <blockquote class="blockquote bq-primary htext">
                <div class="row">
                    <div class="col-2">Inferior</div>
                    <div class="col-3">¿Requiere revisión?</div>
                    <div class="col-6">
                        <div class="switch">
                            <label>
                              No
                              <input type="checkbox" name="reqRev_inferior">
                              <span class="lever"></span>
                              Sí
                            </label>
                        </div>
                    </div>
                </div>
            </blockquote>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <div>
                                <td>
                                  <span>Sistema de Escape</span>
                                </td>
                                <td>
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_sistEsc1" name="inf_sistEsc" value="bien">
                                      <label class="form-check-label" for="inf_sistEsc1" style="padding-right: 20px;">Bien</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_sistEsc2" name="inf_sistEsc" value="mal">
                                      <label class="form-check-label" for="inf_sistEsc2" style="padding-right: 20px;">Mal</label>
                                    </div>
                                </td>
                                <td> 
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_sistEsc3" name="inf_sistEsc" value="fuga">
                                      <label class="form-check-label" for="inf_sistEsc3" style="padding-right: 20px;">Fuga</label>
                                    </div>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div>
                                <td>
                                  <span>Amortiguadores</span>
                                </td>
                                <td>
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_amort1" name="inf_amort" value="bien">
                                      <label class="form-check-label" for="inf_amort1" style="padding-right: 20px;">Bien</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_amort2" name="inf_amort" value="mal">
                                      <label class="form-check-label" for="inf_amort2" style="padding-right: 20px;">Mal</label>
                                    </div>
                                </td>
                                <td> 
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_amort3" name="inf_amort" value="fuga">
                                      <label class="form-check-label" for="inf_amort3" style="padding-right: 20px;">Fuga</label>
                                    </div>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div>
                                <td>
                                  <span>Tuberías</span>
                                </td>
                                <td>
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_tuberias1" name="inf_tuberias" value="bien">
                                      <label class="form-check-label" for="inf_tuberias1" style="padding-right: 20px;">Bien</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_tuberias2" name="inf_tuberias" value="mal">
                                      <label class="form-check-label" for="inf_tuberias2" style="padding-right: 20px;">Mal</label>
                                    </div>
                                </td>
                                <td> 
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_tuberias3" name="inf_tuberias" value="fuga">
                                      <label class="form-check-label" for="inf_tuberias3" style="padding-right: 20px;">Fuga</label>
                                    </div>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div>
                                <td>
                                  <span>Transeje / Transmisión</span>
                                </td>
                                <td>
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_transeje_transm1" name="inf_transeje_transm" value="bien">
                                      <label class="form-check-label" for="inf_transeje_transm1" style="padding-right: 20px;">Bien</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_transeje_transm2" name="inf_transeje_transm" value="mal">
                                      <label class="form-check-label" for="inf_transeje_transm2" style="padding-right: 20px;">Mal</label>
                                    </div>
                                </td>
                                <td> 
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_transeje_transm3" name="inf_transeje_transm" value="fuga">
                                      <label class="form-check-label" for="inf_transeje_transm3" style="padding-right: 20px;">Fuga</label>
                                    </div>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div>
                                <td>
                                  <span>Sistema de Dirección</span>
                                </td>
                                <td>
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_sistDir1" name="inf_sistDir" value="bien">
                                      <label class="form-check-label" for="inf_sistDir1" style="padding-right: 20px;">Bien</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_sistDir2" name="inf_sistDir" value="mal">
                                      <label class="form-check-label" for="inf_sistDir2" style="padding-right: 20px;">Mal</label>
                                    </div>
                                </td>
                                <td> 
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_sistDir3" name="inf_sistDir" value="fuga">
                                      <label class="form-check-label" for="inf_sistDir3" style="padding-right: 20px;">Fuga</label>
                                    </div>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div>
                                <td>
                                  <span>Chasis sucio</span>
                                </td>
                                <td>
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_chasisSucio1" name="inf_chasisSucio" value="bien">
                                      <label class="form-check-label" for="inf_chasisSucio1" style="padding-right: 20px;">Bien</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_chasisSucio2" name="inf_chasisSucio" value="mal">
                                      <label class="form-check-label" for="inf_chasisSucio2" style="padding-right: 20px;">Mal</label>
                                    </div>
                                </td>
                                <td> 
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_chasisSucio3" name="inf_chasisSucio" value="fuga">
                                      <label class="form-check-label" for="inf_chasisSucio3" style="padding-right: 20px;">Fuga</label>
                                    </div>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div>
                                <td>
                                  <span>Golpes Especifico</span>
                                </td>
                                <td>
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_golpesEspecif1" name="inf_golpesEspecif" value="bien">
                                      <label class="form-check-label" for="inf_golpesEspecif1" style="padding-right: 20px;">Bien</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_golpesEspecif2" name="inf_golpesEspecif" value="mal">
                                      <label class="form-check-label" for="inf_golpesEspecif2" style="padding-right: 20px;">Mal</label>
                                    </div>
                                </td>
                                <td> 
                                    <div class="form-check form-check-inline border">
                                      <input type="radio" class="form-check-input" id="inf_golpesEspecif3" name="inf_golpesEspecif" value="fuga">
                                      <label class="form-check-label" for="inf_golpesEspecif3" style="padding-right: 20px;">Fuga</label>
                                    </div>
                                </td>
                            </div>
                        </tr>
                    </tbody>
                </table>
            </div>
            <blockquote class="blockquote bq-primary htext">
                <div class="row">
                    <div class="col-3">Sistema de Frenos</div>
                    <div class="col-3">¿Requiere revisión?</div>
                    <div class="col-6">
                        <div class="switch">
                            <label>
                              No
                              <input type="checkbox" name="reqRev_sistFrenos">
                              <span class="lever"></span>
                              Sí
                            </label>
                        </div>
                    </div>
                </div>
            </blockquote>
            <div class="row">
                <div class="col-2">
                    <div class="form-check form-check-inline success-color" style="width: 100%">
                        <span style="display: block;position: relative;left: 60px;font-size: 12px">Bien</span>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-check form-check-inline warning-color" style="width: 100%">
                        <span style="display: block;position: relative;left: 13px;font-size: 12px">Requiere Atención</span>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-check form-check-inline danger-color" style="width: 100%">
                        <span style="display: block;position: relative;left: 5px;font-size: 12px;">Requiere Reparación</span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                 <table class="table table-bordered table-striped table-hover animated fadeIn" id="tabla_danios">
                    <thead class="mdb-color primary-color" style="font-weight: bold; color:#fff;">
                        <tr>
                            <th><h6>Ruedas</h6></th>
                            <th><h6>Balata/Zapata</h6></th>
                            <th><h6>Disco/Tambor</h6></th>
                            <th><h6>Neumático</h6></th>
                        </tr>                                   
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <h6>Delantera Derecha</h6>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <div class="form-check form-check-inline danger-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_ddBalata3" name="sfrenos_ddBalata" value="reparacion">
                                        <label class="form-check-label" for="sfrenos_ddBalata3"></label>
                                    </div>                                   
                            
                                    <div class="form-check form-check-inline warning-color">
                                      <input type="radio" class="form-check-input" id="sfrenos_ddBalata2" name="sfrenos_ddBalata" value="atencion">
                                      <label class="form-check-label" for="sfrenos_ddBalata2"></label>
                                    </div>
                              
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_ddBalata1" name="sfrenos_ddBalata" value="bien">
                                        <label class="form-check-label" for="sfrenos_ddBalata1"></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <div class="form-check form-check-inline danger-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_ddDisco3" name="sfrenos_ddDisco" value="reparacion">
                                        <label class="form-check-label" for="sfrenos_ddDisco3"></label>
                                    </div>                                   
                            
                                    <div class="form-check form-check-inline warning-color">
                                      <input type="radio" class="form-check-input" id="sfrenos_ddDisco2" name="sfrenos_ddDisco" value="atencion">
                                      <label class="form-check-label" for="sfrenos_ddDisco2"></label>
                                    </div>
                              
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_ddDisco1" name="sfrenos_ddDisco" value="bien">
                                        <label class="form-check-label" for="sfrenos_ddDisco1"></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <div class="form-check form-check-inline danger-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_ddNeumat3" name="sfrenos_ddNeumat" value="reparacion">
                                        <label class="form-check-label" for="sfrenos_ddNeumat3"></label>
                                    </div>                                   
                            
                                    <div class="form-check form-check-inline warning-color">
                                      <input type="radio" class="form-check-input" id="sfrenos_ddNeumat2" name="sfrenos_ddNeumat" value="atencion">
                                      <label class="form-check-label" for="sfrenos_ddNeumat2"></label>
                                    </div>
                              
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_ddNeumat1" name="sfrenos_ddNeumat" value="bien">
                                        <label class="form-check-label" for="sfrenos_ddNeumat1"></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h6>Delantera Izquierda</h6>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <div class="form-check form-check-inline danger-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_diBalata3" name="sfrenos_diBalata" value="reparacion">
                                        <label class="form-check-label" for="sfrenos_diBalata3"></label>
                                    </div>                                   
                            
                                    <div class="form-check form-check-inline warning-color">
                                      <input type="radio" class="form-check-input" id="sfrenos_diBalata2" name="sfrenos_diBalata" value="atencion">
                                      <label class="form-check-label" for="sfrenos_diBalata2"></label>
                                    </div>
                              
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_diBalata1" name="sfrenos_diBalata" value="bien">
                                        <label class="form-check-label" for="sfrenos_diBalata1"></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <div class="form-check form-check-inline danger-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_diDisco3" name="sfrenos_diDisco" value="reparacion">
                                        <label class="form-check-label" for="sfrenos_diDisco3"></label>
                                    </div>                                   
                            
                                    <div class="form-check form-check-inline warning-color">
                                      <input type="radio" class="form-check-input" id="sfrenos_diDisco2" name="sfrenos_diDisco" value="atencion">
                                      <label class="form-check-label" for="sfrenos_diDisco2"></label>
                                    </div>
                              
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_diDisco1" name="sfrenos_diDisco" value="bien">
                                        <label class="form-check-label" for="sfrenos_diDisco1"></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <div class="form-check form-check-inline danger-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_diNeumat3" name="sfrenos_diNeumat" value="reparacion">
                                        <label class="form-check-label" for="sfrenos_diNeumat3"></label>
                                    </div>                                   
                            
                                    <div class="form-check form-check-inline warning-color">
                                      <input type="radio" class="form-check-input" id="sfrenos_diNeumat2" name="sfrenos_diNeumat" value="atencion">
                                      <label class="form-check-label" for="sfrenos_diNeumat2"></label>
                                    </div>
                              
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_diNeumat1" name="sfrenos_diNeumat" value="bien">
                                        <label class="form-check-label" for="sfrenos_diNeumat1"></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h6>Trasera Derecha</h6>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <div class="form-check form-check-inline danger-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_tdBalata3" name="sfrenos_tdBalata" value="reparacion">
                                        <label class="form-check-label" for="sfrenos_tdBalata3"></label>
                                    </div>                                   
                            
                                    <div class="form-check form-check-inline warning-color">
                                      <input type="radio" class="form-check-input" id="sfrenos_tdBalata2" name="sfrenos_tdBalata" value="atencion">
                                      <label class="form-check-label" for="sfrenos_tdBalata2"></label>
                                    </div>
                              
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_tdBalata1" name="sfrenos_tdBalata" value="bien">
                                        <label class="form-check-label" for="sfrenos_tdBalata1"></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <div class="form-check form-check-inline danger-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_tdDisco3" name="sfrenos_tdDisco" value="reparacion">
                                        <label class="form-check-label" for="sfrenos_tdDisco3"></label>
                                    </div>                                   
                            
                                    <div class="form-check form-check-inline warning-color">
                                      <input type="radio" class="form-check-input" id="sfrenos_tdDisco2" name="sfrenos_tdDisco" value="atencion">
                                      <label class="form-check-label" for="sfrenos_tdDisco2"></label>
                                    </div>
                              
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_tdDisco1" name="sfrenos_tdDisco" value="bien">
                                        <label class="form-check-label" for="sfrenos_tdDisco1"></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <div class="form-check form-check-inline danger-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_tdNeumat3" name="sfrenos_tdNeumat" value="reparacion">
                                        <label class="form-check-label" for="sfrenos_tdNeumat3"></label>
                                    </div>                                   
                            
                                    <div class="form-check form-check-inline warning-color">
                                      <input type="radio" class="form-check-input" id="sfrenos_tdNeumat2" name="sfrenos_tdNeumat" value="atencion">
                                      <label class="form-check-label" for="sfrenos_tdNeumat2"></label>
                                    </div>
                              
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_tdNeumat1" name="sfrenos_tdNeumat" value="bien">
                                        <label class="form-check-label" for="sfrenos_tdNeumat1"></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h6>Trasera Izquierda</h6>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <div class="form-check form-check-inline danger-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_tiBalata3" name="sfrenos_tiBalata" value="reparacion">
                                        <label class="form-check-label" for="sfrenos_tiBalata3"></label>
                                    </div>                                   
                            
                                    <div class="form-check form-check-inline warning-color">
                                      <input type="radio" class="form-check-input" id="sfrenos_tiBalata2" name="sfrenos_tiBalata" value="atencion">
                                      <label class="form-check-label" for="sfrenos_tiBalata2"></label>
                                    </div>
                              
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_tiBalata1" name="sfrenos_tiBalata" value="bien">
                                        <label class="form-check-label" for="sfrenos_tiBalata1"></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <div class="form-check form-check-inline danger-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_tiDisco3" name="sfrenos_tiDisco" value="reparacion">
                                        <label class="form-check-label" for="sfrenos_tiDisco3"></label>
                                    </div>                                   
                            
                                    <div class="form-check form-check-inline warning-color">
                                      <input type="radio" class="form-check-input" id="sfrenos_tiDisco2" name="sfrenos_tiDisco" value="atencion">
                                      <label class="form-check-label" for="sfrenos_tiDisco2"></label>
                                    </div>
                              
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_tiDisco1" name="sfrenos_tiDisco" value="bien">
                                        <label class="form-check-label" for="sfrenos_tiDisco1"></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <div class="form-check form-check-inline danger-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_tiNeumat3" name="sfrenos_tiNeumat" value="reparacion">
                                        <label class="form-check-label" for="sfrenos_tiNeumat3"></label>
                                    </div>                                   
                            
                                    <div class="form-check form-check-inline warning-color">
                                      <input type="radio" class="form-check-input" id="sfrenos_tiNeumat2" name="sfrenos_tiNeumat" value="atencion">
                                      <label class="form-check-label" for="sfrenos_tiNeumat2"></label>
                                    </div>
                              
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_tiNeumat1" name="sfrenos_tiNeumat" value="bien">
                                        <label class="form-check-label" for="sfrenos_tiNeumat1"></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h6>Refacción</h6>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="form-inline">
                                    <div class="form-check form-check-inline danger-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_refNeumat3" name="sfrenos_refNeumat" value="reparacion">
                                        <label class="form-check-label" for="sfrenos_refNeumat3"></label>
                                    </div>                                   
                            
                                    <div class="form-check form-check-inline warning-color">
                                      <input type="radio" class="form-check-input" id="sfrenos_refNeumat2" name="sfrenos_refNeumat" value="atencion">
                                      <label class="form-check-label" for="sfrenos_refNeumat2"></label>
                                    </div>
                              
                                    <div class="form-check form-check-inline success-color">
                                        <input type="radio" class="form-check-input" id="sfrenos_refNeumat1" name="sfrenos_refNeumat" value="bien">
                                        <label class="form-check-label" for="sfrenos_refNeumat1"></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                 </table> 
            </div> 
        </div>
    </div>
      <!-- Third Step -->
    <div class="row setup-content-2" id="step-3">
              <div class="col-md-12">
                  <br>
                  <h5 style="color: #4285f4;"><center><b>Paso 3: Fotos</b></center></h5>
                  <br>
                  <h3 class="font-weight-bold pl-0 my-4"><strong>Registro de Daños</strong></h3>
                  <div class="col-12">
                    <div class="col-6 danios">
                        <label for="existen_danios">¿Existen Daños?</label>
                          <div class="switch div_switchDanios">
                            <label>
                                  No
                                  <input type="checkbox" name="existen_danios" id="existen_danios">
                                  <span class="lever success"></span>
                                  Sí
                            </label>
                        </div>
                    </div>
                  </div>
                  <div class="row">                      
                      <div class="col-4">
                        <div style="height: 63px;"></div>
                        <div class="table-responsive">                                          <!-- tabla daños -->
                            <table class="table table-bordered table-striped table-hover animated fadeIn" id="tabla_danios">
                                <thead class="mdb-color primary-color" style="font-weight: bold; color:#fff;">
                                    <tr>
                                        <th colspan="2">
                                            <center>
                                                <h6>Tabla Daños</h6>
                                            </center>
                                        </th>
                                    </tr>                                   
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Costado Derecho</th>
                                        <th>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-tablaDanios" name="dan_costDerecho" id="dan_costDerecho">
                                                <label class="form-check-label" for="dan_costDerecho"></label>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Parte Delantera</th>
                                        <th>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-tablaDanios" name="dan_parteDel" id="dan_parteDel">
                                                <label class="form-check-label" for="dan_parteDel"></label>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Interior, asientos, alfombra</th>
                                        <th>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-tablaDanios" name="dan_intAsAlf" id="dan_intAsAlf">
                                                <label class="form-check-label" for="dan_intAsAlf"></label>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Costado Izquierdo</th>
                                        <th>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-tablaDanios" name="dan_costIzq" id="dan_costIzq">
                                                <label class="form-check-label" for="dan_costIzq"></label>
                                            </div>
                                        </th>
                                    </tr> 
                                    <tr>
                                        <th>Parte Trasera</th>
                                        <th>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-tablaDanios" name="dan_parteTras" id="dan_parteTras">
                                                <label class="form-check-label" for="dan_parteTras"></label>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Cristales y Faros</th>
                                        <th>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-tablaDanios" name="dan_cristFaros" id="dan_cristFaros">
                                                <label class="form-check-label" for="dan_cristFaros"></label>
                                            </div>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                      </div>
                      <div class="col-8">
                        <input type="hidden" name="img_insp" id="img_insp">
                        <div style="overflow: hidden; margin-bottom: 5px;">
                            <div class="column-right">
                                <strong>Tipo de Daño:</strong>
                                <a class="btn btn-danger" href="#" onclick='$("#canvasid").data("jqScribble").update({brush: CircleBrush, brushColor: "#ff3547"});'>Golpes (Ο)</a>
                                <a class="btn btn-success" href="#" onclick='$("#canvasid").data("jqScribble").update({brush: CrossBrush, brushColor: "#00e25b"});'>Roto / estrellado (X)</a>
                                <a class="btn btn-info" href="#" onclick='$("#canvasid").data("jqScribble").update({brush: LineBrush, brushColor: "#4abde8"});'>Rayones (\)</a>
                            </div>
                        </div>
                        <!--  canvasid imagen para marcar daños -->
                        <div class="canvas" id="canvasid" style="border: 3px solid;"></div>
                        <div class="links float-right" style="margin-top: 5px;">
                            <button class="btn btn-danger" id="btn_resetImgInsp">Reiniciar Imagen</button>
                        </div>
                      </div>
                  </div>
                <input type="file" name="pic" id="pic"  style="display:none;" />
              </div>
            <section>
                <!-- fotos y video -->
                <div class="fixed-action-btn" style="bottom: 60px; right: 24px;">
                    <a class="btn-floating btn-lg red waves-effect waves-light">
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="list-unstyled">
                        <li>
                            <a class="btn-floating red waves-effect waves-light" id="mostrar_modalfotos"><i class="fa fa-camera"></i></a>
                        </li>
                       <!--  <li>
                            <a class="btn-floating green waves-effect waves-light" id="mostrar_modalsonido"><i class="fa fa-microphone" aria-hidden="true"></i></a>
                        </li> -->
                    </ul>
                </div>
            </section>
        </div>
      <!-- Third Step -->
    <div class="row setup-content-2" id="step-4">
            <div class="col-md-12">
                  <br>
                  <h5 style="color: #4285f4;"><center><b>Paso 4: Audios</b></center></h5>
                  <br>
                  <h3 class="font-weight-bold pl-0 my-4"><strong>Voz del cliente</strong></h3>
                  <div class="col-12">
                    <div class="col-6 voz">
                        <label for="autorizacion_voz">Autorización para grabar voz?</label>
                          <div class="switch div_switchvoz">
                            <label>
                                  No
                                  <input type="checkbox" name="autorizacion_voz" id="autorizacion_voz">
                                  <span class="lever success"></span>
                                  Sí
                            </label>
                        </div>
                    </div>
                  </div>
                <div class="row">                      
                    <div class="col-6">
                        <blockquote class="blockquote bq-primary htext">Identificación de necesidades de servicio</blockquote>
                        <div class="form-check">
                            <label for="">Definición de falla</label>
                            <input class="form-control" type="text" row="20" name="articulos_personales">
                        </div>
                    </div>
                    <div class="col-6">
                        <blockquote class="blockquote bq-primary htext">Condiciones Ambientales</blockquote>
                        <div class="form-check">
                            <label class="form-check-label" for="temperatura">Temperatura ambiente</label>
                            <input type="range" list="temperatura" class="form-check-input">
                            <datalist id="temperatura">
                                <option value="-10" label="-10°C">
                                <option value="0" label="0°C">
                                <option value="10" label="10°C">
                                <option value="20" label="20°C">
                                <option value="30" label="30°C">
                                <option value="40" label="40°C">
                                <option value="50" label="50°C">
                                <option value="60" label="60°C">
                            </datalist>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="">Húmedad</label><br>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="humedadSeco" name="humedad" value="seco" checked>
                                  <label class="form-check-label" for="humedadSeco">Seco</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="humedadHumedo" name="humedad" value="húmedo" checked>
                                  <label class="form-check-label" for="humedadHumedo">Húmedo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="humedadMojado" name="humedad" value="mojado" checked>
                                  <label class="form-check-label" for="humedadMojado">Mojado</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="humedadLluvia" name="humedad" value="lluvia" checked>
                                  <label class="form-check-label" for="humedadLluvia">Lluvia</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="humedadHielo" name="humedad" value="hielo" checked>
                                  <label class="form-check-label" for="humedadHielo">Hielo</label>
                                </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="">Viento</label><br>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="vientoLigero" name="viento" value="ligero" checked>
                                  <label class="form-check-label" for="vientoLigero">Ligero</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="vientoMedio" name="viento" value="medio" checked>
                                  <label class="form-check-label" for="vientoMedio">Medio</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="vientoFuerte" name="viento" value="fuerte" checked>
                                  <label class="form-check-label" for="vientoFuerte">Fuerte</label>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="row">                      
                    <div class="col-6">
                        <div class="table-responsive">                                          <!-- tabla fallas cuando -->
                            <table class="table table-bordered table-striped table-hover animated fadeIn" id="tabla_falla_presenta">
                                <thead class="mdb-color primary-color" style="font-weight: bold; color:#fff;">
                                    <tr>
                                        <th colspan="2">
                                            <center>
                                                <h6>La falla se presenta cuando:</h6>
                                            </center>
                                        </th>
                                    </tr>                                   
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Arranca el vehículo</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_presenta" name="falla_arranca" id="falla_arranca">
                                                <label class="form-check-label" for="falla_arranca"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Inicia movimiento</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_presenta" name="falla_inicia" id="falla_inicia">
                                                <label class="form-check-label" for="falla_inicia"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Disminuye la velocidad</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_presenta" name="falla_disminuye_vel" id="falla_disminuye_vel">
                                                <label class="form-check-label" for="falla_disminuye_vel"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Da vuelta a la izquiera</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_presenta" name="falla_vuelta_izq" id="falla_vuelta_izq">
                                                <label class="form-check-label" for="falla_vuelta_izq"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Da vuelta a la derecha</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_presenta" name="falla_vuelta_der" id="falla_vuelta_der">
                                                <label class="form-check-label" for="falla_vuelta_der"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pasa un tope</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_presenta" name="falla_pasa_tope" id="falla_pasa_tope">
                                                <label class="form-check-label" for="falla_pasa_tope"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pasa un bache</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_presenta" name="falla_pasa_bache" id="falla_pasa_bache">
                                                <label class="form-check-label" for="falla_pasa_bache"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cambia la velocidad</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_presenta" name="falla_cambia_vel" id="falla_cambia_vel">
                                                <label class="form-check-label" for="falla_cambia_vel"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Está sin movimiento</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_presenta" name="falla_sin_movimiento" id="falla_sin_movimiento">
                                                <label class="form-check-label" for="falla_sin_movimiento"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Constantemente</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_presenta" name="falla_constantemente" id="falla_constantemente">
                                                <label class="form-check-label" for="falla_constantemente"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Esporádicamente</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_presenta" name="falla_esporadicamente" id="falla_esporadicamente">
                                                <label class="form-check-label" for="falla_esporadicamente"></label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">                                          <!-- tabla fallas cuando -->
                            <table class="table table-bordered table-striped table-hover animated fadeIn" id="tabla_falla_presenta">
                                <thead class="mdb-color primary-color" style="font-weight: bold; color:#fff;">
                                    <tr>
                                        <th colspan="4">
                                            <center>
                                                <h6>La falla se percibe en:</h6>
                                            </center>
                                        </th>
                                    </tr>                                   
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Volante</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_percibe" name="falla_volante" id="falla_volante">
                                                <label class="form-check-label" for="falla_volante"></label>
                                            </div>
                                        </td>
                                        <td>Cofre</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_percibe" name="falla_cofre" id="falla_cofre">
                                                <label class="form-check-label" for="falla_cofre"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Asiento</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_percibe" name="falla_asiento" id="falla_asiento">
                                                <label class="form-check-label" for="falla_asiento"></label>
                                            </div>
                                        </td>
                                        <td>Cajuela</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_percibe" name="falla_cajuela" id="falla_cajuela">
                                                <label class="form-check-label" for="falla_cajuela"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cristales</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_percibe" name="falla_cristales" id="falla_cristales">
                                                <label class="form-check-label" for="falla_cristales"></label>
                                            </div>
                                        </td>
                                        <td>Toldo</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_percibe" name="falla_toldo" id="falla_toldo">
                                                <label class="form-check-label" for="falla_toldo"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Carrocería</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_percibe" name="falla_carroceria" id="falla_carroceria">
                                                <label class="form-check-label" for="falla_carroceria"></label>
                                            </div>
                                        </td>
                                        <td>Debajo del vehículo</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input check-falla_percibe" name="falla_debajo_vehiculo" id="falla_debajo_vehiculo">
                                                <label class="form-check-label" for="falla_debajo_vehiculo"></label>
                                            </div>
                                        </td>
                                    </tr>
                                        <td>Estando</td>
                                        <td colspan="4">
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input check-falla_percibe" name="falla_dentro" id="falla_dentro">
                                                <label class="form-check-label" for="falla_dentro">Dentro</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input check-falla_percibe" name="falla_fuera" id="falla_fuera">
                                                <label class="form-check-label" for="falla_fuera">Fuera</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input check-falla_percibe" name="falla_frente" id="falla_frente">
                                                <label class="form-check-label" for="falla_frente">Frente</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input check-falla_percibe" name="falla_detras" id="falla_detras">
                                                <label class="form-check-label" for="falla_detras">Detrás</label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-6">
                        <blockquote class="blockquote bq-primary htext">Condiciones Operativas</blockquote>
                        <div class="form-check">
                            <label class="form-check-label" for="velocidad">Velocidad Km/hr</label>
                            <input type="range" min="0" max="260" list="velocidad" class="form-check-input">
                            <datalist id="velocidad">
                                <option value="0" label="0">
                                <option value="20" label="20">
                                <option value="40" label="40">
                                <option value="60" label="60">
                                <option value="80" label="80">
                                <option value="100" label="100">
                                <option value="120" label="120">
                                <option value="140" label="140">
                                <option value="160" label="160">
                                <option value="180" label="180">
                                <option value="200" label="200">
                                <option value="220" label="220">
                                <option value="240" label="240">
                                <option value="260" label="260">
                            </datalist>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="">Cambio transmisión</label>
                            <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="cambioTransmisionR" name="cambioTransmision" value="r" checked>
                                  <label class="form-check-label" for="cambioTransmisionR">R</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="cambioTransmision1" name="cambioTransmision" value="1" checked>
                                  <label class="form-check-label" for="cambioTransmision1">1</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="cambioTransmision2" name="cambioTransmision" value="2" checked>
                                  <label class="form-check-label" for="cambioTransmision2">2</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="cambioTransmision3" name="cambioTransmision" value="3" checked>
                                  <label class="form-check-label" for="cambioTransmision3">3</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="cambioTransmision4" name="cambioTransmision" value="4" checked>
                                  <label class="form-check-label" for="cambioTransmision4">4</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="cambioTransmision5" name="cambioTransmision" value="5" checked>
                                  <label class="form-check-label" for="cambioTransmision5">5</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="cambioTransmision6" name="cambioTransmision" value="6" checked>
                                  <label class="form-check-label" for="cambioTransmision6">6</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input check-4x2" name="cambioTransmision4x2" id="cambioTransmision4x2">
                                   <label class="form-check-label" for="cambioTransmision4x2">4x2</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input check-4x4" name="cambioTransmision4x4" id="cambioTransmision4x4">
                                   <label class="form-check-label" for="cambioTransmision4x4">4x4</label>
                                </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="rpm">Rpm x1000</label>
                            <input type="range" min="1" max="8" list="rpm" class="form-check-input">
                            <datalist id="rpm">
                                <option value="1" label="1">
                                <option value="2" label="2">
                                <option value="3" label="3">
                                <option value="4" label="4">
                                <option value="5" label="5">
                                <option value="6" label="6">
                                <option value="7" label="7">
                                <option value="8" label="8">
                            </datalist>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="carga">Carga</label>
                            <input type="range" min="0" max="100" list="carga" class="form-check-input">
                            <datalist id="carga">
                                <option value="0" label="0%">
                                <option value="25" label="25%">
                                <option value="50%" label="50%">
                                <option value="75%" label="75%">
                                <option value="100" label="100%">
                                <option value="101" label="+Remolque">
                            </datalist>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="pasajeros">Pasajeros</label>
                            <input type="range" min="1" max="9" list="pasajeros" class="form-check-input">
                            <datalist id="pasajeros">
                                <option value="1" label="1">
                                <option value="2" label="2">
                                <option value="3" label="3">
                                <option value="4" label="4">
                                <option value="5" label="5">
                                <option value="6" label="6">
                                <option value="7" label="7">
                                <option value="8" label="8">
                                <option value="9" label="9">
                            </datalist>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="cajuela">Cajuela</label>
                            <input type="range" min="0" max="100" list="cajuela" class="form-check-input">
                            <datalist id="cajuela">
                                <option value="0" label="0%">
                                <option value="25" label="25%">
                                <option value="50%" label="50%">
                                <option value="75%" label="75%">
                                <option value="100" label="100%">
                            </datalist>
                        </div><br>
                        <blockquote class="blockquote bq-primary htext">Condiciones del Camino</blockquote>
                        <div class="form-check">
                            <label class="form-check-label" for="">Estructura</label><br>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="estructuraPlano" name="estructura" value="plano" checked>
                                  <label class="form-check-label" for="estructuraPlano">Plano</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="estructuraVado" name="estructura" value="vado" checked>
                                  <label class="form-check-label" for="estructuraVado">Vado</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="estructuraTope" name="estructura" value="tope" checked>
                                  <label class="form-check-label" for="estructuraTope">Tope</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="estructuraTope" name="estructura" value="tope" checked>
                                  <label class="form-check-label" for="estructuraTope">Tope</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="estructuraBaches" name="estructura" value="Baches" checked>
                                  <label class="form-check-label" for="estructuraBaches">Baches</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="estructuraVibradores" name="estructura" value="Vibradores" checked>
                                  <label class="form-check-label" for="estructuraVibradores">Vibradores</label>
                                </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="">Camino</label><br>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="caminoRecto" name="camino" value="recto" checked>
                                  <label class="form-check-label" for="caminoRecto">Recto</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="caminoCurvaLigera" name="camino" value="curva ligera" checked>
                                  <label class="form-check-label" for="caminoCurvaLigera">Curva ligera</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="caminoCurvaCerrada" name="camino" value="curva cerrada" checked>
                                  <label class="form-check-label" for="caminoCurvaCerrada">Curva cerrada</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="caminoCurvaSinuoso" name="camino" value="curva sinuoso" checked>
                                  <label class="form-check-label" for="caminoCurvaSinuoso">Sinuoso</label>
                                </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="">Pendiente</label><br>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="caminoRecto" name="pendiente" value="recto" checked>
                                  <label class="form-check-label" for="pendienteRecto">Recto</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="pendienteLigera" name="pendiente" value="pendeinte ligera" checked>
                                  <label class="form-check-label" for="pendienteLigera">Pendiente ligera 10°</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="pendienteMediana" name="pendiente" value="pendiente mediana" checked>
                                  <label class="form-check-label" for="pendienteMediana">Pendiente mediana</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" id="pendienteMontania" name="pendiente" value="Pendiente Montaña" checked>
                                  <label class="form-check-label" for="pendienteMontania">Pendiente Motaña</label>
                                </div>
                        </div>
                    </div>
                </div>
                <input type="file" name="pic" id="pic"  style="display:none;" />
            </div>
            <section>
                <!-- fotos y video -->
                <div class="fixed-action-btn" style="bottom: 60px; right: 24px;">
                    <a class="btn-floating btn-lg red waves-effect waves-light">
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="list-unstyled">
                        <li>
                            <a class="btn-floating red waves-effect waves-light" id="mostrar_modalsonido"><i class="fa fa-file-audio"></i></a>
                        </li>
                        <li>
                            <a class="btn-floating green waves-effect waves-light" id="add_causa_raiz"><i class="fa fa-copy"></i></a>
                        </li>
                       <!--  <li>
                            <a class="btn-floating green waves-effect waves-light" id="mostrar_modalsonido"><i class="fa fa-microphone" aria-hidden="true"></i></a>
                        </li> -->
                    </ul>
                </div>
            </section>
        </div>
        <?php
            echo form_close();
        ?>
                <div class="col-sm-12">                  
                    <a class="btn btn-success float-right" id="btn_guardarInspeccion">Guardar Inspección</a>
                </div>
            </div>
        </div>
        <!-- ir hacia arriba -->
        <div class="fixed-action-btn smooth-scroll" style="bottom: 0px; right: 30px;">
            <a href="#top-section" class="btn-floating btn-large" style="background: #0d47a1;">
                <i class="fa fa-arrow-up"></i>
            </a>
        </div>
    </div>
    <div class="modal-footer d-flex justify-content-center" style="padding-top: 0px;">
        <a id="ok_after" class="btn dark-primary-color animated fadeIn ">Anterior</a>

        <a id="ok_next" class="btn dark-primary-color animated fadeIn">Siguiente</a>
        <a id="ok_after2" class="btn dark-primary-color animated fadeIn ">Anterior</a>
        <a id="ok_nextwo" class="btn dark-primary-color animated fadeIn">Siguiente</a>
        <a id="btn_inicio" href="<?=base_url();?>" class="btn info-color animated fadeIn">Regresar al Inicio</a>
    </div>

<?php 
    echo form_close();
?>
<!-- modal busqueda paquetes -->
<div class="modal fade" id="modalbusqpaq" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Paquetes de Servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="" class="grey-text">Articulo</label>
                                    <input class="form-control form-control-sm" id="busq_arti" readonly="true" type="text">
                                </div>
                                <div class="col">  
                                    <label for="" class="grey-text">Modelo</label>
                                    <input class="form-control form-control-sm" id="busq_model" readonly="true" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                 <input class="form-control" type="text" id="busquedapaq" onkeyup="mySearch2()" placeholder="Buscar por Descripcion">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7">
                                <h5>Paquetes Disponibles</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover animated fadeIn" id="table_paq">
                                        <thead class="mdb-color primary-color" style="font-weight: bold; color:#fff;">
                                            <tr>
                                                <th>ID</th>
                                                <th>Paquete</th>
                                                <th>Descripcion</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="col-5">
                                <h5>Detalles</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover animated fadeIn" id="tabla_detalle">
                                        <thead class="mdb-color primary-color" style="font-weight: bold; color:#fff;">
                                            <tr>
                                                <th>Articulo</th>
                                                <th>Descripcion</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="precio_paq" class="grey-text">Precio</label> 
                                    <input type="text" class="form-control form-control-sm" name="precio_paq" id="preciopaquete" readonly="true">
                                    <label for="tipo_precio" class="grey-text">Tipo</label>
                                    <input type="text" class="form-control form-control-sm" name="tipo_precio" id="tipodepreciopaquete" readonly="true">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!-- <button type="button" class="btn btn-primary">Seleccionar</button> -->
            </div>
        </div>
    </div>
</div>
<!-- modal busqueda M.O. -->
<div class="modal fade" id="modalmanodeobra" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buscar Articulo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <input class="form-control" type="text" id="busquedamano" onkeyup="mySearch()" placeholder="Buscar por Descripcion">
                                <table class="table table-bordered table-striped table-hover animated fadeIn" id="table_manos">
                                    <thead class="mdb-color primary-color" style="font-weight: bold; color:#fff;">
                                        <tr>
                                            <th>Articulo</th>
                                            <th>Descripcion</th>
                                            <th>Precio</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <br>
                            <div class="loader loader5" id="spinner">
                              <svg width="40px" height="40px" viewBox="0 0 40 40" fill="transparent">
                                <circle cx="20" cy="20" r="4" stroke="#1976D2"/>
                              </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Seleccionar</button>
                </div>
            </div>
    </div>
</div>
<!-- modal busqueda articulos -->
<div class="modal fade" id="modalbusqarts" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buscar Articulo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4 ui-front">
                                        <input type="hidden" name="input_claveArt" id="input_claveArt">
                                        <input class="form-control" type="text" id="ajax_arts" placeholder="Buscar Artículo">
                                        <!-- <datalist id="json-datalist-art"></datalist> -->
                                    </div>
                                    <div class="col-sm-1">
                                        <label for="input_precio">Precio:</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input class="form-control" type="text" id="input_precio" name="input_precio">
                                    </div>
                                    <div class="col-sm-1">
                                        <label for="input_cantidad">Cantidad:</label>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control" id="input_cantidad" name="input_cantidad" value="1">
                                    </div>
                                    <div class="col-sm-1">
                                        <label for="input_stock">Stock:</label>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="input_stock" name="input_stock" value="0" readonly="true">
                                    </div>
                                    <div class="col-sm-1">
                                        <button class="btn btn-success float-right" id="boton_agregarArt"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                             <br>
                            <div class="loader loader5" id="spinner">
                              <svg width="40px" height="40px" viewBox="0 0 40 40" fill="transparent">
                                <circle cx="20" cy="20" r="4" stroke="#1976D2"/>
                              </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
<!--                     <button type="button" class="btn btn-primary">Seleccionar</button> -->
                </div>
            </div>
    </div>
</div>
<!-- modal configuracion firma -->
<div class="modal fade" id="modalfirma" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Firma del Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $this->load->view("firma_configuracion");?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
    </div>
</div>
<!-- modal Campañas //lo nuevo para campañas-->
<div class="modal fade" id="modalcamp" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Campañas Disponibles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Asunto</th>
                                <th>Problema</th>
                                <th>Vigencia</th>
                                <th>Prioridad</th>
                            </tr>
                        </thead>
                        <tbody id="tbodycamp">
                            
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
    </div>
</div>

<!-- modal capturar fotos-->
<div class="modal fade" id="modalfotos" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Capturar Fotos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $this->load->view("capturar_fotos");?>
                </div>
                <div class="modal-footer">
                    <h5 style="color: #4285f4;"><center><b> <div id ='totalFots'></div> </b></center></h5>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
    </div>
</div>
<!-- modal capturar sonido-->
<div class="modal fade" id="modalsonido" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-sm"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Capturar Audio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $this->load->view("capturar_audio");?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
    </div>
</div>
<!-- modal send email -->
<div class="modal fade" id="modalsendmail" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-sm"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enviar Orden Por Correo</h5>
                </div>
                <div class="modal-body">
                    <p><i>Se enviará una copia de la Orden con los servicios requeridos.</i></p>
                    <input type="email" class="form-control" id="email_envio">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <a  class="btn btn-primary" id="send_mail">Enviar</a>
                </div>
            </div>
    </div>
</div>
<!--Modal Ordenes-->
<div id="modalOrdenes" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ordenes de Servicio - VIN: <strong><?=$vin?></strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBodyO">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- modal oasis -->
<div class="modal fade" id="modaloasis" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-sm"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Oasis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $this->load->view("cargar_oasis");?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
    </div>
</div>
<!--Modal Oasis-->
<!-- <div id="ModalGoasis" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">GOASIS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBodyO">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div> -->
<!-- Genera el formato de orden servicio -->
<iframe src="" id="iframe_correo" style="width: 100%; height: 0px; border: none;"></iframe>
<input type="hidden" id="url_correo" value="<?=site_url().'servicio/mensaje'?>">
<iframe src="" id="iframe_formato" style="width: 100%; height: 0px; border: none;"></iframe>
<input type="hidden" id="url_formato" value="<?=site_url().'servicio/correo'?>">
<iframe src="" id="iframe_reversoformato" style="width: 100%; height: 0px; border: none;"></iframe>
<input type="hidden" id="url_reversoformato" value="<?=site_url().'servicio/correo_reverso'?>">
<!-- Multipuntos -->
<iframe src="" id="iframe_formato_multipunto" style="width: 100%; height: 0px; border: none;"></iframe>
<input type="hidden" id="url_formato_multipunto" value="<?=site_url().'servicio/ver_hojaMultipuntos'?>">
<!-- Formato de Inventario -->
<iframe src="" id="iframe_inventario" style="width: 100%; height: 0px; border: none;"></iframe>
<input type="hidden" id="url_inventario" value="<?=site_url().'servicio/generar_formatoInventario/1'?>">
<script>

$(document).ready(function() {
    var id_orden = localStorage.getItem("id_orden_servicio");

    $("#id_orden").val(id_orden);

    $( "#slider-range-max" ).slider({
          range: "max",
          min: 1,
          max: 8,
          value: 4,
          slide: function( event, ui ) {
            $( "#amount" ).val( ui.value );
          }
    });
    $( "#amount" ).val( $( "#slider-range-max" ).slider( "value" ) );
    
    // busqueda articulo 
    $("#ajax_arts").autocomplete({
            source: function(request, response) {
                filtro = $("#tipoprecio_cliente").val();
                $.ajax({
                    cache: false,
                    url: base_url+"index.php/buscador/buscar_art",
                    data:  {term : request.term , li: filtro },
                    dataType: "json",
                beforeSend: function(){
                    $('#spinner').show();
                },
                complete: function(){
                    $('#spinner').hide();                       
                },
                success: function(data) {
                    if(data.length == 0){
                            swal({
                                title: 'No se encontraron coincidencias',
                                    icon: "error"
                                });
                    }

                    response( $.map( data, function( item ) {
                        // console.log(item);
                        return {
                        label: item.art+' -- '+ item.clave_art,
                        value: item.art,
                        precio: item.descrip,
                        clave_art: item.clave_art,
                        stock:item.stock
                        }
                    }));
                },
                error : function(xhr, status) {
                    alert('Disculpe, existió un problema');
                }
            });
        },
        minLength: 3
    });
    
    $("#ajax_arts").on("autocompleteselect", function(event, ui){
        $("#input_precio").val(ui.item.precio);
        $("#input_claveArt").val(ui.item.clave_art);
        $("#input_stock").val(ui.item.stock);
    });
    var person = $("#us_seleccionado").val();
    if(person != 0 && person != '' ){
        $("#boton_OrdenesVin").show();
        // console.log()
    }
    $("#boton_OrdenesVin").on('click', function(e){
        e.preventDefault();
        buscar_OrdenesVin();
    });
    function buscar_OrdenesVin(){
        var vinO = $("#vin").val();
        // console.log(vinO);
        $.ajax({
            cache: false,
            url: site_url+"buscador/buscar_OrdenesVin",
            type: 'POST',
            data:{vin:vinO},
            success: function(data) {
                data = eval("("+data+")");
                if(data.bandera == true)
                {
                    print_tables(data.datos);
                    
                }else
                {
                    $.alert({
                        title: 'No hay info',
                        content: 'No se encontraron datos para este vin',
                        theme: 'material'
                    });
                }
            }, 
            error: function( ){
                $.alert({
                    title: 'Hubo un error al buscar las ordenes',
                    content: 'Por favor, intente de nuevo',
                    theme: 'material'
                });
            }
        });
    }
    function print_tables(data){
        $("#modalBodyO").empty();
        $.each(data, function(key, value){
            if(value.FechaFacturacion != null && value.FechaFacturacion != ''){
                var fecha =  value.FechaFacturacion.split(' ', 2);
                var fecha2 =  fecha[0].split('-',3);
                fecha = fecha2[2]+"/"+fecha2[1]+"/"+fecha2[0];
            }else fecha = '-';
            var table = $("<table class='table' id='tableOrdenes'></table>");
            var thead = $("<thead class='ironBlue white-text'></thead>");
            var trow = $("<tr></tr>");
            var th = $("<th>Tipo</th><th>Orden</th><th>Fecha de Facturación</th><th>Asesor</th><th>Tipo Orden</th><th>Kilometraje</th><th>Estatus</th>");
            trow.append(th);
            thead.append(trow);
            table.append(thead);
            var tbody = $("<tbody></tbody>");
            var trow2 = $("<tr class='grey lighten-2'></tr>");
            var orden = (value.Orden == null)?'-':value.Orden;
            var th2 = $("<th>"+value.tipo+"</th><th >"+orden+"</th><th>"+fecha+"</th><th>"+value.NombreAgente+"</th><th>"+value.ServicioTipoOrden+"</th><th>"+value.Kilometraje+"</th><th>"+value.Estatus+"</th>");
            trow2.append(th2);
            tbody.append(trow2);
            table.append(tbody);
            $.each(value.servicios, function(llave, valores){
                var trow3 = $("<tr><td>"+valores.TipoRenglon+"</td><td>"+valores.Articulo+"</td><td colspan='3'>"+valores.DescripcionExtra+"</td><td colspan='2'>"+valores.agente+"</td></tr>");
                table.append(trow3);
            });
            $.each(value.eventos, function(llave2, valores2){
                var trow3 = $("<tr><td>"+valores2.TipoRenglon+"</td><td colspan='2'>"+valores2.Tipo+"</td><td colspan='4'>"+valores2.Evento+"</td></tr>");
                table.append(trow3);
            });
            $("#modalBodyO").append(table);
        })
        
        $("#modalOrdenes").modal('show');
    }
});
</script>