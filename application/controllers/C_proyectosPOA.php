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
}

?> 