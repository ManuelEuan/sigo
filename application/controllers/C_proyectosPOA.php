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
        $this->load->library('Class_seguridad');
        $this->load->library('Class_options');
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