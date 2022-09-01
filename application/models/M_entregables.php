<?php

class M_entregables extends CI_Model{

    private $table = 'Entregable';
	private $idF = 'iIdEntregable';

    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default',TRUE);
    }

    /* Mostrar Ejes */
	public function mostrarEje()
	{
		$this->db->order_by('vEje', 'asc');
		$this->db->select();
		$this->db->from('PED2019Eje');

		$query = $this->db->get();
		$resultado = $query->result();
		return $resultado;
	}

    /* Modificar datos */

	public function preparar_update($id)
	{
		$sql = 'SELECT * FROM "DetalleActividad" detAct
            INNER JOIN "Actividad" act on act."iIdActividad" = detAct."iIdActividad" 
			INNER JOIN "Dependencia" d on d."iIdDependencia" = act."iIdDependencia" 
			INNER JOIN "DependenciaEje" de on de."iIdDependencia" = d."iIdDependencia"  
			WHERE detAct."iIdDetalleActividad" = '.$id.'
			LIMIT 1';
            
		return $this->db->query($sql)->result();

	}

    //Muestra todos los entregables
	public function mostrar_entregables($id)
	{              
        $this->db->select();
        $this->db->from('Entregable e');
        $this->db->join('UnidadMedida um','e.iIdUnidadMedida = um.iIdUnidadMedida','JOIN');
        $this->db->join('Periodicidad p','e.iIdPeriodicidad = p.iIdPeriodicidad','JOIN');
        $this->db->join('SujetoAfectado sa','e.iIdSujetoAfectado = sa.iIdSujetoAfectado','JOIN');
        $this->db->join('DetalleEntregable de','e.iIdEntregable = de.iIdEntregable','JOIN');
        $this->db->join('DetalleActividad da','de.iIdDetalleActividad = da.iIdDetalleActividad','JOIN');
        $this->db->where('e.iActivo', 1);
        $this->db->where('de.iActivo', 1);
        $this->db->where('da.iIdDetalleActividad', $id);
        $this->db->order_by('e.vEntregable');	

		$query =  $this->db->get();
        
        $resultado = $query->result();
        return $resultado;
    }

    public function mostrar_entregables_municipio($id)
    {              
        $this->db->select('a.*');
        $this->db->from('EntregableMunicipio a');
        $this->db->where('a.iIdEntregable', $id);

        $query =  $this->db->get();
        
        $resultado = $query->result();
        return $resultado;
    }

    public function eliminar_entregablemunicipios($id_ent){

        $this->db->where('iIdEntregable' ,  $id_ent );
        if($this->db->delete('EntregableMunicipio')){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    //Guarda el entregable y el detalle entregable en la DB
    public function guardado_general($table,$data){

        $this->db->insert($table, $data);
		return $this->db->insert_id();
    }

    //Guarda el entregable con municipio en la DB
    public function guardar_entregablemunicipio($table,$data){

        return $this->db->insert($table, $data);
    }

    //Guarda el Entregable alinado a un Componente en la DB
    public function guardar_entregablecomponente($table,$data){

        return $this->db->insert($table, $data);
    }

    //Muestra la ponderacion mas alta del DetalleEntregable
    public function mostrar_detalleentregable($id_detalleactividad){

        $this->db->select();
        $this->db->from('DetalleEntregable de');
        $this->db->join('DetalleActividad da','de.iIdDetalleActividad = da.iIdDetalleActividad','JOIN');
        $this->db->where('de.iActivo', 1);
        $this->db->where('de.iIdDetalleActividad', $id_detalleactividad);
        $this->db->order_by('iPonderacion', 'DESC');
        $this->db->limit(1);			

		$query =  $this->db->get()->row();
        
        return $query;

    }

    //funcion de modificacion generica
    public function modificacion_general($where,$table,$data){

        $this->db->where($where);
		return $this->db->update($table, $data);
    }

    //Modifica la informacion de la tabla entregable y DetalleEntregable
    public function modificar_detalleentregable($id,$data){

        $this->db->where('iIdDetalleEntregable', $id);
		return $this->db->update('DetalleEntregable', $data);
    }

    //Obtiene el id de la tabla DetalleEntregable
    public function obtener_id_detallentregable($id_ent){

        $this->db->select();
        $this->db->from('DetalleEntregable de');
        $this->db->where('de.iIdEntregable', $id_ent);

        $query =  $this->db->get()->row();
        
        return $query;

    }

    //Muestra la ponderacion del entregable actual
    public function mostrar_ponderacion_actual($id_detent){

        $this->db->select();
        $this->db->from('DetalleEntregable de');
        $this->db->join('Entregable e','de.iIdEntregable = e.iIdEntregable','JOIN');
        $this->db->join('UnidadMedida um','e.iIdUnidadMedida = um.iIdUnidadMedida','JOIN');
        $this->db->where('de.iActivo', 1);
        $this->db->where('de.iIdDetalleEntregable', $id_detent);
        $this->db->limit(1);			

		$query =  $this->db->get()->row();
        
        return $query;

    }

    //Muestra la ponderacion de los entregables
    public function mostrar_ponderaciones($id_detact,$identregableactual=''){

        $this->db->select();
        $this->db->from('DetalleEntregable de');
        $this->db->join('Entregable e','de.iIdEntregable = e.iIdEntregable','JOIN');
        $this->db->join('UnidadMedida um','e.iIdUnidadMedida = um.iIdUnidadMedida','JOIN');
        $this->db->where('de.iActivo', 1);
        $this->db->where('de.iIdDetalleActividad', $id_detact);
        $this->db->order_by('e.vEntregable','ASC');

        if($identregableactual != ''){
            $this->db->where('de.iIdDetalleEntregable !=', $identregableactual);
        }
        
        $query =  $this->db->get();

        $resultado = $query->result();
        return $resultado;
    }

    //Calcula el total de las ponderaciones
    public function total_ponderaciones($id_detact){

        $this->db->select_sum('iPonderacion');
        $this->db->from('DetalleEntregable de');
        $this->db->where('de.iIdDetalleActividad',$id_detact);
    }

    //Muestra los municipios
    public function mostrar_municipios(){

        $this->db->select();
        $this->db->from('Municipio m');
        
        $query =  $this->db->get();

        $resultado = $query->result();
        return $resultado;
    }

    //Muestra el entregable actual
    public function mostrar_entregable_actual($id_entregable, $id_detact){

        $this->db->select();
        $this->db->from('Entregable e');
        $this->db->join('DetalleEntregable de','e.iIdEntregable = de.iIdEntregable','JOIN');
        $this->db->join('UnidadMedida um','e.iIdUnidadMedida = um.iIdUnidadMedida','JOIN');
        $this->db->where('e.iIdEntregable',$id_entregable);   
        $this->db->where('de.iIdDetalleActividad',$id_detact);    

        $query =  $this->db->get()->row();
        
        return $query;

    }

    public function obtenerAntes($id_entregable, $id_detact){
        $sql = 'SELECT e."vEntregable", e."iIdPeriodicidad", e."vNombreEntregable", e."iIdFormaInd", e."iIdDimensionInd", e."nLineaBase", e."vMedioVerifica", e."vFormula", e."iAcumulativo", e."iAutorizado", e."iIdSujetoAfectado", e."iIdUnidadMedida", e."iMunicipalizacion", e."iMismosBeneficiarios", de."nMeta", de."nMetaModificada", de."dFechaInicio", de."dFechaFin", de."iAnexo", de."iAutorizado" FROM "Entregable" as e
        INNER JOIN "DetalleEntregable" as de ON e."iIdEntregable" = de."iIdEntregable"
        INNER JOIN "UnidadMedida" as um ON e."iIdUnidadMedida" = um."iIdUnidadMedida"
        WHERE e."iIdEntregable" = '.$id_entregable.' AND de."iIdDetalleActividad" = '.$id_detact;
        return $this->db->query($sql)->result();

    }

    //Muestra las metas de los entregables por municipios
    public function mostrar_metas_municipios($id_mun,$id_detent){

        $this->db->select('dem.*');
        $this->db->from('DetalleEntregableMetaMunicipio dem');
        $this->db->join('Municipio m','dem.iIdMunicipio = m.iIdMunicipio','JOIN');
        $this->db->join('DetalleEntregable de','de.iIdDetalleEntregable = dem.iIdDetalleEntregable','JOIN');
        $this->db->where('dem.iIdMunicipio',$id_mun);
        $this->db->where('dem.iIdDetalleEntregable',$id_detent);    

        $query =  $this->db->get()->row();
        
        return $query;

    }

    //Muestra los entregables alineados a un componente de compromiso
    public function mostrar_entregablecomponente($id_ent){

        $this->db->select();
        $this->db->from('EntregableComponente ec');
        $this->db->where('ec.iIdEntregable',$id_ent);

        $query =  $this->db->get()->row();
        
        return $query;
    }

    //mostrar todos los entregables y los componentes
    public function mostrar_entregablecompromiso($id){

        $this->db->select();
        $this->db->from('Entregable e');
        $this->db->join('EntregableComponente ec','ec.iIdEntregable = e.iIdEntregable','LEFT OUTER');
        $this->db->join('Componente c','ec.iIdComponente = c.iIdComponente','LEFT OUTER');
        $this->db->join('Compromiso cp','c.iIdCompromiso = cp.iIdCompromiso','LEFT OUTER');
        $this->db->join('DetalleEntregable de','e.iIdEntregable = de.iIdEntregable','JOIN');
        $this->db->join('DetalleActividad da','de.iIdDetalleActividad = da.iIdDetalleActividad','JOIN');
        $this->db->where('e.iActivo',1);
        $this->db->where('da.iIdDetalleActividad', $id);
        
        $query =  $this->db->get();

        $resultado = $query->result();
        return $resultado;

    }

    //Mostrar compromisos y componentes
    public function mostrar_componentescompromiso($id_ent){
        
        $this->db->select('ec.iIdEntregable,c2.vCompromiso,c2.iIdCompromiso,c.vComponente,c.iIdComponente');
        $this->db->from('Componente c');
        $this->db->join('EntregableComponente ec','c.iIdComponente = ec.iIdComponente','JOIN');
        $this->db->join('Compromiso c2','c.iIdCompromiso = c2.iIdCompromiso','JOIN');
        $this->db->where('ec.iIdEntregable',$id_ent);

        $query =  $this->db->get()->row();
        
        return $query;
    }

    //Muestra los entregables alineados a un componente de compromiso
    public function validar_entregablemunicipio($id_detent){

        $this->db->select();
        $this->db->from('DetalleEntregableMetaMunicipio dem');
        $this->db->where('dem.iIdDetalleEntregable',$id_detent);

        $query =  $this->db->get();

        $resultado = $query->result();
        return $resultado;
    }

    //Elimina los entregables por municipio de determinado entregable
    public function eliminar_entregablemunicipio($id){
       
        $this->db->where('iIdDetalleEntregable' ,  $id );
        if($this->db->delete('DetalleEntregableMetaMunicipio')){
            return TRUE;
        }else{
            return FALSE;
        }
        
    }

    //Elimina la informacion de la tabla EntregableComponente
    public function eliminar_compromiso($id_ent){

        $this->db->where('iIdEntregable' ,  $id_ent );
        if($this->db->delete('EntregableComponente')){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    //Cambia de estatus activo a inactivo(Metoo de eliminacion)
	public function eliminacion_generica($where,$table,$data){

        $this->db->where($where);
		return $this->db->update($table,$data);
    }

    //Calcula la suma de avances por cada entregable
    public function suma_avances_total($id_detent){
        
        $this->db->select('sum("nAvance") as total_avance');
        $this->db->from('Avance');
        $this->db->where('iIdDetalleEntregable', $id_detent);
        $this->db->where('iActivo', 1);
        $this->db->where('iAprobado', 1);

        $query =  $this->db->get()->row();
        
        return $query;
    }

    //Obtiene la informacion de un determinado entregable
    public function detalle_entregable($id_detact,$where='')
    {
        $this->db->select();
        $this->db->from('DetalleEntregable');
        $this->db->where('iIdDetalleActividad', $id_detact);
        $this->db->where('iActivo', 1);

        if(!empty($where)) $this->db->where($where);

        $query =  $this->db->get();

        $resultado = $query->result();
        return $resultado;
    }

    public function mostrar_compromisos(){

        $this->db->select();
		$this->db->from('Compromiso');
		$this->db->where('iActivo',1);
		$this->db->order_by('iNumero');
        $query =  $this->db->get();
		$resultado = $query->result();
        return $resultado;
    }

    public function nombre_actividad($id)
    {
        $this->db->select('act.vActividad');
        $this->db->from('Actividad act');
        $this->db->join('DetalleActividad da','da.iIdActividad = act.iIdActividad','INNER');
        $this->db->where('da.iIdDetalleActividad',$id);

        return $this->db->get()->row()->vActividad;
    }

    public function entregables($keyword,$where = '')
    {
        $this->db->select('eje.vEje, dep.vDependencia, ent.iIdEntregable, ent.vEntregable, dat.iAnio');
        $this->db->select('ent.iIdEntregable, det.iIdDetalleEntregable');
        $this->db->from('Entregable ent');
        $this->db->join('DetalleEntregable det','det.iIdEntregable = ent.iIdEntregable','INNER');
        $this->db->join('DetalleActividad dat','dat.iIdDetalleActividad = det.iIdDetalleActividad AND dat.iActivo = 1','INNER');
        $this->db->join('Dependencia dep','dep.iIdDependencia = ent.iIdDependencia','INNER');
        $this->db->join('DependenciaEje dej','dej.iIdDependencia = dep.iIdDependencia','INNER');
        $this->db->join('PED2019Eje eje','eje.iIdEje = dej.iIdEje','INNER');
        $this->db->where('det.iActivo',1);
        $this->db->order_by('ent.vEntregable');

        if($where != '' && !empty($where)) $this->db->where($where);
        if(trim($keyword) != '')
        {
            $this->db->where("(lower(translate(ent.\"vEntregable\",'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) ilike lower(translate('%$keyword%','áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')))");
        }

        return $this->db->get();
    }


    function detalle_entregable_by_id($id)
    {
        $this->db->select();
        $this->db->from('Entregable e');
        $this->db->join('UnidadMedida um','e.iIdUnidadMedida = um.iIdUnidadMedida','JOIN');
        $this->db->join('Periodicidad p','e.iIdPeriodicidad = p.iIdPeriodicidad','JOIN');
        $this->db->join('SujetoAfectado sa','e.iIdSujetoAfectado = sa.iIdSujetoAfectado','JOIN');
        $this->db->join('DetalleEntregable de','e.iIdEntregable = de.iIdEntregable','JOIN');
        $this->db->join('DetalleActividad da','de.iIdDetalleActividad = da.iIdDetalleActividad','JOIN');
        $this->db->join('Actividad act','act.iIdActividad = da.iIdActividad','JOIN');
        $this->db->where('e.iActivo', 1);
        $this->db->where('de.iActivo', 1);
        $this->db->where('de.iIdDetalleEntregable', $id);
        $this->db->order_by('e.vEntregable');

        return $this->db->get();
    }

    function avances_capturados($idDetEnt)
    {
        $idDetEnt = $this->db->escape($idDetEnt);
        $sql = 'SELECT COUNT(av."iIdAvance") avances 
        FROM "DetalleEntregable" det 
        INNER JOIN "Entregable" ent ON ent."iIdEntregable" = det."iIdEntregable" AND det."iActivo" = 1
        INNER JOIN "DetalleActividad" dat ON dat."iIdDetalleActividad" = det."iIdDetalleActividad" AND dat."iActivo" = 1
        INNER JOIN "Avance" av ON av."iIdDetalleEntregable" = det."iIdDetalleEntregable" AND av."iActivo" = 1
        WHERE det."iActivo" = 1 AND  det."iIdEntregable" = '.$idDetEnt;

        $query = $this->db->query($sql);
        return ($query->row()->avances > 0) ? true:false;
    }

    //Agregados Saul Tun
    function obtenerForma(){
        $this->db->select();
        $this->db->from('FormaIndicador');
        
        $query =  $this->db->get();
		$resultado = $query->result();
        return $resultado;
    }

    function obtenerDimension(){
        $this->db->select();
        $this->db->from('DimensionIndicador');
        
        $query =  $this->db->get();
		$resultado = $query->result();
        return $resultado;
    }

    
	public function insertarVariablesIndicador($tabla, $datos, $con=''){
		if($con == '') $con = $this->db;
		if($con->insert($tabla,$datos)) return true;
		else return false;
	}

    public function eliminarVariables($id){
		$this->db->where('iIdEntregable', $id);
		$this->db->delete('VariableIndicador');
		return true;
	}

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

    function actualizarVariables($id, $data){

        $this->db->where('iIdVariableIndicador', $id);
        return $this->db->update('VariableIndicador', $data);
    }

    function eliminarVariable($id){
        $this->db->where('iIdVariableIndicador', $id);
		$this->db->delete('VariableIndicador');
		return true;
    }

    public function insertCambio($data){
		return $this->db->insert('Logs', $data);
	}
}

?>