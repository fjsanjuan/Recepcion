<div class="row">
	<div class="col-sm-12">
		<div class="">
			<div class="btn btn-info btn-md float-left" id="camaracontainer">
				
				<!-- captura fotos sin accesar a galeria -->
				<input type="file" accept="image/*" capture="camera" id="cameraInput" name="imagen[]" 
				style="width: 150px;height:50px;opacity: 0;overflow: hidden;position: absolute;z-index: 100000;left:20px;top:5px; cursor: pointer;" 
				multiple>
				
				<!-- captura fotos y accesa a galeria -->
				<!-- <input type="file" accept="image/*;capture=camera" id="cameraInput" name="imagen[]" 
				style="width: 150px;height:50px;opacity: 0;overflow: hidden;position: absolute;z-index: 100000;left:20px;top:5px; cursor: pointer;" 
				multiple> -->

	            <span>Capturar Foto  <i class="fa fa-camera"></i></span>
	        </div>
	        <span class="nav-link">Los archivos no deben pesar mas de 10 MB cada uno o 30 MB en conjunto.</span>
        </div>
		<?php
            $attributes = array('id' => 'form_foto');
            echo form_open('',$attributes);
        ?>
       <!--  <input type="hidden" name="input_vista_previa" id="input_vista_previa"> -->
	</div>
	<br><br><br>
	<div class="col-sm-12">
		<h5 style="text-align: center;"><b>Vista Previa</b></h5>
		<!-- cambio para adjuntar m�s fotos -->
		<div style="width:100%; max-width:900px; height:130px; display:inline-block;float:left; overflow-x: scroll; overflow-y: hidden; white-space: nowrap;" class="coloca" id="pictures_orden_recepcion"></div>
		<img id="vista_previa" name="vista_previa" class="img-fluid" style="display: block; margin: 0 auto;">
	</div>
	<br><br>
	<div class="col-sm-12">
		<div class="md-form">
		    <i class="fa fa-edit prefix"></i>
		    <textarea type="text" id="foto_comentario" name="foto_comentario" class="md-textarea form-control" rows="1"></textarea>
		    <label for="form10">Escribir Comentario</label>
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
