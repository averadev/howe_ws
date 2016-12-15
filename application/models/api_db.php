<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class api_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
	
	 /**
     * registro del usuario
     */
    public function insert($data, $table){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Actualizacion del usuario
     */
    public function update($data){
        $this->db->where('email', $data['email']);
        $this->db->update('user', $data);
    }
	
	/**
     * inserta y retorna la id
     */
	public function updateReturn($data, $table, $condicion){
		$this->db->where($condicion);
		$this->db->update($table, $data);
	}
 
    /**
     * Obtiene los datos del usuario
     */
    public function get($data){
        $this->db->from('user');
        $this->db->where($data);
        return $this->db->get()->result();
    }
 
    /**
     * verifica si el usuario ya se ha registrado
     */
    public function verifyEmail($email){
        $this->db->from('user');
        $this->db->where('email', $email);
        return $this->db->get()->result();
    }
	
	/**
     * verifica si el usuario ya se ha registrado
     */
    public function verifyExistingMail($email){
        $this->db->from('residente');
        $this->db->where('email', $email);
        return $this->db->get()->result();
    }
 
    /**
     * verifica si el usuario ya se ha registrado
     */
    public function getIdsOneSignal($residencialId){
        $this->db->from('empleados');
        $this->db->where('residencialId', $residencialId);
        return $this->db->get()->result();
    }
    
    
    /**
     * Actualizacion del id OneSignal
     */
    public function updateAdminOS($id, $idOneSignal){
        $this->db->where('id', $id);
        $this->db->update('empleados', array('idOneSignal' => $idOneSignal));
    }
	
	/**
     * veridica si el correo y password existen
     */
    public function verifyEmailPassAdmin($email, $pass){
		$this->db->select('empleados.id, empleados.email, empleados.contrasena, empleados.nombre, empleados.residencialId');
		$this->db->select('residencial.nombre as nameResidencial, residencial.ciudadesId');
        $this->db->from('empleados');
		$this->db->join('residencial', 'residencial.id = empleados.residencialId');
        $this->db->where('empleados.email', $email);
        $this->db->where('empleados.contrasena', $pass);
		$this->db->where('empleados.catPuestosId = 1');
        return $this->db->get()->result();
    }
	
	/**
     * veridica si el correo y password existen
     */
    public function verifyEmailPassUser($email, $pass){
		$this->db->select('residente.id, residente.email, residente.contrasena, residente.nombre, residente.apellido, residente.condominioId, residente.telefono');
		$this->db->select('condominios.nombre as nameCondominious, condominios.residencialId');
        $this->db->from('residente');
		$this->db->join('condominios', 'condominios.id = residente.condominioId');
        $this->db->where('residente.email', $email);
        $this->db->where('residente.contrasena', $pass);
		$this->db->where('residente.status = 1');
        return $this->db->get()->result();
    }
	
	/**
     * veridica si el correo y password existen
     */
    public function signOutAdmin($idApp, $pass){
		$this->db->select('empleados.id, empleados.email, empleados.contrasena, empleados.nombre, empleados.residencialId');
		$this->db->select('residencial.nombre as nameResidencial, residencial.ciudadesId');
        $this->db->from('empleados');
		$this->db->join('residencial', 'residencial.id = empleados.residencialId');
        $this->db->where('empleados.id', $idApp);
        $this->db->where('empleados.contrasena', $pass);
		$this->db->where('empleados.catPuestosId = 1');
        return $this->db->get()->result();
    }
	
	/**
	 * obtenemos las ciudades
	 */
	public function getCity(){
		$this->db->from('ciudades');
        return $this->db->get()->result();
	}
	
	/**
	 * obtenemos la info de los guardias
	 */
	public function getInfoGuard($idResidencial){
		$this->db->select('empleados.id, empleados.email, empleados.contrasena, empleados.nombre, empleados.residencialId, empleados.foto');
		$this->db->select('residencial.nombre as nameResidencial, residencial.ciudadesId');
        $this->db->from('empleados');
		$this->db->join('residencial', 'residencial.id = empleados.residencialId');
        $this->db->where('empleados.residencialId', $idResidencial);
		$this->db->where('empleados.catPuestosId = 2');
        return $this->db->get()->result();
	}
	
	/**
	 * Obtiene los condominios de la residencia
	 */
	public function getCondominium($idResidencial){
        $this->db->from('condominios');
        $this->db->where('condominios.residencialId', $idResidencial);
        return $this->db->get()->result();
	}
	
	/**
	 * Obtiene el playerId de usuario por condominio
	 */
	public function getUserByCondominioId($condominioId){
        $this->db->from('residente');
        $this->db->where('residente.condominioId', $condominioId);
		$this->db->where('residente.status', 1);
        return $this->db->get()->result();
	}
	
	/**
	 * Obtiene la info de la residencia
	 */
	public function getResidential($id){
        $this->db->from('residencial');
        $this->db->where('residencial.id', $id);
        return $this->db->get()->result();
	}
	
	/**
	 * Obtiene la lista de asuntos
	 */
	public function getAsuntos($id){
        $this->db->from('cat_asunto');
        $this->db->where('status = 1');
        return $this->db->get()->result();
	}
	
	/**
	 * Inserta los datos del mensaje
	 */
    public function saveMessageGuard($data){
        $this->db->insert('cat_notificaciones_seguridad', $data);
        return $this->db->insert_id();
    }
	
	/**
	 * Inserta los datos del mensaje
	 */
    public function saveRecordVisit($data){
        $this->db->insert('registro_visitas', $data);
        return $this->db->insert_id();
    }
	
	/*****************************************************/
	/*******************Booking User**********************/
	/*****************************************************/
	
	/**
     * veridica si el correo y password existen
     */
    public function getMessageAdminUnRead($condominium){
        $this->db->from('xref_notificaciones_condominio');
        $this->db->where('xref_notificaciones_condominio.condominiosId', $condominium);
		$this->db->where('xref_notificaciones_condominio.leido = 0');
		//$this->db->where('cat_notificaciones_admin.status = 1');
		$this->db->where('xref_notificaciones_condominio.status = 1');
        return $this->db->get()->result();
    }
    
    /**
     * veridica si el correo y password existen
     */
    public function getNotif($residencialId){
        $this->db->select('registro_visitas.id, condominios.nombre, registro_visitas.action');
        $this->db->from('registro_visitas');
        $this->db->join('condominios', 'registro_visitas.condominiosId = condominios.id');
        $this->db->where('condominios.residencialId', $residencialId);
        $this->db->where('registro_visitas.action >= 0');
        $this->db->order_by('registro_visitas.id', 'desc'); 
        $this->db->group_by('registro_visitas.id'); 
        $this->db->limit(8);
        return $this->db->get()->result();
    }
	
	/**
     * veridica si el correo y password existen
     */
    public function getMessageVisitUnRead($condominium){
        $this->db->from('registro_visitas');
        $this->db->where('registro_visitas.condominiosId', $condominium);
		$this->db->where('registro_visitas.leido = 0');
		$this->db->where('registro_visitas.status = 1');
        return $this->db->get()->result();
    }
	
	/**
	 * Obtiene la informacion de visitantes por condominio
	 */
	public function getMessageToVisit($condominium){
		$this->db->select('registro_visitas.id, registro_visitas.nombreVisitante, registro_visitas.motivo, registro_visitas.fechaHora, registro_visitas.enviadoUltimoIntento, registro_visitas.leido');
        $this->db->from('registro_visitas');
        $this->db->where('registro_visitas.condominiosId', $condominium);
		$this->db->where('registro_visitas.status = 1');
		$this->db->order_by('registro_visitas.leido asc, registro_visitas.fechaHora desc'); 
        return $this->db->get()->result();	
    }
	
	/**
	 * Obtiene la informacion de visitantes por condominio
	 */
	public function getMessageToVisitById($id){
		$this->db->select('registro_visitas.id, registro_visitas.nombreVisitante, registro_visitas.motivo, registro_visitas.fechaHora, registro_visitas.enviadoUltimoIntento, registro_visitas.action, registro_visitas.leido');
        $this->db->from('registro_visitas');
        $this->db->where('registro_visitas.id', $id);
		//$this->db->where('registro_visitas.leido = 0');
		//$this->db->order_by('registro_visitas.leido asc, registro_visitas.fechaHora asc'); 
        return $this->db->get()->result();	
    }
	
	/**
	 * Obtiene la informacion de los mensajes de admin
	 */
	public function getMessageToAdmin($condominium){
		$this->db->select('cat_notificaciones_admin.id, cat_notificaciones_admin.asunto, cat_notificaciones_admin.mensaje, cat_notificaciones_admin.fechaHora');
		$this->db->select('xref_notificaciones_condominio.id as idXref, xref_notificaciones_condominio.leido');
		$this->db->select('empleados.nombre as nombreAdmin, empleados.apellidos as apellidosAdmin');
        $this->db->from('cat_notificaciones_admin');
		$this->db->join('xref_notificaciones_condominio', 'cat_notificaciones_admin.id = xref_notificaciones_condominio.catNotificacionesAdminId');
		$this->db->join('empleados', 'cat_notificaciones_admin.empleadosId = empleados.id');
		$this->db->where('xref_notificaciones_condominio.condominiosId', $condominium);
		$this->db->where('cat_notificaciones_admin.status = 1');
		$this->db->where('xref_notificaciones_condominio.status = 1');
		//$this->db->where('registro_visitas.leido = 0');
		$this->db->order_by('xref_notificaciones_condominio.leido asc, cat_notificaciones_admin.fechaHora desc'); 
        return $this->db->get()->result();
    }
	
	/**
	 * Obtiene la informacion de visitantes por condominio
	 */
	public function getMessageToAdminById($id){
		$this->db->select('cat_notificaciones_admin.id, cat_notificaciones_admin.asunto, cat_notificaciones_admin.mensaje, cat_notificaciones_admin.fechaHora');
        $this->db->from('cat_notificaciones_admin');
        $this->db->where('cat_notificaciones_admin.id', $id);
		//$this->db->where('registro_visitas.leido = 0');
		//$this->db->order_by('registro_visitas.leido asc, registro_visitas.fechaHora asc'); 
        return $this->db->get()->result();	
    }
	
	/**
	 * actualiza el playerId del usuario
	 */
	public function getLastGuard($condominioId){
		$this->db->select('condominios.residencialId');
        $this->db->from('condominios ');
        $this->db->where('condominios.id', $condominioId);
        $idResidencial = $this->db->get()->result();
		//echo $idResidencial[0]->residencialId;
		
		if(count($idResidencial) > 0){
			$this->db->select('empleados.nombre, empleados.apellidos, empleados.foto, empleados.residencialId, registro_visitas.fechaHora, empleados.workingTime');
			$this->db->select('DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(empleados.birthDay)), "%Y")+0 AS edad');
			$this->db->from('empleados');
			$this->db->join('registro_visitas', 'empleados.id = registro_visitas.empleadosId');
			$this->db->where('empleados.residencialId = ', $idResidencial[0]->residencialId);
			$this->db->order_by('registro_visitas.fechaHora DESC'); 
			$this->db->limit(1);
			$data1 = $this->db->get()->result();
			
			$this->db->select('empleados.nombre, empleados.apellidos, empleados.foto, empleados.residencialId, cat_notificaciones_seguridad.fechaHora, empleados.workingTime');
			$this->db->select('DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(empleados.birthDay)), "%Y")+0 AS edad');
			$this->db->from('empleados');
			$this->db->join('cat_notificaciones_seguridad', 'empleados.id = cat_notificaciones_seguridad.empleadosId');
			$this->db->where('empleados.residencialId = ', $idResidencial[0]->residencialId);
			$this->db->order_by('cat_notificaciones_seguridad.fechaHora DESC'); 
			$this->db->limit(1);
			$data2 = $this->db->get()->result();
			
			$this->db->select('empleados.nombre, empleados.apellidos, empleados.foto, empleados.residencialId, empleados.workingTime');
			$this->db->select('DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(empleados.birthDay)), "%Y")+0 AS edad');
			$this->db->from('empleados');
			$this->db->where('empleados.residencialId = ', $idResidencial[0]->residencialId);
			$this->db->order_by('empleados.id DESC'); 
			$this->db->limit(1);
			$data3 = $this->db->get()->result();
			
			if(count($data1) > 0 && count($data2) == 0){
				return $data1;
			}else if(count($data1) == 0 && count($data2) > 0){
				return $data2;
			}else if(count($data1) > 0 && count($data2) > 0){
				if($data1[0]->fechaHora >= $data2[0]->fechaHora){
					return $data1;
				}else{
					return $data2;
				}
			}else if(count($data3)){
				return $data3;
			}
		
		}else{
			return array();
		}
	}
	
	/**
	 * Inserta los datos de la queja
	 */
    public function saveSuggestion($data){
        $this->db->insert('cat_quejas_sugerencias', $data);
    }
	
	/**
	 * actualiza el playerId del usuario
	 */
	public function setIdPlayerUser($idApp, $playerId){
		
		$data = array(
               'playerId' => 0,
		);
		$this->db->where('playerId', $playerId);
		$this->db->update('residente', $data);
		
		$data2 = array(
               'playerId' => $playerId,
		);
		$this->db->where('id', $idApp);
		$this->db->update('residente', $data2);
		
	}
	
	/**
	 * actualiza el playerId del usuario
	 */
	public function deletePlayerIdOfUSer($idApp, $condominioId){
		
		$data = array(
               'playerId' => 0,
		);
		$this->db->where('id', $idApp);
		$this->db->where('condominioId', $condominioId);
		$this->db->update('residente', $data);
		
	}
	
	/**
	 * Marca el mensaje como leido
	 */
	public function markMessageRead($id, $typeM, $data){
		
		$this->db->where('id', $id);
		if($typeM == 1){
			$this->db->update('xref_notificaciones_condominio', $data);
		}else if($typeM == 2){
			$this->db->update('registro_visitas', $data);
		}
		
	}
	
	/**
	 * Actualiza el estado enviado de los mensajes
	 */
	public function updateMSGStatusSent($id, $typeM){
		
		$data = array(
               'enviado' => 1,
		);
		
		$this->db->where('id', $id);
		if($typeM == 1){
			$this->db->update('registro_visitas', $data);
		}else{
			$this->db->update('residente', $data);
		}
		
	}
	
	/**
	 * Actualiza el estado recibido de los mensajes
	 */
	public function updateMSGStatusReceived($id, $typeM){
		
		$data = array(
               'recibido' => 1,
		);
		
		$this->db->where('id', $id);
		if($typeM == 1){
			$this->db->update('registro_visitas', $data);
		}else{
			$this->db->update('residente', $data);
		}
		
	}
	
	/**
	 * Actualiza el estado recibido de los mensajes
	 */
	public function updateVisitAction($id, $action){
		$this->db->where('id', $id);
        $this->db->update('registro_visitas', array('action' => $action));
	}
	
	/**
	 * Elimina los mensajes de visitas
	 */
	public function deleteMsgVisit($data){
		
		$this->db->update_batch('registro_visitas', $data, 'id'); 
		
	}
	
}
//end model



