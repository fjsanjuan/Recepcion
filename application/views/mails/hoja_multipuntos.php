<!DOCTYPE html>
<meta charset="UTF-8">
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<head>
	<title>Hoja Multipuntos</title>
	<link rel="icon" href="<?=base_url()?>assets/img/favicon.ico">

	<!-- jQuery version mas antigua-->
	<script src="<?php echo base_url();?>assets/jquery/jquery-1.12.3.js"></script>
	<script src="<?=base_url()?>assets/jquery/jquery_ui/js/jquery-ui-1.10.4.custom.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/jquery/jquery_ui/css/ui-lightness/jquery-ui-1.10.4.custom.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/bootstrap-3.3.6/css/bootstrap.min.css" media="all">
	<script src="<?php echo base_url();?>assets/bootstrap/bootstrap-3.3.6/js/bootstrap.min.js"></script>
	<!--FontAwesome-->
	<link rel="stylesheet" href="<?=base_url()?>assets/librerias/fontawesome-free-5.2.0-web/css/all.css"/>
	<!-- Css formato hoja multipuntos -->
	<link rel="stylesheet" href="<?=base_url()?>assets/css/hoja_multipuntos.css">
	<!-- Html2canvas -->
	<script src="<?=base_url()?>assets/librerias/html2canvas/html2canvas.min.js"></script>
	<!-- Jspdf -->
	<script src="<?=base_url()?>assets/librerias/jspdf/jspdf.debug.js"></script>
	<!--Toaster-->
	<script src="<?=base_url()?>assets/js/toastr.min.js"></script>
	<script src="<?= base_url()?>assets/librerias/Signature/src/jSignature.js"></script>
	<script src="<?= base_url()?>assets/librerias/jq-signature-master/jq-signature.min.js"></script>
</head>
<script>
$(document).ready(function() {
	base_url = "<?=base_url()?>";
	var firma = "";
	var firma_multip = "<?=$firma_cliente['firma_multipuntos']?>";
	var id_orden = localStorage.getItem("hist_id_orden");
	$("#id_orden_hidden").val(id_orden);
	if(firma_multip != ''){
		$("#div_firma_usu").remove();
		$("#btn_borrarFirmaUsu").remove();
		$("#btn_saveFirmaUsu").hide();
		$("#firma_cliente").show();
	}
	var config = {
        autoFit : true,       // Update any forms field with signature when loading the page
        // format : "image/png",  // Default signature image format
        background : "#EEE",   // Default signature background
        lineColor : "#000",          // Default signature pen color
        lineWidth : 1,          // Default signature pen width
        border : "#AAA",       // Default signature pen border color
        height : 130           // Default signature height in px
    };

    // firma = $("#firma").jqSignature(config);
    firma = $("#div_firma_usu").jqSignature(config);
    /*Borrar canvas*/
    $("#btn_borrarFirmaUsu").on("click", function(e){
        e.preventDefault();

        $("#div_firma_usu").jqSignature("clearCanvas");
        $("#firma_usu").val("");
    });

    function validar_firma(firma)
    {
        var valida = true;
        var firma_vacia = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAdIAAACCCAYAAADymUl1AAAFN0lEQVR4Xu3VsQ0AAAjDMPj/aX4gq9m7WEjZcQQIECBAgMBbYN9LQwIECBAgQGCE1BMQIECAAIEgIKQBz5QAAQIECAipHyBAgAABAkFASAOeKQECBAgQEFI/QIAAAQIEgoCQBjxTAgQIECAgpH6AAAECBAgEASENeKYECBAgQEBI/QABAgQIEAgCQhrwTAkQIECAgJD6AQIECBAgEASENOCZEiBAgAABIfUDBAgQIEAgCAhpwDMlQIAAAQJC6gcIECBAgEAQENKAZ0qAAAECBITUDxAgQIAAgSAgpAHPlAABAgQICKkfIECAAAECQUBIA54pAQIECBAQUj9AgAABAgSCgJAGPFMCBAgQICCkfoAAAQIECAQBIQ14pgQIECBAQEj9AAECBAgQCAJCGvBMCRAgQICAkPoBAgQIECAQBIQ04JkSIECAAAEh9QMECBAgQCAICGnAMyVAgAABAkLqBwgQIECAQBAQ0oBnSoAAAQIEhNQPECBAgACBICCkAc+UAAECBAgIqR8gQIAAAQJBQEgDnikBAgQIEBBSP0CAAAECBIKAkAY8UwIECBAgIKR+gAABAgQIBAEhDXimBAgQIEBASP0AAQIECBAIAkIa8EwJECBAgICQ+gECBAgQIBAEhDTgmRIgQIAAASH1AwQIECBAIAgIacAzJUCAAAECQuoHCBAgQIBAEBDSgGdKgAABAgSE1A8QIECAAIEgIKQBz5QAAQIECAipHyBAgAABAkFASAOeKQECBAgQEFI/QIAAAQIEgoCQBjxTAgQIECAgpH6AAAECBAgEASENeKYECBAgQEBI/QABAgQIEAgCQhrwTAkQIECAgJD6AQIECBAgEASENOCZEiBAgAABIfUDBAgQIEAgCAhpwDMlQIAAAQJC6gcIECBAgEAQENKAZ0qAAAECBITUDxAgQIAAgSAgpAHPlAABAgQICKkfIECAAAECQUBIA54pAQIECBAQUj9AgAABAgSCgJAGPFMCBAgQICCkfoAAAQIECAQBIQ14pgQIECBAQEj9AAECBAgQCAJCGvBMCRAgQICAkPoBAgQIECAQBIQ04JkSIECAAAEh9QMECBAgQCAICGnAMyVAgAABAkLqBwgQIECAQBAQ0oBnSoAAAQIEhNQPECBAgACBICCkAc+UAAECBAgIqR8gQIAAAQJBQEgDnikBAgQIEBBSP0CAAAECBIKAkAY8UwIECBAgIKR+gAABAgQIBAEhDXimBAgQIEBASP0AAQIECBAIAkIa8EwJECBAgICQ+gECBAgQIBAEhDTgmRIgQIAAASH1AwQIECBAIAgIacAzJUCAAAECQuoHCBAgQIBAEBDSgGdKgAABAgSE1A8QIECAAIEgIKQBz5QAAQIECAipHyBAgAABAkFASAOeKQECBAgQEFI/QIAAAQIEgoCQBjxTAgQIECAgpH6AAAECBAgEASENeKYECBAgQEBI/QABAgQIEAgCQhrwTAkQIECAgJD6AQIECBAgEASENOCZEiBAgAABIfUDBAgQIEAgCAhpwDMlQIAAAQJC6gcIECBAgEAQENKAZ0qAAAECBITUDxAgQIAAgSAgpAHPlAABAgQICKkfIECAAAECQUBIA54pAQIECBAQUj9AgAABAgSCgJAGPFMCBAgQICCkfoAAAQIECAQBIQ14pgQIECBAQEj9AAECBAgQCAJCGvBMCRAgQICAkPoBAgQIECAQBIQ04JkSIECAAAEh9QMECBAgQCAICGnAMyVAgAABAkLqBwgQIECAQBAQ0oBnSoAAAQIEDhKXAINwmjSdAAAAAElFTkSuQmCC";

        if(firma === firma_vacia)
        {
            alert("Es necesario configurar su firma, favor de escribirla.");
            valida = false;
        }

        return valida;
    }
	var img = "";
	var nombre_asesor = "<?php echo $orden_servicio['asesor']?>";

	$("#nombre_asesor").val(nombre_asesor);
	
	function genIMG()
	{
		html2canvas($(".subcuerpo"),{
		   	onrendered:function(canvas){
			   img = canvas.toDataURL("image/png");
			   localStorage.removeItem("hoja_multipuntos");
			   localStorage.setItem("hoja_multipuntos", img);
		   	}
	    });
	}

	/*Pdf*/
	function generar_pdf()
	{
	    // var hoja_multipuntos = localStorage.getItem("hoja_multipuntos");
	    var id_orden = localStorage.getItem("hist_id_orden");
	    var doc = new jsPDF("p", "mm", "legal", true);
	    var width = 0;
	    var height = 0;
	    width = doc.internal.pageSize.width;    
	    height = doc.internal.pageSize.height;
	    html2canvas($(".subcuerpo"),{
		   	onrendered:function(canvas){
			   img = canvas.toDataURL("image/png");
			   // localStorage.removeItem("hoja_multipuntos");
			   // localStorage.setItem("hoja_multipuntos", img);
			   doc.addImage(img, 'PNG', 0, 0, width, height, undefined, 'FAST');
	    		doc.save('Hoja_Multipuntos'+id_orden+'.pdf');
		   	}
	    });
	    // doc.addImage(hoja_multipuntos, 'PNG', 0, 0, width, height, undefined, 'FAST');
	    // doc.save('Hoja_Multipuntos'+id_orden+'.pdf');
	}

	function llenar_camposAsesor()
	{
		var perdida_fluidos = "<?php echo (isset($orden_inspeccion['rev_asesor']['perdida_fluidos'])) ? $orden_inspeccion['rev_asesor']['perdida_fluidos'] : ''?>";
		var cambiado_nivFlu = "<?php echo (isset($orden_inspeccion['rev_asesor']['nivel_fluidos_cambiado'])) ? $orden_inspeccion['rev_asesor']['nivel_fluidos_cambiado'] : ''?>";
		var aceite_motor = "<?php echo (isset($orden_inspeccion['rev_asesor']['aceiteMotor'])) ? $orden_inspeccion['rev_asesor']['aceiteMotor'] : ''?>";
		var dir_hidraulica = "<?php echo (isset($orden_inspeccion['rev_asesor']['direccionHidraulica'])) ? $orden_inspeccion['rev_asesor']['direccionHidraulica'] : ''?>";
		var transmision = "<?php echo (isset($orden_inspeccion['rev_asesor']['liquidoTransmision'])) ? $orden_inspeccion['rev_asesor']['liquidoTransmision'] : ''?>";
		var dep_freno = "<?php echo (isset($orden_inspeccion['rev_asesor']['liquidoFreno'])) ? $orden_inspeccion['rev_asesor']['liquidoFreno'] : ''?>";
		var limpiaparabrisas = "<?php echo (isset($orden_inspeccion['rev_asesor']['liquidoLimpiaPara'])) ? $orden_inspeccion['rev_asesor']['liquidoLimpiaPara']: ''?>";
		var refrigerante = "<?php echo (isset($orden_inspeccion['rev_asesor']['deposito_refrigerante'])) ? $orden_inspeccion['rev_asesor']['deposito_refrigerante'] : ''?>";
		var prlimpiaparab = "<?php echo (isset($orden_inspeccion['rev_asesor']['pruebaParabrisas'])) ? $orden_inspeccion['rev_asesor']['pruebaParabrisas'] : ''?>";
		var plumas = "<?php echo (isset($orden_inspeccion['rev_asesor']['plumas'])) ? $orden_inspeccion['rev_asesor']['plumas'] : ''?>";
		var plumaslimp_cambiado = "<?php echo (isset($orden_inspeccion['rev_asesor']['plumaslimp_cambiado'])) ? $orden_inspeccion['rev_asesor']['plumaslimp_cambiado'] : ''?>";
		var sistemas1 = "<?php echo (isset($orden_inspeccion['rev_asesor']['luces'])) ? $orden_inspeccion['rev_asesor']['luces'] : ''?>";
		var sistemas2 = "<?php echo (isset($orden_inspeccion['rev_asesor']['parabrisas'])) ? $orden_inspeccion['rev_asesor']['parabrisas'] : ''?>";
		var sistemas1_cambiado = "<?php echo (isset($orden_inspeccion['rev_asesor']['sistemas1_cambiado'])) ? $orden_inspeccion['rev_asesor']['sistemas1_cambiado'] : ''?>";
		var sistemas2_cambiado = "<?php echo (isset($orden_inspeccion['rev_asesor']['sistemas2_cambiado'])) ? $orden_inspeccion['rev_asesor']['sistemas2_cambiado'] : ''?>";
		var bateria_cambiado = "<?php echo (isset($orden_inspeccion['rev_asesor']['bateria_cambiado'])) ? $orden_inspeccion['rev_asesor']['bateria_cambiado'] : ''?>";
		var cca = "<?php echo (isset($orden_inspeccion['rev_asesor']['corriente_fabrica'])) ? $orden_inspeccion['rev_asesor']['corriente_fabrica'] : ''?>";
		var cca_2 = "<?php echo (isset($orden_inspeccion['rev_asesor']['corriente_real'])) ? $orden_inspeccion['rev_asesor']['corriente_real'] :''?>";
		var bateria = "<?php echo (isset($orden_inspeccion['rev_asesor']['bateria'])) ? $orden_inspeccion['rev_asesor']['bateria'] : ''?>";
		var extension_garantia = "<?php echo (isset($orden_inspeccion['rev_asesor']['extension_garantia'])) ? $orden_inspeccion['rev_asesor']['extension_garantia'] : ''?>";
		//Pérdidas de fluido y/o aceite
		switch(perdida_fluidos)
		{
			case "si":
				$("#i_perdidafl_si").removeClass("fa-square-o").addClass("fa-check-square");
			break;
			case "no":
				$("#i_perdidafl_no").removeClass("fa-square-o").addClass("fa-check-square");
			break;
			default:

			break;
		}
		switch(extension_garantia)
		{

			case "si":
				$("#i_gext_si").removeClass("fa-square-o").addClass("fa-check-square");
			break;
			case "no":
				$("#i_gext_no").removeClass("fa-square-o").addClass("fa-check-square");
			break;
			case "":
				$("#i_gext_no").removeClass("fa-square-o").addClass("fa-check-square");
			break;
			default:
			
			break;
		}
		//niveles fluidos cambiado
		if(cambiado_nivFlu == "si")
		{
			$("#i_cambiado_nivFlu").removeClass("fa-square-o").addClass("fa-check-square");
		}

		//aceite de motor
		switch(aceite_motor)
		{
			case "Bien":
				$("#i_aceitemotor_bien").removeClass("fa-square").addClass("fa-check-square");
			break;
			case "Llenar":
				$("#i_aceitemotor_llenar").removeClass("fa-square").addClass("fa-check-square");
			break;
			default:

			break;
		}

		//direccion hidraulica
		switch(dir_hidraulica)
		{
			case "Bien":
				$("#i_dirhidr_bien").removeClass("fa-square").addClass("fa-check-square");
			break;
			case "Llenar":
				$("#i_dirhidr_llenar").removeClass("fa-square").addClass("fa-check-square");
			break;
			default:

			break;
		}
		
		//transmision
		switch(transmision)
		{
			case "Bien":
				$("#i_transmision_bien").removeClass("fa-square").addClass("fa-check-square");
			break;
			case "Llenar":
				$("#i_transmision_llenar").removeClass("fa-square").addClass("fa-check-square");
			break;
			default:

			break;
		}

		//deposito freno
		switch(dep_freno)
		{
			case "Bien":
				$("#i_dep_freno_bien").removeClass("fa-square").addClass("fa-check-square");
			break;
			case "Llenar":
				$("#i_dep_freno_llenar").removeClass("fa-square").addClass("fa-check-square");
			break;
			default:

			break;
		}

		//limpiaparabrisas
		switch(limpiaparabrisas)
		{
			case "Bien":
				$("#i_limpiaparabrisas_bien").removeClass("fa-square").addClass("fa-check-square");
			break;
			case "Llenar":
				$("#i_limpiaparabrisas_llenar").removeClass("fa-square").addClass("fa-check-square");
			break;
			default:

			break;
		}

		//refrigerante
		switch(refrigerante)
		{
			case "Bien":
				$("#i_refrigerante_bien").removeClass("fa-square").addClass("fa-check-square");
			break;
			case "Llenar":
				$("#i_refrigerante_llenar").removeClass("fa-square").addClass("fa-check-square");
			break;
			default:

			break;
		}

		//Pruebas de limpiaparabrisas realizada
		switch(prlimpiaparab)
		{
			case "si":
				$("#i_prblimpiapara_si").removeClass("fa-square-o").addClass("fa-check-square");
			break;
			case "no":
				$("#i_prblimpiapara_no").removeClass("fa-square-o").addClass("fa-check-square");
			break;
			default:

			break;
		}

		//Plumas Limpiaparabrisas
		switch(plumas)
		{
			case "Buen Estado":
				$("#i_prblimpiapara_aprobado").removeClass("fa-square-o").addClass("fa-check-square");
			break;
			case "Requiere cambiar":
				$("#i_prblimpiapara_ratencion").removeClass("fa-square-o").addClass("fa-check-square");
			break;
			default:

			break;
		}

		//plumas limpiaparabrisas cambiado
		if(plumaslimp_cambiado == "si")
		{
			$("#i_plumaslimp_cambiado").removeClass("fa-square-o").addClass("fa-check-square");
		}

		//Funcionamiento de claxon, luces interiores,
		switch(sistemas1)
		{
			case "Bien":
				$("#i_sistemas1_si").removeClass("fa-square").addClass("fa-check-square");
			break;
			case "Requiere Reparación":
				$("#i_sistemas1_no").removeClass("fa-square").addClass("fa-check-square");
			break;
			default:

			break;
		}

		//Grietas, roturas y picaduras del parabrisas
		switch(sistemas2)
		{
			case "Bien":
				$("#i_sistemas2_si").removeClass("fa-square").addClass("fa-check-square");
			break;
			case "Requiere Reparación":
				$("#i_sistemas2_no").removeClass("fa-square").addClass("fa-check-square");
			break;
			default:

			break;
		}

		//sistemas1 cambiado
		if(sistemas1_cambiado == "si")
		{
			$("#i_sistemas1_cambiado").removeClass("fa-square-o").addClass("fa-check-square");
		}

		//sistemas2 cambiado
		if(sistemas2_cambiado == "si")
		{
			$("#i_sistemas2_cambiado").removeClass("fa-square-o").addClass("fa-check-square");
		}

		//bateria
		if(bateria_cambiado == "si")
		{
			$("#i_bateria_cambiado").removeClass("fa-square-o").addClass("fa-check-square");
		}

		$("#cca").val(cca);

		$("#cca_2").val(cca_2);

		switch(bateria)
		{
			case "Bien":
				$("#i_bateria_aprobado").removeClass("fa-square").addClass("fa-check-square");
			break;
			case "Requiere Atencion":
				$("#i_bateria_atencion").removeClass("fa-square").addClass("fa-check-square");
			break;
			case "Requiere Reparacion":
				$("#i_bateria_reparacion").removeClass("fa-square").addClass("fa-check-square");
			break;
			default:

			break;
		}
	}

	//Asigna id's dinámicamente a los elementos
	var c1 = 1;
	$.each($(".i_asignar").find("i"), function(index, val) 
	{
		if($(this).hasClass("cuadro_blanco") == false && $(this).hasClass("fa-leaf") == false)
		{
			$(this).prop("id", "c"+c1);
			c1++;
		}		
	});

	var c2 = 1;
	$.each($(".input_asignar").find(".renglon_mm"), function(index, val) 
	{
		$(this).prop("id", "i"+c2);
		c2++;	
	});

	var c3 = 1;
	$.each($("textarea"), function(index, val) 
	{
		$(this).prop("id", "t"+c3);
		c3++;	
	});

	function llenar_camposTecnico()
	{
		var radio = "<?php echo (isset($orden_inspeccion['rev_tecnico']['multipuntos_radio'])) ? $orden_inspeccion['rev_tecnico']['multipuntos_radio'] : ''?>";
		radio =radio.split("-");

		var checkbox = "<?php echo (isset($orden_inspeccion['rev_tecnico']['multipuntos_box'])) ? $orden_inspeccion['rev_tecnico']['multipuntos_box'] : ''?>";
		checkbox = checkbox.split("-");
		// console.log(checkbox);
		var input = "<?php echo (isset($orden_inspeccion['rev_tecnico']['multipuntos_input'])) ? $orden_inspeccion['rev_tecnico']['multipuntos_input'] : ''?>";
		input = input.split("|");
		<?php 
			$cla = $orden_inspeccion['rev_tecnico']['multipuntos_text'];
			$stripped =preg_replace( "/\r|\n/", "",$cla);
		?>
		var textarea = "<?php echo $stripped?>";
		
		textarea = textarea.split("-");

		$.each(checkbox, function(index, val) 
		{
			var elemento = $(".i_asignar").find("i[id='"+val+"']");

			elemento.removeClass("fa-square fa-square-o");

			elemento.addClass("fa-check-square");
		});

		$.each(radio, function(index, val) 
		{
			var elemento = $(".i_asignar").find("i[id='"+val+"']");
			// console.log(elemento);
			elemento.removeClass("fa-square fa-square-o");

			elemento.addClass("fa-check-square");
		});
		$.each(input, function(index, val) 
		{
			if(val != ""){
				var elemento = val.split("-");
				var id = elemento[0];
				var value = elemento[1];

				$("#"+id+"").val(value);
			}
		});	

		$.each(textarea, function(index, val) 
		{
			var elemento = val.split("-");
			//console.log(elemento);
			$("#t1").append(elemento + '\n');
		});
	}

	llenar_camposAsesor();
	llenar_camposTecnico();
	/*genIMG(); */

	$(".boton_imprimir").click(function(){
		$("button").css("display", "none");
		window.print();
		$("button").css("display", "inline");
	});

	$(".boton_pdf").click(function(){
		if(firma_multip == "" || firma_multip == null){ // validar que existe una firma, solamente primera vez
			var firma_ok = validar_firma(firma.jqSignature("getDataURL"));
			if(firma_ok == false)
	        {
	            return;
	        }
	        else{
	        	$("#firma_usu").val(firma.jqSignature("getDataURL"));
		        var form = $("#formFirma").serialize();
		        $.ajax({
		            cache: false,
		            url: base_url+ "index.php/Servicio/guardar_firma_multi/",
		            type: 'POST',
		            dataType: 'json',
		            data: form
		        })
		        .done(function(data) {
		            if(data)
		            {
		                $("#firma_cliente").attr("src","");
		                $("#firma_cliente").attr("src",firma.jqSignature("getDataURL"));
		                $("#firma_cliente").show();
		                $("#div_firma_usu").jqSignature("clearCanvas");
		                $("#div_firma_usu").hide();
		                $("#btn_borrarFirmaUsu").hide();
		                $("#btn_saveFirmaUsu").hide();
        				$("#firma_usu").val("");
        				$("#div_firma_usu").remove();
						$("#btn_borrarFirmaUsu").remove();
		                toastr.success("Se han actualizado los datos");
		            }else 
		            {
		                toastr.error("Hubo un error en la actualización de los datos");
		            }
		        })
		        .fail(function() {
		            alert("Hubo un error al actualizar los datos");
		        });
		        $(this).css("display", "none");

				toastr.success("Generando el PDF, espere un momento, por favor");
				setTimeout(function(){
						generar_pdf();
				}, 500);
				// $.ajax({
				// 	url: genIMG()
				// })
				// .done(function() {

				// 	setTimeout(function(){
				// 		generar_pdf();
				// 	}, 500);
				// })
				// .fail(function() {
				// 	alert("Hubo un error al generar el formato");
				// });

				$(this).css("display", "inline");
	        }
		}else{
			$(this).css("display", "none");
			toastr.success("Generando el PDF, espere un momento, por favor");
			generar_pdf();
			$(this).css("display", "inline");
		}
	});
	$("#btn_saveFirmaUsu").click(function(e){
		e.preventDefault();
		if(firma_multip == "" || firma_multip == null){ // validar que existe una firma, solamente primera vez
			var firma_ok = validar_firma(firma.jqSignature("getDataURL"));
			if(firma_ok == false)
	        {
	            return;
	        }
	        else{
	        	$("#firma_usu").val(firma.jqSignature("getDataURL"));
		        var form = $("#formFirma").serialize();
		        $.ajax({
		            cache: false,
		            url: base_url+ "index.php/Servicio/guardar_firma_multi/",
		            type: 'POST',
		            dataType: 'json',
		            data: form
		        })
		        .done(function(data) {
		            if(data)
		            {
		                $("#firma_cliente").attr("src","");
		                $("#firma_cliente").attr("src",firma.jqSignature("getDataURL"));
		                $("#firma_cliente").show();
		                $("#div_firma_usu").jqSignature("clearCanvas");
		                $("#div_firma_usu").hide();
		                $("#btn_borrarFirmaUsu").hide();
		                $("#btn_saveFirmaUsu").hide();
        				$("#firma_usu").val("");
        				$("#div_firma_usu").remove();
						$("#btn_borrarFirmaUsu").remove();
		                toastr.success("Se han actualizado los datos");
		            }else 
		            {
		                toastr.error("Hubo un error en la actualización de los datos");
		            }
		        })
		        .fail(function() {
		            alert("Hubo un error al actualizar los datos");
		        });
	        }
		}else{
			toastr.info("ya existe la firma del cliente");
		}
	});
});
</script>
<style type="text/css" media="print">
	@page{margin:5cm}

    .subcuerpo{
		width: 100% !important;
		margin: 5px !important;
	}

	.container{
		width: 1110px !important;
		height: 1110px !important;
	}

	.prb_limp {
		font-size: 10px !important;
	}

	.sist_frenos_print {
		font-size: 11px !important;
	}

	.neum_cuadros_print {
		position: relative;
		top: 10px !important;
	}

	.neum_tit_print{
		font-size: 12px !important;
	}

	.firma_cliente {
		width: 30% !important;
	}
	#div_firma_usu {
        border: 2px dotted black;
        background-color: #fff;
        width: 100%;
        height: 130px;
    }
	/* 
      ##Device = Laptops, Desktops
      ##Screen = B/w 1025px to 1280px
    */
    @media (min-width: 1025px) and (max-width: 1280px) {
      
        .jSignature, #div_firma_usu {
            width: 800px !important;
        }
      
    }

    /* 
      ##Device = Tablets, Ipads (portrait)
      ##Screen = B/w 768px to 1024px
    */
    @media (min-width: 768px) and (max-width: 1024px) {

        .jSignature, #div_firma_usu {
            width: 500px !important;
        }
      
    }

    /* 
      ##Device = Tablets, Ipads (landscape)
      ##Screen = B/w 768px to 1024px
    */
    @media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
      
        .jSignature, #div_firma_usu {
            width: 700px !important;
        }
    }

    /* 
      ##Device = Low Resolution Tablets, Mobiles (Landscape)
      ##Screen = B/w 481px to 767px
    */
    @media (min-width: 481px) and (max-width: 767px) {

        .jSignature, #div_firma_usu {
            width: 500px !important;
        }
    }

    /* 
      ##Device = Most of the Smartphones Mobiles (Portrait)
      ##Screen = B/w 320px to 479px
    */
    @media (min-width: 320px) and (max-width: 480px) {
      
        .jSignature, #div_firma_usu {
            width: 380px !important;
        }
      
    }
</style>
<body>
	<button class="btn btn-success boton_imprimir" title="Imprimir"><i class="fa fa-print"></i> Imprimir</button>
	<button class="btn btn-success boton_pdf" title="Guardar PDF"><i class="fa fa-download"></i> Guardar PDF</button>
	<div class="subcuerpo">
	<div class="container">
		<br>
		<div class="row encabezado">											<!-- encabezado logo -->
			<div class="col-xs-7">
				<h4>HOJA MULTIPUNTOS</h4>
			</div>
			<div class="col-xs-2">
				<!-- <img src="<?=base_url()?>assets/img/logo_ford.png" alt="logo Ford" class="logoFord"> -->
			</div>
			<div class="col-xs-3">
				<h6><?=$sucursal["razon_social"]?></h6>
			</div>
		</div>
		<div class="row titulo_apartado">										<!-- titulo inspeccion -->
			<div class="col-xs-12">
				<h6>INSPECCIÓN DEL VEHÍCULO</h6>
			</div>
		</div>
		<div class="row">														<!-- columna 1 cajas 1, 2, 3 y 4 -->
			<div class="col-xs-6">
				<div class="row caja">											<!-- caja 1 -->
					<div class="col-xs-12">
						<div class="row">
							<div class="col-xs-6">
								<label>Fecha:</label>
								<?php 
									$fecha = $orden_servicio["fecha_creacion"];

									if($fecha)
									{										
										$fecha = explode(" ", $fecha);
										$fecha = $fecha[0];
										$fecha = date("d-m-Y", strtotime($fecha));
									}else 
									{
										$fecha = "";
									}									
								?>
								<input type="text" name="fecha" id="fecha" class="renglon" style="width: 83%;" value="<?=$fecha?>">
							</div>
							<div class="col-xs-6">
								<label>OR:</label>
								<input type="text" name="or" id="or" class="renglon" style="width: 81%;" value="<?=$mov_id?>">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<label>No. de serie (VIN):</label>
								<?php 
									$vin = ($orden_servicio["vin"]) ? $orden_servicio["vin"] : "";
								?>
								<input type="text" name="vin" id="vin" class="renglon" style="width: 75%;" value="<?=$vin?>">
							</div>
						</div>
					</div>
				</div>
				<div class="row caja">											<!-- caja 2 -->
					<div class="col-xs-12">
						<div class="row">
							<div class="col-xs-7">
								<label>Modelo:</label>
								<?php 
									$modelo = ($orden_servicio["anio_modelo_v"]) ? $orden_servicio["anio_modelo_v"] : "";
								?>
								<input type="text" name="modelo" id="modelo" class="renglon" style="width: 75%;" value="<?=$modelo?>">
							</div>
							<div class="col-xs-5">
								<label># de torre:</label>
								<input type="text" name="no_torre" id="no_torre" class="renglon" style="width: 57%;" value="<?=$num_torre?>">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<label>Nombre:</label>
								<?php 
									$nombre = ($orden_servicio["nombre_cliente"]) ? $orden_servicio["nombre_cliente"] : "";
									$ap_cliente = ($orden_servicio["ap_cliente"]) ? $orden_servicio["ap_cliente"] : "";
									$am_cliente = ($orden_servicio["am_cliente"]) ? $orden_servicio["am_cliente"] : "";

									if($nombre =='undefined' && $ap_cliente =='undefined' && $am_cliente == 'undefined'){
										$nombre_cliente = $orden_servicio["nom_compania"];

									}else{
										$nombre_cliente = $nombre." ".$ap_cliente." ".$am_cliente;
									}
									
								?>
								<input type="text" name="nombre" id="nombre" class="renglon" style="width: 85%;" value="<?=$nombre_cliente?>">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<label>Correo electrónico:</label>
								<?php 
									$email = ($orden_servicio["email_cliente"]) ? $orden_servicio["email_cliente"] : "";
								?>
								<input type="text" name="correo_e" id="correo_e" class="renglon" style="width: 74%;" value="<?=$email?>">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<div class="col-xs-5">
								<label class="perdida_fluido">Extensión de garantía:</label>
							</div>
								<div class="col-xs-5">
									<label class="perdida_fluido_si" for="i_gext_si">SÍ</label><i id="i_gext_si" class="fa fa-square-o fa-2x perdida_fluido_si"></i>
									<label class="perdida_fluido_no" for="i_gext_no">NO</label><i id="i_gext_no" class="fa fa-square-o fa-2x perdida_fluido_no"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row caja_simple">									<!-- niveles de fluidos -->
					<div class="row">
						<div class="col-xs-10 titulo_apartado">
						<h6>NIVELES DE FLUIDOS</h6>
						</div>
						<div class="col-xs-2 titulo_blanco_apartado">
							<h6>CAMBIADO</h6>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid black;">
						<div class="col-xs-5">
							<label class="perdida_fluido">Pérdidas de fluido y/o aceite</label>
						</div>
						<div class="col-xs-5" style="border-right: 1px solid black;">
							<label class="perdida_fluido_si">SÍ</label><i id="i_perdidafl_si" class="fa fa-square-o fa-2x perdida_fluido_si"></i></span>
							<label class="perdida_fluido_no">NO</label><i id="i_perdidafl_no" class="fa fa-square-o fa-2x perdida_fluido_no"></i></span>
						</div>
						<div class="col-xs-2">
							<i id="i_cambiado_nivFlu" class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-2 bien_llenar subcolumna1">							<!-- subcolumna 1 -->
							<div class="row">
								<div class="col-xs-6">
									<p>BIEN</p>
								</div>
								<div class="col-xs-6">
									<p>LLENAR</p>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<i id="i_aceitemotor_bien" class="fa fa-square fa-2x"></i>
								</div>
								<div class="col-xs-6">
									<i id="i_aceitemotor_llenar" class="fa fa-square fa-2x"></i>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<i id="i_dep_freno_bien" class="fa fa-square fa-2x"></i>
								</div>
								<div class="col-xs-6">
									<i id="i_dep_freno_llenar" class="fa fa-square fa-2x"></i>
								</div>
							</div>
						</div>
						<div class="col-xs-2 niveles_texto subcolumna2">						<!-- subcolumna 2 -->
							<div class="row" style="height: 15px;">
								
							</div>
							<div class="row">
								<div class="col-xs-12">
									<span class="niveles_texto">Aceite de motor</span>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<span class="niveles_texto">Depósito de fluido de freno</span>
								</div>
							</div>
						</div>
						<div class="col-xs-2 bien_llenar subcolumna3">							<!-- subcolumna 3 -->
							<div class="row">
								<div class="col-xs-6">
									<p>BIEN</p>
								</div>
								<div class="col-xs-6">
									<p>LLENAR</p>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<i id="i_dirhidr_bien" class="fa fa-square fa-2x"></i>
								</div>
								<div class="col-xs-6">
									<i id="i_dirhidr_llenar" class="fa fa-square fa-2x"></i>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<i id="i_limpiaparabrisas_bien" class="fa fa-square fa-2x"></i>
								</div>
								<div class="col-xs-6">
									<i id="i_limpiaparabrisas_llenar" class="fa fa-square fa-2x"></i>
								</div>
							</div>
						</div>
						<div class="col-xs-2 niveles_texto subcolumna4">						<!-- subcolumna 4 -->
							<div class="row" style="height: 15px;">
								
							</div>
							<div class="row">
								<div class="col-xs-12" style="padding: 0px;">
									<span class="niveles_texto" style="display: inline-block; position: relative; left: 10px;">Dirección hidráulica</span>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12" style="padding: 0px;">
									<span class="niveles_texto" style="display: inline-block; position: relative; left: 10px; top: 12px;">Limpiaparabrisas</span>
								</div>
							</div>
						</div>
						<div class="col-xs-2 bien_llenar subcolumna5">							<!-- subcolumna 5 -->
							<div class="row">
								<div class="col-xs-6">
									<p>BIEN</p>
								</div>
								<div class="col-xs-6">
									<p>LLENAR</p>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<i id="i_transmision_bien" class="fa fa-square fa-2x"></i>
								</div>
								<div class="col-xs-6">
									<i id="i_transmision_llenar" class="fa fa-square fa-2x"></i>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<i id="i_refrigerante_bien" class="fa fa-square fa-2x"></i>
								</div>
								<div class="col-xs-6">
									<i id="i_refrigerante_llenar" class="fa fa-square fa-2x"></i>
								</div>
							</div>
						</div>
						<div class="col-xs-2 niveles_texto subcolumna6">						<!-- subcolumna 6 -->
							<div class="row" style="height: 15px;">
								
							</div>
							<div class="row">
								<div class="col-xs-12" style="padding: 0px; width: 180%;">
									<span class="niveles_texto" style="position: relative; top: -5px;">Transmisión</span><br><span style="font-size: 8px; position: relative; top: -15px;">(si está equipada con bayoneta de medición)</span>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12" style="padding: 0px; width: 175%;">
									<span class="niveles_texto" style="position: relative; top: -18px;">Depósito de recuperación de refrigerante</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">											<!-- plumas limpiaparabrisas -->
						<div class="col-xs-10 titulo_apartado">
							<h6>PLUMAS LIMPIAPARABRISAS</h6>
						</div>
						<div class="col-xs-2 titulo_blanco_apartado">
							<h6>CAMBIADO</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3">
							<span class="prb_limp">Pruebas de limpiaparabrisas realizada</span>
						</div>
						<div class="col-xs-7 plumas_limp">
							<span>SÍ</span>  <i id="i_prblimpiapara_si" class="fa fa-square-o fa-2x"></i>
							<span>NO</span>  <i id="i_prblimpiapara_no" class="fa fa-square-o fa-2x"></i>
							<i id="i_prblimpiapara_aprobado" class="fa fa-square fa-2x cuadro_verde"></i>
							<i id="i_prblimpiapara_ratencion" class="fa fa-square fa-2x cuadro_rojo"></i>
							<span>Pruebas de limpiaparabrisas</span>
						</div>
						<div class="col-xs-2">
							<i id="i_plumaslimp_cambiado" class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row">											<!-- sistemas/componentes -->
						<div class="col-xs-12 titulo_apartado">
							<h6>SISTEMAS/COMPONENTES</h6>
						</div>
					</div>
					<div class="row">											<!-- luces/parabrisas -->
						<div class="col-xs-10 titulo_apartado_gris">				
							<h6>LUCES/PARABRISAS</h6>
						</div>
						<div class="col-xs-2 titulo_blanco_apartado">
							<h6>CAMBIADO</h6>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid black;">
						<div class="col-xs-3 luces_parabrisas">
							<span>SÍ</span>  <i id="i_sistemas1_si" class="fa fa-square fa-2x cuadro_verde"></i> &nbsp;
							<i id="i_sistemas1_no" class="fa fa-square fa-2x cuadro_rojo"></i>  <span>NO</span>
						</div>
						<div class="col-xs-7 luces_parabrisas">
							<span>Funcionamiento de claxon, luces interiores, luces exteriores, luces de giro, luces de emergencia y freno</span>
						</div>
						<div class="col-xs-2">
							<i id="i_sistemas1_cambiado" class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3 luces_parabrisas">
							<span>SÍ</span>  <i id="i_sistemas2_si" class="fa fa-square fa-2x cuadro_verde"></i> &nbsp;
							<i id="i_sistemas2_no" class="fa fa-square fa-2x cuadro_rojo"></i>  <span>NO</span>
						</div>
						<div class="col-xs-7">
							<span style="font-size: 12px">Grietas, roturas y picaduras del parabrisas</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black;">
							<i id="i_sistemas2_cambiado" class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row">											<!-- bateria -->
						<div class="col-xs-10 titulo_apartado">				
							<h6>BATERÍA</h6>
						</div>
						<div class="col-xs-2 titulo_blanco_apartado">
							<h6>CAMBIADO</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 bateria">
							<center>
								<span>Nivel de carga de batería</span>
							</center>
						</div>
						<div class="col-xs-4 bateria">
							<center>
								<span>Estado de la batería</span>
							</center>
						</div>
						<div class="col-xs-2" style="border: 1px solid;">
							<i id="i_bateria_cambiado" class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 bateria">
							<span class="porc_cero">0%</span>
							<img src="<?=base_url()?>assets/img/nivel_carga_bateria.png" class="nivel_carga_bateria" alt="nivel carga batería">
							<span class="porc_cien">100%</span>
						</div>
						<div class="col-xs-4">
							<center class="cuadros_estado_bateria">
								<i id="i_bateria_aprobado" class="fa fa-square fa-2x cuadro_verde"></i>
								<i id="i_bateria_atencion" class="fa fa-square fa-2x cuadro_amarillo"></i>
								<i id="i_bateria_reparacion" class="fa fa-square fa-2x cuadro_rojo"></i>
							</center>
						</div>
						<div class="col-xs-2" style="height: 100px;"></div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<div class="row">
								<div class="col-xs-8 bateria" style="padding: 0px;">
									<span style="font-size: 11px;">Corriente de arranque en frío</span>
									<br>
									<span style="font-size: 11px;">especificaciones de fábrica</span>
								</div>
								<div class="col-xs-4 bateria">
									<input type="text" class="renglon" name="cca" id="cca">
									<span class="cca">CCA</span>
								</div>
							</div>
						</div>
						<div class="col-xs-4 bateria">
							<span style="font-size: 11px;">Corriente de arranque en frío real</span>
						</div>
						<div class="col-xs-2 bateria">
							<input type="text" class="renglon" name="cca_2" id="cca_2">
							<span class="cca">CCA</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-6">												<!-- columna 2 -->									
				<div class="row sin_borde">
					<div class="col-xs-12">
						<p><span><b>SÍMBOLO</b></span>  <i class="fa fa-leaf cuadro_verde"></i> Puede contribuir a la eficiencia del vehículo y la protección del medio ambiente</p>
					</div>
					<div class="col-xs-4">
						<div class="row">
							<div class="col-xs-2">
								<i class="fa fa-square cuadro_verde fa-2x"></i>
							</div>
							<div class="col-xs-10">
								<span>Verificado y </span>
								<br>
								<span>aprobado</span>
							</div>
						</div>					
					</div>
					<div class="col-xs-4">
						<div class="row">
							<div class="col-xs-2">
								<i class="fa fa-square cuadro_amarillo fa-2x"></i>
							</div>
							<div class="col-xs-10">
								<span>Puede requerir </span>
								<br>
								<span>atención en el futuro</span>
							</div>
						</div>					
					</div>
					<div class="col-xs-4">
						<div class="row">
							<div class="col-xs-2">
								<i class="fa fa-square cuadro_rojo fa-2x"></i>
							</div>
							<div class="col-xs-10">
								<span>Requiere</span>
								<br>
								<span>atención inmediata</span>
							</div>
						</div>					
					</div>
				</div>
				<div class="row caja_simple col-derecha i_asignar input_asignar">
					<div class="row">											<!-- bandas/mangueras -->
						<div class="col-xs-10 titulo_apartado_gris">				
							<h6>BANDAS/MANGUERAS</h6>
						</div>
						<div class="col-xs-2 titulo_blanco_apartado">
							<h6>CAMBIADO</h6>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid black;">
						<div class="col-xs-3 luces_parabrisas">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7 luces_parabrisas">
							<span>Pérdidas y/o daños en el sistema de calefacción, ventilación y aire acondicionado y en mangueras/cables</span>
						</div>
						<div class="col-xs-2">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid black;">
						<div class="col-xs-3 luces_parabrisas">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_blanco"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7 luces_parabrisas">
							<span>Sistema de refrigeración del motor, radiador, mangueras ya abrazaderas</span>
						</div>
						<div class="col-xs-2">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid black;">
						<div class="col-xs-3 luces_parabrisas">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_blanco"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7 luces_parabrisas">
							<span>Banda(s) <br> &nbsp;</span>
						</div>
						<div class="col-xs-2">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row">											<!-- sistema de frenos -->
						<div class="col-xs-10 titulo_apartado_gris">				
							<h6>SISTEMA DE FRENOS</h6>
						</div>
						<div class="col-xs-2 titulo_blanco_apartado">
							<h6>CAMBIADO</h6>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid black;">
						<div class="col-xs-3 luces_parabrisas">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7 luces_parabrisas">
							<span class="sist_frenos_print">Sistema de frenos (incluye mangueras y freno de mano) &nbsp;<i class="fa fa-leaf cuadro_verde"></i></span>
							<br>
							<span>&nbsp;</span>
						</div>
						<div class="col-xs-2">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row">											<!-- direccion/suspension -->
						<div class="col-xs-10 titulo_apartado_gris">				
							<h6>DIRECCIÓN/SUSPENSIÓN</h6>
						</div>
						<div class="col-xs-2 titulo_blanco_apartado">
							<h6>CAMBIADO</h6>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid black;">
						<div class="col-xs-3 luces_parabrisas">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7 luces_parabrisas">
							<span>Pérdidas y/o daños en amortiguadores/puntales y otros componentes de la suspensión</span>
						</div>
						<div class="col-xs-2">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid black;">
						<div class="col-xs-3 luces_parabrisas">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7 luces_parabrisas">
							<span>Dirección, varillaje de la dirección y juntas de rótula (visual)</span>
							<br>
							<span>&nbsp;</span>
						</div>
						<div class="col-xs-2">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row">											<!-- SISTEMA DE ESCAPE -->
						<div class="col-xs-10 titulo_apartado_gris">				
							<h6>SISTEMA DE ESCAPE</h6>
						</div>
						<div class="col-xs-2 titulo_blanco_apartado">
							<h6>CAMBIADO</h6>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid black;">
						<div class="col-xs-3 luces_parabrisas">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7 luces_parabrisas">
							<span>Sistema de escape y escudo de calor <span style="font-size: 11px;">(pérdidas, daño, piezas sueltas)</span> &nbsp;<i class="fa fa-leaf cuadro_verde"></i></span>
						</div>
						<div class="col-xs-2">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row">											<!-- tren motriz -->
						<div class="col-xs-10 titulo_apartado_gris">				
							<h6>TREN MOTRIZ</h6>
						</div>
						<div class="col-xs-2 titulo_blanco_apartado">
							<h6>CAMBIADO</h6>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid black;">
						<div class="col-xs-3 luces_parabrisas">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7 luces_parabrisas">
							<span>Funcionamiento del embrague (si está equipado)</span>
							<br>
							<span>&nbsp;</span>
						</div>
						<div class="col-xs-2">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid black;">
						<div class="col-xs-3 luces_parabrisas">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7 luces_parabrisas">
							<span>Transmisión, flecha cardán y lubricación (si necesita)</span>
							<br>
							<span>&nbsp;</span>
						</div>
						<div class="col-xs-2">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row">											<!-- parte inferior del vehiculo -->
						<div class="col-xs-12 titulo_apartado">
							<h6>Parte inferior del vehículo</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-8 vista_inferior">
							<img src="<?=base_url()?>assets/img/vista_inferior.jpg" alt="vista inferior automóvil">
						</div>
						<div class="col-xs-4 vista_inferior">
							<br>
							<p>Anote en el diagrama todos los daños o defectos detectados en la parte inferior de la carrocería durante la revisión en el taller</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row caja_simple i_asignar input_asignar">
			<div class="row titulo_apartado">										<!-- desgaste de naumatico/freno -->
				<div class="col-xs-12">
					<h6>DESGASTE DE NEUMÁTICO/FRENO</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-3 rectangulo_azul">
					<h6>PROFUNDIDAD DE DIBUJO</h6>
				</div>
				<div class="col-xs-3 rectangulo_verde">
					<h6>5 mm y mayor</h6>
				</div>
				<div class="col-xs-3 rectangulo_amarillo">
					<h6>3 a 5 mm</h6>
				</div>
				<div class="col-xs-3 rectangulo_rojo">
					<h6>2 mm y menor</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-3 rectangulo_azul">
					<h6>MEDIDA DE BALATAS</h6>
				</div>
				<div class="col-xs-3 rectangulo_verde">
					<h6>Más de 8 mm</h6>
				</div>
				<div class="col-xs-3 rectangulo_amarillo">
					<h6>4 a 6 mm</h6>
				</div>
				<div class="col-xs-3 rectangulo_rojo">
					<h6>3 mm o menos</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2" style="padding: 0px;">										<!-- comentarios -->
					<div class="row fondo_gris">
						<div class="col-xs-2">
							<i class="fa fa-square fa-2x cambiado_aceite"></i>
						</div>
						<div class="col-xs-10">
							<p>No se tomaron mediciones de los frenos en esta visita de servicio</p>
						</div>
					</div>
					<div class="row fondo_gris">
						<div class="col-xs-2">
							<i class="fa fa-square fa-2x cambiado_aceite"></i>
						</div>
						<div class="col-xs-10">
							<p>Reinicio del indicador de cambio de aceite</p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 comentarios">
							<br>
							<br>
							<p>Comentarios:</p>
							<textarea class="form-control" id="comentscoments"></textarea>
						</div>
					</div>
				</div>
				<div class="col-xs-5 frente_izquierdo" style="padding: 0px;">						<!-- frente izquierdo -->
					<div class="row">
						<div class="col-xs-5 titulo_apartado_gris" style="border: 1px solid black; height: 19px;">
							<h6 style="text-align: left;">FRENTE IZQUIERDO</h6>
						</div>
						<div class="col-xs-5" style="border: 1px solid black; height: 19px;">							
							<i class="fa fa-leaf" style="margin: 0px; color: green;"></i>
						</div>
						<div class="col-xs-2 titulo_blanco_apartado">
							<h6>CAMBIADO</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Profundidad de dibujo del neumático  &nbsp; &nbsp; <input type="text" class="renglon_mm">mm</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Patrón de desgaste/daño del neumático</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid;">
						<div class="col-xs-3" style="border-left: 1px solid black; height: 41px;">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Presión de inflado a PSI según recomendación del fabricante</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="background: #d2d2d2; border-left: 1px solid black;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Espesor de balatas  &nbsp; &nbsp; &nbsp; &nbsp; <input type="text" class="renglon_mm" style="background: #d2d2d2;">mm</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="background: #d2d2d2; border-left: 1px solid black;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Espesor de disco  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input type="text" class="renglon_mm" style="background: #d2d2d2;">mm</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-left: 1px solid;">								<!-- parte trasera izquierda -->
						<div class="col-xs-5 titulo_apartado_gris" style="border: 1px solid black; height: 19px;">
							<h6 style="text-align: left;" class="neum_tit_print">PARTE TRASERA IZQUIERDA</h6>
						</div>
						<div class="col-xs-5" style="border: 1px solid black; height: 19px;">							
							<i class="fa fa-leaf" style="margin: 0px; color: green;"></i>
						</div>
						<div class="col-xs-2 titulo_blanco_apartado">
							<h6>CAMBIADO</h6>
						</div>
					</div>
					<div class="row" style="border-left: 1px solid;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Profundidad de dibujo del neumático  &nbsp; &nbsp; <input type="text" class="renglon_mm">mm</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-left: 1px solid; border-bottom: 1px solid;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Patrón de desgaste/daño del neumático</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid;">
						<div class="col-xs-3" style="border-left: 1px solid black; height: 41px;">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Presión de inflado a PSI según recomendación del fabricante</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="background: #d2d2d2; border-left: 1px solid black;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Espesor de balatas  &nbsp; &nbsp; &nbsp; &nbsp; <input type="text" class="renglon_mm" style="background: #d2d2d2;">mm</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="background: #d2d2d2; border-left: 1px solid black; border-bottom: 1px solid;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Espesor de disco  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input type="text" class="renglon_mm" style="background: #d2d2d2;">mm</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-left: 1px solid black; border-bottom: 1px solid black;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Diámetro de tambor  &nbsp; &nbsp; <input type="text" class="renglon_mm">mm</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
				</div>
				<div class="col-xs-5 frente_izquierdo" style="padding: 0px;">						<!-- frente derecho -->
					<div class="row">
						<div class="col-xs-5 titulo_apartado_gris" style="border: 1px solid black; height: 19px;">
							<h6 style="text-align: left;">FRENTE DERECHO</h6>
						</div>
						<div class="col-xs-5" style="border: 1px solid black; height: 19px;">							
							<i class="fa fa-leaf" style="margin: 0px; color: green;"></i>
						</div>
						<div class="col-xs-2 titulo_blanco_apartado">
							<h6>CAMBIADO</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Profundidad de dibujo del neumático  &nbsp; &nbsp; <input type="text" class="renglon_mm">mm</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Patrón de desgaste/daño del neumático</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid;">
						<div class="col-xs-3" style="border-left: 1px solid black; height: 41px;">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Presión de inflado a PSI según recomendación del fabricante</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="background: #d2d2d2; border-left: 1px solid black;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Espesor de balatas  &nbsp; &nbsp; &nbsp; &nbsp; <input type="text" class="renglon_mm" style="background: #d2d2d2;">mm</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="background: #d2d2d2; border-left: 1px solid black;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Espesor de disco  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input type="text" class="renglon_mm" style="background: #d2d2d2;">mm</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-left: 1px solid;">								<!-- parte trasera derecha -->
						<div class="col-xs-5 titulo_apartado_gris" style="border: 1px solid black; height: 19px;">
							<h6 style="text-align: left;">PARTE TRASERA DERECHA</h6>
						</div>
						<div class="col-xs-5" style="border: 1px solid black; height: 19px;">							
							<i class="fa fa-leaf" style="margin: 0px; color: green;"></i>
						</div>
						<div class="col-xs-2 titulo_blanco_apartado">
							<h6>CAMBIADO</h6>
						</div>
					</div>
					<div class="row" style="border-left: 1px solid;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Profundidad de dibujo del neumático  &nbsp; &nbsp; <input type="text" class="renglon_mm">mm</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-left: 1px solid; border-bottom: 1px solid;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Patrón de desgaste/daño del neumático</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-bottom: 1px solid;">
						<div class="col-xs-3" style="border-left: 1px solid black; height: 41px;">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Presión de inflado a PSI según recomendación del fabricante</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="background: #d2d2d2; border-left: 1px solid black;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Espesor de balatas  &nbsp; &nbsp; &nbsp; &nbsp; <input type="text" class="renglon_mm" style="background: #d2d2d2;">mm</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="background: #d2d2d2; border-left: 1px solid black; border-bottom: 1px solid;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Espesor de disco  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input type="text" class="renglon_mm" style="background: #d2d2d2;">mm</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-left: 1px solid black; border-bottom: 1px solid black;">
						<div class="col-xs-3">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Diámetro de tambor  &nbsp; &nbsp; <input type="text" class="renglon_mm">mm</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
					<div class="row" style="border-left: 1px solid;">								<!-- parte trasera derecha -->
						<div class="col-xs-5 titulo_apartado_gris" style="border: 1px solid black; height: 19px;">
							<h6 style="text-align: left;" class="neum_tit_print">NEUMÁTICO DE REFACCIÓN</h6>
						</div>
						<div class="col-xs-5" style="border: 1px solid black; height: 19px;">							
							<i class="fa fa-leaf" style="margin: 0px; color: green;"></i>
						</div>
						<div class="col-xs-2 titulo_blanco_apartado">
							<h6>CAMBIADO</h6>
						</div>
					</div>
					<div class="row" style="border-left: 1px solid black; border-bottom: 1px solid black;">
						<div class="col-xs-3 neum_cuadros_print">
							<i class="fa fa-square fa-2x cuadro_verde"></i>
							<i class="fa fa-square fa-2x cuadro_amarillo"></i>
							<i class="fa fa-square fa-2x cuadro_rojo"></i>
						</div>
						<div class="col-xs-7" style="padding: 0px;">
							<span>Presión de inflado establecida en  &nbsp; &nbsp; <input type="text" class="renglon_mm">PSI</span>
						</div>
						<div class="col-xs-2" style="border-left: 1px solid black; border-right: 1px solid black; height: 41px;">
							<i class="fa fa-square-o fa-2x cambiado_aceite"></i>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-7" style="padding: 0px; border: 1px solid black; border-right: 6px solid #333;">
					<div class="row">
						<div class="col-xs-12 titulo_apartado_gris">
							<h6>DIAGNÓSTICO</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<input type="text" value="Sistema" class="input_diagnostico" readonly>
						</div>
						<div class="col-xs-4">
							<input type="text" value="Componente" class="input_diagnostico" readonly>
						</div>
						<div class="col-xs-4">
							<input type="text" value="Causa raíz" class="input_diagnostico" readonly>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<!-- se ponen ocultos estos para saltar las lineas de la bateria que se agregaron y no aparezcan en este apartado de diagnostico revisar codigo -->
							<input type="hidden" class="renglon_mm renglon_diagnostico">
							<input type="hidden" class="renglon_mm renglon_diagnostico">
							<input type="hidden" class="renglon_mm renglon_diagnostico">
							<!-- se ponen ocultos estos para saltar las lineas de la bateria que se agregaron y no aparezcan en este apartado de diagnostico revisar codigo -->
							<input type="text" class="renglon_mm renglon_diagnostico">
							<input type="text" class="renglon_mm renglon_diagnostico">
							<input type="text" class="renglon_mm renglon_diagnostico">
						</div>
						<div class="col-xs-4">
							<input type="text" class="renglon_mm renglon_diagnostico">
							<input type="text" class="renglon_mm renglon_diagnostico">
							<input type="text" class="renglon_mm renglon_diagnostico">
						</div>
						<div class="col-xs-4">
							<input type="text" class="renglon_mm renglon_diagnostico">
							<input type="text" class="renglon_mm renglon_diagnostico">
							<input type="text" class="renglon_mm renglon_diagnostico">
						</div>
					</div>
				</div>
				<div class="col-xs-5 div_direccion">
					<h4><?=$sucursal["razon_social"]?></h4>
					<?php 
						$domicilio = $sucursal["dom_calle"]." No."." ".$sucursal["dom_numExt"]." ".$sucursal["dom_colonia"]." C.P. ".$sucursal["dom_cp"]." ".$sucursal["dom_ciudad"]." ".$sucursal["dom_estado"]." Tel.".$sucursal["telefono"];
					?>
					<p><?=$domicilio?>
					<br>
					R.F.C. <?=$sucursal["rfc"]?></p>
					<!-- <p class="dir_sitio">ford.mx/servicio</p> -->
					<span class="dir_sitio_texto">Un sitio para todas las necesidades de su vehículo</span>
					
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-xs-6">			
				<label>Nombre del asesor:</label> <input type="text" class="renglon" style="width: 79%;" id="nombre_asesor">
			</div>
			<div class="col-xs-6">
				<?php 
					$nombre_tecnico = $orden_inspeccion["rev_tecnico"]["tecnico_inspeccion"];
				?>			
				<label>Nombre del Técnico:</label> <input type="text" class="renglon" style="width: 78%;" value="<?=$nombre_tecnico?>">
			</div>
		</div>
		<br>
		<?php
            $attributes = array('id' => 'formFirma');
            echo form_open('',$attributes);
        ?>
		<div class="row">
			<div class="col-xs-6"></div>
			<div class="col-xs-5">
				<label for="">Firma Cliente</label>
	            <div id="div_firma_usu">
	            </div>
	            <img class="firma_cliente" id="firma_cliente" src="<?=$firma_cliente['firma_multipuntos']?>" style="width: 50%; display: none">
	            <input type="hidden" name="firma_usu" id="firma_usu">
	            <input type="hidden" name="id_orden_hidden" id="id_orden_hidden">
            </div>
            <div class="col-xs-1">
            	<button class="btn btn-danger" id="btn_borrarFirmaUsu"><i class="fa fa-eraser"></i>
            	</button><br>
            	<button class="btn btn-success" id="btn_saveFirmaUsu" style="margin-top: 10px;"><i class="fa fa-save"></i> Guardar Firma
            	</button>
            </div>
		</div>
		<?php
            echo form_close();
        ?>
		<div class="row">
			<div class="col-xs-6">
				<span class="original_cliente">ORIGINAL CLIENTE</span>
			</div>
			<div class="col-xs-6">
				<span class="derechos_reservados">©2014, Ford Motor Company, Todos los Derechos Reservados</span>
			</div>
		</div>
		<br>
		<div>
			<span class="titulo_vertical1">USO EXCLUSIVO TÉCNICO</span>
		</div>
		<div>
			<span class="titulo_vertical2">USO EXCLUSIVO TÉCNICO</span>
		</div>
	</div>
	</div>
</body>
</html>