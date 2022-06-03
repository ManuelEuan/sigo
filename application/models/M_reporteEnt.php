<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class M_reporteEnt extends CI_Model {

    function __construct(){
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
    }
    
    public function datos_entregable(){
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
      $this->db->join('UnidadMedida u','ent.iIdUnidadMedida = un.iIdUnidadMedida','INNER');
      $this->db->join('Periodicidad per','ent.iIdPeriodicidad = per.iIdPeriodicidad','INNER');
      $this->db->order_by('ac.iIdActividad', 'ASC');
      
      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;      
   }

   /********************************************funciones para generar el reporte divididas**********************************************/
   public function carga_actividad($ejeid = 0, $depid = 0, $anio = '',$where = array())
   {
      $this->db->select('act.iIdActividad, act.vActividad, dep.vDependencia, e.vEje, dact.nAvance, dact.iAnio, dent.nMeta, dent.nMetaModificada, dent.iIdDetalleEntregable, ent.iIdEntregable, ent.vEntregable, ent.iIdUnidadMedida, ent.iIdPeriodicidad, ent.iMunicipalizacion, ent.iMismosBeneficiarios, ent.iIdSujetoAfectado, dent.iSuspension');
      $this->db->select('um.vUnidadMedida, sa.vSujetoAfectado, per.vPeriodicidad');
      $this->db->select('dent."iAnexo", act."vNombreActividad", ent."vNombreEntregable", ent."iNumOds"');
      $this->db->from('Actividad act');
      $this->db->join('Dependencia dep','act.iIdDependencia = dep.iIdDependencia','INNER');
      $this->db->join('DetalleActividad dact','act.iIdActividad = dact.iIdActividad AND dact.iActivo = 1','INNER');
      $this->db->join('DetalleEntregable dent','dact.iIdDetalleActividad = dent.iIdDetalleActividad AND dent.iActivo = 1','LEFT');
      $this->db->join('Entregable ent','dent.iIdEntregable = ent.iIdEntregable AND ent.iActivo = 1','LEFT');
      $this->db->join('UnidadMedida um','um.iIdUnidadMedida = ent.iIdUnidadMedida','LEFT');
      $this->db->join('SujetoAfectado sa','sa.iIdSujetoAfectado = ent.iIdSujetoAfectado','LEFT');
      $this->db->join('Periodicidad per','per.iIdPeriodicidad = ent.iIdPeriodicidad','LEFT');
      $this->db->join('DependenciaEje de','dep.iIdDependencia = de.iIdDependencia','LEFT');
      $this->db->join('PED2019Eje e','de.iIdEje = e.iIdEje','LEFT');
      $this->db->where('act.iActivo',1);
         

      if($ejeid > 0) $this->db->where('de.iIdEje', $ejeid);
      if($depid > 0) $this->db->where('act.iIdDependencia', $depid);
      if($anio!='') $this->db->where('dact.iAnio', $anio);
      if(!empty($where)) {
			$this->db->where($where);
		};

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
      $this->db->join('Municipio mun','av.iMunicipio = mun.iIdMunicipio','LEFT OUTER');
      $this->db->where('av.iIdDetalleEntregable', $iIdDetalleEntregable);
      $this->db->where('av.iActivo',1);
      $this->db->where('av.iAprobado',1);
      $this->db->group_by(array('av.iIdDetalleEntregable', 'fecha', 'mun.vMunicipio'));
      $this->db->order_by('av.iIdDetalleEntregable ASC, fecha ASC, mun.vMunicipio ASC');

      $query = $this->db->get();
      if($query!=false) return $query->result();
      else return false;      
   }

}                    