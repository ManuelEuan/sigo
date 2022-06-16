<?php
class M_avances extends CI_Model
{
    
    function __construct()
	{
		parent::__construct();
        $this->db = $this->load->database('default',TRUE);
    }

    //Muestra la infromacion de la Actividad y el Entregable
    public function mostrar_actividadentregable($id_detent){

        $this->db->select('e.vEntregable,a.vActividad,e.iMunicipalizacion,de.iIdDetalleEntregable,da.iAnio, de.nMeta, de.nMetaModificada');
        $this->db->from('Entregable e');
        $this->db->join('DetalleEntregable de','e.iIdEntregable = de.iIdEntregable','JOIN');
        $this->db->join('DetalleActividad da','de.iIdDetalleActividad = da.iIdDetalleActividad','JOIN');
        $this->db->join('Actividad a','da.iIdActividad = a.iIdActividad','JOIN');
         $this->db->where('e.iActivo',1);
        $this->db->where('de.iIdDetalleEntregable',$id_detent);

        $query =  $this->db->get()->row();
        
        return $query;

    }

    //Obtiene la fecha del entregable
    public function obtener_avance_mes($mes,$id_detent,$acceso=''){

        $mont = "'MM'";
        
        $this->db->select();
        $this->db->from('Avance a');
        $this->db->join('Municipio m','a.iMunicipio = m.iIdMunicipio','LEFT OUTER');
        $this->db->where('to_char("dFecha",'.$mont.')', ''.$mes.'');
        $this->db->where('a.iIdDetalleEntregable', $id_detent);
        $this->db->where('a.iActivo', 1);
        $this->db->order_by('a.iAprobado DESC, m.vMunicipio ASC');

        //if($acceso != 'lectesc') $this->db->where('a.iAprobado', 1);

        $query =  $this->db->get();
        $resultado = $query->result();
        return $resultado;
    }

    //Guarda los avances en la DB
    public function guardado_general($table,$data){

        $this->db->insert($table, $data);
		return $this->db->insert_id();
    }

    //funcion de modificacion generica
    public function modificacion_general($where,$table,$data){

        $this->db->where($where);
		return $this->db->update($table, $data);
    }

    //Cambia de estatus activo a inactivo(Metoo de eliminacion)
	public function eliminacion_generica($where,$table,$data){

        $this->db->where($where);
		return $this->db->update($table,$data);
    }

    //Calcula la suma de avances por cada mes
    public function suma_avances_mensual($mes,$id_detent){

        $mont = "'MM'";
        
        $this->db->select('COALESCE(SUM("nAvance"),0) AS total_avance,
            COALESCE(SUM("nEjercido"),0) AS monto_total, 
            COALESCE((SUM("nBeneficiariosH") + SUM("nBeneficiariosM")),0) AS total_beneficiarios,
            COALESCE((SUM("nDiscapacitadosH") + SUM("nDiscapacitadosM")),0) AS total_discapacitados,
            COALESCE((SUM("nLenguaH") + SUM("nLenguaM")),0) AS total_mayahablantes,
            COALESCE((SUM("nTerceraEdadH") + SUM("nTerceraEdadM")),0) AS total_terceraedad,
            COALESCE((SUM("nAdolescenteH") + SUM("nAdolescenteH")),0) AS total_adolecentes');
        $this->db->from('Avance');
        $this->db->where('to_char("dFecha",'.$mont.')', ''.$mes.'');
        $this->db->where('iIdDetalleEntregable', $id_detent);
        $this->db->where('iActivo', 1);
        $this->db->where('iAprobado', 1);

        $query =  $this->db->get()->row();
        
        return $query;
    }

     public function suma_avances_mensual_desglosado($mes,$id_detent){

        $mont = "'MM'";
        
        $this->db->select('COALESCE(SUM("nAvance"),0) AS total_avance,
            COALESCE(avg("nEjercido"),0) AS monto_total, 
            COALESCE(SUM("nBeneficiariosH"),0) AS total_beneh, COALESCE(SUM("nBeneficiariosM"),0) AS total_benem,
            COALESCE(SUM("nDiscapacitadosH"),0) AS total_disch, COALESCE(SUM("nDiscapacitadosM"),0) AS total_discm,
            COALESCE(SUM("nLenguaH"),0) AS total_lengh, COALESCE(SUM("nLenguaM"),0) AS total_lengm,
            COALESCE(SUM("nTerceraEdadH"),0) AS total_tercerah, COALESCE(SUM("nTerceraEdadM"),0) AS total_terceram,
            COALESCE(SUM("nAdolescenteH"),0) AS total_adoleh, COALESCE(SUM("nAdolescenteM"),0) AS total_adolem');
        $this->db->from('Avance');
        $this->db->where('to_char("dFecha",'.$mont.')', ''.$mes.'');
        $this->db->where('iIdDetalleEntregable', $id_detent);
        $this->db->where('iActivo', 1);
        $this->db->where('iAprobado', 1);

        $query =  $this->db->get()->row();
        
        return $query;
    }

    //Calcula la suma de avances por cada entregable
    public function suma_avances_total($id_detent,$dFecha=''){
        
        $this->db->select('COALESCE(sum("nAvance"),0) AS total_avance, avg("nEjercido") AS monto_total, 
            COALESCE((sum("nBeneficiariosH") + sum("nBeneficiariosM")),0) AS total_beneficiarios, 
            COALESCE((sum("nDiscapacitadosH") + sum("nDiscapacitadosM")),0) AS total_discapacitados,
            COALESCE((sum("nLenguaH") + sum("nLenguaM")),0) AS total_mayahablantes,
            COALESCE((SUM("nTerceraEdadH") + SUM("nTerceraEdadM")),0) AS total_terceraedad,
            COALESCE((SUM("nAdolescenteH") + SUM("nAdolescenteM")),0) AS total_adolecentes');
        $this->db->from('Avance');
        $this->db->where('iIdDetalleEntregable', $id_detent);
        $this->db->where('iActivo', 1);
        $this->db->where('iAprobado', 1);
        if($dFecha != '') $this->db->where('dFecha', $dFecha);

        $query =  $this->db->get()->row();
        
        return $query;
    }

    public function Min_avance_total($id_detent,$dFecha=''){
        
        $this->db->select('COALESCE(sum("nAvance"),0) AS total_avance, MAX("nEjercido") AS monto_total, 
            COALESCE((sum("nBeneficiariosH") + sum("nBeneficiariosM")),0) AS total_beneficiarios, 
            COALESCE((sum("nDiscapacitadosH") + sum("nDiscapacitadosM")),0) AS total_discapacitados,
            COALESCE((sum("nLenguaH") + sum("nLenguaM")),0) AS total_mayahablantes,
            COALESCE((SUM("nTerceraEdadH") + SUM("nTerceraEdadM")),0) AS total_terceraedad,
            COALESCE((SUM("nAdolescenteH") + SUM("nAdolescenteM")),0) AS total_adolecentes');
        $this->db->from('Avance');
        $this->db->where('iIdDetalleEntregable', $id_detent);
        $this->db->where('iActivo', 1);
        $this->db->where('iAprobado', 1);
        if($dFecha != '') $this->db->where('dFecha', $dFecha);

        $query =  $this->db->get()->row();
        
        return $query;
    }

    //Obtiene el id del municipio seleccionado
    public function obtener_idmunicipio($municipio){

        $this->db->select('iIdMunicipio');
        $this->db->from('Municipio');
        $this->db->where("(\"vMunicipio\" ilike '%$municipio%')");

        $query =  $this->db->get()->row();
        
        return $query;
    }

     //Obtiene el id del municipio seleccionado
    public function obtener_idmunicipio_por_nombre($municipio){

        $this->db->select('iIdMunicipio');
        $this->db->from('Municipio');
        $this->db->where("(\"vMunicipio\" ilike '%$municipio%')");

        return $this->db->get();
    }

    //Obtiene la informacion de un determinado entregable
    public function detalle_entregable($id_detent,$id_detact){

        $this->db->select();
        $this->db->from('DetalleEntregable');
        $this->db->where('iIdDetalleActividad', $id_detact);
        $this->db->where('iActivo', 1);

        $query =  $this->db->get();

        $resultado = $query->result();
        return $resultado;

    }

    public function datos_mismos_beneficiarios($iIdDetalleEntregable)
    {
        $this->db->select('e.iMismosBeneficiarios, av.dFecha');
        $this->db->from('DetalleEntregable de');
        $this->db->join('Entregable e','e.iIdEntregable = de.iIdEntregable','INNER');
        $this->db->join('Avance av','av.iIdDetalleEntregable = de.iIdDetalleEntregable AND av.iActivo = 1  AND av.iAprobado = 1','LEFT OUTER');
        $this->db->where('de.iActivo',1);
        $this->db->where('de.iIdDetalleEntregable',$iIdDetalleEntregable);
        $this->db->order_by('av.dFecha','DESC');
        $this->db->limit(1);

        return $this->db->get()->row();
    }

    public function num_avances_no_aprobados($iIdDetalleEntregable)
    {
        $this->db->select('COUNT("iIdAvance") num');
        $this->db->from('Avance'); 
        $this->db->where('iAprobado',0);
        $this->db->where('iActivo',1);
        $this->db->where('iIdDetalleEntregable',$iIdDetalleEntregable);

        return $this->db->get()->row()->num;
    }

    public function registros_por_mes($iIdDetalleEntregable,$mes)
    {
        $sql = 'SELECT "iAprobado", COUNT("iIdAvance") AS num
                FROM "Avance"
                WHERE "iActivo" = 1 AND "iIdDetalleEntregable" = '.$iIdDetalleEntregable.' AND EXTRACT(MONTH FROM "dFecha") = '.$mes.'
                GROUP BY "iAprobado"
                ORDER BY "iAprobado" DESC';
        return $this->db->query($sql);
    }

    public function getActividad($idDetalle){
        $sql = 'SELECT * FROM "DetalleActividad" detAct
            INNER JOIN "Actividad" act on act."iIdActividad" = detAct."iIdActividad" 
			WHERE detAct."iIdDetalleActividad" = '.$idDetalle.'
			ORDER BY detAct."iIdActividad"';
            
		return $this->db->query($sql)->result();
    }

    //Agregado Saul Tun
    function obtenerDetalleId($id){
        $this->db->select('iIdEntregable');
        $this->db->from('DetalleEntregable');
        $this->db->where('iIdDetalleEntregable', $id);
        
        $query =  $this->db->get();
		$resultado = $query->row();
        return $resultado;
    }

    function obtenerVariables($id){

        $this->db->select();
        $this->db->from('VariableIndicador');
        $this->db->where('iIdEntregable', $id);

        $query =  $this->db->get();
		$resultado = $query->result();
        return $resultado;

    }

    function obtenerFormula($id){

        $this->db->select();
        $this->db->from('Entregable');
        $this->db->where('iIdEntregable', $id);

        $query =  $this->db->get();
		$resultado = $query->row();
        return $resultado;

    }

    public function insertarVariableAvance($tabla, $datos, $con=''){
		if($con == '') $con = $this->db;
		if($con->insert($tabla,$datos)) return true;
		else return false;
	}

    public function eliminarVariableAvance($id){
        $this->db->where('iIdAvance', $id);
		$this->db->delete('VariablesAvance');
		return true;
    }

    public function obtenerValoresVA($id){
        $this->db->select();
        $this->db->from('VariablesAvance');
        $this->db->where('iIdAvance', $id);

        $query =  $this->db->get();
		$resultado = $query->result();
        return $resultado;
    }

    public function obtenerIDEntregable($id){
        $this->db->select('iIdEntregable');
        $this->db->from('DetalleEntregable');
        $this->db->where('iIdDetalleEntregable', $id);

        $query =  $this->db->get();
		$resultado = $query->row();
        return $resultado;
    }

}
