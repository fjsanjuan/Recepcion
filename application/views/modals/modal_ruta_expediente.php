<!--modal para actualizar la ruta de almacenamiento del expediente digital-->
<div class="modal fade" id="modal-ruta-expediente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="false">
	<div class="modal-dialog modal-lg"  role="document" style="max-width: 1000px">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="TitleRutaExpediente">Escriba la nueva ruta donde se guardará el expediente digital</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
						<div class="form-group col-10">
						<label for="rutaValue">Ruta</label>
						<input type="text" class="form-control" id="rutaValue" name="value" aria-describedby="rutaValueHelp" placeholder="assets/uploads" required>
						<small id="nombreHelp" class="form-text text-muted">Si la ruta ingresada no existe se creará automáticamente.</small>
					</div>
						<input type="hidden" class="form-control" name="key" value="" id="rutaKey">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn_guardarRutaExpediente" class="btn btn-primary">Guardar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
