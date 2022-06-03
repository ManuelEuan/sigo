<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_dependencias extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->model('M_dependencias','md');
        $this->load->model('M_seguridad');
        $this->load->library('Class_options');
    }

    //Muestra la vista principal
    public function index()
    {
        $opt = new Class_options();
        $data['options_eje'] = $opt->options_tabla('eje');
        $data['consulta'] = $this->md->mostrar_dependencias();
    	$this->load->view('dependencias/principal',$data);
    }

    public function buscar()
    {
        $eje = $this->input->post('seleje');
        $key = $this->input->post('key');

        $data['consulta'] = $this->md->mostrar_dependencias($eje,$key);
        $this->load->view('dependencias/contenido_tabla',$data);
        
    }

    //Muestra la pagina para agregar fuentes de financiamiento
    public function create(){
        $opt = new Class_options();
        $datos['options_eje'] = $opt->options_tabla('eje');
        $this->load->view('dependencias/contenido_agregar',$datos);
    }

    //Funcion para insertar
    public function insert(){

        if(isset($_POST['dependencia']) && isset($_POST['nombrecorto'])){
            try {
            
                $data['vDependencia'] = $this->input->post('dependencia',true);
                $data['vNombreCorto'] = $this->input->post('nombrecorto',true);
                $ejes = $this->input->post('ejes',true);
                $data['iActivo']= 1;
                $seg = new M_seguridad();

                $con = $seg->iniciar_transaccion();

                $id = $seg->inserta_registro('Dependencia',$data,$con);
                foreach ($ejes as $value) {
                    $seg->inserta_registro_no_pk('DependenciaEje',array('iIdDependencia' => $id, 'iIdEje' => $value),$con);
                }

                if($seg->terminar_transaccion($con)) echo $id;
                else echo 'Ha ocurrido un error.';
            } catch (Exception $e) {
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            }
            
        }else{
            //Mensaje en caso de que no reciba el POST
            echo "Falla algo";
        }
    }

    //Muestra la pantalla de edicion para el update
    public function edit(){

        if(isset($_POST['id'])){
            $id = $this->input->post('id',true);
            $opt = new Class_options();
            $seleccionado = array();

            $data['consulta'] = $this->md->preparar_update($id);
            $ejes = $this->md->get_ejes($id)->result();
            foreach ($ejes as $row) {
                $seleccionado[] = $row->iIdEje;
            }
            $data['options_eje'] = $opt->options_multiselect('eje',$seleccionado);
            $this->load->view('dependencias/contenido_modificar',$data);

        }else{
            echo "No recibe la variable";
        }
        
    }

    //Funcion para modificar
    public function update(){

        if(isset($_POST['id']) && isset($_POST['dependencia']) && isset($_POST['nombrecorto'])){

            $data = array();

            $id = $this->input->post('id',true);
            $data['vDependencia'] = $this->input->post('dependencia',true);
            $data['vNombreCorto'] = $this->input->post('nombrecorto',true);
            $ejes = $this->input->post('ejes',true);
            
            $seg = new M_seguridad();
            $con = $seg->iniciar_transaccion();
            //Update info
            $where['iIdDependencia'] = $id;
            $aux = $seg->actualiza_registro('Dependencia',$where,$data,$con);

            //Alineación con ejes
            $where2['iIdDependencia'] = $id;
            $aux = $seg->elimina_registro('DependenciaEje',$where2,$con);
            foreach ($ejes as $value) {
                $data = array('iIdEje' => $value, 'iIdDependencia' => $id);
                $id2 = $seg->inserta_registro_no_pk('DependenciaEje',$data,$con);
            }
            //----------------------------------
            if($seg->terminar_transaccion($con)) echo true;
            else echo 'Ha ocurrido un error';

        }else{
            //Mensaje en caso de que no reciba el POST
            echo "Falla algo";
        }
    }

    //Funcion para eliminar
    public function delete(){

        if(isset($_POST['id'])){

            $id = $this->input->post('id',true);
            $resultado = $this->md->eliminar_dependencia($id);

            echo $resultado;

        }else{
            echo "algo salio mal";
        }
    }
}
?>