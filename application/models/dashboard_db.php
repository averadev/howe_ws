<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class dashboard_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene los mensajes de la residencia
     */
	public function getMessageDash($id, $residencialId){
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
        $this->db->select('registro_visitas.id, registro_visitas.motivo, registro_visitas.fechaHora, registro_visitas.proveedor');
		$this->db->select('condominios.nombre as nameCondominium');
        $this->db->from('registro_visitas');
        $this->db->join('empleados', 'empleados.id = registro_visitas.empleadosId', 'inner');
		$this->db->join('condominios', 'condominios.id = registro_visitas.condominiosId', 'inner');
		$this->db->where('empleados.residencialId = ', $residencialId);
		$this->db->order_by("registro_visitas.id", "desc"); 
		//$this->db->limit(10);
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
	public function getVisitById($id){
		$this->db->select('registro_visitas.id, registro_visitas.nombreVisitante, registro_visitas.motivo, registro_visitas.fechaHora');
		$this->db->select('empleados.nombre as nombreEmpleado, empleados.apellidos as apellidosEmpleado');
		$this->db->select('condominios.nombre as nombreCondominio');
        $this->db->from('registro_visitas');
        $this->db->join('empleados', 'empleados.id = registro_visitas.empleadosId', 'inner');
		$this->db->join('condominios', 'condominios.id = registro_visitas.condominiosId', 'inner');
		$this->db->where('registro_visitas.id = ', $id);
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene los mensajes por paginador
     */
	public function getMessagePaginador($num, $dato, $id, $residencialId){
		$this->db->select('cat_notificaciones_seguridad.id, cat_notificaciones_seguridad.asunto, cat_notificaciones_seguridad.fechaHora');
        $this->db->from('cat_notificaciones_seguridad');
        $this->db->join('empleados', 'empleados.id = cat_notificaciones_seguridad.empleadosId', 'inner');
		$this->db->where('empleados.residencialId = ', $residencialId);
		$this->db->order_by("cat_notificaciones_seguridad.id", "desc"); 
		//$this->db->limit(10);
	}
	
	/**
	 * Obtiene las residenciales
	 */
	public function getResidencialDash(){
		$this->db->select('residencial.id, residencial.nombre, residencial.nombreContacto');
		$this->db->select('(select count(*) from empleados where residencial.id = empleados.residencialId and empleados.catPuestosId = 1 and empleados.status = 1 ) as totalUsuarios');
        $this->db->from('residencial');
		$this->db->where('residencial.status = 1');
		return  $this->db->get()->result();
	}
	
	/**
	 * obtiene los condominios y total de usuarios por residencial
	 */
	public function getConsominiumByResidencial($residencialId){
		$this->db->select('condominios.id, (select count(*) from residente where residente.condominioId = condominios.id ) as totalUser');
        $this->db->from('condominios');
		$this->db->where('condominios.residencialId = ', $residencialId);
		return  $this->db->get()->result();
	}
	
	/**
	* obtiene el nombre de las ciudades
	**/
	public function getCities($dato){
            $this->db->select('ciudades.id, ciudades.nombre');
            $this->db->from('ciudades');
            $this->db->like('ciudades.nombre', $dato);
            return  $this->db->get()->result();
	}
	
	/**
	 * Obtiene las residenciales
	 */
	public function getResidentialById($id){
		$this->db->select('residencial.id, residencial.nombre, residencial.ciudadesId, residencial.telAdministracion, residencial.telCaseta');
		$this->db->select('residencial.telLobby, residencial.nombreContacto, residencial.telContacto, residencial.emailContacto, residencial.requiereFoto');
		$this->db->select('ciudades.nombre as nombreCiudad');
        $this->db->from('residencial');
		$this->db->join('ciudades', 'ciudades.id = residencial.ciudadesId', 'inner');
		$this->db->where('residencial.status = 1');
		$this->db->where('residencial.id = ', $id);
		return  $this->db->get()->result();
	}
	
	/**
	* Inserta los datos de la residencia
	**/
	public function insertResidential($data){
		$this->db->insert('residencial', $data);
	}
	
	/**
	* actualiza los datos de la residencia
	**/
	public function updateResidential($data){
		$this->db->where('id', $data['id']);
		$this->db->update('residencial', $data);	
	}
	
	/**
	 * Obtiene la info de los usuarios por residencial
	 */
	public function getUserByResidencial(){
		$this->db->select('cat_notificaciones_seguridad.id, cat_notificaciones_seguridad.asunto, cat_notificaciones_seguridad.fechaHora');
        $this->db->from('cat_notificaciones_seguridad');
        $this->db->join('empleados', 'empleados.id = cat_notificaciones_seguridad.empleadosId', 'inner');
		$this->db->where('empleados.residencialId = ', $residencialId);
		$this->db->where('empleados.status = 1');
		return  $this->db->get()->result();
	}
	
	/**
	* obtiene los datos de la residencia por id
	**/
	public function getUserByResidencial2($residencialId){
		$this->db->select('empleados.id, empleados.nombre, empleados.apellidos, empleados.email');
        $this->db->from('empleados');
		$this->db->where('empleados.residencialId = ', $residencialId);
		$this->db->where('empleados.catPuestosId = 1');
		$this->db->where('empleados.status = 1');
		return  $this->db->get()->result();
	}
	
	/**
	 * inserta los datos del empleado
	 */
	public function insertEmpleado($data){
		$this->db->insert('empleados', $data);
	}
	
	/**
	 * inserta los datos del empleado
	 */
	public function updateEmpleado($data){
		$this->db->where('id', $data['id']);
		$this->db->update('empleados', $data);
	}
	
	public function getUserById($id){
		$this->db->select('empleados.id, empleados.nombre, empleados.apellidos, empleados.email, empleados.telefono, empleados.direccion');
		$this->db->select('empleados.estado, empleados.ciudad');
        $this->db->from('empleados');
		$this->db->where('empleados.id = ', $id);
		return  $this->db->get()->result();
	}

}
//end model