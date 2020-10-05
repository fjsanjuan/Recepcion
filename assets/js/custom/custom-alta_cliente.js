$(document).ready(function(){
	$("#alta_cliente").validationEngine("attach",{promptPosition : "topLeft"});

	$("#check_rfc").change(function(){
	    val = this.checked;

	    if(val){
	    	$('#rfcinput').focus();
	    	$("#rfcinput").val('XAXX010101000');
	    }else{
			$("#rfcinput").val('');
	    }
	});

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
	function guardar_cliente(datos)
	{
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
                                    //$("body").load(site_url);
                                    $("body").load( site_url+"buscador/resultados", { id: data['id'], tipo: 1 } );
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
	$("#modalRegisterForm").modal('show');
});