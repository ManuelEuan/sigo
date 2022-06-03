<?php
class M_ubps extends CI_Model {

	function __construct(){
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
	}

	/* MOSTRAR DATOS */

	public function mostrar_ubps($keyword = null, $year = null){
        $this->db->select();
		$this->db->from('UBP');	
		$this->db->where('iActivo', 1);

		if (!empty($keyword) && $keyword != null){
			$this->db->where("(\"vClave\" ilike '%$keyword%' or \"vUBP\" ilike '%$keyword%')");
		}
		if (!empty($year) && $year != null){
			$this->db->where('iAnio', $year);
		}
		
		$query =  $this->db->get();
        
        $resultado = $query->result();
        return $resultado;
	}

	/* AGREGAR DATOS */

	public function insertarUBP($data){
		$this->db->insert('UBP', $data);
		return $this->db->insert_id();
	}

	/* MODIFICAR DATOS */

	public function preparar_update($id){
        $this->db->select();
		$this->db->from('UBP u');
		$this->db->join('Dependencia d','u.iIdDependencia = d.iIdDependencia','JOIN');
		$this->db->join('TipoUBP t','t.iIdTipoUbp = u.iIdTipoUbp','JOIN');
		$this->db->join('ProgramaPresupuestario pp','pp.iIdProgramaPresupuestario = u.iIdProgramaPresupuestario','left outer');
		$this->db->where('iIdUbp', $id);

		$query =  $this->db->get()->row();
        
        return $query;
	}	

	public function modificarUBP($id, $data){
		$this->db->where('iIdUbp', $id);	   

		return $this->db->update('UBP', $data);
	}

	/* ELIMINAR DATOS */
	public function eliminarUBP($id){
		$this->db->where('iIdUbp', $id);
		$data = array('iActivo' => 0);
		$this->db->update('UBP', $data);
		return $this->db->affected_rows();
	}
}