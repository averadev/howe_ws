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
        if ($this->session->userdata('type') != 1) {
            redirect('login');
        }
    }

    /**
     * Despliega la pantalla de dashboard
     */
	public function index($offset = 0){        
        $data['page'] = 'dashboard';
		//$data['nameUser'] = $this->session->userdata('username'); 
		//$message = $this->dashboard_db->getMessageDash($this->session->userdata('id'),$this->session->userdata('residencialId'));
		
		$message = $this->sortSliceArray($this->dashboard_db->getMessageDash($this->session->userdata('id'),$this->session->userdata('residencialId')),10);
		$data['totalM'] = $this->totalArray($this->dashboard_db->getMessageDash($this->session->userdata('id'),$this->session->userdata('residencialId')));
		
		//var_dump($data['totalM']);
		
		$months = array('', 'Enero','Febrero','Marzp','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
		if (count($message) > 0){
				foreach($message as $item):
					//echo date('N', strtotime($item->fechaHora));
					$fechaD = $dias[date('N', strtotime($item->fechaHora)) - 1];
					$item->dia = $fechaD;
					$item->fechaFormat = date('d', strtotime($item->fechaHora)) . '-' . $months[date('n', strtotime($item->fechaHora))] . '-' . date('Y', strtotime($item->fechaHora));
					$date = date_create($item->fechaHora);
					$item->hora = date_format($date, 'g:i A');
				endforeach;
		}
		$data['message'] = $message;
		
		//$visit = $this->dashboard_db->getVisitDash($this->session->userdata('id'),$this->session->userdata('residencialId'));
		$visit = $this->sortSliceArray($this->dashboard_db->getVisitDash($this->session->userdata('id'),$this->session->userdata('residencialId')),10);
		$data['totalV'] = $this->totalArray($this->dashboard_db->getVisitDash($this->session->userdata('id'),$this->session->userdata('residencialId')));
		
		$months = array('', 'Enero','Febrero','Marzp','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
		if (count($visit) > 0){
				foreach($visit as $item):
					//echo date('N', strtotime($item->fechaHora));
					$fechaD = $dias[date('N', strtotime($item->fechaHora)) - 1];
					$item->dia = $fechaD;
					$item->fechaFormat = date('d', strtotime($item->fechaHora)) . '-' . $months[date('n', strtotime($item->fechaHora))] . '-' . date('Y', strtotime($item->fechaHora));
					$date = date_create($item->fechaHora);
					$item->hora = date_format($date, 'g:i A');
				endforeach;
		}
		$data['visit'] = $visit;
		
		$this->load->view('vwDashboard',$data);
		
	}
	
	/**
	 * obtiene la informacion del mensaje o visita por id
	 */
	public function getMessageById(){
		if($this->input->is_ajax_request()){
			$data = $_POST['typeM'];
			if($_POST['typeM'] == "message"){
				$data = $this->dashboard_db->getMessageById($_POST['id']);
			}else if($_POST['typeM'] == "visit"){
				$data = $this->dashboard_db->getVisitById($_POST['id']);
			}
			
			$months = array('', 'Enero','Febrero','Marzp','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
			$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
			if (count($data) > 0){
				foreach($data as $item):
					//echo date('N', strtotime($item->fechaHora));
					$fechaD = $dias[date('N', strtotime($item->fechaHora)) - 1];
					$item->dia = $fechaD;
					$item->fechaFormat = date('d', strtotime($item->fechaHora)) . '-' . $months[date('n', strtotime($item->fechaHora))] . '-' . date('Y', strtotime($item->fechaHora));
					$date = date_create($item->fechaHora);
					$item->hora = date_format($date, 'g:i A');
				endforeach;
			}
			
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
	public function getMessagePaginador(){
		if($this->input->is_ajax_request()){
			$message = $this->dashboard_db->getMessageDash($this->session->userdata('id'),$this->session->userdata('residencialId'));
			$message = array_slice($message, $_POST['num'], 10);
		
			$months = array('', 'Enero','Febrero','Marzp','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
			$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
			if (count($message) > 0){
				foreach($message as $item):
					//echo date('N', strtotime($item->fechaHora));
					$fechaD = $dias[date('N', strtotime($item->fechaHora)) - 1];
					$item->dia = $fechaD;
					$item->fechaFormat = date('d', strtotime($item->fechaHora)) . '-' . $months[date('n', strtotime($item->fechaHora))] . '-' . date('Y', strtotime($item->fechaHora));
					$date = date_create($item->fechaHora);
					$item->hora = date_format($date, 'g:i A');
				endforeach;
			}
			
			echo json_encode($message);
		}
	}
	
	/**
	 * obtiene las visitas por paginador
	 */
	public function getVisitPaginador(){
		if($this->input->is_ajax_request()){
			$visit = $this->dashboard_db->getVisitDash($this->session->userdata('id'),$this->session->userdata('residencialId'));
			$visit = array_slice($visit, $_POST['num'], 10);
		
			$months = array('', 'Enero','Febrero','Marzp','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
			$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
			if (count($visit) > 0){
				foreach($visit as $item):
					//echo date('N', strtotime($item->fechaHora));
					$fechaD = $dias[date('N', strtotime($item->fechaHora)) - 1];
					$item->dia = $fechaD;
					$item->fechaFormat = date('d', strtotime($item->fechaHora)) . '-' . $months[date('n', strtotime($item->fechaHora))] . '-' . date('Y', strtotime($item->fechaHora));
					$date = date_create($item->fechaHora);
					$item->hora = date_format($date, 'g:i A');
				endforeach;
			}
			
			echo json_encode($visit);
		}
	}
	
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