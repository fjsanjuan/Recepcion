<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Formato</title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/pdfstyles/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/toastr.min.css">
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
	<?php
	$attributes = array('id' => 'form_anverso');
	echo form_open('',$attributes);
	?>
    <body class="gray-bg" style="overflow-x: auto;" cz-shortcut-listen="true">
        <div class="sidebar">
            <a class="no_print" name="" id="save_anverso" type="button" href="#home">Guardar</a>
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
                                Código de Diagnóstico del Problema
                            </div>
                        </div>
                        <div id="top-section">
                            <div id="head">
                                <div id="left" class="header">
                                    <strong class="header-left-title sfont">(REP)Número de reparación<br/>(NL) Luz indicadora de falla<br/>(DTC) Código de falla</strong>
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
							NUEVA LÍNEA
                            </div>
                            <div class="column veinte border-right-light border-bottom-light pad-tp pad-bt bold">
							BORRAR LÍNEA
                            </div>
                        </div>
						<div class="code_lines">
                        <div class="row">
                            <div class="column diez border-left-light border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="detalles[0][num_reparacion]" id="" style="width: 98%">
                            </div>
                            <div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="detalles[0][luz_de_falla]" id="" style="width: 98%;">
                            </div>
                            <div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito" style='text-decoration: none;'>
                            <select id="select_codigo" name="detalles[0][tren_motriz]" class="requisito" style="appearance: none;-webkit-appearance: none;-moz-appearance: none; border: none;overflow:hidden;width: 100%;">
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
                                <input class="required write" type="text" name="detalles[0][codigos]" id="" style="width: 98%;">
                            </div>
                            <div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito">
							<i class="fa fa-plus fa-2x nuevo_codigo no_print" style="color:grey; cursor:pointer;" aria-hidden="true"></i>
                            </div>
                            <div class="column veinte border-right-light border-bottom-light pad-tp pad-bt requisito">
							<i class="fa fa-times fa-2x erase_line no_print" style="color:grey; cursor:pointer;"></i>
                            </div>
                        </div>
						</div>
						</>
                        <div class="row header-title-blue">
                            <div class="column cincuenta border-right-light bold">
                                COMENTARIOS DEL MECÁNICO
                            </div>
                            <div class="column cincuenta bold">
                                REGISTRO DE LABOR
                            </div>
                        </div>
                        <div class="row">
                            <div class="column treinta border-left-light border-right-light border-bottom-light pad-tp pad-bt bold">
                                INCLUYA LA DESCRIPCIÓN DE LA CAUSA DEL PROBLEMA
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt bold">
                                NÚMERO REP.
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt bold">
                                CLAVE DE DEFECTO
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt bold">
                                RETORNO DE PARTES: BÁSICO/FECHA
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt bold">
                                MECÁNICO CLAVE
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
                                <input class="required write" type="text" name="num_reparacion" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="clave_defecto" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="retorno_partes" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="mecanico_clave" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="costo_tiempo" id="" style="width: 98%;">
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
                                <input class="required write" type="text" name="parte_causante" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
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
                                <input class="required write" type="text" name="num_reparacion" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="clave_defecto" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="retorno_partes" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="mecanico_clave" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="costo_tiempo" id="" style="width: 98%;">
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
                                <input class="required write" type="text" name="causa_falla" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
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
                                IDENTIFIQUE EL EQUIPO DE DIAGNÓSTICO
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="num_reparacion" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="clave_defecto" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="retorno_partes" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="mecanico_clave" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="costo_tiempo" id="" style="width: 98%;">
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
                                <input class="required write" type="text" name="equipo_diagnostico" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
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
                                EXPLIQUE LA REPARACIÓN EFECTUADA
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="num_reparacion" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="clave_defecto" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="retorno_partes" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="mecanico_clave" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="costo_tiempo" id="" style="width: 98%;">
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
                                <textarea class="required write" type="textarea" name="reparacion_efectuada" id="" style="width: 98%;" rows="10" cols="15" ></textarea>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;" readonly>
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                            <div class="column diez border-right-light border-bottom-light pad-tp pad-bt requisito">
                                <input class="required write" type="text" name="" id="" style="width: 98%;">
                            </div>
                        </div>
                    </div>
					<tbody>
						<div class="row" style="text-align: center; width:90%; margin: 50px;">
							<div class="form-check" id="FirmaTecnico"><b>FIRMA DE TÉCNICO</b><br><br>
								<input class="form-check-input no_print" name="firma_tecnico" type="checkbox" id="firmTecn" style='height: 24px; width: 24px;' required>
								<label class="form-check-label" for="firmTecn"></label>
                                <input type="hidden" name="firma_techn" id="firma_techn">
								<button type="button" class="btn btn-outline-warning btn-sm no_print" id="cancelFirmTechn" style="display: none">X</button>
							</div>
							<div class="form-check" id="checkeaJefe1" ><b>FIRMA DE JEFE TALLER</b><br><br>
								<input class="form-check-input no_print" name="firma_jefe_taller" type="checkbox" id="checkJefe1" style="height: 24px; width: 24px;">
								<label for="checkJefe1"></label>
								<button type="button" class="btn btn-outline-warning btn-sm no_print" id="cancelJefe1" style="display: none">X</button>
							</div>
						</div>
					</tbody>
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
	<?php
	echo form_close();
	?>
	<!--scripts-->
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.min.js"></script>
	<script src="<?=base_url()?>assets/js/toastr.min.js"></script>
	<script src="<?= base_url()?>assets/librerias/jq-signature-master/jq-signature.min.js"></script>
	<script src="<?=base_url();?>assets/librerias/sweetalert2-7.17.0/dist/sweetalert2.all.js"></script>
	<script src="<?=base_url()?>assets/js/toastr.min.js"></script>

	<script src='<?=base_url()?>assets/js/jquery.validate.js'></script>
	<script src='<?=base_url()?>assets/js/jquery.validate.min.js'></script>
	<script src='<?=base_url()?>assets/js/jquery.validator.message.js'></script>

	<?php 
	date_default_timezone_set('America/Mexico_City');
	clearstatcache();                //clears the file status cache
	?>

    <script>
		var base_url = `<?php echo  base_url(); ?>`;
		var idOrden = `<?php echo $id_orden; ?>`;
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
		
	$(document).on("click", '#save_anverso', function(e){
	e.preventDefault();
	//var idOrden = $(this).prop("data-orden");
	console.log('id_orden', idOrden);
	//localStorage.setItem("hist_id_orden", idOrden);
	const form = new FormData(document.getElementById("form_anverso"));
	form.append('id_orden', idOrden);
	swal({
		title: '¿Desea guardar el diagnóstico?',
		showCancelButton: true,
		confirmButtonText: 'Guardar',
		cancelButtonText: 'Cancelar',
		type: 'info'
	})
	.then((result) => {
		if (result.value) {

				$.ajax({
					cache: false,
					url: base_url+ "index.php/servicio/guardar_diagnostico/"+idOrden,
					contentType: false,
					processData: false,
					type: 'POST',
					dataType: 'json',
					data: form,
					beforeSend: function(){
						$("#loading_spin").show();
					}
				})
				.done(function(data) {
					if (data.estatus) {
						swal('Diagnóstico guardado.', '', 'success');

					}else{
						toastr.warning(data.mensaje);
					}
				})
				.fail(function() {
					toastr.warning('Hubo un error al firmar diagnóstico');
				})
				.always(function() {
					$("#loading_spin").hide();
				});	
			
		}else if (result.dismiss) {
			swal('Cancelado', '', 'error');
		}
	})
});
$(document).on('click', '#firmTecn', function(e){
	e.preventDefault();
	var id_orden = localStorage.getItem('hist_id_orden');
	//console.log('id_orden', id_orden);
	const form = new FormData();
	form.append('id_orden', id_orden);
	swal({
		title: '¿Firmar anverso?',
		showCancelButton: true,
		confirmButtonText: 'Firmar',
		cancelButtonText: 'Cancelar',
		type: 'info'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					cache: false,
					url: base_url+ "index.php/servicio/firmar_anverso/"+id_orden,
					contentType: false,
					processData: false,
					type: 'POST',
					dataType: 'json',
					data: form,
					beforeSend: function(){
						$("#loading_spin").show();
					}
				})
				.done(function(data) {
					if (data.estatus) {
						$('input[name="firma_techn"]').val(data.firma_electronica);
						$("#firmaTecn").prop("checked", true);
						$("#cancelFirmTechn").css('display', 'inline-block');
					}else{
						toastr.warning(data.mensaje);
					}
				})
				.fail(function() {
					toastr.warning('Hubo un error al firmar el anverso');
				})
				.always(function() {
					$("#loading_spin").hide();
				});
			} else if (result.dismiss) {
				swal('Cancelado', '', 'error');
			}
		});
});

$(document).on('click', '#cancelFirmTechn', function(e){
	e.preventDefault();
	var idOrden = $(this).prop("data-orden");
	localStorage.setItem("hist_id_orden", idOrden);
	const form = new FormData();
	form.append('id_orden', idOrden);
	swal({
		title: '¿Desea cancelar firma del anverso?',
		showCancelButton: true,
		confirmButtonText: 'Cancelar',
		cancelButtonText: 'Cerrar',
		type: 'info'
		}).then((result) => {
			if (result.value) {
				$('input[name="firma_techn"]').val("");
				$('#firmaTechn').prop('checked', false);
				$("#cancelFirmTechn").css('display', 'none');
			} else if (result.dismiss) {
				swal('Cancelado', '', 'error');
			}
		});
	});
var newlinecode = 1;
$(document).on('click', '.nuevo_codigo', function (e) {
	e.preventDefault();
	const code = $(this).closest('div.row').clone();
	code.find('input[type="text"]').val("");
	code.find('input[name="detalles[0][num_reparacion]"]').prop('name',`detalles[${newlinecode}][num_reparacion]`);
	code.find('input[name="detalles[0][luz_de_falla]"]').prop('name',`detalles[${newlinecode}][luz_de_falla]`);
	code.find('select[name="detalles[0][tren_motriz]"]').prop('name',`detalles[${newlinecode}][tren_motriz]`);
	code.find('input[name="detalles[0][codigos]"]').prop('name',`detalles[${newlinecode}][codigos]`);
	newlinecode++;
	code.find('select').val("");
	code.insertAfter($(this).closest('div.row'));
	
})
$(document).on('click', '.erase_line', function (e) {
	e.preventDefault();
	if ($(this).closest('.code_lines div.row').find('div.row').length > 0) {
        toastr.warning('No puedes eliminar la primer linea');
        return;
    }
    if ($('.code_lines div.row ').length > 1) {
        $(this).closest('.code_lines div.row').remove();
    }else {
        toastr.warning('Debes matener una linea');
    }
});

    </script>
</html>
