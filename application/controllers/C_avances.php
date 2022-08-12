<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_avances extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->model('M_avances','ma');
        $this->load->library('Class_options');
        $this->load->library('Excel');
        $this->load->library('Class_seguridad');
        $this->load->model('M_seguridad','ms');
        $this->load->helper('funciones');
        $this->load->library('session');

    }

    //Muestra la vista principal
    public function index(){

        $lib = new Class_options();

        $seg = new Class_seguridad();
        $acceso = $seg->tipo_acceso(17,$_SESSION[PREFIJO.'_idusuario']);

        $data['acceso']     = $acceso;
        $id_detent          = $this->input->post('id',TRUE);
        $data['id_detent']  = $id_detent;
        $data['id_detact']  = $this->input->post('id_detact',TRUE);
        $actividades           = $this->ma->getActividad( $data['id_detact']);
        $data['tipoActividad'] = $actividades[0]->vtipoactividad;
        $data['numProyecto']   = $actividades[0]->vcattipoactividad;

        // Numeralia de avances
        $data['header'] = $this->header_principal($id_detent);
        // Selector municipios
        $data['municipios'] = $lib->options_tabla('municipios');

        // Tab de trimestres
        $data['contenido_trimestres'] = $this->html_tab_trimestes($id_detent);
        
        $data['consulta'] = $this->ma->mostrar_actividadentregable($id_detent);

        //Escalar a la tabla VariableIndicador
        $id_entregable = $this->ma->obtenerDetalleId($id_detent);

        $Formula = $this->ma->obtenerFormula($id_entregable->iIdEntregable);

        $Variables = $this->ma->obtenerVariables($id_entregable->iIdEntregable);

        $data['Variables'] = $Variables;

        $data['vFormula'] = $Formula->vFormula;

    	$this->load->view('avances/principal',$data);

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

    //Funcion para insertar
    public function insert(){
            if(isset($_POST['mes_corte']) && isset($_POST['avance'])){
                $dataNuevo = array();
                
                $data['iIdDetalleEntregable'] = $this->input->post('id_detent',TRUE);
                $dataNuevo['iIdDetalleEntregable'] = $this->input->post('id_detent',TRUE);

                $data['nAvance'] = EliminaComas($this->input->post('avance',TRUE));
                $dataNuevo['nAvance'] = $this->input->post('avance',TRUE);

                $data['nEjercido'] = EliminaComas($this->input->post('monto',TRUE)) == "" ? 0 : EliminaComas($this->input->post('monto',TRUE));
                $dataNuevo['nEjercido'] = EliminaComas($this->input->post('monto',TRUE)) == "" ? 0 : EliminaComas($this->input->post('monto',TRUE));

                $data['iActivo'] = 1;
                $dataNuevo['iActivo'] = 1;

                $Letras = $this->input->post('letra',TRUE);
                $dataNuevo['Letras'] = $Letras;
                $Valores = $this->input->post('valores',TRUE);
                $dataNuevo['Valores'] = $Valores;

                //echo "Monto=";
                //echo $data['nEjercido'] ;

                $consulta = $this->ma->mostrar_actividadentregable($data['iIdDetalleEntregable']);

                $anio = $consulta->iAnio;
                $mes = $this->input->post('mes_corte',TRUE);
                $dia = 01;

                $fecha = $anio.'-'.$mes.'-'.$dia;

                $data['dFecha'] = $fecha;
                $dataNuevo['dFecha'] = $fecha;

                $data['iIdUsuarioActualiza'] = $_SESSION[PREFIJO.'_idusuario'];
                $dataNuevo['iIdUsuarioActualiza'] = $_SESSION[PREFIJO.'_idusuario'];

                $data['dFechaActualiza'] = date("Y-m-d h:i:s");
                $dataNuevo['dFechaActualiza'] = date("Y-m-d h:i:s");
                
                if(isset($_POST['nBeneficiariosH']) && $_POST['nBeneficiariosH'] != ''){
                    $beneficiarioH = $this->input->post('nBeneficiariosH',TRUE);
                    $dataNuevo['nBeneficiariosH'] = $beneficiarioH;
                }else{
                    $beneficiarioH = 0;
                    $dataNuevo['nBeneficiariosH'] = 0;
                }
                if(isset($_POST['nBeneficiariosM']) && $_POST['nBeneficiariosM'] != ''){
                    $beneficiarioM = $this->input->post('nBeneficiariosM',TRUE);
                    $dataNuevo['nBeneficiariosM'] = $beneficiarioM;
                }else{
                    $beneficiarioM = 0;
                    $dataNuevo['nBeneficiariosM'] = 0;
                }
                if(isset($_POST['nDiscapacitadosH']) && $_POST['nDiscapacitadosH'] != '' ){
                    $discapacitadoH = $this->input->post('nDiscapacitadosH',TRUE);
                    $dataNuevo['nDiscapacitadosH'] = $discapacitadoH;
                }else{
                    $discapacitadoH = 0;
                    $dataNuevo['nDiscapacitadosH'] = 0;
                }
                if(isset($_POST['nDiscapacitadosM']) && $_POST['nDiscapacitadosM'] != ''){
                    $discapacitadoM = $this->input->post('nDiscapacitadosM',TRUE);
                    $dataNuevo['nDiscapacitadosM'] = $discapacitadoM;
                }else{
                    $discapacitadoM = 0;
                    $dataNuevo['nDiscapacitadosM'] = 0;
                }
                if(isset($_POST['nLenguaH']) && $_POST['nLenguaH'] != ''){
                    $lenguaindH = $this->input->post('nLenguaH',TRUE);
                    $dataNuevo['nLenguaH'] = $lenguaindH;
                }else{
                    $lenguaindH = 0;
                    $dataNuevo['nLenguaH'] = 0;
                }
                if(isset($_POST['nLenguaM']) && $_POST['nLenguaM'] != ''){
                    $lenguaindM = $this->input->post('nLenguaM',TRUE);
                    $dataNuevo['nLenguaM'] = $lenguaindM;
                }else{
                    $lenguaindM = 0;
                    $dataNuevo['nLenguaM'] = 0;
                }
                if(isset($_POST['nTerceraEdadH']) && $_POST['nTerceraEdadH'] != ''){
                    $terceraH = $this->input->post('nTerceraEdadH',TRUE);
                    $dataNuevo['nTerceraEdadH'] = $terceraH;
                }else{
                    $terceraH = 0;
                    $dataNuevo['nTerceraEdadH'] = 0;
                }
                if(isset($_POST['nTerceraEdadM']) && $_POST['nTerceraEdadM'] != ''){
                    $terceraM = $this->input->post('nTerceraEdadM',TRUE);
                    $dataNuevo['nTerceraEdadM'] = $terceraM;
                }else{
                    $terceraM = 0;
                    $dataNuevo['nTerceraEdadM'] = $terceraM;
                }
                if(isset($_POST['nAdolescenteH']) && $_POST['nAdolescenteH'] != ''){
                    $adolecenteH = $this->input->post('nAdolescenteH',TRUE);
                    $dataNuevo['nAdolescenteH'] = $adolecenteH;
                }else{
                    $adolecenteH = 0;
                    $dataNuevo['nAdolescenteH'] = $adolecenteH;
                }
                if(isset($_POST['nAdolescenteM']) && $_POST['nAdolescenteM'] != ''){
                    $adolecenteM = $this->input->post('nAdolescenteM',TRUE);
                    $dataNuevo['nAdolescenteM'] = $adolecenteM;
                }else{
                    $adolecenteM = 0;
                    $dataNuevo['nAdolescenteM'] = $adolecenteM;
                }

                if(isset($_POST['observaciones']) && $_POST['observaciones'] != ''){
                    $observaciones = $this->input->post('observaciones',TRUE);
                    $dataNuevo['observaciones'] = $observaciones;
                }
                else{
                    $observaciones = ' ';
                    $dataNuevo['observaciones'] = $observaciones;
                }
                if(isset($_POST['txtTotal']) && $_POST['txtTotal'] != ''){
                    $totalAvance = $this->input->post('txtTotal',TRUE);
                    
                    $dividirTotalH = $totalAvance / 2;
                    $totalHround = round($dividirTotalH);
                    $dividirTotalM = $totalAvance - $totalHround;
                    $sumah = $totalHround + $dividirTotalM;
                    if($sumah == $totalAvance){
                        $beneficiarioH = $totalHround;
                        $beneficiarioM = $dividirTotalM;
                        $dataNuevo['TbeneficiarioH'] = $beneficiarioH;
                        $dataNuevo['TbeneficiarioM'] = $beneficiarioM;
                    }else{
                        echo 'Algo fallo';
                    }
                }
                else{
                    $totalAvance = 0;
                    $dataNuevo['totalAvance'] = $totalAvance;
                }
                $result = false;
                $table = 'Avance';
                if(isset($_POST['municipios'])){
                    $arrMunicipios = $this->input->post('municipios',TRUE);
                    $dataNuevo['arrMunicipios'] = $arrMunicipios;
                    foreach ($arrMunicipios as $value) {
                        $data['iMunicipio'] = $value;
                        $data['vObservaciones'] = $observaciones;
                        $data['nBeneficiariosH'] = EliminaComas($beneficiarioH);
                        $data['nBeneficiariosM'] = EliminaComas($beneficiarioM);
                        $data['nDiscapacitadosH'] = EliminaComas($discapacitadoH);
                        $data['nDiscapacitadosM'] = EliminaComas($discapacitadoM);
                        $data['nLenguaH'] = EliminaComas($lenguaindH);
                        $data['nLenguaM'] = EliminaComas($lenguaindM);
                        $data['nTerceraEdadH'] = EliminaComas($terceraH);
                        $data['nTerceraEdadM'] = EliminaComas($terceraM);
                        $data['nAdolescenteH'] = EliminaComas($adolecenteH);
                        $data['nAdolescenteM'] = EliminaComas($adolecenteM);

                        $data['iAprobado'] = 1; //EliminaComas($lenguaindM);

                        $data['iEmpresas'] = $this->input->post('empresa',TRUE) ?: 0;
                        $data['iBeneficiariosTotales'] = $totalAvance;

                        $idInsertado = $this->ma->guardado_general($table,$data);
                        

                        foreach($Valores as $key => $v){
                            $this->ma->insertarVariableAvance('VariablesAvance', array('iVariable' => $Letras[$key], 'iValor' => $v, 'iIdAvance' => $idInsertado), $con);
                        }

                        if($idInsertado){
                            $result = true;
                        }
                    }
                    
                }else {
                    $data['iMunicipio'] = 0;
                    $data['vObservaciones'] = $observaciones;
                    $data['nBeneficiariosH'] = EliminaComas($beneficiarioH);
                    $data['nBeneficiariosM'] = EliminaComas($beneficiarioM);
                    $data['nDiscapacitadosH'] = EliminaComas($discapacitadoH);
                    $data['nDiscapacitadosM'] = EliminaComas($discapacitadoM);
                    $data['nLenguaH'] = EliminaComas($lenguaindH);
                    $data['nLenguaM'] = EliminaComas($lenguaindM);
                    $data['nTerceraEdadH'] = EliminaComas($terceraH);
                    $data['nTerceraEdadM'] = EliminaComas($terceraM);
                    $data['nAdolescenteH'] = EliminaComas($adolecenteH);
                    $data['nAdolescenteM'] = EliminaComas($adolecenteM);
                    //$data['nEjercido'] = 0;

                    $data['iAprobado'] = 1; //EliminaComas($lenguaindM);

                    $data['iEmpresas'] = $this->input->post('empresa',TRUE) ?: 0;
                    $data['iBeneficiariosTotales'] = $this->input->post('txtTotal',TRUE) ?: 0;

                    //Validacion
                    $dataNuevo['iMunicipio'] = 0;
                    $dataNuevo['vObservaciones'] = $observaciones;
                    $dataNuevo['nBeneficiariosH'] = EliminaComas($beneficiarioH);
                    $dataNuevo['nBeneficiariosM'] = EliminaComas($beneficiarioM);
                    $dataNuevo['nDiscapacitadosH'] = EliminaComas($discapacitadoH);
                    $dataNuevo['nDiscapacitadosM'] = EliminaComas($discapacitadoM);
                    $dataNuevo['nLenguaH'] = EliminaComas($lenguaindH);
                    $dataNuevo['nLenguaM'] = EliminaComas($lenguaindM);
                    $dataNuevo['nTerceraEdadH'] = EliminaComas($terceraH);
                    $dataNuevo['nTerceraEdadM'] = EliminaComas($terceraM);
                    $dataNuevo['nAdolescenteH'] = EliminaComas($adolecenteH);
                    $dataNuevo['nAdolescenteM'] = EliminaComas($adolecenteM);
                    //$data['nEjercido'] = 0;

                    $dataNuevo['iAprobado'] = 1; //EliminaComas($lenguaindM);

                    $dataNuevo['iEmpresas'] = $this->input->post('empresa',TRUE) ?: 0;
                    $dataNuevo['iBeneficiariosTotales'] = $this->input->post('txtTotal',TRUE) ?: 0;

                    $idInsertado = $this->ma->guardado_general($table,$data);

                    foreach($Valores as $key => $v){
                        $this->ma->insertarVariableAvance('VariablesAvance', array('iVariable' => $Letras[$key], 'iValor' => $v, 'iIdAvance' => $idInsertado), $con);
                    }

                    if($idInsertado){
                        $result = true;
                    }
                }
                if($result){
                    $hoy = date('Y-m-d H:i:s');

                    $resp = $this->ma->insertCambio(array(
                        'iTipoCambio' => 'Indicador',
                        'iAntesCambio' => 'Avance Creado',
                        'iDespuesCambio' => strval(json_encode($dataNuevo)),
                        'iFechaCambio' => $hoy,
                        'iIdUsuario' => $_SESSION[PREFIJO.'_idusuario'],
                        'iAprovacion' => 0,
                    ));
                    echo true;
                }else echo false;

            }else{
                echo false;
            }
       
    }
    //Muestra la vista con los tabs
    public function showtabs(){

        if(isset($_POST['id_detent']))
        {
            $data['tabs_trimestres'] = $this->crear_contenido_tabs($this->input->post('id_detent',true));

            $this->load->view('avances/tabs_trimestres',$data);
        }
    }

    //Muestra el contenido de los tabs
    public function crear_contenido_tabs($id_detent)
    {

        $seg = new Class_seguridad();
        $tipo_acceso = $seg->tipo_acceso(29,$_SESSION[PREFIJO.'_idusuario']);

        switch($tipo_acceso){

            case $tipo_acceso == 1:
            $acceso = 'lect';
            break;

            case $tipo_acceso == 2:
            $acceso = 'lectesc';
            break;

            default;
            $acceso = 'dng';
            break;
        }

        $html = '<div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#1tri" role="tab">
                                <h4>
                                <span class="hidden-sm-up"><i class="mdi mdi-calendar-multiple"></i></span><span class="hidden-xs-down">1 Trimestre</span>
                                </h4>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#2tri" role="tab">
                                <h4>
                                <span class="hidden-sm-up"><i class="mdi mdi-calendar-multiple"></i></span> <span class="hidden-xs-down">2 Trimestre</span>
                                </h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#3tri" role="tab">
                                <h4>
                                <span class="hidden-sm-up"><i class="mdi mdi-calendar-multiple"></i></span> <span class="hidden-xs-down">3 Trimestre</span>
                                </h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#4tri" role="tab">
                                <h4>
                                <span class="hidden-sm-up"><i class="mdi mdi-calendar-multiple"></i></span> <span class="hidden-xs-down">4 Trimestre</span>
                                </h4>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="1tri" role="tabpanel">
                            <div class="p-20">
                                '.$this->tabla_trimestres(1,$id_detent,$acceso).'
                            </div>
                        </div>
                        <div class="tab-pane" id="2tri" role="tabpanel">
                            <div class="p-20">
                                '.$this->tabla_trimestres(2,$id_detent,$acceso).'
                            </div>
                        </div>
                        <div class="tab-pane" id="3tri" role="tabpanel">
                            <div class="p-20">
                                '.$this->tabla_trimestres(3,$id_detent,$acceso).'
                            </div>
                        </div>
                        <div class="tab-pane" id="4tri" role="tabpanel">
                            <div class="p-20">
                                '.$this->tabla_trimestres(4,$id_detent,$acceso).'
                            </div>
                        </div>
                    </div>
                </div>';

        return $html;
    }

    //Muestra la tabla de trimestres
    public function tabla_trimestres($trimestre,$id_detent,$acceso)
    {
        switch($trimestre){

            case $trimestre == 1:
            $meses = array(
            '01'  => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            );
            break;

            case $trimestre == 2:
            $meses = array(
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            );
            break;

            case $trimestre == 3:
            $meses = array(
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            );
            break;

            case $trimestre == 4:
            $meses = array(
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
            );
            break;

            default:
            break;
        }

        $html = '<div class="accordion" id="meses">';

        foreach($meses as $key => $value)
        {

            $html.= '<div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#mes'.$key.'" aria-expanded="true" aria-controls="mes'.$key.'" style="cursor:pointer">
                        <h4 class="mb-0">
                            <!--<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#mes'.$key.'" aria-expanded="true" aria-controls="mes'.$key.'">-->
                                '.$value.'
                            <!--</button>-->
                        </h4>
                    </div>
                    <div id="mes'.$key.'" class="collapse" aria-labelledby="headingOne" data-parent="meses">
                    <div class="card-body">
                        <!--<div class="form-row">
                            </div>-->

                            <div id="contenidotabla'.$key.'">
                            '.$this->contenido_tabla($key,$value,$id_detent,$acceso).'
                            </div>    
                        </div>
                    </div>
                </div>';
        }

        $html.= '</div>';

        return $html;
    }

    //Muestra totales meses
    function muestra_totales_mes()
    {
        $id_detent = $this->input->post('id_detent');
        $mes = $this->input->post('mes');

        echo $this->tabla_totales_mes($mes,$id_detent);
    }

    function tabla_totales_mes($mes,$id_detent)
    {
        $totales = $this->ma->suma_avances_mensual_desglosado($mes,$id_detent);

        $total_avance = Decimal($totales->total_avance);
        $total_monto = Decimal($totales->monto_total);

        $total_beneficiarios = Decimal($totales->total_beneh + $totales->total_benem );
        $total_discapacitados = Decimal($totales->total_disch + $totales->total_discm);
        $total_mayahablantes = Decimal($totales->total_lengh + $totales->total_lengm);

        $html = '';

        $html.= '<blockquote>
                <div class="row">
                    <div class="col-md-6 mb-6">
                        <i class="mdi mdi-flag"></i>Avance <br><b>'.$total_avance.'</b>
                    </div>
                    <div class="col-md-6 mb-6">                
                        <i class="mdi mdi-cash-multiple"></i>Ejercido<br><b>$'.$total_monto.'</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-4">                            
                        <i class="mdi mdi-account-multiple"></i>Total beneficiariosss<br>
                        <i class="fa-lg mdi mdi-human-male text-primary"></i>'.Decimal($totales->total_beneh).'+<i class="rosa fa-lg mdi mdi-human-female text-primary"></i>'.Decimal($totales->total_benem).' = <b>'.$total_beneficiarios.'</b>
                    </div>

                    
                </div>
            </blockquote>';
        return $html;
    }

    //Funcion para leer el archivo Excel
    public function read_excel()
    {
        $response['estatus'] = false;
        $response['mensaje'] = '';
        $response['tipo'] = 'warning';
        $n = 0;

        $extensiones = array('xlsx');
        
        $file_name = $_FILES['file']['name'];
        $file_campos = explode(".", $file_name);
        $file_extension = strtolower(end($file_campos));
        if($file_name != '')
        {
            //valida que la extension del archivo subido corresponda a un excel
            if (in_array($file_extension, $extensiones)==TRUE)
            {

                $data['iIdUsuarioActualiza'] = $_SESSION[PREFIJO.'_idusuario'];
                $data['dFechaActualiza'] = date("Y-m-d h:i:s");
                $data['iIdDetalleEntregable'] = $this->input->post('id_detent',TRUE);
                    
                $consulta = $this->ma->mostrar_actividadentregable($data['iIdDetalleEntregable']);

                $anio = $consulta->iAnio;
                $mes = $this->input->post('mes_corte',TRUE);
                $dia = 01;
                $fecha = $anio.'-'.$mes.'-'.$dia;
                $data['dFecha'] = $fecha;
                
                $ruta = $_FILES['file']['tmp_name'];
                //obtiene la hoja del excel que sera validado
                //$hojaexcel = $this->obtener_hojaexcel($mes);
            
                $inputFileType = PHPExcel_IOFactory::identify($ruta);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($ruta);
                //$sheet = $objPHPExcel->getSheet(0); 
                $sheet = $objPHPExcel->getActiveSheet(); 
                //echo $objPHPExcel->getActiveSheet()->getTitle();
                $highestRow = 110;//$sheet->getHighestRow(); 
                $highestColumn = 'K';//$sheet->getHighestColumn();
                

                //Iniciamos la transaccion
                $con = $this->ms->iniciar_transaccion();

                //recorre la hoja de excel desde la celda 4
                for ($row = 4; $row < $highestRow; $row++)
                {
                    $municipio = $sheet->getCell("A".$row)->getValue();
                    $consultamunicipio = $this->ma->obtener_idmunicipio_por_nombre($municipio);

                    if($consultamunicipio->num_rows() == 1)
                    {
                        $data['iMunicipio'] = $consultamunicipio->row()->iIdMunicipio;

                        $avance = floatval(trim($sheet->getCell("B".$row)->getValue()));
                        $montoejercido = floatval(trim($sheet->getCell("C".$row)->getValue()));
                        $beneficiarioH = intval(trim($sheet->getCell("D".$row)->getValue()));
                        $beneficiarioM = intval(trim($sheet->getCell("E".$row)->getValue()));                        
                        //revisa si hay algun avance agregado 
                        //avance comentariado para poder subir datos
                        if($avance > 0 || $montoejercido > 0 || $beneficiarioH > 0 || $beneficiarioM > 0)
                        {
                            if($sheet->getCell("D".$row)->getValue() != ''){
                                $beneficiarioM = intval(trim($sheet->getCell("D".$row)->getValue()));
                            }else{
                                $beneficiarioM = 0;
                            }
                            if($sheet->getCell("E".$row)->getValue() != ''){
                                $beneficiarioH = intval(trim($sheet->getCell("E".$row)->getValue()));
                            }else{
                                $beneficiarioH = 0;
                            }
                            if($sheet->getCell("F".$row)->getValue() != ''){
                                $discapacitadoM = intval(trim($sheet->getCell("F".$row)->getValue()));
                            }else{
                                $discapacitadoM = 0;
                            }
                            if($sheet->getCell("G".$row)->getValue() != ''){
                                $discapacitadoH = intval(trim($sheet->getCell("G".$row)->getValue()));
                            }else{
                                $discapacitadoH = 0;
                            }
                            if($sheet->getCell("H".$row)->getValue() != ''){
                                $lenguaindM = intval(trim($sheet->getCell("H".$row)->getValue()));
                            }else{
                                $lenguaindM = 0;
                            }
                            if($sheet->getCell("I".$row)->getValue() != ''){
                                $lenguaindH = intval(trim($sheet->getCell("I".$row)->getValue()));
                            }else{
                                $lenguaindH = 0;
                            }
                            if($sheet->getCell("J".$row)->getValue() != ''){
                                $observaciones = intval(trim($sheet->getCell("J".$row)->getValue()));
                            }else{
                                $observaciones = ' ';
                            } 

                            $data['nAvance'] = $avance;
                            $data['nEjercido'] = $montoejercido;            
                            $data['nBeneficiariosM'] = $beneficiarioM;
                            $data['nBeneficiariosH'] = $beneficiarioH;
                            $data['nDiscapacitadosM'] = $discapacitadoM;
                            $data['nDiscapacitadosH'] = $discapacitadoH;
                            $data['nLenguaM'] = $lenguaindM;
                            $data['nLenguaH'] = $lenguaindH;
                            $data['vObservaciones'] = $observaciones;
                            $data['iActivo'] = 1;

                            $table = 'Avance';

                            $idavance  = $this->ms->inserta_registro($table, $data, $con);
                            $n++;
                        }
                    }
                }

                // Finalizar transaccion
                if ($this->ms->terminar_transaccion($con) == true)
                {
                    $response['estatus'] = true;
                    $response['tipo'] = 'success';
                    $response['mensaje'] = "Se ha importado un total $n de registro(s)";
                }
                else
                {
                    $response['tipo'] = 'error';
                    $response['mensaje'] = 'Ha ocurrido un error al intentar guardar los datos';                
                }
                

            }
            else
            {
                $response['mensaje'] = 'El formato del archivo no es válido';
            } 
        }
        else
        {
            $response['mensaje'] = 'Debe subir un archivo válido';
        }
        
        echo json_encode($response);
    }

    //Obtiene el numero de hoja del excel que sera recorrida
    public function obtener_hojaexcel($mes){

        switch($mes){

            case $mes == '01':
            return 0;
            break;

            case $mes == '02':
            return 1;
            break;

            case $mes == '03':
            return 2;
            break;

            case $mes == '04':
            return 3;
            break;

            case $mes == '05':
            return 4;
            break;

            case $mes == '06':
            return 5;
            break;

            case $mes == '07':
            return 6;
            break;

            case $mes == '08':
            return 7;
            break;

            case $mes == '09':
            return 8;
            break;

            case $mes == '10':
            return 9;
            break;

            case $mes == '11':
            return 10;
            break;

            case $mes = '12':
            return 11;
            break;

        }

    }

   

    //Funcion para mostrar la cabecera con los datos principales del entregable
    public function showheader()
    {
        if(isset($_POST['id_detent']) && !empty($_POST['id_detent']))
        {
            echo $this->header_principal($this->input->post('id_detent',TRUE));
        }
    }

    //funcion para crear el header de la pagina principal
    public function header_principal($id_detent)
    {
        $query = $this->ma->datos_mismos_beneficiarios($id_detent);

        $totales = $this->ma->suma_avances_total($id_detent);
        $consulta = $this->ma->mostrar_actividadentregable($id_detent);

        $avance_total = $monto_total = $total_beneficiarios = $total_discapacitados = $total_mayahablantes = 0;

        $avance_total = $totales->total_avance;

        $monto_total = $totales->monto_total;


        $total_beneficiarios = $totales->total_beneficiarios;
        $total_discapacitados = $totales->total_discapacitados;
        $total_mayahablantes = $totales->total_mayahablantes;
        $total_terceraedad = $totales->total_terceraedad;
        $total_adolecentes = $totales->total_adolecentes;

        $gran_total = Decimal($total_beneficiarios + $total_discapacitados + $total_mayahablantes + $total_terceraedad + $total_adolecentes);//

  

        if($query->iMismosBeneficiarios == 1)
        {
            $bene = $this->ma->suma_avances_total($id_detent,$query->dFecha);
            $total_beneficiarios = $bene->total_beneficiarios;
            $total_discapacitados = $bene->total_discapacitados;
            $total_mayahablantes = $bene->total_mayahablantes;
        }
    
        if((int)$consulta->nMetaModificada > 0) $consulta->nMeta = $consulta->nMetaModificada;

        $html = '<div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 mb-3">
                    <div class="row">
                        <div class="col-md-12 mb-9">
                            <h6 class="card-subtitle">Acciones Estrategica</h6>
                            <h4 class="card-title">'.$consulta->vActividad.'<br><br></h4>
                        </div>                            
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-9">
                            <h6 class="card-subtitle">Indicador</h6>
                            <h4 class="card-title">'.$consulta->vEntregable.'</h4>
                        </div>
                    </div>
                        
                    <div class="row">
                        <div class="col-6 col-xs-12">
                            <blockquote>
                                <strong>'.Decimal($avance_total).'/'.Decimal($consulta->nMeta).'</strong>
                                <h6><i class="mdi mdi-flag"></i>&nbsp;Total Avance</h6>
                            </blockquote>
                        </div>
                        <div class="col-6 col-xs-12">
                            <blockquote>
                                <strong>&nbsp;$'.Decimal($monto_total).'</strong>
                                <h6><i class="mdi mdi-cash-multiple"></i>&nbsp;Total ejercido</h6>
                            </blockquote>
                        </div>
                    </div>
                    <blockquote>
                    <div class="row">
                        <div class="col-4 col-xs-12">
                            <blockquote>
                                <strong>'.$gran_total.'</strong>
                                <h6><i class="mdi mdi-account-multiple"></i>&nbsp;Beneficiarios totales </h6>
                            </blockquote>
                        </div>
                        <!--<div class="col-4 col-xs-12">
                            <blockquote>
                                <strong>'.Decimal($total_discapacitados).'</strong>
                                <h6><i class="mdi mdi-wheelchair-accessibility"></i>&nbsp;Personas discapacitadas beneficiadas</h6>
                            </blockquote>
                        </div>
                        <div class="col-4 col-xs-12">
                            <blockquote>
                               <strong>'.Decimal($total_mayahablantes).'</strong>
                                <h6><i class="mdi mdi-message"></i>&nbsp;Población indígena beneficiada</h6>
                            </blockquote>
                        </div>-->
                    </div>
                    </blockquote>
                </div>

                <div class="col-md-2 mb-3 text-right">
                    <button title="Ir al Listado de indicadores" type="button" class="btn waves-effect waves-light btn-outline-info" onclick="regresarmodulo();"><i class="mdi mdi-arrow-left"></i>&nbsp;Regresar</button>
                    <br><br>
                    <button title="Ir al listado del PAT" type="button" class="btn waves-effect waves-light btn-outline-info" onclick="back();"><i class="mdi mdi-home"></i>&nbsp;Ir al PAT</button>
                </div>
            </div>    
        </div>
        </div>';

        return $html;
    }




    function html_tab_trimestes($iddetent)
    {
         $html = '<div class="card-body">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#1tri" role="tab">
                                <h4>
                                <span class="hidden-sm-up"><i class="mdi mdi-calendar-multiple"></i></span><span class="hidden-xs-down"> Trimestre 1</span>
                                </h4>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#2tri" role="tab">
                                <h4>
                                <span class="hidden-sm-up"><i class="mdi mdi-calendar-multiple"></i></span> <span class="hidden-xs-down"> Trimestre 2</span>
                                </h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#3tri" role="tab">
                                <h4>
                                <span class="hidden-sm-up"><i class="mdi mdi-calendar-multiple"></i></span> <span class="hidden-xs-down"> Trimestre 3</span>
                                </h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#4tri" role="tab">
                                <h4>
                                <span class="hidden-sm-up"><i class="mdi mdi-calendar-multiple"></i></span> <span class="hidden-xs-down"> Trimestre 4</span>
                                </h4>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="1tri" role="tabpanel">
                            <div class="p-20">'.$this->html_accordion_meses($iddetent,1).'</div>
                        </div>
                        <div class="tab-pane" id="2tri" role="tabpanel">
                            <div class="p-20">'.$this->html_accordion_meses($iddetent,2).'</div>
                        </div>
                        <div class="tab-pane" id="3tri" role="tabpanel">
                            <div class="p-20">'.$this->html_accordion_meses($iddetent,3).'</div>
                        </div>
                        <div class="tab-pane" id="4tri" role="tabpanel">
                            <div class="p-20">'.$this->html_accordion_meses($iddetent,4).'</div>
                        </div>
                    </div>
                </div>';

        return $html;
    }

  /*  function html_tab_trimestes($iddetent)
    {
         $html = '<div class="card-body">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#4tri" role="tab">
                                <h4>
                                <span class="hidden-sm-up"><i class="mdi mdi-calendar-multiple"></i></span> <span class="hidden-xs-down"> Detalle de Avances</span>
                                </h4>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="4tri" role="tabpanel">
                            <div class="p-20">'.$this->html_accordion_meses($iddetent,4).'</div>
                        </div>
                    </div>
                </div>';

        return $html;
    }
*/
     public function html_accordion_meses($iddetent,$trimestre=1)
    {
        switch($trimestre)
        {
            case $trimestre == 1:
            $meses = array(
            '01'  => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            );
            break;

            case $trimestre == 2:
            $meses = array(
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            );
            break;

            case $trimestre == 3:
            $meses = array(
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            );
            break;

            case $trimestre == 4:
            $meses = array(
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
            );
            break;
        }

        $html = '<div class="accordion" id="meses">';

        foreach($meses as $mes => $value)
        {   
            $texto = $this->html_registros_mes($iddetent,$mes); 

            $html.= '<div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#mes'.$mes.'" aria-expanded="true" aria-controls="mes'.$mes.'" style="cursor:pointer" onclick="motrarAvances(\''.$mes.'\');">
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#mes'.$mes.'" aria-expanded="true" aria-controls="mes'.$mes.'" >
                                    '.$value.'
                                </button>
                            </div>
                            <div class="col-6 text-right" id="divRegistros'.$mes.'">'.$texto.'</div>
                        </div>
                        
                    </div>
                    <div id="mes'.$mes.'" class="collapse" aria-labelledby="headingOne" data-parent="meses">
                        <div class="card-body">
                            <div id="divAvances'.$mes.'"></div>
                        </div>
                    </div>
                </div>';
        }

        $html.= '</div>';

        return $html;
    }

    function html_registros_mes($iddetent,$mes)
    {
        $texto = '';
        $result = $this->ma->registros_por_mes($iddetent,$mes);
        if($result->num_rows() > 0)
        {
            $count = 0;
            $rows = $result->result();
            foreach ($rows as $row)
            {
                $texto.= ($row->iAprobado == 1) ? ' <b>'.$row->num.'</b> <i class="far fa-check-circle text-success" title="Aprobados"></i>':' <b>'.$row->num.'</b> <i class="far fa-clock text-warning" title="Pendientes"></i>';
                $count+= $row->num;
            }
            $texto = '<b>'.$count.'</b> Registro(s):'.$texto;
        }

        return $texto;
    }

    function mostrar_registros_mes()
    {
        $iddetent = $this->input->post('id_detent',true);
        $mes = $this->input->post('mes',true);
        echo $this->html_registros_mes($iddetent,$mes);
    }

    function mostrar_avances()
    {
        $iddetent = $this->input->post('id_detent',true);
        $mes = $this->input->post('mes',true);

        echo $this->html_avances($iddetent,$mes);
    }

   function html_avances($iddetent,$mes)
    {
        $seg = new Class_seguridad();
        $lib = new Class_options();
        $acceso = $seg->tipo_acceso(17,$_SESSION[PREFIJO.'_idusuario']);
        $acceso_rev = $seg->tipo_acceso(29,$_SESSION[PREFIJO.'_idusuario']);
        
        $totales = $this->ma->suma_avances_mensual_desglosado($mes,$iddetent);

        $total_avance = Decimal($totales->total_avance);
        $total_monto = Decimal($totales->monto_total);

        $total_beneficiarios = $totales->total_beneh + $totales->total_benem;
        $total_discapacitados =$totales->total_disch + $totales->total_discm;
        $total_mayahablantes = $totales->total_lengh + $totales->total_lengm;
        $total_terceraedad = $totales->total_tercerah + $totales->total_terceram;
        $total_adolecentes = $totales->total_adoleh + $totales->total_adolem;
        
        $gran_total = $total_beneficiarios + $total_discapacitados + $total_mayahablantes + $total_terceraedad + $total_adolecentes;

        $html = '<div id="totalesMes'.$mes.'">
                    <blockquote>
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <i class="mdi mdi-flag"></i>Avance <br><b>'.$total_avance.'</b>
                            </div>
                            <div class="col-md-6 mb-6">                
                                <i class="mdi mdi-cash-multiple"></i>Ejercido<br><b>$'.$total_monto.'</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-4">                            
                                <i class="mdi mdi-account-multiple"></i>Total beneficiarios asdasd<br>
                                '.$gran_total.'</b>
                            </div>
                            
                        </div>
                    </blockquote>
                </div>';
        $acciones_rev = '';
        if($acceso_rev > 1) $acciones_rev = '<a class="dropdown-item" href="javascript:void(0)" onclick="revisarSeleccionados(\''.$mes.'\',0);">Rechazar</a>';
        if($acceso > 1) $html.= '<div class="row">
                    <div class="col-12 mb-4 text-right"><b><span id="e'.$mes.'">0</span></b> elemento(s) seleccionado(s) <div class="btn-group">
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Acción
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="eliminarSeleccionados(\''.$mes.'\');">Eliminar</a>'.$acciones_rev.'
                            </div>
                        </div>
                    </div>
                </div>';
       
        $tbody = '';
        $avances = $this->ma->obtener_avance_mes($mes,$iddetent);

        $idEntregable = $this->ma->obtenerIDEntregable($iddetent);

        $vFormul = $this->ma->obtenerFormula($idEntregable->iIdEntregable);

        $formulaCalculo = strval($vFormul->vFormula);

        $estructuraFinal = 0;

        $value = array();

        foreach ($avances as $avance)
        {
            $valores = $this->ma->obtenerValoresVA($avance->iIdAvance);
            // Validamos acceso por avance
            if($acceso_rev > 1) $class_read = '';
            elseif($acceso > 1 && $avance->iAprobado == 0 ) $class_read = '';
            else $class_read = 'soloLectura';


            $mun = ($avance->iMunicipio == 0) ? 'N/A':$avance->vMunicipio;

            if($mun != 'N/A')
            {
                $municipio = '<select id="municipios" name="municipios" required class="form-control '.$class_read.'" style="width:150px;">'.$lib->options_tabla('municipios',$avance->iMunicipio).'</select>';
            }
            else
            {
                $municipio = 'N/A <input type="hidden" name="municipios" id="municipios" value="'.$avance->iMunicipio.'">';
            }

            $checkbox = ($class_read == '') ? '<input class="chk'.$mes.'" type="checkbox" onclick="" value="'.$avance->iIdAvance.'" onchange="contarSeleccionados(\''.$mes.'\');">':'';
            $avan = '<input id="avance" class="'.$class_read.' form-control" type="text" value="'.$avance->nAvance.'">';
            $monto ='<input id="monto" class="'.$class_read.' form-control" type="text" value="'.$avance->nEjercido.'">';

            $beneH = '<div class="input-group">
                    <input type="text" style="width:46px" class="'.$class_read.' form-control" id="bnfH" value="'.($avance->nBeneficiariosH + $avance->nBeneficiariosM + $avance->nDiscapacitadosH + $avance->nDiscapacitadosM + $avance->nLenguaH + $avance->nLenguaM + $avance->nTerceraEdadH + $avance->nTerceraEdadM + $avance->nAdolescenteH + $avance->nAdolescenteM).'">
                </div>';

            
           /* $beneM = '<div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i  margin-top:5px;" class="rosa fa-lg mdi mdi-human-female text-primary"></i></span>
                    </div>
                    <input type="text" style="width:46px" class="'.$class_read.' form-control" id="bnfM" value="'.$avance->nBeneficiariosM.'">
                </div>';*/

            
            $discH = '<!--<div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i style="margin-top:5px;" class="fa-lg mdi mdi-human-male text-primary"></i></span>
                    </div>
                    <input type="text" style="width:46px" class="'.$class_read.' form-control" id="discH" value="'.$avance->nDiscapacitadosH.'">
                </div>-->';
            
            $discM = '<!--<div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i style="margin-top:5px;" class="rosa fa-lg mdi mdi-human-female text-primary"></i></span>
                    </div>
                    <input type="text" style="width:46px" class="'.$class_read.' form-control" id="discM" value="'.$avance->nDiscapacitadosM.'">
                </div>-->';
            
            $lenH = '<!--<div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i style="margin-top:5px;" class="fa-lg mdi mdi-human-male text-primary"></i></span>
                    </div>
                    <input type="text" style="width:46px" class="'.$class_read.' form-control" id="lengindH" value="'.$avance->nLenguaH.'">
                </div>-->';
            
            $lenM = '<!--<div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i style="margin-top:5px;" class="rosa fa-lg mdi mdi-human-female text-primary"></i></span>
                    </div>
                    <input type="text" style="width:46px" class="'.$class_read.' form-control" id="lengindM" value="'.$avance->nLenguaM.'">
                </div>-->';
            $botones = '';
            if($class_read == '') $botones = '<!--<button title="Guardar cambios" type="button" class="btn-lectura btn waves-effect waves-light btn-xs btn-info update" onclick="actualizarAvance(this,\''.$mes.'\','.$iddetent.');"><i class="mdi mdi-content-save"></i></button>-->
            <button title="Eliminar" type="button" class="btn-lectura btn waves-effect waves-light btn-xs btn-danger" onclick="eliminarAvance('.$avance->iIdAvance.',\''.$mes.'\');"><i class="mdi mdi-close"></i></button>
            <input type="hidden" name="idavance" id="idavance" value="'.$avance->iIdAvance.'">';

           
            foreach($valores as $v){
                array_push($value, $v->iValor);
            }

            $class = ($avance->iAprobado == 1) ? 'table-success':'';
            $tbody .= '<tr class="'.$class.'">
                        <td>'.$checkbox.'</td>
                        <td>'.$municipio.'</td>
                        <td>'.$avan.'</td>
                        <td>'.$monto.'</td>
                        <td>'.$beneH.'</td>
                        <td>'.$avance->vObservaciones.'</td>
                        <td>'.$botones.'</td>
                    </tr>';
        }

        $html.= '<div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped table-bordered display" style="width:100%" id="grid'.$mes.'">
                            <thead>
                                <tr>';
                                   
                        $html .= '<th with="10px;" style="width:5px !important;">
                                    <div class="text-center">
                                        <input title="Seleccionar todos" class="'.$acceso.'" type="checkbox" id="selAll'.$mes.'" onchange="seleccionarTodos(\''.$mes.'\');">
                                    </div>
                                </th>'; 

                            $html .= '<!--<th>Mes</th>-->
                                    <th width="150px">Municipio</th>
                                    <th id="thavance">Avance</th>
                                    <th id="thmonto">Total ejercido a la fecha de corte</th>
                                    <th id="thbenef" width="150px">Beneficiarios</th>
                                    <th id="thobservaciones">Observaciones</th>
                                    <!--<th id="thdisc" width="150px">Personas <br>con <br>discapacidad</th>
                                    <th th="thhabla" width="150px">Personas <br>de habla <br>indígena</th>
                                    <th width="20px;"></th>-->
                                </tr>
                            </thead>
                            <tbody id="gridbody'.$mes.'">'.$tbody.'</tbody>
                        </table>
                    </div>
                </div>
                <script>
                    $(document).ready(function(){
                        validarAcceso();

                    });
                        
                </script>';

        return $html;
    }
    //Funcion para modificar los avances
    public function actualizar_avance()
    {
        if(isset($_POST['municipio'])) $data['iMunicipio'] = $this->input->post('municipio',TRUE);
        
        $data['nAvance'] = $this->input->post('avance',TRUE);
        $data['nEjercido'] = $this->input->post('monto',TRUE);
        $data['nBeneficiariosH'] = $this->input->post('beneficiariosH',TRUE);
        $data['nBeneficiariosM'] = $this->input->post('beneficiariosM',TRUE);
        $data['nDiscapacitadosH'] = $this->input->post('discapacitadosH',TRUE);
        $data['nDiscapacitadosM'] = $this->input->post('discapacitadosM',TRUE);
        $data['nLenguaH'] = $this->input->post('lenguaindijenaH',TRUE);
        $data['nLenguaM'] = $this->input->post('lenguaindijenaM',TRUE);
        $data['vObservaciones'] = $this->input->post('observaciones',TRUE);
        $data['iIdUsuarioActualiza'] = $_SESSION[PREFIJO.'_idusuario'];
        $data['dFechaActualiza'] = date("Y-m-d h:i:s");

        $where["iIdAvance"] = $this->input->post('idavance',TRUE);
        
        echo ($this->M_seguridad->actualiza_registro('Avance',$where,$data)) ? true:false;

    }

    public function eliminar_avance(){

        if(isset($_POST['id']) && !empty($_POST['id']))
        {
            $where["iIdAvance"] = $this->input->post('id',true);
            $data = array(  'iActivo' => 0,
                            'iIdUsuarioActualiza' => $_SESSION[PREFIJO.'_idusuario'],
                            'dFechaActualiza' => date("Y-m-d h:i:s")
                        );

            echo ($this->M_seguridad->actualiza_registro('Avance',$where,$data)) ? true:false;

            $hoy = date('Y-m-d H:i:s');

            $resp = $this->ma->insertCambio(array(
                'iTipoCambio' => 'Indicador',
                'iAntesCambio' => 'Registro: '.$this->input->post('id',true).' Estatus: 1',
                'iDespuesCambio' => 'Registro Eliminado: '.$this->input->post('id',true).' Estatus: 0',
                'iFechaCambio' => $hoy,
                'iIdUsuario' => $_SESSION[PREFIJO.'_idusuario'],
                'iAprovacion' => 0,
            ));

            $this->ma->eliminarVariableAvance($where["iIdAvance"]);
        }else echo false;
    }

     //Funcion para eliminacion multiple
    public function eliminar_avances()
    {
        $var = $this->input->post('ids',TRUE);
        
        $con = $this->M_seguridad->iniciar_transaccion();

        foreach($var as $valor => $value)
        {
            $where["iIdAvance"] = $value;
            $data = array(  'iActivo' => 0,
                            'iIdUsuarioActualiza' => $_SESSION[PREFIJO.'_idusuario'],
                            'dFechaActualiza' => date("Y-m-d h:i:s")
                        );
            $this->M_seguridad->actualiza_registro('Avance',$where,$data,$con);
            
        }

        echo ($this->M_seguridad->terminar_transaccion($con)) ? true:false;
    }

    //Funcion para aprobación multiple
    public function revisar_avances()
    {
        $var = $this->input->post('ids',TRUE);
        $iAprobado = $this->input->post('rev',true);
        
        $con = $this->M_seguridad->iniciar_transaccion();

        foreach($var as $valor => $value)
        {
            $where["iIdAvance"] = $value;
            $data = array(  'iAprobado' => $iAprobado,
                            'iIdUsuarioAprueba' => $_SESSION[PREFIJO.'_idusuario'],
                            'dFechaAprueba' => date("Y-m-d h:i:s")
                        );
            $this->M_seguridad->actualiza_registro('Avance',$where,$data,$con);
            
        }

        echo ($this->M_seguridad->terminar_transaccion($con)) ? true:false;
    }

}