<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$caller_class = $this->router->class;

$caller_method = $this->router->fetch_method();

// echo $caller_method;
// echo $caller_class;die;
?>
<!-- JQuery  y scripts universales -->
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="<?=base_url()?>assets/js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/materialize.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="<?=base_url()?>assets/js/mdb.min.js"></script>
<script src="<?=base_url()?>assets/js/toastr.min.js"></script>
<!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->
<script src="<?=base_url();?>assets/librerias/sweetalert2-7.17.0/dist/sweetalert2.all.js"></script>
<script src="<?=base_url()?>assets/js/jqueryui/jquery-ui.min.js"></script>
<script src="<?=base_url();?>assets/librerias/bootstrap-select-1.10.0/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/main.js"></script>
<script src="<?=base_url();?>assets/librerias/jquery-confirm-master/js/jquery-confirm.js"></script>
<script src="<?=base_url()?>assets/librerias/validation/js/languages/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url()?>assets/librerias/validation/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?=base_url()?>assets/tesseract.js/dist/tesseract.js"></script>
<script src="<?= base_url()?>assets/librerias/Signature/src/jSignature.js"></script>
<script src="<?= base_url()?>assets/librerias/jq-signature-master/jq-signature.min.js"></script>
<script src="<?= base_url()?>assets/librerias/Flatpickr/flatpickr.min.js"></script>
<script src="<?= base_url()?>assets/librerias/Flatpickr/es.js"></script>
<!-- scripts especificos -->

<script src='<?=base_url()?>assets/js/jquery.validate.js'></script>
<script src='<?=base_url()?>assets/js/jquery.validate.min.js'></script>
<script src='<?=base_url()?>assets/js/jquery.validator.message.js'></script>
<?php 
	date_default_timezone_set('America/Mexico_City');
	clearstatcache();                //clears the file status cache
?>

<!-- scripts especificos -->
<?php

//look for JS for the class/controller
$class_js = "assets/js/custom/custom-".$caller_class.".js";
    if(file_exists(getcwd()."/".$class_js)){
    	$fecha = date("d m Y H:i:s", filemtime($class_js));
		$fecha = str_replace(' ', '', $fecha);
		$fecha = str_replace(':', '', $fecha);
    	$tam = filesize($class_js);
        ?><script type="text/javascript" src="<?php echo base_url().$class_js; ?>?u='<?php echo $fecha.$tam;?>'""></script>
        <?php
    } 

//look for JS for the class/controller/method
$class_method_js = "assets/js/custom/custom-".$caller_method.".js";
    if(file_exists(getcwd()."/".$class_method_js)){
        $fecha = date("d m Y H:i:s", filemtime($class_method_js));
        $fecha = str_replace(' ', '', $fecha);
        $fecha = str_replace(':', '', $fecha);
        $tam = filesize($class_method_js);
        ?><script type="text/javascript" src="<?php echo base_url().$class_method_js; ?>?u='<?php echo $fecha.$tam;?>'""></script>
        <?php
    } 
?>
<script src="<?=base_url()?>assets/js/moment.js"></script>

<!-- <script src='<?=base_url()?>assets/js/fullcalendar.js'></script>
<script src='<?=base_url()?>assets/js/scheduler.min.js'></script>
<script src='<?=base_url()?>assets/js/calendars.js'></script> -->
