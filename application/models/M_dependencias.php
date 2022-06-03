<?php
class M_dependencias extends CI_Model
{
    private $table = 'Dependencia';
	private $idD = 'iIdDependencia';

    function __construct()
	{
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
    }
    
    //Muestra todas las dependencias
    public function mostrar_dependencias($eje=0,$key=''){

        $this->db->select('d.*');
        $this->db->from('Dependencia d');
        $this->db->where('d.iActivo', 1);
        if($eje > 0 )
        {
        	$this->db->join('DependenciaEje de','de.iIdDependencia = d.iIdDependencia','INNER');
        	$this->db->where('de.iIdEje',$eje);
        }
        if($key != '' ) $this->db->where("( lower(translate(d.\"vDependencia\",'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) ilike lower(translate( '%$key%','áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) OR lower(translate(d.\"vNombreCorto\",'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) ilike lower(translate( '%$key%','áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')))");

		$query =  $this->db->get();
        
        $resultado = $query->result();
        return $resultado;

    }

    //Guarda las dependencias en la DB
	public function guardar_dependencia($data){

		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	//Muestra las dependencias con determinado id
	public function preparar_update($id){

		$this->db->select();
		$this->db->from('Dependencia d');
		$this->db->where($this->idD, $id);

		$query =  $this->db->get()->row();
        
        return $query;

    }
    
    //Modifica las dependencias en la DB
	public function modificar_dependencia($id,$data){

		$this->db->where('iIdDependencia', $id);
		return $this->db->update('Dependencia', $data);
		
	}

	//Cambia de estatus activo a inactivo(Metoo de eliminacion)
	public function eliminar_dependencia($id){

		$data = array('iActivo' => 0);

		$this->db->where('iIdDependencia', $id);
		return $this->db->update('Dependencia',$data);
	}

	public function get_ejes($iIdDependencia)
	{
		$this->db->select('d.iIdEje, p.vEje');
		$this->db->from('DependenciaEje d');
		$this->db->join('PED2019Eje p','p.iIdEje = d.iIdEje','INNER');
		$this->db->where('d.iIdDependencia',$iIdDependencia);

		return $this->db->get();
	}
}

?>