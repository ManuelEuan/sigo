<?php

class M_admin extends CI_Model {

	function __construct()
	{
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
    }

    //Muestra todos los usuarios
    public function mostrar_permisos($where=null)
    {
        $this->db->select();
        $this->db->from('Permiso p');
        if($where != null) $this->db->where($where);
		$query =  $this->db->get();
               
        return $query;
    }

    function next_permiso_id()
    {
        $sql = 'SELECT MAX("iIdPermiso") + 1 AS id FROM "Permiso";';

        return $this->db->query($sql)->row()->id;
    }
}
?>