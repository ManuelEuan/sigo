<?php
class M_logs extends CI_Model{

    function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

    function obtenerLogs(){
        $this->db->select('
			lg.*, us.vNombre as uNombre, us.vPrimerApellido, us.vSegundoApellido, dp.vDependencia

		');
		$this->db->from('Logs lg');
        $this->db->join('Usuario us','lg.iIdUsuario = us.iIdUsuario','JOIN');
        $this->db->join('Dependencia dp','us.iIdDependencia = dp.iIdDependencia','JOIN');
		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
    }

	function obtenerCambios($id){
		$this->db->select();
		$this->db->from('Logs');
		$this->db->where('iIdLog', $id);
		$query = $this->db->get();
		$resultado = $query->row();
		return $resultado;
	}
	public function updateLog($idLog,$data)
	{
		//$this->db->insert('ActividadLineaAccion', $data);
		$this->db->where('iIdLog', $idLog);
		return $this->db->update('Logs', $data);
	}


}
?>