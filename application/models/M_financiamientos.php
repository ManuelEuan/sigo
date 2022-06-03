<?php
class M_financiamientos extends CI_Model {


	private $table = 'Financiamiento';
	private $idF = 'iIdFinanciamiento';

	function __construct()
	{
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
	}

	//Muestra todas las fuentes de financiamiento
	public function mostrar_financiamientos($fuente = null, $anio = null)
	{              
        $this->db->select();
		$this->db->from('Financiamiento f');
		$this->db->where('iActivo', 1);
		
		if (!empty($fuente) && $fuente != null){
			$this->db->where("(\"vClave\" ilike '%$fuente%' or \"vFinanciamiento\" ilike '%$fuente%')");
		}
		if (!empty($anio) && $anio != null){
			$this->db->where('iAnio', $anio);
		}

		$query =  $this->db->get();
        
        $resultado = $query->result();
        return $resultado;
	}

	//Guarda las fuentes de financiamiento en la DB
	public function guardar_financiamiento($data){

		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	//Muestra las fuentes de financiamiento con determinado id
	public function preparar_update($id){

		$this->db->select();
		$this->db->from('Financiamiento f');
		$this->db->where($this->idF, $id);

		$query =  $this->db->get()->row();
        
        return $query;

	}

	//Modifica las fuentes de financiamiento en la DB
	public function modificar_financiamiento($id,$data){

		$this->db->where('iIdFinanciamiento', $id);
		return $this->db->update('Financiamiento', $data);
		
	}

	//Cambia de estatus activo a inactivo(Metoo de eliminacion)
	public function eliminar_financiamiento($id){

		/*$data = array('iActivo' => 0);

		$this->db->where('iIdFinanciamiento', $id);
		return $this->db->update('Financiamiento',$data);*/

		$this->db->where('iIdFinanciamiento', $id);
		$data = array('iActivo' => 0);
		$this->db->update('Financiamiento', $data);
		return $this->db->affected_rows();
	}
	
}
