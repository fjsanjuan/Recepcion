<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<head>
<link rel="stylesheet" href="<?=base_url()?>assets/librerias/fontawesome-free-5.2.0-web/css/all.css"/>
<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" media="all">
<link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">

<script src="<?=base_url()?>assets/js/jquery.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/librerias/html2canvas/html2canvas.js"></script>
<script src="<?=base_url()?>assets/librerias/html2canvas/html2canvas.min.js"></script>
<title>Orden de Servicio</title>
</head>
<script>
$( document ).ready(function() {
	var img = "";
	var cajuela = "<?=$inspeccion['cajuela']?>";
	cajuela = cajuela.split(",");
	var exteriores = "<?=$inspeccion['exteriores']?>";
	exteriores = exteriores.split(",");
	var documentacion = "<?=$inspeccion['documentacion']?>";
	documentacion = documentacion.split(",");
	var ids_cajuela = [];
	var ids_exteriores = [];
	var ids_documentacion = [];
	var dejaArticulos = "<?=$inspeccion['dejaArticulos']?>";
	//se extrae lo contenido en la varible de luces tablero 
	var luces_tablero   = "<?=$inspeccion['luces_tablero']?>";
	//se hace el conteo de el contenido de la variable para evitar problemas al mostrar la info
	var cont_lucs_tblero = luces_tablero.length;
	luces_tablero = luces_tablero.split(",");
	var claxon      = "<?=$inspeccion['claxon']?>";
	var luces_int   = "<?=$inspeccion['luces_int']?>";
	luces_int = luces_int.split(",");
	var radio       = "<?=$inspeccion['radio']?>";
	var pantalla    = "<?=$inspeccion['pantalla']?>";
	var ac          = "<?=$inspeccion['ac']?>";
	var encendedor  = "<?=$inspeccion['encendedor']?>";
	var vidrios     = "<?=$inspeccion['vidrios']?>";
	var espejos     ="<?=$inspeccion['espejos']?>";
	var seguros_ele ="<?=$inspeccion['seguros_ele']?>";
	var co          ="<?=$inspeccion['co']?>";
	var asientosyvesti ="<?=$inspeccion['asientosyvesti']?>";
	var tapetes     ="<?=$inspeccion['tapetes']?>";

	var operaint = [];

	//console.log(documentacion);
	//console.log(documentacion[1]);

	//validar campo de seguro de rines
	if(documentacion[1] == "n/a"){
		$("#i_seguro_rines").append("NC");
	}
	else{
		$("#i_seguro_rines").append("<i class='fa fa-check'></i>");
	}
	if(dejaArticulos == "Si")
	{
		$("#artpersonales_si").val("x").css({"text-align":"center", "font-weight":"bold"});
	}else 
	{
		$("#artpersonales_no").val("x").css({"text-align":"center", "font-weight":"bold"});
	}

	//validar contenido de la variable del tablero si es 0 es por que no tiene ningun contenido en los registro de la tabla por ser campo nuevo
	if(cont_lucs_tblero > 0){
		switch(luces_tablero[0]) {
		  case "motor_on":
		    $("#i_motor_luz").append("<i class='fa fa-times'></i>");
		    break;
		  case "motor_nc":
		  	$("#i_motor_luz").append("NC");
		    break;
		  default:
		    // code block
		}
		switch(luces_tablero[1]) {
		  case "servicio_on":
		    $("#i_servicio_luz").append("<i class='fa fa-times'></i>");
		    break;
		  case "servicio_nc":
		  	$("#i_servicio_luz").append("NC");
		    break;
		  default:
		    // code block
		}
		switch(luces_tablero[2]) {
		  case "abs_on":
		    $("#i_abs_luz").append("<i class='fa fa-times'></i>");
		    break;
		  case "abs_nc":
		  	$("#i_abs_luz").append("NC");
		    break;
		  default:
		    // code block
		}
		switch(luces_tablero[3]) {
		  case "frenosluz_on":
		    $("#i_frenos_luz").append("<i class='fa fa-times'></i>");
		    break;
		  case "frenosluz_nc":
		  	$("#i_frenos_luz").append("NC");
		    break;
		  default:
		    // code block
		}
		switch(luces_tablero[4]) {
		  case "frenosluzp_on":
		    $("#i_frenosp_luz").append("<i class='fa fa-times'></i>");
		    break;
		  case "frenosluzp_nc":
		  	$("#i_frenosp_luz").append("NC");
		    break;
		  default:
		    // code block
		}
		switch(luces_tablero[5]) {
		  case "airbag_on":
		    $("#i_airbag_luz").append("<i class='fa fa-times'></i>");
		    break;
		  case "airbag_nc":
		  	$("#i_airbag_luz").append("NC");
		    break;
		  default:
		    // code block
		}
		switch(luces_tablero[6]) {
		  case "presionaire_on":
		    $("#i_presionaire_luz").append("<i class='fa fa-times'></i>");
		    break;
		  case "presionaire_nc":
		  	$("#i_presionaire_luz").append("NC");
		    break;
		  default:
		    // code block
		}
		switch(luces_tablero[7]) {
		  case "bateria_on":
		    $("#i_bateria_luz").append("<i class='fa fa-times'></i>");
		    break;
		  case "bateria_nc":
		  	$("#i_bateria_luz").append("NC");
		    break;
		  default:
		    // code block
		}
	}

	if(claxon == "NO" ){
		$("#i_claxon").append("<i class='fa fa-times'></i>");
	}else if(claxon == "No cuenta"){
		$("#i_claxon").append("NC");
	}else{
		$("#i_claxon").append("<i class='fa fa-check'></i>");
	}
	//console.log(luces_int[0])
	//luces varias
	if(luces_int[0] == "NO" ){
		$("#i_luces_int").append("<i class='fa fa-times'></i>");
	}else if(luces_int[0] == "No cuenta"){
		$("#i_luces_int").append("NC");
	}else if(luces_int[0] == "SI"){
		$("#i_luces_int").append("<i class='fa fa-check'></i>");
	}
	if(luces_int[1] == "NO" ){
		$("#i_luces_delant").append("<i class='fa fa-times'></i>");
	}else if(luces_int[1] == "No cuenta"){
		$("#i_luces_delant").append("NC");
	}else if(luces_int[1] == "SI"){
		$("#i_luces_delant").append("<i class='fa fa-check'></i>");
	}
	if(luces_int[2] == "NO" ){
		$("#i_luces_traseras").append("<i class='fa fa-times'></i>");
	}else if(luces_int[2] == "No cuenta"){
		$("#i_luces_traseras").append("NC");
	}else if(luces_int[2] == "SI"){
		$("#i_luces_traseras").append("<i class='fa fa-check'></i>");
	}
	if(luces_int[3] == "NO" ){
		$("#i_luces_stop").append("<i class='fa fa-times'></i>");
	}else if(luces_int[3] == "No cuenta"){
		$("#i_luces_stop").append("NC");
	}else if(luces_int[3] == "SI"){
		$("#i_luces_stop").append("<i class='fa fa-check'></i>");
	}
	//luces varias
	if(radio == "NO" ){
		$("#i_radio").append("<i class='fa fa-times'></i>");
	}else if(encendedor == "No cuenta"){
		$("#i_radio").append("NC");
	}else{
		$("#i_radio").append("<i class='fa fa-check'></i>");
	}
	if(pantalla == "NO" ){
		$("#i_pantalla").append("<i class='fa fa-times'></i>");
	}else if(pantalla == "No cuenta"){
		$("#i_pantalla").append("NC");
	}else{
		$("#i_pantalla").append("<i class='fa fa-check'></i>");
	}
	if(encendedor == "NO" ){
		$("#i_encendedor").append("<i class='fa fa-times'></i>");
	}else if(encendedor == "No cuenta"){
		$("#i_encendedor").append("NC");
	}else{
		$("#i_encendedor").append("<i class='fa fa-check'></i>");
	}
	if(ac == "NO" ){
		$("#i_ac").append("<i class='fa fa-times'></i>");
	}else if(ac == "No cuenta"){
		$("#i_ac").append("NC");
	}else{
		$("#i_ac").append("<i class='fa fa-check'></i>");
	}
	if(vidrios == "NO" ){
		$("#i_vidrios").append("<i class='fa fa-times'></i>");
	}else if(vidrios == "No cuenta"){
		$("#i_vidrios").append("NC");
	}else{
		$("#i_vidrios").append("<i class='fa fa-check'></i>");
	}
	if(espejos == "NO" ){
		$("#i_espejos").append("<i class='fa fa-times'></i>");
	}else if(espejos == "No cuenta"){
		$("#i_espejos").append("NC");
	}else{
		$("#i_espejos").append("<i class='fa fa-check'></i>");
	}
	if(seguros_ele == "NO" ){
		$("#i_seguros_ele").append("<i class='fa fa-times'></i>");
	}else if(seguros_ele == "No cuenta"){
		$("#i_seguros_ele").append("NC");
	}else{
		$("#i_seguros_ele").append("<i class='fa fa-check'></i>");
	}
	if(co == "NO" ){
		$("#i_co").append("<i class='fa fa-times'></i>");
	}else if(seguros_ele == "No cuenta"){
		$("#i_co").append("NC");
	}else{
		$("#i_co").append("<i class='fa fa-check'></i>");
	}
	if(asientosyvesti == "NO" ){
		$("#i_asientosyvesti").append("<i class='fa fa-times'></i>");
	}else if(seguros_ele == "No cuenta"){
		$("#i_asientosyvesti").append("NC");
	}else{
		$("#i_asientosyvesti").append("<i class='fa fa-check'></i>");
	}
	if(tapetes == "NO" ){
		$("#i_tapetes").append("<i class='fa fa-times'></i>");
	}else if(seguros_ele == "No cuenta"){
		$("#i_tapetes").append("NC");
	}else{
		$("#i_tapetes").append("<i class='fa fa-check'></i>");
	}


	function obtener_spanIds()
	{
		var span_cajuela = $(".tabla_cajuela").find("span");
		var span_exteriores = $(".tabla_exteriores").find("span");
		var span_documentacion = $(".tabla_documentacion").find("span");
		
		$.each(span_cajuela, function(index, val) 
		{
			ids_cajuela.push(val.id);
		});

		$.each(span_exteriores, function(index, val) 
		{
			ids_exteriores.push(val.id);
		});

		ids_exteriores.shift();

		$.each(span_documentacion, function(index, val) 
		{
			ids_documentacion.push(val.id);
		});

		ids_documentacion.shift();
	}

	obtener_spanIds();

	function llenar_tablas()
	{
		if(cajuela.length > 0)
		{
			$.each(ids_cajuela, function(index, val)
			{	
				$.each(cajuela, function(indice, valor)
				{
					if(index == indice)
					{
						if(valor == "n/a" || valor == "N/a")
						{
							$("#"+val+"").append("<i class='fa fa-times'></i>");
						}else 
						{
							$("#"+val+"").append("<i class='fa fa-check'></i>");
						}						
					}
				});
			});
		}

		if(exteriores.length > 0)
		{
			$.each(ids_exteriores, function(index, val)
			{	
				$.each(exteriores, function(indice, valor)
				{
					if(index == indice)
					{
						if(valor == "n/a" || valor == "N/a")
						{
							$("#"+val+"").append("<i class='fa fa-times'></i>");
						}else 
						{
							$("#"+val+"").append("<i class='fa fa-check'></i>");
						}						
					}
				});
			});
		}

		if(documentacion.length > 0)
		{
			$.each(ids_documentacion, function(index, val)
			{	
				$.each(documentacion, function(indice, valor)
				{
					if(index == indice)
					{
						if(valor == "n/a" || valor == "N/a")
						{
							$("#"+val+"").append("<i class='fa fa-times'></i>");
						}else 
						{
							$("#"+val+"").append("<i class='fa fa-check'></i>");
						}						
					}
				});
			});
		}
	}


	llenar_tablas();
	
	function genIMG()
	{
		html2canvas($(".subcuerpo_frente"),{
		   onrendered:function(canvas){
			   img = canvas.toDataURL("image/png");
			   localStorage.setItem("formato_base64", img);
		   }
	    });
	}

	$("#boton").click(function(){
		genIMG();	
	});

	$("#boton").click();

	var tipo_orden = "<?=$cliente['tipo_orden']?>";

	switch (tipo_orden) 
	{
		case "Garantia":
			$("#tipo_ordenG").prop("checked", true).next().remove("i");
			$("#tipo_ordenG").prop("checked", true).next().prepend('<i class="far fa-dot-circle"></i>  ');
		break;
		case "Interno":
			$("#tipo_ordenI").prop("checked", true).next().remove("i");
			$("#tipo_ordenI").prop("checked", true).next().prepend('<i class="far fa-dot-circle"></i>  ');
		break;
		case "Publico":
			$("#tipo_ordenP").prop("checked", true).next().remove("i");
			$("#tipo_ordenP").prop("checked", true).next().prepend('<i class="far fa-dot-circle"></i>  ');
		break;
		case "Seguro":
			$("#tipo_ordenExt").prop("checked", true).next().remove("i");
			$("#tipo_ordenExt").prop("checked", true).next().prepend('<i class="far fa-dot-circle"></i>  ');
		break;
		default:
			$("#tipo_ordenP").prop("checked", true).next().remove("i");
			$("#tipo_ordenP").prop("checked", true).next().prepend('<i class="far fa-dot-circle"></i>  ');
		break;
	}

	var gasolina = "<?=$inspeccion['gasolina']?>";

	switch (gasolina)
    {
        case "V":
        	$("#img_gasolina").prop("src", "<?=base_url()?>assets/img/gasolina/V.PNG");
        break;
        case "1/8":
        	$("#img_gasolina").prop("src", "<?=base_url()?>assets/img/gasolina/18.PNG");
        break;
        case "1/4":
        	$("#img_gasolina").prop("src", "<?=base_url()?>assets/img/gasolina/14.PNG");
        break;
        case "3/8":
        	$("#img_gasolina").prop("src", "<?=base_url()?>assets/img/gasolina/38.PNG");
        break;
        case "1/2":
        	$("#img_gasolina").prop("src", "<?=base_url()?>assets/img/gasolina/12.PNG");
        break;
        case "5/8":
        	$("#img_gasolina").prop("src", "<?=base_url()?>assets/img/gasolina/58.PNG");
        break;
        case "3/4":
        	$("#img_gasolina").prop("src", "<?=base_url()?>assets/img/gasolina/34.PNG");
        break;
        case "7/8":
        	$("#img_gasolina").prop("src", "<?=base_url()?>assets/img/gasolina/78.PNG");
        break;
        case "LL":
        	$("#img_gasolina").prop("src", "<?=base_url()?>assets/img/gasolina/LL.PNG");
        break;
        default:
        	$("#img_gasolina").prop("src", "<?=base_url()?>assets/img/gasolina/V.PNG");
        break;
    }

    function formatear_numero(numero)
	{
	    var num = numero.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

	    return num;
	}

	$.each($("input.formatear"), function(index, val) 
	{
		var valor = $(this).val();
		valor = formatear_numero(valor);

		$(this).val(valor);
	});

	$.each($("span.formatear"), function(index, val) 
	{
		var texto = $(this).text();
		texto = formatear_numero(texto);

		$(this).text(texto);
	});


});
</script>
<style>
	body {
		font-family: Arial !important;
	}

	.container {
		max-width: 1140px !important;
		max-height: 2097px !important;
	}
</style>
<body>
	<button style="display: none;" id="boton">Generar PDF</button>
	<input type="hidden" id="base_64">
	<div class="subcuerpo_frente">
	<br>
	<br>
	<div class="container borde_general" id="PDFcontent">
		<div class="row row_uno">
			<div class="col-3 div_uno">
				<div class="col-12">
					<center><img src="<?=base_url(). $sucursal['ruta_logo']?>" alt="logo Ford" class="logoFord"></center>
				</div>
				<div class="col-12">
					<p><center><b><?=$sucursal["razon_social"]?></b></center></p>
				</div>
			</div>
			<div class="col-6 div_dos">
				<p>
				<b><?=$sucursal["razon_social"]?></b>
				<br>
				<?=$sucursal["dom_calle"]." ".$sucursal["dom_numExt"].", ".$sucursal["dom_colonia"]." C.P.".$sucursal["dom_cp"]?>
				<br>
				<?=$sucursal["dom_ciudad"].", ".$sucursal["dom_estado"]." Tel.".$sucursal["telefono"]." R.F.C. ".$sucursal["rfc"]?>
				<br>
				CED EMP <u><?=$sucursal["cedula_empresarial"]?></u> REG. CAM  NAL. COM <u><?=$sucursal["reg_cam_nal_com"]?></u>
				<!-- CED EMP <?=$sucursal["cedula_empresarial"]?> REG. CAM  NAL. COM ________________ -->
				<br>
				Email: <?=$sucursal["email_contacto"]?>  Web: <?=$sucursal["sitio_web"]?>
				<br>
				Horario en Recepción y Entrega de Unidades: <?=$sucursal["horario_recep"]?>
				<!--
				<br>
				Horario de Caja: <?=$sucursal["horario_caja"]?> 
				</p>
				-->
			</div>
			<div class="col-3 div_tres">
				<div class="col-12">
					<p><center><b>Orden de Servicio</b></center></p>
				</div>
			</div>
		</div>
		<div class="row row_dos">
			<div class="col-1">
				<p class="etiquetas_encabezado"><b>Asesor</b></p>
			</div>
			<div class="col-8">
				<input type="text" name="input_nomAsesor" id="input_nomAsesor" class="input_sinBorde" value="<?=$cliente['asesor']?>">
			</div>
			<div class="col-1">
				<p class="etiquetas_encabezado"><b>Folio</b></p>
			</div>
			<div class="col-2">
				<input type="text" name="input_torre" value="<?=$cliente['MovID']?>" id="input_folio1" class="input_bordeInferior">
			</div>
		</div>
		<div class="row">
			<div class="col-9"></div>
			<div class="col-1">
				<p class="etiquetas_encabezado"><b>Torre</b></p>
			</div>
			<div class="col-2">
				<input type="text" name="input_torre" value="<?=$cliente['torrecolor'].' '.$cliente['torrenumero']?>" id="input_torre" class="input_bordeInferior">
			</div>
		</div>
		<div class="row row_tres">
			<div class="col-2">
				<p class="etiquetas_encabezado"><b>Fecha Recepción</b></p>
			</div>
			<div class="col-1">
				<?php 
					$cliente["fecha_recepcion"] = explode(" ", $cliente["fecha_recepcion"]);
					$fecha_recepcion = date("d-m-Y", strtotime($cliente['fecha_recepcion'][0]));
				?>
				<input type="text" name="input_frecepcion" id="input_frecepcion" class="input_sinBorde_fechas" value="<?=$fecha_recepcion?>">
			</div>
			<div class="col-2">
				<p class="etiquetas_encabezado"><b>Hora Recepción</b></p>
			</div>
			<div class="col-1">
				<input type="text" name="input_hrecepcion" id="input_hrecepcion" class="input_sinBorde_fechas" value="<?=$cliente['hora_recepcion']?>">
			</div>
			<?php 
				$cliente["fecha_entrega"] = explode(" ", $cliente["fecha_entrega"]);
				$fecha_entrega = date("d-m-Y", strtotime($cliente['fecha_entrega'][0]));
			?>
			<div class="col-2">
				<p class="etiquetas_encabezado"><b>Fecha Entrega</b></p>
			</div>
			<div class="col-1">
				<input type="text" name="input_fentrega" id="input_fentrega" class="input_sinBorde_fechas" value="<?=$fecha_entrega?>">
			</div>
			<div class="col-2">
				<p class="etiquetas_encabezado"><b>Hora Entrega</b></p>
			</div>
			<div class="col-1">
				<input type="text" name="input_fentrega" id="input_fentrega" class="input_sinBorde_fechas" value="<?=$cliente['hRequerida']?>"> <!--Se cambio  hora_entrega a hRequerida-->
			</div>
		</div>
		<div class="row row_cuatro">
			<div class="col-12">
				<p>DATOS DEL CONSUMIDOR</p>
			</div>
		</div>
		<div class="row row_cinco">
			<div class="col-2">
				<?php
					if($cliente["regimen"] == "fisica")
					{
						$nombre_cliente = $cliente['nombre_cliente'];
						$ap_paterno = $cliente['ap_cliente'];
						$ap_materno = $cliente['am_cliente'];
						$nom_compania = "";
					}else 
					{
						$nombre_cliente = "";
						$ap_paterno = "";
						$ap_materno = "";
						$nom_compania = $cliente['nombre_cliente'];
					}
				?>
				<label>Nombre(s) del Consumidor</label>
			</div>
			<div class="col-2">
				<input type="text" name="input_nomCons" id="input_nomCons" class="input_sinBorde" value="<?=$nombre_cliente?>">
			</div>
			<div class="col-2">
				<label>Apellido Paterno</label>
			</div>
			<div class="col-2">
				<input type="text" name="input_appaterno" id="input_appaterno" class="input_sinBorde" value="<?=$ap_paterno?>">
			</div>
			<div class="col-2">
				<label>Apellido Materno</label>
			</div>
			<div class="col-2">
				<input type="text" name="input_appaterno" id="input_appaterno" class="input_sinBorde" value="<?=$ap_materno?>">
			</div>
		</div>
		<div class="row row_seis">
			<div class="col-2">
				<label>Nombre de la Compañía</label>
			</div>
			<div class="col-10">
				<input type="text" name="input_nomComp" id="input_nomComp" class="input_sinBorde" value="<?=$nom_compania?>">
			</div>
		</div>
		<div class="row row_siete">
			<div class="col-4" style="border-right: 1px solid #000;">
				<div class="col-12">
					<label>Nombre(s) del Contacto de la compañía</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_nomCont" id="input_nomCont" class="input_sinBorde" value="<?=$cliente['nom_contacto_compania']?>">
				</div>
			</div>
			<div class="col-3" style="border-right: 1px solid #000;">
				<div class="col-12">
					<label>Apellido Paterno del Contacto</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_appaternoC" id="input_appaternoC" class="input_sinBorde" value="<?=$cliente['ap_contacto_compania']?>">
				</div>
			</div>
			<div class="col-1" style="border-right: 1px solid #000;">

			</div>
			<div class="col-4">
				<div class="col-12">
					<label>Apellido Materno del Contacto</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_apmaternoC" id="input_apmaternoC" class="input_sinBorde" value="<?=$cliente['am_contacto_compania']?>">
				</div>
			</div>
		</div>
		<div class="row row_ocho">
			<div class="col-4" style="border-right: 1px solid #000;">
				<div class="col-12">
					<label>Correo Electrónico del Consumidor</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_nomCont" id="input_nomCont" class="input_sinBorde" value="<?=$cliente['email_cliente']?>">
				</div>
			</div>
			<div class="col-3" style="border-right: 1px solid #000;">
				<div class="col-12">
					<label>RFC</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_appaternoC" id="input_appaternoC" class="input_sinBorde" value="<?=$cliente['rfc_cliente']?>">
				</div>
			</div>
			<div class="col-1" style="border-right: 1px solid #000;">

			</div>
			<div class="col-4">
				<div class="col-12">
					<label>Correo Electrónico de la Compañía</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_apmaternoC" id="input_apmaternoC" class="input_sinBorde" value="<?=$cliente['email_compania']?>">
				</div>
			</div>
		</div>
		<div class="row row_nueve">
			<div class="col-4" style="border-right: 1px solid #000;">
				<div class="col-12">
					<label>Dirección (Calle, No. Exterior, No. Interior, Colonia)</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_dir" id="input_dir" class="input_sinBorde" value="<?=$cliente['dir_calle']?>">
				</div>
			</div>
			<div class="col-3" style="border-right: 1px solid #000;">
				<div class="col-12" style="height: 32px;">
					
				</div>
				<div class="col-12">
					<input type="text" name="input_dir" id="input_dir" class="input_sinBorde" value="<?=$cliente['dir_num_ext']?>">
				</div>
			</div>
			<div class="col-1" style="border-right: 1px solid #000;">
				<div class="col-12" style="height: 32px;">
					
				</div>
				<div class="col-12">
					<input type="text" name="input_dir" id="input_dir" class="input_sinBorde" value="<?=$cliente['dir_num_int']?>">
				</div>
			</div>
			<div class="col-4">
				<div class="col-12" style="height: 32px;">
					
				</div>
				<div class="col-12">
					<input type="text" name="input_dir" id="input_dir" class="input_sinBorde" value="<?=$cliente['dir_colonia']?>">
				</div>
			</div>
		</div>
		<div class="row row_diez">
			<div class="col-4" style="border-right: 1px solid #000;">
				<div class="col-12">
					<label>Municipio/Delegación</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_nomCont" id="input_nomCont" class="input_sinBorde" value="<?=$cliente['dir_municipio']?>">
				</div>
			</div>
			<div class="col-3" style="border-right: 1px solid #000;">
				<div class="col-12">
					
				</div>
				<div class="col-12">

				</div>
			</div>
			<div class="col-1" style="border-right: 1px solid #000;">
				<div class="col-12">
					<label>Código Postal</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_cp" id="input_cp" class="input_sinBorde" value="<?=$cliente['dir_cp']?>">
				</div>
			</div>
			<div class="col-2" style="border-right: 1px solid #000;">
				<div class="col-12">
					<label>Estado</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_estado" id="input_estado" class="input_sinBorde" value="<?=$cliente['dir_estado']?>">
				</div>
			</div>
			<div class="col-2">
				
			</div>
		</div>
		<div class="row row_once">
			<div class="col-6" style="border-right: 1px solid #000;">
				<div class="col-12">
					<label>Teléfono Móvil</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_telm" id="input_telm" class="input_sinBorde" value="<?=$cliente['tel_movil']?>">
				</div>
			</div>
			<div class="col-6">
				<div class="col-12">
					<label>Otro Teléfono</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_otrotel" id="input_otrotel" class="input_sinBorde" value="<?=$cliente['otro_tel']?>">
				</div>
			</div>
		</div>
		<div class="row row_doce">
			<div class="col-12">
				<p>DATOS DEL VEHÍCULO</p>
			</div>
		</div>
		<div class="row row_trece">
			<div class="col-4" style="border-right: 1px solid #000;">
				<div class="col-12">
					<label>Placas del Vehículo</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_placas" id="input_placas" class="input_sinBorde" value="<?=$cliente['placas_v']?>">
				</div>
			</div>
			<div class="col-4" style="border-right: 1px solid #000;">
				<div class="col-12">
					<label>Número de Identificación Vehicular</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_numIdVeh" id="input_numIdVeh" class="input_sinBorde" value="<?=$cliente['vin_v']?>">
				</div>
			</div>
			<div class="col-4">
				<div class="col-12">
					<label>Kilometraje</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_km" id="input_km" class="input_sinBorde" value="<?=$cliente['kilometraje_v']?>">
				</div>
			</div>
		</div>
		<div class="row row_catorce">
			<div class="col-4" style="border-right: 1px solid #000;">
				<div class="col-12">
					<label>Marca/ Línea del Vehículo</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_marca" id="input_marca" class="input_sinBorde" value="<?=$sucursal['sucursal_marca']?>">
				</div>
			</div>
			<div class="col-4" style="border-right: 1px solid #000;">
				<div class="col-12">
					<label>Año Modelo</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_anio" id="input_anio" class="input_sinBorde" value="<?=$cliente['anio_modelo_v']?>">
				</div>
			</div>
			<div class="col-4">
				<div class="col-12">
					<label>Color</label>
				</div>
				<div class="col-12">
					<input type="text" name="input_color" id="input_color" class="input_sinBorde" value="<?=$cliente['color_v']?>">
				</div>
			</div>
		</div>
		<div class="row row_quince">
			<div class="col-12">
				<h6>TIPO DE ORDEN (Para uso exclusivo del Distribuidor)</h6>
			</div>
		</div>
		<div class="row row_dieciseis">
			<div class="col-4">
				<input type="radio" name="tipo_orden" id="tipo_ordenP" style="display: none;">
				<i class="far fa-circle fa-xs"></i>
				<label for="tipo_ordenP" class="label_radio">Público</label> <label>(La reparación es pagada por el cliente)</label>
			</div>
			<div class="col-4">
				<input type="radio" name="tipo_orden" id="tipo_ordenG" style="display: none;">
				<i class="far fa-circle fa-xs"></i>
				<label for="tipo_ordenG" class="label_radio">Garantía</label> <label>(La reparación es pagada por Ford México)</label>
			</div>
			<div class="col-4">
				<input type="radio" name="tipo_orden" id="tipo_ordenHP" style="display: none;">
				<i class="far fa-circle fa-xs"></i>
				<label for="tipo_ordenHP" class="label_radio">Hojalatería y Pintura</label> <label>(Reparación de partes exteriores del vehículo)</label>
			</div>
		</div>
		<div class="row row_diecisiete">
			<div class="col-6 derecha">
				<input type="radio" name="tipo_orden" id="tipo_ordenI" style="display: none;">
				<i class="far fa-circle fa-xs"></i>
				<label for="tipo_ordenI" class="label_radio">Interna</label> <label>(Reparación de unidades del Distribuidor)</label>
			</div>
			<div class="col-6">
				<input type="radio" name="tipo_orden" id="tipo_ordenExt" style="display: none;">
				<i class="far fa-circle fa-xs"></i>
				<label for="tipo_ordenI" class="label_radio">Extensión de Garantía</label> <label>(Órdenes con contrato de Extensión de Garantía)</label>
			</div>
		</div>
		<div class="row row_dieciocho">
			<div class="col-10" style="border-right: 1px solid #000;">
				<label class="label_radio">DESCRIPCIÓN DEL TRABAJO Y DESGLOSE DEL PRESUPUESTO</label>
			</div>
			<div class="col-2">
				<label class="label_radio">IMPORTE (Moneda Nacional)</label>
			</div>
		</div>
		<div class="row row_diecinueve">
			<div class="col-10" style="border-right: 1px solid #000;">
				<div class="textarea_d"><?php 
						foreach ($desglose as $key => $value) 
						{
							if($key <= 5)
							{
								echo "- Descripción: ".$value["descripcion"]." Cantidad: ".$value["cantidad"]." Precio Unitario $".$value["precio_unitario"];
								echo "<br>";
							}
						}
						//echo "<br>";
						echo "Comentario Cliente : ".$cliente['comentario_cliente'];
					?>
				</div>
			</div>
			<div class="col-2">
				<div class="textarea_i"><?php
						foreach ($desglose as $key => $value) 
						{
							if($key <= 5)
							{
								echo "$ <span class='formatear'>".$value["total"]."</span>";
								echo "<br>";
							}				
						}
					?>
				</div>
			</div>
		</div>
		<div class="row row_veinte">
			<div class="col-10" style="border-right: 1px solid #000;">
				<div class="col-12 derecha">
					<label class="label_radio">SUB-TOTAL</label>
				</div>
				<div class="col-12 derecha">
					<label class="label_radio">I.V.A.</label>
				</div>
				<div class="col-12 derecha">
					<label class="label_radio">PRESUPUESTO TOTAL</label>
				</div>
			</div>
			<div class="col-2">
				<div class="col-12">
					<label class="label_radio">$</label> <input type="text" name="input_subtotcant" class="input_sinBorde formatear" style="width: 70%;" value="<?=$cliente['subtotal_orden']?>"> <label class="label_radio">M.N.</label>
				</div>
				<div class="col-12">
					<label class="label_radio">$</label> <input type="text" name="input_ivacant" class="input_sinBorde formatear" style="width: 70%;" value="<?=$cliente['iva_orden']?>"> <label class="label_radio">M.N.</label>
				</div>
				<div class="col-12">
					<label class="label_radio">$</label> <input type="text" name="input_presupcant" class="input_sinBorde formatear" style="width: 70%;" value="<?=$cliente['total_orden']?>"> <label class="label_radio">M.N.</label>
				</div>			
			</div>
		</div>
		<div class="row row_veintiuno">
			<div class="col-10" style="border-right: 1px solid #000;">
				<div class="col-12 derecha">
					<label class="label_radio">ANTICIPO</label>
				</div>
				<div class="col-12 derecha">
					<label class="label_radio">SALDO RESTANTE</label>
				</div>
			</div>
			<div class="col-2">
				<div class="col-12">
					<label class="label_radio">$</label> <input type="text" name="input_anticipcant" class="input_sinBorde" style="width: 70%;"> <label class="label_radio">M.N.</label>
				</div>
				<div class="col-12">
					<label class="label_radio">$</label> <input type="text" name="input_saldorcant" class="input_sinBorde" style="width: 70%;"> <label class="label_radio">M.N.</label>
				</div>
			</div>
		</div>
		<div class="row row_veintidos">
			<div class="col-12 texto">
				<p>Este presupuesto tiene una vigencia de 3 (tres) días hábiles. Si después del diagnóstico y presupuesto, durante la reparación los precios de refacciones sufriesen algún cambio debido a fluctuaciones cambiadas, antes de hacer el trabajo se recabará autorización del cliente. El pago deberá ser efectuado en efectivo o mediante tarjeta de crédito o débito bancaria, a la entrega de la unidad. Se requerirá anticipo en el caso de la cláusula #14. En caso de cancelación aplican los cargos descritos en la cláusula 9.</p>
			</div>
		</div>
		<div class="row row_veintitres">
			<div class="col-12">
				<label class="label_radio">DIAGNÓSTICO Y POSIBLES CONSECUENCIAS</label>
			</div>
		</div>
		<div class="row row_veinticuatro">
			<div class="col-12">
				<p class="texto">Para elaborar el diagnóstico de <input type="text" name="" style="border: none;"> del vehículo, autorizo en forma expresa a desarmar las partes indispensables del mismo y sus componentes, a efecto de obtener un diagnóstico adecuado de él, en el entendido de que el vehículo se me devolverá en las mismas condiciones en que fuera entregado, excepto en caso de que como consecuencia inevitable resulte imposible o ineficaz para su funcionamiento así entregarlo, por causa no imputable al proveedor, la cual sí (  ) no (  ) acepto. En todo caso me obligo a pagar el importe del diagnóstico y los trabajos necesarios para realizarlo en caso de no autorizar la reparación en términos del contrato y acepto que el diagnóstico se realice en un plazo de <input type="text" name="" style="border: none; width: 5%;"> hábiles a partir de la firma del presente.</p>
			</div>
		</div>
		<div class="row row_veinticinco">
			<div class="col-3">
				<div class="col-12" style="padding-top: 42px;">
					<input type="text" name="" class="input_bordeInferior" value="<?=$inspeccion['tecnico_inspeccion']?>">
				</div>
				<div class="col-12" style="text-align: center;">
					<label>Nombre y Firma de quien elabora el diagnóstico</label>
				</div>
			</div>
			<div class="col-3">
				<?php
					$fecha_actual = date("d-m-Y"); 
				?>
				<div class="col-12" style="padding-top: 42px;">
					<input type="text" name="" class="input_bordeInferior" style="font-size: 10px; text-align: center;" value="<?=$fecha_actual?>">
				</div>
				<div class="col-12">
					<label>Fecha de elaboración del diagnóstico</label>
				</div>
			</div>
			<div class="col-4">
				<div class="col-12">
					<img src="<?=$firma_cliente['firma']?>" class="firma" style="width: 100%; max-height: 70px;">
				</div>
				<div class="col-12">
					<label>Nombre y Firma del Consumidor aceptando el diagnóstico</label>
				</div>
			</div>
			<div class="col-2">
				<?php
					$fecha_actual = date("d-m-Y"); 
				?>
				<div class="col-12" style="padding-top: 42px;">
					<input type="text" name="" class="input_bordeInferior" value="<?=$fecha_actual?>" style="font-size: 10px; text-align: center;">
				</div>
				<div class="col-12">
					<label>Fecha Aceptación</label>
				</div>
			</div>
		</div>
		<div class="row row_veintiseis">
			<div class="col-12">
				<p>INSPECCIÓN VISUAL E INVENTARIO EN RECEPCIÓN</p>
			</div>
		</div>
		<div class="row row_veintisiete">
			<div class="col-4">
				<div class="col-12">
					<p style="font-weight: bold; color: red; font-size: 12px; margin-bottom: 0px;">Condiciones de carrocería-Daños</p>
					<span class="texto">
					Sí (<i class="fa fa-check"></i>) / No (<i class="fa fa-times"></i>) 
					Golpes <b>O</b>
					Roto o estrellado <b>X</b>
					Rayones <b>\</b>
					</span>
				</div>
				<div class="col-12">
					<br>
					<img src="<?=$inspeccion['img']?>" alt="logo Ford" class="car_demo" alt="img inspeccion">
				</div>
			</div>
			<div class="col-3">
				<div class="row texto" style="padding: 0px; border: 1px solid #000;">
					<div class="col-12">
						<b>Interiores Opera Sí (<i class="fa fa-check"></i>)/No (<i class="fa fa-times"></i>) / No cuenta (NC)</b>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;"></div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;"></div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<p class="texto">Seguro Rines</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_seguro_rines" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<p class="texto">Indicadores de falla Activados</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;"></div>
				</div>
				<!-- <div class="row">
					<div class="col-12" style="padding: 0px; border: 1px solid #000; height: 40px;">
							<img src="<?=base_url()?>assets/img/iconos.png" style="width: 85%; height: 25px;" alt="iconos tablero">
						<p class="texto">Rociados y Limpiaparabrisas</p>
					</div>
				</div> -->
				<!-- indicadores de falla -->
				<div class="row">
					<div class="col-2" style="padding: 0px; border-top: 1px solid #000; border-left: 1px solid #000;  height: 25px;">
						
					</div>
					<div class="col-1" style="padding: 0px; border-top: 1px solid #000;  height: 25px;">
						<img src="<?=base_url()?>assets/img/icons_form/check-engine.jpg" style="height: 20px; margin-bottom: 2px;" alt="iconos tablero">
					</div>
					<div class="col-1" style="padding: 0px; border-top: 1px solid #000; height: 25px;">
						<img src="<?=base_url()?>assets/img/icons_form/repair-car.png" style="height: 20px; margin-bottom: 2px;" alt="iconos tablero">
					</div>
					<div class="col-1" style="padding: 0px; border-top: 1px solid #000;  height: 25px;">
						<img src="<?=base_url()?>assets/img/icons_form/abs.png" style="height: 20px; margin-bottom: 2px;" alt="iconos tablero">
					</div>
					<div class="col-1" style="padding: 0px; border-top: 1px solid #000;  height: 25px;">
						<img src="<?=base_url()?>assets/img/icons_form/sis-frenos.png" style="height: 20px; margin-bottom: 2px;" alt="iconos tablero">
					</div>
					<div class="col-1" style="padding: 0px; border-top: 1px solid #000;  height: 25px;">
						<img src="<?=base_url()?>assets/img/icons_form/sis-p.png" style="height: 20px; margin-bottom: 2px;" alt="iconos tablero">
					</div>
					<div class="col-1" style="padding: 0px; border-top: 1px solid #000;  height: 25px;">
						<img src="<?=base_url()?>assets/img/icons_form/airbag.png" style="height: 20px; margin-bottom: 2px;" alt="iconos tablero">
					</div>
					<div class="col-1" style="padding: 0px; border-top: 1px solid #000; height: 25px;">
						<img src="<?=base_url()?>assets/img/icons_form/presion-car.png" style="height: 20px; margin-bottom: 2px;" alt="iconos tablero">
					</div>
					<div class="col-1" style="padding: 0px; border-top: 1px solid #000; height: 25px;">
						<img src="<?=base_url()?>assets/img/icons_form/bateria.png" style="height: 20px; margin-bottom: 3px;" alt="iconos tablero">
					</div>
					<div class="col-2" style="padding: 0px; border-top: 1px solid #000; border-right: 1px solid #000; height: 25px;">
						
					</div>
				</div>
			
				<div class="row">
					<div class="col-2" style="padding: 0px; border-left: 1px solid #000; border-bottom: 1px solid #000; height: 15px;">
					</div>
					<div class="col-1" style="padding: 0px; border-bottom: 1px solid #000; height: 15px;">
						<span id="i_motor_luz" class="span_celda" style="left: 2px;"></span>
					</div>
					<div class="col-1" style="padding: 0px; border-bottom: 1px solid #000; height: 15px;">
						<span id="i_servicio_luz" class="span_celda" style="left: 2px;"></span>
					</div>
					<div class="col-1" style="padding: 0px; border-bottom: 1px solid #000; height: 15px;">
						<span id="i_abs_luz" class="span_celda" style="left: 2px;"></span>
					</div>
					<div class="col-1" style="padding: 0px; border-bottom: 1px solid #000; height: 15px;">
						<span id="i_frenos_luz" class="span_celda" style="left: 4px;"></span>
					</div>
					<div class="col-1" style="padding: 0px; border-bottom: 1px solid #000; height: 15px;">
						<span id="i_frenosp_luz" class="span_celda" style="left: 4px;"></span>
					</div>
					<div class="col-1" style="padding: 0px; border-bottom: 1px solid #000; height: 15px;">
						<span id="i_airbag_luz" class="span_celda" style="left: 3px;"></span>
					</div>
					<div class="col-1" style="padding: 0px; border-bottom: 1px solid #000; height: 15px;">
						<span id="i_presionaire_luz" class="span_celda" style="left: 3px;"></span>
					</div>
					<div class="col-1" style="padding: 0px; border-bottom: 1px solid #000; height: 15px;">
						<span id="i_bateria_luz" class="span_celda" style="left: 3px;"></span>
					</div>
					<div class="col-2" style="padding: 0px; border-bottom: 1px solid #000; border-right: 1px solid #000; height: 15px;">
						
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<p class="texto">Rociados y Limpiaparabrisas</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_parabrisas" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<p class="texto">Cláxon</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_claxon" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<p class="texto">Luces</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_luces_int" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px; text-align: center;">
						<p class="texto" style="margin-left: 20px;">Delanteras</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_luces_delant" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px; text-align: center;">
						<p class="texto" style="margin-left: 20px;">Traseras</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_luces_traseras" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px; text-align: center;">
						<p class="texto" style="margin-left: 20px;">Stop</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_luces_stop" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<p class="texto">Radio/ Carátula</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_radio" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<p class="texto">Pantallas </p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_pantalla" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<p class="texto">A / C</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_ac" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<p class="texto">Encendedor</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_encendedor" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<p class="texto">Vidrios</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_vidrios" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<p class="texto">Espejos</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_espejos" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<p class="texto">Seguros Eléctricos</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_seguros_ele" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<p class="texto">CO</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_co" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<p class="texto">Asientos y vestiduras</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_asientosyvesti" class="span_celda"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<p class="texto">Tapetes</p>
					</div>
					<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
						<span id="i_tapetes" class="span_celda"></span>
					</div>
				</div>
			</div>
			<div class="col-5" style="padding-bottom: 10px;">
				<div class="row">
					<div class="col-5 tabla_cajuela" style="margin-left: 15px;">
						<div class="row" style="padding: 0px; border: 1px solid #000;">
							<div class="col-12" style="text-align: left;">
								<b style="font-weight: bold; color: red; font-size: 12px; margin-bottom: 0px;">
								Cajuela
								Sí (<i class="fa fa-check"></i>) / No (<i class="fa fa-times"></i>) / 
								<br> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; No cuenta (NC)
								</b>
							</div>
						</div>
						<div class="row">
							<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<p class="texto">Herramienta</p>
							</div>
							<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<span id="i_herramienta" class="span_celda"></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<p class="texto">Gato / Llave</p>
							</div>
							<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<span id="i_gato" class="span_celda"></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<p class="texto">Reflejantes</p>
							</div>
							<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<span id="i_reflejantes" class="span_celda"></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<p class="texto">Cables</p>
							</div>
							<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<span id="i_cables" class="span_celda"></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<p class="texto">Extintor</p>
							</div>
							<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<span id="i_extintor" class="span_celda"></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<p class="texto">Llanta Refacción</p>
							</div>
							<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<span id="i_llanta" class="span_celda"></span>
							</div>
						</div>
					</div>
					<div class="col-5 tabla_exteriores" style="margin-left: 15px;">
						<div class="row" style="padding: 0px; border: 1px solid #000;">
							<div class="col-12" style="text-align: left;">
								<b style="font-weight: bold; color: red; font-size: 12px; margin-bottom: 0px;">
								Exteriores 
								<span class="texto">Sí (<i class="fa fa-check"></i>) / No (<i class="fa fa-times"></i>) </span>
								</b>
							</div>
						</div>
						<div class="row">
							<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<p class="texto">Tapones Rueda</p>
							</div>
							<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<span id="i_tapones" class="span_celda"></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<p class="texto">Gomas de limpiadores</p>
							</div>
							<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<span id="i_gomas" class="span_celda"></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<p class="texto">Antena</p>
							</div>
							<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<span id="i_antena" class="span_celda"></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<p class="texto">Tapón Gasolina</p>
							</div>
							<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<span id="i_tapon" class="span_celda"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-5" style="margin-left: 15px;">
						<img src="" id="img_gasolina" alt="img_gasolina">
					</div>
					<div class="col-5 tabla_documentacion" style="margin-left: 15px;">
						<div class="row" style="padding: 0px; border: 1px solid #000;">
							<div class="col-12" style="text-align: left;">
								<b style="font-weight: bold; color: red; font-size: 12px; margin-bottom: 0px;">
								Documentación 
								<span class="texto">Sí (<i class="fa fa-check"></i>) / No (<i class="fa fa-times"></i>) </span>
								</b>
							</div>
						</div>
						<div class="row">
							<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<p class="texto" style="font-size: 9px;">Póliza de Garantía / Manual de Prop.</p>
							</div>
							<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<span id="i_poliza" class="span_celda"></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<p class="texto">Seguro de Rines</p>
							</div>
							<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<span id="i_seguro" class="span_celda"></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<p class="texto">Certificado de Verificación</p>
							</div>
							<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<span id="i_certificado" class="span_celda"></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<p class="texto">Tarjeta de Circulación</p>
							</div>
							<div class="col-2" style="padding: 0px; border: 1px solid #000; height: 15px;">
								<span id="i_tarjeta" class="span_celda"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12" style="text-align: left;">
						<label>¿Deja Artículos personales?</label>
					</div>
					<div class="col-12" style="text-align: left;">
						<label>Sí</label> <input type="text" name="" id="artpersonales_si" class="input_bordeInferior" style="width: 40%;">
						<label>No</label> <input type="text" name="" id="artpersonales_no" class="input_bordeInferior" style="width: 40%;">
					</div>
					<div class="col-12" style="text-align: left;">
						<label>¿Cuáles?</label> <input type="text" name="" class="input_bordeInferior" style="width: 83%; font-size: 10px; font-weight: bold; text-align: center;" value="<?=$inspeccion['articulos']?>">
					</div>
					<div class="col-12" style="text-align: left;">
						<label>¿Desea reportar algo más?</label> <input type="text" name="" class="input_bordeInferior" style="width: 65%;">
					</div>
				</div>
			</div>
		</div>
		<div class="row row_veintiocho">
			<div class="col-12">
				<label class="label_radio">IMPORTANTE:</label>
			</div>
			<div class="col-12">
				<p class="texto">
					Favor de recoger su unidad en un plazo no mayor a 48 Hrs. contados a partir de la fecha en que su asesor le informe que la unidad está lista, pasado este plazo deberá cubrir el almacenaje por guarda de vehículo conforme al contrato.
				</p>
			</div>
		</div>
		<div class="row row_veintiocho">
			<div class="col-12">
				<?php 
					$dia_actual = date("d");
					$mes_actual = date("m");
					$anio_actual = date("Y");
				?>
				<p class="texto">
					Manifiesto bajo protesta que soy dueño del vehículo, o tengo orden y/o autorización del él para utilizarlo y ordenar esta reparación, autorizando en su nombre y en el propio la realización de los trabajos descritos, así como la colocación de piezas, refacciones, repuestos y materiales e insumos necesarios para efectuarlos, comprometiéndome en su nombre y en el propio a pagar el importe de la reparación; también manifiesto mi conformidad con el inventario realizado y que consta en el ejemplar del presente que recibo; en cualquier caso que las partes acuerden que el vehículo vaya a ser recogido o entregado por personal del PROVEEDOR en el domicilio del CONSUMIDOR, ello solo será mediante previo acuerdo u orden del CONSUMIDOR por escrito y debidamente aceptado por el PROVEEDOR con un costo de $ <input type="text" name="" class="input_bordeInferior" style="width: 20%;"> 
					(<input type="text" name="" class="input_bordeInferior" style="width: 40%;"> MONEDA NACIONAL); será en todo caso obligación del personal del PROVEEDOR identificarse plenamente ante el CONSUMIDOR como tal.
					Finalmente, manifiesto mi conformidad con los términos y condiciones previstas en el contrato inscrito al reverso, el cual manifiesto que leído obligándome en lo personal y en nombre del propietario del automóvil en los términos del mismo, por lo que se suscribe de plena conformidad, siendo el día <input type="text" name="" class="input_bordeInferior" style="width: 5%; text-align: center;" value="<?=$dia_actual?>"> de <input type="" name="" class="input_bordeInferior" style="width: 5%;text-align: center;" value="<?=$mes_actual?>"> de <input type="text" name="" class="input_bordeInferior" style="width: 5%; text-align: center;" value="<?=$anio_actual?>">.
				</p>
			</div>
		</div>
		<div class="row row_veintinueve">
			<div class="col-6">
				<img src="<?=$asesor['firma_electronica']?>" style="width: 50%;">
			</div>
			<div class="col-6">
				<div class="col-12">
					<img src="<?=$firma_cliente['firma']?>" style="width: 50%;">
				</div>
			</div>
		</div>
		<div class="row row_veintinueve">
			<div class="col-6">
				<p style="font-size: 10px;"><?=$cliente["asesor"]?></p>
				<label>Nombre y Firma del Asesor de Servicio</label>
			</div>
			<div class="col-6">
				<label>Firma del Consumidor</label>
			</div>
		</div>
		<div class="row row_treinta">
			<div class="col-6"></div>
			<div class="col-6">
				<label>ACEPTA PRESUPUESTO E INVENTARIO</label>
			</div>
		</div>
	</div>
	<p style="text-align: center; font-weight: bold; color: red; font-size: 14px;">CLIENTE</p>
	<br>
	<br>
	</div>
</body>
</html>