<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class M_reporteClinicas extends CI_Model {

    function __construct(){
    parent::__construct();
        $this->db = $this->load->database('default',TRUE);
    }
    
    public function ejes(){
        $this->db->select('"iIdEje", "vEje"');
        $this->db->from('"PED2019Eje"');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
        $datos[] = [
           'iIdEje'                       => $row->iIdEje,
           'vEje'                   => $row->vEje
         ];
     }
     return $datos;
    }
    
    public function anio(){
        $this->db->distinct();
        $this->db->select('"iAnio"');
        $this->db->from('"DetalleActividad"');

        $query = $this->db->get();

        foreach ($query->result() as $row) {
        $datos[] = [
           'iAnio'                       => $row->iAnio
         ];
     }
     return $datos;
    }

    public function generar($eje,$dep,$anio){
        $datos = '';
        $datos = array();
        $this->db->select();
        $this->db->from('reporte_actividades');
        $this->db->where('iIdEje', $eje);
        $this->db->where('iIdDependencia', $dep);
        $this->db->where('iAnio', $anio);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $datos[] = [
                   'iIdActividad'             => $row->iIdActividad,
                   'iActivo'                       => $row->iActivo,
                   'vActividad'                 => $row->vActividad,
                   'vResumenNarrativo'            =>$row->vResumenNarrativo,
                   'vSupuesto'                    =>$row->vSupuesto,
                   'iIdNivelMIR'                  =>$row->iIdNivelMIR,
                   'vNivelMIR'                    =>$row->vNivelMIR,
                   'vAreaResponsable'              =>$row->vAreaResponsable,
                   'vMedioVerifica'               =>$row->vMedioVerifica,
                   'vProgramaPresupuestario'      =>$row->vProgramaPresupuestario,
                   'vEntregable'               =>$row->vEntregable,
                   'objetivoactividad'   => $row->objetivoactividad,
                   'vPoblacionObjetivo' => $row->vPoblacionObjetivo,
                   'vDescripcion'             => $row->vDescripcion,
                   'dInicio'                       => $row->dInicio,
                   'dFin'                             => $row->dFin,
                   'vDependencia'             => $row->vDependencia,
                   'claveff'                       => $row->claveff,
                   'vFinanciamiento'       => $row->vFinanciamiento,
                   'monto'                           => $row->monto,
                   'vLineaAccion'             => $row->vLineaAccion,
                   'vEstrategia'               => $row->vEstrategia,
                   'valorobjetivo'           => $row->valorobjetivo,
                   'vTema'                           => $row->vTema,
                   'vEje'                             => $row->vEje,
                   'claveubp'                     => $row->claveubp,
                   'vUBP'                             => $row->vUBP,
                   'iIdEntregable'           => $row->iIdEntregable,
                   'vEntregable'               => $row->vEntregable,
                   'nMeta'                           => $row->nMeta,
                   'vUnidadMedida'           => $row->vUnidadMedida,
                   'vSujetoAfectado'       => $row->vSujetoAfectado,
                   'vPeriodicidad'           => $row->vPeriodicidad,
                   'iMunicipalizacion'   => $row->iMunicipalizacion,
                   'nAvance'                       => $row->nAvance,
                   'nEjercido'                   => $row->nEjercido,
                   'iIdAvance'                    =>$row->iIdAvance,
                   
                 ];
             }
        }else{
            return 'no hay datos';
        }
     return $datos;
    }

    public function generar2($anio){
        $datos = '';
        $datos = array();
        $this->db->select();
        $this->db->from('"reporte_actividades"');
        $this->db->where('"iAnio" = '.$anio. '');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $datos[] = [
                   'iIdActividad'             => $row->iIdActividad,
                   'iActivo'                       => $row->iActivo,
                   'vActividad'                 => $row->vActividad,
                   'objetivoactividad'   => $row->objetivoactividad,
                   'vPoblacionObjetivo' => $row->vPoblacionObjetivo,
                   'vDescripcion'             => $row->vDescripcion,
                   'dInicio'                       => $row->dInicio,
                   'dFin'                             => $row->dFin,
                   'vDependencia'             => $row->vDependencia,
                   'claveff'                       => $row->claveff,
                   'vFinanciamiento'       => $row->vFinanciamiento,
                   'monto'                           => $row->monto,
                   'vLineaAccion'             => $row->vLineaAccion,
                   'vEstrategia'               => $row->vEstrategia,
                   'valorobjetivo'           => $row->valorobjetivo,
                   'vTema'                           => $row->vTema,
                   'vEje'                             => $row->vEje,
                   'claveubp'                     => $row->claveubp,
                   'vUBP'                             => $row->vUBP,
                   'iIdEntregable'           => $row->iIdEntregable,
                   'vEntregable'               => $row->vEntregable,
                   'nMeta'                           => $row->nMeta,
                   'vUnidadMedida'           => $row->vUnidadMedida,
                   'vSujetoAfectado'       => $row->vSujetoAfectado,
                   'vPeriodicidad'           => $row->vPeriodicidad,
                   'iMunicipalizacion'   => $row->iMunicipalizacion,
                   'nAvance'                       => $row->nAvance,
                   'nEjercido'                   => $row->nEjercido,
                   'iIdAvance'                    =>$row->iIdAvance,
                   'vResumenNarrativo'                    =>$row->vResumenNarrativo,
                   'vSupuesto'                    =>$row->vSupuesto,
                 ];
             }
        }else{
            return 'no hay datos';
        }
        return $datos;
    }
    function obtenerPP(){
      $this->db->select();
      $this->db->from('ProgramaPresupuestario');
      $query = $this->db->get()->result();
      return $query;
    }
    function obtenerPPporId($id){
      $this->db->select();
      $this->db->from('ProgramaPresupuestario');
      $this->db->where('iIdProgramaPresupuestario', $id);
      $query = $this->db->get()->row();
      return $query;
    }
    public function generar3($eje,$anio){

        $datos = '';
        $datos = array();
        $this->db->select();
        $this->db->from('reporte_actividades');
        $this->db->where('iIdEje', $eje);
        $this->db->where('iAnio', $anio);
        $this->db->where('iActivo',1);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $datos[] = [
                   'iIdActividad'             => $row->iIdActividad,
                   'iActivo'                       => $row->iActivo,
                   'vActividad'                 => $row->vActividad,
                   'objetivoactividad'   => $row->objetivoactividad,
                   'vPoblacionObjetivo' => $row->vPoblacionObjetivo,
                   'vDescripcion'             => $row->vDescripcion,
                   'dInicio'                       => $row->dInicio,
                   'dFin'                             => $row->dFin,
                   'vDependencia'             => $row->vDependencia,
                   'claveff'                       => $row->claveff,
                   'vFinanciamiento'       => $row->vFinanciamiento,
                   'monto'                           => $row->monto,
                   'vLineaAccion'             => $row->vLineaAccion,
                   'vEstrategia'               => $row->vEstrategia,
                   'valorobjetivo'           => $row->valorobjetivo,
                   'vTema'                           => $row->vTema,
                   'vEje'                             => $row->vEje,
                   'claveubp'                     => $row->claveubp,
                   'vUBP'                             => $row->vUBP,
                   'iIdEntregable'           => $row->iIdEntregable,
                   'vEntregable'               => $row->vEntregable,
                   'nMeta'                           => $row->nMeta,
                   'vUnidadMedida'           => $row->vUnidadMedida,
                   'vSujetoAfectado'       => $row->vSujetoAfectado,
                   'vPeriodicidad'           => $row->vPeriodicidad,
                   'iMunicipalizacion'   => $row->iMunicipalizacion,
                   'nAvance'                       => $row->nAvance,
                   'nEjercido'                   => $row->nEjercido,
                   'iIdAvance'                    =>$row->iIdAvance,
                   'vResumenNarrativo'                    =>$row->vResumenNarrativo,
                   'vSupuesto'                    =>$row->vSupuesto,
                 ];
             }
        }else{
            echo 'no hay datos';
        }
        
     return $datos;
    }

    public function recolectarsuma1($id){
        $this->db->select('COALESCE(sum("monto"),0) as "monto"');
        $this->db->from('"DetalleActividadFinanciamiento"');
        $this->db->join('"DetalleActividad"', '"DetalleActividad"."iIdDetalleActividad" = "DetalleActividadFinanciamiento"."iIdDetalleActividad"');
        $this->db->where('"DetalleActividad"."iIdActividad"', $id);

        return $this->db->get()->row()->monto;
    }

    public function recolectarsuma2($id){
        $this->db->select('COALESCE(sum("nBeneficiariosH"+"nBeneficiariosM"+"nDiscapacitadosH"+"nDiscapacitadosM"+"nLenguaH"+"nLenguaM"),0) as "sum2"');
        $this->db->from('"Avance"');
        $this->db->where('"iIdAvance"', $id);
        return $this->db->get()->row()->sum2;
    }

    /******************** Funciones Barbosa ************************/
   public function carga_actividades($eje = 0, $dep= 0, $anio= '')
   {
      $this->db->select('act.iIdActividad');
      $this->db->from('Actividad act');
      $this->db->join('DetalleActividad dact','act.iIdActividad = dact.iIdActividad','INNER');
      $this->db->join('DependenciaEje dep','act.iIdDependencia = dep.iIdDependencia','INNER');
      
      if($eje > 0) $this->db->where('dep.iIdEje', $eje);
      if($dep > 0) $this->db->where('act.iIdDependencia', $dep);
      if($anio != '') $this->db->where('dact.iAnio', $anio);

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }

   public function dependencias($ejeid)
   {
      $this->db->select('d.iIdDependencia, d.vDependencia');
      $this->db->from('Dependencia d');
      $this->db->join('DependenciaEje de','d.iIdDependencia = de.iIdDependencia','INNER');
      $this->db->where('de.iIdEje', $ejeid);

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }

   /******************** Funciones Jorge E ************************/

    public function listado_actividades($where='')
    {
      $this->db->select('da.iIdDetalleActividad');
      $this->db->from('DetalleActividad da');
      $this->db->join('Actividad ac','ac.iIdActividad = da.iIdActividad','INNER');
      $this->db->join('Dependencia dep','dep.iIdDependencia = ac.iIdDependencia','INNER');
      $this->db->join('DependenciaEje dej','dej.iIdDependencia = dep.iIdDependencia','INNER');
      $this->db->where('da.iActivo = 1 AND ac.iActivo = 1');
      $this->db->order_by('dej.iIdEje, dep.vDependencia');
      if($where != '') $this->db->where($where);

      $result = $this->db->get()->result();
      $_SESSION['sql'] = $this->db->last_query(); 
      return $result;
    }

    public function getEjeDep($iIdDetalleActividad)
    {
      $this->db->select('dej.iIdEje, dep.vNombreCorto');
      $this->db->from('DetalleActividad da');
      $this->db->join('Actividad ac','ac.iIdActividad = da.iIdActividad','INNER');
      $this->db->join('Dependencia dep','dep.iIdDependencia = ac.iIdDependencia','INNER');
      $this->db->join('DependenciaEje dej','dej.iIdDependencia = dep.iIdDependencia','INNER');
      $this->db->where('da.iIdDetalleActividad',$iIdDetalleActividad);

      return $this->db->get()->row();
      
    }

    public function reporte_actividades($anio,$eje,$dep=0)
    {
        $sql = 'SELECT "iIdEje" FROM actividades_eje';

        return $this->db->query($sql);
    }
    public function obtenerDatosPorActividad($idActividad){
      $coma = "','";
      $sql = 'select "vActividad",
      "vNivelMIR",
      "vProgramaPresupuestario",
      "vDescripcion",
      "vNombreResumenNarrativo",
      "vEntregable",
      "iValor",
      "nLineaBase",
      "nMeta",
      "vPeriodicidad",
      array_to_string(array_agg(DISTINCT "vNombreVariable"), '.$coma.') AS vNombreVariable,
      (sum("nAvance") / avg("nMeta")) * 100 as PorcentajeAvance,
      "vMedioVerifica",
      "vSupuesto"
      from vistaMir4
      where "iIdActividad" = '.$idActividad.'
      group by "vActividad","vNivelMIR","vProgramaPresupuestario", "nMeta", "vDescripcion","vNombreResumenNarrativo", "vActividad", "vEntregable", "iValor", "nLineaBase","vPeriodicidad", "vMedioVerifica", "vSupuesto"';

      $query =  $this->db->query($sql)->result();
      return $query;
    }

    public function obteneridActividades($idEje, $idDep){
      $sql = 'SELECT "Actividad"."iIdActividad", "DetalleActividad"."iAnio", "iIdDependencia", iideje
      FROM public."Actividad"
      INNER JOIN "DetalleActividad" ON "Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"
      WHERE "iideje" = '.$idEje.' AND "iIdDependencia" = '.$idDep;
      $query =  $this->db->query($sql);
      return $query;
    }

    public function reporte_pat($anio, $dep, $whereString=null)
    {
      $select ='SELECT DISTINCT "Actividad"."iIdActividad",
      "Actividad"."vActividad",
      "Actividad"."vNombreActividad",
      "ProgramaPresupuestario"."vProgramaPresupuestario",
      "ProgramaPresupuestario"."vDescripcion",
      "Actividad"."vResumenNarrativo",
      "Entregable"."vEntregable",
      "Entregable"."iIdEntregable",
      "VariableIndicador"."vVariableIndicador",
      "VariableIndicador"."vNombreVariable",
      "VariablesAvance"."iVariable",
      "VariablesAvance"."iValor",
      "DetalleEntregable"."nMeta",
      "Entregable"."nLineaBase",
      "Periodicidad"."vPeriodicidad",
      "Avance"."nAvance",
      "Avance"."dFecha",
      "Actividad"."vSupuesto",
      "NivelMIR"."vNivelMIR",
      "ResumenNarrativo"."vNombreResumenNarrativo",
      "Entregable"."vMedioVerifica"';
      // $select = 'SELECT distinct eje."vEje" AS ejedependencia, dep."vDependencia", act."iIdActividad",act."iIdNivelMIR", dat."iIdDetalleActividad", act."vActividad", act."vDescripcion", act."vObjetivo" AS objetivoact, act."vPoblacionObjetivo", dat."iAnio", act."vResumenNarrativo", act."vSupuesto" ,dat."dInicio", dat."dFin", dat."nAvance", area."vAreaResponsable",mir."vNivelMIR", dat."iReactivarEconomia", dat."nPresupuestoModificado",program."vProgramaPresupuestario", entr."vEntregable", entr."vMedioVerifica",dat."nPresupuestoAutorizado" as pauth, "Reto"."vDescripcion" as vreto, act."vEstrategia" as estrategiaact, coalesce(ava."ejercido", 0) as ejercido,

      $from = 'FROM "Actividad"
      JOIN "ProgramaPresupuestario" ON "Actividad"."iIdProgramaPresupuestario" = "ProgramaPresupuestario"."iIdProgramaPresupuestario"
      LEFT JOIN "DetalleActividad" ON "Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"
      LEFT JOIN "DetalleEntregable" ON "DetalleActividad"."iIdDetalleActividad" = "DetalleEntregable"."iIdDetalleActividad"
      left JOIN "ResumenNarrativo" ON "Actividad"."vResumenNarrativo" = cast("ResumenNarrativo"."iIdResumenNarrativo" as varchar)
      LEFT JOIN "Entregable" ON "DetalleEntregable"."iIdEntregable" = "Entregable"."iIdEntregable"
      LEFT JOIN "VariableIndicador" ON "Entregable"."iIdEntregable" = "VariableIndicador"."iIdEntregable"
      LEFT JOIN "Avance" ON "DetalleEntregable"."iIdDetalleEntregable" = "Avance"."iIdDetalleEntregable"
      LEFT JOIN "VariablesAvance" ON "Avance"."iIdAvance" = "VariablesAvance"."iIdAvance"
      LEFT JOIN "Periodicidad" ON "Entregable"."iIdPeriodicidad" = "Periodicidad"."iIdPeriodicidad"
      LEFT JOIN "NivelMIR" ON "Actividad"."iIdNivelMIR" = "NivelMIR"."iIdNivelMIR"';     
    //   $whereCondition = 'WHERE'. ' "DetalleActividad"."iAnio" = '.$anio;

      if(!empty($whereString)){
        $whereCondition = $whereCondition.' '. $whereString;
      }
      
      $group_by = '';
      
      $sql = $select.$from.$whereCondition.$group_by;
      $query =  $this->db->query($sql);
      //$_SESSION['sql'] = $this->db->last_query();
      return $query;
    }

    function catalogos($tipo)
    {
        $sql = '';
        if($tipo == 1)
        {
          $sql = 'SELECT * FROM "Financiamiento" WHERE "iActivo" = 1'; 
        }

        if($tipo == 2)
        {
          $sql = 'SELECT * FROM "PED2019"'; 
        }

        if($tipo == 3)
        {
          $sql = 'SELECT * FROM "ProgramaPresupuestario" WHERE "iActivo" = 1'; 
        }

        if($tipo == 4)
        {
          $sql = 'SELECT * FROM "SujetoAfectado" WHERE "iActivo" = 1'; 
        }

        if($tipo == 5)
        {
          $sql = 'SELECT u.*, tu."vTipoUbp" 
              FROM "UBP" u
              INNER JOIN "TipoUBP" tu ON tu."iIdTipoUbp" = u."iIdTipoUbp"
              WHERE u."iActivo" = 1;'; 
        }

        if($tipo == 6)
        {
          $sql = 'SELECT * FROM "UnidadMedida" WHERE "iActivo" = 1 ORDER BY "iIdUnidadMedida"'; 
        }
        return $this->db->query($sql);
    }

    public function obtenerDep($dep){
      $this->db->select('vDependencia');
      $this->db->from('Dependencia');
      $this->db->where('iIdDependencia', $dep);
      $query =  $this->db->get();
		  $resultado = $query->row();
      return $resultado;
    }

    public function obtenerEje($eje){
      $this->db->select('vEje');
      $this->db->from('PED2019Eje');
      $this->db->where('iIdEje', $eje);
      $query =  $this->db->get();
		  $resultado = $query->row();
      return $resultado;
    }
    
    public function porcentaje($idEntregable){
      $sql = 'SELECT
      "Entregable"."iIdEntregable",
      "Entregable"."vEntregable",
      "DetalleEntregable"."iIdDetalleEntregable",
      avg("DetalleEntregable"."nMeta") as Meta,
      sum("Avance"."nAvance") as SumaAvances,
      sum("Avance"."nAvance") / avg("DetalleEntregable"."nMeta") * 100 as PorcentajeAvance
      FROM
      "DetalleEntregable"
      INNER JOIN
      "Entregable"
      ON
      "DetalleEntregable"."iIdEntregable" = "Entregable"."iIdEntregable"
      INNER JOIN
      "Avance"
      ON
      "DetalleEntregable"."iIdDetalleEntregable" = "Avance"."iIdDetalleEntregable"
      where "Entregable"."iIdEntregable"='.$idEntregable.'
      group by "Entregable"."iIdEntregable", "Entregable"."vEntregable", "DetalleEntregable"."iIdDetalleEntregable"
      order by "iIdEntregable", "iIdDetalleEntregable"';

      $query =  $this->db->query($sql)->result();
      return $query;
    }

    public function obtenerVista($eje, $dep){
      $coma = "','";

      /*$select = 'select "iIdActividad", "vActividad",
      "vNivelMIR",
      "vProgramaPresupuestario",
      "vDescripcion",
      "vNombreResumenNarrativo",
      "vEntregable",
      "iValor",
      "nLineaBase",
      "nMeta",
      "vPeriodicidad",
      array_to_string(array_agg(DISTINCT "vNombreVariable"), '.$coma.') AS vNombreVariable,
      (sum("nAvance") / avg("nMeta")) * 100 as PorcentajeAvance,
      "vMedioVerifica",
      "vSupuesto"
      from vistaMir4';

      $where = 'where "iIdEje" = '.$eje;

      if($dep != '' || $dep != null || $dep != 0){
        $where = $where.' AND "iIdDependencia" = '.$dep;
      }

      $group = 'group by "vActividad","vNivelMIR","vProgramaPresupuestario", "nMeta", "vDescripcion","vNombreResumenNarrativo", "vActividad", "vEntregable", "iValor", "nLineaBase","vPeriodicidad", "vMedioVerifica", "vSupuesto", "iIdActividad"';

      $sql = $select.$where.$group;*/
      $coma = "','";
      $barra = "' | '";
      $select = 'select "iIdActividad", "vActividad",
      "vNivelMIR",
      "vProgramaPresupuestario",
      "vDescripcion",
      "vNombreResumenNarrativo",
			STRING_AGG ("vEntregable",' .$barra. ') as indicador,
			max("iValor") as ivalor,
			max("nLineaBase") as nlineabase,  
      max("nMeta") as meta,
			STRING_AGG ("vPeriodicidad",' .$barra. ') as periodicidad,
      array_to_string(array_agg(DISTINCT "vNombreVariable"), '.$coma. ') AS vNombreVariable,
      sum("nAvance") / sum("nMeta") * 100 as PorcentajeAvance,
			STRING_AGG ("vMedioVerifica",' .$barra. ') as medioverifica,
      STRING_AGG ("vSupuesto",' .$barra. ') as supuesto
      from vistaMir4
      ';

      $where = 'where "iIdEje" = '.$eje;

      if($dep != 0){
        $where = $where.' AND "iIdDependencia" = '.$dep;
      }

      $group = 'group by "vActividad","vNivelMIR","vProgramaPresupuestario", "vDescripcion","vNombreResumenNarrativo", "vActividad","iIdActividad"';

      $sql = $select.$where.$group;

      $query =  $this->db->query($sql);
      return $query;
    }

    public function obtenerDatosHija($idAct){
      $coma = "','";
      if($idAct != ''){
        $sql = 'select "iIdActividad", "vActividad",
        "vNivelMIR",
        "vProgramaPresupuestario",
        "vDescripcion",
        "vNombreResumenNarrativo",
        "vEntregable",
        "iValor",
        "nLineaBase",
        "nMeta",
        "vPeriodicidad",
        array_to_string(array_agg(DISTINCT "vNombreVariable"), '.$coma.') AS vNombreVariable,
        (sum("nAvance") / avg("nMeta")) * 100 as PorcentajeAvance,
        "vMedioVerifica",
        "vSupuesto"
        from vistaMir4
        WHERE vistamir4."iIdActividad" = '.$idAct.'
        group by "vActividad","vNivelMIR","vProgramaPresupuestario", "nMeta", "vDescripcion","vNombreResumenNarrativo", "vActividad", "vEntregable", "iValor", "nLineaBase","vPeriodicidad", "vMedioVerifica", "vSupuesto", "iIdActividad"';
        $query =  $this->db->query($sql)->result();
        return $query;
      }
      
    }

  function obtenerIdHija($idact)
  {
    $sql = 'SELECT "ActividadAglomerada"."iIdActividadHija" FROM "ActividadAglomerada" WHERE "ActividadAglomerada"."iIdActividadPadre" =' . $idact;

    $query =  $this->db->query($sql)->result();
    return $query;
  }

}

                        
/* End of file M_reporteMir.php */
    
                        