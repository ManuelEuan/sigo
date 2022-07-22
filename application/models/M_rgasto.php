<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class M_rgasto extends CI_Model {

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
   public function obtenerDep($dep){
$this->db->select('vDependencia');
$this->db->from('Dependencia');
$this->db->where('iIdDependencia',$dep);
$query = $this->db->get();
$resultado = $query->row();
return $resultado;
   }
   public function obtenerEje($eje){
    $this->db->select('vEje');
    $this->db->from('PED2019Eje');
    $this->db->where('iIdEje',$eje);
    $query = $this->db->get();
    $resultado = $query->row();
    return $resultado;
   }
   public function obtenerObj($eje){
    /*$this->db->select('vObjetivo');
    $this->db->from('PED2019Eje');
    $this->db->where('iIdEje',$eje);
    $query = $this->db->get();
    $resultado = $query->row();*/
    $sql = 'SELECT "vObjetivoGobierno" from "PED2019Eje" WHERE "iIdEje" ='.$eje;
    $query =  $this->db->query($sql)->result();
    return $query;
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




    public function reporte_pat($anio,$eje, $dep, $whereString=null, $pp)
    {
      $select ='SELECT DISTINCT
      "PED2019Eje"."vEje", 
      "Dependencia"."vDependencia", 
      "Actividad"."iIdActividad", 
			"DetalleActividad"."iIdDetalleActividad",
			"Actividad"."vAccion",
      "DetalleActividad"."iAnio", 
      "DetalleActividad"."dInicio", 
      "DetalleActividad"."dFin", 
      "DetalleActividad"."nAvance", 
      "Actividad"."vResponsable", 
      "AreaResponsable"."vAreaResponsable",  
      "DetalleActividad"."iReactivarEconomia", 
      "DetalleActividad"."nPresupuestoAutorizado",
      "DetalleActividad"."nPresupuestoModificado",
      "Actividad"."vEstrategia" as estrategiaact, 
      "Dependencia"."iIdDependencia", 
      "PED2019Eje"."iIdEje",
			"Avance"."nAvance" as avancedos,
			SUM("Avance"."nBeneficiariosH" + "Avance"."nBeneficiariosM" + "Avance"."nTerceraEdadM" +"Avance"."nTerceraEdadH" + "Avance"."nLenguaM" + "Avance"."nLenguaH" + "Avance"."nEjercido" + "Avance"."nDiscapacitadosM" + "Avance"."nDiscapacitadosH" + "Avance"."nAdolescenteM" + "Avance"."nAdolescenteH") personasbeneficiadas,
			"ProyectosPrioritarios"."vProyectoPrioritario",
			"ODS"."vOds"
			
			';
      

      $from = 'FROM "Actividad"
      INNER JOIN "PED2019Eje" ON "Actividad".iideje = "PED2019Eje"."iIdEje"
      INNER JOIN "DetalleActividad" ON  "Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"
      left JOIN "AreaResponsable" ON "Actividad"."vResponsable" = cast("AreaResponsable"."iIdAreaResponsable" as varchar)
      INNER JOIN "Dependencia" ON "Dependencia"."iIdDependencia" = "AreaResponsable"."iIdDependencia"
      left join "DetalleEntregable" on "DetalleActividad"."iIdDetalleActividad"="DetalleEntregable"."iIdDetalleActividad"
      left join "Entregable" on "DetalleEntregable"."iIdEntregable"="Entregable"."iIdEntregable"
      left join "Avance" on "DetalleEntregable"."iIdDetalleEntregable"="Avance"."iIdDetalleEntregable"
      INNER JOIN "ProyectosPrioritarios" ON "ProyectosPrioritarios"."iIdEje" = "PED2019Eje"."iIdEje"
			LEFT JOIN "ODS" ON "ODS"."iIdOds" = "Actividad"."iODS"';


      $whereCondition = ' WHERE "PED2019Eje"."iIdEje" = '.$eje.' AND "DetalleActividad"."iAnio" = '.$anio.' AND "Actividad"."iActivo" = 1 AND "DetalleActividad"."iActivo" = 1 AND "Entregable"."iActivo" = 1 AND "DetalleEntregable"."iActivo" = 1 AND "Avance"."iActivo" = 1';
      //

      if($dep != 0){
        $whereCondition = $whereCondition.' AND "Dependencia"."iIdDependencia" ='.$dep;
      }

      // if($pp != 0){
      //   $whereCondition = $whereCondition.' AND "ProgramaPresupuestario"."iIdProgramaPresupuestario" = '.$pp;
      // }

      if(!empty($whereString)){
        $whereCondition = $whereCondition.' '. $whereString;
      }
      
      $group_by = '	GROUP BY "PED2019Eje"."iIdEje", "Dependencia"."iIdDependencia", "Actividad"."iIdActividad", "DetalleActividad"."iIdDetalleActividad", "AreaResponsable"."iIdAreaResponsable", "Avance"."iIdAvance", "ProyectosPrioritarios"."iIdProyectoPrioritario", "ODS"."iIdOds"';
      
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
}

                        
/* End of file M_reporteMir.php */
    
                        