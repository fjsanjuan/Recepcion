<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/130527/qrcode.js"></script>
<div class="container">
    <div style="padding-top: 30px;">
        <?php 
            $attributes = array('id' => 'update_cliente');
            echo form_open('',$attributes);
        ?>
        <input type="hidden" name="id_c" id="id_c" value="<?=$id?>">
        <input type="hidden" name="tipo_c" id="tipo_c" value="<?=$tipo?>">
        <p class="h4 text-center mb-4">Datos Actuales</p>

         <h5 class="bq-primary"><b style="padding-left: 10px;">ID: </b> <?=$id?></h5>

        <div class="row">
            <!-- Default input name -->
            <div class="col-md-6">
                <div class="md-"> 
                    <label for="nombre_cliente" class="grey-text">Nombre </label>
                    <input type="text" id="nombre_cliente" name="nombre_cliente" class="form-control" readonly="true" ondblclick="this.readOnly='';">
                </div>
                <div class="md-">
                    <label for="telefono_cliente" class="grey-text">Teléfono</label>
                    <input type="text" id="telefono_cliente" name="telefono_cliente" class="form-control" readonly="true" ondblclick="this.readOnly='';">
                </div>
                <div class="md-">
                    <label for="celular_cliente" class="grey-text">Celular</label>
                    <input type="text" id="celular_cliente" name="celular_cliente" class="form-control" readonly="true" ondblclick="this.readOnly='';">
                </div> 
                <div class="md-">
                    <label for="email_cliente" class="grey-text">Email</label>
                    <input type="email" id="email_cliente" name="email_cliente" class="form-control" readonly="true" ondblclick="this.readOnly='';">
                </div>
                <div class="md-">   
                    <label for="rfc_cliente" class="grey-text">RFC</label>
                    <input type="text" id="rfc_cliente" name="rfc_cliente" class="form-control" readonly="true" ondblclick="this.readOnly='';">
                </div>
                <div class="md-">
                    <label for="direc_cliente" class="grey-text">Direccion</label>
                    <input type="text" id="direc_cliente" name="direc_cliente" class="form-control" readonly="true" ondblclick="this.readOnly='';">
                </div>
            </div>  
            <div class="col-md-6"> 
                <div class="md-">
                    <label for="no_ext_cliente" class="grey-text">Número Ext</label>
                    <input type="text" id="no_ext_cliente" name="no_ext_cliente" class="form-control" readonly="true" ondblclick="this.readOnly='';">
                </div>
                <div class="md-">
                    <label for="no_int_cliente" class="grey-text">Número Int</label>
                    <input type="text" id="no_int_cliente" name="no_int_cliente" class="form-control" readonly="true" ondblclick="this.readOnly='';">
                </div>
                <div class="md-">
                    <label for="colonia_cliente" class="grey-text">Colonia</label>
                    <input type="text" id="colonia_cliente" name="colonia_cliente" class="form-control" readonly="true" ondblclick="this.readOnly='';">
                </div>
                <div class="md-">
                    <label for="poblacion_cliente" class="grey-text">Poblacion</label>
                    <input type="text" id="poblacion_cliente" name="poblacion_cliente" class="form-control" readonly="true" ondblclick="this.readOnly='';">
                </div>
                <div class="md-">
                    <label for="edo_cliente" class="grey-text">Estado</label>
                    <input type="text" id="edo_cliente" name="edo_cliente" class="form-control" readonly="true" ondblclick="this.readOnly='';">
                </div>
                <div class="md-">
                    <label for="cp_cliente" class="grey-text">Código Postal</label>
                    <input type="text" id="cp_cliente" name="cp_cliente" class="form-control" readonly="true" ondblclick="this.readOnly='';">
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <button class="btn btn-primary" style="float: right;"  id="btn_UpdateCli">Actualizar</button>
        </div> 
        <?php 
            echo form_close();
        ?>
        <h5 class="bq-primary"> <p style="padding-left: 10px;">Si necesita actualizar un campo haga doble clic sobre el</p></h5>

        <div class="qr-code-generator">

        <input type="hidden" class="qr-url" value="<?=$id?>">
        <input type="hidden" class="qr-size" value="85">

        <button class="generate-qr-code">Generar QR</button>

        <br>

        <div id="qrcode"></div>
        </div>
        <br>
    </div>     
 </div>