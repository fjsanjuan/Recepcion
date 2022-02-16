<div>
	<div class="col-sm-12">
		<div class="file-field">
			<div class="btn btn-info btn-md float-left">
	            <span>Cargar Oasis  <i class="fa fa-file-pdf" ></i></span>
	            <input type="file" accept="application/pdf" id="oasisInput" name="oasis_pdf" 
				style="width: 150px;height:50px;opacity: 0;overflow: hidden;position: absolute;z-index: 100000;left:20px;top:5px; cursor: pointer;" 
				>
	        </div>
	        <span class="nav-link">Los archivos no deben pesar mas de 10 MB cada uno o 30 MB en conjunto.</span>
        </div>
		<?php
            $attributes = array('id' => 'form_oasis');
            echo form_open('',$attributes);
        ?>
        <input type="hidden" name="input_vista_previa_pdf" id="input_vista_previa_pdf">
	</div>
	<br><br><br>
	<div class="col-sm-12">
		<h5 style="text-align: center;"><b>Vista Previa</b></h5>
		<div class="embed-responsive embed-responsive-16by9 hidden" id="oasis-embed" style="height: 350px; overflow-y: hidden;">
			<iframe class="embed-responsive-item" src="" frameborder="0" id="vista_previa_pdf" allowfullscreen></iframe>
		</div>
	</div>
	<br><br>
		<?php
        	echo form_close();
    	?>
	<br>
	<div class="col-sm-12">
		<button class="btn btn-danger float-left" id="btn_borrarOasis">Borrar</button>
		<button class="btn btn-success float-right" id="btn_guardarOasis">Guardar</button>
	</div>
</div>
