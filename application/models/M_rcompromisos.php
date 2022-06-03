<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class M_rcompromisos extends CI_Model {

    function __construct(){
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
    }

    public function rcomSSBD($eje, $dep){
        $this->db->select('"iIdCompromiso", "iNumero", "vCompromiso", "Compromiso"."vNombreCorto", "vEje", "vTema", "vDependencia", "dPorcentajeAvance", "vAntes", "vDespues", "vFeNotarial", "vEstatus"');
        $this->db->from('"Compromiso"');
        $this->db->join('"PED2019Tema"', '"Compromiso"."iIdTema" = "PED2019Tema"."iIdTema"');
        $this->db->join('"PED2019Eje"', '"PED2019Tema"."iIdEje" = "PED2019Eje"."iIdEje"');
        $this->db->join('"DependenciaEje"', '"PED2019Eje"."iIdEje" = "DependenciaEje"."iIdEje"');
        $this->db->join('"Dependencia"', '"DependenciaEje"."iIdDependencia" = "Dependencia"."iIdDependencia"');
        $this->db->join('"Estatus"', '"Compromiso"."iEstatus" = "Estatus"."iIdEstatus"');
        $this->db->where('"PED2019Eje"."iIdEje" = '. $eje .' and "Dependencia"."iIdDependencia" = '. $dep .'');
        $this->db->order_by('iNumero', 'ASC');

        $query = $this->db->get();

        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $datos[] = [
                    'iIdCompromiso' => $row->iIdCompromiso,
                   'iNumero'                       => $row->iNumero,
                   'vCompromiso'                   => $row->vCompromiso,
                   'vNombreCorto' => $row->vNombreCorto,
                   'vEje' => $row->vEje,
                   'vTema' => $row->vTema,
                   'vDependencia' => $row->vDependencia,
                   'dPorcentajeAvance' => $row->dPorcentajeAvance,
                   'vAntes' => $row->vAntes,
                   'vDespues' => $row->vDespues,
                   'vFeNotarial' => $row->vFeNotarial,
                   'vEstatus' => $row->vEstatus
                 ];
             }
        }else{
            return 'no hay datos';
        }

        
     return $datos;
    }

    public function rcomSSBD2(){
        $this->db->select('"iIdCompromiso", "iNumero", "vCompromiso", "Compromiso"."vNombreCorto", "vEje", "vTema", "vDependencia", "dPorcentajeAvance", "vAntes", "vDespues", "vFeNotarial", "vEstatus"');
        $this->db->from('"Compromiso"');
        $this->db->join('"PED2019Tema"', '"Compromiso"."iIdTema" = "PED2019Tema"."iIdTema"');
        $this->db->join('"PED2019Eje"', '"PED2019Tema"."iIdEje" = "PED2019Eje"."iIdEje"');
        $this->db->join('"DependenciaEje"', '"PED2019Eje"."iIdEje" = "DependenciaEje"."iIdEje"');
        $this->db->join('"Estatus"', '"Compromiso"."iEstatus" = "Estatus"."iIdEstatus"');
        $this->db->join('"Dependencia"', '"DependenciaEje"."iIdDependencia" = "Dependencia"."iIdDependencia"');
        $this->db->order_by('iNumero', 'ASC');

        $query = $this->db->get();

        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $datos[] = [
                    'iIdCompromiso' => $row->iIdCompromiso,
                   'iNumero'                       => $row->iNumero,
                   'vCompromiso'                   => $row->vCompromiso,
                   'vNombreCorto' => $row->vNombreCorto,
                   'vEje' => $row->vEje,
                   'vTema' => $row->vTema,
                   'vDependencia' => $row->vDependencia,
                   'dPorcentajeAvance' => $row->dPorcentajeAvance,
                   'vAntes' => $row->vAntes,
                   'vDespues' => $row->vDespues,
                   'vFeNotarial' => $row->vFeNotarial,
                   'vEstatus' => $row->vEstatus
                 ];
             }
        }else{
            return 'no hay datos';
        }

        
     return $datos;
    }

    public function datosEX($id){
        $this->db->select('"Dependencia"."vDependencia" as "dependencia"');
        $this->db->from('"Dependencia"');
        $this->db->join('"CompromisoCorresponsable"','"Dependencia"."iIdDependencia" = "CompromisoCorresponsable"."iIdDependencia"');
        $this->db->join('"Compromiso"','"CompromisoCorresponsable"."iIdCompromiso" = "Compromiso"."iIdCompromiso"');
        $this->db->where('"Compromiso"."iIdCompromiso"',$id);
        

        $query = $this->db->get();

        $select= '';
        foreach ($query->result() as $row)
        {
            $select .= $row->dependencia.', ';
        }
        return $select;
    }

    public function rcomSCBD($eje, $dep){
        $this->db->select('"Compromiso"."iIdCompromiso", "iNumero", "vCompromiso", "Compromiso"."vNombreCorto", "vEje", "vTema", "vDependencia", "dPorcentajeAvance", "vAntes", "vDespues", "vFeNotarial", "vEstatus", "iIdComponente", "vComponente", "nPonderacion", "nAvance"');       
        $this->db->from('"Compromiso"');
        $this->db->join('"PED2019Tema"', '"Compromiso"."iIdTema" = "PED2019Tema"."iIdTema"');
        $this->db->join('"PED2019Eje"', '"PED2019Tema"."iIdEje" = "PED2019Eje"."iIdEje"');
        $this->db->join('"DependenciaEje"', '"PED2019Eje"."iIdEje" = "DependenciaEje"."iIdEje"');
        $this->db->join('"Dependencia"', '"DependenciaEje"."iIdDependencia" = "Dependencia"."iIdDependencia"');
        $this->db->join('"Estatus"', '"Compromiso"."iEstatus" = "Estatus"."iIdEstatus"');
        $this->db->join('"Componente"', '"Compromiso"."iIdCompromiso" = "Componente"."iIdCompromiso"', 'left outer');
        $this->db->where('"PED2019Eje"."iIdEje" = '. $eje .' and "Dependencia"."iIdDependencia" = '. $dep .'');
        $this->db->order_by('iNumero', 'ASC');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $datos[] = [
                    'iIdCompromiso' => $row->iIdCompromiso,
                   'iNumero'                       => $row->iNumero,
                   'vCompromiso'                   => $row->vCompromiso,
                   'vNombreCorto' => $row->vNombreCorto,
                   'vEje' => $row->vEje,
                   'vTema' => $row->vTema,
                   'vDependencia' => $row->vDependencia,
                   'dPorcentajeAvance' => $row->dPorcentajeAvance,
                   'vAntes' => $row->vAntes,
                   'vDespues' => $row->vDespues,
                   'vFeNotarial' => $row->vFeNotarial,
                   'vEstatus' => $row->vEstatus,
                   'iIdComponente' => $row->iIdComponente,
                   'vComponente' => $row->vComponente,
                   'nPonderacion' => $row->nPonderacion,
                   'nAvance' => $row->nAvance
                 ];
             }
        }else{
            return 'no hay datos';
        }
        
     return $datos;
    }


    public function rcomCABD($eje, $dep){
        $this->db->select('"Compromiso"."iIdCompromiso", "iNumero", "vCompromiso", "Compromiso"."vNombreCorto", "vEje", "vTema", "vDependencia", "dPorcentajeAvance", "vAntes", "vDespues", "vFeNotarial", "Estatus"."vEstatus", "Componente"."iIdComponente", "vComponente", "nPonderacion", "nAvance", "vEvidencia", "vTipo", "iFotoInicio"'); 
        $this->db->from('"Compromiso"');
        $this->db->join('"PED2019Tema"', '"Compromiso"."iIdTema" = "PED2019Tema"."iIdTema"');
        $this->db->join('"PED2019Eje"', '"PED2019Tema"."iIdEje" = "PED2019Eje"."iIdEje"');
        $this->db->join('"DependenciaEje"', '"PED2019Eje"."iIdEje" = "DependenciaEje"."iIdEje"');
        $this->db->join('"Dependencia"', '"DependenciaEje"."iIdDependencia" = "Dependencia"."iIdDependencia"');
        $this->db->join('"Estatus"', '"Compromiso"."iEstatus" = "Estatus"."iIdEstatus"');
        $this->db->join('"Componente"', '"Compromiso"."iIdCompromiso" = "Componente"."iIdCompromiso"', 'left outer');
        $this->db->join('"Evidencia"', '"Componente"."iIdComponente" = "Evidencia"."iIdComponente"', 'left outer');
        $this->db->where('"PED2019Eje"."iIdEje" = '. $eje .' and "Dependencia"."iIdDependencia" = '. $dep .'');
        $this->db->order_by('iNumero', 'ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $datos[] = [
                    'iIdCompromiso' => $row->iIdCompromiso,
                   'iNumero'                       => $row->iNumero,
                   'vCompromiso'                   => $row->vCompromiso,
                   'vNombreCorto' => $row->vNombreCorto,
                   'vEje' => $row->vEje,
                   'vTema' => $row->vTema,
                   'vDependencia' => $row->vDependencia,
                   'dPorcentajeAvance' => $row->dPorcentajeAvance,
                   'vAntes' => $row->vAntes,
                   'vDespues' => $row->vDespues,
                   'vFeNotarial' => $row->vFeNotarial,
                   'vEstatus' => $row->vEstatus,
                   'iIdComponente' => $row->iIdComponente,
                   'vComponente' => $row->vComponente,
                   'nPonderacion' => $row->nPonderacion,
                   'nAvance' => $row->nAvance,
                   'vEvidencia' => $row->vEvidencia,
                   'vTipo' => $row->vTipo,
                   'iFotoInicio' => $row->iFotoInicio
                 ];
             }
        }else{
            return 'no hay datos';
        }
     return $datos;
    }

    public function rcomCABD2(){
        $this->db->select('"Compromiso"."iIdCompromiso", "iNumero", "vCompromiso", "Compromiso"."vNombreCorto", "vEje", "vTema", "vDependencia", "dPorcentajeAvance", "vAntes", "vDespues", "vFeNotarial", "Estatus"."vEstatus", "Componente"."iIdComponente", "vComponente", "nPonderacion", "nAvance", "vEvidencia", "vTipo", "iFotoInicio"'); 
        $this->db->from('"Compromiso"');
        $this->db->join('"PED2019Tema"', '"Compromiso"."iIdTema" = "PED2019Tema"."iIdTema"');
        $this->db->join('"PED2019Eje"', '"PED2019Tema"."iIdEje" = "PED2019Eje"."iIdEje"');
        $this->db->join('"DependenciaEje"', '"PED2019Eje"."iIdEje" = "DependenciaEje"."iIdEje"');
        $this->db->join('"Dependencia"', '"DependenciaEje"."iIdDependencia" = "Dependencia"."iIdDependencia"');
        $this->db->join('"Estatus"', '"Compromiso"."iEstatus" = "Estatus"."iIdEstatus"');
        $this->db->join('"Componente"', '"Compromiso"."iIdCompromiso" = "Componente"."iIdCompromiso"', 'left outer');
        $this->db->join('"Evidencia"', '"Componente"."iIdComponente" = "Evidencia"."iIdComponente"', 'left outer');
        
    $this->db->order_by('iNumero', 'ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $datos[] = [
                    'iIdCompromiso' => $row->iIdCompromiso,
                   'iNumero'                       => $row->iNumero,
                   'vCompromiso'                   => $row->vCompromiso,
                   'vNombreCorto' => $row->vNombreCorto,
                   'vEje' => $row->vEje,
                   'vTema' => $row->vTema,
                   'vDependencia' => $row->vDependencia,
                   'dPorcentajeAvance' => $row->dPorcentajeAvance,
                   'vAntes' => $row->vAntes,
                   'vDespues' => $row->vDespues,
                   'vFeNotarial' => $row->vFeNotarial,
                   'vEstatus' => $row->vEstatus,
                   'iIdComponente' => $row->iIdComponente,
                   'vComponente' => $row->vComponente,
                   'nPonderacion' => $row->nPonderacion,
                   'nAvance' => $row->nAvance,
                   'vEvidencia' => $row->vEvidencia,
                   'vTipo' => $row->vTipo,
                   'iFotoInicio' => $row->iFotoInicio
                 ];
             }
        }else{
            return 'no hay datos';
        }
     return $datos;
    }

    public function contador($eje, $dep){
        $this->db->select('count(*) as contador'); 
        $this->db->from('"Compromiso"');
        $this->db->join('"PED2019Tema"', '"Compromiso"."iIdTema" = "PED2019Tema"."iIdTema"');
        $this->db->join('"PED2019Eje"', '"PED2019Tema"."iIdEje" = "PED2019Eje"."iIdEje"');
        $this->db->join('"DependenciaEje"', '"PED2019Eje"."iIdEje" = "DependenciaEje"."iIdEje"');
        $this->db->join('"Dependencia"', '"DependenciaEje"."iIdDependencia" = "Dependencia"."iIdDependencia"');
        $this->db->join('"Estatus"', '"Compromiso"."iEstatus" = "Estatus"."iIdEstatus"');
        $this->db->join('"Componente"', '"Compromiso"."iIdCompromiso" = "Componente"."iIdCompromiso"', 'left outer');
        $this->db->join('"Evidencia"', '"Componente"."iIdComponente" = "Evidencia"."iIdComponente"', 'left outer');
        $this->db->where('"PED2019Eje"."iIdEje" = '. $eje .' and "Dependencia"."iIdDependencia" = '. $dep .'');
        return $this->db->get()->row()->contador;
    }

    public function contador2(){
        $this->db->select('count(*) as contador'); 
        $this->db->from('"Compromiso"');
        $this->db->join('"PED2019Tema"', '"Compromiso"."iIdTema" = "PED2019Tema"."iIdTema"');
        $this->db->join('"PED2019Eje"', '"PED2019Tema"."iIdEje" = "PED2019Eje"."iIdEje"');
        $this->db->join('"DependenciaEje"', '"PED2019Eje"."iIdEje" = "DependenciaEje"."iIdEje"');
        $this->db->join('"Dependencia"', '"DependenciaEje"."iIdDependencia" = "Dependencia"."iIdDependencia"');
        $this->db->join('"Estatus"', '"Compromiso"."iEstatus" = "Estatus"."iIdEstatus"');
        $this->db->join('"Componente"', '"Compromiso"."iIdCompromiso" = "Componente"."iIdCompromiso"', 'left outer');
        $this->db->join('"Evidencia"', '"Componente"."iIdComponente" = "Evidencia"."iIdComponente"', 'left outer');
        
        return $this->db->get()->row()->contador;
    }


    public function celdascombinadas1($eje, $dep){
        $this->db->select('"Compromiso"."iIdCompromiso", "iNumero", "vCompromiso", "Compromiso"."vNombreCorto", "vEje", "vTema", "vDependencia", "dPorcentajeAvance", "vAntes", "vDespues", "vFeNotarial", "vEstatus"');        
        $this->db->from('"Compromiso"');
        $this->db->join('"PED2019Tema"', '"Compromiso"."iIdTema" = "PED2019Tema"."iIdTema"');
        $this->db->join('"PED2019Eje"', '"PED2019Tema"."iIdEje" = "PED2019Eje"."iIdEje"');
        $this->db->join('"DependenciaEje"', '"PED2019Eje"."iIdEje" = "DependenciaEje"."iIdEje"');
        $this->db->join('"Dependencia"', '"DependenciaEje"."iIdDependencia" = "Dependencia"."iIdDependencia"');
        $this->db->join('"Estatus"', '"Compromiso"."iEstatus" = "Estatus"."iIdEstatus"');
        $this->db->join('"Componente"', '"Compromiso"."iIdCompromiso" = "Componente"."iIdCompromiso"', 'left outer');
        $this->db->where('"PED2019Eje"."iIdEje" = '. $eje .' and "Dependencia"."iIdDependencia" = '. $dep .'');
    $this->db->order_by('iNumero', 'ASC');
        $query = $this->db->get();

        if($query->num_rows()  > 0){
            foreach ($query->result() as $row) {
        $datos[] = [
            'iIdCompromiso' => $row->iIdCompromiso,
           'iNumero'                       => $row->iNumero,
           'vCompromiso'                   => $row->vCompromiso,
           'vNombreCorto' => $row->vNombreCorto,
           'vEje' => $row->vEje,
           'vTema' => $row->vTema,
           'vDependencia' => $row->vDependencia,
           'dPorcentajeAvance' => $row->dPorcentajeAvance,
           'vAntes' => $row->vAntes,
           'vDespues' => $row->vDespues,
           'vFeNotarial' => $row->vFeNotarial,
           'vEstatus' => $row->vEstatus,
         ];
     }
     return $datos;
      }else{
            return 0;
      }
    }

    /*public function cceldascombinadas1($id){
        $this->db->select('Count(*) as "count"');        
        $this->db->from('"Compromiso"');
        $this->db->where('iIdCompromiso', $id);
        $this->db->order_by('iNumero', 'ASC');
        

        return $this->db->get()->row()->count;



       
    }*/

    public function componentes(){
        $this->db->select('');
        $this->db->from('');
        $this->db->join('');
        $this->db->where('');
    }
                                        
}
                        
/* End of file M_rcompromisos.php */
    
                        