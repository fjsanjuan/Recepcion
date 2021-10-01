<div>
	<div class="col-sm-12">
		<div class="file-field">
			<div class="btn btn-info btn-md float-left">
	            <span>Cargar Oasis  <i class="fa fa-file-pdf" ></i></span>
	            <input type="file" accept="application/pdf" id="oasisInput" name="oasis_pdf" 
				style="width: 150px;height:50px;opacity: 0;overflow: hidden;position: absolute;z-index: 100000;left:20px;top:5px; cursor: pointer;" 
				multiple>
	        </div>
        </div>
		<?php
            $attributes = array('id' => 'form_oasis');
            echo form_open('',$attributes);
        ?>
        <input type="hidden" name="input_vista_previa_pdf" id="input_vista_previa_pdf">
	</div>
	<br><br><br><!-- 
	<div class="col-sm-12">
		<h5 style="text-align: center;"><b>Vista Previa</b></h5>
		
	</div>
	<br><br> -->
		<?php
        	echo form_close();
    	?>
	<br>
	<div class="col-sm-12">
		<button class="btn btn-danger float-left" id="btn_borrarOasis">Borrar</button>
		<button class="btn btn-success float-right" id="btn_guardarOasis">Guardar</button>
	</div>
</div>