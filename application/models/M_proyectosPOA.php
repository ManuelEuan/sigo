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

	function obtenerSeleccionados(){

		$sql = 'SELECT * FROM "DetalleActividad" detAct
            INNER JOIN "Actividad" act on act."iIdActividad" = detAct."iIdActividad" 
			INNER JOIN "Dependencia" d on d."iIdDependencia" = act."iIdDependencia" 
			INNER JOIN "DependenciaEje" de on de."iIdDependencia" = d."iIdDependencia"';
		
		return $this->db->query($sql)->result();

	}

}

?>