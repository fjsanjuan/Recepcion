<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="<?=base_url()?>assets/librerias/fontawesome-free-5.2.0-web/css/all.css"/>
		<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" media="all">
		<link href="<?=base_url()?>assets/css/style_profeco.css" rel="stylesheet">
		<script src="<?=base_url()?>assets/js/jquery.min.js"></script>
		<script src="<?=base_url()?>assets/librerias/html2canvas/html2canvas.min.js"></script>
		<title>Orden de Servicio</title>
	</head>
	<body id='body'>
		<div class="header bordes">
			<div class="elements rightline" >
				<div class="imagen">
					<img src="<?= $imgtype == 'html' ? base_url() : './'?>assets/img/logo/Find-New-Roads.png" height="90px" /> 
				</div>
			</div>
			<div class="elements-identity rightline">
				<div class="no-margins">
					<div class="col1-1 "> Denominación o razón social:  <?=strtoupper($sucursal["razon_social"])?> </div>
				</div>
				<div class="no-margins">
					<div class="col1-1 "> R.F.C: <?=$sucursal["rfc"]?> </div>
				</div>
				<div class="no-margins" >
					<div class="col1-1 "> Domicilio: <label class="backcoloured"> <?= $sucursal["dom_calle"] ?> </label>, no. <label class="backcoloured"> <?= $sucursal["dom_numExt"] ?>, int  <?= $sucursal["dom_numInt"] ?></label>, Col. <label class="backcoloured"> <?= $sucursal["dom_colonia"] ?> </label><br>
					 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <label class="backcoloured"> <?= $sucursal["dom_ciudad"] ?>, <?= $sucursal["dom_estado"] ?> </label>, C.P. <label class="backcoloured"> <?= $sucursal["dom_cp"] ?> </label>
					</div>
				</div>
				<div class="no-margins" >
					<div class="col1-1"> Teléfono(s) y horario de atención: 
						<div>
							<label class="backcoloured"> <?=$sucursal["telefono"].", ".$sucursal["horario_recep"]?> </label>
						</div>
					</div>

				</div>
				<div class="no-margins" >
					<div class="col1-1"> Fax: N/A</div>
				</div>
				<div class="no-margins" >
					<div class="col1-1"> E.Mail: <?php echo ($sucursal["email_contacto"])?$sucursal["email_contacto"]:'.';?></div>
				</div>
				<div class="no-margins" >
					<div class="col1-1"> SIEM (opcional): . </div>
				</div>

			</div>
			<div class="elements-right">
				
				<div class="underline">
					<div class="col1-1 secondary-right-header">Orden de reparación: <br>
						<div class="centered backcoloured">
							<labe class="remarked"> <?=$cliente["MovID"]?> </label>
						</div>	
					</div>
				</div>

				<div class="underline">
					<div class="col1-1 secondary-right-header">Fecha: <br>
						<div class="centered backcoloured">
							<labe class="remarked"> <?=date('Y/m/d')?> </label>
						</div>	
					</div>
				</div>

				<div class="col1-1 primary-right-header">Localidad: <br>
					<div class="centered">
						<label class="remarked backcoloured"> <?=$sucursal["dom_ciudad"]?>,  <?=$sucursal["dom_estado"]?> </label> <br>
						<label class="unmarked centered no-margins">(lugar de reparación y/o <br> mantenimiento) </label>
					</div>	
				</div>
			</div>
		</div>
		<div class="datos-cliente">
			<div class="elements-cliente" style="height: 8px;"> 
				<div class="datos-cliente-title">DATOS DEL CLIENTE (CONSUMIDOR)</div>
			</div>
			<div class="elements-cliente" style="height: 12px;">
				<div class="no-margins">
					<div class="col3-1">
						<label class="cliente-nombre-label">
							Nombre: 
						</label>
						<label class="backcoloured cliente-nombre">
							<?= $cliente['nombre_cliente']." ".$cliente["ap_cliente"]." ".$cliente["am_cliente"] ?>
						</label>
						<label class="cliente-rfc-label">
							RFC:
						</label>
						<label class="backcoloured cliente-rfc">
							<?=$cliente["rfc_cliente"]?>
						</label>
						<label class="cliente-mail-label">
							E.Mail: 
						</label>
						<label class="backcoloured cliente-mail">
							<?=$cliente['email_cliente']?>
						</label>
					</div>
				</div>
			</div>
			<div class="elements-cliente" style="margin-top:2px;height: 10px;">
				<div class="no-margins">
					<div class="elements-cliente-row underline">
						<label class="domicilio-col-1">
							Domicilio:
						</label>
						<label class="backcoloured domicilio-col-2 ">
							<?=$cliente["dir_calle"]?>
						</label>
						<label class="backcoloured domicilio-col-3">
							<?=$cliente["dir_num_ext"].", ".$cliente["dir_num_int"]?>
						</label>
						<label class="backcoloured domicilio-col-4">
							<?=$cliente["dir_colonia"]?>
						</label>
					</div>
				</div>
			</div>
			<div class="elements-cliente" style="margin-top:2px;height: 10px;">
				<div class="no-margins underline">
					<label class="domicilio-col-1"> </label>
					<label class="domicilio-col-2 unmarked ">
						(Calle)
					</label>
					<label class="domicilio-col-3 unmarked">
						(Número exterior e interior)
					</label>
					<label class="domicilio-col-4 unmarked">
						(Colonia)
					</label>
				</div>
			</div>
			<div class="elements-cliente" style="margin-top:2px;height: 10px;">
				<div class="no-margins underline">
					<label class="backcoloured domicilio-col-1">
						<?=$cliente["dir_cp"]?>
					</label>
					<label class="backcoloured domicilio-col-2">
						<?=$cliente["dir_municipio"]?>
					</label>
					<label class="backcoloured domicilio-col-3">
						<?=$cliente["dir_estado"]?>
					</label>
					<label class="backcoloured domicilio-col-4">
						<?=$cliente["tel_movil"]." - - ".$cliente["otro_tel"]?>
					</label>
				</div>
			</div>
			<div class="elements-cliente" style="margin-top:2px;height: 10px;">
				<div class="no-margins underline">
					
					<label class="unmarked domicilio-col-1">
						(Código Postal)
					</label>
					<label class="unmarked domicilio-col-2">
						(Delegación o Municipio)
					</label>
					<label class="unmarked domicilio-col-3">
						(Estado)
					</label>
					<label class="unmarked domicilio-col-4">
						(Teléfonos)
					<label>
				</div>
			</div>
		</div>
		<div class="datos-caracteristicas">
			<div class="elements-cliente" style="margin-top:12px;margin-left:-7px">
				<div class="middle">
					<div>
						Marca: <label class="backcoloured"> <?=$cliente["marca_v"]?></label>
					</div>
					<div>
						Submarca: <label class="backcoloured">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</label>
					</div>
					<div>
						Tipo o versión: <label class="backcoloured"> <?=$cliente["Descripcion1"]?></label>
					</div>
					<div>
						Color: <label class="backcoloured"> <?=$cliente["color_v"]?></label>
					</div>
					<div>
						Año-modelo: <label class="backcoloured"> <?=$cliente['anio_modelo_v']?></label>
					</div>
					<div>
						Número Identificación Vehicular: <label class="backcoloured"> <?=$cliente['vin_v']?></label>
					</div>
					<div>
						Capacidad: <label class="backcoloured"> <?=$cliente['Pasajeros']?></label>
					</div>
					<div>
						Número de kilómetros recorridos: <label class="backcoloured"> <?=$cliente['kilometraje_v']?></label>
					</div>
					<div>
						Número de placas: <label class="backcoloured"> <?=$cliente['placas_v']?></label>
					</div>
				</div>
				<div class="middle2">
					<div>
						Asesor: <label class="backcoloured"> <?=$cliente['asesor']?></label>
					</div>
					<div>
						Pirámide: <label class="backcoloured"> <?=$cliente['torrecolor']?></label>
					</div>
					<div>
						<?php 
						$cliente["fecha_recepcion"] = explode(" ", $cliente["fecha_recepcion"]);
						$fecha_recepcion = date("d-m-Y", strtotime($cliente['fecha_recepcion'][0]));
						?>
						Fecha y hora de recepción del vehículo: <label class="backcoloured"> <?=$fecha_recepcion?> <?=$cliente['hora_recepcion']?></label>
					</div>
					<div>
						<?php 
						$cliente["fecha_entrega"] = explode(" ", $cliente["fecha_entrega"]);
						$fecha_entrega = date("d-m-Y", strtotime($cliente['fecha_entrega'][0]));
						?>
						Fecha y hora de entrega del vehículo:  <label class="backcoloured"> <b style="font-size:11px;">fecha sujeta a tiempo de revisión</b> </label>
					</div>
					<div>
						Se entregan las partes o refacciones reemplazadas al consumidor:
					</div>
					<div>
						Si (&nbsp;&nbsp;&nbsp;) No (&nbsp;x&nbsp;)
					</div>
					<div>
						<b>NOTA:</b> Las partes y/o refacciones <b>no</b> se entregarán al consumidor cuando:<br>
					</div>
					<div>
							a) Sean cambiadas en uso de garantía.<br>
							b) Se trate de residuos considerados peligrosos de acuerdo con las disposiciones legales aplicables.
					</div>
					<div>
						Servicio en el domicilio del consumidor Si (&nbsp;&nbsp;&nbsp;) No (&nbsp;x&nbsp;)
					</div>
					<div>
						Póliza de seguro para cubrir al consumidor los daños o el extravío de bienes: <br> (&nbsp;x&nbsp;) Si Número  (&nbsp;&nbsp;&nbsp;) No
					</div>
				</div>
			</div>
		</div>
		<div class="datos-servicio">
			<?php 
			$print_operaciones="";
			$print_precios="";
			$print_subtotales="";
			$print_total=0;
			$subtotal=0;
			foreach ($desglose as $key => $value){
					$print_operaciones.="<div> ".$value["descripcion"]."</div>";
					$print_precios.="<div>$".number_format($value["precio_unitario"], 2, '.', ',')."</div>";
					$print_subtotales.="<div>$".number_format($value["iva_total"], 2, '.', ',')."</div>";
					$print_total+=$value["iva_total"];
					$subtotal+=$value["precio_unitario"]*$value["cantidad"];

			}
			$iva = $print_total-$subtotal;
			?>
			<div class="elements-operation" style="margin-top:12px;">
				<div class="seg4-1">
					<div class="operation-column">
					OPERACIONES A EFECTUAR:
					</div>
					<label class="backcoloured unmarked"> <?= $print_operaciones ?> </label>
					<div>
					</div>
					<div class="operation-column">
					POSIBLES CONSECUENCIAS:
					</div>
				</div>
				<div class="seg4-2">
					<div class="operation-column">
					PARTES Y/O REFACCIONES:
					</div>
				</div>
				<div class="seg4-3">
					<div class="operation-column">
					PRECIOS UNITARIOS:
					</div>
					<label class="backcoloured unmarked"> <?= $print_precios ?> </label>
					<div>
					Monto total de la operación:
					</div>
				</div>
				<div class="seg4-4">
					<div class="operation-column">
					&nbsp;
					</div>
					<label class="backcoloured unmarked"> <?= $print_subtotales ?> </label>
					<div>
					<label class="backcoloured unmarked"> <?= "$".number_format($print_total, 2, '.', ',') ?> </label>
					</div>
				</div>
			</div>
		</div>
		<div class="datos-pago">
			<div class="elements-cliente" style="margin-left:-7px">
				<div class="seg4-1">
					<div class="operation-column">
					FORMA DE PAGO: <br>Monto de la operación:
					</div>
					<div>
					Otros cargos:
					</div>
					<div>
					Servicios adicionales:
					</div>
					<div>
					Parcial:
					</div>
					<div>
					Impuesto al Valor Agregado:
					</div>
					<div>
					(Incluye mano de obra)
					</div>
					<div>
					Efectivo (&nbsp;&nbsp;&nbsp;) Cheque (&nbsp;&nbsp;&nbsp;)  tarjeta de crédito (&nbsp;&nbsp;&nbsp;) Otro (&nbsp;&nbsp;&nbsp;)
					</div>
				</div>
				<div class="seg4-2">
					<div class="operation-column">
					&nbsp;
					</div>
					<div class="etiqueta-renglon">
						<label class="backcoloured"> <?= "$".number_format($subtotal, 2, '.', ',') ?> </label>
					</div>
					<div class="etiqueta-renglon">
					$&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					<div class="etiqueta-renglon">
					$&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					<div class="etiqueta-renglon">
					$&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					<div class="etiqueta-renglon">
						<label class="backcoloured"> <?= "$".number_format($iva, 2, '.', ',') ?> </label>
					</div>
					<div class="etiqueta-renglon">
						<label class="backcoloured"> <?= "$".number_format($print_total, 2, '.', ',') ?> </label>
					</div>
				</div>
				<div class="seg4-3">
					<div class="operation-column">
					SERVICIOS ADICIONALES:
					</div>
					<div class="operation-column">
					Total refacciones y servicios adicionales:
					</div>
					<div style="margin-top:20px">
					El resto del monto total de la operación, se liquidará en la fecha señalada para la entrega del vehículo.
					</div>
				</div>
				<div class="seg4-4">
					<div class="operation-column">
					&nbsp;
					</div>
					<div>
					$ __________________
					</div>
					<div class="operation-column">
					&nbsp;
					</div>
					<div>
					$ __________________
					</div>
				</div>
			</div>
		</div>
		<?php
			//plumas 
			$checked_plumas = ($inspeccion["plumas"] == "Buen Estado") ? "(Si) Limpiadores (plumas);" : "(No) Limpiadores (plumas);";
			//unidad de luces
			$checked_luces = ($inspeccion["luces_int"] == "SI") ? "(Si) Unidades de luces; " : "(No) Unidades de luces;";
			//antena
			$antn = explode(",", $inspeccion["exteriores"]);
			$checked_antn = ($antn[2] == "n/a") ? "(No) Antena;" : "(Si) Antena;";
			//espejos laterales
			$checked_espejos = ($inspeccion["espejos"] == "SI") ? "Si" : "No";
			//Cristales lo marcan como vidrios en la inpeccion con la tablet y en el de profeco dice cristales
			$checked_cristales = ($inspeccion["vidrios"] == "SI") ? "Si" : "No";
			//tapones de ruedas
			$tapons_rueds = explode(",", $inspeccion["exteriores"]);
			$checked_tapons_rueds = ($tapons_rueds[0] == "n/a") ? "No" : "Si";
			//molduras completas
			$molduras = explode(",", $inspeccion["exteriores"]);
			if (count($molduras)>4) {
				$checked_molduras = ($molduras[4] == "n/a") ? "No" : "Si";	
			}
			else {
				$checked_molduras="No";
			}

			
			//tapon de gasolina
			$tapn_gas = explode(",", $inspeccion["exteriores"]);
			$checked_tapn_gas = ($tapn_gas[3] == "n/a") ? "No" : "Si";
			//Claxon
			$checked_claxon = ($inspeccion["claxon"] == 'SI') ? "Si" : "No";
			//tablero
			$tablero = explode(",", $inspeccion["profecoFame"]);
			$checked_tablero = ($tablero[0] == "tablero_si") ? "Si" : "No";
			//espejo retrovisor pendiente
			$retrovisor = explode(",", $inspeccion["profecoFame"]);
			$checked_retrovisor = ($retrovisor[1] == "retrovisor_si") ? "Si" : "No";
			//aire acondicionado
			$checked_ac = ($inspeccion["ac"] == "SI") ? "Si" : "No";
			//radio
			$checked_radio = ($inspeccion["radio"] == "SI") ? "Si" : "No";
			//radio
			$checked_encendedor = ($inspeccion["encendedor"] == "SI") ? "Si" : "No";
			//cenicero
			$cenicero = explode(",", $inspeccion["profecoFame"]);
			$checked_cenicero = ($cenicero[2] == "cenicero_si") ? "Si" : "No";
			//cinturon de seguridad
			$cinturon = explode(",", $inspeccion["profecoFame"]);
			$checked_cinturon = ($cinturon[3] == "cinturon_si") ? "Si" : "No";
			//tapetes
			$checked_tapetes = ($inspeccion["tapetes"] == "SI") ? "Si" : "No";
			//manijas
			$manijas = explode(",", $inspeccion["profecoFame"]);
			$checked_manijas = ($manijas[4] == "manijas_si") ? "Si" : "No";
			//aspectos mecanicos
			$aspectos_mecanicos = explode(",", $inspeccion["profecoFame"]);
			$str_aspectos_mecanicos = ($aspectos_mecanicos[4] == "amNoE") ? "no enciende" : "regulares de uso";

			//aspectos de carroceria 
			$aspectos_carroceria = explode(",", $inspeccion["profecoFame"]);
			switch ($aspectos_carroceria[5]) 
			{	
				case "acMalEdo":
					$str_aspectos_carroceria = "mal estado";
				break;
				case "acRayones":
					$str_aspectos_carroceria = "presenta rayones diversos";
				break;
				default:
					$str_aspectos_carroceria = "regulares de uso";
				break;
			}

			//garantia serivicio
			$checked_garantía = ($inspeccion["extension_garantia"] == "si") ? "() sin garantía; (x) con garantía" : "(x) sin garantía; () con garantía";
			$dias_garantia = ($inspeccion["extension_garantia"] == "si") ? "90" : "0";

		?>
		<!--<div class="break-page four_border"></div>-->
		
		<div class="datos-condiciones">
			<div id="back-header">
				<div class="back-imagen">
					<img src="<?= $imgtype == 'html' ? base_url() : './'?>assets/img/logo/Find-New-Roads.png" height="70px" weight="40px" /> 
				</div>
				<div id="back-header-text">
					<div style="text-align: left; font-size:14px; font-weight: bold;">
						<?=strtoupper($sucursal["razon_social"])?>
						<label style="float:right; text-align:left; font-size: 10px ;">
							Citas de Servicio: <?=$sucursal["telefono"]?> <br>
						</label>
					</div>
					<div style="float:left; text-align:left; font-size: 13px ;">
						R.F.C: <?=$sucursal["rfc"]?> <br>
						<?= $sucursal["dom_calle"] ?> No. <?= $sucursal["dom_numExt"] ?>, Int.  <?= $sucursal["dom_numInt"] ?>, <?= $sucursal["dom_colonia"] ?>, <?= $sucursal["dom_ciudad"] ?> C.P. <?= $sucursal["dom_cp"] ?> <br>
						Tel.:  <?=$sucursal["telefono"]?> Email: <?php echo ($sucursal["email_contacto"])?$sucursal["email_contacto"]:'.';?>
						
						<div style="float:right; text-align:left; font-size: 14px ; font-weight: bold; margin-top:15px;">
							ORDEN DE SERVICIO No. <?=$cliente["MovID"]?>
						</div>
					</div>
					
				</div>

			</div>
			<div class="col-over-title">
				CONDICIONES DEL CONTRATO DE PRESTACIÓN DE SERVICIOS DE REPARACIÓN Y/O MANTENIMIENTO DE VEHÍCULOS
			</div>
			<div class="col-over-content">1. En virtud de este contrato (*), el Distribuidor presta el servicio de reparación y/o mantenimiento al Cliente (Consumidor), del vehículo cuyas características se detallan en este contrato.</div>
			<div class="col-over-content">2. El Cliente expresa ser el dueño del vehículo y/o estar facultado para autorizar la reparación y/o mantenimiento del vehículo descrito en el presente contrato, por lo que acepta las condiciones y términos bajo los cuales se realizará la prestación del servicio descrita en el presente contrato. Asimismo, es sabedor de las posibles consecuencias que puede sufrir el vehículo con motivo de su reparación y/o mantenimiento y se responsabiliza de las mismas. El consumidor acepta haber tenido a la vista los precios por mano de obra, partes y/o refacciones a emplear en las operaciones a efectuar por parte del Distribuidor.</div>
			<div class="col-over-content">3. El precio total por concepto de la prestación del servicio de reparación y/o mantenimiento será cubierto en las instalaciones del Distribuidor y en moneda nacional en la forma y términos expresados en este contrato, incluyendo, en su caso, las partes y/o refacciones y los servicios adicionales que el cliente haya aceptado previamente.</div>
			<div class="col-over-content">4. En la situación de que el Cliente solicite, o en su caso, el Distribuidor avise al Cliente de servicios adicionales a los establecidos en el presente contrato, éste último los podrá autorizar vía telefónica. Asimismo, todas las quejas y sugerencias serán atendidas en el domicilio, teléfonos y horarios de atención señalados en la carátula o anverso del presente contrato.</div>
			<div class="col-over-content">5. Las condiciones generales del vehículo materia de reparación y/o mantenimiento, son las siguientes: <b>Exteriores:</b>
			<?php  echo $checked_plumas; ?> <!-- Limpiadores (plumas);  -->
			<?php  echo $checked_luces; ?> <!-- Unidades de luces; --> 
			<?php  echo $checked_antn; ?> <!-- Antena;  -->
			(<?php  echo $checked_espejos; ?>) Espejos laterales; 
			(<?php  echo $checked_cristales; ?>) Cristales; 
			(<?php  echo $checked_tapons_rueds; ?>) Tapones de ruedas; 
			(<?php  echo $checked_molduras; ?>) Molduras completas; 
			(<?php  echo $checked_tapn_gas; ?>) Tapón de gasolina; 
			(<?php  echo $checked_claxon; ?>) claxon; <b>Interiores:</b> 
			(<?php  echo $checked_tablero; ?>) Instrumentos de tablero; 
			(Si) Calefacción; 
			(<?php  echo $checked_ac; ?>) Aire acondicionado; 
			(<?php  echo $checked_radio; ?>) Radio/Tipo; 
			(<?php  echo $checked_radio; ?>) Bocinas; 
			(<?php  echo $checked_encendedor; ?>) Encendedor; 
			(<?php  echo $checked_retrovisor; ?>) Espejo retrovisor; 
			(<?php  echo $checked_cenicero; ?>) ceniceros; 
			(<?php  echo $checked_cinturon; ?>) Cinturones de seguridad; 
			(<?php  echo $checked_tapetes; ?>) Tapetes; 
			(<?php  echo $checked_manijas; ?>) Manijas y/o controles interiores; 
			(No) Equipo adicional; (No) Accesorios; (No) Aditamientos especiales; (No) Otros. El vehículo se esncuentra en las siguientes condiciones generales: Aspectos mecánicos <?php echo $str_aspectos_mecanicos; ?>; aspectos de carrocería <?php  echo $str_aspectos_carroceria; ?>.</div>
			<div class="col-over-content">6. La prestación del servicio de reparación y/o mantenimientos del vehículo materia de este contrato, se otorga <?php echo $checked_garantía ?> por un plazo de <b><?php echo $dias_garantia ?> días</b>, (Art. 77 de la LFPC* no podrá ser inferior a 90 días) contados a partir de la entrega del vehículo. Para la garantía en partes, piezas, refacciones y accesorios, El Distribuidor transmitirá la otorgada por el fabricante, la garantía deberá hacerse válida en el domicilio, teléfonos y horarios de atención señalados en la carátula o anverso del presente contrato, siempre y cuando no se haya efectuado una reparación por un tercero. El tiempo que dure la reparación y/o mantenimiento del vehículo, bajo la protección de la garantía, no es computable dentro del plazo de la misma. Las partes y/o refacciones empleadas en la reparación y/o mantenimiento del vehículo materia de este contrato, son nuevas y apropiadas para el funcionamiento del mismo. De igual forma, los gastos en que incurra el Cliente para hacer válida la garantía en un domicilio diverso al del Distribuidor, deberán ser cubiertos por éste.</div>
			<div class="col-over-content">7. El Distribuidor será el responsable por las descomposturas, daños o pérdidas parciales o totales imputables a él, mientras el vehículo se encuentre bajo su resguardo para llevar a cabo la prestación del servicio de reparación y/o mantenimiento, o como consecuencia de la prestación del servicio, o bien, en el cumplimiento de la garantía, de acuerdo a lo establecido en el presente contrato. Asimismo, el Cliente autoriza al Distribuidor a usar el vehículo para efectos de prueba o verificación de las operaciones a realizar o realizadas. El Cliente libera al Distribuidor de cualquier responsabilidad que hubiere surgido o pudiera surgir con relación al origen, propiedad o posesión del vehículo.</div>
			<div class="col-over-content">8. El Cliente podrá revocar su consentimiento, en un plazo de 5 días hábiles mediante aviso personal, correo electrónico o correo certificado, siempre y cuando no se hayan iniciado los trabajos de reparación y/o mantenimiento.</div>
			<div class="col-over-content">9. En caso de que apliquen restricciones, estas se le darán a conocer al cliente.</div>
			<div class="col-over-content">10. En caso de que el consumidor cancele la operación, está obligado a pagar de manera inmediata y previa a la entrega del vehículo, el importe de las operaciones efectuadas y partes y/o refacciones colocadas o adquiridas hasta el retiro del mismo.</div>
			<div class="col-over-content">11. Son causas de rescisión del presente contrato: (i) Que el Distribuidor incumpla en la fecha y el lugar de entrega del vehículo por causas imputables a él.- El Cliente le notificará por escrito el incumplimiento de dicha obligación y el Distribuidor entregará de manera inmediata el vehículo, debiendo descontar del monto total de la operación, la cantidad equivalente al <b>0</b>% por concepto de pena convencional (ii) Que el Cliente incumpla con su obligación de pago.- En el evento que el Cliente incumpla con el pago por concepto de la reparación y/o mantenimiento del vehículo, el Distribuidor le notificará por escrito su incumplimiento y podrá exigirle la rescisión o cumplimiento del contrato por mora, más la pena convencional del <b>0</b>% del monto total de la operación. Las penas convencionales deberán ser equitativas y de la misma magnitud para las partes.</div>
			<div class="col-over-content">12. El Consumidor deberá recoger el vehículo en la fecha y lugar establecida en el presente contrato, en caso contrario, se obliga a pagar al Distribuidor, la cantidad que resulte por concepto de almacenaje del vehículo por cada día que transcurra, tomando como referencia una tarifa no mayor al precio general establecido para estacionamientos públicos ubicados en la localidad del Distribuidor. Transcurrido un plazo de 15 días naturales a partir de la fecha señalada para la entrega del vehículo, y el Cliente no acuda a recoger el mismo, el Distribuidor sin responsabilidad alguna, pondrá a disposición de la autoridad correspondiente dicho vehículo. Sin perjuicio de lo anteior, el Distribuidor podrá realizar el cobro correspondiente por concepto de almacenaje.</div>
			<div class="col-over-content">13. El Distribuidor se obliga a expedir la factura o comprobante de pago por la operaciones efectuadas, en la cual se especificarán los precios por mano de obra, refacciones, materiales y accesorios empleados, así como la garantía que en su caso se otorgue, conforme al artículo 62 de la Ley Federal de Protección al Consumidor.</div>
			<div class="col-over-content">14. El Distribuidor se obliga a: (i) No ceder o transmitir a terceros, con fines mercadoténicos o publicitarios, los datos e información proporcionada por el consumidor con motivo del presente contrato (ii) No enviar publicidad sobre bienes o servicios, salvo autorización expresa del consumidor en la presente cláusula.</div>
			<div class="col-over-content">
				<img src="<?=$firma_cliente["firma"]?>" class="firma_cliente" alt="firma del cliente"><br/>Firma o rúbrica de autorización del consumidor
			</div>
			<div class="col-over-content">15. Las partes están de acuerdo en someterse a la competencia de la Procuraduría Federal del Consumidor en la vía administrativa para resolver cualquier controversia que se suscite sobre la interpretación o cumplimiento de los términos y condiciones del presente contrato y de las disposiciones de la Ley Federal de Protección al Consumidor, la Norma Oficial Mexicana NOM-174-SCFI-2007, Prácticas comerciales-Elementos de información para la prestación de servicios en general y cualquier otra disposición aplicable, sin perjuicio del derecho que tienen las partes de someterse a la jurisdicción de los Tribunales competentes del domicilio del Distribuidor, renunciando las partes expresamente a cualquier otra jurisdicción que pudiera corresponderles por razón de sus domicilios futuros.</div>
			<div class="col-over-content">16. El Cliente y el Distribuidor aceptan la realización de la prestación del servicio de reparación y/o mantenimiento, en los términos establecidos en este contrato, y sabedores de su alcance legal, lo firman por duplicado.</div>
			<div class="col-over-sign">
				<p>EL DISTRIBUIDOR</p>
				<img src="<?=$sucursal["firma"]?>" class="firma_cliente" alt="firma del asesor" style="margin-top:-10px;">
				<p style="font-size: 9px; margin: -5px;"><?=$sucursal["razon_social"]?></p>
				<p style="font-size: 9px; margin: 4px;">Firma</p>
			</div>
			<div class="col-over-sign2">
				<p>EL CLIENTE</p>
				<img src="<?=$firma_cliente["firma"]?>" class="firma_cliente" alt="firma del cliente" style="margin-top:-10px;">
				<p style="font-size: 9px; margin: -5px;"><?=$cliente["nombre_cliente"]." ".$cliente["ap_cliente"]." ".$cliente["am_cliente"]?></p>
				<p style="font-size: 9px; margin: 4px;">Firma</p>
			</div>
			<div class="col-over-content" style="font-size:9px;margin-top:-22px;">(*) El presente contrato fue registrado en la Procuraduría Federal del Consumidor bajo el número 3597­2018 de fecha 08 de mayo del 2018. <br>
				*LFPC.- Ley Federal de Protección al Consumidor</div>
		</div>

	</body>
	<script>
		(function () {
			html2canvas($("body"),{
				onrendered:function(canvas){
					img = canvas.toDataURL("image/png");
					localStorage.setItem("formato_base64", img);
				}
			});
		})();
	</script>
</html>