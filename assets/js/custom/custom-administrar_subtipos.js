$(document).ready(function() {
	let sucursal = 0;
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
	var tabla_subtipos = $(".tabla_hist").dataTable(
	{
		"oLanguage": {
			"sProcessing":    "Procesando...",
			"sLengthMenu":    "Mostrar _MENU_ registros",
			"sZeroRecords":   "No se encontraron resultados",
			"sEmptyTable":    "Ning&uacute;n dato disponible en esta tabla",
			"sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":   "",
			"sSearch":        "Buscar:",
			"sUrl":           "",
			"sInfoThousands": ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst":     "<i class='fa fa-step-backward'></i>",
				"sLast":      "<i class='fa fa-step-forward'></i>",
				"sNext":     "<i class='fa fa-forward'></i>",
				"sPrevious": "<i class='fa fa-backward'></i>"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		},
		"aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
		"bSort": true,
		"bDestroy": true,
		"sPaginationType": "full_numbers",
		"pageLength": 5,
		"aoColumnDefs": [{ 
			"bVisible": false, 
			"aTargets": [0]
		}]
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
	$('#btn_mostrarSub').off('click').on('click', function(event) {
		event.preventDefault();
		tabla_subtipos.fnClearTable();
		//TODO -tipos y subtipos globales o por sucursal manejeran diversos catálogo de ellos
		var fecha_ini = $("#fecha_ini").val();
		var fecha_fin = $("#fecha_fin").val();
		$("#loading_spin").show();
		$.ajax({
			url: `${base_url}index.php/Servicio/obtener_subtipos_garantia/${sucursal}`,
			type: 'POST',
			dataType: 'json',
			data: {fecha_ini: fecha_ini, fecha_fin: fecha_fin},
		})
		.done(function(resp) {
			if (resp.estatus) {
				$.each(resp.subtipos, function(index, val) {
					acciones = '';
					acciones  +=`<button class='btn btn-sm editarSubtipo' style='min-width: 140px; max-width: 140px; min-height: 50px; max-height: 50px; background:#17A2B8;' id='editarSubtipo-${val.id}'><i class='fa fa-edit'></i>&nbspEditar Subtipo</button>`;
					acciones  +=`<button class='btn btn-sm estatusSubtipo' style='min-width: 140px; max-width: 140px; min-height: 50px; max-height: 50px; background:red;' data-estatus='${val.eliminado}' id='estatusSubtipo-${val.id}'><i class='fa fa-${val.eliminado == 1 ? 'check' : 'times'}'></i>&nbsp${val.eliminado == 1 ? 'Activar' : 'Desactivar'} Subtipo</button>`;
					tabla_subtipos.fnAddData([
						val.id,
						val.nombre,
						val.descripcion,
						new Date(val.fecha_creacion).toLocaleString('en-GB', {timezone: 'UTC'}).replace(',',''),
						val.fecha_actualizacion ? new Date(val.fecha_actualizacion).toLocaleString('en-GB', {timezone: 'UTC'}).replace(',','') : '',
						val.eliminado == 0 ? 'Activo' : 'Inactivo',
						val.fecha_eliminacion ? new Date(val.fecha_eliminacion).toLocaleString('en-GB', {timezone: 'UTC'}).replace(',','') : '',
						val.usuario,
						acciones
					]);
				});
				//toastr.info(resp.mensaje);
			}else {
				toastr.warning(resp.mensaje);
			}
		})
		.fail(function(error) {
			toastr.error('Ocurrió un erro al obtener los subtipos de garantía.');
			console.log("error", error);
		})
		.always(function() {
			$('#loading_spin').hide();
		});
	});
	$(document).off('click', '.estatusSubtipo').on('click', '.estatusSubtipo', function(event) {
		event.preventDefault();
		id = $(this).prop('id').split('-')[1];
		estatus = $(this).data('estatus');
		console.log('id', id);
		console.log('estatus', estatus);
		swal({
			title: `¿${estatus == 0 ? 'Desactivar' : 'Activar'}?`,
			showCancelButton: true,
			confirmButtonText: `${estatus == 0 ? 'Desactivar' : 'Activar'}`,
			cancelButtonText: 'Cancelar',
			type: 'info'
			}).then((result) => {
				if (result.value) {
					$('#loading_spin').show();
					$.ajax({
						url: `${base_url}index.php/Servicio/estatus_subtipos_garantia/${sucursal}/${id}`,
						type: 'POST',
						dataType: 'json',
						data: {eliminado: estatus == 0 ? 1 : 0},
					})
					.done(function(resp) {
						if (resp.estatus) {
							toastr.info(resp.mensaje);
							$('#btn_mostrarSub').trigger('click');
						}else {
							toastr.warning(resp.mensaje);
						}
					})
					.fail(function(error) {
						toastr.error('Ocurrió un erro al obtener los subtipos de garantía.');
						console.log("error", error);
					})
					.always(function() {
						$('#loading_spin').hide();
					});
				} else if (result.dismiss) {
					toastr.info('Operación cancelada.');
				}
		});
	});

	$(document).off('click', '#btn_nuevoSubtipo').on('click', '#btn_nuevoSubtipo', function(event) {
		$('#nombreSubtipo').val();
		$('#descripcionSubtipo').text();
		$('#btn_actualizarSubtipo').hide();
		$('#btn_crearSubtipo').show();
		$('#subtipoModalLabel').text('Añadir Subtipo de Garantía');
		$('#subtipoModal').modal('toggle');
	});
	$(document).off('click', '.editarSubtipo').on('click', '.editarSubtipo', function(event) {
		event.preventDefault();
		id = $(this).prop('id').split('-')[1];
		console.log('id', id);
		$('#loading_spin').show();
		$.ajax({
			url: `${base_url}index.php/Servicio/obtener_subtipo_garantia/${sucursal}/${id}`,
			type: 'POST',
			dataType: 'json',
			data: {},
		})
		.done(function(resp) {
			if (resp.estatus) {
				$('#nombreSubtipo').val(resp.subtipo.nombre);
				$('#descripcionSubtipo').text(resp.subtipo.descripcion);
				$('#btn_actualizarSubtipo').show();
				$('#btn_crearSubtipo').hide();
				$('#btn_actualizarSubtipo').data('id', id);
				$('#subtipoModalLabel').text('Editar Subtipo de Garantía');
				$('#subtipoModal').modal('toggle');
			}else {
				toastr.warning(resp.mensaje);
			}
		})
		.fail(function(error) {
			toastr.error('Ocurrió un erro al obtener el subtipo de garantía.');
			console.log("error", error);
		})
		.always(function() {
			$('#loading_spin').hide();
		});
	});
	$(document).off('click', '#btn_crearSubtipo').on('click', '#btn_crearSubtipo', function(event) {
		event.preventDefault();
		const form = new FormData($('#form_subtipo')[0]);
		$('#loading_spin').show();
		$.ajax({
			url: `${base_url}index.php/Servicio/guardar_subtipos_garantia/${sucursal}`,
			type: 'POST',
			dataType: 'json',
			contentType: false,
			processData: false,
			data: form,
		})
		.done(function(resp) {
			if (resp.estatus) {
				toastr.info(resp.mensaje);
				$('#nombreSubtipo').val('');
				$('#descripcionSubtipo').val('');
				$('#subtipoModal').modal('toggle');
				$('#btn_mostrarSub').trigger('click');
			}else {
				toastr.warning(resp.mensaje);
			}
		})
		.fail(function(error) {
			toastr.error('Ocurrió un erro al editar el subtipo de garantía.');
			console.log("error", error);
		})
		.always(function() {
			$('#loading_spin').hide();
		});
	});
	$(document).off('click', '#btn_actualizarSubtipo').on('click', '#btn_actualizarSubtipo', function(event) {
		event.preventDefault();
		id = $(this).data('id');
		$('#loading_spin').show();
		console.log('id', id);
		const form = new FormData($('#form_subtipo')[0]);
		$.ajax({
			url: `${base_url}index.php/Servicio/editar_subtipos_garantia/${sucursal}/${id}`,
			type: 'POST',
			dataType: 'json',
			contentType: false,
			processData: false,
			data: form,
		})
		.done(function(resp) {
			if (resp.estatus) {
				toastr.info(resp.mensaje);
				$('#nombreSubtipo').val('');
				$('#descripcionSubtipo').val('');
				$('#subtipoModal').modal('toggle');
				$('#btn_mostrarSub').trigger('click');
			}else {
				toastr.warning(resp.mensaje);
			}
		})
		.fail(function(error) {
			toastr.error('Ocurrió un erro al editar el subtipo de garantía.');
			console.log("error", error);
		})
		.always(function() {
			$('#loading_spin').hide();
		});
	});
	$('#btn_mostrarSub').trigger('click');
});
