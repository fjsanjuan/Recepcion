<!DOCTYPE html>
<html lang="es">
<head runat="server">   
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Recepcion de Servicio</title>
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="<?=base_url()?>assets/librerias/fontawesome-free-5.2.0-web/css/all.css"/>
    <!-- Material Icons-->
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
    <!-- Bootstrap core CSS -->
    <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="<?=base_url()?>assets/css/compiled.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/js/jqueryui/jquery-ui.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/alertify.core.css">    
    <link rel="stylesheet" href="<?=base_url()?>assets/css/alertify.bootstrap.css">
    <link href="<?=base_url()?>assets/css/hover.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
    <link rel="icon" href="<?=base_url();?>assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?=base_url();?>assets/librerias/jquery-confirm-master/css/jquery-confirm.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/librerias/validation/css/validationEngine.jquery.css" type="text/css"/>
    <link rel="stylesheet" href="<?=base_url()?>assets/librerias/validation/css/template.css" type="text/css"/>
    <link rel="stylesheet" href="<?=base_url()?>assets/librerias/Flatpickr/flatpickr.min.css" type="text/css"/>
    <link rel="stylesheet" href="<?=base_url()?>assets/librerias/Flatpickr/material_blue.css" type="text/css"/>
</head>
<script>
    site_url = "<?=site_url()?>";
    base_url = "<?=base_url()?>";
    var id_perfil = "<?=isset($this->session->userdata['logged_in']['perfil']) ? $this->session->userdata['logged_in']['perfil'] : 0?>";             //importante!!!  
    var fordStar = "<?=isset($this->session->userdata['logged_in']['fordStar']) ? $this->session->userdata['logged_in']['fordStar'] : null?>";             //importante!!!  
    if (id_perfil == 5 && !fordStar && !window.location.pathname.includes('configurar_perfil')) {
    	window.location.href = "<?=site_url('user/configurar_perfil')?>";
    }
</script>
<body>
    <!-- SCRIPTS -->
    <?=$scripts?>
    <!-- ./*SCRIPTS -->
    <!--navbar -->
    
    <?=$navbar?> 
    <!-- ./navbar  -->
    <!-- content here -->
	<?=$contenido?>
	<?php
	    $this->load->view("modals/modal_ruta_expediente");
	?>
    <!-- ./content here -->
    <script type="text/javascript">
    	if (id_perfil == 7) {
			$(document).off('click','span.menu-assets').on('click', 'span.menu-assets', function(event) {
				event.preventDefault();
				$.ajax({
					url: `${base_url}index.php/Servicio/obtener_ruta_expediente`,
					type: 'POST',
					dataType: 'json',
					data: [],
					contentType: false,
					processData: false,
					beforeSend: function () {
						$('#loading_spin').show();
					}
				})
				.done(function(resp) {
					if (resp.estatus) {
						$('#modal-ruta-expediente #rutaValue').val(resp.ruta_expediente);
						$('#modal-ruta-expediente').modal('toggle');
					}
				})
				.fail(function(error) {
					console.log('error', error);
					toastr.warning('Ocurrió un error inesperado, intente más tarde.');
				})
				.always(function() {
					$('#loading_spin').hide();
				});
			});
			$(document).off('click','#modal-ruta-expediente #btn_guardarRutaExpediente').on('click', '#modal-ruta-expediente #btn_guardarRutaExpediente', function(event) {
				event.preventDefault();
				if ($('#modal-ruta-expediente #rutaValue').val().trim().length > 3) {
					const form = new FormData();
					form.append('create', true);
					form.append('key', 'URL_FORMATS');
					form.append('value', $('#modal-ruta-expediente #rutaValue').val().trim());
					$.ajax({
						url: `${base_url}index.php/Admin/cambiar_variable_entorno`,
						type: 'POST',
						dataType: 'json',
						data: form,
						contentType: false,
						processData: false,
						beforeSend: function () {
							$('#loading_spin').show();
						}
					})
					.done(function(resp) {
						if (resp.estatus) {
							toastr.info(resp.mensaje);
							$('#modal-ruta-expediente').modal('toggle');
						} else {
							toastr.warning(resp.mensaje);
						}
					})
					.fail(function(error) {
						console.log('error', error);
						toastr.warning('Ocurrió un error inesperado, intente más tarde.');
					})
					.always(function() {
						$('#loading_spin').hide();
					});
				}else {
					toastr.warning('Ingresa una ruta mayor a 3 caracteres.');
				}
			});
    }
    </script>
<div class="cargando" id="loading_spin" style="background-color: rgba(0, 0, 0, 0)">
    <div class="col-md-12">
        <div class="windows8">
        <div class="wBall" id="wBall_1">
        <div class="wInnerBall">
        </div>
        </div>
        <div class="wBall" id="wBall_2">
        <div class="wInnerBall">
        </div>
        </div>
        <div class="wBall" id="wBall_3">
        <div class="wInnerBall">
        </div>
        </div>
        <div class="wBall" id="wBall_4">
        <div class="wInnerBall">
        </div>
        </div>
        <div class="wBall" id="wBall_5">
        <div class="wInnerBall">
        </div>
        </div>
        </div>
    </div>
</div>
</body>
</html>
<?php
    $this->load->view("modals/modal_sesion");
?>
