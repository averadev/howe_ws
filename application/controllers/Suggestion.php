<?php
/**
 * GeekBucket 2014
 * Author: Alfredo Chi
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");



class Suggestion extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
		$this->load->database('default');
        $this->load->model('suggestion_db');
        if ($this->session->userdata('type') != 1) {
            redirect('login');
        }
    }

    /**
     * Despliega la pantalla de dashboard
     */
	public function index($offset = 0){        
        $data['page'] = 'suggestion';
		$suggestion = $this->sortSliceArray($this->suggestion_db->getComplaintsSuggestions($this->session->userdata('id'),$this->session->userdata('residencialId')),10);
		$data['totalM'] = $this->totalArray($this->suggestion_db->getComplaintsSuggestions($this->session->userdata('id'),$this->session->userdata('residencialId')));
		
		$months = array('', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
		if (count($suggestion) > 0){
				foreach($suggestion as $item):
					$fechaD = $dias[date('N', strtotime($item->fechaHora)) - 1];
					$item->dia = $fechaD;
					$item->fechaFormat = date('d', strtotime($item->fechaHora)) . '-' . $months[date('n', strtotime($item->fechaHora))] . '-' . date('Y', strtotime($item->fechaHora));
					$date = date_create($item->fechaHora);
					$item->hora = date_format($date, 'g:i A');
				endforeach;
		}
		$data['suggestion'] = $suggestion;
		
		$this->load->view('vwSuggestion',$data);
	}
	
	/**
	 * obtiene la informacion del mensaje o visita por id
	 */
	public function getSuggestionById(){
		if($this->input->is_ajax_request()){
			$data = $this->suggestion_db->getSuggestionById($_POST['id']);
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
	
	public function getSuggestionByDate(){
		if($this->input->is_ajax_request()){
			
			$data = $this->suggestion_db->getSuggestionByDate($this->session->userdata('residencialId'), $_POST['iniDate'], $_POST['endDate']);
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
	
	public function getSuggestionPaginador(){
		if($this->input->is_ajax_request()){
			
			$data = $this->suggestion_db->getSuggestionByDate($this->session->userdata('residencialId'), $_POST['iniDate'], $_POST['endDate']);
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