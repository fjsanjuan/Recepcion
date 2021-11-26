<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<head>
<link rel="stylesheet" href="<?=base_url()?>assets/librerias/fontawesome-free-5.2.0-web/css/all.css"/>
<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" media="all">
<link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.tosrus.all.css">
<script src="<?=base_url()?>assets/js/jquery.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/js/jquery.tosrus.all.min.js"></script>
<script src="<?=base_url()?>assets/librerias/html2canvas/html2canvas.js"></script>
<script src="<?=base_url()?>assets/librerias/html2canvas/html2canvas.min.js"></script>
<title>Verificación</title>
</head>
<body>
	<div class="container borde_general" style="margin-top: 15px;">
		<div class="row">
			<div class="col-4">
				<!-- <button type="button" class="btn btn-info printMe" data-dismiss="modal" id="btn_update_mail"><i class="fas fa-print"></i> </button> -->
			</div>
			<div class="col-6">
				<h5><?=$agencia['razon_social']?></h5>
				<p><?=$datos_suc['dom_calle']." #".$datos_suc['dom_numExt'].", ".$datos_suc["dom_numInt"]?>, <?=$datos_suc['dom_colonia']?>
				<br><?=$datos_suc['dom_ciudad']?>, <?=$datos_suc['dom_estado']?>, <?=$datos_suc['dom_cp']?>
				<br> Email: <?=$datos_suc['email_contacto']?>     Sitio Web: <?=$datos_suc['sitio_web']?> <br>
				</p>
			</div>
			<div class="col-2">
				<?php 
					$movID = (isset($usuario["movID"]["MovID"])) ? $usuario["movID"]["MovID"] : "-";
				?>
				<h5>ORDEN NO. <?=$movID?></h5>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<h5>FORMATO DE VERIFICACIÓN DE REFACCIONES</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h6>TÉCNICO</h6>
						<p>
						<b>Nombre Técnico:</b> <?=$datos_refacciones['nombre']?> <?=$datos_refacciones['apellidos']?><br>
						<b>Email: </b> <?=$datos_refacciones['correo_tecnico']?><br>
						<b>Fecha Verificación:</b> <?=$datos_refacciones['actualizado']?><br>
						<!-- <b>refacciones Autorizadas:</b> <?=($datos_refacciones['autorizado'] == 1)?"SI":"NO"?> -->
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h6>REFACCIONES</h6>
						<p>
						<b>Nombre Responsable:</b> <?=$datos_tecnico['nombre']?> <?=$datos_tecnico['apellidos']?><br>
						<b>Email: </b> <?=$datos_tecnico['correo_refacciones']?><br>
						
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h6>PARTES REQUERIDAS</h6>
						<?php
                            $attributes = array('id' => 'form_presupuesto2');
                            echo form_open('',$attributes);
                        ?>
						<table class="table table-bordered table-striped table-hover animated fadeIn no-footer tablepres">
							<thead><tr><th>Clave Articulo</th><th>Descripcion</th><th>Precio Unitario</th><th>Cantidad</th>
								<th>I.V.A.</th><th>Total</th><th>En Existencia</th></tr></thead>
							<tbody>
								<?php
									$total = 0;
									foreach ($detalle as $key => $value) {
										$iva= round(($value["precio_unitario"] * 0.16),2);
										//$iva = $value["precio_unitario"] - $iva;
										$totalIva = $iva*$value["cantidad"];
										echo "<tr><td>".$value["cve_articulo"]."</td>";
										echo "<td>".$value["descripcion"]."</td>";
										echo "<td>".$value["precio_unitario"]."</td>";
										echo "<td>".$value["cantidad"]."</td>";
										echo "<td>".$totalIva."</td>";
										echo "<td>".($value["total_arts"]+$totalIva)."</td>";
										//echo "<td>".$value["en_existencia"]."</td>";
										echo "<td><input type='checkbox' class='check chk_aut2' value='".$value['cve_articulo']."' name='check_aut[]'></td></tr>";
										
										$total += ($value["total_arts"]+$totalIva);
									}
									echo "<tr><td colspan = '5' ></td><td>".$total."</td></tr>";
								?>
							</tbody>
						</table>
						
						<?php
                            echo form_close();
                        ?>
						 
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="ver_fotos"><i class="fas fa-image"></i> Ver fotos</button>
						<button type="button" class="btn btn-success" data-dismiss="modal" id="btn_update_mail2"><i class="fas fa-save"></i> Guardar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h6>Aviso</h6>
						<p>
							<ul>
								<li>Estos precios tiene Vigencia de 30 dias </li>
								<li>Precios Iva incluido</li>
							</ul>
						</p>
					</div>
				</div>
			</div>
		</div>
		<!--modal fotos-->
		<!--<div class="modal fade" id="modalFotos" tabindex="-1" role="dialog" data-backdrop="false">
			<div class="modal-dialog modal-sm"  role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Fotografías de la Orden</h5>
					</div>
					<div class="modal-body">
						<div id="links_light">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
		</div>
	</div>-->
</body>
</html> 
<script>
$(document).ready(function() {
	//variables que controlan la ruta donde se guardan las fotos de la inspeccion y seguimiento en el presupuesto
	//mostrar guardadas en el mismo proyecto dejarlas vacias alias_exists = '' var dir_fotos= '';
	//mostrar guardadas en otra ruta  alias_exists = 'nom_alias' var dir_fotos= 'F:/recepcion_activa/fotografias/';
	//var alias_exists = ''; 
	//var dir_fotos= '';

	var base_url = "<?=base_url();?>";
	$("#btn_update_mail").on("click", function(){
		$.ajax({
			url: base_url+ "index.php/Servicio/presupuesto_mail_cte",
			type: "POST",
			dataType: 'json',
			data: {datos:$("#form_presupuesto2").serializeArray(),id_presupuesto: $("#id_presupuesto").val()},
			beforeSend: function(){
				$("#loading_spin").show();
			},
			error: function(){
				console.log('error');
			},
			success: function (data){
				if(data.estatus == true){
					alert("Presupuesto Actualizado");
					// window.close();
				}else{
					alert(data.mensaje);
				}
			}
		});
	}); 
	$('.printMe').click(function(){
	     window.print();
	});
	$("#ver_fotos").on("click", function(e){
		var id_orden = $("#id_orden").val();
		var vin = $("#vin").val();
		// var id_orden = $("#id_orden").val();
		// alert('orden: ' + id_orden);
		$.ajax({
			url: base_url+ "index.php/Servicio/fotos_presupuesto_email",
			type: "POST",
			dataType: 'json',
			data: {id:id_orden, vin:vin},
			beforeSend: function(){
				$("#loading_spin").show();
			},
			error: function(){
				console.log('error fotos');
			},
			success: function (data){
				if(data.mensaje=="ok"){
					var img = document.createElement("img");

					if(alias_exists != ''){
						//variable que contiene la ruta con el alias del virtual host donde se encuentra la unidad donde se alojaran las imagenes
						var vhost=window.location.origin+'/'+alias_exists+'/';
						for(i = 0; i<data.fotos.length; i++){
							str =  data.fotos[i]['ruta_archivo'];
							var str_res = str.replace(dir_fotos, "");
							$("#links_light").append('<img src="'+vhost+str_res+'">');
						}
					}
					else{
						for(i = 0; i<data.fotos.length; i++){
							ruta = base_url + data.fotos[i]['ruta_archivo'];
							$("#links_light").append('<img src="'+ruta +'">');
						}
					}
					
					$("#links_light").tosrus();
					$('#modalFotos').modal('show');
					$("#loading_spin").hide();
				}else{
					alert(data.mensaje);
					$("#loading_spin").hide();
				}
			}
		});
	});
});
</script>
