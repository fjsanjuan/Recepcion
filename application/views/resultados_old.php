<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css' rel='stylesheet' />
<link href='<?=base_url()?>assets/css/scheduler.css' rel='stylesheet' />
<!-- NAVBAR -->
<nav class="navbar navbar-expand-md sticky-top navbar-dark dark-primary-color">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="#"> Servicio de Citas</a>
        <ul class="navbar-nav ml-auto mt-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fa fa-user"></i> Perfil
                </a>
                <div class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdownMenuLink-4">
                    <a class="dropdown-item waves-effect waves-light" href="#">Salir</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<br>
<!-- ./NAVBAR -->
<main>
<div class="main-wrapper">
    <!-- Start your project here-->
    <div class="container"> 
    <input type="hidden" name="vin_seleccionado" id="vin_seleccionado" value="<?=$vin_selec?>">
    <input type="hidden" name="us_seleccionado" id="us_seleccionado" value="<?=$us_select?>">
    <input type="hidden" name="art_seleccionado" id="art_seleccionado" value="<?=$art_select?>">
    <div class="row">
        <div class="col-md-4">
            <blockquote class="blockquote bq-primary htext"><?=$Cliente['Nombre']?></blockquote>
        </div>
    </div>
    <br>
    <div class="row">
            <div class="col-xs-12 col-md-6">
                <!--Panel-->
                <div class="card">
                    <div class="card-body">
                        <div class="form-header dark-primary-color rounded">
                            <h3><i class="fa fa-car"></i> Datos de Unidades</h3>
                        </div>
                        <!--Table-->
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
                                foreach ($vehiculos as $val) 
                                {
                                echo "<tr id='".$val['VIN']."'>";
                                    echo "<td>".$val['VIN']."</td>";
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
            <div class="col-xs-12 col-md-6">
                <!--Panel-->
                <div class="card">
                    <div class="card-body">
                        <div class="form-header dark-primary-color rounded">
                            <h3><i class="fa fa-list-alt"></i> Cita de Servicio</h3>
                        </div>
                        <!--Table-->
                    <table class="table" id="table_citas">
                            <!--Table head-->
                            <thead class="blue-grey lighten-4">
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>VIN</th>
                                    <th>Asesor</th>
                                    <th>Comentarios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach ($cita as $val) 
                                    {
                                    echo "<tr title='".$val['Comentarios']."' id='".$val['MovID']."''>";
                                        echo "<td>".$val['MovID']."</td>";
                                        echo "<td>".$val['fecha_requerida']." ".$val['HoraRequerida']."</td>";
                                        echo "<td>".substr($val['VIN'], -6)."</td>";
                                        echo "<td>".$val['asesor']."</td>";
                                        echo "<td>".substr($val['Comentarios'], 0,40)."</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/.Panel-->
            </div><!-- /col -->
    </div><!-- /row -->
    <br><br>
    <!-- button return -->
    <div class="fixed-action-btn" style="bottom: 275px; left: 24px;">
        <a class="btn-floating accent-color" href="<?= $_SERVER['HTTP_REFERER']; ?>"><i class="fa fa-undo"></i></a>
    </div>
    </div><!-- /container -->
    <!-- float bottons -->
    <div id="container-floating">
      <div class="nd1 nds"><img class="reminder">
        <p class="letter hvr-pulse"  data-toggle="tooltip" data-placement="left" title="Orden de Servicio"><i class="fa fa-file"  data-toggle="modal" data-target="#modalContactForm"  aria-hidden="true"></i></p>
      </div>
        <div class="nd3 nds"><img class="reminder">
        <p class="letter hvr-pulse" data-toggle="tooltip" data-placement="left" title="Cita de Servicio"><i class="fa fa-edit"  data-toggle="modal" data-target="#modalContactForm2"  aria-hidden="true"></i></p>
      </div>
      <div id="floating-button" data-toggle="tooltip" data-placement="left" data-original-title="Create" >
        <p class="plus">+</p>
        <img class="edit" src="https://ssl.gstatic.com/bt/C3341AA7A1A076756462EE2E5CD71C11/1x/bt_compose2_1x.png">
      </div>
    </div>
</div>
    
</main>    


    <!-- /float buttons -->
    <!-- modal cita de Servicio -->
    <div class="modal fade" id="modalContactForm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form role="form" id="form_cita_servicio" class="form-actions">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Cita de Servicio</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                                        <option value="1">3423</option>
                                        <option value="2">2342</option>
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
                                <div class="md-form" id="form_cita_ordn">
                                    <button type="button" data-toggle="modal" data-target="#modal_asesor"><i class="fa fa-search hvr-bob" aria-hidden="true"></i></button>
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

    <!-- ./modal orden Servicio -->
    <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form role="form" action="<?= base_url()?>servicio/nueva_orden" method="post" id="form_cita_servicio" class="form-actions">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Orden de Servicio</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="row">
                       <div class="col-md-6">
                            <div class="form-inline md-form form-sm active-cyan-2  ">
                                <i class="fa fa-user prefix grey-text"></i>
                                <input name="orden_cliente" class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Cliente" id="orden_cliente">
                                <button type="button" data-toggle="modal" data-target="#modalbusqcli"  class=""><i class="fa fa-search hvr-bob" aria-hidden="true"></i></button> 
                            </div>
                            <div class="md-form ">
                                <i class="fa fa-th-list prefix grey-text"></i>
                                <input name="orden_movimiento" type="text" id="form34" class="form-control validate">
                                <label data-error="wrong" data-success="right" for="form34">Movimiento</label>
                            </div>
                            <div class="md-form">
                                <input name="orden_fecha" placeholder="Fecha" type="text" id="date-picker-example" class="form-control datepicker">
                                <label for="date-picker-example">Fecha Emision</label>
                            </div>
                            <div class="md-form">
                                    <!--Blue select-->
                                    <select name="orden_horario" class="mdb-select colorful-select dropdown-primary" id="orden_horario">

                                    </select>
                                    <label>Horario</label>
                                </div>
                            <div class="md-form">
                                <!--Blue select-->
                                <select name="orden_moneda" class="mdb-select colorful-select dropdown-primary">
                                    <option value="1">Pesos</option>
                                    <option value="2">USD</option>
                                </select>
                                <label>Moneda</label>
                            </div>
                                    
                        </div>
                       <div class="col-md-6">
                             <div class="form-inline md-form form-sm active-cyan-2  ">
                                    <i class="fa fa-cubes prefix grey-text"></i>
                                    <input name="orden_articulo" id="orden_articulo" class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Artículo Servicio" aria-label="Search">
                                   <button type="button" data-toggle="modal" data-target="#modalbusqart"  class=""><i class="fa fa-search hvr-bob" aria-hidden="true"></i></button> 
                                </div>
                                <div class="md-form">
                                    <!--Blue select-->
                                    <select name="orden_uen" class="mdb-select colorful-select dropdown-primary">
                                        <option value="0">Seleccionar</option>    
                                        <option value="1">3423</option>
                                        <option value="2">2342</option>
                                    </select>
                                    <label>UEN</label>
                                </div>
                                <div class="md-form">
                                    <i class="fa fa-user-secret prefix grey-text"></i>
                                    <label for="formas">Asesor</label>
                                        <br>
                                        <div class="form-check">
                                            <input class="form-check-input" name="orden_ag" type="radio" id="radioor" checked="checked" value="sinc">
                                            <label class="form-check-label" for="radioor">Asignado por Agencia</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="orden_ag" type="radio" id="rdior" value="conc">
                                            <label class="form-check-label" for="rdior">Seleccionar Asesor</label>
                                        </div>
                                </div>
                                <div class="md-form" id="form_asesor_ordn">
                                    <button type="button" data-toggle="modal" data-target="#modal_asesor"><i class="fa fa-calendar hvr-bob" aria-hidden="true"></i></button>
                                </div>
                                <!--<button type="button" data-toggle="modal" data-target="#modal_tecnico"><i class="fa fa-gear" aria-hidden="true"></i></button> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn dark-primary-color">Finalizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal orden de Servicio -->


    <!-- modal busqueda articulo -->
    <div class="modal fade" id="modalbusqart" tabindex="-1" role="dialog" aria-labelledby="modalbusqart" data-backdrop="false">
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
    <div class="modal fade" id="modalbusqcli" tabindex="-1" role="dialog" aria-labelledby="modalbusqcli" data-backdrop="false">
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
    <div class="modal fade" id="modal_asesor" tabindex="-1" role="dialog" aria-labelledby="modal_asesor" data-backdrop="false">
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
    <div class="modal fade" id="modal_tecnico" tabindex="-1" role="dialog" aria-labelledby="modal_tecnico" data-backdrop="false">
        <div class="modal-dialog modal-fluid" role="document">
            <div class="modal-content">
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
                            <label for="new_asesor">Asesor</label>
                            <input type="text"  id="new_asesor" name="new_asesor" class="form-control" disabled>  
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <label for="new_fecha">Hr. Inicial</label>
                            <input type="text"  id="new_recepcion" name="new_fecha" class="form-control" disabled>
                            <input type="hidden" name="fecha_cita_hid" id="fecha_cita_hid" class="form-control" >
                        </div>
                        <div class="col">
                            <label for="new_asesor">Hr. Entrega</label>
                            <input type="text"  id="new_entrega" name="new_entrega" class="form-control">
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
    <!-- alta cliente -->
    <div class="modal fade" id="modalAltaCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
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
