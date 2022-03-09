<ul class="nav nav-pills nav-fill" role="tablist">
	<li class="nav-item" role="presentation">
		<a class="nav-link active" id="nuev-lin" data-toggle="tab" role="tab" aria-controls="nueva_linea" aria-selected="true" href="#nueva_linea">AGREGAR TIPO DE GARANTÍAS</a>
	</li>
	<li class="nav-item" role="presentation">
		<a class="nav-link"  id="lin-carg" data-toggle="tab" role="tab" aria-controls="lineas_cargadas" aria-selected="true" href="#lineas_cargadas">TIPO DE GARANTÍAS AGREGADAS</a>
	</li>
	
</ul><br>
<div class="tab-content" id="linTabContent">
	<div class="col-md-12 tab-pane fade show active" id="nueva_linea" role="tabpanel" aria-labelledby="nuev-lin">
<?php
$attributes = array('id' => 'form_lineasTrabajo');
echo form_open('',$attributes);
?>
	<div class="container">
		<div class="row" >
			<form role="form">
				<div class="form-group col-md-8">
					<label for="linea_tipo" class="grey-text">Manos de Obra</label>
					<select id="linea_tipo" name="linea_tipo" class="browser-default form-control validate[required]" required>
					<option value="">seleccione una línea...</option>
					</select>
				</div>
				<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
					<label for="num_rep" class="control-label" style="white-space: nowrap;">No. Reparación</label>
					<input type="text" class="form-control" name="num_reparacion" id="num_rep">
				</div>
				<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
					<label for="tipo_garantia" class="control-label" style="white-space: nowrap;">Tipo de Garantía</label>
					<select id="tipo_garantia" name="tipo_garantia" class="browser-default form-control">
					<option value="">Tipo Garantías</option>
					<option value="Cero Defectos">Cero Defectos</option>
					<option value="Básica">Básica</option>
					<option value="Inspección de Previa Extensión de Servicio">Inspección Previa de Servicios</option>
					<option value="Política">Política</option>
					<option value="Partes de Servicio">Partes de Servicio</option>
					<option value="Partes Vendidas en Mostrador">Partes Vendidas</option>
					<option value="Daños en Transito">Daños en Transito</option>
					</select>
				</div>
				<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
					<label for="sub_garantia" class="control-label" style="white-space: nowrap;">Sub Tipo de Garantía</label>
					<select id="sub_garantia" name="subtipo_garantia" class="browser-default form-control">
					<option value="">Sub Tipos Garantía</option>
					<option value="MVC">MVC Son números desde Ford</option>
					<option value="ACC">ACC</option>
					<option value="ADD">ADD</option>
					<option value="COMFU">COMFU</option>
					<option value="ESC, ESQ">ESC, ESQ </option>
					<option value="LVP">LVP</option>
					<option value="MT">MT</option>
					</select>
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
					<label for="danios_relacion" class="col-sm-4 control-label" style="white-space: nowrap;">Daños en Relación</label>
					<input type="text" class="form-control" name="danio_ralacion" id="danios_relacion">
				</div>
				<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
					<label for="auth_1" class="col-sm-4 control-label" style="white-space: nowrap;">Autoriz N°1</label>
					<input type="text" class="form-control" name="autoriz_1" id="auth_1">
				</div>
				<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
					<label for="auth_2" class="col-sm-4 control-label" style="white-space: nowrap;">Autoriz N°2</label>
					<input type="text" class="form-control" name="autoriz_2" id="auth_2">
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
					<label for="part_total" class="col-sm-4 control-label" style="white-space: nowrap;">Partes Totales $</label>
					<input type="text" class="form-control" name="partes_totales" id="part_total">
				</div>
				<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
					<label for="m_obra" class="col-sm-4 control-label" style="white-space: nowrap;">Mano Obra Total $</label>
					<input type="text" class="form-control" name="mano_obra_total" id="m_obra">
				</div>
				<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
					<label for="misc_total" class="col-sm-4 control-label" style="white-space: nowrap;">Misc. Total $</label>
					<input type="text" class="form-control" name="misc_total" id="misc_total">
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
					<label for="iva_total" class="col-sm-4 control-label" style="white-space: nowrap;">IVA %</label>
					<input type="text" class="form-control" name="iva" id="iva_total">
				</div>
				<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
					<label for="p_cliente" class="col-sm-4 control-label" style="white-space: nowrap;">Participación Cliente $</label>
					<input type="text" class="form-control" name="participacion_cliente" id="p_cliente">
				</div>
				<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
					<label for="p_dist" class="col-sm-4 control-label" style="white-space: nowrap;">Participación Distribuidor $</label>
					<input type="text" class="form-control" name="participacion_distribuidor" id="p_dist">
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4" >
					<label for="rep_total" class="col-sm-4 control-label" style="white-space: nowrap;">Reparación Total $</label>
					<input type="text" class="form-control" name="reparacion_total" id="rep_total">
				</div>
				
			</form>
		</div>
	</div>
<table style="width:100%">
<tr>
<td style="text-align: center;"><b>ADMINISTRADOR DE GARANTÍA</b>
<div class="form-check" name="firma_linea" id="checkFirmaAdmon" style="text-align: center;">
	<input class="form-check-input" type="checkbox" name="firma_linea" id="firma_linea">
	<label class="form-check-label" for="firma_linea">FIRMA</label>
	<input type="hidden" name="firma_admin" id="firma_admin">
	<button type="button" class="btn btn-outline-warning btn-sm" id="cancelar_firmaLineas">X</button>
</div>
</td>
</tr>
</table>		
<?php
echo form_close();
?>
</div>
<div class="col-md-12 tab-pane fade" id="lineas_cargadas" role="tabpanel" aria-labelledby="lin_carg">
	<div class="modal-body" >
		<div class="row">
			<div class="col-sm-12 table-responsive">
				<table class="table"></table>
			</div>
		</div>
	</div>
</div>
</div>
