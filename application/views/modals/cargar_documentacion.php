<input type="hidden" name="trae_signGrtia" id="trae_signGrtia">
<ul class="nav nav-pills nav-fill" role="tablist">
	<li class="nav-item" role="presentation">
		<a class="nav-link active"  id="adjuntosdoc-tab" data-toggle="tab" role="tab" aria-controls="adjuntosDoc" aria-selected="true" href="#adjuntosDoc">Archivos Adjuntos</a>
	</li>
	<li class="nav-item" role="presentation">
		<a class="nav-link" id="cargardoc-tab" data-toggle="tab" role="tab" aria-controls="cargarDoc" aria-selected="true" href="#cargarDoc">Cargar Documentación</a>
	</li>
	
</ul>
<div class="tab-content" id="cargardocContent">
		<div class="col-md-12 tab-pane fade" id="cargarDoc" role="tabpanel" aria-labelledby="cargardoc-tab">
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
			<span class="nav-link">Los archivos no deben pesar mas de 10 MB cada uno o 30 MB en conjunto.</span>
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
	    					<th><i class="fa fa-times text-danger"></i></th>
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
	<div class="col-md-12 tab-pane fade show active" id="adjuntosDoc" role="tabpanel" aria-labelledby="adjuntosdoc-tab">
		<?php $this->load->view('modals/archivos_adjuntos'); ?>
	</div>
</div>
