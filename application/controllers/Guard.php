<?php
/**
 * GeekBucket 2014
 * Author: Alfredo Chi
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");



class Guard extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
		$this->load->database('default');
        $this->load->model('guard_db');
        if ($this->session->userdata('type') != 1) {
            redirect('login');
        }
    }

    /**
     * Despliega la pantalla de dashboard
     */
	public function index($offset = 0){        
        $data['page'] = 'guard';
		//$data['nameUser'] = $this->session->userdata('username'); 
		//$guard = $this->guard_db->getGuard($this->session->userdata('residencialId'));
		
		$guard = $this->sortSliceArray($this->guard_db->getGuard($this->session->userdata('residencialId')),10);
		$data['totalG'] = $this->totalArray($this->guard_db->getGuard($this->session->userdata('residencialId')));
		
		$data['guard'] = $guard;
		
		$this->load->view('vwGuard',$data);
		
	}
	
	/**
	 * Obtiene los condominios de la residencialId
	 */
	public function getGuardSearch(){
		if($this->input->is_ajax_request()){
			$data = $this->guard_db->getGuardSearch($this->session->userdata('residencialId'),$_POST['dato']);
			$total = count($data);
			$data = array_slice($data, 0, 10);
			echo json_encode(array('items' => $data, 'total' => $total ));
		}
	}
	
	/**
	 * Obtiene los condominios de la residencialId
	 */
	public function getGuardPaginador(){
		if($this->input->is_ajax_request()){
			$data = $this->guard_db->getGuardSearch($this->session->userdata('residencialId'),$_POST['dato']);
			$data = array_slice($data, $_POST['num'], 10);
            echo json_encode($data);
		}
	}
	
	/**
	 * obtiene la info del condominio por id
	 */
	public function getGuardById(){
		if($this->input->is_ajax_request()){
			$data = $this->guard_db->getGuardById($_POST['id'],$this->session->userdata('residencialId'));
            echo json_encode($data);
		}
	}
	
	/**
	 * Sube la imagen al servidor
	 */
	public function uploadImage(){
		
		$ruta = $_POST['ruta'];
		
		if($_POST['nameImage'] != "0"){
			$nombreTimeStamp = $_POST['nameImage'];
		} else {
			$fecha = new DateTime();
        	$nombreTimeStamp = "guardia_" . $fecha->getTimestamp();
		}
		
  		foreach ($_FILES as $key) {
    		if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
      			$nombre = $key['name'];//Obtenemos el nombre del archivo
      			$temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
      			$tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
				$tipo = $key['type']; //obtenemos el tipo de imagen
				
				$extencion = explode(".", $nombre);
				$nombreTimeStamp = $nombreTimeStamp . "." . $extencion[count($extencion)-1];
				
				move_uploaded_file($temporal, $ruta . $nombreTimeStamp);
				
				echo $nombreTimeStamp;
				
    		}else{
    		}
		}
		
	}
	
	/**
	 * guarda los datos del condominio
	 */
	public function saveGuard(){
		if($this->input->is_ajax_request()){
			
			if($_POST['id'] == 0){
				
				$insert = array(
					'nombre'			=> $_POST['nombre'],
					'apellidos'			=> $_POST['apellidos'],
					'contrasena'		=> md5($_POST['contrasena']),
					'telefono'			=> $_POST['telefono'],
					'direccion'			=> $_POST['direccion'],
					'ciudad'			=> $_POST['ciudad'],
					'estado'			=> $_POST['estado'],
					'foto'				=> $_POST['foto'],
					'email'				=> $_POST['email'],
					'catPuestosId'		=> 2,
					'residencialId' 	=> $this->session->userdata('residencialId'),
					'status'			=> 1
				);
				
				$data = $this->guard_db->insertGuard($insert);
				$data = "Se ha agregado un nuevo guardia";
			}else{
				
				$update = array(
					'id'				=> $_POST['id'],
					'nombre'			=> $_POST['nombre'],
					'apellidos'			=> $_POST['apellidos'],
					'telefono'			=> $_POST['telefono'],
					'direccion'			=> $_POST['direccion'],
					'ciudad'			=> $_POST['ciudad'],
					'estado'			=> $_POST['estado'],
					'foto'				=> $_POST['foto'],
					'email'				=> $_POST['email'],
				);
				
				if($_POST['contrasena'] != ""){
					$update['contrasena'] = md5($_POST['contrasena']);
				}
				
				$data = $this->guard_db->updateGuard($update);
				
				$data = "Se ha editado los datos del guardia";
			}
            echo json_encode($data);
		}
	}
	
	/**
	 * obtiene la info del condominio por id
	 */
	public function deleteGuard(){
		if($this->input->is_ajax_request()){
			$data = $this->guard_db->deleteGuard($_POST['id'],$this->session->userdata('residencialId'));
            echo json_encode("El guardia ha sido dado de baja.");
		}
	}
	
	/*********************************/
	/********Metodos genericos********/
	/*********************************/
	
	/**
     * Obtiene un array sorting and sliced
     */
    public function sortSliceArray($array, $count){
		//slice
        if (count($array) > $count){
            $array = array_slice($array, 0, $count);
        }
        return $array;
    }
	
	public function totalArray($array){
        $array = count($array);
        return $array;
    }
	
}