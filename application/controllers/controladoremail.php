<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 class Controladoremail extends CI_Controller {
 
    public function index()
    {
        
    }
    public function obtener_url_adjunto()
    {
        $ruta='./assets/uploads/adjunto/'.$this->session->userdata('session_id');        
        $total_imagenes = count(glob($ruta.'/'.'/{*.jpg,*.gif,*.png,*.jpeg,*.pdf,*.docx,*.doc,*.xls,*.xlsx}',GLOB_BRACE));
        if($total_imagenes>0)
        {
            $files_u = get_filenames('./assets/uploads/adjunto/'.$this->session->userdata('session_id').'/thumbnail/');
            sort($files_u);
            $files = get_filenames('./assets/uploads/adjunto/'.$this->session->userdata('session_id').'/');
            sort($files);
            $imagen = array_shift($files);                        
            $data1['ruta'] = "assets/uploads/adjunto/".$this->session->userdata('session_id');
            $data1['imagen']=$imagen;
        }
        else
        {
            $data1['imagen'] ="";
            $data1['ruta']="";
        }        
        return $data1;

    }
    public function mandar_pedido($id_pedido = null) 
    {
        $adjunto=$this->obtener_url_adjunto();        
        $this->load->model('buscador_model');
        $data = $this->prospeccion_model->imprimir_pedido($id_pedido);
        $data2 = $this->prospeccion_model->datos_sucursal($data['sucursal']['id'], $id_pedido);
        $html = $this->load->view('pedido_pdf', $data, true);
        $this->load->helper('file'); 
        $this->load->helper(array('dompdf', 'file'));
        $pdf = pdf_create($html, '', false);
        // write_file('C:/wamp/www/CRM/assets/archivos/temporales/pedido'.$this->session->userdata("id_suc").$this->session->userdata("id_usuario")."pdf", $pdf); linea para escribir en disco el pdf
        $datos_post = $this->input->post();
        $this->load->library('My_PHPMailer');
        $mail = new PHPMailer();
        $mail->IsSMTP(); // establecemos que utilizaremos SMTP
        $mail->SMTPAuth   = true; // habilitamos la autenticación SMTP
        $mail->SMTPSecure = "ssl";  // establecemos el prefijo del protocolo seguro de comunicación con el servidor
        $mail->Host       = "192.168.41.236";      // establecemos GMail como nuestro servidor SMTP
        $mail->Port       = 465;                   // establecemos el puerto SMTP en el servidor de GMail
        $mail->Username   = "sistema@intelisis-solutions.com";  // la cuenta de correo GMail
        $mail->Password   = "sis2009";            // password de la cuenta GMail
        $mail->CharSet = 'UTF-8';
        $mail->SetFrom('sistema@intelisis-solutions.com', $data['sucursal']['nom']);  //Quien envía el correo
        $mail->AddReplyTo("sistema@intelisis-solutions.com",$data['sucursal']['nom']);  //A quien debe ir dirigida la respuesta
        $mail->Subject    = "Envio de pedido";  //Asunto del mensaje
        $mail->IsHTML(true);
        $mail->Body      = "<p>".$datos_post['comentario_email']."</p>"
                        .    "<br><br><br><br><br>"
                        .    "<b>Datos de Contacto</b>"
                        .    "<br><b>Agencia: </b>".$data['sucursal']['nom']
                        .    "<br><b>Telefono en la Agencia: </b> ".$data2['datos_complementarios']['numero']
                        .    "<br><b>Asesor de ventas: </b>".$data['pedido_formato']['firma_ejecutivo']
                        .    "<br><b>Telefono de asesor: </b>".$data2['datos_vendedor']['telefono']
                        .    "<br><b>Correo Electronico de asesor: </b>".$data2['datos_vendedor']['email']
                        .    "<br><br><b>NOTA: Este correo no es monitoreado por nadie favor de no contestar al mismo <br>"
                        .    "Favor de contestar a los datos de Contacto, de lo contrario puede que nunca tenga respuesta.</b>";
        // $archivo = $_SERVER['DOCUMENT_ROOT']."CRM/assets/"; //ruta del archivo en caso de que se saque de disco duro
        $mail->AddStringAttachment($pdf, 'Pedido Unidad.pdf');// adjuntar un archico desde archivo sin que este escrito en disco        
        
        if ($adjunto['imagen']!="")
        {
            $extension=explode(".", $adjunto['imagen']);            
            $mail->AddAttachment($adjunto['ruta']."/".$adjunto['imagen'], "adjunto.".$extension[1]);// adjuntar un archico desde archivo sin que este escrito en disco
        }
        $mail->AddCC($data2['datos_vendedor']['email']);

        if($data2['regimen'] == "fisica")
        {
            if($data2['cliente']['email_principal'] == "" || $data2['cliente']['email_principal'] == null)
            {
                $data1['saved'] = "ko";
                $data1['mensaje'] = "Este prospecto no cuenta con un correo electronico establecido favor de llenar el campo de email para poder mandar un correo";
            }else
            {
                $mail->AddAddress($data2['cliente']['email_principal'], $data2['cliente']['nombre']); //direccion de correo a la que se mandara el correo
                if(!$mail->Send()) {
                    $data1["mensaje"] = "Error en el envío: " . $mail->ErrorInfo;
                    $data1['saved'] = "ko";
                } else {
                    $data1["mensaje"] = "¡Mensaje enviado correctamente!";
                    $data1['saved'] = "ok";
                }        
            }
            
        }else
        {
            if(($data2['cliente']['email_principal'] == "" || $data2['cliente']['email_principal'] == null) && ( $data2['cliente']['email_contacto'] == "" ||  $data2['cliente']['email_contacto'] == null))
            {
                $data1['saved'] = "ko";
                $data1['mensaje'] = "Este prospecto no cuenta con un correo electronico establecido favor de llenar el campo de email para poder mandar un correo";
            }else
            {
                if($data2['cliente']['email_principal'] != "" || $data2['cliente']['email_principal'] != null)
                {
                    $mail->AddAddress($data2['cliente']['email_principal'], $data2['cliente']['nombre']); //direccion de correo a la que se mandara el correo
                    if(!$mail->Send()) {
                        $data1["mensaje"] = "Error en el envío: " . $mail->ErrorInfo;
                        $data1['saved'] = "ko";
                    } else {
                        $data1["mensaje"] = "¡Mensaje enviado correctamente!";
                        $data1['saved'] = "ok";
                    }        
                }
                $mail->ClearAddresses();
                if($data2['cliente']['email_contacto'] != "" ||  $data2['cliente']['email_contacto'] != null)
                {
                    $mail->AddAddress($data2['cliente']['email_contacto'], $data2['cliente']['nombre_contacto']); //direccion de correo a la que se mandara el correo
                    if(!$mail->Send()) {
                        $data1["mensaje"] = "Error en el envío: " . $mail->ErrorInfo;
                        $data1['saved'] = "ko";
                    } else {
                        $data1["mensaje"] = "¡Mensaje enviado correctamente!";
                        $data1['saved'] = "ok";
                    }           
                }
                
            } 
        }
        $this->eliminar_dir($adjunto['ruta']);
        echo json_encode($data1);
    }
}
?>