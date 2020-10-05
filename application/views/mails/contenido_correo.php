<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<head>
<link rel="stylesheet" href="<?=base_url()?>assets/librerias/fontawesome-free-5.2.0-web/css/all.css"/>
<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" media="all">
<link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">

<script src="<?=base_url()?>assets/js/jquery.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/librerias/html2canvas/html2canvas.js"></script>
<script src="<?=base_url()?>assets/librerias/html2canvas/html2canvas.min.js"></script>
</head>
<script>
$(document).ready(function(){
	var img = "";
	
	function genIMG()
	{
		html2canvas(document.body,{
		   onrendered:function(canvas){
			   img = canvas.toDataURL("image/png");
			   localStorage.setItem("correo_base64", img);
		   }
	    });
	}

	genIMG();
});
</script>
<style>
	.mensaje {
	  text-align: justify;
	  color: #1c396d;
	  border: 5px solid #1c396d;
	  padding: 60px;
	}

	.logoCorreo{
	  display: block;
	  position: relative;
	  margin: 0px auto;
	  width: 50%;
	}
</style>
<body>
	<div class="container mensaje">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="col-md-12">
					<!-- <img src="<?=base_url()?>assets/img/fmx-global-header-logo.png" alt="logo Ford" class="logoCorreo"> -->
				</div>
				<br>
				<?php 
					$nombre_cliente = $orden["nombre_cliente"]." ".$orden["ap_cliente"];
					$fecha_creacion = explode(" ", $orden["fecha_creacion"]);
					$dia_creacion = date("d", strtotime($fecha_creacion[0]));
					$mes_creacion = date("F", strtotime($fecha_creacion[0]));

					switch ($mes_creacion) 
					{
						case "January":
							$mes_creacion = "Enero";
						break;
						case "March":
							$mes_creacion = "Marzo";
						break;
						case "April":
							$mes_creacion = "Abril";
						break;
						case "May":
							$mes_creacion = "Mayo";
						break;
						case "June":
							$mes_creacion = "Junio";
						break;
						case "July":
							$mes_creacion = "Julio";
						break;
						case "August":
							$mes_creacion = "Agosto";
						break;
						case "September":
							$mes_creacion = "Septiembre";
						break;
						case "October":
							$mes_creacion = "Octubre";
						break;
						case "November":
							$mes_creacion = "Noviembre";
						break;
						case "December":
							$mes_creacion = "Diciembre";
						break;
						default:
							$mes_creacion = date("m");
						break;
					}

					$anio_creacion = date("Y", strtotime($fecha_creacion[0]));

					$fecha_creacion = $dia_creacion." de ".$mes_creacion." de ".$anio_creacion;
				?>
				<p>Estimado/a Cliente, <b><?=$nombre_cliente?></b>:
					<br>
				   Ponemos a su disposición una copia de la <b>Orden de Servicio</b> (ver archivo PDF adjunto <i class="fa fa-paperclip"></i>) creada el día: <b><?=$fecha_creacion?></b>.
					<br> 
				   Sin más por el momento, agradecemos su visita al Taller de <?=$sucursal["nombre"]?>.
				   <br>
				   <center>Le atendió:
				   <br>
				   <?=$orden["asesor"]?> (Asesor)
				   <br>
				   <b>Servicio <?=$sucursal["nombre"]?></b>
				   </center>
				</p>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</body>
</html>