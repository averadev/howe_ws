<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Visit_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene los mensaje de las visitas por residencial
     */
	public function getVisitOfResidential($residencialId){
		$this->db->select('registro_visitas.id, registro_visitas.nombreVisitante, registro_visitas.motivo, registro_visitas.fechaHora, registro_visitas.proveedor');
		$this->db->select('condominios.nombre as nombreCondominio');
        $this->db->from('registro_visitas');
		$this->db->join('condominios', 'condominios.id = registro_visitas.condominiosId', 'inner');
		$this->db->where('condominios.residencialId = ', $residencialId);
		//$this->db->where('condominios.status = 1');
		return  $this->db->get()->result();
	}
	
	 /**
     * Obtiene los condiminios por residencial
     */
	public function getCondominiumByResidencial($residencialId){
		$this->db->select('condominios.id, condominios.nombre');
        $this->db->from('condominios');
		$this->db->where('condominios.residencialId = ', $residencialId);
		$this->db->where('condominios.status = 1');
		return  $this->db->get()->result();
	}
	
	/**
	** Obtiene los condiminios por residencial
    **/
	public function getVisitByDateAndFilter($residencialId, $iniDate, $endDate, $idCondominium){
		$this->db->select('registro_visitas.id, registro_visitas.nombreVisitante, registro_visitas.motivo, registro_visitas.fechaHora, registro_visitas.proveedor');
		$this->db->select('condominios.nombre as nombreCondominio');
        $this->db->from('registro_visitas');
		$this->db->join('condominios', 'condominios.id = registro_visitas.condominiosId', 'inner');
		$this->db->where('condominios.residencialId = ', $residencialId);
		if($iniDate != ""){
			$this->db->where('DATE(registro_visitas.fechaHora) >= ', $iniDate);
		}
		if($endDate != ""){
			$this->db->where('DATE(registro_visitas.fechaHora) <= ', $endDate);
		}
		if($idCondominium != 0){
			$this->db->where('registro_visitas.condominiosId = ', $idCondominium);
		}
		
		//$this->db->where('condominios.status = 1');
		return  $this->db->get()->result();
	}
	
	/**
	** Obtiene los condiminios por residencial
    **/
	public function getVisitById($id){
		$this->db->select('registro_visitas.id, registro_visitas.nombreVisitante, registro_visitas.motivo, registro_visitas.fechaHora');
		$this->db->select('registro_visitas.idFrente, registro_visitas.idVuelta, registro_visitas.proveedor');
		$this->db->select('empleados.nombre as nameEmplado, empleados.apellidos as apellidosEmpleados');
		$this->db->select('condominios.nombre as nombreCondominio');
        $this->db->from('registro_visitas');
		$this->db->join('empleados', 'empleados.id = registro_visitas.empleadosId', 'inner');
		$this->db->join('condominios', 'condominios.id = registro_visitas.condominiosId', 'inner');
		$this->db->where('registro_visitas.id = ', $id);
		return  $this->db->get()->result();
	}
	
}
//end model