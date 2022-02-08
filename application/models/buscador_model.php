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
require_once APPPATH.'libraries/PDFMerger/PDFMerger.php';
use PDFMerger\PDFMerger;

class Buscador_Model extends CI_Model{

	private $Version = 'V4000';
	private $vista = 'PaquetesWeb';
	//private $ruta_formts = "F:/recepcion/assets";
	private $ruta_formts = '../recepcion/assets/uploads/';

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

	public function obtener_configEmail()
	{
		//se agreg en caso de que no detecte variable de session mandar datos smtp de sucursal 1
		$suc_sess_mail = 1;
		if (isset($this->session->userdata["logged_in"]["id_sucursal"])) {
			$suc_sess_mail= $this->session->userdata["logged_in"]["id_sucursal"];
		}
		$query = $this->db->query(" SELECT mail_host, mail_smtpAuth, mail_userName, mail_password, mail_smtpSecure, mail_port 
				FROM sucursal 
				WHERE id = ".  $suc_sess_mail . "");

		if($query->num_rows() > 0){
			return $query->result_array();
		}else
			return null;
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
					DISTINCT
					art.Articulo,
					art.Descripcion1,
					art.Unidad,
					ISNULL(li.Precio, 0) AS Precio,
					ISNULL(li.Lista, 'Precio Publico') AS Lista
				FROM
					Art art
				LEFT JOIN ListaPreciosD li ON Art.Articulo = li.Articulo
				--habilitar unicamente para las ford
				Inner JOIN OperacionesEreactValidas oert ON oert.Articulo = art.Articulo
				WHERE
					art.Tipo = 'Servicio'
					AND art.categoria <> 'TOT'
					AND art.Estatus = 'ALTA'
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

		$tabla = "MovTipoValidarUEN";
		if ($this->Version == 'V6000'){ 
			$tabla = "CA_MovTipoValidarUEN";
		}

		$query['UEN']  = $this->db2->query("SELECT  UEN, Nombre from  uen join ".$tabla." muv on muv.UENValida = UEN.UEN 
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
	// Datos Vehículo
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

		$xp = "LimpiaListaSt";
		if ($this->Version == 'V6000'){ 
			$xp = "xpCA_LimpiaListaSt";
		}
		
		$this->db2->query("exec ".$xp." 888");
		$this->db2->query("INSERT INTO ListaSt (Estacion, Clave) VALUES (888,?)", array($idpak));
		// echo $this->db2->last_query();
		// echo $user_id;.
		$sp = "spGenerarDetalleST";
		if ($this->Version == 'V6000'){ 
			$sp = "xpCA_spGenerarDetalleST";
		}

		$ok = $this->db2->query("DECLARE @OkRef varchar(250) EXEC ".$sp." 'VentaD',?,?,?,888,1,@OkRef OUTPUT SELECT @OkRef", array($user_id,$Empresa,$Sucursal));
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
						isset($manodeobra[$i]['Agente']) ? $manodeobra[$i]['Agente'] : $Agente,
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

		//tabla daños
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
		$existe_orden = $this->db->select("id")
						   ->from("orden_servicio")
						   ->where("id", $orden_servicio)
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

		if($existe_orden > 0) {
			foreach ($data['articulos_personales'] as $key => $articulos_personales) {
				if ($articulos_personales != '') {
					$causa_raiz['id_orden_servicio']       = $orden_servicio;
					$causa_raiz['autorizacion_grabar_voz'] = $data['autorizacion_voz'];
					$causa_raiz['definicion_falla']        = isset($data['articulos_personales'][$key]) ?  $data['articulos_personales'][$key] : null;
					$causa_raiz['arranca_vehiculo']        = isset($data['arranca'][$key]) ? 1 : 0;
					$causa_raiz['inicia_movimiento']       = isset($data['inicia'][$key]) ? 1 : 0;
					$causa_raiz['disminuye_vel']           = isset($data['disminuye'][$key]) ? 1 : 0;
					$causa_raiz['da_vuelta_izq']           = isset($data['vuelta_izq'][$key]) ? 1 : 0;
					$causa_raiz['da_vuelta_der']           = isset($data['vuelta_der'][$key]) ? 1 : 0;
					$causa_raiz['pasa_tope']               = isset($data['tope'][$key]) ? 1 : 0;
					$causa_raiz['pasa_bache']              = isset($data['bache'][$key]) ? 1 : 0;
					$causa_raiz['cambia_vel']              = isset($data['cambia'][$key]) ? 1 : 0;
					$causa_raiz['esta_sin_movimiento']     = isset($data['movimiento'][$key]) ? 1 : 0;
					$causa_raiz['constantemente']          = isset($data['constantemente'][$key]) ? 1 : 0;
					$causa_raiz['esperodicamente']         = isset($data['esporadicamente'][$key]) ? 1 : 0;
					$causa_raiz['asiento']                 = isset($data['asiento'][$key]) ? 1 : 0;
					$causa_raiz['volante']                 = isset($data['volante'][$key]) ? 1 : 0;
					$causa_raiz['cristales']               = isset($data['cristales'][$key]) ? 1 : 0;
					$causa_raiz['carroceria']              = isset($data['carroceria'][$key]) ? 1 : 0;
					$causa_raiz['cofre']                   = isset($data['cofre'][$key]) ? 1 : 0;
					$causa_raiz['cajuela']                 = isset($data['cajuela_f'][$key]) ? 1 : 0;
					$causa_raiz['toldo']                   = isset($data['toldo'][$key]) ? 1 : 0;
					$causa_raiz['debajo']                  = isset($data['debajo'][$key]) ? 1 : 0;
					$causa_raiz['estando_dentro']          = isset($data['dentro'][$key]) ? 1 : 0;
					$causa_raiz['estando_fuera']           = isset($data['fuera'][$key]) ? 1 : 0;
					$causa_raiz['estando_frente']          = isset($data['frente'][$key]) ? 1 : 0;
					$causa_raiz['estando_detras']          = isset($data['detras'][$key]) ? 1 : 0;
					$causa_raiz['temp_ambiente']           = isset($data['temperatura'][$key]) ?  $data['temperatura'][$key] : null;
					$causa_raiz['humedad']                 = isset($data['humedad'][$key]) ? $data['humedad'][$key] : null;
					$causa_raiz['viento']                  = isset($data['viento'][$key]) ? $data['viento'][$key] : null;
					$causa_raiz['vel_km_hr']               = isset($data['velocidad'][$key]) ? $data['velocidad'][$key] : null;
					$causa_raiz['cambio_transmision']      = isset($data['cambioTransmision'][$key]) ? $data['cambioTransmision'][$key] : null;
					$causa_raiz['rpmx1000']                = isset($data['rpm'][$key]) ? $data['rpm'][$key] : null;
					$causa_raiz['carga']                   = isset($data['carga'][$key]) ? $data['carga'][$key] : null;
					$causa_raiz['pasajeros']               = isset($data['pasajeros'][$key]) ? $data['pasajeros'][$key] : null;
					$causa_raiz['cajuela_cond_operativa']   = isset($data['cajuela'][$key]) ? $data['cajuela'][$key] : null;
					$causa_raiz['estructura']              = isset($data['estructura'][$key]) ? $data['estructura'][$key] : null;
					$causa_raiz['camino']                  = isset($data['camino'][$key]) ? $data['camino'][$key] : null;
					$causa_raiz['pendiente']               = isset($data['pendiente'][$key]) ? $data['pendiente'][$key] : null;
					$causa_raiz['firma_cliente']           = isset($data['valor_firma'][$key]) ?  $data['valor_firma'][$key] : null;
					$causa_raiz['cambio_tipo']             = isset($data['cambioTipo'][$key]) ? $data['cambioTipo'][$key] : null;
					if (isset($data['id'][$key]) && $data['id'][$key] != '') {
						$id_causa_raiz[] = $data['id'][$key];
						$this->db->where('id', $data['id'][$key]);
						$this->db->update('causa_raiz_componente', $causa_raiz);
					} else {
						$id_causa_raiz[] = $this->db->insert('causa_raiz_componente', $causa_raiz);
					}
				}
			}
		}

		$this->db->trans_complete();
		
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

		
		$clientes = $intelisis->select("MovID,Pasajeros,ar.Descripcion1")
												->from("Venta vta")
												->join("VIN vn", "vta.servicioSerie = vn.vin")
												->join("art ar", "ar.Articulo = vta.ServicioArticulo")
												->where("ID", $datos["cliente"]["id_orden_intelisis"])
												->get()->row_array(); 

		$datos["cliente"]+= is_array($clientes) ? $clientes:[];
												/*echo "<pre>"; print_r($clientes);
												echo "</pre>";*/

		$datos["inspeccion"] = $this->db->select("*")
										->from("orden_servicio_inspeccion")
										->where("id_servicio", $id_orden)
										->get()->row_array();

		//modificacion para obtener detalle de orden de servicio desde ventaD intelisis
		$datos["desglose"] = $intelisis->select("(Precio*Cantidad)+((SUM((Precio*Cantidad)) * Impuesto1 ) / 100) as iva_total, Articulo as articulo, DescripcionExtra as descripcion, Cantidad as cantidad, Precio as precio_unitario, (Precio*Cantidad) as total")
			->from("VentaD")
			->where("ID", $datos["cliente"]["id_orden_intelisis"])
			->where('ventad.cantidad > isnull(ventad.cantidadcancelada,0)')
			->group_by('precio, cantidad, impuesto1, articulo,DescripcionExtra')
			->get()->result_array();

		$datos["firma_cliente"] = $this->db->select("firma, firma_formatoInventario")
										   ->from("firma_electronica")
										   ->where("id_orden_servicio", $id_orden)
										   ->get()->row_array();

		$datos["asesor"] = $this->db->select("firma_electronica, nombre, apellidos")
									->from("usuarios")
									->where("id", $this->session->userdata["logged_in"]["id"])
									->get()->row_array();
		/*
			Cambio realizado para un ticket pendite de revisar si solo es para la agencia del ticket
			$datosAsesor = $intelisis->select('eMail,Telefonos')->from('agente')->where('agente', $datos['cliente']['clave_asesor'])->get()->row_array();
			$datos['contacto_asesor'] = is_array($datosAsesor) ? $datosAsesor: ['eMail' => 'no asignado', 'Telefonos' => ' no asignado'];
		*/
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
		//se obtiene el id de sucursal a la que pertenece el usuario de la tabla sucursal en bd recepcion
		$suc_login = $this->session->userdata["logged_in"]["id_sucursal"];

		//se obtiene el  id_intelisis de la sucursal a la cual pertenece el usuario en la bd de la empresa
		$suc_or['id'] = $this->db->select("id_servicio")
							->from("sucursal")
							->where('id', $suc_login)
							->get()->row_array();

		//print_r($suc_or['id']['id_intelisis']); die();
		$where = " fecha_creacion BETWEEN '".date('d-m-Y', strtotime($fecha_ini))." 00:00:00' AND '".date('d-m-Y', strtotime($fecha_fin))." 23:59:59'";
		if($perfil == 2)																//refacciones
		{
			$cond_claveUs = "1 = 1 and  id_sucursal_intelisis = ".$suc_or['id']['id_servicio']."  ";
			//$cond_claveUs = "1 = 1 ";
		}else if($perfil == 4 || $perfil == 5 || $perfil == 6 || $perfil == 7 || $perfil == 8){
			$usuario = "AM2";
			$cond_claveUs = "clave_asesor = '".$usuario."'";
		}else if($perfil == 4 || $perfil == 5 || $perfil == 7 || $perfil == 8){ //se debe reacomodar esta condicional
			//$usuario = "AM2";
			$cond_claveUs = " movimiento IS NOT NULL";
		}else 
		{
			$cond_claveUs = "clave_asesor = '".$usuario."'";
		}
		
		$ordenes = $this->db->select("*")
							->from("orden_servicio")
							->where($cond_claveUs)
							->where("id_orden_intelisis IS NOT NULL")
							->where("eliminado = 0")
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
		// valor  de firma para la carta de extension a garantia que usara historico
		foreach ($ordenes as $keyF => $valueF) 
		{
			$ordenes[$keyF]["signGrtia"] =  $this->db->select(" firma_renunciaGarantia ")
												->from("firma_electronica")
												->where('id_orden_servicio', $valueF["id"])
												->get()->row_array();
		}

		$ordenes_validas = [];
		foreach ($ordenes as $key => $value) 
		{
			$venta = $intelisis->select("Estatus")
												->from("Venta")
												->where("ID", $value["id_orden_intelisis"])
												->get()->row_array(); 
			$ordenes[$key]["movID"] = $intelisis->select("MovID")
												->from("Venta")
												->where("ID", $value["id_orden_intelisis"])
												->get()->row_array(); 
			$ordenes[$key]["origenID"] = $intelisis->select("origenID")
												->from("Venta")
												->where("ID", $value["id_orden_intelisis"])
												->get()->row_array(); 
			if (isset($venta['Estatus']) && $venta['Estatus'] != 'CANCELADO') {
				$ordenes_validas[] = $ordenes[$key];
			}
		}

		foreach ($ordenes_validas as $key => $value) 
		{
			$firma = $this->db->select("firma_electronica as signAsesor")
							->from("usuarios")
							->where("cve_intelisis",$value['clave_asesor'])
							->get()->row_array();
							
			$ordenes_validas[$key] += is_array($firma) ? $firma : ['signAsesor' => null];
		}

		return $ordenes_validas;					
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
	/*public function SaveDocsIntelisis($ruta, $id_orden, $tipo){
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
	}*/

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
	public function GuardaVerificacion($data){
		$data["detalles"] = parse_str($data["detalles"],$arr);
		//var_dump($arr);die();
		$insertP["fecha_creacion"] = date('d-m-Y');
		$insertP["eliminado"] = 0;
		$insertP["id_orden"] = $arr['id_orden_b'];
		$insertP["total_presupuesto"] = $arr['precioTotal'];
		$insertP["autorizado"] = 0;
		$insertP["vista_email"] = 0;
		$insertP['id_tecnico'] = $data['id_tecnico'];

		$this->db->trans_start();
		$this->db->insert('verificacion_refacciones',$insertP);
		$id_pres = $this->db->select("IDENT_CURRENT('verificacion_refacciones') as id")->get()->row_array();
		$arts = $data["articulos"];
		foreach ($arts as $key => $value) {
			$value["id_presupuesto"] = $id_pres['id'];
			$value["autorizado"] = 0;
			$this->db->insert('detalles_verificacion_refacciones',$value);
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
	public function search_verificacion($id_orden){
		$num_pres = $this->db->select("id_presupuesto, total_presupuesto, autorizado")->from("verificacion_refacciones")->where("id_orden", $id_orden)->where("eliminado",0)->get()->result_array();
		if($num_pres){
			foreach ($num_pres as $key => $value) {
				$detalle = $this->db->select("*")->FROM("detalles_verificacion_refacciones")->where("id_presupuesto", $value['id_presupuesto'])->get()->result_array();
				$array[$key]['detalle'] = $detalle;
				$array[$key]['total_presupuesto'] = $value['total_presupuesto'];
				$array[$key]['autorizado'] = $value['autorizado'];
				$array[$key]['id_presupuesto'] = $value['id_presupuesto'];
			}
			$response["estatus"] = true;
			$response["pres"] = $array;
		}
		else{
			$response["mensaje"] = "No hay verificaciones relacionadas con la orden";
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
						/*echo "<pre>";
						print_r($this->db->last_query());
						echo "</pre>";*/
		$ret['user'] = $this->db->select("usuarios.nombre, usuarios.apellidos, usuarios.email as correo_refacciones")->from("usuarios")
						->where("usuarios.perfil", 6, "presupuestos.id_presupuesto", $data['id'])
						->get()->row_array();
		$ret['userTecnico'] = $this->db->select("usuarios.nombre, usuarios.apellidos, usuarios.actualizado, usuarios.email as correo_tecnico")->from("usuarios")
						->where("usuarios.perfil", 5, "presupuestos.id_presupuesto", $data['id'])
						->get()->row_array();
		
		$ret['detalle'] = $this->db->select("*")->from("presupuesto_detalle")->where("id_presupuesto", $data['id'])->get()->result_array();
		/*echo "<pre>";
		print_r($ret['detalle']);
		echo "</pre>";*/
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
	public function datos_verificacion($data = 0)
	{
		$ret['usuario'] = $this->db->select("verificacion_refacciones.*,orden_servicio.*, orden_servicio.id as id_orden, usuarios.email as correo_asesor")->from("verificacion_refacciones")
						->join("orden_servicio", "orden_Servicio.id = verificacion_refacciones.id_orden")
						->join("usuarios", "usuarios.cve_intelisis = orden_servicio.clave_asesor")
						->where("verificacion_refacciones.id_presupuesto", $data['id'])
						->get()->row_array();
						/*echo "<pre>";
						print_r($this->db->last_query());
						echo "</pre>";*/
		$ret['user'] = $this->db->select("usuarios.nombre, usuarios.apellidos, usuarios.email as correo_refacciones")->from("usuarios")
						->where("usuarios.perfil", 6)
						->get()->row_array();
		$ret['userTecnico'] = $this->db->select("usuarios.nombre, usuarios.apellidos, usuarios.actualizado, usuarios.email as correo_tecnico")->from("usuarios")
						->where("usuarios.perfil", 5)
						->where("usuarios.id", $ret['usuario']['id_tecnico'])
						->get()->row_array();
		$ret['detalle'] = $this->db->select("*")->from("detalles_verificacion_refacciones")->where("id_presupuesto", $data['id'])->get()->result_array();
		/*echo "<pre>";
		print_r($ret['detalle']);
		echo "</pre>";*/
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
	public function autorizar_verificacion($estatus = null, $id_presupuesto = null){
		$dat["autorizado"] = $estatus;
		$this->db->trans_start();

		$this->db->where("id_presupuesto", $id_presupuesto);
		$this->db->update("verificacion_refacciones", $dat);

		$this->db->trans_complete();

		if($this->db->trans_status() == true)
		{
			$refacciones["estatus"] = true;
			$refacciones["mensaje"] ="Estatus del presupuesto actualizado";
			$refacciones["id"] =$id_presupuesto;
		}else
		{
			$refacciones["estatus"] = false;
			$refacciones["mensaje"] = 'no';
		}
		return $refacciones;
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
	public function EditarVerificacion($datos){
		$logged_in =  $this->session->userdata("logged_in");
		$perfil    =  $logged_in["perfil"];
		$datos["detalles"] = parse_str($datos["detalles"],$arr);
		$existen = $this->db->select("*")->from("detalles_verificacion_refacciones")->where("id_presupuesto", $arr["id_presupuesto"])->get()->result_array();
		$new = $datos["articulos"];
		$this->db->trans_start();
		foreach ($existen as $value) {
			$this->db->where('id_presupuesto', $value["id_presupuesto"]);
			$this->db->delete('detalles_verificacion_refacciones'); 
		}
		foreach ($new as $key => $value) {
			$value["id_presupuesto"] = $arr["id_presupuesto"];
			$value["en_existencia"] = 0;
			$this->db->insert("detalles_verificacion_refacciones", $value);
		}
		$this->db->where("id_presupuesto", $arr["id_presupuesto"]);
		if ($perfil == 5){
		$this->db->update("verificacion_refacciones", array("total_presupuesto"=>$arr["precioTotal2"], "id_tecnico"=>$datos['id_tecnico']));
		}
		$this->db->trans_complete();
		if($this->db->trans_status() == true)
		{
			$refacciones["estatus"] = true;
			$refacciones['id'] = $arr["id_presupuesto"];
			$refacciones["mensaje"] ="Verificación actualizada";
		}else
		{
			$refacciones["estatus"] = false;
			$refacciones["mensaje"] = 'Error al editar';
		}
		return $refacciones;
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
	public function verificar_articulo($datos){
		// print_r($datos);die();
		foreach ($datos["articulo"] as $value) {
			$this->db->trans_start();
			$this->db->where("id_presupuesto", $value["id_presupuesto"]);
			$this->db->where("cve_articulo", $value["clave_art"]);
			$this->db->update("detalles_verificacion_refacciones", array("en_existencia"=>$value["autorizado"], "quien_autoriza" => $this->session->userdata["logged_in"]["cve_intelisis"], "fecha_autorizacion" => date("d-m-Y H:i:s")));
			/*echo "<pre>";
			print_r($this->db->last_query());
			echo "</pre>";*/
			$this->db->trans_complete();
		}
		
		if($this->db->trans_status() == true)
		{
			$refacciones["estatus"] = true;
			$refacciones["mensaje"] ="Estatus actualizado";
		}else
		{
			$refacciones["estatus"] = false;
			$refacciones["mensaje"] = 'Error al actualizar';
		}
		return $refacciones;
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
	public function verificacion_mail_refacciones($datos =  null){
		// print_r($datos);die();
		$id_pres = $datos["id_presupuesto"];
		$this->db->trans_start();
		$this->db->where("id_presupuesto", $id_pres);
		$this->db->update("verificacion_refacciones", array("vista_email"=>1));
		$this->db->trans_complete();
		
		$elem = $this->db->select("cve_articulo")
								 ->from("detalles_verificacion_refacciones")
								 ->where("id_presupuesto", $id_pres)
								 ->get()->result_array();
								 
		if(isset($datos["datos"]))
		{			
			foreach ($datos["datos"] as $value) {
				//print_r($value['name']);
				$this->db->trans_start();
				$this->db->where("id_presupuesto", $id_pres);
				$this->db->where("cve_articulo", $value["value"]);
				$this->db->update("detalles_verificacion_refacciones", array("en_existencia"=>1, "quien_autoriza" => "refacciones", "fecha_autorizacion" => date("d-m-Y")));
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
				$this->db->update("detalles_verificacion_refacciones", array("en_existencia"=>0, "quien_autoriza" => "refacciones", "fecha_autorizacion" => date("d-m-Y H:i:s")));
				$this->db->trans_complete();
		}
		}else 
		{		
			foreach($elem as $key => $value) 
			{
				$this->db->trans_start();
				$this->db->where("id_presupuesto", $id_pres);
				$this->db->where("cve_articulo", $value["cve_articulo"]);
				$this->db->update("detalles_verificacion_refacciones", array("en_existencia"=>0, "quien_autoriza" => "refacciones", "fecha_autorizacion" => date("d-m-Y H:i:s")));
				$this->db->trans_complete();
			}
		}
		
		if($this->db->trans_status() == true)
		{
			$refacciones["estatus"] = true;
			$refacciones["mensaje"] ="Estatus actualizado";
		}else
		{
			$refacciones["estatus"] = false;
			$refacciones["mensaje"] = 'Error al actualizar';
		}
		return $refacciones;
	}
	/*public function verificar_todo($datos){
		
		$this->db->trans_start();
		$this->db->where("id_presupuesto", $datos["id_presupuesto"]);
		$this->db->update("detalles_verificacion_refacciones", array("en_existencia"=>$datos["en_existencia"]));
		$this->db->trans_complete();

		if($this->db->trans_status() == true)
		{
			$refacciones["estatus"] = true;
			$refacciones["mensaje"] ="Estatus actualizado";
		}else
		{
			$refacciones["estatus"] = false;
			$refacciones["mensaje"] = 'Error al actualizar';
		}
		return $refacciones;
	}*/
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
	public function cargar_oasis($ruta, $oasis, $id_orden = null)
	{
		$response = [
			"estatus" => false,
			"ruta" => ""
		];
		 $data = explode( ',', $oasis );
		/*$f = fopen($ruta."FormatoDeOrdenServicio".$id_orden.".pdf", "wb");
		// guardamos en el archivo el contenido que hay despues de la coma
		fwrite($f, base64_decode($data[1]));
		fclose($f);*/
		$orden = $this->db->select('vin')->from('orden_servicio')->where(['id' => $id_orden])->get()->row_array();
		$ruta = RUTA_FORMATS.$orden["vin"].'/'.$id_orden;
		if(!file_exists($ruta)) {
			mkdir($ruta, 0777, true);
		}
		$ruta .= '/';
		$bin = base64_decode($data[1], true);
		if ($id_orden !== null) {
			file_put_contents($ruta."FormatoOasis".$id_orden.".pdf", $bin);
			if(file_exists($ruta."FormatoOasis".$id_orden.".pdf"))
			{
				$archivo = [
					'id_orden_servicio' => $id_orden,
					'tipo_archivo' => 7,
					'fecha_creacion' => date("d-m-Y H:i:s"),
					'fecha_actualizacion' => date("d-m-Y H:i:s"),
					'eliminado' => 0,
					'comentario' => '',
					'ruta_archivo' => $ruta."FormatoOasis".$id_orden.".pdf"
				];
				$this->db->trans_start();
				$this->db->insert("archivo", $archivo);
				$id_registro = $this->db->select("IDENT_CURRENT('archivo') as id")->get()->row_array();
				$this->db->where('id', $id_orden);
				$this->db->update('orden_servicio', ['oasis' => 1]);
				$this->db->trans_complete();

				if($this->db->trans_status() == true)
				{
					$response["estatus"] = true;
					$response["ruta"] = $ruta."FormatoOasis".$id_orden.".pdf";
					$response['id_registro'] = $id_registro;
				}else
				{
					$response["estatus"] = false;
					$response["ruta"] = "";
				}
			}else
			{
				$response["estatus"] = false;
				$response["ruta"] = "";
			}
		}
		return $response;
	}
	public function guardar_voc($datos = null)
	{
		//$vocs = $datos['voc'];
		$vocs = $_FILES;
		$files = [];
		$audios   = $this->db->select('id')->from('archivo')->where(['id_orden_servicio' => $datos["id_orden_servicio"], 'tipo_archivo' => 8])->count_all_results();
		foreach($vocs as $key => $value) 
		{
			$datos["voc"] = $value;
			$datos['id'] = ++$audios;
			$archivo_creado = $this->crear_archivo($datos);
			$files[] = ($archivo_creado) ? true : false;
		}

		return $files;
	}
	public function crear_archivo($datos = null)
	{
		$archivo = $datos["voc"];
		$datos["vin"] = trim($datos["vin"]);
		$ruta = RUTA_FORMATS.''.$datos["vin"].'/'.$datos["id_orden_servicio"].'/voc-'.$datos['id'].'.mp3'; 
		if(!file_exists(RUTA_FORMATS.''.$datos["vin"].'/'.$datos["id_orden_servicio"])) {
			mkdir(RUTA_FORMATS.''.$datos["vin"].'/'.$datos["id_orden_servicio"], 0777, true);
		}
		//$nombrearchivo = $archivo["name"];
		$nombrearchivo = 'voc-'.$datos['id'].'.mp3'; 
		move_uploaded_file($archivo["tmp_name"], $ruta);
		if(file_exists($ruta)) {

			$archivo = [
					'id_orden_servicio' => $datos['id_orden_servicio'],
					'tipo_archivo' => 8,
					'fecha_creacion' => date("d-m-Y H:i:s"),
					'fecha_actualizacion' => date("d-m-Y H:i:s"),
					'eliminado' => 0,
					'comentario' => '',
					'ruta_archivo' => $ruta
				];
				$this->db->trans_start();
				$this->db->insert("archivo", $archivo);
				$this->db->trans_complete();
				if($this->db->trans_status() == FALSE)
				{
					$this->db->trans_rollback();
					$creado = false;
				}else
				{
					$this->db->trans_commit();
					$creado = true;
				}
			$creado = true;
		}else {
			$creado = false;
		}
		return $creado;
	}
	public function get_archivos_orden_servicio($id_orden = null, $tipo = 7)
	{
		$this->load->database();
		$query = $this->db->query("select archivo.id, archivo.id_orden_servicio, archivo.tipo_archivo, archivo.ruta_archivo, tipo_archivo.tipo from archivo INNER JOIN tipo_archivo ON (archivo.tipo_archivo = tipo_archivo.id) where archivo.id_orden_servicio = {$id_orden} and archivo.tipo_archivo = {$tipo} and archivo.eliminado = 0 order by archivo.id ASC;");
		if($query->num_rows() > 0){
			return $query->result_array();
		}else
			return [];
	}
	public function cargar_documentacion($ruta_temp, $tipos, $id_orden)
	{
		$archivos = $_FILES;
		$files    = [];
		$columna  = 0;
		$pdfs     = $this->db->select('id')->from('archivo')->where(['id_orden_servicio' => $id_orden, 'tipo_archivo' => 7])->count_all_results();
		$audios   = $this->db->select('id')->from('archivo')->where(['id_orden_servicio' => $id_orden, 'tipo_archivo' => 8])->count_all_results();
		$orden = $this->db->select('vin')->from('orden_servicio')->where(['id' => $id_orden])->get()->row_array();
		foreach($archivos as $key => $value) 
		{
			if ( $tipos[$columna] == 'PDF') {
				$pdfs++;
			} else {
				$audios++;
			}
			$datos["archivo"]           = $value;
			$datos['id']                =  $tipos[$columna] == 'PDF' ? $pdfs : $audios;
			$datos['id_orden_servicio'] = $id_orden;
			$datos['tipo']              = $tipos[$columna] == 'PDF' ? 7 : 8;
			$datos['tipo_nombre']       = $tipos[$columna];
			$datos['vin']               = $orden['vin'];
			$archivo_creado             = $this->crear_archivo_v2($datos);
			$files[]                    = ($archivo_creado) ? true : false;
		}

		return $files;
	}
	public function crear_archivo_v2($datos = null)
	{
		$archivo = $datos["archivo"];
		$ruta = RUTA_FORMATS.''.$datos['vin'].'/'.$datos["id_orden_servicio"].'/'.$datos['tipo_nombre']."-".$datos["id"].($archivo["type"] == "application/pdf" ? ".pdf" : ".mp3"); 
		if(!file_exists(RUTA_FORMATS.''.$datos['vin'].'/'.$datos["id_orden_servicio"])) {
			mkdir(RUTA_FORMATS.''.$datos['vin'].'/'.$datos["id_orden_servicio"], 0777, true);
		}
		$nombrearchivo = $archivo["name"];
		move_uploaded_file($archivo["tmp_name"], $ruta);
		if(file_exists($ruta)) {
			$archivo = [
					'id_orden_servicio'   => $datos['id_orden_servicio'],
					'tipo_archivo'        => $datos['tipo'],
					'fecha_creacion'      => date("d-m-Y H:i:s"),
					'fecha_actualizacion' => date("d-m-Y H:i:s"),
					'eliminado'           => 0,
					'comentario'          => '',
					'ruta_archivo'        => $ruta
				];
				$this->db->trans_start();
				$this->db->insert("archivo", $archivo);
				$this->db->trans_complete();
				if($this->db->trans_status() === FALSE)
				{
					$creado = false;
					$this->db->trans_rollback();
				}else
				{
					$this->db->trans_commit();
					$creado = true;
				}
			$creado = true;
		}else {
			$creado = false;
		}
		return $creado;
	}
	public function abrir_pregarantia($id_orden_servicio)
	{
		$this->db2 = $this->load->database("other", true);
		$xp       = "xpCA_CopiarSoloEncabezadoGarantia";
		$modulo   = "VTAS";
		$mov      = "Servicio";
		$usuario  = $this->session->userdata('logged_in')['usuario_intelisis'];

		$orServicio = $this->db->select('id_orden_intelisis')->from('orden_servicio')->where('id', $id_orden_servicio)->get()->row();
		$idIntelisis= $orServicio->id_orden_intelisis;

		$ok = $this->db2->query("DECLARE @OkRef varchar(250) EXEC ".$xp." ?,?,?,?,?,?,?,?,?,?,?,?,?,@OkRef OUTPUT,0,0 SELECT @OkRef", 
		array($modulo, $idIntelisis, $mov, $usuario, date('d/m/Y'),'SINAFECTAR','Pesos', 1 , NULL, 1, 'Servicio', NULL, NULL));
		$id = $this->db2->query("SELECT ident_current('Venta') AS id;")->row_array()['id'];
		$response['id'] = $id;
		$ordenServicioRecep = $this->db->select('*')->from('orden_servicio')->where('id', $id_orden_servicio)->get()->row_array();
		$this->db->trans_start();
		$ordenServicioRecep['movimiento']          = $ordenServicioRecep['id'];
		$ordenServicioRecep['fecha_creacion']      = date('d-m-Y H:i:s');
		$ordenServicioRecep['fecha_actualizacion'] = date('d-m-Y H:i:s');
		$ordenServicioRecep['fecha_recepcion'] = date('d-m-Y H:i:s',strtotime($ordenServicioRecep['fecha_recepcion']));
		$ordenServicioRecep['fecha_entrega'] = date('d-m-Y H:i:s',strtotime($ordenServicioRecep['fecha_entrega']));
		$ordenServicioRecep['fecha_termCond'] = date('d-m-Y H:i:s',strtotime($ordenServicioRecep['fecha_termCond']));
		$ordenServicioRecep['tipo_orden'] = 'Garantia';
		$ordenServicioRecep['id_orden_intelisis'] = $id;
		$this->db->trans_complete();
		if( $this->db->trans_status() === FALSE)
		{
			$response["estatus"] = false;
			$response["update"] = $this->db->affected_rows() > 0;
			$this->db->trans_rollback();
		}else
		{
			$this->db->trans_commit();
			$response["estatus"] = true;
			$response["update"] = $this->db->affected_rows() > 0;
		}
		unset($ordenServicioRecep['id']);
		$this->db->insert('orden_servicio', $ordenServicioRecep);

		return $response;
	}
	public function obtener_datos_quejas($id_orden_servicio)
	{
		$query = $this->db->select('id, id_orden_servicio, autorizacion_grabar_voz, definicion_falla, arranca_vehiculo, inicia_movimiento, disminuye_vel, da_vuelta_izq, da_vuelta_der, pasa_bache, pasa_tope, cambia_vel, esta_sin_movimiento, constantemente, volante, esperodicamente, asiento, cristales, carroceria, cofre, cajuela, toldo, estando_dentro, estando_fuera, estando_frente, estando_detras, temp_ambiente, humedad, viento, vel_km_hr, cambio_transmision, rpmx1000, cambio_tipo, carga, pasajeros, cajuela_cond_operativa, estructura, camino, pendiente, firma_cliente, debajo')
			->from('causa_raiz_componente')
			->where('id_orden_servicio', $id_orden_servicio)
			->get();
			if($query->num_rows() > 0){
				return  $query->result_array();
			}else{
				return [];
			}
	}
	public function eliminar_archivo_documentacion($id_archivo)
	{
		$this->db->trans_start();
		$this->db->where('id', $id_archivo);
		$this->db->update('archivo', ['eliminado' => 1]);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Archivo inexistente.';
			$this->db->trans_rollback();
		}else {
			$response['estatus'] = true;
			$response['mensaje'] = 'Archivo eliminado correctamente.';
			$this->db->trans_commit();
		}
		return $response;
	}
	public function autorizar_pregarantia($id_orden)
	{
		$firma = $this->db->select('firma_electronica')->from('usuarios')->where("id", $this->session->userdata["logged_in"]["id"])->get()->row_array();
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		if(isset($firma['firma_electronica']) && !empty($firma['firma_electronica'])){
			$existe_firma = $this->db->select("*")
								 ->from("firma_electronica")
								 ->where("id_orden_servicio", $id_orden)
								 ->count_all_results();
			if($existe_firma == 0){
				$response['estatus'] = false;
				$response['mensaje']=['No tienes firmas registradas.'];
			}else {
				$existencia = $this->db->select("verificacion_refacciones.id_presupuesto")->from("verificacion_refacciones")
				->join("detalles_verificacion_refacciones", "verificacion_refacciones.id_presupuesto = detalles_verificacion_refacciones.id_presupuesto AND detalles_verificacion_refacciones.en_existencia = 1")
				->where("verificacion_refacciones.id_orden",$id_orden)
				->count_all_results();
				$verificaciones = $this->db->select('*')->from('verificacion_refacciones')->where("id_orden", $id_orden)->count_all_results();
				
				if ($verificaciones > 0 && $existencia > 0) {
					$this->db->trans_start();
					$this->db->where('id_orden_servicio', $id_orden);
					if ($perfil == 4){
						$this->db->update('firma_electronica', ['firma_pregarantiaJefe' => $firma['firma_electronica']]);
					}
					if ($perfil == 8){
						$this->db->update('firma_electronica', ['firma_pregarantiaGerente' => $firma['firma_electronica']]);
					}
					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$response['estatus'] = false;
						$response['mensaje'] = 'No se pudo autorizar firma.';
					}else {
						$this->db->trans_commit();
						$response['estatus'] = true;
					}
				}else {
					$response['estatus'] = false;
					$response['mensaje']='La orden no cuenta con cotizaciones o existencia de refacciones registradas.';
				}
			}
		}else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No tienes firma registrada.';
		}
		return $response;
	}
	public function obtenerFirmasPregarantia($id_orden)
	{
		$pregarantia = $this->db->select('*')
		->from('orden_servicio')->where("movimiento", $id_orden)->count_all_results();
		if ($pregarantia > 0){
			$response['estatus'] = false;
			$response['mensaje'] =['Ya existe una pregarantia abierta para esta orden.'];

		}else{
		$response['data'] = $this->db->select("*")->from('firma_electronica')->where('id_orden_servicio', $id_orden)->get()->result_array();
		$response['estatus'] = sizeof($response['data']) > 0;	
		}
		return $response;
	}

	public function cancelar_firma_pregarantia($id_orden)
	{
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		$existe_firma = $this->db->select("*")
								 ->from("firma_electronica")
								 ->where("id_orden_servicio", $id_orden)
								 ->count_all_results();
			if($existe_firma == 0){
				$response['estatus'] = false;
				$response['mensaje']=['No tienes firmas para cancelar.'];
			}else {
				$this->db->trans_start();
				$this->db->where('id_orden_servicio', $id_orden);
				if($perfil == 4){$this->db->update('firma_electronica', ['firma_pregarantiaJefe' => null]);}
				if($perfil == 8){$this->db->update('firma_electronica', ['firma_pregarantiaGerente' => null]);}
				if($perfil == 7){$this->db->update('firma_electronica', ['firma_pregarantiaAdmon' => null]);}

				$this->db->trans_complete();
				if ($this->db->trans_status() === TRUE) {
					$this->db->trans_commit();
					$response['estatus'] = true;
				}else {
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No se pudo cancelar la autorización.';
				}
			}
		return $response;
	}

	public function autorizar_adicional($id_orden)
	{
		$firma = $this->db->select('firma_electronica')->from('usuarios')->where("id", $this->session->userdata["logged_in"]["id"])->get()->row_array();
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		if(isset($firma['firma_electronica']) && !empty($firma['firma_electronica'])){
			$existe_firma = $this->db->select("*")
								 ->from("firma_electronica")
								 ->where("id_orden_servicio", $id_orden)
								 ->count_all_results();
			if($existe_firma == 0){
				$response['estatus'] = false;
				$response['mensaje']=['No tienes firmas registradas.'];
			}else {
				$this->db->trans_start();
				$this->db->where('id_orden_servicio', $id_orden);
				if($perfil == 4){
				$this->db->update('firma_electronica', ['firma_adicionalJefe' => $firma['firma_electronica']]);
				}
				if($perfil == 8){
				$this->db->update('firma_electronica', ['firma_adicionalGerente' => $firma['firma_electronica']]);
				}
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No se pudo autorizar firma.';
				}else {
					$this->db->trans_commit();
					$response['estatus'] = true;
				}
			}
		}else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No tienes firma registrada.';
		}
		return $response;
	}
	
	public function obtenerFirmaAdd($id_orden)
	{
		return $this->db->select("*")->from('firma_electronica')->where('id_orden_servicio', $id_orden)->get()->result_array();
	}

	public function cancelar_firma_adicional($id_orden)
	{
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		$existe_firma = $this->db->select("*")
								 ->from("firma_electronica")
								 ->where("id_orden_servicio", $id_orden)
								 ->count_all_results();
			if($existe_firma == 0){
				$response['estatus'] = false;
				$response['mensaje']=['No tienes firmas para cancelar.'];
			}else {
				$this->db->trans_start();
				$this->db->where('id_orden_servicio', $id_orden);
				if($perfil == 4){$this->db->update('firma_electronica', ['firma_adicionalJefe' => null]);}
				if($perfil == 8){$this->db->update('firma_electronica', ['firma_adicionalGerente' => null]);}
				if($perfil == 7){$this->db->update('firma_electronica', ['firma_adicionalAdmon

					' => null]);}
				$this->db->trans_complete();
				if ($this->db->trans_status() === TRUE) {
					$this->db->trans_commit();
					$response['estatus'] = true;
				}else {
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No se pudo cancelar la autorización.';
				}
			}
		return $response;
	}
	public function autorizar_cp($id_orden)
	{
		$firma = $this->db->select('firma_electronica')->from('usuarios')->where("id", $this->session->userdata["logged_in"]["id"])->get()->row_array();
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		if(isset($firma['firma_electronica']) && !empty($firma['firma_electronica'])){
			$existe_firma = $this->db->select("*")
								 ->from("firma_electronica")
								 ->where("id_orden_servicio", $id_orden)
								 ->count_all_results();
			if($existe_firma == 0){
				$response['estatus'] = false;
				$response['mensaje']=['No tienes firmas registradas.'];
			}else {
				$this->db->trans_start();
				$this->db->where('id_orden_servicio', $id_orden);
				if($perfil == 4){
				$this->db->update('firma_electronica', ['firma_carroParado' => $firma['firma_electronica']]);
				}
				if($perfil == 8){
				$this->db->update('firma_electronica', ['firma_carroParado' => $firma['firma_electronica']]);
				}
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No se pudo autorizar firma.';
				}else {
					$this->db->trans_commit();
					$response['estatus'] = true;
				}
			}
		}else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No tienes firma registrada.';
		}
		return $response;
	}
	public function obtenerFirmaCP($id_orden)
	{
		return $this->db->select("*")->from('firma_electronica')->where('id_orden_servicio', $id_orden)->get()->result_array();
	}

	public function cancelar_firma_cp($id_orden)
	{
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		$existe_firma = $this->db->select("*")
								 ->from("firma_electronica")
								 ->where("id_orden_servicio", $id_orden)
								 ->count_all_results();
			if($existe_firma == 0){
				$response['estatus'] = false;
				$response['mensaje']=['No tienes firmas para cancelar.'];
			}else {
				$this->db->trans_start();
				$this->db->where('id_orden_servicio', $id_orden);
				if($perfil == 4){$this->db->update('firma_electronica', ['firma_carroParado' => null]);}
				$this->db->trans_complete();
				if ($this->db->trans_status() === TRUE) {
					$this->db->trans_commit();
					$response['estatus'] = true;
				}else {
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No se pudo cancelar la autorización.';
				}
			}
		return $response;
	}
	public function obtener_firmas($id_orden)
	{
		$firmas = [];
		//$result = $this->db->select('IIF(firma IS NOT NULL, 1, 0) AS Profeco, IIF(firma_multipuntos IS NOT NULL, 1, 0) AS "Hoja Multipuntos", IIF(firma_formatoInventario IS NOT NULL, 1, 0) AS "Formato Inventiario", IIF(firma_renunciaGarantia IS NOT NULL, 1, 0) AS "Carta Renuncia Garant\u00eda", IIF(firma_pregarantiaJefe IS NOT NULL OR firma_pregarantiaGerente IS NOT NULL, 1, 0) AS "Pregarant\u00eda", IIF(firma_adicionalJefe IS NOT NULL AND firma_adicionalGerente IS NOT NULL, 1, 0) AS "ADD(Adicional)", IIF(firma_carroParado IS NOT NULL, 1, 0) AS "Carro Parado"')->from('firma_electronica')->where('id_orden_servicio', $id_orden)->get();
		$result = $this->db->select('IIF(firma IS NOT NULL, 1, 0) AS Profeco, IIF(firma_multipuntos IS NOT NULL, 1, 0) AS "Hoja Multipuntos", IIF(firma_formatoInventario IS NOT NULL, 1, 0) AS "Formato Inventiario", IIF(firma_renunciaGarantia IS NOT NULL, 1, 0) AS "Carta Renuncia Garant\\u00eda", IIF(firma_pregarantiaJefe IS NOT NULL OR firma_pregarantiaGerente IS NOT NULL, 1, 0) AS "Pregarant\\u00eda"')->from('firma_electronica')->where('id_orden_servicio', $id_orden)->get();
		$firmas = $result->row_array();
		$orden = $this->db->select('*')->from('orden_servicio')->where('id', $id_orden)->get()->row_array();
		if ($orden['movimiento']) {
			//$aux = $this->db->select('IIF(firma IS NOT NULL, 1, 0) AS Profeco, IIF(firma_multipuntos IS NOT NULL, 1, 0) AS "Hoja Multipuntos", IIF(firma_formatoInventario IS NOT NULL, 1, 0) AS "Formato Inventiario", IIF(firma_renunciaGarantia IS NOT NULL, 1, 0) AS "Carta Renuncia Garant\u00eda", IIF(firma_pregarantiaJefe IS NOT NULL OR firma_pregarantiaGerente IS NOT NULL, 1, 0) AS "Pregarant\u00eda", IIF(firma_adicionalJefe IS NOT NULL AND firma_adicionalGerente IS NOT NULL, 1, 0) AS "ADD(Adicional)", IIF(firma_carroParado IS NOT NULL, 1, 0) AS "Carro Parado"')->from('firma_electronica')->where('id_orden_servicio', $orden['movimiento'])->get()->row_array();
			$aux = $this->db->select('IIF(firma IS NOT NULL, 1, 0) AS Profeco, IIF(firma_multipuntos IS NOT NULL, 1, 0) AS "Hoja Multipuntos", IIF(firma_formatoInventario IS NOT NULL, 1, 0) AS "Formato Inventiario", IIF(firma_renunciaGarantia IS NOT NULL, 1, 0) AS "Carta Renuncia Garant\\u00eda", IIF(firma_pregarantiaJefe IS NOT NULL OR firma_pregarantiaGerente IS NOT NULL, 1, 0) AS "Pregarant\\u00eda"')->from('firma_electronica')->where('id_orden_servicio', $orden['movimiento'])->get()->row_array();
			if (!is_array($firmas)) {
				$firmas = [];
			}
			$firmas = array_merge($firmas, $aux);
		}
		if (sizeof($firmas) > 0) {
			$response['estatus'] = true;
			$response['data'] = $firmas;
			$response['mensaje'] = "Firmas obtenidas con éxito.";
		} else {
			$response['estatus'] = false;
			$response['mensaje'] = "No hay firmas para esta orden de serivicio.";
		}
		return $response;
	}
	public function obtener_datos_cp($id_orden, $id_orden_intelisis, $vin)
	{
		$result = $this->db->select('IIF(carro_parado IS NOT NULL, 1, 0) AS "Carro Parado"')->from('orden_servicio')->where('id', $id_orden)->get();
		if ($result->num_rows() > 0) {
			$this->db2 = $this->load->database('other',true);
		$datos = $this->db2->select('v.Cliente AS cliente, v.ServicioIdentificador, ServicioNumero, MovID')->from('Venta AS v')->where('id', $id_orden)->get()->row_array();
		$response['cliente'] = $this->db2->select(" '0' as ID, c.cliente,,c.Contacto2, c.nombre,c.PersonalTelefonoMovil AS Celular, c.RFC, c.Telefonos, c.Direccion, c.DireccionNumero, c.TelefonosLada,c.Extencion2,c.DireccionNumeroInt, c.Colonia, c.Poblacion, c.Estado, c.CodigoPostal, c.eMail1, c.Cliente, '".$vin."' as ServicioSerie,c.PersonalNombres,ISNULL(c.PersonalNombres2,' ') AS 'PersonalNombres2',ISNULL(c.PersonalApellidoPaterno,'') AS 'PersonalApellidoPaterno',ISNULL(c.PersonalApellidoMaterno,'') AS 'PersonalApellidoMaterno' ")->from("Cte c")->where("c.Cliente",$datos['cliente'])->get()->row_array();
		$response['vehiculo'] = $this->db2->select ("Vin.Articulo as ServicioArticulo ,vin.Modelo, vin.Placas, vin.Km,  vin.Vin as ServicioSerie, vin.ColorExteriorDescripcion")->from("Vin vin")
			->where("vin.Vin", urldecode($vin))->get()->row_array();
		$response['agente'] = $this->db2->query("Select ag.agente, ag.nombre FROM Venta vta INNER JOIN Agente ag ON ag.Agente = vta.Agente WHERE vta.ID = ?" ,$id_orden)->row_array();
		$response['datos'] = $datos;
		if (!empty($response)) {
			$response['estatus'] = true;
			$response['mensaje'] = 'Ok.';
		}else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No fue posible recuperar datos de la orden.';
		}
		} else {
			$response['estatus'] = false;
			$response['mensaje'] = "Formato de Carro Parado no necesario, el vehículo es apto para entregarse al cliente.";
		}
		return $response;
	}
	public function autorizar_refacc($id_orden)
	{
		$firma = $this->db->select('firma_electronica')->from('usuarios')->where("id", $this->session->userdata["logged_in"]["id"])->get()->row_array();
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		if(isset($firma['firma_electronica']) && !empty($firma['firma_electronica'])){
			$existe_firma = $this->db->select("*")
								 ->from("firma_electronica")
								 ->where("id_orden_servicio", $id_orden)
								 ->count_all_results();
			if($existe_firma == 0){
				$response['estatus'] = false;
				$response['mensaje']=['No tienes firmas registradas.'];
			}else {
				$this->db->trans_start();
				$this->db->where('id_orden_servicio', $id_orden);
				if($perfil == 6){
				$this->db->update('firma_electronica', ['firma_refacc' => $firma['firma_electronica']]);
				}
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No se pudo autorizar firma.';
				}else {
					$this->db->trans_commit();
					$response['estatus'] = true;
				}
			}
		}else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No tienes firma registrada.';
		}
		return $response;
	}
	
	public function obtenerFirmaRefacc($id_orden)
	{
		return $this->db->select("*")->from('firma_electronica')->where('id_orden_servicio', $id_orden)->get()->result_array();
	}

	public function cancelar_firma_refacc($id_orden)
	{
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		$existe_firma = $this->db->select("*")
								 ->from("firma_electronica")
								 ->where("id_orden_servicio", $id_orden)
								 ->count_all_results();
			if($existe_firma == 0){
				$response['estatus'] = false;
				$response['mensaje']=['No tienes firmas para cancelar.'];
			}else {
				$this->db->trans_start();
				$this->db->where('id_orden_servicio', $id_orden);
				if($perfil == 6){$this->db->update('firma_electronica', ['firma_refacc' => null]);}
				$this->db->trans_complete();
				if ($this->db->trans_status() === TRUE) {
					$this->db->trans_commit();
					$response['estatus'] = true;
				}else {
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No se pudo cancelar la autorización.';
				}
			}
		return $response;
	}
	public function recibo_refacc($id_orden)
	{
		$firma = $this->db->select('firma_electronica')->from('usuarios')->where("id", $this->session->userdata["logged_in"]["id"])->get()->row_array();
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		if(isset($firma['firma_electronica']) && !empty($firma['firma_electronica'])){
			$existe_firma = $this->db->select("*")
								 ->from("firma_electronica")
								 ->where("id_orden_servicio", $id_orden)
								 ->count_all_results();
			if($existe_firma == 0){
				$response['estatus'] = false;
				$response['mensaje']=['No tienes firmas registradas.'];
			}else {
				$this->db->trans_start();
				$this->db->where('id_orden_servicio', $id_orden);
				if($perfil == 5){
				$this->db->update('firma_electronica', ['firma_tecnico' => $firma['firma_electronica']]);
				}
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No se pudo autorizar firma.';
				}else {
					$this->db->trans_commit();
					$response['estatus'] = true;
				}
			}
		}else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No tienes firma registrada.';
		}
		return $response;
	}
	
	public function obtenerFirmaTecnico($id_orden)
	{
		return $this->db->select("*")->from('firma_electronica')->where('id_orden_servicio', $id_orden)->get()->result_array();
	}

	public function cancelar_firma_tecnico($id_orden)
	{
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		$existe_firma = $this->db->select("*")
								 ->from("firma_electronica")
								 ->where("id_orden_servicio", $id_orden)
								 ->count_all_results();
			if($existe_firma == 0){
				$response['estatus'] = false;
				$response['mensaje']=['No tienes firmas para cancelar.'];
			}else {
				$this->db->trans_start();
				$this->db->where('id_orden_servicio', $id_orden);
				if($perfil == 5){$this->db->update('firma_electronica', ['firma_tecnico' => null]);}
				$this->db->trans_complete();
				if ($this->db->trans_status() === TRUE) {
					$this->db->trans_commit();
					$response['estatus'] = true;
				}else {
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No se pudo cancelar la autorización.';
				}
			}
		return $response;
	}
	public function obtener_pdf_api($token, $datos, $contentType = 'Content-Type:application/json')
	{
		$data = [];
		foreach ($datos as $key => $dato) {
			$data[$key] = $dato;
		}
		$payload = json_encode($data);
		$headers = [
			$contentType,
			'Authorization: Token '. $token,
			'Content-Length: ' . strlen($payload)
		];
		$URL = $datos['url'] ? $datos['url'] : "https://isapi.intelisis-solutions.com/reportes/getPDF";
		$request = curl_init();
		$response= [];
		curl_setopt($request, CURLOPT_URL, $URL);
		curl_setopt($request, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($request, CURLOPT_HEADER, 1);
		curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($request, CURLOPT_POST, 1);
		curl_setopt($request, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($request, CURLOPT_BINARYTRANSFER, TRUE);
		$result = curl_exec($request);
		$info = curl_getinfo($request);
		if (curl_errno($request)) {
			$response['estatus'] = false;
			$response['mensaje'] = "Error al consumir la api";
		} elseif (empty($info['http_code']) || $info['http_code'] != 200) {
				$response['estatus'] = false;
				$response['mensaje'] = 'No fue posible generar el formato.';
				curl_close($request);
		} else {
			curl_close($request);
			$datos['vin'] = str_replace('.', '', $datos['vin']);
			$ruta = RUTA_FORMATS.$datos['vin']."/".$datos['id_orden'];
			if(!file_exists($ruta)) 
			{
				mkdir($ruta, 0777, true);
			}
			$ruta .= "/";
			$pdf = fopen("{$ruta}{$datos['name']}-{$datos['id_orden']}.pdf", 'w');
			fwrite($pdf, $result);
			fclose($pdf);
			if (file_exists("{$ruta}{$datos['name']}-{$datos['id_orden']}.pdf")) {
				$archivo = file_get_contents("{$ruta}{$datos['name']}-{$datos['id_orden']}.pdf");
				$archivo64 = 'data:application/pdf;base64,' . base64_encode($archivo);
				$response['estatus'] = true;
				$response['mensaje'] = "Archivo creado exitosamente.";
				$response['data'] = [
					'ruta' => base_url("{$ruta}{$datos['name']}-{$datos['id_orden']}.pdf"),
					'nombre' => "{$datos['name']}-{$datos['id_orden']}",
					'archivo' => $archivo64,
					'ruta_rel' => "{$ruta}{$datos['name']}-{$datos['id_orden']}.pdf"
				];
			}else {
				$response['estatus'] = false;
				$response['mensaje'] = "No fue posible guardar el archivo.";
			}
		}
		return $response;
	}
	public function get_archivos_f1863($id_orden = null, $tipo = 7, $f1863 = "")
	{
		$this->load->database();
		$query = $this->db->query("select archivo.id, archivo.id_orden_servicio, archivo.tipo_archivo, archivo.ruta_archivo, tipo_archivo.tipo from archivo INNER JOIN tipo_archivo ON (archivo.tipo_archivo = tipo_archivo.id) where archivo.id_orden_servicio = {$id_orden} and archivo.tipo_archivo = {$tipo} and archivo.eliminado = 0 {$f1863} order by archivo.id desc;");
		if($query->num_rows() > 0){
			return $query->result_array();
		}else
			return [];
	}
	public function obtener_union_pdf($token, $datos)
	{
		$aux = 0;
		$mensaje = "";
		#$pdfs = "";
		$pdfs = [];
		$response = [];
		$ruta = RUTA_FORMATS."{$datos['id_orden']}/";
		/*if(!file_exists($ruta)) {
			mkdir($ruta, 0777, true);
		}*/
		foreach ($datos['archivos'] as $key => $archivo) {;
			if (file_exists($archivo["ruta_archivo"])) {
				$pdf['data']= chunk_split(base64_encode(file_get_contents($archivo['ruta_archivo'])));
				$pdf['extension'] = pathinfo($archivo['ruta_archivo'], PATHINFO_EXTENSION);
				$pdfs[] = $pdf;
				$aux++;
			}
		}
		if ($aux > 0) {
			$datos['archivos'] = $pdfs;
			$response = $this->obtener_pdf_api($token, $datos);
		}else {
			$mensaje = "No hay documentación generada en PDF, ";
		}
		if ($aux > 0 && file_exists("{$response['data']['ruta_rel']}")) {
			$response["estatus"] = true;
			$response["mensaje"] = "Archivo generado exitosamente.";
			$response["nombre"] = "formato-{$datos['id_orden']}";
		} else {
			$response["estatus"] = false;
			$response["mensaje"] = "{$mensaje}Archivo no generado.";
		}
		return $response;
	}
	public function guardar_formato($id_orden, $ruta)
	{
		$existe = $this->db->select('id')->from('archivo')->where(['id_orden_servicio' =>$id_orden, 'ruta_archivo' => $ruta])->get()->row_array();
		$creado = false;
		if(isset($existe['id'])){
			$archivo = [
				'fecha_actualizacion' => date("d-m-Y H:i:s"),
				'ruta_archivo' => $ruta
			];
			$this->db->trans_start();
			$this->db->where('id', $existe['id']);
			$this->db->update("archivo", $archivo);
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$creado = false;
				$this->db->trans_rollback();
			}else
			{
				$this->db->trans_commit();
				$creado = true;
			}
		}else {
			$archivo = [
				'id_orden_servicio' => $id_orden,
				'tipo_archivo' => 7,
				'fecha_creacion' => date("d-m-Y H:i:s"),
				'fecha_actualizacion' => date("d-m-Y H:i:s"),
				'eliminado' => 0,
				'comentario' => '',
				'ruta_archivo' => $ruta
			];
			$this->db->trans_start();
			$this->db->insert("archivo", $archivo);
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$creado = false;
				$this->db->trans_rollback();
			}else
			{
				$this->db->trans_commit();
				$creado = true;
			}
		}
			return $creado;
	}
	public function guardar_requisiciones($idOrden, $datos)
	{
		$firma = $this->db->select('firma_electronica')->from('usuarios')->where("id", $this->session->userdata["logged_in"]["id"])->get()->row_array();
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		if(isset($firma['firma_electronica']) && !empty($firma['firma_electronica'])){
		$logged_in = $this->session->userdata("logged_in");
		$tecnico = $this->db->select('CONCAT( nombre, \' \', apellidos) AS nombre')->from('usuarios')->where('id', $logged_in['id'])->get()->row_array();
		$datos['total_presupuesto'] = str_ireplace(',', '', $datos['total_presupuesto']);
		$requisicion = [
			'no_requisicion'    => null,
			'fecha_requisicion' => date('d-m-Y H:i:s'),
			'fecha_recepcion'   => null,
			'nom_tecnico'       => isset($tecnico['nombre']) ? $tecnico['nombre'] : null,
			'id_orden'          => $idOrden,
			'total_presupuesto' => $datos['total_presupuesto'],
			'id_usuario'        => $logged_in['id'],
			'firma_de_tecnico'	=> $firma['firma_electronica']
		];
	}
		$this->db->trans_start();
		$this->db->insert('requisiciones', $requisicion);
		$id = $this->db->insert_id();
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$response['estatus'] = false;
			$response['mensaje'] = 'No fue posible guardar la requisición.';
			return $response;
		}else
		{
			$this->db->trans_commit();
			$response['estatus'] = true;
			$response['mensaje'] = 'Requisición guardada.';
			$response['id']      = $id;
		}
		$this->db->trans_start();
		foreach ($datos['detalles'] as $key => $detalles) {
			$detalles['precio_unitario'] = str_ireplace(',', '', $detalles['precio_unitario']);
			$detalles['total_arts'] = str_ireplace(',', '', $detalles['total_arts']);
			$insert = [
				'id_requisicion'  => $id,
				'cantidad'        => isset($detalles['cantidad']) ? $detalles['cantidad'] : null,
				'cve_articulo'    => isset($detalles['cve_articulo']) ? $detalles['cve_articulo'] : null,
				'descripcion'     => isset($detalles['descripcion']) ? $detalles['descripcion'] : null,
				'precio_unitario' => isset($detalles['precio_unitario']) ? $detalles['precio_unitario'] : null,
				'total_arts'      => isset($detalles['total_arts']) ? $detalles['total_arts'] : null
			];
			$this->db->insert('detalles_requisiciones', $insert);
		}
		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$response['estatus'] = false;
			$response['mensaje'] = 'No fue posible guardar las piezas de la requisición.';
		}else
		{
			$this->db->trans_commit();
			$response['estatus'] = true;
			$response['mensaje'] = 'Requisición y detalles guardada.';
		}
		return $response;
	}
	public function guardar_diagnostico($idOrden, $datos)
	{
		$diagnostico = [
			'id_orden'             => $idOrden,
			'parte_causante'       => isset($datos['parte_causante']) ? $datos['parte_causante'] : null,
			'causa_falla'          => isset($datos['causa_falla']) ? $datos['causa_falla'] : null,
			'equipo_diagnostico'   => isset($datos['equipo_diagnostico']) ? $datos['equipo_diagnostico'] : null,
			'reparacion_efectuada' => isset($datos['reparacion_efectuada']) ? $datos['reparacion_efectuada'] : null,
			'clave_defect'         => isset($datos['clave_defect']) ? $datos['clave_defect'] : null,
			'retorno_partes'       => isset($datos['retorno_partes']) ? $datos['retorno_partes'] : null,
			'mecanico_clave'       => isset($datos['mecanico_clave']) ? $datos['mecanico_clave'] : null,
			'costo_tiempo'         => isset($datos['costo_tiempo']) ? $datos['costo_tiempo'] : 0,
			'jefe_de_taller'       => isset($datos['jefe_de_taller']) ? $datos['jefe_de_taller'] : null,
			'firma_jefe_taller'    => isset($datos['firma_jefe_taller']) ? $datos['firma_jefe_taller'] : null,
			'terminado'            => 0
		];
		//echo "<pre>"; print_r($diagnostico); echo "</pre>";
		$this->db->trans_start();
		$this->db->insert('diagnostico_tecnico', $diagnostico);
		$id = $this->db->insert_id();
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$response['estatus'] = false;
			$response['mensaje'] = 'No fue posible guardar el diagnóstico.';
			return;
		}else
		{
			$this->db->trans_commit();
			$response['estatus'] = true;
			$response['mensaje'] = 'Diagnóstico guardado.';
		}
		$this->db->trans_start();
		foreach ($datos['detalles'] as $key => $detalle) {
			$insert = [
				'num_reparacion' => isset($detalle['num_reparacion']) ? $detalle['num_reparacion'] : null,
				'tren_motriz'    => isset($detalle['tren_motriz']) ? $detalle['tren_motriz'] : null,
				'codigos'        => isset($detalle['codigos']) ? $detalle['codigos'] : null,
				'luz_de_falla'   => isset($detalle['luz_de_falla']) ? $detalle['luz_de_falla'] : null,
				#'id_orden'       => $idOrden,
				'id_diagnostico' => $id
			];
			$this->db->insert('detalles_diagnostico_tecnico', $insert);
		}
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$response['estatus'] = false;
			$response['mensaje'] = 'No fue posible guardar las fallas del diagnóstico.';
		}else
		{
			$this->db->trans_commit();
			$response['estatus']        = true;
			$response['id_diagnostico'] = $id;
			$response['mensaje']        = 'Diagnóstico guardado.';
		}
		return $response;
	}
	public function obtener_diagnosticos($idOrden)
	{
		$response['data'] = $this->db->select('*')->from('diagnostico_tecnico')->where('id_orden', $idOrden)->get()->result_array();
		foreach ($response['data'] as $key => $diagnostico) {
			$response['data'][$key]['detalles'] = $this->db->select('*')->from('detalles_diagnostico_tecnico')->where(['id_diagnostico' => $diagnostico['id_diagnostico']])->get()->result_array();
		}
		if ( sizeof($response['data']) > 0) {
			$response['estatus'] = true;
			$response['mensaje'] = "Ok.";
		}else {
			$response['estatus'] = false;
			$response['data']    = [];
			$response['mensaje'] = "La orden no tiene diagnosticos.";
		}
		return $response;
	}
	public function obtener_detalles_diagnostico($idOrden, $idRevision = null)
	{
		if ($idRevision == null) {
			$response['data'] = $this->db->select('*')->from('diagnostico_tecnico')->where(['id_orden' => $idOrden, 'terminado' => 0])->get()->row_array();
		}else {
			$response['data'] = $this->db->select('*')->from('diagnostico_tecnico')->where(['id_orden' => $idOrden, 'id_diagnostico' => $idRevision, 'terminado' => 0])->get()->row_array();
		}
		if (sizeof($response['data']) > 0) {
			$response['data']['detalles'] = $this->db->select('*')->from('detalles_diagnostico_tecnico')->where(['id_diagnostico' => $response['data']['id_diagnostico']])->get()->result_array();
			$response['estatus']          = true;
			$response['mensaje']          = 'Ok.';
		} else {
			$response['estatus'] = false;
			$response['data']    = [];
			$response['mensaje'] = 'La orden no cuenta con una línea activa para realizar el llenado de información.';
		}
		return $response;
	}
	public function editar_diagnostico($idOrden, $datos)
	{
		
		if(sizeof(array_column($datos['detalles'], 'id_revision')) > 0){
			$this->db->trans_start();
			$this->db->where('id_diagnostico', $datos['id_diagnostico']);
			$this->db->where("id NOT IN(".implode(',',array_column($datos['detalles'], 'id_revision')).")" );
			$this->db->delete('detalles_diagnostico_tecnico');
			$this->db->trans_complete();
		}

		$logged_in = $this->session->userdata("logged_in");
		$existe = $this->db->select('id_diagnostico')->from('diagnostico_tecnico')->where(['id_orden' => $idOrden, 'id_diagnostico' => $datos['id_diagnostico']])->get()->row_array();
		if (!isset($existe['id_diagnostico'])) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Diagnóstico inexistente.';
			return $response;
		}
		#TODO
		if (true) {
			$diagnostico = [
				'id_orden' => $idOrden,
				'parte_causante'       => isset($datos['parte_causante']) ? $datos['parte_causante'] : null,
				'causa_falla'          => isset($datos['causa_falla']) ? $datos['causa_falla'] : null,
				'equipo_diagnostico'   => isset($datos['equipo_diagnostico']) ? $datos['equipo_diagnostico'] : null,
				'reparacion_efectuada' => isset($datos['reparacion_efectuada']) ? $datos['reparacion_efectuada'] : null,
				'clave_defect'         => isset($datos['clave_defect']) ? $datos['clave_defect'] : null,
				'retorno_partes'       => isset($datos['retorno_partes']) ?( $datos['retorno_partes'] != '' ? $datos['retorno_partes'] : null ): null,
				'mecanico_clave'       => isset($datos['mecanico_clave']) ? $datos['mecanico_clave'] : null,
				'costo_tiempo'         => isset($datos['costo_tiempo']) ? $datos['costo_tiempo'] : 0,
				
			];
			if($logged_in['perfil'] == 4 && isset($datos['firma_jefe_taller']) && !empty($datos['firma_jefe_taller'])){
				$jefe = $this->db->select('CONCAT( nombre, \' \', apellidos) AS nombre')->from('usuarios')->where('id', $logged_in['id'])->get()->row_array();
				$diagnostico['jefe_de_taller'] = $jefe['nombre'];
				$diagnostico['firma_jefe_taller'] = isset($datos['firma_jefe_taller']) ? $datos['firma_jefe_taller'] : null;
				$diagnostico['terminado'] = isset($datos['terminado']) ? $datos['terminado'] : 1;

			}
			$this->db->trans_start();
			$this->db->where('id_diagnostico', $datos['id_diagnostico']);
			$this->db->update('diagnostico_tecnico', $diagnostico);
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$response['estatus'] = false;
				$response['mensaje'] = 'No fue posible actualizar el diagnóstico.';
				return $response;
			}else
			{
				$this->db->trans_commit();
				$response['estatus'] = true;
				$response['mensaje'] = 'Diagnóstico actualizado.';
			}
			$this->db->trans_start();
			foreach ($datos['detalles'] as $key => $detalle) {
				$data = [
					'tren_motriz'    => $detalle['tren_motriz'],
					'codigos'        => $detalle['codigos'],
					'luz_de_falla'   => $detalle['luz_de_falla'],
					'num_reparacion' => $detalle['num_reparacion'],
					#'id_orden'      => $idOrden,
				];
				if (isset($detalle['id_revision'])) {
					$this->db->where(['id' =>	$detalle['id_revision'], 'id_diagnostico' => $datos['id_diagnostico']]);
					$this->db->update('detalles_diagnostico_tecnico', $data);
				}else {
					$data['id_diagnostico'] = $datos['id_diagnostico'];
					$data['num_reparacion'] = $detalle['num_reparacion'];
					$this->db->insert('detalles_diagnostico_tecnico', $data);
				}
			}
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$response['estatus'] = false;
				$response['mensaje'] = 'No fue posible actualizar las fallas del diagnóstico.';
			}else
			{
				$this->db->trans_commit();
				$response['estatus'] = true;
				$response['mensaje'] = 'Diagnóstico actualizado.';
			}
		}else{
			$response['estatus'] = false;
			$response['mensaje'] = 'No fue posible actualizar el nombre de perfil.';
		}
		return $response;
	}
	public function detalles_formato_diagnostico($data = 0)
	{
		$ret['usuario'] = $this->db->select("presupuestos.*,orden_servicio.*, orden_servicio.id as id_orden, usuarios.email as correo_asesor")->from("presupuestos")
						->join("orden_servicio", "orden_Servicio.id = presupuestos.id_orden")
						->join("usuarios", "usuarios.cve_intelisis = orden_servicio.clave_asesor")
						->where("presupuestos.id_presupuesto", $data['id'])
						->get()->row_array();
		$ret['userTecnico'] = $this->db->select("diagnostico_tecnico.tecnico")->from("diagnostico_tecnico")
						->where("diagnostico_tecnico.id_diagnostico", $data['id'])
						->get()->row_array();
		$ret['userJefe'] = $this->db->select("diagnostico_tecnico.jefe_de_taller")->from("diagnostico_tecnico")
						->where("diagnostico_tecnico.id_diagnostico", $data['id'])
						->get()->row_array();
		$ret['codigo'] = $this->db->select("detalles_diagnostico_tecnico.num_reparacion, detalles_diagnostico_tecnico.luz_de_falla, detalles_diagnostico_tecnico.tren_motriz, detalles_diagnostico_tecnico.codigos, detalles_diagnostico_tecnico.fecha_creacion")->from("detalles_diagnostico_tecnico")
						->where("detalles_diagnostico_tecnico.id_diagnostico", $data['id'])
						->get()->row_array();
		$ret['anotaciones'] = $this->db->select("diagnostico_tecnico.queja_cliente, diagnostico_tecnico.sintomas_falla, diagnostico_tecnico.equipo_diagnostico, diagnostico_tecnico.comentarios_tecnicos, diagnostico_tecnico.publica, diagnostico_tecnico.garantia, diagnostico_tecnico.adicional, diagnostico_tecnico.firma_tecnico, diagnostico_tecnico.firma_jefe_taller")->from("diagnostico_tecnico")
						->where("diagnostico_tecnico.id_diagnostico", $data['id'])
						->get()->row_array();
		
		$ret['detalle'] = $this->db->select("*")->from("presupuesto_detalle")->where("id_presupuesto", $data['id'])->get()->result_array();
		/*echo "<pre>";
		print_r($ret['detalle']);
		echo "</pre>";*/
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
	public function autorizar_diagnostico($id_orden)
	{
		$firma = $this->db->select('firma_electronica')->from('usuarios')->where("id", $this->session->userdata["logged_in"]["id"])->get()->row_array();
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		if(isset($firma['firma_electronica']) && !empty($firma['firma_electronica'])){
			
				$this->db->trans_start();
				$this->db->where('id_diagnostico', $id_orden);
				if ($perfil == 4){
					$this->db->update('diagnostico_tecnico', ['firma_jefe_taller' => $firma['firma_electronica']]);
				}
				if ($perfil == 5){
					$this->db->update('diagnostico_tecnico', ['firma_tecnico' => $firma['firma_electronica']]);
				}
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No se pudo autorizar firma.';
				}else {
					$this->db->trans_commit();
					$response['estatus'] = true;
				}
		}else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No tienes firma registrada.';
		}
		return $response;
	}
	public function obtenerFirmaDiagnostico($id_orden)
	{
		return $this->db->select("*")->from('diagnostico_tecnico')->where('id_diagnostico', $id_orden)->get()->result_array();
	}

	/*public function cancela_diagnostico($id_orden)
	{
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		$existe_firma = $this->db->select("*")
								 ->from("diagnostico_tecnico")
								 ->where("id_diagnostico", $id_orden)
								 ->count_all_results();
			
				$this->db->trans_start();
				$this->db->where('id_diagnostico', $id_orden);
				if($perfil == 4){$this->db->update('diagnostico_tecnico', ['firma_jefe_taller' => null]);}
				if($perfil == 5){$this->db->update('diagnostico_tecnico', ['firma_tecnico' => null]);}
				$this->db->trans_complete();
				if ($this->db->trans_status() === TRUE) {
					$this->db->trans_commit();
					$response['estatus'] = true;
				}else {
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No se pudo cancelar la autorización.';
				}
		return $response;
	}*/
	public function obtener_requisiciones($idOrden)
	{
		$response['requisiciones'] = $this->db->select('*')->from('requisiciones')->where('id_orden', $idOrden)->get()->result_array();
		foreach ($response['requisiciones'] as $key => $requisicion) {
			$response['requisiciones'][$key]['detalles'] = $this->db->select('*')->from('detalles_requisiciones')->where(['id_requisicion' => $requisicion['id_requisicion']])->get()->result_array();
		}
		if ( sizeof($response['requisiciones']) > 0) {
			$response['estatus'] = true;
			$response['mensaje'] = "Ok.";
		}else {
			$response['estatus'] = false;
			$response['mensaje'] = "La orden no tiene requisiciones.";
		}
		return $response;
	}
	public function obtener_detalles_requisicion($id)
	{
		$response['requisicion'] = $this->db->select('*')->from('requisiciones')->where(['id_requisicion' => $id])->get()->row_array();
		if (sizeof($response['requisicion']) > 0) {
			$response['estatus'] = true;
			$response['mensaje'] = 'Ok.';
			$response['requisicion']['detalles'] = $this->db->select('*')->from('detalles_requisiciones')->where('id_requisicion', $id)->get()->result_array();
			$orden = $this->db->select('*')->from('orden_servicio')->where('id', $response['requisicion']['id_orden'])->get()->row_array();
			$tec = $this->db->select('*')->from('usuarios')->where('id', $response['requisicion']['id_usuario'])->get()->row_array();
			$response['vin'] = $orden['vin'];
			$response['id_orden'] = $orden['id'];
			$response['firmaTec'] = $tec['firma_electronica'];
		}else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No existe la requisición.';
		}
		return $response;
	}
	public function obtener_detalles_cotizacion($id)
	{
		$response['cotizacion'] = $this->db->select('*')->from('verificacion_refacciones')->where('id_presupuesto', $id)->get()->row_array();
		if (sizeof($response['cotizacion']) > 0) {
			$response['estatus'] = true;
			$response['mensaje'] = 'Ok.';
			$response['cotizacion']['detalles'] = $this->db->select('*')->from('detalles_verificacion_refacciones')->where('id_presupuesto', $id)->get()->result_array();
			$existencias = $this->db->select('*')->from('detalles_verificacion_refacciones')->where(['id_presupuesto' => $id, 'en_existencia !=' => 1])->count_all_results();
			 $response['existencias'] = $existencias > 0 ? false : true;
		}else {
			$response['estatus'] = false;
			$response['existencias'] = false;
			$response['mensaje'] = 'No existe la cotización de piezas.';
		}
		return $response;
	}
	public function convertir_cotizacion($id)
	{
		$existe = $this->obtener_detalles_cotizacion($id);
		if ($existe['estatus']) {
			$pregarantia = $this->db->select('id')->from('orden_servicio')->where('movimiento', $existe['cotizacion']['id_orden'])->get()->row_array();
			if ($existe['existencias'] === false) {
				$response['estatus'] = false;
				$response['mensaje'] = 'No puedes convertir la cotización ya que tiene artículos sin existencia.';
			}elseif (isset($pregarantia['id'])) {
				$datos = [
					'total_presupuesto' => $existe['cotizacion']['total_presupuesto'],
					'detalles'          => $existe['cotizacion']['detalles']
				];
				$response = $this->guardar_requisiciones($pregarantia['id'],$datos);
			} else {
				$response['estatus'] = false;
				$response['mensaje'] = 'La orden pública no tiene una pregarantía abierta para cargar la requisicion';
			}
		}else {
			$response['estatus'] = false;
			$response['mensaje'] = $existe['mensaje'];
		}
		return $response;
	}
	public function editar_requisicion($datos){
		//$datos["detalles"] = parse_str($datos["detalles"],$arr);
		$existen = $this->db->select("*")->from("detalles_requisiciones")->where("id_requisicion", $datos["id_requisicion"])->get()->result_array();
		$new = $datos["detalles"];
		$this->db->trans_start();
		foreach ($existen as $value) {
			$this->db->where('id_requisicion', $value["id_requisicion"]);
			$this->db->delete('detalles_requisiciones'); 
		}
		foreach ($new as $key => $value) {
			$value["id_requisicion"] = $datos["id_requisicion"];
			$this->db->insert("detalles_requisiciones", $value);
		}
		$this->db->where("id_requisicion", $datos["id_requisicion"]);
		$this->db->update("requisiciones", array("total_presupuesto"=>$datos["precioTotal3"]));
		$this->db->trans_complete();
		if($this->db->trans_status() == true)
		{
			$refacciones["estatus"] = true;
			$refacciones["mensaje"] ="requisición actualizada";
			$refacciones["id"] =$datos['id_requisicion'];
		}else
		{
			$refacciones["estatus"] = false;
			$refacciones["mensaje"] = 'Error al editar';
		}
		return $refacciones;
	}
	public function obtener_datos_f1863($idOrden)
	{
		$ordenGarantia = $this->db->select('*')->from('orden_servicio')->where(['id' => $idOrden])->get()->row_array();
		if (sizeof($ordenGarantia) > 0) {

			$response['garantia'] = $ordenGarantia;
			$publica = $this->db->select('*')->from('orden_servicio')->where(['id' => $ordenGarantia['movimiento']])->get()->row_array();
			$response['publica'] = $ordenGarantia;
			if ($response['garantia'] && $response['garantia']['oasis']) {
				$response['garantia']['oasis'] = $response['garantia']['oasis'] == 1 ? 'Si' : 'No';
			}
			if ($response['publica'] && $response['publica']['oasis']) {
				$response['publica']['oasis'] = $response['publica']['oasis'] == 1 ? 'Si' : 'No';
			}

			$response['lineas'] = $this->db->select('*')->from('lineas_reparacion')->where(['id_orden' => $idOrden])->get()->result_array();

			$intelisis = $this->load->database("other", TRUE);

			$response["sucursal"] = $this->db->select("ds.*, s.nombre, s.sucursal_marca, a.razon_social, a.dom_calle_fiscal, a.dom_col_fiscal, a.dom_numExt_fiscal, a.dom_numInt_fiscal, a.dom_ciudad_fiscal, a.dom_estado_fiscal, a.dom_cp_fiscal")
									  ->from("datos_sucursal ds")
									  ->join("sucursal s", "ds.id_sucursal = s.id")
									  ->join("agencia a", "s.id_agencia = a.id")
									  ->where("ds.id_sucursal", $this->session->userdata["logged_in"]["id_sucursal"])
									  ->get()->row_array();

			// echo $this->db->last_query();die;
			$response["reverso"] = $this->db->query("
				SELECT dom_calle, dom_numExt, dom_colonia, dom_ciudad, dom_estado, dom_cp, rfc
				FROM datos_sucursal WHERE id_sucursal = ?", array($this->session->userdata["logged_in"]["id_sucursal"])) 
			->row_array();
		
			// echo $this->db->last_query();die;						 
			$response["cliente"] = $intelisis->select("MovID,Pasajeros,ar.Descripcion1")
													->from("Venta vta")
													->join("VIN vn", "vta.servicioSerie = vn.vin")
													->join("art ar", "ar.Articulo = vta.ServicioArticulo")
													->where("ID", $ordenGarantia["id_orden_intelisis"])
													->get()->row_array(); 

			$response["inspeccion"] = $this->db->select("*")
											->from("orden_servicio_inspeccion")
											->where("id_servicio", $ordenGarantia['movimiento'])
											->get()->row_array();

			$response['garantia']['MovID'] = $intelisis->select('MovID')->from('Venta')->where(['ID' => $ordenGarantia['id_orden_intelisis']])->get()->row_array()['MovID'];
			$response['publica']['MovID'] = $intelisis->select('MovID')->from('Venta')->where(['ID' => $publica['id_orden_intelisis']])->get()->row_array()['MovID'];
			$response['crc'] = $this->db->select('definicion_falla AS comentario_cliente, id AS codigo_queja')->from('causa_raiz_componente')->where('id_orden_servicio',$publica['id'])->get()->result_array();

			//modificacion para obtener detalle de orden de servicio desde ventaD intelisis
			/*$response["desglose"] = $intelisis->select("(Precio*Cantidad)+((SUM((Precio*Cantidad)) * VentaD.Impuesto1 ) / 100) as iva_total, VentaD.Articulo as articulo, VentaD.DescripcionExtra as descripcion, Cantidad as cantidad, Precio as precio_unitario, (Precio*Cantidad) as importe, (SELECT TOP 1 FordStar FROM Agente WHERE Agente.Agente = \"VentaD\".\"Agente\") AS FordStar, MAX(Art.Tipo) AS 'tipo', MAX(RenglonID) AS RenglonID, MAX(Renglon) AS Renglon, MAX(ID) AS id")
				->from("VentaD")
				->join('Art', 'VentaD.Articulo = Art.Articulo')
				->where("ID", $ordenGarantia["id_orden_intelisis"])
				->where('ventad.cantidad > isnull(ventad.cantidadcancelada,0)')
				->group_by('precio, cantidad, VentaD.impuesto1, VentaD.articulo,VentaD.DescripcionExtra, Agente')
				->get()->result_array();*/
				$response['desglose'] = $intelisis->select('*')->from('vwCA_GarantiasPartsOperaciones')->where("IdVenta", $ordenGarantia["id_orden_intelisis"])->get()->result_array();

			if (is_array($response['desglose'])) {
				foreach ($response['desglose'] as $key => $valor) {
					$costo_tiempo = null;
					if ($valor['tipo'] === 'Servicio') {
						$response['desglose'][$key]['cantidad'] = null;
						$response['desglose'][$key]['precio_unitario'] = null;
						$response['desglose'][$key]['importe'] = null;
						$response['desglose'][$key]['prefijo'] = null;
						$response['desglose'][$key]['sufijo'] = null;
						$costo_tiempo = 0;
						$linea = $this->db->select('*')->from('lineas_reparacion')->where(['VentaID' => $response['desglose'][$key]['IdVenta'], 'Renglon' => $response['desglose'][$key]['Renglon'], 'RenglonId' => $response['desglose'][$key]['RenglonID']])->get()->row_array();
						$response['desglose'][$key]['num_rem'] = isset($linea['num_reparacion']) ? $linea['num_reparacion'] : null;
						$response['desglose'][$key]['importe_mano'] = isset($linea['mano_obra_total']) ? $linea['mano_obra_total'] : 0;
						$tiempos = $intelisis->select('*')->from('SeguimientoOperaciones')->where(['IdVenta' => $response['desglose'][$key]['IdVenta'], 'Renglon' => $response['desglose'][$key]['Renglon'], 'RenglonId' => $response['desglose'][$key]['RenglonID'], 'Estado' => 'En Curso'])->get()->result_array();
						foreach (is_array($tiempos) ? $tiempos : [] as $key2 => $inicio) {
							$aux_fin = new DateTime($inicio['FechafIN'] ? $inicio['FechafIN'] : $inicio['FechaInicio']);
							$aux_inicio = new DateTime($inicio['FechaInicio']);
							$aux = (($aux_fin->format('U.u') - $aux_inicio->format('U.u')) * 1000) / (1000 * 3600);
							$costo_tiempo += is_nan($aux) ? 0 : $aux;
						}
						$costo_tiempo = number_format($costo_tiempo, 2);
						$mano_obra_total = $response['desglose'][$key]['importe_mano'] * $costo_tiempo;
						$response['desglose'][$key]['importe_mano'] = number_format($mano_obra_total, 2);
					}
					$response['desglose'][$key]['tiempo'] = $costo_tiempo;
				}
			}

			$response["asesor"] = $this->db->select("firma_electronica, nombre, apellidos")
										->from("usuarios")
										->where("cve_intelisis", $ordenGarantia['clave_asesor'])
										->get()->row_array();
			$asesor = $intelisis->select('FordStar')->from('Agente')->where(['Agente' => $ordenGarantia['clave_asesor']])->get()->row_array();

			$response['asesor']['FordStar'] = isset($asesor['FordStar']) ? $asesor['FordStar'] : '';

			$response["firma_cliente"] = $this->db->select("firma, firma_formatoInventario")
										   ->from("firma_electronica")
										   ->where("id_orden_servicio", $ordenGarantia['movimiento'])
										   ->get()->row_array();
			//$response['venta'] = $intelisis->select('*')->from('Venta')->where(['id' => $ordenGarantia['id_orden_intelisis']])->get()->row_array();
			//$response['ventaD'] = $intelisis->select('*')->from('Venta')->where(['id' => $ordenGarantia['id_orden_intelisis']])->get()->row_array();
			//$response['data'] = $datos;
			$response['estatus'] = true;
			$response['mensaje'] = 'Ok.';
		} else {
			$response['estatus'] = false;
			$response['data'] = [];
			$response['mensaje'] = 'No existe una orden válida.';
		}
		return $response;
	}
	public function guardar_linea($idOrden, $datos)
	{
		$existen = $this->db->select('*')->from('diagnostico_tecnico')->where('id_orden', $idOrden)->count_all_results();
		//print_r($this->db->last_query());
		if ($existen > 0) {
			$this->db->trans_start();
			$data = [
				'num_reparacion'             => isset($datos['num_reparacion']) ? $datos['num_reparacion'] : null,
				'tipo_garantia'              => isset($datos['tipo_garantia']) ? $datos['tipo_garantia'] : null,
				'subtipo_garantia'           => isset($datos['subtipo_garantia']) ? $datos['subtipo_garantia'] : null,
				'dannio'                     => isset($datos['danio_ralacion']) ? $datos['danio_ralacion'] : null,
				'autoriz_1'                  => isset($datos['autoriz_1']) ? $datos['autoriz_1'] : null,
				'autoriz_2'                  => isset($datos['autoriz_2']) ? $datos['autoriz_2'] : null,
				'partes_totales'             => isset($datos['partes_totales']) ? $datos['partes_totales'] : null,
				'mano_obra_total'            => isset($datos['mano_obra_total']) ? $datos['mano_obra_total'] : null,
				'misc_total'                 => isset($datos['misc_total']) ? $datos['misc_total'] : null,
				'iva'                        => isset($datos['iva']) ? $datos['iva'] : null,
				'participacion_cliente'      => isset($datos['participacion_cliente']) ? $datos['participacion_cliente'] : null,
				'participacion_distribuidor' => isset($datos['participacion_distribuidor']) ? $datos['participacion_distribuidor'] : null,
				'reparacion_total'           => isset($datos['reparacion_total']) ? $datos['reparacion_total'] : null,
				'firma_admin'                => isset($datos['firma_admin']) ? $datos['firma_admin'] : null,
				'id_orden'                   => $idOrden,
				'VentaID'                    => isset($datos['ventaId']) ? $datos['ventaId'] : null,
				'Renglon'                    => isset($datos['renglon']) ? $datos['renglon'] : null,
				'RenglonID'                  => isset($datos['renglonId']) ? $datos['renglonId'] : null,
				'RenglonSub'                 => isset($datos['renglonSub']) ? $datos['renglonSub'] : null,
			]; 
			$this->db->insert('lineas_reparacion', $data);
			$id = $this->db->insert_id();
			$this->db->trans_complete();
			if ($this->db->trans_status() === TRUE) {
				$this->db->trans_commit();
				$response['id']      = $id;
				$response['mensaje'] = 'Línea guardada correctamente.';
				$response['estatus'] = true;
			}else {
				$this->db->trans_rollback();
				$response['estatus'] = false;
				$response['mensaje'] = 'No se pudo guardar la línea.';
			}
		} else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No existen diagnósticos cargados para la orden.';
		}
		return $response;
	}
	public function editar_linea($idOrden, $datos)
	{
		$this->db->trans_start();
		$data = [
			'num_reparacion'             => isset($datos['num_reparacion']) ? $datos['num_reparacion'] : null,
			'tipo_garantia'              => isset($datos['tipo_garantia']) ? $datos['tipo_garantia'] : null,
			'subtipo_garantia'           => isset($datos['subtipo_garantia']) ? $datos['subtipo_garantia'] : null,
			'dannio'            		 => isset($datos['danio_ralacion']) ? $datos['danio_ralacion'] : null,
			'autoriz_1'                  => isset($datos['autoriz_1']) ? $datos['autoriz_1'] : null,
			'autoriz_2'                  => isset($datos['autoriz_2']) ? $datos['autoriz_2'] : null,
			'partes_totales'             => isset($datos['partes_totales']) ? $datos['partes_totales'] : null,
			'mano_obra_total'            => isset($datos['mano_obra_total']) ? $datos['mano_obra_total'] : null,
			'misc_total'                 => isset($datos['misc_total']) ? $datos['misc_total'] : null,
			'iva'                        => isset($datos['iva']) ? $datos['iva'] : null,
			'participacion_cliente'      => isset($datos['participacion_cliente']) ? $datos['participacion_cliente'] : null,
			'participacion_distribuidor' => isset($datos['participacion_distribuidor']) ? $datos['participacion_distribuidor'] : null,
			'reparacion_total'           => isset($datos['reparacion_total']) ? $datos['reparacion_total'] : null,
			'firma_admin'                => isset($datos['firma_admin']) ? $datos['firma_admin'] : null,
			'id_orden'                   => $idOrden,
			'VentaID'                    => isset($datos['ventaId']) ? $datos['ventaId'] : null,
			'Renglon'                    => isset($datos['renglon']) ? $datos['renglon'] : null,
			'RenglonID'                  => isset($datos['renglonId']) ? $datos['renglonId'] : null,
			'RenglonSub'                 => isset($datos['renglonSub']) ? $datos['renglonSub'] : null,
		];
		/*echo '<prev>'; print_r($data);
		echo '</prev>';*/
		$this->db->where(['id' => $datos['id'], 'id_orden' => $idOrden]);
		$this->db->update('lineas_reparacion', $data);
		$this->db->trans_complete();
		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			$response['mensaje'] = 'Línea editadas correctamente.';
			$response['estatus'] = true;
		}else {
			$this->db->trans_rollback();
			$response['estatus'] = false;
			$response['mensaje'] = 'No se pudo cancelar la autorización.';
		}
		return $response;
	}
	public function obtener_lineas($idOrden)
	{
		$this->db2 = $this->load->database('other',true);
		$orden = $this->db->select('*')->from('orden_servicio')->where(['id' => $idOrden])->get()->row_array();
		$response['lineas_reparacion'] = $this->db->select('*')->from('lineas_reparacion')->where(['id_orden' => $idOrden])->get()->result_array();
		if (sizeof($orden) > 0 /*&& sizeof($response['lineas_reparacion']) > 0*/) {
			$response['manos'] = $this->db2->select('*')->from('VentaD')->where(['ID' => $orden['id_orden_intelisis']])->get()->result_array();
			if (sizeof($response['manos']) > 0) {
				$response['estatus'] = true;
				$response['mensaje'] = "Ok.";
			} else {
				$response['estatus'] = false;
				$response['mensaje'] = 'No hay líneas cargadas para la garantía.';
			}
		} else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No hay líneas cargadas para la garantíassss.';
		}
		return $response;
	}

	public function firmar_lineas($id_orden)
	{
		$firma = $this->db->select('firma_electronica')->from('usuarios')->where("id", $this->session->userdata["logged_in"]["id"])->get()->row_array();
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		if(isset($firma['firma_electronica']) && !empty($firma['firma_electronica'])){
			$response['estatus'] = true;
			$response['firma_electronica'] = $firma['firma_electronica'];
		
		}else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No tienes firma registrada.';
		}
		return $response;
	}
	
	public function obtenerFirmaAdmon($id_orden)
	{
		return $this->db->select("*")->from('firma_electronica')->where('id_orden_servicio', $id_orden)->get()->result_array();
	}

	public function cancelar_firma_Admon($id_orden)
	{
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		$existe_firma = $this->db->select("*")
								 ->from("lineas_reparacion")
								 ->where("id_orden_servicio", $id_orden)
								 ->count_all_results();
			if($existe_firma == 0){
				$response['estatus'] = false;
				$response['mensaje']=['No tienes firmas para cancelar.'];
			}else {
				$this->db->trans_start();
				$this->db->where('id_orden_servicio', $id_orden);
				if($perfil == 7){$this->db->update('firma_electronica', ['firma_pregarantiaAdmon' => null]);}
				$this->db->trans_complete();
				if ($this->db->trans_status() === TRUE) {
					$this->db->trans_commit();
					$response['estatus'] = true;
				}else {
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No se pudo cancelar la autorización.';
				}
			}
		return $response;
	}
	public function autorizar_requisicion($idOrden, $idRequisicion, $datos)
	{
		$firma = $this->db->select('firma_electronica')->from('usuarios')->where("id", $this->session->userdata["logged_in"]["id"])->get()->row_array();
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		if(isset($firma['firma_electronica']) && !empty($firma['firma_electronica'])){

		$existe = $this->db->select('*')->from('requisiciones')->where(['id_requisicion' => $idRequisicion, 'id_orden' => $idOrden])->get()->row_array();
		if (sizeof($existe) > 0) {
			$data = [
				'autorizado' => $datos['check'],
				'firma_de_admon' => $firma['firma_electronica']
			];
			$this->db->trans_start();
			$this->db->where(['id_requisicion' => $idRequisicion, 'id_orden' => $idOrden]);
			if($perfil == 7){
				$this->db->update('requisiciones', $data);	
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No fue posible actualizar la autorización de la requisición.';
				}else {
					$this->db->trans_commit();
					$response['estatus'] = true;
					$response['mensaje'] = 'Autorización de la requisición actualizada.';
				}
			}else {
				$response['estatus'] = false;
					$response['mensaje'] = 'Tu perfil no es el indicado.';
			}			
			
		} else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No se encontró ninguna requisición.';
		}
	}else {
		$response['estatus'] = false;
		$response['mensaje'] = 'No tienes firma registrada.';
	}
		return $response;
	}
	public function entrega_requisicion($idOrden, $idRequisicion, $datos)
	{
		$existe = $this->db->select('*')->from('requisiciones')->where(['id_requisicion' => $idRequisicion, 'id_orden' => $idOrden])->get()->row_array();
		if (sizeof($existe) > 0) {
			$data = [
				'entregado' => $datos['check']
			];
			if ($existe['autorizado']) {
				$this->db->trans_start();
				$this->db->where(['id_requisicion' => $idRequisicion, 'id_orden' => $idOrden]);
				$this->db->update('requisiciones', $data);
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No fue posible actualizar el estatus de la requisición.';
				}else {
					$this->db->trans_commit();
					$response['estatus'] = true;
					$response['mensaje'] = 'Estatus de la requisición actualizado.';
				}
			} else {
				$response['estatus'] = false;
				$response['mensaje'] = 'No es posible entregar una requisición que no ha sido autorizada.';
			}
		} else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No se encontró ninguna requisición.';
		}
		return $response;
	}
	public function save_docs_anexo_mov($idOrden,$nomArchivo,$rutaArchivo){
		$this->db2 = $this->load->database("other", true);
		$xp  = "xpCA_GenerarAnexoMovRa";
		$modulo = "VTAS";
		$tipo   = "PDF";
		$orden_servicio = $this->db->select('id_orden_intelisis, vin')->from('orden_servicio')->where('id', $idOrden)->get()->row();
		$idIntelisis = $this->db2->select('id')->from('venta')->where('id',$orden_servicio->id_orden_intelisis)->where("estatus <> 'CANCELADO' ")->get()->row();

		if(file_exists(RUTA_FORMATS.$orden_servicio->vin."/".$idOrden."/".$nomArchivo)) {
			//$sqlXp = "DECLARE @OkRef varchar(250) EXEC ".$nomXp." ?,?,?,?,?,@OkRef OUTPUT SELECT @OkRef",array($modulo,$tipo,$Sucursal,$nomArchivo,$rutaArchivo);
			$ok = $this->db2->query("DECLARE @OkRef varchar(250) EXEC ".$xp." ?,?,?,?,?,@OkRef OUTPUT SELECT @OkRef", array($modulo, $idIntelisis->id, $tipo, $nomArchivo, $rutaArchivo));
			/*echo "<pre>";
			print_r ($this->db2->last_query());
			echo "</pre>";*/
			if ($ok) {
				$creado["estatus"] = true;
				$creado["mensaje"] = 'Archivo anexado correctamente.';
				$creado["rutaFisica"] = realpath(RUTA_FORMATS.$orden_servicio->vin."/".$idOrden."/".$nomArchivo);
			} else {
				$creado["estatus"] = false;
				$creado["mensaje"] = 'No fue posible guardar el regitro del archivo.';
				$creado["rutaFisica"] = "";
			}
		}else
		{
			$creado["estatus"] = false;
			$creado["mensaje"] = 'El archivo especificado no existe.';
			$creado["rutaFisica"] = "";
		}
		return $creado;
	}
	public function firmar_anverso($idOrden)
	{
		$firma = $this->db->select('firma_electronica')->from('usuarios')->where("id", $this->session->userdata["logged_in"]["id"])->get()->row_array();
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		if(isset($firma['firma_electronica']) && !empty($firma['firma_electronica'])){
			$response['estatus'] = true;
			$response['firma_electronica'] = $firma['firma_electronica'];
		
		}else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No tienes firma registrada.';
		}
		return $response;
	}
	function autocomplete_mo_lineas($q){

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
					DISTINCT
					art.Articulo,
					art.Descripcion1,
					art.Unidad,
					ISNULL(li.Precio, 0) AS Precio,
					ISNULL(li.Lista, 'Precio Publico') AS Lista
				FROM
					Art art
				LEFT JOIN ListaPreciosD li ON Art.Articulo = li.Articulo
				--habilitar unicamente para las ford
				Inner JOIN OperacionesEreactValidas oert ON oert.Articulo = art.Articulo
				WHERE
					art.Tipo = 'Servicio'
					AND art.categoria <> 'TOT'
					AND art.Estatus = 'ALTA'
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
		
		  //echo $this->db2->last_query();
		if($query->num_rows() > 0){
			$response['data'] = $query->result_array();
		}else{
			$response['data'] = [];
			$response['estatus'] = false;
			$response['mensaje'] = 'No se encontraron manos de obra.';
		}
		return $response;
	}

	public function guardar_mo_lineas($idOrden,$formulario, $elementos)
	{
		$existen_articulos = $this->db->select("*")
			->from("orden_servicio_desglose")
			->where("id_orden", $idOrden)
			->count_all_results();
		$this->db->trans_start();
		//si existian ya articulos en para la orden los elimina
		if($existen_articulos != 0)
		{
			$this->db->where("id_orden", $idOrden);
			$this->db->delete("orden_servicio_desglose");
		}
		$orden_servicio["subtotal_orden"] = $this->formatear_numero($formulario["subTotal"]);
		$orden_servicio["iva_orden"] = $this->formatear_numero($formulario["ivaTotal"]);
		$orden_servicio["total_orden"] = $this->formatear_numero($formulario["totales"]);
		$orden_servicio["fecha_actualizacion"] = date("d-m-Y H:i:s");
		$this->db->where('id', $idOrden);
		$this->db->update('orden_servicio', $orden_servicio);

		foreach ($elementos as $key => $value) 
		{
			$orden_servicio_desglose["id_orden"] = $idOrden;
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
			$response['estatus'] = true;
			$response['mensaje'] = 'Orden de servicio desglose agregado.';
		}else
		{
			$response['estatus'] = false;
			$response['mensaje'] = 'No fue posible agregar desglose de la orden de servicio.';
		}

		return $response;
	}

	function guardar_mo_lineas_intelisis($idOrden,$datar, $elementos){
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

		$sucursal = $this->db->select("empresa, sucursal_int, almacen_servicio")
							 ->from("sucursal")
							 ->where("id", $this->session->userdata["logged_in"]["id_sucursal"])
							 ->get()->row_array();

		// Datos Generales
		$Empresa               = $sucursal["empresa"];
		$usuario               = $this->session->userdata('logged_in')['usuario_intelisis'];//
		$Almacen               = $sucursal["almacen_servicio"];
		$Sucursal              = $sucursal["sucursal_int"];
		$timestamp             = date('d-m-Y G:i:s');
		// Datos Articulos y Mano de Obra
		$Importe               = $datar['Total'];
		$Impuestos             = $datar['iva'];

		$ordenServicio = $this->db->select('*')->from('orden_Servicio')->where(['id' => $idOrden])->get()->row_array();

		$idOrdenIntelisis = $ordenServicio['id_orden_intelisis'];
		$response['estatus'] = false;
		$response['mensaje'] = 'Orden no válida.';
		if (sizeof($ordenServicio) <= 0){
			$response['estatus'] = false;
			$response['mensaje'] = 'Orden no válida.';
		}else{
			$this->db2->trans_begin();

			// Datos Asesor
			$Agente                = $this->db2->select('*')->from('Venta')->where(['ID' => $idOrdenIntelisis])->get()->row_array();
			$Agente = isset($Agente['Agente']) ? $Agente['Agente'] : '';

			$manodeobra = [];
			$venta = [
				'Importe' => $Importe,
				'Impuestos' => $Impuestos
			];
			$this->db2->where('ID', $idOrdenIntelisis);
			$this->db2->update('Venta', $venta);
			//separamos elementos y vamos guardando por partes...
			for ($i = 0; $i < sizeof($elementos); $i++) {
				//mano de obra
				if ($elementos[$i]['tipo'] == 'mo') {
					$manodeobra[$i]['art'] = $elementos[$i]['art'];
					$manodeobra[$i]['cantidad'] = $elementos[$i]['cantidad'];
					$manodeobra[$i]['precio_u'] = $elementos[$i]['precio_u'];
					$manodeobra[$i]['Agente'] = isset($elementos[$i]['Agente']) ? $elementos[$i]['Agente'] : '';
				}
			}
			if(sizeof($manodeobra)> 0){
				$ok3 = $this->guardar_manoo($manodeobra,$idOrdenIntelisis, $Almacen,$Agente, $Sucursal );
				$this->db2->trans_complete();
				if ($this->db2->trans_status() === FALSE || $ok3 === FALSE){
					$this->db2->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No fue posible cargar las líneas de trabajo en Intelisis.';
				}else{
					$this->db2->trans_commit();
					$response['estatus'] = true;
					$response['mensaje'] = 'Líneas de trabajo agregadas correctamente.';
				}
			}else {
				$response['estatus'] = false;
				$response['mensaje'] = 'No fue posible cargar las líneas de trabajo en Intelisis.';
			}
		}
		return $response;
	}
	public function obtener_mecanicos()
	{
		$this->db2 = $this->load->database("other", true);
		$idSucursal          = $this->session->userdata["logged_in"]['id_sucursal'];
		$sucursal = $this->db->select('*')->from('sucursal')->where(['id' => $idSucursal])->get()->row_array();
		if (sizeof($sucursal) > 0) {
			$data = $this->db2->select('*')->from('Agente')->where(['Tipo' => 'Mecanico', 'Estatus' => 'ALTA', 'Categoria' => 'Servicio', 'SucursalEmpresa' => $sucursal['id_intelisis'], 'Jornada IS NOT NULL' => null])->get()->result_array();
			$total = sizeof($data);
			if ($total > 0) {
				$response['data'] = $data;
				$response['estatus'] = true;
				$response['mensaje'] = "Se encontraron {$total} resultado(s).";
			} else {
				$response['data'] = [];
				$response['estatus'] = false;
				$response['mensaje'] = "No se encontraron resultados.";
			}
		} else {
				$response['data'] = [];
				$response['estatus'] = false;
				$response['mensaje'] = "Sucursal no válida.";
		}
		return $response;
	}
	public function obtener_iva($idOrden){
		$this->db2 = $this->load->database("other", true);
		$iva = $this->db->select('*')->from('orden_Servicio')->where(['id' => $idOrden])->get()->row_array();
		$idOrdenIva = $iva['id_orden_intelisis'];
		if (sizeof($iva) <= 0){
			$response['estatus'] = false;
			$response['mensaje'] = 'Orden no válida.';
		}else{
			$ZonaImpuesto = $this->db2->select('*')->from('Venta')->where(['ID' => $idOrdenIva])->get()->row_array();
			$idOrdenZona = $ZonaImpuesto['ZonaImpuesto'];
		
			if (sizeof($ZonaImpuesto) <= 0){
				$response['estatus'] = false;
				$response['mensaje'] = 'Orden no válida.';
			}else{
				$porcentaje = $this->db2->select('*')->from('ZonaImp')->where(['Zona' => $idOrdenZona])->get()->row_array();
				$idOrdenZona = $porcentaje['Porcentaje'];
				$response['estatus'] = true;
				$response['mensaje'] = 'Porcentaje de zona encontrado.';
				$response['Porcentaje'] = $porcentaje;
				
			}
		}
		return $response;
	}
	function asignar_tecnico_linea($id, $datos) {
		$data = [
			'Agente' => $datos['asigna_tecnico']
		];
		/*$data_diagnostico = [
			'VentaID' => $id,
			'Renglon' => $datos['Renglon'],
			'RenglonID' => $datos['RenglonID'],
			'RenglonSub' => $datos['RenglonSub']
		];
		$diagnostico = $this->obtener_detalles_diagnostico($datos['id_orden']);
		$this->db->trans_begin();
		$this->db->where(['id_diagnostico' => $diagnostico['data']['id_diagnostico']]);
		$this->db->update('diagnostico_tecnico', $data_diagnostico);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE ){
			$this->db->trans_rollback();
			$response['estatus'] = false;
			$response['mensaje'] = 'No fue posible diagnóstico a la línea.';
		}else{
			$this->db->trans_commit();
			$response['estatus'] = true;
			$response['mensaje'] = 'Técnico asignado correctamente.';
		}*/
		$this->db2 = $this->load->database('other',true);
		$this->db2->trans_begin();
		$this->db2->where(['ID' => $id, 'Renglon' => $datos['Renglon'],'RenglonID' => $datos['RenglonID'], 'RenglonSub' => $datos['RenglonSub']]);
		$this->db2->update('VentaD', $data);
		$this->db2->trans_complete();
		if ($this->db2->trans_status() === FALSE ){
			$this->db2->trans_rollback();
			$response['estatus'] = false;
			$response['mensaje'] = 'No fue posible asignar el técnico a la línea.';
		}else{
			$this->db2->trans_commit();
			$response['estatus'] = true;
			$response['mensaje'] = 'Técnico asignado correctamente.';
		}
		if ($datos['id_diagnostico']) {
			$data_diagnostico = [
				'VentaID'       => $id,
				'Renglon'       => $datos['Renglon'],
				'RenglonID'     => $datos['RenglonID'],
				'RenglonSub'    => $datos['RenglonSub'],
				'cve_intelisis' => $datos['asigna_tecnico']
			];
			$this->db->trans_begin();
			$this->db->where(['id_diagnostico' => $datos['id_diagnostico']]);
			$this->db->update('diagnostico_tecnico', $data_diagnostico);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE ){
				$this->db->trans_rollback();
				$response['estatus'] = false;
				$response['mensaje'] = 'No fue posible actualizar el anverso con el nuevo técnico.';
			}else{
				$this->db->trans_commit();
				$response['estatus'] = true;
				$response['mensaje'] = 'Técnico asignado correctamente.';
			}
		}
		return $response;
	}
	public function firmar_reciboRefacciones($idOrden, $idRequisicion, $datos)
	{
		$firma = $this->db->select('firma_electronica')->from('usuarios')->where("id", $this->session->userdata["logged_in"]["id"])->get()->row_array();
		$perfil = $this->session->userdata["logged_in"]["perfil"];
		if(isset($firma['firma_electronica']) && !empty($firma['firma_electronica'])){
		$existen = $this->db->select("*")->from('requisiciones')->where(['id_requisicion' => $idRequisicion])->get()->row_array();
		if (sizeof($existen) > 0){
		$data = [
			'recibi_piezas' => $datos['check'],
			'fecha_recepcion' => date('d-m-Y H:i:s')
		];
		/*echo '<pre>'; print_r($existen);
		echo '</pre>';*/
		if ($existen['entregado']) {
			$this->db->trans_start();
			$this->db->where(['id_requisicion' => $idRequisicion, 'id_orden' => $idOrden]);
			if($perfil == 7){
				$this->db->update('requisiciones', $data);
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = 'No fue posible actualizar el estatus de la requisición.';
				}else {
					$this->db->trans_commit();
					$response['estatus'] = true;
					$response['mensaje'] = 'Estatus de la requisición actualizado.';
				}
			}else{
				$response["estatus"] = false;
				$response["mensaje"] = 'Su perfil no es el indicado para recibir piezas.';
			}
		}else {
			$response["estatus"] = false;
			$response["mensaje"] = 'No existen piezas para recibir, verificar con el técnico si realizó el retorno piezas.';
		}
	}else{
		$response['estatus'] = false;
		$response['mensaje'] = 'No se encontró ninguna requisición.';
	}
	}else {
		$response['estatus'] = false;
		$response['mensaje'] = 'No tienes firma registrada.';
	}
	return $response;
	}
	public function autorizar_linea($idDiagnostico, $check, $cve_intelisis)
	{
		$intelisis = $this->load->database('other',true);
		$existe = $this->db->select('*')->from('diagnostico_tecnico')->where(['id_diagnostico' => $idDiagnostico, 'terminado !=' => 1])->count_all_results();
		if ($existe > 0) {
			$diagnostico = $this->db->select('*')->from('diagnostico_tecnico')->where(['id_diagnostico' => $idDiagnostico, 'terminado !=' => 1])->get()->row_array();
			$pendientes = $this->db->select('*')->from('diagnostico_tecnico')->where(['cve_intelisis' => $cve_intelisis, 'terminado !=' => 1])->count_all_results();
			$orden = $this->db->select('id_orden_intelisis')->from('orden_servicio')->where(['id' => $diagnostico['id_orden']])->get()->row_array();
			$venta = $intelisis->select('MovID')->from('Venta')->where(['ID' => $orden['id_orden_intelisis']])->get()->row_array();
			if ($check == 'true' && $pendientes > 1) {
				$response['estatus'] = false;
				$response['mensaje'] = "El técnico con clave {$cve_intelisis} ya tiene un anverso trabajando. Es necesario terminar el anverso o asigne otro técnico.";
			}elseif (isset($venta['MovID'])) {
				$this->db->trans_begin();
				$this->db->where(['id_diagnostico' => $idDiagnostico]);
				$this->db->update('diagnostico_tecnico', ['autorizado' => $check]);
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE ){
					$this->db->trans_rollback();
					$response['estatus'] = false;
					$response['mensaje'] = $check == 'true' ? 'No fue posible autorizar el anverso.' : 'No fue posible desautorizar el anverso.';
				}else{
					$this->db->trans_commit();
					$response['estatus'] = true;
					$response['mensaje'] = $check == 'true' ? 'Anverso autorizado correctamente.' : 'Anverso desautorizado correctamente.';
				}
			} else {
				$response['estatus'] = false;
				$response['mensaje'] = $check == 'true' ? 'Necesitas afectar la orden en intelisis antes de autorizar.' : 'Necesitas afectar la orden en intelisis antes de desautorizar.';
			}
		}else {
			$response['estatus'] = false;
			$response['mensaje'] = $check == 'true' ? 'No es posible autorizar un anverso cerrado.' : 'No es posible desautorizar un anverso cerrado.';
		}
		return $response;
	}
	public function obtener_detalles_diagnostico_pdf($idOrden, $idRevision)
	{
		$response['data'] = $this->db->select('*')->from('diagnostico_tecnico')->where(['id_orden' => $idOrden, 'id_diagnostico' => $idRevision])->get()->row_array();
		if (sizeof($response['data']) > 0) {
			$response['data']['detalles'] = $this->db->select('*')->from('detalles_diagnostico_tecnico')->where(['id_diagnostico' => $response['data']['id_diagnostico']])->get()->result_array();
			$response['estatus']          = true;
			$response['mensaje']          = 'Ok.';
		} else {
			$response['estatus'] = false;
			$response['data']    = [];
			$response['mensaje'] = 'La orden no cuenta con una línea activa para realizar el llenado de información.';
		}
		return $response;
	}
	public function obtener_manos_obra_orden($idOrden)
	{
		$this->db2 = $this->load->database('other',true);
		$orden = $this->db->select('*')->from('orden_servicio')->where(['id' => $idOrden])->get()->row_array();
		$response['lineas_reparacion'] = $this->db->select('*')->from('lineas_reparacion')->where(['id_orden' => $idOrden])->get()->result_array();
		if (sizeof($orden) > 0 ) {
			$response['manos'] = $this->db2->select('*, IdVenta AS ID, descripcion AS Descripcion1')->from('vwCA_GarantiasPartsOperaciones')->where(['IdVenta' => $orden['id_orden_intelisis'], 'Tipo' => 'Servicio'])->get()->result_array();
			if (sizeof($response['manos']) > 0) {
				foreach ($response['manos'] as $key => $mano) {
					$response['manos'][$key]['autorizado'] = $this->db->select('autorizado')->from('diagnostico_tecnico')->where(['VentaID' => $mano['ID'], 'Renglon' => $mano['Renglon'], 'RenglonID' => $mano['RenglonID'],'RenglonSub' => $mano['RenglonSub'], 'autorizado' => 1])->count_all_results();
				}
				$response['estatus'] = true;
				$response['mensaje'] = "Ok.";
				$response['total_manos'] = sizeof($response['manos']);
			} else {
				$response['estatus'] = false;
				$response['mensaje'] = 'No hay líneas cargadas para la garantía.';
				$response['total_manos'] = 0;
			}
		} else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No hay líneas cargadas para la garantía.';
			$response['total_manos'] = 0;
		}
		return $response;
	}
	public function obtener_historial_anversos($idOrden)
	{
		$this->db2 = $this->load->database('other',true);
		$orden = $this->db->select('*')->from('orden_servicio')->where(['id' => $idOrden])->get()->row_array();
		if (sizeof($orden) > 0 ) {
			$response['manos'] = $this->db2->select('*, IdVenta AS ID, descripcion AS Descripcion1')->from('vwCA_GarantiasPartsOperaciones')->where(['IdVenta' => $orden['id_orden_intelisis'], 'Tipo' => 'Servicio'])->get()->result_array();
			if (sizeof($response['manos']) > 0) {
				$response['estatus'] = true;
				$response['mensaje'] = "Ok.";
				foreach ($response['manos'] as $key => $mano) {
					$response['manos'][$key]['diagnostico'] = $this->db->select('*')->from('diagnostico_tecnico')->where(['VentaID' => $mano['IdVenta'], 'RenglonID' => $mano['RenglonID'], 'Renglon' => $mano['Renglon']])->get()->row_array();
				}
			} else {
				$response['estatus'] = false;
				$response['mensaje'] = 'No hay líneas cargadas para la garantía.';
			}
		} else {
			$response['estatus'] = false;
			$response['mensaje'] = 'No hay líneas cargadas para la garantías.';
		}
		return $response;
	}
	public function validar_estatus_orden_mano($idOrden)
	{
		$this->db2 = $this->load->database('other',true);
		$orden = $this->db->select('*')->from('orden_servicio')->where(['id' => $idOrden])->get()->row_array();
		if (sizeof($orden) > 0 ) {
			$venta = $this->db2->select('Estatus')->from('Venta')->where(['id' => $orden['id_orden_intelisis']])->get()->row_array();
			if ($venta['Estatus'] != 'SINAFECTAR') {
				$response['estatus'] = false;
				$response['mensaje'] = 'No puedes añadir manos de obra a una orden afectada.';
			}else {
				$response['estatus'] = true;
				$response['mensaje'] = 'Estatus sin afectar.';
			}
		} else {
			$response['estatus'] = false;
			$response['mensaje'] = 'Orden no válida.';
		}
		return $response;
	}
	public function obtener_tipos_garantia($idSucursal)
	{
		$response['tipos'] = $this->db->select('*')->from('tipos_garantia')->get()->result_array();
		if (sizeof($response['tipos']) > 0) {
			$response['estatus'] = true;
			$response['mensaje'] = sizeof($response['tipos'])." tipos de garantía encontrados.";
		} else {
			$response['estatus'] = false;
			$response['tipos'] = [];
			$response['mensaje'] = "No se encontraron tipos de garantía.";
		}
		return $response;
	}
	public function obtener_tipos_garantia_activos($idSucursal)
	{
		$response['tipos'] = $this->db->select('*')->from('tipos_garantia')->where(['eliminado' => 0])->get()->result_array();
		if (sizeof($response['tipos']) > 0) {
			$response['estatus'] = true;
			$response['mensaje'] = sizeof($response['tipos'])." tipos de garantía encontrados.";
		} else {
			$response['estatus'] = false;
			$response['tipos'] = [];
			$response['mensaje'] = "No se encontraron tipos de garantía.";
		}
		return $response;
	}
	public function guardar_tipos_garantia($idSucursal, $datos)
	{
		$usuario = $this->session->userdata["logged_in"];
		$data = [
			'nombre'         => isset($datos['nombre']) ? $datos['nombre'] : null,
			'descripcion'    => isset($datos['descripcion']) ? $datos['descripcion'] : null,
			'fecha_creacion' => date("d-m-Y H:i:s"),
			'eliminado'      => 0,
			'usuario'        => $usuario['nombre']
		];
		if($usuario['perfil'] == 7){
			$this->db->trans_start();
			$id = $this->db->insert('tipos_garantia', $data);
			$id = $this->db->insert_id();
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$response['estatus'] = false;
				$response['id'] = null;
				$response['mensaje'] = 'No fue posible crear el tipo de garantía.';
			}else{
				$this->db->trans_commit();
				$response['estatus'] = true;
				$response['id'] = $id;
				$response['mensaje'] = 'Tipo de garantía agregado correctamente.';
			}
		} else {
			$response['estatus'] = false;
			$response['id'] = null;
			$response['mensaje'] = "Solo los administradores de garantías pueden crear tipos de garantías.";
		}
		return $response;
	}
	public function editar_tipos_garantia($idSucursal,$idTipo, $datos)
	{
		$usuario = $this->session->userdata["logged_in"];
		$data = [
			'nombre'              => isset($datos['nombre']) ? $datos['nombre'] : null,
			'descripcion'         => isset($datos['descripcion']) ? $datos['descripcion'] : null,
			'fecha_actualizacion' => date("d-m-Y H:i:s"),
			'usuario'             => $usuario['nombre']
		];
		$existe = $this->db->select('*')->from('tipos_garantia')->where(['id' => $idTipo])->get()->row_array();
		if ($existe == 0 ) {
			$response['estatus'] = false;
			$response['mensaje'] = "El tipo de garantía seleccionado no existe.";
		}elseif($usuario['perfil'] == 7){
			$this->db->trans_start();
			$this->db->where('id', $idTipo);
			$this->db->update('tipos_garantia', $data);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$response['estatus'] = false;
				$response['mensaje'] = 'No fue posible actualizar el tipo de garantía.';
			}else{
				$this->db->trans_commit();
				$response['estatus'] = true;
				$response['mensaje'] = 'Tipo de garantía actualizado correctamente.';
			}
		} else {
			$response['estatus'] = false;
			$response['mensaje'] = "Solo los administradores de garantías pueden actualizar tipos de garantías.";
		}
		return $response;
	}
	public function estatus_tipos_garantia($idSucursal,$idTipo, $datos)
	{
		$usuario = $this->session->userdata["logged_in"];
		$existe = $this->db->select('id')->from('tipos_garantia')->where(['id' => $idTipo])->count_all_results();
		$data = [
			'eliminado'           => $datos['eliminado'],
			'fecha_eliminacion'   => $datos['eliminado'] == 1 ?  date("d-m-Y H:i:s") : null,
			'fecha_actualizacion' => date("d-m-Y H:i:s"),
			'usuario'             => $usuario['nombre']
		];
		if ($existe == 0 ) {
			$response['estatus'] = false;
			$response['mensaje'] = "El tipo de garantía seleccionado no existe.";
		}elseif($usuario['perfil'] == 7){
			$this->db->trans_start();
			$this->db->where('id', $idTipo);
			$this->db->update('tipos_garantia', $data);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$response['estatus'] = false;
				$response['mensaje'] = 'No fue posible actualizar el estatus del tipo de garantía.';
			}else{
				$this->db->trans_commit();
				$response['estatus'] = true;
				$response['mensaje'] = 'Estatus del tipo de garantía actualizado correctamente.';
			}
		} else {
			$response['estatus'] = false;
			$response['mensaje'] = "Solo los administradores de garantías pueden actualizar el estatus de los tipos de garantías.";
		}
		return $response;
	}

	public function obtener_tipo_garantia($idSucursal,$idTipo)
	{
		$usuario = $this->session->userdata["logged_in"];
		$existe = $this->db->select('*')->from('tipos_garantia')->where(['id' => $idTipo])->get()->row_array();
		if (sizeof($existe) > 0 ) {
			$response['estatus'] = true;
			$response['tipo']    = $existe;
			$response['mensaje'] = "Tipo de garantía encontrado.";
		} else {
			$response['estatus'] = false;
			$response['tipo']    = [];
			$response['mensaje'] = "El tipo de garantía no existe.";
		}
		return $response;
	}
	public function obtener_subtipos_garantia($idSucursal)
	{
		$response['subtipos'] = $this->db->select('*')->from('subtipos_garantia')->get()->result_array();
		if (sizeof($response['subtipos']) > 0) {
			$response['estatus'] = true;
			$response['mensaje'] = sizeof($response['subtipos'])." subtipos de garantía encontrados.";
		} else {
			$response['estatus'] = false;
			$response['subtipos'] = [];
			$response['mensaje'] = "No se encontraron subtipos de garantía.";
		}
		return $response;
	}
	public function obtener_subtipos_garantia_activos($idSucursal)
	{
		$response['subtipos'] = $this->db->select('*')->from('subtipos_garantia')->where(['eliminado' => 0])->get()->result_array();
		if (sizeof($response['subtipos']) > 0) {
			$response['estatus'] = true;
			$response['mensaje'] = sizeof($response['subtipos'])." subtipos de garantía encontrados.";
		} else {
			$response['estatus'] = false;
			$response['subtipos'] = [];
			$response['mensaje'] = "No se encontraron subtipos de garantía.";
		}
		return $response;
	}
	public function guardar_subtipos_garantia($idSucursal, $datos)
	{
		$usuario = $this->session->userdata["logged_in"];
		$data = [
			'nombre'         => isset($datos['nombre']) ? $datos['nombre'] : null,
			'descripcion'    => isset($datos['descripcion']) ? $datos['descripcion'] : null,
			'fecha_creacion' => date("d-m-Y H:i:s"),
			'eliminado'      => 0,
			'usuario'        => $usuario['nombre']
		];
		if($usuario['perfil'] == 7){
			$this->db->trans_start();
			$id = $this->db->insert('subtipos_garantia', $data);
			$id = $this->db->insert_id();
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$response['estatus'] = false;
				$response['id'] = null;
				$response['mensaje'] = 'No fue posible crear el subtipo de garantía.';
			}else{
				$this->db->trans_commit();
				$response['estatus'] = true;
				$response['id'] = $id;
				$response['mensaje'] = 'Tipo de garantía agregado correctamente.';
			}
		} else {
			$response['estatus'] = false;
			$response['id'] = null;
			$response['mensaje'] = "Solo los administradores de garantías pueden crear subtipos de garantías.";
		}
		return $response;
	}
	public function editar_subtipos_garantia($idSucursal,$idSubtipo, $datos)
	{
		$usuario = $this->session->userdata["logged_in"];
		$data = [
			'nombre'              => isset($datos['nombre']) ? $datos['nombre'] : null,
			'descripcion'         => isset($datos['descripcion']) ? $datos['descripcion'] : null,
			'fecha_actualizacion' => date("d-m-Y H:i:s"),
			'usuario'             => $usuario['nombre']
		];
		$existe = $this->db->select('*')->from('subtipos_garantia')->where(['id' => $idSubtipo])->get()->row_array();
		if ($existe == 0 ) {
			$response['estatus'] = false;
			$response['mensaje'] = "El tipo de garantía seleccionado no existe.";
		}elseif($usuario['perfil'] == 7){
			$this->db->trans_start();
			$this->db->where('id', $idSubtipo);
			$this->db->update('subtipos_garantia', $data);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$response['estatus'] = false;
				$response['mensaje'] = 'No fue posible actualizar el subtipo de garantía.';
			}else{
				$this->db->trans_commit();
				$response['estatus'] = true;
				$response['mensaje'] = 'Tipo de garantía actualizado correctamente.';
			}
		} else {
			$response['estatus'] = false;
			$response['mensaje'] = "Solo los administradores de garantías pueden actualizar subtipos de garantías.";
		}
		return $response;
	}
	public function estatus_subtipos_garantia($idSucursal,$idSubtipo, $datos)
	{
		$usuario = $this->session->userdata["logged_in"];
		$existe = $this->db->select('id')->from('subtipos_garantia')->where(['id' => $idSubtipo])->count_all_results();
		$data = [
			'eliminado'           => $datos['eliminado'],
			'fecha_eliminacion'   => $datos['eliminado'] == 1 ?  date("d-m-Y H:i:s") : null,
			'fecha_actualizacion' => date("d-m-Y H:i:s"),
			'usuario'             => $usuario['nombre']
		];
		if ($existe == 0 ) {
			$response['estatus'] = false;
			$response['mensaje'] = "El subtipo de garantía seleccionado no existe.";
		}elseif($usuario['perfil'] == 7){
			$this->db->trans_start();
			$this->db->where('id', $idSubtipo);
			$this->db->update('subtipos_garantia', $data);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$response['estatus'] = false;
				$response['mensaje'] = 'No fue posible actualizar el estatus del subtipo de garantía.';
			}else{
				$this->db->trans_commit();
				$response['estatus'] = true;
				$response['mensaje'] = 'Estatus del subtipo de garantía actualizado correctamente.';
			}
		} else {
			$response['estatus'] = false;
			$response['mensaje'] = "Solo los administradores de garantías pueden actualizar el estatus de los subtipos de garantías.";
		}
		return $response;
	}

	public function obtener_subtipo_garantia($idSucursal,$idSubtipo)
	{
		$usuario = $this->session->userdata["logged_in"];
		$existe = $this->db->select('*')->from('subtipos_garantia')->where(['id' => $idSubtipo])->get()->row_array();
		if (sizeof($existe) > 0 ) {
			$response['estatus'] = true;
			$response['subtipo']    = $existe;
			$response['mensaje'] = "Subtipo de garantía encontrado.";
		} else {
			$response['estatus'] = false;
			$response['subtipo']    = [];
			$response['mensaje'] = "El subtipo de garantía no existe.";
		}
		return $response;
	}
}
