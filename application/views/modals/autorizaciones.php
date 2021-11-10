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
                                <th>Cancelar</th>
        				</tr>
        			</thead>
        			<tbody id="hacer_autorizaciones">
        				<tr>
                            <td>Pregarantia</td>
                            <td>
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pregCheck1" disabled>
                            <label class="form-check-label" for="pregCheck1"></label>
                            </div>
                            </td>
                            <td>
                            <button type="button" class="btn btn-outline-success btn-sm" id="autor_preg">☑</button>
                            </td>
                            <td>
                            <button type="button" class="btn btn-outline-warning btn-sm" id="cancelar_preg">X</button>
                            </td>
                        </tr>
        				<tr id="lineAdicional">
                            <td>Adicional (ADD)</td>
                            <td>
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="addCheck1" disabled>
                            <label class="form-check-label" for="addCheck1"></label>
                            </div>
                            </td>
                            <td>
                            <button type="button" class="btn btn-outline-success btn-sm" id="autor_add">☑</button>
                            </td>
                            <td>
                            <button type="button" class="btn btn-outline-warning btn-sm" id="cancelar_add">X</button>
                            </td>
                        </tr>
        			</tbody>
        		</table>
        	</div>
        </div>
    </div>
</div>