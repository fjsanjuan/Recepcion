<ul class="nav nav-pills nav-fill" role="tablist">
	<li class="nav-item" role="presentation">
		<a class="nav-link active" id="req-tab" data-toggle="tab" role="tab" aria-controls="nuevaReq" aria-selected="true" href="#nuevaReq">Nueva Requsición</a>
	</li>
	<li class="nav-item" role="presentation">
		<a class="nav-link"  id="cot-tab" data-toggle="tab" role="tab" aria-controls="cotizaciones" aria-selected="true" href="#cotizaciones">cotizaciones</a>
	</li>
	
</ul>
<div class="tab-content" id="reqTabContent">
	<div class="col-md-12 tab-pane fade show active" id="nuevaReq" role="tabpanel" aria-labelledby="req-tab">
		<tbody>
			<tr>
				<td><b>No. REQUISICIÓN</b><input type="text" class="form-control" name="num_req" id="" readonly></td>
				<td><b>FECHA REQUISICIÓN</b><input type="text" class="form-control" name="fec_req" id="" readonly></td>
				<td><b>FECHA RECEPCIÓN</b><input type="text" class="form-control" name="fec_recep" id="" readonly></td>
				<td><b>No. 1863</b><input type="text" class="form-control" name="folio_1863" id="" readonly></td>
				<td><b>TÉCNICO</b><input type="text" class="form-control" name="tecnico" id="" readonly></td>
			</tr>
		</tbody>
		<div class="modal-body">
			<div class="card">
				<div class="card-body">
					<div class="form-group">
						<div class="row">
							<div class="col-sm-4 ui-front">
								<input type="hidden" name="input_claveArt" id="input_claveArt3">
								<input class="form-control ui-autocomplete-input" type="text" id="ajax_arts3" placeholder="Buscar Artículo">
								<!-- <datalist id="json-datalist-art"></datalist> -->
							</div>
							<div class="col-sm-1">
								<label for="input_precio3">Precio:</label>
							</div>
							<div class="col-sm-2">
								<input class="form-control" type="text" id="input_precio3" name="input_precio">
							</div>
							<div class="col-sm-1">
								<label for="input_cantidad3">Cantidad:</label>
							</div>
							<div class="col-sm-1">
								<input type="" class="" id="" name="" value="" readonly="" style='display:none'>
							</div>
							<div class="col-sm-1">
								<input type="number" class="form-control" id="input_cantidad3" name="input_cantidad" value="1" style="width: 150% !important" >
							</div>
							<br><br>
							<div class="col-sm-1">
								<input type="text" class="form-control" id="input_stock3" name="input_stock" value="0" readonly="true" style='display:none'>
							</div>
							<div class="col-sm-1">
								<button class="btn btn-sm btn-success float-right" id="boton_agregarArt3"><i class="fa fa-plus"></i></button>
							</div>
						</div>
					</div>
					<br>
					<div class="loader loader5" id="spinner">
						<svg width="40px" height="40px" viewBox="0 0 40 40" fill="transparent">
							<circle cx="20" cy="20" r="4" stroke="#1976D2"/>
						</svg>
					</div>
				</div>
			</div>
			<div class="card" id="card_articulos3" style="display: none;">
			<div class="card-body">
				<h5>Artículos</h5>
				<div class="table-responsive">
					<?php
					$attributes = array('id' => 'form_requisicion');
					echo form_open('',$attributes);
					?>
					<table class="table table-condensed" id="table_invoice3">
						<thead>
							<tr>
								<td></td>
								<td><strong>Artículo</strong></td>
								<td class="text-center"><strong>Descripción</strong></td>
								<td class="text-center"><strong>Cantidad</strong></td>
								<td class="text-center"><strong>Precio U</strong></td>
								<td class="text-center" style="display: none"><strong>Comentarios</strong></td>
								<td class="text-center"><strong>Total</strong></td>
							</tr>
						</thead>
						<tbody>
						</tbody>
							<tfoot>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><label for="totalFin3">Total Fin:</label></td>
									<td class=""><input class="cost md-textarea" id="precioTotal3" name="precioTotal3" readonly="true"></td>
								</tr>
							</tfoot>
					</table>
					<input type="hidden" id="id_orden_b3" name="id_orden_b">
					<input type="hidden" id="numero_articulos3" name="numero_articulos">
					<input type="hidden" id="id_presupuesto3" name="id_presupuesto">
					<input type="hidden" id="id_requisicion3" name="id_requisicion">
					<!--<input type="text" name="firma_de_admon" id="firma_de_admon" style="display: none;">
					<input type="text" name="firma_de_tecnico" id="firma_de_tecnico" style="display: none;">-->
					<?php
					echo form_close();
					?>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-success" id="guardarReq">Guardar Requisición</button>
			<button type="button" class="btn btn-success" id="bnActualizarRequi" style="display: none">Actualizar Requisición</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		</div>
	</div>
	<div id="cotizaciones" class="tab-pane fade" role="tabpanel" aria-labelledby="cot-tab">
		<div class="col-md-12">
			<button class="btn btn-sm btn-success actualizarCot"><i class="fa fa-refresh"></i> Actualizar</button>
		</div>
		<div class="row contentCot">
		</div>
	</div>
</div>

