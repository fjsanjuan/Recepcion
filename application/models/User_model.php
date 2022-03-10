<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*  
*     _____  ____  _____  _________  ________  _____     _____   ______   _____   ______   
*    |_   _||_   \|_   _||  _   _  ||_   __  ||_   _|   |_   _|.' ____ \ |_   _|.' ____ \  
*      | |    |   \ | |  |_/ | | \_|  | |_ \_|  | |       | |  | (___ \_|  | |  | (___ \_| 
*      | |    | |\ \| |      | |      |  _| _   | |   _   | |   _.____`.   | |   _.____`.  
*     _| |_  _| |_\   |_    _| |_    _| |__/ | _| |__/ | _| |_ | \____) | _| |_ | \____) | 
*    |_____||_____|\____|  |_____|  |________||________||_____| \______.'|_____| \______.' 
*                                                                                      
*
*	 Revision: Roberto Ortiz	Abril 2020
*/
class User_model extends CI_Model {

	private $Version = 'V4000';
	/*  ./assets/uploads/fotografias/   o  F:/recepcion_activa/fotografias/  */
	private $dir_fotos = './assets/uploads/fotografias/';

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function login( $data ){
		//var_dump($data);
		$email=$data['usr_email'];
		$query = $this->db->query("SELECT u.id, u.usuario, u.nombre, u.email, u.password, u.salt, u.perfil, u.id_sucursal, s.id_agencia, s.almacen_servicio, s.almacen_refacciones, s.sucursal_int, u.cve_intelisis, u.fordStar FROM usuarios u INNER JOIN sucursal s ON u.id_sucursal = s.id WHERE email=? AND u.eliminado= 0",array($email));
		if ($query->num_rows() > 0){
			$user=$query->row();
			//var_dump($user);
			$mix_password=hash('sha256', $user->salt.$data['usr_password']);

			$this->load->helper("jacksecure_helper");
			if(slowEquals($user->password,$mix_password)){
				return array("status"=>1, "user"=>$user); //Success
			}else
				return array("status"=>-1); //correo/*password incorrectos.
		}else
			return array("status"=>-2); //Usuario inexistente
		return array("status"=>-3);
	}

	function create($data){

		$nombre = $data['nombre_usr'];
		$apellidos = $data['apellido_usr'];
		$email = $data['email_usr'];
		$salt = random_string('alnum', 24);
		$password = $data['password_usr'];
		$password=hash('sha256', $salt.$password);
		$role = $data['rol_usr'];
		$cve_usuario = $data['cve_user'];
		$eliminado = 0;
		$sucursal = $data['sucursal'];

		$usuario= substr(strtolower($nombre), 0, 1) .strtolower($apellidos);
		//validar existe el usuario para que no se empalmen
		$user_ex = $this->user_exist($usuario);
		//var_dump($user_ex);
		//die( 'validando usuario');
		if(is_array($user_ex) ){
			$usuario= substr(strtolower($nombre), -1) . substr(strtolower($apellidos), 0,-1);
		}

		$this->db->trans_begin();
		$this->db->query("INSERT INTO usuarios(usuario, nombre, apellidos, email, salt, password, perfil, eliminado,id_sucursal, cve_intelisis)
			VALUES (?,?,?,?,?,?,?,?,?,?)", 
			array($usuario, $nombre, $apellidos, $email, $salt,$password, $role, $eliminado, $sucursal, $cve_usuario));

		$user_id = $this->db->insert_id();
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $user_id;
		}
	}

	function user_exist($usuario){
		$query = $this->db->query("SELECT usuario FROM usuarios WHERE usuario=?",array($usuario));
		//$this->db->save_queries = TRUE;
		//$str = $this->db->last_query();
		//echo $str;
		if($query->num_rows() > 0){
			return $query->result();
		}else
			return null;
	}

	function datos_cliente($id){
		$this->db2 = $this->load->database('other',true); 
		$query = $this->db2->query(
			"Select Nombre,Telefonos, PersonalTelefonoMovil, email1 , RFC ,Direccion, DireccionNumero, DireccionNumeroInt, Colonia, Poblacion, Estado, CodigoPostal FROM Cte WHERE Cliente = ?", array($id)
		);
		if($query->num_rows() > 0){
			return $query->result_array();
		}else
			return null;
	}

	function datos_vta($id, $datos = 0){
		if($id != 0)
		{
			/*vta.ID, c.cliente,c.Contacto2, c.nombre,c.PersonalTelefonoMovil AS Celular, c.RFC, c.Telefonos, c.TelefonosLada,c.Direccion, c.DireccionNumero,c.Extencion2, c.DireccionNumeroInt, c.Colonia, c.Poblacion, c.Estado, c.CodigoPostal, c.eMail1, vta.Empresa, vta.Almacen, vta.Cliente, vta.Sucursal, vta.Mov, vta.FechaEmision,vta.FechaRequerida, vta.HoraRequerida, vta.UEN, vta.Moneda, vta.Agente, vta.ServicioSerie,c.PersonalNombres,c.PersonalApellidoPaterno,c.PersonalApellidoMaterno */
			$this->db2 = $this->load->database('other',true); 
			$query['datos'] = $this->db2->query("SELECT vta.Mov,
												vta.Empresa,
												vta.Sucursal,
												vta.Almacen,
												vta.ID,
												vta.FechaEmision,
												c.PersonalNombres,
												ISNULL(c.PersonalNombres2,'') AS PersonalNombres2,
												ISNULL(c.PersonalApellidoPaterno,'') AS PersonalApellidoPaterno,
												ISNULL(c.PersonalApellidoMaterno,'') AS PersonalApellidoMaterno,
												c.cliente,
												c.nombre,
												c.PersonalTelefonoMovil AS Celular,
												c.eMail1,
												c.TelefonosLada,
												c.Telefonos,
												c.Extencion2,
												c.Contacto2,
												c.RFC,
												c.Direccion,
												c.DireccionNumero,
												c.DireccionNumeroInt,
												c.Colonia,
												c.Poblacion,
												c.Estado,
												c.CodigoPostal,
												vta.FechaRequerida,
												vta.HoraRequerida,
												vta.Condicion,
												vta.ServicioTipoOrden,
												vta.ServicioTipoOperacion,
												vta.ListaPreciosEsp,
												vta.Concepto,
												vta.Moneda,
												vta.UEN,
												vta.ServicioIdentificador,
												vta.ServicioNumero,
												vta.ZonaImpuesto
											FROM Venta vta 
											INNER JOIN Cte c ON vta.Cliente = c.Cliente 
											WHERE ID = ? " , array($id))->result_array();

			$query['vehiculo'] = $this->db2->query("SELECT vta.ServicioArticulo ,vin.Modelo, vin.Placas, vin.Km, vta.ServicioSerie, 
				vin.ColorExteriorDescripcion 
			FROM Venta vta  INNER JOIN VIN vin ON vta.ServicioSerie = vin.VIN WHERE vta.ID = ?", array($id))->result_array();

			$query['Agente'] = $this->db2->query("Select ag.agente, ag.nombre FROM Venta vta INNER JOIN Agente ag ON ag.Agente = vta.Agente WHERE vta.ID = ?" ,array($id))->result_array();	
		}else
		{
			$this->db2 = $this->load->database('other',true); 
			
			$query['datos'] = $this->db2->select(" '0' as ID, c.cliente,,c.Contacto2, c.nombre,c.PersonalTelefonoMovil AS Celular, c.RFC, c.Telefonos, c.Direccion, c.DireccionNumero, c.TelefonosLada,c.Extencion2,c.DireccionNumeroInt, c.Colonia, c.Poblacion, c.Estado, c.CodigoPostal, c.eMail1, c.Cliente, '".$datos['vin']."' as ServicioSerie,c.PersonalNombres,ISNULL(c.PersonalNombres2,' ') AS 'PersonalNombres2',ISNULL(c.PersonalApellidoPaterno,'') AS 'PersonalApellidoPaterno',ISNULL(c.PersonalApellidoMaterno,'') AS 'PersonalApellidoMaterno' ")->from("Cte c")->where("c.Cliente",$datos['cliente'])->get()->result_array();

			$select = "su.empresa as Empresa, su.almacen_servicio as Almacen, su.sucursal_int as Sucursal, '' as Mov, '' as FechaEmision, '' as FechaRequerida, '' as HoraRequerida, '' as UEN, su.moneda as Moneda, us.cve_intelisis as Agente";

			$query['datos'] += $this->db->select($select)->from("usuarios us")->join("sucursal su", "su.id = us.id_sucursal")->where("us.id", $this->session->userdata("id"))->get()->result_array();

			$query['vehiculo'] = $this->db2->select ("Vin.Articulo as ServicioArticulo ,vin.Modelo, vin.Placas, vin.Km,  vin.Vin as ServicioSerie, vin.ColorExteriorDescripcion")->from("Vin vin")
								->where("vin.Vin", urldecode($datos['vin']))->get()->result_array();

			$query['Agente'] = $this->db2->select("ag.agente, ag.nombre")->from("Agente ag")->where("ag.Agente",$this->session->userdata["logged_in"]["cve_intelisis"])->get()->result_array();	
			$tabla = "MovTipoValidarUEN muv";
			if($this->Version == "V6000")
				$tabla = "CA_MovTipoValidarUEN muv";
			$query['uen'] = $this->db2->select("UEN.Nombre, UEN.UEN, muv.mov")->from("UEN")->join($tabla, "muv.UENValida = UEN.UEN")->where("muv.Mov IN ('Servicio','Cita Servicio')")->where("UEN.Estatus",'ALTA')->get()->result_array();
		}
		$query['Horarios']  = $this->db2->query("SELECT Hora FROM agendahora")->result_array();
		//lo nuevo para campañas
		$tabla = "vinrecalld as vd";
		$tabla2 = "vinrecall vdd";
		if($this->Version == "V6000"){
			$tabla = "CA_vinrecalld as vd";
			$tabla2 = "CA_vinrecall vdd";
		}
		$query['camp'] = $this->db2->select("vdd.Asunto,vdd.Problema, vd.Vigencia,vdd.Prioridad")->from($tabla)->join($tabla2,"vdd.id = vd.id")->where("vd.Estatus","PENDIENTE")
			->where("vd.VIN", $query['vehiculo'][0]['ServicioSerie'])->where("vd.Vigencia >= '".date("d-m-Y")."'")->get()->result_array();


		return $query;
	}

	function update_cli($data){

		$id           = $data['id'];
		$nombre_full  = $data['nombre_cliente'];
		$telefono     = $data['telefono_cliente'];
		$celular      = $data['celular_cliente'];
		$email        = $data['email_usr'];        
		$rfc          = $data['rfc_cliente'];      
		$direccion    = $data['direc_cliente'];    
		$no_ext       = $data['no_ext_cliente'];   
		$no_int       = $data['no_int_cliente'];  
		$colonia      = $data['colonia_cliente'];
		$poblacion    = $data['poblacion_cliente']; 
		$estado       = $data['edo_cliente'];    
		$cp           = $data['cp_cliente'];

		$this->db2 = $this->load->database('other',true);
		
		$this->db2->trans_begin();

		$this->db2->query("UPDATE Cte SET Nombre=?, Telefonos=?, PersonalTelefonoMovil=?, email1=?, RFC=?, Direccion=?, DireccionNumero=?,
		DireccionNumeroInt=?, Colonia=?, Poblacion=?, Estado=?, CodigoPostal=?  WHERE Cliente = ?", 
		array($nombre_full, $telefono, $celular, $email, $rfc, $direccion, $no_ext, $no_int, $colonia, $poblacion, $estado, $cp, $id));

		if ($this->db2->trans_status() === FALSE){
			$this->db2->trans_rollback();
			return false;
		}else{
			$this->db2->trans_commit();
			return true;
		}	

	}

	public function actualizar_datosOrden($datos = null)
	{
		$this->load->model("buscador_model", "buscador");
		$elemento = $datos["tipo_elemento"];

		$this->db2 = $this->load->database('other',true);
		
		switch($elemento) 
		{
			case "cliente":
				$Cte["Nombre"] = $datos["nombre_cliente"];
				$Cte["PersonalTelefonoMovil"] = $datos["cel_cliente"];
				$Cte["eMail1"] = $datos["correo_cliente"];
				$Cte["TelefonosLada"] = $datos["lada_casa"];
				$Cte["Telefonos"] = $datos["telefono_cliente"];
				$Cte["Extencion2"] = $datos["lada_oficina"];
				$Cte["Contacto2"] = $datos["telefono_oficina"];
				$Cte["Direccion"] = $datos["dir_cliente"];
				$Cte["DireccionNumero"] = $datos["numExt_cliente"];
				$Cte["DireccionNumeroInt"] = $datos["numInt_cliente"];
				$Cte["Colonia"] = $datos["colonia_cliente"];
				$Cte["Poblacion"] = $datos["poblacion_cliente"];
				$Cte["Estado"] = $datos["estado_cliente"];
				$Cte["CodigoPostal"] = $datos["cp_cliente"];
				

				/*$bd = $this->db2->database;									//nombre de la bd
				$triggers = $this->buscador->trigger_exist($bd, "Cte");

				if($triggers)
				{
					foreach ($triggers as $key => $value) 
					{
						$trigger_name[$key] = $value->Trigger;

						$ok = $this->buscador->deshabilita_trigger($trigger_name[$key], "Cte", $bd);
					}
				}*/

				$this->db2->trans_start();

				$this->db2->where("Cliente", $datos["id_cliente"]);
				$this->db2->update("Cte", $Cte);

				$this->db2->trans_complete();

				/*if($triggers)
				{
					foreach ($triggers as $key => $value) 
					{
						$trigger_name[$key] = $value->Trigger;

						$hab_ok = $this->buscador->habilita_triggers($trigger_name[$key], "Cte", $bd);
						
						if($hab_ok === FALSE)
						{
							return false;
						}
					}
				}*/
			break;
			case "vehiculo":
				$vin["Placas"] = $datos["placas_cliente"];
				$vin["ColorExteriorDescripcion"] = $datos["color_cliente"];
				$vin["Km"] = $datos["kms_cliente"];
				
				$this->db2->trans_start();
				
				$this->db2->where("VIN", $datos["vin_cliente"]);
				$this->db2->update("VIN", $vin);

				$this->db2->trans_complete();
			break;
			case "listasOrden":
				$orden["Condicion"] = $datos["condicion_cliente"];
				$orden["ServicioTipoOrden"] = $datos["tipoorden_cliente"];
				$orden["ServicioTipoOperacion"] = $datos["tipooperacion_cliente"];
				$orden["ListaPreciosEsp"] = $datos["tipoprecio_cliente"];
				$orden["Concepto"] = $datos["concepto_cliente"];
				$orden["Moneda"] = $datos["moneda_cliente"];
				$orden["ZonaImpuesto"] = $datos["ZonaImpuesto_select"];
				$orden["UEN"] = $datos["tipouen_cliente"];
				$orden["ServicioIdentificador"] = $datos["tipotorre"];
				$orden["ServicioNumero"] = $datos["torrenumero"];
				$orden["Comentarios"] = $datos["comentcliente"];
				//$formato = $datos["fecha_promesa_cliente"];
				$formato =date("d-m-Y", strtotime($datos["fecha_promesa_cliente"]));
				//print_r($formato); die();
				$orden["FechaRequerida"] = $formato;
				$orden["HoraRequerida"] = $datos["hora_promesa_cliente2"];

				$this->db2->trans_start();
				
				$this->db2->where("id", $datos["id_servicio"]);
				$this->db2->update("venta", $orden);

				$this->db2->trans_complete();
			break;
			default:
				return false;
			break;
		}

		if ($this->db2->trans_status() === FALSE)
		{
			return false;
		}else
		{
			return true;
		}	
	}

	public function buscar_claveCliente($id_cita = null)
	{
		$this->db2 = $this->load->database('other',true);
		
		$this->db2->trans_begin();

		$clave = $this->db2->select("Cliente")
						   ->from("Venta")
						   ->where("ID", $id_cita)
						   ->get()->row_array();
		
		$this->db2->trans_commit();
						   
		return $clave;				   
	}

	public function existe_ordenCita($cliente = null,$vin = null,$movId = null)
	{
		$this->db->trans_begin();

		$res = $this->db->select(" dbo.existeOrdenCita('$cliente','$vin','$movId') res")->get()->row_array();
		
		$this->db->trans_commit();
						   
		return $res;				   
	}

	public function crear_ordenServicio($datos = null)
	{
		if($datos['id_cita'] == 0){
			$clave_cliente['Cliente'] = $datos['cliente'];
			$clave_cliente['vin'] = $datos['vin'];
			$clave_cliente['no_cita'] = $datos['no_cita'];
		}
		else
			$clave_cliente = $this->buscar_claveCliente($datos["id_cita"]);

			$orden_servicio["cliente"] = $clave_cliente["Cliente"];
			$orden_servicio["vin"] = $datos["vin"];
			$orden_servicio["num_cita"] = $datos["no_cita"]; 						//es el movID
			$orden_servicio["fecha_creacion"] = date("d-m-Y H:i:s");
			$orden_servicio["fecha_actualizacion"] = date("d-m-Y H:i:s");
			$orden_servicio["eliminado"] = 0;

			
			$existe = $this->existe_ordenCita($clave_cliente["Cliente"],$datos["vin"],$datos["no_cita"]);

			if($existe['res'] == NULL){

				$this->db->trans_start();

				$this->db->insert("orden_servicio", $orden_servicio);
				$id_orden = $this->db->select("IDENT_CURRENT('orden_servicio') as id")->get()->row_array();

				$this->db->trans_complete();

				if($this->db->trans_status() == true)
				{
					$orden["estatus"] = true;
					$orden["datos"]["id"] = $id_orden["id"];
				}
				else
				{
					$orden["estatus"] = false;
					$orden["datos"] = [];
				}
			}
			else{
				$orden["estatus"] = true;
				$orden["datos"]["id"] = $existe["res"];
			}


		return $orden;
	}

	public function nueva_ordenServicio($datos = null)
	{
		if($datos['id_cita'] == 0){
			$clave_cliente['Cliente'] = $datos['cliente'];
			$clave_cliente['vin'] = $datos['vin'];
			$clave_cliente['no_cita'] = $datos['no_cita'];
		}
		else
			$clave_cliente = $this->buscar_claveCliente($datos["id_cita"]);

		$orden_servicio["cliente"] = $clave_cliente["Cliente"];
		$orden_servicio["vin"] = $datos["vin"];
		$orden_servicio["num_cita"] = $datos["no_cita"]; 						//es el movID
		$orden_servicio["fecha_creacion"] = date("d-m-Y H:i:s");
		$orden_servicio["fecha_actualizacion"] = date("d-m-Y H:i:s");
		$orden_servicio["eliminado"] = 0;

		$this->db->trans_start();

		$this->db->insert("orden_servicio", $orden_servicio);
		$id_orden = $this->db->select("IDENT_CURRENT('orden_servicio') as id")->get()->row_array();

		$this->db->trans_complete();

		if($this->db->trans_status() == true)
		{
			$orden["estatus"] = true;
			$orden["datos"]["id"] = $id_orden["id"];
		}else
		{
			$orden["estatus"] = false;
			$orden["datos"] = [];
		}

		return $orden;
	}

	public function guardar_firma($datos = null)
	{
		$existe_firma = $this->db->select("*")
								 ->from("firma_electronica")
								 ->where("id_orden_servicio", $datos["id_orden_servicio"])
								 ->count_all_results();

		$firma["firma"] = $datos["valor_firma"];
		$firma["firma_formatoInventario"] = $datos["valor_firma2"];
		$firma["firma_renunciaGarantia"] = $datos["valor_firma3"];					 
		$firma["fecha_actualizacion"] = date("d-m-Y H:i:s");

		if($existe_firma == 0)
		{
			$firma["id_orden_servicio"] = $datos["id_orden_servicio"];			
			$firma["fecha_creacion"] = date("d-m-Y H:i:s");			
			$firma["eliminado"] = 0;

			$this->db->trans_start();

			$this->db->insert("firma_electronica", $firma);

			$this->db->trans_complete();
		}else 
		{
			$this->db->where("id_orden_servicio", $datos["id_orden_servicio"]);
			$this->db->where("eliminado", 0);
			$this->db->update("firma_electronica", $firma);
		}						 		

		if($this->db->trans_status() == true)
		{
			$firma_creada = true;
			// registro de aprobacion del cte termins y condicions
			$orden['acepta_termCond'] = $datos["cb_termCond"];	
			$orden['fecha_termCond'] = date("d-m-Y H:i:s");	
			$this->db->where("id", $datos["id_orden_servicio"]);
			$this->db->update("orden_servicio", $orden);
		}else
		{
			$firma_creada = false;
		}

		return $firma_creada;	
	}

	/*public function crear_archivo($datos = null)
	{
		$archivo = $datos["input_vista_previa"];
		$datos["vin"] = trim($datos["vin"]);
		$archivo = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $archivo));
		$ruta = 'C:/recepcion_activa/fotografias/'.$datos["vin"].'/'.$datos["id_orden_servicio"].'/img'.$datos["id"].'.jpg';

		if(!file_exists('C:/recepcion_activa/fotografias/'.$datos["vin"].'/'.$datos["id_orden_servicio"])) 
        {
            mkdir('C:/recepcion_activa/fotografias/'.$datos["vin"].'/'.$datos["id_orden_servicio"], 0777, true);
        }

        file_put_contents($ruta, $archivo);

        if(file_exists($ruta)) 
        {
        	$ruta_a["ruta_archivo"] = $ruta;
        	$ruta_a["fecha_actualizacion"] = date("d-m-Y H:i:s");

            $this->db->where("id", $datos["id"]);
            $this->db->update("archivo", $ruta_a);

            $creado = true;
        }else
        {
        	$creado = false;
        }

        return $creado;
	}*/

	public function crear_archivo($datos = null)
	{
		$archivo = $datos["imagen"];
		$datos["vin"] = trim($datos["vin"]);
		$ruta = $this->dir_fotos.$datos["vin"].'/'.$datos["id_orden_servicio"].'/img'.$datos["id"].'.jpg'; 

		if(!file_exists($this->dir_fotos.$datos["vin"].'/'.$datos["id_orden_servicio"])) 
        {
            mkdir($this->dir_fotos.$datos["vin"].'/'.$datos["id_orden_servicio"], 0777, true);
        }

        $nombrearchivo = $archivo["name"];
		move_uploaded_file($archivo["tmp_name"], $ruta);

        if(file_exists($ruta)) 
        {
        	$ruta_a["ruta_archivo"] = $ruta;
        	$ruta_a["fecha_actualizacion"] = date("d-m-Y H:i:s");

        	$this->db->trans_start();

            $this->db->where("id", $datos["id"]);
            $this->db->update("archivo", $ruta_a);

            $this->db->trans_complete();

            if($this->db->trans_status() == true)
            {
            	$creado = true;
            }else 
            {
            	$creado = false;
            }           
        }else
        {
        	$creado = false;
        }

        return $creado;
	}

	/*public function guardar_foto($datos = null)
	{
		$datos["vin"] = trim($datos["vin"]);
		$archivo["id_orden_servicio"] = $datos["id_orden_servicio"];	//DE PRUEBA
		$archivo["tipo_archivo"] = 1;
		$archivo["fecha_creacion"] = date("d-m-Y H:i:s");
		$archivo["fecha_actualizacion"] = date("d-m-Y H:i:s");
		$archivo["eliminado"] = 0;
		$archivo["comentario"] = $datos['form_foto_f'];

		//se hace un clico para guardar las fotos que trae el form 
		$datos2=$datos;
		for($i=0;$i<sizeof($datos["input_vista_previa"]);$i++){
			$datos2["input_vista_previa"]=$datos["input_vista_previa"][$i];
			$this->db->trans_start();

			$this->db->insert("archivo", $archivo);
			$id_registro = $this->db->select("IDENT_CURRENT('archivo') as id")->get()->row_array();

			$this->db->trans_complete();

			if($this->db->trans_status() == true)
			{
				$datos2["id"] = $id_registro["id"];
				$archivo_creado = $this->crear_archivo($datos2);

				$file = ($archivo_creado) ? true : false;
			}else
			{
				$file = false;
			}
		}

		return $file;
	}*/

	public function guardar_foto($datos = null)
	{
		$datos["vin"] = trim($datos["vin"]);
		$archivo["id_orden_servicio"] = $datos["id_orden_servicio"];	//DE PRUEBA
		$archivo["tipo_archivo"] = 1;
		$archivo["fecha_creacion"] = date("d-m-Y H:i:s");
		$archivo["fecha_actualizacion"] = date("d-m-Y H:i:s");
		$archivo["eliminado"] = 0;
		$archivo["comentario"] = $datos['form_foto_f'];

		//se hace un clico para guardar las fotos que trae el form 
		$datos2=$datos;
		$imagenes = $_FILES;
		foreach($imagenes as $key => $value) 
		{
			$this->db->trans_start();

			$this->db->insert("archivo", $archivo);
			$id_registro = $this->db->select("IDENT_CURRENT('archivo') as id")->get()->row_array();

			$this->db->trans_complete();

			if($this->db->trans_status() == true)
			{
				$datos2["imagen"] = $value;
				$datos2["id"] = $id_registro["id"];
				$archivo_creado = $this->crear_archivo($datos2);

				$file = ($archivo_creado) ? true : false;
			}else
			{
				$file = false;
			}
		}

		return $file;
	}

	public function ver_datosUsuario($id_usuario = null)

	{
		$datos = $this->db->select("usuario, nombre, apellidos, email, cve_intelisis, firma_electronica, perfil.perfil, fordStar")
						  ->join("perfil", "usuarios.perfil = perfil.id")
						  ->from("usuarios")
						  ->where("usuarios.id", $id_usuario)
						  ->where("usuarios.eliminado", 0)
						  ->where("perfil.eliminado", 0)
						  ->get()->row_array();

		return $datos;
	}

	public function guardar_configPerfil($datos = null)
	{
		$salt = random_string("alnum", 24);
		$password = hash("sha256", $salt.$datos["pass_usu"]);

		$usuarios["nombre"] = $datos["nombre_usu"];
		$usuarios["apellidos"] = $datos["apellidos_usu"];
		$usuarios["firma_electronica"] = $datos["firma_usu"];
		if($datos["pass_usu"] != "")
		{
			$usuarios["salt"] = $salt;
			$usuarios["password"] = $password;
		}
		//Ford star   --------------->>>>>
		$fordStar =  isset($datos["cve_fordStar"]) ? $datos["cve_fordStar"] : '';
		if( $fordStar != "")
		{
			//$usuarios["fordStar"] = $datos["cve_fordStar"];
			$usuarios["fordStar"] = $fordStar;
		}
		//--------------->>>>>>>>>
		$usuarios["actualizado"] = date("d-m-Y H:i:s");

		$this->db->trans_start();

		$this->db->where("id", $this->session->userdata["logged_in"]["id"]);
		$this->db->update("usuarios", $usuarios);

		$this->db->trans_complete();
		
		if($this->db->trans_status() == true)
		{
			$estatus = true;
			$logged_in = $this->session->userdata["logged_in"];
			$logged_in['fordStar'] = $fordStar;
			$this->session->set_userdata('logged_in', $logged_in);
		}else 
		{
			$estatus = false;
		}

		return $estatus;
	}

	public function revisar_email($data = null)
	{

		$this->db2 = $this->load->database('other',true); 
		$ret = $this->db2->select("*")->from("CorreoNoValidoFord")->where("Email", $data['email'])->count_all_results();
		return $ret;
	}

	public function total_fotos($data = null)
	{
		$this->db->trans_begin();
		$res = $this->db->select("*")->from("archivo")->where("id_orden_servicio", $data['id_orden_servicio'])->where("tipo_archivo",1)->count_all_results();
		$this->db->trans_commit();
						   
		return $res;	
	}
}
