<style>
    #firma, #firma2 , #firma3 {
        border: 2px dotted black;
        background-color: #fff;
        width: 425px;
        height: 210px;
    }

    html.touch #contenido {
        float:left;
        width:100%;
    }

    html.touch #scrollgrabber {
        float:right;
        width:4%;
        margin-right:2%;
        background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAFCAAAAACh79lDAAAAAXNSR0IArs4c6QAAABJJREFUCB1jmMmQxjCT4T/DfwAPLgOXlrt3IwAAAABJRU5ErkJggg==)
    }
    html.borderradius #scrollgrabber {
        border-radius: 1em;
    }

    .btn-success {
        padding: 13px;
    }
    #ver_termCond{
        color: #ff3547; 
        font-weight: bold
    }
</style>
<div>
    <div class="col-sm-12" id="crear_firma">
        <div id="contenido">
            <?php
                $attributes = array('id' => 'formFirma');
                echo form_open('',$attributes);
            ?>

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-fProfeco-tab" data-toggle="pill" href="#pills-fProfeco" role="tab" aria-controls="pills-fProfeco" aria-selected="true" style="font-weight: bold;">Formato profeco</a>
                </li>
                <li class="nav-item">
                   <!--  el nav de la carta será visible unicamente  para FORD -->
                    <a class="nav-link" id="pills-fExtGarantia-tab" data-toggle="pill" href="#pills-fExtGarantia" role="tab" aria-controls="pills-fExtGarantia" aria-selected="false" style="font-weight: bold;">Carta de renuncia a beneficios <!-- (extensión de garantía) --></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-fInventario-tab" data-toggle="pill" href="#pills-fInventario" role="tab" aria-controls="pills-fInventario" aria-selected="false" style="font-weight: bold;">Formato inventario</a>
                </li>
            </ul>

            <div class="col-12">
                <h6><b>Por favor, escriba su firma en los siguientes espacios:</b></h6>
            </div>



                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-fProfeco" role="tabpanel" aria-labelledby="pills-fProfeco-tab">
                        <!--  <h6>Formato Profeco</h6> -->
                        <div class="row"> 
                            <div class="col-sm-1" >
                                <!-- <button class="btn btn-success" id="btn_guardarFirma">Guardar Firma</button> -->
                            </div>

                            <div class="col-sm-8">
                                <input type="hidden" name="valor_firma" id="valor_firma">
                                <div id="firma"></div>
                                <!-- <button class="btn btn-success" id="btn_guardarFirma">Guardar Firma</button> -->
                            </div>
                            
                            <div class="col-sm-3">
                                <button class="btn btn-danger" id="btn_borrarFirma"><i class="fa fa-eraser"></i></button>
                            </div>
                        </div>
                        <br/>
                        <div class="form-check-inline">
                            <input type="checkbox" class="form-check-input check-tablaDanios" name="cb_termCond" id="cb_termCond">
                            <label class="form-check-label" for="cb_termCond">
                                <h6>
                                    <b> 
                                        Acepto Términos y Condiciones del Contrato de Adhesión. 
                                        <i  id="ver_termCond" >
                                            <i class="far fa-file-pdf"></i> <u>Ver</u>  
                                        </i>
                                    </b>
                                </h6>
                            </label>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="pills-fExtGarantia" role="tabpanel" aria-labelledby="pills-fExtGarantia-tab">
                            <div class="row">
                                <div class="col-sm-1" >
                                    
                                </div>

                                <div class="col-sm-8">
                                    <input type="hidden" name="valor_firma3" id="valor_firma3">
                                    <div id="firma3"></div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <button class="btn btn-danger" id="btn_borrarFirma3"><i class="fa fa-eraser"></i></button>
                                </div>
                            </div>
                            <br/>
                            <h6 style="color: #ff3547; font-weight: bold;">&nbsp; * <b>Firmar solo si el cliente ha rechazado la extensión de garantía.</b></h6>     
                    </div>
                    <div class="tab-pane fade" id="pills-fInventario" role="tabpanel" aria-labelledby="pills-fInventario-tab">
                        <!-- <h6>Formato de Inventario</h6> -->
                        <div class="row">
                            <div class="col-sm-1" >
                                
                            </div>

                            <div class="col-sm-8">
                                <input type="hidden" name="valor_firma2" id="valor_firma2">
                                <div id="firma2"></div>
                            </div>

                            <div class="col-sm-3">
                                <button class="btn btn-danger" id="btn_borrarFirma2"><i class="fa fa-eraser"></i></button>
                                <button class="btn btn-success" id="btn_guardarFirma" disabled>Guardar Firmas</button>
                            </div>

                        </div>

                    </div>
                </div>
                      
            <?php
                echo form_close();
            ?>
        </div>

       



        <div id="scrollgrabber"></div>
    </div>






</div>