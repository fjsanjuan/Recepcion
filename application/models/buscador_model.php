<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*  
*     _____  ____  _____  _________  ________  _____     _____   ______   _____   ______   
*    |_   _||_   \|_   _||  _   _  ||_   __  ||_   _|   |_   _|.' ____ \ |_   _|.' ____ \  
*      | |    |   \ | |  |_/ | | \_|  | |_ \_|  | |       | |  | (___ \_|  | |  | (___ \_| 
*      | |    | |\ \| |      | |      |  _| _   | |   _   | |   _.____`.   | |   _.____`.  
*     _| |_  _| |_\   |_    _| |_    _| |__/ | _| |__/ | _| |_ | \____) | _| |_ | \____) | 
*    |_____||_____|\____|  |_____|  |________||________||_____| \______.'|_____| \______.' 
*                                                                                      
*    Author: Luis Fernando Zapien Perez
*	 Revision: Roberto Ortiz Gomez	Abril 2020
*/
class Buscador_Model extends CI_Model{

	private $Version = 'V6000';
	private $vista = 'PaquetesWeb';

	public function __construct()
	{
		parent::__construct();
		if ($this->Version == 'V6000') 
			$this->vista = "vwCA_PaquetesWeb";
	}
	
	public function busqueda($datos = null){
		$int = $this->load->database("other", TRUE);

		// print_r($datos);
		switch ($datos['tipo']) 
		{
			case '1':
				//$ret['resultado'] = $int->select("nombre as value, cliente as id")->from("Cte")->like("Nombre", $datos['busqueda'])->limit(20)->get()->result_array();
				$q= $datos['busqueda'];
				$var = implode("%", $q);
				//utf8_encode($var);
				//echo $var . '<br>';
        		$inver = array_reverse($q);  
        		$var2 = implode("%", $inver);

				$ret['resultado'] = $int->query("SELECT TOP 20 nombre as value, cliente as id, PersonalNombres + ' ' + PersonalNombres2  as nombre, PersonalApellidoPaterno as ap_paterno, PersonalApellidoMaterno as ap_materno FROM Cte WHERE Nombre  LIKE '%$var%' OR Nombre LIKE '%$var2%'")->result_array();
				$ret['estatus'] = "ok";
				//echo $int->last_query();
			break;

			case '2':
				$ret['resultado'] = $int->select("VIN as value, VIN as id, cte.cliente as id_cliente, PersonalNombres + ' ' + PersonalNombres2  as nombre, PersonalApellidoPaterno as ap_paterno, PersonalApellidoMaterno as ap_materno")->from("VIN")->join("cte","cte.Cliente=vin.Cliente","left")
					->like("VIN", $datos['busqueda'][0])->limit(20)->get()->result_array();
				// echo $int->last_query();
				$ret['estatus'] = "ok";
			break;

			case '3':
				$ret['resultado'] = $int->select("Placas as value, VIN as id, cte.cliente as id_cliente, PersonalNombres + ' ' + PersonalNombres2  as nombre, PersonalApellidoPaterno as ap_paterno, PersonalApellidoMaterno as ap_materno")->from("VIN")->join("cte","cte.Cliente=vin.Cliente","left")
				->like("Placas", $datos['busqueda'][0])->limit(20)->get()->result_array();
				$ret['estatus'] = "ok";
			break;

			default:
				$ret['estatus'] = "ko";
				$ret['resultado'] = false;
			break;
		}

		$int->close();
		return $ret;
	}

	public function traer_datos($datos = null){
		$int = $this->load->database("other", TRUE);
		$select = "CONVERT(date, vtn.FechaRequerida, 105 ) as fecha_requerida, vtn.HoraRequerida, vtn.HoraRecepcion, VIN.VIN, ag.Nombre as asesor, vtn.Comentarios, vtn.MovID";
		$tabla = "MovTipoValidarUEN";
		if ($this->Version == 'V6000') 
			$tabla = "CA_MovTipoValidarUEN";
		switch ($datos['tipo']) 
		{
			case '1':
				$select = "CONVERT(date, vtn.FechaRequerida, 105 ) as fecha_requerida, vtn.HoraRequerida, vtn.HoraRecepcion, VIN.VIN, ag.Nombre as asesor,vtn.Estatus as estatus ,vtn.Comentarios, vtn.MovID";
				$ret['cita'] = $int->select($select)->from("venta vtn")->join("VIN", "VIN.VIN = vtn.ServicioSerie")->join("Agente ag", "ag.Agente = vtn.Agente")
					->where("vtn.mov", "Cita Servicio")->where("vtn.estatus", "CONFIRMAR")->where("vtn.Cliente", $datos['id'])->get()->result_array();

				$id_cliente = $int->select("TOP(1) Cliente")->from("Cte")->where("Cliente", $datos['id'])->get()->result_array();
				
				$select =  "VIN.VIN, VIN.ColorExteriorDescripcion, Art.Descripcion1";
				$ret['vehiculos'] = $int->select($select)->from("VIN")->join("art", "art.Articulo = vin.Articulo")->where("VIN.cliente", $id_cliente[0]['Cliente'])->get()->result_array();
				$select = "Cte.Cliente, Cte.Nombre";
				$ret['Cliente'] = $int->select($select)->from("Cte")->where("Cte.Cliente", $datos['id'])->get()->row_array();
				$ret['estatus'] = "ok";
				$ret['us_select'] = $datos['id'];
				$ret['vin_selec'] = 0;
				$ret['art_select'] = 0;
				$ret['uen'] = $int->select("UEN.Nombre, UEN.UEN, muv.mov")->from("UEN")->join($tabla." muv", "muv.UENValida = UEN.UEN")->where("muv.Mov IN ('Servicio','Cita Servicio')")->where("UEN.Estatus",'ALTA')->get()->result_array();
				// echo $this->$int->last_query();die;
			break;	
			case '2':
			case '3':
				$ret['cita'] = $int->select($select)->from("venta vtn")->join("VIN", "VIN.VIN = vtn.ServicioSerie")->join("Agente ag", "ag.Agente = vtn.Agente")
					->where("vtn.mov", "Cita Servicio")->where("vtn.estatus", "CONFIRMAR")->where("VIN.VIN", $datos['id'])->get()->result_array();
				$select =  "VIN.VIN, VIN.ColorExteriorDescripcion, Art.Descripcion1, Art.Articulo";
				$ret['vehiculos'] = $int->select($select)->from("VIN")->join("art", "art.articulo = vin.articulo")->where("VIN.VIN", $datos['id'])->get()->result_array();
				$select = " ISNULL(Cte.Nombre, 'Sin cliente') as Nombre, ISNULL(Cte.Cliente, 0) as id";
				$ret['Cliente'] = $int->select($select)->from("Vin")->join("Cte", "Cte.Cliente = Vin.Cliente", "left")->where("Vin.Vin", $datos['id'])->get()->row_array();
				$ret['estatus'] = "ok";
				$ret['us_select'] = $ret['Cliente']['id'];
				$ret['vin_selec'] = $datos['id'];
				if(isset($ret['vehiculos'][0]['Articulo']))
				$ret['art_select'] = $ret['vehiculos'][0]['Articulo'];
				else
					$ret['art_select'] = "";
				$ret['uen'] = $int->select("UEN.Nombre, UEN.UEN, muv.mov")->from("UEN")->join($tabla." muv", "muv.UENValida = UEN.UEN")->where("muv.Mov IN ('Servicio','Cita Servicio')")->where("UEN.Estatus",'ALTA')->get()->result_array();
			break;
		}
		// echo $int->last_query();
		// print_r($ret);die;
		return $ret;
	}
	
	public function autocomplete($q){
		$this->db2 = $this->load->database('other',true); 

		$row_set[]=0;
		$var=implode("%", $q);
        $inver=array_reverse($q);  
        $var2=implode("%", $inver);

        $query = $this->db2->query("SELECT TOP 10 * FROM Cte WHERE Nombre  LIKE '%$var%' OR Nombre LIKE '%$var2%'");

		$arrglo = $query->result_array();

		foreach ($arrglo as $row) {
			$new_row['value'] = (''.$row['Nombre'].'');
			$new_row['dat'] = (''.$var.'');
			$new_row['id_cliente'] = ($row['Cliente']);
            $row_set[] = $new_row;
		}
		return $row_set;
	}
	public function autocomplete_art($q, $li){
		$this->db2 = $this->load->database('other',true); 
		$row_set[]=0;
		$var=implode("%", $q);
        $inver=array_reverse($q);  
        $var2=implode("%", $inver);
        if($li == "")
        {
        	$li = "(Precio Lista)";
        }
        $query = $this->db2->query("
	    	SELECT DISTINCT  TOP 10 art.Articulo,
			art.Descripcion1,
			art.Unidad,
			li.Precio,
			li.Lista,
			art.Tipo
			FROM
			Art art
			LEFT JOIN ListaPreciosD li ON Art.Articulo = li.Articulo and li.lista = ?
			WHERE
			art.Descripcion1 LIKE '%$var%' OR  art.Articulo LIKE '%$var%'", array($li));
        // AND art.Tipo = 'Normal'
	        // echo $this->db2->last_query();

		$arrglo = $query->result_array();

		// var_dump($arrglo);die;
		$logged_in = $this->session->userdata("logged_in");
		$almacen = $logged_in['almacen_refac'];
		foreach ($arrglo as $row) {
			$new_row['art'] = (''.$row['Descripcion1'].'');
			$new_row['descrip'] = ($row['Precio']);
			$new_row['clave_art'] = ($row['Articulo']);
			if($row['Tipo'] == "Normal"){
				$existencia =  $this->db2->select('Disponible')->from('ArtDisponible')->where('Articulo', $row['Articulo'])->where('Almacen', $almacen)->get()->row_array();
				$new_row['stock'] = ($existencia['Disponible'] != null)?$existencia['Disponible']:0;
			}
            $row_set[] = $new_row;
		}
		return $row_set;
	}
	// public function autocomplete_art($q, $li){
	// 	$this->db2 = $this->load->database('other',true); 
	// 	$row_set[]=0;
	// 	$var=implode("%", $q);
 //        $inver=array_reverse($q);  
 //        $var2=implode("%", $inver);

 //        if($li == "")
 //        {
 //        	$li = "(Precio Lista)";
 //        }
        
 //   //      $query = $this->db2->query("
	//   //   	SELECT DISTINCT  TOP 10 art.Articulo,
	// 		// art.Descripcion1,
	// 		// art.Unidad,
	// 		// li.Precio,
	// 		// li.Lista,
	// 		// art.Tipo
	// 		// FROM
	// 		// Art art
	// 		// LEFT JOIN ListaPreciosD li ON Art.Articulo = li.Articulo and li.lista = ?
	// 		// WHERE
	// 		// art.Descripcion1 LIKE '%$var%' OR  art.Articulo LIKE '%$var%'", array($li));
 //        $query = $this->db2->query("
	//     	SELECT DISTINCT  TOP 10 art.Articulo,
	// 		art.Descripcion1,
	// 		art.Unidad,
	// 		FLP.Precio,
	// 		art.Tipo
	// 		FROM
	// 		Art art
	// 		LEFT JOIN FordListaPrecios FLP ON Art.Articulo = FLP.Articulo
	// 		WHERE
	// 		art.Descripcion1 LIKE '%$var%' OR  art.Articulo LIKE '%$var%'");
 //        // AND art.Tipo = 'Normal'
	//         // echo $this->db2->last_query();

	// 	$arrglo = $query->result_array();

	// 	// var_dump($arrglo);die;
	// 	$logged_in = $this->session->userdata("logged_in");
	// 	$almacen = $logged_in['almacen_servicio'];
	// 	foreach ($arrglo as $row) {
	// 		$new_row['art'] = (''.$row['Descripcion1'].'');
	// 		$new_row['descrip'] = ($row['Precio']);
	// 		$new_row['clave_art'] = ($row['Articulo']);
	// 		if($row['Tipo'] == "Normal"){
	// 			$existencia =  $this->db2->select('Disponible')->from('FordArtDisponible')->where('Articulo', $row['Articulo'])->get()->row_array();
	// 			$new_row['stock'] = ($existencia['Disponible'] != null)?$existencia['Disponible']:0;
	// 		}
 //            $row_set[] = $new_row;
	// 	}
	// 	return $row_set;
	// }

	function autocomplete_mo($q){

		$this->db2 = $this->load->database('other',true); 
   //      $query = $this->db2->query("WITH tabla1 AS (
			// 	SELECT
			// 		art.Articulo,
			// 		art.Descripcion1,
			// 		art.Unidad,
			// 		ISNULL(li.Precio, 0) AS Precio,
			// 		ISNULL(li.Lista, 'Precio Publico') AS Lista
			// 	FROM
			// 		Art art
			// 	LEFT JOIN ListaPreciosD li ON Art.Articulo = li.Articulo
			// 	Inner JOIN OperacionesEreactValidas oert ON oert.Articulo = art.Articulo
			// 	WHERE
			// 		art.Tipo = 'Servicio'
			// 	AND art.Estatus = 'ALTA'
			// ) SELECT
			// 	Articulo,
			// 	Descripcion1,
			// 	Unidad,
			// 	Precio,
			// 	Lista
			// FROM
			// 	tabla1
			// WHERE
			// 	Lista = ?", array($q));

		 $query = $this->db2->query("WITH tabla1 AS (
				SELECT
					art.Articulo,
					art.Descripcion1,
					art.Unidad,
					ISNULL(li.Precio, 0) AS Precio,
					ISNULL(li.Lista, 'Precio Publico') AS Lista
				FROM
					Art art
				LEFT JOIN ListaPreciosD li ON Art.Articulo = li.Articulo

				WHERE
					art.Tipo = 'Servicio'
					AND art.categoria <> 'TOT'
			) SELECT
				Articulo,
				Descripcion1,
				Unidad,
				Precio,
				Lista
			FROM
		 	tabla1
			WHERE
				Lista = ?", array($q));
		//Excluido en script anterior
		 //Inner JOIN OperacionesEreactValidas oert ON oert.Articulo = art.Articulo
		 //AND art.Estatus = 'ALTA'
     	
        // echo $this->db2->last_query();
       
     	if($query->num_rows() > 0){
			return  $query->result_array();
		}else{
			return false;
		}
	}
	/* deprecated -- solo informativa */
	public function obtener_datos(){
		$this->db2 = $this->load->database('other',true);
		$query = $this->db2->query("SELECT DISTINCT
										Agente,PersonalNombres, PersonalApellidoPaterno, SucursalEmpresa
									FROM
										VistaAgenteDisponibilidad
									WHERE
										Estatus = 'ALTA'
									AND Tipo = 'Asesor'
									AND SucursalEmpresa = 22");
		$arrglo = $query->result_array();
		foreach ($arrglo as $row) {
			$new_row['id'] = (''.$row['Agente'].'');
			$new_row['title'] = ($row['Agente']. ' - '. $row['PersonalNombres']);
            $row_set[] = $new_row;
		}
		return $row_set;
	}

	/* regresar dos resultados diferentes por el parametro*/
	public function obtener_asesores($b, $sucursal){

		$this->db2 = $this->load->database('other', true);
		$query = $this->db2->query("SELECT * FROM Asesores2 WHERE Horario = '' AND Fecha >=  '01-07-2018' AND Sucursal=?", array($sucursal));
		$arreglo = $query->result_array();
		$asesores=array();
		$asesoresid = array();
		$sizearray = sizeof($arreglo,1);

		$a=0;
		for ($i=1; $i <= $sizearray ; $i++) { 
			if(empty($arreglo[0]["Agente".$i]) ){
				$x = 'Sin agentes';
			}else{
				$asesoresid[] = $arreglo[0]['Agente'.$i];
				$asesores[] = $arreglo[0]['Agente'.$i]."-".$arreglo[0]['Recep'.$i] ."-".$arreglo[0]['Entrega'.$i] ;
				$asesoresSep[] = explode('-', $asesores[$a]);
				$a++;			
			}
		}

		if($b == 1){
			if(empty($asesores)){
				return null;
			}
			return $asesoresid;
		}else{
			if(empty($asesoresSep)){
				return null;
			}else{
				for($a=0; $a<=9; $a++){
					$new_row['id'] = $asesoresSep[$a][0];
					$new_row['title'] = $asesoresSep[$a][1]." " . $asesoresSep[$a][2];
					$row_set[] = $new_row;

				}
			}

			return $row_set;
			}

		}

	//horarios de comida?
	function obtener_horario(){
		$this->db2 = $this->load->database('other',true);
		$query = $this->db2->query("SELECT DISTINCT
										Agente,
										SalidaComida,
										EntradaComida
									FROM
										VistaAgenteDisponibilidad
									WHERE Estatus = 'ALTA'
									AND Tipo = 'Asesor'
									AND SucursalEmpresa = 22
									AND SalidaComida >= DATEADD(day, DATEDIFF(day,0,GETDATE()),0) 
									AND SalidaComida <  DATEADD(day, DATEDIFF(day,0,GETDATE())+1,0) ");
		$arrglo = $query->result_array();
		$i=1;
		foreach ($arrglo as $row) {
			$new_row['id'] = $i.'cmda';
			$new_row['resourceId'] = (''.$row['Agente'].'');
			$new_row['start'] = $row['SalidaComida'];
			$new_row['end'] =   $row['EntradaComida'];
			$new_row['title'] ='Comida';
			$new_row['color'] = '#c0c0c0';
			$i++;
			$row_set[] = $new_row;
			}			
		return $row_set;
	}


	function citas_asesor_dia($data)
	{

		$logged_in =  $this->session->userdata("logged_in");
		$agente    =  $logged_in["cve_intelisis"];
		$dia       =  $data['dia'];
		$newDate = date("d-m-Y", strtotime($dia['dia']));
	
		$this->db2 =  $this->load->database("other", true);
		if($this->session->userdata["logged_in"]["perfil"] == 2){//recepcionista{
			$query = $this->db2->query("SELECT DISTINCT vw.HoraCita, vw.idCita, vw.NoCita, vw.Nombre, vw.NombreCliente, vw.Ap_PatCliente, vw.Ap_MatCliente,vw.Telefono, vw.VIN, vw.VehiculoDescripcion, vw.Modelo, vw.Color, vw.Placas, vw.HoraPromesa, Ag.Nombre AS Nombre_asesor, vw.CFechaLlegada, vw.CFechaAtencion 
				FROM vwCitasServicioWeb vw 
				INNER JOIN Agente ag ON vw.Asesor= Ag.Agente 
				WHERE FechaCita = ? 
				AND Sucursal = ?
				ORDER BY HoraCita", array($newDate,$logged_in["sucursal_int"]));

		}else{
			$query = $this->db2->query("SELECT DISTINCT vw.HoraCita, vw.idCita, vw.NoCita, vw.Nombre, vw.NombreCliente, vw.Ap_PatCliente, vw.Ap_MatCliente,vw.Telefono, vw.VIN, vw.VehiculoDescripcion, vw.Modelo, vw.Color, vw.Placas, vw.HoraPromesa, Ag.Nombre AS Nombre_asesor, vw.CFechaLlegada, vw.CFechaAtencion 
				FROM vwCitasServicioWeb vw 
				INNER JOIN Agente ag ON vw.Asesor = Ag.Agente 
				WHERE Asesor = ?  
					AND FechaCita = ? 
				ORDER BY HoraCita", array($agente,$newDate));
		}

		// echo $this->db2->last_query();

		if($query->num_rows() > 0){
			return $query->result_array();
		}else
			return false;
	}

	function obtener_citas_por_asesor()
	{

		$logged_in =  $this->session->userdata("logged_in");
		$agente    =  $logged_in["cve_intelisis"];
		$this->db2 =  $this->load->database("other", true);
		$fecha_actual = date("d-m-Y");

		if($this->session->userdata["logged_in"]["perfil"] == 2)//recepcionista
		{
			$query = $this->db2->query("SELECT DISTINCT vw.HoraCita, vw.idCita, vw.NoCita, vw.Nombre, vw.NombreCliente, vw.Ap_PatCliente, vw.Ap_MatCliente,vw.Telefono, vw.VIN, vw.VehiculoDescripcion, vw.Modelo, vw.Color, vw.Placas, vw.HoraPromesa, Ag.Nombre AS Nombre_asesor, vw.CFechaLlegada, vw.CFechaAtencion 
				FROM vwCitasServicioWeb vw
				INNER JOIN Agente Ag ON vw.Asesor = Ag.Agente
				WHERE vw.FechaCita = '".$fecha_actual."' 
				AND vw.Sucursal = ".$logged_in["sucursal_int"]." 
				ORDER BY vw.HoraCita");
		}else 
		{
			$query = $this->db2->query("SELECT DISTINCT HoraCita, idCita, NoCita, Nombre, Telefono, VIN, VehiculoDescripcion, Modelo, Color, Placas, HoraPromesa, NombreCliente, Ap_PatCliente, Ap_MatCliente,CFechaLlegada 
				FROM vwCitasServicioWeb 
				WHERE Asesor = ?  
					AND FechaCita = ? 
				ORDER BY HoraCita", array($agente, $fecha_actual));
		}

		if($query->num_rows() > 0){
			return $query->result_array();
		}else
			return null;
	}


	function obtener_citas(){
		$bandera = 1;
		$logged_in = $this->session->userdata("logged_in");
		$sucursal= $logged_in["id_sucursal"];
		$filtros = $this->obtener_asesores($bandera, $sucursal);
		$filtersize = sizeof($filtros);
		$filtersize = $filtersize +1;
		$this->db2 = $this->load->database("other", true);
				//$array = $query->result_array();
				//var_dump($array);
				//$sizearray = count($array);
		$a=0;
		for ($i=1; $i < $filtersize ; $i++) {
				$query = $this->db2->query("SELECT Agente".$i." AS Agente, Recep".$i." AS Recepcion, Entrega".$i." AS Entrega,  Fecha, Horario From Asesores2 WHERE Agente".$i."='".$filtros[$a]."' AND Fecha >='01-05-2018' AND Horario <> '' AND Sucursal = ?", array($sucursal));
		
				if($query->num_rows() > 0){
					$agenteocupado[] = "Agente".$i;
					$var[] = $query->result_array();
				} 
				$a++;
		}

		$CitaServicio= array();
		$CitaEntrega = array();
		if(empty($var)){
			return 'null';
		}else{
		
		$i=0;	


		foreach($var as $row) {
        	foreach($row as $k) {

        		if(!is_null($k['Recepcion'])){
        			$CitaServicio[] = explode('-', $k['Recepcion']);
        			$CitaEntrega[] =null;
       
        		}
        		if(!is_null($k['Entrega'])){
        			$CitaServicio[] =null;
        			$CitaEntrega[] = explode('-', $k['Entrega']);
   
        		}if(!is_null($k['Entrega']) && !is_null($k['Recepcion'])){
        			$CitaServicio[] = explode('-', $k['Recepcion']);
        			$CitaEntrega[] = explode('-', $k['Entrega']);
        		}

             	$ini = $k['Fecha'];
				$endi = $k['Horario'];
				$starTime = substr($ini, 0,10) .' '. $endi;
				$endTime = date("Y-m-d H:i:s", strtotime('+30 minutes', strtotime($starTime)));
				//$new_row['title'] = 'CITA';

				// si es una cita de recepcion CR
				if($CitaServicio[$i][0] == 'CR'){

					if(!ctype_space($CitaServicio[$i][3])){
						$new_row['title'] = $CitaServicio[$i][3];
						$new_row['id'] = $CitaServicio[$i][2];
					}else{
						$new_row['title'] = 'CR';
						$new_row['id'] = $CitaServicio[$i][2];
					}
					$new_row['resourceId'] = $k["Agente"];
					$new_row['start'] = $starTime;
					$new_row['end'] = $endTime;
					$new_row['color'] = '#0355a3';

				}
				//si es cita de entrega 
				if($CitaEntrega[$i][0] == 'CE'){
					if(!ctype_space($CitaEntrega[$i][3])){
						$new_row['title'] = $CitaEntrega[$i][3];
						$new_row['id'] = $CitaEntrega[$i][2];
					}else{
						$new_row['title'] = 'CE';
						$new_row['id'] = $CitaEntrega[$i][2];
					}	
					$new_row['resourceId'] = $k["Agente"];
					$new_row['start'] = $starTime;
					$new_row['end'] = $endTime;
					$new_row['color'] = '#56ca85';

				}
				
				$row_set[] = $new_row;
				$i++; 
	       		}
       		}
		}	
		return $row_set;
	}

	
	function ver_horariosAg(){
		$datos_sesion = $this->session->userdata("logged_in");
		$bd_agencia = $this->load->database('other', TRUE);
		$horario = $bd_agencia->select("*")		
							  ->from("AgendaHora")
							  ->get()->result_array();
		return $horario;                             
	}

	function guardar_nuevoCliente($datos = null){
		$consecutivo = $this->db->select("consecutivo")
								->from("agencia")
								->where("id", $this->session->userdata["logged_in"]["id_agencia"])
								->where("eliminado", 0)
								->get()->row_array();

		$consecutivo = $consecutivo["consecutivo"] + 1;

		$nombre_completo = strtoupper($datos["nombre_cli"]." ".$datos["apaterno_cli"]." ".$datos["amaterno_cli"]);

		$cte["Cliente"] = "cw".$consecutivo;
		$cte["Nombre"] = $nombre_completo;
		$cte["PersonalNombres"] = $datos["nombre_cli"];
		$cte["PersonalApellidoPaterno"] = $datos["apaterno_cli"];
		$cte["PersonalApellidoMaterno"] = $datos["amaterno_cli"];
		$cte["RFC"] = $datos["rfc_cli"];
		$cte["Estatus"] = "ALTA";
		$cte["UltimoCambio"] = date("d-m-Y H:i:s");
		$cte["Alta"] = date("d-m-Y H:i:s");
		$cte["Agente"] = $this->session->userdata["logged_in"]["cve_intelisis"];

		$bd_agencia = $this->load->database("other", TRUE);
		$db_debug = $bd_agencia->db_debug; //save setting
		$bd_agencia->db_debug = FALSE; //disable debugging for queries

		$bd_agencia->trans_start();
		$bd_agencia->insert("Cte", $cte);

		$cliente["error"] = $bd_agencia->error();

		$bd_agencia->trans_complete();

		$agencia["consecutivo"] = $consecutivo;

		$this->db->trans_start();

		$this->db->where("id", $this->session->userdata["logged_in"]["id_agencia"]);
		$this->db->where("eliminado", 0);
		$this->db->update("agencia", $agencia);

		$this->db->trans_complete();

		if($bd_agencia->trans_status() == true && $this->db->trans_status() == true)
		{
			$cliente["estatus"] = true;
			$cliente["id"] = $cte["Cliente"];
		}else
		{
			$cliente["estatus"] = false;
			$cliente["id"] = 'no';
		}
		return $cliente;
	}

	function obtener_tecnicos($b, $sucursal){
		$this->db2 = $this->load->database('other',true);
		$query = $this->db2->query("SELECT * FROM Tecnicos2 WHERE Horario = ''
								AND Fecha >= dateadd(day, 1-datepart(dw, getdate()), CONVERT(date,getdate())) 
								AND Fecha <  dateadd(day, 8-datepart(dw, getdate()), CONVERT(date,getdate()))
								AND sucursal =?", array($sucursal));
		$arreglo = $query->result_array();


		$tecnicos=array();
		$sizearray = sizeof($arreglo,1);

		for ($i=1; $i <= $sizearray ; $i++) { 
			if(empty($arreglo[0]["Agente".$i]) ){
				$x = 'Sin agentes';
		}else{
				$tecnicos[] = $arreglo[0]['Agente'.$i];
			}
		}
		if($b == 1){
			if(empty($tecnicos)){
			return null;
		}
			return $tecnicos;
		}else{
			if(empty($tecnicos)){
				return null;
			}else{
			foreach ($tecnicos as $row) {
				$new_row['id'] = $row;
				$new_row['title'] = $row;
				$row_set[] = $new_row;
			}
			return $row_set;
			}
		}
	}

	public function guardar_nuevoArt($datos = null)
	{
		$art["Articulo"] = $datos["clave_art"]; 
		$art["Descripcion1"] = $datos["descripcion_art"];
		$art["Categoria"] = ($datos["cat_art"] == 1) ? "Autos Nuevos" : "Autos Seminuevos";
		$art["Unidad"] = $datos["uVenta_art"];
		$art["UnidadTraspaso"] = $datos["uTrasp_art"];
		$art["Tipo"] = "VIN";
		$art["TipoOpcion"] = $datos["opciones_art"];
		$art["Estatus"] = $datos["estatus_art"];
		$art["UltimoCambio"] = date("d-m-Y H:i:s");
		$art["Alta"] = date("d-m-Y H:i:s");
		$art["EstatusPrecio"] = $datos["estPrecio_art"];
		$art["ClaveFabricante"] = $datos["codFabr_art"];
		$art["Impuesto1"] = 16;
		$art["MonedaCosto"] = $datos["monVenta_art"];
		$art["MonedaPrecio"] = $datos["monVenta_art"];
		$art["UnidadCantidad"] = $datos["numPartes_art"];

		$bd_agencia = $this->load->database("other", TRUE);
		$db_debug = $bd_agencia->db_debug; //save setting
		$bd_agencia->db_debug = FALSE; //disable debugging for queries

		$bd_agencia->trans_start();

		$bd_agencia->query("DISABLE TRIGGER tgDIOTArt ON Art");

		$bd_agencia->insert("Art", $art);

		$bd_agencia->query("ENABLE TRIGGER tgDIOTArt ON Art");

		$articulo["error"] = $bd_agencia->error();

		$bd_agencia->trans_complete();

		if($bd_agencia->trans_status() == true)
		{
			$articulo["estatus"] = true;
		}else
		{
			$articulo["estatus"] = false;
		}

		return $articulo;
	}

	public function guardar_nuevoVin($datos = null)
	{
		$vin["Modelo"] = $datos["anio_vin"];
		$vin["Articulo"] = $datos["art_vin"];
		$vin["VIN"] = $datos["vin_vin"];
		$vin["Descripcion1"] = $datos["descr_vin"];
		$vin["Cilindros"] = $datos["cil_vin"];
		$vin["Puertas"] = $datos["puertas_vin"];
		$vin["Pasajeros"] = $datos["pasaj_vin"];
		$vin["Transmision"] = $datos["trans_vin"];
		$vin["TipoVehiculoQC"] = $datos["tipovqc_vin"];
		$vin["MotorLts"] = $datos["motorlts_vin"];
		$vin["ColorExteriorDescripcion"] = $datos["color_vin"];
		$vin["Cliente"] = $datos["id_cliente"];
		$vin["Fecha"] = date("d-m-Y");
		$vin["Alta"] = date("d-m-Y");

		$bd_agencia = $this->load->database("other", TRUE);
		$db_debug = $bd_agencia->db_debug; //save setting
		$bd_agencia->db_debug = FALSE; //disable debugging for queries

		$bd_agencia->trans_start();

		$bd_agencia->insert("VIN", $vin);

		$v["error"] = $bd_agencia->error();

		$bd_agencia->trans_complete();

		if($bd_agencia->trans_status() == true)
		{
			$v["estatus"] = true;
		}else
		{
			$v["estatus"] = false;
		}

		return $v;
	}

	public function calculacargataller($dia = 0){
		if($dia == 0)
		{
			$dia = date("d-m-Y");

			// $dia = "14-05-2018";
		}

		$temp = $this->db->select("horas_rampas,rampas_x_disponibilidad,servicio_express, rampas")->from("sucursal")->where("id", $this->session->userdata['logged_in']['id_sucursal'])->get()->row_array();
		// print_r($temp);die;
		$int = $this->load->database("other", TRUE);

		$tiempotrabajo = $int->select("Hora")->from("AgendaHora")->limit(2)->get()->result_array();
		$tiempotrabajo = (strtotime($tiempotrabajo[1]['Hora']) - strtotime ($tiempotrabajo[0]['Hora']))/60;

		$contador = 0;
		$contadorexpress = 0;
		$contador2 = 0; 
		$tiempoocupado = $int->select("*")->from("Tecnicos2")->where("Fecha", $dia)->get()->result_array();
		foreach ($tiempoocupado as $value) 
		{
			if($value['Horario'] != '' && $value['Horario'] != null)
			{


				foreach ($value as $value2) 
				{
					if($contador2 > 3)
					{

						if(isset($value2))
						{
							if($contador2%2 != 0)
							{
								$temp2 = explode('-',$value2); 
								if($temp2[6])
								{
									$contadorexpress++;
									$contadorexpress++;
									$contador--;
								}
								else
									$contador++;
							}else
							{
								$contador++;
							}
						}

						$contador2++;

					}else
					{
						$contador2++;
					}

				}
			}

			$contador2 = 0 ;
		}
		$contador  = $contador/2;
		$contadorexpress  = $contadorexpress/2;
		$ret['tiempo_ocupado'] = $contador*$tiempotrabajo;
		$ret['tiempo_expressocupado'] = $contadorexpress*$tiempotrabajo;
		$ret['tiempo_disponible'] = ((($temp['rampas'] * $temp['horas_rampas'])*60) *($temp['rampas_x_disponibilidad']/100));
		$ret['tiempo_expressdisponible'] = ((($temp['rampas'] * $temp['horas_rampas'])*60) *($temp['servicio_express']/100));

		if(($ret['tiempo_disponible'] - $ret['tiempo_ocupado']) > $tiempotrabajo)
			$ret['disponible'] = "ok";
		else
			$ret['disponible'] = "ko";

		if(($ret['tiempo_expressdisponible'] - $ret['tiempo_expressocupado']) > $tiempotrabajo)
			$ret['disponibleexpress'] = "ok";
		else
			$ret['disponibleexpress'] = "ko";


		return $ret;

	}

	public function obtener_citas_tecnicos(){
		$bandera = 1;
		$logged_in   = $this->session->userdata("logged_in");
		$sucursal    = $logged_in['id_sucursal'];
		$filtros     = $this->obtener_tecnicos($bandera, $sucursal);
		$filtersize  = sizeof($filtros);
		$filtersize  = $filtersize +1;
		
		$this->db2 = $this->load->database("other", true);

		$a=0;


		// execute store

		//$query2 = $this->db2->query("Exec xpAsesoresEsp 'GMFAM', '1'");

		for ($i=1; $i < $filtersize ; $i++) {



				$query = $this->db2->query("SELECT Agente".$i." AS Agente, Operaci".$i." AS Operacion,  Fecha, Horario FROM Tecnicos2 WHERE Agente".$i."='".$filtros[$a]."'AND Fecha >= dateadd(day, 1-datepart(dw, getdate()), CONVERT(date,getdate())) 
					AND Fecha <  dateadd(day, 8-datepart(dw, getdate()), CONVERT(date,getdate()))
					AND Horario <> '' AND Sucursal = ?", array($sucursal));
		
				if($query->num_rows() > 0){
					$agenteocupado[] = "Agente".$i;
					$var[] = $query->result_array();
				} 
				$a++;
		}
		if(empty($var)){
			return null;
		}else{
		$i=0;
		foreach($var as $row) {
        	foreach($row as $k) {
        		if(!empty($k['Operacion'])){
        			$operacion[] = explode('-', $k['Operacion']);
        		}
             	$ini = $k['Fecha'];
				$endi = $k['Horario'];
				$starTime = substr($ini, 0,10) .' '. $endi;
				$endTime = date("Y-m-d H:i:s", strtotime('+60 minutes', strtotime($starTime)));
				//$new_row['title'] = 'CITA';
				$new_row['title']      = $operacion[$i][2];
				$new_row['resourceId'] = $k["Agente"];
				$new_row['start']      = $starTime;
				$new_row['end']        = $endTime;
				$new_row['color']      = '#0080ff';
				$row_set[]             = $new_row;
				$i++;
	       		}
       		}
		}	
		return $row_set;
	}


	public function crear_cita($data){

		$this->db2 = $this->load->database("other", true);

		$empresa         = 'GMFAM';
		$moneda          = 'Pesos';
		$almacen 		 = 'SS3';
		$estatus         = 'CONFIRMAR';
		$prioridad       = 'Normal';
		$ejercicio		 = date('Y');
		$periodo         = date('m');

		$sucursal        = '1';

		$movimiento      = $data['movimiento'];  
  		$fecha_emicion   = $data['fecha_emicion'];

  		$fecha_emicion2   = substr($fecha_emicion, 0,10). 'T00:00:00.000';

  		
  		$timestamp       = date('d-m-Y');
  		$hora_recepcion  = $data['hora_recepcion'];
  		$hora_requerida  = $data['hora_requerida'];
  		$fecha_requerida = $data['fecha_requerida'];
  		$cliente         = $data['cliente']; 
  		$agente          = $data['agente'];
  		$vin             = $data['servicioserie']; 
  		$uen             = $data['uen']; 

  		$art = $this->db2->query("SELECT Articulo FROM VIN WHERE VIN= ?", array($vin))->result_array();
  		
  		//$x = $this->update_store_asesores();
  		//echo $x;die;
  		/**** Fecha_registro  FechaRequerida */
  		$this->db2->trans_begin();

  		$this->db2->query("INSERT INTO Venta(Empresa, Mov, FechaEmision, UEN, Moneda, Estatus, Cliente, Almacen, Agente, ServicioSerie,FechaRequerida, HoraRequerida, Ejercicio, Periodo, FechaRegistro,Sucursal, HoraRecepcion, ServicioArticulo)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", 
			array($empresa, $movimiento,$fecha_emicion2,$uen,$moneda,$estatus, $cliente, $almacen, $agente,$vin,$fecha_requerida,$hora_requerida,$ejercicio, $periodo, $timestamp,$sucursal, $hora_recepcion, $art[0]['Articulo']));
  		
  		$user_id = $this->db2->insert_id();
		if ($this->db2->trans_status() === FALSE){
			$this->db2->trans_rollback();
			return false;
		}else{
			$this->db2->trans_commit();
			return $user_id;
		}
	}

	public function crear_cita_tec($data){

		$this->db2 = $this->load->database("other", true);

		$empresa         = 'GMFAM';
		$almacen 		 = 'SS3';
		$estatus         = 'CONFIRMAR';
		$prioridad       = 'Normal';
	    $ejercicio		 = date('Y');
		$periodo         = date('m');

		$sucursal        = '1';
		$SucursalVenta   = '1';

		$movimiento      = $data['movimiento'];
		$fecha_emicion   = $data['fecha_emicion'];
		$moneda          = $data['moneda'];
		$timestamp       = date('d-m-Y G:i:s');
  		$hora_recepcion  = $data['hora_recepcion'];
  		$hora_requerida  = $data['hora_requerida'];
  		$cliente         = $data['cliente']; 
  		$agente          = $data['agente']; 
  		$uen             = $data['uen'];

  		$this->db2->trans_begin();
  		
  		$this->db2->query(
  			"INSERT INTO Venta (Empresa, Mov, FechaEmision, UEN, Moneda, Cliente, Almacen, Agente, FechaRequerida, HoraRequerida, Ejercicio, Periodo, FechaRegistro, Sucursal,SucursalVenta, HoraRecepcion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", 
  			array($empresa,$movimiento, $fecha_emicion, $uen, $moneda, $cliente, $almacen, $agente, $fecha_requerida, $hora_requerida, $ejercicio, $periodo, $timestamp, $sucursal, $SucursalVenta, $HoraRecepcion)

  		);

  		$user_id = $this->db2->insert_id();
		if ($this->db2->trans_status() === FALSE){
			$this->db2->trans_rollback();
			return false;
		}else{
			$this->db2->trans_commit();
			return $user_id;
		}  

	}
	public function update_table_Asesores(){

		$this->load->database();
		$this->db2 = $this->load->database("other", true);			
		$agen = 'GMFAM';
		$suc  = '1';
		$query2 = $this->db2->query("Exec xpAsesoresEsp $agen, $suc");


		$query = $this->db->query("SELECT hora_Actualizacion fROM sucursal WHERE id = 1");
		if ($query->num_rows() > 0){
			$update = $query->row();

			$lastupdate =  $update->hora_Actualizacion;
			$date_now = new DateTime();

			$date_now2 = new DateTime($lastupdate);

			if($date_now > $date_now2 ){
				  //$query1 = $this->db2->query("Delete Asesores2");
				 //$query2 = $this->db2->query("Exec xpAsesoresEsp $agen, $suc");
				//	$query2->result_array();
			}
			else{
				'No necesita actualizar';
			}

		}
		else{
			return array("status"=>-1);//no
		}
	}

	function update_store_asesores(){

		$this->db2 = $this->load->database("other", true);
		$query2 = $this->db2->query("Exec xpAsesoresEsp 'GMFAM','1'");
		return ($this->db2->affected_rows() > 0);
	}

	public function detalle($id){

		$this->db2 = $this->load->database("other", true);

		$query = $this->db2->query("Select c.Nombre, c.eMail1, v.FechaEmision as FechaRecepcion, v.HoraRecepcion,v.FechaRequerida, v.HoraRequerida, v.ServicioSerie FROM Venta V
			INNER JOIN Cte c ON v.Cliente = c.Cliente AND  v.ID=?", array($id));
		if ($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function datos_para_cita($cliente){

		$this->db2 = $this->load->database("other", true);
		$query = $this->db2->query("SELECT c.Nombre, vin.vin, art.Descripcion1 AS articulo FROM VIN vin inner join
		art art ON art.Articulo = vin.Articulo inner join Cte c on vin.Cliente = c.Cliente WHERe vin.Cliente = ?", array($cliente));
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return $cliente;
		}

	} 

	public function detalle_por_vin($vin){

		$this->db2 = $this->load->database("other", true);
		$query = $this->db2->query("SELECT a.Descripcion1 as Descripcion,a.Version,v.Modelo,v.FechaUltimoServicioFord,v.transmision, v.VencimientoGarantia From VIN v inner join Art a ON v.Articulo = a.Articulo WHERE v.VIN=?", array($vin));
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return false;
		}
	}

	public function pkt_por_vin($vin){
		//echo $vin;	
		$this->db2 = $this->load->database("other", true);
		$query = $this->db2->query("SELECT Articulo, Modelo FROM VIN WHERE VIN = ?", array($vin));
		if ($query->num_rows() > 0){
			$art = $query->result_array();
		}else{
			echo 'sin';
		}
		//var_dump($art);
		$query2 = $this->db2->query("SELECT DISTINCT Articulo, IdPaquete, DescripcionC, DescripcionL, kilometraje, Modelo, TipoPaquete FROM ". $this->vista ." WHERE Articulo IN (?, 'Todos') AND Modelo IN (?, 'Todos') AND TipoPaquete = 'Mantenimiento' OR (Articulo ='Todos' AND TipoPaquete = 'Mantenimiento' AND Modelo ='Todos')", array($art[0]['Articulo'], $art[0]['Modelo']))->result_array();
			return  $query2;

	}

	public function pkt_frec_por_vin($vin){
		//echo $vin;	
		$this->db2 = $this->load->database("other", true);
		$query = $this->db2->query("SELECT Articulo, Modelo FROM VIN WHERE VIN = ?", array($vin));
		if ($query->num_rows() > 0){
			$art = $query->result_array();
		}else{
			echo 'sin';
		}
		//var_dump($art);
		$query2 = $this->db2->query("SELECT Articulo, IdPaquete, DescripcionC,kilometraje, Modelo, TipoPaquete FROM ". $this->vista ." WHERE Articulo = 'Todos' AND TipoPaquete = 'OperacionFrecuente'")->result_array();
			
			return  $query2;

	}
	public function pkt_por_vin_r(){
		//echo $vin;	
		$this->db2 = $this->load->database("other", true);
		//var_dump($art);
		$query2 = $this->db2->query("SELECT Articulo, IdPaquete, DescripcionC, Precio,kilometraje, Modelo, TipoPaquete FROM ". $this->vista ." WHERE Articulo = 'Todos' AND TipoPaquete = 'OperacionFrecuente' ");
		//$this->db2->save_queries = TRUE;
		//$str = $this->db2->last_query();
		//echo $str;
		if($query2->num_rows() > 0){
			return  $query2->result_array();
		}else{
			return false;
		}

	}
	public function tipo_precio_paquete($id){
		$tabla = "ServicioPaquetes";
		if ($this->Version == "V6000")
			$tabla = "CA_ServicioPaquetes";
		$tipoPrecio =  $this->db2->query("SELECT TipoPrecio FROM ". $tabla ." WHERE Id = ?", array($id))->result_array();
		return $tipoPrecio;
	}
	
	public function paquete_detalle($id){
		$tabla = "ServicioPaquetesD";
		$tabla2 = "ServicioPaquetes";
		if ($this->Version == "V6000"){
			$tabla = "CA_ServicioPaquetesD";
			$tabla2 = "CA_ServicioPaquetes";
		}
		$this->db2 = $this->load->database("other", true);

		// $query = $this->db2->query("SELECT d.Articulo,d.Descripcion, d.Cantidad, d.PrecioUnitario, d.TipoArticulo, d.PrecioUnitario * d.Cantidad AS Total from ServicioPaquetesD as d inner join art as a on d.articulo = a.articulo where d.IdPaquete = ?", array($id));
		$query = $this->db2->query("
			SELECT d.Articulo,d.Descripcion, d.Cantidad, d.PrecioUnitario, d.TipoArticulo, d.PrecioUnitario * d.Cantidad AS Total, spd.TipoPrecio, spd.Precio, spd.DescripcionC
			from ". $tabla ." as d 
			inner join art a on d.articulo = a.articulo
			inner join ". $tabla2 ." spd ON d.idPaquete = spd.id
			where d.IdPaquete = ?", array($id));
		if($query->num_rows() > 0){
			return  $query->result_array();
		}else{
			return false;
		}
	}

	public function cargar_listas($id){

		$this->db2 = $this->load->database("other", true);

		if ($id == 0) 
			$query['Datos'][0] = array('Condicion' => '', 'ServicioTipoOrden' => '', 'ServicioTipoOperacion' => '', 'ListaPreciosEsp' => '', 'Concepto' => '', 'Moneda' => '', 'UEN' => '', 'ServicioIdentificador' => '', 'ServicioNumero' => '', "ZonaImpuesto" => "");
		else
			$query['Datos'] = $this->db2->query("SELECT Condicion,
												ServicioTipoOrden,
												ServicioTipoOperacion,
												ListaPreciosEsp,
												Concepto,
												Moneda,
												UEN,
												ServicioIdentificador,
												ServicioNumero,
												ZonaImpuesto,
												ISNULL(comentarios,'') AS 'Comentarios'
												FROM Venta where id = ?", array($id))->result_array();

		$query['Condicion']   = $this->db2->query("SELECT Condicion FROM Condicion")->result_array();

		$query['TipoOrden'] = $this->db2->query("SELECT TipoOrden From ServicioTipoOrden")->result_array();

		$query['TipoOperacion'] = $this->db2->query("SELECT TipoOperacion FROM ServicioTipoOperacion")->result_array();

		$query['ListaPrecios']  = $this->db2->query("SELECT Lista FROM ListaPrecios")->result_array();

		// $query['Moneda'] = $this->db2->query("SELECT Moneda FROM Mon")->result_array();

		$query['UEN']  = $this->db2->query("SELECT  UEN, Nombre from  uen join CA_MovTipoValidarUEN muv on muv.UENValida = UEN.UEN 
			WHERE  muv.Modulo='VTAS' AND MOV IN('Servicio','Cita Servicio') ")->result_array();

		$query['torrecolor'] = $this->db2->query("SELECT Identificador from ServicioIdentificador")->result_array();

		$query['Concepto'] = $this->db2->query("SELECT DISTINCT Concepto FROM Venta WHERE Mov = 'Servicio' AND Concepto IS NOT NULL AND Concepto NOT IN ('null','Flotilla','Venta Servicio','')")->result_array();

		$query["iva"] = $this->db2->query("SELECT * FROM ZonaImp")->result_array();

		/*if($id == 0)
		{
			$query['Concepto']      = $this->db2->query("SELECT DISTINCT Concepto  from Venta where Mov = 'Servicio'")->result_array();
			$query['TipoOrden']     = $this->db2->query("SELECT DISTINCT TipoOrden From ServicioTipoOrden")->result_array();
			$query['TipoOperacion'] = $this->db2->query("SELECT DISTINCT TipoOperacion FROM ServicioTipoOperacion")->result_array();
			$query['ListaPrecios']  = $this->db2->query("SELECT DISTINCT Lista FROM ListaPrecios")->result_array();
			$query['uen']           = $this->db2->select("UEN.Nombre, UEN.UEN, muv.mov")->from("UEN")->join("MovTipoValidarUEN muv", "muv.UENValida = UEN.UEN")->where("muv.Mov IN ('Servicio')")->where("UEN.Estatus",'ALTA')->get()->result_array();
			
			$query['colores']       = $this->db2->query("SELECT DISTINCT Descripcion from vincolor")->result_array();
			$query['Condicion'] = $this->db2->query("SELECT DISTINCT Condicion  from Venta where Mov = 'Servicio'")->result_array();
			$query['torrecolor']    = $this->db2->query("SELECT Identificador FROM ServicioIdentificador")->result_array();
		}else
		{
			$query['Condicion']   = $this->db2->query("SELECT Condicion as Condicion  FROM Venta WHERE id = ?", array($id))->result_array();

			if(!isset($query['Condicion'][0]['Condicion'])) 
			{
				$query['Condicion'] = $this->db2->query("SELECT DISTINCT Condicion  from Venta where Mov = 'Servicio'")->result_array();
			}

			

			$query['Concepto']   = $this->db2->query("SELECT concepto as Concepto  FROM Venta WHERE id = ?", array($id))->result_array();

			if(!isset($query['Concepto'][0]['Concepto'])) 
			{
				$query['Concepto']      = $this->db2->query("SELECT DISTINCT Concepto  from Venta where Mov = 'Servicio'")->result_array();
			}

			$query['TipoOrden'] = $this->db2->query("SELECT ServicioTipoOrden as TipoOrden FROM Venta WHERE id = ?", array($id))->result_array();

			if(!isset($query['TipoOrden'][0]['TipoOrden'] ))
			{
				$query['TipoOrden'] = $this->db2->query("SELECT DISTINCT TipoOrden From ServicioTipoOrden")->result_array();
			}

			$query['TipoOperacion'] = $this->db2->query("SELECT ServicioTipoOperacion as TipoOperacion FROM Venta WHERE id = ?", array($id))->result_array();

			if(!isset($query['TipoOperacion'][0]['TipoOperacion']))
			{
				$query['TipoOperacion'] = $this->db2->query("SELECT DISTINCT TipoOperacion FROM ServicioTipoOperacion")->result_array();
			}

			$query['ListaPrecios']  = $this->db2->query("SELECT DISTINCT Lista FROM ListaPrecios")->result_array();

			$query['uen'] = $this->db2->query("SELECT UEN as UEN FROM Venta WHERE id = ?", array($id))->result_array();
			
			if(!isset($query['uen'][0]['UEN']))
			{
				$query['uen'] = $this->db2->select("UEN.Nombre, UEN.UEN, muv.mov")->from("UEN")->join("MovTipoValidarUEN muv", "muv.UENValida = UEN.UEN")->where("muv.Mov IN ('Servicio')")->where("UEN.Estatus",'ALTA')->get()->result_array();
			}

			$query['colores']       = $this->db2->query("SELECT DISTINCT Descripcion from vincolor")->result_array();

			$query['torrecolor']    = $this->db2->query("SELECT Identificador FROM ServicioIdentificador")->result_array();

			$query['numtorre']    = $this->db2->query("SELECT servicionumero as numservicio FROM Venta WHERE id = ?", array($id))->row_array();
		}*/

		return $query;
	}

	public function formatear_numero($numero = null)
	{
		$num = floatval(preg_replace("/[^-0-9\.]/","", $numero));

		return $num;
	}

	public function guardar_infoOrden($formulario = null, $elementos = null)	//Guarda los datos en bd del proyecto
	{
		
		$marca_sucursal = $this->db->select("sucursal_marca")
								   ->from("sucursal")
								   ->where("id", $this->session->userdata["logged_in"]["id_sucursal"])
								   ->where("eliminado", 0)
								   ->get()->row_array();

		$marca_sucursal = $marca_sucursal["sucursal_marca"];

		$orden_servicio["asesor"] = $formulario["asesorname_cliente"];
		$orden_servicio["clave_asesor"] = $formulario["cve_cliente"];
		$orden_servicio["fecha_recepcion"] = date("d-m-Y");
		$orden_servicio["hora_recepcion"] = date("H:i:s");
		
		$fecha_promesa = strtotime($formulario["fecha_promesa_cliente"]);
		$fecha_promesa = date("d-m-y", $fecha_promesa);
		$orden_servicio["fecha_entrega"] = $fecha_promesa;
		
		$hora_promesa = strtotime($formulario["horapromesa_cliente"]);
		$hora_promesa = date("H:i:s", $hora_promesa);
		$orden_servicio["hora_entrega"] = $hora_promesa;
		
		$orden_servicio["nombre_cliente"] = ($formulario["nom_cliente"] == null) ? "" : $formulario["nom_cliente"];
		$orden_servicio["ap_cliente"] = ($formulario["ap_cliente"] == null || $formulario["ap_cliente"] == "") ? "" : $formulario["ap_cliente"];
		$orden_servicio["am_cliente"] = ($formulario["am_cliente"] == null || $formulario["am_cliente"] == "") ? "" : $formulario["am_cliente"];
		$orden_servicio["email_cliente"] = $formulario["correo_cliente"];
		$orden_servicio["rfc_cliente"] = $formulario["rfc_cliente"];
		$orden_servicio["dir_calle"] = $formulario["dir_cliente"];
		$orden_servicio["dir_num_ext"] = $formulario["numExt_cliente"];
		$orden_servicio["dir_num_int"] = $formulario["numInt_cliente"];
		$orden_servicio["dir_colonia"] = $formulario["colonia_cliente"];
		$orden_servicio["dir_municipio"] = $formulario["poblacion_cliente"];
		$orden_servicio["dir_estado"] = $formulario["estado_cliente"];
		$orden_servicio["dir_cp"] = $formulario["cp_cliente"];
		$orden_servicio["tel_movil"] = $formulario["cel_cliente"];
		$orden_servicio["otro_tel"] = $formulario["telefono_cliente"];
		$orden_servicio["placas_v"] = $formulario["placas_cliente"];
		$orden_servicio["vin_v"] = $formulario["vin_cliente"];
		$orden_servicio["kilometraje_v"] = $formulario["kms_cliente"];
		$orden_servicio["marca_v"] = $marca_sucursal;
		$orden_servicio["anio_modelo_v"] = $formulario["anio_cliente"];
		$orden_servicio["color_v"] = $formulario["color_cliente"];
		$orden_servicio["tipo_orden"] = $formulario["concepto_cliente"];
		$orden_servicio["subtotal_orden"] = $this->formatear_numero($formulario["subtotal"]);
		$orden_servicio["iva_orden"] = $this->formatear_numero($formulario["iva"]);
		$orden_servicio["total_orden"] = $this->formatear_numero($formulario["totaaal"]);
		$orden_servicio["fecha_actualizacion"] = date("d-m-Y H:i:s");
		$orden_servicio["torrecolor"] = $formulario["tipotorre"];
		$orden_servicio["torrenumero"] = $formulario["torrenumero"];
		$orden_servicio["comentario_cliente"] = $formulario["comentcliente"];



		if(strlen($orden_servicio["rfc_cliente"]) == 13)
		{
			$orden_servicio["regimen"] = "fisica";
		}else 
		{
			$orden_servicio["regimen"] = "moral";
		}

		$this->db->trans_start();

		$this->db->where("id", $formulario["id_orden"]);
		$this->db->update("orden_servicio", $orden_servicio);

		$existen_articulos = $this->db->select("*")
									  ->from("orden_servicio_desglose")
									  ->where("id_orden", $formulario["id_orden"])
									  ->count_all_results();

		//si existian ya articulos en para la orden los elimina							  
		if($existen_articulos != 0)
		{
			$this->db->where("id_orden", $formulario["id_orden"]);
			$this->db->delete("orden_servicio_desglose");
		}

		foreach ($elementos as $key => $value) 
		{
			$orden_servicio_desglose["id_orden"] = $formulario["id_orden"];
			$orden_servicio_desglose["articulo"] = $value["art"];
			$orden_servicio_desglose["descripcion"] = $value["descripcion"];
			$orden_servicio_desglose["cantidad"] = $value["cantidad"];
			$orden_servicio_desglose["precio_unitario"] = $this->formatear_numero($value["precio_u"]);
			$orden_servicio_desglose["total"] = $this->formatear_numero($value["total"]);
			$orden_servicio_desglose["fecha_creacion"] = date("d-m-Y H:i:s");
			$orden_servicio_desglose["fecha_actualizacion"] = date("d-m-Y H:i:s");
			$orden_servicio_desglose["eliminado"] = 0;

			$this->db->insert("orden_servicio_desglose", $orden_servicio_desglose);
		}

		$this->db->trans_complete();

		if($this->db->trans_status() == true)
		{
			$estatus = true;
		}else
		{
			$estatus = false;
		}

		return $estatus;
	}

	function guardar_orden_na($datar, $elementos){
		

		global $trigger_name;
		$this->db2 = $this->load->database("other", true);
		$bd = $this->db2->database;
		// consultar si hay triggers activos
		$tigger = $this->trigger_exist($bd, "VentaD");
		//si regresa 0 no hay triggers se pasa hacer el update si no a desactivarlos
		$no_trigger = sizeof($tigger);
		if($no_trigger > 0){
			$i=0;
			foreach ($tigger as $trig) {
				$trigger_name[$i] = $trig->Trigger;
				//mandamos nombre del trigger a deshabilitar y la tabla, en este caso siempre es Cte,
				//si fuera distinto mofidicar.
				//$ok= $this->deshabilita_trigger($trigger_name[$i], 'VentaD', $bd);

				$i++;
			}
		}

		// if($datar['OrigenID'] == 0)
		// {
		// 	$mov_id['MovID'] == null;
		// 	$mov_id['Mov'] == null;
		// 	// $datar['OrigenID'] = null;
		// }else
		// {
			$mov_id = $this->db2->select("MovID, Mov")->from("venta")->where("id",$datar['OrigenID'])->get()->row_array();	
		// }
		

		$sucursal = $this->db->select("empresa, sucursal_int, almacen_servicio")
							 ->from("sucursal")
							 ->where("id", $this->session->userdata["logged_in"]["id_sucursal"])
							 ->get()->row_array();

		// $us_intelisis = $this->db->select("cve_intelisis")->from("usuarios")->where("id", $this->session->userdata('logged_in')['id'])->get()->row_array();

	// Datos Generales
		$Empresa               = $sucursal["empresa"];
		$Servicio              = $datar['Mov'];
		$TipoCambio            = $datar['TipoCambio'];
		$usuario               = $this->session->userdata('logged_in')['usuario_intelisis'];//$us_intelisis['cve_intelisis'];//$datar['usuario'];
		$Estatus               = $datar['Estatus'];
		$Observaciones         = $datar['Observaciones'];
		$Directo               = $datar['Directo'];
		$Prioridad             = $datar['Prioridad'];
		$RenglonID             = $datar['RenglonID'];
		$Almacen               = $sucursal["almacen_servicio"];
		$Sucursal              = $sucursal["sucursal_int"];
		$FechaEmision          = date('d-m-Y');
		$HoraRecepcion 		   = $datar['HoraRequerida']; // date('G:i');
		$HoraPromesa           = $datar['HoraPromesa'];
		$UltimoCambio          = $datar['UltimoCambio'];
			// $OrigenID              = $datar['OrigenID']; // si viene de una cita es el movid de la cita
		$OrigenID              = $mov_id['MovID']; // si viene de una cita es el movid de la cita
		$Origen                = $mov_id['Mov'];
		$Referencia            = $datar['Referencia'];
		// $EstatusV              = 'CONCLUIDO';	//<--- No se utiliza
		// $Unidad				   = 'pza';			//<--- No se utiliza
		// $Factor				   = 1;				//<--- No se utiliza
		$ejercicio		       = date('Y');
		$periodo               = date('m');
		$timestamp             = date('d-m-Y G:i:s');
		$OrigenTipo            = "VTAS";
		// $impuesto              = 16;				//<--- No se utiliza
	// Datos Cliente
		$Cliente               = $datar['Cliente'];
	// Datos Veh??culo
		$ServicioArticulo      = $datar['ServicioArticulo'];
		$Modelo 			   = $datar['Modelo'];
		$ServicioSerie         = $datar['ServicioSerie'];
		$ServicioPlacas        = $datar['ServicioPlacas'];
		$ServicioKms           = $datar['ServicioKms'];
	// Datos Asesor
		$Agente                = $datar['Agente'];
		$fecharequerida        = $datar['fecharequerida'];
	// $HoraRequerida         = $datar['HoraRequerida'];	//<--- No se utiliza
	// Datos Orden
		$Condicion             = $datar['Condicion'];
		$ServicioTipoOrden     = $datar['ServicioTipoOrden']; //tabla serviciotipoorden
		$ServicioTipoOperacion = $datar['ServicioTipoOperacion']; //servicio tipo operacion 
		$ListaPreciosEsp       = $datar['ListaPreciosEsp']; //$datar['ListaPreciosEsp']; // tabla ListaPrecios
		$Concepto              = $datar['Concepto'];
		$Moneda                = $datar['Moneda'];
		$UEN                   = $datar['UEN'];
		$torrecolor            = $datar['torrecolor'];
		$torrenum              = $datar['torrenum'];
		$Comentarios		   = $datar['Comentarios'];
	// Datos Articulos y Mano de Obra
		$Importe               = $datar['Total'];
		$Impuestos             = $datar['iva'];
		$IdPaquete             = $datar['paqueteid'];
		$ZonaImpuesto		   = $datar['ZonaImpuesto'];
		$ServicioDescripcion   = $datar['color_cliente'];


		// procedemos a llenar los arrays con datos para insertar en Venta y VentaD
		$this->db2->trans_begin();
		// cambiar estatus de la cita de servicio
		// $query = $this->db2->query("UPDATE VENTA SET Estatus = ?, UltimoCambio = ?, Referencia = ? WHERE ID = ?", array($EstatusV,$UltimoCambio,$Referencia,$datar['OrigenID']));
		
		// inserta en Venta la ORDEN
		$query = $this->db2->query("INSERT INTO Venta(Empresa, Mov, Concepto,UEN,
				Moneda, TipoCambio, Usuario, Estatus, Comentarios, Observaciones,
				Directo, Prioridad, RenglonID, Cliente, Agente, Condicion, Importe, Impuestos, 
				ServicioArticulo, ServicioSerie, Almacen, Sucursal,
				FechaEmision, horarecepcion, UltimoCambio, OrigenID, Referencia,ServicioTipoOrden, ServicioPlacas, ServicioTipoOperacion, ServicioKms
				,ListaPreciosEsp, FechaRequerida, Paquetes,Ejercicio, Periodo, FechaRegistro,HoraRequerida,ServicioIdentificador,ServicioNumero,Origen,OrigenTipo,ServicioModelo,ZonaImpuesto,ServicioDescripcion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", array($Empresa,$Servicio,$Concepto,$UEN,$Moneda,$TipoCambio,$usuario,$Estatus,$Comentarios,$Observaciones,$Directo,$Prioridad,$RenglonID ,$Cliente,$Agente,$Condicion,$Importe,$Impuestos,$ServicioArticulo,$ServicioSerie,$Almacen,$Sucursal,$FechaEmision, $HoraRecepcion, $UltimoCambio,$OrigenID,$Referencia,$ServicioTipoOrden,$ServicioPlacas,$ServicioTipoOperacion,$ServicioKms, $ListaPreciosEsp,$fecharequerida, $IdPaquete, $ejercicio,$periodo,$timestamp,$HoraPromesa,$torrecolor,$torrenum, $Origen,$OrigenTipo,$Modelo,$ZonaImpuesto,$ServicioDescripcion));

		$user_id = $this->db2->insert_id();

		// $movf['sucursal'] = $sucursal['sucursal_int'];
		// $movf['empresa'] = $sucursal['empresa'];
		// $movf['Omodulo'] = "VTAS";
		// $movf['OID'] = $datar['OrigenID'];
		// $movf['OMov'] = "";
		// $movf['OMovID'] = $mov_id['MovID'];
		// $movf['Dmodulo'] = "VTAS";
		// $movf['DID'] = $user_id;
		// $movf['DMov'] = "";
		// $movf['Cancelado'] = 0;
		
		// $this->db2->insert("MovFlujo", $movf);

		//actualiza la tabla de orden servicio con el id recien generado en la tabla venta de intelisis
		$id_ordenServ = $datar["id_orden"];

		$orden_servicio["id_orden_intelisis"] = $user_id;
		$orden_servicio["id_sucursal_intelisis"] = $sucursal["sucursal_int"];
		// $orden_servicio["OModulo"] = "VTAS";
		// $orden_servicio["OID"] = "";

		$this->db->trans_start();

		$this->db->where( "id", $id_ordenServ);

		$this->db->update("orden_servicio", $orden_servicio);

		$this->db->trans_complete();

		if ($this->db2->trans_status() === FALSE){
			$this->db2->trans_rollback();
			return false;
		}else{
			$this->db2->trans_commit();
			
			// para VentaD
			$paq_pf     = [];
			$paq_sc     = [];
			$articulos  = [];
			$manodeobra = [];
			$idpak =0;

			//separamos elementos y vamos guardando por partes...
			
			for ($i = 0; $i < sizeof($elementos); $i++) {
				//si es paquete precio fijo lo guardamos con el store spGenerarDetalleST enviamos paq y id de venta
				if($elementos[$i]['tipo'] == 'Precio Fijo'){
					$idpak = $elementos[$i]['id'];
				}
				//single
				elseif ($elementos[$i]['tipo'] == 'single') {
					$articulos [$i]['art']      = $elementos[$i]['art'];
					$articulos [$i]['cantidad'] = $elementos[$i]['cantidad'];
					$articulos [$i]['precio_u'] = $elementos[$i]['precio_u'];
				}
				//mano de obra
				elseif ($elementos[$i]['tipo'] == 'mo') {
					$manodeobra[$i]['art'] = $elementos[$i]['art'];
					$manodeobra[$i]['cantidad'] = $elementos[$i]['cantidad'];
					$manodeobra[$i]['precio_u'] = $elementos[$i]['precio_u'];

				}else{
					$idpak= $elementos[$i]['id'];
				}
			}

			// var_dump($idpak);
			// var_dump($articulos);
			// var_dump($manodeobra);
			// die;
			if($idpak > 0){
				$ok1 = $this->guardar_paq($idpak,$user_id,$Empresa,$Sucursal);
			}

			if(sizeof($articulos)> 0){
				$ok2 = $this->guardar_articulos($articulos,$user_id, $Almacen,$Agente, $Sucursal );
			}
		
			if(sizeof($manodeobra)> 0){
				$ok3 = $this->guardar_manoo($manodeobra,$user_id, $Almacen,$Agente, $Sucursal );
			}

			// echo 'ok1: '. $ok1;
			// echo 'ok2: '. $ok2;
			// echo 'ok3: '. $ok3;

			//obtener el id actual insertado, en inspeccion
			$current_id = $this->db->query("SELECT IDENT_CURRENT('orden_servicio_inspeccion') as id")->row_array();

			//set elementos a insertar o actualizar.
	        $elementos['Baterias'] = $this->db->query("SELECT bateria as Elemento From orden_servicio_inspeccion WHERE id=?", array($current_id['id']))->row_array();
			$elementos['Balatas']  = $this->db->query("SELECT balatas as Elemento From orden_servicio_inspeccion WHERE id=?", array($current_id['id']))->row_array();
			$elementos['Discos']   = $this->db->query("SELECT discos as Elemento From orden_servicio_inspeccion WHERE id=?",array($current_id['id']))->row_array();
			$elementos['Tambores'] = $this->db->query("SELECT tambores as Elemento From orden_servicio_inspeccion WHERE id=?",array($current_id['id']))->row_array();
			$elementos['Llantas']  = $this->db->query("SELECT llantas as Elemento From orden_servicio_inspeccion WHERE id=?", array($current_id['id']))->row_array();
		}

		return $user_id;
	}


	public function guardar_paq($idpak,$user_id,$Empresa,$Sucursal){
		$this->db2 = $this->load->database("other", true);

		$this->db2->query("exec LimpiaListaSt 888");
		$this->db2->query("INSERT INTO ListaSt (Estacion, Clave) VALUES (888,?)", array($idpak));
		// echo $this->db2->last_query();
		// echo $user_id;.
		$ok = $this->db2->query("DECLARE @OkRef varchar(250) EXEC spGenerarDetalleST 'VentaD',?,?,?,888,1,@OkRef OUTPUT SELECT @OkRef", array($user_id,$Empresa,$Sucursal));
		// echo $this->db2->last_query();
		if ($ok) {
    		return 1;
		}else{
			return FALSE;
		}
	}

	public function guardar_articulos($articulos,$user_id, $Almacen,$Agente, $Sucursal ){
		$this->db2 = $this->load->database("other", true);
		$arts = [];
		$Factor = 1;
		$impuesto = 16;
		$i=0;

		foreach ($articulos as $row) {
			$arts[$i] = $this->db2->query("SELECT Articulo, Descripcion1, Unidad, UnidadCantidad, Tipo AS TipoArticulo FROM Art WHERE Articulo= ?", 
				array($row['art']))->result_array();
			$i++;
		}


		$x = $this->db2->query("SELECT TOP 1 RenglonID from VentaD where ID = ? order by RenglonID DESC", array($user_id) )->result_array();
		$y =  $this->db2->query("SELECT TOP 1 Renglon from VentaD where ID = ? order by RenglonID DESC", array($user_id) )->result_array();

		if(empty($x)){
			$renglonid = 1;
		}else{
			$renglonid =  $x[0]['RenglonID'] + 1;
		}
		if(empty($y)){
			$renglon = 2048;
		}else{
			$renglon = $y[0]['Renglon'] + 2048;
		}
		$i=0;
		$control =  sizeof($articulos);

		$arts = array_values($arts);
		$articulos = array_values($articulos);

		//foreach y for
		for ($i=0; $i < sizeof($articulos) ; $i++) {
			$query = $this->db2->query("INSERT INTO VentaD (id, Renglon, RenglonID, Cantidad,Almacen, Articulo,
				Precio, PrecioSugerido, Impuesto1, DescripcionExtra,
				Unidad, Factor, Agente, Sucursal) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",	
					array(
						$user_id,
					 	$renglon,
						$renglonid,
				 		$articulos[$i]['cantidad'],
				 		$Almacen,
				 		$articulos[$i]['art'],
				 		floatval(preg_replace("/[^-0-9\.]/","", $articulos[$i]['precio_u'])),
					 	floatval(preg_replace("/[^-0-9\.]/","", $articulos[$i]['precio_u'])),
					 	$impuesto,
					 	$arts[$i][0]['Descripcion1'],
					 	$arts[$i][0]['Unidad'],
					 	$Factor,
					 	$Agente,
					 	$Sucursal
					)
				);
				$renglon=$renglon + 2048;
				$renglonid++;
		}

		if ($query) {
    		return 1;
		}else{
			return FALSE;
		}

	}
	public function guardar_manoo($manodeobra,$user_id, $Almacen,$Agente, $Sucursal){
		$this->db2 = $this->load->database("other", true);
		$arts2 = [];
		$Factor = 1;
		$impuesto = 16;

		$i=0;
		foreach ($manodeobra as $row) {
			$articulos_mo[$i] = $this->db2->query("Select Articulo, Descripcion1, Unidad, UnidadCantidad FROM Art WHERE Articulo = ?", 
				array($row['art']))->result_array();
			$i++;
		}
		$x = $this->db2->query("SELECT TOP 1 RenglonID from VentaD where ID = ? order by RenglonID DESC", array($user_id) )->result_array();
		$y =  $this->db2->query("SELECT TOP 1 Renglon from VentaD where ID = ? order by RenglonID DESC", array($user_id) )->result_array();

		if(empty($x)){
			$renglonid = 1;
		}else{
			$renglonid =  $x[0]['RenglonID'] + 1;
		}
		if(empty($y)){
			$renglon = 2048;
		}else{
			$renglon = $y[0]['Renglon'] + 2048;
		}
		$i=0;

		$manodeobra = array_values($manodeobra);
		$articulos_mo = array_values($articulos_mo);
		// echo 'mano';
		// var_dump($manodeobra);
		// echo 'arts mo';
		// var_dump($articulos_mo);
		// die;

		for ($i=0; $i <  sizeof($manodeobra); $i++) { 
			# code...
				$query= $this->db2->query("INSERT INTO VentaD (id, Renglon, RenglonID, Cantidad,UT,CCTiempoTab, Almacen, Articulo,
					Precio, PrecioSugerido, Impuesto1, DescripcionExtra,
					Unidad, Factor, Agente, Sucursal) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
					array(
						$user_id,
						$renglon,
				 		$renglonid,
				 		$manodeobra[$i]['cantidad'],
				 		$manodeobra[$i]['cantidad'],
						$manodeobra[$i]['cantidad'],
				 		$Almacen,
						$articulos_mo[$i][0]['Articulo'],
						floatval(preg_replace("/[^-0-9\.]/","", $manodeobra[$i]['precio_u'])),
						floatval(preg_replace("/[^-0-9\.]/","", $manodeobra[$i]['precio_u'])),
						$impuesto,
						$articulos_mo[$i][0]['Descripcion1'],
						$articulos_mo[$i][0]['Unidad'],
						$Factor,
						$Agente,
						$Sucursal
					 )
				);
				$renglon=$renglon + 2048;
				$renglonid++;
			
		}
		if ($query) {
    		return 1;
		}else{
			return FALSE;
		}
	}

	function guardar_inspeccion($data){
		$cajuela = $data['cajuela_herramienta'] . ',' . $data['cajuela_gato'] . ',' . $data['cajuela_reflejante'] .','.$data['cajuela_cables']
					. ','. $data['cajuela_extintor'] . ',' . $data['cajuela_llanta'];

		$exteriores = $data['exterior_taponesrueda'] .',' . $data['exterior_gomaslimpiador'] .',' . $data['exterior_antena'] .',' . $data['exterior_tapagasolina']
		.',' . $data['exterior_molduras'];

		//variable que contiene los nuevos campos para el formato profeco de grupo fame
		$profecoFame = $data['interior_tablero'] .',' . $data['interior_retrovisor'] .',' . $data['interior_cenicero'].',' . $data['interior_cinturon'].',' . $data['interior_manijas']
		.',' . $data['aspectos_mecanicos'].',' . $data['aspectos_carroceria'] ;

		$documentacion = $data['doc_polmanual'] . ','. $data['doc_rines'] . ','.  $data['doc_verificacion'] . ','. $data['doc_circulacion'] ;
		$gasolina = $data['gasolina'];

		$deja_articulos = (isset($data['dejaArticulos'])) ? $data['dejaArticulos'] : "No Especificado";

		$articulos = $data['Articulos'];

		$aceiteMotor = $data['aceiteMotor'];

		$direccionHidraulica = $data['direccionHidraulica'];

		$liquidoTransmision = $data['liq_transmision'];

		$liquidoLimpiaPara = $data['liq_limpiaparabrisas'];

		$liquidoFreno = $data['liq_frenos'];

		$plumas = $data['Plumas'];

		$llantas = $data['Llantas'];

		$tambores = $data['Tambores'];

		$discos = $data['discos'];

		$balatas = $data['Balatas'];

		$img = $data["img_inspeccion"];

		$bateria = $data['Bateria'];

		$corriente_fabrica = $data["corriente_fabrica"];

		$corriente_real = $data["corriente_real"];

		$nivel_carga = $data["nivel_carga"];

		$luces = $data["luces"];

		$parabrisas = $data["parabrisa"];
		
		$fecha_creacion = date("d-m-Y H:i:s");

		$fecha_actualizacion = date("d-m-Y H:i:s");

		$orden_servicio = $data["id_orden"];

		//elementos faltantes
		$perdida_fluidos = $data["perdida_fluidos"];

		$nivel_fluidos_cambiado = $data["nivel_fluidos_cambiado"];

		$prueba_parabrisas = $data["pruebaParabrisas"];

		$plumaslimp_cambiado = $data["plumaslimp_cambiado"];

		$bateria_cambiado = $data["bateria_cambiado"];

		$sistemas1_cambiado = $data["sistemas1_cambiado"];

		$sistemas2_cambiado = $data["sistemas2_cambiado"];

		$deposito_refrigerante = $data["liq_refrigerante"];
		$ext_garantia = $data["ext_garantia"];
		$danios = $data["existen_danios"];
		//demas
		$claxon          = $data["claxon"];
		$luces_int       = $data["lucesok"];
		$radio           = $data["radio"];
		$pantalla        = $data["pantalla"];
		$ac              = $data["ac"];
		$encendedor      = $data["encendedor"];
		$vidrios         = $data["vidrios"];
		$espejos         = $data["espejos"];
		$seguros_ele     = $data["seguros_ele"];
		$co              = $data["co"];
		$asientosyvesti  = $data["asientosyvesti"];
		$tapetes         = $data["tapetes"];

		//tabla da??os
		$dan_costDerecho = $data["dan_costDerecho"];
		$dan_parteDel = $data["dan_parteDel"];
		$dan_intAsAlf = $data["dan_intAsAlf"];
		$dan_costIzq = $data["dan_costIzq"];
		$dan_parteTras = $data["dan_parteTras"];
		$dan_cristFaros = $data["dan_cristFaros"];
		//inferior step2
		$inf_sistEsc = $data["inf_sistEsc"];
		$inf_amort = $data["inf_amort"];
		$inf_tuberias = $data["inf_tuberias"];
		$inf_transeje_transm = $data["inf_transeje_transm"];
		$inf_sistDir = $data["inf_sistDir"];
		$inf_chasisSucio = $data["inf_chasisSucio"];
		$inf_golpesEspecif = $data["inf_golpesEspecif"];
		//sistema de frenos
		$sfrenos_ddBalata = $data["sfrenos_ddBalata"];
		$sfrenos_ddDisco = $data["sfrenos_ddDisco"];
		$sfrenos_ddNeumat = $data["sfrenos_ddNeumat"];
		$sfrenos_diBalata = $data["sfrenos_diBalata"];
		$sfrenos_diDisco = $data["sfrenos_diDisco"];
		$sfrenos_diNeumat = $data["sfrenos_diNeumat"];
		$sfrenos_tdBalata = $data["sfrenos_tdBalata"];
		$sfrenos_tdDisco = $data["sfrenos_tdDisco"];
		$sfrenos_tdNeumat = $data["sfrenos_tdNeumat"];
		$sfrenos_tiBalata = $data["sfrenos_tiBalata"];
		$sfrenos_tiDisco = $data["sfrenos_tiDisco"];
		$sfrenos_tiNeumat = $data["sfrenos_tiNeumat"];
		$sfrenos_refNeumat = $data["sfrenos_refNeumat"];
		//apartados opcionales inferior y sistema de frenos
		$reqRev_inferior = $data["reqRev_inferior"];
		$reqRev_sistFrenos = $data["reqRev_sistFrenos"];

		$existe = $this->db->select("id_servicio")
						   ->from("orden_servicio_inspeccion")
						   ->where("id_servicio", $orden_servicio)
						   ->count_all_results();
				   
		$this->db->trans_begin();

		if($existe == 0)
		{
			$this->db->query("INSERT INTO orden_servicio_inspeccion(id_servicio,cajuela,exteriores,documentacion,gasolina,dejaArticulos, 
				articulos, aceiteMotor, direccionHidraulica, liquidoTransmision, liquidoLimpiaPara, liquidoFreno,
				plumas, llantas,tambores, discos, balatas, img, fecha_creacion, fecha_actualizacion,bateria, corriente_fabrica,corriente_real, nivel_carga, luces, parabrisas, perdida_fluidos, pruebaParabrisas, nivel_fluidos_cambiado, plumaslimp_cambiado, bateria_cambiado, sistemas1_cambiado, sistemas2_cambiado, deposito_refrigerante,claxon,luces_int,radio,pantalla,ac,encendedor,
				vidrios,espejos,seguros_ele,co, asientosyvesti, tapetes, extension_garantia, existen_danios, dan_costDerecho, dan_parteDel, dan_intAsAlf, dan_costIzq, dan_parteTras, dan_cristFaros, inf_sistEsc, inf_amort, inf_tuberias, inf_transeje_transm, inf_sistDir, inf_chasisSucio, inf_golpesEspecif, sfrenos_ddBalata, sfrenos_ddDisco, sfrenos_ddNeumat, sfrenos_diBalata, sfrenos_diDisco,sfrenos_diNeumat, sfrenos_tdBalata, sfrenos_tdDisco, sfrenos_tdNeumat, sfrenos_tiBalata, sfrenos_tiDisco, sfrenos_tiNeumat, sfrenos_refNeumat, reqRev_inferior, reqRev_sistFrenos, profecoFame) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", array($orden_servicio,$cajuela, $exteriores,$documentacion ,
					$gasolina,$deja_articulos, $articulos,$aceiteMotor, $direccionHidraulica,$liquidoTransmision,$liquidoLimpiaPara,
					$liquidoFreno, $plumas, $llantas, $tambores, $discos, $balatas, $img, $fecha_creacion, $fecha_actualizacion,$bateria,$corriente_fabrica,$corriente_real, $nivel_carga,$luces,$parabrisas, $perdida_fluidos, $nivel_fluidos_cambiado, $prueba_parabrisas, $plumaslimp_cambiado, $bateria_cambiado, $sistemas1_cambiado, $sistemas2_cambiado, $deposito_refrigerante,
					$claxon,$luces_int,$radio,$pantalla,$ac, $encendedor,$vidrios,$espejos, $seguros_ele,$co, $asientosyvesti, $tapetes, $ext_garantia, $danios, $dan_costDerecho, $dan_parteDel, $dan_intAsAlf, $dan_costIzq, $dan_parteTras, $dan_cristFaros, $inf_sistEsc, $inf_amort, $inf_tuberias, $inf_transeje_transm, $inf_sistDir, $inf_chasisSucio, $inf_golpesEspecif, $sfrenos_ddBalata, $sfrenos_ddDisco, $sfrenos_ddNeumat, $sfrenos_diBalata, $sfrenos_diDisco, $sfrenos_diNeumat, $sfrenos_tdBalata, $sfrenos_tdDisco, $sfrenos_tdNeumat, $sfrenos_tiBalata, $sfrenos_tiDisco, $sfrenos_tiNeumat, $sfrenos_refNeumat, $reqRev_inferior, $reqRev_sistFrenos, $profecoFame));

			$id = $this->db->insert_id();
		}else 
		{
			$this->db->where("id_servicio", $orden_servicio);
			$this->db->set("cajuela", $cajuela);
			$this->db->set("exteriores", $exteriores);
			$this->db->set("documentacion", $documentacion);
			$this->db->set("gasolina", $gasolina);
			$this->db->set("dejaArticulos", $deja_articulos);
			$this->db->set("articulos", $articulos);
			$this->db->set("aceiteMotor", $aceiteMotor);
			$this->db->set("direccionHidraulica", $direccionHidraulica);
			$this->db->set("liquidoTransmision", $liquidoTransmision);
			$this->db->set("liquidoLimpiaPara", $liquidoLimpiaPara);
			$this->db->set("liquidoFreno", $liquidoFreno);
			$this->db->set("plumas", $plumas);
			$this->db->set("llantas", $llantas);
			$this->db->set("tambores", $tambores);
			$this->db->set("discos", $discos);
			$this->db->set("balatas", $balatas);
			$this->db->set("img", $img);
			$this->db->set("bateria", $bateria);
			$this->db->set("corriente_fabrica", $corriente_fabrica);
			$this->db->set("corriente_real", $corriente_real);
			$this->db->set("nivel_carga", $nivel_carga);
			$this->db->set("perdida_fluidos", $perdida_fluidos);
			$this->db->set("nivel_fluidos_cambiado", $nivel_fluidos_cambiado);
			$this->db->set("luces", $luces);
			$this->db->set("parabrisas", $parabrisas);
			$this->db->set("pruebaParabrisas", $prueba_parabrisas);
			$this->db->set("plumaslimp_cambiado", $plumaslimp_cambiado);
			$this->db->set("bateria_cambiado", $bateria_cambiado);
			$this->db->set("sistemas1_cambiado", $sistemas1_cambiado);
			$this->db->set("sistemas2_cambiado", $sistemas2_cambiado);
			$this->db->set("deposito_refrigerante", $deposito_refrigerante);
			$this->db->set("claxon",$claxon);
			$this->db->set("luces_int",$luces_int);
			$this->db->set("radio",$radio);
			$this->db->set("pantalla",$pantalla);
			$this->db->set("ac",$ac);
			$this->db->set("encendedor",$encendedor);
			$this->db->set("vidrios",$vidrios);
			$this->db->set("espejos",$espejos);
			$this->db->set("seguros_ele",$seguros_ele);
			$this->db->set("co",$co);
			$this->db->set("asientosyvesti",$asientosyvesti);
			$this->db->set("tapetes",$tapetes);
			$this->db->set("extension_garantia",$ext_garantia);
			$this->db->set("existen_danios",$danios);
			$this->db->set("dan_costDerecho",$dan_costDerecho);
			$this->db->set("dan_parteDel",$dan_parteDel);
			$this->db->set("dan_intAsAlf",$dan_intAsAlf);
			$this->db->set("dan_costIzq",$dan_costIzq);
			$this->db->set("dan_parteTras",$dan_parteTras);
			$this->db->set("dan_cristFaros",$dan_cristFaros);
			$this->db->set("inf_sistEsc",$inf_sistEsc);
			$this->db->set("inf_amort",$inf_amort);
			$this->db->set("inf_tuberias",$inf_tuberias);
			$this->db->set("inf_transeje_transm",$inf_transeje_transm);
			$this->db->set("inf_sistDir",$inf_sistDir);
			$this->db->set("inf_chasisSucio",$inf_chasisSucio);
			$this->db->set("inf_golpesEspecif",$inf_golpesEspecif);

			$this->db->set("sfrenos_ddBalata",$sfrenos_ddBalata);
			$this->db->set("sfrenos_ddDisco",$sfrenos_ddDisco);
			$this->db->set("sfrenos_ddNeumat",$sfrenos_ddNeumat);
			$this->db->set("sfrenos_diBalata",$sfrenos_diBalata);
			$this->db->set("sfrenos_diDisco",$sfrenos_diDisco);
			$this->db->set("sfrenos_diNeumat",$sfrenos_diNeumat);
			$this->db->set("sfrenos_tdBalata",$sfrenos_tdBalata);
			$this->db->set("sfrenos_tdDisco",$sfrenos_tdDisco);
			$this->db->set("sfrenos_tdNeumat",$sfrenos_tdNeumat);
			$this->db->set("sfrenos_tiBalata",$sfrenos_tiBalata);
			$this->db->set("sfrenos_tiDisco",$sfrenos_tiDisco);
			$this->db->set("sfrenos_tiNeumat",$sfrenos_tiNeumat);
			$this->db->set("sfrenos_refNeumat",$sfrenos_refNeumat);
			$this->db->set("reqRev_inferior",$reqRev_inferior);
			$this->db->set("reqRev_sistFrenos",$reqRev_sistFrenos);
			$this->db->set("profecoFame",$profecoFame);

			$this->db->set("fecha_actualizacion", $fecha_actualizacion);
			$this->db->update("orden_servicio_inspeccion");

			$id = $orden_servicio;
		}	
			
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $id;
		}	
	}

	function trigger_exist($bd, $tabla){
		$this->db2 = $this->load->database("other", true);	
		$query = $this->db2->query("SELECT sys.sysobjects.name AS Tabla,sys.triggers.name AS [Trigger], 
						case when is_disabled = 0 
						then
						'ACTIVADO'
						else
						'DESACTIVADO'
						END As Estado
						FROM sys.triggers INNER JOIN
						sys.sysobjects ON sys.triggers.parent_id = sys.sysobjects.id 
						WHERE sys.sysobjects.name='".$tabla."' AND is_disabled = 0");
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }else{
			return null;
        }

	}

	/*function deshabilita_trigger($nombre, $tabla, $bd){
		//var_dump($bd);
		//die(' .. trigger deshabilitar');
		$this->db2 = $this->load->database("other", true);

		$this->db2->trans_begin();
		$this->db2->query("DISABLE TRIGGER $nombre ON $tabla");
		if ($this->db2->trans_status() === FALSE){
				$this->db2->trans_rollback();
				return false;
			}else{
				$this->db2->trans_commit();
				return true;
			}

	}
	function habilita_triggers($nombre, $tabla, $bd){
		$this->db2 = $this->load->database("other", true);
		$this->db2->trans_begin();
		$this->db2->query("ENABLE TRIGGER $nombre ON $tabla");

		if ($this->db2->trans_status() === FALSE){
			$this->db2->trans_rollback();
			return false;
		}else{
			$this->db2->trans_commit();
			return true;
		}
	}*/

	function traer_firma(){
		$this->load->database();
		$query = $this->db->query("select top 1 firma from firma_electronica order by id desc;");
		if($query->num_rows() > 0){
			return $query->result_array();
		}else
			return null;

	}

	function autocomplete_artAltaVin($cadena = null)
	{
		$this->db2 = $this->load->database('other',true); 

        $query = $this->db2->query("
        	SELECT TOP 5 Articulo, Descripcion1 AS Descripcion FROM Art WHERE Articulo  LIKE '".$cadena."%'
        	OR Articulo LIKE '".$cadena."%'
			OR Descripcion1 LIKE '".$cadena."%'
			OR Descripcion1 LIKE '".$cadena."%'"
        );

		$arrglo = $query->result_array();

		$row_set = [];
		foreach ($arrglo as $row) {
			$new_row['art'] = (''.$row['Articulo'].'');
			$new_row['descrip'] = ($row['Descripcion']);
            $row_set[] = $new_row;
		}
		
		return $row_set;
	}

	public function obtener_datosOrden($id_orden = null)
	{
		$intelisis = $this->load->database("other", TRUE);

		$datos["sucursal"] = $this->db->select("ds.*, s.nombre, s.sucursal_marca, a.razon_social, a.dom_calle_fiscal, a.dom_col_fiscal, a.dom_numExt_fiscal, a.dom_numInt_fiscal, a.dom_ciudad_fiscal, a.dom_estado_fiscal, a.dom_cp_fiscal")
									  ->from("datos_sucursal ds")
									  ->join("sucursal s", "ds.id_sucursal = s.id")
									  ->join("agencia a", "s.id_agencia = a.id")
									  ->where("ds.id_sucursal", $this->session->userdata["logged_in"]["id_sucursal"])
									  ->get()->row_array();

		// echo $this->db->last_query();die;
		$datos["reverso"] = $this->db->query("
			SELECT dom_calle, dom_numExt, dom_colonia, dom_ciudad, dom_estado, dom_cp, rfc
			FROM datos_sucursal WHERE id_sucursal = ?", array($this->session->userdata["logged_in"]["id_sucursal"])) 
		->row_array();
		
		// echo $this->db->last_query();die;						 
									  
		$datos["cliente"] = $this->db->select("*")
									 ->from("orden_servicio")
									 ->where("id", $id_orden)
									 ->where("eliminado", 0)
									 ->get()->row_array();

		
		$datos["cliente"] += $intelisis->select("MovID,Pasajeros,ar.Descripcion1")
												->from("Venta vta")
												->join("VIN vn", "vta.servicioSerie = vn.vin")
												->join("art ar", "ar.Articulo = vta.ServicioArticulo")
												->where("ID", $datos["cliente"]["id_orden_intelisis"])
												->get()->row_array(); 

		$datos["inspeccion"] = $this->db->select("*")
										->from("orden_servicio_inspeccion")
										->where("id_servicio", $id_orden)
										->get()->row_array();

		$datos["desglose"] = $this->db->select("*")
									  ->from("orden_servicio_desglose")
									  ->where("id_orden", $id_orden)
									  ->where("eliminado", 0)
									  ->get()->result_array();

		$datos["firma_cliente"] = $this->db->select("firma, firma_formatoInventario")
										   ->from("firma_electronica")
										   ->where("id_orden_servicio", $id_orden)
										   ->get()->row_array();

		$datos["asesor"] = $this->db->select("firma_electronica, nombre, apellidos")
									->from("usuarios")
									->where("id", $this->session->userdata["logged_in"]["id"])
									->get()->row_array();

							   
		return $datos;
	} 


	public function cargar_datsOrden_insp($id_orden = null)
	{
		$datos["inspeccion"] = $this->db->select("id ,id_servicio ,cajuela ,exteriores ,documentacion ,gasolina ,dejaArticulos ,articulos ,aceiteMotor ,direccionHidraulica ,liquidoTransmision ,liquidoLimpiaPara ,liquidoFreno ,pruebaParabrisas ,plumas ,llantas ,tambores ,discos ,balatas ,img ,fecha_creacion ,fecha_actualizacion ,bateria ,corriente_fabrica ,corriente_real ,nivel_carga ,luces ,parabrisas ,multipuntos
			,multipuntos_box ,multipuntos_input ,perdida_fluidos ,nivel_fluidos_cambiado ,plumaslimp_cambiado ,bateria_cambiado ,sistemas1_cambiado ,sistemas2_cambiado ,deposito_refrigerante ,multipuntos_text		,tecnico_inspeccion ,claxon ,luces_int ,radio ,pantalla ,ac ,encendedor ,vidrios ,espejos ,seguros_ele ,co ,asientosyvesti ,tapetes ,multipuntos_radio ,extension_garantia ,existen_danios ,dan_costDerecho,dan_parteDel ,dan_intAsAlf ,dan_costIzq ,dan_parteTras ,dan_cristFaros ,inf_sistEsc ,inf_amort ,inf_tuberias ,inf_transeje_transm ,inf_sistDir ,inf_chasisSucio ,inf_golpesEspecif ,sfrenos_ddBalata ,sfrenos_ddDisco ,sfrenos_ddNeumat ,sfrenos_diBalata ,sfrenos_diDisco ,sfrenos_diNeumat ,sfrenos_tdBalata ,sfrenos_tdDisco ,sfrenos_tdNeumat,sfrenos_tiBalata ,sfrenos_tiDisco ,sfrenos_tiNeumat ,sfrenos_refNeumat ,reqRev_inferior ,reqRev_sistFrenos ,profecoFame")
		// $datos["inspeccion"] = $this->db->select("*")
										->from("orden_servicio_inspeccion")
										->where("id_servicio", $id_orden)
										->get()->row_array();

		$datos["desglose"] = $this->db->select("*")
									  ->from("orden_servicio_desglose")
									  ->where("id_orden", $id_orden)
									  ->where("eliminado", 0)
									  ->get()->result_array();


		$datos["asesor"] = $this->db->select("firma_electronica, nombre, apellidos")
									->from("usuarios")
									->where("id", $this->session->userdata["logged_in"]["id"])
									->get()->row_array();

							   
		return $datos;
	} 


	public function buscar_OrdenesVin($vin = null){
		$intelisis = $this->load->database("other",true); 
		$ordenes = $intelisis->select('V.ID, V.MovID as Orden, V.FechaConclusion as FechaFacturacion, A.Nombre as NombreAgente, V.ServicioTipoOrden, V.ServicioKms as Kilometraje, V.Estatus')
			->from('Venta V')
			->join('Agente A', 'A.Agente = V.Agente', 'left')
			->where('V.Mov', "Servicio")
			->where('V.ServicioSerie', $vin)
			->where('V.AnexoID', null)
			->order_by('V.FechaConclusion', 'desc')
			->get()->result_array();
		if($ordenes){
			foreach ($ordenes as $key => $value) {
				$servicios = $intelisis->select("V.Articulo, V.DescripcionExtra, A.Agente+ ' ' + A.Nombre as agente,  TipoRenglon = 'Servicios'")
				->from('VentaD V')
				->join('Agente A', 'A.Agente = V.Agente', 'left')
				->where('V.ID', $value['ID'])
				->get()->result_array();
				$ordenes[$key]['servicios'] = $servicios;
				$ar = array('Trabajo Adicional','Autorizacion Trabajo','FIRM','Resultado de Trabajo', 'Recomendaciones Adicionales');
				$eventos = $intelisis->select("V.ID, TipoRenglon = 'Eventos', M.Tipo, M.Evento")
					->from('Venta V')
					->join('MovBitacora M', 'V.ID = M.ID')
					->where('V.Mov', "Servicio")
					->where('V.AnexoID', null)
					->where('V.ID', $value['ID'])
					->where_in('M.tipo',$ar)
					->order_by('V.FechaConclusion', 'desc')
					->get()->result_array();
				$ordenes[$key]['eventos'] = $eventos;
				$ordenes[$key]['tipo'] = "Orden de Servicio";
			}
			$ret['bandera'] = true;
			$ret['datos'] = $ordenes;
			
		}else{
			$ret['bandera'] = false;
			$ret['datos'] = [];
		}
		return $ret;
	}

	public function ver_datosMensaje($id_orden = null)
	{
		$datos_mensaje["orden"] = $this->db->select("nombre_cliente, ap_cliente, am_cliente, nom_compania, nom_contacto_compania, ap_contacto_compania, am_contacto_compania, asesor, fecha_creacion, placas_v")
										   ->from("orden_servicio")
										   ->where("id", $id_orden)
										   ->get()->row_array();

		$datos_mensaje["sucursal"] = $this->db->select("nombre")
											  ->from("sucursal")
											  ->where("id", $this->session->userdata["logged_in"]["id_sucursal"])
											  ->get()->row_array();

		return $datos_mensaje;						   
	} 

	public function guardar_horaRecep($id_cita = null, $tipo = null, $hora = null)
	{
		$this->db2 = $this->load->database('other',true);

		if($hora != null)
		{
			$time = strtotime($hora);
			$formato = date('d-m-Y H:i', $time);
		}else
		{
			$formato = null;
		}

		if($tipo == 1)
		{
			$venta["CFechaLlegada"] = $formato;
		}else
		{
			$venta["CFechaAtencion"] = $formato;
		}

		$this->db2->trans_start();

		$this->db2->where("ID", $id_cita);
		$this->db2->update("Venta", $venta);

		$this->db2->trans_complete();

		if($this->db2->trans_status() == true)
		{
			$estatus = true;
		}else
		{
			$estatus = false;
		}

		return $estatus;
	}
	public function actualizavin($vin, $id)	{		
		$int = $this->load->database("other", TRUE);		
		$int->trans_start();				
		$articulo = $int->select("Articulo")->from("VIN")->where("VIN", $vin)->get()->row_array();		
		$int->where("ID", $id);		
		$int->update("Venta", array("ServicioSerie"=> $vin,"ServicioArticulo"=> $articulo['Articulo']));		
		$int->trans_complete();		
		if($int->trans_status() == true){			
			$ret['saved'] = "ok";		
		}else{			
			$ret['saved'] = "ko";
		}		
		return $ret;
	}

	public function obtener_ordenesPasadas($fecha_ini = null, $fecha_fin = null)
	{	
		$intelisis = $this->load->database("other", TRUE);
		$usuario = $this->session->userdata["logged_in"]["cve_intelisis"];
		$perfil = $this->session->userdata["logged_in"]["perfil"];

		$where = " fecha_creacion BETWEEN '".date('d-m-Y', strtotime($fecha_ini))." 00:00:00' AND '".date('d-m-Y', strtotime($fecha_fin))." 23:59:59'";

		if($perfil == 6)																//refacciones
		{
			$cond_claveUs = "1 = 1";
		}else 
		{
			$cond_claveUs = "clave_asesor = '".$usuario."'";
		}
		
		$ordenes = $this->db->select("*")
							->from("orden_servicio")
							->where($cond_claveUs)
							->where("id_orden_intelisis IS NOT NULL")
							->where($where)
							->order_by("fecha_creacion", "ASC")
							->get()->result_array();
		//sql donde se evalua si la orden de servicio esta firmada o no devolviendo 1 o 0 el resultado lo recibe custom-ver_historico.js 
		foreach ($ordenes as $keyF => $valueF) 
		{
			$ordenes[$keyF]["contFirma"] =  $this->db->select(" COUNT(ID) AS contadorFirma ")
												->from("firma_electronica")
												->where('id_orden_servicio', $valueF["id"])
												->get()->row_array();
		}
		foreach ($ordenes as $key => $value) 
		{
			$ordenes[$key]["movID"] = $intelisis->select("MovID")
												->from("Venta")
												->where("ID", $value["id_orden_intelisis"])
												->get()->row_array(); 
		}

		return $ordenes;					
	}

	public function ver_datosHojaMult($id_orden = null)
	{
		$int = $this->load->database("other", TRUE);

		$datos["orden_servicio"] = $this->db->select("*")
						 				    ->from("orden_servicio")
						 				    ->where("id", $id_orden)
						                    ->get()->row_array();

		$mov_id = $int->select("MovID, ServicioIdentificador")
					  ->from("Venta")
					  ->where("ID", $datos["orden_servicio"]["id_orden_intelisis"])
					  ->get()->row_array();

		$datos["mov_id"] = (isset($mov_id["MovID"])) ? $mov_id["MovID"] : "";						//el movID lo da hasta que se afecta la orden
		$datos["num_torre"] = (isset($mov_id["ServicioIdentificador"])) ? $mov_id["ServicioIdentificador"] : "";		       

		$datos["orden_inspeccion"]["rev_asesor"] = $this->db->select("perdida_fluidos, nivel_fluidos_cambiado, aceiteMotor, direccionHidraulica, liquidoTransmision, liquidoFreno, liquidoLimpiaPara, deposito_refrigerante, pruebaParabrisas, plumas, plumaslimp_cambiado, sistemas1_cambiado, sistemas2_cambiado, luces, parabrisas, bateria, corriente_fabrica, corriente_real, nivel_carga, bateria_cambiado, extension_garantia")
														   ->from("orden_servicio_inspeccion")
														   ->where("id_servicio", $id_orden)
														   ->get()->row_array();

		$datos["orden_inspeccion"]["rev_tecnico"] = $this->db->select("multipuntos_box,multipuntos_radio, multipuntos_input, multipuntos_text, tecnico_inspeccion")
															->from("orden_servicio_inspeccion")
														    ->where("id_servicio", $id_orden)
														    ->get()->row_array();

		$datos["sucursal"] = $this->db->select("a.razon_social, s.nombre, ds.*")
									 ->from("sucursal s")
									 ->join("datos_sucursal ds", "s.id = ds.id_sucursal")
									 ->join("agencia a", "s.id_agencia = a.id")
									 ->where("s.sucursal_int", $datos["orden_servicio"]["id_sucursal_intelisis"])
									 ->get()->row_array();								

		$datos["firma_cliente"] = $this->db->select("firma, firma_multipuntos")
										   ->from("firma_electronica")
										   ->where("id_orden_servicio", $id_orden)
										   ->get()->row_array();
		// var_dump($datos);die;
		return $datos;
	}
	public function SaveDocsIntelisis($ruta, $id_orden, $tipo){
		//load database
		$this->db2 = $this->load->database("other", true);
		// variables
		$logged_in = $this->session->userdata("logged_in");
		
		$rama      = 'VTAS';
		if($tipo == 'orden'){
			$nombre    = 'FormatoDeOrdenServicio'.$id_orden.'.pdf';
		}else{
			$nombre    = 'HojaMultipuntos'.$id_orden.'.pdf';
		}
		$id        = $id_orden;
		$new_ruta  = str_replace("/", "\\", $ruta);
		$new_ruta  = substr($new_ruta,2);
		//corregir ruta dependiendo de donde esta la instalacion.
		$ruta      = 'C:\wamp\www\WebProyectos2'.$new_ruta;
		$icono     = 754;
		$tipo      = 'Archivo';
		$sucursal  = $logged_in["id_sucursal"];
		$fecha     =  date("d-m-Y");
		$cfd       = 0;

		//insert 
		$this->db2->query("INSERT INTO AnexoMov (Rama, ID, Nombre, Direccion, Icono, Tipo, Sucursal,
			FechaEmision, CFD) VALUES (?,?,?,?,?,?,?,?,?);", array($rama, $id, $nombre, $ruta, $icono, $tipo, 
			$sucursal,$fecha,$cfd));
	}

	public function guardar_bitacora( $msj, $id_){
		//load database
		$this->db2 = $this->load->database("other", true);
		$this->load->database();
		
		$logged_in = $this->session->userdata("logged_in");
		//load orden
		$oden_vta = $this->db->query("SELECT id_orden_intelisis FROM orden_servicio WHERE id = ?", array($id_))->result_array();
		//variables
		$modulo     = 'VTAS';
		$ID         = $oden_vta[0]['id_orden_intelisis'];//Id Venta
		$usuario    = 'SOPDESA';
		$sucursal   = $logged_in["id_sucursal"];
		$fecha      =  date("d-m-Y");
		$mensaje    = $msj;
		$tipo       = 'Comentario';
		$movStatus  = '';
		
		$this->db2->trans_begin();
		$query = $this->db2->query("INSERT INTO MovBitacora(Modulo,ID, Fecha, Evento, Tipo, Sucursal, Usuario, MovEstatus) VALUES(?,?,?,?,?,?,?,?) ",array(
			$modulo, $ID, $fecha, $mensaje, $tipo, $sucursal, $usuario, $movStatus
		));
		$user_id = $this->db2->insert_id();
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $user_id;
		}	
	}

	public function traerArticulosCita($datar){
		$tabla = "ServicioPaquetes";
		if ($this->Version == "V6000")
			$tabla = "CA_ServicioPaquetes";
		//load database
		$this->db2 = $this->load->database("other", true);
		$this->load->database();
		$OrigenID              = $datar['OrigenID'];

		// $query = $this->db2->query("
		// 	SELECT d.Articulo,d.Descripcion, d.Cantidad, d.PrecioUnitario, d.TipoArticulo, d.PrecioUnitario * d.Cantidad AS Total, spd.TipoPrecio, spd.Precio, spd.DescripcionC
		// 	from ServicioPaquetesD as d 
		// 	inner join art a on d.articulo = a.articulo
		// 	inner join ServicioPaquetes spd ON d.idPaquete = spd.id
		// 	where d.IdPaquete = ?", array($id));
		//Revisar si la cita tiene asignados articuls o mano de obra .
		$query = $this->db2->query("SELECT  vd.Renglon, vd.Cantidad, vd.Articulo,art.Descripcion1, vd.Precio, vd.PrecioSugerido, art.Tipo,d.tipoPrecio,d.precio ,d.ID as idp,d.DescripcionL,vd.Paquete,d.DescripcionC  FROM VentaD vd JOIN ART art ON art.Articulo = vd.Articulo 
			JOIN ". $tabla ." as d on vd.Paquete = d.Id
		 	WHERE vd.ID = ? ORDER BY vd.Paquete ", array($OrigenID));
		if($query->num_rows() > 0 )
        {
            return $query->result_array();
        }else{
			return null;
        }
	}
	public function detalle_normal($elementos){
		$this->db2 = $this->load->database("other", true);
		
		$arts_nor = [];
		$juego = [];
		$servicio = [];


		for ($i=0; $i < sizeof($elementos) ; $i++) { 

			$arts_nor = $this->db2->query("", array());
		}
		return $arts_nor;
	}
	public function traer_fotos($id){
		//load database
		$this->load->database();
		$query = $this->db->query("
			SELECT
				ruta_archivo,
				comentario
			FROM
				archivo
			WHERE
				id_orden_servicio = ? AND (tipo_archivo = 1 OR tipo_archivo = 2) and eliminado = 0", 
			array($id));
		
		if($query->num_rows() > 0 )
        {
        	return $query->result_array();
        }else{
			return false;
        }
	}
	public function fotos_seguimiento($data){
		$archivos = $this->db->select("*")->from("archivo")->where("id_orden_servicio", $data["id"])
					->where("tipo_archivo", 2)->where("eliminado", 0)->get()->result_array();
		if(empty($archivos)){
			$return["mensaje"] = "no hay imagenes para la orden";
		}
		else{
			$return["mensaje"] = "ok";
			$return["fotos"] = $archivos;
		}
				
		return $return;
	}
	public function GuardarPresupuesto($data){
		$data["detalles"] = parse_str($data["detalles"],$arr);
		// var_dump($arr);die();
		$insertP["fecha_creacion"] = date("d-m-Y H:i:s");
		$insertP["eliminado"] = 0;
		$insertP["id_orden"] = $arr['id_orden_b'];
		$insertP["total_presupuesto"] = $arr['precioTotal'];
		$insertP["autorizado"] = 0;
		$insertP["vista_email"] = 0;
		
		$this->db->trans_start();
		$this->db->insert('presupuestos',$insertP);
		$id_pres = $this->db->select("IDENT_CURRENT('presupuestos') as id")->get()->row_array();
		$arts = $data["articulos"];
		foreach ($arts as $key => $value) {
			$value["id_presupuesto"] = $id_pres['id'];
			$value["autorizado"] = 0;
			$this->db->insert('presupuesto_detalle',$value);
		}
		$this->db->trans_complete();
		if($this->db->trans_status() == true)
		{
			$response["estatus"] = true;
			$response["id_presupuesto"] = $id_pres['id'];
		}else
		{
			$response["estatus"] = false;
			$response["id_presupuesto"] = 'no';
		}
		return $response;
	}
	// public function GuardarPresupuesto($data){
	// 	$insertP["fecha_creacion"] = date("d-m-Y H:i:s");
	// 	$insertP["eliminado"] = 0;
	// 	$insertP["id_orden"] = $data['id_orden_b'];
	// 	$insertP["total_presupuesto"] = $data['precioTotal'];
	// 	unset($data["precioTotal"]);
	// 	unset($data["id_orden_b"]);
	// 	$data = array_reverse($data,true);
	// 	$this->db->trans_start();
	// 	$this->db->insert('presupuestos',$insertP);
	// 	$id_pres = $this->db->select("IDENT_CURRENT('presupuestos') as id")->get()->row_array();
	// 	$i = 1;
	// 	$keys = array_keys($data);
	// 	$last = end($keys);
	// 	$objects = substr($last, -1);
	// 	for ($i=1;$i<=$objects;$i++) {
	// 		$detalle["id_presupuesto"] = $id_pres['id'];
	// 		$detalle["cve_articulo"] = $data["cve_".$i];
	// 		$detalle["descripcion"] = $data["descrip_".$i];
	// 		$detalle["cantidad"] = $data["art_qty_".$i];
	// 		$detalle["precio_unitario"] = floatval($data["art_cost_".$i]);
	// 		$detalle["total_arts"] = $data["atotal_".$i];
	// 		$this->db->insert('presupuesto_detalle',$detalle);
	// 	}
	// 	$this->db->trans_complete();
	// 	if($this->db->trans_status() == true)
	// 	{
	// 		$response["estatus"] = true;
	// 		$response["id_presupuesto"] = $id_pres['id'];
	// 	}else
	// 	{
	// 		$response["estatus"] = false;
	// 		$response["id_presupuesto"] = 'no';
	// 	}
	// 	return $response;
	// }
	public function search_budget($id_orden){
		$num_pres = $this->db->select("id_presupuesto, total_presupuesto, autorizado")->from("presupuestos")->where("id_orden", $id_orden)->where("eliminado",0)->get()->result_array();
		if($num_pres){
			foreach ($num_pres as $key => $value) {
				$detalle = $this->db->select("*")->FROM("presupuesto_detalle")->where("id_presupuesto", $value['id_presupuesto'])->get()->result_array();
				$array[$key]['detalle'] = $detalle;
				$array[$key]['total_presupuesto'] = $value['total_presupuesto'];
				$array[$key]['autorizado'] = $value['autorizado'];
				$array[$key]['id_presupuesto'] = $value['id_presupuesto'];
			}
			$response["estatus"] = true;
			$response["pres"] = $array;
		}
		else{
			$response["mensaje"] = "No hay presupuestos relacionados con la orden";
			$response["estatus"] = false;
		}
		return $response;
	}

	public function datos_presupuesto($data = 0)
	{
		$ret['usuario'] = $this->db->select("presupuestos.*,orden_servicio.*, orden_servicio.id as id_orden, usuarios.email as correo_asesor")->from("presupuestos")
						->join("orden_servicio", "orden_Servicio.id = presupuestos.id_orden")
						->join("usuarios", "usuarios.cve_intelisis = orden_servicio.clave_asesor")
						->where("presupuestos.id_presupuesto", $data['id'])
						->get()->row_array();

		$ret['detalle'] = $this->db->select("*")->from("presupuesto_detalle")->where("id_presupuesto", $data['id'])->get()->result_array();
		$sucursal = $ret["usuario"]["id_sucursal_intelisis"];
		$ret["datos_sucursal"] = $this->db->select("datos_sucursal.*, sucursal.email_refacciones")
										  ->from("datos_sucursal")
										  ->join("sucursal","datos_sucursal.id_sucursal = sucursal.id")
										  ->where("sucursal.sucursal_int", $sucursal)
										  ->get()->row_array();
		$ret['agencia'] = $this->db->select("*")
										  ->from("agencia")
										  ->join("sucursal", "sucursal.id_agencia = agencia.id")
										  ->where("sucursal.sucursal_int", $sucursal)
										  ->get()->row_array();

		$intelisis = $this->load->database("other", TRUE);								  
		$ret["usuario"]["movID"] = $intelisis->select("MovID")
											 ->from("Venta")
											 ->where("ID", $ret["usuario"]["id_orden_intelisis"])
											 ->get()->row_array();	
		$intelisis->close();

		return $ret;
	}
	public function autorizar_presupuesto($estatus = null, $id_presupuesto = null){
		$dat["autorizado"] = $estatus;
		$this->db->trans_start();

		$this->db->where("id_presupuesto", $id_presupuesto);
		$this->db->update("presupuestos", $dat);

		$this->db->trans_complete();

		if($this->db->trans_status() == true)
		{
			$cliente["estatus"] = true;
			$cliente["mensaje"] ="Estatus del presupuesto actualizado";
			$cliente["id"] =$id_presupuesto;
		}else
		{
			$cliente["estatus"] = false;
			$cliente["mensaje"] = 'no';
		}
		return $cliente;
	}
	public function EditarPresupuesto($datos){
		$datos["detalles"] = parse_str($datos["detalles"],$arr);
		$existen = $this->db->select("*")->from("presupuesto_detalle")->where("id_presupuesto", $arr["id_presupuesto"])->get()->result_array();
		$new = $datos["articulos"];
		$this->db->trans_start();
		foreach ($existen as $value) {
			$this->db->where('id_presupuesto', $value["id_presupuesto"]);
			$this->db->delete('presupuesto_detalle'); 
		}
		foreach ($new as $key => $value) {
			$value["id_presupuesto"] = $arr["id_presupuesto"];
			$value["autorizado"] = 0;
			$this->db->insert("presupuesto_detalle", $value);
		}
		$this->db->where("id_presupuesto", $arr["id_presupuesto"]);
		$this->db->update("presupuestos", array("total_presupuesto"=>$arr["precioTotal"]));
		$this->db->trans_complete();
		if($this->db->trans_status() == true)
		{
			$cliente["estatus"] = true;
			$cliente["mensaje"] ="Presupuesto actualizado";
		}else
		{
			$cliente["estatus"] = false;
			$cliente["mensaje"] = 'Error al editar';
		}
		return $cliente;
	}
	public function Autorizar_articulo($datos){
		// print_r($datos);die();
		foreach ($datos["articulo"] as $value) {
			$this->db->trans_start();
			$this->db->where("id_presupuesto", $value["id_presupuesto"]);
			$this->db->where("cve_articulo", $value["clave_art"]);
			$this->db->update("presupuesto_detalle", array("autorizado"=>$value["autorizado"], "quien_autoriza" => $this->session->userdata["logged_in"]["cve_intelisis"], "fecha_autorizacion" => date("d-m-Y H:i:s")));
			$this->db->trans_complete();
		}
		
		if($this->db->trans_status() == true)
		{
			$cliente["estatus"] = true;
			$cliente["mensaje"] ="Estatus actualizado";
		}else
		{
			$cliente["estatus"] = false;
			$cliente["mensaje"] = 'Error al actualizar';
		}
		return $cliente;
	}
	public function presupuesto_mail_cte($datos =  null){
		// print_r($datos);die();
		$id_pres = $datos["id_presupuesto"];
		$this->db->trans_start();
		$this->db->where("id_presupuesto", $id_pres);
		$this->db->update("presupuestos", array("vista_email"=>1));
		$this->db->trans_complete();
		
		$elem = $this->db->select("cve_articulo")
								 ->from("presupuesto_detalle")
								 ->where("id_presupuesto", $id_pres)
								 ->get()->result_array();
								 
		if(isset($datos["datos"]))
		{			
			foreach ($datos["datos"] as $value) {
				$this->db->trans_start();
				$this->db->where("id_presupuesto", $id_pres);
				$this->db->where("cve_articulo", $value["value"]);
				$this->db->update("presupuesto_detalle", array("autorizado"=>1, "quien_autoriza" => "cliente", "fecha_autorizacion" => date("d-m-Y H:i:s")));
				$this->db->trans_complete();
			}

			$elem1 = [];
			foreach($elem as $key => $value) 
			{
				array_push($elem1, $value["cve_articulo"]);
			}

			$elem2 = [];
			foreach($datos["datos"] as $key => $value) 
			{
				array_push($elem2, $value["value"]);
			}

			$diferencia = array_diff($elem1, $elem2); 
			foreach($diferencia as $key => $value) 
			{
				$this->db->trans_start();
				$this->db->where("id_presupuesto", $id_pres);
				$this->db->where("cve_articulo", $value);
				$this->db->update("presupuesto_detalle", array("autorizado"=>0, "quien_autoriza" => "cliente", "fecha_autorizacion" => date("d-m-Y H:i:s")));
				$this->db->trans_complete();
		}
		}else 
		{		
			foreach($elem as $key => $value) 
			{
				$this->db->trans_start();
				$this->db->where("id_presupuesto", $id_pres);
				$this->db->where("cve_articulo", $value["cve_articulo"]);
				$this->db->update("presupuesto_detalle", array("autorizado"=>0, "quien_autoriza" => "cliente", "fecha_autorizacion" => date("d-m-Y H:i:s")));
				$this->db->trans_complete();
			}
		}
		
		if($this->db->trans_status() == true)
		{
			$cliente["estatus"] = true;
			$cliente["mensaje"] ="Estatus actualizado";
		}else
		{
			$cliente["estatus"] = false;
			$cliente["mensaje"] = 'Error al actualizar';
		}
		return $cliente;
	}
	public function Autorizar_todo($datos){
		
		$this->db->trans_start();
		$this->db->where("id_presupuesto", $datos["id_presupuesto"]);
		$this->db->update("presupuesto_detalle", array("autorizado"=>$datos["autorizado"]));
		$this->db->trans_complete();

		if($this->db->trans_status() == true)
		{
			$cliente["estatus"] = true;
			$cliente["mensaje"] ="Estatus actualizado";
		}else
		{
			$cliente["estatus"] = false;
			$cliente["mensaje"] = 'Error al actualizar';
		}
		return $cliente;
	}
	public function guardar_firma_multi($datos = null)
	{
		$usuarios["firma_multipuntos"] = $datos["firma_usu"];
		$usuarios["fecha_actualizacion"] = date("d-m-Y H:i:s");

		$this->db->trans_start();
		$exist = $this->db->select("*")->from("firma_electronica")->where("id_orden_servicio", $datos["id_orden_hidden"])->count_all_results();
		if($exist>0){
			$this->db->where("id_orden_servicio", $datos["id_orden_hidden"]);
			$this->db->update("firma_electronica", $usuarios);

			$this->db->where("id", $datos["id_orden_hidden"]);
			$this->db->update("orden_servicio", array("multipuntos"=>2));
		}else{
			$insert["id_orden_servicio"] = $datos["id_orden_hidden"];
			$insert["firma"] = $datos["firma_usu"];
			$insert["firma_multipuntos"] = $datos["firma_usu"];
			$insert["fecha_actualizacion"] = date("d-m-Y H:i:s");
			$insert["fecha_creacion"] = date("d-m-Y H:i:s");
			$insert["eliminado"] = 0;
			$this->db->insert("firma_electronica", $insert);
		}

		$this->db->trans_complete();
		
		if($this->db->trans_status() == true)
		{
			$estatus = true;
		}else 
		{
			$estatus = false;
		}

		return $estatus;
	}

	public function revisar_tickaje($data = 0)
	{
		$int = $this->load->database("other", TRUE);
		$ret = $int->select("ISNULL(CFechaLlegada,0) as CFechaLlegada, ISNULL(CFechaAtencion,0) as CFechaAtencion")->from("Venta")->where("id", $data['id'])->get()->row_array();

		//se hace consulta para saber si la sucursal tendra tickaje o no 
		$logged_in = $this->session->userdata("logged_in");
		$sucursal= $logged_in["id_sucursal"];
		$ret['valTickaje']= $this->db->select("tickaje")->from("sucursal")->where("id", $sucursal)->get()->row_array();
	
		return $ret;
	}

	public function obtener_datosFormato_inventario($id_orden = null)
	{
		$datos["orden"] = $this->obtener_datosOrden($id_orden);

		return $datos;
	}
}