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
<script src="<?=base_url()?>assets/librerias/jspdf/jspdf.debug.js"></script>
<script src="<?=base_url()?>assets/js/toastr.min.js"></script>
<title>Formato de Inventario</title>
</head>
<style>
	body {
		font-family: Arial !important;
	}

	.container {
		max-width: 1140px !important;
		max-height: 2097px !important;
	}

	.container-fluid {
		width: 86%;
	}
	.subcuerpo {
		background-color: white;
	}
</style>
<style type="text/css" media="print">
	@page {
	  size: A4;
	  margin: .3cm;
	}

	.container-fluid{
		width: 1110px !important;
		height: 1000px !important;
	}

	.titulo-caja {
		font-size: 12px !important;
	}

	.caja-8 img {
    	width: 40%;
	}

	.formato-inv img.logo-distribuidor {
    	width: 50%;
	}

	#espacio, #br-1 {
		display: none;
	}

	#span_reqRevinf {
		font-size: 11px !important;
	}
</style>
<body>
	<button class="btn btn-success btn-finv boton_imprimir" title="Imprimir"><i class="fa fa-print"></i> Imprimir</button>
	<button class="btn btn-success btn-finv boton_pdf" title="Guardar PDF"><i class="fa fa-download"></i> Guardar PDF</button>
	<button style="display: none;" id="boton">Generar PDF</button>
	<div class="subcuerpo">
	<div class="container-fluid formato-inv">
		<div class="row">
			<div class="col-2 logo-empresa">
				<center><b style="text-transform: uppercase; font-size: 12px;"><?=$orden["sucursal"]["razon_social"]?></b></center>
			</div>
			<div class="col-8 encabezado-nom">
				<span id="nom_distribuidor"><?=$orden["sucursal"]["nombre"]?></span>
			</div>
			<div class="col-2 logo-empresa">
				<center><!--<img src="<?=base_url().'assets/img/logo_ford.png'?>" class="logo-distribuidor" alt="logo Ford"> --> </center>
			</div>
		</div>
		<div class="row">
			<div class="col-2"></div>
			<div class="col-8">
				<center>
					<span class="dir-distribuidor">
						<?=$orden["sucursal"]["dom_calle"].", ".$orden["sucursal"]["dom_numExt"].", ".$orden["sucursal"]["dom_colonia"]?>
						<br>
						<?=$orden["sucursal"]["dom_ciudad"].", ".$orden["sucursal"]["dom_estado"].", ".$orden["sucursal"]["dom_cp"]?>
						<br>
						TELS: <?=$orden["sucursal"]["telefono"]?>
					</span>
				</center>
			</div>
			<div class="col-2">
				<center><span class="dir-distribuidor">Re .. 5346451</span></center>
			</div>
		</div>
		<div class="row tabla-1">
			<div class="col-8"></div>
			<div class="col-2 celda">
				<div class="row">
					<div class="col-6">COLOR:</div>
					<div class="col-6"><?=$orden["cliente"]["color_v"]?></div>
				</div>
			</div>
			<div class="col-2 celda">
				<div class="row">
					<div class="col-6">TORRE:</div>
					<div class="col-6"><?=$orden["cliente"]["torrecolor"]?></div>
				</div>
			</div>
		</div>
		<div class="row tabla-1">
			<div class="col-8 celda">
				<div class="row">
					<?php 
						$nom_cliente = $orden["cliente"]["nombre_cliente"];
						$ap_cliente = $orden["cliente"]["ap_cliente"];
						$am_cliente = ($orden["cliente"]["am_cliente"] == "null") ? "" : $orden["cliente"]["am_cliente"];
					?>
					<div class="col-2">NOMBRE DEL CLIENTE:</div>
					<div class="col-10"><?=$nom_cliente." ".$ap_cliente." ".$am_cliente?></div>
				</div>
			</div>
			<div class="col-2 celda">
				<div class="row">
					<div class="col-6">MODELO:</div>
					<div class="col-6"><?=$orden["cliente"]["anio_modelo_v"]?></div>
				</div>
			</div>
			<div class="col-2 celda">
				<div class="row">
					<div class="col-6">KMS:</div>
					<div class="col-6"><?=$orden["cliente"]["kilometraje_v"]?></div>
				</div>
			</div>
		</div>
		<div class="row tabla-1">
			<div class="col-2 celda">
				<div class="row">
					<div class="col-6">PLACAS:</div>
					<div class="col-6"><?=$orden["cliente"]["placas_v"]?></div>
				</div>
			</div>
			<div class="col-2 celda">
				<div class="row">
					<div class="col-6">FECHA:</div>
					<div class="col-6">
					<?php
						$fecha = explode(" ", $orden["cliente"]["fecha_creacion"]);
						$fecha = $fecha[0];
						$fecha = date("d/m/Y", strtotime($fecha));
						echo $fecha;
					?>						
					</div>
				</div>
			</div>
			<div class="col-4 celda">
				<div class="row">
					<div class="col-6">MOTOR:</div>												<!-- falta dato -->
					<div class="col-6"></div>
				</div>
			</div>
			<div class="col-4 celda">
				<div class="row">
					<div class="col-6">No. SERIE:</div>
					<div class="col-6"><?=$orden["cliente"]["vin_v"]?></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<h6 class="titulo">Inspección Visual e Inventario en recepción</h6>
			</div>
		</div>
		<div class="row">
			<div class="col-4 col-sm-4 caja-1">															<!-- Caja 1 -->
				<div class="row">
					<div class="col-4 col-sm-4 col-md-4 col-lg-6">
						<label class="titulo-caja">Interiores</label>
					</div>
					<div class="col-8 col-sm-8 col-md-8 col-lg-6">
						<label class="subtitulo-caja">Opera SI(<i class="fa fa-check"></i>) / NO(X) /No cuenta (NC)</label>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Póliza Garantía / Manual de Prop.</label>
					</div>
					<div class="col-2">
						<?php
							$interiores = explode(",", $orden["inspeccion"]["documentacion"]);
							$checked_poliza = ($interiores[0] == "n/a") ? "<label>X</label>" : "<i class='fa fa-check'></i>";
						?>
						<span><?=$checked_poliza?></span>
					</div>
				</div>
				<!-- <div class="row">
					<div class="col-12">
						<label>Indicadores de falla Activados:</label>
					</div>
					<div class="col-10">
						<img src="<?=base_url()?>assets/img/iconos.png" style="width: 68%;" alt="iconos tablero">
					</div>
					<div class="col-2">
						<span></span>														
					</div>
				</div> -->
				<div class="row">
					<div class="col-12">
						<label>Indicadores de falla Activados:</label>
					</div>
					<?php
						$luces_tablero = explode(",", $orden["inspeccion"]["luces_tablero"]);
						//echo "string".count($luces_tablero);

						$i_motor_luz = "";
						$i_servicio_luz = "";
						$i_abs_luz = "";
						$i_frenos_luz = "";
						$i_frenosp_luz = "";
						$i_airbag_luz = "";
						$i_presionaire_luz = "";
						$i_bateria_luz = "";

						if(count($luces_tablero)>1){
							//var_dump($luces_tablero[1]);
							switch ($luces_tablero[0]) 
							{
								case "motor_on":
									$i_motor_luz = "<label>&nbsp;X</label>";
								break;
								case "motor_nc":
									$i_motor_luz = "<label>X</label>";
								break;
								default:
								break;
							}
							switch ($luces_tablero[1]) 
							{
								case "servicio_on":
									$i_servicio_luz = "<label>&nbsp;X</label>";
								break;
								case "servicio_nc":
									$i_servicio_luz = "<label>NC</label>";
								break;
								default:
								break;
							}
							switch ($luces_tablero[2]) 
							{
								case "abs_on":
									$i_abs_luz = "<label>&nbsp;X</label>";
								break;
								case "abs_nc":
									$i_abs_luz = "<label>NC</label>";
								break;
								default:
								break;
							}
							switch ($luces_tablero[3]) 
							{
								case "frenosluz_on":
									$i_frenos_luz = "<label>&nbsp;X</label>";
								break;
								case "frenosluz_nc":
									$i_frenos_luz = "<label>NC</label>";
								break;
								default:
								break;
							}
							switch ($luces_tablero[4]) 
							{
								case "frenosluzp_on":
									$i_frenosp_luz = "<label>&nbsp;X</label>";
								break;
								case "frenosluzp_nc":
									$i_frenosp_luz = "<label>NC</label>";
								break;
								default:
								break;
							}
							switch ($luces_tablero[5]) 
							{
								case "airbag_on":
									$i_airbag_luz = "<label>&nbsp;X</label>";
								break;
								case "airbag_nc":
									$i_airbag_luz = "<label>NC</label>";
								break;
								default:
								break;
							}
							switch ($luces_tablero[6]) 
							{
								case "presionaire_on":
									$i_presionaire_luz = "<label>&nbsp;X</label>";
								break;
								case "presionaire_nc":
									$i_presionaire_luz = "<label>NC</label>";
								break;
								default:
								break;
							}
							switch ($luces_tablero[7]) 
							{
								case "bateria_on":
									$i_bateria_luz = "<label>&nbsp;X</label>";
								break;
								case "bateria_nc":
									$i_bateria_luz = "<label>NC</label>";
								break;
								default:
								break;
							}
						}
					?>
					<div class="col-2">
						<span></span>														<!-- no hay datos -->
					</div>
					<div class="col-1">
						<span><img src="<?=base_url()?>assets/img/icons_form/check-engine.jpg" style="height: 20px;" alt="iconos tablero"></span>
					</div>
					<div class="col-1">
						<span><img src="<?=base_url()?>assets/img/icons_form/repair-car.png" style="height: 20px;" alt="iconos tablero"></span>
					</div>
					<div class="col-1">
						<span><img src="<?=base_url()?>assets/img/icons_form/abs.png" style="height: 20px;" alt="iconos tablero"></span>
					</div>
					<div class="col-1">
						<span><img src="<?=base_url()?>assets/img/icons_form/sis-frenos.png" style="height: 20px;" alt="iconos tablero"></span>
					</div>
					<div class="col-1">
						<span><img src="<?=base_url()?>assets/img/icons_form/sis-p.png" style="height: 20px;" alt="iconos tablero"></span>
					</div>
					<div class="col-1">
						<span><img src="<?=base_url()?>assets/img/icons_form/airbag.png" style="height: 20px;" alt="iconos tablero"></span>
					</div>
					<div class="col-1">
						<span><img src="<?=base_url()?>assets/img/icons_form/presion-car.png" style="height: 20px;" alt="iconos tablero"></span>
					</div>
					<div class="col-1">
						<span><img src="<?=base_url()?>assets/img/icons_form/bateria.png" style="height: 20px;" alt="iconos tablero"></span>
					</div>
					<div class="col-2">
						<span></span>														<!-- no hay datos -->
					</div>

					<!-- datos optenidos de la inspeccion -->

					<div class="col-2">
						<span></span>														<!-- no hay datos -->
					</div>
					<div class="col-1">
						<span><?=$i_motor_luz?></span>
					</div>
					<div class="col-1">
						<span><?=$i_servicio_luz?></span> 
					</div>
					<div class="col-1">
						<span><?=$i_abs_luz?></span>
					</div>
					<div class="col-1">
						<span><?=$i_frenos_luz?></span>
					</div>
					<div class="col-1">
						<span><?=$i_frenosp_luz?></span>
					</div>
					<div class="col-1">
						<span><?=$i_airbag_luz?></span>
					</div>
					<div class="col-1">
						<span><?=$i_presionaire_luz?></span>
					</div>
					<div class="col-1">
						<span><?=$i_bateria_luz?></span>
					</div>
					<div class="col-2">
						<span></span>														<!-- no hay datos -->
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Rociador y Limpiaparabrisas</label>
					</div>
					<div class="col-2">
						<?php
							switch ($orden["inspeccion"]["claxon"]) 
							{
								case "Buen Estado":
									$plumas_limp = "<i class='fa fa-check'></i>";
								break;
								case "Requiere cambiar":
									$plumas_limp = "<label>X</label>";
								default:
									$plumas_limp = "<label>X</label>";
								break;
							}
						?>
						<span><?=$plumas_limp?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Claxon</label>
					</div>
					<div class="col-2">
						<?php
							switch ($orden["inspeccion"]["claxon"]) 
							{
								case "SI":
									$checked_claxon = "<i class='fa fa-check'></i>";
								break;
								case "NO":
									$checked_claxon = "<label>X</label>";
								break;
								default:
									$checked_claxon = "<label>NC</label>";
								break;
							}
						?>
						<span><?=$checked_claxon?></span>
					</div>
				</div>
				<div class="row sin-borde">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<label>Luces:</label>												<!-- solo viene en general -->
					</div>
					<?php
						
						$luces_int = explode(",", $orden["inspeccion"]["luces_int"]);
						//var_dump(count($luces_int));
						if(count($luces_int)==1){
							
							switch ($luces_int[0]) 
							{
								case "SI":
									$luces_delant = "<i class='fa fa-check'></i>";
									$luces_traseras = "<i class='fa fa-check'></i>";
									$luces_stop = "<i class='fa fa-check'></i>";
								break;
								case "NO":
									$luces_delant = "<label>X</label>";
									$luces_traseras = "<label>X</label>";
									$luces_stop = "<label>X</label>";
								break;
								default:
									$luces_delant = "<label>NC</label>";
									$luces_traseras = "<label>NC</label>";
									$luces_stop = "<label>NC</label>";
								break;
							}
						}
						else{
							switch ($luces_int[1]) 
							{
								case "SI":
									$luces_delant = "<i class='fa fa-check'></i>";
								break;
								case "NO":
									$luces_delant = "<label>X</label>";
								break;
								default:
									$luces_delant = "<label>NC</label>";
								break;
							}
							switch ($luces_int[2]) 
						{
							case "SI":
									$luces_traseras = "<i class='fa fa-check'></i>";
							break;
							case "NO":
									$luces_traseras = "<label>X</label>";
								break;
								default:
									$luces_traseras = "<label>NC</label>";
								break;
							}
							switch ($luces_int[3]) 
							{
								case "SI":
									$luces_stop = "<i class='fa fa-check'></i>";
								break;
								case "NO":
									$luces_stop = "<label>X</label>";
							break;
							default:
									$luces_stop = "<label>NC</label>";
							break;
						}
						}
					?>
				</div>
				<div class="row sin-borde">
					<div class="col-2 col-sm-2 col-md-2 col-lg-2"></div>
					<div class="col-8 col-sm-8 col-md-8 col-lg-8 celda-descrip">
						<label>Delanteras</label>
					</div>
					<div class="col-2 col-sm-2 col-md-2 col-lg-2 celda-opc">
						<span><?=$luces_delant?></span>
					</div>
				</div>
				<div class="row sin-borde">
					<div class="col-2 col-sm-2 col-md-2 col-lg-2"></div>
					<div class="col-8 col-sm-8 col-md-8 col-lg-8 celda-descrip">
						<label>Traseras</label>
					</div>
					<div class="col-2 col-sm-2 col-md-2 col-lg-2 celda-opc">
						<span><?=$luces_traseras?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-2 col-sm-2 col-md-2 col-lg-2"></div>
					<div class="col-8 col-sm-8 col-md-8 col-lg-8 celda-descrip">
						<label>Stop</label>
					</div>
					<div class="col-2 col-sm-2 col-md-2 col-lg-2">
						<span><?=$luces_stop?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Radio / Caratula</label>
					</div>
					<div class="col-2">
						<?php
							switch ($orden["inspeccion"]["radio"]) 
							{
								case "SI":
									$checked_radio = "<i class='fa fa-check'></i>";
								break;
								case "NO":
									$checked_radio = "<label>X</label>";
								break;
								default:
									$checked_radio = "<label>NC</label>";
								break;
							}
						?>
						<span><?=$checked_radio?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Pantallas, FIS</label>
					</div>
					<div class="col-2">
						<?php
							switch ($orden["inspeccion"]["pantalla"]) 
							{
								case "SI":
									$checked_pantallas = "<i class='fa fa-check'></i>";
								break;
								case "NO":
									$checked_pantallas = "<label>X</label>";
								break;
								default:
									$checked_pantallas = "<label>NC</label>";
								break;
							}
						?>
						<span><?=$checked_pantallas?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>A/C</label>
					</div>
					<div class="col-2">
						<?php
							switch ($orden["inspeccion"]["ac"]) 
							{
								case "SI":
									$checked_ac = "<i class='fa fa-check'></i>";
								break;
								case "NO":
									$checked_ac = "<label>X</label>";
								break;
								default:
									$checked_ac = "<label>NC</label>";
								break;
							}
						?>
						<span><?=$checked_ac?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Encendedor</label>
					</div>
					<div class="col-2">
						<?php
							switch ($orden["inspeccion"]["encendedor"]) 
							{
								case "SI":
									$checked_encededor = "<i class='fa fa-check'></i>";
								break;
								case "NO":
									$checked_encededor = "<label>X</label>";
								break;
								default:
									$checked_encededor = "<label>NC</label>";
								break;
							}
						?>
						<span><?=$checked_encededor?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Vidrios</label>
					</div>
					<div class="col-2">
						<?php
							switch ($orden["inspeccion"]["vidrios"]) 
							{
								case "SI":
									$checked_vidrios = "<i class='fa fa-check'></i>";
								break;
								case "NO":
									$checked_vidrios = "<label>X</label>";
								break;
								default:
									$checked_vidrios = "<label>NC</label>";
								break;
							}
						?>
						<span><?=$checked_vidrios?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Espejos</label>
					</div>
					<div class="col-2">
						<?php
							switch ($orden["inspeccion"]["espejos"]) 
							{
								case "SI":
									$checked_espejos = "<i class='fa fa-check'></i>";
								break;
								case "NO":
									$checked_espejos = "<label>X</label>";
								break;
								default:
									$checked_espejos = "<label>NC</label>";
								break;
							}
						?>
						<span><?=$checked_espejos?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Seguros Eléctricos</label>
					</div>
					<div class="col-2">
						<?php
							switch ($orden["inspeccion"]["seguros_ele"]) 
							{
								case "SI":
									$checked_seguros_ele = "<i class='fa fa-check'></i>";
								break;
								case "NO":
									$checked_seguros_ele = "<label>X</label>";
								break;
								default:
									$checked_seguros_ele = "<label>NC</label>";
								break;
							}
						?>
						<span><?=$checked_seguros_ele?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>CD, Artículos Personales, Guantera</label>						 <!-- antes estaba como co -->
					</div>
					<div class="col-2">
						<?php
							switch ($orden["inspeccion"]["co"]) 
							{
								case "SI":
									$checked_artPers = "<i class='fa fa-check'></i>";
								break;
								case "NO":
									$checked_artPers = "<label>X</label>";
								break;
								default:
									$checked_artPers = "<label>NC</label>";
								break;
							}
						?>
						<span><?=$checked_artPers?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Asientos y Vestiduras</label>
					</div>
					<div class="col-2">
						<?php
							switch ($orden["inspeccion"]["asientosyvesti"]) 
							{
								case "SI":
									$checked_asientos = "<i class='fa fa-check'></i>";
								break;
								case "NO":
									$checked_asientos = "<label>X</label>";
								break;
								default:
									$checked_asientos = "<label>NC</label>";
								break;
							}
						?>
						<span><?=$checked_asientos?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Tapetes</label>
					</div>
					<div class="col-2">
						<?php
							switch ($orden["inspeccion"]["tapetes"]) 
							{
								case "SI":
									$checked_tapetes = "<i class='fa fa-check'></i>";
								break;
								case "NO":
									$checked_tapetes = "<label>X</label>";
								break;
								default:
									$checked_tapetes = "<label>NC</label>";
								break;
							}
						?>
						<span><?=$checked_tapetes?></span>
					</div>
				</div>				
			</div>
			<div class="col-8 caja-2">
				<div class="row">
					<div class="col-12">
						<label class="titulo-caja">Condiciones de carrocería</label>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<label>Daños
							<?php 
								$danio = $orden["inspeccion"]["existen_danios"];
								if($danio == 1)
								{
									echo "SI (X) / NO ( )";
								}else 
								{
									echo "SI ( ) / NO (X)";
								}
							?>							 
							Golpes <i class="fa fa-plus-circle"></i> Roto o estrellado X Rayones <i class="fa fa-bolt"></i></label>
					</div>
				</div>
				<div class="row">
					<center>
						<img src="<?=$orden["inspeccion"]["img"]?>" class="img-danios" alt="daños">
					</center>
				</div>
				<div class="row">
					<div class="col-6 caja-3">
						<div class="row">
							<div class="col-6">
								<label class="titulo-caja">Exteriores</label>
							</div>
							<div class="col-6">
								<label class="subtitulo-caja">SI(<i class="fa fa-check"></i>) / NO(X)</label>
							</div>
						</div>
						<div class="row">
							<div class="col-10 celda-descrip">
								<label>Tapones Ruedas</label>
							</div>
							<div class="col-2">
								<?php
									$taponesr = explode(",", $orden["inspeccion"]["exteriores"]);
									$checked_taponesr = ($taponesr[0] == "n/a") ? "<label>X</label>" : "<i class='fa fa-check'></i>";
								?>
								<span><?=$checked_taponesr?></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10 celda-descrip">
								<label>Gomas de limpiadores</label>
							</div>
							<div class="col-2">
								<?php
									$gomasl = explode(",", $orden["inspeccion"]["exteriores"]);
									$checked_gomasl = ($gomasl[1] == "n/a") ? "<label>X</label>" : "<i class='fa fa-check'></i>";
								?>
								<span><?=$checked_gomasl?></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10 celda-descrip">
								<label>Antena</label>
							</div>
							<div class="col-2">
								<?php
									$antena = explode(",", $orden["inspeccion"]["exteriores"]);
									$checked_antena = ($antena[2] == "n/a") ? "<label>X</label>" : "<i class='fa fa-check'></i>";
								?>
								<span><?=$checked_antena?></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10 celda-descrip">
								<label>Tapón Gasolina</label>
							</div>
							<div class="col-2">
								<?php
									$tapong = explode(",", $orden["inspeccion"]["exteriores"]);
									$checked_tapong = ($tapong[3] == "n/a") ? "<label>X</label>" : "<i class='fa fa-check'></i>";
								?>
								<span><?=$checked_tapong?></span>
							</div>
						</div>
					</div>
					<div class="col-6 caja-4">
						<div class="row">
							<div class="col-10 celda-descrip">
								<label>Costado Derecho</label>							<!-- se agrego dato -->
							</div>
							<div class="col-2">
								<?php
									$dan_costDerecho = ($orden["inspeccion"]["dan_costDerecho"] == 0) ? "<label>X</label>" : "<i class='fa fa-check'></i>";
								?>
								<span><?=$dan_costDerecho?></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10 celda-descrip">
								<label>Parte Delantera</label>							<!-- se agrego dato -->
							</div>
							<div class="col-2">
								<?php
									$dan_parteDel = ($orden["inspeccion"]["dan_parteDel"] == 0) ? "<label>X</label>" : "<i class='fa fa-check'></i>";
								?>
								<span><?=$dan_parteDel?></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10 celda-descrip">
								<label>Interior, asientos, alfombra</label>				<!-- se agrego dato -->
							</div>
							<div class="col-2">
								<?php
									$dan_intAsAlf = ($orden["inspeccion"]["dan_intAsAlf"] == 0) ? "<label>X</label>" : "<i class='fa fa-check'></i>";
								?>
								<span><?=$dan_intAsAlf?></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10 celda-descrip">
								<label>Costado Izquierdo</label>						<!-- se agrego dato -->
							</div>
							<div class="col-2">
								<?php
									$dan_costIzq = ($orden["inspeccion"]["dan_costIzq"] == 0) ? "<label>X</label>" : "<i class='fa fa-check'></i>";
								?>
								<span><?=$dan_costIzq?></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10 celda-descrip">
								<label>Parte Trasera</label>							<!-- se agrego dato -->
							</div>
							<div class="col-2">
								<?php
									$dan_parteTras = ($orden["inspeccion"]["dan_parteTras"] == 0) ? "<label>X</label>" : "<i class='fa fa-check'></i>";
								?>
								<span><?=$dan_parteTras?></span>
							</div>
						</div>
						<div class="row">
							<div class="col-10 celda-descrip">
								<label>Cristales y Faros</label>						<!-- se agrego dato -->
							</div>
							<div class="col-2">
								<?php
									$dan_cristFaros = ($orden["inspeccion"]["dan_cristFaros"] == 0) ? "<label>X</label>" : "<i class='fa fa-check'></i>";
								?>
								<span><?=$dan_cristFaros?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br id="br-1">
		<div class="row">
			<div class="col-4 caja-5">
				<div class="row">
					<div class="col-6">
						<label class="titulo-caja">Cajuela</label>
					</div>
					<div class="col-6">
						<label class="subtitulo-caja">SI(<i class="fa fa-check"></i>) / NO(X) /No cuenta (NC)</label>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Herramienta</label>
					</div>
					<div class="col-2">
						<?php
							$herram = explode(",", $orden["inspeccion"]["cajuela"]);
							$checked_herram = ($herram[0] == "n/a") ? "<label>X</label>" : "<i class='fa fa-check'></i>";
						?>
						<span><?=$checked_herram?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Gato / Llave</label>
					</div>
					<div class="col-2">
						<?php
							$gato = explode(",", $orden["inspeccion"]["cajuela"]);
							$checked_gato = ($gato[1] == "n/a") ? "<label>X</label>" : "<i class='fa fa-check'></i>";
						?>
						<span><?=$checked_gato?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Reflejantes</label>
					</div>
					<div class="col-2">
						<?php
							$refleg = explode(",", $orden["inspeccion"]["cajuela"]);
							$checked_refleg = ($refleg[2] == "n/a") ? "<label>X</label>" : "<i class='fa fa-check'></i>";
						?>
						<span><?=$checked_refleg?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Cables</label>
					</div>
					<div class="col-2">
						<?php
							$cables = explode(",", $orden["inspeccion"]["cajuela"]);
							$checked_cables = ($cables[3] == "n/a") ? "<label>X</label>" : "<i class='fa fa-check'></i>";
						?>
						<span><?=$checked_cables?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Extintor</label>
					</div>
					<div class="col-2">
						<?php
							$extintor = explode(",", $orden["inspeccion"]["cajuela"]);
							$checked_extintor = ($extintor[4] == "n/a") ? "<label>X</label>" : "<i class='fa fa-check'></i>";
						?>
						<span><?=$checked_extintor?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Llanta Refacción</label>
					</div>
					<div class="col-2">
						<?php
							$llantaref = explode(",", $orden["inspeccion"]["cajuela"]);
							$checked_llantaref = ($llantaref[5] == "n/a") ? "<label>X</label>" : "<i class='fa fa-check'></i>";
						?>
						<span><?=$checked_llantaref?></span>
					</div>
				</div>
			</div>
			<div class="col-4 caja-6">
				<div class="row">
					<div class="col-6">
						<label class="titulo-caja">Cofre</label>
					</div>
					<div class="col-6">
						<label class="subtitulo-caja">NIVEL CORRECTO(<i class="fa fa-check"></i>) / NIVEL INCORRECTO(X) /FUGAS (F)</label>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Aceite de Motor</label>
					</div>
					<div class="col-2">
						<?php
							$aceitem = $orden["inspeccion"]["aceiteMotor"];
							$checked_aceitem = ($aceitem == "Bien") ? "<i class='fa fa-check'></i>" : "<label>X</label>";
						?>
						<span><?=$checked_aceitem?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Líquido de Frenos</label>
					</div>
					<div class="col-2">
						<?php
							$liqfreno = $orden["inspeccion"]["liquidoFreno"];
							$checked_liqfreno = ($liqfreno == "Bien") ? "<i class='fa fa-check'></i>" : "<label>X</label>";
						?>
						<span><?=$checked_liqfreno?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Limpiaparabrisas</label>
					</div>
					<div class="col-2">
						<?php
							$liqlimpiap = $orden["inspeccion"]["liquidoLimpiaPara"];
							$checked_liqlimpiap = ($liqlimpiap == "Bien") ? "<i class='fa fa-check'></i>" : "<label>X</label>";
						?>
						<span><?=$checked_liqlimpiap?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Anticongelante</label>
					</div>
					<div class="col-2">
						<?php
							$liqrefr = $orden["inspeccion"]["deposito_refrigerante"];
							$checked_liqrefr = ($liqrefr == "Bien") ? "<i class='fa fa-check'></i>" : "<label>X</label>";
						?>
						<span><?=$checked_liqrefr?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Líquido de Dirección</label>
					</div>
					<div class="col-2">
						<?php
							$liqdirecc = $orden["inspeccion"]["direccionHidraulica"];
							$checked_liqdirecc = ($liqdirecc == "Bien") ? "<i class='fa fa-check'></i>" : "<label>X</label>";
						?>
						<span><?=$checked_liqdirecc?></span>
					</div>
				</div>
			</div>
			<div class="col-4 caja-7">
				<div class="row">
					<div class="col-3 col-sm-3 col-md-3 col-lg-3">
						<label class="titulo-caja">Inferior</label>
					</div>
					<div class="col-9 col-sm-9 col-md-9 col-lg-9">
						<span id="span_reqRevinf" style="font-size: 12px;font-weight: bold;color: #0e76c7;text-transform: uppercase;"><u>
						¿Requiere revisión?
						<?php 
							switch ($orden["inspeccion"]["reqRev_inferior"]) 
							{
								case 0:
									echo "NO";
								break;
								case 1:
									echo "SÍ";
								break;
								default:
									echo "NO";
								break;
							}
						?>
						</u>
						</span>
						<label class="subtitulo-caja" style="font-size: 11px !important; margin: 0px;">BIEN(<i class="fa fa-check"></i>) / MAL(X) /FUGA (F)</label>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Sistema de Escape</label>							<!-- se agrego -->
					</div>
					<div class="col-2">
						<?php 
							$sist_esc = $orden["inspeccion"]["inf_sistEsc"];
							if($sist_esc == "bien")
							{
								echo "<i class='fa fa-check'></i>";
							}else if($sist_esc == "mal")
							{
								echo "<label>X</label>";
							}else if($sist_esc == "fuga")
							{
								echo "<label>F</label>";
							}else 
							{
								echo "<label></label>";
							}
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Amortiguadores</label>								<!-- se agrego -->
					</div>	
					<div class="col-2">
						<?php 
							$amort = $orden["inspeccion"]["inf_amort"];
							if($amort == "bien")
							{
								echo "<i class='fa fa-check'></i>";
							}else if($amort == "mal")
							{
								echo "<label>X</label>";
							}else if($amort == "fuga")
							{
								echo "<label>F</label>";
							}else 
							{
								echo "<label></label>";
							}
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Tuberías</label>										<!-- se agrego -->
					</div>
					<div class="col-2">
						<?php 
							$tuberias = $orden["inspeccion"]["inf_tuberias"];
							if($tuberias == "bien")
							{
								echo "<i class='fa fa-check'></i>";
							}else if($tuberias == "mal")
							{
								echo "<label>X</label>";
							}else if($tuberias == "fuga")
							{
								echo "<label>F</label>";
							}else 
							{
								echo "<label></label>";
							}
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Transeje / Transmisión</label>						<!-- se agrego -->
					</div>
					<div class="col-2">
						<?php 
							$transmision = $orden["inspeccion"]["inf_transeje_transm"];
							if($transmision == "bien")
							{
								echo "<i class='fa fa-check'></i>";
							}else if($transmision == "mal")
							{
								echo "<label>X</label>";
							}else if($transmision == "fuga")
							{
								echo "<label>F</label>";
							}else 
							{
								echo "<label></label>";
							}
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Sistema de Dirección</label>							 <!-- se agrego -->
					</div>
					<div class="col-2">
						<?php 
							$direccion = $orden["inspeccion"]["inf_sistDir"];
							if($direccion == "bien")
							{
								echo "<i class='fa fa-check'></i>";
							}else if($direccion == "mal")
							{
								echo "<label>X</label>";
							}else if($direccion == "fuga")
							{
								echo "<label>F</label>";
							}else 
							{
								echo "<label></label>";
							}
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Chasis sucio</label>									<!-- se agrego -->
					</div>
					<div class="col-2">
						<?php 
							$chasis = $orden["inspeccion"]["inf_chasisSucio"];
							if($chasis == "bien")
							{
								echo "<i class='fa fa-check'></i>";
							}else if($chasis == "mal")
							{
								echo "<label>X</label>";
							}else if($chasis == "fuga")
							{
								echo "<label>F</label>";
							}else 
							{
								echo "<label></label>";
							}
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-10 celda-descrip">
						<label>Golpes Especifico</label>							<!-- se agrego -->
					</div>
					<div class="col-2">
						<?php 
							$golpes_especif = $orden["inspeccion"]["inf_golpesEspecif"];
							if($golpes_especif == "bien")
							{
								echo "<i class='fa fa-check'></i>";
							}else if($golpes_especif == "mal")
							{
								echo "<label>X</label>";
							}else if($golpes_especif == "fuga")
							{
								echo "<label>F</label>";
							}else 
							{
								echo "<label></label>";
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<br id="espacio">
		<div class="row">
			<div class="col-4 caja-8">
				<div class="row gasolina">
					<div class="col-4 bderecho">
						<center><i class="fa fa-gas-pump fa-2x"></i></center>
						<span id="a0" data-max="V"></span>
					</div>
					<div class="col-2 bderecho cuarto-1">
						<span class="etiqueta-gasolina" id="cuarto1">1/4</span>
						<div class="row">
							<div class="col-6" id="a1" data-max="1/8"></div>
							<div class="col-6" id="a2" data-max="1/4"></div>
						</div>
					</div>
					<div class="col-2 bderecho cuarto-2">
						<span class="etiqueta-gasolina" id="cuarto2">2/4</span>
						<div class="row">
							<div class="col-6" id="a3" data-max="3/8"></div>
							<div class="col-6" id="a4" data-max="1/2"></div>
						</div>
					</div>
					<div class="col-2 bderecho cuarto-3">
						<span class="etiqueta-gasolina" id="cuarto3">3/4</span>
						<div class="row">
							<div class="col-6" id="a5" data-max="5/8"></div>
							<div class="col-6" id="a6" data-max="3/4"></div>
						</div>
					</div>
					<div class="col-2 cuarto-4">
						<div class="row">
							<div class="col-6" id="a7" data-max="7/8"></div>
							<div class="col-6" id="a8" data-max="LL"></div>
						</div>
					</div>			
				</div>
				<br>
				<div class="row caja-8b">
					<div class="col-12">
						<div class="row">
							<div class="col-8 titulocj9">
								<label>¿Deja artículos personales?</label>
							</div>
							<div class="col-4 titulocj9">
								<?php
									$deja_articulos = $orden["inspeccion"]["dejaArticulos"];

									echo "<label style='text-transform: uppercase;'>".$deja_articulos."</label>";
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-8 titulocj9">
								<label>¿Cuáles?</label>
							</div>
							<div class="col-4 titulocj9">								
								<label>&nbsp</label>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<?php
									$articulos = $orden["inspeccion"]["articulos"];

									echo "<label>".$articulos."</label>";
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-8 caja-9">
				<div class="row titulocj9">
					<div class="col-5 col-sm-5 col-md-5 col-lg-4">
							<label class="titulo-caja">Sistema de Frenos</label>
					</div>
					<div class="col-7 col-sm-7 col-md-7 col-lg-8">
						<span id="span_reqRevinf" style="font-size: 12px;font-weight: bold;color: #0e76c7;text-transform: uppercase;"><u>
						¿Requiere revisión?
						<?php
							switch ($orden["inspeccion"]["reqRev_sistFrenos"]) 
							{
								case 0:
									echo "NO";
								break;
								case 1:
									echo "SÍ";
								break;
								default:
									echo "NO";
								break;
							}
						?>
						</u>
						</span>
						<br>
						<label style="font-size: 11px !important; margin: 0px;" class="subtitulo-caja">SOLO REVISAR 2 RUEDAS ACEPTADA(<i class="fa fa-check"></i>)</label>
					</div>
				</div>
				<div class="row">
					<div class="col-3 colc9">
						<div class="row">
							<div class="col-12 renglonc9">
								<label>Ruedas</label>
							</div>
							<div class="col-12 renglonc9">
								<label>Delantera Derecha</label>
							</div>
							<div class="col-12 renglonc9">
								<label>Delantera Izquierda</label>
							</div>
							<div class="col-12 renglonc9">
								<label>Trasera Derecha</label>
							</div>
							<div class="col-12 renglonc9">
								<label>Trasera Izquierda</label>
							</div>
							<div class="col-12 renglonc9" style="border-bottom: none;">
								<label>Refacción</label>
							</div>
						</div>
					</div>
					<div class="col-3 colc9">
						<div class="row">
							<div class="col-12 renglonc9">
								<label>Balata/Zapata</label>
							</div>
							<div class="col-12 renglonc9">
								<?php
									$sfrenos_ddBalata = $orden["inspeccion"]["sfrenos_ddBalata"];
									switch($sfrenos_ddBalata) 
									{
										case "bien":
											echo '<div class="fa fa-check-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "atencion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-check-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "reparacion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-check-square fa-2x check-rojo"></div>';
										break;										
										default:
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;
									}
								?>								
							</div>
							<div class="col-12 renglonc9">
								<?php 
									$sfrenos_diBalata = $orden["inspeccion"]["sfrenos_diBalata"];
									switch($sfrenos_diBalata) 
									{
										case "bien":
											echo '<div class="fa fa-check-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "atencion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-check-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "reparacion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-check-square fa-2x check-rojo"></div>';
										break;										
										default:
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;
									}
								?>
							</div>
							<div class="col-12 renglonc9">
								<?php 
									$sfrenos_tdBalata = $orden["inspeccion"]["sfrenos_tdBalata"];
									switch($sfrenos_tdBalata) 
									{
										case "bien":
											echo '<div class="fa fa-check-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "atencion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-check-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "reparacion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-check-square fa-2x check-rojo"></div>';
										break;										
										default:
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;
									}
								?>
							</div>
							<div class="col-12 renglonc9">
								<?php 
									$sfrenos_tiBalata = $orden["inspeccion"]["sfrenos_tiBalata"];
									switch($sfrenos_tiBalata) 
									{
										case "bien":
											echo '<div class="fa fa-check-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "atencion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-check-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "reparacion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-check-square fa-2x check-rojo"></div>';
										break;										
										default:
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;
									}
								?>
							</div>
							<div class="col-12 renglonc9" style="border-bottom: none;">
								<label>&nbsp</label>
							</div>
						</div>
					</div>
					<div class="col-3 colc9">
						<div class="row">
							<div class="col-12 renglonc9">
								<label>Disco/Tambor</label>
							</div>
							<div class="col-12 renglonc9">
								<?php 
									$sfrenos_ddDisco = $orden["inspeccion"]["sfrenos_ddDisco"];
									switch($sfrenos_ddDisco) 
									{
										case "bien":
											echo '<div class="fa fa-check-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "atencion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-check-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "reparacion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-check-square fa-2x check-rojo"></div>';
										break;										
										default:
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;
									}
								?>
							</div>
							<div class="col-12 renglonc9">
								<?php 
									$sfrenos_diDisco = $orden["inspeccion"]["sfrenos_diDisco"];
									switch($sfrenos_diDisco) 
									{
										case "bien":
											echo '<div class="fa fa-check-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "atencion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-check-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "reparacion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-check-square fa-2x check-rojo"></div>';
										break;										
										default:
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;
									}
								?>
							</div>
							<div class="col-12 renglonc9">
								<?php 
									$sfrenos_tdDisco = $orden["inspeccion"]["sfrenos_tdDisco"];
									switch($sfrenos_tdDisco) 														
									{
										case "bien":
											echo '<div class="fa fa-check-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "atencion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-check-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "reparacion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-check-square fa-2x check-rojo"></div>';
										break;										
										default:
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;
									}
								?>
							</div>
							<div class="col-12 renglonc9">
								<?php 
									$sfrenos_tiDisco = $orden["inspeccion"]["sfrenos_tiDisco"];
									switch($sfrenos_tiDisco) 														//disco y si no, tambor
									{
										case "bien":
											echo '<div class="fa fa-check-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "atencion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-check-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "reparacion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-check-square fa-2x check-rojo"></div>';
										break;										
										default:
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;
									}
								?>
							</div>
							<div class="col-12 renglonc9" style="border-bottom: none;">
								<label>&nbsp</label>
							</div>
						</div>
					</div>
					<div class="col-3">
						<div class="row">
							<div class="col-12 renglonc9">
								<label>Neumático</label>
							</div>
							<div class="col-12 renglonc9">
								<?php 
									$sfrenos_ddNeumat = $orden["inspeccion"]["sfrenos_ddNeumat"];
									switch($sfrenos_ddNeumat) 
									{
										case "bien":
											echo '<div class="fa fa-check-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "atencion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-check-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "reparacion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-check-square fa-2x check-rojo"></div>';
										break;										
										default:
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;
									}
								?>
							</div>
							<div class="col-12 renglonc9">
								<?php 
									$sfrenos_diNeumat = $orden["inspeccion"]["sfrenos_diNeumat"];
									switch($sfrenos_diNeumat) 
									{
										case "bien":
											echo '<div class="fa fa-check-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "atencion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-check-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "reparacion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-check-square fa-2x check-rojo"></div>';
										break;										
										default:
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;
									}
								?>
							</div>
							<div class="col-12 renglonc9">
								<?php 
									$sfrenos_tdNeumat = $orden["inspeccion"]["sfrenos_tdNeumat"];
									switch($sfrenos_tdNeumat) 
									{
										case "bien":
											echo '<div class="fa fa-check-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "atencion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-check-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "reparacion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-check-square fa-2x check-rojo"></div>';
										break;										
										default:
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;
									}
								?>
							</div>
							<div class="col-12 renglonc9">
								<?php 
									$sfrenos_tiNeumat = $orden["inspeccion"]["sfrenos_tiNeumat"];
									switch($sfrenos_tiNeumat) 
									{
										case "bien":
											echo '<div class="fa fa-check-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "atencion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-check-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "reparacion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-check-square fa-2x check-rojo"></div>';
										break;										
										default:
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;
									}
								?>
							</div>
							<div class="col-12 renglonc9" style="border-bottom: none;">
								<?php 
									$sfrenos_refNeumat = $orden["inspeccion"]["sfrenos_refNeumat"];
									switch($sfrenos_refNeumat) 
									{
										case "bien":
											echo '<div class="fa fa-check-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "atencion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-check-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;										
										case "reparacion":
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-check-square fa-2x check-rojo"></div>';
										break;										
										default:
											echo '<div class="fa fa-square fa-2x check-verde"></div>';
											echo '<div class="fa fa-square fa-2x check-amarillo"></div>';
											echo '<div class="fa fa-square fa-2x check-rojo"></div>';
										break;
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row obs">
			<div class="col-12 titulo-caja titulocj9">
				<label style="font-size: 20px !important;">Observaciones</label>
			</div>
			<div class="col-12 titulocj9">
				<label>&nbsp</label>
			</div>
		</div>
		<div class="row firmas-finv">
			<div class="col-6">
				<div style="height: 32px;"></div>
				<div class="row">
					<div class="col-12">
						<br>
						<label style="text-transform: uppercase;"><?=$orden["cliente"]["asesor"]?></label>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<hr class="reng-firma">
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<label>Nombre del Asesor</label>						
					</div>
				</div>
			</div>
			<div class="col-6">
				<div class="row">
					<div class="col-12">
						<center><img src="<?=$orden["firma_cliente"]["firma_formatoInventario"]?>"></center>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<hr class="reng-firma">
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<label>Firma Cliente</label>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</body>
<script>
$(document).ready(function(){
	var b_generar = "<?=$orden["bandera"]?>";						//para detectar si se abre desde el botón o desde enviar el correo
	var  base_url = "<?=base_url();?>";

	$(".boton_imprimir").click(function(){
		$(".boton_imprimir, .boton_pdf").css("display", "none");
		window.print();
		$(".boton_imprimir, .boton_pdf").css("display", "inline");
		$("#button").hide();
	});

	function genIMG()
	{
		html2canvas($(".subcuerpo"),{
		   	onrendered:function(canvas){
			   img = canvas.toDataURL("image/png");
			   sessionStorage.setItem("formato_inventario", img);
		   }
	    });
	}

	/*Pdf*/
	function generar_pdf(img_formato, img_reverso)
	{
	    var formato_inventario = sessionStorage.getItem("formato_inventario");
	    var id_orden = "<?=$orden["cliente"]["id"]?>";
	    var t_vin = "<?=$orden["cliente"]["vin_v"]?>";
		t_vin = t_vin.replace(".", "");
		t_vin = t_vin.replace(" ", "");
		var tok=""
		$.ajax({
			url: "https://isapi.intelisis-solutions.com/auth/",
			type: "POST",
			dataType: 'json',
			data: {
				username:'TEST001',
				password:'intelisis'
			},
			beforeSend: function(){
				$("#loading_spin").show();
			},
			error: function(){
				console.log('error al consumir token de ApiReporter');
				$("#loading_spin").hide();
			},
			success: function (data){
				tok=data.token;
				$.ajax({
					// url: "https://isapi.intelisis-solutions.com/reportes/getPDF",
					url: `${base_url}index.php/servicio/obtener_formato_inventario/${tok}/${id_orden}`,
					type: "POST",
					headers: {
						Authorization: `Token ${tok}`,
					},
					//habilitar xhrFields cuando se requiera descargar
					//xhrFields: {responseType: "blob"},
					data: {
						name:'Formato_inventario',
						dwn:'0',
						opt:'1',
						path:'None',
						vin:t_vin,
						id:id_orden,
						id_orden:id_orden,
						url:`https://isapi.intelisis-solutions.com/reportes/getPDFInventario`,
						// url:`http://127.0.0.1:8000/reportes/getPDFInventario`,
						img_formato: formato_inventario,
					},
					beforeSend: function(){
						$("#loading_spin").show();
						toastr.info("Generando Formato");
					},
					error: function(){
						console.log('error al consumir getPDF de ApiReporter');
						toastr.error("Error al generar el formato");
						$("#loading_spin").hide();
					},
					success: function (blob){
						$("#loading_spin").hide();
						data = JSON.parse(blob);
						if(data.estatus) {
							const link = $('<a>', {'href':data.data['archivo'], 'download':data.data['nombre']+'.pdf', 'target':'_blank'});
							link[0].click();
						} else {
							toastr.info(data.mensaje);
						}
					}
				});
			}
		});
	    /*var doc = new jsPDF("p", "mm", "A4", true);
	    var width = 0;
	    var height = 0;

	    width = doc.internal.pageSize.width;    
	    height = doc.internal.pageSize.height;
	    height = height - 10;

	    doc.addImage(formato_inventario, 'PNG', 0, 5, width, height, undefined, 'FAST');
	    doc.save('Formato_inventario'+id_orden+'.pdf');*/
	}

	$(".boton_pdf").click(function(){
		$(this).css("display", "none");

		toastr.success("Generando el PDF, espere un momento, por favor");

		$.ajax({
			url: genIMG(),
		})
		.done(function() {

			setTimeout(function(){
				generar_pdf();
			}, 1500);
		})
		.fail(function() {
			alert("Hubo un error al generar el formato");
		});

		$(this).css("display", "inline");
	});

	var gasolina = "<?=$orden["inspeccion"]["gasolina"]?>";
	var marca_gas = "<span><i class='fa fa-times' style='color: red;'></i></span>";

	switch(gasolina)
	{
		case "V":
			$("#a0").append(marca_gas).css({
										   "display" : "block",
										   "position" : "relative",
										   "bottom" : "-13px",
										   "left" : "103px",
										   "z-index" : 1
										});
		break;
		case "1/8":
			$("#a1").append(marca_gas);
		break;
		case "1/4":
			$("#a2").append(marca_gas).css({
										   "display" : "block",
										   "position" : "relative",
										   "left" : "10px",
										   "z-index" : 1
										});
		break;
		case "3/8":
			$("#a3").append(marca_gas);
		break;
		case "1/2":
			$("#a4").append(marca_gas).css({
										   "display" : "block",
										   "position" : "relative",
										   "left" : "10px",
										   "z-index" : 1
										});
		break;
		case "5/8":
			$("#a5").append(marca_gas);
		break;
		case "3/4":
			$("#a6").append(marca_gas).css({
										   "display" : "block",
										   "position" : "relative",
										   "left" : "10px",
										   "z-index" : 1
										});
		break;
		case "7/8":
			$("#a7").append(marca_gas);
		break;
		case "LL":
			$("#a8").append(marca_gas).css({
										   "display" : "block",
										   "position" : "relative",
										   "left" : "10px",
										   "z-index" : 1
										});
		break;
		default:
			//
		break;
	}

	$("#boton").click(function(){
		genIMG();	
	});

	if(b_generar == 1)												// para generar formato para enviar por correo
	{
		$("#boton").click();
	}
});
</script>
</html>
