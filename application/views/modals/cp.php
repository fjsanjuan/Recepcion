<!-- modal para revision las autorizaciones-->
<div class="modal fade" id="cpModal" tabindex="-1" aria-labelledby="cpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 style="color: #4285f4;" class="modal-title" id="cpModalLabel">FORMATO CARRO PARADO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
        	<div class="form-group col-6">
				<label for="unidadCp">Unidad</label>
				<input type="text" class="form-control-plaintext" id="unidadCp" name="unidadCp" placeholder="Unidad" readonly>
			</div>
        	<div class="form-group col-6">
				<label for="modeloCp">Modelo</label>
				<input type="text" class="form-control-plaintext" id="modeloCp" name="modeloCp" placeholder="Modelo" readonly>
			</div>
        </div>
        <div class="row">
        	<div class="form-group col-4">
				<label for="serieCp">No. Serie</label>
				<input type="text" class="form-control-plaintext" id="serieCp" name="serieCp" placeholder="Número serie" readonly>
			</div>
        	<div class="form-group col-4">
				<label for="ordenCp">No. Orden</label>
				<input type="text" class="form-control-plaintext" id="ordenCp" name="ordenCp" placeholder="Número Orden" readonly>
			</div>
        	<div class="form-group col-4">
				<label for="torreCp">Torre</label>
				<input type="text" class="form-control-plaintext" id="torreCp" name="torreCp" placeholder="Torre" readonly>
			</div>
        </div>
        <div class="row">
        	<div class="form-group col-12">
				<label for="asesorCp">Asesor</label>
				<input type="text" class="form-control-plaintext" id="asesorCp" name="asesorCp" placeholder="Nombre del Asesor" readonly>
			</div>
        </div>
        <br>
        <div class="table-responsive">
        	<table class="table table-border">
        		<thead>
        			<th>Cant.</th>
        			<th>No. Partes</th>
        			<th>Descripción</th>
        			<th>CEX/CIN/GAR</th>
        			<th>Firma Recibido</th>
        			<th>Observaciones</th>
        			<th class="addPiezaCp" style="cursor: pointer;"><i class="fa fa-plus text-success"></i></th>
        		</thead>
        		<tbody id="datosCp"></tbody>
        	</table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar</button> 
      </div>
    </div>
  </div>
</div>
