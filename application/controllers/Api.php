<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';


/**
 * The Saving coupon
 * Author: Alberto Vera Espitia
 * GeekBucket 2014
 *
 */
class Api extends REST_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->database('default');
        $this->load->model('Api_db');
    }

	public function index_get(){
       // $this->load->view('web/vwApi');
	   echo "hola";
    }
	
	/*
     * Validar usuarios
     */
    public function validateAdmin_get() { 
        // Verificamos parametros y acceso
        $message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
            // Obtener cupones
            $data = $this->Api_db->verifyEmailPassAdmin($this->get('email'), $this->get('password'));
            if (count($data) > 0){
                // Guardar OneSignal
                $this->Api_db->updateAdminOS($data[0]->id, $this->get('idOneSignal'));
                
				$items = $this->Api_db->getInfoGuard($data[0]->residencialId);
				foreach ($items as $item):
					$item->path = 'assets/img/app/user/';
				endforeach;
				$items2 = $this->Api_db->getCondominium($data[0]->residencialId);
				$items3 = $this->Api_db->getResidential($data[0]->residencialId);
                $asuntos = $this->Api_db->getAsuntos($data[0]->residencialId);
                $message = array('success' => true, 'message' => 'Usuario correcto', 'items' => $data, 'items2' => $items, 'items3' => $items2, 'items4' => $items3, 'asuntos' => $asuntos);
            }else{
                $message = array('success' => false, 'message' => 'El usuario o password es incorrecto.');
            }
        }
        $this->response($message, 200);
    }
	
	/*
     * Validar a los usuarios de la app
     */
    public function validateUser_get() { 
        // Verificamos parametros y acceso
        $message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
            // Obtener cupones
            $data = $this->Api_db->verifyEmailPassUser($this->get('email'), $this->get('password'));
			
			$playerId = 0;
            if (count($data) > 0){
				if (count($data) == 1){
					$this->Api_db->setIdPlayerUser($data[0]->id, $this->get('playerId'));
				}
				$residencial = $this->Api_db->getResidential($data[0]->residencialId);
				
                $message = array('success' => true, 'message' => 'Usuario correcto', 'items' => $data, 'residencial' => $residencial);
            }else{
                $message = array('success' => false, 'message' => 'Password es incorrecto.');
            }
        }
        $this->response($message, 200);
    }
	
	/*
     * Registra un nuevo residente
     */
    public function RegisterUser_post() { 
        // Verificamos parametros y acceso
        $message = $this->verifyIsSetPost(array('idApp'));
        if ($message == null) {
			
            $data = $this->Api_db->verifyExistingMail($this->post('email'));
			
			$playerId = 0;
            if (count($data) == 0){
				$insert = array(
					'nombre' => "",
					'apellido' => "",
					'telefono' => "",
					'email' => $this->post('email'),
					'status' => 0,
					'contrasena' => $this->post('password'),
					'condominioId' => 36,
					'playerId' => $playerId,
				);
				
				$id = $this->Api_db->insert($insert, "residente");
				
				//$data2 = $this->Api_db->verifyEmailPassUser($this->post('email'), $this->post('password'));
				
				/*if( count( $data2 ) > 0 ){
					$residencial = $this->Api_db->getResidential($data[0]->residencialId );
				}*/
				 
				$message = array( 'success' => true, 'message' => 'se ha registrado, espere confirmacion del administrador' );
				
				//$residencial = $this->Api_db->getResidential($data[0]->residencialId);
				
            }else{
                $message = array('success' => false, 'message' => 'El correo ya existe.');
            }
			//$message = array('success' => true, 'message' => count( $data ) );
        }
        $this->response($message, 200);
    }
	
	
	/**
	 * Actualiza el playerId de los usuario
	 */
	public function setIdPlayerUser_get() { 
        // Verificamos parametros y acceso
        $message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
            // Obtener cupones
            $data = $this->Api_db->setIdPlayerUser($this->get('idApp'), $this->get('playerId'));
			$message = array('success' => true, 'message' => 'Condominio asignado.', 'items' => $data);
        }
        $this->response($message, 200);
    }
	
	/**
	 * Actualiza el playerId de los usuario
	 */
	public function getNotif_get() { 
        $items = $this->Api_db->getNotif($this->get('residencial'));
        $this->response(array('success' => true, 'items' => $items), 200);
    }
	
	/**
	 * Actualiza el playerId de los usuario
	 */
	public function updateVisitAction_get() { 
        $this->Api_db->updateVisitAction($this->get('idMSG'), $this->get('action'));
        // Mandar notificacion guardia
        if ($this->get('action') == "2" || $this->get('action') == "3"){
            $data = $this->Api_db->getIdsOneSignal($this->get('residencial'));
            foreach ($data as $item):
                if (isset($item->idOneSignal)) {
                    $this->SendNotificationSecurity($item->idOneSignal, $this->get('action'), "d5a06f1e-b4c1-424a-8964-52458c9045a6");
                }
            endforeach;
            
        }
        $this->response(array('success' => true), 200);
    }
	
	/**
	 * Actualiza el playerId de los usuario a 0
	 */
	public function deletePlayerIdOfUSer_get() { 
        // Verificamos parametros y acceso
        $message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
            // Obtener cupones
            $data = $this->Api_db->deletePlayerIdOfUSer($this->get('idApp'), $this->get('condominioId'));
			$message = array('success' => true, 'message' => 'Sesión terminada.', 'items' => $data);
        }
        $this->response($message, 200);
    }
	
	/***
	 * signOut Admin
	 */
	public function signOut_get() {
		
		$message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
            // Obtener cupones
            $data = $this->Api_db->signOutAdmin($this->get('idApp'), $this->get('password'));
            if (count($data) > 0){
                $message = array('success' => true, 'message' => 'Usuario correcto', 'items' => $data);
            }else{
                $message = array('success' => false, 'message' => 'Password es incorrecto.');
            }
        }
        $this->response($message, 200);
		
	}
    
	public function getCity_get(){
		$items = $this->Api_db->getCity();
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
	}
	
	/*public function getInfoGuard_get(){
		$items = $this->Api_db->getInfoGuard($this->get('recidencial'));
		foreach ($items as $item):
            $item->path = 'assets/img/app/user/';
        endforeach;
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
	}*/
	
	/**
	 * Guarda los datos del mensaje seguridad
	 */
	public function saveMessageGuard_get(){
		$message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
			
			$hoy = getdate();
			$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"] . " " . $hoy["hours"].":".$hoy["minutes"].":".$hoy["seconds"];
			
			$insert = array(
				'empleadosId' 			=> $this->get('idGuard'),
				'asunto' 				=> $this->get('subject'),
				'mensaje' 				=> $this->get('message'),
				'fechaHora' 			=> $this->get('dateS'),
				'enviado' 				=> 0,
				'enviadoUltimoIntento' 	=> $strHoy,
				'recibido' 				=> 0,
				'leido' 				=> 0,
				'status' 				=> 1
			);
			
			$idMSGNew = $this->Api_db->saveMessageGuard($insert);
			$items = array( 'idMSGNew' => $idMSGNew, 'idMSG' => $this->get('idMSG') );
			$message = array('success' => true, 'message' => 'Mensaje enviado', 'items' => $items);
        }
        $this->response($message, 200);
	}
	
	/**
	 * Guarda los datos del registro visita
	 */
	public function saveRecordVisit_get(){
		$message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
			
			$hoy = getdate();
			$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"] . " " . $hoy["hours"].":".$hoy["minutes"].":".$hoy["seconds"];
			
			$insert = array(
				'empleadosId' 			=> $this->get('idGuard'),
				'nombreVisitante' 		=> $this->get('name'),
				'motivo' 				=> $this->get('reason'),
				'idFrente' 				=> $this->get('idFrente'),
				'idVuelta' 				=> $this->get('idVuelta'),
				'condominiosId' 		=> $this->get('condominiosId'), 
				'fechaHora' 			=> $this->get('dateS'),
				'enviado' 				=> 0,
				'enviadoUltimoIntento' 	=> $strHoy,
				'recibido' 				=> 0,
				'leido' 				=> 0,
				'proveedor' 			=> $this->get('provider'),
                'action' 				=> 0,
				'status' 				=> 1
			);
			
			$idMSGNew = $this->Api_db->saveRecordVisit($insert);
			$items = array( 'idMSGNew' => $idMSGNew, 'idMSG' => $this->get('idMSG') );
			
			
			$user = $this->Api_db->getUserByCondominioId($this->get('condominiosId'));
			
			if( count($user) > 0){
				if($user[0]->playerId != 0 || $user[0]->playerId != '0'){
					usleep(10000);
					$this->SendNotificationPush($user[0]->playerId, $idMSGNew, "1", "d55cca2a-694c-11e5-b9d4-c39860ec56cd");
					
				}
			}
			
			$message = array('success' => true, 'message' => 'Mensaje enviado', 'items' => $items, 'user' => count($user));
			
        }
        $this->response($message, 200);
	}
	
	/*****************************************************/
	/*******************Booking User**********************/
	/*****************************************************/
	
	/**
	 * Obtiene la info del ultimo guardia de la residencial
	 */
	public function getLastGuard_get(){
		$message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
			$items = $this->Api_db->getLastGuard($this->get('condominioId'));
			if(count($items) > 0){
				foreach ($items as $item):
					$item->path = 'assets/img/app/user/';
					$ext = explode( ".", $item->foto );
					$item->extension = $ext[1];
				endforeach;
			}
			$message = array('success' => true, 'message' => 'Guardia en turno', 'items' => $items);
        }
        $this->response($message, 200);
	}
	
	/**
	 * Obtiene el numero los mensajes no leidos del condominio
	 */
	public function getMessageUnRead_get(){
		$message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
			$items = $this->Api_db->getMessageAdminUnRead($this->get('condominium'));
			$items2 = $this->Api_db->getMessageVisitUnRead($this->get('condominium'));
			$items = count($items);
			$items2 = count($items2);
			$message = array('success' => true, 'message' => 'Mensajes sin leer', 'items' => $items, 'items2' => $items2);
        }
        $this->response($message, 200);
	}
	
	/**
	 * marca el mensaje como leido
	 */
	public function markMessageRead_get(){
		$message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
			$items = 0;
			
			$data = array(
               'leido' => 1,
            );
			
			$this->Api_db->markMessageRead($this->get('idMSG'), $this->get('typeM'), $data);
			
			$message = array('success' => true, 'message' => 'Mensajes marcado como leido');
        }
        $this->response($message, 200);
	}
	
	/**
	 * Obtiene los mensajes no leidos del condominio
	 */
	public function getMessageToVisit_get(){
		$message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
			$months = array('', 'Enero','Febrero','Marzp','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
			$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
			$items = $this->Api_db->getMessageToVisit($this->get('condominioId'));
			if (count($items) > 0){
				foreach($items as $item):
					$fechaD = $dias[date('N', strtotime($item->fechaHora)) - 1];
					$item->dia = $fechaD;
					$item->fechaFormat = date('d', strtotime($item->fechaHora)) . '-' . $months[date('n', strtotime($item->fechaHora))] . '-' . date('Y', strtotime($item->fechaHora));
					$date = date_create($item->fechaHora);
					$item->hora = date_format($date, 'g:i A');
				endforeach;
                $message = array('success' => true, 'message' => 'Mesajes nuevos',  'items' => $items);
            }else{
                $message = array('success' => true, 'message' => 'Sin Visitantes.', 'items' => $items);
            }
        }
        $this->response($message, 200);
	}
	
	/**
	 * Obtiene el mensaje de visitante por id
	 */
	public function getMessageToVisitById_get(){
		$message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
			$months = array('', 'Enero','Febrero','Marzp','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
			$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
			$items = $this->Api_db->getMessageToVisitById($this->get('idMSG'));
			if (count($items) > 0){
				foreach($items as $item):
					$fechaD = $dias[date('N', strtotime($item->fechaHora)) - 1];
					$item->dia = $fechaD;
					$item->fechaFormat = date('d', strtotime($item->fechaHora)) . '-' . $months[date('n', strtotime($item->fechaHora))] . '-' . date('Y', strtotime($item->fechaHora));
					$date = date_create($item->fechaHora);
					$item->hora = date_format($date, 'g:i A');
				endforeach;
                $message = array('success' => true, 'message' => 'Mesajes nuevos',  'items' => $items);
            }else{
                $message = array('success' => false, 'message' => 'Sin Visitantes.');
            }
        }
        $this->response($message, 200);
	}
	
	/**
	 * Obtiene los mensajes no leidos del condominio
	 */
	public function getMessageToAdmin_get(){
		$message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
			$months = array('', 'Enero','Febrero','Marzp','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
			$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
			$items = $this->Api_db->getMessageToAdmin($this->get('condominioId'));
			if (count($items) > 0){
				foreach($items as $item):
					$fechaD = $dias[date('N', strtotime($item->fechaHora)) - 1];
					$item->dia = $fechaD;
					$item->fechaFormat = date('d', strtotime($item->fechaHora)) . '-' . $months[date('n', strtotime($item->fechaHora))] . '-' . date('Y', strtotime($item->fechaHora));
					$date = date_create($item->fechaHora);
					$item->hora = date_format($date, 'g:i A');
				endforeach;
                $message = array('success' => true, 'message' => 'Mesajes nuevos',  'items' => $items);
            }else{
                $message = array('success' => true, 'message' => 'Sin Visitantes.', 'items' => $items);
            }
        }
        $this->response($message, 200);
	}
	
	/**
	 * Obtiene el mensaje del administrador por id
	 */
	public function getMessageToAdminById_get(){
		$message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
			$months = array('', 'Enero','Febrero','Marzp','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
			$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
			$items = $this->Api_db->getMessageToAdminById($this->get('idMSG'));
			if (count($items) > 0){
				foreach($items as $item):
					$fechaD = $dias[date('N', strtotime($item->fechaHora)) - 1];
					$item->dia = $fechaD;
					$item->fechaFormat = date('d', strtotime($item->fechaHora)) . '-' . $months[date('n', strtotime($item->fechaHora))] . '-' . date('Y', strtotime($item->fechaHora));
					$date = date_create($item->fechaHora);
					$item->hora = date_format($date, 'g:i A');
				endforeach;
                $message = array('success' => true, 'message' => 'Mesajes nuevos',  'items' => $items);
            }else{
                $message = array('success' => false, 'message' => 'Sin Visitantes.');
            }
        }
        $this->response($message, 200);
	}
	
	/**
	 * elimina los mensaje de visitas
	 */
	public function deleteMsgVisit_get(){
		$message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
			
			$msgVisit =  json_decode($this->get('idMSG'));
			
			foreach($msgVisit as $idV){
				$update = array(
					'status'=> 0
				);
				$condicion = "id = " . $idV;
				$this->Api_db->updateReturn($update, "registro_visitas", $condicion);
			}
			
			$message = array('success' => true, 'message' => 'Mensajes eliminados');
        }
        $this->response($message, 200);
	}
	
	/**
	 * elimina los mensaje de visitas
	 */
	public function deleteMsgAdmin_get(){
		$message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
			
			$msgAdmin =  json_decode($this->get('idMSG'));
			
			foreach($msgAdmin as $idV){
				$update = array(
					'status'=> 0
				);
				$condicion = "id = " . $idV;
				$this->Api_db->updateReturn($update,"xref_notificaciones_condominio", $condicion);
			}
			
			$message = array('success' => true, 'message' => 'Mensajes eliminados');
        }
        $this->response($message, 200);
	}
	
	/**
	 * Guarda los datos del mensaje seguridad
	 */
	public function saveSuggestion_get(){
		$message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
			
			$hoy = getdate();
			$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"] . " " . $hoy["hours"].":".$hoy["minutes"].":".$hoy["seconds"];
			
			$insert = array(
				'residenteId' 			=> $this->get('idApp'),
				'asunto' 				=> $this->get('subject'),
				'mensaje' 				=> $this->get('message'),
				'fechaHora' 			=> $strHoy,
				'leido' 				=> 0,
				'status' 				=> 1
			);
			
			$this->Api_db->saveSuggestion($insert);
			$message = array('success' => true, 'message' => 'Mensaje enviado');
        }
        $this->response($message, 200);
	}
	
	public function getEmergencyCalls_get(){
		$message = $this->verifyIsSet(array('idApp'));
        if ($message == null) {
			$items = $this->Api_db->getEmergencyCalls($this->get('condominioId'));
			$message = array('success' => true, 'message' => 'Mensaje enviado', 'items' => $items);
        }
        $this->response($message, 200);
	}
	
	 /************** metodo generico ******************/
    
    /**
	 * Envia las notificaciones push
	 */
	public function SendNotificationSecurity($playerId, $typeMSG, $idAppOneSignal){
		
		
		$userID = [$playerId]; 
		if($typeMSG == "2"){
			$massage = "Acceso Aceptado";
		}elseif($typeMSG == "3"){
			$massage = "Acceso Negado";
		}
	  
		$content = array(
			"en" => $massage
		);
    
		$fields = array(
		'app_id' => $idAppOneSignal,
		//'included_segments' => array('All'),
		'include_player_ids' => $userID,
		'data' => array("type" => $typeMSG, "id" => ""),
		'isAndroid' => true,
		'contents' => $content
		);
    
		$fields = json_encode($fields);
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
	
		curl_close($ch);
		
	}
	 
	/**
	 * Envia las notificaciones push
	 */
	public function SendNotificationPush($playerId, $idMSGNew, $typeMSG, $idAppOneSignal){
		
		$idMSGNew = $idMSGNew . "";
		
		$userID = [$playerId]; 
		if($typeMSG == 1){
			$massage = "Visitante";
		}
	  
		$content = array(
			"en" => $massage
		);
    
		$fields = array(
		'app_id' => $idAppOneSignal,
		//'included_segments' => array('All'),
		'include_player_ids' => $userID,
		'data' => array("type" => $typeMSG, "id" => $idMSGNew),
		'isAndroid' => true,
		'contents' => $content
		);
    
		$fields = json_encode($fields);
		//print("\nJSON sent:\n");
		// print($fields);
		
		$this->Api_db->updateMSGStatusSent($idMSGNew, $typeMSG);
		
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
			$this->Api_db->updateMSGStatusReceived($idMSGNew, $typeMSG);
		}
	
		curl_close($ch);
		
	}
	
	/**
     * Verificamos si las variables obligatorias fueron enviadas
     */
    private function verifyIsSet($params){
    	foreach ($params as &$value) {
		    if ($this->get($value) ==  '')
		    	return array('success' => false, 'message' => 'El parametro '.$value.' es obligatorio');
		}
		return null;
    }
	
	/**
     * Verificamos si las variables obligatorias fueron enviadas por post
     */
    private function verifyIsSetPost($params){
    	foreach ($params as &$value) {
		    if ($this->post($value) ==  '')
		    	return array('success' => false, 'message' => 'El parametro '.$value.' es obligatorio');
		}
		return null;
    }
	
	
}