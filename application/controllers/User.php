<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller { 
	public function __construct(){
    	parent::__construct();
    	$this->load->helper(array('form', 'url'));
    	$this->load->library('form_validation');
  	}

  	public function index(){
  		show_404();
  	}
  	//view
  	function registro_form(){
  		$logged_in = $this->session->userdata("logged_in");
		if(!empty($logged_in) && $logged_in['perfil']==1){
		  	$data['contenido'] = $this->load->view("registro_form",'',true);
		  	$data['scripts'] = $this->load->view("scripts",'',true);
		    $this->load->view("base", $data);
		}else{
			show_404();
		}
  	}
  	function create(){
  		$logged_in = $this->session->userdata("logged_in");
		if(!empty($logged_in) && $logged_in['perfil']==1){
	    	$this->form_validation->set_rules('nombre_usr', 'Nombre', 'trim|required|xss_clean|prep_for_form|htmlspecialchars|min_length[2]|max_length[200]');
	    	$this->form_validation->set_rules('apellido_usr', 'Apellidos', 'trim|required|xss_clean|prep_for_form|htmlspecialchars|min_length[2]|max_length[200]');
	    	$this->form_validation->set_rules('email_usr', 'Email', 'trim|required|valid_email');
	    	$this->form_validation->set_rules('password_usr', 'Contraseña', 'trim|required|min_length[6]|max_length[50]|matches[repassword_usr]');
	   	    $this->form_validation->set_rules('repassword_usr', 'Confirmar Contraseña', 'trim|required');

	    	if($this->form_validation->run() == FALSE) {
	        	$data = array('success' =>0, 'errors' => $this->form_validation->error_array());
	    	} else {
	    		
		    	$data['nombre_usr'] = $this->input->post('nombre_usr');
		    	$data['apellido_usr'] = $this->input->post('apellido_usr');
		    	$data['email_usr'] = strtolower($this->input->post('email_usr'));
		    	$data['password_usr'] = $this->input->post('password_usr');
		    	$data['rol_usr'] = $this->input->post('rol_usr');
		    	$data['cve_user'] = $this->input->post('cve_usuario');
		    	$data['sucursal'] = $this->input->post('usuario_suc');
		    	$this->load->model('user_model');

		    	$create=$this->user_model->create($data);

				if($create){
					$data = array('success' =>1, 'data' => ('Usuario creado satisfactoriamente.'));
				}else
					$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
	    	}

		    $data = json_encode($data);
			$data=array('response'=>$data);
			$this->load->view('ajax',$data);
		}else{
			show_404();
		}
  	}
  	/* Login usuario común */
	function login(){
		$this->form_validation->set_rules('email', 'Correo', 'trim|required|xss_clean|valid_email|prep_for_form|htmlspecialchars');
		$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|min_length[6]|max_length[50]');

		if ($this->form_validation->run() == FALSE){
			$data = array('success' =>0, 'errors' => $this->form_validation->error_array());
		}else{
			$this->load->model('user_model');
			$data['usr_email'] = $this->input->post('email');
			$data['usr_password'] = $this->input->post('password');
			
			$login=$this->user_model->login($data);
			if($login['status'] == 1){
				$user = $login['user'];
				
				$sess_array = array(
					'id' => $user->id,
					'usuario_intelisis' => $user->usuario,
					'nombre' => $user->nombre,
					'correo' => $user->email,
					'perfil' => $user->perfil,
					'id_agencia' => $user->id_agencia,
					'id_sucursal' => $user->id_sucursal,
					'cve_intelisis' => $user->cve_intelisis,
					'almacen_servicio' => $user->almacen_servicio,
					'almacen_refac'=> $user->almacen_refacciones,
					'sucursal_int' => $user->sucursal_int
				);
				$this->session->set_userdata('logged_in', $sess_array);
				
				$actions = $this->session->userdata("actions");
				if( !empty($actions)){
					$data = array('success' =>1, 'data' => ('Ingresando'), 'actions'=>$actions);
				}else{
					$data = array('success' =>1, 'data' => ('Ingresando'), 'href'=>site_url());
				}
			}else{
				if($login['status'] == -1){
					$data = array('success' =>0, 'data' => ('Usuario o contraseña incorrectos'));//Contraseña incorrecta
				}else if($login['status'] == -2){
					$data = array('success' =>0, 'data' => ('Usuario o contraseña incorrectos'));//Usuario inexistente 
				}else if($login['status'] == -3){
					$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso'));
				}else{
					$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso'));
				}
			}
		}
		// print_r($data);die;
		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}

  function logout(){
		$this->session->sess_destroy();
		redirect();
	}

	function resumen_cliente(){
		//$logged_in = $this->session->userdata("logged_in");
		$datos = $this->input->post();
		//var_dump($datos);
		$data['contenido'] = $this->load->view("cliente_resumen",$datos,true);
		$data['navbar'] = $this->load->view('navbar','', true);
		$data['scripts'] = $this->load->view("scripts",'',true);
	    $this->load->view("base", $data);
	}


	function cargar_datos_id(){

		$id = $this->input->post('id');
		$this->load->model('user_model');
		$datos = $this->user_model->datos_cliente($id);
		echo json_encode($datos);
	}

	//cargamos los datos que estan registrados en venta para generar orden
	function cargar_datos_vta(){
		$idVta = $this->input->post('id');
		$datos = $this->input->post();
		$this->load->model('user_model');
		$datos = $this->user_model->datos_vta($idVta, $datos);
		// print_r($datos);
		echo json_encode($datos);
	}

	//vista form
	function actualizar_datos(){
		$datos = $this->input->post();
		$data['contenido'] = $this->load->view("forms/actualizar_cliente_form",$datos,true);
		$data['scripts'] = $this->load->view("scripts",'',true);
	    $this->load->view("base", $data);
	}

	function actualiza_ciente_id(){

		$data['id']                = trim($this->input->post('id_c'));
		$data['nombre_cliente']    = trim($this->input->post('nombre_cliente'));
		$data['telefono_cliente']  = trim($this->input->post('telefono_cliente'));
		$data['celular_cliente']   = trim($this->input->post('celular_cliente'));
		$data['email_usr']         = strtolower($this->input->post('email_cliente'));
		$data['rfc_cliente']       = trim($this->input->post('rfc_cliente'));
		$data['direc_cliente']     = trim($this->input->post('direc_cliente'));
		$data['no_ext_cliente']    = trim($this->input->post('no_ext_cliente'));
		$data['no_int_cliente']    = trim($this->input->post('no_int_cliente'));
		$data['colonia_cliente']   = trim($this->input->post('colonia_cliente'));
		$data['poblacion_cliente'] = trim($this->input->post('poblacion_cliente'));
		$data['edo_cliente']       = trim($this->input->post('edo_cliente'));
		$data['cp_cliente']        = trim($this->input->post('edo_cliente'));

		$this->load->model('user_model');

		$update=$this->user_model->update_cli($data);

		if($update){
			$data = array('success' =>1, 'data' => ('Usuario actualozado satisfactoriamente.'));
		}else{
			$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
		}

		echo json_encode($data);
	}

	public function actualizar_datosOrden()
	{
		$datos = $this->input->post();
		 $this->load->model("user_model");
		$actualizacion = $this->user_model->actualizar_datosOrden($datos);

		echo json_encode($actualizacion);
	}

	public function crear_ordenServicio()
	{
		$datos = $this->input->post();

		// print_r($datos);die;
		$this->load->model("user_model");
		$orden = $this->user_model->crear_ordenServicio($datos);

		echo json_encode($orden);
	}

	public function nueva_ordenServicio()
	{
		$datos = $this->input->post();

		// print_r($datos);die;
		$this->load->model("user_model");
		$orden = $this->user_model->nueva_ordenServicio($datos);

		echo json_encode($orden);
	}

	public function existe_ordenCita()
	{
		$datos = $this->input->post();

		//$datos['cliente'];
		//$datos['vin'];
		//$datos['no_cita'];
		//print_r($datos['no_cita']);die;
		$this->load->model("user_model");
		$orden = $this->user_model->existe_ordenCita($datos['cliente'], $datos['vin'], $datos['no_cita']);

		echo json_encode($orden);
	}

	public function guardar_firma()
	{
		$datos = $this->input->post();
		$this->load->model("user_model");
		$firma = $this->user_model->guardar_firma($datos);

		echo json_encode($firma);
	}

	public function guardar_archivo()
	{
		$datos = $this->input->post();
		
		$this->load->model("user_model");

		$archivo = $this->user_model->guardar_foto($datos);

		echo json_encode($archivo);
	}

	public function configurar_perfil()
	{
		$logged_in = $this->session->userdata("logged_in");
		if(empty($logged_in) == false)
		{
			$this->load->model("user_model");
			$id_usuario = $this->session->userdata["logged_in"]["id"];

			$datos = $this->user_model->ver_datosUsuario($id_usuario);
					
			$data["scripts"] = $this->load->view("scripts", "", true);	
			$data["navbar"] = $this->load->view("navbar", "", true);	
			$data["contenido"] = $this->load->view("configuracion_perfil", $datos, true);

			// print_r($datos);die;
			$this->load->view("base", $data);
		}else 
		{
			// echo "que pex";
			show_404();
		}
	}

	public function guardar_configPerfil()
	{
		$this->load->model("user_model");
		$datos = $this->input->post();
		$update = $this->user_model->guardar_configPerfil($datos);

		echo json_encode($update);
	}

	public function revisar_email(){
		$this->load->model("user_model");
		$data = $this->input->post();
		$ret = $this->user_model->revisar_email($data);
		echo json_encode($ret);
	}

	public function total_fotos(){
		$this->load->model("user_model");
		$data = $this->input->post();
		$total = $this->user_model->total_fotos($data);
		echo json_encode($total);
	}
}