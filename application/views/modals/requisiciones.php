<div class="col-md-12">
            <tbody>
              <tr>
                  <td><b>No. REQUISICIÓN</b><input type="text" class="form-control" name="" id=""></td>
                  <td><b>FECHA REQUISICIÓN</b><input type="text" class="form-control" name="" id=""></td>
                  <td><b>FECHA RECEPCIÓN</b><input type="text" class="form-control" name="" id=""></td>
                  <td><b>No. 1863</b><input type="text" class="form-control" name="" id=""></td>
                  <td><b>TÉCNICO</b><input type="text" class="form-control" name="" id=""></td>
                </tr>
            </tbody>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-border text-center">
                        <thead>
                            <tr>
                                <th>CANT.</th>
                                <th>NO. PARTE</th>
                                <th>DESCRIPCIÓN DE LA PARTE</th>
                            </tr>
                        </thead>
                        <tbody class="lineas_refacciones">
                            <tr>
                            <td><input type="text" class="form-control" id="" name="cantidad{}" style="width: 50px;" /></td>
                            <td><input type="text" class="form-control" id="" name="numero{}" style="width: 100px;" /></td>
                            <td><input type="text" class="form-control" id="" name="descripcion{}" style="width: 400px;" /></td>
                            <td>
                            <i class="fa fa-plus fa-2x nueva_linea" style="color:green; cursor:pointer;" aria-hidden="true"></i>
                            </td>
                            <td>
                            <i class="fa fa-times fa-2x borra_linea" style="color:red; cursor:pointer;"></i>
                            </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-responsive">
                        <table class="table table-border text-center">
                            <tbody>
                                <tr>
                                    <td><input type="text"  class="form-control" name="" id="" style="width: 330px;" /><b>Nombre y Firma Resp. Refacc.</b>
									<div class="form-check" id="checkRefacc" >
									<input class="form-check-input" type="checkbox" id="refaccCheck1" >
									<label class="form-check-label" for="refaccCheck1">Firma</label>
									<button type="button" class="btn btn-outline-warning btn-sm" id="cancelar_refacc">X</button>
									</div>
									</td>
									<td><input type="text"  class="form-control" name="" id="" style="width: 330px;" /><b>Nombre y Firma Técnico</b>
									<div class="form-check" id="checkTecn" >
									<input class="form-check-input" type="checkbox" id="reciboCheck1">
									<label class="form-check-label" for="reciboCheck1">Firma</label>
									<button type="button" class="btn btn-outline-warning btn-sm" id="cancelar_recibo">X</button>
									</div>
									</td>
								
								</tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
