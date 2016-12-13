<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

//require APPPATH.'/libraries/REST_Controller.php';


/**
 * The Saving coupon
 * Author: Alberto Vera Espitia
 * GeekBucket 2014
 *
 */
class Login extends CI_Controller {

	public function __construct(){
        parent::__construct();
		$this->load->helper('url');
		$this->load->database('default');
		$this->load->model('admin_user_db');
    }

	public function index(){
		$this->load->view('admin/vwLogin');
		/*if ($this->session->userdata('type') == 1) {
            redirect('home');
        }elseif($this->session->userdata('type') == 2){
			redirect('admin/dashboard');
		} else {
            $this->load->view('partner/vwLogin');
        }*/
    }
	
	/*/
	 * verificamos usuario y contraseña
	 */
	public function checkLogin(){
        if($this->input->is_ajax_request()){
			$data = $this->admin_user_db->get(array('email' => $_POST['email'], 'contrasena' => md5($_POST['password']), 'catPuestosId' => 1 ));
			//$data2 = $this->admin_user_db->getAdmin(array('email' => $_POST['email'], 'password' => md5($_POST['password'])));
			
			if(count($data)>0){
				$this->session->set_userdata(array(
                    'id'	 			=> $data[0]->id,
                    'email' 			=> $data[0]->email,
					'username' 			=> $data[0]->nombre . " " . $data[0]->apellidos,
					'residencialId' 	=> $data[0]->residencialId,
					'type' 				=> 1
                ));
				echo json_encode(array('success' => true, 'message' => 'Acceso satisfactorio.', 'type' => 1));
			}else {
				echo json_encode(array('success' => false, 'message' => 'El usuario y/o password es incorrecto.'));
			}
					
        }
    }
	
	public function logout() {
        $this->session->unset_userdata('id');
		$this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
		$this->session->unset_userdata('residencialId');
		$this->session->unset_userdata('type');
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect('login');
    }
	
	//genera la nueva contraseña
	public function getRandomCode(){
        $an = "ABCDEFGHJKLMNPQRSTUVWXYZ123456789";
        $su = strlen($an) - 1;
        return substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
				substr($an, rand(0, $su), 1) .
				substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1);
    }
	
}