<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/third_party/Spout/Autoloader/autoload.php";
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Common\Entity\Style\Color;

class C_query extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->library('excel');
        $this->load->helper('url');
        $this->load->model('M_query', 'mq');
        $this->load->library('Class_seguridad');
        $this->load->library('Class_options');

        //Parametros para la conexion al sistema de finanzas
        $this->urlFinanzas    = "https://picaso.queretaro.gob.mx:8080/wsSigo/API/";
        $this->userFinanzas   = 'ws_user';
        $this->passFinanzas   = 'usr.sws.951';
        $this->authFinanzas   = $this->userFinanzas.":".$this->passFinanzas;
    }

    public function index()
    {
        $seg = new Class_seguridad();
        $opt = new Class_options();
        $data['all_sec'] = $all_sec = $seg->tipo_acceso(9,$_SESSION[PREFIJO.'_idusuario']);
        $data['all_dep'] = $all_dep = $seg->tipo_acceso(10,$_SESSION[PREFIJO.'_idusuario']);

        $dep = $sec = 0;

        if($all_sec > 0) $data['ejes'] = $opt->options_tabla('eje',"");
        else
        { 
            $sec = $_SESSION[PREFIJO.'_ideje'];
            $where['iIdEje'] = $_SESSION[PREFIJO.'_ideje'];
        }

        if($all_dep > 0)
        { 
            $data['dependencias'] = (isset($where['iIdEje'])) ? $opt->options_tabla('dependencia',"",$where):$opt->options_tabla('dependencia',"",'iActivo = 3');
        }
        else
        {
            $dep = $_SESSION[PREFIJO.'_iddependencia'];
        }
        $this->load->view('vquery/index', $data);
    }

    public function ejecutarQuery(){
        $mensaje = $this->input->post('message',true);
        $string = stripslashes($mensaje);
        //$res1 = "'".$res."'";
        $resultado = $this->mq->ejecutarQuery($string);

        echo var_dump($resultado);
    }
}
?>