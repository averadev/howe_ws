<?php
/**
 * GeekBucket 2014
 * Author: Alfredo Chi
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");



class Condominium extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
		$this->load->database('default');
        $this->load->model('condominium_db');
        if ($this->session->userdata('type') != 1) {
            redirect('login');
        }
    }

    /**
     * Despliega la pantalla de dashboard
     */
	public function index($offset = 0){        
        $data['page'] = 'condominium';
		//$data['nameUser'] = $this->session->userdata('username'); 
		//$condominium = $this->condominium_db->getCondominium($this->session->userdata('residencialId'));
		$condominium = $this->sortSliceArray($this->condominium_db->getCondominium($this->session->userdata('residencialId')),10);
		$data['totalM'] = $this->totalArray($this->condominium_db->getCondominium($this->session->userdata('residencialId')));
		
		if (count($condominium) > 0){
			foreach($condominium as $item):
				$resident = $this->condominium_db->getResidentOfCondominium($item->id,$this->session->userdata('residencialId'));
				if(count($resident) > 0){
					$nameResident = $resident[0]->nombre . " " . $resident[0]->apellido;
					if(count($resident) > 1){
						$nameResident = $nameResident . " y otros...";
					}
				}else{
					$nameResident = "";
				}
				$item->residente = $nameResident;
			endforeach;
		}
		
		$data['condominium'] = $condominium;
		
		$this->load->view('vwCondominium',$data);
		
	}
	
	/**
	 * Obtiene los condominios de la residencialId
	 */
	public function getCondominio(){
		if($this->input->is_ajax_request()){
			$data = $this->condominium_db->getCondominium($this->session->userdata('residencialId'));
			if (count($data) > 0){
			foreach($data as $item):
				$resident = $this->condominium_db->getResidentOfCondominium($item->id,$this->session->userdata('residencialId'));
				if(count($resident) > 0){
					$nameResident = $resident[0]->nombre . " " . $resident[0]->apellido;
					if(count($resident) > 1){
						$nameResident = $nameResident . " y otros...";
					}
				}else{
					$nameResident = "";
				}
				$item->residente = $nameResident;
			endforeach;
		}
            echo json_encode($data);
		}
	}
	
	/**
	 * Obtiene los condominios de la residencialId
	 */
	public function getCondominiumSearch(){
		if($this->input->is_ajax_request()){
			$data = $this->condominium_db->getCondominiumSearch($this->session->userdata('residencialId'),$_POST['dato']);
			$total = count($data);
			$data = array_slice($data, 0, 10);
			if (count($data) > 0){
			foreach($data as $item):
				$resident = $this->condominium_db->getResidentOfCondominium($item->id,$this->session->userdata('residencialId'));
				if(count($resident) > 0){
					$nameResident = $resident[0]->nombre . " " . $resident[0]->apellido;
					if(count($resident) > 1){
						$nameResident = $nameResident . " y otros...";
					}
				}else{
					$nameResident = "";
				}
				$item->residente = $nameResident;
			endforeach;
		}
            echo json_encode(array('items' => $data, 'total' => $total ));
		}
	}
	
	/**
	 * Obtiene los condominios de la residencialId
	 */
	public function getCondominiumPaginador(){
		if($this->input->is_ajax_request()){
			$data = $this->condominium_db->getCondominiumSearch($this->session->userdata('residencialId'),$_POST['dato']);
			$data = array_slice($data, $_POST['num'], 10);
			if (count($data) > 0){
				foreach($data as $item):
					$resident = $this->condominium_db->getResidentOfCondominium($item->id,$this->session->userdata('residencialId'));
					if(count($resident) > 0){
						$nameResident = $resident[0]->nombre . " " . $resident[0]->apellido;
						if(count($resident) > 1){
							$nameResident = $nameResident . " y otros...";
						}
					}else{
						$nameResident = "";
					}
					$item->residente = $nameResident;
				endforeach;
			}
            echo json_encode($data);
		}
	}
	
	
	
	/**
	 * obtiene la info del condominio por id
	 */
	public function getCondoById(){
		if($this->input->is_ajax_request()){
			$data = $this->condominium_db->getCondoById($_POST['id'],$this->session->userdata('residencialId'));
            echo json_encode($data);
		}
	}
	
	/**
	 * Obtiene los residentes del condominio
	 */
	public function getResidentByCondominium(){
		if($this->input->is_ajax_request()){
			$data = $this->condominium_db->getResidentOfCondominium($_POST['condominioId'],$this->session->userdata('residencialId'));
            echo json_encode($data);
		}
	}
	
	/**
	 * Obtiene los residentes por residencial
	 */
	public function getResidentByResidential(){
		if($this->input->is_ajax_request()){
			$data = $this->condominium_db->getResidentByResidential($this->session->userdata('residencialId'));
            echo json_encode($data);
		}
	}
	
	/**
	 * Obtiene la info del residente por id
	 */
	public function getResidentById(){
		if($this->input->is_ajax_request()){
			$data = $this->condominium_db->getResidentById($_POST['id']);
            echo json_encode($data);
		}
	}
	
	/**
	 * guarda los datos del condominio
	 */
	public function saveCondominium(){
		if($this->input->is_ajax_request()){
			
			if($_POST['id'] == 0){
				
				$insert = array(
					'nombre'			=> $_POST['name'],
					'residencialId' 	=> $this->session->userdata('residencialId'),
					'status' 			=> 1
				);
				
				$data = $this->condominium_db->insertCodominium($insert);
				$data = "Se ha agregado un nuevo condominio";
			}else{
				
				$update = array(
					'id' 				=> $_POST['id'],
					'nombre'			=> $_POST['name'],
					'residencialId'		=> $this->session->userdata('residencialId')
				);
				
				$data = $this->condominium_db->updateCodominium($update);
				
				$data = "Se ha editado los datos del condominio";
			}
            echo json_encode($data);
		}
	}
	
	/**
	 * Elimina el condominio selecionado
	 */
	public function deleteCondominium(){
		if($this->input->is_ajax_request()){
				
			$update = array(
				'id' 		=> $_POST['id'],
				'residencialId'		=> $this->session->userdata('residencialId'),
				'status'	=> 0
			);
				
			$data = $this->condominium_db->updateCodominium($update);
				
			$data = "Se ha eliminado el condominio";
            echo json_encode($data);
		}
	}
	
	/**
	 * guarda los datos del residente
	 */
	public function saveResident(){
		if($this->input->is_ajax_request()){
			
			if($_POST['id'] == 0){
				
				$insert = array(
					'nombre'			=> $_POST['name'],
					'apellido'			=> $_POST['lastName'],
					'telefono'			=> $_POST['phone'],
					'email'				=> $_POST['email'],
					'status'			=> 1,
					'contrasena'		=> md5($_POST['pass']),
					'condominioId'		=> $_POST['condominioId'],
					'playerId'			=> 0
				);
				
				$data = $this->condominium_db->insertResident($insert);
				$data = "Se ha agregado un nuevo residente";
			}else{
				
				$update = array(
					'id' 				=> $_POST['id'],
					'nombre'			=> $_POST['name'],
					'apellido'			=> $_POST['lastName'],
					'telefono'			=> $_POST['phone'],
					'email'				=> $_POST['email']
					//'contrasena'		=> md5($_POST['pass']),
				);
				
				if($_POST['pass'] != ""){
					$update['contrasena'] = md5($_POST['pass']);
				}
				
				$data = $this->condominium_db->updateResident($update);
				
				$data = "Se ha editado los datos del residente";
			}
            echo json_encode($data);
		}
	}
	
	/**
	 * elimina al residente selecionado
	 */
	public function deleteResident(){
		if($this->input->is_ajax_request()){
				
			$update = array(
				'id' 		=> $_POST['id'],
				'status'	=> 0
			);
				
			$data = $this->condominium_db->updateResident($update);
				
			$data = "Se ha eliminadp el residente";
            echo json_encode($data);
		}
	}
	
	/**
	 * Asigna residentes a condominios por id
	 */
	public function assignResident(){
		if($this->input->is_ajax_request()){
				
			$residentId = json_decode(stripslashes($_POST['ResidentId']));	
			foreach($residentId as $id){
				$data = $this->condominium_db->getResidentAllById($id);
				$item = $data[0];
				$insert = array(
					'nombre'			=> $item->nombre,
					'apellido'			=> $item->apellido,
					'telefono'			=> $item->telefono,
					'email'				=> $item->email,
					'status'			=> 1,
					'contrasena'		=> $item->contrasena,
					'condominioId'		=> $_POST['condominioId'],
					'playerId'			=> 0
				);
				
				$data = $this->condominium_db->insertResident($insert);
			}
            echo json_encode("Residente asignado");
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