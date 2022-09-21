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
		$sql = 'SELECT act."vActividad" as "Nombre Acción", act."vNombreActividad" as "Nombre", act."vObjetivo" as "Objetivo", act."vDescripcion" as "Descripción", act."iODS" as "ODS", act."vResponsable" as "Responsable", act."vCargo" as "Cargo", act."vCorreo" as "Correo", act."vTelefono" as "Teléfono", act."vJustificaCambio" as "Justificación del cambio", act."vAccion" as "Acción", act."vEstrategia" as "Estrategia", act."iReto" as "Reto", act.iideje as "ID Eje", act.vtipoactividad as "Tipo Acción", act.vcattipoactividad as "Cat Tipo Acción", act."iIncluyeMIR" as "Incluye MIR", act."iAglomeraMIR" as "ID Aglomeración MIR",act."iIdActividadMIR" as "Id Acción MIR","iIdNivelMIR" as "ID Nivel MIR", act."iIdProgramaPresupuestario" as "ID Programa Presupuestario", act."vResumenNarrativo" as "Resumen Narrativo", act."vSupuesto" as "Supuesto", act."iIdProyectoPrioritario" as "Proyecto Prioritario", detAct."iAutorizado" as "Autorizado", d."vDependencia" as "Dependencia", act."iIdActividad" as "Identificador Accián", detAct."iAnio" as "Año", detAct."dInicio" as "Fecha Inicio", detAct."dFin" as "Fecha Fin", detAct."iReactivarEconomia" as "Reactivar Economica", detAct."nPresupuestoModificado" as "Presupuesto Modificado", detAct."nPresupuestoAutorizado" as "Presupuesto Autorizado", detAct."vClavePOA" as "Clave POA" FROM "DetalleActividad" detAct
		INNER JOIN "Actividad" act on act."iIdActividad" = detAct."iIdActividad" 
		INNER JOIN "Dependencia" d on d."iIdDependencia" = act."iIdDependencia" 
		INNER JOIN "DependenciaEje" de on de."iIdDependencia" = d."iIdDependencia"  
		WHERE act."iIdActividad" = '.$id.'
		LIMIT 1';

		return $this->db->query($sql)->result();
	}

	public function obtenerAntesIndicador($id_entregable){
        $sql = 'SELECT e."vEntregable" as "Indicador", e."iIdPeriodicidad" as "ID Periodicidad", e."vNombreEntregable" as "Nombre Indicador", e."iIdFormaInd" as "ID Forma Indicador", e."iIdDimensionInd" as "ID Dimensión Indicador", e."nLineaBase" as "Linea Base", e."vMedioVerifica" as "Medio Verificación", e."vFormula" as "Formula", e."iAcumulativo" as "Acomulativo", de."iAutorizado" as "Autorizado", e."iIdSujetoAfectado" as "ID Sujeto Afectado", e."iIdUnidadMedida" as "ID Unidad Medida", e."iMunicipalizacion" as "Municipalización", e."iMismosBeneficiarios" as "Mismo Beneficiario", de."nMeta" as "Meta", de."nMetaModificada" as "Meta Modificada", de."dFechaInicio" as "Fecha Inicio", de."dFechaFin" as "Fecha Fin", de."iAnexo" as "Anexo" FROM "Entregable" as e
        INNER JOIN "DetalleEntregable" as de ON e."iIdEntregable" = de."iIdEntregable"
        INNER JOIN "UnidadMedida" as um ON e."iIdUnidadMedida" = um."iIdUnidadMedida"
        WHERE e."iIdEntregable" = '.$id_entregable;
        return $this->db->query($sql)->result();

    }

}
?>