/*se pone aquí porque es la vista que carga por default, en refacciones debe cargar el histórico por eso se hace el cambio de vista*/
if(id_perfil != 0)                                                                      //importante!!
{
    switch(id_perfil)                                                               
    {
        case "8":
        case "7":
        case "6":
        case "5":
        case "4":
            window.location.href = site_url+"buscador/ver_historico";
        break;
        default:
        //
        break;
    }
}
$(document).ready(function(){
    id = 0;
    tipo = 0;
    var hora_cita = "";
    var no_cita = "";
    $("input[name='tipo']").eq(0).trigger("click");
    $("#alta_cliente, #alta_vin, #alta_articulo").validationEngine("attach",{promptPosition : "topLeft"});
    $(".botones_alta").hide();

    $("#querysearch").keydown(function(e){
        if(e.keyCode == 13)
        {
          event.preventDefault();
          return false;
        }
    });

    $("#querysearch").autocomplete({
        source: function( request, response ) {
            $("#loading_spin").show();
            $.ajax({
                cache: false,
                url: site_url+"buscador/busqueda/",
                type: 'post',
                dataType: "json",
                data: {
                    busqueda: $("#querysearch").val(),
                    tipo: $("input[name='tipo']:checked").val()
                },
                success: function( data ) 
                {
                    // console.log(data)
                    if(data.estatus == "ok" && data.resultado.length > 0)
                    {
                        $("#loading").hide();
                        response(data.resultado);
                    }
                    else
                    {
                        var tipo = $("input[name='tipo']:checked").val()
                        $.confirm({
                            title: 'No se encontraron resultados',
                            content: '¿Qué desea hacer?',
                            buttons: {
                                nueva_busqueda: {
                                    text: 'Nueva Búsqueda',
                                    btnClass: 'btn-blue',
                                    action: function(){
                                        $("#querysearch").val("");
                                    }
                                }/*,
                                agregar: {
                                    text: 'Dar de Alta',
                                    btnClass: 'btn-blue',
                                    action: function(){
                                        if($("#option1").parent().hasClass("active"))
                                        {
                                            $(".botones_alta").show();   //que salgan los 3 botones
                                        }

                                        if($("#option2").parent().hasClass("active") || $("#option3").parent().hasClass("active"))
                                        {
                                            $("#boton_acliente").parent().show();          // que salga el boton de cliente y en placa seria lo mismo que vin
                                        }
                                    }
                                }*/
                            },
                            theme: 'material'
                        });
                    }
                    $("#loading_spin").hide();
                },
                error: function( jqXHR, textStatus, errorThrown )
                {
                    alert( 'Ocurrio un error, por favor vuelve a intentar.' );
                }
              
            });
        },
        minLength: 3,
        select: function( event, ui ) {
            console.log(ui);
            id = ui.item.id;
            if( $("input[name='tipo']:checked").val() == 2 ||  $("input[name='tipo']:checked").val() == 3)
            {
                $("#id_usuario, #id_cliente").val(ui.item.id_cliente);
                tipo = $("input[name='tipo']:checked").val();

                localStorage.setItem("nom_cliente", ui.item.nombre);
                localStorage.setItem("ap_cliente", ui.item.ap_paterno);
                localStorage.setItem("am_cliente", ui.item.ap_materno);
            }else
            {
                $("#id_usuario, #id_cliente").val(ui.item.id);
                tipo = $("input[name='tipo']:checked").val();

                localStorage.setItem("nom_cliente", ui.item.nombre);
                localStorage.setItem("ap_cliente", ui.item.ap_paterno);
                localStorage.setItem("am_cliente", ui.item.ap_materno);   
            }
            
        },
        open: function() {
            $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
        }
    });

    /*$("#proceder_c").on("click", function(e){
        e.preventDefault();
        console.log('clic');
        $("body").load( site_url+"buscador/resultados", { id: id, tipo: tipo } );
    });*/
     $("#buscar").on("click", function(e){
        e.preventDefault();

        if($("#querysearch").val() == "")
        {
            toastr.error("El campo de búsqueda se encuentra vacío");
            
            return false;
        }

        

        $("body #detalle").load( site_url+"buscador/resultadosprincipal", { id: id, tipo: $("input[name='tipo']:checked").val() } );

        if($("#option1").parent().hasClass("active") && id != 0)
        {
            /*$("#boton_avin").parent().show();
            $("#boton_aarticulo").parent().show();*/
        }

        if(($("#option2").parent().hasClass("active") || $("#option3").parent().hasClass("active")) && id != 0)
        {
            // $("#boton_acliente").parent().show();
        }
    });
    $("#photo_button").on("click",function(e){
        e.stopPropagation();
        $("#fileOcr").click();
    });

    var seleccionado = "";
    $("#input_artAltaVin").autocomplete({
        source: function(request, response){
            var cadena = $("#input_artAltaVin").val();
            
            $('#spinner').show();

            $.ajax({
                cache: false,
                url: site_url+"buscador/autocomplete_artAltaVin/",
                type: 'POST',
                dataType: 'json',
                data: {cadena: cadena}
            })
            .done(function(data) {
                $('#spinner').hide();

                if(data.length > 0)
                {
                    response( $.map( data, function( item ) {
                        $("#descr_vin").val(item.descrip);
                        return {
                        label: item.descrip,
                        value: item.art
                        }
                    }));

                }else 
                {
                    toastr.error("No se encontraron resultados");
                }
            })
            .fail(function() {
                alert("Hubo une error al buscar el artículo")
});
        },
        minLength: 3,
        select: function(event, ui){
            seleccionado = ui.item.value;
        }
    });

    $("#btn_cerrarModArtVin").on("click", function(e){
        e.preventDefault();

        $("#modalbusqArtAltaVin").modal("hide");
        $("#art_vin").val(seleccionado);
    });
}); //termina el document ready


function resizeImg(file){
    console.log("gio");
    var imgPath = $("#fileOcr")[0].value;
    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
    if ( extn == "png" || extn == "jpg" || extn == "jpeg") {
        $("#loading_spin").show();
        // $("#canvas").show();
        // $("#canvas2").show();
        var ctx = document.getElementById('canvas').getContext('2d');
        var ctx2 = document.getElementById('canvas2').getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        var img = new Image;
        img.src = URL.createObjectURL(file.target.files[0]);
        img.onload = function() {
            var MAX_WIDTH = canvas.width;
            var MAX_HEIGHT = canvas.height;
            var tempW = img.width;
            var tempH = img.height;
            if (tempW > tempH) {
                if (tempW > MAX_WIDTH) {
                   tempH *= MAX_WIDTH / tempW;
                   tempW = MAX_WIDTH;
                }
            } else {
                if (tempH > MAX_HEIGHT) {
                   tempW *= MAX_HEIGHT / tempH;
                   tempH = MAX_HEIGHT;
                }
            }
            ctx.drawImage(img, 0, -40,tempW,tempH);
            var sourceCanvas = document.getElementById('canvas');
            ctx2.drawImage(sourceCanvas, -15, -10,MAX_WIDTH,MAX_HEIGHT);
            scan_img(ctx2);
        }
        
    }else{
        alert("Por favor elija un archivo de IMAGEN");
    }
}
function scan_img(ctx){
    console.log("luis");
    document.querySelector("#fileOcr").innerHTML = ''
    Tesseract.recognize(ctx, {
        lang: 'eng'
    })
    .then(function(info){
        var newStr = info.text.replace(/-/g, "");
        console.log(info.text);
        $("#loading_spin").hide();
        $.confirm({
            title: 'Texto Escaneado!',
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label>¿Desea buscar esta placa?</label>' +
            '<input type="text" value="'+newStr+'" class="name form-control" required />' +
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: 'Buscar',
                    btnClass: 'btn-green',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if(!name){
                            $.alert('favor de escribir un número de placa');
                            return false;
                        }
                        search_no(newStr);
                    }
                },
                cerrar: {
                    text: 'cancelar',
                    btnClass: 'btn-dark',
                    action: function () {
                        //close
                    }
                },
            },
            theme: 'material'
        });
    })
}
function search_no(num_placa){
    $("#loading_spin").show();
    $.ajax({
        cache: false,
        url: site_url+"buscador/busqueda/",
        type: 'post',
        dataType: "json",
        data: {
            busqueda: num_placa,
            tipo: 3
        },
        success: function( data ) 
        {
            if(data.estatus == "ok" && data.resultado.length > 0)
            {
                $("#loading_spin").hide();
                var id_d = data.resultado[0]['id'];
                console.log(id_d);
                $("body").load( site_url+"buscador/resultadosprincipal", { id:id_d , tipo: 3 } );
            }
            else
            {
                $.confirm({
                    title: 'No se encontraron resultados',
                    content: '¿Qué desea hacer?',
                    buttons: {
                        nueva_busqueda: {
                            text: 'Nueva Búsqueda',
                            btnClass: 'btn-blue',
                            action: function(){
                                $("#querysearch").val("");
                            }
                        }/*,
                        agregar: {
                            text: 'Dar de Alta',
                            btnClass: 'btn-blue',
                            action: function(){
                                $("body").load(site_url+"buscador/sin_resultados");
                            }
                        }*/
                    },
                    theme: 'material'
                });
            }
            $("#loading_spin").hide();
            var control = $("#fileOcr");
            control.replaceWith( control.val('').clone( true ) );
        },
        error: function( jqXHR, textStatus, errorThrown )
        {
            alert( 'Ocurrio un error, por favor vuelve a intentar.' );
            $("#loading_spin").hide();
        }
      
    });
}

//Botones Alta cliente, vin y articulo
$(document).on("click", '#boton_acliente', function (e){
    e.preventDefault();
    $("#modalAltaCliente").modal("show");
});

$(document).on("change", '#check_rfc', function (e){
    val = this.checked;

    if(val){
        $('#rfcinput').focus();
        $("#rfcinput").val('XAXX010101000');
    }else{
        $("#rfcinput").val('');
    }
});

//formar fecha 
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}
function validar_rfc(rfc)
{
    var expresion = /^[a-zñ&A-ZÑ&]{3,4}(\d{6})((\D|\d){3})?$/;

    if(expresion.test(rfc))
    {
        return true;
    }else
    {
        return false;
    }
}

var nuevo_clienteId = 0;
function guardar_cliente(datos)
{
    return  $.ajax({
            cache: false,
            url: site_url+"buscador/guardar_nuevoCliente",
            type: 'POST',
            dataType: 'json',
            data: datos
            })
            .done(function(data) {
                if(data["estatus"])
                {
                    nuevo_clienteId = data["id"];
                    id = data["id"];

                    $("#id_usuario, #id_cliente").val(nuevo_clienteId);

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

$(document).on("click", '#btn_altaCli', function (e){
    e.preventDefault();
    var rfc = $("#rfcinput").val();
    var nombre_ok = $("#orangeForm-name").val();
    var rfc_ok = validar_rfc(rfc);
    var form = $("#alta_cliente").serialize();

    if(nombre_ok != "" && rfc_ok)
    {   
        $.when(guardar_cliente(form)).then(function(x)
        {
            $("body #detalle").load( site_url+"buscador/resultadosprincipal", { id: nuevo_clienteId, tipo: 1 } );

            $("#querysearch").val(nombre_ok);
     
            setTimeout(function(){ 
                $("#cliente_seleccionado").text(nombre_ok);
                $("#boton_acliente").hide();
            }, 1000);

        });         
    }else
    {
        if(nombre_ok == "" && !rfc_ok)
        {
            $.alert({
                title: 'Por favor, revise los datos del cliente',
                content: 'Debe escribir el nombre completo y un RFC válido',
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
            $("#anio_vin, #pasaj_vin, #art_vin, #trans_vin, #vin_vin, #tipovqc_vin, #descr_vin, #motorlts_vin, #cil_vin, #cilqc_vin, #puertas_vin, #input_artAltaVin").val("").focusout();
        break;
        default:
            //code block
        } 
}

$(document).on("click", '#boton_avin', function (e){
    e.preventDefault();
    $("#modalAltaVin").modal("show");
});

$(document).on("click", '#btn_altaVin', function (e){
    e.preventDefault();
    var fvalido = $("#alta_vin").validationEngine("validate");
    var form = $("#alta_vin").serialize();
    var vin = $("#vin_vin").val();

    if(fvalido)
    {
        if(vin.length == 17)
        {
            $.when(guardar_vin(form)).then(function(x)
            {   
                if($("#hayvin").val() == "0")
                    $("body #detalle").load( site_url+"buscador/resultadosprincipal", { id: id, tipo: 1 } );
                else
                {
                    $.ajax({
                        cache: false,
                        url: site_url+"/buscador/actualizavin/"+vin+"/"+$("#citaseleccionada").val(),
                        dataType: "json",
                        success: function( data ) 
                        {
                            if(data.saved == "ok")
                                location.reload();
                            else
                                alert("Error al guardar el vin");

                        },
                        error: function( jqXHR, textStatus, errorThrown )
                        {
                          alert( 'Ocurrio un error, por favor vuelve a intentar.' );
                        }
                    });

                    $("#hayvin").val("0");
                    $("#citaseleccionada").val("0");
                }
            });      
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
    return $.ajax({
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
      
$(document).on("click", '#boton_aarticulo', function (e){
    e.preventDefault();
    $("#modalAltaArt").modal("show");
    });

$(document).on("click", '#btn_altaArt', function (e){
    e.preventDefault();
    var fvalido = $("#alta_articulo").validationEngine("validate");
    var form = $("#alta_articulo").serialize();

    if(fvalido)
    {
        guardar_articulo(form);
}
});
      
function guardar_articulo(datos)
{
    return $.ajax({
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

$(document).on("blur", '#clave_art', function (){
    var codFabr = $("#codFabr_art");
    codFabr.focus().val(this.value);
});

function obtener_horasMinutos(hora){
    var string = hora.split(" ");
    string = string[1].split(".");
    string = string[0].split(":");
    string = string[0]+":"+string[1];

    return string;
}
function obtener_colorEstatus(hora_registrada, hora_cita){
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