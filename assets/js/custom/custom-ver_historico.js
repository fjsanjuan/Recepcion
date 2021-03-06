$(document).ready(function() {

	//variableque controlan la ruta donde se guardan las fotos de la inspeccion 
	//en este caso para poder vizualizarlas desde el historico
	var alias_exists = 'uploads';
	var dir_fotos= 'F:/recepcion_activa/fotografias/';

    // Data Picker Initialization
    id_presupuesto = 0;
	/*$('.datepicker').pickadate({
	  	monthsFull: [ 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre' ],
	    monthsShort: [ 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic' ],
	    weekdaysFull: [ 'domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado' ],
	    weekdaysShort: [ 'dom', 'lun', 'mar', 'mié', 'jue', 'vie', 'sáb' ],
	    weekday: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
	    today: '',
	    clear: 'Borrar',
	    close: 'Cerrar',
	    format: 'dd-mm-yyyy',
	    formatSubmit: 'dd-mm-yyyy',
	    labelMonthNext: 'Mes Siguiente',
		labelMonthPrev: 'Mes Anterior',
		labelMonthSelect: 'Seleccione un Mes',
		labelYearSelect: 'Seleccione un Año',
		selectYears: true,
  		selectMonths: true,
  		firstDay: 2,
  		closeOnSelect: true,
  		selectYears: 4,
  		max: true
	});*/

	$(".datepicker").flatpickr({
		"altInput": true,
    	"altFormat": "j F, Y",
    	"dateFormat": "Y-m-d",
		"locale": "es",
		onReady: function(dateObj, dateStr, instance) {
	        $('.flatpickr-calendar').each(function() {
	            var $this = $(this);
	            if ($this.find('.flatpickr-clear').length < 1) {
	                $this.append('<div class="flatpickr-clear">Borrar</div>');
	                $this.find('.flatpickr-clear').on('click', function() {
	                    instance.clear();
	                    instance.close();
	                });
	            }
	        });
	    }
	});

	var tabla_historico = $(".tabla_hist").dataTable(
    {
         "oLanguage": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ning&uacute;n dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "<i class='fa fa-step-backward'></i>",
                "sLast":     "<i class='fa fa-step-forward'></i>",
                "sNext":     "<i class='fa fa-forward'></i>",
                "sPrevious": "<i class='fa fa-backward'></i>"
                        },
            "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
            },
        "bSort": true,
        "bDestroy": true,
        "sPaginationType": "full_numbers",
        "pageLength": 5,
        "aoColumnDefs": [
            { 
            "bVisible": false, 
            "aTargets": [0]
            }
        ]
    });

	$("select.picker__select--month, select.picker__select--year").addClass("form-control");

	$.each($(".picker__weekday"), function(index, val) 
	{
		switch ($(this).prop("title")) 
		{
			case "lunes":
				$(this).text("L");
			break;
			case "martes":
				$(this).text("M");
			break;
			case "miércoles":
				$(this).text("M");
			break;
			case "jueves":
				$(this).text("J");
			break;
			case "viernes":
				$(this).text("V");
			break;
			case "sábado":
				$(this).text("S");
			break;
			case "domingo":
				$(this).text("D");
			break;
			default:
				//
			break;
		}
	});

	/*$("#btn_borrar_ini").on("click", function(e){
		e.preventDefault();

		$("#fecha_ini").prev().val("");
	});

	$("#btn_borrar_fin").on("click", function(e){
		e.preventDefault();

		$("#fecha_fin").val("");
	});*/

	$("#btn_mostrar").on("click", function(e){
		var fecha_ini = $("#fecha_ini").val();
		var fecha_fin = $("#fecha_fin").val();

		if(fecha_ini == "" || fecha_fin == "")
		{
			toastr.error("Por favor, seleccione una fecha inicio y una fecha fin.");
			return;
		}

		$("#loading_spin").show();

		$.ajax({
			cache: false,
			url: base_url+ "index.php/buscador/obtener_ordenesPasadas",
			type: 'POST',
			dataType: 'json',
			data: {fecha_ini: fecha_ini, fecha_fin: fecha_fin}
		})
		.done(function(data) {
			var tabla = "", nombre = "", folio = "";
			var btn1 = "", btn2 = "";
			var btn_comentario = "";
			//variables que contienen valor del correoE del cliente y si la orden esta firmada o no 
			var correo_cte="", trae_firma='';

			tabla_historico.fnClearTable();

			$("#loading_spin").hide();

			if(data.length == 0)
			{
				toastr.error("No se encontraron órdenes.");
				return;
			}

			$.each(data, function(index, val) 
			{
				val["ap_cliente"] = (val["ap_cliente"] == "null") ? "" : val["ap_cliente"];
				val["am_cliente"] = (val["am_cliente"] == "null") ? "" : val["am_cliente"];
				correo_cte=val['email_cliente'];
				trae_firma=val['contFirma']['contadorFirma'];

				nombre  = val["nombre_cliente"]+" "+val["ap_cliente"]+" "+val["am_cliente"];
				folio   = (val["movID"] == null || val["movID"]["MovID"] == null) ? "-" : val["movID"]["MovID"];
				//btn     =  "<button class='btn btn-sm profeco' style='background: #152f6d;' id='profeco-"+val["id"]+"'><i class='fa fa-file-download'></i>  &nbsp&nbsp Formato Profeco</button>";
				btn     =  "<button class='btn btn-sm profec' style='background: #152f6d;' id='profeco-"+val["id"]+"'><i class='fa fa-file-download'></i>  &nbsp&nbsp Formato Profeco</button>";
				// btn     +=  "<button class='btn btn-sm profecoTalisman' style='background: #152f6d;' id='profecoTalisman-"+val["id"]+"'><i class='fa fa-file-download'></i>  &nbsp&nbsp Formato Profeco Toyota</button>";
				btn     += "<button class='btn btn-sm multipuntos' style='background: #152f6d;' id='multi-"+val["id"]+"'><i class='fa fa-file-download'></i>  &nbsp&nbsp Hoja Multipuntos</button>";
				btn     += "<button class='btn btn-sm formatoInventario' style='background: #152f6d;' id='inv-"+val["id"]+"'><i class='fa fa-file-download'></i>  &nbsp&nbsp Formato de Inventario</button>";
				
				btn     += "<input type='hidden' id='btn_trae_firma' value='"+trae_firma+"'>";
				// se usara para ver a que cliente se envia en presupuesto
				btn     += "<input type='hidden' id='btn_email_cte' value='"+correo_cte+"'>";

				action  = "<button class='btn btn-sm whatsapp' style='background: #79c143;' id='whats-"+val["id"]+"'><i class='fab fa-whatsapp'></i>  &nbsp&nbsp Whatsapp</button>";
				action  +="<button class='btn btn-sm correohist' style='background:#2B95FF;' id='correo-"+val["id"]+"'><i class='fa fa-envelope'></i>&nbsp&nbsp Correo</button>";
				action  +="<button class='btn btn-sm anexofotos' style='background:#C70039;' id='anexofotos-"+val["id"]+"'><i class='fa fa-images'></i>&nbsp&nbsp Fotografías</button>";
				//console.log( val['contFirma']['contadorFirma']);
				//Se obtiene de buscador_model.php el valor de la consulta donde se evalua si existe firma o no del cliente en la orden de servico 
				if(val['contFirma']['contadorFirma'] == 0){
					action  +="<button class='btn btn-sm addFirma' style='background:#17A2B8;' id='addFirma-"+val["id"]+"'><i class='fa fa-file-signature'></i>&nbsp&nbsp Agregar Firma</button>";	
				}
				btn_presupuesto = "<button class='btn btn-sm new_budget' style='background: #607d8b;' id='"+val["id"]+"'><i class='fas fa-file-invoice-dollar'></i>  &nbsp&nbsp Generar Presupuesto</button>";
				btn_presupuesto += "<button class='btn btn-sm search_budgets' style='background: #607d8b;' id='"+val["id"]+"'><i class='fas fa-search'></i>  &nbsp&nbsp Ver Presupuestos</button>";
				btn_comentario = "<div style='display: none;' id='comentario-"+val["id"]+"'>"+val["comentario_tecnico_multip"]+"</div><button class='btn btn-sm btn-info comentario-tec' data-id='"+val["id"]+"'><i class='fa fa-edit'></i>&nbsp&nbsp Ver</button>";
				action2  ="<button class='btn btn-sm anexofotos' style='background:#C70039;' id='anexofotos-"+val["id"]+"'><i class='fa fa-images'></i>&nbsp&nbsp Fotografías</button>";
				if(id_perfil == 6)
				{
					tabla_historico.fnAddData([
						val["id"],
						folio,	
						val["asesor"],
						nombre,	
						val["tel_movil"],
						val["vin"],
						val["anio_modelo_v"],
						btn,
						action2,
						btn_presupuesto,
						btn_comentario
					]);
				}else 
				{
					tabla_historico.fnAddData([
						val["id"],
						folio,	
						nombre,	
						val["tel_movil"],
						val["vin"],
						val["anio_modelo_v"],
						btn,
						action,
						btn_presupuesto,
						btn_comentario
					]);
				}	
			});		
		})
		.fail(function() {
			alert("Hubo un error al mostrar los datos");
		});	
	});
	$("#table_invoice tbody").on("click", "tr td button.coment_presupuesto", function(e){
		e.preventDefault();
		var id = $(this).attr("id");
		id = id.split("_");
		var value = $("#coment_"+id[1]).val();
		toastr.info(value, "Comentario", {
            "timeOut": "0",
            "extendedTImeout": "0",
            "tapToDismiss": true,
    		"onclick": false,
    		"closeOnHover": false,
            "positionClass": "toast-top-right",
        });
	})
	$(document).on("click", "tr td button.coment_presupuestoe", function(e){
		e.preventDefault();
		var value = $(this).find(".fa-comment").attr("data-val");
		toastr.info(value, "Comentario", {
            "timeOut": "0",
            "extendedTImeout": "0",
            "tapToDismiss": true,
    		"onclick": false,
    		"closeOnHover": false,
            "positionClass": "toast-top-right",
        });
	})
	$(".tabla_hist tbody").on("click", "tr td button.comentario-tec", function(e){
		var id = $(this).attr("data-id");
		var texto = ($("#comentario-"+id).text() == "null") ? "No hay ningún comentario" : $("#comentario-"+id).text();

		toastr.info(texto, "Comentario Técnico", {
            "timeOut": "0",
            "extendedTImeout": "0",
            "tapToDismiss": true,
    		"onclick": false,
    		"closeOnHover": false,
            "positionClass": "toast-bottom-left",
        });
	});

	var b_profeco = false;
	$(".tabla_hist tbody").on("click", "tr td button.profeco", function(e){
		
		if(b_profeco == false)
		{
			b_profeco = true;
			localStorage.setItem("formato_base64", "");
			localStorage.setItem("formatoReverso_base64", "");

			var id_orden = $(this).prop("id");
			id_orden = id_orden.split("-");
			id_orden = id_orden[1];

			$("#loading_spin").show();
			
			generar_formato(id_orden);
			console.log("click")
		}else 
		{
			toastr.info("Por favor, espere un momento, mientras termina la generación del formato");
		}
	});

	$(".tabla_hist tbody").on("click", "tr td button.profec", function(e){
		var id_orden = $(this).prop("id");
		id_orden = id_orden.split("-");
		id_orden = id_orden[1];
		window.open(base_url+"index.php/servicio/profeco_print/"+ id_orden, "_blank");
	});

	$(".tabla_hist tbody").on("click", "tr td button.multipuntos", function(e){
		var id_orden = $(this).prop("id");
		id_orden = id_orden.split("-");
		id_orden = id_orden[1];
		localStorage.setItem("hist_id_orden", id_orden);

		window.open(base_url+"index.php/servicio/ver_hojaMultipuntos/"+ id_orden, "_blank");
	});

	//formato de Inventario
	$(".tabla_hist tbody").on("click", "tr td button.formatoInventario", function(e){
		var id_orden = $(this).prop("id");
		id_orden = id_orden.split("-");
		id_orden = id_orden[1];

		window.open(base_url+"index.php/servicio/generar_formatoInventario/0/"+ id_orden, "_blank");
	});

	//formato Profeco Talismán
	$(".tabla_hist tbody").on("click", "tr td button.profecoTalisman", function(e){
		var id_orden = $(this).prop("id");
		id_orden = id_orden.split("-");
		id_orden = id_orden[1];

		window.open(base_url+"index.php/servicio/generar_formatoProfecoTalisman/0/"+ id_orden, "_blank");
	});
	
	$(".tabla_hist tbody").on("click", "tr td button.whatsapp", function(e){
		var id_orden = $(this).prop("id");
		id_orden = id_orden.split("-");
		id_orden = id_orden[1];
		var $this = $(this);

		$("#oden_hide").val(id_orden);
		var parent = $this.parent().parent().find('td:eq(2)').text();
		var numerowhats = parent.substring(3);
		$("#numerowhats").val(numerowhats);
		$('#modal_whatsapp').modal('show');
	});
	//modal envio correo 
	$(".tabla_hist tbody").on("click", "tr td button.correohist", function(e){
		e.preventDefault();
		var id_orden = $(this).prop("id");
		id_orden = id_orden.split("-");
		id_orden = id_orden[1];
		//obetener el valor para saber si trae firma o no
		var $this = $(this);
		var parent_trae_firm = $this.parent().parent().find('#btn_trae_firma').val();
		localStorage.setItem("hist_trae_firma", parent_trae_firm);
		localStorage.setItem("hist_id_orden", id_orden);
		$('#modalsendmail').modal('show');
	});
	//para fotografias
	$(".tabla_hist tbody").on("click", "tr td button.anexofotos", function(e){
		e.preventDefault();
		var id_orden = $(this).prop("id");
		id_orden = id_orden.split("-");
		id_orden = id_orden[1];

		localStorage.setItem("hist_id_orden_f", id_orden);
		// alert('orden: ' + id_orden);
		$.ajax({
			url: base_url+ "index.php/Servicio/traer_fotos_inspeccion",
			type: "POST",
			dataType: 'json',
			data: {id:id_orden},
			beforeSend: function(){
				$("#loading_spin").show();
			},
			error: function(){
				console.log('error fotos');
			},
			success: function (data){
				if(data.success==1){
					var img = document.createElement("img");
					var random = 0;
					$("#links_light").empty();

					if(alias_exists != ''){
						//variable que contiene la ruta con el alias del virtual host donde se encuentra la unidad donde se alojaran las imagenes
						var vhost=window.location.origin+'/'+alias_exists+'/';
						//alert(vhost);
						for(i = 0; i<data.fotos.length; i++){
							random = Math.floor((Math.random() * 100) + 1);
							var str = data.fotos[i]['ruta_archivo'];
							var str_res = str.replace(dir_fotos, "");
							ruta = vhost + str_res;
							$("#links_light").append('<a href="'+ ruta +'" target="_blank"><img class="img_hist" src="'+ruta +"?id="+random+'" style="width:100%"></a>');
						}
					}
					else{
						//en caso de que no exista un alias configurado la ruta debe ser local	./assets/uploads/fotografias/
						for(i = 0; i<data.fotos.length; i++){
							random = Math.floor((Math.random() * 100) + 1);
							ruta = base_url + data.fotos[i]['ruta_archivo'];
							var str = data.fotos[i]['ruta_archivo'];
							$("#links_light").append('<a href="'+ ruta +'" target="_blank"><img class="img_hist" src="'+ruta +"?id="+random+'" style="width:100%"></a>');
						}
					}

					$("#links_light").tosrus();
					var j = 0;
					$('#links_light .tos-slider a').each(function() {
				        // alert($(this).attr('src'))
				        $(this).parent().append("<p class='comentario_fotos'>"+data.fotos[j]['comentario']+"</p>");
				        j++;
				    });
					$('#modalFotos').modal('show');
					$("#loading_spin").hide();
				}else{
					toastr.error(data.data);
					$("#loading_spin").hide();
				}
			
			}
		});
		
	});

	/* BEGIN ALGUNAS CONFIGURACIONES PARA AGREGAR LA FIRMA DESDE EL HISTORICO */


	//modal para agregar firmas en caso de que la orden no las tenga
	$(".tabla_hist tbody").on("click", "tr td button.addFirma", function(e){
		e.preventDefault();
		var id_orden = $(this).prop("id");
		id_orden = id_orden.split("-");
		id_orden = id_orden[1];
		localStorage.setItem('hist_id_orden_firm',id_orden);
		limpiar_firmas();
		$('#modalfirma').modal("show");
	});


	//agregar configuracion para los inputs valor_firma Y valor_firma2 que se encuentran EN firma_configuracion.php
	var firma=""; var firma2="";
	var config = {
        autoFit : true,       // Update any forms field with signature when loading the page
        // format : "image/png",  // Default signature image format
        background : "#EEE",   // Default signature background
        lineColor : "#000",          // Default signature pen color
        lineWidth : 1,          // Default signature pen width
        border : "#AAA",       // Default signature pen border color
        height : 200           // Default signature height in px
    };

    firmaH = $("#firma").jqSignature(config);
    firmaH2 = $("#firma2").jqSignature(config);


    function limpiar_firmas() {
    	 $("#firma").jqSignature('clearCanvas');
    	 $("#firma2").jqSignature('clearCanvas');
    }

    //botones de accion para el modal de forma en historico

    $(document).on("click", '#btn_borrarFirma', function (e){
	    e.preventDefault();
	    $("#firma").jqSignature('clearCanvas');
	    // $("#firma").jSignature("clear");
	    $("#valor_firma").val("");
	    $("#loading_spin").hide();
	});

	$(document).on("click", '#btn_borrarFirma2', function (e){
	    e.preventDefault();
	    $("#firma2").jqSignature('clearCanvas');
	    // $("#firma").jSignature("clear");
	    $("#valor_firma2").val("");
	    $("#loading_spin").hide();
	});


	$(document).on("click", '#btn_guardarFirma', function (e){
    e.preventDefault();

    $("#valor_firma").val(firmaH.jqSignature("getDataURL"));
    $("#valor_firma2").val(firmaH2.jqSignature("getDataURL"));

    var form = $("#formFirma").serialize();
    var id_orden_servicio = localStorage.getItem("hist_id_orden_firm");
    var firma_vacia = "data:image/png;base64,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";

   
    form += "&id_orden_servicio="+id_orden_servicio;

    console.log($("#valor_firma").val());

    if($("#valor_firma").val() == firma_vacia || $("#valor_firma2").val() == firma_vacia)
    {
        toastr.error("La firma está vacía, favor de proporcionarla.");
    }else 
    {
        $.ajax({
            cache: false,
            url: base_url+ "index.php/user/guardar_firma/",
            type: 'POST',
            dataType: 'json',
            data: form,
            beforeSend: function(){
                toastr.info("Guardando las firmas, por favor, espere un momento.");
                $("#loading_spin").show();
            }
        })
        .done(function(data) {
            if(data)
            {
                toastr.success("Se han guardado las firmas del Cliente.");

                $("#loading_spin").hide();

                $("#modalfirma").modal("hide");
            }else
            {
                toastr.error("Hubo un error al guardar las firmas del Cliente.");
            }
        })
        .fail(function() {
            alert("Hubo un error al guardar las firma");
        }); 
    }


	});

	/* END ALGUNAS CONFIGURACIONES PARA AGREGAR LA FIRMA DESDE EL HISTORICO */

	$(".tabla_hist tbody").on("click", "tr td button.new_budget", function(e){
		var idOrden =  $(this).attr('id');
		$("#id_orden_b").val(idOrden);
		$("#table_invoice tbody").empty();
		var table_body_default = "<td></td>";
		table_body_default += "<td></td>";
     	table_body_default +=		"<td></td>";
 		table_body_default +=	"<td></td>";
 		table_body_default +=	"<td><label for='totalFin'>Total Fin:</label></td>";
     	table_body_default +=		"<td class='price'><input class='cost md-textarea' ";
     	table_body_default +="id='precioTotal' name='";
		table_body_default +="precioTotal' readonly='true'></td>";
		$("#table_invoice tbody").append(table_body_default);
		$("#card_articulos").hide();
		numArt = 0;
		arrayArticulos = [];
		$("#titlePresupuesto").text("Generar Presupuesto");
		$("#bnActualizarPres").hide();
		$("#bnGuardarPres").show();
		$('#modalbusqarts').modal('show');
	});
	$(".tabla_hist tbody").on("click", "tr td button.search_budgets", function(e){
		var idOrden =  $(this).attr('id');
		search_budgets(idOrden);
		var $this = $(this);
		var parent = $this.parent().parent().find('td:eq(2)').text();
		var cte = $this.parent().parent().find('td:eq(1)').text();
		var numerowhats = parent.substring(3);
		$("#oden_hide").val(idOrden);
		var textoWhats = "Buen día estimado (a) "+ cte + " le envíamos la siguiente información acerca de los detalles que se encontraron en su vehículo. Saludos";
		$("#numerowhats").val(numerowhats);
		$("#TextWhats").val(textoWhats);
		$('#modalPresupuestos .modal-body').empty();
		//se envia al modal modalemailP el correoE del cliente que unicamente visualizara a donde se enviara su presupuesto  
		var $this = $(this);
		var parent_email_cte = $this.parent().parent().find('#btn_email_cte').val();
		$("#email_envio_p").val(parent_email_cte);
		//alert(parent_email_cte);
	});

	var presupuestos_array;

	function search_budgets(id_orden){
	    $.ajax({
			url: base_url+ "index.php/Buscador/search_budget",
			type: "POST",
			dataType: 'json',
			data: {id:id_orden},
			beforeSend: function(){
				$("#loading_spin").show();
			},
			error: function(){
				console.log('error al buscar');
			},
			success: function (data){
				$("#loading_spin").hide();
				if(data.estatus == true){
					presupuestos_array = data.pres;
					$.each(data.pres, function(index, value){
						
						var idpres = value.id_presupuesto;
						var row_title = $("<div class='row'><div class='col-md-4'><label>#Presupuesto: <b>"+idpres+"</b></label></div><div class='col-md-4'><button class='btn btn-sm btn-primary editarPres' data-id_presupuesto='"+index+"'><i class='fa fa-edit'></i> Editar</button></div></div>");
						/*if(value.autorizado == 1)
							var check = $("<label for='"+idpres+"' class='pres_autorizado'><input type='checkbox' class='checkA' id='"+idpres+"' name='check_aut' value='1' checked>Autorizado</label>");
						else
							var check = $("<label for='"+idpres+"' class='no_autorizado'><input type='checkbox' class='checkA' id='"+idpres+"' name='check_aut' value='1'>Autorizado</label>");

						row_title.append(check);*/

						var table = $("<table class='table table-bordered table-striped table-hover animated fadeIn no-footer tablepres' id='presupuesto"+(index+1)+"'><thead style='text-align:center;'><tr><th>Clave Articulo</th><th>Descripcion</th><th>Precio Unitario</th><th>Cantidad</th><th>Total</th><th>Comentario</th><th>Autorizado<br><input type='checkbox' class='check check_all' value='1' id='"+idpres+"'></th></tr></thead><tbody style='text-align:center;'></tbody></table>");
						$.each(value.detalle, function(index2, value2){
							if (value2.comentario != "" && value2.comentario != null){
								var disable = "<td><button class='btn btn-sm btn-info coment_presupuestoe' id='com_"+index2+"'> <i class='fa fa-comment' data-val='"+value2.comentario+"'></i></button></td>";
							}else{
								var disable = "<td><button class='btn btn-sm btn-info coment_presupuestoe' id='com_"+index2+"' disabled> <i class='fa fa-comment' data-val='"+value2.comentario+"'></i></button></td>";
							}
							if(value2.autorizado == 0){
								var row = $("<tr><td>"+value2.cve_articulo+"</td><td>"+value2.descripcion+"</td><td>"+value2.precio_unitario+"</td><td>"+value2.cantidad+"</td><td>"+value2.total_arts+"</td>"+disable+"<td><input type='checkbox' class='check chk_aut' id='"+idpres+"-"+value2.cve_articulo+"' name='check_aut' value='1'></td></tr>");
							}else{
								var row = $("<tr><td>"+value2.cve_articulo+"</td><td>"+value2.descripcion+"</td><td>"+value2.precio_unitario+"</td><td>"+value2.cantidad+"</td><td>"+value2.total_arts+"</td>"+disable+"<td><input type='checkbox' class='check chk_aut' id='"+idpres+"-"+value2.cve_articulo+"' name='check_aut' value='1' checked></td></tr>");
							}
							table.append(row);
						});
						var row_importe = $("<tr><td><button class='btn btn-sm btn-info btn-mailP' id='"+index+"'><i class='fas fa-envelope'></i> Email</button><button class='btn btn-sm btn-primary btnPdf' data-index='"+index+"'><i class='fas fa-file-download'></i> PDF</button><button class='btn btn-sm whatsapp_pres' data-index='"+index+"'><i class='fab fa-whatsapp'></i></button></td><td></td><td></td><td><b>Importe</b></td><td><b>"+value.total_presupuesto+"</b><td></td></td>");
						table.append(row_importe);
						$('#modalPresupuestos .modal-body').append(row_title);
						$('#modalPresupuestos .modal-body').append(table);
					});
					$('#modalPresupuestos').modal('show');
				}else{
					toastr.error(data.mensaje);
				}
			}
		});
	}
	$(document).on("click", "input.check_all", function(){
		$(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
		var id_presupuesto = $(this).attr("id");
		var estatus = this.checked;
		$.ajax({
			url: base_url+ "index.php/Servicio/Autorizar_todo",
			type: "POST",
			dataType: 'json',
			data: {id_presupuesto:id_presupuesto, autorizado:estatus},
			beforeSend: function(){
				$("#loading_spin").show();
			},
			error: function(){
				toastr.error("error al autorizar");
			},
			success: function (data){
				toastr.success(data.mensaje);
				$("#loading_spin").hide();
			}
		});
	});
	$(document).on("click", "input.chk_aut", function(){
		var id_aut = $(this).attr("id");
		id_aut = id_aut.split("-");
		
		var clave = id_aut[1];
		var presupuesto = id_aut[0];
		var arts = [];
		var valueTopush ={};
		if($(this).is(':checked'))
			var aut = 1;
		else
			var aut = 0;
		valueTopush["clave_art"] = clave;
		valueTopush["id_presupuesto"] = presupuesto;
		valueTopush["autorizado"] = aut;
		arts.push(valueTopush)
		autorizar_articulo(arts);
	});
	function autorizar_articulo(cve_arts){
		$.ajax({
			url: base_url+ "index.php/Servicio/Autorizar_articulo",
			type: "POST",
			dataType: 'json',
			data: {articulo:cve_arts},
			beforeSend: function(){
				$("#loading_spin").show();
			},
			error: function(){
				toastr.error("error al autorizar");
			},
			success: function (data){
				toastr.success(data.mensaje);
				$("#loading_spin").hide();
			}
		});
	}
	$(document).on("click", "button.editarPres", function(){
		var idIndex =  $(this).attr('data-id_presupuesto');
		var datos = presupuestos_array[idIndex];
		var id_presupuesto = datos["id_presupuesto"];
		$("#id_presupuesto").val(id_presupuesto);
		$("#table_invoice tbody").empty();
		var table_body_default = "<td></td>";
		table_body_default += "<td></td>";
     	table_body_default +=		"<td></td>";
 		table_body_default +=	"<td></td>";
 		table_body_default +=	"<td><label for='totalFin'>Total Fin:</label></td>";
     	table_body_default +=		"<td class='price'><input class='cost md-textarea' ";
     	table_body_default +="id='precioTotal' name='";
		table_body_default +="precioTotal' readonly='true'></td>";
		$("#table_invoice tbody").append(table_body_default);
		$("#card_articulos").hide();
		numArt = 0;
		arrayArticulos = [];
		$.each(datos["detalle"], function(index, value){
			var valueTopush ={};
			var table = "<tr class='item-row arst_add' style='text-align:center;'>";
				    table += "<td class='item-name'><div class='delete-wpr'><a class='delete' id='"+numArt+"'>X</a> </div></td>";
		    table += "<td class='artmoo'>"+value.cve_articulo+"<input type='hidden' name='cve_"+numArt+"' id='cve_"+numArt+"' value='"+value.cve_articulo+"'/> </td>";
		    table += "<td>"+value.descripcion+"<input type='hidden' name='descrip_"+numArt+"' id='descrip_"+numArt+"' value='"+value.descripcion+"'/> </td>";
		    table += "<td><input class='qty md-textarea' name='art_qty_"+numArt+"' id='art_qty_"+numArt+"' value='"+value.cantidad+"'/></td>";
		    table += "<td><input class='cost md-textarea' name='art_cost_"+numArt+"' id='art_cost_"+numArt+"' value='"+value.precio_unitario+"'/></td>";
		    table +="<td><button class='btn btn-sm btn-info coment_presupuesto' id='com_"+numArt+"'> <i class='fa fa-comment' ></i></button><input type='hidden' name='coment_"+numArt+"' id='coment_"+numArt+"' value='"+value.comentario+"'/></td>";
		    table += "<td><label class='price'>"+value.total_arts+"</label><input type='hidden' class='atotal' name='atotal_"+numArt+"' id='atotal_"+numArt+"' value='"+value.total_arts+"'/></td>";
		    table +="<td style='display:none;' name='articulosad_"+numArt+"' id='articulosad_"+numArt+"'>single</td>";
		    table += "<td style='display:none;' name='idpq_"+numArt+"' id='idpq_"+numArt+"'>" + 'NA' + "</td>";
		    table += "</tr>";
		    valueTopush["cve_articulo"] = value.cve_articulo;
		    valueTopush["descripcion"] = value.descripcion;
		    valueTopush["cantidad"] = value.cantidad;
		    valueTopush["precio_unitario"] = value.precio_unitario;
		    valueTopush["total_arts"] = value.total_arts;
		    update_total();
		    $("#table_invoice tbody").prepend(table);
		    bind();
		    numArt++;
		    arrayArticulos.push(valueTopush);
		    update_total();
		});
		$("#card_articulos").show();
		$("#titlePresupuesto").text("Editar presupuesto");
		$("#bnGuardarPres").hide();
		$("#bnActualizarPres").show();
		$("#modalbusqarts").modal("show");
		$("#modalPresupuestos").modal("hide");
	});
	$("#bnActualizarPres").on("click", function(){
		countArticulos();
		if(arrayArticulos.length > 0){
			var presupuestoDato = arrayArticulos;
			$.ajax({
				url: base_url+ "index.php/Servicio/EditarPresupuesto",
				type: "POST",
				dataType: 'json',
				data: {articulos:presupuestoDato, detalles:$("#formPresupuesto").serialize()},
				beforeSend: function(){
					$("#loading_spin").show();
				},
				error: function(){
					toastr.error("error");
				},
				success: function (data){
					toastr.success(data.mensaje);
					$("#loading_spin").hide();
					$("#table_invoice tbody").empty();
					var table_body_default = "<td></td>";
					table_body_default += "<td></td>";
	             	table_body_default +=		"<td></td>";
	         		table_body_default +=	"<td></td>";
	         		table_body_default +=	"<td><label for='totalFin'>Total Fin:</label></td>";
	             	table_body_default +=		"<td class='price'><input class='cost md-textarea' ";
	             	table_body_default +="id='precioTotal' name='";
					table_body_default +="precioTotal' readonly='true'></td>";
					$("#table_invoice tbody").append(table_body_default);
					$("#card_articulos").hide();
					numArt = 0;
					arrayArticulos = [];
					$('#modalbusqarts').modal('hide');
				}
			});
		}else{
			toastr.error('Debe agregar articulos al presupuesto');
		}
	});
	$(document).on("change", "input.checkA", function(e){
		var id = $(this).attr('id');
		if($(this).is(':checked'))
			var aut = 1;
		else
			var aut = 0;
		$.ajax({
            cache: false,
            type: 'get',
            url: base_url+ "index.php/Servicio/autorizar_presupuesto/"+aut+"/"+id,
            dataType: "json",
            beforeSend: function(){
				$("#loading_spin").show();
			},
            success: function(data)
            {
            	toastr.success(data.mensaje);
            	if(aut == 1){
            		$("#"+data.id).labels().removeClass('no_autorizado');
            		$("#"+data.id).labels().addClass('pres_autorizado');
            	}else{
            		$("#"+data.id).labels().removeClass('pres_autorizado');
            		$("#"+data.id).labels().addClass('no_autorizado');
            	}
            	$("#loading_spin").hide();
            },
            error: function( jqXHR, textStatus, errorThrown )
            {
                toastr.error("Error al actualizar");
                $("#loading_spin").hide();
            } 
        });
	});
	$(document).on("click", "button.btn-mailP", function(e){
		var idIndex =  $(this).attr('id');
		var datos = presupuestos_array[idIndex];
		$("#id").val(datos.id_presupuesto);
		// $("#modalemailP").modal('show');
		$("#enviar_presupuesto").click();
	});
	$(document).on("click", "button.btnPdf", function(e){
		var idIndex =  $(this).attr('data-index');
		var datos = presupuestos_array[idIndex];
		var id_press = datos.id_presupuesto;
		window.open(base_url+"index.php/Servicio/ver_presupuestoPdF/"+ id_press, "_blank");
	});
	$("#enviar_presupuesto").click(function(){
        $.ajax({
            cache: false,
            type: 'post',
            url: base_url+ "index.php/Servicio/enviar_presupuesto_mail",
            dataType: "json",
            data: $("#mandar_pres_mail").serialize(),
            beforeSend: function(){
				$("#loading_spin").show();
			},
            success: function(data)
            {
            	$("#loading_spin").hide();
            	if(data)
            	{
            		toastr.success("Se ha enviado el correo");
            	}else 
            	{
            		toastr.error("Error al enviar Email");
            	}
            },
            error: function( jqXHR, textStatus, errorThrown )
            {
                toastr.error("Error al enviar Email");
                $("#loading_spin").hide();
            } 
        });
    });
	// busqueda articulo 
    $("#ajax_arts").autocomplete({
            source: function(request, response) {
                filtro = "";
                $.ajax({
                    cache: false,
                    url: base_url+"index.php/buscador/buscar_art",
                    data:  {term : request.term , li: filtro },
                    dataType: "json",
                beforeSend: function(){
                    $('#spinner').show();
                },
                complete: function(){
                    $('#spinner').hide();                       
                },
                success: function(data) {
                	console.log("datos")
                    if(data.length == 0){
                            swal({
                                title: 'No se encontraron coincidencias',
                                    icon: "error"
                                });
                    }

                    response( $.map( data, function( item ) {
                        // console.log(item);
                        return {
                        label: item.art+' -- '+ item.clave_art,
                        value: item.art,
                        precio: item.descrip,
                        clave_art: item.clave_art,
                        stock:item.stock
                        }
                    }));
                },
                error : function(xhr, status) {
                    alert('Disculpe, existió un problema');
                }
            });
        },
        minLength: 3,
        select: function( event, ui ) {
        	$("#input_precio").val((ui["item"]["precio"] == null) ? 0 : ui["item"]["precio"]);
        	$("#input_stock").val(ui["item"]["stock"]);
        }
    });
    
    $("#ajax_arts").on("autocompleteselect", function(event, ui){
        $("#input_precio").val(ui.item.precio);
        $("#input_claveArt").val(ui.item.clave_art);
        $("#input_stock").val(ui.item.stock);
    });
    var numArt = 0;
     arrayArticulos = [];
    $(document).on("click", '#boton_agregarArt', function (e){
    	// numArt+=1;
    	var valueTopush ={};
	    e.preventDefault();
	    var art = $("#ajax_arts").val();
	    var precio = $("#input_precio").val();
	    var cantidad = $("#input_cantidad").val();
	    var clave_art = $("#input_claveArt").val();
	    var total = precio * cantidad;
	    var table = "<tr class='item-row arst_add' style='text-align:center;'>";
	    var comentarios  = $("#comentario_art").val();
	    if(comentarios == null || comentarios == ""){
	    	var coment = "<td><button class='btn btn-sm btn-info coment_presupuesto' id='com_"+numArt+"' disabled> <i class='fa fa-comment' ></i></button><input type='hidden' name='coment_"+numArt+"' id='coment_"+numArt+"' value='"+comentarios+"'/></td>";
	    }else{
	    	var coment = "<td><button class='btn btn-sm btn-info coment_presupuesto' id='com_"+numArt+"'> <i class='fa fa-comment' ></i></button><input type='hidden' name='coment_"+numArt+"' id='coment_"+numArt+"' value='"+comentarios+"'/></td>";
	    }
	    if(art == "" || precio == "")
	    {
	        toastr.error("No se ha especificado ningún artículo");
	        return false;
	    }
	    valueTopush["cve_articulo"] = clave_art;
	    valueTopush["descripcion"] = art;
	    valueTopush["cantidad"] = cantidad;
	    precio = roundNumber(precio,2);
	    valueTopush["precio_unitario"] = precio;
	    precio = formatear_numero(precio);
	    
	    total1 = total;
	    valueTopush["total_arts"] = total1;
	    valueTopush["comentario"] = comentarios;
	    total = formatear_numero(total);

	    table += "<td class='item-name'><div class='delete-wpr'><a class='delete' id='"+numArt+"'>X</a> </div></td>";
	    table += "<td class='artmoo'>"+clave_art+"<input type='hidden' name='cve_"+numArt+"' id='cve_"+numArt+"' value='"+clave_art+"'/> </td>";
	    table += "<td>"+art+"<input type='hidden' name='descrip_"+numArt+"' id='descrip_"+numArt+"' value='"+art+"'/> </td>";
	    table += "<td><input class='qty md-textarea' name='art_qty_"+numArt+"' id='art_qty_"+numArt+"' value='"+cantidad+"'/></td>";
	    table += "<td><input class='cost md-textarea' name='art_cost_"+numArt+"' id='art_cost_"+numArt+"' value='"+precio+"'/></td>";
	    table += coment;
	    table += "<td><label class='price'>"+total+"</label><input type='hidden' class='atotal' name='atotal_"+numArt+"' id='atotal_"+numArt+"' value='"+total1+"'/></td>";
	    table +="<td style='display:none;' name='articulosad_"+numArt+"' id='articulosad_"+numArt+"'>single</td>";
	    table += "<td style='display:none;' name='idpq_"+numArt+"' id='idpq_"+numArt+"'>" + 'NA' + "</td>";
	    table += "</tr>";

	    $("#table_invoice tbody").prepend(table);
	    bind();
	    $("#modalbusqpaq").modal("hide");
	    update_total();
	    $("#ajax_arts, #input_precio, #input_claveArt, #comentario_art").val("");
	    $("#input_cantidad").val(1);
	    $("#card_articulos").show();
	    numArt++;
	    arrayArticulos.push(valueTopush);
	    
	});
	// $(document).on("click", '#boton_agregarArt', function (e){
 //    	numArt+=1;
	//     e.preventDefault();
	//     var art = $("#ajax_arts").val();
	//     var precio = $("#input_precio").val();
	//     var cantidad = $("#input_cantidad").val();
	//     var clave_art = $("#input_claveArt").val();
	//     var total = precio * cantidad;
	//     var table = "<tr class='item-row arst_add' style='text-align:center;'>";

	//     if(art == "" || precio == "")
	//     {
	//         toastr.error("No se ha especificado ningún artículo");
	//         return false;
	//     }

	//     precio = roundNumber(precio,2);
	//     precio = formatear_numero(precio);
	//     total1 = total;
	//     total = formatear_numero(total);

	//     table += "<td class='item-name'><div class='delete-wpr'><a class='delete'>X</a> </div></td>";
	//     table += "<td class='artmoo'>"+clave_art+"<input type='hidden' name='cve_"+numArt+"' id='cve_"+numArt+"' value='"+clave_art+"'/> </td>";
	//     table += "<td>"+art+"<input type='hidden' name='descrip_"+numArt+"' id='descrip_"+numArt+"' value='"+art+"'/> </td>";
	//     table += "<td><input class='qty md-textarea' name='art_qty_"+numArt+"' id='art_qty_"+numArt+"' value='"+cantidad+"'/></td>";
	//     table += "<td><input class='cost md-textarea' name='art_cost_"+numArt+"' id='art_cost_"+numArt+"' value='"+precio+"'/></td>";
	//     table += "<td><label class='price'>"+total+"</label><input type='hidden' class='atotal' name='atotal_"+numArt+"' id='atotal_"+numArt+"' value='"+total1+"'/></td>";
	//     table +="<td style='display:none;' name='articulosad_"+numArt+"' id='articulosad_"+numArt+"'>single</td>";
	//     table += "<td style='display:none;' name='idpq_"+numArt+"' id='idpq_"+numArt+"'>" + 'NA' + "</td>";
	//     table += "</tr>";

	//     $("#table_invoice tbody").prepend(table);
	//     bind();
	//     $("#modalbusqpaq").modal("hide");
	//     update_total();
	//     $("#ajax_arts, #input_precio, #input_claveArt").val("");
	//     $("#input_cantidad").val(1);
	//     $("#card_articulos").show()
	// });
	function update_total() {
	  var total = 0;
	  var iva = 0;
	  var price = 0;
	  $('.price').each(function(i){
	    price = $(this).html().replace("$","");
	    price = parseFloat(price.replace(/,/g, ''));
	    if (!isNaN(price)) total += Number(price);
	  });


	  total = roundNumber(total,2);
	  iva = roundNumber((total * .16),2)

	  price = formatear_numero(price);
	  // total = formatear_numero(total);
	  iva = formatear_numero(iva);
	  $("#precioTotal").val(total);
	  $('#subtotal').val(total);
	  $('#ivatotal').val(iva); 
	  
	  // update_balance();
	}
	function bind() {
	  $(".cost").blur(update_price);
	  $(".qty").blur(update_price);
	}
	function update_balance() {
	    var due = parseFloat($("#subtotal").val().replace(/,/g, ''));
	    var iva = parseFloat($("#ivatotal").val().replace(/,/g, ''));

	    due = roundNumber((due+iva),2);
	    due = formatear_numero(due);

	    $('.due').val(due);
	}
	function update_price() {
	    $(this).closest('tr').find('.qty').each(
	    function (i) {
	      cuantos = $(this).val();
	      $(this).val(cuantos);
	    });
	    $(this).closest('tr').find('.cost').each(
		    function (i) {
		      cuanto = $(this).val();
		      cuanto1 = parseFloat(cuanto.replace(/,/g, ''));
		      $(this).val(cuanto);
		});
	 
	  price = cuanto1 * cuantos;

	  price = roundNumber(price,2);
	  
	  $(this).closest('tr').find('.atotal').each(
	    function(i){
	        $(this).val(price);

	    })
	  price = formatear_numero(price);

	  $(this).closest('tr').find('.price').each(
	    function(i){
	        $(this).html(price);

	    })
	  
	  update_total();
	}
	$("#bnGuardarPres").on("click", function(){
		if(arrayArticulos.length > 0){
			var presupuestoDato = arrayArticulos;
			$.ajax({
				url: base_url+ "index.php/Servicio/GuardarPresupuesto",
				type: "POST",
				dataType: 'json',
				data: {articulos:presupuestoDato, detalles:$("#formPresupuesto").serialize()},
				beforeSend: function(){
					$("#loading_spin").show();
				},
				error: function(){
					console.log('error');
				},
				success: function (data){
					console.log(data);
					if(data.estatus == true){
						toastr.success('Presupuesto Guardado');
						if(data.email == true)
						toastr.success('Se ha notificado al asesor');
					}
					else
						toastr.success('Error al guardar');
					$("#loading_spin").hide();
					$("#table_invoice tbody").empty();
					var table_body_default = "<td></td>";
					table_body_default += "<td></td>";
	             	table_body_default +=		"<td></td>";
	         		table_body_default +=	"<td></td>";
	         		table_body_default +=	"<td><label for='totalFin'>Total Fin:</label></td>";
	             	table_body_default +=		"<td class='price'><input class='cost md-textarea' ";
	             	table_body_default +="id='precioTotal' name='";
					table_body_default +="precioTotal' readonly='true'></td>";
					$("#table_invoice tbody").append(table_body_default);
					$("#card_articulos").hide();
					numArt = 0;
					arrayArticulos = [];
					$('#modalbusqarts').modal('hide');
				}
			});
		}else{
			toastr.error('Debe agregar articulos al presupuesto');
		}
	});
	// $("#bnGuardarPres").on("click", function(){
	// 	var presupuestoDato = $("#formPresupuesto").serialize();
	// 	$.ajax({
	// 		url: base_url+ "Servicio/GuardarPresupuesto",
	// 		type: "POST",
	// 		dataType: 'json',
	// 		data: presupuestoDato,
	// 		beforeSend: function(){
	// 			$("#loading_spin").show();
	// 		},
	// 		error: function(){
	// 			console.log('error');
	// 		},
	// 		success: function (data){
	// 			toastr.success('Presupuesto Guardado');
	// 			$("#loading_spin").hide();
	// 			$("#table_invoice tbody").empty();
	// 			var table_body_default = "<td></td>";
	// 			table_body_default += "<td></td>";
 //             	table_body_default +=		"<td></td>";
 //         		table_body_default +=	"<td></td>";
 //         		table_body_default +=	"<td><label for='totalFin'>Total Fin:</label></td>";
 //             	table_body_default +=		"<td class='price'><input class='cost md-textarea' ";
 //             	table_body_default +="id='precioTotal' name='";
	// 			table_body_default +="precioTotal' readonly='true'></td>";
	// 			$("#table_invoice tbody").append(table_body_default);
	// 			$("#card_articulos").hide();
	// 			numArt = 0;
	// 			$('#modalbusqarts').modal('hide');
	// 		}
	// 	});
	// });

	$(document).on('click','.item-name .delete-wpr .delete' ,function(){
	    $(this).parents('.item-row').remove();
	    var index = $(this).attr('id');
	    update_total();
		arrayArticulos.splice(index, 1); 
		     numArt-=1;
		console.log(arrayArticulos);
	    // if ($(".delete").length < 2) $(".delete").hide();                             //para que haya minimo un elemento
	});
	$(document).on("click", '#env_whats', function (e){
		e.preventDefault();
		var codigo_area = "521";  // equivale al +52 1 xxxxxxxxxx
		var numero = $("#numerowhats").val();
		var texto  = encodeURI($("#TextWhats").val());
		// console.log(texto);
		// whatsapp_url = 'https://wa.me/'+codigo_area+numero+'?text='+texto;
		var whatsapp_url = 'https://api.whatsapp.com/send?phone='+codigo_area+numero+'&text='+texto;
		// window.open(whatsapp_url, "_blank");
		var form = $("#form_send_whatsapp").serializeArray();
		$.ajax({
			url: base_url+ "index.php/Servicio/guardar_en_bitacora",
			type: "POST",
			dataType: 'json',
			data: form,
			beforeSend: function(){
				$("#loading_spin").show();
			},
			error: function(){
				console.log('error');
			},
			success: function (data){

				toastr.success('Mensaje enviado');
				window.open(whatsapp_url, "_blank");
				$("#loading_spin").hide();
				$('#modal_whatsapp').modal('hide');
			}
		});
        
	});
	$(document).on("click", "button.whatsapp_pres", function(e){
		$('#modalPresupuestos').modal('toggle');
		$('#modal_whatsapp').modal('show');
	})
	/*Pdf formato orden servicio*/
	function generar_pdf( img_formato, img_reverso, id_orden)
	{
	    var fecha_actual = new Date();
	    var doc = new jsPDF("p", "mm", "letter", true);
	    var width = 0;
	    var height = 0;

	    width = doc.internal.pageSize.width;    
	    height = doc.internal.pageSize.height;

	    doc.addImage(img_formato, 'PNG', 0, 0, width, height, undefined, 'FAST');
	    doc.addPage();
	    doc.addImage(img_reverso, 'PNG', 0, 0, width, height, undefined, 'FAST');
	    doc.save('OrdenServicio'+id_orden+'.pdf', { returnPromise: true });

	    $("#loading_spin").hide();
	    b_profeco = false;
	}

	/*Formato orden servicio*/
	function generar_formato(id_orden)
	{
        var url_formato = $("#url_formato").val();
        url_formato += "/"+id_orden;
        var url_reverso = $("#url_reversoformato").val();
        url_reverso += "/"+id_orden;
        var img = "";
        var img_reverso = "";
        var bandera = true;
									
        $("#iframe_formato").prop("src", url_formato);													//1ero se ejecuta esto
        $("#iframe_reversoformato").prop("src", url_reverso);
        console.log(url_formato)
        $("#iframe_formato, #iframe_reversoformato").off("load").on("load", function (){				//luego se ejecuta esto
        
            setTimeout(function(){               
                if(bandera)															//para que se ejecute solo 1 vez, no por cada iframe
                {               	
                	revisar_creacionImg(id_orden);
                }

                bandera = false;
            }, 800);        
        });         
	}

	function revisar_creacionImg(id_orden)
	{
		if(localStorage.getItem("formato_base64") != "" && localStorage.getItem("formatoReverso_base64") != "")
		{
			img = localStorage.getItem("formato_base64");
            img_reverso = localStorage.getItem("formatoReverso_base64");

            generar_pdf(img, img_reverso, id_orden);
		}else 
		{
			setTimeout(function(){
				revisar_creacionImg(id_orden);
			}, 1000);
		}
	}
});

function reset_formatos()
{
	localStorage.setItem("formato_base64", "");				//profeco
	sessionStorage.setItem("formato_inventario", "");		//inventario
	localStorage.setItem("correo_base64", "");				//img correo
	localStorage.setItem("formatoReverso_base64", "");		//reverso profeco
}

function revisar_creacionFormatosCorreo()
{
	if(localStorage.getItem("formato_base64") != "" && localStorage.getItem("formatoReverso_base64") != "" && 
		sessionStorage.getItem("formato_inventario") != "" && localStorage.getItem("correo_base64") != "")
	{
		var img = localStorage.getItem("formato_base64");
        var img2 = localStorage.getItem("hoja_multipuntos");
        var img3 = sessionStorage.getItem("formato_inventario");
        var img_correo = localStorage.getItem("correo_base64");
        var img_reverso = localStorage.getItem("formatoReverso_base64");

		enviar_correo(img,img2, img_correo, img_reverso, img3);
	}else 
	{
		setTimeout(function(){
			revisar_creacionFormatosCorreo();
		}, 1000);
	}
}

/*Email*/
$(document).off("click", "#send_mail").on("click", '#send_mail', function (e)
{
    e.preventDefault();
    
    reset_formatos();

    toastr.info("Enviando la orden por correo, esto podría tardar un momento, por favor, espere la notificación de envío", {timeOut: 120000});

    //Formato orden servicio
    var url_formato = $("#url_formato").val();
    url_formato += "/"+localStorage.getItem("hist_id_orden");
    var url_correo = $("#url_correo").val();
    url_correo += "/"+localStorage.getItem("hist_id_orden");
    var url_reverso = $("#url_reversoformato").val();
    url_reverso += "/"+localStorage.getItem("hist_id_orden");
    var url_formato_multipunto = $("#url_formato_multipunto").val();
    url_formato_multipunto += "/"+localStorage.getItem("hist_id_orden");
    var url_inventario = $("#url_inventario").val();
    url_inventario += "/"+localStorage.getItem("hist_id_orden");

    var bandera = true;

    $("#iframe_formato, #iframe_correo, #iframe_reversoformato, #iframe_formato_multipunto, #iframe_inventario").off("load").on("load", function (){
        setTimeout(function(){
            
            if(bandera)
            {
                revisar_creacionFormatosCorreo();
            }
            bandera = false;
        }, 800);
    });

    var firma_vacia = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAyAAAADICAYAAAAQj4UaAAANEklEQVR4Xu3ZwVEkUQwFwcYo1p2xbdwBp9YEbhWCl5wnQr9TulTw8fgjQIAAAQIECBAgQIBAJPARzTGGAAECBAgQIECAAAECjwBxBAQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApnAVIC8Xq+v53k+M12DCBAgQIAAAQIECPws8P1+v//9/LO/8QsB8jf26CsIECBAgAABAgR+r4AA+b2783ICBAgQIECAAAECBC4LTP0H5PIivI0AAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARAQFyZBGeQYAAAQIECBAgQGBBQIAsbNk3EiBAgAABAgQIEDgiIECOLMIzCBAgQIAAAQIECCwICJCFLftGAgQIECBAgAABAkcEBMiRRXgGAQIECBAgQIAAgQUBAbKwZd9IgAABAgQIECBA4IiAADmyCM8gQIAAAQIECBAgsCAgQBa27BsJECBAgAABAgQIHBEQIEcW4RkECBAgQIAAAQIEFgQEyMKWfSMBAgQIECBAgACBIwIC5MgiPIMAAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARAQFyZBGeQYAAAQIECBAgQGBBQIAsbNk3EiBAgAABAgQIEDgiIECOLMIzCBAgQIAAAQIECCwICJCFLftGAgQIECBAgAABAkcEBMiRRXgGAQIECBAgQIAAgQUBAbKwZd9IgAABAgQIECBA4IiAADmyCM8gQIAAAQIECBAgsCAgQBa27BsJECBAgAABAgQIHBEQIEcW4RkECBAgQIAAAQIEFgQEyMKWfSMBAgQIECBAgACBIwIC5MgiPIMAAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARgf8OegrJcwoE6QAAAABJRU5ErkJggg==";

    setTimeout(function(){
		if(localStorage.getItem("hist_trae_firma") == 0)
        //if($("#valor_firma").val() == firma_vacia || $("#valor_firma").val() == "")
        {
            toastr.error("Es necesario tener la firma del Cliente para enviar el correo.");
        }else 
        {
            $("#iframe_correo").prop("src", url_correo);
            $("#iframe_formato").prop("src", url_formato);
            $("#iframe_reversoformato").prop("src", url_reverso);
            $("#iframe_inventario").prop("src", url_inventario);
            $("#iframe_formato_multipunto").prop("src", url_formato_multipunto);
        } 
    }, 1000);
});

function enviar_correo( img, img2, img_correo, img_reverso, img3)
{
    var email = $("#email_envio").val();
    var cliente = $("#nombre_cliente").val();
    // var id_orden = localStorage.getItem("id_orden_servicio");
    var id_orden = localStorage.getItem("hist_id_orden");

    $.ajax({
        cache: false,
        url: base_url+"index.php/servicio/enviar_orden_mail/",
        type: 'POST',
        dataType: "json",
        data:  {email_envio: email, cliente_envio: cliente, id_orden: id_orden, base64: img, correo_base64: img_correo, img_reverso: img_reverso, multi: img2, inv: img3},
        beforeSend: function(){
            $('#loading_spin').show();
        },
        success: function(data) {
            if(data)
            {
                $('#loading_spin').hide();
                $("#modalsendmail").modal("hide");
                $("#enviar_whatsapp").show();
                toastr.success('El correo electrónico ha sido enviado.', {timeOut: 5000});
            }else 
            {
                toastr.error('Hubo un error al enviar el correo electrónico.', {timeOut: 5000});
            }               
        },
        error : function(xhr, status) {
            alert("Hubo un error al enviar el correo");
        }
    });
}
function roundNumber(number,decimals) {
  var newString;// The new rounded number
  decimals = Number(decimals);
  if (decimals < 1) {
    newString = (Math.round(number)).toString();
  } else {
    var numString = number.toString();
    if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
      numString += ".";// give it one at the end
    }
    var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
    var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
    var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
    if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
      if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
        while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
          if (d1 != ".") {
            cutoff -= 1;
            d1 = Number(numString.substring(cutoff,cutoff+1));
          } else {
            cutoff -= 1;
          }
        }
      }
      d1 += 1;
    } 
    if (d1 == 10) {
      numString = numString.substring(0, numString.lastIndexOf("."));
      var roundedNum = Number(numString) + 1;
      newString = roundedNum.toString() + '.';
    } else {
      newString = numString.substring(0,cutoff) + d1.toString();
    }
  }
  if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
    newString += ".";
  }
  var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
  for(var i=0;i<decimals-decs;i++) newString += "0";
  //var newNumber = Number(newString);// make it a number if you like
  return newString; // Output the result to the form field (change for your purposes)
}
function formatear_numero(numero)
{
    var num = numero.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    return num;
}
function countArticulos(){
	arrayArticulos = [];
	$.each($("tr.arst_add"),function(index, val){
		var valueTopush ={};
		var clave = $(this).find("td").eq(1).text();  
		var descripcion = $(this).find("td").eq(2).text();  
		var cantidad = $(this).find("td").eq(3).find("input").val();  
		var precio_unitario = stringToFloat($(this).find("td").eq(4).find("input").val()); 
		var comentarios = $(this).find("td").eq(5).find("input").val();
		var total = $(this).find("td").eq(6).find("input").val();
		
		valueTopush["cve_articulo"] = clave;
	    valueTopush["descripcion"] = descripcion;
	    valueTopush["cantidad"] = cantidad;
	    valueTopush["precio_unitario"] = precio_unitario;
	    valueTopush["comentario"] = comentarios;
	    valueTopush["total_arts"] = total;
	    arrayArticulos.push(valueTopush);
	    console.log(valueTopush);
	})
}
function stringToFloat(num){
	var val = parseFloat(num.replace(/,/g, ''));
	return val;
}