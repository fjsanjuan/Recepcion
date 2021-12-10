<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Formato</title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/pdfstyles/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
        <link rel="apple-touch-icon" href="<?php echo base_url();?>assets/pdfstyles/images/reporticon.png">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/pdfstyles/css/page.css">
        <link rel="icon" href="<?php echo base_url();?>assets/pdfstyles/images/reporticon.png" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/pdfstyles/css/multipuntos.css">
        <meta name="theme-color" content="#801515" />
        <meta name="description" content="Formato">
        <meta property="og:title" content="Seguimiento a tu vehiculo" />
        <meta property="og:url" content="http://isapi.intelisis-solutions.com/" />
        <meta property="og:description" content="Formato">
        <meta property="og:image" content="<?php echo base_url();?>assets/pdfstyles/images/reporticon.png">
        <style>
            /* The side navigation menu */
.sidebar {
  margin: 0;
  padding: 0;
  width: 300px;
  background-color: #f1f1f1;
  position: fixed;
  height: 100%;
  overflow: auto;
  margin-top: -20px;
  box-shadow: 3px 3px 3px #ddd;
}

/* Sidebar links */
.sidebar a , .sidebar div {
  display: block;
  color: black;
  padding: 16px;
  text-decoration: none;
}

/* Active/current link */
.sidebar a.active {
  background-color: #29b6f6;
  color: white;
}

/* Links on mouse-over */
.sidebar a:hover:not(.active) {
  background-color: #0288d1;
  color: white;
}

#myDIV {
    background-color: #f1f1f1;
    position:fixed;
    top:0;
    width:18%;
    z-index:100;
    left:82%;
    height: 100%;
    visibility: hidden;
    opacity: 0;
    transition: visibility 0s, opacity 0.5s linear;
    box-shadow: -3px 3px 3px #ddd;
    padding: 10px;
}
.code{
    background: #f4f4f4;
    border: 1px solid #ddd;
    border-left: 3px solid #f36d33;
    color: #666;
    page-break-inside: avoid;
    font-family: monospace;
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 1.6em;
    max-width: 100%;
    overflow: auto;
    padding: 1em 1.5em;
    display: block;
    word-wrap: break-word;
}
.requisito{
    background:#fff59d;
}

input {
    background-color: transparent;
    border: 0px solid;
}

input:focus{
    outline: none;
}

/* On screens that are less than 700px wide, make the sidebar into a topbar */
@media screen and (max-width: 1750px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .sidebar a , .sidebar div {float: left;}
  #myDIV {
    width:40%;
    left:60%;
  }
}

/* On screens that are less than 400px, display the bar vertically, instead of horizontally */
@media screen and (max-width: 500px) {
  .sidebar a , .sidebar div {
    text-align: center;
    float: none;
  }
  #myDIV {
    width:80%;
    left:20%;
  }
}

@media print {
    @page {size: landscape}
    .no_print {
        display: none !important;
        visibility: hidden;
        opacity: 0;
    }
    .requisito{
        background:none;
    }
}

        </style>
    </head>
    <body class="gray-bg" style="overflow-x: auto;" cz-shortcut-listen="true">
        <div class="sidebar">
            <a class="no_print" href="#home">Guardar</a>
            <a class="active no_print" href="#home" onclick="window.print();return false;">Imprimir</a>
            <!--<a href="#news">News</a>
            <a href="#contact">Contact</a>
            <a href="#about">About</a>-->
        </div>
        <div class="book">
            <div class="page" id="firstpage">
                <div id="page-wrapper">
                    <div id="principal">
                        <div class="row header-title-blue">
                            <div class=" bold">
                                Codigo de Diagnostico del Problema
                            </div>
                        </div>
                        <div id="top-section">
                            <div id="head">
                                <div id="left" class="header">
                                    <strong class="header-left-title sfont">(REP)Numero de reparación<br/>(NL) Luz indicadora de falla<br/>(DTC) Codigo de falla</strong>
                                </div>
                                <div id="center" class="header">
                                    
                                </div>
                                <div id="right" class="header">
                                    <div class="row content-center pad-tp pad-bt">
                                        <strong class="header-right-title">Folio: 34234</strong>
                                    </div>
                                    <div class="row">
                                        <div class="column cincuenta border-left-light border-right-light border-bottom-light border-top-light pad-tp pad-bt">
                                            Torre:
                                        </div>
                                        <div class="column cincuenta border-right-light border-bottom-light border-top-light pad-tp pad-bt">
                                            Consecutivo:
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row header-title-blue">
                            <div class=" bold">
                                Datos generales de la Agencia
                            </div>
                        </div>
                        <div class="row">
                            <div class="column diez border-left-light border-right-light border-bottom-light pad-tp pad-bt bold">
                                NO. REP.
                            </div>
                            <div class="column veinte border-right-light border-bottom-light pad-tp pad-bt bold">
                                LUZ FALLA ENCENDIDA
                            </div>
                            <div class="column veinte border-right-light border-bottom-light pad-tp pad-bt bold">
                                TIPO CÓDIGOS DTC&nbspTREN&nbspMOTRIZ
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt bold">
                                CÓDIGOS
                            </div>
                            <div class="column veinte border-right-light border-bottom-light pad-tp pad-bt bold">
                                -
                            </div>
                            <div class="column veinte border-right-light border-bottom-light pad-tp pad-bt bold">
                                -
                            </div>
                        </div>
                        <div class="row">
                            <div class="column diez border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%">
                            </div>
                            <div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito" style='text-decoration: none;'>
                            <select id="select_codigo" name="select_codigo" class="requisito" style="appearance: none;-webkit-appearance: none;-moz-appearance: none; border: none;overflow:hidden;width: 100%;">
                                <option value="">Tipo códigos</option>
                                <option value="2">KOEO</option>
                                <option value="3">KOEC</option>
                                <option value="4">KOER</option>
                                <option value="5">CARROCERIA</option>
                                <option value="6">CHASIS</option>
                                <option value="7">INDEFINIDO</option>
                                <option value="8">OTRO</option>
                            </select>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row header-title-blue">
                            <div class="column cincuenta border-right-light bold">
                                COMENTARIOS DEL MECANICO
                            </div>
                            <div class="column cincuenta bold">
                                REGISTRO DE LABOR
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt bold">
                                INCLUYA LA DESCRIPCION DE LA CAUSA DEL PROBLEMA
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt bold">
                                FechaNÚMERO REP.
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt bold">
                                CLAVE DE DEFECTO
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt bold">
                                RETORNO DE PARTES: BASICO/FECHA
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt bold">
                                MECANICO CLAVE
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt bold">
                                COSTO O TIEMPO UTILIZADO
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt bold">
                                RELOJ CHEC.(INICIO)
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt bold">
                                RELOJ CHEC.(FIN)
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt bold">
                                IDENTIFIQUE LA PARTE CAUSANTE
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt bold">
                                IDENTIFIQUE LA CAUSA DE LA FALLA
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt bold">
                                IDENTIFIQUE EL EQUIPO DE DIAGNOSTICO
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt bold">
                                EXPLIQUE LA REPARACIÓN AFECTUADA
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="myDIV" class="no_print" style="visibility:hidden;opacity: 0;">
            <button type="button" data-close onclick="closebutton()">
                <span aria-hidden="true">&times;</span>
            </button>
            <h1>Request</h1>
            <p id="request" class="code">
                -
            </p>
            <h1>Response</h1>
            <p id="response" class="code">
                -
            </p>
            
        </div>
    </body>
    <script>

        function myFunction(id) {
            var x = document.getElementById("myDIV");
            //x.innerHTML=id;
            if (x.style.visibility === "hidden") {
                x.style.visibility = "visible";
                x.style.opacity = "1";
                fetch('https://url/api/getDetailsLog/', {
                    method: 'POST',
                    headers:{
                        'Accept': 'application/json',
                        "Content-type":"application/json;charset=utf-8",
                        'Authorization':'Token 23c36877d39f649b8e1d8fa3a970e779f915143e',
                    },
                    body: JSON.stringify({"id":id})
                })
                .then(response => response.json())
                .then(response => {
                    console.log(response);
                    document.getElementById("request").innerHTML=response["data"]["request"];
                    document.getElementById("response").innerHTML=response["data"]["response"];
                }).catch(error => 
                    console.log(error.message)
                );
            } else {
                x.style.visibility = "hidden";
                x.style.opacity = "0";
            }
        }

        function closebutton() {
            var x = document.getElementById("myDIV");
            x.style.visibility = "hidden";
            x.style.opacity = "0";
        }
    </script>
</html>