<div class="row vista_previa">
	<div class="col-sm-3">
		<div class="col-sm"> 
            <label for="art_cliente" class="grey-text">Artículo</label>
             <input type="text" id="art_cliente" name="art_cliente" class="form-control" readonly="true">
        </div>
	</div>
	<div class="col-sm-2">
		<div class="col-sm">
			<label for="anio_cliente" class="grey-text">Año</label>
        	<input type="text" id="anio_cliente" name="anio_cliente" class="form-control" readonly="true">
		</div>
	</div>
	<div class="col-sm-3">
		<div class="col-sm">
			<label for="vin_cliente" class="grey-text">VIN</label>
            <input type="text" id="vin_cliente" name="vin_cliente" class="form-control" readonly="true">
		</div>
	</div>
	<div class="col-sm-3">
		<div class="col-sm">
			<label for="vin_cliente" class="grey-text">Placas</label>
            <input type="text" id="placas_cliente" name="placas_cliente" class="form-control validate[required]">
		</div>
	</div>
	<div class="col-sm-1">
        <div class="sm-"> 
            <p class="grey-text ver_todo_vehiculo" style="font-size: 12px;">Ver Todo</p>
            <i class="fa fa-plus rotate-icon fa-1x card-link" style="display: block; text-align: center; color: #1976D2; cursor: pointer;" id="ver_todoVehiculo"></i>
        </div>
    </div>
</div>
<div class="row vista_completa_vehiculo">
	<div class="col-sm-3">
		<div class="col-sm">
			<label for="color_cliente" class="grey-text">Color</label>
            <input type="text" id="color_cliente" name="color_cliente" class="form-control validate[required]">
		</div>
	</div>
	<div class="col-sm-3">
		<div class="col-sm">
			<label for="vin_cliente" class="grey-text">KM</label>
            <input type="text" id="kms_cliente" name="kms_cliente" class="form-control validate[required]">
		</div>
	</div>
</div>
<div class="row vista_completa_vehiculo">
    <div class="col-sm-11">
        <button class="btn btn-success float-right" id="actualizar_vehiculo">Guardar Cambios</button>
    </div>
</div>
<br>