<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.dynameter.css">
<script src="<?=base_url()?>assets/js/jquery.dynameter.js"></script>
<script src="http://bernardo-castilho.github.io/DragDropTouch/DragDropTouch.js"></script>

<script src="https://superal.github.io/canvas2image/canvas2image.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="text-center font-bold pt-4 pb-5 mb-5"><strong>Inspección de Vehículo</strong></h2>
      <!-- Stepper -->
      <div class="steps-form-2">
          <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">
              <div class="steps-step-2">
                  <a href="#step-1" type="button" class="btn btn-amber btn-circle-2 waves-effect ml-0" data-toggle="tooltip" data-placement="top" title="Inspeccion Visual"><i class="fa fa-eye" aria-hidden="true"></i></a>
              </div>
              <div class="steps-step-2">
                  <a href="#step-2" type="button" class="btn btn-blue-grey btn-circle-2 waves-effect" data-toggle="tooltip" data-placement="top" title="Personal Data"><i class="fa fa-car" aria-hidden="true"></i></a>
              </div>
              <div class="steps-step-2">
                  <a href="#step-3" type="button" class="btn btn-blue-grey btn-circle-2 waves-effect" data-toggle="tooltip" data-placement="top" title="Terms and Conditions"><i class="fa fa-photo" aria-hidden="true"></i></a>
              </div>
              <div class="steps-step-2">
                  <a href="#step-4" type="button" class="btn btn-blue-grey btn-circle-2 waves-effect mr-0" data-toggle="tooltip" data-placement="top" title="Finish"><i class="fa fa-check" aria-hidden="true"></i></a>
              </div>
          </div>
      </div>
      <!-- First Step -->
      <form role="form" action="" method="post">
          <div class="row setup-content-2" id="step-1">
            <div class="col-md-12">
              <!--<blockquote class="blockquote bq-primary htext">Inspeccion Visual e Inventario en Recepción</blockquote> -->
              <br>
              <div class="row">
                <div class="col-6">
                  <div class="table-responsive">
                    <table class="table">
                        <blockquote class="blockquote bq-primary htext">Cajuela</blockquote>
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="herramienta">
                              <label class="form-check-label" for="herramienta">Herramienta</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="gatollave">
                              <label class="form-check-label" for="gatollave">Gato/Llave</label>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="reflejantes">
                              <label class="form-check-label" for="reflejantes">Reflejantes</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="cables">
                              <label class="form-check-label" for="cables">Cables</label>
                            </div>
                          </td>
                        </tr>
                        <!-- -->
                        <tr>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="extintor">
                              <label class="form-check-label" for="extintor">Extintor</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="llantarefaccion" >
                              <label class="form-check-label" for="llantarefaccion">Llanta de refacción</label>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-6">
                  <div class="table-responsive">
                    <table class="table">
                        <blockquote class="blockquote bq-primary htext">Exteriores</blockquote>
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="taponesrueda">
                              <label class="form-check-label" for="taponesrueda">Tapones de Ruedas</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="gomalimpiador">
                              <label class="form-check-label" for="gomalimpiador">Gomas de Limpiadores</label>
                            </div>
                          </td>
                          <tr>
                            <td>
                              <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="antna">
                                <label class="form-check-label" for="antna">Antena</label>
                              </div>
                            </td>
                            <td>
                              <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="tapagas">
                                <label class="form-check-label" for="tapagas">Tapon de Gasolina</label>
                              </div>
                            </td>
                          </tr>
        
                        </tr>          
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-6">
                  <div class="table-responsive">
                    <table class="table">
                        <blockquote class="blockquote bq-primary htext">Documentación</blockquote>
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="polizamanual">
                              <label class="form-check-label" for="polizamanual">Poliza de Garantía/Manual Op.</label>
                            </div>
                          </td>
                          <td>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="segrines">
                              <label class="form-check-label" for="segrines">Seguro de Rines</label>
                            </div>
                          </td>
                          <tr>
                            <td>
                              <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="certverific">
                                <label class="form-check-label" for="certverific">Certificado de Verificación</label>
                              </div>
                            </td>
                            <td>
                              <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="tarjcirc">
                                <label class="form-check-label" for="tarjcirc">Tarjeta de Circulación</label>
                              </div>
                            </td>
                          </tr>     
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-6">
                    <blockquote class="blockquote bq-primary htext">Gasolina</blockquote>
                  <div class="form-check">
                    <div id="fuel-gauge"></div>
                    <br>
                    <div id="fuel-gauge-control" style="width:200px;"></div>
                  </div>
                </div>
                <div class="col">
                    <blockquote class="blockquote bq-primary htext">¿Deja artículos personales?</blockquote>
                  <!-- Material inline 1 -->
                  <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="materialInline1" name="inlineMaterialRadiosExample">
                    <label class="form-check-label" for="materialInline1">SI</label>
                  </div>
                  <!-- Material inline 2 -->
                  <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="materialInline2" name="inlineMaterialRadiosExample">
                    <label class="form-check-label" for="materialInline2">NO</label>
                  </div>
                  <div class="form-check">
                    <label for="">¿Cuáles?</label>
                    <input class="form-control" type="text" >
                  </div>
                </div>
              </div>

            </div>
          </div>
          <!-- Second Step -->
          <div class="row setup-content-2" id="step-2">
            <div class="col" style="text-align: center;">
              <strong>Leyenda</strong>
              <button type="button" class="btn btn-sm btn-success">Verfificado y aprobado esta vez</button>
              <button type="button" class="btn btn-sm btn-yellow">Puede requerir atencion en el futuro</button>
              <button type="button" class="btn btn-sm btn-danger">Requiere atencion inmediata</button>
            </div>

            <div class="col-md-12">
              <blockquote class="blockquote bq-primary htext">NIVELES DE FLUIDOS</blockquote>
              <div class="table-responsive">
                <table class="table">
                  <div>
                      <label for="">Pérdida de aceite o fluidos</label>
                        <!-- Material inline 1 -->
                        <div class="form-check form-check-inline">
                          <input type="radio" class="form-check-input" id="fluidossi" name="">
                          <label class="form-check-label" for="fluidossi">si</label>
                        </div>
                        <!-- Material inline 2 -->
                        <div class="form-check form-check-inline">
                          <input type="radio" class="form-check-input" id="fluidosno" name="">
                          <label class="form-check-label" for="fluidosno">no</label>
                        </div>
                  </div>
                  <tr>
                    <td>
                      <label for="">Aceite de Motor</label>
                      <div class="switch">
                        <label>
                              Llenar
                              <input type="checkbox">
                              <span class="lever success"></span>
                              Bien
                          </label>
                      </div>
                    </td>
                    <td>
                      <label for="">Dirección Hidraulica</label>
                      <div class="switch">
                        <label>
                              Llenar
                              <input type="checkbox">
                              <span class="lever"></span>
                              Bien
                          </label>
                      </div>
                    </td>
                    <td>
                      <label for="">Transmisión</label>
                      <div class="switch">
                        <label>
                              Llenar
                              <input type="checkbox">
                              <span class="lever"></span>
                              Bien
                          </label>
                      </div>
                    </td>
                    <td>
                      <label for="">Limpiaparabrisas</label>
                      <div class="switch">
                        <label>
                              Llenar
                              <input type="checkbox">
                              <span class="lever"></span>
                              Bien
                          </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="">Deposito de Fluido de Freno</label>
                      <div class="switch">
                        <label>
                              Llenar
                              <input type="checkbox">
                              <span class="lever"></span>
                              Bien
                          </label>
                      </div>
                    </td>
                    <td>
                      <label for="">Deposito de recuperación refrigerante</label>
                      <div class="switch">
                        <label>
                              Llenar
                              <input type="checkbox">
                              <span class="lever"></span>
                              Bien
                          </label>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
              <blockquote class="blockquote bq-primary htext">PLUMAS LIMPIAPARABRISAS</blockquote>

              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <td>
                      <label for="">Prueba de limpiaparabrisas realizada</label>
                      <div class="switch  success-switch">
                        <label>
                              No
                              <input type="checkbox" id="checklel">
                              <span class="lever success"></span>
                              Si
                          </label>
                      </div>
                    </td>
                    <td>
                      <div class="form-inline">
                          <span>Plumas Limpiaparabrisas  </span>
                          <!-- Default checkbox -->
                          <div class="form-check mr-3 btn-success">
                              <input class="form-check-input plma " type="checkbox" id="inlineFormCheckbox1">
                              <label class="form-check-label" for="inlineFormCheckbox1" style="padding-right: 20px;">Verificado</label>
                          </div>
                          <!-- Filled-in checkbox -->
                          <div class="form-check mr-3 btn-danger">
                              <input type="checkbox" class="form-check-input plma" id="inlineFormCheckbox2" >
                              <label class="form-check-label" for="inlineFormCheckbox2" style="padding-right: 20px;">Requiere Atención</label>
                          </div>
                      </div>
                               
                    </td>
                  </tr>
                </table>
              </div>
               <blockquote class="blockquote bq-primary htext">DESGASTE DE NEUMATICO/FRENO</blockquote>
              <div class="table-responsive">
                <table class="table">
                  <tbody>
                  <tr>
                    <td>
                      <span>Profundidad del dibujo</span>
                    </td>
                    <td>
                        <div class="form-check form-check-inline btn-success">
                          <input type="radio" class="form-check-input" id="fluidossi" name="">
                          <label class="form-check-label" for="fluidossi" style="padding-right: 20px;">5 mm y mayor</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline btn-yellow">
                          <input type="radio" class="form-check-input" id="fluidossi" name="">
                          <label class="form-check-label" for="fluidossi" style="padding-right: 20px;">3 a 5 mm</label>
                        </div>
                    </td>
                    <td> 
                        <div class="form-check form-check-inline btn-danger">
                          <input type="radio" class="form-check-input" id="fluidossi" name="">
                          <label class="form-check-label" for="fluidossi" style="padding-right: 20px;">2 mm y menor</label>
                        </div>
                    </td>
                  </tr>
            
                  <tr>
                    <td><span>Medida de balatas</span></td>
                    <td>
                        <div class="form-check form-check-inline btn-success">
                          <input type="radio" class="form-check-input" id="fluidossi" name="">
                          <label class="form-check-label" for="fluidossi" style="padding-right: 20px;">Más de 8 mm</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline btn-yellow">
                          <input type="radio" class="form-check-input" id="fluidossi" name="">
                          <label class="form-check-label" for="fluidossi" style="padding-right: 20px;">4 a 6 mm</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline btn-danger">
                          <input type="radio" class="form-check-input" id="fluidossi" name="">
                          <label class="form-check-label" for="fluidossi" style="padding-right: 20px;"> 3 mm o menos</label>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td><span>Tambores</span></td>
                    <td>
                      <div class="form-check form-check-inline btn-success">
                        <input type="radio" class="form-check-input" id="fluidossi" name="">
                          <label class="form-check-label" for="fluidossi" style="padding-right: 20px;">Bien</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline btn-yellow">
                        <input type="radio" class="form-check-input" id="fluidossi" name="">
                          <label class="form-check-label" for="fluidossi" style="padding-right: 20px;">Requiere Atención</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline btn-danger">
                        <input type="radio" class="form-check-input" id="fluidossi" name="">
                          <label class="form-check-label" for="fluidossi" style="padding-right: 20px;">Requiere Reparación</label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><span>Discos</span></td>
                    <td>
                      <div class="form-check form-check-inline btn-success">
                        <input type="radio" class="form-check-input" id="fluidossi" name="">
                          <label class="form-check-label" for="fluidossi" style="padding-right: 20px;">Bien</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline btn-yellow">
                        <input type="radio" class="form-check-input" id="fluidossi" name="">
                          <label class="form-check-label" for="fluidossi" style="padding-right: 20px;">Requiere Atención</label>
                      </div>
                    </td>
                    <td>
                      <div class="form-check form-check-inline btn-danger">
                        <input type="radio" class="form-check-input" id="fluidossi" name="">
                          <label class="form-check-label" for="fluidossi" style="padding-right: 20px;">Requiere Reparación</label>
                      </div>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- Third Step -->
          <div class="row setup-content-2" id="step-3">
              <div class="col-md-12">
                  <h3 class="font-weight-bold pl-0 my-4"><strong>Registro de Daños</strong></h3>
                  <div class="col">
                    <div class="toolbar"><span>Arrastre...</span></div>
                    <div class="canvas" id="canvasid">
                      
                    </div>
                    <div id="img-out"></div>
                    <a class="btn btn-primary" id="saveCar">GUARDAR</a>
                  </div>
        
              </div>
          </div>
          <!-- Fourth Step -->
          <div class="row setup-content-2" id="step-4">
              <div class="col-md-12">
                  <h3 class="font-weight-bold pl-0 my-4"><strong>Finish</strong></h3>
                  <h2 class="text-center font-weight-bold my-4">Registration completed!</h2>
                  <button class="btn btn-mdb-color btn-rounded prevBtn-2 float-left" type="button">Previous</button>
                  <button class="btn btn-success btn-rounded float-right" type="submit">Submit</button>
              </div>
          </div>
      </form>
    </div>
  </div>
</div>
<br>
<br>  