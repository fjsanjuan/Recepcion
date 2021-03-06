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
				<p>Horarios de Atenci??n:</p>
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
					CONTRATO DE PRESTACI??N DE SERVICIO DE REPARACI??N Y MANTENIMIENTO DE VEHICULOS QUE CELEBRAN POR UNA PARTE  <span class="nombre_empresa"><u><?=$sucursal["razon_social"]?></u></span>, DISTRIBUIDOR AUTORIZADO FORD Y POR LA OTRA EL CONSUMIDOR CUYO NOMBRE SE SE??ALA EN EL ANVERSO DEL PRESENTE, A QUIENES EN LO SUCESIVO Y PARA EFECTO DEL PRESENTE CONTRATO SE LE DENOMINAR?? "EL PROVEEDOR" Y "EL CONSUMIDOR", RESPECTIVAMENTE.
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
					Las partes denominadas CONSUMIDOR y PROVEEDOR, se reconocen las personalidades con las cuales se ostentan y que se encuentran especificadas en este documento (orden de servicio y contrato), por lo cual, est??n dispuestas a sujetarse a las condiciones que se establecen en las siguientes:
				</p>
			</div>
		</div>
		<div class="row">											<!-- CLAUSULAS -->
			<div class="col-12">
				<p class="subtitulo">CLA??SULAS</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					1.	Objeto: El PROVEEDOR realizar?? todas las operaciones de mantenimiento, reparaciones y composturas, solicitadas por el CONSUMIDOR que suscribe el presente contrato, a las que se someter?? el veh??culo que al anverso se detalla, para obtener las condiciones de funcionamiento de acuerdo a lo solicitado por el CONSUMIDOR y que ser??n realizadas a cargo y por cuenta del CONSUMIDOR. EL PROVEEDOR no condicionar?? en modo alguno la prestaci??n de servicios de reparaci??n o mantenimiento del veh??culo, a la adquisici??n o renta de otros productos o servicios en el mismo establecimiento o en otro taller o agencia predeterminada. El precio total de los servicios contratados se establece en el presupuesto que forma parte del presente y se describe en su anverso; dicho precio ser?? pagado por el CONSUMIDOR al recibo del veh??culo reparado, o en su caso, al momento de ser celebrado el presente contrato, por concepto de anticipo, la cantidad que resulte conforme a lo que establece la cl??usula 14, y el resto en la fecha de entrega del veh??culo reparado; todo pago efectuado por el CONSUMIDOR deber?? efectuarse en el establecimiento del PROVEEDOR al contado y en Moneda Nacional o extranjera al tipo de cambio vigente al d??a de pago, de contado, ya sea en efectivo, o mediante tarjeta de cr??dito o deposito o transferencia bancaria efectuada con anterioridad a la entrega del veh??culo.
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
					2.	Las partes est??n de acuerdo en que las condiciones generales en las que se encuentra el autom??vil de acuerdo con el inventario visual al momento de su recepci??n, son las que se definen en la orden de servicio-presupuesto que se encuentra al anverso del presente contrato.
				</p>
			</div>
		</div>
		<div class="row">											<!-- DEL DIAGNOSTICO Y DEL PRESUPUESTO. -->
			<div class="col-12">
				<p class="subtitulo">DEL DIAGN??STICO Y DEL PRESUPUESTO.</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					3.	Las partes convienen en que en caso de que el autom??vil motivo de este contrato se deje en las instalaciones del PROVEEDOR para diagn??stico y presupuesto, ??ste, en un plazo no mayor de lo asentado en este contrato, realizar?? y entregar?? al CONSUMIDOR dicho diagn??stico y presupuesto en el que har?? constar el precio detallado de las operaciones de mano de obra, de partes, reparaci??n de partes, materiales, insumos, as?? como el tiempo en que se efectuarla la reparaci??n para que, en su caso, el CONSUMIDOR lo apruebe. El presupuesto que as?? se entregue tendr?? una vigencia de 3 d??as h??biles.
					<br>
					4.	El PROVEEDOR hace saber al CONSUMIDOR que al efectuar el diagn??stico a su autom??vil, las posibles consecuencias son las se??aladas en el anverso del presente contrato, por lo que de no aceptarse la reparaci??n, el veh??culo le ser?? entregado en las condiciones en que fue recibido para el diagn??stico, excepto en caso de que como consecuencia inevitable resulte imposible o ineficaz para su funcionamiento as?? entregarlo, porque al entregarlo armado sin repararlo, sea posible que se cause un da??o mayor al mismo veh??culo, o su uso constituya un riesgo para el usuario o terceros, por causa no imputable al PROVEEDOR, caso en el cual este s??lo se har?? responsable de dichas consecuencias por causas imputables a ??l o sus empleados, el CONSUMIDOR enterado de esas consecuencias se responsabiliza de ellas.
					<br>
					5. El PROVEEDOR se obliga ante el CONSUMIDOR a respetar el presupuesto contenido en el presente contrato.
					<br>
					6.	El CONSUMIDOR se obliga pagar a el PROVEEDOR por el diagn??stico de su autom??vil la cantidad de $ <u><?=$cliente["total_orden"]?></u> MONEDA NACIONAL), siempre y cuando no apruebe la reparaci??n. En caso de autorizar la reparaci??n, el diagn??stico no ser?? cobrado.
				</p>
			</div>
		</div>
		<div class="row">											<!-- DE LA PRESTACION DE SERVICIOS -->
			<div class="col-12">
				<p class="subtitulo">DE LA PRESTACI??N DE SERVICIOS</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					7.	Las partes convienen en que la fecha de aceptaci??n del presupuesto es la que se indica en el anverso de este contrato.
					<br>
					8.	El PROVEEDOR se obliga a hacer la entrega del autom??vil reparado el d??a previamente establecido en el presupuesto. El PROVEEDOR se obliga a emplear partes y refacciones nuevas apropiadas para los servicios contratados salvo que el CONSUMIDOR ordene o autorice expresamente y por escrito se utilicen otras o las provea, de conformidad con lo establecido en el art??culo 60 de la Ley Federal de Protecci??n al Consumidor, caso en el cual la reparaci??n no tendr?? garant??a en lo que se relacione a esas partes y refacciones, o a lo que ??stas afecten, salvo en cuanto a la mano de obra que haya correspondido a su colocaci??n. El retraso en la entrega de las refacciones por parte del CONSUMIDOR, si ??ste se compromete a proporcionar??as, prorrogar?? por el mismo lapso de demora, la fecha de entrega del veh??culo.
					<br>
					9.	El CONSUMIDOR, puede desistir en cualquier momento de la prestaci??n del servicio, pagando al PROVEEDOR el importe por los trabajos efectuados y partes colocadas o adquiridas, hasta el retiro del autom??vil; en ??ste caso, las refacciones adquiridas y que no hayan sido colocadas en el veh??culo a repararse, ser??n entregadas al CONSUMIDOR.
					<br>
					10.	El PROVEEDOR, podr?? utilizar el autom??vil solo para recorridos de prueba, dentro de un radio de m??ximo 15 (quince) kil??metros alrededor del local en el que se presta el servicio, a efecto de realizar pruebas o verificar las reparaciones efectuadas; el PROVEEDOR no podr?? usar el veh??culo para fines propios o de terceros. El PROVEEDOR se hace responsable por los da??os causados al veh??culo, como consecuencia de los recorridos de prueba efectuados por parte de su personal. Cuando el CONSUMIDOR, solicite que ??l o un representante suyo sea quien conduzca el autom??vil en un recorrido de prueba, el riesgo, ser?? por su cuenta.
					<br>
					11.	El PROVEEDOR se hace responsable por las posibles descomposturas, da??os o p??rdidas parciales o totales imputables a ??l o a sus subalternos que sufra el veh??culo, el equipo y los aditamentos adicionales que el CONSUMIDOR le haya notificado que existen en el momento de la recepci??n del mismo, o que se causen a terceros, mientras el veh??culo se encuentre bajo su resguardo, salvo los ocasionados por desperfectos mec??nicos o a resultas de piezas gastadas o sentidas, por incendio motivado por deficiencia de la instalaci??n el??ctrica, o fallas en el sistema de combustible, preexistentes y no causadas por el PROVEEDOR; para tal efecto el PROVEEDOR cuenta con un seguro suficiente para cubrir dichas eventualidades, bajo p??liza expedida por compa????a de seguros autorizada al efecto. El PROVEEDOR no se hace responsable por la p??rdida de objetos dejados en el interior del autom??vil, aun con la cajuela cerrada, salvo que estos le hayan sido notificados y puestos bajo su resguardo al momento de la recepci??n del autom??vil. El PROVEEDOR tampoco se hace responsable por da??os causados por fuerza mayor o caso fortuito, ni por la situaci??n legal del autom??vil cuando ??ste previamente haya sido robado o se hubiere utilizado en la comisi??n de alg??n il??cito; lo anterior, salvo que alguna de ??stas cuestiones resultara legalmente imputable al PROVEEDOR; as?? mismo, el CONSUMIDOR, libera al PROVEEDOR de cualquier responsabilidad que surja o pueda surgir con relaci??n al origen, posesi??n o cualquier otro derecho inherente al veh??culo o a partes y componentes del mismo, oblig??ndose en lo personal y en nombre del propietario, a responder de su procedencia.
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
					12.	El CONSUMIDOR acepta haber tenido a su disposici??n :os precios de la tarifa de mano de obra, de las refacciones y materiales a usar en las reparaciones, ofrecidas por el PROVEEDOR; los incrementos que resulten durante la reparaci??n, por costos no previsibles y/o incrementos que resulten al momento de la ejecuci??n de la reparaci??n ordenada, deber??n ser autorizados por el CONSUMIDOR, por v??a telef??nica siempre y cuando estos no excedan del 20% presupuestado. Si el incremento citado es superior al 20%, el CONSUMIDOR lo tendr?? que autorizar en forma escrita o por correo electr??nico proveniente del mismo se??alado como propio de ??l en el anverso del presente contrato. El tiempo que, en su caso, transcurra para cumplir ??sta condici??n, modificar?? la fecha de entrega, en la misma proporci??n. Todas las quejas y sugerencias ser??n atendidas en el domicilio, correo, tel??fonos y horarios de atenci??n se??alados en la parte superior del presente o en su anverso.
					<br>
					13.	Ser?? obligaci??n del PROVEEDOR expedir la factura correspondiente por los servicios y productos que preste o enajene; el importe total del servicio as?? como el precio por concepto de refacciones, mano de obra, materiales y accesorios quedar?? especificado en ella, conforme a la ley.
					<br>
					14.	El CONSUMIDOR se obliga a pagar de contado al PROVEEDOR (conforme a lo establecido en la cl??usula 1), en las instalaciones de ??ste y previo a la entrega del autom??vil, el importe de los trabajos efectuados y partes colocadas o adquiridas hasta el retiro del mismo, de conformidad con el presupuesto elaborado para tal efecto. En caso de reparaciones cuyo presupuesto sea superior a $15,000.00 (QUINCE MIL PESOS 00/100  M.N.) el CONSUMIDOR deber?? pagar un anticipo del 50% sobre el monto del presupuesto elaborado, y el saldo restante lo pagar?? a la entrega del autom??vil debidamente reparado.
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
					15.	El PROVEEDOR se obliga a hacer la entrega del autom??vil reparado en la fecha y hora establecida en este contrato, en las propias instalaciones del PROVEEDOR, pudiendo ampliarse dicho plazo en caso fortuito o de fuerza mayor, en cuyo caso ser?? obligaci??n del PROVEEDOR dar aviso previo al CONSUMIDOR de !a causa y del tiempo que se ampliar?? el plazo de entrega.
					<br>
					16.	Las refacciones reemplazadas en las reparaciones quedar??n a disposici??n del CONSUMIDOR al momento de recoger el autom??vil, salvo que ??ste exprese lo contrario o que las refacciones, partes o piezas sean las cambiadas en ejercicio de la garant??a o se trate de residuos considerados peligrosos, de acuerdo con las disposiciones legales aplicables. Si el CONSUMIDOR, al recoger su autom??vil se niega a recibir las partes reemplazadas, el PROVEEDOR podr?? disponer de ellas.
					<br>
					17.	ELCONSUMIDOR se obliga a hacer el pago, a recoser el autom??vil y, en su caso, las refacciones que fueran reemplazadas, dentro del horario establecido por el PROVEEDOR, en un t??rmino no mayor de 48 horas, contadas a partir del d??a y hora fijadas para su entrega, o bien de que se haya entregado el presupuesto y ??ste no hubiera sido autorizado. Si dentro de ??ste plazo el autom??vil no pudiera circular por cualquier restricci??n, el plazo citado se ampliar?? 24 horas m??s. En caso de que el CONSUMIDOR no haga el pago y recoja el veh??culo en el tiempo establecido, se obliga a pagar el almacenaje por la guarda del autom??vil, caso en el que pagar?? la suma que resulte equivalente a 2 (dos) d??as de salario m??nimo general vigente en la zona en la que se encuentran las instalaciones del PROVEEDOR, por cada d??a de retraso el cumplimiento de esas obligaciones. Si transcurridos 60 d??as naturales, contados a partir de la fecha en que debi?? entregarse el autom??vil, no ha sido reclamado por el CONSUMIDOR, el PROVEEDOR notificar?? este hecho a las autoridades competentes y podr?? dar inicio a las acciones legales que correspondan para el cobro de los servicios y/o refacciones otorgados, as?? como del almacenaje.
					<br>
					18.	En el momento en que el PROVEEDOR entregue y el CONSUMIDOR reciba el autom??vil reparado, se entender?? que esto fue a completa satisfacci??n del CONSUMIDOR en lo que respecta a sus condiciones generales de acuerdo al inventario visual, mismas que fueron descritos en la orden de servicio, as?? como tambi??n en cuanto a la reparaci??n efectuada, sin afectar sus derechos a ejercer la garant??a.
				</p>
			</div>
		</div>
		<div class="row">											<!-- DE LA RESCISION Y PENAS CONVENCIONALES -->
			<div class="col-12">
				<p class="subtitulo">DE LA RESCISI??N Y PENAS CONVENCIONALES</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					19.	Es causa de rescisi??n del presente contrato: A.- Que EL PROVEEDOR incumpla en la fecha, hora y lugar de entrega del veh??culo por causas propias, caso en el cual el CONSUMIDOR notificar?? por escrito del incumplimiento al PROVEEDOR, y ??ste har?? entrega inmediata del veh??culo debidamente reparado conforme al diagn??stico y presupuesto establecido, descontando del precio pactado para la prestaci??n del servicio, la suma equivalente al 2% (dos por ciento) del total de la reparaci??n, que se pacta como pena convencional; B.- Que el CONSUMIDOR incumpla con el pago de la reparaci??n ordenada, en el t??rmino previsto en la cl??usula 19, caso en el cual el PROVEEDOR le notificar?? por escrito su incumplimiento, y podr?? optar por exigir la recisi??n o cumplimiento forzoso de la obligaci??n, cobrando la misma pena pactada del 2% al COSUMIDOR, por la mora.
				</p>
			</div>
		</div>
		<div class="row">											<!-- DE LAS GARANTIAS -->
			<div class="col-12">
				<p class="subtitulo">DE LAS GARANT??AS</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					20.	<u>Las reparaciones a que se refiere el presupuesto aceptado por el CONSUMIDOR y ??ste contrato est??n garantizadas por 60 d??as naturales contados a partir de la fecha de la entrega  del veh??culo ya reparado, en mano de obra y en las refacciones, piezas y accesorios,</u> y trabajos que por su naturaleza hayan tenido que ser realizados en otros talleres <u>tendr?? la  especificada por el fabricante o taller respectivo, siempre y cuando no sea menor a la expresada, y no se manifieste mal uso, negligencia o descuido en el uso de ellas, de conformidad a  lo establecido en el art??culo 77 de la Ley Federal de Protecci??n al Consumidor.</u> S?? el veh??culo es intervenido por un tercero, el PROVEEDOR no ser?? responsable y la garant??a quedara sin efecto. Las reclamaciones por garant??a se har??n en el establecimiento del PROVEEDOR, para lo cual el CONSUMIDOR deber?? presentar su veh??culo en dicho establecimiento. Las reparaciones efectuadas por el PROVEEDOR en cumplimiento a la garant??a del servicio ser??n sin cargo alguno para el CONSUMIDOR, salvo aquellos trabajos que no deriven de las reparaciones aceptadas en el presupuesto. No se computar?? dentro del plazo de garant??a el tiempo que dure la reparaci??n y/o mantenimiento del veh??culo para el cumplimiento de le misma. Esta garant??a cubre cualquier falla, deficiencia o irregularidad relacionada con la reparaci??n efectuada por el PROVEEDOR, por causas imputables al mismo y solo ser?? v??lida siempre y cuando el autom??vil se haya utilizado en condiciones de uso normal, se hayan observado en su uso las indicaciones de manejo y servicio que se le hubiera dado. En todo caso, el PROVEEDOR ser?? corresponsable y solidario con los terceros del cumplimiento o incumplimiento de las garant??as por ellos otorgadas en lo que se relacione a las piezas, refacciones y accesorios, colocadas en el veh??culo y de los servicios a ??ste realizados, siempre que hayan sido contratados ante el CONSUMIDOR.
					<br>
					21.	Toda reclamaci??n dentro del t??rmino de garant??a, deber?? ser realizada ante el PROVEEDOR que efectu?? la reparaci??n y en el domicilio del mismo indicado en el anverso del presente contrato. En caso de que sea necesario hacer v??lida la garant??a en un domicilio diverso al del PROVEEDOR, los gastos por ello deber??n ser cubiertos por ??ste, siempre y cuando la garant??a proceda, dichos gastos sean indispensables para tal fin, y sea igualmente indispensable realizar la reparaci??n del veh??culo en domicilio diverso al del PROVEEDOR, pero en dado caso, si el autom??vil fallase fuera de la entidad donde se localiza el PROVEEDOR, ??ste inmediatamente despu??s de que tenga conocimiento de la falla o deficiencia, podr?? indicar al CONSUMIDOR en donde se encuentra la agencia distribuidora de la marca m??s cercana, para hacer efectiva la garant??a por conducto de ??sta, si procede, debiendo acreditar con la factura correspondiente la reparaci??n efectuada, con el objeto, de no hacer ning??n cargo por ello al CONSUMIDOR. Con el objeto de dar cumplimiento a las obligaciones que ??sta cl??usula le impone, El PROVEEDOR se??ala como tel??fonos de atenci??n al CONSUMIDOR los que aparecen en ??ste contrato. Para los efectos de la atenci??n y resoluci??n de quejas y reclamaciones, estas deber??n ser presentadas dentro de d??as y horas h??biles, que son los detallados en la parte superior del presente, ante la Gerencia de Servicio ubicada en las instalaciones del mismo PROVEEDOR, detallando en forma expresa la causa o motivo de la reclamaci??n; la Gerencia de Servicio proceder?? a analizar la queja y resolver?? lo conducente dentro de un lapso de tres d??as h??biles, procediendo a reparar el veh??culo o manifestando las causas de improcedencia de la reclamaci??n, en forma escrita.

				</p>
			</div>
		</div>
		<div class="row">											<!-- DE LA INFORMACION Y PUBLICIDAD -->
			<div class="col-12">
				<p class="subtitulo">DE LA INFORMACI??N Y PUBLICIDAD</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<p class="texto">
					22.	El PROVEEDOR se obliga a observar en todo momento lo dispuesto por los cap??tulos III y IV de la Ley Federal de Protecci??n al Consumidor, en cuanto a la informaci??n, publicidad, promociones y ofertas.
					<br>
					23.	El CONSUMIDOR S?? (___) NO (___) acepta que el PROVEEDOR ceda o transmita a tercero, con fines mercadot??cnicos o publicitarios, la informaci??n proporcionada por ??l con motivo del presente contrato, S?? (___) NO (___) acepta que el PROVEEDOR le env??e publicidad sobre bienes y servicios, firmando en ??ste espacio	_____________________________________________________.
					<br>
					24.	La Procuradur??a Federal del Consumidor, es competente para conocer y resolver en la v??a administrativa de cualquier controversia que se suscite sobre la interpretaci??n o cumplimiento del presente contrato, por lo que las partes est??n de acuerdo en someterse a ella en t??rminos de ley, para resolver sobre la interpretaci??n o cumplimiento de los t??rminos del presente contrato y de las disposiciones de la Ley Federal de Protecci??n al Consumidor, la Norma Oficial Mexicana NOM-174-SCFI-2007, Pr??cticas Comerciales- Elementos de Informaci??n para la Prestaci??n de Servicios en General y cualquier otra disposici??n aplicable. Sin perjuicio de lo anterior en caso de persistir la inconformidad, las partes se someten a la jurisdicci??n de los tribunales competentes del domicilio del PROVEEDOR, renunciando en forma expresa a cualquier otra jurisdicci??n o al fuero que pudiera corresponderles en raz??n de sus domicilios presente o futuros o por cualquier otra raz??n.
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
					El Aviso de Privacidad Integral podr?? ser consultado en nuestra p??gina en internet <?=$sucursal["sitio_web"]?>, o lo puede solicitar al correo electr??nico  <?=$sucursal["email_contacto"]?>, u obtener personalmente en el ??rea	de Atenci??n a la Privacidad, en nuestras instalaciones.
			
					____ Al marcar el recuadro precedente y remitir mis datos, otorgo mi consentimiento para que mis datos personales sean tratados conforme a lo se??alado en el Aviso de Privacidad.
					
					Este contrato fue registrado ante la Procuradur??a Federal del Consumidor. Registro p??blico de contratos de adhesi??n y aprobado e inscrito con el n??mero _<?=$sucursal["noyexpediente"]?>, de fecha 8 de enero de 2016.
					
					Cualquier variaci??n del presente contrato en perjuicio de EL CONSUMIDOR, frente al contrato de adhesi??n registrado, se tendr?? por no puesta.
				</p>
			</div>
		</div>
	</div>
	</div>
</body>
</html>