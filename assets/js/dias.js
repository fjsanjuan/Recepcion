moment.locale( 'es' ); //// fechas en español
var today = moment().startOf('day');
var periodos = 
    [
        {
            Name: '1 day',
            Label: '1 day',
            TimeframePeriod: 15,
            TimeframeHeaders: 
                [
                    'dddd D MMMM',
                    'HH',
                    'mm'
                ]
        }
    ];

//------------Jornada Lunes---------------------------------//
var lunes;

var jornadaLunes = {
    Periods: [] ,

    Items: [{
            id: 20,
            name: '<div>Item 1</div><div>Sub Info</div>',
            sectionID: 1,
            start: moment(today).add('days', -1),
            end: moment(today).add('days', 3),
            classes: 'item-status-three',
            events: [
                {
                    label: 'one',
                    at: moment(today).add('hours', 6),
                    classes: 'item-event-one'
                },
                {
                    label: 'two',
                    at: moment(today).add('hours', 10),
                    classes: 'item-event-two'
                },
                {
                    label: 'three',
                    at: moment(today).add('hours', 11),
                    classes: 'item-event-three'
                }
            ]
        },],     // actividades
    Sections: [
        {
            id: 1,
            name: 'Section 1'
        },

    ], // trabajadores

    Init: function ( entrada, cntdr ) {
        lunes = moment().add( cntdr, 'w' ).weekday( 1 ).startOf( 'd' );

    // lunes.subtract( moment.duration(2, 'w') ); // solo de prueba semana anterior a la actual
        TimeScheduler.Options.GetSections = jornadaLunes.GetSections;
        TimeScheduler.Options.GetSchedule = jornadaLunes.GetSchedule;
        TimeScheduler.Options.Start = lunes.add( entrada, 'hours' );
        TimeScheduler.Options.Periods = jornadaLunes.Periods;
        TimeScheduler.Options.SelectedPeriod = '1 day';
        TimeScheduler.Options.Element = $( 'div#lunes' );

        TimeScheduler.Options.Events.ItemClicked = jornadaLunes.Item_Clicked;

        TimeScheduler.Init();
    },

    GetSections: function ( callback ) {
        callback(jornadaLunes.Sections);
    },

    GetSchedule: function ( callback, start, end ) {
        callback(jornadaLunes.Items);
    },

    Item_Clicked: function() {}  
};
//------------Termina Jornada Lunes---------------------------------//

//------------Jornada Martes---------------------------------//
var martes;

var jornadaMartes = {
    Periods: [],

    Items: [], // actividades
    Sections: [], // trabajadores

    Init: function ( entrada, cntdr ) {
        martes = moment().add( cntdr, 'w' ).weekday( 2 ).startOf( 'd' );

    // martes.subtract( moment.duration(2, 'w') );
        TimeScheduler.Options.GetSections = jornadaMartes.GetSections;
        TimeScheduler.Options.GetSchedule = jornadaMartes.GetSchedule;
        TimeScheduler.Options.Start = martes.add( entrada, 'hours' );
        TimeScheduler.Options.Periods = jornadaMartes.Periods;
        TimeScheduler.Options.SelectedPeriod = '1 day';
        TimeScheduler.Options.Element = $( 'div#martes' );

        TimeScheduler.Options.Events.ItemClicked = jornadaMartes.Item_Clicked;        

        TimeScheduler.Init();
    },

    GetSections: function ( callback ) {
        callback(jornadaMartes.Sections);
    },

    GetSchedule: function ( callback, start, end ) {
        callback(jornadaMartes.Items);
    },

    Item_Clicked: function() {}
};
//------------Termina Jornada Martes---------------------------------//

//------------Jornada Miercoles---------------------------------//
var miercoles;

var jornadaMiercoles = {
    Periods: [],

    Items: [],     // actividades
    Sections: [], // trabajadores

    Init: function ( entrada, cntdr ) {
        miercoles = moment().add( cntdr, 'w' ).weekday( 3 ).startOf( 'd' );

    // miercoles.subtract( moment.duration(2, 'w') );
        TimeScheduler.Options.GetSections = jornadaMiercoles.GetSections;
        TimeScheduler.Options.GetSchedule = jornadaMiercoles.GetSchedule;
        TimeScheduler.Options.Start = miercoles.add( entrada, 'hours' );
        TimeScheduler.Options.Periods = jornadaMiercoles.Periods;
        TimeScheduler.Options.SelectedPeriod = '1 day';
        TimeScheduler.Options.Element = $( 'div#miercoles' );

        TimeScheduler.Options.Events.ItemClicked = jornadaMiercoles.Item_Clicked;        

        TimeScheduler.Init();
    },

    GetSections: function ( callback ) {
        callback(jornadaMiercoles.Sections);
    },

    GetSchedule: function ( callback, start, end ) {
        callback(jornadaMiercoles.Items);
    },

    Item_Clicked: function() {}
};
//------------Termina Jornada Miercoles---------------------------------//

//------------Jornada Jueves---------------------------------//
var jueves;

var jornadaJueves = {
    Periods: [],

    Items: [],     // actividades
    Sections: [], // trabajadores

    Init: function ( entrada, cntdr ) {
        jueves = moment().add( cntdr, 'w' ).weekday( 4 ).startOf( 'd' );

    // jueves.subtract( moment.duration(2, 'w') );
        TimeScheduler.Options.GetSections = jornadaJueves.GetSections;
        TimeScheduler.Options.GetSchedule = jornadaJueves.GetSchedule;
        TimeScheduler.Options.Start = jueves.add( entrada, 'hours' );
        TimeScheduler.Options.Periods = jornadaJueves.Periods;
        TimeScheduler.Options.SelectedPeriod = '1 day';
        TimeScheduler.Options.Element = $( 'div#jueves' );

        TimeScheduler.Options.Events.ItemClicked = jornadaJueves.Item_Clicked;        

        TimeScheduler.Init();
    },

    GetSections: function ( callback ) {
        callback(jornadaJueves.Sections);
    },

    GetSchedule: function ( callback, start, end ) {
        callback(jornadaJueves.Items);
    },

    Item_Clicked: function() {}
};
//------------Termina Jornada Jueves---------------------------------//

//------------Jornada Viernes---------------------------------//
var viernes;

var jornadaViernes = {
    Periods: [],

    Items: [],     // actividades
    Sections: [], // trabajadores

    Init: function ( entrada, cntdr ) {
        viernes = moment().add( cntdr, 'w' ).weekday( 5 ).startOf( 'd' );

    // viernes.subtract( moment.duration(2, 'w') );
        TimeScheduler.Options.GetSections = jornadaViernes.GetSections;
        TimeScheduler.Options.GetSchedule = jornadaViernes.GetSchedule;
        TimeScheduler.Options.Start = viernes.add( entrada, 'hours' );
        TimeScheduler.Options.Periods = jornadaViernes.Periods;
        TimeScheduler.Options.SelectedPeriod = '1 day';
        TimeScheduler.Options.Element = $( 'div#viernes' );

        TimeScheduler.Options.Events.ItemClicked = jornadaViernes.Item_Clicked;        

        TimeScheduler.Init();
    },

    GetSections: function ( callback ) {
        callback(jornadaViernes.Sections);
    },

    GetSchedule: function ( callback, start, end ) {
        callback(jornadaViernes.Items);
    },

    Item_Clicked: function() {}
};
//------------Termina Jornada Viernes---------------------------------//

//------------Jornada Sabado---------------------------------//
var sabado;

var jornadaSabado = {
    Periods: [],

    Items: [],     // actividades
    Sections: [], // trabajadores

    Init: function ( entrada, cntdr ) {
        sabado = moment().add( cntdr, 'w' ).weekday( 6 ).startOf( 'd' );

    // sabado.subtract( moment.duration(2, 'w') );
        TimeScheduler.Options.GetSections = jornadaSabado.GetSections;
        TimeScheduler.Options.GetSchedule = jornadaSabado.GetSchedule;
        TimeScheduler.Options.Start = sabado.add( entrada, 'hours' );
        TimeScheduler.Options.Periods = jornadaSabado.Periods;
        TimeScheduler.Options.SelectedPeriod = '1 day';
        TimeScheduler.Options.Element = $( 'div#sabado' );

        TimeScheduler.Options.Events.ItemClicked = jornadaSabado.Item_Clicked;

        TimeScheduler.Init();
    },

    GetSections: function ( callback ) {
        callback(jornadaSabado.Sections);
    },

    GetSchedule: function ( callback, start, end ) {
        callback(jornadaSabado.Items);
    },

    Item_Clicked: function ( item ) {
        if ( item.mov == 'Cita Servicio' || item.mov == 'Orden Servicio' )
        {
			$( 'div.modal-header > h4#tipoMov' ).text( item.mov +' - '+ item.movId );

			var asesorNombreCompleto;
			var coment;
            coment = item.Comentarios == null ? item.Observaciones : item.Comentarios;
            asesorNombreCompleto = item.nombreAsesor == null ? ' ' : item.nombreAsesor + ' ';
			asesorNombreCompleto += item.apPaternoAsesor == null ? ' ' : item.apPaternoAsesor + ' ';
			asesorNombreCompleto += item.apMaternoAsesor == null ? ' ' : item.apMaternoAsesor;

			item.estatus = item.estatus == null ? '-' : item.estatus;

			var situacion;
			item.mov == 'Orden Servicio' ? situacion = '<dt>Situación</dt><dd>' + item.situacion + '</dd>' : situacion = '';

			// datos cliente
			item.nomCte = item.nomCte == null ? '-' : item.nomCte;

            var ladaTel = '';
            if ( item.ladaCte != null )
                ladaTel = item.ladaCte + ' - ';
            if ( item.telCte != null )
                ladaTel += item.telCte;

            item.emailCte = item.emailCte == null ? '-' : item.emailCte;

            // datos servicio
            item.tipoOrden = item.tipoOrden == null ? '-' : item.tipoOrden;
            item.tipoOperacion = item.tipoOperacion == null ? '-' : item.tipoOperacion;

            var torre = '';
            if ( item.mov == 'Orden Servicio' )
            {
                item.torre = item.torre == null ? '-' : item.torre;
                item.noTorre = item.noTorre == null ? '-' : item.noTorre;

                torre =
                    '<dt>Torre</dt>' +
                    '<dd>' + item.torre + '</dd>' +
                    '<dt>No. Torre</dt>' +
                    '<dd>' + item.noTorre + '</dd>';
            }

            // datos VIN
            item.serie = item.serie == null ? '-' : item.serie;
            item.cveModelo = item.cveModelo == null ? '-' : item.cveModelo;
            item.modelo = item.modelo == null ? '-' : item.modelo;
            item.anioModelo = item.anioModelo == null ? '-' : item.anioModelo;

            $( 'div.modal-body#detalles' ).html(
                '<dl class="dl-horizontal">' + 
                    '<dt>Asesor Pru</dt>' +
                    '<dd>' + item.claveAsesor + ' - ' + asesorNombreCompleto + '</dd>' +
                    '<dt>Inicio</dt>' +
                    '<dd>' + item.fechaIni.format( 'dddd D MMMM, HH:mm:ss' ) + '</dd>' +
                    '<dt>Fin</dt>' +
                    '<dd>' + item.fechaFin.format( 'dddd D MMMM, HH:mm:ss' ) + '</dd>' +
                    '<dt>Estatus</dt>' +
                    '<dd>' + item.estatus + '</dd>' +
                    situacion +
                '</dl>' +
                '<center><b>Cliente</b></center>'+
                '<dl class="dl-horizontal">' +
                    '<dt>Nombre</dt>' +
                    '<dd>' + item.nomCte + '</dd>' +
                    '<dt>Lada - Tél.</dt>' +
                    '<dd>' + ladaTel + '</dd>' +
                    '<dt>Correo</dt>' +
                    '<dd>' + item.emailCte + '</dd>' +
                '</dl>'+
                '<center><b>Servicio</b></center>' +
                '<dl class="dl-horizontal">' +
                    '<dt>Tipo Orden</dt>' +
                    '<dd>' + item.tipoOrden + '</dd>' +
                    '<dt>Tipo Operación</dt>' +
                    '<dd>' + item.tipoOperacion + '</dd>' +
                    torre +
                    '<dt>Hora Llegada</dt>' +
                    '<dd>' + item.hrLlegada + '</dd>' +
                    '<dt>Hora Prometida</dt>' +
                    '<dd>' + item.hrPromesa + '</dd>' +
                '</dl>' +
                '<center><b>Vin</b></center>' +
                '<dl class="dl-horizontal">' +
                    '<dt>Serie</dt>' +
                    '<dd>' + item.serie + '</dd>' +
                    '<dt>Modelo</dt>' +
                    '<dd>' + item.modelo + '</dd>' +
                    '<dt>Año</dt>' +
                    '<dd>' + item.anioModelo + '</dd>' +
                    '<dt>Clave Modelo</dt>' +
                    '<dd>' + item.cveModelo + '</dd>' +
                    '<dt>Placas</dt>' +
                    '<dd>' + item.placas + '</dd>' +
                    '<dt>Comentarios</dt>' +
                    '<dd>' + coment + '<dd>' +
                '</dl>'
            );

            $( 'div#detallesModal' ).modal( 'show' );
        }
        else if ( item.opReal )
        {
            $( 'div.modal-header > h4#tipoMov' ).text( 'Orden Servicio - '+ item.movId );

            var estado, comentarios;
            if ( item.estado )
                estado = '<dt>Estatus</dt>' +
                         '<dd>' + item.estado + '</dd>';
            else
                estado = '';
            if ( item.comentarios )
                comentarios = '<dt>Comentarios</dt>' +
                              '<dd>' + item.comentarios + '</dd>';
            else
                comentarios = '';

            $( 'div.modal-body#detalles' ).html(
                '<dl class="dl-horizontal">' + 
                    '<dt>Clave Asesor</dt>' +
                    '<dd>' + item.claveAsesor + '</dd>' +
                    '<dt>Inicio Real</dt>' +
                    '<dd>' + item.fechaIni.format( 'dddd D MMMM, HH:mm:ss' ) + '</dd>' +
                    '<dt>Fin Real</dt>' +
                    '<dd>' + item.fechaFin.format( 'dddd D MMMM, HH:mm:ss' ) + '</dd>' +
                    '<dt>Inicio Estimado</dt>' +
                    '<dd>' + item.inicioEst + '</dd>' +
                    '<dt>Fin Estimado</dt>' +
                    '<dd>' + item.finEst + '</dd>' +
                    '<dt>Clave Operación</dt>' +
                    '<dd>' + item.cveOp + '</dd>' +
                    '<dt>Descripción</dt>' +
                    '<dd>' + item.descripcion + '</dd>' +
                    '<dt>Duración Real</dt>' +
                    '<dd>' + item.duracionReal + ' hrs.</dd>' +
                    '<dt>Duración Estimada</dt>' +
                    '<dd>' + item.duracionEst + ' hrs.</dd>' +
                    '<dt>Tiempo Trabajado</dt>' +
                    '<dd>' + item.duracionTrabajado + ' hrs.</dd>' +
                    estado +
                    comentarios +
                '</dl>'
            );

            $( 'div#detallesModal' ).modal( 'show' );
        }
    }
};
//------------Termina Jornada Sabado---------------------------------//