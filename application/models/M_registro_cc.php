<?php
class M_registro_cc extends CI_Model {


	private $tabla = 'Financiamiento';
	private $idTabla = 'iIdRegistro';

	function __construct()
	{
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
	}

	//Muestra todas las fuentes de financiamiento
	public function mostrar_registros($keyword = null,$where='')
	{              
        $this->db->select('r.*, m.vMunicipio, p.vProgramaCC, mo.vMotivoCC');
		$this->db->from('RegistroCC r');
		$this->db->join('Municipio m','m.iIdMunicipio = r.iIdMunicipio','INNER');
		$this->db->join('ProgramaCC p','p.iIdProgramaCC = r.iIdProgramaCC','LEFT OUTER');
		$this->db->join('MotivoCC mo','mo.iIdMotivoCC = r.iIdMotivoCC','LEFT OUTER');
		$this->db->where('r.iActivo', 1);
		
		if (!empty($keyword) && $keyword != null)
		{
			//$this->db->where("(r.\"vNombre\" ilike '%$keyword%' or r.\"vProblemaWeb\" ilike '%$keyword%')");

			$this->db->where("(lower(translate(CONCAT(r.\"vNombre\",' ',r.\"vPrimerApellido\",' ',r.\"vSegundoApellido\"),'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) ilike lower(translate('%$keyword%','áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU'))) OR (lower(translate(mo.\"vMotivoCC\",'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) ilike lower(translate('%$keyword%','áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')))");
		}

		if($where != '')
		{
			$this->db->where($where);
		}

		$query =  $this->db->get();
        $resultado = $query->result();
        return $resultado;
	}	

	public function consultar_registro($id){

		$this->db->select();
		$this->db->from('RegistroCC f');
		$this->db->where($this->idTabla, $id);

		$query =  $this->db->get()->row();
        
        return $query;
	}

	//Muestra todas las fuentes de financiamiento
	public function resumen_llamadas($where='')
	{              
        $this->db->select('p."vProgramaCC", COUNT(r."iIdRegistro") AS llamadas');
		$this->db->from('RegistroCC r');
		$this->db->join('ProgramaCC p','p.iIdProgramaCC = r.iIdProgramaCC','LEFT OUTER');
		$this->db->where('r.iActivo', 1);
		$this->db->group_by('p.iIdProgramaCC');
		$this->db->order_by('p.vProgramaCC');
		
		if($where != '')
		{
			$this->db->where($where);
		}

		$query =  $this->db->get();
        $resultado = $query->result();
        return $resultado;
	}	
}
