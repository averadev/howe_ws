<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class message_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene los mensajes de la residencia
     */
	public function getMessageGuard($id, $residencialId){
        $this->db->select('cat_notificaciones_seguridad.id, cat_notificaciones_seguridad.asunto, cat_notificaciones_seguridad.fechaHora');
        $this->db->from('cat_notificaciones_seguridad');
        $this->db->join('empleados', 'empleados.id = cat_notificaciones_seguridad.empleadosId', 'inner');
		$this->db->where('empleados.residencialId = ', $residencialId);
		$this->db->order_by("cat_notificaciones_seguridad.id", "desc"); 
		//$this->db->limit(10);
		return  $this->db->get()->result();
	}	
	
	/**
     * Obtiene las ultimas visitas de la residencia
     */
	public function getVisitDash($id, $residencialId){
        $this->db->select('registro_visitas.id, registro_visitas.motivo, registro_visitas.fechaHora');
        $this->db->from('registro_visitas');
        $this->db->join('empleados', 'empleados.id = registro_visitas.empleadosId', 'inner');
		$this->db->where('empleados.residencialId = ', $residencialId);
		$this->db->order_by("registro_visitas.id", "desc"); 
		$this->db->limit(10);
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene el mensaje de guardia por id
     */
	public function getMessageById($id){
		$this->db->select('cat_notificaciones_seguridad.id, cat_notificaciones_seguridad.asunto, cat_notificaciones_seguridad.mensaje');
		$this->db->select('cat_notificaciones_seguridad.fechaHora');
		$this->db->select('empleados.nombre as nombreEmpleado, empleados.apellidos as apellidosEmpleado');
        $this->db->from('cat_notificaciones_seguridad');
        $this->db->join('empleados', 'empleados.id = cat_notificaciones_seguridad.empleadosId', 'inner');
		$this->db->where('cat_notificaciones_seguridad.id = ', $id);
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene la visita por id
     */
	public function getMessageByDate($residencialId, $iniDate, $endDate){
		$this->db->select('cat_notificaciones_seguridad.id, cat_notificaciones_seguridad.asunto, cat_notificaciones_seguridad.fechaHora');
        $this->db->from('cat_notificaciones_seguridad');
        $this->db->join('empleados', 'empleados.id = cat_notificaciones_seguridad.empleadosId', 'inner');
		$this->db->where('empleados.residencialId = ', $residencialId);
		if($iniDate != ""){
			$this->db->where('DATE(cat_notificaciones_seguridad.fechaHora) >= ', $iniDate);
		}
		
		if($endDate != ""){
			$this->db->where('DATE(cat_notificaciones_seguridad.fechaHora) <= ', $endDate);
		}
		$this->db->order_by("cat_notificaciones_seguridad.id", "desc"); 
		//$this->db->limit(10);
		return  $this->db->get()->result();
	}

}
//end model