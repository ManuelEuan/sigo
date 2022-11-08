<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_reporteCombinado extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->db = $this->load->database('default', TRUE);
  }

  public function ejes()
  {
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

  public function anio()
  {
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


  public function generar($eje, $dep, $anio)
  {
    $datos = '';
    $datos = array();
    $this->db->select();
    $this->db->from('reporte_actividades');
    $this->db->where('iIdEje', $eje);
    $this->db->where('iIdDependencia', $dep);
    $this->db->where('iAnio', $anio);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
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
          'iIdAvance'                    => $row->iIdAvance,
        ];
      }
    } else {
      return 'no hay datos';
    }
    return $datos;
  }

  public function generar2($anio)
  {
    $datos = '';
    $datos = array();
    $this->db->select();
    $this->db->from('"reporte_actividades"');
    $this->db->where('"iAnio" = ' . $anio . '');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
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
          'iIdAvance'                    => $row->iIdAvance,
        ];
      }
    } else {
      return 'no hay datos';
    }
    return $datos;
  }

  public function generar3($eje, $anio)
  {

    $datos = '';
    $datos = array();
    $this->db->select();
    $this->db->from('reporte_actividades');
    $this->db->where('iIdEje', $eje);
    $this->db->where('iAnio', $anio);
    $this->db->where('iActivo', 1);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
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
          'iIdAvance'                    => $row->iIdAvance,
        ];
      }
    } else {
      echo 'no hay datos';
    }

    return $datos;
  }

  public function recolectarsuma1($id)
  {
    $this->db->select('COALESCE(sum("monto"),0) as "monto"');
    $this->db->from('"DetalleActividadFinanciamiento"');
    $this->db->join('"DetalleActividad"', '"DetalleActividad"."iIdDetalleActividad" = "DetalleActividadFinanciamiento"."iIdDetalleActividad"');
    $this->db->where('"DetalleActividad"."iIdActividad"', $id);

    return $this->db->get()->row()->monto;
  }

  public function recolectarsuma2($id)
  {
    $this->db->select('COALESCE(sum("nBeneficiariosH"+"nBeneficiariosM"+"nDiscapacitadosH"+"nDiscapacitadosM"+"nLenguaH"+"nLenguaM"),0) as "sum2"');
    $this->db->from('"Avance"');
    $this->db->where('"iIdAvance"', $id);
    return $this->db->get()->row()->sum2;
  }

  /******************** Funciones Barbosa ************************/
  public function carga_actividades($eje = 0, $dep = 0, $anio = '')
  {
    $this->db->select('act.iIdActividad');
    $this->db->from('Actividad act');
    $this->db->join('DetalleActividad dact', 'act.iIdActividad = dact.iIdActividad', 'INNER');
    $this->db->join('DependenciaEje dep', 'act.iIdDependencia = dep.iIdDependencia', 'INNER');

    if ($eje > 0) $this->db->where('dep.iIdEje', $eje);
    if ($dep > 0) $this->db->where('act.iIdDependencia', $dep);
    if ($anio != '') $this->db->where('dact.iAnio', $anio);

    $query = $this->db->get();
    if ($query != false) return $query->result();
    else return false;
  }

  public function dependencias($ejeid)
  {
    $this->db->select('d.iIdDependencia, d.vDependencia');
    $this->db->from('Dependencia d');
    $this->db->join('DependenciaEje de', 'd.iIdDependencia = de.iIdDependencia', 'INNER');
    $this->db->where('de.iIdEje', $ejeid);

    $query = $this->db->get();
    if ($query != false) return $query->result();
    else return false;
  }

  /******************** Funciones Jorge E ************************/

  public function listado_actividades($where = '')
  {
    $this->db->select('da.iIdDetalleActividad');
    $this->db->from('DetalleActividad da');
    $this->db->join('Actividad ac', 'ac.iIdActividad = da.iIdActividad', 'INNER');
    $this->db->join('Dependencia dep', 'dep.iIdDependencia = ac.iIdDependencia', 'INNER');
    $this->db->join('DependenciaEje dej', 'dej.iIdDependencia = dep.iIdDependencia', 'INNER');
    $this->db->where('da.iActivo = 1 AND ac.iActivo = 1');
    $this->db->order_by('dej.iIdEje, dep.vDependencia');
    if ($where != '') $this->db->where($where);

    $result = $this->db->get()->result();
    $_SESSION['sql'] = $this->db->last_query();
    return $result;
  }

  public function getEjeDep($iIdDetalleActividad)
  {
    $this->db->select('dej.iIdEje, dep.vNombreCorto');
    $this->db->from('DetalleActividad da');
    $this->db->join('Actividad ac', 'ac.iIdActividad = da.iIdActividad', 'INNER');
    $this->db->join('Dependencia dep', 'dep.iIdDependencia = ac.iIdDependencia', 'INNER');
    $this->db->join('DependenciaEje dej', 'dej.iIdDependencia = dep.iIdDependencia', 'INNER');
    $this->db->where('da.iIdDetalleActividad', $iIdDetalleActividad);

    return $this->db->get()->row();
  }

  public function reporte_actividades($anio, $eje, $dep = 0)
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

  public function reporte_pat($anio, $dep, $eje, $whereString = null, $mes, $pp)
  {
    $barra = "' | '";
    $mes = "'month'";
    $coma = "','";
    $select = 'select idact, nivel, resumennarrativo,tipo, dimension, accion, clave, STRING_AGG ( DISTINCT operacion,' .$barra. ') as operacion,STRING_AGG (DISTINCT vvariable,' .$barra. ') as vvariable, STRING_AGG ( DISTINCT indicador,' .$barra. ') as indicador, STRING_AGG ( DISTINCT unidadmedida,' .$barra. ') as unidadmedida, STRING_AGG ( DISTINCT frecuencia,' .$barra. ') as frecuencia, avg(meta) as meta,
    STRING_AGG ( DISTINCT formula,' .$barra. ') as formula, STRING_AGG( DISTINCT umedioverifica, ' .$barra. ') as umedioverifica,
   SUM (Enero) AS Enero, sum(Febrero) as Febrero,sum(Marzo) as Marzo,
   sum(Abril) as Abril, sum(Mayo) as Mayo,Sum(Junio) as Junio,sum(Julio) as Julio, sum(Agosto) as Agosto,
   sum(Septiembre) as Septiembre, sum(Octubre) as Octubre, sum(Noviembre) as Noviembre, sum(Diciembre) as Diciembre from 
   (select idact, nivel, resumennarrativo,tipo, dimension, accion, clave, indicador, meta, frecuencia, operacion, vvariable, unidadmedida, formula, umedioverifica,
           sum(case when (fecha=1) then avance end) as Enero,
           sum(case when (fecha=2) then avance end) as Febrero,
           sum(case when (fecha=3) then avance end) as Marzo,
           sum(case when (fecha=4) then avance end) as Abril,
           sum(case when (fecha=5) then avance end) as Mayo,
           sum(case when (fecha=6) then avance end) as Junio,
           sum(case when (fecha=7) then avance end) as Julio,
           sum(case when (fecha=8) then avance end) as Agosto,
           sum(case when (fecha=9) then avance end) as Septiembre,
           sum(case when (fecha=10) then avance end) as Octubre,
           sum(case when (fecha=11) then avance end) as Noviembre,
           sum(case when (fecha=12) then avance end) as Diciembre
           from
   
           (select idact, nivel,resumennarrativo,tipo, dimension, accion, clave, indicador, meta, frecuencia, operacion, vvariable, unidadmedida, formula,
                   umedioverifica, fecha, sum(avance) as avance, dep, iideje  from
                   (SELECT "NivelMIR"."vNivelMIR" as nivel,
                           "Actividad"."iIdActividad" as idact,
                           "ResumenNarrativo"."vNombreResumenNarrativo" as resumennarrativo,
                           "Actividad"."vtipoactividad" as tipo,
                           "DimensionIndicador"."vDescripcion" as dimension,
                           "Actividad"."vActividad" as accion,
                           "Actividad"."iIdActividad" as clave,
                           "Entregable"."vEntregable" as indicador,
                           "DetalleEntregable"."nMeta" as meta,
                           "Periodicidad"."vPeriodicidad" as frecuencia,
                           "FormaIndicador"."vDescripcion" as operacion,
                           string_agg("VariableIndicador"."vNombreVariable", '.$coma. ') vvariable,
                           "UnidadMedida"."vUnidadMedida" as unidadmedida,
                           "Entregable"."vFormula" as formula,
                           "Entregable"."vMedioVerifica" as umedioverifica,
                           date_part('.$mes.',"Avance"."dFecha") as fecha,
                           "Avance"."nAvance" as avance,
                           "Dependencia"."iIdDependencia" as dep,
                           "PED2019Eje"."iIdEje" as iideje,
                           "DetalleEntregable"."iIdDetalleEntregable" as iiddetalleentregable,
                           "Avance"."iIdAvance" as iidavance
                           FROM "Actividad"
                           INNER JOIN "PED2019Eje" ON "Actividad".iideje = "PED2019Eje"."iIdEje"
                           INNER JOIN "DetalleActividad" ON  "Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"
                           left JOIN "AreaResponsable" ON "Actividad"."vResponsable" = cast("AreaResponsable"."iIdAreaResponsable" as varchar)
                           left JOIN "ResumenNarrativo" ON "Actividad"."vResumenNarrativo" = cast("ResumenNarrativo"."iIdResumenNarrativo" as varchar)
                           INNER JOIN "Dependencia" ON "Dependencia"."iIdDependencia" = "Actividad"."iIdDependencia"
                           INNER JOIN "NivelMIR" ON "Actividad"."iIdNivelMIR" = "NivelMIR"."iIdNivelMIR"
                           inner join "Retos" on "Actividad"."iReto"="Retos"."iIdReto"
                           inner join "ProgramaPresupuestario" on "Actividad"."iIdProgramaPresupuestario" = "ProgramaPresupuestario"."iIdProgramaPresupuestario"
                           left join "DetalleEntregable" on "DetalleActividad"."iIdDetalleActividad"="DetalleEntregable"."iIdDetalleActividad"
                           left join "Entregable" on "DetalleEntregable"."iIdEntregable"="Entregable"."iIdEntregable"
                           LEFT JOIN "DimensionIndicador" ON "DimensionIndicador"."iIdDimensionInd" = "Entregable"."iIdDimensionInd"
                           LEFT JOIN "Periodicidad" ON "Periodicidad"."iIdPeriodicidad" = "Entregable"."iIdPeriodicidad"
                           LEFT JOIN "FormaIndicador" ON "FormaIndicador"."iIdFormaInd" = "Entregable"."iIdFormaInd"
                           LEFT JOIN "VariableIndicador" ON "VariableIndicador"."iIdEntregable" = "Entregable"."iIdEntregable"
                           left join "Avance" on "DetalleEntregable"."iIdDetalleEntregable"="Avance"."iIdDetalleEntregable"
                           LEFT JOIN "UnidadMedida" ON "UnidadMedida"."iIdUnidadMedida" = "Entregable"."iIdUnidadMedida"';

    $where = ' WHERE "PED2019Eje"."iIdEje" = ' . $eje . ' AND "Actividad"."iActivo" = 1  AND "DetalleActividad"."iAnio" = ' . $anio . ' AND "DetalleActividad"."iActivo" = 1 AND
               "Avance"."iActivo" = 1  AND "Entregable"."iActivo" = 1  AND "DetalleEntregable"."iActivo" = 1  ';
    if ($dep != '') {
      $weherDep = ' AND "Dependencia"."iIdDependencia" = ' . $dep;
      $where = $where . $weherDep;
    }
    if ($pp != '' && $pp != null) {
      $wherePP = ' AND "ProgramaPresupuestario"."iIdProgramaPresupuestario" = ' . $pp;
      $where = $where . $wherePP;
    }

    $gropuBy = ' GROUP BY fecha, nivel, resumennarrativo, tipo, dimension, accion, clave, indicador, meta, frecuencia, operacion, unidadmedida, formula, umedioverifica, avance, dep, "PED2019Eje"."iIdEje",iiddetalleentregable,iidavance)  vistaRCombinado
    group by idact, nivel,resumennarrativo,tipo, dimension, accion, clave, indicador, meta, frecuencia, operacion, vvariable, unidadmedida, formula,
    umedioverifica, fecha, dep, iideje) consulta
              group by idact, nivel, resumennarrativo,tipo, dimension, accion, clave, indicador, meta, frecuencia, operacion, vvariable, unidadmedida, formula, umedioverifica) qry
group by	idact, nivel, resumennarrativo,tipo, dimension, accion, clave';
    $sql = $select . $where . $gropuBy;
    $query =  $this->db->query($sql);
    //$_SESSION['sql'] = $this->db->last_query();
    return $query;
  }
  public function reporteH($idactividad)
  {
    if (!empty($idactividad)) {
      $this->db->select('*');
      $this->db->from('Actividad');
      $this->db->where('iIdActividad', $idactividad);
      $query =  $this->db->get();
      $resultado = $query->row();
      return $resultado;
    }
  }
  public function reporteHija($idactividad)
  {
    $mes = "'month'";
    $coma = "','";
    if (!empty($idactividad)) {


      $select = 'select idact, nivel, resumennarrativo,tipo, dimension, accion, clave, indicador, meta, frecuencia, operacion, vvariable, unidadmedida, formula, umedioverifica, isActivo, isEntregable,
      sum(case when (fecha=1) then avance end) as Enero,
      sum(case when (fecha=2) then avance end) as Febrero,
      sum(case when (fecha=3) then avance end) as Marzo,
      sum(case when (fecha=4) then avance end) as Abril,
      sum(case when (fecha=5) then avance end) as Mayo,
      sum(case when (fecha=6) then avance end) as Junio,
      sum(case when (fecha=7) then avance end) as Julio,
      sum(case when (fecha=8) then avance end) as Agosto,
      sum(case when (fecha=9) then avance end) as Septiembre,
      sum(case when (fecha=10) then avance end) as Octubre,
      sum(case when (fecha=11) then avance end) as Noviembre,
      sum(case when (fecha=12) then avance end) as Diciembre
      from

      (select idact, nivel,resumennarrativo,tipo, dimension, accion, clave, indicador, meta, frecuencia, operacion, vvariable, unidadmedida, formula, isActivo, isEntregable,
              umedioverifica, fecha, sum(avance) as avance, dep, iideje  from
              (SELECT "NivelMIR"."vNivelMIR" as nivel,
                      "Actividad"."iIdActividad" as idact,
                      "ResumenNarrativo"."vNombreResumenNarrativo" as resumennarrativo,
                      "Actividad"."vtipoactividad" as tipo,
                      "DimensionIndicador"."vDescripcion" as dimension,
                      "Actividad"."vActividad" as accion,
                      "Actividad"."iIdActividad" as clave,
                      "Entregable"."vEntregable" as indicador,
                      "Entregable"."nLineaBase" as meta,
                      "Periodicidad"."vPeriodicidad" as frecuencia,
                      "FormaIndicador"."vDescripcion" as operacion,
                      string_agg("VariableIndicador"."vNombreVariable", ' . $coma . ') vvariable,
                      "UnidadMedida"."vUnidadMedida" as unidadmedida,
                      "Entregable"."vFormula" as formula,
                      "Entregable"."vMedioVerifica" as umedioverifica,
                      date_part(' . $mes . ',"Avance"."dFecha") as fecha,
                      "Avance"."nAvance" as avance,
                      "Dependencia"."iIdDependencia" as dep,
                      "PED2019Eje"."iIdEje" as iideje,
                      "DetalleEntregable"."iIdDetalleEntregable" as iiddetalleentregable,
                      "Avance"."iIdAvance" as iidavance,
                      "Avance"."iActivo" as isActivo,
											"Entregable"."iActivo" as isEntregable
                      FROM "Actividad"
                      left JOIN "PED2019Eje" ON "Actividad".iideje = "PED2019Eje"."iIdEje"
                      left JOIN "DetalleActividad" ON  "Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"
                      left JOIN "AreaResponsable" ON "Actividad"."vResponsable" = cast("AreaResponsable"."iIdAreaResponsable" as varchar)
                      left JOIN "ResumenNarrativo" ON "Actividad"."vResumenNarrativo" = cast("ResumenNarrativo"."iIdResumenNarrativo" as varchar)
                      left JOIN "Dependencia" ON "Dependencia"."iIdDependencia" = "Actividad"."iIdDependencia"
                      left JOIN "NivelMIR" ON "Actividad"."iIdNivelMIR" = "NivelMIR"."iIdNivelMIR"
                      left join "Retos" on "Actividad"."iReto"="Retos"."iIdReto"
                      left join "ProgramaPresupuestario" on "Actividad"."iIdProgramaPresupuestario" = "ProgramaPresupuestario"."iIdProgramaPresupuestario"
                      left join "DetalleEntregable" on "DetalleActividad"."iIdDetalleActividad"="DetalleEntregable"."iIdDetalleActividad"
                      left join "Entregable" on "DetalleEntregable"."iIdEntregable"="Entregable"."iIdEntregable"
                      LEFT JOIN "DimensionIndicador" ON "DimensionIndicador"."iIdDimensionInd" = "Entregable"."iIdDimensionInd"
                      LEFT JOIN "Periodicidad" ON "Periodicidad"."iIdPeriodicidad" = "Entregable"."iIdPeriodicidad"
                      LEFT JOIN "FormaIndicador" ON "FormaIndicador"."iIdFormaInd" = "Entregable"."iIdFormaInd"
                      LEFT JOIN "VariableIndicador" ON "VariableIndicador"."iIdEntregable" = "Entregable"."iIdEntregable"
                      left join "Avance" on "DetalleEntregable"."iIdDetalleEntregable"="Avance"."iIdDetalleEntregable"
                      LEFT JOIN "UnidadMedida" ON "UnidadMedida"."iIdUnidadMedida" = "Entregable"."iIdUnidadMedida"
                      WHERE "Actividad"."iActivo" = 1 AND "Entregable"."iActivo" = 1 AND "DetalleEntregable"."iActivo" = 1 AND "DetalleActividad"."iActivo" = 1 AND "Avance"."iActivo" = 1 AND "Actividad"."iIdActividad" =' . $idactividad;


      // $where = ' WHERE "PED2019Eje"."iIdEje" = '.$eje.' AND "DetalleActividad"."iAnio" = '. $anio.' AND "Entregable"."iActivo" = 1 AND "Avance"."iActivo" = 1 AND "Actividad"."iActivo" = 1';


      $gropuBy = 'GROUP BY fecha, nivel, resumennarrativo, tipo, dimension, accion, clave, indicador, meta, frecuencia, operacion, unidadmedida, formula, umedioverifica, avance, dep, "PED2019Eje"."iIdEje",iiddetalleentregable,iidavance, isEntregable)  vistaRCombinado
      group by idact, nivel,resumennarrativo,tipo, dimension, accion, clave, indicador, meta, frecuencia, operacion, vvariable, unidadmedida, formula,isActivo, isEntregable,
      umedioverifica, fecha, dep, iideje) consulta
                group by idact, nivel, resumennarrativo,tipo, dimension, accion, clave, indicador, meta, frecuencia, operacion, vvariable, unidadmedida, formula, umedioverifica, isActivo, isEntregable';

      $sql = $select . $gropuBy;
      $query =  $this->db->query($sql)->result();
      //$_SESSION['sql'] = $this->db->last_query();
      return $query;
    }
  }
  function obtenerIdHija($idact)
  {
    $sql = 'SELECT "ActividadAglomerada"."iIdActividadHija" FROM "ActividadAglomerada" WHERE "ActividadAglomerada"."iIdActividadPadre" =' . $idact;

    $query =  $this->db->query($sql)->result();
    return $query;
  }
  function catalogos($tipo)
  {
    $sql = '';
    if ($tipo == 1) {
      $sql = 'SELECT * FROM "Financiamiento" WHERE "iActivo" = 1';
    }

    if ($tipo == 2) {
      $sql = 'SELECT * FROM "PED2019"';
    }

    if ($tipo == 3) {
      $sql = 'SELECT * FROM "ProgramaPresupuestario" WHERE "iActivo" = 1';
    }

    if ($tipo == 4) {
      $sql = 'SELECT * FROM "SujetoAfectado" WHERE "iActivo" = 1';
    }

    if ($tipo == 5) {
      $sql = 'SELECT u.*, tu."vTipoUbp" 
              FROM "UBP" u
              INNER JOIN "TipoUBP" tu ON tu."iIdTipoUbp" = u."iIdTipoUbp"
              WHERE u."iActivo" = 1;';
    }

    if ($tipo == 6) {
      $sql = 'SELECT * FROM "UnidadMedida" WHERE "iActivo" = 1 ORDER BY "iIdUnidadMedida"';
    }
    return $this->db->query($sql);
  }

  public function obtenerDep($dep)
  {
    $this->db->select('*');
    $this->db->from('Dependencia');
    $this->db->where('iIdDependencia', $dep);
    $query =  $this->db->get();
    $resultado = $query->row();
    return $resultado;
  }

  public function obtenerEje($eje)
  {
    $this->db->select();
    $this->db->from('PED2019Eje');
    $this->db->where('iIdEje', $eje);
    $query =  $this->db->get();
    $resultado = $query->row();
    return $resultado;
  }

  public function obtenerObj($eje)
  {
    $sql = 'select "vEje", "vObjetivoGobierno" From "PED2019Eje" Where "iIdEje" =' . $eje;

    $query =  $this->db->query($sql);
    $resultado = $query->row();
    return $resultado;
  }
  function obtenerPP()
  {
    $this->db->select();
    $this->db->from('ProgramaPresupuestario');
    $query = $this->db->get()->result();

    return $query;
  }

  function obtenerPPporId($id)
  {
    $this->db->select();
    $this->db->from('ProgramaPresupuestario');
    $this->db->where('iIdProgramaPresupuestario', $id);
    $query = $this->db->get()->row();

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
