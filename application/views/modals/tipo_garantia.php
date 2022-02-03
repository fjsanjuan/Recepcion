<!-- modal para tipos de garantía-->
<div class="modal fade" id="tipoModal" tabindex="-1" aria-labelledby="tipoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 style="color: #4285f4;" class="modal-title" id="tipoModalLabel">Tipos de garantía</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php
					$attributes = array('id' => 'form_tipo');
					echo form_open('',$attributes);
				?>
					<div class="form-group">
						<label for="nombreTipo">Nombre</label>
						<input type="text" class="required write form-control" id="nombreTipo" name="nombre" aria-describedby="nombreHelpTipo" placeholder="Nombre tipo de garantía" required />
						<small id="nombreHelpTipo" class="form-text text-muted">Ingresa el nombre del tipo de garantía.</small>
					</div>
					<div class="form-group">
						<label for="descripcionTipo">Descripción</label>
						<textarea type="text" class="required write form-control" id="descripcionTipo" name="descripcion" aria-describedby="descripcionHelpTipo" placeholder="Descripción tipo de garantía" required />
						</textarea>
						<small id="descripcionHelpTipo" class="form-text text-muted">Describa el subtipo de garantía.</small>
					</div>
				<?php
					echo form_close();
				?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" id="btn_crearTipo">Crear</button> 
				<button type="button" class="btn btn-primary" id="btn_actualizarTipo">Actualizar</button> 
			</div>
		</div>
	</div>
</div>
