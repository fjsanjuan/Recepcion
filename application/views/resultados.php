<!-- <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css' rel='stylesheet' /> -->
<link href='<?=base_url()?>assets/css/scheduler.css' rel='stylesheet' />
<br><br>    
<!-- Start your project here-->
<style type="text/css">
    .table tr{

    }

    .btn-sm {
        display: block;
        margin: 0px auto;
    }

    table#table_vin tbody > tr { cursor: pointer; }
</style>
<div class="container"> 
    <input type="hidden" name="vin_seleccionado" id="vin_seleccionado" value="<?=$vin_selec?>">
    <input type="hidden" name="us_seleccionado" id="us_seleccionado" value="<?=$us_select?>">
    <input type="hidden" name="art_seleccionado" id="art_seleccionado" value="<?=$art_select?>">
    <div class="row">
        <div class="col">
            <blockquote id="cliente_seleccionado" class="blockquote bq-primary htext"><?=$Cliente['Nombre']?></blockquote>
        </div>
    </div>
    <br>
    <div class="row">
            <div class="col-xs-12 col-md-12">
                <!--Panel-->
                <div class="card animated fadeIn">
                    <div class="card-body">
                        <div class="form-header dark-primary-color rounded" style="margin-bottom: 8px;">
                            <div class="col-sm-12">
                                <h6><i class="fa fa-car"></i> Datos de Unidades</h6>
                            </div>
                        </div>
                    <table class="table" id="table_vin">
                            <!--Table head-->
                            <thead class="blue-grey lighten-4">
                                <tr>
                                    <th>VIN</th>
                                    <th>Descripción</th>
                                    <th>Color</th>
                                </tr>
                            </thead>
                            <!--Table head-->
                            
                            <!--Table body-->
                            <tbody>
                            <?php 
                                $permitido="aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789";
                                $especial=false;
                                $print_vin="";
                                $real_vin="";
                                foreach ($vehiculos as $val) 
                                {
                                    $real_vin=$val['VIN'];
                                    for($count=0;$count<strlen($val['VIN']);$count++){
                                        if(!strpos($permitido,substr($val['VIN'],$count,1))){
                                            $especial=true;
                                        }else{
                                            $print_vin.=substr($val['VIN'],$count,1);
                                        }
                                    }
                                    echo "<tr id='".$print_vin."' data-real='".$val['VIN']."'>";
                                    echo "<td>";
                                    if($especial==true){
                                        echo "<strong style='color:red' title='Incluye caracteres especiales'>".$val['VIN']."</strong></td>";
                                    }else{
                                        echo "<strong>".$val['VIN']."</strong></td>";
                                        $especial=false;
                                        $real_vin="";
                                    }
                                    echo "<td>".$val['Descripcion1']."</td>";
                                    echo "<td>".$val['ColorExteriorDescripcion']."</td>";
                                    echo "</tr>";
                                }
                            ?>
                            </tbody>
                            <!--Table body-->
                    </table>
                        <!--Table-->
                    </div>
                </div>
                <!--/.Panel-->
            </div>
            
            <!-- <div class="col-xs-12 col-md-6"> -->
                <!--Panel-->
                <!-- <div class="card animated fadeIn">
                    <div class="card-body">
                        <div class="form-header dark-primary-color rounded">
                            <h3><i class="fa fa-list-alt"></i> Cita de Servicio</h3>
                        </div> -->
                        <!--Table-->
                    <!-- <table class="table" id="table_citas"> -->
                            <!--Table head-->
                         <!--    <thead class="blue-grey lighten-4">
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>VIN</th>
                                    <th>Asesor</th>
                                    <th>Estatus</th>
                                    <th>Comentarios</th>
                                </tr>
                            </thead> -->
                           <!--  <tbody>
                                cambiar
                                <?php 
                                    foreach ($cita as $val) 
                                    {
            
                                        echo "<tr id='".$val['MovID']."'>";
                                        echo "<td>".$val['MovID']."</td>";
                                        echo "<td>".$val['fecha_requerida']." ".$val['HoraRequerida']."</td>";
                                        echo "<td>".substr($val['VIN'], -6)."</td>";
                                        echo "<td>".$val['asesor']."</td>";
                                        echo "<td>".$val['estatus']."</td>";
                                        echo "<td>".substr($val['Comentarios'], 0,40)."</td>";
                                        echo "</tr>";
                                    }
                                ?> -->
                            <!-- </tbody> -->
                        <!-- </table> -->
                    <!-- </div> -->
                <!-- </div> -->
                <!--/.Panel-->
            <!-- </div>/col -->
    </div><!-- /row -->
    <br><br>
<!-- button return -->
<div class="fixed-action-btn" style="left: 24px;width: 67px;">
    <!-- <a class="btn-floating accent-color" href="<?= $_SERVER['HTTP_REFERER']; ?>"><i class="fa fa-undo"></i></a> -->
</div>
</div><!-- /container -->
    <!-- float bottons -->
    <div id="container-floating" style="display: none;">
    <?php 
        $perfil = $this->session->userdata["logged_in"]["perfil"];

        if($perfil == 1 || $perfil == 3)        //superusuario y asesor
        {
    ?>
      <div class="nd1 nds"><img class="reminder">
        <p class="letter hvr-pulse"  data-toggle="tooltip" data-placement="left" title="Orden de Servicio"><i class="fa fa-file"  data-toggle="modal" data-target="#modalContactForm"  aria-hidden="true"></i></p>
      </div>
    <?php 
        }
        if($perfil == 1 || $perfil == 2)        //superusuario y recepcionista
        {
    ?>
        <div class="nd3 nds"><img class="reminder">
            <p class="letter hvr-pulse" data-toggle="tooltip" data-placement="left" title="Cita de Servicio"><i class="fa fa-edit" aria-hidden="true" id="cita_serv_btn"><a id="hrefcita" href="<?=base_url()?>servicio/cita_de_servicio"></a></i></p>
        </div>
    <?php
        }
    ?>
      <div id="floating-button" data-toggle="tooltip" data-placement="left" data-original-title="Create" style="display: none;">
        <p class="plus">+</p>
        <img class="edit" src="https://ssl.gstatic.com/bt/C3341AA7A1A076756462EE2E5CD71C11/1x/bt_compose2_1x.png">
      </div>
    </div>
    <!-- /float buttons -->


    <!-- modal cita de Servicio -->
    <div class="modal fade" id="modalContactForm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form role="form" id="form_cita_servicio" class="form-actions">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Cita de Servicio</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-header">
                        <button class="btn btn-info btn-rounded btn-sm" id="btn_acCliente">Alta Cliente</button>
                        <button class="btn btn-info btn-rounded btn-sm" id="btn_acArt">Alta Artículo</button>
                        <button class="btn btn-info btn-rounded btn-sm" id="btn_acVin">Alta Vin</button>
                    </div>
                    <div class="modal-body mx-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-inline md-form form-sm active-cyan-2">
                                    <i class="fa fa-cubes prefix grey-text"></i>
                                    <input name="cita_articulo" id="cita_articulo" class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Artículo Servicio" aria-label="Search">
                                    <button type="button" data-toggle="modal" data-target="#modalbusqart"  class=""><i class="fa fa-search hvr-bob" aria-hidden="true"></i></button> 
                                </div>
                                <div class="md-form">
                                    <i class="fa fa-level-up prefix grey-text"></i>
                                    <input name="cita_movimiento" type="text" id="form29" readonly class="form-control" value="Cita Servicio">
                                    <label  for="form29">Movimiento</label>
                                </div>
                              <div class="md-form">
                                    <label class="active" for="cita_fecha">Fecha Emision</label>
                                    <input  name="cita_fecha" id="cita_fecha" type="text" class="form-control" readonly style="text-align: center;">
                                    <input type="hidden" name="fulldate" id="fulldate">
                                    <input type="hidden" name="fecha_requerida" id="fecha_requerida">

                                    
                                </div>
                                <div class="md-form">
                                    <!--Blue select-->
                                    <label class="active" for="cita_hr_ini">Hora</label>
                                    <input type="text" readonly name="cita_hr_ini" id="cita_hr_ini" style="text-align: center;">
                                </div>
                                <div class="md-form">
                                    <!--Blue select-->
                                    <label class="active" for="cita_hr_fin">Entrega</label>
                                    <input type="text" readonly name="cita_hr_fin" id="cita_hr_fin" style="text-align: center;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-inline md-form form-sm active-cyan-2  ">
                                    <i class="fa fa-user prefix grey-text"></i>
                                    <input name="cita_cliente" id = 'cita_cliente' class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Cliente" aria-label="Search">
                                   <button type="button" data-toggle="modal" data-target="#modalbusqart"  class=""><i class="fa fa-search hvr-bob" aria-hidden="true"></i></button> 
                                </div>
                                <div class="md-form">
                                    <!--Blue select-->
                                    <select name="cita_uen" class="mdb-select colorful-select dropdown-primary">
                                        <option value="0">Seleccionar</option>    
                                        <?php
                                        // print_r($uen);
                                            foreach ($uen as $val) 
                                            {
                                                if($val['mov'] == 'Servicio')
                                                    echo "<option value['".$val['UEN']."'] >".$val['UEN']."</option>";
                                            }
                                        ?>
                                    </select>
                                    <label>UEN</label>
                                </div>
                                <div class="md-form">
                                    <i class="fa fa-user-secret prefix grey-text"></i>
                                    <label for="formas">Asesor</label>
                                    <input type="hidden" name="cita_asesor" id="cita_agente">
                                        <br>
                                        <div class="form-check">
                                            <input class="form-check-input" name="cita_ag" type="radio" id="radcit" checked="checked" value="sinc">
                                            <label class="form-check-label" for="radcit">Asignado por Agencia</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="cita_ag" type="radio" id="radcit2" value="conc">
                                            <label class="form-check-label" for="radcit2">Seleccionar Asesor</label>
                                        </div>
                                </div>
                                <div class="md-form" id="form_asesor_ordn">
                                    <button type="button" data-toggle="modal" data-target="#modal_asesor"><i class="fa fa-calendar hvr-bob" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" id="guardar_cita" class="btn dark-primary-color">Cita</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- ./modal cita Servicio -->

    <!-- modal orden de Servicio -->
    <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form role="form" action="<?= base_url()?>servicio/nueva_orden" method="post" id="form_orden_servicio" class="form-actions">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Orden de Servicio</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-header">
                    <button class="btn btn-info btn-rounded btn-sm" id="btn_aoCliente">Alta Cliente</button>
                    <button class="btn btn-info btn-rounded btn-sm" id="btn_aoArt">Alta Artículo</button>
                    <button class="btn btn-info btn-rounded btn-sm" id="btn_aoVin">Alta Vin</button>
                </div>
                <div class="modal-body mx-3">
                    <div class="row">
                       <div class="col-md-6">
                            <div class="form-inline md-form form-sm active-cyan-2  ">
                                <i class="fa fa-user prefix grey-text"></i>
                                <input name="orden_cliente" class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Cliente" id="orden_cliente">
                                <button type="button" data-toggle="modal" data-target="#modalbusqcli"  class=""><i class="fa fa-search hvr-bob" aria-hidden="true"></i></button> 
                            </div>
                            <div class="md-form">
                                <i class="fa fa-level-up prefix grey-text"></i>
                                <input name="orden_movimiento" type="text" id="form29" readonly class="form-control" value="Servicio">
                                <label  for="form29">Movimiento</label>
                            </div>
                            <div class="md-form">
                                <input name="orden_fecha" placeholder="Fecha" type="text" id="orden_fecha" class="form-control">
                                <input type="hidden" name="fulldate2" id="fulldate2">
                                <label for="date-picker-example">Fecha Emision</label>
                            </div>
                             <div class="md-form">
                                <!--Blue select-->
                                <label class="active" for="orden_hr_ini">Hora</label>
                                <input type="text" readonly name="orden_hr_ini" id="orden_hr_ini" style="text-align: center;">
                            </div>
                            <div class="md-form">
                                <!--Blue select-->
                                <label class="active" for="orden_hr_fin">Entrega</label>
                                <input type="text" readonly name="orden_hr_fin" id="orden_hr_fin" style="text-align: center;">
                            </div>
                            <div class="md-form">
                                <!--Blue select-->
                                <select name="orden_moneda" class="mdb-select colorful-select dropdown-primary">
                                    <option value="Pesos">Pesos</option>
                                    <option value="USD">USD</option>
                                </select>
                                <label>Moneda</label>
                            </div>
                                    
                        </div>
                       <div class="col-md-6">
                             <div class="form-inline md-form form-sm active-cyan-2  ">
                                    <i class="fa fa-cubes prefix grey-text"></i>
                                    <input name="orden_articulo" id="orden_articulo" class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Artículo Servicio" aria-label="Search">
                                   <button type="button" id="buscar_art"  class=""><i class="fa fa-search hvr-bob" aria-hidden="true"></i></button> 
                                </div>
                                <div class="md-form">
                                    <!--Blue select-->
                                    <select name="orden_uen" class="mdb-select colorful-select dropdown-primary">
                                        <option value="0">Seleccionar</option>    
                                        <?php
                                        // print_r($uen);
                                            foreach ($uen as $val) 
                                            {
                                                if($val['mov'] == 'Servicio')
                                                    echo "<option value['".$val['UEN']."'] >".$val['UEN']."</option>";
                                            }
                                        ?>
                                    </select>
                                    <label>UEN</label>
                                </div>
                                <div class="md-form">
                                    <i class="fa fa-user-secret prefix grey-text"></i>
                                    <label for="formas">Técnico</label>
                                        <br>
                                        <div class="form-check">
                                            <input class="form-check-input" name="orden_ag" type="radio" id="radioor" checked="checked" value="sinc">
                                            <label class="form-check-label" for="radioor">Asignado por Agencia</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="orden_ag" type="radio" id="rdior" value="conc">
                                            <label class="form-check-label" for="rdior">Seleccionar Técnico</label>
                                        </div>
                                </div>
                                <div class="md-form" id="form_tec_ordn">
                                    <button type="button" id ="horario_tec" data-toggle="modal" data-target="#modal_tecnico"><i class="fa fa-wrench hvr-bob" aria-hidden="true"></i></button>
                                </div>
                               <!-- <button type="button" data-toggle="modal" data-target="#modal_tecnico"><i class="fa fa-gear" aria-hidden="true"></i></button> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn dark-primary-color">Finalizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ./modal orden Servicio -->

    <!-- modal busqueda articulo -->
    <div class="modal fade" id="modalbusqart" tabindex="-1" role="dialog" aria-labelledby="modalbusqart">
        <div class="modal-dialog" role="document">
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
                                <input class="form-control" type="text" id="ajax_art" list="json-datalist-art" placeholder="Buscar Artículo">
                                <datalist id="json-datalist-art">
                                </datalist>
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
    <!-- ./ modal busqueda -->
    <!-- modal busqueda cliente -->
    <div class="modal fade" id="modalbusqcli" tabindex="-1" role="dialog" aria-labelledby="modalbusqcli">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buscar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <input class="form-control" type="text" id="ajax" list="json-datalist" placeholder="Buscar Cliente">
                                <datalist id="json-datalist">
                                </datalist>
                            </div>
                            <br>
                            <div class="loader loader5" id="spinner">
                              <svg width="40px" height="40px" viewBox="0 0 40 40" fill="transparent">
                                <circle cx="20" cy="20" r="4" stroke="#1976D2"/>
                              </svg>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" id="selciente" class="btn btn-primary">Seleccionar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ modal busqueda -->
    <!-- modal asesores -->
    <div class="modal fade" id="modal_asesor" tabindex="-1" role="dialog" aria-labelledby="modal_asesor">
        <div class="modal-dialog modal-fluid" role="document">
            <div class="modal-content">
                <button style="display:none;" type="button" data-toggle="modal" data-target="#modal_newdate" id="add_event"><i class="fa fa-search hvr-bob" aria-hidden="true"></i></button> 
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Disponibilidad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./modal asesores -->

    <!-- modal tecnicos -->
    <div class="modal fade" id="modal_tecnico" tabindex="-1" role="dialog" aria-labelledby="modal_tecnico">
        <div class="modal-dialog modal-fluid" role="document">
            <div class="modal-content">
                 <button style="display:none;" type="button" data-toggle="modal" data-target="#modal_newdate2" id="add_event_tec"><i class="fa fa-search hvr-bob" aria-hidden="true"></i></button> 
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Disponibilidad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="calendar_tecnicos"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./modal tecnicos -->
   
    <!-- modal new date -->
    <div class="modal fade" id="modal_newdate" tabindex="-1" role="dialog" aria-labelledby="modal_newdate" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Cita</h5>
                    <button type="button" id="close_newcita" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label for="new_asesor">Asesor</label>
                            <input type="text"  id="new_asesor" name="new_asesor" class="form-control" disabled>  
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <label for="new_fecha_requerida">Fecha Recepción</label>
                            <input type="text" id="new_fecha_recep" name="new_fecha_requerida" class="form-control" placeholder="00-00-0000">
                        </div>
                        <div class="col">
                            <label for="new_fecha">Hr. Recepción</label>
                            <input type="text"  id="new_recepcion" name="new_recepcion" class="form-control" disabled>
                            <input type="hidden" name="fecha_cita_hid" id="fecha_cita_hid" class="form-control" >
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="new_fecha">Fecha Requerida</label>
                            <input type="text"  id="new_requerida" name="new_requerida" class="form-control" placeholder="00-00-0000">
                            <input type="hidden" id="new_requerida_hid" name="new_requerida_hid" class="form-control">
                        </div>
                        <div class="col">
                            <label for="new_asesor">Hr. Requerida</label>
                            <input type="text"  id="new_hr_req" name="new_hr_req" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="new_nombre">Notas</label>
                            <input type="textarea" rows="4" cols="25" id="new_mov" name="new_mov"class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" id="create_date" class="btn btn-rounded btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ modal new date -->

    <!-- modal new date tech -->
    <div class="modal fade" id="modal_newdate2" tabindex="-1" role="dialog" data-backdrop="false">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label for="new_tecnico">Técnico</label>
                            <input type="text"  id="new_tecnico" name="new_tecnico" class="form-control" disabled>  
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <label for="new_fecha">Hr. Inicial</label>
                            <input type="text"  id="new_recepcion_tec" name="new_fecha" class="form-control" disabled>
                            <input type="hidden" name="fecha_cita_hidd" id="fecha_cita_hidd" class="form-control" >
                        </div>
                        <div class="col">
                            <label for="new_entrega_tec">Hr. Entrega</label>
                            <input type="text"  id="new_entrega_tec" name="new_entrega" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="new_nombre">Notas</label>
                            <input type="textarea" rows="4" cols="25" id="new_mov" name="new_mov"class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" id="create_date_tec" class="btn btn-rounded btn-primary">Guardar</button>
                    </div>
                </div>
                
            </div>
        </div> 
    </div>
    <!-- ./modal new date tech -->


    <!-- ./ modal new date -->
<script>
    var perfil = '<?=$this->session->userdata["logged_in"]["perfil"]?>';
    var param_cliente = $('#us_seleccionado').val();
    var params = { cliente:param_cliente};
    $('#hrefcita').attr('href', function() {
        return this.href +'/'+param_cliente;
    });

    $("#cita_serv_btn").click(function(){
        window.location.href = base_url + 'index.php/servicio/cita_de_servicio/'+param_cliente+'/int';
        return false;
    });
    // detalle de cita.
    $(document).on("click", "#table_citas tbody tr", function() {
        //some think
        $.confirm({
            title: 'Detalle!',
            content: 'Seleccion una opción?',
            type: 'blue',
            typeAnimated: true,
            buttons: {
                cancelar: {
                    text: 'Cancelar',
                    btnClass: 'btn-red',
                    action: function(){
                        alert("cita cancelada");
                    }
                },
                detalle:{
                    text:'Detalle',
                    btnClass: 'btn-blue',
                    action: function(){   
                        alert("detalle de cita");   
                    }
                },  

                close: function () {
                }
            }
        });
    });

    $(document).off("click", "#table_vin tbody tr").on("click", "#table_vin tbody tr", function() {
        var bid = this.id;
        var real = this.dataset.real;
        var us = $("#us_seleccionado").val();
        var muestra="";
        if(bid!=real){
            muestra="( el vin seleccionado podría existir mas de una vez: <strong style="+'"color:red"'+">"+real+"</strong> debido a un caracter especial)";
        }
        //bid = bid.replace(/[&\/\#,+()$~%'":*?<>{}|]/g, '').replace(/\u201C/g, '').replace(/\u201D/g, '').replace(/\s+/g, '');
        if(perfil == 2)
        {
            return;
        }

        var btnContinuar = false;

        $.ajax({
            cache: false,
            url: base_url+ "index.php/user/existe_ordenCita/",
            type: 'POST',
            dataType: 'json',
            data: {cliente: $("body #id_usuario").val(), vin: bid, no_cita: 0}
        })
        .done(function(data) {
            //console.log(data.res);
            if(data.res == null){
                btnContinuar= true;
            }

            $.confirm({
                title: '¿Qué desea hacer?',
                content: ' ' +  
                'VIN: '+'<b>'+bid +'</b>' + '<br>'+muestra
                +'<br/>Seleccione una opción',
                type: 'blue',
                typeAnimated: true,
                //autoClose: 'cita|4000',
                buttons:{
                    cerrar: function () {
                    },
                    contnOrden:{
                        text:'Continuar Orden de Servicio',
                        btnClass: 'btn-warning',
                        isHidden: btnContinuar,
                        action: function(){
                             $.alert('Espere por favor.');
                            
                            function insert_update_orden()
                             {                   
                                return  $.ajax({
                                         cache: false,
                                         url: base_url+ "index.php/user/crear_ordenServicio/",
                                         type: 'POST',
                                         dataType: 'json',
                                         data: {cliente: $("body #id_usuario").val(), vin: bid, id_cita: 0, no_cita: 0}
                                         })
                                         .done(function(data) {
                                            if(data["estatus"])
                                            {
                                                localStorage.setItem("id_orden_servicio", data["datos"]["id"]);
                                            }else 
                                            {
                                                localStorage.setItem("id_orden_servicio", 0);
                                            }
                                         })
                                         .fail(function() {
                                            alert("Hubo un error en la inserción a la base de datos");
                                         });
                             }

                            $.when(insert_update_orden()).done(function( x ) 
                            {
                                
                                location.href = base_url+ "index.php/servicio/orden_de_servicio/"+ 0 + "/"+$("body #us_seleccionado").val()+"/"+bid.replace('.', '')+"/";
                            });                     
                        }
                    },
                    Orden:{
                        text:'Nueva Orden de Servicio',
                        btnClass: 'btn-blue',
                        action: function(){
                             $.alert('Espere por favor.');
                            
                            function insert_orden()
                             {                   
                                return  $.ajax({
                                         cache: false,
                                         url: base_url+ "index.php/user/nueva_ordenServicio/",
                                         type: 'POST',
                                         dataType: 'json',
                                         data: {cliente: $("body #id_usuario").val(), vin: bid, id_cita: 0, no_cita: 0}
                                         })
                                         .done(function(data) {
                                            if(data["estatus"])
                                            {
                                                localStorage.setItem("id_orden_servicio", data["datos"]["id"]);
                                            }else 
                                            {
                                                localStorage.setItem("id_orden_servicio", 0);
                                            }
                                         })
                                         .fail(function() {
                                            alert("Hubo un error en la inserción a la base de datos");
                                         });
                             }

                            $.when(insert_orden()).done(function( x ) 
                            {
                                
                                location.href = base_url+ "index.php/servicio/orden_de_servicio/"+ 0 + "/"+$("body #us_seleccionado").val()+"/"+bid.replace('.', '')+"/";
                            });                     
                        }
                    },
                    // detalle:{
                    //     text:'Detalle',
                    //     btnClass: 'btn-primary',
                    //     action: function(){
                    //         $.ajax({
                    //             url: base_url+ "servicio/detalle_por_vin",
                    //             type: "POST",
                    //             dataType: 'json',
                    //             data: ({ vin: bid } ),
                    //             beforeSend: function(){
                    //                 $("#loading_spin").show();    
                    //             },
                    //             error: function(){
                    //                 console.log('error');
                    //             },
                    //             success: function (data){
                    //                 $("#loading_spin").hide();
                    //                 result = eval(data);
                    //                 //console.log(data);
                    //                 $.alert({
                    //                     title: 'Detalle',
                    //                     content:''+
                    //                         'Descripcion: '    + data[0]['Descripcion'] + '<br>'+
                    //                         'Modelo: '         + data[0]['Modelo']+ '<br>'+
                    //                         'Version: '        + data[0]['Version'] + '<br>' +
                    //                         'Transmision: '    + data[0]['transmision'] + '<br>'+
                    //                         'Último Servicio: '+ data[0]['FechaUltimoServicioFord']+'<br>'+
                    //                         'Vence Garantía: ' + data[0]['VencimientoGarantia'] + '<br>',
                    //                     type: 'blue',
                    //                     typeAnimated: true,
                    //                 });
                    //             }
                    //         });
                    //     }
                    // },              
                }
            });// fin del confirm
        
        })
        .fail(function() {
             toastr.error("Error al consultar si el cliente tiene ordenes incompletas");
        }); 


    });// fin document click
    $('.table_citas').mouseover(function(){
        $(this).toggleClass('light-primary-color');
    });
    
</script>