<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class M_reporteAnex extends CI_Model {

   function __construct(){
      parent::__construct();
      $this->db = $this->load->database('default',TRUE);
      $this->ssop = $this->load->database('ssop', TRUE);
   }
    
   public function carga_anios($entregid, $anio)
   {
      $this->db->select('dact.iAnio');
      $this->db->from('DetalleEntregable dent');
      $this->db->join('DetalleActividad dact', 'dent.iIdDetalleActividad = dact.iIdDetalleActividad','LEFT');
      $this->db->join('Avance av', 'dent.iIdDetalleEntregable = av.iIdDetalleEntregable','INNER');     
      $this->db->where('dent.iIdEntregable', $entregid);
      $this->db->where('dent.iActivo',1);
      $this->db->where('dact.iActivo', 1);
      $this->db->where('dact.iAnio <= ', $anio);
      $this->db->where('av.iActivo', 1);
      $this->db->where('av.iAprobado', 1);
      $this->db->group_by('dact.iAnio');
      $this->db->order_by('dact.iAnio', 'ASC');

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }

   

   
   public function carga_actividades_mapa($ejeid = 0, $anio = '')
   {
      //$this->db->select('DISTINCT tem."iIdEje", tem."iIdTema", act."iIdActividad", act."vActividad", dact."iIdDetalleActividad", ent."iIdEntregable", ent."vEntregable", dact."iAnio", act."iIdDependencia", ent."iMismosBeneficiarios", act."vNombreActividad", ent."vNombreEntregable", ent."iNumOds", dent."iAnexo"', false);
      /*$this->db->select('DISTINCT tem."iIdEje", act."iIdActividad", act."vActividad", dact."iIdDetalleActividad", ent."iIdEntregable", ent."vEntregable", dact."iAnio", act."iIdDependencia", ent."iMismosBeneficiarios", act."vNombreActividad", ent."vNombreEntregable", ent."iNumOds", dent."iAnexo", ent."iEjeAnexo", ent."vNombreEntregableMaya"', false);
      $this->db->from('PED2019Tema tem');
      $this->db->join('PED2019Objetivo obj', 'tem.iIdTema = obj.iIdTema','INNER');
      $this->db->join('PED2019Estrategia est', 'obj.iIdObjetivo = est.iIdObjetivo','INNER');
      $this->db->join('PED2019LineaAccion la', 'est.iIdEstrategia = la.iIdEstrategia','INNER');
      $this->db->join('ActividadLineaAccion ala', 'la.iIdLineaAccion = ala.iIdLineaAccion','INNER');
      $this->db->join('Actividad act', 'ala.iIdActividad = act.iIdActividad','INNER');
      $this->db->join('DetalleActividad dact', 'act.iIdActividad = dact.iIdActividad AND dact."iActivo" = 1','INNER');
      $this->db->join('DetalleEntregable dent', 'dact.iIdDetalleActividad = dent.iIdDetalleActividad and dent."iActivo" = 1','INNER');
      $this->db->join('Entregable ent', 'dent.iIdEntregable = ent.iIdEntregable','INNER');
      $this->db->where('act.iActivo', 1);
      $this->db->where('tem.iIdEje',$ejeid);
      $this->db->where('dact.iAnio', $anio);
      $this->db->where('ent.iActivo',1);
      $this->db->where('ent.iMunicipalizacion', 1);
      $this->db->where('dent.iAnexo', 1);*/
      $this->db->select('DISTINCT eje."iIdEje", eje."vEje", act."iIdActividad", act."vActividad", dact."iIdDetalleActividad", ent."iIdEntregable", ent."vEntregable", dact."iAnio", act."iIdDependencia", ent."iMismosBeneficiarios", act."vNombreActividad", ent."vNombreEntregable", ent."iNumOds", dent."iAnexo", ent."iEjeAnexo", ent."vNombreEntregableMaya"',false);
      $this->db->from('PED2019Eje eje');
      $this->db->join('Entregable ent', 'ent.iEjeAnexo = eje.iIdEje AND ent.iActivo = 1 AND ent.iMunicipalizacion = 1','INNER');
      $this->db->join('DetalleEntregable dent','dent.iIdEntregable = ent.iIdEntregable and dent.iActivo = 1 AND dent.iAnexo = 1','INNER'); 
      $this->db->join('DetalleActividad dact','dact.iIdDetalleActividad = dent.iIdDetalleActividad AND dact.iActivo = 1','INNER');
      $this->db->join('Actividad act','act.iIdActividad = dact.iIdActividad AND act.iActivo = 1','INNER');
      $this->db->join('avdet_anexo av','av.iIdDetalleEntregable = dent.iIdDetalleEntregable','INNER');
      $this->db->order_by('act.vNombreActividad ASC, ent.vNombreEntregable ASC');
      $this->db->where('eje.iIdEje',$ejeid);
      $this->db->where('dact.iAnio', $anio);
      //$this->db->where('ent.iIdEntregable IN (4123,4124)');
      //$this->db->limit(1,21);

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }
   
   
   public function carga_actividades($ejeid=0, $anio='')
   {
      $this->db->select('tem.iIdEje, tem.iIdTema, act.iIdActividad, act.vActividad, dact.iIdDetalleActividad');
      $this->db->from('PED2019Tema tem');
      $this->db->join('PED2019Objetivo obj','tem.iIdTema = obj.iIdTema','INNER');
      $this->db->join('PED2019Estrategia est','obj.iIdObjetivo = est.iIdObjetivo','INNER');
      $this->db->join('PED2019LineaAccion la','est.iIdEstrategia = la.iIdEstrategia','INNER');
      $this->db->join('ActividadLineaAccion ala','la.iIdLineaAccion = ala.iIdLineaAccion','INNER');
      $this->db->join('Actividad act','ala.iIdActividad = act.iIdActividad','INNER');
      $this->db->join('DetalleActividad dact','act.iIdActividad = dact.iIdActividad','INNER');
      $this->db->where('dact.iActivo', 1);
      $this->db->where('act.iActivo', 1);
      if($ejeid > 0) $this->db->where('tem.iIdEje',$ejeid);
      if($anio != '') $this->db->where('dact.iAnio',$anio);
      $this->db->order_by('tem.iIdEje ASC, tem.iIdTema ASC');
      
      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }

   public function guarda_anex($datos)
   {
      //return $this->db2->insert('tabla_anexo', $datos);
      return $this->db2->insert('tabla_anexo', $datos);      
   }

   public function carga_detalle($iIdEntregable, $iIdActividad, $anio)
   {
      $this->db->select('act.iIdActividad, dact.iIdDetalleActividad, dent.iIdDetalleEntregable, ent.iIdEntregable, dact.iAnio');
      $this->db->from('Actividad act');
      $this->db->join('DetalleActividad dact', 'act.iIdActividad = dact.iIdActividad','INNER');
      $this->db->join('DetalleEntregable dent', 'dact.iIdDetalleActividad = dent.iIdDetalleActividad','INNER');
      $this->db->join('Entregable ent', 'dent.iIdEntregable = ent.iIdEntregable','INNER');
      $this->db->where('act.iActivo', 1);
      $this->db->where('dact.iActivo', 1);
      $this->db->where('dent.iActivo', 1);
      $this->db->where('ent.iActivo', 1);
      //$this->db->where('ent.iIdEntregable', $iIdEntregable);
      $this->db->where('ent.iIdEntregable', $iIdEntregable);
      //$this->db->where('act.iIdActividad', $iIdActividad);
      $this->db->where('act.iIdActividad', $iIdActividad);
      $this->db->where('dact.iAnio', $anio);

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }

   public function carga_entregables($iIdActividad=0, $anio='')
   {  
      $this->db->select('ent.iIdEntregable, ent.vEntregable, dact.iAnio, dact.iIdActividad, ent.iIdDependencia');
      $this->db->from('Entregable ent');
      $this->db->join('DetalleEntregable dent', 'ent.iIdEntregable = dent.iIdDetalleEntregable', 'INNER');
      $this->db->join('DetalleActividad dact', 'dent.iIdDetalleActividad = dact.iIdDetalleActividad', 'INNER');
      $this->db->where('ent.iActivo', 1);
      $this->db->where('ent.iMunicipalizacion', 1);
      $this->db->where('dact.iIdActividad', $iIdActividad);
      $this->db->where('dact.iAnio', $anio);
      $this->db->where('dent.iActivo', 1);
      $this->db->where('dact.iActivo', 1);
      $this->db->order_by('ent.iIdEntregable');
    
      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }

   public function poblacion_mun($mundid)
   {
      $this->db->select('iTotalPoblacion');
      $this->db->from('Municipio');
      $this->db->where('iIdMunicipio', $mundid);

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }

   public function carga_municipios($entregid)
   {
      $this->db->select('mu.iIdMunicipio, mu.vMunicipio');
      $this->db->from('Avance av');
      $this->db->join('Municipio mu','av.iMunicipio = mu.iIdMunicipio','INNER');
      $this->db->join('DetalleEntregable dent','av.iIdDetalleEntregable = dent.iIdDetalleEntregable','INNER');
      $this->db->where('dent.iIdEntregable',$entregid);
      $this->db->where('dent.iActivo', 1);
      $this->db->where('av.iAprobado', 1);
      $this->db->where('av.iActivo', 1);
      $this->db->group_start();
      $this->db->where('av.nAvance >', 0);
         $this->db->or_group_start();
            $this->db->where('av.nBeneficiariosH >', 0);
            $this->db->where('av.nBeneficiariosM >', 0);
            $this->db->where('av.nDiscapacitadosH >', 0);
            $this->db->where('av.nDiscapacitadosM >', 0);
            $this->db->where('av.nLenguaH >', 0);
            $this->db->where('av.nLenguaM >', 0);
         $this->db->group_end();
      $this->db->group_end();      
      $this->db->group_by('mu.iIdMunicipio, mu.vMunicipio');
      $this->db->order_by('mu.vMunicipio');         
      
      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }

   public function carga_region($munid)
   {
      $this->db->select('iIdRegion');
      $this->db->from('Municipio');
      $this->db->where('iIdMunicipio', $munid);

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }

   public function carga_mben($entregid)
   {
      $this->db->select('iMismosBeneficiarios');
      $this->db->from('Entregable');
      $this->db->where('iIdEntregable', $entregid);

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }

   public function carga_umes($entregid, $anio)
   {
      $this->db->select('EXTRACT(MONTH FROM "dFecha") as mes, SUM(av."nBeneficiariosH" + av."nBeneficiariosM") ben');
      $this->db->from('Avance av');
      $this->db->join('DetalleEntregable dent','av.iIdDetalleEntregable = dent.iIdDetalleEntregable','INNER');
      $this->db->where('av.iActivo', 1);
      $this->db->where('av.iAprobado', 1);
      $this->db->where('dent.iIdEntregable', $entregid);
      $this->db->where('dent.iActivo', 1);
      $this->db->where('EXTRACT(year FROM av."dFecha") = '.$anio);
      $this->db->group_by('EXTRACT(MONTH FROM av."dFecha")');
      ///$this->db->order_by('mes DESC');
      $this->db->order_by('ben DESC');
      $this->db->limit(1);

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }

   public function carga_dependencia($depid)
   {
      $this->db->select('vNombreCorto');
      $this->db->from('Dependencia');
      $this->db->where('iActivo', 1);
      $this->db->where('iIdDependencia', $depid);

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }

   public function carga_dependencia2($actid)
   {
      $this->db->select('dep.iIdDependencia, dep.vNombreCorto');
      $this->db->from('Dependencia dep');
      $this->db->join('Actividad act','dep.iIdDependencia = act.iIdDependencia','INNER');
      $this->db->where('act.iIdActividad', $actid);

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;

   }

   public function valida_totalben($iIdEntregable)
   {
      $this->db->select('sum(av."nDiscapacitadosH" + av."nDiscapacitadosM") as discap, sum(av."nLenguaH" + av."nLenguaM") as leng, dent."iIdEntregable"');
      $this->db->from('"Avance" av');
      $this->db->join('"DetalleEntregable" dent', 'av."iIdDetalleEntregable" = dent."iIdDetalleEntregable"','INNER');
      $this->db->where('av."iActivo"', 1);
      $this->db->where('av."iAprobado"', 1);
      $this->db->where('dent."iActivo"', 1);
      $this->db->where('dent.iIdEntregable', $iIdEntregable);
      $this->db->group_by('dent.iIdEntregable');

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;

   }

   public function carga_avances($mundid, $entregid, $anio, $mes = 0)   
   {            
      if($mes > 0) 
      {
         $this->db->select('mu.vMunicipio, count(distinct(dent."iIdEntregable")) as tot_ent, sum(av."nBeneficiariosH") as sum_benh, sum(av."nBeneficiariosM") as sum_benm, sum(av."nDiscapacitadosH") as sum_disch, sum(av."nDiscapacitadosM") as sum_discm, sum(av."nLenguaH") as sum_lenh, sum(av."nLenguaM") as sum_lenm');
         $this->db->where('EXTRACT(MONTH FROM av."dFecha") = '.$mes);
      }
      else
      {
         $this->db->select('mu.vMunicipio, count(distinct(dent."iIdEntregable")) as tot_ent, sum(av."nAvance") as sum_avance, sum(av."nBeneficiariosH") as sum_benh, sum(av."nBeneficiariosM") as sum_benm, sum(av."nDiscapacitadosH") as sum_disch, sum(av."nDiscapacitadosM") as sum_discm, sum(av."nLenguaH") as sum_lenh, sum(av."nLenguaM") as sum_lenm');
      }

      //$this->db->select('mu.vMunicipio, count(distinct(dent."iIdEntregable")) as tot_ent, sum(av."nAvance") as sum_avance, sum(av."nBeneficiariosH") as sum_benh, sum(av."nBeneficiariosM") as sum_benm, sum(av."nDiscapacitadosH") as sum_disch, sum(av."nDiscapacitadosM") as sum_discm, sum(av."nLenguaH") as sum_lenh, sum(av."nLenguaM") as sum_lenm');
      $this->db->from('Avance av');
      $this->db->join('Municipio mu','av.iMunicipio = mu.iIdMunicipio','INNER');
      $this->db->join('DetalleEntregable dent','av.iIdDetalleEntregable = dent.iIdDetalleEntregable','INNER');
      $this->db->where('dent.iIdEntregable',$entregid);
      $this->db->where('dent.iActivo', 1);                                 
      $this->db->where('EXTRACT(year FROM av."dFecha") = '.$anio);


      $this->db->where('mu.iIdMunicipio', $mundid);
      $this->db->where('av.iAprobado', 1);
      $this->db->where('av.iActivo', 1);
      $this->db->group_by('mu.vMunicipio');
      $this->db->order_by('mu.vMunicipio');
      
      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }

   public function generar($ejeid, $depid, $anio)
   {
      $this->db->select('ac.iIdActividad, dact.nAvance, ac.vActividad, dact.iAnio, dep.vDependencia, ej.vEje, ent.iIdEntregable, ent.vEntregable, dent.nMeta, dent.iIdDetalleEntregable, un.vUnidadMedida, sujaf.vSujetoAfectado,  per.vPeriodicidad, ent.iMunicipalizacion, ent.iMismosBeneficiarios');
      $this->db->from('PED2019Eje ej');
      $this->db->join('PED2019Tema tem','ej.iIdEje = tem.iIdEje','INNER');
      $this->db->join('PED2019Objetivo obj','tem.iIdTema = obj.iIdTema','INNER');
      $this->db->join('PED2019Estrategia est','obj.iIdObjetivo = est.iIdObjetivo','INNER');
      $this->db->join('PED2019LineaAccion lina','est.iIdEstrategia = lina.iIdEstrategia','INNER');
      $this->db->join('ActividadLineaAccion acla','lina.iIdLineaAccion = acla.iIdLineaAccion','LEFT');
      $this->db->join('Actividad ac','acla.iIdActividad = ac.iIdActividad','LEFT');
      $this->db->join('Dependencia dep','ac.iIdDependencia = dep.iIdDependencia','INNER');
      $this->db->join('DetalleActividad dact','ac.iIdActividad = dact.iIdActividad','LEFT');
      $this->db->join('DetalleEntregable dent','dact.iIdDetalleActividad = dent.iIdDetalleActividad','LEFT');
      $this->db->join('Entregable ent','dent.iIdEntregable = ent.iIdEntregable','INNER');
      $this->db->join('SujetoAfectado sujaf','ent.iIdSujetoAfectado = sujaf.iIdSujetoAfectado','INNER');
      $this->db->join('UnidadMedida un','ent.iIdUnidadMedida = un.iIdUnidadMedida','INNER');
      $this->db->join('Periodicidad per','ent.iIdPeriodicidad = per.iIdPeriodicidad','INNER');
      $this->db->order_by('ac.iIdActividad', 'ASC');
      
      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;      
   }

   /********************************************funciones para generar el reporte divididas**********************************************/
   

   public function carga_actividad($ejeid, $anio)
   {
      $this->db->select('act.iIdActividad, act.vActividad, dep.vDependencia, e.vEje, dact.nAvance, dact.iAnio, dent.nMeta, dent.iIdDetalleEntregable, ent.iIdEntregable, ent.vEntregable, ent.iIdUnidadMedida, ent.iIdPeriodicidad, ent.iMunicipalizacion, ent.iMismosBeneficiarios, ent.iIdSujetoAfectado');
      $this->db->from('Actividad act');
      $this->db->join('Dependencia dep','act.iIdDependencia = dep.iIdDependencia','INNER');
      $this->db->join('DetalleActividad dact','act.iIdActividad = dact.iIdActividad','INNER');
      $this->db->join('DetalleEntregable dent','dact.iIdDetalleActividad = dent.iIdDetalleActividad','LEFT');
      $this->db->join('Entregable ent','dent.iIdEntregable = ent.iIdEntregable','LEFT');
      $this->db->join('DependenciaEje de','dep.iIdDependencia = de.iIdDependencia','LEFT');
      $this->db->join('PED2019Eje e','de.iIdEje = e.iIdEje','LEFT');
         

      if($ejeid) $this->db->where('de.iIdEje', $ejeid);      
      if($anio) $this->db->where('dact.iAnio', $anio);

      $this->db->order_by('act.iIdActividad ASC, ent.iIdEntregable ASC');      

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }

   public function carga_cat($op, $id)
   {      
      switch ($op) {
         case 1:
            $this->db->select('vUnidadMedida');
            $this->db->from('UnidadMedida');
            $this->db->where('iIdUnidadMedida', $id);
            break;
         case 2:
              $this->db->select('vSujetoAfectado');
            $this->db->from('SujetoAfectado');
            $this->db->where('iIdSujetoAfectado', $id);
               break;
         case 3:
            $this->db->select('vPeriodicidad');
            $this->db->from('Periodicidad');
            $this->db->where('iIdPeriodicidad', $id);
            break;         
      }

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;
   }

   public function carga_avance($iIdDetalleEntregable)
   {
      $this->db->select('av.iIdDetalleEntregable, to_char(av."dFecha", \'MM\') as fecha, mun.vMunicipio , SUM(av."nAvance") as cant_avance, SUM(av."nEjercido") as cant_ejercido, SUM(av."nBeneficiariosH") as ben_h, SUM(av."nBeneficiariosM") as ben_m, SUM(av."nDiscapacitadosH") as disc_h, SUM(av."nDiscapacitadosM") as disc_m, SUM(av."nLenguaH") as len_h, SUM(av."nLenguaM") as len_m');
      $this->db->from('Avance av');
      $this->db->join('Municipio mun','av.iMunicipio = mun.iIdMunicipio','INNER');
      $this->db->where('av.iIdDetalleEntregable', $iIdDetalleEntregable);
      $this->db->group_by(array('av.iIdDetalleEntregable', 'fecha', 'mun.vMunicipio'));
      $this->db->order_by('av.iIdDetalleEntregable ASC, fecha ASC, mun.vMunicipio ASC');

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;      
   }

   public function tablaAnexo($eje=0)
   {
      $sql = 'SELECT DISTINCT ej."iIdEje", ej."vEje", tem."iIdEje", tem."iIdTema", act."iIdActividad", dep."vDependencia", act."vActividad", dact."iIdDetalleActividad", ent."iIdEntregable", ent."vEntregable", dact."iAnio", ent."iIdDependencia", ent."iMismosBeneficiarios", act."vNombreActividad", ent."vNombreEntregable", ent."iNumOds", dent."iAnexo", dent."iIdDetalleEntregable"
         from "PED2019Tema" tem
         INNER JOIN "PED2019Eje" ej ON ej."iIdEje" = tem."iIdEje"
         inner join "PED2019Objetivo" obj on tem."iIdTema" = obj."iIdTema"
         inner join "PED2019Estrategia" est on obj."iIdObjetivo" = est."iIdObjetivo"
         inner join "PED2019LineaAccion" la on est."iIdEstrategia" = la."iIdEstrategia"
         inner join "ActividadLineaAccion" ala on la."iIdLineaAccion" = ala."iIdLineaAccion"
         inner join "Actividad" act on ala."iIdActividad" = act."iIdActividad"
         INNER JOIN "Dependencia" dep ON dep."iIdDependencia" = act."iIdDependencia"
         inner join "DetalleActividad" dact on act."iIdActividad" = dact."iIdActividad" AND dact."iActivo" = 1
         inner join "DetalleEntregable" dent on dact."iIdDetalleActividad" = dent."iIdDetalleActividad" and dent."iActivo" = 1
         inner join "Entregable" ent on dent."iIdEntregable" = ent."iIdEntregable"
         where act."iActivo" = 1
         and dact."iAnio" = 2019
         and ent."iActivo" = 1
         and ent."iMunicipalizacion" = 1
         and dent."iAnexo" = 1
         AND ej."iIdEje" IN (3,4,5,6,7,8,9)';
      if($eje > 0 ) $sql.= ' AND ej."iIdEje" = '.$eje;
      $sql.= ' ORDER BY ej."iIdEje", act."vNombreActividad", ent."vNombreEntregable"';
      $query = $this->db->query($sql);
      //$_SESSION['sqlprincipal'] = $this->db->last_query();
      return $query;
   }


   public function idAnterior($idactividad,$identregable)
   {
      /*$sql = 'SELECT de."iIdDetalleEntregable" 
               FROM "DetalleActividad" da 
               INNER JOIN "DetalleEntregable" de ON de."iIdDetalleActividad" = da."iIdDetalleActividad" AND de."iActivo" = 1
               WHERE da."iActivo" =1 AND de."iIdEntregable" = '.$identregable.' AND da."iIdActividad" = '.$idactividad.' AND da."iAnio" = 2018 AND de."iAnexo" = 1';*/
      $sql = 'SELECT de."iIdDetalleEntregable" 
               FROM "DetalleActividad" da 
               INNER JOIN "DetalleEntregable" de ON de."iIdDetalleActividad" = da."iIdDetalleActividad" AND de."iActivo" = 1
               WHERE da."iActivo" =1 AND de."iIdEntregable" = '.$identregable.' AND da."iAnio" = 2018 AND de."iAnexo" = 1';
      $query = $this->db->query($sql);
      return $query;
   }

   function avancesMunicipio($iIdDetalleEntregable,$iIdMunicipio='',$dFecha='')
   {
      $sql = 'SELECT mun."iIdMunicipio", mun."vMunicipio", SUM(av."nAvance") avance, SUM(av."nBeneficiariosH") beneh, SUM(av."nBeneficiariosM") benem
               FROM "Avance" av
               INNER JOIN "Municipio" mun ON mun."iIdMunicipio" = av."iMunicipio"
               WHERE  av."iActivo" = 1 AND av."iAprobado" = 1  AND av."iIdDetalleEntregable" = '.$iIdDetalleEntregable;
      if($iIdMunicipio != '' && $dFecha != '')
      {
         $sql.= ' AND av."iMunicipio" = '.$iIdMunicipio.' AND av."dFecha" = \''.$dFecha.'\'';
      }
      
      $sql.= ' GROUP BY mun."iIdMunicipio", mun."vMunicipio"';
      $query = $this->db->query($sql);

      //$_SESSION['sql'] = $this->db->last_query();
      return $query;
   }

   function ultimoMes($iIdDetalleEntregable)
   {
      $sql = 'SELECT MAX(av."dFecha") "ultimoMes" FROM "Avance" av WHERE av."iActivo" = 1 AND av."iAprobado" = 1  AND av."iIdDetalleEntregable" = '.$iIdDetalleEntregable;
      $query = $this->db->query($sql)->row()->ultimoMes;

      return $query;
   }
   

   // Consutas para el anexo de obra
   public function vista_anexo($ejeid,$anio)
   {
      $this->ssop->select('*');
      $this->ssop->from('AnexoObra');
      $this->ssop->where('iIdEje', $ejeid);
      $this->ssop->where('iAnio <=', $anio);
      //$this->ssop->order_by('iAnio DESC, iIdEje ASC, vMunicipio ASC, vLocalidad ASC, vEstatus ASC, nCosto DESC, vNombreModificado ASC');
      $this->ssop->order_by('iIdEje ASC, iAnio ASC, vGrupo DESC, nCosto DESC, vNombreModificado ASC');

      return $this->ssop->get();
   }

   public function datos_eje($id)
   {
      $this->db->select();
      $this->db->from('PED2019Eje');
      $this->db->where('iIdEje',$id);

      return $this->db->get()->row();
   }

}                    