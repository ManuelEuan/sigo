<?php
class M_pat extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	/* MOSTRAR DATOS */

	public function mostrar_act($keyword = null, $year = null, $sec = 0, $dep = 0, $covid = "")
	{
		$this->db->select('*, 0 AS ods');
		$this->db->from('DetalleActividad da');
		$this->db->join('Actividad a', 'da.iIdActividad = a.iIdActividad', 'INNER');
		$this->db->join('Dependencia d', 'd.iIdDependencia = a.iIdDependencia', 'INNER');
		$this->db->join('DependenciaEje de', 'de.iIdDependencia = d.iIdDependencia', 'INNER');
		$this->db->join('PED2019Eje e', 'e.iIdEje = de.iIdEje', 'INNER');
		$this->db->where('da.iActivo', 1);
		$this->db->where('a.iActivo', 1);
		$this->db->order_by('a.vActividad', 'ASC');
		//lower(translate("vActividad",'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU'))
		if (!empty($keyword) && $keyword != null) {
			//$sqlPalabra = "\"c\".\"vCompromiso\" ilike '%$palabra%'";
			$this->db->where("(lower(translate(\"vActividad\",'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) ilike lower(translate('%$keyword%','áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')))");
		}
		if (!empty($year) && $year != null) {
			$this->db->where('da.iAnio', $year);
		}

		if (!empty($sec) && $sec != null) {
			$this->db->where('e.iIdEje', $sec);
		}

		if (!empty($dep) && $dep != null) {
			$this->db->where('a.iIdDependencia', $dep);
		}

		if ($covid != "") {
			$this->db->where('da.iReactivarEconomia', $covid);
		}

		$query =  $this->db->get();
		//$_SESSION['SQL_'] = $this->db->last_query();
		$resultado = $query->result();
		return $resultado;
	}

	/* Mostrar Ejes */
	public function mostrarEje()
	{
		$this->db->order_by('vEje', 'asc');
		$this->db->select();
		$this->db->from('PED2019Eje');

		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}

	public function obtenerRetosEje($id)
	{
		$sql = 'SELECT "Retos"."iIdReto", "Retos"."vDescripcion" FROM "EjeRetos" 
		INNER JOIN "Retos" ON "Retos"."iIdReto" = "EjeRetos"."iIdReto"
		WHERE "EjeRetos"."iIdEje" =' . $id;
		$query =  $this->db->query($sql);
		return $query->result();
	}
	public function obtenerDependenciaEje($id)
	{
		$sql = 'SELECT "Dependencia"."iIdDependencia", "Dependencia"."vDependencia" FROM "DependenciaEje" 
		INNER JOIN "Dependencia" ON "Dependencia"."iIdDependencia" = "DependenciaEje"."iIdDependencia"
		WHERE "DependenciaEje"."iIdEje" =' . $id;
		$query =  $this->db->query($sql);
		return $query->result();
	}

	/* Mostrar Ejes */
	public function mostrarReto()
	{
		$this->db->order_by('vDescripcion', 'asc');
		$this->db->select();
		$this->db->from('Reto');

		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}



	/* Mostrar Politica Publica */
	public function mostrarPpublica($eje = null)
	{
		$this->db->order_by('vTema', 'asc');
		$this->db->select();
		$this->db->from('PED2019Tema');

		if ($eje != null) {
			$this->db->where('iIdEje', $eje);
		}

		$query = $this->db->get();
		return $query->result();
		//return $resultado;
	}

	/* Mostrar Objetivo */
	public function mostrarObjetivo($popu = null)
	{
		$this->db->order_by('vObjetivo', 'asc');
		$this->db->select();
		$this->db->from('PED2019Objetivo');

		if ($popu != null) {
			$this->db->where('iIdTema', $popu);
		}

		$query = $this->db->get();
		return $query->result();
	}

	/* Mostrar Estrategia */
	public function mostrarEstrategia($obj = null)
	{
		$this->db->order_by('vEstrategia', 'asc');
		$this->db->select();
		$this->db->from('PED2019Estrategia');

		if ($obj != null) {
			$this->db->where('iIdObjetivo', $obj);
		}

		$query = $this->db->get();
		return $query->result();
	}

	/* Mostrar linea de Accion */
	public function mostrarLineaAccion($est = null)
	{
		$this->db->order_by('vLineaAccion', 'asc');
		$this->db->select();
		$this->db->from('PED2019LineaAccion');

		if ($est != null) {
			$this->db->where('iIdEstrategia', $est);
		}

		$query = $this->db->get();
		return $query->result();
	}

	/* Mostrar Financiamiento */
	public function mostrarFinanciamiento($anio = 0)
	{
		$this->db->order_by('vFinanciamiento', 'asc');
		$this->db->select();
		$this->db->from('Financiamiento');
		$this->db->where('iActivo', 1);
		if ($anio > 0) $this->db->where('iAnio', $anio);

		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}

	/* Mostrar UBP */
	public function mostrarUbp($anio = 0)
	{
		$this->db->order_by('"vClave" ASC, "vUBP"');
		$this->db->select('*,"vClave" AS defe');
		$this->db->from('UBP');
		$this->db->where('iActivo', 1);
		if ($anio > 0) $this->db->where('iAnio', $anio);

		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}

	/* Guardar datos */

	public function agregarInforme($data, $idAct, $idLA)
	{
		//$this->db->insert('ActividadLineaAccion', $data);
		$this->db->where('iIdActividad', $idAct);
		$this->db->where('iIdLineaAccion', $idLA);
		return $this->db->update('ActividadLineaAccion', $data);
	}

	public function consultaExiste($data)
	{
		$this->db->where('iIdActividad', $data['iIdActividad']);
		$this->db->where('iIdLineaAccion', $data['iIdLineaAccion']);
		$this->db->select('*');
		$this->db->from('ActividadLineaAccion');
		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}

	public function agregarAct($data)
	{
		$this->db->insert('Actividad', $data);
		return $this->db->insert_id();
	}

	public function obtenerActividades($idDependencia)
	{
		$this->db->select();
		$this->db->from('Actividad');
		$this->db->where('iIdDependencia', $idDependencia);
		$this->db->where('iActivo', 1);
		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}
	public function obtenerResumen($idNivel)
	{
		$this->db->select();
		$this->db->from('ResumenNarrativo');
		$this->db->where('iNivel', $idNivel);
		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}

	public function obtenerAreasRESP($idDependencia)
	{
		$this->db->select();
		$this->db->from('AreaResponsable');
		$this->db->where('iIdDependencia', $idDependencia);
		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}

	public function obtenerODS()
	{
		$this->db->select();
		$this->db->from('ODS');
		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}

	public function obtenerProyectosPrioritarios()
	{
		$this->db->select();
		$this->db->from('ProyectosPrioritarios');
		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}

	public function obtenerProgramaPresupuestario()
	{
		$this->db->select();
		$this->db->from('ProgramaPresupuestario');
		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}

	public function obtenerNivelesMIR()
	{
		$this->db->select();
		$this->db->from('NivelMIR');
		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}

	public function obtenerResumenNarrativo()
	{
		$this->db->select();
		$this->db->from('ResumenNarrativo');
		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}

	public function agregarDetAct($data)
	{
		$this->db->insert('DetalleActividad', $data);
		return $this->db->insert_id();
	}

	public function agregarActLineaAcc($LinAcc)
	{
		$this->db->insert('ActividadLineaAccion', $LinAcc);
		return $this->db->insert();
	}

	public function agregarActFinanciamiento($fin)
	{
		$this->db->insert('DetalleActividadFinanciamiento', $fin);
		return $this->db->insert();
	}

	public function agregarActUBP($UBP)
	{
		$this->db->insert('DetalleActividadUBP', $UBP);
		return $this->db->insert();
	}

	/* Modificar datos */

	public function preparar_update($id)
	{
		$sql = 'SELECT * FROM "DetalleActividad" detAct
            INNER JOIN "Actividad" act on act."iIdActividad" = detAct."iIdActividad" 
			INNER JOIN "Dependencia" d on d."iIdDependencia" = act."iIdDependencia" 
			INNER JOIN "DependenciaEje" de on de."iIdDependencia" = d."iIdDependencia"  
			WHERE detAct."iIdDetalleActividad" = ' . $id . '
			LIMIT 1';

		return $this->db->query($sql)->result();
	}

	public function validaralineaneacionactividad($idactividad)
	{
		//$datosDA = $this->preparar_update($id);

		$this->db->select();
		$this->db->from('ActividadLineaAccion');
		$this->db->where('iIdActividad', $idactividad/*$datosDA->iIdActividad*/);

		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}

	public function preparar_update2($iIdDetalleActividad)
	{
		$this->db->distinct();
		$this->db->select();
		$this->db->from('DetalleActividadLineaAccion ala');
		$this->db->join('DetalleActividad da', 'da.iIdDetalleActividad = ala.iIdDetalleActividad', 'JOIN');
		$this->db->join('Actividad a', 'a.iIdActividad = da.iIdActividad', 'JOIN');
		$this->db->join('PED2019LineaAccion la', 'ala.iIdLineaAccion = la.iIdLineaAccion', 'JOIN');
		$this->db->join('PED2019Estrategia e', 'la.iIdEstrategia = e.iIdEstrategia', 'JOIN');
		$this->db->join('PED2019Objetivo o', 'e.iIdObjetivo = o.iIdObjetivo', 'JOIN');
		$this->db->join('PED2019Tema t', 'o.iIdTema = t.iIdTema', 'JOIN');
		$this->db->join('PED2019Eje ej', 't.iIdEje = ej.iIdEje', 'JOIN');
		$this->db->where('ala.iIdDetalleActividad', $iIdDetalleActividad);

		$query =  $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}

	public function preparar_carrito($id)
	{
		$this->db->select();
		$this->db->from('ActividadLineaAccion al');
		$this->db->join('PED2019LineaAccion la', 'al.iIdLineaAccion = la.iIdLineaAccion', 'JOIN');
		$this->db->where('iIdActividad', $id);

		$query =  $this->db->get()->row();

		return $query;
	}

	public function getCarritoSelec($iIdActividad)
	{
		/*$datosDA = $this->DAA($id);

		$this->db->select('la.*,al.*,e.*,o.*,t.*,ej.*,1 as "iActivo"');
		$this->db->from('ActividadLineaAccion al');
		$this->db->join('DetalleActividad da', 'al.iIdActividad = da.iIdActividad', 'JOIN');
		$this->db->join('PED2019LineaAccion la', 'al.iIdLineaAccion = la.iIdLineaAccion', 'JOIN');
		$this->db->join('PED2019Estrategia e', 'la.iIdEstrategia = e.iIdEstrategia', 'JOIN');
		$this->db->join('PED2019Objetivo o', 'e.iIdObjetivo = o.iIdObjetivo', 'JOIN');
		$this->db->join('PED2019Tema t', 'o.iIdTema = t.iIdTema', 'JOIN');
		$this->db->join('PED2019Eje ej', 't.iIdEje = ej.iIdEje', 'JOIN');
		$this->db->where('da.iIdDetalleActividad', $id);
		$query = $this->db->get();*/
		$sql = 'SELECT ped.*, COALESCE(t.caracteres,0) caracteres
				FROM "ActividadLineaAccion" al
				INNER JOIN "PED2019" ped ON ped."iIdLineaAccion" = al."iIdLineaAccion"
				LEFT OUTER JOIN (SELECT dat."iIdLineaAccion", CHAR_LENGTH(LTRIM(CONCAT(string_agg(dat."tInforme1",\'\'), string_agg(dat."tInforme2",\'\'), string_agg(dat."tInforme3",\'\'), string_agg(dat."tInforme4",\'\')))) AS caracteres
								FROM "ActividadLineaAccion" al
								INNER JOIN "DetalleActividad" da ON da."iIdActividad" = al."iIdActividad"
								LEFT OUTER JOIN "DetalleActividadLineaAccion" dat ON dat."iIdDetalleActividad" = da."iIdDetalleActividad"
								WHERE al."iIdActividad" = ' . $iIdActividad . '
								GROUP BY dat."iIdLineaAccion") AS t ON t."iIdLineaAccion" = al."iIdLineaAccion"
				WHERE al."iIdActividad" = ' . $iIdActividad;
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getCarritoFinan($id)
	{
		$this->db->select('da.*,daf.*,1 as "iActivo"');
		$this->db->from('DetalleActividadFinanciamiento daf');
		$this->db->join('Financiamiento da', 'daf.iIdFinanciamiento = da.iIdFinanciamiento', 'JOIN');
		$this->db->where('daf.iIdDetalleActividad', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function getCarritoUbpP($id)
	{
		$this->db->select('da.*,dau.*,u.*,pp.*,1 as "iActivo"');
		$this->db->from('DetalleActividadUBP dau');
		$this->db->join('DetalleActividad da', 'dau.iIdDetalleActividad = da.iIdDetalleActividad', 'JOIN');
		$this->db->join('UBP u', 'dau.iIdUbp = u.iIdUbp', 'JOIN');
		$this->db->join('ProgramaPresupuestario pp', 'u.iIdProgramaPresupuestario = pp.iIdProgramaPresupuestario', 'JOIN');
		$this->db->where('dau.iIdDetalleActividad', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function modificarDetaAct($data1, $id)
	{
		$this->db->where('iIdDetalleActividad', $id);

		return $this->db->update('DetalleActividad', $data1);
	}

	public function modificarAct($data, $idActividad)
	{
		$this->db->where('iIdActividad', $idActividad);

		$query  = $this->db->update('Actividad', $data);

		return $query;
	}

	/* Eliminar datos */

	public function eliminarActLineaAcc($idActividad)
	{
		$this->db->where('iIdActividad', $idActividad);
		if ($this->db->delete('ActividadLineaAccion')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function eliminarActFinanciamiento($id)
	{
		$this->db->where('iIdDetalleActividad', $id);
		if ($this->db->delete('DetalleActividadFinanciamiento')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function eliminarActUBP($id)
	{
		$this->db->where('iIdDetalleActividad', $id);
		if ($this->db->delete('DetalleActividadUBP')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function eliminarDetaActividad($id)
	{
		$this->db->where('iIdDetalleActividad', $id);
		$data = array('iActivo' => 0);
		$this->db->update('DetalleActividad', $data);
		return $this->db->affected_rows();
	}

	/* Consulta linea de accion (join) */
	public function getRecord($id)
	{
		$this->db->select();
		$this->db->select('0 AS caracteres');
		$this->db->from('PED2019LineaAccion la');
		$this->db->where('iIdLineaAccion', $id);
		//$this->db->join('ActividadLineaAccion ala', 'la.iIdLineaAccion = ala.iIdLineaAccion', 'JOIN');
		$this->db->join('PED2019Estrategia e', 'la.iIdEstrategia = e.iIdEstrategia', 'JOIN');
		$this->db->join('PED2019Objetivo o', 'e.iIdObjetivo = o.iIdObjetivo', 'JOIN');
		$this->db->join('PED2019Tema t', 'o.iIdTema = t.iIdTema', 'JOIN');
		$this->db->join('PED2019Eje ej', 't.iIdEje = ej.iIdEje', 'JOIN');
		$query = $this->db->get();
		return $query->result();
	}

	public function DAA($id)
	{
		$this->db->select();
		$this->db->from('DetalleActividad da');
		$this->db->where('iIdDetalleActividad', $id);
		$query = $this->db->get()->row();
		return $query;
	}


	/* Consulta financiamiento */
	public function getFinanciamiento($id)
	{
		$this->db->select();
		$this->db->from('Financiamiento');
		$this->db->where('iIdFinanciamiento', $id);
		$query = $this->db->get();
		return $query->result();
	}

	/* Consulta UBP (join) */
	public function getUbpsPP($id)
	{
		$this->db->select();
		$this->db->from('UBP u');
		$this->db->where('iIdUbp', $id);
		$this->db->join('ProgramaPresupuestario p', 'u.iIdProgramaPresupuestario = p.iIdProgramaPresupuestario', 'JOIN');
		$query = $this->db->get();
		return $query->result();
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Captura de texto
	public function consultaLA($iIdActividad, $iIdDetalleActividad)
	{
		$this->db->select('ped.*,dal.iIdDetalleActividad, dal.tInforme1, dal.tInforme2, dal.tInforme3, dal.tInforme4');
		$this->db->from('ActividadLineaAccion al');
		$this->db->join('PED2019 ped', 'ped.iIdLineaAccion = al.iIdLineaAccion', 'INNER');
		$this->db->join('DetalleActividadLineaAccion dal', 'dal.iIdLineaAccion = al.iIdLineaAccion AND dal.iIdDetalleActividad = ' . $iIdDetalleActividad, 'LEFT OUTER');
		$this->db->where('al.iIdActividad', $iIdActividad);
		$query = $this->db->get()->result();
		return $query;
	}

	public function obtener_informacion_actividad($id_detact)
	{

		$this->db->select();
		$this->db->from('DetalleActividad da');
		$this->db->join('Actividad a', 'da.iIdActividad = a.iIdActividad', 'JOIN');
		$this->db->join('Dependencia d', 'a.iIdDependencia = d.iIdDependencia', 'JOIN');
		$this->db->where('a.iActivo', 1);
		$this->db->where('iIdDetalleActividad', $id_detact);

		$query =  $this->db->get()->row();

		return $query;
	}

	public function obtener_alineacion_actividad($id_detact)
	{

		$this->db->select();
		$this->db->from('DetalleActividad da');
		$this->db->join('Actividad a', 'da.iIdActividad = a.iIdActividad', 'JOIN');
		$this->db->join('ActividadLineaAccion ala', 'da.iIdActividad=ala.iIdActividad', 'JOIN');
		$this->db->join('PED2019LineaAccion la', 'ala.iIdLineaAccion=la.iIdLineaAccion', 'JOIN');
		$this->db->join('PED2019Estrategia e', 'la.iIdEstrategia = e.iIdEstrategia', 'JOIN');
		$this->db->join('PED2019Objetivo o', 'e.iIdObjetivo = o.iIdObjetivo', 'JOIN');
		$this->db->join('PED2019Tema t', 'o.iIdTema = t.iIdTema', 'JOIN');
		$this->db->join('PED2019Eje ej', 't.iIdEje = ej.iIdEje', 'JOIN');

		$this->db->where('iIdDetalleActividad', $id_detact);

		$query =  $this->db->get()->result();

		return $query;
	}
	public function obtenerActividadAglomerada($idActividad)
	{
		$sql = 'SELECT "ActividadAglomerada"."iIdActividadHija", "Actividad"."vDescripcion" FROM "ActividadAglomerada" 
	INNER JOIN "Actividad" ON "Actividad"."iIdActividad" = "ActividadAglomerada"."iIdActividadHija"
	WHERE "ActividadAglomerada"."iIdActividadPadre" = ' . $idActividad;
		$query =  $this->db->query($sql);
		return $query->result();
	}
	public function borrarActividadAgromerada($idActidad)
	{
		$this->db->where('iIdActividadPadre', $idActidad);
		$this->db->delete('ActividadAglomerada');
		return true;
	}
	public function insertarAgromerada($datos)
	{
		$this->db->insert('ActividadAglomerada', $datos);
		return $this->db->insert_id();
	}
	public function obtener_alineacion_ods($id_detact)
	{

		$this->db->select('ped.iIdOds');
		$this->db->from('DetalleActividad da');
		$this->db->join('Actividad a', 'da.iIdActividad = a.iIdActividad', 'JOIN');
		$this->db->join('ActividadLineaAccion ala', 'da.iIdActividad=ala.iIdActividad', 'JOIN');
		$this->db->join('PED2019 ped', 'ped.iIdLineaAccion = ala.iIdLineaAccion', 'JOIN');
		$this->db->where('da.iIdDetalleActividad', $id_detact);
		$this->db->group_by('ped.iIdOds');
		$this->db->order_by('ped.iIdOds');

		$query =  $this->db->get()->result();

		return $query;
	}

	//Muestra la infromacion de la Actividad y el Entregable
	public function mostrar_actividadentregables($id_detact)
	{

		$this->db->select();
		$this->db->from('Entregable e');
		$this->db->join('DetalleEntregable de', 'e.iIdEntregable = de.iIdEntregable', 'JOIN');
		$this->db->where('e.iActivo', 1);
		$this->db->where('de.iActivo', 1);
		$this->db->where('de.iIdDetalleActividad', $id_detact);

		$query =  $this->db->get()->result();

		return $query;
	}

	//Calcula la suma de avances por cada entregable
	public function suma_avances_total($id_detent)
	{

		$this->db->select('sum("nAvance") as total_avance, sum("nEjercido") as monto_total,(sum("nBeneficiariosH") + sum("nBeneficiariosM") + sum("nDiscapacitadosH") + sum("nDiscapacitadosM") + sum("nLenguaH") + sum("nLenguaM")) as total_beneficiarios');
		$this->db->from('Avance');
		$this->db->where('iIdDetalleEntregable', $id_detent);
		$this->db->where('iActivo', 1);
		$this->db->where('iAprobado', 1);

		$query =  $this->db->get()->row();

		return $query;
	}

	//Calcula la suma del presupuesto
	public function suma_presupuesto_ejercido($id_detact)
	{

		$this->db->select('sum(a."nEjercido") as monto_total');
		$this->db->from('Avance a');
		$this->db->join('DetalleEntregable de', 'a.iIdDetalleEntregable = de.iIdDetalleEntregable', 'JOIN');
		$this->db->where('de.iIdDetalleActividad', $id_detact);
		$this->db->where('a.iActivo', 1);
		$this->db->where('a.iAprobado', 1);
		$this->db->where('de.iActivo', 1);

		$query =  $this->db->get()->row();

		return $query;
	}

	//Calcula la suma del presupuesto
	public function suma_presupuesto_modificado($id_detact)
	{

		$this->db->select('sum(daf."monto") as monto_total');
		$this->db->from('DetalleActividadFinanciamiento daf');
		$this->db->join('DetalleActividad da', 'da.iIdDetalleActividad = daf.iIdDetalleActividad', 'JOIN');
		$this->db->where('daf.iIdDetalleActividad', $id_detact);
		$this->db->where('da.iActivo', 1);

		$query =  $this->db->get()->row();

		return $query;
	}

	public function obtener_municipios_actividad($id_detact)
	{
		$this->db->distinct();
		$this->db->select("m.iIdMunicipio,m.vMunicipio");
		$this->db->from('DetalleEntregableMetaMunicipio demm');
		$this->db->join('DetalleEntregable de', 'demm.iIdDetalleEntregable = de.iIdDetalleEntregable', 'JOIN');
		$this->db->join('Municipio m', 'demm.iIdMunicipio = m.iIdMunicipio', 'JOIN');
		$this->db->where('de.iIdDetalleActividad', $id_detact);
		$this->db->where('de.iActivo', 1);

		$query =  $this->db->get()->result();

		return $query;
	}

	public function actividad($idAct)
	{
		$this->db->select('da.iIdDetalleActividad, da.iIdActividad, da.dInicio, da.dFin');
		$this->db->from('DetalleActividad da');
		$this->db->join('Actividad ac', 'ac.iIdActividad = da.iIdActividad', 'INNER');
		$this->db->where('da.iActivo', 1);
		$this->db->where('da.iIdDetalleActividad', $idAct);

		$query =  $this->db->get();

		return $query;
	}

	public function actividades_dep($iddep, $anio)
	{
		$this->db->select('da.iIdDetalleActividad, da.iIdActividad, da.dInicio, da.dFin');
		$this->db->from('DetalleActividad da');
		$this->db->join('Actividad ac', 'ac.iIdActividad = da.iIdActividad', 'INNER');
		$this->db->where('da.iActivo', 1);
		$this->db->where('da.iAnio', $anio);
		$this->db->where('ac.iIdDependencia', $iddep);

		$query =  $this->db->get();

		return $query;
	}

	public function entregables_det_act($iIdDetalleActividad)
	{
		$this->db->select('de.iIdEntregable, de.iPonderacion');
		$this->db->from('DetalleEntregable de');
		$this->db->where('de.iActivo', 1);
		$this->db->where('de.iIdDetalleActividad', $iIdDetalleActividad);

		$query =  $this->db->get()->result();

		return $query;
	}

	public function get_iIdActividad($iIdDetalleActividad)
	{
		$this->db->select('da.iIdActividad');
		$this->db->from('DetalleActividad da');
		$this->db->where('da.iIdDetalleActividad', $iIdDetalleActividad);

		return $this->db->get()->row()->iIdActividad;
	}

	public function get_nameActividad($iIdDetalleActividad)
	{
		$this->db->select('act.vActividad');
		$this->db->from('DetalleActividad da');
		$this->db->join('Actividad act', 'act.iIdActividad = da.iIdActividad', 'INNER');
		$this->db->where('da.iIdDetalleActividad', $iIdDetalleActividad);

		return $this->db->get()->row()->vActividad;
	}

	public function get_linea_accion($iIdLineaAccion)
	{
		$this->db->select('ped.*');
		$this->db->from('PED2019 ped');
		$this->db->where('ped.iIdLineaAccion', $iIdLineaAccion);

		return $this->db->get()->row();
	}

	public function ods_actividad($idAct)
	{
		$sql = 'SELECT ped."iIdOds" FROM "ActividadLineaAccion" al 
				INNER JOIN "PED2019" ped ON ped."iIdLineaAccion" = al."iIdLineaAccion"
				WHERE al."iIdActividad" = ' . $idAct . '
				GROUP BY ped."iIdOds"';

		return $this->db->query($sql);
	}

	//Muestra PATs por página
	public function search_pats($keyword = '', $where = array(), $inicial = null, $lim = null, $orden = null, $col = 0)
	{
		/*$this->db->select('act.iIdActividad, da.iIdDetalleActividad, da.nAvance, da.iAnio, act.vActividad, dep.vDependencia, dep.vNombreCorto AS siglas');
        $this->db->select('COUNT(av."iIdAvance") avances_pendientes',false);
        $this->db->from('Actividad act');
        $this->db->join('DetalleActividad da','da.iIdActividad = act.iIdActividad AND da.iActivo = 1','INNER');
        $this->db->join('Dependencia dep','dep.iIdDependencia = act.iIdDependencia','INNER');
        $this->db->join('DependenciaEje dej','dej.iIdDependencia = dep.iIdDependencia','INNER');

        $this->db->join('DetalleEntregable det','det.iIdDetalleActividad = da.iIdDetalleActividad AND det.iActivo = 1','LEFT OUTER');
        $this->db->join('Avance av','av.iIdDetalleEntregable = det.iIdDetalleEntregable AND av.iActivo = 1 AND av.iAprobado = 0','LEFT OUTER');

        
        $this->db->where('da.iActivo', 1);
        $this->db->group_by('act.iIdActividad, da.iIdDetalleActividad, da.nAvance, da.iAnio, act.vActividad, dep.vDependencia, dep.vNombreCorto'); */
		$this->db->from('vListadoPat');
		$this->db->limit($lim, $inicial);

		if (!empty($where)) {
			$this->db->where($where);
		};

		if (!empty($keyword) && $keyword != null) {
			$this->db->where("(\"vActividad\" ilike '%$keyword%')");
		}

		// Ordenamiento
		if (!empty($orden) && $orden != null) {
			switch ($col) {
				case 0:
					$this->db->order_by('nAvance ' . $orden);
					break;
				case 1:
					$this->db->order_by('vDependencia', $orden);
					break;
				case 2:
					$this->db->order_by('vActividad', $orden);
					break;
				case 3:
					$this->db->order_by('iAnio', $orden);
					break;
			}
		}

		$this->db->group_by('iIdEje, iIdDependencia, iIdActividad, iIdDetalleActividad, nAvance, iReactivarEconomia, iAnio, dInicio, vActividad, vDependencia, siglas, avances_pendientes');
		$query =  $this->db->get();

		//$_SESSION['query'] = $this->db->last_query();

		return $query;
	}

	public function total_pats($keyword = '', $where = array())
	{
		/*$this->db->select('COUNT(act."iIdActividad") total',false);
        $this->db->from('Actividad act');
        $this->db->join('DetalleActividad da','da.iIdActividad = act.iIdActividad AND da.iActivo = 1','INNER');
        $this->db->join('Dependencia dep','dep.iIdDependencia = act.iIdDependencia','INNER');
        $this->db->join('DependenciaEje dej','dej.iIdDependencia = dep.iIdDependencia','INNER');
        $this->db->where('da.iActivo', 1);*/

		$this->db->select('COUNT("iIdDetalleActividad") total', false);
		$this->db->from('vListadoPat');

		if (!empty($where)) $this->db->where($where);

		if (!empty($keyword) && $keyword != null) {
			$this->db->where("(\"vActividad\" ilike '%$keyword%')");
		}

		$query = $this->db->get();

		return ($query->num_rows() == 1) ? $query->row()->total : 0;
	}

	public function getDependenciaPorEje($ejeID = 0)
	{
		$sql = 'SELECT * FROM "Dependencia" d 
		INNER JOIN "DependenciaEje" de on de."iIdDependencia" = d."iIdDependencia" 
		WHERE de."iIdEje" = ' . $ejeID;

		return $this->db->query($sql)->result();
	}

	public function getReto($retoID)
	{
		$sql = 'SELECT "iIdReto", "iIdEje" FROM "EjeRetos" WHERE "iIdReto" =' . $retoID;

		return $this->db->query($sql)->result();
	}

	public function getRetosPorDependencia($dependenciaID)
	{
		$sql = 'SELECT * FROM "Reto" r WHERE "iIdDependencia" =' . $dependenciaID;
		return $this->db->query($sql)->result();
	}
	public function getRetosDependencia($dependenciaID = 0)
	{
		$sql = 'SELECT "Retos"."iIdReto", "Retos"."vDescripcion" FROM "DependenciaEje"
		LEFT JOIN "EjeRetos" ON "EjeRetos"."iIdEje" = "DependenciaEje"."iIdEje"
		LEFT JOIN "Retos" ON "Retos"."iIdReto" = "EjeRetos"."iIdReto"
		WHERE "DependenciaEje"."iIdDependencia" = ' . $dependenciaID;
		return $this->db->query($sql)->result();
	}

	/**
	 * Retorna los datos de una tabla en base a la consulta solicitada
	 * @param string $tabla
	 * @param string $where
	 * @return array
	 */
	public function getDataTable($tabla, $where = '')
	{
		$model = new M_catalogos();
		$select = '';

		$query = $model->{$tabla}($where);

		if ($query != false)
			return $query->result();
	}

	/**
	 * Retorna los datos de la dependencia en base a su id
	 * @param int $dependenciaID
	 * @return array
	 */
	public function getDependenciaById($dependenciaID = 0)
	{
		$sql = 'SELECT * FROM "Dependencia" d WHERE "iIdDependencia" =' . $dependenciaID;

		return $this->db->query($sql)->result();
	}

	function obtenerSeleccionados($id)
	{
		if ($id != '') {
			$sql = 'SELECT * FROM "DetalleActividad" detAct
            INNER JOIN "Actividad" act on act."iIdActividad" = detAct."iIdActividad" 
			INNER JOIN "Dependencia" d on d."iIdDependencia" = act."iIdDependencia" 
			INNER JOIN "DependenciaEje" de on de."iIdDependencia" = d."iIdDependencia"  
			WHERE detAct."iIdDetalleActividad" = ' . $id . '
			LIMIT 1';
		} else {
			$sql = 'SELECT * FROM "DetalleActividad" detAct
            INNER JOIN "Actividad" act on act."iIdActividad" = detAct."iIdActividad" 
			INNER JOIN "Dependencia" d on d."iIdDependencia" = act."iIdDependencia" 
			INNER JOIN "DependenciaEje" de on de."iIdDependencia" = d."iIdDependencia"';
		}
		return $this->db->query($sql)->result();
	}

	function getRetosPorDEP($dependenciaID)
	{
		$sql = 'SELECT "Retos"."iIdReto", "Retos"."vDescripcion" FROM "DependenciaEje"

        LEFT JOIN "EjeRetos" ON "EjeRetos"."iIdEje" = "DependenciaEje"."iIdEje"

        LEFT JOIN "Retos" ON "Retos"."iIdReto" = "EjeRetos"."iIdReto"

        WHERE "DependenciaEje"."iIdDependencia" = ' . $dependenciaID . '
		ORDER BY "Retos"."vDescripcion"';

		return $this->db->query($sql)->result();
	}

	function getRol($id)
	{
		$sql = 'SELECT * FROM "Usuario" WHERE "iIdUsuario" = ' . $id;

		return $this->db->query($sql)->result();
	}
}
