<?php
/**
 * GeekBucket 2014
 * Author: Alfredo Chi
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");



class Visit extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
		$this->load->database('default');
        $this->load->model('visit_db');
        if ($this->session->userdata('type') != 1) {
            redirect('login');
        }
    }

    /**
     * Despliega la pantalla de visitas
     */
	public function index($offset = 0){        
        $data['page'] = 'visit';
		//$data['nameUser'] = $this->session->userdata('username'); 
		//$visit = $this->visit_db->getVisitOfResidential($this->session->userdata('residencialId'));
		
		$visit = $this->sortSliceArray($this->visit_db->getVisitOfResidential($this->session->userdata('residencialId')),10);
		$data['totalV'] = $this->totalArray($this->visit_db->getVisitOfResidential($this->session->userdata('residencialId')));
		
		$data['visit'] = $visit;
		
		$condominio = $this->visit_db->getCondominiumByResidencial($this->session->userdata('residencialId'));
		
		$data['condominium'] = $condominio;
		
		$this->load->view('vwVisit',$data);
	}
	
	/**
	 * Obtiene los condominios de la residencialId
	 */
	public function getVisitByDateAndFilter(){
		if($this->input->is_ajax_request()){
			$data = $this->visit_db->getVisitByDateAndFilter($this->session->userdata('residencialId'),$_POST['iniDate'],$_POST['endDate'],$_POST['idCondominium']);
            $total = count($data);
			$data = array_slice($data, 0, 10);
			echo json_encode(array('items' => $data, 'total' => $total ));
		}
	}
	
	/**
	 * Obtiene los condominios de la residencialId
	 */
	public function getVisitPaginador(){
		if($this->input->is_ajax_request()){
			$data = $this->visit_db->getVisitByDateAndFilter($this->session->userdata('residencialId'),$_POST['iniDate'],$_POST['endDate'],$_POST['idCondominium']);
			$data = array_slice($data, $_POST['num'], 10);
			echo json_encode($data);
		}
	}
	
	/**
	 * Obtiene los condominios de la residencialId
	 */
	public function getVisitById(){
		if($this->input->is_ajax_request()){
			
			$months = array('', 'Enero','Febrero','Marzp','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
			$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
			
			$data = $this->visit_db->getVisitById($_POST['id']);
			
			if (count($data) > 0){
				foreach($data as $item):
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