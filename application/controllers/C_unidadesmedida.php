<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_unidadesmedida extends CI_Controller {
	public function __construct(){
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->model('M_unidadesmedida', 'mum');
    }

    public function index(){
        $data['consulta'] = $this->mum->mostrar_um();
    	$this->load->view('UnidadesDeMedidas/inicio_UM', $data);
    }

    public function cargar(){
        $data['modal'] = isset($_POST['modal']);
        $this->load->view('UnidadesDeMedidas/agregar_um',$data);      
    }

    public function regresar(){
        $data['consulta'] = $this->mum->mostrar_um();
    	$this->load->view('UnidadesDeMedidas/vTabla', $data);
    }

    public function insertar(){
        
        if(isset($_POST['NombUm'])){
            $data = array(
                'vUnidadMedida'=>$this->input->post('NombUm',true)
            );
            
            $resultado = $this->mum->insertarUM($data);
            echo $resultado;

         
        }else{
            echo "Algo salió mal";
        }
    }

    public function edit(){
        if(isset($_POST['id'])){
            $id = $this->input->post('id',true);
            
            $data2['consulta'] = $this->mum->preparar_update($id);
            $this->load->view('UnidadesDeMedidas/editar_um', $data2);
        }
    }

    public function actualizar(){
        if(isset($_POST['id']) && isset($_POST['NombUm'])){    
            
            $id = $this->input->post('id',true);

            $data = array(
                'vUnidadMedida'=>$this->input->post('NombUm',true)
            );

            $resul = $this->mum->modificarUM($id, $data);
            echo $resul;
        }else {
            echo "No funcionó";
        }
    }

    public function eliminar(){
        $key = $this->input->post('key',true);
        echo $this->mum->eliminarUM($key);
    }

    public function gettable(){
        $keyword = null;
        if(isset($_POST['keyword']) && !empty($_POST['keyword'])){
            $keyword = $this->input->post('keyword',true);
        }
       
        $data['consulta'] = $this->mum->mostrar_um($keyword);
        $this->load->view('UnidadesDeMedidas/vTabla', $data);
    }

    public function genera_options()
    {
        $this->load->library('Class_options');
        $opts = new Class_options();

        $selected = (isset($_POST['selected'])) ? $this->input->post('selected'):0; 

        echo $opts->options_tabla('unidades_medida',$selected);
    }
}