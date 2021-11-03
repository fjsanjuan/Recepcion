<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-border">
                <thead>
                    <tr>
                        <th>No.&nbspQUEJA</th>
                        <th>DESCRIPCIÓN QUEJA</th>
                        <th>ANOTACIONES DEL TÉCNICO</th>
                        <th>APLICA GARANTÍA</th>
                        <th>ADICIONAL (ADD)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <select id="select_queja" name="select_queja" style="width:auto;" class="browser-default form-control">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <textarea name="textarea" rows="3" cols="40" id="queja" class="form-control" readonly></textarea>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <textarea name="anotaciones_tec" rows="3" cols="40" id="anotaciones_tec" class="form-control" ></textarea>
                            </div>
                        </td>
                        <td>
                            <div class="checkbox">
                                <input id="apl_grta" type="checkbox" name="apl_grta"  ><label for="apl_grta"><b></b></label>
                            </div>
                        </td>
                        <td>
                            <div class="checkbox">
                                <input id="apl_add" type="checkbox" name="apl_add" ><label for="apl_add"><b></b></label>
                            </div>
                        </td>
                        <td><i class="fa fa-plus fa-2x registrar_linea" style="color:green; cursor:pointer;" aria-hidden="true"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-border">
                <thead>
                    <tr>
                        <th style="width: 90px;">No. QUEJA</th>
                        <th>DESCRIPCIÓN QUEJA</th>
                        <th>Anotaciones</th>
                        <th>Aplica Garantía</th>
                        <th>Adicional (ADD)</th>
                        <th><i class="fas fa-edit"></i></th>
                        <th><i class="fa fa-times"></i></th>
                    </tr>
                </thead>
                <tbody id="quejas_diagnostico"></tbody>
            </table>
        </div>
    </div>
</div>