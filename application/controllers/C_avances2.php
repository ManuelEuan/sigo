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

    }

    //Muestra la vista principal
    public function index(){

        $lib = new Class_options();

        $seg = new Class_seguridad();
        $tipo_acceso = $seg->tipo_acceso(17,$_SESSION[PREFIJO.'_idusuario']);

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

        $data['acceso'] = $acceso;
        $id_detent = $this->input->post('id',TRUE);
        $data['id_detent'] = $id_detent;
        $data['id_detact'] = $this->input->post('id_detact',TRUE);
        $data['contenido_trimestres'] = $this->crear_contenido_tabs($id_detent);
        $data['municipios'] = $lib->options_tabla('municipios');
        $data['consulta'] = $this->ma->mostrar_actividadentregable($id_detent);
        $data['header'] = $this->header_principal($id_detent);
    	$this->load->view('avances/principal',$data);
    }

    //Funcion para insertar
    public function insert(){

        if(isset($_POST['mes_corte']) && isset($_POST['avance']) && isset($_POST['monto']) && isset($_POST['observaciones'])){
            
            $data['iIdDetalleEntregable'] = $this->input->post('id_detent',TRUE);
            $data['nAvance'] = $this->input->post('avance',TRUE);
            $data['nEjercido'] = $this->input->post('monto',TRUE);
            $data['iActivo'] = 1;

            $consulta = $this->ma->mostrar_actividadentregable($data['iIdDetalleEntregable']);

            $anio = $consulta->iAnio;
            $mes = $this->input->post('mes_corte',TRUE);
            $dia = 01;
            $fecha = $anio.'-'.$mes.'-'.$dia;

            $data['dFecha'] = $fecha;
            $data['iIdUsuarioActualiza'] = $_SESSION[PREFIJO.'_idusuario'];
            $data['dFechaActualiza'] = date("Y-m-d h:i:s");
            
            if(isset($_POST['beneficiarioH']) && $_POST['beneficiarioH'] != ''){
                $beneficiarioH = $this->input->post('beneficiarioH',TRUE);
            }else{
                $beneficiarioH = 0;
            }
            if(isset($_POST['beneficiarioM']) && $_POST['beneficiarioM'] != ''){
                $beneficiarioM = $this->input->post('beneficiarioM',TRUE);
            }else{
                $beneficiarioM = 0;
            }
            if(isset($_POST['discapacitadoH']) && $_POST['discapacitadoH'] != '' ){
                $discapacitadoH = $this->input->post('discapacitadoH',TRUE);
            }else{
                $discapacitadoH = 0;
            }
            if(isset($_POST['discapacitadoM']) && $_POST['discapacitadoM'] != ''){
                $discapacitadoM = $this->input->post('discapacitadoM',TRUE);
            }else{
                $discapacitadoM = 0;
            }
            if(isset($_POST['lenguaindH']) && $_POST['lenguaindH'] != ''){
                $lenguaindH = $this->input->post('lenguaindH',TRUE);
            }else{
                $lenguaindH = 0;
            }
            if(isset($_POST['lenguaindM']) && $_POST['lenguaindM'] != ''){
               $lenguaindM = $this->input->post('lenguaindM',TRUE);
            }else{
                $lenguaindM = 0;
            }
            if(isset($_POST['municipio'])){
                $data['iMunicipio'] = $this->input->post('municipio',TRUE);
            }
            if(isset($_POST['observaciones']) && $_POST['observaciones'] != ''){
                $observaciones = $this->input->post('observaciones',TRUE);
            }
            else{
                $observaciones = ' ';
            }
            $data['vObservaciones'] = $observaciones;
            $data['nBeneficiariosH'] = $beneficiarioH;
            $data['nBeneficiariosM'] = $beneficiarioM;
            $data['nDiscapacitadosH'] = $discapacitadoH;
            $data['nDiscapacitadosM'] = $discapacitadoM;
            $data['nLenguaH'] = $lenguaindH;
            $data['nLenguaM'] = $lenguaindM;

            $table = 'Avance';

            if($this->ma->guardado_general($table,$data)){
                echo true;
            }

        }else{
            echo false;
        }
    }
    //Muestra la vista con los tabs
    public function showtabs(){

        if(isset($_POST['id_detent'])){
            $data['tabs_trimestres'] = $this->crear_contenido_tabs($this->input->post('id_detent',TRUE));

            $this->load->view('avances/tabs_trimestres',$data);
        }
    }

    //Muestra el contenido de los tabs
    public function crear_contenido_tabs($id_detent){

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
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#1tri" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-calendar-multiple"></i></span> <span class="hidden-xs-down">1 Trimestre</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#2tri" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-calendar-multiple"></i></span> <span class="hidden-xs-down">2 Trimestre</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#3tri" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-calendar-multiple"></i></span> <span class="hidden-xs-down">3 Trimestre</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#4tri" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-calendar-multiple"></i></span> <span class="hidden-xs-down">4 Trimestre</span></a> </li>
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
    public function tabla_trimestres($trimestre,$id_detent,$acceso){

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

        foreach($meses as $key => $value){

            

            $html.= '<div class="card">
                    <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#mes'.$key.'" aria-expanded="true" aria-controls="mes'.$key.'">
                            '.$value.'
                        </button>
                    </h5>
                    </div>
                    <div id="mes'.$key.'" class="collapse" aria-labelledby="headingOne" data-parent="#meses">
                    <div class="card-body">
                        <div class="form-row">
                            </div>

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

    //Muestra la vista de la tabla
    public function contenido_tabla($key,$value,$id_detent,$acceso){

        $lib = new Class_options();
        $deleteall = "'¿Esta usted seguro? Esta operación eliminara todos los avances seleccionados',enviar_datos,'null','$key','$value','$id_detent','$acceso'";
        $aprobacion = "'¿Esta usted seguro? Una vez aprobados los avances ya no podran ser editados',aprobarAvances,this,event,'$key','$value','$id_detent','$acceso'";
        
        $totales = $this->ma->suma_avances_mensual($key,$id_detent);

        if($totales->total_avance != NULL){
            $total_avance = $totales->total_avance;
        }else{
            $total_avance = 0;
        }
        if($totales->monto_total != NULL){
            $total_monto = $totales->monto_total;
        }else{
            $total_monto = 0;
        }
        if($totales->total_beneficiarios != NULL){
            $total_beneficiarios = $totales->total_beneficiarios;
        }else{
            $total_beneficiarios = 0;
        }

        if($acceso != 'lectesc'){
            $titulocheck = '';
        }else{
            $titulocheck = ' todos';
        }
        

        $html = '<div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label>Cantidad de avance:</label>
                        <label>'.$total_avance.'</label>
                        </div>
                    <div class="col-md-4 mb-3">
                        <label>Presupuesto Ejercido a la Fecha de Corte: </label>
                        <label>$'.$total_monto.'</label>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Cantidad de beneficiarios: </label> 
                        <label>'.$total_beneficiarios.'</label>                                 
                    </div>
                </div>
                <!-- basic table -->
                <div class="row">
                     <div class="col-12">
                         <div class="card">
                         <form id="delete_sel" onsubmit="confirmarAprobacion('.$aprobacion.')" onsubmit="aprobarAvances(this,event);">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered display" style="width:100%" id="grid'.$key.'">
                                        <thead>
                                            <tr>
                                                <th>
                                                <input class="'.$acceso.'" type="checkbox" id="selectallapb'.$key.'" onchange="seleccionaraprobacion('.$key.')"> '.$titulocheck.'
                                                <button disabled="true" id="btnaprobar'.$key.'" type="submit" class="btn waves-effect waves-light btn-xs btn-info '.$acceso.'">Aprobar</button>
                                                </th>
                                                <th class="'.$acceso.'">
                                                <input class="'.$acceso.'" type="checkbox" id="selectalldlt'.$key.'" onchange="seleccionareliminacion('.$key.')"> todos
                                                <button disabled="true" type="button" class="btn waves-effect waves-light btn-xs btn-danger '.$acceso.'" id="btneliminar'.$key.'" onclick="confirmarEliminacion('.$deleteall.')">Eliminar</button>
                                                </th>
                                                <th>Mes</th>
                                                <th>Municipio</th>
                                                <th>Avance</th>
                                                <th>Presupuesto Ejercido a la Fecha de Corte</th>
                                                <th>Beneficiarios Hombres</th>
                                                <th>Beneficiarios Mujeres</th>
                                                <th>Discapacitados Hombres</th>
                                                <th>Discapacitados Mujeres</th>
                                                <th>Lengua indigena H</th>
                                                <th>Lengua indigena M</th>
                                                <th class="'.$acceso.'"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="gridbody'.$key.'">';

                                $avances = $this->ma->obtener_avance_mes($key,$id_detent,$acceso);
                                foreach($avances as $value2){
                                   
                                    $contenido = "'¿Esta usted seguro?',EliminarAvance,'$value2->iIdAvance','$key','$value','$id_detent','$acceso'";

                                    if($value2->iMunicipio != 0){
                                        if($value2->iAprobado != 0){
                                            $municipio = $value2->vMunicipio;
                                        }else{
                                            //$municipio = $value2->vMunicipio;
                                            $municipio = 
                                            '<select id="municipios" name="municipios" required class="form-control" style="width:170px;">
                                            '.$lib->options_tabla('municipios',$value2->iMunicipio);'
                                            </select>';
                                        }
                                        
                                    }else{
                                        $municipio = 'N/A';
                                    }
                                    if($value2->iAprobado != 0){
                                        $checkbox = ' <i class="mdi mdi-checkbox-marked-outline"></i>';
                                        $checkdelete = '';
                                        $mes = '';
                                        $avance = $value2->nAvance;
                                        $monto = $value2->nEjercido;
                                        $beneficiarioH = $value2->nBeneficiariosH;
                                        $beneficiarioM = $value2->nBeneficiariosM;
                                        $discH = $value2->nDiscapacitadosH;
                                        $discM = $value2->nDiscapacitadosM;
                                        $lengindH = $value2->nLenguaH;
                                        $lengindM = $value2->nLenguaM;
                                        $botones = '';
                                        
                                    }elseif($value2->iAprobado == 0){
                                        $checkbox = '
                                            <input class="chkapb'.$key.' " type="checkbox" id="rbt'.$value2->iIdAvance.'" onclick="aprobarcheck('.$value2->iIdAvance.','.$key.')">
                                            <input class="aprobar'.$key.'" type="hidden" name="apb['.$value2->iIdAvance.']" id="apb'.$value2->iIdAvance.'" value="0">';
                                        $checkdelete = '';
                                        $mes ='<input id="avance" type="text" value="'.$value.'" style="width:80px;">';
                                        $avance = '<input id="avance" type="text" value="'.$value2->nAvance.'" style="width:80px;">';
                                        $monto ='<input id="monto" type="text" value="'.$value2->nEjercido.'" style="width:80px;">';
                                        $beneficiarioH ='<input id="bnfH" value="'.$value2->nBeneficiariosH.'" style="width:80px;">';
                                        $beneficiarioM ='<input id="bnfM" value="'.$value2->nBeneficiariosM.'" style="width:80px;">';
                                        $discH = '<input id="discH" value="'.$value2->nDiscapacitadosH.'" style="width:80px;">';
                                        $discM = '<input id="discM" value="'.$value2->nDiscapacitadosM.'" style="width:80px;">';
                                        $lengindH = '<input id="lengindH" value="'.$value2->nLenguaH.'" style="width:80px;">';
                                        $lengindM = '<input id="lengindM" value="'.$value2->nLenguaM.'" style="width:80px;">';
                                        $botones = '<button type="button" class="btn waves-effect waves-light btn-rounded btn-xs btn-warning update"><i class="mdi mdi-pencil"></i></button>';

                                    }

                                    $html.='<tr>
                                        <td>
                                            <div class="custom-control">
                                                '.$checkbox.' 
                                            </div>
                                        </td>
                                        <td class="'.$acceso.'">
                                            <div class="custom-control">
                                                <input class="chkdlt'.$key.' '.$acceso.'" type="checkbox" id="rbt2'.$value2->iIdAvance.'" onclick="eliminarcheck('.$value2->iIdAvance.','.$key.')">
                                                <input class="delete'.$key.'" type="hidden" name="dlt['.$value2->iIdAvance.']" id="dlt'.$value2->iIdAvance.'" value="0">
                                            </div>
                                        </td>

                                        <td>'.$value.'</td>
                                        <td>'.$municipio.'</td>
                                        <td>'.$avance.'</td>
                                        <td>'.$monto.'</td>
                                        <td>'.$beneficiarioH.'</td>
                                        <td>'.$beneficiarioM.'</td>
                                        <td>'.$discH.'</td>
                                        <td>'.$discM.'</td>
                                        <td>'.$lengindH.'</td>
                                        <td>'.$lengindM.'</td>
                                        <td class="'.$acceso.'">'.$botones.'
                                        <button type="button" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger" onclick="confirmarEliminacion('.$contenido.')"><i class="mdi mdi-close"></i></button>
                                        <input type="hidden" name="idavance" id="idavance" value="'.$value2->iIdAvance.'">
                                        </td>';
                                                                                                      
                                }
                                                
                            $html.='</tr>
                                    </form>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        return $html;
    }

    //Muestra la vista de la tabla de avances
    public function showtable(){

        //$value,$key,$id_detent,$acceso
        if(isset($_POST['mm']) && isset($_POST['fecha']) && isset($_POST['id_detent']) && isset($_POST['acceso'])){
            $mm = $this->input->post('mm',TRUE);
            $fecha = $this->input->post('fecha',TRUE);
            $id_detent = $this->input->post('id_detent',TRUE);
            $acceso = $this->input->post('acceso',TRUE);
        }
        $data['tabla_avances'] = $this->contenido_tabla($mm,$fecha,$id_detent,$acceso);
        $this->load->view('avances/tabla_avances',$data);
    }

    //Funcion para eiminar
    public function delete(){

        if(isset($_POST['id'])){

            $id_av = $this->input->post('id',TRUE);

            $where = "iIdAvance =".$id_av;
            $table = 'Avance';
            $data['iActivo'] = 0;
            $data['iIdUsuarioActualiza'] = $_SESSION[PREFIJO.'_idusuario'];
            $data['dFechaActualiza'] = date("Y-m-d h:i:s");

            if($this->ma->eliminacion_generica($where,$table,$data)){
                echo true;
            }
        }else{
            echo false;
        }
    }

    //Funcion para aprobar los avances
    public function aprobar_avances(){

        //Iniciamos la transaccion
        $con = $this->ms->iniciar_transaccion();

        $resultado = false;

        if(isset($_POST['apb'])){

            $var = $this->input->post('apb',TRUE);

            foreach($var as $valor => $value){

                if($value == 1){
                    
                    $where = 'iIdAvance = '.$valor;
                    $data['iAprobado'] = $value;
                    $data['iIdUsuarioAprueba'] = $_SESSION[PREFIJO.'_idusuario'];;
                    $data['dFechaAprueba'] = date("Y-m-d h:i:s");
                    $table = 'Avance';

                    $this->ms->actualiza_registro($table, $where, $data, $con);
                    // Finalizar transaccion
                    if ($this->ms->terminar_transaccion($con) == true) {
                        $resultado = true;
                    }else{
                        $resultado = false;
                    }

                }
            }
            echo $resultado;
        }else{
            echo $resultado;
        }
    }

    //Funcion para eliminacion multiple
    public function eliminar_avances(){

        $var = $this->input->post('dlt',TRUE);
        $result = false;

        foreach($var as $valor => $value){

            if($value == 1){
                
                $where = 'iIdAvance = '.$valor;
                $data['iActivo'] = 0;
                $data['iIdUsuarioActualiza'] = $_SESSION[PREFIJO.'_idusuario'];
                $data['dFechaActualiza'] = date("Y-m-d h:i:s");
                $table = 'Avance';

                if($this->ma->modificacion_general($where,$table,$data)){
                    $result = true;
                }
            }
        }
        echo $result;
    }

    //Funcion para leer el archivo Excel
    public function read_excel(){

        //Iniciamos la transaccion
        $con = $this->ms->iniciar_transaccion();

        $resultado = 3;

        $extensiones = array('xlsx');
        
        $file_name = $_FILES['file']['name'];
        $file_campos = explode(".", $file_name);
        $file_extension = strtolower(end($file_campos));
        if($file_name != ''){
            //valida que la extension del archivo subido corresponda a un excel
            if (in_array($file_extension, $extensiones)==TRUE){

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
                $hojaexcel = $this->obtener_hojaexcel($mes);
            
                $inputFileType = PHPExcel_IOFactory::identify($ruta);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($ruta);
                $sheet = $objPHPExcel->getSheet($hojaexcel); 
                $highestRow = $sheet->getHighestRow(); 
                $highestColumn = $sheet->getHighestColumn();

                //recorre la hoja de excel desde la celda 4
                for ($row = 4; $row < $highestRow; $row++){

                    $municipio = $sheet->getCell("A".$row)->getValue();
                    $consultamunicipio = $this->ma->obtener_idmunicipio($municipio);

                    $data['iMunicipio'] = $consultamunicipio->iIdMunicipio;

                    $avance = $sheet->getCell("B".$row)->getValue();
                    $montoejercido = $sheet->getCell("C".$row)->getValue();               
                    //revisa si hay algun avance agregado 
                    if($avance != '' && $montoejercido != ''){

                        if($sheet->getCell("D".$row)->getValue() != ''){
                            $beneficiarioM = $sheet->getCell("D".$row)->getValue();
                        }else{
                            $beneficiarioM = 0;
                        }
                        if($sheet->getCell("E".$row)->getValue() != ''){
                            $beneficiarioH = $sheet->getCell("E".$row)->getValue();
                        }else{
                            $beneficiarioH = 0;
                        }
                        if($sheet->getCell("F".$row)->getValue() != ''){
                            $discapacitadoM = $sheet->getCell("F".$row)->getValue();
                        }else{
                            $discapacitadoM = 0;
                        }
                        if($sheet->getCell("G".$row)->getValue() != ''){
                            $discapacitadoH = $sheet->getCell("G".$row)->getValue();
                        }else{
                            $discapacitadoH = 0;
                        }
                        if($sheet->getCell("H".$row)->getValue() != ''){
                            $lenguaindM = $sheet->getCell("H".$row)->getValue();
                        }else{
                            $lenguaindM = 0;
                        }
                        if($sheet->getCell("I".$row)->getValue() != ''){
                            $lenguaindH = $sheet->getCell("I".$row)->getValue();
                        }else{
                            $lenguaindH = 0;
                        }
                        if($sheet->getCell("J".$row)->getValue() != ''){
                            $observaciones = $sheet->getCell("J".$row)->getValue();
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

                        $this->ms->inserta_registro($table, $data, $con);
                        // Finalizar transaccion
                        if ($this->ms->terminar_transaccion($con) == true) {
                            $resultado = true;
                        }else{
                            $resultado = 3;
                        }

                    }
                    
                }
                echo $resultado;

            }else{
                echo 2;
            } 
        }else{
            echo false;
        }
             
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

    //Funcion para modificar los avances
    public function update(){

        //$data['mes'] = $_POST['mes'];
        if(isset($_POST['municipio'])){
            $data['iMunicipio'] = $_POST['municipio'];
        }
        $data['nAvance'] = $this->input->post('avance',true);
        $data['nEjercido'] = $this->input->post('monto',true);
        $data['nBeneficiariosH'] = $this->input->post('beneficiariosH',true);
        $data['nBeneficiariosM'] = $this->input->post('beneficiariosM',true);
        $data['nDiscapacitadosH'] = $this->input->post('discapacitadosH',true);
        $data['nDiscapacitadosM'] = $this->input->post('discapacitadosM',true);
        $data['nLenguaH'] = $this->input->post('lenguaindijenaH',true);
        $data['nLenguaM'] = $this->input->post('lenguaindijenaM',true);
        $data['iIdUsuarioActualiza'] = $_SESSION[PREFIJO.'_idusuario'];
        $data['dFechaActualiza'] = date("Y-m-d h:i:s");

        $where = "iIdAvance =".$this->input->post('idavance',true);
        $table = "Avance";

        //var_dump($data);
        
        if($this->ma->modificacion_general($where,$table,$data)){
            echo true;
        }else{
            echo false;
        }

    }

    //Funcion para mostrar la cabecera con los datos principales del entregable
    public function showheader(){

        if(isset($_POST['id_detent'])){
            $data['header'] = $this->header_principal($this->input->post('id_detent',true));

            $this->load->view('avances/header_avances',$data);
        }

    }

    //funcion para crear el header de la pagina principal
    public function header_principal($id_detent){

        $totales = $this->ma->suma_avances_total($id_detent);
        $consulta = $this->ma->mostrar_actividadentregable($id_detent);

        if($totales->total_avance != NULL){
            $avance_total = $totales->total_avance;
        }else{
            $avance_total = 0;
        }
        if($totales->monto_total != NULL){
            $monto_total = $totales->monto_total;
        }else{
            $monto_total = 0;
        }
        if($totales->total_beneficiarios != NULL){
            $total_beneficiarios = $totales->total_beneficiarios;
        }else{
            $total_beneficiarios = 0;
        }

        $html = '<div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 mb-3">
                    <h3 class="card-title">Datos generales</h3>
                    <br><br>
                    <div class="row">
                        <div class="col-md-3 mb-3 text-right">
                            <label>Actividad Estrategica: </label>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h6>'.$consulta->vActividad.'</h6>
                        </div>
                        <div class="col-md-3 mb-3">
                        <i class="mdi mdi-account-plus">'.$avance_total.'</i>
                        <div class="progress">
                            <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" style="width: 40%; height:8px;" role="progressbar">
                            </div>
                        </div>
                            <h6>cantidad de avance </h6>
                        </div>
                        <div class="col-md-3 mb-3">
                        <i class="mdi mdi-cash-multiple">$'.$monto_total.'</i>
                        <div class="progress">
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width: 40%; height:8px;" role="progressbar">
                            </div>
                        </div>
                            <h6>Presupuesto Ejercido a la Fecha de Corte </h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mb-3 text-right">
                            <label>Indicador: </label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h6>'.$consulta->vEntregable.'</h6>
                        </div>
                        <div class="col-md-3 mb-3">
                        <i class="mdi mdi-account-multiple">'.$total_beneficiarios.'</i>
                        <div class="progress">
                            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" style="width: 40%; height:8px;" role="progressbar">
                            </div>
                        </div>
                            <h6>total de beneficiarios </h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <button type="button" class="btn waves-effect waves-light btn-light" onclick="regresarmodulo()"><i class="mdi mdi-arrow-left">Regresar</i></button>
                </div>
            </div>    
        </div>';

        return $html;
    }

    //Crea la seccion de entregables del contenido de la ficha de actividad
    public function generar_entregables_ficha($id_detact){

        $cont = 0;

        $entregables = $this->pat->mostrar_actividadentregables($id_detact);

        $html = '
            <div class="row">
                <div class="col-lg-6">
                    <h4>Entregables</h4>
                </div>
            </div>';

        foreach($entregables as $ent){
            $cont = $cont+1;
            $sumatotal = $this->pat->suma_avances_total($ent->iIdDetalleEntregable);
            if($sumatotal->total_avance != NULL){
                $total = $sumatotal->total_avance;
            }else{
                $total = 0;
            }
            $porcentaje = $total /($ent->nMeta)/100;
            $html.= '
            <div class="card">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-3 m-b-30">
                                <h4 class="card-title">Indicador '.$cont.'</h4>
                                <h6 class="card-subtitle">'.$ent->vEntregable.'</h6>
                            </div>
                            <div class="col-lg-1 m-b-30"></div>
                            <div class="col-lg-3 m-b-30">
                                <h4 class="card-title">Avance</h4>
                                <h6>'.$total.' | '.$porcentaje.'%</h6>
                                <div class="progress">
                                    <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" style="width: 40%; height:8px;" role="progressbar">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 m-b-30"></div>
                            <div class="col-lg-3 m-b-30">
                                <h4 class="card-title">Meta</h4>
                                <h6 class="card-subtitle">'.$ent->nMeta.'</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
        
        return $html;
    }

    //Crea el contenido HTML que se convertira en PDF
    public function CreateHTML_PDF($id_detact){

        $actividad = $this->pat->obtener_informacion_actividad($id_detact);
        $lineasaccion = $this->pat->obtener_alineacion_actividad($id_detact);
        $entregables = $this->pat->mostrar_actividadentregables($id_detact);

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
<body style="height: 100%; width:100%; background-color: #F2F3F4;>
    <form id="form1" runat="server">
        <form id="form1" runat="server">
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
                    <td class="auto-style1" style="font-weight: bolder; text-align: right;">Dependencia: '.$actividad->vDependencia.'</td>
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
            
    $html.='</div>
    </form>
    <div></div>
    <table align="center" class="auto-style9">
        <tr>
            <td class="auto-style10" style="font-weight: bolder; text-align: left;">Entregables<br />
            </td>
        </tr>
    </table>';

    foreach($entregables as $ent){
        $html.= '
        <table align="center" style="width: 95%;  height: 80px; background-color: #FFFFFF;">
        <tr>
            <td class="auto-style4">Entregable 1</td>
            <td class="auto-style2">Avance</td>
            <td class="auto-style2">Meta</td>
        </tr>
        <tr>
            <td class="auto-style4">'.$ent->vEntregable.'</td>
            <td class="auto-style2">
                
            </td>
            <td class="auto-style2">
            '.$ent->nMeta.'
            </td>
        </tr>
        </table>
        <br>';
    }

    $html.='</form>
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

}
