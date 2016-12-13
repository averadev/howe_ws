<?php
/**
 * GeekBucket 2014
 * Author: Alfredo Chi
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");



class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
		$this->load->database('default');
        $this->load->model('dashboard_db');
        if ($this->session->userdata('type') != 3) {
            redirect('login');
        }
    }

    /**
     * Despliega la pantalla de dashboard
     */
	public function index($offset = 0){        
        
		$data['page'] = 'dashboard';
		
		$redidencial = $this->sortSliceArray($this->dashboard_db->getResidencialDash(),10);
		$data['totalR'] = $this->totalArray($this->dashboard_db->getResidencialDash());
		
		/*foreach($redidencial as $item){
			$condominium = $this->dashboard_db->getConsominiumByResidencial($item->id);
			$totalUser = 0;
			foreach($condominium as $item2){
				$totalUser = $totalUser + $item2->totalUser;
			}
			$item->totalUsuarios = $totalUser;
		}*/
		
		$data['residencial'] = $redidencial;
		
		$this->load->view('admin/vwDashboard',$data);
		
	}
	
	/**
	 * obtiene la informacion del mensaje o visita por id
	 */
	public function getMessageById(){
		if($this->input->is_ajax_request()){
			
			
			echo json_encode($data);
		}
	} 
	
	/**
	 * obtiene la informacion de los usuarios activos por busqueda
	 */
	public function getInfoActiveUserBySearch(){
		if($this->input->is_ajax_request()){
			$data = $this->dashboard_db->getInfoActiveUserBySearch($_POST['dato'],$_POST['column'],$_POST['order']);
		//	$array = array_slice($data,$_POST['cantidad'], 10);
			//$message = array('items' => $array, 'total' => count($data));
			echo json_encode($data);
		}
	}
	
	/**
	 * obtiene los mensajes por paginador
	 */
	public function getResidencialPaginador(){
		if($this->input->is_ajax_request()){
			$redidencial = $this->dashboard_db->getResidencialDash();
			$redidencial = array_slice($redidencial, $_POST['num'], 10);
			
			/*foreach($redidencial as $item){
				$condominium = $this->dashboard_db->getConsominiumByResidencial($item->id);
				$totalUser = 0;
				foreach($condominium as $item2){
					$totalUser = $totalUser + $item2->totalUser;
				}
				$item->totalUsuarios = $totalUser;
			}*/
			
			echo json_encode($redidencial);
		}
	}
	
	/**
	 * obtiene la informacion de los usuarios activos por busqueda
	 */
	public function getCities(){
		if($this->input->is_ajax_request()){
			$data = $this->dashboard_db->getCities($_POST['dato']);
			echo json_encode($data);
		}
	}
	
	/**
	 * guarda los datos de la residencial
	 */
	public function saveResidential(){
		if($this->input->is_ajax_request()){
			if($_POST['id'] == 0){
				
				$insert = array(
					'nombre'				=> $_POST['nombre'],
					'ciudadesId'			=> $_POST['ciudadesId'],
					'telAdministracion'		=> $_POST['telAdministracion'],
					'telCaseta'				=> $_POST['telCaseta'],
					'telLobby'				=> $_POST['telLobby'],
					'nombreContacto'		=> $_POST['nombreContacto'],
					'telContacto'			=> $_POST['telContacto'],
					'emailContacto'			=> $_POST['emailContacto'],
					'status'				=> 1,
					'requiereFoto'			=> $_POST['requiereFoto']
				);
				
				$data = $this->dashboard_db->insertResidential($insert);
				$data = "Se ha agregado una nueva residencia";
				
			}else{
				
				$update = array(
					'id'					=> $_POST['id'],
					'nombre'				=> $_POST['nombre'],
					'ciudadesId'			=> $_POST['ciudadesId'],
					'telAdministracion'		=> $_POST['telAdministracion'],
					'telCaseta'				=> $_POST['telCaseta'],
					'telLobby'				=> $_POST['telLobby'],
					'nombreContacto'		=> $_POST['nombreContacto'],
					'telContacto'			=> $_POST['telContacto'],
					'emailContacto'			=> $_POST['emailContacto'],
					'requiereFoto'			=> $_POST['requiereFoto']
				);
				
				$data = $this->dashboard_db->updateResidential($update);
				$data = "Se ha editado la informacion de la residencia";
				
			}
			echo json_encode($data);
		}
	}
	
	/**
	 * obtiene la info de la residencial por id
	 */
	public function getResidentialById(){
		if($this->input->is_ajax_request()){
			$data = $this->dashboard_db->getResidentialById($_POST['id']);
			echo json_encode($data);
		}
	}
	
	/**
	 * obtiene las residenciales
	 */
	public function getResidencial(){
		
		$redidencial = $this->sortSliceArray($this->dashboard_db->getResidencialDash(),10);
		$total = $this->totalArray($this->dashboard_db->getResidencialDash());
		
		/*foreach($redidencial as $item){
			$condominium = $this->dashboard_db->getConsominiumByResidencial($item->id);
			$totalUser = 0;
			foreach($condominium as $item2){
				$totalUser = $totalUser + $item2->totalUser;
			}
			$item->totalUsuarios = $totalUser;
		}*/
		echo json_encode(array('items' => $redidencial, 'totalR' => $total));
	}
	
	/**
	 * Elimina la residencia selecionada
	 */
	public function deleteResidencial(){
		if($this->input->is_ajax_request()){
			$delete = array(
				'id'		=> $_POST['id'],
				'status'	=> 0
			);
				
			$data = $this->dashboard_db->updateResidential($delete);
			$data = "Se ha eliminado la residencia";
			echo json_encode($data);
		}
	}
	
	/**
	 * Obtiene la informacion de los administradores de la residencia
	 */
	public function getUserByResidencial(){
		if($this->input->is_ajax_request()){
			$data = $this->dashboard_db->getUserByResidencial2($_POST['residencialId']);
			echo json_encode($data);
		}
	}
	
	/**
	 * Guarda los datos del usuario(empleado)
	 */
	function saveUser(){
		if($this->input->is_ajax_request()){
			if($_POST['id'] == 0){
				
				$insert = array(
					'nombre'				=> $_POST['nombre'],
					'apellidos'				=> $_POST['apellidos'],
					'contrasena'			=> md5($_POST['contrasena']),
					'telefono'				=> $_POST['telefono'],
					'direccion'				=> $_POST['direccion'],
					'ciudad'				=> $_POST['ciudad'],
					'estado'				=> $_POST['estado'],
					'foto'					=> 'avatarUser.png',
					'email'					=> $_POST['email'],
					'catPuestosId'			=> 1,
					'residencialId'			=> $_POST['residencialId'],
					'status'				=> 1
				);
				
				$data = $this->dashboard_db->insertEmpleado($insert);
				$data = "Se ha agregado una nueva administrador de la residencia";
				
			}else{
				
				$update = array(
					'id'				=> $_POST['id'],
					'nombre'			=> $_POST['nombre'],
					'apellidos'			=> $_POST['apellidos'],
					'telefono'			=> $_POST['telefono'],
					'direccion'			=> $_POST['direccion'],
					'ciudad'			=> $_POST['ciudad'],
					'estado'			=> $_POST['estado'],
					'email'				=> $_POST['email']
				);
				
				if($_POST['contrasena'] != ""){
					$update['contrasena'] = md5($_POST['contrasena']);
				}
				
				$data = $this->dashboard_db->updateEmpleado($update);
				$data = "Se ha editado la informacion del administrador";
				
			}
			echo json_encode($data);
		}
	}
	
	/**
	 * Obtiene los datos del empleado selecionado
	 */
	public function getUserById(){
		if($this->input->is_ajax_request()){
			$data = $this->dashboard_db->getUserById($_POST['id']);
			echo json_encode($data);
		}
	}
	
	/**
	 * Obtiene los datos del empleado selecionado
	 */
	public function deleteUser(){
		if($this->input->is_ajax_request()){
			$delete = array(
				'id'		=> $_POST['id'],
				'status'	=> 0
			);
				
			$data = $this->dashboard_db->updateEmpleado($delete);
			$data = "Se ha eliminado el administrador";
			echo json_encode($data);
		}
	}
	
	/////////////////////////////////////////////////////////
	////////////////Default metod////////////////////////////
	/////////////////////////////////////////////////////////
	
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