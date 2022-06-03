<?php

class M_compromisos extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);

    }

    /*	Funciones para usar transacciones
	======================================
	*/
    public function iniciar_transaccion()
    {
        $con = $this->load->database('default',TRUE);
        $con->trans_begin();
        return  $con;
    }

    public function terminar_transaccion($con)
    {
        if ($con->trans_status() === FALSE)
        {
            $con->trans_rollback();
            return false;
        }
        else
        {
            $con->trans_commit();
            return true;
        }
    }
    public function ActualizarPosicion_imagenes($where,$data,$con='')
    {
        if($con == '') $con = $this->db;
        $con->where('iIdEvidencia',$where);
        $con->update('Evidencia', $data);

    }
    public function insertar_compromiso_pag($tabla,$datos,$con='')
    {
        if($con == '') $con = $this->db;

        $con->insert($tabla,$datos);


    }
    public function insertar_componente_pag($tabla,$datos,$con)
    {
        if($con == '') $con = $this->db;

        $con->insert($tabla,$datos);


    }
    public function insertar_corresponsable_pag($tabla,$datos,$con)
    {
        if($con == '') $con = $this->db;

        $con->insert($tabla,$datos);


    }
    public function insertar_evidencia_pag($tabla,$datos,$con)
    {
        if($con == '') $con = $this->db;

        $con->insert($tabla,$datos);
    }
    
    public function Actualizar_compromiso_revisado( $where)
    {
        $data = [
            "iRevisado" => 0,

        ];
        $this->db->where($where);
        $this->db->update('Compromiso', $data);
    }
    public function ActualizarEvidencia( $where)
    {
        $data = [
            "iEstatus" => 3,

        ];
        $this->db->where($where);
        $this->db->update('Evidencia', $data);
    }
    public function eliminar_compromiso_pag($tabla,$where,$con)
    {
        $con->delete($tabla,$where);

    }
    function consultar_compromisos_pag($id_compromiso,$con){

        if($con == '') $con = $this->db;
        $con->select("*");
        $con->from('CompromisoPag');
        $con->where('iIdCompromiso',$id_compromiso);

        $query = $con->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $where = [
                    "iIdCompromiso" => $row->iIdCompromiso
                ];
                $where_revisado = [
                    "iRevisado" => 1
                ];
                $this->eliminar_compromiso_pag('CompromisoPag',$where,$con);
                $data=$this->recuperar_Copia_compromisos($con,$id_compromiso);

                $this->insertar_compromiso_pag('CompromisoPag',$data,$con);
                $this->Actualizar_compromiso_revisado($where_revisado);
                $this->recuperar_copia_componente('Componente',$id_compromiso,$con);
                $this->recuperar_copia_corresponsable('CompromisoCorresponsable',$id_compromiso,$con);


            }

        } else {
            $where_revisado = [
                "iRevisado" => 1
            ];
            $data=$this->recuperar_Copia_compromisos($con,$id_compromiso);
            $this->insertar_compromiso_pag('CompromisoPag',$data,$con);
            $this->Actualizar_compromiso_revisado($where_revisado);
            $this->recuperar_copia_componente('Componente',$id_compromiso,$con);
            $this->recuperar_copia_corresponsable('CompromisoCorresponsable',$id_compromiso,$con);


        }



    }
    function recuperar_copia_evidencia($tabla,$id_Componente,$con){

        $con->select('*');
        $con->from('Evidencia Evi');
        $con->where("Evi.iEstatus\"='2' or \"Evi.iEstatus\" = '3' and \"Evi.iIdComponente='$id_Componente'");

        $query = $con->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data =array (
                    "iIdEvidencia" => $row->iIdEvidencia,
                    "iIdComponente" => $row->iIdComponente,
                    "vEvidencia" => $row->vEvidencia,
                    "vTipo" => $row->vTipo,
                    "dFechaSubida" => $row->dFechaSubida,
                    "dFechaRevision" => $row->dFechaRevision,
                    "iFotoInicio" => $row->iFotoInicio,
                    "iOrdenFoto" => $row->iOrdenFoto,
                    "iIdUsuarioSube" => $row->iIdUsuarioSube,
                    "iIdUsuarioRevisa" => $row->iIdUsuarioRevisa



                );
                $this->insertar_evidencia_pag('EvidenciaPag',$data,$con);
                $where = [
                    "iEstatus" => 2
                ];
                $this->ActualizarEvidencia($where);


            }
        }
        /*else {
            //echo "sin valores";//ahora veo que hacer con este else
        }*/
    }
    function recuperar_copia_corresponsable($tabla,$id_compromiso,$con){
        $con->select('*');
        $con->from($tabla);
        $con->where('iIdCompromiso',$id_compromiso);


        $query = $con->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data =array (
                    "iIdCompromiso" => $row->iIdCompromiso,
                    "iIdDependencia" => $row->iIdDependencia



                );
                $this->insertar_corresponsable_pag('CompromisoCorresponsablePag',$data,$con);


            }
        }
        /*else {
            //echo "sin valores";//ahora veo que hacer con este else
        }*/
    }
    function recuperar_copia_componente($tabla,$id_compromiso,$con){
        $con->select('*');
        $con->from($tabla);
        $con->where("iActivo='1' and \"iIdCompromiso\"='$id_compromiso'");


        $query = $con->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data =array (
                    "iIdComponente" => $row->iIdComponente,
                    "vComponente" => $row->vComponente,
                    "vDescripcion" => $row->vDescripcion,
                    "nPonderacion" => $row->nPonderacion,
                    "nAvance" => $row->nAvance,
                    "iIdCompromiso" => $row->iIdCompromiso,
                    "iIdUnidadMedida" => $row->iIdUnidadMedida,
                    "nMeta" => $row->nMeta,
                    "iOrden" => $row->iOrden


                );
                $this->insertar_componente_pag('ComponentePag',$data,$con);
                $this->recuperar_copia_evidencia('Evidencia',$row->iIdComponente,$con);

            }
        }
        /*else {
            //echo "sin valores";//ahora veo que hacer con este else
        }*/
    }
    function recuperar_Copia_compromisos($con,$id_compromiso){
        $con->select('iIdCompromiso, vCompromiso, iNumero, iEstatus, dPorcentajeAvance, iIdDependencia, vFeNotarial, vNombreCorto, dUltimaAct, vDescripcion, iUltUsuarioAct, iIdTema,vAntes, vDespues');
        $con->from('Compromiso');
        $con->where('iIdCompromiso',$id_compromiso);


        $query = $con->get();
        foreach ($query->result() as $row) {
            $data =array (
                "iIdCompromiso" => $row->iIdCompromiso,
                "vCompromiso" => $row->vCompromiso,
                "iNumero" => $row->iNumero,
                "iEstatus" => $row->iEstatus,
                "dPorcentajeAvance" => $row->dPorcentajeAvance,
                "iIdDependencia" => $row->iIdDependencia,
                "vFeNotarial" => $row->vFeNotarial,
                "vNombreCorto" => $row->vNombreCorto,
                "dUltimaAct" => $row->dUltimaAct,
                "vDescripcion" => $row->vDescripcion,
                "iUltUsuarioAct" => $row->iUltUsuarioAct,
                "iIdTema" => $row->iIdTema,
                "vAntes" => $row->vAntes,
                "vDespues" => $row->vDespues

            );
        }
        return $data;
    }
    function iniciar_copiado_compromisos($tabla,$where,$con=''){

        if($con == '') $con = $this->db;
        $con->select('iIdCompromiso');
        $con->from($tabla);
        $con->where($where);

        $query = $con->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $this->consultar_compromisos_pag($row->iIdCompromiso,$con);
            }
        }
        // return $datos;


    }
    public function listar_galeria($id_Compromiso)//faltan ponerles atributos al array para marcar las fotos inicio
    {
        $this->db->select('Evi.iIdEvidencia,Evi.vEvidencia,Evi.iFotoInicio,Evi.iOrdenFoto');
        $this->db->from('Evidencia Evi');
        $this->db->join('Componente cpag', 'Evi.iIdComponente = cpag.iIdComponente', 'JOIN');
        $this->db->join('Compromiso compag', 'cpag.iIdCompromiso = compag.iIdCompromiso', 'JOIN');
        $this->db->where("Evi.iEstatus\"='3' and \"Evi.vTipo\"='Fotografía' and \"compag.iIdCompromiso\"='$id_Compromiso'");
        $this->db->order_by('Evi.iOrdenFoto', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $datos [] = [
                    'iIdEvidencia' => $row->iIdEvidencia,
                    'iFotoInicio' => $row->iFotoInicio,
                    'vEvidencia' => $row->vEvidencia,

                ];
            }
        } else {
            $datos = array();
        }
        return $datos;
    }
    // function normaliza($cadena){
    //     $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
    // ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    //     $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
    // bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    //     $cadena = utf8_decode($cadena);
    //     $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    //     $cadena = strtolower($cadena);
    //     return utf8_encode($cadena);
    // }
    function buscar_compromisos($where = '')
    {   
        $this->db->select('DISTINCT c."iIdCompromiso", c."vCompromiso", c."iNumero", c."dPorcentajeAvance", c."dUltimaAct" , e."vEstatus", d."vDependencia", c."iIdDependencia"',FALSE);
        $this->db->from('Compromiso c');
        $this->db->join('Estatus e','e.iIdEstatus = c.iEstatus');
        $this->db->join('Dependencia d','d.iIdDependencia = c.iIdDependencia');
        $this->db->join('DependenciaEje dej','dej.iIdDependencia = d.iIdDependencia');

        if (!empty($where) && $where != null && $where != '') {

            // $eje= $where["eje"];
            $palabra = isset($where["palabra"]) ? $where["palabra"]:"";
            if ($palabra == "") {
                $sqlPalabra = false;
            } else {
                $palabra = $where["palabra"];
				    $value = preg_match('/^(0|(-{0,1}[1-9]\d*))$/', trim($palabra));

				if ($value == 1){
				$sqlPalabra = "\"c\".\"iNumero\" = '$palabra'";
				}else{
                    // $palabra=$this->normaliza($palabra);
				 $sqlPalabra = "(lower(translate(\"c\".\"vCompromiso\",'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) ilike lower(translate('%$palabra%','áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')))";
				}
            }
            if ($dependencia = $where["dependencia"] <= 0) {
                $sqldependencia = false;
            } else {
                $dependencia = $dependencia = $where["dependencia"];
                $sqldependencia = "\"c\".\"iIdDependencia\"='$dependencia'";
            }
            if ($estatus = $where["estatus"] <= 0) {
                $sqlestatus = false;
            } else {
                $estatus = $where["estatus"];
                $sqlestatus = "\"e\".\"iIdEstatus\"='$estatus'";
            }
            if ($fecha = $where["fecha"] <= 0) {
                $sqlfecha = false;
            } else {
                $fecha = $where["fecha"];
                $sqlfecha = "date(\"c\".\"dUltimaAct\")='$fecha'";
                // $sqlfecha="c"."."."dUltimaAct:: DATE, dd/mm/yyyy =".$fecha;
            }
            if ($eje = $where["eje"] <= 0) {
                $sqleje = false;
            } else {
                $eje = $where["eje"];
                $sqleje = "\"dej\".\"iIdEje\"='$eje'";
                // $sqlfecha="c"."."."dUltimaAct:: DATE, dd/mm/yyyy =".$fecha;
            }


            $wheresql = "";
            if ($sqlPalabra != false) {
                $wheresql .= $sqlPalabra;
            }
            if ($sqldependencia != false) {
                if ($wheresql != "") {
                    $wheresql .= " and " . $sqldependencia;
                } else {
                    $wheresql .= $sqldependencia;
                }
            }
            if ($sqlestatus != false) {
                if ($wheresql != "") {
                    $wheresql .= " and " . $sqlestatus;
                } else {
                    $wheresql .= $sqlestatus;
                }
            }
            if ($sqlfecha != false) {
                if ($wheresql != "") {
                    $wheresql .= " and " . $sqlfecha;
                } else {
                    $wheresql .= $sqlfecha;
                }
            }
            if ($sqleje != false) {
                if ($wheresql != "") {
                    $wheresql .= " and " . $sqleje;
                } else {
                    $wheresql .= $sqleje;
                }
            }


        }
        //cambios para q sesuba al git
        if (!empty($wheresql) && $wheresql != null && $wheresql != '') {
            $this->db->where("($wheresql and c.iActivo=1 )");
        } else {
            $this->db->where('c.iActivo', 1);
        }
        $this->db->order_by('c.iNumero');
        $query = $this->db->get();
        // $resultado = $query->result();
        return $query;
    }

    function listarpp($ideje)
    {
        $this->db->select('pp.iIdTema as id, pp.vTema as tema');
        $this->db->from('PED2019Tema pp');
        if ($ideje > 0) {
            $this->db->where('pp.iIdEje', $ideje);
        }
        $this->db->order_by('pp.vTema');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $datos[] = [
                'iIdTema' => $row->id,
                'vTema' => $row->tema
            ];
        }
        return $datos;
    }

    function consulta_simple($datostabla, $tabla, $where, $tipo)
    {

        $this->db->select("*");
        $this->db->from($tabla);
        $this->db->where($where);
        $query = $this->db->get();
        if ($tipo == 0) {
            foreach ($query->result() as $row) {
                $dato = $row->$datostabla;
            }
        } else {
            if($query->num_rows()>0){
                foreach ($query->result() as $row) {
                    $dato[] = [$datostabla => $row->$datostabla];
                }
            }else{
                $dato[] =[];
            }

        }

        return $dato;

    }

    function listarcompromiso($id)
    {
        $this->db->select('*');
        $this->db->from('Compromiso c');

        $this->db->where("iIdCompromiso", $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $datos[] = [
                "iIdCompromiso" => $row->iIdCompromiso,
                "vCompromiso" => $row->vCompromiso,
                "iNumero" => $row->iNumero,
                "iRevisado" => $row->iRevisado,
                "dPorcentajeAvance" => $row->dPorcentajeAvance,
                "iIdDependencia" => $row->iIdDependencia,
                "vFeNotarial" => $row->vFeNotarial,
                "vNombreCorto" => $row->vNombreCorto,
                "dUltimaAct" => $row->dUltimaAct,
                "vDescripcion" => $row->vDescripcion,
                "iUltUsuarioAct" => $row->iUltUsuarioAct,
                "iUltUsuarioRev" => $row->iUltUsuarioRev,
                "iIdTema" => $row->iIdTema,
                "vAntes" => $row->vAntes,
                "vDespues" => $row->vDespues,
                "iActivo" => $row->iActivo,
                "vObservaciones" => $row->vObservaciones,
                "iEstatus" => $row->iEstatus,
                "iIdEje" => $this->consulta_simple("iIdEje", "PED2019Tema", ["iIdTema" => $row->iIdTema], 0),
                "iIdDependenciaCble" => $this->consulta_simple("iIdDependencia", "CompromisoCorresponsable", ["iIdCompromiso" => $row->iIdCompromiso], 1)
            ];
        }
        return $datos;
    }

    function listado_imagenes($where)
    {
        $this->db->select('*');
        $this->db->from('Evidencia e');
        $this->db->join('Componente c', 'c.iIdComponente = e.iIdComponente');
        $this->db->where($where);
        $this->db->order_by('iOrdenFoto');
        $query = $this->db->get();
        return $query;

    }

    function insertarCompromiso($data)
    {
        $this->db->insert('Compromiso', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function periodorevisionactivo()
    {
        $this->db->select('iActivo');
        $this->db->from('Parametro p');
        $this->db->where(["iIdParametro" => 1]);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $iActivo = $row->iActivo;
        }
        return $iActivo;
    }

    public function delete($where)
    {
        $this->db->where($where);
        $this->db->update('Compromiso', ['iActivo' => 0]);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    public function ActualizarCompromiso($data, $where)
    {
        $this->db->where($where);
        $this->db->update('Compromiso', $data);
    }

    function agregar_CompromisoCorresponsable($data)
    {
        $this->db->insert('CompromisoCorresponsable', $data);
    }

    function eliminar_CompromisoCorresponsable($where)
    {
        $this->db->delete('CompromisoCorresponsable', $where);
    }

    public function actualizarperiodo($data, $where)
    {
        $this->db->where($where);
        $this->db->update('Parametro', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    public function ActualizarIrevisado($data, $where)
    {
        $this->db->where($where);
        $this->db->update('Compromiso', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    public function ConsultarCompromisos($where)
    {
        $this->db->from('Compromiso');
        $this->db->where($where);

        return $query = $this->db->get();
    }
}

?>