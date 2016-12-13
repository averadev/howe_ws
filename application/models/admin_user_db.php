<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class admin_user_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function insert($data){
        $this->db->insert('admin_user', $data);
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function update($data){
        $this->db->where('id', $data['id']);
        $this->db->update('admin_user', $data);
    }
 
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function get($data){
        $this->db->from('empleados');
        $this->db->where($data);
        return $this->db->get()->result();
    }
	
	 /**
     * verifica que el administrador sea correcto
     */
    public function getAdmin($data){
        $this->db->from('admin_user');
        $this->db->where($data);
        return $this->db->get()->result();
    }
	
	/**
	 * verifica si el correo existe
	 */
	public function chechMail($email){
		$this->db->select('id');
		$this->db->from('partner');
		$this->db->where('email = ', $email);
		return $this->db->get()->result();
	}
	
	/**
	 * cambia la contraseña del comercio
	 */
	 
	public function updatePassword($data){
		$this->db->where('id', $data['id']);
		$this->db->update('partner', $data);
	}

}
//end model