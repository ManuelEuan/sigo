<?php

class M_eje extends CI_Model {

    function __construct(){
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
       // $this->ssop = $this->load->database('ssop',TRUE);
	}


    function obtenerRetos(){
		$this->db->select();
		$this->db->from('Reto');

		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
    }

}

?>