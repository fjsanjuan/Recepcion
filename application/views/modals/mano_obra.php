<div class="form-group col" style="display: none;">
	<label for="ZonaImpuesto_selected" class="grey-text">% IVA (Zona Impuesto)</label>
	<select id="ZonaImpuesto_selected" name="ZonaImpuesto_selected" class="browser-default form-control validate[required]">
		<option>Seleccione... </option>
	</select>
</div>
<?php
    $attributes = array('id' => 'form_datosManObra');
    echo form_open('',$attributes);
?>
<div class="row" style="text-align: center;">
	<div class=" col-md-12" >
		<div class="panel panel-default" >
			<div class="panel-heading" >
				<!--<a class="btn btn-primary btn-sm" data-toggle="modal" id="add_pac"><i class="fa fa-plus mr-1"></i> Agregar Paquete</a>-->
				<!--  <a class="btn btn-primary btn-sm" data-toggle="modal" ><i class="fa fa-plus mr-1"></i> Agregar Op. Frecuentes</a> 
				<a class="btn btn-primary btn-sm" data-toggle="modal" id="add_mano"><i class="fa fa-plus mr-1"></i> Mano de Obra</a>-->
				<!--<a class="btn btn-primary btn-sm" data-toggle="modal" id="add_arts"><i class="fa fa-plus mr-1"></i> Articulos</a>-->
			</div>
			<div class="panel-body" >
				<div class="table-responsive" style="width: 100%;">
					<table class="table table-condensed" id="tabla_invoice" >
						<thead>
							<tr>
								<td></td>
								<td><strong>Artículo</strong></td>
								<td class="text-center"><strong>Descripción</strong></td>
								<td class="text-center"><strong>Cantidad</strong></td>
								<td class="text-center"><strong>Precio U</strong></td>
								<td class="text-center"><strong>Total</strong></td>
							</tr>
						</thead>
						<tbody>

					</tbody>
					</table>
				</div>
				<div class="row" style="text-align: center;">
					<div class="col">
						<div class="md-form" style="padding: 25px; font-size: 45px;">
							<i class="fa fa-dollar" aria-hidden="true"></i>
						</div>
					</div>
					<div class="col">
						<div class="md-form" style="padding: 25px;">
							<span class="font-weight-bold">SUBTOTAL</span>
							<input class="form-control" id="subTotal" name ="subTotal" type="text" readonly="true">
						</div>
						
					</div>
					<div class="col">
						<div class="md-form" style="padding: 25px;">
								<span class="font-weight-bold">IVA</span>  
								<input class="form-control" type="text" name="ivaTotal" id="ivaTotal" readonly="true">
						</div>
						
					</div>
					<div class="col">
						<div class="md-form" style="padding: 25px;">
							<span class="font-weight-bold">TOTAL</span>
							<input class="due form-control" type="text" name='totales' id="totales" readonly="true">
						</div>
					</div>   
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-body" style="height: 300px; overflow-y: scroll;">
	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
				<input class="form-control" type="text" id="buscarManObra" onkeyup="mySearch()" placeholder="Buscar por Descripcion">
				<table class="table table-bordered table-striped table-hover animated fadeIn table_mano" id="table_mano">
					<thead class="mdb-color primary-color" style="font-weight: bold; color:#fff;">
						<tr>
							<th>Articulo</th>
							<th>Descripcion</th>
							<th>Precio</th>
						</tr>
					</thead>
				</table>
			</div>
			<br>
			<div class="loader loader5" id="spinner">
				<svg width="40px" height="40px" viewBox="0 0 40 40" fill="transparent">
				<circle cx="20" cy="20" r="4" stroke="#1976D2"/>
				</svg>
			</div>
		</div>
	</div>
</div>
<?php
	echo form_close();
?>
