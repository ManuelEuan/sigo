<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_entregables extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('funciones');
        $this->load->model('M_entregables','me');
        $this->load->library('Class_options');
        $this->load->library('Class_seguridad');
    }

    //Muestra la vista principal
    public function index(){

        if(isset($_POST['id'])){
            $seg = new Class_seguridad();
            $idActividad = isset($_POST['id']);

            $data['id_detact'] = $this->input->post('id',true);
            $data['vActividad'] = $this->me->nombre_actividad($data['id_detact']);
            $data['tabla'] = $this->vista_tabla_entregables($data['id_detact']);
            $data['tabla_alineacion'] = $this->vista_tabla_alineacion($data['id_detact']);
            $data['acceso'] = $seg->tipo_acceso(14,$_SESSION[PREFIJO.'_idusuario']);
            
            $this->load->view('entregables/principal',$data);
        }
    }

    //Muestra la vista para agregar
    public function create(){
        
        $lib = new Class_options();

        $data['id_detact'] = $this->input->post('id',true);
        $data['unidadmedida'] = $lib->options_tabla('unidades_medida');
        $data['periodicidad'] = $lib->options_tabla('periodicidad');
        $data['sujeto_afectado'] = $lib->options_tabla('sujeto_afectado');
        $data['compromiso'] = $lib->options_tabla('compromisos');
        $data['compromisos'] = $this->me->mostrar_compromisos();

        //Agregados Saul Tun
        $data['FormaInd'] = $this->me->obtenerForma();
        $data['dimension'] = $this->me->obtenerDimension();

        $data['municipios'] = $lib->options_multiselect('municipios',[]);

        $this->load->view('entregables/contenido_agregar',$data);
    }

    //Funcion para insertar
    public function insert()
    {
        if(isset($_POST['entregable']) && isset($_POST['unidadmedida']) && isset($_POST['sujetoafectado']) 
        && isset($_POST['periodicidad']) && isset($_POST['meta']) && isset($_POST['id_detalleactividad'])){

            if($_POST['meta']){

                $data['vEntregable'] = $this->input->post('entregable',TRUE);
                $data['iIdUnidadMedida'] = $this->input->post('unidadmedida',TRUE);
                $data['iIdPeriodicidad'] = $this->input->post('periodicidad',TRUE);

                if(isset($_POST['municipalizable'])){
                    $municipalizacion = $this->input->post('municipalizable',TRUE);
                }else{
                    $municipalizacion = 0;
                }

                if(isset($_POST['checkMismoBenef'])){
                    $beneficios = $this->input->post('checkMismoBenef',TRUE);
                }else{
                    $beneficios = 0;
                }

                $data['iMunicipalizacion'] = $municipalizacion;
                $data['iMismosBeneficiarios'] = $beneficios;
                $data['iIdDependencia'] = $_SESSION[PREFIJO.'_iddependencia'];
                $data['iIdSujetoAfectado'] = $this->input->post('sujetoafectado',TRUE);
                $data['iActivo']= 1;

                //Agregado Saul Tun
                $data['iIdFormaInd'] = $this->input->post('formaIndicador',TRUE);
                $data['iIdDimensionInd'] = $this->input->post('selectDimension',TRUE);
                $data['nLineaBase'] = $this->input->post('baseIndicador',TRUE);
                $data['vMedioVerifica'] = $this->input->post('medioVerificacion',TRUE);
                $data['vFormula'] = $this->input->post('areaCalculo',TRUE);
                $data['iAcumulativo'] =$this->input->post('tipoAlta',TRUE);
                $data['iAutorizado'] = 1;
                $Variable = $this->input->post('Variable', true);
                $Letra = $this->input->post('Letra', true);


                $table = 'Entregable';

                $identregable = $this->me->guardado_general($table,$data);
                
                if($identregable > 0){
                  //municipio entregable
                $municipios = $this->input->post('municipios',true);

                if(isset($_POST['municipios'])){
                    foreach ($municipios as $value) {
                      $muni['iIdEntregable'] = $identregable;
                      $muni['iIdMunicipio'] = $value;

                      $this->me->guardar_entregablemunicipio('EntregableMunicipio', $muni);
                    }
                }

                //Agregado Saul Tun
                foreach($Variable as $key => $v){
                    $this->me->insertarVariablesIndicador('VariableIndicador', array('vVariableIndicador' => $Letra[$key], 'vNombreVariable' => $v, 'iIdEntregable' => $identregable), $con);
                }

                    $table2 = 'DetalleEntregable';

                    $data2['iIdEntregable'] = $identregable;
                    $data2['iIdDetalleActividad'] = $this->input->post('id_detalleactividad',TRUE);
                    $data2['nMeta'] = EliminaComas($this->input->post('meta',TRUE));
                    $data2['nMetaModificada'] = EliminaComas($this->input->post('metamodificada',TRUE));
                    $data2['dFechaInicio'] = $this->input->post('fechainicio',true);
                    $data2['dFechaFin'] = $this->input->post('fechafin',true);
                    $data2['iAutorizado'] = 1;

                    $cantidadEntregables = $this->validar_entregables($this->input->post('id_detalleactividad',TRUE));

                    if($cantidadEntregables != null){

                        $id_detalleentregable = $cantidadEntregables->iIdDetalleEntregable;

                        $pond_alta = $cantidadEntregables->iPonderacion;

                        $nueva_ponderacion = $pond_alta - 1;
                        //$data2_1 = array();
                        $data2_1['iPonderacion'] = $nueva_ponderacion;

                        if($this->me->modificar_detalleentregable($id_detalleentregable,$data2_1)){
                            $ponderacion = 1;
                        }
                    }else{
                        $ponderacion = 100;
                    }

                    $data2['iPonderacion'] = $ponderacion;
                    $data2['iActivo'] = 1;

                    $id_detentregable = $this->me->guardado_general($table2,$data2);

                    if($id_detentregable > 0){

                        if(isset($_POST['compromiso']) && $_POST['compromiso'] != 0 && isset($_POST['componente']) && $_POST['componente'] != 0){

                            $table3 = 'EntregableComponente';

                            $data3['iIdEntregable'] = $identregable;
                            $data3['iIdComponente'] = $this->input->post('componente',TRUE);

                            $this->me->guardar_entregablecomponente($table3,$data3);
                        }

                        echo $id_detentregable;

                    }else{                   
                        echo 'error';
                    }
                }
            }else{
                echo 'error_meta';
            }          
        }else{
            echo "error post";
        }
    }

    //Muestra la pantalla de editar
    public function edit(){

        $lib = new Class_options();
        $seg = new Class_seguridad();

        $data = array();

        $data['id_ent'] = $this->input->post('id',TRUE);
        $data['id_detact'] = $this->input->post('id2',TRUE);

        $data3['eje'] = $this->me->mostrarEje();
        $data3['consulta1'] = $this->me->preparar_update($data['id_detact']);
        
        $arrMunicipios = array();
        $municipios = $this->me->mostrar_entregables_municipio($data['id_ent']);
        foreach ($municipios as $row) {
            $arrMunicipios[] = $row->iIdMunicipio;
        }
        $data['municipios'] = $lib->options_multiselect('municipios', $arrMunicipios);

        $data['consulta'] = $this->me->mostrar_entregable_actual($data['id_ent'], $data['id_detact']);
        $componente = $this->me->mostrar_componentescompromiso($data['id_ent']);

        if($componente != NULL){
            $data['componente'] = $lib->options_tabla('componentes_compromiso',$componente->iIdComponente,'cp.iIdCompromiso = '.$componente->iIdCompromiso.'');
            $data['compromiso'] = $lib->options_tabla('compromisos',$componente->iIdCompromiso);
        }else{
            $data['componente'] = '<option value="0">Seleccionar...</option>';
            $data['compromiso'] = $lib->options_tabla('compromisos');
        }
        $data['unidadmedida'] = $lib->options_tabla('unidades_medida',$data['consulta']->iIdUnidadMedida);
        $data['periodicidad'] = $lib->options_tabla('periodicidad',$data['consulta']->iIdPeriodicidad);
        $data['sujeto_afectado'] = $lib->options_tabla('sujeto_afectado',$data['consulta']->iIdSujetoAfectado);
        $data['acceso'] = $seg->tipo_acceso(14,$_SESSION[PREFIJO.'_idusuario']);        
        $all_edit = $seg->tipo_acceso(45,$_SESSION[PREFIJO.'_idusuario']);

        //Agregados Saul
        $data['formaIndicador'] = $this->me->obtenerForma();
        $data['dimension'] = $this->me->obtenerDimension();
        $data['Variables'] = $this->me->obtenerVariables($data['id_ent']);
        
        $data['baseIndicador'] = $data['consulta']->nLineaBase;
        $data['medioVerificacion'] = $data['consulta']->vMedioVerifica;
        $data['areaCalculo'] = $data['consulta']->vFormula;

        $data['idForma'] = $data['consulta']->iIdFormaInd;
        $data['idDiemension'] = $data['consulta']->iIdDimensionInd;
        $data['iMismosBeneficiarios'] = $data['consulta']->iMismosBeneficiarios;
        $data['iAcumulativo'] = $data['consulta']->iAcumulativo;

        if($all_edit > 1){
            $data['candado'] = false;
        } else {
            $data['candado'] = ($this->me->avances_capturados($data['id_ent']) > 0) ? true:false;
        }
        $new_array = array_merge($data,$data3);
        //echo json_encode(count($data['Variables']));
        $this->load->view('entregables/contenido_modificar', $new_array);
    }

    public function obtenerDatosAntiguos($idEnt, $idAct){
        $lib = new Class_options();
        $seg = new Class_seguridad();

        $data = array();

        $data['id_ent'] = $idEnt;//$this->input->post('id',TRUE);
        $data['id_detact'] = $idAct;//$this->input->post('id2',TRUE);

        $data3['eje'] = $this->me->mostrarEje();
        $data3['consulta1'] = $this->me->preparar_update($data['id_detact']);
        
        $arrMunicipios = array();
        $municipios = $this->me->mostrar_entregables_municipio($data['id_ent']);
        foreach ($municipios as $row) {
            $arrMunicipios[] = $row->iIdMunicipio;
        }
        $data['municipios'] = $lib->options_multiselect('municipios', $arrMunicipios);

        $data['consulta'] = $this->me->mostrar_entregable_actual($data['id_ent'], $data['id_detact']);
        $componente = $this->me->mostrar_componentescompromiso($data['id_ent']);

        if($componente != NULL){
            $data['componente'] = $lib->options_tabla('componentes_compromiso',$componente->iIdComponente,'cp.iIdCompromiso = '.$componente->iIdCompromiso.'');
            $data['compromiso'] = $lib->options_tabla('compromisos',$componente->iIdCompromiso);
        }else{
            $data['componente'] = '<option value="0">Seleccionar...</option>';
            $data['compromiso'] = $lib->options_tabla('compromisos');
        }
        $data['unidadmedida'] = $lib->options_tabla('unidades_medida',$data['consulta']->iIdUnidadMedida);
        $data['periodicidad'] = $lib->options_tabla('periodicidad',$data['consulta']->iIdPeriodicidad);
        $data['sujeto_afectado'] = $lib->options_tabla('sujeto_afectado',$data['consulta']->iIdSujetoAfectado);
        $data['acceso'] = $seg->tipo_acceso(14,$_SESSION[PREFIJO.'_idusuario']);        
        $all_edit = $seg->tipo_acceso(45,$_SESSION[PREFIJO.'_idusuario']);

        //Agregados Saul
        $data['formaIndicador'] = $this->me->obtenerForma();
        $data['dimension'] = $this->me->obtenerDimension();
        $data['Variables'] = $this->me->obtenerVariables($data['id_ent']);
        
        $data['baseIndicador'] = $data['consulta']->nLineaBase;
        $data['medioVerificacion'] = $data['consulta']->vMedioVerifica;
        $data['areaCalculo'] = $data['consulta']->vFormula;

        $data['idForma'] = $data['consulta']->iIdFormaInd;
        $data['idDiemension'] = $data['consulta']->iIdDimensionInd;
        $data['iMismosBeneficiarios'] = $data['consulta']->iMismosBeneficiarios;
        $data['iAcumulativo'] = $data['consulta']->iAcumulativo;

        if($all_edit > 1){
            $data['candado'] = false;
        } else {
            $data['candado'] = ($this->me->avances_capturados($data['id_ent']) > 0) ? true:false;
        }
        $new_array = array_merge($data,$data3);
        return $new_array;
    }

    //Funcion para editar
    public function update(){
        
        if(isset($_POST['entregable']) && isset($_POST['periodicidad']) && isset($_POST['meta']) && isset($_POST['id_entregable']) && isset($_POST['id_detalleactividad']) && isset($_POST['metamodificada']))
        {
            $datosViejos = $this->obtenerDatosAntiguos($this->input->post('id_entregable',TRUE), $this->input->post('id_detalleactividad',TRUE));
            $datosCambiados = array();
            $datosAntiguos = array();
            $seg = new Class_seguridad();
            $id_ent = $this->input->post('id_entregable');
            // Para saber que campos no debemos actualizar
            $all_edit = $seg->tipo_acceso(45,$_SESSION[PREFIJO.'_idusuario']);
            if($all_edit > 1){
                $candado = false;
            } else {
                $candado = ($this->me->avances_capturados($id_ent) > 0) ? true:false;
            }
            //
            $data['vEntregable'] = $this->input->post('entregable',TRUE);
            
            $data['iIdPeriodicidad'] = $this->input->post('periodicidad',TRUE);
            
            $data['vNombreEntregable'] = '.';
            //Agregado Saul
            $data['iIdFormaInd'] = $this->input->post('formaIndicador',TRUE);
            
            $data['iIdDimensionInd'] = $this->input->post('selectDimension',TRUE);
            
            $data['nLineaBase'] = $this->input->post('baseIndicador',TRUE);
            
            $data['vMedioVerifica'] = $this->input->post('medioVerificacion',TRUE);
            
            $data['vFormula'] = $this->input->post('areaCalculo',TRUE);
            
            $data['iAcumulativo'] =$this->input->post('tipoAlta',TRUE);

            $data['iAutorizado'] = 0;

            //Actualizar tabla variables

            $Variable = $this->input->post('Variable', true);
            
            $Letra = $this->input->post('Letra', true);
            $idVariable = $this->input->post('idVariable', true);

            foreach($Variable as $key => $v){
                if($idVariable[$key] == ''){
                    $this->me->insertarVariablesIndicador('VariableIndicador', array('vVariableIndicador' => $Letra[$key], 'vNombreVariable' => $v, 'iIdEntregable' => $id_ent), $con);
                }else{
                    $this->me->actualizarVariables($idVariable[$key], array('vVariableIndicador' => $Letra[$key], 'vNombreVariable' => $v, 'iIdEntregable' => $id_ent));
                }   
            }
            if(!$candado)
            {
                $data['iIdSujetoAfectado'] = $this->input->post('sujetoafectado',TRUE);
                
                $data['iIdUnidadMedida'] = $this->input->post('unidadmedida',TRUE);
                
                $data['iMunicipalizacion']  = (isset($_POST['municipalizable'])) ? 1:0;
                
                $data['iMismosBeneficiarios'] = (isset($_POST['checkMismoBenef'])) ? 1:0;
                
            }

            $where = "iIdEntregable =".$id_ent;
            $table = 'Entregable';

            if($this->me->modificacion_general($where,$table,$data))
            {                
                $where2 = array('iIdEntregable' => $id_ent, 'iIdDetalleActividad' => $this->input->post('id_detalleactividad',TRUE));
                $table2 = 'DetalleEntregable';
                
                $data2['nMeta'] = EliminaComas($this->input->post('meta',TRUE));

                $data2['nMetaModificada'] = EliminaComas($this->input->post('metamodificada',TRUE));
                
                $data2['dFechaInicio'] = $this->input->post('fechainicio',TRUE);
                
                $data2['dFechaFin'] = $this->input->post('fechafin',TRUE);
                
                $data2['iAnexo'] = (isset($_POST['anexo'])) ? 1:0;

                $data2['iAutorizado'] = 0;
                
                if($this->me->modificacion_general($where2,$table2,$data2)){

                    $detalleentregable = $this->me->obtener_id_detallentregable($id_ent);
                    echo  $detalleentregable->iIdDetalleEntregable;
                }
            }

            if($this->me->eliminar_compromiso($id_ent)){

                if(isset($_POST['compromiso']) && $_POST['compromiso'] != 0 && isset($_POST['componente']) && $_POST['componente'] != 0){

                    $table3 = 'EntregableComponente';

                    $data3['iIdEntregable'] = $id_ent;
                    $data3['iIdComponente'] = $this->input->post('componente',TRUE);

                    $this->me->guardar_entregablecomponente($table3,$data3);
                }
            }

            if($this->me->eliminar_entregablemunicipios($id_ent)){
                $municipios = $this->input->post('municipios',true);

                if(isset($_POST['municipios'])){
                    foreach ($municipios as $value) {
                    $muni['iIdEntregable'] = $id_ent;
                    $muni['iIdMunicipio'] = $value;

                    $this->me->guardar_entregablemunicipio('EntregableMunicipio', $muni);
                    }
                }
            }

            $hoy = date('Y-m-d H:i:s');

            $resp = $this->me->insertCambio(array(
                'iTipoCambio' => 'Indicador',
                'iAntesCambio' => strval(json_encode($datosViejos['consulta'])),
                'iDespuesCambio' => '['.strval(json_encode($data)).','.strval(json_encode($data2)).','.strval(json_encode($data3)).']',
                'iFechaCambio' => $hoy,
                'iIdUsuario' => $_SESSION[PREFIJO.'_idusuario'],
                'iAprovacion' => 0,
            ));

        }else{
            echo 'error';
        }

    }

    //Muestra los componentes en base a un compromiso
    public function showcomponentes($id){

        $lib = new Class_options();

        if($id == 0){
            $componentes= '<option value="0">Seleccionar...</option>';
        }else{
            $componentes.= $lib->options_tabla('componentes_compromiso',$id,'cp.iIdCompromiso = '.$id.'');
        }
        
        echo $componentes;
    }

    //Valida los entregables
    public function validar_entregables($id_detalleactividad){

        return $this->me->mostrar_detalleentregable($id_detalleactividad);
    }

    //Muestra la pantalla de ponderacion
    public function showponderacion(){

        if(isset($_POST['id']) && isset($_POST['id2'])){

            $id_detent = $this->input->post('id',true);
            $id_detact = $this->input->post('id2',true);
            $data['contenido'] = $this->crear_vista($id_detent,$id_detact,null,"crea");
           
            $this->load->view('entregables/contenido_ponderacion',$data);
        }else{

            $id_detact = $this->input->post('id2',true);

            if(isset($_POST['tipo'])){
                $tipo = $this->input->post('tipo',true);
            }else{
                $tipo = null;
            }

            $data['contenido'] = $this->crear_vista(null,$id_detact,$tipo,"elimina");

            $this->load->view('entregables/contenido_ponderacion',$data);
        }
    }

    //Crea la vista principal de las ponderaciones
    public function crear_vista($id_detent,$id_detact,$tipo,$modo){


        $ponderacion_actual = $this->me->mostrar_ponderacion_actual($id_detent);

        $str = '<div class="col-12">
                    <div class="card">
                        <div class="card-body">
                         <form class="needs-validation was-validated" onsubmit="guardarPonderacion(this,event);">';

                         if($id_detent != NULL){

                            $str.='<div class="row">
                                <div class="col-md-12">
                                    <h5 class="card-title">Ponderación del indicador actual</h5>
                                </div>
                                <table class="table table-bordered table-striped ">
                                    <thead>
                                        <tr>
                                            <th>Indicador</th>
                                            <th>Unidad de medida</th>
                                            <th>Ponderación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>'.$ponderacion_actual->vEntregable.'</td>
                                            <td>'.$ponderacion_actual->vUnidadMedida.'</td>
                                            <td><input class="text-center ponderacion" type="text" name="val['.$ponderacion_actual->iIdDetalleEntregable.']" id="ponderacionActual" value="'.$ponderacion_actual->iPonderacion.'" onkeyup="sumar();" onkeypress="return filterFloat(event,this);"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="dropdown-divider"></div>
                            <br>';

                            $ponderaciones = $this->me->mostrar_ponderaciones($id_detact,$ponderacion_actual->iIdDetalleEntregable);
                            $titulo = 'Otras ponderaciones';
                        }else{
                            $ponderaciones = $this->me->mostrar_ponderaciones($id_detact);

                            $titulo = 'Ponderaciones';

                            $str.='<div class="row">
                                <div class="col-md-10 mb-3">                                    
                                </div>';
                                if($tipo == 'null'){
                                    $str.=
                                    '<div class="col-md-2 mb-3 text-right">
                                        <button title="Ir al Listado de indicadores" class="btn waves-effect waves-light btn-outline-info" type="button" onclick="regresarmodulo()"><i class="mdi mdi-arrow-left"></i>Regresar</button>                                  
                                    </div>';
                                }
                            $str.= '</div>';
                        }                       

                        $str.='<div class="row">
                                <div class="col-md-12">
                                    <h5 class="card-title">'.$titulo.'</h5>
                                </div>
                                <table class="table table-bordered table-striped ">
                                    <thead>
                                        <tr>
                                            <th>Indicador</th>
                                            <th>Unidad de medida</th>
                                            <th>Ponderación</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    $count = 1;
                            foreach($ponderaciones as $value){
                                $str.= '<tr>
                                            <td>'.$value->vEntregable.'</td>
                                            <td>'.$value->vUnidadMedida.'</td>
                                            <td><input class="form-control text-center ponderacion" type="text" name="val['.$value->iIdDetalleEntregable.']" id="otrasPonderaciones'.$count.'" value="'.$value->iPonderacion.'" onkeyup="sumar();" onkeypress="return filterFloat(event,this);"></td>
                                        </tr>';
                                        $count = $count + 1 ;
                            }
                             $str.='</tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-4">
                                    <input type="hidden" name="totalponderacion" id="totalponderacion" value="">
                                    <input type="hidden"  id="num_ponderaciones" value="'.Count($ponderaciones).'">
                                    <input type="hidden"  id="modo" value="'.$modo.'">
                                    <label>Total de ponderaciones: </label> <label id="total"></label>
                                </div>
                                <div class="col-md-2">
                                
                                </div>
                            </div>
                            <br>';
                             if($ponderaciones != 'NULL'){
                                $str.='<center>
                                    <button class="btn waves-effect waves-light btn-info" type="submit">Guardar</button>
                                    </center>';
                            }
                            
                        $str.='</form>
                        </div>
                    </div>
                </div>';

        return $str;
    }

    //Guarda las ponderaciones de los entregables
    public function restart_ponderacion(){

        $var = $_POST['val'];
        $ponderacion = $this->input->post('totalponderacion',true);

        if($ponderacion >100){

            echo 'mayor';
        }
        if($ponderacion < 100){

            echo 'menor';
        }
        if($ponderacion == 100){

            foreach($var as $valor => $value){

                $id_detent = $valor;
                $data['iPonderacion'] = $value;

                $this->me->modificar_detalleentregable($id_detent,$data);
            }
            echo 'correcto';
        }
    }

    //Muestra la vista de municipalizacion
    public function create_municipalizacion(){
        $seg = new Class_seguridad();
        $data['acceso'] = $seg->tipo_acceso(16,$_SESSION[PREFIJO.'_idusuario']);

        $data['contenido'] = $this->vista_municipalizacion();
        $this->load->view('entregables/contenido_municipalizacion',$data);

    }

    //Crea la vista principal de municipalizacion
    public function vista_municipalizacion(){

        $id_ent = $this->input->post('id');
        $id_act = $this->input->post('id_act');

        $str = '<div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <h4 class="card-title">Municipalización</h4>
                                </div>
                                <div class="col-md-2 text-right">
                                    <button title="Ir al Listado de indicadores" class="btn waves-effect waves-light btn-outline-info" type="button" onclick="regresarmodulo()"><i class="mdi mdi-arrow-left"></i>Regresar</button>
                                </div>
                            </div>
                            <br>
                            <br>
                            <form class="needs-validation was-validated" onsubmit="guardarMunicipalizacion(this,event);">
                                <div class="row">
                                    <div class="col-md-12">';

                                $entregable = $this->me->mostrar_entregable_actual($id_ent, $id_act);
                                
                                $str.='<h5 class="card-title">Indicador: '.$entregable->vEntregable.'</h5>
                                    </div>
                                    <table class="table table-bordered table-striped ">
                                        <thead>
                                            <tr>
                                                <th>Municipio</th>
                                                <th>Meta anual del municipio</th>
                                                <th>Meta modificada del municipio</th>
                                                <th>Unidad de medida</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                                        $municipios = $this->me->mostrar_municipios();

                                        foreach($municipios as $value){

                                            $metas = $this->me->mostrar_metas_municipios($value->iIdMunicipio,$entregable->iIdDetalleEntregable);

                                            if($metas != NULL){
                                                $meta = $metas->nMeta;
                                                $metamod = $metas->nMetaModificada;
                                            }else{
                                                $meta = NULL;
                                                $metamod = NULL;
                                            }
                                            
                                         $str.='<tr>
                                                <td>'.$value->vMunicipio.'</td>
                                                <td><input class="input-lectura text-center ponderacion" type="text" name="val['.$value->iIdMunicipio.']" id="" value="'.$meta.'" onkeypress="return filterFloat(event,this);" onkeyup="sumar();"></td>
                                                <td><input class="input-lectura text-center ponderacionMod" type="text" name="valmod['.$value->iIdMunicipio.']" id="" value="'.$metamod.'" onkeypress="return filterFloat(event,this);" onblur="sumarMod();" ></td>
                                                <td>'.$entregable->vUnidadMedida.'</td>
                                            </tr>';
                                        }
                             $str.='</tbody>
                                    </table>
                                </div>                               
                                <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-4 text-center">
                                    <input type="hidden" name="metaanual" id="metaanual" value="'.$entregable->nMeta.'">
                                    <input type="hidden" name="totalmeta" id="totalmeta" value="">
                                    <label>Meta anual: </label> <label>'.$entregable->nMeta.'</label><br>
                                    <label>Suma de meta: </label> <label id="total"></label>
                                </div>
                                <div class="col-md-4 text-center">
                                <input type="hidden" name="metaanualmod" id="metaanualmod" value="'.$entregable->nMetaModificada.'">
                                    <input type="hidden" name="totalmetamod" id="totalmetamod" value="">
                                    <label>Meta anual modificada: </label> <label>'.$entregable->nMetaModificada.'</label><br>
                                    <label>Suma de meta modificada: </label> <label id="totalmod"></label>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <br>
                                <center>
                                    <input type="hidden" name="id_detent" id="id_detent" value="'.$entregable->iIdDetalleEntregable.'">
                                    <button class="btn-lectura btn waves-effect waves-light btn-info" type="submit">Guardar</button>
                                    <button type="reset" class="btn-lectura btn waves-effect waves-light btn-inverse" onclick="regresarmodulo()">Cancelar</button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>';

        return $str;
    }

    //Metodo para insertar los entregables en base a un municipio
    public function insert_municipalizacion(){

        if(isset($_POST['metaanual']) && isset($_POST['totalmeta']) && isset($_POST['id_detent'])){

            $metaanual = $this->input->post('metaanual',TRUE);
            $sumameta = $this->input->post('totalmeta',TRUE);
            
            /*if($sumameta == $metaanual)
            {*/

                $var = $_POST['val'];
                $varmod = $_POST['valmod'];

                $id_detent = $this->input->post('id_detent',TRUE);
                
                if($this->me->validar_entregablemunicipio($id_detent))
                {

                    $this->me->eliminar_entregablemunicipio($id_detent);
                }
                
                foreach($var as $valor => $value)
                {
                    if(floatval($value) > 0 || floatval($varmod[$valor]) > 0)
                    {

                        $table='DetalleEntregableMetaMunicipio';

                        $data['iIdDetalleEntregable'] = $id_detent;
                        $data['iIdMunicipio'] = $valor;
                        $data['nMeta'] = floatval($value);
                        $data['nMetaModificada'] = floatval($varmod[$valor]);

                        $this->me->guardar_entregablemunicipio($table,$data);
                    }                   
                }
                
                echo 'correcto';

            /*}
            if($sumameta > $metaanual){
                echo 'mayor';
            }
            if($sumameta < $metaanual){
                echo 'menor';
            } */          
        }else{
            echo 'error';
        }
    }

    //Funcion para crear la vista de la tabla de entregables
    function marcar()
    {
        if(isset($_POST['id']) && !empty($_POST['id']))
        {
            $this->load->model('M_seguridad');
            $mg = new M_seguridad();
            $where['iIdDetalleEntregable'] = $this->input->post('id');
            $datos['iSuspension'] = $this->input->post('validado');
            $con = $mg->iniciar_transaccion();
            $mg->actualiza_registro('DetalleEntregable',$where,$datos,$con);
            if($mg->terminar_transaccion($con)) echo 0;
            else echo 'El registro no pudo ser actualizado';

        }
    }

    public function vista_tabla_entregables($id_detact){

        $this->load->model('M_avances');
        $ma = new M_avances();

        $seg = new Class_seguridad();
        $tipo_acceso = $seg->tipo_acceso(16,$_SESSION[PREFIJO.'_idusuario']);
        $acceso_pat = $seg->tipo_acceso(14,$_SESSION[PREFIJO.'_idusuario']);

        $str='<div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                                    <thead>
                                        <tr>
                                            <th>Nombre completo</th>
                                            <th>Suspensión <br>(Total/Parcial)</th>
                                            <th>Periodicidad</th>
                                            <th>¿Mismos beneficiarios en cada periodo?</th>
                                            <th>Municipalizable</th>
                                            <th>Avance/Meta</th>
                                            <th width="120px" align="center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    $consulta = $this->me->mostrar_entregables($id_detact);
                                
                                    foreach($consulta as $value)
                                    {
                                        $value->nMeta = ($value->nMetaModificada > 0) ? $value->nMetaModificada:$value->nMeta;
                                        $avances_noaprobados = $ma->num_avances_no_aprobados($value->iIdDetalleEntregable);
                                        $icon = ($avances_noaprobados > 0) ? '<i style="color:#E5BE01; font-size:24px;" class="mdi mdi-new-box md-24" title="Hay '.$avances_noaprobados.' avance(s) sin aprobar"></i>':'';
//Aqui
                                        $avance = $ma->suma_avances_total($value->iIdDetalleEntregable)->total_avance;
                                        
                                        $contenido = "'¿Esta usted seguro?',EliminarEntregable,'$value->iIdDetalleEntregable'";
                                        $checked = ($value->iSuspension) ? 'checked':'';
                                        $str.=  '<tr>
                                            <td><dl><dd>'.$icon.''.$value->vEntregable.'</dd></dl></td>
                                            <td><input type="checkbox" class="form-control" id="chk'.$value->iIdDetalleEntregable.'" onclick="validar('.$value->iIdDetalleEntregable.');" value="1" '.$checked.'>                                                
                                            </td>
                                            <td>'.$value->vPeriodicidad.'</td>';

                                        $beneficiario = ($value->iMismosBeneficiarios == 1) ? 'Si':'No';
                                        $municipalizacion = ($value->iMunicipalizacion == 1) ?'Si':'No';
                                   
                                        if($acceso_pat > 1)
                                        {
                                            $icon_class = 'mdi mdi-border-color';
                                            $title = 'Editar'; 
                                        }
                                        else
                                        {
                                            $icon_class = 'fas fa-search';
                                            $title = 'Consultar';
                                        }
                                    
                                        $str.= '<td>'.$beneficiario.'</td>
                                            <td>'.$municipalizacion.'</td>
                                            <td align="center"><dl><dt>'.Decimal($avance).'/'.Decimal($value->nMeta).'</dt><dd></dd>'.$value->vUnidadMedida.'</dl></td>
                                            <td class="text-center" align="center">
                                                <button type="button" class="btn btn-xs waves-effect waves-light btn-warning" data-toggle="tooltip" data-placement="top" title="'.$title.'" onclick="modificar_entregable('.$value->iIdEntregable.')"><i class="'.$icon_class.'"></i></button>&nbsp;';
                                            if($acceso_pat > 1)
                                            {    
                                            
                                                $str.=  '<button type="button" class="btn btn-xs waves-effect waves-light btn-danger"><i class="mdi mdi-close" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="confirmar('.$contenido.')"></i></button>&nbsp;';
                                            }
                                                
                                            if($value->iMunicipalizacion == 1 && $tipo_acceso > 0){
                                                $str.= '<button type="button" class="btn btn-xs waves-effect waves-light btn-success" data-toggle="tooltip" data-placement="top" title="Metas por municipio" onclick="municipalizacion('.$value->iIdEntregable.','.$id_detact.')"><i class="mdi mdi-garage"></i></button>&nbsp;';
                                            }

                                        $str.='<button type="button" class="btn btn-xs waves-effect waves-light btn-info" data-toggle="tooltip" data-placement="top" title="Avances" onclick="mostrar_avances('.$value->iIdDetalleEntregable.')"><i class="mdi mdi-trending-up"></i></button>';

                                      $str.='</td>
                                        </tr>';
                                        }
                                $str.='</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';          

            return $str;
    }

    //Funcion para crear la vista de la tabla de alineaciones
    public function vista_tabla_alineacion($id_detact){

        $str='<div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered display table2" style="width:100%" id="grid2">
                                    <thead>
                                        <tr>
                                            <th>Indicador</th>
                                            <th>Compromiso</th>
                                            <th>Componente</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    $consulta = $this->me->mostrar_entregablecompromiso($id_detact);
                                
                                        foreach($consulta as $value){
                                            if($value->vCompromiso != NULL){
                                                $compromiso = $value->vCompromiso;
                                            }else{
                                                $compromiso = '-------';
                                            }
                                            if($value->vComponente != NULL){
                                                $componente = $value->vComponente;
                                            }else{
                                                $componente = '-------';
                                            }                                  
                                $str.=  '<tr>
                                            <td>'.$value->vEntregable.'</td>
                                            <td>'.$compromiso.'</td>
                                            <td>'.$componente.'</td>';
                                $str.=  '</tr>';
                                        }
                                $str.='</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

            return $str;
    }

    //Funcion para eliminar
    public function delete(){

        if(isset($_POST['id'])){

            $id_ent = $this->input->post('id',true);

           
            //$table = 'Entregable';
            //$table2 = 'DetalleEntregable';
            $where = "iIdDetalleEntregable =".$id_ent;
            $data['iActivo'] = 0;         

            //if($this->me->eliminacion_generica($where,$table,$data)){

                if($this->me->eliminacion_generica($where,'DetalleEntregable',$data)){

                    $id_entregable = $this->me->obtenerDetalleId($id_ent);

                    $this->me->eliminarVariables($id_entregable->iIdEntregable);

                    if($this->me->mostrar_entregables($_POST['id_detact']) != null){
                        echo true;
                    }else{
                        echo false;
                    }
                }
            //}

        }else{
            echo 2;
        }

    }

    //funcion para obtener el porcentaje de cada avance
	public function calcular_porcentaje_avance(){

        if(isset($_POST['id_detact'])){

            $id_detact = $this->input->post('id_detact',true);
            $total = 0;
            //Se obtienen los entregables de una determinada actividad
            $where['iSuspension'] = 0; // Sólo consideramos los entregables no suspendidos (COVID)
            $consulta = $this->me->detalle_entregable($id_detact);
            //se recorre cada uno de los entregables obtenidos
            foreach($consulta as $value)
            {
                //Se obtiene el id del entregable
                $id_detent = $value->iIdDetalleEntregable;
                //Se calcula el equivalente al 1%  de la meta del entregable
                $meta = ($value->nMetaModificada > 0) ? $value->nMetaModificada:$value->nMeta;
                $unidadmeta = ($meta > 0) ? ($meta/100):0;

                //Se obtiene el avance reportado y se divide entre el 1% de la meta del entregable para obtener el porcentaje base
                $consulta2 = $this->me->suma_avances_total($id_detent);
                $avancereportado = $consulta2->total_avance;
                $porcentajeavance = ($unidadmeta > 0) ? ($avancereportado/$unidadmeta):0;

                if($porcentajeavance > 100){
                    $porcentajeavance = 100;
                }
                //Se obtiene la ponderacion y se calcula su equivalente al 1%
                $ponderacion = $value->iPonderacion;
                $unidadponderacion = ($ponderacion/100);
                //Se multiplica el 1% de la ponderacion con el porcentaje base de avance para obtener el porcentaje de cumplimiento
                $porcentajecumplimiento = ($unidadponderacion * $porcentajeavance);
                //Se suman todos los porcentajes de cumplimiento

                //echo "Avance reportado:". $avancereportado."<br>"."porcentaje avance: ".$porcentajeavance."<br>"."Porcentaje cumplimiento:".$porcentajecumplimiento.'<br>';
                $total += $porcentajecumplimiento;
            }
            //echo $total;

            $where = "iIdDetalleActividad =".$id_detact;
            $table = 'DetalleActividad';   
            $data['nAvance'] = $total;

            if($this->me->modificacion_general($where,$table,$data)){
                echo true;
            }

        }
	}

    function entregables()
    {
        $seg = new Class_seguridad();
        $opt = new Class_options();

        $data['all_sec'] = $all_sec = $seg->tipo_acceso(9,$_SESSION[PREFIJO.'_idusuario']);
        $data['all_dep'] = $all_dep = $seg->tipo_acceso(10,$_SESSION[PREFIJO.'_idusuario']);
        $data['acceso'] = $seg->tipo_acceso(14,$_SESSION[PREFIJO.'_idusuario']);
        $dep = $sec = 0;
        $where = array();
        $data['year'] = $where['dat.iAnio'] = ( in_array(date('n'), array(1,2)) ) ?  (date('Y') - 1):date('Y');

        if($all_sec > 0) $data['ejes'] = $opt->options_tabla('eje',"");
        else
        { 
            $sec = $_SESSION[PREFIJO.'_ideje'];
            $where['dej.iIdEje'] = $_SESSION[PREFIJO.'_ideje'];
        }

        if($all_dep > 0)
        { 
            $data['dependencias'] = (isset($where['iIdEje'])) ? $opt->options_tabla('dependencia',"",$where):$opt->options_tabla('dependencia',"",'iActivo = 3');
        }
        else
        {
            $dep = $_SESSION[PREFIJO.'_iddependencia'];
        }

        
        $data['tabla'] = $this->tabla_entregables('',$where); 
        $this->load->view('entregables/index',$data); 
    }

    function tabla_entregables($keyword,$where)
    {
        $consulta = $this->me->entregables($keyword,$where)->result();
        if(count($consulta) > 0)
        {
            $html = '<div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered display" style="width:100%" id="grid">
                                            <thead>
                                                <tr>
                                                    <th>ID<br>Indicador</th>
                                                    <th>Eje</th>
                                                    <th>Dependencia</th>
                                                    <th>Año</th>
                                                    <th>ID<br>Anual</th>
                                                    <th>Indicador</th>
                                                    <th width="30px"> </th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                   
            foreach($consulta as $value)
            {
                $html.= '<tr>
                            <td>'.$value->iIdEntregable.'</td>
                            <td>'.$value->vEje.'</td>
                            <td>'.$value->vDependencia.'</td>
                            <td>'.$value->iAnio.'</td>
                            <td>'.$value->iIdDetalleEntregable.'</td>
                            <td>'.$value->vEntregable.'</td>
                            <td align="center">
                                <button type="button" class="btn btn-xs waves-effect waves-light btn-warning" data-toggle="tooltip" data-placement="top" title="Editar" onclick="modificar('.$value->iIdDetalleEntregable.')"><i class="mdi mdi-border-color"></i></button>
                            </td>
                         </tr>';
            }
                                    
            $html.= '                     </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        initDataTable();
                    });
                </script>';
        }
        else 
        {
            $html = '<p>No existen registros que coincidan con la búsqueda.</p>';
            
        }

        return $html;
    }

    function buscar_entregable()
    {
        $where = array();
        if( !empty($this->input->post('eje')) ) $where['dej.iIdEje'] = $this->input->post('eje');
        if( !empty($this->input->post('dep')) ) $where['ent.iIdDependencia'] = $this->input->post('dep');
        if( !empty($this->input->post('anio')) ) $where['dat.iAnio'] = $this->input->post('anio');
        if( isset($_POST['anexo']) ) $where['det.iAnexo'] = 1;
        $keyword = $this->input->post('keyword',true);

        echo $this->tabla_entregables($keyword,$where);
    }

    function modificar_entregable()
    {
        $opt = new Class_options();
        $id = $this->input->post('id',true);
        $result =$this->me->detalle_entregable_by_id($id)->row();

        $data = array();

        foreach ($result as $key => $value) 
        {
            $data[$key] = $value;
        }

        $data['mun'] = ($data['iMunicipalizacion'] == 1) ? 'Este indicador se entrega por municipio':'Este entregable no es municipalizable';
        $data['misben'] = ($data['iMismosBeneficiarios'] == 1) ? 'Este indicador reporta los mismos beneficiarios':'';
        $data['checked'] = ($data["iAnexo"] == 1) ? 'checked="checked"':'';
        $data['ejes'] = $opt->options_tabla('eje',$data['iEjeAnexo']);
        $data['ods'] = $opt->options_tabla('ods',$data['iNumOds']);
        
        $this->load->view('entregables/editar',$data);
    }

    function guardar_entregable()
    {
        $this->load->model('M_seguridad');
        $seg = new M_seguridad();

        $d_act['vNombreActividad'] = $this->input->post('vNombreActividad',true);
        $w_act['iIdActividad'] = $this->input->post('iIdActividad',true);
      
        $d_ent['vNombreEntregable'] = '.';
        $d_ent['vNombreEntregableMaya'] = $this->input->post('vNombreEntregableMaya',true);
        $d_ent['iEjeAnexo'] = $this->input->post('iEjeAnexo',true);
        $d_ent['iNumOds'] = $this->input->post('iNumOds',true);
        $w_ent['iIdEntregable'] = $this->input->post('iIdEntregable',true);


        $d_det_ent['iAnexo'] = (isset($_POST['iAnexo'])) ? 1:0;
        $w_det_ent['iIdDetalleEntregable'] = $this->input->post('iIdDetalleEntregable',true);

        $con = $seg->iniciar_transaccion();

        $upd = $seg->actualiza_registro('Actividad',$w_act,$d_act,$con);
        $upd = $seg->actualiza_registro('Entregable',$w_ent,$d_ent,$con);
        $upd = $seg->actualiza_registro('DetalleEntregable',$w_det_ent,$d_det_ent,$con);

        echo ($seg->terminar_transaccion($con))  ? 1:0;
    }

    function eliminarVariable(){
        $idVariable = $this->input->post('id',true);
        
        $this->me->eliminarVariable($idVariable);
    }

}
