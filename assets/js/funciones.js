function llenarSucursales( sucursales, sucursalAct )
{
	// llenar select de sucursales
	var opciones = $( 'select#sucursal' ).children().first();
	
	opciones.empty(); // vaciar opciones ????¿¿¿¿¿
	
	$.each( sucursales, function ( index, sucursal )
	{
		opciones.append( '<option value="'+ sucursal.id + '">' + sucursal.Nombre + '</option>' );
	});
	
	// poner texto y valor de que sucursal se esta mostrando
	if ( $( 'span.ui-selectmenu-text' ).text().length === 1 )
		$( 'span.ui-selectmenu-text' ).text( opciones.children( '[value=' + sucursalAct + ']' ).text() );

	$( 'select#sucursal' ).val( sucursalAct );
}

function ponerAgentes( agentes )
{
	// agentes y sus claves
	$.each( agentes, function ( index, agente ) {
		var nombreAgente = '';

		nombreAgente += ( agente.PersonalNombres == null )? '' : agente.PersonalNombres;
		nombreAgente += ' ';
		nombreAgente += ( agente.PersonalApellidoPaterno == null )? '' : agente.PersonalApellidoPaterno;

		jornadaLunes.Sections.push({
			id: agente.Agente + '-E',
			// datos para mostrar relacionados con el mecanico, horas trabajadas, horas estimadas
			name: "<u class='mecanico' data-mecanico='" + agente.Agente + "'>" + agente.Agente + " - " + nombreAgente + "</u>"
		});

		jornadaLunes.Sections.push({
			id: agente.Agente + '-R',
			name: agente.Agente + ' - ' + nombreAgente
		});        
	});
}

function ponerCitasServicio( citasServicio, entrada )
{
	var texto, inicio, fin, entrada;

	// actividades de agentes por semana
	$.each( citasServicio, function ( index, actividad, salida ) {
		texto = '<div class="cita citaEst row textoActividad" data-toggle="tooltip" title="' + actividad.MovID + '">' +
					'<div class="pull-left">CS - ' + actividad.MovID + ' -- ' + actividad.ClaveAsesor +' -- PL - '+ actividad.ServicioPlacas + '</div>' +
					'<div class="pull-right">CS - ' + actividad.MovID + ' -- ' + actividad.ClaveAsesor + '</div>' +
				'</div>';
		
		inicio = moment( actividad.FechaIn );
		fin = moment( actividad.FechaFn );
		difEntrada = fin.hour() - entrada;
		difSalida = salida - inicio.hour();

		if ( fin.diff( inicio, 'hours' ) < 3 || difSalida < 3 || difEntrada < 3 )
			texto = '<div class="cita citaEst textoActividad" style="margin-left: 5px;" data-toggle="tooltip" title="' + actividad.MovID + '">' +
						'CS - ' + actividad.MovID + ' -- ' + actividad.ClaveAsesor +' -- PL - ' + actividad.ServicioPlacas +
					'</div>';

		if ( fin.diff( inicio, 'hours' ) > 5 && difSalida > 5 && difEntrada > 5 )
			texto = '<div class="servicio servicioEst row textoActividad" data-toggle="tooltip" title="' + actividad.MovID + '">' +
						'<div class="pull-left">OS - ' + actividad.MovID + ' -- ' + actividad.ClaveAsesor + ' -- PL - ' + actividad.ServicioPlacas + '</div>' +
						'<div class="pull-right">PL - '+ actividad.ServicioPlacas + ' -- OS - ' + actividad.MovID + ' -- ' + actividad.ClaveAsesor + '</div>' +
					'</div>';					

		jornadaLunes.Items.push({
			// id: 20,
			name: texto,
			sectionID: actividad.Agente + '-E',
			start: inicio,
			fechaFin: fin, // real, el que se muestra en modal
			fechaIni: inicio,
			end: moment( actividad.FechaFn ).subtract( 5, 'seconds' ), // para pintarlo se le quitan 5 seg, para poder crear act. seguidas
			classes: 'colorCitaEst no-visible',
			estatus: actividad.Estatus,
			situacion: actividad.Situacion,
			mov: actividad.Mov,
			movId: actividad.MovID,
			nombreAsesor: actividad.nombreAsesor,
			apPaternoAsesor: actividad.apPaternoAsesor,
			apMaternoAsesor: actividad.apMaternoAsesor,
			claveAsesor: actividad.ClaveAsesor,
			nomCte: actividad.CteNombre,
			ladaCte: actividad.CteLada,
			telCte: actividad.CteTel,
			emailCte: actividad.CteCorreo,
			tipoOrden: actividad.ServicioTipoOrden,
			tipoOperacion: actividad.ServicioTipoOperacion,
			torre: actividad.ColorTorre,
			noTorre: actividad.Torre,
			hrLlegada: moment( actividad.HoraLlegada ).format( 'dddd D MMMM, HH:mm:ss' ),
			hrPromesa: moment( actividad.HoraPromesa ).format( 'dddd D MMMM, HH:mm:ss' ),
			serie: actividad.VIN,
			cveModelo: actividad.ClaveModelo,
			modelo: actividad.Modelo,
			anioModelo: actividad.AnoModelo,
			placas : actividad.ServicioPlacas,
			Comentarios: actividad.Comentarios,
            Observaciones: actividad.Observaciones
		});
	});
}

function ponerOrdenesServicio( ordenesServicio, entrada, salida )
{
	var texto, inicio, fin, difEntrada;

	$.each( ordenesServicio, function ( index, actividad )
	{
		texto = '<div class="servicio servicioEst row textoActividad" data-toggle="tooltip" title="' + actividad.MovID + '">' +
					'<div class="pull-left">OS - ' + actividad.MovID + ' -- ' + actividad.ClaveAsesor + ' -- PL - ' + actividad.ServicioPlacas + '</div>' +
					'<div class="pull-right">OS - ' + actividad.MovID + ' -- ' + actividad.ClaveAsesor + '</div>' +
				'</div>';

		inicio = moment( actividad.FechaIn );
		fin = moment( actividad.FechaFn );
		difEntrada = fin.hour() - entrada;
		difSalida = salida - inicio.hour();

		if ( fin.diff( inicio, 'hours' ) < 3 || difSalida < 3 || difEntrada < 3 )
			texto = '<div class="servicio servicioEst textoActividad" style="margin-left: 5px;" data-toggle="tooltip" title="' + actividad.MovID + '">' +
						'OS - ' + actividad.MovID + ' -- ' + actividad.ClaveAsesor+ ' -- PL - ' + actividad.ServicioPlacas
					'</div>';	

		if ( fin.diff( inicio, 'hours' ) > 5 && difSalida > 5 && difEntrada > 5 )
			texto = '<div class="servicio servicioEst row textoActividad" data-toggle="tooltip" title="' + actividad.MovID + '">' +
						'<div class="pull-left">OS - ' + actividad.MovID + ' -- ' + actividad.ClaveAsesor + ' -- PL - ' + actividad.ServicioPlacas + '</div>' +
						'<div class="pull-right">PL - '+ actividad.ServicioPlacas + ' -- OS - ' + actividad.MovID + ' -- ' + actividad.ClaveAsesor + '</div>' +
					'</div>';
							

		jornadaLunes.Items.push( {
			// id: 20,
			name: texto,
			sectionID: actividad.Agente + '-E',
			start: inicio,
			fechaFin: fin, // real, el que se muestra en modal
			fechaIni: inicio,
			end: moment( actividad.FechaFn ).subtract( 5, 'seconds' ), // para pintarlo se le quitan 5 seg, para poder crear act. seguidas
			classes: 'colorServEst no-visible ' + actividad.EstadoColor,
			estatus: actividad.Estatus,
			situacion: actividad.Situacion,
			mov: 'Orden ' + actividad.Mov,
			movId: actividad.MovID,
			nombreAsesor: actividad.nombreAsesor,
			apPaternoAsesor: actividad.apPaternoAsesor,
			apMaternoAsesor: actividad.apMaternoAsesor,
			claveAsesor: actividad.ClaveAsesor,
			nomCte: actividad.CteNombre,
			ladaCte: actividad.CteLada,
			telCte: actividad.CteTel,
			emailCte: actividad.CteCorreo,
			tipoOrden: actividad.ServicioTipoOrden,
			tipoOperacion: actividad.ServicioTipoOperacion,
			torre: actividad.ColorTorre,
			noTorre: actividad.Torre,
			hrLlegada: moment( actividad.HoraLlegada ).format( 'dddd D MMMM, HH:mm:ss' ),
			hrPromesa: moment( actividad.HoraPromesa ).format( 'dddd D MMMM, HH:mm:ss' ),
			serie: actividad.VIN,
			cveModelo: actividad.ClaveModelo,
			modelo: actividad.Modelo,
			anioModelo: actividad.AnoModelo,
			placas : actividad.ServicioPlacas,
			Comentarios: actividad.Comentarios,
            Observaciones: actividad.Observaciones
		});
	});
}

function ponerOperacionesReal( ordenes )
{
	var texto, inicio, fin, rangoEstimado;

	$.each( ordenes, function ( index, orden ) { // index => MovID
		$.each( orden, function ( index2, opReal ) {
			texto = '<div class="servicio operacionReal row textoActividad" data-toggle="tooltip" title="' + opReal.MovID + '">' +
						'<div class="pull-left">OS - ' + opReal.MovID + ' -- ' + opReal.ClaveAsesor + '</div>' +
						'<div class="pull-right">OS - ' + opReal.MovID + ' -- ' + opReal.ClaveAsesor + '</div>' +
					'</div>';
			inicioR = moment( opReal.InicioReal );
			finR = moment( opReal.FinReal );

			inicioE = moment( opReal.IniEstimado );
			finE = moment( opReal.FinEstimado );

			rangoEstimado = moment().range( inicioE, finE );

			// variables en caso de que no pase de lo estimado, se quedan igual
			var inicioPintar = inicioR;
			var clase = 'colorOperacion real real-inicio real-fin';

			var horaSistema = moment();
			var y = moment.max( finE, horaSistema );
			var quinceMinAntesEstimado = moment( opReal.FinEstimado ).subtract( 15, 'minutes' );
			var x = moment.max( quinceMinAntesEstimado, horaSistema );
			// si no esta completada y a un no se pasa de lo estimado y ya son los 15 min antes estimado
			
			//Agregar variable descrip, la descripción del modal será Descripción Extra(Descripción) si existe o en su defecto MODescripción
			var descrip;
			if ( opReal.Descripcion != '' && opReal.Descripcion != null )	
				descrip = opReal.Descripcion;
			else	
				descrip = opReal.MODescripcion;

			if ( opReal.EstadoActualOper != 'Completada' && y == finE && x == horaSistema )
			{
				// como no esta completada, se pinta hasta la --horaSistema (opReal.FinReal)--
					// si inicia antes de 15min y termina dentro de los 15min
				if ( moment.max( quinceMinAntesEstimado, inicioR ) == quinceMinAntesEstimado && quinceMinAntesEstimado != inicioR )
				{
					// se pinta color normal hasta 15 min antes
					jornadaLunes.Items.push({
						movId: opReal.MovID,
						opReal: true,
						name: texto,
						sectionID: opReal.Mecanico + '-R',
						start: moment( opReal.InicioReal ), //**
						end: moment( opReal.FinEstimado ).subtract( 15, 'minutes' ).subtract( 5, 'seconds' ), //**
						fechaIni: moment( opReal.InicioReal ),
						fechaFin: moment( opReal.FinReal ),
						classes: 'real real-inicio colorOperacion no-visible', //**
						inicioEst: inicioE.format( 'dddd D MMMM, HH:mm:ss' ),
						finEst: finE.format( 'dddd D MMMM, HH:mm:ss' ),
						descripcion: descrip,
						cveOp: opReal.ClaveOperacion,
						duracionEst: opReal.DEstimado.toFixed( 2 ),
						duracionReal: opReal.DReal.toFixed( 2 ),
						duracionTrabajado: opReal.DTrabajado.toFixed( 2 ),
						claveAsesor: opReal.ClaveAsesor
					});
					// y despues amarillo hasta horaSistema
					jornadaLunes.Items.push({
						movId: opReal.MovID,
						opReal: true,
						name: texto,
						sectionID: opReal.Mecanico + '-R',
						start: moment( opReal.FinEstimado ).subtract( 15, 'minutes' ), //**
						end: moment( opReal.FinReal ).subtract( 5, 'seconds' ), //**
						fechaIni: moment( opReal.InicioReal ),
						fechaFin: moment( opReal.FinReal ),
						classes: 'real real-fin amarillo no-visible', //**
						inicioEst: inicioE.format( 'dddd D MMMM, HH:mm:ss' ),
						finEst: finE.format( 'dddd D MMMM, HH:mm:ss' ),
						descripcion: descrip,
						cveOp: opReal.ClaveOperacion,
						duracionEst: opReal.DEstimado.toFixed( 2 ),
						duracionReal: opReal.DReal.toFixed( 2 ),
						duracionTrabajado: opReal.DTrabajado.toFixed( 2 ),
						claveAsesor: opReal.ClaveAsesor
					});
				}
				else
					// si inicia y termina dentro los 15min
					jornadaLunes.Items.push({
						movId: opReal.MovID,
						opReal: true,
						name: texto,
						sectionID: opReal.Mecanico + '-R',
						start: moment( opReal.InicioReal ), //**
						end: moment( opReal.FinReal ).subtract( 5, 'seconds' ), //**
						fechaIni: moment( opReal.InicioReal ),
						fechaFin: moment( opReal.FinReal ),
						classes: 'real real-inicio real-fin amarillo no-visible', //**
						inicioEst: inicioE.format( 'dddd D MMMM, HH:mm:ss' ),
						finEst: finE.format( 'dddd D MMMM, HH:mm:ss' ),
						descripcion: descrip,
						cveOp: opReal.ClaveOperacion,
						duracionEst: opReal.DEstimado.toFixed( 2 ),
						duracionReal: opReal.DReal.toFixed( 2 ),
						duracionTrabajado: opReal.DTrabajado.toFixed( 2 ),
						claveAsesor: opReal.ClaveAsesor
					});
			}
			else
			{
				// si termino despues de lo estimado
				if ( finR.diff( finE ) > 0 )
				{
					// si inicio despues de lo estimado, se pinta toda la actividad roja
					if ( ! rangoEstimado.contains( inicioR ) && moment.max( finE, inicioR ) == inicioR )
						clase = 'tRetraso real real-inicio real-fin';
					// si inicio dentro de lo estimado
					else
					{
						// primero la parte que no se paso de lo estimado
						jornadaLunes.Items.push({
							// id: 20,
							movId: opReal.MovID,
							opReal: true,
							name: texto,
							sectionID: opReal.Mecanico + '-R',
							start: moment( opReal.InicioReal ), //**
							end: moment( opReal.FinEstimado ).subtract( 5, 'seconds' ), //**
							fechaFin: finR,
							fechaIni: moment( opReal.InicioReal ),
							classes: 'colorOperacion real real-inicio no-visible', //**
							inicioEst: inicioE.format( 'dddd D MMMM, HH:mm:ss' ),
							finEst: finE.format( 'dddd D MMMM, HH:mm:ss' ),
							descripcion: descrip,
							cveOp: opReal.ClaveOperacion,
							duracionEst: opReal.DEstimado.toFixed( 2 ),
							duracionReal: opReal.DReal.toFixed( 2 ),
							duracionTrabajado: opReal.DTrabajado.toFixed( 2 ),
							claveAsesor: opReal.ClaveAsesor
						});

						// despues se asignan variables para la parte que se paso de lo estimado
						inicioPintar = finE;
						clase = 'tRetraso real real-fin';
					}
				}

				jornadaLunes.Items.push({
					// id: 20,
					movId: opReal.MovID,
					opReal: true,
					name: texto,
					sectionID: opReal.Mecanico + '-R',
					start: inicioPintar, //**
					end: moment( opReal.FinReal ).subtract( 5, 'seconds' ), //**
					fechaFin: moment( opReal.FinReal ),
					fechaIni: moment( opReal.InicioReal ),
					classes: clase + ' no-visible', //**
					inicioEst: inicioE.format( 'dddd D MMMM, HH:mm:ss' ),
					finEst: finE.format( 'dddd D MMMM, HH:mm:ss' ),
					descripcion: descrip,
					cveOp: opReal.ClaveOperacion,
					duracionEst: opReal.DEstimado.toFixed( 2 ),
					duracionReal: opReal.DReal.toFixed( 2 ),
					duracionTrabajado: opReal.DTrabajado.toFixed( 2 ),
					claveAsesor: opReal.ClaveAsesor
				});
			}
		});
	});
}

function ponerOperacionesRealHist( operaciones )
{
	var texto, inicio, fin, rangoEstimado;

	$.each( operaciones, function ( index, operacion ) {
		$.each( operacion, function ( index2, estatus ) {
			inicioR = moment( estatus.InicioReal );
			finR = moment( estatus.FinReal );

			if ( inicioR.format( 'dddd D MMMM, HH:mm' ) == finR.format( 'dddd D MMMM, HH:mm' ) || estatus.color == 'Completada' )
				return true;
			// redondear la parte antes de completada

			texto = '<div class="servicio operacionRealH row textoActividad" data-toggle="tooltip" title="' + estatus.MovID + '">' +
						'<div class="pull-left">OS - ' + estatus.MovID + ' -- ' + estatus.ClaveAsesor + '</div>' +
						'<div class="pull-right">OS - ' + estatus.MovID + ' -- ' + estatus.ClaveAsesor + '</div>' +
					'</div>';

			inicioE = moment( estatus.IniEstimado );
			finE = moment( estatus.FinEstimado );

			rangoEstimado = moment().range( inicioE, finE );

			// variables en caso de que no pase de lo estimado, se quedan igual
			var inicioPintar = inicioR;
			var clase = 'real';

			// primera y ultima iteracion, para aplicar border-radius
			if ( index2 === 0 ) clase += ' real-inicio';

			var horaSistema = moment();
			var y = moment.max( finE, horaSistema );
			var quinceMinAntesEstimado = moment( estatus.FinEstimado ).subtract( 15, 'minutes' );
			var x = moment.max( quinceMinAntesEstimado, horaSistema );
			
			var descrip;
			if( estatus.Descripcion != '' && estatus.Descripcion != null )
				descrip = estatus.Descripcion;
			else	
				descrip = estatus.MODescripcion;

			// si no esta completada y a un no se pasa de lo estimado y ya son los 15 min antes estimado
			if ( estatus.EstadoActualOper != 'Completada' && y == finE && x == horaSistema )
			{
				// como no esta completada, se pinta hasta la --horaSistema (estatus.FinReal)--
					// si inicia antes de 15min y termina dentro de los 15min
				if ( moment.max( quinceMinAntesEstimado, inicioR ) == quinceMinAntesEstimado && quinceMinAntesEstimado != inicioR )
				{
					// se pinta color normal hasta 15 min antes
					jornadaLunes.Items.push({
						movId: estatus.MovID,
						opReal: true,
						name: texto,
						sectionID: estatus.Mecanico + '-R',
						start: moment( estatus.InicioReal ), //**
						end: moment( estatus.FinEstimado ).subtract( 15, 'minutes' ).subtract( 5, 'seconds' ), //**
						fechaFin: moment( estatus.FinReal ),
						fechaIni: moment( estatus.InicioReal ),
						classes: 'real real-inicio no-visible ' + estatus.color.replace( / /g, '' ), //**
						inicioEst: inicioE.format( 'dddd D MMMM, HH:mm:ss' ),
						finEst: finE.format( 'dddd D MMMM, HH:mm:ss' ),
						descripcion: descrip,
						cveOp: estatus.ClaveOperacion,
						duracionEst: estatus.DEstimado.toFixed( 2 ),
						duracionReal: estatus.DReal.toFixed( 2 ),
						duracionTrabajado: estatus.DTrabajado.toFixed( 2 ),
						estado: estatus.EstadoSeg,
						comentarios: estatus.Comentarios,
						claveAsesor: estatus.ClaveAsesor
					});
					// y despues amarillo hasta horaSistema
					jornadaLunes.Items.push({
						movId: estatus.MovID,
						opReal: true,
						name: texto,
						sectionID: estatus.Mecanico + '-R',
						start: moment( estatus.FinEstimado ).subtract( 15, 'minutes' ), //**
						end: moment( estatus.FinReal ).subtract( 5, 'seconds' ), //**
						fechaFin: moment( estatus.FinReal ),
						fechaIni: moment( estatus.InicioReal ),
						classes: 'real real-fin amarillo no-visible', //**
						inicioEst: inicioE.format( 'dddd D MMMM, HH:mm:ss' ),
						finEst: finE.format( 'dddd D MMMM, HH:mm:ss' ),
						descripcion: descrip,
						cveOp: estatus.ClaveOperacion,
						duracionEst: estatus.DEstimado.toFixed( 2 ),
						duracionReal: estatus.DReal.toFixed( 2 ),
						duracionTrabajado: estatus.DTrabajado.toFixed( 2 ),
						estado: estatus.EstadoSeg,
						comentarios: estatus.Comentarios,
						claveAsesor: estatus.ClaveAsesor
					});
				}
				else
					// si inicia y termina dentro los 15min
					jornadaLunes.Items.push({
						movId: estatus.MovID,
						opReal: true,
						name: texto,
						sectionID: estatus.Mecanico + '-R',
						start: moment( estatus.InicioReal ), //**
						end: moment( estatus.FinReal ).subtract( 5, 'seconds' ), //**
						fechaFin: moment( estatus.FinReal ),
						fechaIni: moment( estatus.InicioReal ),
						classes: 'real real-fin amarillo no-visible', //**
						inicioEst: inicioE.format( 'dddd D MMMM, HH:mm:ss' ),
						finEst: finE.format( 'dddd D MMMM, HH:mm:ss' ),
						descripcion: descrip,
						cveOp: estatus.ClaveOperacion,
						duracionEst: estatus.DEstimado.toFixed( 2 ),
						duracionReal: estatus.DReal.toFixed( 2 ),
						duracionTrabajado: estatus.DTrabajado.toFixed( 2 ),
						estado: estatus.EstadoSeg,
						comentarios: estatus.Comentarios,
						claveAsesor: estatus.ClaveAsesor
					});
			}
			else
			{
				// si termino despues de lo estimado
				if ( finR.diff( finE ) > 0 )
				{
					// si inicio despues de lo estimado, se pinta toda el estatus rojo
					if ( ! rangoEstimado.contains( inicioR ) && moment.max( finE, inicioR ) == inicioR )
						clase += ' tRetraso';
					// si inicio dentro de lo estimado
					else
					{
						// primero la parte que no se paso de lo estimado
						jornadaLunes.Items.push({
							// id: 20,
							movId: estatus.MovID,
							opReal: true,
							name: texto,
							sectionID: estatus.Mecanico + '-R',
							start: moment( estatus.InicioReal ), //**
							end: moment( estatus.FinEstimado ).subtract( 5, 'seconds' ), //**
							fechaFin: finR,
							fechaIni: moment( estatus.InicioReal ),
							classes: clase + ' ' + estatus.color.replace( / /g, '' ) + ' no-visible', //**
							inicioEst: inicioE.format( 'dddd D MMMM, HH:mm:ss' ),
							finEst: finE.format( 'dddd D MMMM, HH:mm:ss' ),
							descripcion: descrip,
							cveOp: estatus.ClaveOperacion,
							duracionEst: estatus.DEstimado.toFixed( 2 ),
							duracionReal: estatus.DReal.toFixed( 2 ),
							duracionTrabajado: estatus.DTrabajado.toFixed( 2 ),
							estado: estatus.EstadoSeg,
							comentarios: estatus.Comentarios,
							claveAsesor: estatus.ClaveAsesor
						});

						// despues se asignan variables para la parte que se paso de lo estimado
						inicioPintar = finE;
						clase = 'real tRetraso';
					}

					estatus.color = '';
				}

				if ( ( index2 + 1 ) === operacion.length ) clase += ' real-fin';

				jornadaLunes.Items.push({
					// id: 20,
					movId: estatus.MovID,
					opReal: true,
					name: texto,
					sectionID: estatus.Mecanico + '-R',
					start: inicioPintar, //**
					end: moment( estatus.FinReal ).subtract( 5, 'seconds' ), //**
					fechaFin: moment( estatus.FinReal ),
					fechaIni: inicioPintar,
					classes: clase + ' ' + estatus.color.replace( / /g, '' ) + ' no-visible', //**
					inicioEst: inicioE.format( 'dddd D MMMM, HH:mm:ss' ),
					finEst: finE.format( 'dddd D MMMM, HH:mm:ss' ),
					descripcion: descrip,
					cveOp: estatus.ClaveOperacion,
					duracionEst: estatus.DEstimado.toFixed( 2 ),
					duracionReal: estatus.DReal.toFixed( 2 ),
					duracionTrabajado: estatus.DTrabajado.toFixed( 2 ),
					estado: estatus.EstadoSeg,
					comentarios: estatus.Comentarios,
					claveAsesor: estatus.ClaveAsesor
				});
			}
		});
	});
}

function ponerOrdenesReal( ordenes )
{
	$.each( ordenes, function ( index, orden ) {
		texto = '<div class="servicio ordenReal row textoActividad" data-toggle="tooltip" title="' + orden.MovID + '">' +
					'<div class="pull-left">OS - ' + orden.MovID + '</div>' +
					'<div class="pull-right">OS - ' + orden.MovID + '</div>' +
				'</div>';
		inicioR = moment( orden.InicioReal );
		finR = moment( orden.FinReal );

		inicioE = moment( orden.IniEstimado );
		finE = moment( orden.FinEstimado );

		rangoEstimado = moment().range( inicioE, finE );

		// variables en caso de que no pase de lo estimado, se quedan igual
		var inicioPintar = inicioR;
		var clase = 'colorOrden real real-inicio real-fin';

		// si termino despues de lo estimado
		if ( finR.diff( finE ) > 0 )
		{
			// si inicio despues de lo estimado, se pinta toda la actividad roja
			if ( ! rangoEstimado.contains( inicioR ) && moment.max( finE, inicioR ) == inicioR )
				clase = 'tRetraso real real-inicio real-fin';
			// si inicio dentro de lo estimado
			else
			{
				// primero la parte que no se paso de lo estimado
				jornadaLunes.Items.push({
					// id: 20,
					name: texto,
					sectionID: orden.Mecanico + '-R',
					start: moment( orden.InicioReal ),
					end: moment( orden.FinEstimado ).subtract( 5, 'seconds' ),
					fechaIni: moment( orden.InicioReal ),
					fechaFin: finR,
					classes: 'colorOrden real real-inicio no-visible',
					estatus: orden.Estatus,
					situacion: orden.Situacion,
					mov: 'Orden ' + orden.Mov,
					movId: orden.MovID,
					nombreAsesor: orden.PersonalNombres,
					apPaternoAsesor: orden.PersonalApellidoPaterno,
					apMaternoAsesor: orden.PersonalApellidoMaterno,
					claveAsesor: orden.ClaveAsesor,
					nomCte: orden.CteNombre,
					ladaCte: orden.CteLada,
					telCte: orden.CteTel,
					emailCte: orden.CteCorreo,
					tipoOrden: orden.ServicioTipoOrden,
					tipoOperacion: orden.ServicioTipoOperacion,
					torre: orden.ColorTorre,
					noTorre: orden.Torre,
					hrLlegada: moment( orden.HoraLlegada ).format( 'dddd D MMMM, HH:mm:ss' ),
					hrPromesa: moment( orden.HoraPromesa ).format( 'dddd D MMMM, HH:mm:ss' ),
					serie: orden.VIN,
					cveModelo: orden.ClaveModelo,
					modelo: orden.Modelo,
					anioModelo: orden.AnoModelo
				});

				// despues se asignan variables para la parte que se paso de lo estimado
				inicioPintar = finE;
				clase = 'tRetraso real real-fin';
			}
		}

		jornadaLunes.Items.push({
			// id: 20,
			name: texto,
			sectionID: orden.Mecanico + '-R',
			start: inicioPintar,
			end: moment( orden.FinReal ).subtract( 5, 'seconds' ),
			fechaIni: moment( orden.InicioReal ),
			fechaFin: finR,
			classes: clase + ' no-visible',
			estatus: orden.Estatus,
			situacion: orden.Situacion,
			mov: 'Orden ' + orden.Mov,
			movId: orden.MovID,
			nombreAsesor: orden.PersonalNombres,
			apPaternoAsesor: orden.PersonalApellidoPaterno,
			apMaternoAsesor: orden.PersonalApellidoMaterno,
			claveAsesor: orden.ClaveAsesor,
			nomCte: orden.CteNombre,
			ladaCte: orden.CteLada,
			telCte: orden.CteTel,
			emailCte: orden.CteCorreo,
			tipoOrden: orden.ServicioTipoOrden,
			tipoOperacion: orden.ServicioTipoOperacion,
			torre: orden.ColorTorre,
			noTorre: orden.Torre,
			hrLlegada: moment( orden.HoraLlegada ).format( 'dddd D MMMM, HH:mm:ss' ),
			hrPromesa: moment( orden.HoraPromesa ).format( 'dddd D MMMM, HH:mm:ss' ),
			serie: orden.VIN,
			cveModelo: orden.ClaveModelo,
			modelo: orden.Modelo,
			anioModelo: orden.AnoModelo
		});
	});
}

function ponerOrdenesRealHist( ordenes )
{
	$.each( ordenes, function ( index, orden ) {
		$.each( orden, function ( index2, situacion ) {
			texto = '<div class="servicio ordenRealH row textoActividad" data-toggle="tooltip" title="' + situacion.MovID + '">' +
						'<div class="pull-left">OS - ' + situacion.MovID + '</div>' +
						'<div class="pull-right">OS - ' + situacion.MovID + '</div>' +
					'</div>';
			inicioR = moment( situacion.FechaIniSituacion );
			finR = moment( situacion.FechaFinSituacion );

			inicioE = moment( situacion.IniEstimado );
			finE = moment( situacion.FinEstimado );

			rangoEstimado = moment().range( inicioE, finE );

			// variables en caso de que no pase de lo estimado, se quedan igual
			var inicioPintar = inicioR;
			var clase = 'real';

			// primera y ultima iteracion, para aplicar border-radius
			if ( index2 === 0 ) clase += ' real-inicio';

			// si termino despues de lo estimado
			if ( finR.diff( finE ) > 0 )
			{
				// si inicio despues de lo estimado, se pinta toda la actividad roja
				if ( ! rangoEstimado.contains( inicioR ) && moment.max( finE, inicioR ) == inicioR )
					clase += ' tRetraso';
				// si inicio dentro de lo estimado
				else
				{
					// primero la parte que no se paso de lo estimado
					jornadaLunes.Items.push({
						// id: 20,
						name: texto,
						sectionID: situacion.Mecanico + '-R',
						start: moment( situacion.FechaIniSituacion ),
						end: moment( situacion.FinEstimado ).subtract( 5, 'seconds' ),
						fechaIni: moment( situacion.FechaIniSituacion ),
						fechaFin: finR,
						classes: clase + ' ' + situacion.color.replace( / /g, '' ) + ' no-visible',
						estatus: situacion.Estatus,
						situacion: situacion.SituacionHist,
						mov: 'Orden ' + situacion.Mov,
						movId: situacion.MovID,
						nombreAsesor: situacion.PersonalNombres,
						apPaternoAsesor: situacion.PersonalApellidoPaterno,
						apMaternoAsesor: situacion.PersonalApellidoMaterno,
						claveAsesor: situacion.ClaveAsesor,
						nomCte: situacion.CteNombre,
						ladaCte: situacion.CteLada,
						telCte: situacion.CteTel,
						emailCte: situacion.CteCorreo,
						tipoOrden: situacion.ServicioTipoOrden,
						tipoOperacion: situacion.ServicioTipoOperacion,
						torre: situacion.ColorTorre,
						noTorre: situacion.Torre,
						hrLlegada: moment( situacion.HoraLlegada ).format( 'dddd D MMMM, HH:mm:ss' ),
						hrPromesa: moment( situacion.HoraPromesa ).format( 'dddd D MMMM, HH:mm:ss' ),
						serie: situacion.VIN,
						cveModelo: situacion.ClaveModelo,
						modelo: situacion.Modelo,
						anioModelo: situacion.AnoModelo
					});

					// despues se asignan variables para la parte que se paso de lo estimado
					inicioPintar = finE;
					clase = 'real tRetraso';
				}

				situacion.color = '';
			}

			if ( ( index2 + 1 ) === orden.length ) clase += ' real-fin';

			jornadaLunes.Items.push({
				// id: 20,
				name: texto,
				sectionID: situacion.Mecanico + '-R',
				start: inicioPintar,
				end: moment( situacion.FechaFinSituacion ).subtract( 5, 'seconds' ),
				fechaIni: inicioPintar,
				fechaFin: finR,
				classes: clase + ' ' + situacion.color.replace( / /g, '' ) + ' no-visible',
				estatus: situacion.Estatus,
				situacion: situacion.SituacionHist,
				mov: 'Orden ' + situacion.Mov,
				movId: situacion.MovID,
				nombreAsesor: situacion.PersonalNombres,
				apPaternoAsesor: situacion.PersonalApellidoPaterno,
				apMaternoAsesor: situacion.PersonalApellidoMaterno,
				claveAsesor: situacion.ClaveAsesor,
				nomCte: situacion.CteNombre,
				ladaCte: situacion.CteLada,
				telCte: situacion.CteTel,
				emailCte: situacion.CteCorreo,
				tipoOrden: situacion.ServicioTipoOrden,
				tipoOperacion: situacion.ServicioTipoOperacion,
				torre: situacion.ColorTorre,
				noTorre: situacion.Torre,
				hrLlegada: moment( situacion.HoraLlegada ).format( 'dddd D MMMM, HH:mm:ss' ),
				hrPromesa: moment( situacion.HoraPromesa ).format( 'dddd D MMMM, HH:mm:ss' ),
				serie: situacion.VIN,
				cveModelo: situacion.ClaveModelo,
				modelo: situacion.Modelo,
				anioModelo: situacion.AnoModelo
			});
		});
	});
}

function ponerNoDisponibilidad( horarioDisponibilidad )
{
	var incidenciaRango, recesoRango, agente, permisoD, permisoA, salidaComida, entradaComida;

	$.each( horarioDisponibilidad, function ( index, noDisponible )  // considerar mas de un permiso por dia ???¿¿¿
	{
		agente = noDisponible.Agente;

		permisoD = moment( noDisponible.PermisoD );
		permisoA = moment( noDisponible.PermisoA );

		salidaComida = moment( noDisponible.SalidaComida );
		entradaComida = moment( noDisponible.EntradaComida );

		salidaL1 = moment( noDisponible.SalidaL1 );
		entradaL1 = moment( noDisponible.EntradaL1 );

		salidaL2 = moment( noDisponible.SalidaL2 );
		entradaL2 = moment( noDisponible.EntradaL2 );

		incidenciaRango = moment().range( permisoD, permisoA );
		recesoRango = moment().range( salidaComida, entradaComida );
		
		// si salida comida esta dentro de la incidencia
		if ( incidenciaRango.contains( salidaComida ) )
		{
			// si el receso esta completamente dentro de la incidencia, entrada comida
			if ( incidenciaRango.contains( entradaComida ) )
			{
				pushNoDisponible( agente, permisoD, permisoA );

				return;
			}
			// la incidencia toma un fragmento del receso, primero -incidencia- despues -receso-
			else
			{
				pushNoDisponible( agente, permisoD, entradaComida );

				return;
			}
		}
		// si tiene receso e incidencia el mismo dia, pero no se 'empalman' entre si, se pinta receso e incidencia
		else if ( ! incidenciaRango.contains( entradaComida ) )
		{
			pushNoDisponible( agente, salidaComida, entradaComida );

			pushNoDisponible( agente, permisoD, permisoA )

			pushNoDisponible( agente, salidaL1, entradaL1 )

			pushNoDisponible( agente, salidaL2, entradaL2 )

			return;
		}

		// la incidencia toma un fragmento del receso, primero -receso- despues -incidencia-
		if ( recesoRango.contains( permisoD ) && ! recesoRango.contains( permisoA ) )
		{
			pushNoDisponible( agente, salidaComida, permisoA )

			return;
		}
	});
}

function ponerFueraHorario( fueraHorario )
{
	$.each( fueraHorario, function ( index, noDisponible )
	{
		agente = noDisponible.agente;
		if ( noDisponible.entrada )
		{
			inicio = moment( noDisponible.entrada );
			fin = moment( noDisponible.inicia );
		} 		
		else
		{
			inicio = moment( noDisponible.termina );
			fin = moment( noDisponible.salida );
		}
			
		pushNoDisponible( agente, inicio, fin )
	});
}

function pushNoDisponible( agente, inicio, fin )
{
	jornadaLunes.Items.push( {
		name: '<center>No Disponible</center>',
		sectionID: agente + '-E',
		start: inicio,
		end: fin.subtract( 5, 'seconds' ),
		classes: 'tDescanso no-visible'
	});

	jornadaLunes.Items.push( {
		name: '<center>No Disponible</center>',
		sectionID: agente + '-R',
		start: inicio,
		end: fin,
		classes: 'tDescanso no-visible'
	});
}

function vaciarObjetos()
{
	jornadaLunes.Sections = [];
	jornadaLunes.Periods = [];
	jornadaLunes.Items = [];

	jornadaMartes.Sections = jornadaMiercoles.Sections = jornadaJueves.Sections =
	jornadaViernes.Sections = jornadaSabado.Sections = jornadaLunes.Sections;

	jornadaMartes.Periods = jornadaMiercoles.Periods = jornadaJueves.Periods =
	jornadaViernes.Periods = jornadaSabado.Periods = jornadaLunes.Periods;
	
	jornadaMartes.Items = jornadaMiercoles.Items = jornadaJueves.Items =
	jornadaViernes.Items = jornadaSabado.Items = jornadaLunes.Items;
}

function ponerTextoSemana( cntdr )
{
	var textoLunes, textoSabado, textoSemana;

	textoLunes = moment().add( cntdr, 'w' ).weekday( 1 ).startOf( 'd' );

	textoSabado = moment().add( cntdr, 'w' ).weekday( 6 ).startOf( 'd' );

	textoSemana = 'Semana del ' + textoLunes.format( 'dddd D MMMM' ) + ' al ' + textoSabado.format( 'dddd D MMMM' );

	$( 'center#textoSemana' ).text( textoSemana + ' ' + textoSabado.format( 'YYYY' ) );
}

// actualizar cada 60 segundos, se ejecuta evento click de btnActualizar
var intervaloActualizar = function() { $( 'button#btnActualizar' ).trigger( 'click' ) };
var intervalo = setInterval( intervaloActualizar, 120000 );

function reiniciarIntervalo()
{
	clearInterval( intervalo );
	intervalo = setInterval( intervaloActualizar, 120000 );
}

function aplicarColores( peticion, colores )
{
	// se aplica el color a tiempos estimados, permisos => siempre
	// 1 => cita estimado, 2 => servicio estimado, 3 => permisos
	var siempre = colores.siempre;

	$( '.colorCitaEst' ).css({
		'background-color': siempre[ 0 ].color,
		'border-color'    : siempre[ 0 ].color
	});

	$( '.colorServEst' ).css({
		'background-color': siempre[ 1 ].color,
		'border-color'    : siempre[ 1 ].color
	});

	$( '.colorServEst.Proceso > div.time-sch-item-start ').css({ 'border-right': '7px solid ' + siempre[ 3 ].color });
	$( '.colorServEst.Proceso > div.time-sch-item-end ').css({ 'border-left': '7px solid ' + siempre[ 3 ].color });

	$( '.colorServEst.Detenida > div.time-sch-item-start ').css({ 'border-right': '7px solid ' + siempre[ 4 ].color });
	$( '.colorServEst.Detenida > div.time-sch-item-end ').css({ 'border-left': '7px solid ' + siempre[ 4 ].color });

	$( '.colorServEst.Finalizada > div.time-sch-item-start ').css({ 'border-right': '7px solid ' + siempre[ 5 ].color });
	$( '.colorServEst.Finalizada > div.time-sch-item-end ').css({ 'border-left': '7px solid ' + siempre[ 5 ].color });

	$( '.tDescanso' ).css({
		'background-color': siempre[ 2 ].color,
		'border-color'    : siempre[ 2 ].color
	});

	if ( peticion != 'nada' )
	{
		$( '.tRetraso' ).css({
			'background-color': colores.tRetraso.color,
			'border-color'    : colores.tRetraso.color
		});

		$( '.amarillo' ).css({
			'background-color': siempre[ 6 ].color,
			'border-color'    : siempre[ 6 ].color
		});

		// en switch se aplica color de acuerdo a peticion
		switch ( peticion )
		{
			case 'ordenesReal':
				var ordenesReal = colores.ordenesReal;

				$( '.colorOrden' ).css({
					'background-color': ordenesReal.color,
					'border-color'    : ordenesReal.color
				});

				break;

			case 'operacionesReal':
				var operacionesReal = colores.operacionesReal;

				$( '.colorOperacion' ).css({
					'background-color': operacionesReal.color,
					'border-color'    : operacionesReal.color
				});

				break;

			case 'ordenesRealHist':
				$.each( colores.ordenesRealHist, function ( index, situacion ) {
					$( '.' + situacion.situacionSeg.replace( / /g, '' ) ).css({
						'background-color': situacion.color,
						'border-color'    : situacion.color
					});
				});

				break;

			case 'operacionesRealHist':
				$.each( colores.operacionesRealHist, function ( index, operacion ) {
					$( '.' + operacion.estadoSeg.replace( / /g, '' ) ).css({
						'background-color': operacion.color,
						'border-color'    : operacion.color
					});
				});
		}
	}

	// al final se remueve clase para ocultarlos mientras se cambia de color
	setTimeout( function() {
		$( '.no-visible' ).css({ 'font-weight': 'bold' }).removeClass( 'no-visible' );
	}, 100 );
}