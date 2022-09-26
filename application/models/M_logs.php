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

	public function obtenerAntesAccion($id)
	{
		$sql = 'SELECT act."vActividad" as "Nombre Acción", act."vNombreActividad" as "Nombre", act."vObjetivo" as "Objetivo", act."vDescripcion" as "Descripción", ods."vOds" as "ODS", ar."vAreaResponsable" as "Área Responsable", act."vCargo" as "Cargo", act."vCorreo" as "Correo", act."vTelefono" as "Teléfono", act."vJustificaCambio" as "Justificación del cambio", act."vAccion" as "Acción", act."vEstrategia" as "Estrategia", rt."vDescripcion" as "Reto", eje."vEje" as "Eje", act.vtipoactividad as "Tipo Acción", act.vcattipoactividad as "Cat Tipo Acción", act."iIncluyeMIR" as "Incluye MIR", act."iAglomeraMIR" as "ID Aglomeración MIR",act."iIdActividadMIR" as "Id Acción MIR",mir."vNivelMIR" as "Nivel MIR", prps."vProgramaPresupuestario" as "Programa Presupuestario", rn."vNombreResumenNarrativo" as "Resumen Narrativo", act."vSupuesto" as "Supuesto", act."iIdProyectoPrioritario" as "Proyecto Prioritario", detAct."iAutorizado" as "Autorizado", d."vDependencia" as "Dependencia", act."iIdActividad" as "Identificador Acción", detAct."iAnio" as "Año", detAct."dInicio" as "Fecha Inicio", detAct."dFin" as "Fecha Fin", detAct."iReactivarEconomia" as "Reactivar Economica", detAct."nPresupuestoModificado" as "Presupuesto Modificado", detAct."nPresupuestoAutorizado" as "Presupuesto Autorizado", detAct."vClavePOA" as "Clave POA" FROM "DetalleActividad" detAct
		LEFT JOIN "Actividad" act on act."iIdActividad" = detAct."iIdActividad" 
		LEFT JOIN "Dependencia" d on d."iIdDependencia" = act."iIdDependencia" 
		LEFT JOIN "DependenciaEje" de on de."iIdDependencia" = d."iIdDependencia"
		LEFT JOIN "ODS" ods ON ods."iIdOds" = act."iODS"
		LEFT JOIN "Retos" rt ON rt."iIdReto" = act."iReto"
		LEFT JOIN "PED2019Eje" eje ON eje."iIdEje" = act."iideje"
		LEFT JOIN "ProgramaPresupuestario" prps ON prps."iIdProgramaPresupuestario" = act."iIdProgramaPresupuestario"
		LEFT JOIN "NivelMIR" mir ON mir."iIdNivelMIR" = act."iIdNivelMIR"
		LEFT JOIN "ResumenNarrativo" rn ON rn."iIdResumenNarrativo" = CAST (act."vResumenNarrativo" AS INTEGER)
		LEFT JOIN "AreaResponsable" ar ON ar."iIdAreaResponsable" = CAST(act."vResponsable" as INTEGER)
		WHERE act."iIdActividad" = '.$id.'
		LIMIT 1';

		return $this->db->query($sql)->result();
	}

	public function obtenerAntesIndicador($id_entregable){
        $sql = 'SELECT e."vEntregable" as "Indicador", pr."vPeriodicidad" as "Periodicidad", e."vNombreEntregable" as "Nombre Indicador", fi."vDescripcion" as "Forma Indicador", di."vDescripcion" as "Dimensión Indicador", e."nLineaBase" as "Linea Base", e."vMedioVerifica" as "Medio Verificación", e."vFormula" as "Formula", e."iAcumulativo" as "Acomulativo", de."iAutorizado" as "Autorizado", e."iIdSujetoAfectado" as "ID Sujeto Afectado", um."vUnidadMedida" as "Unidad Medida", e."iMunicipalizacion" as "Municipalización", e."iMismosBeneficiarios" as "Mismo Beneficiario", de."nMeta" as "Meta", de."nMetaModificada" as "Meta Modificada", de."dFechaInicio" as "Fecha Inicio", de."dFechaFin" as "Fecha Fin", de."iAnexo" as "Anexo" FROM "Entregable" as e
        LEFT JOIN "DetalleEntregable" as de ON e."iIdEntregable" = de."iIdEntregable"
        LEFT JOIN "UnidadMedida" as um ON e."iIdUnidadMedida" = um."iIdUnidadMedida"
		LEFT JOIN "Periodicidad" as pr ON  pr."iIdPeriodicidad" = e."iIdPeriodicidad"
		LEFT JOIN "FormaIndicador" as fi ON fi."iIdFormaInd" = e."iIdFormaInd"
		LEFT JOIN "DimensionIndicador" as di ON di."iIdDimensionInd" = e."iIdDimensionInd"
        WHERE e."iIdEntregable" ='.$id_entregable;
        return $this->db->query($sql)->result();

    }

	public function obtenerDependencia($idDep){
		$sql = 'SELECT "vDependencia" FROM "Dependencia" WHERE "iIdDependencia" = ' .$idDep;
		return $this->db->query($sql)->result();
	}

	public function obtenerProyPri($idProyPri){
		$sql = 'SELECT "vProyectoPrioritario" FROM "ProyectosPrioritarios" WHERE "iIdProyectoPrioritario" = '. $idProyPri;
		return $this->db->query($sql)->result();
	}

	public function obtenerResumenNarrativo($idRN){
		$sql = 'SELECT "vNombreResumenNarrativo" FROM "ResumenNarrativo" WHERE "iIdResumenNarrativo" = '.$idRN;
		return $this->db->query($sql)->result();
	}

	public function obtenerProgramaPresu($idProgPres){
		$sql = 'SELECT "vProgramaPresupuestario" FROM "ProgramaPresupuestario" WHERE "iIdProgramaPresupuestario" = '.$idProgPres;
		return $this->db->query($sql)->result();
	}

	public function obtenerMIR($idMir){
		$sql = 'SELECT "vNivelMIR" FROM "NivelMIR" WHERE "iIdNivelMIR" = '. $idMir;
		return $this->db->query($sql)->result();
	}

	public function obtenerEje($idEje){
		$sql = 'SELECT "vEje" FROM "PED2019Eje" WHERE "iIdEje" = '. $idEje;
		return $this->db->query($sql)->result();
	}

	public function obtenerReto($idReto){
		$sql = 'SELECT "vDescripcion" FROM "Retos" WHERE "iIdReto" = '. $idReto;
		return $this->db->query($sql)->result();
	}

	public function obtenerAreaResp($idArea){
		$sql = 'SELECT "vAreaResponsable" FROM "AreaResponsable" WHERE "iIdAreaResponsable" = '.$idArea;
		return $this->db->query($sql)->result();
	}

	public function obternerODS($idOds){
		$sql = 'SELECT "vOds" FROM "ODS" WHERE "iIdOds" = '. $idOds;
		return $this->db->query($sql)->result();
	}

	public function obtenerFormaInd($idForma){
		$sql = 'SELECT "vDescripcion" FROM "FormaIndicador" WHERE "iIdFormaInd" = '.$idForma;
		return $this->db->query($sql)->result();
	}

	public function obtenerDimenInd($idDimen){
		$sql = 'SELECT "vDescripcion" FROM "DimensionIndicador" WHERE "iIdDimensionInd" = '.$idDimen;
		return $this->db->query($sql)->result();
	}

	public function obtenerUnidadMedida($idUnidadMedida){
		$sql = 'SELECT "vUnidadMedida" FROM "UnidadMedida" WHERE "iIdUnidadMedida" ='.$idUnidadMedida;
		return $this->db->query($sql)->result();
	}

	public function obtenerPeriodicidad($idPeriodi){
		$sql = 'SELECT "vPeriodicidad" FROM "Periodicidad" WHERE "iIdPeriodicidad" = '.$idPeriodi;
		return $this->db->query($sql)->result();
	}

}
?>