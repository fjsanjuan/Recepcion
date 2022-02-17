<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Formato</title>
		<link rel="stylesheet" href="<?php echo base_url();?>assets/pdfstyles/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/toastr.min.css">
		<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
		<link rel="apple-touch-icon" href="<?php echo base_url();?>assets/pdfstyles/images/reporticon.png">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/pdfstyles/css/page.css">
		<link rel="icon" href="<?php echo base_url();?>assets/pdfstyles/images/reporticon.png" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/pdfstyles/css/multipuntos.css">
		<meta name="theme-color" content="#801515" />
		<meta name="description" content="Formato">
		<meta property="og:title" content="Seguimiento a tu vehiculo" />
		<meta property="og:url" content="http://isapi.intelisis-solutions.com/" />
		<meta property="og:description" content="Formato">
		<meta property="og:image" content="<?php echo base_url();?>assets/pdfstyles/images/reporticon.png">
		<style>
			/* The side navigation menu */
.sidebar {
  margin: 0;
  padding: 0;
  width: 300px;
  background-color: #f1f1f1;
  position: fixed;
  height: 100%;
  overflow: auto;
  margin-top: -20px;
  box-shadow: 3px 3px 3px #ddd;
}

/* Sidebar links */
.sidebar a , .sidebar div {
  display: block;
  color: black;
  padding: 16px;
  text-decoration: none;
}

/* Active/current link */
.sidebar a.active {
  background-color: #29b6f6;
  color: white;
}

/* Links on mouse-over */
.sidebar a:hover:not(.active) {
  background-color: #0288d1;
  color: white;
}

#myDIV {
	background-color: #f1f1f1;
	position:fixed;
	top:0;
	width:18%;
	z-index:100;
	left:82%;
	height: 100%;
	visibility: hidden;
	opacity: 0;
	transition: visibility 0s, opacity 0.5s linear;
	box-shadow: -3px 3px 3px #ddd;
	padding: 10px;
}
.code{
	background: #f4f4f4;
	border: 1px solid #ddd;
	border-left: 3px solid #f36d33;
	color: #666;
	page-break-inside: avoid;
	font-family: monospace;
	font-size: 15px;
	line-height: 1.6;
	margin-bottom: 1.6em;
	max-width: 100%;
	overflow: auto;
	padding: 1em 1.5em;
	display: block;
	word-wrap: break-word;
}
.requisito{
	background:#fff59d;
}

input {
	background-color: transparent;
	border: 0px solid;
}

input:focus{
	outline: none;
}

.print {
	display: none !important;
}

/* On screens that are less than 700px wide, make the sidebar into a topbar */
@media screen and (max-width: 1750px) {
  .sidebar {
	width: 100%;
	height: auto;
	position: relative;
  }
  .sidebar a , .sidebar div {float: left;}
  #myDIV {
	width:40%;
	left:60%;
  }
}

/* On screens that are less than 400px, display the bar vertically, instead of horizontally */
@media screen and (max-width: 500px) {
  .sidebar a , .sidebar div {
	text-align: center;
	float: none;
  }
  #myDIV {
	width:80%;
	left:20%;
  }
}

@media print {
	@page {size: landscape}
	.no_print {
		display: none !important;
		visibility: hidden;
		opacity: 0;
	}
	.requisito{
		background:none;
	}
	.print {
		display: block !important;
	}
}
.tiempo_inicio{
word-break: break-word;
}
.tiempo_fin{
word-break: break-word;
}
		</style>
	</head>
	<?php
	$attributes = array('id' => 'form_codigos');
	echo form_open('',$attributes);
   ?>
	<body class="gray-bg" style="overflow-x: auto;" cz-shortcut-listen="true">
		
		<div class="book">
			<div class="page" id="firstpage">
				<div id="page-wrapper">
					<div id="principal">
						<div class="row header-title-blue">
							<div class=" bold">
								Código de Diagnóstico del Problema
							</div>
						</div>
						<div id="top-section">
							<div id="head">
								<div id="left" class="header">
									<strong class="header-left-title sfont">(REP)Número de reparación (NL) Luz indicadora de falla (DTC) Código de falla</strong>
								</div>
								<div id="right" class="header">
									
									<div class="row">
									<div class="column cuarenta content-center pad-tp pad-bt">
									<?php 
										$torre =  isset($Mov['ServicioNumero']) ? $Mov['ServicioNumero'] : '-';
										$Mov = (isset($Mov["MovID"])) ? $Mov["MovID"] : "-";
									?>
	                                    <strong class="header-right-title" id="num_orden">Folio: <?php echo $Mov?> </strong>
									</div>
										<div class="column veinte pad-tp pad-bt" id="num_torre">
											Torre: <?php echo $torre; ?>
										</div>
										<div class="column cuarenta pad-tp pad-bt" id="folio_consecutivo">
										<?php 
											$movID = (isset($movID["MovID"])) ? $movID["MovID"] : "-";
										?>
										   Consecutivo: <?php echo $movID?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row header-title-blue">
							<div class=" bold">
								Datos generales de la Agencia
							</div>
						</div>
						<div class="row">
							<div class="column diez border-left-light border-right-light border-bottom-light pad-tp pad-bt bold">
								NO. REP.
							</div>
							<div class="column veinte border-right-light border-bottom-light pad-tp pad-bt bold">
								LUZ FALLA ENCENDIDA
							</div>
							<div class="column veinte border-right-light border-bottom-light pad-tp pad-bt bold">
								TIPO CÓDIGOS DTC&nbspTREN&nbspMOTRIZ
							</div>
							<div class="column diez border-right-light border-bottom-light pad-tp pad-bt bold">
								CÓDIGOS
							</div>
							<div class="column veinte border-right-light border-bottom-light pad-tp pad-bt bold">
							NUEVO CÓDIGO
							</div>
						   <div class="column veinte border-right-light border-bottom-light pad-tp pad-bt bold">
							BORRAR CÓDIGO
							</div>
						</div>
						<div class="code_lines">
						<?php if ($estatus == false): ?>
						<div class="row">
							<div class="column diez border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
								<input class="required write" type="text" name="detalles[0][num_reparacion]" id="" style="width: 98%" required>
							</div>
							<div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito">
								<input class="required write" type="text" name="detalles[0][luz_de_falla]" id="" style="width: 98%;" required>
							</div>
							<div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito" style='text-decoration: none;'>
							<select name="detalles[0][tren_motriz]" class="requisito" style="appearance: none;-webkit-appearance: none;-moz-appearance: none; border: none;overflow:hidden;width: 100%;" required>
								<option value="">Tipo códigos</option>
								<option value="KOEO">KOEO</option>
								<option value="KOEC">KOEC</option>
								<option value="KOER">KOER</option>
								<option value="CARROCERIA">CARROCERIA</option>
								<option value="CHASIS">CHASIS</option>
								<option value="INDEFINIDO">INDEFINIDO</option>
								<option value="OTRO">OTRO</option>
							</select>
							</div>
							<div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
								<input class="required write" type="text" name="detalles[0][codigos]" id="" style="width: 98%;" required>
							</div>
							<div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito">
							<!-- <i class="fa fa-plus fa-2x nuevo_codigo no_print" style="color:grey; cursor:pointer;" aria-hidden="true"></i> -->
							</div>
							<div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito">
							<!-- <i class="fa fa-times fa-2x erase_line no_print" style="color:grey; cursor:pointer;"></i> -->
							</div>
							<!--<input type="text" name="firma_tecnico" id="firma_tecnico" style="display: none;">-->
						</div>
						<?php else: ?>
						<?php foreach(isset($data['detalles']) ? $data['detalles'] : [] as $key => $detalle): ?>
						<div class="row">
						<input class="" value="<?=$detalle['id'];?>" name="detalles[<?=$key;?>][id_revision]" style="display: none;">
							<div class="column diez border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
								<input class="required write" type="text" name="detalles[<?=$key;?>][num_reparacion]" id="" style="width: 98%" value="<?=$detalle['num_reparacion'];?>" required>
							</div>
							<div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito">
								<input class="required write" type="text" name="detalles[<?=$key;?>][luz_de_falla]" id="" style="width: 98%;" value="<?=$detalle['luz_de_falla'];?>" required>
							</div>
							<div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito" style='text-decoration: none;'>
							<select id="select_codigo" name="detalles[<?=$key;?>][tren_motriz]" class="requisito" style="appearance: none;-webkit-appearance: none;-moz-appearance: none; border: none;overflow:hidden;width: 100%;" required>
								<option value="">Tipo códigos</option>
								<option value="KOEO" <?php echo ($detalle['tren_motriz'] == 'KOEO' ? 'selected' : '');?>>KOEO</option>
								<option value="KOEC" <?php echo ($detalle['tren_motriz'] == 'KOEC' ? 'selected' : '');?>>KOEC</option>
								<option value="KOER" <?php echo ($detalle['tren_motriz'] == 'KOER' ? 'selected' : '');?>>KOER</option>
								<option value="CARROCERIA" <?php echo ($detalle['tren_motriz'] == 'CARROCERIA' ? 'selected' : '');?>>CARROCERIA</option>
								<option value="CHASIS" <?php echo ($detalle['tren_motriz'] == 'CHASIS' ? 'selected' : '');?>>CHASIS</option>
								<option value="INDEFINIDO" <?php echo ($detalle['tren_motriz'] == 'INDEFINIDO' ? 'selected' : '');?>>INDEFINIDO</option>
								<option value="OTRO" <?php echo ($detalle['tren_motriz'] == 'OTRO' ? 'selected' : '');?>>OTRO</option>
							</select>
							</div>
							<div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
								<input class="required write" type="text" name="detalles[<?=$key;?>][codigos]" id="" style="width: 98%;" value="<?=$detalle['codigos'];?>" required>
							</div>
							<div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito">
							<!-- <i class="fa fa-plus fa-2x nuevo_codigo no_print" style="color:grey; cursor:pointer;" aria-hidden="true"></i> -->
							</div>
							<div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito">
							<!-- <i class="fa fa-times fa-2x erase_line no_print" style="color:grey; cursor:pointer;"></i> -->
							</div>
							<!--<input type="text" name="firma_tecnico" id="firma_tecnico" style="display: none;">-->
						</div>
						<?php endforeach;?>
						<?php endif; ?>
						</div>
						<?php
						echo form_close();
						?>
						</>
						<?php
						$attributes = array('id' => 'form_anverso');
						echo form_open('',$attributes);
						?>
						<div class="row header-title-blue">
							<div class="column cincuenta border-right-light bold">
								COMENTARIOS DEL MECÁNICO
							</div>
							<div class="column cincuenta bold">
								REGISTRO DE LABOR
							</div>
						</div>
						<div class="row">
							<div class="column veintitres border-left-light border-right-light border-bottom-light pad-tp pad-bt bold">
								DESCRIPCIÓN DE LA CAUSA DEL PROBLEMA
							</div>
							<div class="column cinco border-right-light border-bottom-light pad-tp pad-bt bold">
								NÚM. REP.
							</div>
							<div class="column ocho border-right-light border-bottom-light pad-tp pad-bt bold">
								CLAVE DEFECTO
							</div>
							<div class="column ocho border-right-light border-bottom-light pad-tp pad-bt bold">
								MECÁNICO CLAVE
							</div>
							<div class="column ocho border-right-light border-bottom-light pad-tp pad-bt bold">
								COSTO O TIEMPO
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt bold">
								FECHA DE RETORNO DE PARTES
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt bold">
								RELOJ CHEC.(INICIO)
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt bold">
								RELOJ CHEC.(FIN)
							</div>
						</div>
						<div class="row">
							<div class="column veintitres border-left-light border-right-light border-bottom-light pad-tp pad-bt bold">
								IDENTIFIQUE LA PARTE CAUSANTE
							</div>
							<div class="column cinco border-right-light border-bottom-light pad-tp pad-bt requisito">
								<input class="required write" type="text" name="num_reparacion" id="" style="width: 98%;" value="<?= isset($detalle['num_reparacion']) ? $detalle['num_reparacion'] : "";?>">
							</div>
							<div class="column ocho border-right-light border-bottom-light pad-tp pad-bt requisito">
								<input class="required write" type="text" name="clave_defect" id="" style="width: 98%;" value="<?= isset($data['clave_defect']) ? $data['clave_defect'] : "";?>">
							</div>
							<div class="column ocho border-right-light border-bottom-light pad-tp pad-bt requisito">
								<input class="required write" type="text" name="mecanico_clave" id="" style="width: 98%;" value="<?= isset($data['mecanico_clave']) ? $data['mecanico_clave'] : "";?>">
							</div>
							<div class="column ocho border-right-light border-bottom-light pad-tp pad-bt requisito costo_tiempo">
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito">
								<input class="required write" type="date" name="retorno_partes" id="" style="width: 98%;" value="<?= isset($data['retorno_partes']) ? $data['retorno_partes'] : "";?>">
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito tiempo_inicio">
								
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito tiempo_fin">
								
							</div>
						</div>
						<div class="row">
							<div class="column sesentayocho border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
								<input class="required write" type="text" name="parte_causante" id="" style="width: 98%;" value="<?= isset($data['parte_causante']) ? $data['parte_causante'] : "";?>">
							</div>
		
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito tiempo_inicio">
							   
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito tiempo_fin">
							   
							</div>
						</div>
						<div class="row">
							<div class="column sesentayocho border-left-light border-right-light border-bottom-light pad-tp pad-bt bold">
								IDENTIFIQUE LA CAUSA DE LA FALLA
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito tiempo_inicio">
							  
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito tiempo_fin">
								
							</div>
						</div>
						<div class="row">
							<div class="column sesentayocho border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
								<input class="required write" type="text" name="causa_falla" id="" style="width: 98%;" value="<?= isset($data['causa_falla']) ? $data['causa_falla'] : "";?>">
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito tiempo_inicio">
								
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito tiempo_fin">
							   
							</div>
						</div>
						<div class="row">
							<div class="column sesentayocho border-left-light border-right-light border-bottom-light pad-tp pad-bt bold">
								IDENTIFIQUE EL EQUIPO DE DIAGNÓSTICO
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito tiempo_inicio">
								
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito tiempo_fin">
							   
							</div>
						</div>
						<div class="row">
							<div class="column sesentayocho border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
								<input class="required write" type="text" name="equipo_diagnostico" id="" style="width: 98%;" value="<?= isset($data['equipo_diagnostico']) ? $data['equipo_diagnostico'] : "";?>">
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito tiempo_inicio">
						  
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito tiempo_fin">
								
							</div>
						</div>
						<div class="row">
							<div class="column sesentayocho border-left-light border-right-light border-bottom-light pad-tp pad-bt bold">
								EXPLIQUE LA REPARACIÓN EFECTUADA
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito tiempo_inicio">
								
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito tiempo_fin">
							  
							</div>
						</div>
						<div class="row">
							<div class="column sesentayocho border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
								<textarea class="required write" type="textarea" name="reparacion_efectuada" id="" style="width: 98%;" rows="5" cols="15" ><?= isset($data['reparacion_efectuada']) ? $data['reparacion_efectuada'] : "";?></textarea>
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito revisar_tiempos">
								
							</div>
							<div class="column diesiseis border-right-light border-bottom-light pad-tp pad-bt requisito revisar_tiempos">
								
							</div>
						</div>
					</div>
					<div class="row print <?php echo $data['firma_jefe_taller'] ? '' : 'no_print'; ?>" id="print_firma" style="text-align:center; margin-left:auto; margin-right:auto; font-size: 16pt;">
					<img src="<?php echo $data['firma_jefe_taller']; ?>" id="ver_firma" alt="Firma" width="400" height="100"><input class="" type="text" name="jefe_de_taller" id="jefe_de_taller" value="<?php echo $data['jefe_de_taller'];?>">
					</div>
					
				</div>
			</div>
		</div>
		<div id="myDIV" class="no_print" style="visibility:hidden;opacity: 0;">
			<button type="button" data-close onclick="closebutton()">
				<span aria-hidden="true">&times;</span>
			</button>
			<h1>Request</h1>
			<p id="request" class="code">
				-
			</p>
			<h1>Response</h1>
			<p id="response" class="code">
				-
			</p>
			
		</div>
	</body>
	<?php
	echo form_close();
	?>
	<!--scripts-->
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.min.js"></script>
	<script src="<?=base_url()?>assets/js/toastr.min.js"></script>
	<script src="<?= base_url()?>assets/librerias/jq-signature-master/jq-signature.min.js"></script>
	<script src="<?=base_url();?>assets/librerias/sweetalert2-7.17.0/dist/sweetalert2.all.js"></script>
	<script src="<?=base_url()?>assets/js/toastr.min.js"></script>

	<script src='<?=base_url()?>assets/js/jquery.validate.js'></script>
	<script src='<?=base_url()?>assets/js/jquery.validate.min.js'></script>
	<script src='<?=base_url()?>assets/js/jquery.validator.message.js'></script>

	<?php
	date_default_timezone_set('America/Mexico_City');
	clearstatcache();                //clears the file status cache
	?>

	<?php
		$costo_tiempo = 0;
		foreach ($tiempo_inicio as $key => $inicio) {
			$aux_fin = new DateTime($inicio['FechafIN'] ? $inicio['FechafIN'] : $inicio['FechaInicio']);
			$aux_inicio = new DateTime($inicio['FechaInicio']);
			//$aux = $aux_fin->diff($aux_inicio);
			$aux = (($aux_fin->format('U.u') - $aux_inicio->format('U.u')) * 1000) / (1000 * 3600);
			$costo_tiempo += is_nan($aux) ? 0 : $aux;
			$tiempo_inicio[$key]['FechaInicio'] = $aux_inicio->format('d/m/Y H:i:s');
			$tiempo_inicio[$key]['FechafIN'] = $inicio['FechafIN'] ? $aux_fin->format('d/m/Y H:i:s') : '';
		}
		$json_inicio = json_encode($tiempo_inicio);
	?>

	<script>
		var base_url = `<?php echo  base_url(); ?>`;
		var idOrden = `<?php echo $id_orden; ?>`;
		var idDiagnostico = `<?php echo $data['id_diagnostico']; ?>`;
		let tiempo_inicio = '<?php echo $json_inicio;?>';
		let tiempo_fin = '<?php echo $json_fin;?>';
		tiempo_inicio = JSON.parse(tiempo_inicio);
		tiempo_fin = JSON.parse(tiempo_fin);
		$('input').prop('readonly', true);
		$('textarea').prop('readonly', true);
		$('select').prop('disabled', true);
		$('select').css({'color': 'black', 'opacity': 1});
		function myFunction(id) {
			var x = document.getElementById("myDIV");
			//x.innerHTML=id;
			if (x.style.visibility === "hidden") {
				x.style.visibility = "visible";
				x.style.opacity = "1";
				fetch('https://url/api/getDetailsLog/', {
					method: 'POST',
					headers:{
						'Accept': 'application/json',
						"Content-type":"application/json;charset=utf-8",
						'Authorization':'Token 23c36877d39f649b8e1d8fa3a970e779f915143e',
					},
					body: JSON.stringify({"id":id})
				})
				.then(response => response.json())
				.then(response => {
					console.log(response);
					document.getElementById("request").innerHTML=response["data"]["request"];
					document.getElementById("response").innerHTML=response["data"]["response"];
				}).catch(error => 
					console.log(error.message)
				);
			} else {
				x.style.visibility = "hidden";
				x.style.opacity = "0";
			}
		}

		function closebutton() {
			var x = document.getElementById("myDIV");
			x.style.visibility = "hidden";
			x.style.opacity = "0";
		}
$(document).ready(function(){
		const tiempos_inicio =  $('.tiempo_inicio');
		const tiempos_fin =  $('.tiempo_fin');
		let costo_tiempo = "<?php echo number_format($costo_tiempo, 2); ?>";
		$.each(tiempo_inicio, function (index, val) {
			inicio = new Date(val.FechaInicio);
			fin = new Date(val.FechafIN ? val.FechafIN : val.FechaInicio);
			$(tiempos_inicio[index]).text(val.FechaInicio);
			$(tiempos_fin[index]).text(val.FechafIN);
		});
		$('.costo_tiempo').text(costo_tiempo+' Hrs.');
	});
	</script>
</html>
