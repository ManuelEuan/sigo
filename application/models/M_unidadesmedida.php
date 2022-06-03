<?php
class M_unidadesmedida extends CI_Model {

	function __construct(){
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
	}

	/* MOSTRAR DATOS */

	public function mostrar_um($keyword = null){
        $this->db->select();
		$this->db->from('UnidadMedida');	
		$this->db->where('iActivo', 1);

		if (!empty($keyword) && $keyword != null){
			$this->db->where("(\"vUnidadMedida\" ilike '%$keyword%')");
		}
		$query =  $this->db->get();
        
        $resultado = $query->result();
        return $resultado;
    }
    
    /* AGREGAR DATOS */

	public function insertarUM($data){
		$this->db->insert('UnidadMedida', $data);
		return $this->db->insert_id();
	}

	/* MODIFICAR DATOS */

	public function preparar_update($id){
        $this->db->select();
		$this->db->from('UnidadMedida');
		$this->db->where('iIdUnidadMedida', $id);

		$query =  $this->db->get()->row();
        
        return $query;
	}	

	public function modificarUM($id, $data){
		$this->db->where('iIdUnidadMedida', $id);	   

		return $this->db->update('UnidadMedida', $data);
	}

	/* ELIMINAR DATOS */
	public function eliminarUM($id){
		$this->db->where('iIdUnidadMedida', $id);
		$data = array('iActivo' => 0);
		$this->db->update('UnidadMedida', $data);
		return $this->db->affected_rows();
	}
}