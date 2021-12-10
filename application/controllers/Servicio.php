<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."libraries\dompdf/autoload.inc.php";
use Dompdf\Dompdf;
class Servicio extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('buscador_model');
		$this->form_validation->set_error_delimiters('', '<br/>');
		
		//variable que controlan el tipo de formato de orden de servicio(profeco) que se enviara por correo 
		$this->formt_servicio = "ford";
		//variable para crear directorio donde se guardaran los formatos creador
		$this->ruta_formts = "../recepcion/";
		//variable para hablitar o deshabilitar el adjunto de fotos de recepcion al envio de correo
		// se solicito en cever hyundai aeropuero
		$this->adjuntar_fotos = true;

		//datos de configuracion por default para envio de correos
		$this->mail_host = "smtp.gmail.com";
		$this->mail_smtpAuth = true;
		$this->mail_username = "sistemas.intelisis@gmail.com";
		$this->mail_password = "1234*Sistema";
		$this->mail_smtpSecure = "ssl";
		$this->mail_port = 465;
		$this->APPLICATION_PATH = realpath("/");

		$this->obtener_configEmail();
		
	}

	function tablero(){
		$data['contenido'] = $this->load->view("tablero",'',true);
		$data['scripts'] = $this->load->view("scripts",'',true);
        $this->load->view("base", $data);
	}

	function obtener_asesores(){
		$b=0;
		$logged_in = $this->session->userdata("logged_in");
		$sucursal= $logged_in["id_sucursal"];
		$result= $this->buscador_model->obtener_asesores($b, $sucursal);
		echo json_encode($result);
	}

	function obtener_configEmail()
	{
		$result= $this->buscador_model->obtener_configEmail();
		$config = array('success' =>0, 'msj' => ('Se ha agregado configuracion para envio de correos por defecto, revisar con soporte.'));

		//si la consulta de obtener_configEmail() es exitosa agregará la config por bd al envio de correos de lo contrario dejará la config que se define por default en el constructor
		if($result != null){
			foreach ($result as $row) {
				$this->mail_host = $row['mail_host'];
				$this->mail_smtpAuth = $row['mail_smtpAuth'];
				$this->mail_username = $row['mail_userName'];
				$this->mail_password = $row['mail_password'];
				$this->mail_smtpSecure = $row['mail_smtpSecure'];
				$this->mail_port = $row['mail_port'];
			}
		$config = array('success' =>1, 'msj' => ('Configuracion por bd para envio de correos exitosa'));
		}		
		//print_r($this->mail_host);print_r($this->mail_smtpAuth);print_r($this->mail_username);print_r($this->mail_password);print_r($this->mail_smtpSecure);print_r($this->mail_port);
		
		//echo json_encode($config);
	}

	function obtener_horario(){
		$result= $this->buscador_model->obtener_horario();
		echo json_encode($result);
	}

	function obtener_citas(){
		$result= $this->buscador_model->obtener_citas();
		echo json_encode($result);

	}
	function citas_por_asesor(){
		$result= $this->buscador_model->obtener_citas_por_asesor();
		echo json_encode($result);		
	}
	function citas_asesor_dia(){
		$data['dia'] = $this->input->post();
		$result= $this->buscador_model->citas_asesor_dia($data);

		if($result){
			$data = array('success' =>1, 'data' => $result);
		}else{
			$data = array('success' =>0, 'data' => ('No hay citas para este dia.'));
		}
		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);		
	}
	function obtener_tecnicos(){
		$b=0;
		$logged_in = $this->session->userdata("logged_in");
		$sucursal= $logged_in["id_sucursal"];
		$result= $this->buscador_model->obtener_tecnicos($b, $sucursal);
		echo json_encode($result);
	}

	function obtener_citas_tecnicos(){
		$result= $this->buscador_model->obtener_citas_tecnicos();
		echo json_encode($result);
	}

	function nueva_cita(){
		$this->form_validation->set_rules('cita_uen', 'UEN', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE ){
			$data = array('success' =>0, 'errors' => $this->form_validation->error_array());

		}else{
			$this->load->model('buscador_model');
			$data['servicioserie']   = $this->input->post('cita_articulo');
			$data['movimiento']      = $this->input->post('cita_movimiento');
			$data['fecha_emicion']   = $this->input->post('fulldate');
			$data['hora_recepcion']  = $this->input->post('cita_hr_ini');
			$data['hora_requerida']  = $this->input->post('cita_hr_fin');
			$data['cliente']         = $this->input->post('cita_cliente');
			$data['agente']          = $this->input->post('cita_asesor');
			$data['uen']             = $this->input->post('cita_uen');
			$data['fecha_requerida'] = $this->input->post('fecha_requerida');

			$create=$this->buscador_model->crear_cita($data);
			
			if($create){
				$data = array('success' =>1, 'data' => ('Cita creada satisfactoriamente.'));
			}else{
				$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
			}

		}
		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);

	}
	function nueva_orden(){

			$this->load->model('buscador_model');
			$data['movimiento']      = $this->input->post('orden_movimiento');
			$data['cliente']         = $this->input->post('orden_cliente');
			$data['moneda']          = $this->input->post('orden_moneda');
			$data['uen']             = $this->input->post('orden_uen');
			$data['fecha_emicion']   = $this->input->post('fulldate2');
			$data['hora_recepcion'] = $this->input->post('orden_hr_fin');
			$data['hora_requerida'] = $this->input->post('cita_hr_fin');
		

		//$create=$this->buscador_model->crear_cita_tec($data);
		
		/*if($create){
			$data = array('success' =>1, 'data' => ('Cita creada satisfactoriamente.'));
		}else{
			$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
		}
		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);*/

	}
	function cargar_listas(){
		$id = $this->input->post('id');
		$this->load->model('buscador_model');
		$info=$this->buscador_model->cargar_listas($id);
		if($info){
			echo json_encode($info);
		}else{
			$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
		}
	}

	function ArticulosDeCita(){
		$datar['OrigenID'] = $this->input->post('id');
		$create=$this->buscador_model->traerArticulosCita($datar);
		// print_r($create);
		echo json_encode($create);
	}
	function nueva_orden_detalle()
	{
		$logged_in = $this->session->userdata("logged_in");
		$formulario = $this->input->post();
		$elementos = (isset($formulario["elementos"])) ? json_decode($formulario["elementos"], true) : [];
		$datos_guardados = $this->buscador_model->guardar_infoOrden($formulario, $elementos);//guarda datos en bd del proyecto
		$articulos_mo = json_decode($this->input->post('artmo'));

		if($datos_guardados){
			//recopilando los post
			$datar['Empresa'] = $this->input->post('empresa_cliente');
			$datar['Mov'] = 'Servicio';
			$datar['Concepto'] = $this->input->post('concepto_cliente'); // de una tabla servicio
			$datar['Moneda'] = $this->input->post('moneda_cliente');
			$datar['TipoCambio'] = 1;
			$datar['usuario'] = 'SOPDESA';
			$datar['Estatus'] = 'SINAFECTAR';
			$datar['Comentarios'] =  $this->input->post('comentcliente');
			$datar['Observaciones'] =  $this->input->post('observaciones_cliente');
			$datar['Directo'] = 1;
			$datar['Prioridad'] = "Normal";
			$datar['RenglonID'] = 1;
			$datar['Cliente'] =  $this->input->post('cliente_cliente');
			$datar['Agente'] = $this->input->post('cve_cliente');
			$datar['Condicion'] = $this->input->post('condicion_cliente');
			$datar['Importe'] = $this->input->post('importe_cliente');
			$datar['Impuestos'] = '';
			$datar['ServicioArticulo'] = $this->input->post('art_cliente');
			$datar['Modelo'] = $this->input->post('anio_cliente');
			$datar['ServicioSerie'] = $this->input->post('vin_cliente');
			$datar['Almacen'] = $this->input->post('almacen_cliente');
			$datar['Sucursal'] = $this->input->post('sucursal_cliente');
			$xtime = strtotime($this->input->post('Fecha_Emision_cliente'));
			$datar['FechaEmision'] =  date('d-m-Y',$xtime);
			$datar['UltimoCambio'] = date('d-m-Y'); //date('d-m-Y G:i:s');
			$datar['OrigenID'] = $this->input->post('id_servicio'); // si viene de una cita es el movid de la cita
			$datar['Referencia'] ='';
			$datar['ServicioTipoOrden'] = $this->input->post('tipoorden_cliente'); //tabla serviciotipoorden
			$datar['ServicioPlacas'] = $this->input->post('placas_cliente');
			$datar['ServicioTipoOperacion'] = $this->input->post('tipooperacion_cliente'); //servicio tipo operacion 
			$datar['ServicioKms'] = $this->input->post('kms_cliente');
			$datar['ListaPreciosEsp'] = $this->input->post('tipoprecio_cliente'); // tabla ListaPrecios
			$datar['UEN'] = $this->input->post('tipouen_cliente');
			$xtime2 = strtotime($this->input->post('fecha_promesa_cliente'));
			$datar['fecharequerida'] = date('d-m-Y',$xtime2);
			$datar['paqueteid'] = $this->input->post('paquete_cliente');
			$datar['paqueteFrec'] = $this->input->post('servicios_frec');
			$datar['HoraRequerida'] =$this->input->post('horapromesa_cliente');
			$datar['HoraPromesa'] =$this->input->post('hora_promesa_cliente2');
			$datar['Total'] = $this->input->post('totaaal');
			$datar['iva'] = $this->input->post('iva');
			$datar["id_orden"] = $this->input->post("id_orden");
			$datar["torrecolor"] = $this->input->post('tipotorre');
			$datar["torrenum"]   = $this->input->post('torrenumero');
			$datar['ZonaImpuesto'] = $this->input->post('ZonaImpuesto_select');
			$datar['color_cliente'] = $this->input->post('color_cliente');

			//mano de obras y datos
			$create=$this->buscador_model->guardar_orden_na($datar, $elementos);
			if($create){
				$data = array('success' =>1, 'data' => ('Orden de Servicio creada satisfactoriamente.'));
			}else{
				$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
			}		
		}else{
			$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
		}

		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
		/*$data['contenido'] = $this->load->view("orden_servicio_detalle",'',true);
		$data['scripts'] = $this->load->view("scripts",'',true);
	    $this->load->view("base", $data);*/
	}

	public function enviar_presupuesto_mail()
	{
		$datos = $this->input->post();
		$data = $this->buscador_model->datos_presupuesto($datos);
		$url = base_url()."Servicio/email_presupuesto/".$datos['id'];
		$data['datos_cliente'] = $data['usuario'];
		$data["datos_suc"] = $data["datos_sucursal"];
		$data["bandera_correo"] = 1;
		$cliente = $data['usuario']['nombre_cliente']." ".$data['usuario']['ap_cliente']." ".$data['usuario']['am_cliente'];
		ini_set('memory_limit', '1024M');
		// cargando las librerias para envío de correo.
		$html = $this->load->view('formatos/formato_presupuesto', $data, true);
        // $this->load->helper('dompdf');
        // $pdf = pdf_create($html, '', false);

		// no se utliza pdf_create por que vuelve a enviar importar la libreria y causa conflicto
        $dompdf = new DOMPDF();
    	$dompdf->load_html($html);
    	$dompdf->render();
    	$pdf = $dompdf->output();
    
        $correo_asesor = $this->session->userdata["logged_in"]["correo"];
        // $correo_asesor = "lorozco@intelisis.com";

        // enviar correo       
       	$this->load->library("PhpMailerLib");
		$mail = $this->phpmailerlib->load();
			try {
			    //Server settings
			    // $mail->SMTPDebug = 2;// Enable verbose debug output
			    // $mail->ErrorInfo;
			    // $mail->isSMTP();// Set mailer to use SMTP
			    // $mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
			    // $mail->SMTPAuth = true;// Enable SMTP authentication
			    // $mail->Username = 'fameserviceexcellence@gmail.com'; // SMTP username
			    // $mail->Password = '9F8a*37x';  // SMTP password
			    // $mail->SMTPSecure = 'ssl';   // Enable TLS encryption, `ssl` also accepted
			    // $mail->Port = 465;// TCP port to connect to

			    //Server settings
			    //$mail->SMTPDebug = 2;// Enable verbose debug output
			    //$mail->ErrorInfo;
			    $mail->isSMTP();// Set mailer to use SMTP
			    $mail->Host = $this->mail_host;// Specify main and backup SMTP servers
			    $mail->SMTPAuth = $this->mail_smtpAuth;// Enable SMTP authentication
			    $mail->Username = $this->mail_username; // SMTP username
			    $mail->Password = $this->mail_password;  // SMTP password
			    $mail->SMTPSecure = $this->mail_smtpSecure;   // Enable TLS encryption, `ssl` also accepted
			    $mail->Port = $this->mail_port;// TCP port to connect to
				
				//se agrega a variable para se utilizado el nombre de correo del remitente config en bd
				$mail_username_env = $this->mail_username;
			    
			    //Recipients
			     $mail->SetFrom($mail_username_env, 'Service Excellence');  	//Quien envía el correo
			    //$mail->addAddress($data['usuario']['email_cliente']);// Name is optional
			    // $mail->AddReplyTo($correo_asesor,'Service Excellence');  //A quien debe ir dirigida la respuesta
			    $mail->addCC($correo_asesor);											//Con copia a
			    $mail->addBCC('fsanjuan@intelisis.com');	 //Con copia oculta a
			    
			    //Attachments
			    $mail->AddStringAttachment($pdf, 'Presupuesto.pdf');                 // Agregar archivo adjunto
			    $datos["comentario"] = "Hello there";
			    //Content
			                                     // Set email format to HTML
			    $mail->CharSet = 'UTF-8';
			    $mail->Subject = 'Presupuesto';
			    $mail->Body      = "<html><body><p>Estimado ".$cliente.": 
				En base a la inspección realizada a su unidad hemos generado presupuestos sugeridos, con la finalidad de seguir manteniendo su unidad en optimo estado,para ello deberá acceder a la siguiente liga: </p>
				<p><a href='".$url."' target='_blank' >REVISAR PRESUPUESTO</a></p>
				<p>Sobre el cual podrá autorizarlos o bien rechazarlos <br>

				Agradecemos su preferencia! </p></html></body>";
			    $mail->isHTML(true); 
				$enviar = $mail->send();
				
			    $data = array('success' => 1, 'data' => ('presupuesto enviada.'));
			    //$this->eliminar_archivoTemp($formato["ruta"]);

			    if($enviar)
			    {
			    	$envio = true;
			    }else 
			    {
			    	$envio = false;
			    	var_dump($mail->ErrorInfo);
			    }
			} catch (Exception $e) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;

			    $envio = false;
			}
       
        echo json_encode($envio);	
	}
	public function envia_verificacion_mail()
	{
		$datos = $this->input->post();
		
		$data = $this->buscador_model->datos_verificacion($datos);
		$url = base_url()."index.php/Servicio/email_verificacion/".$datos['id'];
		$data['datos_cliente'] = $data['usuario'];
		$data['datos_refacciones'] = $data['user'];
		$data['datos_tecnico'] = $data['userTecnico'];
		$data["datos_suc"] = $data["datos_sucursal"];
		$data['movID'] = $data["usuario"];
		$data['cve_articulo'] = $data["detalle"];
		$refacciones = $data['user']['nombre']." ".$data['user']['apellidos']." ";
		$tecnico = $data['userTecnico']['nombre']." ".$data['userTecnico']['apellidos']." ".$data['userTecnico']['actualizado']." ";
		$data["datos_tecnico"]["tecnico"] = $tecnico;
		$data["datos_tecnico"]["actualizado"] =date('Y-m-d');
		$data["datos_tecnico"]["autorizado"] = 1;
		$data["bandera_correo"] = 1;
		$correo_refacciones=$data['user']['correo_refacciones'];
		$data["datos_refacciones"]["refacciones"] = $correo_refacciones;
		$correo_tecnico=$data['userTecnico']['correo_tecnico'];
		$data["datos_tecnico"]["tecnico"] = $correo_tecnico;
		ini_set('memory_limit', '1024M');
		// cargando las librerias para envío de correo.
		$html = $this->load->view('formatos/formato_verificacion_refacciones', $data, true); 
        // $this->load->helper('dompdf');
        // $pdf = pdf_create($html, '', false);

		// no se utliza pdf_create por que vuelve a enviar importar la libreria y causa conflicto
        $dompdf = new DOMPDF();
    	$dompdf->load_html($html);
    	$dompdf->render();
    	$pdf = $dompdf->output();
    
        #$correo_tecnico = $this->session->userdata["logged_in"]["correo"];
        // $correo_asesor = "lorozco@intelisis.com";

        // enviar correo       
       	$this->load->library("PhpMailerLib");
		$mail = $this->phpmailerlib->load();
			try {
			    //Server settings
			    // $mail->SMTPDebug = 2;// Enable verbose debug output
			    // $mail->ErrorInfo;
			    // $mail->isSMTP();// Set mailer to use SMTP
			    // $mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
			    // $mail->SMTPAuth = true;// Enable SMTP authentication
			    // $mail->Username = 'fameserviceexcellence@gmail.com'; // SMTP username
			    // $mail->Password = '9F8a*37x';  // SMTP password
			    // $mail->SMTPSecure = 'ssl';   // Enable TLS encryption, `ssl` also accepted
			    // $mail->Port = 465;// TCP port to connect to

			    //Server settings
			    //$mail->SMTPDebug = 2;// Enable verbose debug output
			    //$mail->ErrorInfo;
			    $mail->isSMTP();// Set mailer to use SMTP
			    $mail->Host = $this->mail_host;// Specify main and backup SMTP servers
			    $mail->SMTPAuth = $this->mail_smtpAuth;// Enable SMTP authentication
			    $mail->Username = $this->mail_username; // SMTP username
			    $mail->Password = $this->mail_password;  // SMTP password
			    $mail->SMTPSecure = $this->mail_smtpSecure;   // Enable TLS encryption, `ssl` also accepted
			    $mail->Port = $this->mail_port;// TCP port to connect to
				
				//se agrega a variable para se utilizado el nombre de correo del remitente config en bd
				$mail_username_env = $this->mail_username;
			    
			    //Recipients
			     $mail->SetFrom($mail_username_env, 'Service Excellence');  	//Quien envía el correo
			    //$mail->addAddress($data['usuario']['email_cliente']);// Name is optional
			    // $mail->AddReplyTo($correo_asesor,'Service Excellence');  //A quien debe ir dirigida la respuesta
			    $mail->addCC($correo_refacciones);											//Con copia a
			    $mail->addBCC('mlopez@intelisis.com');	 //Con copia oculta a
			    $mail->addCC($correo_tecnico);											//Con copia a
			   $mail->addBCC('tpena@intelisis.com');	 //Con copia oculta a
			    
			    //Attachments
			    $mail->AddStringAttachment($pdf, 'Verificación.pdf');                 // Agregar archivo adjunto
			    $datos["comentarios"] = "Hello there";
			    //Content
			                                     // Set email format to HTML
			    $mail->CharSet = 'UTF-8';
			    $mail->Subject = 'Verificación';
			    $mail->Body      = "<html><body><p>Estimado ".$refacciones.":
				Requiero que me haga una verificacion de piezas en exitencia que necesito para efectuar la reparación de la orden </p>
				<p><a href='".$url."' target='_blank' >REVISAR VERIFICACIÓN</a></p>
				<p>Sin más por el momento, saludos cordiales. <br>

				Gracias! </p></html></body>";
			    $mail->isHTML(true); 
				$envia = $mail->send();
				
			    $data = array('success' => 1, 'data' => ('Verificación enviada.'));
			    //$this->eliminar_archivoTemp($formato["ruta"]);
				//$enviar = false;
			    if($envia)
			    {
			    	$envio = true;
			    	$this->db->where('id_presupuesto', $datos['id']);
			    	$this->db->update('verificacion_refacciones', ['autorizado' => 1]);
			    }else 
			    {
			    	$envio = false;
			    	var_dump($mail->ErrorInfo);
			    }
			} catch (Exception $e) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;

			    $envio = false;
			}
       
        echo json_encode($envio);	
	}

	function pkts_detalle(){
		$idp = $this->input->post('idp');

		$info = $this->buscador_model->paquete_detalle($idp);

		if($info){
			echo json_encode($info);

		}else{
			$data = array('success' =>0, 'data' => ('Los articulos del paquete no han sido dados de alta.'));
		}
	}

	function create_date(){

	}	

	function update_table_Asesores(){
		$this->load->model('buscador_model');
		$create=$this->buscador_model->update_table_Asesores();
		//var_dump($create);
		//$data = json_encode($data);
		//$data=array('response'=>$data);
		//$this->load->view('ajax',$data);

	}

	function detalle_cita(){
		$id= $this->input->post('id');
		$this->load->model('buscador_model');
		$info = $this->buscador_model->detalle($id);
		if($info){
			echo json_encode($info);

		}else{
			$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
		}
	}

	function cita_de_servicio($uno, $dos){
		//$temp = $this->buscador_model->traer_datos($datos);
		$clienteid = array('uno' => $uno, 'dos' =>$dos );
		//var_dump($clienteid);die;
		$data['contenido'] = $this->load->view("cita_servicio",$clienteid,true);
		$data['scripts'] = $this->load->view("scripts",'',true);
        $this->load->view("base", $data);
	}

	function orden_de_servicio($vta, $cliente = 0, $vin = 0){
		// echo $cliente;die;
		// si se recibe el vin en base64 es por que viene con punto 
		if (base64_decode($vin, true)) {
			$decoded64Vin = base64_decode($vin);
		} else {
			$decoded64Vin = $vin;
		}
		
		$logged_in = $this->session->userdata("logged_in");
		if(!empty($logged_in))	{
			// var_dump($vta);die();
			
			//$firma_cliente = ['firma_formato_raiz_componente' =>"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAakAAADSCAYAAADwvj/tAAAAAXNSR0IArs4c6QAAB/JJREFUeF7t1UENAAAMArHh3/Rs3KNTQMoSdo4AAQIECEQFFs0lFgECBAgQOCPlCQgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAASPlBwgQIEAgK2CkstUIRoAAAQJGyg8QIECAQFbASGWrEYwAAQIEjJQfIECAAIGsgJHKViMYAQIECBgpP0CAAAECWQEjla1GMAIECBAwUn6AAAECBLICRipbjWAECBAgYKT8AAECBAhkBYxUthrBCBAgQMBI+QECBAgQyAoYqWw1ghEgQICAkfIDBAgQIJAVMFLZagQjQIAAgQee7QDT4w9urAAAAABJRU5ErkJggg=="]; -->
			$idVenta = array('vta' => $vta ,'cliente' =>$cliente, 'vin' => $decoded64Vin);
			// var_dump($idVenta);die;
			$data['contenido'] = $this->load->view("orden_servicio",$idVenta,true);
			$data['navbar'] = $this->load->view('navbar','', true);
			$data['scripts'] = $this->load->view("scripts",'',true);
	        $this->load->view("base", $data);
        }else{
			$data['contenido'] = $this->load->view("login",'',true);
			$data['scripts'] = $this->load->view('scripts','',true);
			$data['navbar'] = $this->load->view('navbar2','', true);
	        $this->load->view("base", $data);
		}
	}

	function paquete_por_vin(){
		$vin = $this->input->post('vin');
		$paquetes = $this->buscador_model->datos_paquetes_vin($vin);

	}
	function cita_de_servicio_vin($vin){

	}
	function detalle_por_vin(){
		$id = $this->input->post('vin');

	}
	function cita_de_servicio_cliente(){
		$cliente = $this->input->post('cliente');
		$datos   = $this->buscador_model->datos_para_cita($cliente);
		echo json_encode($datos);
	}
	function pkts_por_vin(){
		$vin = $this->input->post('vin');
		$data = $this->buscador_model->pkt_por_vin($vin);
		echo json_encode($data);
	}

	function pkts_por_vin_frec(){
		$vin = $this->input->post('vin');
		$data = $this->buscador_model->pkt_frec_por_vin($vin);
		echo json_encode($data);
	}

	function enviar_cita_mail(){
		
	}

	function inspeccion_vehiculo(){
		$data['navbar'] = $this->load->view('navbar','', true);
		$data['scripts'] = $this->load->view("scripts",'',true);
		$data['contenido'] = $this->load->view("vehihulo_inspeccion",'',true);
        $this->load->view("base", $data);
	}
	function guardar_inspeccion($id_orden = null){
		$logged_in = $this->session->userdata("logged_in");
		//var_dump($logged_in);
		//recopilando los post
		//cajuela
		$dato["id_orden"] = $id_orden;

		if($this->input->post('herramienta') == "on"){
			$dato['cajuela_herramienta'] = 'herramienta';
		}else{
			$dato['cajuela_herramienta'] = 'n/a';
		}
		if($this->input->post('gatollave') == "on"){
			$dato['cajuela_gato'] = "Gato/Llave";
		}else{
			$dato['cajuela_gato'] = "n/a";
		}
		if($this->input->post('reflejantes')== "on"){
			$dato['cajuela_reflejante'] = "Reflejantes";
		}else{
			$dato['cajuela_reflejante'] = "n/a";
		}
		if( $this->input->post('cables') == "on"){
			$dato['cajuela_cables'] = "Cables";
		}else{
			$dato['cajuela_cables'] = "n/a";
		}
		if($this->input->post('extintor') =='on'){
			$dato['cajuela_extintor'] = "Extintor";
		}else{
			$dato['cajuela_extintor'] = "n/a";
		}	
		if($this->input->post('llantarefaccion') == "on"){
			$dato['cajuela_llanta'] = "Llanta de Refaccion";
		}else{
			$dato['cajuela_llanta'] = "n/a";
		}
		//Exteriores
		if($this->input->post('taponesrueda') == "on"){
			$dato['exterior_taponesrueda'] = "Tapones Ruedas" ;
		}else{
			$dato['exterior_taponesrueda'] = "n/a" ;
		}
		if($this->input->post('gomalimpiador') == "on"){
			$dato['exterior_gomaslimpiador'] = "Gomas de Limpiadores";
		}else{
			$dato['exterior_gomaslimpiador'] = "n/a";
		}
		if($this->input->post('antna') == "on"){
			$dato['exterior_antena'] = "Antena";
		}else{
			$dato['exterior_antena'] = "n/a";
		}
		if($this->input->post('tapagas') == "on"){
			$dato['exterior_tapagasolina'] = "Tapon de Gasolina" ;
		}else{
			$dato['exterior_tapagasolina'] = "n/a" ;
		}
		//Aplica para FAME
		if($this->input->post('molduras') == "on"){
			$dato['exterior_molduras'] = "Molduras" ;
		}else{
			$dato['exterior_molduras'] = "n/a" ;
		}
		//Interiores(profecoFame)
		if($this->input->post('tableroVal') == "si"){
			$dato['interior_tablero'] = "tablero_si" ;
		}else{
			$dato['interior_tablero'] = "tablero_no" ;
		}
		if($this->input->post('retrovisorVal') == "si"){
			$dato['interior_retrovisor'] = "retrovisor_si" ;
		}else{
			$dato['interior_retrovisor'] = "retrovisor_no" ;
		}
		if($this->input->post('ceniceroVal') == "si"){
			$dato['interior_cenicero'] = "cenicero_si" ;
		}else{
			$dato['interior_cenicero'] = "cenicero_no" ;
		}
		if($this->input->post('cinturonVal') == "si"){
			$dato['interior_cinturon'] = "cinturon_si" ;
		}else{
			$dato['interior_cinturon'] = "cinturon_no" ;
		}
		if($this->input->post('manijasVal') == "si"){
			$dato['interior_manijas'] = "manijas_si" ;
		}else{
			$dato['interior_manijas'] = "manijas_no" ;
		}
		//Condiciones generales
		switch ($this->input->post("amecanicos")) 
		{
			case "amRegulares":
				$dato["aspectos_mecanicos"] = "amRegulares";
			break;
			default:
				$dato["aspectos_mecanicos"] = "amNoE";
			break;
		}
		switch ($this->input->post("acarroceria")) 
		{
			case "acRegulares":
				$dato["aspectos_carroceria"] = "acRegulares";
			break;
			case "acRayones":
				$dato["aspectos_carroceria"] = "acRayones";
			break;
			default:
				$dato["aspectos_carroceria"] = "acMalEdo";
			break;
		}
		//*Aplica para FAME
		//Documentación
		if( $this->input->post('polizamanual') == "on"){
			$dato['doc_polmanual'] = 'Poliza/Manual';
		}else{
			$dato['doc_polmanual'] = 'n/a';
		}
		if($this->input->post('segrines') == "on"){
			$dato['doc_rines'] = "Seguro de Rines";
		}else{
			$dato['doc_rines'] = "n/a";
		}
		if($this->input->post('certverific') == "on"){
			$dato['doc_verificacion'] = "Verificacion";
		}else{
			$dato['doc_verificacion'] = "n/a";
		}
		if($this->input->post('tarjcirc') == "on"){
			$dato['doc_circulacion'] = "Tarjeta de Circulacion" ;
		}else{
			$dato['doc_circulacion'] = "n/a" ;
		}
		//Gasolina
		$dato['gasolina'] = $this->input->post('insp_gasolina');
		//articulos personales
		if( $this->input->post("dejaarticulos") == "on" ){
			$dato["dejaArticulos"] = 'Si';
			$dato["Articulos"] = $this->input->post("articulos_personales");
 		}elseif($this->input->post("nodejaarticulos") == "on" ){
 			$dato["dejaArticulos"] = 'no';
 			$dato["Articulos"] = 'n/a';
		}else{
			$dato["Articulos"] = "No se reviso";
		}
		//niveles fluidos
		if( $this->input->post('aceiteMotor') == "on"){
			$dato['aceiteMotor'] ="Bien";
		}else{
			$dato['aceiteMotor'] ="Llenar";
		}
		if( $this->input->post('direccionHidraulica')== "on"){
			$dato['direccionHidraulica']  ="Bien";
		}else{
			$dato['direccionHidraulica'] = "Llenar";
		}
		if( $this->input->post('transmision') == "on"){
			$dato['liq_transmision'] = "Bien";
		}else{
			$dato['liq_transmision'] = "Llenar";
		}
		if( $this->input->post('liq_limpiaparabrisas') == "on"){
			$dato['liq_limpiaparabrisas'] ="Bien";
		}else{
			$dato['liq_limpiaparabrisas'] ="Llenar";
		}
		if( $this->input->post('liq_frenos') == "on"){
			$dato['liq_frenos'] = "Bien";
		}else{
			$dato['liq_frenos'] = "Llenar";
		}
		if( $this->input->post('liq_refrigerante') == "on"){
			$dato['liq_refrigerante'] ="Bien";
		}else{
			$dato['liq_refrigerante'] ="Llenar";
		}

		if($this->input->post('plumasok') == "si"){
			$dato['Plumas'] = "Buen Estado";
		}elseif ($this->input->post('plumasok') == "no") {
			$dato['Plumas'] = "Requiere cambiar";
		}else{
			$dato['Plumas'] = "No se reviso";
		}
		//llanta
		if($this->input->post('llantabien') == "on"){
			$dato['Llantas'] = "Bien";
		}elseif($this->input->post('llantamedio') == "on"){
			$dato['Llantas'] = "Requiere Atención";

		}elseif($this->input->post('llantamal') == "on"){
			$dato['Llantas'] = "Requiere Reparación";
		}else{
			$dato['Llantas'] = "No se reviso";
		}
		//bateria
		if($this->input->post('bateriabien') == "bateriabien"){
			$dato['Bateria'] = 'Bien';
		}elseif($this->input->post('bateriabien') == "bateriamedio"){
			$dato['Bateria'] = "Requiere Atencion";
		}elseif($this->input->post('bateriabien') == "bateriamal"){
			$dato['Bateria'] = "Requiere Reparacion";
		}else{
			$dato['Bateria'] = ' No se reviso';
		}
		//balatas
		if( $this->input->post('bienbalata') == "on"){
			$dato['Balatas'] = "Bien";
		}elseif($this->input->post('mediobalata') == "on"){
			$dato['Balatas'] = "Requiere Atención";
		}elseif( $this->input->post('malbalata') == "on"){
			$dato['Balatas'] = "Requiere Reparación";
		}else{
			$dato['Balatas'] = "No se reviso";
		}
		//tambores
		if($this->input->post('tamboresbien') == "on"){
			$dato["Tambores"] = "Bien" ;
		}elseif($this->input->post('tamboresmedio') == "on"){
			$dato["Tambores"] = "Requiere Atención";
		}elseif( $this->input->post('tamboresmal') == "on"){
			$dato["Tambores"] = "Requiere Reparación";
		}else{
			$dato["Tambores"] = "No se reviso" ;	
		}
		//discos
		if( $this->input->post('discosbien') == "on"){
			$dato["discos"] = "Bien" ;
		}elseif( $this->input->post('discosmedio') == "on"){
			$dato["discos"] = "Requiere Atención";

		}elseif( $this->input->post('discosmal') == "on"){
			$dato["discos"] = "Requiere Reparación";

		}else{
			$dato["discos"] =  "No se reviso";			
		}
		//adicionales
		//claxo
		if($this->input->post('claxonok') == 'si'){
			$dato["claxon"] =  "SI";	
		}elseif ( $this->input->post('claxonok') == 'no') {
			$dato["claxon"] =  "NO";	
		}elseif ($this->input->post('claxonok') == 'nc') {
			$dato["claxon"] =  "No cuenta";	
		}else{
			$dato["claxon"] =  "No se reviso";	
		}
		//luces
		if($this->input->post('lucesok') == 'si'){
			$dato["lucesok"] =  "SI";	
		}elseif ( $this->input->post('lucesok') == 'no') {
			$dato["lucesok"] =  "NO";	
		}elseif ($this->input->post('lucesok') == 'nc') {
			$dato["lucesok"] =  "No cuenta";	
		}else{
			$dato["lucesok"] =  "No se reviso";	
		}
		//radio
		if($this->input->post('radiook') == 'si'){
			$dato["radio"] =  "SI";	
		}elseif ( $this->input->post('radiook') == 'no') {
			$dato["radio"] =  "NO";	
		}elseif ($this->input->post('radiook') == 'nc') {
			$dato["radio"] =  "No cuenta";	
		}else{
			$dato["radio"] =  "No se reviso";	
		}
		//radio
		if($this->input->post('pantallasi') == 'si'){
			$dato["pantalla"] =  "SI";	
		}elseif ( $this->input->post('pantallasi') == 'no') {
			$dato["pantalla"] =  "NO";	
		}elseif ($this->input->post('pantallasi') == 'nc') {
			$dato["pantalla"] =  "No cuenta";	
		}else{
			$dato["pantalla"] =  "No se reviso";	
		}
		//A/c
		if($this->input->post('acsi') == 'si'){
			$dato["ac"] =  "SI";	
		}elseif ( $this->input->post('acsi') == 'no') {
			$dato["ac"] =  "NO";	
		}elseif ($this->input->post('acsi') == 'nc') {
			$dato["ac"] =  "No cuenta";	
		}else{
			$dato["ac"] =  "No se reviso";	
		}
		//encendedor
		if($this->input->post('encendedorsi') == 'si'){
			$dato["encendedor"] =  "SI";	
		}elseif ( $this->input->post('encendedorsi') == 'no') {
			$dato["encendedor"] =  "NO";	
		}elseif ($this->input->post('encendedorsi') == 'nc') {
			$dato["encendedor"] =  "No cuenta";	
		}else{
			$dato["encendedor"] =  "No se reviso";	
		}
		//vidrios
		if($this->input->post('vidriossi') == 'si'){
			$dato["vidrios"] =  "SI";	
		}elseif ( $this->input->post('vidriossi') == 'no') {
			$dato["vidrios"] =  "NO";	
		}elseif ($this->input->post('vidriossi') == 'nc') {
			$dato["vidrios"] =  "No cuenta";	
		}else{
			$dato["vidrios"] =  "No se reviso";	
		}
		//espejos
		if($this->input->post('espejossi') == 'si'){
			$dato["espejos"] =  "SI";	
		}elseif ( $this->input->post('espejossi') == 'no') {
			$dato["espejos"] =  "NO";	
		}elseif ($this->input->post('espejossi') == 'nc') {
			$dato["espejos"] =  "No cuenta";	
		}else{
			$dato["espejos"] =  "No se reviso";	
		}
		//seguros electronicos
		if($this->input->post('segurosesi') == 'si'){
			$dato["seguros_ele"] =  "SI";	
		}elseif ( $this->input->post('segurosesi') == 'no') {
			$dato["seguros_ele"] =  "NO";	
		}elseif ($this->input->post('segurosesi') == 'nc') {
			$dato["seguros_ele"] =  "No cuenta";	
		}else{
			$dato["seguros_ele"] =  "No se reviso";	
		}
		//CO
		if($this->input->post('cosi') == 'si'){
			$dato["co"] =  "SI";	
		}elseif ( $this->input->post('cosi') == 'no') {
			$dato["co"] =  "NO";	
		}elseif ($this->input->post('cosi') == 'nc') {
			$dato["co"] =  "No cuenta";	
		}else{
			$dato["co"] =  "No se reviso";	
		}
		//asientos y vestiduras
		if($this->input->post('asientosvsi') == 'si'){
			$dato["asientosyvesti"] =  "SI";	
		}elseif ( $this->input->post('asientosvsi') == 'no') {
			$dato["asientosyvesti"] =  "NO";	
		}elseif ($this->input->post('asientosvsi') == 'nc') {
			$dato["asientosyvesti"] =  "No cuenta";	
		}else{
			$dato["asientosyvesti"] =  "No se reviso";	
		}
		//tapetes
		if($this->input->post('tapetessi') == 'si'){
			$dato["tapetes"] =  "SI";	
		}elseif ( $this->input->post('tapetessi') == 'no') {
			$dato["tapetes"] =  "NO";	
		}elseif ($this->input->post('tapetessi') == 'nc') {
			$dato["tapetes"] =  "No cuenta";	
		}else{
			$dato["tapetes"] =  "No se reviso";	
		}

		$dato["img_inspeccion"] = $this->input->post("img_insp");

		$dato["corriente_fabrica"] = $this->input->post("corriente_fabrica");
		$dato["corriente_real"] = $this->input->post("corriente_real"); 
		$dato["nivel_carga"] = $this->input->post("nivel_carga");  

		//componentes 
		if ($this->input->post("lucesydemasbien") == "si") {
			$dato["luces"] = "Bien";
		}else if ($this->input->post("lucesydemasbien") == "no") {
			$dato["luces"] = "Requiere Reparacion";			
		}else{
			$dato["luces"] = "No se reviso";
		}
		if ($this->input->post("parabrisasbien") == "si") {
			$dato["parabrisa"] = "Bien";
		}else if ($this->input->post("parabrisasbien") == "no") {
			$dato["parabrisa"] = "Requiere Reparacion";			
		}else{
			$dato["parabrisa"] = "No se reviso";
		}

		//elementos faltantes
		$dato["perdida_fluidos"] = ($this->input->post("perdida_fluid")) ? $this->input->post("perdida_fluid") : "no";
		$dato["nivel_fluidos_cambiado"] = ($this->input->post("nivel_fl_cambiado")) ? $this->input->post("nivel_fl_cambiado") : "no";
		$dato["pruebaParabrisas"] = ($this->input->post("prueba_limp")) ? $this->input->post("prueba_limp") : "no";
		$dato["plumaslimp_cambiado"] = ($this->input->post("plumaslimp_cambiado")) ? $this->input->post("plumaslimp_cambiado") : "no";
		$dato["bateria_cambiado"] = ($this->input->post("bateria_cambiado")) ? $this->input->post("bateria_cambiado") : "no";
		$dato["sistemas1_cambiado"] = ($this->input->post("sistemas1_cambiado")) ? $this->input->post("sistemas1_cambiado") : "no";
		$dato["sistemas2_cambiado"] = ($this->input->post("sistemas2_cambiado")) ? $this->input->post("sistemas2_cambiado") : "no";
		$dato["ext_garantia"] = ($this->input->post("ext_garantia")) ? $this->input->post("ext_garantia") : "no";
		$dato["existen_danios"] = ($this->input->post("existen_danios") == "on") ? 1 : 0;
		//tabla daños
		$dato["dan_costDerecho"] = ($this->input->post("dan_costDerecho") == "on") ? 1 : 0;
		$dato["dan_parteDel"] = ($this->input->post("dan_parteDel") == "on") ? 1 : 0;
		$dato["dan_intAsAlf"] = ($this->input->post("dan_intAsAlf") == "on") ? 1 : 0;
		$dato["dan_costIzq"] = ($this->input->post("dan_costIzq") == "on") ? 1 : 0;
		$dato["dan_parteTras"] = ($this->input->post("dan_parteTras") == "on") ? 1 : 0;
		$dato["dan_cristFaros"] = ($this->input->post("dan_cristFaros") == "on") ? 1 : 0;
		//inferior step2
		//sistema escape
		if($this->input->post('inf_sistEsc') == 'bien'){
			$dato["inf_sistEsc"] =  "bien";	
		}elseif ( $this->input->post('inf_sistEsc') == 'mal') {
			$dato["inf_sistEsc"] =  "mal";	
		}elseif ($this->input->post('inf_sistEsc') == 'fuga') {
			$dato["inf_sistEsc"] =  "fuga";
		}else{
			$dato["inf_sistEsc"] =  "No se reviso";	
		}
		//amortiguadores
		if($this->input->post('inf_amort') == 'bien'){
			$dato["inf_amort"] =  "bien";	
		}elseif ( $this->input->post('inf_amort') == 'mal') {
			$dato["inf_amort"] =  "mal";	
		}elseif ($this->input->post('inf_amort') == 'fuga') {
			$dato["inf_amort"] =  "fuga";
		}else{
			$dato["inf_amort"] =  "No se reviso";	
		}
		//tuberias
		if($this->input->post('inf_tuberias') == 'bien'){
			$dato["inf_tuberias"] =  "bien";	
		}elseif ( $this->input->post('inf_tuberias') == 'mal') {
			$dato["inf_tuberias"] =  "mal";	
		}elseif ($this->input->post('inf_tuberias') == 'fuga') {
			$dato["inf_tuberias"] =  "fuga";
		}else{
			$dato["inf_tuberias"] =  "No se reviso";	
		}
		//transeje/transmision
		if($this->input->post('inf_transeje_transm') == 'bien'){
			$dato["inf_transeje_transm"] =  "bien";	
		}elseif ( $this->input->post('inf_transeje_transm') == 'mal') {
			$dato["inf_transeje_transm"] =  "mal";	
		}elseif ($this->input->post('inf_transeje_transm') == 'fuga') {
			$dato["inf_transeje_transm"] =  "fuga";
		}else{
			$dato["inf_transeje_transm"] =  "No se reviso";	
		}
		//sistema de direccion
		if($this->input->post('inf_sistDir') == 'bien'){
			$dato["inf_sistDir"] =  "bien";	
		}elseif ( $this->input->post('inf_sistDir') == 'mal') {
			$dato["inf_sistDir"] =  "mal";	
		}elseif ($this->input->post('inf_sistDir') == 'fuga') {
			$dato["inf_sistDir"] =  "fuga";
		}else{
			$dato["inf_sistDir"] =  "No se reviso";	
		}
		//chasis sucio
		if($this->input->post('inf_chasisSucio') == 'bien'){
			$dato["inf_chasisSucio"] =  "bien";	
		}elseif ( $this->input->post('inf_chasisSucio') == 'mal') {
			$dato["inf_chasisSucio"] =  "mal";	
		}elseif ($this->input->post('inf_chasisSucio') == 'fuga') {
			$dato["inf_chasisSucio"] =  "fuga";
		}else{
			$dato["inf_chasisSucio"] =  "No se reviso";	
		}
		//golpes especifico
		if($this->input->post('inf_golpesEspecif') == 'bien'){
			$dato["inf_golpesEspecif"] =  "bien";	
		}elseif ( $this->input->post('inf_golpesEspecif') == 'mal') {
			$dato["inf_golpesEspecif"] =  "mal";	
		}elseif ($this->input->post('inf_golpesEspecif') == 'fuga') {
			$dato["inf_golpesEspecif"] =  "fuga";
		}else{
			$dato["inf_golpesEspecif"] =  "No se reviso";	
		}
		//sistema de frenos
		//delantera derecha balata
		switch ($this->input->post("sfrenos_ddBalata")) 
		{
			case "bien":
				$dato["sfrenos_ddBalata"] = "bien";
			break;
			case "atencion":
				$dato["sfrenos_ddBalata"] = "atencion";
			break;
			case "reparacion":
				$dato["sfrenos_ddBalata"] = "reparacion";
			break;
			default:
				$dato["sfrenos_ddBalata"] = "no especificado";
			break;
		}
		//delantera derecha disco
		switch ($this->input->post("sfrenos_ddDisco")) 
		{
			case "bien":
				$dato["sfrenos_ddDisco"] = "bien";
			break;
			case "atencion":
				$dato["sfrenos_ddDisco"] = "atencion";
			break;
			case "reparacion":
				$dato["sfrenos_ddDisco"] = "reparacion";
			break;
			default:
				$dato["sfrenos_ddDisco"] = "no especificado";
			break;
		}
		//delantera derecha neumatico
		switch ($this->input->post("sfrenos_ddNeumat")) 
		{
			case "bien":
				$dato["sfrenos_ddNeumat"] = "bien";
			break;
			case "atencion":
				$dato["sfrenos_ddNeumat"] = "atencion";
			break;
			case "reparacion":
				$dato["sfrenos_ddNeumat"] = "reparacion";
			break;
			default:
				$dato["sfrenos_ddNeumat"] = "no especificado";
			break;
		}
		//delantera izquierda balata
		switch ($this->input->post("sfrenos_diBalata")) 
		{
			case "bien":
				$dato["sfrenos_diBalata"] = "bien";
			break;
			case "atencion":
				$dato["sfrenos_diBalata"] = "atencion";
			break;
			case "reparacion":
				$dato["sfrenos_diBalata"] = "reparacion";
			break;
			default:
				$dato["sfrenos_diBalata"] = "no especificado";
			break;
		}
		//delantera izquierda disco
		switch ($this->input->post("sfrenos_diDisco")) 
		{
			case "bien":
				$dato["sfrenos_diDisco"] = "bien";
			break;
			case "atencion":
				$dato["sfrenos_diDisco"] = "atencion";
			break;
			case "reparacion":
				$dato["sfrenos_diDisco"] = "reparacion";
			break;
			default:
				$dato["sfrenos_diDisco"] = "no especificado";
			break;
		}
		//delantera izquierda neumatico
		switch ($this->input->post("sfrenos_diNeumat")) 
		{
			case "bien":
				$dato["sfrenos_diNeumat"] = "bien";
			break;
			case "atencion":
				$dato["sfrenos_diNeumat"] = "atencion";
			break;
			case "reparacion":
				$dato["sfrenos_diNeumat"] = "reparacion";
			break;
			default:
				$dato["sfrenos_diNeumat"] = "no especificado";
			break;
		}
		//trasera derecha balata
		switch ($this->input->post("sfrenos_tdBalata")) 
		{
			case "bien":
				$dato["sfrenos_tdBalata"] = "bien";
			break;
			case "atencion":
				$dato["sfrenos_tdBalata"] = "atencion";
			break;
			case "reparacion":
				$dato["sfrenos_tdBalata"] = "reparacion";
			break;
			default:
				$dato["sfrenos_tdBalata"] = "no especificado";
			break;
		}
		//trasera derecha disco
		switch ($this->input->post("sfrenos_tdDisco")) 
		{
			case "bien":
				$dato["sfrenos_tdDisco"] = "bien";
			break;
			case "atencion":
				$dato["sfrenos_tdDisco"] = "atencion";
			break;
			case "reparacion":
				$dato["sfrenos_tdDisco"] = "reparacion";
			break;
			default:
				$dato["sfrenos_tdDisco"] = "no especificado";
			break;
		}
		//trasera derecha neumatico
		switch ($this->input->post("sfrenos_tdNeumat")) 
		{
			case "bien":
				$dato["sfrenos_tdNeumat"] = "bien";
			break;
			case "atencion":
				$dato["sfrenos_tdNeumat"] = "atencion";
			break;
			case "reparacion":
				$dato["sfrenos_tdNeumat"] = "reparacion";
			break;
			default:
				$dato["sfrenos_tdNeumat"] = "no especificado";
			break;
		}
		//trasera izquierda balata
		switch ($this->input->post("sfrenos_tiBalata")) 
		{
			case "bien":
				$dato["sfrenos_tiBalata"] = "bien";
			break;
			case "atencion":
				$dato["sfrenos_tiBalata"] = "atencion";
			break;
			case "reparacion":
				$dato["sfrenos_tiBalata"] = "reparacion";
			break;
			default:
				$dato["sfrenos_tiBalata"] = "no especificado";
			break;
		}
		//trasera izquierda disco
		switch ($this->input->post("sfrenos_tiDisco")) 
		{
			case "bien":
				$dato["sfrenos_tiDisco"] = "bien";
			break;
			case "atencion":
				$dato["sfrenos_tiDisco"] = "atencion";
			break;
			case "reparacion":
				$dato["sfrenos_tiDisco"] = "reparacion";
			break;
			default:
				$dato["sfrenos_tiDisco"] = "no especificado";
			break;
		}
		//trasera izquierda neumatico
		switch ($this->input->post("sfrenos_tiNeumat")) 
		{
			case "bien":
				$dato["sfrenos_tiNeumat"] = "bien";
			break;
			case "atencion":
				$dato["sfrenos_tiNeumat"] = "atencion";
			break;
			case "reparacion":
				$dato["sfrenos_tiNeumat"] = "reparacion";
			break;
			default:
				$dato["sfrenos_tiNeumat"] = "no especificado";
			break;
		}
		//refaccion neumatico
		switch ($this->input->post("sfrenos_refNeumat")) 
		{
			case "bien":
				$dato["sfrenos_refNeumat"] = "bien";
			break;
			case "atencion":
				$dato["sfrenos_refNeumat"] = "atencion";
			break;
			case "reparacion":
				$dato["sfrenos_refNeumat"] = "reparacion";
			break;
			default:
				$dato["sfrenos_refNeumat"] = "no especificado";
			break;
		}
		//apartados opcionales inferior y sistema de frenos
		if( $this->input->post('reqRev_inferior')== "on"){
			$dato['reqRev_inferior']  = 1;
		}else{
			$dato['reqRev_inferior'] = 0;
		}
		if( $this->input->post('reqRev_sistFrenos')== "on"){
			$dato['reqRev_sistFrenos']  = 1;
		}else{
			$dato['reqRev_sistFrenos'] = 0;
		}

		/*Datos del formato causa raíz componente para la voz del cliente*/
		$dato['autorizacion_voz']     = $this->input->post('autorizacion_voz') == "on" ? 1 : 0;
		$dato['articulos_personales'] = $this->input->post('articulos_personales[]') !== "" ?  $this->input->post('articulos_personales[]') : [];
		$dato['temperatura']          = $this->input->post('temperatura[]') !== "" ?  $this->input->post('temperatura[]') : [];
		$dato['humedad']              = $this->input->post('humedad[]') !== "" ?  $this->input->post('humedad[]') : [];
		$dato['viento']               = $this->input->post('viento[]') !== "" ?  $this->input->post('viento[]') : [];
		$dato['arranca']              = $this->input->post('arranca[]') !== "" ?  $this->input->post('arranca[]') : [];
		$dato['inicia']               = $this->input->post('inicia[]') !== "" ?  $this->input->post('inicia[]') : [];
		$dato['disminuye']            = $this->input->post('disminuye[]') !== "" ?  $this->input->post('disminuye[]') : [];
		$dato['vuelta_izq']           = $this->input->post('vuelta_izq[]') !== "" ?  $this->input->post('vuelta_izq[]') : [];
		$dato['vuelta_der']           = $this->input->post('vuelta_der[]') !== "" ?  $this->input->post('vuelta_der[]') : [];
		$dato['tope']                 = $this->input->post('tope[]') !== "" ?  $this->input->post('tope[]') : [];
		$dato['bache']                = $this->input->post('bache[]') !== "" ?  $this->input->post('bache[]') : [];
		$dato['cambia']               = $this->input->post('cambia[]') !== "" ?  $this->input->post('cambia[]') : [];
		$dato['movimiento']           = $this->input->post('movimiento[]') !== "" ?  $this->input->post('movimiento[]') : [];
		$dato['constantemente']       = $this->input->post('constantemente[]') !== "" ?  $this->input->post('constantemente[]') : [];
		$dato['esporadicamente']      = $this->input->post('esporadicamente[]') !== "" ?  $this->input->post('esporadicamente[]') : [];
		$dato['volante']              = $this->input->post('volante[]') !== "" ?  $this->input->post('volante[]') : [];
		$dato['cofre']                = $this->input->post('cofre[]') !== "" ?  $this->input->post('cofre[]') : [];
		$dato['asiento']              = $this->input->post('asiento[]') !== "" ?  $this->input->post('asiento[]') : [];
		$dato['cajuela_f']            = $this->input->post('cajuela_f[]') !== "" ?  $this->input->post('cajuela_f[]') : [];
		$dato['cristales']            = $this->input->post('cristales[]') !== "" ?  $this->input->post('cristales[]') : [];
		$dato['toldo']                = $this->input->post('toldo[]') !== "" ?  $this->input->post('toldo[]') : [];
		$dato['carroceria']           = $this->input->post('carroceria[]') !== "" ?  $this->input->post('carroceria[]') : [];
		$dato['dentro']               = $this->input->post('dentro[]') !== "" ?  $this->input->post('dentro[]') : [];
		$dato['fuera']                = $this->input->post('fuera[]') !== "" ?  $this->input->post('fuera[]') : [];
		$dato['frente']               = $this->input->post('frente[]') !== "" ?  $this->input->post('frente[]') : [];
		$dato['detras']               = $this->input->post('detras[]') !== "" ?  $this->input->post('detras[]') : [];
		$dato['velocidad']            = $this->input->post('velocidad[]') !== "" ?  $this->input->post('velocidad[]') : [];
		$dato['cambioTransmision']    = $this->input->post('cambioTransmision[]') !== "" ?  $this->input->post('cambioTransmision[]') : [];
		$dato['cambioTipo']           = $this->input->post('cambioTipo[]') !== "" ?  $this->input->post('cambioTipo[]') : [];
		$dato['rpm']                  = $this->input->post('rpm[]') !== "" ?  $this->input->post('rpm[]') : [];
		$dato['carga']                = $this->input->post('carga[]') !== "" ?  $this->input->post('carga[]') : [];
		$dato['pasajeros']            = $this->input->post('pasajeros[]') !== "" ?  $this->input->post('pasajeros[]') : [];
		$dato['cajuela']              = $this->input->post('cajuela[]') !== "" ?  $this->input->post('cajuela[]') : [];
		$dato['estructura']           = $this->input->post('estructura[]') !== "" ?  $this->input->post('estructura[]') : [];
		$dato['camino']               = $this->input->post('camino[]') !== "" ?  $this->input->post('camino[]') : [];
		$dato['pendiente']            = $this->input->post('pendiente[]') !== "" ?  $this->input->post('pendiente[]') : [];
		$dato['valor_firma']          = $this->input->post('valor_firma[]') !== "" ?  $this->input->post('valor_firma[]') : [];

		// var_dump($dato);die;
		$create = $this->buscador_model->guardar_inspeccion($dato);
		
		if($create){
			$data = array('success' =>1, 'data' => ('Orden de Servicio creada satisfactoriamente.'));
		}else{
			$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
		}

		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
		
	}
	function pdf(){

		$data['scripts'] = $this->load->view("scripts",'',true);
		$data['navbar'] = $this->load->view('navbar2','', true);
		$data['contenido'] = $this->load->view("mails/orden_servicio",'',true);
        $this->load->view("base", $data);
	}

	public function mensaje($id_orden = null)
	{
		$datos_mensaje = $this->buscador_model->ver_datosMensaje($id_orden);

		$this->load->view("mails/contenido_correo", $datos_mensaje);
	}

	public function mensaje2($id_orden = 1)
	{
		$datos_mensaje = $this->buscador_model->ver_datosMensaje($id_orden);

		$this->load->view("mails/formatos_demo/contenido_correo", $datos_mensaje);
	}

	public function enviar_orden_mail()
	{
		ini_set('memory_limit', '1024M');
		ini_set('max_execution_time', 900); //300 seconds = 5 minutes
		// cargando las librerias para envío de correo.
		$this->load->library("PhpMailerLib");
        $mail = $this->phpmailerlib->load();
		$multipunto = $this->input->post('multi');
        $imagenb64 = $this->input->post("base64");
        $img_reverso = $this->input->post("img_reverso");
        $email_envio = $this->input->post("email_envio");
        $cliente_envio = $this->input->post("cliente_envio");
        $id_orden = $this->input->post("id_orden");
        $correo_b64 = $this->input->post("correo_base64");
		$correo_b64 = file_get_contents($correo_b64);//para obtener solo el string de la imagen sin la cabecera base64 firma valida e invalida
        $formato_inventario = $this->input->post("inv");
        $correo_asesor = $this->session->userdata["logged_in"]["correo"];
        $correo_refacciones = $this->session->userdata["logged_in"]["correo"];
        $correo_tecnico = $this->session->userdata["logged_in"]["correo"];
		
		//$multipunto = $this->crear_pdf_multipunto($multipunto, $id_orden);
		
		
		//guardar en intelisis los archvios generados pendiente de validar
			//$saveIntelisis = $this->buscador_model->SaveDocsIntelisis($formato["ruta"], $id_orden,'orden' );
			//$saveIntelisis = $this->buscador_model->SaveDocsIntelisis($multipunto["ruta"], $id_orden, 'multipuntos' );

		if($this->formt_servicio == 'ford'){
			$formato = $this->crear_pdf($imagenb64, $id_orden, $img_reverso); //se utliza cuando se manda a llamar el formato de Ford
			$finventario = $this->crear_pdfInv($formato_inventario, $id_orden);	
		}
		else{
			$formato = $this->profeco_make($id_orden); //se utliza cuando se manda a llamar el formato de Fame Toyota en este caso
			$finventario["estatus"] = false;
			$finventario["ruta"] = "";
		}

        // enviar correo       
        if($formato['estatus'])
        {
			try {
			    //Server settings
			    //$mail->SMTPDebug = 2;// Enable verbose debug output
			    $mail->isSMTP();// Set mailer to use SMTP
			    $mail->Host = $this->mail_host;// Specify main and backup SMTP servers
			    $mail->SMTPAuth = $this->mail_smtpAuth;// Enable SMTP authentication
			    $mail->Username = $this->mail_username; // SMTP username
			    $mail->Password = $this->mail_password;  // SMTP password
			    $mail->SMTPSecure = $this->mail_smtpSecure;   // Enable TLS encryption, `ssl` also accepted
			    $mail->Port = $this->mail_port;// TCP port to connect to
				
				//se agrega a variable para se utilizado el nombre de correo del remitente config en bd
				$mail_username_env = $this->mail_username;
			    
			    //Recipients
			    $mail->SetFrom( $mail_username_env, 'Service Excellence');  	//Quien envía el correo
			    $mail->addAddress($email_envio, $cliente_envio);// Name is optional
			    $mail->AddReplyTo($mail_username_env,'Service Excellence');  //A quien debe ir dirigida la respuesta
			    $mail->addCC($correo_asesor);						  			  			//Con copia a
			    $mail->addCC($correo_refacciones);						  			  			//Con copia a
			    $mail->addCC($correo_tecnico);						  			  			//Con copia a
			    //$mail->addBCC('fsanjuan@intelisis.com');						  			//Con copia oculta a
			    
			    //Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->CharSet = 'UTF-8';
			    $mail->Subject = 'Copia Orden de Servicio ';
			    
				// esta imagen adjunta siempre va a ir por eso se agrega primero
				$mail->addStringEmbeddedImage($correo_b64, 'mensaje', '', 'base64','image/png'); //Se agrega el parametro de type : image/png ya que sino lo adjunta como un archivo temporal sin extención
			    $imgs='<img width="800" height="400" src="cid:mensaje" alt="texto">';

				if($this->adjuntar_fotos){
					$fotos = $this->buscador_model->traer_fotos($id_orden);

					// si existen fotos se van concatenando a la variable $imgs y la funcion addEmbeddedImage para el envio en el correo
					// hace la concatenacion si adjuntar_fotos = True
					if($fotos){
						foreach ($fotos as $row) {
							$mail->addEmbeddedImage($row['ruta_archivo'], $row['ruta_archivo'], '', 'base64','image/jpg'); //Se agrega el parametro de type : image/png ya que sino lo adjunta como un archivo temporal sin extención
							$imgs.='<img width="400" height="200" src="cid:'.$row['ruta_archivo'].'" alt="fotos">';
						}
					}
				}
				
				$mail->Body = $imgs;

				//Attachments 
				// Se cambiaron al final para permitir cargar imagen dentro del cuerpo
			    //$mail->addAttachment($formato["ruta"]);
			    $mail->addAttachment($formato["ruta"]); //Agregar archivo adjunto formato orden de servicio
			    $mail->addAttachment($finventario["ruta"]); // Agregar archivo adjunto

				$enviar = $mail->send();
				
			    $data = array('success' => 1, 'data' => ('orden enviada.'));
			    //$this->eliminar_archivoTemp($formato["ruta"]);

			    if($enviar)
			    {
			    	$envio = true;
			    }else 
			    {
			    	$envio = false;
			    }
			} catch (Exception $e) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;

			    $envio = false;
			}
        }else
        {
        	$envio = false;
        }
        echo json_encode($envio);	
	}

	public function correo($id_orden = null)
	{
		$datos = $this->buscador_model->obtener_datosOrden($id_orden);
		// var_dump($datos);die;
		$this->load->view("mails/formato_ordenServicio", $datos);
	}

	public function correo2($id_orden = 1)
	{
		$datos = $this->buscador_model->obtener_datosOrden($id_orden);
		// var_dump($datos);die;
		$this->load->view("mails/formatos_demo/formato_ordenServicio", $datos);
	}

	public function profeco_print($id_orden = null){
		$datos = $this->buscador_model->obtener_datosOrden($id_orden);
		// var_dump($datos);die;
		
		//La función recibe el nombre del folder temporal para almacenar el PDF
		$ruta_temp                = $this->createFolder("archivos_recepcion"); //Se crea el folder si no existe
		
		$html = $this->load->view('mails/formato_ordenServicioFame', $datos, true);
		if (false) {
			$this->load->view("mails/formato_ordenServicioFame", $datos);
		}else{
			$dompdf = new DOMPDF();
			$dompdf->loadHtml($html);
			$dompdf->setPaper('letter', 'portrait');
			$dompdf->render();
			$output = $dompdf->output();
			file_put_contents($ruta_temp."FormatoDeOrdenServicio".$id_orden.".pdf", $output);
			$this->showFile("archivos_recepcion", "FormatoDeOrdenServicio".$id_orden);
		}
		
	}

	public function profeco_make($id_orden = null){
		$datos = $this->buscador_model->obtener_datosOrden($id_orden);
		
		//La función recibe el nombre del folder temporal para almacenar el PDF
		$ruta_temp                = $this->createFolder("archivos_recepcion"); //Se crea el folder si no existe
		
		$html = $this->load->view('mails/formato_ordenServicioFame', $datos, true);
		$dompdf = new DOMPDF();
		$dompdf->loadHtml($html);
		$dompdf->setPaper('letter', 'portrait');
		$dompdf->render();
		$output = $dompdf->output();
		file_put_contents($ruta_temp."FormatoDeOrdenServicio".$id_orden.".pdf", $output);


		if(file_exists($ruta_temp."FormatoDeOrdenServicio".$id_orden.".pdf"))
		{
			$creado["estatus"] = true;
			$creado["ruta"] = $ruta_temp."FormatoDeOrdenServicio".$id_orden.".pdf";
		}else
		{
			$creado["estatus"] = false;
			$creado["ruta"] = "";
		}


		return $creado;
	}

	public function createFolder($folder){
		$base = $this->ruta_formts;
		$ruta = $this->ruta_formts.$folder."/";
		if(!is_dir($ruta) && !file_exists($ruta)){
			//mkdir($this->ASSETS, 0777);
			//mkdir($base, 0777);
			mkdir($ruta, 0777);
		}
		return $ruta;
	}

	public function showFile($folder, $name){
		$base = $this->ruta_formts;
		$directorio = $this->ruta_formts.$folder;
		if(is_dir($directorio)){
			$filename = $name.".pdf";
			$ruta = base_url($directorio."/".$filename);
			if(file_exists($directorio."/".$filename)){
				header('Content-type:application/pdf');
				readfile($ruta);
			}
		}
	}

	public function correo_reverso($id_orden = null)
	{
		$datos = $this->buscador_model->obtener_datosOrden($id_orden);
		// print_r($datos);die;
		$this->load->view("mails/formato_ordenServicio_reverso", $datos);
	}

	public function correo_reverso2($id_orden = 1)
	{
		$datos = $this->buscador_model->obtener_datosOrden($id_orden);
		// print_r($datos);die;
		$this->load->view("mails/formatos_demo/formato_ordenServicio_reverso", $datos);
	}

	public function generar_archivoPdf()
	{
		include_once('./application/libraries/MPDF60/mpdf.php');

		$img = $this->input->post("imagen64");
		$id_orden = $this->input->post("id_orden");

		$nombre = "FormatoDeOrdenServicio".$id_orden.".pdf";

		$html = "<img src=\"data:image/jpg;base64, ".$img."\"/>";
		$mpdf = new mPDF('c','A4','', '', 5 , 5 , 5 , 5 , 5 , 5, 'P');
		$mpdf->SetDisplayMode('fullwidth');
		$mpdf->WriteHTML($html);
		echo $mpdf->Output($nombre, "D");
	}

	public function crear_pdf($imagenb64 = null, $id_orden = null, $img_reverso = null)
	{
		include_once('./application/libraries/MPDF60/mpdf.php');

		$nombre = "FormatoDeOrdenServicio".$id_orden.".pdf";
		$imagenb64 = "".$imagenb64."";
		$img_reverso = "".$img_reverso."";

		/*Frente*/
		$mpdf = new mPDF('c','legal');
		$mpdf->simpleTables = true;
		$mpdf->packTableData = true;
		$mpdf->SetDefaultBodyCSS('background-image', "url('".$imagenb64."')");
		$mpdf->SetDefaultBodyCSS('background-image-resize', 6);
		$html = "";
		$mpdf->WriteHTML($html);

		/*Reverso*/
		$mpdf->Reset();
		$mpdf->AddPage();
		$mpdf->SetDefaultBodyCSS('background-image', "url('".$img_reverso."')");
		$mpdf->SetDefaultBodyCSS('background-image-resize', 6);
		$html2 = "";
		$mpdf->WriteHTML($html2);
		$mpdf->Output('./archivos_recepcion/'.$nombre, "F");

		if(file_exists('./archivos_recepcion/'.$nombre))
		{
			$creado["estatus"] = true;
			$creado["ruta"] = './archivos_recepcion/'.$nombre;
		}else
		{
			$creado["estatus"] = false;
			$creado["ruta"] = "";
		}

		return $creado;
	}

	public function crear_pdfInv($finventario = null, $id_orden = null)
	{
		include_once('./application/libraries/MPDF60/mpdf.php');

		$nombre = "FormatoDeInventario".$id_orden.".pdf";
		$finventario = "".$finventario."";

		$mpdf = new mPDF('c','legal');
		$mpdf->simpleTables = true;
		$mpdf->packTableData = true;
		$mpdf->SetDefaultBodyCSS('background-image', "url('".$finventario."')");
		$mpdf->SetDefaultBodyCSS('background-image-resize', 6);
		$html = "";
		$mpdf->WriteHTML($html);

		$mpdf->Output('./archivos_recepcion/'.$nombre, "F");

		if(file_exists('./archivos_recepcion/'.$nombre))
		{
			$creado["estatus"] = true;
			$creado["ruta"] = './archivos_recepcion/'.$nombre;
		}else
		{
			$creado["estatus"] = false;
			$creado["ruta"] = "";
		}

		return $creado;
	}
	public function crear_pdf_multipunto($imagenb64 = null, $id_orden = null){
		
		include_once('./application/libraries/MPDF60/mpdf.php');

		$nombre = "HojaMultipuntos".$id_orden.".pdf";
		$imagenb64 = "".$imagenb64."";
		$img_reverso = "".$img_reverso."";

		/*Frente*/
		$mpdf = new mPDF('c','legal');
		$mpdf->simpleTables = true;
		$mpdf->packTableData = true;
		$mpdf->SetDefaultBodyCSS('background-image', "url('".$imagenb64."')");
		$mpdf->SetDefaultBodyCSS('background-image-resize', 6);
		$html = "";
		$mpdf->WriteHTML($html);

		$mpdf->Output('./archivos_recepcion/'.$nombre, "F");

		if(file_exists('./archivos_recepcion/'.$nombre))
		{
			$creado["estatus"] = true;
			$creado["ruta"] = './archivos_recepcion/'.$nombre;
		}else
		{
			$creado["estatus"] = false;
			$creado["ruta"] = "";
		}

		return $creado;

	}

	public function eliminar_archivoTemp($ruta = null)
	{
		unlink($ruta);

		if(file_exists($ruta))
		{
			$eliminado = true;
		}else
		{
			$eliminado = false;
		}

		return $eliminado;
	}

	public function ver_datosOrden()
	{
		$id_orden = $this->input->post("id_orden");
		$datos = $this->buscador_model->obtener_datosOrden($id_orden);
		echo json_encode($datos);
	}

	public function ver_hojaMultipuntos($id_orden = null)
	{
		$datos = $this->buscador_model->ver_datosHojaMult($id_orden);
		// var_dump($datos);die;
		$this->load->view("mails/hoja_multipuntos", $datos);
	}

	public function ver_hojaMultipuntos2($id_orden = 1)							//Genera un formato demo sin datos
	{
		$datos = $this->buscador_model->ver_datosHojaMult($id_orden);
		// var_dump($datos);die;
		$this->load->view("mails/formatos_demo/hoja_multipuntos", $datos);
	}

	public function guardar_en_bitacora(){
		//var_dump($this->input->post());die;
		$msj = $this->input->post('TextWhats');
		$id_ = $this->input->post('ide_orden');
		$guardar = $this->buscador_model->guardar_bitacora($msj, $id_);
		
		if($guardar){
			$data = array('success' =>1, 'data' => ('Mensaje en proceso, se abrirá una nueva ventana.'));
		}else{
			$data = array('success' =>0, 'data' => ('Ocurrió al enviar.'));
		}

		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}

	public function traer_fotos_inspeccion(){
		$id = $this->input->post('id');
		$fotos = $this->buscador_model->traer_fotos($id);

		if($fotos){
			$data = array('success' =>1, 'data' => ('Mensaje en proceso, se abrirá una nueva ventana.'), 'fotos'=>$fotos);
		}else{
			$data = array('success' =>0, 'data' => ('No se encontraron fotos guardadas.'));
		}

		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}
	public function GuardarPresupuesto(){
		$datos = $this->input->post();
		$presupuesto = $this->buscador_model->GuardarPresupuesto($datos);
		$logged_in =  $this->session->userdata("logged_in");
		$perfil    =  $logged_in["perfil"];
		if($perfil == 6 && $presupuesto["estatus"] == true){ //si es de refacciones enviar mail al asesor
			$info["perfil"] = $perfil;
			$info["id"] = $presupuesto["id_presupuesto"];
			$notify = $this->notificar_asesor($info);
			$presupuesto["email"] = $notify;
		}
		echo json_encode($presupuesto);
	}
	public function GuardaVerificacion(){
		$datos = $this->input->post();
		$presupuesto = $this->buscador_model->GuardaVerificacion($datos);
		$logged_in =  $this->session->userdata("logged_in");
		$perfil    =  $logged_in["perfil"];
		if($perfil == 6 && $presupuesto["estatus"] == true){ //si es de refacciones enviar mail al tecnico
			$info["perfil"] = $perfil;
			$info["id"] = $presupuesto["id_presupuesto"];
			$notify = $this->notificar_tecnico($info);
			$presupuesto["correo_refacciones"] = $notify;
		if($perfil == 5 && $presupuesto["estatus"] == true){ //si es de tecnico enviar mail a refacciones
			$info["perfil"] = $perfil;
			$info["id"] = $presupuesto["id_presupuesto"];
			$notify = $this->notificar_refacciones($info);
			$presupuesto["correo_tecnico"] = $notify;
		}
	}
		echo json_encode($presupuesto);
	}
	// public function ver_presupuestoPdF(){
	// 	$datos = $this->input->post();
	// 	$data = $this->buscador_model->datos_presupuesto($datos);
	// 	$data['datos_cliente'] = $data['usuario'][0];
	// 	// print_r($data);
	// 	$this->load->view('formatos/formato_presupuesto',$data);
	// }
	
	public function ver_presupuestoPdF($datos= 0){
		$data["id"] = $datos;
		$data = $this->buscador_model->datos_presupuesto($data);
		$data['datos_cliente'] = $data['usuario'];
		$data["datos_suc"] = $data["datos_sucursal"];
		//print_r($data);
		$this->load->view('formatos/formato_presupuesto',$data);
	}
	public function ver_verificacionPdF($datos= 0){
		$data["id"] = $datos;
		$data = $this->buscador_model->datos_verificacion($data);
		$data['datos_cliente'] = $data['usuario'];
		$data["datos_suc"] = $data["datos_sucursal"];
		$data['movID'] = $data["usuario"];
		$data['cve_articulo'] = $data["detalle"];
		$tecnico = $data['userTecnico']['nombre']." ".$data['userTecnico']['apellidos']." ".$data['userTecnico']['actualizado']." ";
		//print_r($data['id_orden']);
		$data["datos_tecnico"]["tecnico"] = $tecnico;
		$data["datos_tecnico"]["actualizado"] =date('Y-m-d');
		$data["datos_tecnico"]["correo_tecnico"] = $tecnico;
		$data['datos_tecnico'] = $data['userTecnico'];
		$data['datos_refacciones'] = $data['user'];
		//print_r($data);
		$this->load->view('formatos/formato_verificacion_refacciones',$data);
	}
	public function email_presupuesto($datos= 0){
		$data["id"] = $datos;
		$data = $this->buscador_model->datos_presupuesto($data);
		$data['datos_cliente'] = $data['usuario'];
		$data["datos_suc"] = $data["datos_sucursal"];
		$data['id_presupuesto'] = $datos;
		$data['vin'] = $data["usuario"]["vin"];
		$data['id_orden'] = $data["usuario"]["id_orden"];
		if($data['usuario']['vista_email'] == 0)
			$this->load->view('formatos/formato_presupuesto_mail',$data);
		else show_404();
	}
	public function email_verificacion($datos= 0){
		$data["id"] = $datos;
		$logged_in =  $this->session->userdata("logged_in");
		$perfil    =  $logged_in["perfil"];
		$data = $this->buscador_model->datos_verificacion($data);
		$tecnico = $data['userTecnico']['nombre']." ".$data['userTecnico']['apellidos']." ".$data['userTecnico']['actualizado']." ";
		$data['datos_tecnico'] = $data['userTecnico'];
		$data['datos_refacciones'] = $data['user'];
		$data['id_presupuesto'] = $datos;
		$data['cve_articulo'] = $data["detalle"];
		//$correo_refacciones = $datos["datos_sucursal"]["email_refacciones"];
		$data["datos_suc"] = $data["datos_sucursal"];
		$data['id_presupuesto'] = $datos;
		//$data['vin'] = $data["user"]["vin"];
		$data['id_orden'] = $data["usuario"]["id_orden"];
		$logged_in =  $this->session->userdata("logged_in");
		$data['perfil'] = $logged_in["perfil"];
		if($data['usuario']['vista_email'] == 0)
			$this->load->view('formatos/formato_verificacion_mail',$data);
		else if($data['usuario']['vista_email'] == 1)
			$this->load->view('formatos/formato_verificacion_mail',$data);
		else show_404();
	}
	public function autorizar_presupuesto($estatus = null,  $id_presupuesto = null){
		$data = $this->buscador_model->autorizar_presupuesto($estatus, $id_presupuesto);
		echo json_encode($data);
	}
	public function EditarPresupuesto(){
		$datos = $this->input->post();
		// print_r($datos);die();
		$presupuesto = $this->buscador_model->EditarPresupuesto($datos);
		echo json_encode($presupuesto);
	}
	public function Autorizar_articulo(){
		$datos = $this->input->post();
		$presupuesto = $this->buscador_model->Autorizar_articulo($datos);
		echo json_encode($presupuesto);
	}
	public function Autorizar_todo(){
		$datos = $this->input->post();
		$presupuesto = $this->buscador_model->Autorizar_todo($datos);
		echo json_encode($presupuesto);
	}
	public function autorizar_verificacion($estatus = null,  $id_presupuesto = null){
		$data = $this->buscador_model->autorizar_verificacion($estatus, $id_presupuesto);
		echo json_encode($data);
	}
	public function EditarVerificacion(){
		$datos = $this->input->post();
		// print_r($datos);die();
		$presupuesto = $this->buscador_model->EditarVerificacion($datos);
		echo json_encode($presupuesto);
	}
	public function verificar_articulo(){
		$datos = $this->input->post();
		$presupuesto = $this->buscador_model->verificar_articulo($datos);
		echo json_encode($presupuesto);
	}
	/*public function verificar_todo(){
		$datos = $this->input->post();
		$presupuesto = $this->buscador_model->verificar_todo($datos);
		echo json_encode($presupuesto);
	}*/
	public function presupuesto_mail_cte(){
		$datos = $this->input->post();
		$presupuesto = $this->buscador_model->presupuesto_mail_cte($datos);
		if($presupuesto["estatus"])
		{
			$datos_presupuesto["id"] = $datos["id_presupuesto"];
			$this->notificar_autorizacionCliente($datos_presupuesto);
		}
		echo json_encode($presupuesto);
	}
	public function verificacion_mail_refacciones(){
		$datos = $this->input->post();
		$presupuesto = $this->buscador_model->verificacion_mail_refacciones($datos);
		$logged_in =  $this->session->userdata("logged_in");
		$perfil    =  $logged_in["perfil"];
		if($presupuesto["estatus"])
		{
			$datos_verificacion["id"] = $datos["id_presupuesto"];
			$datos_verificacion["perfil"] = $perfil;
			$this->notificar_verificacionRefacciones($datos_verificacion);
		}
		echo json_encode($presupuesto);
	}

	public function notificar_verificacionRefacciones($datos)
	{
		ini_set('memory_limit', '1024M');
		//$datos = $this->buscador_model->datos_verificacion($datos);
		$data = $this->buscador_model->datos_verificacion($datos);
		$refacciones = $data['user']['nombre']." ".$data['user']['apellidos'];
		$tecnico = $data['userTecnico']['nombre']." ".$data['userTecnico']['apellidos']." ".$data['userTecnico']['actualizado']." ";
		//print_r($data);die();
		#$refacciones = $data['user']['refacciones'];
		#$tecnico = $data['userTecnico']['tecnico'];
		$correo_refacciones = $data["datos_sucursal"]["email_refacciones"];
		#$num_cita = $data['user']['num_cita'];
		#$vin = $data['user']['vin'];
		$vin = "";
		$num_cita = "";
		$correo_tecnico = "";
		if($datos["perfil"] == 6){ //notificar a tecnico de la verificación de refacciones
			$comentario_email = "Buen día Técnico, este mensaje es para informarle que se ha revisado verificación de refacciones<br> Ya puede ver las refacciones existentes en el sistema.<br><a href='".base_url("index.php/Servicio/email_verificacion/{$datos['id']}")." ' target='_blank'>REVISAR VERIFICACIÓN</a><br>Sin más por el momento, quedo a sus ordenes, saludos.";
			$correo_refacciones = $data['user']['correo_refacciones'];
		}else{
			$correo_tecnico = "";
			$comentario_email = "";
		}
        
        // enviar correo       
       	$this->load->library("PhpMailerLib");
		$mail = $this->phpmailerlib->load();
			try {
			    //Server settings
			    // $mail->SMTPDebug = 2;// Enable verbose debug output
			    //$mail->ErrorInfo;
			    // $mail->isSMTP();// Set mailer to use SMTP
			    // $mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
			    // $mail->SMTPAuth = true;// Enable SMTP authentication
			    // $mail->Username = 'fameserviceexcellence@gmail.com'; // SMTP username
			    // $mail->Password = '9F8a*37x';  // SMTP password
			    // $mail->SMTPSecure = 'ssl';   // Enable TLS encryption, `ssl` also accepted
			    // $mail->Port = 465;// TCP port to connect to

			    //Server settings
			    // $mail->SMTPDebug = 2;// Enable verbose debug output
			    //$mail->ErrorInfo;
			    $mail->isSMTP();// Set mailer to use SMTP
			    $mail->Host = $this->mail_host;// Specify main and backup SMTP servers
			    $mail->SMTPAuth = $this->mail_smtpAuth;// Enable SMTP authentication
			    $mail->Username = $this->mail_username; // SMTP username
			    $mail->Password = $this->mail_password;  // SMTP password
			    $mail->SMTPSecure = $this->mail_smtpSecure;   // Enable TLS encryption, `ssl` also accepted
			    $mail->Port = $this->mail_port;// TCP port to connect to
				
				//se agrega a variable para se utilizado el nombre de correo del remitente config en bd
				$mail_username_env = $this->mail_username;
			    
			    //Recipients
			    $mail->SetFrom($mail_username_env, 'Service Excellence');  	//Quien envía el correo
			    #$mail->addAddress($correo_tecnico);// Name is optional
				$mail->addCC("mlopez@intelisis.com");
			    #$mail->addAddress($correo_refacciones);// Name is optional
				$mail->addCC("tpena@intelisis.com");
			    //$mail->addBCC('fsanjuan@intelisis.com');	//Con copia oculta
			                              // Set email format to HTML
			    $mail->CharSet = 'UTF-8';
			    $mail->Subject = 'Verificación';
			    $mail->Body      = "<html><body>".$comentario_email."</html></body>";

			    $mail->isHTML(true); 
				$envia = $mail->send();
				
			    $data = array('success' => 1, 'data' => ('Verificación enviada.'));
			    //$this->eliminar_archivoTemp($formato["ruta"]);

			    if($envia)
			    {
			    	$envio = true;
			    }else 
			    {
			    	$envio = false;
			    	var_dump($mail->ErrorInfo);
			    }
			} catch (Exception $e) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;

			    $envio = false;
			}
       
        return $envio;	
	}
	public function notificar_autorizacionCliente($datos_presupuesto = null)
	{
		ini_set('memory_limit', '1024M');
		$datos = $this->buscador_model->datos_presupuesto($datos_presupuesto);
		
		$nom_cliente = $datos["usuario"]["nombre_cliente"]." ".$datos["usuario"]["ap_cliente"]." ".$datos["usuario"]["am_cliente"];
		$no_orden = (isset($datos["usuario"]["movID"]["MovID"])) ? $datos["usuario"]["movID"]["MovID"] : "-";
		$no_presupuesto = $datos["usuario"]["id_presupuesto"];
		$correo_asesor = $datos["usuario"]["correo_asesor"];
		$correo_refacciones = $datos["datos_sucursal"]["email_refacciones"];
		$total_presup = 0;
		$contenido_correo = "";
		$contenido_correo .= "<p style='text-align: justify;'>El Cliente <b>".$nom_cliente."</b> ha revisado el <b>presupuesto No. ".$no_presupuesto."</b> para la <b>orden de servicio ".$no_orden."</b>, cuyos artículos y autorización se muestran a continuación:</p><br>";
		$contenido_correo .= "<table style='padding: 5px 0 0 0; font-family: Arial, sans-serif; color: #000; font-size: 14px; border: 1px solid  #000;' width='100%' cellpadding='2' cellspacing='0'><tr><thead><th>Clave Artículo</th><th>Descripción</th><th>Precio Unitario</th><th>Cantidad</th><th>Total</th><th>Autorizar</th></thead></tr><tbody>";
		foreach ($datos["detalle"] as $key => $value) 
		{
			$contenido_correo .= "<tr>";
			$contenido_correo .= "<td>".$value["cve_articulo"]."</td>";
			$contenido_correo .= "<td>".$value["descripcion"]."</td>";
			$contenido_correo .= "<td>".$value["precio_unitario"]."</td>";
			$contenido_correo .= "<td>".$value["cantidad"]."</td>";
			$contenido_correo .= "<td>".$value["total_arts"]."</td>";
			if($value["autorizado"] == 1)
			{
				$contenido_correo .= "<td>SÍ</td>";
			}else
			{
				$contenido_correo .= "<td>NO</td>";
			}
			$contenido_correo .= "</tr>";
			$total_presup += $value["total_arts"];
		}
		$contenido_correo .= "</tbody></table>";
		$contenido_correo .="<p><b>Total del Presupuesto: $".$total_presup."</b></p>";

		$this->load->library("PhpMailerLib");
		$mail = $this->phpmailerlib->load();
		try {
			    //Server settings
			    // $mail->SMTPDebug = 2;// Enable verbose debug output
			    //$mail->ErrorInfo;
			    // $mail->isSMTP();// Set mailer to use SMTP
			    // $mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
			    // $mail->SMTPAuth = true;// Enable SMTP authentication
			    // $mail->Username = 'fameserviceexcellence@gmail.com'; // SMTP username
			    // $mail->Password = '9F8a*37x';  // SMTP password
			    // $mail->SMTPSecure = 'ssl';   // Enable TLS encryption, `ssl` also accepted
			    // $mail->Port = 465;// TCP port to connect to

				//Server settings
			    // $mail->SMTPDebug = 2;// Enable verbose debug output
			    //$mail->ErrorInfo;
				$mail->isSMTP();// Set mailer to use SMTP
			    $mail->Host = $this->mail_host;// Specify main and backup SMTP servers
			    $mail->SMTPAuth = $this->mail_smtpAuth;// Enable SMTP authentication
			    $mail->Username = $this->mail_username; // SMTP username
			    $mail->Password = $this->mail_password;  // SMTP password
			    $mail->SMTPSecure = $this->mail_smtpSecure;   // Enable TLS encryption, `ssl` also accepted
			    $mail->Port = $this->mail_port;// TCP port to connect to
				
				//se agrega a variable para se utilizado el nombre de correo del remitente config en bd
				$mail_username_env = $this->mail_username;

			    //Recipients
			    $mail->SetFrom($mail_username_env, 'Service Excellence');  	//Quien envía el correo
			    //$mail->addAddress("fsanjuan@intelisis.com");// Name is optional
			    $mail->addAddress($correo_asesor);// Name is optional
			    $mail->addCC($correo_refacciones);
			    // $mail->AddReplyTo($correo_asesor,'Service Excellence');  //A quien debe ir dirigida la respuesta
			    //Content
			    // Set email format to HTML
			    $mail->CharSet = 'UTF-8';
			    $mail->Subject = 'Autorización Presupuesto, Orden de Servicio '.$no_orden;
			    $mail->Body      = "<html><body style='font-family: Arial, sans-serif; color: #000; font-size: 14px;'>".$contenido_correo."</html></body>";
			    $mail->isHTML(true); 
				$enviar = $mail->send();
				
			    $data = array('success' => 1, 'data' => ('Autorización de presupuesto enviada.'));

			    if($enviar)
			    {
			    	$envio = true;
			    }else 
			    {
			    	$envio = false;
			    	var_dump($mail->ErrorInfo);
			    }
			} catch (Exception $e) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;

			    $envio = false;
			}
       
        return $envio;
	}
	
	public function notificar_asesor($info)
	{
		ini_set('memory_limit', '1024M');

		$data = $this->buscador_model->datos_presupuesto($info);
		$cliente = $data['usuario']['nombre_cliente']." ".$data['usuario']['ap_cliente']." ".$data['usuario']['am_cliente'];
		// print_r($data);die();
		$asesor = $data['usuario']['asesor'];
		$num_cita = $data['usuario']['num_cita'];
		$vin = $data['usuario']['vin'];
		if($info["perfil"] == 6){ //notificar al asesor desde el refacciones
			$comentario_email = "Buen día ".$asesor.", este mensaje es para informarle que se ha generado un nuevo presupuesto para el cliente: ".$cliente.". <br> La cita tiene el número: <b>".$num_cita."</b>. Y el vin relacionado es: <b>".$vin.".</b><br> Favor de verificarlo en el sistema a la brevedad. <br>Saludos.";
			$correo_asesor = $data['usuario']['correo_asesor'];
		}else{
			$comentario_email = "";
		}
        
        // enviar correo       
       	$this->load->library("PhpMailerLib");
		$mail = $this->phpmailerlib->load();
			try {
			    //Server settings
			    // $mail->SMTPDebug = 2;// Enable verbose debug output
			    //$mail->ErrorInfo;
			    // $mail->isSMTP();// Set mailer to use SMTP
			    // $mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
			    // $mail->SMTPAuth = true;// Enable SMTP authentication
			    // $mail->Username = 'fameserviceexcellence@gmail.com'; // SMTP username
			    // $mail->Password = '9F8a*37x';  // SMTP password
			    // $mail->SMTPSecure = 'ssl';   // Enable TLS encryption, `ssl` also accepted
			    // $mail->Port = 465;// TCP port to connect to

			    //Server settings
			    // $mail->SMTPDebug = 2;// Enable verbose debug output
			    //$mail->ErrorInfo;
			    $mail->isSMTP();// Set mailer to use SMTP
			    $mail->Host = $this->mail_host;// Specify main and backup SMTP servers
			    $mail->SMTPAuth = $this->mail_smtpAuth;// Enable SMTP authentication
			    $mail->Username = $this->mail_username; // SMTP username
			    $mail->Password = $this->mail_password;  // SMTP password
			    $mail->SMTPSecure = $this->mail_smtpSecure;   // Enable TLS encryption, `ssl` also accepted
			    $mail->Port = $this->mail_port;// TCP port to connect to
				
				//se agrega a variable para se utilizado el nombre de correo del remitente config en bd
				$mail_username_env = $this->mail_username;
			    
			    //Recipients
			    $mail->SetFrom($mail_username_env, 'Service Excellence');  	//Quien envía el correo
			    $mail->addAddress($correo_asesor);// Name is optional
			    //$mail->addBCC('fsanjuan@intelisis.com');	//Con copia oculta
			                              // Set email format to HTML
			    $mail->CharSet = 'UTF-8';
			    $mail->Subject = 'Presupuesto';
			    $mail->Body      = "<html><body><p>".$comentario_email."</p></html></body>";
			    $mail->isHTML(true); 
				$enviar = $mail->send();
				
			    $data = array('success' => 1, 'data' => ('presupuesto enviada.'));
			    //$this->eliminar_archivoTemp($formato["ruta"]);

			    if($enviar)
			    {
			    	$envio = true;
			    }else 
			    {
			    	$envio = false;
			    	var_dump($mail->ErrorInfo);
			    }
			} catch (Exception $e) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;

			    $envio = false;
			}
       
        return $envio;	
	}
	public function notificar_refacciones($info)
	{
		ini_set('memory_limit', '1024M');

		$data = $this->buscador_model->datos_verificacion($info);
		$refacciones = $data['user']['nombre']." ".$data['user']['apellidos'];
		$tecnico = $data['userTecnico']['nombre']." ".$data['userTecnico']['apellidos']." ".$data['userTecnico']['actualizado']." ";
		// print_r($data);die();
		$refacciones = $data['user']['refacciones'];
		$tecnico = $data['userTecnico']['tecnico'];
		$correo_refacciones = $datos["datos_sucursal"]["email_refacciones"];
		#$num_cita = $data['user']['num_cita'];
		#$vin = $data['user']['vin'];
		$vin = "";
		$num_cita = "";
		if($info["perfil"] == 6){ //notificar a tecnico de la verificación de refacciones
			$comentario_email = "Buen día ".$tecnico.", este mensaje es para informarle que se ha revisado verificación de refacciones: ".$tecnico.".</b><br> Ya puede verificarlo en el sistema. <br>Saludos.";
			$correo_refacciones = $data['user']['correo_refacciones'];
		}else{
			$correo_tecnico = "";
			$comentario_email = "";
		}
		if($info["perfil"] == 5){ //notificar a refacciones de la verificación de refacciones
			$comentario_email = "Buen día ".$refacciones.", este mensaje es para informarle que se ha generado una nueva verificación de refacciones: ".$refacciones.".</b><br> Favor de verificarlo en el sistema a la brevedad. <br>Saludos.";
			$correo_tecnico = $data['userTecnico']['correo_tecnico'];
		}else{
			$correo_refacciones = "";
			$comentario_email = "";
		}
        
        // enviar correo       
       	$this->load->library("PhpMailerLib");
		$mail = $this->phpmailerlib->load();
			try {
			    //Server settings
			    // $mail->SMTPDebug = 2;// Enable verbose debug output
			    //$mail->ErrorInfo;
			    // $mail->isSMTP();// Set mailer to use SMTP
			    // $mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
			    // $mail->SMTPAuth = true;// Enable SMTP authentication
			    // $mail->Username = 'fameserviceexcellence@gmail.com'; // SMTP username
			    // $mail->Password = '9F8a*37x';  // SMTP password
			    // $mail->SMTPSecure = 'ssl';   // Enable TLS encryption, `ssl` also accepted
			    // $mail->Port = 465;// TCP port to connect to

			    //Server settings
			    // $mail->SMTPDebug = 2;// Enable verbose debug output
			    //$mail->ErrorInfo;
			    $mail->isSMTP();// Set mailer to use SMTP
			    $mail->Host = $this->mail_host;// Specify main and backup SMTP servers
			    $mail->SMTPAuth = $this->mail_smtpAuth;// Enable SMTP authentication
			    $mail->Username = $this->mail_username; // SMTP username
			    $mail->Password = $this->mail_password;  // SMTP password
			    $mail->SMTPSecure = $this->mail_smtpSecure;   // Enable TLS encryption, `ssl` also accepted
			    $mail->Port = $this->mail_port;// TCP port to connect to
				
				//se agrega a variable para se utilizado el nombre de correo del remitente config en bd
				$mail_username_env = $this->mail_username;
			    
			    //Recipients
			    $mail->SetFrom($mail_username_env, 'Service Excellence');  	//Quien envía el correo
			    $mail->addAddress($correo_tenico);// Name is optional
				$mail->addCC("mlopez@intelisis.com");
			    $mail->addAddress($correo_refacciones);// Name is optional
				$mail->addCC("tpena@intelisis.com");
			    //$mail->addBCC('fsanjuan@intelisis.com');	//Con copia oculta
			                              // Set email format to HTML
			    $mail->CharSet = 'UTF-8';
			    $mail->Subject = 'Verificación';
			    $mail->Body      = "<html><body><p>".$comentario_email."</p></html></body>";
			    $mail->isHTML(true); 
				$envia = $mail->send();
				
			    $data = array('success' => 1, 'data' => ('Verificación enviada.'));
			    //$this->eliminar_archivoTemp($formato["ruta"]);

			    if($envia)
			    {
			    	$envio = true;
			    }else 
			    {
			    	$envio = false;
			    	var_dump($mail->ErrorInfo);
			    }
			} catch (Exception $e) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;

			    $envio = false;
			}
       
        return $envio;	
	}
	public function fotos_presupuesto_email(){
		$datos = $this->input->post();
		$fotos = $this->buscador_model->fotos_seguimiento($datos);
		echo json_encode($fotos);
	}
	public function guardar_firma_multi()
	{
		$datos = $this->input->post();
		$update = $this->buscador_model->guardar_firma_multi($datos);
		echo json_encode($update);
	}

	public function generar_formatoInventario($bandera = 0, $id_orden = null)
	{
		$datos = $this->buscador_model->obtener_datosFormato_inventario($id_orden);
		$datos["orden"]["bandera"] = $bandera;
		
		$this->load->view("formatos/formato_inventario", $datos);
	}

	public function cargar_datsOrden_insp($id_orden = null)
	{
		$datos = $this->buscador_model->cargar_datsOrden_insp($id_orden);
		
		echo json_encode($datos);
	}

	public function generar_formatoProfecoTalisman($bandera = null, $id_orden = null)
	{
		$datos = $this->buscador_model->obtener_datosOrden($id_orden);
		// var_dump($datos);
		// die();
		$this->load->view("formatos/formato_ProfecoTalisman", $datos);
	}

	public function guardar_formatoOasis($id_orden = null)
	{
		ini_set('memory_limit', '1024M');
		ini_set('max_execution_time', 900); //300 seconds = 5 minutes
		$formato_oasis = $this->input->post("oasis");
		$id_orden = $this->input->post("id_orden");
		$ruta_temp                = $this->createFolder("archivos_recepcion"); //Se crea el folder si no existe
		$oasis = $this->buscador_model->cargar_oasis($ruta_temp, $formato_oasis, $id_orden);
		echo json_encode($oasis);
	}
	public function guardar_voc()
	{
		ini_set('memory_limit', '1024M');
		ini_set('max_execution_time', 900); //300 seconds = 5 minutes
		$datos = $this->input->post();
		$response = $this->buscador_model->guardar_voc($datos);
		echo json_encode($response);
	}
	public function get_archivos_orden_servicio($id_orden = null)
	{
		if ($id_orden == null) {
			$response['estatus'] = false;
			$response['archivos'] = [];
		}else{
			$orden = $this->db->select('movimiento')->from('orden_servicio')->where('id', $id_orden)->get()->row_array();
			if (isset($orden['movimiento'])) {
				$oasis  = $this->buscador_model->get_archivos_orden_servicio($orden['movimiento'], 7);
				$audios = $this->buscador_model->get_archivos_orden_servicio($orden['movimiento'], 8);
			}

			$oasis  = array_merge($oasis, $this->buscador_model->get_archivos_orden_servicio($id_orden, 7));
			$audios = array_merge($this->buscador_model->get_archivos_orden_servicio($id_orden, 8));
			$array  = [];
			foreach ($oasis as $key => $value) {
				$path = base_url().$value['ruta_archivo'];
				if (file_exists($value['ruta_archivo'])) {
					$array[] = [
						'ruta'   => $path,
						'tipo'   => $value['tipo'],
						'nombre' => pathinfo($path)['filename'],
						'id'     => $value['id']
					];
				}
			}
			foreach ($audios as $key => $value) {
				$path = base_url().$value['ruta_archivo'];
				if (file_exists($value['ruta_archivo'])) {
					$array[] = [
						'ruta'   => $path,
						'tipo'   => $value['tipo'],
						'nombre' => pathinfo($path)['filename'],
						'id'     => $value['id']
					];
				}
			}
			$response['archivos'] = $array;
			$response['estatus'] = true;
		}
		echo json_encode($response);
	}
	public function guardar_documentacion()
	{
		ini_set('memory_limit', '1024M');
		ini_set('max_execution_time', 900); //300 seconds = 5 minutes;
		$tipo = $this->input->post("tipo");
		$id_orden = $this->input->post("id_orden_servicio");
		$ruta_temp                = $this->createFolder("archivos_recepcion"); //Se crea el folder si no existe
		$response = $this->buscador_model->cargar_documentacion($ruta_temp, $tipo, $id_orden);
		echo json_encode($response);
	}
	public function abrir_pregarantia()
	{
		$id_orden_servicio = $this->input->post('id_orden_servicio');
		$response = $this->buscador_model->abrir_pregarantia($id_orden_servicio);
		echo json_encode($response);
	}
	public function obtener_datos_quejas($id_orden = null)
	{
		$response = [];
		if ($id_orden == null) {
			$response = [
				'estatus' => false,
				'mensaje' => 'Orden de servicio no válida.'
			];
		}else {
			$response['data']    = $this->buscador_model->obtener_datos_quejas($id_orden);
			$response['estatus'] = sizeof($response['data']) > 0 ? true : false;
			$response['mensaje'] = sizeof($response['data']) > 0 ? 'Quejas encontradas para la orden de servicio.' : 'La orden de servicio no tiene ninguna queja vinculada.';
		}
		echo json_encode($response);
	}
	public function eliminar_archivo_documentacion($id_archivo = null)
	{
		if ($id_archivo == null) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Archivo no válido.';
		}else {
			$response = $this->buscador_model->eliminar_archivo_documentacion($id_archivo);
		}
		echo json_encode($response);
	}
	public function autorizar_pregarantia()
	{
		$id_orden = $this->input->post('id_orden_servicio') != '' ? $this->input->post('id_orden_servicio') : null;
		if ($id_orden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = 'orden no valida';
		}else {
			$response = $this->buscador_model->autorizar_pregarantia($id_orden);
		}
		echo json_encode($response);
	}
	public function obtenerFirmasPregarantia($id_orden = null)
	{
		if ($id_orden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = "orden no válida.";
		}else {
			$response['estatus'] = true;
			$response['data'] = $this->buscador_model->obtenerFirmasPregarantia($id_orden);
		}
		echo json_encode($response);
	}
	public function cancelar_firma_pregarantia()
		{
			$id_orden = $this->input->post('id_orden_servicio') !=''? $this->input->post('id_orden_servicio') : null;
			if ($id_orden == null) {
				$response['estatus'] = false;
				$response['mensaje'] = 'no existe autorizacion';
			}else {
				$response = $this->buscador_model->cancelar_firma_pregarantia($id_orden);
			}
			echo json_encode($response);
		}
	public function autorizar_adicional()
	{
		$id_orden = $this->input->post('id_orden_servicio') != '' ? $this->input->post('id_orden_servicio') : null;
		if ($id_orden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = 'orden no valida';
		}else {
			$response = $this->buscador_model->autorizar_adicional($id_orden);
		}
		echo json_encode($response);
	}
	public function obtenerFirmaAdd($id_orden = null)
	{
		if ($id_orden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = "orden no válida.";
		}else {
			$response['estatus'] = true;
			$response['data'] = $this->buscador_model->obtenerFirmaAdd($id_orden);
		}
		echo json_encode($response);
	}
	public function cancelar_firma_adicional()
		{
			$id_orden = $this->input->post('id_orden_servicio') !=''? $this->input->post('id_orden_servicio') : null;
			if ($id_orden == null) {
				$response['estatus'] = false;
				$response['mensaje'] = 'no existe autorizacion';
			}else {
				$response = $this->buscador_model->cancelar_firma_adicional($id_orden);
			}
			echo json_encode($response);
		}
	public function autorizar_cp()
	{
		$id_orden = $this->input->post('id_orden_servicio') != '' ? $this->input->post('id_orden_servicio') : null;
		if ($id_orden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = 'orden no valida';
		}else {
			$response = $this->buscador_model->autorizar_cp($id_orden);
		}
		echo json_encode($response);
	}
	public function obtenerFirmaCP($id_orden = null)
	{
		if ($id_orden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = "orden no válida.";
		}else {
			$response['estatus'] = true;
			$response['data'] = $this->buscador_model->obtenerFirmaCP($id_orden);
		}
		echo json_encode($response);
	}
	public function cancelar_firma_cp()
		{
			$id_orden = $this->input->post('id_orden_servicio') !=''? $this->input->post('id_orden_servicio') : null;
			if ($id_orden == null) {
				$response['estatus'] = false;
				$response['mensaje'] = 'no existe autorizacion';
			}else {
				$response = $this->buscador_model->cancelar_firma_cp($id_orden);
			}
			echo json_encode($response);
		}
	public function obtener_firmas($id_orden = null)
	{
		if ($id_orden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = "orden no válida.";
		}else {
			$response = $this->buscador_model->obtener_firmas($id_orden);
		}
		echo json_encode($response);
	}
	/*public function verificar_cp($id_orden = null)
	{
		if ($id_orden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = "Orden no válida.";
		} else {
			$response = $this->buscador_model->verificar_cp($id_orden);
		}
		echo json_encode($response);
	}*/
	public function obtener_datos_cp($id_orden_servicio = null, $id_orden_intelisis = null, $vin = null){
		if ($id_orden_servicio == null || $id_orden_intelisis == null || $vin == null) {
			$response['estatus'] = false;
			$response['mensaje'] = "Orden no válida.";
		} else {
			$response = $this->buscador_model->obtener_datos_cp($id_orden_servicio, $id_orden_intelisis, $vin);
		}
		echo json_encode($response);
	}
	public function autorizar_refacc()
	{
		$id_orden = $this->input->post('id_orden_servicio') != '' ? $this->input->post('id_orden_servicio') : null;
		if ($id_orden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = 'orden no valida';
		}else {
			$response = $this->buscador_model->autorizar_refacc($id_orden);
		}
		echo json_encode($response);
	}
	public function obtenerFirmaRefacc($id_orden = null)
	{
		if ($id_orden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = "orden no válida.";
		}else {
			$response['estatus'] = true;
			$response['data'] = $this->buscador_model->obtenerFirmaRefacc($id_orden);
		}
		echo json_encode($response);
	}
	public function cancelar_firma_refacc()
		{
			$id_orden = $this->input->post('id_orden_servicio') !=''? $this->input->post('id_orden_servicio') : null;
			if ($id_orden == null) {
				$response['estatus'] = false;
				$response['mensaje'] = 'no existe autorizacion';
			}else {
				$response = $this->buscador_model->cancelar_firma_refacc($id_orden);
			}
			echo json_encode($response);
		}
	public function recibo_refacc()
	{
		$id_orden = $this->input->post('id_orden_servicio') != '' ? $this->input->post('id_orden_servicio') : null;
		if ($id_orden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = 'orden no valida';
		}else {
			$response = $this->buscador_model->recibo_refacc($id_orden);
		}
		echo json_encode($response);
	}
	public function obtenerFirmaTecnico($id_orden = null)
	{
		if ($id_orden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = "orden no válida.";
		}else {
			$response['estatus'] = true;
			$response['data'] = $this->buscador_model->obtenerFirmaTecnico($id_orden);
		}
		echo json_encode($response);
	}
	public function cancelar_firma_tecnico()
	{
		$id_orden = $this->input->post('id_orden_servicio') !=''? $this->input->post('id_orden_servicio') : null;
		if ($id_orden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = 'no existe autorizacion';
		}else {
			$response = $this->buscador_model->cancelar_firma_tecnico($id_orden);
		}
		echo json_encode($response);
	}
	public function obtener_pdf_api($token = null)
	{
		$datos = $this->input->post();
		#$token = $this->input->post('token') != '' ? $this->input->post('token') : null;
		if ($token == null) {
			$response['estatus'] = false;
			$response['mensaje'] = "Token no válido.";
		} else {
			$response = $this->buscador_model->obtener_pdf_api($token, $datos);
		}
		echo json_encode($response);
	}

	public function generar_formato_causa_raiz_componente($token = null, $id_orden = null)
	{
		#$id_orden = 34762;  orden de prueba
		$data = [];
    	$data = $this->buscador_model->obtener_datos_quejas($id_orden);
    	$datos = $this->input->post();
    	$datos["quejas"] = $data;
		#$token = $this->input->post('token') != '' ? $this->input->post('token') : null;
		if ($token == null || $id_orden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = "Orden no válida.";
		} else {
			$response = $this->buscador_model->obtener_pdf_api($token, $datos);
			if ($response["estatus"]) {
				$this->buscador_model->guardar_formato($id_orden, $response["data"]["ruta_rel"]);
			}
		}
    	/*$html = $this->load->view('formatos/causa_raiz_componente', $data, TRUE);
		$dompdf = new DOMPDF();
		$dompdf->setBasePath(realpath("{$this->ruta_formts}/assets"));
    	$dompdf->load_html($html);
    	$dompdf->render();
    	//$dompdf->stream();
    	$output = $dompdf->output();
    	$pdf = fopen("{$this->ruta_formts}prueba.pdf", 'w');
		fwrite($pdf, $output);
		fclose($pdf);
    	if (file_exists("{$this->ruta_formts}prueba.pdf")) {
    		$response = ['value' => 'si'];
    	} else {
    		$response = ['value' => 'no'];
    	}*/
    	#$dompdf->folder($this->ruta_formts);
    	#$dompdf->create('save');
    	echo json_encode($response);
	}
	public function obtener_union_pdf($token = null, $idOrden = null)
	{
		$data = [];
		$datos = $this->input->post();
		if ($idOrden == null || $token == null) {
			$response['estatus'] = false;
			$response['mensaje'] = 'no existe autorizacion';
		}else {
			$orden = $this->db->select('movimiento')->from('orden_servicio')->where('id', $idOrden)->get()->row_array();
			if (isset($orden['movimiento'])) {
				$archivos = $this->buscador_model->get_archivos_f1863($orden['movimiento'], 7);
			}
			$archivos = array_merge($archivos,$this->buscador_model->get_archivos_f1863($idOrden, 7));
			$datos["archivos"] = $archivos;
			$response = $this->buscador_model->obtener_union_pdf($token, $datos);
		}
		echo json_encode($response);
	}
	public function guardar_requisiciones($idOrden = null)
	{
		$datos = [];
		$datos = $this->input->post();
		if ($idOrden == null ) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Orden no válida.';
		}elseif(!isset($datos['detalles']) || sizeof($datos['detalles']) <= 0) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Datos de requisiciones faltantes.';
		}else {
			$response = $this->buscador_model->guardar_requisiciones($idOrden, $datos);
		}
		echo json_encode($response);
	}
	public function guardar_diagnostico($idOrden = null)
	{
		$datos = [];
		$datos = $this->input->post();
		if ($idOrden == null ) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Orden no válida.';
		}elseif(!isset($datos['detalles']) || sizeof($datos['detalles']) <= 0) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Datos del diagnóstico faltantes.';
		}else { 
			$response = $this->buscador_model->guardar_diagnostico($idOrden, $datos);
		}
		echo json_encode($response);
	}
	public function obtener_diagnosticos($idOrden = null)
	{
		$datos = [];
		if ($idOrden == null ) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Orden no válida.';
		}else {
			$response = $this->buscador_model->obtener_diagnosticos($idOrden);
		}
		echo json_encode($response);
	}
	public function obtener_detalles_diagnostico($idRevision = null)
	{
		$datos = [];
		$datos = $this->input->post();
		if ($idRevision == null) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Orden no válida.';
		}else {
			$response = $this->buscador_model->obtener_detalles_diagnostico($idRevision);
		}
		echo json_encode($response);
	}
	public function editar_diagnostico($idOrden = null)
	{
		$datos = [];
		$datos = $this->input->post();
		if ($idOrden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Orden no válida.';
		}elseif (!isset($datos['id_diagnostico'])) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Diagnóstico no válido.';
		}elseif(!isset($datos['detalles']) || sizeof($datos['detalles']) <= 0) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Datos del diagnóstico faltantes.';
		}else {
			$response = $this->buscador_model->editar_diagnostico($idOrden, $datos);
		}
		echo json_encode($response);
	}
	public function ver_diagnosticoPdf($datos = 0){
		$data["id"] = $datos;
		$data = $this->buscador_model->detalles_formato_diagnostico($data);
		$data["datos_suc"] = $data["datos_sucursal"];
		$data['movID'] = $data["usuario"];
		$tecnico = $data['userTecnico']['tecnico']." ";
		$jefeTaller = $data['userJefe']['jefe_de_taller']." ";
		$codig = $data['codigo']['num_reparacion']." ".$data['codigo']['luz_de_falla']." ".$data['codigo']['tren_motriz']." ".$data['codigo']['codigos']." ".$data['codigo']['fecha_creacion']." ";
		$notes = $data['anotaciones']['queja_cliente']." ".$data['anotaciones']['sintomas_falla']." ".$data['anotaciones']['equipo_diagnostico']." ".$data['anotaciones']['comentarios_tecnicos']." ".$data['anotaciones']['publica']." ".$data['anotaciones']['garantia']." ".$data['anotaciones']['adicional']." ".$data['anotaciones']['firma_tecnico']." ".$data['anotaciones']['firma_jefe_taller']." ";
		//print_r($data['id_orden']);
		$data["datos_notes"]["notes"] = $notes;
		$data['datos_notes'] = $data['anotaciones'];
		$data["datos_code"]["codig"] = $codig;
		$data['datos_code'] = $data['codigo'];
		$data["datos_tecnico"]["tecnico"] = $tecnico;
		$data['datos_tecnico'] = $data['userTecnico'];
		$data["datos_jefe"]["jefeTaller"] = $jefeTaller;
		$data['datos_jefe'] = $data['userJefe'];
		//print_r($data);
		$this->load->view("formatos/formato_diagnostico_tecnico",$data);
		
	}
	public function firmar_diagnostico($idDiagnostico = null){
		if ($idDiagnostico == null ) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Firma no valida.';
		}else {
			$response = $this->buscador_model->autorizar_diagnostico($idDiagnostico);
		}
		echo json_encode($response);
	}
	public function obtenerFirmaDiagnostico($idDiagnostico = null)
	{
		if ($idDiagnostico == null) {
			$response['estatus'] = false;
			$response['mensaje'] = "no existen firmas.";
		}else {
			$response['estatus'] = true;
			$response['data'] = $this->buscador_model->obtenerFirmaDiagnostico($idDiagnostico);
		}
		echo json_encode($response);
	}
	public function cancela_diagnostico()
	{
		$idDiagnostico = $this->input->post('id_diagnostico') !=''? $this->input->post('id_diagnostico') : null;
		if ($idDiagnostico == null) {
			$response['estatus'] = false;
			$response['mensaje'] = 'no existe autorizacion';
		}else {
			$response = $this->buscador_model->cancela_diagnostico($idDiagnostico);
		}
		echo json_encode($response);
	}
	public function generar_formato_inventario($token = null, $id_orden = null)
	{
		#$id_orden = 34762;  orden de prueba
		$data = [];
		$datos = $this->input->post();
		if ($token == null || $id_orden == null) {
			$response['estatus'] = false;
			$response['mensaje'] = "Orden no válida.";
		} else {
			$response = $this->buscador_model->obtener_pdf_api($token, $datos);
			if ($response["estatus"]) {
				$this->buscador_model->guardar_formato($id_orden, $response["data"]["ruta_rel"]);
			}
		}
	}
	public function obtener_requisiciones($idOrden = null)
	{
		$datos = [];
		if ($idOrden == null ) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Orden no válida.';
		}else {
			$response = $this->buscador_model->obtener_requisiciones($idOrden);
		}
		echo json_encode($response);
	}
	public function obtener_detalles_requisicion($idReq = null)
	{
		$datos = [];
		$datos = $this->input->post();
		if ($idReq == null) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Orden no válida.';
		}else {
			$response = $this->buscador_model->obtener_detalles_requisicion($idReq);
		}
		echo json_encode($response);
	}
	public function convertir_cotizacion($idPresupuesto = null)
	{
		$datos = [];
		$datos = $this->input->post();
		if ($idPresupuesto == null) {
			$response['estatus'] = false;
			$response['mensaje'] = 'Presupuesto no válido.';
		}else {
			$response = $this->buscador_model->convertir_cotizacion($idPresupuesto);
		}
		echo json_encode($response);
	}
	public function editar_requisicion(){
		$datos = $this->input->post();
		/*echo "<pre>";
		print_r ($datos);
		echo "</pre>";
		die();*/
		// print_r($datos);die();
		$presupuesto = $this->buscador_model->editar_requisicion($datos);
		echo json_encode($presupuesto);
	}
	public function generar_formato_requisicion($token = null, $id = null)
	{
		$data = [];
		$datos = $this->input->post();
		if ($token == null || $id == null) {
			$response['estatus'] = false;
			$response['mensaje'] = "Requisición no válida.";
		} else {
			$requisicion = $this->buscador_model->obtener_detalles_requisicion($id);
			if ($requisicion['estatus']) {
				$datos = array_merge($datos, $requisicion);
				$datos['vin'] = $requisicion['vin'];
				$datos['id_orden'] = $requisicion['id_orden'];
				$datos['firmaTec'] = $requisicion['firmaTec'];
				$datos['firmaRef'] = "";
				$response = $this->buscador_model->obtener_pdf_api($token, $datos);
				if ($response["estatus"]) {
					$this->buscador_model->guardar_formato($datos['id_orden'], $response["data"]["ruta_rel"]);
				}
			}else {
				$response = $requisicion;
			}
		}
		echo json_encode($response);
	}
}
