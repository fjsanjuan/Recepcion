<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <button class="btn btn-outline btn-success down_f1816" title="Descargar documentación" style="z-index: 9999;"><i class="fa fa-file-pdf"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        	<div class="table-responsive">
        		<table class="table table-border text-center">
        			<thead>
        				<tr>
        					<th>Nombre</th>
        					<th>Tipo</th>
        					<th><i class="fa fa-eye"></i></th>
                            <?php if($this->session->userdata["logged_in"]["perfil"] == 7): ?>
                                <th><i class="fa fa-times"></i></th>
                            <?php endif; ?>
        				</tr>
        			</thead>
        			<tbody id="archivos_documentacion">
        				<tr><td colspan="3" class="text-center text-danger">No hay documentación adjunta.</td></tr>
        			</tbody>
        		</table>
        	</div>
        </div>
    </div>
</div>