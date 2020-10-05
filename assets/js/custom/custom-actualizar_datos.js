$(document).ready(function(){
	console.log('update...');
	
 	var id = $("#id_c").val();
    var tipo =$("#tipo_c").val();

	$.ajax({
        url: base_url+ "index.php/user/cargar_datos_id",
        type: "POST",
        dataType: 'json',
        data: ({ id: id } ),
        beforeSend: function(){
        	$("#loading_spin").show();    
       	},
        error: function(){
            console.log('error');
        },
        success: function (data){
            $("#loading_spin").hide();
            result = eval(data);
            //console.log(data);
            //validation
            $("#nombre_cliente").val(data[0]['Nombre']);
            $("#telefono_cliente").val(data[0]['Telefonos']);
            $("#celular_cliente").val(data[0]['PersonalTelefonoMovil']);
            $("#email_cliente").val(data[0]['email1']);
            $("#rfc_cliente").val(data[0]['RFC']);
            $("#direc_cliente").val(data[0]['Direccion']);
            $("#no_ext_cliente").val(data[0]['DireccionNumero']);
            $("#no_int_cliente").val(data[0]['DireccionNumeroInt']);
            $("#colonia_cliente").val(data[0]['Colonia']);
            $("#poblacion_cliente").val(data[0]['Poblacion']);
            $("#edo_cliente").val(data[0]['Estado']);
            $("#cp_cliente").val(data[0]['CodigoPostal']);

        }
	});


	$("#btn_UpdateCli").on("click", function(e){
		e.preventDefault();
		var form = $("#update_cliente").serialize();
		actualizar_cliente(form);
	});

	function actualizar_cliente(datos){
		$.ajax({
			cache: false,
        	url: site_url+"user/actualiza_ciente_id",
			type: 'POST',
			dataType: 'json',
			data: datos
		})
		.done(function(data) {
			//data = eval("("+data+")");
			if(data.success == 1){
				$.confirm({
                    title: 'Cliente actualizado exitosamente',
                    content: 'Se ha actualizado el cliente',
                    buttons: {
                            confirmar: {
                                text: 'OK',
                                btnClass: 'btn-blue',
                                action: function(){
                                    //$("body").load(site_url);
                                    $("body").load( site_url+"buscador/resultados", { id: id, tipo: tipo } );
                                }
                            }
                    },
                    theme: 'material'
            	});
			}else{
				$.alert({
					title: 'Hubo un error al actualizar el cliente',
					content: 'Por favor, intente de nuevo err_code: #300',
					theme: 'material'
				});
			}
		})
		.fail(function() {
			$.alert({
				title: 'Hubo un error al actualizar el cliente',
				content: 'Por favor, intente de nuevo',
				theme: 'material'
			});
		});
	}


    /* QR */
    $('.generate-qr-code').on('click', function(){
    // Clear Previous QR Code
    $('#qrcode').empty();
    // Set Size to Match User Input
    $('#qrcode').css({
        'width' : $('.qr-size').val(),
        'height' : $('.qr-size').val()
    })
    // Generate and Output QR Code
    $('#qrcode').qrcode({width: $('.qr-size').val(),height: $('.qr-size').val(),text: $('.qr-url').val()});
    });
});


