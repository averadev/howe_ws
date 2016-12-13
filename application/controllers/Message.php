<?php
/**
 * GeekBucket 2014
 * Author: Alfredo Chi
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");



class Message extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
		$this->load->database('default');
        $this->load->model('message_db');
        if ($this->session->userdata('type') != 1) {
            redirect('login');
        }
    }

    /**
     * Despliega la pantalla de dashboard
     */
	public function index($offset = 0){        
        $data['page'] = 'message';
		//$data['nameUser'] = $this->session->userdata('username'); 
		//$message = $this->message_db->getMessageGuard($this->session->userdata('id'),$this->session->userdata('residencialId'));
		$message = $this->sortSliceArray($this->message_db->getMessageGuard($this->session->userdata('id'),$this->session->userdata('residencialId')),10);
		$data['totalM'] = $this->totalArray($this->message_db->getMessageGuard($this->session->userdata('id'),$this->session->userdata('residencialId')));
		
		$months = array('', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
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
		
		/*$visit = $this->message_db->getVisitDash($this->session->userdata('id'),$this->session->userdata('residencialId'));
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
		$data['visit'] = $visit;*/
		
		$this->load->view('vwMessage',$data);
		
	}
	
	/**
	 * obtiene la informacion del mensaje o visita por id
	 */
	public function getMessageById(){
		if($this->input->is_ajax_request()){
			$data = $_POST['typeM'];
			if($_POST['typeM'] == "message"){
				$data = $this->message_db->getMessageById($_POST['id']);
			}else if($_POST['typeM'] == "visit"){
				$data = $this->message_db->getVisitById($_POST['id']);
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
	
	public function getMessageByDate(){
		if($this->input->is_ajax_request()){
			
			$data = $this->message_db->getMessageByDate($this->session->userdata('residencialId'), $_POST['iniDate'], $_POST['endDate']);
			$total = count($data);
			$data = array_slice($data, 0, 10);
			$months = array('', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
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
			
			echo json_encode(array('items' => $data, 'total' => $total ));
		}
	}
	
	public function getMessagePaginador(){
		if($this->input->is_ajax_request()){
			
			$data = $this->message_db->getMessageByDate($this->session->userdata('residencialId'), $_POST['iniDate'], $_POST['endDate']);
			$data = array_slice($data, $_POST['num'], 10);
			
			$months = array('', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
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