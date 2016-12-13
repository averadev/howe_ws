<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class suggestion_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene las quejas y sugerencias por residencial
     */
	public function getComplaintsSuggestions($id, $residencialId){
        $this->db->select('cat_quejas_sugerencias.id, cat_quejas_sugerencias.asunto, cat_quejas_sugerencias.fechaHora');
        $this->db->from('cat_quejas_sugerencias');
        $this->db->join('residente', 'residente.id = cat_quejas_sugerencias.residenteId', 'inner');
		$this->db->join('condominios', 'condominios.id = residente.condominioId', 'inner');
		$this->db->where('condominios.residencialId = ', $residencialId);
		$this->db->order_by("cat_quejas_sugerencias.id", "desc"); 
		//$this->db->limit(10);
		return  $this->db->get()->result();
	}	
	
	/**
     * Obtiene el mensaje de sugerencias por id
     */
	public function getSuggestionById($id){
		$this->db->select('cat_quejas_sugerencias.id, cat_quejas_sugerencias.asunto, cat_quejas_sugerencias.mensaje');
		$this->db->select('cat_quejas_sugerencias.fechaHora');
		$this->db->select('residente.nombre as nombreResidente, residente.apellido as apellidosResidente');
        $this->db->from('cat_quejas_sugerencias');
        $this->db->join('residente', 'residente.id = cat_quejas_sugerencias.residenteId', 'inner');
		$this->db->where('cat_quejas_sugerencias.id = ', $id);
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene la visita por id
     */
	public function getSuggestionByDate($residencialId, $iniDate, $endDate){
		$this->db->select('cat_quejas_sugerencias.id, cat_quejas_sugerencias.asunto, cat_quejas_sugerencias.fechaHora');
        $this->db->from('cat_quejas_sugerencias');
         $this->db->join('residente', 'residente.id = cat_quejas_sugerencias.residenteId', 'inner');
		$this->db->join('condominios', 'condominios.id = residente.condominioId', 'inner');
		$this->db->where('condominios.residencialId = ', $residencialId);
		if($iniDate != ""){
			$this->db->where('DATE(cat_quejas_sugerencias.fechaHora) >= ', $iniDate);
		}
		
		if($endDate != ""){
			$this->db->where('DATE(cat_quejas_sugerencias.fechaHora) <= ', $endDate);
		}
		$this->db->order_by("cat_quejas_sugerencias.id", "desc"); 
		//$this->db->limit(10);
		return  $this->db->get()->result();
	}

}
//end model