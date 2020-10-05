<html>
<head>              
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/css/compiled.min.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" crossorigin="anonymous"></script>
</head>
<body>

<div class="container-fluid" id="orden_pdf">
	<div  class="row align-items-center">
		<div class="col-md-10">
			<div class="table-responsive">
				<table>
					<tr>
						<td><img src="http://logok.org/wp-content/uploads/2014/04/Ford-logo-219x286.png" alt="" style="width: 45%;"></td>
						<td>
							<p>RAVISA MOTORS SA. DE C.V</p>
						</td>
					</tr>
					<tr>
						<td>Asesor: <?= $asesor ?></td>
						<td>Torre: </td>
					</tr>
					<tr>
						<td>Fecha recepcion: <?= $fecha_recepcion?> </td>
						<td>Hora recepcion: <?= $hora_recepcion?></td>
						<td>Fecha de entrega: <?= $fecha_entrega?></td>
						<td>Hora de Entrega: <?= $hora_entrega?></td>
					</tr>
					<tr>
						<td> <b>Datos del Cliente</b></td>
					</tr>
					<tr>
						<td>Nombre(s): <?= $cliente ?></td>
				
					</tr>
					<tr>
						<td><b>Datos Vehiculo</b></td>
					</tr>
					<tr>
						<td>Placas: <?= $placas ?></td>
						<td>VIN: <?= $VIN ?> </td>
						<td>Kilometraje: <?=$kilometraje?> KM</td>
					</tr>
					<tr>
						<td>Marca/Linea del vehiculo</td>
						<td>A&ntilde;o Modelo: <?=$anio?></td>
						<td>Color: <?= $color?></td>
					</tr>
					<tr>
						<td>Tipo de orden: <?= $concepto?></td>
					</tr>
					<!-- add importes y desgloce -->
					<tr>
						<td><b>Inspeccion Visual</b></td>
					</tr>
					<tr>
						<td>
							Exterior: 
						</td>
					</tr>
					<tr>
						<td>Cajuela:  <?=$herramienta?></td>
					</tr>
					<tr>
						<td>Documentacion: </td>
					</tr>
					<tr>
						<td>subtotal:<?=$total?></td>
						<td>IVA: <?=$iva?></td>
						<td>Total: <?=$total?></td>
					</tr>
				</table>
				<br>
				<div class="col">
					<img src="<?=$firma?>" alt="Firma">
					Nombre y Firma del Cliente
					<?=$cliente?>
				</div>
			</div>
			<div class="table-responsive">
				<table>
					<?=$tabla?>
				</table>
			</div>
		</div>
	</div>
</div>
</body>
</html>