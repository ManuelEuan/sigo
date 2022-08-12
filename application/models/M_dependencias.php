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

	public function eliminarAreas($id){
		$this->db->where('iIdDependencia', $id);
		$this->db->delete('AreaResponsable');
		return true;
	}

	public function get_ejes($iIdDependencia)
	{
		$this->db->select('d.iIdEje, p.vEje');
		$this->db->from('DependenciaEje d');
		$this->db->join('PED2019Eje p','p.iIdEje = d.iIdEje','INNER');
		$this->db->where('d.iIdDependencia',$iIdDependencia);

		return $this->db->get();
	}

	public function get_areas_responsables($iIdDependencia){
		$this->db->select();
		$this->db->from('AreaResponsable');
		$this->db->where('iIdDependencia', $iIdDependencia);

		return $this->db->get();
	}

	public function delete_area($id){
		$this->db->where('iIdAreaResponsable', $id);
		$this->db->delete('AreaResponsable');
		return true;
	}

	/**
	 * Retorna las dependencias en base al ODS
	 * @param int $odsID
	 */
	public function getDependenciasxODS(){
		$sql = 'SELECT ods."iIdOds", ods."vOds", d."vDependencia", da."iIdDetalleActividad", sum(av."nBeneficiariosH") as hombres, sum(av."nBeneficiariosM") as mujeres FROM "ODS" ods
				INNER JOIN "Actividad" a ON ods."iIdOds" = a."iODS"
				INNER JOIN "DetalleActividad" da ON a."iIdActividad" = da."iIdActividad"
				INNER JOIN "Dependencia" d ON a."iIdDependencia"  = d."iIdDependencia"
				inner join "DetalleEntregable" de on de."iIdDetalleActividad"  = da."iIdDetalleActividad" 
				inner join "Avance" av on de."iIdDetalleEntregable" = av."iIdDetalleEntregable"
				WHERE a."iActivo" = 1
				group by ods."iIdOds", ods."vOds", d."vDependencia", da."iIdDetalleActividad" ';

		return $this->db->query($sql)->result();
	}

	/**
	 * Retorna el avance en base a dependencia, actividad y/o detalle de actividad 
	 * @param string $tipo
	 * @param int $filtroID
	 */
	public function getAvance(string $tipo = 'dependencia', int $filtroID) {
		$this->db->select('av.iIdAvance, av.nBeneficiariosH, av.nBeneficiariosM, a.iIdDependencia, de.iIdDetalleEntregable, da.iIdDetalleActividad, a.iIdActividad');
		$this->db->from('Avance av');
		$this->db->join('DetalleEntregable de', 'av.iIdDetalleEntregable = de.iIdDetalleEntregable', 'INNER');
		$this->db->join('DetalleActividad da', 'de.iIdDetalleActividad = da.iIdDetalleActividad', 'INNER');
		$this->db->join('Actividad a', 'da.iIdActividad = a.iIdActividad', 'INNER');
		$this->db->where('de.iActivo', 1);

		if($tipo == 'dependencia')
			$this->db->where('a.iIdDependencia', $filtroID);
		elseif($tipo == 'actividad')
			$this->db->where('a.iIdActividad', $filtroID);
		elseif($tipo == 'detalleActividad')
			$this->db->where('de.iIdDetalleActividad', $filtroID);

		return $this->db->get()->result();
	}

	/**
	 * Retorna los retos
	 */
	public function getRetos() {
		$this->db->select('r.vDescripcion as reto, eje.vEje');
		$this->db->from('Retos r');
		$this->db->join('EjeRetos ej', 'r.iIdReto = ej.iIdReto', 'INNER');
		$this->db->join('PED2019Eje eje', 'ej.iIdEje = eje.iIdEje', 'INNER');
		$this->db->order_by('r.iIdReto', 'asc');
		$this->db->order_by('eje.iIdEje', 'asc');

		
		return $this->db->get()->result();
	}

	/**
	 * Retorna los proyectos priooritarios
	 */
	public function getPrioritarios(){

	}
}

?>