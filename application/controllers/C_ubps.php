<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_ubps extends CI_Controller {
	public function __construct(){

        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->model('M_ubps', 'mu');
        $this->load->library('Class_options');
    }

    public function index(){
        $data['consulta'] = $this->mu->mostrar_ubps();
    	$this->load->view('UBPs/inicio_ubp', $data);
    }

    public function agregar(){
        $lib = new Class_options();
        $data1['tipo_ubps'] = $lib->options_tabla('tipo_ubps');
        $data1['dependencias'] = $lib->options_tabla('dependencias');
        $data1['PP'] = $lib->options_tabla('programa_presupuestario');
        $this->load->view('UBPs/agregar_ubp', $data1);
        //echo '<pre>';
        //print_r($data1['tUBP']);
        //echo '</pre>';        
    }

    public function modificar($id){
        $data1['tUBP'] = $this->mu->mostrar_Tubps();
        $data1['Dep'] = $this->mu->mostrar_dependencia();
        $data1['PP'] = $this->mu->mostrar_PP();
        //$this->load->view('UBPs/editar_ubp', $data1);
    }

    public function edit(){
        if(isset($_POST['id'])){

            $lib = new Class_options();
            
            $id = $this->input->post('id',true);

            $data2['consulta'] = $this->mu->preparar_update($id);
            $data2['tipo_ubps'] = $lib->options_tabla('tipo_ubps');
            $data2['dependencias'] = $lib->options_tabla('dependencias');
            $data2['PP'] = $lib->options_tabla('programa_presupuestario');
            $this->load->view('UBPs/editar_ubp', $data2);
        }
    }

    public function regresar(){
        $data['consulta'] = $this->mu->mostrar_ubps();
    	$this->load->view('UBPs/vTabla', $data);
    }

    public function insertar(){
        
        if(isset($_POST['Cubp']) && isset($_POST['NombUbp']) && isset($_POST['annio']) && isset($_POST['TipoUBP']) && isset($_POST['Depen']) && isset($_POST['ProgP'])){
            $data = array(
                'vClave'=>$this->input->post('Cubp',true),
                'vUBP'=>$this->input->post('NombUbp',true),
                'iAnio'=>$this->input->post('annio',true),
                'iIdTipoUbp'=>$this->input->post('TipoUBP',true),
                'iIdDependencia'=>$this->input->post('Depen',true),
                'iIdProgramaPresupuestario'=>$this->input->post('ProgP',true)
            );
            //print_r($data);
            $resultado = $this->mu->insertarUBP($data);
            //print_r($resultado);
            echo $resultado;

         
        }else{
            echo "Algo salió mal";
        }
    }

    public function actualizar(){
        if(isset($_POST['id']) && isset($_POST['Cubp']) && isset($_POST['NombUbp']) && isset($_POST['annio']) && isset($_POST['TipoUBP']) && isset($_POST['Depen']) && isset($_POST['ProgP'])){    
            
            $id = $this->input->post('id',true);

            $data = array(
                'vClave'=>$this->input->post('Cubp'),
                'vUBP'=>$this->input->post('NombUbp'),
                'iAnio'=>$this->input->post('annio'),
                'iIdTipoUbp'=>$this->input->post('TipoUBP'),
                'iIdDependencia'=>$this->input->post('Depen'),
                'iIdProgramaPresupuestario'=>$this->input->post('ProgP')
            );

            $resul = $this->mu->modificarUBP($id, $data);
            echo $resul;
        }else {
            echo "No funcionó";
        }
    }

    public function eliminar(){
        $key = $this->input->post('key',true);
        echo $this->mu->eliminarUBP($key);
    }

    public function gettable(){
        $year = $keyword = null;
        if(isset($_POST['keyword']) && !empty($_POST['keyword'])){
            $keyword = $this->input->post('keyword',true);
        }
        
        if(isset($_POST['year']) && !empty($_POST['year'])){
            $year = $this->input->post('year',true);
        }
       
        $data['consulta'] = $this->mu->mostrar_ubps($keyword, $year);
        //echo $_SESSION['sql'];
        //print_r($data['consulta']);
        $this->load->view('UBPs/vTabla', $data);
    }

}