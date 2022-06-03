<?php
class M_dash2 extends CI_Model {

	function __construct(){
		parent::__construct();
        $this->sigo = $this->load->database('default',TRUE);
       // $this->ssop = $this->load->database('ssop',TRUE);
	}

	function AniosDep($idDep)
	{
		$sql = 'SELECT da."iAnio" FROM "Actividad" act
		INNER JOIN "DetalleActividad" da ON da."iIdActividad" = act."iIdActividad" AND da."iActivo" = 1
		WHERE act."iIdDependencia" = '.$idDep.'
		GROUP BY da."iAnio"
		ORDER BY da."iAnio" DESC';

		$query = $this->sigo->query($sql);
		return $query;
	}

	function buscar_dep($text, $anio = 0)
	{
		
		$this->sigo->select('d.iIdDependencia, d.vDependencia, d.vNombreCorto, COUNT(act."vActividad") numact, SUM(dat."nAvance") sumavance');
		$this->sigo->from('Dependencia d');
		$this->sigo->join('Actividad act','act.iIdDependencia = d.iIdDependencia','INNER');
		if($anio == 0){
			$this->sigo->join('DetalleActividad dat', 'dat.iIdActividad = act.iIdActividad AND dat.iActivo = 1', 'INNER');	
		} else {
			$this->sigo->join('DetalleActividad dat', 'dat.iIdActividad = act.iIdActividad AND dat.iActivo = 1 AND dat.iAnio ='.$anio, 'INNER');
		}
		
		
		$this->sigo->where("( lower(translate(d.\"vDependencia\",'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) ilike lower( translate('%$text%','áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) OR lower(translate(d.\"vNombreCorto\",'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) ilike lower( translate('%$text%','áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) )");
		$this->sigo->group_by('d.iIdDependencia, d.vDependencia, d.vNombreCorto');
		$this->sigo->order_by('d.vDependencia');
		
		return $query = $this->sigo->get();
	}

	function datos_dep($idDep, $anio = 0)
	{
		if($anio == 0) $anio = date('Y');
		$this->sigo->select('d.iIdDependencia, d.vDependencia, d.vNombreCorto, COUNT(act."vActividad") numact, SUM(dat."nAvance") sumavance');
		$this->sigo->from('Dependencia d');
		$this->sigo->join('Actividad act','act.iIdDependencia = d.iIdDependencia','LEFT OUTER');
		$this->sigo->join('DetalleActividad dat', 'dat.iIdActividad = act.iIdActividad AND dat.iActivo = 1 AND dat.iAnio ='.$anio, 'LEFT OUTER');
		
		$this->sigo->where('d.iIdDependencia',$idDep);
		$this->sigo->group_by('d.iIdDependencia, d.vDependencia, d.vNombreCorto');
		$this->sigo->order_by('d.vDependencia');
		
		return $query = $this->sigo->get()->row();
	}

	function compromisos_by_dep($idDep)
	{
		$sql = 'SELECT e."vEstatus", e."vColor", c."iNumero", c."vCompromiso", c."dPorcentajeAvance"
				FROM "Compromiso" c
				INNER JOIN "Estatus" e ON e."iIdEstatus" = c."iEstatus"
				WHERE c."iActivo" = 1 AND c."iIdDependencia" = '.$idDep.'
				ORDER BY c."iNumero"';

		return $this->sigo->query($sql);
	}

	function compromisos_estatus_by_dep($idDep)
	{
		$sql = 'SELECT e."vEstatus", e."vColor", COUNT(c."iNumero") AS numcomp
				FROM "Compromiso" c
				INNER JOIN "Estatus" e ON e."iIdEstatus" = c."iEstatus"
				WHERE c."iActivo" = 1 AND c."iIdDependencia" = '.$idDep.'
				GROUP BY e."vEstatus", e."vColor"
				ORDER BY e."vEstatus"';
				
		return $this->sigo->query($sql);
	}

	function avance_dep_by_anio($idDep,$anio)
	{
		$sql = 'SELECT dat."iAnio", COUNT(act."vActividad") numact, SUM(dat."nAvance") sumaavance
				FROM "Dependencia" dep
				INNER JOIN "Actividad" act ON act."iIdDependencia" = dep."iIdDependencia"
				INNER JOIN "DetalleActividad" dat ON dat."iIdActividad" = act."iIdActividad" AND dat."iActivo" = 1
				WHERE dep."iIdDependencia" = '.$idDep.' AND dat."iAnio" = '.$anio.'
				GROUP BY dat."iAnio"
				ORDER BY dat."iAnio" DESC';
		return $this->sigo->query($sql)->result();
	}

	function num_acts_by_dep($idDep,$anio)
	{
		$sql = 'SELECT COUNT(act."vActividad") num
				FROM "Dependencia" dep
				INNER JOIN "Actividad" act ON act."iIdDependencia" = dep."iIdDependencia"
				INNER JOIN "DetalleActividad" dat ON dat."iIdActividad" = act."iIdActividad" AND dat."iActivo" = 1 AND dat."iAnio" = '.$anio.'
				WHERE dep."iIdDependencia" = '.$idDep.'
				GROUP BY dep."iIdDependencia"';
		return ($this->sigo->query($sql)->num_rows() > 0) ? $this->sigo->query($sql)->row()->num:0;
	}

	function num_ent_by_dep($idDep,$anio)
	{
		$sql = 'SELECT COUNT(det."iIdDetalleEntregable") num
				FROM "Dependencia" dep
				INNER JOIN "Actividad" act ON act."iIdDependencia" = dep."iIdDependencia"
				INNER JOIN "DetalleActividad" dat ON dat."iIdActividad" = act."iIdActividad" AND dat."iActivo" = 1 AND dat."iAnio" = '.$anio.'
				INNER JOIN "DetalleEntregable" det ON det."iIdDetalleActividad" = dat."iIdDetalleActividad" AND det."iActivo" = 1
				WHERE dep."iIdDependencia" = '.$idDep.'
				GROUP BY dep."iIdDependencia"';
		return ($this->sigo->query($sql)->num_rows() > 0) ? $this->sigo->query($sql)->row()->num:0;
	}

	function ejercido_by_dep($idDep,$anio)
	{
		$sql = 'SELECT COALESCE(SUM(av."nEjercido"),0) gasto
				FROM "Dependencia" dep
				INNER JOIN "Actividad" act ON act."iIdDependencia" = dep."iIdDependencia"
				INNER JOIN "DetalleActividad" dat ON dat."iIdActividad" = act."iIdActividad" AND dat."iActivo" = 1 AND dat."iAnio" = '.$anio.'
				INNER JOIN "DetalleEntregable" det ON det."iIdDetalleActividad" = dat."iIdDetalleActividad" AND det."iActivo" = 1
				INNER JOIN "Avance" av ON av."iIdDetalleEntregable" = det."iIdDetalleEntregable" AND av."iActivo" = 1 AND av."iAprobado" = 1
				WHERE dep."iIdDependencia" = '.$idDep.'
				GROUP BY dep."iIdDependencia"';
		return ($this->sigo->query($sql)->num_rows() > 0) ? $this->sigo->query($sql)->row()->gasto:0;
	}

	#######################################
	/* Consultas para el dash por Sectores */
	#######################################
	function sectores()
	{
		$sql = 'SELECT * FROM "PED2019Eje" WHERE "iIdEje" < 10';
		return $this->sigo->query($sql);
	}

	function info_dash_sector($where='')
	{
		$this->sigo->select('s."iIdEje", s."vEje", COUNT(DISTINCT(s."iIdDependencia")) pats, COUNT(s."iIdDetalleActividad") actividades, SUM(s."nAvance") avance, SUM(s.entregables) entregables, SUM(s.presupuesto) presupuesto, SUM(s.ejercido) ejercido, SUM(dat."nPresupuestoAutorizado") autorizado',FALSE);
		$this->sigo->from('info_dash_sector AS s');
		$this->sigo->join('DetalleActividad dat', 'dat.iIdDetalleActividad = s.iIdDetalleActividad','LEFT OUTER');
		if(!empty($where))$this->sigo->where($where);
		$this->sigo->group_by('s."iIdEje", s."vEje"');
		$this->sigo->order_by('s."iIdEje"');

		return $this->sigo->get();
	}

}
?>