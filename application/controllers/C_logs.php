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
        foreach($despues as $d){
            array_push($arraySoloValores, $d);
        }
        foreach($datosAntes[0] as $key => $k){
            array_push($arraySoloLlaves, $key);
        }

        foreach($arraySoloLlaves as $key => $llave){
            $valorFinal[$llave] = $arraySoloValores[$key];
        }

        //echo json_encode($valorFinal);

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