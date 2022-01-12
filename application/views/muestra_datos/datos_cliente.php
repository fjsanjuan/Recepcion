<!-- hidden fields -->
<input type="hidden" name="empresa_cliente"  id="empresa_cliente">
<input type="hidden" name="sucursal_cliente" id="sucursal_cliente">
<input type="hidden" name="almacen_cliente"  id="almacen_cliente">
<input type="hidden" name="cliente_cliente"  id="cliente_cliente">
<input type="hidden" name="paquete_cliente" id="paquete_cliente">                      
<input type="hidden" name="id_servicio"  id="id_servicio">
<input type="hidden" name="mov_cliente" id="mov_cliente" value="Servicio">
<input type="hidden" id="Fecha_Emision_cliente" name="Fecha_Emision_cliente">
<input type="hidden" name="nom_cliente" id="nom_cliente">
<input type="hidden" name="ap_cliente" id="ap_cliente">
<input type="hidden" name="am_cliente" id="am_cliente">
<input type="hidden" name="ZonaImpuesto" id="ZonaImpuesto">

<div class="row vista_previa">
	<div class="col-sm-2">
        <div class="sm-"> 
            <label for="id_cliente" class="grey-text">Clave</label>
            <input type="text" id="id_cliente" name="id_cliente" class="form-control" readonly="true">
       </div>
	</div>
    <div class="col-sm-4">
        <div class="sm-"> 
            <label for="nombre_cliente" class="grey-text">Cliente</label>
            <input type="text" id="nombre_cliente" name="nombre_cliente" class="form-control">
        </div>
	</div>
    <div class="col-sm-2">
        <div class="sm-"> 
            <label for="cel_cliente" class="grey-text">Celular</label>
            <input type="text" id="cel_cliente" name="cel_cliente" class="form-control  validate[required,custom[onlyNumberSp],minSize[13],maxSize[13]] ">
        </div>
    </div>
    <div class="col-sm-3">
        <div class="sm-"> 
            <label for="correo_cliente" class="grey-text">Email</label>
            <input type="text" id="correo_cliente" name="correo_cliente" class="form-control validate[required] [custom[email]]">
        </div>
    </div>
    <div class="col-sm-1">
        <div class="sm-"> 
            <p class="grey-text ver_todo_texto" style="font-size: 12px; margin-bottom: 8px;">Ver Todo</p>
            <i class="fa fa-plus rotate-icon fa-1x card-link" style="display: block; text-align: center; color: #1976D2; cursor: pointer;" id="ver_todoCliente"></i>
        </div>
    </div>
</div>
<div class="row vista_completa">
	<div class="col-sm-2">
		<div class="sm-">
			<label for="lada_casa" class="grey-text">Lada Casa</label>
			<input type="text" id="lada_casa" name="lada_casa" class="form-control">
		</div>
	</div>
	<div class="col-sm-2">
		<div class="sm-">
			<label for="telefono_cliente" class="grey-text">Casa</label>
			<input type="text" id="telefono_cliente" name="telefono_cliente" class="form-control  validate[required]">
		</div>
	</div>
	<div class="col-sm-2">
		<div class="sm-">
			<label for="lada_oficina" class="grey-text">Lada Oficina</label>
			<input type="text" id="lada_oficina" name="lada_oficina" class="form-control">
		</div>
	</div>
	<div class="col-sm-2">
		<div class="sm-">
			<label for="telefono_oficina" class="grey-text">Teléfono Oficina</label>
			<input type="text" id="telefono_oficina" name="telefono_oficina" class="form-control ">
		</div>
	</div>
	
</div>
<div class="row vista_completa">
	<div class="col-sm-4">
		<div class="sm-">
			<label for="rfc_cliente" class="grey-text">RFC</label>
			<input type="text" id="rfc_cliente" name="rfc_cliente" class="form-control" readonly="true">
		</div>
	</div>
	<div class="col-sm-5">
		<div class="sm-">
			<label for="dir_cliente" class="grey-text">Dirección</label>
			<input type="text" id="dir_cliente" name="dir_cliente" class="form-control validate[required]">
		</div>
	</div>
</div>	
<div class="row vista_completa">
	<div class="col-sm-2">
		<div class="sm-">
			<label for="numExt_cliente" class="grey-text">Núm. Ext.</label>
			<input type="text" id="numExt_cliente" name="numExt_cliente" class="form-control validate[required]">
		</div>
	</div>
	<div class="col-sm-2">
		<div class="sm-">
			<label for="numInt_cliente" class="grey-text">Núm. Int.</label>
			<input type="text" id="numInt_cliente" name="numInt_cliente" class="form-control validate[required]">
		</div>
	</div>
	<div class="col-sm-7">
		<div class="sm-">
			<label for="colonia_cliente" class="grey-text">Colonia</label>
			<input type="text" id="colonia_cliente" name="colonia_cliente" class="form-control validate[required]">
		</div>
	</div>
</div>
<div class="row vista_completa">
	<div class="col-sm-4">
		<div class="sm-">
			<label for="poblacion_cliente" class="grey-text">Población</label>
			<input type="text" id="poblacion_cliente" name="poblacion_cliente" class="form-control validate[required]">
		</div>
	</div>
	<div class="col-sm-4">
		<div class="sm-">
			<label for="estado_cliente" class="grey-text">Estado</label>
			<input type="text" id="estado_cliente" name="estado_cliente" class="form-control validate[required]">
		</div>
	</div>
	<div class="col-sm-3">
		<div class="sm-">
			<label for="cp_cliente" class="grey-text">Código Postal</label>
			<input type="number" id="cp_cliente" name="cp_cliente" class="form-control validate[required]">
		</div>
	</div>
</div>
<br>
<div class="row vista_completa">
	<div class="col-sm-11">
		<button class="btn btn-success float-right" id="actualizar_cliente">Guardar Cambios</button>
	</div>
</div>