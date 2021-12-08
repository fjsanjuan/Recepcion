<?php
	$attributes = array('id' => 'form_requisicion');
	echo form_open('', $attributes);
?>
<div class="col-md-12">
	<tbody>
	<tr>
		<td><b>No. REQUISICIÓN</b><input type="text" class="form-control" name="num_req" id="" readonly></td>
		<td><b>FECHA REQUISICIÓN</b><input type="text" class="form-control" name="fec_req" id="" readonly></td>
		<td><b>FECHA RECEPCIÓN</b><input type="text" class="form-control" name="fec_recep" id="" readonly></td>
		<td><b>No. 1863</b><input type="text" class="form-control" name="folio_1863" id="" readonly></td>
		<td><b>TÉCNICO</b><input type="text" class="form-control" name="tecnico" id="" readonly></td>
		</tr>
	</tbody>
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-border text-center">
				<thead>
					<tr>
						<th>CANT.</th>
						<th>NO. PARTE</th>
						<th>DESCRIPCIÓN DE LA PARTE</th>
					</tr>
				</thead>
				<tbody class="lineas_refacciones">
					<tr>
					<td><input type="text" class="digitos form-control" id="" pattern="\d+" digits required name="detalles[0][cantidad]" style="width: 50px;" /></td>
					<td><input type="text" class="form-control" id="" required name="detalles[0][numero]" style="width: 100px;" /></td>
					<td><input type="text" class="form-control" id="" required name="detalles[0][descripcion]" style="width: 400px;" /></td>
					<td>
					<i class="fa fa-plus fa-2x nueva_linea" style="color:green; cursor:pointer;" aria-hidden="true"></i>
					</td>
					<td>
					<i class="fa fa-times fa-2x borra_linea" style="color:red; cursor:pointer;"></i>
					</td>
					</tr>
				</tbody>
			</table>
			<div class="table-responsive">
				<table class="table table-border text-center">
					<tbody>
						<tr>
							<td><b>Nombre y Firma Resp. Refacc.</b>
							<div class="form-check" id="checkRefacc" >
							<input class="form-check-input" type="checkbox" id="refaccCheck1" style="display:none">
							<label class="form-check-label" for="refaccCheck1" style="display:none">Firma</label>
							</div>
							</td>
							<td><b>Nombre y Firma Técnico</b>
							<div class="form-check" id="checkTecn" >
							<input class="form-check-input" type="checkbox" id="reciboCheck1" style="display:none">
							<label class="form-check-label" for="reciboCheck1" style="display:none">Firma</label>
							</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php
	echo form_close();
?>
