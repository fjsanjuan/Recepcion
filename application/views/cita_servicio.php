<!-- hidden fields -->
<input type="hidden" value="<?=$uno?>" id="clienteid">
<input type="hidden" value="<?=$dos?>" id="clie">

<link rel="stylesheet" href="<?=base_url()?>assets/librerias/fullcalendar-3.9.0/fullcalendar.min.css"/>
<link href='<?=base_url()?>assets/css/scheduler.css' rel='stylesheet' /> 
    <!-- modal cita de Servicio -->
    <div class=" " id="modalContactForm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form role="form" id="form_cita_servicio" class="form-actions">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Cita de Servicio</h4>
                    </div>
                    <div class="modal-header">
                        <button class="btn btn-info btn-rounded btn-sm" id="btn_acCliente">Alta Cliente</button>
                        <button class="btn btn-info btn-rounded btn-sm" id="btn_acArt">Alta Artículo</button>
                        <button class="btn btn-info btn-rounded btn-sm" id="btn_acVin">Alta Vin</button>
                    </div>
                    <div class="modal-body mx-3">
                        <div class="row">
                            <div class="col-md-6">
                               <!-- <div class="form-inline md-form form-sm active-cyan-2">
                                    <i class="fa fa-cubes prefix grey-text"></i>
                                    <!-<input name="cita_articulo" id="cita_articulo" class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Artículo Servicio" aria-label="Search">
                                    <button type="button" data-toggle="modal" data-target="#modalbusqart"  class=""><i class="fa fa-search hvr-bob" aria-hidden="true"></i></button>  --
                                  
                                </div> -->

                                <div class="md-form">
                                    <select name="cita_articulo" id="cita_articulo" class="mdb-select">
                                    <option value="" disabled selected>Seleccione VIN</option> 
                                    </select>
                                    <label>Artículo</label>
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
                                    <input name="cita_cliente" id ='cita_cliente' class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Cliente" aria-label="Search" value="">
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
<script src='<?=base_url()?>assets/js/calendars.js'></script>
<script type="text/javascript">

$( document ).ready(function() {
    console.log( "ready!" );

    $('input:radio[name=cita_ag]').change(function() {
        if (this.value == 'sinc') {
             $('#form_asesor_ordn').fadeOut( "slow");
        }
        else if (this.value == 'conc') {
             $('#form_asesor_ordn').fadeIn( "slow");
        }
    });

    var uno = $('#clienteid').val();
    var dos = $("#clie").val();

    if(uno.length == 17){
        console.log('vin');
        $('#cita_articulo').append('<option value="'+uno+'" selected="selected">'+uno+'</option>');

        $('#cita_articulo').material_select();
        $("#cita_cliente").val(dos);
    }else{
        console.log('cliente');
        $.ajax({
            url: base_url+ "index.php/servicio/cita_de_servicio_cliente",
            type: "POST",
            dataType: 'json',
            data: ({ cliente: uno } ),
            beforeSend: function(){
                $("#loading_spin").show();
            
            },
            error: function(){
                console.log('error');
            }, 
            success: function (data){
                $("#loading_spin").hide();
                result = eval(data);
                var opc = "";
                var i=0;
                $.each(data, function(index, val) {
                    opc += '<option value="' + result[i]['vin'] + '">' + result[i]["articulo"] + '</option>';
                    i++;
                });
                $("#cita_articulo").html(opc);
                $('#cita_articulo').material_select();
                $("#cita_cliente").val(uno);
            }
        });

    }


});
</script>