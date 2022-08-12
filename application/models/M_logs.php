<?php
class M_logs extends CI_Model{

    function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

    function obtenerLogs(){
        $this->db->select();
		$this->db->from('Logs');
		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
    }
}
?>