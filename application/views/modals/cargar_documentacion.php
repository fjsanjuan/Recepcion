<div>
	<div class="col-sm-12 col-lg-6">
		<input type="radio" id="PDF" name="tipo_archivo" value="PDF"checked>
		<label for="PDF">PDF</label>
		<input type="radio" id="Audio" name="tipo_archivo" value="Audio">
		<label for="Audio">Audio</label>
	</div>
	<div class="col-sm-12 col-lg-6">
		<div class="file-field">
			<div class="btn btn-info btn-md float-left">
	            <span>Cargar archivo  <i class="fa fa-file" ></i></span>
	            <input type="file" accept="application/pdf, audio/mp3" id="cargar_doc" name="cargar_doc" 
				style="width: 150px;height:50px;opacity: 0;overflow: hidden;position: absolute;z-index: 100000;left:20px;top:5px; cursor: pointer;" 
				>
	        </div>
        </div>
		
	</div>
	<br><br><br>
	<?php
            $attributes = array('id' => 'form_documentacion');
            echo form_open('',$attributes);
        ?>
        <input type="hidden" name="id_orden_servicio_doc" id="id_orden_servicio_doc">
	<div class="col-sm-12">
		<div class="table-responsive">
    		<table class="table table-border text-center">
    			<thead>
    				<tr>
    					<th>Nombre</th>
    					<th>Tipo</th>
    				</tr>
    			</thead>
    			<tbody id="archivos_adjuntos_doc">
    			</tbody>
    		</table>
    	</div>
	</div>
	<br><br>
		<?php
        	echo form_close();
    	?>
	<br>
	<div class="col-sm-12">
		<button class="btn btn-danger float-left" id="btn_borrar_doc"><i class="fa fa-times"></i> Borrar</button>
		<button class="btn btn-success float-right" id="btn_guardar_doc"><i class="fa fa-file-upload"></i> Guardar</button>
	</div>
</div>