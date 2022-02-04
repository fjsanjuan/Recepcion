<!-- modal para subtipos de garantía-->
<div class="modal fade" id="subtipoModal" tabindex="-1" aria-labelledby="subtipoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 style="color: #4285f4;" class="modal-title" id="subtipoModalLabel">Subtipo de garantía</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php
					$attributes = array('id' => 'form_subtipo');
					echo form_open('',$attributes);
				?>
					<div class="form-group">
						<label for="nombreSubtipo">Nombre</label>
						<input type="text" class="form-control" id="nombreSubtipo" name="nombre" aria-describedby="nombreHelp" placeholder="Nombre tipo de garantía" required>
						<small id="nombreHelp" class="form-text text-muted">Ingresa el nombre del subtipo de garantía.</small>
					</div>
					<div class="form-group">
						<label for="descripcionSubtipo">Descripción</label>
						<textarea type="text" class="form-control" id="descripcionSubtipo" name="descripcion" aria-describedby="descripcionHelp" placeholder="Descripción tipo de garantía" required>
						</textarea>
						<small id="descripcionHelp" class="form-text text-muted">Describa el subtipo de garantía.</small>
					</div>
				<?php
					echo form_close();
				?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btn_crearSubtipo">Crear</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" id="btn_actualizarSubtipo">Actualizar</button> 
			</div>
		</div>
	</div>
</div>
