<div class="container">
    <div class="row">
        <div class="col-sm-12">
        	<div class="table-responsive">
        		<table class="table table-border text-center">
        			<thead>
        				<tr>
        					<th>Nombre</th>
        					<th>Autorizado</th>
        					<th>Autorizar y Firmar</th>
                            <?php if($this->session->userdata["logged_in"]["perfil"] == 7): ?>
                                <th><i class="fa fa-times"></i></th>
                            <?php endif; ?>
        				</tr>
        			</thead>
        			<tbody id="hacer_autorizaciones">
        				<tr>
                            <td>Pregarantia</td>
                            <td>
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pregCheck1">
                            <label class="form-check-label" for="pregCheck1"></label>
                            </div>
                            </td>
                            <td>
                            <button type="button" class="btn btn-success" id="autor_preg">Autorizar</button>
                            </td>
                        </tr>
        				<tr>
                            <td>Adicional (ADD)</td>
                            <td>
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="addCheck1">
                            <label class="form-check-label" for="addCheck1"></label>
                            </div>
                            </td>
                            <td>
                            <button type="button" class="btn btn-success" id="autor_add">Autorizar</button>
                            </td>
                        </tr>
        			</tbody>
        		</table>
        	</div>
        </div>
    </div>
</div>