<?php

//defined('BASEPATH') OR exit('No direct script access allowed');
class C_notis extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
       // session_start();
        $this->load->helper('url');
        $this->load->model('M_notis','notis');
       // $this->load->library('Class_options');
        //$this->load->library('Class_seguridad');
    }

    public function agregarNoti()
    {
        //$sesion = $_SESSION[PREFIJO.'_iddependencia'];
    
            $data = array(
                'comment_subject' => $this->input->post('comment_subject',true),
                'comment_text' => $this->input->post('comment_text',true),
                'comment_status' => $this->input->post('comment_status',true)
            );

            $Id_comment = $this->notis->agregarNoti($data);
            //$data1['iIdActividad'] = $this->pat->agregarAct($data);
            //$this->pat->agregarDetAct($data1);
            
        
          
    }

    public function Prueba(){
        try{
            $this->notis->PruebaX();
            
        }
        catch(Exception $e){
            var_dump($e);
        }
        
    }


}
?>