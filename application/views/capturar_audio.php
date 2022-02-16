<div>
	<div class="col-sm-12">
		<div class="file-field">
			<div id="btn_audio" class="btn btn-info btn-md float-left">
	            <span id="btn_audioTitulo">Iniciar grabación  </span>
	            <i id="btn_audioIcono" class="fa fa-microphone" ></i>
	            <input type="file" accept="audio/*" id="audioInput" name="audios" 
				style="width: 150px;height:50px;opacity: 0;overflow: hidden;position: absolute;z-index: 100000;left:20px;top:5px; cursor: pointer;" 
				multiple>
				<span id="tiempo_grabado"></span>
	        </div>
        </div>
		<?php
            $attributes = array('id' => 'form_audio');
            echo form_open('',$attributes);
        ?>
	</div>
	<br><br><br>
	<div class="col-sm-12">
		<h5 style="text-align: center;"><b>Vista Previa</b></h5>
		<div id="audios_grabados"></div>
	</div>
	<span class="nav-link">Los archivos no deben pesar mas de 10 MB cada uno o 30 MB en conjunto.</span>
	<br><br>
		<?php
        	echo form_close();
    	?>
	<br>
	<div class="col-sm-12">
		<button class="btn btn-danger float-left" id="btn_borrarAudio">Borrar</button>
		<button class="btn btn-success float-right" id="btn_guardarAudio">Guardar</button>
	</div>
</div>
