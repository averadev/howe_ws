<?php
/**
 * GeekBucket 2014
 * Author: Alfredo Chi
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");



class Send extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
		$this->load->database('default');
        $this->load->model('send_db');
        if ($this->session->userdata('type') != 1) {
            redirect('login');
        }
    }

    /**
     * Despliega la pantalla de dashboard
     */
	public function index($offset = 0){        
        $data['page'] = 'send';
		//$data['nameUser'] = $this->session->userdata('username'); 
		//$message = $this->send_db->getMessageAdmin($this->session->userdata('id'),$this->session->userdata('residencialId'));
		$message = $this->sortSliceArray($this->send_db->getMessageAdmin($this->session->userdata('id'),$this->session->userdata('residencialId')),10);
		$data['totalM'] = $this->totalArray($this->send_db->getMessageAdmin($this->session->userdata('id'),$this->session->userdata('residencialId')));
		
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
		
		$this->load->view('vwSend',$data);
		
	}
	
	/**
	 * obtiene la informacion del mensaje o visita por id
	 */
	public function getMessageAdminById(){
		if($this->input->is_ajax_request()){
			$data = $_POST['typeM'];
			if($_POST['typeM'] == "message"){
				$data = $this->send_db->getMessageAdminById($_POST['id']);
			}else if($_POST['typeM'] == "visit"){
				$data = $this->send_db->getVisitById($_POST['id']);
			}
			
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
	
	/**
	 * Obtiene los mensaje del administrador por fecha
	 */
	public function getMessageAdminByDate(){
		if($this->input->is_ajax_request()){
			
			$data = $this->send_db->getMessageAdminByDate($this->session->userdata('residencialId'), $_POST['iniDate'], $_POST['endDate']);
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
			
			echo json_encode(array('items' => $data, 'total' => $total));
		}
	}
	
		/**
	 * Obtiene los mensaje del administrador por fecha
	 */
	public function getMessagePaginador(){
		if($this->input->is_ajax_request()){
			
			$data = $this->send_db->getMessageAdminByDate($this->session->userdata('residencialId'), $_POST['iniDate'], $_POST['endDate']);
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
	
	/**
	 * Envia un mensaje a los condominios
	 */
	public function sendMessageOfAdmin(){
		if($this->input->is_ajax_request()){
			
			$hoy = getdate();
			$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"] . " " . $hoy["hours"].":".$hoy["minutes"].":".$hoy["seconds"];
			
			$messageAdmin = array(
				'empleadosId'	=> $this->session->userdata('id'),
				'asunto'		=> $_POST['subject'],
				'mensaje'		=> $_POST['message'],
				'fechaHora'		=> $strHoy,
				'status'		=> 1
			);
			
			$data = $this->send_db->insertMessageOfAdmin($messageAdmin);
			
			$condominium = $this->send_db->getCondominiumByResidential($this->session->userdata('residencialId'));
			
			if( count($condominium) > 0){
				
				$hoy = getdate();
				$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"] . " " . $hoy["hours"].":".$hoy["minutes"].":".$hoy["seconds"];
				
				
				$idXrefMessage = array();
				
				foreach($condominium as $item){
					$xrefMessage = array(
						'catNotificacionesAdminId'	=> $data,
						'condominiosId'				=> $item->id,
						'enviado' 					=> 1,
						'enviadoUltimoIntento'		=> $strHoy,
						'recibido' 					=> 0,
						'leido'						=> 0
					);
					
					$data2 = $this->send_db->insertMessageXrefOfAdmin($xrefMessage);
					
					
					array_push($idXrefMessage,$data2);
					//$idXrefMessage = array();
				}
				
				foreach($condominium as $item){
					array_push($xrefMessage, array(
						'catNotificacionesAdminId'	=> $data,
						'condominiosId'				=> $item->id,
						'enviado' 					=> 1,
						'enviadoUltimoIntento'		=> $strHoy,
						'recibido' 					=> 0,
						'leido'						=> 0
					));
				}
				
				$cont = 0;
				foreach($condominium as $item){
					
					$user = $this->send_db->getUserByCondominioId($item->id);
			
					if(count($user) > 0){
						foreach($user as $userId){
							if($userId->playerId != 0 || $userId->playerId != '0'){
								usleep(10000);
								$playerIdArray = [$userId->playerId];	
								$this->SendNotificationMAPush($playerIdArray, $data);
							}
						}
						
					}
					
					$cont++;
					
				}
				
			}
			echo json_encode("mensaje enviado");
			//echo json_encode('mensaje enviado.');
		}
	}
	
	/************** metodo generico ******************/
	 
	/**
	 * Envia las notificaciones push
	 */
	public function SendNotificationMAPush($playerId, $idMSGNew){
		
		$idMSGNew = $idMSGNew . "";
		
		//$userID = [$playerId]; 
		//$userID = $playerId; 
		$massage = "mensaje";
	  
		$content = array(
			"en" => $massage
		);
    
		$fields = array(
		'app_id' => "d55cca2a-694c-11e5-b9d4-c39860ec56cd",
		//'included_segments' => array('All'),
		'include_player_ids' => $playerId,
		'data' => array("type" => '2', "id" => $idMSGNew),
		'isAndroid' => true,
		'contents' => $content
		);
    
		$fields = json_encode($fields);
		//print("\nJSON sent:\n");
		// print($fields);
		
		//$this->send_db->updateMSGAStatusSent($idMSGNew);
		
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                           'Authorization: Basic NGEwMGZmMjItY2NkNy0xMWUzLTk5ZDUtMDAwYzI5NDBlNjJj'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		$return["allresponses"] = $response;
		$return = json_encode($return);
  
		$findme   = 'error';
		$pos = strpos($return, $findme);
	
		if ($pos === false) {
			//$this->send_db->updateMSGAStatusReceived($idMSGNew);
		}
	
		curl_close($ch);
		
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