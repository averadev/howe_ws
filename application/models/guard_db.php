<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class guard_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene los mensajes de la residencia
     */
	public function getGuard($residencialId){
		$this->db->select('empleados.id, empleados.nombre, empleados.apellidos');
        $this->db->from('empleados');
		$this->db->where('empleados.residencialId = ', $residencialId);
		$this->db->where('empleados.catPuestosId = 2');
		$this->db->where('empleados.status > 0');
		return  $this->db->get()->result();
	}
	
	//obtiene los datos de la residencia por idate
	public function getGuardById($id, $residencialId){
		$this->db->select('empleados.id, empleados.nombre, empleados.apellidos, empleados.telefono, empleados.direccion');
		$this->db->select('empleados.ciudad, empleados.estado, empleados.foto, empleados.email');
		$this->db->from('empleados');
		$this->db->where('empleados.id = ', $id);
		return  $this->db->get()->result();
	}
	
	//obtiene los datos de la residencia por idate
	public function getGuardSearch($residencialId, $dato){
		$this->db->select('empleados.id, empleados.nombre, empleados.apellidos');
        $this->db->from('empleados');
		$this->db->where('empleados.status > 0');
		$this->db->where('empleados.residencialId = ', $residencialId);
		$this->db->where('empleados.catPuestosId = 2');
		$this->db->where('(empleados.nombre LIKE \'%'.$dato.'%\' OR empleados.apellidos LIKE \'%'.$dato.'%\')', NULL); 
		return  $this->db->get()->result();
	}

	//inserta los datos del condominio
	public function insertGuard($data){
		$this->db->insert('empleados', $data);
	}
	
	//actualiza el nombre del condominio
	public function updateGuard($data){
		
		$this->db->where('id', $data['id']);
		$this->db->update('empleados', $data); 
		
	}
	
	//actualiza el nombre del condominio
	public function deleteGuard($id, $residencialId){
		
		$this->db->set('status', 0);
		$this->db->where('id', $id);
		$this->db->where('residencialId', $residencialId);
		$this->db->update('empleados');
		
	}
	
}
//end model