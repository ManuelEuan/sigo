<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class C_proyectosPOA extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('funciones');
        $this->load->model('M_proyectosPOA', 'poa');
        $this->load->model('M_pat', 'pat');

        $this->load->library('Class_seguridad');
        $this->load->library('Class_options');
          //Parametros para la conexion al sistema de finanzas
          $this->urlFinanzas    = "https://picaso.queretaro.gob.mx:8080/wsSigo/API/";
          $this->userFinanzas   = 'ws_user';
          $this->passFinanzas   = 'usr.sws.951';
          $this->authFinanzas   = $this->userFinanzas.":".$this->passFinanzas;
    }
    public function index(){
        $data['proyectos'] = $this->poa->obtenerProyectosPOAS();
       

        $this->load->view('proyectosPOA/index', $data);
    }

    function validarListaPOA(){
        $catalogosPOA       = $this->poa->obtenerProyectosPOAS();
        $datos              = $catalogosPOA;
        $arrayResultados    = array();
        $arrayidElegido     = array();

        $respuestaElegidosID = $this->poa->obtenerSeleccionados();

        foreach ($respuestaElegidosID as $key => $value) {
            array_push($arrayidElegido, $value->vcattipoactividad);
        }

        foreach ($datos as $key => $value) {
            if(!in_array($value->numeroProyecto, $arrayidElegido)){
                array_push($arrayResultados,
                ['numeroProyecto'   => $value->numeroProyecto,
                'aprobado'          => $value->aprobado,
                'pagado'            => $value->pagado,
                'dependenciaEjecutora' => $value->dependenciaEjecutora,
                'nombreProyecto'    => $value->nombreProyecto,
                'fechaAprobacion'   => $value->fechaAprobacion]);
            }
        }

        return $arrayResultados;
    }
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

    function traerProyectoPicaso(){
        $catalogosPOA       = $this->getCatalogoPOA(false);
        $datos              = json_decode($catalogosPOA, true);
        $arrayElegidos     = array();
        $respuestaElegidos = $this->pat->obtenerProyectos();

        foreach ($respuestaElegidos as $key => $value) {
            array_push($arrayElegidos, $value->numeroProyecto);
        }

        // $data['prueba']= $datos['datos'] ;
        foreach ($datos['datos'] as $key => $value) {
            //aqui va el insert
            if(!in_array($value['numeroProyecto'], $arrayElegidos)){
                $arrayElegidos[] = array(
                    "0" => $value['numeroProyecto'],
                    "1" => $value['aprobado'],
                    "2" => $value['pagado'],
                    "3" => $value['dependenciaEjecutora'],
                    "4" => $value['nombreProyecto'],
                    "5" => $value['fechaAprobacion'],
                );
                
                
                
            }else{
                
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($arrayElegidos), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($arrayElegidos), //enviamos el total registros a visualizar
            "aaData" => $arrayElegidos
        );
        echo json_encode($results);
    }

    function filtrar(){
        if(isset($_GET['valor'])){
            if($this->input->get('valor',TRUE) == 'todos'){
                $resultado = $this->poa->obtenerProyectosPOAS();
                $data = Array();
                foreach ($resultado as $key => $value) {
                    $data[] = array(
                        '0' => $value->numeroProyecto,
                        '1' => $value->aprobado,
                        '2' => $value->pagado,
                        '3' => $value->dependenciaEjecutora,
                        '4' => $value->nombreProyecto,
                        '5' => $value->fechaAprobacion
                    );
                }
            }
            if($this->input->get('valor',TRUE) == 'noguardado'){
                $resultado = $this->validarListaPOA();
                $data = Array();
                foreach ($resultado as $key => $value) {
                    $data[] = array(
                        '0' => $value['numeroProyecto'],
                        '1' => $value['aprobado'],
                        '2' => $value['pagado'],
                        '3' => $value['dependenciaEjecutora'],
                        '4' => $value['nombreProyecto'],
                        '5' => $value['fechaAprobacion']
                    );
                }
            }
            
            $results = array(
                "sEcho"=>1, //Información para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                "aaData"=>$data);
            
            echo json_encode($results);
            
        }
        
    }
}

?> 