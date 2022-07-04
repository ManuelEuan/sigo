<?php
class M_catalogos extends CI_Model {


	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default',TRUE);
	}

	//Mostrar Dependencias
	public function dependencias($where=''){
		$this->db->order_by('vDependencia');
        $this->db->select('iIdDependencia AS id , vDependencia AS valor');
		$this->db->from('Dependencia');
		$this->db->where('iActivo',1);
		
		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	//Mostrar dependencias con eje
	public function dependencias_nombre_largo($where=''){

        $this->db->select('d.iIdDependencia AS id , d.vDependencia AS valor');
		$this->db->from('Dependencia  d');
		$this->db->join('DependenciaEje de','de.iIdDependencia = d.iIdDependencia','LEFT OUTER');
		$this->db->order_by('d.vDependencia');
		$this->db->where('d.iActivo',1);

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	//Mostrar estatus
	public function estatus($where=''){

		$this->db->select('e.iIdEstatus AS id , e.vEstatus AS valor');
		$this->db->from('Estatus e');
		$this->db->where('e.iActivo',1);
		$this->db->order_by('e.iIdEstatus', 'asc');

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	//Mostrar Roles
	public function roles($where=''){

		$this->db->order_by('vRol', 'asc');
        $this->db->select('iIdRol AS id , vRol AS valor');
		$this->db->from('Rol');
		$this->db->where('iActivo',1);

		if($where != '') $this->db->where($where);

		return $this->db->get();

	}

	//Mostrar maximo nivel academico
	public function maximo_nivel_academico($where=''){

		$this->db->order_by('iIdMaxNivelAcademico', 'asc');
        $this->db->select('iIdMaxNivelAcademico AS id , vNivelAcademico AS valor');
		$this->db->from('MaxNivelAcademico');
		$this->db->where('iActivo',1);

		if($where != '') $this->db->where($where);

		return $this->db->get();
		
	}

	//Mostrar formacion academica
	public function formacion_academica($where=''){

		$this->db->order_by('vFormacionAcademica', 'asc');
        $this->db->select('iIdFormacionAcademica AS id , vFormacionAcademica AS valor');
		$this->db->from('FormacionAcademica');
		$this->db->where('iActivo',1);

		if($where != '') $this->db->where($where);

		return $this->db->get();
		
	}

	//Mostrar Tipo de UBP
	public function tipo_ubps($where=''){

		$this->db->order_by('vTipoUbp', 'asc');
        $this->db->select('iIdTipoUbp AS id , vTipoUbp AS valor');
		$this->db->from('TipoUBP');
		$this->db->where('iActivo',1);

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	//Mostrar Programa Presupuestario
	public function programa_presupuestario($where=''){

		$this->db->order_by('vProgramaPresupuestario', 'asc');
        $this->db->select('"iIdProgramaPresupuestario" AS id , CONCAT("vProgramaPresupuestario",\' [\',"iNumero",\']\') AS valor');
		$this->db->from('ProgramaPresupuestario');
		$this->db->where('iActivo',1);

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	//Mostrar UBP
	public function ubps($where=''){

		$this->db->order_by('vUBP', 'asc');
        $this->db->select('iIdUbp AS id , vUBP AS valor');
		$this->db->from('UBP');
		$this->db->where('iActivo',1);

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	//Mostrar financiamiento
	public function financiamiento($where=''){

		$this->db->order_by('vFinanciamiento', 'asc');
        $this->db->select('iIdFinanciamiento AS id , vFinanciamiento AS valor');
		$this->db->from('Financiamiento');
		$this->db->where('iActivo',1);

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	//Mostrar eje
	public function eje($where=''){

	
        $this->db->select('iIdEje AS id , vEje AS valor');
		$this->db->from('PED2019Eje');	
		$this->db->order_by('iIdEje');
		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	//Mostrar periodicidad
	public function periodicidad($where=''){

		$this->db->select('iIdPeriodicidad AS id, vPeriodicidad AS valor ');
		$this->db->from('Periodicidad');
		$this->db->where('iActivo',1);
		$this->db->order_by('vPeriodicidad');

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	//Mostrar unidades de medida
	public function unidades_medida($where=''){

		$this->db->select('iIdUnidadMedida AS id, vUnidadMedida AS valor ');
		$this->db->from('UnidadMedida');
		$this->db->where('iActivo',1);
		$this->db->order_by('vUnidadMedida');

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	//Mostrar sujeto afectado
	public function sujeto_afectado($where=''){

		$this->db->select('iIdSujetoAfectado AS id, vSujetoAfectado AS valor ');
		$this->db->from('SujetoAfectado');
		$this->db->where('iActivo',1);
		$this->db->order_by('vSujetoAfectado');

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	//Mostrar compromisos
	public function compromisos($where=''){

		$this->db->select('iIdCompromiso AS id, vCompromiso AS valor ');
		$this->db->from('Compromiso');
		$this->db->where('iActivo',1);
		$this->db->order_by('vCompromiso');

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	//Mostrar componentes
	public function componentes($where=''){

		$this->db->select('iIdComponente AS id, vComponente AS valor ');
		$this->db->from('Componente');
		$this->db->where('iActivo',1);
		$this->db->order_by('vComponente');

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	//Muestra los componentes dependiendo el compromiso seleccionado
	public function componentes_compromiso($where=''){

		$this->db->select('c.iIdComponente AS id, c.vComponente AS valor ');
		$this->db->from('Componente c');
		$this->db->join('Compromiso cp','c.iIdCompromiso = cp.iIdCompromiso','INNER');
		$this->db->where('c.iActivo',1);
		$this->db->where('cp.iActivo',1);
		$this->db->order_by('c.vComponente');

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	//Muestra los temas
	public function tema($where=''){
		$this->db->order_by('vTema');
		$this->db->select('iIdTema AS id, vTema AS valor ');
		$this->db->from('PED2019Tema');
		// $this->db->where('iActivo',1);
		
		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	//Muestra los objetivos
	public function objetivo($where='')
	{
		$this->db->order_by('vObjetivo');
		$this->db->select('iIdObjetivo as id, vObjetivo as valor');
		$this->db->from('PED2019Objetivo');

		if($where != '') $this->db->where($where);
		return $this->db->get();
	}

	//Muestra los municipios
	public function municipios($where=''){

		$this->db->select('iIdMunicipio AS id, vMunicipio AS valor ');
		$this->db->from('Municipio');
		$this->db->order_by('vMunicipio');

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	public function dependencia($where=''){
		$this->db->order_by('vDependencia');
        $this->db->select('d.iIdDependencia AS id , d.vDependencia AS valor');
		$this->db->from('Dependencia d');
		$this->db->join('DependenciaEje de','de.iIdDependencia = d.iIdDependencia','INNER');	
		$this->db->where('d.iActivo',1);	
		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	public function dependenciaSelector($where=''){
		$this->db->order_by('vDependencia');
        $this->db->select('d.iIdDependencia AS id , d.vDependencia AS valor');
		$this->db->from('Dependencia d');
		$this->db->where('d.iActivo',1);	
		if($where != '') $this->db->where($where);
		return $this->db->get();
	}

	public function programascc($where=''){

		$this->db->select('iIdProgramaCC AS id, vProgramaCC AS valor ');
		$this->db->from('ProgramaCC');
		$this->db->order_by('vProgramaCC');

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	public function motivoscc($where=''){

		$this->db->select('iIdMotivoCC AS id, vMotivoCC AS valor ');
		$this->db->from('MotivoCC');
		$this->db->order_by('iIdMotivoCC');

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	public function det_entregables($where=''){

		$this->db->select('de.iIdDetalleEntregable AS id, e.vEntregable AS valor ');
		$this->db->from('DetalleEntregable de');
		$this->db->join('Entregable e','e.iIdEntregable = de.iIdEntregable','INNER');
		$this->db->where('de.iActivo',1);
		$this->db->where('e.iActivo',1);
		$this->db->order_by('e.vEntregable');

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}	

	public function PermisoPadre($where=''){

		$this->db->order_by('vPermiso', 'asc');
        $this->db->select('"iIdPermiso" AS id , CONCAT("vPermiso",\' (\' , "iIdPermiso",\')\' ) AS valor',false);
		$this->db->from('Permiso');
		$this->db->where('iIdPermisoPadre',0);
		$this->db->where('iTipo',1);

		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	public function ods($where=''){
		$this->db->order_by('o.iNumero');
        $this->db->select('o."iIdOds" AS id , CONCAT(o."iNumero",\' \', o."vOds") AS valor',false);
		$this->db->from('ODS o');
		if($where != '') $this->db->where($where);

		return $this->db->get();
	}

	public function retos($where=''){
        $this->db->select('o.iIdReto as id, o.vDescripcion as valor');
		$this->db->from('Reto o');
		if($where != '') $this->db->where($where);

		return $this->db->get();
	}
}

?>