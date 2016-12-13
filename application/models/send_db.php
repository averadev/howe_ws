<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class send_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene los mensajes de la residencia
     */
	public function getMessageAdmin($id, $residencialId){
        $this->db->select('cat_notificaciones_admin.id, cat_notificaciones_admin.asunto, cat_notificaciones_admin.fechaHora');
        $this->db->from('cat_notificaciones_admin');
        $this->db->join('empleados', 'empleados.id = cat_notificaciones_admin.empleadosId', 'inner');
		$this->db->where('empleados.residencialId = ', $residencialId);
		$this->db->order_by("cat_notificaciones_admin.id", "desc"); 
		//$this->db->limit(10);
		return  $this->db->get()->result();
	}	
	
	/**
     * Obtiene el mensaje de guardia por id
     */
	public function getMessageAdminById($id){
		$this->db->select('cat_notificaciones_admin.id, cat_notificaciones_admin.asunto, cat_notificaciones_admin.mensaje');
		$this->db->select('cat_notificaciones_admin.fechaHora');
		$this->db->select('empleados.nombre as nombreEmpleado, empleados.apellidos as apellidosEmpleado');
        $this->db->from('cat_notificaciones_admin');
        $this->db->join('empleados', 'empleados.id = cat_notificaciones_admin.empleadosId', 'inner');
		$this->db->where('cat_notificaciones_admin.id = ', $id);
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene la visita por id
     */
	public function getMessageAdminByDate($residencialId, $iniDate, $endDate){
		$this->db->select('cat_notificaciones_admin.id, cat_notificaciones_admin.asunto, cat_notificaciones_admin.fechaHora');
        $this->db->from('cat_notificaciones_admin');
        $this->db->join('empleados', 'empleados.id = cat_notificaciones_admin.empleadosId', 'inner');
		$this->db->where('empleados.residencialId = ', $residencialId);
		if($iniDate != ""){
			$this->db->where('DATE(cat_notificaciones_admin.fechaHora) >= ', $iniDate);
		}
		
		if($endDate != ""){
			$this->db->where('DATE(cat_notificaciones_admin.fechaHora) <= ', $endDate);
		}
		$this->db->order_by("cat_notificaciones_admin.id", "desc"); 
		$this->db->limit(10);
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene la info de los condominiosn por residencia
     */
	public function getCondominiumByResidential($residencialId){
		
		$this->db->select('*');
        $this->db->from('condominios');
		$this->db->where('condominios.residencialId = ', $residencialId);
		return $this->db->get()->result();
		
	}
	
	/**
     * inserta el mensaje de admin
     */
	public function insertMessageOfAdmin($data){
		
		$this->db->insert('cat_notificaciones_admin', $data); 
		return $this->db->insert_id();
		
	}
	
	/**
     * enlaza el mesaje de administrador a los condominios
     */
	public function insertMessageXrefOfAdmin($data){
		
		$this->db->insert('xref_notificaciones_condominio', $data); 
		return $this->db->insert_id();
		
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
	 * Actualiza el estado enviado de los mensajes
	 */
	public function updateMSGAStatusSent($id){
		
		$data = array(
               'enviado' => 1,
		);
		
		$this->db->where('id', $id);
		$this->db->update('xref_notificaciones_condominio', $data);
		
	}
	
	/**
	 * Actualiza el estado recibido de los mensajes
	 */
	public function updateMSGAStatusReceived($id){
		
		$data = array(
               'recibido' => 1,
		);
		
		$this->db->where('id', $id);
		$this->db->update('xref_notificaciones_condominio', $data);
		
	}

}
//end model