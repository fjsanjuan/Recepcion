<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

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
	public function search(){
		$logged_in = $this->session->userdata("logged_in");
		if(!empty($logged_in)){
			$data['contenido'] = $this->load->view("buscador",'',true);
			$data['scripts'] = $this->load->view("scripts",'',true);
			$data['navbar'] = $this->load->view('navbar','', true);
			$this->load->view("base", $data);
		}else{
			$data['contenido'] = $this->load->view("login",'',true);
			$data['scripts'] = $this->load->view('scripts','',true);
			$data['navbar'] = $this->load->view('navbar2','', true);
        	$this->load->view("base", $data);
		}
	}
	
}