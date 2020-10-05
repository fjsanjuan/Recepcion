$(document).ready(function() {

    var data_from_ajax; 
    var horaInicial; 
    var horaFinal;

    $.get(base_url+ 'index.php/buscador/ver_horariosAg', function(data) {
    }).done(function (data){
        data_from_ajax = data;
        var obj = JSON.parse(data_from_ajax);
        var sizeof = obj.length;
        horaInicial = obj[0]['Hora'];
        horaFinal = obj[sizeof-1]['Hora'];

        $('#calendar').fullCalendar({
            dayClick: function(date, jsEvent, view, resourceObj) {
            var ini =  date.format();

            var iniReq = date.format('DD-MM-YYYY');

            //console.log(iniReq);    

            var resource = resourceObj.id;
            $('#fecha_cita_hid').val(ini);
            $("#new_fecha_recep").val(iniReq);
            $('#new_recepcion').val(ini.substring(11,16));
            $('#new_asesor').val(resource);
           

            var reqhid = $("#new_requerida").val();

            $("#add_event").click();
     
            },
            
            eventClick: function(event) {

                var id= event.id;
                $.ajax({
                    url: base_url+ "index.php/servicio/detalle_cita",
                    type: "POST",
                    dataType: 'json',
                    data: ({ id: id } ),

                    success: function(data){

                        //console.log(data);
                        swal({
                        title: "Detalle", 
                        html: 
                                 "<b>Cliente:</b> "+ data[0]['Nombre'] + '<br>' +
                                 "<b>Fecha recepcion:</b> "+ data[0]['FechaRecepcion'].substring(0,10) + '<br>'+
                                 "<b>Hora recepcion:</b> " + data[0]['HoraRecepcion'] +'<br>'+
                                 "<b>Fecha Entrega: </b>" + data[0]['FechaRequerida'].substring(0,10) +'<br>'+
                                 "<b>Hora Entrega: </b>" + data[0]['HoraRequerida'] +'<br>'+
                                 "<b>VIN: </b>" +data[0]['ServicioSerie'] 
                              
                        });
                    }
                });
                
            },
        schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
        defaultView: 'timelineDay',
        now: '2018-05-21',
        editable: true,
        aspectRatio: 1.8,
        minTime: horaInicial+':00',
        maxTime: horaFinal+':00',
        businessHours: {
            dow: [ 1, 2, 3, 4, 5, 6], // Monday - saturday
            start: '08:00', // a start time (8am in this example)
            end: '19:00', // an end time (7pm in this example)
        },
        events: {
            cache: true
        },
        resources: base_url+'index.php/servicio/obtener_asesores',
        eventSources: [
                base_url+'index.php/servicio/obtener_citas',
        ],
        });
    }).fail(function( data, textStatus, jqXHR){
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
        }
    });

        /** para tecnicos */ 
    $.get(base_url+ 'index.php/buscador/ver_horariosAg', function(data){
    }).done(function(data){
        data_from_ajax = data;
        var obj = JSON.parse(data_from_ajax);
        var sizeof = obj.length;
        horaInicial = obj[0]['Hora'];
        horaFinal = obj[sizeof-1]['Hora'];

        $('#calendar_tecnicos').fullCalendar({

            dayClick: function(date, jsEvent, view, resourceObj) {
                var ini =  date.format();
                var resource = resourceObj.id;
                $('#fecha_cita_hidd').val(ini);
                $('#new_recepcion_tec').val(ini.substring(11,16));


                $('#new_tecnico').val(resource);

                $("#add_event_tec").click();
            },
            
            eventClick: function(event) {
                swal({
                    title: 'Detalle',
                    icon: "info"
                });
          
            },
            schedulerLicenseKey:"GPL-My-Project-Is-Open-Source",
            defaultView:"timelineDay",
            now: '2018-05-21',
            editable: true,
            aspectRatio: 1.8,
            minTime: horaInicial + ':00',
            maxTime:horaFinal + ':00',
            businessHours:{
            dow: [ 1, 2, 3, 4, 5, 6], // Monday - saturday
            start: '08:00', // a start time (8am in this example)
            end: '19:00', // an end time (7pm in this example)
        },
        resources: base_url + 'index.php/servicio/obtener_tecnicos',
        eventSources: [
            base_url+'index.php/servicio/obtener_citas_tecnicos',
        ],
        });
    }).fail(function(data, textStatus,jqXHR){
    });

});

    $("#create_date").click(function(e) {
        e.preventDefault();
        console.log('Ready create');
        $.ajax({
            type: "POST",
            url: base_url + "index.php/servicio/create_date",
            data: { 
                id: $(this).val(), // < note use of 'this' here
                access_token: $("#access_token").val() 
            },
            beforeSend: function( ) {
                var myCalendar = $('#calendar');
                var start = $('#fecha_cita_hid').val();
                var end = $("#new_hr_req").val();
                var hrfinal =start.substring(0,10)+'T'+ end + ':00';
                var fechaReq = $("#new_fecha_recep").val();
                var reqhid = $("#new_requerida").val();
                //console.log(hrfinal);
                myCalendar.fullCalendar();
                var title = "Cita";
                var assr = $("#new_asesor").val()
                var myEvent = {
                    title: title,
                    resourceId: assr,
                    start: start,
                    end: hrfinal,
                    color: "#9966ff"
                };
                myCalendar.fullCalendar( 'renderEvent', myEvent );

                $("#fulldate").val(start);
                $("#fecha_requerida").val(reqhid);
                $("#cita_fecha").val(start.substring(0,10));
                $("#cita_hr_ini").val(start.substring(11,16));
                $("#cita_hr_fin").val(end);
                $("#cita_agente").val(assr);

            },
            success: function(result) {
               //$("#modal_asesor").modal('hide');
            $("#modal_newdate").modal('toggle');
            $("#guardar_cita").show("fade");  
               //$("#close_newcita").click();
            },
            error: function(result) {
                alert('error');
            }
        });
    });

    var frm = $('#form_cita_servicio');

    $("#guardar_cita").click(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url:  base_url+'index.php/servicio/nueva_cita',
            data: frm.serialize() 
        })
        .done(function(data) {
            data = eval("("+data+")");
            if(typeof data.success != "undefined"){
                if(data.success==1){
                    //$form[0].reset();
                    swal({
                      icon:'success',
                      text: data.data
                    });
                    history.go(-1);
                }else if(typeof data.errors != "undefined"){
                    var error_string = '';
                    for(key in data.errors){
                        error_string += data.errors[key];
                    }
                    swal({
                         icon: 'warning',
                        text: error_string,
                        html: true
                    });
                }else{
                    swal({
                        icon: 'error',
                        text: data.data
                    });
                }
            }else{
                swal({
                    icon: 'error',
                    text: data.error
                  });
            }
        })
        .fail(function() {
        })
        .always(function() {
            console.log( "done" );
        })
        
    });

    /** ordens ervicio */ 
    $("#create_date_tec").click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: base_url + "index.php/servicio/create_date",
            data: { 
                id: $(this).val(), // < note use of 'this' here
                access_token: $("#access_token").val() 
            },
            beforeSend: function( ) {
                var myCalendar2 = $('#calendar_tecnicos');
                var start = $('#fecha_cita_hidd').val();
                var end = $("#new_entrega_tec").val();
                var hrfinal =start.substring(0,10)+'T'+ end + ':00';
                myCalendar2.fullCalendar();
                var title = "Cita";
                var assr = $("#new_tecnico").val()
                var myEvent = {
                    title: title,
                    resourceId: assr,
                    start: start,
                    end: hrfinal,
                    color: "#9966ff"
                };
                myCalendar2.fullCalendar( 'renderEvent', myEvent );

                $("#fulldate2").val(start);
                $("#orden_fecha").val(start.substring(0,10));
                $("#orden_hr_ini").val(start.substring(11,16));
                $("#orden_hr_fin").val(end);
                $("#orden_agente").val(assr);

            },
            success: function(result) {
               //$("#modal_asesor").modal('hide');
               //$("#modal_newdate2").modal('hide');
               $("#close_newcita").click();
            },
            error: function(result) {
                alert('error');
            }
        });
    });

    var frm2 = $('#form_orden_servicio');

    $("#guardar_orden").click(function() {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url:  base_url+'index.php/servicio/nueva_orden',
            data: frm2.serialize() 
        })
        .done(function(data) {
            data = eval("("+data+")");
            if(typeof data.success != "undefined"){
                if(data.success==1){
                    //$form[0].reset();
                    swal({
                      icon:'success',
                      text: data.data
                    });
                }else if(typeof data.errors != "undefined"){
                    var error_string = '';
                    for(key in data.errors){
                        error_string += data.errors[key]+"<br/>";
                    }
                    swal({
                      icon: 'error',
                      html: error_string 
                    });
                }else{
                    swal({
                      icon: 'info',
                      html: data.data 
                    });
                }
            }else{
                swal({
                    icon: 'error',
                    text: data.error
                  });
            }
        })
        .fail(function() {
        })
        .always(function() {
            console.log( "done" );
        })
        
    });


   /*$("#cita_serv_btn").click(function(){
        $.get(base_url+ 'servicio/update_table_Asesores', function(data){
        }).done(function(data){
            console.log('go');

        }).fail(function( data, textStatus, jqXHR){
        if ( console && console.log ) {
            console.log( "La solicitud a fallado: " +  textStatus);
        }
        });
    });    */