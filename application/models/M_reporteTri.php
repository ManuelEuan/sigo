<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class M_reporteTri extends CI_Model {


    function __construct(){
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
    }                      
    
    public function temas($id){
        $this->db->select();
        $this->db->from('"PED2019Tema"');
        $this->db->where('"iIdEje"',$id);

        $query = $this->db->get();

        $select= '<option value="0" class="selected">Todos</option>';
        foreach ($query->result() as $row)
        {
            $select .= '<option value="'.$row->iIdTema.'">'.$row->vTema.'</option>';
        }
        return $select;
    }

    public function objetivos($id){
        $this->db->select();
        $this->db->from('"PED2019Objetivo"');
        $this->db->where('"iIdTema"', $id);

        $query = $this->db->get();

        $select= '<option value="0" class="selected">Todos</option>';
        foreach ($query->result() as $row)
        {
            $select .= '<option value="'.$row->iIdObjetivo.'">'.$row->vObjetivo.'</option>';
        }
        return $select;
    }

    public function estrategias($id){
        $this->db->select();
        $this->db->from('"PED2019Estrategia"');
        $this->db->where('"iIdObjetivo"', $id);

        $query = $this->db->get();

        $select= '<option value="0" class="selected">Todos</option>';
        foreach ($query->result() as $row)
        {
            $select .= '<option value="'.$row->iIdEstrategia.'">'.$row->vEstrategia.'</option>';
        }
        return $select;
    }

    public function lineas($id){
        $this->db->select();
        $this->db->from('"PED2019LineaAccion"');
        $this->db->where('"iIdEstrategia"', $id);

        $query = $this->db->get();

        $select= '<option value="0" class="selected">Todos</option>';
        foreach ($query->result() as $row)
        {
            $select .= '<option value="'.$row->iIdLineaAccion.'">'.$row->vLineaAccion.'</option>';
        }
        return $select;
    }

    public function todosti($anio, $tin){
        $this->db->select('"vEje", "vTema", "PED2019Objetivo"."vObjetivo", "vEstrategia", "vLineaAccion", "vActividad", "'. $tin .'" as "tInforme"');
        $this->db->from('"PED2019Eje"');
        $this->db->join('"PED2019Tema"', '"PED2019Eje"."iIdEje" = "PED2019Tema"."iIdEje"', 'left outer');
        $this->db->join('"PED2019Objetivo"', '"PED2019Tema"."iIdTema" = "PED2019Objetivo"."iIdTema"', 'left outer');
        $this->db->join('"PED2019Estrategia"', '"PED2019Objetivo"."iIdObjetivo" = "PED2019Estrategia"."iIdObjetivo"', 'left outer');
        $this->db->join('"PED2019LineaAccion"', '"PED2019Estrategia"."iIdEstrategia" = "PED2019LineaAccion"."iIdEstrategia"', 'left outer');
        $this->db->join('"ActividadLineaAccion"', '"PED2019LineaAccion"."iIdLineaAccion" = "ActividadLineaAccion"."iIdLineaAccion"', 'left outer');
        $this->db->join('"Actividad"', '"ActividadLineaAccion"."iIdActividad" = "Actividad"."iIdActividad"', 'left outer');
        $this->db->join('"DetalleActividad"', '"Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"', 'left outer');
        $this->db->join('"Dependencia"', '"Actividad"."iIdDependencia" = "Dependencia"."iIdDependencia"', 'left outer');
        $this->db->where('"iAnio"', $anio);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $datos[] = [
                   'vEje'                   => $row->vEje,
                   'vTema' => $row->vTema,
                   'vObjetivo' => $row->vObjetivo,
                   'vEstrategia' => $row->vEstrategia,
                   'vLineaAccion' => $row->vLineaAccion,
                   'tInforme' => $row->tInforme,
                   'vActividad' => $row->vActividad
                 ];

             }
             return $datos;
        }else{
            return 'No hay datos';
        }
        
     
    }

    public function todostif($eje, $tema, $obj, $est, $la, $tin, $anio, $dep){
        $this->db->select('"vEje", "vTema", "PED2019Objetivo"."vObjetivo", "vEstrategia", "vLineaAccion", "vActividad", "'. $tin .'" as "tInforme"');
        $this->db->from('"PED2019Eje"');
        $this->db->join('"PED2019Tema"', '"PED2019Eje"."iIdEje" = "PED2019Tema"."iIdEje"', 'left outer');
        $this->db->join('"PED2019Objetivo"', '"PED2019Tema"."iIdTema" = "PED2019Objetivo"."iIdTema"', 'left outer');
        $this->db->join('"PED2019Estrategia"', '"PED2019Objetivo"."iIdObjetivo" = "PED2019Estrategia"."iIdObjetivo"', 'left outer');
        $this->db->join('"PED2019LineaAccion"', '"PED2019Estrategia"."iIdEstrategia" = "PED2019LineaAccion"."iIdEstrategia"', 'left outer');
        $this->db->join('"ActividadLineaAccion"', '"PED2019LineaAccion"."iIdLineaAccion" = "ActividadLineaAccion"."iIdLineaAccion"', 'left outer');
        $this->db->join('"Actividad"', '"ActividadLineaAccion"."iIdActividad" = "Actividad"."iIdActividad"', 'left outer');
        $this->db->join('"DetalleActividad"', '"Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"', 'left outer');
        $this->db->join('"Dependencia"', '"Actividad"."iIdDependencia" = "Dependencia"."iIdDependencia"', 'left outer');
        $this->db->where('"iAnio" ='. $anio .' and "PED2019Eje"."iIdEje" ='. $eje .' and "PED2019Tema"."iIdTema"  = '. $tema .' and "PED2019Objetivo"."iIdObjetivo" = '. $obj .' and "PED2019Estrategia"."iIdEstrategia"  = '. $est .' and "PED2019LineaAccion"."iIdLineaAccion"  = '. $la .' and "Dependencia"."iIdDependencia"  = '. $dep .'');
        $query = $this->db->get();

        if($query->num_rows() > 0){
        foreach ($query->result() as $row) {
        $datos[] = [
           'vEje'                   => $row->vEje,
           'vTema' => $row->vTema,
           'vObjetivo' => $row->vObjetivo,
           'vEstrategia' => $row->vEstrategia,
           'vLineaAccion' => $row->vLineaAccion,
           'tInforme' => $row->tInforme,
           'vActividad' => $row->vActividad
         ];
     }
     return $datos;
    }else{
        return 'No hay datos';
    }

    }

    public function todoseje($eje, $tin, $anio){
        $this->db->select('"vEje", "vTema", "PED2019Objetivo"."vObjetivo", "vEstrategia", "vLineaAccion", "vActividad", "'. $tin .'" as "tInforme"');
        $this->db->from('"PED2019Eje"');
        $this->db->join('"PED2019Tema"', '"PED2019Eje"."iIdEje" = "PED2019Tema"."iIdEje"', 'left outer');
        $this->db->join('"PED2019Objetivo"', '"PED2019Tema"."iIdTema" = "PED2019Objetivo"."iIdTema"', 'left outer');
        $this->db->join('"PED2019Estrategia"', '"PED2019Objetivo"."iIdObjetivo" = "PED2019Estrategia"."iIdObjetivo"', 'left outer');
        $this->db->join('"PED2019LineaAccion"', '"PED2019Estrategia"."iIdEstrategia" = "PED2019LineaAccion"."iIdEstrategia"', 'left outer');
        $this->db->join('"ActividadLineaAccion"', '"PED2019LineaAccion"."iIdLineaAccion" = "ActividadLineaAccion"."iIdLineaAccion"', 'left outer');
        $this->db->join('"Actividad"', '"ActividadLineaAccion"."iIdActividad" = "Actividad"."iIdActividad"', 'left outer');
        $this->db->join('"DetalleActividad"', '"Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"', 'left outer');
        $this->db->join('"Dependencia"', '"Actividad"."iIdDependencia" = "Dependencia"."iIdDependencia"', 'left outer');
        $this->db->where('"iAnio" ='. $anio .' and "PED2019Eje"."iIdEje" ='. $eje .'');
        $query = $this->db->get();

        if($query->num_rows() > 0){
        foreach ($query->result() as $row) {
        $datos[] = [
           'vEje'                   => $row->vEje,
           'vTema' => $row->vTema,
           'vObjetivo' => $row->vObjetivo,
           'vEstrategia' => $row->vEstrategia,
           'vLineaAccion' => $row->vLineaAccion,
           'tInforme' => $row->tInforme,
           'vActividad' => $row->vActividad
         ];
     }
     return $datos;
    }else{
        return 'No hay datos';
    }
    }

    public function todostema($eje, $tema, $tin, $anio){
        $this->db->select('"vEje", "vTema", "PED2019Objetivo"."vObjetivo", "vEstrategia", "vLineaAccion", "vActividad", "'. $tin .'" as "tInforme"');
        $this->db->from('"PED2019Eje"');
        $this->db->join('"PED2019Tema"', '"PED2019Eje"."iIdEje" = "PED2019Tema"."iIdEje"', 'left outer');
        $this->db->join('"PED2019Objetivo"', '"PED2019Tema"."iIdTema" = "PED2019Objetivo"."iIdTema"', 'left outer');
        $this->db->join('"PED2019Estrategia"', '"PED2019Objetivo"."iIdObjetivo" = "PED2019Estrategia"."iIdObjetivo"', 'left outer');
        $this->db->join('"PED2019LineaAccion"', '"PED2019Estrategia"."iIdEstrategia" = "PED2019LineaAccion"."iIdEstrategia"', 'left outer');
        $this->db->join('"ActividadLineaAccion"', '"PED2019LineaAccion"."iIdLineaAccion" = "ActividadLineaAccion"."iIdLineaAccion"', 'left outer');
        $this->db->join('"Actividad"', '"ActividadLineaAccion"."iIdActividad" = "Actividad"."iIdActividad"', 'left outer');
        $this->db->join('"DetalleActividad"', '"Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"', 'left outer');
        $this->db->join('"Dependencia"', '"Actividad"."iIdDependencia" = "Dependencia"."iIdDependencia"', 'left outer');
        $this->db->where('"iAnio" ='. $anio .' and "PED2019Eje"."iIdEje" ='. $eje .' and "PED2019Tema"."iIdTema"  = '. $tema .'');
        $query = $this->db->get();

        if($query->num_rows() > 0){
        foreach ($query->result() as $row) {
        $datos[] = [
           'vEje'                   => $row->vEje,
           'vTema' => $row->vTema,
           'vObjetivo' => $row->vObjetivo,
           'vEstrategia' => $row->vEstrategia,
           'vLineaAccion' => $row->vLineaAccion,
           'tInforme' => $row->tInforme,
           'vActividad' => $row->vActividad
         ];
     }
     return $datos;
     
}else{
    return 'No hay datos';
}
    }

    public function todosobj($eje, $tema, $obj, $tin, $anio){
        $this->db->select('"vEje", "vTema", "PED2019Objetivo"."vObjetivo", "vEstrategia", "vLineaAccion", "vActividad", "'. $tin .'" as "tInforme"');
        $this->db->from('"PED2019Eje"');
        $this->db->join('"PED2019Tema"', '"PED2019Eje"."iIdEje" = "PED2019Tema"."iIdEje"', 'left outer');
        $this->db->join('"PED2019Objetivo"', '"PED2019Tema"."iIdTema" = "PED2019Objetivo"."iIdTema"', 'left outer');
        $this->db->join('"PED2019Estrategia"', '"PED2019Objetivo"."iIdObjetivo" = "PED2019Estrategia"."iIdObjetivo"', 'left outer');
        $this->db->join('"PED2019LineaAccion"', '"PED2019Estrategia"."iIdEstrategia" = "PED2019LineaAccion"."iIdEstrategia"', 'left outer');
        $this->db->join('"ActividadLineaAccion"', '"PED2019LineaAccion"."iIdLineaAccion" = "ActividadLineaAccion"."iIdLineaAccion"', 'left outer');
        $this->db->join('"Actividad"', '"ActividadLineaAccion"."iIdActividad" = "Actividad"."iIdActividad"', 'left outer');
        $this->db->join('"DetalleActividad"', '"Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"', 'left outer');
        $this->db->join('"Dependencia"', '"Actividad"."iIdDependencia" = "Dependencia"."iIdDependencia"', 'left outer');
        $this->db->where('"iAnio" ='. $anio .' and "PED2019Eje"."iIdEje" ='. $eje .' and "PED2019Tema"."iIdTema"  = '. $tema .' and "PED2019Objetivo"."iIdObjetivo" = '. $obj .'');
        $query = $this->db->get();

        if($query->num_rows() > 0){
        foreach ($query->result() as $row) {
        $datos[] = [
           'vEje'                   => $row->vEje,
           'vTema' => $row->vTema,
           'vObjetivo' => $row->vObjetivo,
           'vEstrategia' => $row->vEstrategia,
           'vLineaAccion' => $row->vLineaAccion,
           'tInforme' => $row->tInforme,
           'vActividad' => $row->vActividad
         ];
     }
     return $datos;
     
}else{
    return 'No hay datos';
}
    }

    public function todosest($eje, $tema, $obj, $est, $tin, $anio){
        $this->db->select('"vEje", "vTema", "PED2019Objetivo"."vObjetivo", "vEstrategia", "vLineaAccion", "vActividad", "'. $tin .'" as "tInforme"');
        $this->db->from('"PED2019Eje"');
        $this->db->join('"PED2019Tema"', '"PED2019Eje"."iIdEje" = "PED2019Tema"."iIdEje"', 'left outer');
        $this->db->join('"PED2019Objetivo"', '"PED2019Tema"."iIdTema" = "PED2019Objetivo"."iIdTema"', 'left outer');
        $this->db->join('"PED2019Estrategia"', '"PED2019Objetivo"."iIdObjetivo" = "PED2019Estrategia"."iIdObjetivo"', 'left outer');
        $this->db->join('"PED2019LineaAccion"', '"PED2019Estrategia"."iIdEstrategia" = "PED2019LineaAccion"."iIdEstrategia"', 'left outer');
        $this->db->join('"ActividadLineaAccion"', '"PED2019LineaAccion"."iIdLineaAccion" = "ActividadLineaAccion"."iIdLineaAccion"', 'left outer');
        $this->db->join('"Actividad"', '"ActividadLineaAccion"."iIdActividad" = "Actividad"."iIdActividad"', 'left outer');
        $this->db->join('"DetalleActividad"', '"Actividad"."iIdActividad" = "DetalleActividad"."iIdActividad"', 'left outer');
        $this->db->join('"Dependencia"', '"Actividad"."iIdDependencia" = "Dependencia"."iIdDependencia"', 'left outer');
        $this->db->where('"iAnio" ='. $anio .' and "PED2019Eje"."iIdEje" ='. $eje .' and "PED2019Tema"."iIdTema"  = '. $tema .' and "PED2019Objetivo"."iIdObjetivo" = '. $obj .' and "PED2019Estrategia"."iIdEstrategia"  = '. $est .'');
        $query = $this->db->get();

        

if($query->num_rows() > 0){
    foreach ($query->result() as $row) {
        $datos[] = [
           'vEje'                   => $row->vEje,
           'vTema' => $row->vTema,
           'vObjetivo' => $row->vObjetivo,
           'vEstrategia' => $row->vEstrategia,
           'vLineaAccion' => $row->vLineaAccion,
           'tInforme' => $row->tInforme,
           'vActividad' => $row->vActividad
         ];
     }
     return $datos;
     
}else{
    return 'No hay datos';
}
    }

    public function todoslin($anio, $trim, $eje, $tema=0, $obj=0, $est=0, $la=0, $dep=0,$inactivas=0)
    {
        /*$this->db->select('ped."vEje", ped."vTema", ped."vObjetivo", ped."vEstrategia", ped."vLineaAccion"');
        $this->db->select('act."vActividad", dat."'. $trim .'" as "tInforme"');
        $this->db->from('"PED2019" ped');        
        $this->db->join('"DetalleActividadLineaAccion" dat', 'dat."iIdLineaAccion" = ped."iIdLineaAccion"', 'INNER');
        $this->db->join('"DetalleActividad" da', 'da."iIdDetalleActividad" = dat."iIdDetalleActividad" AND da."iActivo" = 1', 'INNER');
        $this->db->join('"Actividad" act', 'act."iIdActividad" = da."iIdActividad"', 'INNER');
        
        $this->db->join('"Dependencia" dep', 'dep."iIdDependencia" = act."iIdDependencia"', 'INNER');
        $this->db->where('da."iAnio" ='. $anio .' AND ped."iIdEje" ='. $eje);
        $this->db->order_by('ped.iIdTema ASC, ped.iIdObjetivo ASC, ped.iIdEstrategia ASC');
        if($tema > 0) $this->db->where('ped."iIdTema" ='. $tema);
        if($obj > 0) $this->db->where('ped."iIdObjetivo" ='. $obj);
        if($est > 0) $this->db->where('ped."iIdEstrategia" ='. $est);
        if($la > 0) $this->db->where('ped."iIdLineaAccion" ='. $la);
        if($dep > 0) $this->db->where('act."iIdDependencia" ='. $dep);
        $query = $this->db->get();*/

        $sql = 'SELECT "ped"."vEje", "ped"."vTema", "ped"."vObjetivo", "ped"."vEstrategia", "ped"."vLineaAccion", "act"."vActividad", sus.suspendida, "dat"."'.$trim.'" as "tInforme"
                FROM "PED2019" "ped"
                INNER JOIN "DetalleActividadLineaAccion" dat ON dat."iIdLineaAccion" = ped."iIdLineaAccion"
                INNER JOIN "DetalleActividad" "da" ON da."iIdDetalleActividad" = dat."iIdDetalleActividad" AND da."iActivo" = 1
                INNER JOIN "Actividad" "act" ON act."iIdActividad" = da."iIdActividad"
                INNER JOIN "Dependencia" "dep" ON dep."iIdDependencia" = act."iIdDependencia"
                INNER JOIN (SELECT da."iIdDetalleActividad",
                            CASE
                                WHEN COUNT(de."iIdDetalleEntregable") = SUM(de."iSuspension") THEN 1
                                ELSE 0
                            END 
                            AS suspendida
                            FROM "DetalleActividad" da
                            INNER JOIN "DetalleEntregable" de ON de."iIdDetalleActividad" = da."iIdDetalleActividad" AND de."iActivo" = 1
                            WHERE da."iActivo" = 1 
                            GROUP BY  da."iIdDetalleActividad") AS sus ON sus."iIdDetalleActividad" = da."iIdDetalleActividad"
                WHERE "da"."iAnio" = '.$anio.' AND "ped"."iIdEje" = '.$eje;
        if($tema > 0) $sql.= ' AND ped."iIdTema" = '. $tema;
        if($obj > 0) $sql.= ' AND ped."iIdObjetivo" = '. $obj;
        if($est > 0) $sql.= ' AND ped."iIdEstrategia" = '. $est;
        if($la > 0) $sql.= ' AND ped."iIdLineaAccion" = '. $la;
        if($dep > 0) $sql.= ' AND act."iIdDependencia" = '. $dep;
        if($inactivas > 0) $sql.= ' AND sus.suspendida = 0';

        $sql.= ' ORDER BY "ped"."iIdTema" ASC, "ped"."iIdObjetivo" ASC, "ped"."iIdEstrategia" ASC';

        $query = $this->db->query($sql);
        $_SESSION['sql'] = $this->db->last_query();

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) 
            {
                $datos[] = [
                   'vEje' => $row->vEje,
                   'vTema' => $row->vTema,
                   'vObjetivo' => $row->vObjetivo,
                   'vEstrategia' => $row->vEstrategia,
                   'vLineaAccion' => $row->vLineaAccion,
                   'tInforme' => $row->tInforme,
                   'vActividad' => $row->vActividad,
                   'suspendida' => $row->suspendida
                 ];
            }
            return $datos;
        }else{
            return 'No hay datos';
        }
    }
}
                        
/* End of file M_reporteTri.php */
    
                        