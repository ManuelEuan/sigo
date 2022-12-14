<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class C_logs extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('funciones');
        $this->load->model('M_logs', 'ml');
        $this->load->model('M_pat', 'mpat');
        $this->load->model('M_seguridad', 'mseg');
        $this->load->model('M_entregables','me');
        $this->load->library('Class_seguridad');
        $this->load->library('Class_options');
    }
    public function index(){
        $data['logs'] = $this->ml->obtenerLogs();

        $this->load->view('Logs/index', $data);
    }

    public function obtenerCambios(){
        $id = $this->input->post('id',true);
        //$cambios = $this->ml->obtenerCambios();
    }

    public function detalle(){
        $id = $this->input->post('id',true);
        $cambios = $this->ml->obtenerCambios($id);

        /**
         * Aqui va todo
         */
        $tipo = $cambios->iTipoCambio;
        if($tipo == 'Indicador'){
            $datosAntes = $this->ml->obtenerAntesIndicador($cambios->iIdCambio);
        }
        if($tipo == 'Acción'){
            $datosAntes = $this->ml->obtenerAntesAccion($cambios->iIdCambio);
        }
        $antes = json_decode($cambios->iAntesCambio);
        $despues = json_decode($cambios->iDespuesCambio);
        $result ='';
        $arrayAntes = array();
        $arraySoloValores = array();
        $arraySoloLlaves = array();
        $valorFinal = array();

        if($tipo == 'Acción'){

            foreach($despues as $key => $d){
                switch ($key) {
                    case 'iIdDependencia':
                        if(!empty($despues->iIdDependencia)){
                            $dep = $this->ml->obtenerDependencia($despues->iIdDependencia);
                            array_push($arraySoloValores, $dep[0]->vDependencia);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
    
                    case 'iIdProyectoPrioritario':
                        if(!empty($despues->iIdProyectoPrioritario)){
                            $proypri = $this->ml->obtenerProyPri($despues->iIdProyectoPrioritario);
                            array_push($arraySoloValores, $proypri[0]->vProyectoPrioritario);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
    
                    case 'vResumenNarrativo':
                        if(!empty($despues->vResumenNarrativo) && $despues->vResumenNarrativo != '.'){
                            $vRN = $this->ml->obtenerResumenNarrativo($despues->vResumenNarrativo);
                            array_push($arraySoloValores, $vRN[0]->vNombreResumenNarrativo);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
    
                    case 'iIdProgramaPresupuestario':
                        if(!empty($despues->iIdProgramaPresupuestario)){
                            $progpres = $this->ml->obtenerProgramaPresu($despues->iIdProgramaPresupuestario);
                            array_push($arraySoloValores, $progpres[0]->vProgramaPresupuestario);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
    
                    case 'iIdNivelMIR':
                        if(!empty($despues->iIdNivelMIR)){
                            $mir = $this->ml->obtenerMIR($despues->iIdNivelMIR);
                            array_push($arraySoloValores, $mir[0]->vNivelMIR);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
    
                    case 'iideje':
                        if(!empty($despues->iideje)){
                            $eje = $this->ml->obtenerEje($despues->iideje);
                            array_push($arraySoloValores, $eje[0]->vEje);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
    
                    case 'iReto':
                        if(!empty($despues->iReto)){
                            $reto = $this->ml->obtenerReto($despues->iReto);
                            array_push($arraySoloValores, $reto[0]->vDescripcion);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
                        
                    case 'vResponsable':
                        if(!empty($despues->vResponsable) && $despues->vResponsable != '.'){
                            $arearesp = $this->ml->obtenerAreaResp($despues->vResponsable);
                            array_push($arraySoloValores, $arearesp[0]->vAreaResponsable);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
    
                    case 'iODS':
                        if(!empty($despues->iODS)){
                            $ods = $this->ml->obternerODS($despues->iODS);
                            array_push($arraySoloValores, $ods[0]->vOds);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
                    
                    default:
                        array_push($arraySoloValores, $d);
                        break;
                }
            }

            foreach($datosAntes[0] as $key => $k){
                array_push($arraySoloLlaves, $key);
            }
    
            foreach($arraySoloLlaves as $key => $llave){
                $valorFinal[$llave] = $arraySoloValores[$key];
            }
        }

        if($tipo == 'Indicador'){

            foreach($despues as $key => $d){
                switch ($key) {
                    case 'iIdPeriodicidad':
                        if(!empty($despues->iIdPeriodicidad)){
                            $rsp = $this->ml->obtenerPeriodicidad($despues->iIdPeriodicidad);
                            array_push($arraySoloValores, $rsp[0]->vPeriodicidad);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;

                    case 'iIdFormaInd':
                        if(!empty($despues->iIdFormaInd)){
                            $rsp = $this->ml->obtenerFormaInd($despues->iIdFormaInd);
                            array_push($arraySoloValores, $rsp[0]->vDescripcion);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;

                    case 'iIdDimensionInd':
                        if(!empty($despues->iIdDimensionInd)){
                            $rsp = $this->ml->obtenerDimenInd($despues->iIdDimensionInd);
                            array_push($arraySoloValores, $rsp[0]->vDescripcion);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
                    
                    case 'iIdUnidadMedida':
                        if(!empty($despues->iIdUnidadMedida)){
                            $rsp = $this->ml->obtenerUnidadMedida($despues->iIdUnidadMedida);
                            array_push($arraySoloValores, $rsp[0]->vUnidadMedida);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
                    case 'iAcumulativo':
                        if(!empty($despues->iAcumulativo) && $despues->iAcumulativo == 1){
                            array_push($arraySoloValores, 'Acumulativo');
                        }elseif(!empty($despues->iAcumulativo) && $despues->iAcumulativo == 2){
                            array_push($arraySoloValores, 'Puntual');
                        }
                        else{
                            array_push($arraySoloValores, $d);
                        }
                        break;

                    default:
                        array_push($arraySoloValores, $d);
                        break;
                }
            }
            foreach($datosAntes[0] as $key => $k){
                array_push($arraySoloLlaves, $key);
            }
    
            foreach($arraySoloLlaves as $key => $llave){
                $valorFinal[$llave] = $arraySoloValores[$key];
            }
            
        }

        switch ($tipo) {
            case 'Indicador':
                # code...
                foreach($datosAntes[0] as $key => $value ){

                    // $result =$antes[$key];
                
                    if($value != $valorFinal[$key]){
                        $result .= '
                                <tr>
                                <td ><p >'.$key.'</p></td>
                                <td ><p style="background-color: rgba(46,160,67,0.4);">'.$value.'</p></td>
                                <td><p style="background-color: rgba(248,81,73,0.4);">'.$valorFinal[$key].'</p></td>
                                </tr>';
                    }else{
                        $result .= '
                            <tr> 
                            <td ><p >'.$key.'</p></td>
                            <td>'.$value.'</td>
                            <td>'.$valorFinal[$key].'</td></tr>';
                    }
                    // var_dump($despues);
                    // var_dump($antes);

                }
                break;
            
            case 'Acción':
                # code...

                foreach($datosAntes[0] as $key => $value ){

                    // $result =$antes[$key];
                
                    if($value != $valorFinal[$key]){
                        $result .= '
                                <tr>
                                <td ><p >'.$key.'</p></td>
                                <td ><p style="background-color: rgba(46,160,67,0.4);">'.$value.'</p></td>
                                <td><p style="background-color: rgba(248,81,73,0.4);">'.$valorFinal[$key].'</p></td>
                                </tr>';
                    }else{
                        $result .= '
                            <tr> 
                            <td ><p >'.$key.'</p></td>
                            <td>'.$value.'</td>
                            <td>'.$valorFinal[$key].'</td></tr>';
                    }
                    // var_dump($despues);
                    // var_dump($antes);

                }

                break;
            
            default:
                # code...
                break;
        }

        $data['cambios'] = $result;
        $this->load->view('Logs/detalle', $data);
    }
    public function aprobarCambios(){
        $id = $this->input->post('iIdAccion',true);
        $iIdCambio = $this->input->post('iIdCambio',true);
        $cambios = $this->ml->obtenerCambios($id);

        /**
         * Aqui va todo
         */
        $tipo = $cambios->iTipoCambio;


        $antes = json_decode($cambios->iAntesCambio);
        $despues = json_decode($cambios->iDespuesCambio);
        $result ='';
        $arrayAntes = array();
        $data = array();
        $dataLog = array();

        foreach($antes as $value){
            array_push($arrayAntes, $value);
        }

        switch ($tipo) {
            case 'Indicador':
                # code...
                foreach($despues as $key => $value ){

                    // $result =$antes[$key];
                  
                    if($value != $antes->$key){
                        $data[$key] = $value;
                        $where = "iIdEntregable =".$iIdCambio;
                        $table = 'Entregable';

                        // if($this->me->modificacion_general($where,$table,$data))
                          
                        $this->me->modificacion_general($where,$table,$data);
                        $dataLog['iAprovacion'] = 1;
                        $this->ml->updateLog($id, $dataLog);
                    }else{
                        // $result .= '
                        //    <tr> 
                        //    <td ><p >'.$key.'</p></td>
                        //    <td>'.$value.'</td>
                        //    <td>'.$antes->$key.'</td></tr>';

                    }
                    // var_dump($despues);
                    // var_dump($antes);

                }

                
                
                break;
            
            case 'Acción':
                # code...
                foreach($despues as $key => $value ){

                    // $result =$antes[$key];
                  
                    if($value != $antes->$key){
                        $data[$key] = $value;
                        $where['iIdActividad'] = $iIdCambio;
                     
                        
                        $this->mseg->actualiza_registro('Actividad', $where, $data, $con);
                        $dataLog['iAprovacion'] = 1;
                        $this->ml->updateLog($id, $dataLog);


                    }else{
                        // $result .= '
                        //    <tr> 
                        //    <td ><p >'.$key.'</p></td>
                        //    <td>'.$value.'</td>
                        //    <td>'.$antes->$key.'</td></tr>';

                    }
                    // var_dump($despues);
                    // var_dump($antes);

                }

                
                
                break;
            
            default:
                # code...
                break;
        }
        // $data['cambios'] = $result;
        echo json_encode($data);
        // $this->load->view('Logs/detalle', $data);
    }

}