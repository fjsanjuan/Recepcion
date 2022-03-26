<!DOCTYPE html>
	<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<head>
	<link rel="stylesheet" href="<?=base_url()?>assets/librerias/fontawesome-free-5.2.0-web/css/all.css"/>
	<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" media="all">
	<link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">

    <link href="<?=base_url()?>assets/css/compiled.min.css" rel="stylesheet">
	<link rel="icon" href="<?=base_url();?>assets/img/favicon.ico" type="image/x-icon">

	<script src="<?=base_url()?>assets/js/jquery.min.js"></script>
	<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url()?>assets/librerias/html2canvas/html2canvas.js"></script>
	<script src="<?=base_url()?>assets/librerias/html2canvas/html2canvas.min.js"></script>
	<style>
	
	</style>
	</head>
	<body>
		<div class="container borde_general">
			<div class="row">
				<div class="col-12">
					<h5 style="text-align: right;">COMPRA BACK ORDER</h5>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<table class="table table-bordered table-striped table-hover animated fadeIn no-footer tableDet">
								<tbody>
								<?php
									foreach ($compra as $key => $value) {
										echo "<tr><td  style='border: 1px solid black'><b>".$value["MovCompra"].'<br/> '.($value["MovIDCompra"] ? $value["MovIDCompra"] : $value["ID"])."</b></td>";
										echo "<td  style='border: 1px solid black'><b> Orden Servicio <br> ".$value["MovIDVenta"]."</b></td>";
										echo "<td  style='border: 1px solid black'><b> Estatus <br>".$value["Estatus"]."</b></td>";
										echo "<td  style='border: 1px solid black'><b> Moneda <br/>".$value["Moneda"]."</b></td>";
										echo "<td  style= 'border: 1px solid black'><b> Fecha Emision <br/>".$value["FechaEmision"]."</b></td></tr>";
									}
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
							<tbody>
								<p>
									Proveedor: <b><?=isset($compra[0]['Nombre']) ? $compra[0]['Nombre'] : '-'?> <?=isset($compra[0]['Proveedor']) ? $compra[0]['Proveedor'] : '-'?>  </b><br>
									Referencia: <b><?=isset($compra[0]['Referencia']) ? $compra[0]['Referencia'] : '-'?>  </b><br>
									Forma de Adquisición: <b><?=isset($compra[0]['Concepto']) ? $compra[0]['Concepto'] : '-'?> </b> <br>
									Observaciones: <b> </b><br>
								</p>
							</tbody>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<table class="table table-striped table-hover animated fadeIn no-footer tableDesc">
								<thead><tr><th><b>Artículo</b></th><th><b>Descripción</b></th><th><b>Cantidad</b></th><th><b>Almacén</b></th></tr></thead>
								<tbody>
								<?php
									foreach ($data as $key => $value) {
										echo "<tr><td>".$value["Articulo1"]."</td>";
										echo "<td>".$value["Descripcion1"]."</td>";
										echo "<td>".$value["Cantidad"]."</td>";
										echo "<td>".$value["Almacen"]."</td></tr>";
									} 
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
	</body>
	</html>