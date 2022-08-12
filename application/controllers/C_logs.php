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
}