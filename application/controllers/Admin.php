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


}