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

<div class="container">
    <br>
    <div class="row">
        <div class="col-sm-12">
            <blockquote class="blockquote bq-primary htext"><b>SELF CHECK IN</b></blockquote>
        </div>
    </div>
    <br>
    
</div>
