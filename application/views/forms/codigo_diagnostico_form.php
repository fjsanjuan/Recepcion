<div class="col-md-12">
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th><b>NO. REP.</b></th>
											<th><b>LUZ FALLA ENCENDIDA</b></th>
											<th><b>TIPO CÓDIGOS DTC&nbspTREN&nbspMOTRIZ</b></th>
											<th><b>CÓDIGOS</b></th>
										</tr>
									</thead>
									<tbody class="code_lines">
										<tr>
											<td><input type="text" name="" id="" style="width: 80px;"></td>
											<td><input type="text" name="" id="" style="width: 80px;"></td>
											<td> <div class="form-group">
											<select id="select_codigo" name="select_codigo" style="width:auto;" class="browser-default form-control">
												<option value="">Tipo códigos</option>
                                				<option value="2">KOEO</option>
                                				<option value="3">KOEC</option>
                                				<option value="4">KOER</option>
                                				<option value="5">CARROCERIA</option>
                                				<option value="6">CHASIS</option>
                                				<option value="7">INDEFINIDO</option>
												<option value="8">OTRO</option>
											</select>
											</div>
											</td>
											<td><input type="text" name="" id="" placeholder="Ingrese Código"></td>
											<td><i class="fa fa-plus fa-2x nuevo_codigo" style="color:grey; cursor:pointer;" aria-hidden="true"></i></td>
											<td><i class="fa fa-times fa-2x erase_line" style="color:grey; cursor:pointer;"></i></td>
                            			</tr>
									</tbody>
								</table>
							</div>
						</div> 
					</th>
                </tr>
            </thead>
        </table>
	</div>
</div> 
<div class="col-md-12">
	<div class="modal-header">
		<h5 style="color: #4285f4;" class="modal-title" id="exampleModalLongTitle"><b>COMENTARIOS DEL MECANICO</b></h5>
    </div>
</div>
<div class="col-md-12">
	<div class="table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th><b>INCLUYA LA DESCRIPCION DE LA CAUSA DEL PROBLEMA</b></th>
					<th><b>NÚMERO REP.</b></th>
					<th><b>CLAVE DE DEFECTO</b></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="form-group">
							<label for="usr">IDENTIFIQUE LA PARTE CAUSANTE</label><br>
							<input type="text" class="form-control" id="usr" name="username">
						</div>
					</td>
					<td><input type="text" class="form-control" name="" id=""></td>
					<td><input type="text" class="form-control" name="" id=""></td>
				</tr>
				<tr>
					<td>
						<div class="form-group">
							<label for="usr">IDENTIFIQUE LA CAUSA DE LA FALLA</label><br>
							<input type="text" class="form-control" id="usr" name="username">
						</div>
					</td>
					<td><input type="text" class="form-control" name="" id=""></td>
					<td><input type="text" class="form-control" name="" id=""></td>
				</tr>
				<tr>
					<td>
						<div class="form-group">
							<label for="usr">IDENTIFIQUE EL EQUIPO DE DIAGNOSTICO</label>
							<input type="text" class="form-control" id="usr" name="username">
						</div>
					</td>
					<td><input type="text" class="form-control" name="" id=""></td>
					<td><input type="text" class="form-control" name="" id=""></td>
				</tr>
				<tr>
					<td>
						<div class="form-group">
							<label for="usr">EXPLIQUE LA REPARACIÓN AFECTUADA</label>
							<textarea name="textarea" rows="10" cols="50"></textarea>
						</div>
					</td>
					<td><input type="text" class="form-control" name="" id=""></td>
					<td><input type="text" class="form-control" name="" id=""></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="col-md-12">
	<div class="modal-header">
		<h5 style="color: #4285f4;" class="modal-title" id="exampleModalLongTitle"><b>REGISTRO DE LABOR</b></h5>
	</div>
</div>
<div class="col-md-12">
	<div class="table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th style="width: 200px;"><b>RETORNO DE PARTES: BASICO/FECHA</b></th>
					<th style="width: 70px;"><b>MECANICO CLAVE</b></th>
					<th style="width: 60px;"><b>COSTO O TIEMPO UTILIZADO</b></th>
					<th style="width: 70px;"><b>RELOJ CHEC.(INICIO)</b></th>
					<th style="width: 70px;"><b>RELOJ CHEC.(TERMINO)</b></th>
				</tr>
			</thead>
			<tbody class="registro_labor">
				<tr>
					<td><input type="text" class="form-control" id="" name="return_partes{}" style="width: 200px;" /></td>
					<td><input type="text" class="form-control" id="" name="mecanico_clave{}" style="width: 70px;" /></td>
					<td><input type="text" class="form-control" id="" name="costo_tiempo{}" style="width: 60px;" /></td>
					<td><input type="text" class="form-control" id="" name="reloj_inicio{}" style="width: 70px;" /></td>
					<td><input type="text" class="form-control" id="" name="reloj_termino{}" style="width: 70px;" /></td>
					<td>
						<i class="fa fa-plus fa-1x nuevo_registro" style="color:green; cursor:pointer;" aria-hidden="true"></i>
					</td>
					<td>
						<i class="fa fa-times fa-1x borrar_registro" style="color:red; cursor:pointer;"></i>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="form-check">
	<input class="form-check-input" type="checkbox" id="firmaCheck1" disabled>
	<label class="form-check-label" for="firmaCheck1">Firma Jefe Taller</label>
</div>
