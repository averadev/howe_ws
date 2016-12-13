<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class condominium_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene los mensajes de la residencia
     */
	public function getCondominium($residencialId){
        $this->db->from('condominios');
		$this->db->where('condominios.residencialId = ', $residencialId);
		$this->db->where('condominios.status = 1');
		return  $this->db->get()->result();
	}
	
	/**
	 * Obtiene los residentes del condominio
	 */
	public function getResidentOfCondominium($condominioId, $residencialId){
		$this->db->select('residente.id, residente.nombre, residente.apellido, residente.email');
		$this->db->from('residente');
		$this->db->join('condominios', 'condominios.id = residente.condominioId', 'inner');
		$this->db->where('residente.condominioId = ', $condominioId);
		$this->db->where('condominios.residencialId = ', $residencialId);
		$this->db->where('residente.status = 1');
		return  $this->db->get()->result();
	}
	
	//obtiene los datos de la residencia por idate
	public function getCondoById($id, $residencialId){
		$this->db->from('condominios');
		$this->db->where('condominios.id = ', $id);
		$this->db->where('condominios.residencialId = ', $residencialId);
		return  $this->db->get()->result();
	}
	
	//obtiene los datos de la residencia por idate
	public function getCondominiumSearch($residencialId, $dato){
		$this->db->from('condominios');
		$this->db->where('condominios.residencialId = ', $residencialId);
		$this->db->where('(condominios.nombre LIKE \'%'.$dato.'%\')', NULL); 
		$this->db->where('condominios.status = 1');
		return  $this->db->get()->result();
	}
	
	//obtiene los residentes por condominio
	public function getResidentByCondominium($id, $residencialId){
		$this->db->select('residente.nombre, residente.apellido, residente.email');
		$this->db->from('residente');
		$this->db->where('residente.condominioId = ', $condominioId);
		$this->db->where('residente.status = 1');
		return  $this->db->get()->result();
	}
	
	//obtiene los residentes por condominio
	public function getResidentByResidential($residencialId){
		$this->db->select('residente.id, residente.nombre, residente.apellido, residente.email');
		$this->db->from('residente');
		$this->db->join('condominios', 'condominios.id = residente.condominioId', 'inner');
		$this->db->where('condominios.residencialId = ', $residencialId);
		$this->db->where('residente.status = 1');
		$this->db->group_by("residente.email"); 
		return  $this->db->get()->result();
	}
	
	//obtiene la info del residente por id
	public function getResidentById($id){
		$this->db->select('residente.id, residente.nombre, residente.apellido, residente.email, residente.telefono');
		$this->db->from('residente');
		$this->db->where('residente.id = ', $id);
		return  $this->db->get()->result();
	}
	
	//obtiene la info del residente por id
	public function getResidentAllById($id){
		$this->db->from('residente');
		$this->db->where('residente.id = ', $id);
		return  $this->db->get()->result();
	}

	//inserta los datos del condominio
	public function insertCodominium($data){
		$this->db->insert('condominios', $data);
	}
	
	//actualiza el nombre del condominio
	public function updateCodominium($data){
		
		$this->db->where('id', $data['id']);
		$this->db->where('residencialId', $data['residencialId']);
		$this->db->update('condominios', $data); 
		
	}
	
	//inserta los datos de residentes
	public function insertResident($data){
		$this->db->insert('residente', $data);
	}
	
	//actualiza los datos del residente
	public function updateResident($data){
		$this->db->where('id', $data['id']);
		$this->db->update('residente', $data);
	}
	
}
//end model