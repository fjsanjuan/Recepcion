<style>
    #firma, #firma2 {
        border: 2px dotted black;
        background-color: #fff;
        width: 400px;
        height: 200px;
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
</style>
<div>
    <div class="col-sm-12" id="crear_firma">
        <div id="contenido">
            <?php
                $attributes = array('id' => 'formFirma');
                echo form_open('',$attributes);
            ?>
            <div class="row">
                <div class="col-12">
                    <h6><b>Por favor, escriba su firma en los siguientes espacios:</b></h6>
                </div>
                <div class="col-12 col-sm-6 col-md-6">
                    <h6>Formato Profeco</h6>
                    <input type="hidden" name="valor_firma" id="valor_firma">
                    <div id="firma">
                    
                    </div>
                    <br>
                    <button class="btn btn-info" id="btn_borrarFirma">Borrar Firma</button>
                    <!-- <button class="btn btn-success" id="btn_guardarFirma">Guardar Firma</button> -->
                </div>
                <div class="col-12 col-sm-6 col-md-6">
                    <h6>Formato de Inventario</h6>
                    <input type="hidden" name="valor_firma2" id="valor_firma2">
                    <div id="firma2">
                    
                    </div>
                    <br>
                    <button class="btn btn-info" id="btn_borrarFirma2">Borrar Firma</button>
                    <button class="btn btn-success" id="btn_guardarFirma">Guardar Firmas</button>
                </div>            
            </div>
            <?php
                echo form_close();
            ?>
        </div>
        <div id="scrollgrabber"></div>
    </div>
</div>