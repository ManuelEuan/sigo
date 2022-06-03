<?php
class M_preguntas extends CI_Model {


	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default',TRUE);
	}

	//Mostrar Dependencias
	public function inserta_pregunta($datos) {
		return $this->db->insert('Pregunta', $datos);
	}

	public function actualiza_pregunta($datos, $iIdPregunta)
	{
		$this->db->where('iIdPregunta', $iIdPregunta);
		return $this->db->update('Pregunta', $datos);
	}

	public function carga_preguntas($eje='', $anio='', $partido='')
	{
		$this->db->select('iIdPregunta, vPregunta, vRespuesta, iNumero, vBancada, iAnio');
		$this->db->from('Pregunta');
		if($eje != '') $this->db->where('iIdEje', $eje);
		if($anio != '') $this->db->where('iAnio', $anio);
		if($partido != '') $this->db->where('vBancada', $partido);
		$this->db->where('iActivo', 1);

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function eliminar_pregunta($pregid)
	{
		$this->db->set('iActivo', 0);
		$this->db->where('iIdPregunta', $pregid);
		return $this->db->update('Pregunta');
	}

	public function eliminar_doc($pregid)
	{
		$this->db->set('vRuta', '');
		$this->db->where('iIdPregunta', $pregid);
		return $this->db->update('Pregunta');
	}

	public function bancadas()
	{
		$this->db->select('vBancada');
		$this->db->from('Pregunta');
		$this->db->where('iActivo', 1);
		$this->db->group_by('vBancada');

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function datos_preg($pregid)
	{
		$this->db->select('iIdPregunta,vPregunta,iAnio,iIdEje,iIdTema,iIdObjetivo,vRespuesta,vBancada,iIdResponsable, iIdCorresponsable, vRuta');
		$this->db->from('Pregunta');
		$this->db->where('iIdPregunta', $pregid);
		$this->db->where('iActivo', 1);

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function subir_doc($doc, $pregid)
	{
		$this->db->set('vRuta', $doc);
		$this->db->where('iIdPregunta', $pregid);
		return $this->db->update('Pregunta');
	}

	public function anios($anio)
	{		
		$this->db->select('iAnio');
		$this->db->from('Pregunta');
		$this->db->where('iActivo', 1);
		$this->db->group_by('iAnio');
		$this->db->order_by('iAnio','ASC');

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;

	}

}

?>