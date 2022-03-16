<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buscador extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("buscador_model");
	}

	public function index(){
		$data['contenido'] = $this->load->view("buscador",'',true);
		$data['scripts'] = $this->load->view("scripts",'',true); 
        $this->load->view("base", $data);
	}

	function resultados(){
		$datos = $this->input->post();
		$temp = $this->buscador_model->traer_datos($datos);
		$data['contenido'] = $this->load->view("resultados",$temp,true);
		$data['navbar'] = $this->load->view('navbar','', true);
		$data['scripts'] = $this->load->view("scripts",'',true);
        $this->load->view("base", $data);

	}


	function resultadosprincipal(){
		$datos = $this->input->post();
		$temp = $this->buscador_model->traer_datos($datos);
		// $data['contenido'] = $this->load->view("resultados",$temp,true);
		// $data['navbar'] = $this->load->view('navbar','', true);
		// $data['scripts'] = $this->load->view("scripts",'',true);
		// print_r($temp);
        $this->load->view("resultados", $temp);
        // echo json_encode($data);

	}

	function intro(){
		$data['contenido'] = $this->load->view("intro",'',true);
		$data['scripts'] = $this->load->view("scripts",'',true);
        $this->load->view("base", $data);	
	}

	function sin_resultados(){
		$data['contenido'] = $this->load->view("no_encontrados",'',true);
		$data['scripts'] = $this->load->view("scripts",'',true);
        $this->load->view("base", $data);
	}
	function alta_cliente(){
		$data['contenido'] = $this->load->view("alta_cliente",'',true);
		$data['scripts'] = $this->load->view("scripts",'',true);
        $this->load->view("base", $data);
	}
	function alta_vin_articulo(){
		$data['contenido'] = $this->load->view("alta_vin_articulo",'',true);
		$data['scripts'] = $this->load->view("scripts",'',true);
        $this->load->view("base", $data);
	}
	function buscar_cliente(){
		
		if (isset($_GET['term'])){
			$valor = ($_GET['term']);
			$q= explode(" ", $valor);
			//var_dump($q);
			//die();
			$result= $this->buscador_model->autocomplete($q);
			foreach ($result as $key => $value) {
 			 	if($value == 0)
 			 	{
 			 		unset($result[$key]);
 			 	}
 			}
  			echo json_encode($result);
		}
	}
	function buscar_art(){
		if (isset($_GET['term'])){
			$valor = ($_GET['term']);
			$li    = ($_GET['li']);
			$q= explode(" ", $valor);
			//var_dump($q);
			
			$result= $this->buscador_model->autocomplete_art($q,$li);
			foreach ($result as $key => $value) {
 			 	if($value == 0)
 			 	{
 			 		unset($result[$key]);
 			 	}
 			}
  			echo json_encode($result);
		}
	}

	function buscar_mo(){
		if (isset($_GET['term'])){
			$valor = ($_GET['term']);
			$q  =  $valor;
			//bucar mano de obra
			$result= $this->buscador_model->autocomplete_mo($q);
			echo json_encode($result);
		}
	}

	public function busqueda(){
		$data = $this->input->post();
		$data['busqueda'] = explode(" ", $data['busqueda']);
		//var_dump($data);die();
		$ret = $this->buscador_model->busqueda($data);
		//var_dump($ret);
		echo json_encode($ret);
	}

	public function ver_horariosAg()
	{
		$horarios = $this->buscador_model->ver_horariosAg();
		echo json_encode($horarios);
	}

	public function guardar_nuevoCliente()
	{
		$datos = $this->input->post();
		$cliente = $this->buscador_model->guardar_nuevoCliente($datos);
		echo json_encode($cliente);
	}

	public function guardar_nuevoArt()
	{
		$datos = $this->input->post();
		$articulo = $this->buscador_model->guardar_nuevoArt($datos);
		echo json_encode($articulo);
	}

	public function guardar_nuevoVin()
	{
		$datos = $this->input->post();
		$vin = $this->buscador_model->guardar_nuevoVin($datos);
		echo json_encode($vin);
	}

	public function calculacargataller($dia = 0)
	{
		$ret = $this->buscador_model->calculacargataller($dia);
		echo json_encode($ret);
	}

	public function autocomplete_artAltaVin()
	{
		$cadena = $this->input->post("cadena");
		$art = $this->buscador_model->autocomplete_artAltaVin($cadena);
		echo json_encode($art);
	}
	public function buscar_OrdenesVin()
	{
		$vin = $this->input->post("vin");
		//print_r($vin);
		$datos = $this->buscador_model->buscar_OrdenesVin($vin);
		echo json_encode($datos);
	}

	public function enviar_horaRecep()
	{
		$datos = $this->input->post();
		$id_cita = $this->input->post("cita");
		$tipo = $datos["tipo"];
		$hora = $datos["hora"];

		$envio = $this->buscador_model->guardar_horaRecep($id_cita, $tipo, $hora);

		echo json_encode($envio);
	}
	public function actualizavin($vin, $id)	{		
		$ret = $this->buscador_model->actualizavin($vin,$id);		
		echo json_encode($ret);	
	}

	public function ver_historico()
	{
		$logged_in = $this->session->userdata("logged_in");
		if(empty($logged_in) == false)
		{
			$data["scripts"] = $this->load->view("scripts", "", true);	
			$data["navbar"] = $this->load->view("navbar", "", true);	
			$data["contenido"] = $this->load->view("historico_ordenes", "", true);
			$this->load->view("base", $data);
		}else
		{
			show_404();
		}	
	}

	public function obtener_ordenesPasadas()
	{
		$fecha_ini = $this->input->post("fecha_ini");
		$fecha_fin = $this->input->post("fecha_fin");

		$ordenes = $this->buscador_model->obtener_ordenesPasadas($fecha_ini, $fecha_fin);

		echo json_encode($ordenes);
	}
	public function search_budget(){
		$id_orden = $this->input->post("id");
		$presupuestos = $this->buscador_model->search_budget($id_orden);
		echo json_encode($presupuestos);
	}
	public function search_verificacion(){
		$id_orden = $this->input->post("id");
		$verificacion_refacciones = $this->buscador_model->search_verificacion($id_orden);
		echo json_encode($verificacion_refacciones);
	}

	public function revisar_tickaje()
	{
		$data = $this->input->post();
		$ret = $this->buscador_model->revisar_tickaje($data);
		echo json_encode($ret);
	}

	public function buscar_mo_lineas(){
		if (isset($_GET['term'])){
			$valor = ($_GET['term']);
			$q  =  $valor;
			//bucar mano de obra
			$response= $this->buscador_model->autocomplete_mo_lineas($q);
		}else {
			$response['estatus'] = false;
			$response['mensaje'] = 'Lista no válida.';
		}
		echo json_encode($response);
	}
	public function administrar_tipos()
	{
		$logged_in = $this->session->userdata("logged_in");
		if(empty($logged_in) == false && $logged_in['perfil'] == 7)
		{
			$data["scripts"] = $this->load->view("scripts", "", true);	
			$data["navbar"] = $this->load->view("navbar", "", true);	
			$data["contenido"] = $this->load->view("tipos_garantia", "", true);
			$this->load->view("base", $data);
		}else
		{
			$response['heading'] = 'Permiso denegado.';
			$response['message'] = 'Solo los administradores pueden visualizar la página de tipos de garantía.';
			$this->load->view("errors/html/error_404", $response);
		}	
	}
	
	public function administrar_subtipos()
	{
		$logged_in = $this->session->userdata("logged_in");
		if(empty($logged_in) == false && $logged_in['perfil'] == 7)
		{
			$data["scripts"] = $this->load->view("scripts", "", true);	
			$data["navbar"] = $this->load->view("navbar", "", true);	
			$data["contenido"] = $this->load->view("subtipos_garantia", "", true);
			$this->load->view("base", $data);
		}else
		{
			$response['heading'] = 'Permiso denegado.';
			$response['message'] = 'Solo los administradores pueden visualizar la página de subtipos de garantía.';
			$this->load->view("errors/html/error_404", $response);
		}	
	}
	public function administrar_clave_defecto()
	{
		$logged_in = $this->session->userdata("logged_in");
		if(empty($logged_in) == false && $logged_in['perfil'] == 7)
		{
			$data["scripts"] = $this->load->view("scripts", "", true);	
			$data["navbar"] = $this->load->view("navbar", "", true);	
			$data["contenido"] = $this->load->view("claves_defecto", "", true);
			$this->load->view("base", $data);
		}else
		{
			$response['heading'] = 'Permiso denegado.';
			$response['message'] = 'Solo los administradores pueden visualizar la página de administración de claves de defecto.';
			$this->load->view("errors/html/error_404", $response);
		}	
	}

	// public function administrar_tecnicos()
	// {
	// 	$logged_in = $this->session->userdata("logged_in");
	// 	if(empty($logged_in) == false && $logged_in['perfil'] == 5)
	// 	{
	// 		$data["scripts"] = $this->load->view("scripts", "", true);	
	// 		$data["navbar"] = $this->load->view("navbar", "", false);	
	// 		$data["contenido"] = $this->load->view("configuracion_perfil", "", true);
	// 		$this->load->view("base", $data);
	// 	}else
	// 	{
	// 		$response['heading'] = 'Permiso denegado.';
	// 		$response['message'] = 'Solo los técnicos, realizan este proceso.';
	// 		$this->load->view("errors/html/error_404", $response);
	// 	}	
	// }
}
