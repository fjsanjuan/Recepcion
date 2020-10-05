<div>
	<div class="col-sm-12">
		<div class="file-field">
			<div class="btn btn-info btn-md float-left">
	            <span>Capturar Audio  <i class="fa fa-microphone" ></i></span>
	            <input type="file" capture="camera" accept="image/*" id="cameraInput" name="imagen">
	        </div>
        </div>
		<?php
            $attributes = array('id' => 'form_foto');
            echo form_open('',$attributes);
        ?>
        <input type="hidden" name="input_vista_previa" id="input_vista_previa">
	</div>
	<br><br><br>
	<div class="col-sm-12">
		<h5 style="text-align: center;"><b>Vista Previa</b></h5>
		
	</div>
	<br><br>
	<div class="col-sm-12">
		<div class="md-form">
		    <i class="fa fa-edit prefix"></i>
		    <textarea type="text" id="foto_comentario" name="foto_comentario" class="md-textarea form-control" rows="1"></textarea>
		    <label for="form10">Escribir Comentarios adicionales</label>
		</div>
	</div>
		<?php
        	echo form_close();
    	?>
	<br>
	<div class="col-sm-12">
		<button class="btn btn-danger float-left" id="btn_borrarFoto">Borrar</button>
		<button class="btn btn-success float-right" id="btn_guardarFoto">Guardar</button>
	</div>
</div>