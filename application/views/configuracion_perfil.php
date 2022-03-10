<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/multi-select.css">
<link rel="stylesheet" href="<?=base_url()?>assets/librerias/fontawesome-free-5.2.0-web/css/all.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/librerias/roundslider/roundslider.css">       

<script src="<?=base_url()?>assets/js/jquery.multi-select.js"></script>
<style>
    .links a {
        padding-left: 10px;
        margin-left: 10px;
        border-left: 1px solid #000;
        text-decoration: none;
        color: #999;
    }
    .links a:first-child {
        padding-left: 0;
        margin-left: 0;
         border-left: none;
    }
    .links a:hover {text-decoration: underline;}

    a[href="<?=site_url('user/configurar_perfil')?>"]{
        display: none;
    }

    #div_firma_usu {
        border: 2px dotted black;
        background-color: #fff;
        width: 100%;
        height: 200px;
    }

    html.touch #contenido-firma {
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

    #formConfigUsu{
        width: 100%;
    }

    /* 
      ##Device = Laptops, Desktops
      ##Screen = B/w 1025px to 1280px
    */
    @media (min-width: 1025px) and (max-width: 1280px) {
      
        .jSignature, #div_firma_usu {
            width: 800px !important;
        }
      
    }

    /* 
      ##Device = Tablets, Ipads (portrait)
      ##Screen = B/w 768px to 1024px
    */
    @media (min-width: 768px) and (max-width: 1024px) {

        .jSignature, #div_firma_usu {
            width: 500px !important;
        }
      
    }

    /* 
      ##Device = Tablets, Ipads (landscape)
      ##Screen = B/w 768px to 1024px
    */
    @media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
      
        .jSignature, #div_firma_usu {
            width: 700px !important;
        }
    }

    /* 
      ##Device = Low Resolution Tablets, Mobiles (Landscape)
      ##Screen = B/w 481px to 767px
    */
    @media (min-width: 481px) and (max-width: 767px) {

        .jSignature, #div_firma_usu {
            width: 500px !important;
        }
    }

    /* 
      ##Device = Most of the Smartphones Mobiles (Portrait)
      ##Screen = B/w 320px to 479px
    */
    @media (min-width: 320px) and (max-width: 480px) {
      
        .jSignature, #div_firma_usu {
            width: 380px !important;
        }
      
    }
</style>
<script>
$(document).ready(function(){
    var firma = "";
    var signature = "<?=$firma_electronica?>";
      
    // var config = {
    //     autoInit : true,       // Update any forms field with signature when loading the page
    //     format : "image/png",  // Default signature image format
    //     background : "#EEE",   // Default signature background
    //     pen : "#000",          // Default signature pen color
    //     penWidth : 1,          // Default signature pen width
    //     border : "#AAA",       // Default signature pen border color
    //     height : 200           // Default signature height in px
    // };

    var config = {
        autoFit : true,       // Update any forms field with signature when loading the page
        // format : "image/png",  // Default signature image format
        background : "#EEE",   // Default signature background
        lineColor : "#000",          // Default signature pen color
        lineWidth : 1,          // Default signature pen width
        border : "#AAA",       // Default signature pen border color
        height : 200           // Default signature height in px
    };

    // firma = $("#firma").jqSignature(config);
    firma = $("#div_firma_usu").jqSignature(config);

    // firma = $("#div_firma_usu").jSignature(config);
    
    /*Mostrar la firma configurada*/
    // if(signature != "")
    // {
    //     firma.jqSignature("reset");
    //     firma.jqSignature("setData", signature);
    // }

    /*Borrar canvas*/
    $("#btn_borrarFirmaUsu").on("click", function(e){
        e.preventDefault();

        $("#div_firma_usu").jqSignature("clearCanvas");
        $("#firma_usu").val("");
    });

    function validar_firma(firma)
    {
        var valida = true;
        var firma_vacia = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAyAAAADICAYAAAAQj4UaAAANEklEQVR4Xu3ZwVEkUQwFwcYo1p2xbdwBp9YEbhWCl5wnQr9TulTw8fgjQIAAAQIECBAgQIBAJPARzTGGAAECBAgQIECAAAECjwBxBAQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApmAAMmoDSJAgAABAgQIECBAQIC4AQIECBAgQIAAAQIEMgEBklEbRIAAAQIECBAgQICAAHEDBAgQIECAAAECBAhkAgIkozaIAAECBAgQIECAAAEB4gYIECBAgAABAgQIEMgEBEhGbRABAgQIECBAgAABAgLEDRAgQIAAAQIECBAgkAkIkIzaIAIECBAgQIAAAQIEBIgbIECAAAECBAgQIEAgExAgGbVBBAgQIECAAAECBAgIEDdAgAABAgQIECBAgEAmIEAyaoMIECBAgAABAgQIEBAgboAAAQIECBAgQIAAgUxAgGTUBhEgQIAAAQIECBAgIEDcAAECBAgQIECAAAECmYAAyagNIkCAAAECBAgQIEBAgLgBAgQIECBAgAABAgQyAQGSURtEgAABAgQIECBAgIAAcQMECBAgQIAAAQIECGQCAiSjNogAAQIECBAgQIAAAQHiBggQIECAAAECBAgQyAQESEZtEAECBAgQIECAAAECAsQNECBAgAABAgQIECCQCQiQjNogAgQIECBAgAABAgQEiBsgQIAAAQIECBAgQCATECAZtUEECBAgQIAAAQIECAgQN0CAAAECBAgQIECAQCYgQDJqgwgQIECAAAECBAgQECBugAABAgQIECBAgACBTECAZNQGESBAgAABAgQIECAgQNwAAQIECBAgQIAAAQKZgADJqA0iQIAAAQIECBAgQECAuAECBAgQIECAAAECBDIBAZJRG0SAAAECBAgQIECAgABxAwQIECBAgAABAgQIZAICJKM2iAABAgQIECBAgAABAeIGCBAgQIAAAQIECBDIBARIRm0QAQIECBAgQIAAAQICxA0QIECAAAECBAgQIJAJCJCM2iACBAgQIECAAAECBASIGyBAgAABAgQIECBAIBMQIBm1QQQIECBAgAABAgQICBA3QIAAAQIECBAgQIBAJiBAMmqDCBAgQIAAAQIECBAQIG6AAAECBAgQIECAAIFMQIBk1AYRIECAAAECBAgQICBA3AABAgQIECBAgAABApnAVIC8Xq+v53k+M12DCBAgQIAAAQIECPws8P1+v//9/LO/8QsB8jf26CsIECBAgAABAgR+r4AA+b2783ICBAgQIECAAAECBC4LTP0H5PIivI0AAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARAQFyZBGeQYAAAQIECBAgQGBBQIAsbNk3EiBAgAABAgQIEDgiIECOLMIzCBAgQIAAAQIECCwICJCFLftGAgQIECBAgAABAkcEBMiRRXgGAQIECBAgQIAAgQUBAbKwZd9IgAABAgQIECBA4IiAADmyCM8gQIAAAQIECBAgsCAgQBa27BsJECBAgAABAgQIHBEQIEcW4RkECBAgQIAAAQIEFgQEyMKWfSMBAgQIECBAgACBIwIC5MgiPIMAAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARAQFyZBGeQYAAAQIECBAgQGBBQIAsbNk3EiBAgAABAgQIEDgiIECOLMIzCBAgQIAAAQIECCwICJCFLftGAgQIECBAgAABAkcEBMiRRXgGAQIECBAgQIAAgQUBAbKwZd9IgAABAgQIECBA4IiAADmyCM8gQIAAAQIECBAgsCAgQBa27BsJECBAgAABAgQIHBEQIEcW4RkECBAgQIAAAQIEFgQEyMKWfSMBAgQIECBAgACBIwIC5MgiPIMAAQIECBAgQIDAgoAAWdiybyRAgAABAgQIECBwRECAHFmEZxAgQIAAAQIECBBYEBAgC1v2jQQIECBAgAABAgSOCAiQI4vwDAIECBAgQIAAAQILAgJkYcu+kQABAgQIECBAgMARgf8OegrJcwoE6QAAAABJRU5ErkJggg==";

        if(firma === firma_vacia)
        {
            toastr.error("Es necesario configurar su firma, favor de escribirla.");
            valida = false;
        }

        return valida;
    }

    function validar_password(password)
    {
        var valido = true;

        if(password.length < 6 || password.length > 50)
        {
            toastr.error("La contraseña debe tener, mínimo, 6 caracteres");
            valido = false;
        }

        return valido;
    }

    $("#pass_usu").on("focusout", function(){
        var pass = $(this).val();
        var valido = validar_password(pass);
    });

    //Ford Star validación
    function validar_fordStar(fordStar)
    {
        var validar;
        if(fordStar.length <= 8 || fordStar.length >= 10)
        {
            toastr.error("El Ford Star, debe contener 9 caracteres")
            validar = false;
        }
        else if(fordStar.length === 9)
            {
                toastr.info("Ford Star es correcto");
                validar = true;
            }
        return validar;
    }

    //Ford Star
    $("#cve_fordStar").on("focusout" , function(){
        var star = $(this).val();
        var validar = validar_fordStar(star);
    })

    /*Guardar cambios*/
    $("#btn_guardarConfUsu").on("click", function(e){
        e.preventDefault();
        var form = "";
        var password = $("#pass_usu").val();
        var firma_ok = validar_firma(firma.jqSignature("getDataURL"));
        var fordStar = $("#cve_fordStar").val();
        
        if(password != "")
        {
            var valido = validar_password(password);

            if(valido == false)
            {
                return;
            }
        }

        if(firma_ok == false)
        {
            return;
        }
        //Ford Star
        if(id_perfil == 5)
        {
            var validar = validar_fordStar(fordStar);

            if(validar == false)
            {
                return;
            }
        }

        $("#firma_usu").val(firma.jqSignature("getDataURL"));
        form = $("#formConfigUsu").serialize();
        
        $.ajax({
            cache: false,
            url: base_url+ "index.php/user/guardar_configPerfil/",
            type: 'POST',
            dataType: 'json',
            data: form
        })
        .done(function(data) {
            if(data)
            {
                $("#pass_usu").val("");
                $("#firma_cliente").attr("src","");
                $("#firma_cliente").attr("src",firma.jqSignature("getDataURL"));

                toastr.success("Se han actualizado los datos");
            }else 
            {
                toastr.error("Hubo un error en la actualización de los datos");
            }
        })
        .fail(function() {
            alert("Hubo un error al actualizar los datos");
        });
    });
});
</script>
<div class="container">
    <br>
    <div class="row">
        <div class="col-sm-12">
            <blockquote class="blockquote bq-primary htext"><b>INFORMACIÓN Y CONFIGURACIÓN DEL PERFIL</b></blockquote>
        </div>
    </div>
    <br>
    <div class="row">
        <?php
            $attributes = array('id' => 'formConfigUsu');
            echo form_open('',$attributes);
        ?>
        <div class="col-sm-12">
            <div class="row">                           <!-- Nombre -->
                <div class="col-sm-2">
                    <i class="fa fa-user iconos-usuario"></i>
                    &nbsp;
                    <label for="nombre_usu">Nombre:</label>
                </div>
                <div class="col-sm-10">
                    <input type="text" name="nombre_usu" id="nombre_usu" class="form-control input-usuario" value="<?=$nombre?>">
                </div>
            </div>
            <div class="row">                           <!-- Apellidos -->
                <div class="col-sm-2">
                    <i class="fa fa-user-friends iconos-usuario"></i>
                    &nbsp;
                    <label for="apellidos_usu">Apellidos:</label>
                </div>
                <div class="col-sm-10">
                    <input type="text" name="apellidos_usu" id="apellidos_usu" class="form-control input-usuario" value="<?=$apellidos?>">
                </div>
            </div>
            <div class="row">                           <!-- Contraseña -->
                <div class="col-sm-2">
                    <i class="fa fa-lock iconos-usuario"></i>
                    &nbsp;
                    <label for="email_usu">Contraseña:</label>
                </div>
                <div class="col-sm-10">
                    <input type="text" name="pass_usu" id="pass_usu" class="form-control input-usuario" placeholder="******">
                </div>
            </div>
            <input type="hidden" name="firma_usu" id="firma_usu">
            <?php
                echo form_close();
            ?>
            <div class="row">                           <!-- Email -->
                <div class="col-sm-2">
                    <i class="fa fa-at iconos-usuario"></i>
                    &nbsp;
                    <label for="email_usu">E-mail:</label>
                </div>
                <div class="col-sm-10">
                    <input type="text" name="email_usu" id="email_usu" class="form-control input-usuario" readonly value="<?=$email?>">
                </div>
            </div>
            <div class="row">                           <!-- Perfil -->
                <div class="col-sm-2">
                    <i class="fa fa-address-card iconos-usuario"></i>
                    &nbsp;
                    <label for="perfil_usu">Perfil:</label>
                </div>
                <div class="col-sm-10">
                    <input type="text" name="perfil_usu" id="perfil_usu" class="form-control input-usuario" readonly value="<?=$perfil?>">
                </div>
            </div>
            <div class="row">                           <!-- Clave Intelisis -->
                <div class="col-sm-2">
                    <i class="fa fa-key iconos-usuario"></i>
                    &nbsp;
                    <label for="cve_usu">Clave Intelisis:</label>
                </div>
                <div class="col-sm-10">
                    <input type="text" name="cve_usu" id="cve_usu" class="form-control input-usuario" readonly value="<?=$cve_intelisis?>">
                </div>
            </div>
            <?php if($this->session->userdata["logged_in"]["perfil"] == 5):?>
            <div class="row" id="fordStar">                       
                <div class="col-sm-2">
                    <i class="fa fa-key iconos-usuario"></i>
                    &nbsp;
                    <label for="cve_fordstar">Ford Star:</label>
                </div>
                <div class="col-sm-10">
                    <input type="text" name="cve_fordStar" id="cve_fordStar" class="form-control input-usuario" value="<?=$fordStar;?>" placeholder="Ford Star del Técnico">
                </div>
            </div>
            <?php endif;?>
            <br>
            <div class="row">
                <div class="col-sm-2">
                    <label for="">Firma configurada</label>
                </div>
                <div class="col-sm-10">
                    <img class="firma_cliente" id="firma_cliente" src="<?=$firma_electronica?>" style="width: 50%;">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                    <p style="font-size: 12px;"><b>NOTA: Por favor, escriba su firma sin salirse del área especificada.</b></p>
                </div>
            </div>
            <div class="row contenido-firma">                           <!-- Firma -->
                <div class="col-sm-2">
                    <i class="fa fa-signature iconos-usuario"></i>
                    &nbsp;
                    <label for="cve_usu">Firma:</label>
                </div>
                <div class="col-sm-9">
                    <div id="div_firma_usu">
                        
                    </div>
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-danger" id="btn_borrarFirmaUsu"><i class="fa fa-eraser"></i></button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12">
                    <button class="btn btn-success waves-effect waves-light" id="btn_guardarConfUsu">Guardar Cambios</button>
                </div>
            </div>
            <br>
        </div>
    </div>
</div>
