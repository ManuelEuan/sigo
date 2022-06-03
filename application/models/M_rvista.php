<?php
class M_rvista extends CI_Model
{
    
    function __construct()
	{
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
    }

    public function vavances()
    {
    	$this->db->from('vavances');
    	return $this->db->get();
    }

    public function vcapdiaria()
    {
    	$this->db->from('vcapdiaria');
    	return $this->db->get();
    }

    public function vnocaptura()
    {
    	$this->db->from('vnocaptura');
    	return $this->db->get();
    }

    public function vultcapt()
    {
    	$this->db->from('vultcapt');
    	return $this->db->get();
    }

    public function ventact()
    {
        $this->db->select('act.iIdActividad, act.vActividad, act.vDescripcion, act.vObjetivo, ent.iIdEntregable, ent.vEntregable, ent.iMunicipalizacion, ent.iMismosBeneficiarios, eje.vEje, tem.vTema, dact.iAnio, dep.vDependencia');
        $this->db->from('Actividad act');
        $this->db->join('DetalleActividad dact','act.iIdActividad = dact.iIdActividad and dact."iActivo" = 1', 'INNER');
        $this->db->join('DetalleEntregable dent','dact.iIdDetalleActividad = dent.iIdDetalleActividad and dent."iActivo" = 1', 'INNER');
        $this->db->join('Entregable ent','dent.iIdEntregable = ent.iIdEntregable', 'INNER');
        $this->db->join('ActividadLineaAccion actl','act.iIdActividad = actl.iIdActividad', 'LEFT');
        $this->db->join('PED2019LineaAccion la','actl.iIdLineaAccion = la.iIdLineaAccion', 'LEFT');
        $this->db->join('PED2019Estrategia est','la.iIdEstrategia = est.iIdEstrategia', 'LEFT');
        $this->db->join('PED2019Objetivo obj','est.iIdObjetivo = obj.iIdObjetivo', 'LEFT');
        $this->db->join('PED2019Tema tem','obj.iIdTema = tem.iIdTema', 'LEFT');
        $this->db->join('PED2019Eje eje','tem.iIdEje = eje.iIdEje', 'LEFT');
        $this->db->join('Dependencia dep', 'act.iIdDependencia = dep.iIdDependencia', 'INNER');
        $this->db->where('act.iActivo', 1);
        $this->db->where('ent.iActivo', 1);
        $this->db->order_by('act."iIdActividad"');
      
        $query = $this->db->get();
        if($query!=false) return $query->result();
        else return false;
    }
}
?>