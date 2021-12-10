<?php 
	if(isset($bandera_correo))
	{
?>
	<!DOCTYPE html>
	<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<head>
	<link rel="stylesheet" href="<?=base_url()?>assets/librerias/fontawesome-free-5.2.0-web/css/all.css"/>
	<!-- <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet"> -->
	<link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
	<title>Verificación</title>
	</head>
	<style>
	.container {
	    width: 100%;
	    padding-right: 15px;
	    padding-left: 15px;
	    margin-right: auto;
	    margin-left: auto;
	} 

	.row {
	  margin-right: -15px;
	  margin-left: -15px;
	}

	.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
	    position: relative;
	    width: 100%;
	    min-height: 1px;
	    padding-right: 15px;
	    padding-left: 15px;
	}

	.h5, h5 {
	    font-size: 1.25rem;
	}

	p {
	    margin-top: 0;
	    margin-bottom: 1rem;
	}

	.h6, h6 {
	    font-size: 1rem;
	}
	.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
	    margin-bottom: .5rem;
	    font-family: inherit;
	    font-weight: 500;
	    line-height: 1.2;
	    color: inherit;
	}
	h1, h2, h3, h4, h5, h6 {
	    margin-top: 0;
	    margin-bottom: .5rem;
	}

	b, strong {
	    font-weight: bolder;
	}

	.card {
	    position: relative;
	    background-color: #fff;
	    background-clip: border-box;
	    border: 1px solid rgba(0,0,0,.125);
	    border-radius: .25rem;
	}

	.card-body {
	    padding: 1.25rem;
	}

	.table-bordered {
	    border: 1px solid #dee2e6;
	}

	.table {
	    width: 100%;
	    max-width: 100%;
	    margin-bottom: 1rem;
	    background-color: transparent;
	}
	table {
	    border-collapse: collapse;
	}
	</style>
	<body>
		<div class="container borde_general">
			<div class="row">
				<div class="col-10" style="text-align: center;">
					<h5><?=$agencia['razon_social']?></h5>
					<p><?=$datos_suc['dom_calle']." #".$datos_suc['dom_numExt'].", ".$datos_suc["dom_numInt"]?>, <?=$datos_suc['dom_colonia']?>
					<br><?=$datos_suc['dom_ciudad']?>, <?=$datos_suc['dom_estado']?>, <?=$datos_suc['dom_cp']?>
					<br> Email: <?=$datos_suc['email_contacto']?>     Sitio Web: <?=$datos_suc['sitio_web']?> <br>
					</p>
				</div>
				<div class="col-2">
					<?php 
						$movID = (isset($usuario["movID"]["MovID"])) ? $usuario["movID"]["MovID"] : "-";
					?>
					<h5>ORDEN NO <?=$movID?></h5>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<h5>FORMATO DE VERIFICACIÓN DE REFACCIONES</h5>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<h6>TECNICO</h6>
							<p>
							<b>Nombre Técnico:</b> <?=$datos_tecnico['nombre']?> <?=$datos_tecnico['apellidos']?><br>
							<b>Email: </b> <?=$datos_tecnico['correo_tecnico']?><br>
							<b>Fecha Verificación:</b> <?=$datos_tecnico['actualizado']?><br>
							<!-- <b>Presupuesto Autorizado:</b> <?=($datos_tecnico['autorizado'] == 1)?"SI":"NO"?> -->
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<h6>REFACCIONES</h6>
							<p>
							<b>Nombre Responsable:</b> <?=$datos_refacciones['nombre']?> <?=$datos_refacciones['apellidos']?><br>
							<b>Email: </b> <?=$datos_refacciones['correo_refacciones']?><br>
							
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<h6>PARTES REQUERIDAS</h6>
							<table class="table table-bordered table-striped table-hover animated fadeIn no-footer tablepres">
								<thead><tr><th>Clave Articulo</th><th>Descripcion</th><th>Precio Unitario</th><th>Cantidad</th>
									<th>I.V.A.</th><th>Total</th><th>En Existencia</th></tr></thead>
								<tbody>
									<?php
										$total = 0;
										foreach ($detalle as $key => $value) {
											$iva= round(($value["precio_unitario"]*0.16),2);
											
											$totalIva = $iva*$value["cantidad"];
											echo "<tr><td>".$value["cve_articulo"]."</td>";
											echo "<td>".$value["descripcion"]."</td>";
											echo "<td>".$value["precio_unitario"]."</td>";
											echo "<td>".$value["cantidad"]."</td>";
											echo "<td>".$totalIva."</td>";
											echo "<td>".($value["total_arts"]+$totalIva)."</td>";
											//echo "<td>".$value["en_existencia"]."</td>";
											if($value["autorizado"] == 1)
											{
												echo "<td style='text-align: center;'><input type='checkbox' style='background-color: blue; height: 24px; width: 24px;' checked disabled></td></tr>";
											}else 
											{
												echo "<td style='text-align: center;'><input type='checkbox' style='background-color: blue; height: 24px; width: 24px;' disabled></td></tr>";
											}
											$total += ($value["total_arts"]+$totalIva);
										}
										echo "<tr><td colspan = '4' ></td><td>".$total."</td></tr>";
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	</html>
<?php 
	}else 
	{
?>
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
	<title>Verificación</title>
	</head>
	<body>
		<div class="container borde_general">
			<div class="row">
				<div class="col-4">
					
				</div>
				<div class="col-6">
					<h5><?=$agencia['razon_social']?></h5>
					<p><?=$datos_suc['dom_calle']." #".$datos_suc['dom_numExt'].", ".$datos_suc["dom_numInt"]?>, <?=$datos_suc['dom_colonia']?>
					<br><?=$datos_suc['dom_ciudad']?>, <?=$datos_suc['dom_estado']?>, <?=$datos_suc['dom_cp']?>
					<br> Email: <?=$datos_suc['email_contacto']?>     Sitio Web: <?=$datos_suc['sitio_web']?> <br>
					</p>
				</div>
				<div class="col-2">
					<?php 
						$movID = (isset($usuario["movID"]["MovID"])) ? $usuario["movID"]["MovID"] : "-";
					?>
					<h5>ORDEN NO <?=$movID?></h5>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<h5>FORMATO DE VERIFICACIÓN DE REFACCIONES</h5>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<h6>TÉCNICO</h6>
							<p>
							<b>Nombre Técnico:</b> <?=$datos_tecnico['nombre']?> <?=$datos_tecnico['apellidos']?><br>
							<b>Email: </b> <?=$datos_tecnico['correo_tecnico']?><br>
							<b>Fecha Verificación:</b> <?=$datos_tecnico['actualizado']?><br>
							<!-- <b>refacciones Autorizadas:</b> <?=($datos_tecnico['autorizado'] == 1)?"SI":"NO"?> -->
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<h6>REFACCIONES</h6>
							<p>
							<b>Nombre Responsable:</b> <?=$datos_refacciones['nombre']?> <?=$datos_refacciones['apellidos']?><br>
							<b>Email: </b> <?=$datos_refacciones['correo_refacciones']?><br>
							
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<h6>PARTES REQUERIDAS</h6>
							<table class="table table-bordered table-striped table-hover animated fadeIn no-footer tablepres">
								<thead><tr><th>Clave Articulo</th><th>Descripcion</th><th>Precio Unitario</th><th>Cantidad</th>
									<th>I.V.A.</th><th>Total</th><th>En Existencia</th></tr></thead>
								<tbody>
									<?php
										$total = 0;
										foreach ($detalle as $key => $value) {
											$iva= round(($value["precio_unitario"]*0.16),2);
											
											$totalIva = $iva*$value["cantidad"];
											echo "<tr><td>".$value["cve_articulo"]."</td>";
											echo "<td>".$value["descripcion"]."</td>";
											echo "<td>".$value["precio_unitario"]."</td>";
											echo "<td>".$value["cantidad"]."</td>";
											echo "<td>".$totalIva."</td>";
											echo "<td>".($value["total_arts"]+$totalIva)."</td>";
											//echo "<td>".$value["en_existencia"]."</td>";
											if($value["autorizado"] == 1)
											{
												echo "<td style='text-align: center;'><input type='checkbox' style='background-color: blue; height: 24px; width: 24px;' checked disabled></td></tr>";
											}else 
											{
												echo "<td style='text-align: center;'><input type='checkbox' style='background-color: blue; height: 24px; width: 24px;' disabled></td></tr>";
											}
											$total += ($value["total_arts"]+$totalIva);
										}
										echo "<tr><td colspan = '5' ></td><td>".$total."</td></tr>";
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<h6>Aviso</h6>
							<p>
								<ul>
									<li>Estos precios tiene Vigencia de 30 dias </li>
									<li>Los precios pueden cambiar sin previo Aviso</li>
								</ul>
							</p>
						</div>
					</div>
				</div>
			</div>
	</body>
	</html>
<?php 
	}
?>
