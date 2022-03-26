<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$logged_in = $this->session->userdata("logged_in");
		$this->load->vars(array(
			"logged_in"=>$logged_in
		));
	}
	public function index(){
  		show_404();
  	}
	public function dash(){
		$data['navbar']  =  $this->load->view('admin/navbar','', true);
		$data['sidebar'] = $this->load->view('admin/sidebar','', true);
		$data['scripts'] = $this->load->view('scripts','',true);
		$data['contenido']  =  $this->load->view('admin/dash','', true);
		$this->load->view('admin/base', $data);
	}

	public function checklist(){
		$data['navbar']  =  $this->load->view('admin/navbar','', true);
		$data['contenido']  =  $this->load->view('admin/checklist','', true);
		$this->load->view('admin/base', $data);
	}

	public function usuarios(){

		$logged_in = $this->session->userdata("logged_in");
		if(!empty($logged_in) && $logged_in['perfil']==1){
		  	$data['navbar']  =  $this->load->view('admin/navbar','', true);
			$data['sidebar'] = $this->load->view('admin/sidebar','', true);
		  	$data['contenido'] = $this->load->view("registro_form",'',true);
		    $this->load->view("admin/base", $data);

		}else{
			show_404();
		}
		
	}

	public function cambiar_variable_entorno() {
		$logged_in = $this->session->userdata("logged_in");
		$response['estatus'] = false;
		$response['mensaje'] = 'Los campos "variable" y "valor" son requeridos.';
		$key = $this->input->post('key') != '' ? $this->input->post('key') : null;
		$value = $this->input->post('value') != '' ? $this->input->post('value') : null;
		$create = $this->input->post('create') != '' ? $this->input->post('create') : null;
		if (empty($logged_in) || $logged_in['perfil'] != 7) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Solo el administrador de garantía puede cambiar la ruta de almacenamiento del expediente digital.';
		}elseif ($key !== null || $value !== null) {
			$value = substr($value, 0,1) == '/' ? substr($value,1, -1) : $value;
			$value = substr($value, -1) != '/' ? "{$value}/" : $value;
			$dotenv = new Dotenv\Dotenv(realpath(''));
			$response = $dotenv->setEnvironmentValue($key, $value);
			if ($create != null && $create == true) {
				if(!file_exists($value)) {
					mkdir($value, 0777, true);
				}
			}
		}
		echo json_encode($response);
	}

}
