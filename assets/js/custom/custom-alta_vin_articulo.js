$(document).ready(function(){
	$("#alta_vin, #alta_articulo").validationEngine("attach",{promptPosition : "topLeft"});

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

	function guardar_articulo(datos)
	{
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
                                    $("body").load(site_url);
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
                                    $("body").load(site_url);
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
	$("#modalAltaVin").modal('show');

	$("#btn_acArt").on("click", function(e){
        e.preventDefault();
        trigger = e.target.id;
        $("#modalAltaVin").modal('hide');
        $("#modAltaArt").modal("show");
        sessionStorage.setItem("trigger", trigger);
    });
    $("#btn_acVin").on("click", function(e){
        e.preventDefault();
        trigger = e.target.id;
        $("#modAltaArt").modal("hide");
        $("#modalAltaVin").modal("show");
        sessionStorage.setItem("trigger", trigger);
    });
});