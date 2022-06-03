<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_admin extends CI_Controller {

    public function __construct()
    {
    	parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->library('Class_options');
        $this->load->model('M_admin');
        $this->load->model('M_seguridad','mseg');

    }

    public function principal_permisos()
    {
        $data['result'] = $this->M_admin->mostrar_permisos()->result();
    	$this->load->view('permisos/principal',$data);
    }

    //Funcion de busquedas
    public function search_permisos()
    {
        $data['result'] = $this->M_admin->mostrar_permisos()->result();
        $this->load->view('permisos/contenido_tabla',$data);
    }

    function capturar_permiso()
    {
        $id = $this->input->post('id',true);
        if($id == 0)
        {
            $data = array(  'iIdPermiso' => 0,
                            'vIdentificador' => '',
                            'vPermiso' => '',
                            'vDescripcion' => '',
                            'iTipo' => 1,
                            'vUrl' => '',
                            'iIdPermisoPadre' => 0,
                            'vClass' => '',
                            'iOrden' => 0,
                            'iActivo' => 1,
                            'iInicial' => 0 );
        }
        else
        {
            $where['iIdPermiso'] = $id;
            $row = $this->M_admin->mostrar_permisos($where)->row();
            
            foreach ($row as $campo => $valor)
            {
                $data[$campo] = $valor;
            }
        }

        $options = new Class_options();
        $data['permisosPadre'] = $options-> options_tabla('PermisoPadre',$data['iIdPermisoPadre']);

        $this->load->view('permisos/capturar',$data);
    }

    function guardar_permiso()
    {
        $where['iIdPermiso'] = $this->input->post('iIdPermiso');
        $resp = array('status' => 'error', 'message' => '','id' => $where['iIdPermiso']);
        $data = array(  'vIdentificador' => $this->input->post('vIdentificador'),
                        'vPermiso' => $this->input->post('vPermiso'),
                        'vDescripcion' => $this->input->post('vDescripcion'),
                        'iTipo' => $this->input->post('iTipo'),
                        'vUrl' => $this->input->post('vUrl'),
                        'iIdPermisoPadre' => $this->input->post('iIdPermisoPadre'),
                        'vClass' => $this->input->post('vClass'),
                        'iOrden' => $this->input->post('iOrden'),
                        'iActivo' => $this->input->post('iActivo'),
                        'iInicial' => $this->input->post('iInicial'));
        
        if($where['iIdPermiso'] > 0)
        {
           if($this->mseg->actualiza_registro('Permiso',$where,$data)) $resp['status'] = 'success';
        }
        else
        {
            //$data['iIdPermiso'] = $this->M_admin->next_permiso_id();
            if( ($resp['id'] = $this->mseg->inserta_registro('Permiso',$data)) > 0)
            {
                $resp['status'] = 'success';
            }
        }

        echo json_encode($resp);
    }
}
?>