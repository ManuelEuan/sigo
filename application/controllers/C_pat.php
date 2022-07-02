<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_pat extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('funciones');
        $this->load->model('M_pat', 'pat');
        $this->load->model('M_seguridad', 'mseg');
        $this->load->library('Class_seguridad');
        $this->load->library('Class_options');

        //Parametros para la conexion al sistema de finanzas
        $this->urlFinanzas    = "https://picaso.queretaro.gob.mx:8080/wsSigo/API/";
        $this->userFinanzas   = 'ws_user';
        $this->passFinanzas   = 'usr.sws.951';
        $this->authFinanzas   = $this->userFinanzas.":".$this->passFinanzas;
    }

    public function index() {
        $seg = new Class_seguridad();
        $opt = new Class_options();

        $data['all_sec'] = $all_sec = $seg->tipo_acceso(9,$_SESSION[PREFIJO.'_idusuario']);
        $data['all_dep'] = $all_dep = $seg->tipo_acceso(10,$_SESSION[PREFIJO.'_idusuario']);
        $data['p_clonar'] = $p_clonar = $seg->tipo_acceso(32,$_SESSION[PREFIJO.'_idusuario']);
        $data['acceso'] = $seg->tipo_acceso(14,$_SESSION[PREFIJO.'_idusuario']);
        $aux = array();
        $dep = $sec = 0;

        if($all_sec > 0) $data['ejes'] = $opt->options_tabla('eje',"");
        else
        { 
            $sec = $_SESSION[PREFIJO.'_ideje'];
            $where['iIdEje'] = $_SESSION[PREFIJO.'_ideje'];
        }

        if($all_dep > 0)
        { 
            $data['dependencias'] = (isset($where['iIdEje'])) ? $opt->options_tabla('dependencia',"",$where):$opt->options_tabla('dependencia',"",'iActivo = 3');
        }
        else
        {
            $dep = $_SESSION[PREFIJO.'_iddependencia'];
        }
        
        $data['year'] = date('Y');
        $data['actividad'] = $result = $this->pat->mostrar_act(null,$data['year'],$sec, $dep);
        foreach ($result as $row)
        {
            $aux[$row->iIdActividad] = $this->imgs_ods($row->iIdActividad);
        }
        
        $data['ods'] = $aux;
        $this->load->view('PAT/inicio_PAT', $data);
    }

    public function cargar() {
        $this->load->view('PAT/agregar_actividad');
    }

    public function abrirCapTxt() {
        $_SESSION['consulInf'] = null;
        if (isset($_POST['id'])) {
            $seg = new Class_seguridad();
            $iIdDetalleActividad = $this->input->post('id',true); // iIdDetalleActividad
            $iIdActividad = $this->pat->get_iIdActividad($iIdDetalleActividad);
            $data['vActividad'] = $this->pat->get_nameActividad($iIdDetalleActividad);
            $data['acceso'] = $seg->tipo_acceso(14,$_SESSION[PREFIJO.'_idusuario']);
            $data['iIdDetalleActividad'] = $iIdDetalleActividad;
            $data['texto'] = $this->pat->consultaLA($iIdActividad,$iIdDetalleActividad);
            $this->load->view('CapturaTxt/inicio_txt', $data);
        }
    }

    public function normaliza($cadena){
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
        ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
        bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtolower($cadena);
        return utf8_encode($cadena);
    }

    public function gettable() {
        $anio = $keyword = null;
        if (isset($_POST['keyword']) && !empty($_POST['keyword']))
        {
            $keyword =  $this->input->post('keyword',TRUE);
        }

        if (isset($_POST['anio']) && !empty($_POST['anio']))
        {
            $anio = $this->input->post('anio',TRUE);
        }
        $sec = (isset($_POST['search_eje'])) ? $this->input->post('search_eje',true):0;
        $dep = (isset($_POST['search_dependencia'])) ? $this->input->post('search_dependencia',true):0;
        $covid = $this->input->post('covid',true);

        $seg = new Class_seguridad();
        $data['acceso'] = $seg->tipo_acceso(14,$_SESSION[PREFIJO.'_idusuario']);
        $data['actividad'] = $result = $this->pat->mostrar_act($keyword, $anio,$sec,$dep,$covid);
        $aux = array();    
        foreach ($result as $row)
        {
            $aux[$row->iIdActividad] = $this->imgs_ods($row->iIdActividad);
        }
        
        $data['ods'] = $aux;        
        $data['all_sec'] = $all_sec = $seg->tipo_acceso(9,$_SESSION[PREFIJO.'_idusuario']);
        $data['all_dep'] = $all_dep = $seg->tipo_acceso(10,$_SESSION[PREFIJO.'_idusuario']);
        $data['p_clonar'] = $p_clonar = $seg->tipo_acceso(32,$_SESSION[PREFIJO.'_idusuario']);
        $this->load->view('PAT/vTablaAct', $data);
    }

    function imgs_ods($idAct) {
        $result = $this->pat->ods_actividad($idAct);
        $html = '';
        if($result->num_rows() > 0)
        {
            $result = $result->result();
            foreach ($result as $row)
            {
                $html.= '&nbsp;';
            }   
        }
        if($html != '') $html.= '';
        return $html;
    }

    public function editEje() {
        $data2['eje'] = $this->pat->mostrarEje();

        $this->load->view('PAT/editar_actividad', $data2);
    }

    public function obtenerActividades(){

        $iIdDependencia = isset($_POST['idDependencia']) ? $_POST['idDependencia'] : '';

        $actividades = $this->pat->obtenerActividades($iIdDependencia);

        echo json_encode($actividades);
        //
    }

    public function obtenerAreasRESP(){
        $iIdDependencia = isset($_POST['idDependencia']) ? $_POST['idDependencia'] : '';

        $areas = $this->pat->obtenerAreasRESP($iIdDependencia);

        echo json_encode($areas);
        //
    }

    public function edit() {
        $_SESSION['carritoFinan'] = null;
        $_SESSION['carritoUbpP'] = null;
        $_SESSION['valores'] = null;
        $_SESSION['valLinInfo'] = null;
        $data3['eje'] = $this->pat->mostrarEje();

        if (isset($_POST['id'])) {
            $seg    = new Class_seguridad();
            $opt    = new Class_options();
            $id     = $this->input->post('id',true); // iIdDetalleActividad
            $data3['consulta']  = $this->pat->preparar_update($id);

            //Obtengo el select de los ejes
            $ejes           = '';
            $dependencias   = '';
            $retos          = '';
            $catPoas        = '';

            $objReto        = $this->pat->getReto($data3['consulta'][0]->iReto);
            $arrRetos       = $this->pat->getRetosPorDependencia($objReto[0]->iIdDependencia);
            $arrDependencias= [];
            $dependencia    = '';

            if($data3['consulta'][0]->iideje != ''){
                $arrDependencias = $this->pat->getDependenciaPorEje($data3['consulta'][0]->iideje);
            }

            foreach ($data3['eje']  as $row) {
                $selected =  $row->iIdEje == $data3['consulta'][0]->iideje ? 'selected' : '';
                $ejes .= '<option value="'.$row->iIdEje.'" '.$selected.'>'.$row->vEje.'</option>';
            }

            foreach ($arrDependencias as $dep) {
                $selected =  $dep->iIdDependencia == $data3['consulta'][0]->iIdDependencia ? 'selected' : '';
                $dependencias .= '<option value="'.$dep->iIdDependencia.'" '.$selected.'>'.$dep->vDependencia.'</option>';
            }

            foreach ($arrRetos as $value) {
                $selected =  $value->iIdReto == $data3['consulta'][0]->iReto ? 'selected' : '';
                $retos .= '<option value="'.$value->iIdReto.'" '.$selected.'>'.$value->vDescripcion.'</option>';
            }

            $iIdActividad       = $data3['consulta'][0]->iIdActividad;   // Obtenemos el Id de l actividad
            $data3['finan']     = $this->pat->mostrarFinanciamiento($data3['consulta'][0]->iAnio);
            $data3['ubp']       = $this->pat->mostrarUbp($data3['consulta'][0]->iAnio);
            $all_sec            = $seg->tipo_acceso(9,$_SESSION[PREFIJO.'_idusuario']);
            $all_dep            = $seg->tipo_acceso(10,$_SESSION[PREFIJO.'_idusuario']);
            $data3['per_ods']   = $seg->tipo_acceso(41,$_SESSION[PREFIJO.'_idusuario']);
            $data3['alineacion']    = $this->pat->getCarritoSelec($iIdActividad);

            if($all_sec > 0 && $all_dep > 0) {
                $data3['ejes']          = $ejes;
                $data3['dependencias']  = $dependencias;
                $data3['retos']         = $retos;
            }
            $data3['retos']         = $retos;

            $this->pintarT_financiamiento($id);
            $this->pintarT_ubps($id);
            $data3['montoFinal']    = $this->sumaMonto();
            $data3['consulta2']     = $this->pat->preparar_update2($id);
            
            //Se trabaja con el catalogo de POAS
            $arrayDependencias      = $this->pat->getDependenciaById($data3['consulta'][0]->iIdDependencia );
            $dependencia            = $arrayDependencias[0]->vDependencia;


            /*$catalogosPOA   = json_decode($this->getCatalogoPOA(false));
            $dependencia    = $this->eliminar_tildes($dependencia);
            
            foreach ($catalogosPOA->datos as $value) {
                $valorFinanzas = $this->eliminar_tildes($value->dependenciaEjecutora);
                if(strtoupper($valorFinanzas) == strtoupper($dependencia)) {
                    $selected =  $value->numeroProyecto == $data3['consulta'][0]->vcattipoactividad ? 'selected' : '';
                    $catPoas .= '<option value="'.$value->numeroProyecto.'" '.$selected.'>'.$value->nombreProyecto.'</option>'; 
                }
            }*/
            
            $catalogosPOA   = $this->validarListaPOAEdit($id);
            $dependencia    = $this->eliminar_tildes($dependencia);
            
            foreach ($catalogosPOA as $value) {
                $valorFinanzas = $this->eliminar_tildes($value['dependenciaEjecutora']);
                if(strtoupper($valorFinanzas) == strtoupper($dependencia)) {
                    $selected =  $value['numeroProyecto'] == $data3['consulta'][0]->vcattipoactividad ? 'selected' : '';
                    $catPoas .= '<option value="'.$value['numeroProyecto'].'" '.$selected.'>'.$value['nombreProyecto'].'</option>'; 
                }
            }

            $data3['proyectoPrioritario']    = $this->pat->obtenerProyectosPrioritarios();
            $data3['programaPresupuestario']    = $this->pat->obtenerProgramaPresupuestario();
            $data3['nivelesMIR']    = $this->pat->obtenerNivelesMIR();
            $data3['resumenNarrativo']    = $this->pat->obtenerResumenNarrativo();
            $data3['ODS']    = $this->pat->obtenerODS();
           
            $seg = new Class_seguridad();
            $data3['acceso'] = $seg->tipo_acceso(14,$_SESSION[PREFIJO.'_idusuario']);
            $data3['catalogosPOA']  = $catalogosPOA;
            $data3['catPoas']       = $catPoas;
            $this->load->view('PAT/editar_actividad', $data3);
        }
    }
    public function obtenerResumenNarrativo(){
        $nivelMIR = isset($_POST['nivelMIR']) ? $_POST['nivelMIR'] : '';

        $mir = $this->pat->obtenerResumen($nivelMIR);

        echo json_encode($mir);
    }
    /**
     * Retorna la vista para agregar un nuevo reto
     * @return view
     */
    public function add()
    {
        $_SESSION['carritoFinan'] = null;
        $_SESSION['carritoUbpP'] = null;
        $_SESSION['valores'] = null;
        $_SESSION['valLinInfo'] = null;
        $data3['eje'] = $this->pat->mostrarEje();
        $seg = new Class_seguridad();
        $opt = new Class_options();

        
        $all_sec = $seg->tipo_acceso(9,$_SESSION[PREFIJO.'_idusuario']);
        $all_dep = $seg->tipo_acceso(10,$_SESSION[PREFIJO.'_idusuario']);
        $data3['per_ods'] = $seg->tipo_acceso(41,$_SESSION[PREFIJO.'_idusuario']);

        if($all_sec > 0 && $all_dep > 0) {
            $data3['ejes'] = $opt->options_tabla('eje',null);
            $data3['dependencias'] = $opt->options_tabla('dependencia', null,null);
            $data3['retos'] = $opt->options_tabla('retos',null);
            $data3['objDependencias'] = json_encode($this->pat->getDataTable('dependencia', null));
        }else{
            $data3['retos'] = $opt->options_tabla('retos', null, 'iIdDependencia = '.$_SESSION[PREFIJO.'_iddependencia']);
        }
        $dependencia = $this->pat->getDependenciaById($_SESSION[PREFIJO.'_iddependencia']);
        $data3['vDependencia']  = $dependencia[0]->vDependencia;
        $data3['idDependencia']  = $_SESSION[PREFIJO.'_iddependencia'];
        $data3['montoFinal']    = $this->sumaMonto();
        $data3['proyectoPrioritario']    = $this->pat->obtenerProyectosPrioritarios();
        $data3['programaPresupuestario']    = $this->pat->obtenerProgramaPresupuestario();
        $data3['nivelesMIR']    = $this->pat->obtenerNivelesMIR();
        $data3['resumenNarrativo']    = $this->pat->obtenerResumenNarrativo();
        $data3['ODS']    = $this->pat->obtenerODS();
        $seg = new Class_seguridad();
        $data3['acceso'] = $seg->tipo_acceso(14,$_SESSION[PREFIJO.'_idusuario']);
        $this->load->view('PAT/crear_actividad', $data3);
    }

    public function pintarT_selectores($id)
    {
        $_SESSION['carritoSelec'] = $this->pat->getCarritoSelec($id);
    }

    public function pintarT_financiamiento($id)
    {
        $fin = $this->pat->getCarritoFinan($id);
        $_SESSION['carritoFinan'] = $fin;
    }

    public function pintarT_ubps($id)
    {
        $ubp = $this->pat->getCarritoUbpP($id);
        $_SESSION['carritoUbpP'] = $ubp;
    }

    public function actualizarActividad()
    {
        if (isset($_POST['id']) && isset($_POST['NombAct'])) {

            $id = $this->input->post('id',true);

            $data = array(
                'vActividad' => $this->input->post('NombAct',true)
            );

            $resul = $this->pat->modificarAct($id, $data);
            echo $resul;
        } else {
            echo "No funcionó";
        }
    }

    public function actualizarDeatalleActividad()
    {
        if (isset($_POST['id']) && isset($_POST['NombAct']) && isset($_POST['annio'])) {

            $id = $this->input->post('id',true);

            $data = array(
                'iIdActividad' => $this->input->post('NombAct',true),
                'iAnio' => $this->input->post('annio',true)
            );

            $resul = $this->pat->modificarDetaAct($id, $data);
            echo $resul;
        } else {
            echo "No funcionó";
        }
    }

    public function eliminarActividad()
    {
        $key = $_POST['key'];
        echo $this->pat->eliminarDetaActividad($key);
    }

    ////////////////

    public function dPoliPub($eje)
    {
        //$eje = 0;

        /*if (!empty($_POST['eje']) && $_POST['eje'] != '0') {
                $eje = $_POST['eje'];
            }
            echo $eje;*/
        $PolPub = $this->pat->mostrarPpublica($eje);
        $opc = '<option value="0">Seleccione...</option>';
        foreach ($PolPub as $value) {
            $opc .= "<option value='$value->iIdTema'>$value->vTema</option>";
        }
        echo $opc;
    }

    public function dObjetivo($popu)
    {
        $Obj = $this->pat->mostrarObjetivo($popu);
        $opc = '<option value="0">Seleccione...</option>';
        foreach ($Obj as $value) {
            $opc .= "<option value='$value->iIdObjetivo'>$value->vObjetivo</option>";
        }
        echo $opc;
    }

    public function dEstrategia($obj)
    {
        $est = $this->pat->mostrarEstrategia($obj);
        $opc = '<option value="0">Seleccione...</option>';
        foreach ($est as $value) {
            $opc .= "<option value='$value->iIdEstrategia'>$value->vEstrategia</option>";
        }
        echo $opc;
    }

    public function dLineaAccion($est)
    {
        $la = $this->pat->mostrarLineaAccion($est);
        $opc = '<option value="0">Seleccione...</option>';
        foreach ($la as $value) {
            $opc .= "<option value='$value->iIdLineaAccion'>$value->vLineaAccion</option>";
        }
        echo $opc;
    }

    public function insertarAct()
    {
        //$sesion = $_SESSION[PREFIJO.'_iddependencia'];
        if (isset($_POST['NombAct'])) {
            $data = array(
                'vActividad' => $this->input->post('NombAct',true),
                'iIdDependencia' => (int) $_SESSION[PREFIJO . '_iddependencia']
            );

            $idAct = $this->pat->agregarAct($data);
            //$data1['iIdActividad'] = $this->pat->agregarAct($data);
            //$this->pat->agregarDetAct($data1);

            if ($idAct > 0) {
                $data1 = array(
                    'iIdActividad' => $idAct,
                    'iAnio' => $this->input->post('annio',true)
                );
                $insert = $this->pat->agregarDetAct($data1);

                echo $insert;
            }
        }
    }

    /* Guardar nuevo */
    public function guardarNewAct() {
        //$sesion = $_SESSION[PREFIJO.'_iddependencia'];
        $idDep =  $_SESSION[PREFIJO.'_iddependencia'];
        if(isset($_POST['depAct'])){
            $idDep = $this->input->post('depAct');
        }
        $idEje = null;
        if (isset($_POST['RetoAct'])) {
            $idEje =  $this->input->post('RetoAct', true);
        }else{
            $objReto = $this->pat->getReto($this->input->post('iReto',true));
            $idEje = $objReto[0]->iIdEje;
        }
        $incluyeMIR = $this->input->post('icluyeMIR', true);
        $incluyeAglomeraMIR = $this->input->post('tieneAglomeracion', true);
        $idActividadAglomera = $this->input->post('idActividad', true);
        $idNivelMIR = $this->input->post('idNivelMIR', true);
        $valorMIR = 0;
        $valorAglomeraMIR = 0;

        if($incluyeMIR == 'on'){
            $valorMIR = 1;
        }else{
            $valorMIR = 0;
        }

        if($incluyeAglomeraMIR == 'on'){
            $valorAglomeraMIR = 1;
        }else{
            $valorAglomeraMIR = 0;
        }


        if (isset($_POST['NombAct'])) {
            $data = array(
                'vActividad'    => $this->input->post('NombAct',true),
                'vObjetivo'     => $this->input->post('objGeneral',true),
                'vDescripcion'  => strip_tags($_POST['descripcion']),
                'iActivo'       => 1,
                'iODS'          => $this->input->post('selectODS',true)?: 0,
               // 'iIdDependencia'=> $this->input->post('depAct'),
               'iIdDependencia'=> $idDep,
              //  (isset($_POST['depAct'])) ? $this->input->post('depAct'):0;

                'vResponsable'  => $this->input->post('iAreaResponsable',true),
                'vCargo'        => $this->input->post('vCargo',true),
                'vCorreo'       => $this->input->post('vCorreo',true),
                'vTelefono'     => $this->input->post('vTelefono',true),
                'vAccion'       => $this->input->post('vAccion',true),
                'vEstrategia'   => $this->input->post('vEstrategia',true),
                'iReto'         => $this->input->post('iReto',true),
                'iideje'        => $idEje,
                'vtipoactividad'    => $this->input->post('vTipoActividad', true),
                'vcattipoactividad' => $this->input->post('valCatPoas', true),
                'iIncluyeMIR' => $valorMIR ?: 0,
                'iAglomeraMIR' => $valorAglomeraMIR ,
                'iIdActividadMIR' => $idActividadAglomera ?: null,
                'iIdNivelMIR' => $idNivelMIR ?: null,
                'iIdProgramaPresupuestario' => $this->input->post('ProgramaPresupuestario',true) ?: null,
                'vResumenNarrativo' => $this->input->post('resumenNarrativo',true) ?: null,
                'vSupuesto' => $this->input->post('txtSupuesto',true)?: null,
                'iIdProyectoPrioritario' => $this->input->post('selectProyectoPrioritario',true)?: null,
            );

            $idAct = $this->pat->agregarAct($data);
            //$data1['iIdActividad'] = $this->pat->agregarAct($data);
            //$this->pat->agregarDetAct($data1);

            if ($idAct > 0) {
                $data1 = array(
                    'iIdActividad'              => $idAct,
                    'iAnio'                     => $this->input->post('annio',true),
                    'dInicio'                   => $this->input->post('fINICIO',true),
                    'dFin'                      => $this->input->post('fFIN',true),
                    'nPresupuestoAutorizado'    => floatval(EliminaComas($this->input->post('nPresupuestoAutorizado',true))),//$this->input->post('nPresupuestoAutorizado',true),
                    'dUltActAvance'             => null, //$this->input->post('fINICIO',true),
                    'dUltActTexto'              => null, //$this->input->post('fINICIO',true),
                    'dFechaElim'                => null, //$this->input->post('fINICIO',true),
                    'vClavePOA'                 => $this->input->post('catPoas',true) ?: '',

                );
                $insert = $this->pat->agregarDetAct($data1);

                if ($insert > 0) {
                    echo 'Correcto';
                } else {
                    echo 'Error';
                }
            }
        }
    }

    /* Guardar edición */

    public function guardarAct()
    {
       
        if (isset($_POST['id']) && isset($_POST['idAct']) && isset($_POST['NombAct']) && isset($_POST['objGeneral']) && isset($_POST['descripcion'])) {
            $iIdDependencia =  $_SESSION[PREFIJO.'_iddependencia'];
            if(isset($_POST['depAct'])){
                $iIdDependencia = $this->input->post('depAct');
            }
            $idEje = null;
            if (isset($_POST['RetoAct'])) {
                $idEje =  $this->input->post('RetoAct', true);
            }else{
                $objReto = $this->pat->getReto($this->input->post('iReto',true));
                $idEje = $objReto[0]->iIdEje;
            }
            $id             = $this->input->post('id',true);    //$iIdDetalleActividad
            $idActividad    = $this->input->post('idAct',true);
            //$iIdDependencia = (isset($_POST['depAct'])) ? $this->input->post('depAct'):0;

            $incluyeMIR = $this->input->post('icluyeMIR', true);
            $incluyeAglomeraMIR = $this->input->post('tieneAglomeracion', true);
            $idActividadAglomera = $this->input->post('idActividad', true);
            $idNivelMIR = $this->input->post('idNivelMIR', true);
            $valorMIR = 0;
            $valorAglomeraMIR = 0;

            if($incluyeMIR == 'on'){
                $valorMIR = 1;
            }else{
                $valorMIR = 0;
            }

            if($incluyeAglomeraMIR == 'on'){
                $valorAglomeraMIR = 1;
            }else{
                $valorAglomeraMIR = 0;
            }

            //  Iniciamos laa transaccion
            $con = $this->mseg->iniciar_transaccion();

            // Actualizamos la atabla Actividad
            $data = array(
                'vActividad'        => $this->input->post('NombAct',true),
                'vNombreActividad'  => $this->input->post('vNombreActividad',true),
                'vObjetivo'         => $this->input->post('objGeneral',true),
                'vDescripcion'      => strip_tags($_POST['descripcion']),
                'iODS'              => $this->input->post('selectODS',true)?: 0,
                'vResponsable'      => $this->input->post('iAreaResponsable',true),
                'vCargo'            => $this->input->post('vCargo',true),
                'vCorreo'           => $this->input->post('vCorreo',true),
                'vTelefono'         => $this->input->post('vTelefono',true),
                'vJustificaCambio'  => $this->input->post('vJustificaCambio',true),
                'vAccion'           => $this->input->post('vAccion',true),
                'vEstrategia'       => $this->input->post('vEstrategia',true),
                'iReto'             => $this->input->post('iReto',true),
                'iideje'            => $idEje,
                'vtipoactividad'    => $this->input->post('vTipoActividad', true),
                'vcattipoactividad' => $this->input->post('valCatPoas', true),
                'iIncluyeMIR' => $valorMIR,
                'iAglomeraMIR' => $valorAglomeraMIR,
                'iIdActividadMIR' => $idActividadAglomera ?: null,
                'iIdNivelMIR' => $idNivelMIR ?: null,
                'iIdProgramaPresupuestario' => $this->input->post('ProgramaPresupuestario',true) ?: null,
                'vResumenNarrativo' => $this->input->post('resumenNarrativo',true) ?: null,
                'vSupuesto' => $this->input->post('txtSupuesto',true)?: null,
                //'iIdProyectoPrioritario' => $this->input->post('selectProyectoPrioritario',true)?: null,
            );

            if(isset($_POST['iODS'])) $data['iODS'] = 1;

            if($iIdDependencia > 0) $data['iIdDependencia'] = $iIdDependencia;
            $where['iIdActividad'] = $idActividad;
            $this->mseg->actualiza_registro('Actividad', $where, $data, $con);

            // Actualizamos la tabla DetalleActividad
            $data1 = array(
                'iIdActividad' => $idActividad,
                'iAnio' => $this->input->post('annio',true),
                'dInicio' => $this->input->post('fINICIO',true),
                'dFin' => $this->input->post('fFIN',true),
                'iReactivarEconomia' => (isset($_POST['iReactivarEconomia'])) ? 1:0,
                'nPresupuestoModificado' => floatval(EliminaComas($this->input->post('nPresupuestoModificado',true))),
                'nPresupuestoAutorizado' => floatval(EliminaComas($this->input->post('nPresupuestoAutorizado',true))),
                'vClavePOA' => $this->input->post('catPoas',true) ?: null,
            );
            $where1['iIdDetalleActividad'] = $id;
            $this->mseg->actualiza_registro('DetalleActividad', $where1, $data1, $con);

            //Eliminar ActividadLineaAccion
            $del = $this->mseg->elimina_registro('ActividadLineaAccion',$where, $con);
            $contLA = $this->input->post('contLA');
            //  Guardamos las lineas de acción
            for ($i=0; $i < $contLA; $i++)
            { 
                if(isset($_POST['la'.$i]))
                {
                    $LinAcc['iIdActividad'] = $idActividad;
                    $LinAcc['iIdLineaAccion'] = $this->input->post('la'.$i);
                    $this->mseg->inserta_registro_no_pk('ActividadLineaAccion', $LinAcc, $con);
                }
            }

            //Eliminar DetalleActividadFinanciamiento
            $this->mseg->elimina_registro('DetalleActividadFinanciamiento', $where1, $con);
            //  Guardamos financiamiento
            $actFin = $_SESSION['carritoFinan'];

            foreach ($actFin as $Af) {
                if ($Af->iActivo > 0) {
                    $fin['iIdDetalleActividad'] = $id;
                    $fin['iIdFinanciamiento'] = $Af->iIdFinanciamiento;
                    $fin['monto'] = $Af->monto;

                    $this->mseg->inserta_registro_no_pk('DetalleActividadFinanciamiento', $fin, $con);
                }
            }

            //Eliminar DetalleActividadFinanciamiento
            $this->mseg->elimina_registro('DetalleActividadUBP', $where1, $con);

            //Gardamos las UBPs
            $ActUbp = $_SESSION['carritoUbpP'];

            foreach ($ActUbp as $Au) {
                if ($Au->iActivo > 0) {
                    $UBP['iIdDetalleActividad'] = $id;
                    $UBP['iIdUbp'] = $Au->iIdUbp;

                    $this->mseg->inserta_registro_no_pk('DetalleActividadUBP', $UBP, $con);
                }
            }

            // Finalizar transaccion
            if ($this->mseg->terminar_transaccion($con) == true) {
                echo 'Correcto';
            } else {
                echo 'Error';
            }
        }
    }

    public function guardarInforme()
    {
        if(isset($_POST['iIdDetalleActividad']) && !empty($_POST['iIdDetalleActividad']))
        {
            $iIdDetalleActividad = $this->input->post('iIdDetalleActividad');
            $iIdActividad = $this->pat->get_iIdActividad($iIdDetalleActividad);

            $lineas = $this->pat->consultaLA($iIdActividad,$iIdDetalleActividad);
            $con = $this->mseg->iniciar_transaccion();

            // Eliminamos textos anteriores
            $where['iIdDetalleActividad'] = $iIdDetalleActividad;
            $del = $this->mseg->elimina_registro('DetalleActividadLineaAccion',$where,$con);
            // Insertamos los nuevos textos
            foreach ($lineas as $la) 
            {
                $datos = array( 
                    'iIdDetalleActividad' => $iIdDetalleActividad,
                    'iIdLineaAccion' => $la->iIdLineaAccion,
                    'tInforme1'=> base64_decode($this->input->post('editor1_'.$iIdDetalleActividad.'_'.$la->iIdLineaAccion)),
                    'tInforme2'=> base64_decode($this->input->post('editor2_'.$iIdDetalleActividad.'_'.$la->iIdLineaAccion)),
                    'tInforme3'=> base64_decode($this->input->post('editor3_'.$iIdDetalleActividad.'_'.$la->iIdLineaAccion)),
                    'tInforme4'=> base64_decode($this->input->post('editor4_'.$iIdDetalleActividad.'_'.$la->iIdLineaAccion))
                );                
                $rows = $this->mseg->inserta_registro_no_pk('DetalleActividadLineaAccion',$datos,$con);
            }

            if($this->mseg->terminar_transaccion($con)) echo '0';
            else echo 'Ha ocurrido un error al intentar guardar los cambios';
        }
    }

    /* Carrito de selectores */

    public function carritoSelectores()
    {
        $data = array();
        $result = 0;
        $existe = false;
        $key = $this->input->post('linAcc',true);
        if (!is_null($_SESSION['carritoSelec'])) {
            $data = $_SESSION['carritoSelec'];
        }
        if (isset($_POST['linAcc'])) {
            foreach ($data as $r) {
                if ($r->iIdLineaAccion == $key) {
                    $existe = true;
                    if ($r->iActivo == 1) {
                        $result = 0;
                        break;
                    } else {
                        $r->iActivo = 1;
                        $result = 1;
                        break;
                    }
                }
            }
            if ($existe === false) {
                $instrumento = $this->pat->getRecord($key);
                if (isset($instrumento[0])) {
                    $instrumento = $instrumento[0];
                    $instrumento->iActivo = 1;
                    $data[] = $instrumento;
                    $result = 1;
                }
            }
        }
        echo json_encode($result);
        $_SESSION['carritoSelec'] = $data;
    }

    public function removecarritoSelectores()
    {
        $data = array();
        $result = 0;
        $key = $this->input->post('linAcc',TRUE);
        if (isset($_SESSION['carritoSelec']) && !empty($_SESSION['carritoSelec'])) {
            $data = $_SESSION['carritoSelec'];
            foreach ($data as $r) {
                if ($r->iIdLineaAccion == $key) {
                    $r->iActivo = 0;
                    $result = 1;
                    break;
                }
            }
        }
        echo json_encode($result);
    }

    public function generar_tabla()
    {
        $data = array();
            if (!is_null($_SESSION['carritoSelec'])) {
                $data = $_SESSION['carritoSelec'];
            }
            
            $row = '';
            foreach ($data as $r) {
                $activo = '';
                if ($r->iActivo == 1) {

                    if(!is_null($_SESSION['valLinInfo'])){
                        foreach ($_SESSION['valLinInfo'] as $r2) 
                        {
                            if($r2['id']==$r->iIdLineaAccion){
                                $activo = $r2['sel'];
                                //print_r($r);
                                //print_r($r2['id']);
                                break;
                            }
                        }
                    }
                    
                    $button = ($r->caracteres > 10) ? '<i class="fas fa-info-circle" title="La vinculación no puede ser eliminada debido a que se ha capturado texto para el informe"></i>':'<button type="button" name="dltactla" title="Eliminar" id="dltactla" type="button" class="btn btn-xs waves-effect waves-light boton_eliminar dltactla" onclick="eliminarCarrito('.$r->iIdLineaAccion.')"><i class="mdi mdi-close"></i></button>';
                        
                    $row .= '<tr>
                        <td>' . $r->vEje . '</td>
                        <td>' . $r->vTema . '</td>
                        <td>' . $r->vObjetivo . '</td>
                        <td>' . $r->vEstrategia . '</td>
                        <td>' . $r->vLineaAccion . '</td>
                        <td align="center">'.$button.'</td>
                    </tr>';
                }
            }
            $tb = '<table class="table table-striped table-bordered display" style="width:100%" id="grid3">
                <thead>
                    <tr>
                        <th>Eje</th>
                        <th>Politica pública</th>
                        <th>Objetivo</th>
                        <th>Estrategia</th>
                        <th>Linea de acción</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    ' . $row . '
                </tbody>
            </table>
            <script>
            $(document).ready(function() {
                $("#grid3").DataTable();
            });
            </script>
            ';
            echo $tb;
    }

    /* Carrito de financiamiento */

    public function carritoFinanciamiento()
    {
        $data = array();
        $result = 0;
        $existe = false;
        $key = $this->input->post('fuenteF',true);
        if (!is_null($_SESSION['carritoFinan'])) {
            $data = $_SESSION['carritoFinan'];
        }
        if (isset($_POST['fuenteF'])) {
            foreach ($data as $r) {
                if ($r->iIdFinanciamiento == $key) {
                    $existe = true;
                    if ($r->iActivo == 1) {
                        $result = 0;
                        break;
                    } else {
                        $r->iActivo = 1;
                        $r->monto = $this->input->post('montoF',true); 
                        $result = 1;
                        break;
                    }
                }
            }
            if ($existe === false) {
                $instrumento = $this->pat->getFinanciamiento($key);
                if (isset($instrumento[0])) {
                    $instrumento = $instrumento[0];
                    if (isset($_POST['montoF'])) {
                        $instrumento->monto = $this->input->post('montoF',true);                        
                    } else {
                        $instrumento->monto = null;
                    }
                    //$instrumento->iActivo = 1;
                    $data[] = $instrumento;
                    $result = 1;
                }
            }
        }
        echo json_encode($result);
        $_SESSION['carritoFinan'] = $data;
    }

    public function removecarritoFinanciamiento()
    {
        $data = array();
        $result = 0;
        $key = $this->input->post('fuenteF',true);
        if (isset($_SESSION['carritoFinan']) && !empty($_SESSION['carritoFinan'])) {
            $data = $_SESSION['carritoFinan'];
            foreach ($data as $r) {
                if ($r->iIdFinanciamiento == $key) {
                    $r->iActivo = 0;
                    $result = 1;
                    break;
                }
            }
        }
        echo json_encode($result);
    }

    public function sumaMonto()
    {
        $data = $_SESSION['carritoFinan'];
        $total = 0;
        foreach ($data as $r) {
            if ($r->iActivo == 1) {
                $total = bcadd($total, $r->monto, 2);
            }
        }
        return $total;
        //return number_format($total, 2, ".", ",");
    }

    public function getsumaMonto()
    {
        print($this->sumaMonto());
    }

    function number_format_string($number) {
        return strrev(implode(',', str_split(strrev($number), 3)));
    }
    public function tablaFinanciamiento()
    {
        $data = array();
        if (!is_null($_SESSION['carritoFinan'])) {
            $data = $_SESSION['carritoFinan'];
        }
        $row = '';
        
        foreach ($data as $r) {
            if ($r->iActivo == 1) {
                
                $valor = explode('.', $r->monto);
                $resultado = '';
                if (isset($valor[1])){
                    $resultado = $this->number_format_string($valor[0]).'.'.$valor[1];
                }else{
                    $resultado = $this->number_format_string($valor[0]);
                }

                $row .= '
                    <tr>
                    <td>' . $r->vFinanciamiento . '</td>
                    <td> $' . $resultado . '</td>
                    <td align="center"><button type="button" title="Eliminar" class="btn btn-xs waves-effect waves-light boton_eliminar " onclick="eliminarCarritoF(' . $r->iIdFinanciamiento . ')"><i class="mdi mdi-close"></i></button></td>
                    </tr>';
            }
        }
        $tb = '<table class="table table-striped table-bordered display" style="width:100%" id="grid">
            <thead>
                <tr>
                    <th>Nombre de la fuente de financiamiento</th>
                    <th>Monto</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
            ' . $row . '
            </tbody>
        </table>
        <script>
        $(document).ready(function() {
            $("#grid").DataTable();
        });
        </script>
        ';
        echo $tb;
    }

    /* Carrito de UBP y PP */

    public function carritoUbpsPp()
    {
        $data = array();
        $result = 0;
        $existe = false;
        $key = $this->input->post('NumUBP',true);
        if (!is_null($_SESSION['carritoUbpP'])) {
            $data = $_SESSION['carritoUbpP'];
        }
        if (isset($_POST['NumUBP'])) {
            foreach ($data as $r) {
                if ($r->iIdUbp == $key) {
                    $existe = true;

                    if ($r->iActivo == 1) {
                        $result = 0;
                        break;
                    } else {
                        $r->iActivo = 1;
                        $result = 1;
                        break;
                    }
                }
            }
            if ($existe === false) {
                $instrumento = $this->pat->getUbpsPP($key);
                if (isset($instrumento[0])) {
                    $instrumento = $instrumento[0];
                    $instrumento->iActivo = 1;
                    $data[] = $instrumento;
                    $result = 1;
                }
            }
        }
        echo json_encode($result);
        $_SESSION['carritoUbpP'] = $data;
    }

    public function removecarritoUbpsPp()
    {
        $data = array();
        $result = 0;
        $key = $this->input->post('NumUBP',true);
        if (isset($_SESSION['carritoUbpP']) && !empty($_SESSION['carritoUbpP'])) {
            $data = $_SESSION['carritoUbpP'];
            foreach ($data as $r) {
                if ($r->iIdUbp == $key) {
                    $r->iActivo = 0;
                    $result = 1;
                    break;
                }
            }
        }
        echo json_encode($result);
    }

    public function tablaUbpsPp()
    {
        $data = array();
        if (!is_null($_SESSION['carritoUbpP'])) {
            $data = $_SESSION['carritoUbpP'];
        }
        $row = '';

        foreach ($data as $r) {
            if ($r->iActivo == 1) {
                $row .= '
                    <tr>
                        <td>' . $r->vClave . '</td>
                        <td>' . $r->vUBP . '</td>
                        <td>' . $r->iNumero . '</td>
                        <td>' . $r->vProgramaPresupuestario . '</td>
                        <td align="center"><button type="button" title="Eliminar" class="btn btn-xs waves-effect waves-light boton_eliminar " onclick="eliminarCarritoUP(' . $r->iIdUbp . ')"><i class="mdi mdi-close"></i></button></td>
                    </tr>';
            }
        }
        $tb = '<table class="table table-striped table-bordered display" style="width:100%" id="grid2">
            <thead>
                <tr>
                <th>Número POA</th>
                <th>Nombre POA</th>
                <th>Número PP</th>
                <th>Nombre PP</th>
                <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
            ' . $row . '
            </tbody>
        </table>
        <script>
        $(document).ready(function() {
            $("#grid2").DataTable();
        });
        </script>
        ';
        echo $tb;
    }

    //Recuperar datos del carrito
    function recuperarLineaAccion($id)
    {
        $query = $this->pat->getLineaAccion($id);
        $ids = '';
        if ($query) {
            $query = $query->result();

            foreach ($query as $dato) {
                if ($ids != '') $ids .= ',';
                $ids .= $dato->iIdLineaAccion;
            }
        }
        return $ids;
    }

    //Convierte el contenido HTML en formato PDF
    public function ShowFichaActividad(){
        try 
        {
            $val_ent = array();            
            
            $id_detact = $this->uri->segment('3');
            $save_type = $this->uri->segment('4');
            $temp_dir = $this->uri->segment('5');

            $data= $this->Ficha_Actividad();
            $this->load->library('ReportePdf');
            if(true)
            {
                if(true)
                {
                    $pdf = new ReportePdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
                    $pdf->config();        
                    $pdf->body($data);

                    if(!empty($save_type))
                    {
                        $this->load->model('M_reporteAct');
                        $mod = new M_reporteAct();

                        // Creamos un directorio temporal
                        if(empty($temp_dir)) $temp_dir = SHA1(rand(1000,9999));
                        
                        $dir = __DIR__.'/../../public/reportes/'.$temp_dir;

                        if(!is_dir($dir)) mkdir($dir);

                        // Consultamos el id del Eje y nombre corto de la dependencia para agrupar por carpetas
                        $row = $mod->getEjeDep($id_detact);
                        //$ruta = __DIR__.'/../../public/reportes/'.$row->iIdEje;
                        $ruta = $dir.'/'.$row->iIdEje;
                        if(!is_dir($ruta)) mkdir($ruta);
                        $ruta.= '/'.$row->vNombreCorto; 
                        if(!is_dir($ruta)) mkdir($ruta);

                        // Si es llamada por el reporte del listado de reportes
                        $ruta.= '/'.$id_detact.'.pdf';
                        $pdf->Output($ruta, 'F');
                        
                        $response['status'] = true;
                        $response['temp_dir'] = $temp_dir;

                        echo json_encode($response);
                    }
                    else
                    {
                        $pdf->Output('FichaActividad.pdf', 'D'); 
                    }
                    
                }
                else 
                {                    
                    echo '<h2>La Actividad no cuenta con fuentes de financiamiento</h2>';                    
                }                
            }
            else echo '<h2>La meta de los entregables debe ser mayor a cero, favor de verificarlos</h2>';
            
            
        }
        catch (Exception $e) 
        {
            echo "Error al momento de descargar el documento";
        }
    }


    public function ShowFichaActividadobj(){
        try 
        {
            $val_ent = array();            
            
            $id_detact = $this->uri->segment('3');
            $save_type = $this->uri->segment('4');
            $temp_dir = $this->uri->segment('5');

            $data= $this->Ficha_Actividadobj();
            $this->load->library('ReportePdf');
            if(true)
            {

                //if($data['presupuesto_modificado'] > 0)
                if(true)
                {
                    $pdf = new ReportePdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
                    $pdf->config();        
                    $pdf->bodyobj($data);

                    if(!empty($save_type))
                    {
                        $this->load->model('M_reporteAct');
                        $mod = new M_reporteAct();

                        // Creamos un directorio temporal
                        if(empty($temp_dir)) $temp_dir = SHA1(rand(1000,9999));
                        
                        $dir = __DIR__.'/../../public/reportes/'.$temp_dir;

                        if(!is_dir($dir)) mkdir($dir);

                        // Consultamos el id del Eje y nombre corto de la dependencia para agrupar por carpetas
                        $row = $mod->getEjeDep($id_detact);
                        //$ruta = __DIR__.'/../../public/reportes/'.$row->iIdEje;
                        $ruta = $dir.'/'.$row->iIdEje;
                        if(!is_dir($ruta)) mkdir($ruta);
                        $ruta.= '/'.$row->vNombreCorto; 
                        if(!is_dir($ruta)) mkdir($ruta);

                        // Si es llamada por el reporte del listado de reportes
                        $ruta.= '/'.$id_detact.'.pdf';
                        $pdf->Output($ruta, 'F');
                        
                        $response['status'] = true;
                        $response['temp_dir'] = $temp_dir;

                        echo json_encode($response);
                    }
                    else
                    {
                        $pdf->Output('FichaActividad.pdf', 'D'); 
                    }
                    
                }
                else 
                {                    
                    echo '<h2>La Actividad no cuenta con fuentes de financiamiento</h2>';                    
                }                
            }
            else echo '<h2>La meta de los entregables debe ser mayor a cero, favor de verificarlos</h2>';
            
            
        }
        catch (Exception $e) 
        {
            echo "Error al momento de descargar el documento";
        }
    }


    //Redirecciona a la vista de la ficha_actividad
    public function Ficha_Actividadobj(){

        $id_detact = $this->uri->segment('3');
        $actividad = $this->pat->obtener_informacion_actividad($id_detact);
        $lineasaccion = $this->pat->obtener_alineacion_actividad($id_detact);
        $entregables = $this->pat->mostrar_actividadentregables($id_detact);
        $municipios= $this->pat->obtener_municipios_actividad($id_detact);
        $pe = $this->pat->suma_presupuesto_ejercido($id_detact);
        $pm = $this->pat->suma_presupuesto_modificado($id_detact);

        if($id_detact != NULL){
            //Actividad
            $data['actividad'] = $this->pat->obtener_informacion_actividad($id_detact)->vActividad;
            $data['descact'] = $this->pat->obtener_informacion_actividad($id_detact)->vDescripcion;
            $data['objact'] = $this->pat->obtener_informacion_actividad($id_detact)->vObjetivo;            
            //vDependencia    
            $data['vdependencia']=((isset($actividad->vDependencia))?$actividad->vDependencia:'');
            $data['pres_mod'] = $actividad->nPresupuestoModificado;
            //Detalle linea acción
            $data['lineasaccion']=$lineasaccion;
            //Detalle entregables
            foreach($entregables as $ent)
            {
                $sumatotal = $this->pat->suma_avances_total($ent->iIdDetalleEntregable);
                if($sumatotal->total_avance != NULL){
                    $total = $sumatotal->total_avance;
                    $ejercido = $sumatotal->monto_total;
                }else{
                    $ejercido = $total = 0;
                }
                $data['entregables'][] = array(
                         'vEntregable' => $ent->vEntregable,    
                         'vAvance' => $total,
                         'vMeta' => $ent->nMeta,
                         'ejercido' => $ejercido
                 );
                }   
            //$data['entregables']=$entregables;       
           //Municipios   
           $mpios = array();
           foreach($municipios as $key=>$mun)
           {
               $mpios[] = $mun->iIdMunicipio;
           }
           $data['edos_a_pintar']=$mpios;    
            //id actividad            
            $data['idactividad'] =$id_detact;
            //presupuesto ejercido
            if($pe->monto_total != NULL){
                $data['presupuesto_ejercido'] = $pe->monto_total;
            }else{
                $data['presupuesto_ejercido'] = 0;
            }
            //presupuesto modificado
            if($pm->monto_total != NULL){
                $data['presupuesto_modificado'] = $pm->monto_total;
            }else{
                $data['presupuesto_modificado'] = 0;
            }
           return $data; 
        }
    }

    //Redirecciona a la vista de la ficha_actividad
    public function Ficha_Actividad(){

        $id_detact = $this->uri->segment('3');
        $actividad = $this->pat->obtener_informacion_actividad($id_detact);
        $lineasaccion = $this->pat->obtener_alineacion_actividad($id_detact);
        $ods = $this->pat->obtener_alineacion_ods($id_detact);
        $entregables = $this->pat->mostrar_actividadentregables($id_detact);
        $municipios= $this->pat->obtener_municipios_actividad($id_detact);
        $pe = $this->pat->suma_presupuesto_ejercido($id_detact);
        $pm = $this->pat->suma_presupuesto_modificado($id_detact);

        if($id_detact != NULL){
            //Actividad
            $data['actividad'] = $actividad->vActividad;
            $data['nPresupuestoModificado'] = $actividad->nPresupuestoModificado;
            //vDependencia    
            $data['vdependencia']=((isset($actividad->vDependencia))?$actividad->vDependencia:'');
            //Detalle linea acción
            $data['lineasaccion']=$lineasaccion;
            $data['ods'] = $ods;
            //Detalle entregables
            foreach($entregables as $ent)
            {
                $sumatotal = $this->pat->suma_avances_total($ent->iIdDetalleEntregable);
                if($sumatotal->total_avance != NULL){
                    $total = $sumatotal->total_avance;
                    $ejercido = $sumatotal->monto_total;
                }else{
                    $ejercido = $total = 0;
                }
                $data['entregables'][] = array(
                         'vEntregable' => $ent->vEntregable,	
                         'vAvance' => $total,
                         'vMeta' => $ent->nMeta,
                         'vMetaModificada' => $ent->nMetaModificada,
                         'ejercido' => $ejercido
                 );
                }   
            //$data['entregables']=$entregables;       
           //Municipios   
           $mpios = array();
           foreach($municipios as $key=>$mun)
           {
               $mpios[] = $mun->iIdMunicipio;
           }
           $data['edos_a_pintar']=$mpios;    
            //id actividad            
            $data['idactividad'] =$id_detact;
            //presupuesto ejercido
            if($pe->monto_total != NULL){
                $data['presupuesto_ejercido'] = $pe->monto_total;
            }else{
                $data['presupuesto_ejercido'] = 0;
            }
            //presupuesto modificado
            if($pm->monto_total != NULL){
                $data['presupuesto_modificado'] = $pm->monto_total;
            }else{
                $data['presupuesto_modificado'] = 0;
            }
           return $data; 
        }
    }

    //Agregado patra generar la imagen
    public function graficar($im, $total, $pctv)
	{
		$fondo = imagecolorallocate($im, 255, 255, 255);
		$arc100 = imagecolorallocate($im, 41, 34, 91);
		$arcpct = imagecolorallocate($im, 31, 111, 182);
		$letra = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im,0,0,400,300, $fondo);
        $pct = 270 - $pctv*270/$total;
        if($pctv!=0)
        {
            imagefilledarc($im,130,150,150,150,$pct,270,$arcpct,IMG_ARC_EDGED);
            imagefilledarc($im,130,150,150,150,$pct,270,$arcpct,IMG_ARC_EDGED);
        }
        if($total!=0)
        {
            imagefilledarc($im,130,150,250,250,0,270,$arc100,IMG_ARC_EDGED);
		    imagefilledarc($im,130,150,200,200,0,270,$fondo,IMG_ARC_EDGED);   
        }
        imagefilledrectangle($im,230,50,260,60, $arcpct);
        imagefilledrectangle($im,230,100,260,110, $arc100);
		imagestring ($im, 1,265,50,"Ppto ejercido:",$letra);
        imagestring ($im, 2,265,70,"$".$pctv,$letra);	
        imagestring ($im, 1,265,100,"Ppto Modificado:",$letra);
		imagestring ($im, 2,265,120,"$".$total,$letra);	
    }

    function genSVG($edos_a_pintar, $idactividad)
    {
            $ruta = str_replace('system','',BASEPATH).'public/';  

            $file = fopen($ruta.'ImgTemporal/'.$idactividad.'.svg', "w");

            $cadena = <<<EOD
                <?xml version="1.0" standalone="no"?>
                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 20010904//EN"
                    "http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                    width="1024px" height="800px" viewBox="0 0 1024 800"
                    preserveAspectRatio="xMidYMid meet">
                <metadata>
                    Created by JLira, using GeoJSON
                </metadata>
                <g transform="translate(0.000000,600.000000) scale(0.70000, 0.60000)" fill="#FF0000" stroke="none">\n
                EOD;
        $json = file_get_contents($ruta."data.json");
        $data = json_decode($json);
        //$array= array(1,5,15,33,48,65,104);
        foreach ($data->mapData as $key => $value) {
            if(in_array($value->id, $edos_a_pintar))
                $relleno = "#29225b";
            else
                $relleno = "none";
            $cadena = $cadena.'<path stroke="lightgray" id="'.$value->id.'" fill="'.$relleno.'"'."\n".' d="'.$value->path.'" />'."\n";
        }
        $cadena = $cadena. " </g>\n
        </svg>";
            fwrite($file, $cadena . PHP_EOL);
            fclose($file);
    }
    //Crea el contenido HTML que se convertira en PDF
    public function Contenido_HTML_PDF($id_detact){

        $actividad = $this->pat->obtener_informacion_actividad($id_detact);
        $lineasaccion = $this->pat->obtener_alineacion_actividad($id_detact);
        $presupuesto = $this->pat->suma_presupuesto($id_detact);

        if($presupuesto->monto_total != NULL){
            $monto_total = $presupuesto->monto_total;
        }else{
            $monto_total = 0;
        }
        
            // Obteniendo la fecha actual con hora, minutos y segundos en PHP
        $fechaActual = date('d-m-Y H:i:s');   
        


        if($lineasaccion != NULL){
            $html = '
        <!DOCTYPE html>

        <html>
        <head runat="server">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <title></title>
            <style type="text/css">
                .auto-style1 {
                    height: 27px;
                }
                .auto-style2 {
                    height: 26px;
                }
                .auto-style4 {
                    height: 26px;
                    width: 453px;
                }
                .auto-style5 {
                    width: 95%;
                    height: 31px;
                    margin-left: 34px;
                }
                .auto-style6 {
                    width: 100%;
                    height: 40px;
                }
                .auto-style7 {
                    height: 28px;
                }
                .auto-style8 {
                    height: 27px;
                    width: 565px;
                }
                .auto-style9 {
                    width: 95%;
                    height: 32px;
                }
            </style>
        </head>
        <body background-color: #F2F3F4;>
                <div>
                    <div>
                        <img alt="logo" src="" />
                    </div>

                    <table align="center" class="auto-style6">
                        <tr>
                            <td style="text-align: center; background-color: #293543; color: #FFFFFF; font-family: Arial, Helvetica, sans-serif;">'.$actividad->vActividad.'</td>
                        </tr>
                    </table>
                    <br />

                    <table align="center" class="auto-style9">
                        <tr>
                            <td class="auto-style10" style="font-weight: bolder; text-align: left;">Alineacion<br />
                            </td>
                            <td class="auto-style1" style="font-weight: bolder; text-align: right;">Dependencia: '.((isset($actividad->vDependencia))?$actividad->vDependencia:'').'</td>
                        </tr>
                    </table>';
                    foreach($lineasaccion as $la){

                        $html.= '
                        <table align="center" style="width: 95%;  height: 80px; background-color: #FFFFFF;">
                        <tr>
                            <td style="text-decoration: underline; font-weight: bolder;" class="auto-style7">Eje PED<br />
                            </td>
                            <td style="text-decoration: underline; font-weight: bolder;" class="auto-style7">Politica publica<br />
                            </td>
                        </tr>
                        <tr>
                            <td>
                            '.$la->vEje.'
                            </td>
                            <td>
                                '.$la->vTema.'
                            </td>
                        </tr>
                        <tr>
                            <td style="text-decoration: underline; font-weight: bolder;">Estrategia
                            </td>
                            <td style="text-decoration: underline; font-weight: bolder;">Linea de accion<br />
                                </td>
                        </tr>
                        <tr>
                            <td>
                            '.$la->vEstrategia.'
                            </td>
                            <td>
                            '.$la->vLineaAccion.'
                            </td>
                        </tr>
                    </table>
                    <br>';
            }
            $html.= $this->generar_entregables_ficha($id_detact);

            $html.='
                <br/>
                <table align="center" style="width: 95%;  height: 80px; background-color: #FFFFFF;">
                    <tr>
                        <td class="auto-style1" style="font-weight: bolder">Datos financieros<br />
                        </td>
                        <td class="auto-style1" style="font-weight: bolder">Mapa<br />
                        </td>
                    </tr>
                    <tr>
                        <td class="auto-style2">
                        Presupuesto ejercido: '.$monto_total.'<br>
                        Presupuesto modificado: '.$monto_total.'
                        </td>
                        <td class="auto-style2">
                        Aqui va el mapa
                        </td>
                    </tr>
                </table>
                <br>
                <table align="center" style="width: 95%;  height: 80px; background-color: #FFFFFF;">
                    <tr>
                        <td class="auto-style1" style="font-weight: bolder">Datos financieros<br />
                        </td>
                        <td class="auto-style1" style="font-weight: bolder">Mapa<br />
                        </td>
                    </tr>
                    <tr>
                        <td class="auto-style2">
                        Aqui va la grafica
                        </td>
                        <td class="auto-style2">
                        Aqui va el mapa
                        </td>
                    </tr>
                </table>

            </body>
        </html>
        ';
        }

        return $html;
    }

    //crea el contenido de las lineas de accion del contenido de la ficha de actividad
    public function generar_lineasaccion_ficha($id_detact){

        $actividad = $this->pat->obtener_informacion_actividad($id_detact);
        $lineasaccion = $this->pat->obtener_alineacion_actividad($id_detact);
       
        $html = '<table style="width: 98%; padding:5px; font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif;">
                        <tr style="background-color:#F2F3F4;">
                            <td style="font-weight: bolder; text-align: left; font-size:14px;">
                                Alineacion
                            </td>
                            <td style="text-align: left;">
                             <span style="font-weight: bolder;"> Dependencia:</span> <span style="font-size:11px;">'.((isset($actividad->vDependencia))?$actividad->vDependencia:'').'</span></td>
                        </tr>
                </table>';
                    foreach($lineasaccion as $la){

                        $html.= '
                        <table style="width:100%; background-color: #FFFFFF; padding-left:10px; padding-bottom:5px; padding-top:5px;">
                        <tr>
                            <td style="font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif; text-decoration: underline; font-weight: bolder; text-align: left;">Eje PED
                            </td>
                            <td style="font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif; text-decoration: underline; font-weight: bolder; text-align: left;">Politica publica
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size:11px; font-family: Panton-Regular, Helvetica, sans-serif; text-align: left;">
                            '.$la->vEje.'
                            </td>
                            <td style="font-size:11px; font-family: Panton-Regular, Helvetica, sans-serif; text-align: left;">
                                '.$la->vTema.'
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif; text-decoration: underline; font-weight: bolder; text-align: left;">Estrategia
                            </td>
                            <td style="font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif; text-decoration: underline; font-weight: bolder; text-align: left;">Linea de accion
                                </td>
                        </tr>
                        <tr>
                            <td style="font-size:11px; font-family: Panton-Regular, Helvetica, sans-serif; text-align: left;">
                            '.$la->vEstrategia.'
                            </td>
                            <td style="font-size:11px; font-family: Panton-Regular, Helvetica, sans-serif; text-align: left;">
                            '.$la->vLineaAccion.'
                            </td>
                        </tr>
                    </table>
                    <br>';
                    }
        return $html;
    }
    

    //Crea la seccion de entregables del contenido de la ficha de actividad
    public function generar_entregables_ficha($id_detact){

        $cont = 0;

        $entregables = $this->pat->mostrar_actividadentregables($id_detact);

        $html = '
            <table style="width:100%; padding-bottom:5px;">
                <tr>
                    <td style="font-weight: bolder; text-align: left; font-size:14px; font-family: Panton-Regular, Helvetica, sans-serif;">
                        Entregables
                    </td>
                </tr>
            </table>
            <div style="height:1px; background-color: #F2F3F4;"></div> ';

        foreach($entregables as $ent){
            $cont = $cont+1;
            $sumatotal = $this->pat->suma_avances_total($ent->iIdDetalleEntregable);
            if($sumatotal->total_avance != NULL){
                $total = $sumatotal->total_avance;
                $ejercido = $sumatotal->ejercido;
            }else{
                $total = $ejercido = 0;
            }
            $porcentaje = $total /($ent->nMeta)/100;
            /*
            $html.= '
            <table style="width:100%; padding-left:10px; padding-bottom:5px; padding-top:5px; background-color: #FFFFFF;">
                <tr>
                    <td style="width:250px; font-weight: bolder; text-align: left; font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif;">Entregable '.$cont.'</td>
                    <td style="width:90px; font-weight: bolder; text-align: left; font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif;">Meta</td>
                    <td style="width:90px; font-weight: bolder; text-align: left; font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif;">Avance</td>
                    <td style="width:90px; font-weight: bolder; text-align: left; font-size:12px; font-family: Panton-Regular, Helvetica, sans-serif;">Ejercido</td>
                    
                </tr>
                <tr>
                    <td style="width:250px;">'.$ent->vEntregable.'</td>
                    <td style="width:90px;">'.$ent->nMeta.'</td>
                    <td style="width:90px;">
                                '.$total.' | '.$porcentaje.'%        
                    </td>
                    <td style="width:90px;">'.$ejercido.'</td>
                    
                </tr>
            </table>
            <div style="height:2px; background-color: #F2F3F4;"></div>';*/
            
        }
        
        return $html;
    }

    function cargar_options()
    {
        $listado = $this->input->post('listado',true);
        $valor = $this->input->post('valor',true);
        $this->load->library('Class_options');
        $opt = new Class_options();

        switch ($listado) {
            case 'dependencias':
                echo $opt->options_tabla('dependencia',"",'iIdEje = '.$valor);
                break;
            case 'c_dependencias':
                echo $opt->options_tabla('dependencia',"",'iIdEje = '.$valor);
                break;
            case 'dependencias_act':
                echo $opt->options_tabla('dependencia',"",'iIdEje = '.$valor);
                break;
            case 'retos':
                echo $opt->options_tabla('retos',"",'iIdDependencia = '.$valor);
                break;
            default:
                # code...
                break;
        }

    }
    function clonar_actividad()
    {
        $idAct = $this->input->post('idActClone',true);
        $anio_destino = $this->input->post('anioDestino',true);

        $resp = array('error' => true, 'mensaje' => '');

        $qact = $this->pat->actividad($idAct);

        if($qact->num_rows() == 1)
        {
            $con = $this->mseg->iniciar_transaccion();

            $d = $qact->row();
            $dInicio = ($d->dInicio == null || $d->dInicio == '') ? $anio_destino.'-01-01':$anio_destino.substr(trim($d->dInicio), 4);
            $dFin = ($d->dFin == null || $d->dFin == '') ? $anio_destino.'-12-31':$anio_destino.substr(trim($d->dFin), 4);
            $d_detact = array(
                'iIdActividad' => $d->iIdActividad,
                'iAnio' => $anio_destino,
                'dInicio' => $dInicio,
                'dFin' => $dFin,
                'nAvance' => 0
            );

            $iIdDetalleActividad = $this->mseg->inserta_registro('DetalleActividad',$d_detact,$con);

            $qent =  $this->pat->entregables_det_act($d->iIdDetalleActividad);
            foreach ($qent as $de)
            {
                $d_detent = array(
                    'iIdEntregable' => $de->iIdEntregable,
                    'iIdDetalleActividad' => $iIdDetalleActividad,
                    'nMeta' => 0,
                    'iPonderacion' => $de->iPonderacion,
                    'iActivo' => 1
                );
            

                $iIdEntregable = $this->mseg->inserta_registro('DetalleEntregable',$d_detent,$con);
            }

            if($this->mseg->terminar_transaccion($con))
            {
                $resp['error'] = false;
                $resp['mensaje'] = 'La clonación se ha realizado correctamente';
            } 
            else
            {
                $resp['mensaje'] = 'Ha ocurrido un error';
            }
        } else $resp['mensaje'] = 'No se encontraron actividades para clonar';

        echo json_encode($resp);
    }

    function clonar()
    {
        if(isset($_POST['clonar-dep']) && isset($_POST['anio-origen']) && isset($_POST['anio-destino']))
        {
            $depid = $this->input->post('clonar-dep',true);
            $anio_origen = $this->input->post('anio-origen',true);
            $anio_destino = $this->input->post('anio-destino',true);
            $resp = array('error' => true, 'mensaje' => '');

            $qact = $this->pat->actividades_dep($depid,$anio_origen);

            if($qact->num_rows() > 0){
                $con = $this->mseg->iniciar_transaccion();

                $qact = $qact->result();
                foreach ($qact as $d)
                {
                    $dInicio = ($d->dInicio == null || $d->dInicio == '') ? $anio_destino.'-01-01':$anio_destino.substr(trim($d->dInicio), 4);
                    $dFin = ($d->dFin == null || $d->dFin == '') ? $anio_destino.'-12-31':$anio_destino.substr(trim($d->dFin), 4);
                    $d_detact = array(
                        'iIdActividad' => $d->iIdActividad,
                        'iAnio' => $anio_destino,
                        'dInicio' => $dInicio,
                        'dFin' => $dFin,
                        'nAvance' => 0
                    );

                    $iIdDetalleActividad = $this->mseg->inserta_registro('DetalleActividad',$d_detact,$con);

                    //  Clonamos los entregables

                    $qent =  $this->pat->entregables_det_act($d->iIdDetalleActividad);
                    foreach ($qent as $de){
                        $d_detent = array(
                            'iIdEntregable' => $de->iIdEntregable,
                            'iIdDetalleActividad' => $iIdDetalleActividad,
                            'nMeta' => 0,
                            'iPonderacion' => $de->iPonderacion,
                            'iActivo' => 1
                        );
                    

                        $iIdEntregable = $this->mseg->inserta_registro('DetalleEntregable',$d_detent,$con);
                    }
                    
                }

                if($this->mseg->terminar_transaccion($con)){
                    $resp['error'] = false;
                    $resp['mensaje'] = 'La clonación se ha realizado correctamente';
                } else {
                    $resp['mensaje'] = 'Ha ocurrido un error';
                }
            }else $resp['mensaje'] = 'No se encontraron actividades para clonar';

            echo json_encode($resp);
        }
    }

    function agregar_la()
    {
        $iIdLineaAccion = $this->input->post('idLA');
        $contLA = $this->input->post('contLA');
        $row = $this->pat->get_linea_accion($iIdLineaAccion);
        $button = '<button type="button" name="dltactla" title="Eliminar" id="dltactla" type="button" class="btn btn-xs waves-effect waves-light boton_eliminar dltactla" onclick="eliminarLA('.$contLA.')"><i class="mdi mdi-close"></i></button>';
        $input = '<input type="hidden" class="linea" name="la'.$contLA.'" id="la'.$contLA.'" value="'.$row->iIdLineaAccion.'">';

        echo '<tr id="trla'.$contLA.'">
            <td>'.$row->vEje.'</td>
            <td>'.$row->vTema.'</td>
            <td>'.$row->vObjetivo.'</td>
            <td>'.$row->vEstrategia.'</td>
            <td>'.$row->vLineaAccion.'</td>
            <td>'.$button.$input.'</td>
        </tr>';
    }
   
    function new_search()
    {
        $seg = new Class_seguridad();

        $data['all_sec'] = $all_sec = $seg->tipo_acceso(9,$_SESSION[PREFIJO.'_idusuario']);
        $data['all_dep'] = $all_dep = $seg->tipo_acceso(10,$_SESSION[PREFIJO.'_idusuario']);
        $data['p_clonar'] = $p_clonar = $seg->tipo_acceso(32,$_SESSION[PREFIJO.'_idusuario']);
        $data['acceso'] = $seg->tipo_acceso(14,$_SESSION[PREFIJO.'_idusuario']);
        $this->load->view('PAT/pat_list',$data);
    }

    function search_pats()
    {
        // Permisos
        $seg = new Class_seguridad();
        $acceso = $seg->tipo_acceso(14,$_SESSION[PREFIJO.'_idusuario']);
        $p_clonar = $seg->tipo_acceso(32,$_SESSION[PREFIJO.'_idusuario']);
        // Filtros DataTable
        $draw = $this->input->post('draw', TRUE);
        $start = $this->input->post('start', TRUE);
        $length = $this->input->post('length', TRUE);
        $columnas = $this->input->post('columns', TRUE);
        $ordenamiento = $this->input->post('order', TRUE);
        $col = $ordenamiento[0]['column'];
        $orden = $ordenamiento[0]['dir'];

        $where = array();

        // Filtros
        if($_SESSION[PREFIJO.'_rol'] == "Administrador"){
            if((int)$this->input->post('eje')  > 0) $where['iIdEje'] = $this->input->post('eje',true);
        }
        if((int)$this->input->post('dep')  > 0) $where['iIdDependencia'] = $this->input->post('dep',true);
        if((int)$this->input->post('anio')  > 0) $where['iAnio'] = $this->input->post('anio',true);
        if((int)$this->input->post('covid')  > 0) $where['iReactivarEconomia'] = $this->input->post('covid',true);
        if((int)$this->input->post('newAvances')  > 0) $where['avances_pendientes > '] = 0;
        if((int)$this->input->post('mes')  > 0) $where['EXTRACT(MONTH from "dInicio")='] = (int)$this->input->post('mes',true);

        $keyword = $this->input->post('keyword',true);

        $query = $this->pat->search_pats($keyword, $where, $start, $length, $orden, $col);
        $total_pats = $this->pat->total_pats($keyword, $where);
        
        $us = array();

        $result = $query->result();

        foreach ($result as $row)
        {  
            $icon_class = ($acceso > 1) ? 'mdi mdi-border-color':'fas fa-search'; 
            $title = ($acceso > 1) ? 'Editar':'Consultar'; 
            
            $btns ='<div class="btn-group">
                        <button type="button" title="Opciones" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-cog"></i></button>
                        <div class="dropdown-menu">';
            if($acceso > 1) $btns.= '<a class="dropdown-item" href="#" onclick="modificarAct('.$row->iIdDetalleActividad.')"><i class="mdi mdi-border-color"></i> Editar</a>';
            if($acceso == 1) $btns.= '<a class="dropdown-item" href="javascript:;" onclick="modificarAct('.$row->iIdDetalleActividad.');"><i class="fas fa-search"></i> Consultar</a>';
            if($acceso > 1) $btns.= '<a class="dropdown-item" href="javascript:;" onclick="confirmar(\'¿Está seguro de eliminar?\', eliminarActividad,'.$row->iIdDetalleActividad.');"><i class="mdi mdi-close"></i> Eliminar</a>';
            if($p_clonar > 0) $btns.= '<div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:;" onclick="openModalCloneAct('.$row->iIdDetalleActividad.');"><i class="far fa-copy"></i> Clonar</a>';
            $btns.= '    </div>
                    </div>&nbsp;';
            $btns.= '<button title="Captura de Indicadores" type="button" class="btn btn-sm waves-effect waves-light boton" onclick="abrirEntregables('.$row->iIdDetalleActividad.')"><i class="icon-badge"></i></button>&nbsp;';
            
            $btns.= '<button title="Ver ficha técnica" type="button" class="btn btn-sm waves-effect btn-danger" onclick="FichaActividad('.$row->iIdDetalleActividad.')"><i class="fas fa-file-pdf"></i></button>';

            /*$btns = '<button title="'.$title.'" type="button" class="btn btn-xs waves-effect waves-light boton_edit" onclick="modificarAct('.$row->iIdActividad.')"><i class="'.$icon_class.'"></i></button>';
            if($acceso > 1) $btns.= '<button title="Eliminar" type="button" class="btn btn-xs waves-effect waves-light boton_eliminar " onclick="confirmar(\'¿Está seguro de eliminar?\', eliminarActividad,<?=row->iIdDetalleActividad ?>);"><i class="mdi mdi-close"></i></button>';
            $btns.= '<button title="Entregables" type="button" class="btn btn-xs waves-effect waves-light boton" onclick="abrirEntregables('.$row->iIdDetalleActividad.')"><i class="icon-badge"></i></button>';
            $btns.= '<button title="Texto para el informe" type="button" class="btn btn-xs waves-effect waves-light boton_InfTex" onclick="abrirCapturaTxt('.$row->iIdDetalleActividad.')"><i class="icon-book-open"></i></button>';
            $btns.= '<button title="Descargar ficha" type="button" class="btn btn-xs waves-effect waves-light boton_desc" onclick="Show('.$row->iIdDetalleActividad.')"><i class="mdi mdi-download"></i></button>';
            if($p_clonar > 0) $btns.= '<button type="button" class="btn btn-xs waves-effect waves-light boton_edit" onclick="openModalCloneAct('.$row->iIdDetalleActividad.');"><i class="far fa-copy"></i></button>';*/
            // Gráfica avance
            $row->nAvance = round($row->nAvance);
            $clase = "border-success";
            
            if($row->nAvance >= 0 && $row->nAvance < 25)
                $clase = "border-danger";
            elseif($row->nAvance >= 25 && $row->nAvance < 81)
                $clase = "border-warning";

            $graph = '<div class="progress-c mx-auto" data-value='.$row->nAvance.'>
                        <span class="progress-c-left">
                            <span class="progress-c-bar '.$clase.'"></span>
                        </span>
                        <span class="progress-c-right">
                            <span class="progress-c-bar '.$clase.'"></span>
                        </span>
                        <div class="progress-c-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                            <div class="h3 font-weight-bold">'.$row->nAvance.'<sup class="small">%</sup></div>
                        </div>
                    </div>';

            // Img ODS + Nombre de la actividad
            $new = ((int)$row->avances_pendientes > 0) ? '<i style="color:#E5BE01; font-size:24px;" class="mdi mdi-new-box md-24" title="Avances pendientes de aprobar"></i>':'';
            $actividad = $this->imgs_ods($row->iIdActividad).$new.$row->vActividad;

            $datos = array(
                0 => $graph,
                1 => (trim($row->siglas) != '') ? $row->siglas:$row->vDependencia,
                2 => $actividad,
                3 => $row->iAnio,
                4 => $btns
            );


            $us[] = $datos;
        }

        $usuarios = array(  
            'draw' => $draw,
            'recordsTotal' => $total_pats,
            'recordsFiltered' => $total_pats,
            'data' => $us
        );

        echo json_encode($usuarios);
    }

    /**
     * Retorna el catalogo de POAS que brinda el sistema de finanzas
     * @return Json
     */
    function getCatalogoPOA($print = true) {
        $url    = $this->urlFinanzas.'proyectos/listado';

        try{
            $ch = curl_init($url);
            $headers = array(
                'Content-Type: application/json',
                'Authorization: Basic '. base64_encode("$this->userFinanzas:$this->passFinanzas")
            );

            $headers = array();
            $headers[] = 'Cache-Control: no-cache';
            $headers[] = 'Content-Type: application/json; charset= utf-8';

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_USERPWD, $this->authFinanzas);
            
            if(!$print)
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            $result = curl_exec($ch);
            curl_close($ch);

            if(!$print)
                return $result;
            
            $datos = json_decode(json_encode($result));
            print_r($datos->datos);
        }catch(Exception $ex){
            print_r($ex);
        }
    }

    function actualizarValoresPOA(){
        $catalogosPOA   = json_decode($this->getCatalogoPOA(false));
        echo var_dump($catalogosPOA);
    }

    /**
     * Retorna el json de las dependencias;
     * @return Json
     */
    function getDependencias() {
        $respuesta = $this->pat->getDataTable('dependencia', null);
        $temp = array();
        
        foreach($respuesta as $resp) {
            $resp->valor = str_replace('"','\'', $resp->valor);
            array_push($temp, $resp);
        }
        print_r(json_encode($temp));
    }

    /**
     * Elimina las tildes para que se pueda realizar merger con el distema de finanzas
     * @return string
     */
    function eliminar_tildes($cadena){
    
        //Ahora reemplazamos las letras
        $cadena = str_replace(
            array('á','é','í','ó','ú'),
            array('a','e','i','o','u'),
            $cadena
        );

        $cadena = str_replace(
            array('Á','É','Í','Ó','Ú'),
            array('A','E','I','O','U'),
            $cadena );
    
        return $cadena;
    }

    function validarListaPOA(){
        $catalogosPOA   = $this->getCatalogoPOA(false);
        $datos = json_decode($catalogosPOA, true);
        
        $arrayResultados = array();
        $arrayElegidos = array();

        $arrayidElegido = array();

        $idelegido = (int)$this->input->post('id',true)?:'';

        $respuestaElegidosID = $this->pat->obtenerSeleccionados($idelegido);

        
        if($idelegido != '' && $respuestaElegidosID[0]->vcattipoactividad != null){

            foreach ($respuestaElegidosID as $key => $value) {
                array_push($arrayidElegido, $value->vcattipoactividad);
            }

            foreach ($datos['datos'] as $key => $value) {
                if(in_array($value['numeroProyecto'], $arrayidElegido)){
                    array_push($arrayResultados,
                    ['numeroProyecto' => $value['numeroProyecto'],
                    'aprobado' => $value['aprobado'],
                    'pagado' => $value['pagado'],
                    'dependenciaEjecutora' => $value['dependenciaEjecutora'],
                    'nombreProyecto' => $value['nombreProyecto'],
                    'fechaAprobacion' => $value['fechaAprobacion']]);
                    break;
                }
            }
            
        }

        //json_encode($datos['datos']);

        $respuestaElegidos = $this->pat->obtenerSeleccionados('');

        foreach ($respuestaElegidos as $key => $value) {
            array_push($arrayElegidos, $value->vcattipoactividad);
        }
        

        foreach ($datos['datos'] as $key => $value) {
            if(!in_array($value['numeroProyecto'], $arrayElegidos)){
                array_push($arrayResultados,
                ['numeroProyecto' => $value['numeroProyecto'],
                'aprobado' => $value['aprobado'],
                'pagado' => $value['pagado'],
                'dependenciaEjecutora' => $value['dependenciaEjecutora'],
                'nombreProyecto' => $value['nombreProyecto'],
                'fechaAprobacion' => $value['fechaAprobacion']]);
            }
        }
        
        echo json_encode($arrayResultados);
    }


    function validarListaPOAEdit($id){
        $catalogosPOA   = $this->getCatalogoPOA(false);
        $datos = json_decode($catalogosPOA, true);
        
        $arrayResultados = array();
        $arrayElegidos = array();

        $arrayidElegido = array();

        $respuestaElegidosID = $this->pat->obtenerSeleccionados($id);

        
        if($respuestaElegidosID[0]->vcattipoactividad != null || $respuestaElegidosID[0]->vcattipoactividad != ''){

            foreach ($respuestaElegidosID as $key => $value) {
                array_push($arrayidElegido, $value->vcattipoactividad);
            }

            foreach ($datos['datos'] as $key => $value) {
                if(in_array($value['numeroProyecto'], $arrayidElegido)){
                    array_push($arrayResultados,
                    ['numeroProyecto' => $value['numeroProyecto'],
                    'aprobado' => $value['aprobado'],
                    'pagado' => $value['pagado'],
                    'dependenciaEjecutora' => $value['dependenciaEjecutora'],
                    'nombreProyecto' => $value['nombreProyecto'],
                    'fechaAprobacion' => $value['fechaAprobacion']]);
                    break;
                }
            }
            
        }

        //json_encode($datos['datos']);

        $respuestaElegidos = $this->pat->obtenerSeleccionados('');

        foreach ($respuestaElegidos as $key => $value) {
            array_push($arrayElegidos, $value->vcattipoactividad);
        }
        

        foreach ($datos['datos'] as $key => $value) {
            if(!in_array($value['numeroProyecto'], $arrayElegidos)){
                array_push($arrayResultados,
                ['numeroProyecto' => $value['numeroProyecto'],
                'aprobado' => $value['aprobado'],
                'pagado' => $value['pagado'],
                'dependenciaEjecutora' => $value['dependenciaEjecutora'],
                'nombreProyecto' => $value['nombreProyecto'],
                'fechaAprobacion' => $value['fechaAprobacion']]);
            }
        }
        
        return $arrayResultados;
    }

}
?>