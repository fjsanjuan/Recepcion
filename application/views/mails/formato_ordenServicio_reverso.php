<!DOCTYPE html>
<html>
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" /> -->
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<head>
<link rel="stylesheet" href="<?=base_url()?>assets/librerias/fontawesome-free-5.2.0-web/css/all.css"/>
<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" media="all">
<link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">

<script src="<?=base_url()?>assets/js/jquery.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/librerias/html2canvas/html2canvas.js"></script>
<script src="<?=base_url()?>assets/librerias/html2canvas/html2canvas.min.js"></script>
<title>Orden de Servicio</title>
</head>
<script>
$( document ).ready(function() {
	var img = "";

	function genIMG()
	{
		html2canvas($(".subcuerpo_reverso"),{
		   onrendered:function(canvas){
			   img = canvas.toDataURL("image/png");
			   localStorage.setItem("formatoReverso_base64", img);
		   }
	    });
	}

	genIMG();
});
</script>
<style>
body {
	font-family: Arial;
}

.container {
  max-width: 1140px !important;
  max-height: 2667.5px !important;
  background: white !important;
}

.contenedor_reverso {
  color: black;
  font-size: 14px;
}

.encabezado_reverso p, .encabezado_reverso label{
  font-size: 12px;
  color: rgb(16, 35, 60);
  font-weight: bold;
  margin-bottom: 0px;
}

.input_bordeInferior_reverso{
  border: none;
  border-bottom: 1px solid #000;
  width: 70%;
  text-align: center;
  font-size: 12px;
}

.nombre_empresa {
  text-transform: uppercase;
}

.texto {
  font-size: 12px;
  text-align: justify;
}

.subtitulo {
  font-weight: bold;
  font-size: 12px;
  margin: 0;
  text-align: center;
}

.firma_cliente {
  width: 100%;
}
</style>
<body>
	<div class="subcuerpo_reverso">
	<br>
	<br>
	<div class="container contenedor_reverso">
		<div class="row encabezado_reverso">					    <!-- ENCABEZADO -->
			<div class="col-4">
				<p><?=$sucursal["razon_social"]?></p>
				<?php 
					$suc_domicilio = $reverso["dom_calle"]." No. ".$reverso["dom_numExt"].",  Colonia ".$reverso["dom_colonia"].", ".$reverso["dom_ciudad"].", ".$reverso["dom_estado"].", C.P. ".$reverso["dom_cp"].".";
				?>
				<p><?=$suc_domicilio?></p>
				<p>RFC: <?=$sucursal["rfc"]?></p>
				<br>
			</div>
			<div class="col-1"></div>
			<div class="col-4">
				<p>Horarios de Atención:</p>
				<?php 
					$horario = explode("\n", wordwrap($sucursal["horario_recep"], 31));
				?>
				<p><?=$horario[0]?></p>
				<p><?=$horario[1]?></p>
			</div>
			<div class="col-2">
				<label>Folio:</label>
				<input type="text" name="folio" id="folio" class="input_bordeInferior_reverso" value="<?=$cliente['MovID']?>">
				<label>Fecha:</label>
				<?php 
					$fecha_actual = date("d-m-Y");
					$hora_actual = date("H:i:s");
				?>
				<input type="text" name="fecha" id="fecha" class="input_bordeInferior_reverso" value="<?=$fecha_actual?>">
				<label>Hora:</label>
				<input type="text" name="hora" id="hora" class="input_bordeInferior_reverso" value="<?=$hora_actual?>">
			</div>
		</div>
		<div class="row encabezado_reverso">
			<div class="col-1"></div>
			<div class="col-3">
				<p>Tels.: <?=$sucursal["telefono"]?> </p>
			</div>
			<div class="col-6">
				<p>Mail: <?=$sucursal["email_contacto"]?> (Quejas y Reclamaciones)</p>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					CONTRATO DE PRESTACIÓN DE SERVICIO DE REPARACIÓN Y MANTENIMIENTO DE VEHICULOS QUE CELEBRAN POR UNA PARTE  <span class="nombre_empresa"><u><?=$sucursal["razon_social"]?></u></span>, DISTRIBUIDOR AUTORIZADO FORD Y POR LA OTRA EL CONSUMIDOR CUYO NOMBRE SE SEÑALA EN EL ANVERSO DEL PRESENTE, A QUIENES EN LO SUCESIVO Y PARA EFECTO DEL PRESENTE CONTRATO SE LE DENOMINARÁ "EL PROVEEDOR" Y "EL CONSUMIDOR", RESPECTIVAMENTE.
				</p>
			</div>
		</div>
		<div class="row">											<!-- DECLARACIONES -->
			<div class="col-12">
				<p class="subtitulo">DECLARACIONES</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					Las partes denominadas CONSUMIDOR y PROVEEDOR, se reconocen las personalidades con las cuales se ostentan y que se encuentran especificadas en este documento (orden de servicio y contrato), por lo cual, están dispuestas a sujetarse a las condiciones que se establecen en las siguientes:
				</p>
			</div>
		</div>
		<div class="row">											<!-- CLAUSULAS -->
			<div class="col-12">
				<p class="subtitulo">CLAÚSULAS</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					1.	Objeto: El PROVEEDOR realizará todas las operaciones de mantenimiento, reparaciones y composturas, solicitadas por el CONSUMIDOR que suscribe el presente contrato, a las que se someterá el vehículo que al anverso se detalla, para obtener las condiciones de funcionamiento de acuerdo a lo solicitado por el CONSUMIDOR y que serán realizadas a cargo y por cuenta del CONSUMIDOR. EL PROVEEDOR no condicionará en modo alguno la prestación de servicios de reparación o mantenimiento del vehículo, a la adquisición o renta de otros productos o servicios en el mismo establecimiento o en otro taller o agencia predeterminada. El precio total de los servicios contratados se establece en el presupuesto que forma parte del presente y se describe en su anverso; dicho precio será pagado por el CONSUMIDOR al recibo del vehículo reparado, o en su caso, al momento de ser celebrado el presente contrato, por concepto de anticipo, la cantidad que resulte conforme a lo que establece la cláusula 14, y el resto en la fecha de entrega del vehículo reparado; todo pago efectuado por el CONSUMIDOR deberá efectuarse en el establecimiento del PROVEEDOR al contado y en Moneda Nacional o extranjera al tipo de cambio vigente al día de pago, de contado, ya sea en efectivo, o mediante tarjeta de crédito o deposito o transferencia bancaria efectuada con anterioridad a la entrega del vehículo.
				</p>
			</div>
		</div>
		<div class="row">											<!-- DE LAS CONDICIONES GENERALES -->
			<div class="col-12">
				<p class="subtitulo">DE LAS CONDICIONES GENERALES:</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					2.	Las partes están de acuerdo en que las condiciones generales en las que se encuentra el automóvil de acuerdo con el inventario visual al momento de su recepción, son las que se definen en la orden de servicio-presupuesto que se encuentra al anverso del presente contrato.
				</p>
			</div>
		</div>
		<div class="row">											<!-- DEL DIAGNOSTICO Y DEL PRESUPUESTO. -->
			<div class="col-12">
				<p class="subtitulo">DEL DIAGNÓSTICO Y DEL PRESUPUESTO.</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					3.	Las partes convienen en que en caso de que el automóvil motivo de este contrato se deje en las instalaciones del PROVEEDOR para diagnóstico y presupuesto, éste, en un plazo no mayor de lo asentado en este contrato, realizará y entregará al CONSUMIDOR dicho diagnóstico y presupuesto en el que hará constar el precio detallado de las operaciones de mano de obra, de partes, reparación de partes, materiales, insumos, así como el tiempo en que se efectuarla la reparación para que, en su caso, el CONSUMIDOR lo apruebe. El presupuesto que así se entregue tendrá una vigencia de 3 días hábiles.
					<br>
					4.	El PROVEEDOR hace saber al CONSUMIDOR que al efectuar el diagnóstico a su automóvil, las posibles consecuencias son las señaladas en el anverso del presente contrato, por lo que de no aceptarse la reparación, el vehículo le será entregado en las condiciones en que fue recibido para el diagnóstico, excepto en caso de que como consecuencia inevitable resulte imposible o ineficaz para su funcionamiento así entregarlo, porque al entregarlo armado sin repararlo, sea posible que se cause un daño mayor al mismo vehículo, o su uso constituya un riesgo para el usuario o terceros, por causa no imputable al PROVEEDOR, caso en el cual este sólo se hará responsable de dichas consecuencias por causas imputables a él o sus empleados, el CONSUMIDOR enterado de esas consecuencias se responsabiliza de ellas.
					<br>
					5. El PROVEEDOR se obliga ante el CONSUMIDOR a respetar el presupuesto contenido en el presente contrato.
					<br>
					6.	El CONSUMIDOR se obliga pagar a el PROVEEDOR por el diagnóstico de su automóvil la cantidad de $ <u><?=$cliente["total_orden"]?></u> MONEDA NACIONAL), siempre y cuando no apruebe la reparación. En caso de autorizar la reparación, el diagnóstico no será cobrado.
				</p>
			</div>
		</div>
		<div class="row">											<!-- DE LA PRESTACION DE SERVICIOS -->
			<div class="col-12">
				<p class="subtitulo">DE LA PRESTACIÓN DE SERVICIOS</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					7.	Las partes convienen en que la fecha de aceptación del presupuesto es la que se indica en el anverso de este contrato.
					<br>
					8.	El PROVEEDOR se obliga a hacer la entrega del automóvil reparado el día previamente establecido en el presupuesto. El PROVEEDOR se obliga a emplear partes y refacciones nuevas apropiadas para los servicios contratados salvo que el CONSUMIDOR ordene o autorice expresamente y por escrito se utilicen otras o las provea, de conformidad con lo establecido en el artículo 60 de la Ley Federal de Protección al Consumidor, caso en el cual la reparación no tendrá garantía en lo que se relacione a esas partes y refacciones, o a lo que éstas afecten, salvo en cuanto a la mano de obra que haya correspondido a su colocación. El retraso en la entrega de las refacciones por parte del CONSUMIDOR, si éste se compromete a proporcionarías, prorrogará por el mismo lapso de demora, la fecha de entrega del vehículo.
					<br>
					9.	El CONSUMIDOR, puede desistir en cualquier momento de la prestación del servicio, pagando al PROVEEDOR el importe por los trabajos efectuados y partes colocadas o adquiridas, hasta el retiro del automóvil; en éste caso, las refacciones adquiridas y que no hayan sido colocadas en el vehículo a repararse, serán entregadas al CONSUMIDOR.
					<br>
					10.	El PROVEEDOR, podrá utilizar el automóvil solo para recorridos de prueba, dentro de un radio de máximo 15 (quince) kilómetros alrededor del local en el que se presta el servicio, a efecto de realizar pruebas o verificar las reparaciones efectuadas; el PROVEEDOR no podrá usar el vehículo para fines propios o de terceros. El PROVEEDOR se hace responsable por los daños causados al vehículo, como consecuencia de los recorridos de prueba efectuados por parte de su personal. Cuando el CONSUMIDOR, solicite que él o un representante suyo sea quien conduzca el automóvil en un recorrido de prueba, el riesgo, será por su cuenta.
					<br>
					11.	El PROVEEDOR se hace responsable por las posibles descomposturas, daños o pérdidas parciales o totales imputables a él o a sus subalternos que sufra el vehículo, el equipo y los aditamentos adicionales que el CONSUMIDOR le haya notificado que existen en el momento de la recepción del mismo, o que se causen a terceros, mientras el vehículo se encuentre bajo su resguardo, salvo los ocasionados por desperfectos mecánicos o a resultas de piezas gastadas o sentidas, por incendio motivado por deficiencia de la instalación eléctrica, o fallas en el sistema de combustible, preexistentes y no causadas por el PROVEEDOR; para tal efecto el PROVEEDOR cuenta con un seguro suficiente para cubrir dichas eventualidades, bajo póliza expedida por compañía de seguros autorizada al efecto. El PROVEEDOR no se hace responsable por la pérdida de objetos dejados en el interior del automóvil, aun con la cajuela cerrada, salvo que estos le hayan sido notificados y puestos bajo su resguardo al momento de la recepción del automóvil. El PROVEEDOR tampoco se hace responsable por daños causados por fuerza mayor o caso fortuito, ni por la situación legal del automóvil cuando éste previamente haya sido robado o se hubiere utilizado en la comisión de algún ilícito; lo anterior, salvo que alguna de éstas cuestiones resultara legalmente imputable al PROVEEDOR; así mismo, el CONSUMIDOR, libera al PROVEEDOR de cualquier responsabilidad que surja o pueda surgir con relación al origen, posesión o cualquier otro derecho inherente al vehículo o a partes y componentes del mismo, obligándose en lo personal y en nombre del propietario, a responder de su procedencia.
				</p>
			</div>
		</div>
		<div class="row">											<!-- DEL PRECIO Y FORMAS DE PAGO -->
			<div class="col-12">
				<p class="subtitulo">DEL PRECIO Y FORMAS DE PAGO</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					12.	El CONSUMIDOR acepta haber tenido a su disposición :os precios de la tarifa de mano de obra, de las refacciones y materiales a usar en las reparaciones, ofrecidas por el PROVEEDOR; los incrementos que resulten durante la reparación, por costos no previsibles y/o incrementos que resulten al momento de la ejecución de la reparación ordenada, deberán ser autorizados por el CONSUMIDOR, por vía telefónica siempre y cuando estos no excedan del 20% presupuestado. Si el incremento citado es superior al 20%, el CONSUMIDOR lo tendrá que autorizar en forma escrita o por correo electrónico proveniente del mismo señalado como propio de él en el anverso del presente contrato. El tiempo que, en su caso, transcurra para cumplir ésta condición, modificará la fecha de entrega, en la misma proporción. Todas las quejas y sugerencias serán atendidas en el domicilio, correo, teléfonos y horarios de atención señalados en la parte superior del presente o en su anverso.
					<br>
					13.	Será obligación del PROVEEDOR expedir la factura correspondiente por los servicios y productos que preste o enajene; el importe total del servicio así como el precio por concepto de refacciones, mano de obra, materiales y accesorios quedará especificado en ella, conforme a la ley.
					<br>
					14.	El CONSUMIDOR se obliga a pagar de contado al PROVEEDOR (conforme a lo establecido en la cláusula 1), en las instalaciones de éste y previo a la entrega del automóvil, el importe de los trabajos efectuados y partes colocadas o adquiridas hasta el retiro del mismo, de conformidad con el presupuesto elaborado para tal efecto. En caso de reparaciones cuyo presupuesto sea superior a $15,000.00 (QUINCE MIL PESOS 00/100  M.N.) el CONSUMIDOR deberá pagar un anticipo del 50% sobre el monto del presupuesto elaborado, y el saldo restante lo pagará a la entrega del automóvil debidamente reparado.
				</p>
			</div>
		</div>
		<div class="row">											<!-- DE LA ENTREGA. -->
			<div class="col-12">
				<p class="subtitulo">DE LA ENTREGA.</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					15.	El PROVEEDOR se obliga a hacer la entrega del automóvil reparado en la fecha y hora establecida en este contrato, en las propias instalaciones del PROVEEDOR, pudiendo ampliarse dicho plazo en caso fortuito o de fuerza mayor, en cuyo caso será obligación del PROVEEDOR dar aviso previo al CONSUMIDOR de !a causa y del tiempo que se ampliará el plazo de entrega.
					<br>
					16.	Las refacciones reemplazadas en las reparaciones quedarán a disposición del CONSUMIDOR al momento de recoger el automóvil, salvo que éste exprese lo contrario o que las refacciones, partes o piezas sean las cambiadas en ejercicio de la garantía o se trate de residuos considerados peligrosos, de acuerdo con las disposiciones legales aplicables. Si el CONSUMIDOR, al recoger su automóvil se niega a recibir las partes reemplazadas, el PROVEEDOR podrá disponer de ellas.
					<br>
					17.	ELCONSUMIDOR se obliga a hacer el pago, a recoser el automóvil y, en su caso, las refacciones que fueran reemplazadas, dentro del horario establecido por el PROVEEDOR, en un término no mayor de 48 horas, contadas a partir del día y hora fijadas para su entrega, o bien de que se haya entregado el presupuesto y éste no hubiera sido autorizado. Si dentro de éste plazo el automóvil no pudiera circular por cualquier restricción, el plazo citado se ampliará 24 horas más. En caso de que el CONSUMIDOR no haga el pago y recoja el vehículo en el tiempo establecido, se obliga a pagar el almacenaje por la guarda del automóvil, caso en el que pagará la suma que resulte equivalente a 2 (dos) días de salario mínimo general vigente en la zona en la que se encuentran las instalaciones del PROVEEDOR, por cada día de retraso el cumplimiento de esas obligaciones. Si transcurridos 60 días naturales, contados a partir de la fecha en que debió entregarse el automóvil, no ha sido reclamado por el CONSUMIDOR, el PROVEEDOR notificará este hecho a las autoridades competentes y podrá dar inicio a las acciones legales que correspondan para el cobro de los servicios y/o refacciones otorgados, así como del almacenaje.
					<br>
					18.	En el momento en que el PROVEEDOR entregue y el CONSUMIDOR reciba el automóvil reparado, se entenderá que esto fue a completa satisfacción del CONSUMIDOR en lo que respecta a sus condiciones generales de acuerdo al inventario visual, mismas que fueron descritos en la orden de servicio, así como también en cuanto a la reparación efectuada, sin afectar sus derechos a ejercer la garantía.
				</p>
			</div>
		</div>
		<div class="row">											<!-- DE LA RESCISION Y PENAS CONVENCIONALES -->
			<div class="col-12">
				<p class="subtitulo">DE LA RESCISIÓN Y PENAS CONVENCIONALES</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					19.	Es causa de rescisión del presente contrato: A.- Que EL PROVEEDOR incumpla en la fecha, hora y lugar de entrega del vehículo por causas propias, caso en el cual el CONSUMIDOR notificará por escrito del incumplimiento al PROVEEDOR, y éste hará entrega inmediata del vehículo debidamente reparado conforme al diagnóstico y presupuesto establecido, descontando del precio pactado para la prestación del servicio, la suma equivalente al 2% (dos por ciento) del total de la reparación, que se pacta como pena convencional; B.- Que el CONSUMIDOR incumpla con el pago de la reparación ordenada, en el término previsto en la cláusula 19, caso en el cual el PROVEEDOR le notificará por escrito su incumplimiento, y podrá optar por exigir la recisión o cumplimiento forzoso de la obligación, cobrando la misma pena pactada del 2% al COSUMIDOR, por la mora.
				</p>
			</div>
		</div>
		<div class="row">											<!-- DE LAS GARANTIAS -->
			<div class="col-12">
				<p class="subtitulo">DE LAS GARANTÍAS</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					20.	<u>Las reparaciones a que se refiere el presupuesto aceptado por el CONSUMIDOR y éste contrato están garantizadas por 60 días naturales contados a partir de la fecha de la entrega  del vehículo ya reparado, en mano de obra y en las refacciones, piezas y accesorios,</u> y trabajos que por su naturaleza hayan tenido que ser realizados en otros talleres <u>tendrá la  especificada por el fabricante o taller respectivo, siempre y cuando no sea menor a la expresada, y no se manifieste mal uso, negligencia o descuido en el uso de ellas, de conformidad a  lo establecido en el artículo 77 de la Ley Federal de Protección al Consumidor.</u> Sí el vehículo es intervenido por un tercero, el PROVEEDOR no será responsable y la garantía quedara sin efecto. Las reclamaciones por garantía se harán en el establecimiento del PROVEEDOR, para lo cual el CONSUMIDOR deberá presentar su vehículo en dicho establecimiento. Las reparaciones efectuadas por el PROVEEDOR en cumplimiento a la garantía del servicio serán sin cargo alguno para el CONSUMIDOR, salvo aquellos trabajos que no deriven de las reparaciones aceptadas en el presupuesto. No se computará dentro del plazo de garantía el tiempo que dure la reparación y/o mantenimiento del vehículo para el cumplimiento de le misma. Esta garantía cubre cualquier falla, deficiencia o irregularidad relacionada con la reparación efectuada por el PROVEEDOR, por causas imputables al mismo y solo será válida siempre y cuando el automóvil se haya utilizado en condiciones de uso normal, se hayan observado en su uso las indicaciones de manejo y servicio que se le hubiera dado. En todo caso, el PROVEEDOR será corresponsable y solidario con los terceros del cumplimiento o incumplimiento de las garantías por ellos otorgadas en lo que se relacione a las piezas, refacciones y accesorios, colocadas en el vehículo y de los servicios a éste realizados, siempre que hayan sido contratados ante el CONSUMIDOR.
					<br>
					21.	Toda reclamación dentro del término de garantía, deberá ser realizada ante el PROVEEDOR que efectuó la reparación y en el domicilio del mismo indicado en el anverso del presente contrato. En caso de que sea necesario hacer válida la garantía en un domicilio diverso al del PROVEEDOR, los gastos por ello deberán ser cubiertos por éste, siempre y cuando la garantía proceda, dichos gastos sean indispensables para tal fin, y sea igualmente indispensable realizar la reparación del vehículo en domicilio diverso al del PROVEEDOR, pero en dado caso, si el automóvil fallase fuera de la entidad donde se localiza el PROVEEDOR, éste inmediatamente después de que tenga conocimiento de la falla o deficiencia, podrá indicar al CONSUMIDOR en donde se encuentra la agencia distribuidora de la marca más cercana, para hacer efectiva la garantía por conducto de ésta, si procede, debiendo acreditar con la factura correspondiente la reparación efectuada, con el objeto, de no hacer ningún cargo por ello al CONSUMIDOR. Con el objeto de dar cumplimiento a las obligaciones que ésta cláusula le impone, El PROVEEDOR señala como teléfonos de atención al CONSUMIDOR los que aparecen en éste contrato. Para los efectos de la atención y resolución de quejas y reclamaciones, estas deberán ser presentadas dentro de días y horas hábiles, que son los detallados en la parte superior del presente, ante la Gerencia de Servicio ubicada en las instalaciones del mismo PROVEEDOR, detallando en forma expresa la causa o motivo de la reclamación; la Gerencia de Servicio procederá a analizar la queja y resolverá lo conducente dentro de un lapso de tres días hábiles, procediendo a reparar el vehículo o manifestando las causas de improcedencia de la reclamación, en forma escrita.

				</p>
			</div>
		</div>
		<div class="row">											<!-- DE LA INFORMACION Y PUBLICIDAD -->
			<div class="col-12">
				<p class="subtitulo">DE LA INFORMACIÓN Y PUBLICIDAD</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					22.	El PROVEEDOR se obliga a observar en todo momento lo dispuesto por los capítulos III y IV de la Ley Federal de Protección al Consumidor, en cuanto a la información, publicidad, promociones y ofertas.
					<br>
					23.	El CONSUMIDOR SÍ (___) NO (___) acepta que el PROVEEDOR ceda o transmita a tercero, con fines mercadotécnicos o publicitarios, la información proporcionada por él con motivo del presente contrato, SÍ (___) NO (___) acepta que el PROVEEDOR le envíe publicidad sobre bienes y servicios, firmando en éste espacio	_____________________________________________________.
					<br>
					24.	La Procuraduría Federal del Consumidor, es competente para conocer y resolver en la vía administrativa de cualquier controversia que se suscite sobre la interpretación o cumplimiento del presente contrato, por lo que las partes están de acuerdo en someterse a ella en términos de ley, para resolver sobre la interpretación o cumplimiento de los términos del presente contrato y de las disposiciones de la Ley Federal de Protección al Consumidor, la Norma Oficial Mexicana NOM-174-SCFI-2007, Prácticas Comerciales- Elementos de Información para la Prestación de Servicios en General y cualquier otra disposición aplicable. Sin perjuicio de lo anterior en caso de persistir la inconformidad, las partes se someten a la jurisdicción de los tribunales competentes del domicilio del PROVEEDOR, renunciando en forma expresa a cualquier otra jurisdicción o al fuero que pudiera corresponderles en razón de sus domicilios presente o futuros o por cualquier otra razón.
				</p>
			</div>
		</div>
		<div class="row">										    <!-- FIRMAS -->
			<div class="col-1"></div>
			<div class="col-4">
				<img src="<?=$asesor["firma_electronica"]?>" class="firma_cliente" alt="firma del asesor">
			</div>
			<div class="col-2"></div>
			<div class="col-4">
				<img src="<?=$firma_cliente["firma"]?>" class="firma_cliente" alt="firma del cliente">
			</div>
			<div class="col-1"></div>
		</div>
		<div class="row">
			<div class="col-1"></div>
			<div class="col-4" style="text-align: center;">
				<p style="font-size: 10px; margin: 0px;"><?=$cliente["asesor"]?></p>
				<label>EL DISTRIBUIDOR (NOMBRE Y FIRMA)</label>
			</div>
			<div class="col-2"></div>
			<div class="col-4" style="text-align: center;">
				<p style="font-size: 10px; margin: 0px;"><?=$cliente["nombre_cliente"]." ".$cliente["ap_cliente"]." ".$cliente["am_cliente"]?></p>
				<label>EL CONSUMIDOR (NOMBRE Y FIRMA)</label>
			</div>
			<div class="col-1"></div>
		</div>
		<br>
		<div class="row">											<!-- AVISO DE PRIVACIDAD -->
			<div class="col-12">
				<p class="texto"><b>AVISO DE PRIVACIDAD</b></p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					El Aviso de Privacidad Integral podrá ser consultado en nuestra página en internet <?=$sucursal["sitio_web"]?>, o lo puede solicitar al correo electrónico  <?=$sucursal["email_contacto"]?>, u obtener personalmente en el Área	de Atención a la Privacidad, en nuestras instalaciones.
			
					____ Al marcar el recuadro precedente y remitir mis datos, otorgo mi consentimiento para que mis datos personales sean tratados conforme a lo señalado en el Aviso de Privacidad.
					
					Este contrato fue registrado ante la Procuraduría Federal del Consumidor. Registro público de contratos de adhesión y aprobado e inscrito con el número _<?=$sucursal["noyexpediente"]?>, de fecha 8 de enero de 2016.
					
					Cualquier variación del presente contrato en perjuicio de EL CONSUMIDOR, frente al contrato de adhesión registrado, se tendrá por no puesta.
				</p>
			</div>
		</div>
	</div>
	</div>
</body>
</html>