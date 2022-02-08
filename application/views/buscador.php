<link rel="stylesheet" href="<?=base_url();?>assets/librerias/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">

<script src="<?=base_url();?>assets/librerias/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>assets/librerias/moment.js/moment.min.js"></script>
<script src="<?=base_url();?>assets/librerias/moment.js/moment-with-locales.min.js"></script>
<style>
        table, th, td 
        {
            margin:10px 0;
            border:solid 1px #333;
            padding:2px 4px;
            font:15px Verdana;
        }
        th {
            font-weight:bold;
        }

        #buscar{
            cursor: pointer;
        }

        [type=checkbox]:checked+label:before{
            border-width: 4px;
            border-color: transparent #ffffff #ffffff transparent;
        }
    </style> 
<!-- NAVBAR -->

<!-- ./NAVBAR -->
<div class="container-fluid">

    <!-- Start your project here-->
    <div  class="row " >
        <div class="col-md-6 mcenter">
            <br>
            <!-- <img class="animated fadeIn" src="<?=base_url()?>assets/img/logo.png" alt="Intelisis"> -->
        </div>
        <div class="col-md-12 mcenter">
            <br>
            <div id="dia_pivote" style="display: none;"><?php echo date('Y-m-d')?></div>
            <h5 class="mb-4 font-weight-bold dark-grey-text" id="miscitasdia"></h5>
            <div class="row">
                <div class="col-md-4">
                    <i id="dia_anterior" class="fa fa-arrow-left" style="font-size:36px;color:#007bff;float: left;"></i>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <i id="dia_siguiente" class="fa fa-arrow-right" style="font-size:36px;color:#007bff;float: right;"></i>
                </div>
            </div>
              
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover animated fadeIn" id="table_recepcion">
                    <thead class="mdb-color primary-color" style="font-weight: bold; color:#fff;">
                        <tr>
                            <th>Hora Cita</th>
                            <th>No. Cita</th>
                            <th>Nombre</th>
                            <th style="display: none;">Nombre(s)</th>
                            <th style="display: none;">Apellido Paterno</th>
                            <th style="display: none;">Apellido Materno</th>
                            <th>Teléfono</th>
                            <th>VIN</th>
                            <th>Descripción</th>
                            <th>Modelo</th>
                            <th>Color</th>
                            <th>Placas</th>
                            <th>Fecha Promesa</th>
                            <th class="recepcion">Llegada Cliente</th>
                            <th class="recepcion">Atención Asesor</th>
                            <th class="recepcion">Asesor</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
   
    <div class="row">
        <div class="col-md-6 mcenter">
        <!--<h5 class="mtop animated fadeIn mb-3">Thank you for using our product. We're glad you're with us.</h5> -->
        <br><br>
        <form>
            <div class="input-group md-form form-sm form-2 pl-0">
                <input name="querysearch" id = "querysearch" class="form-control my-0 py-1 red-border" type="text" placeholder="Buscar" aria-label="Search">
                <div class="input-group-append">
                    <button class="input-group-text azul lighten-2" id="buscar"><i class="fa fa-search text-white" aria-hidden="true"></i></button>
                </div>
            </div>
            <!--<a href="<?=site_url()?>buscador/resultados">resultados</a>
            <a href="<?=site_url()?>buscador/sin_resultados" id="sinresultados">sin resultados</a> -->
            <br>
            <!-- Form inline with radios -->
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary form-check-label" style="height: 100%;">
                    <input type="radio" name="tipo" id="option1" autocomplete="off" value="1">NOMBRE
                </label>
                <label class="btn btn-primary form-check-label" style="height: 100%;">
                    <input type="radio" name="tipo" id="option2" autocomplete="off" value="2"> VIN
                </label>
                <label class="btn btn-primary form-check-label" style="height: 100%;">
                    <input type="radio" name="tipo" id="option3" autocomplete="off" value="3"> PLACA
                </label>
                <label class="btn btn-primary form-check-label" id="photo_button" style="height: 100%;">
                    <input type="file" name="fileOcr" autocomplete="off" id="fileOcr" accept="image/*;capture=camera" onchange="resizeImg(event)">TOMAR FOTO</label>
            </div>   <!-- Form inline with radios -->
        </form>
            <canvas id="canvas" width="390" height="100"></canvas>
            <canvas id="canvas2" width="360" height="90"></canvas>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-sm-2 botones_alta">
            <button class="btn btn-info btn-sm" id="boton_acliente">Alta Cliente</button>
        </div>
        <div class="col-sm-2 botones_alta">
            <button class="btn btn-info btn-sm" id="boton_avin">Alta VIN</button>
        </div>
        <div class="col-sm-2 botones_alta">
            <button class="btn btn-info btn-sm" id="boton_aarticulo">Alta Artículo</button>
        </div>
        <div class="col-md-3"></div>                 
    </div>
    <br>
    <br>
    <div class="row" id="detalle">
        
    </div>
    <input type="hidden" id="id_usuario">
    <input type="hidden" id="hayvin" value="0">
    <input type="hidden" id="citaseleccionada" value="0">
</div>

<!-- footer -->
<footer>
    <div class="footer-copyright py-3 text-center text-muted animated fadeIn">
         Intelisis Solutions - Todos los Derechos Reservados <br>
    </div>
</footer>    
</div>    
<style>
   #canvas {border:1px solid #000; background-color:#000; border-radius:10px;display: none;}
   #canvas2 { background-color:#000; border-radius:10px;display: none;}
</style>

<script>
var perfil = '<?=$this->session->userdata["logged_in"]["perfil"]?>';
var hora_cita = "";
var no_cita = "";
$(document).ready(function() {


$('.mdb-select').material_select();

function obtener_colorEstatus(hora_registrada, hora_cita)
{
    var color = "";

    if(hora_registrada <= hora_cita)
    {
        color = "success";
    }else 
    {
        color = "danger";
    }

    return color;
}

function enviar_hora(id_cita, tipo_hora, hora)
{
    $.ajax({
        cache: false,
        url: base_url+ "index.php/buscador/enviar_horaRecep/",
        type: 'POST',
        dataType: 'json',
        data: {cita: id_cita, tipo: tipo_hora, hora: hora}
    })
    .done(function(data) {
        if(hora != null)
        {
            if(tipo_hora == 1)
            {
                toastr.success("Se registró la llegada del Cliente a las "+ hora);
            }else 
            {
                toastr.success("Se registró la atención del Asesor al Cliente a las "+ hora);
            }
        } 
    })
    .fail(function() {
        if(tipo == 1)
        {
            alert("Hubo un error al actualizar la hora de llegada del cliente");
        }else 
        {
            alert("Hubo un error al actualizar la hora de atención del cliente");
        }
    }); 
}

/*Check hora llegada cliente*/
$(document).on("click", "#table_recepcion tbody tr td.recepcion.llegada", function(e){
    e.stopPropagation();
    var checked = $(this).find('input[type="checkbox"]');
    var now = moment().format("H:mm");
    hora_cita = $(this).closest("tr").children()[0].innerText;
    id_cita = $(this).closest("tr")[0].id;
    // no_cita = $(this).closest("tr").children()[1].innerText;
    var color = obtener_colorEstatus(now, hora_cita);
// console.log(id_cita);
// throw new Error("Stop!");
    // if(checked.is(':checked') == false){
        checked.prop('checked', !checked.is(':checked'));

        $(this).toggleClass("btn-"+ color);

        if($(this).find("span.span-ll").text() == "")
        {
            $(this).find("span.span-ll").text(now);
            enviar_hora(id_cita, 1, now);
        }else 
        {
            $(this).find("span.span-ll").text("");
            enviar_hora(id_cita, 1, null);
        }
    /*}else{
        toastr.warning("Ya se registró la llegada del Cliente a las "+ $(this).find("span.span-ll").text());
    }*/

    
    return false;
});

/*Check hora atencion a cliente*/
$(document).on("click", "#table_recepcion tbody tr td.recepcion.atencion", function(e){
    e.stopPropagation();
    var checked = $(this).find('input[type="checkbox"]');
    var now = moment().format("H:mm");
    hora_cita = $(this).closest("tr").children()[0].innerText;
    id_cita = $(this).closest("tr")[0].id;
    // no_cita = $(this).closest("tr").children()[1].innerText;
    var color = obtener_colorEstatus(now, hora_cita);

    // if(checked.is(':checked') == false){
        checked.prop('checked', !checked.is(':checked'));

        $(this).toggleClass("btn-"+ color);

        if($(this).find("span.span-at").text() == "")
        {
            $(this).find("span.span-at").text(now);

            enviar_hora(id_cita, 2, now);
        }else 
        {
            $(this).find("span.span-at").text("");

            enviar_hora(id_cita, 2, null);
        }
    /*}else{
        toastr.warning("Ya se registró la atención del Asesor al Cliente a las "+ $(this).find("span.span-at").text());
    }*/
    
    return false;
});

/*valores on click tabla citas*/
$(document).on("click", "#table_recepcion tbody tr", function(e) {
    //variable que contiene el id de la tabla venta 
    var bid = this.id;
    hora_cita = $(this).children()[0].innerText;
    no_cita = $(this).children()[1].innerText;          //es el movID
    var cliente = $(this).children()[2].innerText;
    var nom_cliente = ($(this).children()[3].innerText == "null") ? "" : $(this).children()[3].innerText;
    var ap_cliente = ($(this).children()[4].innerText == "null") ? "" : $(this).children()[4].innerText;
    var am_cliente = ($(this).children()[5].innerText == "null") ? "" : $(this).children()[5].innerText;
    var vin = $(this).children()[7].innerText;
    cliente = encodeURIComponent(cliente);
    
    if(perfil == 2)
    {
        return;
    }
    
    localStorage.setItem("nom_cliente", nom_cliente);
    localStorage.setItem("ap_cliente", ap_cliente);
    localStorage.setItem("am_cliente", am_cliente);
    if(vin == '' || vin == null)
    {
        $($("#boton_avin").trigger("click"));
        $("#hayvin").val("1");
        $("#citaseleccionada").val(bid);
    }
    else
    {
        $("#loading_spin").show();
        $.ajax({
            cache: false,
            url: base_url+ "index.php/Buscador/revisar_tickaje/",
            type: 'POST',
            dataType: 'json',
            data: {id: bid}
        })
        .done(function(data) {
            $("#loading_spin").hide();
            //console.log(data);
            //alert(data.valTickaje.tickaje);


            switch(data.valTickaje.tickaje) {
              case 1:
                    if(data.CFechaLlegada != 0 && data.CFechaAtencion != 0 && data.CFechaLlegada != '1900-01-01 00:00:00.000' && data.CFechaAtencion != '1900-01-01 00:00:00.000')
                    {
                     mandar_tickaje();   
                    }else
                    {
                        alert("Es necesario marcar el tickaje de llegada y pase de asesor para poder avanzar a la orden");
                    }
                break;
              default:
                    mandar_tickaje();
            }
                // inicio funncion mandar_tickaje
                function mandar_tickaje() {
                    $.confirm({
                        title: 'Generar Orden de Servicio',
                        content: ' ' +  
                        'Folio: '+'<b>'+bid +'</b>' + '<br>'+
                        'Proceder a generar la orden',
                        type: 'blue',
                        typeAnimated: true,
                        //autoClose: 'cita|4000',
                        closeIcon: true,
                        closeIconClass: 'fa fa-close',
                        buttons:{
                            orden:{
                                text:'SI',
                                btnClass: 'btn-blue',
                                action: function(){
                                     $.alert('Espere por favor.');
                                     
                                     /*Crea insert en tabla orden_servicio*/
                                     function insert_orden2()
                                     {                   
                                        return  $.ajax({
                                                 cache: false,
                                                 url: base_url+ "index.php/user/crear_ordenServicio/",
                                                 type: 'POST',
                                                 dataType: 'json',
                                                 data: {cliente: cliente, vin: vin, id_cita: bid, no_cita: no_cita}
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

                                    $.when(insert_orden2()).done(function( x ) 
                                    {
                                        location.href = base_url+ "index.php/servicio/orden_de_servicio/"+ bid + "/";
                                    });                     
                                }
                            },
                        }
                    });
                } // final funncion mandar_tickaje

        })
        .fail(function() {
            $("#loading_spin").hide();
        }); 
        
    }
});


function obtener_horasMinutos(hora)
{
    var string = hora.split(" ");
    string = string[1].split(".");
    string = string[0].split(":");
    string = string[0]+":"+string[1];

    return string;
}

$.get(base_url+ 'index.php/Servicio/citas_por_asesor', function(data) {
    }).always( function() {

    $("#loading_spin").show();

}).done(function (data){
        data_from_ajax = data;
        var obj = JSON.parse(data_from_ajax);
        var items =[];
        // console.log(obj);

        $.each(obj , function (key, val){ 
            var ll_cliente = (val.CFechaLlegada == null) ? "" : obtener_horasMinutos(val.CFechaLlegada);
            var at_cliente = (val.CFechaAtencion == null) ? "" : obtener_horasMinutos(val.CFechaAtencion);
            var color_ll = obtener_colorEstatus(ll_cliente, val.HoraCita);
            var color_at = obtener_colorEstatus(at_cliente, val.HoraCita);
            items.push("<tr id='" + val.idCita    + "'>");
            // console.log(val.CFechaLlegada);
            if(val.CFechaLlegada != null){
                  items.push("<td style= 'background-color:lightgreen;'>" + val.HoraCita + "</td>");
            }else{
                  items.push("<td>" + val.HoraCita + "</td>");
            }
            items.push("<td>"  + val.NoCita + "</td>");
            items.push("<td class='cliente'>" + val.Nombre + "</td>");
            items.push("<td style='display: none;'>" + val.NombreCliente + "</td>");
            items.push("<td style='display: none;'>" + val.Ap_PatCliente + "</td>");
            items.push("<td style='display: none;'>" + val.Ap_MatCliente + "</td>");
            items.push("<td>"  + val.Telefono + "</td>");
            items.push("<td class='vin'>" + val.VIN + "</td>");
            items.push("<td>"  + val.VehiculoDescripcion + "</td>");
            items.push("<td>"  + val.Modelo + "</td>");
            items.push("<td>"  + val.Color + "</td>");
            items.push("<td>"  + val.Placas + "</td>");
            items.push("<td>"  + val.HoraPromesa + "</td>");
            
            if(ll_cliente != "")
            {
                items.push('<td class="recepcion llegada btn-'+color_ll+'"><input type="checkbox" id="check-ll-'+val.NoCita+'" checked><label class="check-tbcitas"></label><span class="span-ll">'+ll_cliente+'</span></td>');
            }else 
            {
                items.push('<td class="recepcion llegada"><input type="checkbox" id="check-ll-'+val.NoCita+'"><label class="check-tbcitas"></label><span class="span-ll"></span></td>');
            }
            
            if(at_cliente != "")
            {
                items.push('<td class="recepcion atencion btn-'+color_at+'"><input type="checkbox" id="check-at-'+val.NoCita+'" checked><label class="check-tbcitas"></label><span class="span-at">'+at_cliente+'</span></td>');
            }else 
            {
                items.push('<td class="recepcion atencion"><input type="checkbox" id="check-at-'+val.NoCita+'"><label class="check-tbcitas"></label><span class="span-at"></span></td>');
            }
                         
            items.push("<td class='recepcion' style='font-size: 10px;'>"  + val.Nombre_asesor + "</td>");
            items.push("</tr>");
        });

        $("<tbody/>",{html: items.join("")}).appendTo("table");
        $("#loading_spin").hide();

        if(perfil == 2)
        {
            $(".recepcion").show();
        }else 
        {
            $(".recepcion").hide();
        }
    }).fail(function( data, textStatus, jqXHR){
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
        }
    });

});
$(document).on("click", "#dia_anterior", function(e){
    e.preventDefault();
    //obtener el valor del div oculto
    var k = $("#dia_pivote").text();
    //usamos momentjs para las fechas.
    var today = moment(k); 
    var tomorrow = moment(today).subtract(1, 'days');
    tomorrow = formatDate(tomorrow);
    //actualizar valor del div
    $("#dia_pivote").text(tomorrow);
    //actualizar el titulo
    $("#miscitasdia").text(moment(tomorrow).format('LLL'));
    
    $.ajax({
        url: base_url+ "index.php/Servicio/citas_asesor_dia",
        type: "POST",
        dataType: 'json',
        data: ({ dia : tomorrow} ),
        beforeSend: function(){
            $("#loading_spin").show();
        },
        error: function(){
            console.log('error');
        },
        success: function (data){
            data = eval(data);
            $("#table_recepcion tbody").remove();
            if(data.success == 0){
                toastr.warning('Sin Citas para este día');
            }else{  
                var obj = data.data;
                var items =[];

                $.each(obj , function (key, val){ 
                var ll_cliente = (val.CFechaLlegada == null) ? "" : obtener_horasMinutos(val.CFechaLlegada);
                var at_cliente = (val.CFechaAtencion == null) ? "" : obtener_horasMinutos(val.CFechaAtencion);
                var color_ll = obtener_colorEstatus(ll_cliente, val.HoraCita);
                var color_at = obtener_colorEstatus(at_cliente, val.HoraCita);

                items.push("<tr id='" + val.idCita    + "'>");
                items.push("<td>" + val.HoraCita + "</td>");
                items.push("<td>"  + val.NoCita + "</td>");
                items.push("<td class='cliente'>" + val.Nombre + "</td>");
                items.push("<td style='display: none;'>" + val.NombreCliente + "</td>");
                items.push("<td style='display: none;'>" + val.Ap_PatCliente + "</td>");
                items.push("<td style='display: none;'>" + val.Ap_MatCliente + "</td>");
                items.push("<td>"  + val.Telefono + "</td>");
                items.push("<td class='vin'>" + val.VIN + "</td>");
                items.push("<td>"  + val.VehiculoDescripcion + "</td>");
                items.push("<td>"  + val.Modelo + "</td>");
                items.push("<td>"  + val.Color + "</td>");
                items.push("<td>"  + val.Placas + "</td>");
                items.push("<td>"  + val.HoraPromesa + "</td>");
                
                if(ll_cliente != "")
                {
                    items.push('<td class="recepcion llegada btn-'+color_ll+'"><input type="checkbox" id="check-ll-'+val.NoCita+'" checked><label class="check-tbcitas"></label><span class="span-ll">'+ll_cliente+'</span></td>');
                }else 
                {
                    items.push('<td class="recepcion llegada"><input type="checkbox" id="check-ll-'+val.NoCita+'"><label class="check-tbcitas"></label><span class="span-ll"></span></td>');
                }
                
                if(at_cliente != "")
                {
                    items.push('<td class="recepcion atencion btn-'+color_at+'"><input type="checkbox" id="check-at-'+val.NoCita+'" checked><label class="check-tbcitas"></label><span class="span-at">'+at_cliente+'</span></td>');
                }else 
                {
                    items.push('<td class="recepcion atencion"><input type="checkbox" id="check-at-'+val.NoCita+'"><label class="check-tbcitas"></label><span class="span-at"></span></td>');
                }
                             
                items.push("<td class='recepcion' style='font-size: 10px;'>"  + val.Nombre_asesor + "</td>");
                items.push("</tr>");
            });

                $("<tbody/>",{html: items.join("")}).appendTo("table");
            }
                $("#loading_spin").hide();
                if(perfil == 2){
                    $(".recepcion").show();
                }else{
                    $(".recepcion").hide();
                }
        }
    });
}); 
$(document).on("click", "#dia_siguiente", function(e){
    e.preventDefault();
    var k = $("#dia_pivote").text();
    var today = moment(k); 
    var tomorrow = moment(today).add(1, 'days');
    tomorrow = formatDate(tomorrow);
    $("#dia_pivote").text(tomorrow);
    $("#miscitasdia").text(moment(tomorrow).format('LLL'));

    $.ajax({
        url: base_url+ "index.php/Servicio/citas_asesor_dia",
        type: "POST",
        dataType: 'json',
        data: ({ dia : tomorrow} ),
        beforeSend: function(){
            $("#loading_spin").show();
        },
        error: function(){
            console.log('error');
        },
         success: function (data){
            data = eval(data);
            $("#table_recepcion tbody").remove();
            if(data.success == 0){
                toastr.warning('Sin Citas para este día');
            }else{  
                var obj = data.data;
                var items =[];
               $.each(obj , function (key, val){ 
                    var ll_cliente = (val.CFechaLlegada == null) ? "" : obtener_horasMinutos(val.CFechaLlegada);
                    var at_cliente = (val.CFechaAtencion == null) ? "" : obtener_horasMinutos(val.CFechaAtencion);
                    var color_ll = obtener_colorEstatus(ll_cliente, val.HoraCita);
                    var color_at = obtener_colorEstatus(at_cliente, val.HoraCita);
                    items.push("<tr id='" + val.idCita    + "'>");
                    items.push("<td>" + val.HoraCita + "</td>");
                    items.push("<td>"  + val.NoCita + "</td>");
                    items.push("<td class='cliente'>" + val.Nombre + "</td>");
                    items.push("<td style='display: none;'>" + val.NombreCliente + "</td>");
                    items.push("<td style='display: none;'>" + val.Ap_PatCliente + "</td>");
                    items.push("<td style='display: none;'>" + val.Ap_MatCliente + "</td>");
                    items.push("<td>"  + val.Telefono + "</td>");
                    items.push("<td class='vin'>" + val.VIN + "</td>");
                    items.push("<td>"  + val.VehiculoDescripcion + "</td>");
                    items.push("<td>"  + val.Modelo + "</td>");
                    items.push("<td>"  + val.Color + "</td>");
                    items.push("<td>"  + val.Placas + "</td>");
                    items.push("<td>"  + val.HoraPromesa + "</td>");
                    
                    if(ll_cliente != "")
                    {
                        items.push('<td class="recepcion llegada btn-'+color_ll+'"><input type="checkbox" id="check-ll-'+val.NoCita+'" checked><label class="check-tbcitas"></label><span class="span-ll">'+ll_cliente+'</span></td>');
                    }else 
                    {
                        items.push('<td class="recepcion llegada"><input type="checkbox" id="check-ll-'+val.NoCita+'"><label class="check-tbcitas"></label><span class="span-ll"></span></td>');
                    }
                    
                    if(at_cliente != "")
                    {
                        items.push('<td class="recepcion atencion btn-'+color_at+'"><input type="checkbox" id="check-at-'+val.NoCita+'" checked><label class="check-tbcitas"></label><span class="span-at">'+at_cliente+'</span></td>');
                    }else 
                    {
                        items.push('<td class="recepcion atencion"><input type="checkbox" id="check-at-'+val.NoCita+'"><label class="check-tbcitas"></label><span class="span-at"></span></td>');
                    }
                                 
                    items.push("<td class='recepcion' style='font-size: 10px;'>"  + val.Nombre_asesor + "</td>");
                    items.push("</tr>");
                });

                $("<tbody/>",{html: items.join("")}).appendTo("table");
                }
                $("#loading_spin").hide();
                if(perfil == 2){
                    $(".recepcion").show();
                }else{
                    $(".recepcion").hide();
                }
        }
    });
});
</script>
<style>
    #dia_anterior, #dia_siguiente { cursor: pointer; }
    
    table#table_recepcion tbody > tr { cursor: pointer; }
</style>
<!-- modal alta cliente -->
<div class="modal fade" id="modalAltaCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">
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
                    <label data-error="wrong" data-success="right" for="orangeForm-name">Nombre(s)</label>
                </div>
                <div class="md-form mb-5">
                    <i class="fa fa-male prefix grey-text"></i>
                    <input type="text" id="orangeForm-name" class="form-control validate[required]" name="apaterno_cli">
                    <label data-error="wrong" data-success="right" for="orangeForm-name">Apellido Paterno</label>
                </div>
                <div class="md-form mb-5">
                    <i class="fa fa-female prefix grey-text"></i>
                    <input type="text" id="orangeForm-name" class="form-control validate[required]" name="amaterno_cli">
                    <label data-error="wrong" data-success="right" for="orangeForm-name">Apellido Materno</label>
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

<!-- modal alta VIN -->
<div class="modal fade" id="modalAltaVin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?php 
                $attributes = array('id' => 'alta_vin');
                echo form_open('',$attributes);
            ?>
                <input type="hidden" name="id_cliente" id="id_cliente">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Alta VIN</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="row">
                        <div class="col-md-12">
                            <h4><small>Favor de dar de asignar el VIN en Intelisis para poder continuar con la operación</small></h1>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="md-form mb-4">
                                <i class="fa fa-calendar prefix grey-text"></i>
                                <input type="number" class="form-control validate[required]" id="anio_vin" name="anio_vin" maxlength="4"/>
                                <label data-error="wrong" data-success="right" for="orangeForm-name">Año</label>
                            </div>
                            <div class="form-inline md-form form-sm active-cyan-2">
                                <i class="fa fa-briefcase prefix grey-text"></i>
                                <input class="form-control form-control-sm mr-3 w-75 validate[required]" type="text" placeholder="Artículo" aria-label="Search" id="art_vin" name="art_vin">
                                <button type="button btn-primary" data-toggle="modal" data-target="#modalbusqArtAltaVin" class=""><i class="fa fa-search hvr-bob" aria-hidden="true"></i></button> 
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
                            <div class="md-form mb-4">
                                <i class="fa fa-paint-brush prefix grey-text"></i>
                                <input type="text" class="form-control validate[required]" id="color_vin" name="color_vin">
                                <label>Color</label>
                        </div>
                    </div> -->
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <!-- <button class="btn btn-deep-orange" id="btn_altaVin">Alta VIN</button> -->
                </div>
            <?php 
                echo form_close();
            ?>
        </div>
    </div>
</div>

<!-- modal alta Articulo -->
<div class="modal fade" id="modalAltaArt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">
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
                <div class="modal-body mx-3">
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <div class="md-form">
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
                            <div class="md-form">
                                <i class="fa fa-edit prefix grey-text"></i>
                                <textarea class="form-control md-textarea" id="descripcion_art" name="descripcion_art"></textarea>
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
                                <input type="number" id="orangeForm-name" class="form-control" id="numPartes_art" name="numPartes_art" value="1"readonly>
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

<!-- modal busqueda articulo para alta vin-->
<div class="modal fade" id="modalbusqArtAltaVin" tabindex="-1" role="dialog" aria-labelledby="modalbusqcli">
    <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buscar Artículo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group ui-front">
                                <label for="input_artAltaVin">Buscar:</label>
                                <input type="text" id="input_artAltaVin" name="input_artAltaVin" class="form-control">
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
                        <button type="button" id="btn_cerrarModArtVin" class="btn btn-secondary">Seleccionar</button>
                    </div>
                </div>
            </div>
    </div>
</div>
<script>
    $(document).ready(function() {
   $('.mdb-select').material_select();
 });
moment.lang('es', {
  months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
  monthsShort: 'Enero._Feb._Mar_Abr._May_Jun_Jul._Ago_Sept._Oct._Nov._Dec.'.split('_'),
  weekdays: 'Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado'.split('_'),
  weekdaysShort: 'Dom._Lun._Mar._Mier._Jue._Vier._Sab.'.split('_'),
  weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_')
});
$("#miscitasdia").text(moment().format("LLL"));
</script>