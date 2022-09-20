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


        $antes = json_decode($cambios->iAntesCambio);
        $despues = json_decode($cambios->iDespuesCambio);
        $result ='';
        $arrayAntes = array();

        foreach($antes as $value){
            array_push($arrayAntes, $value);
        }

        switch ($tipo) {
            case 'Indicador':
                # code...
                foreach($despues as $key => $value ){

                    // $result =$antes[$key];
                  
                    if(!in_array($value, $arrayAntes)){
                        $result .= '
                            <tr>
                            <td ><p >'.$key.'</p></td>
                            <td ><p style="background-color: rgba(46,160,67,0.4);">'.$value.'</p></td>
                            <td><p style="background-color: rgba(248,81,73,0.4);">'.$antes->$key.'</p></td>
                            </tr>';
                    }else{
                        $result .= '
                           <tr> 
                           <td ><p >'.$key.'</p></td>
                           <td>'.$value.'</td>
                           <td>'.$antes->$key.'</td></tr>';

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

}