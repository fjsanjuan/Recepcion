<!-- modal para jefe de taller asignar tecnico encargado-->
<div class="modal fade" id="asignEncargadoModal" aria-labelledby="asignEncargadoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 style="color: #4285f4;" class="modal-title" id="asignEncargadoModalLabel">ASIGNAR TÉCNICO ENCARGADO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="col-md-12">
      	<form id="formAsignarEncargado">
	        <div class="table-responsive">
	            <table class="table table-bordered">
	                <thead>
	                    <tr>
	                        <th>Técnico</th>
	                        <td>
	                        <div class="form-group col-md-8">
	                            <label for="asigna_encargado" class="grey-text">Nombre</label>
	                            <select id="asigna_encargado" name="asigna_encargado" class="browser-default form-control validate[required]" required>
	                            <option value="">seleccione un técnico...</option>
	                            </select>
	                        </div>
	                        </td>
	                    </tr>
	                </thead>
	            </table>
	        </div>
	    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_asignarEncargado">Asignar</button>
      </div>
    </div>
  </div>
</div>
