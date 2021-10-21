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
<div class="modal fade" id="modaloasis" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg"  role="document">
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
<!-- modal archivos adjuntos -->
<div class="modal fade" id="modalarchivosadjuntos" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Archivos Adjuntos</h5>
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
<!-- modal diagnostico del problema -->

<div id="classModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="diagnosticoproblema" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="col-lg-12 text-center"><div class="modal-header">
      <h4 style="color: #4285f4; text-align: center;"class="modal-title" id="classModalLabel"><b>Diagnóstico del Problema</b></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table id="classTable" class="table table-bordered">
              <thead>
              <tr>
                  <th>Rep. No.</th>
                  <th>Tipo de Garantía</th>
                  <th>Daños en Relación</th>
                  <th>Autoriz NO.1</th>
                  <th>Autoriz NO.2</th>
                  <th>Partes Totales $</th>
                  <th>M. de Obra Total $</th>
                  <th>Misc. Total $</th>
                  <th>IVA $</th>
                  <th>Participación Cliente $</th>
                  <th>Participación Distribuidor $</th>
                  <th>Reparación Distribuidor $</th>
                  <th>Autorización Jefe de Taller</th>
                  <th>Autorización Gerente de Servicio</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                    <td>1</td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                    <td><input type="text" class="form-control"/></td>
                </tr>
              </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>