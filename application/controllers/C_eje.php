<?php 

class C_eje extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('funciones');
        $this->load->model('M_eje', 'eje');

    }

    public function index(){
        $this->load->view('ejes/principal');
    }

    public function add(){

        $data['retos'] = $this->eje->obtenerRetos();

        $this->load->view('ejes/crear_eje', $data);
    }

}

?>