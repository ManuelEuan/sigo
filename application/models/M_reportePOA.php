<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class M_reportePOA extends CI_Model {

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

    /*public function dependencias($id){
        $this->db->select('"Dependencia"."iIdDependencia","vDependencia"');
        $this->db->from('"Dependencia"');
        $this->db->join('"DependenciaEje"', '"Dependencia"."iIdDependencia" = "DependenciaEje"."iIdDependencia"');
        $this->db->where('"DependenciaEje"."iIdEje"', $id);
        
        $query = $this->db->get();

        $select= '<option value="0">Seleccione...</option>';
        foreach ($query->result() as $row)
        {
            $select .= '<option value="'.$row->iIdDependencia.'">'.$row->vDependencia.'</option>';
        }
        return $select;
    }*/


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
                 ];
             }
        }else{
            return 'no hay datos';
        }
        return $datos;
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
      /*$sql = 'SELECT ped."vEje", ped."vTema", ped."vObjetivo", ped."vEstrategia", ped."vLineaAccion", ped."iIdOds", ped."vOds",  eje."vEje" AS ejedependencia, dep."vDependencia", act."iIdActividad", dat."iIdDetalleActividad", act."vActividad", act."vDescripcion", act."vObjetivo" AS objetivoact, act."vPoblacionObjetivo", dat."dInicio", dat."dFin", fin."vFinanciamiento", daf.monto, pre.presupuesto, dat."nAvance", dat."iReactivarEconomia", dat."nPresupuestoModificado", dat."nPresupuestoAutorizado",
        pp."vProgramaPresupuestario", ubp."vClave", ubp."vUBP",
        ent."iIdEntregable", det."iIdDetalleEntregable", ent."vEntregable", det."iPonderacion", det."nMeta", det."iSuspension", u."vUnidadMedida",
        s."vSujetoAfectado", pe."vPeriodicidad", ent."iMunicipalizacion", ent."iMismosBeneficiarios", av.avance, av.ejercido, av.beneficiariosh, av.beneficiariosm, 
        av.discapacitadosh, av.discapacitadosm, av.lenguah, av.lenguam, 
        ben.beneficiariosh beneh, ben.beneficiariosm benem, 
        ben.discapacitadosh disch, ben.discapacitadosm discm, ben.lenguah lengh, ben.lenguam lengm,
        mun."vMunicipio", dem."nMeta" metamunicipio,
        c."iNumero", c."vCompromiso", comp."vComponente"
        FROM "Actividad" act
        INNER JOIN "DetalleActividad" dat ON dat."iIdActividad" = act."iIdActividad" AND dat."iAnio" = '.$anio.'
        INNER JOIN "Dependencia" dep ON dep."iIdDependencia" = act."iIdDependencia"';*/
        /*$sql = 'SELECT COUNT(act."iIdActividad") num FROM 
        FROM "Actividad" act
        INNER JOIN "DetalleActividad" dat ON dat."iIdActividad" = act."iIdActividad" AND dat."iAnio" = '.$anio.'
        INNER JOIN "Dependencia" dep ON dep."iIdDependencia" = act."iIdDependencia"';

        if($dep > 0) $sql.= ' AND dep."iIdDependencia" = '.$dep;

        $sql .= ' INNER JOIN "DependenciaEje" dej ON dej."iIdDependencia" = dep."iIdDependencia"
        INNER JOIN "PED2019Eje" eje ON eje."iIdEje" = dej."iIdEje" AND dej."iIdEje" = '.$eje.'
        LEFT OUTER JOIN "ActividadLineaAccion" al ON al."iIdActividad" = act."iIdActividad"
        LEFT OUTER JOIN "PED2019" ped ON ped."iIdLineaAccion" = al."iIdLineaAccion"
        LEFT OUTER JOIN "DetalleActividadFinanciamiento" daf ON daf."iIdDetalleActividad" = dat."iIdDetalleActividad" 
        LEFT OUTER JOIN "Financiamiento" fin ON fin."iIdFinanciamiento" = daf."iIdFinanciamiento" 
        LEFT OUTER JOIN "DetalleActividadUBP" dup ON dup."iIdDetalleActividad" = dat."iIdDetalleActividad"
        LEFT OUTER JOIN "UBP" ubp ON ubp."iIdUbp" = dup."iIdUbp"
        LEFT OUTER JOIN "ProgramaPresupuestario" pp ON pp."iIdProgramaPresupuestario" = ubp."iIdProgramaPresupuestario"
        LEFT OUTER JOIN (SELECT "iIdDetalleActividad", SUM("monto") presupuesto
                        FROM "DetalleActividadFinanciamiento"
                        GROUP BY "iIdDetalleActividad") AS pre ON pre."iIdDetalleActividad" = dat."iIdDetalleActividad"
        LEFT OUTER JOIN "DetalleEntregable" det ON det."iIdDetalleActividad" = dat."iIdDetalleActividad" AND det."iActivo" = 1
        LEFT OUTER JOIN "Entregable" ent ON ent."iIdEntregable" = det."iIdEntregable" AND ent."iActivo" = 1
        LEFT OUTER JOIN "UnidadMedida" u ON u."iIdUnidadMedida" = ent."iIdUnidadMedida" 
        LEFT OUTER JOIN "SujetoAfectado" s ON s."iIdSujetoAfectado" = ent."iIdSujetoAfectado"
        LEFT OUTER JOIN "Periodicidad" pe ON pe."iIdPeriodicidad" = ent."iIdPeriodicidad"
        LEFT OUTER JOIN "DetalleEntregableMetaMunicipio" dem ON dem."iIdDetalleEntregable" = det."iIdDetalleEntregable"
        LEFT OUTER JOIN "Municipio" mun ON mun."iIdMunicipio" = dem."iIdMunicipio"
        LEFT OUTER JOIN "EntregableComponente" ec ON ec."iIdEntregable" = ent."iIdEntregable"
        LEFT OUTER JOIN "Componente" comp ON comp."iIdComponente" = ec."iIdComponente"
        LEFT OUTER JOIN "Compromiso" c ON c."iIdCompromiso" = comp."iIdCompromiso"
        LEFT OUTER JOIN (SELECT "iIdDetalleEntregable", SUM("nAvance") avance, SUM("nEjercido")  ejercido, SUM("nBeneficiariosH") beneficiariosh, SUM("nBeneficiariosM") beneficiariosm, SUM("nDiscapacitadosH") discapacitadosh, SUM("nDiscapacitadosM") discapacitadosm, SUM("nLenguaH") lenguah, SUM("nLenguaM") lenguam, MAX("dFecha") fechamax
                          FROM "Avance"
                          WHERE "iActivo" = 1 AND "iAprobado" = 1
                          GROUP BY "iIdDetalleEntregable") AS av ON av."iIdDetalleEntregable" = det."iIdDetalleEntregable"
        LEFT OUTER JOIN (SELECT "iIdDetalleEntregable", "dFecha" fechamax, SUM("nBeneficiariosH") beneficiariosh, SUM("nBeneficiariosM") beneficiariosm, SUM("nDiscapacitadosH") discapacitadosh, SUM("nDiscapacitadosM") discapacitadosm, SUM("nLenguaH") lenguah, SUM("nLenguaM") lenguam 
        FROM "Avance" 
        WHERE "iActivo" = 1 AND "iAprobado" = 1
        GROUP BY "iIdDetalleEntregable", "dFecha" ) AS ben ON ben."iIdDetalleEntregable" = det."iIdDetalleEntregable" AND ben.fechamax = av.fechamax
        WHERE dat."iActivo" = 1
        LIMIT 1';*/

        $sql = 'SELECT "iIdEje" FROM actividades_eje';

        return $this->db->query($sql);
    }

    public function reporte_pat($anio, $dep, $eje, $whereString=null, $mes)
    {
        
        /*$select = 'SELECT
            "Dependencia"."vDependencia" AS organismo, 
            "AreaResponsable"."vAreaResponsable" AS area, 
            "ProgramaPresupuestario"."vProgramaPresupuestario", 
            "PED2019Eje"."vEje", 
            "PED2019Eje"."iIdEje",
            "Actividad"."vObjetivo", 
            "Actividad"."vEstrategia", 
            "NivelMIR"."vNivelMIR", 
            "Actividad"."iIdActividad" AS clave, 
            "Actividad"."vDescripcion" AS resumennarrativo, 
            "Entregable"."vEntregable" as Indicador, 
            "DetalleEntregable"."nMeta" as Meta, 
            "UnidadMedida"."vUnidadMedida" as UnidadMedida,
            "DetalleActividad"."iAnio",
            "Dependencia"."iIdDependencia",
            "DetalleEntregable"."dFechaInicio",
            "ResumenNarrativo"."vNombreResumenNarrativo",
	          "DetalleEntregable"."dFechaFin",
            "Entregable"."nLineaBase" as lineabase,
            "Periodicidad"."vPeriodicidad" as frecuencia
            FROM "Dependencia"
            INNER JOIN "AreaResponsable" ON "Dependencia"."iIdDependencia" = "AreaResponsable"."iIdDependencia"
            INNER JOIN "Actividad" ON cast("AreaResponsable"."iIdAreaResponsable" as varchar) = cast("Actividad"."vResponsable" as varchar)
            left JOIN "ResumenNarrativo" ON "Actividad"."vResumenNarrativo" = cast("ResumenNarrativo"."iIdResumenNarrativo" as varchar)
            INNER JOIN "ProgramaPresupuestario" ON "Actividad"."iIdProgramaPresupuestario" = "ProgramaPresupuestario"."iIdProgramaPresupuestario"
            INNER JOIN "NivelMIR" ON "Actividad"."iIdNivelMIR" = "NivelMIR"."iIdNivelMIR"
            INNER JOIN "PED2019Eje" ON "Actividad".iideje = "PED2019Eje"."iIdEje"
            INNER JOIN "DetalleActividad" ON "Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"
            INNER JOIN "DetalleEntregable" ON "DetalleActividad"."iIdDetalleActividad" = "DetalleEntregable"."iIdDetalleActividad"
            INNER JOIN "Entregable" ON "DetalleEntregable"."iIdEntregable" = "Entregable"."iIdEntregable"
            INNER JOIN "UnidadMedida" ON "Entregable"."iIdUnidadMedida" = "UnidadMedida"."iIdUnidadMedida"
            INNER JOIN "Periodicidad" ON "Periodicidad"."iIdPeriodicidad" = "Entregable"."iIdPeriodicidad"';*/
            $barra = "' | '";
            $select = 'SELECT 
            "Dependencia"."vDependencia" AS organismo, 
            "AreaResponsable"."vAreaResponsable" AS area, 
            "ProgramaPresupuestario"."vProgramaPresupuestario", 
            "PED2019Eje"."vEje", 
            "PED2019Eje"."iIdEje",
            "Actividad"."vObjetivo", 
            "Actividad"."vEstrategia", 
            "NivelMIR"."vNivelMIR", 
            "Actividad"."iIdActividad" AS clave, 
            "Actividad"."vDescripcion" AS resumennarrativo, 
            STRING_AGG ( DISTINCT "Entregable"."vEntregable",'.$barra.') as Indicador, 
            sum("DetalleEntregable"."nMeta") as Meta, 
            STRING_AGG ( DISTINCT "UnidadMedida"."vUnidadMedida",'.$barra.') as UnidadMedida,
            "DetalleActividad"."iAnio",
            "Dependencia"."iIdDependencia",
            "DetalleEntregable"."dFechaInicio",
            "ResumenNarrativo"."vNombreResumenNarrativo",
	          "DetalleEntregable"."dFechaFin",
            max("Entregable"."nLineaBase") as lineabase,
            STRING_AGG ( DISTINCT "Periodicidad"."vPeriodicidad",'.$barra.') as frecuencia
            FROM "Dependencia"
            left JOIN "AreaResponsable" ON "Dependencia"."iIdDependencia" = "AreaResponsable"."iIdDependencia"
            left JOIN "Actividad" ON cast("AreaResponsable"."iIdAreaResponsable" as varchar) = cast("Actividad"."vResponsable" as varchar)
            left JOIN "ResumenNarrativo" ON "Actividad"."vResumenNarrativo" = cast("ResumenNarrativo"."iIdResumenNarrativo" as varchar)
            left JOIN "ProgramaPresupuestario" ON "Actividad"."iIdProgramaPresupuestario" = "ProgramaPresupuestario"."iIdProgramaPresupuestario"
            left JOIN "NivelMIR" ON "Actividad"."iIdNivelMIR" = "NivelMIR"."iIdNivelMIR"
            left JOIN "PED2019Eje" ON "Actividad".iideje = "PED2019Eje"."iIdEje"
            left JOIN "DetalleActividad" ON "Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"
            left JOIN "DetalleEntregable" ON "DetalleActividad"."iIdDetalleActividad" = "DetalleEntregable"."iIdDetalleActividad"
            left JOIN "Entregable" ON "DetalleEntregable"."iIdEntregable" = "Entregable"."iIdEntregable"
            left JOIN "UnidadMedida" ON "Entregable"."iIdUnidadMedida" = "UnidadMedida"."iIdUnidadMedida"
            left JOIN "Periodicidad" ON "Periodicidad"."iIdPeriodicidad" = "Entregable"."iIdPeriodicidad"';
        
            $whereCondition = ' WHERE "PED2019Eje"."iIdEje" = '.$eje.'AND "Actividad"."iActivo" = 1 AND "DetalleActividad"."iActivo" = 1 AND "Entregable"."iActivo" = 1 AND "DetalleEntregable"."iActivo" = 1 AND "DetalleActividad"."iAnio" ='.$anio ;
            if($dep != 0){
              $whereCondition = $whereCondition.' AND "Dependencia"."iIdDependencia" = '. $dep;
            }
      /*if(!empty($whereString)){
        $whereCondition = $whereCondition.' '. $whereString;
      }*/
      
      $group_by = ' group by
      "Dependencia"."vDependencia",
      "AreaResponsable"."vAreaResponsable",
      "ProgramaPresupuestario"."vProgramaPresupuestario", 
      "PED2019Eje"."vEje", 
      "PED2019Eje"."iIdEje",
      "Actividad"."vObjetivo", 
      "Actividad"."vEstrategia", 
      "NivelMIR"."vNivelMIR", 
      "Actividad"."iIdActividad", 
      "Actividad"."vDescripcion",             
      "DetalleActividad"."iAnio",
      "Dependencia"."iIdDependencia",
      "DetalleEntregable"."dFechaInicio",
      "ResumenNarrativo"."vNombreResumenNarrativo",
      "DetalleEntregable"."dFechaFin"';
      
        $sql = $select.$whereCondition.$group_by;
        $query =  $this->db->query($sql);
      //$_SESSION['sql'] = $this->db->last_query();
        return $query;
    }

    function obtenerDatosHija($idAct){
      if($idAct != ''){
        $sql = 'SELECT DISTINCT
        "Dependencia"."vDependencia" AS organismo, 
        "AreaResponsable"."vAreaResponsable" AS area, 
        "ProgramaPresupuestario"."vProgramaPresupuestario", 
        "PED2019Eje"."vEje", 
        "PED2019Eje"."iIdEje",
        "Actividad"."vObjetivo", 
        "Actividad"."vEstrategia", 
        "NivelMIR"."vNivelMIR", 
        "Actividad"."iIdActividad" AS clave, 
        "Actividad"."vDescripcion" AS resumennarrativo, 
        "Entregable"."vEntregable" as Indicador, 
        "DetalleEntregable"."nMeta" as Meta, 
        "UnidadMedida"."vUnidadMedida" as UnidadMedida,
        "DetalleActividad"."iAnio",
        "Dependencia"."iIdDependencia",
        "DetalleEntregable"."dFechaInicio",
        "ResumenNarrativo"."vNombreResumenNarrativo",
        "DetalleEntregable"."dFechaFin",
        "Entregable"."nLineaBase" as lineabase,
        "Periodicidad"."vPeriodicidad" as frecuencia,
        "Entregable"."iIdEntregable" as idindicador
        FROM "Dependencia"
        left JOIN "AreaResponsable" ON "Dependencia"."iIdDependencia" = "AreaResponsable"."iIdDependencia"
        left JOIN "Actividad" ON cast("AreaResponsable"."iIdAreaResponsable" as varchar) = cast("Actividad"."vResponsable" as varchar)
        left JOIN "ResumenNarrativo" ON "Actividad"."vResumenNarrativo" = cast("ResumenNarrativo"."iIdResumenNarrativo" as varchar)
        left JOIN "ProgramaPresupuestario" ON "Actividad"."iIdProgramaPresupuestario" = "ProgramaPresupuestario"."iIdProgramaPresupuestario"
        left JOIN "NivelMIR" ON "Actividad"."iIdNivelMIR" = "NivelMIR"."iIdNivelMIR"
        left JOIN "PED2019Eje" ON "Actividad".iideje = "PED2019Eje"."iIdEje"
        left JOIN "DetalleActividad" ON "Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"
        left JOIN "DetalleEntregable" ON "DetalleActividad"."iIdDetalleActividad" = "DetalleEntregable"."iIdDetalleActividad"
        left JOIN "Entregable" ON "DetalleEntregable"."iIdEntregable" = "Entregable"."iIdEntregable"
        left JOIN "UnidadMedida" ON "Entregable"."iIdUnidadMedida" = "UnidadMedida"."iIdUnidadMedida"
        left JOIN "Periodicidad" ON "Periodicidad"."iIdPeriodicidad" = "Entregable"."iIdPeriodicidad"
        WHERE "Actividad"."iIdActividad" = '. $idAct;
        $query =  $this->db->query($sql)->result();
          return $query;
      }
      
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
      $this->db->select();
      $this->db->from('PED2019Eje');
      $this->db->where('iIdEje', $eje);
      $query =  $this->db->get();
		  $resultado = $query->row();
      return $resultado;
    }

    public function obtenerObj($eje){
      $sql = 'select "vEje", "vObjetivoGobierno" From "PED2019Eje" Where "iIdEje" = '.$eje;
      
      $query =  $this->db->query($sql);
		  $resultado = $query->row();
      return $resultado;
  
     }

     function obtenerIdHija($idact)
  {
    $sql = 'SELECT "ActividadAglomerada"."iIdActividadHija" FROM "ActividadAglomerada" WHERE "ActividadAglomerada"."iIdActividadPadre" =' . $idact;

    $query =  $this->db->query($sql)->result();
    return $query;
  }

}



/*
SELECT ped."vEje", ped."vTema", ped."vObjetivo", ped."vEstrategia", ped."vLineaAccion", ped."iIdOds", ped."vOds",  eje."vEje" AS ejedependencia, dep."vDependencia", act."iIdActividad", dat."iIdDetalleActividad", act."vActividad", act."vDescripcion", act."vObjetivo" AS objetivoact, act."vPoblacionObjetivo", dat."dInicio", dat."dFin", dat."nAvance", dat."iReactivarEconomia", dat."nPresupuestoModificado", dat."nPresupuestoAutorizado",
        ent."iIdEntregable", det."iIdDetalleEntregable", ent."vEntregable", det."iPonderacion", det."nMeta", det."nMetaModificada", det."iSuspension", u."vUnidadMedida",
        s."vSujetoAfectado", pe."vPeriodicidad", ent."iMunicipalizacion", ent."iMismosBeneficiarios", av."nAvance", av."nEjercido", av."nBeneficiariosH", av."nBeneficiariosM", 
        av."nDiscapacitadosH", av."nDiscapacitadosM", av."nLenguaH", av."nLenguaM", mun."vMunicipio"
        FROM "Actividad" act
        INNER JOIN "DetalleActividad" dat ON dat."iIdActividad" = act."iIdActividad" AND dat."iAnio" = 2020
        INNER JOIN "Dependencia" dep ON dep."iIdDependencia" = act."iIdDependencia" AND dep."iIdDependencia" = 14
        INNER JOIN "DependenciaEje" dej ON dej."iIdDependencia" = dep."iIdDependencia"
        INNER JOIN "PED2019Eje" eje ON eje."iIdEje" = dej."iIdEje" AND dej."iIdEje" = 2
        LEFT OUTER JOIN "ActividadLineaAccion" al ON al."iIdActividad" = act."iIdActividad"
        LEFT OUTER JOIN "PED2019" ped ON ped."iIdLineaAccion" = al."iIdLineaAccion"        
        LEFT OUTER JOIN "DetalleActividadUBP" dup ON dup."iIdDetalleActividad" = dat."iIdDetalleActividad"
        LEFT OUTER JOIN "DetalleEntregable" det ON det."iIdDetalleActividad" = dat."iIdDetalleActividad" AND det."iActivo" = 1
        LEFT OUTER JOIN "Entregable" ent ON ent."iIdEntregable" = det."iIdEntregable" AND ent."iActivo" = 1
        LEFT OUTER JOIN "UnidadMedida" u ON u."iIdUnidadMedida" = ent."iIdUnidadMedida" 
        LEFT OUTER JOIN "SujetoAfectado" s ON s."iIdSujetoAfectado" = ent."iIdSujetoAfectado"
        LEFT OUTER JOIN "Periodicidad" pe ON pe."iIdPeriodicidad" = ent."iIdPeriodicidad"        
        INNER JOIN "Avance" av ON av."iIdDetalleEntregable" = det."iIdDetalleEntregable" AND av."iActivo" = 1 AND av."iAprobado" = 1 
        INNER JOIN "Municipio" mun ON mun."iIdMunicipio" = av."iMunicipio"
*/
                        
/* End of file M_reporteAct.php */
    
                        