<?php
class M_dash extends CI_Model {

	function __construct(){
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
       // $this->ssop = $this->load->database('ssop',TRUE);
	}

	public function dependencias($id){
		
		$datos = '';
		$datos = array();
		$this->db->select('Dependencia.iIdDependencia, Dependencia.vNombreCorto');
		$this->db->from('Dependencia');
		$this->db->join('DependenciaEje', 'Dependencia.iIdDependencia = DependenciaEje.iIdDependencia');
		$this->db->join('PED2019Eje', 'PED2019Eje.iIdEje = DependenciaEje.iIdEje');
		$this->db->where('PED2019Eje.iIdEje', $id);
		$query = $this->db->get();

     	foreach ($query->result() as $row) {
        	$datos[] = [
	           'iIdDependencia' => $row->iIdDependencia,
	           'vNombreCorto' => $row->vNombreCorto
	        ];
	    }
     	return $datos;
	}

	function avance_por_dependencia_mes($idDePendencia, $anio, $mes, $iIdActividad){
		$sql = 'SELECT a."nAvance", a."nBeneficiariosH", a."nBeneficiariosM", a."nDiscapacitadosH",a."nDiscapacitadosM",a."nLenguaH",a."nLenguaM",a."nTerceraEdadH",a."nTerceraEdadM",
			a."nAdolescenteH",a."nAdolescenteM", a."vObservaciones" FROM "Avance" a 
			INNER JOIN "DetalleEntregable" de on de."iIdDetalleEntregable" = a."iIdDetalleEntregable" 
			INNER JOIN "DetalleActividad" da on da."iIdDetalleActividad" =  de."iIdDetalleActividad" AND da."iActivo" = 1 AND da."iSuspendida" = 0 AND da."iAnio" = '.$anio.'
			INNER JOIN "Actividad" act on act."iIdActividad" = da."iIdActividad"
			where a."iActivo" = 1 AND EXTRACT(MONTH FROM a."dFecha") = '.$mes.'  AND act."iIdActividad" = '.$iIdActividad.' AND act."iIdDependencia" = '.$idDePendencia;
			return $this->db->query($sql)->result();
	}

	public function ejes(){
		$datos = '';
		$datos = array();
		$this->db->select('iIdEje, vEje, vIcono');
		$this->db->from('PED2019Eje');
		$this->db->where('iIdEje >= 1 and iIdEje <= 9');
	
		$query = $this->db->get();

     	foreach ($query->result() as $row)
     	{
	        $datos[] = [
	           'iIdEje'	=> $row->iIdEje,
			   'vEje'   => $row->vEje,
			   'vIcono' => $row->vIcono
	        ];
	    }

     	return $datos;
	}

	public function temas($id){
		$datos = '';
		$datos = array();
		$this->db->select('iIdTema, vTema, PED2019Tema.vIcono');
		$this->db->from('PED2019Tema');
		$this->db->join('PED2019Eje', 'PED2019Tema.iIdEje = PED2019Eje.iIdEje');
		$this->db->where('PED2019Eje.iIdEje', $id);
	
		$query = $this->db->get();

     foreach ($query->result() as $row) {
        $datos[] = [
           'iIdTema'                       => $row->iIdTema,
		   'vTema'                   => $row->vTema,
		   'vIcono' => $row->vIcono
         ];
     }
     return $datos;
	}

	public function totaltemas($id){
		
		$this->db->select('COALESCE(round("sum"("nAvance") / "count"("nAvance"),2) ,0) as prom');
		$this->db->from('"DetalleActividad"');
		$this->db->join('"Actividad"', '"Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"');
		$this->db->join('"ActividadLineaAccion"', '"ActividadLineaAccion"."iIdActividad" =  "Actividad"."iIdActividad"');
		$this->db->join('"PED2019LineaAccion"', '"PED2019LineaAccion"."iIdLineaAccion" = "ActividadLineaAccion"."iIdLineaAccion"');
		$this->db->join('"PED2019Estrategia"', '"PED2019Estrategia"."iIdEstrategia" = "PED2019LineaAccion"."iIdEstrategia"');
		$this->db->join('"PED2019Objetivo"', '"PED2019Objetivo"."iIdObjetivo" = "PED2019Estrategia"."iIdObjetivo"');
		$this->db->join('"PED2019Tema"', '"PED2019Tema"."iIdTema" = "PED2019Objetivo"."iIdTema"');
		$this->db->where('"PED2019Tema"."iIdTema"',$id);
	
		return $this->db->get()->row()->prom;

    /* foreach ($query->result() as $row) {
		$datos = $row->prom;
     }
     return $datos;*/
	}

	public function actividades($id,$anio){
		$datos = '';
		$datos = array();
		$this->db->select('Actividad.iIdActividad , Actividad.vActividad, DetalleActividad.nAvance');
		$this->db->from('Actividad');
		$this->db->join('DetalleActividad', 'DetalleActividad.iIdActividad = Actividad.iIdActividad');
		$this->db->join('Dependencia', 'Dependencia.iIdDependencia = Actividad.iIdDependencia');
		$this->db->join('DependenciaEje', 'Dependencia.iIdDependencia = DependenciaEje.iIdDependencia');
		$this->db->join('PED2019Eje', 'PED2019Eje.iIdEje = DependenciaEje.iIdEje');
		$this->db->where('PED2019Eje.iIdEje = '.$id.' and DetalleActividad.iAnio = '.$anio.' and DetalleActividad.iActivo = 1 AND DetalleActividad.iSuspendida = 0');
		$this->db->order_by('"Actividad"."iIdActividad"', 'ASC');
		$query = $this->db->get();

		foreach ($query->result() as $row) {
			$datos[] = [
				'iIdActividad'                       => $row->iIdActividad,
				'vActividad'                   => $row->vActividad,
				'nAvance' => $row->nAvance
			];
		}
		return $datos;
	}

	public function actividades2($id,$anio){
		$datos = '';
		$datos = array();
		$this->db->select('Actividad.iIdActividad , Actividad.vActividad, DetalleActividad.nAvance');
		$this->db->from('Actividad');
		$this->db->join('DetalleActividad', 'DetalleActividad.iIdActividad = Actividad.iIdActividad');
		$this->db->join('Dependencia', 'Dependencia.iIdDependencia = Actividad.iIdDependencia');
		$this->db->where('Dependencia.iIdDependencia = '.$id.' and DetalleActividad.iAnio = '.$anio.' and DetalleActividad.iActivo = 1  AND DetalleActividad.iSuspendida = 0');
		$this->db->order_by('"Actividad"."iIdActividad"', 'ASC');
		$query = $this->db->get();

		foreach ($query->result() as $row) {
			$datos[] = [
				'iIdActividad'                       => $row->iIdActividad,
				'vActividad'                   => $row->vActividad,
				'nAvance' => $row->nAvance
			];
		}
		return $datos;
	}

	public function avacetotaleje($id, $an){
		$this->db->select('COALESCE(round("sum"("nAvance") / "count"("nAvance"),2) ,0) as prom');
		$this->db->from('"DetalleActividad"');
		$this->db->join('"Actividad"', '"Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"');
		$this->db->join('"ActividadLineaAccion"', '"ActividadLineaAccion"."iIdActividad" =  "Actividad"."iIdActividad"');
		$this->db->join('"PED2019LineaAccion"', '"PED2019LineaAccion"."iIdLineaAccion" = "ActividadLineaAccion"."iIdLineaAccion"');
		$this->db->join('"PED2019Estrategia"', '"PED2019Estrategia"."iIdEstrategia" = "PED2019LineaAccion"."iIdEstrategia"');
		$this->db->join('"PED2019Objetivo"', '"PED2019Objetivo"."iIdObjetivo" = "PED2019Estrategia"."iIdObjetivo"');
		$this->db->join('"PED2019Tema"', '"PED2019Tema"."iIdTema" = "PED2019Objetivo"."iIdTema"');
		$this->db->join('"PED2019Eje"', '"PED2019Eje"."iIdEje" = "PED2019Tema"."iIdEje"');
		$this->db->where('DetalleActividad.iActivo',1);
		$this->db->where('DetalleActividad.iSuspendida',0);
		$this->db->where('"PED2019Eje"."iIdEje" = '.$id. ' and "iAnio" ='.$an.'');
	
		return $this->db->get()->row()->prom;

	}

	public function avacetotalejes($an){
		$this->db->select('COALESCE(round("sum"("nAvance") / "count"("nAvance"),2) ,0) as prom');
		$this->db->from('"DetalleActividad"');
		$this->db->join('"Actividad"', '"Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"');
		$this->db->join('"ActividadLineaAccion"', '"ActividadLineaAccion"."iIdActividad" =  "Actividad"."iIdActividad"');
		$this->db->join('"PED2019LineaAccion"', '"PED2019LineaAccion"."iIdLineaAccion" = "ActividadLineaAccion"."iIdLineaAccion"');
		$this->db->join('"PED2019Estrategia"', '"PED2019Estrategia"."iIdEstrategia" = "PED2019LineaAccion"."iIdEstrategia"');
		$this->db->join('"PED2019Objetivo"', '"PED2019Objetivo"."iIdObjetivo" = "PED2019Estrategia"."iIdObjetivo"');
		$this->db->join('"PED2019Tema"', '"PED2019Tema"."iIdTema" = "PED2019Objetivo"."iIdTema"');
		$this->db->join('"PED2019Eje"', '"PED2019Eje"."iIdEje" = "PED2019Tema"."iIdEje"');
		$this->db->where('"iAnio"',$an);
		$this->db->where('DetalleActividad.iActivo',1);
		$this->db->where('DetalleActividad.iSuspendida',0);
		return $this->db->get()->row()->prom;
	}

	public function avance_anio_eje($anio,$eje = 0){
		if($eje > 0 )
		{
			$sql = 'SELECT tt."iIdEje", count(tt."iIdDetalleActividad") AS numact, sum(tt.navanceactividad) AS avance_r
				FROM (	SELECT DISTINCT t."iIdEje", t."iIdDetalleActividad", t.navanceactividad
						FROM actividades_eje2 t
						WHERE t."iAnio" = '.$anio.' AND t."iIdEje" = '.$eje.') as tt
				GROUP BY tt."iIdEje"';
		}
		else
		{
			$sql = 'SELECT tt."iIdEje", count(tt."iIdDetalleActividad") AS numact, sum(tt.navanceactividad) AS avance_r
				FROM (	SELECT DISTINCT t."iIdEje", t."iIdDetalleActividad", t.navanceactividad
						FROM actividades_eje2 t
						WHERE t."iAnio" = '.$anio.') as tt
				GROUP BY tt."iIdEje"';
		}
		

		return $this->db->query($sql);
	}

	public function beneficiarios_anio_eje($anio,$eje=0) {
		if($eje > 0) {
			$sql = 'SELECT tt."iIdEje", sum(tt."nBeneficiariosH" + tt."nBeneficiariosM") as beneficiarios
					FROM ( 	SELECT DISTINCT t."iIdEje", t."iIdDetalleActividad", t."iIdFinanciamiento", t.monto, t."nBeneficiariosH", t."nBeneficiariosM"
							FROM actividades_eje2 t
							WHERE t."iAnio" = '.$anio.' AND t."iIdEje" = '.$eje.' ) as tt
					GROUP BY tt."iIdEje"';
		} else {
			$sql = 'SELECT tt."iIdEje", sum(tt."nBeneficiariosH" + tt."nBeneficiariosM") as beneficiarios
				FROM ( 	SELECT DISTINCT t."iIdEje", t."iIdDetalleActividad", t."iIdFinanciamiento", t.monto, t."nBeneficiariosH", t."nBeneficiariosM"
						FROM actividades_eje2 t
						WHERE t."iAnio" = '.$anio.') as tt
				GROUP BY tt."iIdEje"';
		}

		return $this->db->query($sql);
	}

	public function ent_por_anio($anio,$eje=0) {
		if($eje > 0) {
			$sql = 'SELECT tt."iIdEje", count(tt."iIdDetalleEntregable") AS nument
					FROM (	SELECT DISTINCT t."iIdEje", t."iIdDetalleEntregable"
							FROM actividades_eje2 t
							WHERE t."iAnio" = '.$anio.' AND t."iIdEje" = '.$eje.') as tt
					GROUP BY tt."iIdEje"';
		}	else {
			$sql = 'SELECT tt."iIdEje", count(tt."iIdDetalleEntregable") AS nument
					FROM (	SELECT DISTINCT t."iIdEje", t."iIdDetalleEntregable"
							FROM actividades_eje2 t
							WHERE t."iAnio" = '.$anio.') as tt
					GROUP BY tt."iIdEje"';
		}

		return $this->db->query($sql);
	}

	public function pat_anio($ejeid, $anio) {
		$sql = 'select DISTINCT de."iIdDependencia", de."iIdEje"
		from "DetalleActividad" da
		inner join "Actividad" a on da."iIdActividad" = a."iIdActividad" and a."iActivo" = 1
		inner join "DependenciaEje" de on de."iIdDependencia" = a."iIdDependencia"
		where da."iActivo" = 1 AND da."iSuspendida" = 0
		and da."iAnio" = '.$anio.'
		and de."iIdEje" = '.$ejeid;
		
		return $this->db->query($sql);

	}


	public function presupuesto_anio_eje($anio,$eje=0) {
		if($eje > 0)
		{
			$sql = 'SELECT tt."iIdEje", sum(tt.monto)  AS presupuesto
				FROM ( 	SELECT DISTINCT t."iIdEje", t."iIdDetalleActividad", t."iIdFinanciamiento", t.monto
						FROM actividades_eje2 t
						WHERE t."iAnio" = '.$anio.' AND t."iIdEje" = '.$eje.') as tt
				GROUP BY tt."iIdEje"';
		}
		else
		{		
			$sql = 'SELECT tt."iIdEje", sum(tt.monto)  AS presupuesto
					FROM ( 	SELECT DISTINCT t."iIdEje", t."iIdDetalleActividad", t."iIdFinanciamiento", t.monto
							FROM actividades_eje2 t
							WHERE t."iAnio" = '.$anio.') as tt
					GROUP BY tt."iIdEje"';
		}

		return $this->db->query($sql);
	}

	public function ejercido_anio_eje($anio,$eje=0) {
		if($eje > 0)
		{
			$sql = 'SELECT tt."iIdEje", sum(tt."nEjercido") AS ejercido
					FROM ( 	SELECT DISTINCT t."iIdEje", t."iIdDetalleActividad", t."iIdDetalleEntregable", t."iIdAvance", t."nEjercido"
							FROM actividades_eje2 t
							WHERE t."iAnio" = '.$anio.' AND t."iIdEje" = '.$eje.' AND t."iAprobado" = 1) as tt
					GROUP BY tt."iIdEje"';
		}
		else
		{
			$sql = 'SELECT tt."iIdEje", sum(tt."nEjercido") AS ejercido
					FROM ( 	SELECT DISTINCT t."iIdEje", t."iIdDetalleActividad", t."iIdDetalleEntregable", t."iIdAvance", t."nEjercido"
							FROM actividades_eje2 t
							WHERE t."iAnio" = '.$anio.' AND t."iAprobado" = 1) as tt
					GROUP BY tt."iIdEje"';
		}

		return $this->db->query($sql);
	}

	public function totalRegistros($anio,$eje=0) {
		if($eje > 0)
		{
			$sql = 'SELECT tt."iIdEje", count(tt."nEjercido")
					FROM ( 	SELECT DISTINCT t."iIdEje", t."iIdDetalleActividad", t."iIdDetalleEntregable", t."iIdAvance", t."nEjercido"
							FROM actividades_eje2 t
							WHERE t."iAnio" = '.$anio.' AND t."iIdEje" = '.$eje.' AND t."iAprobado" = 1) as tt
					GROUP BY tt."iIdEje"';
		}
		else
		{
			$sql = 'SELECT tt."iIdEje", count(tt."nEjercido")
					FROM ( 	SELECT DISTINCT t."iIdEje", t."iIdDetalleActividad", t."iIdDetalleEntregable", t."iIdAvance", t."nEjercido"
							FROM actividades_eje2 t
							WHERE t."iAnio" = '.$anio.' AND t."iAprobado" = 1) as tt
					GROUP BY tt."iIdEje"';
		}

		return $this->db->query($sql);
	}

	public function ejes_icono($eje=0) {
		$this->db->select('iIdEje, vEje, vIcono, vColorDesca');
		$this->db->from('PED2019Eje');
		$this->db->where('iIdEje !=',10);
		if($eje > 0) $this->db->where('iIdEje',$eje);
		$this->db->order_by('iIdEje');
		//$this->db->limit(3);
		return $this->db->get();
	}

	public function ejercido_municipio($anio,$idDetAct=0,$idDetEnt=0) {
		$anio = $this->db->escape($anio);
		$sql = 'SELECT m."iIdMunicipio", m."vMunicipio", SUM(av."nAvance") avance, SUM(av."nEjercido") ejercido, m."iTotalPoblacion"
				FROM "DetalleEntregable" de
				INNER JOIN "Entregable" en ON en."iIdEntregable" = de."iIdEntregable" AND en."iMunicipalizacion" = 1 
				INNER JOIN "DetalleActividad" da ON da."iIdDetalleActividad" = de."iIdDetalleActividad" AND da."iActivo" = 1 AND da."iSuspendida" = 0 AND da."iAnio" = '.$anio.'
				INNER JOIN "Avance" av ON av."iIdDetalleEntregable" = de."iIdDetalleEntregable" AND av."iActivo" = 1 AND av."iAprobado" = 1
				INNER JOIN "Municipio" m ON m."iIdMunicipio" = av."iMunicipio"
				WHERE de."iActivo" = 1';
		if($idDetAct > 0) $sql.= ' AND da."iIdDetalleActividad" = '.$idDetAct;
		if($idDetEnt > 0) $sql.= ' AND de."iIdDetalleEntregable" = '.$idDetEnt;
		$sql.= ' GROUP BY m."iIdMunicipio", m."vMunicipio", m."iTotalPoblacion"
				ORDER BY SUM(av."nEjercido") DESC';
		
		$query = $this->db->query($sql);
		$_SESSION['sql'] = $this->db->last_query();

		return $query;
	}

	public function compromisos_estatus() {
		$sql = 'SELECT es."iIdEstatus", es."vColor", es."vEstatus", COUNT(c."iIdCompromiso") numcomp, SUM(c."dPorcentajeAvance" ) avance
				FROM "Compromiso" c
				INNER JOIN "PED2019Tema" t ON t."iIdTema" = c."iIdTema"
				INNER JOIN "PED2019Eje" e ON e."iIdEje" = t."iIdEje"
				INNER JOIN "Estatus" es ON es."iIdEstatus" = c."iEstatus"
				WHERE c."iActivo" = 1 
				GROUP BY es."iIdEstatus", es."vColor", es."vEstatus"';
		return $this->db->query($sql)->result();
	}

	public function compromisos_eje($eje=0) {
		$sql = 'SELECT e."iIdEje", e."vEje", e."vColorDesca", e."vIcono", COUNT(c."iIdCompromiso") numcomp, SUM(c."dPorcentajeAvance" ) avance, 0 AS estatus
				FROM "Compromiso" c
				INNER JOIN "PED2019Tema" t ON t."iIdTema" = c."iIdTema"
				INNER JOIN "PED2019Eje" e ON e."iIdEje" = t."iIdEje"
				WHERE c."iActivo" = 1 ';

		if($eje > 0) $sql .= ' AND e."iIdEje" = '.$eje;
		$sql.=	' GROUP BY e."iIdEje", e."vEje", e."vColorDesca", e."vIcono"
				ORDER BY e."iIdEje"';

		return $this->db->query($sql)->result();
	}

	public function estatus_compromisos_eje($iIdEje) {
		$this->db->select('c.iEstatus, est.vEstatus, est."vColor", COUNT(c."iIdCompromiso") numcomp, SUM(c."dPorcentajeAvance" ) avance');
		$this->db->from('Compromiso c');
		$this->db->join('Estatus est','est.iIdEstatus = c.iEstatus','INNER');
		$this->db->join('PED2019Tema t','t.iIdTema = c.iIdTema','INNER');
		$this->db->join('PED2019Eje e','e.iIdEje = t.iIdEje','INNER');
		$this->db->where('c.iActivo = 1');
		$this->db->where('e.iIdEje',$iIdEje);
		$this->db->group_by('c.iEstatus, est.vEstatus, est.vColor');
		$this->db->order_by('c.iEstatus');

		return $this->db->get()->result();
	}


	public function busqueda($keyword,$eje=0) {
		$this->db->select('a.*,d.vDependencia');
		$this->db->from('Actividad a');
		$this->db->join('DetalleActividad da','da.iIdActividad = a.iIdActividad AND da.iActivo = 1 AND da.iSuspendida = 0','INNER');
		$this->db->join('Dependencia d','d.iIdDependencia = a.iIdDependencia','INNER');
		$this->db->where("(lower(translate(a.\"vActividad\",'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) ilike lower(translate( '%$keyword%','áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')))");
		$this->db->group_by('a.iIdActividad, d.iIdDependencia');
		if($eje > 0) 
		{
			$this->db->join('DependenciaEje de','de.iIdDependencia = d.iIdDependencia AND de.iIdEje = '.$eje,'INNER');			
		}

		$query = $this->db->get();

		if($query!=false) return $query->result();
		else return false;		
	}

	public function busqueda_eje($eje, $anio) {
		$this->db->select('act.*, dep."vDependencia", dact."iIdDetalleActividad"');
		$this->db->from('"Actividad" act');
		$this->db->join('"DetalleActividad" dact', 'dact."iIdActividad" = act."iIdActividad" and dact."iActivo" = 1 AND dact."iSuspendida" = 0','INNER');
		$this->db->join('"Dependencia" dep', 'dep."iIdDependencia" = act."iIdDependencia"','INNER');
		$this->db->join('"ActividadLineaAccion" actl', 'actl."iIdActividad" = act."iIdActividad"','INNER');
		$this->db->join('"PED2019LineaAccion" la', 'la."iIdLineaAccion" = actl."iIdLineaAccion"','INNER');
		$this->db->join('"PED2019Estrategia" est', 'est."iIdEstrategia" = la."iIdEstrategia"','INNER');
		$this->db->join('"PED2019Objetivo" obj', 'obj."iIdObjetivo" = est."iIdObjetivo"','INNER');
		$this->db->join('"PED2019Tema" tem', 'tem."iIdTema" = obj."iIdTema"','INNER');
		$this->db->where('tem."iIdEje"', $eje);
		$this->db->where('dact."iAnio"', $anio);
		$this->db->group_by('act."iIdActividad", dep."iIdDependencia", dact."iIdDetalleActividad"');
		$this->db->order_by('act."iImportante');

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;		
	}

	public function busqueda_eje_totales($anio, $iIdActividad) {
		$this->db->select('act."iIdActividad", act."vActividad", sum(av."nEjercido") as ej_total, sum(av."nAvance") as av_total, sum(av."nBeneficiariosH" + av."nBeneficiariosM") as ben_total');
		$this->db->from('"Actividad" act');
		$this->db->join('"DetalleActividad" dact', 'dact."iIdActividad" = act."iIdActividad" and dact."iActivo" = 1 AND dact."iSuspendida" = 0','INNER');
		$this->db->join('"DetalleEntregable" dent', 'dent."iIdDetalleActividad" = dact."iIdDetalleActividad" and dent."iActivo" = 1','INNER');
		$this->db->join('"Avance" av', 'av."iIdDetalleEntregable" = dent."iIdDetalleEntregable"','INNER');
		$this->db->where('act."iIdActividad"', $iIdActividad);
		$this->db->where('dact."iAnio"', $anio);
		$this->db->where('av."iActivo"', 1);
		$this->db->where('av."iAprobado"', 1);
		$this->db->group_by('act."iIdActividad"');

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function datos_actividad($id,$anio=0) {
		$this->db->select('a.*, d.vDependencia');
		$this->db->from('Actividad a');
		$this->db->join('Dependencia d','d.iIdDependencia = a.iIdDependencia','INNER');
		if($anio > 0)
		{
			$this->db->select('dat.nAvance');
			$this->db->join('DetalleActividad dat','dat.iIdActividad = a.iIdActividad AND dat.iAnio = '.$anio,'INNER');
		}
		$this->db->where('a.iIdActividad',$id);

		return $this->db->get()->row();
	}

	public function anios_financiamientos($id) {
		$id = $this->db->escape($id);
		$sql = 'SELECT a."iAnio"
				FROM "DetalleActividad" a
				INNER JOIN "DetalleActividadFinanciamiento" df ON df."iIdDetalleActividad" = a."iIdDetalleActividad"
				WHERE a."iIdActividad" = '.$id.' AND a."iActivo" = 1
				GROUP BY a."iAnio"
				ORDER BY a."iAnio" DESC';

		return $this->db->query($sql)->result();
	}

	public function datos_financiamientos($id,$anio) {
		$id = $this->db->escape($id);
		$anio = $this->db->escape($anio);
		$sql = 'SELECT a."iAnio",  df.*, f."vFinanciamiento"
				FROM "DetalleActividad" a
				INNER JOIN "DetalleActividadFinanciamiento" df ON df."iIdDetalleActividad" = a."iIdDetalleActividad"
				INNER JOIN "Financiamiento" f ON f."iIdFinanciamiento" = df."iIdFinanciamiento"
				WHERE a."iIdActividad" = '.$id.' AND a."iActivo" = 1 AND a."iAnio" = '.$anio.'
				ORDER BY a."iAnio" DESC';

		return $this->db->query($sql)->result();
	}

	public function anios_entregables($id) {
		$id = $this->db->escape($id);

		$sql = 'SELECT a."iAnio", a."nAvance"
				FROM "DetalleActividad" a
				INNER JOIN  "DetalleEntregable" de ON de."iIdDetalleActividad" = a."iIdDetalleActividad" AND de."iActivo" = 1
				WHERE a."iIdActividad" = '.$id.' AND a."iActivo" = 1
				GROUP BY a."iAnio", a."nAvance"
				ORDER BY a."iAnio" DESC';
		return $this->db->query($sql)->result();
	}

	public function entregables_por_anio($id,$anio) {
		$id = $this->db->escape($id);
		$anio = $this->db->escape($anio);

		$sql = 'SELECT de."iIdDetalleEntregable", en."iMismosBeneficiarios", en."vEntregable", de."nMeta", u."vUnidadMedida", SUM(av."nAvance") avance, sum(av."nEjercido") ejercido, sum(av."nBeneficiariosH") benh, sum(av."nBeneficiariosM") benm, COALESCE(MAX(av."dFecha"),\'1900-01-01\') maxfecha
				FROM "DetalleActividad" a
				INNER JOIN "DetalleEntregable" de ON de."iIdDetalleActividad" = a."iIdDetalleActividad" AND de."iActivo" = 1
				INNER JOIN "Entregable" en ON en."iIdEntregable" = de."iIdEntregable"
				INNER JOIN "UnidadMedida" u ON u."iIdUnidadMedida" = en."iIdUnidadMedida"
				LEFT OUTER JOIN "Avance" av ON av."iIdDetalleEntregable" = de."iIdDetalleEntregable" AND av."iActivo" = 1 AND av."iAprobado" = 1
				WHERE a."iIdActividad" = '.$id.' AND a."iActivo" = 1 AND a."iAnio" = '.$anio.'
				group by de."iIdDetalleEntregable", u."iIdUnidadMedida", en."iIdEntregable"';

		return $this->db->query($sql)->result();
	}

	public function benef_mes_entregable($iIdDetalleEntregable,$fecha) {
		$sql = 'SELECT COALESCE(SUM("nBeneficiariosH"),0) benh, COALESCE(sum("nBeneficiariosM"),0) benm
				FROM "Avance" 
				WHERE "iActivo" = 1 AND "iAprobado" = 1 AND "iIdDetalleEntregable" = '.$iIdDetalleEntregable.' AND "dFecha" = \''.$fecha.'\';';
		return $this->db->query($sql)->row();
	}

	public function presupuesto_by_anio($iIdActividad) {
		$sql = 'SELECT da."iAnio", COALESCE(SUM(df.monto),0) presupuesto
					FROM "DetalleActividad" da
					INNER JOIN "DetalleActividadFinanciamiento" df ON df."iIdDetalleActividad" = da."iIdDetalleActividad"
					WHERE da."iIdActividad" = '.$iIdActividad.' AND da."iActivo" = 1
					GROUP BY da."iAnio"
					ORDER BY da."iAnio"';
		return $this->db->query($sql)->result();
	}

	public function presupuesto_mod_by_anio($iIdActividad) {
		$sql = 'SELECT da."iAnio", SUM(da."nPresupuestoAutorizado") presupuesto_autorizado, SUM(da."nPresupuestoModificado") presupuesto_modificado
		FROM "DetalleActividad" da
		WHERE da."iIdActividad" = '.$iIdActividad.' AND da."iActivo" = 1
		GROUP BY da."iAnio"
		ORDER BY da."iAnio"';
		return $this->db->query($sql)->result();
	}

	public function ejercido_by_anio($iIdActividad) {
		$sql = 'SELECT da."iAnio", SUM(av."nEjercido") ejercido
				FROM "DetalleActividad" da
				INNER JOIN "DetalleEntregable" de ON de."iIdDetalleActividad" = da."iIdDetalleActividad" AND de."iActivo" = 1
				INNER JOIN "Avance" av ON av."iIdDetalleEntregable" = de."iIdDetalleEntregable" AND av."iActivo" = 1 AND av."iAprobado" = 1
				WHERE da."iActivo"= 1 AND da."iIdActividad" = '.$iIdActividad.'
				GROUP BY da."iAnio"
				ORDER BY da."iAnio"';
		return $this->db->query($sql)->result();
	}
     
	public function av_by_anio($id)  {
		$this->db->select('dact.iAnio, dact.nAvance');
		$this->db->from('"DetalleActividad" dact');
		$this->db->where('dact."iIdActividad"', $id);
		$this->db->where('dact."iActivo"', 1);
		$this->db->order_by('dact."iAnio"');

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function avent_by_anio($id, $anio = 0) {
		if($anio > 0)
		{

			$this->db->select('da."iIdActividad", da."iIdDetalleActividad", da."iAnio", da."nAvance", de."iIdDetalleEntregable", de."nMeta", e."iIdEntregable", e."vEntregable"');
			$this->db->order_by('da."iAnio" ASC, e.iIdEntregable ASC');
			$this->db->where('da.iAnio', $anio);
		}
		else 
		{
			$this->db->select('da."iAnio"');
			$this->db->group_by('da.iAnio');
			$this->db->order_by('da."iAnio" ASC');
		}

		$this->db->from('"DetalleActividad" da');
		$this->db->join('"DetalleEntregable" de', 'da."iIdDetalleActividad" = de."iIdDetalleActividad" and de."iActivo" = 1', 'INNER');
		$this->db->join('"Entregable" e', 'de."iIdEntregable" = e."iIdEntregable" and e."iActivo" = 1', 'INNER');
		$this->db->where('da."iIdActividad"', $id);
		$this->db->where('da."iActivo"', 1);

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function ben_by_anio($id) {
		$this->db->select('dact."iAnio", sum(av."nAvance") as avance, sum(dent."nMeta") as meta, sum(av."nBeneficiariosH" + av."nBeneficiariosM") as beneficiarios');
		$this->db->from('"DetalleActividad" dact');
		$this->db->join('"DetalleEntregable" dent', 'dent."iIdDetalleActividad" = dact."iIdDetalleActividad" and dent."iActivo" = 1', 'INNER');
		$this->db->join('"Avance" av', 'av."iIdDetalleEntregable" = dent."iIdDetalleEntregable" and av."iActivo" = 1 and av."iAprobado" = 1', 'INNER');
		$this->db->where('dact."iIdActividad"', $id);
		$this->db->where('dact."iActivo"', 1);
		$this->db->group_by('dact."iAnio"');
		$this->db->order_by('dact."iAnio"');

		$query = $this->db->get();
		if($query!=false) return $query->result();
		else return false;
	}

	public function num_actividades_avance($iIdEje,$anio,$trim=1) {
		$iIdEje = $this->db->escape($iIdEje);
		$anio = intval($anio);
		//var_dump($anio);
		$trim = $this->db->escape($trim);
		$meses = "'$anio-01-01','$anio-02-01','$anio-03-01'";
		if($trim == 2) $meses = "'$anio-04-01','$anio-05-01','$anio-06-01'";
		if($trim == 3) $meses = "'$anio-07-01','$anio-08-01','$anio-09-01'";
		if($trim == 4) $meses = "'$anio-10-01','$anio-11-01','$anio-12-01'";
		$sql = 'SELECT t."iIdEje", COUNT(t."iIdDetalleActividad"), SUM(t.point )
				FROM (SELECT t."iIdEje", t."iIdDetalleActividad", CASE WHEN COUNT(t."iIdDetalleEntregable") = SUM(t.avances) THEN 1 ELSE 0 END AS point
					FROM (SELECT DISTINCT p."iIdEje", da."iIdDetalleActividad", de."iIdDetalleEntregable", CASE WHEN count(av."iIdAvance") > 0 THEN 1 ELSE 0 END avances
						FROM "Actividad" ac
						INNER JOIN "DetalleActividad" da ON da."iIdActividad" = ac."iIdActividad" AND da."iActivo" = 1
						INNER JOIN "ActividadLineaAccion" al ON al."iIdActividad" = ac."iIdActividad"
						INNER JOIN "PED2019" p ON p."iIdLineaAccion" = al."iIdLineaAccion"
						INNER JOIN "DetalleEntregable" de ON de."iIdDetalleActividad" = da."iIdDetalleActividad" AND de."iActivo" = 1
						LEFT OUTER JOIN "Avance" av ON av."iIdDetalleEntregable" = de."iIdDetalleEntregable" AND av."iActivo" = 1 AND av."iAprobado" = 1 AND  av."dFecha" IN ('.$meses.')
						WHERE da."iAnio" = '.$anio.' AND da."iSuspendida" = 0 AND p."iIdEje" = '.$iIdEje.'
						GROUP BY p."iIdEje", da."iIdDetalleActividad", de."iIdDetalleEntregable") AS t
					GROUP BY t."iIdEje", t."iIdDetalleActividad"  ) as t
			GROUP BY t."iIdEje"';
		return $this->db->query($sql);
	}


	public function num_dependencias_eje($iIdEje,$anio) {
		$iIdEje = $this->db->escape($iIdEje);
		$anio = intval($anio);
		$sql = 'SELECT COUNT(DISTINCT ac."iIdDependencia") numdep
				FROM "Actividad" ac
				INNER JOIN "DetalleActividad" da ON da."iIdActividad" = ac."iIdActividad" AND da."iActivo" = 1
				INNER JOIN "ActividadLineaAccion" al ON al."iIdActividad" = ac."iIdActividad"
				INNER JOIN "PED2019" p ON p."iIdLineaAccion" = al."iIdLineaAccion"
				INNER JOIN "DetalleEntregable" de ON de."iIdDetalleActividad" = da."iIdDetalleActividad" AND de."iActivo" = 1
				WHERE da."iAnio" = '.$anio.' AND p."iIdEje" = '.$iIdEje;
		return $this->db->query($sql)->row()->numdep;
	}

	public function fecha_ult_avance_eje($iIdEje,$anio) {
		$iIdEje = $this->db->escape($iIdEje);
		$anio = intval($anio);
		$sql = 'SELECT MAX(av."dFecha") fecha
				FROM "Actividad" ac
				INNER JOIN "DetalleActividad" da ON da."iIdActividad" = ac."iIdActividad" AND da."iActivo" = 1
				INNER JOIN "ActividadLineaAccion" al ON al."iIdActividad" = ac."iIdActividad"
				INNER JOIN "PED2019" p ON p."iIdLineaAccion" = al."iIdLineaAccion"
				INNER JOIN "DetalleEntregable" de ON de."iIdDetalleActividad" = da."iIdDetalleActividad" AND de."iActivo" = 1
				INNER JOIN "Avance" av ON av."iIdDetalleEntregable" = de."iIdDetalleEntregable" AND av."iAprobado" = 1
				WHERE da."iAnio" = '.$anio.' AND p."iIdEje" = '.$iIdEje;
		$query = $this->db->query($sql);
		$resp = ($query->num_rows() > 0) ? $query->row()->fecha:'N/D';
		return $resp;
	}

	function nombre_eje($id) {
		$this->db->select('vEje, vColorDesca, vIcono');
		$this->db->from('PED2019Eje');
		$this->db->where('iIdEje',$id);

		return $this->db->get()->row();
	}

	function actividades_eje_trim($iIdEje,$anio,$trim,$tipo) {
		$iIdEje = $this->db->escape($iIdEje);
		$anio = intval($anio);
		$tipo = intval($tipo);
		$trim = $this->db->escape($trim);
		$meses = "'$anio-01-01','$anio-02-01','$anio-03-01'";
		if($trim == 2) $meses = "'$anio-04-01','$anio-05-01','$anio-06-01'";
		if($trim == 3) $meses = "'$anio-07-01','$anio-08-01','$anio-09-01'";
		if($trim == 4) $meses = "'$anio-10-01','$anio-11-01','$anio-12-01'";
		$sql = 'SELECT t."iIdDetalleActividad", de."nAvance", ac."vActividad", d."vDependencia", t."point", 0 AS entregables
				FROM (
				SELECT t."iIdEje", t."iIdDetalleActividad", CASE WHEN COUNT(t."iIdDetalleEntregable") = SUM(t.avances) THEN 1 ELSE 0 END AS point
				FROM (SELECT DISTINCT p."iIdEje", da."iIdDetalleActividad", da."iIdActividad", de."iIdDetalleEntregable", CASE WHEN count(av."iIdAvance") > 0 THEN 1 ELSE 0 END avances
					FROM "Actividad" ac
					INNER JOIN "DetalleActividad" da ON da."iIdActividad" = ac."iIdActividad" AND da."iActivo" = 1
					INNER JOIN "ActividadLineaAccion" al ON al."iIdActividad" = ac."iIdActividad"
					INNER JOIN "PED2019" p ON p."iIdLineaAccion" = al."iIdLineaAccion"
					INNER JOIN "DetalleEntregable" de ON de."iIdDetalleActividad" = da."iIdDetalleActividad" AND de."iActivo" = 1
					LEFT OUTER JOIN "Avance" av ON av."iIdDetalleEntregable" = de."iIdDetalleEntregable" AND av."iActivo" = 1 AND  av."dFecha" IN ('.$meses.')
					WHERE da."iAnio" = '.$anio.' AND p."iIdEje" = '.$iIdEje.'
					GROUP BY p."iIdEje", da."iIdDetalleActividad", de."iIdDetalleEntregable") AS t
				GROUP BY t."iIdEje", t."iIdDetalleActividad" ) AS t
				INNER JOIN "DetalleActividad" de ON de."iIdDetalleActividad" = t."iIdDetalleActividad"
				INNER JOIN "Actividad" ac ON ac."iIdActividad" = de."iIdActividad"
				INNER JOIN "Dependencia" d ON d."iIdDependencia" = ac."iIdDependencia"
				WHERE t."point" = '.$tipo;

		$query = $this->db->query($sql);

		return $query;
	}

	function lista_entregables($iIdDetalleActividad,$anio,$trim) {
		$iIdDetalleActividad = $this->db->escape($iIdDetalleActividad);
		/*$sql = 'SELECT de."iIdDetalleEntregable", de."nMeta", e."vEntregable", p."vPeriodicidad" 
				FROM "DetalleEntregable" de
				INNER JOIN "Entregable" e ON e."iIdEntregable" = de."iIdEntregable"
				INNER JOIN "Periodicidad" p ON p."iIdPeriodicidad" = e."iIdPeriodicidad"
				WHERE de."iActivo" = 1 AND de."iIdDetalleActividad" = '.$iIdDetalleActividad;*/
		$meses = "'$anio-01-01','$anio-02-01','$anio-03-01'";
		if($trim == 2) $meses = "'$anio-04-01','$anio-05-01','$anio-06-01'";
		if($trim == 3) $meses = "'$anio-07-01','$anio-08-01','$anio-09-01'";
		if($trim == 4) $meses = "'$anio-10-01','$anio-11-01','$anio-12-01'";
		
		$sql = 'SELECT de."iIdDetalleEntregable", de."nMeta", e."vEntregable", p."vPeriodicidad" , COALESCE(SUM(av."nAvance"),0) AS avance
				FROM "DetalleEntregable" de
				INNER JOIN "Entregable" e ON e."iIdEntregable" = de."iIdEntregable"
				INNER JOIN "Periodicidad" p ON p."iIdPeriodicidad" = e."iIdPeriodicidad"
				LEFT OUTER JOIN "Avance" av ON av."iIdDetalleEntregable" = de."iIdDetalleEntregable" AND av."iAprobado" = 1 AND av."dFecha" IN ('.$meses.')
				WHERE de."iActivo" = 1 AND de."iIdDetalleActividad" = '.$iIdDetalleActividad.'
				GROUP BY de."iIdDetalleEntregable", e."vEntregable", p."vPeriodicidad"';
		return $query = $this->db->query($sql)->result();			
	}

	function ejercido_mun_eje_anio_acciones($eje,$anio) {
		$sql = 'SELECT mun."vMunicipio", mun."iIdMunicipio", SUM(av."nEjercido") ejercido, mun."iTotalPoblacion"
				FROM "ActividadLineaAccion" al
				INNER JOIN "PED2019" ped ON ped."iIdLineaAccion" = al."iIdLineaAccion" AND ped."iIdEje" = '.$eje.'
				INNER JOIN "DetalleActividad" dat ON dat."iIdActividad" = al."iIdActividad" AND dat."iActivo" = 1 AND dat."iAnio" = '.$anio.'
				INNER JOIN "DetalleEntregable" det ON det."iIdDetalleActividad" = dat."iIdDetalleActividad" AND det."iActivo" = 1
				INNER JOIN "Avance" av ON av."iIdDetalleEntregable" = det."iIdDetalleEntregable" AND av."iActivo" = 1 AND av."iAprobado" = 1
				INNER JOIN "Municipio" mun ON mun."iIdMunicipio" = av."iMunicipio"
				GROUP BY mun."iIdMunicipio"
				ORDER BY mun."iIdMunicipio"';
		return $query = $this->db->query($sql);
	}


	function monto_municipio_eje_anio_acciones($municipio,$eje,$anio) {
		$sql = 'SELECT ent."iMismosBeneficiarios", SUM(av.avance) acciones, SUM(av.ejercido) ejercido, (SUM(av.beneficiariosh) + SUM(av.beneficiariosm)) beneficiarios, (SUM(ben.beneficiariosh) + SUM(ben.beneficiariosm)) bene
				FROM "ActividadLineaAccion" al
				INNER JOIN "PED2019" ped ON ped."iIdLineaAccion" = al."iIdLineaAccion" AND ped."iIdEje" = '.$eje.'
				INNER JOIN "DetalleActividad" dat ON dat."iIdActividad" = al."iIdActividad" AND dat."iActivo" = 1 AND dat."iAnio" = '.$anio.'
				INNER JOIN "DetalleEntregable" det ON det."iIdDetalleActividad" = dat."iIdDetalleActividad" AND det."iActivo" = 1
				INNER JOIN "Entregable" ent ON ent."iIdEntregable" = det."iIdEntregable"
				LEFT OUTER JOIN (SELECT "iIdDetalleEntregable", SUM("nAvance") avance, SUM("nEjercido")  ejercido, SUM("nBeneficiariosH") beneficiariosh, SUM("nBeneficiariosM") beneficiariosm, SUM("nDiscapacitadosH") discapacitadosh, SUM("nDiscapacitadosM") discapacitadosm, SUM("nLenguaH") lenguah, SUM("nLenguaM") lenguam, MAX("dFecha") fechamax
				                          FROM "Avance"
				                          WHERE "iActivo" = 1 AND "iAprobado" = 1 AND "iMunicipio" = '.$municipio.'
				                          GROUP BY "iIdDetalleEntregable") AS av ON av."iIdDetalleEntregable" = det."iIdDetalleEntregable"
				LEFT OUTER JOIN (SELECT "iIdDetalleEntregable", "dFecha" fechamax, SUM("nBeneficiariosH") beneficiariosh, SUM("nBeneficiariosM") beneficiariosm, SUM("nDiscapacitadosH") discapacitadosh, SUM("nDiscapacitadosM") discapacitadosm, SUM("nLenguaH") lenguah, SUM("nLenguaM") lenguam 
				        FROM "Avance" 
				        WHERE "iActivo" = 1 AND "iAprobado" = 1 AND "iMunicipio" = '.$municipio.'
				        GROUP BY "iIdDetalleEntregable", "dFecha" ) AS ben ON ben."iIdDetalleEntregable" = det."iIdDetalleEntregable" AND ben.fechamax = av.fechamax
				GROUP BY ent."iMismosBeneficiarios"';
		return $this->db->query($sql);
	}

/*
	function ejercido_mun_eje_anio_obras($eje,$anio) {*/
		/*$sql = 'SELECT mun."vMunicipio", t."iIdMunicipio", COUNT(t."iIdObra") acciones, SUM(t."nMontoPagado") ejercido, 0 AS "iTotalPoblacion"
				FROM (
				SELECT l."iIdMunicipio", o."iIdObra", o."nMontoPagado"
				FROM "Obra" o
				INNER JOIN "Alineacion" a ON a."iIdObra" = o."iIdObra" AND a."iIdEje" = '.$eje.'
				INNER JOIN "ObraLocalidad" ol ON ol."iIdObra" = o."iIdObra"
				INNER JOIN "Localidad" l ON l."iIdLocalidad" = ol."iIdLocalidad"
				WHERE o."iActivo" = 1 AND o."iAnioEjecucion" = '.$anio.'
				GROUP BY l."iIdMunicipio", o."iIdObra") AS t
				INNER JOIN "Municipio" mun ON mun."iIdMunicipio" = t."iIdMunicipio"
				GROUP BY mun."vMunicipio", t."iIdMunicipio"
				ORDER BY t."iIdMunicipio"';*/

/*



		$sql = 'SELECT mun."vMunicipio", t."iIdMunicipio", COUNT(t."iIdObra") acciones, SUM(t."nMontoPagado") ejercido, 0 AS "iTotalPoblacion"
				FROM (
				SELECT l."iIdMunicipio", o."iIdObra", o."nMontoPagado"
				FROM "Obra" o
				INNER JOIN "Alineacion" a ON a."iIdObra" = o."iIdObra" AND a."iIdEje" = '.$eje.'
				INNER join "Contrato" co on o."iIdObra" = co."iIdObra"
				INNER join "Accion" ac on co."iIdContrato" = ac."iIdContrato"
				INNER join "Localidad" l on ac."iIdLocalidad" = l."iIdLocalidad"
				WHERE o."iActivo" = 1 AND o."iAnioEjecucion" = '.$anio.'
				GROUP BY l."iIdMunicipio", o."iIdObra") AS t
				INNER JOIN "Municipio" mun ON mun."iIdMunicipio" = t."iIdMunicipio"
				GROUP BY mun."vMunicipio", t."iIdMunicipio"
				ORDER BY t."iIdMunicipio"';

		return $this->ssop->query($sql);
	}
*/
/*	function datos_mun_eje_anio_obras($municipio, $eje,$anio) {
		$sql = 'SELECT mun."vMunicipio", t."iIdMunicipio", COUNT(t."iIdObra") acciones, SUM(t."nMontoPagado") ejercido, 0 AS "iTotalPoblacion"
				FROM (
				SELECT l."iIdMunicipio", o."iIdObra", o."nMontoPagado"
				FROM "Obra" o
				INNER JOIN "Alineacion" a ON a."iIdObra" = o."iIdObra" AND a."iIdEje" = '.$eje.'
				INNER join "Contrato" co on o."iIdObra" = co."iIdObra"
				INNER join "Accion" ac on co."iIdContrato" = ac."iIdContrato"
				INNER join "Localidad" l on ac."iIdLocalidad" = l."iIdLocalidad"
				WHERE o."iActivo" = 1 AND o."iAnioEjecucion" = '.$anio.'
				GROUP BY l."iIdMunicipio", o."iIdObra") AS t
				INNER JOIN "Municipio" mun ON mun."iIdMunicipio" = t."iIdMunicipio" AND t."iIdMunicipio" = '.$municipio.'
				GROUP BY mun."vMunicipio", t."iIdMunicipio"
				ORDER BY t."iIdMunicipio"';
				
				
		return $this->ssop->query($sql);
	}
*/
	public function list_acts($anio,$eje=0,$municipio=0,$dep=0) {
		$inner = ($municipio > 0) ? 'INNER':'LEFT OUTER';
		$where = ($municipio > 0) ? 'AND "iMunicipio" = '.$municipio:'';
		$sql = 'SELECT dep."vDependencia", act."iIdActividad", act."vActividad", dat."iIdDetalleActividad", ent."vEntregable", ent."iMismosBeneficiarios", dat."nAvance",SUM(av.avance) avance, SUM(av.ejercido) ejercido, (SUM(av.beneficiariosh) + SUM(av.beneficiariosm)) beneficiarios, (SUM(ben.beneficiariosh) + SUM(ben.beneficiariosm)) bene
				FROM "ActividadLineaAccion" al
				INNER JOIN "Actividad" act ON act."iIdActividad" = al."iIdActividad"
				INNER JOIN "Dependencia" dep ON dep."iIdDependencia" = act."iIdDependencia"
				INNER JOIN "PED2019" ped ON ped."iIdLineaAccion" = al."iIdLineaAccion" AND ped."iIdEje" = '.$eje.'
				INNER JOIN "DetalleActividad" dat ON dat."iIdActividad" = al."iIdActividad" AND dat."iActivo" = 1 AND dat."iAnio" = '.$anio.'
				INNER JOIN "DetalleEntregable" det ON det."iIdDetalleActividad" = dat."iIdDetalleActividad" AND det."iActivo" = 1
				INNER JOIN "Entregable" ent ON ent."iIdEntregable" = det."iIdEntregable"
				'.$inner.' JOIN (SELECT "iIdDetalleEntregable", SUM("nAvance") avance, SUM("nEjercido")  ejercido, SUM("nBeneficiariosH") beneficiariosh, SUM("nBeneficiariosM") beneficiariosm, SUM("nDiscapacitadosH") discapacitadosh, SUM("nDiscapacitadosM") discapacitadosm, SUM("nLenguaH") lenguah, SUM("nLenguaM") lenguam, MAX("dFecha") fechamax
				                          FROM "Avance"
				                          WHERE "iActivo" = 1 AND "iAprobado" = 1 '.$where.'
				                          GROUP BY "iIdDetalleEntregable") AS av ON av."iIdDetalleEntregable" = det."iIdDetalleEntregable"
				'.$inner.' JOIN (SELECT "iIdDetalleEntregable", "dFecha" fechamax, SUM("nBeneficiariosH") beneficiariosh, SUM("nBeneficiariosM") beneficiariosm, SUM("nDiscapacitadosH") discapacitadosh, SUM("nDiscapacitadosM") discapacitadosm, SUM("nLenguaH") lenguah, SUM("nLenguaM") lenguam 
				        FROM "Avance" 
				        WHERE "iActivo" = 1 AND "iAprobado" = 1 '.$where.'
				        GROUP BY "iIdDetalleEntregable", "dFecha" ) AS ben ON ben."iIdDetalleEntregable" = det."iIdDetalleEntregable" AND ben.fechamax = av.fechamax
				GROUP BY dep."vDependencia", act."iIdActividad", dat."iIdDetalleActividad", ent."vEntregable", ent."iMismosBeneficiarios"
				ORDER BY act."iImportante" DESC, act."vActividad" ASC';
		return $this->db->query($sql)->result();
	}

	public function listado_actividades_by_keyword($keyword,$municipio=0,$eje=0) {
		$inner = ($municipio > 0) ? 'INNER':'LEFT OUTER';
		$where = ($municipio > 0) ? 'AND "iMunicipio" = '.$municipio:'';
		$where2 = ($eje > 0) ? ' AND ped."iIdEje" = '.$eje:'';
		$sql = 'SELECT dep."vDependencia", act."iIdActividad", act."vActividad", dat."iIdDetalleActividad", ent."vEntregable", ent."iMismosBeneficiarios", SUM(av.avance) avance, SUM(av.ejercido) ejercido, (SUM(av.beneficiariosh) + SUM(av.beneficiariosm)) beneficiarios, (SUM(ben.beneficiariosh) + SUM(ben.beneficiariosm)) bene
				FROM "ActividadLineaAccion" al
				INNER JOIN "Actividad" act ON act."iIdActividad" = al."iIdActividad"
				INNER JOIN "Dependencia" dep ON dep."iIdDependencia" = act."iIdDependencia"
				INNER JOIN "PED2019" ped ON ped."iIdLineaAccion" = al."iIdLineaAccion" 
				INNER JOIN "DetalleActividad" dat ON dat."iIdActividad" = al."iIdActividad" AND dat."iActivo" = 1 
				INNER JOIN "DetalleEntregable" det ON det."iIdDetalleActividad" = dat."iIdDetalleActividad" AND det."iActivo" = 1
				INNER JOIN "Entregable" ent ON ent."iIdEntregable" = det."iIdEntregable"
				'.$inner.' JOIN (SELECT "iIdDetalleEntregable", SUM("nAvance") avance, SUM("nEjercido")  ejercido, SUM("nBeneficiariosH") beneficiariosh, SUM("nBeneficiariosM") beneficiariosm, SUM("nDiscapacitadosH") discapacitadosh, SUM("nDiscapacitadosM") discapacitadosm, SUM("nLenguaH") lenguah, SUM("nLenguaM") lenguam, MAX("dFecha") fechamax
				                          FROM "Avance"
				                          WHERE "iActivo" = 1 AND "iAprobado" = 1 '.$where.'
				                          GROUP BY "iIdDetalleEntregable") AS av ON av."iIdDetalleEntregable" = det."iIdDetalleEntregable"
				'.$inner.' JOIN (SELECT "iIdDetalleEntregable", "dFecha" fechamax, SUM("nBeneficiariosH") beneficiariosh, SUM("nBeneficiariosM") beneficiariosm, SUM("nDiscapacitadosH") discapacitadosh, SUM("nDiscapacitadosM") discapacitadosm, SUM("nLenguaH") lenguah, SUM("nLenguaM") lenguam 
				        FROM "Avance" 
				        WHERE "iActivo" = 1 AND "iAprobado" = 1 '.$where.'
				        GROUP BY "iIdDetalleEntregable", "dFecha" ) AS ben ON ben."iIdDetalleEntregable" = det."iIdDetalleEntregable" AND ben.fechamax = av.fechamax
				WHERE lower(translate(act."vActividad",\'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ\',\'aeiouAEIOUaeiouAEIOU\')) ilike lower(translate(\'%'.$keyword.'%\',\'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ\',\'aeiouAEIOUaeiouAEIOU\'))
				'.$where2.' 
				GROUP BY dep."vDependencia", act."iIdActividad", dat."iIdDetalleActividad", ent."vEntregable", ent."iMismosBeneficiarios"
				ORDER BY act."iImportante" DESC, act."vActividad" ASC';
		return $this->db->query($sql)->result();
	}

	function nombre_actividades($term,$anio=0,$eje=0) {
		$this->db->select('da.iIdDetalleActividad, a.vActividad');
		$this->db->from('Actividad a');
		$this->db->join('DetalleActividad da','da.iIdActividad = a.iIdActividad','INNER');
		$this->db->where('a.iActivo',1);
		$this->db->where("(LOWER(translate(a.\"vActividad\",'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) ILIKE LOWER(translate('%$term%','áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')))");
		if($anio > 0) $this->db->where('da.iAnio',$anio);
		$this->db->order_by('a.vActividad');
		if($eje > 0)
		{
			$this->db->join('DependenciaEje dej','dej.iIdDependencia = a.iIdDependencia AND dej.iIdEje = '.$eje,'INNER');			
		}

		return $this->db->get();
	}

	function avances_entregable($iIdActividad,$anio=0) {
		$sql = 'SELECT dat."iAnio", ent."vEntregable", det."nMeta", COALESCE(SUM(av."nAvance"),0) avance 
				FROM "DetalleActividad" dat
				INNER JOIN "DetalleEntregable" det ON det."iIdDetalleActividad" = dat."iIdDetalleActividad" AND det."iActivo" = 1
				INNER JOIN "Entregable" ent ON ent."iIdEntregable" = det."iIdEntregable"
				LEFT OUTER JOIN "Avance" av ON av."iIdDetalleEntregable" = det."iIdDetalleEntregable" AND av."iActivo" = 1 AND av."iAprobado" = 1
				WHERE "iIdActividad" = '.$iIdActividad.' AND dat."iActivo" = 1
				GROUP BY dat."iAnio", ent."vEntregable", det."nMeta", av."iIdDetalleEntregable"
				ORDER BY dat."iAnio", av."iIdDetalleEntregable"';
		return $this->db->query($sql)->result();
	}

	function deps_anio_eje($anio,$eje) {
		$sql = 'SELECT dep."iIdDependencia", dep."vNombreCorto", dep."vDependencia", COUNT(act."vActividad") numact, SUM(dat."nAvance") sumavance

		FROM "Dependencia" dep

		INNER JOIN "Actividad" act ON act."iIdDependencia" = dep."iIdDependencia"

		INNER JOIN "DetalleActividad" dat ON dat."iIdActividad" = act."iIdActividad" AND dat."iActivo" = 1 AND dat."iSuspendida" = 0 AND dat."iAnio" = '.$anio.'

		WHERE act."iideje" = '.$eje.' and dep."iActivo" = 1

		GROUP BY dep."iIdDependencia", dep."vNombreCorto", dep."vDependencia"

		ORDER BY dep."vNombreCorto"';

		/*$sql = 'SELECT dep."iIdDependencia", dep."vNombreCorto", dep."vDependencia", COUNT(act."vActividad") numact, SUM(dat."nAvance") sumavance
				FROM "Dependencia" dep
				INNER JOIN "DependenciaEje" dej ON dej."iIdDependencia" = dep."iIdDependencia" AND dep."iActivo" = 1
				INNER JOIN "Actividad" act ON act."iIdDependencia" = dep."iIdDependencia"
				INNER JOIN "DetalleActividad" dat ON dat."iIdActividad" = act."iIdActividad" AND dat."iActivo" = 1 AND dat."iSuspendida" = 0 AND dat."iAnio" = '.$anio.'
				WHERE dej."iIdEje" = '.$eje.'
				GROUP BY dep."iIdDependencia", dep."vNombreCorto", dep."vDependencia"
				ORDER BY dep."vNombreCorto"';*/
		return $this->db->query($sql)->result();
	}

	function list_actividades($anio,$dep) {
		$sql = 'SELECT act."iIdActividad", act."vActividad", dat."nAvance", dat."iIdDetalleActividad"
				FROM "Dependencia" dep
				INNER JOIN "Actividad" act ON act."iIdDependencia" = dep."iIdDependencia"
				INNER JOIN "DetalleActividad" dat ON dat."iIdActividad" = act."iIdActividad" AND dat."iActivo" = 1 AND dat."iAnio" = '.$anio.'
				WHERE act."iIdDependencia" = '.$dep.'
				ORDER BY act."vActividad"';
		return $this->db->query($sql)->result();
	}

	function avance_por_detalle($idDetalle){
		$sql = 'SELECT * FROM "DetalleEntregable" de
			INNER JOIN "Avance" a ON a."iIdDetalleEntregable" = de."iIdDetalleEntregable"
			WHERE de."iActivo" = 1 AND de."iIdDetalleActividad" = '.$idDetalle.' AND a."iActivo" = 1 
			ORDER BY a."iIdAvance"';
		return $this->db->query($sql)->result();
	}

	function avance_por_dependencia($idDePendencia, $anio){
			$sql = 'SELECT sum(a."nAvance") as nAvance, max(a."nBeneficiariosH") as nBeneficiariosH, max(a."nBeneficiariosM") as nBeneficiariosM, max(a."nDiscapacitadosH") as nDiscapacitadosH,max(a."nDiscapacitadosM") as nDiscapacitadosM,max(a."nLenguaH") nLenguaH ,max(a."nLenguaM") nLenguaM,max(a."nTerceraEdadH") nTerceraEdadH,max(a."nTerceraEdadM") nTerceraEdadM,
            max(a."nAdolescenteH") nAdolescenteH,max(a."nAdolescenteM") nAdolescenteM, da."iIdActividad" FROM "Avance" a
            INNER JOIN "DetalleEntregable" de on de."iIdDetalleEntregable" = a."iIdDetalleEntregable"
            INNER JOIN "DetalleActividad" da on da."iIdDetalleActividad" =  de."iIdDetalleActividad" AND da."iActivo" = 1 AND da."iSuspendida" = 0 AND da."iAnio" = '.$anio.'
            INNER JOIN "Actividad" act on act."iIdActividad" = da."iIdActividad"
            where a."iActivo" = 1 AND a."iAprobado" = 1 AND act."iIdDependencia" ='.$idDePendencia.'
			GROUP BY da."iIdActividad"';
			return $this->db->query($sql)->result();
	}

	public function dependencias_por_eje($idEje){
		$sql = 'SELECT ids."iIdEje", ids."vEje",ids."iIdDependencia" from info_dash_sector ids 
			LEFT JOIN "DetalleActividad" da on da."iIdDetalleActividad" = ids."iIdDetalleActividad" 
			WHERE da."iActivo" = 1 AND ids."iIdEje" = '.$idEje.'
			GROUP BY ids."iIdEje", ids."vEje",ids."iIdDependencia"
			ORDER BY ids."iIdEje"';
		return $this->db->query($sql)->result();
	}

	public function retos_por_eje($idEje){
		$sql = 'SELECT "iIdReto" FROM public."Reto" where "iIdEje" = '.$idEje;
		return $this->db->query($sql)->num_rows();
	}

	function avance_anios($idAct)
	{
		$sql = 'SELECT "iAnio", "nAvance"
				FROM "DetalleActividad" 
				WHERE "iActivo" = 1 AND "iIdActividad" = '.$idAct.' 
				ORDER BY "iAnio" DESC';
		return $this->db->query($sql)->result();
	}

	function finanzas_by_anio($idAct,$anio)
	{
		$sql = 'SELECT dat."iIdDetalleActividad", dat."iAnio",  COALESCE(SUM(pre.presupuesto),0) presupuesto, COALESCE(SUM(dat."nPresupuestoAutorizado"),0) autorizado, COALESCE(SUM(dat."nPresupuestoModificado"),0) modificado
				FROM "DetalleActividad" dat
				LEFT OUTER JOIN ( SELECT "iIdDetalleActividad", SUM ( monto ) presupuesto FROM "DetalleActividadFinanciamiento" GROUP BY "iIdDetalleActividad" ) AS pre ON pre."iIdDetalleActividad" = dat."iIdDetalleActividad"
				WHERE dat."iActivo" = 1 AND dat."iIdActividad" = '.$idAct.' AND dat."iAnio" = '.$anio.'
				GROUP BY dat."iIdDetalleActividad", dat."iAnio"
				ORDER BY dat."iAnio"';
		return $this->db->query($sql);
	}
	function finanzas_by_anio_mes($idAct,$anio)
	{
		$sql = 'SELECT dat."iIdDetalleActividad", dat."iAnio",Extract(MONTH FROM dat."dInicio") mes, COALESCE(SUM(pre.presupuesto),0) presupuesto, COALESCE(SUM(dat."nPresupuestoAutorizado"),0) autorizado, COALESCE(SUM(dat."nPresupuestoModificado"),0) modificado
				FROM "DetalleActividad" dat
				LEFT OUTER JOIN ( SELECT "iIdDetalleActividad", SUM ( monto ) presupuesto FROM "DetalleActividadFinanciamiento" GROUP BY "iIdDetalleActividad" ) AS pre ON pre."iIdDetalleActividad" = dat."iIdDetalleActividad"
				WHERE dat."iActivo" = 1 AND dat."iIdActividad" = '.$idAct.' AND dat."iAnio" = '.$anio.'
				GROUP BY dat."iIdDetalleActividad", dat."iAnio"
				ORDER BY dat."iAnio", dat."dInicio" asc';
		return $this->db->query($sql);
	}

	function ejercido_by_idact($idAct)
	{
		$sql = 'SELECT SUM(av."nEjercido") ejercido 
				FROM "Avance" av
				INNER JOIN "DetalleEntregable" det ON det."iIdDetalleEntregable" = av."iIdDetalleEntregable" AND det."iActivo" = 1 
				INNER JOIN "DetalleActividad" dat ON dat."iIdDetalleActividad" = det."iIdDetalleActividad" AND dat."iActivo" = 1 
				WHERE av."iActivo" = 1 AND av."iAprobado" = 1  AND dat."iIdDetalleActividad" = '.$idAct.'
				GROUP BY dat."iIdDetalleActividad"';
		$query = $this->db->query($sql);
		return ($query->num_rows() == 1) ? $query->row()->ejercido:0;
	} 

	function list_entregables_by_idact($idAct)
	{
		$sql = 'SELECT ent."iIdEntregable", ent."vEntregable", um."vUnidadMedida"
			FROM "DetalleActividad" dat 
			INNER JOIN "DetalleEntregable" det ON det."iIdDetalleActividad" = dat."iIdDetalleActividad" AND det."iActivo" = 1
			INNER JOIN "Entregable" ent ON ent."iIdEntregable" = det."iIdEntregable" 
			INNER JOIN "UnidadMedida" um ON um."iIdUnidadMedida" = ent."iIdUnidadMedida"
			WHERE dat."iActivo" = 1 AND dat."iIdActividad" = '.$idAct.'
			GROUP BY ent."iIdEntregable", ent."vEntregable", um."vUnidadMedida"
			ORDER BY ent."vEntregable"';

		return $this->db->query($sql)->result();
	}

	function metas_av_anio($idAct,$idEnt,$anio)
	{
		var_dump($idAct);
		var_dump($idEnt);
		var_dump($anio);
		$sql = 'SELECT de."nMeta", de."nMetaModificada", COALESCE(SUM(av."nAvance"),0) avance 
				FROM "DetalleActividad" da
				INNER JOIN "DetalleEntregable" de ON de."iIdDetalleActividad" = da."iIdDetalleActividad" AND de."iActivo" = 1 AND de."iIdEntregable" = '.$idEnt.'
				LEFT OUTER JOIN "Avance" av ON av."iIdDetalleEntregable" = de."iIdDetalleEntregable" AND av."iActivo" = 1 AND av."iAprobado" = 1
				WHERE da."iActivo" = 1 AND da."iAnio" = '.$anio.' AND da."iIdActividad" = '.$idAct.'
				GROUP BY de."iIdDetalleEntregable", de."nMeta", de."nMetaModificada"';

		return $this->db->query($sql);
	}

	function metas_av_anio_mes($idAct,$idEnt,$anio)
	{

		$sql = 'SELECT de."nMeta", de."nMetaModificada", av."nAvance" Avance, EXTRACT(MONTH FROM av."dFecha") mes
				FROM "DetalleActividad" da
				INNER JOIN "DetalleEntregable" de ON de."iIdDetalleActividad" = da."iIdDetalleActividad" AND de."iActivo" = 1 AND de."iIdEntregable" = '.$idEnt.'
				LEFT OUTER JOIN "Avance" av ON av."iIdDetalleEntregable" = de."iIdDetalleEntregable" AND av."iActivo" = 1 AND av."iAprobado" = 1
				WHERE da."iActivo" = 1 AND da."iAnio" = '.$anio.' AND da."iIdActividad" = '.$idAct.'
				ORDER BY av."dFecha" asc';

		return $this->db->query($sql);
	}

	function avan_ejer_anio($idAct,$idEnt,$anio)
	{
		$sql = 'SELECT EXTRACT(MONTH FROM av."dFecha") - 1 AS mes, av."dFecha", SUM(av."nAvance") avance, SUM(av."nEjercido") ejercido 
				FROM "Avance" av
				INNER JOIN "DetalleEntregable" det ON det."iIdDetalleEntregable" = av."iIdDetalleEntregable"
				INNER JOIN "DetalleActividad" dat ON dat."iIdDetalleActividad" = det."iIdDetalleActividad" AND dat."iActivo" = 1 AND dat."iIdActividad" = '.$idAct.' AND dat."iAnio" = '.$anio.'
				WHERE av."iActivo" = 1 AND av."iAprobado" = 1 AND det."iActivo" = 1 AND det."iIdEntregable" = '.$idEnt.'
				GROUP BY av."dFecha"
				ORDER BY av."dFecha"';
		return $this->db->query($sql)->result();
	}

	function buscar_act_dep($keyword,$ideje=0)
	{
		$sql = 'SELECT term.id, term.nom, term.nom2, term.ideje, term.tipo 
		FROM (
		 (SELECT dep."iIdDependencia" AS id, dep."vDependencia" AS nom, dep."vNombreCorto" AS nom2, dej."iIdEje" AS ideje, 1 As tipo 
		FROM "Dependencia" dep
		INNER JOIN "DependenciaEje" dej ON dej."iIdDependencia" = dep."iIdDependencia" AND dep."iActivo" = 1)
		UNION ALL
		(SELECT act."iIdActividad" AS id, act."vActividad" AS nom, \'\' AS nom2, dej."iIdEje" AS ideje, 2 AS tipo
		FROM "Actividad" act
		INNER JOIN "DetalleActividad" dat ON dat."iIdActividad" = act."iIdActividad" AND dat."iActivo" = 1
		INNER JOIN "DependenciaEje" dej ON dej."iIdDependencia" = act."iIdDependencia" 
		GROUP BY act."iIdActividad", act."vActividad", dej."iIdEje") ) AS term
		WHERE ( lower(translate(term.nom,\'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ\',\'aeiouAEIOUaeiouAEIOU\')) ilike lower(translate( \'%'.$keyword.'%\',\'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ\',\'aeiouAEIOUaeiouAEIOU\')) OR lower(translate(term.nom2,\'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ\',\'aeiouAEIOUaeiouAEIOU\')) ilike lower(translate( \'%'.$keyword.'%\',\'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ\',\'aeiouAEIOUaeiouAEIOU\')) )';
		if($ideje > 0) $sql.= ' AND term.ideje = '.$ideje;
		$sql.= ' ORDER BY term.id';

		return $this->db->query($sql);
	}
/*
	function avance_obras($anio)
	{
		$sql = 'SELECT COUNT(o."iIdObra") numobras, COALESCE(SUM(c."iAvanceFisico"),0) avancefisico, COALESCE(SUM(c."iAvanceFinanciero"),0) avancefinanciero  FROM "Obra" o
				LEFT OUTER JOIN "Contrato" c ON c."iIdObra" = o."iIdObra" AND c."iActivo" = 1
				WHERE o."iActivo" = 1 AND o."iAnioEjecucion" = '.$anio;

		return $this->ssop->query($sql)->row();
	}

	function presupuesto_obras($anio)
	{
		$sql = 'SELECT COUNT(o."iIdObra") numobras, COALESCE(SUM(of."nMonto")) presupuestoobra  FROM "Obra" o
				INNER JOIN "ObraFinanciamiento" of ON of."iIdObra" = o."iIdObra"
				WHERE o."iActivo" = 1 AND o."iAnioEjecucion" = '.$anio;
		return $this->ssop->query($sql)->row();
	}

	function obras_por_ejecutora($anio=0,$id=0)
	{
		$sql = 'SELECT dep."iIdDependencia", dep."vDependencia", COUNT(o."iIdObra") total, (SELECT COUNT("iIdObra") FROM "Obra" WHERE "iActivo" = 1 AND "iIdEjecutor" = dep."iIdDependencia" AND "iEstatus" = 5) licitadas,
				(SELECT COUNT("iIdObra") FROM "Obra" WHERE "iActivo" = 1 AND "iIdEjecutor" = dep."iIdDependencia" AND "iEstatus" = 8) concluidas,
				(SELECT COUNT("iIdObra") FROM "Obra" WHERE "iActivo" = 1 AND "iIdEjecutor" = dep."iIdDependencia" AND "iEstatus" = 1) noiniciadas
				FROM "Obra" o
				INNER JOIN "Dependencia" dep ON dep."iIdDependencia" = o."iIdEjecutor"
				WHERE o."iActivo" = 1';
		if($anio > 0) $sql.= ' AND o."iAnioEjecucion" = '.$anio;
		if($id > 0) $sql.= ' AND dep."iIdDependencia" = '.$id;
		$sql.= ' GROUP BY dep."iIdDependencia"';
		return $this->ssop->query($sql);
	}

	function list_obras_ejecutor($anio=0,$id=0)
	{
		$sql = 'SELECT o."iIdObra", o."vNombre", SUM(of."nMonto") AS presupuesto
				FROM "Obra" o 
				LEFT OUTER JOIN "ObraFinanciamiento" of ON of."iIdObra" = o."iIdObra"
				WHERE o."iActivo" = 1 AND o."iIdEjecutor" = '.$id.' AND o."iAnioEjecucion" = '.$anio.' 
				GROUP BY o."iIdObra"';
		return $this->ssop->query($sql)->result();
	}
*/
	function alineacion_actividad_ods($idAct)
	{
		$sql = 'SELECT ped."iIdOds" FROM "ActividadLineaAccion" al
				INNER JOIN "PED2019" ped ON ped."iIdLineaAccion" = al."iIdLineaAccion" 
				WHERE al."iIdActividad" = '.$idAct.' 
				GROUP BY ped."iIdOds"';
		return $this->db->query($sql);
	}

	function presupuesto_por_dependencia($idEje, $idDep, $iAnio){
		$sql = 'SELECT "iIdEje", "vEje", SUM("ejercido") AS ejercido  FROM "info_dash_sector" 
				WHERE "iIdDependencia" = '.$idDep.' AND "iAnio" = '.$iAnio.' and "iIdEje" = '.$idEje.
				' GROUP BY "iIdEje", "vEje"';

		return $this->db->query($sql)->result();
	}

	function getDetalleActividad($idDetalleActividad){
		$sql = 'SELECT * FROM "DetalleActividad" WHERE "iIdDetalleActividad" ='.$idDetalleActividad;
		return $this->db->query($sql)->result();
	}
}
