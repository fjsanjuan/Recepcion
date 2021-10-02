<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
class Peticiones extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('buscador_model');
		$this->form_validation->set_error_delimiters('', '<br/>');
	}

	function inspeccion_imgBase64($id_orden = null){
		$data = $this->buscador_model->traer_fotos($id_orden);
		
		foreach ($data as $key => $value) {
			// Nombre de la imagen
			// este path se utliza cuando las fotos se guardan dentro del mismo proyecto de recepcion en el servidor
			$path = base_url().$value['ruta_archivo'];
			// este path se utliza cuando las fotos se guardan dentro de otra ruta del servidor
			//$path ='D:/firmaImg.jpg';

			// Extensión de la imagen
			$type = pathinfo($path, PATHINFO_EXTENSION);

			// Cargando la imagen
			$file = file_get_contents($path);

			// Decodificando la imagen en base64
			$array[$key] = $base64 = 'data:image/' . $type . ';base64,' . base64_encode($file);
		}
		
		echo json_encode($array);
	}

	function get_seguimiento_cliente($id_orden = null){
		$id_orden = $this->base64_decode_url($id_orden);
		$array = [];
		$data = [];
		if ( is_numeric($id_orden) && $this->buscador_model->orden_existente($id_orden)) {
			$imagenes = $this->buscador_model->traer_fotos($id_orden);
			$orden = $this->buscador_model->get_datos_seguimiento($id_orden);
			foreach ($imagenes ? $imagenes : [] as $key => $value) {
				// Nombre de la imagen
				// este path se utliza cuando las fotos se guardan dentro del mismo proyecto de recepcion en el servidor
				$path = base_url().$value['ruta_archivo'];
				// este path se utliza cuando las fotos se guardan dentro de otra ruta del servidor
				//$path ='D:/firmaImg.jpg';
				// Extensión de la imagen
				$type = pathinfo($path, PATHINFO_EXTENSION);
				// Cargando la imagen
				$file = file_get_contents($path);
				// Decodificando la imagen en base64
				$array[$key] = $base64 = 'data:image/' . $type . ';base64,' . base64_encode($file);
		}
			$data['estatus'] = true;
			$data['imagenes'] = $array;
			$data['orden'] = $orden['orden'];
			$data['cliente'] = $orden['cliente']->PersonalNombres.' '.$orden['cliente']->PersonalNombres.' '.$orden['cliente']->PersonalApellidoPaterno.' '.$orden['cliente']->PersonalApellidoMaterno;
		}else {
			$data['estatus'] = false;
		}
		$this->load->view('seguimiento_cliente', $data);
	}
	function base64_decode_url($string) {
		return base64_decode(str_replace(['-','_'], ['+','/'], $string));
	}

}