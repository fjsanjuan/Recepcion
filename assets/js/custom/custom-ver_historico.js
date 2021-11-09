$(document).ready(function() {

	//variable que controlan la ruta donde se guardan las fotos de la inspeccion 
	//en este caso para poder vizualizarlas desde el historico
	var alias_exists = '';
	// ./assets/uploads/fotografias/   o  F:/recepcion_activa/fotografias/
	var dir_fotos= './assets/uploads/fotografias/'; 
	//variable que controlan el tipo de formato de orden de servicio(profeco) que se genera en pdf 
	var formt_serv_pdf = "ford";
	// true solo si aplicar para ford en los distribuidores que necesiten la carta de rechazo a extensión de garantía
	bnt_renunciaGrtia =true;

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
	$('[data-toggle="tooltip"]').tooltip();

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
			
			console.log('Datos tabla historico');
			console.log(data);

			var tabla = "", nombre = "", folio = "";
			var btn1 = "", btn2 = "";
			var btn_comentario = "";
			//variables que contienen valor del correoE del cliente, si la orden esta firmada o no
			// trae_signGrtia valor de la firma para el formato de rechazo extension de garantia 
			var correo_cte="", trae_firma='', trae_signGrtia=null;
			//
			const firma_vacia = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAakAAADSCAYAAADwvj/tAAAAAXNSR0IArs4c6QAAB/JJREFUeF7t1UENAAAMArHh3/Rs3KNTQMoSdo4AAQIECEQFFs0lFgECBAgQOCPlCQgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAgQee7QDT4w9urAAAAABJRU5ErkJggg==";


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
				if(trae_firma ==1){
				trae_signGrtia = val['signGrtia']['firma_renunciaGarantia'];
				}
				else{
					trae_signGrtia = null;
				}
				//console.log(trae_signGrtia);

				nombre  = val["nombre_cliente"]+" "+val["ap_cliente"]+" "+val["am_cliente"];
				folio   = (val["movID"] == null || val["movID"]["MovID"] == null) ? "-" : val["movID"]["MovID"];
				tipo	= (val["movimiento"] == null) ? "Pública": "Pregarantía";
				btn = "";
				//btn     =  "<button class='btn btn-sm profeco' style='background: #152f6d;' id='profeco-"+val["id"]+"'><i class='fa fa-file-download'></i>  &nbsp&nbsp Formato Profeco</button>";
				//btn     =  "<button class='btn btn-sm profec' style='background: #152f6d;' id='profeco-"+val["id"]+"'><i class='fa fa-file-download'></i>  &nbsp&nbsp Formato Profeco</button>";
				// btn     +=  "<button class='btn btn-sm profecoTalisman' style='background: #152f6d;' id='profecoTalisman-"+val["id"]+"'><i class='fa fa-file-download'></i>  &nbsp&nbsp Formato Profeco Toyota</button>";
				//btn     += "<button class='btn btn-sm multipuntos' style='background: #152f6d;' id='multi-"+val["id"]+"'><i class='fa fa-file-download'></i>  &nbsp&nbsp Hoja Multipuntos</button>";
				//btn     += "<button class='btn btn-sm formatoInventario' style='background: #152f6d;' id='inv-"+val["id"]+"'><i class='fa fa-file-download'></i>  &nbsp&nbsp Formato de Inventario</button>";
				// si la firma renucia extension garantia es diferente a la vacia y diferente de null entonces muestra el boton para ver formato firmado
				// es decir solo aparecera el boton para ver la carta siempre y cuando el cliente firme la carta desde la creacion de la orden
				//  bnt_renunciaGrtia == true  solo si aplicar para ford en los distribuidores que necesiten la carta de rechazo a extensión de garantía
				btn_garantias	=``;
				btn_garantias	+="<button class='btn btn-sm archivosadjuntos' style='background: #152f6d;' id='archivosadjuntos-"+val["id"]+"'><i class='fa fa-file-download'></i>&nbsp&nbsp Archivos Adjuntos</button>";
				btn_garantias	+="<button class='btn btn-sm verautorizaciones' style='background: #152f6d;' id='verautorizaciones-"+val["id"]+"'><i class='fa fa-folder-open'></i>&nbsp&nbsp Ver firmas</button>";
				//action_garantias	= "<button class='btn btn-sm f1863' style='background: #79c143;' id='f1863-"+val["id"]+"'><i class='fa fa-file'></i>  &nbsp&nbsp Abrir&nbspF-1863</button>";
				action_garantias	="<button class='btn btn-sm correohist' style='background:#2B95FF;' id='correo-"+val["id"]+"'><i class='fa fa-envelope'></i>&nbsp&nbsp Correo</button>";
				action_garantias	+="<button class='btn btn-sm anexofotos' style='background:#C70039;' id='anexofotos-"+val["id"]+"'><i class='fa fa-images'></i>&nbsp&nbsp Fotografías</button>";
				action_garantias	+="<button type='button' class='btn btn-sm btn-primary autorizaciones' style='background: #152f6d;' data-toggle='modal' data-target='#modalautorizaciones' id='autorizaciones-"+val["id"]+"'><i class='fa fa-check'></i>&nbsp&nbsp Autorizaciones</button>";
				action_garantias	+= "<button class='btn btn-sm whatsapp' style='background: #79c143;' id='whats-"+val["id"]+"'><i class='fab fa-whatsapp'></i>  &nbsp&nbsp Whatsapp</button>";
				action_garantias	+="<button class='btn btn-sm cargardocumentacion' style='background:#C70039;' id='addDoc-"+val["id"]+"'><i class='fa fa-file'></i>&nbsp&nbsp Cargar&nbspDocs</button>";
				//action_garantias	+="<button class='btn btn-sm autorizarefacc' style='background:#17A2B8;' id='autorizarefacc-"+val["id"]+"'><i class='fa fa-paste'></i>&nbsp&nbsp Autorizar Refacciones</button>";
				//action_garantias	 +="<button class='btn btn-sm pregarantia' style='background:#C70039;' id='pregarantia-"+val["id"]+"'><i class='fa fa-paste'></i>&nbsp&nbsp Validar Pregarantía</button>";
				//action_garantias	+=`<button type="button" class="btn btn-primary btn-sm refacciones" id='autorizar_refacciones-${val["id"]}'><i class="fa fa-check"></i>&nbsp&nbsp Autorizar Refacciones</button>`;
				btn_gerente		=``;
				btn_gerente		+="<button class='btn btn-sm archivosadjuntos' style='background: #152f6d;' id='archivosadjuntos-"+val["id"]+"'><i class='fa fa-file-download'></i>&nbsp&nbsp Archivos Adjuntos</button>";
				action_gerente	="<button type='button' class='btn btn-sm btn-primary autorizaciones' style='background: #152f6d;' data-toggle='modal' data-target='#modalautorizaciones' id='autorizaciones-"+val["id"]+"'><i class='fa fa-check'></i>&nbsp&nbsp Autorizaciones</button>";
				btn_jefe       = ``;
				btn_jefe	+="<button class='btn btn-sm archivosadjuntos' style='background: #152f6d;' id='archivosadjuntos-"+val["id"]+"'><i class='fa fa-file-download'></i>&nbsp&nbsp Archivos Adjuntos</button>";
				//action_jefe    = `<button type="button" class="btn btn-primary btn-sm diagnostico" id='autorizar_diagnostico-${val["id"]}'><i class="fa fa-check"></i>&nbsp&nbsp Autorizar Diagnóstico</button>`;
				//action_jefe		+=`<button type="button" class="btn btn-primary btn-sm add" id='autorizar_add-${val["id"]}'><i class="fa fa-check"></i>&nbsp&nbsp Autorizar ADD</button>`;
				action_jefe		="<button type='button' class='btn btn-sm btn-primary autorizaciones' style='background: #152f6d;' data-toggle='modal' data-target='#modalautorizaciones' id='autorizaciones-"+val["id"]+"'><i class='fa fa-check'></i>&nbsp&nbsp Autorizaciones</button>";
				btn_tecnico    = ``;
				btn_tecnico    += "<button class='btn btn-sm archivosadjuntos' style='background: #152f6d;' id='archivosadjuntos-"+val["id"]+"'><i class='fa fa-file-download'></i>&nbsp&nbsp Archivos Adjuntos</button>";
				//action_tecnico = `<button type="button" class="btn btn-sm btn-primary revisionqueja" id='revisionqueja-${val["id"]}'><i class="fa fa-tasks"></i>&nbsp&nbsp Revisión Quejas</button>`;
				if((trae_signGrtia != firma_vacia && trae_signGrtia != null) && bnt_renunciaGrtia == true){
					//btn     +="<button class='btn btn-sm renunciaGrtia' style='background: #ff9800;' id='renunGrtia-"+val["id"]+"'><i class='fa fa-file-download'></i>  &nbsp&nbsp Carta de renuncia a beneficios</button>";
					// se agregan los valores del vin y de la firma de renuncia a extesion de garantia para enviar a la ApiReporter que genera el formato
					btn     += "<input type='hidden' id='api_vin-"+val["id"]+"' value='"+val['vin']+"'>";
					btn     += "<input type='hidden' id='api_signGrtia-"+val["id"]+"' value='"+trae_signGrtia+"'>";
					btn     += "<input type='hidden' id='api_nomCte-"+val["id"]+"' value='"+nombre+"'>";
					btn     += "<input type='hidden' id='api_signAsesor-"+val["id"]+"' value='"+val['signAsesor']+"'>";
				}	
				btn     += "<input type='hidden' id='btn_trae_firma' value='"+trae_firma+"'>";
				//action_jefe       += `<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#asignModal"><i class="fas fa-bars"></i>&nbsp&nbsp Asignar Técnico</button>`;
				action_tecnico		= `<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#requisModal"><i class="fas fa-bars"></i>&nbsp&nbsp Requisiciones</button>`;
				action_tecnico		+= `<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModalLong"><i class="fas fa-bars"></i>&nbsp&nbsp Generar Reverso</button>`;
				// se usara para ver a que cliente se envia en presupuesto
				btn     += "<input type='hidden' id='btn_email_cte' value='"+correo_cte+"'>";
				btn     += "<button class='btn btn-sm archivosadjuntos' style='background: #152f6d;' id='archivosadjuntos-"+val["id"]+"' data-trae_signGrtia='"+trae_signGrtia+"'><i class='fa fa-file-download'></i>&nbsp&nbsp Archivos Adjuntos</button>";
				action  = "<button class='btn btn-sm whatsapp' style='background: #79c143;' id='whats-"+val["id"]+"'><i class='fab fa-whatsapp'></i>  &nbsp&nbsp Whatsapp</button>";
				action  +="<button class='btn btn-sm correohist' style='background:#2B95FF;' id='correo-"+val["id"]+"'><i class='fa fa-envelope'></i>&nbsp&nbsp Correo</button>";
				action  +="<button class='btn btn-sm anexofotos' style='background:#C70039;' id='anexofotos-"+val["id"]+"'><i class='fa fa-images'></i>&nbsp&nbsp Fotografías</button>";
				action  +="<button class='btn btn-sm cargardocumentacion' style='background:#C70039;' id='addDoc-"+val["id"]+"'><i class='fa fa-file'></i>&nbsp&nbsp Cargar Documentación</button>";
				if (val['movimiento'] == null) {
					action  +="<button class='btn btn-sm pregarantia' style='background:#C70039;' id='pregarantia-"+val["id"]+"'><i class='fa fa-paste'></i>&nbsp&nbsp Abrir Pregarantía</button>";
				}
				//btn  +="<button class='btn btn-sm audiomp3' style='background:#fff200;' id='audiomp3-"+val["id"]+"'><i class='fa fa-file-audio-o'></i>&nbsp&nbsp audios mp3</button>";
				//console.log( val['contFirma']['contadorFirma']);
				//Se obtiene de buscador_model.php el valor de la consulta donde se evalua si existe firma o no del cliente en la orden de servico 
				if(val['contFirma']['contadorFirma'] == 0){
					action  +="<button class='btn btn-sm addFirma' style='background:#17A2B8;' id='addFirma-"+val["id"]+"'><i class='fa fa-file-signature'></i>&nbsp&nbsp Agregar Firma</button>";	
				}
				btn_presupuesto = "<button class='btn btn-sm new_budget' style='background: #607d8b;' id='"+val["id"]+"'><i class='fas fa-file-invoice-dollar'></i>  &nbsp&nbsp Generar Presupuesto</button>";
				btn_presupuesto += "<button class='btn btn-sm search_budgets' style='background: #607d8b;' id='"+val["id"]+"'><i class='fas fa-search'></i>  &nbsp&nbsp Ver Presupuestos</button>";
				btn_comentario = "<div style='display: none;' id='comentario-"+val["id"]+"'>"+val["comentario_tecnico_multip"]+"</div><button class='btn btn-sm btn-info comentario-tec' data-id='"+val["id"]+"'><i class='fa fa-edit'></i>&nbsp&nbsp Ver</button>";
				action2  ="<button class='btn btn-sm anexofotos' style='background:#C70039;' id='anexofotos-"+val["id"]+"'><i class='fa fa-images'></i>&nbsp&nbsp Fotografías</button>";
				action2  +="<button class='btn btn-sm cargardocumentacion' style='background:#C70039;' id='addDoc-"+val["id"]+"'><i class='fa fa-file'></i>&nbsp&nbsp Cargar Documentación</button>";
				action2  +="<button class='btn btn-sm pregarantia' style='background:#C70039;' id='pregarantia-"+val["id"]+"'><i class='fa fa-paste'></i>&nbsp&nbsp Abrir Pregarantía</button>";
				if(id_perfil == 6)
				{
					tabla_historico.fnAddData([
						val["id"],
						folio,
						tipo,	
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
				} else if(id_perfil == 4){
					tabla_historico.fnAddData([
						val["id"],
						folio,
						tipo,	
						nombre,	
						val["tel_movil"],
						val["vin"],
						val["anio_modelo_v"],
						btn_jefe,
						action_jefe,
						"",
						btn_comentario
					]);
				} else if(id_perfil == 5){
					tabla_historico.fnAddData([
						val["id"],
						folio,
						tipo,
						nombre,	
						val["tel_movil"],
						val["vin"],
						val["anio_modelo_v"],
						btn_tecnico,
						action_tecnico,
						"",
						btn_comentario
					]);
				} else if(id_perfil == 7){
					tabla_historico.fnAddData([
						val["id"],
						folio,
						tipo,
						nombre,	
						val["tel_movil"],
						val["vin"],
						val["anio_modelo_v"],
						btn_garantias,
						action_garantias,
						btn_presupuesto,
						btn_comentario
					]);
				} else if(id_perfil == 8){
					tabla_historico.fnAddData([
						val["id"],
						folio,
						tipo,
						nombre,	
						val["tel_movil"],
						val["vin"],
						val["anio_modelo_v"],
						btn_gerente,
						action_gerente,
						"",
						btn_comentario
					]);
				}else 
				{
					tabla_historico.fnAddData([
						val["id"],
						folio,
						tipo,	
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
	// para archivos adjuntos
	$(".tabla_hist tbody").on("click", "tr td button.archivosadjuntos", function (e){
		e.preventDefault();
		$('#archvis_documentacion').empty();
		var id_orden = $(this).prop("id");
		id_orden = id_orden.split("-");
		id_orden = id_orden[1];
		trae_signGrtia = $(this).data('trae_signgrtia');
		const firma_vacia = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAakAAADSCAYAAADwvj/tAAAAAXNSR0IArs4c6QAAB/JJREFUeF7t1UENAAAMArHh3/Rs3KNTQMoSdo4AAQIECEQFFs0lFgECBAgQOCPlCQgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAgQee7QDT4w9urAAAAABJRU5ErkJggg==";
		$.ajax({
			url: base_url+"index.php/servicio/get_archivos_orden_servicio/"+id_orden,
			type: "POST",
			dataType: 'json',
			beforeSend: function(){
				$("#loading_spin").show();
			},
			error: function(){
				$("#loading_spin").hide();
				toastr.warning('No hay archivos adjuntos para mostrar');
			},
			success: function(data){
				$("#loading_spin").hide();
				if (data.estatus){
					$('#modalarchivosadjuntos').modal('toggle');
					let archivos = "";
					archivos += `<tr>
						<td>Formato Profeco</td>
						<td>PDF</td>
						<td class="text-info" data-toggle="tooltip" data-placement="top" title="Descargar formato profeco"><a class="profec" id="profeco-${id_orden}" href="#!"><i class="fa fa-file-download"></i></a></td>`;
						archivos += id_perfil == 7 ? '<td></td>' : '';
					archivos +=`<tr>`;
					archivos += `<tr>
						<td>Hoja Multipuntos</td>
						<td>PDF</td>
						<td class="text-info" data-toggle="tooltip" data-placement="top" title="Ver hoja multipuntos"><a class="multipuntos" id="multi-${id_orden}" href="#!"><i class="fa fa-eye"></i></a></td>`;
						archivos += id_perfil == 7 ? '<td></td>' : '';
					archivos +=`<tr>`;
					archivos += `<tr>
						<td>Formato de Inventario</td>
						<td>PDF</td>
						<td class="text-info" data-toggle="tooltip" data-placement="top" title="Ver formato de inventario"><a class="formatoInventario" id="inv-${id_orden}" href="#!"><i class="fa fa-eye"></i></a></td>`;
						archivos += id_perfil == 7 ? '<td></td>' : '';
					archivos +=`<tr>`;
					if((trae_signGrtia != firma_vacia && trae_signGrtia != null) && bnt_renunciaGrtia == true){
						archivos += `<tr>
							<td>Carta de Renuncia a Beneficios</td>
							<td>PDF</td>
							<td class="text-warning" data-toggle="tooltip" data-placement="top" title="Ver carte de renuncia a beneficios"><a class="renunciaGrtia" id="renunGrtia-${id_orden}" href="#!"><i class="fa fa-eye"></i></a></td>`;
							archivos += id_perfil == 7 ? '<td></td>' : '';
						archivos +=`<tr>`;
					}
					if (data.archivos && data.archivos.length >0) {
						$.each(data.archivos, function(index, archivo){
							archivos += `<tr>`;
							archivos += `<td>${archivo['nombre']}</td>`;
							archivos += `<td>${archivo['tipo']}</td>`;
							archivos += `<td class="text-info" data-toggle="tooltip" data-placement="top" title="Ver archivo ${archivo['nombre']}"><a href="${archivo['ruta']}" target="_blank"><i class="fa fa-eye"></i></a></td>`;
							archivos += id_perfil == 7 ? `<td class="text-danger" data-toggle="tooltip" data-placement="top" title="Eliminar archivo ${archivo['nombre']}"><a href="#!" class="deladjunto" id="deladjunto-${archivo['id']}"><i class="fa fa-times text-danger"></i></a></td>` : '';
							archivos += `</tr>`;
						});
						$('#archivos_documentacion').html(archivos);
					}else{
						//archivos += '<tr><td colspan="3" class="text-center text-danger">No hay documentación adjunta.</td></tr>';
						$('#archivos_documentacion').html(archivos);
					}
				}else{
					toastr.warning('No hay documentación adjunta.');
				}
			}
		});
	});

	var b_profeco = false;
	//condicion que  genera en pdf la orden de servicio por marca
	if(formt_serv_pdf == "ford"){
		$("#archivos_documentacion").on("click", "tr td a.profec", function(e){
			// para crear formato ford
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
			}else 
			{
				toastr.info("Por favor, espere un momento, mientras termina la generación del formato");
			}
		});
	}
	else{
		$("#archivos_documentacion").on("click", "tr td a.profec", function(e){
			// para crear formato fame
			var id_orden = $(this).prop("id");
			id_orden = id_orden.split("-");
			id_orden = id_orden[1];
			window.open(base_url+"index.php/servicio/profeco_print/"+ id_orden, "_blank");
		});
	}

	$("#archivos_documentacion").on("click", "tr td a.multipuntos", function(e){
		var id_orden = $(this).prop("id");
		id_orden = id_orden.split("-");
		id_orden = id_orden[1];
		localStorage.setItem("hist_id_orden", id_orden);

		window.open(base_url+"index.php/servicio/ver_hojaMultipuntos/"+ id_orden, "_blank");
	});
	
	//formato de Inventario
	$("#archivos_documentacion").on("click", "tr td a.formatoInventario", function(e){
		var id_orden = $(this).prop("id");
		id_orden = id_orden.split("-");
		id_orden = id_orden[1];

		window.open(base_url+"index.php/servicio/generar_formatoInventario/0/"+ id_orden, "_blank");
	});

	//formato carta de renuncia a beneficios(rechazo a extension de garantia)
	$("#archivos_documentacion").on("click", "tr td a.renunciaGrtia", function(e){
		var id_orden = $(this).prop("id");
		id_orden = id_orden.split("-");
		id_orden = id_orden[1];
		var t_vin = $("#api_vin-"+id_orden).val();
		//var vin = $("#api_vin-26590").val();
		var signGrtia = $("#api_signGrtia-"+id_orden).val();
		//  t_nomCte  -> t_ = this
		var t_nomCte = $("#api_nomCte-"+id_orden).val();
		var t_signAsesor = $("#api_signAsesor-"+id_orden).val();
		//console.log(t_signAsesor);
		var tok=""
		$.ajax({
			url: "https://apiintelisis.intelisis-solutions.com:8443/auth/",
			type: "POST",
			dataType: 'json',
			data: {
				username:'Angelin20',
				password:'3210995'
			},
			beforeSend: function(){
				$("#loading_spin").show();
			},
			error: function(){
				console.log('error al consumir token de ApiReporter');
			},
			success: function (data){
				tok=data.token;
			}
		});
		$.ajax({
			url: "https://apiintelisis.intelisis-solutions.com:8443/reports/getPDF",
			type: "POST",
			headers: {
				Authorization: `Token ${tok}`,
			},
			//habilitar xhrFields cuando se requiera descargar
			//xhrFields: {responseType: "blob"},
			data: {
				name:'WRACRN001',
				dwn:'1',
				opt:'1',
				path:'None',
				vin:t_vin,
				garantia:signGrtia,
				nomCte:t_nomCte,
				signAsesor:t_signAsesor
			},
			beforeSend: function(){
				$("#loading_spin").show();
			},
			error: function(){
				console.log('error al consumir getPDF de ApiReporter');
				toastr.error("Error al generar el formato");
				$("#loading_spin").hide();
			},
			success: function (blob){
				$("#loading_spin").hide();
				//console.log(blob);
				// habilitar en caso de descarga xhrFields
				// var link = document.createElement('a');
				// link.href = window.URL.createObjectURL(blob);
				// para vizualiar formato en pc y descargar en tablet
				// window.open(link);
				// para de descargar el formato 
				//link.download = "WRACRN001.pdf";
				//link.click();
				// URL.revokeObjectURL(link.href);

				var win = window.open("", "_blank");
				//win.document.body.innerHTML = blob;
				win.document.write(blob);
		
			}
		});
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


	//Funcion de leyenda Ver en modal para agregar firmas muestra termins y condcions (contrato adehesion)
	$(document).on('click','#ver_termCond' ,function(e){
		e.preventDefault();
		window.open(base_url+"index.php/servicio/correo_reverso/"+ localStorage.getItem("hist_id_orden_firm"), "_blank");
	});

	//Habilitar y deshabilitar boton de guardado de firmas a traves de check "terminos y condiciones"
	$(document).on('click','#cb_termCond' ,function(e){
		if( val_checked("cb_termCond")  == true ){
		   $('#btn_guardarFirma').attr('disabled', false);
		}
		else{
			$('#btn_guardarFirma').attr("disabled", true);
		}
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
	//modal para agregar documentación en caso de que la orden no las tenga
	$(".tabla_hist tbody").on("click", "tr td button.cargardocumentacion", function(e){
		e.preventDefault();
		var id_orden = $(this).prop("id");
		id_orden = id_orden.split("-");
		id_orden = id_orden[1];
		localStorage.setItem("hist_id_orden", id_orden);
		$('#modaldocumentacion').modal("show");
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
        height : 210           // Default signature height in px
    };

    firmaH = $("#firma").jqSignature(config);
    firmaH2 = $("#firma2").jqSignature(config);
    firmaH3 = $("#firma3").jqSignature(config);


    function limpiar_firmas() {
    	 $("#firma").jqSignature('clearCanvas');
    	 $("#firma2").jqSignature('clearCanvas');
    	 $("#firma3").jqSignature('clearCanvas');
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

	$(document).on("click", '#btn_borrarFirma3', function (e){
	    e.preventDefault();
	    $("#firma3").jqSignature('clearCanvas');
	    // $("#firma").jSignature("clear");
	    $("#valor_firma3").val("");
	    $("#loading_spin").hide();
	});


	$(document).on("click", '#btn_guardarFirma', function (e){
    e.preventDefault();

    $("#valor_firma").val(firmaH.jqSignature("getDataURL"));
    $("#valor_firma2").val(firmaH2.jqSignature("getDataURL"));
    $("#valor_firma3").val(firmaH3.jqSignature("getDataURL"));

    var form = $("#formFirma").serialize();
    var id_orden_servicio = localStorage.getItem("hist_id_orden_firm");
    //var firma_vacia = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZAAAADICAYAAADGFbfiAAAHFklEQVR4Xu3VsQ0AAAjDMPr/0/yQ2exdLKTsHAECBAgQCAILGxMCBAgQIHAC4gkIECBAIAkISGIzIkCAAAEB8QMECBAgkAQEJLEZESBAgICA+AECBAgQSAICktiMCBAgQEBA/AABAgQIJAEBSWxGBAgQICAgfoAAAQIEkoCAJDYjAgQIEBAQP0CAAAECSUBAEpsRAQIECAiIHyBAgACBJCAgic2IAAECBATEDxAgQIBAEhCQxGZEgAABAgLiBwgQIEAgCQhIYjMiQIAAAQHxAwQIECCQBAQksRkRIECAgID4AQIECBBIAgKS2IwIECBAQED8AAECBAgkAQFJbEYECBAgICB+gAABAgSSgIAkNiMCBAgQEBA/QIAAAQJJQEASmxEBAgQICIgfIECAAIEkICCJzYgAAQIEBMQPECBAgEASEJDEZkSAAAECAuIHCBAgQCAJCEhiMyJAgAABAfEDBAgQIJAEBCSxGREgQICAgPgBAgQIEEgCApLYjAgQIEBAQPwAAQIECCQBAUlsRgQIECAgIH6AAAECBJKAgCQ2IwIECBAQED9AgAABAklAQBKbEQECBAgIiB8gQIAAgSQgIInNiAABAgQExA8QIECAQBIQkMRmRIAAAQIC4gcIECBAIAkISGIzIkCAAAEB8QMECBAgkAQEJLEZESBAgICA+AECBAgQSAICktiMCBAgQEBA/AABAgQIJAEBSWxGBAgQICAgfoAAAQIEkoCAJDYjAgQIEBAQP0CAAAECSUBAEpsRAQIECAiIHyBAgACBJCAgic2IAAECBATEDxAgQIBAEhCQxGZEgAABAgLiBwgQIEAgCQhIYjMiQIAAAQHxAwQIECCQBAQksRkRIECAgID4AQIECBBIAgKS2IwIECBAQED8AAECBAgkAQFJbEYECBAgICB+gAABAgSSgIAkNiMCBAgQEBA/QIAAAQJJQEASmxEBAgQICIgfIECAAIEkICCJzYgAAQIEBMQPECBAgEASEJDEZkSAAAECAuIHCBAgQCAJCEhiMyJAgAABAfEDBAgQIJAEBCSxGREgQICAgPgBAgQIEEgCApLYjAgQIEBAQPwAAQIECCQBAUlsRgQIECAgIH6AAAECBJKAgCQ2IwIECBAQED9AgAABAklAQBKbEQECBAgIiB8gQIAAgSQgIInNiAABAgQExA8QIECAQBIQkMRmRIAAAQIC4gcIECBAIAkISGIzIkCAAAEB8QMECBAgkAQEJLEZESBAgICA+AECBAgQSAICktiMCBAgQEBA/AABAgQIJAEBSWxGBAgQICAgfoAAAQIEkoCAJDYjAgQIEBAQP0CAAAECSUBAEpsRAQIECAiIHyBAgACBJCAgic2IAAECBATEDxAgQIBAEhCQxGZEgAABAgLiBwgQIEAgCQhIYjMiQIAAAQHxAwQIECCQBAQksRkRIECAgID4AQIECBBIAgKS2IwIECBAQED8AAECBAgkAQFJbEYECBAgICB+gAABAgSSgIAkNiMCBAgQEBA/QIAAAQJJQEASmxEBAgQICIgfIECAAIEkICCJzYgAAQIEBMQPECBAgEASEJDEZkSAAAECAuIHCBAgQCAJCEhiMyJAgAABAfEDBAgQIJAEBCSxGREgQICAgPgBAgQIEEgCApLYjAgQIEBAQPwAAQIECCQBAUlsRgQIECAgIH6AAAECBJKAgCQ2IwIECBAQED9AgAABAklAQBKbEQECBAgIiB8gQIAAgSQgIInNiAABAgQExA8QIECAQBIQkMRmRIAAAQIC4gcIECBAIAkISGIzIkCAAAEB8QMECBAgkAQEJLEZESBAgICA+AECBAgQSAICktiMCBAgQEBA/AABAgQIJAEBSWxGBAgQICAgfoAAAQIEkoCAJDYjAgQIEBAQP0CAAAECSUBAEpsRAQIECAiIHyBAgACBJCAgic2IAAECBATEDxAgQIBAEhCQxGZEgAABAgLiBwgQIEAgCQhIYjMiQIAAAQHxAwQIECCQBAQksRkRIECAgID4AQIECBBIAgKS2IwIECBAQED8AAECBAgkAQFJbEYECBAgICB+gAABAgSSgIAkNiMCBAgQEBA/QIAAAQJJQEASmxEBAgQICIgfIECAAIEkICCJzYgAAQIEBMQPECBAgEASEJDEZkSAAAECAuIHCBAgQCAJCEhiMyJAgAABAfEDBAgQIJAEBCSxGREgQICAgPgBAgQIEEgCApLYjAgQIEBAQPwAAQIECCQBAUlsRgQIECAgIH6AAAECBJKAgCQ2IwIECBAQED9AgAABAklAQBKbEQECBAgIiB8gQIAAgSQgIInNiAABAgQExA8QIECAQBIQkMRmRIAAAQIC4gcIECBAIAkISGIzIkCAAAEB8QMECBAgkAQEJLEZESBAgICA+AECBAgQSAICktiMCBAgQOABB1wAyWjdfzMAAAAASUVORK5CYII=";
    var firma_vacia = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAakAAADSCAYAAADwvj/tAAAAAXNSR0IArs4c6QAAB/JJREFUeF7t1UENAAAMArHh3/Rs3KNTQMoSdo4AAQIECEQFFs0lFgECBAgQOCPlCQgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAgQee7QDT4w9urAAAAABJRU5ErkJggg==";
   
    form += "&id_orden_servicio="+id_orden_servicio;
    // valor de check terminos y condiciones
    form += "&cb_termCond="+ val_checked("cb_termCond");

    //console.log($("#valor_firma").val());

    if($("#valor_firma").val() == firma_vacia)
    {
    	toastr.warning("La firma para el Formato profeco está vacía, favor de proporcionarla.");
    }
    else if($("#valor_firma2").val() == firma_vacia){
    	toastr.warning("La firma para el Formato de inventario está vacía, favor de proporcionarla.");
    }
    else 
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
//funcion para obtener valor de un check box sin value asignado
function val_checked(id_cbx) {
	var v = false;
	if( ( v = $("#"+ id_cbx +":checked").val() ) != null ){
		v = true;
	}
	return v;
}
//Cambio para adjuntar pdf
$(document).on("change", "#cargar_doc", function(event){
    optimizar_archivo(event);
});
//Cambio para adjuntar pdf
$(document).on("click", "#btn_guardar_doc", function(event){
     event.preventDefault();
    var data = new FormData();
    var id_orden = localStorage.getItem("hist_id_orden");
    const archivos = $("input[name='doc_adjunto[]']");
    const tipos = $("input[name='tipo[]']");
    $('#id_orden_servicio_doc').val(id_orden);
    data.append('id_orden_servicio', id_orden);
     $.each(archivos, function(index, val)
    {
        var file = base64toFile($(val).val(), "archivo-"+(index+1));
        data.append("archivo-"+(index+1), file);
    });
     $.each(tipos, function(index, val)
    {
        data.append("tipo[]", $(val).val());
    });
    guardar_documentacion(data);
});
function optimizar_archivo(e)
{
	$("#loading_spin").show();
    var fileName = e.target.files[0].name;
    var reader = new FileReader(); 								//Se crea instancia de FileReader Js API
    reader.readAsDataURL(e.target.files[0]);					//Lee la imagen que está en el input usando el FileReader
    reader.onload = event => {
        var binaryData = event.target.result;
      //Converting Binary Data to base 64
      var base64String = window.btoa(binaryData);
      base64data = reader.result;
      //showing file converted to base64
      const archivo = `
      	<tr>
      		<input type='hidden' value='${base64data}' name="doc_adjunto[]" />
      		<input type='hidden' value='${$('input[name="tipo_archivo"]:checked').val()}' name="tipo[]" />
      		<td>${fileName}</td>
      		<td>${$('input[name="tipo_archivo"]:checked').val()}</td>
      		<td><i class="fa fa-times text-danger td_borrar_doc" style="cursor: pointer;"></i></td>
      	</tr>
      `;
      $('#archivos_adjuntos_doc').append(archivo);
	  
	  $("#loading_spin").hide();
	  $('#cargar_doc').val('');
    };
}
function guardar_documentacion(form)
{
    $.ajax({
        cache: false,
        url: base_url+ "index.php/servicio/guardar_documentacion/",
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        data: form,
        beforeSend: function(){
            toastr.info("Guardando documentación, por favor, espere un momento.");
            $("#loading_spin").show();
        }
    })
    .done(function(data) {
    	$("#loading_spin").hide();
        if(data.length > 0)
        {
        	$('#archivos_adjuntos_doc').empty();
            toastr.success("Se guardo la documentación.");

        }else
        {
            toastr.error("Hubo un error al guardar la documentación.");
        }
    })
    .fail(function() {
        alert("Hubo un error al guardar la documentación.");
        $("#loading_spin").hide();
    });
}
$(document).on('click', '#btn_borrar_doc', function (e) {
	e.preventDefault();
	$('#archivos_adjuntos_doc').empty();
	$('#cargar_doc').val('');
});

//autorizar diagnóstico por parte del jefe de taller
	/*$(document).on("click", ".tabla_hist tbody tr td button.diagnostico", function(e){
		e.preventDefault();
		var id_orden = $(this).prop("id");
		id_orden = id_orden.split("-");
		id_orden = id_orden[1];
		localStorage.setItem("hist_id_orden", id_orden);
		swal({
			title: '¿Autorizar el diagnóstico de la orden?',
			showCancelButton: true,
			confirmButtonText: 'Autorizar',
			cancelButtonText: 'Cancelar',
			type: 'info'
			}).then((result) => {
				if (result.value) {
					swal('Diagnóstico autorizado.', '', 'success');
				} else if (result.dismiss) {
					swal('Cancelado', '', 'error');
				}
		});
	});*/

//abrir pregarantía por parte del asesor
	$(document).on("click", ".tabla_hist tbody tr td button.pregarantia", function(e){
		e.preventDefault();
		var id_orden = $(this).prop("id");
		id_orden = id_orden.split("-");
		id_orden = id_orden[1];
		localStorage.setItem("hist_id_orden", id_orden);
		swal({
			title: 'Abrir Pregarantía',
			showCancelButton: true,
			confirmButtonText: 'Abrir',
			cancelButtonText: 'Cancelar',
			type: 'info'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						url: `${base_url}index.php/servicio/abrir_pregarantia`,
						type: 'POST',
						dataType: 'json',
						data: {id_orden_servicio: id_orden},
						beforeSend: function(){
							toastr.info("Abriendo Pregarantía.");
							$("#loading_spin").show();
						}
					})
					.done(function(data) {
						if (data.estatus) {
							swal('Pregarantía abierta.', '', 'success');
							$("#btn_mostrar").trigger("click");
						}else{
							toastr.warning('Hubo un error al abrir la pregarantía');
						}
					})
					.fail(function() {
						toastr.warning('Hubo un error al abrir la pregarantía');
					})
					.always(function() {
						$("#loading_spin").hide();
					});
					
					//swal('Pregarantía abierta.', '', 'success');
				} else if (result.dismiss) {
					swal('Cancelado', '', 'error');
				}
		});
	});
// autorizar pregarantia
$(document).on('click', '#autor_preg', function(e){
	e.preventDefault();
	var id_orden = $(this).prop("data-orden");
	console.log('id orden', id_orden);
	localStorage.setItem("hist_id_orden", id_orden);
	const form = new FormData();
	form.append('id_orden_servicio', id_orden);
	swal({
		title: '¿Autorizar Pregarantia?',
		showCancelButton: true,
		confirmButtonText: 'Autorizar',
		cancelButtonText: 'Cancelar',
		type: 'info'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					cache: false,
					url: base_url+ "index.php/servicio/autorizar_pregarantia/",
					contentType: false,
					processData: false,
					type: 'POST',
					dataType: 'json',
					data: form,
					beforeSend: function(){
						$("#loading_spin").show();
					}
				})
				.done(function(data) {
					if (data.estatus) {
						swal('Pregarantia autorizada.', '', 'success');
						$("#pregCheck1").prop("checked", true);
						$("#pregCheck1").css('display', 'inline-block');
						document.getElementById("autor_preg").disabled = true;
						$("#cancelar_preg").css('display', 'inline-block');
					}else{
						toastr.warning(data.mensaje);
					}
				})
				.fail(function() {
					toastr.warning('Hubo un error al autorizar pregarantia');
				})
				.always(function() {
					$("#loading_spin").hide();
				});
			} else if (result.dismiss) {
				swal('Cancelado', '', 'error');
			}
	});
});

$(document).off('click', '.autorizaciones').on('click', '.autorizaciones', function (e) {
	let id_orden = $(this).prop('id');
    id_orden = id_orden.split('-')[1];
	e.preventDefault();
	console.log('id', id_orden);
	$('#autor_preg').prop('data-orden', id_orden);
	$('#autor_add').prop('data-orden', id_orden);
	$('#cancelar_preg').prop('data-orden', id_orden);
	$('#cancelar_add').prop('data-orden', id_orden);
	
	$('#autor_preg').prop('disabled', false);
	$('#autor_add').prop('disabled', false);
	$('#cancelar_preg').css('display', 'none');
	$('#cancelar_add').css('display', 'none');
	$('#pregCheck1').prop('checked', false);
	$('#addCheck1').prop('checked', false);
	$.ajax({
		cache: false,
		url: base_url+ "index.php/servicio/obtenerFirmasPregarantia/"+id_orden,
		url: base_url+ "index.php/servicio/obtenerFirmaAdd/"+id_orden,
		contentType: false,
		processData: false,
		type: 'GET',
		dataType: 'json',
		beforeSend: function(){
			$("#loading_spin").show();
		}
	}).done(function (data) {
		if (data.estatus) {
			if (data.data.length > 0) {
				if(data.data[0].firma_pregarantiaJefe != null){
					$('#autor_preg').prop('disabled', true);
					$('#pregCheck1').prop('checked', true);
					$('#cancelar_preg').css('display', 'inline-block');

				}
			}
		}else {
			toast.warning(data.mensaje);
		}
	}).fail(function (error) {
		toast.warning("No se pudo obtener información de las firmas");
	})
	.always(function() {
		$("#loading_spin").hide();
	});
	$.ajax({
		cache: false,
		url: base_url+ "index.php/servicio/obtenerFirmaAdd/"+id_orden,
		contentType: false,
		processData: false,
		type: 'GET',
		dataType: 'json',
		beforeSend: function(){
			$("#loading_spin").show();
		}
	}).done(function (data) {
		if (data.estatus) {
			if (data.data.length > 0) {
				if(data.data[0].firma_adicionalJefe != null){
					$('#autor_add').prop('disabled', true);
					$('#addCheck1').prop('checked', true);
					$('#cancelar_add').css('display', 'inline-block');
				}
			}
		}else {
			toast.warning(data.mensaje);
		}
	}).fail(function (error) {
		toast.warning("No se pudo obtener información de las firmas");
	})
	.always(function() {
		$("#loading_spin").hide();
	});
});

$(document).on('click', '#cancelar_preg', function(e){
	e.preventDefault();
	var id_orden = $(this).prop("data-orden");
	localStorage.setItem("hist_id_orden", id_orden);
	const form = new FormData();
	form.append('id_orden_servicio', id_orden);
	swal({
		title: '¿Desea cancelar pregarantia?',
		showCancelButton: true,
		confirmButtonText: 'Cancelar',
		cancelButtonText: 'Cancelar',
		type: 'info'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					cache: false,
					url: base_url+ "index.php/servicio/cancelar_firma_pregarantia/",
					contentType: false,
					processData: false,
					type: 'POST',
					dataType: 'json',
					data: form,
					beforeSend: function(){
						$("#loading_spin").show();
					}
				})
				.done(function(data) {
					if (data.estatus) {
						swal('Pregarantia cancelada.', '', 'success');
						$("#pregCheck1").prop("checked", false);
						$("#cancelar_preg").css('display', 'none');
						document.getElementById("autor_preg").disabled = false;
					}else{
						toastr.warning(data.mensaje);
					}
				})
				.fail(function() {
					toastr.warning('Hubo un error al cancelar pregarantia');
				})
				.always(function() {
					$("#loading_spin").hide();
				});
			} else if (result.dismiss) {
				swal('Cancelado', '', 'error');
			}
	});
});
// autoriza refacciones admón de garantias
$(document).on("click", ".tabla_hist tbody tr td button.autorizarefacc", function(e){
	e.preventDefault();
	var id_orden = $(this).prop("id");
	id_orden = id_orden.split("-");
	id_orden = id_orden[1];
	localStorage.setItem("hist_id_orden", id_orden);
	swal({
		title: '¿Desea autorizar Refacciones?',
		showCancelButton: true,
		confirmButtonText: 'Autorizar',
		cancelButtonText: 'Cancelar',
		type: 'info'
		}).then((result) => {
			if (result.value) {
				swal('Refacciones autorizadas.', '', 'success');
			} else if (result.dismiss) {
				swal('Cancelado', '', 'error');
			}
	});
});
// autorizar Adicional (ADD) por parte jefe taller y de Gerente
$(document).on('click', '#autor_add', function(e){
	e.preventDefault();
	var id_orden = $(this).prop("data-orden");
	console.log('id orden', id_orden);
	localStorage.setItem("hist_id_orden", id_orden);
	const form = new FormData();
	form.append('id_orden_servicio', id_orden);
	swal({
		title: '¿Autorizar Adicional?',
		showCancelButton: true,
		confirmButtonText: 'Autorizar',
		cancelButtonText: 'Cancelar',
		type: 'info'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					cache: false,
					url: base_url+ "index.php/servicio/autorizar_adicional/",
					contentType: false,
					processData: false,
					type: 'POST',
					dataType: 'json',
					data: form,
					beforeSend: function(){
						$("#loading_spin").show();
					}
				})
				.done(function(data) {
					if (data.estatus) {
						swal('Adicional autorizada.', '', 'success');
						$("#addCheck1").prop("checked", true);
						$("#addCheck1").css('display', 'inline-block');
						document.getElementById("autor_add").disabled = true;
						$("#cancelar_add").css('display', 'inline-block');
					}else{
						toastr.warning(data.mensaje);
					}
				})
				.fail(function() {
					toastr.warning('Hubo un error al autorizar adicional');
				})
				.always(function() {
					$("#loading_spin").hide();
				});
			} else if (result.dismiss) {
				swal('Cancelado', '', 'error');
			}
	});
});

$(document).on('click', '#cancelar_add', function(e){
	e.preventDefault();
	var id_orden = $(this).prop("data-orden");
	localStorage.setItem("hist_id_orden", id_orden);
	const form = new FormData();
	form.append('id_orden_servicio', id_orden);
	swal({
		title: '¿Desea cancelar adicional?',
		showCancelButton: true,
		confirmButtonText: 'Cancelar',
		cancelButtonText: 'Cancelar',
		type: 'info'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					cache: false,
					url: base_url+ "index.php/servicio/cancelar_firma_adicional/",
					contentType: false,
					processData: false,
					type: 'POST',
					dataType: 'json',
					data: form,
					beforeSend: function(){
						$("#loading_spin").show();
					}
				})
				.done(function(data) {
					if (data.estatus) {
						swal('Adicional cancelada.', '', 'success');
						$("#addCheck1").prop("checked", false);
						$("#cancelar_add").css('display', 'none');
						document.getElementById("autor_add").disabled = false;
					}else{
						toastr.warning(data.mensaje);
					}
				})
				.fail(function() {
					toastr.warning('Hubo un error al cancelar adicional');
				})
				.always(function() {
					$("#loading_spin").hide();
				});
			} else if (result.dismiss) {
				swal('Cancelado', '', 'error');
			}
	});
});

//Cambio para adjuntar pdf
$(document).on("change", "#oasisInput", function(event){
    optimizar_PDF(event);
});
//Cambio para adjuntar pdf
$(document).on("click", "#btn_guardarOasis", function(event){
     event.preventDefault();
    var data = new FormData();
    var id_orden = localStorage.getItem("hist_id_orden");
    var oasis = $("#input_vista_previa_pdf").val();
    data.append("id_orden", id_orden);
    data.append("oasis",oasis);
    guardar_oasis(data);
});
function optimizar_PDF(e)
{
	$("#loading_spin").show();
    var fileName = e.target.files[0].name;
    var reader = new FileReader(); 								//Se crea instancia de FileReader Js API
    reader.readAsDataURL(e.target.files[0]);					//Lee la imagen que está en el input usando el FileReader
    reader.onload = event => {
        var binaryData = event.target.result;
      //Converting Binary Data to base 64
      var base64String = window.btoa(binaryData);
      base64data = reader.result;
      //showing file converted to base64
      $('#input_vista_previa_pdf').val(base64data);
	  $('#vista_previa_pdf').prop('src', base64data);
	  $("#loading_spin").hide();
    };
}
function guardar_oasis(form)
{
    $.ajax({
        cache: false,
        url: base_url+ "index.php/servicio/guardar_formatoOasis/",
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        data: form,
        beforeSend: function(){
            toastr.info("Guardando formato Oasis, por favor, espere un momento.");
            $("#loading_spin").show();
        }
    })
    .done(function(data) {
    	$("#loading_spin").hide();
        if(data.estatus)
        {
            toastr.success("Se han guardado el formato Oasis.");

        }else
        {
            toastr.error("Hubo un error al guardar el formato Oasis.");
        }
    })
    .fail(function() {
        alert("Hubo un error al guardar el formato Osis.");
        $("#loading_spin").hide();
    });
}
$(document).on('click', '#btn_borrarOasis', function (e) {
	e.preventDefault();
	$('#vista_previa_pdf').prop('src', '');
	$('#input_vista_previa_pdf').val('');
	$('#oasisInput').val('');
});

function base64toFile(dataurl, filename) 
{
    var arr = dataurl.split(','),
        mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]), 
        n = bstr.length, 
        u8arr = new Uint8Array(n);
            
    while(n--){
        u8arr[n] = bstr.charCodeAt(n);
    }
        
    return new File([u8arr], filename, {type:mime});
}
$(document).on('click', '.td_borrar_doc', function (e) {
	e.preventDefault();
	$(this).closest('tr').remove();
})
$(document).on('click', 'a.deladjunto', function (e) {
	e.preventDefault();
	id_archivo = $(this).prop('id');
	const tr = $(this).closest('tr');
	id_archivo = id_archivo.split('-')[1];
	$.ajax({
		url: base_url+ "index.php/servicio/eliminar_archivo_documentacion/"+ id_archivo,
		type: 'delete',
		dataType: 'json',
		beforeSend: function(){
            $("#loading_spin").show();
        }
	})
	.done(function(data) {
		if (data.estatus == true) {
			toastr.success(data.mensaje);
			tr.remove();
		}else{
			toastr.warning(data.mensaje);
		}
	})
	.fail(function(error) {
		toastr.warning('No fue posible eliminar el archivo');
	})
	.always(function() {
		$("#loading_spin").hide();
	});
	
})

//para modal jefe taller asigna tecnico
$("#asigna_tecnico").empty();
            $("#asigna_tecnico").append('<option value="">Seleccione</option>');
            /*for (var i = 0; i < data.Nombre.length; i++) {
                if (data.Nombre[i]['Nombre'] == data.Datos[0].Nombre)
                    $("#asigna_tecnico").append('<option value="' + data.Nombre[i]['Nombre'] + '" selected>' + data.Nombre[i]['Nombre'] + '</option>');
                else
                    $("#asigna_tecnico").append('<option value="' + data.Nombre[i]['Nombre'] + '">' + data.Nombre[i]['Nombre'] + '</option>');
            }*/

// nueva linea de registro de labor en codigo diagnostico del problema
$(document).on('click', '.nuevo_registro', function (e) {
	e.preventDefault();
	$(this).closest('tr').clone().insertBefore($(this).closest('tr'));
	$(this).closest('tr').find('input[type="text"]').val("");
})

$(document).on('click', '.borrar_registro', function (e) {
	e.preventDefault();
	if ($(this).closest('.registro_labor tr').find('tr').length > 0) {
        toastr.warning('No puedes eliminar el primer registro');
        return;
    }
    if ($('.registro_labor tr').length > 1) {
        $(this).closest('.registro_labor tr').remove();
    }else {
        toastr.warning('Debes matener una linea de registro');
    }
});

// nueva linea en requisiciones
$(document).on('click', '.nueva_linea', function (e) {
	e.preventDefault();
	//clone.find('input[type="text"]').prop('value', "");
	$(this).closest('tr').clone().insertBefore($(this).closest('tr'));
	$(this).closest('tr').find('input[type="text"]').val("");
})

$(document).on('click', '.borra_linea', function (e) {
	e.preventDefault();
	if ($(this).closest('.lineas_refacciones tr').find('tr').length > 0) {
        toastr.warning('No puedes eliminar la primer linea');
        return;
    }
    if ($('.lineas_refacciones tr').length > 1) {
        $(this).closest('.lineas_refacciones tr').remove();
    }else {
        toastr.warning('Debes matener una linea');
    }
});
// seleccionar linea revision quejas
$("#select_queja").empty();
            $("#select_queja").append('<option value=""></option>');
$(document).on('click', '.registrar_linea', function (e) {
	e.preventDefault();
	const actual = $('#quejas_diagnostico > tr').length;
	if (actual >= 5) {
		swal({
			title: 'No puedes agregar más de 5 quejas a tu revisión debido a que la garantía solo puede contener máximo 5 líneas.',
			type: "warning"
		});
		return;
	}
	const registro = $('<tr>');
	//registro.append($('<td>').append($('<input>',{'class': 'form-control','readonly': 'readonly', 'value': actual+1, 'name': 'num_linea[]'})));
	registro.append($('<td>').append($('<input>',{'class': 'form-control','readonly': 'readonly', 'value': $('#select_queja').val(), 'name': 'num_queja[]'})));
	registro.append($('<td>').append($('<textarea>',{'class': 'form-control','readonly': 'readonly', 'text': $('#queja').val(), 'name': 'queja[]'})));
    registro.append($('<td>').append($('<textarea>',{'class': 'form-control','readonly': 'readonly', 'text': $('#anotaciones_tec').val(), 'name': 'anotaciones[]'})));
	let check;
	if ($('#apl_grta:checked').length > 0){
		check = $('<div>',{'class': 'checkbox check_grta'}).append($('<input>',{'type': 'checkbox', 'disabled': 'disabled', 'checked': 'checked', 'name':`apl_grta[${actual}]`, 'id':`apl_grta[${actual}]`}));
	}else {
		check = $('<div>',{'class': 'checkbox check_grta'}).append($('<input>',{'type': 'checkbox', 'disabled': 'disabled', 'name':`apl_grta[${actual}]`, 'id':`apl_grta[${actual}]`}));
	}
	registro.append($('<td>').append(check));
	check.append($('<label>', {'for': `apl_grta[${actual}]`}));
	if ($('#apl_add:checked').length > 0){
		check = $('<div>',{'class': 'checkbox check_add'}).append($('<input>',{'type': 'checkbox', 'disabled': 'disabled', 'checked': 'checked', 'name':`apl_add[${actual}]`, 'id':`apl_add[${actual}]`}));
	}else {
		check = $('<div>',{'class': 'checkbox check_add'}).append($('<input>',{'type': 'checkbox', 'disabled': 'disabled', 'name':`apl_add[${actual}]`, 'id':`apl_add[${actual}]`}));
	}
	registro.append($('<td>').append(check));
	check.append($('<label>', {'for': `apl_add[${actual}]`}));
	registro.append($('<td>').append($('<button>',{'class': 'edit_reg'}).append($('<i>', {'class': 'fas fa-edit fa-1x'}))));
	registro.append($('<td>').append($('<button>',{'class': 'del_reg'}).append($('<i>', {'class': 'fa fa-times fa-1x'}))));
	$('#quejas_diagnostico').append(registro);
	$('#select_queja').val('');
	$('#queja').val('');
    $('#anotaciones_tec').val('');
	$('#apl_grta').prop('checked', false);
	$('#apl_add').prop('checked', false);
});
$(document).on('click', '#quejas_diagnostico .edit_reg', function (e) {
	e.preventDefault();
	if ($(this).find('i').hasClass('fa-edit')) {
		$(this).find('i').removeClass('fa-edit').addClass('fa-save');
		$(this).removeClass('btn-info').addClass('btn-success');
		$(this).closest('tr').find('input[name="num_queja[]"]').removeAttr('readonly');
		$(this).closest('tr').find('textarea[name="queja[]"]').removeAttr('readonly');
        $(this).closest('tr').find('textarea[name="anotaciones[]"]').removeAttr('readonly');
		$(this).closest('tr').find('.checkbox').find('input:checkbox').removeAttr('disabled');
		$(this).closest('tr').find('.checkbox').find('input[name="apl_add[]"]').removeAttr('disabled');
	} else {
		$(this).find('i').removeClass('fa-save').addClass('fa-edit');
		$(this).removeClass('btn-success').addClass('btn-info');
		$(this).closest('tr').find('input[name="num_queja[]"]').prop('readonly', 'readonly');
		$(this).closest('tr').find('textarea[name="queja[]"]').prop('readonly', 'readonly');
        $(this).closest('tr').find('textarea[name="anotaciones[]"]').prop('readonly', 'readonly');
		$(this).closest('tr').find('input:checkbox').prop('disabled', true);
		$(this).closest('tr').find('input[name="apl_add[]"]').prop('disabled', true);
	}
});
$(document).on('click', '#quejas_diagnostico .del_reg', function (e) {
	e.preventDefault();
	$(this).closest('tr').remove();
	recalcular_lineas();
});

$(document).on('click', '.tabla_hist tbody tr td button.revisionqueja', function (e) {
    let id_orden = $(this).prop('id');
    id_orden = id_orden.split('-')[1];
    e.preventDefault();
    $.ajax({
        url: `${base_url}index.php/servicio/obtener_datos_quejas/${id_orden}`,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $("#loading_spin").show();
            toastr.info('Obteniendo información de las quejas de la orden');
        }
    })
    .done(function(data) {
        if (data.estatus) {
            $('#select_queja').empty();
            $('#select_queja').append($('<option>',{'value': '', 'text': 'Select'}));
            $.each(data.data, function(index, val) {
                $('#select_queja').append($('<option>',{'value': val.id, 'text': val.id, 'data-queja': val.definicion_falla}));
            });
            $('#exampleModal').modal('toggle');
        }else {
            toastr.warning(data.mensaje);
        }
    })
    .fail(function() {
        toastr.warning('No fue posible obtener las quejas de la orden');
    })
    .always(function() {
        $('#loading_spin').hide();
    });
    
});

$(document).on('change', '#exampleModal #select_queja', function(e){
    e.preventDefault();
    $(this).closest('tr').find('#queja').val($(this).find('option:selected').data('queja'));
});

function recalcular_lineas() {
	const tr = $('#quejas_diagnostico > tr');
	$.each(tr, function(index, val) {
		$(this).find('input[name="num_linea[]"]').val(index+1);
		$(this).closest('check_grta').find('input:checkbox').prop({'name': `apl_grta[${index+1}]`, 'id': `apl_grta[${index+1}]`});
		$(this).closest('check_grta').find('label').prop('for', `apl_grta[${index+1}]`);
		$(this).closest('check_add').find('input:checkbox').prop({'name': `apl_add[${index+1}]`, 'name': `apl_add[${index+1}]`});
		$(this).closest('check_add').find('label').prop('for', `apl_add[${index+1}]`);
	});

}

$(document).on('click', '.tabla_hist tbody tr td button.verautorizaciones', function(e) {
	e.preventDefault();
	$('#tbl-aut').empty();
	let id_orden_servicio = $(this).prop('id');
	id_orden_servicio = id_orden_servicio.split('-')[1];
	$.ajax({
		url: `${base_url}index.php/servicio/obtener_firmas/${id_orden_servicio}`,
		type: 'GET',
		dataType: 'json',
		beforeSend: function () {
			$("#loading_spin").show();
		}
	})
	.done(function(data) {
		if (data.estatus) {
			let registro = undefined;
			console.log('daa', data.data);
			for (index in data.data) {
				console.log(index);
				registro = $("<tr>");
				registro.append($("<td>",{"text": index}));
				var checkbox = $('<div>', {'class': 'form-check'});
                if (data.data[index]) {
                	checkbox.append($('<input>', {'class': 'form-check-input', 'type': 'checkbox','checked': 'checked', 'disabled': 'disabled', 'id': `aut-${index}`}));
                	checkbox.append($('<label>', {'class': 'form-check-label', 'for': `aut-${index}`}));
                }else{
                	checkbox.append($('<input>', {'class': 'form-check-input', 'type': 'checkbox', 'disabled': 'disabled', 'id': `aut-${index}`}));
                	checkbox.append($('<label>', {'class': 'form-check-label', 'for': `aut-${index}`}));
                }
				registro.append($("<td>").append(checkbox));
				registro.append($("<td>"));
				registro.appendTo('#tbl-aut');
			}
			if (registro === undefined) {
				registro = $("<tr>");
				registro.append($("<td>",{"class": "text-danger text-center", "colspan": 3, "text": "No existen firmas para la orden de servicio."}));
				registro.appendTo('#tbl-aut');
			}else {
				$('#autorizacionesModal').modal('toggle');
			}
		}else {
			toastr.info(data.mensaje);
		}
	})
	.fail(function(error) {
		registro = $("<tr>");
		registro.append($("<td>",{"class": "text-danger text-center", "colspan": 3, "text": "No existen firmas para la orden de servicio."}));
		registro.appendTo('#tbl-aut');
		toastr.warning('Hubo un problema al tratar de obtener la información de las firmas.');
	})
	.always(function() {
		$("#loading_spin").hide();
	});
});
