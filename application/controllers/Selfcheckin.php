<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Selfcheckin extends CI_Controller{
	public function __construct(){
    	parent::__construct();
    	
  	}

	
	function self_check_in(){
		$logged_in = $this->session->userdata('logged_in');

		if(empty($logged_in) == false){
			$data["scripts"] = $this->load->view("scripts", "", true);	
			$data["navbar"] = $this->load->view("navbar", "", true);	
			$data["contenido"] = $this->load->view("self_check_in", "", true);
			$this->load->view("base", $data);
		}else{
			show_404();
		}
	}
}
