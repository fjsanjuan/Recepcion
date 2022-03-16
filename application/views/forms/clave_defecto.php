<!-- modal para Claves de Defecto-->
<div class="modal fade" id="claveModal" tabindex="-1" aria-labelledby="claveModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 style="color: #4285f4;" class="modal-title" id="claveModalLabel">Clave de Defecto</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="!#" id='form_clave'>
					<div class="form-group">
						<label for="clave">Clave</label>
						<input type="text" class="required write form-control" id="nombreClave" name="clave" aria-describedby="claveHelpClave" placeholder="Clave de defecto" required maxlength="2" minlength="2" />
						<small id="claveHelpClave" class="form-text text-muted">Ingresa la clave de defecto.</small>
					</div>
					<div class="form-group">
						<label for="descripcionClave">Descripción</label>
						<textarea type="text" class="form-control" id="descripcionClave" name="descripcion" aria-describedby="descripcionHelpClave" placeholder="Descripción Clave de defecto" required />
						</textarea>
						<small id="descripcionHelpClave" class="form-text text-muted">Describa la Clave de Defecto.</small>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btn_crearClave">Crear</button> 
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" id="btn_actualizarClave">Actualizar</button> 
			</div>
		</div>
	</div>
</div>
