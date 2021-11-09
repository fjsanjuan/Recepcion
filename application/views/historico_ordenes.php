<!-- datatables -->
<link rel="stylesheet" href="<?=base_url()?>assets/librerias/datatablescrm/media/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.tosrus.all.css">
<script src="<?=base_url();?>assets/librerias/datatablescrm/media/js/jquery.dataTables.min.js"></script>
<!-- html2canvas -->
<script src="<?=base_url()?>assets/librerias/html2canvas/html2canvas.min.js"></script>
<script src="<?=base_url()?>assets/js/jquery.tosrus.all.min.js"></script>
<!-- jspdf -->
<script src="<?=base_url()?>assets/librerias/jspdf/jspdf.debug.js"></script>
<style>
    .checkA, .check{
        left: 0 !important;
        visibility: inherit !important;
        position: relative !important;
        margin-left: 15px;
    }
    label.pres_autorizado{
        background-color: #00c851!important;
        color: #fff;
        padding-right: 10px;
        border-radius: 10px;
        margin-left: 10px;
    }
    label.no_autorizado{
        background-color: #ec8585!important;
        color: #fff;
        padding-right: 10px;
        border-radius: 10px;
        margin-left: 10px;
    }

    a[href="<?=site_url('buscador/ver_historico')?>"]{
        display: none;
    }

    .flatpickr-clear {
        font-size: 100%;
        font-weight: bold;
        cursor: pointer;
        background: #fff;
    }
    button.whatsapp_pres{
        background-color: #79c143;
    }
    .comentario_fotos{
       line-height: normal !important;
        display: block;
        margin-top: 3px !important;
        width: 100%;
        text-align: justify;
        white-space: normal;
    }
    #modalbusqarts{
        overflow:scroll;
    }
    #exampleModal td{
        vertical-align: middle;
    }
</style>
<div class="container">
    <br>
    <div class="row">
        <div class="col-sm-12">
            <blockquote class="blockquote bq-primary htext">
                <b>HISTÓRICO ÓRDENES DE SERVICIO</b>
            </blockquote>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <h6><b>Seleccione, por favor, un rango de fechas:</b></h6>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-1 icono_calendario">
            <i class="fa fa-calendar-alt"></i>
        </div>
        <div class="col-sm-4">
        <input placeholder="Fecha Inicio" value="<?php echo date("Y-m").'-1';?>" type="text" id="fecha_ini" class="form-control datepicker input_fecha" >
        </div>
        <div class="col-sm-1 icono_calendario">
            <i class="fa fa-calendar-alt"></i>
        </div>
        <div class="col-sm-4">
        <input placeholder="Fecha Fin" value="<?php echo date("Y-m-t", strtotime(date("Y-m-d")));?>" type="text" id="fecha_fin" class="form-control datepicker input_fecha">
        </div>
        <div class="col-sm-2">
            <button type="button" id="btn_mostrar" class="btn btn-success btn-sm float-right">Mostrar Órdenes</button>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-sm-12 table-responsive">
            <table class="table table-bordered table-striped table-hover animated fadeIn tabla_hist" id="tabla_historico">
                <thead class="mdb-color primary-color">
                    <tr>
                        <th>ID</th>
                        <th>Folio</th>
                        <th>Tipo Garantía</th>
                        <?php 
                        if($this->session->userdata["logged_in"]["perfil"] == 6)
                            {
                        ?>
                            <th>Asesor</th>
                        <?php
                            }
                        ?>
                        <th>Nombre</th>
                        <th>Teléfono</th> 
                        <th>VIN</th>
                        <th>Modelo</th>
                        <th>Formatos</th>
                        <th>Acciones</th>
                        <th>Presupuestos</th>
                        <th>Comentario Técnico</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <br>
</div>
<!-- Genera el formato de orden servicio -->
<iframe src="" id="iframe_correo" style="width: 100%; height: 0px; border: none;"></iframe>
<input type="hidden" id="url_correo" value="<?=site_url().'servicio/mensaje'?>">
<iframe src="" id="iframe_formato" style="width: 100%; height: 0px; border: none;"></iframe>
<input type="hidden" id="url_formato" value="<?=site_url().'servicio/correo'?>">
<iframe src="" id="iframe_reversoformato" style="width: 100%; height: 0px; border: none;"></iframe>
<input type="hidden" id="url_reversoformato" value="<?=site_url().'servicio/correo_reverso'?>">
<iframe src="" id="iframe_correo" style="width: 100%; height: 0px; border: none;"></iframe>
<input type="hidden" id="url_correo" value="<?=site_url().'servicio/mensaje'?>">
<iframe src="" id="iframe_inventario" style="width: 100%; height: 0px; border: none;"></iframe>
<input type="hidden" id="url_inventario" value="<?=site_url().'servicio/generar_formatoInventario/1'?>">
<!-- modal envio whatss -->

<div class="modal fade" id="modal_whatsapp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!-- Change class .modal-sm to change the size of the modal -->
    <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Enviar Whatsapp <i class="fab fa-whatsapp" style="color:#79c143;"></i></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <?php
            $attributes = array('id' => 'form_send_whatsapp');
            echo form_open('',$attributes);
        ?>
        <div class="modal-body">
            <div class="form-group">
                <label for="">Número</label>
                <input type="text" id="numerowhats" class="form-control" readonly="true" ondblclick="this.readOnly='';">
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea2">Mensaje</label>
                <textarea class="form-control rounded-0" id="TextWhats" name="TextWhats" rows="3"></textarea>
                <input type="hidden" id='oden_hide' name='ide_orden'>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary btn-sm" id="env_whats">Enviar</button>
        </div>
        <?php
            echo form_close();
        ?>
    </div>
    </div>
</div>
<!-- Central Modal Small -->
<!-- modal send email -->
<div class="modal fade" id="modalsendmail" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-sm"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enviar Orden Por Correo</h5>
                </div>
                <div class="modal-body">
                    <p><i>Se enviará una copia de la Orden con los servicios requeridos.</i></p>
                    <input type="email" class="form-control" id="email_envio" readonly="true" ondblclick="this.readOnly='';">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <a  class="btn btn-primary" id="send_mail">Enviar</a>
                </div>
            </div>
    </div>
</div>
<!-- modal fotos -->
<div class="modal fade" id="modalFotos" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Fotografías de la Orden</h5>
                </div>
                <div class="modal-body">
                    <div id="links_light">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
    </div>
</div>
<!-- modal configuracion firma -->
<div class="modal fade" id="modalfirma" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg"  role="document" style="max-width: 1000px" > 
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

<!-- modal nuevo presupuesto -->
<div class="modal fade" id="modalbusqarts" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg"  role="document" style="max-width: 1000px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titlePresupuesto">Nuevo Presupuesto</h5>
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
                                    <input type="number" class="form-control" id="input_cantidad" name="input_cantidad" value="1" style="width: 150% !important" >
                                </div>
                                <div class="col-sm-1">
                                        <label for="input_stock">Stock:</label>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="input_stock" name="input_stock" value="0" readonly="true">
                                    </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-sm btn-success float-right" id="boton_agregarArt"><i class="fa fa-plus"></i></button>
                                </div>
                                <br><br>
                                 <div class="col-sm-4">
                                    <textarea name="comentario_art" id="comentario_art" cols="50" rows="5" placeholder="comentario" class="form-control"></textarea>
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
                <div class="card" id="card_articulos" style="display: none;">
                    <div class="card-body">
                        <h5>Artículos</h5>
                        <div class="table-responsive">
                            <?php
                                $attributes = array('id' => 'formPresupuesto');
                                echo form_open('',$attributes);
                            ?>
                            <table class="table table-condensed" id="table_invoice">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td><strong>Artículo</strong></td>
                                        <td class="text-center"><strong>Descripción</strong></td>
                                        <td class="text-center"><strong>Cantidad</strong></td>
                                        <td class="text-center"><strong>Precio U</strong></td>
                                        <td class="text-center"><strong>Comentarios</strong></td>
                                        <td class="text-center"><strong>Total</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><label for="totalFin">Total Fin:</label></td>
                                    <td class="price"><input class="cost md-textarea" id="precioTotal" name="precioTotal" readonly="true"></td>
                                </tbody>
                            </table>
                            <input type="hidden" id="id_orden_b" name="id_orden_b">
                            <input type="hidden" id="numero_articulos" name="numero_articulos">
                            <input type="hidden" id="id_presupuesto" name="id_presupuesto">
                            <?php
                                echo form_close();
                            ?>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="bnGuardarPres">Guardar Presupuesto</button>
                <button type="button" class="btn btn-success" id="bnActualizarPres" style="display: none">Actualizar Presupuesto</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPresupuestos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="false">
    <div class="modal-dialog modal-lg"  role="document" style="max-width: 1000px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Presupuestos de la Orden</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-success" id="bnGuardarPres">Guardar Presupuesto</button> -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- modal para email de presupuestos -->
<div class="modal fade" id="modalemailP" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg"  role="document" style="max-width: 1000px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mandar Presupuesto por Correo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Añadir Comentarios</h6>
                <?php
                    $attributes = array('id' => 'mandar_pres_mail');
                    echo form_open('',$attributes);
                ?>   
                <textarea name="comentario" id="comentario" cols="100" rows="10"></textarea>
                <input type="hidden" name="id" id="id" value="">
                <?php
                    echo form_close();
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="enviar_presupuesto">Enviar Email</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- modal oasis -->
<div class="modal fade" id="modaldocumentacion" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Documentación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $this->load->view("modals/cargar_documentacion");?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
    </div>
</div>
<!-- modal para codigo diagnostico del problema -->
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">Genera Reverso</button>-->
<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 style="color: #4285f4;" class="modal-title" id="exampleModalLongTitle"><b>CÓDIGO DE DIAGNÓSTICO DEL PROBLEMA</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-border">
            <thead>
                <tr>
                    <th>
                    <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-border">
                            <thead>
                                <tr>
                                    <th style="width: 30px;"><b>NO. REP.</b></th>
                                    <th style="width: 60px;"><b>LUZ FALLA ENCENDIDA</b></th>
                                    <th><b>DTC&nbspTREN&nbspMOTRIZ</b></th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 60px;" /></td>
                                <td>KOEO</td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 60px;" /></td>
                                <td>KOEC</td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 60px;" /></td>
                                <td>KOER</td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 60px;" /></td>
                                <td>CARROCERIA</td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 60px;" /></td>
                                <td>CHASIS</td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 60px;" /></td>
                                <td>INDEFINIDO</td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 60px;" /></td>
                                <td>OTRO</td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                                <td><input type="text" name="" id="" style="width: 30px;" /></td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div> 
                    </th>
                </tr>
            </thead>
        </table>
        </div>
    </div>
    <div class="col-md-12">
    <div class="modal-header">
        <h5 style="color: #4285f4;" class="modal-title" id="exampleModalLongTitle"><b>COMENTARIOS DEL MECANICO</b></h5>
    </div>
    </div>
    <div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><b>INCLUYA LA DESCRIPCION DE LA CAUSA DEL PROBLEMA</b></th>
                    <th><b>NÚMERO REP.</b></th>
                    <th><b>CLAVE DE DEFECTO</b></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="form-group">
                            <label for="usr">IDENTIFIQUE LA PARTE CAUSANTE</label><br>
                            <input type="text" class="form-control" id="usr" name="username">
                        </div></td>
                        <td><input type="text" class="form-control" name="" id=""></td>
                        <td><input type="text" class="form-control" name="" id=""></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                            <label for="usr">IDENTIFIQUE LA CAUSA DE LA FALLA</label><br>
                            <input type="text" class="form-control" id="usr" name="username">
                            </div></td>
                        <td><input type="text" class="form-control" name="" id=""></td>
                        <td><input type="text" class="form-control" name="" id=""></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                            <label for="usr">IDENTIFIQUE EL EQUIPO DE DIAGNOSTICO</label><br>
                            <input type="text" class="form-control" id="usr" name="username">
                            </div></td>
                        <td><input type="text" class="form-control" name="" id=""></td>
                        <td><input type="text" class="form-control" name="" id=""></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                            <label for="usr">EXPLIQUE LA REPARACIÓN AFECTUADA</label><br>
                            <textarea name="textarea" rows="10" cols="50"></textarea>
                            </div></td>
                        <td><input type="text" class="form-control" name="" id=""></td>
                        <td><input type="text" class="form-control" name="" id=""></td>
                    </tr>
                </tbody>
            </body>
        </table>
        </div>
            <div class="col-md-12">
            <div class="modal-header">
                <h5 style="color: #4285f4;" class="modal-title" id="exampleModalLongTitle"><b>REGISTRO DE LABOR</b></h5>
            </div>
            </div>
            <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 200px;"><b>RETORNO DE PARTES: BASICO/FECHA</b></th>
                            <th style="width: 70px;"><b>MECANICO CLAVE</b></th>
                            <th style="width: 60px;"><b>COSTO O TIEMPO UTILIZADO</b></th>
                            <th style="width: 70px;"><b>RELOJ CHEC.(INICIO)</b></th>
                            <th style="width: 70px;"><b>RELOJ CHEC.(TERMINO)</b></th>
                        </tr>
                    </thead>
                    <tbody class="registro_labor">
                        <tr>
                        <td><input type="text" class="form-control" id="" name="return_partes{}" style="width: 200px;" /></td>
                        <td><input type="text" class="form-control" id="" name="mecanico_clave{}" style="width: 70px;" /></td>
                        <td><input type="text" class="form-control" id="" name="costo_tiempo{}" style="width: 60px;" /></td>
                        <td><input type="text" class="form-control" id="" name="reloj_inicio{}" style="width: 70px;" /></td>
                        <td><input type="text" class="form-control" id="" name="reloj_termino{}" style="width: 70px;" /></td>
                        <td>
                        <i class="fa fa-plus fa-1x nuevo_registro" style="color:green; cursor:pointer;" aria-hidden="true"></i>
                        </td>
                        <td>
                        <i class="fa fa-times fa-1x borrar_registro" style="color:red; cursor:pointer;"></i>
                        </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Generar Reverso</button>
            </div>
    </div>
    </div>
    </div>
</div>
<!-- modal archivos adjuntos -->
<div class="modal fade" id="modalarchivosadjuntos" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Documentación Adjunta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $this->load->view("modals/archivos_adjuntos");?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
    </div>
</div>
<!-- modal autorizaciones -->
<div class="modal fade" id="modalautorizaciones" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="color: #4285f4;" class="modal-title" id="exampleModalLabel">AUTORIZACIONES</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $this->load->view("modals/autorizaciones");?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
    </div>
</div>
<!-- modal para jefe de taller asignar tecnico-->
<div class="modal fade" id="asignModal" tabindex="-1" aria-labelledby="asignModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 style="color: #4285f4;" class="modal-title" id="asignModalLabel">ASIGNAR TÉCNICO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Técnico</th>
                        <td>
                        <div class="form-group col-md-8">
                            <label for="asigna_tecnico" class="grey-text">Nombre</label>
                            <select id="asigna_tecnico" name="asigna_tecnico" class="browser-default form-control validate[required]" >
                            <!-- <option>seleccione... </option> -->
                            </select>
                        </div>
                        </td>
                    </tr>
                        <tr><th>Fecha Asignación</th>
                        <td>
                        <div class="col-sm-1 icono_calendario">
                            <i class="fa fa-calendar-alt"></i>
                        </div>
                        <div class="col-sm-4">
                        <input placeholder="Fecha Inicio" value="<?php echo date("Y-m").'\n';?>" type="text" id="fecha_ini" class="form-control datepicker input_fecha" >
                        </div>
                        </td></tr>
                        <tr><th>Hora Asignación</th>
                        <td>
                        <div class="row">
                        <div class="col-md-4">
                            <div class="md-form md-outline input-with-post-icon timepicker" twelvehour="true">
                            <input type="text" id="light-version-examples" class="form-control" placeholder="Select time">
                            <label for="light-version-examples">Hora inico</label>
                            <i class="fas fa-clock input-prefix" style="cursor:pointer;"></i>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="md-form md-outline input-with-post-icon timepicker" twelvehour="true">
                            <input type="text" id="light-version-examples" class="form-control" placeholder="Select time">
                            <label for="light-version-examples">Hora termina</label>
                            <i class="fas fa-clock input-prefix1" style="cursor:pointer;"></i>
                            </div>
                        </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck1">
                            <label class="form-check-label" for="gridCheck1">Todo el día</label>
                        </div>
                        </td></tr>
                        <tr><th>Trabajo Inicial</th>
                        <td>
                        <div class="row">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                            <label class="form-check-label" for="exampleRadios1">FORD</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                            <label class="form-check-label" for="exampleRadios2">PROPIO</label>
                        </div>&nbsp&nbsp
                        <div id="contenedor">
                            <div class="added">
                                <input name="mitexto[]" id="campo_1" placeholder="Paquetes" type="text"><a href="#" class="eliminar">X</a>
                            </div>
                        </div>
                        </div>
                        </td></tr>
                        <tr><th>Detalles o Comentarios</th>
                        <td><textarea name="textarea" rows="3" cols="60"></textarea></td></tr>
                </thead>
            </table>
        </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Asignar</button>
      </div>
    </div>
  </div>
</div>
<!-- modal para requisiciones-->
<div class="modal fade" id="requisModal" tabindex="-1" aria-labelledby="requisModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 style="color: #4285f4;" class="modal-title" id="requisModalLabel">REQUISICIÓN DE REFACCIONES POR GARANTÍA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <?php $this->load->view('modals/requisiciones'); ?>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- modal para revision de quejas del cliente-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 style="color: #4285f4;" class="modal-title" id="exampleModalLabel">REVISIÓN DE QUEJAS DEL CLIENTE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php $this->load->view('modals/revision_queja'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- modal para revision las autorizaciones-->
<div class="modal fade" id="autorizacionesModal" tabindex="-1" aria-labelledby="autorizacionesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 style="color: #4285f4;" class="modal-title" id="autorizacionesModalLabel">REVISIÓN DE AUTORIZACIONES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php $this->load->view('modals/validar_autorizaciones'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- modal lineas de reparacion -->
<!--<div id="classModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="lineareparacion" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
      <h4 style="color: #4285f4;" class="modal-title" id="classModalLabel"><b>Línea de Reparación</b></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <span aria-hidden="true">&times;</span></button>
    </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-border">
                <thead>
                    <tr>
                        <th><b>NUM. REP.</b></th>
                        <th><b>LUZ INDICADORA</b></th>
                        <th><b>DAÑOS EN RELACIÓN</b></th>
                        <th><b>AUTORIZACIÓN JEFE TALLER</b></th>
                        <th><b>AUTORIZACIÓN GERENTE SERVICIO</b></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" name="" id=""></td>
                        <td><input type="text" class="form-control" name="" id=""></td>
                        <td><input type="text" class="form-control" name="" id=""></td>
                        <td>
                        <div>
                            <input id="checkbox1" type="checkbox" name="checkbox" value="" check=""><label for=""></label>
                        </div>
                        </td>
                        <td>
                        <div>
                            <input id="checkbox2" type="checkbox" name="checkbox" value="" check=""><label for=""></label>
                        </div>
                        </td>
                        <td><button type="button" class="btn btn-info btn-sm">Generar&nbspFormato</button></td>
                    </tr>
                    <tr>
                        <td>Linea 2</td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td>
                        <div>
                            <input id="checkbox3" type="checkbox" name="checkbox" value="" check=""><label for=""></label>
                        </div>
                        </td>
                        <td>
                        <div>
                            <input id="checkbox4" type="checkbox" name="checkbox" value="" check=""><label for=""></label>
                        </div>
                        </td>
                        <td><button type="button" class="btn btn-info btn-sm">Generar&nbspFormato</button></td>
                    </tr>
                    <tr>
                        <td>Linea 3</td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td>
                        <div>
                            <input id="checkbox5" type="checkbox" name="checkbox" value="" check=""><label for=""></label>
                        </div>
                        </td>
                        <td>
                        <div>
                            <input id="checkbox6" type="checkbox" name="checkbox" value="" check=""><label for=""></label>
                        </div>
                        </td>
                        <td><button type="button" class="btn btn-info btn-sm">Generar&nbspFormato</button></td>
                    </tr>
                    <tr>
                        <td>Linea 4</td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td>
                        <div>
                            <input id="checkbox7" type="checkbox" name="checkbox" value="" check=""><label for=""></label>
                        </div>
                        </td>
                        <td>
                        <div>
                            <input id="checkbox8" type="checkbox" name="checkbox" value="" check=""><label for=""></label>
                        </div>
                        </td>
                        <td><button type="button" class="btn btn-info btn-sm">Generar&nbspFormato</button></td>
                    </tr>
                    <tr>
                        <td>Linea 5</td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td>
                        <div>
                            <input id="checkbox9" type="checkbox" name="checkbox" value="" check=""><label for=""></label>
                        </div>
                        </td>
                        <td>
                        <div>
                            <input id="checkbox10" type="checkbox" name="checkbox" value="" check=""><label for=""></label>
                        </div>
                        </td>
                        <td><button type="button" class="btn btn-info btn-sm">Generar&nbspFormato</button></td>
                    </tr> 
                </tbody>
            </table>
            <table class="table table-border">
                <thead>
                    <tr></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>KOEO</td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                    </tr>
                    <tr>
                        <td>KOEC</td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                    </tr>
                    <tr>
                        <td>KOER</td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                    </tr>
                    <tr>
                        <td>CARROCERIA</td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                    </tr>
                    <tr>
                        <td>CHASIS</td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                    </tr>
                    <tr>
                        <td>INDEFINIDO</td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                    </tr>
                    <tr>
                        <td>OTRO</td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                        <td><input type="text" name="" id=""></td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>-->