<?php
class M_componente extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->db = $this->load->database('default',TRUE);
		
	}
	function consultaArchivos($where,$tabla){
		//"count"(*) as "count"
		$this->db->select("COUNT(\"$tabla\".\"iIdEvidencia\")");
		//$this->db->select("count"."(*)". "as". "count");
		$this->db->from($tabla);
		//	$this->db->select_count('iIdEvidencia');
		// $this->db->order_by('iIdCompromiso');
		$this->db->where($where);
		$query = $this->db->get();
			foreach ($query->result() as $row) {
				$datos = $row->count;
			}
			return $datos;
	}
	function consultaPonderacion($iIdCompromiso){
		$where=array('iIdCompromiso'=>$iIdCompromiso, 'iActivo'=>1);
		$this->db->select_sum('nPonderacion');
		$this->db->from('Componente');
		// $this->db->order_by('iIdCompromiso');

		$this->db->where($where);
		$query = $this->db->get();
			foreach ($query->result() as $row) {
				$datos = $row->nPonderacion;
			}
			if ($datos=="")
			$datos=0;
			return $datos;
		}
	function porcentajeAvance($where){
		$this->db->select('*');
		$this->db->from('Componente');
		$this->db->where($where);
		$query = $this->db->get();
		$porcentaje=0;
		foreach ($query->result() as $row) {
		$porcentaje+= ($row->nPonderacion/100)*$row->nAvance;
		}
		$data=array("dPorcentajeAvance"=>$porcentaje);
		$this->db->update('Compromiso', $data, $where);
		
	}
	function listarubp($where){
		$this->db->select('*');
		$this->db->from('UBP u');
		if($where['iIdTipoUbp']!=0){ $this->db->where($where); }
		
		$this->db->order_by('u.vUBP');
		$query = $this->db->get();
			
			foreach ($query->result() as $row) {
				$datos[] = [
				'iIdUbp' =>$row->iIdUbp,
				'vUBP' => $row->vUBP
				];
			}
			return $datos;
	}
	// Modulo de UBP
	function agregarUbpComponente($data){
		$this->db->insert('ComponenteUBP', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
	}
	function eliminarUbpComponente($where){
		$this->db->delete('ComponenteUBP', $where); 
		if ($this->db->affected_rows() > 0)
		{
	  return TRUE;
		}
	else
		{
	  return FALSE;
		}
	}
	
	function insertarComponente($data){
		$this->db->insert('Componente', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
	}
	function updateComponente($data,$where){
		$this->db->where($where);
		$this->db->update('Componente', $data);
		if ($this->db->affected_rows() > 0)
		{
	  return TRUE;
		}
	else
		{
	  return FALSE;
		}
	}
	function updateEvidencia($data,$where){
		$this->db->where($where);
		$this->db->update('Evidencia', $data);
		if ($this->db->affected_rows() > 0)
		{
	  return TRUE;
		}
	else
		{
	  return FALSE;
		}
	}
	function eliminarComponente($where){
		$this->db->where($where);
		$this->db->update('Componente', array('iActivo'=>0));
		if ($this->db->affected_rows() > 0)
		{
	  return TRUE;
		}
	else
		{
	  return FALSE;
		}
	}
	function listado_componentes($where){
		$this->db->select('c.*, um.vUnidadMedida');
		$this->db->from('Componente c');
		$this->db->join('UnidadMedida um','c.iIdUnidadMedida = um.iIdUnidadMedida','INNER');

		$this->db->where($where);
		$this->db->order_by('iIdComponente');

		$query = $this->db->get();
		// foreach ($query->result() as $row) {
		// 		$datos[] = [
		// 			"iIdComponente" =>$row->iIdComponente,
		// 			"vComponente" =>$row->vComponente,
		// 			"vDescripcion" =>$row->vComponente,
		// 			"nPonderacion"=>$row->nPonderacion,
		// 			"nAvance" =>$row->nAvance,
		// 			"iIdCompromiso" =>$row->iIdCompromiso,
		// 			"iIdUnidadMedida" =>$row->iIdUnidadMedida,
		// 			"nMeta" =>$row->nMeta,
		// 			"iOrden" =>$row->iOrden,
		// 			"iActivo" =>$row->iActivo
		// 		];
		// 	}
			return $query;

	}
	function listado_ComponenteUBP($where){
		$this->db->select('*');
		$this->db->from('ComponenteUBP C');
		$this->db->join("UBP U","U.iIdUbp=C.iIdUbp");
		$this->db->where($where);

		$query = $this->db->get();
		return $query;

	}
	function listar_Estatus_evidencia($where){
		$this->db->select('*');
		$this->db->from('Estatus E');
		$this->db->order_by("vEstatus");
		//$this->db->join("Evidencia EV","EV.iEstatus=E.iIdEstatus");
		$this->db->where($where);
		$query = $this->db->get();
		return $query;
	}

	function listado_evidencia($where){
		$this->db->select('*');
		$this->db->from('Evidencia E');
	//	$this->db->join("UBP U","U.iIdUbp=C.iIdUbp");
		$this->db->where($where);
		$this->db->order_by('iIdEvidencia');

		$query = $this->db->get();
		return $query;

	}
	function add_files($data){
		$this->db->insert('Evidencia', $data);
	}

	function eliminar_evidencia($data,$where){
		$this->db->where($where);
		$this->db->update('Evidencia', $data);
		if ($this->db->affected_rows() > 0)
		{
	  return TRUE;
		}
	else
		{
	  return FALSE;
		}
	}
	function descargarEvidencia(){
		
	}
	
}
?>