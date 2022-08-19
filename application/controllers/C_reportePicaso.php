<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/third_party/Spout/Autoloader/autoload.php";
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Common\Entity\Style\Color;

class C_reportePicaso extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->library('excel');
        $this->load->helper('url');
        $this->load->model('M_reportePicaso', 'mp');
        $this->load->library('Class_seguridad');
        $this->load->library('Class_options');

        //Parametros para la conexion al sistema de finanzas
        $this->urlFinanzas    = "https://picasoplus.queretaro.gob.mx:8080/wsSigo/API/";
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
        $this->load->view('reporte/reportePicaso', $data);
    }

    function getCatalogoPOA($print = true) {
        $url    = $this->urlFinanzas.'proyectos/listado';

        try{
            $ch = curl_init($url);
            $headers = array(
                'Content-Type: application/json',
                'Authorization: Basic '. base64_encode("$this->userFinanzas:$this->passFinanzas")
            );

            $headers = array();
            $headers[] = 'Cache-Control: no-cache';
            $headers[] = 'Content-Type: application/json; charset= utf-8';

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_USERPWD, $this->authFinanzas);
            
            if(!$print)
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            $result = curl_exec($ch);
            curl_close($ch);

            if(!$print)
                return $result;
            
            $datos = json_decode(json_encode($result));
            print_r($datos->datos);
        }catch(Exception $ex){
            print_r($ex);
        }
    }

    function eliminar_tildes($cadena){
    
        //Ahora reemplazamos las letras
        $cadena = str_replace(
            array('á','é','í','ó','ú'),
            array('a','e','i','o','u'),
            $cadena
        );

        $cadena = str_replace(
            array('Á','É','Í','Ó','Ú'),
            array('A','E','I','O','U'),
            $cadena );
    
        return $cadena;
    }

    public function generarrepo()
    {
        ini_set('max_execution_time', 600); // 5 Minutos máximo
        $anio = $this->input->post('anio',true);
        $eje = $this->input->post('selEje',true);
        $dep = $this->input->post('selDep',true)?: '';
        $resp = array('resp' => false, 'error_message' => '', 'url' => '');
        $tabla = array();

        /*$catalogosPOA   = $this->getCatalogoPOA(false);
        $datos = json_decode($catalogosPOA, true);*/



        //iIdDetalleActividad


                $ruta = 'public/reportes/Reporte Picaso.xlsx';
                $writer = WriterEntityFactory::createXLSXWriter();
                $writer->openToFile($ruta);            
                
                $cells = [
                        WriterEntityFactory::createCell('Numero de proyecto'),
                        WriterEntityFactory::createCell('Aprobado'),
                        WriterEntityFactory::createCell('Pagado'),
                        WriterEntityFactory::createCell('Dependencia Ejecutora'),
                        WriterEntityFactory::createCell('Nombre Proyecto'),
                        WriterEntityFactory::createCell('Fecha Aprobacion'),
                    ];
            
        
                // Agregamos la fila de encabezados
                $rowStyle = (new StyleBuilder())
                                ->setFontBold()
                                ->build();
                $singleRow = WriterEntityFactory::createRow($cells,$rowStyle); 
                $writer->addRow($singleRow);

                /*foreach ($datos['datos'] as $value) {
                    $valorFinanzas = $this->eliminar_tildes($value['dependenciaEjecutora']);

                        $cells = [
                            WriterEntityFactory::createCell($value['numeroProyecto']),
                            WriterEntityFactory::createCell($value['aprobado']),
                            WriterEntityFactory::createCell($value['pagado']),
                            WriterEntityFactory::createCell($value['dependenciaEjecutora']),
                            WriterEntityFactory::createCell($value['nombreProyecto']),
                            WriterEntityFactory::createCell($value['fechaAprobacion']),
                        ];
        
        
                        $singleRow = WriterEntityFactory::createRow($cells);
                        $writer->addRow($singleRow);
                    
                }*/

                $writer->close();
            
                $resp['resp'] = true;
                $resp['url'] = base_url().$ruta;    
    
        
        echo json_encode($resp);
    }

}

?>