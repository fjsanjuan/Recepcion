$(document).ready(function() {
    $("#alta_cliente, #alta_vin, #alta_articulo").validationEngine("attach",{promptPosition : "topLeft"});
    $('#json-datalist').empty();
    $('input:radio[name=asesor_grp]').change(function() {
        if (this.value == 'sin') {
             $('#form_asesor').fadeOut( "slow");
        }
        else if (this.value == 'con') {
             $('#form_asesor').fadeIn( "slow");
        }
    });
    
    $('input:radio[name=orden_ag]').change(function() {
        if (this.value == 'sinc') {
             $('#form_tec_ordn').fadeOut( "slow");
        }
        else if (this.value == 'conc') {
             $('#form_tec_ordn').fadeIn( "slow");
        }
    });


    $('input:radio[name=cita_ag]').change(function() {
        if (this.value == 'sinc') {
             $('#form_asesor_ordn').fadeOut( "slow");
        }
        else if (this.value == 'conc') {
             $('#form_asesor_ordn').fadeIn( "slow");
        }
    });

    $("#ajax").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url:site_url+"buscador/buscar_cliente",
                    data:  {term : request.term},
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
                    response(data);

                    var dataList = $("#json-datalist");
                    var long = Object.keys(data).length;
                    //var input = document.getElementById('ajax');
                    //console.log(long);
                    //console.log('data: ' +data[1]['value']);
                    for (var i=1; i <= long ; i++) {
                        var str = data[i]['value'];
                        str = str.replace(/ +(?= )/g,'');
                        dataList.append('<option value="'+str+'">' +data[i]['id_cliente']+'</option>');
                    }
                    $("#ajax").on('input', function () {
                        var val = this.value;
                        if($('#json-datalist option').filter(function(){
                            return this.value === val;        
                        }).length) {
                            //send ajax request
                            $('#json-datalist').empty();
                            $('#orden_cliente').val(this.value);
                            $('#modalbusqcli').modal('hide');
                        }
                    });
                },
                error : function(xhr, status) {
                    alert('Disculpe, existió un problema');
                }
            });
        },
            minLength: 3,
    });
    // busqueda articulo 
    $("#ajax_art").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: site_url+"buscador/buscar_art",
                    data:  {term : request.term},
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
                    response(data);
                    var dataList = $("#json-datalist-art");
                    var long = Object.keys(data).length;
                    //var input = document.getElementById('ajax');
                    //console.log(long);
                    //console.log('data: ' +data[1]['value']);
                    for (var i=1; i <= long ; i++) {
                        var str = data[i]['art'];
                        str = str.replace(/ +(?= )/g,'');
                        dataList.append('<option value="'+str+'">' +data[i]['descrip']+'</option>');
                    }
                    $("#ajax_art").on('input', function () {
                        var val = this.value;
                        if($('#json-datalist-art option').filter(function(){
                            return this.value === val;        
                        }).length) {
                            //send ajax request
                            $('#json-datalist-art').empty();
                            $('#orden_articulo').val(this.value);
                            $('#modalbusqart').modal('hide')
                        }
                    });
                },
                error : function(xhr, status) {
                    alert('Disculpe, existió un problema');
                }
            });
        },
            minLength: 3,
    });
    //on seleccionar
    $( "#selciente" ).click(function() {
        var val = $("#ajax").val();
        $('#orden_cliente').val(val);
        $("#ajax").empty();
        $('#modalbusqcli').modal('hide')
        
    });

    function inicializar(){
        $("#orden_cliente").val($("#us_seleccionado").val());
        $("#cita_cliente").val($("#us_seleccionado").val());
        $("#orden_articulo").val($("#art_seleccionado").val());
        $("#cita_articulo").val($("#art_seleccionado").val());
        
    }

    inicializar();

    var trigger = "";
    var modal_activo = "";

    $("#btn_acCliente").on("click", function(e){
        e.preventDefault();
        trigger = e.target.id;

        $("#modalContactForm2").modal("hide");
        $("#modalAltaCliente").modal("show");
        sessionStorage.setItem("trigger", trigger);
    });

    $("#btn_acArt").on("click", function(e){
        e.preventDefault();
        trigger = e.target.id;

        $("#modalContactForm2").modal("hide");
        $("#modalAltaArt").modal("show");
        sessionStorage.setItem("trigger", trigger);
    });

    $("#btn_acVin").on("click", function(e){
        e.preventDefault();
        trigger = e.target.id;
        $("#modalContactForm2").modal("hide");
        $("#modalAltaVin").modal("show");
        sessionStorage.setItem("trigger", trigger);
    });

    $("#btn_aoCliente").on("click", function(e){
        e.preventDefault();
        trigger = e.target.id;

        $("#modalContactForm").modal("hide");
        $("#modalAltaCliente").modal("show");
        sessionStorage.setItem("trigger", trigger);
    });

    $("#btn_aoArt").on("click", function(e){
        e.preventDefault();
        trigger = e.target.id;

        $("#modalContactForm").modal("hide");
        $("#modalAltaArt").modal("show");
        sessionStorage.setItem("trigger", trigger);
    });

    $("#btn_aoVin").on("click", function(e){
        e.preventDefault();
        trigger = e.target.id;

        $("#modalContactForm").modal("hide");
        $("#modalAltaVin").modal("show");
        sessionStorage.setItem("trigger", trigger);
    });

    $("#modalAltaCliente").on("hidden.bs.modal", function(){
        modal_activo = sessionStorage.getItem("trigger");
        switch(modal_activo) 
        {
            case "btn_acCliente":
                $("#modalContactForm2").modal("show");
            break;
            case "btn_aoCliente":
                $("#modalContactForm").modal("show");
            break;
            default:
                //code block
        }  
    });

    $("#modalAltaArt").on("hidden.bs.modal", function(){
        modal_activo = sessionStorage.getItem("trigger");

        switch(modal_activo) 
        {
            case "btn_acArt":
                $("#modalContactForm2").modal("show");
            break;
            case "btn_aoArt":
                $("#modalContactForm").modal("show");
            break;
            default:
                //code block
        } 
    });

    $("#modalAltaVin").on("hidden.bs.modal", function(){
        modal_activo = sessionStorage.getItem("trigger");
        
        switch(modal_activo) 
        {
            case "btn_acVin":
                $("#modalContactForm2").modal("show");
            break;
            case "btn_aoVin":
                $("#modalContactForm").modal("show");
            break;
            default:
                //code block
        } 
    });

    $("#check_rfc").change(function(){
        val = this.checked;

        if(val){
            $('#rfcinput').focus();
            $("#rfcinput").val('XAXX010101000');
        }else{
            $("#rfcinput").val('');
        }
    });

    function validar_rfc(rfc){
        var expresion = /^[a-zñ&A-ZÑ&]{3,4}(\d{6})((\D|\d){3})?$/;

        if(expresion.test(rfc))
        {
            return true;
        }else
        {
            return false;
        }
    }

    $("#btn_altaCli").on("click", function(e){
        e.preventDefault();
        var rfc = $("#rfcinput").val();
        var nombre_ok = $("#orangeForm-name").val();
        var rfc_ok = validar_rfc(rfc);
        var form = $("#alta_cliente").serialize();

        if(nombre_ok != "" && rfc_ok)
        {
            guardar_cliente(form);
        }else
        {
            if(nombre_ok == "" && !rfc_ok)
            {
                $.alert({
                    title: 'Por favor, revise los datos del cliente',
                    content: 'Debe escribir el nombre y un RFC válido',
                    theme: 'material'
                });
            }else 
            {
                if(nombre_ok == "")
                {
                    $.alert({
                        title: 'Por favor, revise los datos del cliente',
                        content: 'Debe escribir el nombre',
                        theme: 'material'
                    });
                }

                if(!rfc_ok)
                {
                    $.alert({
                        title: 'Por favor, revise los datos del cliente',
                        content: 'El RFC no tiene una estructura válida',
                        theme: 'material'
                    });
                }
            }       
        }
    });

    function guardar_cliente(datos){
        $.ajax({
            cache: false,
            url: site_url+"buscador/guardar_nuevoCliente",
            type: 'POST',
            dataType: 'json',
            data: datos
        })
        .done(function(data) {
            if(data["estatus"])
            {
                $.confirm({
                    title: 'Cliente guardado exitosamente',
                    content: 'Se ha guardado el nuevo cliente',
                    buttons: {
                            confirmar: {
                                text: 'OK',
                                btnClass: 'btn-blue',
                                action: function(){
                                    $("#modalAltaCliente").modal("hide");
                                    var modal = "cliente";
                                    reset_inputs(modal);
                                }
                            }
                    },
                    theme: 'material'
                });
            }else
            {
                if(data["error"]["code"] == "23000/2627")
                {
                    $.alert({
                        title: 'Hubo un error al guardar el cliente',
                        content: 'La clave del cliente se encuentra duplicada, favor de revisar',
                        theme: 'material'
                    });
                }else 
                {
                    $.alert({
                        title: 'Hubo un error al guardar el cliente',
                        content: data["error"]["message"],
                        theme: 'material'
                    });
                }   
            }
        })
        .fail(function() {
            $.alert({
                title: 'Hubo un error al guardar el cliente',
                content: 'Por favor, intente de nuevo',
                theme: 'material'
            });
        });
    }

    var codFabr = $("#codFabr_art");
    $("#clave_art").blur(function(){
        codFabr.focus().val(this.value);
    });

    $("#btn_altaArt").on("click", function(e){
        e.preventDefault();
        var fvalido = $("#alta_articulo").validationEngine("validate");
        var form = $("#alta_articulo").serialize();

        if(fvalido)
        {
            guardar_articulo(form);
        }
    });

    function guardar_articulo(datos){
        $.ajax({
            cache: false,
            url: site_url+"buscador/guardar_nuevoArt",
            type: 'POST',
            dataType: 'json',
            data: datos
        })
        .done(function(data) {
            if(data["estatus"])
            {
                $.confirm({
                    title: 'Artículo guardado exitosamente',
                    content: 'Se ha guardado el nuevo artículo',
                    buttons: {
                            confirmar: {
                                text: 'OK',
                                btnClass: 'btn-blue',
                                action: function(){
                                    $("#modalAltaArt").modal("hide");
                                    var modal = "articulo";
                                    reset_inputs(modal);
                                }
                            }
                    },
                    theme: 'material'
                });
            }else
            {
                if(data["error"]["code"] == "23000/2627")
                {
                    $.alert({
                        title: 'Hubo un error al guardar el artículo',
                        content: 'La clave del artículo se encuentra duplicada, favor de revisar',
                        theme: 'material'
                    });
                }else 
                {
                    $.alert({
                        title: 'Hubo un error al guardar el artículo',
                        content: data["error"]["message"],
                        theme: 'material'
                    });
                }   
            }
        })
        .fail(function() {
            $.alert({
                title: 'Hubo un error al guardar el artículo',
                content: 'Por favor, intente de nuevo',
                theme: 'material'
            });
        });
    }

    $("#btn_altaVin").on("click", function(e){
        e.preventDefault();
        var fvalido = $("#alta_vin").validationEngine("validate");
        var form = $("#alta_vin").serialize();
        var vin = $("#vin_vin").val();

        if(fvalido)
        {
            if(vin.length == 17)
            {
                guardar_vin(form);
            }else
            {
                $.alert({
                        title: 'Vin incorrecto',
                        content: 'El vin debe contener 17 caracteres',
                        theme: 'material'
                });
            }
        }
    });

    function guardar_vin(datos)
    {
        $.ajax({
            cache: false,
            url: site_url+"buscador/guardar_nuevoVin",
            type: 'POST',
            dataType: 'json',
            data: datos
        })
        .done(function(data) {
            if(data["estatus"])
            {
                $.confirm({
                    title: 'Vin guardado exitosamente',
                    content: 'Se ha guardado el nuevo vin',
                    buttons: {
                            confirmar: {
                                text: 'OK',
                                btnClass: 'btn-blue',
                                action: function(){
                                    $("#modalAltaVin").modal("hide");
                                    var modal = "vin";
                                    reset_inputs(modal);
                                }
                            }
                    },
                    theme: 'material'
                });
            }else
            {
                if(data["error"]["code"] == "23000/2627")
                {
                    $.alert({
                        title: 'Hubo un error al guardar el vin',
                        content: 'El vin se encuentra duplicado, favor de revisar',
                        theme: 'material'
                    });
                }else 
                {
                    $.alert({
                        title: 'Hubo un error al guardar el vin',
                        content: data["error"]["message"],
                        theme: 'material'
                    });
                }   
            }
        })
        .fail(function() {
            $.alert({
                title: 'Hubo un error al guardar el vin',
                content: 'Por favor, intente de nuevo',
                theme: 'material'
            });
        });
    }

    function reset_inputs(modal)
    {
        switch(modal) 
        {
            case "cliente":
                $("#orangeForm-name, #rfcinput").val("").focusout();
                $("#check_rfc").prop("checked", false);
            break;
            case "articulo":
                $("#clave_art, #codFabr_art, #descripcion_art, #numPartes_art").val("").focusout();
            break;
            case "vin":
                $("#anio_vin, #pasaj_vin, #art_vin, #trans_vin, #vin_vin, #tipovqc_vin, #descr_vin, #motorlts_vin, #cil_vin, #cilqc_vin, #puertas_vin").val("").focusout();
            break;
            default:
                //code block
        } 
    }

   /* $("#table_citas tr, #table_vin tr").on("click", function(){
        var tipo = $(this).parent().parent().attr("id");
        var id = $(this).attr("id");

        $.ajax({
            cache: false,
            type: 'post',
            url: base_url+"index.php/buscador/detalle_ordenunidad/",
            dataType: "json",
            data: {
                tipo: tipo,
                id: id,
            },
        })
        .done(function(data){
            
        })
        .fail(function() {
            
        });         

    });*/

    $("#orden_ser").on("click", function(){
        $("#modalContactForm").modal("show");
    });

    $("#horario_asesor").on("click", function(){
        $('#modal_asesor').modal('show');
    });

    $("#buscar_art").on("click", function(){
        $('#modalbusqart').modal('show');
    });
    
});
