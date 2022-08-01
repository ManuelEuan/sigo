<?php
class M_proyectosPOA extends CI_Model{

    function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

    function obtenerProyectosPOAS(){
        $this->db->select();
		$this->db->from('proyectosPOA');
		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
    }

}

?>