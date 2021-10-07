$(window).on('load', function() {
    bind();
    var options = {
        brushColor:"rgb(255,0,0)",
        backgroundImage: base_url+"assets/img/canvas/car_demo.png",
    };

    $("#canvasid").jqScribble(options);

    var id = $("#id_venta").val();

    var id_cliente = $("#cliente").val();
    var vin = $("#vin").val();

    $(".vista_completa, .vista_completa_vehiculo, .vista_completa_asesor, .vista_completaOrden, #mostrar_modalemail, #generar_pdf, #mostrar_modalfirma, #btn_inicio, #enviar_whatsapp #mostrar_modalOasis").hide();

    // funcion que asigna el total de fotos que tiene cada orden 
    set_totalFots();

    /*Grafica Gasolina roundslider*/
    $("#handle1").roundSlider({
        min: 0,
        max: 100,
        step: 12.5,
        sliderType: "min-range",
        editableTooltip: false,
        radius: 80,
        width: 16,
        value: 0,
        handleSize: 0,
        handleShape: "square",
        circleShape: "half-top",
        startAngle: 0,
        create: function(e){
            var img = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAALtSURBVGhD7ZpLqA1xHMfHK2SBWGAjjxVZWZBHbKwsUZKykNfCRrKRyCM3yUaRsvSIBRaUZKcsSMpWkihF5J03n890/5k7Z+45x8yce/6n7qc+3fv/nbn/me+d13/+c5ImLMZr+Ab/1OxPfIoncBp2jO3oyoo2om5f4gKsnSVoCD2Cs7BuxuBCvIWGce+Mw1q5jnZ+KG11FgM9RNe32UKdfEQ7np62kmQKXsRPaL2qHkp7MLADrZ9LWzUxAe3UMIHLaO0Hvq3oOwyBNqKsRNseCTIRD+CotFUSO7FTVyju+q9oiPkWasC94TqupK0kWYbZIOG88R9YOkw+SL5dB2HD76StxiBebN5jpTAxBJHKYWIJIpXCxBRESoeJLYiUChNjENmGLqNthYk1yAZ0mWDLMLEHeYRtHWaxBzmPbZ0zvRBEsmHOWsiT3/CR+AF/43qcXdE56IpdRxgklgkihnH4ZH2RhSxFe+A4WqvTX7gCpWwQOYnWD6atDEVBRuNuvItPKvoYb+AqDFQJEh4BTqWtDJ04J1rRTpA16DJX09Y/ei6Iz/Qu8xonW+in54LIfXS5mzjeAvRkkLn4CrNhogzik2ErPMSyYXb1/x5VEH2Be3EsDkY2jNsZXRBvuv7UezgJByMbRqMKEu4vTtbZzl9q82TDRHmyz8AwjmoYeuTYidEGkWNozSnbZkR/+XWAau1S2hqc6IOsxnytiOEgnWA4CAwH6QRFQXx/ac2HuWY4nHG5w2krQyxBHNl+we8400IBI/AB+rfuwQHEEkQ8XKw72+J2ZTHEUfRzH599jzOAmIK4LW6knz3H/eiN0mGJh5z1b7gUG4gpiPgO/jb6ed5nuBwLiS1IwKmjPnQWxSkg90zT19mxBvkv5uEmtNPPuG6I3Ieu0yvQWpyKlejEd07KeAErYSdet53h7oZeZt2GyoeYnQzluZGn3WFJS+zEu+nWLhkmpCsHcYbcjrqt3xGrxBY802VPY6sJhwKS5C9/WIaPzshN2AAAAABJRU5ErkJggg==">';
            $(".rs-inner").append(img);
        },
        tooltipFormat: function (e) {
            var val = e.value;

            switch (val) 
            {
                case 0:
                    tanque = "V";
                    $("#span_grafica").css({"background": "#f13139", "color": "#fff"});
                break;
                case 12.5:
                    tanque = "1/8";
                    $("#span_grafica").css({"background": "#f13139", "color": "#fff"});
                break;
                case 25:
                    tanque = "1/4";
                    $("#span_grafica").css({"background": "#f19b31", "color": "#fff"});
                break;
                case 37.5:
                    tanque = "3/8";
                    $("#span_grafica").css({"background": "#f19b31", "color": "#fff"});
                break;
                case 50:
                    tanque = "1/2";
                    $("#span_grafica").css({"background": "#f9ea32", "color": "#000"});
                break;
                case 62.5:
                    tanque = "5/8";
                    $("#span_grafica").css({"background": "#f9ea32", "color": "#000"});
                break;
                case 75:
                    tanque = "3/4";
                    $("#span_grafica").css({"background": "#2196f3", "color": "#000"});
                break;
                case 87.5:
                    tanque = "7/8";
                    $("#span_grafica").css({"background": "#2196f3", "color": "#000"});
                break;
                case 100:
                    tanque = "LL";
                    $("#span_grafica").css({"background": "#128e1b", "color": "#fff"});
                break;
                default:
                    tanque = "V";
                    $("#span_grafica").css({"background": "#f13139", "color": "#fff"});
                break;
            }

            $("#span_grafica").text(tanque);
            $("#insp_gasolina").val(tanque);

            return val+" %";
        }
    });

    $.ajax({
        url: base_url + "index.php/servicio/cargar_listas",
        type: "POST",
        dataType: 'json',
        data: {id:id},
        beforeSend: function(){
            $("#loading_spin").show();
            $('.mdb-selectc').material_select('destroy'); 
        },
        success: function(data){
            $("#condicion_cliente").empty();
            $("#condicion_cliente").append('<option value="">Seleccione</option>');
            for (var i = 0; i < data.Condicion.length; i++) {
                if (data.Condicion[i]['Condicion'] == data.Datos[0].Condicion)
                    $("#condicion_cliente").append('<option value="' + data.Condicion[i]['Condicion'] + '" selected>' + data.Condicion[i]['Condicion'] + '</option>');
                else    
                    $("#condicion_cliente").append('<option value="' + data.Condicion[i]['Condicion'] + '">' + data.Condicion[i]['Condicion'] + '</option>');
            }

            $("#tipoorden_cliente").empty();
            $("#tipoorden_cliente").append('<option value="">Seleccione</option>');
            for (var i = 0; i < data.TipoOrden.length; i++) {
                if (data.TipoOrden[i]['TipoOrden'] == data.Datos[0].ServicioTipoOrden)
                    $("#tipoorden_cliente").append('<option value="' + data.TipoOrden[i]['TipoOrden'] + '" selected>' + data.TipoOrden[i]['TipoOrden'] + '</option>');
                else
                    $("#tipoorden_cliente").append('<option value="' + data.TipoOrden[i]['TipoOrden'] + '">' + data.TipoOrden[i]['TipoOrden'] + '</option>');
            }

            $("#tipooperacion_cliente").empty();
            $("#tipooperacion_cliente").append('<option value="">Seleccione</option>');
            for (var i = 0; i < data.TipoOperacion.length; i++) {
                if (data.TipoOperacion[i]['TipoOperacion'] == data.Datos[0].ServicioTipoOperacion)
                    $("#tipooperacion_cliente").append('<option value="' + data.TipoOperacion[i]['TipoOperacion'] + '" selected>' + data.TipoOperacion[i]['TipoOperacion'] + '</option>');
                else
                    $("#tipooperacion_cliente").append('<option value="' + data.TipoOperacion[i]['TipoOperacion'] + '">' + data.TipoOperacion[i]['TipoOperacion'] + '</option>');
            }

            $("#tipoprecio_cliente").empty();
            $("#tipoprecio_cliente").append('<option value="">Seleccione</option>');
            for (var i = 0; i < data.ListaPrecios.length; i++) {
                if (data.ListaPrecios[i]['Lista'] == data.Datos[0].ListaPreciosEsp)
                    $("#tipoprecio_cliente").append('<option value="' + data.ListaPrecios[i]['Lista'] + '" selected>' + data.ListaPrecios[i]['Lista'] + '</option>');
                else
                    $("#tipoprecio_cliente").append('<option value="' + data.ListaPrecios[i]['Lista'] + '">' + data.ListaPrecios[i]['Lista'] + '</option>');
            }

            $("#concepto_cliente").empty();
            $("#concepto_cliente").append('<option value="">Seleccione</option>');
            for (var i = 0; i < data.Concepto.length; i++) {
                if (data.Concepto[i]['Concepto'] == data.Datos[0].Concepto)
                    $("#concepto_cliente").append('<option value="' + data.Concepto[i]['Concepto'] + '" selected>' + data.Concepto[i]['Concepto'] + '</option>');
                else
                    $("#concepto_cliente").append('<option value="' + data.Concepto[i]['Concepto'] + '">' + data.Concepto[i]['Concepto'] + '</option>');
            }

            $("#ZonaImpuesto_select").empty();
            $("#ZonaImpuesto_select").append('<option value="" data-porc="null">Seleccione</option>');
            for (var i = 0; i < data.iva.length; i++) {
                if (data.iva[i]['Zona'] == data.Datos[0].ZonaImpuesto)
                {
                    $("#ZonaImpuesto_select").append('<option value="' + data.iva[i]['Zona'] + '" data-porc="'+data.iva[i]['Porcentaje']+'" selected>' + data.iva[i]['Zona'] + '</option>');
                }
                else{
                    $("#ZonaImpuesto_select").append('<option value="' + data.iva[i]['Zona'] + '" data-porc="'+data.iva[i]['Porcentaje']+'">' + data.iva[i]['Zona'] + '</option>');
                }
            }

            /*$("#moneda_cliente").empty();
            $("#moneda_cliente").append('<option value="">Seleccione</option>');
            for (var i = 0; i < data.Moneda.length; i++) {
                $("#moneda_cliente").append('<option value="' + data.Moneda[i]['Moneda'] + '">' + data.Moneda[i]['Moneda'] + '</option>');
            }*/

            $("#tipouen_cliente").empty();
            $("#tipouen_cliente").append('<option value="">Seleccione</option>');
            for (var i = 0; i < data.UEN.length; i++) {
                if (data.UEN[i]['UEN'] == data.Datos[0].UEN)
                    $("#tipouen_cliente").append('<option value="' + data.UEN[i]['UEN'] + '" selected>' + data.UEN[i]['UEN'] +' - ' + data.UEN[i]['Nombre'] + '</option>');
                else
                    $("#tipouen_cliente").append('<option value="' + data.UEN[i]['UEN'] + '">' + data.UEN[i]['UEN'] +' - ' + data.UEN[i]['Nombre'] + '</option>');
            }

            $("#tipotorre").empty();
            $("#tipotorre").append('<option value="">Seleccione</option>');
            for (var i = 0; i < data.torrecolor.length; i++) {
                if (data.torrecolor[i]['Identificador'] == data.Datos[0].ServicioIdentificador)
                    $("#tipotorre").append('<option value="' + data.torrecolor[i]['Identificador'] + '" selected>' + data.torrecolor[i]['Identificador'] + '</option>');
                else
                    $("#tipotorre").append('<option value="' + data.torrecolor[i]['Identificador'] + '">' + data.torrecolor[i]['Identificador'] + '</option>');
            }

            //data = eval("("+data+")");
            /*var sel   = $("#concepto_cliente");
            var sel2  = $("#tipooperacion_cliente");
            var sel3  = $("#tipoprecio_cliente")
            var sel4  = $("#tipouen_cliente");
            var sel5  = $("#tipoorden_cliente");
            var sel6  = $("#tipotorre");*/

            // var condicion     = data.Condicion;
            /*var tipoorden     = data.TipoOrden;
            var tipooperacion = data.TipoOperacion;
            var listprecio    = data.ListaPrecios;
            var concepto      = data.Concepto;
            var uen           = data.uen;
            var torre         = data.torrecolor;*/
            // console.log(data);

            // var numCondicion = condicion.length;
            /*var numreg  = tipoorden.length;
            var numreg2 = tipooperacion.length;
            var numreg3 = listprecio.length;
            var numreg5 = concepto.length;
            var numreg4 = uen.length;
            var numreg6 = torre.length; */

            //empty
            /*sel.empty();
            sel2.empty();
            sel3.empty();
            sel4.empty();
            sel5.empty();
            sel6.empty();*/


            /*for (var i=0; i<numreg; i++) {
                if(i == 0){
                    sel5.append('<option disabled selected>Seleccione... </option>');
                }
                sel5.append('<option value="' + tipoorden[i]["TipoOrden"] + '">' + tipoorden[i]["TipoOrden"] + '</option>');
            }
            for (var i=0; i<numreg2; i++) {
                if(i == 0){
                    sel2.append('<option disabled selected>Seleccione... </option>');
                }
                sel2.append('<option value="' + tipooperacion[i]["TipoOperacion"] + '">' + tipooperacion[i]["TipoOperacion"] + ' </option>');
            }
            for (var i=0; i<numreg3; i++) {
                if(i == 0){
                    sel3.append('<option disabled selected>Seleccione... </option>');
                }
                sel3.append('<option value="' + listprecio[i]["Lista"] + '">' + listprecio[i]["Lista"] + '</option>');
            }
            for (var i=0; i<numreg5; i++) {
                if(i == 0){
                    sel.append('<option disabled selected>Seleccione... </option>');
                }
                sel.append('<option value="' + concepto[i]["Concepto"] + '">' + concepto[i]["Concepto"] + '</option>');
            }
            for (var i=0; i<numreg4; i++) {
                if(i == 0){
                    sel4.append('<option disabled selected>Seleccione... </option>');
                }
                sel4.append('<option value="' + uen[i]["UEN"] + '">' + uen[i]["UEN"] + '</option>');
            }
             for (var i=0; i<numreg6; i++) {
                if(i == 0){
                    sel6.append('<option disabled selected>Seleccione... </option>');
                }
                sel6.append('<option value="' + torre[i]["Identificador"] + '">' + torre[i]["Identificador"] + '</option>');
            }*/
            $("#comentcliente").val(data.Datos[0]['Comentarios']);
			$('.mdb-selectc').material_select();
            $("#loading_spin").hide();
        },
        error: function(){
            alert('error');
        }
    });

    $.ajax({
        url: base_url+ "index.php/user/cargar_datos_vta",
        type: "POST",
        dataType: 'json',
        data: ({ id: id, cliente: id_cliente, vin:vin} ),
        beforeSend: function(){
            $("#loading_spin").show();
        },
        error: function(){
            console.log('error');
        },
        success: function (data){
            $("#loading_spin").hide();
            result = eval(data);
            // console.log(data[0]);
            //validation
           
            var datos  = data.datos;
    
            var vehiculo = data.vehiculo;

            var agente = data.Agente;

            var camp = data.camp;

            //console.log(data);
            
            if(datos[0]['PersonalApellidoPaterno'] == null || datos[0]['PersonalApellidoPaterno'] == '')
                localStorage.setItem("nom_cliente", datos[0]['nombre']);
            else
                
				localStorage.setItem("nom_cliente", datos[0]['PersonalNombres'] + ' ' + datos[0]['PersonalNombres2']) ;
            // console.log("agrega PersonalNombres");
            localStorage.setItem("ap_cliente", datos[0]['PersonalApellidoPaterno']);
            localStorage.setItem("am_cliente", datos[0]['PersonalApellidoMaterno']);



            // Datos Ocultos
            $("#mov_cliente").val(datos[0]['Mov']);
            $("#empresa_cliente").val(datos[0]['Empresa']);
            $("#sucursal_cliente").val(datos[0]['Sucursal']);
            $("#almacen_cliente").val(datos[0]['Almacen']);
            $("#cliente_cliente").val(datos[0]['cliente']);
            $("#tipouen_cliente").val(datos[0]['UEN']);
            $("#id_servicio").val(datos[0]['ID']);
            $("#ZonaImpuesto").val(datos[0]['ZonaImpuesto']);
            if(datos[0]['FechaEmision'])
            {
                $("#Fecha_Emision_cliente").val(datos[0]['FechaEmision'].substring(0,10));
            }



            //datos ->  Pestaña Cliente
            $("#id_cliente").val(datos[0]['cliente']);

            $("#nombre_cliente").val(datos[0]['nombre']);
            $("#cel_cliente").val(datos[0]['Celular']);
            $("#correo_cliente").val(datos[0]["eMail1"]);
            $("#lada_casa").val(datos[0]["TelefonosLada"]);
            $("#telefono_cliente").val(datos[0]["Telefonos"]);
            $("#lada_oficina").val(datos[0]["Extencion2"]);
            $("#telefono_oficina").val(datos[0]['Contacto2']);
            
            $("#rfc_cliente").val(datos[0]["RFC"]);

            $("#dir_cliente").val(datos[0]["Direccion"]);
            $("#numExt_cliente").val(datos[0]["DireccionNumero"]);
            $("#numInt_cliente").val(datos[0]["DireccionNumeroInt"]);
            $("#colonia_cliente").val(datos[0]["Colonia"]);
            $("#poblacion_cliente").val(datos[0]["Poblacion"]);
            $("#estado_cliente").val(datos[0]["Estado"]);
            $("#cp_cliente").val(datos[0]["CodigoPostal"]);

            

            //vehiculos ->  Pestaña Vehículo
            if( vehiculo.length > 0 ){
                $("#busq_arti").val(vehiculo[0]['ServicioArticulo']);
                $("#busq_model").val(vehiculo[0]['Modelo']);

                $("#art_cliente").val(vehiculo[0]['ServicioArticulo']);
                $("#anio_cliente").val(vehiculo[0]['Modelo']);
                $("#vin_cliente").val(vehiculo[0]['ServicioSerie']);
                $("#placas_cliente").val(vehiculo[0]['Placas']);
                $("#color_cliente").val(vehiculo[0]["ColorExteriorDescripcion"]);
                $("#kms_cliente").val(vehiculo[0]['Km']);
            }
            else{
                 $("#art_cliente").val('No capturado');
            }



            //Agente -> Pestaña Asesor
            $("#cve_cliente").val(agente[0]['agente']);
            $("#asesorname_cliente").val(agente[0]['nombre']);
            if(datos[0]['FechaRequerida'])
                $("#fecha_promesa_cliente").val(datos[0]['FechaRequerida'].substring(0,10));
            if(datos[0]['HoraRequerida'])
                // se comenta para que tome la hora del sistema y no la hora de la orden
                //$("#horapromesa_cliente").val(datos[0]['HoraRequerida']);

            $("#hora_promesa_cliente2").empty();
            for (var i = 0; i < data.Horarios.length; i++) {
                if (data.Horarios[i]['Hora'] == datos[0]['HoraRequerida'])
                    $("#hora_promesa_cliente2").append('<option value="' + data.Horarios[i]['Hora'] + '" selected>' + data.Horarios[i]['Hora'] + '</option>');
                else
                    $("#hora_promesa_cliente2").append('<option value="' + data.Horarios[i]['Hora'] + '">' + data.Horarios[i]['Hora'] + '</option>');
            }
            
            //lo nuevo para campañas
            if(camp.length > 0)
            {
                var temp = "";
                for (var i = 0; i < camp.length; i++) 
                {
                    temp += "<tr>";
                    temp +="<td>"+camp[i]['Asunto']+"</td>";
                    temp +="<td>"+camp[i]['Problema']+"</td>";
                    temp +="<td>"+camp[i]['Vigencia']+"</td>";
                    temp +="<td>"+camp[i]['Prioridad']+"</td>";
                    temp += "</tr>";
                }
                $("#tbodycamp").empty();
                $("#tbodycamp").append(temp);
                $("#modalcamp").modal("show");
            }else
            {
                alert("no hay campañas activas para esta unidad");
            }
            //$("#promesa_cliente").val(datos[0]['FechaRequerida']);

           // var moneda = result[0]['Moneda'];
            //console.log(moneda);
            
            //$("#moneda_cliente").val(moneda);

            /*$('[name=moneda_cliente] option').filter(function() { 
                return ($(this).text() == moneda); //To select Blue
            }).prop('selected', true);*/
            

            //$("#uen_cliente").val(result[0]['UEN']);
          
           /* if(result[0]['ServicioSerie'] != null){
                $("#vin_cliente").val(result[0]['ServicioSerie']);  
                
            }else{
                $("#vin_cliente").val('NO CAPTURADO');
                toastr.error('Favor de capturar el VIN', 'Falta VIN!');
            }
            $("#agente_cliente").val(result[0]['Agente']);*/
            
            //inicializar los select
            //$('.mdb-selectc').material_select();

            //Orden -> Pestaña Orden
            // $('#condicion_cliente').removeAttr('selected').filter('[value="'+datos[0]['Condicion']+'"]').attr('selected', true);
            /*if(datos[0]['Condicion'])
                $('#condicion_cliente > option[value="'+datos[0]['Condicion']+'"]').attr("selected", true);
            $('#condicion_cliente').trigger("chosen:updated");
            if(datos[0]['ServicioTipoOrden'])
                $('#tipoorden_cliente > option[value="'+datos[0]['ServicioTipoOrden']+'"]').attr("selected", true);
            $('#tipoorden_cliente').trigger("chosen:updated");
            if(datos[0]['ServicioTipoOperacion'])
                $('#tipooperacion_cliente > option[value="'+datos[0]['ServicioTipoOperacion']+'"]').attr("selected", true);
            $('#tipooperacion_cliente').trigger("chosen:updated");
            if(datos[0]['ListaPreciosEsp'])
                $('#tipoprecio_cliente > option[value="'+datos[0]['ListaPreciosEsp']+'"]').attr("selected", true);
            $('#tipoprecio_cliente').trigger("chosen:updated");
            if(datos[0]['Concepto'])
                $('#concepto_cliente > option[value="'+datos[0]['Concepto']+'"]').attr("selected", true);
            $('#concepto_cliente').trigger("chosen:updated");*/
            if(datos[0]['Moneda'])
                $('#moneda_cliente > option[value="'+datos[0]['Moneda']+'"]').attr("selected", true);
            $('#moneda_cliente').trigger("chosen:updated");
            /*if(datos[0]['UEN'])
                $('#tipouen_cliente > option[value="'+datos[0]['UEN']+'"]').attr("selected", true);
            $('#tipouen_cliente').trigger("chosen:updated");
            if(datos[0]['ServicioIdentificador'])
                $('#tipotorre > option[value="'+datos[0]['ServicioIdentificador']+'"]').attr("selected", true);
            $('#tipotorre').trigger("chosen:updated");*/
            if(datos[0]['ServicioNumero'])
                $('#torrenumero').val(datos[0]['ServicioNumero']);

            //% IVA/ZONA IMPUESTO
            if(datos[0]['ZonaImpuesto'])
            {
                $('#ZonaImpuesto_select > option[value="'+datos[0]['ZonaImpuesto'].toUpperCase()+'"]').attr("selected", true);
            }         
        }
    });

    //se asigna la variable con el id de la orden en la tabla orden_servicio
    var id_orden_servicio_insp = localStorage.getItem("id_orden_servicio");
    $.ajax({
        url: base_url+ "index.php/Servicio/cargar_datsOrden_insp/"+id_orden_servicio_insp,
        type: "POST",
        dataType: 'json',
        beforeSend: function(){
            $("#loading_spin").show();
        },
        error: function(){
            //console.log('Error al recuperar datos de inspección');
            toastr.info('Error al recuperar los datos de la inspección, continue con la orden de servicio...');
        },
        success: function (data){
            $("#loading_spin").hide();
             
            var inspeccion  = data.inspeccion; 
            console.log("Datos inspeccion");
            console.log(inspeccion);
            if(inspeccion){
                set_value_inspeccion(inspeccion);   
            }


        } //llave succes cierre
    }); // cierre funcion ajax

    function set_value_inspeccion(inspeccion) {
            //se convierte en array el campo de la cajuela que se separan por una coma para obtner su valor del check correspondiente
            var insp_cajuela = inspeccion.cajuela.split(",");
             //se convierte en array el campo  exteriores que se separan por una coma para obtner el valor del check correspondiente
            var insp_exteriores = inspeccion.exteriores.split(",");
            //se convierte en array el campo  documentacion que se separan por una coma para obtner el valor del check correspondiente
            var insp_documentacion = inspeccion.documentacion.split(",");
            //console.log(insp_cajuela[0]);

        /* PASO 1 : Inspección Visual e Inventario en Recepción  */
            
            //cajuela
            if(insp_cajuela[0] != "n/a"){
                $('#herramienta').prop('checked',true);
            }
            if(insp_cajuela[1] != "n/a"){
                $('#gatollave').prop('checked',true);
            }
            if(insp_cajuela[2] != "n/a"){
                $('#reflejantes').prop('checked',true);
            }
             if(insp_cajuela[3] != "n/a"){
                $('#cables').prop('checked',true);
            }
            if(insp_cajuela[4] != "n/a"){
                $('#extintor').prop('checked',true);
            }
            if(insp_cajuela[5] != "n/a"){
                $('#llantarefaccion').prop('checked',true);
            }
            //exteriores
            if(insp_exteriores[0] != "n/a"){
                $('#taponesrueda').prop('checked',true);
            }
            if(insp_exteriores[1] != "n/a"){
                $('#gomalimpiador').prop('checked',true);
            }
            if(insp_exteriores[2] != "n/a"){
                $('#antna').prop('checked',true);
            }
            if(insp_exteriores[3] != "n/a"){
                $('#tapagas').prop('checked',true);
            }
            if(insp_exteriores[4] != "n/a"){
                $('#molduras').prop('checked',true);
            }
            //documentación
            if(insp_documentacion[0] != "n/a"){
                $('#polizamanual').prop('checked',true);
            }
             if(insp_documentacion[1] != "n/a"){
                $('#segrines').prop('checked',true);
            }
             if(insp_documentacion[2] != "n/a"){
                $('#certverific').prop('checked',true);
            }
            if(insp_documentacion[3] != "n/a"){
                $('#tarjcirc').prop('checked',true);
            }
            // garantía
            radio_check(inspeccion.extension_garantia,"#extGSI");
            // ¿Deja artículos personales?
            switch(inspeccion.dejaArticulos) {
              case 'Si':
                $("#dejaarticulos").prop('checked',true);
                break;
              default:
                //$(idInput).prop('checked',true);
            }
            // ¿Cuáles?
            $("input[name='articulos_personales']").val(inspeccion.articulos);
             // campo gasolina que se extrae de la bd
            //console.log( inspeccion.gasolina);
            set_datsGasoln(inspeccion.gasolina);
         
        /* Paso 2: Niveles  */
        
            //NIVELES DE FLUIDOS 

            // Pérdida de aceite o fluidos
            radio_check(inspeccion.perdida_fluidos,"#fluidossi");
            //nivel_fluidos_cambiado
            radio_check(inspeccion.nivel_fluidos_cambiado,"#materialInline1");
            // Aceite de Motor
            radio_check_switch(inspeccion.aceiteMotor,'input:checkbox[name=aceiteMotor]');
              //$('input:checkbox[name=aceiteMotor]').prop('checked',true);
            // Dirección Hidraulica
            radio_check_switch(inspeccion.direccionHidraulica,'input:checkbox[name=direccionHidraulica]');
            //Transmisión
            radio_check_switch(inspeccion.liquidoTransmision,'input:checkbox[name=transmision]');
            //Limpiaparabrisas
            radio_check_switch(inspeccion.liquidoLimpiaPara,'input:checkbox[name=liq_limpiaparabrisas]');
            //Deposito de Fluido de Freno
            radio_check_switch(inspeccion.liquidoFreno,'input:checkbox[name=liq_frenos]');
            //Deposito de recuperación refrigerante
            radio_check_switch(inspeccion.deposito_refrigerante,'input:checkbox[name=liq_refrigerante]');
        
            //PLUMAS LIMPIAPARABRISAS
            
            //Prueba de limpiaparabrisas realizada
            radio_check(inspeccion.pruebaParabrisas,"#prueba_limp1");
            //Cambiado limpiaparabrisas
            radio_check(inspeccion.plumaslimp_cambiado,"#plumaslimp_cambiado1");
            //Plumas Limpiaparabrisas
            switch(inspeccion.plumas) {
                case 'Buen Estado':
                    $("#inlineFormCheckbox1").prop('checked',true);
                break;
                case 'Requiere cambiar': // el campo dice requiere atencion
                    $("#inlineFormCheckbox2").prop('checked',true);
                break;
                default:
                    //$(idInput).prop('checked',true);
            }
            //Bateria cambiado
            radio_check(inspeccion.bateria_cambiado,"#bateria_cambiado1");
            //Nivel de Batería leyenda
            switch(inspeccion.bateria) {
                case 'Bien':
                    $("#bateriabien").prop('checked',true);
                break;
                case 'Requiere Atencion':
                    $("#bateriamedio").prop('checked',true);
                break;
                case 'Requiere Reparacion':
                    $("#bateriamal").prop('checked',true);
                break;
                default:
                    //$(idInput).prop('checked',true);
            }
            // corriente de arranque en frío, especificaciones de fabrica
            $("input[name='corriente_fabrica']").val(inspeccion.corriente_fabrica);
            // Corriente de arranque en frío real
            $("input[name='corriente_real']").val(inspeccion.corriente_real);
            // Nivel de Carga
            $("input[name='nivel_carga']").val(inspeccion.nivel_carga);

            // SISTEMAS/COMPONENTES

            // Funcionamiento del claxon, luces interiores, luces exteriores, luces de giro, luces de emergencia y frenos
            switch(inspeccion.luces) {
                case 'Bien':
                    $("#lucesydemasbien").prop('checked',true);
                break;
                case 'Requiere Reparacion':
                    $("#lucesydemasmal").prop('checked',true);
                break;
                default:
                    //$(idInput).prop('checked',true);
            }
                // CAMBIADO
                radio_check(inspeccion.sistemas1_cambiado,"#sistemas1_cambiado1");
            // Grietas, roturas y picaduras en el parabrisas
            switch(inspeccion.parabrisas) {
                case 'Bien':
                    $("#parabrisasbien").prop('checked',true);
                break;
                case 'Requiere Reparacion':
                    $("#parabrisasmal").prop('checked',true);
                break;
                default:
                    //$(idInput).prop('checked',true);
            }
                // CAMBIADO
                 radio_check(inspeccion.sistemas2_cambiado,"#sistemas2_cambiado1");

        // Interiores (Opera)
            // Claxon
            check_tres(inspeccion.claxon,"SI","#claxonok","NO","#claxonno","No cuenta","#claxonnc");
            // Luces
            check_tres(inspeccion.luces_int,"SI","#lucesok","NO","#lucesno","No cuenta","#lucesnc");
            // Radio
            check_tres(inspeccion.radio,"SI","#radiook","NO","#radiono","No cuenta","#radionc");
            // Pantallas
            check_tres(inspeccion.pantalla,"SI","#pantallasi","NO","#pantallano","No cuenta","#pantallanc");
            // A/C
            check_tres(inspeccion.ac,"SI","#acsi","NO","#acno","No cuenta","#acnc");
            // Encendedor
            check_tres(inspeccion.encendedor,"SI","#encendedorsi","NO","#encendedorno","No cuenta","#encendedornc");
            // Vidrios
            check_tres(inspeccion.vidrios,"SI","#vidriossi","NO","#vidriosno","No cuenta","#vidriosnc");
            // Espejos
            check_tres(inspeccion.espejos,"SI","#espejossi","NO","#espejosno","No cuenta","#espejosnc");
            // Seguros Electrónicos
            check_tres(inspeccion.seguros_ele,"SI","#segurosesi","NO","#seguroseno","No cuenta","#segurosenc");
            // CD
            check_tres(inspeccion.co,"SI","#cosi","NO","#cono","No cuenta","#conc");
            // Asientos y Vestiduras
            check_tres(inspeccion.asientosyvesti,"SI","#asientosvsi","NO","#asientosvno","No cuenta","#asientosvnc");
             // Tapetes
            check_tres(inspeccion.tapetes,"SI","#tapetessi","NO","#tapetesno","No cuenta","#tapetesnc");

            // Interiores Profeco (opera)
            //se convierte en array el campo  documentacion que se separan por una coma para obtner el valor del check correspondiente
            var insp_profecoFame = inspeccion.profecoFame.split(",");

            // Instrumentos de tablero
            check_dos(insp_profecoFame[0],"tablero_si","#tableroSi","tablero_no","#tableroNo");
            // Espejo retrovisor
            check_dos(insp_profecoFame[1],"retrovisor_si","#retrovisorSi","retrovisor_no","#retrovisorNo");
            // Ceniceros
            check_dos(insp_profecoFame[2],"cenicero_si","#ceniceroSi","cenicero_no","#ceniceroNo");
            // Cinturones de seguridad
            check_dos(insp_profecoFame[3],"cinturon_si","#cinturonSi","cinturon_no","#cinturonNo");
            // Manijas y/o controles interiores
            check_dos(insp_profecoFame[4],"manijas_si","#manijasSi","manijas_no","#manijasNo");

            // Condiciones Generales
            // Aspectos mecanicos la diferencia con check_dos es que este si asigna los valores completos
            check_dos_no(insp_profecoFame[5],"amRegulares","#amRegulares","amNoE","#amNoE");
            // Aspectos de carroceria
            check_tres(insp_profecoFame[6],"acRegulares","#acRegulares","acRayones","#acRayones","acMalEdo","#acMalEdo");

            // Inferior
            // ¿Requiere revisión?
            if(inspeccion.reqRev_inferior){
                $('input:checkbox[name=reqRev_inferior]').prop('checked',true);
            }
            // Sistema de Escape
            check_tres(inspeccion.inf_sistEsc,"bien","#inf_sistEsc1","mal","#inf_sistEsc2","fuga","#inf_sistEsc3");
            // Amortiguadores
            check_tres(inspeccion.inf_amort,"bien","#inf_amort1","mal","#inf_amort2","fuga","#inf_amort3");
            // Tuberias
            check_tres(inspeccion.inf_tuberias,"bien","#inf_tuberias1","mal","#inf_tuberias2","fuga","#inf_tuberias3");
            // Transeje / Transmisión
            check_tres(inspeccion.inf_transeje_transm,"bien","#inf_transeje_transm1","mal","#inf_transeje_transm2","fuga","#inf_transeje_transm3");
            // Sistema de Dirección
            check_tres(inspeccion.inf_sistDir,"bien","#inf_sistDir1","mal","#inf_sistDir2","fuga","#inf_sistDir3");
             // Chasis sucio
            check_tres(inspeccion.inf_chasisSucio,"bien","#inf_chasisSucio1","mal","#inf_chasisSucio2","fuga","#inf_chasisSucio3");
            // Golpes Especifico
            check_tres(inspeccion.inf_golpesEspecif,"bien","#inf_golpesEspecif1","mal","#inf_golpesEspecif2","fuga","#inf_golpesEspecif3");

            // Sistema de Frenos
            // ¿Requiere revisión?
            if(inspeccion.reqRev_sistFrenos){
                $('input:checkbox[name=reqRev_sistFrenos]').prop('checked',true);
            }
            // Delantera Derecha Balata/Zapata
            check_tres(inspeccion.sfrenos_ddBalata,"reparacion","#sfrenos_ddBalata3","atencion","#sfrenos_ddBalata2","bien","#sfrenos_ddBalata1");
            // Delantera Derecha Disco/Tambor
            check_tres(inspeccion.sfrenos_ddDisco,"reparacion","#sfrenos_ddDisco3","atencion","#sfrenos_ddDisco2","bien","#sfrenos_ddDisco1");
            // Delantera Derecha Neumatico
            check_tres(inspeccion.sfrenos_ddNeumat,"reparacion","#sfrenos_ddNeumat3","atencion","#sfrenos_ddNeumat2","bien","#sfrenos_ddNeumat1");

            // Delantera Izquierda Balata/Zapata
            check_tres(inspeccion.sfrenos_diBalata,"reparacion","#sfrenos_diBalata3","atencion","#sfrenos_diBalata2","bien","#sfrenos_diBalata1");
            // Delantera Izquierda Disco/Tambor
            check_tres(inspeccion.sfrenos_diDisco,"reparacion","#sfrenos_diDisco3","atencion","#sfrenos_diDisco2","bien","#sfrenos_diDisco1");
            // Delantera Izquierda Neumatico
            check_tres(inspeccion.sfrenos_diNeumat,"reparacion","#sfrenos_diNeumat3","atencion","#sfrenos_diNeumat2","bien","#sfrenos_diNeumat1");

            // Trasera Derecha Balata/Zapata
            check_tres(inspeccion.sfrenos_tdBalata,"reparacion","#sfrenos_tdBalata3","atencion","#sfrenos_tdBalata2","bien","#sfrenos_tdBalata1");
            // Trasera Derecha Disco/Tambor
            check_tres(inspeccion.sfrenos_tdDisco,"reparacion","#sfrenos_tdDisco3","atencion","#sfrenos_tdDisco2","bien","#sfrenos_tdDisco1");
            // Trasera Derecha Neumatico
            check_tres(inspeccion.sfrenos_tdNeumat,"reparacion","#sfrenos_tdNeumat3","atencion","#sfrenos_tdNeumat2","bien","#sfrenos_tdNeumat1");

             // Trasera Izquierda Balata/Zapata
            check_tres(inspeccion.sfrenos_tiBalata,"reparacion","#sfrenos_tiBalata3","atencion","#sfrenos_tiBalata2","bien","#sfrenos_tiBalata1");
            // Trasera Izquierda Disco/Tambor
            check_tres(inspeccion.sfrenos_tiDisco,"reparacion","#sfrenos_tiDisco3","atencion","#sfrenos_tiDisco2","bien","#sfrenos_tiDisco1");
            // Trasera Izquierda Neumatico
            check_tres(inspeccion.sfrenos_tiNeumat,"reparacion","#sfrenos_tiNeumat3","atencion","#sfrenos_tiNeumat2","bien","#sfrenos_tiNeumat1");

            // Refacción  Neumatico
            check_tres(inspeccion.sfrenos_refNeumat,"reparacion","#sfrenos_refNeumat3","atencion","#sfrenos_refNeumat2","bien","#sfrenos_refNeumat1");

        /* Paso 3: Fotos y Audio */
        // Registro de Daños
            set_tableDanios(inspeccion.dan_costDerecho,inspeccion.dan_parteDel,inspeccion.dan_intAsAlf,inspeccion.dan_costIzq,
            inspeccion.dan_parteTras,inspeccion.dan_cristFaros);

            // Tipo de daño
            var options = {
                brushColor:"rgb(255,0,0)",
                // se agina la img que se guardada en la inspeccion marcando rayones estrellado o golpes
                backgroundImage: inspeccion.img,
            };            
            $("#canvasid").data("jqScribble").clear();
            $("#canvasid").data("jqScribble").update(options);
    }
    
    //función que evalua la seleccion de radio inputs y asigna con si o no solo asigna si
    function radio_check(val,idInput) {
        switch(val) {
          case 'si':
            $(idInput).prop('checked',true);
            break;
          default:
            //$(idInput).prop('checked',true);
        }
    }

    //función que evalua la seleccion de los check inputs y asigna con LLenar o Bien 
    function radio_check_switch(val,nameInput) {
        switch(val) {
          case 'Bien':
            $(nameInput).prop('checked',true);
            break;
          default:
            //$(idInput).prop('checked',true);
        }
    }

    // funcion que evalua checks con 3 opciones  ejem: si - no - no cuenta
    function check_tres(val,opc1,idInput1,opc2,idInput2,opc3,idInput3) {
        switch(val) {
            case opc1:
                $(idInput1).prop('checked',true);
            break;
            case opc2:
                $(idInput2).prop('checked',true);
            break;
            case opc3:
                $(idInput3).prop('checked',true);
            break;
            default:
                //$(idInput).prop('checked',true);
            } 
    }

    // funcion que evalua checks con 2 opciones interiores profeco  ejem: si - no  asigna a un solo valor
    function check_dos(val,opc1,idInput1,opc2,idInput2) {
        switch(val) {
            case opc1:
                $(idInput1).prop('checked',true);
            break;
            case opc2:
                //si no lo selecciona o asignas no es igual a valor por omision por eso se comenta esta linea
                // y por eso no se va a salvar el valor no 
                //$(idInput2).prop('checked',true);
            break;
            default:
                //$(idInput).prop('checked',true);
            } 
    }

    // funcion que evalua checks con 2 opciones  condiciones generales asina a los dos valores
    function check_dos_no(val,opc1,idInput1,opc2,idInput2) {
        switch(val) {
            case opc1:
                $(idInput1).prop('checked',true);
            break;
            case opc2:
                $(idInput2).prop('checked',true);
            break;
            default:
                //$(idInput).prop('checked',true);
        } 
    }

    //funcion que asina los valores capturados de la gasolina 
    function set_datsGasoln(valor) {

        switch (valor) 
        {
            case "V":
                $("#span_grafica").css({"background": "#f13139", "color": "#fff"}); 
                $("#span_grafica").text(valor);
                $("#insp_gasolina").val(valor);
                $('#handle1').roundSlider('setValue',  0);
            break;
            case "1/8":
                $("#span_grafica").css({"background": "#128e1b", "color": "#fff"});
                $("#span_grafica").text(valor);
                $("#insp_gasolina").val(valor);
                $('#handle1').roundSlider('setValue',  12.5);
            break;
            case "1/4":
                $("#span_grafica").css({"background": "#128e1b", "color": "#fff"});
                $("#span_grafica").text(valor);
                $("#insp_gasolina").val(valor);
                $('#handle1').roundSlider('setValue',  25);
            break;
            case "3/8":
                $("#span_grafica").css({"background": "#128e1b", "color": "#fff"});
                $("#span_grafica").text(valor);
                $("#insp_gasolina").val(valor);
                $('#handle1').roundSlider('setValue',  37.5);
            break;
            case  "1/2":
                $("#span_grafica").css({"background": "#128e1b", "color": "#fff"});
                $("#span_grafica").text(valor);
                $("#insp_gasolina").val(valor);
                $('#handle1').roundSlider('setValue',  50);
            break;
            case "5/8":
                $("#span_grafica").css({"background": "#128e1b", "color": "#fff"});
                $("#span_grafica").text(valor);
                $("#insp_gasolina").val(valor);
                $('#handle1').roundSlider('setValue',  62.5);
            break;
            case "3/4":
                $("#span_grafica").css({"background": "#128e1b", "color": "#fff"});
                $("#span_grafica").text(valor);
                $("#insp_gasolina").val(valor);
                $('#handle1').roundSlider('setValue',  75);
            break;
            case "7/8":
                $("#span_grafica").css({"background": "#128e1b", "color": "#fff"});
                $("#span_grafica").text(valor);
                $("#insp_gasolina").val(valor);
                $('#handle1').roundSlider('setValue',  87.5);
            break;
            case "LL":
                $("#span_grafica").css({"background": "#128e1b", "color": "#fff"});
                $("#span_grafica").text(valor);
                $("#insp_gasolina").val(valor);
                $('#handle1').roundSlider('setValue',  100);
            break;
            default:
                
            break;      
        }
      
    }

    function set_tableDanios(dan_costDerecho,dan_parteDel,dan_intAsAlf,dan_costIzq,dan_parteTras,dan_cristFaros) {
        var check_exisDanios = 0;
        
        // Costado Derecho
        if(dan_costDerecho){
            $("#dan_costDerecho").prop('checked',true);
            check_exisDanios += 1;
        }
        if(dan_parteDel){
            $("#dan_parteDel").prop('checked',true);
            check_exisDanios += 1;
        }
        if(dan_intAsAlf){
            $("#dan_intAsAlf").prop('checked',true);
            check_exisDanios += 1;
        }
        if(dan_costIzq){
            $("#dan_costIzq").prop('checked',true);
            check_exisDanios += 1;
        }
        if(dan_parteTras){
            $("#dan_parteTras").prop('checked',true);
            check_exisDanios += 1;
        }
        if(dan_cristFaros){
            $("#dan_cristFaros").prop('checked',true);
            check_exisDanios += 1;
        }
        if(check_exisDanios>0){
            $("#existen_danios").prop('checked',true);
        }
        //console.log(check_exisDanios);
    }

    function set_totalFots() {    
            $.ajax({
            cache: false,
            type: 'post',
            url: base_url+ "index.php/user/total_fotos",
            dataType: "json",
            data: ({ id_orden_servicio: localStorage.getItem("id_orden_servicio") }),
            success: function(data){
                    //console.log(data);
                    var texto = "Total de fotos capturadas: "+ data;
                    $("#totalFots").text(texto);
            },
            error: function(){
                console.log('error al consultar total de fotos funcion : set_totalFots()');
            }
        });
    }

    //validacion datos orden de servicio begin
    function limpiar_numero(cadena) {
		txt = cadena.replace(/\D/g, "");
		return txt;
	}
    
    //Validación de telefono movil
	$(document)
    .off("change paste keyup", "#cel_cliente")
    .on("change paste keyup", "#cel_cliente", function(event) {
        var contenido = $("#cel_cliente").val();
        contenido = limpiar_numero(contenido);
        if (contenido.length > 10) {
            contenido = contenido.substring(0, 10);
        }
        $("#cel_cliente").val(contenido);
    });

    //Validación de telefono casa
	$(document)
    .off("change paste keyup", "#telefono_cliente")
    .on("change paste keyup", "#telefono_cliente", function(event) {
        var contenido = $("#telefono_cliente").val();
        contenido = limpiar_numero(contenido);
        if (contenido.length > 10) {
            contenido = contenido.substring(0, 10);
        }
        $("#telefono_cliente").val(contenido);
    });
    //Validación de correo de cliente
    $(document)
        .off("change paste keyup", "#correo_cliente")
        .on("change paste keyup", "#correo_cliente", function(event) {
            var contenido = $("#correo_cliente").val();
            if (contenido.length > 50) {
                contenido = contenido.substring(0, 50);
            }
            $("#correo_cliente").val(contenido);
    });
    //Validación de clave asesor
    $(document)
        .off("change paste keyup", "#cve_cliente")
        .on("change paste keyup", "#cve_cliente", function(event) {
            var contenido = $("#cve_cliente").val();
            if (contenido.length > 10) {
                contenido = contenido.substring(0, 10);
            }
            $("#cve_cliente").val(contenido);
    });
    //Validación de CALLE
    $(document)
        .off("change paste keyup", "#dir_cliente")
        .on("change paste keyup", "#dir_cliente", function(event) {
            var contenido = $("#dir_cliente").val();
            if (contenido.length > 100) {
                contenido = contenido.substring(0, 100);
            }
            $("#dir_cliente").val(contenido);
    });
    //Validación de numExt_cliente
    $(document)
        .off("change paste keyup", "#numExt_cliente")
        .on("change paste keyup", "#numExt_cliente", function(event) {
            var contenido = $("#numExt_cliente").val();
            if (contenido.length > 20) {
                contenido = contenido.substring(0, 20);
            }
            $("#numExt_cliente").val(contenido);
    });
    //Validación de numInt_cliente
    $(document)
        .off("change paste keyup", "#numInt_cliente")
        .on("change paste keyup", "#numInt_cliente", function(event) {
            var contenido = $("#numInt_cliente").val();
            if (contenido.length > 20) {
                contenido = contenido.substring(0, 20);
            }
            $("#numInt_cliente").val(contenido);
    });
    //Validación de colonia_cliente
    $(document)
        .off("change paste keyup", "#colonia_cliente")
        .on("change paste keyup", "#colonia_cliente", function(event) {
            var contenido = $("#colonia_cliente").val();
            if (contenido.length > 100) {
                contenido = contenido.substring(0, 100);
            }
            $("#colonia_cliente").val(contenido);
    });
    //Validación de poblacion_cliente
    $(document)
        .off("change paste keyup", "#poblacion_cliente")
        .on("change paste keyup", "#poblacion_cliente", function(event) {
            var contenido = $("#poblacion_cliente").val();
            if (contenido.length > 100) {
                contenido = contenido.substring(0, 100);
            }
            $("#poblacion_cliente").val(contenido);
    });
    //Validación de estado_cliente
    $(document)
        .off("change paste keyup", "#estado_cliente")
        .on("change paste keyup", "#estado_cliente", function(event) {
            var contenido = $("#estado_cliente").val();
            if (contenido.length > 50) {
                contenido = contenido.substring(0, 50);
            }
            $("#estado_cliente").val(contenido);
    });

    //Validación de cp_cliente
    $(document)
        .off("change paste keyup", "#cp_cliente")
        .on("change paste keyup", "#cp_cliente", function(event) {
            var contenido = $("#cp_cliente").val();
            contenido = limpiar_numero(contenido);
            if (contenido.length > 10) {
                contenido = contenido.substring(0, 10);
            }
            $("#cp_cliente").val(contenido);
    });
    //Validación de placas_cliente
    $(document)
        .off("change paste keyup", "#placas_cliente")
        .on("change paste keyup", "#placas_cliente", function(event) {
            var contenido = $("#placas_cliente").val();
            if (contenido.length > 20) {
                contenido = contenido.substring(0, 20);
            }
            $("#placas_cliente").val(contenido);
    });
    //Validación de color_cliente
    $(document)
        .off("change paste keyup", "#color_cliente")
        .on("change paste keyup", "#color_cliente", function(event) {
            var contenido = $("#color_cliente").val();
            if (contenido.length > 50) {
                contenido = contenido.substring(0, 50);
            }
            $("#color_cliente").val(contenido);
    });
    //Validación de kms_cliente
    $(document)
        .off("change paste keyup", "#kms_cliente")
        .on("change paste keyup", "#kms_cliente", function(event) {
            var contenido = $("#kms_cliente").val();
            contenido = limpiar_numero(contenido);
            if (contenido.length > 12) {
                contenido = contenido.substring(0, 12);
            }
            $("#kms_cliente").val(contenido);
    });

    //validacion datos orden de servicio end

    // step 1 
    $("#ok_after").click(function(e){
        e.preventDefault(); 
        $("#panel5").removeClass();
        $("#panel6").removeClass();
        $("#panel7").removeClass();
        
        $('#panel7').addClass('animated bounceOutRight');
        $('#panel7').hide();

        $("#panel5").addClass('animated bounceInLeft');
        $('#panel5').show();

        $("#ok_next").show();
        $("#ok_after").hide();
        $("#ok_nextwo").hide();

    });
    // step 1 
    $("#ok_after2").click(function(e){
        e.preventDefault(); 
        $("#panel5").removeClass();
        $("#panel6").removeClass();
        $("#panel7").removeClass();
        
        $('#panel6').addClass('animated bounceOutRight');
        $('#panel6').hide();

        $("#panel7").addClass('animated bounceInLeft');
        $('#panel7').show();
        
        $("#ok_nextwo").show();
        $("#ok_after2").hide();
        $("#ok_after").show();


    });

    //step 2
    $("#ok_next").click(function(e){
        e.preventDefault(); 
        $("#panel5").removeClass();
        $("#panel6").removeClass();
        $("#panel7").removeClass();

        // some validations here 
        validor = $("#form_orden_servicio").validationEngine('validate');

        var numtel = 0;
        


        if($("#cel_cliente").val() != '' || $("#telefono_cliente").val() != '' || $("#telefono_oficina").val() != '')
            numtel = 1;

        if(validor && numtel){
               $("#loading_spin").show();  
            $.ajax(
            {
                 cache: false,
                 type: 'post',
                 url: base_url+ "index.php/user/revisar_email",
                 dataType: "json",
                 data: ({ email: $("#correo_cliente").val()}),
                 success: function(data)
                 {
                    $("#loading_spin").hide();  
                     if(data == 0){
                        $('#panel5').addClass('animated bounceOutLeft');
                        $('#panel5').hide();

                        $("#panel7").addClass('animated bounceInRight');
                        $('#panel7').show();

                        $("#ok_nextwo, #btn_guardarInspeccion").hide();

                        $("#ok_after").show();
                        // $("#ok_nextwo").show();
                        $('html, body').animate({
                                    scrollTop: $("#scrolltoo").offset().top
                                }, 2000);
                        $("#ok_next").hide();
                        
                        $('a[href="#step-1"]').click();
                        
                        var form = $("#form_orden_servicio").serialize();
                        //console.log(form);
                        actualizar_listasOrden(form, "listasOrden");      
                     }else{
                        //alert("Correo no valido");
                        toastr.info("Correo no valido");
                        $("#correo_cliente").focus();
                     }
                 },
                 error: function( jqXHR, textStatus, errorThrown )
                 {
                    $("#loading_spin").hide();
                     //alert( 'Ocurrio un error,el correo electrónico no se pudo validar de manera correcta, por favor vuelve a intentar.' );
                     toastr.error( 'Ocurrio un error,el correo electrónico no se pudo validar de manera correcta, por favor vuelve a intentar.' );
                 } 
             });

           
        }
        else{
            if(!numtel){
                alert("Favor de guardar al menos un telefono de contacto para avanzar");
            }
        }

         



    });

    /*Botones pasos inspección*/
    $('a[href="#step-1"]').click(function(){
        $("#btn_guardarInspeccion").hide();

        $(this).removeClass("btn-circle-2").addClass("current-step");
        $('a[href="#step-2"], a[href="#step-3"], a[href="#step-4"]').removeClass("current-step").addClass("btn-circle-2");
    });

    $('a[href="#step-2"]').click(function(){
        $(this).removeClass("btn-circle-2").addClass("current-step");
        $('a[href="#step-1"], a[href="#step-3"], a[href="#step-4"]').removeClass("current-step").addClass("btn-circle-2");
    });

    $('a[href="#step-3"]').click(function(){
        $(this).removeClass("btn-circle-2").addClass("current-step");
        $('a[href="#step-1"], a[href="#step-2"], a[href="#step-4"]').removeClass("current-step").addClass("btn-circle-2");
    }); 
    $('a[href="#step-4"]').click(function(){
        $("#btn_guardarInspeccion").show();
        $(this).removeClass("btn-circle-2").addClass("current-step");
        $('a[href="#step-1"], a[href="#step-2"], a[href="#step-3"]').removeClass("current-step").addClass("btn-circle-2");
    }); 


    //step 3
    $("#ok_nextwo").click(function(e){
        e.preventDefault();
        $("#panel5").removeClass();
        $("#panel6").removeClass();
        $("#panel7").removeClass();

        $('#panel7').addClass('animated bounceOutLeft');
        $('#panel7').hide();

        $("#panel6").addClass('animated bounceInRight');
        $('#panel6').show();

        $("#ok_nextwo").hide();
        $("#ok_after").hide();  
        $("#ok_after2").show();

        var id_venta = $("#id_servicio").val();
        
        $.ajax({
            type: "POST",
            url: base_url + "index.php/Servicio/ArticulosDeCita",
            data: ( {id: id_venta } ),
            beforeSend: function (){
                $("#loading_spin").show();  
            },
            success: function (data){
                if(data != null){
                    $("#loading_spin").hide();
                    var items = [];
                    var json = data;
                    var obj = JSON.parse(json);
                    var  i=0;

                     
                        var contador = 0;
                        var paquete_ant = 0;
                        $.each(obj , function (key, val){ 
                            // alert(val.idp);
                            // alert(paquete_ant);
                            if(contador == 0 && val.tipoPrecio == 'Precio Fijo')
                            {
                                // alert("entra al primero");
                                items.push("<tr class='item-row' style='text-align:center;'>");
                                items.push("<td class='item-name'><div class='delete-wpr'><a class='delete'>X</a> </div></td>");
                                items.push("<td>" + 'Paquete: '+ val.Paquete + "</td>");
                                items.push("<td>" + val.DescripcionC + "</td>");
                                items.push("<td>" + 1 + "</td>");
                                items.push("<td>" + val.precio + "</td>");
                                items.push("<td  class='price'>" +  val.precio + "</td>");
                                items.push("<td style='display:none;' id='tipopaquete'>" +  val.tipoPrecio + "</td>");
                                items.push("<td style='display:none;' id='idpq'>" +  val.idp + "</td>");
                                items.push("</tr>");
                                contador++;
                                paquete_ant = val.idp;
                            }else
                            {
                                if(paquete_ant != val.idp)
                                {
                                    // alert("entra la diferencia");
                                    paquete_ant = 0;

                                    if(val.tipoPrecio == 'Precio Fijo')
                                    {
                                        // alert("entra la diferencia primero");
                                        items.push("<tr class='item-row' style='text-align:center;'>");
                                        items.push("<td class='item-name'><div class='delete-wpr'><a class='delete'>X</a> </div></td>");
                                        items.push("<td>" + 'Paquete: '+ val.Paquete + "</td>");
                                        items.push("<td>" + obj.DescripcionC + "</td>");
                                        items.push("<td>" + 1 + "</td>");
                                        items.push("<td>" + val.precio + "</td>");
                                        items.push("<td  class='price'>" +  val.precio + "</td>");
                                        items.push("<td style='display:none;' id='tipopaquete'>" +  val.tipoPrecio + "</td>");
                                        items.push("<td style='display:none;' id='idpq'>" +  val.idp + "</td>");
                                        items.push("</tr>");
                                        contador++;
                                        paquete_ant = val.idp;
                                    }else
                                    {
                                        // alert("entra la diferencia segundo");
                                        items.push("<tr class='item-row' style='text-align:center;'>");
                                        items.push("<td class='item-name'><div class='delete-wpr'><a class='delete'>X</a> </div></td>");
                                        items.push("<td>"  + val.Articulo + "</td>");
                                        items.push("<td>"  + val.Descripcion1 + "</td>");
                                        items.push("<td class='qty'>" + val.Cantidad    + "</td>");
                                        items.push("<td id='manoo_precio'>" + val.Precio + "</td>");
                                        var total = (val.Cantidad * val.Precio);
                                        items.push("<td  class='price'>" +  total + "</td>");
                                        if(val.Tipo == 'Normal'){
                                            items.push("<td style='display:none;' id='articulosad'>single</td>");
                                        }else if(val.Tipo == 'Servicio'){
                                            items.push("<td style='display:none;' id='articulosmo'>mo</td>");
                                        }else{

                                        }
                                        items.push("<td style='display:none;' id='idpq'>" + 'NA' + "</td>");
                                        items.push("</tr>");
                                    }
                                }
                            }
                        });
                        $("<tbody/>",{html: items.join("")}).appendTo("#table_invoice");
                        update_total();
                    
                }    
                    $("#loading_spin").hide();
            },
            error: function (){
                console.log("error");
            }
        });
    });

	$("#existen_danios").on("change", function(){
	    if($(this).prop("checked") == false)
	    {
	        $(".check-tablaDanios").prop("checked", false);
	    }
	});

	$("#tabla_danios .check-tablaDanios").on("change", function(){

	    if($(this).prop("checked") == true)
	    {
	        if($("#existen_danios").prop("checked") == false)
	        {
	            $("#existen_danios").prop("checked", true);
	        }
	    }

	    var total = $('.check-tablaDanios:checked').length;

	    if(total == 0)
	    {
	        $("#existen_danios").prop("checked", false);
	    }
	});

    $("#dejaarticulos").on("click", function(){
        $("#nodejaarticulos").prop("checked", false);
    });

    $("#nodejaarticulos").on("click", function(){
        $("#dejaarticulos").prop("checked", false);
    });
});

$(document).on("click", "#table_paq tbody tr", function() {
        //console.log('simple clic');
        var idp = this.id;
        var items = [];
        $.ajax({
            type: "POST",
            url: base_url + "index.php/servicio/pkts_detalle",
            data: ({ idp: idp } ),
            beforeSend: function(){
                $("#loading_spin").show();  
            },
            success: function(data){    
                var json = data;
                var obj = JSON.parse(json);
                //reset campos
                $("#tabla_detalle tbody").empty(); 
                $("#preciopaquete").val('');
                $("#tipodepreciopaquete").val(''); 
                // console.log(obj);
                var  i=0;
                if (obj.length > 0){
                    //console.log(obj[0]['Articulo'] + ' ' + obj[0]['Descripcion'] + ' ' +obj[0]['Cantidad']);
                    $.each(obj , function (key, val){
                        //console.log(val);
                        items.push("<tr>");
                        items.push("<td>" + val.Articulo    + "</td>");
                        items.push("<td>" + val.Descripcion + "</td>");
                        items.push("<td>" + val.Cantidad    + "</td>");
                        items.push("</tr>");
                        //inputs
                        $("#preciopaquete").val(val.Precio);
                        $("#tipodepreciopaquete").val(val.TipoPrecio);
                    });
                $("<tbody/>",{html: items.join("")}).appendTo("#tabla_detalle");
              
                }else{
                    console.log('Sin Datos');
                }

                $("#loading_spin").hide(); 

                   
            },
            error: function(){

            }   
        });
    }).on("click", "#table_paq tbody tr button", function(e){
        e.preventDefault();  //cancel system double-click event
        // console.log(this.parentElement.parentElement);
        var idp = this.parentElement.parentElement.id;
        $.confirm({
            title: '¿Desea agregar este paquete a la orden?',
            content: '',
            buttons: {
                cancelar: function () {
                
                },
                aceptar: {
                    text: 'Aceptar',
                    btnClass: 'btn-green',
                    action: function(){
                        
                        $("#paquete_cliente").val(idp);
                        $("#"+idp).addClass('light-green accent-3');
                        var items = [];
                        $.ajax({
                            type: "POST",
                            url: base_url + "index.php/servicio/pkts_detalle",
                            data: ({ idp: idp } ),
                            beforeSend: function(){
                                $("#loading_spin").show();  
                            },
                            success: function(data){
                                var json = data;
                                var obj = JSON.parse(json);
                                console.log(obj);
                                //$("#tabla_detalle").empty();
                                var  i=0;
                
                                if(obj[0]['TipoPrecio'] == 'Precio Fijo'){
                                    toastr.success("Se ha seleccionado el paquete "+idp);
                                    
                                    var precio_unitario = roundNumber(obj[0]['Precio'],2);
                                    var total = formatear_numero(precio_unitario);
                                    
                                    items.push("<tr class='item-row' style='text-align:center;'>");
                                    items.push("<td class='item-name'><div class='delete-wpr'><a class='delete'>X</a> </div></td>");
                                    items.push("<td>" + 'Paquete: '+ idp + "</td>");
                                    items.push("<td>" + obj[0]['DescripcionC'] + "</td>");
                                    items.push("<td>" + 1 + "</td>");
                                    items.push("<td>" + precio_unitario + "</td>");
                                    items.push("<td  class='price'>" +  total + "</td>");
                                    items.push("<td style='display:none;' id='tipopaquete'>" +  obj[0]['TipoPrecio'] + "</td>");
                                    items.push("<td style='display:none;' id='idpq'>" + idp + "</td>");
                                    items.push("</tr>");

                                    var html = {html: items.join("")}
                                    i++;
                                    console.log(i);
                                    $("#table_invoice tbody").append(html.html);
                                    update_total();

                                }else{
                                    
                                        //console.log(obj[0]['Articulo'] + ' ' + obj[0]['Descripcion'] + ' ' +obj[0]['Cantidad']);
                                        $.each(obj , function (key, val){
                                            var precio_unitario = roundNumber(val.PrecioUnitario,2);
                                            precio_unitario = formatear_numero(precio_unitario);
                                            var total = formatear_numero(val.Total);
                                            items.push("<tr class='item-row' style='text-align:center;'>");
                                            items.push("<td class='item-name'><div class='delete-wpr'><a class='delete'>X</a> </div></td>");
                                            items.push("<td>" + val.Articulo    + "</td>");
                                            items.push("<td>" + val.Descripcion + "</td>");
                                            items.push("<td class='qty'>" + val.Cantidad    + "</td>");
                                            items.push("<td>" + precio_unitario + "</td>");
                                            items.push("<td  class='price'>" +  total + "</td>");
                                            items.push("<td style='display:none;' id='tipopaquete'>Suma de componentes</td>");
                                            items.push("<td style='display:none;' id='idpq'>" + idp + "</td>");
                                            items.push("</tr>");
                                        });

                                        toastr.success("Se ha seleccionado el paquete "+idp);
                                        var html = {html: items.join("")}
                                        $("#table_invoice tbody").append(html.html);
                                        update_total();

                                }
                                $("#loading_spin").hide(); 
                                $("#modalbusqpaq").modal("hide");
                                $("#tabla_detalle tbody").empty();   
                            }  
                        });
                    }
                }
            }
        });
});

$(document).on('click','.item-name .delete-wpr .delete' ,function(){
    $(this).parents('.item-row').remove();
    update_total();
    if ($(".delete").length < 1) $(".delete").hide();                             //para que haya minimo un elemento
});

function obtener_artSeleccionados()
{
    var elementos = [];
    
    $("#table_invoice tr").each(function(index, value){
        var cantidad = $(this).find('td:eq(3)').find('input').val();
        var precio_unidad = $(this).find('td:eq(4)').find('input').val();
        
        if(cantidad == undefined)
        {
            cantidad = $(this).find('td:eq(3)').text();
        }

        if(precio_unidad == undefined)
        {
            precio_unidad = $(this).find('td:eq(4)').text()
        }
        elementos[index] = {
            "art" : $(this).find('td:eq(1)').text(),
            "descripcion" :$(this).find('td:eq(2)').text(),
            "cantidad" : cantidad,
            "precio_u" : precio_unidad,
            "total" : $(this).find('td:eq(5)').text(),
            "tipo" : $(this).find('td:eq(6)').text(),
            "id" :  $(this).find('td:eq(7)').text()
        }
    });

    elementos.shift();  // remueve el header de la tabla

    return elementos;
}

// guardar la orden en intelisis y base del proyecto
var click_guardar = false;
$(document).on('click','#levanta_orden' ,function(e){
    if(click_guardar === false)
    {
        e.preventDefault();
        $("#loading_spin").show();
        toastr.info('Preparando orden, espere.');

        $("#nom_cliente").val(localStorage.getItem("nom_cliente"));
        $("#ap_cliente").val(localStorage.getItem("ap_cliente"));
        $("#am_cliente").val(localStorage.getItem("am_cliente"));
        // alert(localStorage.getItem("nom_cliente"));


        var form = $("#form_orden_servicio").serializeArray();
        var elementos = [];
        var artmo = [];

        //sacar los valores de la mano de obra y guardarlos en un arraite
        $("#table_invoice  .arst_add").each(function(index, value){
            artmo[index] = {
                "art" : $(this).find('td:eq(1)').text(),
                "descripcion": $(this).find('td:eq(2)').text(),
                "cantidad" : $(this).find('td:eq(3)').find('input').val(),
                "precio_u" : $(this).find('td:eq(4)').find('input').val(),
                "total" : $(this).find('td:eq(5)').text(),

            }
        });
        elementos = obtener_artSeleccionados();

        elementos = JSON.stringify(elementos);

        artmo = JSON.stringify(artmo);

        form.push({name: "elementos", value: elementos});
        form.push({name: "artmo", value: artmo})

        $.ajax({
            type:'POST',
            url: base_url+ 'index.php/servicio/nueva_orden_detalle',
            data: form
        }).always(function(data){
            $("#loading_spin").show();
        })
        .done(function(data) {
            data = eval("("+data+")");
            if(data.success == 1)
            {
                toastr.success('Orden creada correctamente.');
                $("#mostrar_modalemail, #generar_pdf, #mostrar_modalfirma, #btn_inicio, #mostrar_modalOasis").show();
                // $("#mostrar_modalemail").click();
                $("#send_mail").click();
                $("#loading_spin, #levanta_orden").hide();
                setTimeout(function(){ 
                    window.open(base_url+"index.php/servicio/correo_reverso/"+ localStorage.getItem("id_orden_servicio"), "_blank");
                }, 6000);
                
            }else 
            {
                toastr.error('Hubo un error al crear la orden.');
            }     
        })
        .fail(function() {
            alert("Hubo un error al crear la orden");
        });
    }

    // click_guardar = true;
});

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
  
  price = formatear_numero(price);

  $(this).closest('tr').find('.price').each(
    function(i){
        $(this).html(price);

    })

  update_total();
}
function bind() {
  $(".cost").blur(update_price);
  $(".qty").blur(update_price);

}
  
bind();

function update_total() {
  var total = 0;
  var iva = 0;
  var price = 0;
  var porc_iva_elegido = ($("#ZonaImpuesto_select option:selected").attr("data-porc") == "null") ? 16 * 0.01 : parseFloat($("#ZonaImpuesto_select option:selected").attr("data-porc")) * 0.01;
  $('.price').each(function(i){
    price = $(this).html().replace("$","");
    price = parseFloat(price.replace(/,/g, ''));
    if (!isNaN(price)) total += Number(price);
  });


  total = roundNumber(total,2);
  iva = roundNumber((total * porc_iva_elegido),2)

  price = formatear_numero(price);
  total = formatear_numero(total);
  iva = formatear_numero(iva);

  $('#subtotal').val(total);
  $('#ivatotal').val(iva); 
  
  update_balance();
}

function update_balance() {
    var due = parseFloat($("#subtotal").val().replace(/,/g, ''));
    var iva = parseFloat($("#ivatotal").val().replace(/,/g, ''));

    due = roundNumber((due+iva),2);
    due = formatear_numero(due);

    $('.due').val(due);
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

$(document).on('click', '#add_pac', function (){
    var vin = $("#vin_cliente").val();
    $('#modalbusqpaq').modal('show');
    //empty
    $.ajax({
        cache: false,
        type: "POST",
        url: base_url + "index.php/servicio/pkts_por_vin",
        data: ({ vin: vin } ),
        beforeSend: function(){
            $("#loading_spin").show();
        },
        success: function(data){

            var data_from_ajax = data;
            var obj = JSON.parse(data_from_ajax);
            //console.log(obj);
            var items =[];
            $.each(obj , function (key, val){ 
                items.push("<tr id='" + val.IdPaquete    + "'>");
                items.push("<td>" + val.IdPaquete  + "</td>");
                items.push("<td>"  + val.DescripcionC + "</td>");
                items.push("<td>" + val.DescripcionL + "</td>");
                items.push("<td><button class='btn btn-success float-right'><i class='fa fa-plus'></i></button></td>");
                items.push("</tr>");
            });

        $("#table_paq tbody").empty();
        $("<tbody/>",{html: items.join("")}).appendTo("#table_paq");
        $("#loading_spin").hide();
        },
        error: function(){
        }   
    });
});
/*$(document).on('click', '#add_pacfrec', function (){
    var vin = $("#vin_cliente").val();
    //reduze
    $.ajax({
        type: "POST",
        url: base_url + "servicio/pkts_por_vin_frec",
        data: ({ vin: vin } ),
        beforeSend: function(){
            $("#loading_spin").show();
        },
        success: function(data){

            var data_from_ajax = data;
            var obj = JSON.parse(data_from_ajax);
            console.log(obj);
            var items =[];
            $.each(obj , function (key, val){ 
                items.push("<tr id='" + val.IdPaquete    + "'>");
                items.push("<td>" + val.IdPaquete  + "</td>");
                items.push("<td>"  + val.DescripcionC + "</td>");
                items.push("<td>" + val.DescripcionL + "</td>");
                items.push("</tr>");


            });

        $("<tbody/>",{html: items.join("")}).appendTo("#table_paq");
        $("#loading_spin").hide();
        },
        error: function(){

        }   
    });
});*/

$(document).on('click', '#add_mo', function (){
    $('#modalmanodeobra').modal('show');
    filtro = $("#tipoprecio_cliente").val();
    //console.log('V: '+filtro);
    $.ajax({
        url: site_url+"buscador/buscar_mo",
        data:  {term :filtro },
        cache:false,
        dataType: "json",
        beforeSend: function(){
            $('#spinner').show();
        },
        complete: function(){
            $('#spinner').hide();                       
        },
        success: function(data) {
            //limpiar tabla para no duplicar registros
            $('#table_manos > tbody').empty();
            var obj = data;
            //console.log(obj);
            var items =[];
            var  i=0;
            $.each(obj , function (key, val){ 
                items.push("<tr id='" + val.Articulo    + "'>");
                items.push("<td id='manoo_art'>"  + val.Articulo + "</td>");
                items.push("<td id='manoo_desc'>"  + val.Descripcion1 + "</td>");
                items.push("<td id='manoo_precio'>" + val.Precio + "</td>");
                items.push("<td class='item-name'><button class='btn btn-success' id='boton_agregarMano'><i class='fa fa-plus'></i></button></td>");
                items.push("</tr>");
            });

        $("<tbody/>",{html: items.join("")}).appendTo("#table_manos");
            
        },
        error : function(xhr, status) {
            alert('Disculpe, existió un problema');
        }
    });
});
$(document).on('click', '#add_arts', function (){
    $('#modalbusqarts').modal('show');   
});

function mySearch() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("busquedamano");
  filter = input.value.toUpperCase();
  table = document.getElementById("table_manos");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}

function mySearch2() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("busquedapaq");
  filter = input.value.toUpperCase();
  table = document.getElementById("table_paq");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        td2 = tr[i].getElementsByTagName("td")[0];
        td3 = tr[i].getElementsByTagName("td")[2];
        if (td || td2 || td3) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1 || td2.innerHTML.trim().toUpperCase().indexOf(filter) > -1  || td3.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "table-row";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

$(document).on("click", '#ver_todoCliente', function (){
    $(".vista_completa").toggle();
});

$(document).on("click", '#ver_todoVehiculo', function (){
    $(".vista_completa_vehiculo").toggle();
});

$(document).on("click", '#actualizar_cliente', function (e){
    e.preventDefault();

    var form = $("#form_orden_servicio").serialize();
    actualizar_cliente(form, "cliente");
});

$(document).on("click", '#actualizar_vehiculo', function (e){
    e.preventDefault();

    var form = $("#form_orden_servicio").serialize();
    actualizar_vehiculo(form, "vehiculo");
});

function actualizar_cliente(form, elemento)
{
    form += "&tipo_elemento="+elemento;
    $.ajax({
        url: base_url+ "index.php/user/actualizar_datosOrden/",
        type: 'POST',
        dataType: 'json',
        data: form
    })
    .done(function(data) {
        if(data)
        {
            toastr.success("Se actualizaron los datos del Cliente");
        }else
        {
            toastr.info("Hubo un error al actualizar los datos del Cliente, favor de continuar...");
        }
    })
    .fail(function() {
         toastr.info("Hubo un error al actualizar los datos del cliente, favor de continuar...");
    });
}

function actualizar_vehiculo(form, elemento)
{
    form += "&tipo_elemento="+elemento;
    $.ajax({
        url: base_url+ "index.php/user/actualizar_datosOrden/",
        type: 'POST',
        dataType: 'json',
        data: form
    })
    .done(function(data) {
        if(data)
        {
            toastr.success("Se actualizaron los datos del Vehículo");
        }else
        {
            toastr.info("Hubo un error al actualizar los datos del Vehículo");
        }
    })
    .fail(function() {
        toastr.info("Hubo un error al actualizar los datos del cliente, favor de continuar...");
    });
}


function actualizar_listasOrden(form, elemento)
{
    form += "&tipo_elemento="+elemento;
    $.ajax({
        url: base_url+ "index.php/user/actualizar_datosOrden/",
        type: 'POST',
        dataType: 'json',
        data: form
    })
    .done(function(data) {
        //console.log(data);
        if(data)
        {
            toastr.success("Se actualizaron los datos de la orden");
        }else
        {
            toastr.info("Hubo un error al actualizar los datos de la orden, favor de continuar...");
        }
    })
    .fail(function() {
        toastr.info("Hubo un error al actualizar los datos de la orden, favor de continuar...");
    });
}

//Habilitar y deshabilitar boton de guardado de firmas a traves de check "terminos y condiciones"
$(document).on('click','#cb_termCond' ,function(e){
    if( val_checked("cb_termCond")  == true ){
        $('#btn_guardarFirma').attr('disabled', false);
    }
    else{
        $('#btn_guardarFirma').attr("disabled", true);
    }
});

//funcion para obtener valor de un check box sin value asignado
function val_checked(id_cbx) {
    var v = false;
    if( ( v = $("#"+ id_cbx +":checked").val() ) != null ){
        v = true;
    }
    return v;
}

/*Configuración de firma*/
$(document).on("click", '#mostrar_modalfirma', function (e){
    e.preventDefault();

    $("#modalfirma").modal("show");
});

/*Configuración de firma*/
$(document).on("click", '#mostrar_modalOasis', function (e){
    e.preventDefault();

    $("#modaloasis").modal("show");
});

// var firma = "";
// $(document).ready(function() {
//     var config = {
//         autoInit : true,       // Update any forms field with signature when loading the page
//         format : "image/png",  // Default signature image format
//         background : "#EEE",   // Default signature background
//         pen : "#000",          // Default signature pen color
//         penWidth : 1,          // Default signature pen width
//         border : "#AAA",       // Default signature pen border color
//         height : 200           // Default signature height in px
//     };

//     firma = $("#firma").jSignature(config);
// });

// firma = Formato profeco
var firma = "";
//firma2 = Formato de inventario
var firma2 = "";
//firma3 = Carta de renuncia a a la extensión de garantía
var firma3 = "";

// cada firma debe tener su propia config
$(document).ready(function() {
    var config = {
        autoFit : true,       // Update any forms field with signature when loading the page
        // format : "image/png",  // Default signature image format
        background : "#EEE",   // Default signature background
        lineColor : "#000",          // Default signature pen color
        lineWidth : 1,          // Default signature pen width
        border : "#AAA",       // Default signature pen border color
        height : 210           // Default signature height in px
    };

    firma = $("#firma").jqSignature(config);
});



$(document).ready(function() {
    var config = {
        autoFit : true,       // Update any forms field with signature when loading the page
        // format : "image/png",  // Default signature image format
        background : "#EEE",   // Default signature background
        lineColor : "#000",          // Default signature pen color
        lineWidth : 1,          // Default signature pen width
        border : "#AAA",       // Default signature pen border color
        height : 210           // Default signature height in px
    };

    firma2 = $("#firma2").jqSignature(config);
});


$(document).ready(function() {
    var config = {
        autoFit : true,       // Update any forms field with signature when loading the page
        // format : "image/png",  // Default signature image format
        background : "#EEE",   // Default signature background
        lineColor : "#000",          // Default signature pen color
        lineWidth : 1,          // Default signature pen width
        border : "#AAA",       // Default signature pen border color
        height : 210           // Default signature height in px
    };

    firma3 = $("#firma3").jqSignature(config);
});

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

    $("#valor_firma").val(firma.jqSignature("getDataURL"));
    $("#valor_firma2").val(firma2.jqSignature("getDataURL"));
    $("#valor_firma3").val(firma3.jqSignature("getDataURL"));


    var form = $("#formFirma").serialize();
    var cve_cliente = $("#id_cliente").val();
    var vin = $("#vin_cliente").val();
    var id_orden_servicio = localStorage.getItem("id_orden_servicio");
    var firma_vacia = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAakAAADSCAYAAADwvj/tAAAAAXNSR0IArs4c6QAAB/JJREFUeF7t1UENAAAMArHh3/Rs3KNTQMoSdo4AAQIECEQFFs0lFgECBAgQOCPlCQgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAgQee7QDT4w9urAAAAABJRU5ErkJggg==";

    form += "&cve_cliente="+cve_cliente;
    form += "&vin="+vin;
    form += "&id_orden_servicio="+id_orden_servicio;

    // variable que hablita la validacion de la firma de carta de garantia para ford
    validar_ext_garantia = true;

    // valor de check terminos y condiciones
    form += "&cb_termCond="+ val_checked("cb_termCond");
    
    // Si el elemento esta oculto deshabiltara la validacion para la carta de extension de garantía ford
    if ($('#pills-fExtGarantia-tab').is(':hidden')) {
       validar_ext_garantia = false;
    } 
    
    //variable que contiene el valor de seleccion del radio de extension de garantia
    var input_ext_garantia = $('input:radio[name=ext_garantia]:checked').val();


    if($("#valor_firma").val() == firma_vacia )
    {
        toastr.warning("La firma para el Formato profeco está vacía, favor de proporcionarla.");
    }
    else if( validar_ext_garantia && ($("#valor_firma3").val() == firma_vacia  && input_ext_garantia == 'no' ) ){
            toastr.warning("La firma para la Carta de renuncia a beneficios está vacía, favor de proporcionarla.",{timeOut: 7000});
    }
    else if($("#valor_firma2").val() == firma_vacia ){
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

//Funcion de leyenda Ver en modal firma_config para mostrar termins y condcions (contrato adehesion)
$(document).on('click','#ver_termCond' ,function(e){
    e.preventDefault();
    window.open(base_url+"index.php/servicio/correo_reverso/"+ localStorage.getItem("id_orden_servicio"), "_blank");
});

/*$(document).on("click", '#btn_guardarFirma2', function (e){
    e.preventDefault();

    $("#valor_firma2").val(firma.jqSignature("getDataURL"));

    var form = $("#formFirma").serialize();
    var cve_cliente = $("#id_cliente").val();
    var vin = $("#vin_cliente").val();
    var id_orden_servicio = localStorage.getItem("id_orden_servicio");
    var firma_vacia = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAyAAAADICAYAAAAQj4UaAAANEklEQVR4Xu3ZwVEkUQwFwcYo1p2xbdwBp9YEbhWCl5wnQr9TulTw8fgjQIAAAQIECBAgQIBAJPARzTGGAAECBAgQIECAAAECjwBxBAQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApnAVIC8Xq+v53k+M12DCBAgQIAAAQIECPws8P1+v//9/LO/8QsB8jf26CsIECBAgAABAgR+r4AA+b2783ICBAgQIECAAAECBC4LTP0H5PIivI0AAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARAQFyZBGeQYAAAQIECBAgQGBBQIAsbNk3EiBAgAABAgQIEDgiIECOLMIzCBAgQIAAAQIECCwICJCFLftGAgQIECBAgAABAkcEBMiRRXgGAQIECBAgQIAAgQUBAbKwZd9IgAABAgQIECBA4IiAADmyCM8gQIAAAQIECBAgsCAgQBa27BsJECBAgAABAgQIHBEQIEcW4RkECBAgQIAAAQIEFgQEyMKWfSMBAgQIECBAgACBIwIC5MgiPIMAAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARAQFyZBGeQYAAAQIECBAgQGBBQIAsbNk3EiBAgAABAgQIEDgiIECOLMIzCBAgQIAAAQIECCwICJCFLftGAgQIECBAgAABAkcEBMiRRXgGAQIECBAgQIAAgQUBAbKwZd9IgAABAgQIECBA4IiAADmyCM8gQIAAAQIECBAgsCAgQBa27BsJECBAgAABAgQIHBEQIEcW4RkECBAgQIAAAQIEFgQEyMKWfSMBAgQIECBAgACBIwIC5MgiPIMAAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARgf8OegrJcwoE6QAAAABJRU5ErkJggg==";

    form += "&cve_cliente="+cve_cliente;
    form += "&vin="+vin;
    form += "&id_orden_servicio="+id_orden_servicio;

    if($("#valor_firma2").val() == firma_vacia)
    {
        toastr.error("La firma está vacía, favor de proporcionarla.");
    }else 
    {
        $.ajax({
            cache: false,
            url: base_url+ "user/guardar_firma/",
            type: 'POST',
            dataType: 'json',
            data: form,
            beforeSend: function(){
                toastr.info("Guardando la firma, por favor, espere un momento.");
                $("#loading_spin").show();
            }
        })
        .done(function(data) {
            if(data)
            {
                toastr.success("Se ha guardado la firma del Cliente.");

                $("#loading_spin").hide();

                $("#modalfirma").modal("hide");
            }else
            {
                toastr.error("Hubo un error al guardar la firma del Cliente.");
            }
        })
        .fail(function() {
            alert("Hubo un error al guardar la firma");
        }); 
    }
});*/

// $(document).on("click", '#btn_guardarFirma', function (e){
//     e.preventDefault();

//     $("#valor_firma").val(firma.jSignature("getData"));

//     var form = $("#formFirma").serialize();
//     var cve_cliente = $("#id_cliente").val();
//     var vin = $("#vin_cliente").val();
//     var id_orden_servicio = localStorage.getItem("id_orden_servicio");
//     var firma_vacia = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAyAAAADICAYAAAAQj4UaAAANEklEQVR4Xu3ZwVEkUQwFwcYo1p2xbdwBp9YEbhWCl5wnQr9TulTw8fgjQIAAAQIECBAgQIBAJPARzTGGAAECBAgQIECAAAECjwBxBAQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApnAVIC8Xq+v53k+M12DCBAgQIAAAQIECPws8P1+v//9/LO/8QsB8jf26CsIECBAgAABAgR+r4AA+b2783ICBAgQIECAAAECBC4LTP0H5PIivI0AAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARAQFyZBGeQYAAAQIECBAgQGBBQIAsbNk3EiBAgAABAgQIEDgiIECOLMIzCBAgQIAAAQIECCwICJCFLftGAgQIECBAgAABAkcEBMiRRXgGAQIECBAgQIAAgQUBAbKwZd9IgAABAgQIECBA4IiAADmyCM8gQIAAAQIECBAgsCAgQBa27BsJECBAgAABAgQIHBEQIEcW4RkECBAgQIAAAQIEFgQEyMKWfSMBAgQIECBAgACBIwIC5MgiPIMAAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARAQFyZBGeQYAAAQIECBAgQGBBQIAsbNk3EiBAgAABAgQIEDgiIECOLMIzCBAgQIAAAQIECCwICJCFLftGAgQIECBAgAABAkcEBMiRRXgGAQIECBAgQIAAgQUBAbKwZd9IgAABAgQIECBA4IiAADmyCM8gQIAAAQIECBAgsCAgQBa27BsJECBAgAABAgQIHBEQIEcW4RkECBAgQIAAAQIEFgQEyMKWfSMBAgQIECBAgACBIwIC5MgiPIMAAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARgf8OegrJcwoE6QAAAABJRU5ErkJggg==";

//     form += "&cve_cliente="+cve_cliente;
//     form += "&vin="+vin;
//     form += "&id_orden_servicio="+id_orden_servicio;

//     if($("#valor_firma").val() == firma_vacia)
//     {
//         toastr.error("La firma está vacía, favor de proporcionarla.");
//     }else 
//     {
//         $.ajax({
//             cache: false,
//             url: base_url+ "user/guardar_firma/",
//             type: 'POST',
//             dataType: 'json',
//             data: form,
//             beforeSend: function(){
//                 toastr.info("Guardando la firma, por favor, espere un momento.");
//                 $("#loading_spin").show();
//             }
//         })
//         .done(function(data) {
//             if(data)
//             {
//                 toastr.success("Se ha guardado la firma del Cliente.");

//                 $("#loading_spin").hide();

//                 $("#modalfirma").modal("hide");
//             }else
//             {
//                 toastr.error("Hubo un error al guardar la firma del Cliente.");
//             }
//         })
//         .fail(function() {
//             alert("Hubo un error al guardar la firma");
//         }); 
//     }
// });

/*Capturar Fotos*/
$(document).on("click", '#mostrar_modalfotos', function (e){
    e.preventDefault();

    $("#modalfotos").modal("show");
});

// $(document).on("change", '#cameraInput', function (e){
//     e.preventDefault();
//     var fileReader = new FileReader();

//     fileReader.onload = function (evt) {
//         var data = fileReader.result;  // data <-- in this var you have the file data in Base64 format
//         $('#vista_previa').attr('src',evt.target.result);
//         $("#input_vista_previa").val(evt.target.result);
//     };

//     fileReader.readAsDataURL($('#cameraInput').prop('files')[0]);
// });

//cambio para adjuntar más fotos

$(document).on("change", "#cameraInput", function(event){
    var total_img = $(this)[0].files.length;
    var total_selecc = $("#pictures_orden_recepcion").children("img.img-fluid.vista_previa").length;
    total_selecc += 1;
    var cant_max = 15;
    
    if(total_img <= cant_max && total_selecc <= cant_max && (total_img+total_selecc) <= (cant_max+1))
    {
    	for(var i = 0; i < total_img; i++)
	    {
	        optimizar_imagen(event, i);
	    }
    }else 
    {
    	toastr.error("No es posible agregar más imágenes, se ha alcanzado el límite máximo permitido: " + cant_max);
    	return;
    }
});

/*function readmultifiles(files) {
    for (var i = 0; i < files.length; i++) { //for multiple files          
        (function(file) {
            var name = file.name;
            var reader = new FileReader();  
            reader.onload = function(e) {  
                var data = reader.result;  // data <-- in this var you have the file data in Base64 format
                $('.coloca').append('<input type="hidden" name="input_vista_previa[]" class="new_image" id="input_vista_previa" value="'+e.target.result+'">');
                $('.coloca').append('<img src="'+e.target.result+'" name="vista_previa" class="img-fluid vista_previa" style="display: inline-block; margin: 2 auto;  border: 1px solid #ddd;border-radius: 4px;padding: 5px;max-width: 150px;max-height:100px;"><span class="remove-imagenes" data-id="0" style="cursor:pointer;top:-33px; margin-left:-29px; background-color:rgba(255,0,0,0.8);position:relative;padding:9px;"><i class="fa fa-trash" style="color:#fff"></i></span>');
            }
            reader.readAsDataURL(file);
        })(files[i]);
    }
}*/

function optimizar_imagen(e, indice)
{
    //const width = 880;
    var maxWidth = 960;
    var maxHeight = 720;

    var fileName = e.target.files[indice].name;
    var reader = new FileReader(); 								//Se crea instancia de FileReader Js API
    reader.readAsDataURL(e.target.files[indice]);					//Lee la imagen que está en el input usando el FileReader
    reader.onload = event => {
        var img = new Image();									//Se crea una nueva instancia de la clase Image
        img.src = event.target.result;								//Asignar al source de la imagen el resultado del FileReader
        img.onload = () => {
                var elem = document.createElement('canvas');		//Crear un elemento Canvas HTML5
                // const scaleFactor = width / img.width;				//Para mantener la relación de aspecto se pone el ancho como constante
                // elem.width = width;
                // elem.height = img.height * scaleFactor;
                var rectRatio = img.width / img.height;
                var boundsRatio = maxWidth / maxHeight;
                var w, h;
                if (rectRatio > boundsRatio) {
                    w = maxWidth;
                    h = img.height * (maxWidth / img.width);
                } else {
                    w = img.width * (maxHeight / img.height);
                    h = maxHeight;
                }
                elem.width = w;
                elem.height = h;

                var ctx = elem.getContext('2d');					//Crea objeto para dibujar en el Canvas
                ctx.drawImage(img, 0, 0, w, h);	//Dibuja el elemento en el Canvas
                ctx.canvas.toBlob((blob) => {					    //Retorna la imagen como un blob 							
                	convertir_blobFileToBase64(blob);
                }, 'image/jpeg', 1);               
            },
            reader.onerror = error => toastr.error("Hubo un error al leer el archivo "+error);
    };
}

function convertir_blobFileToBase64(blob)
{
    var reader = new FileReader();
    var base64data = "";

    reader.readAsDataURL(blob); 
    reader.onloadend = function() {
        base64data = reader.result;
        agregar_img(base64data);
    }

    return base64data;
}

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

function agregar_img(img)
{
    $('.coloca').append('<input type="hidden" name="input_vista_previa[]" class="new_image" id="input_vista_previa" value="'+img+'">');
    $('.coloca').append('<img src="'+img+'" name="vista_previa" class="img-fluid vista_previa" style="display: inline-block; margin: 2 auto;  border: 1px solid #ddd;border-radius: 4px;padding: 5px;max-width: 150px;max-height:100px;"><span class="remove-imagenes" data-id="0" style="cursor:pointer;top:-33px; margin-left:-29px; background-color:rgba(255,0,0,0.8);position:relative;padding:9px;"><i class="fa fa-trash" style="color:#fff"></i></span>');
}

// <!-- cambio para adjuntar más fotos -->
$(document).off("click", '.vista_previa').on("click", '.vista_previa', function (e){
    var img = $(this).clone();
    var img_type = img.attr("src");
    $('#vista_previa').attr('src',img_type);
    //$('#show-image').html('<img src="'+img_type+'" name="vista_previa" class="img-fluid" style="display: inline-block; margin: 0 auto;  border: 1px solid #ddd;border-radius: 4px;padding: 5px;width: 100%;">');
});

//<!-- cambio para adjuntar más fotos -->
$(document).off("click", '.remove-imagenes').on("click", '.remove-imagenes', function (e){
    var id_imagen_remover=$(this).attr("data-id");
    if(id_imagen_remover!=0){
        $(this).prev().prev().addClass("quitar");
        //$(this).prev().prev().attr('name', "imagen_quitar[]" );
        $('#vista_previa').attr('src', "");
    }else{
        $(this).prev().prev().remove();
    }
    $(this).prev().remove();
    $(this).remove();
    
});



$(document).on("click", '#btn_guardarFoto', function (e){
    e.preventDefault();
    var data = new FormData();
    var cve_cliente = $("#id_cliente").val();
    var vin = $("#vin_cliente").val();
    var id_orden_servicio = localStorage.getItem("id_orden_servicio");
    var img_selecc = $("img.img-fluid.vista_previa");
     //reemplaza vins que tengan puntos o espacios pero no afecta el campo en la BD
     vin = vin.replace(".", "");
     vin = vin.replace(" ", "");

    $.each(img_selecc, function(index, val)
    {
        var file = base64toFile(val["src"], "imagen-"+(index+1));
        data.append("imagen-"+(index+1), file);
    });
    data.append("cve_cliente", cve_cliente);
    data.append("vin", vin);
    data.append("id_orden_servicio", id_orden_servicio);
    data.append("form_foto_f",$("#foto_comentario").val());

    if($("#input_vista_previa").val() == "")
    {
        toastr.error("No se ha capturado ninguna fotografía.");
    }else 
    {
        //console.log(form.length);
        guardar_imagen(data);
    }
});

function guardar_imagen(form)
{
    $.ajax({
        cache: false,
        url: base_url+ "index.php/user/guardar_archivo/",
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        data: form,
        beforeSend: function(){
            toastr.info("Guardando la(s) fotografía(s), por favor, espere un momento.");
            $("#loading_spin").show();
        }
    })
    .done(function(dat) {
        if(dat)
        {
            toastr.success("Se han guardado la(s) fotografía(s).");
			set_totalFots();
            borrar_captura();
            $(".coloca").empty();
        }else
        {
            toastr.error("Hubo un error al guardar la(s) fotografía(s).");
        }
    })
    .fail(function() {
        alert("Hubo un error al guardar la(s) fotografía(s)");
        $("#loading_spin").hide();
    });
}

$(document).on("click", '#btn_borrarFoto', function (e){
    e.preventDefault();
    //borrar_captura();
    $('#vista_previa').attr('src', "");
});

function set_totalFots() {    
            $.ajax({
            cache: false,
            type: 'post',
            url: base_url+ "index.php/user/total_fotos",
            dataType: "json",
            data: ({ id_orden_servicio: localStorage.getItem("id_orden_servicio") }),
            success: function(data){
                    //console.log(data);
                    var texto = "Total de fotos capturadas: "+ data;
                    $("#totalFots").text(texto);
            },
            error: function(){
                console.log('error al consultar total de fotos funcion : set_totalFots()');
            }
        });
}

function borrar_captura()
{
    $('#vista_previa').attr('src', "");
    $("#cameraInput, #input_vista_previa, #foto_comentario").val("");
    $("#loading_spin").hide();
}

/*Modal correo*/
$(document).on("click", '#mostrar_modalemail', function (e){
    e.preventDefault();
    var mail = $("#correo_cliente").val();
    $("#email_envio").val(mail);
    $("#modalsendmail").modal("show");
});

/*Modal de sonido*/
$(document).on("click", '#mostrar_modalsonido', function (e){
    e.preventDefault();

    $("#modalsonido").modal("show");
});

/*Inspección*/
$(document).on("click", "#btn_resetImgInsp", function(e){
    e.preventDefault();
    var options = {
        brushColor:"rgb(255,0,0)",
        backgroundImage: base_url+"assets/img/canvas/car_demo.png",
    };
    
    $("#canvasid").data("jqScribble").clear();
    $("#canvasid").data("jqScribble").update(options);
});

function guardar_imgInsp()
{
    var img_insp = "";

    $("#canvasid").data("jqScribble").save(function(imageData){
        img_insp = imageData;
        $("#img_insp").val(img_insp);
    });
}

$(document).on("click", "#btn_guardarInspeccion", function(e){
    e.preventDefault();
    var form = "";

    $.ajax({
        cache: false,
        url: guardar_imgInsp()
    })
    .done(function() {
        // var existen_danios = ($("#existen_danios").val() == "on") ? "No"  : "Si";
        //form = $("#form_inspeccion_servicio").serialize();
        //form += "&id_orden="+localStorage.getItem("id_orden_servicio");
		id_orden = localStorage.getItem("id_orden_servicio");
        $.ajax({
            cache: false,
            url: base_url+ "index.php/servicio/guardar_inspeccion/"+id_orden,
            type: 'POST',
            dataType: 'json',
            data: $('#form_inspeccion_servicio').serialize(),
            beforeSend: function(){
                toastr.info("Guardando la inspección del vehículo, espere un momento, por favor.");
                $("#loading_spin").show();
            }
        })
        .done(function(data) {
            if(data)
            {
                toastr.success("Se ha guardado la inspección.");
                $("#loading_spin").hide();
                
                $("#ok_nextwo").show();
            }else
            {
                toastr.error("Hubo un error al guardar la información.");
            }
        })
        .fail(function() {
            alert("Hubo un error, vuelva a intentarlo.");
        });

    })
    .fail(function() {
        alert("Hubo un error al guardar la inspección");
    });  
});

/*Email*/
/*$(document).off("click", "#send_mail").on("click", '#send_mail', function (e){
    e.preventDefault();
    
    toastr.info("Enviando la orden por correo, esto podría tardar un momento, por favor, espere la notificación de envío", {timeOut: 120000});

    //Formato orden servicio
    var url_formato = $("#url_formato").val();
    url_formato += "/"+localStorage.getItem("id_orden_servicio");
    var url_correo = $("#url_correo").val();
    url_correo += "/"+localStorage.getItem("id_orden_servicio");
    var url_reverso = $("#url_reversoformato").val();
    url_reverso += "/"+localStorage.getItem("id_orden_servicio");
    var url_formato_multipunto = $("#url_formato_multipunto").val();
    url_formato_multipunto += "/"+localStorage.getItem("id_orden_servicio");
     
    var img = ""; 
    var img2 ="";
    var img_correo = "";
    var bandera = true;

    $("#iframe_formato, #iframe_correo, #iframe_reversoformato, #iframe_formato_multipunto").off("load").on("load", function (){
        setTimeout(function(){
            img = localStorage.getItem("formato_base64");
            img2 = localStorage.getItem("hoja_multipuntos");
            img_correo = localStorage.getItem("correo_base64");
            img_reverso = localStorage.getItem("formatoReverso_base64");

            if(bandera)
            {
                enviar_correo(img,img2, img_correo, img_reverso);
            }
            bandera = false;
        }, 1000);
    });

    var firma_vacia = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAyAAAADICAYAAAAQj4UaAAANEklEQVR4Xu3ZwVEkUQwFwcYo1p2xbdwBp9YEbhWCl5wnQr9TulTw8fgjQIAAAQIECBAgQIBAJPARzTGGAAECBAgQIECAAAECjwBxBAQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApnAVIC8Xq+v53k+M12DCBAgQIAAAQIECPws8P1+v//9/LO/8QsB8jf26CsIECBAgAABAgR+r4AA+b2783ICBAgQIECAAAECBC4LTP0H5PIivI0AAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARAQFyZBGeQYAAAQIECBAgQGBBQIAsbNk3EiBAgAABAgQIEDgiIECOLMIzCBAgQIAAAQIECCwICJCFLftGAgQIECBAgAABAkcEBMiRRXgGAQIECBAgQIAAgQUBAbKwZd9IgAABAgQIECBA4IiAADmyCM8gQIAAAQIECBAgsCAgQBa27BsJECBAgAABAgQIHBEQIEcW4RkECBAgQIAAAQIEFgQEyMKWfSMBAgQIECBAgACBIwIC5MgiPIMAAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARAQFyZBGeQYAAAQIECBAgQGBBQIAsbNk3EiBAgAABAgQIEDgiIECOLMIzCBAgQIAAAQIECCwICJCFLftGAgQIECBAgAABAkcEBMiRRXgGAQIECBAgQIAAgQUBAbKwZd9IgAABAgQIECBA4IiAADmyCM8gQIAAAQIECBAgsCAgQBa27BsJECBAgAABAgQIHBEQIEcW4RkECBAgQIAAAQIEFgQEyMKWfSMBAgQIECBAgACBIwIC5MgiPIMAAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARgf8OegrJcwoE6QAAAABJRU5ErkJggg==";

    setTimeout(function(){
        if($("#valor_firma").val() == firma_vacia || $("#valor_firma").val() == "")
        {
            toastr.error("Es necesario tener la firma del Cliente para enviar el correo.");
        }else 
        {
            $("#iframe_correo").prop("src", url_correo);
            $("#iframe_formato").prop("src", url_formato);
            $("#iframe_reversoformato").prop("src", url_reverso);
            $("#iframe_formato_multipunto").prop("src", url_formato_multipunto);
        } 
    }, 1000);
});*/
function reset_formatos()
{
    localStorage.setItem("formato_base64", "");             //profeco
    sessionStorage.setItem("formato_inventario", "");       //inventario
    localStorage.setItem("correo_base64", "");              //img correo
    localStorage.setItem("formatoReverso_base64", "");      //reverso profeco
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

function enviar_correo( img, img2, img_correo, img_reverso, img3)
{
    var email = $("#email_envio").val();
    var cliente = $("#nombre_cliente").val();
    var id_orden = localStorage.getItem("id_orden_servicio");

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

$(document).off("click", "#send_mail").on("click", '#send_mail', function (e){
    e.preventDefault();
    
    reset_formatos();

    //Formato orden servicio
    var url_formato = $("#url_formato").val();
    url_formato += "/"+localStorage.getItem("id_orden_servicio");
    var url_correo = $("#url_correo").val();
    url_correo += "/"+localStorage.getItem("id_orden_servicio");
    var url_reverso = $("#url_reversoformato").val();
    url_reverso += "/"+localStorage.getItem("id_orden_servicio");
    var url_formato_multipunto = $("#url_formato_multipunto").val();
    url_formato_multipunto += "/"+localStorage.getItem("id_orden_servicio");
    var url_inventario = $("#url_inventario").val();
    url_inventario += "/"+localStorage.getItem("id_orden_servicio");

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
    var firma_vacia2 = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZAAAADICAYAAADGFbfiAAAHFklEQVR4Xu3VsQ0AAAjDMPr/0/yQ2exdLKTsHAECBAgQCAILGxMCBAgQIHAC4gkIECBAIAkISGIzIkCAAAEB8QMECBAgkAQEJLEZESBAgICA+AECBAgQSAICktiMCBAgQEBA/AABAgQIJAEBSWxGBAgQICAgfoAAAQIEkoCAJDYjAgQIEBAQP0CAAAECSUBAEpsRAQIECAiIHyBAgACBJCAgic2IAAECBATEDxAgQIBAEhCQxGZEgAABAgLiBwgQIEAgCQhIYjMiQIAAAQHxAwQIECCQBAQksRkRIECAgID4AQIECBBIAgKS2IwIECBAQED8AAECBAgkAQFJbEYECBAgICB+gAABAgSSgIAkNiMCBAgQEBA/QIAAAQJJQEASmxEBAgQICIgfIECAAIEkICCJzYgAAQIEBMQPECBAgEASEJDEZkSAAAECAuIHCBAgQCAJCEhiMyJAgAABAfEDBAgQIJAEBCSxGREgQICAgPgBAgQIEEgCApLYjAgQIEBAQPwAAQIECCQBAUlsRgQIECAgIH6AAAECBJKAgCQ2IwIECBAQED9AgAABAklAQBKbEQECBAgIiB8gQIAAgSQgIInNiAABAgQExA8QIECAQBIQkMRmRIAAAQIC4gcIECBAIAkISGIzIkCAAAEB8QMECBAgkAQEJLEZESBAgICA+AECBAgQSAICktiMCBAgQEBA/AABAgQIJAEBSWxGBAgQICAgfoAAAQIEkoCAJDYjAgQIEBAQP0CAAAECSUBAEpsRAQIECAiIHyBAgACBJCAgic2IAAECBATEDxAgQIBAEhCQxGZEgAABAgLiBwgQIEAgCQhIYjMiQIAAAQHxAwQIECCQBAQksRkRIECAgID4AQIECBBIAgKS2IwIECBAQED8AAECBAgkAQFJbEYECBAgICB+gAABAgSSgIAkNiMCBAgQEBA/QIAAAQJJQEASmxEBAgQICIgfIECAAIEkICCJzYgAAQIEBMQPECBAgEASEJDEZkSAAAECAuIHCBAgQCAJCEhiMyJAgAABAfEDBAgQIJAEBCSxGREgQICAgPgBAgQIEEgCApLYjAgQIEBAQPwAAQIECCQBAUlsRgQIECAgIH6AAAECBJKAgCQ2IwIECBAQED9AgAABAklAQBKbEQECBAgIiB8gQIAAgSQgIInNiAABAgQExA8QIECAQBIQkMRmRIAAAQIC4gcIECBAIAkISGIzIkCAAAEB8QMECBAgkAQEJLEZESBAgICA+AECBAgQSAICktiMCBAgQEBA/AABAgQIJAEBSWxGBAgQICAgfoAAAQIEkoCAJDYjAgQIEBAQP0CAAAECSUBAEpsRAQIECAiIHyBAgACBJCAgic2IAAECBATEDxAgQIBAEhCQxGZEgAABAgLiBwgQIEAgCQhIYjMiQIAAAQHxAwQIECCQBAQksRkRIECAgID4AQIECBBIAgKS2IwIECBAQED8AAECBAgkAQFJbEYECBAgICB+gAABAgSSgIAkNiMCBAgQEBA/QIAAAQJJQEASmxEBAgQICIgfIECAAIEkICCJzYgAAQIEBMQPECBAgEASEJDEZkSAAAECAuIHCBAgQCAJCEhiMyJAgAABAfEDBAgQIJAEBCSxGREgQICAgPgBAgQIEEgCApLYjAgQIEBAQPwAAQIECCQBAUlsRgQIECAgIH6AAAECBJKAgCQ2IwIECBAQED9AgAABAklAQBKbEQECBAgIiB8gQIAAgSQgIInNiAABAgQExA8QIECAQBIQkMRmRIAAAQIC4gcIECBAIAkISGIzIkCAAAEB8QMECBAgkAQEJLEZESBAgICA+AECBAgQSAICktiMCBAgQEBA/AABAgQIJAEBSWxGBAgQICAgfoAAAQIEkoCAJDYjAgQIEBAQP0CAAAECSUBAEpsRAQIECAiIHyBAgACBJCAgic2IAAECBATEDxAgQIBAEhCQxGZEgAABAgLiBwgQIEAgCQhIYjMiQIAAAQHxAwQIECCQBAQksRkRIECAgID4AQIECBBIAgKS2IwIECBAQED8AAECBAgkAQFJbEYECBAgICB+gAABAgSSgIAkNiMCBAgQEBA/QIAAAQJJQEASmxEBAgQICIgfIECAAIEkICCJzYgAAQIEBMQPECBAgEASEJDEZkSAAAECAuIHCBAgQCAJCEhiMyJAgAABAfEDBAgQIJAEBCSxGREgQICAgPgBAgQIEEgCApLYjAgQIEBAQPwAAQIECCQBAUlsRgQIECAgIH6AAAECBJKAgCQ2IwIECBAQED9AgAABAklAQBKbEQECBAgIiB8gQIAAgSQgIInNiAABAgQExA8QIECAQBIQkMRmRIAAAQIC4gcIECBAIAkISGIzIkCAAAEB8QMECBAgkAQEJLEZESBAgICA+AECBAgQSAICktiMCBAgQOABB1wAyWjdfzMAAAAASUVORK5CYII="

    setTimeout(function(){
        if($("#valor_firma").val() == firma_vacia || $("#valor_firma").val() == firma_vacia2 || $("#valor_firma").val() == "" || $("#valor_firma2").val() == firma_vacia || $("#valor_firma2").val() == firma_vacia2 || $("#valor_firma2").val() == "")
        {
            toastr.error("Es necesario tener las firmas del Cliente para enviar el correo.");
        }else 
        {
            toastr.info("Enviando la orden por correo, esto podría tardar un momento, por favor, espere la notificación de envío", {timeOut: 120000});
            
            $("#iframe_correo").prop("src", url_correo);
            $("#iframe_formato").prop("src", url_formato);
            $("#iframe_reversoformato").prop("src", url_reverso);
            $("#iframe_inventario").prop("src", url_inventario);
            $("#iframe_formato_multipunto").prop("src", url_formato_multipunto);
        } 
    }, 1000);
});

/*Pdf*/
var b_profeco = false;
function generar_formato(id_orden)
{
    var url_formato = $("#url_formato").val();
    url_formato += "/"+id_orden;
    var url_reverso = $("#url_reversoformato").val();
    url_reverso += "/"+id_orden;
    var img = "";
    var img_reverso = "";
    var bandera = true;

    $("#iframe_formato").prop("src", url_formato);                                                  //1ero se ejecuta esto
    $("#iframe_reversoformato").prop("src", url_reverso);

    $("#iframe_formato, #iframe_reversoformato").off("load").on("load", function (){                //luego se ejecuta esto
        
        setTimeout(function(){               
            if(bandera)                                                         //para que se ejecute solo 1 vez, no por cada iframe
            {                   
                revisar_creacionImg(id_orden);
            }

            bandera = false;
        }, 800);        
    });
}
//se cambia a esta funcion para poder generar el fomato profeco ok al finalizar la or
function generar_formatoProfeco(id_orden)
{   
    window.open(base_url+"index.php/servicio/profeco_print/"+ id_orden, "_blank");
    $("#enviar_whatsapp").show();
    $("#loading_spin").hide();
    b_profeco = false;
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

function generar_pdf(img_formato, img_reverso, id_orden)
{
    // var id_orden = localStorage.getItem("id_orden_servicio");
    var fecha_actual = new Date();
    var doc = new jsPDF("p", "mm", "letter", true);
    var width = 0;
    var height = 0;

    width = doc.internal.pageSize.width;    
    height = doc.internal.pageSize.height;

    doc.addImage(img_formato, 'PNG', 0, 0, width, height, undefined, 'FAST');
    doc.addPage();
    doc.addImage(img_reverso, 'PNG', 0, 0, width, height, undefined, 'FAST');
    doc.save('OrdenServicio'+id_orden+'.pdf');
    $("#enviar_whatsapp").show();
    
    $("#loading_spin").hide();
    b_profeco = false;
}

$(document).off("click", "#generar_pdf").on("click", "#generar_pdf", function(e){
    e.preventDefault();
    $.confirm({
        title: 'Generar Archivo PDF',
        content: '¿Desea generar el archivo PDF de la Orden de Servicio?',
        buttons: {
            Cancelar: function () {
                //
            },
            Aceptar: function () {
                if(b_profeco == false)
                {
                    var firma_vacia = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAyAAAADICAYAAAAQj4UaAAANEklEQVR4Xu3ZwVEkUQwFwcYo1p2xbdwBp9YEbhWCl5wnQr9TulTw8fgjQIAAAQIECBAgQIBAJPARzTGGAAECBAgQIECAAAECjwBxBAQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApnAVIC8Xq+v53k+M12DCBAgQIAAAQIECPws8P1+v//9/LO/8QsB8jf26CsIECBAgAABAgR+r4AA+b2783ICBAgQIECAAAECBC4LTP0H5PIivI0AAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARAQFyZBGeQYAAAQIECBAgQGBBQIAsbNk3EiBAgAABAgQIEDgiIECOLMIzCBAgQIAAAQIECCwICJCFLftGAgQIECBAgAABAkcEBMiRRXgGAQIECBAgQIAAgQUBAbKwZd9IgAABAgQIECBA4IiAADmyCM8gQIAAAQIECBAgsCAgQBa27BsJECBAgAABAgQIHBEQIEcW4RkECBAgQIAAAQIEFgQEyMKWfSMBAgQIECBAgACBIwIC5MgiPIMAAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARAQFyZBGeQYAAAQIECBAgQGBBQIAsbNk3EiBAgAABAgQIEDgiIECOLMIzCBAgQIAAAQIECCwICJCFLftGAgQIECBAgAABAkcEBMiRRXgGAQIECBAgQIAAgQUBAbKwZd9IgAABAgQIECBA4IiAADmyCM8gQIAAAQIECBAgsCAgQBa27BsJECBAgAABAgQIHBEQIEcW4RkECBAgQIAAAQIEFgQEyMKWfSMBAgQIECBAgACBIwIC5MgiPIMAAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARgf8OegrJcwoE6QAAAABJRU5ErkJggg==";
                    var firma_vacia2 = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZAAAADICAYAAADGFbfiAAAHFklEQVR4Xu3VsQ0AAAjDMPr/0/yQ2exdLKTsHAECBAgQCAILGxMCBAgQIHAC4gkIECBAIAkISGIzIkCAAAEB8QMECBAgkAQEJLEZESBAgICA+AECBAgQSAICktiMCBAgQEBA/AABAgQIJAEBSWxGBAgQICAgfoAAAQIEkoCAJDYjAgQIEBAQP0CAAAECSUBAEpsRAQIECAiIHyBAgACBJCAgic2IAAECBATEDxAgQIBAEhCQxGZEgAABAgLiBwgQIEAgCQhIYjMiQIAAAQHxAwQIECCQBAQksRkRIECAgID4AQIECBBIAgKS2IwIECBAQED8AAECBAgkAQFJbEYECBAgICB+gAABAgSSgIAkNiMCBAgQEBA/QIAAAQJJQEASmxEBAgQICIgfIECAAIEkICCJzYgAAQIEBMQPECBAgEASEJDEZkSAAAECAuIHCBAgQCAJCEhiMyJAgAABAfEDBAgQIJAEBCSxGREgQICAgPgBAgQIEEgCApLYjAgQIEBAQPwAAQIECCQBAUlsRgQIECAgIH6AAAECBJKAgCQ2IwIECBAQED9AgAABAklAQBKbEQECBAgIiB8gQIAAgSQgIInNiAABAgQExA8QIECAQBIQkMRmRIAAAQIC4gcIECBAIAkISGIzIkCAAAEB8QMECBAgkAQEJLEZESBAgICA+AECBAgQSAICktiMCBAgQEBA/AABAgQIJAEBSWxGBAgQICAgfoAAAQIEkoCAJDYjAgQIEBAQP0CAAAECSUBAEpsRAQIECAiIHyBAgACBJCAgic2IAAECBATEDxAgQIBAEhCQxGZEgAABAgLiBwgQIEAgCQhIYjMiQIAAAQHxAwQIECCQBAQksRkRIECAgID4AQIECBBIAgKS2IwIECBAQED8AAECBAgkAQFJbEYECBAgICB+gAABAgSSgIAkNiMCBAgQEBA/QIAAAQJJQEASmxEBAgQICIgfIECAAIEkICCJzYgAAQIEBMQPECBAgEASEJDEZkSAAAECAuIHCBAgQCAJCEhiMyJAgAABAfEDBAgQIJAEBCSxGREgQICAgPgBAgQIEEgCApLYjAgQIEBAQPwAAQIECCQBAUlsRgQIECAgIH6AAAECBJKAgCQ2IwIECBAQED9AgAABAklAQBKbEQECBAgIiB8gQIAAgSQgIInNiAABAgQExA8QIECAQBIQkMRmRIAAAQIC4gcIECBAIAkISGIzIkCAAAEB8QMECBAgkAQEJLEZESBAgICA+AECBAgQSAICktiMCBAgQEBA/AABAgQIJAEBSWxGBAgQICAgfoAAAQIEkoCAJDYjAgQIEBAQP0CAAAECSUBAEpsRAQIECAiIHyBAgACBJCAgic2IAAECBATEDxAgQIBAEhCQxGZEgAABAgLiBwgQIEAgCQhIYjMiQIAAAQHxAwQIECCQBAQksRkRIECAgID4AQIECBBIAgKS2IwIECBAQED8AAECBAgkAQFJbEYECBAgICB+gAABAgSSgIAkNiMCBAgQEBA/QIAAAQJJQEASmxEBAgQICIgfIECAAIEkICCJzYgAAQIEBMQPECBAgEASEJDEZkSAAAECAuIHCBAgQCAJCEhiMyJAgAABAfEDBAgQIJAEBCSxGREgQICAgPgBAgQIEEgCApLYjAgQIEBAQPwAAQIECCQBAUlsRgQIECAgIH6AAAECBJKAgCQ2IwIECBAQED9AgAABAklAQBKbEQECBAgIiB8gQIAAgSQgIInNiAABAgQExA8QIECAQBIQkMRmRIAAAQIC4gcIECBAIAkISGIzIkCAAAEB8QMECBAgkAQEJLEZESBAgICA+AECBAgQSAICktiMCBAgQEBA/AABAgQIJAEBSWxGBAgQICAgfoAAAQIEkoCAJDYjAgQIEBAQP0CAAAECSUBAEpsRAQIECAiIHyBAgACBJCAgic2IAAECBATEDxAgQIBAEhCQxGZEgAABAgLiBwgQIEAgCQhIYjMiQIAAAQHxAwQIECCQBAQksRkRIECAgID4AQIECBBIAgKS2IwIECBAQED8AAECBAgkAQFJbEYECBAgICB+gAABAgSSgIAkNiMCBAgQEBA/QIAAAQJJQEASmxEBAgQICIgfIECAAIEkICCJzYgAAQIEBMQPECBAgEASEJDEZkSAAAECAuIHCBAgQCAJCEhiMyJAgAABAfEDBAgQIJAEBCSxGREgQICAgPgBAgQIEEgCApLYjAgQIEBAQPwAAQIECCQBAUlsRgQIECAgIH6AAAECBJKAgCQ2IwIECBAQED9AgAABAklAQBKbEQECBAgIiB8gQIAAgSQgIInNiAABAgQExA8QIECAQBIQkMRmRIAAAQIC4gcIECBAIAkISGIzIkCAAAEB8QMECBAgkAQEJLEZESBAgICA+AECBAgQSAICktiMCBAgQOABB1wAyWjdfzMAAAAASUVORK5CYII="
                    
                    if($("#valor_firma").val() == firma_vacia || $("#valor_firma").val() == "" || $("#valor_firma").val() == firma_vacia2)
                    {
                        toastr.error("Es necesario tener la firma del Cliente para generar el archivo PDF.");
                    }else 
                    {
                        var id_orden = localStorage.getItem("id_orden_servicio");           //se genera en el buscador al crear una nueva
                        b_profeco = true;
                        localStorage.setItem("formato_base64", "");
                        localStorage.setItem("formatoReverso_base64", "");
                                                         
                        $("#loading_spin").show();
                        generar_formatoProfeco(id_orden);
                    }                   
                }else 
                {
                    toastr.info("Por favor, espere un momento, mientras termina la generación del formato");
                }
            }
        }
    });
});

/*Enviar Whatsapp*/
$(document).on("click", '#enviar_whatsapp', function (e){
    e.preventDefault();

    var id_orden = localStorage.getItem("id_orden_servicio");
    var cliente = localStorage.getItem("nom_cliente")+" "+localStorage.getItem("ap_cliente");
    var codigo_area = "521";                                                                   // equivale al +52 1 xxxxxxxxxx
    var num_cel = $("#cel_cliente").val();
    var hora_actual = moment().format("HH:mm");
    var texto = "";
    var saludo = "";
    var whatsapp_url = "";

    $.confirm({
        title: 'Enviar WhatsApp al Cliente',
        content: '' +
        '<form action="" class="formName">' +
        '<div class="form-group">' +
        '<p>¿Desea enviar un mensaje de WhatsApp al Cliente con los datos de su Orden de Servicio?</p>' +
        '<label>Número Tel. Celular del Cliente:</label>' +
        '<input type="text" placeholder="Celular" class="numero form-control" value="'+num_cel+'" required />' +
        '</div>' +
        '</form>',
        buttons: {
            Cancelar: function () {
                //close
            },
            formSubmit: {
                text: 'Enviar',
                btnClass: 'btn-blue',
                action: function () {
                    var numero = this.$content.find('.numero').val();

                    if(!numero){
                        $.alert("Por favor, escriba el número de celular del Cliente (10 dígitos).");
                        return false;
                    }

                    $.ajax({
                        cache: false,
                        url: base_url+"index.php/servicio/ver_datosOrden/",
                        type: 'POST',
                        dataType: 'json',
                        data: {id_orden: id_orden}
                    })
                    .done(function(datos) {

                        if(hora_actual >= "00:00" && hora_actual <= "11:59")
                        {
                            saludo = "¡Buenos días";
                        }else if(hora_actual >= "12:00" && hora_actual <= "19:00")
                        {
                            saludo = "¡Buenas tardes";
                        }else 
                        {
                            saludo = "¡Buenas noches";
                        }

                        texto = saludo +", "+ cliente + "!";
                        texto += "\n";
                        texto += "Ponemos a su disposición los datos de su Órden de Servicio (ver archivo PDF adjunto).";
                        texto += "\n";
                        texto += "Agradecemos su visita al Taller de "+datos["sucursal"]["nombre"]+".";
                        texto += "\n";
                        texto += "Le atendió: "+datos["asesor"]["nombre"]+" "+datos["asesor"]["apellidos"];

                        texto = encodeURIComponent(texto);

                        whatsapp_url = 'https://api.whatsapp.com/send?phone='+codigo_area+numero+'&text='+texto;
                        window.open(whatsapp_url, "_blank");
                    })
                    .fail(function() {
                        alert("Hubo un error al obtener los datos de la orden");
                    }); 
                }
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
});

// Steppers
$(document).ready(function () {
  var navListItems = $('div.setup-panel-2 div a'),
          allWells = $('.setup-content-2'),
          allNextBtn = $('.nextBtn-2'),
          allPrevBtn = $('.prevBtn-2');

  allWells.hide();

  navListItems.click(function (e) {
      e.preventDefault();
      var $target = $($(this).attr('href')),
              $item = $(this);

      if (!$item.hasClass('disabled')) {
          navListItems.removeClass('btn-amber').addClass('btn-blue-grey');
          $item.addClass('btn-amber');
          allWells.hide();
          $target.show();
          $target.find('input:eq(0)').focus();
      }
  });
  allPrevBtn.click(function(){
      var curStep = $(this).closest(".setup-content-2"),
          curStepBtn = curStep.attr("id"),
          prevStepSteps = $('div.setup-panel-2 div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

          prevStepSteps.removeAttr('disabled').trigger('click');
  });
  allNextBtn.click(function(){
      var curStep = $(this).closest(".setup-content-2"),
          curStepBtn = curStep.attr("id"),
          nextStepSteps = $('div.setup-panel-2 div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
          curInputs = curStep.find("input[type='text'],input[type='url']"),
          isValid = true;

      $(".form-group").removeClass("has-error");
      for(var i=0; i< curInputs.length; i++){
          if (!curInputs[i].validity.valid){
              isValid = false;
              $(curInputs[i]).closest(".form-group").addClass("has-error");
          }
      }
      if (isValid)
          nextStepSteps.removeAttr('disabled').trigger('click');
  });


  $('div.setup-panel-2 div a.btn-amber').trigger('click');
});

function formatear_numero(numero)
{
    var num = numero.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    return num;
}

$(document).on("click", '#boton_agregarArt', function (e){
    e.preventDefault();
    var art = $("#ajax_arts").val();
    var precio = $("#input_precio").val();
    var cantidad = $("#input_cantidad").val();
    var clave_art = $("#input_claveArt").val();
    var total = precio * cantidad;
    var table = "<tr class='item-row arst_add' style='text-align:center;'>";

    /*
    if(art == "" || precio == "")
    {
        toastr.error("No se ha especificado ningún artículo");
        return false;
    }
    */

    if(art == "" || precio == "" || clave_art == "")
    {
        toastr.error("No se ha especificado ningún artículo de la lista");
        $("#ajax_arts").focus();
        return false;
    }


    precio = roundNumber(precio,2);
    precio = formatear_numero(precio);
    total = formatear_numero(total);

    table += "<td class='item-name'><div class='delete-wpr'><a class='delete'>X</a> </div></td>";
    table += "<td class='artmoo'>"+clave_art+"</td>";
    table += "<td>"+art+"</td>";
    table += "<td><input class='qty md-textarea' id='art_qty' value='"+cantidad+"'/></td>";
    table += "<td><input class='cost md-textarea' id='art_cost' value='"+precio+"'/></td>";
    table += "<td class='price'>"+total+"</td>";
    table +="<td style='display:none;' id='articulosad'>single</td>";
    table += "<td style='display:none;' id='idpq'>" + 'NA' + "</td>";
    table += "</tr>";

    $("#table_invoice tbody").append(table);
    bind();
    $("#modalbusqpaq").modal("hide");
    update_total();
    $("#ajax_arts, #input_precio, #input_claveArt").val("");
    $("#input_cantidad").val(1);
    $("#table_paq tbody, #tabla_detalle tbody").empty();
});

$(document).on("click", '#boton_agregarMano', function (e){
    e.preventDefault();
    var itmo = new Array();
    $(this).closest('tr').find('td').each(
    function (i) {
      itmo[i] = $(this).text();
    });

    var art = itmo[1];
    var cantidad = 1;//$("#input_cantidad").val();
    var clave_art = itmo[0];
    var precio = itmo[2];
    var total  = precio; 
    var table  = "<tr class='item-row arst_add' style='text-align:center;'>";

    table += "<td class='item-name'><div class='delete-wpr'><a class='delete'>X</a> </div></td>";
    table += "<td class='artmoo'>"+clave_art+"</td>";
    table += "<td>"+art+"</td>";
    table += "<td><input class='qty md-textarea' id='mo_qty' value='"+cantidad+"'/></td>";
    table += "<td><input class='cost md-textarea' id='mo_cost' value='"+precio+"'/></td>";
    table += "<td class='price'>"+total+"</td>";
    table += "<td style='display:none;' id='articulosmo'>mo</td>";
    table += "<td style='display:none;' id='idpq'>" + 'NA' + "</td>";
    table += "</tr>";

    $("#table_invoice tbody").append(table);

    // $("#mo_cost").val(precio);
    bind();
    $("#modalmanodeobra").modal("hide");
    update_total();
     
    toastr.success("Mano de Obra agregada");
    $("#ajax_arts, #input_precio, #input_claveArt").val("");
    $("#input_cantidad").val(1);
    $("#table_paq tbody, #tabla_detalle tbody").empty();
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
    console.log("id", id_orden);
    console.log("oasis", oasis);
    data.append("id_orden", id_orden);
    data.append("oasis",oasis);
    guardar_oasis(data);
});
function optimizar_PDF(e)
{
    $("#loading_spin").show();
    var fileName = e.target.files[0].name;
    var reader = new FileReader();                              //Se crea instancia de FileReader Js API
    reader.readAsDataURL(e.target.files[0]);                    //Lee la imagen que está en el input usando el FileReader
    reader.onload = event => {
        var binaryData = event.target.result;
      //Converting Binary Data to base 64
      var base64String = window.btoa(binaryData);
      base64data = reader.result;
      //showing file converted to base64
      $('#input_vista_previa_pdf').val(base64data);
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
function convertir_tiempo(segundos) {
    let horas = Math.floor(segundos / 3600);
    segundos -= horas * 3600;
    let minutos = Math.floor(segundos / 60);
    segundos -= minutos * 60;
    segundos = parseInt(segundos);
    if (horas < 10) horas = "0" + horas;
    if (minutos < 10) minutos = "0" + minutos;
    if (segundos < 10) segundos = "0" + segundos;

    return `${horas}:${minutos}:${segundos}`;
}
let tiempo_inicio, media_recorder, id_intervalo;
 // Mostrar tiempo de grabación
function iniciar_conteo() {
    tiempo_inicio = Date.now();
    id_intervalo = setInterval(refrescar, 1000);
}
function refrescar() {
    $('#tiempo_grabado').text(convertir_tiempo((Date.now() - tiempo_inicio) / 1000));
}
function detener_grabacion() {
    if (!media_recorder) return alert("No se está grabando");
    media_recorder.stop();
    media_recorder = null;
}
function detener_conteo() {
    clearInterval(id_intervalo);
    tiempo_inicio = null;
    $('#tiempo_grabado').text('');
}
function agregar_audio(blob) {
    var reader = new FileReader();
    var base64data = "";
    reader.readAsDataURL(blob); 
    reader.onloadend = function() {
        base64data = reader.result;
        $('#audios_grabados').append(`<input type="hidden" name="input_vista_previa_audo[]" class="new_audio" value="${base64data}">`);
        $('#audios_grabados').append(`<div class="row"><audio class="col-sm-10" controls controlsList="nofullscreen nodownload" name="vista_previa_audio[]" src="${base64data}"></audio><span class="remove-audio col-sm-2" data-id="0" style="max-width:50px;cursor:pointer; background-color:rgba(255,0,0,0.8);padding:15px;"><i class="fa fa-trash" style="color:#fff"></i></span></div>`);
        $('#audios_grabados').append(`<br>`);
    }
}
$(document).on("click", '#btn_borrarAudio', function (e){
    e.preventDefault();
    //TODO llamada al borrado de archivos de momento no se almacenan
    $('#audios_grabados').empty();
});
$(document).on("click", '.remove-audio', function (e){
    e.preventDefault();
    //TODO llamada al borrado de archivos de momento no se almacenan
    $(this).closest(".row").remove();
});
let cloneID = 0;
//Añadir causa raíz componente
$(document).on("click", "#add_causa_raiz", function(event){
    event.preventDefault();
    $( "#step-4:first" ).clone().appendTo('#step-4');
});
$(document).on("click", "#audioInput", function(event){
    event.preventDefault();
    if (media_recorder) {
        $('#btn_audio').removeClass('btn-green').addClass('btn-info');
        detener_grabacion();
    }else{
        $('#btn_audio').removeClass('btn-info').addClass('btn-green');
        navigator.mediaDevices.getUserMedia({
          audio: true
        })
        .then( stream => {
                media_recorder = new MediaRecorder(stream);
                media_recorder.start();
                iniciar_conteo();
                const grabacion = [];
                media_recorder.addEventListener("dataavailable", event => {
                    grabacion.push(event.data);
                });
                media_recorder.addEventListener("stop", () => {
                stream.getTracks().forEach(track => track.stop());
                detener_conteo();
                const blobAudio = new Blob(grabacion, {type: "audio/mp3"});
                agregar_audio(blobAudio);
                });
        })
        .catch(error => {
            console.log('error stream', error);
            $('#btn_audio').removeClass('btn-green').addClass('btn-info');
            detener_grabacion();
      });
  }
});
