
<?php
$attributes = array('id' => 'formDiagnosticoTecnico');
echo form_open('',$attributes);
?>
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
											<td><input type="text" name="detalles[0][num_reparacion]" id="nreparacion" style="width: 80px;" required></td>
											<td><input type="text" name="detalles[0][luz_de_falla]" id="lfalla" style="width: 80px;" required></td>
											<td> <div class="form-group">
											<select id="tmotriz" name="detalles[0][tren_motriz]" style="width:auto;" class="browser-default form-control" required>
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
											</td>
											<td><input type="text" name="detalles[0][codigos]" id="icodigo" placeholder="Ingrese Código" required></td>
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
	<div class="table-responsive">
		<table class="table">
			<tbody>
				<tr>
					<td>QUEJA CLIENTE<input type="text" name="queja_cliente" id="qcliente" style="width: 300px;" required></td>
					<td>SÍNTOMAS DE FALLA<input type="text" name="sintomas_falla" id="sfalla" style="width: 300px;" required></td>
				</tr>
				<tr>
					<td>EQUIPO DE DIAGNÓSTICO<input type="text" name="equipo_diagnostico" id="ediagnostico" style="width: 300px;" required></td>
					<td>COMENTARIOS TÉCNICOS<input type="text" name="comentarios_tecnicos" id="ctecnicos" style="width: 300px;" required></td>
				</tr>
				<tr>
					<td>PÚBLICA
						<div class="col-sm-2">
							<div class="checkbox-inline">
								<input id="tpublica" type="checkbox" name="publica" onclick="document.getElementById('tgarantia').checked = false" opcional><label for="tpublica"></label>
							</div>
						</div>
					</td>
					<td>GARANTÍA
						<div class="col-sm-2">
							<div class="checkbox-inline">
                                <input id="tgarantia" type="checkbox" name="garantia" onclick="document.getElementById('tpublica').checked = false" optional><label for="tgarantia"></label>
                            </div>
						</div>
					</td>
					<td>ADICIONAL
						<div class="col-sm-2">
							<div class="checkbox-inline">
                                <input id="tadicional" type="checkbox" name="adicional" optional><label for="tadicional"></label>
                            </div>
						</div>
					</td>
				</tr>
				<tr>
					<td><b>Firma Técnico</b>
					<div class="form-check" id="checkTecnico1" >
						<input class="form-check-input" name="firma_tecnico" type="checkbox" id="checkTecn1" required>
						<label for="checkTecn1" for="checkTecn1"></label>
						<button type="button" class="btn btn-outline-warning btn-sm" id="cancelTecn1">X</button>
					</div>
					</td>
					<td><b>Firma Jefe Taller</b>
					<div class="form-check" id="checkeaJefe1" >
						<input class="form-check-input" name="firma_jefe_taller" type="checkbox" id="checkJefe1">
						<label for="checkJefe1" for="checkJefe1"></label>
						<button type="button" class="btn btn-outline-warning btn-sm" id="cancelJefe1">X</button>
					</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
echo form_close();
?>
