<?php
$attributes = array('id' => 'form_lineasTrabajo');
echo form_open('',$attributes);
?>
<div class="container">
	<div class="row" >
		<form role="form">
			<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
				<label for="num_rep" class="col-sm-4 control-label" style="white-space: nowrap;">No. Reparación</label>
				<input type="text" class="form-control" name="" id="num_rep">
			</div>
			<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
				<label for="tipo_garantia" class="col-sm-4 control-label" style="white-space: nowrap;">Tipo de Garantía</label>
				<select id="tipo_garantia" name="" style="width:auto;" class="browser-default form-control">
				<option value="">Tipo Garantías</option>
				<option value="Cero Defectos">Cero Defectos</option>
				<option value="Básica">Básica</option>
				<option value="Inspección de Previa Extensión de Servicio">Inspección Previa Extensión de Servicios</option>
				<option value="Política">Política</option>
				<option value="Partes de Servicio">Partes de Servicio</option>
				<option value="Partes Vendidas en Mostrador">Partes Vendidas</option>
				<option value="Daños en Transito">Daños en Transito</option>
				</select>
			</div>
			<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
				<label for="sub_garantia" class="col-sm-4 control-label" style="white-space: nowrap;">Sub Tipo de Garantía</label>
				<select id="sub_garantia" name="" style="width:auto;" class="browser-default form-control">
				<option value="">Sub Tipos Garantía</option>
				<option value="MVC">MVC (Son números de parte de Ford)</option>
				<option value="ACC">ACC</option>
				<option value="ADD">ADD</option>
				<option value="COMFU">COMFU</option>
				<option value="ESC, ESQ">ESC, ESQ (introducir el código publicado)</option>
				<option value="LVP">LVP</option>
				<option value="MT">MT</option>
				</select>
			</div>
			<div class="clearfix"></div>
			<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
				<label for="dan_relacion" class="col-sm-4 control-label" style="white-space: nowrap;">Daños en Relación</label>
				<input type="text" class="form-control" name="" id="dan_relacion">
			</div>
			<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
				<label for="auth_1" class="col-sm-4 control-label" style="white-space: nowrap;">Autorización N°1</label>
				<input type="text" class="form-control" name="" id="auth_1">
			</div>
			<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
				<label for="auth_2" class="col-sm-4 control-label" style="white-space: nowrap;">Autorización N°2</label>
				<input type="text" class="form-control" name="" id="auth_2">
			</div>
			<div class="clearfix"></div>
			<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
				<label for="part_total" class="col-sm-4 control-label" style="white-space: nowrap;">Partes Totales $</label>
				<input type="text" class="form-control" name="" id="part_total">
			</div>
			<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
				<label for="m_obra" class="col-sm-4 control-label" style="white-space: nowrap;">Mano Obra Total $</label>
				<input type="text" class="form-control" name="" id="m_obra">
			</div>
			<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
				<label for="misc_total" class="col-sm-4 control-label" style="white-space: nowrap;">Misc. Total $</label>
				<input type="text" class="form-control" name="" id="misc_total">
			</div>
			<div class="clearfix"></div>
			<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
				<label for="iva_total" class="col-sm-4 control-label" style="white-space: nowrap;">IVA $</label>
				<input type="text" class="form-control" name="" id="iva_total">
			</div>
			<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
				<label for="p_cliente" class="col-sm-4 control-label" style="white-space: nowrap;">Participación Cliente $</label>
				<input type="text" class="form-control" name="" id="p_cliente">
			</div>
			<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
				<label for="p_dist" class="col-sm-4 control-label" style="white-space: nowrap;">Participación Distribuidor $</label>
				<input type="text" class="form-control" name="" id="p_dist">
			</div>
			<div class="clearfix"></div>
			<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
				<label for="rep_total" class="col-sm-4 control-label" style="white-space: nowrap;">Reparación Total $</label>
				<input type="text" class="form-control" name="" id="rep_total">
			</div>
			
		</form>
	</div>
</div>		
<?php
echo form_close();
?>
