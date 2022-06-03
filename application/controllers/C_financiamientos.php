<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_financiamientos extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->model('M_financiamientos','mf');
        //$this->load->library('Class_options');
        //$this->load->model('M_seguridad','ms');
    }

    //Muestra la vista principal
    public function index()
    {
        $data['consulta'] = $this->mf->mostrar_financiamientos();      
        $this->load->view('financiamientos/principal',$data);
        //print_r($data['consulta']);
    }

    //Muestra la pagina para agregar fuentes de financiamiento
    public function create(){

        $this->load->view('financiamientos/contenido_agregar');
    }

    //Funcion para insertar
    public function insert(){

        if(isset($_POST['clave']) && isset($_POST['anio']) && isset($_POST['financiamiento'])){

            $data = array();

            $data['vClave'] = $this->input->post('clave',true);
            $data['vFinanciamiento'] = $this->input->post('financiamiento',true);
            $data['iAnio'] = $this->input->post('anio',true);
            $data['iActivo']= 1;

            $resultado = $this->mf->guardar_financiamiento($data);

            echo $resultado;
            
        }else{
            //Mensaje en caso de que no reciba el POST
            echo "Falla algo";
        }
    }

    //Muestra la pantalla de edicion para el update
    public function edit(){

        if(isset($_POST['id'])){

            $id = $this->input->post('id',true);
            $data['consulta'] = $this->mf->preparar_update($id);      
            $this->load->view('financiamientos/contenido_modificar',$data);

        }else{
            echo "No recibe la variable";
        }
        
    }

    //Funcion para modificar
    public function update(){

        if(isset($_POST['id']) && isset($_POST['clave']) && isset($_POST['anio']) && isset($_POST['financiamiento'])){

            $data = array();

            $id = $this->input->post('id',true);
            $data['vClave'] = $this->input->post('clave',true);
            $data['vFinanciamiento'] = $this->input->post('financiamiento',true);
            $data['iAnio'] = $this->input->post('anio',true);
            $data['iActivo']= 1;

            $resultado = $this->mf->modificar_financiamiento($id,$data);

            echo $resultado;

        }else{
            //Mensaje en caso de que no reciba el POST
            echo "Falla algo";
        }
    }

    //Funcion para eliminar
    public function eliminar(){

        if(isset($_POST['id'])){

            $id = $this->input->post('id',true);

            $resultado = $this->mf->eliminar_financiamiento($id);

            echo $resultado;

        }else{
            echo "algo salio mal";
        }
    }

    //Funcion de busquedas
    public function search(){

        $anio = $fuente = null;
        if(isset($_POST['fuente']) && !empty($_POST['fuente'])){

            $fuente = $this->input->post('fuente',true);
        }
        
        if(isset($_POST['anio']) && !empty($_POST['anio'])){

            $anio = $this->input->post('anio',true);
        }
       
        $data['consulta'] = $this->mf->mostrar_financiamientos($fuente, $anio);
        $this->load->view('financiamientos/contenido_tabla',$data);
    }

}
?>